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
 * @package block_microsoft
 * @author  Remote-Learner.net Inc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot.'/blocks/microsoft/lib.php');
require_once($CFG->dirroot . '/webservice/tests/helpers.php');

/**
 * Tests block_microsoft.
 */
class block_microsoft_testcase extends \externallib_advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test block_microsoft_study_groups_list to ensure groups are returned.
     */
    public function test_block_microsoft_study_groups_list() {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $group = $this->getDataGenerator()->create_group(array('name' => 'abc group', 'courseid' => $course->id));
        $this->getDataGenerator()->enrol_user($user->id, $course->id);

        // Ensure at system context level study group is returned for student.
        groups_add_member($group->id, $user->id, 'mod_workshop', '123');
        $groups = block_microsoft_study_groups_list($user->id, null, false, 0, 5, 1);
        $parsedurl = [];
        parse_str(parse_url($groups[0], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group->id, $parsedurl['groupid']);
        $this->assertEquals($course->id, $parsedurl['courseid']);

        // Ensure no groups are returned with no permissions.
        $groups = block_microsoft_study_groups_list($user->id, null, true, 0, 5, 1);
        $this->assertCount(0, $groups);
        self::setUser($user);

        // Ensure only groups which can be managed are returned.
        $course1 = $this->getDataGenerator()->create_course();
        $group1 = $this->getDataGenerator()->create_group(array('name' => 'xyz group', 'courseid' => $course1->id));
        $this->getDataGenerator()->enrol_user($user->id, $course1->id);
        groups_add_member($group1->id, $user->id, 'mod_workshop', '124');

        // Only assign managegroups to one course, both block/microsoft:managegroups and moodle/course:managegroups are required to manage moodle groups.
        $context = context_course::instance($course->id);
        $roleid = $this->assignUserCapability('block/microsoft:managegroups', $context->id);
        $this->assignUserCapability('moodle/course:managegroups', $context->id, $roleid);
        $groups = block_microsoft_study_groups_list($user->id, null, true, 0, 5, 1);
        $this->assertCount(1, $groups);
        parse_str(parse_url($groups[0], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group->id, $parsedurl['groupid']);
        $this->assertEquals($course->id, $parsedurl['courseid']);

        // Ensure all groups are returned and in proper order.
        $groups = block_microsoft_study_groups_list($user->id, null, false, 0, 5, 1);
        $this->assertCount(2, $groups);
        parse_str(parse_url($groups[0], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group->id, $parsedurl['groupid']);
        $this->assertEquals($course->id, $parsedurl['courseid']);
        parse_str(parse_url($groups[1], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group1->id, $parsedurl['groupid']);
        $this->assertEquals($course1->id, $parsedurl['courseid']);

        // Ensure filtering by course returns course.
        $groups = block_microsoft_study_groups_list($user->id, ['courseid' => $course->id], false, 0, 5, 1);
        $parsedurl = [];
        parse_str(parse_url($groups[0], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group->id, $parsedurl['groupid']);
        $this->assertEquals($course->id, $parsedurl['courseid']);

        // Ensure filtering by groupid returns course.
        $groups = block_microsoft_study_groups_list($user->id, ['groupid' => $group->id], false, 0, 5, 1);
        $parsedurl = [];
        parse_str(parse_url($groups[0], PHP_URL_QUERY), $parsedurl);
        $this->assertEquals($group->id, $parsedurl['groupid']);
        $this->assertEquals($course->id, $parsedurl['courseid']);
    }
}