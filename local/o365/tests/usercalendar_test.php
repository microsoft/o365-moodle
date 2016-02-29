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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

class mockusercalendar extends \local_o365\feature\calsync\calendar\user {
	use \local_o365\tests\testableobjecttrait;
	public $tracers = [];

	public function get_tracers() {
		return $this->tracers;
	}

	public function get_api_operations() {
		return $this->calapi->operations;
	}

    protected function mtrace($msg, $trace = null, $eol = "\n") {
    	$this->tracers[] = $trace;
    }
}

class calapi extends \local_o365\feature\calsync\main {
	public $operations = [];

	public function create_event_raw($muserid, $eventid, $subject, $body, $timestart, $timeend, $attendees, array $other = array(), $calid) {
		$this->operations[] = [
			'func' => 'create_event_raw',
			'args' => [
				'muserid' => $muserid,
				'eventid' => $eventid,
				'subject' => $subject,
				'body' => $body,
				'timestart' => $timestart,
				'timeend' => $timeend,
				'attendees' => $attendees,
				'other' => $other,
				'calid' => $calid,
			],
		];
	}

	public function delete_event_raw($muserid, $outlookeventid, $idmaprecid = null) {
		$this->operations[] = [
			'func' => 'delete_event_raw',
			'args' => [
				'muserid' => $muserid,
				'outlookeventid' => $outlookeventid,
				'idmaprecid' => $idmaprecid,
			],
		];
	}
}

/**
 * Tests \local_o365\feature\calsync\task\syncoldevents
 *
 * @group local_o365
 * @group office365
 * @codeCoverageIgnore
 */
class local_o365_usercalendar_testcase extends \advanced_testcase {
	use \local_o365\tests\apitesttrait;

	/**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Construct mock user calendar object.
     *
     * @param int $userid The user id to construct for.
     * @param \local_o365\tests\mockhttpclient $httpclient An httpclient object to use.
     * @return mockusercalendar The constructed user calendar object.
     */
    protected function get_mock_usercalendar($userid, \local_o365\tests\mockhttpclient $httpclient) {
    	global $DB;

    	$tokenrec = [
    		'user_id' => $userid,
    		'token' => 'token',
            'expiry' => time() + 100000,
            'refreshtoken' => 'refreshtoken',
            'scope' => 'scope',
    	];
    	$DB->insert_record('local_o365_token', (object)array_merge($tokenrec, ['resource' => \local_o365\rest\unified::get_resource()]));
    	$DB->insert_record('local_o365_token', (object)array_merge($tokenrec, ['resource' => \local_o365\rest\calendar::get_resource()]));

    	$calapi = new calapi($this->get_mock_clientdata(), $httpclient);
    	return new mockusercalendar($userid, $DB, $calapi);
    }

    /**
     * Test has_been_synced_since.
     */
	public function test_has_been_synced_since() {
		$httpclient = new \local_o365\tests\mockhttpclient();
		$usercalendar = $this->get_mock_usercalendar(1, $httpclient);

		// Test empty config and empty query timestamp.
		$actual = $usercalendar->has_been_synced_since(0);
		$this->assertFalse($actual);

		// Test empty config.
		$actual = $usercalendar->has_been_synced_since(time());
		$this->assertFalse($actual);

		// Test empty config value.
		set_config('cal_user_lastsync', '', 'local_o365');
		$actual = $usercalendar->has_been_synced_since(time());
		$this->assertFalse($actual);

		// Test invalid config value.
		set_config('cal_user_lastsync', 12345, 'local_o365');
		$actual = $usercalendar->has_been_synced_since(time());
		$this->assertFalse($actual);

		// Tests empty array does not work.
		set_config('cal_user_lastsync', serialize([]), 'local_o365');
		$actual = $usercalendar->has_been_synced_since(time());
		$this->assertFalse($actual);

		// Test looks for correct user id.
		set_config('cal_user_lastsync', serialize([2 => 100110]), 'local_o365');
		$actual = $usercalendar->has_been_synced_since(100100);
		$this->assertFalse($actual);

		// Test correct userid with older last sync timestamp.
		set_config('cal_user_lastsync', serialize([1 => 100090]), 'local_o365');
		$actual = $usercalendar->has_been_synced_since(100100);
		$this->assertFalse($actual);

		// Test correct userid with older last sync timestamp.
		set_config('cal_user_lastsync', serialize([1 => 100100]), 'local_o365');
		$actual = $usercalendar->has_been_synced_since(100100);
		$this->assertFalse($actual);

		// Test correct userid with newer last sync timestamp.
		set_config('cal_user_lastsync', serialize([1 => 100110]), 'local_o365');
		$actual = $usercalendar->has_been_synced_since(100100);
		$this->assertTrue($actual);
	}

