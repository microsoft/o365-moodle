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

namespace auth_oidc\task;

use advanced_testcase;
use dml_exception;

/**
 * Unit tests for the class cleanup_oidc_sid_test
 *
 * @package   auth_oidc
 * @copyright 2025 eDaktik GmbH {@link https://www.edaktik.at/}
 * @author    Christian Abila <christian.abila@edaktik.at>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \auth_oidc\task\cleanup_oidc_sid
 */
final class cleanup_oidc_sid_test extends advanced_testcase {
    /**
     * SIDs created before yesterday are deleted.
     *
     * @return void
     * @throws dml_exception
     * @covers ::execute
     */
    public function test_sids_older_than_yesterday_are_deleted(): void {
        global $DB, $USER;
        $this->resetAfterTest();
        $twodaysago = strtotime('-2 day');
        $yesterday = strtotime('-1 day');
        $today = time();
        // Create entries in auth_oidc_sid.
        $entry1id = $DB->insert_record(
            'auth_oidc_sid',
            ['userid' => $USER->id, 'sid' => 'sid', 'timecreated' => $twodaysago],
        );
        $entry2id = $DB->insert_record(
            'auth_oidc_sid',
            ['userid' => $USER->id, 'sid' => 'sid', 'timecreated' => ($twodaysago - 1000)],
        );
        $entry3id = $DB->insert_record(
            'auth_oidc_sid',
            ['userid' => $USER->id, 'sid' => 'sid', 'timecreated' => $today],
        );
        $entry4id = $DB->insert_record(
            'auth_oidc_sid',
            ['userid' => $USER->id, 'sid' => 'sid', 'timecreated' => $yesterday],
        );

        $cleanup = new cleanup_oidc_sid();

        $cleanup->execute();

        $records = $DB->get_records('auth_oidc_sid');

        $this->assertCount(2, $records);

        $this->assertTrue($DB->record_exists('auth_oidc_sid', ['id' => $entry3id]));
        $this->assertFalse($DB->record_exists('auth_oidc_sid', ['id' => $entry1id]));
        $this->assertFalse($DB->record_exists('auth_oidc_sid', ['id' => $entry2id]));
        $this->assertTrue($DB->record_exists('auth_oidc_sid', ['id' => $entry4id]));
    }
}
