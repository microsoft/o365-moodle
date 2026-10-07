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
 * Test cases for the channels created for Moodle groups.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\coursesync;

use advanced_testcase;
use local_o365\rest\unified;
use stdClass;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/group/lib.php');

/**
 * Tests the channels created for Moodle groups.
 *
 * @group local_o365
 * @group office365
 * @covers \local_o365\feature\coursesync\groupchannels
 */
final class groupchannels_test extends advanced_testcase {
    /** @var string The object ID of the Team. */
    private const TEAMID = 'aaaaaaaa-0000-0000-0000-000000000001';

    /** @var string The object ID of the teacher. */
    private const TEACHERID = 'bbbbbbbb-0000-0000-0000-000000000001';

    /** @var string The object ID of the student. */
    private const STUDENTID = 'cccccccc-0000-0000-0000-000000000001';

    /**
     * Perform setup before every test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Create a course synchronized to a Team, with a teacher and a student, and a group.
     *
     * @param bool $teacheringroup Whether to put the teacher in the group, as well as the student.
     * @return stdClass The group.
     */
    private function create_group_in_team_course(bool $teacheringroup = true): stdClass {
        global $DB;

        set_config('coursesync', 'onall', 'local_o365');
        set_config('coursesyncgroupchannels', 1, 'local_o365');

        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $teacher = $generator->create_user();
        $student = $generator->create_user();
        $generator->enrol_user($teacher->id, $course->id, 'editingteacher');
        $generator->enrol_user($student->id, $course->id, 'student');
        $group = $generator->create_group([
            'courseid' => $course->id,
            'name' => 'Group A',
            'description' => '<p>The <b>first</b> group &amp; friends</p>',
        ]);
        if ($teacheringroup) {
            $generator->create_group_member(['userid' => $teacher->id, 'groupid' => $group->id]);
        }

        $generator->create_group_member(['userid' => $student->id, 'groupid' => $group->id]);

        $now = time();
        foreach ([[$teacher->id, self::TEACHERID], [$student->id, self::STUDENTID]] as [$userid, $objectid]) {
            $DB->insert_record('local_o365_objects', (object)[
                'type' => 'user', 'subtype' => '', 'objectid' => $objectid, 'moodleid' => $userid, 'o365name' => 'user' . $userid,
                'tenant' => '', 'timecreated' => $now, 'timemodified' => $now,
            ]);
        }

        $DB->insert_record('local_o365_objects', (object)[
            'type' => 'group', 'subtype' => 'teamfromgroup', 'objectid' => self::TEAMID, 'moodleid' => $course->id,
            'o365name' => 'Team', 'tenant' => '', 'timecreated' => $now, 'timemodified' => $now,
        ]);

        return $group;
    }

    /**
     * Create a mock Graph client.
     *
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function create_graph_mock() {
        return $this->getMockBuilder(unified::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'create_private_channel',
                'get_channel_members',
                'add_member_to_channel',
                'update_channel_member_role',
                'remove_member_from_channel',
            ])
            ->getMock();
    }

    /**
     * Create a channel sync that uses the mock Graph client and reports whether the Team is locked as given.
     *
     * @param \PHPUnit\Framework\MockObject\MockObject $graph The mock Graph client.
     * @param bool $locked Whether the Team limits its membership to its owners.
     * @param array $extramethods Names of other methods to mock.
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function create_syncer($graph, bool $locked = false, array $extramethods = []) {
        $syncer = $this->getMockBuilder(groupchannels::class)
            ->setConstructorArgs([$graph])
            ->onlyMethods(array_merge(['is_team_locked'], $extramethods))
            ->getMock();
        $syncer->method('is_team_locked')->willReturn($locked);

        return $syncer;
    }

    /**
     * Test channels are only created when enabled, and when the user sync direction allows it.
     */
    public function test_is_enabled(): void {
        $this->assertFalse(groupchannels::is_enabled());

        set_config('coursesyncgroupchannels', 1, 'local_o365');
        $this->assertFalse(groupchannels::is_enabled());

        set_config('coursesync', 'onall', 'local_o365');
        $this->assertTrue(groupchannels::is_enabled());

        set_config('courseusersyncdirection', COURSE_USER_SYNC_DIRECTION_TEAMS_TO_MOODLE, 'local_o365');
        $this->assertFalse(groupchannels::is_enabled());

        set_config('courseusersyncdirection', COURSE_USER_SYNC_DIRECTION_BOTH, 'local_o365');
        $this->assertTrue(groupchannels::is_enabled());
    }

