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
 * Tests for the system role sync feature.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365;

use advanced_testcase;
use context_system;
use local_o365\adminsetting\rolesyncmapping;
use local_o365\feature\rolesync\main;
use local_o365\rest\unified;

/**
 * Tests for the system role sync feature.
 *
 * @covers \local_o365\feature\rolesync\main
 */
final class rolesync_test extends advanced_testcase {
    /** @var string Group object ID used in the tests. */
    private const GROUP1 = '11111111-1111-4111-8111-111111111111';

    /** @var string Group object ID used in the tests. */
    private const GROUP2 = '22222222-2222-4222-8222-222222222222';

    /** @var string Microsoft user object ID used in the tests. */
    private const USER1 = 'aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaa1';

    /** @var string Microsoft user object ID used in the tests. */
    private const USER2 = 'aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaa2';

    /** @var string Microsoft user object ID used in the tests. */
    private const USER3 = 'aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaa3';

    /** @var string Microsoft user object ID used in the tests. */
    private const USER4 = 'aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaa4';

    /** @var string Microsoft user object ID that has an object mapping, but no Microsoft 365 connection. */
    private const USER5 = 'aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaa5';

    /** @var string Microsoft user object ID that has no Moodle user. */
    private const UNLINKED = 'aaaaaaaa-aaaa-4aaa-8aaa-aaaaaaaaaaa9';

    /**
     * Test parsing of group mapping text.
     */
    public function test_parse_mapping(): void {
        $this->resetAfterTest();

        $groupid = '550E8400-e29b-41d4-a716-446655440000';
        $text = "# comment\n\n$groupid = manager, coursecreator\nnotaguid=manager\n$groupid=nosuchrole\nbroken";
        [$mapping, $errors] = main::parse_mapping($text);

        $this->assertSame(['550e8400-e29b-41d4-a716-446655440000' => ['manager', 'coursecreator']], $mapping);
        $this->assertEquals([['group', 'notaguid'], ['role', 'nosuchrole'], ['format', 'broken']], $errors);

        // Roles that are not assignable in the system context are rejected.
        [, $errors] = main::parse_mapping("$groupid=student");
        $this->assertEquals([['role', 'student']], $errors);
    }

    /**
     * Test that apply_roles only adds and removes assignments owned by the group role sync.
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

        [$added, $removed] = main::apply_roles($user->id, [$managerid, $creatorid], true);
        $this->assertEqualsCanonicalizing([$managerid, $creatorid], $added);
        $this->assertEmpty($removed);

        // Idempotent.
        [$added, $removed] = main::apply_roles($user->id, [$managerid, $creatorid], true);
        $this->assertEmpty($added);
        $this->assertEmpty($removed);

        // Without revoke nothing is removed.
        [, $removed] = main::apply_roles($user->id, [], false);
        $this->assertEmpty($removed);

        [, $removed] = main::apply_roles($user->id, [], true);
        $this->assertEqualsCanonicalizing([$managerid, $creatorid], $removed);
        $this->assertTrue($DB->record_exists('role_assignments', [
            'roleid' => $creatorid,
            'userid' => $user->id,
            'contextid' => $context->id,
            'component' => '',
        ]));
        $this->assertFalse($DB->record_exists('role_assignments', [
            'userid' => $user->id,
            'component' => main::COMPONENT,
        ]));
    }

    /**
     * Test that the group mapping is resolved to role IDs and invalid entries are dropped.
     */
    public function test_get_mapping(): void {
        global $DB;
        $this->resetAfterTest();

        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);
        $creatorid = (int) $DB->get_field('role', 'id', ['shortname' => 'coursecreator']);

        $this->assertSame([], main::get_mapping());

        $group1 = self::GROUP1;
        $group2 = self::GROUP2;
        set_config(
            'rolesync_groupmap',
            strtoupper($group1) . "=manager\nnotaguid=manager\n{$group2}=nosuchrole\n{$group2}=manager,coursecreator",
            'local_o365'
        );
        $mapping = main::get_mapping();

