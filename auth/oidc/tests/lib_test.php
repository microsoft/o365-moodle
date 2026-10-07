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

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/auth/oidc/lib.php');

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

    /**
     * Data provider for {@see self::test_determine_endpoint_version()}.
     *
     * @return array
     */
    public static function determine_endpoint_version_provider(): array {
        return [
            'global v1' => [
                'https://login.microsoftonline.com/contoso.com/oauth2/token',
                AUTH_OIDC_MICROSOFT_ENDPOINT_VERSION_1,
            ],
            'global v2' => [
                'https://login.microsoftonline.com/contoso.com/oauth2/v2.0/token',
                AUTH_OIDC_MICROSOFT_ENDPOINT_VERSION_2,
            ],
            'China v1' => [
                'https://login.partner.microsoftonline.cn/contoso.com/oauth2/authorize',
                AUTH_OIDC_MICROSOFT_ENDPOINT_VERSION_1,
            ],
            'China v2' => [
                'https://login.partner.microsoftonline.cn/contoso.com/oauth2/v2.0/authorize',
                AUTH_OIDC_MICROSOFT_ENDPOINT_VERSION_2,
            ],
            'China former host name v1' => [
                'https://login.chinacloudapi.cn/contoso.com/oauth2/token',
                AUTH_OIDC_MICROSOFT_ENDPOINT_VERSION_1,
            ],
            'China former host name v2' => [
                'https://login.chinacloudapi.cn/contoso.com/oauth2/v2.0/token',
                AUTH_OIDC_MICROSOFT_ENDPOINT_VERSION_2,
            ],
            'other host' => [
                'https://idp.example.com/contoso.com/oauth2/token',
                AUTH_OIDC_MICROSOFT_ENDPOINT_VERSION_UNKNOWN,
            ],
            'host only starting with a Microsoft host name' => [
                'https://login.microsoftonline.com.example.com/contoso.com/oauth2/token',
                AUTH_OIDC_MICROSOFT_ENDPOINT_VERSION_UNKNOWN,
            ],
            'Microsoft host without an OAuth 2.0 path' => [
                'https://login.microsoftonline.com/contoso.com/saml2',
                AUTH_OIDC_MICROSOFT_ENDPOINT_VERSION_UNKNOWN,
            ],
        ];
    }

    /**
     * Test auth_oidc_determine_endpoint_version().
     *
     * @dataProvider determine_endpoint_version_provider
     * @param string $endpoint
     * @param int $expected
     * @return void
     * @covers ::auth_oidc_determine_endpoint_version
     */
    public function test_determine_endpoint_version(string $endpoint, int $expected): void {
        $this->assertSame($expected, auth_oidc_determine_endpoint_version($endpoint));
    }

    /**
     * The Microsoft cloud endpoints follow the Microsoft cloud setting.
     *
     * @return void
     * @covers ::auth_oidc_use_chinese_api
     * @covers ::auth_oidc_get_login_baseurl
     * @covers ::auth_oidc_get_graph_resource
     */
    public function test_microsoft_cloud_endpoints(): void {
        $this->resetAfterTest(true);

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');

        $this->assertFalse(auth_oidc_use_chinese_api());
        $this->assertSame('https://login.microsoftonline.com', auth_oidc_get_login_baseurl());
        $this->assertSame('https://graph.microsoft.com', auth_oidc_get_graph_resource());

        set_config('microsoftcloud', AUTH_OIDC_MICROSOFT_CLOUD_GLOBAL, 'auth_oidc');
        $this->assertFalse(auth_oidc_use_chinese_api());
        $this->assertSame('https://login.microsoftonline.com', auth_oidc_get_login_baseurl());

        set_config('microsoftcloud', AUTH_OIDC_MICROSOFT_CLOUD_CHINA, 'auth_oidc');
        $this->assertTrue(auth_oidc_use_chinese_api());
        $this->assertSame('https://login.partner.microsoftonline.cn', auth_oidc_get_login_baseurl());
        $this->assertSame('https://microsoftgraph.chinacloudapi.cn', auth_oidc_get_graph_resource());

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');
        $this->assertTrue(auth_oidc_use_chinese_api());

        // The setting does not apply to other IdP types.
        set_config('idptype', AUTH_OIDC_IDP_TYPE_OTHER, 'auth_oidc');
        $this->assertFalse(auth_oidc_use_chinese_api());
        $this->assertSame('https://login.microsoftonline.com', auth_oidc_get_login_baseurl());
        $this->assertSame('https://graph.microsoft.com', auth_oidc_get_graph_resource());
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

    /**
     * Data provider for {@see self::test_fieldmap_applies_to_event()}.
     *
     * @return array
     */
    public static function fieldmap_applies_to_event_provider(): array {
        return [
            'always on create' => ['always', 'create', true],
            'always on login' => ['always', 'login', true],
            'always on usersync' => ['always', 'usersync', true],
            'oncreate on create' => ['oncreate', 'create', true],
            'oncreate on login' => ['oncreate', 'login', false],
            'oncreate on usersync' => ['oncreate', 'usersync', false],
            'onlogin on create' => ['onlogin', 'create', false],
            'onlogin on login' => ['onlogin', 'login', true],
            'onlogin on usersync' => ['onlogin', 'usersync', true],
            'oncreate_usersync on create' => ['oncreate_usersync', 'create', true],
            'oncreate_usersync on login' => ['oncreate_usersync', 'login', false],
            'oncreate_usersync on usersync' => ['oncreate_usersync', 'usersync', true],
            'unknown behaviour' => ['unknown', 'create', false],
            'unknown event' => ['always', 'unknown', false],
        ];
    }

    /**
     * Test auth_oidc_fieldmap_applies_to_event().
     *
     * @dataProvider fieldmap_applies_to_event_provider
     * @param string $behavior
     * @param string $eventtype
     * @param bool $expected
     * @return void
     * @covers ::auth_oidc_fieldmap_applies_to_event
     */
    public function test_fieldmap_applies_to_event(string $behavior, string $eventtype, bool $expected): void {
        require_once(__DIR__ . '/../lib.php');

        $this->assertSame($expected, auth_oidc_fieldmap_applies_to_event($behavior, $eventtype));
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
