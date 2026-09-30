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
 * Test cases for the coursesync_update web service.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365;

use advanced_testcase;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use local_o365\feature\coursesync\utils as coursesyncutils;
use local_o365\webservices\update_coursesync;

/**
 * Tests \local_o365\webservices\update_coursesync.
 *
 * @group local_o365
 * @group office365
 */
final class webservices_coursesync_test extends advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
        $this->setAdminUser();
    }

    /**
     * Test coursesync_update_parameters method.
     *
     * @covers \local_o365\webservices\update_coursesync::coursesync_update_parameters
     */
    public function test_coursesync_update_parameters(): void {
        $schema = update_coursesync::coursesync_update_parameters();
        $this->assertTrue($schema instanceof external_function_parameters);
        $this->assertArrayHasKey('courses', $schema->keys);
    }

    /**
     * Test coursesync_update_returns method.
     *
     * @covers \local_o365\webservices\update_coursesync::coursesync_update_returns
     */
    public function test_coursesync_update_returns(): void {
        $schema = update_coursesync::coursesync_update_returns();
        $this->assertTrue($schema instanceof external_single_structure);
        $this->assertArrayHasKey('data', $schema->keys);
        $this->assertArrayHasKey('warnings', $schema->keys);
    }

    /**
     * Test coursesync_update() when course sync is disabled site-wide.
     *
     * @covers \local_o365\webservices\update_coursesync::coursesync_update
     */
    public function test_coursesync_update_site_disabled(): void {
        set_config('coursesync', 'off', 'local_o365');

        $course = $this->getDataGenerator()->create_course();

        $result = update_coursesync::coursesync_update([['id' => $course->id, 'sync' => true]]);

        $this->assertEquals([], $result['data']);
        $this->assertEquals([
            [
                'item' => 'course',
                'itemid' => $course->id,
                'warningcode' => 'coursesyncdisabled',
                'message' => 'Course sync to Microsoft 365 Groups / Teams is not enabled on this site.',
            ],
        ], $result['warnings']);
    }

    /**
     * Test coursesync_update() with a course id that does not exist.
     *
     * @covers \local_o365\webservices\update_coursesync::coursesync_update
     */
    public function test_coursesync_update_course_not_found(): void {
        global $DB;

        set_config('coursesync', 'oncustom', 'local_o365');

        $fakecourseid = (int) $DB->get_field_sql('SELECT MAX(id) FROM {course}') + 1;

        $result = update_coursesync::coursesync_update([['id' => $fakecourseid, 'sync' => true]]);

        $this->assertEquals([], $result['data']);
        $this->assertEquals([
            [
                'item' => 'course',
                'itemid' => $fakecourseid,
                'warningcode' => 'coursenotfound',
                'message' => 'The course with the given ID could not be found.',
            ],
        ], $result['warnings']);
    }

    /**
     * Test coursesync_update() with the Moodle site course id, which cannot be synced.
     *
     * @covers \local_o365\webservices\update_coursesync::coursesync_update
     */
    public function test_coursesync_update_site_course(): void {
        set_config('coursesync', 'oncustom', 'local_o365');

        $result = update_coursesync::coursesync_update([['id' => SITEID, 'sync' => true]]);

        $this->assertEquals([], $result['data']);
        $this->assertEquals([
            [
                'item' => 'course',
                'itemid' => SITEID,
                'warningcode' => 'coursenotfound',
                'message' => 'The course with the given ID could not be found.',
            ],
        ], $result['warnings']);
    }

    /**
     * Test coursesync_update() when course sync is set to "All Features Enabled" for the whole site.
     *
     * @covers \local_o365\webservices\update_coursesync::coursesync_update
     */
    public function test_coursesync_update_onall_mode(): void {
        set_config('coursesync', 'onall', 'local_o365');

        $course = $this->getDataGenerator()->create_course();

        $result = update_coursesync::coursesync_update([['id' => $course->id, 'sync' => false]]);

        $this->assertEquals([], $result['data']);
        $this->assertEquals([
            [
                'item' => 'course',
                'itemid' => $course->id,
                'warningcode' => 'coursesyncmodeonall',
                'message' => 'Course sync is set to "All Features Enabled" for the whole site, so sync cannot be ' .
                    'enabled or disabled for individual courses. This course remains synced regardless of the ' .
                    'requested value.',
            ],
        ], $result['warnings']);

        // The course remains synced (as it always is under "onall") and the per-course flag was never touched.
        $this->assertTrue(coursesyncutils::is_course_sync_enabled($course->id));
    }

    /**
     * Test coursesync_update() successfully enabling and disabling sync for courses.
     *
     * @covers \local_o365\webservices\update_coursesync::coursesync_update
     */
    public function test_coursesync_update_enable_disable(): void {
        set_config('coursesync', 'oncustom', 'local_o365');

        $course1 = $this->getDataGenerator()->create_course();
        $course2 = $this->getDataGenerator()->create_course();

        // Enable sync for both courses in one call.
        $result = update_coursesync::coursesync_update([
            ['id' => $course1->id, 'sync' => true],
            ['id' => $course2->id, 'sync' => true],
        ]);

        $this->assertEquals([], $result['warnings']);
        $this->assertEquals([
            ['id' => $course1->id, 'sync' => true],
            ['id' => $course2->id, 'sync' => true],
        ], $result['data']);
        $this->assertTrue(coursesyncutils::is_course_sync_enabled($course1->id));
        $this->assertTrue(coursesyncutils::is_course_sync_enabled($course2->id));

        // Disable sync for the first course only; the second course must be unaffected.
        $result = update_coursesync::coursesync_update([
            ['id' => $course1->id, 'sync' => false],
        ]);

        $this->assertEquals([], $result['warnings']);
        $this->assertEquals([
            ['id' => $course1->id, 'sync' => false],
        ], $result['data']);
        $this->assertFalse(coursesyncutils::is_course_sync_enabled($course1->id));
        $this->assertTrue(coursesyncutils::is_course_sync_enabled($course2->id));
    }
}
