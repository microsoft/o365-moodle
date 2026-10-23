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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace auth_oidc\loginflow;

use advanced_testcase;
use auth_oidc\jwt;
use core\plugininfo\auth as auth_plugininfo;
use moodle_exception;
use phpunit_util;

/**
 * Unit tests for the class \auth_oidc\loginflow\authcode.
 *
 * @package    auth_oidc
 * @copyright  2026 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group      auth_oidc
 * @group      office365
 * @coversDefaultClass \auth_oidc\loginflow\authcode
 */
final class authcode_test extends advanced_testcase {
    /**
     * Set up test environment.
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);

        auth_plugininfo::enable_plugin('oidc', 1);
        set_config('bindingusernameclaim', 'upn', 'auth_oidc');
    }

    /**
     * A manually matched user (auth already 'oidc', local_o365_connections keyed on the full Entra UPN,
     * Moodle username only the UPN prefix) must complete on the very first OIDC login: the token must be
     * bound to the matched Moodle user, not left dangling because the Moodle username differs from the UPN.
     *
     * Regression test for https://github.com/microsoft/o365-moodle/issues/2875.
     *
     * @return void
     * @covers ::handlelogin
     * @covers ::check_for_matched
     */
    public function test_handlelogin_completes_manually_matched_user_with_differing_username(): void {
        if (!auth_oidc_is_local_365_installed()) {
            $this->markTestSkipped('This test requires local_o365 to be installed (local_o365_connections table).');
        }

        $this->assert_login_completes_for_matched_user('asmith@sc.school.edu.au', 'asmith@sc.school.edu.au');
    }

    /**
     * A local_o365_connections row stored with mixed-case entraidupn (e.g. saved before UPNs were
     * normalized to lower case, or entered that way by an admin) must still match a differently-cased
     * UPN claim from the ID token, including on case-sensitive database collations such as PostgreSQL.
     *
     * @return void
     * @covers ::check_for_matched
     */
    public function test_handlelogin_completes_manually_matched_user_with_legacy_mixed_case_upn(): void {
        if (!auth_oidc_is_local_365_installed()) {
            $this->markTestSkipped('This test requires local_o365 to be installed (local_o365_connections table).');
        }

        $this->assert_login_completes_for_matched_user('ASmith@SC.School.edu.AU', 'asmith@sc.school.edu.au');
    }

    /**
     * When the "Show login button" setting is disabled, loginpage_idp_list() must not expose an entry
     * for this provider on the login page, even though the plugin is otherwise fully configured.
     *
     * Regression test for https://github.com/microsoft/o365-moodle/issues/1824.
     *
     * @return void
     * @covers ::loginpage_idp_list
     */
    public function test_loginpage_idp_list_is_empty_when_showbutton_disabled(): void {
        set_config('clientid', 'clientid', 'auth_oidc');
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        set_config('clientauthmethod', AUTH_OIDC_AUTH_METHOD_SECRET, 'auth_oidc');
        set_config('clientsecret', 'clientsecret', 'auth_oidc');
        set_config('authendpoint', 'https://example.com/authorize', 'auth_oidc');
        set_config('tokenendpoint', 'https://example.com/token', 'auth_oidc');

        $loginflow = new authcode();
        $this->assertNotEmpty($loginflow->loginpage_idp_list(''));

        set_config('showbutton', 0, 'auth_oidc');
        $loginflow = new authcode();
        $this->assertEmpty($loginflow->loginpage_idp_list(''));
    }

    /**
     * Data provider for test_handlelogin_rejects_new_user_with_duplicate_email().
     *
     * @return array
     */
    public static function duplicate_email_provider(): array {
        return [
            'same case' => ['john.smith@example.com', 'john.smith@example.com'],
            'different case' => ['john.smith@example.com', 'John.Smith@Example.com'],
            'existing email is mixed case' => ['John.Smith@Example.com', 'john.smith@example.com'],
        ];
    }

