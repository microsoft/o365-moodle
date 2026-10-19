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
 * Unit tests for the authorization checks of \local_onenote\api\base::get_page.
 *
 * @package    local_onenote
 * @copyright  2026 Enovation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_onenote;

use core\context\module;
use local_onenote\api\base;
use ReflectionMethod;
use stdClass;

/**
 * Tests that get_page cannot be used to reach another user's submission or feedback.
 *
 * @group local_onenote
 * @covers \local_onenote\api\base::get_page
 * @covers \local_onenote\api\base::require_page_access
 */
final class page_access_test extends \advanced_testcase {
    /** @var stdClass Course. */
    private $course;
    /** @var stdClass Course module record. */
    private $cm;
    /** @var stdClass Assignment record. */
    private $assign;
    /** @var stdClass Student A. */
    private $studenta;
    /** @var stdClass Student B. */
    private $studentb;
    /** @var stdClass Teacher. */
    private $teacher;
    /** @var stdClass Submission of student B. */
    private $submissionb;
    /** @var stdClass Grade of student B. */
    private $gradeb;
    /** @var base API stub that never contacts Microsoft Graph. */
    private $api;

    /**
     * Create a course with an assignment, two students, a teacher and a submission and grade for student B.
     */
    protected function setUp(): void {
        global $DB;
        parent::setUp();
        $this->resetAfterTest();

        $generator = $this->getDataGenerator();
        $this->course = $generator->create_course();
        $this->studenta = $generator->create_and_enrol($this->course, 'student');
        $this->studentb = $generator->create_and_enrol($this->course, 'student');
        $this->teacher = $generator->create_and_enrol($this->course, 'editingteacher');

        $this->assign = $generator->create_module('assign', ['course' => $this->course->id]);
        $this->cm = get_coursemodule_from_instance('assign', $this->assign->id);

        $this->submissionb = (object) [
            'assignment' => $this->assign->id,
            'userid' => $this->studentb->id,
            'timecreated' => time(),
            'timemodified' => time(),
            'status' => 'submitted',
            'attemptnumber' => 0,
            'latest' => 1,
        ];
        $this->submissionb->id = $DB->insert_record('assign_submission', $this->submissionb);

        $this->gradeb = (object) [
            'assignment' => $this->assign->id,
            'userid' => $this->studentb->id,
            'timecreated' => time(),
            'timemodified' => time(),
            'grader' => $this->teacher->id,
            'grade' => 50,
            'attemptnumber' => 0,
        ];
        $this->gradeb->id = $DB->insert_record('assign_grades', $this->gradeb);

        $this->api = new class extends base {
            /**
             * Skip the parent constructor.
             */
            public function __construct() {
            }

            /**
             * Fail if Graph is called.
             */
            public function apicall($httpmethod, $apimethod, $params = '', $options = []) {
                throw new \coding_exception('Graph must not be reached by these tests.');
            }

            /**
             * Stub.
             */
            public function geturl($url, $options = []) {
                return '';
            }

            /**
             * Stub.
             */
            public function get_token() {
                return null;
            }

            /**
             * Stub.
             */
            public function is_logged_in() {
                return true;
            }

            /**
             * Stub.
             */
            public function get_login_url() {
                return '';
            }

            /**
             * Stub.
             */
            public function log_out() {
            }

            /**
             * Stub.
             */
            public function render_signin_widget() {
                return '';
            }
        };
    }

    /**
     * Run the access check directly for the given request parameters.
     *
     * @param stdClass $student The student whose work is requested.
     * @param bool $isteacher Requested teacher mode.
     * @param int|null $submissionid Requested submission ID.
     * @param int|null $gradeid Requested grade ID.
     */
    private function check_access(stdClass $student, bool $isteacher, ?int $submissionid, ?int $gradeid): void {
        $method = new ReflectionMethod(base::class, 'require_page_access');
        $method->invoke(
            $this->api,
            $this->cm,
            $this->assign,
            module::instance($this->cm->id),
            $student,
            $isteacher,
            $submissionid,
            $gradeid
        );
    }

    /**
     * A student cannot restore another student's submission by supplying their own user ID with the other's submission ID.
     */
    public function test_student_cannot_use_other_students_submission_id(): void {
        $this->setUser($this->studenta);
        $this->expectException(\moodle_exception::class);
        $this->expectExceptionMessage(get_string('errorinvalidreference', 'local_onenote'));
        $this->check_access($this->studenta, false, $this->submissionb->id, null);
    }

    /**
     * The same attack must be rejected end to end, before any page record is written or Graph is called.
     */
    public function test_get_page_rejects_cross_user_submission_id(): void {
        global $DB;
        $this->setUser($this->studenta);
        try {
            $this->api->get_page($this->cm->id, false, false, $this->studenta->id, $this->submissionb->id, 0);
            $this->fail('Expected exception not thrown');
        } catch (\moodle_exception $e) {
            $this->assertEquals('errorinvalidreference', $e->errorcode);
        }
        $this->assertFalse($DB->record_exists('local_onenote_assign_pages', ['assign_id' => $this->assign->id]));
    }

    /**
     * A student cannot name another student as the submission user.
     */
    public function test_student_cannot_access_other_student(): void {
        $this->setUser($this->studenta);
        $this->expectException(\required_capability_exception::class);
        $this->check_access($this->studentb, false, $this->submissionb->id, null);
    }

    /**
     * A student cannot claim teacher mode.
     */
    public function test_student_cannot_claim_teacher_mode(): void {
        $this->setUser($this->studenta);
        $this->expectException(\required_capability_exception::class);
        $this->check_access($this->studentb, true, $this->submissionb->id, $this->gradeb->id);
    }

    /**
     * A student cannot restore another student's feedback by grade ID.
     */
    public function test_student_cannot_use_other_students_grade_id(): void {
        $this->setUser($this->studenta);
        $this->expectException(\moodle_exception::class);
        $this->expectExceptionMessage(get_string('errorinvalidreference', 'local_onenote'));
        $this->check_access($this->studenta, false, null, $this->gradeb->id);
    }

    /**
     * A user who is not enrolled cannot access the assignment.
     */
    public function test_unenrolled_user_is_rejected(): void {
        $outsider = $this->getDataGenerator()->create_user();
        $this->setUser($outsider);
        $this->expectException(\required_capability_exception::class);
        $this->check_access($outsider, false, null, null);
    }

    /**
     * A student can access their own submission.
     */
    public function test_student_can_access_own_submission(): void {
        $this->setUser($this->studentb);
        $this->check_access($this->studentb, false, $this->submissionb->id, null);
        $this->assertTrue(true);
    }

    /**
     * A student starting a new submission passes with no identifiers.
     */
    public function test_student_can_start_new_submission(): void {
        $this->setUser($this->studenta);
        $this->check_access($this->studenta, false, null, null);
        $this->assertTrue(true);
    }

    /**
     * A teacher can access a student's submission and grade in teacher mode.
     */
    public function test_teacher_can_access_student_work(): void {
        $this->setUser($this->teacher);
        $this->check_access($this->studentb, true, $this->submissionb->id, $this->gradeb->id);
        $this->assertTrue(true);
    }

    /**
     * Even a teacher cannot mix identifiers from different students.
     */
    public function test_teacher_cannot_mix_student_identifiers(): void {
        $this->setUser($this->teacher);
        $this->expectException(\moodle_exception::class);
        $this->expectExceptionMessage(get_string('errorinvalidreference', 'local_onenote'));
        $this->check_access($this->studenta, true, $this->submissionb->id, null);
    }
}