	/**
	 * Dataprovider for test_save_sync_time
	 *
	 * @return array Array of test parameters.
	 */
	public function dataprovider_save_sync_time() {
		return [
			'Test invalid timestamp (1)' => [
				1,
				null,
				0,
				null,
			],
			'Test invalid timestamp (2)' => [
				1,
				null,
				'test',
				null,
			],
			'Test invalid timestamp with existing data' => [
				1,
				serialize([1 => 123456]),
				'test',
				serialize([1 => 123456]),
			],
			'Test basic saving' => [
				1,
				null,
				100100,
				serialize([1 => 100100]),
			],
			'Test user data is appended to existing data' => [
				1,
				serialize([2 => 123456]),
				100100,
				serialize([2 => 123456, 1 => 100100]),
			],
			'Test older values don\'t overwrite newer values' => [
				2,
				serialize([2 => 123456]),
				100100,
				serialize([2 => 123456]),
			],
			'Test newer values overwrite newer values' => [
				2,
				serialize([2 => 100100]),
				123456,
				serialize([2 => 123456]),
			],
			'Test updating values maintains other data' => [
				2,
				serialize([1 => 123456, 2 => 100100]),
				234567,
				serialize([1 => 123456, 2 => 234567]),
			],
		];
	}

	/**
	 * Test save_sync_time() method.
	 *
	 * @dataProvider dataprovider_save_sync_time
	 * @param int $userid The userid to construct the user calendar for.
	 * @param string $configsetup Initial data to set in config.
	 * @param int $timestamp The timestamp to save.
	 * @param string $expectedconfig The expected data in the config after test.
	 */
	public function test_save_sync_time($userid, $configsetup, $timestamp, $expectedconfig) {
		$httpclient = new \local_o365\tests\mockhttpclient();
		$usercalendar = $this->get_mock_usercalendar($userid, $httpclient);

		if (!empty($configsetup)) {
			set_config('cal_user_lastsync', $configsetup, 'local_o365');
		}

		$usercalendar->save_sync_time($timestamp);

		$actualconfig = get_config('local_o365', 'cal_user_lastsync');

		if (!empty($expectedconfig)) {
			$this->assertEquals($expectedconfig, $actualconfig);
		} else {
			$this->assertEmpty($actualconfig);
		}
	}

