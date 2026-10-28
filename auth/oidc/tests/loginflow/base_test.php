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
use phpunit_util;

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
    }

    /**
     * Data provider for test_is_user_from_additional_tenant.
     *
     * @return array
     */
    public static function is_user_from_additional_tenant_provider(): array {
        $hosting = 'abcdef12-3456-7890-abcd-ef1234567890';
        $other = '22222222-2222-2222-2222-222222222222';
        $endpoint = 'https://login.microsoftonline.com/' . $hosting . '/oauth2/v2.0/authorize';
        $commonendpoint = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize';

        return [
            'Hosting tenant matches token' => [$hosting, '', $hosting, false],
            'Hosting tenant matches token, different case' => [$hosting, '', strtoupper($hosting), false],
            'Hosting tenant differs from token' => [$hosting, '', $other, true],
            'Token has no tenant ID' => [$hosting, '', null, true],
            'Token has no tenant ID and hosting tenant not recorded' => ['', '', null, true],
            'Hosting tenant not recorded, no tenant in endpoint' => ['', $commonendpoint, $other, false],
            'Hosting tenant not recorded, endpoint tenant matches token' => ['', $endpoint, $hosting, false],
            'Hosting tenant not recorded, endpoint tenant differs from token' => ['', $endpoint, $other, true],
            'Recorded hosting tenant takes precedence over endpoint' => [$other, $endpoint, $hosting, true],
        ];
    }

    /**
     * Test that users are only identified as coming from an additional tenant when the tenants can be compared.
     *
     * @param string $hostingtenantid The local_o365 entratenantid setting.
     * @param string $authendpoint The auth_oidc authendpoint setting.
     * @param string|null $tokentenantid The tid claim of the token, null for no claim.
     * @param bool $expected The expected result.
     * @return void
     * @dataProvider is_user_from_additional_tenant_provider
     * @covers ::is_user_from_additional_tenant
     */
    public function test_is_user_from_additional_tenant(
        string $hostingtenantid,
        string $authendpoint,
        ?string $tokentenantid,
        bool $expected
    ): void {
        set_config('entratenantid', $hostingtenantid, 'local_o365');
        set_config('authendpoint', $authendpoint, 'auth_oidc');

        $claims = ['sub' => 'subject'];
        if ($tokentenantid !== null) {
            $claims['tid'] = $tokentenantid;
        }
        $token = new jwt();
        $token->set_claims($claims);

        $loginflow = new base();
        $result = phpunit_util::call_internal_method($loginflow, 'is_user_from_additional_tenant', [$token], base::class);

        $this->assertSame($expected, $result);
    }

    /**
     * Test that get_userinfo() falls back to token based field mapping when the Graph API client cannot be created,
     * for example because the admin consent flow has not completed and there is no application token.
     *
     * @return void
     * @covers ::get_userinfo
     */
    public function test_get_userinfo_falls_back_to_token_when_graph_api_unavailable(): void {
        global $DB;

        if (!auth_oidc_is_local_365_installed()) {
            $this->markTestSkipped('This test requires local_o365 to be installed.');
        }

        // No hosting tenant recorded and no application token, so the Graph API client cannot be created.
        set_config('entratenantid', '', 'local_o365');
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');
        set_config('field_updatelocal_firstname', 'oncreate', 'auth_oidc');
        set_config('field_map_firstname', 'givenName', 'auth_oidc');

        $encode = static function (array $claims): string {
            return base64_encode(json_encode(['alg' => 'none'])) . '.' .
                rtrim(strtr(base64_encode(json_encode($claims)), '+/', '-_'), '=') . '.sig';
        };
        $claims = [
            'tid' => '33333333-3333-3333-3333-333333333333',
            'oid' => 'object-id',
            'preferred_username' => 'jane@example.com',
            'email' => 'jane@example.com',
            'given_name' => 'Jane',
            'family_name' => 'Doe',
        ];

        $DB->insert_record('auth_oidc_token', (object) [
            'oidcuniqid' => 'oidcuniqid',
            'username' => 'jane@example.com',
            'userid' => 0,
            'oidcusername' => 'jane@example.com',
            'scope' => 'openid',
            'resource' => 'resource',
            'authcode' => 'authcode',
            'token' => $encode($claims),
            'expiry' => time() + 3600,
            'refreshtoken' => 'refresh',
            'idtoken' => $encode($claims),
        ]);

        $loginflow = new base();
        $userinfo = $loginflow->get_userinfo('jane@example.com');

        $this->assertIsArray($userinfo);
        $this->assertSame('Jane', $userinfo['firstname']);
    }
}
