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
 * AdHoc task to sync a single Moodle calendar event change with Microsoft Outlook.
 *
 * Queued by calsync observers instead of performing the sync synchronously,
 * to avoid blocking web requests when courses have large enrolments.
 *
 * @package     local_o365
 * @copyright   Enovation Solutions Ltd. {@link https://enovation.ie}
 * @author      Patryk Mroczko <patryk.mroczko@enovation.ie>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_o365\feature\calsync\task;

use local_o365\utils;

/**
 * AdHoc task to sync a single Moodle calendar event change with Microsoft Outlook.
 *
 * Custom data fields:
 *   - int    eventid  The ID of the Moodle calendar event.
 *   - string action   One of 'create', 'update', or 'delete'.
 *   - array  snapshot (delete only) JSON-encoded snapshot of the event record taken before deletion.
 */
class synccalendarevent extends \core\task\adhoc_task {
    /**
     * Execute the task.
     *
     * @return bool
     */
    public function execute(): bool {
        global $DB;

        if (utils::is_connected() !== true) {
            return false;
        }

        $data = $this->get_custom_data();

        $calsync = new \local_o365\feature\calsync\main();

        switch ($data->action) {
            case 'create':
                if (!$DB->record_exists('event', ['id' => $data->eventid])) {
                    return true;
                }
                $calsync->create_outlook_event_from_moodle_event($data->eventid);
                break;

            case 'update':
                $calsync->update_outlook_event($data->eventid);
                break;

            case 'delete':
                $calsync->delete_outlook_event($data->eventid, (object)$data->snapshot);
                break;
        }

        return true;
    }
}
