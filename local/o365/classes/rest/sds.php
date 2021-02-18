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
class sds extends \local_o365\rest\unified {
    /** Prefix identifying SDS-specific attributes. */
    const PREFIX = 'extension_fe2174665583431c953114ff7268b7b3_Education';

    /**
     * Get schools in SDS.
     *
     * @return array API call response.
     */
    public function get_schools() {
        $endpoint = '/administrativeUnits';
        $endpoint .= '?$filter='.static::PREFIX.'_ObjectType%20eq%20\'School\'';
        $response = $this->betaapicall('get', $endpoint);
        $processed = $this->process_apicall_response($response, ['value' => null]);
        return $processed;
    }

    /**
     * Get all sections in SDS.
     *
     * @return array API call response.
     */
    public function get_sections() {
        $endpoint = '/administrativeUnits';
        $endpoint .= '?$filter='.static::PREFIX.'_ObjectType%20eq%20\'Section\'';
        $response = $this->betaapicall('get', $endpoint);
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
        $response = $this->betaapicall('get', $endpoint);
        $reqparams = [
            'id' => null,
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
        $endpoint .= '?$filter='.static::PREFIX.'_ObjectType%20eq%20\'Section\'';
        $endpoint .= '%20and%20'.static::PREFIX.'_SyncSource_SchoolId%20eq%20\''.$schoolid.'\'';
        $response = $this->betaapicall('get', $endpoint);
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
        if (!empty($skiptoken) && is_string($skiptoken)) {
            $endpoint .= '&$skiptoken='.$skiptoken;
        }
        $response = $this->betaapicall('get', $endpoint);
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
        $response = $this->betaapicall('get', $endpoint);
        return $this->process_apicall_response($response, ['value' => null]);
    }
}