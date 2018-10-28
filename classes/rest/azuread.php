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

namespace local_o365\rest;

/**
 * API client for Azure AD graph.
 */
class azuread extends \local_o365\rest\o365api {
    /** The general API area of the class. */
    public $apiarea = 'directory';

    /** @var string A value to use for the Azure AD tenant. If null, will use value from local_o365/aadtenant config setting. */
    protected $tenantoverride = null;

    /**
     * Determine if the API client is configured.
     *
     * @return bool Whether the API client is configured.
     */
    public static function is_configured() {
        $config = get_config('local_o365');
        return (!empty($config->aadtenant)) ? true : false;
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
        $requesturi .= 'api-version=1.5';
        return $requesturi;
    }

    /**
     * Test a tenant value.
     *
     * @param string $tenant A tenant string to test.
     * @return bool True if tenant succeeded, false if not.
     */
    public function test_tenant($tenant) {
        if (!is_string($tenant)) {
            throw new \coding_exception('tenant value must be a string');
        }
        $this->tenantoverride = $tenant;
        $appinfo = $this->get_application_info();
        $this->tenantoverride = null;
        if (isset($appinfo['value']) && isset($appinfo['value'][0]['odata.type'])) {
            return ($appinfo['value'][0]['odata.type'] === 'Microsoft.DirectoryServices.Application') ? true : false;
        }
        return false;
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        $tenant = null;
        if (!empty($this->tenantoverride)) {
            $tenant = $this->tenantoverride;
        } else {
            $config = get_config('local_o365');
            if (!empty($config->aadtenant)) {
                $tenant = $config->aadtenant;
            }
        }

        if (!empty($tenant)) {
            return static::get_resource().'/'.$tenant;
        } else {
            return false;
        }
    }

    /**
     * Get information on the current application.
     *
     * @return array|null Array of application information, or null if failure.
     */
    public function get_application_info() {
        $oidcconfig = get_config('auth_oidc');
        $endpoint = '/applications/?$filter=appId%20eq%20\''.$oidcconfig->clientid.'\'';
        $response = $this->apicall('get', $endpoint);
        return $this->process_apicall_response($response, ['value' => null]);
    }

