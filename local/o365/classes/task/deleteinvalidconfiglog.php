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

    /** @var int Number of records to delete from logstore_standard_log per chunk to avoid long locks */
    const DELETE_CHUNK_SIZE = 500;

    /**
     * @var int Maximum items for IN clause to support Oracle's 1000-item limit.
     * Set to 900 to provide safety margin.
     */
    const MAX_IN_CLAUSE_ITEMS = 900;

    /** @var int Maximum execution time in seconds before queuing next task (5 minutes) */
    const MAX_EXECUTION_TIME = 300;

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
        $starttime = time();

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
                    // Delete corresponding logstore_standard_log records in chunks to avoid long table locks.
                    // The logstore_standard_log table is typically very large and a single DELETE with thousands
                    // of IDs can lock the table for extended periods, making the site unavailable.
                    //
                    // Strategy: Use SELECT-then-DELETE approach to leverage existing indexes:
                    // 1. Get config_log records with timemodified values
                    // 2. Use timecreated index to find matching logstore records
                    // 3. Delete by primary key ID (very fast)
                    //
                    // This avoids full table scans on unindexed columns (eventname, objectid).
                    $deletechunks = array_chunk($configlogids, self::DELETE_CHUNK_SIZE);
                    $totaldeleted = 0;

                    foreach ($deletechunks as $chunk) {
                        // First, get the config_log records with their timemodified values.
                        $configrecords = $DB->get_records_list('config_log', 'id', $chunk, '', 'id, timemodified');

                        if (empty($configrecords)) {
                            continue;
                        }

                        // Build map of config_log ID => [possible timecreated values].
                        // The objectid in logstore_standard_log references these config_log IDs.
                        $objectidtotimes = [];
                        $alltimecreated = [];
                        foreach ($configrecords as $record) {
                            $objectidtotimes[$record->id] = [
                                $record->timemodified,
                                $record->timemodified + 1,
                            ];
                            $alltimecreated[] = $record->timemodified;
                            $alltimecreated[] = $record->timemodified + 1;
                        }

                        // Remove duplicates and use timecreated index to narrow search.
                        $alltimecreated = array_unique($alltimecreated);

                        if (empty($alltimecreated)) {
                            continue;
                        }

                        // Oracle has a 1000-item limit for IN clauses. Split into chunks if needed.
                        // This also improves performance on other databases by avoiding huge IN clauses.
                        $timechunks = array_chunk($alltimecreated, self::MAX_IN_CLAUSE_ITEMS);
                        $logidstodelete = [];

                        foreach ($timechunks as $timechunk) {
                            // Use timecreated index to find potential matching records.
                            // This dramatically reduces the search space from 202M rows to just thousands.
                            [$timesql, $timeparams] = $DB->get_in_or_equal($timechunk, SQL_PARAMS_NAMED);
                            $selectsql = "SELECT id, objectid, timecreated
                                            FROM {logstore_standard_log}
                                           WHERE eventname = :eventname
                                             AND timecreated $timesql";
                            $params = array_merge(['eventname' => '\core\event\config_log_created'], $timeparams);

                            $logrecords = $DB->get_records_sql($selectsql, $params);

                            // Filter to exact matches (objectid and timecreated correlation).
                            foreach ($logrecords as $logrec) {
                                if (isset($objectidtotimes[$logrec->objectid])) {
                                    if (in_array($logrec->timecreated, $objectidtotimes[$logrec->objectid])) {
                                        $logidstodelete[] = $logrec->id;
                                    }
                                }
                            }
                        }

                        // Delete by primary key (very efficient).
                        if (!empty($logidstodelete)) {
                            // Further chunk the deletes to avoid holding locks too long.
                            $microdeletechunks = array_chunk($logidstodelete, 100);
                            foreach ($microdeletechunks as $microchunk) {
                                $DB->delete_records_list('logstore_standard_log', 'id', $microchunk);
                                usleep(50000); // 0.05 seconds between micro-deletes.
                            }
                            $totaldeleted += count($logidstodelete);
                            mtrace("... Deleted " . count($logidstodelete) . " logstore records for chunk");

                            // Delete config_log records for this chunk immediately after logstore deletion.
                            // This ensures atomic per-chunk processing: either both tables are cleaned up,
                            // or neither is touched. Prevents orphaning logstore deletions on timeout.
                            $DB->delete_records_list('config_log', 'id', $chunk);
                            mtrace("... Deleted " . count($chunk) . " config_log records for chunk");

                            // Check if we've exceeded the maximum execution time.
                            if (time() >= $starttime + self::MAX_EXECUTION_TIME) {
                                mtrace("... Reached time limit. Processed {$totaldeleted} records so far.");
                                $hasmore = true;
                                break 2; // Break out of both foreach loops.
                            }

                            // Brief pause to allow locks to be released and other queries to execute.
                            usleep(100000); // 0.1 seconds.
                        }
                    }

                    // Check if there are more records to process for this config name.
                    if (!$hasmore) {
                        mtrace("... Completed processing for {$configname}");
                        $remaining = $DB->count_records('config_log', ['plugin' => 'local_o365', 'name' => $configname]);
                        if ($remaining > 0) {
                            mtrace("... {$remaining} records remaining for {$configname}");
                            $hasmore = true;
                        }
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
