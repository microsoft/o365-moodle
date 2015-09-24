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
 * Client for unified Office 365 API.
 */
class unified extends \local_o365\rest\o365api {
    /**
     * Determine if the API client is configured.
     *
     * @return bool Whether the API client is configured.
     */
    public static function is_configured() {
        $config = get_config('local_o365');
        return (static::is_enabled() && !empty($config->aadtenant) && !empty($config->unifiedapiactive)) ? true : false;
    }

    /**
     * Switch to disable unified API until release.
     *
     * @return bool Whether the unified API is enabled.
     */
    public static function is_enabled() {
        return true;
    }

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_resource() {
        return 'https://graph.microsoft.com';
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        return 'https://graph.microsoft.com/beta';
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
    public function tenantapicall($httpmethod, $apimethod, $params = '', $options = array()) {
        $config = get_config('local_o365');
        if (empty($config->aadtenant)) {
            throw new \moodle_exception('erroracplocalo365notconfig', 'local_o365');
        }
        $apimethod = '/'.$config->aadtenant.$apimethod;
        return parent::apicall($httpmethod, $apimethod, $params, $options);
    }

    /**
     * Get a list of groups.
     *
     * @return array List of groups.
     */
    public function get_groups() {
        $response = $this->tenantapicall('get', '/groups');
        $expectedparams = ['value' => null];
        $response = $this->process_apicall_response($response, $expectedparams);
        if (!empty($response) && isset($response['value'])) {
            return $response['value'];
        } else {
            return null;
        }
    }

    /**
     * Create a group.
     *
     * @param string $name The name of the group.
     * @return array Array of returned o365 group data.
     */
    public function create_group($name, $mailnickname = null) {
        if (empty($mailnickname)) {
            $mailnickname = strtolower(preg_replace('/[^a-z0-9]+/iu', '', $name));
        }

        $groupdata = [
            'groupTypes' => ['Unified'],
            'displayName' => $name,
            'mailEnabled' => false,
            'securityEnabled' => true,
            'mailNickname' => $mailnickname,
        ];
        $response = $this->tenantapicall('post', '/groups', json_encode($groupdata));
        $expectedparams = ['objectId' => null, 'objectType' => 'Group'];
        $response = $this->process_apicall_response($response, $expectedparams);
        return $response;
    }

    /**
     * Get group info.
     *
     * @param string $objectid The object ID of the group.
     * @return array Array of returned o365 group data.
     */
    public function get_group($objectid) {
        $response = $this->tenantapicall('get', '/groups/'.$objectid);
        $expectedparams = ['objectId' => null, 'objectType' => 'Group'];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Delete a group.
     *
     * @param string $objectid The object ID of the group.
     * @return bool|string True if group successfully deleted, otherwise returned string (may contain error info, etc).
     */
    public function delete_group($objectid) {
        $response = $this->tenantapicall('delete', '/groups/'.$objectid);
        return ($response === '') ? true : $response;
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
        if ($params === 'default') {
            $params = ['mail', 'city', 'country', 'department', 'givenName', 'surname', 'preferredLanguage', 'userPrincipalName'];
        }
        if (empty($skiptoken) || !is_string($skiptoken)) {
            $skiptoken = '';
        }
        if (!empty($skiptoken)) {
            $endpoint .= '?$skiptoken='.$skiptoken;
        }
        $response = $this->tenantapicall('get', $endpoint);
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Get a list of the user's o365 calendars.
     *
     * @return array|null Returned response, or null if error.
     */
    public function get_calendars() {
        $response = $this->apicall('get', '/me/calendars');
        $response = @json_decode($response, true);
        return $response;
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
            'Subject' => $subject,
            'Body' => [
                'ContentType' => 'HTML',
                'Content' => $body,
            ],
            'Start' => date('c', $starttime),
            'End' => date('c', $endtime),
            'Attendees' => [],
        ];
        foreach ($attendees as $attendee) {
            $eventdata['Attendees'][] = [
                'EmailAddress' => [
                    'Address' => $attendee->email,
                    'Name' => $attendee->firstname.' '.$attendee->lastname,
                ],
                'Type' => 'Resource'
            ];
        }
        $eventdata = array_merge($eventdata, $other);
        $eventdata = json_encode($eventdata);
        $endpoint = (!empty($calendarid)) ? '/me/calendars/'.$calendarid.'/events' : '/me/events';
        $response = $this->apicall('post', $endpoint, $eventdata);
        $response = @json_decode($response, true);
        return $response;
    }

    /**
     * Get a list of events.
     *
     * @param string $calendarid The calendar ID to get events from. If empty, primary calendar used.
     * @param string $since datetime date('c') to get events since.
     * @return array Array of events.
     */
    public function get_events($calendarid = null, $since = null) {
        $endpoint = (!empty($calendarid)) ? '/me/calendars/'.$calendarid.'/events' : '/me/events';
        if (!empty($since)) {
            $since = date('c', $since);
            $endpoint .= '?$filter=DateTimeCreated%20ge%20'.$since;
        }
        $response = $this->apicall('get', $endpoint);
        $response = $this->process_apicall_response($response);
        return $response;
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
            $updateddata['Subject'] = $updated['subject'];
        }
        if (!empty($updated['body'])) {
            $updateddata['Body'] = ['ContentType' => 'HTML', 'Content' => $updated['body']];
        }
        if (!empty($updated['starttime'])) {
            $updateddata['Start'] = date('c', $updated['starttime']);
        }
        if (!empty($updated['endtime'])) {
            $updateddata['End'] = date('c', $updated['endtime']);
        }
        if (isset($updated['attendees'])) {
            $updateddata['Attendees'] = [];
            foreach ($updated['attendees'] as $attendee) {
                $updateddata['Attendees'][] = [
                    'EmailAddress' => [
                        'Address' => $attendee->email,
                        'Name' => $attendee->firstname.' '.$attendee->lastname,
                    ],
                    'Type' => 'Resource'
                ];
            }
        }
        $updateddata = json_encode($updateddata);
        $response = $this->apicall('patch', '/me/events/'.$outlookeventid, $updateddata);
        $response = @json_decode($response, true);
        return $response;
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
        $params = json_encode(['name' => $filename, 'type' => 'File']);
        $endpoint = '/me/files';
        $fileresponse = $this->apicall('post', $endpoint, $params);
        $fileresponse = $this->process_apicall_response($fileresponse);
        if (isset($fileresponse['id'])) {
            $endpoint = '/me/files/'.$fileresponse['id'].'/uploadContent';
            $contentresponse = $this->apicall('post', $endpoint, $content, ['contenttype' => $contenttype]);
        }
        return $fileresponse;
    }

    /**
     * Get a file by it's file id.
     *
     * @param string $parentid The parent id to use.
     * @return array|null Returned response, or null if error.
     */
    public function get_files($parentid = '') {
        $endpoint = '/me/files';
        if (!empty($parentid) && $parentid !== '/') {
            $endpoint .= "/{$parentid}/children";
        }
        $response = $this->apicall('get', $endpoint);
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Get a file's metadata by it's file id.
     *
     * @param string $fileid The file's ID.
     * @return string The file's content.
     */
    public function get_file_metadata($fileid) {
        $response = $this->apicall('get', "/me/files/{$fileid}");
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Get a file by it's file id.
     *
     * @param string $fileid The file's ID.
     * @return string The file's content.
     */
    public function get_file_by_id($fileid) {
        return $this->apicall('get', "/me/files/{$fileid}/content");
    }

    /**
     * Get information on the current application.
     *
     * @return array|null Array of application information, or null if failure.
     */
    public function get_application_info() {
        $oidcconfig = get_config('auth_oidc');
        $endpoint = '/applications/?$filter=appId%20eq%20\''.$oidcconfig->clientid.'\'';
        $response = $this->tenantapicall('get', $endpoint);
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
        $response = $this->tenantapicall('get', $endpoint);
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get the service principal object for the unified API.
     *
     * @return array Array representing service principal object.
     */
    public function get_unified_api_serviceprincipal_info() {
        static $response = null;
        if (empty($response)) {
            $endpoint = '/servicePrincipals?$filter=displayName%20eq%20\'Microsoft.Azure.AgregatorService\'';
            $response = $this->tenantapicall('get', $endpoint);
            $expectedparams = ['value' => null];
            $response = $this->process_apicall_response($response, $expectedparams);
        }
        return $response;
    }

    /**
     * Get all available permissions for the unified API.
     *
     * @return array Array of available permissions, include descriptions and keys.
     */
    public function get_available_permissions() {
        $svc = $this->get_unified_api_serviceprincipal_info();
        if (empty($svc) || !is_array($svc)) {
            return null;
        }
        if (!isset($svc['value']) || !isset($svc['value'][0]) || !isset($svc['value'][0]['oauth2Permissions'])) {
            return null;
        }
        return $svc['value'][0]['oauth2Permissions'];
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
        if (!isset($appinfo['value']) || !isset($appinfo['value'][0]) || !isset($appinfo['value'][0]['objectId'])) {
            return null;
        }
        $appobjectid = $appinfo['value'][0]['objectId'];
        $endpoint = '/oauth2PermissionGrants?$filter=clientId%20eq%20\''.$appobjectid.'\'';
        if (!empty($resourceid)) {
            $endpoint .= '%20and%20resourceId%20eq%20\''.$resourceid.'\'';
        }
        $response = $this->tenantapicall('get', $endpoint);
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Get currently assigned permissions for the unified API.
     *
     * @return array Array of permission keys.
     */
    public function get_unified_api_permissions() {
        $apiinfo = $this->get_unified_api_serviceprincipal_info();
        if (empty($apiinfo) || !is_array($apiinfo)) {
            return null;
        }
        if (!isset($apiinfo['value']) || !isset($apiinfo['value'][0]) || !isset($apiinfo['value'][0]['objectId'])) {
            return null;
        }
        $apiobjectid = $apiinfo['value'][0]['objectId'];
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
     * Get an array of the current required permissions.
     *
     * @return array Array of required AzureAD application permissions.
     */
    public function get_required_permissions() {
        return [
            'openid',
            'Calendars.ReadWrite',
            'Directory.AccessAsUser.All',
            'Directory.ReadWrite.All',
            'Files.ReadWrite',
            'User.ReadWrite.All',
            'Group.ReadWrite.All',
            'Sites.ReadWrite.All',
        ];
    }

    /**
     * Check whether all required permissions are present.
     *
     * @return array Array of missing permissions, permission key as array key, human-readable name as values.
     */
    public function check_permissions() {
        $this->disableratelimit = true;
        $currentperms = $this->get_unified_api_permissions();
        $neededperms = $this->get_required_permissions();
        $availableperms = $this->get_available_permissions();
        $this->disableratelimit = false;

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
}