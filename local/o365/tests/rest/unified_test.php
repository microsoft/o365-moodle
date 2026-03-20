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
 * Unit tests for the unified class.
 *
 * @package local_o365
 * @author Christian Abila <christian.abila@edaktik.at>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2025 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\rest;

use advanced_testcase;
use core\component;
use dml_exception;
use local_o365\oauth2\token;
use local_o365\tests\mockhttpclient;

/**
 * Unit tests for the class unified
 *
 * @package   local_o365
 * @copyright 2025 eDaktik GmbH {@link https://www.edaktik.at/}
 * @author    Christian Abila <christian.abila@edaktik.at>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group local_o365
 * @group office365
 * @coversDefaultClass \local_o365\rest\unified
 */
final class unified_test extends advanced_testcase {
    /**
     * If oidcresource is set, its value is returned.
     *
     * @return void
     * @throws dml_exception
     * @covers ::get_tokenresource
     */
    public function test_get_token_oidc_resource(): void {
        $this->resetAfterTest();
        $pluginslist = component::get_plugin_list('auth');
        if (!array_key_exists('oidc', $pluginslist)) {
            $this->markTestSkipped('auth_oidc needs to be installed to use this test!');
        }

        $resource = 'resource';
        set_config('oidcresource', $resource, 'auth_oidc');

        $this->assertEquals($resource, unified::get_tokenresource());
    }

    /**
     * If oidcresource and the Chinese API are not set, "https://graph.microsoft.com" is returned.
     *
     * @return void
     * @covers ::get_tokenresource
     * @throws dml_exception
     */
    public function test_get_token_microsoft_resource(): void {
        $this->resetAfterTest();
        $pluginslist = component::get_plugin_list('auth');
        if (!array_key_exists('oidc', $pluginslist)) {
            $this->markTestSkipped('auth_oidc needs to be installed to use this test!');
        }

        $this->assertEquals(unified::RESOURCE_URL, unified::get_tokenresource());
    }

    /**
     * If oidcresource is not set and chineseapi is active, then the Chinese resource is returned.
     *
     * @return void
     * @covers ::get_tokenresource
     * @throws dml_exception
     */
    public function test_get_token_chinese_api(): void {
        $this->resetAfterTest();
        $pluginslist = component::get_plugin_list('auth');
        if (!array_key_exists('oidc', $pluginslist)) {
            $this->markTestSkipped('auth_oidc needs to be installed to use this test!');
        }

        set_config('chineseapi', '1', 'local_o365');

        $this->assertEquals(unified::RESOURCE_URL_CHINESE, unified::get_tokenresource());
    }

    /**
     * use_chinese_api() returns the correct value.
     *
     * @return void
     * @covers ::use_chinese_api
     */
    public function test_use_chinese_api_returns_correct_value(): void {
        $this->resetAfterTest();
        $this->assertFalse(unified::use_chinese_api());

        set_config('chineseapi', '1', 'local_o365');
        $this->assertTrue(unified::use_chinese_api());
    }

    /**
     * If the HTTP client is not completely set, the HTTP method's result is returned.
     *
     * @return void
     * @covers ::betaapicall
     */
    public function test_betaapicall_http_method_result(): void {

        $expectedresult = 'OK';
        $token = self::createMock(token::class);
        $token->method('is_expired')->willReturn(false);
        $token->method('get_token')->willReturn('token');

        $httpclient = new mockhttpclient();
        $httpclient->set_response($expectedresult);

        $unified = new unified($token, $httpclient);
        $this->assertEquals($expectedresult, $unified->betaapicall('get', 'users'));
    }

    /**
     * If the HTTP code is 202, the HTTP response is returned.
     *
     * @return void
     * @covers ::betaapicall
     */
    public function test_betaapicall_202(): void {

        $expectedresult = 'OK';
        $token = self::createMock(token::class);
        $token->method('is_expired')->willReturn(false);
        $token->method('get_token')->willReturn('token');

        $httpclient = new mockhttpclient();
        $httpclient->set_response($expectedresult);
        $httpclient->info = ['http_code' => 202];
        $httpclient->response = $expectedresult;

        $unified = new unified($token, $httpclient);
        $this->assertEquals($expectedresult, $unified->betaapicall('get', 'users'));
    }
}
