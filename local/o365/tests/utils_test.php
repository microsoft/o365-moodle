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

namespace local_o365;

use advanced_testcase;
use core\component;
use dml_exception;
use local_o365\tests\mockhttpclient;
use moodle_exception;

/**
 * Unit tests for the class utils
 *
 * @package   local_o365
 * @copyright 2025 eDaktik GmbH {@link https://www.edaktik.at/}
 * @author    Christian Abila <christian.abila@edaktik.at>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \local_o365\utils
 * @group local_o365
 * @group office365
 */
final class utils_test extends advanced_testcase {
    /**
     * The correct Microsoft OID is returned
     *
     * @return void
     * @throws dml_exception
     * @covers ::get_microsoft_account_oid_by_user_id
     */
    public function test_correct_ms_account_returned(): void {
        $this->resetAfterTest();
        global $DB, $USER;

        $expected = 'objectid';
        $DB->insert_record(
            'local_o365_objects',
            [
                'moodleid' => $USER->id,
                'type' => 'user',
                'objectid' => $expected,
                'o365name' => 'name',
                'timecreated' => time(),
                'timemodified' => time(),
            ],
        );

        $this->assertEquals($expected, utils::get_microsoft_account_oid_by_user_id($USER->id));
    }

    /**
     * All connected users are returned correctly.
     *
     * @return void
     * @throws dml_exception
     * @covers ::get_connected_users
     */
    public function test_get_connected_users(): void {
        $this->resetAfterTest();
        global $DB;

        // Create users.
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();
        $user3 = $this->getDataGenerator()->create_user();
        $user4 = $this->getDataGenerator()->create_user();

        // Create local_o365_objects entries.
        $DB->insert_record(
            'local_o365_objects',
            [
                'moodleid' => $user1->id,
                'type' => 'user',
                'objectid' => '00000000-0000-0000-0000-000000000001',
                'o365name' => 'name',
                'timecreated' => time(),
                'timemodified' => time(),
            ],
        );

        $DB->insert_record(
            'local_o365_objects',
            [
                'moodleid' => $user2->id,
                'type' => 'user',
                'objectid' => '00000000-0000-0000-0000-000000000002',
                'o365name' => 'name',
                'timecreated' => time(),
                'timemodified' => time(),
            ],
        );

        $DB->insert_record(
            'local_o365_objects',
            [
                'moodleid' => $user3->id,
                'type' => 'user',
                'objectid' => '00000000-0000-0000-0000-000000000003',
                'o365name' => 'name',
                'timecreated' => time(),
                'timemodified' => time(),
            ],
        );

        $expected = [
            $user1->id => '00000000-0000-0000-0000-000000000001',
            $user2->id => '00000000-0000-0000-0000-000000000002',
            $user3->id => '00000000-0000-0000-0000-000000000003',
        ];

        $this->assertEquals($expected, utils::get_connected_users());
    }

    /**
     * Configured app only access is indicated correctly.
     *
     * @return void
     * @covers ::is_configured_apponlyaccess
     */
    public function test_is_configured_apponlyaccess(): void {
        $this->resetAfterTest();
        set_config('entratenant', 'set', 'local_o365');
        set_config('entratenantid', 'set', 'local_o365');
        $this->assertTrue(utils::is_configured_apponlyaccess());

        set_config('entratenant', '', 'local_o365');
        set_config('entratenantid', '', 'local_o365');
        $this->assertFalse(utils::is_configured_apponlyaccess());
    }

    /**
     * Active app only access is indicated correctly.
     *
     * This method checks both is_configured_apponlyaccess() AND unified::is_configured().
     * Note: unified::is_configured() currently always returns true (legacy APIs removed).
     * Note: is_configured_apponlyaccess() returns true if EITHER config is set (uses OR logic, not AND).
     *
     * @return void
     * @covers ::is_active_apponlyaccess
     */
    public function test_is_active_apponlyaccess(): void {
        $this->resetAfterTest();

        // Test that it returns true when app-only is configured.
        // (unified::is_configured() is always true in current implementation).
        set_config('entratenant', 'set', 'local_o365');
        set_config('entratenantid', 'set', 'local_o365');
        $this->assertTrue(utils::is_active_apponlyaccess());

        // Test that it returns false when app-only is NOT configured,
        // even though unified::is_configured() returns true.
        set_config('entratenant', '', 'local_o365');
        set_config('entratenantid', '', 'local_o365');
        $this->assertFalse(utils::is_active_apponlyaccess());

        // Test partial configuration - if EITHER config is set, returns true.
        // This is the current behavior: the code checks if BOTH are empty to return false.
        set_config('entratenant', 'set', 'local_o365');
        set_config('entratenantid', '', 'local_o365');
        $this->assertTrue(utils::is_active_apponlyaccess());

        set_config('entratenant', '', 'local_o365');
        set_config('entratenantid', 'set', 'local_o365');
        $this->assertTrue(utils::is_active_apponlyaccess());
    }

    /**
     * When an application token can't be obtained, the exception carries the reason returned by the token endpoint.
     *
     * @return void
     * @covers ::get_application_token
     */
    public function test_get_application_token_failure_includes_reason(): void {
        $this->resetAfterTest();
        $pluginslist = component::get_plugin_list('auth');
        if (!array_key_exists('oidc', $pluginslist)) {
            $this->markTestSkipped('auth_oidc needs to be installed to use this test!');
        }

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        set_config('clientid', 'clientid', 'auth_oidc');
        set_config('clientsecret', 'clientsecret', 'auth_oidc');
        set_config('clientauthmethod', AUTH_OIDC_AUTH_METHOD_SECRET, 'auth_oidc');
        set_config('entratenant', 'wrong.example.org', 'local_o365');

        $httpclient = new mockhttpclient();
        $httpclient->set_response(json_encode([
            'error' => 'invalid_request',
            'error_description' => "AADSTS90002: Tenant not found.\r\nTrace ID: 1234",
        ]));

        try {
            utils::get_application_token(
                'https://graph.microsoft.com',
                oauth2\clientdata::instance_from_oidc(),
                $httpclient,
                true
            );
            $this->fail('Expected exception was not thrown.');
        } catch (moodle_exception $e) {
            $this->assertEquals('errorcannotgettoken', $e->errorcode);
            $this->assertEquals('invalid_request: AADSTS90002: Tenant not found. Trace ID: 1234', $e->debuginfo);
        }
    }
}
