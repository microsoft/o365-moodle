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
use dml_exception;

/**
 * Unit tests for the class utils_test
 *
 * @package   local_o365
 * @copyright 2025 eDaktik GmbH {@link https://www.edaktik.at/}
 * @author    Christian Abila <christian.abila@edaktik.at>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \local_o365\utils
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

        $DB->insert_record(
            'local_o365_objects',
            [
                'moodleid' => $USER->id + 1,
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
    public function test_get_connected_user(): void {
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
                'objectid' => $user1->id,
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
                'objectid' => $user2->id,
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
                'objectid' => $user3->id,
                'o365name' => 'name',
                'timecreated' => time(),
                'timemodified' => time(),
            ],
        );

        $expected = [
            $user1->id => $user1->id,
            $user2->id => $user2->id,
            $user3->id => $user3->id,
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
     * @return void
     * @covers ::is_active_apponlyaccess
     */
    public function test_is_active_apponlyaccess(): void {
        $this->resetAfterTest();
        set_config('entratenant', 'set', 'local_o365');
        set_config('entratenantid', 'set', 'local_o365');
        $this->assertTrue(utils::is_active_apponlyaccess());

        set_config('entratenant', '', 'local_o365');
        set_config('entratenantid', '', 'local_o365');
        $this->assertFalse(utils::is_active_apponlyaccess());
    }
}
