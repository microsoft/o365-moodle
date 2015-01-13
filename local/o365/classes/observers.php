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
     * Handle an authentication-only OIDC event.
     *
     * Does the following:
     *     - This is used for setting the system API user, so store the received token appropriately.
     *
     * @param \auth_oidc\event\user_authed $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_oidc_user_authed(\auth_oidc\event\user_authed $event) {
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
     * Handles an existing Moodle user connecting to OpenID Connect.
     *
     * @param \auth_oidc\event\user_connected $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_oidc_user_connected(\auth_oidc\event\user_connected $event) {
        // Get additional tokens for the user.
        $eventdata = $event->get_data();
        if (!empty($eventdata['other']['username']) && !empty($eventdata['other']['userid'])) {
            $tokenresult = static::get_additional_tokens_for_user($eventdata['other']['username'], $eventdata['other']['userid']);
        }

        return true;
    }

    /**
     * Handle a user being created by the OpenID Connect authentication plugin.
     *
     * Does the following:
     *     - Gets additional information from AAD and updates the user.
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
        if (empty($tokenrec)) {
            // No OIDC token for this user and resource - maybe not an AAD user.
            return false;
        }

        $httpclient = new \local_o365\httpclient();
        $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint,
                $oidcconfig->tokenendpoint);
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
     * Handles an existing Moodle user disconnecting from OpenID Connect.
     *
     * @param \auth_oidc\event\user_disconnected $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_oidc_user_disconnected(\auth_oidc\event\user_disconnected $event) {

    }

    /**
     * Handles logins from the OpenID Connect auth plugin.
     *
     * Does the following:
     *     - Uses the received OIDC auth code to get tokens for the other resources we use: onedrive, sharepoint, outlook.
     *
     * @param \auth_oidc\event\user_loggedin $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_oidc_user_loggedin(\auth_oidc\event\user_loggedin $event) {
        // Get additional tokens for the user.
        $eventdata = $event->get_data();
        if (!empty($eventdata['other']['username']) && !empty($eventdata['userid'])) {
            $tokenresult = static::get_additional_tokens_for_user($eventdata['other']['username'], $eventdata['userid']);
        }

        return true;
    }

    /**
     * Get additional tokens for a given user.
     *
     * @param string $username The username of the user to fetch OpenID Connect tokens for.
     * @param int $userid The ID of the user to store the new tokens for.
     * @return bool Success/Failure.
     */
    public static function get_additional_tokens_for_user($username, $userid) {
        global $DB;

        // Auth_oidc config gives us the client credentials and token endpoint.
        $oidcconfig = get_config('auth_oidc');
        if (empty($oidcconfig)) {
            return false;
        }
        if (empty($oidcconfig->clientid) || empty($oidcconfig->clientsecret) || empty($oidcconfig->tokenendpoint)) {
            return false;
        }

        // The token record created/updated on login by auth_oidc.
        $oidctokenrec = $DB->get_record('auth_oidc_token', ['username' => $username]);
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
            // Request token.
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

            // Create/update the stored token record.
            $o365tokenrec = $DB->get_record('local_o365_token', ['user_id' => $userid, 'resource' => $resource]);
            if (!empty($o365tokenrec)) {
                $o365tokenrec->scope = $tokenresult['scope'];
                $o365tokenrec->token = $tokenresult['access_token'];
                $o365tokenrec->expiry = $tokenresult['expires_on'];
                $o365tokenrec->refreshtoken = $tokenresult['refresh_token'];
                $DB->update_record('local_o365_token', $o365tokenrec);
            } else {
                $o365tokenrec = new \stdClass;
                $o365tokenrec->user_id = $userid;
                $o365tokenrec->resource = $tokenresult['resource'];
                $o365tokenrec->scope = $tokenresult['scope'];
                $o365tokenrec->token = $tokenresult['access_token'];
                $o365tokenrec->expiry = $tokenresult['expires_on'];
                $o365tokenrec->refreshtoken = $tokenresult['refresh_token'];
                $o365tokenrec->id = $DB->insert_record('local_o365_token', $o365tokenrec);
            }
        }
    }

    /**
     * Construct a calendar API client using the system API user.
     *
     * @param int $userid The userid to get the outlook token for.
     * @return \local_o365\rest\calendar|bool A constructed calendar API client, or false if error.
     */
    public static function construct_calendar_api($userid, $systemfallback = true) {
        global $DB;
        $outlookresource = \local_o365\rest\calendar::get_resource();
        $oidcconfig = get_config('auth_oidc');
        $httpclient = new \local_o365\httpclient();
        $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint,
                $oidcconfig->tokenendpoint);
        $tokenparams = ['user_id' => $userid, 'resource' => $outlookresource];
        $tokenrec = $DB->get_record('local_o365_token', $tokenparams);
        $token = null;
        if (!empty($tokenrec)) {
            $token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken, $tokenrec->scope,
                $tokenrec->resource, $clientdata, $httpclient);
        }
        if (empty($token) && $systemfallback === true) {
            $token = \local_o365\oauth2\systemtoken::instance($outlookresource, $clientdata, $httpclient);
        }
        if (empty($token)) {
            return false;
        }
        $cal = new \local_o365\rest\calendar($token, $httpclient);
        return $cal;
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
        $cal = static::construct_calendar_api($event->userid);

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
        } else if (isset($event->courseid) && $event->courseid != SITEID && $event->courseid > 0) {
            // Course event - Get subscribed students.
            if (!empty($event->groupid)) {
                $subscribedsql = 'SELECT u.id, u.email, u.firstname, u.lastname
                                    FROM {user} u
                                    JOIN {user_enrolments} ue ON ue.userid = u.id
                                    JOIN {enrol} e ON e.id = ue.enrolid
                                    JOIN {local_o365_calsub} sub ON sub.user_id = u.id
                                         AND sub.caltype = "course"
                                         AND sub.caltypeid = e.courseid
                                    JOIN {groups_members} grpmbr ON grpmbr.userid = u.id
                                   WHERE e.courseid = ? AND grpmbr.groupid = ?';
                $attendees = $DB->get_records_sql($subscribedsql, [$event->courseid, $event->groupid]);
            } else {
                $subscribedsql = 'SELECT u.id, u.email, u.firstname, u.lastname
                                    FROM {user} u
                                    JOIN {user_enrolments} ue ON ue.userid = u.id
                                    JOIN {enrol} e ON e.id = ue.enrolid
                                    JOIN {local_o365_calsub} sub ON sub.user_id = u.id
                                         AND sub.caltype = "course"
                                         AND sub.caltypeid = e.courseid
                                   WHERE e.courseid = ?';
                $attendees = $DB->get_records_sql($subscribedsql, [$event->courseid]);
            }
        } else {
            // Personal user event. Only sync if user is subscribed to their events.
            if (!$DB->record_exists('local_o365_calsub', ['caltype' => 'user', 'user_id' => $event->userid])) {
                return true;
            } else {
                $attendees = [];
            }
        }

        // Send event to o365.
        // $response = $cal->create_event($subject, $body, $timestart, $timeend, $attendees);

        // Temporary workaround to make sure that saving of assignment works.
        $response = array();

        // Store ID.
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
        $cal = static::construct_calendar_api($event->userid);

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
        $cal = static::construct_calendar_api($event->userid);

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
     * Construct a sharepoint API client using the system API user.
     *
     * @return \local_o365\rest\sharepoint|bool A constructed sharepoint API client, or false if error.
     */
    public static function construct_sharepoint_api_with_system_user() {
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
                    return $sharepoint;
                }
            }
        }
        return false;
    }

    /**
     * Handle course_created event - clean up calendar subscriptions.
     *
     * Does the following:
     *     - create a sharepoint site and associated groups.
     *
     * @param \core\event\course_created $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_course_created(\core\event\course_created $event) {
        $sharepoint = static::construct_sharepoint_api_with_system_user();
        if (!empty($sharepoint)) {
            $sharepoint->create_course_site($event->objectid);
        }
    }

    /**
     * Handle course_updated event - clean up calendar subscriptions.
     *
     * Does the following:
     *     - update associated sharepoint sites and associated groups.
     *
     * @param \core\event\course_updated $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_course_updated(\core\event\course_updated $event) {
        $courseid = $event->objectid;
        $eventdata = $event->get_data();
        if (!empty($eventdata['other'])) {
            $sharepoint = static::construct_sharepoint_api_with_system_user();
            if (!empty($sharepoint)) {
                $sharepoint->update_course_site($courseid, $eventdata['other']['shortname'], $eventdata['other']['fullname']);
            }
        }
    }

    /**
     * Handle course_deleted event
     *
     * Does the following:
     *     - clean up calendar subscriptions.
     *     - delete sharepoint sites and groups, and local sharepoint site data.
     *
     * @param \core\event\course_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_course_deleted(\core\event\course_deleted $event) {
        global $DB;
        $courseid = $event->objectid;
        $DB->delete_records('local_o365_calsub', ['caltype' => 'course', 'caltypeid' => $courseid]);

        $sharepoint = static::construct_sharepoint_api_with_system_user();
        if (!empty($sharepoint)) {
            $sharepoint->delete_course_site($courseid);
        }
        return true;
    }

    /**
     * Sync Sharepoint course site access when a role was assigned or unassigned for a user.
     *
     * @param int $roleid The ID of the role that was assigned/unassigned.
     * @param int $userid The ID of the user that it was assigned to or unassigned from.
     * @param int $contextid The ID of the context the role was assigned/unassigned in.
     * @return bool Success/Failure.
     */
    public static function sync_spsite_access_for_roleassign_change($roleid, $userid, $contextid) {
        global $DB;
        $requiredcap = \local_o365\rest\sharepoint::get_course_site_required_capability();

        // Check if the role affected the required capability
        $rolecapsql = "SELECT *
                         FROM {role_capabilities}
                        WHERE roleid = ? AND capability = ?";
        $capassignrec = $DB->get_record_sql($rolecapsql, [$roleid, $requiredcap]);

        if (empty($capassignrec) || $capassignrec->permission == CAP_INHERIT) {
            // Role doesn't affect required capability. Doesn't concern us.
            return false;
        }

        $context = \context::instance_by_id($contextid, IGNORE_MISSING);
        if (empty($context)) {
            // Invalid context, stop here.
            return false;
        }

        if ($context->contextlevel == CONTEXT_COURSE) {
            $courseid = $context->instanceid;
            $user = $DB->get_record('user', ['id' => $userid]);
            if (empty($user)) {
                // Bad userid.
                return false;
            }

            $userupn = \local_o365\rest\azuread::get_muser_upn($user);
            if (empty($userupn)) {
                // No user UPN, can't continue.
                return false;
            }

            $spgroupsql = 'SELECT *
                             FROM {local_o365_coursespsite} site
                             JOIN {local_o365_spgroupdata} grp ON grp.coursespsiteid = site.id
                            WHERE site.courseid = ? AND grp.permtype = ?';
            $spgrouprec = $DB->get_record_sql($spgroupsql, [$courseid, 'contribute']);
            if (empty($spgrouprec)) {
                // No sharepoint group, can't fix that here.
                return false;
            }

            // If the context is a course context we can change SP access now.
            $sharepoint = static::construct_sharepoint_api_with_system_user();
            $hascap = has_capability($requiredcap, $context, $user);
            if ($hascap === true) {
                // Add to group.
                $sharepoint->add_user_to_group($userupn, $spgrouprec->groupid, $user->id);
            } else {
                // Remove from group.
                $sharepoint->remove_user_from_group($userupn, $spgrouprec->groupid, $user->id);
            }
            return true;
        } else if ($context->get_course_context(false) == false) {
            // If the context is higher than a course, we have to run a sync in cron.
            $cronqueuerec = new \stdClass;
            $cronqueuerec->operation = 'spaccesssync';
            $cronqueuerec->data = serialize(['roleid' => $roleid, 'userid' => $user->id, 'contextid' => $contextid]);
            $cronqueuerec->timecreated = time();
            $DB->insert_record('local_o365_cronqueue', $cronqueuerec);
            return true;
        }
    }

    /**
     * Handle role_assigned event
     *
     * Does the following:
     *     - check if the assigned role has the permission needed to access course sharepoint sites.
     *     - if it does, add the assigned user to the course sharepoint sites as a contributor.
     *
     * @param \core\event\role_assigned $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_role_assigned(\core\event\role_assigned $event) {
        return static::sync_spsite_access_for_roleassign_change($event->objectid, $event->relateduserid, $event->contextid);
    }

    /**
     * Handle role_unassigned event
     *
     * Does the following:
     *     - check if, by unassigning this role, the related user no longer has the required capability to access course sharepoint
     *       sites. If they don't, remove them from the sharepoint sites' contributor groups.
     *
     * @param \core\event\role_unassigned $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_role_unassigned(\core\event\role_unassigned $event) {
        return static::sync_spsite_access_for_roleassign_change($event->objectid, $event->relateduserid, $event->contextid);
    }

    /**
     * Handle role_capabilities_updated event
     *
     * Does the following:
     *     - check if the required capability to access course sharepoint sites was removed. if it was, check if affected users
     *       no longer have the required capability to access course sharepoint sites. If they don't, remove them from the
     *       sharepoint sites' contributor groups.
     *
     * @param \core\event\role_capabilities_updated $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_role_capabilities_updated(\core\event\role_capabilities_updated $event) {
        global $DB;
        $roleid = $event->objectid;
        $contextid = $event->contextid;

        // If the context is higher than a course, we have to run a sync in cron.
        $cronqueuerec = new \stdClass;
        $cronqueuerec->operation = 'spaccesssync';
        $cronqueuerec->data = serialize(['roleid' => $roleid, 'userid' => '*', 'contextid' => null]);
        $cronqueuerec->timecreated = time();
        $DB->insert_record('local_o365_cronqueue', $cronqueuerec);
        return true;
    }

    /**
     * Handle role_deleted event
     *
     * Does the following:
     *     - check if the deleted role contained the required capability to access course sharepoint sites. If it did, check if
     *       users that were assigned this role no longer have the required capability to access course sharepoint sites. If they
     *       don't, remove them from the sharepoint sites' contributor groups.
     *
     * @param \core\event\role_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_role_deleted(\core\event\role_deleted $event) {
        global $DB;
        $roleid = $event->objectid;

        // If the context is higher than a course, we have to run a sync in cron.
        $cronqueuerec = new \stdClass;
        $cronqueuerec->operation = 'spaccesssync';
        $cronqueuerec->data = serialize(['roleid' => '*', 'userid' => '*', 'contextid' => null]);
        $cronqueuerec->timecreated = time();
        $DB->insert_record('local_o365_cronqueue', $cronqueuerec);
        return true;
    }

    /**
     * Handle user_deleted event - clean up calendar subscriptions.
     *
     * @param \core\event\user_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_user_deleted(\core\event\user_deleted $event) {
        global $DB;
        $userid = $event->objectid;
        $DB->delete_records('local_o365_calsub', ['user_id' => $userid]);
        $DB->delete_records('local_o365_token', ['user_id' => $userid]);
        $DB->delete_records('local_o365_aaduserdata', ['muserid' => $userid]);
        return true;
    }
}
