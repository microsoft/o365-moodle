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
 * OpenID Connect authentication plugin declaration.
 *
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

use core\url;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/authlib.php');
require_once($CFG->dirroot . '/login/lib.php');
require_once($CFG->dirroot . '/auth/oidc/lib.php');

/**
 * OpenID Connect Authentication Plugin.
 */
class auth_plugin_oidc extends \auth_plugin_base {
    /** @var string Authentication plugin type - the same as db field. */
    public $authtype = 'oidc';

    /** @var object Plugin config. */
    public $config;

    /** @var object extending \auth_oidc\loginflow\base */
    public $loginflow;

    /**
     * Constructor.
     *
     * @param null $forceloginflow
     * @throws moodle_exception
     */
    public function __construct($forceloginflow = null) {
        global $SESSION;
        $loginflow = 'authcode';

        if (
            isset($SESSION->stateadditionaldata) && !empty($SESSION->stateadditionaldata) &&
            isset($SESSION->stateadditionaldata['forceflow'])
        ) {
            $loginflow = $SESSION->stateadditionaldata['forceflow'];
        } else if (!empty($forceloginflow) && is_string($forceloginflow)) {
            $loginflow = $forceloginflow;
        }
        $loginflowclass = '\auth_oidc\loginflow\\' . $loginflow;
        if (class_exists($loginflowclass)) {
            $this->loginflow = new $loginflowclass($this->config);
        } else {
            throw new moodle_exception('errorbadloginflow', 'auth_oidc');
        }
        $this->config = $this->loginflow->config;
    }

    /**
     * Returns true if plugin can be manually set.
     *
     * @return bool
     */
    public function can_be_manually_set() {
        return true;
    }

    /**
     * Returns a list of potential IdPs that this authentication plugin supports. Used to provide links on the login page.
     *
     * @param string $wantsurl The relative url fragment the user wants to get to.
     * @return array Array of idps.
     */
    public function loginpage_idp_list($wantsurl) {
        return $this->loginflow->loginpage_idp_list($wantsurl);
    }

    /**
     * Set an HTTP client to use.
     *
     * @param \auth_oidc\httpclientinterface $httpclient
     * @return mixed
     */
    public function set_httpclient(\auth_oidc\httpclientinterface $httpclient) {
        return $this->loginflow->set_httpclient($httpclient);
    }

    /**
     * Hook for overriding behaviour of logout page.
     */
    public function logoutpage_hook() {
        global $CFG, $redirect;

        // No need for custom logic if we don't force the redirect on login.
        if (!isset($this->config->forceredirect) || !$this->config->forceredirect) {
            return;
        }

        if (empty($redirect)) {
            return;
        }

        $redirecturl = is_string($redirect) ? new url($redirect) : $redirect;
        if (!($redirecturl instanceof url)) {
            return;
        }

        if ($redirecturl->compare(new url('/login/index.php'), URL_MATCH_BASE)) {
            // When we log out and are redirecting to the login page, add the noredirect to prevent our own redirect.
            $redirecturl->param('noredirect', 1);
            $redirecturl->param('oidcloggedout', 1);
            $redirect = $redirecturl->out(false);
        } else if (!empty($CFG->forcelogin) && $redirecturl->compare(new url('/'), URL_MATCH_BASE)) {
            // The site requires login, so the front page would send the user to the login page without the noredirect
            // parameter, and the forced redirect (and silent login) would immediately log the user back in.
            // Send the user to the login page directly instead.
            $loginurl = new url('/login/index.php', ['noredirect' => 1, 'oidcloggedout' => 1]);
            $redirect = $loginurl->out(false);
        }
    }

    /**
     * Hook for overriding behaviour of login page.
     * This method is called from login/index.php page for all enabled auth plugins.
     */
    public function loginpage_hook() {
        global $frm;  // Can be used to override submitted login form.
        global $user; // Can be used to replace authenticate_user_login().
        // The user was just logged out, and is back from the IdP logout. The cookie is removed here rather than earlier, as
        // the login page is where the user is sent to after the site front page, and the redirect is skipped for this visit.
        $returnedfromlogout = $this->has_logout_suppression_cookie();
        if ($returnedfromlogout) {
            $this->clear_logout_suppression_cookie();
        }
        if (!$returnedfromlogout && $this->should_login_redirect()) {
            $this->loginflow->handleredirect();
        }
        return $this->loginflow->loginpage_hook($frm, $user);
    }

