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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace auth_oidc\task;

use advanced_testcase;
use dml_exception;

/**
 * Unit tests for the class cleanup_oidc_state_and_token
 *
 * @package   auth_oidc
 * @copyright 2026 Enovation Solutions
 * @author    Lai Wei <lai.wei@enovation.ie>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group auth_oidc
 * @group office365
 * @coversDefaultClass \auth_oidc\task\cleanup_oidc_state_and_token
 */
final class cleanup_oidc_state_and_token_test extends advanced_testcase {
    /**
     * Insert an auth_oidc_state record with the given state string and timecreated.
     *
     * @param string $state Unique state string.
     * @param int $timecreated Time the state record was created.
     * @return int The id of the inserted record.
     * @throws dml_exception
     */
    private function create_state_record(string $state, int $timecreated): int {
        global $DB;

        return $DB->insert_record('auth_oidc_state', [
            'sesskey' => 'sesskey123',
            'state' => $state,
            'nonce' => 'nonce123',
            'timecreated' => $timecreated,
        ]);
    }

    /**
     * When "stateexpiry" is not configured, state records older than the default 5 minutes are deleted.
     *
     * @return void
     * @throws dml_exception
     * @covers ::execute
     */
    public function test_default_expiry_is_five_minutes(): void {
        global $DB;
        $this->resetAfterTest();

        $now = time();
        $cutofftime = strtotime('-5 min', $now);

        $old = $cutofftime - MINSECS;
        $new = $cutofftime + MINSECS;

        $oldid = $this->create_state_record('state_old', $old);
        $newid = $this->create_state_record('state_new', $new);

        (new cleanup_oidc_state_and_token())->execute();

        $this->assertFalse($DB->record_exists('auth_oidc_state', ['id' => $oldid]));
        $this->assertTrue($DB->record_exists('auth_oidc_state', ['id' => $newid]));
    }

    /**
     * A configured "stateexpiry" value is honored, keeping records that the default 5 minute
     * window would have deleted.
     *
     * @return void
     * @throws dml_exception
     * @covers ::execute
     */
    public function test_configured_expiry_is_honored(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('stateexpiry', 15, 'auth_oidc');

        $now = time();
        $cutofftime = strtotime('-15 min', $now);

        // 10 minutes old: would be deleted by the default 5 minute window, but must be kept
        // with a configured 15 minute expiry.
        $keptbyconfig = $now - (MINSECS * 10);
        $old = $cutofftime - MINSECS;
        $new = $cutofftime + MINSECS;

        $keptbyconfigid = $this->create_state_record('state_kept', $keptbyconfig);
        $oldid = $this->create_state_record('state_old', $old);
        $newid = $this->create_state_record('state_new', $new);

        (new cleanup_oidc_state_and_token())->execute();

        $this->assertTrue($DB->record_exists('auth_oidc_state', ['id' => $keptbyconfigid]));
        $this->assertFalse($DB->record_exists('auth_oidc_state', ['id' => $oldid]));
        $this->assertTrue($DB->record_exists('auth_oidc_state', ['id' => $newid]));
    }

    /**
     * A "stateexpiry" of zero or less falls back to the default 5 minute window, rather than
     * deleting state records almost immediately.
     *
     * @return void
     * @throws dml_exception
     * @covers ::execute
     */
    public function test_non_positive_expiry_falls_back_to_default(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('stateexpiry', 0, 'auth_oidc');

        $now = time();

        // Created just now: would be deleted almost immediately by a literal zero-minute expiry,
        // but must survive because zero falls back to the 5 minute default.
        $recent = $now - MINSECS;

        $recentid = $this->create_state_record('state_recent', $recent);

        (new cleanup_oidc_state_and_token())->execute();

        $this->assertTrue($DB->record_exists('auth_oidc_state', ['id' => $recentid]));
    }
}
