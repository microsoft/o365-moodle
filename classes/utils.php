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

namespace local_o365;

/**
 * General purpose utility class.
 */
class utils {
    /**
     * Determine whether the plugins are configured.
     *
     * Determines whether essential configuration has been completed.
     *
     * @return bool Whether the plugins are configured.
     */
    public static function is_configured() {
        $cfg = get_config('auth_oidc');
        if (empty($cfg) || !is_object($cfg)) {
            return false;
        }
        if (empty($cfg->clientid) || empty($cfg->clientsecret) || empty($cfg->authendpoint) || empty($cfg->tokenendpoint)) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the local_msaccount plugin is configured.
     *
     * @return bool Whether the plugins are configured.
     */
    public static function is_configured_msaccount() {
        if (!class_exists('\local_msaccount\client')) {
            return false;
        }
        $cfg = get_config('local_msaccount');
        if (empty($cfg) || !is_object($cfg)) {
            return false;
        }
        if (empty($cfg->clientid) || empty($cfg->clientsecret) || empty($cfg->authendpoint) || empty($cfg->tokenendpoint)) {
            return false;
        }
        return true;
    }

    /**
     * Get an app token if available or fall back to system API user token.
     *
     * @param string $resource The desired resource.
     * @param \local_o365\oauth2\clientdata $clientdata Client credentials.
     * @param \local_o365\httpclientinterface $httpclient An HTTP client.
     * @return \local_o365\oauth2\apptoken|\local_o365\oauth2\systemapiusertoken An app or system token.
     */
    public static function get_app_or_system_token($resource, $clientdata, $httpclient) {
        $token = null;
        try {
            if (static::is_configured_apponlyaccess() === true) {
                $token = \local_o365\oauth2\apptoken::instance(null, $resource, $clientdata, $httpclient);
            }
        } catch (\Exception $e) {
            static::debug($e->getMessage(), 'get_app_or_system_token (app)', $e);
        }

        if (empty($token)) {
            try {
                $token = \local_o365\oauth2\systemapiusertoken::instance(null, $resource, $clientdata, $httpclient);
            } catch (\Exception $e) {
                static::debug($e->getMessage(), 'get_app_or_system_token (system)', $e);
            }
        }

        if (!empty($token)) {
            return $token;
        } else {
            throw new \Exception('Could not get app or system token');
        }
    }

    /**
     * Get the tenant from an ID Token.
     *
     * @param \auth_oidc\jwt $idtoken The ID token.
     * @return string|null The tenant, or null is failure.
     */
    public static function get_tenant_from_idtoken(\auth_oidc\jwt $idtoken) {
        $iss = $idtoken->claim('iss');
        $parsediss = parse_url($iss);
        if (!empty($parsediss['path'])) {
            $tenant = trim($parsediss['path'], '/');
            if (!empty($tenant)) {
                return $tenant;
            }
        }
        return null;
    }

    /**
     * Determine whether app-only access is enabled.
     *
     * @return bool Enabled/disabled.
     */
    public static function is_enabled_apponlyaccess() {
        $apponlyenabled = get_config('local_o365', 'enableapponlyaccess');
        return (!empty($apponlyenabled)) ? true : false;
    }

    /**
     * Determine whether the app only access is configured.
     *
     * @return bool Whether the app only access is configured.
     */
    public static function is_configured_apponlyaccess() {
        // App only access requires unified api to be enabled.
        $apponlyenabled = static::is_enabled_apponlyaccess();
        if (empty($apponlyenabled)) {
            return false;
        }
        $aadtenant = get_config('local_o365', 'aadtenant');
        $aadtenantid = get_config('local_o365', 'aadtenantid');
        if (empty($aadtenant) && empty($aadtenantid)) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether app-only access is both configured and active.
     *
     * @return bool Whether app-only access is active.
     */
    public static function is_active_apponlyaccess() {
        return (static::is_configured_apponlyaccess() === true && \local_o365\rest\unified::is_configured() === true)
            ? true : false;
    }

    /**
     * Filters an array of userids to users that are currently connected to O365.
     *
     * @param array $userids The full array of userids.
     * @return array Array of userids that are o365 connected.
     */
    public static function limit_to_o365_users($userids) {
        global $DB;
        if (empty($userids)) {
            return [];
        }
        $aadresource = \local_o365\rest\azuread::get_resource();
        list($idsql, $idparams) = $DB->get_in_or_equal($userids);
        $sql = 'SELECT u.id as userid
                  FROM {user} u
             LEFT JOIN {local_o365_token} localtok ON localtok.user_id = u.id
             LEFT JOIN {auth_oidc_token} authtok ON authtok.resource = ? AND authtok.userid = u.id
                 WHERE u.id '.$idsql.'
                       AND (localtok.id IS NOT NULL OR authtok.id IS NOT NULL)';
        $params = [$aadresource];
        $params = array_merge($params, $idparams);
        $records = $DB->get_recordset_sql($sql, $params);
        $return = [];
        foreach ($records as $record) {
            $return[$record->userid] = (int)$record->userid;
        }
        return array_values($return);
    }

    /**
     * Get the UPN of the connected Office 365 account.
     *
     * @param int $userid The Moodle user id.
     * @return string|null The UPN of the connected Office 365 account, or null if none found.
     */
    public static function get_o365_upn($userid) {
        $o365user = \local_o365\obj\o365user::instance_from_muserid($userid);
        return (!empty($o365user)) ? $o365user->upn : null;
    }

    /**
     * Determine if a user is connected to Office 365.
     *
     * @param int $userid The user's ID.
     * @return bool Whether they are connected (true) or not (false).
     */
    public static function is_o365_connected($userid) {
        global $DB;
        $o365user = \local_o365\obj\o365user::instance_from_muserid($userid);
        return (!empty($o365user)) ? true : false;
    }

    /**
     * Convert any value into a debuggable string.
     *
     * @param mixed $val The variable to convert.
     * @return string A string representation.
     */
    public static function tostring($val) {
        if (is_scalar($val)) {
            if (is_bool($val)) {
                return '(bool)'.(string)(int)$val;
            } else {
                return '('.gettype($val).')'.(string)$val;
            }
        } else if (is_null($val)) {
            return '(null)';
        } else if ($val instanceof \Exception) {
            $valinfo = [
                'file' => $val->getFile(),
                'line' => $val->getLine(),
                'message' => $val->getMessage(),
            ];
            if ($val instanceof \moodle_exception) {
                $valinfo['debuginfo'] = $val->debuginfo;
                $valinfo['errorcode'] = $val->errorcode;
                $valinfo['module'] = $val->module;
            }
            return print_r($valinfo, true);
        } else {
            return print_r($val, true);
        }
    }

    /**
     * Record a debug message.
     *
     * @param string $message The debug message to log.
     */
    public static function debug($message, $where = '', $debugdata = null) {
        $debugmode = (bool)get_config('local_o365', 'debugmode');
        if ($debugmode === true) {
            $fullmessage = (!empty($where)) ? $where : 'Unknown function';
            $fullmessage .= ': '.$message;
            $fullmessage .= ' Data: '.static::tostring($debugdata);
            $event = \local_o365\event\api_call_failed::create(['other' => $fullmessage]);
            $event->trigger();
        }
    }

    /**
     * Construct an API client.
     *
     * @return \local_o365\rest\o365api|bool A constructed user API client (unified or legacy), or throw an error.
     */
    public static function get_api($userid = null, $forcelegacy = false, $caller = 'get_api') {
        if ($forcelegacy) {
            $unifiedconfigured = false;
        } else {
            $unifiedconfigured = \local_o365\rest\unified::is_configured();
        }

        if ($unifiedconfigured === true) {
            $resource = \local_o365\rest\unified::get_resource();
        } else {
            $resource = \local_o365\rest\azuread::get_resource();
        }

        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();
        if (!empty($userid)) {
            $token = \local_o365\oauth2\token::instance($userid, $resource, $clientdata, $httpclient);
        } else {
            $token = \local_o365\utils::get_app_or_system_token($resource, $clientdata, $httpclient);
        }
        if (empty($token)) {
            throw new \Exception('No token available for system user. Please run local_o365 health check.');
        }

        if ($unifiedconfigured === true) {
            $apiclient = new \local_o365\rest\unified($token, $httpclient);
        } else {
            $apiclient = new \local_o365\rest\azuread($token, $httpclient);
        }
        return $apiclient;
    }

    /**
     * Enable an additional Office 365 tenant/
     */
    public static function enableadditionaltenant($tenant) {
        $configuredtenants = get_config('local_o365', 'multitenants');
        if (!empty($configuredtenants)) {
            $configuredtenants = json_decode($configuredtenants, true);
            if (!is_array($configuredtenants)) {
                $configuredtenants = [];
            }
        }
        $configuredtenants[] = $tenant;
        $configuredtenants = array_unique($configuredtenants);
        set_config('multitenants', json_encode($configuredtenants), 'local_o365');

        // Generate restrictions.
        $newrestrictions = [];
        $o365config = get_config('local_o365');
        array_unshift($configuredtenants, $o365config->aadtenant);
        foreach ($configuredtenants as $configuredtenant) {
            $newrestriction = '@';
            $newrestriction .= str_replace('.', '\.', $configuredtenant);
            $newrestriction .= '$';
            $newrestrictions[] = $newrestriction;
        }
        $userrestrictions = get_config('auth_oidc', 'userrestrictions');
        $userrestrictions = explode("\n", $userrestrictions);
        $userrestrictions = array_merge($userrestrictions, $newrestrictions);
        $userrestrictions = array_unique($userrestrictions);
        $userrestrictions = implode("\n", $userrestrictions);
        set_config('userrestrictions', $userrestrictions, 'auth_oidc');
    }

    /**
     * Disable an additional Office 365 tenant.
     */
    public static function disableadditionaltenant($tenant) {
        $o365config = get_config('local_o365');
        if (empty($o365config->multitenants)) {
            return true;
        }
        $configuredtenants = json_decode($o365config->multitenants, true);
        if (!is_array($configuredtenants)) {
            $configuredtenants = [];
        }
        $configuredtenants = array_diff($configuredtenants, [$tenant]);
        set_config('multitenants', json_encode($configuredtenants), 'local_o365');

        // Update restrictions.
        $userrestrictions = get_config('auth_oidc', 'userrestrictions');
        $userrestrictions = (!empty($userrestrictions)) ? explode("\n", $userrestrictions) : [];
        $regex = '@'.str_replace('.', '\.', $tenant).'$';
        $userrestrictions = array_diff($userrestrictions, [$regex]);
        $userrestrictions = implode("\n", $userrestrictions);
        set_config('userrestrictions', $userrestrictions, 'auth_oidc');
    }

    /**
     * Get the tenant for a user.
     *
     * @param int $userid The ID of the user.
     * @return string The tenant for the user. Empty string unless different from the host tenant.
     */
    public static function get_tenant_for_user($userid) {
        try {
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            $httpclient = new \local_o365\httpclient();
            $resource = (\local_o365\rest\unified::is_enabled() === true)
                ? \local_o365\rest\unified::get_resource()
                : \local_o365\rest\discovery::get_resource();
            $token = \local_o365\oauth2\token::instance($userid, $resource, $clientdata, $httpclient);
            if (!empty($token)) {
                $apiclient = (\local_o365\rest\unified::is_enabled() === true)
                    ? new \local_o365\rest\unified($token, $httpclient)
                    : new \local_o365\rest\discovery($token, $httpclient);
                $tenant = $apiclient->get_tenant();
                $tenant = clean_param($tenant, PARAM_TEXT);
                return ($tenant != get_config('local_o365', 'aadtenant'))
                    ? $tenant : '';
            }
        } catch (\Exception $e) {

        }
        return '';
    }

    /**
     * Get the OneDrive for Business URL for a user.
     *
     * @param int $userid The ID of the user.
     * @return string The OneDrive for Business URL for the user.
     */
    public static function get_odburl_for_user($userid) {
        try {
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            $httpclient = new \local_o365\httpclient();
            $resource = (\local_o365\rest\unified::is_enabled() === true)
                ? \local_o365\rest\unified::get_resource()
                : \local_o365\rest\discovery::get_resource();
            $token = \local_o365\oauth2\token::instance($userid, $resource, $clientdata, $httpclient);
            if (!empty($token)) {
                $apiclient = (\local_o365\rest\unified::is_enabled() === true)
                    ? new \local_o365\rest\unified($token, $httpclient)
                    : new \local_o365\rest\discovery($token, $httpclient);
                $tenant = $apiclient->get_odburl();
                $tenant = clean_param($tenant, PARAM_TEXT);
                return ($tenant != get_config('local_o365', 'odburl'))
                    ? $tenant : '';
            }
        } catch (\Exception $e) {

        }
        return '';
    }

}
