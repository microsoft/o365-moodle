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

namespace auth_oidc\adminsetting;

use advanced_testcase;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/auth/oidc/lib.php');

/**
 * Unit tests for the authorization and token endpoint admin setting.
 *
 * @package    auth_oidc
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 * @group      auth_oidc
 * @group      office365
 * @coversDefaultClass \auth_oidc\adminsetting\auth_oidc_admin_setting_endpoint
 */
final class auth_oidc_admin_setting_endpoint_test extends advanced_testcase {
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
        unset(
            $_POST['s_auth_oidc_idptype'],
            $_POST['s_auth_oidc_clientauthmethod'],
            $_POST['s_auth_oidc_authendpoint']
        );
        parent::tearDown();
    }

    /**
     * Create the setting.
     *
     * @param string $type Either "auth" or "token".
     * @return auth_oidc_admin_setting_endpoint
     */
    private function create_setting(string $type): auth_oidc_admin_setting_endpoint {
        return new auth_oidc_admin_setting_endpoint(
            'auth_oidc/' . ($type === 'token' ? 'tokenendpoint' : 'authendpoint'),
            'Endpoint',
            'Description',
            'https://login.microsoftonline.com/organizations/oauth2/' . ($type === 'token' ? 'token' : 'authorize'),
            $type
        );
    }

    /**
     * Submit the IdP type and optionally the client authentication method, as the settings form would.
     *
     * @param int $idptype
     * @param int|null $clientauthmethod
     * @return void
     */
    private function submit(int $idptype, ?int $clientauthmethod = null): void {
        $_POST['s_auth_oidc_idptype'] = (string) $idptype;
        if ($clientauthmethod !== null) {
            $_POST['s_auth_oidc_clientauthmethod'] = (string) $clientauthmethod;
        }
    }

    /**
     * Data provider for the validation of the endpoints with the Microsoft Entra External ID IdP type.
     *
     * @return array
     */
    public static function external_id_endpoint_provider(): array {
        return [
            'authorization endpoint' => [
                'auth', 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize', null,
            ],
            'token endpoint' => [
                'token', 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token', null,
            ],
            'default template with placeholders' => [
                'auth', 'https://<tenant-name>.ciamlogin.com/<tenant-id>/oauth2/v2.0/authorize',
                'error_endpoint_external_id_placeholder',
            ],
            'workforce host' => [
                'auth', 'https://login.microsoftonline.com/tenant-id/oauth2/v2.0/authorize', 'error_endpoint_external_id',
            ],
            'multi-tenant path' => [
                'auth', 'https://contoso.ciamlogin.com/common/oauth2/v2.0/authorize', 'error_endpoint_external_id_tenant',
            ],
            'v1.0 style path' => [
                'token', 'https://contoso.ciamlogin.com/tenant-id/oauth2/token', 'error_endpoint_external_id_v1',
            ],
        ];
    }

    /**
     * Test the validation of the endpoints with the Microsoft Entra External ID IdP type.
     *
     * @dataProvider external_id_endpoint_provider
     * @param string $type
     * @param string $endpoint
     * @param string|null $errorstring The identifier of the expected error string, null when the endpoint is valid.
     * @return void
     * @covers ::validate
     */
    public function test_validate_external_id(string $type, string $endpoint, ?string $errorstring): void {
        $this->submit(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);

        $result = $this->create_setting($type)->validate($endpoint);

        if ($errorstring === null) {
            $this->assertTrue($result);
        } else {
            $this->assertSame(get_string($errorstring, 'auth_oidc'), $result);
        }
    }

    /**
     * An External ID endpoint of the wrong kind is rejected.
     *
     * @return void
     * @covers ::validate
     */
    public function test_validate_external_id_wrong_kind(): void {
        $this->submit(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);

        $this->assertSame(
            get_string('error_endpoint_external_id_kind', 'auth_oidc', 'authorize'),
            $this->create_setting('auth')->validate('https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token')
        );
        $this->assertSame(
            get_string('error_endpoint_external_id_kind', 'auth_oidc', 'token'),
            $this->create_setting('token')->validate('https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize')
        );
    }

    /**
     * The token endpoint has to belong to the same External ID tenant as the authorization endpoint.
     *
     * @return void
     * @covers ::validate
     */
    public function test_validate_external_id_token_endpoint_tenant_must_match_authorization_endpoint(): void {
        $this->submit(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);
        $_POST['s_auth_oidc_authendpoint'] = 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize';
        $setting = $this->create_setting('token');

        $this->assertTrue($setting->validate('https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token'));
        $this->assertSame(
            get_string('error_endpoint_external_id_mismatch', 'auth_oidc'),
            $setting->validate('https://contoso.ciamlogin.com/another-tenant/oauth2/v2.0/token')
        );
        $this->assertSame(
            get_string('error_endpoint_external_id_mismatch', 'auth_oidc'),
            $setting->validate('https://another.ciamlogin.com/tenant-id/oauth2/v2.0/token')
        );
    }

    /**
     * The tenants are only compared when the authorization endpoint is a valid External ID endpoint.
     *
     * @return void
     * @covers ::validate
     */
    public function test_validate_external_id_token_endpoint_not_compared_with_invalid_authorization_endpoint(): void {
        $this->submit(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);
        $_POST['s_auth_oidc_authendpoint'] = 'https://<tenant-name>.ciamlogin.com/<tenant-id>/oauth2/v2.0/authorize';

        $this->assertTrue(
            $this->create_setting('token')->validate('https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token')
        );
    }

    /**
     * The saved IdP type is used when it is not submitted.
     *
     * @return void
     * @covers ::validate
     */
    public function test_validate_uses_saved_idp_type_when_not_submitted(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');

        $this->assertSame(
            get_string('error_endpoint_external_id', 'auth_oidc'),
            $this->create_setting('auth')->validate('https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize')
        );
    }

    /**
     * Data provider for the validation of the endpoints with the Microsoft IdP types and the other IdP type.
     *
     * @return array
     */
    public static function other_idp_type_endpoint_provider(): array {
        $v1 = 'https://login.microsoftonline.com/organizations/oauth2/authorize';
        $v2 = 'https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize';
        $external = 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize';

        return [
            'v1.0 type, v1.0 endpoint' => [AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, $v1, null],
            'v1.0 type, v2.0 endpoint' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, $v2, 'error_endpoint_mismatch_auth_endpoint',
            ],
            'v1.0 type, External ID endpoint' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, $external, 'error_endpoint_is_external_id',
            ],
            'v2.0 type, v2.0 endpoint' => [AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, $v2, null],
            'v2.0 type, v1.0 endpoint' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, $v1, 'error_endpoint_mismatch_auth_endpoint',
            ],
            'v2.0 type, External ID endpoint' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, $external, 'error_endpoint_is_external_id',
            ],
            'other type, v1.0 endpoint' => [AUTH_OIDC_IDP_TYPE_OTHER, $v1, null],
            'other type, v2.0 endpoint' => [AUTH_OIDC_IDP_TYPE_OTHER, $v2, null],
            'other type, External ID endpoint' => [AUTH_OIDC_IDP_TYPE_OTHER, $external, null],
            'other type, endpoint of another provider' => [
                AUTH_OIDC_IDP_TYPE_OTHER, 'https://idp.example.com/oauth2/authorize', null,
            ],
        ];
    }

    /**
     * Test the validation of the authorization endpoint with the other IdP types.
     *
     * @dataProvider other_idp_type_endpoint_provider
     * @param int $idptype
     * @param string $endpoint
     * @param string|null $errorstring The identifier of the expected error string, null when the endpoint is valid.
     * @return void
     * @covers ::validate
     */
    public function test_validate_other_idp_types(int $idptype, string $endpoint, ?string $errorstring): void {
        $this->submit($idptype);

        $result = $this->create_setting('auth')->validate($endpoint);

        if ($errorstring === null) {
            $this->assertTrue($result);
        } else {
            $this->assertSame(get_string($errorstring, 'auth_oidc'), $result);
        }
    }

    /**
     * Test that the Microsoft identity platform requires tenant specific endpoints with certificate authentication.
     *
     * @return void
     * @covers ::validate
     */
    public function test_validate_identity_platform_certificate_requires_tenant_specific_endpoint(): void {
        $this->submit(AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, AUTH_OIDC_AUTH_METHOD_CERTIFICATE);
        $setting = $this->create_setting('auth');

        $this->assertSame(
            get_string('error_tenant_specific_endpoint_required', 'auth_oidc'),
            $setting->validate('https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize')
        );
        $this->assertTrue(
            $setting->validate('https://login.microsoftonline.com/contoso.onmicrosoft.com/oauth2/v2.0/authorize')
        );

        $this->submit(AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, AUTH_OIDC_AUTH_METHOD_SECRET);
        $this->assertTrue($setting->validate('https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize'));
    }
}
