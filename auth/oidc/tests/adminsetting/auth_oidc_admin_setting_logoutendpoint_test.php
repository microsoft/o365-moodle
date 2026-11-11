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
 * Unit tests for the logout endpoint admin setting.
 *
 * @package    auth_oidc
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 * @group      auth_oidc
 * @group      office365
 * @coversDefaultClass \auth_oidc\adminsetting\auth_oidc_admin_setting_logoutendpoint
 */
final class auth_oidc_admin_setting_logoutendpoint_test extends advanced_testcase {
    /** @var string The default logout endpoint of the setting. */
    private const DEFAULT_ENDPOINT = 'https://login.microsoftonline.com/organizations/oauth2/logout';

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
        unset($_POST['s_auth_oidc_idptype'], $_POST['s_auth_oidc_single_logout']);
        parent::tearDown();
    }

    /**
     * Create the setting.
     *
     * @return auth_oidc_admin_setting_logoutendpoint
     */
    private function create_setting(): auth_oidc_admin_setting_logoutendpoint {
        return new auth_oidc_admin_setting_logoutendpoint(
            'auth_oidc/logouturi',
            'Logout endpoint',
            'Description',
            self::DEFAULT_ENDPOINT
        );
    }

    /**
     * Data provider for the validation of the logout endpoint with the Microsoft Entra External ID IdP type.
     *
     * @return array
     */
    public static function external_id_logout_endpoint_provider(): array {
        return [
            'logout endpoint' => ['https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/logout', null],
            'empty, derived from the authorization endpoint' => ['', null],
            'placeholders' => [
                'https://<tenant-name>.ciamlogin.com/<tenant-id>/oauth2/v2.0/logout',
                'error_endpoint_external_id_placeholder',
            ],
            'workforce endpoint' => [self::DEFAULT_ENDPOINT, 'error_logoutendpoint_external_id'],
            'another provider' => ['https://idp.example.com/logout', 'error_logoutendpoint_external_id'],
            'multi-tenant path' => [
                'https://contoso.ciamlogin.com/common/oauth2/v2.0/logout',
                'error_endpoint_external_id_tenant',
            ],
            'v1.0 style path' => [
                'https://contoso.ciamlogin.com/tenant-id/oauth2/logout',
                'error_endpoint_external_id_v1',
            ],
        ];
    }

    /**
     * Test the validation of the logout endpoint when single logout is enabled with the External ID IdP type.
     *
     * @dataProvider external_id_logout_endpoint_provider
     * @param string $endpoint
     * @param string|null $errorstring The identifier of the expected error string, null when the endpoint is valid.
     * @return void
     * @covers ::validate
     */
    public function test_validate_external_id_with_single_logout(string $endpoint, ?string $errorstring): void {
        $_POST['s_auth_oidc_idptype'] = (string) AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID;
        $_POST['s_auth_oidc_single_logout'] = '1';

        $result = $this->create_setting()->validate($endpoint);

        if ($errorstring === null) {
            $this->assertTrue($result);
        } else {
            $this->assertSame(get_string($errorstring, 'auth_oidc'), $result);
        }
    }

    /**
     * An External ID logout endpoint of the wrong kind is rejected.
     *
     * @return void
     * @covers ::validate
     */
    public function test_validate_external_id_wrong_kind(): void {
        $_POST['s_auth_oidc_idptype'] = (string) AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID;
        $_POST['s_auth_oidc_single_logout'] = '1';

        $this->assertSame(
            get_string('error_endpoint_external_id_kind', 'auth_oidc', 'logout'),
            $this->create_setting()->validate('https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize')
        );
    }

    /**
     * The saved settings are used when they are not submitted.
     *
     * @return void
     * @covers ::validate
     */
    public function test_validate_uses_saved_settings_when_not_submitted(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');
        set_config('single_logout', 1, 'auth_oidc');

        $this->assertSame(
            get_string('error_logoutendpoint_external_id', 'auth_oidc'),
            $this->create_setting()->validate(self::DEFAULT_ENDPOINT)
        );
    }

    /**
     * The logout endpoint is not checked when single logout is disabled, as the field is not in use then.
     *
     * @return void
     * @covers ::validate
     */
    public function test_validate_external_id_without_single_logout(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');
        set_config('single_logout', 0, 'auth_oidc');

        $this->assertTrue($this->create_setting()->validate(self::DEFAULT_ENDPOINT));
    }

    /**
     * The logout endpoint is not checked for the other IdP types.
     *
     * @return void
     * @covers ::validate
     */
    public function test_validate_other_idp_types(): void {
        $_POST['s_auth_oidc_single_logout'] = '1';
        $setting = $this->create_setting();

        $idptypes = [
            AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID,
            AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM,
            AUTH_OIDC_IDP_TYPE_OTHER,
        ];
        foreach ($idptypes as $idptype) {
            $_POST['s_auth_oidc_idptype'] = (string) $idptype;
            $this->assertTrue($setting->validate(self::DEFAULT_ENDPOINT));
            $this->assertTrue($setting->validate('https://idp.example.com/logout'));
        }
    }

    /**
     * Data provider for the default shown for the configured IdP type.
     *
     * @return array
     */
    public static function default_by_idp_type_provider(): array {
        return [
            'not connected' => [AUTH_OIDC_IDP_TYPE_NOT_CONNECTED, self::DEFAULT_ENDPOINT],
            'Microsoft Entra ID (v1.0)' => [AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, self::DEFAULT_ENDPOINT],
            'Microsoft identity platform (v2.0)' => [AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, self::DEFAULT_ENDPOINT],
            'Microsoft Entra External ID' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID,
                'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/logout',
            ],
            'other' => [AUTH_OIDC_IDP_TYPE_OTHER, ''],
        ];
    }

    /**
     * The default shown next to the field follows the saved IdP type.
     *
     * @dataProvider default_by_idp_type_provider
     * @param int $idptype
     * @param string $expecteddefault
     * @return void
     * @covers ::output_html
     */
    public function test_output_html_shows_default_of_idp_type(int $idptype, string $expecteddefault): void {
        set_config('idptype', $idptype, 'auth_oidc');
        set_config('authendpoint', 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize', 'auth_oidc');
        $setting = $this->create_setting();

        $html = $setting->output_html('https://idp.example.com/saved-value');

        $expected = $expecteddefault === '' ? get_string('emptysettingvalue', 'admin') : $expecteddefault;
        $this->assertStringContainsString(get_string('defaultsettinginfo', 'admin', $expected), $html);
        $this->assertStringContainsString('https://idp.example.com/saved-value', $html);

        // The default of the setting itself is not changed.
        $this->assertSame(self::DEFAULT_ENDPOINT, $setting->get_defaultsetting());
    }
}
