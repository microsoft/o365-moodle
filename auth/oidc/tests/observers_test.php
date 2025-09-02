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
use coding_exception;
use dml_exception;

/**
 * Unit tests for the class \auth_oidc\observers
 *
 * @package   auth_oidc
 * @copyright 2025 eDaktik GmbH {@link https://www.edaktik.at/}
 * @author    Christian Abila <christian.abila@edaktik.at>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \auth_oidc\observers
 */
final class observers_test extends advanced_testcase {
    /**
     * OIDC user token is deleted when the Moodle user is deleted.
     *
     * @return void
     * @throws dml_exception
     * @throws coding_exception
     */
    public function test_token_is_deleted_when_user_is_deleted(): void {
        global $DB;
        $this->resetAfterTest();
        // Create user.
        $user = $this->getDataGenerator()->create_user([]);
        // Insert an entry in auth_oidc_token.
        $DB->insert_record(
            'auth_oidc_token',
            [
                'userid' => $user->id,
                'oidcuniqid' => 'oidcuniqid',
                'username' => 'username',
                'scope' => 'scope',
                'authcode' => 'authcode',
                'token' => 'token',
                'expiry' => time(),
                'refreshtoken' => 'refreshtoken',
                'idtoken' => 'idtoken',
            ],
        );
        // Delete the user.
        delete_user($user);

        $this->assertFalse($DB->record_exists('auth_oidc_token', ['userid' => $user->id]));
    }
}