	/**
	 * Dataprovider for test_sync_event.
	 *
	 * @return array Array of test parameters.
	 */
	public function dataprovider_sync_event() {
		return [
			'Event not synced, subscription out, primary cal' => [
				1,
				(object)[
					'id' => '2',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => null,
					'origin' => null,
				],
				(object)[
					'syncbehav' => 'out',
					'o365calid' => '111',
					'isprimary' => 1,
				],
				[
					[
						'func' => 'create_event_raw',
						'args' => [
							'muserid' => 1,
							'eventid' => '2',
							'subject' => 'test event',
							'body' => 'test description',
							'timestart' => 100100,
							'timeend' => 100130,
							'attendees' => [],
							'other' => [],
							'calid' => null,
						],
					],
				],
				['se1'],
			],
			'Event not synced, subscription out, non-primary cal' => [
				2,
				(object)[
					'id' => '3',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => null,
					'origin' => null,
				],
				(object)[
					'syncbehav' => 'out',
					'o365calid' => '222',
					'isprimary' => 0,
				],
				[
					[
						'func' => 'create_event_raw',
						'args' => [
							'muserid' => 2,
							'eventid' => '3',
							'subject' => 'test event',
							'body' => 'test description',
							'timestart' => 100100,
							'timeend' => 100130,
							'attendees' => [],
							'other' => [],
							'calid' => '222',
						],
					],
				],
				['se1'],
			],
			'Event not synced, subscription both, primary cal' => [
				1,
				(object)[
					'id' => '2',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => null,
					'origin' => null,
				],
				(object)[
					'syncbehav' => 'both',
					'o365calid' => '111',
					'isprimary' => 1,
				],
				[
					[
						'func' => 'create_event_raw',
						'args' => [
							'muserid' => 1,
							'eventid' => '2',
							'subject' => 'test event',
							'body' => 'test description',
							'timestart' => 100100,
							'timeend' => 100130,
							'attendees' => [],
							'other' => [],
							'calid' => null,
						],
					],
				],
				['se1'],
			],
			'Event not synced, subscription both, non-primary cal' => [
				2,
				(object)[
					'id' => '3',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => null,
					'origin' => null,
				],
				(object)[
					'syncbehav' => 'both',
					'o365calid' => '222',
					'isprimary' => 0,
				],
				[
					[
						'func' => 'create_event_raw',
						'args' => [
							'muserid' => 2,
							'eventid' => '3',
							'subject' => 'test event',
							'body' => 'test description',
							'timestart' => 100100,
							'timeend' => 100130,
							'attendees' => [],
							'other' => [],
							'calid' => '222',
						],
					],
				],
				['se1'],
			],
			'Event not synced, subscription in' => [
				2,
				(object)[
					'id' => '3',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => null,
					'origin' => null,
				],
				(object)[
					'syncbehav' => 'in',
					'o365calid' => '222',
					'isprimary' => 0,
				],
				[],
				['se2'],
			],
			'Event synced, subscription out' => [
				1,
				(object)[
					'id' => '1',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => '222',
					'origin' => 'moodle',
				],
				(object)[
					'syncbehav' => 'out',
					'o365calid' => '111',
					'isprimary' => 1,
				],
				[],
				['se4'],
			],
			'Event synced, subscription both' => [
				1,
				(object)[
					'id' => '1',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => '222',
					'origin' => 'moodle',
				],
				(object)[
					'syncbehav' => 'both',
					'o365calid' => '111',
					'isprimary' => 1,
				],
				[],
				['se4'],
			],
			'Event synced, subscription in' => [
				5,
				(object)[
					'id' => '1',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => '222',
					'origin' => 'moodle',
				],
				(object)[
					'syncbehav' => 'in',
					'o365calid' => '111',
					'isprimary' => 1,
				],
				[
					[
						'func' => 'delete_event_raw',
						'args' => [
							'muserid' => 5,
							'outlookeventid' => '222',
							'idmaprecid' => null,
						],
					],
				],
				['se3'],
			],
			'Event synced, no subscription, moodle event origin' => [
				6,
				(object)[
					'id' => '1',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => '1234',
					'origin' => 'moodle',
				],
				false,
				[
					[
						'func' => 'delete_event_raw',
						'args' => [
							'muserid' => 6,
							'outlookeventid' => '1234',
							'idmaprecid' => null,
						],
					],
				],
				['se5'],
			],
			'Event synced, no subscription, o365 event origin' => [
				6,
				(object)[
					'id' => '1',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => '4321',
					'origin' => 'o365',
				],
				false,
				[],
				['se6'],
			],
			'Event not synced, no subscription' => [
				6,
				(object)[
					'id' => '1',
					'name' => 'test event',
					'description' => 'test description',
					'timestart' => 100100,
					'timeduration' => 30,
				],
				(object)[
					'outlookeventid' => null,
					'origin' => null,
				],
				false,
				[],
				['se7'],
			],
		];
	}

	/**
	 * Test sync_event() method.
	 *
	 * @dataProvider dataprovider_sync_event
	 * @param int $userid The user id to construct the user calendar for.
	 * @param array $event Event recordto test with.
	 * @param array $idmaprec Record from local_o365_calidmap to test with.
	 * @param array $subscription Subscription record to test with.
	 * @param array $expectedoperations The expected API operations performed.
	 * @param array $expectedtracers The expected tracers registered in the usercalendar object.
	 */
	public function test_sync_event($userid, $event, $idmaprec, $subscription, $expectedoperations, $expectedtracers) {
		$httpclient = new \local_o365\tests\mockhttpclient();
		$usercalendar = $this->get_mock_usercalendar($userid, $httpclient);
		$usercalendar->sync_event($event, $idmaprec, $subscription);
		$this->assertEquals($expectedoperations, $usercalendar->get_api_operations());
		$this->assertEquals($expectedtracers, $usercalendar->get_tracers());
	}

