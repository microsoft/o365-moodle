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

namespace auth_oidc;

use advanced_testcase;
use core\context\system;
use core\event\user_deleted;

/**
 * Unit tests for the class \auth_oidc\observers
 *
 * @package   auth_oidc
 * @copyright 2025 eDaktik GmbH {@link https://www.edaktik.at/}
 * @author    Christian Abila <christian.abila@edaktik.at>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group     auth_oidc
 * @group     office365
 * @coversDefaultClass \auth_oidc\observers
 */
final class observers_test extends advanced_testcase {
    /**
     * Set up test environment.
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * OIDC user token is deleted when the Moodle user is deleted.
     *
     * @return void
     * @covers ::handle_user_deleted
     */
    public function test_token_is_deleted_when_user_is_deleted(): void {
        global $DB;
        // Create user.
        $user = $this->getDataGenerator()->create_user([]);
        // Insert an entry in auth_oidc_token.
        $DB->insert_record(
            'auth_oidc_token',
            [
                'userid' => $user->id,
                'oidcuniqid' => 'oidcuniqid',
                'username' => 'username',
                'oidcusername' => 'oidcusername',
                'scope' => 'scope',
                'tokenresource' => 'tokenresource',
                'authcode' => 'authcode',
                'token' => 'token',
                'expiry' => time(),
                'refreshtoken' => 'refreshtoken',
                'idtoken' => 'idtoken',
            ],
        );

        // Verify token exists before deletion.
        $this->assertTrue($DB->record_exists('auth_oidc_token', ['userid' => $user->id]));

        // Create the user_deleted event with all required data.
        $event = user_deleted::create([
            'objectid' => $user->id,
            'relateduserid' => $user->id,
            'context' => system::instance(),
            'other' => [
                'username' => $user->username,
                'email' => $user->email,
                'idnumber' => $user->idnumber,
                'picture' => $user->picture,
                'mnethostid' => $user->mnethostid,
            ],
        ]);

        // Call the observer directly to test return value.
        $result = observers::handle_user_deleted($event);

        // Verify the method returned true (deletion succeeded).
        $this->assertTrue($result);

        // Verify the token was actually deleted.
        $this->assertFalse($DB->record_exists('auth_oidc_token', ['userid' => $user->id]));
    }

    /**
     * Observer returns true when user has no tokens (no error on empty deletion).
     *
     * @return void
     * @covers ::handle_user_deleted
     */
    public function test_deletion_succeeds_when_user_has_no_tokens(): void {
        global $DB;

        // Create user WITHOUT creating any token.
        $user = $this->getDataGenerator()->create_user([]);

        // Verify no token exists.
        $this->assertFalse($DB->record_exists('auth_oidc_token', ['userid' => $user->id]));

        // Create the user_deleted event with all required data.
        $event = user_deleted::create([
            'objectid' => $user->id,
            'relateduserid' => $user->id,
            'context' => system::instance(),
            'other' => [
                'username' => $user->username,
                'email' => $user->email,
                'idnumber' => $user->idnumber,
                'picture' => $user->picture,
                'mnethostid' => $user->mnethostid,
            ],
        ]);

        // Call the observer directly.
        $result = observers::handle_user_deleted($event);

        // Verify the method returned true even though no records were deleted.
        $this->assertTrue($result);

        // Verify still no token exists (nothing changed).
        $this->assertFalse($DB->record_exists('auth_oidc_token', ['userid' => $user->id]));
    }
}
