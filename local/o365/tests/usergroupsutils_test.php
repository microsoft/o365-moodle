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

/**
 * Tests \local_o365\feature\usergroups\utils.
 *
 * @group local_o365
 * @group office365
 */
class local_o365_usergroupsutils_testcase extends \advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test is_enabled() method.
     */
    public function test_is_enabled() {
        global $DB;

        $DB->delete_records('config_plugins', ['name' => 'creategroups', 'plugin' => 'local_o365']);
        $this->assertFalse(\local_o365\feature\usergroups\utils::is_enabled());

        set_config('creategroups', '', 'local_o365');
        $this->assertFalse(\local_o365\feature\usergroups\utils::is_enabled());

        set_config('creategroups', 'onall', 'local_o365');
        $this->assertTrue(\local_o365\feature\usergroups\utils::is_enabled());

        set_config('creategroups', 'off', 'local_o365');
        $this->assertFalse(\local_o365\feature\usergroups\utils::is_enabled());

        set_config('creategroups', 'oncustom', 'local_o365');
        $this->assertTrue(\local_o365\feature\usergroups\utils::is_enabled());

        set_config('creategroups', 'off', 'local_o365');
        $this->assertFalse(\local_o365\feature\usergroups\utils::is_enabled());
    }

    /**
     * Test get_enabled_courses() method.
     */
    public function test_get_enabled_courses() {
        global $DB;

        $DB->delete_records('config_plugins', ['name' => 'creategroups', 'plugin' => 'local_o365']);
        $actual = \local_o365\feature\usergroups\utils::get_enabled_courses();
        $this->assertInternalType('array', $actual);
        $this->assertEmpty($actual);

        set_config('creategroups', 'off', 'local_o365');
        set_config('usergroupcustom', json_encode([1 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::get_enabled_courses();
        $this->assertInternalType('array', $actual);
        $this->assertEmpty($actual);

        set_config('creategroups', 'onall', 'local_o365');
        set_config('usergroupcustom', json_encode([1 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::get_enabled_courses();
        $this->assertTrue($actual);

        set_config('creategroups', 'oncustom', 'local_o365');
        set_config('usergroupcustom', json_encode([1 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::get_enabled_courses();
        $this->assertInternalType('array', $actual);
        $this->assertEquals([1], $actual);
    }

    /**
     * Test course_is_group_enabled() method.
     */
    public function test_course_is_group_enabled() {
        global $DB;
        $DB->delete_records('config_plugins', ['name' => 'creategroups', 'plugin' => 'local_o365']);
        $DB->delete_records('config_plugins', ['name' => 'usergroupcustom', 'plugin' => 'local_o365']);
        $actual = \local_o365\feature\usergroups\utils::course_is_group_enabled(3);
        $this->assertFalse($actual);

        set_config('creategroups', 'off', 'local_o365');
        set_config('usergroupcustom', json_encode([1 => 1, 3 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::course_is_group_enabled(3);
        $this->assertFalse($actual);

        set_config('creategroups', 'onall', 'local_o365');
        set_config('usergroupcustom', json_encode([2 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::course_is_group_enabled(3);
        $this->assertTrue($actual);

        set_config('creategroups', 'oncustom', 'local_o365');
        set_config('usergroupcustom', json_encode([2 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::course_is_group_enabled(3);
        $this->assertFalse($actual);

        set_config('creategroups', 'oncustom', 'local_o365');
        set_config('usergroupcustom', json_encode([2 => 1, 3 => 1]), 'local_o365');
        $actual = \local_o365\feature\usergroups\utils::course_is_group_enabled(3);
        $this->assertTrue($actual);
    }
}
