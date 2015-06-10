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

namespace local_o365\feature\calsync;

class main {
    protected $clientdata = null;
    protected $httpclient = null;

    public function __construct(\local_o365\oauth2\clientdata $clientdata = null, \local_o365\httpclient $httpclient = null) {
        $this->clientdata = (!empty($clientdata)) ? $clientdata : \local_o365\oauth2\clientdata::instance_from_oidc();
        $this->httpclient = (!empty($httpclient)) ? $httpclient : new \local_o365\httpclient();
    }

	/**
     * Construct a calendar API client using the system API user.
     *
     * @param int $muserid The userid to get the outlook token for.
     * @return \local_o365\rest\o365api|bool A constructed calendar API client (unified or legacy), or false if error.
     */
    public function construct_calendar_api($muserid, $systemfallback = true) {
        $unifiedconfigured = \local_o365\rest\unified::is_configured();
        if ($unifiedconfigured === true) {
            $resource = \local_o365\rest\unified::get_resource();
        } else {
            $resource = \local_o365\rest\calendar::get_resource();
        }

        $token = \local_o365\oauth2\token::instance($muserid, $resource, $this->clientdata, $this->httpclient);
        if (empty($token) && $systemfallback === true) {
            $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $this->clientdata, $this->httpclient);
        }
        if (empty($token)) {
            throw new \Exception('No token available for user #'.$muserid);
        }