	/**
	 * Dataprovider for test_sync.
	 *
	 * @return array Array of test parameters.
	 */
	public function dataprovider_sync() {
		return [
			'Test function checks can_sync()' => [
				1,
				[],
				[],
				[],
				[],
				['s0'],
				null,
				true,
			],
			'Test function works if there are no events' => [
				1,
				[],
				[],
				[],
				[],
				[],
				serialize([1 => 100100]),
			],
			'Test function passed no subscription to sync_event successfully. (no sync operation should occur)' => [
				1,
				[
					[
						'name' => 'Test event 1',
						'description' => 'Test event 1 description',
						'timestart' => 100050,
						'timeduration' => 30,
						'userid' => 1,
					],
				],
				[],
				[],
				[],
				['s1', 'se7'],
				serialize([1 => 100100]),
			],
			'Test function passed subscription to sync_event successfully. (sync operation should occur)' => [
				1,
				[
					[
						'name' => 'Test event 1',
						'description' => 'Test event 1 description',
						'timestart' => 100050,
						'timeduration' => 30,
						'userid' => 1,
					],
				],
				[],
				[
					[
						'user_id' => 1,
						'caltype' => 'user',
						'caltypeid' => 1,
						'syncbehav' => 'both',
						'timecreated' => 100010,
					],
				],
				[
					[
						'func' => 'create_event_raw',
						'args' => [
							'muserid' => 1,
							'eventid' => '252000',
							'subject' => 'Test event 1',
							'body' => 'Test event 1 description',
							'timestart' => '100050',
							'timeend' => '100080',
							'attendees' => [],
							'other' => [],
							'calid' => null,
						],
					],
				],
				['s1', 'se1'],
				serialize([1 => 100100]),
			],
			'Test function passed idmap record to sync_event successfully. (sync already occurred, no new sync should occur)' => [
				1,
				[
					[
						'name' => 'Test event 1',
						'description' => 'Test event 1 description',
						'timestart' => 100050,
						'timeduration' => 30,
						'userid' => 1,
					],
				],
				[
					[
						'outlookeventid' => '3f4f3wfcd',
						'origin' => 'moodle',
						'eventid' => '252000',
						'userid' => 1,
					],
				],
				[
					[
						'user_id' => 1,
						'caltype' => 'user',
						'caltypeid' => 1,
						'syncbehav' => 'both',
						'timecreated' => 100010,
					],
				],
				[],
				['s1', 'se4'],
				serialize([1 => 100100]),
			],
		];
	}

	/**
	 * Test sync() function.
	 * Note: this function pulls together a number of the other, idependantly tested functions, so not all cases are tested here.
	 *
	 * @dataProvider dataprovider_sync
	 * @param int $userid The user id to construct the user calendar for.
	 * @param array $events Event records to create before the test.
	 * @param array $idmaprecs Records to create in local_o365_calidmap before the test.
	 * @param array $subscriptions Subscription records to created before the sync operation.
	 * @param array $expectedoperations The expected API operations performed.
	 * @param array $expectedtracers The expected tracers registered in the usercalendar object.
	 * @param string $expectedconfig The expected value for cal_user_lastsync config setting.
	 */
	public function test_unified_sync($userid, $events, $idmaprecs, $subscriptions, $expectedoperations, $expectedtracers, $expectedconfig, $deletetokens = false) {
		global $DB;
		$timestart = 100100;
		$httpclient = new \local_o365\tests\mockhttpclient();
		$usercalendar = $this->get_mock_usercalendar($userid, $httpclient);

		if ($deletetokens === true) {
			$DB->delete_records('local_o365_token');
		}

		// Insert initial data.
		foreach ($events as $event) {
			$DB->insert_record('event', $event);
		}
		foreach ($idmaprecs as $idmaprec) {
			$DB->insert_record('local_o365_calidmap', $idmaprec);
		}
		foreach ($subscriptions as $subscription) {
			$DB->insert_record('local_o365_calsub', $subscription);
		}

		$usercalendar->sync($timestart);

		$this->assertEquals($expectedoperations, $usercalendar->get_api_operations());
		$this->assertEquals($expectedtracers, $usercalendar->get_tracers());
		$actualconfig = get_config('local_o365', 'cal_user_lastsync');
		if (!empty($expectedconfig)) {
			$this->assertEquals($expectedconfig, $actualconfig);
		} else {
			$this->assertEmpty($actualconfig);
		}
	}

