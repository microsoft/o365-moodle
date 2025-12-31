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
 * Unit tests for the class cleanup_oidc_sid
 *
 * @package   auth_oidc
 * @copyright 2025 eDaktik GmbH {@link https://www.edaktik.at/}
 * @author    Christian Abila <christian.abila@edaktik.at>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group auth_oidc
 * @group office365
 * @coversDefaultClass \auth_oidc\task\cleanup_oidc_sid
 */
final class cleanup_oidc_sid_test extends advanced_testcase {
    /**
     * SIDs older than 1 day are deleted.
     *
     * The cleanup task deletes records where timecreated < strtotime('-1 day').
     * Records created exactly 1 day ago or more recently are kept.
     *
     * @return void
     * @throws dml_exception
     * @covers ::execute
     */
    public function test_sids_older_than_yesterday_are_deleted(): void {
        global $DB;
        $this->resetAfterTest();

        // Create a test user to own the SID records.
        $user = $this->getDataGenerator()->create_user();

        // Calculate cutoff time once to avoid timing issues if test runs slowly.
        // This matches what the cleanup task will calculate during execute().
        $cutofftime = strtotime('-1 day');

        // Create timestamps relative to the cutoff time.
        $twodaysago = $cutofftime - DAYSECS;  // Older than cutoff, should be deleted.
        $yesterday = $cutofftime;              // Exactly at cutoff, should be kept (< operator).
        $today = time();                       // Newer than cutoff, should be kept.

        // Create entries in auth_oidc_sid with unique SIDs.
        $entry1id = $DB->insert_record(
            'auth_oidc_sid',
            ['userid' => $user->id, 'sid' => 'sid_old_1', 'timecreated' => $twodaysago],
        );
        $entry2id = $DB->insert_record(
            'auth_oidc_sid',
            ['userid' => $user->id, 'sid' => 'sid_old_2', 'timecreated' => ($twodaysago - 1000)],
        );
        $entry3id = $DB->insert_record(
            'auth_oidc_sid',
            ['userid' => $user->id, 'sid' => 'sid_new_1', 'timecreated' => $today],
        );
        $entry4id = $DB->insert_record(
            'auth_oidc_sid',
            ['userid' => $user->id, 'sid' => 'sid_boundary', 'timecreated' => $yesterday],
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
