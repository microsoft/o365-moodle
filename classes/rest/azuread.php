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

namespace local_o365\rest;

/**
 * API client for AzureAD graph.
 */
class azuread extends \local_o365\rest\o365api {
    /**
     * Determine if the API client is configured.
     *
     * @return bool Whether the API client is configured.
     */
    public static function is_configured() {
        $config = get_config('local_o365');
        return (!empty($config->tenant)) ? true : false;
    }

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_resource() {
        return 'https://graph.windows.net';
    }

    /**
     * Transform the full request URL.
     *
     * @param string $requesturi The full request URI, includes the API uri and called endpoint.
     * @return string The transformed full request URI.
     */
    protected function transform_full_request_uri($requesturi) {
        $requesturi .= (strpos($requesturi, '?') === false) ? '?' : '&';
        $requesturi .= 'api-version=2013-04-05';
        return $requesturi;
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        $config = get_config('local_o365');
        if (!empty($config->tenant)) {
            return static::get_resource().'/'.$config->tenant.'.onmicrosoft.com';
        } else {
            return false;
        }
    }

    /**
     * Get all users in the configured directory.
     *
     * @param string|array $params Requested user parameters.
     * @return array|null Array of user information, or null if failure.
     */
    public function get_users($params = 'default') {
        $endpoint = "/users";
        if ($params === 'default') {
            $params = ['mail', 'city', 'country', 'department', 'givenName', 'surname', 'preferredLanguage'];
        }
        if (!empty($params) && is_array($params)) {
            $endpoint .= '?deltaLink=&$select='.implode(',', $params);
        }
        $response = $this->apicall('get', $endpoint);
        if (!empty($response)) {
            $response = @json_decode($response, true);
            if (!empty($response) && is_array($response)) {
                return $response;
            }
        }
        return null;
    }

    /**
     * Get a specific user's information.
     *
     * @param string $oid The user's object id.
     * @return array|null Array of user information, or null if failure.
     */
    public function get_user($oid) {
        $endpoint = "/users/{$oid}";
        $response = $this->apicall('get', $endpoint);
        if (!empty($response)) {
            $response = @json_decode($response, true);
            if (!empty($response) && is_array($response)) {
                return $response;
            }
        }
        return null;
    }

    /**
     * Create a Moodle user from AzureAD user data.
     *
     * @param array $aaddata Array of AzureAD user data.
     * @return \stdClass An object representing the created Moodle user.
     */
    public function create_user_from_aaddata($aaddata) {
        global $CFG;

        require_once($CFG->dirroot.'/user/profile/lib.php');
        require_once($CFG->dirroot.'/user/lib.php');

        $newuser = (object)[
            'auth' => 'oidc',
            'username' => trim(\core_text::strtolower($aaddata['objectId'])),
            'email' => $aaddata['mail'],
            'firstname' => $aaddata['givenName'],
            'lastname' => $aaddata['surname'],
            'city' => (isset($aaddata['city'])) ? $aaddata['city'] : '',
            'country' => (isset($aaddata['country'])) ? $aaddata['country'] : '',
            'department' => (isset($aaddata['department'])) ? $aaddata['department'] : '',
            'lang' => (isset($aaddata['preferredLanguage'])) ? substr($aaddata['preferredLanguage'], 0, 2) : 'en',
            'confirmed' => 1,
            'timecreated' => time(),
            'mnethostid' => $CFG->mnet_localhost_id,
        ];
        $password = null;
        $newuser->idnumber = $newuser->username;

        if (!empty($newuser->email)) {
            if (email_is_not_allowed($newuser->email)) {
                unset($newuser->email);
            }
        }

        if (empty($newuser->lang) || !get_string_manager()->translation_exists($newuser->lang)) {
            $newuser->lang = $CFG->lang;
        }

        $newuser->timemodified = $newuser->timecreated;
        $newuser->id = user_create_user($newuser, false, false);

        // Save user profile data.
        profile_save_data($newuser);

        $user = get_complete_user_data('id', $newuser->id);
        if (!empty($CFG->{'auth_'.$newuser->auth.'_forcechangepassword'})) {
            set_user_preference('auth_forcepasswordchange', 1, $user);
        }
        // Set the password.
        update_internal_user_password($user, $password);

        // Trigger event.
        \core\event\user_created::create_from_userid($newuser->id)->trigger();

        return $user;
    }

    /**
     * Sync AzureAD Moodle users with the configured AzureAD directory.
     *
     * @return bool Success/Failure
     */
    public function sync_users() {
        global $DB, $CFG;
        $users = $this->get_users();
        if (!empty($users) && is_array($users) && !empty($users['value'])) {
            $aadresource = static::get_resource();
            $sql = 'SELECT token.oidcuniqid, user.id, user.username
                      FROM {user} user
                      JOIN {auth_oidc_token} token ON user.username = token.username
                     WHERE user.auth = ? AND user.deleted = ? AND user.mnethostid = ? AND token.resource = ?';
            $params = ['oidc', '0', $CFG->mnet_localhost_id, $aadresource];
            $existingusers = $DB->get_records_sql($sql, $params);

            foreach ($users['value'] as $user) {
                if (!isset($existingusers[$user['objectId']])) {
                    try {
                        $this->create_user_from_aaddata($user);
                    } catch (\Exception $e) {
                        if (!PHPUNIT_TEST) {
                            mtrace('Could not create user with objectid '.$user['objectId']);
                        }
                    }
                }
                unset($existingusers[$user['objectId']]);
            }
        }
        return true;
    }

    /**
     * Get the AzureAD UPN of a connected Moodle user.
     *
     * @param \stdClass $user The Moodle user.
     * @return string|bool The user's AzureAD UPN, or false if failure.
     */
    public static function get_muser_upn($user) {
        global $DB;
        $now = time();

        if (is_numeric($user)) {
            $user = $DB->get_record('user', ['id' => $user]);
            if (empty($user)) {
                return false;
            }
        }

        // Get user UPN.
        $aaduserdata = $DB->get_record('local_o365_aaduserdata', ['muserid' => $user->id]);
        if (!empty($aaduserdata)) {
            return $aaduserdata->userupn;
        } else {
            // Get user data.
            $authoidcuserdata = $DB->get_record('auth_oidc_token', ['username' => $user->username]);
            if (empty($authoidcuserdata)) {
                // No data for the user in the OIDC token table. Can't proceed.
                return false;
            }
            $oidcconfig = get_config('auth_oidc');
            $httpclient = new \local_o365\httpclient();
            $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret,
                    $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
            $resource = static::get_resource();
            $token = \local_o365\oauth2\systemtoken::instance($resource, $clientdata, $httpclient);
            $aadapiclient = new \local_o365\rest\azuread($token, $httpclient);
            $rawaaduserdata = $aadapiclient->get_user($authoidcuserdata->oidcuniqid);
            if (!empty($rawaaduserdata) && isset($rawaaduserdata['objectId']) && isset($rawaaduserdata['userPrincipalName'])) {
                // Save user data.
                $aaduserdata = new \stdClass;
                $aaduserdata->muserid = $user->id;
                $aaduserdata->objectid = $rawaaduserdata['objectId'];
                $aaduserdata->userupn = $rawaaduserdata['userPrincipalName'];
                $aaduserdata->timecreated = $now;
                $aaduserdata->timemodified = $now;
                $aaduserdata->id = $DB->insert_record('local_o365_aaduserdata', $aaduserdata);
                return $aaduserdata->userupn;
            }
        }
        return false;
    }
}
