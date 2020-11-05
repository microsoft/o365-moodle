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
 * Client for unified Office 365 API.
 */
class unified extends \local_o365\rest\o365api {
    /** The general API area of the class. */
    public $apiarea = 'graph';

    /**
     * Determine if the API client is configured.
     *
     * @return bool Whether the API client is configured.
     */
    public static function is_configured() {
        return (static::is_enabled()) ? true : false;
    }

    /**
     * Switch to disable Microsoft Graph API until release.
     *
     * @return bool Whether the Microsoft Graph API is enabled.
     */
    public static function is_enabled() {
        global $CFG;
        if (!empty($CFG->local_o365_forcelegacyapi)) {
            return false;
        }
        return true;
    }

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_resource() {
        $oidcresource = get_config('auth_oidc', 'oidcresource');
        if (!empty($oidcresource)) {
            return $oidcresource;
        } else {
            return (static::use_chinese_api() === true) ? 'https://microsoftgraph.chinacloudapi.cn' : 'https://graph.microsoft.com';
        }
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        $oidcresource = get_config('auth_oidc', 'oidcresource');
        if (!empty($oidcresource)) {
            return $oidcresource;
        } else {
            return (static::use_chinese_api() === true) ? 'https://microsoftgraph.chinacloudapi.cn' : 'https://graph.microsoft.com';
        }
    }

    /**
     * Generate an api area.
     *
     * @param string $apimethod The API method being called.
     * @return string a simplified api area string.
     */
    protected function generate_apiarea($apimethod) {
        $apimethod = explode('/', $apimethod);
        foreach ($apimethod as $apicomponent) {
            $validareas = ['applications', 'groups', 'calendars', 'events', 'trendingaround', 'users'];
            $apicomponent = strtolower($apicomponent);
            $apicomponent = explode('?', $apicomponent);
            $apicomponent = reset($apicomponent);
            if (in_array($apicomponent, $validareas)) {
                return $apicomponent;
            }
        }
        return 'graph';
    }

    /**
     * Make an API call.
     *
     * @param string $httpmethod The HTTP method to use. get/post/patch/merge/delete.
     * @param string $apimethod The API endpoint/method to call.
     * @param string $params Additional paramters to include.
     * @param array $options Additional options for the request.
     * @return string The result of the API call.
     */
    public function betaapicall($httpmethod, $apimethod, $params = '', $options = array()) {
        if ($apimethod[0] !== '/') {
            $apimethod = '/'.$apimethod;
        }
        $apimethod = '/beta'.$apimethod;
        if (empty($options['apiarea'])) {
            $options['apiarea'] = $this->generate_apiarea($apimethod);
        }
        return parent::apicall($httpmethod, $apimethod, $params, $options);
    }

    /**
     * Make an API call.
     *
     * @param string $httpmethod The HTTP method to use. get/post/patch/merge/delete.
     * @param string $apimethod The API endpoint/method to call.
     * @param string $params Additional paramters to include.
     * @param array $options Additional options for the request.
     * @return string The result of the API call.
     */
    public function apicall($httpmethod, $apimethod, $params = '', $options = array()) {
        if ($apimethod[0] !== '/') {
            $apimethod = '/'.$apimethod;
        }
        if (empty($options['apiarea'])) {
            $options['apiarea'] = $this->generate_apiarea($apimethod);
        }
        $apimethod = '/v1.0'.$apimethod;
        return parent::apicall($httpmethod, $apimethod, $params, $options);
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
        $oidcconfig = get_config('auth_oidc');
        $appinfo = $this->get_application_info();
        if (isset($appinfo['value']) && isset($appinfo['value'][0]['id'])) {
            return ($appinfo['value'][0]['id'] === $oidcconfig->clientid) ? true : false;
        }
        return false;
    }

    /**
     * Get the tenant associated with the current account.
     *
     * @return string The tenant string.
     */
    public function get_tenant() {
        $response = $this->apicall('get', '/domains');
        $response = $this->process_apicall_response($response, ['value' => null]);
        foreach ($response['value'] as $domain) {
            if (!empty($domain['isInitial']) && isset($domain['id'])) {
                return $domain['id'];
            }
        }
        throw new \moodle_exception('erroracpapcantgettenant', 'local_o365');
    }

    /**
     * Get the OneDrive URL associated with the current account.
     *
     * @return string The OneDrive URL string.
     */
    public function get_odburl() {
        $tenant = $this->get_tenant();
        $suffix = '.onmicrosoft.com';
        $sufflen = strlen($suffix);
        if (substr($tenant, -$sufflen) === $suffix) {
            $prefix = substr($tenant, 0, -$sufflen);
            $service = $prefix.'-my.sharepoint.com';
            return $service;
        }
        throw new \moodle_exception('erroracpcantgettenant', 'local_o365');
    }

    /**
     * Validate that a given url is a valid OneDrive for Business SharePoint URL.
     *
     * @param string $resource Uncleaned, unvalidated URL to check.
     * @param \local_o365\oauth2\clientdata $clientdata oAuth2 Credentials
     * @param \local_o365\httpclientinterface $httpclient An HttpClient to use for transport.
     * @return bool Whether the received resource is valid or not.
     */
    public function validate_resource($resource, $clientdata) {
        $cleanresource = clean_param($resource, PARAM_URL);
        if ($cleanresource !== $resource) {
            return false;
        }
        $fullcleanresource = 'https://'.$cleanresource;
        $token = \local_o365\utils::get_app_or_system_token($fullcleanresource, $clientdata, $this->httpclient);
        return (!empty($token)) ? true : false;
    }

