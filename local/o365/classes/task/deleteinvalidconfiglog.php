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
 * An adhoc task to delete invalid config log records in batches.
 *
 * @package     local_o365
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright   (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

use core\task\adhoc_task;
use core\task\manager;

/**
 * Adhoc task for deleting invalid config log records in batches.
 */
class deleteinvalidconfiglog extends adhoc_task {
    /** @var int Number of records to process per batch */
    const BATCH_SIZE = 10000;

    /** @var array List of config names that should not have been logged */
    const CONFIG_NAMES = [
        'apptokens',
        'teamscacheupdated',
        'calsyncinlastrun',
        'task_usersync_lastdeltatoken',
        'task_usersync_lastdelete',
        'cal_site_lastsync',
        'cal_course_lastsync',
        'cal_user_lastsync',
    ];

    /**
     * Execute the task.
     *
     * @return bool
     */
    public function execute(): bool {
        global $DB;

        $hasmore = false;

        foreach (self::CONFIG_NAMES as $configname) {
            mtrace("Processing config name: {$configname}");

            // Count total records for this config name.
            $totalcount = $DB->count_records('config_log', ['plugin' => 'local_o365', 'name' => $configname]);

            if ($totalcount > 0) {
                mtrace("... Found {$totalcount} config_log records for {$configname}");

                // Use recordset for memory efficiency, process up to BATCH_SIZE records.
                $configlogids = [];
                $recordset = $DB->get_recordset_select(
                    'config_log',
                    'plugin = :plugin AND name = :name',
                    ['plugin' => 'local_o365', 'name' => $configname],
                    'id ASC',
                    'id'
                );

                $count = 0;
                foreach ($recordset as $record) {
                    $configlogids[] = $record->id;
                    $count++;
                    if ($count >= self::BATCH_SIZE) {
                        break;
                    }
                }
                $recordset->close();

                if (!empty($configlogids)) {
                    // Delete corresponding logstore_standard_log records.
                    [$insql, $inparams] = $DB->get_in_or_equal($configlogids, SQL_PARAMS_NAMED);
                    $params = array_merge(['eventname' => '\core\event\config_log_created'], $inparams);
                    $DB->delete_records_select('logstore_standard_log', "eventname = :eventname AND objectid $insql", $params);

                    // Delete config_log records.
                    $DB->delete_records_list('config_log', 'id', $configlogids);

                    mtrace("... Deleted {$count} records for {$configname}");

                    // Check if there are more records to process.
                    $remaining = $DB->count_records('config_log', ['plugin' => 'local_o365', 'name' => $configname]);
                    if ($remaining > 0) {
                        mtrace("... {$remaining} records remaining for {$configname}");
                        $hasmore = true;
                    }
                }
            }
        }

        // If there are more records to process, queue another ad-hoc task.
        if ($hasmore) {
            mtrace("Queueing another ad-hoc task to continue processing...");
            $task = new self();
            // Set next run time to ensure it runs in the next cron cycle, not immediately.
            $task->set_next_run_time(time() + 60);
            manager::queue_adhoc_task($task);
        } else {
            mtrace("All invalid config log records have been deleted.");
        }

        return true;
    }
}
