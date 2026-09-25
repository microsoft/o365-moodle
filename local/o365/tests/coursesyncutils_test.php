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
 * Test cases for course sync feature utility class.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365;

use externallib_advanced_testcase;
use local_o365\feature\coursesync\utils;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/webservice/tests/helpers.php');

/**
 * Tests \local_o365\feature\coursesync\utils.
 *
 * @group local_o365
 */
final class coursesyncutils_test extends externallib_advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test is_enabled() method.
     *
     * @covers \local_o365\feature\coursesync\utils::is_enabled
     */
    public function test_is_enabled(): void {
        global $DB;

        $DB->delete_records('config_plugins', ['name' => 'coursesync', 'plugin' => 'local_o365']);
        $this->assertFalse(utils::is_enabled());

        set_config('coursesync', '', 'local_o365');
        $this->assertFalse(utils::is_enabled());

        set_config('coursesync', 'onall', 'local_o365');
        $this->assertTrue(utils::is_enabled());

        set_config('coursesync', 'off', 'local_o365');
        $this->assertFalse(utils::is_enabled());

        set_config('coursesync', 'oncustom', 'local_o365');
        $this->assertTrue(utils::is_enabled());

        set_config('coursesync', 'off', 'local_o365');
        $this->assertFalse(utils::is_enabled());
    }

    /**
     * Test get_enabled_courses() method.
     *
     * @covers \local_o365\feature\coursesync\utils::get_enabled_courses
     */
    public function test_get_enabled_courses(): void {
        global $DB;

        $DB->delete_records('config_plugins', ['name' => 'coursesync', 'plugin' => 'local_o365']);
        $actual = utils::get_enabled_courses();
        $this->assertIsArray($actual);
        $this->assertEmpty($actual);

        set_config('coursesync', 'off', 'local_o365');
        set_config('coursesynccustom', json_encode([1 => 1]), 'local_o365');
        $actual = utils::get_enabled_courses();
        $this->assertIsArray($actual);
        $this->assertEmpty($actual);

        set_config('coursesync', 'onall', 'local_o365');
        set_config('coursesynccustom', json_encode([1 => 1]), 'local_o365');
        $actual = utils::get_enabled_courses();
        $this->assertTrue($actual);

        set_config('coursesync', 'oncustom', 'local_o365');
        set_config('coursesynccustom', json_encode([1 => 1]), 'local_o365');
        $actual = utils::get_enabled_courses();
        $this->assertIsArray($actual);
        $this->assertEquals([1], $actual);
    }

    /**
     * Test course_is_group_enabled() method.
     *
     * @covers \local_o365\feature\coursesync\utils::is_course_sync_enabled
     */
    public function test_course_is_group_enabled(): void {
        global $DB;

        $DB->delete_records('config_plugins', ['name' => 'coursesync', 'plugin' => 'local_o365']);
        $DB->delete_records('config_plugins', ['name' => 'coursesynccustom', 'plugin' => 'local_o365']);
        $actual = utils::is_course_sync_enabled(3);
        $this->assertFalse($actual);

        set_config('coursesync', 'off', 'local_o365');
        set_config('coursesynccustom', json_encode([1 => 1, 3 => 1]), 'local_o365');
        $actual = utils::is_course_sync_enabled(3);
        $this->assertFalse($actual);

        set_config('coursesync', 'onall', 'local_o365');
        set_config('coursesynccustom', json_encode([2 => 1]), 'local_o365');
        $actual = utils::is_course_sync_enabled(3);
        $this->assertTrue($actual);

        set_config('coursesync', 'oncustom', 'local_o365');
        set_config('coursesynccustom', json_encode([2 => 1]), 'local_o365');
        $actual = utils::is_course_sync_enabled(3);
        $this->assertFalse($actual);

        set_config('coursesync', 'oncustom', 'local_o365');
        set_config('coursesynccustom', json_encode([2 => 1, 3 => 1]), 'local_o365');
        $actual = utils::is_course_sync_enabled(3);
        $this->assertTrue($actual);
    }

    /**
     * Data provider for test_clean_up_group_mail_alias().
     *
     * @return array
     */
    public static function clean_up_group_mail_alias_provider(): array {
        return [
            'ASCII only' => ['sample 15', 'sample15'],
            'ASCII with unsupported characters' => ['[U] Math (2026); a.b@c', 'UMath2026abc'],
            'Cyrillic' => ['[U] [СИЭ] Муниципальное право (заочное)', 'USIEMunicipalnoepravozaocnoe'],
            'Accented Latin' => ['Café Über', 'CafeUber'],
            'Empty' => ['', ''],
        ];
    }

    /**
     * Test clean_up_group_mail_alias() method.
     *
     * @dataProvider clean_up_group_mail_alias_provider
     * @covers \local_o365\feature\coursesync\utils::clean_up_group_mail_alias
     * @param string $mailalias
     * @param string $expected
     */
    public function test_clean_up_group_mail_alias(string $mailalias, string $expected): void {
        $this->assertEquals($expected, utils::clean_up_group_mail_alias($mailalias));
    }

    /**
     * Test get_group_mail_alias() method with a course whose name contains only non-Latin characters.
     *
     * @covers \local_o365\feature\coursesync\utils::get_group_mail_alias
     */
    public function test_get_group_mail_alias_non_latin_course_name(): void {
        set_config('group_mail_alias_prefix', 'U', 'local_o365');
        set_config('group_mail_alias_suffix', '', 'local_o365');
        set_config('group_mail_alias_course', \local_o365\feature\coursesync\main::NAME_OPTION_FULL_NAME, 'local_o365');

        $course = new \stdClass();
        $course->fullname = 'Муниципальное право (заочное)';
        $course->shortname = 'МП';
        $course->idnumber = '';
        $course->id = 2;

        $this->assertEquals('UMunicipalnoepravozaocnoe', utils::get_group_mail_alias($course));
    }
}
