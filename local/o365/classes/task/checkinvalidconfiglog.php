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
 * Scheduled task to check for invalid config log records and queue adhoc task if found.
 *
 * @package     local_o365
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright   (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

use core\task\manager;
use core\task\scheduled_task;

/**
 * Scheduled task to check for invalid config log records and queue cleanup if needed.
 */
class checkinvalidconfiglog extends scheduled_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name(): string {
        return get_string('task_checkinvalidconfiglog', 'local_o365');
    }

    /**
     * Execute the task.
     *
     * @return bool
     */
    public function execute(): bool {
        global $DB;

        $hasinvalidrecords = false;

        // Check if there are any invalid records to process.
        foreach (deleteinvalidconfiglog::CONFIG_NAMES as $configname) {
            $count = $DB->count_records('config_log', ['plugin' => 'local_o365', 'name' => $configname]);
            if ($count > 0) {
                mtrace("Found {$count} invalid config_log records for {$configname}");
                $hasinvalidrecords = true;
            }
        }

        // If there are invalid records, check if there's already a queued or running task.
        if ($hasinvalidrecords) {
            // Check if there's already a queued adhoc task for deletion.
            $adhoctasks = manager::get_adhoc_tasks('\local_o365\task\deleteinvalidconfiglog');
            $hastask = false;
            foreach ($adhoctasks as $adhoctask) {
                if ($adhoctask->get_fail_delay() == 0) {
                    // Task is not in a failed state.
                    $hastask = true;
                    break;
                }
            }

            if (!$hastask) {
                mtrace("Queueing adhoc task to delete invalid config log records...");
                $task = new deleteinvalidconfiglog();
                // Set next run time to ensure it runs in the next cron cycle.
                $task->set_next_run_time(time() + 60);
                manager::queue_adhoc_task($task);
            } else {
                mtrace("Adhoc task already queued or running, skipping.");
            }
        } else {
            mtrace("No invalid config log records found.");
        }

        return true;
    }
}