        if ($unifiedconfigured === true) {
            $apiclient = new \local_o365\rest\unified($token, $this->httpclient);
        } else {
            $apiclient = new \local_o365\rest\calendar($token, $this->httpclient);
        }
        return $apiclient;
    }

    /**
     * Get a token that can be used for calendar syncing.
     *
     * @param int $muserid The ID of a Moodle user to get a token for.
     * @return \local_o365\oauth2\token|null Either a token for calendar syncing, or null if no token could be retrieved.
     */
    public function get_user_token($muserid) {
        $outlookresource = \local_o365\rest\calendar::get_resource();
        $usertoken = \local_o365\oauth2\token::instance($muserid, $outlookresource, $this->clientdata, $this->httpclient);
        return (!empty($usertoken)) ? $usertoken : null;
    }

    /**
     * Ensures an event is synced for a *single* user.
     *
     * @param int $eventid The ID of the event.
     * @param int $muserid The ID of the user who will own the event.
     * @param string $subject The event's subject.
     * @param string $body The body text of the event.
     * @param int $timestart The timestamp for the event's start.
     * @param int $timeend The timestamp for the event's end.
     * @param string $calid The o365 ID of the calendar to create the event in.
     * @return int The new ID from local_o365_calidmap.
     */
    public function ensure_event_synced_for_user($eventid, $muserid, $subject, $body, $timestart, $timeend, $calid) {
        global $DB;
        $eventsynced = $DB->record_exists('local_o365_calidmap', ['eventid' => $eventid, 'userid' => $muserid]);
        if (!$eventsynced) {
            return $this->create_event_raw($muserid, $eventid, $subject, $body, $timestart, $timeend, [], [], $calid);
        }
    }

    /**
     * Create a calendar event, including all needed local information.
     *
     * @param int $muserid The ID of the Moodle user to communicate as.
     * @param int $eventid The ID of the Moodle event to link to the Outlook event.
     * @param string $subject The event's title/subject.
     * @param string $body The event's body/description.
     * @param int $starttime The timestamp when the event starts.
     * @param int $endtime The timestamp when the event ends.
     * @param array $attendees Array of moodle user objects that are attending the event.
     * @param array $other Other parameters to include.
     * @param string $calid The o365 ID of the calendar to create the event in.
     * @return int The new ID of the calidmap record.
     */
    public function create_event_raw($muserid, $eventid, $subject, $body, $timestart, $timeend, $attendees, array $other = array(), $calid) {
        global $DB;
        $apiclient = $this->construct_calendar_api($muserid, true);
        $response = $apiclient->create_event($subject, $body, $timestart, $timeend, $attendees, $other, $calid);
        if (!empty($response) && is_array($response) && isset($response['Id'])) {
            $idmaprec = [
                'eventid' => $eventid,
                'outlookeventid' => $response['Id'],
                'userid' => $muserid,
                'origin' => 'moodle',
            ];
            return $DB->insert_record('local_o365_calidmap', (object)$idmaprec);
        }
    }

    /**
     * Update an event.
     *
     * @param int $muserid The ID of the Moodle user to communicate as.
     * @param string $outlookeventid The event ID in o365 outlook.
     * @param array $updated Array of updated information. Keys are 'subject', 'body', 'starttime', 'endtime', and 'attendees'.
     * @return array|null Returned response, or null if error.
     */
    public function update_event_raw($muserid, $outlookeventid, $updated) {
        $apiclient = $this->construct_calendar_api($muserid, true);
        $apiclient->update_event($outlookeventid, $updated);
    }

    /**
     * Delete an event.
     *
     * @param string $outlookeventid The event ID in o365 outlook.
     * @return bool Success/Failure.
     */
    public function delete_event_raw($muserid, $outlookeventid, $idmaprecid = null) {
        global $DB;
        $apiclient = $this->construct_calendar_api($muserid, true);
        $response = $apiclient->delete_event($outlookeventid);
        if (!empty($idmaprecid)) {
            $DB->delete_records('local_o365_calidmap', ['id' => $idmaprecid]);
        } else {
            $DB->delete_records('local_o365_calidmap', ['outlookeventid' => $outlookeventid]);
        }
    }

    /**
     * Create an outlook event for a newly created Moodle event.
     *
     * @param int $moodleventid The ID of the newly created Moodle event.
     * @return bool Success/Failure.
     */
    public function create_outlook_event_from_moodle_event($moodleventid) {
        global $DB;

        // Assemble basic event data.
        $event = $DB->get_record('event', ['id' => $moodleventid]);
        $subject = $event->name;
        $body = $event->description;
        $timestart = $event->timestart;
        $timeend = $timestart + $event->timeduration;

        // Get attendees.
        if (isset($event->courseid) && $event->courseid == SITEID) {
            // Site event.
            $sql = 'SELECT u.id,
                           u.id as userid,
                           u.email,
                           u.firstname,
                           u.lastname,
                           sub.isprimary as subisprimary,
                           sub.o365calid as subo365calid
                      FROM {user} u
                      JOIN {local_o365_calsub} sub ON sub.user_id = u.id
                     WHERE sub.caltype = ? AND (sub.syncbehav = ? OR sub.syncbehav = ?)';
            $params = ['site', 'out', 'both'];
            $attendees = $DB->get_records_sql($sql, $params);
        } else if (isset($event->courseid) && $event->courseid != SITEID && $event->courseid > 0) {
            // Course event - Get subscribed students.
            if (!empty($event->groupid)) {
                $sql = 'SELECT u.id,
                               u.id as userid,
                               u.email,
                               u.firstname,
                               u.lastname,
                               sub.isprimary as subisprimary,
                               sub.o365calid as subo365calid
                          FROM {user} u
                          JOIN {user_enrolments} ue ON ue.userid = u.id
                          JOIN {enrol} e ON e.id = ue.enrolid
                          JOIN {local_o365_calsub} sub ON sub.user_id = u.id
                               AND sub.caltype = ?
                               AND sub.caltypeid = e.courseid
                               AND (sub.syncbehav = ? OR sub.syncbehav = ?)
                          JOIN {groups_members} grpmbr ON grpmbr.userid = u.id
                         WHERE e.courseid = ? AND grpmbr.groupid = ?';
                $params = ['course', 'out', 'both', $event->courseid, $event->groupid];
                $attendees = $DB->get_records_sql($sql, $params);
            } else {
                $sql = 'SELECT u.id,
                               u.id as userid,
                               u.email,
                               u.firstname,
                               u.lastname,
                               sub.isprimary as subisprimary,
                               sub.o365calid as subo365calid
                          FROM {user} u
                          JOIN {user_enrolments} ue ON ue.userid = u.id
                          JOIN {enrol} e ON e.id = ue.enrolid
                          JOIN {local_o365_calsub} sub ON sub.user_id = u.id
                               AND sub.caltype = ?
                               AND sub.caltypeid = e.courseid
                               AND (sub.syncbehav = ? OR sub.syncbehav = ?)
                         WHERE e.courseid = ?';
                $params = ['course', 'out', 'both', $event->courseid];
                $attendees = $DB->get_records_sql($sql, $params);
            }
        } else {
            // Personal user event. Only sync if user is subscribed to their events.
            $select = 'caltype = ? AND user_id = ? AND (syncbehav = ? OR syncbehav = ?)';
            $params = ['user', $event->userid, 'out', 'both'];
            $calsub = $DB->get_record_select('local_o365_calsub', $select, $params);
            if (!empty($calsub)) {
                // Send event to o365 and store ID.
                $apiclient = $this->construct_calendar_api($event->userid);
                $calid = (!empty($calsub->o365calid) && empty($calsub->isprimary)) ? $calsub->o365calid : null;
                $response = $apiclient->create_event($subject, $body, $timestart, $timeend, [], [], $calid);
                if (!empty($response) && is_array($response) && isset($response['Id'])) {
                    $idmaprec = [
                        'eventid' => $event->id,
                        'outlookeventid' => $response['Id'],
                        'userid' => $event->userid,
                        'origin' => 'moodle',
                    ];
                    $DB->insert_record('local_o365_calidmap', (object)$idmaprec);
                }
            }
            return true;
        }

        // Move users who've subscribed to non-primary calendars.
        $nonprimarycalsubs = [];
        $eventcreatorsub = null;
        foreach ($attendees as $userid => $attendee) {
            if ($userid == $event->userid) {
                $eventcreatorsub = $attendee;
            }
            if (isset($attendee->subisprimary) && $attendee->subisprimary == '0') {
                $nonprimarycalsubs[] = $attendee;
                unset($attendees[$userid]);
            }
        }

        // Sync primary-calendar users as attendees on a single event.
        if (!empty($attendees)) {
            $apiclient = $this->construct_calendar_api($event->userid);
            $calid = (!empty($eventcreatorsub) && !empty($eventcreatorsub->subo365calid)) ? $eventcreatorsub->subo365calid : null;
            if (isset($eventcreatorsub->subisprimary) && $eventcreatorsub->subisprimary == 1) {
                $calid = null;
            }
            $response = $apiclient->create_event($subject, $body, $timestart, $timeend, $attendees, [], $calid);
            if (!empty($response) && is_array($response) && isset($response['Id'])) {
                $idmaprec = [
                    'eventid' => $event->id,
                    'outlookeventid' => $response['Id'],
                    'userid' => $event->userid,
                    'origin' => 'moodle',
                ];
                $DB->insert_record('local_o365_calidmap', (object)$idmaprec);
            }
        }

        // Sync non-primary attendees individually.
        foreach ($nonprimarycalsubs as $attendee) {
            $apiclient = $this->construct_calendar_api($attendee->id);
            $calid = (!empty($attendee->subo365calid)) ? $attendee->subo365calid : null;
            $response = $apiclient->create_event($subject, $body, $timestart, $timeend, [], [], $calid);
            if (!empty($response) && is_array($response) && isset($response['Id'])) {
                $idmaprec = [
                    'eventid' => $event->id,
                    'outlookeventid' => $response['Id'],
                    'userid' => $attendee->userid,
                    'origin' => 'moodle',
                ];
                $DB->insert_record('local_o365_calidmap', (object)$idmaprec);
            }
        }

        return true;
    }

    /**
     * Get user calendars.
     *
     * @return array Array of user calendars.
     */
    public function get_calendars() {
        global $USER;
        $apiclient = $this->construct_calendar_api($USER->id, false);
        $response = $apiclient->get_calendars();
        return (!empty($response['value']) && is_array($response['value'])) ? $response['value'] : [];
    }

    /**
     * Get events for a given user in a given calendar.
     *
     * @param int $muserid The ID of the Moodle user to get events as.
     * @param string $o365calid The ID of the o365 calendar to get events from.
     * @param int $since Timestamp to fetch events since.
     * @return array Array of events.
     */
    public function get_events($muserid, $o365calid, $since = null) {
        $apiclient = $this->construct_calendar_api($muserid, false);
        return $apiclient->get_events($o365calid, $since);
    }

    /**
     * Update an already-synced event with new information.
     *
     * @param int $moodleeventid The ID of an updated Moodle event.
     * @return bool Success/Failure.
     */
    public function update_outlook_event($moodleeventid) {
        global $DB;

        // Get o365 event id (and determine if we can sync this event).
        $idmaprecs = $DB->get_records('local_o365_calidmap', ['eventid' => $moodleeventid]);
        if (empty($idmaprecs)) {
            return true;
        }

        // Send updated information to o365.
        $event = $DB->get_record('event', ['id' => $moodleeventid]);
        if (empty($event)) {
            return true;
        }

        $updated = [
            'subject' => $event->name,
            'body' => $event->description,
            'starttime' => $event->timestart,
            'endtime' => $event->timestart + $event->timeduration,
        ];

        foreach ($idmaprecs as $idmaprec) {
            $apiclient = $this->construct_calendar_api($idmaprec->userid);
            $apiclient->update_event($idmaprec->outlookeventid, $updated);
        }
        return true;
    }

    /**
     * Delete all synced outlook event for a given Moodle event.
     *
     * @param int $moodleeventid The ID of a Moodle event.
     * @return bool Success/Failure.
     */
    public function delete_outlook_event($moodleeventid) {
        global $DB;

        // Get o365 event ids (and determine if we can sync this event).
        $idmaprecs = $DB->get_records('local_o365_calidmap', ['eventid' => $moodleeventid]);
        if (empty($idmaprecs)) {
            return true;
        }

        foreach ($idmaprecs as $idmaprec) {
            $apiclient = $this->construct_calendar_api($idmaprec->userid);
            $apiclient->delete_event($idmaprec->outlookeventid);
        }

        // Clean up idmap table.
        $DB->delete_records('local_o365_calidmap', ['eventid' => $moodleeventid]);

        return true;
    }
}