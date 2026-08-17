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
 * An adhoc task to force a one-off full Microsoft Entra ID user sync.
 *
 * @package     local_o365
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright   (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

use core\task\adhoc_task;
use local_o365\feature\usersync\main;

/**
 * Adhoc task to force a one-off full Microsoft Entra ID user sync.
 *
 * Queued during upgrade to repair Moodle accounts whose linked Microsoft Entra ID object ID
 * went stale (e.g. the Entra ID account was deleted and recreated more than 30 days ago) before
 * the fix to the object ID repair logic in the user sync task. Delta sync only reports users
 * that changed since the last sync, so accounts that were already stale before this fix would
 * not otherwise be picked up again on their own. If the site currently uses delta sync, this
 * temporarily enables a full sync for a single run, then restores the previous setting. If a
 * full sync already runs every time, no override is needed.
 */
class forcefullusersync extends adhoc_task {
    /**
     * Execute the task.
     *
     * @return bool
     */
    public function execute(): bool {
        if (main::sync_option_enabled('nodelta')) {
            mtrace('Full sync already runs every time (nodelta enabled). No override needed.');

            return true;
        }

        $originalsetting = (string) get_config('local_o365', 'usersync');
        $originaloptions = array_filter(explode(',', $originalsetting));

        mtrace('Delta sync is currently in use. Temporarily forcing a full sync for this run...');
        set_config('usersync', implode(',', array_merge($originaloptions, ['nodelta'])), 'local_o365');

        try {
            $task = new usersync();
            $task->execute();
        } finally {
            set_config('usersync', implode(',', $originaloptions), 'local_o365');
            mtrace('Restored previous delta sync setting.');
        }

        return true;
    }
}