        $this->assertEqualsCanonicalizing([$group1, $group2], array_keys($mapping));
        $this->assertSame([$managerid], $mapping[$group1]);
        $this->assertEqualsCanonicalizing([$managerid, $creatorid], $mapping[$group2]);
    }

    /**
     * Test validation of the group mapping setting.
     */
    public function test_setting_validate(): void {
        global $CFG;
        require_once($CFG->libdir . '/adminlib.php');

        $this->resetAfterTest();

        $setting = new rolesyncmapping('local_o365/rolesync_groupmap', 'name', 'description');

        $this->assertTrue($setting->validate(''));
        $this->assertTrue($setting->validate("# comment\n" . self::GROUP1 . "=manager,coursecreator"));

        $result = $setting->validate('notaguid=manager');
        $this->assertIsString($result);
        $this->assertStringContainsString('notaguid', $result);

        $result = $setting->validate(self::GROUP1 . '=nosuchrole');
        $this->assertIsString($result);
        $this->assertStringContainsString('nosuchrole', $result);

        $result = $setting->validate('broken');
        $this->assertIsString($result);
        $this->assertStringContainsString('broken', $result);
    }

    /**
     * Create a Moodle user with an object mapping to a Microsoft user object ID, but no Microsoft 365 connection.
     *
     * This is the state of a provisioned user who has not logged in yet.
     *
     * @param string $oid The Microsoft user object ID.
     * @return int The Moodle user ID.
     */
    private function create_mapped_user(string $oid): int {
        global $DB;

        $user = $this->getDataGenerator()->create_user();
        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'subtype' => '',
            'objectid' => $oid,
            'o365name' => $user->username . '@example.com',
            'moodleid' => $user->id,
            'tenant' => '',
            'metadata' => '',
            'timecreated' => time(),
            'timemodified' => time(),
        ]);

        return (int) $user->id;
    }

    /**
     * Create a Moodle user connected to Microsoft 365: an object mapping and a Graph resource OIDC token.
     *
     * @param string $oid The Microsoft user object ID.
     * @return int The Moodle user ID.
     */
    private function create_connected_user(string $oid): int {
        global $DB;

        $userid = $this->create_mapped_user($oid);
        $DB->insert_record('auth_oidc_token', (object) [
            'oidcuniqid' => $oid,
            'username' => 'user' . $userid,
            'userid' => $userid,
            'oidcusername' => 'user' . $userid . '@example.com',
            'scope' => 'openid',
            'tokenresource' => unified::get_tokenresource(),
            'authcode' => 'code',
            'token' => 'token',
            'expiry' => time() + 3600,
            'refreshtoken' => 'refresh',
            'idtoken' => 'idtoken',
        ]);

        return $userid;
    }

    /**
     * Build a mock Graph client that returns the given group members and owners.
     *
     * @param array $groups Group object ID => ['members' => [oids], 'owners' => [oids], 'fail' => bool].
     * @return unified
     */
    private function create_graph_mock(array $groups): unified {
        $graph = $this->createMock(unified::class);
        $graph->method('get_group')->willReturnCallback(function (string $groupoid): array {
            return ['id' => $groupoid, 'displayName' => 'Group ' . $groupoid];
        });
        $graph->method('get_transitive_group_members')->willReturnCallback(function (string $groupoid) use ($groups): array {
            if (!empty($groups[$groupoid]['fail'])) {
                throw new \moodle_exception('generalexceptionmessage', 'error', '', 'Graph failure');
            }

            return array_map(function (string $oid): array {
                return ['id' => $oid];
            }, $groups[$groupoid]['members'] ?? []);
        });
        $graph->method('get_group_owners')->willReturnCallback(function (string $groupoid) use ($groups): array {
            return array_map(function (string $oid): array {
                return ['id' => $oid, '@odata.type' => '#microsoft.graph.user'];
            }, $groups[$groupoid]['owners'] ?? []);
        });

        return $graph;
    }

    /**
     * Check whether a user holds a system role through the group role sync.
     *
     * @param int $userid The user ID.
     * @param string $shortname The role short name.
     * @param string $component The component the assignment is recorded with.
     * @return bool
     */
    private function has_role(int $userid, string $shortname, string $component = main::COMPONENT): bool {
        global $DB;

        return $DB->record_exists('role_assignments', [
            'roleid' => $DB->get_field('role', 'id', ['shortname' => $shortname]),
            'userid' => $userid,
            'contextid' => context_system::instance()->id,
            'component' => $component,
        ]);
    }

    /**
     * Test that owners and members, including nested members, get the roles of every mapped group.
     */
    public function test_sync_groups_assigns_owners_and_members(): void {
        $this->resetAfterTest();

        set_config('rolesync_groupmap', self::GROUP1 . "=manager\n" . self::GROUP2 . '=coursecreator', 'local_o365');
        set_config('rolesync_revoke', 1, 'local_o365');

        $user1 = $this->create_connected_user(self::USER1);
        $user2 = $this->create_connected_user(self::USER2);
        $user3 = $this->create_connected_user(self::USER3);
        $user4 = $this->create_connected_user(self::USER4);
        // User 5 is mapped to a Microsoft user, but has no Microsoft 365 connection yet, so must be skipped.
        $user5 = $this->create_mapped_user(self::USER5);

        $graph = $this->create_graph_mock([
            // User 1 is a member of both groups, user 2 a member and user 3 an owner of the first. The member ID is in
            // upper case, and one member has no Moodle user.
            self::GROUP1 => [
                'members' => [strtoupper(self::USER1), self::USER2, self::UNLINKED, self::USER5],
                'owners' => [self::USER3],
            ],
            self::GROUP2 => ['members' => [self::USER1], 'owners' => [self::USER3]],
        ]);

        $trace = [];
        $complete = main::sync_groups($graph, function (string $message, int $level = 0) use (&$trace): void {
            $trace[] = $message;
        });

        $this->assertTrue($complete);
        $this->assertTrue($this->has_role($user1, 'manager'));
        $this->assertTrue($this->has_role($user1, 'coursecreator'));
        $this->assertTrue($this->has_role($user2, 'manager'));
        $this->assertFalse($this->has_role($user2, 'coursecreator'));
        $this->assertTrue($this->has_role($user3, 'manager'));
        $this->assertTrue($this->has_role($user3, 'coursecreator'));
        $this->assertFalse($this->has_role($user4, 'manager'));
        $this->assertFalse($this->has_role($user5, 'manager'));

        $output = implode("\n", $trace);
        $this->assertStringContainsString('Role assignments added: 5, removed: 0.', $output);
        $this->assertStringContainsString('Users processed: 3, changed: 3, unaffected: 0.', $output);
        $this->assertStringContainsString('2 not connected (skipped)', $output);
        $this->assertStringContainsString('not connected to Microsoft 365 (skipped): 2', $output);

        // A second run changes nothing.
        $trace = [];
        main::sync_groups($graph, function (string $message, int $level = 0) use (&$trace): void {
            $trace[] = $message;
        });
        $output = implode("\n", $trace);
        $this->assertStringContainsString('Role assignments added: 0, removed: 0.', $output);
        $this->assertStringContainsString('Users processed: 3, changed: 0, unaffected: 3.', $output);
    }

    /**
     * Test that roles are removed when a user leaves a group, but never manual or claim based roles.
     */
    public function test_sync_groups_removes_roles(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('rolesync_groupmap', self::GROUP1 . '=manager', 'local_o365');
        set_config('rolesync_revoke', 1, 'local_o365');

        $user1 = $this->create_connected_user(self::USER1);
        $user2 = $this->create_connected_user(self::USER2);
        $systemcontextid = context_system::instance()->id;

        // User 2 also holds the role manually, and user 1 through the claim mapping.
        $managerid = (int) $DB->get_field('role', 'id', ['shortname' => 'manager']);
        role_assign($managerid, $user2, $systemcontextid);
        role_assign($managerid, $user1, $systemcontextid, 'auth_oidc', 1);

        $both = ['members' => [self::USER1, self::USER2], 'owners' => []];
        main::sync_groups($this->create_graph_mock([self::GROUP1 => $both]));
        $this->assertTrue($this->has_role($user1, 'manager'));
        $this->assertTrue($this->has_role($user2, 'manager'));

        // Both users leave the group.
        $trace = [];
        main::sync_groups(
            $this->create_graph_mock([self::GROUP1 => ['members' => [], 'owners' => []]]),
            function (string $message, int $level = 0) use (&$trace): void {
                $trace[] = $message;
            }
        );

        $this->assertFalse($this->has_role($user1, 'manager'));
        $this->assertFalse($this->has_role($user2, 'manager'));
        $this->assertTrue($this->has_role($user1, 'manager', 'auth_oidc'));
        $this->assertTrue($this->has_role($user2, 'manager', ''));
        $this->assertStringContainsString('Role assignments added: 0, removed: 2.', implode("\n", $trace));
    }

    /**
     * Test that roles are not removed when removal is disabled.
     */
    public function test_sync_groups_removal_disabled(): void {
        $this->resetAfterTest();

        set_config('rolesync_groupmap', self::GROUP1 . '=manager', 'local_o365');
        set_config('rolesync_revoke', 0, 'local_o365');

        $user1 = $this->create_connected_user(self::USER1);

        main::sync_groups($this->create_graph_mock([self::GROUP1 => ['members' => [self::USER1], 'owners' => []]]));
        $this->assertTrue($this->has_role($user1, 'manager'));

        main::sync_groups($this->create_graph_mock([self::GROUP1 => ['members' => [], 'owners' => []]]));
        $this->assertTrue($this->has_role($user1, 'manager'));
    }

    /**
     * Test that a group that can't be read still lets other groups add roles, but stops any removal.
     */
    public function test_sync_groups_failed_group_skips_removal(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('rolesync_groupmap', self::GROUP1 . "=manager\n" . self::GROUP2 . '=coursecreator', 'local_o365');
        set_config('rolesync_revoke', 1, 'local_o365');

        $user1 = $this->create_connected_user(self::USER1);
        $user2 = $this->create_connected_user(self::USER2);

        // User 2 holds the manager role from an earlier run, but is no longer in the first group.
        main::apply_roles($user2, [(int) $DB->get_field('role', 'id', ['shortname' => 'manager'])], true);

        $graph = $this->create_graph_mock([
            self::GROUP1 => ['members' => [self::USER1], 'owners' => []],
            self::GROUP2 => ['fail' => true],
        ]);

        $trace = [];
        $complete = main::sync_groups($graph, function (string $message, int $level = 0) use (&$trace): void {
            $trace[] = $message;
        });

        $this->assertFalse($complete);
        $this->assertTrue($this->has_role($user1, 'manager'));
        $this->assertTrue($this->has_role($user2, 'manager'));
        $this->assertStringContainsString('Skipping role removal', implode("\n", $trace));
    }

    /**
     * Test that a user who loses the Microsoft 365 connection loses the roles granted through the group mapping.
     */
    public function test_sync_groups_connection_lost(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('rolesync_groupmap', self::GROUP1 . '=manager', 'local_o365');
        set_config('rolesync_revoke', 1, 'local_o365');

        $user1 = $this->create_connected_user(self::USER1);
        $graph = $this->create_graph_mock([self::GROUP1 => ['members' => [self::USER1], 'owners' => []]]);

        main::sync_groups($graph);
        $this->assertTrue($this->has_role($user1, 'manager'));

        // The OIDC token is removed, but the object mapping stays.
        $DB->delete_records('auth_oidc_token', ['userid' => $user1]);
        main::sync_groups($graph);
        $this->assertFalse($this->has_role($user1, 'manager'));
    }

    /**
     * Test that deleted users are skipped, including when they still hold a role from an earlier run.
     */
    public function test_sync_groups_skips_deleted_users(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('rolesync_groupmap', self::GROUP1 . '=manager', 'local_o365');
        set_config('rolesync_revoke', 1, 'local_o365');

        $user1 = $this->create_connected_user(self::USER1);
        $user2 = $this->create_connected_user(self::USER2);
        $graph = $this->create_graph_mock([self::GROUP1 => ['members' => [self::USER1, self::USER2], 'owners' => []]]);

        main::sync_groups($graph);
        $this->assertTrue($this->has_role($user1, 'manager'));
        $this->assertTrue($this->has_role($user2, 'manager'));

        // User 1 is deleted, and user 2 leaves the group.
        $DB->set_field('user', 'deleted', 1, ['id' => $user1]);
        $trace = [];
        $graph = $this->create_graph_mock([self::GROUP1 => ['members' => [], 'owners' => []]]);
        main::sync_groups($graph, function (string $message, int $level = 0) use (&$trace): void {
            $trace[] = $message;
        });

        $this->assertFalse($this->has_role($user2, 'manager'));
        $this->assertTrue($this->has_role($user1, 'manager'));
        $this->assertStringContainsString('Users processed: 1, changed: 1, unaffected: 0.', implode("\n", $trace));
    }

    /**
     * Test that the summary counts Microsoft IDs, when several IDs resolve to one Moodle user.
     */
    public function test_sync_groups_summary_counts_microsoft_ids(): void {
        global $DB;
        $this->resetAfterTest();

        set_config('rolesync_groupmap', self::GROUP1 . '=manager', 'local_o365');
        set_config('rolesync_revoke', 1, 'local_o365');

        // Two Microsoft IDs are linked to the same Moodle user, and the second ID is also linked to another one.
        $user1 = $this->create_connected_user(self::USER1);
        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'subtype' => '',
            'objectid' => self::USER2,
            'o365name' => 'second@example.com',
            'moodleid' => $user1,
            'tenant' => '',
            'metadata' => '',
            'timecreated' => time(),
            'timemodified' => time(),
        ]);
        $this->create_connected_user(self::USER2);

        $trace = [];
        main::sync_groups(
            $this->create_graph_mock([self::GROUP1 => ['members' => [self::USER1, self::USER2], 'owners' => []]]),
            function (string $message, int $level = 0) use (&$trace): void {
                $trace[] = $message;
            }
        );

        $this->assertStringContainsString(
            '2 distinct Microsoft user(s) in the mapped groups, 2 of them connected to Microsoft 365, 0 not connected (skipped).',
            implode("\n", $trace)
        );
        $this->assertTrue($this->has_role($user1, 'manager'));
    }
}
