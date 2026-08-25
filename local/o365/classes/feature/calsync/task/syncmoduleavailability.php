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
 * AdHoc task to re-sync Outlook events for a course module after its availability may have changed.
 *
 * @package local_o365
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\calsync\task;

use local_o365\utils;

/**
 * AdHoc task to re-sync Outlook events for a course module after its availability may have changed.
 *
 * Queued by \local_o365\feature\calsync\observers::handle_course_module_updated() whenever a course
 * module is edited, since editing "Restrict access" rules doesn't touch the calendar 'event' table at
 * all and so never fires the events the normal calendar sync observers listen for.
 */
class syncmoduleavailability extends \core\task\adhoc_task {
    /**
     * Do the job.
     */
    public function execute() {
        global $DB;

        if (utils::is_connected() !== true) {
            return;
        }

        $data = $this->get_custom_data();

        $events = $DB->get_records('event', ['modulename' => $data->modulename, 'instance' => $data->instanceid]);
        if (empty($events)) {
            return;
        }

        $calsync = new \local_o365\feature\calsync\main();

        foreach ($events as $event) {
            try {
                if (!empty($event->courseid)) {
                    $calsync->reconcile_course_event_attendees($event->id);
                } else {
                    $calsync->reconcile_personal_event($event->id);
                }
            } catch (\Throwable $e) {
                // Catches \Error (e.g. a coding bug like a TypeError) as well as moodle_exception, so one
                // bad event can't silently abort reconciliation for the rest of this module's events.
                mtrace('Error reconciling Outlook sync for event #' . $event->id . ': ' . $e->getMessage());
            }
        }
    }
}
