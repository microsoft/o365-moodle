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
        $enabled = get_config('local_o365', 'enableunifiedapi');
        return (!empty($enabled)) ? true : false;
    }

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_resource() {
        return (static::use_chinese_api() === true) ? 'https://microsoftgraph.chinacloudapi.cn' : 'https://graph.microsoft.com';
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        return (static::use_chinese_api() === true) ? 'https://microsoftgraph.chinacloudapi.cn' : 'https://graph.microsoft.com';
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
    public function betatenantapicall($httpmethod, $apimethod, $params = '', $options = array()) {
        $config = get_config('local_o365');
        if (empty($config->aadtenant)) {
            throw new \moodle_exception('erroracplocalo365notconfig', 'local_o365');
        }
        $apimethod = '/beta/'.$config->aadtenant.$apimethod;
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
        $apimethod = '/v1.0'.$apimethod;
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
    public function tenantapicall($httpmethod, $apimethod, $params = '', $options = array()) {
        $config = get_config('local_o365');
        if (empty($config->aadtenant)) {
            throw new \moodle_exception('erroracplocalo365notconfig', 'local_o365');
        }
        $apimethod = '/v1.0/'.$config->aadtenant.$apimethod;
        return parent::apicall($httpmethod, $apimethod, $params, $options);
    }

    /**
     * Get a list of groups.
     *
     * @return array List of groups.
     */
    public function get_groups() {
        $response = $this->apicall('get', '/groups');
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
        $response = $this->process_apicall_response($response, $expectedparams);
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
     * Delete a group.
     *
     * @param string $objectid The object ID of the group.
     * @return bool|string True if group successfully deleted, otherwise returned string (may contain error info, etc).
     */
    public function delete_group($objectid) {
        $response = $this->apicall('delete', '/groups/'.$objectid);
        return ($response === '') ? true : $response;
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
        $response = $this->apicall('post', $endpoint, json_encode($data));
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
        $response = $this->apicall('delete', $endpoint);
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
        $odataqueries = [];
        if ($params === 'default') {
            $params = [
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
                'telephoneNumber',
                'facsimileTelephoneNumber',
                'mobile',
            ];
            $odataqueries[] = '$select='.implode(',', $params);
        }
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
        $response = $this->process_apicall_response($response, ['value' => null]);
        if (!empty($response)) {
            if (is_array($response['value'])) {
                foreach ($response['value'] as $i => $user) {
                    // Legacy value.
                    $response['value'][$i]['objectId'] = $response['value'][$i]['id'];
                }
            }
        }
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
     * Get a list of events.
     *
     * @param string $calendarid The calendar ID to get events from. If empty, primary calendar used.
     * @param string $since datetime date('c') to get events since.
     * @return array Array of events.
     */
    public function get_events($calendarid = null, $since = null) {
        \local_o365\utils::ensure_timezone_set();
        $endpoint = (!empty($calendarid)) ? '/me/calendars/'.$calendarid.'/events' : '/me/calendar/events';
        if (!empty($since)) {
            $since = urlencode(date(DATE_ATOM, $since));
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
            $updateddata['Subject'] = $updated['subject'];
        }
        if (!empty($updated['body'])) {
            $updateddata['Body'] = ['ContentType' => 'HTML', 'Content' => $updated['body']];
        }
        if (!empty($updated['starttime'])) {
            $updateddata['Start'] = [
                'dateTime' => date('c', $updated['starttime']),
                'timeZone' => date('T', $updated['starttime']),
            ];
        }
        if (!empty($updated['endtime'])) {
            $updateddata['End'] = [
                'dateTime' => date('c', $updated['endtime']),
                'timeZone' => date('T', $updated['endtime']),
            ];
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
        $response = $this->betaapicall('patch', '/me/events/'.$outlookeventid, $updateddata);
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
            $this->betaapicall('delete', '/me/events/'.$outlookeventid);
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
        $response = $this->betatenantapicall('get', $endpoint);
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
        $response = $this->betatenantapicall('get', $endpoint);
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
            $response = $this->betatenantapicall('get', $endpoint);
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
        if (!isset($appinfo['value']) || !isset($appinfo['value'][0]) || !isset($appinfo['value'][0]['id'])) {
            return null;
        }
        $appobjectid = $appinfo['value'][0]['id'];
        $endpoint = '/oauth2PermissionGrants?$filter=clientId%20eq%20\''.$appobjectid.'\'';
        if (!empty($resourceid)) {
            $endpoint .= '%20and%20resourceId%20eq%20\''.$resourceid.'\'';
        }
        $response = $this->betatenantapicall('get', $endpoint);
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
     * Get an array of the current required permissions.
     *
     * @return array Array of required Azure AD application permissions.
     */
    public function get_required_permissions() {
        return [
            'openid',
            'Calendars.ReadWrite',
            'Directory.AccessAsUser.All',
            'Directory.ReadWrite.All',
            'Files.ReadWrite',
            'Notes.ReadWrite.All',
            'User.ReadWrite.All',
            'Group.ReadWrite.All',
            'Sites.Read.All',
        ];
    }

    /**
     * Check whether all required permissions are present.
     *
     * @return array Array of missing permissions, permission key as array key, human-readable name as values.
     */
    public function check_permissions() {
        $this->token->refresh();
        $currentperms = $this->get_unified_api_permissions();
        $neededperms = $this->get_required_permissions();
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
}