    /**
     * When "Allow accounts with same email" is disabled, a first-time OIDC login must not create a new account
     * if another account already uses the same email address, regardless of the letter case of either address.
     *
     * Regression test for https://github.com/microsoft/o365-moodle/issues/1836.
     *
     * @dataProvider duplicate_email_provider
     * @param string $existingemail The email of the existing Moodle user.
     * @param string $incomingemail The email received for the user who is logging in.
     * @return void
     * @covers ::handlelogin
     */
    public function test_handlelogin_rejects_new_user_with_duplicate_email(
        string $existingemail,
        string $incomingemail
    ): void {
        global $DB;

        set_config('allowaccountssameemail', 0);
        $this->getDataGenerator()->create_user(['username' => 'existinguser', 'email' => $existingemail]);

        $upn = 'newuser@example.com';
        $idtoken = new jwt();
        $idtoken->set_claims([
            'sub' => 'sub-newuser',
            'upn' => $upn,
            'preferred_username' => $upn,
        ]);

        $oidcuniqid = 'oidcuniqid-newuser';
        $authparams = ['code' => 'authcode-newuser'];
        $tokenparams = [
            'access_token' => 'access-token',
            'id_token' => 'id-token',
            'expires_in' => 3600,
            'resource' => 'resource',
            'scope' => 'scope',
        ];

        $loginflow = $this->getMockBuilder(authcode::class)
            ->onlyMethods(['get_userinfo'])
            ->getMock();
        $loginflow->method('get_userinfo')->willReturn(['email' => $incomingemail]);

        $_GET['code'] = $authparams['code'];

        try {
            phpunit_util::call_internal_method(
                $loginflow,
                'handlelogin',
                [$oidcuniqid, $authparams, $tokenparams, $idtoken],
                authcode::class
            );
            $this->fail('Expected a moodle_exception for the duplicate email address.');
        } catch (moodle_exception $e) {
            $this->assertEquals('errorauthloginfaileddupemail', $e->errorcode);
            $this->assertEquals('auth_oidc', $e->module);
        } finally {
            unset($_GET['code']);
        }

        $this->assertFalse($DB->record_exists('user', ['username' => 'newuser@example.com']));
    }

    /**
     * Data provider for test_handleauthresponse_forwards_stored_code_verifier.
     *
     * @return array
     */
    public static function codeverifier_provider(): array {
        return [
            'verifier stored with the state' => ['storedverifier', 'storedverifier'],
            'PKCE disabled (empty verifier)' => ['', null],
            'state created before the upgrade (null verifier)' => [null, null],
        ];
    }

    /**
     * The code verifier stored with the state must be the one sent in the token request, and a state without one must
     * be exchanged without PKCE.
     *
     * @param string|null $storedverifier The value of auth_oidc_state.codeverifier.
     * @param string|null $expectedverifier The code_verifier expected in the token request, or null if it must be absent.
     * @return void
     * @dataProvider codeverifier_provider
     * @covers ::handleauthresponse
     */
    public function test_handleauthresponse_forwards_stored_code_verifier(
        ?string $storedverifier,
        ?string $expectedverifier
    ): void {
        global $CFG, $DB;

        // The CSRF cookie check, which sets a cookie and so cannot run after PHPUnit has started output, is only done over
        // HTTPS. It is not what is tested here, so make sure it is skipped whatever the test environment's wwwroot is.
        $CFG->wwwroot = 'http://www.example.com/moodle';
        $CFG->sslproxy = false;
        unset($_COOKIE['auth_oidc_csrf']);

        set_config('clientid', 'clientid', 'auth_oidc');
        set_config('clientsecret', 'clientsecret', 'auth_oidc');
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        set_config('clientauthmethod', AUTH_OIDC_AUTH_METHOD_SECRET, 'auth_oidc');
        set_config('authendpoint', 'http://example.com/auth', 'auth_oidc');
        set_config('tokenendpoint', 'http://example.com/token', 'auth_oidc');

        $DB->insert_record('auth_oidc_state', (object) [
            'sesskey' => sesskey(),
            'state' => 'teststate',
            'nonce' => 'Ntestnonce',
            'timecreated' => time(),
            'additionaldata' => serialize([]),
            'codeverifier' => $storedverifier,
        ]);

        // An ID token without a subject makes the login stop right after the token request, which is all that is checked here.
        $encode = static fn(array $data): string => rtrim(strtr(base64_encode(json_encode($data)), '+/', '-_'), '=');
        $idtoken = $encode(['alg' => 'none']) . '.' . $encode(['aud' => 'clientid']) . '.';
        $httpclient = new \auth_oidc\tests\mockhttpclient();
        $httpclient->set_response(json_encode(['id_token' => $idtoken, 'access_token' => 'accesstoken']));

        $loginflow = new authcode();
        $loginflow->set_httpclient($httpclient);
        try {
            phpunit_util::call_internal_method(
                $loginflow,
                'handleauthresponse',
                [['code' => 'thecode', 'state' => 'teststate']],
                authcode::class
            );
            $this->fail('Expected the login to stop at the ID token without a subject.');
        } catch (\moodle_exception $e) {
            $this->assertEquals('errorauthinvalididtoken', $e->errorcode);
        }

        $this->assertCount(1, $httpclient->postrequests);
        $tokenrequest = $httpclient->postrequests[0]['params'];
        $this->assertEquals('thecode', $tokenrequest['code']);
        if ($expectedverifier === null) {
            $this->assertArrayNotHasKey('code_verifier', $tokenrequest);
        } else {
            $this->assertEquals($expectedverifier, $tokenrequest['code_verifier']);
        }
        $this->assertFalse($DB->record_exists('auth_oidc_state', ['state' => 'teststate']));
    }

