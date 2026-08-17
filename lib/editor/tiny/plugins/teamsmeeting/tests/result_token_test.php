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
 * Unit tests for the tiny_teamsmeeting result_token single-use token.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2026 Enovation Solutions
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tiny_teamsmeeting;

use advanced_testcase;
use context_course;

/**
 * Unit tests for the tiny_teamsmeeting result_token single-use token.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2026 Enovation Solutions
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers \tiny_teamsmeeting\result_token
 */
final class result_token_test extends advanced_testcase {
    /**
     * Set up test data.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * A freshly generated token validates against the context it was issued for
     * and resolves to the issuing user.
     */
    public function test_valid_token_resolves_to_issuing_user(): void {
        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);

        $token = result_token::generate($user->id, $context->id);

        $this->assertSame((int) $user->id, result_token::validate($token, $context->id));
    }

    /**
     * A token issued for one context is rejected when validated against another.
     */
    public function test_token_rejected_for_wrong_context(): void {
        $user = $this->getDataGenerator()->create_user();
        $course1 = $this->getDataGenerator()->create_course();
        $course2 = $this->getDataGenerator()->create_course();
        $context1 = context_course::instance($course1->id);
        $context2 = context_course::instance($course2->id);

        $token = result_token::generate($user->id, $context1->id);

        $this->assertNull(result_token::validate($token, $context2->id));
    }

    /**
     * A token whose validuntil timestamp has passed is rejected.
     */
    public function test_expired_token_rejected(): void {
        global $DB;

        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);

        $token = result_token::generate($user->id, $context->id);
        $DB->set_field(
            'user_private_key',
            'validuntil',
            time() - 1,
            ['script' => result_token::SCRIPT, 'value' => $token]
        );

        $this->assertNull(result_token::validate($token, $context->id));
    }

    /**
     * A token cannot be validated a second time once it has been consumed.
     */
    public function test_token_cannot_be_replayed(): void {
        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);

        $token = result_token::generate($user->id, $context->id);

        $this->assertSame((int) $user->id, result_token::validate($token, $context->id));
        $this->assertNull(result_token::validate($token, $context->id));
    }

    /**
     * An empty token string is rejected without querying the database.
     */
    public function test_empty_token_rejected(): void {
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);

        $this->assertNull(result_token::validate('', $context->id));
    }
}