    /**
     * Test channel names are made valid for Microsoft Teams.
     */
    public function test_get_channel_name(): void {
        $this->assertSame('Group A', groupchannels::get_channel_name('Group A', 5));
        $this->assertSame('Maths- Year 1', groupchannels::get_channel_name('Maths: Year 1', 5));
        $this->assertSame('A-B-C-D', groupchannels::get_channel_name('A#B%C&D', 5));
        $this->assertSame('Group 5', groupchannels::get_channel_name('', 5));
        $this->assertSame('General 5', groupchannels::get_channel_name('General', 5));
        $this->assertSame('Spaced out', groupchannels::get_channel_name("  _.Spaced \t out. ", 5));
        $this->assertSame(
            str_repeat('x', 50),
            groupchannels::get_channel_name(str_repeat('x', 80), 5)
        );
    }

    /**
     * Test the Graph permissions needed for channels are only required when channels are enabled.
     */
    public function test_required_permissions(): void {
        $graph = $this->getMockBuilder(unified::class)->disableOriginalConstructor()->onlyMethods([])->getMock();

        $permissions = $graph->get_required_permissions('graph')['requiredAppPermissions'];
        $this->assertArrayNotHasKey('Channel.Create', $permissions);
        $this->assertArrayNotHasKey('ChannelMember.ReadWrite.All', $permissions);

        set_config('coursesyncgroupchannels', 1, 'local_o365');
        $permissions = $graph->get_required_permissions('graph')['requiredAppPermissions'];
        $this->assertArrayHasKey('Channel.Create', $permissions);
        $this->assertArrayHasKey('ChannelMember.ReadWrite.All', $permissions);
    }

    /**
     * Test a channel is created for a group, owned by the group's teacher, and the student is added to it.
     */
    public function test_sync_group_creates_channel(): void {
        $this->expectOutputRegex('/Process group/');

        $group = $this->create_group_in_team_course();

        $graph = $this->create_graph_mock();
        $graph->expects($this->once())
            ->method('create_private_channel')
            ->with(self::TEAMID, 'Group A', 'The first group & friends', self::TEACHERID)
            ->willReturn(['id' => 'channel1']);
        $graph->method('get_channel_members')
            ->with(self::TEAMID, 'channel1')
            ->willReturn([['id' => 'm1', 'userId' => self::TEACHERID, 'roles' => ['owner']]]);
        $graph->expects($this->once())
            ->method('add_member_to_channel')
            ->with(self::TEAMID, 'channel1', self::STUDENTID, false);
        $graph->expects($this->never())->method('remove_member_from_channel');
        $graph->expects($this->never())->method('update_channel_member_role');

        $this->assertTrue($this->create_syncer($graph)->sync_group($group->id));

        $mapping = groupchannels::get_mapping($group->id);
        $this->assertNotFalse($mapping);
        $this->assertSame('channel1', $mapping->objectid);
        $this->assertSame('Group A', $mapping->o365name);
    }

    /**
     * Test a Team owner of the course owns the channel of a group that has no teacher in it.
     */
    public function test_sync_group_uses_team_owner_when_group_has_none(): void {
        $this->expectOutputRegex('/Process group/');

        $group = $this->create_group_in_team_course(false);

        $graph = $this->create_graph_mock();
        $graph->expects($this->once())
            ->method('create_private_channel')
            ->with(self::TEAMID, 'Group A', 'The first group & friends', self::TEACHERID)
            ->willReturn(['id' => 'channel1']);
        $graph->method('get_channel_members')
            ->willReturn([['id' => 'm1', 'userId' => self::TEACHERID, 'roles' => ['owner']]]);
        $graph->expects($this->once())
            ->method('add_member_to_channel')
            ->with(self::TEAMID, 'channel1', self::STUDENTID, false);
        $graph->expects($this->never())->method('remove_member_from_channel');

        $this->assertTrue($this->create_syncer($graph)->sync_group($group->id));
    }

