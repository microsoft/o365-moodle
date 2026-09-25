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

namespace local_o365\oauth2;

use advanced_testcase;
use local_o365\tests\mockhttpclient;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/auth/oidc/lib.php');

/**
 * Unit tests for the class clientdata and the application token request.
 *
 * @package   local_o365
 * @copyright 2026 Enovation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group local_o365
 * @group office365
 */
final class clientdata_test extends advanced_testcase {
    /**
     * The app token endpoint uses the global sign-in service by default, and the Chinese one if the Chinese cloud is used.
     *
     * @return void
     * @covers \local_o365\oauth2\clientdata::get_apptokenendpoint_from_tenant
     * @covers \local_o365\oauth2\clientdata::get_login_baseurl
     */
    public function test_get_apptokenendpoint_from_tenant(): void {
        $this->resetAfterTest();

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        $this->assertEquals(
            'https://login.microsoftonline.com/contoso.com/oauth2/token',
            clientdata::get_apptokenendpoint_from_tenant('contoso.com')
        );

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');
        $this->assertEquals(
            'https://login.microsoftonline.com/contoso.com/oauth2/v2.0/token',
            clientdata::get_apptokenendpoint_from_tenant('contoso.com')
        );

        set_config('microsoftcloud', AUTH_OIDC_MICROSOFT_CLOUD_CHINA, 'auth_oidc');
        $this->assertEquals(
            'https://login.partner.microsoftonline.cn/contoso.com/oauth2/v2.0/token',
            clientdata::get_apptokenendpoint_from_tenant('contoso.com')
        );

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        $this->assertEquals(
            'https://login.partner.microsoftonline.cn/contoso.com/oauth2/token',
            clientdata::get_apptokenendpoint_from_tenant('contoso.com')
        );
    }

    /**
     * No app token endpoint is returned for other identity providers.
     *
     * @return void
     * @covers \local_o365\oauth2\clientdata::get_apptokenendpoint_from_tenant
     */
    public function test_get_apptokenendpoint_from_tenant_other_idp(): void {
        $this->resetAfterTest();

        set_config('idptype', AUTH_OIDC_IDP_TYPE_OTHER, 'auth_oidc');
        set_config('microsoftcloud', AUTH_OIDC_MICROSOFT_CLOUD_CHINA, 'auth_oidc');
        $this->assertEquals('', clientdata::get_apptokenendpoint_from_tenant('contoso.com'));
    }

    /**
     * The app token request is sent to the sign-in service, and asks for the Graph resource, of the cloud in use.
     *
     * @return void
     * @covers \local_o365\oauth2\apptoken::get_app_token
     */
    public function test_get_app_token_request_uses_cloud_endpoints(): void {
        $this->resetAfterTest();

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');
        set_config('clientid', 'clientid', 'auth_oidc');
        set_config('clientsecret', 'clientsecret', 'auth_oidc');
        set_config('clientauthmethod', AUTH_OIDC_AUTH_METHOD_SECRET, 'auth_oidc');

        $cases = [
            [AUTH_OIDC_MICROSOFT_CLOUD_GLOBAL, 'https://login.microsoftonline.com/', 'https://graph.microsoft.com/.default'],
            [
                AUTH_OIDC_MICROSOFT_CLOUD_CHINA,
                'https://login.partner.microsoftonline.cn/',
                'https://microsoftgraph.chinacloudapi.cn/.default',
            ],
        ];
        foreach ($cases as [$microsoftcloud, $expectedurl, $expectedscope]) {
            set_config('microsoftcloud', $microsoftcloud, 'auth_oidc');
            $httpclient = new mockhttpclient();
            $httpclient->set_response(json_encode(['error' => 'invalid_request']));

            $clientdata = clientdata::instance_from_oidc('contoso.com');
            $this->assertFalse(apptoken::get_app_token('https://graph.microsoft.com', $clientdata, $httpclient));

            $requests = $httpclient->get_requests();
            $this->assertCount(1, $requests);
            $this->assertStringStartsWith($expectedurl, $requests[0]['url']);
            $this->assertStringContainsString('scope=' . urlencode($expectedscope), $requests[0]['options']['CURLOPT_POSTFIELDS']);
        }
    }
}
