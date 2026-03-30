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

        // Get photo expiration setting (in hours).
        $photoexpire = get_config('local_o365', 'photoexpire');
        if (empty($photoexpire) || !is_numeric($photoexpire)) {
            $photoexpire = 24;
        }
        $photoexpiresec = $photoexpire * 3600;
        $currenttime = time();

        if (main::sync_option_enabled('photosync')) {
            $this->mtrace('Photo expiry: ' . $photoexpire . ' hours.', 1);
        }

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
        $totaluserswithstalephotos = 0;
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
                $totaluserswithstalephotos = $progressdata['stale_photos'] ?? 0;
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

            // Fetch batch of users.
            $sql = "SELECT obj.moodleid AS muserid,
                           obj.o365name AS upn,
                           u.username,
                           u.picture AS currentpicture,
                           u.timezone AS currenttimezone,
                           assign.id AS appassignid,
                           assign.photoid,
                           assign.photoupdated
                      FROM {local_o365_objects} obj
                      JOIN {user} u ON u.id = obj.moodleid
                 LEFT JOIN {local_o365_appassign} assign ON assign.muserid = obj.moodleid
                     WHERE obj.type = 'user'
                       AND u.deleted = 0
                       AND u.suspended = 0
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
            $upnsforphotosync = [];
            $upnsfortzsync = [];

            foreach ($users as $user) {
                // Check if photo needs updating (is stale).
                if ($photosyncenabled) {
                    $photoisstale = (
                        empty($user->photoupdated) ||
                        ($user->photoupdated + $photoexpiresec) < $currenttime
                    );

                    if ($photoisstale) {
                        $upnsforphotosync[] = $user->upn;
                    }
                }

                // Always sync timezone if enabled (no expiration check for timezone).
                if ($tzsynceenabled) {
                    $upnsfortzsync[] = $user->upn;
                }
            }

            if ($photosyncenabled) {
                $this->mtrace('Users with stale photos: ' . count($upnsforphotosync), 1);
                $totaluserswithstalephotos += count($upnsforphotosync);
            }

            if ($tzsynceenabled) {
                $this->mtrace('Users for timezone sync: ' . count($upnsfortzsync), 1);
                $totalusersfortzsync += count($upnsfortzsync);
            }

            // Construct the API client once per batch. Both the timezone and photo
            // fetches share the same client so we pay the token lookup cost only once.
            $apiclient = null;

            // Batch fetch timezones for users that need it.
            $timezonesbyupn = [];
            if ($tzsynceenabled && !empty($upnsfortzsync) && !PHPUNIT_TEST && !defined('BEHAT_SITE_RUNNING')) {
                try {
                    $this->mtrace('Fetching timezones...', 1);
                    $apiclient = $usersync->construct_user_api();
                    $timezonesbyupn = $apiclient->get_timezones_batch($upnsfortzsync);
                    $this->mtrace('Fetched ' . count(array_filter($timezonesbyupn)) . ' timezones from API.', 2);
                } catch (moodle_exception $e) {
                    $this->mtrace('Error fetching timezones: ' . $e->getMessage(), 1);
                    utils::debug($e->getMessage(), __METHOD__, $e);
                }
            }

            // Batch fetch photos only for users with stale photos.
            $photosbyupn = [];
            if ($photosyncenabled && !empty($upnsforphotosync) && !PHPUNIT_TEST && !defined('BEHAT_SITE_RUNNING')) {
                try {
                    $this->mtrace('Fetching photos...', 1);
                    if ($apiclient === null) {
                        $apiclient = $usersync->construct_user_api();
                    }
                    $photosbyupn = $apiclient->get_photos_batch($upnsforphotosync);
                    $this->mtrace('Fetched ' . count(array_filter($photosbyupn)) . ' photos from API.', 2);
                } catch (moodle_exception $e) {
                    $this->mtrace('Error fetching photos: ' . $e->getMessage(), 1);
                    utils::debug($e->getMessage(), __METHOD__, $e);
                }
            }

            // Apply photos and timezones to users in this batch.
            $batchphotoschanged = 0;
            $batchtimezoneschanged = 0;

            if ($photosyncenabled && !empty($photosbyupn)) {
                $this->mtrace('Applying photos...', 1);

                foreach ($users as $user) {
                    // Apply photo if available.
                    if (isset($photosbyupn[$user->upn]) && $photosbyupn[$user->upn] !== false) {
                        try {
                            $usersync->apply_photo_public(
                                $user->muserid,
                                $photosbyupn[$user->upn],
                                $user->appassignid ?? null,
                                $user->currentpicture ?? null
                            );
                            $this->mtrace('User "' . $user->username . '": Photo changed.', 2);
                            $batchphotoschanged++;
                        } catch (moodle_exception $e) {
                            $this->mtrace('User "' . $user->username . '": Error applying photo - ' .
                                $e->getMessage(), 2);
                            utils::debug($e->getMessage(), __METHOD__, $e);
                        }
                    }
                }
            }

            if ($tzsynceenabled && !empty($timezonesbyupn)) {
                $this->mtrace('Applying timezones...', 1);

                foreach ($users as $user) {
                    // Apply timezone if available. Pass the current timezone from the batch
                    // query so apply_timezone_public can short-circuit without fetching the
                    // full user record when the value has not changed. Normalisation and the
                    // Etc/GMT mapping live only in apply_timezone, eliminating the duplicate
                    // logic that previously existed here.
                    if (isset($timezonesbyupn[$user->upn]) && $timezonesbyupn[$user->upn] !== false) {
                        try {
                            $changed = $usersync->apply_timezone_public(
                                $user->muserid,
                                $timezonesbyupn[$user->upn],
                                $user->currenttimezone
                            );
                            if ($changed) {
                                $newtz = $timezonesbyupn[$user->upn]['value'] ?? '';
                                $this->mtrace('User "' . $user->username . '": Timezone changed from ' .
                                    ($user->currenttimezone ?: '(not set)') . ' to ' . $newtz . '.', 2);
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
                'stale_photos' => $totaluserswithstalephotos,
                'tz_users' => $totalusersfortzsync,
                'timestamp' => time(),
            ];
            set_config('photosync_progress', json_encode($progressdata), 'local_o365');

            // Free memory.
            unset($users, $photosbyupn, $timezonesbyupn, $upnsforphotosync, $upnsfortzsync, $apiclient);
            gc_collect_cycles();
        }

        // Clear progress tracking (sync completed successfully).
        unset_config('photosync_progress', 'local_o365');

        // Show final summary.
        $this->mtrace('=== Summary ===');

        if ($photosyncenabled) {
            $this->mtrace('Total users with stale photos: ' . $totaluserswithstalephotos);
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
