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
 * Tests for atto_teamsmeeting's lib functions.
 *
 * @package    atto_teamsmeeting
 * @copyright  2026 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace atto_teamsmeeting;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/lib/editor/atto/plugins/teamsmeeting/lib.php');

use advanced_testcase;

/**
 * Tests for atto_teamsmeeting's lib functions.
 *
 * @package    atto_teamsmeeting
 * @copyright  2026 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers ::atto_teamsmeeting_params_for_js
 */
final class lib_test extends advanced_testcase {
    /**
     * Set up test data.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * The add capability is defined as a write capability at course level.
     */
    public function test_capability_is_defined(): void {
        $capability = get_capability_info('atto/teamsmeeting:add');

        $this->assertNotEmpty($capability);
        $this->assertSame('write', $capability->captype);
        $this->assertEquals(CONTEXT_COURSE, $capability->contextlevel);
    }

    /**
     * Only roles that are granted the capability by default see the button in a course.
     *
     * @dataProvider default_role_provider
     * @param string $role The role shortname the user is enrolled with.
     * @param bool $expected Whether the button should be offered.
     */
    public function test_button_is_offered_by_role_in_course(string $role, bool $expected): void {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_and_enrol($course, $role);
        $this->setUser($user);

        $params = atto_teamsmeeting_params_for_js(
            'id_message',
            ['context' => \context_course::instance($course->id)],
            []
        );

        $this->assertSame($expected, $params['canadd']);
    }

    /**
     * Data provider for the default role behaviour.
     *
     * @return array
     */
    public static function default_role_provider(): array {
        return [
            'student' => ['student', false],
            'non-editing teacher' => ['teacher', false],
            'editing teacher' => ['editingteacher', true],
            'manager' => ['manager', true],
        ];
    }

    /**
     * An editing teacher is not offered the button in another course they are not enrolled in.
     */
    public function test_button_is_not_offered_in_another_course(): void {
        $course = $this->getDataGenerator()->create_course();
        $othercourse = $this->getDataGenerator()->create_course();
        $teacher = $this->getDataGenerator()->create_and_enrol($course, 'editingteacher');
        $this->setUser($teacher);

        $params = atto_teamsmeeting_params_for_js(
            'id_message',
            ['context' => \context_course::instance($othercourse->id)],
            []
        );

        $this->assertFalse($params['canadd']);
    }

    /**
     * The id of the editor's context is passed on so token.php can check the capability there.
     */
    public function test_context_id_is_passed_to_the_javascript(): void {
        $course = $this->getDataGenerator()->create_course();
        $coursecontext = \context_course::instance($course->id);
        $this->setAdminUser();

        $params = atto_teamsmeeting_params_for_js('id_message', ['context' => $coursecontext], []);

        $this->assertSame($coursecontext->id, $params['contextid']);
        $this->assertTrue($params['canadd']);
    }

    /**
     * Without an editor context the system context is used.
     */
    public function test_system_context_is_used_when_no_context_is_given(): void {
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);

        $params = atto_teamsmeeting_params_for_js('id_message', [], []);

        $this->assertSame(\context_system::instance()->id, $params['contextid']);
        $this->assertFalse($params['canadd']);
    }
}
