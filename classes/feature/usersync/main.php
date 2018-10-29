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

namespace local_o365\feature\usersync;

use \local_o365\oauth2\clientdata;
use \local_o365\httpclient;

class main {
    protected $clientdata = null;
    protected $httpclient = null;

    /**
     * Constructor
     *
     * @param clientdata $clientdata The client data to use for API construction.
     * @param httpclient $httpclient The HTTP client to use for API construction.
     */
    public function __construct(clientdata $clientdata = null, httpclient $httpclient = null) {
        $this->clientdata = (!empty($clientdata))
            ? $clientdata
            : clientdata::instance_from_oidc();

        $this->httpclient = (!empty($httpclient))
            ? $httpclient
            : new httpclient();
    }

    /**
     * Determine whether any sync-related options are enabled.
     *
     * @return bool Enabled/disabled.
     */
    public static function is_enabled() {
        $aadsyncenabled = get_config('local_o365', 'aadsync');
        if (empty($aadsyncenabled) || $aadsyncenabled === 'photosynconlogin') {
            return false;
        }
        return true;
    }

    /**
     * Construct a user API client, accounting for Microsoft Graph API presence, and fall back to system api user if desired.
     *
     * @param bool $forcelegacy If true, force using the legacy API.
     * @return \local_o365\rest\o365api|bool A constructed user API client (unified or legacy), or false if error.
     */
    public function construct_user_api($forcelegacy = false) {
        if ($forcelegacy === true) {
            $uselegacy = true;
        } else {
            $uselegacy = (\local_o365\rest\unified::is_configured() === true) ? false : true;
        }

        if ($uselegacy === true) {
            $resource = \local_o365\rest\azuread::get_resource();
            $token = \local_o365\oauth2\systemapiusertoken::instance(null, $resource, $this->clientdata, $this->httpclient);
            if (empty($token)) {
                throw new \Exception('No token available for usersync');
            }
            return new \local_o365\rest\azuread($token, $this->httpclient);
        } else {
            $resource = \local_o365\rest\unified::get_resource();
            $token = \local_o365\utils::get_app_or_system_token($resource, $this->clientdata, $this->httpclient);
            if (empty($token)) {
                throw new \Exception('No token available for usersync');
            }
            return new \local_o365\rest\unified($token, $this->httpclient);
        }
    }

    /**
     * Construct a outlook API client using the system API user.
     *
     * @param int $muserid The userid to get the outlook token for. Call with null to retrieve system token.
     * @param boolean $systemfallback Set to true to use system token as fall back.
     * @return \local_o365\rest\o365api|bool A constructed calendar API client (unified or legacy), or false if error.
     */
    public function construct_outlook_api($muserid, $systemfallback = true) {
        $unifiedconfigured = \local_o365\rest\unified::is_configured();
        if ($unifiedconfigured === true) {
            $resource = \local_o365\rest\unified::get_resource();
        } else {
            $resource = \local_o365\rest\outlook::get_resource();
        }

        $token = \local_o365\oauth2\token::instance($muserid, $resource, $this->clientdata, $this->httpclient);
        if (empty($token) && $systemfallback === true) {
            $token = ($unifiedconfigured === true)
                ? \local_o365\utils::get_app_or_system_token($resource, $this->clientdata, $this->httpclient)
                : \local_o365\oauth2\systemapiusertoken::instance(null, $resource, $this->clientdata, $this->httpclient);
        }
        if (empty($token)) {
            throw new \Exception('No token available for user #'.$muserid);
        }

        if ($unifiedconfigured === true) {
            $apiclient = new \local_o365\rest\unified($token, $this->httpclient);
        } else {
            $apiclient = new \local_o365\rest\outlook($token, $this->httpclient);
        }
        return $apiclient;
    }

    /**
     * Get information on the app.
     *
     * @return array|null Array of app service information, or null if failure.
     */
    public function get_application_serviceprincipal_info() {
        $apiclient = $this->construct_user_api(false);
        return $apiclient->get_application_serviceprincipal_info();
    }

