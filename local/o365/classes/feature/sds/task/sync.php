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
 * Scheduled task to run SDS sync.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\sds\task;

use context_course;
use core\task\scheduled_task;
use core_course_category;
use core_text;
use local_o365\rest\unified;
use local_o365\utils;
use moodle_exception;

/**
 * Scheduled task to run SDS sync.
 */
class sync extends scheduled_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name(): string {
        return get_string('task_sds_sync', 'local_o365');
    }

    /**
     * Run the sync process.
     *
     * @param unified $apiclient The unified API client.
     * @return bool
     */
    public static function runsync(unified $apiclient): bool {
        global $DB, $CFG;

        require_once($CFG->dirroot . '/user/lib.php');
        require_once($CFG->dirroot . '/user/profile/lib.php');
        require_once($CFG->libdir . '/accesslib.php');
        require_once($CFG->libdir . '/enrollib.php');

        // Profile data sync.
        static::mtrace('Running profile sync', 1);
        [$idandnamemappings, $additionalprofilemappings] = \local_o365\feature\sds\utils::get_sds_profile_sync_api_requirements();

        if ($idandnamemappings || $additionalprofilemappings) {
            static::mtrace('SDS fields exists in field mapping settings', 2);
            [$profilesyncenabled, $schoolid, $schoolname] = \local_o365\feature\sds\utils::get_profile_sync_status_with_id_name(
                $apiclient
            );

            if ($profilesyncenabled) {
                static::mtrace('SDS field mapping enabled and connected to school "' . $schoolname . '"', 2);
                $processedschoolusers = [];
                if ($additionalprofilemappings) {
                    static::mtrace('Additional SDS profile data required', 2);
                    $rawschoolusers = $apiclient->get_school_users($schoolid);

                    foreach ($rawschoolusers as $rawschooluser) {
                        if (
                            $userobjectrecord = $DB->get_record('local_o365_objects', ['type' => 'user',
                            'objectid' => $rawschooluser['id']])
                        ) {
                            $processedschoolusers[$userobjectrecord->moodleid] = $rawschooluser;
                        }
                    }
                } else {
                    static::mtrace('Only basic SDS profile data required', 2);
                }

                // Use recordset instead of get_records to reduce memory usage.
                $oidcusersrecordset = $DB->get_recordset('user', ['auth' => 'oidc', 'deleted' => 0]);
                foreach ($oidcusersrecordset as $userid => $oidcuser) {
                    $completeuser = get_complete_user_data('id', $userid);
                    if ($completeuser) {
                        static::mtrace('Processing user ' . $oidcuser->username, 3);
                        foreach ($idandnamemappings as $remotefield => $localfield) {
                            switch ($remotefield) {
                                case 'sds_school_id':
                                    $completeuser->$localfield = $schoolid;
                                    break;
                                case 'sds_school_name':
                                    $completeuser->$localfield = $schoolname;
                                    break;
                            }
                        }

                        if (array_key_exists($userid, $processedschoolusers)) {
                            static::mtrace('User profile found in SDS', 4);
                            $processedschooluser = $processedschoolusers[$userid];
                            $primaryrole = $processedschooluser['primaryRole'];
                            $studentexternalid = '';
                            $studentbirthdate = '';
                            $studentgrade = '';
                            $studentgraduationyear = '';
                            $studentstudentnumber = '';
                            $teacherexternalid = '';
                            $teacherteachernumber = '';
                            if ($primaryrole == 'student' && isset($processedschooluser['student'])) {
                                if (isset($processedschooluser['student']['externalId'])) {
                                    $studentexternalid = $processedschooluser['student']['externalId'];
                                }

                                if (isset($processedschooluser['student']['birthDate'])) {
                                    $studentbirthdate = $processedschooluser['student']['birthDate'];
                                }

                                if (isset($processedschooluser['student']['grade'])) {
                                    $studentgrade = $processedschooluser['student']['grade'];
                                }

                                if (isset($processedschooluser['student']['graduationYear'])) {
                                    $studentgraduationyear = $processedschooluser['student']['graduationYear'];
                                }

                                if (isset($processedschooluser['student']['studentNumber'])) {
                                    $studentstudentnumber = $processedschooluser['student']['studentNumber'];
                                }
                            }

                            if ($primaryrole == 'teacher' && isset($processedschooluser['teacher'])) {
                                if (isset($processedschooluser['teacher']['externalId'])) {
                                    $teacherexternalid = $processedschooluser['teacher']['externalId'];
                                }

                                if (isset($processedschooluser['teacher']['teacherNumber'])) {
                                    $teacherteachernumber = $processedschooluser['teacher']['teacherNumber'];
                                }
                            }

                            foreach ($additionalprofilemappings as $remotefield => $localfield) {
                                switch ($remotefield) {
                                    case 'sds_school_role':
                                        $completeuser->$localfield = $primaryrole;
                                        break;
                                    case 'sds_student_externalId':
                                        $completeuser->$localfield = $studentexternalid;
                                        break;
                                    case 'sds_student_birthDate':
                                        $completeuser->$localfield = $studentbirthdate;
                                        break;
                                    case 'sds_student_grade':
                                        $completeuser->$localfield = $studentgrade;
                                        break;
                                    case 'sds_student_graduationYear':
                                        $completeuser->$localfield = $studentgraduationyear;
                                        break;
                                    case 'sds_student_studentNumber':
                                        $completeuser->$localfield = $studentstudentnumber;
                                        break;
                                    case 'sds_teacher_externalId':
                                        $completeuser->$localfield = $teacherexternalid;
                                        break;
                                    case 'sds_teacher_teacherNumber':
                                        $completeuser->$localfield = $teacherteachernumber;
                                        break;
                                }
                            }

                            // Save user profile.
                            user_update_user($completeuser, false, false);
                            profile_save_data($completeuser);

                            static::mtrace('User profile updated', 4);
                        } else {
                            static::mtrace('User profile not found in SDS', 4);
                        }
                    }
                }

                $oidcusersrecordset->close();
            } else {
                static::mtrace('SDS field mapping disabled', 2);
            }
        } else {
            static::mtrace('SDS fields not used in field map settings', 2);
        }

        // Course sync.
        static::mtrace('Running course sync', 1);
        $schoolobjectids = get_config('local_o365', 'sdsschools');
        $sdscoursesyncenabled = true;
        $sdscoursesyncroleconfigured = true;
        if (!$schoolobjectids) {
            $sdscoursesyncenabled = false;
        } else {
            $schoolobjectids = explode(',', $schoolobjectids);
            if (!$schoolobjectids) {
                $sdscoursesyncenabled = false;
            } else {
                $enrolenabled = get_config('local_o365', 'sdsenrolmentenabled');
                $teamsyncenabled = get_config('local_o365', 'sdsteamsenabled');

                if ($enrolenabled) {
                    // Get role records.
                    $studentrole = null;
                    $studentroleid = get_config('local_o365', 'sdsenrolmentstudentrole');
                    if ($studentroleid) {
                        $studentrole = $DB->get_record('role', ['id' => $studentroleid], '*', IGNORE_MISSING);
                    }

                    if (empty($studentrole)) {
                        $sdscoursesyncroleconfigured = false;
                    }

                    $teacherrole = null;
                    $teacherroleid = get_config('local_o365', 'sdsenrolmentteacherrole');
                    if ($teacherroleid) {
                        $teacherrole = $DB->get_record('role', ['id' => $teacherroleid], '*', IGNORE_MISSING);
                    }

                    if (empty($teacherrole)) {
                        $sdscoursesyncroleconfigured = false;
                    }
                }
            }
        }

        if (!$sdscoursesyncenabled) {
            static::mtrace('SDS course sync disabled', 2);
            return true;
        } else if ($enrolenabled && !$sdscoursesyncroleconfigured) {
            static::mtrace('SDS course sync enabled, but role mapping not configured', 2);
            return true;
        }

        $syncedschools = [];
        $schools = $apiclient->get_schools();

        foreach ($schools as $school) {
            if (in_array($school['id'], $schoolobjectids)) {
                $syncedschools[$school['id']] = $school;
            }
        }

        foreach ($syncedschools as $schoolid => $syncedschool) {
            $schoolcoursecat = static::get_or_create_school_coursecategory($syncedschool['id'], $syncedschool['displayName']);
            static::mtrace('Processing school ' . $syncedschool['displayName'], 2);

            $schoolclasses = $apiclient->get_school_classes($schoolid);

            // Get configuration options (read once per school, not per class).
            $sdscategorizebysubject = get_config('local_o365', 'sdscategorizebysubject');
            $sdsignorepastclasses = get_config('local_o365', 'sdsignorepastclasses');
            $sdsexpiredprefix = trim((string) get_config('local_o365', 'sdsexpiredprefix'));
            if (empty($sdsexpiredprefix)) {
                $sdsexpiredprefix = 'Exp';
            }
            $sdsenablecoursesync = get_config('local_o365', 'sdsenablecoursesync');
            $sdscreatecohorts = get_config('local_o365', 'sdscreatecohorts');
            $includeteachers = get_config('local_o365', 'sdscohortincludeteachers');
            $suspendusers = get_config('local_o365', 'sdssuspendenrolment');

            foreach ($schoolclasses as $schoolclass) {
                static::mtrace('Processing school section ' . $schoolclass['displayName'], 3);

                // Extract course dates from term information.
                $classstartdate = 0;
                $classenddate = 0;
                if (isset($schoolclass['term']) && is_array($schoolclass['term'])) {
                    if (isset($schoolclass['term']['startDate'])) {
                        $classstartdate = strtotime($schoolclass['term']['startDate']);
                    }
                    if (isset($schoolclass['term']['endDate'])) {
                        $classenddate = strtotime($schoolclass['term']['endDate']);
                    }
                }

                // Filter out expired courses if configured.
                if ($sdsignorepastclasses) {
                    // Check for expired prefix.
                    if (str_starts_with($schoolclass['displayName'], $sdsexpiredprefix)) {
                        static::mtrace('Skipping expired course (prefix match): ' . $schoolclass['displayName'], 4);
                        continue;
                    }
                    // Check end date.
                    if ($classenddate > 0 && $classenddate < time()) {
                        static::mtrace('Skipping expired course (past end date): ' . $schoolclass['displayName'] .
                            ' (end date: ' . date('Y-m-d', $classenddate) . ')', 4);
                        continue;
                    }
                }

                // Determine course category (subject-based or school-based).
                $coursecat = $schoolcoursecat;
                if ($sdscategorizebysubject) {
                    // Extract subject name from class data.
                    // Only course.subject carries the actual academic subject; classCode and
                    // externalName are section identifiers and must NOT be used as fallbacks
                    // because they would create spurious categories named after the class.
                    // When course.subject is absent the course falls back to the school category.
                    $subjectname = null;
                    if (isset($schoolclass['course']['subject']) && $schoolclass['course']['subject'] !== '') {
                        $subjectname = $schoolclass['course']['subject'];
                    }

                    if (!empty($subjectname)) {
                        // Normalize: trim leading/trailing whitespace and collapse internal runs.
                        $subjectname = trim(preg_replace('/\s+/', ' ', $subjectname));
                        // Resolve SDS numeric subject codes to human-readable names.
                        $subjectname = static::resolve_subject_name($subjectname);
                    }

                    if (!empty($subjectname)) {
                        $coursecat = static::get_or_create_subject_coursecategory(
                            $subjectname,
                            $schoolcoursecat->id
                        );
                        static::mtrace('Using subject category: ' . $subjectname, 4);
                    } else {
                        static::mtrace('No subject on class ' . $schoolclass['displayName'] . ', using school category.', 4);
                    }
                }

                // Create the course.
                $course = static::get_or_create_class_course(
                    $schoolclass['id'],
                    $schoolclass['mailNickname'],
                    $schoolclass['displayName'],
                    $coursecat->id,
                    $classstartdate,
                    $classenddate
                );
                $coursecontext = context_course::instance($course->id);

                // Enable two-way sync (course sync) if configured.
                if ($sdsenablecoursesync) {
                    // Associate the section group with the course for two-way sync.
                    $groupobjectparams = ['type' => 'group', 'subtype' => 'course', 'objectid' => $schoolclass['id'],
                        'moodleid' => $course->id];
                    $groupobjectrec = $DB->get_record('local_o365_objects', $groupobjectparams);

                    if (empty($groupobjectrec)) {
                        $now = time();
                        $groupobjectrec = $groupobjectparams;
                        $groupobjectrec['o365name'] = $schoolclass['displayName'];
                        $groupobjectrec['timecreated'] = $now;
                        $groupobjectrec['timemodified'] = $now;
                        $groupobjectrec['id'] = $DB->insert_record('local_o365_objects', (object) $groupobjectrec);
                        \local_o365\feature\coursesync\utils::set_course_sync_enabled($course->id);
                        static::mtrace('Enabled two-way sync for course ' . $course->id, 4);

                        if ($teamsyncenabled) {
                            $teamobjectrec = ['type' => 'group', 'subtype' => 'teamfromgroup', 'objectid' => $schoolclass['id'],
                                'moodleid' => $course->id];
                            $teamobjectrec['o365name'] = $schoolclass['displayName'];
                            $teamobjectrec['timecreated'] = $now;
                            $teamobjectrec['timemodified'] = $now;
                            $teamobjectrec['id'] = $DB->insert_record('local_o365_objects', (object) $teamobjectrec);
                        }
                    }
                }

                // Sync cohorts if enabled.
                if ($sdscreatecohorts) {
                    static::mtrace('Running cohort sync', 4);

                    // Create or get the cohort for this class.
                    $cohort = static::get_or_create_class_cohort(
                        $schoolclass['id'],
                        $schoolclass['mailNickname'],
                        $schoolclass['displayName'],
                        $coursecat->id
                    );

                    // Sync cohort membership.
                    $allclassmembers = [];

                    // Get teachers.
                    $classteacherlist = $apiclient->get_school_class_teachers($schoolclass['id']);
                    if (!empty($classteacherlist)) {
                        foreach ($classteacherlist as $teacher) {
                            $teacher['@odata.type'] = '#microsoft.graph.educationTeacher';
                            $allclassmembers[] = $teacher;
                        }
                    }

                    // Get students/members.
                    $classmemberlist = $apiclient->get_school_class_members($schoolclass['id']);
                    if (!empty($classmemberlist)) {
                        foreach ($classmemberlist as $member) {
                            $member['@odata.type'] = '#microsoft.graph.educationStudent';
                            $allclassmembers[] = $member;
                        }
                    }

                    if (!empty($allclassmembers)) {
                        static::sync_cohort_members($cohort, $allclassmembers, $includeteachers);
                    }
                }

                // Sync enrolments from SDS into Moodle (controlled by the 'sdsenrolmentenabled' setting).
                if (!empty($enrolenabled)) {
                    static::mtrace('Running enrol sync', 4);

                    $classuserids = [];

                    // Sync teachers.
                    // Teachers are never unassigned, suspended, or unenrolled by SDS sync —
                    // their enrolment is managed manually or by other means. We only ADD new
                    // teacher role assignments here; we never remove existing ones.
                    // Build a snapshot of current teacher userids so the "removed users" handler
                    // below can identify and skip them.
                    $priorteacheruserids = [];
                    $existingteacherroleassignments = get_users_from_role_on_context($teacherrole, $coursecontext);
                    foreach ($existingteacherroleassignments as $roleassignment) {
                        $priorteacheruserids[$roleassignment->userid] = true;
                    }

                    $teachersobjectids = [];
                    $classteachers = $apiclient->get_school_class_teachers($schoolclass['id']);
                    $classteachers = is_array($classteachers) ? $classteachers : [];
                    static::mtrace('API returned ' . count($classteachers) . ' teachers for class ' . $schoolclass['id'], 5);
                    foreach ($classteachers as $classteacher) {
                        $classuserids[] = $classteacher['id'];
                        $objectrec = $DB->get_record('local_o365_objects', ['type' => 'user', 'objectid' => $classteacher['id']]);
                        if (empty($objectrec)) {
                            static::mtrace('Teacher ' . $classteacher['id'] . ': no local_o365_objects mapping found, skipping', 5);
                            continue;
                        }
                        $teachersobjectids[] = $classteacher['id'];
                        $role = $teacherrole;

                        $roleparams = ['roleid' => $role->id, 'contextid' => $coursecontext->id,
                            'userid' => $objectrec->moodleid, 'component' => '', 'itemid' => 0];
                        if (!$DB->record_exists('role_assignments', $roleparams)) {
                            static::mtrace('Enrolling user ' . $objectrec->moodleid . ' into course ' . $course->id, 5);
                            enrol_try_internal_enrol(
                                $course->id,
                                $objectrec->moodleid,
                                $role->id
                            );
                        }
                    }

                    // Sync members.
                    // Store as a [userid => true] map for O(1) removal tracking.
                    $existingstudentids = [];
                    $existingstudentroleassignments = get_users_from_role_on_context($studentrole, $coursecontext);
                    foreach ($existingstudentroleassignments as $roleassignment) {
                        $existingstudentids[$roleassignment->userid] = true;
                    }

                    // Fetch enrol instances once per course (used for reactivation checks inside the loop).
                    $courseenrolinstances = [];
                    // Suspended user_enrolments for the course, keyed by [userid][enrolid].
                    // Pre-fetched in bulk so the per-member loop needs no DB queries for reactivation.
                    $suspendedenrolmentsbyuser = [];
                    if ($suspendusers) {
                        $courseenrolinstances = $DB->get_records('enrol', ['courseid' => $course->id]);
                        if (!empty($courseenrolinstances)) {
                            [$enrolidssql, $enrolidsparams] = $DB->get_in_or_equal(
                                array_keys($courseenrolinstances),
                                SQL_PARAMS_NAMED
                            );
                            $suspendedenrolments = $DB->get_records_sql(
                                'SELECT * FROM {user_enrolments} WHERE status = :status AND enrolid ' . $enrolidssql,
                                array_merge($enrolidsparams, ['status' => ENROL_USER_SUSPENDED])
                            );
                            foreach ($suspendedenrolments as $suspendedenrolment) {
                                $suspendedenrolmentsbyuser[$suspendedenrolment->userid][$suspendedenrolment->enrolid]
                                    = $suspendedenrolment;
                            }
                        }
                    }

                    $classmembers = $apiclient->get_school_class_members($schoolclass['id']);
                    $classmembers = is_array($classmembers) ? $classmembers : [];
                    static::mtrace('API returned ' . count($classmembers) . ' members for class ' . $schoolclass['id'], 5);
                    foreach ($classmembers as $classmember) {
                        if (!in_array($classmember['id'], $teachersobjectids)) {
                            $classuserids[] = $classmember['id'];
                        }

                        $objectrec = $DB->get_record('local_o365_objects', ['type' => 'user', 'objectid' => $classmember['id']]);
                        if (empty($objectrec)) {
                            static::mtrace('Member ' . $classmember['id'] . ': no local_o365_objects mapping found, skipping', 5);
                            continue;
                        }
                        // O(1) removal from the map of pre-existing student role assignments.
                        unset($existingstudentids[$objectrec->moodleid]);

                        $role = $studentrole;

                        $roleparams = ['roleid' => $role->id, 'contextid' => $coursecontext->id,
                            'userid' => $objectrec->moodleid, 'component' => '', 'itemid' => 0];
                        if (!$DB->record_exists('role_assignments', $roleparams)) {
                            static::mtrace('Enrolling user ' . $objectrec->moodleid . ' into course ' . $course->id, 5);
                            enrol_try_internal_enrol(
                                $course->id,
                                $objectrec->moodleid,
                                $role->id
                            );
                        } else {
                            // User is already enrolled - check if they are suspended and need to be reactivated.
                            // Use the pre-fetched map to avoid a DB query per member.
                            if ($suspendusers && isset($suspendedenrolmentsbyuser[$objectrec->moodleid])) {
                                foreach ($suspendedenrolmentsbyuser[$objectrec->moodleid] as $userenrolment) {
                                    static::mtrace('Reactivating suspended user ' . $objectrec->moodleid .
                                        ' in course ' . $course->id, 5);
                                    $enrolinstance = $courseenrolinstances[$userenrolment->enrolid];
                                    $enrolplugin = enrol_get_plugin($enrolinstance->enrol);
                                    if ($enrolplugin && method_exists($enrolplugin, 'update_user_enrol')) {
                                        $enrolplugin->update_user_enrol(
                                            $enrolinstance,
                                            $objectrec->moodleid,
                                            ENROL_USER_ACTIVE
                                        );
                                    }
                                }
                            }
                        }
                    }

                    foreach (array_keys($existingstudentids) as $existingstudentid) {
                        static::mtrace('Unassign class member role from user ' . $existingstudentid . ' in course ' .
                            $course->id, 5);
                        role_unassign($studentroleid, $existingstudentid, $coursecontext->id);
                    }

                    // Handle users who have been removed from the SDS class.
                    $enrolledusers = get_enrolled_users($coursecontext);
                    if (!$enrolledusers) {
                        continue;
                    }

                    [$moodleuseridsql, $params] = $DB->get_in_or_equal(array_keys($enrolledusers), SQL_PARAMS_NAMED);
                    $sql = 'SELECT objectid, moodleid AS userid
                              FROM {local_o365_objects}
                             WHERE type = :usertype
                               AND moodleid ' . $moodleuseridsql;
                    $params = array_merge($params, ['usertype' => 'user']);
                    $courseuserobjectids = $DB->get_records_sql($sql, $params);
                    $userstoberemoved = array_diff(array_keys($courseuserobjectids), $classuserids);
                    $enrols = [];
                    if ($userstoberemoved) {
                        $enrols = $DB->get_records('enrol', ['courseid' => $course->id]);
                    }

                    if ($enrols) {
                        // Collect non-teacher userids to process, skipping teachers up-front.
                        $useridstoprocess = [];
                        foreach ($userstoberemoved as $userobjectid) {
                            $userid = $courseuserobjectids[$userobjectid]->userid;
                            if (!isset($priorteacheruserids[$userid])) {
                                $useridstoprocess[] = $userid;
                            }
                        }

                        if (!empty($useridstoprocess)) {
                            // Bulk-fetch all relevant user_enrolments in one query instead of N per-user queries.
                            [$enrolsql, $enrolparams] = $DB->get_in_or_equal(array_keys($enrols), SQL_PARAMS_NAMED);
                            [$useridsql, $useridparams] = $DB->get_in_or_equal($useridstoprocess, SQL_PARAMS_NAMED);
                            $alluserenrolments = $DB->get_records_sql(
                                'SELECT * FROM {user_enrolments} WHERE userid ' . $useridsql . ' AND enrolid ' . $enrolsql,
                                array_merge($useridparams, $enrolparams)
                            );

                            // Group fetched enrolments by userid for O(1) per-user access.
                            $enrolmentsbyuser = [];
                            foreach ($alluserenrolments as $userenrolment) {
                                $enrolmentsbyuser[$userenrolment->userid][$userenrolment->enrolid] = $userenrolment;
                            }

                            foreach ($useridstoprocess as $userid) {
                                $userenrolments = $enrolmentsbyuser[$userid] ?? [];
                                if (empty($userenrolments)) {
                                    continue;
                                }

                                if ($suspendusers) {
                                    static::mtrace('Suspending user ' . $userid . ' in course ' . $course->id, 5);
                                    foreach ($userenrolments as $userenrolment) {
                                        $enrolplugin = enrol_get_plugin($enrols[$userenrolment->enrolid]->enrol);
                                        if ($enrolplugin && method_exists($enrolplugin, 'update_user_enrol')) {
                                            $enrolplugin->update_user_enrol(
                                                $enrols[$userenrolment->enrolid],
                                                $userid,
                                                ENROL_USER_SUSPENDED
                                            );
                                        }
                                    }
                                } else {
                                    static::mtrace('Unenrol user ' . $userid . ' from course ' . $course->id, 5);
                                    foreach ($userenrolments as $userenrolment) {
                                        $enrolplugin = enrol_get_plugin($enrols[$userenrolment->enrolid]->enrol);
                                        $enrolplugin->unenrol_user($enrols[$userenrolment->enrolid], $userid);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    static::mtrace('Enrol sync disabled (sdsenrolmentenabled is off)', 4);
                }
            }
        }

        // Clean up SDS sync records.
        static::clean_up_sds_sync_records();

        return true;
    }

    /**
     * Resolve a Microsoft SDS subject code to its human-readable name.
     *
     * SDS subjects are a standardised enum defined by Microsoft. Each code has a
     * short form (e.g. '14') and a long numeric form (e.g. '14999'); both are
     * accepted. When the code is unknown the original value is returned unchanged
     * so the category name is always non-empty.
     *
     * Reference: https://learn.microsoft.com/en-us/schooldatasync/default-list-of-values#subjects
     *
     * @param string $code The raw subject code returned by the Graph API.
     * @return string The human-readable subject name, or the original code if unrecognised.
     */
    public static function resolve_subject_name(string $code): string {
        // Map both the short code and the alternate long numeric code to the same label.
        $map = [
            '01'    => 'English language and literature',
            '51037' => 'English language and literature',
            '02'    => 'Mathematics',
            '52039' => 'Mathematics',
            '03'    => 'Life and physical sciences',
            '51999' => 'Life and physical sciences',
            '04'    => 'Social sciences and history',
            '54999' => 'Social sciences and history',
            '05'    => 'Visual and performing arts',
            '55199' => 'Visual and performing arts',
            '07'    => 'Religious education and theology',
            '57999' => 'Religious education and theology',
            '08'    => 'Physical, health, and safety education',
            '58999' => 'Physical, health, and safety education',
            '09'    => 'Military science',
            '09999' => 'Military science',
            '10'    => 'Information technology',
            '10999' => 'Information technology',
            '11'    => 'Communication and audio/video technology',
            '11999' => 'Communication and audio/video technology',
            '12'    => 'Business and marketing',
            '62999' => 'Business and marketing',
            '13'    => 'Manufacturing',
            '13999' => 'Manufacturing',
            '14'    => 'Health care sciences',
            '14999' => 'Health care sciences',
            '15'    => 'Public, protective, and government service',
            '65999' => 'Public, protective, and government service',
            '16'    => 'Hospitality and tourism',
            '66999' => 'Hospitality and tourism',
            '17'    => 'Architecture and construction',
            '67997' => 'Architecture and construction',
            '18'    => 'Agriculture, food, and natural resources',
            '68999' => 'Agriculture, food, and natural resources',
            '19'    => 'Human services',
            '69001' => 'Human services',
            '20'    => 'Transportation, distribution, and logistics',
            '70999' => 'Transportation, distribution, and logistics',
            '21'    => 'Engineering and technology',
            '71999' => 'Engineering and technology',
            '22'    => 'Miscellaneous',
            '22999' => 'Miscellaneous',
            '23'    => 'Non-subject-specific',
            '72999' => 'Non-subject-specific',
            '24'    => 'World language',
            '24039' => 'World language',
        ];

        return $map[$code] ?? $code;
    }

    /**
     * Run mtrace if not in a unit test.
     *
     * @param string $str The trace string.
     * @param int $level
     */
    public static function mtrace(string $str, int $level = 0) {
        if (!PHPUNIT_TEST && !defined('BEHAT_SITE_RUNNING')) {
            $str = str_repeat('...', $level) . ' ' . $str;
            mtrace($str);
        }
    }

    /**
     * Retrieve or create a course for a class.
     *
     * @param string $classobjectid The object ID of the class.
     * @param string $shortname The shortname of the class course.
     * @param string $fullname The full name of the class course.
     * @param int $categoryid The ID of the category to create the course in (if necessary).
     * @param int $startdate Optional start date for the course (Unix timestamp).
     * @param int $enddate Optional end date for the course (Unix timestamp).
     * @return object The course object.
     */
    public static function get_or_create_class_course(
        string $classobjectid,
        string $shortname,
        string $fullname,
        int $categoryid = 0,
        int $startdate = 0,
        int $enddate = 0
    ): object {
        global $DB, $CFG;

        require_once($CFG->dirroot . '/course/lib.php');

        // Look for existing course.
        $params = ['type' => 'sdssection', 'subtype' => 'course', 'objectid' => $classobjectid];
        $objectrec = $DB->get_record('local_o365_objects', $params);
        if (!empty($objectrec)) {
            $course = $DB->get_record('course', ['id' => $objectrec->moodleid]);
            if (!empty($course)) {
                // Update course dates and category if they have changed.
                $updated = false;
                if ($startdate > 0 && $course->startdate != $startdate) {
                    $course->startdate = $startdate;
                    $updated = true;
                }
                if ($enddate > 0 && $course->enddate != $enddate) {
                    $course->enddate = $enddate;
                    $updated = true;
                }
                if ($categoryid > 0 && $course->category != $categoryid) {
                    $course->category = $categoryid;
                    $updated = true;
                    static::mtrace('Moving course ' . $fullname . ' to category ' . $categoryid, 4);
                }
                if ($updated) {
                    update_course($course);
                    static::mtrace('Updated course ' . $fullname, 4);
                }
                return $course;
            } else {
                // Course was deleted, remove object record and recreate.
                $DB->delete_records('local_o365_objects', ['id' => $objectrec->id]);
                $objectrec = null;
            }
        }

        // Create new course and object record.
        $fullname = core_text::substr($fullname, 0, 254);
        // Course full name max length is 254, while class display name can be 256.
        $data = [
            'category' => $categoryid,
            'shortname' => $shortname,
            'fullname' => $fullname,
            'idnumber' => $classobjectid,
        ];

        // Add dates if provided.
        if ($startdate > 0) {
            $data['startdate'] = $startdate;
        }
        if ($enddate > 0) {
            $data['enddate'] = $enddate;
        }

        // Check if a course with this shortname already exists (e.g. object record was deleted but course was not).
        $existingcourse = $DB->get_record('course', ['shortname' => $shortname]);
        if (!empty($existingcourse)) {
            static::mtrace('Found existing course with shortname ' . $shortname . ', re-linking object record.', 4);
            if ($categoryid > 0 && $existingcourse->category != $categoryid) {
                $existingcourse->category = $categoryid;
                update_course($existingcourse);
                static::mtrace('Moved re-linked course ' . $fullname . ' to category ' . $categoryid, 4);
            }
            $now = time();
            $objectrec = ['type' => 'sdssection', 'subtype' => 'course', 'objectid' => $classobjectid,
                'moodleid' => $existingcourse->id, 'o365name' => $shortname, 'tenant' => '',
                'timecreated' => $now, 'timemodified' => $now];
            $DB->insert_record('local_o365_objects', $objectrec);
            return $existingcourse;
        }

        $course = create_course((object) $data);
        static::mtrace('Created course ' . $fullname . ' with dates', 4);

        $now = time();
        $objectrec = ['type' => 'sdssection', 'subtype' => 'course', 'objectid' => $classobjectid, 'moodleid' => $course->id,
            'o365name' => $shortname, 'tenant' => '', 'timecreated' => $now, 'timemodified' => $now];
        $DB->insert_record('local_o365_objects', $objectrec);

        return $course;
    }

    /**
     * Get or create the course category for a school.
     *
     * @param string $schoolobjectid The Microsoft 365 object ID of the school.
     * @param string $schoolname The name of the school.
     * @return core_course_category A course category object for the retrieved or created course category.
     */
    public static function get_or_create_school_coursecategory(string $schoolobjectid, string $schoolname): core_course_category {
        global $DB;

        // Look for existing category.
        $params = ['type' => 'sdsschool', 'subtype' => 'coursecat', 'objectid' => $schoolobjectid];
        $existingobject = $DB->get_record('local_o365_objects', $params);
        if (!empty($existingobject)) {
            $coursecat = core_course_category::get($existingobject->moodleid, IGNORE_MISSING, true);
            if (!empty($coursecat)) {
                return $coursecat;
            } else {
                // Course category was deleted, remove object record and recreate.
                $DB->delete_records('local_o365_objects', ['id' => $existingobject->id]);
                $existingobject = null;
            }
        }

        // Create new course category and object record.
        $data = ['visible' => 1, 'name' => $schoolname, 'idnumber' => $schoolobjectid];
        if (core_text::strlen($data['name']) > 255) {
            static::mtrace('School name was over 255 chars when creating course category, truncating to 255.');
            $data['name'] = core_text::substr($data['name'], 0, 255);
        }

        // Check if a category with this idnumber already exists (e.g. object record was deleted but category was not).
        $existingcatid = $DB->get_field('course_categories', 'id', ['idnumber' => $schoolobjectid]);
        if (!empty($existingcatid)) {
            $coursecat = core_course_category::get($existingcatid, IGNORE_MISSING, true);
            if (!empty($coursecat)) {
                static::mtrace('Found existing course category with idnumber ' . $schoolobjectid . ', re-linking object record.');
                $now = time();
                $objectrec = ['type' => 'sdsschool', 'subtype' => 'coursecat', 'objectid' => $schoolobjectid,
                    'moodleid' => $coursecat->id, 'o365name' => $schoolname, 'tenant' => '',
                    'timecreated' => $now, 'timemodified' => $now];
                $DB->insert_record('local_o365_objects', $objectrec);
                return $coursecat;
            }
        }

        $coursecat = core_course_category::create($data);

        $now = time();
        $objectrec = ['type' => 'sdsschool', 'subtype' => 'coursecat', 'objectid' => $schoolobjectid, 'moodleid' => $coursecat->id,
            'o365name' => $schoolname, 'tenant' => '', 'timecreated' => $now, 'timemodified' => $now];
        $DB->insert_record('local_o365_objects', $objectrec);

        return $coursecat;
    }

    /**
     * Get or create a course category for a subject within a school.
     *
     * The subject name must already be normalized (trimmed, collapsed whitespace) by the caller.
     * A stable mapping is persisted in local_o365_objects so subsequent syncs use the authoritative
     * record rather than a fragile name-based lookup.
     *
     * @param string $subjectname The normalized name of the subject.
     * @param int $parentcategoryid The ID of the parent category (usually school category).
     * @return core_course_category A course category object for the retrieved or created course category.
     */
    public static function get_or_create_subject_coursecategory(string $subjectname, int $parentcategoryid): core_course_category {
        global $DB;

        // Build a synthetic stable key from the normalized name and parent category.
        // This is stored in local_o365_objects as the authoritative mapping so that
        // minor name variations across sync runs do not produce duplicate categories.
        $subjectkey = 'subject:' . $parentcategoryid . ':' . $subjectname;

        // Primary lookup via local_o365_objects mapping.
        $objectrec = $DB->get_record(
            'local_o365_objects',
            ['type' => 'sdssubject', 'subtype' => 'coursecat', 'objectid' => $subjectkey]
        );
        if (!empty($objectrec)) {
            $coursecat = core_course_category::get($objectrec->moodleid, IGNORE_MISSING, true);
            if (!empty($coursecat)) {
                return $coursecat;
            }
            // Category was deleted externally; remove stale mapping and recreate.
            $DB->delete_records('local_o365_objects', ['id' => $objectrec->id]);
        }

        // Fallback: look up by name and parent for categories created before the mapping existed.
        // ORDER BY id LIMIT 1 for deterministic selection when duplicates exist.
        $existingcat = $DB->get_record_sql(
            'SELECT * FROM {course_categories} WHERE name = :name AND parent = :parent ORDER BY id LIMIT 1',
            ['name' => $subjectname, 'parent' => $parentcategoryid]
        );
        if (!empty($existingcat)) {
            // Backfill the mapping so future syncs use the authoritative path.
            $now = time();
            $DB->insert_record('local_o365_objects', [
                'type' => 'sdssubject',
                'subtype' => 'coursecat',
                'objectid' => $subjectkey,
                'moodleid' => $existingcat->id,
                'o365name' => $subjectname,
                'tenant' => '',
                'timecreated' => $now,
                'timemodified' => $now,
            ]);
            return core_course_category::get($existingcat->id);
        }

        // Create new course category.
        $displayname = $subjectname;
        if (core_text::strlen($displayname) > 255) {
            static::mtrace('Subject name was over 255 chars when creating course category, truncating to 255.', 4);
            $displayname = core_text::substr($displayname, 0, 255);
        }
        $coursecat = core_course_category::create(['visible' => 1, 'name' => $displayname, 'parent' => $parentcategoryid]);
        static::mtrace('Created subject category: ' . $subjectname, 4);

        // Persist the mapping for future syncs.
        $now = time();
        $DB->insert_record('local_o365_objects', [
            'type' => 'sdssubject',
            'subtype' => 'coursecat',
            'objectid' => $subjectkey,
            'moodleid' => $coursecat->id,
            'o365name' => $subjectname,
            'tenant' => '',
            'timecreated' => $now,
            'timemodified' => $now,
        ]);

        return $coursecat;
    }

    /**
     * Get or create a cohort for a SDS class.
     *
     * @param string $classobjectid The object ID of the class.
     * @param string $shortname The shortname for the cohort.
     * @param string $fullname The full name for the cohort.
     * @param int $categoryid The ID of the category (for context).
     * @return object The cohort object.
     */
    public static function get_or_create_class_cohort(
        string $classobjectid,
        string $shortname,
        string $fullname,
        int $categoryid
    ): object {
        global $DB, $CFG;

        require_once($CFG->dirroot . '/cohort/lib.php');

        // Look for existing cohort via local_o365_objects mapping first — this is the
        // authoritative source and avoids dml_multiple_records_exception that would occur
        // if duplicate idnumbers exist (cohort idnumber is not unique in Moodle).
        $objectrec = $DB->get_record(
            'local_o365_objects',
            ['type' => 'sdssection', 'subtype' => 'cohort', 'objectid' => $classobjectid]
        );
        if (!empty($objectrec)) {
            $cohort = $DB->get_record('cohort', ['id' => $objectrec->moodleid]);
            if (!empty($cohort)) {
                static::mtrace('Found existing cohort for ' . $fullname, 4);
                return $cohort;
            }
            // Cohort was deleted; remove the stale mapping and recreate below.
            $DB->delete_records('local_o365_objects', ['id' => $objectrec->id]);
        }

        // Fall back to idnumber lookup for cohorts created before the mapping existed.
        // ORDER BY id LIMIT 1 gives deterministic selection when duplicate idnumbers exist.
        $cohort = $DB->get_record_sql(
            'SELECT * FROM {cohort} WHERE idnumber = :idnumber ORDER BY id LIMIT 1',
            ['idnumber' => $classobjectid]
        );

        if (!empty($cohort)) {
            static::mtrace('Found existing cohort for ' . $fullname . ' via idnumber fallback; creating mapping', 4);
            // Backfill the mapping so future syncs use the authoritative local_o365_objects path.
            $now = time();
            $DB->insert_record('local_o365_objects', [
                'type' => 'sdssection',
                'subtype' => 'cohort',
                'objectid' => $classobjectid,
                'moodleid' => $cohort->id,
                'o365name' => $shortname,
                'tenant' => '',
                'timecreated' => $now,
                'timemodified' => $now,
            ]);
            return $cohort;
        }

        // Create new cohort.
        $catcontext = \context_coursecat::instance($categoryid);
        $cohortdata = [
            'idnumber' => $classobjectid,
            'name' => core_text::substr($fullname, 0, 254), // Cohort name max length is 254.
            'contextid' => $catcontext->id,
            'description' => 'Cohort synced from SDS class',
            'descriptionformat' => FORMAT_HTML,
        ];

        $cohortid = cohort_add_cohort((object) $cohortdata);
        $cohort = $DB->get_record('cohort', ['id' => $cohortid]);
        static::mtrace('Created cohort for ' . $fullname, 4);

        // Track this cohort in local_o365_objects.
        $now = time();
        $objectrec = [
            'type' => 'sdssection',
            'subtype' => 'cohort',
            'objectid' => $classobjectid,
            'moodleid' => $cohort->id,
            'o365name' => $shortname,
            'tenant' => '',
            'timecreated' => $now,
            'timemodified' => $now,
        ];
        $DB->insert_record('local_o365_objects', $objectrec);

        return $cohort;
    }

    /**
     * Sync cohort membership from SDS class members.
     *
     * @param object $cohort The cohort object.
     * @param array $classmembers Array of class members from Microsoft Graph API.
     * @param bool $includeteachers Whether to include teachers in the cohort.
     * @return void
     */
    public static function sync_cohort_members(object $cohort, array $classmembers, bool $includeteachers): void {
        global $DB, $CFG;

        require_once($CFG->dirroot . '/cohort/lib.php');

        // Fetch current cohort member user IDs keyed by userid for O(1) membership tests.
        // get_records() keys by the table's id column, not userid, so use get_records_sql
        // with userid as the first selected column to get a [userid => record] map.
        $currentmemberids = $DB->get_records_sql(
            'SELECT userid FROM {cohort_members} WHERE cohortid = :cohortid',
            ['cohortid' => $cohort->id]
        );

        $newmemberids = [];

        // Bulk-fetch Moodle user IDs for all class members in a single query.
        $classobjectids = array_column($classmembers, 'id');
        $userobjectmap = [];
        if (!empty($classobjectids)) {
            [$insql, $inparams] = $DB->get_in_or_equal($classobjectids, SQL_PARAMS_NAMED);
            $inparams['usertype'] = 'user';
            $userobjectmap = $DB->get_records_sql(
                'SELECT objectid, moodleid FROM {local_o365_objects} WHERE type = :usertype AND objectid ' . $insql,
                $inparams
            );
        }

        // Process each class member using the pre-fetched map.
        foreach ($classmembers as $classmember) {
            if (!isset($userobjectmap[$classmember['id']])) {
                continue;
            }

            // Check if this is a teacher.
            $isteacher = false;
            if (isset($classmember['@odata.type'])) {
                $isteacher = (stripos($classmember['@odata.type'], 'teacher') !== false);
            }

            // Skip teachers if configured.
            if ($isteacher && !$includeteachers) {
                continue;
            }

            $moodleid = $userobjectmap[$classmember['id']]->moodleid;
            $newmemberids[] = $moodleid;

            // Add to cohort if not already a member.
            if (!isset($currentmemberids[$moodleid])) {
                static::mtrace('Adding user ' . $moodleid . ' to cohort ' . $cohort->id, 5);
                cohort_add_member($cohort->id, $moodleid);
            }
        }

        // Remove members who are no longer in the SDS class.
        // $currentmemberids is keyed by userid; diff against the new userid set.
        $memberstoremove = array_diff_key($currentmemberids, array_flip($newmemberids));
        foreach (array_keys($memberstoremove) as $userid) {
            static::mtrace('Removing user ' . $userid . ' from cohort ' . $cohort->id, 5);
            cohort_remove_member($cohort->id, $userid);
        }
    }

    /**
     * Do the job.
     *
     * @return bool
     */
    public function execute(): bool {
        if (utils::is_connected() !== true) {
            static::mtrace('local_o365 reported unconfigured during SDS sync task, so exiting.');
            return false;
        }

        $apiclient = \local_o365\feature\sds\utils::get_apiclient();
        if (!empty($apiclient)) {
            return static::runsync($apiclient);
        } else {
            static::mtrace('Could not construct API client for SDS task, so exiting.');
            return false;
        }
    }

    /**
     * Clean up SDS sync records.
     * This will delete records of synced schools and sections when they are disabled.
     *
     * @return void
     */
    public static function clean_up_sds_sync_records() {
        global $DB;

        static::mtrace('Running course sync cleanup', 1);

        // Get existing synced records.
        // Use recordset instead of get_records to reduce memory usage.
        $syncedsdsschoolsrecordset = $DB->get_recordset('local_o365_objects', ['type' => 'sdsschool']);
        $syncedsdsschools = [];
        foreach ($syncedsdsschoolsrecordset as $school) {
            $syncedsdsschools[$school->id] = $school;
        }

        $syncedsdsschoolsrecordset->close();

        $syncedsdssectionsrecordset = $DB->get_recordset('local_o365_objects', ['type' => 'sdssection']);
        $syncedsdssections = [];
        foreach ($syncedsdssectionsrecordset as $section) {
            $syncedsdssections[$section->id] = $section;
        }

        $syncedsdssectionsrecordset->close();

        // Clean up schools.
        $enabledschools = get_config('local_o365', 'sdsschools');
        if ($enabledschools) {
            $enabledschools = explode(',', $enabledschools);
        } else {
            $enabledschools = [];
        }

        foreach ($syncedsdsschools as $syncedsdsschool) {
            if (!in_array($syncedsdsschool->objectid, $enabledschools)) {
                static::mtrace('Deleting SDS sync record for school ' . $syncedsdsschool->o365name . ' (' .
                    $syncedsdsschool->objectid . ')', 2);
                $DB->delete_records('local_o365_objects', ['id' => $syncedsdsschool->id]);
            }
        }

        // Clean up school sections.
        $sectionsinenabledschools = [];
        $sectionsinenabledschoolids = [];
        $apiclient = \local_o365\feature\sds\utils::get_apiclient();
        if (!$apiclient) {
            return;
        }

        foreach ($enabledschools as $schoolobjectid) {
            try {
                $schoolclasses = $apiclient->get_school_classes($schoolobjectid);
                $sectionsinenabledschools = array_merge($sectionsinenabledschools, $schoolclasses);
            } catch (moodle_exception $e) {
                // Do nothing.
                static::mtrace('Error getting school classes. Details: ' . $e->getMessage(), 2);
            }
        }

        foreach ($sectionsinenabledschools as $sectionsinenabledschool) {
            $sectionsinenabledschoolids[] = $sectionsinenabledschool['id'];
        }

        $sdsschoolsyncdisabledaction = get_config('local_o365', 'sdsschooldisabledaction');
        if (!$sdsschoolsyncdisabledaction) {
            $sdsschoolsyncdisabledaction = SDS_SCHOOL_DISABLED_ACTION_KEEP_CONNECTED;
        }

        foreach ($syncedsdssections as $syncedsdssection) {
            if (!in_array($syncedsdssection->objectid, $sectionsinenabledschoolids)) {
                static::mtrace('Deleting SDS sync record for school section ' . $syncedsdssection->o365name . ' (' .
                    $syncedsdssection->objectid . ')', 2);
                $DB->delete_records('local_o365_objects', ['id' => $syncedsdssection->id]);
                if ($sdsschoolsyncdisabledaction == SDS_SCHOOL_DISABLED_ACTION_DISCONNECT) {
                    static::mtrace('Deleting course sync record for school section ' . $syncedsdssection->o365name .
                        ' (' . $syncedsdssection->objectid . ')', 2);
                    $DB->delete_records('local_o365_objects', ['moodleid' => $syncedsdssection->moodleid, 'type' => 'group']);
                }
            }
        }
    }
}
