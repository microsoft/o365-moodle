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
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365;

global $CFG;
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
        require_login();
        require_capability('moodle/site:config', \context_system::instance());

        $eventdata = $event->get_data();

        $redirect = '/admin/settings.php?section=local_o365';
        $action = (!empty($eventdata['other']['statedata']['action']))
            ? $eventdata['other']['statedata']['action'] : null;

        switch ($action) {
            case 'setsystemapiuser':
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
                break;

            case 'adminconsent':
                // Get tenant if using app-only access.
                if (\local_o365\utils::is_enabled_apponlyaccess() === true) {
                    if (isset($eventdata['other']['tokenparams']['id_token'])) {
                        $idtoken = $eventdata['other']['tokenparams']['id_token'];
                        $idtoken = \auth_oidc\jwt::instance_from_encoded($idtoken);
                        if (!empty($idtoken)) {
                            $tenant = \local_o365\utils::get_tenant_from_idtoken($idtoken);
                            if (!empty($tenant)) {
                                set_config('aadtenantid', $tenant, 'local_o365');
                            }
                        }
                    }
                }
                redirect(new \moodle_url('/admin/settings.php?section=local_o365'));
                break;

            case 'addtenant':
                $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
                $httpclient = new \local_o365\httpclient();
                $token = $eventdata['other']['tokenparams']['access_token'];
                $expiry = $eventdata['other']['tokenparams']['expires_on'];
                $rtoken = $eventdata['other']['tokenparams']['refresh_token'];
                $scope = $eventdata['other']['tokenparams']['scope'];
                $res = $eventdata['other']['tokenparams']['resource'];
                $token = new \local_o365\oauth2\token($token, $expiry, $rtoken, $scope, $res, null, $clientdata, $httpclient);
                $resource = (\local_o365\rest\unified::is_enabled() === true)
                    ? \local_o365\rest\unified::get_resource()
                    : \local_o365\rest\discovery::get_resource();
                $token = \local_o365\oauth2\token::jump_resource($token, $resource, $clientdata, $httpclient);
                $apiclient = (\local_o365\rest\unified::is_enabled() === true)
                    ? new \local_o365\rest\unified($token, $httpclient)
                    : new \local_o365\rest\discovery($token, $httpclient);
                $tenant = $apiclient->get_tenant();
                $tenant = clean_param($tenant, PARAM_TEXT);
                \local_o365\utils::enableadditionaltenant($tenant);
                redirect(new \moodle_url('/local/o365/acp.php?mode=tenants'));
                break;

            default:
                return true;
        }
    }

    /**
     * Handles an existing Moodle user connecting to OpenID Connect.
     *
     * @param \auth_oidc\event\user_connected $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_oidc_user_connected(\auth_oidc\event\user_connected $event) {
        global $DB;
        $caller = '\local_o365\observers::handle_oidc_user_connected';
        if (\local_o365\utils::is_configured() !== true) {
            return false;
        }

        // Get additional tokens for the user.
        $eventdata = $event->get_data();
        if (!empty($eventdata['userid'])) {
            try {
                $userid = $eventdata['userid'];
                // Create local_o365_objects record.
                if (!empty($eventdata['other']['oidcuniqid'])) {
                    $userobject = $DB->get_record('local_o365_objects', ['type' => 'user', 'moodleid' => $userid]);
                    if (empty($userobject)) {
                        try {
                            $apiclient = \local_o365\utils::get_api();
                            $userdata = $apiclient->get_user($eventdata['other']['oidcuniqid']);
                        } catch (\Exception $e) {
                            \local_o365\utils::debug('Exception: '.$e->getMessage(), $caller, $e);
                            return true;
                        }

                        $tenant = \local_o365\utils::get_tenant_for_user($eventdata['userid']);
                        $metadata = '';
                        if (!empty($tenant)) {
                            // Additional tenant - get ODB url.
                            $odburl = \local_o365\utils::get_odburl_for_user($eventdata['userid']);
                            if (!empty($odburl)) {
                                $metadata = json_encode(['odburl' => $odburl]);
                            }
                        }

                        // Create userobject if it does not exist.
                        $now = time();
                        $userobjectdata = (object)[
                            'type' => 'user',
                            'subtype' => '',
                            'objectid' => $userdata['objectId'],
                            'o365name' => $userdata['userPrincipalName'],
                            'moodleid' => $userid,
                            'tenant' => $tenant,
                            'metadata' => $metadata,
                            'timecreated' => $now,
                            'timemodified' => $now,
                        ];
                        $userobjectdata->id = $DB->insert_record('local_o365_objects', $userobjectdata);
                    }
                } else {
                    \local_o365\utils::debug('no oidcuniqid received', 'handle_oidc_user_connected', $eventdata);
                }
                return true;
            } catch (\Exception $e) {
                \local_o365\utils::debug($e->getMessage(), 'handle_oidc_user_connected', $e);
                return false;
            }
        }
        return false;
    }

    /**
     * Handle a user being created .
     *
     * Does the following:
     *     - Check if user is using OpenID Connect auth plugin.
     *     - If so, gets additional information from Azure AD and updates the user.
     *
     * @param \core\event\user_created $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_user_created(\core\event\user_created $event) {
        global $DB;

        if (\local_o365\utils::is_configured() !== true) {
            return false;
        }

        $eventdata = $event->get_data();

        if (empty($eventdata['objectid'])) {
            return false;
        }
        $createduserid = $eventdata['objectid'];

        $user = $DB->get_record('user', ['id' => $createduserid]);
        if (!empty($user) && isset($user->auth) && $user->auth === 'oidc') {
            static::get_additional_user_info($createduserid, 'create');
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
            $DB->delete_records('local_o365_objects', ['type' => 'user', 'moodleid' => $eventdata['userid']]);
            $DB->delete_records('local_o365_connections', ['muserid' => $eventdata['userid']]);
            $DB->delete_records('local_o365_appassign', ['muserid' => $eventdata['userid']]);
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
        if (\local_o365\utils::is_configured() !== true) {
            return false;
        }

        // Get additional tokens for the user.
        $eventdata = $event->get_data();
        if (!empty($eventdata['other']['username']) && !empty($eventdata['userid'])) {
            static::get_additional_user_info($eventdata['userid'], 'login');
        }

        return true;
    }

    /**
     * Get additional information about a user from Azure AD.
     *
     * @param int $userid The ID of the user we want more information about.
     * @param string $eventtype The type of event that triggered this call. "login" or "create".
     * @return bool Success/Failure.
     */
    public static function get_additional_user_info($userid, $eventtype) {
        global $DB;

        try {
            // Azure AD must be configured for us to fetch data.
            if (\local_o365\rest\azuread::is_configured() !== true) {
                return true;
            }

            $o365user = \local_o365\obj\o365user::instance_from_muserid($userid);
            if (empty($o365user)) {
                // No OIDC token for this user and resource - maybe not an Azure AD user.
                return false;
            }

            $idtoken = \auth_oidc\jwt::instance_from_encoded($o365user->get_idtoken());
            $apiclient = \local_o365\utils::get_api($userid);
            $userdata = $apiclient->get_user($o365user->objectid);
            // Azuread users objectid, unified uses id.
            if (\local_o365\rest\unified::is_configured() && empty($userdata['objectId']) && !empty($userdata['id'])) {
                $userdata['objectId'] = $userdata['id'];
            }

            // Extract basic information from the IDToken.
            $updateduser = new \stdClass;
            $firstname = $idtoken->claim('given_name');
            if (!empty($firstname)) {
                $updateduser->firstname = $firstname;
            }

            $lastname = $idtoken->claim('family_name');
            if (!empty($lastname)) {
                $updateduser->lastname = $lastname;
            }

            $email = $idtoken->claim('email');
            if (!empty($email)) {
                $updateduser->email = $email;
            }

            if (empty($updateduser->email)) {
                $aademail = $idtoken->claim('upn');
                if (!empty($aademail)) {
                    $aademailvalidateresult = filter_var($aademail, FILTER_VALIDATE_EMAIL);
                    if (!empty($aademailvalidateresult)) {
                        $updateduser->email = $aademail;
                    }
                }
            }

            // Then apply the custom field map.
            $updateduser = \local_o365\feature\usersync\main::apply_configured_fieldmap($userdata, $updateduser, $eventtype);

            // Save profile data.
            if (!empty($updateduser)) {
                $updateduser->id = $userid;
                $DB->update_record('user', $updateduser);
                profile_save_data($updateduser);
            }

            $userobject = $DB->get_record('local_o365_objects', ['type' => 'user', 'moodleid' => $userid]);
            if (empty($userobject)) {
                // Create userobject if it does not exist.
                $tenant = \local_o365\utils::get_tenant_for_user($userid);
                $metadata = '';
                if (!empty($tenant)) {
                    // Additional tenant - get ODB url.
                    $odburl = \local_o365\utils::get_odburl_for_user($userid);
                    if (!empty($odburl)) {
                        $metadata = json_encode(['odburl' => $odburl]);
                    }
                }
                $now = time();
                $userobjectdata = (object)[
                    'type' => 'user',
                    'subtype' => '',
                    'objectid' => $userdata['objectId'],
                    'o365name' => $userdata['userPrincipalName'],
                    'moodleid' => $userid,
                    'tenant' => $tenant,
                    'metadata' => $metadata,
                    'timecreated' => $now,
                    'timemodified' => $now,
                ];
                $userobjectdata->id = $DB->insert_record('local_o365_objects', $userobjectdata);
            }

            return true;
        } catch (\Exception $e) {
            \local_o365\utils::debug($e->getMessage(), 'get_additional_user_info', $e);
        }
        return false;
    }

    /**
     * Handle user_enrolment_created event.
     *
     * @param \core\event\user_enrolment_created $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_user_enrolment_created(\core\event\user_enrolment_created $event) {
        global $DB;
        $caller = 'local_o365\observer::handle_user_enrolment_created';
        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            \local_o365\utils::debug("Not configured", $caller);
            return false;
        }

        $userid = $event->relateduserid;
        $courseid = $event->courseid;

        if (empty($userid) || empty($courseid)) {
            \local_o365\utils::debug("handle_user_enrolment_created no userid $userid or course $courseid", $caller);
            return true;
        }

        try {
            // Add user from course usergroup.
            $apiclient = \local_o365\utils::get_api();
            $apiclient->add_user_to_course_group($courseid, $userid);
        } catch (\Exception $e) {
            \local_o365\utils::debug('Exception: '.$e->getMessage(), $caller, $e);
        }
        return false;
    }

    /**
     * Handle user_enrolment_deleted event
     *
     * Tasks
     *     - remove user from course usergroups.
     *
     * @param \core\event\user_enrolment_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_user_enrolment_deleted(\core\event\user_enrolment_deleted $event) {
        global $DB;

        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }

        $userid = $event->relateduserid;
        $courseid = $event->courseid;

        if (empty($userid) || empty($courseid)) {
            return true;
        }

        try {
            // Remove user from course usergroup.
            $apiclient = \local_o365\utils::get_api();
            $apiclient->remove_user_from_course_group($courseid, $userid);
        } catch (\Exception $e) {
            \local_o365\utils::debug($e->getMessage(), 'handle_user_enrolment_deleted', $e);
        }

        try {
            // Remove owner from course usergroup.
            $apiclient = \local_o365\utils::get_api();
            $apiclient->remove_owner_from_course_group($courseid, $userid);
        } catch (\Exception $e) {
            \local_o365\utils::debug($e->getMessage(), 'handle_user_enrolment_deleted', $e);
        }
        return false;
    }

    /**
     * Construct a sharepoint API client using the system API user.
     *
     * @return \local_o365\rest\sharepoint|bool A constructed sharepoint API client, or false if error.
     */
    public static function construct_sharepoint_api_with_system_user() {
        try {
            $spresource = \local_o365\rest\sharepoint::get_resource();
            if (!empty($spresource)) {
                $httpclient = new \local_o365\httpclient();
                $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
                $sptoken = \local_o365\utils::get_app_or_system_token($spresource, $clientdata, $httpclient);
                if (!empty($sptoken)) {
                    $sharepoint = new \local_o365\rest\sharepoint($sptoken, $httpclient);
                    return $sharepoint;
                }
            }
        } catch (\Exception $e) {
            \local_o365\utils::debug($e->getMessage(), get_called_class(), $e);
        }
        return false;
    }

    /**
     * Handle course_created event.
     *
     * Does the following:
     *     - create a sharepoint site and associated groups.
     *
     * @param \core\event\course_created $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_course_created(\core\event\course_created $event) {
        if (\local_o365\utils::is_configured() !== true || \local_o365\rest\sharepoint::is_configured() !== true) {
            return false;
        }
        $sharepoint = static::construct_sharepoint_api_with_system_user();
        if (!empty($sharepoint)) {
            $sharepoint->create_course_site($event->objectid);
        }
    }

    /**
     * Handle course_updated event.
     *
     * Does the following:
     *     - update associated sharepoint sites and associated groups.
     *
     * @param \core\event\course_updated $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_course_updated(\core\event\course_updated $event) {
        if (\local_o365\utils::is_configured() !== true || \local_o365\rest\sharepoint::is_configured() !== true) {
            return false;
        }
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
     *     - delete sharepoint sites and groups, and local sharepoint site data.
     *
     * @param \core\event\course_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_course_deleted(\core\event\course_deleted $event) {
        global $DB;
        if (\local_o365\utils::is_configured() !== true || \local_o365\rest\sharepoint::is_configured() !== true) {
            return false;
        }
        $courseid = $event->objectid;

        // delete course group
        \local_o365\feature\usergroups\utils::delete_course_group($courseid);

        $sharepoint = static::construct_sharepoint_api_with_system_user();
        if (!empty($sharepoint)) {
            $sharepoint->delete_course_site($courseid);
        }
        return true;
    }

    /**
     * Sync SharePoint course site access when a role was assigned or unassigned for a user.
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

            if (\local_o365\rest\unified::is_configured()) {
                $userupn = \local_o365\rest\unified::get_muser_upn($user);
            } else {
                $userupn = \local_o365\rest\azuread::get_muser_upn($user);
            }
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
     *     - check if the assigned role has the permission needed to access course sharepoint sites. If it does, add
     *       the assigned user to the course sharepoint sites as a contributor.
     *     - check if group sync is enabled for the course. If it does, add the user as group owner if the user is a
     *       teacher.
     *
     * @param \core\event\role_assigned $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_role_assigned(\core\event\role_assigned $event) {
        global $DB;

        $response = false;
        if (\local_o365\utils::is_configured() === true) {
            if (\local_o365\rest\sharepoint::is_configured() === true) {
                $response = static::sync_spsite_access_for_roleassign_change($event->objectid, $event->relateduserid,
                    $event->contextid);
            }
            if (\local_o365\feature\usergroups\utils::is_enabled() === true) {
                $userid = $event->relateduserid;
                $courseid = $event->courseid;
                $roleid = $event->objectid;

                if (\local_o365\feature\usergroups\utils::course_is_group_enabled($courseid)) {
                    $caller = 'local_o365\observer::handle_role_assigned';

                    if (empty($userid) || empty($courseid)) {
                        \local_o365\utils::debug("handle_role_assigned no userid $userid or course $courseid", $caller);
                    } else {
                        $teacherrole = get_config('local_o365', 'rolemappingteacher');
                        if (!$teacherrole || $teacherrole == 'teacher') {
                            // Fall back to the default role.
                            $teacherrole = 'teacher';
                            $rolenoneditingteacher = $DB->get_record('role', array('shortname' => $teacherrole))->id;
                        } else {
                            $rolenoneditingteacher = explode(',', $teacherrole);
                        }
                        $editingteacherrole = get_config('local_o365', 'rolemappingeditingteacher');
                        if (!$editingteacherrole || $teacherrole == 'editingteacher') {
                            // Fall back to the default role.
                            $editingteacherrole = 'editingteacher';
                            $roleteacher = $DB->get_record('role', array('shortname' => $editingteacherrole))->id;
                        } else {
                            $roleteacher = explode(',', $editingteacherrole);
                        }
                        $allroles = array_merge($rolenoneditingteacher, $roleteacher);
                        $apiclient = \local_o365\utils::get_api();
                        if (in_array($roleid, $allroles)) {
                            $response = $apiclient->add_owner_to_course_group($courseid, $userid);
                        } else {
                            $response = $apiclient->add_user_to_course_group($courseid, $userid);
                        }
                    }
                }
            }
        }

        return $response;
    }

    /**
     * Handle role_unassigned event
     *
     * Does the following:
     *     - check if, by unassigning this role, the related user no longer has the required capability to access course sharepoint
     *       sites. If they don't, remove them from the sharepoint sites' contributor groups.
     *     - check if group sync is enabled for the course. If it does, remove the user as group owner if the user is
     *       a teacher.
     *
     * @param \core\event\role_unassigned $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_role_unassigned(\core\event\role_unassigned $event) {
        global $DB;

        $response = false;

        if (\local_o365\utils::is_configured() === true) {
            if (\local_o365\rest\sharepoint::is_configured() === true) {
                $response = static::sync_spsite_access_for_roleassign_change($event->objectid, $event->relateduserid,
                    $event->contextid);
            }
            if (\local_o365\feature\usergroups\utils::is_enabled() === true) {
                $userid = $event->relateduserid;
                $courseid = $event->courseid;
                $roleid = $event->objectid;

                if (\local_o365\feature\usergroups\utils::course_is_group_enabled($courseid)) {
                    $caller = 'local_o365\observer::handle_role_unassigned';

                    if (empty($userid) || empty($courseid)) {
                        \local_o365\utils::debug("handle_role_unassigned no userid $userid or course $courseid",
                            $caller);
                    } else {
                        $teacherrole = get_config('local_o365', 'rolemappingteacher');
                        if (!$teacherrole || $teacherrole == 'teacher') {
                            // Fall back to the default role.
                            $teacherrole = 'teacher';
                            $rolenoneditingteacher = $DB->get_record('role', array('shortname' => $teacherrole))->id;
                        } else {
                            $rolenoneditingteacher = explode(',', $teacherrole);
                        }
                        $editingteacherrole = get_config('local_o365', 'rolemappingeditingteacher');
                        if (!$editingteacherrole || $teacherrole == 'editingteacher') {
                            // Fall back to the default role.
                            $editingteacherrole = 'editingteacher';
                            $roleteacher = $DB->get_record('role', array('shortname' => $editingteacherrole))->id;
                        } else {
                            $roleteacher = explode(',', $editingteacherrole);
                        }
                        $allroles = array_merge($rolenoneditingteacher, $roleteacher);
                        if (in_array($roleid, $allroles)) {
                            $apiclient = \local_o365\utils::get_api();
                            $response = $apiclient->remove_owner_from_course_group($courseid, $userid);
                            // add the user back to the group as member
                            $apiclient->add_user_to_course_group($courseid, $userid);
                        }
                    }
                }
            }
        }

        return $response;
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
        if (\local_o365\utils::is_configured() !== true || \local_o365\rest\sharepoint::is_configured() !== true) {
            return false;
        }
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
        if (\local_o365\utils::is_configured() !== true || \local_o365\rest\sharepoint::is_configured() !== true) {
            return false;
        }
        $roleid = $event->objectid;

        // Role deletions can be heavy - run in cron.
        $spaccesssync = new \local_o365\task\sharepointaccesssync();
        $spaccesssync->set_custom_data(['roleid' => '*', 'userid' => '*', 'contextid' => null]);
        \core\task\manager::queue_adhoc_task($spaccesssync);
        return true;
    }

    /**
     * Handle user_deleted event.
     *
     * @param \core\event\user_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_user_deleted(\core\event\user_deleted $event) {
        global $DB;
        $userid = $event->objectid;
        $DB->delete_records('local_o365_token', ['user_id' => $userid]);
        $DB->delete_records('local_o365_objects', ['type' => 'user', 'moodleid' => $userid]);
        $DB->delete_records('local_o365_connections', ['muserid' => $userid]);
        $DB->delete_records('local_o365_appassign', ['muserid' => $userid]);
        return true;
    }

    /**
     * Send proactive notifications to o365 users when a notification is sent to the Moodle user.
     *
     * @param \core\event\notification_sent $event
     *
     * @return bool
     * @throws \dml_exception
     */
    public static function handle_notification_sent(\core\event\notification_sent $event) {
        global $CFG, $DB, $PAGE;

        // check if we have the configuration to send proactive notifications
        $aadtenant = get_config('local_o365', 'aadtenant');
        $botappid = get_config('local_o365', 'bot_app_id');
        $botappsecret = get_config('local_o365', 'bot_app_password');
        $notificationendpoint = get_config('local_o365', 'bot_webhook_endpoint');
        if (empty($aadtenant) || empty($botappid) || empty($botappsecret) || empty($notificationendpoint)) {
            // incomplete settings, exit.
            debugging('SKIPPED: handle_notification_sent - incomplete settings', DEBUG_DEVELOPER);
            return true;
        }

        $notificationid = $event->objectid;
        $notification = $DB->get_record('notifications', ['id' => $notificationid]);
        if (!$notification) {
            // notification cannot be found, exit.
            debugging('SKIPPED: handle_notification_sent - notification cannot be found', DEBUG_DEVELOPER);
            return true;
        }

        $user = $DB->get_record('user', ['id' => $notification->useridto]);
        if (!$user) {
            // recipient user invalid, exit.
            debugging('SKIPPED: handle_notification_sent - recipient user invalid', DEBUG_DEVELOPER);
            return true;
        }

        if ($user->auth != 'oidc') {
            // recipient user is not office 365 user, exit.
            debugging('SKIPPED: handle_notification_sent - recipient user is not office 365 user', DEBUG_DEVELOPER);
            return true;
        }

        // get user object record
        $userrecord = $DB->get_record('local_o365_objects', ['type' => 'user', 'moodleid' => $user->id]);
        if (!$userrecord) {
            // recipient user doesn't have an object ID, exit.
            debugging('SKIPPED: handle_notification_sent - recipient user doesn\'t have an object ID', DEBUG_DEVELOPER);
            return true;
        }

        // get course object record
        if (!array_key_exists('courseid', $event->other)) {
            // course doesn't exist, exit.
            debugging('SKIPPED: handle_notification_sent - course doesn\'t exist', DEBUG_DEVELOPER);
            return true;
        }
        $courseid = $event->other['courseid'];
        if (!$courseid || $courseid == SITEID) {
            // invalid course id, exit.
            debugging('SKIPPED: handle_notification_sent - invalid course id', DEBUG_DEVELOPER);
            return true;
        }
        $course = $DB->get_record('course', ['id' => $courseid]);
        if (!$course) {
            // invalid course, exit.
            debugging('SKIPPED: handle_notification_sent - invalid course id', DEBUG_DEVELOPER);
            return true;
        }

        // get course object record
        $courserecord = $DB->get_record('local_o365_objects',
            ['type' => 'group', 'subtype' => 'course', 'moodleid' => $courseid]);
        if (!$courserecord) {
            // course record doesn't have an object ID, exit.
            debugging('SKIPPED: handle_notification_sent - course record doesn\'t have an object ID', DEBUG_DEVELOPER);
            return true;
        }else{
            $courseobjectid = $courserecord->objectid;
        }

        // passed all tests, need to send notification
        $botframework = new \local_o365\rest\botframework();
        if (!$botframework->has_token()) {
            // cannot get token, exit.
            debugging('SKIPPED: handle_notification_sent - cannot get token from bot framework', DEBUG_DEVELOPER);
            return true;
        }

        //Check if we need to add activity details
        $listItems = [];
        if ((strpos($notification->component, 'mod_') !== FALSE) && !empty($notification->contexturl)) {
            $PAGE->theme->force_svg_use(null);
            $listItems[] = [
                'title' => $notification->contexturlname,
                'subtitle' => '',
                'icon' => $CFG->wwwroot . '/local/o365/pix/moodle.png',
                'action' => $notification->contexturl,
                'actionType' => 'openUrl'
            ];
        }
        $message = (empty($notification->smallmessage) ? $notification->fullmessage : $notification->smallmessage);
        // send notification
        $botframework->send_notification($courseobjectid, $userrecord->objectid,
            $message, $listItems, $notificationendpoint);
        return true;
    }
}