    public function assign_user($muserid, $userobjectid, $appobjectid) {
        global $DB;
        $record = $DB->get_record('local_o365_appassign', ['muserid' => $muserid]);
        if (empty($record) || $record->assigned == 0) {
            $roleid = '00000000-0000-0000-0000-000000000000';
            $endpoint = '/users/'.$userobjectid.'/appRoleAssignments/';
            $params = [
                'id' => $roleid,
                'resourceId' => $appobjectid,
                'principalId' => $userobjectid,
            ];
            $response = $this->betaapicall('post', $endpoint, json_encode($params));
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
     * Get a list of groups.
     *
     * @param string $skiptoken Skip token.
     * @return array List of groups.
     */
    public function get_groups($skiptoken = '') {
        $endpoint = '/groups';
        $odataqueries = [];
        if (empty($skiptoken) || !is_string($skiptoken)) {
            $skiptoken = '';
        }
        if (!empty($skiptoken)) {
            $odataqueries[] = '$skiptoken='.$skiptoken;
        }
        if (!empty($odataqueries)) {
            $endpoint .= '?'.implode('&', $odataqueries);
        }
        $response = $this->apicall('get', $endpoint);
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Create a group.
     *
     * @param string $name The name of the group.
     * @param string $mailnickname The mailnickname.
     * @param array $extra Extra options for creation, ie description for Description of the group.
     * @return array Array of returned o365 group data.
     */
    public function create_group($name, $mailnickname = null, $extra = null) {
        if (empty($mailnickname)) {
            $mailnickname = $name;
        }

        if (!empty($mailnickname)) {
            $mailnickname = \core_text::strtolower($mailnickname);
            $mailnickname = preg_replace('/[^a-z0-9_]+/iu', '', $mailnickname);
            $mailnickname = trim($mailnickname);
        }

        if (empty($mailnickname)) {
            // Cannot generate a good mailnickname because there's nothing but non-alphanum chars to work with. So generate one.
            $mailnickname = 'group'.uniqid();
        }

        $groupdata = [
            'groupTypes' => ['Unified'],
            'displayName' => $name,
            'mailEnabled' => false,
            'securityEnabled' => false,
            'mailNickname' => $mailnickname,
            'visibility' => 'Private',
        ];

        if (!empty($extra) && is_array($extra)) {
            // Set extra parameters.
            foreach ($extra as $name => $value) {
                $groupdata[$name] = $value;
            }
        }

        // Description cannot be set and empty.
        if (empty($groupdata['description'])) {
            unset($groupdata['description']);
        }

        $response = $this->apicall('post', '/groups', json_encode($groupdata));
        $expectedparams = ['id' => null];
        try {
            $response = $this->process_apicall_response($response, $expectedparams);
        } catch (\Exception $e) {
            if ($e->getMessage() ==
                'Error in API call: Another object with the same value for property mailNickname already exists.') {
                $groupdata['mailNickname'] = $groupdata['mailNickname'] . '_' . preg_replace('/[^a-z0-9]+/iu', '', $name);
                $response = $this->apicall('post', '/groups', json_encode($groupdata));
                $response = $this->process_apicall_response($response, $expectedparams);
            } else {
                throw $e;
            }
        }

        return $response;
    }

    /**
     * Update a group.
     *
     * @param array $groupdata Array containing paramters for update.
     * @return string Null string on success, json string on failure.
     */
    public function update_group($groupdata) {
        // Check for required parameters.
        if (!is_array($groupdata) || empty($groupdata['id'])) {
            throw new \moodle_exception('invalidgroupdata', 'local_o365');
        }
        if (!isset($groupdata['mailEnabled'])) {
            $groupdata['mailEnabled'] = false;
        }
        if (!isset($groupdata['securityEnabled'])) {
            $groupdata['securityEnabled'] = false;
        }
        if (!isset($groupdata['groupTypes'])) {
            $groupdata['groupTypes'] = ['Unified'];
        }

        // Description cannot be empty.
        if (empty($groupdata['description'])) {
            unset($groupdata['description']);
        }
        $response = $this->apicall('patch', '/groups/'.$groupdata['id'], json_encode($groupdata));
        return $response;
    }

    /**
     * Get group info.
     *
     * @param string $objectid The object ID of the group.
     * @return array Array of returned o365 group data.
     */
    public function get_group($objectid) {
        $response = $this->apicall('get', '/groups/'.$objectid);
        $expectedparams = ['id' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }


    /**
     * Get group urls.
     *
     * @param string $objectid The object ID of the group.
     * @return array|object Array of returned o365 group urls, null on no group data found.
     */
    public function get_group_urls($objectid) {
        $group = $this->get_group($objectid);
        if (empty($group['mailNickname'])) {
            return null;
        }
        $config = get_config('local_o365');
        $url = preg_replace("/-my.sharepoint.com/", ".sharepoint.com", $config->odburl);
        $o365urls = [
            // First time visiting the onedrive or notebook urls will result in a please wait while we provision onedrive message.
            'onedrive' => 'https://'.$url.'/_layouts/groupstatus.aspx?id='.$objectid.'&target=documents',
            'notebook' => 'https://'.$url.'/_layouts/groupstatus.aspx?id='.$objectid.'&target=notebook',
            'conversations' => 'https://outlook.office.com/owa/?path=/group/'.$group['mail'].'/mail',
            'calendar' => 'https://outlook.office365.com/owa/?path=/group/'.$group['mail'].'/calendar',
            'team' => 'https://teams.microsoft.com',
        ];
        return $o365urls;
    }

    /**
     * Get group photo meta data or photo.
     *
     * @param string $objectid The object ID of the group.
     * @return array Array of returned o365 group data.
     */
    public function get_group_photo($objectid, $metadata = true) {
        if ($metadata) {
            $response = $this->apicall('get', '/groups/'.$objectid.'/photo');
            $expectedparams = ['id' => null];
            return $this->process_apicall_response($response, $expectedparams);
        }
        return $this->apicall('get', '/groups/'.$objectid.'/photo/$value');
    }

    /**
     * Upload group photo meta data or photo.
     *
     * @param string $objectid The object ID of the group.
     * @param string $photo Binary string containing image.
     * @return array Array of returned o365 group data.
     */
    public function upload_group_photo($objectid, $photo) {
        global $CFG;
        if (empty($photo)) {
            // Deleting photo, currently delete call is not supported, uploading default profile.
            $photo = file_get_contents($CFG->dirroot.'/local/o365/pix/defaultprofile.png');
        }
        return $this->apicall('patch', '/groups/'.$objectid.'/photo/$value', $photo);
    }

    /**
     * Get a group by it's displayName
     *
     * @param string $name The group name,
     * @return array Array of group information, or null if group not found.
     */
    public function get_group_by_name($name) {
        $response = $this->apicall('get', '/groups?$filter=displayName'.rawurlencode(' eq \''.$name.'\''));
        $expectedparams = ['value' => null];
        $groups = $this->process_apicall_response($response, $expectedparams);
        return (isset($groups['value'][0])) ? $groups['value'][0] : null;
    }

    /**
     * Delete a group.
     *
     * @param string $objectid The object ID of the group.
     * @return bool|string True if group successfully deleted, otherwise returned string (may contain error info, etc).
     */
    public function delete_group($objectid) {
        if (empty($objectid)) {
            return null;
        }
        $response = $this->apicall('delete', '/groups/'.$objectid);
        return ($response === '') ? true : $response;
    }

    /**
     * Get a list of recently deleted groups.
     *
     * @return array Array of returned information.
     */
    public function list_deleted_groups() {
        $response = $this->betaapicall('get', '/directory/deleteditems/Microsoft.Graph.Group');
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Restore a recently deleted group.
     *
     * @param string $objectid The Object ID of the group to be restored.
     * @return array Array of returned information.
     */
    public function restore_deleted_group($objectid) {
        $response = $this->betaapicall('post', '/directory/deleteditems/'.$objectid.'/restore');
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Get a list of all groups a user is member of.
     *
     * @param string $groupobjectid The object ID of the group.
     * @param string $userobjecttid The user ID.
     * @return array Array of groups user is member of.
     */
    public function get_users_groups($groupobjectid, $userobjectid) {
        $endpoint = 'users/'.$userobjectid.'/getMemberGroups';
        $postdata = '{ "securityEnabledOnly": false }';
        $response = $this->apicall('post', $endpoint, $postdata);
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a list of group members.
     *
     * @param string $groupobjectid The object ID of the group.
     * @return array Array of returned members.
     */
    public function get_group_members($groupobjectid) {
        $endpoint = '/groups/'.$groupobjectid.'/members';
        $response = $this->apicall('get', $endpoint);
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a file by it's file id.
     *
     * @param string $parentid The parent id to use.
     * @return array|null Returned response, or null if error.
     */
    public function get_group_files($groupid, $parentid = '') {
        if (!empty($parentid) && $parentid !== '/') {
            $endpoint = "/groups/{$groupid}/drive/items/{$parentid}/children";
        } else {
            $endpoint = "/groups/{$groupid}/drive/root/children";
        }
        $response = $this->apicall('get', $endpoint);
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a file's metadata by it's file id.
     *
     * @param string $fileid The file's ID.
     * @return string The file's content.
     */
    public function get_group_file_metadata($groupid, $fileid) {
        $response = $this->apicall('get', "/groups/{$groupid}/drive/items/{$fileid}");
        $expectedparams = ['id' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Create a readonly sharing link for a group file.
     *
     * @param string $fileid OneDrive file id.
     * @return string Sharing link url.
     */
    public function get_group_file_sharing_link($groupid, $fileid) {
        $params = array('type' => 'view', 'scope' => 'organization');
        $apiresponse = $this->apicall('post', "/groups/{$groupid}/drive/items/{$fileid}/createLink", json_encode($params));
        $response = $this->process_apicall_response($apiresponse);
        return $response['link']['webUrl'];
    }

    /**
     * Get a file's content by it's file id.
     *
     * @param string $fileid The file's ID.
     * @return string The file's content.
     */
    public function get_group_file_by_id($groupid, $fileid) {
        return $this->apicall('get', "/groups/{$groupid}/drive/items/{$fileid}/content");
    }

    /**
     * Add member to group.
     *
     * @param string $groupobjectid The object ID of the group to add to.
     * @param string $memberobjectid The object ID of the item to add (can be group object id or user object id).
     * @return bool|string True if successful, returned string if not (may contain error info, etc).
     */
    public function add_member_to_group($groupobjectid, $memberobjectid) {
        $endpoint = '/groups/'.$groupobjectid.'/members/$ref';
        $data = [
            '@odata.id' => $this->get_apiuri().'/v1.0/directoryObjects/'.$memberobjectid
        ];
        $response = $this->betaapicall('post', $endpoint, json_encode($data));
        return ($response === '') ? true : $response;
    }

    /**
     * Add owner to group.
     *
     * @param string $groupobjectid The object ID of the group to add to.
     * @param string $memberobjectid The object ID of the item to add (user object id).
     * @return bool|string True if successful, returned string if not (may contain error info, etc).
     */
    public function add_owner_to_group($groupobjectid, $memberobjectid) {
        $endpoint = '/groups/'.$groupobjectid.'/owners/$ref';
        $data = [
            '@odata.id' => $this->get_apiuri().'/v1.0/users/'.$memberobjectid
        ];
        $response = $this->betaapicall('post', $endpoint, json_encode($data));
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
        $endpoint = '/groups/'.$groupobjectid.'/members/'.$memberobjectid.'/$ref';
        $response = $this->betaapicall('delete', $endpoint);
        return ($response === '') ? true : $response;
    }

    /**
     * Remove owner from group.
     *
     * @param string $groupobjectid The object ID of the group to remove from.
     * @param string $memberobjectid The object ID of the item to remove (can be group object id or user object id).
     * @return bool|string True if successful, returned string if not (may contain error info, etc).
     */
    public function remove_owner_from_group($groupobjectid, $memberobjectid) {
        $endpoint = '/groups/'.$groupobjectid.'/owners/'.$memberobjectid.'/$ref';
        $response = $this->betaapicall('delete', $endpoint);
        return ($response === '') ? true : $response;
    }

    /**
     * Create a group file.
     *
     * @param string $groupid The group Id.
     * @param string $parentid The parent Id.
     * @param string $filename The file's name.
     * @param string $content The file's content.
     * @return file upload response.
     */
    public function create_group_file($groupid, $parentid = '', $filename, $content, $contenttype = 'text/plain') {
        $filename = rawurlencode($filename);
        if (!empty($parentid) && $parentid !== '/') {
            $endpoint = "/groups/{$groupid}/drive/items/{$parentid}/children/{$filename}/content";
        } else {
            $endpoint = "/groups/{$groupid}/drive/root:/{$filename}:/content";
        }
        $fileresponse = $this->apicall('put', $endpoint, ['file' => $content], ['contenttype' => $contenttype]);
        $expectedparams = ['id' => null];
        $fileresponse = $this->process_apicall_response($fileresponse, $expectedparams);
        return $fileresponse;
    }

    /**
     * Get an array of general user fields to query for.
     *
     * @return array Array of user fields.
     */
    protected function get_default_user_fields() {
        return [
            'id',
            'userPrincipalName',
            'displayName',
            'givenName',
            'surname',
            'mail',
            'streetAddress',
            'city',
            'postalCode',
            'state',
            'country',
            'jobTitle',
            'department',
            'companyName',
            'preferredLanguage',
            'employeeId',
            'businessPhones',
            'mobilePhone',
            'officeLocation',
            'preferredName',
            'manager',
            'teams',
            'groups',
        ];
    }

    /**
     * Get all users in the configured directory.
     *
     * @param string|array $params Requested user parameters.
     * @param string $skiptoken A skiptoken param from a previous get_users query. For pagination.
     * @return array|null Array of user information, or null if failure.
     */
    public function get_users($params = 'default', $skiptoken = '') {
        $endpoint = "/users";
        $odataqueries = [];

        // Select params.
        if ($params === 'default') {
            $params = $this->get_default_user_fields();
        }
        if (is_array($params)) {
            $odataqueries[] = '$select='.implode(',', $params);
        }

        // Skip token.
        if (!empty($skiptoken) && is_string($skiptoken)) {
            $odataqueries[] = '$skiptoken='.$skiptoken;
        }

        // Process and append odata params.
        if (!empty($odataqueries)) {
            $endpoint .= '?'.implode('&', $odataqueries);
        }

        $response = $this->apicall('get', $endpoint);
        return $this->process_apicall_response($response, ['value' => null]);
    }

    public function get_users_delta($params, $skiptoken, $deltatoken) {
        $endpoint = "/users/delta";
        $odataqueries = [];

        // Select params.
        if ($params === 'default') {
            $params = $this->get_default_user_fields();
        }
        if (is_array($params) && empty($skiptoken) && empty($deltatoken)) {
            $odataqueries[] = '$select='.implode(',', $params);
        }

        // Delta/skip tokens.
        if (!empty($skiptoken) && is_string($skiptoken)) {
            $odataqueries[] = '$skiptoken='.$skiptoken;
        } else {
            if (!empty($deltatoken) && is_string($deltatoken)) {
                $odataqueries[] = '$deltatoken='.$deltatoken;
            }
        }

        // Process and append odata params.
        if (!empty($odataqueries)) {
            $endpoint .= '?'.implode('&', $odataqueries);
        }

        $response = $this->apicall('get', $endpoint);
        $result = $this->process_apicall_response($response, ['value' => null]);
        $users = null;
        $skiptoken = null;
        $deltatoken = null;

        if (!empty($result) && is_array($result)) {
            if (!empty($result['value']) && is_array($result['value'])) {
                $users = $result['value'];
            }

            if (isset($result['@odata.nextLink'])) {
                $skiptoken = $this->extract_param_from_link($result['@odata.nextLink'], '$skiptoken');
            }

            if (isset($result['@odata.deltaLink'])) {
                $deltatoken = $this->extract_param_from_link($result['@odata.deltaLink'], '$deltatoken');
            }
        }

        return [$users, $skiptoken, $deltatoken];
    }

    public function get_user_manager($userobjectid) {
        $endpoint = "users/$userobjectid/manager";
        $response = $this->apicall('get', $endpoint);
        $result = $this->process_apicall_response($response, ['value' => null]);
        return $result['value'];
    }

    public function get_user_groups($userobjectid) {
        $endpoint = "users/$userobjectid/memberOf";
        $response = $this->apicall('get', $endpoint);
        $result = $this->process_apicall_response($response, ['value' => null]);
        return $result['value'];
    }

    public function get_user_teams($userobjectid) {
        $endpoint = "users/$userobjectid/joinedTeams";
        $response = $this->apicall('get', $endpoint);
        $result = $this->process_apicall_response($response, ['value' => null]);
        return $result['value'];
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
     * Get a list of recently deleted users.
     *
     * @return array Array of returned information.
     */
    public function list_deleted_users() {
        $response = $this->betaapicall('get', '/directory/deleteditems/Microsoft.Graph.User');
        $response = $this->process_apicall_response($response);
        return $response;
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
        $expectedparams = ['id' => null, 'userPrincipalName' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a list of the user's o365 calendars.
     *
     * @return array|null Returned response, or null if error.
     */
    public function get_calendars() {
        $response = $this->apicall('get', '/me/calendars');
        $expectedparams = ['value' => null];
        $return = $this->process_apicall_response($response, $expectedparams);
        foreach ($return['value'] as $i => $calendar) {
            // Set legacy values.
            if (!isset($calendar['Id']) && isset($calendar['id'])) {
                $return['value'][$i]['Id'] = $calendar['id'];
            }
            if (!isset($calendar['Name']) && isset($calendar['name'])) {
                $return['value'][$i]['Name'] = $calendar['name'];
            }
        }
        return $return;
    }

    /**
     * Create a new calendar in the user's o365 calendars.
     *
     * @param string $name The calendar's title.
     * @return array|null Returned response, or null if error.
     */
    public function create_calendar($name) {
        $calendardata = json_encode(['name' => $name]);
        $response = $this->apicall('post', '/me/calendars', $calendardata);
        $expectedparams = ['id' => null];
        $return = $this->process_apicall_response($response, $expectedparams);
        if (!isset($return['Id']) && isset($return['id'])) {
            $return['Id'] = $return['id'];
        }
        if (!isset($return['Name']) && isset($return['name'])) {
            $return['Name'] = $return['name'];
        }
        return $return;
    }

    /**
     * Update a existing o365 calendar.
     *
     * @param string $calendearid The calendar's title.
     * @param array $updated Array of updated information. Keys are 'name'.
     * @return array|null Returned response, or null if error.
     */
    public function update_calendar($outlookcalendearid, $updated) {
        if (empty($outlookcalendearid) || empty($updated)) {
            return [];
        }
        $updateddata = [];
        if (!empty($updated['name'])) {
            $updateddata['name'] = $updated['name'];
        }
        $updateddata = json_encode($updateddata);
        $response = $this->apicall('patch', '/me/calendars/'.$outlookcalendearid, $updateddata);
        $expectedparams = ['id' => null];
        return  $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Create a new event in the user's o365 calendar.
     *
     * @param string $subject The event's title/subject.
     * @param string $body The event's body/description.
     * @param int $starttime The timestamp when the event starts.
     * @param int $endtime The timestamp when the event ends.
     * @param array $attendees Array of moodle user objects that are attending the event.
     * @param array $other Other parameters to include.
     * @param string $calendarid The o365 ID of the calendar to create the event in.
     * @return array|null Returned response, or null if error.
     */
    public function create_event($subject, $body, $starttime, $endtime, $attendees, array $other = array(), $calendarid = null) {
        $eventdata = [
            'subject' => $subject,
            'body' => [
                'contentType' => 'HTML',
                'content' => $body,
            ],
            'start' => [
                'dateTime' => date('c', $starttime),
                'timeZone' => date('T', $starttime),
            ],
            'end' => [
                'dateTime' => date('c', $endtime),
                'timeZone' => date('T', $endtime),
            ],
            'attendees' => [],
            'responseRequested' => false, // Sets meeting appears as accepted.
        ];
        foreach ($attendees as $attendee) {
            $eventdata['attendees'][] = [
                'EmailAddress' => [
                    'Address' => $attendee->email,
                    'Name' => $attendee->firstname.' '.$attendee->lastname,
                ],
                'type' => 'Resource'
            ];
        }
        $eventdata = array_merge($eventdata, $other);
        $eventdata = json_encode($eventdata);
        $endpoint = (!empty($calendarid)) ? '/me/calendars/'.$calendarid.'/events' : '/me/calendar/events';
        $response = $this->apicall('post', $endpoint, $eventdata);
        $expectedparams = ['id' => null];
        $return = $this->process_apicall_response($response, $expectedparams);
        if (!isset($return['Id']) && isset($return['id'])) {
            $return['Id'] = $return['id'];
        }
        return $return;
    }

    /**
     * Create a new event in the course group's o365 calendar.
     *
     * @param string $subject The event's title/subject.
     * @param string $body The event's body/description.
     * @param int $starttime The timestamp when the event starts.
     * @param int $endtime The timestamp when the event ends.
     * @param array $attendees Array of moodle user objects that are attending the event.
     * @param array $other Other parameters to include.
     * @param string $calendarid The o365 ID of the calendar to create the event in.
     * @return array|null Returned response, or null if error.
     */
    public function create_group_event($subject, $body, $starttime, $endtime, $attendees, array $other = array(), $calendarid = null) {
        $eventdata = [
            'subject' => $subject,
            'body' => [
                'contentType' => 'HTML',
                'content' => $body,
            ],
            'start' => [
                'dateTime' => date('c', $starttime),
                'timeZone' => date('T', $starttime),
            ],
            'end' => [
                'dateTime' => date('c', $endtime),
                'timeZone' => date('T', $endtime),
            ],
            'attendees' => [],
        ];
        foreach ($attendees as $attendee) {
            $eventdata['attendees'][] = [
                'EmailAddress' => [
                    'Address' => $attendee->email,
                    'Name' => $attendee->firstname.' '.$attendee->lastname,
                ],
                'type' => 'Resource'
            ];
        }
        $eventdata = array_merge($eventdata, $other);
        $eventdata = json_encode($eventdata);
        $endpoint =  "/groups/{$calendarid}/calendar/events";
        $response = $this->apicall('post', $endpoint, $eventdata);
        $expectedparams = ['id' => null];
        $return = $this->process_apicall_response($response, $expectedparams);
        if (!isset($return['Id']) && isset($return['id'])) {
            $return['Id'] = $return['id'];
        }
        return $return;
    }

    /**
     * Get a list of events.
     *
     * @param string $calendarid The calendar ID to get events from. If empty, primary calendar used.
     * @param string $since datetime date('c') to get events since.
     * @return array Array of events.
     */
    public function get_events($calendarid = null, $since = null) {
        \core_date::set_default_server_timezone();
        $endpoint = (!empty($calendarid)) ? '/me/calendars/'.$calendarid.'/events' : '/me/calendar/events';
        if (!empty($since)) {
            // Pass datetime in UTC, regardless of Moodle timezone setting.
            $sincedt = new \DateTime('@'.$since);
            $since = urlencode($sincedt->format('Y-m-d\TH:i:s\Z'));
            $endpoint .= '?$filter=CreatedDateTime%20ge%20'.$since;
        }
        $response = $this->apicall('get', $endpoint);
        $expectedparams = ['value' => null];
        $return = $this->process_apicall_response($response, $expectedparams);
        foreach ($return['value'] as $i => $event) {
            // Converts params to the old legacy parameter used by the rest of the code from the new unified parameter.
            if (!isset($event['Id']) && isset($event['id'])) {
                $return['value'][$i]['Id'] = $event['id'];
            }
            if (!isset($event['Subject']) && isset($event['subject'])) {
                $return['value'][$i]['Subject'] = $event['subject'];
            }
            if (!isset($event['Body']) && isset($event['body'])) {
                $return['value'][$i]['Body'] = $event['body'];
                if (!isset($return['value'][$i]['Body']['Content']) && isset($return['value'][$i]['body']['content'])) {
                    $return['value'][$i]['Body']['Content'] = $return['value'][$i]['body']['content'];
                }
            }
            if (!isset($event['Start']) && isset($event['start'])) {
                if (is_array($event['start'])) {
                    $return['value'][$i]['Start'] = $event['start']['dateTime'].' '.$event['start']['timeZone'];
                } else {
                    $return['value'][$i]['Start'] = $event['start'];
                }
            }
            if (!isset($event['End']) && isset($event['end'])) {
                if (is_array($event['end'])) {
                    $return['value'][$i]['End'] = $event['end']['dateTime'].' '.$event['end']['timeZone'];
                } else {
                    $return['value'][$i]['End'] = $event['end'];
                }
            }
        }
        return $return;
    }

    /**
     * Update an event.
     *
     * @param string $outlookeventid The event ID in o365 outlook.
     * @param array $updated Array of updated information. Keys are 'subject', 'body', 'starttime', 'endtime', and 'attendees'.
     * @return array|null Returned response, or null if error.
     */
    public function update_event($outlookeventid, $updated) {
        if (empty($outlookeventid) || empty($updated)) {
            return [];
        }
        $updateddata = [];
        if (!empty($updated['subject'])) {
            $updateddata['subject'] = $updated['subject'];
        }
        if (!empty($updated['body'])) {
            $updateddata['body'] = ['contentType' => 'HTML', 'content' => $updated['body']];
        }
        if (!empty($updated['starttime'])) {
            $updateddata['start'] = [
                'dateTime' => date('c', $updated['starttime']),
                'timeZone' => date('T', $updated['starttime']),
            ];
        }
        if (!empty($updated['endtime'])) {
            $updateddata['end'] = [
                'dateTime' => date('c', $updated['endtime']),
                'timeZone' => date('T', $updated['endtime']),
            ];
        }
        if (!empty($updated['responseRequested'])) {
            $updateddata['responseRequested'] = $updated['responseRequested'];
        }
        if (isset($updated['attendees'])) {
            $updateddata['attendees'] = [];
            foreach ($updated['attendees'] as $attendee) {
                $updateddata['attendees'][] = [
                    'emailAddress' => [
                        'address' => $attendee->email,
                        'name' => $attendee->firstname.' '.$attendee->lastname,
                    ],
                    'type' => 'resource'
                ];
            }
        }
        $updateddata = json_encode($updateddata);
        $response = $this->apicall('patch', '/me/events/'.$outlookeventid, $updateddata);
        $expectedparams = ['id' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Delete an event.
     *
     * @param string $outlookeventid The event ID in o365 outlook.
     * @return bool Success/Failure.
     */
    public function delete_event($outlookeventid) {
        if (!empty($outlookeventid)) {
            $this->apicall('delete', '/me/events/'.$outlookeventid);
        }
        return true;
    }

    /**
     * Create a file.
     *
     * @param string $fileid The file's ID.
     * @return string The file's content.
     */
    public function create_file($parentid, $filename, $content, $contenttype = 'text/plain') {
        $filename = rawurlencode($filename);
        if (!empty($parentid)) {
            $endpoint = "/me/drive/items/{$parentid}/children/{$filename}/content";
        } else {
            $endpoint = "/me/drive/root:/{$filename}:/content";
        }
        $fileresponse = $this->apicall('put', $endpoint, ['file' => $content], ['contenttype' => $contenttype]);
        $expectedparams = ['id' => null];
        $fileresponse = $this->process_apicall_response($fileresponse, $expectedparams);
        return $fileresponse;
    }

    /**
     * Get a file by it's file id.
     *
     * @param string $parentid The parent id to use.
     * @return array|null Returned response, or null if error.
     */
    public function get_files($parentid = '') {
        if (!empty($parentid) && $parentid !== '/') {
            $endpoint = "/me/drive/items/{$parentid}/children";
        } else {
            $endpoint = '/me/drive/root/children';
        }
        $response = $this->apicall('get', $endpoint);
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a files from trendingAround api.
     *
     * @param string $parentid The parent id to use.
     * @return array|null Returned response, or null if error.
     */
    public function get_trending_files($parentid = '') {
        $response = $this->betaapicall('get', '/me/trendingAround');
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a file's data by it's file information.
     *
     * @param string $fileinfo The file's drive id and file id.
     * @return string The file's content.
     */
    public function get_file_data($fileinfo) {
        $response = $this->apicall('get', "/{$fileinfo}");
        $expectedparams = ['id' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a file's content by it's file URL.
     *
     * @param string $url The file's URL.
     * @return string The file's content.
     */
    public function get_file_by_url($url) {
        return $this->httpclient->download_file($url);
    }

    /**
     * Get a file's metadata by it's file id.
     *
     * @param string $fileid The file's ID.
     * @return string The file's content.
     */
    public function get_file_metadata($fileid) {
        $response = $this->apicall('get', "/me/drive/items/{$fileid}");
        $expectedparams = ['id' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a file's content by it's file id.
     *
     * @param string $fileid The file's ID.
     * @return string The file's content.
     */
    public function get_file_by_id($fileid) {
        return $this->apicall('get', "/me/drive/items/{$fileid}/content");
    }

    /**
     * Get information on the current application.
     *
     * @return array|null Array of application information, or null if failure.
     */
    public function get_application_info() {
        $oidcconfig = get_config('auth_oidc');
        $endpoint = '/applications/?$filter=appId%20eq%20\''.$oidcconfig->clientid.'\'';
        $response = $this->betaapicall('get', $endpoint);
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get information on the current application.
     *
     * @return array|null Array of application information, or null if failure.
     */
    public function get_application_serviceprincipal_info() {
        $oidcconfig = get_config('auth_oidc');
        $endpoint = '/servicePrincipals/?$filter=appId%20eq%20\''.$oidcconfig->clientid.'\'';
        $response = $this->betaapicall('get', $endpoint);
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get the service principal object for the Microsoft Graph API.
     *
     * @return array Array representing service principal object.
     */
    public function get_unified_api_serviceprincipal_info() {
        static $response = null;
        if (empty($response)) {
            $graphperms = $this->get_required_permissions('graph');
            $endpoint = '/servicePrincipals?$filter=appId%20eq%20\''.$graphperms['appId'].'\'';
            $response = $this->betaapicall('get', $endpoint);
            $expectedparams = ['value' => null];
            $response = $this->process_apicall_response($response, $expectedparams);
        }
        return $response;
    }

    /**
     * Get all available permissions for the Microsoft Graph API.
     *
     * @return array Array of available permissions, include descriptions and keys.
     */
    public function get_available_permissions() {
        $svc = $this->get_unified_api_serviceprincipal_info();
        if (empty($svc) || !is_array($svc)) {
            return null;
        }
        if (!isset($svc['value']) || !isset($svc['value'][0])) {
            return null;
        }
        if (isset($svc['value'][0]['oauth2Permissions'])) {
            return $svc['value'][0]['oauth2Permissions'];
        } else if (isset($svc['value'][0]['publishedPermissionScopes'])) {
            return $svc['value'][0]['publishedPermissionScopes'];
        } else {
            return null;
        }
    }

    /**
     * Get all available app-only permissions for the graph api.
     *
     * @return array Array of available app-only permissions, indexed by permission name.
     */
    public function get_graph_available_apponly_permissions() {
        // Get list of permissions and associated IDs.
        $graphsp = $this->get_unified_api_serviceprincipal_info();
        $graphsp = $graphsp['value'][0];
        $graphappid = $graphsp['appId'];
        $graphperms = [];
        foreach ($graphsp['appRoles'] as $perm) {
            $graphperms[$perm['value']] = $perm;
        }
        return $graphperms;
    }

    /**
     * Get currently configured app-only permissions for the graph api.
     *
     * @return array Array of current app-only permissions, indexed by permission name.
     */
    public function get_graph_current_apponly_permissions() {
        // Get available permissions.
        $graphsp = $this->get_unified_api_serviceprincipal_info();
        $graphsp = $graphsp['value'][0];
        $graphappid = $graphsp['appId'];
        $graphperms = [];
        foreach ($graphsp['appRoles'] as $perm) {
            $graphperms[$perm['id']] = $perm;
        }

        // Get a list of configured permissions for the graph api within the client application.
        $appinfo = $this->get_application_info();
        $appinfo = $appinfo['value'][0];
        $graphresource = null;
        foreach ($appinfo['requiredResourceAccess'] as $resource) {
            if ($resource['resourceAppId'] === $graphappid) {
                $graphresource = $resource;
                break;
            }
        }
        if (empty($graphresource)) {
            throw new \Exception('Unable to find graph api in application.');
        }

        // Translate to permission information.
        $currentperms = [];
        foreach ($graphresource['resourceAccess'] as $resource) {
            if ($resource['type'] === 'Role') {
                if (isset($graphperms[$resource['id']])) {
                    $perminfo = $graphperms[$resource['id']];
                    $currentperms[$perminfo['value']] = $perminfo;
                }
            }
        }
        return $currentperms;
    }

    /**
     * Get information on the current application.
     *
     * @return array|null Array of application information, or null if failure.
     */
    public function get_permission_grants($resourceid = '') {
        $appinfo = $this->get_application_serviceprincipal_info();
        if (empty($appinfo) || !is_array($appinfo)) {
            return null;
        }
        if (!isset($appinfo['value']) || !isset($appinfo['value'][0]) || !isset($appinfo['value'][0]['id'])) {
            return null;
        }
        $appobjectid = $appinfo['value'][0]['id'];
        $endpoint = '/oauth2PermissionGrants?$filter=clientId%20eq%20\''.$appobjectid.'\'';
        if (!empty($resourceid)) {
            $endpoint .= '%20and%20resourceId%20eq%20\''.$resourceid.'\'';
        }
        $response = $this->betaapicall('get', $endpoint);
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Get currently assigned permissions for the Microsoft Graph API.
     *
     * @return array Array of permission keys.
     */
    public function get_unified_api_permissions() {
        $apiinfo = $this->get_unified_api_serviceprincipal_info();
        if (empty($apiinfo) || !is_array($apiinfo)) {
            return null;
        }
        if (!isset($apiinfo['value']) || !isset($apiinfo['value'][0]) || !isset($apiinfo['value'][0]['id'])) {
            return null;
        }
        $apiobjectid = $apiinfo['value'][0]['id'];
        $permgrants = $this->get_permission_grants($apiobjectid);
        if (empty($permgrants) || !is_array($permgrants)) {
            return null;
        }
        if (!isset($permgrants['value']) || !isset($permgrants['value'][0]) || !isset($permgrants['value'][0]['scope'])) {
            return null;
        }
        $scopes = explode(' ', $permgrants['value'][0]['scope']);
        return $scopes;
    }

    /**
     * Get an array of the current required permissions for the graph api.
     *
     * @return array Array of required Azure AD permissions.
     */
    public function get_graph_required_permissions() {
        $allperms = $this->get_required_permissions();
        if (isset($allperms['graph'])) {
            $graphperms = $allperms['graph']['requiredDelegatedPermissions'];
            return array_keys($graphperms);
        }
        return [];
    }

    /**
     * Get required app-only permissions for the graph api.
     *
     * @return array Array of required Azure AD application permissions.
     */
    public function get_graph_required_apponly_permissions() {
        $allperms = $this->get_required_permissions();
        if (isset($allperms['graph'])) {
            $graphperms = $allperms['graph']['requiredAppPermissions'];
            return array_keys($graphperms);
        }
        return [];
    }

    public function check_graph_apponly_permissions() {
        $this->token->refresh();
        $requiredperms = $this->get_graph_required_apponly_permissions();
        $currentperms = $this->get_graph_current_apponly_permissions();
        $availableperms = $this->get_graph_available_apponly_permissions();

        $requiredperms = array_flip($requiredperms);
        $missingperms = array_diff_key($requiredperms, $currentperms);
        $missingperminfo = [];
        foreach ($missingperms as $permname => $index) {
            if (isset($availableperms[$permname])) {
                $missingperminfo[$permname] = $availableperms[$permname]['displayName'];
            } else {
                $missingperminfo[$permname] = $permname;
            }
        }
        return $missingperminfo;
    }

    /**
     * Check whether all required permissions are present.
     *
     * @return array Array of missing permissions, permission key as array key, human-readable name as values.
     */
    public function check_graph_delegated_permissions() {
        $this->token->refresh();
        $currentperms = $this->get_unified_api_permissions();
        $neededperms = $this->get_graph_required_permissions();
        $availableperms = $this->get_available_permissions();

        if ($currentperms === null || $availableperms === null) {
            return null;
        }

        sort($currentperms);
        sort($neededperms);

        $missingperms = array_diff($neededperms, $currentperms);
        if (empty($missingperms)) {
            return [];
        }

        // Assemble friendly names for permissions.
        $permnames = [];
        foreach ($availableperms as $perminfo) {
            if (!isset($perminfo['value']) || !isset($perminfo['adminConsentDisplayName'])) {
                continue;
            }
            $permnames[$perminfo['value']] = $perminfo['adminConsentDisplayName'];
        }

        $missingpermsreturn = [];
        foreach ($missingperms as $missingperm) {
            $missingpermsreturn[$missingperm] = (isset($permnames[$missingperm])) ? $permnames[$missingperm] : $missingperm;
        }

        return $missingpermsreturn;
    }

    /**
     * Check whether all permissions defined in $this->get_required_permissions have been assigned.
     *
     * @return array Array of missing permissions.
     */
    public function check_legacy_permissions() {
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
                    // If $permids is empty no candidate permission exists in the application.
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
        return [$missingperms, false];
    }

    /**
     * Get a users photo.
     * @param $user User to retrieve photo.
     * @param $height Height of image to retrieve.
     * @param $width Width of image to retrieve.
     * @return array|null Returned binary photo data, false if there is no photo.
     */
    public function get_photo($user, $height = null, $width = null) {
        if (!empty($width) && !empty($height)) {
            return $this->betaapicall('get', "/Users('$user')/Photos('".$height."x".$width."')/\$value");
        } else {
            return $this->apicall('get', "/Users('$user')/Photo/\$value");
        }
        return false;
    }

    /**
     * Get photo meta data.
     * @param $user User to retrieve photo meta data for.
     * @param $minsize Minimum size to retrieve. 0 to return all sizes.
     * @return array|null Return array of sizes or single size if minsize is set, or false if error.
     */
    public function get_photo_metadata($user, $minsize = 100) {
        $response = $this->betaapicall('get', "/Users('$user')/Photos");
        $data = json_decode($response, true);
        // Photo not found.
        if (!empty($data['error'])) {
            return false;
        }
        $expected = array('value' => null);
        $photo = $this->process_apicall_response($response, $expected);
        if (empty($minsize)) {
            return $photo['value'];
        }
        $lastsize = $photo['value'];
        if (count($photo['value'])) {
            foreach ($photo['value'] as $size) {
                $lastsize = $size;
                if ($size['height'] >= $minsize) {
                    break;
                }
            }
        }
        return $lastsize;
    }

    /**
     * Create readonly link for onedrive file.
     *
     * @param string $fileid onedrive file id.
     * @return string Readonly file url.
     */
    public function get_sharing_link($fileid) {
        $params = array('type' => 'view', 'scope' => 'organization');
        $apiresponse = $this->apicall('post', "/me/drive/items/$fileid/createLink", json_encode($params));
        $response = $this->process_apicall_response($apiresponse);
        return $response['link']['webUrl'];
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
        $response = $this->betaapicall('get', $endpoint);
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
                        $permissionslist = [];
                        if (isset($appdata['oauth2Permissions'])) {
                            $permissionslist = $appdata['oauth2Permissions'];
                        } else if (isset($appdata['publishedPermissionScopes'])) {
                            $permissionslist = $appdata['publishedPermissionScopes'];
                        }
                        foreach ($permissionslist as $i => $permdata) {
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
     * Add a user to a course o365 usergroup.
     *
     * @param int $courseid The ID of the Moodle group.
     * @param int $userid The ID of the Moodle user.
     *
     * @return bool|null|string True if successful, null if not applicable, string if other API error.
     * @throws \dml_exception
     */
    public function add_user_to_course_group($courseid, $userid) {
        global $DB;

        $filters = ['type' => 'group', 'subtype' => 'course', 'moodleid' => $courseid];
        $coursegroupobject = $DB->get_record('local_o365_objects', $filters);
        if (empty($coursegroupobject)) {
            return null;
        }

        $sql = "SELECT u.id,
                       objs.objectid as userobjectid
                  FROM {user} u
                  JOIN {local_o365_objects} objs ON objs.moodleid = u.id
                 WHERE u.deleted = 0 AND objs.type = :user AND u.id = :userid";
        $params['user'] = 'user';
        $params['userid'] = $userid;
        $userobject = $DB->get_record_sql($sql, $params);

        if (empty($userobject)) {
            return null;
        }

        $response = $this->add_member_to_group($coursegroupobject->objectid, $userobject->userobjectid);
        return $response;
    }

    /**
     * Add a user as owner to a course o365 usergroup.
     *
     * @param int $courseid The ID of the Moodle group.
     * @param int $userid The ID of the Moodle user.
     *
     * @return bool|null|string True if successful, null if not applicable, string if other API error.
     * @throws \dml_exception
     */
    public function add_owner_to_course_group($courseid, $userid) {
        global $DB;

        $filters = ['type' => 'group', 'subtype' => 'course', 'moodleid' => $courseid];
        $coursegroupobject = $DB->get_record('local_o365_objects', $filters);
        if (empty($coursegroupobject)) {
            return null;
        }

        $sql = "SELECT u.id,
                       objs.objectid as userobjectid
                  FROM {user} u
                  JOIN {local_o365_objects} objs ON objs.moodleid = u.id
                 WHERE u.deleted = 0 AND objs.type = :user AND u.id = :userid";
        $params['user'] = 'user';
        $params['userid'] = $userid;
        $userobject = $DB->get_record_sql($sql, $params);

        if (empty($userobject)) {
            return null;
        }

        $response = $this->add_owner_to_group($coursegroupobject->objectid, $userobject->userobjectid);
        return $response;
    }

    /**
     * Remove a user from a course o365 usergroup.
     *
     * @param int $courseid The ID of the Moodle group.
     * @param int $userid The ID of the Moodle user.
     *
     * @return bool|null|string True if successful, null if not applicable, string if other API error.
     * @throws \dml_exception
     */
    public function remove_user_from_course_group($courseid, $userid) {
        global $DB;

        $filters = ['type' => 'group', 'subtype' => 'course', 'moodleid' => $courseid];
        $coursegroupobject = $DB->get_record('local_o365_objects', $filters);
        if (empty($coursegroupobject)) {
            return null;
        }

        $sql = "SELECT u.id,
                       objs.objectid as userobjectid
                  FROM {user} u
                  JOIN {local_o365_objects} objs ON objs.moodleid = u.id
                 WHERE u.deleted = 0 AND objs.type = :user AND u.id = :userid";
        $params['user'] = 'user';
        $params['userid'] = $userid;
        $userobject = $DB->get_record_sql($sql, $params);

        if (empty($userobject)) {
            return null;
        }

        $response = $this->remove_member_from_group($coursegroupobject->objectid, $userobject->userobjectid);
        return $response;
    }

    /**
     * Remove an owner from a course o365 usergroup.
     *
     * @param int $courseid The ID of the Moodle group.
     * @param int $userid The ID of the Moodle user.
     *
     * @return bool|null|string True if successful, null if not applicable, string if other API error.
     * @throws \dml_exception
     */
    public function remove_owner_from_course_group($courseid, $userid) {
        global $DB;

        $filters = ['type' => 'group', 'subtype' => 'course', 'moodleid' => $courseid];
        $coursegroupobject = $DB->get_record('local_o365_objects', $filters);
        if (empty($coursegroupobject)) {
            return null;
        }

        $sql = "SELECT u.id,
                       objs.objectid as userobjectid
                  FROM {user} u
                  JOIN {local_o365_objects} objs ON objs.moodleid = u.id
                 WHERE u.deleted = 0 AND objs.type = :user AND u.id = :userid";
        $params['user'] = 'user';
        $params['userid'] = $userid;
        $userobject = $DB->get_record_sql($sql, $params);

        if (empty($userobject)) {
            return null;
        }

        $response = $this->remove_owner_from_group($coursegroupobject->objectid, $userobject->userobjectid);
        return $response;
    }

    /**
     * Get a specific user's information.
     *
     * @param string $oid The user's object id.
     * @return array|null Array of user information, or null if failure.
     */
    public function get_user($oid, $params = 'default') {
        $endpoint = "/users/{$oid}";
        $odataqueries = [];
        $context = 'https://graph.microsoft.com/v1.0/$metadata#users/$entity';
        if ($params === 'default') {
            $params = $this->get_default_user_fields();
            $context = 'https://graph.microsoft.com/v1.0/$metadata#users(';
            $context = $context.join(',', $params).')/$entity';
            $odataqueries[] = '$select='.implode(',', $params);
        }
        if (!empty($odataqueries)) {
            $endpoint .= '?'.implode('&', $odataqueries);
        }
        $response = $this->apicall('get', $endpoint);
        $expectedparams = [
            '@odata.context' => $context,
            'id' => null,
            'userPrincipalName' => null,
        ];
        $result = $this->process_apicall_response($response, $expectedparams);
        if (!empty($result['id'])) {
            $result['objectId'] = $result['id'];
        }
        return $result;
    }

    /**
     * Validate that a given SharePoint url is accessible with the given client data.
     *
     * @param string $uncleanurl Uncleaned, unvalidated URL to check.
     * @return string One of:
     *                    "invalid" : The URL is not a usable SharePoint url.
     *                    "notempty" : The URL is a usable SharePoint url, and the SharePoint site exists.
     *                    "valid" : The URL is a usable SharePoint url, and the SharePoint site doesn't exist.
     */
    public function sharepoint_validate_site($uncleanurl) {
        if (!filter_var($uncleanurl, FILTER_VALIDATE_URL)) {
            return 'invalid';
        }
        $parsedurl = parse_url($uncleanurl);

        try {
            $site = $this->sharepoint_get_site($parsedurl['host']);
        } catch (\Exception $e) {
            return 'invalid';
        }

        if (empty($parsedurl['path']) || $parsedurl['path'] == '/') {
            return 'notempty';
        } else {
            try {
                $site = $this->sharepoint_get_site($parsedurl['host'], $parsedurl['path']);
                return 'notempty';
            } catch (\Exception $e) {
                return 'valid';
            }
        }
    }

    /**
     * Get a sharepoint site.
     *
     * @param string $hostname The hostname of the top-level sharepoint site.
     * @param string $subsitepath A path to a subsite if you want to get a subsite.
     * @return array Site information.
     */
    public function sharepoint_get_site($hostname, $subsitepath = null) {
        $endpoint = '/sites/'.$hostname;
        if (!empty($subsitepath)) {
            $endpoint .= ':'.$subsitepath;
        }
        $response = $this->apicall('get', $endpoint);
        $expectedparams = ['id' => null];
        $result = $this->process_apicall_response($response, $expectedparams);
        return $result;
    }

    /**
     * Determine if a sharepoint site exists.
     *
     * @param string $hostname The hostname of the top-level sharepoint site.
     * @param string $subsitepath A path to a subsite if you want to get a subsite.
     * @return bool Whether a sharepoint site exists.
     */
    public function sharepoint_site_exists($hostname, $subsitepath = null) {
        try {
            $site = $this->sharepoint_get_site($hostname, $subsitepath);
            return (!empty($site) && !empty($site['id'])) ? true : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Create a sharepoint site.
     *
     * NOTE: Not yet supported in graph API.
     *
     * @param string $hostname The hostname of the top-level sharepoint site.
     * @param string $subsitepath A path to a subsite if you want to get a subsite.
     * @param string $name The name of the site.
     * @param string $description The description of the site.
     */
    public function sharepoint_create_site($hostname, $subsitepath, $name, $description) {
        throw new \Exception('Not yet supported with the Graph API');
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
                \local_o365\utils::debug('User not found', 'local_o365\rest\unified::get_muser_upn', $user);
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
                $apiclient = \local_o365\utils::get_api();
            } catch (\Exception $e) {
                \local_o365\utils::debug($e->getMessage(), 'local_o365\rest\unified::get_muser_upn', $e);
                return false;
            }
            $userdata = $apiclient->get_user($o365user->objectid);
            if (\local_o365\rest\unified::is_configured() && empty($userdata['objectId']) && !empty($userdata['id'])) {
                $userdata['objectId'] = $userdata['id'];
            }
            $userobjectdata = (object)[
                'type' => 'user',
                'subtype' => '',
                'objectid' => $userdata['objectId'],
                'o365name' => $userdata['userPrincipalName'],
                'moodleid' => $user->id,
                'timecreated' => $now,
                'timemodified' => $now,
            ];
            $userobjectdata->id = $DB->insert_record('local_o365_objects', $userobjectdata);
            return $userobjectdata->o365name;
        }
    }

    /**
     * Create a team from group.
     *
     * @param $groupobjectid
     *
     * @return mixed
     * @throws \moodle_exception
     */
    public function create_team($groupobjectid) {
        $teamdata = [
            'template@odata.bind' => "https://graph.microsoft.com/beta/teamsTemplates('standard')",
            'group@odata.bind' => "https://graph.microsoft.com/v1.0/groups('{$groupobjectid}')",
        ];

        // Create a group first.
        $this->betaapicall('post', '/teams', json_encode($teamdata));

        if ($this->httpclient->info['http_code'] == 202) {
            // If response is 202 Accepted, return response.
            return $this->httpclient->response;
        } else if ($this->httpclient->info['http_code'] == 409) {
            // If response is 409, conflict is found, i.e. Team has already been created from the group.
            return true;
        } else {
            // Error.
            throw new \moodle_exception('errorcreatingteamfromgroup', 'local_o365');
        }
    }

    /**
     * Provision an app in a team.
     *
     * @param $groupobjectid
     * @param $appid
     *
     * @return array|string|null
     * @throws \moodle_exception
     */
    public function provision_app($groupobjectid, $appid) {
        $endpoint = '/teams/' . $groupobjectid . '/installedApps';
        $data = [
            'teamsApp@odata.bind' => $this->get_apiuri() . '/beta/appCatalogs/teamsApps/' . $appid,
        ];
        $response = $this->betaapicall('post', $endpoint, json_encode($data));

        return $response;
    }

    /**
     * Return the ID of the app with the given internalId in the catalog.
     *
     * @param $externalappid
     *
     * @return |null
     * @throws \moodle_exception
     */
    public function get_catalog_app_id($externalappid) {
        $moodleappid = null;

        $endpoint = '/appCatalogs/teamsApps?$filter=externalId' . rawurlencode(' eq \'' . $externalappid . '\'');
        $response = $this->betaapicall('get', $endpoint);
        $expectedparams = ['value' => null];
        $response = $this->process_apicall_response($response, $expectedparams);
        if (count($response['value']) > 0) {
            $moodleapp = array_shift($response['value']);
            $moodleappid = $moodleapp['id'];
        }


        return $moodleappid;
    }

    /**
     * Return the ID of the general channel of the team.
     *
     * @param $groupobjectid
     *
     * @return |null
     * @throws \moodle_exception
     */
    public function get_general_channel_id($groupobjectid) {
        $generalchannelid = null;

        $endpoint = '/teams/' . $groupobjectid . '/channels?$filter=displayName' . rawurlencode(' eq \'General\'');
        $response = $this->betaapicall('get', $endpoint);
        $expectedparams = ['value' => null];
        $response = $this->process_apicall_response($response, $expectedparams);
        if (count($response['value']) > 0) {
            $generalchannel = array_shift($response['value']);
            $generalchannelid = $generalchannel['id'];
        }

        return $generalchannelid;
    }

    /**
     * Add a Moodle tab for the Moodle course to a channel.
     *
     * @param $groupobjectid
     * @param $channelid
     * @param $appid
     * @param $moodlecourseid
     *
     * @return array|string|null
     * @throws \coding_exception
     * @throws \moodle_exception
     */
    public function add_moodle_tab_to_channel($groupobjectid, $channelid, $appid, $moodlecourseid) {
        global $CFG;

        $tabconfiguration = [
            'entityId' => 'course_' . $moodlecourseid,
            'contentUrl' => $CFG->wwwroot . '/local/o365/teams_tab.php?id=' . $moodlecourseid,
            'websiteUrl' => $CFG->wwwroot . '/course/view.php?id=' . $moodlecourseid,
        ];

        return $this->add_tab_to_channel($groupobjectid, $channelid, $appid, $tabconfiguration);
    }

    /**
     * Add a tab of app to a channel.
     *
     * @param $groupobjectid
     * @param $channelid
     * @param $appid
     * @param $tabconfiguration
     *
     * @return array|string|null
     * @throws \coding_exception
     * @throws \moodle_exception
     */
    public function add_tab_to_channel($groupobjectid, $channelid, $appid, $tabconfiguration) {
        $endpoint = '/teams/' . $groupobjectid . '/channels/' . $channelid . '/tabs';
        $requestparams = [
            'displayName' => get_string('tab_moodle', 'local_o365'),
            'teamsApp@odata.bind' => $this->get_apiuri() . '/beta/appCatalogs/teamsApps/' . $appid,
            'configuration' => $tabconfiguration,
        ];

        $response = $this->betaapicall('post', $endpoint, json_encode($requestparams));
        $expectedresponse = ['id' => null];
        $response = $this->process_apicall_response($response, $expectedresponse);

        return $response;
    }

    /**
     * Create a class team.
     *
     * @param string $displayname
     * @param string $description
     * @param array $ownerids
     * @param null $extra
     *
     * @return array|null
     * @throws \moodle_exception
     */
    public function create_class_team($displayname, $description, $ownerid, $extra = null) {
        $owneridparam = ["https://graph.microsoft.com/beta/users/{$ownerid}"];
        $description = substr($description,0,1024); // API restricts length to 1024 chars
        $teamdata = [
            'template@odata.bind' => "https://graph.microsoft.com/beta/teamsTemplates('educationClass')",
            'displayName' => $displayname,
            'description' => $description,
            'owners@odata.bind' => $owneridparam,
        ];

        if (!empty($extra) && is_array($extra)) {
            foreach ($extra as $name => $value) {
                $teamdata[$name] = $value;
            }
        }

        if (empty($teamdata['description'])) {
            unset($teamdata['description']);
        }

        return $this->betaapicall('post', '/teams', json_encode($teamdata));
    }
}
