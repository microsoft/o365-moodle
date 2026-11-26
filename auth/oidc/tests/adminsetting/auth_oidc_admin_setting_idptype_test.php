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
 * Unit tests for the IdP type admin setting.
 *
 * @package    auth_oidc
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 * @group      auth_oidc
 * @group      office365
 * @coversDefaultClass \auth_oidc\adminsetting\auth_oidc_admin_setting_idptype
 */
final class auth_oidc_admin_setting_idptype_test extends advanced_testcase {
    /** @var string The standard logout endpoint of the Microsoft workforce IdP types. */
    private const WORKFORCE_LOGOUT_ENDPOINT = 'https://login.microsoftonline.com/organizations/oauth2/logout';

    /**
     * Set up the test environment.
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
        $this->setAdminUser();
    }

    /**
     * Clean up the request parameters set by the tests.
     *
     * @return void
     */
    protected function tearDown(): void {
        unset($_POST['s_auth_oidc_authendpoint']);
        parent::tearDown();
    }

    /**
     * Create the setting.
     *
     * @return auth_oidc_admin_setting_idptype
     */
    private function create_setting(): auth_oidc_admin_setting_idptype {
        return new auth_oidc_admin_setting_idptype(
            'auth_oidc/idptype',
            'IdP type',
            'Description',
            AUTH_OIDC_IDP_TYPE_NOT_CONNECTED,
            [
                AUTH_OIDC_IDP_TYPE_NOT_CONNECTED => 'Not connected',
                AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID => 'Microsoft Entra ID (v1.0)',
                AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM => 'Microsoft identity platform (v2.0)',
                AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID => 'Microsoft Entra External ID',
                AUTH_OIDC_IDP_TYPE_OTHER => 'Other',
            ]
        );
    }

    /**
     * Changing the IdP type saves it, and updates a standard logout endpoint using the submitted authorization endpoint.
     *
     * @return void
     * @covers ::write_setting
     */
    public function test_write_setting_converts_logout_endpoint(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        set_config('logouturi', self::WORKFORCE_LOGOUT_ENDPOINT, 'auth_oidc');
        $_POST['s_auth_oidc_authendpoint'] = 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize';

        $result = $this->create_setting()->write_setting((string) AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);

        $this->assertSame('', $result);
        $this->assertEquals(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, get_config('auth_oidc', 'idptype'));
        $this->assertSame(
            'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/logout',
            get_config('auth_oidc', 'logouturi')
        );
    }

    /**
     * The Microsoft cloud that is submitted with the IdP type is used for the logout endpoint, although it is saved after
     * the IdP type.
     *
     * @return void
     * @covers ::write_setting
     */
    public function test_write_setting_uses_submitted_microsoft_cloud_for_logout_endpoint(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');
        set_config('microsoftcloud', AUTH_OIDC_MICROSOFT_CLOUD_GLOBAL, 'auth_oidc');
        set_config('logouturi', 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/logout', 'auth_oidc');
        $_POST['s_auth_oidc_microsoftcloud'] = (string) AUTH_OIDC_MICROSOFT_CLOUD_CHINA;

        $result = $this->create_setting()->write_setting((string) AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM);

        $this->assertSame('', $result);
        $this->assertSame(
            'https://login.partner.microsoftonline.cn/organizations/oauth2/logout',
            get_config('auth_oidc', 'logouturi')
        );
    }

    /**
     * A logout endpoint that was entered by the administrator is kept when the IdP type changes.
     *
     * @return void
     * @covers ::write_setting
     */
    public function test_write_setting_keeps_custom_logout_endpoint(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        set_config('logouturi', 'https://idp.example.com/logout', 'auth_oidc');
        $_POST['s_auth_oidc_authendpoint'] = 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize';

        $result = $this->create_setting()->write_setting((string) AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);

        $this->assertSame('', $result);
        $this->assertSame('https://idp.example.com/logout', get_config('auth_oidc', 'logouturi'));
    }

    /**
     * The logout endpoint is not touched when the IdP type is saved without being changed.
     *
     * @return void
     * @covers ::write_setting
     */
    public function test_write_setting_without_change_keeps_logout_endpoint(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        set_config('logouturi', self::WORKFORCE_LOGOUT_ENDPOINT, 'auth_oidc');

        $result = $this->create_setting()->write_setting((string) AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID);

        $this->assertSame('', $result);
        $this->assertSame(self::WORKFORCE_LOGOUT_ENDPOINT, get_config('auth_oidc', 'logouturi'));
    }

    /**
     * A standard Microsoft logout endpoint is cleared when the IdP type is changed to another provider.
     *
     * @return void
     * @covers ::write_setting
     */
    public function test_write_setting_clears_microsoft_logout_endpoint_for_other_idp(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        set_config('logouturi', self::WORKFORCE_LOGOUT_ENDPOINT, 'auth_oidc');

        $result = $this->create_setting()->write_setting((string) AUTH_OIDC_IDP_TYPE_OTHER);

        $this->assertSame('', $result);
        $this->assertSame('', get_config('auth_oidc', 'logouturi'));
    }
}
