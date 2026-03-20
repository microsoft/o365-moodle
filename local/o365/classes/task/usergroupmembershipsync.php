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
 * Ad-hoc task to sync a single Moodle user's role in a course group to Microsoft 365.
 *
 * @package local_o365
 * @author  Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

use core\task\adhoc_task;
use local_o365\utils;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/o365/lib.php');

/**
 * Ad-hoc task to sync a single user-course pair to the connected Microsoft 365 group.
 *
 * @package     local_o365
 * @subpackage  local_o365\task
 */
class usergroupmembershipsync extends adhoc_task {
    /**
     * Return a human-readable name for this task (shown in the admin task log UI).
     *
     * @return string
     */
    public function get_name(): string {
        return get_string('task_usergroupmembershipsync', 'local_o365');
    }

    /**
     * Execute the task: sync one user's role in one course group to Microsoft 365.
     *
     * Custom data fields:
     *   - userid (int)                      Moodle user ID
     *   - courseid (int)                    Moodle course ID
     *   - excluderoleid (int)               Role ID to exclude (0 = none); used for role_unassigned events
     *   - coursegroupobjectrecordid (int)   Optional: pre-fetched local_o365_objects record ID for the course group.
     *                                       When provided, skips the per-task DB lookup in sync_user_role_in_course_group.
     *   - sdscoursechecked (bool)           Optional: true when the observer already verified SDS sync eligibility,
     *                                       allowing sync_user_role_in_course_group to skip the redundant SDS check.
     *
     * @return bool
     */
    public function execute(): bool {
        $data = $this->get_custom_data();

        if (empty($data->userid)) {
            mtrace('... usergroupmembershipsync: missing userid, skipping.');
            return false;
        }

        if (empty($data->courseid)) {
            mtrace('... usergroupmembershipsync: missing courseid, skipping.');
            return false;
        }

        $courseusersyncdirection = get_config('local_o365', 'courseusersyncdirection');
        if ($courseusersyncdirection == COURSE_USER_SYNC_DIRECTION_TEAMS_TO_MOODLE) {
            return false;
        }

        if (utils::is_connected() !== true || \local_o365\feature\coursesync\utils::is_enabled() !== true) {
            return false;
        }

        if (\local_o365\feature\coursesync\utils::is_course_sync_enabled((int) $data->courseid) !== true) {
            mtrace("... usergroupmembershipsync: course sync disabled for course {$data->courseid}, skipping.");
            return false;
        }

        $excluderoleid = !empty($data->excluderoleid) ? (int) $data->excluderoleid : 0;
        $coursegroupobjectrecordid = !empty($data->coursegroupobjectrecordid) ? (int) $data->coursegroupobjectrecordid : 0;
        $sdscoursechecked = !empty($data->sdscoursechecked);

        mtrace("... Syncing user {$data->userid} in course {$data->courseid} to Microsoft 365 group.");

        return \local_o365\feature\coursesync\utils::sync_user_role_in_course_group(
            (int) $data->userid,
            (int) $data->courseid,
            0,
            $coursegroupobjectrecordid,
            $sdscoursechecked,
            $excluderoleid
        );
    }
}
