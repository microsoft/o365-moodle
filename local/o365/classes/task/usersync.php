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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

/**
 * Scheduled task to sync users with Azure AD.
 */
class usersync extends \core\task\scheduled_task {
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
     * @return string|null The token, or null if empty/not found.
     */
    protected function get_token($name) {
        $token = get_config('local_o365', 'task_usersync_last'.$name);
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
        set_config('task_usersync_last'.$name, $value, 'local_o365');
    }

    protected function mtrace($msg) {
        mtrace('...... '.$msg);
    }

    /**
     * Do the job.
     */
    public function execute() {
        if (\local_o365\utils::is_configured() !== true) {
            $this->mtrace('Office 365 not configured');
            return false;
        }

        if (\local_o365\feature\usersync\main::is_enabled() !== true) {
            $this->mtrace('Azure AD cron sync disabled. Nothing to do.');
            return true;
        }
        $this->mtrace('Starting sync');

        $usersync = new \local_o365\feature\usersync\main();

        if ($usersync->sync_option_enabled('nodelta') === true) {
            $skiptoken = $this->get_token('skiptokenfull');
            if (!empty($skiptoken)) {
                $this->mtrace('Using skiptoken (full)');
            } else {
                $this->mtrace('No skiptoken (full) stored.');
            }

            $this->mtrace('Forcing full sync.');
            $this->mtrace('Contacting Azure AD...');
            try {
                list($users, $skiptoken) = $usersync->get_users('default', $skiptoken);
            } catch (\Exception $e) {
                $this->mtrace('Error in full usersync: '.$e->getMessage());
                \local_o365\utils::debug($e->getMessage(), 'usersync task', $e);
                $this->mtrace('Resetting skip and delta tokens.');
                $skiptoken = null;
            }
            $this->mtrace('Got response from Azure AD');

            // Store skiptoken.
            if (!empty($skiptoken)) {
                $this->mtrace('Storing skiptoken (full)');
            } else {
                $this->mtrace('Clearing skiptoken (full) (none received)');
            }
            $this->store_token('skiptokenfull', $skiptoken);
        } else {
            $skiptoken = $this->get_token('skiptokendelta');
            if (!empty($skiptoken)) {
                $this->mtrace('Using skiptoken (delta)');
            } else {
                $this->mtrace('No skiptoken (delta) stored.');
            }

            $deltatoken = $this->get_token('deltatoken');
            if (!empty($deltatoken)) {
                $this->mtrace('Using deltatoken.');
            } else {
                $this->mtrace('No deltatoken stored.');
            }

            $this->mtrace('Using delta sync.');
            $this->mtrace('Contacting Azure AD...');
            try {
                list($users, $skiptoken, $deltatoken) = $usersync->get_users_delta('default', $skiptoken, $deltatoken);
            } catch (\Exception $e) {
                $this->mtrace('Error in delta usersync: '.$e->getMessage());
                \local_o365\utils::debug($e->getMessage(), 'usersync task', $e);
                $this->mtrace('Resetting skip and delta tokens.');
                $skiptoken = null;
                $deltatoken = null;
            }

            $this->mtrace('Got response from Azure AD');

            // Store deltatoken.
            if (!empty($deltatoken)) {
                $this->mtrace('Storing deltatoken');
            } else {
                $this->mtrace('Clearing deltatoken (none received)');
            }
            $this->store_token('deltatoken', $deltatoken);

            // Store skiptoken.
            if (!empty($skiptoken)) {
                $this->mtrace('Storing skiptoken (delta)');
            } else {
                $this->mtrace('Clearing skiptoken (delta) (none received)');
            }
            $this->store_token('skiptokendelta', $skiptoken);
        }

        if (!empty($users)) {
            $this->mtrace(count($users).' users received. Syncing...');
            $usersync->sync_users($users);
        } else {
            $this->mtrace('No users received to sync.');
        }

        $this->mtrace('Sync process finished.');
        return true;
    }
}
