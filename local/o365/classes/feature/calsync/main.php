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
 * Calendar sync feature.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\calsync;

use core\url;
use local_o365\httpclient;
use local_o365\oauth2\clientdata;
use local_o365\oauth2\token;
use local_o365\rest\unified;
use local_o365\utils;
use moodle_exception;
use stdClass;

/**
 * Calendar sync feature.
 */
class main {
    /**
     * @var clientdata|null
     */
    protected $clientdata = null;
    /**
     * @var httpclient|null
     */
    protected $httpclient = null;

    /**
     * Constructor.
     *
     * @param clientdata|null $clientdata
     * @param httpclient|null $httpclient
     * @throws moodle_exception
     */
    public function __construct(?clientdata $clientdata = null, ?httpclient $httpclient = null) {
        $this->clientdata = (!empty($clientdata)) ? $clientdata : clientdata::instance_from_oidc();
        $this->httpclient = (!empty($httpclient)) ? $httpclient : new httpclient();
    }

    /**
     * Construct a calendar API client using the system API user.
     *
     * @param int $muserid The userid to get the outlook token for.
     * @param bool $systemfallback
     *
     * @return unified A constructed unified API client, or false if error.
     * @throws moodle_exception
     */
    public function construct_calendar_api($muserid, $systemfallback = true) {
        $tokenresource = unified::get_tokenresource();

        $token = token::instance($muserid, $tokenresource, $this->clientdata, $this->httpclient);
        if ($token && $token->is_expired()) {
            try {
                if (!$token->refresh()) {
                    $token = null;
                }
            } catch (moodle_exception $e) {
                // Token fails to refresh, so we'll use application token.
                $token = null;
            }
        }

        if (empty($token) && $systemfallback === true) {
            $token = utils::get_application_token($tokenresource, $this->clientdata, $this->httpclient);
        }

        if (empty($token)) {
            throw new moodle_exception('errornotoken', 'local_o365', '', $muserid);
        }

        $apiclient = new unified($token, $this->httpclient);

        return $apiclient;
    }

