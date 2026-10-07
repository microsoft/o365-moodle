<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Ad-hoc task to sync Moodle course role assignment changes to Microsoft Groups.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2022 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

use core\task\adhoc_task;
use core\task\manager;
use local_o365\feature\coursesync\main;
use local_o365\feature\coursesync\utils as coursesyncutils;
use local_o365\utils;
use Throwable;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/o365/lib.php');

/**
 * Ad-hoc task to sync Moodle course role assignment changes to Microsoft Groups.
 *
 * The task reconciles owners and members for every sync-enabled course that has a connected group. Because that
 * can be a large number of courses and each one needs several Microsoft Graph calls, the work is processed in
 * bounded batches: each run handles up to "courses_per_task" courses and, if more remain, queues a follow-up task
 * with the outstanding course IDs. This keeps individual runs short enough to finish within the cron time limit
 * and, on failure, to be retried without starving the courses at the end of the list.
 *
 * @package     local_o365
 * @subpackage  local_o365\task
 */
class groupmembershipsync extends adhoc_task {
    /**
     * Default number of courses to process in a single run when the "courses_per_task" setting is not usable.
     */
    const DEFAULT_BATCH_SIZE = 20;

    /**
     * Maximum number of times a course that keeps failing is carried over into a follow-up task before it is
     * given up on (until the next event re-triggers a sync). Prevents a permanently broken course from making
     * the follow-up chain run forever.
     */
    const MAX_COURSE_ATTEMPTS = 3;

    /**
     * Return a human-readable name for this task (shown in the admin task log UI).
     *
     * @return string
     */
    public function get_name(): string {
        return get_string('task_groupmembershipsync', 'local_o365');
    }

    /**
     * Check if the course sync feature is enabled, get the courses that still need processing, and resync owners
     * and members for a bounded batch of them.
     *
     * @return false|void
     */
    public function execute() {
        // If the sync direction is Teams to Moodle, we don't want to sync the course membership. Exiting.
        $courseusersyncdirection = get_config('local_o365', 'courseusersyncdirection');
        if ($courseusersyncdirection == COURSE_USER_SYNC_DIRECTION_TEAMS_TO_MOODLE) {
            mtrace('Sync direction is Teams to Moodle. Exiting.');
            return false;
        }

        if (utils::is_connected() !== true || coursesyncutils::is_enabled() !== true) {
            return false;
        }

        $graphclient = coursesyncutils::get_unified_api();
        if (!$graphclient) {
            return false;
        }

        // Raise limits: a batch still involves several Graph calls per course.
        raise_memory_limit(MEMORY_HUGE);
        @set_time_limit(0);

        $courseids = $this->get_courses_to_process();
        if (empty($courseids)) {
            mtrace('No connected sync-enabled courses to process.');
            return;
        }

        // Keep the order deterministic so that a given set of remaining courses always produces the same
        // follow-up custom data, letting queue_adhoc_task() deduplicate it.
        sort($courseids);

        $batchsize = (int) get_config('local_o365', 'courses_per_task');
        if ($batchsize <= 0) {
            $batchsize = self::DEFAULT_BATCH_SIZE;
        }

        $batch = array_slice($courseids, 0, $batchsize);
        $remaining = array_slice($courseids, $batchsize);

        mtrace('Processing ' . count($batch) . ' course(s); ' . count($remaining) . ' queued for follow-up.');

        // Per-course failure counts carried over from earlier runs, keyed by course ID.
        $data = $this->get_custom_data();
        $attempts = ($data && !empty($data->attempts)) ? (array) $data->attempts : [];

        $retrycourseids = [];
        $coursesync = new main($graphclient);
        foreach ($batch as $courseid) {
            $courseid = (int) $courseid;
            try {
                $coursesync->process_course_team_user_sync_from_moodle_to_microsoft($courseid);
                // Success - forget any earlier failures for this course.
                unset($attempts[$courseid]);
            } catch (Throwable $e) {
                // Isolate per-course failures so one bad course does not abort the whole batch (and prevent the
                // follow-up task from being queued).
                mtrace('Error syncing owners / members for course ' . $courseid . ': ' . $e->getMessage());
                utils::debug('Exception: ' . $e->getMessage(), __METHOD__, $e);

                $attemptcount = (int) ($attempts[$courseid] ?? 0) + 1;
                if ($attemptcount < self::MAX_COURSE_ATTEMPTS) {
                    // Give transient errors another attempt via the follow-up task.
                    $attempts[$courseid] = $attemptcount;
                    $retrycourseids[] = $courseid;
                } else {
                    mtrace('Course ' . $courseid . ' failed ' . $attemptcount . ' times; giving up until next sync.');
                    unset($attempts[$courseid]);
                }
            }
        }

        $followupcourseids = array_values(array_unique(array_merge($remaining, $retrycourseids)));
        if (!empty($followupcourseids)) {
            // Only carry forward failure counts for courses that are actually in the follow-up list.
            $attempts = array_intersect_key($attempts, array_flip($followupcourseids));

            $customdata = ['courseids' => $followupcourseids];
            if (!empty($attempts)) {
                $customdata['attempts'] = $attempts;
            }
            $followup = new groupmembershipsync();
            $followup->set_custom_data($customdata);
            // Pass true to skip queueing when an identical follow-up already exists: this task may be retried, or
            // run concurrently, and re-queueing the same remaining course list would only add redundant load.
            manager::queue_adhoc_task($followup, true);
            mtrace('Queued follow-up for ' . count($followupcourseids) . ' course(s) (' . count($retrycourseids) . ' retried).');
        }
    }

    /**
     * Return the list of course IDs this run should work through.
     *
     * When the task carries custom data with a "courseids" list (a follow-up of an earlier run), that list is
     * used as-is. Otherwise the full set of sync-enabled courses that currently have a connected group is built.
     *
     * @return array Array of course IDs.
     */
    private function get_courses_to_process(): array {
        global $DB;

        $data = $this->get_custom_data();
        if ($data && !empty($data->courseids) && is_array($data->courseids)) {
            return array_values(array_filter(array_map('intval', $data->courseids)));
        }

        // All courses that currently have a connected group, excluding the site course.
        $sql = "SELECT DISTINCT obj.moodleid
                  FROM {local_o365_objects} obj
                  JOIN {course} c ON c.id = obj.moodleid
                 WHERE obj.type = :type AND obj.subtype = :subtype AND obj.moodleid <> :siteid";
        $params = ['type' => 'group', 'subtype' => 'course', 'siteid' => SITEID];
        $connectedcourseids = $DB->get_fieldset_sql($sql, $params);
        if (empty($connectedcourseids)) {
            return [];
        }

        $enabled = coursesyncutils::get_enabled_courses();
        if ($enabled === true) {
            return array_values(array_map('intval', $connectedcourseids));
        }
        if (is_array($enabled) && !empty($enabled)) {
            return array_values(array_intersect(array_map('intval', $connectedcourseids), array_map('intval', $enabled)));
        }

        return [];
    }
}