    /**
     * Test an existing channel is corrected: wrong roles are fixed and users who aren't in the group are removed.
     */
    public function test_sync_group_updates_existing_channel(): void {
        global $DB;

        $this->expectOutputRegex('/Process group/');

        $group = $this->create_group_in_team_course();
        $now = time();
        $DB->insert_record('local_o365_objects', (object)[
            'type' => groupchannels::OBJECT_TYPE, 'subtype' => groupchannels::OBJECT_SUBTYPE, 'objectid' => 'channel1',
            'moodleid' => $group->id, 'o365name' => 'Group A', 'tenant' => '',
            'metadata' => json_encode(['courseid' => (int)$group->courseid, 'teamobjectid' => self::TEAMID]),
            'timecreated' => $now, 'timemodified' => $now,
        ]);

        $graph = $this->create_graph_mock();
        $graph->expects($this->never())->method('create_private_channel');
        $graph->method('get_channel_members')
            ->with(self::TEAMID, 'channel1')
            ->willReturn([
                ['id' => 'm1', 'userId' => strtoupper(self::TEACHERID), 'roles' => ['owner']],
                ['id' => 'm2', 'userId' => self::STUDENTID, 'roles' => ['owner']],
                ['id' => 'm3', 'userId' => 'dddddddd-0000-0000-0000-000000000001', 'roles' => []],
            ]);
        $graph->expects($this->never())->method('add_member_to_channel');
        $graph->expects($this->once())
            ->method('update_channel_member_role')
            ->with(self::TEAMID, 'channel1', 'm2', false);
        $graph->expects($this->once())
            ->method('remove_member_from_channel')
            ->with(self::TEAMID, 'channel1', 'm3');

        $this->assertTrue($this->create_syncer($graph)->sync_group($group->id));
    }

    /**
     * Test a user who isn't in the Team yet is added to the Team, then to the channel.
     */
    public function test_sync_group_adds_user_missing_from_team(): void {
        $this->expectOutputRegex('/Process group/');

        $group = $this->create_group_in_team_course();

        $graph = $this->create_graph_mock();
        $graph->method('create_private_channel')->willReturn(['id' => 'channel1']);
        $graph->method('get_channel_members')
            ->willReturn([['id' => 'm1', 'userId' => self::TEACHERID, 'roles' => ['owner']]]);
        $attempts = 0;
        $graph->expects($this->exactly(2))
            ->method('add_member_to_channel')
            ->with(self::TEAMID, 'channel1', self::STUDENTID, false)
            ->willReturnCallback(function () use (&$attempts) {
                if (!$attempts++) {
                    throw new \moodle_exception(
                        'erroro365apibadcall_message',
                        'local_o365',
                        '',
                        'User is not part of the parent team roster.'
                    );
                }

                return ['id' => 'm2'];
            });

        $syncer = $this->create_syncer($graph, false, ['add_user_to_team']);
        $syncer->expects($this->once())->method('add_user_to_team')->with(self::TEAMID, self::STUDENTID)->willReturn(true);

        $this->assertTrue($syncer->sync_group($group->id));
    }

    /**
     * Test a user who can't be added to the Team isn't added to the channel, and the sync is reported as incomplete.
     */
    public function test_sync_group_reports_user_that_cannot_join_team(): void {
        $this->expectOutputRegex('/Process group/');

        $group = $this->create_group_in_team_course();

        $graph = $this->create_graph_mock();
        $graph->method('create_private_channel')->willReturn(['id' => 'channel1']);
        $graph->method('get_channel_members')
            ->willReturn([['id' => 'm1', 'userId' => self::TEACHERID, 'roles' => ['owner']]]);
        $graph->expects($this->once())
            ->method('add_member_to_channel')
            ->willThrowException(new \moodle_exception(
                'erroro365apibadcall_message',
                'local_o365',
                '',
                'User is not part of the parent team roster.'
            ));

        $syncer = $this->create_syncer($graph, false, ['add_user_to_team']);
        $syncer->method('add_user_to_team')->willReturn(false);

        $this->assertFalse($syncer->sync_group($group->id));
    }

