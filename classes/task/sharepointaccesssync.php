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
 * AdHoc task to sync Moodle permissions with sharepoint.
 */
class sharepointaccesssync extends \core\task\adhoc_task {
    /**
     * Sync sharepoint access for a list of courses and users.
     *
     * @param array $courses The courses to sync.
     * @param array $users The users to sync.
     * @param string $requiredcap The required capability.
     * @param \local\o365\rest\sharepoint $sharepoint Constructed sharepoint API client.
     * @return bool Success/Failure.
     */
    protected function sync_spsiteaccess_for_courses_and_users(array $courses, array $users, $requiredcap,
                                                               \local_o365\rest\sharepoint $sharepoint) {
        global $DB;
        foreach ($courses as $course) {
            $courseid = (is_numeric($course)) ? $course : $course->id;
            $context = \context_course::instance($courseid);
            $spgroupsql = 'SELECT *
                             FROM {local_o365_coursespsite} site
                             JOIN {local_o365_spgroupdata} grp ON grp.coursespsiteid = site.id
                            WHERE site.courseid = ? AND grp.permtype = ?';
            $spgrouprec = $DB->get_record_sql($spgroupsql, [$courseid, 'contribute']);
            foreach ($users as $user) {
                $userid = (is_numeric($user)) ? $user : $user->id;
                $userupn = \local_o365\rest\azuread::get_muser_upn($user);
                $hascap = has_capability($requiredcap, $context, $user);
                if ($hascap === true) {
                    // Add to group.
                    $sharepoint->add_user_to_group($userupn, $spgrouprec->groupid, $userid);
                } else {
                    // Remove from group.
                    $sharepoint->remove_user_from_group($userupn, $spgrouprec->groupid, $userid);
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
        global $DB;
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
     * Do the job.
     */
    public function execute() {
        $reqcap = \local_o365\rest\sharepoint::get_course_site_required_capability();

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
                }
            }
        }

        if (empty($sharepoint)) {
            throw new \moodle_exception('errorcreatingsharepointclient', 'local_o365');
        }

        $opdata = $this->get_custom_data();
        if ($opdata->userid !== '*' && $opdata->roleid !== '*' && !empty($opdata->contextid)) {
            // Single user role assign/unassign.
            $this->do_role_assignmentchange($opdata->roleid, $opdata->userid, $opdata->contextid, $reqcap, $sharepoint);
        } else if ($opdata->userid === '*' && $opdata->roleid !== '*') {
            // Capability update.
            $this->do_role_capabilitychange($opdata->roleid, $reqcap, $sharepoint);
        } else if ($opdata->roleid === '*' && $opdata->userid === '*') {
            // Role deleted.
            $this->do_role_delete($reqcap, $sharepoint);
        }
    }
}
