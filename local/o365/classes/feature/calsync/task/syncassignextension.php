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
 * AdHoc task to sync a mod_assign extension change with Outlook.
 *
 * @package local_o365
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\calsync\task;

use local_o365\utils;
use moodle_exception;

/**
 * AdHoc task to sync a mod_assign extension change with Outlook.
 *
 * mod_assign\assign::save_user_extension() updates or deletes the underlying calendar 'event' record
 * with direct SQL rather than through calendar_event::update()/delete() when an extension is re-granted
 * or revoked, so the generic calendar_event_updated/deleted events never fire for those changes. This
 * task is queued by \local_o365\feature\calsync\observers::handle_assign_extension_granted() - which
 * captures a snapshot of the pre-change event plus the new extension date - to make the corresponding
 * outbound Graph API calls after the triggering request has committed, rather than making them inline
 * during the teacher's grant-extension request.
 */
class syncassignextension extends \core\task\adhoc_task {
    /**
     * Do the job.
     */
    public function execute() {
        if (utils::is_connected() !== true) {
            return;
        }

        $data = $this->get_custom_data();
        $event = (object) (array) $data->event;

        $calsync = new \local_o365\feature\calsync\main();

        try {
            if ($data->action === 'delete') {
                $calsync->delete_outlook_event($event->id, $event);
            } else if ($data->action === 'update') {
                $calsync->update_outlook_event_datetime($event->id, (int) $data->newextensionduedate);
            }
        } catch (moodle_exception $e) {
            mtrace('Error syncing assignment extension for event #' . $event->id . ': ' . $e->getMessage());
        }
    }
}
