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
 * Microsoft Entra ID user photo and timezone sync scheduled task.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

use core\task\scheduled_task;
use local_o365\feature\usersync\main;
use local_o365\utils;
use moodle_exception;

/**
 * Scheduled task to sync user photos and timezones with Microsoft Entra ID.
 */
class photoandtimezonesync extends scheduled_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_syncusersphotostimezones', 'local_o365');
    }

    /**
     * Print debugging information using mtrace.
     *
     * @param string $msg
     * @param int $additionallevel
     */
    protected function mtrace(string $msg, int $additionallevel = 0) {
        utils::mtrace($msg, 2 + $additionallevel);
    }

    /**
     * Do the job.
     */
    public function execute() {
        global $DB, $CFG;

        if (utils::is_connected() !== true) {
            $this->mtrace('Microsoft 365 not configured');
            return false;
        }

        // Check if photo or timezone sync is enabled.
        $photosyncenabled = main::sync_option_enabled('photosync');
        $tzsynceenabled = main::sync_option_enabled('tzsync');

        if (!$photosyncenabled && !$tzsynceenabled) {
            $this->mtrace('Photo and timezone sync disabled. Nothing to do.');
            return true;
        }

        $this->mtrace('Starting photo and timezone sync.');
        raise_memory_limit(MEMORY_HUGE);

        // Do not time out when syncing.
        @set_time_limit(0);

        // Get batch size from config (default: 5000).
        $batchsize = get_config('local_o365', 'photosync_batchsize');
        if (empty($batchsize) || !is_numeric($batchsize) || $batchsize < 1) {
            $batchsize = 5000;
        }
        $this->mtrace('Batch size: ' . $batchsize . ' users.', 1);

        $usersync = new main();

        // Count total users to process.
        $countsql = "SELECT COUNT(obj.moodleid)
                       FROM {local_o365_objects} obj
                       JOIN {user} u ON u.id = obj.moodleid
                      WHERE obj.type = 'user'
                        AND u.deleted = 0
                        AND u.suspended = 0
                        AND obj.o365name IS NOT NULL
                        AND obj.o365name != ''";

        $totalusers = $DB->count_records_sql($countsql);

        if (empty($totalusers)) {
            $this->mtrace('No Microsoft 365 users found.');
            return true;
        }

        $this->mtrace('Total Microsoft 365 users: ' . $totalusers . '.');
        $this->mtrace('');

        // Track totals across all batches.
        $totalphotoschanged = 0;
        $totaltimezoneschanged = 0;
        $totalusersforphotosync = 0;
        $totalusersfortzsync = 0;

        // Check for in-progress sync (resumable).
        $syncprogress = get_config('local_o365', 'photosync_progress');
        $startbatch = 0;

        if (!empty($syncprogress)) {
            $progressdata = json_decode($syncprogress, true);
            if (is_array($progressdata) && isset($progressdata['batch'])) {
                $startbatch = $progressdata['batch'];
                $totalphotoschanged = $progressdata['photos_changed'] ?? 0;
                $totaltimezoneschanged = $progressdata['timezones_changed'] ?? 0;
                $totalusersforphotosync = $progressdata['photos_requested'] ?? 0;
                $totalusersfortzsync = $progressdata['tz_users'] ?? 0;

                $this->mtrace('Resuming from batch ' . ($startbatch + 1) . '...', 1);
            }
        }

        // Process users in batches.
        $numbatches = ceil($totalusers / $batchsize);
        $this->mtrace('Processing in ' . $numbatches . ' batch(es)...');
        $this->mtrace('');

        for ($batchnum = $startbatch; $batchnum < $numbatches; $batchnum++) {
            $offset = $batchnum * $batchsize;

            $this->mtrace('Batch ' . ($batchnum + 1) . '/' . $numbatches . ' (offset: ' . $offset . ')...');

            // Azure AD Object ID (GUID) is used as the photo API identifier because
            // o365name may contain a bare username on some installations, which Graph rejects
            // with HTTP 400. A GUID is always a valid user identifier for the Graph API.
            // local_o365_appassign.muserid has a UNIQUE index, so a direct LEFT JOIN is safe.
            $sql = "SELECT obj.moodleid AS muserid,
                           obj.objectid,
                           u.username,
                           u.picture AS currentpicture,
                           u.timezone AS currenttimezone,
                           appassign.id AS appassignid
                      FROM {local_o365_objects} obj
                      JOIN {user} u ON u.id = obj.moodleid
                 LEFT JOIN {local_o365_appassign} appassign ON appassign.muserid = obj.moodleid
                     WHERE obj.type = 'user'
                       AND u.deleted = 0
                       AND u.suspended = 0
                       AND obj.objectid IS NOT NULL
                       AND obj.objectid != ''
                       AND obj.o365name IS NOT NULL
                       AND obj.o365name != ''
                  ORDER BY obj.moodleid";

            $users = $DB->get_records_sql($sql, null, $offset, $batchsize);

            if (empty($users)) {
                $this->mtrace('No users in this batch.', 1);
                continue;
            }

            $this->mtrace('Loaded ' . count($users) . ' users from database.', 1);

            // Separate users by what needs updating.
            // Both photos and timezones use objectid (GUID) as the API identifier.
            $objectidsforphotosync = [];
            $objectidsfortzsync = [];

            foreach ($users as $user) {
                if ($photosyncenabled) {
                    $objectidsforphotosync[] = $user->objectid;
                }

                if ($tzsynceenabled) {
                    $objectidsfortzsync[] = $user->objectid;
                }
            }

            if ($photosyncenabled) {
                $this->mtrace('Users for photo sync: ' . count($objectidsforphotosync), 1);
                $totalusersforphotosync += count($objectidsforphotosync);
            }

            if ($tzsynceenabled) {
                $this->mtrace('Users for timezone sync: ' . count($objectidsfortzsync), 1);
                $totalusersfortzsync += count($objectidsfortzsync);
            }

            // Construct the API client once per batch. Both the timezone and photo
            // fetches share the same client so we pay the token lookup cost only once.
            $apiclient = null;

            // Batch fetch timezones for users that need it.
            $timezonesbyobjectid = [];
            if ($tzsynceenabled && !empty($objectidsfortzsync) && !PHPUNIT_TEST && !defined('BEHAT_SITE_RUNNING')) {
                try {
                    $this->mtrace('Fetching timezones...', 1);
                    $apiclient = $usersync->construct_user_api();
                    $timezonesbyobjectid = $apiclient->get_timezones_batch($objectidsfortzsync);
                    $this->mtrace('Fetched ' . count(array_filter($timezonesbyobjectid)) . ' timezones from API.', 2);
                } catch (moodle_exception $e) {
                    $this->mtrace('Error fetching timezones: ' . $e->getMessage(), 1);
                    utils::debug($e->getMessage(), __METHOD__, $e);
                }
            }

            // Batch fetch photos for all users, keyed by objectid.
            $photosbyobjectid = [];
            $photofetchstats = [
                'success' => 0,
                'not_found' => 0,
                'error' => 0,
                'invalid_data' => 0,
                'batch_error' => 0,
            ];

            if ($photosyncenabled && !empty($objectidsforphotosync) && !PHPUNIT_TEST && !defined('BEHAT_SITE_RUNNING')) {
                try {
                    $this->mtrace('Fetching photos...', 1);
                    if ($apiclient === null) {
                        $apiclient = $usersync->construct_user_api();
                    }
                    $photosbyobjectid = $apiclient->get_photos_batch($objectidsforphotosync);

                    // Count results by status.
                    foreach ($photosbyobjectid as $response) {
                        if (is_array($response) && isset($response['status'])) {
                            $status = $response['status'];
                            if (isset($photofetchstats[$status])) {
                                $photofetchstats[$status]++;
                            }
                        }
                    }

                    // Log detailed fetch results.
                    $this->mtrace('Photo fetch results:', 2);
                    $this->mtrace('Successful: ' . $photofetchstats['success'], 2);
                    $this->mtrace('Not found (no photo in M365): ' . $photofetchstats['not_found'], 2);
                    if ($photofetchstats['error'] > 0) {
                        $this->mtrace('Errors (permissions/rate limit/server): ' . $photofetchstats['error'], 2);
                    }
                    if ($photofetchstats['invalid_data'] > 0) {
                        $this->mtrace('Invalid photo data: ' . $photofetchstats['invalid_data'], 2);
                    }
                    if ($photofetchstats['batch_error'] > 0) {
                        $this->mtrace('Missing from batch response: ' . $photofetchstats['batch_error'] .
                            ' (requested: ' . count($objectidsforphotosync) . ')', 2);
                    }
                } catch (moodle_exception $e) {
                    $this->mtrace('Error fetching photos: ' . $e->getMessage(), 1);
                    utils::debug($e->getMessage(), __METHOD__, $e);
                }
            }

            // Apply photos and timezones to users in this batch.
            $batchphotoschanged = 0;
            $batchtimezoneschanged = 0;

            if ($photosyncenabled && !empty($photosbyobjectid)) {
                $this->mtrace('Applying photos...', 1);

                // Batch-fetch stored raw-photo hashes so we can skip process_new_icon
                // entirely for users whose photo binary hasn't changed since last sync.
                // Chunk to 1000 IDs per query to stay within SQL Server's 2100-parameter limit.
                $userids = array_keys($users);
                $storedphotohashes = [];
                foreach (array_chunk($userids, 1000) as $chunkedids) {
                    [$insql, $inparams] = $DB->get_in_or_equal($chunkedids);
                    $chunk = $DB->get_records_sql(
                        "SELECT userid, value FROM {user_preferences}
                          WHERE userid $insql AND name = 'local_o365_photo_hash'",
                        $inparams
                    );
                    $storedphotohashes += $chunk;
                }

                foreach ($users as $user) {
                    // Apply photo if available, successful, or needs clearing.
                    if (isset($photosbyobjectid[$user->objectid])) {
                        $response = $photosbyobjectid[$user->objectid];
                        // Handle new format (status array).
                        $shouldapply = false;
                        $photodata = false;
                        $logmessage = '';
                        $incominghash = null;

                        if (is_array($response) && isset($response['status'])) {
                            $status = $response['status'];
                            if ($status === 'success') {
                                $incominghash = sha1($response['data']);
                                $storedhash = isset($storedphotohashes[$user->muserid])
                                    ? $storedphotohashes[$user->muserid]->value
                                    : null;
                                if ($storedhash === $incominghash) {
                                    // Raw photo binary unchanged — skip image processing.
                                    continue;
                                }
                                $photodata = $response['data'];
                                $shouldapply = true;
                                $logmessage = 'Photo changed.';
                            } else if ($status === 'not_found') {
                                if (empty($user->currentpicture)) {
                                    // Already has no photo — nothing to clear.
                                    continue;
                                }
                                $photodata = false;
                                $shouldapply = true;
                                $logmessage = 'Photo cleared (not in M365).';
                            }
                        } else if ($response !== false) {
                            // Fallback for old format compatibility.
                            $incominghash = sha1($response);
                            $storedhash = $storedphotohashes[$user->muserid]->value ?? null;
                            if ($storedhash === $incominghash) {
                                continue;
                            }
                            $photodata = $response;
                            $shouldapply = true;
                            $logmessage = 'Photo changed.';
                        }

                        if ($shouldapply) {
                            $applysucceeded = false;
                            try {
                                $changed = $usersync->apply_photo_public(
                                    $user->muserid,
                                    $photodata,
                                    $user->appassignid ?? null,
                                    $user->currentpicture ?? null
                                );
                                if ($changed) {
                                    $this->mtrace('User "' . $user->username . '": ' . $logmessage, 2);
                                    $batchphotoschanged++;
                                }
                                $applysucceeded = true;
                            } catch (moodle_exception $e) {
                                $this->mtrace('User "' . $user->username . '": Error applying photo - ' .
                                    $e->getMessage(), 2);
                                utils::debug($e->getMessage(), __METHOD__, $e);
                            }
                            // Manage stored hash outside the try/catch. Direct DB write
                            // avoids Moodle's static preference cache accumulating across
                            // large batches; $storedphotohashes tells us whether to INSERT,
                            // UPDATE, or DELETE without an extra SELECT.
                            if ($applysucceeded && $incominghash !== null) {
                                // Photo was applied — store/update the hash for future runs.
                                if (isset($storedphotohashes[$user->muserid])) {
                                    $DB->set_field('user_preferences', 'value', $incominghash, [
                                        'userid' => $user->muserid,
                                        'name'   => 'local_o365_photo_hash',
                                    ]);
                                } else {
                                    $DB->insert_record('user_preferences', (object)[
                                        'userid' => $user->muserid,
                                        'name'   => 'local_o365_photo_hash',
                                        'value'  => $incominghash,
                                    ]);
                                }
                            } else if ($applysucceeded && $changed && isset($storedphotohashes[$user->muserid])) {
                                // Photo was cleared — remove stale hash so a future re-upload
                                // with identical binary content is not skipped by the hash check.
                                $DB->delete_records('user_preferences', [
                                    'userid' => $user->muserid,
                                    'name'   => 'local_o365_photo_hash',
                                ]);
                            }
                        }
                    }
                }
            }

            if ($tzsynceenabled && !empty($timezonesbyobjectid)) {
                $this->mtrace('Applying timezones...', 1);

                foreach ($users as $user) {
                    // Apply timezone if available. Pass the current timezone from the batch
                    // query so apply_timezone_public can short-circuit without fetching the
                    // full user record when the value has not changed. Normalisation and the
                    // Etc/GMT mapping live only in apply_timezone, eliminating the duplicate
                    // logic that previously existed here.
                    if (isset($timezonesbyobjectid[$user->objectid]) && $timezonesbyobjectid[$user->objectid] !== false) {
                        try {
                            $result = $usersync->apply_timezone_public(
                                $user->muserid,
                                $timezonesbyobjectid[$user->objectid],
                                $user->currenttimezone
                            );
                            if ($result['changed']) {
                                $this->mtrace('User "' . $user->username . '": Timezone changed from ' .
                                    ($user->currenttimezone ?: '(not set)') . ' to ' . $result['timezone'] . '.', 2);
                                $batchtimezoneschanged++;
                            }
                        } catch (moodle_exception $e) {
                            $this->mtrace('User "' . $user->username . '": Error applying timezone - ' .
                                $e->getMessage(), 2);
                            utils::debug($e->getMessage(), __METHOD__, $e);
                        }
                    }
                }
            }

            // Update totals.
            $totalphotoschanged += $batchphotoschanged;
            $totaltimezoneschanged += $batchtimezoneschanged;

            // Show batch summary.
            if ($photosyncenabled) {
                $this->mtrace('Batch photos changed: ' . $batchphotoschanged, 1);
            }
            if ($tzsynceenabled) {
                $this->mtrace('Batch timezones changed: ' . $batchtimezoneschanged, 1);
            }

            $this->mtrace('');

            // Save progress after each batch (for resumability).
            $progressdata = [
                'batch' => $batchnum + 1,
                'photos_changed' => $totalphotoschanged,
                'timezones_changed' => $totaltimezoneschanged,
                'photos_requested' => $totalusersforphotosync,
                'tz_users' => $totalusersfortzsync,
                'timestamp' => time(),
            ];
            set_config('photosync_progress', json_encode($progressdata), 'local_o365');

            // Free memory.
            unset($users, $photosbyobjectid, $storedphotohashes, $timezonesbyobjectid);
            unset($objectidsforphotosync, $objectidsfortzsync, $apiclient);
            gc_collect_cycles();
        }

        // Clear progress tracking (sync completed successfully).
        unset_config('photosync_progress', 'local_o365');

        // Show final summary.
        $this->mtrace('=== Summary ===');

        if ($photosyncenabled) {
            $this->mtrace('Total users for photo sync: ' . $totalusersforphotosync);
            $this->mtrace('Total photos changed: ' . $totalphotoschanged);
        }

        if ($tzsynceenabled) {
            $this->mtrace('Total users for timezone sync: ' . $totalusersfortzsync);
            $this->mtrace('Total timezones changed: ' . $totaltimezoneschanged);
        }

        $this->mtrace('');
        $this->mtrace('Photo and timezone sync completed.');

        return true;
    }
}
