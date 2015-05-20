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
 * Client for unified Office365 API.
 */
class unified extends \local_o365\rest\o365api {
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
        $response = $this->process_apicall_response($response);
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
            'groupType' => 'Unified',
            'displayName' => $name,
            'mailEnabled' => true,
            'securityEnabled' => true,
            'mailNickname' => $mailnickname,
        ];
        $response = $this->tenantapicall('post', '/groups', json_encode($groupdata));
        $response = $this->process_apicall_response($response);
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
        $response = $this->process_apicall_response($response);
        return $response;
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
     * Get information on the current application.
     *
     * @return array|null Array of application information, or null if failure.
     */
    public function get_application_info() {
        $oidcconfig = get_config('auth_oidc');
        $endpoint = '/applications/?$filter=appId%20eq%20\''.$oidcconfig->clientid.'\'';
        $response = $this->tenantapicall('get', $endpoint);
        $response = $this->process_apicall_response($response);
        return $response;
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
        $response = $this->process_apicall_response($response);
        return $response;
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
            $response = $this->process_apicall_response($response);
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
            'User.Read',
            'User.ReadWrite',
            'Group.Read.All',
            'Directory.Read.All',
            'Directory.ReadWrite.All',
            'Directory.AccessAsUser.All',
            'Calendars.Read',
            'Calendars.ReadWrite',
            'Files.Read',
            'Files.ReadWrite',
            'Files.ReadWrite.Selected',
            'Files.Read.Selected',
            'Sites.Read.All',
            'Sites.ReadWrite.All',
            'User.ReadWrite.All',
            'Group.ReadWrite.All',
            'User.ReadBasic.All',
            'User.Read.All',
        ];
    }

    /**
     * Check whether all required permissions are present.
     *
     * @return array Array of missing permissions, permission key as array key, human-readable name as values.
     */
    public function check_permissions() {
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

        $availablepermsnames = [];
        foreach ($availableperms as $perminfo) {
            if (!isset($perminfo['value']) || !isset($perminfo['adminConsentDisplayName'])) {
                continue;
            }
            $availablepermsnames[$perminfo['value']] = $perminfo['adminConsentDisplayName'];
        }

        $return = [];
        foreach ($missingperms as $missingperm) {
            $return[$missingperm] = (isset($availablepermsnames[$missingperm]))
                    ? $availablepermsnames[$missingperm]
                    : $missingperm;
        }
        return $return;
    }
}