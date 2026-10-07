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
 * Ad-hoc task to create the Microsoft Teams channel of a Moodle group and sync its members.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

use core\task\adhoc_task;
use local_o365\feature\coursesync\groupchannels;
use local_o365\feature\coursesync\utils as coursesyncutils;
use local_o365\utils;

/**
 * Ad-hoc task to create the private channel of one Moodle group and sync its members.
 *
 * Custom data: groupid (int) The Moodle group ID.
 *
 * A group that can't be synced now, for example because a user hasn't been added to the Team yet, is picked up again by the
 * scheduled groupchannelsync task.
 */
class groupchannelsyncgroup extends adhoc_task {
    /**
     * Return a human-readable name for this task (shown in the admin task log UI).
     *
     * @return string
     */
    public function get_name(): string {
        return get_string('task_groupchannelsyncgroup', 'local_o365');
    }

    /**
     * Do the job.
     *
     * @return void
     */
    public function execute(): void {
        $data = $this->get_custom_data();
        if (empty($data->groupid)) {
            utils::mtrace('Missing group ID, skipping.', 1);
            return;
        }

        if (!groupchannels::is_enabled() || utils::is_connected() !== true) {
            return;
        }

        $graphclient = coursesyncutils::get_graphclient();
        if (empty($graphclient)) {
            utils::mtrace('Could not connect to Microsoft Graph, skipping.', 1);
            return;
        }

        $groupchannels = new groupchannels($graphclient);
        $groupchannels->set_trace_level(1);
        $groupchannels->sync_group((int)$data->groupid);
    }
}
