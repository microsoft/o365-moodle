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
 * AdHoc task to re-sync a user's Outlook events after their group membership changed.
 *
 * @package local_o365
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\calsync\task;

use local_o365\utils;

/**
 * AdHoc task to re-sync a user's Outlook events after their group membership changed.
 *
 * Queued by \local_o365\feature\calsync\observers::handle_group_member_added()/
 * handle_group_member_removed(), since a group-based "Restrict access" rule can change who a module is
 * visible to purely from a group membership change, without the module itself ever being edited (which
 * is the only thing \local_o365\feature\calsync\task\syncmoduleavailability reacts to).
 *
 * Scoped to modules that actually have an availability rule configured, to avoid needlessly pushing a
 * redundant Outlook "update attendees" call for every course event whenever any group membership changes
 * anywhere in the course.
 */
class syncuseravailability extends \core\task\adhoc_task {
    /**
     * Do the job.
     */
    public function execute() {
        global $DB;

        if (utils::is_connected() !== true) {
            return;
        }

        $data = $this->get_custom_data();
        $courseid = $data->courseid;
        $userid = $data->userid;

        $calsync = new \local_o365\feature\calsync\main();

        // Course-level events (e.g. due dates): reconcile the whole attendee list, since a combined or
        // group event is shared with every eligible attendee, not just the user whose membership changed.
        $sql = "SELECT ev.*
                  FROM {event} ev
                  JOIN {course_modules} cm ON cm.instance = ev.instance
                  JOIN {modules} m ON m.id = cm.module AND m.name = ev.modulename
                 WHERE ev.courseid = :courseid
                       AND cm.availability IS NOT NULL AND cm.availability <> :empty1";
        $courseevents = $DB->get_records_sql($sql, ['courseid' => $courseid, 'empty1' => '']);
        foreach ($courseevents as $event) {
            try {
                $calsync->reconcile_course_event_attendees($event->id);
            } catch (\Throwable $e) {
                // Catches \Error (e.g. a coding bug like a TypeError) as well as moodle_exception, so one
                // bad event can't silently abort reconciliation for the rest of this course's events - or,
                // for this loop specifically, prevent the personal-events loop below from ever running.
                mtrace('Error reconciling Outlook sync for event #' . $event->id . ': ' . $e->getMessage());
            }
        }

        // Personal events (extensions, user overrides) tied to a restricted module in this course,
        // belonging to the specific user whose group membership changed.
        $sql = "SELECT ev.*
                  FROM {event} ev
                  JOIN {course_modules} cm ON cm.instance = ev.instance
                  JOIN {modules} m ON m.id = cm.module AND m.name = ev.modulename
                 WHERE cm.course = :courseid
                       AND ev.courseid = 0
                       AND ev.userid = :userid
                       AND cm.availability IS NOT NULL AND cm.availability <> :empty2";
        $personalevents = $DB->get_records_sql($sql, ['courseid' => $courseid, 'userid' => $userid, 'empty2' => '']);
        foreach ($personalevents as $event) {
            try {
                $calsync->reconcile_personal_event($event->id);
            } catch (\Throwable $e) {
                // Catches \Error (e.g. a coding bug like a TypeError) as well as moodle_exception, so one
                // bad event can't silently abort reconciliation for the rest of this user's events.
                mtrace('Error reconciling Outlook sync for event #' . $event->id . ': ' . $e->getMessage());
            }
        }
    }
}
