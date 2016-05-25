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

namespace local_msaccount;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/oauthlib.php');

/**
 * A helper class to access Microsoft Account using the REST api.
 * This is a singleton class.
 * All access to Microsoft Account should be through this class instead of directly accessing the \local_msaccount\client class.
 *
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 * @package    local_msaccount
 */
class api {

    private static $instance = null;
    private $msaccountclient = null;

    /**
     * Constructor for msaccount class. This is a singleton class so do not use the constructor directly.
     */
    protected function __construct() {
        $this->msaccountclient = new \local_msaccount\client();
    }

    /**
     * Get the instance of the local_msaccount\api object. Use this method to obtain an instance of the class rather than
     * the constructor. Also tries to ensure that the user is logged in.
     * @return null|static The instance.
     */
    public static function getinstance() {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        self::$instance->msaccountclient->is_logged_in();

        return self::$instance;
    }

    /**
     * Get the underlying msaccount client.
     * @return \local_msaccount\client|null
     */
    public function get_msaccount_client() {
        return $this->msaccountclient;
    }

    /**
     * Check if user is logged in to Microsoft Account. Also handles upgrading / refreshing the token if needed.
     * @return bool True iff the user is logged in.
     */
    public function is_logged_in() {
        return $this->get_msaccount_client()->is_logged_in();
    }

    /**
     * Get the Microsoft Account login url.
     * @return mixed
     */
    public function get_login_url() {
        return $this->get_msaccount_client()->get_login_url();
    }

    /**
     * Logout from Microsoft Account.
     * @return mixed
     */
    public function log_out() {
        return $this->get_msaccount_client()->log_out();
    }

    /**
     * A wrapper for the myget() method in the underlying \local_msaccount\client class.
     * @param $url
     * @param array $params
     * @param string $token
     * @param string $secret
     * @return mixed
     */
    public function myget($url, $params=array(), $token='', $secret='') {
        return $this->get_msaccount_client()->myget($url, $params, $token, $secret);
    }

    /**
     * A wrapper for the mypost() method in the underlying \local_msaccount\client class.
     * @param $url
     * @param array $params
     * @param string $token
     * @param string $secret
     * @return mixed
     */
    public function mypost($url, $params=array(), $token='', $secret='') {
        return $this->get_msaccount_client()->mypost($url, $params, $token, $secret);
    }

    /**
     * Get the OAuth access token for the currently logged in user. This may be used in HTTP requests that require
     * authentication.
     * @return mixed
     */
    public function get_accesstoken() {
        return $this->get_msaccount_client()->get_accesstoken();
    }

    /**
     * A simple wrapper for the setHeader() method in the underyling \local_msaccount\client class.
     * @param $header
     * @return mixed
     */
    public function setHeader($header) {
        return $this->get_msaccount_client()->setHeader($header);
    }

    /**
     * Return the HTML for the sign in widget for the Microsoft Account.
     * Please refer to the styles.css file for styling this widget.
     * @return string HTML containing the sign in widget.
     */
    public function render_signin_widget() {
        if (!\local_o365\utils::is_configured_msaccount()) {
            return '';
        }
        $url = $this->get_login_url();

        return '<a onclick="window.open(this.href,\'mywin\',' .
            '\'left=20,top=20,width=500,height=500,toolbar=1,resizable=0\'); return false;"' .
            'href="'.$url->out(false).'" class="local_msaccount_linkbutton">' . get_string('signin', 'local_msaccount') . '</a>';
    }

    // These are useful primarily for testing purposes.
    /**
     * Store a refresh token into the database so it can be used to obtain a token for subsequent HTTP requests.
     * @param $refreshtoken
     */
    public function store_refresh_token($refreshtoken) {
        $this->get_msaccount_client()->store_refresh_token($refreshtoken);
    }

    /**
     * Get the saved refresh token for the currently logged in user from the database.
     * @return string Refresh token.
     */
    public function refresh_token() {
        return $this->get_msaccount_client()->refresh_token();
    }

}
