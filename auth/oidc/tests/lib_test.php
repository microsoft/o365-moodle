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

/**
 * Unit tests for functions in auth/oidc/lib.php
 *
 * @package   auth_oidc
 * @author    Lai Wei <lai.wei@enovation.ie>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 * @group auth_oidc
 * @group office365
 */
final class lib_test extends advanced_testcase {
    /**
     * Data provider for {@see self::test_validate_secret_expiry_recipients()}.
     *
     * @return array
     */
    public static function validate_secret_expiry_recipients_provider(): array {
        return [
            'empty string' => ['', []],
            'whitespace only' => ['   ', []],
            'single valid address' => ['admin@example.com', []],
            'multiple valid addresses' => ['admin@example.com, second@example.com', []],
            'valid addresses with surrounding whitespace and trailing comma' => [
                ' admin@example.com , second@example.com , ',
                [],
            ],
            'single invalid address' => ['not-an-email', ['not-an-email']],
            'mixed valid and invalid' => [
                'admin@example.com, broken, third@example.com',
                ['broken'],
            ],
            'multiple invalid addresses' => [
                'broken, also broken@',
                ['broken', 'also broken@'],
            ],
        ];
    }

    /**
     * Test auth_oidc_validate_secret_expiry_recipients().
     *
     * @dataProvider validate_secret_expiry_recipients_provider
     * @param string $value
     * @param array $expected
     * @return void
     * @covers ::auth_oidc_validate_secret_expiry_recipients
     */
    public function test_validate_secret_expiry_recipients(string $value, array $expected): void {
        $this->resetAfterTest(true);

        require_once(__DIR__ . '/../lib.php');

        $this->assertSame($expected, auth_oidc_validate_secret_expiry_recipients($value));
    }

    /**
     * Create an auth_oidc_token record for a user.
     *
     * @param int $userid
     * @return void
     */
    private function create_token_record(int $userid): void {
        global $DB;

        $DB->insert_record('auth_oidc_token', (object)[
            'oidcuniqid' => 'uniqid' . $userid,
            'username' => 'user' . $userid,
            'userid' => $userid,
            'oidcusername' => 'user' . $userid . '@example.com',
            'scope' => 'openid',
            'tokenresource' => 'resource',
            'authcode' => 'authcode',
            'token' => 'token',
            'expiry' => time() + 3600,
            'refreshtoken' => 'refreshtoken',
            'idtoken' => 'idtoken',
        ]);
    }

    /**
     * Test auth_oidc_clear_user_tokens() and auth_oidc_count_users_with_tokens().
     *
     * @covers ::auth_oidc_clear_user_tokens
     * @covers ::auth_oidc_count_users_with_tokens
     * @return void
     */
    public function test_clear_user_tokens(): void {
        global $DB;

        $this->resetAfterTest(true);

        require_once(__DIR__ . '/../lib.php');

        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();
        $user3 = $this->getDataGenerator()->create_user();
        $this->create_token_record($user1->id);
        $this->create_token_record($user2->id);
        $this->create_token_record($user3->id);
        // A token record not matched to a Moodle user must never be cleared.
        $this->create_token_record(0);

        $this->assertEquals(3, auth_oidc_count_users_with_tokens());
        $this->assertEquals(2, auth_oidc_count_users_with_tokens([$user1->id, $user2->id]));
        $this->assertEquals(0, auth_oidc_count_users_with_tokens([]));

        // Clearing tokens of no user is a no-op.
        $this->assertEquals(0, auth_oidc_clear_user_tokens([]));
        $this->assertEquals(0, auth_oidc_clear_user_tokens([0]));
        $this->assertEquals(4, $DB->count_records('auth_oidc_token'));

        // Clear the tokens of selected users only.
        $this->assertEquals(2, auth_oidc_clear_user_tokens([$user1->id, $user3->id]));
        $this->assertEqualsCanonicalizing([$user2->id, 0], array_column($DB->get_records('auth_oidc_token'), 'userid'));

        // Clear the tokens of all users, leaving the token record without a user.
        $this->assertEquals(1, auth_oidc_clear_user_tokens());
        $this->assertEquals([0], array_column($DB->get_records('auth_oidc_token'), 'userid'));
    }
}
