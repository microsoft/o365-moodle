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
}