    /**
     * Test the students of a Team that hasn't been activated are left out, and the sync is reported as incomplete.
     */
    public function test_sync_group_skips_students_of_locked_team(): void {
        $this->expectOutputRegex('/Process group/');

        $group = $this->create_group_in_team_course();

        $graph = $this->create_graph_mock();
        $graph->method('create_private_channel')->willReturn(['id' => 'channel1']);
        $graph->method('get_channel_members')
            ->willReturn([['id' => 'm1', 'userId' => self::TEACHERID, 'roles' => ['owner']]]);
        $graph->expects($this->never())->method('add_member_to_channel');
        $graph->expects($this->never())->method('remove_member_from_channel');

        $this->assertFalse($this->create_syncer($graph, true)->sync_group($group->id));
    }

    /**
     * Test nothing is done for a group in a course that isn't synchronized to a Team.
     */
    public function test_sync_group_skips_course_without_team(): void {
        global $DB;

        $this->expectOutputRegex('/Process group/');

        $group = $this->create_group_in_team_course();
        $DB->delete_records('local_o365_objects', ['type' => 'group']);

        $graph = $this->create_graph_mock();
        $graph->expects($this->never())->method('create_private_channel');
        $graph->expects($this->never())->method('get_channel_members');

        $this->assertTrue($this->create_syncer($graph)->sync_group($group->id));
        $this->assertFalse(groupchannels::get_mapping($group->id));
    }

    /**
     * Test deleting a group forgets its channel, but leaves the channel alone.
     */
    public function test_group_deleted_forgets_channel(): void {
        global $DB;

        // The observer only runs once the transaction the event was triggered in has been committed, which the
        // rollback Moodle uses to reset the database on some database types doesn't allow.
        $this->preventResetByRollback();

        $group = $this->create_group_in_team_course();
        $now = time();
        $DB->insert_record('local_o365_objects', (object)[
            'type' => groupchannels::OBJECT_TYPE, 'subtype' => groupchannels::OBJECT_SUBTYPE, 'objectid' => 'channel1',
            'moodleid' => $group->id, 'o365name' => 'Group A', 'tenant' => '', 'timecreated' => $now, 'timemodified' => $now,
        ]);

        groups_delete_group($group);

        $this->assertFalse(groupchannels::get_mapping($group->id));
    }

    /**
     * Create a mock of the channel sync that only records which groups it is asked to sync.
     *
     * @param array $synced The list the IDs of the synced groups are added to.
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function create_syncer_mock(array &$synced) {
        $syncer = $this->getMockBuilder(groupchannels::class)
            ->setConstructorArgs([$this->create_graph_mock()])
            ->onlyMethods(['sync_group'])
            ->getMock();
        $syncer->method('sync_group')->willReturnCallback(function (int $groupid) use (&$synced) {
            $synced[] = $groupid;
            return true;
        });

        return $syncer;
    }

    /**
     * Test the groups without a channel are synced a few at a time, going round all of them.
     */
    public function test_sync_next_groups_without_channel(): void {
        $this->expectOutputRegex('/Process group/');

        $group1 = $this->create_group_in_team_course();
        $group2 = $this->getDataGenerator()->create_group(['courseid' => $group1->courseid, 'name' => 'Group B']);

        $synced = [];
        $syncer = $this->create_syncer_mock($synced);

        $this->assertSame(1, $syncer->sync_next_groups(1));
        $this->assertSame(1, $syncer->sync_next_groups(1));
        $this->assertSame(1, $syncer->sync_next_groups(1));
        $this->assertSame([(int)$group1->id, (int)$group2->id, (int)$group1->id], $synced);
    }

