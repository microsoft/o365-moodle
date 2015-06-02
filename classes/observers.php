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

namespace local_o365;

require_once($CFG->dirroot.'/lib/filelib.php');

/**
 * Handles events.
 */
class observers {
    /** @var bool Flag indicating whether we're currently importing events. */
    public static $importingevents = false;

    /**
     * Set class static flag indicating whether we're currently importing events.
     *
     * @param bool $status Import status.
     */
    public static function set_event_import($status) {
        static::$importingevents = $status;
    }

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
        if (!empty($eventdata['userid'])) {
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            if (!empty($clientdata)) {
                try {
                    $httpclient = new \local_o365\httpclient();
                    $azureresource = \local_o365\rest\calendar::get_resource();
                    $token = \local_o365\oauth2\token::instance($eventdata['userid'], $azureresource, $clientdata, $httpclient);
                } catch (\Exception $e) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Handle a user being created .
     *
     * Does the following:
     *     - Check if user is using OpenID Connect auth plugin.
     *     - If so, gets additional information from AAD and updates the user.
     *
     * @param \core\event\user_created $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_user_created(\core\event\user_created $event) {
        global $DB;
        $eventdata = $event->get_data();

        if (empty($eventdata['objectid'])) {
            return false;
        }
        $createduserid = $eventdata['objectid'];

        $user = $DB->get_record('user', ['id' => $createduserid]);
        if (!empty($user) && isset($user->auth) && $user->auth === 'oidc') {
            static::get_additional_user_info($createduserid);
        }

        return true;
    }

    /**
     * Handles an existing Moodle user disconnecting from OpenID Connect.
     *
     * @param \auth_oidc\event\user_disconnected $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_oidc_user_disconnected(\auth_oidc\event\user_disconnected $event) {
        global $DB;
        $eventdata = $event->get_data();
        if (!empty($eventdata['userid'])) {
            $DB->delete_records('local_o365_token', ['user_id' => $eventdata['userid']]);
        }
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
            static::get_additional_user_info($eventdata['userid']);
        }

        return true;
    }

    /**
     * Get additional information about a user from AzureAD.
     *
     * @return bool Success/Failure.
     */
    public static function get_additional_user_info($userid) {
        global $DB;

        // AAD must be configured for us to fetch data.
        if (\local_o365\rest\azuread::is_configured() !== true) {
            return true;
        }

        $aadresource = \local_o365\rest\azuread::get_resource();
        $sql = 'SELECT tok.*
                  FROM {auth_oidc_token} tok
                  JOIN {user} u
                       ON tok.username = u.username
                 WHERE u.id = ? AND tok.resource = ?';
        $params = [$userid, $aadresource];
        $tokenrec = $DB->get_record_sql($sql, $params);
        if (empty($tokenrec)) {
            // No OIDC token for this user and resource - maybe not an AAD user.
            return false;
        }

        try {
            $httpclient = new \local_o365\httpclient();
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            $token = \local_o365\oauth2\token::instance($userid, $aadresource, $clientdata, $httpclient);
            $apiclient = new \local_o365\rest\azuread($token, $httpclient);
        } catch (\Exception $e) {
            return false;
        }

        $aaduserdata = $apiclient->get_user($tokenrec->oidcuniqid);
        if (!empty($aaduserdata)) {
            $updateduser = [];
            $parammap = [
                'mail' => 'email',
                'city' => 'city',
                'country' => 'country',
                'department' => 'department'
            ];
            foreach ($parammap as $aadparam => $moodleparam) {
                if (!empty($aaduserdata[$aadparam])) {
                    $updateduser[$moodleparam] = $aaduserdata[$aadparam];
                }
            }

            if (!empty($aaduserdata['preferredLanguage'])) {
                $updateduser['lang'] = substr($aaduserdata['preferredLanguage'], 0, 2);
            }

            if (!empty($updateduser)) {
                $updateduser['id'] = $userid;
                $DB->update_record('user', (object)$updateduser);
            }
            return true;
        }
        return false;
    }

    /**
     * Construct a calendar API client using the system API user.
     *
     * @param int $userid The userid to get the outlook token for.
     * @return \local_o365\rest\calendar|bool A constructed calendar API client, or false if error.
     */
    public static function construct_calendar_api($userid, $systemfallback = true) {
        $outlookresource = \local_o365\rest\calendar::get_resource();
        $httpclient = new \local_o365\httpclient();

        try {
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        } catch (\Exception $e) {
            return false;
        }

        $token = \local_o365\oauth2\token::instance($userid, $outlookresource, $clientdata, $httpclient);
        if (empty($token) && $systemfallback === true) {
            $token = \local_o365\oauth2\systemtoken::instance(null, $outlookresource, $clientdata, $httpclient);
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

        if (static::$importingevents === true) {
            return true;
        }

        // Assemble basic event data.
        $event = $DB->get_record('event', ['id' => $event->objectid]);
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
                $cal = static::construct_calendar_api($event->userid);
                if (!empty($cal)) {
                    $calid = (!empty($calsub->o365calid)) ? $calsub->o365calid : null;
                    $response = $cal->create_event($subject, $body, $timestart, $timeend, [], [], $calid);
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
            $cal = static::construct_calendar_api($event->userid);
            if (!empty($cal)) {
                $calid = (!empty($eventcreatorsub) && !empty($eventcreatorsub->subo365calid)) ? $eventcreatorsub->subo365calid : null;
                $response = $cal->create_event($subject, $body, $timestart, $timeend, $attendees, [], $calid);
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
        }

        // Sync non-primary attendees individually.
        foreach ($nonprimarycalsubs as $attendee) {
            $cal = static::construct_calendar_api($attendee->id);
            if (!empty($cal)) {
                $calid = (!empty($attendee->subo365calid)) ? $attendee->subo365calid : null;
                $response = $cal->create_event($subject, $body, $timestart, $timeend, [], [], $calid);
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

        // Send updated information to o365.
        $event = $DB->get_record('event', ['id' => $event->objectid]);
        $updated = [
            'subject' => $event->name,
            'body' => $event->description,
            'starttime' => $event->timestart,
            'endtime' => $event->timestart + $event->timeduration,
        ];

        foreach ($idmaprecs as $idmaprec) {
            $cal = static::construct_calendar_api($idmaprec->userid);
            if (!empty($cal)) {
                $cal->update_event($idmaprec->outlookeventid, $updated);
            }
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

        foreach ($idmaprecs as $idmaprec) {
            $cal = static::construct_calendar_api($idmaprec->userid);
            if (!empty($cal)) {
                $cal->delete_event($idmaprec->outlookeventid);
            }
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
        $eventdata = $event->get_data();
        $calsubscribe = new \local_o365\task\calendarsync();
        $calsubscribe->set_custom_data([
            'caltype' => $eventdata['other']['caltype'],
            'caltypeid' => ((isset($eventdata['other']['caltypeid'])) ? $eventdata['other']['caltypeid'] : 0),
            'userid' => $eventdata['userid'],
            'timecreated' => time(),
        ]);
        \core\task\manager::queue_adhoc_task($calsubscribe);
        return true;
    }

    /**
     * Handle calendar_unsubscribed event - queue calendar sync jobs for cron.
     *
     * @param \local_o365\event\calendar_unsubscribed $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_calendar_unsubscribed(\local_o365\event\calendar_unsubscribed $event) {
        $eventdata = $event->get_data();
        $calunsubscribe = new \local_o365\task\calendarsync();
        $calunsubscribe->set_custom_data([
            'caltype' => $eventdata['other']['caltype'],
            'caltypeid' => ((isset($eventdata['other']['caltypeid'])) ? $eventdata['other']['caltypeid'] : 0),
            'userid' => $eventdata['userid'],
            'timecreated' => time(),
        ]);
        \core\task\manager::queue_adhoc_task($calunsubscribe);
        return true;
    }

    /**
     * Handle user_enrolment_created event.
     *
     * @param \core\event\user_enrolment_created $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_user_enrolment_created(\core\event\user_enrolment_created $event) {
        $userid = $event->relateduserid;
        $courseid = $event->courseid;

        if (empty($userid) || empty($courseid)) {
            return true;
        }

        // Add user from course usergroup.
        $configsetting = get_config('local_o365', 'creategroups');
        if (!empty($configsetting)) {
            $httpclient = new \local_o365\httpclient();
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            $aadresource = \local_o365\rest\azuread::get_resource();
            $aadtoken = \local_o365\oauth2\systemtoken::instance(null, $aadresource, $clientdata, $httpclient);
            if (!empty($aadtoken)) {
                $aadclient = new \local_o365\rest\azuread($aadtoken, $httpclient);
                $aadclient->add_user_to_course_group($courseid, $userid);
            }
        }
    }

    /**
     * Handle user_enrolment_deleted event
     *
     * Tasks
     *     - clean up calendar subscriptions.
     *
     * @param \core\event\user_enrolment_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_user_enrolment_deleted(\core\event\user_enrolment_deleted $event) {
        global $DB;
        $userid = $event->relateduserid;
        $courseid = $event->courseid;

        if (empty($userid) || empty($courseid)) {
            return true;
        }

        // Remove user from course usergroup.
        $configsetting = get_config('local_o365', 'creategroups');
        if (!empty($configsetting)) {
            $httpclient = new \local_o365\httpclient();
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            $aadresource = \local_o365\rest\azuread::get_resource();
            $aadtoken = \local_o365\oauth2\systemtoken::instance(null, $aadresource, $clientdata, $httpclient);
            if (!empty($aadtoken)) {
                $aadclient = new \local_o365\rest\azuread($aadtoken, $httpclient);
                $aadclient->remove_user_from_course_group($courseid, $userid);
            }
        }

        // Clean up calendar subscriptions.
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
                $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret,
                        $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
                $sptoken = \local_o365\oauth2\systemtoken::instance(null, $spresource, $clientdata, $httpclient);
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

        // Check if the role affected the required capability.
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
            if (empty($sharepoint)) {
                // O365 not configured.
                return false;
            }
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
            $spaccesssync = new \local_o365\task\sharepointaccesssync();
            $spaccesssync->set_custom_data([
                'roleid' => $roleid,
                'userid' => $userid,
                'contextid' => $contextid,
            ]);
            \core\task\manager::queue_adhoc_task($spaccesssync);
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
        $roleid = $event->objectid;
        $contextid = $event->contextid;

        // Role changes can be pretty heavy - run in cron.
        $spaccesssync = new \local_o365\task\sharepointaccesssync();
        $spaccesssync->set_custom_data(['roleid' => $roleid, 'userid' => '*', 'contextid' => null]);
        \core\task\manager::queue_adhoc_task($spaccesssync);
        return true;
    }

    /**
     * Handle role_deleted event
     *
     * Does the following:
     *     - Unfortunately the role has already been deleted when we hear about it here, and have no way to determine the affected
     *     users. Therefore, we have to do a global sync.
     *
     * @param \core\event\role_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_role_deleted(\core\event\role_deleted $event) {
        $roleid = $event->objectid;

        // Role deletions can be heavy - run in cron.
        $spaccesssync = new \local_o365\task\sharepointaccesssync();
        $spaccesssync->set_custom_data(['roleid' => '*', 'userid' => '*', 'contextid' => null]);
        \core\task\manager::queue_adhoc_task($spaccesssync);
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
