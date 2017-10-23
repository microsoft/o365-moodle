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
 * API client for school data sync.
 */
class sds extends \local_o365\rest\o365api {
    /** Prefix identifying SDS-specific attributes. */
    const PREFIX = 'extension_fe2174665583431c953114ff7268b7b3_Education';

    /** The general API area of the class. */
    public $apiarea = 'sds';

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
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        $config = get_config('local_o365');
        if (!empty($config->aadtenant)) {
            $tenant = $config->aadtenant;
            return static::get_resource().'/'.$tenant;
        }
        return false;
    }

    /**
     * Transform the full request URL.
     *
     * @param string $requesturi The full request URI, includes the API uri and called endpoint.
     * @return string The transformed full request URI.
     */
    protected function transform_full_request_uri($requesturi) {
        return $requesturi;
    }

    /**
     * Get schools in SDS.
     *
     * @return array API call response.
     */
    public function get_schools() {
        $endpoint = '/administrativeUnits';
        $endpoint .= '?$filter='.static::PREFIX.'_ObjectType%20eq%20\'School\'';
        $endpoint .= '&api-version=beta';
        $response = $this->apicall('get', $endpoint);
        return $this->process_apicall_response($response, ['value' => null]);
    }

    /**
     * Get all sections in SDS.
     *
     * @return array API call response.
     */
    public function get_sections() {
        $endpoint = '/administrativeUnits';
        $endpoint .= '?$filter='.static::PREFIX.'_ObjectType%20eq%20\'Section\'';
        $endpoint .= '&api-version=beta';
        $response = $this->apicall('get', $endpoint);
        return $this->process_apicall_response($response, ['value' => null]);
    }

    /**
     * Get school data.
     *
     * @param string $schoolobjectid The object ID of the school.
     * @return array Array of school data.
     */
    public function get_school($schoolobjectid) {
        $endpoint = '/administrativeUnits/'.$schoolobjectid;
        $endpoint .= '?api-version=beta';
        $response = $this->apicall('get', $endpoint);
        $reqparams = [
            'objectId' => null,
            'displayName' => null,
            static::PREFIX.'_SyncSource_SchoolId' => null,
        ];
        return $this->process_apicall_response($response, $reqparams);
    }

    /**
     * Get sections within a school.
     *
     * @param string $schoolid The "school id" SDS param of the school to get sections for.
     * @return array API call response.
     */
    public function get_school_sections($schoolid) {
        $endpoint = '/groups';
        $endpoint .= '?api-version=1.5';
        $endpoint .= '&$filter='.static::PREFIX.'_ObjectType%20eq%20\'Section\'';
        $endpoint .= '%20and%20'.static::PREFIX.'_SyncSource_SchoolId%20eq%20\''.$schoolid.'\'';
        $response = $this->apicall('get', $endpoint);
        return $this->process_apicall_response($response, ['value' => null]);
    }

    /**
     * Get a list of users in a school.
     *
     * @param string $schoolobjectid The object id of the school.
     * @param string $skiptoken If processing multiple pages, this is the skip token to skip to the next page.
     * @return array API call response.
     */
    public function get_school_users($schoolobjectid, $skiptoken = '') {
        $endpoint = '/administrativeUnits/'.$schoolobjectid.'/members';
        $endpoint .= '?api-version=beta';
        if (!empty($skiptoken) && is_string($skiptoken)) {
            $endpoint .= '&$skiptoken='.$skiptoken;
        }
        $response = $this->apicall('get', $endpoint);
        return $this->process_apicall_response($response, ['value' => null]);
    }

    /**
     * Get a list of students in a school.
     *
     * @param string $schoolobjectid The object id of the school.
     * @return array List of users.
     */
    public function get_school_students($schoolobjectid) {
        $users = $this->get_school_users($schoolobjectid);
        $return = [];
        foreach ($users['value'] as $user) {
            if (isset($user[static::PREFIX.'_ObjectType']) && $user[static::PREFIX.'_ObjectType'] === 'Student') {
                $return[] = $user;
            }
        }
        return $return;
    }

    /**
     * Get a list of teachers in a school.
     *
     * @param string $schoolobjectid The object id of the school.
     * @return array List of users.
     */
    public function get_school_teachers($schoolobjectid) {
        $users = $this->get_school_users($schoolobjectid);
        $return = [];
        foreach ($users['value'] as $user) {
            if (isset($user[static::PREFIX.'_ObjectType']) && $user[static::PREFIX.'_ObjectType'] === 'Teacher') {
                $return[] = $user;
            }
        }
        return $return;
    }

    /**
     * Get a list of users in a section.
     *
     * @param string $sectionobjectid The object id of the section.
     * @return array Array of members.
     */
    public function get_section_members($sectionobjectid) {
        $endpoint = '/groups/'.$sectionobjectid.'/members';
        $endpoint .= '?api-version=1.5';
        $response = $this->apicall('get', $endpoint);
        return $this->process_apicall_response($response, ['value' => null]);
    }
}