    /**
     * Assign user to application.
     *
     * @param int $muserid The Moodle user ID.
     * @param string $userobjectid Object ID of user.
     * @return array|null Array of user information, or null if failure.
     */
    public function assign_user($muserid, $userobjectid) {
        global $DB;

        // Not supported in unit tests at the moment.
        if (PHPUNIT_TEST) {
            return null;
        }
        $this->mtrace('Assigning Moodle user '.$muserid.' (objectid '.$userobjectid.') to application');

        // Get object ID on first call.
        static $appobjectid = null;
        if (empty($objectid)) {
            $appinfo = $this->get_application_serviceprincipal_info();
            if (empty($appinfo)) {
                return null;
            }
            $appobjectid = (\local_o365\rest\unified::is_configured())
                ? $appinfo['value'][0]['id']
                : $appinfo['value'][0]['objectId'];
        }

        // Force using legacy api. Legacy assign user does not support app only access.
        $apiclient = $this->construct_user_api(true);
        $result = $apiclient->assign_user($muserid, $userobjectid, $appobjectid);
        if (!empty($result['odata.error'])) {
            $error = '';
            $code = '';
            if (!empty($result['odata.error']['code'])) {
                $code = $result['odata.error']['code'];
            }
            if (!empty($result['odata.error']['message']['value'])) {
                $error = $result['odata.error']['message']['value'];
            }
            $user = $DB->get_record('user', array('id' => $muserid));
            $this->mtrace('Error assigning users "'.$user->username.'" Reason: '.$code.' '.$error);
        } else {
            $this->mtrace('User assigned to application.');
        }
        return $result;
    }

    /**
     * Assign photo to Moodle user account.
     *
     * @param string|array $params Requested user parameters.
     * @param string $skiptoken A skiptoken param from a previous get_users query. For pagination.
     * @return boolean True on photo updated.
     */
    public function assign_photo($muserid, $user) {
        global $DB, $CFG, $PAGE;
        require_once("$CFG->libdir/gdlib.php");
        $record = $DB->get_record('local_o365_appassign', array('muserid' => $muserid));
        $photoid = '';
        if (!empty($record->photoid)) {
            $photoid = $record->photoid;
        }
        $result = false;
        $apiclient = $this->construct_outlook_api($muserid, true);
        if (empty($user)) {
            $o365user = \local_o365\obj\o365user::instance_from_muserid($muserid);
            $user = $o365user->upn;
        }
        $size = $apiclient->get_photo_metadata($user);
        $muser = $DB->get_record('user', array('id' => $muserid), 'id, picture', MUST_EXIST);
        $context = \context_user::instance($muserid, MUST_EXIST);
        // If there is no meta data, there is no photo.
        if (empty($size)) {
            // Profile photo has been deleted.
            if (!empty($muser->picture)) {
                // User has no photo. Deleting previous profile photo.
                $fs = \get_file_storage();
                $fs->delete_area_files($context->id, 'user', 'icon');
                $DB->set_field('user', 'picture', 0, array('id' => $muser->id));
            }
            $result = false;
        } else if ($size['@odata.mediaEtag'] !== $photoid) {
            if (!empty($size['height']) && !empty($size['width'])) {
                $image = $apiclient->get_photo($user, $size['height'], $size['width']);
            } else {
                $image = $apiclient->get_photo($user);
            }
            // Check if json error message was returned.
            if (!preg_match('/^{/', $image)) {
                // Update profile picture.
                $tempfile = tempnam($CFG->tempdir.'/', 'profileimage').'.jpg';
                if (!$fp = fopen($tempfile, 'w+b')) {
                    @unlink($tempfile);
                    return false;
                }
                fwrite($fp, $image);
                fclose($fp);
                $newpicture = process_new_icon($context, 'user', 'icon', 0, $tempfile);
                $photoid = $size['@odata.mediaEtag'];
                if ($newpicture != $muser->picture) {
                    $DB->set_field('user', 'picture', $newpicture, array('id' => $muser->id));
                    $result = true;
                }
                @unlink($tempfile);
            }
        }
        if (empty($record)) {
            $record = new \stdClass();
            $record->muserid = $muserid;
            $record->assigned = 0;
        }
        $record->photoid = $photoid;
        $record->photoupdated = time();
        if (empty($record->id)) {
            $DB->insert_record('local_o365_appassign', $record);
        } else {
            $DB->update_record('local_o365_appassign', $record);
        }
        return $result;
    }