    /**
     * Creates a Moodle user manually matched to the given (as-stored) Entra UPN, drives handlelogin() with
     * an ID token carrying the given (as-received) UPN claim, and asserts the login completed and bound
     * the auth_oidc_token to the matched user.
     *
     * @param string $storedentraidupn The UPN as stored in local_o365_connections.entraidupn.
     * @param string $tokenupn The UPN as received in the ID token's upn/preferred_username claims.
     * @return void
     */
    private function assert_login_completes_for_matched_user(string $storedentraidupn, string $tokenupn): void {
        global $DB;

        $user = $this->getDataGenerator()->create_user(['username' => 'asmith', 'auth' => 'oidc']);

        // Simulate an admin manually matching the Moodle user to their Entra UPN via
        // Manage User Connections, then flipping the account to auth 'oidc'.
        $DB->insert_record('local_o365_connections', (object) [
            'muserid' => $user->id,
            'entraidupn' => $storedentraidupn,
            'uselogin' => 0,
        ]);

        $idtoken = new jwt();
        $idtoken->set_claims([
            'sub' => 'sub-' . $user->id,
            'upn' => $tokenupn,
            'preferred_username' => $tokenupn,
        ]);

        $oidcuniqid = 'oidcuniqid-' . $user->id;
        $authparams = ['code' => 'authcode-' . $user->id];
        $tokenparams = [
            'access_token' => 'access-token',
            'id_token' => 'id-token',
            'expires_in' => 3600,
            'resource' => 'resource',
            'scope' => 'scope',
        ];

        // The user_login() method validates the auth code against the current request, so it has to be
        // available via optional_param() the same way it would be on a real OIDC callback request.
        $_GET['code'] = $authparams['code'];

        try {
            $loginflow = new authcode();
            phpunit_util::call_internal_method(
                $loginflow,
                'handlelogin',
                [$oidcuniqid, $authparams, $tokenparams, $idtoken],
                authcode::class
            );
        } finally {
            unset($_GET['code']);
        }

        $tokenrec = $DB->get_record('auth_oidc_token', ['oidcuniqid' => $oidcuniqid]);
        $this->assertNotEmpty($tokenrec);
        $this->assertEquals($user->id, $tokenrec->userid);
        $this->assertEquals('asmith', $tokenrec->username);

        global $USER;
        $this->assertEquals($user->id, $USER->id);
    }

    /**
     * Test detection of authorization errors that mean multi-factor authentication is required.
     *
     * @param string $error The error code returned by the identity provider.
     * @param string $errordescription The error description returned by the identity provider.
     * @param bool $expected The expected result.
     * @return void
     * @covers ::is_mfa_required_error
     * @dataProvider is_mfa_required_error_provider
     */
    public function test_is_mfa_required_error(string $error, string $errordescription, bool $expected): void {
        $this->assertSame($expected, authcode::is_mfa_required_error($error, $errordescription));
    }

    /**
     * Data provider for test_is_mfa_required_error().
     *
     * @return array
     */
    public static function is_mfa_required_error_provider(): array {
        return [
            'interaction required error code' => ['interaction_required', 'Interaction is required.', true],
            'interaction required without description' => ['interaction_required', '', true],
            'mfa error in description only' => [
                '',
                'AADSTS50076: Due to a configuration change made by your administrator, you must use multi-factor authentication.',
                true,
            ],
            'other error' => ['access_denied', 'AADSTS65004: The user declined to consent.', false],
            'no error' => ['', '', false],
        ];
    }
}