    /**
     * Get information on the current application.
     *
     * @return array|null Array of application information, or null if failure.
     */
    public function get_all_application_info() {
        $endpoint = '/applications';
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
     * Check whether all permissions defined in $this->get_required_permissions have been assigned.
     *
     * @return array Array of missing permissions.
     */
    public function check_permissions() {
        $this->token->refresh();
        $neededperms = $this->get_required_permissions();
        unset($neededperms['graph']);
        $allappdata = $this->get_service_data($neededperms);
        $currentperms = $this->get_current_permissions();
        $missingperms = [];
        foreach ($neededperms as $api => $apidata) {
            $appid = $apidata['appId'];
            $appname = $allappdata[$appid]['appDisplayName'];
            $requiredperms = $apidata['requiredDelegatedPermissions'];
            $availableperms = $allappdata[$appid]['perms'];
            foreach ($requiredperms as $permname => $altperms) {
                // First we assemble a list of permission IDs, indexed by permission name.
                $permids = [];
                $permstocheck = array_merge([$permname], $altperms);
                foreach ($permstocheck as $permtocheckname) {
                    if (isset($availableperms[$permtocheckname])) {
                        $permids[$permtocheckname] = $availableperms[$permtocheckname]['id'];
                    }
                }
                if (empty($permids)) {
                    // If $permids is empty no candidate permissions exist in the application.
                    $missingperms[$appname][$permname] = $permname;
                } else {
                    $permsatisfied = false;
                    foreach ($permids as $permidsname => $permidsid) {
                        if (isset($currentperms[$appid][$permidsid])) {
                            $permsatisfied = true;
                            break;
                        }
                    }
                    if ($permsatisfied === false) {
                        if (isset($availableperms[$permname]['adminConsentDisplayName'])) {
                            $permdesc = $availableperms[$permname]['adminConsentDisplayName'];
                        } else {
                            $permdesc = $permname;
                        }
                        $missingperms[$appname][$permname] = $permdesc;
                    }
                }
            }
        }

        // Determine whether we have write permissions.
        $writeappid = $allappdata['Microsoft.Azure.ActiveDirectory']['appId'];
        $writepermid = isset($allappdata['Microsoft.Azure.ActiveDirectory']['perms']['Directory.ReadWrite.All']['id'])
            ? $allappdata['Microsoft.Azure.ActiveDirectory']['perms']['Directory.ReadWrite.All']['id'] : null;
        $haswrite = (!empty($writepermid) && !empty($currentperms[$writeappid][$writepermid])) ? true : false;
        $canfix = ($haswrite === true) ? true : false;

        return [$missingperms, $canfix];
    }

    /**
     * Update permissions for the application.
     *
     * @return bool Whether the operation was successful.
     */
    public function push_permissions() {
        $this->token->refresh();
        $appinfo = $this->get_application_info();
        $reqdperms = $this->get_required_permissions();
        $svcdata = $this->get_service_data(array_keys($reqdperms));

        $newperms = [];
        foreach ($reqdperms as $appname => $perms) {
            $appid = $svcdata[$appname]['appId'];
            $appperms = ['resourceAppId' => $appid, 'resourceAccess' => []];
            foreach ($perms as $permname => $altperms) {
                $appperms['resourceAccess'][] = [
                    'id' => $svcdata[$appname]['perms'][$permname]['id'],
                    'type' => 'Scope',
                ];
            }
            $newperms[] = $appperms;
        }
        $newperms = ['value' => $newperms];
        $newperms = json_encode($newperms);
        $endpoint = '/applications/'.$appinfo['value'][0]['objectId'].'/requiredResourceAccess';
        $response = $this->apicall('merge', $endpoint, $newperms);

        if ($response === '') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the currently assigned permissions for this application.
     *
     * @return array Array of currently assign permissions, using service and permission IDs.
     */
    public function get_current_permissions() {
        $currentperms = [];
        $response = $this->get_application_info();
        if (isset($response['value'][0]['requiredResourceAccess'])) {
            foreach ($response['value'][0]['requiredResourceAccess'] as $i => $permset) {
                if (isset($permset['resourceAppId']) && isset($permset['resourceAccess'])) {
                    if (!isset($currentperms[$permset['resourceAppId']])) {
                        $currentperms[$permset['resourceAppId']] = [];
                    }
                    foreach ($permset['resourceAccess'] as $i => $access) {
                        if (isset($access['id']) && isset($access['type'])) {
                            $currentperms[$permset['resourceAppId']][$access['id']] = $access['type'];
                        }
                    }
                }
            }
            unset($response);
        }
        return $currentperms;
    }

    /**
     * Get information on the current application.
     *
     * @return array|null Array of service information, or null if error.
     */
    public function get_application_serviceprincipal_info() {
        $oidcconfig = get_config('auth_oidc');
        $endpoint = '/servicePrincipals()?$filter=appId%20eq%20\''.$oidcconfig->clientid.'\'';
        $params = array(
            'appId' => $oidcconfig->clientid,
        );
        $response = $this->apicall('get', $endpoint);
        $expectedparams = array('value' => null);
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get information on specified services.
     *
     * @param int $muserid Moodle userid.
     * @param string $userid Azure object id for user.
     * @return array|null Array of result, or null if error.
     */
    public function assign_user($muserid, $userid, $appobjectid) {
        global $DB;
        $record = $DB->get_record('local_o365_appassign', array('muserid' => $muserid));
        if (empty($record) || $record->assigned == 0) {
            $endpoint = '/users/'.$userid.'/appRoleAssignments';
            $routeid = '00000000-0000-0000-0000-000000000000';
            $params = array(
                'id' => $routeid,
                'resourceId' => $appobjectid,
                'principalId' => $userid
            );
            $response = $this->apicall('post', $endpoint, json_encode($params));
            $expectedparams = array(
                'odata.type' => 'Microsoft.DirectoryServices.AppRoleAssignment',
                'objectType' => 'AppRoleAssignment',
            );

            try {
                $response = $this->process_apicall_response($response, $expectedparams);
            } catch (\Exception $e) {
                // This error here probably means the user is already assigned, so we can continue. process_apicall_response
                // will log any real errors anyway.
                $msg = 'One or more properties are invalid.';
                $string = get_string('erroro365apibadcall_message', 'local_o365', htmlentities($msg));
                if ($e->getMessage() !== $string) {
                    throw $e;
                }
            }

            if (empty($record)) {
                $record = new \stdClass;
                $record->muserid = $muserid;
                $record->assigned = 1;
                $DB->insert_record('local_o365_appassign', $record);
            } else {
                $record->assigned = 1;
                $DB->update_record('local_o365_appassign', $record);
            }
            return $response;
        }
        return null;
    }

    /**
     * Get information on specified services.
     *
     * @param array $apis Array of api data to get. (See items in get_required_permissions for examples.)
     * @param bool $transform Whether to transform the result for easy consumption (see check_permissions and push_permissions)
     * @return array|null Array of service information, or null if error.
     */
    public function get_service_data(array $apis, $transform = true) {
        if (!empty($apis)) {
            $appids = [];
            foreach ($apis as $api) {
                $appids[] = $api['appId'];
            }
            $filterstr = 'appId%20eq%20\''.implode('\'%20or%20appId%20eq%20\'', $appids).'\'';
            $endpoint = '/servicePrincipals()?$filter='.$filterstr;
        } else {
            $endpoint = '/servicePrincipals()';
        }
        $response = $this->apicall('get', $endpoint);
        if (!empty($response)) {
            $response = @json_decode($response, true);
            if (!empty($response) && is_array($response)) {
                if ($transform === true) {
                    $transformed = [];
                    foreach ($response['value'] as $i => $appdata) {
                        $transformed[$appdata['appId']] = [
                            'appId' => $appdata['appId'],
                            'appDisplayName' => $appdata['appDisplayName'],
                            'perms' => []
                        ];
                        foreach ($appdata['oauth2Permissions'] as $i => $permdata) {
                            $transformed[$appdata['appId']]['perms'][$permdata['value']] = $permdata;
                        }
                    }
                    return $transformed;
                } else {
                    return $response;
                }
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
        $endpoint = '/users';
        if ($params === 'default') {
            $params = ['mail', 'city', 'country', 'department', 'givenName', 'surname', 'preferredLanguage', 'userPrincipalName'];
        }
        if (!empty($skiptoken) && is_string($skiptoken) && !empty($params) && is_array($params)) {
            $endpoint .= '?$skiptoken='.$skiptoken;
        }
        $response = $this->apicall('get', $endpoint);
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
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
        $expectedparams = [
            'odata.type' => 'Microsoft.DirectoryServices.User',
            'objectId' => null,
            'userPrincipalName' => null,
        ];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a user by the user's userPrincipalName
     *
     * @param string $upn The user's userPrincipalName
     * @return array Array of user data.
     */
    public function get_user_by_upn($upn) {
        $endpoint = '/users/'.rawurlencode($upn);
        $response = $this->apicall('get', $endpoint);
        $expectedparams = ['objectId' => null, 'userPrincipalName' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get the Azure AD UPN of a connected Moodle user.
     *
     * @param \stdClass $user The Moodle user.
     * @return string|bool The user's Azure AD UPN, or false if failure.
     */
    public static function get_muser_upn($user) {
        global $DB;
        $now = time();

        if (is_numeric($user)) {
            $user = $DB->get_record('user', ['id' => $user]);
            if (empty($user)) {
                \local_o365\utils::debug('User not found', 'rest\azuread\get_muser_upn', $user);
                return false;
            }
        }

        // Get user UPN.
        $userobjectdata = $DB->get_record('local_o365_objects', ['type' => 'user', 'moodleid' => $user->id]);
        if (!empty($userobjectdata)) {
            return $userobjectdata->o365name;
        } else {
            // Get user data.
            $o365user = \local_o365\obj\o365user::instance_from_muserid($user->id);
            if (empty($o365user)) {
                // No o365 user data for the user is available.
                \local_o365\utils::debug('Could not construct o365user class for user.', 'rest\azuread\get_muser_upn', $user->username);
                return false;
            }
            $httpclient = new \local_o365\httpclient();
            try {
                $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            } catch (\Exception $e) {
                \local_o365\utils::debug($e->getMessage(), 'rest\azuread\get_muser_upn', $e);
                return false;
            }
            $resource = static::get_resource();
            $token = \local_o365\utils::get_app_or_system_token($resource, $clientdata, $httpclient);
            $aadapiclient = new \local_o365\rest\azuread($token, $httpclient);
            $aaduserdata = $aadapiclient->get_user($o365user->objectid);
            $userobjectdata = (object)[
                'type' => 'user',
                'subtype' => '',
                'objectid' => $aaduserdata['objectId'],
                'o365name' => $aaduserdata['userPrincipalName'],
                'moodleid' => $user->id,
                'timecreated' => $now,
                'timemodified' => $now,
            ];
            $userobjectdata->id = $DB->insert_record('local_o365_objects', $userobjectdata);
            return $userobjectdata->o365name;
        }
    }

    /**
     * Add a user to a course o365 usergoup.
     *
     * @param int $courseid The ID of the moodle group.
     * @param int $userid The ID of the moodle user.
     * @return bool|null|string True if successful, null if not applicable, string if other API error.
     */
    public function add_user_to_course_group($courseid, $userid) {
        global $DB;

        $filters = ['type' => 'group', 'subtype' => 'course', 'moodleid' => $courseid];
        $coursegroupobject = $DB->get_record('local_o365_objects', $filters);
        if (empty($coursegroupobject)) {
            return null;
        }

        $o365user = \local_o365\obj\o365user::instance_from_muserid($userid);
        if (empty($o365user)) {
            return null;
        }

        $response = $this->add_member_to_group($coursegroupobject->objectid, $o365user->objectid);
        return $response;
    }

    /**
     * Remove a user from a course o365 usergoup.
     *
     * @param int $courseid The ID of the moodle group.
     * @param int $userid The ID of the moodle user.
     * @return bool|null|string True if successful, null if not applicable, string if other API error.
     */
    public function remove_user_from_course_group($courseid, $userid) {
        global $DB;

        $filters = ['type' => 'group', 'subtype' => 'course', 'moodleid' => $courseid];
        $coursegroupobject = $DB->get_record('local_o365_objects', $filters);
        if (empty($coursegroupobject)) {
            return null;
        }

        $o365user = \local_o365\obj\o365user::instance_from_muserid($userid);
        if (empty($o365user)) {
            return null;
        }

        $response = $this->remove_member_from_group($coursegroupobject->objectid, $o365user->objectid);
        return $response;
    }

    /**
     * Add member to group.
     *
     * @param string $groupobjectid The object ID of the group to add to.
     * @param string $memberobjectid The object ID of the item to add (can be group object id or user object id).
     * @return bool|string True if successful, returned string if not (may contain error info, etc).
     */
    public function add_member_to_group($groupobjectid, $memberobjectid) {
        $config = get_config('local_o365');
        if (empty($config->aadtenant)) {
            return null;
        }
        $endpoint = '/groups/'.$groupobjectid.'/$links/members';
        $data = [
            'url' => $this->get_apiuri().'/directoryObjects/'.$memberobjectid
        ];
        $response = $this->apicall('post', $endpoint, json_encode($data), ['apiarea' => 'groups']);
        return ($response === '') ? true : $response;
    }

    /**
     * Remove member from group.
     *
     * @param string $groupobjectid The object ID of the group to remove from.
     * @param string $memberobjectid The object ID of the item to remove (can be group object id or user object id).
     * @return bool|string True if successful, returned string if not (may contain error info, etc).
     */
    public function remove_member_from_group($groupobjectid, $memberobjectid) {
        $config = get_config('local_o365');
        if (empty($config->aadtenant)) {
            return null;
        }
        $endpoint = '/groups/'.$groupobjectid.'/$links/members/'.$memberobjectid;
        $response = $this->apicall('delete', $endpoint, '', ['apiarea' => 'groups']);
        return ($response === '') ? true : $response;
    }
}
