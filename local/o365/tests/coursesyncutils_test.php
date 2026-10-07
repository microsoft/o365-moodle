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
     * Test get_enabled_categories() method.
     *
     * @covers \local_o365\feature\coursesync\utils::get_enabled_categories
     */
    public function test_get_enabled_categories(): void {
        global $DB;

        $category = $this->getDataGenerator()->create_category();

        $DB->delete_records('config_plugins', ['name' => 'coursesync', 'plugin' => 'local_o365']);
        set_config('coursesync', 'off', 'local_o365');
        set_config('coursesynccustomcategories', json_encode([$category->id]), 'local_o365');
        $this->assertEmpty(utils::get_enabled_categories());

        set_config('coursesync', 'onall', 'local_o365');
        $this->assertEmpty(utils::get_enabled_categories());

        set_config('coursesync', 'oncustom', 'local_o365');
        $this->assertEquals([$category->id], utils::get_enabled_categories());

        // Category IDs that no longer exist should be pruned from the stored setting and the returned list.
        $deletedcategoryid = $category->id + 1000;
        set_config('coursesynccustomcategories', json_encode([$category->id, $deletedcategoryid]), 'local_o365');
        $this->assertEquals([$category->id], utils::get_enabled_categories());
        // The get_enabled_categories() method normalises IDs to integers before storing them, so compare against
        // that canonical representation rather than $category->id, whose type depends on the DB driver.
        $this->assertEquals(json_encode([(int) $category->id]), get_config('local_o365', 'coursesynccustomcategories'));
    }

    /**
     * Test get_course_ids_in_categories() and category_is_in_enabled_categories() methods.
     *
     * @covers \local_o365\feature\coursesync\utils::get_course_ids_in_categories
     * @covers \local_o365\feature\coursesync\utils::category_is_in_enabled_categories
     */
    public function test_category_courses(): void {
        $parentcategory = $this->getDataGenerator()->create_category();
        $childcategory = $this->getDataGenerator()->create_category(['parent' => $parentcategory->id]);
        $othercategory = $this->getDataGenerator()->create_category();

        $courseinparent = $this->getDataGenerator()->create_course(['category' => $parentcategory->id]);
        $courseinchild = $this->getDataGenerator()->create_course(['category' => $childcategory->id]);
        $courseinother = $this->getDataGenerator()->create_course(['category' => $othercategory->id]);

        // Courses in the selected category and its subcategories should be returned.
        $courseids = utils::get_course_ids_in_categories([$parentcategory->id]);
        $this->assertContains((int) $courseinparent->id, $courseids);
        $this->assertContains((int) $courseinchild->id, $courseids);
        $this->assertNotContains((int) $courseinother->id, $courseids);

        // A subcategory is considered enabled when its parent category is enabled.
        $this->assertTrue(utils::category_is_in_enabled_categories((int) $childcategory->id, [(int) $parentcategory->id]));
        $this->assertFalse(utils::category_is_in_enabled_categories((int) $othercategory->id, [(int) $parentcategory->id]));
    }

    /**
     * Test that courses in an enabled category are picked up by get_enabled_courses() and is_course_sync_enabled().
     *
     * @covers \local_o365\feature\coursesync\utils::get_enabled_courses
     * @covers \local_o365\feature\coursesync\utils::is_course_sync_enabled
     */
    public function test_category_based_course_sync(): void {
        $category = $this->getDataGenerator()->create_category();
        $course = $this->getDataGenerator()->create_course(['category' => $category->id]);
        $othercourse = $this->getDataGenerator()->create_course();

        set_config('coursesync', 'oncustom', 'local_o365');
        set_config('coursesynccustom', json_encode([]), 'local_o365');
        set_config('coursesynccustomcategories', json_encode([$category->id]), 'local_o365');

        $this->assertTrue(utils::is_course_sync_enabled((int) $course->id));
        $this->assertFalse(utils::is_course_sync_enabled((int) $othercourse->id));

        $enabledcourses = utils::get_enabled_courses();
        $this->assertContains((int) $course->id, $enabledcourses);
        $this->assertNotContains((int) $othercourse->id, $enabledcourses);

        // Passing pre-fetched enabled categories and/or the course's category ID (as callers checking many
        // courses in a loop would, to avoid repeated DB lookups) must give the same results as when omitted.
        $enabledcategories = utils::get_enabled_categories();
        $this->assertTrue(utils::is_course_sync_enabled((int) $course->id, $enabledcategories));
        $this->assertTrue(utils::is_course_sync_enabled((int) $course->id, $enabledcategories, (int) $category->id));
        $this->assertFalse(utils::is_course_sync_enabled((int) $othercourse->id, $enabledcategories));
        $this->assertFalse(utils::is_course_sync_enabled((int) $othercourse->id, $enabledcategories, 0));
    }

    /**
     * Test get_course_sync_status() method.
     *
     * @covers \local_o365\feature\coursesync\utils::get_course_sync_status
     */
    public function test_get_course_sync_status(): void {
        $category = $this->getDataGenerator()->create_category();
        $categoryenabledcourse = $this->getDataGenerator()->create_course(['category' => $category->id]);
        $individuallyenabledcourse = $this->getDataGenerator()->create_course();
        $bothenabledcourse = $this->getDataGenerator()->create_course(['category' => $category->id]);
        $disabledcourse = $this->getDataGenerator()->create_course();

        set_config('coursesync', 'oncustom', 'local_o365');
        set_config(
            'coursesynccustom',
            json_encode([$individuallyenabledcourse->id => true, $bothenabledcourse->id => true]),
            'local_o365'
        );
        set_config('coursesynccustomcategories', json_encode([$category->id]), 'local_o365');

        // A course enabled via its category reports enabled = true and categoryenabled = true.
        $status = utils::get_course_sync_status((int) $categoryenabledcourse->id);
        $this->assertTrue($status['enabled']);
        $this->assertTrue($status['categoryenabled']);

        // An individually-enabled course (whose category is not selected) reports enabled = true, but
        // categoryenabled = false.
        $status = utils::get_course_sync_status((int) $individuallyenabledcourse->id);
        $this->assertTrue($status['enabled']);
        $this->assertFalse($status['categoryenabled']);

        // A course that is both individually enabled AND in a selected category must still report
        // categoryenabled = true - e.g. from a past bulk "enable all", or from being seeded when switching from
        // "All Features Enabled" to "Customize", must not hide that its category also covers it.
        $status = utils::get_course_sync_status((int) $bothenabledcourse->id);
        $this->assertTrue($status['enabled']);
        $this->assertTrue($status['categoryenabled']);

        // A course that is neither individually nor category enabled reports enabled = false.
        $status = utils::get_course_sync_status((int) $disabledcourse->id);
        $this->assertFalse($status['enabled']);
        $this->assertFalse($status['categoryenabled']);

        // The is_course_sync_enabled() method must agree with the 'enabled' component of get_course_sync_status().
        $this->assertTrue(utils::is_course_sync_enabled((int) $categoryenabledcourse->id));
        $this->assertTrue(utils::is_course_sync_enabled((int) $individuallyenabledcourse->id));
        $this->assertTrue(utils::is_course_sync_enabled((int) $bothenabledcourse->id));
        $this->assertFalse(utils::is_course_sync_enabled((int) $disabledcourse->id));

        // In "All Features Enabled" mode, every course is enabled but never reported as category-enabled.
        set_config('coursesync', 'onall', 'local_o365');
        $status = utils::get_course_sync_status((int) $disabledcourse->id);
        $this->assertTrue($status['enabled']);
        $this->assertFalse($status['categoryenabled']);
    }

    /**
     * Test seed_customize_list_from_existing_groups() method.
     *
     * @covers \local_o365\feature\coursesync\utils::seed_customize_list_from_existing_groups
     */
    public function test_seed_customize_list_from_existing_groups(): void {
        global $DB;

        $syncedcourse = $this->getDataGenerator()->create_course();
        $unsyncedcourse = $this->getDataGenerator()->create_course();
        $alreadyindividuallyenabledcourse = $this->getDataGenerator()->create_course();

        $now = time();
        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'group',
            'subtype' => 'course',
            'objectid' => 'fake-group-object-id',
            'moodleid' => $syncedcourse->id,
            'o365name' => 'Fake group',
            'tenant' => '',
            'timecreated' => $now,
            'timemodified' => $now,
        ]);

        set_config('coursesync', 'onall', 'local_o365');
        set_config('coursesynccustom', json_encode([$alreadyindividuallyenabledcourse->id => true]), 'local_o365');

        utils::seed_customize_list_from_existing_groups();

        set_config('coursesync', 'oncustom', 'local_o365');
        $enabledcourses = utils::get_enabled_courses();

        // The course with an existing group is seeded into the list.
        $this->assertContains((int) $syncedcourse->id, $enabledcourses);
        // A pre-existing individually-enabled course is preserved.
        $this->assertContains((int) $alreadyindividuallyenabledcourse->id, $enabledcourses);
        // A course without an existing group is not seeded.
        $this->assertNotContains((int) $unsyncedcourse->id, $enabledcourses);
    }

    /**
     * Test set_enabled_categories() method.
     *
     * @covers \local_o365\feature\coursesync\utils::set_enabled_categories
     */
    public function test_set_enabled_categories(): void {
        $category = $this->getDataGenerator()->create_category();

        set_config('coursesync', 'oncustom', 'local_o365');
        set_config('coursesynccustomcategories', '', 'local_o365');

        utils::set_enabled_categories([$category->id]);
        $this->assertEquals([$category->id], utils::get_enabled_categories());

        utils::set_enabled_categories([]);
        $this->assertEmpty(utils::get_enabled_categories());
    }
}
