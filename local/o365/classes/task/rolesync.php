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
 * Scheduled task to sync Moodle system roles from Microsoft 365 group membership.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

use core\task\scheduled_task;
use local_o365\feature\cohortsync\main as cohortsyncmain;
use local_o365\feature\rolesync\main;
use local_o365\utils;
use Throwable;

/**
 * Scheduled task to sync Moodle system roles from Microsoft 365 group membership.
 */
class rolesync extends scheduled_task {
    /**
     * Get the name of the task.
     *
     * @return string
     */
    public function get_name(): string {
        return get_string('task_rolesync', 'local_o365');
    }

    /**
     * Execute the scheduled task.
     *
     * @return bool
     */
    public function execute(): bool {
        global $DB;

        if (utils::is_connected() !== true) {
            utils::mtrace('Microsoft 365 not configured.', 2);

            return false;
        }

        $hasmapping = !empty(main::get_mapping());
        $hasexisting = main::is_revoke_enabled() && $DB->record_exists('role_assignments', [
            'component' => main::COMPONENT,
            'itemid' => main::SOURCE_GROUP,
        ]);
        if (!$hasmapping && !$hasexisting) {
            utils::mtrace('No group role mapping configured. Nothing to do.', 2);

            return true;
        }

        raise_memory_limit(MEMORY_HUGE);
        @set_time_limit(0);

        try {
            $graphclient = cohortsyncmain::get_unified_api(__METHOD__);
            if (empty($graphclient)) {
                utils::mtrace('Failed to get Graph API client. Exiting.', 2);

                return true;
            }

            main::sync_groups($graphclient, function (string $message, int $level = 0): void {
                utils::mtrace($message, 2 + $level);
            });
        } catch (Throwable $e) {
            utils::mtrace('Error in role sync: ' . $e->getMessage(), 2);
            utils::debug($e->getMessage(), __METHOD__, $e);
        }

        return true;
    }
}
