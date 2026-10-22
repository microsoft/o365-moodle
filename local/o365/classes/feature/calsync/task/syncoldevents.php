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
 * AdHoc task to sync existing Moodle calendar events with Microsoft 365.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\calsync\task;

use local_o365\utils;
use moodle_exception;

/**
 * AdHoc task to sync existing Moodle calendar events with Microsoft 365.
 *
 * This is run when users subscribe or unsubscribe from calendars.
 */
class syncoldevents extends \core\task\adhoc_task {
    /**
     * Get subscribers for a given calendar type and (optionally) id.
     *
     * @param string $caltype The calendar type.
     * @param int $caltypeid The calendar type ID.
     * @return array A list of arrays subscribers using their primary and non-primary calendars.
     */
    protected function get_subscribers($caltype, $caltypeid = null) {
        global $DB;
        $subscribersprimary = [];
        $subscribersnotprimary = [];
        $sql = 'SELECT u.id,
                       u.email,
                       u.firstname,
                       u.lastname,
                       sub.isprimary as subisprimary,
                       sub.o365calid as subo365calid
                  FROM {user} u
                  JOIN {local_o365_calsub} sub ON sub.user_id = u.id
                 WHERE sub.caltype = ? AND (sub.syncbehav = ? OR sub.syncbehav = ?)';
        $params = [$caltype, 'out', 'both'];
        if (!empty($caltypeid)) {
            $sql .= ' AND sub.caltypeid = ? ';
            $params[] = $caltypeid;
        }

        $allsubscribers = $DB->get_records_sql($sql, $params);
        foreach ($allsubscribers as $userid => $subscriber) {
            if (isset($subscriber->subisprimary) && $subscriber->subisprimary == '0') {
                $subscribersnotprimary[$userid] = $subscriber;
            } else {
                $subscribersprimary[$userid] = $subscriber;
            }
        }

        unset($allsubscribers);
        return [$subscribersprimary, $subscribersnotprimary];
    }

    /**
     * Get the Moodle-originated calendar ID mappings of an event, keyed by user ID.
     *
     * A user should only ever have one mapping per event. If duplicates exist, the first (lowest id) is
     * kept and the extra Outlook events and mappings are deleted.
     *
     * @param int $eventid The ID of the Moodle event.
     * @return array The calidmap records, keyed by user ID.
     */
    protected function get_event_idmaps_by_userid($eventid) {
        global $DB;

        $sql = 'SELECT id, userid, eventid, outlookeventid
                  FROM {local_o365_calidmap}
                 WHERE eventid = ? AND origin = ?
              ORDER BY id';
        $idmaps = [];
        foreach ($DB->get_records_sql($sql, [$eventid, 'moodle']) as $idmap) {
            if (isset($idmaps[$idmap->userid])) {
                mtrace('Removing duplicate Outlook event mapping #' . $idmap->id . ' for user #' . $idmap->userid . '.');
                $this->delete_duplicate_idmap($idmap);
                continue;
            }

            $idmaps[$idmap->userid] = $idmap;
        }

        return $idmaps;
    }

    /**
     * Delete the Outlook event and mapping of a duplicate calidmap record.
     *
     * @param \stdClass $idmap The duplicate calidmap record.
     */
    protected function delete_duplicate_idmap($idmap) {
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $calsync = new \local_o365\feature\calsync\main($clientdata, new \local_o365\httpclient());
        $calsync->delete_event_raw($idmap->userid, $idmap->outlookeventid, $idmap->id);
    }

    /**
     * Get the Outlook subject and body for a Moodle event, built the same way as when an event is first synced.
     *
     * @param \local_o365\feature\calsync\main $calsync The calendar sync helper.
     * @param int $eventid The ID of the Moodle event.
     * @return array The subject and body, in that order.
     */
    protected function get_event_content($calsync, $eventid) {
        global $DB;

        $event = $DB->get_record('event', ['id' => $eventid], '*', MUST_EXIST);

        return [
            $calsync->get_event_subject($event),
            $event->description . $calsync->get_event_link_html($event),
        ];
    }

