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
 * @author Nagesh Tembhurnikar <nagesh@introp.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\rest;

/**
 * API client for onenote class notebook.
 */
class notebook extends \local_o365\rest\o365api {
    /** The general API area of the class. */
    public $apiarea = 'onenote';

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_resource() {
        return 'https://onenote.com';
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        return 'https://www.onenote.com/api/v1.0';
    }

    /**
     * Creates class notebook for Microsoft 365 group.
     *
     * @param string $groupid Microsoft group id for which the class notebook should be created.
     *
     * @return string $url url of created class notebook.
     */
    public function create_class_notebook($groupid, $teachers, $students) {
        $apimethod = '/myOrganization/groups/'.$groupid.'/notes/classNotebooks?omkt=en-us';

        $headers = array();
        $headers ['CURLOPT_USERAGENT'] = 'Homeroom/1.0';

        $body = array();
        $body['name'] = 'Notebook';
        $body['studentSections'] = array("Section1-Sec1");
        $body['teachers'] = array();

        foreach ($teachers as $teacher) {
            $body['teachers'][] = [
                'id' => $teacher,
                'principalType' => 'Person'
            ];
        }

        foreach ($students as $student) {
            $body['students'][] = [
                'id' => $student,
                'principalType' => 'Person'
            ];
        }

        $body ['hasTeacherOnlySectionGroup'] = true;
        $result = $this->apicall('post', $apimethod, json_encode($body), $headers);
        return $this->process_apicall_response($result);
    }
}
