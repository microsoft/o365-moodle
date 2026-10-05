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
     * Data provider for {@see self::test_validate_custom_claims()}.
     *
     * @return array
     */
    public static function validate_custom_claims_provider(): array {
        return [
            'empty string' => ['', []],
            'whitespace only' => ['   ', []],
            'single valid claim' => ['employee_type', []],
            'multiple valid claims' => ['employee_type badge_number costCenter custom_role', []],
            'valid directory extension attribute claim' => [
                'extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode',
                [],
            ],
            'single format-invalid claim' => ['bad claim!', ['claim!']],
            'reserved standard JWT/OIDC claim' => ['sub', ['sub']],
            'reserved standard OIDC claim' => ['email', ['email']],
            'reserved Microsoft Entra ID claim' => ['upn', ['upn']],
            'reserved Microsoft Entra ID claim is case-insensitive' => ['UPN', ['UPN']],
            'reserved Keycloak claim' => ['realm_access', ['realm_access']],
            'reserved binding username claim value' => ['samaccountname', ['samaccountname']],
            'reserved existing field mapping option' => ['department', ['department']],
            'mixed valid, format-invalid, and reserved claims' => [
                'employee_type sub bad claim! realm_access',
                ['sub', 'claim!', 'realm_access'],
            ],
        ];
    }

    /**
     * Test auth_oidc_validate_custom_claims().
     *
     * @dataProvider validate_custom_claims_provider
     * @param string $value
     * @param array $expected
     * @return void
     * @covers ::auth_oidc_validate_custom_claims
     * @covers ::auth_oidc_get_reserved_custom_claim_names
     */
    public function test_validate_custom_claims(string $value, array $expected): void {
        $this->resetAfterTest(true);

        require_once(__DIR__ . '/../lib.php');

        $this->assertSame($expected, auth_oidc_validate_custom_claims($value));
    }

    /**
     * Data provider for {@see self::test_get_validated_custom_claim_names()}.
     *
     * @return array
     */
    public static function get_validated_custom_claim_names_provider(): array {
        return [
            'not configured' => [null, [], []],
            'empty string' => ['', [], []],
            'whitespace only' => ['   ', [], []],
            'single valid claim' => ['employee_type', ['employee_type'], []],
            'multiple valid claims' => [
                'employee_type badge_number costCenter',
                ['employee_type', 'badge_number', 'costCenter'],
                [],
            ],
            'duplicate claims are deduplicated' => [
                'employee_type employee_type badge_number',
                ['employee_type', 'badge_number'],
                [],
            ],
            'format-invalid claims are silently skipped' => [
                'employee_type bad! badge_number',
                ['employee_type', 'badge_number'],
                ['Invalid custom claim name skipped: bad!'],
            ],
            'reserved claims are silently skipped' => [
                'employee_type sub badge_number UPN',
                ['employee_type', 'badge_number'],
                [
                    'Reserved custom claim name skipped: sub',
                    'Reserved custom claim name skipped: UPN',
                ],
            ],
            'mixed valid, duplicate, format-invalid, and reserved claims' => [
                'sub employee_type bad! employee_type realm_access badge_number',
                ['employee_type', 'badge_number'],
                [
                    'Reserved custom claim name skipped: sub',
                    'Invalid custom claim name skipped: bad!',
                    'Reserved custom claim name skipped: realm_access',
                ],
            ],
        ];
    }

    /**
     * Test auth_oidc_get_validated_custom_claim_names().
     *
     * @dataProvider get_validated_custom_claim_names_provider
     * @param string|null $configvalue
     * @param array $expected
     * @param array $expecteddebugging Expected debugging() messages, in call order; empty when
     *                                  every configured claim is valid and none should be skipped.
     * @return void
     * @covers ::auth_oidc_get_validated_custom_claim_names
     * @covers ::auth_oidc_get_reserved_custom_claim_names
     */
    public function test_get_validated_custom_claim_names(
        ?string $configvalue,
        array $expected,
        array $expecteddebugging
    ): void {
        $this->resetAfterTest(true);

        require_once(__DIR__ . '/../lib.php');

        if ($configvalue !== null) {
            set_config('customclaims', $configvalue, 'auth_oidc');
        }

        $this->assertSame($expected, auth_oidc_get_validated_custom_claim_names());

        // The function under test calls debugging() for each format-invalid or reserved claim it
        // silently skips; Moodle's test harness fails a test that triggers an unconsumed
        // debugging() call, so every expected one must be asserted explicitly.
        if (empty($expecteddebugging)) {
            $this->assertDebuggingNotCalled();
        } else {
            $this->assertDebuggingCalledCount(count($expecteddebugging), $expecteddebugging);
        }
    }

    /**
     * Data provider for {@see self::test_custom_claim_value_to_string()}.
     *
     * @return array
     */
    public static function custom_claim_value_to_string_provider(): array {
        return [
            'string' => ['Teacher', 'Teacher'],
            'integer' => [5, '5'],
            'null' => [null, null],
            'empty string' => ['', null],
            'list of values' => [['Teacher', 'Manager'], 'Teacher,Manager'],
            'list with empty and nested values' => [['Teacher', '', ['nested']], 'Teacher'],
            'empty list' => [[], null],
            'list of nested values only' => [[['nested']], null],
        ];
    }

    /**
     * Test auth_oidc_custom_claim_value_to_string().
     *
     * @dataProvider custom_claim_value_to_string_provider
     * @param mixed $value
     * @param string|null $expected
     * @return void
     * @covers ::auth_oidc_custom_claim_value_to_string
     */
    public function test_custom_claim_value_to_string($value, ?string $expected): void {
        $this->resetAfterTest(true);

        require_once(__DIR__ . '/../lib.php');

        $this->assertSame($expected, auth_oidc_custom_claim_value_to_string($value));
    }

    /**
     * Test the "roles" and "groups" custom claims are valid and exposed under a prefixed key, next to the built-in fields.
     *
     * @return void
     * @covers ::auth_oidc_process_custom_claims
     * @covers ::auth_oidc_validate_custom_claims
     */
    public function test_roles_and_groups_custom_claims_exposed_with_prefixed_key(): void {
        $this->resetAfterTest(true);

        require_once(__DIR__ . '/../lib.php');

        $this->assertSame([], auth_oidc_validate_custom_claims('roles groups employee_type'));

        set_config('customclaims', 'roles groups employee_type', 'auth_oidc');

        $remotefields = auth_oidc_process_custom_claims(['roles' => 'Roles', 'groups' => 'Groups', 'mail' => 'Email']);

        $this->assertSame('Roles', $remotefields['roles']);
        $this->assertSame('Groups', $remotefields['groups']);
        $this->assertSame('employee_type', $remotefields['employee_type']);
        $this->assertSame('roles (token claim)', $remotefields[auth_oidc_get_custom_claim_prefixed_key('roles')]);
        $this->assertSame('groups (token claim)', $remotefields[auth_oidc_get_custom_claim_prefixed_key('groups')]);
        $this->assertArrayNotHasKey(auth_oidc_get_custom_claim_prefixed_key('employee_type'), $remotefields);
    }
}