    /**
     * Extract a parameter value from a URL.
     *
     * @param string $link A URL.
     * @param string $param Parameter name.
     * @return string|null The extracted deltalink value, or null if none found.
     */
    protected function extract_param_from_link($link, $param) {
        $link = parse_url($link);
        if (isset($link['query'])) {
            $output = [];
            parse_str($link['query'], $output);
            if (isset($output[$param])) {
                return $output[$param];
            }
        }
        return null;
    }

    /**
     * Get all users in the configured directory.
     *
     * @param string|array $params Requested user parameters.
     * @param string $skiptoken A skiptoken param from a previous get_users query. For pagination.
     * @return array|null Array of user information, or null if failure.
     */
    public function get_users($params = 'default', $skiptoken = '') {
        if (empty($skiptoken)) {
            $skiptoken = '';
        }

        $apiclient = $this->construct_user_api(false);
        $result = $apiclient->get_users($params, $skiptoken);
        $users = null;
        $skiptoken = null;

        if (!empty($result) && is_array($result)) {
            if (!empty($result['value']) && is_array($result['value'])) {
                $users = $result['value'];
            }

            if (isset($result['odata.nextLink'])) {
                $skiptoken = $this->extract_param_from_link($result['odata.nextLink'], '$skiptoken');
            } else if (isset($result['@odata.nextLink'])) {
                $skiptoken = $this->extract_param_from_link($result['@odata.nextLink'], '$skiptoken');
            }
        }

        return [$users, $skiptoken];
    }

    public function get_users_delta($params = 'default', $skiptoken = null, $deltatoken = null) {
        $resource = \local_o365\rest\unified::get_resource();
        $token = \local_o365\utils::get_app_or_system_token($resource, $this->clientdata, $this->httpclient);
        if (empty($token)) {
            throw new \Exception('No token available for usersync');
        }
        $apiclient = new \local_o365\rest\unified($token, $this->httpclient);
        return $apiclient->get_users_delta($params, $skiptoken, $deltatoken);
    }

    /**
     * Apply the configured field map.
     *
     * @param array $aaddata User data from Azure AD.
     * @param array $user Moodle user data.
     * @param string $eventtype 'login', or 'create'
     * @return array Modified Moodle user data.
     */
    public static function apply_configured_fieldmap(array $aaddata, \stdClass $user, $eventtype) {
        $fieldmaps = get_config('local_o365', 'fieldmap');
        if ($fieldmaps === false) {
            $fieldmaps = \local_o365\adminsetting\usersyncfieldmap::defaultmap();
        } else {
            $fieldmaps = @unserialize($fieldmaps);
            if (!is_array($fieldmaps)) {
                $fieldmaps = \local_o365\adminsetting\usersyncfieldmap::defaultmap();
            }
        }

        foreach ($fieldmaps as $fieldmap) {
            $fieldmap = explode('/', $fieldmap);
            if (count($fieldmap) !== 3) {
                continue;
            }
            list($remotefield, $localfield, $behavior) = $fieldmap;
            if ($behavior !== 'on'.$eventtype && $behavior !== 'always') {
                // Field mapping doesn't apply to this event type.
                continue;
            }
            if (isset($aaddata[$remotefield])) {
                if ($localfield !== "country") {
                    $user->$localfield = $aaddata[$remotefield];
                } else {
                    // Update country with two letter country code.
                    $incoming = strtoupper($aaddata[$remotefield]);
                    $countrymap = get_string_manager()->get_list_of_countries();
                    if (isset($countrymap[$incoming])) {
                        $countrycode = $incoming;
                    } else {
                        $countrycode = array_search($aaddata[$remotefield], get_string_manager()->get_list_of_countries());
                    }
                    $user->$localfield = (!empty($countrycode)) ? $countrycode : '';
                }
            }
        }

        // Lang cannot be longer than 2 chars.
        if (!empty($user->lang) && strlen($user->lang) > 2) {
            $user->lang = substr($user->lang, 0, 2);
        }

        return $user;
    }

