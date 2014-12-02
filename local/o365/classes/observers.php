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
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

namespace local_o365;

require_once($CFG->dirroot.'/lib/filelib.php');

/**
 * Handles events.
 */
class observers {
	/**
	 * Handles logins from the OIDC auth plugin.
	 *
	 * @param \auth_oidc\event\user_loggedin $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_oidc_login(\auth_oidc\event\user_loggedin $event) {
		global $DB;

		// Auth_oidc config gives us the client credentials and token endpoint.
		$oidcconfig = get_config('auth_oidc');
		if (empty($oidcconfig)) {
			return false;
		}
		if (empty($oidcconfig->clientid) || empty($oidcconfig->clientsecret) || empty($oidcconfig->tokenendpoint)) {
			return false;
		}

		// We need a username to get the existing token.
		$eventdata = $event->get_data();
		if (empty($eventdata['other']['username'])) {
			return false;
		}

		// The token record created/updated on login by auth_oidc.
		$oidctokenrec = $DB->get_record('auth_oidc_token', ['username' => $eventdata['other']['username']]);
		if (empty($oidctokenrec) || empty($oidctokenrec->authcode)) {
			return false;
		}

		// Assemble resources.
		$resources = [\local_o365\rest\calendar::get_resource()];
		if (\local_o365\rest\onedrive::is_configured() !== false) {
			$resources[] = \local_o365\rest\onedrive::get_resource();
		}
		if (\local_o365\rest\sharepoint::is_configured() !== false) {
			$resources[] = \local_o365\rest\sharepoint::get_resource();
		}

		foreach ($resources as $resource) {
			// Request outlook token.
			$httpclient = new \local_o365\httpclient();
			$params = [
				'client_id' => $oidcconfig->clientid,
				'client_secret' => $oidcconfig->clientsecret,
				'grant_type' => 'authorization_code',
				'code' => $oidctokenrec->authcode,
				'resource' => $resource,
			];
			$tokenresult = $httpclient->post($oidcconfig->tokenendpoint, $params);
			$tokenresult = @json_decode($tokenresult, true);
			if (empty($tokenresult) || !is_array($tokenresult)) {
				return false;
			}

			// Create/update the stored outlook token record.
			$o365tokenrec = $DB->get_record('local_o365_token', ['user_id' => $eventdata['userid'], 'resource' => $resource]);
	        if (!empty($o365tokenrec)) {
	            $o365tokenrec->scope = $tokenresult['scope'];
	            $o365tokenrec->token = $tokenresult['access_token'];
	            $o365tokenrec->expiry = $tokenresult['expires_on'];
	            $o365tokenrec->refreshtoken = $tokenresult['refresh_token'];
	            $DB->update_record('local_o365_token', $o365tokenrec);
	        } else {
	            $o365tokenrec = new \stdClass;
	            $o365tokenrec->user_id = $eventdata['userid'];
	            $o365tokenrec->resource = $tokenresult['resource'];
	            $o365tokenrec->scope = $tokenresult['scope'];
	            $o365tokenrec->token = $tokenresult['access_token'];
	            $o365tokenrec->expiry = $tokenresult['expires_on'];
	            $o365tokenrec->refreshtoken = $tokenresult['refresh_token'];
	            $o365tokenrec->id = $DB->insert_record('local_o365_token', $o365tokenrec);
	        }
		}

        return true;
	}

	/**
	 * Handles auths from the OIDC auth plugin.
	 *
	 * This is mostly used when setting a system API user.
	 *
	 * @param \auth_oidc\event\user_authed $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_oidc_authed(\auth_oidc\event\user_authed $event) {
		$eventdata = $event->get_data();

		$tokendata = [
			'idtoken' => $eventdata['other']['tokenparams']['id_token'],
			$eventdata['other']['tokenparams']['resource'] => [
				'token' => $eventdata['other']['tokenparams']['access_token'],
				'scope' => $eventdata['other']['tokenparams']['scope'],
				'refreshtoken' => $eventdata['other']['tokenparams']['refresh_token'],
				'resource' => $eventdata['other']['tokenparams']['resource'],
				'expiry' => $eventdata['other']['tokenparams']['expires_on'],
			]
		];

		set_config('systemtokens', serialize($tokendata), 'local_o365');
		set_config('sharepoint_initialized', '0', 'local_o365');
		redirect(new \moodle_url('/admin/settings.php?section=local_o365'));
	}

	/**
	 * Handle a calendar_event_created event.
	 *
	 * @param \core\event\calendar_event_created $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_calendar_event_created(\core\event\calendar_event_created $event) {
		global $DB;

		// Construct calendar client.
		$tokenparams = ['user_id' => $event->userid, 'resource' => \local_o365\rest\calendar::get_resource()];
		$tokenrec = $DB->get_record('local_o365_token', $tokenparams);
		if (empty($tokenrec)) {
			return true;
		}
		$oidcconfig = get_config('auth_oidc');
		$httpclient = new \local_o365\httpclient();
		$clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
		$token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken, $tokenrec->scope, $tokenrec->resource, $clientdata, $httpclient);
		$cal = new \local_o365\rest\calendar($token, $httpclient);

		// Assemble basic event data.
		$event = $DB->get_record('event', ['id' => $event->objectid]);
		$subject = $event->name;
		$body = $event->description;
		$timestart = $event->timestart;
		$timeend = $timestart + $event->timeduration;

		// Get attendees.
		if (isset($event->courseid) && $event->courseid == SITEID) {
			// Site event.
			$subscribedsql = 'SELECT u.id, u.email, u.firstname, u.lastname
								FROM {user} u
								JOIN {local_o365_calsub} sub ON sub.user_id = u.id AND sub.caltype = "site"';
			$attendees = $DB->get_records_sql($subscribedsql);
		} elseif (isset($event->courseid) && $event->courseid != SITEID && $event->courseid > 0) {
			// Course event - Get subscribed students.
			$subscribedsql = 'SELECT u.id, u.email, u.firstname, u.lastname
			                    FROM {user} u
							    JOIN {user_enrolments} ue ON ue.userid = u.id
							    JOIN {enrol} e ON e.id = ue.enrolid
							    JOIN {local_o365_calsub} sub ON sub.user_id = u.id AND sub.caltype = "course" AND sub.caltypeid = e.courseid
							   WHERE e.courseid = ?';
			$attendees = $DB->get_records_sql($subscribedsql, [$event->courseid]);
		} else {
			// Personal user event. Only sync if user is subscribed to their events.
			if (!$DB->record_exists('local_o365_calsub', ['caltype' => 'user', 'user_id' => $event->userid])) {
				return true;
			} else {
				$attendees = [];
			}
		}

		// Send event to o365.
		$response = $cal->create_event($subject, $body, $timestart, $timeend, $attendees);

		// Store ID
		if (!empty($response) && is_array($response)) {
			if (isset($response['Id'])) {
				$idmaprec = [
					'eventid' => $event->id,
					'outlookeventid' => $response['Id'],
				];
				$DB->insert_record('local_o365_calidmap', (object)$idmaprec);
			}
		}
		return true;
	}

	/**
	 * Handle a calendar_event_updated event.
	 *
	 * @param \core\event\calendar_event_updated $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_calendar_event_updated(\core\event\calendar_event_updated $event) {
		global $DB;

		// Get o365 event id (and determine if we can sync this event).
		$idmaprecs = $DB->get_records('local_o365_calidmap', ['eventid' => $event->objectid]);
		if (empty($idmaprecs)) {
			return true;
		}

		// Construct calendar client.
		$tokenparams = ['user_id' => $event->userid, 'resource' => \local_o365\rest\calendar::get_resource()];
		$tokenrec = $DB->get_record('local_o365_token', $tokenparams);
		if (empty($tokenrec)) {
			return true;
		}
		$oidcconfig = get_config('auth_oidc');
		$httpclient = new \local_o365\httpclient();
		$clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
		$token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken, $tokenrec->scope, $tokenrec->resource, $clientdata, $httpclient);
		$cal = new \local_o365\rest\calendar($token, $httpclient);

		// Send updated information to o365.
		$event = $DB->get_record('event', ['id' => $event->objectid]);
		$updated = [
			'subject' => $event->name,
			'body' => $event->description,
			'starttime' => $event->timestart,
			'endtime' => $event->timestart + $event->timeduration,
		];

		foreach ($idmaprecs as $idmaprec) {
			$response = $cal->update_event($idmaprec->outlookeventid, $updated);
		}
		return true;
	}

	/**
	 * Handle a calendar_event_deleted event.
	 *
	 * @param \core\event\calendar_event_deleted $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_calendar_event_deleted(\core\event\calendar_event_deleted $event) {
		global $DB;

		// Get o365 event ids (and determine if we can sync this event).
		$idmaprecs = $DB->get_records('local_o365_calidmap', ['eventid' => $event->objectid]);
		if (empty($idmaprecs)) {
			return true;
		}

		// Construct calendar client.
		$tokenparams = ['user_id' => $event->userid, 'resource' => \local_o365\rest\calendar::get_resource()];
		$tokenrec = $DB->get_record('local_o365_token', $tokenparams);
		if (empty($tokenrec)) {
			return true;
		}
		$oidcconfig = get_config('auth_oidc');
		$httpclient = new \local_o365\httpclient();
		$clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
		$token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken, $tokenrec->scope, $tokenrec->resource, $clientdata, $httpclient);
		$cal = new \local_o365\rest\calendar($token, $httpclient);

		foreach ($idmaprecs as $idmaprec) {
			$response = $cal->delete_event($idmaprec->outlookeventid);
		}

		// Clean up idmap table.
		$DB->delete_records('local_o365_calidmap', ['eventid' => $event->objectid]);

		return true;
	}

	/**
	 * Handle calendar_subscribed event - queue calendar sync jobs for cron.
	 *
	 * @param \local_o365\event\calendar_subscribed $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_calendar_subscribed(\local_o365\event\calendar_subscribed $event) {
		global $DB;
		$eventdata = $event->get_data();
		$cronop = [
			'operation' => 'calendarsubscribe',
			'data' => serialize([
				'caltype' => $eventdata['other']['caltype'],
				'caltypeid' => ((isset($eventdata['other']['caltypeid'])) ? $eventdata['other']['caltypeid'] : 0),
				'userid' => $eventdata['userid'],
			]),
			'timecreated' => time(),
		];
		$DB->insert_record('local_o365_cronqueue', (object)$cronop);
		return true;
	}

	/**
	 * Handle calendar_unsubscribed event - queue calendar sync jobs for cron.
	 *
	 * @param \local_o365\event\calendar_unsubscribed $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_calendar_unsubscribed(\local_o365\event\calendar_unsubscribed $event) {
		global $DB;
		$eventdata = $event->get_data();
		$cronop = [
			'operation' => 'calendarunsubscribe',
			'data' => serialize([
				'caltype' => $eventdata['other']['caltype'],
				'caltypeid' => ((isset($eventdata['other']['caltypeid'])) ? $eventdata['other']['caltypeid'] : 0),
				'userid' => $eventdata['userid'],
			]),
			'timecreated' => time(),
		];
		$DB->insert_record('local_o365_cronqueue', (object)$cronop);
		return true;
	}

	/**
	 * Handle user_enrolment_deleted event - clean up calendar subscriptions.
	 *
	 * @param \core\event\user_enrolment_deleted $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_user_enrolment_deleted(\core\event\user_enrolment_deleted $event) {
		global $DB;
		$userid = $event->relateduserid;
		$courseid = $event->courseid;

		$calsubparams = ['user_id' => $userid, 'caltype' => 'course', 'caltypeid' => $courseid];
		$subscriptions = $DB->get_recordset('local_o365_calsub', $calsubparams);
		foreach ($subscriptions as $subscription) {
            $eventdata = [
            	'objectid' => $subscription->id,
            	'userid' => $userid,
            	'other' => [
            		'caltype' => 'course',
            		'caltypeid' => $courseid
            	]
            ];
            $event = \local_o365\event\calendar_unsubscribed::create($eventdata);
            $event->trigger();
		}
		$subscriptions->close();
		$DB->delete_records('local_o365_calsub', $calsubparams);
		return true;
	}

	/**
	 * Handle course_deleted event - clean up calendar subscriptions.
	 *
	 * @param \core\event\course_deleted $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_course_deleted(\core\event\course_deleted $event) {
		global $DB;
		$DB->delete_records('local_o365_calsub', ['caltype' => 'course', 'caltypeid' => $event->objectid]);
		return true;
	}

	/**
	 * Handle auth_oidc user_created event - get additional information.
	 *
	 * @param \auth_oidc\event\user_created $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_oidc_user_created(\auth_oidc\event\user_created $event) {
		global $DB;
		$eventdata = $event->get_data();

		$oidcconfig = get_config('auth_oidc');
		if (\local_o365\rest\azuread::is_configured() !== true || empty($oidcconfig)) {
			return true;
		}

		$aadresource = \local_o365\rest\azuread::get_resource();
		$tokenparams = ['username' => $eventdata['other']['username'], 'resource' => $aadresource];
		$tokenrec = $DB->get_record('auth_oidc_token', $tokenparams);
		$httpclient = new \local_o365\httpclient();
		$clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
		$token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken,
				$tokenrec->scope, $tokenrec->resource, $clientdata, $httpclient);
		$apiclient = new \local_o365\rest\azuread($token, $httpclient);

		$aaduserdata = $apiclient->get_user($tokenrec->oidcuniqid);
		if (!empty($aaduserdata)) {
			$updateduser = [];

			$parammap = [
				'mail' => 'email',
				'city' => 'city',
				'country' => 'country',
				'department' => 'department',
			];
			foreach ($parammap as $aadparam => $moodleparam) {
				if (!empty($aaduserdata[$aadparam])) {
					$updateduser[$moodleparam] = $aaduserdata[$aadparam];
				}
			}

			if (!empty($updateduser)) {
				$updateduser['id'] = $event->userid;
				$DB->update_record('user', (object)$updateduser);
			}
		}
	}

	/**
	 * Handle user_deleted event - clean up calendar subscriptions.
	 *
	 * @param \core\event\user_deleted $event The triggered event.
	 * @return bool Success/Failure.
	 */
	public static function handle_user_deleted(\core\event\user_deleted $event) {
		global $DB;
		$DB->delete_records('local_o365_calsub', ['user_id' => $event->objectid]);
		$DB->delete_records('local_o365_token', ['user_id' => $event->objectid]);
		return true;
	}
}
