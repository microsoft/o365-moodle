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
 * Abstract base class for all o365 REST api classes.
 */
abstract class o365api {
    /** @var \local_o365\oauth2\token A token object representing all token information to be used for this client. */
    protected $token;

    /** @var \local_o365\httpclientinterface An HTTP client to use for communication. */
    protected $httpclient;

    /**
     * Constructor.
     *
     * @param \local_o365\oauth2\token $token A token object representing all token information to be used for this client.
     * @param \local_o365\httpclientinterface $httpclient An HTTP client to use for communication.
     */
    public function __construct(\local_o365\oauth2\token $token, \local_o365\httpclientinterface $httpclient) {
        $this->token = $token;
        $this->httpclient = $httpclient;
    }

    /**
     * Determine if the API client is configured.
     *
     * @return bool Whether the API client is configured.
     */
    public static function is_configured() {
        return true;
    }

    /**
     * Determine whether the plugins are configured to use the chinese API.
     *
     * @return bool Whether we should use the chinese API (true), or not (false).
     */
    public static function use_chinese_api() {
        $chineseapi = get_config('local_o365', 'chineseapi');
        return (!empty($chineseapi)) ? true : false;
    }

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_resource() {
        throw new \moodle_exception('erroro365apinotimplemented', 'local_o365');
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        throw new \moodle_exception('erroro365apinotimplemented', 'local_o365');
    }

    /**
     * Determine whether the supplied token is valid, and refresh if necessary.
     */
    protected function checktoken() {
        if ($this->token->is_expired() === true) {
            return $this->token->refresh();
        } else {
            return true;
        }
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
     * Make an API call.
     *
     * @param string $httpmethod The HTTP method to use. get/post/patch/merge/delete.
     * @param string $apimethod The API endpoint/method to call.
     * @param string $params Additional paramters to include.
     * @param array $options Additional options for the request.
     * @return string The result of the API call.
     */
    public function apicall($httpmethod, $apimethod, $params = '', $options = array()) {
        $tokenvalid = $this->checktoken();
        if ($tokenvalid !== true) {
            throw new \moodle_exception('erroro365apiinvalidtoken', 'local_o365');
        }

        $apiurl = $this->get_apiuri();

        $httpmethod = strtolower($httpmethod);
        if (!in_array($httpmethod, ['get', 'post', 'put', 'patch', 'merge', 'delete'], true)) {
            throw new \moodle_exception('erroro365apiinvalidmethod', 'local_o365');
        }

        $requesturi = $this->transform_full_request_uri($apiurl.$apimethod);

        $header = [
            'Accept: application/json',
            'Content-Type: application/json;odata.metadata=full',
            'Authorization: Bearer '.$this->token->get_token(),
        ];
        $this->httpclient->resetHeader();
        $this->httpclient->setHeader($header);

        // Sleep to avoid rate limiting.
        usleep(1250000);

        return $this->httpclient->$httpmethod($requesturi, $params, $options);
    }
}
