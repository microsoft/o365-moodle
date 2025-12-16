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
 * Microsoft Entra ID user sync scheduled task.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
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
 * Scheduled task to sync users with Microsoft Entra ID.
 */
class usersync extends scheduled_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_syncusers', 'local_o365');
    }

    /**
     * Get a stored token.
     *
     * @param string $name The token name.
     *
     * @return string|null The token, or null if empty/not found.
     */
    protected function get_token($name) {
        $token = get_config('local_o365', 'task_usersync_last' . $name);

        return (!empty($token)) ? $token : null;
    }

    /**
     * Store a token.
     *
     * @param string $name The token name.
     * @param string $value The token value.
     */
    protected function store_token($name, $value) {
        if (empty($value)) {
            $value = '';
        }

        set_config('task_usersync_last' . $name, $value, 'local_o365');
    }

    /**
     * Print debugging information using mtrace.
     *
     * @param string $msg
     */
    protected function mtrace($msg) {
        mtrace('...... ' . $msg);
    }

    /**
     * Do the job.
     */
    public function execute() {
        if (utils::is_connected() !== true) {
            $this->mtrace('Microsoft 365 not configured');

            return false;
        }

        if (main::is_enabled() !== true) {
            $this->mtrace('Microsoft Entra ID user sync disabled. Nothing to do.');

            return true;
        }

        $this->mtrace('Starting sync');
        raise_memory_limit(MEMORY_HUGE);

        $usersync = new main();

        // Do not time out when syncing users.
        @set_time_limit(0);

        $fullsyncfailed = false;
        $totalusersprocessed = 0;

        // Determine binding username claim once.
        $bindingusernameclaim = $this->get_binding_username_claim();

        // Create a callback to process users in batches.
        $processcallback = function ($userbatch) use ($usersync, $bindingusernameclaim) {
            $this->mtrace(count($userbatch) . ' users in batch. Syncing...');
            $this->sync_users($usersync, $userbatch, $bindingusernameclaim);
        };

        if (main::sync_option_enabled('nodelta') === true) {
            $this->mtrace('Forcing full sync.');
            $this->mtrace('Contacting Microsoft Entra ID...');
            $this->mtrace('Processing users in batches of 500...');

            try {
                $totalusersprocessed = $usersync->process_users_batched($processcallback);
                $this->mtrace('Total users processed: ' . $totalusersprocessed);
            } catch (moodle_exception $e) {
                $fullsyncfailed = true;
                $this->mtrace('Error in full usersync: ' . $e->getMessage());
                utils::debug($e->getMessage(), __METHOD__, $e);
            }

            $this->mtrace('Completed processing from Microsoft Entra ID');
        } else {
            $deltatoken = $this->get_token('deltatoken');
            if (!empty($deltatoken)) {
                $this->mtrace('Using deltatoken.');
            } else {
                $this->mtrace('No deltatoken stored.');
            }

            $this->mtrace('Using delta sync.');
            $this->mtrace('Contacting Microsoft Entra ID...');
            $this->mtrace('Processing users in batches of 500...');

            try {
                [$totalusersprocessed, $deltatoken, $fieldsmappingchanged] = $usersync->process_users_delta_batched(
                    $processcallback,
                    'default',
                    $deltatoken
                );
                if ($fieldsmappingchanged) {
                    $this->mtrace('Field mappings changed. Invalidating delta token and starting fresh sync.');
                }
                $this->mtrace('Total users processed: ' . $totalusersprocessed);
            } catch (moodle_exception $e) {
                $this->mtrace('Error in delta usersync: ' . $e->getMessage());
                utils::debug($e->getMessage(), __METHOD__, $e);
                $this->mtrace('Resetting delta tokens.');
                $deltatoken = null;
            }

            $this->mtrace('Completed processing from Microsoft Entra ID');

            // Store deltatoken.
            if (!empty($deltatoken)) {
                $this->mtrace('Storing deltatoken');
            } else {
                $this->mtrace('Clearing deltatoken (none received)');
            }

            $this->store_token('deltatoken', $deltatoken);
        }

        if (main::sync_option_enabled('suspend') || main::sync_option_enabled('reenable')) {
            $lastrundate = get_config('local_o365', 'task_usersync_lastdelete');
            $rundelete = true;
            $alreadyruntoday = false;

            if (strlen($lastrundate) == 10) {
                $lastrundate = false;
            }

            if ($lastrundate && $lastrundate >= date('Ymd')) {
                $alreadyruntoday = true;
                $rundelete = false;
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
                    $rundelete = false;
                }
            }

            if ($lastrundate != false) {
                if (date('Ymd') <= $lastrundate) {
                    $rundelete = false;
                    $this->mtrace('Suspend/delete users feature skipped because it was run less than 1 day ago.');
                }
            }

            if ($rundelete) {
                $this->mtrace('Start suspend/delete users feature...');

                // Suspend_users() requires the COMPLETE set of active Entra ID user IDs to identify
                // Moodle accounts that are absent from Entra ID (set-complement logic). Accumulating
                // all IDs is therefore unavoidable, but memory is bounded to one string ID per user
                // rather than a full user object. reenable_suspsend_users() only needs users that ARE
                // in Entra ID, so it is processed per batch to avoid any accumulation.
                $allentriduserids = [];
                $dosuspend = main::sync_option_enabled('suspend');
                $doreenable = main::sync_option_enabled('reenable');
                $syncdisabledstatus = main::sync_option_enabled('disabledsync');

                // Fetch minimal fields (id + accountEnabled) for all Entra ID users.
                // This runs for both nodelta and delta modes: nodelta never populates $allentriduserids
                // via the top-level sync, so a separate minimal fetch is always required here.
                $this->mtrace('Collecting user IDs for suspend/reenable feature...');
                try {
                    $batchcallback = function (array $userbatch) use (
                        &$allentriduserids,
                        $usersync,
                        $doreenable,
                        $syncdisabledstatus
                    ) {
                        // Accumulate only the ID string — not the full user object.
                        foreach ($userbatch as $user) {
                            $allentriduserids[] = $user['id'];
                        }
                        // Re-enable per batch: no need for the complete set.
                        if ($doreenable) {
                            $usersync->reenable_suspsend_users($userbatch, $syncdisabledstatus);
                        }
                    };
                    $totalcollected = $usersync->process_users_minimal_batched($batchcallback);
                    $this->mtrace('Collected ' . $totalcollected . ' user IDs for suspend/reenable.');
                } catch (moodle_exception $e) {
                    $fullsyncfailed = true;
                    $this->mtrace('Error collecting users for suspend/reenable: ' . $e->getMessage());
                    utils::debug($e->getMessage(), __METHOD__, $e);
                }

                if ($fullsyncfailed) {
                    $this->mtrace('Full user sync failed, skip suspending users...');
                } else {
                    if ($dosuspend) {
                        $this->mtrace('Suspending deleted users...');
                        $usersync->suspend_users($allentriduserids, main::sync_option_enabled('delete'));
                    }
                    if ($doreenable) {
                        $this->mtrace('Re-enabling suspended users (processed per batch above).');
                    }
                }
            }
        }

        $this->mtrace('Sync process finished.');

        return true;
    }

    /**
     * Get the binding username claim to use for user sync.
     * Outputs a trace message once with the determined claim.
     *
     * @return string The Graph API field name to use for binding
     */
    protected function get_binding_username_claim(): string {
        global $CFG;

        require_once($CFG->dirroot . '/auth/oidc/lib.php');

        $bindingusernameclaim = auth_oidc_get_binding_username_claim();
        switch ($bindingusernameclaim) {
            case 'upn':
                $this->mtrace('Binding username claim: userPrincipalName.');
                $bindingusernameclaim = 'userPrincipalName';
                break;
            case 'oid':
                $this->mtrace('Binding username claim: id.');
                $bindingusernameclaim = 'id';
                break;
            case 'samaccountname':
                $this->mtrace('Binding username claim: onPremisesSamAccountName.');
                $bindingusernameclaim = 'onPremisesSamAccountName';
                break;
            case 'email':
                $this->mtrace('Binding username claim: mail.');
                $bindingusernameclaim = 'mail';
                break;
            case 'auto':
                $this->mtrace('Binding username claim: auto-detected. Use userPrincipalName.');
                $bindingusernameclaim = 'userPrincipalName';
                break;
            case 'unique_name':
            case 'sub':
            case 'preferred_username':
                $this->mtrace('Binding user claim "' . $bindingusernameclaim . '" is unavailable in Graph user resource. ' .
                    'Fall back to userPrincipalName.');
                $bindingusernameclaim = 'userPrincipalName';
                break;
            default:
                $this->mtrace('Unsupported binding username claim: ' . $bindingusernameclaim .
                    '. Fall back to userPrincipalName.');
                $bindingusernameclaim = 'userPrincipalName';
        }

        return $bindingusernameclaim;
    }

    /**
     * Sync a batch of users.
     *
     * @param main $usersync
     * @param array $users
     * @param string $bindingusernameclaim The Graph API field name to use for binding
     */
    protected function sync_users($usersync, $users, $bindingusernameclaim) {
        $usersync->sync_users($users, $bindingusernameclaim);
    }
}