    /**
     * Check the configured user creation restriction and determine whether a user can be created.
     *
     * @param array $aaddata Array of user data from Azure AD.
     * @return bool Whether the user can be created.
     */
    protected function check_usercreationrestriction($aaddata) {
        $restriction = get_config('local_o365', 'usersynccreationrestriction');
        if (empty($restriction)) {
            return true;
        }
        $restriction = @unserialize($restriction);
        if (empty($restriction) || !is_array($restriction)) {
            return true;
        }
        if (empty($restriction['remotefield']) || empty($restriction['value'])) {
            return true;
        }
        $useregex = (!empty($restriction['useregex'])) ? true : false;

        if ($restriction['remotefield'] === 'o365group') {
            if (\local_o365\rest\unified::is_configured() !== true) {
                \local_o365\utils::debug('graph api is not configured.', 'check_usercreationrestriction');
                return false;
            }

            try {
                $httpclient = new \local_o365\httpclient();
                $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
                $resource = \local_o365\rest\unified::get_resource();
                $token = \local_o365\utils::get_app_or_system_token($resource, $clientdata, $httpclient);
                $apiclient = new \local_o365\rest\unified($token, $httpclient);
            } catch (\Exception $e) {
                \local_o365\utils::debug('Could not construct graph api', 'check_usercreationrestriction', $e);
                return false;
            }

            try {
                $group = $apiclient->get_group_by_name($restriction['value']);
                if (empty($group) || !isset($group['id'])) {
                    \local_o365\utils::debug('Could not find group (1)', 'check_usercreationrestriction', $group);
                    return false;
                }
                $usersgroups = $apiclient->get_users_groups($group['id'],$aaddata['id']);
                foreach ($usersgroups['value'] as $usergroup) {
                    if ($group['id'] === $usergroup) {
                        return true;
                    }
                }
                return false;
            } catch (\Exception $e) {
                \local_o365\utils::debug('Could not find group (2)', 'check_usercreationrestriction', $e);
                return false;
            }
        } else {
            if (!isset($aaddata[$restriction['remotefield']])) {
                return false;
            }
            $fieldval = $aaddata[$restriction['remotefield']];
            $restrictionval = $restriction['value'];

            if ($useregex === true) {
                $count = @preg_match('/'.$restrictionval.'/', $fieldval, $matches);
                if (!empty($count)) {
                    return true;
                }
            } else {
                if ($fieldval === $restrictionval) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Create a Moodle user from Azure AD user data.
     *
     * @param array $aaddata Array of Azure AD user data.
     * @return \stdClass An object representing the created Moodle user.
     */
    public function create_user_from_aaddata($aaddata) {
        global $CFG, $DB;

        require_once($CFG->dirroot.'/user/profile/lib.php');
        require_once($CFG->dirroot.'/user/lib.php');

        $creationallowed = $this->check_usercreationrestriction($aaddata);
        if ($creationallowed !== true) {
            mtrace('Cannot create user because they do not meet the configured user creation restrictions.');
            return false;
        }

        // Locate country code.
        if (isset($aaddata['country'])) {
            $countries = get_string_manager()->get_list_of_countries(true, 'en');
            foreach ($countries as $code => $name) {
                if ($aaddata['country'] == $name) {
                    $aaddata['country'] = $code;
                }
            }
            if (strlen($aaddata['country']) > 2) {
                // Limit string to 2 chars to prevent sql error.
                $aaddata['country'] = substr($aaddata['country'], 0, 2);
            }
        }

        $newuser = (object)[
            'auth' => 'oidc',
            'username' => trim(\core_text::strtolower($aaddata['userPrincipalName'])),
            'confirmed' => 1,
            'timecreated' => time(),
            'mnethostid' => $CFG->mnet_localhost_id,
        ];

        $newuser = static::apply_configured_fieldmap($aaddata, $newuser, 'create');

        $password = null;
        if (!isset($newuser->idnumber)) {
            $newuser->idnumber = $newuser->username;
        }

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

        // Add o365 object.
        if (\local_o365\rest\unified::is_configured()) {
            $userobjectid = $aaddata['id'];
        } else {
            $userobjectid = $aaddata['objectId'];
        }
        $now = time();
        $userobjectdata = (object)[
            'type' => 'user',
            'subtype' => '',
            'objectid' => $userobjectid,
            'o365name' => $aaddata['userPrincipalName'],
            'moodleid' => $newuser->id,
            'tenant' => '',
            'timecreated' => $now,
            'timemodified' => $now,
        ];
        $userobjectdata->id = $DB->insert_record('local_o365_objects', $userobjectdata);

        // Trigger event.
        \core\event\user_created::create_from_userid($newuser->id)->trigger();

        return $user;
    }

    /**
     * Updates a Moodle user from Azure AD user data.
     *
     * @param array $aaddata Array of Azure AD user data.
     * @return \stdClass An object representing the created Moodle user.
     */
    public function update_user_from_aaddata($aaddata, $fullexistinguser) {
        global $CFG, $DB;

        require_once($CFG->dirroot.'/user/profile/lib.php');
        require_once($CFG->dirroot.'/user/lib.php');

        // Locate country code.
        if (isset($aaddata['country'])) {
            $countries = get_string_manager()->get_list_of_countries(true, 'en');
            foreach ($countries as $code => $name) {
                if ($aaddata['country'] == $name) {
                    $aaddata['country'] = $code;
                }
            }
            if (strlen($aaddata['country']) > 2) {
                // Limit string to 2 chars to prevent sql error.
                $aaddata['country'] = substr($aaddata['country'], 0, 2);
            }
        }

        $existinguser = static::apply_configured_fieldmap($aaddata, $fullexistinguser, 'login');

        if (!empty($existinguser->email)) {
            if (email_is_not_allowed($existinguser->email)) {
                unset($existinguser->email);
            }
        } else {
            // Email is originally pulled (optionally) from UPN, so an empty email should not wipe out Moodle email.
            unset($existinguser->email);
        }

        $existinguser->timemodified = time();

        // Update a user with a user object (will compare against the ID).
        user_update_user($existinguser, false, false);

        // Save user profile data.
        profile_save_data($existinguser);

        // Trigger event.
        \core\event\user_updated::create_from_userid($existinguser->id)->trigger();

        return true;
    }

    /**
     * Selectively run mtrace.
     *
     * @param string $msg The message.
     */
    public static function mtrace($msg) {
        if (!PHPUNIT_TEST) {
            mtrace('......... '.$msg);
        }
    }

    /**
     * Get an array of sync options.
     *
     * @return array Sync options
     */
    public static function get_sync_options() {
        $aadsync = get_config('local_o365', 'aadsync');
        $aadsync = array_flip(explode(',', $aadsync));
        return $aadsync;
    }

    /**
     * Determine whether a sync option is enabled.
     *
     * @param string $option The option to check.
     * @return bool Whether the option is enabled.
     */
    public static function sync_option_enabled($option) {
        $options = static::get_sync_options();
        return (!empty($options[$option])) ? true : false;
    }

    /**
     * Sync Azure AD Moodle users with the configured Azure AD directory.
     *
     * @param array $aadusers Array of Azure AD users from $this->get_users().
     * @return bool Success/Failure
     */
    public function sync_users(array $aadusers = array()) {
        global $DB, $CFG;

        $aadsync = $this->get_sync_options();
        $switchauthminupnsplit0 = get_config('local_o365', 'switchauthminupnsplit0');
        if (empty($switchauthminupnsplit0)) {
            $switchauthminupnsplit0 = 10;
        }

        $usernames = [];
        $upns = [];
        foreach ($aadusers as $i => $user) {
            $upnlower = \core_text::strtolower($user['userPrincipalName']);
            $aadusers[$i]['upnlower'] = $upnlower;

            $usernames[] = $upnlower;
            $upns[] = $upnlower;

            $upnsplit = explode('@', $upnlower);
            if (!empty($upnsplit[0])) {
                $aadusers[$i]['upnsplit0'] = $upnsplit[0];
                $usernames[] = $upnsplit[0];
            }
        }

        list($usernamesql, $usernameparams) = $DB->get_in_or_equal($usernames);
        $sql = 'SELECT u.username,
                       u.id as muserid,
                       u.auth,
                       tok.id as tokid,
                       conn.id as existingconnectionid,
                       assign.assigned assigned,
                       assign.photoid photoid,
                       assign.photoupdated photoupdated,
                       obj.id AS objrecid
                  FROM {user} u
             LEFT JOIN {auth_oidc_token} tok ON tok.userid = u.id
             LEFT JOIN {local_o365_connections} conn ON conn.muserid = u.id
             LEFT JOIN {local_o365_appassign} assign ON assign.muserid = u.id
             LEFT JOIN {local_o365_objects} obj ON obj.type = ? AND obj.moodleid = u.id
                 WHERE u.username '.$usernamesql.' AND u.mnethostid = ? AND u.deleted = ?
              ORDER BY CONCAT(u.username, \'~\')'; // Sort john.smith@example.org before john.smith.
        $params = array_merge(['user'], $usernameparams, [$CFG->mnet_localhost_id, '0']);
        $existingusers = $DB->get_records_sql($sql, $params);

        // Fetch linked AAD user accounts.
        list($upnsql, $upnparams) = $DB->get_in_or_equal($upns);
        list($usernamesql, $usernameparams) = $DB->get_in_or_equal($usernames, SQL_PARAMS_QM, 'param', false);
        $sql = 'SELECT tok.oidcusername,
                       u.username as username,
                       u.id as muserid,
                       u.auth,
                       tok.id as tokid,
                       conn.id as existingconnectionid,
                       assign.assigned assigned,
                       assign.photoid photoid,
                       assign.photoupdated photoupdated,
                       obj.id AS objrecid
                  FROM {user} u
             LEFT JOIN {auth_oidc_token} tok ON tok.userid = u.id
             LEFT JOIN {local_o365_connections} conn ON conn.muserid = u.id
             LEFT JOIN {local_o365_appassign} assign ON assign.muserid = u.id
             LEFT JOIN {local_o365_objects} obj ON obj.type = ? AND obj.moodleid = u.id
                 WHERE tok.oidcusername '.$upnsql.' AND u.username '.$usernamesql.' AND u.mnethostid = ? AND u.deleted = ? ';
        $params = array_merge(['user'], $upnparams, $usernameparams, [$CFG->mnet_localhost_id, '0']);
        $linkedexistingusers = $DB->get_records_sql($sql, $params);

        $existingusers = array_merge($existingusers, $linkedexistingusers);

        foreach ($aadusers as $user) {
            $this->mtrace(' ');
            $this->mtrace('Syncing user '.$user['upnlower']);

            if (\local_o365\rest\unified::is_configured()) {
                $userobjectid = $user['id'];
            } else {
                $userobjectid = $user['objectId'];
            }

            if (isset($user['aad.isDeleted']) && $user['aad.isDeleted'] == '1') {
                if (isset($aadsync['delete'])) {
                    // Check for synced user.
                    $sql = 'SELECT u.*
                              FROM {user} u
                              JOIN {local_o365_objects} obj ON obj.type = \'user\' AND obj.moodleid = u.id
                              JOIN {auth_oidc_token} tok ON tok.userid = u.id
                             WHERE u.username = ?
                                   AND u.mnethostid = ?
                                   AND u.deleted = ?
                                   AND u.suspended = ?
                                   AND u.auth = ?';
                    $params = [
                        trim(\core_text::strtolower($user['userPrincipalName'])),
                        $CFG->mnet_localhost_id,
                        '0',
                        '0',
                        'oidc',
                        time()
                    ];
                    $synceduser = $DB->get_record_sql($sql, $params);
                    if (!empty($synceduser)) {
                        $synceduser->suspended = 1;
                        user_update_user($synceduser, false);
                        $this->mtrace($synceduser->username.' was marked deleted in Azure.');
                    }
                } else {
                    $this->mtrace('User is deleted. Skipping.');
                }
                continue;
            }

            if (!isset($existingusers[$user['upnlower']]) && !isset($existingusers[$user['upnsplit0']])) {
                $newmuser = $this->sync_new_user($aadsync, $user);
            } else {
                $existinguser = null;
                if (isset($existingusers[$user['upnlower']])) {
                    $existinguser = $existingusers[$user['upnlower']];
                    $exactmatch = true;
                } else if (isset($existingusers[$user['upnsplit0']])) {
                    $existinguser = $existingusers[$user['upnsplit0']];
                    $exactmatch = strlen($user['upnsplit0']) >= $switchauthminupnsplit0;
                }

                $result = $this->sync_existing_user($aadsync, $user, $existinguser, $exactmatch);

                if ($existinguser->auth === 'oidc' || empty($existinguser->tokid)) {
                    // Create userobject if it does not exist.
                    if (empty($existinguser->objrecid)) {
                        $this->mtrace('Adding o365 object record for user.');
                        $now = time();
                        $userobjectdata = (object)[
                            'type' => 'user',
                            'subtype' => '',
                            'objectid' => $userobjectid,
                            'o365name' => $user['userPrincipalName'],
                            'moodleid' => $existinguser->muserid,
                            'tenant' => '',
                            'timecreated' => $now,
                            'timemodified' => $now,
                        ];
                        $userobjectdata->id = $DB->insert_record('local_o365_objects', $userobjectdata);
                    }
                    // User already connected.
                    $this->mtrace('User is now synced.');
                }

                // Update existing user on moodle from AD
                if ($existinguser->auth === 'oidc') {
                    if(isset($aadsync['update'])) {
                        $this->mtrace('Updating Moodle user data from Azure AD user data.');
                        $fullexistinguser = get_complete_user_data('username', $existinguser->username);
                        $this->update_user_from_aaddata($user, $fullexistinguser);
                        $this->mtrace('User is now updated.');
                    }
                }
            }
        }
        return true;
    }

    protected function sync_new_user($syncoptions, $aaduserdata) {
        $this->mtrace('User doesn\'t exist in Moodle');

        $userobjectid = (\local_o365\rest\unified::is_configured())
            ? $aaduserdata['id']
            : $aaduserdata['objectId'];

        // Create moodle account, if enabled.
        if (!isset($syncoptions['create'])) {
            $this->mtrace('Not creating a Moodle user because that sync option is disabled.');
            return null;
        }
        try {
            $newmuser = $this->create_user_from_aaddata($aaduserdata);
            if (!empty($newmuser)) {
                $this->mtrace('Created user #'.$newmuser->id);
            }
        } catch (\Exception $e) {
            $this->mtrace('Could not create user "'.$aaduserdata['userPrincipalName'].'" Reason: '.$e->getMessage());
        }

        // User app assignment.
        if (!empty($syncoptions['appassign'])) {
            try {
                if (!empty($newmuser) && !empty($userobjectid)) {
                    $this->assign_user($newmuser->id, $userobjectid);
                }
            } catch (\Exception $e) {
                $this->mtrace('Could not assign user "'.$aaduserdata['userPrincipalName'].'" Reason: '.$e->getMessage());
            }
        }

        // User photo assignment.
        if (!empty($syncoptions['photosync'])) {
            if (!PHPUNIT_TEST) {
                try {
                    if (!empty($newmuser)) {
                        $this->assign_photo($newmuser->id, $aaduserdata['upnlower']);
                    }
                } catch (\Exception $e) {
                    $this->mtrace('Could not assign photo to user "'.$aaduserdata['userPrincipalName'].'" Reason: '.$e->getMessage());
                }
            }
        }
        return $newmuser;
    }

    protected function sync_existing_user($syncoptions, $aaduserdata, $existinguser, $exactmatch) {
        $photoexpire = get_config('local_o365', 'photoexpire');
        if (empty($photoexpire) || !is_numeric($photoexpire)) {
            $photoexpire = 24;
        }
        $photoexpiresec = $photoexpire * 3600;

        $userobjectid = (\local_o365\rest\unified::is_configured())
            ? $aaduserdata['id']
            : $aaduserdata['objectId'];

        // Assign user to app if not already assigned.
        if (isset($syncoptions['appassign'])) {
            if (empty($existinguser->assigned)) {
                try {
                    if (!empty($existinguser->muserid) && !empty($userobjectid)) {
                        $this->assign_user($existinguser->muserid, $userobjectid);
                    }
                } catch (\Exception $e) {
                    $this->mtrace('Could not assign user "'.$aaduserdata['userPrincipalName'].'" Reason: '.$e->getMessage());
                }
            }
        }

        // Perform photo sync.
        if (isset($syncoptions['photosync'])) {
            if (empty($existinguser->photoupdated) || ($existinguser->photoupdated + $photoexpiresec) < time()) {
                try {
                    if (!PHPUNIT_TEST) {
                        $this->assign_photo($existinguser->muserid, $aaduserdata['upnlower']);
                    }
                } catch (\Exception $e) {
                    $this->mtrace('Could not assign profile photo to user "'.$aaduserdata['userPrincipalName'].'" Reason: '.$e->getMessage());
                }
            }
        }

        // Match user if needed.
        if ($existinguser->auth !== 'oidc') {
            $this->mtrace('Found a user in Azure AD that seems to match a user in Moodle');
            $this->mtrace(sprintf('moodle username: %s, aad upn: %s', $existinguser->username, $aaduserdata['upnlower']));
            return $this->sync_users_matchuser($syncoptions, $aaduserdata, $existinguser, $exactmatch);
        } else {
            $this->mtrace('The user is already using OpenID for authentication.');
            return true;
        }
    }

    protected function sync_users_matchuser($syncoptions, $aaduserdata, $existinguser, $exactmatch) {
        global $CFG, $DB;

        if (!isset($syncoptions['match'])) {
            $this->mtrace('Not matching user because that sync option is disabled.');
            return true;
        }

        if (isset($syncoptions['matchswitchauth']) && $exactmatch) {
            // Switch the user to OpenID authentication method, but only if this setting is enabled and full username matched.
            require_once($CFG->dirroot.'/user/profile/lib.php');
            require_once($CFG->dirroot.'/user/lib.php');
            // Do not switch Moodle user to OpenID if another Moodle user is already using same Office 365 account for logging in.
            $sql = 'SELECT u.username
                      FROM {user} u
                 LEFT JOIN {local_o365_objects} obj ON obj.type = ? AND obj.moodleid = u.id
                 WHERE obj.o365name = ?
                   AND u.username != ?';
            $params = ['user', $aaduserdata['upnlower'], $existinguser->username];
            $alreadylinkedusername = $DB->get_field_sql($sql, $params);

            if ($alreadylinkedusername !== false) {
                $errmsg = 'This Azure AD user has already been linked with Moodle user %s. Not switching Moodle user %s to OpenID.';
                $this->mtrace(sprintf($errmsg, $alreadylinkedusername, $existinguser->username));
                return true;
            } else {
                if (!empty($existinguser->existingconnectionid)) {
                    // Delete existing connection before linking (in case matching was performed without auth switching previously).
                    $DB->delete_records_select ('local_o365_connections', "id = {$existinguser->existingconnectionid}");
                }
                $fullexistinguser = get_complete_user_data('username', $existinguser->username);
                $existinguser->id = $fullexistinguser->id;
                $existinguser->auth = 'oidc';
                user_update_user($existinguser, true);
                // Clear user's password.
                $password = null;
                update_internal_user_password($existinguser, $password);
                $this->mtrace('Switched user to OpenID.');
            }
        } else if (!empty($existinguser->existingconnectionid)) {
            $this->mtrace('User is already matched.');
            return true;
        } else {
            // Match to o365 account, if enabled.
            $matchrec = [
                'muserid' => $existinguser->muserid,
                'aadupn' => $aaduserdata['upnlower'],
                'uselogin' => isset($syncoptions['matchswitchauth']) ? 1 : 0,
            ];
            $DB->insert_record('local_o365_connections', $matchrec);
            $this->mtrace('Matched user, but did not switch them to OpenID.');
            return true;
        }
    }
}
