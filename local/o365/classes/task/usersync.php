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
     * Extract a deltalink value from a full aad.nextLink URL.
     *
     * @param string $deltalink A full aad.nextLink URL.
     * @return string|null The extracted deltalink value, or null if none found.
     */
    protected function extract_skiptoken($nextlink) {
        $nextlink = parse_url($nextlink);
        if (isset($nextlink['query'])) {
            $output = [];
            parse_str($nextlink['query'], $output);
            if (isset($output['$skiptoken'])) {
                return $output['$skiptoken'];
            }
        }
        return null;
    }

    /**
     * Do the job.
     */
    public function execute() {
        if (\local_o365\utils::is_configured() !== true) {
            return false;
        }

        $aadsyncenabled = get_config('local_o365', 'aadsync');
        if (empty($aadsyncenabled) || $aadsyncenabled === 'photosynconlogin') {
            mtrace('Azure AD cron sync disabled. Nothing to do.');
            return true;
        }

        $httpclient = new \local_o365\httpclient();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $usersync = new \local_o365\feature\usersync\main($clientdata, $httpclient);

        $skiptoken = get_config('local_o365', 'task_usersync_lastskiptoken');
        if (empty($skiptoken)) {
            $skiptoken = '';
        }

        for ($i = 0; $i < 5; $i++) {
            $users = $usersync->get_users('default', $skiptoken);
            if (!empty($users) && is_array($users) && !empty($users['value']) && is_array($users['value'])) {
                $usersync->sync_users($users['value']);
            } else {
                // No users returned, we're likely past the last page of results. Erase deltalink state and exit loop.
                mtrace('No more users to sync. Resetting for new run.');
                set_config('task_usersync_lastskiptoken', '', 'local_o365');
                return true;
            }

            $nextlink = '';
            if (isset($users['odata.nextLink'])) {
                $nextlink = $users['odata.nextLink'];
            } else if (isset($users['@odata.nextLink'])) {
                $nextlink = $users['@odata.nextLink'];
            }

            // If we have an odata.nextLink, extract deltalink value and store in $deltalink for the next loop. Otherwise break.
            if (!empty($nextlink)) {
                $skiptoken = $this->extract_skiptoken($nextlink);
                if (empty($skiptoken)) {
                    $skiptoken = '';
                    mtrace('Bad odata.nextLink received.');
                    break;
                }
            } else {
                $skiptoken = '';
                mtrace('No odata.nextLink received.');
                break;
            }
        }

        if (!empty($skiptoken)) {
            mtrace('Partial user sync completed. Saving place for next run.');
        } else {
            mtrace('Full user sync completed. Resetting saved state for new run.');
        }
        set_config('task_usersync_lastskiptoken', $skiptoken, 'local_o365');
        return true;
    }
}
