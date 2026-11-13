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

/**
 * Tests for the system role sync from an ID token claim.
 *
 * @package auth_oidc
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc;

use advanced_testcase;
use auth_oidc\adminsetting\auth_oidc_admin_setting_rolesyncmapping;
use context_system;
use core\event\user_updated;

/**
 * Tests for the system role sync from an ID token claim.
 *
 * @covers \auth_oidc\rolesync
 */
final class rolesync_test extends advanced_testcase {
    /**
     * Test parsing of mapping text.
     */
    public function test_parse_mapping(): void {
        $this->resetAfterTest();

        $text = "# comment\n\nAdmins = manager, coursecreator\nbroken\nx=nosuchrole";
        [$mapping, $errors] = rolesync::parse_mapping($text);
        $this->assertSame(['Admins' => ['manager', 'coursecreator']], $mapping);
        $this->assertEquals([['format', 'broken'], ['role', 'nosuchrole']], $errors);

        // Roles that are not assignable in the system context are rejected.
        [, $errors] = rolesync::parse_mapping("x=student");
        $this->assertEquals([['role', 'student']], $errors);
        [, $errors] = rolesync::parse_mapping("x=guest");
        $this->assertEquals([['role', 'guest']], $errors);

        // A key validator can reject or normalise keys.
        [$mapping, $errors] = rolesync::parse_mapping("A=manager\nb=manager", function (string $key): ?string {
            return $key === 'A' ? 'a' : null;
        });
        $this->assertSame(['a' => ['manager']], $mapping);
        $this->assertEquals([['key', 'b']], $errors);
    }

    /**
     * Test that apply_roles only adds and removes assignments it owns.
     */
    public function test_apply_roles(): void {
        global $DB;
        $this->resetAfterTest();

        $user = $this->getDataGenerator()->create_user();
        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);
        $creatorid = (int) $DB->get_field('role', 'id', ['shortname' => 'coursecreator']);
        $context = context_system::instance();

        // A manual assignment must survive.
        role_assign($creatorid, $user->id, $context->id);

        [$added, $removed] = rolesync::apply_roles($user->id, [$managerid, $creatorid], true);
        $this->assertEqualsCanonicalizing([$managerid, $creatorid], $added);
        $this->assertEmpty($removed);

        // Idempotent.
        [$added, $removed] = rolesync::apply_roles($user->id, [$managerid, $creatorid], true);
        $this->assertEmpty($added);
        $this->assertEmpty($removed);

        // Without revoke nothing is removed.
        [, $removed] = rolesync::apply_roles($user->id, [], false);
        $this->assertEmpty($removed);

        // A different component or item ID does not touch this source's assignments.
        [, $removed] = rolesync::apply_roles($user->id, [], true, 'local_o365', 1);
        $this->assertEmpty($removed);

