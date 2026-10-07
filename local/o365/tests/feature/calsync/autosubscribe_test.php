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
 * Test cases for automatic calendar subscription.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\calsync;

use advanced_testcase;

/**
 * Tests automatic calendar subscription.
 *
 * @group local_o365
 * @group office365
 * @covers \local_o365\feature\calsync\autosubscribe
 */
final class autosubscribe_test extends advanced_testcase {
    /**
     * Perform setup before every test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test the site is opt-in unless configured otherwise.
     */
    public function test_is_optout_mode(): void {
        $this->assertFalse(autosubscribe::is_optout_mode());

        set_config('calsyncsubscribemode', autosubscribe::MODE_OPTOUT, 'local_o365');
        $this->assertTrue(autosubscribe::is_optout_mode());

        set_config('calsyncsubscribemode', autosubscribe::MODE_OPTIN, 'local_o365');
        $this->assertFalse(autosubscribe::is_optout_mode());
    }

    /**
     * Test initialising a user enables calendar sync and subscribes to enrolled courses only, once.
     */
    public function test_initialise_user(): void {
        global $DB;

        $user = $this->getDataGenerator()->create_user();
        $course1 = $this->getDataGenerator()->create_course();
        $course2 = $this->getDataGenerator()->create_course();
        $othercourse = $this->getDataGenerator()->create_course();
        $this->getDataGenerator()->enrol_user($user->id, $course1->id);
        $this->getDataGenerator()->enrol_user($user->id, $course2->id);

        $this->assertFalse(autosubscribe::is_initialised($user->id));
        // Personal and course calendars are subscribed to by default.
        $this->assertSame(['user', 'course'], autosubscribe::get_subscribe_types());
        $this->assertSame(3, autosubscribe::initialise_user($user->id));
        $this->assertTrue(autosubscribe::is_initialised($user->id));

        $this->assertTrue($DB->record_exists('local_o365_calsettings', ['user_id' => $user->id]));
        $this->assertEquals(3, $DB->count_records('local_o365_calsub', ['user_id' => $user->id]));

        // Course subscriptions are fetched separately, as caltypeid holds a user id for personal calendars.
        $coursesubs = $DB->get_records(
            'local_o365_calsub',
            ['user_id' => $user->id, 'caltype' => 'course'],
            '',
            'caltypeid, syncbehav, isprimary'
        );
        $this->assertCount(2, $coursesubs);
        $this->assertArrayHasKey($course1->id, $coursesubs);
        $this->assertArrayHasKey($course2->id, $coursesubs);
        $this->assertArrayNotHasKey($othercourse->id, $coursesubs);
        $this->assertEquals('out', $coursesubs[$course1->id]->syncbehav);
        $this->assertEquals(1, $coursesubs[$course1->id]->isprimary);
        $this->assertTrue($DB->record_exists('local_o365_calsub', [
            'user_id' => $user->id, 'caltype' => 'user', 'caltypeid' => $user->id,
        ]));
        $this->assertFalse($DB->record_exists('local_o365_calsub', ['user_id' => $user->id, 'caltype' => 'site']));

        $this->assertNull(autosubscribe::initialise_user($user->id));
    }

    /**
     * Test only the calendar types chosen by the admin are subscribed to.
     */
    public function test_initialise_user_respects_chosen_types(): void {
        global $DB;

        set_config('calsyncsubscribetypes', 'site', 'local_o365');
        $this->assertSame(['site'], autosubscribe::get_subscribe_types());

        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();
        $this->getDataGenerator()->enrol_user($user->id, $course->id);

        $this->assertSame(1, autosubscribe::initialise_user($user->id));
        $subs = $DB->get_records('local_o365_calsub', ['user_id' => $user->id]);
        $this->assertCount(1, $subs);
        $this->assertEquals('site', reset($subs)->caltype);

        set_config('calsyncsubscribetypes', '', 'local_o365');
        $this->assertSame([], autosubscribe::get_subscribe_types());
    }

    /**
     * Test a user who has already made their own choice is not initialised.
     */
    public function test_initialise_user_respects_existing_choice(): void {
        global $DB;

        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();
        $this->getDataGenerator()->enrol_user($user->id, $course->id);

        autosubscribe::mark_initialised($user->id);

        $this->assertNull(autosubscribe::initialise_user($user->id));
        $this->assertFalse($DB->record_exists('local_o365_calsettings', ['user_id' => $user->id]));
        $this->assertFalse($DB->record_exists('local_o365_calsub', ['user_id' => $user->id]));
    }

    /**
     * Test subscribing to a course twice only creates one subscription.
     */
    public function test_subscribe_course_is_idempotent(): void {
        global $DB;

        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();

        $this->assertTrue(autosubscribe::subscribe_course($user->id, $course->id));
        $this->assertFalse(autosubscribe::subscribe_course($user->id, $course->id));
        $this->assertEquals(1, $DB->count_records('local_o365_calsub', ['user_id' => $user->id]));
    }
}
