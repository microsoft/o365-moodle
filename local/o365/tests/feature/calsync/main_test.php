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

namespace local_o365\feature\calsync;

use advanced_testcase;
use local_o365\oauth2\clientdata;
use local_o365\rest\unified;
use local_o365\tests\mockhttpclient;
use ReflectionMethod;
use stdClass;

/**
 * Unit tests for how course calendar events are synced to Outlook.
 *
 * @package   local_o365
 * @copyright Enovation Solutions Ltd. {@link https://enovation.ie}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \local_o365\feature\calsync\main
 * @group local_o365
 * @group office365
 */
final class main_test extends advanced_testcase {
    /**
     * Create the calendar sync helper, with no real API access.
     *
     * @return main
     */
    protected function get_main(): main {
        return new main(self::createMock(clientdata::class), new mockhttpclient());
    }

    /**
     * Create a Moodle user connected to a Microsoft account.
     *
     * @return stdClass The user.
     */
    protected function create_linked_user(): stdClass {
        global $DB;

        $user = $this->getDataGenerator()->create_user();
        $DB->insert_record('auth_oidc_token', (object) [
            'oidcuniqid' => 'uniqid' . $user->id,
            'username' => $user->username,
            'userid' => $user->id,
            'oidcusername' => $user->username . '@example.onmicrosoft.com',
            'useridentifier' => $user->username . '@example.onmicrosoft.com',
            'scope' => 'test',
            'tokenresource' => unified::get_tokenresource(),
            'authcode' => '000',
            'token' => '000',
            'expiry' => 9999999999,
            'refreshtoken' => 'refresh',
            'idtoken' => 'idtoken',
        ]);

        return $user;
    }

    /**
     * Add a course calendar subscription for a user.
     *
     * @param int $userid The user's ID.
     * @param int $courseid The course's ID.
     * @param int $isprimary Whether they sync to their default calendar.
     * @return void
     */
    protected function subscribe_to_course(int $userid, int $courseid, int $isprimary): void {
        global $DB;

        $DB->insert_record('local_o365_calsub', (object) [
            'user_id' => $userid,
            'caltype' => 'course',
            'caltypeid' => $courseid,
            'o365calid' => 'calendar' . $userid,
            'syncbehav' => 'out',
            'isprimary' => $isprimary,
            'timecreated' => time(),
        ]);
    }

    /**
     * Record that an Outlook event was created for a Moodle event.
     *
     * @param int $eventid The Moodle event's ID.
     * @param int $userid The user the Outlook event belongs to.
     * @return int The mapping's ID.
     */
    protected function add_idmap(int $eventid, int $userid): int {
        global $DB;

        return $DB->insert_record('local_o365_calidmap', (object) [
            'eventid' => $eventid,
            'outlookeventid' => 'outlook' . $eventid . '-' . $userid,
            'userid' => $userid,
            'origin' => 'moodle',
        ]);
    }

    /**
     * Call a protected method.
     *
     * @param main $main The object.
     * @param string $method The method name.
     * @param array $args The arguments.
     * @return mixed The result.
     */
    protected function call_protected(main $main, string $method, array $args) {
        $reflection = new ReflectionMethod($main, $method);
        $reflection->setAccessible(true);

        return $reflection->invokeArgs($main, $args);
    }

    /**
     * Course events are only synced individually if the site is set to, and shared otherwise.
     *
     * @return void
     * @covers ::use_individual_course_events
     */
    public function test_use_individual_course_events(): void {
        $this->resetAfterTest();
        $main = $this->get_main();

        $this->assertFalse($main->use_individual_course_events());

        set_config('calsync_courseeventmode', 'shared', 'local_o365');
        $this->assertFalse($main->use_individual_course_events());

        set_config('calsync_courseeventmode', 'individual', 'local_o365');
        $this->assertTrue($main->use_individual_course_events());
    }

    /**
     * Course events are synced individually if the site is set to, or if the creator can't create the shared event.
     *
     * @return void
     * @covers ::sync_course_event_individually
     */
    public function test_sync_course_event_individually(): void {
        $this->resetAfterTest();
        $course = $this->getDataGenerator()->create_course();
        $linked = $this->create_linked_user();
        $unlinked = $this->getDataGenerator()->create_user();

        $linkedevent = (object) ['userid' => $linked->id, 'courseid' => $course->id];
        $unlinkedevent = (object) ['userid' => $unlinked->id, 'courseid' => $course->id];

        // Shared mode: only an unlinked creator forces individual events.
        $this->assertFalse($this->get_main()->sync_course_event_individually($linkedevent));
        $this->assertTrue($this->get_main()->sync_course_event_individually($unlinkedevent));

        // Individual mode: always.
        set_config('calsync_courseeventmode', 'individual', 'local_o365');
        $this->assertTrue($this->get_main()->sync_course_event_individually($linkedevent));
        $this->assertTrue($this->get_main()->sync_course_event_individually($unlinkedevent));
    }

    /**
     * An event with a creator is created as that creator.
     *
     * @return void
     * @covers ::get_event_owner_userid
     */
    public function test_get_event_owner_userid_uses_event_user(): void {
        $this->resetAfterTest();
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();

        $event = (object) ['userid' => $user->id, 'courseid' => $course->id];
        $this->assertSame((int) $user->id, $this->get_main()->get_event_owner_userid($event));
    }

