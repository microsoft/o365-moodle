<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace auth_oidc;

use advanced_testcase;
use auth_plugin_oidc;
use ReflectionMethod;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/auth/oidc/auth.php');

/**
 * Unit tests for the logout related behaviour of the auth_plugin_oidc class.
 *
 * @package    auth_oidc
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 * @group      auth_oidc
 * @group      office365
 * @coversDefaultClass \auth_plugin_oidc
 */
final class auth_test extends advanced_testcase {
    /** @var string Authorization endpoint of an External ID tenant. */
    private const EXTERNAL_ID_AUTH_ENDPOINT = 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize';

    /** @var string Logout endpoint of the External ID tenant, as derived from the authorization endpoint. */
    private const EXTERNAL_ID_LOGOUT_ENDPOINT = 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/logout';

    /**
     * Set up the test environment.
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Clean up the request parameters set by the tests.
     *
     * @return void
     */
    protected function tearDown(): void {
        unset($_GET['noredirect'], $_GET['oidcloggedout'], $_GET['oidc']);
        unset($_COOKIE['MOODLEOIDCLOGOUT']);
        parent::tearDown();
    }

    /**
     * Call the private build_logout_url() method.
     *
     * @param string $logouturl The configured logout endpoint.
     * @param int $idptype The IdP type.
     * @param \stdClass $user The user logging out.
     * @return string|null
     */
    private function build_logout_url(string $logouturl, int $idptype, \stdClass $user): ?string {
        $auth = new auth_plugin_oidc();
        $method = new ReflectionMethod($auth, 'build_logout_url');

        return $method->invoke($auth, $logouturl, (string) $idptype, $user);
    }

    /**
     * Parse the query string of a URL.
     *
     * @param string $url
     * @return array
     */
    private function get_query_params(string $url): array {
        parse_str((string) parse_url($url, PHP_URL_QUERY), $params);

        return $params;
    }

    /**
     * Store a token record with the given ID token claims for a user.
     *
     * @param int $userid
     * @param array $claims
     * @return void
     */
    private function create_token_with_claims(int $userid, array $claims): void {
        global $DB;

        $idtoken = base64_encode(json_encode(['alg' => 'RS256'])) . '.' . base64_encode(json_encode($claims)) . '.signature';

        $DB->insert_record('auth_oidc_token', (object) [
            'oidcuniqid' => 'oidcuniqid-' . $userid,
            'username' => 'user' . $userid,
            'userid' => $userid,
            'oidcusername' => 'user' . $userid,
            'useridentifier' => '',
            'scope' => '',
            'tokenresource' => '',
            'authcode' => '',
            'token' => $idtoken,
            'expiry' => time() + 3600,
            'refreshtoken' => '',
            'idtoken' => $idtoken,
        ]);
    }

    /**
     * An External ID logout endpoint that is configured is used, with the post logout redirect.
     *
     * @return void
     * @covers ::build_logout_url
     */
    public function test_build_logout_url_external_id_keeps_configured_endpoint(): void {
        global $CFG;

        set_config('authendpoint', self::EXTERNAL_ID_AUTH_ENDPOINT, 'auth_oidc');
        $user = $this->getDataGenerator()->create_user();

        $url = $this->build_logout_url(
            'https://other.ciamlogin.com/other-tenant/oauth2/v2.0/logout',
            AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID,
            $user
        );

        $this->assertNotNull($url);
        $this->assertSame(
            'https://other.ciamlogin.com/other-tenant/oauth2/v2.0/logout',
            strtok($url, '?')
        );
        $this->assertSame($CFG->wwwroot, $this->get_query_params($url)['post_logout_redirect_uri']);
    }

    /**
     * Data provider for the logout endpoints that are not External ID endpoints.
     *
     * @return array
     */
    public static function external_id_derived_logout_endpoint_provider(): array {
        return [
            'empty endpoint' => [''],
            'workforce endpoint saved while the IdP type was another one' => [
                'https://login.microsoftonline.com/organizations/oauth2/logout',
            ],
        ];
    }

