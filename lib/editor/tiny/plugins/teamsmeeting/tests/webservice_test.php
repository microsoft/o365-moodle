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
use context_course;
use context_system;
use tiny_teamsmeeting\external\get_meeting_details;

/**
 * REST test case for tiny_teamsmeeting webservice.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers \tiny_teamsmeeting\external\get_meeting_details
 */
final class webservice_test extends externallib_advanced_testcase {
    /**
     * Set up test data.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * Test that users with capability can access Teams Meeting functionality.
     */
    public function test_teamsmeeting_capability_with_access(): void {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'editingteacher');

        $this->setUser($user);
        $context = context_course::instance($course->id);
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $context));
    }

    /**
     * Test that users without capability cannot access Teams Meeting functionality.
     */
    public function test_teamsmeeting_capability_without_access(): void {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'student');

        $this->setUser($user);
        $context = context_course::instance($course->id);
        $this->assertFalse(has_capability('tiny/teamsmeeting:add', $context));
    }

    /**
     * Test capability in system context.
     */
    public function test_teamsmeeting_system_context_capability(): void {
        $user = $this->getDataGenerator()->create_user();

        $this->setUser($user);
        $context = context_system::instance();
        $this->assignUserCapability('tiny/teamsmeeting:add', $context->id, null);
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $context));
    }

    /**
     * Test capability in course context.
     */
    public function test_teamsmeeting_course_context_capability(): void {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'editingteacher');

        $this->setUser($user);
        $context = context_course::instance($course->id);
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $context));
    }

    /**
     * Test capability enforcement across different roles.
     */
    public function test_teamsmeeting_capability_enforcement(): void {
        $course = $this->getDataGenerator()->create_course();
        $roles = ['student', 'editingteacher', 'teacher'];
        foreach ($roles as $role) {
            $user = $this->getDataGenerator()->create_user();
            $this->getDataGenerator()->enrol_user($user->id, $course->id, $role);
            $this->setUser($user);
            $context = context_course::instance($course->id);
            if ($role === 'editingteacher') {
                $this->assertTrue(
                    has_capability('tiny/teamsmeeting:add', $context),
                    "User with role $role should have capability"
                );
            } else {
                $this->assertFalse(
                    has_capability('tiny/teamsmeeting:add', $context),
                    "User with role $role should not have capability"
                );
            }
        }
    }

    /**
     * Test capability in different contexts.
     */
    public function test_teamsmeeting_context_variations(): void {
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'editingteacher');

        $this->setUser($user);
        $coursecontext = context_course::instance($course->id);
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $coursecontext));
        $systemcontext = context_system::instance();
        $this->assertFalse(has_capability('tiny/teamsmeeting:add', $systemcontext));
    }

    /**
     * Test capability inheritance from parent contexts.
     */
    public function test_teamsmeeting_capability_inheritance(): void {
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $systemcontext = context_system::instance();
        $this->assignUserCapability('tiny/teamsmeeting:add', $systemcontext->id, null);
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $systemcontext));
        $course = $this->getDataGenerator()->create_course();
        $coursecontext = context_course::instance($course->id);
        $this->assertTrue(has_capability('tiny/teamsmeeting:add', $coursecontext));
    }

    // Execute() behaviour tests.

    /**
     * execute() returns status=false and an error.php URL when no record matches.
     */
    public function test_execute_missing_record_returns_status_false(): void {
        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'editingteacher');
        $this->setUser($user);

        $result = get_meeting_details::execute(
            'https://teams.microsoft.com/l/meetup-join/does-not-exist'
        );

        $this->assertFalse($result['status']);
        $this->assertStringContainsString('error.php', $result['url']);
    }

    /**
     * execute() throws required_capability_exception when the caller lacks
     * tiny/teamsmeeting:add in the meeting's stored context.
     *
     * Capability is checked before ownership, so the record is owned by the
     * student to isolate this case from the ownership check.
     */
    public function test_execute_throws_on_missing_capability(): void {
        global $DB;

        $course = $this->getDataGenerator()->create_course();
        $student = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($student->id, $course->id, 'student');
        $context = context_course::instance($course->id);

        $meetingurl = 'https://teams.microsoft.com/l/meetup-join/capability-test';
        $DB->insert_record('tiny_teamsmeeting', (object) [
            'userid' => $student->id,
            'contextid' => $context->id,
            'title' => 'Capability test meeting',
            'link' => $meetingurl,
            'linkhash' => sha1($meetingurl),
            'options' => null,
            'timecreated' => time(),
        ]);

        $this->setUser($student);

        $this->expectException(\required_capability_exception::class);
        get_meeting_details::execute($meetingurl);
    }

    /**
     * execute() throws moodle_exception when a user with the capability tries
     * to retrieve a meeting record they did not create.
     */
    public function test_execute_throws_on_wrong_owner(): void {
        global $DB;

        $course = $this->getDataGenerator()->create_course();
        $owner = $this->getDataGenerator()->create_user();
        $other = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($owner->id, $course->id, 'editingteacher');
        $this->getDataGenerator()->enrol_user($other->id, $course->id, 'editingteacher');
        $context = context_course::instance($course->id);

        $meetingurl = 'https://teams.microsoft.com/l/meetup-join/ownership-test';
        $DB->insert_record('tiny_teamsmeeting', (object) [
            'userid' => $owner->id,
            'contextid' => $context->id,
            'title' => 'Ownership test meeting',
            'link' => $meetingurl,
            'linkhash' => sha1($meetingurl),
            'options' => null,
            'timecreated' => time(),
        ]);

        // Other user has the same capability but is not the record owner.
        $this->setUser($other);

        $this->expectException(\moodle_exception::class);
        get_meeting_details::execute($meetingurl);
    }

    /**
     * execute() returns status=true and a correctly constructed result.php URL
     * when the caller is the record owner with the required capability.
     */
    public function test_execute_returns_correct_url_for_owner(): void {
        global $DB;

        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'editingteacher');
        $context = context_course::instance($course->id);

        $meetingurl = 'https://teams.microsoft.com/l/meetup-join/success-test';
        $optionsurl = 'https://teams.microsoft.com/meetingOptions/success-test';
        $DB->insert_record('tiny_teamsmeeting', (object) [
            'userid' => $user->id,
            'contextid' => $context->id,
            'title' => 'Success test meeting',
            'link' => $meetingurl,
            'linkhash' => sha1($meetingurl),
            'options' => $optionsurl,
            'timecreated' => time(),
        ]);

        $this->setUser($user);

        $result = get_meeting_details::execute($meetingurl);

        $this->assertTrue($result['status']);
        $this->assertStringContainsString('result.php', $result['url']);
        $this->assertStringContainsString('viewexisting=1', $result['url']);
        $this->assertStringContainsString(urlencode($meetingurl), $result['url']);
        $this->assertStringContainsString('sesskey=', $result['url']);
    }
}