    /**
     * Return the name of the cookie that remembers that the user has just been logged out of Moodle and sent to the IdP.
     *
     * @return string
     */
    protected function get_logout_suppression_cookie_name(): string {
        global $CFG;

        return 'MOODLEOIDCLOGOUT' . ($CFG->sessioncookie ?? '');
    }

    /**
     * Check whether the user has just been logged out of Moodle and sent to the IdP logout endpoint.
     *
     * @return bool
     */
    protected function has_logout_suppression_cookie(): bool {
        return !empty($_COOKIE[$this->get_logout_suppression_cookie_name()]);
    }

    /**
     * Remember for a few minutes that the user has been logged out of Moodle and sent to the IdP logout endpoint.
     *
     * The IdP sends the user back to the site URL, which has to be exactly the redirect URI registered for the app, so
     * parameters cannot be added to it to stop the forced redirect (and silent login) from starting a new login. The
     * cookie is sent with the return to the site, as it is a top level navigation, and is removed on the login page.
     *
     * @return void
     */
    protected function set_logout_suppression_cookie(): void {
        $this->send_cookie($this->get_logout_suppression_cookie_name(), '1', time() + 5 * MINSECS);
    }

    /**
     * Remove the cookie that remembers that the user has just been logged out of Moodle.
     *
     * @return void
     */
    protected function clear_logout_suppression_cookie(): void {
        unset($_COOKIE[$this->get_logout_suppression_cookie_name()]);
        $this->send_cookie($this->get_logout_suppression_cookie_name(), '', time() - HOURSECS);
    }

