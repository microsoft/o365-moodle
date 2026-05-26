<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * REST tests for tiny_teamsmeeting webservice.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tiny_teamsmeeting;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/webservice/tests/helpers.php');

use externallib_advanced_testcase;
use \context_course;
use \context_system;

/**
 * REST test case for tiny_teamsmeeting webservice.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class webservice_test extends externallib_advanced_testcase {

    /**
     * Set up test data.
     */
    protected function setUp(): void {
        $this->resetAfterTest();
    }

    /**
     * Test that users with capability can access Teams Meeting functionality.
     */
    public function test_teamsmeeting_capability_with_access() {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'editingteacher');

        $this->setUser($user);
        $context = \context_course::instance($course->id);
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $context));
    }

    /**
     * Test that users without capability cannot access Teams Meeting functionality.
     */
    public function test_teamsmeeting_capability_without_access() {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'student');

        $this->setUser($user);
        $context = \context_course::instance($course->id);
        $this->assertFalse(has_capability('tiny/teamsmeeting:add', $context));
    }

    /**
     * Test capability in system context.
     */
    public function test_teamsmeeting_system_context_capability() {
        $user = $this->getDataGenerator()->create_user();

        $this->setUser($user);
        $context = \context_system::instance();
        
        $this->assignUserCapability('tiny/teamsmeeting:add', $context->id, null);
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $context));
    }

    /**
     * Test capability in course context.
     */
    public function test_teamsmeeting_course_context_capability() {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'editingteacher');

        $this->setUser($user);
        $context = \context_course::instance($course->id);
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $context));
    }

    /**
     * Test capability enforcement across different roles.
     */
    public function test_teamsmeeting_capability_enforcement() {
        $course = $this->getDataGenerator()->create_course();
        
        $roles = ['student', 'editingteacher', 'teacher'];
        
        foreach ($roles as $role) {
            $user = $this->getDataGenerator()->create_user();
            $this->getDataGenerator()->enrol_user($user->id, $course->id, $role);
            
            $this->setUser($user);
            $context = \context_course::instance($course->id);
            
            if ($role === 'editingteacher') {
                $this->assertTrue(has_capability('tiny/teamsmeeting:add', $context), "User with role $role should have capability");
            } else {
                $this->assertFalse(has_capability('tiny/teamsmeeting:add', $context), "User with role $role should not have capability");
            }
        }
    }

    /**
     * Test capability in different contexts.
     */
    public function test_teamsmeeting_context_variations() {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'editingteacher');

        $this->setUser($user);
        
        $coursecontext = \context_course::instance($course->id);
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $coursecontext));
        
        $systemcontext = \context_system::instance();
        $this->assertFalse(has_capability('tiny/teamsmeeting:add', $systemcontext));
    }

    /**
     * Test capability inheritance from parent contexts.
     */
    public function test_teamsmeeting_capability_inheritance() {
        $user = $this->getDataGenerator()->create_user();
        
        $this->setUser($user);
        
        $systemcontext = \context_system::instance();
        $this->assignUserCapability('tiny/teamsmeeting:add', $systemcontext->id, null);
        
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $systemcontext));
        
        $course = $this->getDataGenerator()->create_course();
        $coursecontext = \context_course::instance($course->id);
        
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $coursecontext));
    }
}
