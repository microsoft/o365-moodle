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
     * Insert a row into the core {sessions} table so that
     * \core\session\manager::session_exists() reports it as existing.
     *
     * @param string $sid
     * @param int $userid
     * @return void
     * @throws dml_exception
     */
    private function create_moodle_session(string $sid, int $userid): void {
        global $DB;

        $DB->insert_record('sessions', [
            'state' => 0,
            'sid' => $sid,
            'userid' => $userid,
            'sessdata' => '',
            'timecreated' => time(),
            'timemodified' => time(),
        ]);
    }

    /**
     * Mappings whose Moodle session still exists are kept; mappings whose session no longer exists, or
     * that were never given a session id, are deleted.
     *
     * @return void
     * @throws dml_exception
     * @covers ::execute
     */
    public function test_sid_records_are_cleaned_up_based_on_session_existence(): void {
        global $DB;
        $this->resetAfterTest();

        $user = $this->getDataGenerator()->create_user();

        // Mapping tied to a session that still exists: must be kept.
        $this->create_moodle_session('session_active', $user->id);
        $activeid = $DB->insert_record('auth_oidc_sid', [
            'userid' => $user->id,
            'sid' => 'sid_active',
            'timecreated' => time(),
            'sessionid' => 'session_active',
        ]);

        // Mapping tied to a session id that does not exist (e.g. the user's session has already
        // expired or been terminated some other way): must be deleted.
        $expiredid = $DB->insert_record('auth_oidc_sid', [
            'userid' => $user->id,
            'sid' => 'sid_expired',
            'timecreated' => time(),
            'sessionid' => 'session_does_not_exist',
        ]);

        // Legacy mapping created before sessionid was tracked: must be deleted, since there is no way
        // to confirm whether its session still exists.
        $legacyid = $DB->insert_record('auth_oidc_sid', [
            'userid' => $user->id,
            'sid' => 'sid_legacy',
            'timecreated' => time(),
            'sessionid' => null,
        ]);

        $cleanup = new cleanup_oidc_sid();
        $cleanup->execute();

        $this->assertTrue($DB->record_exists('auth_oidc_sid', ['id' => $activeid]));
        $this->assertFalse($DB->record_exists('auth_oidc_sid', ['id' => $expiredid]));
        $this->assertFalse($DB->record_exists('auth_oidc_sid', ['id' => $legacyid]));
    }
}