    /**
     * Without an External ID logout endpoint, it is derived from the authorization endpoint.
     *
     * @dataProvider external_id_derived_logout_endpoint_provider
     * @param string $logouturl
     * @return void
     * @covers ::build_logout_url
     */
    public function test_build_logout_url_external_id_derives_endpoint(string $logouturl): void {
        global $CFG;

        set_config('authendpoint', self::EXTERNAL_ID_AUTH_ENDPOINT, 'auth_oidc');
        $user = $this->getDataGenerator()->create_user();

        $url = $this->build_logout_url($logouturl, AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, $user);

        $this->assertNotNull($url);
        $this->assertSame(self::EXTERNAL_ID_LOGOUT_ENDPOINT, strtok($url, '?'));
        $this->assertSame($CFG->wwwroot, $this->get_query_params($url)['post_logout_redirect_uri']);
    }

    /**
     * The logout endpoint cannot be derived when the authorization endpoint is not an External ID endpoint.
     *
     * @return void
     * @covers ::build_logout_url
     */
    public function test_build_logout_url_external_id_returns_null_with_invalid_authorization_endpoint(): void {
        set_config('authendpoint', 'https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize', 'auth_oidc');
        $user = $this->getDataGenerator()->create_user();

        $this->assertNull($this->build_logout_url('', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, $user));
        $this->assertNull($this->build_logout_url(
            'https://login.microsoftonline.com/organizations/oauth2/logout',
            AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID,
            $user
        ));
    }

    /**
     * The login_hint claim of the stored ID token is sent as the logout hint.
     *
     * @return void
     * @covers ::build_logout_url
     */
    public function test_build_logout_url_external_id_adds_logout_hint_from_login_hint_claim(): void {
        set_config('authendpoint', self::EXTERNAL_ID_AUTH_ENDPOINT, 'auth_oidc');
        $user = $this->getDataGenerator()->create_user();
        $this->create_token_with_claims($user->id, ['oid' => 'oid-1', 'login_hint' => 'opaque-login-hint']);

        $url = $this->build_logout_url('', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, $user);

        $this->assertSame('opaque-login-hint', $this->get_query_params($url)['logout_hint']);
    }

    /**
     * No logout hint is sent when the ID token has no login_hint claim, or the user has no token.
     *
     * @return void
     * @covers ::build_logout_url
     */
    public function test_build_logout_url_external_id_has_no_logout_hint_without_claim(): void {
        set_config('authendpoint', self::EXTERNAL_ID_AUTH_ENDPOINT, 'auth_oidc');
        $user = $this->getDataGenerator()->create_user();
        $usernotoken = $this->getDataGenerator()->create_user();
        $this->create_token_with_claims($user->id, ['oid' => 'oid-1', 'sid' => 'session-id']);

        $params = $this->get_query_params(
            $this->build_logout_url('', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, $user)
        );
        $this->assertArrayNotHasKey('logout_hint', $params);
        $this->assertArrayNotHasKey('id_token_hint', $params);

        $params = $this->get_query_params(
            $this->build_logout_url('', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, $usernotoken)
        );
        $this->assertArrayNotHasKey('logout_hint', $params);
        $this->assertArrayNotHasKey('id_token_hint', $params);
    }

    /**
     * Create the auth plugin with the forced redirect enabled or disabled.
     *
     * @param bool $forceredirect
     * @return auth_plugin_oidc
     */
    private function create_auth_plugin(bool $forceredirect): auth_plugin_oidc {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');
        set_config('forceredirect', $forceredirect ? 1 : 0, 'auth_oidc');

        return new auth_plugin_oidc();
    }

    /**
     * With the forced redirect and a site that requires login, logging out goes to the login page without a redirect to the IdP.
     *
     * @return void
     * @covers ::logoutpage_hook
     */
    public function test_logoutpage_hook_redirects_front_page_to_login_page(): void {
        global $CFG, $redirect;

        $CFG->forcelogin = 1;
        $auth = $this->create_auth_plugin(true);

        $redirect = $CFG->wwwroot . '/';
        $auth->logoutpage_hook();

        $this->assertSame($CFG->wwwroot . '/login/index.php', strtok($redirect, '?'));
        $params = $this->get_query_params($redirect);
        $this->assertSame('1', $params['noredirect']);
        $this->assertSame('1', $params['oidcloggedout']);
    }

