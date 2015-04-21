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

namespace local_o365\task;

/**
 * AdHoc task to sync Moodle calendar events with Office365.
 */
class calendarsync extends \core\task\adhoc_task {
    /**
     * Ensures an event is synced for a *single* user.
     *
     * @param \local_o365\rest\calendar $cal The calendar object to use.
     * @param int $eventid The ID of the event.
     * @param int $userid The ID of the user who will own the event.
     * @param string $subject The event's subject.
     * @param string $body The body text of the event.
     * @param int $timestart The timestamp for the event's start.
     * @param int $timeend The timestamp for the event's end.
     * @param string $calid The o365 ID of the calendar to create the event in.
     * @return int The new ID from local_o365_calidmap.
     */
    protected function ensure_event_synced_for_user(\local_o365\rest\calendar $cal, $eventid, $userid, $subject, $body, $timestart,
                                                    $timeend, $calid) {
        global $DB;
        $eventsynced = $DB->record_exists('local_o365_calidmap', ['eventid' => $eventid, 'userid' => $userid]);
        if (!$eventsynced) {
            return $this->create_event($cal, $eventid, $userid, $subject, $body, $timestart, $timeend, [], $calid);
        }
    }

    /**
     * Create and store an event.
     *
     * @param \local_o365\rest\calendar $cal The calendar object to use.
     * @param int $eventid The ID of the event.
     * @param int $userid The ID of the user who will own the event.
     * @param string $subject The event's subject.
     * @param string $body The body text of the event.
     * @param int $timestart The timestamp for the event's start.
     * @param int $timeend The timestamp for the event's end.
     * @param array $attendees A list of users to include as event attendees.
     * @param string $calid The o365 ID of the calendar to create the event in.
     * @return int The new ID from local_o365_calidmap.
     */
    protected function create_event(\local_o365\rest\calendar $cal, $eventid, $userid, $subject, $body, $timestart,
                                              $timeend, $attendees, $calid = null) {
        global $DB;
        $response = $cal->create_event($subject, $body, $timestart, $timeend, $attendees, [], $calid);
        if (!empty($response) && is_array($response) && isset($response['Id'])) {
            $idmaprec = [
                'eventid' => $eventid,
                'outlookeventid' => $response['Id'],
                'userid' => $userid,
                'origin' => 'moodle',
            ];
            return $DB->insert_record('local_o365_calidmap', (object)$idmaprec);
        }
    }

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
     * Sync all site events with Outlook.
     *
     * @param int $timecreated The time the task was created.
     */
    protected function sync_siteevents($timecreated) {
        global $DB;
        $timestart = time();
        // Check the last time site events were synced. Using a direct query here so we don't run into static cache issues.
        $lastsitesync = $DB->get_record('config_plugins', ['plugin' => 'local_o365', 'name' => 'cal_site_lastsync']);
        if (!empty($lastsitesync) && (int)$lastsitesync->value > $timecreated) {
            // Site events have been synced since this event was created, so we don't have to do it again.
            return true;
        }

        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $outlookresource = \local_o365\rest\calendar::get_resource();
        $httpclient = new \local_o365\httpclient();

        list($subscribersprimary, $subscribersnotprimary) = $this->get_subscribers('site');

        $sql = 'SELECT ev.id AS eventid,
                       ev.name AS eventname,
                       ev.description AS eventdescription,
                       ev.timestart AS eventtimestart,
                       ev.timeduration AS eventtimeduration,
                       idmap.outlookeventid,
                       ev.userid AS eventuserid
                  FROM {event} ev
             LEFT JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid AND idmap.userid = ev.userid
                 WHERE ev.courseid = ?';
        $params = [SITEID];
        $events = $DB->get_recordset_sql($sql, $params);
        foreach ($events as $event) {
            try {
                mtrace('Syncing site event #'.$event->eventid);
                $subject = $event->eventname;
                $body = $event->eventdescription;
                $evstart = $event->eventtimestart;
                $evend = $evstart + $event->eventtimeduration;
                // Sync primary cal users first.
                if (!empty($subscribersprimary)) {
                    // Get token for event creator, fall back to system token if no user token.
                    $token = \local_o365\oauth2\token::instance($event->eventuserid, $outlookresource, $clientdata, $httpclient);
                    if (empty($token)) {
                        mtrace('No user token present, attempting to get system token.');
                        $token = \local_o365\oauth2\systemtoken::instance(null, $outlookresource, $clientdata, $httpclient);
                    }

                    if (!empty($token)) {
                        $cal = new \local_o365\rest\calendar($token, $httpclient);
                        // If there's a stored outlookeventid we've already synced to o365 so update it. Otherwise create it.
                        if (!empty($event->outlookeventid)) {
                            $cal->update_event($event->outlookeventid, ['attendees' => $subscribersprimary]);
                        } else {
                            $calid = null;
                            if (!empty($subscribersprimary[$event->eventuserid])) {
                                $calid = (!empty($subscribersprimary[$event->eventuserid]->subo365calid))
                                    ? $subscribersprimary[$event->eventuserid]->subo365calid : null;
                            } else if (isset($subscribersnotprimary[$event->eventuserid])) {
                                $calid = (!empty($subscribersnotprimary[$event->eventuserid]->subo365calid))
                                    ? $subscribersnotprimary[$event->eventuserid]->subo365calid : null;
                            }
                            $this->create_event($cal, $event->eventid, $event->eventuserid, $subject, $body, $evstart, $evend,
                                    $subscribersprimary, $calid);
                        }
                    } else {
                        mtrace('Could not get any valid token for primary calendar sync.');
                    }
                }

                // Delete event for users who have an idmap record but are no longer subscribed.
                $sql = 'SELECT userid, id, eventid, outlookeventid FROM {local_o365_calidmap} WHERE eventid = ? AND origin = ?';
                $idmapnosub = $DB->get_records_sql($sql, [$event->eventid, 'moodle']);
                $idmapnosub = array_diff_key($idmapnosub, $subscribersnotprimary, $subscribersprimary);
                if (isset($idmapnosub[$event->eventuserid])) {
                    unset($idmapnosub[$event->eventuserid]);
                }
                foreach ($idmapnosub as $userid => $usercalidmap) {
                    $token = \local_o365\oauth2\token::instance($userid, $outlookresource, $clientdata, $httpclient);
                    if (!empty($token)) {
                        $cal = new \local_o365\rest\calendar($token, $httpclient);
                        $response = $cal->delete_event($usercalidmap->outlookeventid);
                        $DB->delete_records('local_o365_calidmap', ['id' => $usercalidmap->id]);
                    }
                }

                // Sync non-primary cal users.
                if (!empty($subscribersnotprimary)) {
                    foreach ($subscribersnotprimary as $userid => $user) {
                        $token = \local_o365\oauth2\token::instance($userid, $outlookresource, $clientdata, $httpclient);
                        if (!empty($token)) {
                            $cal = new \local_o365\rest\calendar($token, $httpclient);
                            $calid = (!empty($user->subo365calid)) ? $user->subo365calid : null;
                            $this->ensure_event_synced_for_user($cal, $event->eventid, $user->id, $subject, $body, $evstart,
                                    $evend, $calid);
                        }
                    }
                }

            } catch (\Exception $e) {
                // Could not sync this site event. Log and continue.
                mtrace('Error syncing site event #'.$event->eventid.': '.$e->getMessage());
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
     */
    protected function sync_courseevents($courseid, $timecreated) {
        global $DB;
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
        $outlookresource = \local_o365\rest\calendar::get_resource();
        $httpclient = new \local_o365\httpclient();

        list($subscribersprimary, $subscribersnotprimary) = $this->get_subscribers('course', $courseid);

        $sql = 'SELECT ev.id AS eventid,
                       ev.name AS eventname,
                       ev.description AS eventdescription,
                       ev.timestart AS eventtimestart,
                       ev.timeduration AS eventtimeduration,
                       idmap.outlookeventid,
                       ev.userid AS eventuserid,
                       ev.groupid
                  FROM {event} ev
             LEFT JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid AND idmap.userid = ev.userid
                 WHERE ev.courseid = ? ';
        $params = [$courseid];
        $events = $DB->get_recordset_sql($sql, $params);
        foreach ($events as $event) {
            try {
                mtrace('Syncing course event #'.$event->eventid);
                $grouplimit = null;
                // If this is a group event, get members and save for limiting later.
                if (!empty($event->groupid)) {
                    $sql = 'SELECT userid
                              FROM {groups_members}
                             WHERE grpmbr.groupid = ?';
                    $params = [$event->groupid];
                    $grouplimit = $DB->get_records_sql($sql, $params);
                }

                $subject = $event->eventname;
                $body = $event->eventdescription;
                $evstart = $event->eventtimestart;
                $evend = $evstart + $event->eventtimeduration;

                // Sync primary cal users first.
                if (!empty($subscribersprimary)) {
                    // Get token for event creator, fall back to system token if no user token.
                    $token = \local_o365\oauth2\token::instance($event->eventuserid, $outlookresource, $clientdata, $httpclient);
                    if (empty($token)) {
                        mtrace('No user token present, attempting to get system token.');
                        $token = \local_o365\oauth2\systemtoken::instance(null, $outlookresource, $clientdata, $httpclient);
                    }

                    if (!empty($token)) {
                        $cal = new \local_o365\rest\calendar($token, $httpclient);

                        // Determine attendees - if this is a group event, limit to group members.
                        $eventattendees = ($grouplimit !== null && is_array($grouplimit))
                            ? array_intersect_key($subscribersprimary, $grouplimit)
                            : $subscribersprimary;

                        // If there's a stored outlookeventid the event exists in o365, so update it. Otherwise create it.
                        if (!empty($event->outlookeventid)) {
                            $cal->update_event($event->outlookeventid, ['attendees' => $eventattendees]);
                        } else {
                            $calid = null;
                            if (!empty($subscribersprimary[$event->eventuserid])) {
                                $calid = (!empty($subscribersprimary[$event->eventuserid]->subo365calid))
                                    ? $subscribersprimary[$event->eventuserid]->subo365calid : null;
                            } else if (isset($subscribersnotprimary[$event->eventuserid])) {
                                $calid = (!empty($subscribersnotprimary[$event->eventuserid]->subo365calid))
                                    ? $subscribersnotprimary[$event->eventuserid]->subo365calid : null;
                            }
                            $this->create_event($cal, $event->eventid, $event->eventuserid, $subject, $body, $evstart, $evend,
                                    $eventattendees, $calid);
                        }
                    } else {
                        mtrace('Could not get any valid token for primary calendar sync.');
                    }
                }

                // Delete event for users who have an idmap record but are no longer subscribed.
                $sql = 'SELECT userid, id, eventid, outlookeventid FROM {local_o365_calidmap} WHERE eventid = ? AND origin = ?';
                $idmapnosub = $DB->get_records_sql($sql, [$event->eventid, 'moodle']);
                $idmapnosub = array_diff_key($idmapnosub, $subscribersnotprimary, $subscribersprimary);
                if (isset($idmapnosub[$event->eventuserid])) {
                    unset($idmapnosub[$event->eventuserid]);
                }
                foreach ($idmapnosub as $userid => $usercalidmap) {
                    $token = \local_o365\oauth2\token::instance($userid, $outlookresource, $clientdata, $httpclient);
                    if (!empty($token)) {
                        $cal = new \local_o365\rest\calendar($token, $httpclient);
                        $response = $cal->delete_event($usercalidmap->outlookeventid);
                        $DB->delete_records('local_o365_calidmap', ['id' => $usercalidmap->id]);
                    }
                }

                // Sync non-primary cal users.
                if (!empty($subscribersnotprimary)) {
                    foreach ($subscribersnotprimary as $userid => $user) {
                        // If we're syncing a group event, only sync users in the group.
                        if ($grouplimit !== null && is_array($grouplimit) && !isset($grouplimit[$user->id])) {
                            continue;
                        }
                        $token = \local_o365\oauth2\token::instance($userid, $outlookresource, $clientdata, $httpclient);
                        if (!empty($token)) {
                            $cal = new \local_o365\rest\calendar($token, $httpclient);
                            $calid = (!empty($user->subo365calid)) ? $user->subo365calid : null;
                            $this->ensure_event_synced_for_user($cal, $event->eventid, $user->id, $subject, $body, $evstart,
                                    $evend, $calid);
                        }
                    }
                }
            } catch (\Exception $e) {
                // Could not sync this course event. Log and continue.
                mtrace('Error syncing course event #'.$event->eventid.': '.$e->getMessage());
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
        global $DB;
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
        $outlookresource = \local_o365\rest\calendar::get_resource();
        $httpclient = new \local_o365\httpclient();

        $usertoken = \local_o365\oauth2\token::instance($userid, $outlookresource, $clientdata, $httpclient);
        if (empty($usertoken)) {
            // No token, can't sync.
            return false;
        }

        $subscription = $DB->get_record('local_o365_calsub', ['user_id' => $userid, 'caltype' => 'user']);

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
            mtrace('Syncing user event #'.$event->eventid);
            if (!empty($subscription)) {
                if (empty($event->outlookeventid)) {
                    // Event not synced, if outward subscription exists sync to o365.
                    if ($subscription->syncbehav === 'out' || $subscription->syncbehav === 'both') {
                        $cal = new \local_o365\rest\calendar($usertoken, $httpclient);
                        $subject = $event->eventname;
                        $body = $event->eventdescription;
                        $evstart = $event->eventtimestart;
                        $evend = $event->eventtimestart + $event->eventtimeduration;
                        $calid = (!empty($subscription->o365calid)) ? $subscription->o365calid : null;
                        $this->create_event($cal, $event->eventid, $userid, $subject, $body, $evstart, $evend, [], $calid);
                    }
                } else {
                    // Event synced. If event was created in Moodle and subscription is inward-only, delete o365 event.
                    if ($event->idmaporigin === 'moodle' && $subscription->syncbehav === 'in') {
                        $cal = new \local_o365\rest\calendar($usertoken, $httpclient);
                        $response = $cal->delete_event($event->outlookeventid);
                        $DB->delete_records('local_o365_calidmap', ['outlookeventid' => $event->outlookeventid]);
                    }
                }
            } else {
                // No subscription exists. Delete relevant events.
                if (!empty($event->outlookeventid)) {
                    if ($event->idmaporigin === 'moodle') {
                        // Event was created in Moodle, delete o365 event.
                        $cal = new \local_o365\rest\calendar($usertoken, $httpclient);
                        $response = $cal->delete_event($event->outlookeventid);
                        $DB->delete_records('local_o365_calidmap', ['outlookeventid' => $event->outlookeventid]);
                    }
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

        // Sync site events.
        if ($opdata->caltype === 'site') {
            $this->sync_siteevents($timecreated);
        } else if ($opdata->caltype === 'course') {
            $this->sync_courseevents($opdata->caltypeid, $timecreated);
        } else if ($opdata->caltype === 'user') {
            $this->sync_userevents($opdata->userid, $timecreated);
        }
    }
}