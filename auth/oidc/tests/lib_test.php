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
     * Data provider for {@see self::test_trim_user_field_value()}.
     *
     * @return array
     */
    public static function trim_user_field_value_provider(): array {
        return [
            'value within column limit is unchanged' => ['city', 'Toronto', 'Toronto'],
            'value exceeding column limit is trimmed' => [
                'phone1',
                '+43 (1) XXXXX - 5107, 5145, 6866',
                '+43 (1) XXXXX - 5107',
            ],
            'field not a user table column is unchanged' => [
                'profile_field_custom',
                str_repeat('a', 500),
                str_repeat('a', 500),
            ],
            'non-character column is unchanged' => ['id', str_repeat('1', 50), str_repeat('1', 50)],
            'non-string value is unchanged' => ['firstname', 123, 123],
        ];
    }

    /**
     * Test auth_oidc_trim_user_field_value().
     *
     * @dataProvider trim_user_field_value_provider
     * @param string $localfield
     * @param mixed $value
     * @param mixed $expected
     * @return void
     * @covers ::auth_oidc_trim_user_field_value
     */
    public function test_trim_user_field_value(string $localfield, $value, $expected): void {
        $this->resetAfterTest(true);

        require_once(__DIR__ . '/../lib.php');

        $this->assertSame($expected, auth_oidc_trim_user_field_value($localfield, $value));
    }
}
