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
 * API client for service discovery.
 */
class discovery extends \local_o365\rest\o365api {
    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_resource() {
        return 'https://api.office.com/discovery/';
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        return 'https://api.office.com/discovery/v1.0/me/services';
    }

    /**
     * Get information for all available services.
     *
     * @return array Array of service information, or null if error.
     */
    public function get_services() {
        $response = $this->apicall('get', '/');
        $response = @json_decode($response, true);
        if (!empty($response) && !empty($response['value'])) {
            return $response['value'];
        }
        return null;
    }

    /**
     * Get information for a specific service.
     *
     * @param string $entitykey The entity key for the service to fetch.
     * @return array Array of service information, or null if not found.
     */
    public function get_service($entitykey) {
        $response = $this->apicall('get', '/');
        $response = @json_decode($response, true);
        if (!empty($response) && !empty($response['value'])) {
            foreach ($response['value'] as $service) {
                if ($service['entityKey'] === $entitykey) {
                    return $service;
                }
            }
        }
        return null;
    }
}