    /**
     * When logging out already goes to the login page, it gets the parameters that prevent the redirect to the IdP.
     *
     * @return void
     * @covers ::logoutpage_hook
     */
    public function test_logoutpage_hook_adds_parameters_to_login_page_redirect(): void {
        global $CFG, $redirect;

        $auth = $this->create_auth_plugin(true);

        $redirect = $CFG->wwwroot . '/login/index.php';
        $auth->logoutpage_hook();

        $this->assertSame($CFG->wwwroot . '/login/index.php', strtok($redirect, '?'));
        $params = $this->get_query_params($redirect);
        $this->assertSame('1', $params['noredirect']);
        $this->assertSame('1', $params['oidcloggedout']);
    }

    /**
     * Data provider for the situations in which the logout redirect is left as it is.
     *
     * @return array
     */
    public static function unchanged_logout_redirect_provider(): array {
        return [
            'forced redirect disabled, login required' => [false, 1, '/'],
            'forced redirect disabled, login page' => [false, 0, '/login/index.php'],
            'login not required, front page' => [true, 0, '/'],
            'another page' => [true, 1, '/course/index.php'],
        ];
    }

    /**
     * The logout redirect is not changed when there is no forced redirect to the IdP to prevent.
     *
     * @dataProvider unchanged_logout_redirect_provider
     * @param bool $forceredirect
     * @param int $forcelogin
     * @param string $path The path of the redirect, relative to the site.
     * @return void
     * @covers ::logoutpage_hook
     */
    public function test_logoutpage_hook_leaves_other_redirects_unchanged(
        bool $forceredirect,
        int $forcelogin,
        string $path
    ): void {
        global $CFG, $redirect;

        $CFG->forcelogin = $forcelogin;
        $auth = $this->create_auth_plugin($forceredirect);

        $redirect = $CFG->wwwroot . $path;
        $auth->logoutpage_hook();

        $this->assertSame($CFG->wwwroot . $path, $redirect);
    }

    /**
     * The noredirect parameter stops the redirect to the IdP, and is remembered for the rest of the session.
     *
     * @return void
     * @covers ::should_login_redirect
     */
    public function test_should_login_redirect_remembers_noredirect(): void {
        global $SESSION;

        $auth = $this->create_auth_plugin(true);
        unset($SESSION->oidc);
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['noredirect'] = '1';

        $this->assertFalse($auth->should_login_redirect());
        $this->assertSame(0, $SESSION->oidc);

        // The next visit of the login page is not redirected either.
        unset($_GET['noredirect']);
        $this->assertFalse($auth->should_login_redirect());
    }

    /**
     * Right after logging out, the redirect to the IdP is skipped without being remembered for the rest of the session.
     *
     * @return void
     * @covers ::should_login_redirect
     */
    public function test_should_login_redirect_does_not_remember_noredirect_after_logout(): void {
        global $SESSION;

        $auth = $this->create_auth_plugin(true);
        unset($SESSION->oidc);
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['noredirect'] = '1';
        $_GET['oidcloggedout'] = '1';

        $this->assertFalse($auth->should_login_redirect());
        $this->assertFalse(isset($SESSION->oidc));

        // The next visit of the login page is redirected to the IdP.
        unset($_GET['noredirect'], $_GET['oidcloggedout']);
        $this->assertTrue($auth->should_login_redirect());
    }