    /**
     * Remove a user's own Outlook events for a calendar, so the sync that follows recreates them in the calendar
     * the user has switched to. Outlook can't move an event between calendars.
     *
     * Used when a user changes which Outlook calendar they sync to. A mapping held by the Moodle event's creator
     * is left alone unless it's an individual event: otherwise it's the shared event the other subscribers are
     * attendees of.
     *
     * @param \local_o365\feature\calsync\main $calsync The calendar sync helper.
     * @param string $caltype The calendar type (site, course or user).
     * @param int $caltypeid The course ID for course calendars.
     * @param int $userid The ID of the user who changed their calendar.
     */
    protected function remove_user_events_for_calendar_change($calsync, $caltype, $caltypeid, $userid) {
        global $DB;

        if ($caltype === 'course') {
            $where = 'ev.courseid = ?';
            $params = [$caltypeid];
        } else if ($caltype === 'site') {
            $where = 'ev.courseid = ?';
            $params = [SITEID];
        } else {
            $where = 'ev.courseid = 0 AND ev.groupid = 0 AND ev.userid = ?';
            $params = [$userid];
        }

        $sql = "SELECT m.id AS idmapid, m.eventid, m.userid, m.outlookeventid, ev.userid AS eventuserid, ev.courseid, ev.groupid,
                       ev.modulename, ev.eventtype
                  FROM {event} ev
                  JOIN {local_o365_calidmap} m ON m.eventid = ev.id
                 WHERE $where AND m.userid = ? AND m.origin = ?";
        $params = array_merge($params, [$userid, 'moodle']);
        $mappings = $DB->get_records_sql($sql, $params);
        foreach ($mappings as $mapping) {
            $creatormapping = $caltype !== 'user' && (int) $mapping->userid === (int) $mapping->eventuserid;
            $individualevent = $caltype === 'course' && $calsync->sync_course_event_individually((object) [
                'userid' => $mapping->eventuserid,
                'courseid' => $mapping->courseid,
                'groupid' => $mapping->groupid,
                'modulename' => $mapping->modulename,
                'eventtype' => $mapping->eventtype,
            ]);

            if ($creatormapping && !$individualevent) {
                // The creator's own mapping is the shared event the other subscribers are attendees of.
                continue;
            }

            if ($creatormapping) {
                // Course events are synced individually now, but this may still be a shared event from before
                // that was configured - which also has to be deleted from the group calendar, and its
                // attendees' copies cleaned up. Do so if it has attendees; otherwise it's a plain event.
                $fullevent = $DB->get_record('event', ['id' => $mapping->eventid]);
                $groupobject = ($fullevent && empty($fullevent->groupid)) ? $calsync->get_course_group_object($fullevent) : null;
                $idmaprec = $DB->get_record('local_o365_calidmap', ['id' => $mapping->idmapid]);
                if ($fullevent && $idmaprec && $calsync->delete_shared_event($idmaprec, $fullevent, $groupobject)) {
                    mtrace('Removed shared event mapping #' . $mapping->idmapid . '.');
                    continue;
                }
            }

            mtrace('Removing event mapping #' . $mapping->idmapid . ' so it is recreated in the new calendar.');
            $calsync->delete_event_raw($mapping->userid, $mapping->outlookeventid, $mapping->idmapid);
        }
    }

    /**
     * Move a user's assignment extension and user-override due date events to the course calendar they've switched to.
     *
     * Those are personal events (course ID 0), so they aren't covered by the course events handled when a user's
     * course calendar changes. They only sync to the course calendar as a fallback, when the user has no
     * personal calendar subscription - see main::create_outlook_event_from_moodle_event() - so users who do have
     * one aren't affected. They're deleted and recreated, as Outlook can't move events between calendars.
     *
     * @param \local_o365\feature\calsync\main $calsync The calendar sync helper.
     * @param int $courseid The ID of the course whose calendar the user changed.
     * @param int $userid The ID of the user who changed their calendar.
     */
    protected function move_assign_personal_events($calsync, $courseid, $userid) {
        global $DB;

        $usersub = 'user_id = ? AND caltype = ? AND (syncbehav = ? OR syncbehav = ?)';
        if ($DB->record_exists_select('local_o365_calsub', $usersub, [$userid, 'user', 'out', 'both'])) {
            return;
        }

        $sql = "SELECT ev.id AS eventid, m.id AS idmapid, m.outlookeventid
                  FROM {event} ev
                  JOIN {assign} a ON a.id = ev.instance AND a.course = ?
                  JOIN {local_o365_calidmap} m ON m.eventid = ev.id AND m.userid = ev.userid AND m.origin = ?
                 WHERE ev.modulename = ? AND ev.courseid = 0 AND ev.userid = ? AND ev.eventtype IN (?, ?)";
        $events = $DB->get_records_sql($sql, [$courseid, 'moodle', 'assign', $userid, 'extension', 'due']);
        foreach ($events as $event) {
            mtrace('Moving assignment event #' . $event->eventid . ' to the new calendar.');
            $calsync->delete_event_raw($userid, $event->outlookeventid, $event->idmapid);
            if (!$DB->record_exists('local_o365_calidmap', ['id' => $event->idmapid])) {
                $calsync->create_outlook_event_from_moodle_event($event->eventid);
            }
        }
    }

