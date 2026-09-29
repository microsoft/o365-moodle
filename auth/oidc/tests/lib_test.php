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
     * A user principal name that is itself a valid email address should be returned as-is.
     *
     * @return void
     * @covers ::auth_oidc_upn_as_email
     */
    public function test_auth_oidc_upn_as_email_returns_valid_email_upn(): void {
        require_once(__DIR__ . '/../lib.php');

        $this->assertSame('jdoe@contoso.com', auth_oidc_upn_as_email('jdoe@contoso.com'));
    }

    /**
     * A user principal name that is not in email format (for example, an on-premises style SAM account name,
     * or one using a non-routable domain suffix) must not be treated as an email address.
     *
     * @return void
     * @covers ::auth_oidc_upn_as_email
     */
    public function test_auth_oidc_upn_as_email_returns_null_for_non_email_upn(): void {
        require_once(__DIR__ . '/../lib.php');

        $this->assertNull(auth_oidc_upn_as_email('CONTOSO\\jdoe'));
        $this->assertNull(auth_oidc_upn_as_email(null));
        $this->assertNull(auth_oidc_upn_as_email(''));
    }

    /**
     * If placeholder email generation is disabled (the default), no placeholder address should be generated,
     * regardless of what identifiers are available.
     *
     * Regression test for https://github.com/microsoft/o365-moodle/issues/2839.
     *
     * @return void
     * @covers ::auth_oidc_generate_dummy_email
     */
    public function test_auth_oidc_generate_dummy_email_returns_null_when_disabled(): void {
        $this->resetAfterTest(true);
        require_once(__DIR__ . '/../lib.php');

        $this->assertNull(auth_oidc_generate_dummy_email('CONTOSO\\jdoe', 'objectid-1'));
    }

    /**
     * If placeholder generation is enabled but no domain has been configured, no placeholder address should
     * be generated, since there is nothing to build one from.
     *
     * @return void
     * @covers ::auth_oidc_generate_dummy_email
     */
    public function test_auth_oidc_generate_dummy_email_returns_null_when_domain_not_configured(): void {
        $this->resetAfterTest(true);
        require_once(__DIR__ . '/../lib.php');

        set_config('generatedummyemail', 1, 'auth_oidc');

        $this->assertNull(auth_oidc_generate_dummy_email('CONTOSO\\jdoe', 'objectid-1'));
    }

    /**
     * When enabled and configured, a placeholder address should be generated from the UPN, sanitised and
     * lower-cased so it always forms a valid, predictable email local part.
     *
     * Regression test for https://github.com/microsoft/o365-moodle/issues/2839.
     *
     * @return void
     * @covers ::auth_oidc_generate_dummy_email
     */
    public function test_auth_oidc_generate_dummy_email_generates_address_from_upn(): void {
        $this->resetAfterTest(true);
        require_once(__DIR__ . '/../lib.php');

        set_config('generatedummyemail', 1, 'auth_oidc');
        set_config('dummyemaildomain', 'example.test', 'auth_oidc');

        $this->assertSame('contosojdoe@example.test', auth_oidc_generate_dummy_email('CONTOSO\\jdoe', 'objectid-1'));
    }

    /**
     * If no user principal name is available, the placeholder address should fall back to the Entra ID object
     * ID, so a user can still be provisioned even without any UPN.
     *
     * @return void
     * @covers ::auth_oidc_generate_dummy_email
     */
    public function test_auth_oidc_generate_dummy_email_falls_back_to_objectid(): void {
        $this->resetAfterTest(true);
        require_once(__DIR__ . '/../lib.php');

        set_config('generatedummyemail', 1, 'auth_oidc');
        set_config('dummyemaildomain', 'example.test', 'auth_oidc');

        $this->assertSame(
            '00000000-0000-0000-0000-000000000001@example.test',
            auth_oidc_generate_dummy_email(null, '00000000-0000-0000-0000-000000000001')
        );
    }

    /**
     * If neither a UPN nor an object ID is available, no placeholder address can be generated.
     *
     * @return void
     * @covers ::auth_oidc_generate_dummy_email
     */
    public function test_auth_oidc_generate_dummy_email_returns_null_without_any_identifier(): void {
        $this->resetAfterTest(true);
        require_once(__DIR__ . '/../lib.php');

        set_config('generatedummyemail', 1, 'auth_oidc');
        set_config('dummyemaildomain', 'example.test', 'auth_oidc');

        $this->assertNull(auth_oidc_generate_dummy_email(null, null));
    }
}
