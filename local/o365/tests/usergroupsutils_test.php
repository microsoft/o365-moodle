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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot.'/webservice/tests/helpers.php');

/**
 * Tests \local_o365\feature\usergroups\utils.
 *
 * @group local_o365
 * @group office365
 */
class local_o365_usergroupsutils_testcase extends \externallib_advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp() : void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test is_enabled() method.
     */
    public function test_is_enabled() {
        global $DB;

        $DB->delete_records('config_plugins', ['name' => 'createteams', 'plugin' => 'local_o365']);
        $this->assertFalse(\local_o365\feature\usergroups\utils::is_enabled());

        set_config('createteams', '', 'local_o365');
        $this->assertFalse(\local_o365\feature\usergroups\utils::is_enabled());

        set_config('createteams', 'onall', 'local_o365');
        $this->assertTrue(\local_o365\feature\usergroups\utils::is_enabled());

        set_config('createteams', 'off', 'local_o365');
        $this->assertFalse(\local_o365\feature\usergroups\utils::is_enabled());

        set_config('createteams', 'oncustom', 'local_o365');
        $this->assertTrue(\local_o365\feature\usergroups\utils::is_enabled());

        set_config('createteams', 'off', 'local_o365');
        $this->assertFalse(\local_o365\feature\usergroups\utils::is_enabled());
    }

    /**
     * Test get_enabled_courses() method.
     */
    public function test_get_enabled_courses() {
        global $DB;

        $DB->delete_records('config_plugins', ['name' => 'createteams', 'plugin' => 'local_o365']);
        $actual = \local_o365\feature\usergroups\utils::get_enabled_courses();
        $this->assertIsArray($actual);
        $this->assertEmpty($actual);

        set_config('createteams', 'off', 'local_o365');
        set_config('usergroupcustom', json_encode([1 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::get_enabled_courses();
        $this->assertIsArray($actual);
        $this->assertEmpty($actual);

        set_config('createteams', 'onall', 'local_o365');
        set_config('usergroupcustom', json_encode([1 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::get_enabled_courses();
        $this->assertTrue($actual);

        set_config('createteams', 'oncustom', 'local_o365');
        set_config('usergroupcustom', json_encode([1 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::get_enabled_courses();
        $this->assertIsArray($actual);
        $this->assertEquals([1], $actual);
    }

    /**
     * Test course_is_group_enabled() method.
     */
    public function test_course_is_group_enabled() {
        global $DB;
        $DB->delete_records('config_plugins', ['name' => 'createteams', 'plugin' => 'local_o365']);
        $DB->delete_records('config_plugins', ['name' => 'usergroupcustom', 'plugin' => 'local_o365']);
        $actual = \local_o365\feature\usergroups\utils::course_is_group_enabled(3);
        $this->assertFalse($actual);

        set_config('createteams', 'off', 'local_o365');
        set_config('usergroupcustom', json_encode([1 => 1, 3 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::course_is_group_enabled(3);
        $this->assertFalse($actual);

        set_config('createteams', 'onall', 'local_o365');
        set_config('usergroupcustom', json_encode([2 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::course_is_group_enabled(3);
        $this->assertTrue($actual);

        set_config('createteams', 'oncustom', 'local_o365');
        set_config('usergroupcustom', json_encode([2 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::course_is_group_enabled(3);
        $this->assertFalse($actual);

        set_config('createteams', 'oncustom', 'local_o365');
        set_config('usergroupcustom', json_encode([2 => 1, 3 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::course_is_group_enabled(3);
        $this->assertTrue($actual);
    }

    /**
     * Test block_microsoft_study_groups_list to ensure groups are returned.
     */
    public function test_block_microsoft_study_groups_list() {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $group = $this->getDataGenerator()->create_group(['name' => 'abc group', 'courseid' => $course->id]);
        $this->getDataGenerator()->enrol_user($user->id, $course->id);

        // Ensure at system context level study group is returned for student.
        groups_add_member($group->id, $user->id, 'mod_workshop', '123');
        $groups = \local_o365\feature\usergroups\utils::study_groups_list($user->id, null, false, 0, 5, 1);
        $parsedurl = [];
        parse_str(parse_url($groups[0], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group->id, $parsedurl['groupid']);
        $this->assertEquals($course->id, $parsedurl['courseid']);

        // Ensure no groups are returned with no permissions.
        $groups = \local_o365\feature\usergroups\utils::study_groups_list($user->id, null, true, 0, 5, 1);
        $this->assertCount(0, $groups);
        self::setUser($user);

        // Ensure only groups which can be managed are returned.
        $course1 = $this->getDataGenerator()->create_course();
        $group1 = $this->getDataGenerator()->create_group(['name' => 'xyz group', 'courseid' => $course1->id]);
        $this->getDataGenerator()->enrol_user($user->id, $course1->id);
        groups_add_member($group1->id, $user->id, 'mod_workshop', '124');

        // Only assign managegroups to one course, both local/o365:managegroups and moodle/course:managegroups are required to manage moodle groups.
        $context = \context_course::instance($course->id);
        $roleid = $this->assignUserCapability('local/o365:managegroups', $context->id);
        $this->assignUserCapability('moodle/course:managegroups', $context->id, $roleid);
        $groups = \local_o365\feature\usergroups\utils::study_groups_list($user->id, null, true, 0, 5, 1);
        $this->assertCount(1, $groups);
        parse_str(parse_url($groups[0], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group->id, $parsedurl['groupid']);
        $this->assertEquals($course->id, $parsedurl['courseid']);

        // Ensure all groups are returned and in proper order.
        $groups = \local_o365\feature\usergroups\utils::study_groups_list($user->id, null, false, 0, 5, 1);
        $this->assertCount(2, $groups);
        parse_str(parse_url($groups[0], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group->id, $parsedurl['groupid']);
        $this->assertEquals($course->id, $parsedurl['courseid']);
        parse_str(parse_url($groups[1], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group1->id, $parsedurl['groupid']);
        $this->assertEquals($course1->id, $parsedurl['courseid']);

        // Ensure filtering by course returns course.
        $groups = \local_o365\feature\usergroups\utils::study_groups_list($user->id, ['courseid' => $course->id], false, 0, 5, 1);
        $parsedurl = [];
        parse_str(parse_url($groups[0], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group->id, $parsedurl['groupid']);
        $this->assertEquals($course->id, $parsedurl['courseid']);

        // Ensure filtering by groupid returns course.
        $groups = \local_o365\feature\usergroups\utils::study_groups_list($user->id, ['groupid' => $group->id], false, 0, 5, 1);
        $parsedurl = [];
        parse_str(parse_url($groups[0], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group->id, $parsedurl['groupid']);
        $this->assertEquals($course->id, $parsedurl['courseid']);
    }
}
