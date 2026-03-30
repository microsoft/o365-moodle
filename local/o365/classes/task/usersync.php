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
use local_o365\rest\unified;
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

        if (main::is_enabled() !== true) {
            $this->mtrace('Microsoft Entra ID user sync disabled. Nothing to do.');

            return true;
        }

        $this->mtrace('Starting sync.');
        raise_memory_limit(MEMORY_HUGE);

        $usersync = new main();

        // Do not time out when syncing users.
        @set_time_limit(0);

        $totalusersprocessed = 0;

        // Determine binding username claim once.
        $bindingusernameclaim = $this->get_binding_username_claim();

        // Display sync settings.
        $this->display_sync_settings();

        // Display field mappings.
        $this->display_field_mappings();

        // Announce sync type first.
        $deltatoken = null;
        if (main::sync_option_enabled('nodelta') === true) {
            $this->mtrace('Forcing full sync.', 1);
        } else {
            $deltatoken = $this->get_token('deltatoken');
            if (!empty($deltatoken)) {
                $this->mtrace('Using deltatoken.', 1);
            } else {
                $this->mtrace('No deltatoken stored.', 1);
            }
            $this->mtrace('Using delta sync.', 1);
        }

        // List users batch size.
        $this->mtrace('Graph API list users batch size: ' . unified::GRAPH_API_BATCH_SIZE . '.', 1);

        // Initialize sync cache ONCE before batch processing to avoid redundant queries.
        $this->mtrace('');
        $this->mtrace('Initializing user sync cache...');
        $synccache = $usersync->init_sync_cache($bindingusernameclaim);
        $this->mtrace('User sync cache initialized.');
        $this->mtrace('');

        $batchnumber = 0;

        // Create a callback to process users in batches.
        $processcallback = function ($userbatch) use ($usersync, $synccache, $bindingusernameclaim, &$batchnumber) {
            $batchnumber++;

            $this->mtrace('Batch ' . $batchnumber . ': ' . count($userbatch) . ' users.');
            $usersync->sync_users_with_cache($userbatch, $synccache, $bindingusernameclaim);
            $this->mtrace('');
        };

        if (main::sync_option_enabled('nodelta') === true) {
            try {
                $totalusersprocessed = $usersync->process_users_batched($processcallback);
                $this->mtrace('Total users processed: ' . $totalusersprocessed);
                $this->mtrace('');
            } catch (moodle_exception $e) {
                $this->mtrace('Error in full usersync: ' . $e->getMessage());
                utils::debug($e->getMessage(), __METHOD__, $e);
            }
        } else {
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
                $this->mtrace('');
            } catch (moodle_exception $e) {
                $this->mtrace('Error in delta usersync: ' . $e->getMessage());
                utils::debug($e->getMessage(), __METHOD__, $e);
                $this->mtrace('Resetting delta tokens.');
                $deltatoken = null;
            }

            // Store deltatoken.
            if (!empty($deltatoken)) {
                $this->mtrace('Storing deltatoken');
            } else {
                $this->mtrace('Clearing deltatoken (none received)');
            }

            $this->store_token('deltatoken', $deltatoken);
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
                $this->mtrace('Binding username claim: userPrincipalName.', 1);
                $bindingusernameclaim = 'userPrincipalName';
                break;
            case 'oid':
                $this->mtrace('Binding username claim: id.', 1);
                $bindingusernameclaim = 'id';
                break;
            case 'samaccountname':
                $this->mtrace('Binding username claim: onPremisesSamAccountName.', 1);
                $bindingusernameclaim = 'onPremisesSamAccountName';
                break;
            case 'email':
                $this->mtrace('Binding username claim: mail.', 1);
                $bindingusernameclaim = 'mail';
                break;
            case 'auto':
                $this->mtrace('Binding username claim: auto-detected. Use userPrincipalName.', 1);
                $bindingusernameclaim = 'userPrincipalName';
                break;
            case 'unique_name':
            case 'sub':
            case 'preferred_username':
                $this->mtrace('Binding user claim "' . $bindingusernameclaim . '" is unavailable in Graph user resource. ' .
                    'Fall back to userPrincipalName.', 1);
                $bindingusernameclaim = 'userPrincipalName';
                break;
            default:
                $this->mtrace('Unsupported binding username claim: ' . $bindingusernameclaim .
                    '. Fall back to userPrincipalName.', 1);
                $bindingusernameclaim = 'userPrincipalName';
        }

        return $bindingusernameclaim;
    }

    /**
     * Display user sync settings.
     */
    protected function display_sync_settings() {
        $syncoptions = main::get_sync_options();

        if (empty($syncoptions)) {
            $this->mtrace('No sync options enabled.', 1);
            return;
        }

        $this->mtrace('Sync options:', 1);

        foreach ($syncoptions as $option => $value) {
            // Skip photo and timezone sync - they're handled by separate task.
            if ($option === 'photosync' || $option === 'tzsync') {
                continue;
            }

            // Skip status sync options - they're handled by separate task.
            if ($option === 'suspend' || $option === 'reenable' || $option === 'delete' || $option === 'disabledsync') {
                continue;
            }

            // Try to get the language string for this option.
            $stringkey = 'settings_usersync_' . $option;
            if (get_string_manager()->string_exists($stringkey, 'local_o365')) {
                $description = get_string($stringkey, 'local_o365');
                $this->mtrace($option . ' - ' . $description, 2);
            } else {
                // Fallback if no language string exists.
                $this->mtrace($option, 2);
            }
        }
    }

    /**
     * Display configured field mappings that apply during user sync task.
     */
    protected function display_field_mappings() {
        global $CFG;

        require_once($CFG->dirroot . '/auth/oidc/lib.php');

        if (PHPUNIT_TEST || defined('BEHAT_SITE_RUNNING')) {
            return; // Skip in test environments.
        }

        $fieldmappings = auth_oidc_get_field_mappings();

        if (empty($fieldmappings)) {
            $this->mtrace('No field mappings configured.', 1);
            return;
        }

        $this->mtrace('Field mappings:', 1);

        $displayedcount = 0;

        foreach ($fieldmappings as $localfield => $mapping) {
            if (empty($mapping['field_map'])) {
                continue; // Skip if no remote field mapped.
            }

            $updatebehavior = $mapping['update_local'] ?? 'always';

            // Only show mappings that apply during sync task (not 'onlogin').
            if ($updatebehavior === 'onlogin') {
                continue;
            }

            $remotefield = $mapping['field_map'];
            $this->mtrace($localfield . ' <- ' . $remotefield, 2);
            $displayedcount++;
        }

        if ($displayedcount === 0) {
            $this->mtrace('No field mappings apply during sync.', 2);
        }
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