    /**
     * Sync all site events with Outlook.
     *
     * @param int $timecreated The time the task was created.
     * @param int $opuserid The user id who triggered the task.
     */
    protected function sync_siteevents($timecreated, $opuserid) {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/calendar/lib.php');

        // Remove local imports from O365 for this user if unsubscribed or outward-only.
        $subscription = $DB->get_record(
            'local_o365_calsub',
            ['user_id' => $opuserid, 'caltype' => 'site']
        );
        if (empty($subscription) || $subscription->syncbehav === 'out') {
            $sqlcleanup = 'SELECT ev.id
                             FROM {event} ev
                             JOIN {local_o365_calidmap} m ON m.eventid = ev.id
                            WHERE ev.courseid = ? AND m.userid = ? AND m.origin = ?';
            $cleanuprecords = $DB->get_records_sql($sqlcleanup, [0, $opuserid, 'o365']);
            foreach ($cleanuprecords as $cleanup) {
                mtrace('Removing imported site event #' . $cleanup->id . '.');
                $DB->delete_records('local_o365_calidmap', [
                    'eventid' => $cleanup->id,
                    'origin'  => 'o365',
                ]);
                \calendar_event::load($cleanup->id)->delete();
            }
        }

        $timestart = time();
        // Check the last time site events were synced. Using a direct query here so we don't run into static cache issues.
        $lastsitesync = $DB->get_record('config_plugins', ['plugin' => 'local_o365', 'name' => 'cal_site_lastsync']);
        if (!empty($lastsitesync) && (int)$lastsitesync->value > $timecreated) {
            // Site events have been synced since this event was created, so we don't have to do it again.
            return true;
        }

        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();
        $calsync = new \local_o365\feature\calsync\main($clientdata, $httpclient);

        [$subscribersprimary, $subscribersnotprimary] = $this->get_subscribers('site');

        $sql = 'SELECT ev.id AS eventid,
                       ev.name AS eventname,
                       ev.description AS eventdescription,
                       ev.timestart AS eventtimestart,
                       ev.timeduration AS eventtimeduration,
                       idmap.outlookeventid,
                       ev.userid AS eventuserid,
                       idmap.id AS idmapid
                  FROM {event} ev
             LEFT JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid AND idmap.userid = ev.userid
                 WHERE ev.courseid = ?';
        $params = [SITEID];
        $events = $DB->get_recordset_sql($sql, $params);
        foreach ($events as $event) {
            try {
                mtrace('Syncing site event #' . $event->eventid);

                [$subject, $body] = $this->get_event_content($calsync, $event->eventid);
                $evstart = $event->eventtimestart;
                $evend = $evstart + $event->eventtimeduration;

                // Sync primary cal users first.
                if (!empty($subscribersprimary)) {
                    mtrace('Syncing primary calendar users.');
                    try {
                        // If there's a stored outlookeventid we've already synced to o365 so update it. Otherwise create it.
                        if (!empty($event->outlookeventid)) {
                            try {
                                $calsync->update_shared_event_attendees(
                                    $event->eventuserid,
                                    $event->outlookeventid,
                                    $subscribersprimary,
                                    null
                                );
                            } catch (moodle_exception $e) {
                                mtrace('ERROR: ' . $e->getMessage());
                            }
                        } else {
                            $calid = null;
                            if (!empty($subscribersprimary[$event->eventuserid])) {
                                if (!empty($subscribersprimary[$event->eventuserid]->subo365calid)) {
                                    $calid = $subscribersprimary[$event->eventuserid]->subo365calid;
                                } else {
                                    $calid = null;
                                }
                            } else if (isset($subscribersnotprimary[$event->eventuserid])) {
                                if (!empty($subscribersnotprimary[$event->eventuserid]->subo365calid)) {
                                    $calid = $subscribersnotprimary[$event->eventuserid]->subo365calid;
                                } else {
                                    $calid = null;
                                }
                            }

                            $calsync->create_event_raw(
                                $event->eventuserid,
                                $event->eventid,
                                $subject,
                                $body,
                                $evstart,
                                $evend,
                                $subscribersprimary,
                                [],
                                $calid
                            );
                        }
                    } catch (moodle_exception $e) {
                        mtrace('ERROR: ' . $e->getMessage());
                    }
                }

                // Delete event for users who have an idmap record but are no longer subscribed.
                // Users would have an idmap record if they were non-primary calendar users, and are thus not taken care of with
                // the attendee update done above.
                $idmapnosub = $this->get_event_idmaps_by_userid($event->eventid);
                $idmapnosub = array_diff_key($idmapnosub, $subscribersnotprimary, $subscribersprimary);
                if (!empty($subscribersprimary) && isset($idmapnosub[$event->eventuserid])) {
                    // The combined event lives in the creator's calendar with the primary-calendar
                    // subscribers as its attendees, and the block above has just refreshed that attendee
                    // list - so keep its mapping even when the creator themselves isn't subscribed,
                    // otherwise it would be deleted here and every attendee would lose the event.
                    //
                    // When there are no primary subscribers, though, nothing above maintains a combined
                    // event, so a leftover mapping under the creator's id is just an orphan (e.g. the last
                    // subscriber has now unsubscribed). Don't protect it - let it fall through to the
                    // deletion loop like any other stale mapping.
                    unset($idmapnosub[$event->eventuserid]);
                }

                if (!empty($idmapnosub)) {
                    mtrace('Removing event for users who have unsubscribed.');
                    foreach ($idmapnosub as $userid => $usercalidmap) {
                        $calsync->delete_event_raw($userid, $usercalidmap->outlookeventid, $usercalidmap->id);
                    }
                }

                // Sync non-primary cal users.
                if (!empty($subscribersnotprimary)) {
                    mtrace('Syncing non-primary calendar users.');
                    foreach ($subscribersnotprimary as $userid => $user) {
                        $calid = (!empty($user->subo365calid)) ? $user->subo365calid : null;
                        $calsync->ensure_event_synced_for_user(
                            $event->eventid,
                            $user->id,
                            $subject,
                            $body,
                            $evstart,
                            $evend,
                            $calid
                        );
                    }
                }
            } catch (moodle_exception $e) {
                // Could not sync this site event. Log and continue.
                mtrace('Error syncing site event #' . $event->eventid . ': ' . $e->getMessage());
            }
        }

        $events->close();

        set_config('cal_site_lastsync', $timestart, 'local_o365');
        return true;
    }

