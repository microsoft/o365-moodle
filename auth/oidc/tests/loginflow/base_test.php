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
use core\plugininfo\auth as auth_plugininfo;

/**
 * Unit tests for the class \auth_oidc\loginflow\base.
 *
 * @package    auth_oidc
 * @copyright  2026 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group      auth_oidc
 * @group      office365
 * @coversDefaultClass \auth_oidc\loginflow\base
 */
final class base_test extends advanced_testcase {
    /**
     * Set up test environment.
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);

        // Lib.php isn't autoloaded, and AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID below is defined there.
        require_once(__DIR__ . '/../../lib.php');

        auth_plugininfo::enable_plugin('oidc', 1);

        // Avoid the Microsoft identity platform IdP type, which forces a Graph API call regardless of field
        // mapping, so get_userinfo() takes the token-based path this test exercises.
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
    }

    /**
     * get_userinfo() must leave the user's email unset when the IdP provided neither an email claim nor an
     * email-shaped user principal name, and placeholder generation is disabled (the default) — instead of
     * silently synthesizing an address.
     *
     * @return void
     * @covers ::get_userinfo
     */
    public function test_get_userinfo_leaves_email_unset_when_no_valid_email_and_generation_disabled(): void {
        $userinfo = $this->get_userinfo_for_token('jdoe', [
            'oid' => 'oid-jdoe',
            'upn' => 'CONTOSO\\jdoe',
            'given_name' => 'John',
            'family_name' => 'Doe',
        ]);

        $this->assertArrayNotHasKey('email', $userinfo);
    }

    /**
     * get_userinfo() must generate and apply a placeholder email address when the IdP provided no usable
     * email address and the site is configured to generate one.
     *
     * Regression test for https://github.com/microsoft/o365-moodle/issues/2839.
     *
     * @return void
     * @covers ::get_userinfo
     */
    public function test_get_userinfo_generates_placeholder_email_end_to_end(): void {
        set_config('generatedummyemail', 1, 'auth_oidc');
        set_config('dummyemaildomain', 'example.test', 'auth_oidc');

        $userinfo = $this->get_userinfo_for_token('jdoe', [
            'oid' => 'oid-jdoe',
            'upn' => 'CONTOSO\\jdoe',
            'given_name' => 'John',
            'family_name' => 'Doe',
        ]);

        $this->assertSame('contosojdoe@example.test', $userinfo['email']);
    }

    /**
     * get_userinfo() must still use a genuine email claim from the IdP in preference to generating a
     * placeholder address, even when placeholder generation is enabled.
     *
     * @return void
     * @covers ::get_userinfo
     */
    public function test_get_userinfo_prefers_email_claim_over_placeholder(): void {
        set_config('generatedummyemail', 1, 'auth_oidc');
        set_config('dummyemaildomain', 'example.test', 'auth_oidc');

        $userinfo = $this->get_userinfo_for_token('jdoe', [
            'oid' => 'oid-jdoe',
            'upn' => 'CONTOSO\\jdoe',
            'email' => 'john.doe@contoso.com',
            'given_name' => 'John',
            'family_name' => 'Doe',
        ]);

        $this->assertSame('john.doe@contoso.com', $userinfo['email']);
    }

    /**
     * Store an auth_oidc_token record carrying the given claims (used for both the ID token and access
     * token), and return the array produced by get_userinfo() for it.
     *
     * @param string $username The Moodle username the token is stored against.
     * @param array $claims The JWT claims to encode into the stored ID and access tokens.
     * @return array
     */
    private function get_userinfo_for_token(string $username, array $claims): array {
        global $DB;

        $encodedtoken = $this->encode_jwt($claims);

        $DB->insert_record('auth_oidc_token', (object) [
            'oidcuniqid' => 'oidcuniqid-' . $username,
            'username' => $username,
            'userid' => 0,
            'oidcusername' => $username,
            'useridentifier' => '',
            'scope' => '',
            'tokenresource' => '',
            'authcode' => '',
            'token' => $encodedtoken,
            'expiry' => time() + 3600,
            'refreshtoken' => '',
            'idtoken' => $encodedtoken,
        ]);

        $loginflow = new base();
        $userinfo = $loginflow->get_userinfo($username);
        $this->assertIsArray($userinfo);

        return $userinfo;
    }

    /**
     * Build a minimal, unsigned, encoded JWT string carrying the given claims, decodable by
     * \auth_oidc\jwt::instance_from_encoded().
     *
     * @param array $claims The claims to encode into the JWT payload.
     * @return string
     */
    private function encode_jwt(array $claims): string {
        $header = base64_encode(json_encode(['alg' => 'RS256']));
        $payload = base64_encode(json_encode($claims));

        return $header . '.' . $payload . '.signature';
    }
}
