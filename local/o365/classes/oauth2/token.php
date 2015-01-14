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
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

namespace local_o365\oauth2;

/**
 * Represents an oauth2 token.
 */
class token {
    /** @var string The access token. */
    protected $token;

    /** @var int The timestamp of when the token expires. */
    protected $expiry;

    /** @var string The refresh token. */
    protected $refreshtoken;

    /** @var string The token's scope. */
    protected $scope;

    /** @var string The token's resource. */
    protected $resource;

    /** @var \local_o365\oauth2\clientdata Client data used for refreshing the token if needed. */
    protected $clientdata;

    /** @var \local_o365\httpclientinterface An HTTP client used for refreshing the token if needed. */
    protected $httpclient;

    /**
     * Constructor.
     *
     * @param string $token The access token.
     * @param int $expiry The timestamp of when the token expires.
     * @param string $refreshtoken The refresh token.
     * @param string $scope The token's scope.
     * @param string $resource The token's resource.
     * @param \local_o365\oauth2\clientdata $clientdata Client data used for refreshing the token if needed.
     * @param \local_o365\httpclientinterface $httpclient An HTTP client used for refreshing the token if needed.
     */
    public function __construct($token, $expiry, $refreshtoken, $scope, $resource, \local_o365\oauth2\clientdata $clientdata, \local_o365\httpclientinterface $httpclient) {
        $this->token = $token;
        $this->expiry = $expiry;
        $this->refreshtoken = $refreshtoken;
        $this->scope = $scope;
        $this->resource = $resource;
        $this->clientdata = $clientdata;
        $this->httpclient = $httpclient;
    }

    /**
     * Get the access token.
     *
     * @return string $token The access token.
     */
    public function get_token() {
        return $this->token;
    }

    /**
     * Get the timestamp of when the token expires.
     *
     * @return int $expiry The timestamp of when the token expires.
     */
    public function get_expiry() {
        return $this->expiry;
    }

    /**
     * Get the refresh token.
     *
     * @return string $refreshtoken The refresh token.
     */
    public function get_refreshtoken() {
        return $this->refreshtoken;
    }

    /**
     * Get the token's scope.
     *
     * @return string $scope The token's scope.
     */
    public function get_scope() {
        return $this->scope;
    }

    /**
     * Get the token's resource.
     *
     * @return string The token's resource.
     */
    public function get_resource() {
        return $this->resource;
    }

    /**
     * Determine whether the token is expired.
     *
     * @return bool Whether the token is expired.
     */
    public function is_expired() {
        return ($this->expiry <= time()) ? true : false;
    }

    /**
     * Get stored token for a user and resourse.
     *
     * @param int $userid The ID of the user to get the token for.
     * @param string $resource The resource to get the token for.
     * @return array Array of token data.
     */
    protected function get_stored_token($userid, $resource) {
        global $DB;
        $tokenparams = ['user_id' => $userid, 'resource' => $resource];
        $record = $DB->get_record('local_o365_token', $tokenparams);
        return (!empty($record)) ? (array)$record : $record;
    }

    /**
     * Update the stored token.
     *
     * @param array $existingtoken Array of existing token data.
     * @param array $newtoken Array of new token data.
     * @return bool Success/Failure.
     */
    protected function update_stored_token($existingtoken, $newtoken) {
        global $DB;
        if (!empty($existingtoken) && !empty($newtoken)) {
            $newtoken['id'] = $existingtoken['id'];
            $DB->update_record('local_o365_token', (object)$newtoken);
            return true;
        }
        return false;
    }

    /**
     * Refresh the token.
     *
     * @return bool Success/Failure.
     */
    public function refresh() {
        global $DB, $USER;
        $params = [
            'client_id' => $this->clientdata->get_clientid(),
            'client_secret' => $this->clientdata->get_clientsecret(),
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshtoken,
            'resource' => $this->resource,
        ];
        $result = $this->httpclient->post($this->clientdata->get_tokenendpoint(), $params);
        $result = json_decode($result, true);
        if (!empty($result) && is_array($result) && isset($result['access_token'])) {
            $origresource = $this->resource;

            $this->token = $result['access_token'];
            $this->expiry = $result['expires_on'];
            $this->refreshtoken = $result['refresh_token'];
            $this->scope = $result['scope'];
            $this->resource = $result['resource'];

            $existingtoken = $this->get_stored_token($USER->id, $origresource);
            if (!empty($existingtoken)) {
                $newtoken = [
                    'scope' => $this->scope,
                    'token' => $this->token,
                    'expiry' => $this->expiry,
                    'refreshtoken' => $this->refreshtoken,
                    'resource' => $this->resource
                ];
                $this->update_stored_token($existingtoken, $newtoken);
            }
            return true;
        } else {
            throw new \moodle_exception('errorcouldnotrefreshtoken', 'local_o365');
            return false;
        }
    }
}