    /**
     * Get a token that can be used for calendar syncing.
     *
     * @param int $muserid The ID of a Moodle user to get a token for.
     * @return token|null Either a token for calendar syncing, or null if no token could be retrieved.
     */
    public function get_user_token($muserid) {
        $tokenresource = unified::get_tokenresource();
        $usertoken = token::instance($muserid, $tokenresource, $this->clientdata, $this->httpclient);
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
     * @param int $timestart The timestamp when the event starts.
     * @param int $timeend The timestamp when the event ends.
     * @param array $attendees Array of moodle user objects that are attending the event.
     * @param array $other Other parameters to include.
     * @param string $calid The o365 ID of the calendar to create the event in.
     * @return bool|int The new ID of the calidmap record.
     */
    public function create_event_raw($muserid, $eventid, $subject, $body, $timestart, $timeend, $attendees, array $other, $calid) {
        global $DB;

        $event = $DB->get_record('event', ['id' => $eventid]);
        if ($event) {
            $context = $this->get_calendar_context($event, $muserid);
            if (!empty($calid) && !$this->calendar_exists($muserid, $calid)) {
                $this->calendar_unsubscribe($muserid, $context['caltype'], $context['caltypeid'], $calid);
                return false;
            }
        }

        $apiclient = $this->construct_calendar_api($muserid, true);
        $o365upn = utils::get_o365_upn($muserid);
        if ($o365upn) {
            $response = $apiclient->create_event($subject, $body, $timestart, $timeend, $attendees, $other, $calid, $o365upn);
            $idmaprec = [
                'eventid' => $eventid,
                'outlookeventid' => $response['Id'],
                'userid' => $muserid,
                'origin' => 'moodle',
            ];
            return $DB->insert_record('local_o365_calidmap', (object)$idmaprec);
        } else {
            return false;
        }
    }

    /**
     * Update an event.
     *
     * @param int $muserid The ID of the Moodle user to communicate as.
     * @param string $outlookeventid The event ID in o365 outlook.
     * @param array $updated Array of updated information. Keys are 'subject', 'body', 'starttime', 'endtime', and 'attendees'.
     * @return void
     * @throws moodle_exception
     */
    public function update_event_raw($muserid, $outlookeventid, $updated) {
        global $DB;

        $idmaprec = $DB->get_record('local_o365_calidmap', ['outlookeventid' => $outlookeventid, 'userid' => $muserid]);
        if ($idmaprec) {
            $event = $DB->get_record('event', ['id' => $idmaprec->eventid]);
            if ($event) {
                $context = $this->get_calendar_context($event, $muserid);
                if (!empty($context['calid']) && !$this->calendar_exists($muserid, $context['calid'])) {
                    $this->calendar_unsubscribe($muserid, $context['caltype'], $context['caltypeid'], $context['calid']);
                    return;
                }
            }
        }

        $apiclient = $this->construct_calendar_api($muserid, true);
        $o365upn = utils::get_o365_upn($muserid);
        if ($o365upn) {
            $apiclient->update_event($outlookeventid, $updated, $o365upn);
        }
    }

    /**
     * Delete an event.
     *
     * The calidmap row is only removed once the Outlook event has actually been deleted (or cleanup was
     * otherwise handled, e.g. via calendar_unsubscribe()). If the delete is skipped (no resolvable Outlook
     * UPN) or fails, the mapping is left in place - and a warning logged via mtrace() - rather than
     * silently forgetting about an Outlook event that's still there.
     *
     * @param bool $muserid
     * @param string $outlookeventid The event ID in o365 outlook.
     * @param int|null $idmaprecid
     *
     * @return bool Success/Failure - false if the delete was skipped or failed.
     */
    public function delete_event_raw($muserid, $outlookeventid, $idmaprecid = null) {
        global $DB;

        if (empty($idmaprecid)) {
            $idmaprec = $DB->get_record('local_o365_calidmap', ['outlookeventid' => $outlookeventid, 'userid' => $muserid]);
            if ($idmaprec) {
                $idmaprecid = $idmaprec->id;
                $eventid = $idmaprec->eventid;
            } else {
                return false;
            }
        } else {
            $idmaprec = $DB->get_record('local_o365_calidmap', ['id' => $idmaprecid]);
            if ($idmaprec) {
                $eventid = $idmaprec->eventid;
            } else {
                return false;
            }
        }

        $event = $DB->get_record('event', ['id' => $eventid]);
        $handled = false;
        if ($event) {
            $context = $this->get_calendar_context($event, $muserid);
            if (!empty($context['calid']) && !$this->calendar_exists($muserid, $context['calid'])) {
                $this->calendar_unsubscribe($muserid, $context['caltype'], $context['caltypeid'], $context['calid']);
                $handled = true;
            }
        }

        if ($handled) {
            $DB->delete_records('local_o365_calidmap', ['id' => $idmaprecid]);
            return true;
        }

        $apiclient = $this->construct_calendar_api($muserid, true);
        $o365upn = utils::get_o365_upn($muserid);
        if (empty($o365upn)) {
            // Can't resolve who to delete this as. Leave the mapping in place rather than silently
            // forgetting about an Outlook event we never actually removed.
            mtrace('Could not delete Outlook event for calidmap #' . $idmaprecid . ' - no Outlook UPN for user ' .
                $muserid . '. Leaving the mapping in place.');
            return false;
        }

        try {
            $apiclient->delete_event($outlookeventid, $o365upn);
        } catch (\moodle_exception $e) {
            mtrace('Error deleting Outlook event for calidmap #' . $idmaprecid . ': ' . $e->getMessage() .
                '. Leaving the mapping in place.');
            return false;
        }

        $DB->delete_records('local_o365_calidmap', ['id' => $idmaprecid]);

        return true;
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
        $subject = $this->get_event_subject($event);
        $body = $event->description;
        $timestart = $event->timestart;
        $timeend = $timestart + $event->timeduration;

        $body .= $this->get_event_link_html($event);

        if (isset($event->courseid) && $event->courseid == SITEID) {
            // Site event. There's no group/M365-group concept at site level, so build the discovery
            // array directly rather than going through get_course_event_attendees().
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

            $discovery = [
                'primary' => $attendees,
                'nonprimary' => $nonprimarycalsubs,
                'eventcreatorsub' => $eventcreatorsub,
                'groupobject' => null,
            ];
        } else if (isset($event->courseid) && $event->courseid != SITEID && $event->courseid > 0) {
            $discovery = $this->get_course_event_attendees($event);
        } else {
            // Personal user event.
            if (!$this->is_event_module_visible_to_user($event, (int) $event->userid)) {
                return true;
            }

            // Sync if the user is subscribed to their personal ("user") calendar. As a fallback,
            // assignment extension events and user-override due dates (which Moodle always stores with
            // courseid = 0, even though they belong to a specific course - see
            // mod_assign::save_user_extension() and assign_update_events()) also sync if the user has
            // subscribed to that assignment's course calendar, since most users only ever subscribe
            // course calendars and would otherwise never see these synced at all.
            $select = 'caltype = ? AND user_id = ? AND (syncbehav = ? OR syncbehav = ?)';
            $params = ['user', $event->userid, 'out', 'both'];
            $calsub = $DB->get_record_select('local_o365_calsub', $select, $params);

            $isassignpersonalduetype = $event->modulename === 'assign' &&
                in_array($event->eventtype, ['extension', 'due'], true);
            if (empty($calsub) && $isassignpersonalduetype) {
                $assigncourseid = $DB->get_field('assign', 'course', ['id' => $event->instance]);
                if (!empty($assigncourseid)) {
                    $select = 'caltype = ? AND caltypeid = ? AND user_id = ? AND (syncbehav = ? OR syncbehav = ?)';
                    $params = ['course', $assigncourseid, $event->userid, 'out', 'both'];
                    $calsub = $DB->get_record_select('local_o365_calsub', $select, $params);
                }
            }

            if (!empty($calsub)) {
                // Send event to o365 and store ID.
                $apiclient = $this->construct_calendar_api($event->userid);
                $calid = (!empty($calsub->o365calid) && empty($calsub->isprimary)) ? $calsub->o365calid : null;
                $context = $this->get_calendar_context($event, $event->userid);
                if (!empty($calid) && !$this->calendar_exists($event->userid, $calid)) {
                    $this->calendar_unsubscribe($event->userid, $context['caltype'], $context['caltypeid'], $calid);
                    return false;
                }

                $o365upn = utils::get_o365_upn($event->userid);
                if ($o365upn) {
                    $response = $apiclient->create_event($subject, $body, $timestart, $timeend, [], [], $calid, $o365upn);
                    $idmaprec = [
                        'eventid' => $event->id,
                        'outlookeventid' => $response['Id'],
                        'userid' => $event->userid,
                        'origin' => 'moodle',
                    ];
                    $DB->insert_record('local_o365_calidmap', (object)$idmaprec);
                } else {
                    return false;
                }
            }

            return true;
        }

        $this->create_combined_course_event($event, $discovery, $subject, $body, $timestart, $timeend);
        $this->sync_nonprimary_attendees($event, $discovery['nonprimary'], $subject, $body, $timestart, $timeend);

        return true;
    }

    /**
     * Discover current, availability-filtered attendees for a course-level calendar event.
     *
     * Handles both group-restricted events (event->groupid set) and whole-course events, and splits the
     * resulting attendees into primary-calendar (combined/group event) and non-primary-calendar
     * (individually synced) groups, matching the different Outlook sync mechanisms used for each. Shared
     * between create_outlook_event_from_moodle_event() and reconcile_course_event_attendees() so a later
     * "Restrict access" change can be reconciled the same way the event was originally synced.
     *
     * @param \stdClass $event The Moodle event object (courseid must be a real, non-site course id).
     * @return array {
     *     primary: array of stdClass attendees (keyed by userid), eligible for the combined/group event.
     *     nonprimary: array of stdClass attendees to sync individually.
     *     eventcreatorsub: stdClass|null the event creator's own calsub row, if they're a primary attendee.
     *     groupobject: stdClass|null the course's linked Microsoft 365 group object, if any (only looked
     *                  up when the event isn't itself group-restricted, matching create_group_event()'s
     *                  own gating).
     * }
     */
    protected function get_course_event_attendees(\stdClass $event): array {
        global $DB;

        $groupobject = null;

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

            $groupobject = $DB->get_record(
                'local_o365_objects',
                ['moodleid' => $event->courseid, 'type' => 'group', 'subtype' => 'course']
            );
        }

        // Drop attendees who can't actually see the module this event belongs to (e.g. excluded by a
        // group restriction), so they don't get an Outlook event for something hidden from them.
        foreach ($attendees as $userid => $attendee) {
            if (!$this->is_event_module_visible_to_user($event, (int) $userid)) {
                unset($attendees[$userid]);
            }
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

        return [
            'primary' => $attendees,
            'nonprimary' => $nonprimarycalsubs,
            'eventcreatorsub' => $eventcreatorsub,
            'groupobject' => $groupobject,
        ];
    }

    /**
     * Create the combined "primary calendar attendees" event for a course/site-level event - either as a
     * Microsoft 365 group calendar event (if the course has a linked group and the event isn't itself
     * group-restricted) or as a single event with each primary-calendar attendee added as an Outlook
     * attendee. No-ops if there are no eligible primary attendees.
     *
     * @param \stdClass $event The Moodle event object.
     * @param array $discovery The result of get_course_event_attendees() (or an equivalent shape).
     * @param string $subject The event's subject.
     * @param string $body The event's body/description.
     * @param int $timestart The event's start timestamp.
     * @param int $timeend The event's end timestamp.
     * @return void
     */
    protected function create_combined_course_event(
        \stdClass $event,
        array $discovery,
        string $subject,
        string $body,
        int $timestart,
        int $timeend
    ): void {
        global $DB;

        $attendees = $discovery['primary'];
        if (empty($attendees)) {
            return;
        }

        $groupobject = $discovery['groupobject'];
        $eventcreatorsub = $discovery['eventcreatorsub'];

        if (!empty($groupobject) && !empty($groupobject->objectid) && empty($event->groupid)) {
            try {
                $apiclient = $this->construct_calendar_api($event->userid);
                $response = $apiclient->create_group_event(
                    $subject,
                    $body,
                    $timestart,
                    $timeend,
                    $attendees,
                    ['responseRequested' => false],
                    $groupobject->objectid
                );
                if (!empty($response)) {
                    $idmaprec = [
                        'eventid' => $event->id,
                        'outlookeventid' => $response['Id'],
                        'userid' => $event->userid,
                        'origin' => 'moodle',
                    ];
                    $DB->insert_record('local_o365_calidmap', (object) $idmaprec);
                    return;
                }
            } catch (moodle_exception $e) {
                debugging('Error creating group event. Details: ' . $e->getMessage());
            }
        }

        $apiclient = $this->construct_calendar_api($event->userid);
        $calid = (!empty($eventcreatorsub) && !empty($eventcreatorsub->subo365calid)) ? $eventcreatorsub->subo365calid : null;
        if (isset($eventcreatorsub->subisprimary) && $eventcreatorsub->subisprimary == 1) {
            $calid = null;
        }

        $context = $this->get_calendar_context($event, $event->userid);
        if (!empty($calid) && !$this->calendar_exists($event->userid, $calid)) {
            $this->calendar_unsubscribe($event->userid, $context['caltype'], $context['caltypeid'], $calid);
            return;
        }

        $o365upn = utils::get_o365_upn($event->userid);
        if ($o365upn) {
            $response = $apiclient->create_event($subject, $body, $timestart, $timeend, $attendees, [], $calid, $o365upn);
            $idmaprec = [
                'eventid' => $event->id,
                'outlookeventid' => $response['Id'],
                'userid' => $event->userid,
                'origin' => 'moodle',
            ];
            $DB->insert_record('local_o365_calidmap', (object) $idmaprec);
        }
    }

    /**
     * Sync each given attendee's own copy of a course/site-level event individually - their own Outlook
     * calendar, via their own token. Used for anyone subscribed to a non-primary/non-default Outlook
     * calendar, since those can't be added as a plain Outlook "attendee" on someone else's combined event.
     *
     * @param \stdClass $event The Moodle event object.
     * @param array $nonprimarycalsubs List of stdClass attendees to sync individually.
     * @param string $subject The event's subject.
     * @param string $body The event's body/description.
     * @param int $timestart The event's start timestamp.
     * @param int $timeend The event's end timestamp.
     * @return void
     */
    protected function sync_nonprimary_attendees(
        \stdClass $event,
        array $nonprimarycalsubs,
        string $subject,
        string $body,
        int $timestart,
        int $timeend
    ): void {
        global $DB;

        foreach ($nonprimarycalsubs as $attendee) {
            $apiclient = $this->construct_calendar_api($attendee->id);
            $calid = (!empty($attendee->subo365calid)) ? $attendee->subo365calid : null;
            $context = $this->get_calendar_context($event, $attendee->userid);
            if (!empty($calid) && !$this->calendar_exists($attendee->userid, $calid)) {
                $this->calendar_unsubscribe($attendee->userid, $context['caltype'], $context['caltypeid'], $calid);
                continue;
            }

            $o365upn = utils::get_o365_upn($attendee->userid);
            if ($o365upn) {
                $response = $apiclient->create_event($subject, $body, $timestart, $timeend, [], [], $calid, $o365upn);
                $idmaprec = [
                    'eventid' => $event->id,
                    'outlookeventid' => $response['Id'],
                    'userid' => $attendee->userid,
                    'origin' => 'moodle',
                ];
                $DB->insert_record('local_o365_calidmap', (object)$idmaprec);
            }
        }
    }

    /**
     * Re-sync a course-level event's attendees after something that isn't reflected in the event itself
     * changed who's eligible to see it - most notably, a course module's "Restrict access" rules being
     * edited, which doesn't touch the calendar 'event' row at all, so calendar_event_updated never fires
     * for it. Adds Outlook events for newly-eligible attendees and removes them for anyone who's lost
     * access, without disturbing attendees whose eligibility hasn't changed.
     *
     * @param int $moodleeventid The ID of the Moodle event to reconcile.
     * @return bool Success/Failure.
     */
    public function reconcile_course_event_attendees($moodleeventid) {
        global $DB;

        $event = $DB->get_record('event', ['id' => $moodleeventid]);
        if (empty($event) || (int) $event->courseid === SITEID || empty($event->courseid)) {
            // Not a course-level event - see reconcile_personal_event() for the personal-event equivalent.
            return true;
        }

        $discovery = $this->get_course_event_attendees($event);

        $idmaprecs = $DB->get_records('local_o365_calidmap', ['eventid' => $moodleeventid]);

        // Every mapping recorded under the event's own creator identity is a candidate "combined" mapping
        // (see create_combined_course_event()). Normally there's at most one, but {event}.userid isn't
        // stable - Moodle's calendar_event::create() refills it from $USER->id whenever mod_assign passes
        // an empty value, which happens on every assignment save - so an earlier reconciliation pass can
        // fail to recognise an already-synced mapping and create a second one alongside it. Collect every
        // match here (rather than keeping only the last one seen) so duplicates like that get cleaned up
        // instead of leaving one permanently orphaned.
        $combinedidmaprecs = [];
        $individualidmaprecsbyuserid = [];
        foreach ($idmaprecs as $idmaprec) {
            if ((int) $idmaprec->userid === (int) $event->userid) {
                $combinedidmaprecs[] = $idmaprec;
            } else {
                $individualidmaprecsbyuserid[(int) $idmaprec->userid] = $idmaprec;
            }
        }

        $eligiblenonprimaryuserids = array_map(static function ($attendee) {
            return (int) $attendee->userid;
        }, $discovery['nonprimary']);

        // Remove individually-synced attendees who are no longer eligible.
        foreach ($individualidmaprecsbyuserid as $userid => $idmaprec) {
            if (!in_array($userid, $eligiblenonprimaryuserids, true)) {
                $this->delete_event_raw($userid, $idmaprec->outlookeventid, $idmaprec->id);
            }
        }

        $subject = $this->get_event_subject($event);
        $body = $event->description . $this->get_event_link_html($event);
        $timestart = $event->timestart;
        $timeend = $timestart + $event->timeduration;

        // Add individual events for newly-eligible non-primary attendees.
        $newlyeligiblenonprimary = array_filter(
            $discovery['nonprimary'],
            static function ($attendee) use ($individualidmaprecsbyuserid) {
                return !isset($individualidmaprecsbyuserid[(int) $attendee->userid]);
            }
        );
        $this->sync_nonprimary_attendees($event, $newlyeligiblenonprimary, $subject, $body, $timestart, $timeend);

        // Reconcile the combined (primary-calendar / group) event's attendee list.
        if (!empty($combinedidmaprecs)) {
            if (empty($discovery['primary'])) {
                // No eligible primary-calendar attendees left - remove every shared-event mapping. Routed
                // through delete_calidmap_rows() (not delete_event_raw()) since it correctly detects and
                // deletes via the group API when the mapping is a Microsoft 365 group calendar event.
                $this->delete_calidmap_rows($event, $combinedidmaprecs, $discovery['groupobject']);
            } else {
                // Keep and update the first mapping found; if duplicates have accumulated, remove the
                // rest rather than leaving them behind untouched.
                $primarycombined = array_shift($combinedidmaprecs);
                $this->update_combined_course_event_attendees($event, $discovery, $primarycombined);
                if (!empty($combinedidmaprecs)) {
                    $this->delete_calidmap_rows($event, $combinedidmaprecs, $discovery['groupobject']);
                }
            }
        } else {
            // There was no combined event before (e.g. no eligible primary attendees at the time it was
            // first created) - create one now if there's anyone to put in it.
            $this->create_combined_course_event($event, $discovery, $subject, $body, $timestart, $timeend);
        }

        return true;
    }

    /**
     * Push an updated attendee list to an already-synced combined (primary-calendar or group) course
     * event, without touching its subject/body/time.
     *
     * @param \stdClass $event The Moodle event object.
     * @param array $discovery The result of get_course_event_attendees($event).
     * @param \stdClass $idmaprec The calidmap row for the combined event.
     * @return void
     */
    protected function update_combined_course_event_attendees(\stdClass $event, array $discovery, \stdClass $idmaprec): void {
        $groupobject = $discovery['groupobject'];
        $isgroupevent = !empty($groupobject) && !empty($groupobject->objectid) && empty($event->groupid);

        $apiclient = $this->construct_calendar_api($idmaprec->userid);
        $updated = ['attendees' => $discovery['primary']];

        try {
            if ($isgroupevent) {
                $apiclient->update_event($idmaprec->outlookeventid, $updated, $groupobject->objectid, 'group');
            } else {
                $o365upn = utils::get_o365_upn($idmaprec->userid);
                if ($o365upn) {
                    $apiclient->update_event($idmaprec->outlookeventid, $updated, $o365upn);
                }
            }
        } catch (\moodle_exception $e) {
            mtrace('Error updating attendees for calidmap #' . $idmaprec->id . ': ' . $e->getMessage());
        }
    }

    /**
     * Re-sync a personal (courseid = 0) event - e.g. an assignment extension or user override - after
     * something outside the event itself changed whether the owning user can see it. Creates the Outlook
     * event if it's newly eligible and not yet synced, or removes it if the user has lost access.
     *
     * @param int $moodleeventid The ID of the Moodle event to reconcile.
     * @return bool Success/Failure.
     */
    public function reconcile_personal_event($moodleeventid) {
        global $DB;

        $event = $DB->get_record('event', ['id' => $moodleeventid]);
        if (empty($event) || !empty($event->courseid)) {
            // Not a personal event - see reconcile_course_event_attendees() for the course-level equivalent.
            return true;
        }

        $idmaprec = $DB->get_record('local_o365_calidmap', ['eventid' => $moodleeventid, 'userid' => $event->userid]);
        $visible = $this->is_event_module_visible_to_user($event, (int) $event->userid);

        if (!empty($idmaprec)) {
            if (!$visible) {
                $this->delete_event_raw((int) $event->userid, $idmaprec->outlookeventid, $idmaprec->id);
            }

            return true;
        }

        if ($visible) {
            return $this->create_outlook_event_from_moodle_event($moodleeventid);
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
        $apiclient = $this->construct_calendar_api($USER->id);
        $o365upn = utils::get_o365_upn($USER->id);
        if ($o365upn) {
            return $apiclient->get_calendars($o365upn);
        } else {
            return [];
        }
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
        $apiclient = $this->construct_calendar_api($muserid);
        $o365upn = utils::get_o365_upn($muserid);

        $events = [];
        if ($o365upn) {
            $events = $apiclient->get_events($o365calid, $since, $o365upn);
        }

        return $events;
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
            'subject' => $this->get_event_subject($event),
            'body' => $event->description,
            'starttime' => $event->timestart,
            'endtime' => $event->timestart + $event->timeduration,
        ];

        $updated['body'] .= $this->get_event_link_html($event);

        $groupobject = null;
        $isgroupevent = false;

        if ($event->courseid !== SITEID && $event->courseid !== 0 && empty($event->groupid)) {
            $groupobject = $DB->get_record(
                'local_o365_objects',
                ['moodleid' => $event->courseid, 'type' => 'group', 'subtype' => 'course']
            );
            $isgroupevent = !empty($groupobject) && !empty($groupobject->objectid);
        }

        foreach ($idmaprecs as $idmaprec) {
            // If the user has since lost access to the module (e.g. a group restriction was added or
            // they were moved out of an allowed group), remove their synced Outlook event instead of
            // updating it. Routed through delete_calidmap_rows() rather than delete_event_raw() directly,
            // since it correctly detects and deletes via the group API when this is a group calendar event.
            if (!$this->is_event_module_visible_to_user($event, (int) $idmaprec->userid)) {
                $this->delete_calidmap_rows($event, [$idmaprec], $groupobject);
                continue;
            }

            $context = $this->get_calendar_context($event, $idmaprec->userid);
            if (!empty($context['calid']) && !$this->calendar_exists($idmaprec->userid, $context['calid'])) {
                $this->calendar_unsubscribe($idmaprec->userid, $context['caltype'], $context['caltypeid'], $context['calid']);
                continue;
            }

            try {
                $apiclient = $this->construct_calendar_api($idmaprec->userid);

                // See the matching comment in delete_outlook_event() - a calidmap row not recorded under
                // the event's own creator identity was created individually, never via the group API.
                $isrecipientgroupevent = $isgroupevent && (int) $idmaprec->userid === (int) $event->userid;

                if ($isrecipientgroupevent) {
                    try {
                        $apiclient->update_event($idmaprec->outlookeventid, $updated, $groupobject->objectid, 'group');
                        continue;
                    } catch (\moodle_exception $e) {
                        $o365upn = utils::get_o365_upn($idmaprec->userid);
                        if ($o365upn) {
                            $apiclient->update_event($idmaprec->outlookeventid, $updated, $o365upn);
                        }

                        continue;
                    }
                }

                $o365upn = utils::get_o365_upn($idmaprec->userid);
                if ($o365upn) {
                    $apiclient->update_event($idmaprec->outlookeventid, $updated, $o365upn);
                }
            } catch (\moodle_exception $e) {
                mtrace('Error updating event: ' . $e->getMessage());
            }
        }

        return true;
    }

    /**
     * Push a new start time for an already-synced Moodle event to Outlook.
     *
     * Used for cases where a Moodle event's timestart has been (or is about to be) changed via direct
     * SQL rather than through the calendar_event API, so the normal \core\event\calendar_event_updated
     * event never fires. mod_assign's assignment extension re-grant is one such case. Everything other
     * than the start time is read fresh from the Moodle event record, since only the start time is stale
     * at the point this is called.
     *
     * @param int $moodleeventid The ID of the Moodle event to update.
     * @param int $newtimestart The new start timestamp to push to Outlook.
     * @return bool Always true - per-recipient failures (e.g. a Graph API error) are logged via mtrace()
     *              and skipped rather than surfaced here, matching update_outlook_event().
     */
    public function update_outlook_event_datetime($moodleeventid, $newtimestart) {
        global $DB;

        $idmaprecs = $DB->get_records('local_o365_calidmap', ['eventid' => $moodleeventid]);
        if (empty($idmaprecs)) {
            return true;
        }

        $event = $DB->get_record('event', ['id' => $moodleeventid]);
        if (empty($event)) {
            return true;
        }

        $updated = [
            'subject' => $this->get_event_subject($event),
            'body' => $event->description . $this->get_event_link_html($event),
            'starttime' => $newtimestart,
            'endtime' => $newtimestart + $event->timeduration,
        ];

        foreach ($idmaprecs as $idmaprec) {
            try {
                $this->update_event_raw($idmaprec->userid, $idmaprec->outlookeventid, $updated);
            } catch (\moodle_exception $e) {
                mtrace('Error updating event: ' . $e->getMessage());
            }
        }

        return true;
    }

    /**
     * Delete all synced Outlook events for a given Moodle event.
     *
     * A calidmap row is only removed once we've confirmed its Outlook event was actually deleted (or that
     * cleanup was otherwise handled, e.g. via calendar_unsubscribe()). Recipients whose delete attempt was
     * skipped (no resolvable Outlook UPN) or failed keep their mapping so they aren't silently forgotten -
     * a warning is logged via mtrace() for each one so it's visible in cron output.
     *
     * @param int $moodleeventid The ID of a Moodle event.
     * @param stdClass|null $eventsnapshot Snapshot of the Moodle event.
     * @return bool Always true - see above for how per-recipient failures are handled.
     */
    public function delete_outlook_event($moodleeventid, ?\stdClass $eventsnapshot) {
        global $DB;

        // Get o365 event ids (and determine if we can sync this event).
        $idmaprecs = $DB->get_records('local_o365_calidmap', ['eventid' => $moodleeventid]);
        if (empty($idmaprecs)) {
            return true;
        }

        $event = $eventsnapshot;

        $groupobject = null;

        if (!empty($event) && $event->courseid !== SITEID && $event->courseid !== 0 && empty($event->groupid)) {
            $groupobject = $DB->get_record(
                'local_o365_objects',
                ['moodleid' => $event->courseid, 'type' => 'group', 'subtype' => 'course']
            );
        }

        $this->delete_calidmap_rows($event, $idmaprecs, $groupobject);

        return true;
    }

    /**
     * Delete a set of already-synced Outlook events, correctly routing group-calendar mappings through
     * the group API instead of always using the individual-user endpoint (unlike delete_event_raw(),
     * which has no way to know a mapping might be a group event).
     *
     * A calidmap row is only removed once we've confirmed its Outlook event was actually deleted (or that
     * cleanup was otherwise handled, e.g. via calendar_unsubscribe()). Anything skipped (no resolvable
     * Outlook UPN) or failed is left in place and logged via mtrace(), rather than silently forgotten.
     *
     * @param \stdClass|null $event The Moodle event object the mappings belong to. Null disables the
     *                              calendar-subscription check and group-event detection (matches the
     *                              behaviour when no event snapshot is available).
     * @param array $idmaprecs The local_o365_calidmap rows to delete.
     * @param \stdClass|null $groupobject The course's linked Microsoft 365 group object, if any.
     * @return void
     */
    protected function delete_calidmap_rows(?\stdClass $event, array $idmaprecs, ?\stdClass $groupobject): void {
        global $DB;

        foreach ($idmaprecs as $idmaprec) {
            if (!empty($event)) {
                $context = $this->get_calendar_context($event, (int) $idmaprec->userid);

                if (!empty($context['calid']) && !$this->calendar_exists($idmaprec->userid, $context['calid'])) {
                    $this->calendar_unsubscribe($idmaprec->userid, $context['caltype'], $context['caltypeid'], $context['calid']);
                    $DB->delete_records('local_o365_calidmap', ['id' => $idmaprec->id]);
                    continue;
                }
            }

            $apiclient = $this->construct_calendar_api($idmaprec->userid);
            $deleted = false;

            // Creation only ever records the group/combined-primary event under the event's own creator
            // identity ($event->userid). A calidmap row recorded under any other userid was created
            // individually, for that specific attendee's own calendar (the "non-primary calendar
            // subscribers" loop) - never the group calendar - so it must always be deleted via that
            // attendee's own UPN, not the group API.
            $isrecipientgroupevent = !empty($groupobject) && !empty($groupobject->objectid) && !empty($event) &&
                empty($event->groupid) && (int) $idmaprec->userid === (int) $event->userid;

            if ($isrecipientgroupevent) {
                try {
                    $apiclient->delete_event($idmaprec->outlookeventid, $groupobject->objectid, 'group');
                    $deleted = true;
                } catch (\moodle_exception $e) {
                    $o365upn = utils::get_o365_upn($idmaprec->userid);
                    if (empty($o365upn)) {
                        mtrace('Error deleting group event for calidmap #' . $idmaprec->id . ': ' . $e->getMessage() .
                            ' (no Outlook UPN fallback for user ' . $idmaprec->userid . '). Leaving the mapping in place.');
                    } else {
                        try {
                            $apiclient->delete_event($idmaprec->outlookeventid, $o365upn);
                            $deleted = true;
                        } catch (\moodle_exception $e2) {
                            mtrace('Error deleting event (group and user fallback both failed) for calidmap #' .
                                $idmaprec->id . ': ' . $e2->getMessage() . '. Leaving the mapping in place.');
                        }
                    }
                }
            } else {
                $o365upn = utils::get_o365_upn($idmaprec->userid);
                if (empty($o365upn)) {
                    mtrace('Could not delete Outlook event for calidmap #' . $idmaprec->id . ' - no Outlook UPN for user ' .
                        $idmaprec->userid . '. Leaving the mapping in place.');
                } else {
                    try {
                        $apiclient->delete_event($idmaprec->outlookeventid, $o365upn);
                        $deleted = true;
                    } catch (\moodle_exception $e) {
                        mtrace('Error deleting Outlook event for calidmap #' . $idmaprec->id . ': ' . $e->getMessage() .
                            '. Leaving the mapping in place.');
                    }
                }
            }

            if ($deleted) {
                $DB->delete_records('local_o365_calidmap', ['id' => $idmaprec->id]);
            }
        }
    }

    /**
     * Create a new calendar in the user's o365 calendars.
     *
     * @param string $name The calendar's title.
     * @return array|null Returned response, or null if error.
     */
    public function create_outlook_calendar($name) {
        global $USER;
        $apiclient = $this->construct_calendar_api($USER->id);
        $o365upn = utils::get_o365_upn($USER->id);
        if ($o365upn) {
            return $apiclient->create_calendar($name, $o365upn);
        } else {
            return null;
        }
    }

    /**
     * Update a existing o365 calendar.
     *
     * @param string $outlookcalendearid The calendar's title.
     * @param array $updated Array of updated information. Keys are 'name'.
     * @return array|null Returned response, or null if error.
     */
    public function update_outlook_calendar($outlookcalendearid, $updated) {
        global $USER;
        $apiclient = $this->construct_calendar_api($USER->id, false);
        $o365upn = utils::get_o365_upn($USER->id);
        if ($o365upn) {
            return $apiclient->update_calendar($outlookcalendearid, $updated, $o365upn);
        } else {
            return null;
        }
    }

    /**
     * Build the Outlook event subject for a Moodle calendar event.
     *
     * Prefixes the event's name with contextual information (site/personal/course name), matching what
     * a user would see if they navigated to the equivalent view in Moodle's own calendar. Pulled out into
     * its own method so every place that pushes a subject to Outlook (create, update, and the
     * calendar_event-API-bypassing update_outlook_event_datetime()) builds it the same way.
     *
     * @param \stdClass $event The Moodle event database object.
     * @return string The subject to use for the Outlook event.
     */
    protected function get_event_subject(\stdClass $event): string {
        global $DB, $SITE;

        $subject = $event->name;

        if ($event->eventtype === 'site') {
            $subject = $SITE->fullname . ': ' . $subject;
        } else if ($event->eventtype === 'user') {
            $subject = get_string('personal_calendar', 'local_o365') . ': ' . $subject;
        } else if ($event->eventtype === 'course') {
            $course = $DB->get_record('course', ['id' => $event->courseid]);
            $subject = $course->fullname . ': ' . $subject;
        }

        return $subject;
    }

    /**
     * Get Moodle event link and it's HTML.
     *
     * @param object $event The Moodle event database object.
     * @return string Moodle event HTML with link.
     */
    public function get_event_link_html($event) {
        // Update event description.
        if (isset($event->courseid) && $event->courseid == SITEID) {
            $moodleeventurl = new url('/calendar/view.php?view=day&time=' . $event->timestart . '#event_' . $event->id);
        } else if (isset($event->courseid) && $event->courseid != SITEID && $event->courseid > 0) {
            $moodleeventurl = new url('/calendar/view.php?course=' . $event->courseid . '&view=day&time=' .
                $event->timestart . '#event_' . $event->id);
        } else {
            $moodleeventurl = new url('/calendar/view.php?view=day&time=' . $event->timestart . '#event_' . $event->id);
        }

        $linkhtml = \html_writer::link($moodleeventurl, get_string('calendar_event', 'local_o365'));
        $fulllinkhtml = \html_writer::link($moodleeventurl, $moodleeventurl);
        $spanhtml = \html_writer::span($linkhtml . \html_writer::empty_tag('br') . $fulllinkhtml);
        return \html_writer::empty_tag('br') . \html_writer::tag('p', $spanhtml);
    }

    /**
     * Check if a specific Outlook calendar exists for the user.
     *
     * @param int $userid The Moodle user ID.
     * @param string $outlookcalendarid The Outlook calendar ID to check.
     * @return bool True if the calendar exists, false otherwise.
     */
    public function calendar_exists(int $userid, string $outlookcalendarid): bool {
        try {
            if (empty($outlookcalendarid)) {
                return false;
            }

            $apiclient = $this->construct_calendar_api($userid, true);
            $o365upn = utils::get_o365_upn($userid);

            if (empty($o365upn)) {
                return true;
            }

            $calendars = $apiclient->get_calendars($o365upn);

            if (empty($calendars)) {
                return true;
            }

            foreach ($calendars as $calendar) {
                if (isset($calendar['id']) && $calendar['id'] === $outlookcalendarid) {
                    return true;
                }
            }

            return false;
        } catch (moodle_exception $e) {
            return true;
        }
    }

    /**
     * Unsubscribe calendar for a user and queue adhoc task to clean mappings/events.
     *
     * - Removes subscription(s) from local_o365_calsub for the given parameters.
     * - Queues syncoldevents adhoc task to perform cleanup.
     *
     * @param int $userid Moodle user ID.
     * @param string $calendartype 'site' | 'course' | 'user'.
     * @param int|null $calendartypeid SITEID / courseid / userid depending on type (nullable for 'site' or 'user').
     * @param string|null $calendarid Outlook calendar ID (o365calid). Null means do not filter by o365calid.
     * @return void
     * @throws \moodle_exception
     */
    public function calendar_unsubscribe(
        int $userid,
        string $calendartype,
        ?int $calendartypeid,
        ?string $calendarid = null
    ): void {
        global $DB;

        if (empty($calendartype)) {
            throw new \moodle_exception('caltype_required', 'local_o365');
        }

        if ($calendartype === 'course' && empty($calendartypeid)) {
            throw new \moodle_exception('caltypeid_required_for_course', 'local_o365');
        }

        // Remove subscription(s).
        $subparams = [
            'user_id' => $userid,
            'caltype' => $calendartype,
        ];
        if ($calendartypeid !== null) {
            $subparams['caltypeid'] = $calendartypeid;
        }

        if (!empty($calendarid)) {
            $subparams['o365calid'] = $calendarid;
        }

        $DB->delete_records('local_o365_calsub', $subparams);

        // Queue adhoc task to sync old events (cleanup mappings/events).
        $task = new \local_o365\feature\calsync\task\syncoldevents();
        $task->set_custom_data([
            'caltype' => $calendartype,
            'caltypeid' => (int)($calendartypeid ?? 0),
            'userid' => $userid,
            'timecreated' => time(),
        ]);
        \core\task\manager::queue_adhoc_task($task);
    }

    /**
     * Get calendar context (type, type ID, and calendar ID) for a Moodle event and user.
     *
     * @param \stdClass $event The Moodle event object.
     * @param int $userid The Moodle user ID.
     * @return array {caltype: string, caltypeid: int|null, calid: string|null}
     */
    protected function get_calendar_context(\stdClass $event, int $userid): array {
        global $DB;

        $calendartype = null;
        $calendartypeid = null;

        if (isset($event->courseid) && $event->courseid == SITEID) {
            $calendartype = 'site';
            $calendartypeid = SITEID;
        } else if (isset($event->courseid) && $event->courseid != SITEID && $event->courseid > 0) {
            $calendartype = 'course';
            $calendartypeid = $event->courseid;
        } else {
            $calendartype = 'user';
            $calendartypeid = $userid;
        }

        $subparams = [
                'user_id' => $userid,
                'caltype' => $calendartype,
        ];
        if ($calendartypeid !== null) {
            $subparams['caltypeid'] = $calendartypeid;
        }

        $calsub = $DB->get_record('local_o365_calsub', $subparams);
        $calendarid = ($calsub && (int)$calsub->isprimary === 0) ? $calsub->o365calid : null;

        return ['caltype' => $calendartype, 'caltypeid' => $calendartypeid, 'calid' => $calendarid];
    }

    /**
     * Check whether the course module a calendar event belongs to is visible to a given user.
     *
     * This mirrors the check the Moodle calendar UI itself applies when deciding whether to show an
     * event to a user (see calendar_get_view() in calendar/lib.php), so that "Restrict access" rules
     * (e.g. group-based restrictions) are respected when deciding who gets a synced Outlook event too.
     * Events that aren't tied to a specific course module (e.g. manually-created course/site events)
     * are always considered visible, since there's no module-level restriction to check.
     *
     * As a cheap pre-check, if the course module is visible and has no availability restrictions
     * configured at all, it's visible to every user, so the far more expensive per-user modinfo lookup
     * (which builds a full course_modinfo and evaluates the availability tree) is skipped entirely. That
     * lookup only runs for modules that are actually hidden or have restrictions configured - for a large
     * course's attendee list, that's the exception rather than the rule.
     *
     * @param \stdClass $event The Moodle event object.
     * @param int $userid The Moodle user ID to check visibility for.
     * @return bool True if the event isn't tied to a module, or the module is visible to the user.
     */
    protected function is_event_module_visible_to_user(\stdClass $event, int $userid): bool {
        global $DB;

        if (empty($event->modulename) || empty($event->instance) || empty($event->courseid)) {
            return true;
        }

        static $cmcache = [];
        $cachekey = $event->courseid . ':' . $event->modulename . ':' . $event->instance;

        if (!array_key_exists($cachekey, $cmcache)) {
            $sql = "SELECT cm.visible, cm.availability
                      FROM {course_modules} cm
                      JOIN {modules} m ON m.id = cm.module
                     WHERE m.name = :modulename AND cm.instance = :instance AND cm.course = :courseid";
            $params = ['modulename' => $event->modulename, 'instance' => $event->instance, 'courseid' => $event->courseid];
            $cm = $DB->get_record_sql($sql, $params);
            $cmcache[$cachekey] = $cm;

            // A date-based "Restrict access" rule has nothing to observe - unlike a group restriction
            // being edited, or a user's group membership changing, visibility just becomes true as time
            // passes, with no event firing to react to. Every other trigger for this method (creation,
            // update, reconciliation) only re-evaluates visibility in response to something happening, so
            // without this, a date-restricted event would only ever end up synced by coincidence (e.g. if
            // the date happened to already be in the past when something else triggered a sync). Schedule
            // a one-off recheck at the exact moment the restriction could next take effect instead.
            if (!empty($cm) && !empty($cm->availability)) {
                $nextchange = $this->get_next_availability_date($cm->availability);
                if ($nextchange !== null) {
                    $this->schedule_availability_recheck($event->modulename, (int) $event->instance, $nextchange);
                }
            }
        }

        $cm = $cmcache[$cachekey];
        if (empty($cm)) {
            // No matching course module - it's most likely been deleted. Default to "not visible" so we
            // don't keep syncing (or create) an Outlook event for something that no longer exists.
            return false;
        }

        if ((int) $cm->visible === 1 && empty($cm->availability)) {
            // Nothing is configured to hide this module from anyone - no need for a per-user check.
            return true;
        }

        $modinfo = \get_fast_modinfo($event->courseid, $userid);
        $usercm = $modinfo->instances[$event->modulename][$event->instance] ?? null;

        if (empty($usercm)) {
            // Same reasoning as above - couldn't resolve the module, so don't assume it's visible.
            return false;
        }

        return $usercm->uservisible;
    }

    /**
     * Find the earliest still-upcoming timestamp among any date-based "Restrict access" conditions
     * anywhere in a course module's availability tree (course_modules.availability, JSON-encoded).
     *
     * This deliberately doesn't try to evaluate the tree's AND/OR/NOT logic - it just collects every
     * date condition's timestamp, regardless of nesting, and returns the soonest one still in the future.
     * That can occasionally schedule a recheck that turns out to be a no-op (e.g. a date condition
     * ANDed with an unrelated, still-unsatisfied condition), which is harmless; the alternative - missing
     * a genuine visibility change - is not.
     *
     * @param string|null $availabilityjson The raw availability JSON from course_modules.availability.
     * @return int|null The earliest future timestamp, or null if there isn't one.
     */
    protected function get_next_availability_date(?string $availabilityjson): ?int {
        if (empty($availabilityjson)) {
            return null;
        }

        $tree = json_decode($availabilityjson);
        if (empty($tree)) {
            return null;
        }

        $now = time();
        $next = null;

        $walk = static function ($node) use (&$walk, &$next, $now) {
            if (empty($node)) {
                return;
            }

            if (is_array($node)) {
                foreach ($node as $child) {
                    $walk($child);
                }
                return;
            }

            if (!is_object($node)) {
                return;
            }

            if (isset($node->type) && $node->type === 'date' && isset($node->t)) {
                $time = (int) $node->t;
                if ($time > $now && ($next === null || $time < $next)) {
                    $next = $time;
                }
            }

            if (isset($node->c) && is_array($node->c)) {
                $walk($node->c);
            }
        };

        $walk($tree);

        return $next;
    }

    /**
     * Schedule a one-off adhoc task to re-check Outlook sync for a module at the moment a date-based
     * "Restrict access" condition could next take effect. Deduplicated (per module and target time) via
     * queue_adhoc_task()'s $checkforexisting, so repeated calls for the same still-pending date don't pile
     * up duplicate tasks; the target time is included in the custom data specifically so that, if the
     * restriction is later edited to a different date, that's treated as a distinct task rather than being
     * silently skipped as "already scheduled".
     *
     * @param string $modulename The module type (e.g. 'assign').
     * @param int $instanceid The module instance ID.
     * @param int $timestamp The timestamp the restriction could next take effect.
     * @return void
     */
    protected function schedule_availability_recheck(string $modulename, int $instanceid, int $timestamp): void {
        $task = new \local_o365\feature\calsync\task\syncmoduleavailability();
        $task->set_custom_data([
            'modulename' => $modulename,
            'instanceid' => $instanceid,
            'scheduledfor' => $timestamp,
        ]);
        // A few seconds of slack after the threshold, so the recheck doesn't race the exact instant the
        // restriction takes effect.
        $task->set_next_run_time($timestamp + 5);
        \core\task\manager::queue_adhoc_task($task, true);
    }
}
