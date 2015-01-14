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

namespace local_o365\task;

/**
 * AdHoc task to sync Moodle calendar events with Office365.
 */
class calendarsync extends \core\task\adhoc_task {
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

        $oidcconfig = get_config('auth_oidc');
        $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint,
                $oidcconfig->tokenendpoint);
        $outlookresource = \local_o365\rest\calendar::get_resource();
        $httpclient = new \local_o365\httpclient();

        $siteeventssubscriberssql = 'SELECT u.id, u.email, u.firstname, u.lastname
                                       FROM {user} u
                                       JOIN {local_o365_calsub} sub ON sub.user_id = u.id
                                      WHERE sub.caltype = "site"';
        $siteeventssubscribers = $DB->get_records_sql($siteeventssubscriberssql);

        $siteeventssql = 'SELECT ev.id,
                                 idmap.outlookeventid,
                                 ev.userid,
                                 tok.token,
                                 tok.expiry AS tokenexpiry,
                                 tok.refreshtoken,
                                 tok.scope AS tokenscope,
                                 tok.resource AS tokenresource
                            FROM {event} ev
                            JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid
                       LEFT JOIN {local_o365_token} tok ON tok.user_id = ev.userid
                           WHERE ev.courseid = ? AND tok.resource = ?';
        $siteevents = $DB->get_recordset_sql($siteeventssql, [SITEID, $outlookresource]);
        foreach ($siteevents as $siteevent) {
            if (!empty($siteevent->token)) {
                mtrace('Syncing site event #'.$siteevent->id.' with user token.');
                $token = new \local_o365\oauth2\token($siteevent->token, $siteevent->tokenexpiry, $siteevent->refreshtoken,
                        $siteevent->tokenscope, $siteevent->tokenresource, $clientdata, $httpclient);
            } else {
                mtrace('Syncing site event #'.$siteevent->id.' with system token.');
                $token = \local_o365\oauth2\systemtoken::instance($outlookresource, $clientdata, $httpclient);
            }
            $cal = new \local_o365\rest\calendar($token, $httpclient);
            $cal->update_event($siteevent->outlookeventid, ['attendees' => $siteeventssubscribers]);
        }
        $siteevents->close();

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

        $oidcconfig = get_config('auth_oidc');
        $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint,
                $oidcconfig->tokenendpoint);
        $outlookresource = \local_o365\rest\calendar::get_resource();
        $httpclient = new \local_o365\httpclient();

        $courseeventssubscriberssql = 'SELECT u.id, u.email, u.firstname, u.lastname
                                         FROM {user} u
                                         JOIN {local_o365_calsub} sub ON sub.user_id = u.id
                                        WHERE sub.caltype = "course" AND sub.caltypeid = ?';
        $courseeventssubscribers = $DB->get_records_sql($courseeventssubscriberssql, [$courseid]);

        $courseeventssql = 'SELECT ev.id,
                                   idmap.outlookeventid,
                                   ev.userid,
                                   ev.groupid,
                                   tok.token,
                                   tok.expiry AS tokenexpiry,
                                   tok.refreshtoken,
                                   tok.scope AS tokenscope,
                                   tok.resource AS tokenresource
                              FROM {event} ev
                              JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid
                         LEFT JOIN {local_o365_token} tok ON tok.user_id = ev.userid
                             WHERE ev.courseid = ? AND tok.resource = ?';
        $courseevents = $DB->get_recordset_sql($courseeventssql, [$courseid, $outlookresource]);
        foreach ($courseevents as $courseevent) {
            try {
                if (!empty($courseevent->token)) {
                    mtrace('Syncing course event #'.$courseevent->id.' with user token.');
                    $token = new \local_o365\oauth2\token($courseevent->token, $courseevent->tokenexpiry, $courseevent->refreshtoken,
                            $courseevent->tokenscope, $courseevent->tokenresource, $clientdata, $httpclient);
                } else {
                    mtrace('Syncing course event #'.$courseevent->id.' with system token.');
                    $token = \local_o365\oauth2\systemtoken::instance($outlookresource, $clientdata, $httpclient);
                }
                $cal = new \local_o365\rest\calendar($token, $httpclient);
                if (!empty($courseevent->groupid)) {
                    $groupeventsubscriberssql = 'SELECT u.id, u.email, u.firstname, u.lastname
                                                   FROM {user} u
                                                   JOIN {local_o365_calsub} sub ON sub.user_id = u.id
                                                   JOIN {groups_members} grpmbr ON grpmbr.userid = u.id
                                                  WHERE sub.caltype = "course" AND sub.caltypeid = ? AND grpmbr.groupid = ?';
                    $groupeventsubscribers = $DB->get_records_sql($groupeventsubscriberssql, [$courseid, $courseevent->groupid]);
                    $cal->update_event($courseevent->outlookeventid, ['attendees' => $groupeventsubscribers]);
                } else {
                    $cal->update_event($courseevent->outlookeventid, ['attendees' => $courseeventssubscribers]);
                }
            } catch (\Exception $e) {
                // Could not sync this course event. Continue on.
                mtrace('Error syncing course event #'.$courseevent->id.': '.$e->getMessage());
            }
        }
        $courseevents->close();

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
            if (isset($lastusersync[$userid]) && (int)$lastusersync[$userid] > $timecreated) {
                // User events for this user have been synced since this event was created, so we don't have to do it again.
                return true;
            }
        }

        $oidcconfig = get_config('auth_oidc');
        $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint,
                $oidcconfig->tokenendpoint);
        $outlookresource = \local_o365\rest\calendar::get_resource();
        $httpclient = new \local_o365\httpclient();

        $usereventssql = 'SELECT ev.id,
                                 ev.name,
                                 ev.description,
                                 ev.timestart,
                                 ev.timeduration,
                                 idmap.outlookeventid,
                                 sub.id AS calsubid,
                                 tok.token,
                                 tok.expiry AS tokenexpiry,
                                 tok.refreshtoken,
                                 tok.scope AS tokenscope,
                                 tok.resource AS tokenresource
                            FROM {event} ev
                            JOIN {local_o365_token} tok ON tok.user_id = ev.userid
                       LEFT JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid
                       LEFT JOIN {local_o365_calsub} sub ON sub.user_id = ev.userid AND sub.caltype = "user"
                           WHERE tok.resource = ? AND ev.courseid = 0 AND ev.groupid = 0 AND ev.userid = ?';
        $userevents = $DB->get_recordset_sql($usereventssql, [$outlookresource, $userid]);
        foreach ($userevents as $userevent) {
            mtrace('Syncing user event #'.$userevent->id);
            if (!empty($userevent->calsubid)) {
                // Subscribed. Perform sync on unsynced events.
                if (empty($userevent->outlookeventid)) {
                    // Event not synced. Create o365 event.
                    $token = new \local_o365\oauth2\token($userevent->token, $userevent->tokenexpiry, $userevent->refreshtoken,
                            $userevent->tokenscope, $userevent->tokenresource, $clientdata, $httpclient);
                    $cal = new \local_o365\rest\calendar($token, $httpclient);
                    $subject = $userevent->name;
                    $body = $userevent->description;
                    $starttime = $userevent->timestart;
                    $endtime = $userevent->timestart + $userevent->timeduration;
                    $response = $cal->create_event($subject, $body, $starttime, $endtime, []);
                    // Store ID.
                    if (!empty($response) && is_array($response)) {
                        if (isset($response['Id'])) {
                            $idmaprec = [
                                'eventid' => $userevent->id,
                                'outlookeventid' => $response['Id'],
                            ];
                            $DB->insert_record('local_o365_calidmap', (object)$idmaprec);
                        }
                    }
                } else {
                    // Event synced. Nothing to do.
                }
            } else {
                // Not subscribed. Delete synced events.
                if (!empty($userevent->outlookeventid)) {
                    // Event synced. Deleted o365 event.
                    $token = new \local_o365\oauth2\token($userevent->token, $userevent->tokenexpiry, $userevent->refreshtoken,
                            $userevent->tokenscope, $userevent->tokenresource, $clientdata, $httpclient);
                    $cal = new \local_o365\rest\calendar($token, $httpclient);
                    $response = $cal->delete_event($userevent->outlookeventid);
                    $DB->delete_records('local_o365_calidmap', ['outlookeventid' => $userevent->outlookeventid]);
                } else {
                    // Event not synced. Nothing to do.
                }
            }
        }
        $userevents->close();

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