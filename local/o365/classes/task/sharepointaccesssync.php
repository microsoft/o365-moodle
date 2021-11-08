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
 * AdHoc task to sync Moodle permissions with sharepoint.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
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
            if (!empty($spgrouprec)) {
                foreach ($users as $user) {
                    $userid = (is_numeric($user)) ? $user : $user->id;
                    if (!\local_o365\utils::is_o365_connected($userid)) {
                        continue;
                    }
                    if (\local_o365\rest\unified::is_configured()) {
                        $userupn = \local_o365\rest\unified::get_muser_upn($user);
                    } else {
                        $userupn = \local_o365\rest\azuread::get_muser_upn($user);
                    }
                    $hascap = has_capability($requiredcap, $context, $user);
                    if ($hascap === true) {
                        // Add to group.
                        try {
                            mtrace('Adding user #'.$userid.' to group id '.$spgrouprec->groupid.'...');
                            $sharepoint->add_user_to_group($userupn, $spgrouprec->groupid, $userid);
                        } catch (\Exception $e) {
                            mtrace('Error: '.$e->getMessage());
                        }
                    } else {
                        // Remove from group.
                        try {
                            mtrace('Removing user #'.$userid.' from group id '.$spgrouprec->groupid.'...');
                            $sharepoint->remove_user_from_group($userupn, $spgrouprec->groupid, $userid);
                        } catch (\Exception $e) {
                            mtrace('Error: '.$e->getMessage());
                        }
                    }
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
        $o365userids = [];
        foreach ($roleassignments as $roleassignment) {
            $roleassignmentssorted[$roleassignment->contextid][] = $roleassignment->userid;
            $o365userids[$roleassignment->userid] = (int)$roleassignment->userid;
        }
        $roleassignments->close();

        // Limit recorded users to o365 users.
        $o365userids = \local_o365\utils::limit_to_o365_users($o365userids);

        foreach ($roleassignmentssorted as $contextid => $users) {
            $users = array_intersect($users, $o365userids);
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
        $users = $DB->get_records('user', null, '', 'id, username');
        $courses = $DB->get_records('course', null, '', 'id');
        return $this->sync_spsiteaccess_for_courses_and_users($courses, $users, $requiredcap, $sharepoint);
    }

    /**
     * Do the job.
     */
    public function execute() {
        if (\local_o365\utils::is_configured() !== true) {
            return false;
        }

        $reqcap = \local_o365\rest\sharepoint::get_course_site_required_capability();

        $sharepointtokenresource = \local_o365\rest\sharepoint::get_tokenresource();
        if (!empty($sharepointtokenresource)) {
            $httpclient = new \local_o365\httpclient();
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            $sptoken = \local_o365\utils::get_app_or_system_token($sharepointtokenresource, $clientdata, $httpclient);
            if (!empty($sptoken)) {
                $sharepoint = new \local_o365\rest\sharepoint($sptoken, $httpclient);
            } else {
                $errmsg = 'Could not get system API user token for SharePoint';
                \local_o365\utils::debug($errmsg, 'local_o365\task\sharepointaccesssync::execute');
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