        [, $removed] = rolesync::apply_roles($user->id, [], true);
        $this->assertEqualsCanonicalizing([$managerid, $creatorid], $removed);
        $this->assertTrue($DB->record_exists('role_assignments', [
            'roleid' => $creatorid,
            'userid' => $user->id,
            'contextid' => $context->id,
            'component' => '',
        ]));
        $this->assertFalse($DB->record_exists('role_assignments', [
            'userid' => $user->id,
            'component' => rolesync::COMPONENT,
        ]));
    }

    /**
     * Test claim mapping parsing.
     */
    public function test_parse_claim_mapping(): void {
        $this->resetAfterTest();

        $text = "groups|Group-A = manager\nroles|Editor=coursecreator\nnoclaim=manager\n|x=manager";
        [$mapping, $errors] = rolesync::parse_claim_mapping($text);
        $this->assertSame(['groups|group-a' => ['manager'], 'roles|editor' => ['coursecreator']], $mapping);
        $this->assertEquals([['key', 'noclaim'], ['key', '|x']], $errors);
    }

    /**
     * Test claim based role sync from an ID token, using several claims.
     */
    public function test_sync_user_from_token(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('rolesync_claimmap', "groups|Group-A=manager\nroles|Editor=coursecreator", 'auth_oidc');
        set_config('rolesync_revoke', 1, 'auth_oidc');

        $user = $this->getDataGenerator()->create_user();
        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);
        $creatorid = (int) $DB->get_field('role', 'id', ['shortname' => 'coursecreator']);

        $token = new jwt();
        $token->set_claims(['groups' => ['group-a', 'unmapped'], 'roles' => 'other']);
        [$added] = rolesync::sync_user_from_token($user->id, $token);
        $this->assertSame([$managerid], $added);

        // A second claim adds its own roles; the first still matches.
        $token->set_claims(['groups' => ['group-a'], 'roles' => ['editor']]);
        [$added, $removed] = rolesync::sync_user_from_token($user->id, $token);
        $this->assertSame([$creatorid], $added);
        $this->assertEmpty($removed);

        // A value is only matched against the claim named in its mapping line.
        $token->set_claims(['groups' => ['editor'], 'roles' => ['group-a']]);
        [$added, $removed] = rolesync::sync_user_from_token($user->id, $token);
        $this->assertEmpty($added);
        $this->assertEqualsCanonicalizing([$managerid, $creatorid], $removed);

        // Group overage: roles are left untouched.
        $token->set_claims(['roles' => ['editor']]);
        rolesync::sync_user_from_token($user->id, $token);
        $token->set_claims(['_claim_names' => ['groups' => 'src1'], 'roles' => []]);
        $this->assertNull(rolesync::sync_user_from_token($user->id, $token));
        $this->assertTrue($DB->record_exists('role_assignments', ['roleid' => $creatorid, 'userid' => $user->id]));
    }

    /**
     * Test that the claim mapping is resolved to role IDs and invalid entries are dropped.
     */
    public function test_get_mapping(): void {
        global $DB;
        $this->resetAfterTest();

        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);
        $creatorid = (int) $DB->get_field('role', 'id', ['shortname' => 'coursecreator']);

        $this->assertSame([], rolesync::get_mapping());

        set_config(
            'rolesync_claimmap',
            "groups|A=manager,coursecreator\ngroups|a=manager\nroles|X|Y=coursecreator\ninvalid\ngroups|b=nosuchrole",
            'auth_oidc'
        );
        $mapping = rolesync::get_mapping();

        $this->assertEqualsCanonicalizing(['groups', 'roles'], array_keys($mapping));
        $this->assertEqualsCanonicalizing(['a'], array_keys($mapping['groups']));
        $this->assertEqualsCanonicalizing([$managerid, $creatorid], $mapping['groups']['a']);
        $this->assertSame(['x|y' => [$creatorid]], $mapping['roles']);
    }

    /**
     * Test conversion of claim values to a list of strings.
     */
    public function test_claim_value_to_list(): void {
        $this->assertSame(['a', 'b'], rolesync::claim_value_to_list(['a', '', ' b ', 'a', ['nested'], null]));
        $this->assertSame(['5'], rolesync::claim_value_to_list(5));
        $this->assertSame([], rolesync::claim_value_to_list(null));
        $this->assertSame([], rolesync::claim_value_to_list(''));
        $this->assertSame([], rolesync::claim_value_to_list(['', ' ']));

        // A scalar value is kept whole, even if it contains spaces or commas.
        $this->assertSame(['Human Resources'], rolesync::claim_value_to_list(' Human Resources '));
        $this->assertSame(['Smith, John'], rolesync::claim_value_to_list('Smith, John'));
        $this->assertSame(['a b', 'c,d'], rolesync::claim_value_to_list(['a b', 'c,d']));
    }

    /**
     * Test that a scalar claim must match a mapping value in full, never partially.
     */
    public function test_sync_user_from_token_scalar_claim_exact_match(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('rolesync_claimmap', "department|IT=manager\ndepartment|Human Resources=coursecreator", 'auth_oidc');
        set_config('rolesync_revoke', 1, 'auth_oidc');

        $user = $this->getDataGenerator()->create_user();
        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);
        $creatorid = (int) $DB->get_field('role', 'id', ['shortname' => 'coursecreator']);

        // Values that only contain a mapped value as a part do not match.
        foreach (['Not IT', 'IT Support', 'IT, Sales', 'Human', 'Resources', 'Human Resources Admin'] as $department) {
            $token = new jwt();
            $token->set_claims(['department' => $department]);
            [$added] = rolesync::sync_user_from_token($user->id, $token);
            $this->assertSame([], $added, $department);
        }
        $this->assertFalse($DB->record_exists('role_assignments', ['userid' => $user->id, 'component' => rolesync::COMPONENT]));

        // A full value matches, including one with a space, ignoring case.
        $token = new jwt();
        $token->set_claims(['department' => 'it']);
        [$added] = rolesync::sync_user_from_token($user->id, $token);
        $this->assertSame([$managerid], $added);

        $token = new jwt();
        $token->set_claims(['department' => 'human resources']);
        [$added, $removed] = rolesync::sync_user_from_token($user->id, $token);
        $this->assertSame([$creatorid], $added);
        $this->assertSame([$managerid], $removed);

        // Several values have to be sent as an array.
        $token = new jwt();
        $token->set_claims(['department' => ['IT', 'Human Resources']]);
        [$added] = rolesync::sync_user_from_token($user->id, $token);
        $this->assertSame([$managerid], $added);
    }

    /**
     * Test that claim values are matched case-insensitively for non-ASCII characters too.
     */
    public function test_sync_user_from_token_unicode_case(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('rolesync_claimmap', "roles|ÉDITEUR=manager\ndepartment|Ärzte=coursecreator", 'auth_oidc');
        set_config('rolesync_revoke', 1, 'auth_oidc');

        $this->assertSame(['roles|éditeur' => ['manager']], rolesync::parse_claim_mapping('roles|ÉDITEUR=manager')[0]);

        $user = $this->getDataGenerator()->create_user();
        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);
        $creatorid = (int) $DB->get_field('role', 'id', ['shortname' => 'coursecreator']);

        foreach (['éditeur', 'ÉDITEUR', 'Éditeur'] as $value) {
            $token = new jwt();
            $token->set_claims(['roles' => [$value], 'department' => 'ärzte']);
            [$added, $removed] = rolesync::sync_user_from_token($user->id, $token);
            $this->assertEmpty($removed, $value);
            $this->assertTrue($DB->record_exists('role_assignments', [
                'userid' => $user->id,
                'roleid' => $managerid,
                'component' => rolesync::COMPONENT,
            ]), $value);
            $this->assertTrue($DB->record_exists('role_assignments', [
                'userid' => $user->id,
                'roleid' => $creatorid,
                'component' => rolesync::COMPONENT,
            ]), $value);
        }
    }

    /**
     * Test that roles are never removed when removal is disabled.
     */
    public function test_sync_user_from_token_revoke_disabled(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('rolesync_claimmap', 'groups|a=manager', 'auth_oidc');
        set_config('rolesync_revoke', 0, 'auth_oidc');

        $user = $this->getDataGenerator()->create_user();
        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);

        $token = new jwt();
        $token->set_claims(['groups' => ['a']]);
        [$added] = rolesync::sync_user_from_token($user->id, $token);
        $this->assertSame([$managerid], $added);

        $token = new jwt();
        $token->set_claims(['groups' => []]);
        [$added, $removed] = rolesync::sync_user_from_token($user->id, $token);
        $this->assertEmpty($added);
        $this->assertEmpty($removed);
        $this->assertTrue($DB->record_exists('role_assignments', [
            'roleid' => $managerid,
            'userid' => $user->id,
            'component' => rolesync::COMPONENT,
        ]));
    }

    /**
     * Build an encoded, unsigned ID token for the given claims.
     *
     * @param array $claims The claims.
     * @return string
     */
    private function build_idtoken(array $claims): string {
        return base64_encode(json_encode(['alg' => 'none'])) . '.' . base64_encode(json_encode($claims)) . '.sig';
    }

    /**
     * Create an auth_oidc_token record for a user.
     *
     * @param int $userid The user ID.
     * @param string $idtoken The encoded ID token.
     * @return void
     */
    private function create_token_record(int $userid, string $idtoken): void {
        global $DB;

        $DB->insert_record('auth_oidc_token', (object) [
            'oidcuniqid' => 'uniq' . $userid,
            'username' => 'user' . $userid,
            'userid' => $userid,
            'oidcusername' => 'user' . $userid,
            'scope' => 'openid',
            'tokenresource' => 'resource',
            'authcode' => 'code',
            'token' => 'token',
            'expiry' => time() + 3600,
            'refreshtoken' => 'refresh',
            'idtoken' => $idtoken,
        ]);
    }

    /**
     * Test role sync from the ID token stored for a user, including that bad input never throws.
     */
    public function test_sync_user_from_stored_token(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('rolesync_claimmap', 'groups|a=manager', 'auth_oidc');
        set_config('rolesync_revoke', 1, 'auth_oidc');
        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);

        // A valid stored token grants the mapped role.
        $user = $this->getDataGenerator()->create_user();
        $this->create_token_record($user->id, $this->build_idtoken(['groups' => ['A']]));
        rolesync::sync_user_from_stored_token($user->id);
        $this->assertTrue($DB->record_exists('role_assignments', [
            'roleid' => $managerid,
            'userid' => $user->id,
            'component' => rolesync::COMPONENT,
        ]));

        // A user without a token record is ignored.
        $notoken = $this->getDataGenerator()->create_user();
        rolesync::sync_user_from_stored_token($notoken->id);
        $this->assertFalse($DB->record_exists('role_assignments', ['userid' => $notoken->id, 'component' => rolesync::COMPONENT]));

        // An unreadable token does not throw and leaves the roles untouched.
        $badtoken = $this->getDataGenerator()->create_user();
        $this->create_token_record($badtoken->id, 'garbage');
        rolesync::sync_user_from_stored_token($badtoken->id);
        $this->assertFalse($DB->record_exists('role_assignments', ['userid' => $badtoken->id, 'component' => rolesync::COMPONENT]));

        // The stored token changes, the role is removed.
        $DB->set_field('auth_oidc_token', 'idtoken', $this->build_idtoken(['groups' => ['other']]), ['userid' => $user->id]);
        rolesync::sync_user_from_stored_token($user->id);
        $this->assertFalse($DB->record_exists('role_assignments', ['userid' => $user->id, 'component' => rolesync::COMPONENT]));
    }

    /**
     * Test validation of the claim mapping setting.
     */
    public function test_setting_validate(): void {
        global $CFG;
        require_once($CFG->libdir . '/adminlib.php');

        $this->resetAfterTest();

        $setting = new auth_oidc_admin_setting_rolesyncmapping('auth_oidc/rolesync_claimmap', 'name', 'description');

        $this->assertTrue($setting->validate(''));
        $this->assertTrue($setting->validate("# comment\ngroups|a=manager\nroles|b=manager,coursecreator"));

        $result = $setting->validate('groups|a=nosuchrole');
        $this->assertIsString($result);
        $this->assertStringContainsString('nosuchrole', $result);

        $result = $setting->validate('noclaim=manager');
        $this->assertIsString($result);
        $this->assertStringContainsString('noclaim', $result);

        $result = $setting->validate('groups|a=student');
        $this->assertIsString($result);
        $this->assertStringContainsString('student', $result);
    }

    /**
     * Test that remove_user_roles only removes the roles assigned by role sync, and only when removal is enabled.
     */
    public function test_remove_user_roles(): void {
        global $DB;
        $this->resetAfterTest();

        $user = $this->getDataGenerator()->create_user();
        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);
        $creatorid = (int) $DB->get_field('role', 'id', ['shortname' => 'coursecreator']);
        $contextid = context_system::instance()->id;

        role_assign($creatorid, $user->id, $contextid);
        role_assign($managerid, $user->id, $contextid, 'local_o365', 1);
        rolesync::apply_roles($user->id, [$managerid], false);

        // Nothing is removed when removal is disabled.
        set_config('rolesync_revoke', 0, 'auth_oidc');
        $this->assertSame([], rolesync::remove_user_roles($user->id));
        $this->assertTrue($DB->record_exists('role_assignments', ['userid' => $user->id, 'component' => rolesync::COMPONENT]));

        set_config('rolesync_revoke', 1, 'auth_oidc');
        $this->assertSame([$managerid], rolesync::remove_user_roles($user->id));
        $this->assertFalse($DB->record_exists('role_assignments', ['userid' => $user->id, 'component' => rolesync::COMPONENT]));

        // Manual assignments and assignments from other components are untouched.
        $this->assertTrue($DB->record_exists('role_assignments', [
            'userid' => $user->id,
            'roleid' => $creatorid,
            'component' => '',
        ]));
        $this->assertTrue($DB->record_exists('role_assignments', ['userid' => $user->id, 'component' => 'local_o365']));
    }

    /**
     * Test that switching a user away from OIDC removes the roles assigned by role sync.
     */
    public function test_user_updated_observer(): void {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/user/lib.php');

        $this->resetAfterTest();

        set_config('rolesync_revoke', 1, 'auth_oidc');
        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);

        $user = $this->getDataGenerator()->create_user(['auth' => 'oidc']);
        rolesync::apply_roles($user->id, [$managerid], false);
        $event = user_updated::create_from_userid($user->id);

        // An update that keeps the user on OIDC leaves the roles alone.
        observers::handle_user_updated($event);
        $this->assertTrue($DB->record_exists('role_assignments', ['userid' => $user->id, 'component' => rolesync::COMPONENT]));

        // Switching to another authentication method removes them.
        user_update_user((object) ['id' => $user->id, 'auth' => 'manual'], false, false);
        observers::handle_user_updated($event);
        $this->assertFalse($DB->record_exists('role_assignments', ['userid' => $user->id, 'component' => rolesync::COMPONENT]));
    }
}