    /**
     * Send a cookie to the browser.
     *
     * @param string $name The cookie name.
     * @param string $value The cookie value.
     * @param int $expires The time the cookie expires.
     * @return void
     */
    protected function send_cookie(string $name, string $value, int $expires): void {
        global $CFG;

        if (headers_sent()) {
            return;
        }

        setcookie($name, $value, [
            'expires' => $expires,
            'path' => $CFG->sessioncookiepath ?: '/',
            'domain' => $CFG->sessioncookiedomain ?? '',
            'secure' => is_moodle_cookie_secure(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    /**
     * Determines if we will redirect to the redirecturi.
     *
     * @return bool If this returns true then redirect
     */
    public function should_login_redirect() {
        global $SESSION;

        $oidc = optional_param('oidc', null, PARAM_BOOL);
        // Also support noredirect param - used by other auth plugins.
        $noredirect = optional_param('noredirect', 0, PARAM_BOOL);
        if (!empty($noredirect)) {
            $oidc = 0;
        }
        if (!isset($this->config->forceredirect) || !$this->config->forceredirect) {
            return false; // Never redirect if we haven't enabled the forceredirect setting.
        }
        if (!auth_oidc_is_idp_type_configured()) {
            return false; // Never redirect if no IdP is configured, for example after disconnecting ("Not connected").
        }
        // Never redirect on POST.
        if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
            return false;
        }

        // Check whether we've skipped the login page already.
        // This is here because loginpage_hook is called again during form submission (all of login.php is processed) and
        // ?oidc=off is not preserved forcing us to the IdP.
        //
        // This isn't needed when duallogin is on because $oidc will default to 0 and duallogin is not part of the request.
        if ((isset($SESSION->oidc) && $SESSION->oidc == 0)) {
            return false;
        }

        // Never redirect if requested so.
        if ($oidc === 0) {
            // Remember the choice for the rest of the session, except right after logging out, so that the next visit to the
            // site is redirected to the IdP again.
            if (!optional_param('oidcloggedout', 0, PARAM_BOOL)) {
                $SESSION->oidc = $oidc;
            }
            return false;
        }
        // We are off to OIDC land so reset the force in SESSION.
        if (isset($SESSION->oidc)) {
            unset($SESSION->oidc);
        }

        return true;
    }

    /**
     * Will check if we have to redirect before going to login page
     */
    public function pre_loginpage_hook() {
        // Right after being logged out and sent back from the IdP, the user is taken to the login page instead.
        if (!$this->has_logout_suppression_cookie() && $this->should_login_redirect()) {
            $this->loginflow->handleredirect();
        }
    }

    /**
     * Handle requests to the redirect URL.
     *
     * @return mixed Determined by loginflow.
     */
    public function handleredirect() {
        return $this->loginflow->handleredirect();
    }

    /**
     * Handle OIDC disconnection from Moodle account.
     *
     * @param bool $justremovetokens If true, just remove the stored OIDC tokens for the user, otherwise revert login methods.
     * @param bool $donotremovetokens If true, do not remove tokens when disconnecting. This migrates from a login account to a
     *                                "linked" account.
     * @param url|null $redirect Where to redirect if successful.
     * @param url|null $selfurl The page this is accessed from. Used for some redirects.
     * @param null $userid
     * @return mixed
     */
    public function disconnect(
        $justremovetokens = false,
        $donotremovetokens = false,
        ?url $redirect = null,
        ?url $selfurl = null,
        $userid = null
    ) {
        return $this->loginflow->disconnect($justremovetokens, $donotremovetokens, $redirect, $selfurl, $userid);
    }

    /**
     * This is the primary method that is used by the authenticate_user_login() function in moodlelib.php.
     *
     * @param string $username The username (with system magic quotes)
     * @param string $password The password (with system magic quotes)
     * @return bool Authentication success or failure.
     */
    public function user_login($username, $password = null) {
        global $CFG;
        // Short circuit for guest user.
        if (!empty($CFG->guestloginbutton) && $username === 'guest' && $password === 'guest') {
            return false;
        }
        return $this->loginflow->user_login($username, $password);
    }

    /**
     * Read user information from external database and returns it as array().
     *
     * @param string $username username
     * @return mixed array with no magic quotes or false on error
     */
    public function get_userinfo($username) {
        return $this->loginflow->get_userinfo($username);
    }

    /**
     * Indicates if moodle should automatically update internal user
     * records with data from external sources using the information
     * from get_userinfo() method.
     *
     * @return bool true means automatically copy data from ext to user table
     */
    public function is_synchronised_with_external() {
        return true;
    }

    /**
     * Returns true if this authentication plugin is "internal".
     *
     * @return bool Whether the plugin uses password hashes from Moodle user table for authentication.
     */
    public function is_internal() {
        return false;
    }

    /**
     * Post authentication hook.
     *
     * This method is called from authenticate_user_login() for all enabled auth plugins.
     *
     * @param object $user user object, later used for $USER
     * @param string $username (with system magic quotes)
     * @param string $password plain text password (with system magic quotes)
     */
    public function user_authenticated_hook(&$user, $username, $password) {
        global $DB;
        if (!empty($user) && !empty($user->auth) && $user->auth === 'oidc') {
            $tokenrec = $DB->get_record('auth_oidc_token', ['userid' => $user->id]);
            if (!empty($tokenrec)) {
                // If the token record username is out of sync (ie username changes), update it.
                if ($tokenrec->username != $user->username) {
                    $updatedtokenrec = new stdClass();
                    $updatedtokenrec->id = $tokenrec->id;
                    $updatedtokenrec->username = $user->username;
                    $DB->update_record('auth_oidc_token', $updatedtokenrec);
                    $tokenrec = $updatedtokenrec;
                }
            } else {
                // There should always be a token record here, so a failure here means
                // the user's token record doesn't yet contain their userid.
                $tokenrec = $DB->get_record('auth_oidc_token', ['username' => $username]);
                if (!empty($tokenrec)) {
                    $tokenrec->userid = $user->id;
                    $updatedtokenrec = new stdClass();
                    $updatedtokenrec->id = $tokenrec->id;
                    $updatedtokenrec->userid = $user->id;
                    $DB->update_record('auth_oidc_token', $updatedtokenrec);
                    $tokenrec = $updatedtokenrec;
                }
            }

            $eventdata = [
                'objectid' => $user->id,
                'userid' => $user->id,
                'other' => ['username' => $user->username],
            ];
            $event = \auth_oidc\event\user_loggedin::create($eventdata);
            $event->trigger();
        }
    }

    /**
     * Build logout URL with appropriate IdP-specific parameters.
     *
     * @param string $logouturl Base logout URL from config.
     * @param string $idptype IdP type (from constants).
     * @param stdClass $user User object.
     * @return string|null Logout URL, or null if logout should be skipped.
     */
    private function build_logout_url(string $logouturl, string $idptype, stdClass $user): ?string {
        global $CFG, $DB;

        $params = [
            'post_logout_redirect_uri' => $CFG->wwwroot,
        ];

        switch ($idptype) {
            case AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID:
            case AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM:
                if (!$logouturl) {
                    $logouturl = auth_oidc_get_login_baseurl() . '/organizations/oauth2/logout';
                }
                $url = new url($logouturl, $params);
                return $url->out(false);

            case AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID:
                if (!$logouturl || !auth_oidc_is_external_id_host($logouturl)) {
                    // The logout endpoint of an External ID tenant is next to its authorization endpoint.
                    $authendpoint = (string) get_config('auth_oidc', 'authendpoint');
                    if (!auth_oidc_is_external_id_endpoint($authendpoint)) {
                        return null;
                    }
                    $logouturl = preg_replace('#/authorize(?=$|\?)#', '/logout', $authendpoint);
                }
                // The login_hint claim of the ID token identifies the session to sign out of, so that the user is not asked
                // to pick an account. The claim is only present when it is added as an optional claim in the app registration.
                $token = $DB->get_record('auth_oidc_token', ['userid' => $user->id]);
                if ($token && !empty($token->idtoken)) {
                    try {
                        $loginhint = \auth_oidc\jwt::instance_from_encoded($token->idtoken)->claim('login_hint');
                    } catch (\Throwable $e) {
                        $loginhint = null;
                    }
                    if (!empty($loginhint)) {
                        $params['logout_hint'] = $loginhint;
                    }
                }
                $url = new url($logouturl, $params);
                return $url->out(false);

            case AUTH_OIDC_IDP_TYPE_OTHER:
                if (!$logouturl) {
                    return null;
                }
                $token = $DB->get_record('auth_oidc_token', ['userid' => $user->id]);
                if ($token) {
                    $params['id_token_hint'] = $token->idtoken;
                }
                $url = new url($logouturl, $params);
                return $url->out(false);

            default:
                return null;
        }
    }

    /**
     * Log out user from Microsoft 365 if single logout (SLO) integration is enabled.
     *
     * @param stdClass $user
     *
     * @return bool
     */
    public function postlogout_hook($user) {
        global $CFG, $DB;

        $singlelogoutsetting = get_config('auth_oidc', 'single_logout');

        if ($singlelogoutsetting) {
            $redirect = false;

            if ($user->auth == 'oidc') {
                $redirect = true;
            } else if (auth_oidc_is_local_365_installed()) {
                if ($DB->record_exists('local_o365_objects', ['type' => 'user', 'moodleid' => $user->id])) {
                    $redirect = true;
                }
            }

            // Do not redirect to logout endpoint when using loginas feature.
            if (!empty($user->loginascontext)) {
                $redirect = false;
            }

            if ($redirect) {
                $logouturl = get_config('auth_oidc', 'logouturi');
                $idptype = get_config('auth_oidc', 'idptype');

                $redirecturl = $this->build_logout_url($logouturl, $idptype, $user);
                if ($redirecturl) {
                    if (!empty($this->config->forceredirect) && !empty($CFG->forcelogin)) {
                        // The IdP sends the user back to the site, where the forced redirect and silent login would start
                        // a new login, so remember the logout across the round trip.
                        $this->set_logout_suppression_cookie();
                    }
                    redirect($redirecturl);
                }
            }
        }

        return true;
    }
}
