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

/**
 * Class for handling cron operations.
 */
class cron {
    /**
     * Execute queued cron calendar operations.
     *
     * @param array $ops Array of calendar operation records.
     * @return bool Success/Failure.
     */
    protected function runcalendarops($ops) {
        global $DB;
        if (empty($ops)) {
            return true;
        }

        $syncsite = false;
        $syncusers = [];
        $synccourses = [];

        // Consolidate.
        foreach ($ops as $i => $op) {
            $opdata = unserialize($op->data);

            if ($opdata['caltype'] === 'site') {
                $syncsite = true;
            } else if ($opdata['caltype'] === 'user') {
                $syncusers[$opdata['userid']] = $opdata['userid'];
            } else if ($opdata['caltype'] === 'course') {
                $synccourses[$opdata['caltypeid']] = $opdata['caltypeid'];
            }

            unset($ops[$i]);
        }

        $oidcconfig = get_config('auth_oidc');
        $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint,
                $oidcconfig->tokenendpoint);
        $httpclient = new \local_o365\httpclient();
        $outlookresource = \local_o365\rest\calendar::get_resource();

        // Sync site events.
        if ($syncsite === true) {
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
                                JOIN {local_o365_token} tok ON tok.user_id = ev.userid
                               WHERE ev.courseid = ? AND tok.resource = ?';
            $siteevents = $DB->get_recordset_sql($siteeventssql, [SITEID, $outlookresource]);
            foreach ($siteevents as $siteevent) {
                mtrace('Syncing event #'.$siteevent->id);
                $token = new \local_o365\oauth2\token($siteevent->token, $siteevent->tokenexpiry, $siteevent->refreshtoken,
                        $siteevent->tokenscope, $siteevent->tokenresource, $clientdata, $httpclient);
                $cal = new \local_o365\rest\calendar($token, $httpclient);
                $cal->update_event($siteevent->outlookeventid, ['attendees' => $siteeventssubscribers]);
            }
            $siteevents->close();
        }

        // Sync user events.
        if (!empty($syncusers)) {
            // Determine current subscription setting.
            list($syncuserinorequalsql, $syncuserinorequalparams) = $DB->get_in_or_equal($syncusers);

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
                               WHERE tok.resource = ? AND ev.courseid = 0 AND ev.groupid = 0 AND ev.userid '.$syncuserinorequalsql;
            $params = array_merge([$outlookresource], $syncuserinorequalparams);
            $userevents = $DB->get_recordset_sql($usereventssql, $params);
            foreach ($userevents as $userevent) {
                mtrace('Syncing event #'.$userevent->id);
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
        }

        // Sync course events.
        foreach ($synccourses as $courseid) {
            $courseeventssubscriberssql = 'SELECT u.id, u.email, u.firstname, u.lastname
                                             FROM {user} u
                                             JOIN {local_o365_calsub} sub ON sub.user_id = u.id
                                            WHERE sub.caltype = "course" AND sub.caltypeid = ?';
            $courseeventssubscribers = $DB->get_records_sql($courseeventssubscriberssql, [$courseid]);

            $courseeventssql = 'SELECT ev.id,
                                       idmap.outlookeventid,
                                       ev.userid,
                                       tok.token,
                                       tok.expiry AS tokenexpiry,
                                       tok.refreshtoken,
                                       tok.scope AS tokenscope,
                                       tok.resource AS tokenresource
                                  FROM {event} ev
                                  JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid
                                  JOIN {local_o365_token} tok ON tok.user_id = ev.userid
                                 WHERE ev.courseid = ? AND tok.resource = ?';
            $courseevents = $DB->get_recordset_sql($courseeventssql, [$courseid, $outlookresource]);
            foreach ($courseevents as $courseevent) {
                mtrace('Syncing event #'.$courseevent->id);
                $token = new \local_o365\oauth2\token($courseevent->token, $courseevent->tokenexpiry, $courseevent->refreshtoken,
                        $courseevent->tokenscope, $courseevent->tokenresource, $clientdata, $httpclient);
                $cal = new \local_o365\rest\calendar($token, $httpclient);
                $cal->update_event($courseevent->outlookeventid, ['attendees' => $courseeventssubscribers]);
            }
            $courseevents->close();
        }
    }

    /**
     * Main cron run method.
     *
     * @return bool Success/Failure.
     */
    public function run() {
        global $DB;
        $timestart = time();

        // We select jobs that are LESS than the current time to ensure we don't miss anything that might be created right now.
        $ops = $DB->get_recordset_select('local_o365_cronqueue', 'timecreated < ?', [$timestart], 'timecreated ASC');
        $opssorted = [];
        foreach ($ops as $op) {
            if ($op->operation === 'calendarsubscribe' || $op->operation === 'calendarunsubscribe') {
                $opssorted['calendar'][] = $op;
            }
        }
        $ops->close();
        mtrace('local_o365: processing '.count($opssorted['calendar']));
        if (!empty($opssorted)) {
            $this->runcalendarops($opssorted['calendar']);
        }

        $DB->delete_records_select('local_o365_cronqueue', 'timecreated < ?', [$timestart]);
        return true;
    }
}
