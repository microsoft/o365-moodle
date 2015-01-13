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
    protected function run_calendarops($ops) {
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
                           LEFT JOIN {local_o365_token} tok ON tok.user_id = ev.userid
                               WHERE ev.courseid = ? AND tok.resource = ?';
            $siteevents = $DB->get_recordset_sql($siteeventssql, [SITEID, $outlookresource]);
            foreach ($siteevents as $siteevent) {
                mtrace('Syncing site event #'.$siteevent->id);
                if (!empty($siteevent->token)) {
                    $token = new \local_o365\oauth2\token($siteevent->token, $siteevent->tokenexpiry, $siteevent->refreshtoken,
                            $siteevent->tokenscope, $siteevent->tokenresource, $clientdata, $httpclient);
                } else {
                    $token = \local_o365\oauth2\systemtoken::instance($outlookresource, $clientdata, $httpclient);
                }
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
                try {
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
                } catch (\Exception $e) {
                    // Could not sync this course. Continue on.
                    mtrace('Error syncing user event #'.$userevent->id.': '.$e->getMessage());
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
                    mtrace('Syncing course event #'.$courseevent->id);
                    if (!empty($courseevent->token)) {
                        mtrace('Using user token.');
                        $token = new \local_o365\oauth2\token($courseevent->token, $courseevent->tokenexpiry, $courseevent->refreshtoken,
                                $courseevent->tokenscope, $courseevent->tokenresource, $clientdata, $httpclient);
                    } else {
                        mtrace('Using system token.');
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
                    // Could not sync this course. Continue on.
                    mtrace('Error syncing course event #'.$courseevent->id.': '.$e->getMessage());
                }
            }
            $courseevents->close();
        }
    }

    /**
     * Sync sharepoint access for a list of courses and users.
     *
     * @param array $courses The courses to sync.
     * @param array $users The users to sync.
     * @param string $requiredcap The required capability.
     * @param \local\o365\rest\sharepoint $sharepoint Constructed sharepoint API client.
     * @return bool Success/Failure.
     */
    protected function sync_spsiteaccess_for_courses_and_users(array $courses, array $users, $requiredcap, \local_o365\rest\sharepoint $sharepoint) {
        foreach ($courses as $course) {
            $context = \context_course::instance($course->id);
            $spgroupsql = 'SELECT *
                             FROM {local_o365_coursespsite} site
                             JOIN {local_o365_spgroupdata} grp ON grp.coursespsiteid = site.id
                            WHERE site.courseid = ? AND grp.permtype = ?';
            $spgrouprec = $DB->get_record_sql($spgroupsql, [$courseid, 'contribute']);
            foreach ($users as $user) {
                $userupn = \local_o365\rest\azuread::get_muser_upn($user);
                $hascap = has_capability($requiredcap, $context, $user);
                if ($hascap === true) {
                    // Add to group.
                    $sharepoint->add_user_to_group($userupn, $spgrouprec->groupid, $user->id);
                } else {
                    // Remove from group.
                    $sharepoint->remove_user_from_group($userupn, $spgrouprec->groupid, $user->id);
                }
            }
        }
        return true;
    }

    /**
     * Handles the scenario where a user was assigned/unassigned a role at a context above course.
     *
     * Searches through all child courses of the received context, determines the user's capability, adds to/removes from
     * sharepoint group.
     *
     * @param int $roleid The ID of the role that changed.
     * @param int $userid The ID of the user that was assigned/unassigned.
     * @param int $contextid The ID of the context that the role was assigned/unassigned at.
     * @param string $requiredcap The required capability.
     * @param \local\o365\rest\sharepoint $sharepoint Constructed sharepoint API client.
     * @return bool Success/Failure.
     */
    protected function do_role_assignmentchange($roleid, $userid, $contextid, $requiredcap, $sharepoint) {
        $context = \context::instance_by_id($contextid);

        $user = $DB->get_record('user', ['id' => $userid], 'id,username');
        if (empty($user)) {
            return false;
        }

        if ($context->contextlevel == CONTEXT_COURSE) {
            return $this->sync_spsiteaccess_for_courses_and_users([$context->instanceid], [$user], $requiredcap, $sharepoint);
        } else if ($context->get_course_context(false) == false) {
            // Get all course contexts that are children of the current context.
            $courseids = [];
            $sql = "SELECT ctx.instanceid
                      FROM {context} ctx
                     WHERE ctx.contextlevel = ? AND ctx.path LIKE ?";
            $params = [CONTEXT_COURSE, $context->path.'/%'];
            $childcourses = $DB->get_recordset_sql($sql, $params);
            foreach ($childcourses as $childcourse) {
                $courseids[] = $childcourse->instanceid;
            }
            $childcourses->close();
            return $this->sync_spsiteaccess_for_courses_and_users($courseids, [$user], $requiredcap, $sharepoint);
        }
    }

    /**
     * Handles the scenario where a role's capabilities change.
     *
     * Searches through each context where role is assigned, determines users assigned the role in that context,
     * Then searches through each child course of each context where the role is assigned, determines each user's capability,
     * and adds to/removes from sharepoint group.
     *
     * @param int $roleid The ID of the role that changed.
     * @param string $requiredcap The required capability.
     * @param \local\o365\rest\sharepoint $sharepoint Constructed sharepoint API client.
     * @return bool Success/Failure.
     */
    protected function do_role_capabilitychange($roleid, $requiredcap, $sharepoint) {
        global $DB;
        $roleassignmentssorted = [];
        $roleassignments = $DB->get_recordset('role_assignments', ['roleid' => $roleid], '', 'contextid, userid');
        foreach ($roleassignments as $roleassignment) {
            $roleassignmentssorted[$roleassignment->contextid][] = $roleassignment->userid;
        }
        $roleassignments->close();

        foreach ($roleassignmentssorted as $contextid => $users) {
            $context = \context::instance_by_id($contextid);
            if ($context->contextlevel == CONTEXT_COURSE) {
                $this->sync_spsiteaccess_for_courses_and_users([$context->instanceid], $users, $requiredcap, $sharepoint);
            } else if ($context->get_course_context(false) == false) {
                // Get all course contexts that are children of the current context.
                $courseids = [];
                $sql = "SELECT ctx.instanceid
                          FROM {context} ctx
                         WHERE ctx.contextlevel = ? AND ctx.path LIKE ?";
                $params = [CONTEXT_COURSE, $context->path.'/%'];
                $childcourses = $DB->get_recordset_sql($sql, $params);
                foreach ($childcourses as $childcourse) {
                    $courseids[] = $childcourse->instanceid;
                }
                $childcourses->close();
                $this->sync_spsiteaccess_for_courses_and_users($courseids, $users, $requiredcap, $sharepoint);
            }
        }
        return true;
    }

    /**
     * Handle the scenario where a role was deleted.
     *
     * Searches through all courses and users, determines each user's capability in each course, adds to/removes from sharepoint
     * group.
     *
     * @param string $requiredcap The required capability.
     * @param \local\o365\rest\sharepoint $sharepoint Constructed sharepoint API client.
     * @return bool Success/Failure.
     */
    protected function do_role_delete($requiredcap, $sharepoint) {
        global $DB;
        $users = $DB->get_records('users', null, '', 'id, username');
        $courses = $DB->get_records('course', null, '', 'id');
        return $this->sync_spsiteaccess_for_courses_and_users($courses, $users, $requiredcap, $sharepoint);
    }

    /**
     * Execute queued cron Sharepoint access sync operations.
     *
     * @param array $ops Array of spaccesssync operation records.
     * @return bool Success/Failure.
     */
    protected function run_spaccesssync($ops) {
        global $DB;
        $reqcap = \local_o365\rest\sharepoint::get_course_site_required_capability();

        $oidcconfig = get_config('auth_oidc');
        if (!empty($oidcconfig)) {
            $spresource = \local_o365\rest\sharepoint::get_resource();
            if (!empty($spresource)) {
                $httpclient = new \local_o365\httpclient();
                $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint,
                        $oidcconfig->tokenendpoint);
                $sptoken = \local_o365\oauth2\systemtoken::instance($spresource, $clientdata, $httpclient);
                if (!empty($sptoken)) {
                    $sharepoint = new \local_o365\rest\sharepoint($sptoken, $httpclient);
                }
            }
        }
        if (empty($sharepoint)) {
            mtrace('Could not get sharepoint api client');
            return false;
        }

        // Do work.
        $jobscomplete = [];
        foreach ($ops as $i => $op) {
            $opdata = @unserialize($op->data);
            if (empty($opdata) || !is_array($opdata)) {
                mtrace('Cronqueue record #'.$op->id.' had invalid data, skipping...');
                continue;
            }

            $key = md5(serialize($opdata));
            if (isset($jobscomplete[$key])) {
                continue;
            }

            if ($opdata['userid'] !== '*' && $opdata['roleid'] !== '*' && !empty($opdata['contextid'])) {
                // Single user role assign/unassign.
                $this->do_role_assignmentchange($opdata['roleid'], $opdata['userid'], $opdata['contextid'], $reqcap, $sharepoint);
            } else if ($opdata['userid'] === '*' && $opdata['roleid'] !== '*') {
                // Capability update.
                $this->do_role_capabilitychange($opdata['roleid'], $reqcap, $sharepoint);
            } else if ($opdata['roleid'] === '*' && $opdata['userid'] === '*') {
                // Role deleted.
                $this->do_role_delete($reqcap, $sharepoint);
            }
            $jobscomplete[$key] = true;
            $DB->delete_records('local_o365_cronqueue', ['id' => $op->id]);
            unset($ops[$i]);
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
            if ($op->operation === 'spaccesssync') {
                $opssorted['spaccesssync'][] = $op;
            }
        }
        $ops->close();

        if (!empty($opssorted['calendar'])) {
            $this->run_calendarops($opssorted['calendar']);
        }

        if (!empty($opssorted['spaccesssync'])) {
            $this->run_spaccesssync($opssorted['spaccesssync']);
        }

        $DB->delete_records_select('local_o365_cronqueue', 'timecreated < ?', [$timestart]);

        // Attempt token refresh if required.
        $oidcconfig = get_config('auth_oidc');
        if (!empty($oidcconfig)) {
            $httpclient = new \local_o365\httpclient();
            $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret,
                    $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
            $systemtokenlastrefresh = get_config('local_o365', 'systemtokenlastrefresh');
            if (empty($systemtokenlastrefresh) || (int)$systemtokenlastrefresh < ($timestart - WEEKSECS)) {
                try {
                    $systemtoken = \local_o365\oauth2\systemtoken::get_for_new_resource('https://graph.windows.net', $clientdata, $httpclient);
                } catch (\Exception $e) {
                    // If we can't refresh the token, it will have to be fixed manually.
                }
            }
        }


        return true;
    }
}
