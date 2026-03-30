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
 * Microsoft Entra ID user enabled status sync scheduled task.
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
 * Scheduled task to sync user enabled status from Microsoft Entra ID (suspend/re-enable/delete users).
 */
class userenabledstatussync extends scheduled_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_userenabledstatussync', 'local_o365');
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
        if (utils::is_connected() !== true) {
            $this->mtrace('Microsoft 365 not configured');
            return false;
        }

        // Check if suspend or reenable is enabled.
        $dosuspend = main::sync_option_enabled('suspend');
        $doreenable = main::sync_option_enabled('reenable');
        $dodelete = main::sync_option_enabled('delete');

        if (!$dosuspend && !$doreenable) {
            $this->mtrace('User suspension and re-enable disabled. Nothing to do.');
            return true;
        }

        $this->mtrace('Starting user suspension/re-enable task.');
        $this->mtrace('');
        raise_memory_limit(MEMORY_HUGE);

        // Do not time out.
        @set_time_limit(0);

        // Check if this should run today based on configured time.
        $lastrundate = get_config('local_o365', 'task_usersync_lastdelete');
        $runtoday = true;
        $alreadyruntoday = false;

        if (strlen($lastrundate) == 10) {
            $lastrundate = false;
        }

        if ($lastrundate && $lastrundate >= date('Ymd')) {
            $alreadyruntoday = true;
            $runtoday = false;
        }

        if (!$alreadyruntoday) {
            $suspensiontaskhour = get_config('local_o365', 'usersync_suspension_h');
            $suspensiontaskminute = get_config('local_o365', 'usersync_suspension_m');
            if (!$suspensiontaskhour) {
                $suspensiontaskhour = 0;
            }

            if (!$suspensiontaskminute) {
                $suspensiontaskminute = 0;
            }

            $currenthour = date('H');
            $currentminute = date('i');
            if ($currenthour > $suspensiontaskhour) {
                set_config('task_usersync_lastdelete', date('Ymd'), 'local_o365');
            } else if (($currenthour == $suspensiontaskhour) && ($currentminute >= $suspensiontaskminute)) {
                set_config('task_usersync_lastdelete', date('Ymd'), 'local_o365');
            } else {
                $runtoday = false;
            }
        }

        if ($lastrundate != false) {
            if (date('Ymd') <= $lastrundate) {
                $runtoday = false;
                $this->mtrace('Skipped - already ran today (less than 1 day ago).');
            }
        }

        if (!$runtoday) {
            return true;
        }

        $this->mtrace('Checking for users to suspend/reenable...');

        $usersync = new main();
        $syncdisabledstatus = main::sync_option_enabled('disabledsync');

        $totalreenabled = 0;
        $totalsuspended = 0;
        $totaldeleted = 0;

        // For reenable, we need to process users with accountEnabled status.
        if ($doreenable) {
            try {
                $actualreenablecount = 0;
                $reenablecallback = function (array $userbatch) use (
                    $usersync,
                    $syncdisabledstatus,
                    &$actualreenablecount
                ) {
                    $actualreenablecount += $usersync->reenable_suspsend_users($userbatch, $syncdisabledstatus);
                };
                $usersync->process_users_minimal_batched($reenablecallback);
                $totalreenabled = $actualreenablecount;
                if ($actualreenablecount > 0) {
                    $this->mtrace('Re-enabled ' . $actualreenablecount . ' user(s).');
                }
            } catch (moodle_exception $e) {
                $this->mtrace('Error processing reenable: ' . $e->getMessage());
                utils::debug($e->getMessage(), __METHOD__, $e);
            }
        }

        // Process user suspension.
        // The suspend_users() method now queries the database directly and processes in batches
        // to handle 500K+ users efficiently without loading all IDs into memory.
        if ($dosuspend) {
            try {
                $result = $usersync->suspend_users($dodelete);
                if (!empty($result)) {
                    $totalsuspended = $result['suspended'] ?? 0;
                    $totaldeleted = $result['deleted'] ?? 0;
                }
            } catch (moodle_exception $e) {
                $this->mtrace('Error processing suspension: ' . $e->getMessage());
                utils::debug($e->getMessage(), __METHOD__, $e);
            }
        }

        // Always show summary at the end.
        $summaryparts = [];
        if ($totalreenabled > 0) {
            $summaryparts[] = 're-enabled ' . $totalreenabled;
        }
        if ($totalsuspended > 0) {
            $summaryparts[] = 'suspended ' . $totalsuspended;
        }
        if ($totaldeleted > 0) {
            $summaryparts[] = 'deleted ' . $totaldeleted;
        }

        if (!empty($summaryparts)) {
            $this->mtrace('Summary: ' . implode(', ', $summaryparts) . ' user(s).');
        } else {
            $this->mtrace('Summary: No changes made.');
        }

        $this->mtrace('');
        $this->mtrace('User suspension/re-enable task completed.');

        return true;
    }
}