    /**
     * An event with no user (as mod_assign leaves them) is created as a course teacher with a Microsoft account.
     *
     * @return void
     * @covers ::get_event_owner_userid
     */
    public function test_get_event_owner_userid_falls_back_to_linked_teacher(): void {
        $this->resetAfterTest();
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $event = (object) ['userid' => 0, 'courseid' => $course->id];

        // No teachers at all.
        $this->assertSame(0, $this->get_main()->get_event_owner_userid($event));

        // A teacher without a Microsoft account doesn't count.
        $unlinkedteacher = $generator->create_user();
        $generator->enrol_user($unlinkedteacher->id, $course->id, 'editingteacher');
        $this->assertSame(0, $this->get_main()->get_event_owner_userid($event));

        // A student with a Microsoft account doesn't count either.
        $student = $this->create_linked_user();
        $generator->enrol_user($student->id, $course->id, 'student');
        $this->assertSame(0, $this->get_main()->get_event_owner_userid($event));

        $linkedteacher = $this->create_linked_user();
        $generator->enrol_user($linkedteacher->id, $course->id, 'editingteacher');
        $this->assertSame((int) $linkedteacher->id, $this->get_main()->get_event_owner_userid($event));
    }

    /**
     * Site events and events with no course have no teacher to fall back to.
     *
     * @return void
     * @covers ::get_event_owner_userid
     */
    public function test_get_event_owner_userid_without_course(): void {
        $this->resetAfterTest();

        $this->assertSame(0, $this->get_main()->get_event_owner_userid((object) ['userid' => 0, 'courseid' => 0]));
        $this->assertSame(0, $this->get_main()->get_event_owner_userid((object) ['userid' => 0, 'courseid' => SITEID]));
    }

    /**
     * An existing shared event keeps its owner, whatever the event's user has since become.
     *
     * Individually synced events only belong to users subscribed to the course calendar, so a mapping for anyone
     * else is the shared event.
     *
     * @return void
     * @covers ::get_event_owner_userid
     */
    public function test_get_event_owner_userid_prefers_existing_shared_event(): void {
        $this->resetAfterTest();
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $owner = $this->create_linked_user();
        $subscriber = $this->create_linked_user();
        $editor = $this->create_linked_user();
        $this->subscribe_to_course($subscriber->id, $course->id, 0);

        $event = (object) ['id' => 501, 'userid' => $editor->id, 'courseid' => $course->id];

        // Only a subscriber's (individual) mapping exists: the event's own user is used.
        $this->add_idmap(501, $subscriber->id);
        $this->assertSame((int) $editor->id, $this->get_main()->get_event_owner_userid($event));

        // Once the shared event's mapping exists, its owner is used instead.
        $this->add_idmap(501, $owner->id);
        $this->assertSame((int) $owner->id, $this->get_main()->get_event_owner_userid($event));

        // Also when the event has no user at all.
        $event->userid = 0;
        $this->assertSame((int) $owner->id, $this->get_main()->get_event_owner_userid($event));
    }

    /**
     * An owner who is subscribed to the course's default calendar still owns the shared event.
     *
     * Only a non-primary subscription means a mapping is an individual event.
     *
     * @return void
     * @covers ::get_event_owner_userid
     */
    public function test_get_event_owner_userid_finds_owner_with_primary_subscription(): void {
        $this->resetAfterTest();
        $course = $this->getDataGenerator()->create_course();
        $owner = $this->create_linked_user();
        $editor = $this->create_linked_user();
        $this->subscribe_to_course($owner->id, $course->id, 1);

        $event = (object) ['id' => 502, 'userid' => $editor->id, 'courseid' => $course->id];
        $this->add_idmap(502, $owner->id);

        $this->assertSame((int) $owner->id, $this->get_main()->get_event_owner_userid($event));
    }

    /**
     * The shared event's mapping is told apart from individually synced ones.
     *
     * @return void
     * @covers ::is_shared_event_mapping
     */
    public function test_is_shared_event_mapping(): void {
        $this->resetAfterTest();
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $creator = $this->create_linked_user();
        $primary = $this->create_linked_user();
        $nonprimary = $this->create_linked_user();
        $this->subscribe_to_course($primary->id, $course->id, 1);
        $this->subscribe_to_course($nonprimary->id, $course->id, 0);

        $event = (object) ['id' => 601, 'userid' => $creator->id, 'courseid' => $course->id];
        $main = $this->get_main();

        $mapping = fn(int $userid) => (object) ['userid' => $userid];

        // The creator's mapping.
        $this->assertTrue($this->call_protected($main, 'is_shared_event_mapping', [$event, $mapping($creator->id)]));
        // Someone not subscribed to a non-primary calendar can't have an individual event, so it's the shared one.
        $this->assertTrue($this->call_protected($main, 'is_shared_event_mapping', [$event, $mapping($primary->id)]));
        // A non-primary subscriber's own event is an individual event.
        $this->assertFalse($this->call_protected($main, 'is_shared_event_mapping', [$event, $mapping($nonprimary->id)]));

        // The event's user is no longer the one the shared event was created as.
        $event->userid = 0;
        $this->assertTrue($this->call_protected($main, 'is_shared_event_mapping', [$event, $mapping($creator->id)]));
        $this->assertFalse($this->call_protected($main, 'is_shared_event_mapping', [$event, $mapping($nonprimary->id)]));
    }

    /**
     * Site and personal events never have a shared event.
     *
     * @return void
     * @covers ::is_shared_event_mapping
     */
    public function test_is_shared_event_mapping_for_non_course_events(): void {
        $this->resetAfterTest();
        $creator = $this->create_linked_user();
        $other = $this->create_linked_user();
        $main = $this->get_main();

        $siteevent = (object) ['id' => 701, 'userid' => $creator->id, 'courseid' => SITEID];
        $personalevent = (object) ['id' => 702, 'userid' => $creator->id, 'courseid' => 0];

        foreach ([$siteevent, $personalevent] as $event) {
            $mapping = (object) ['userid' => $other->id];
            $this->assertFalse($this->call_protected($main, 'is_shared_event_mapping', [$event, $mapping]));
        }
    }
}