	/**
	 * Dataprovider for test_get_events.
	 *
	 * @return array Array of test parameters.
	 */
	public function dataprovider_get_events() {
		return [
			'Test no events returns no events' => [
				1,
				[],
				[],
				[],
			],
			'Test returns events only for the correct user' => [
				1,
				[
					[
						'name' => 'Test event 1',
						'description' => 'Test event 1 description',
						'timestart' => 100050,
						'timeduration' => 30,
						'userid' => 1,
						'courseid' => 0,
						'groupid' => 0,
					],
					[
						'name' => 'Test event 2',
						'description' => 'Test event 2 description',
						'timestart' => 100050,
						'timeduration' => 30,
						'userid' => 2,
						'courseid' => 0,
						'groupid' => 0,
					],
				],
				[],
				[
					'252000' => [
						'eventid' => '252000',
						'eventname' => 'Test event 1',
						'eventdescription' => 'Test event 1 description',
						'eventtimestart' => 100050,
						'eventtimeduration' => 30,
						'outlookeventid' => null,
						'idmaporigin' => null,
					],
				],
			],
			'Test returns correct idmaprec info as well' => [
				1,
				[
					[
						'name' => 'Test event 1',
						'description' => 'Test event 1 description',
						'timestart' => 100050,
						'timeduration' => 30,
						'userid' => 1,
						'courseid' => 0,
						'groupid' => 0,
					],
					[
						'name' => 'Test event 2',
						'description' => 'Test event 2 description',
						'timestart' => 100050,
						'timeduration' => 30,
						'userid' => 1,
						'courseid' => 0,
						'groupid' => 0,
					],
				],
				[
					[
						'outlookeventid' => 'oeid1',
						'origin' => 'moodle',
						'eventid' => '252000',
						'userid' => 1,
					],
					[
						'outlookeventid' => 'oeid2',
						'origin' => 'o365',
						'eventid' => '252001',
						'userid' => 1,
					],
				],
				[
					'252000' => [
						'eventid' => '252000',
						'eventname' => 'Test event 1',
						'eventdescription' => 'Test event 1 description',
						'eventtimestart' => 100050,
						'eventtimeduration' => 30,
						'outlookeventid' => 'oeid1',
						'idmaporigin' => 'moodle',
					],
					'252001' => [
						'eventid' => '252001',
						'eventname' => 'Test event 2',
						'eventdescription' => 'Test event 2 description',
						'eventtimestart' => 100050,
						'eventtimeduration' => 30,
						'outlookeventid' => 'oeid2',
						'idmaporigin' => 'o365',
					],
				],
			],
		];
	}

	/**
	 * Test get_events() method.
	 *
	 * @dataProvider dataprovider_get_events
	 * @param int $userid The user id to construct the user calendar for.
	 * @param array $events Event records to create before the test.
	 * @param array $idmaprecs Records to create in local_o365_calidmap before the test.
	 * @param array $expectedrecords Expected output.
	 */
	public function test_get_events($userid, $events, $idmaprecs, $expectedrecords) {
		global $DB;
		$httpclient = new \local_o365\tests\mockhttpclient();
		$usercalendar = $this->get_mock_usercalendar($userid, $httpclient);

		// Insert initial data.
		foreach ($events as $event) {
			$DB->insert_record('event', $event);
		}
		foreach ($idmaprecs as $idmaprec) {
			$DB->insert_record('local_o365_calidmap', $idmaprec);
		}

		$actualrs = $usercalendar->get_events();

		// Convert to normal array for better assertion.
		$actual = [];
		foreach ($actualrs as $id => $record) {
			$actual[$id] = (array)$record;
		}

		$this->assertEquals($expectedrecords, $actual);
	}
}
