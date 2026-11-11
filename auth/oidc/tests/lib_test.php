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
     * Data provider for test_is_external_id_endpoint().
     *
     * @return array
     */
    public static function is_external_id_endpoint_provider(): array {
        return [
            'authorization endpoint' => ['https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize', true],
            'token endpoint' => ['https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token', true],
            'workforce host' => ['https://login.microsoftonline.com/tenant-id/oauth2/v2.0/authorize', false],
            'multi-tenant path' => ['https://contoso.ciamlogin.com/common/oauth2/v2.0/token', false],
            'v1.0 style path' => ['https://contoso.ciamlogin.com/tenant-id/oauth2/authorize', false],
            'not https' => ['http://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token', false],
            'host in the path' => ['https://example.com/contoso.ciamlogin.com/oauth2/v2.0/token', false],
        ];
    }

    /**
     * Test auth_oidc_is_external_id_endpoint().
     *
     * @dataProvider is_external_id_endpoint_provider
     * @param string $endpoint
     * @param bool $expected
     * @return void
     * @covers ::auth_oidc_is_external_id_endpoint
     */
    public function test_is_external_id_endpoint(string $endpoint, bool $expected): void {
        $this->assertSame($expected, auth_oidc_is_external_id_endpoint($endpoint));
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

    /**
     * Data provider for test_validate_external_id_endpoint().
     *
     * @return array
     */
    public static function validate_external_id_endpoint_provider(): array {
        $tenanturl = 'https://contoso.ciamlogin.com/f3793e73-8410-4111-88c5-9785b9a32eb5/oauth2/v2.0/';

        return [
            'valid authorization endpoint' => [$tenanturl . 'authorize', 'authorize', null],
            'valid token endpoint' => [$tenanturl . 'token', 'token', null],
            'valid logout endpoint' => [$tenanturl . 'logout', 'logout', null],
            'valid endpoint with a tenant name' => [
                'https://contoso.ciamlogin.com/contoso.onmicrosoft.com/oauth2/v2.0/authorize',
                'authorize',
                null,
            ],
            'surrounding whitespace is ignored' => [' ' . $tenanturl . 'authorize ', 'authorize', null],
            'query string is ignored' => [$tenanturl . 'authorize?foo=bar', 'authorize', null],
            'placeholders of the default template' => [
                'https://<tenant-name>.ciamlogin.com/<tenant-id>/oauth2/v2.0/authorize',
                'authorize',
                'error_endpoint_external_id_placeholder',
            ],
            'placeholder in the tenant only' => [
                'https://contoso.ciamlogin.com/<tenant-id>/oauth2/v2.0/token',
                'token',
                'error_endpoint_external_id_placeholder',
            ],
            'workforce host' => [
                'https://login.microsoftonline.com/f3793e73-8410-4111-88c5-9785b9a32eb5/oauth2/v2.0/authorize',
                'authorize',
                'error_endpoint_external_id',
            ],
            'not https' => [
                'http://contoso.ciamlogin.com/f3793e73-8410-4111-88c5-9785b9a32eb5/oauth2/v2.0/authorize',
                'authorize',
                'error_endpoint_external_id',
            ],
            'not a URL' => ['not a url', 'authorize', 'error_endpoint_external_id'],
            'empty value' => ['', 'authorize', 'error_endpoint_external_id'],
            'common tenant' => [
                'https://contoso.ciamlogin.com/common/oauth2/v2.0/authorize',
                'authorize',
                'error_endpoint_external_id_tenant',
            ],
            'organizations tenant' => [
                'https://contoso.ciamlogin.com/organizations/oauth2/v2.0/token',
                'token',
                'error_endpoint_external_id_tenant',
            ],
            'consumers tenant' => [
                'https://contoso.ciamlogin.com/consumers/oauth2/v2.0/logout',
                'logout',
                'error_endpoint_external_id_tenant',
            ],
            'v1.0 authorization endpoint' => [
                'https://contoso.ciamlogin.com/f3793e73-8410-4111-88c5-9785b9a32eb5/oauth2/authorize',
                'authorize',
                'error_endpoint_external_id_v1',
            ],
            'v1.0 token endpoint' => [
                'https://contoso.ciamlogin.com/f3793e73-8410-4111-88c5-9785b9a32eb5/oauth2/token',
                'token',
                'error_endpoint_external_id_v1',
            ],
            'v1.0 logout endpoint' => [
                'https://contoso.ciamlogin.com/f3793e73-8410-4111-88c5-9785b9a32eb5/oauth2/logout',
                'logout',
                'error_endpoint_external_id_v1',
            ],
            'authorization endpoint used as token endpoint' => [
                $tenanturl . 'authorize',
                'token',
                'error_endpoint_external_id_kind',
            ],
            'token endpoint used as logout endpoint' => [
                $tenanturl . 'token',
                'logout',
                'error_endpoint_external_id_kind',
            ],
            'logout endpoint used as authorization endpoint' => [
                $tenanturl . 'logout',
                'authorize',
                'error_endpoint_external_id_kind',
            ],
            'v2.0 path without an endpoint' => [$tenanturl, 'authorize', 'error_endpoint_external_id_kind'],
        ];
    }

    /**
     * Test auth_oidc_validate_external_id_endpoint().
     *
     * @dataProvider validate_external_id_endpoint_provider
     * @param string $endpoint
     * @param string $kind
     * @param string|null $expectederrorstring The identifier of the expected error string, or null when the endpoint is valid.
     * @return void
     * @covers ::auth_oidc_validate_external_id_endpoint
     */
    public function test_validate_external_id_endpoint(string $endpoint, string $kind, ?string $expectederrorstring): void {
        $result = auth_oidc_validate_external_id_endpoint($endpoint, $kind);

        if ($expectederrorstring === null) {
            $this->assertNull($result);
        } else if ($expectederrorstring === 'error_endpoint_external_id_kind') {
            $this->assertSame(get_string($expectederrorstring, 'auth_oidc', $kind), $result);
        } else {
            $this->assertSame(get_string($expectederrorstring, 'auth_oidc'), $result);
        }
    }

    /**
     * Test auth_oidc_get_external_id_endpoint_error(), which returns the identifier of the error string and not the message.
     *
     * @dataProvider validate_external_id_endpoint_provider
     * @param string $endpoint
     * @param string $kind
     * @param string|null $expectederrorstring The identifier of the expected error string, or null when the endpoint is valid.
     * @return void
     * @covers ::auth_oidc_get_external_id_endpoint_error
     */
    public function test_get_external_id_endpoint_error(string $endpoint, string $kind, ?string $expectederrorstring): void {
        $this->assertSame($expectederrorstring, auth_oidc_get_external_id_endpoint_error($endpoint, $kind));
    }

    /**
     * Data provider for test_is_same_external_id_tenant().
     *
     * @return array
     */
    public static function is_same_external_id_tenant_provider(): array {
        return [
            'same tenant' => [
                'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize',
                'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token',
                true,
            ],
            'same tenant, different case' => [
                'https://Contoso.ciamlogin.com/Tenant-ID/oauth2/v2.0/authorize',
                'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token',
                true,
            ],
            'same tenant, whitespace' => [
                ' https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize ',
                'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token',
                true,
            ],
            'different tenant ID' => [
                'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize',
                'https://contoso.ciamlogin.com/other-tenant-id/oauth2/v2.0/token',
                false,
            ],
            'different host' => [
                'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize',
                'https://fabrikam.ciamlogin.com/tenant-id/oauth2/v2.0/token',
                false,
            ],
            'tenant name and tenant ID are different values' => [
                'https://contoso.ciamlogin.com/contoso.onmicrosoft.com/oauth2/v2.0/authorize',
                'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token',
                false,
            ],
        ];
    }

    /**
     * Test auth_oidc_is_same_external_id_tenant().
     *
     * @dataProvider is_same_external_id_tenant_provider
     * @param string $endpoint1
     * @param string $endpoint2
     * @param bool $expected
     * @return void
     * @covers ::auth_oidc_is_same_external_id_tenant
     */
    public function test_is_same_external_id_tenant(string $endpoint1, string $endpoint2, bool $expected): void {
        $this->assertSame($expected, auth_oidc_is_same_external_id_tenant($endpoint1, $endpoint2));
    }

    /**
     * Data provider for test_get_default_endpoints().
     *
     * @return array
     */
    public static function get_default_endpoints_provider(): array {
        return [
            'not connected' => [AUTH_OIDC_IDP_TYPE_NOT_CONNECTED, ['authorize' => '', 'token' => '']],
            'Microsoft Entra ID (v1.0)' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID,
                [
                    'authorize' => 'https://login.microsoftonline.com/organizations/oauth2/authorize',
                    'token' => 'https://login.microsoftonline.com/organizations/oauth2/token',
                ],
            ],
            'Microsoft identity platform (v2.0)' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM,
                [
                    'authorize' => 'https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize',
                    'token' => 'https://login.microsoftonline.com/organizations/oauth2/v2.0/token',
                ],
            ],
            'Microsoft Entra External ID' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID,
                [
                    'authorize' => 'https://<tenant-name>.ciamlogin.com/<tenant-id>/oauth2/v2.0/authorize',
                    'token' => 'https://<tenant-name>.ciamlogin.com/<tenant-id>/oauth2/v2.0/token',
                ],
            ],
            'other' => [AUTH_OIDC_IDP_TYPE_OTHER, ['authorize' => '', 'token' => '']],
        ];
    }

    /**
     * Test auth_oidc_get_default_endpoints().
     *
     * @dataProvider get_default_endpoints_provider
     * @param int $idptype
     * @param array $expected
     * @return void
     * @covers ::auth_oidc_get_default_endpoints
     */
    public function test_get_default_endpoints(int $idptype, array $expected): void {
        $this->assertSame($expected, auth_oidc_get_default_endpoints($idptype));
    }

    /**
     * The default endpoints of the External ID type are templates that fail the validation until the tenant is filled in.
     *
     * @return void
     * @covers ::auth_oidc_get_default_endpoints
     * @covers ::auth_oidc_validate_external_id_endpoint
     */
    public function test_external_id_default_endpoints_are_templates(): void {
        $defaults = auth_oidc_get_default_endpoints(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);

        $this->assertSame(
            get_string('error_endpoint_external_id_placeholder', 'auth_oidc'),
            auth_oidc_validate_external_id_endpoint($defaults['authorize'], 'authorize')
        );
        $this->assertSame(
            get_string('error_endpoint_external_id_placeholder', 'auth_oidc'),
            auth_oidc_validate_external_id_endpoint($defaults['token'], 'token')
        );
    }

    /**
     * Test auth_oidc_get_default_logout_endpoint() for the Microsoft Entra ID and Microsoft identity platform types.
     *
     * @return void
     * @covers ::auth_oidc_get_default_logout_endpoint
     */
    public function test_get_default_logout_endpoint_microsoft_types(): void {
        $this->resetAfterTest(true);

        foreach ([AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM] as $idptype) {
            set_config('idptype', $idptype, 'auth_oidc');

            set_config('microsoftcloud', AUTH_OIDC_MICROSOFT_CLOUD_GLOBAL, 'auth_oidc');
            $this->assertSame(
                'https://login.microsoftonline.com/organizations/oauth2/logout',
                auth_oidc_get_default_logout_endpoint($idptype)
            );

            set_config('microsoftcloud', AUTH_OIDC_MICROSOFT_CLOUD_CHINA, 'auth_oidc');
            $this->assertSame(
                'https://login.partner.microsoftonline.cn/organizations/oauth2/logout',
                auth_oidc_get_default_logout_endpoint($idptype)
            );
        }

        // The Microsoft cloud setting is ignored when no IdP type is saved yet, as it only applies to the Microsoft types.
        set_config('idptype', AUTH_OIDC_IDP_TYPE_NOT_CONNECTED, 'auth_oidc');
        $this->assertSame(
            'https://login.microsoftonline.com/organizations/oauth2/logout',
            auth_oidc_get_default_logout_endpoint(AUTH_OIDC_IDP_TYPE_NOT_CONNECTED)
        );
    }

    /**
     * Test auth_oidc_get_default_logout_endpoint() for the other IdP type.
     *
     * @return void
     * @covers ::auth_oidc_get_default_logout_endpoint
     */
    public function test_get_default_logout_endpoint_other(): void {
        $this->resetAfterTest(true);

        $this->assertSame('', auth_oidc_get_default_logout_endpoint(AUTH_OIDC_IDP_TYPE_OTHER));
    }

    /**
     * The Microsoft cloud that is passed is used for the default logout endpoint, instead of the saved one.
     *
     * @return void
     * @covers ::auth_oidc_get_default_logout_endpoint
     */
    public function test_get_default_logout_endpoint_uses_passed_microsoft_cloud(): void {
        $this->resetAfterTest(true);

        set_config('microsoftcloud', AUTH_OIDC_MICROSOFT_CLOUD_GLOBAL, 'auth_oidc');
        foreach ([AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM] as $idptype) {
            $this->assertSame(
                'https://login.partner.microsoftonline.cn/organizations/oauth2/logout',
                auth_oidc_get_default_logout_endpoint($idptype, null, AUTH_OIDC_MICROSOFT_CLOUD_CHINA)
            );
            $this->assertSame(
                'https://login.microsoftonline.com/organizations/oauth2/logout',
                auth_oidc_get_default_logout_endpoint($idptype, null, AUTH_OIDC_MICROSOFT_CLOUD_GLOBAL)
            );
        }
    }

    /**
     * Test auth_oidc_get_default_logout_endpoint() for the Microsoft Entra External ID type.
     *
     * @return void
     * @covers ::auth_oidc_get_default_logout_endpoint
     */
    public function test_get_default_logout_endpoint_external_id(): void {
        $this->resetAfterTest(true);

        $template = 'https://<tenant-name>.ciamlogin.com/<tenant-id>/oauth2/v2.0/logout';
        $type = AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID;

        // No authorization endpoint saved.
        $this->assertSame($template, auth_oidc_get_default_logout_endpoint($type));

        // An authorization endpoint that is not valid for External ID.
        set_config('authendpoint', 'https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize', 'auth_oidc');
        $this->assertSame($template, auth_oidc_get_default_logout_endpoint($type));

        set_config('authendpoint', 'https://<tenant-name>.ciamlogin.com/<tenant-id>/oauth2/v2.0/authorize', 'auth_oidc');
        $this->assertSame($template, auth_oidc_get_default_logout_endpoint($type));

        // A valid saved authorization endpoint.
        set_config('authendpoint', 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize', 'auth_oidc');
        $this->assertSame(
            'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/logout',
            auth_oidc_get_default_logout_endpoint($type)
        );

        // A valid saved authorization endpoint with a query string.
        set_config('authendpoint', 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize?foo=bar', 'auth_oidc');
        $this->assertSame(
            'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/logout?foo=bar',
            auth_oidc_get_default_logout_endpoint($type)
        );

        // The authorization endpoint that is passed takes priority over the saved one.
        set_config('authendpoint', 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize', 'auth_oidc');
        $this->assertSame(
            'https://fabrikam.ciamlogin.com/other-id/oauth2/v2.0/logout',
            auth_oidc_get_default_logout_endpoint($type, 'https://fabrikam.ciamlogin.com/other-id/oauth2/v2.0/authorize')
        );

        // A passed authorization endpoint that is not valid is not replaced by the saved one.
        $this->assertSame($template, auth_oidc_get_default_logout_endpoint($type, ''));
        $this->assertSame($template, auth_oidc_get_default_logout_endpoint($type, 'https://example.com/authorize'));
    }

    /**
     * Set the saved IdP type, Microsoft cloud and logout endpoint for the logout endpoint conversion tests.
     *
     * @param int $idptype The IdP type that is saved, which is the new type when the conversion runs.
     * @param string|null $logouturi The saved logout endpoint, or null to leave it unset.
     * @param int $cloud The Microsoft cloud.
     * @return void
     */
    private function prepare_logout_endpoint_conversion(
        int $idptype,
        ?string $logouturi,
        int $cloud = AUTH_OIDC_MICROSOFT_CLOUD_GLOBAL
    ): void {
        set_config('idptype', $idptype, 'auth_oidc');
        set_config('microsoftcloud', $cloud, 'auth_oidc');
        if ($logouturi === null) {
            unset_config('logouturi', 'auth_oidc');
        } else {
            set_config('logouturi', $logouturi, 'auth_oidc');
        }
    }

    /**
     * Data provider for test_convert_logout_endpoint().
     *
     * Each case has the previous and the new IdP type, the saved logout endpoint, the authorization endpoint that is passed
     * to the function, and the logout endpoint that is expected afterwards.
     *
     * @return array
     */
    public static function convert_logout_endpoint_provider(): array {
        $notconnected = AUTH_OIDC_IDP_TYPE_NOT_CONNECTED;
        $v1 = AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID;
        $v2 = AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM;
        $other = AUTH_OIDC_IDP_TYPE_OTHER;
        $external = AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID;

        $workforce = 'https://login.microsoftonline.com/organizations/oauth2/logout';
        $workforcetenant = 'https://login.microsoftonline.com/tenant-id/oauth2/logout';
        $china = 'https://login.partner.microsoftonline.cn/organizations/oauth2/logout';
        $chinacloudapi = 'https://login.chinacloudapi.cn/organizations/oauth2/logout';
        $externallogout = 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/logout';
        $externalauthorize = 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize';
        $custom = 'https://idp.example.com/logout';

        return [
            // Nothing changes.
            'same type' => [$v1, $v1, $custom, null, $custom],
            'same External ID type' => [$external, $external, $workforce, $externalauthorize, $workforce],
            'new type not connected' => [$v1, $notconnected, $workforce, null, $workforce],

            // From not connected or other: the default of the new type replaces whatever was saved.
            'not connected to v1' => [$notconnected, $v1, '', null, $workforce],
            'not connected to v2' => [$notconnected, $v2, '', null, $workforce],
            'not connected to other' => [$notconnected, $other, $workforce, null, ''],
            'not connected to External ID' => [$notconnected, $external, '', $externalauthorize, $externallogout],
            'other to v1 replaces a custom value' => [$other, $v1, $custom, null, $workforce],
            'other to v2' => [$other, $v2, '', null, $workforce],
            'other to External ID' => [$other, $external, $custom, $externalauthorize, $externallogout],

            // The template with placeholders is never saved.
            'not connected to External ID without a valid authorization endpoint' => [$notconnected, $external, '', null, ''],
            'other to External ID with a placeholder authorization endpoint' => [
                $other,
                $external,
                $custom,
                'https://<tenant-name>.ciamlogin.com/<tenant-id>/oauth2/v2.0/authorize',
                '',
            ],

            // Between the Microsoft Entra ID and Microsoft identity platform types the logout endpoint is the same.
            'v1 to v2' => [$v1, $v2, $workforce, null, $workforce],
            'v2 to v1' => [$v2, $v1, $custom, null, $custom],

            // To the other type: Microsoft endpoints are removed, custom values are kept.
            'v1 to other, workforce endpoint' => [$v1, $other, $workforce, null, ''],
            'v1 to other, tenant specific workforce endpoint' => [$v1, $other, $workforcetenant, null, ''],
            'v2 to other, China endpoint' => [$v2, $other, $china, null, ''],
            'v2 to other, chinacloudapi endpoint' => [$v2, $other, $chinacloudapi, null, ''],
            'External ID to other, External ID endpoint' => [$external, $other, $externallogout, null, ''],
            'v1 to other, custom value' => [$v1, $other, $custom, null, $custom],
            'External ID to other, custom value' => [$external, $other, $custom, null, $custom],

            // To External ID: standard workforce endpoints are replaced, custom values are kept.
            'v1 to External ID' => [$v1, $external, $workforce, $externalauthorize, $externallogout],
            'v2 to External ID, tenant specific workforce endpoint' => [
                $v2,
                $external,
                $workforcetenant,
                $externalauthorize,
                $externallogout,
            ],
            'v2 to External ID, China endpoint' => [$v2, $external, $china, $externalauthorize, $externallogout],
            'v1 to External ID, chinacloudapi endpoint' => [$v1, $external, $chinacloudapi, $externalauthorize, $externallogout],
            'v1 to External ID, custom value' => [$v1, $external, $custom, $externalauthorize, $custom],
            'v1 to External ID, v2.0 style workforce endpoint is not standard' => [
                $v1,
                $external,
                'https://login.microsoftonline.com/organizations/oauth2/v2.0/logout',
                $externalauthorize,
                'https://login.microsoftonline.com/organizations/oauth2/v2.0/logout',
            ],
            'v1 to External ID without a valid authorization endpoint' => [$v1, $external, $workforce, null, ''],

            // From External ID: standard External ID endpoints are replaced by the default of the new type.
            'External ID to v1' => [$external, $v1, $externallogout, null, $workforce],
            'External ID to v2' => [$external, $v2, $externallogout, null, $workforce],
            'External ID to v1, custom value' => [$external, $v1, $custom, null, $custom],
            'External ID to v1, workforce value is not standard External ID' => [$external, $v1, $china, null, $china],
        ];
    }

    /**
     * Test auth_oidc_convert_logout_endpoint().
     *
     * @dataProvider convert_logout_endpoint_provider
     * @param int $previous
     * @param int $next
     * @param string $saved The saved logout endpoint.
     * @param string|null $authendpoint The authorization endpoint passed to the function.
     * @param string $expected The logout endpoint expected after the conversion.
     * @return void
     * @covers ::auth_oidc_convert_logout_endpoint
     */
    public function test_convert_logout_endpoint(
        int $previous,
        int $next,
        string $saved,
        ?string $authendpoint,
        string $expected
    ): void {
        $this->resetAfterTest(true);

        $this->prepare_logout_endpoint_conversion($next, $saved);
        auth_oidc_convert_logout_endpoint($previous, $next, $authendpoint);

        $this->assertSame($expected, get_config('auth_oidc', 'logouturi'));
    }

    /**
     * The conversion uses the Microsoft cloud for the default of the Microsoft types.
     *
     * @return void
     * @covers ::auth_oidc_convert_logout_endpoint
     */
    public function test_convert_logout_endpoint_uses_microsoft_cloud(): void {
        $this->resetAfterTest(true);

        $this->prepare_logout_endpoint_conversion(
            AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID,
            '',
            AUTH_OIDC_MICROSOFT_CLOUD_CHINA
        );
        auth_oidc_convert_logout_endpoint(AUTH_OIDC_IDP_TYPE_NOT_CONNECTED, AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID);

        $this->assertSame(
            'https://login.partner.microsoftonline.cn/organizations/oauth2/logout',
            get_config('auth_oidc', 'logouturi')
        );
    }

    /**
     * The conversion derives the External ID logout endpoint from the saved authorization endpoint by default.
     *
     * @return void
     * @covers ::auth_oidc_convert_logout_endpoint
     */
    public function test_convert_logout_endpoint_uses_saved_authorization_endpoint(): void {
        $this->resetAfterTest(true);

        set_config('authendpoint', 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize', 'auth_oidc');
        $this->prepare_logout_endpoint_conversion(
            AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID,
            'https://login.microsoftonline.com/organizations/oauth2/logout'
        );
        auth_oidc_convert_logout_endpoint(
            AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM,
            AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID
        );

        $this->assertSame('https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/logout', get_config('auth_oidc', 'logouturi'));
    }

    /**
     * A logout endpoint that was never saved is left unset, so that the default of the IdP type applies.
     *
     * @return void
     * @covers ::auth_oidc_convert_logout_endpoint
     */
    public function test_convert_logout_endpoint_leaves_unset_endpoint_unset(): void {
        $this->resetAfterTest(true);

        $this->prepare_logout_endpoint_conversion(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, null);
        auth_oidc_convert_logout_endpoint(AUTH_OIDC_IDP_TYPE_NOT_CONNECTED, AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID);

        $this->assertFalse(get_config('auth_oidc', 'logouturi'));
    }

    /**
     * A change of the logout endpoint is written to the config log, and nothing is logged when it is not changed.
     *
     * @return void
     * @covers ::auth_oidc_convert_logout_endpoint
     */
    public function test_convert_logout_endpoint_writes_config_log(): void {
        global $DB;

        $this->resetAfterTest(true);
        $this->setAdminUser();

        $workforce = 'https://login.microsoftonline.com/organizations/oauth2/logout';
        $conditions = ['plugin' => 'auth_oidc', 'name' => 'logouturi'];

        // Log entries that may exist already, for example from the installation of the default settings.
        $existing = $DB->count_records('config_log', $conditions);

        // A custom value is kept, and nothing is logged.
        $this->prepare_logout_endpoint_conversion(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'https://idp.example.com/logout');
        auth_oidc_convert_logout_endpoint(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);
        $this->assertSame($existing, $DB->count_records('config_log', $conditions));

        // A converted value is logged with the old and the new value.
        $this->prepare_logout_endpoint_conversion(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, $workforce);
        auth_oidc_convert_logout_endpoint(
            AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID,
            AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID,
            'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize'
        );

        $this->assertSame($existing + 1, $DB->count_records('config_log', $conditions));
        $logs = $DB->get_records('config_log', $conditions, 'id DESC', '*', 0, 1);
        $log = reset($logs);
        $this->assertSame($workforce, $log->oldvalue);
        $this->assertSame('https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/logout', $log->value);
    }

    /**
     * Data provider for test_idp_type_helpers().
     *
     * @return array
     */
    public static function idp_type_helpers_provider(): array {
        return [
            'not connected' => [AUTH_OIDC_IDP_TYPE_NOT_CONNECTED, false, false, 'idp_type_not_connected'],
            'Microsoft Entra ID (v1.0)' => [AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, false, false, 'idp_type_microsoft_entra_id'],
            'Microsoft identity platform (v2.0)' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM,
                false,
                true,
                'idp_type_microsoft_identity_platform',
            ],
            'Microsoft Entra External ID' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID,
                true,
                true,
                'idp_type_microsoft_entra_external_id',
            ],
            'other' => [AUTH_OIDC_IDP_TYPE_OTHER, false, false, 'idp_type_other'],
        ];
    }

    /**
     * Test auth_oidc_is_entra_external_id(), auth_oidc_uses_v2_endpoints() and auth_oidc_get_idp_type_name().
     *
     * @dataProvider idp_type_helpers_provider
     * @param int $idptype
     * @param bool $isexternalid
     * @param bool $usesv2
     * @param string $namestring The identifier of the string with the name of the IdP type.
     * @return void
     * @covers ::auth_oidc_is_entra_external_id
     * @covers ::auth_oidc_uses_v2_endpoints
     * @covers ::auth_oidc_get_idp_type_name
     */
    public function test_idp_type_helpers(int $idptype, bool $isexternalid, bool $usesv2, string $namestring): void {
        $this->resetAfterTest(true);

        set_config('idptype', $idptype, 'auth_oidc');

        $this->assertSame($isexternalid, auth_oidc_is_entra_external_id());
        $this->assertSame($usesv2, auth_oidc_uses_v2_endpoints());
        $this->assertSame(get_string($namestring, 'auth_oidc'), auth_oidc_get_idp_type_name());
    }

    /**
     * The IdP type helpers are false while no IdP type is saved.
     *
     * @return void
     * @covers ::auth_oidc_is_entra_external_id
     * @covers ::auth_oidc_uses_v2_endpoints
     */
    public function test_idp_type_helpers_without_saved_type(): void {
        $this->resetAfterTest(true);

        unset_config('idptype', 'auth_oidc');

        $this->assertFalse(auth_oidc_is_entra_external_id());
        $this->assertFalse(auth_oidc_uses_v2_endpoints());
    }

    /**
     * An unknown IdP type has no name.
     *
     * @return void
     * @covers ::auth_oidc_get_idp_type_name
     */
    public function test_get_idp_type_name_unknown_type(): void {
        $this->resetAfterTest(true);

        set_config('idptype', 99, 'auth_oidc');

        $this->assertSame('', auth_oidc_get_idp_type_name());
    }

    /**
     * Only the fields that come from the token claims are offered for Microsoft Entra External ID.
     *
     * @return void
     * @covers ::auth_oidc_get_remote_fields
     */
    public function test_get_remote_fields_external_id(): void {
        $this->resetAfterTest(true);

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');

        $remotefields = auth_oidc_get_remote_fields();

        $this->assertSame(
            ['', 'bindingusernameclaim', 'objectId', 'userPrincipalName', 'givenName', 'surname', 'mail'],
            array_keys($remotefields)
        );
        $this->assertArrayNotHasKey('displayName', $remotefields);
        $this->assertArrayNotHasKey('extensionAttribute1', $remotefields);
        $this->assertArrayNotHasKey('manager', $remotefields);
    }

    /**
     * Custom claims are added to the fields of Microsoft Entra External ID.
     *
     * @return void
     * @covers ::auth_oidc_get_remote_fields
     */
    public function test_get_remote_fields_external_id_includes_custom_claims(): void {
        $this->resetAfterTest(true);

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');
        set_config('customclaims', 'employee_type', 'auth_oidc');

        $remotefields = auth_oidc_get_remote_fields();

        $this->assertArrayHasKey('employee_type', $remotefields);
        $this->assertArrayNotHasKey('displayName', $remotefields);
    }

    /**
     * The Microsoft Graph fields are still offered for the Microsoft workforce types when local_o365 is installed.
     *
     * @return void
     * @covers ::auth_oidc_get_remote_fields
     */
    public function test_get_remote_fields_workforce_types_include_graph_fields(): void {
        $this->resetAfterTest(true);

        if (!auth_oidc_is_local_365_installed()) {
            $this->markTestSkipped('local_o365 is not installed.');
        }

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');

        $remotefields = auth_oidc_get_remote_fields();

        $this->assertArrayHasKey('displayName', $remotefields);
        $this->assertArrayHasKey('extensionAttribute1', $remotefields);
        $this->assertArrayHasKey('manager', $remotefields);
    }

    /**
     * Return the messages of the notifications that were queued, and clear the queue.
     *
     * @return string[]
     */
    private function fetch_notification_messages(): array {
        return array_map(
            static fn($notification) => $notification->get_message(),
            \core\notification::fetch()
        );
    }

    /**
     * A valid Microsoft Entra External ID configuration does not produce any validation message.
     *
     * @return void
     * @covers ::auth_oidc_validate_auth_settings
     */
    public function test_validate_auth_settings_external_id_with_secret(): void {
        $this->resetAfterTest(true);

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');
        set_config('clientauthmethod', AUTH_OIDC_AUTH_METHOD_SECRET, 'auth_oidc');
        set_config('clientsecret', 'secret', 'auth_oidc');
        $this->fetch_notification_messages();

        auth_oidc_validate_auth_settings('auth_oidc/clientsecret');

        $this->assertSame([], $this->fetch_notification_messages());
    }

    /**
     * A Microsoft Entra External ID configuration with the secret authentication method requires a client secret.
     *
     * @return void
     * @covers ::auth_oidc_validate_auth_settings
     */
    public function test_validate_auth_settings_external_id_without_secret(): void {
        $this->resetAfterTest(true);

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');
        set_config('clientauthmethod', AUTH_OIDC_AUTH_METHOD_SECRET, 'auth_oidc');
        set_config('clientsecret', '', 'auth_oidc');
        $this->fetch_notification_messages();

        auth_oidc_validate_auth_settings('auth_oidc/clientsecret');

        $messages = $this->fetch_notification_messages();
        $this->assertCount(1, $messages);
        $this->assertStringContainsString(get_string('error_empty_client_secret', 'auth_oidc'), $messages[0]);
        $this->assertStringNotContainsString(get_string('error_invalid_client_authentication_method', 'auth_oidc'), $messages[0]);
    }

    /**
     * Microsoft Entra External ID only supports the secret authentication method.
     *
     * @return void
     * @covers ::auth_oidc_validate_auth_settings
     */
    public function test_validate_auth_settings_external_id_rejects_certificate(): void {
        $this->resetAfterTest(true);

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');
        set_config('clientauthmethod', AUTH_OIDC_AUTH_METHOD_CERTIFICATE, 'auth_oidc');
        set_config('clientcertsource', AUTH_OIDC_AUTH_CERT_SOURCE_TEXT, 'auth_oidc');
        set_config('clientprivatekey', 'key', 'auth_oidc');
        set_config('clientcert', 'certificate', 'auth_oidc');
        $this->fetch_notification_messages();

        auth_oidc_validate_auth_settings('auth_oidc/clientauthmethod');

        $messages = $this->fetch_notification_messages();
        $this->assertCount(1, $messages);
        $this->assertStringContainsString(get_string('error_invalid_client_authentication_method', 'auth_oidc'), $messages[0]);
    }

    /**
     * The submitted values are validated instead of the saved ones.
     *
     * @return void
     * @covers ::auth_oidc_get_submitted_or_saved_config
     */
    public function test_get_submitted_or_saved_config(): void {
        $this->resetAfterTest(true);

        set_config('idptype', AUTH_OIDC_IDP_TYPE_OTHER, 'auth_oidc');

        $this->assertEquals(AUTH_OIDC_IDP_TYPE_OTHER, auth_oidc_get_submitted_or_saved_config('idptype'));
        $this->assertFalse(auth_oidc_get_submitted_or_saved_config('doesnotexist'));

        $_POST['s_auth_oidc_idptype'] = (string) AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID;
        try {
            $this->assertEquals(
                AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID,
                auth_oidc_get_submitted_or_saved_config('idptype')
            );
        } finally {
            unset($_POST['s_auth_oidc_idptype']);
        }
    }
}
