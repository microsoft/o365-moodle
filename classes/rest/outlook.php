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
 * API client for o365 outlook api.
 */
class outlook extends \local_o365\rest\o365api {
    /** The general API area of the class. */
    public $apiarea = 'outlook';

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_resource() {
        return (static::use_chinese_api() === true) ? 'https://partner.outlook.cn' : 'https://outlook.office365.com';
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        return static::get_resource().'/api/v2.0';
    }

    /**
     * Get a users photo.
     * @param $user User to retrieve photo.
     * @return array|null Returned binary photo data, false if there is no photo.
     */
    public function get_photo($user = null) {
        if ($user == null) {
            $response = $this->apicall('get', "/me/Photo/\$value");
        } else {
            $response = $this->apicall('get', "/Users('$user')/Photo/\$value");
        }
        return $response;
    }

    /**
     * Get photo meta data.
     * @param $user User to retrieve photo meta data for.
     * @param $minsize Ignored for api version 1.
     * @return array|null Returned response, or false if error.
     */
    public function get_photo_metadata($user = null, $minsize = 100) {
        if ($user == null) {
            $response = $this->apicall('get', "/me/Photo");
        } else {
            $response = $this->apicall('get', "/Users('$user')/Photo");
        }
        $data = json_decode($response, true);
        // Most retrievals for phto meta data fail when there is no photo data uploaded.
        if (!empty($data['error'])) {
            return false;
        }
        $expected = array('@odata.mediaContentType' => 'image/jpeg', '@odata.mediaEtag' => null, 'Id' => null);
        return $this->process_apicall_response($response, $expected);
    }
}