    /**
     * Test groups whose channel needs another attempt are handled before all others.
     */
    public function test_sync_next_groups_prioritises_incomplete_groups(): void {
        global $DB;

        $this->expectOutputRegex('/Process group/');

        $group1 = $this->create_group_in_team_course();
        $generator = $this->getDataGenerator();
        $complete = $generator->create_group(['courseid' => $group1->courseid, 'name' => 'Group B']);
        $incomplete = $generator->create_group(['courseid' => $group1->courseid, 'name' => 'Group C']);
        $now = time();
        foreach ([[$complete, []], [$incomplete, ['incomplete' => true]]] as [$group, $extrametadata]) {
            $DB->insert_record('local_o365_objects', (object)[
                'type' => groupchannels::OBJECT_TYPE, 'subtype' => groupchannels::OBJECT_SUBTYPE,
                'objectid' => 'channel' . $group->id, 'moodleid' => $group->id, 'o365name' => $group->name, 'tenant' => '',
                'metadata' => json_encode(['courseid' => (int)$group->courseid, 'teamobjectid' => self::TEAMID] + $extrametadata),
                'timecreated' => $now, 'timemodified' => $now,
            ]);
        }

        $synced = [];
        $syncer = $this->create_syncer_mock($synced);

        $this->assertSame(3, $syncer->sync_next_groups(3));
        $this->assertSame([(int)$incomplete->id, (int)$group1->id, (int)$complete->id], $synced);
    }

    /**
     * Test a group is noted as incomplete when students couldn't be added, and cleared once they could.
     */
    public function test_sync_group_notes_when_incomplete(): void {
        $this->expectOutputRegex('/Process group/');

        $group = $this->create_group_in_team_course();

        $graph = $this->create_graph_mock();
        $graph->expects($this->once())->method('create_private_channel')->willReturn(['id' => 'channel1']);
        $graph->method('get_channel_members')
            ->willReturn([['id' => 'm1', 'userId' => self::TEACHERID, 'roles' => ['owner']]]);
        $graph->expects($this->once())
            ->method('add_member_to_channel')
            ->with(self::TEAMID, 'channel1', self::STUDENTID, false);

        // The Team isn't activated, so the student can't be added yet.
        $this->assertFalse($this->create_syncer($graph, true)->sync_group($group->id));
        $metadata = json_decode(groupchannels::get_mapping($group->id)->metadata, true);
        $this->assertTrue($metadata['incomplete']);
        $this->assertSame(self::TEAMID, $metadata['teamobjectid']);

        // Once it is activated, the student is added and the note is gone.
        $this->assertTrue($this->create_syncer($graph, false)->sync_group($group->id));
        $metadata = json_decode(groupchannels::get_mapping($group->id)->metadata, true);
        $this->assertArrayNotHasKey('incomplete', $metadata);
        $this->assertSame(self::TEAMID, $metadata['teamobjectid']);
    }

    /**
     * Test groups without a channel are not held up by the groups that have one.
     */
    public function test_sync_next_groups_prioritises_groups_without_channel(): void {
        global $DB;

        $this->expectOutputRegex('/Process group/');

        $group1 = $this->create_group_in_team_course();
        $generator = $this->getDataGenerator();
        $withchannel = [
            $generator->create_group(['courseid' => $group1->courseid, 'name' => 'Group B']),
            $generator->create_group(['courseid' => $group1->courseid, 'name' => 'Group C']),
            $generator->create_group(['courseid' => $group1->courseid, 'name' => 'Group D']),
        ];
        $now = time();
        foreach ($withchannel as $group) {
            $DB->insert_record('local_o365_objects', (object)[
                'type' => groupchannels::OBJECT_TYPE, 'subtype' => groupchannels::OBJECT_SUBTYPE,
                'objectid' => 'channel' . $group->id, 'moodleid' => $group->id, 'o365name' => $group->name, 'tenant' => '',
                'timecreated' => $now, 'timemodified' => $now,
            ]);
        }

        $synced = [];
        $syncer = $this->create_syncer_mock($synced);

        // Of 3, two are for groups without a channel (only one exists), so what is left goes to groups with a channel.
        $this->assertSame(3, $syncer->sync_next_groups(3));
        $this->assertSame([(int)$group1->id, (int)$withchannel[0]->id, (int)$withchannel[1]->id], $synced);
    }
}
