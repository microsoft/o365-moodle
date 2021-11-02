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
 * API client for service discovery.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\rest;

/**
 * API client for service discovery.
 */
class discovery extends \local_o365\rest\o365api {
    /**
     * @var string The general API area of the class.
     */
    public $apiarea = 'discovery';

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_tokenresource() {
        return 'https://graph.microsoft.com';
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        return 'https://graph.microsoft.com/v1.0';
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
        $response = $this->process_apicall_response($response, ['value' => null]);
        foreach ($response['value'] as $service) {
            if ($service['entityKey'] === $entitykey) {
                return $service;
            }
        }
        return null;
    }

    /**
     * Get the tenant associated with the current token.
     *
     * @return string|null The tenant, or null if error.
     */
    public function get_tenant() {
        $entitykey = 'Directory@AZURE';
        $service = $this->get_service($entitykey);
        if (!empty($service) && isset($service['serviceEndpointUri'])) {
            $tenant = trim(parse_url($service['serviceEndpointUri'], PHP_URL_PATH), '/');
            $tenant = trim($tenant);
            if (!empty($tenant)) {
                return $tenant;
            }
        }
        return null;
    }

    /**
     * Get the OneDrive for Business URL associated with the current token.
     *
     * @return string|null The URL, or null if error.
     */
    public function get_odburl() {
        $entitykey = 'MyFiles@O365_SHAREPOINT';
        $service = $this->get_service($entitykey);
        if (!empty($service) && isset($service['serviceResourceId'])) {
            $odburl = trim(parse_url($service['serviceResourceId'], PHP_URL_HOST), '/');
            $odburl = trim($odburl);
            if (!empty($odburl)) {
                return $odburl;
            }
        }
        return null;
    }

}
