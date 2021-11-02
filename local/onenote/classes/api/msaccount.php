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
 * Convenient wrappers and helper for using the OneNote API.
 *
 * @package local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com) Sushant Gawali (sushant@introp.net)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright Microsoft, Inc.
 */

namespace local_onenote\api;

defined('MOODLE_INTERNAL') || die();
/**
 * General purpose utility class.
 */
class msaccount extends base {
    /** @var string Base url to access API */
    const API = 'https://www.onenote.com/api/beta'; // TODO: Switch to non-beta version: 'https://www.onenote.com/api/v1.0'.

    /** @var \local_msaccount\api An instance of the MS Account API to perform api calls with. */
    protected $msacountapi = null;

    /**
     * Constructor.
     *
     * Initializes local_msaccount\api instance which is used to do moest of the underlying authentication and
     * REST API operations. This is a singleton class, do not use the constructor directly to create an instance.
     * Use the getinstance() method instead.
     */
    protected function __construct() {
        $this->msaccountapi = \local_msaccount\api::getinstance();
        $this->msaccountapi->is_logged_in();
    }

    /**
     * Return instance of the underlying local_msaccount\api.
     * @return null|static
     */
    public function get_msaccount_api() {
        return $this->msaccountapi;
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
        global $USER;

        $httpmethod = strtolower($httpmethod);

        $url = static::API.$apimethod;
        if ($httpmethod === 'get') {
            return $this->get_msaccount_api()->myget($url);
        } else if ($httpmethod === 'post') {
            return $this->get_msaccount_api()->mypost($url, $params);
        }
    }

    /**
     * Get the token to authenticate with OneNote.
     *
     * @return string The token to authenticate with OneNote.
     */
    public function get_token() {
        return $this->get_msaccount_api()->get_accesstoken()->token;
    }

    /**
     * Get a full URL and include auth token. This is useful for associated resources: attached images, etc.
     *
     * @param string $url A full URL to get.
     * @param array $options
     * @return string The result of the request.
     */
    public function geturl($url, $options = array()) {
        return $this->get_msaccount_api()->myget($url);
    }

    /**
     * Determine whether the user is connected to OneNote.
     *
     * @return bool True if connected, false otherwise.
     */
    public function is_logged_in() {
        return $this->get_msaccount_api()->is_logged_in();
    }

    /**
     * Get the login url (if applicable).
     *
     * @return string The login URL.
     */
    public function get_login_url() {
        return $this->get_msaccount_api()->get_login_url();
    }

    /**
     * End the connection to OneNote.
     */
    public function log_out() {
        return $this->get_msaccount_api()->log_out();
    }

    /**
     * Return the HTML for the sign in widget for OneNote.
     * Please refer to the styles.css file for styling this widget.
     *
     * @return string HTML containing the sign in widget.
     */
    public function render_signin_widget() {
        return $this->get_msaccount_api()->render_signin_widget();
    }
}