    /**
     * Sync all course events for a given course with Outlook.
     *
     * @param int $courseid The ID of the course to sync.
     * @param int $timecreated The time the task was created.
     * @param int $opuserid The user id who triggered the task.
     */
    protected function sync_courseevents($courseid, $timecreated, $opuserid) {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/calendar/lib.php');

        // Remove local imports from O365 for this user if unsubscribed or outward-only.
        $subscription = $DB->get_record(
            'local_o365_calsub',
            ['user_id' => $opuserid, 'caltype' => 'course', 'caltypeid' => $courseid]
        );
        if (empty($subscription) || $subscription->syncbehav === 'out') {
            $sqlcleanup = 'SELECT ev.id
                             FROM {event} ev
                             JOIN {local_o365_calidmap} m ON m.eventid = ev.id
                            WHERE ev.courseid = ? AND m.userid = ? AND m.origin = ?';
            $cleanuprecords = $DB->get_records_sql($sqlcleanup, [$courseid, $opuserid, 'o365']);
            foreach ($cleanuprecords as $cleanup) {
                mtrace('Removing imported course event #' . $cleanup->id . '.');
                $DB->delete_records('local_o365_calidmap', [
                    'eventid' => $cleanup->id,
                    'origin'  => 'o365',
                ]);
                \calendar_event::load($cleanup->id)->delete();
            }
        }

        $timestart = time();
        // Check the last time course events for this course were synced.
        // Using a direct query here so we don't run into static cache issues.
        $lastcoursesync = $DB->get_record('config_plugins', ['plugin' => 'local_o365', 'name' => 'cal_course_lastsync']);
        if (!empty($lastcoursesync)) {
            $lastcoursesync = unserialize($lastcoursesync->value);
            if (isset($lastcoursesync[$courseid]) && (int)$lastcoursesync[$courseid] > $timecreated) {
                // Course events for this course have been synced since this event was created, so we don't have to do it again.
                return true;
            }
        }

        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();
        $calsync = new \local_o365\feature\calsync\main($clientdata, $httpclient);

        [$subscribersprimary, $subscribersnotprimary] = $this->get_subscribers('course', $courseid);

        $allsubscribersprimary = $subscribersprimary;
        $allsubscribersnotprimary = $subscribersnotprimary;

        $sql = 'SELECT ev.id AS eventid,
                       ev.name AS eventname,
                       ev.description AS eventdescription,
                       ev.timestart AS eventtimestart,
                       ev.timeduration AS eventtimeduration,
                       ev.modulename,
                       ev.instance,
                       ev.eventtype,
                       idmap.outlookeventid,
                       ev.userid AS eventuserid,
                       ev.groupid,
                       idmap.id AS idmapid
                  FROM {event} ev
             LEFT JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid AND idmap.userid = ev.userid
                 WHERE ev.courseid = ? ';
        $params = [$courseid];
        $events = $DB->get_recordset_sql($sql, $params);
        foreach ($events as $event) {
            try {
                mtrace('Syncing course event #' . $event->eventid);

                // Module-generated events (e.g. assignment due dates) can have no user; use whoever their shared
                // Outlook event is created as instead, and find the shared event under that user.
                $event->eventuserid = $calsync->get_event_owner_userid((object) [
                    'id' => $event->eventid,
                    'userid' => $event->eventuserid,
                    'courseid' => $courseid,
                ]);
                if (!empty($event->eventuserid) && empty($event->outlookeventid)) {
                    $event->outlookeventid = $DB->get_field(
                        'local_o365_calidmap',
                        'outlookeventid',
                        ['eventid' => $event->eventid, 'userid' => $event->eventuserid, 'origin' => 'moodle'],
                        IGNORE_MULTIPLE
                    );
                }

                if ($calsync->is_grading_due_event($event)) {
                    // An assignment "due to be graded" reminder goes only to users who can grade it, and
                    // never via the course's shared group calendar. Reconcile it through main's shared
                    // attendee logic (which applies the mod/assign:grade filter and creates, updates, or
                    // removes per-user mappings as needed) rather than this task's whole-course-subscriber
                    // attendee model.
                    $calsync->reconcile_course_event_attendees($event->eventid);
                    continue;
                }

                // Only sync the event for users who can actually see the module it belongs to (e.g. not
                // excluded by "Restrict access"). Anyone filtered out here who already has a mapping is
                // treated like an unsubscribed user below, and has their Outlook event removed.
                $isvisible = static function ($subscriber) use ($calsync, $event): bool {
                    return $calsync->is_event_module_visible_to_user($event, (int) $subscriber->id);
                };
                $subscribersprimary = array_filter($allsubscribersprimary, $isvisible);
                $subscribersnotprimary = array_filter($allsubscribersnotprimary, $isvisible);

                // When every subscriber gets their own Outlook event instead of being an attendee of a shared
                // one, none are handled as primary attendees.
                $individualevents = $calsync->sync_course_event_individually((object) [
                    'userid' => $event->eventuserid,
                    'courseid' => $courseid,
                    'groupid' => $event->groupid,
                    'modulename' => $event->modulename,
                    'eventtype' => $event->eventtype,
                ]);
                if ($individualevents) {
                    $subscribersnotprimary = $subscribersprimary + $subscribersnotprimary;
                    $subscribersprimary = [];
                }

                $grouplimit = null;
                // If this is a group event, get members and save for limiting later.
                if (!empty($event->groupid)) {
                    $sql = 'SELECT userid
                              FROM {groups_members}
                             WHERE groupid = ?';
                    $params = [$event->groupid];
                    $grouplimit = $DB->get_records_sql($sql, $params);
                }

                [$subject, $body] = $this->get_event_content($calsync, $event->eventid);
                $evstart = $event->eventtimestart;
                $evend = $evstart + $event->eventtimeduration;

                // Sync primary cal users first.
                if (!empty($subscribersprimary)) {
                    mtrace('Syncing primary calendar users.');
                    try {
                        // Determine attendees - if this is a group event, limit to group members.
                        if ($grouplimit !== null && is_array($grouplimit)) {
                            $eventattendees = array_intersect_key($subscribersprimary, $grouplimit);
                        } else {
                            $eventattendees = $subscribersprimary;
                        }

                        // If there's a stored outlookeventid the event exists in o365, so update it. Otherwise create it.
                        if (!empty($event->outlookeventid)) {
                            try {
                                $calsync->update_shared_event_attendees(
                                    $event->eventuserid,
                                    $event->outlookeventid,
                                    $eventattendees,
                                    empty($event->groupid) ? $calsync->get_course_group_object((object) [
                                        'courseid' => $courseid,
                                        'modulename' => $event->modulename,
                                        'eventtype' => $event->eventtype,
                                    ]) : null
                                );
                            } catch (moodle_exception $e) {
                                // Do nothing.
                                mtrace('Error updating event #' . $event->eventid . ': ' . $e->getMessage());
                            }
                        } else {
                            $calid = null;
                            if (!empty($subscribersprimary[$event->eventuserid])) {
                                if (!empty($subscribersprimary[$event->eventuserid]->subo365calid)) {
                                    $calid = $subscribersprimary[$event->eventuserid]->subo365calid;
                                } else {
                                    $calid = null;
                                }
                            } else if (isset($subscribersnotprimary[$event->eventuserid])) {
                                if (!empty($subscribersnotprimary[$event->eventuserid]->subo365calid)) {
                                    $calid = $subscribersnotprimary[$event->eventuserid]->subo365calid;
                                } else {
                                    $calid = null;
                                }
                            }

                            $calsync->create_event_raw(
                                $event->eventuserid,
                                $event->eventid,
                                $subject,
                                $body,
                                $evstart,
                                $evend,
                                $eventattendees,
                                [],
                                $calid
                            );
                        }
                    } catch (moodle_exception $e) {
                        mtrace('ERROR: ' . $e->getMessage());
                    }
                }

                // Delete event for users who have an idmap record but are no longer subscribed.
                // Users would have an idmap record if they were non-primary calendar users, and are thus not taken care of with
                // the attendee update done above.
                $idmaps = $this->get_event_idmaps_by_userid($event->eventid);
                $idmapnosub = $idmaps;
                $idmapnosub = array_diff_key($idmapnosub, $subscribersnotprimary, $subscribersprimary);
                if (!empty($subscribersprimary) && isset($idmapnosub[$event->eventuserid])) {
                    // The combined event lives in the creator's calendar with the primary-calendar
                    // subscribers as its attendees, and the block above has just refreshed that attendee
                    // list - so keep its mapping even when the creator themselves isn't subscribed,
                    // otherwise it would be deleted here and every attendee would lose the event.
                    //
                    // When there are no primary subscribers, though, nothing above maintains a combined
                    // event, so a leftover mapping under the creator's id is just an orphan (e.g. the last
                    // subscriber has now unsubscribed). Don't protect it - let it fall through to the
                    // deletion loop like any other stale mapping.
                    unset($idmapnosub[$event->eventuserid]);
                }

                // With no primary subscribers left, nothing above updates the shared event's attendees, so it
                // would stay in the calendar of whoever was on it. That's always the case when events are synced
                // individually, where this also converts a shared event from before that was configured. Delete it
                // (group-aware, and including the attendees' copies) - this runs whether or not the creator is
                // still subscribed themselves, as the non-primary sync below recreates everyone's own event.
                if (empty($subscribersprimary) && isset($idmaps[$event->eventuserid])) {
                    $fullevent = $DB->get_record('event', ['id' => $event->eventid]);
                    $groupobject = (empty($event->groupid) && $fullevent) ? $calsync->get_course_group_object($fullevent) : null;
                    if ($fullevent && $calsync->delete_shared_event($idmaps[$event->eventuserid], $fullevent, $groupobject)) {
                        unset($idmapnosub[$event->eventuserid]);
                    }
                }

                if (!empty($idmapnosub)) {
                    mtrace('Removing event for users who have unsubscribed.');
                    foreach ($idmapnosub as $userid => $usercalidmap) {
                        $calsync->delete_event_raw($userid, $usercalidmap->outlookeventid, $usercalidmap->id);
                    }
                }

                // Sync non-primary cal users.
                if (!empty($subscribersnotprimary)) {
                    mtrace('Syncing non-primary calendar users.');
                    foreach ($subscribersnotprimary as $userid => $user) {
                        // If we're syncing a group event, only sync users in the group.
                        if ($grouplimit !== null && is_array($grouplimit) && !isset($grouplimit[$user->id])) {
                            continue;
                        }

                        $calid = (!empty($user->subo365calid)) ? $user->subo365calid : null;
                        if ($individualevents && !empty($user->subisprimary)) {
                            $calid = null;
                        }

                        $calsync->ensure_event_synced_for_user(
                            $event->eventid,
                            $user->id,
                            $subject,
                            $body,
                            $evstart,
                            $evend,
                            $calid
                        );
                    }
                }
            } catch (moodle_exception $e) {
                // Could not sync this course event. Log and continue.
                mtrace('Error syncing course event #' . $event->eventid . ': ' . $e->getMessage());
            }
        }

        $events->close();

        if (!empty($lastcoursesync) && is_array($lastcoursesync)) {
            $lastcoursesync[$courseid] = $timestart;
        } else {
            $lastcoursesync = [$courseid => $timestart];
        }

        $lastcoursesync = serialize($lastcoursesync);

        set_config('cal_course_lastsync', $lastcoursesync, 'local_o365');

        return true;
    }