    /**
     * Create the auth plugin, with the cookies that it sends recorded instead of being sent to the browser.
     *
     * @param bool $forceredirect
     * @return auth_plugin_oidc
     */
    private function create_auth_plugin_recording_cookies(bool $forceredirect): auth_plugin_oidc {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');
        set_config('authendpoint', self::EXTERNAL_ID_AUTH_ENDPOINT, 'auth_oidc');
        set_config('forceredirect', $forceredirect ? 1 : 0, 'auth_oidc');
        set_config('single_logout', 1, 'auth_oidc');

        return new class extends auth_plugin_oidc {
            /** @var array The cookies that would have been sent, indexed by name. */
            public array $cookies = [];

            /**
             * Record the cookie instead of sending it.
             *
             * @param string $name
             * @param string $value
             * @param int $expires
             * @return void
             */
            protected function send_cookie(string $name, string $value, int $expires): void {
                $this->cookies[$name] = ['value' => $value, 'expires' => $expires];
            }

            /**
             * Expose has_logout_suppression_cookie().
             *
             * @return bool
             */
            public function cookie_present(): bool {
                return $this->has_logout_suppression_cookie();
            }

            /**
             * Expose clear_logout_suppression_cookie().
             *
             * @return void
             */
            public function clear_cookie(): void {
                $this->clear_logout_suppression_cookie();
            }
        };
    }

    /**
     * Log an OpenID Connect user out with the single logout of the plugin, which redirects to the IdP.
     *
     * @param auth_plugin_oidc $auth
     * @return void
     */
    private function run_postlogout_hook(auth_plugin_oidc $auth): void {
        $user = $this->getDataGenerator()->create_user(['auth' => 'oidc']);

        try {
            $auth->postlogout_hook($user);
            $this->fail('The user should have been redirected to the IdP logout endpoint.');
        } catch (\moodle_exception $e) {
            // The redirect is not supported in tests, and means the user was sent to the IdP.
            $this->assertSame('redirecterrordetected', $e->errorcode);
        }
    }

    /**
     * With the forced redirect and a site that requires login, the logout is remembered across the round trip to the IdP.
     *
     * The IdP returns the user to the site URL registered in the app, which cannot carry any parameter.
     *
     * @return void
     * @covers ::postlogout_hook
     */
    public function test_postlogout_hook_remembers_logout_across_idp_round_trip(): void {
        global $CFG;

        $CFG->forcelogin = 1;
        $auth = $this->create_auth_plugin_recording_cookies(true);

        $this->run_postlogout_hook($auth);

        $this->assertArrayHasKey('MOODLEOIDCLOGOUT', $auth->cookies);
        $this->assertSame('1', $auth->cookies['MOODLEOIDCLOGOUT']['value']);
        $this->assertGreaterThan(time(), $auth->cookies['MOODLEOIDCLOGOUT']['expires']);
    }

    /**
     * Nothing is remembered when the forced redirect, or the login requirement, is off, as the return to the site is
     * not sent back to the IdP then.
     *
     * @return void
     * @covers ::postlogout_hook
     */
    public function test_postlogout_hook_does_not_remember_logout_without_forced_redirect_and_login(): void {
        global $CFG;

        $CFG->forcelogin = 1;
        $auth = $this->create_auth_plugin_recording_cookies(false);
        $this->run_postlogout_hook($auth);
        $this->assertSame([], $auth->cookies);

        $CFG->forcelogin = 0;
        $auth = $this->create_auth_plugin_recording_cookies(true);
        $this->run_postlogout_hook($auth);
        $this->assertSame([], $auth->cookies);
    }

    /**
     * Back from the IdP logout, the user is taken to the login page and not sent to the IdP again by the page that
     * requires login.
     *
     * @return void
     * @covers ::pre_loginpage_hook
     * @covers ::clear_logout_suppression_cookie
     */
    public function test_return_from_idp_logout_does_not_start_a_new_login(): void {
        $auth = $this->create_auth_plugin_recording_cookies(true);
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_COOKIE['MOODLEOIDCLOGOUT'] = '1';

        $this->assertTrue($auth->cookie_present());
        // This would redirect to the IdP, which is not supported in tests and throws an exception.
        $auth->pre_loginpage_hook();

        // The cookie stays until the login page, where it is removed.
        $this->assertTrue($auth->cookie_present());
        $auth->clear_cookie();
        $this->assertFalse($auth->cookie_present());
        $this->assertLessThan(time(), $auth->cookies['MOODLEOIDCLOGOUT']['expires']);
    }
}
