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
 * Scheduled task to create Microsoft Teams channels for Moodle groups and sync their members.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

use core\task\scheduled_task;
use local_o365\feature\coursesync\groupchannels;
use local_o365\feature\coursesync\utils as coursesyncutils;
use local_o365\utils;

/**
 * Scheduled task to create a private channel in the Microsoft Team of a course for each Moodle group, and sync its members.
 *
 * Each run handles the next few groups, giving priority to groups that have no channel yet, so all groups are covered over time.
 */
class groupchannelsync extends scheduled_task {
    /** @var int Maximum number of groups to process in one run. */
    protected const BATCH_SIZE = 30;

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_groupchannelsync', 'local_o365');
    }

    /**
     * Do the job.
     *
     * @return bool
     */
    public function execute() {
        if (!groupchannels::is_enabled()) {
            utils::mtrace('Channels for Moodle groups are not enabled, nothing to do.', 1);
            return true;
        }

        if (utils::is_connected() !== true) {
            utils::mtrace('Microsoft 365 integration is not configured, nothing to do.', 1);
            return true;
        }

        $graphclient = coursesyncutils::get_graphclient();
        if (empty($graphclient)) {
            utils::mtrace('Could not connect to Microsoft Graph, nothing to do.', 1);
            return true;
        }

        utils::mtrace('Start syncing channels for Moodle groups.', 1);

        $groupchannels = new groupchannels($graphclient);
        $groupchannels->set_trace_level(2);
        $count = $groupchannels->sync_next_groups(self::BATCH_SIZE);

        utils::mtrace('Finished syncing channels for Moodle groups. Synced ' . $count . ' group(s).', 1);

        return true;
    }
}
