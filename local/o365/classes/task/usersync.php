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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365\task;

/**
 * Scheduled task to sync users with AAD.
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
    protected function parse_deltalink($deltalink) {
        $deltalink = parse_url($deltalink);
        if (isset($deltalink['query'])) {
            $output = [];
            parse_str($deltalink['query'], $output);
            if (isset($output['deltaLink'])) {
                return $output['deltaLink'];
            }
        }
        return null;
    }

    /**
     * Do the job.
     */
    public function execute() {
        $aadsyncenabled = get_config('local_o365', 'aadsync');
        if (empty($aadsyncenabled)) {
            mtrace('AAD sync disabled. Nothing to do.');
            return true;
        }

        $oidcconfig = get_config('auth_oidc');
        if (!empty($oidcconfig)) {
            $httpclient = new \local_o365\httpclient();
            $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret,
                    $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
            $resource = \local_o365\rest\azuread::get_resource();
            $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
            $azureadclient = new \local_o365\rest\azuread($token, $httpclient);

            $deltalink = get_config('local_o365', 'task_usersync_lastdeltalink');
            if (empty($deltalink)) {
                $deltalink = '';
            }

            for($i = 0; $i < 1; $i++) {
                $users = $azureadclient->get_users('default', $deltalink);
                if (!empty($users) && is_array($users) && !empty($users['value']) && is_array($users['value'])) {
                    $azureadclient->sync_users($users['value']);
                } else {
                    // No users returned, we're likely past the last page of results. Erase deltalink state and exit loop.
                    mtrace('No more users to sync.');
                    set_config('task_usersync_lastdeltalink', '', 'local_o365');
                    break;
                }

                // If we have an aad.nextLink, extract deltalink value and store in $deltalink for the next loop. Otherwise break.
                if (!empty($users['aad.nextLink'])) {
                    $deltalink = $this->parse_deltalink($users['aad.nextLink']);
                    if (empty($deltalink)) {
                        $deltalink = '';
                        mtrace('Bad aad.nextlink received.');
                        break;
                    }
                } else {
                    $deltalink = '';
                    mtrace('No aad.nextlink received.');
                    break;
                }
            }

            if (!empty($deltalink)) {
                mtrace('Partial user sync completed. Saving place for next run.');
            } else {
                mtrace('Full user sync completed. Resetting saved state for new run.');
            }
            set_config('task_usersync_lastdeltalink', $deltalink, 'local_o365');
        }
        return true;
    }
}