    /**
     * Sync all user events for a given user with Outlook.
     *
     * @param int $userid The ID of the user to sync.
     * @param int $timecreated The time the task was created.
     */
    protected function sync_userevents($userid, $timecreated) {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/calendar/lib.php');

        // Remove local imports from O365 for this user if unsubscribed or outward-only.
        $subscription = $DB->get_record('local_o365_calsub', ['user_id' => $userid, 'caltype' => 'user']);
        if (empty($subscription) || $subscription->syncbehav === 'out') {
            $sqlcleanup = 'SELECT ev.id
                             FROM {event} ev
                        LEFT JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid AND idmap.userid = ev.userid
                            WHERE ev.courseid = 0
                              AND ev.groupid = 0
                              AND ev.userid = ?
                              AND idmap.origin = ?';
            $cleanuprecords = $DB->get_records_sql($sqlcleanup, [$userid, 'o365']);
            foreach ($cleanuprecords as $cleanup) {
                mtrace('Cleanup(user): removing imported user event #' . $cleanup->id . '.');
                $DB->delete_records('local_o365_calidmap', [
                    'eventid' => $cleanup->id,
                    'origin'  => 'o365',
                ]);
                \calendar_event::load($cleanup->id)->delete();
            }
        }

        $timestart = time();
        // Check the last time user events for this user were synced.
        // Using a direct query here so we don't run into static cache issues.
        $lastusersync = $DB->get_record('config_plugins', ['plugin' => 'local_o365', 'name' => 'cal_user_lastsync']);
        if (!empty($lastusersync)) {
            $lastusersync = unserialize($lastusersync->value);
            if (is_array($lastusersync) && isset($lastusersync[$userid]) && (int)$lastusersync[$userid] > $timecreated) {
                // User events for this user have been synced since this event was created, so we don't have to do it again.
                return true;
            }
        }

        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();
        $calsync = new \local_o365\feature\calsync\main($clientdata, $httpclient);

        $usertoken = $calsync->get_user_token($userid);
        if (empty($usertoken)) {
            // No token, can't sync.
            utils::debug('Could not get user token for calendar sync.', __METHOD__);
            return false;
        }

        $sql = 'SELECT ev.id AS eventid,
                       ev.name AS eventname,
                       ev.description AS eventdescription,
                       ev.timestart AS eventtimestart,
                       ev.timeduration AS eventtimeduration,
                       idmap.outlookeventid,
                       idmap.origin AS idmaporigin
                  FROM {event} ev
             LEFT JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid AND idmap.userid = ev.userid
                 WHERE ev.courseid = 0
                       AND ev.groupid = 0
                       AND ev.userid = ?';
        $events = $DB->get_recordset_sql($sql, [$userid]);
        foreach ($events as $event) {
            mtrace('Syncing user event #' . $event->eventid);
            if (!empty($subscription)) {
                if (empty($event->outlookeventid)) {
                    // Event not synced, if outward subscription exists sync to o365.
                    if ($subscription->syncbehav === 'out' || $subscription->syncbehav === 'both') {
                        mtrace('Creating event in Outlook.');
                        [$subject, $body] = $this->get_event_content($calsync, $event->eventid);
                        $evstart = $event->eventtimestart;
                        $evend = $event->eventtimestart + $event->eventtimeduration;
                        $calid = (!empty($subscription->o365calid)) ? $subscription->o365calid : null;
                        if (isset($subscription->isprimary) && $subscription->isprimary == 1) {
                            $calid = null;
                        }

                        $calsync->create_event_raw($userid, $event->eventid, $subject, $body, $evstart, $evend, [], [], $calid);
                    } else {
                        mtrace('Not creating event in Outlook. (Sync settings are inward-only.)');
                    }
                } else {
                    // Event synced. If event was created in Moodle and subscription is inward-only, delete o365 event.
                    if ($event->idmaporigin === 'moodle' && $subscription->syncbehav === 'in') {
                        mtrace('Removing event from Outlook (Created in Moodle, sync settings are inward-only.)');
                        $calsync->delete_event_raw($userid, $event->outlookeventid);
                    } else {
                        mtrace('Event already synced.');
                    }
                }
            } else {
                // No subscription exists. Delete relevant events.
                if (!empty($event->outlookeventid)) {
                    if ($event->idmaporigin === 'moodle') {
                        mtrace('Removing event from Outlook.');
                        // Event was created in Moodle, delete o365 event.
                        $calsync->delete_event_raw($userid, $event->outlookeventid);
                    } else {
                        mtrace('Not removing event from Outlook (It was created there.)');
                    }
                } else {
                    mtrace('Did not have an outlookeventid. Event not synced?');
                }
            }
        }

        $events->close();

        if (!empty($lastusersync) && is_array($lastusersync)) {
            $lastusersync[$userid] = $timestart;
        } else {
            $lastusersync = [$userid => $timestart];
        }

        $lastusersync = serialize($lastusersync);

        set_config('cal_user_lastsync', $lastusersync, 'local_o365');

        return true;
    }

    /**
     * Do the job.
     */
    public function execute() {
        $opdata = $this->get_custom_data();
        $timecreated = (isset($opdata->timecreated)) ? $opdata->timecreated : time();

        if (utils::is_connected() !== true) {
            utils::debug(get_string('erroracpauthoidcnotconfig', 'local_o365'), __METHOD__);
            return false;
        }

        if (!empty($opdata->calendarchanged)) {
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            $calsync = new \local_o365\feature\calsync\main($clientdata, new \local_o365\httpclient());
            $this->remove_user_events_for_calendar_change(
                $calsync,
                $opdata->caltype,
                $opdata->caltypeid,
                $opdata->userid
            );
            if ($opdata->caltype === 'course') {
                $this->move_assign_personal_events($calsync, $opdata->caltypeid, $opdata->userid);
            }
        }

        // Sync site events.
        if ($opdata->caltype === 'site') {
            $this->sync_siteevents($timecreated, $opdata->userid);
        } else if ($opdata->caltype === 'course') {
            $this->sync_courseevents($opdata->caltypeid, $timecreated, $opdata->userid);
        } else if ($opdata->caltype === 'user') {
            $this->sync_userevents($opdata->userid, $timecreated);
        }
    }
}
