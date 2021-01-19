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

namespace local_o365\feature\sds\task;

/**
 * Scheduled task to run school data sync sync.
 */
class sync extends \core\task\scheduled_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_sds_sync', 'local_o365');
    }

    /**
     * Run the sync process
     *
     * @param \local_o365\rest\sds $apiclient The SDS apiclient.
     */
    public static function runsync($apiclient) {
        global $DB, $CFG;

        //get sds configuration
        $sdsdeletecourses = get_config('local_o365', 'sdsdeletecourses');
        $sdsdeletecohorts = get_config('local_o365', 'sdsdeletecohorts');
        $sdstwowaysync = get_config('local_o365', 'sdstwowaysync');
        $sdsignorepastdate = get_config('local_o365', 'sdsignorepastdate');
        $sdscategorize = get_config('local_o365', 'sdscategorize');
        $sdscreatecourses = get_config('local_o365', 'sdscreatecourses');
        $sdscreatecohorts = get_config('local_o365', 'sdscreatecohorts');
        $cohortincludeteacher = get_config('local_o365', 'sdscohortincludeteacher');
        $sdsenrolementenabled = get_config('local_o365', 'sdsenrolmentenabled');
        $profilesyncenabled = get_config('local_o365', 'sdsprofilesyncenabled');
        $sdsonlycurrent = get_config('local_o365', 'sdsonlycurrent');
        $deletetwowaysync = get_config('local_o365', 'sdsdeletetwowaysync');

        //deletion tasks - this needs to be moved under maintenance activites at some point and should be an archive process
        if ($sdsdeletecourses) {
            static::remove_all_SDS_courses();
            return; //do not continue when delete courses is chosen
        }
        if ($sdsdeletecohorts) {
            static::remove_all_SDS_cohorts();
            return; //do not continue when delete cohorts is chosen
        }
        //this is very simple delete operation for any two way syncs established.
        if ($deletetwowaysync) {
            static::remove_all_twowaysyncing();
            return;
        } // continue
    
        //get which schools have been selected 
        $schools = get_config('local_o365', 'sdsschools'); 

        //Create a field map for the Profile Sync (havent tested this well yet???)
        $fieldmap = get_config('local_o365', 'sdsfieldmap');
        $fieldmap = (!empty($fieldmap)) ? @unserialize($fieldmap) : [];
        if (empty($fieldmap) || !is_array($fieldmap)) {
            $fieldmap = [];
        }
        if (empty($fieldmap)) {
            $profilesyncenabled = false;
        }

        // Get role records for Course Create function. Neededto do this outside of the Course Create Function to avoid unnecessary calls to the database..
        $studentrole = $DB->get_record('role', ['shortname' => 'student']);
        if (empty($studentrole)) {
            throw new \Exception('Could not find the student role.');
        }
        $teacherrole = $DB->get_record('role', ['shortname' => 'editingteacher']);
        if (empty($teacherrole)) {
            throw new \Exception('Could not find the teacher role');
        }

        //For each school selected..
        $schools = explode(',', $schools);
        foreach ($schools as $school) {
            $school = trim($school);
            if (empty($school)) {
                continue;
            }
            try {
                $schooldata = $apiclient->get_school($school);
            } catch (\Exception $e) {
                static::mtrace('... Skipped SDS school '.$school.' because we received an error from the API');
                continue;
            }

            //Get or Create School Course Category
            $schoolcat = static::get_or_create_category($schooldata['displayName']);
            $schoolnumber = $schooldata[$apiclient::PREFIX.'_SyncSource_SchoolId'];
            
            //Get Classes from Office 365
            $sections = $apiclient->get_school_sections($schoolnumber);
            if (empty($sections)) {
                static::mtrace('...No sections (Office 365 groups) found.');
                continue; 
            }

            // Get role records. Doing here, so not repeated for each course
            $studentrole = $DB->get_record('role', ['shortname' => 'student']);
            if (empty($studentrole)) {
                throw new \Exception('Could not find the student role.');
            }
            $teacherrole = $DB->get_record('role', ['shortname' => 'editingteacher']);
            if (empty($teacherrole)) {
                throw new \Exception('Could not find the teacher role');
            }
            
            //for each class office 365 group in Azure AD
            foreach ($sections['value'] as $section) {
                static::mtrace('...... Processing '.$section['displayName'].' with Office 365 Group ID: '.$section['id']);

                $subjectname = $section[$apiclient::PREFIX.'_CourseSubject'];
                $subjectcode = $section[$apiclient::PREFIX.'_CourseNumber']; //not sure this is the subject code
                $classofficegroupid = $section['id'];
                $classname = $section['displayName']; //Not sure where it should be displayName
                $classname .= " ".$section[$apiclient::PREFIX.'_TermName'];
                $classcode = $section[$apiclient::PREFIX.'_SectionNumber'];
                $classcode .= " ".$section[$apiclient::PREFIX.'_TermName'];
                $classstartdate = strtotime($section[$apiclient::PREFIX.'_TermStartDate']);
                $classenddate = strtotime($section[$apiclient::PREFIX.'_TermEndDate']);

                //Limit to only current courses
                if ($sdsonlycurrent) {
                    if  (substr($classname, 0, 3 ) === "Exp"){
                        static::mtrace('......... Skipping enrolments because of Expiry');
                        continue;
                    }
                    $now = time();
                    if (!empty($classenddate)) {
                        if ($classenddate < $now) {
                            static::mtrace('......... Skipping enrolments for course because of past end date');
                            continue;
                        }
                    }
                }

                //Get or create a course category else current course category is School name
                $coursecat = $schoolcat;
                if ($sdscategorize) {
                    $coursecat = static::get_or_create_category($subjectname, $schoolcat->id);
                }

                //Get class members
                $members = $apiclient->get_section_members($classofficegroupid);

                //Get or create a class Cohort
                if ($sdscreatecohorts) {
                    $cohort = static::get_or_create_class_cohort($classofficegroupid, $classcode, $classname, $coursecat->id);
                    if (!empty($members)) {
                        static::enrol_members_in_cohort($cohort, $members, $apiclient, $cohortincludeteacher);
                    }
                }

                //Get or create a class Course
                if ($sdscreatecourses) {
                    $course = static::get_or_create_class_course($classofficegroupid, $classcode, $classname, $classstartdate, $classenddate, $coursecat->id, $sdstwowaysync);
                    if (!empty($members) && $sdsenrolementenabled)
                    {
                        static::enrol_members_in_course($course, $members, $apiclient, $teacherrole, $studentrole);
                    }
                }
            } //completed all classes...

            //Sync each student's profile, not sure this works - old code
            if (!empty($profilesyncenabled)) {
                static::mtrace('...... Running profile sync');
                $skiptoken = get_config('local_o365', 'sdsprofilesync_skiptoken');
                $students = $apiclient->get_school_users($schoolnumber, $skiptoken);
                foreach ($students['value'] as $student) {
                    $objectrec = $DB->get_record('local_o365_objects', ['type' => 'user', 'objectid' => $student['id']]);
                    if (!empty($objectrec)) {
                        $muser = $DB->get_record('user', ['id' => $objectrec->moodleid]);
                        static::update_profiledata($muser, $student, $fieldmap);
                    }
                }
                set_config('sdsprofilesync_skiptoken', '', 'local_o365');
                if (!empty($students['odata.nextLink'])) {
                    // Extract skiptoken.
                    $nextlink = parse_url($students['odata.nextLink']);
                    if (isset($nextlink['query'])) {
                        $query = [];
                        parse_str($nextlink['query'], $query);
                        if (isset($query['$skiptoken'])) {
                            static::mtrace('...... Skip token saved for next run');
                            set_config('sdsprofilesync_skiptoken', $query['$skiptoken'], 'local_o365');
                        }
                    }
                } else {
                    static::mtrace('...... Full run complete.');
                }
            }
        }
    }

    /**
     * Run mtrace if not in a unit test.
     *
     * @param string $str The trace string.
     */
    public static function mtrace($str) {
        if (!PHPUNIT_TEST) {
            mtrace($str);
        }
    }

    /**
     * Update a user's information based on configured field map.
     *
     * @param object $muser The Moodle user record.
     * @param array $sdsdata Incoming data from SDS.
     * @param array $fieldmaps Array of configured field maps.
     * @return bool Success/Failure.
     */
    public static function update_profiledata($muser, $sdsdata, $fieldmaps) {
        global $DB, $CFG;
        require_once($CFG->dirroot.'/user/profile/lib.php');

        static::mtrace("......... Updating user {$muser->id}");
        foreach ($fieldmaps as $fieldmap) {
            $fieldmap = explode('/', $fieldmap);
            list($remotefield, $localfield) = $fieldmap;
            if (strpos($remotefield, 'pre_') === 0) {
                $remotefield = \local_o365\rest\sds::PREFIX.'_'.substr($remotefield, 4);
            }
            if (!isset($sdsdata[$remotefield])) {
                $debugmsg = "SDS: no remotefield: {$remotefield} for user {$muser->id}";
                $caller = 'update_profiledata';
                \local_o365\utils::debug($debugmsg, $caller);
                continue;
            }

            $newdata = $sdsdata[$remotefield];

            if ($localfield === 'country') {
                // Update country with two letter country code.
                $newdata = strtoupper($newdata);
                $countrymap = get_string_manager()->get_list_of_countries();
                if (isset($countrymap[$newdata])) {
                    $countrycode = $incoming;
                } else {
                    $muser->$localfield = '';
                    foreach ($countrymap as $code => $name) {
                        if (strtoupper($name) === $newdata) {
                            $muser->$localfield = $code;
                            break;
                        }
                    }
                }
            } else if ($localfield === 'lang') {
                $muser->$localfield = (strlen($newdata) > 2) ? substr($newdata, 0, 2) : $newdata;
            } else {
                $muser->$localfield = $newdata;
            }
        }
        $DB->update_record('user', $muser);
        profile_save_data($muser);
        return true;
    }

    /**
     * Remove all SDS courses - probably should be changed to an archive at some point
     * Clears all SDS entries from the database
     * Clears all Course Syncing related to SDS
    */
    public static function remove_all_SDS_courses()
    {
        global $DB, $CFG;
        require_once($CFG->dirroot.'/course/lib.php');
        static::mtrace('...Remove all SDS courses and deleting the syncing entries ');
        //Check that SDS tracking is correct, e.g. moodle id = courseid
        $params = ['type' => 'sdssection', 'subtype' => 'course'];
        //get all sds records
        $sdsrecords = $DB->get_records('local_o365_objects', $params);
        if (empty($sdsrecords)) { 
            return;
        }
        foreach ($sdsrecords as $sdsrecord) {
            $courseid = $sdsrecord->moodleid;
            $params['moodleid'] = $courseid;
            $params['type'] = 'sdssection';
            $DB->delete_records('local_o365_objects',$params); //delete sds entry
            $params['type'] = 'group';
            $DB->delete_records('local_o365_objects',$params); //delete sds syncing
            delete_course($courseid); // only delete course after syncing is removed, else obervers are triggered.
            static::mtrace('...Deleting Course: '.$courseid);
        }
        return;
    }

    /**
     * Remove all SDS cohorts - probably should be changed to an archive at some point
     * Clears all SDS entries from the database
     * Clears all Course Syncing related to SDS
    */
    public static function remove_all_SDS_cohorts()
    {
        static::mtrace('...Remove all SDS cohorts ');
        global $DB, $CFG;
        require_once($CFG->dirroot.'/cohort/lib.php');
        //Check that SDS tracking is correct, e.g. moodle id = courseid
        $params = ['type' => 'sdssection', 'subtype' => 'cohort'];
        //get all sds records
        $sdsrecords = $DB->get_records('local_o365_objects', $params);

        if (empty($sdsrecords)) { 
            return;
        }
        foreach ($sdsrecords as $sdsrecord) {
            $cohortid = $sdsrecord->moodleid;
            static::mtrace('...Remove cohort: '.$cohortid);
            $params['moodleid'] = $cohortid;
            $DB->delete_records('local_o365_objects',$params); //deletes cohort entry
            $cohort = $DB->get_record('cohort', array('id'=>$cohortid));
            cohort_delete_cohort($cohort);
        }
        return;
    }

    /**
     * Clears all SDS course syncing. To resync, the Custom Course tab will need to be used
    */
    public static function remove_all_twowaysyncing()
    {
        static::mtrace('...Remove all SDS syncing ');
        global $DB, $CFG;
        $params = ['type' => 'sdssection', 'subtype' => 'course'];
        //get all sds records
        $sdsrecords = $DB->get_records('local_o365_objects', $params);
        if (empty($sdsrecords)) {
            return;
        }
        //now delete local objects sync record
        foreach ($sdsrecords as $sdsrecord) {
            $courseid = $sdsrecord->moodleid;
            $params['type'] = 'group';
            $params['subtype'] = 'course';
            $params['moodleid'] = $courseid;
            $DB->delete_records('local_o365_objects',$params);
        }

        return;
    }

    /**
     * Retrieve or create a course for a section.
     * @param string $classofficegroupid - The group ID of the class
     * @param string $classcode - The shortname of the class
     * @param string $classname The fullname of the class
     * @param int $categoryid The ID of the category to move the class to.
     * @param string $classstartdate - the start date of the class '6/30/2018'
     * @param string $classenddate - The enddate of the class '6/30/2018'
     * @return object The course object.
     */
    public static function get_or_create_class_course($classofficegroupid, $classcode, $classname, $classstartdate, $classenddate, $coursecatid, $sdstwowaysync) {
        global $DB, $CFG;
        require_once($CFG->dirroot.'/course/lib.php');
        $now = time();

        //Check that SDS tracking is correct, e.g. moodle id = courseid
        $params = ['type' => 'sdssection', 'subtype' => 'course', 'objectid' => $classofficegroupid];
        $sdsrecord = $DB->get_record('local_o365_objects', $params);

        // Look for existing Course with idnumber (officegroupid) (you can switch syncing onto another course)
        $courseparams = [];
        $courseparams['idnumber'] = $classofficegroupid;
        $course = $DB->get_record('course', $courseparams);

        if (!empty($course)) {
            static::mtrace('.........Course already exists with that ID number....');
            $params['moodleid'] = $course->id;

            //check to see category is correct, if not update
            if ($course->category != $coursecatid){
                static::mtrace('.........Updating category for course for '.$classname);
                // Create new course
                $data = [
                    'id' => $course->id,
                    'shortname' => $course->shortname,
                    'category' => $coursecatid
                ];
                $DB->update_record('course',$data);
            }

            if (!empty($sdsrecord)) //Check that the SDS record is correct
            {
                if ($sdsrecord->moodleid != $course->id) //Update record
                {
                    $params['id'] = $sdsrecord->id; //update query requires key
                    $params['timemodified'] = $now;
                    $DB->update_record('local_o365_objects',$params); //how does it know
                }
            } else { //record doesnt exist but course is found?? insert sds record
                $params['timecreated'] = $now;
                $params['timemodified'] = $now;
                $params['o365name'] = $classcode;
                $DB->insert_record('local_o365_objects',$params);
            }
            static::mtrace('.........Found Course for '.$classname);
            return $course;
        }

        // Create new course
        $data = [
            'category' => $coursecatid,
            'shortname' => $classcode,
            'fullname' => $classname,
            'idnumber' => $classofficegroupid,
            'startdate' => $classstartdate,
            'enddate' => $classenddate
        ];
        $course = create_course((object)$data);
        static::mtrace('.........Creating Course for '.$classname);

        //create SDS entry in local o365 objects
        $params['moodleid'] = $course->id;
        $params['timecreated'] = $now;
        $params['timemodified'] = $now;
        $params['o365name'] = $classcode;
        $DB->insert_record('local_o365_objects',$params);

        //if not two way syncing, finish here...
        if (!$sdstwowaysync)
        {
            return $course;
        }

        //else get or create entry in local objects for two way syncing to occur
        $groupobjectparams = [
            'type' => 'group',
            'subtype' => 'course',
            'objectid' => $classofficegroupid,
            'moodleid' => $course->id,
        ];
        $groupobjectrec = $DB->get_record('local_o365_objects', $groupobjectparams);
        if (empty($groupobjectrec)) {
            $now = time();
            $groupobjectrec = $groupobjectparams;
            $groupobjectrec['o365name'] = $classcode;
            $groupobjectrec['timecreated'] = $now;
            $groupobjectrec['timemodified'] = $now;
            $groupobjectrec['id'] = $DB->insert_record('local_o365_objects', (object)$groupobjectrec);
        } 
        return $course;
    }

    /** 
    * Retrieve or create a cohort for a section
    * @param string $classofficegroupid - The group ID of the class
    * @param string $classcode - The shortname of the class
    * @param string $classname The fullname of the class
    * @param int $categoryid The ID of the category to move the class to.
    * @return object The cohort object
    */
    public static function get_or_create_class_cohort($classofficegroupid, $classcode, $classname, $coursecat) {
        global $DB, $CFG;
        require_once($CFG->dirroot.'/cohort/lib.php');
        $now = time();

        //Check that SDS tracking is correct, e.g. moodle id = courseid
        $params = ['type' => 'sdssection', 'subtype' => 'cohort', 'objectid' => $classofficegroupid];
        $sdsrecord = $DB->get_record('local_o365_objects', $params);

        $cohortparams = [];
        $cohortparams['idnumber'] = $classofficegroupid;
        $cohort = $DB->get_record('cohort', $cohortparams);
        $catcontext = \context_coursecat::instance($coursecat);

        if (!empty($cohort)) {

            if ($cohort->contextid != $catcontext->id) //check if category is correct, else fix
            {
                static::mtrace('.........Updating category for '.$classname);
                $cohortparams['id'] = $cohort->id;
                $cohortparams['timemodified'] = $now;
                $cohortparams['contextid'] = $catcontext->id;
                $DB->update_record('cohort',$cohortparams);
            }

            $params['moodleid'] = $cohort->id;
            if (!empty($sdsrecord)) //Check that the SDS record is correct else fix
            {
                if ($sdsrecord->moodleid != $cohort->id) //Update record
                {
                    static::mtrace('.........Updating sds record for '.$classname);
                    $params['id'] = $sdsrecord->id;
                    $params['timemodified'] = $now;
                    $DB->update_record('local_o365_objects',$params);
                }
            } else { //record doesnt exist but cohort is found?? insert record
                static::mtrace('.........Inserting sds record for '.$classname);
                $params['timecreated'] = $now;
                $params['timemodified'] = $now;
                $params['o365name'] = $classcode;
                $DB->insert_record('local_o365_objects',$params);
            }
            static::mtrace('.........Found Cohort for '.$classname);
            return $cohort;
        }

        static::mtrace('.........Creating Cohort for '.$classname);
        $cohortid = cohort_add_cohort((object)array('idnumber' => $classofficegroupid,'name' => $classname, 'contextid' => $catcontext->id));
        $cohort = $DB->get_record('cohort', ['id' => $cohortid]);
        return $cohort;
    }

    /**
     * Get or create the course category
     *
     * @param string $categoryname The name of the category -> could be School or Subject Name
     * @param string $parentid - Subject Categories are placed within their School Category
     * @return \coursecat A coursecat object for the retrieved or created course category.
     */
    public static function get_or_create_category($categoryname, $parentid = 0) {
        //static::mtrace('Get or create category '.$categoryname." Parent ".$parentid);
        global $DB, $CFG;

        $params = ['name'=>$categoryname, 'parent'=>$parentid];
        $coursecat = $DB->get_record('course_categories', $params);
        if (!empty($coursecat)) {
            return $coursecat;
        } else {
            $data = [
                'visible' => 1,
                'name' => $categoryname,
                'parent' => $parentid
            ];
            if (strlen($data['name']) > 255) {
                static::mtrace('School name was over 255 chrs when creating course category, truncating to 255.');
                $data['name'] = substr($data['name'], 0, 255);
            }
            $coursecat = \core_course_category::create($data); //also creates entry in context table
        }
        return $coursecat;
    }

    /**
     * Enrol members in course. Suspend users if not found in Office 365 group
     *
     * @param string $course - Course object
     * @param string $members - Membership from the Office 365 Group
     * @return \coursecat A coursecat object for the retrieved or created course category.
     */

    public static function enrol_members_in_course($course, $members, $apiclient, $teacherrole, $studentrole)
    {
        global $DB, $CFG;
        require_once($CFG->dirroot.'/lib/accesslib.php');
        require_once($CFG->dirroot.'/lib/enrollib.php');

        $coursecontext = \context_course::instance($course->id);
        //Get Course enrolment plugin
        $enrol = enrol_get_plugin('manual');
        $instance = $DB->get_record('enrol', array('courseid' => $course->id, 'enrol' => 'manual'));

        $enrolledusers = []; //keep track of all the currently enrolled users
        $enrolledusers = get_enrolled_users($coursecontext, '', 0, 'u.id', null, 0, 0, true);

        foreach ($members['value'] as $member) {
            $objectrec = $DB->get_record('local_o365_objects', ['type' => 'user', 'objectid' => $member['id']]);

            if (!empty($objectrec)) {
                
                $role = null;
                $type = isset($member[$apiclient::PREFIX.'_ObjectType']) ? $member[$apiclient::PREFIX.'_ObjectType'] : '';
                switch ($type) {
                    case 'Student':
                        $role = $studentrole;
                        break;
                    case 'Teacher':
                        $role = $teacherrole;
                        break;
                }
                
                //dont enrol if there is no role allocated
                if (empty($role)) {
                    continue;
                }

                $roleparams = [
                    'roleid' => $role->id,
                    'contextid' => $coursecontext->id,
                    'userid' => $objectrec->moodleid,
                    'component' => '',
                    'itemid' => 0,
                ];

                //check to see if user enrolled
                $ra = $DB->get_record('role_assignments', $roleparams, 'id');
                if (empty($ra)) {
                    static::mtrace('......... Assigning role for user '.$objectrec->moodleid.' in course '.$course->id);
                    role_assign($role->id, $objectrec->moodleid, $coursecontext->id);
                    static::mtrace('......... Enrolling user '.$objectrec->moodleid.' into course '.$course->id);
                    enrol_try_internal_enrol($course->id, $objectrec->moodleid);
                }

                // We need to check if the enrolment has been suspended.
                $enrolparams = [
                    'enrolid' => $instance->id,
                    'userid' => $objectrec->moodleid
                ];
                $enrolment = $DB->get_record('user_enrolments', $enrolparams, 'id, status');

                if (empty($enrolment)) {
                    static::mtrace('......... Enrolling user '.$objectrec->moodleid.' into course '.$course->id);
                    enrol_try_internal_enrol($course->id, $objectrec->moodleid);
                } elseif ($enrolment->status == 1 && $type !== 'Teacher') {
                    static::mtrace('......... Re-enrolling user '.$objectrec->moodleid.' into course '.$course->id);
                    $enrol->update_user_enrol($instance, $objectrec->moodleid, ENROL_USER_ACTIVE);  //suspended users made active
                }

                //if user already enrolled, remove from course enrolment list to identify if any users are enrolled but should not be.
                if (isset($enrolledusers[$objectrec->moodleid])) {
                    unset($enrolledusers[$objectrec->moodleid]);
                }
                
            }
        }

        //remaining users are enrolled but not in the SDS, therefore suspend enrolment
        if (!empty($enrolledusers)) {
            foreach ($enrolledusers as $id => $user) {
                // We want to ignore teachers.
                $roleparams = [
                    'roleid' => $teacherrole->id,
                    'contextid' => $coursecontext->id,
                    'userid' => $user->id,
                    'component' => '',
                    'itemid' => 0,
                ];
                $ra = $DB->get_record('role_assignments', $roleparams, 'id');

                //COULD BE CONFIGURABLE - CHOICE BETWEEN SUSPENDING OR UNENROLLING
                //Not a teacher, so suspend the enrolment of the student
                if (empty($ra)) {
                    static::mtrace('......... Suspending enrolment for user '.$user->id.' in course '.$course->id);
                    $enrol->update_user_enrol($instance, $user->id, ENROL_USER_SUSPENDED);
                }
            }
        }
        
    }

    /**
     * Enrol members in cohort (unenrol them if user leaves group). 
     * @param string $cohort object (include cohort fields)
     * @param string $members - Membership from the Office 365 Group
     */
    public static function enrol_members_in_cohort($cohort, $members, $apiclient, $cohortincludeteacher)
    {
        global $DB, $CFG;
        require_once($CFG->dirroot.'/cohort/lib.php');

        //static::mtrace('.........Enrolling users in cohort......');
        //get current cohort members checklist to ensure correct membership
        $cohortmembers = [];
        $sql = "SELECT userid FROM {cohort_members} WHERE cohortid = ?";
        $cohortmembers = $DB->get_records_sql($sql, array($cohort->id));
        //static::mtrace('.........Cohort Membership: '.var_dump($cohortmembers));

        //for each member from o365 group
        foreach ($members['value'] as $member) {
            $objectrec = $DB->get_record('local_o365_objects', ['type' => 'user', 'objectid' => $member['id']]); //need to get userid (moodleid) from Office 365 ID
            //check to see if Teacher if so skip -- not sure what to do with teachers??
            $type = isset($member[$apiclient::PREFIX.'_ObjectType']) ? $member[$apiclient::PREFIX.'_ObjectType'] : '';
            if ($type == 'Teacher') {
                if (!$cohortincludeteacher)
                {
                    continue;
                }
                //static::mtrace('............Teacher: '.$objectrec->moodleid." is placed in cohort");
            }
            
            //user exists in office 365 Moodle
            if (!empty($objectrec)) {
                //check to see if user from Office Group, if so remove from checklist
                if (isset($cohortmembers[$objectrec->moodleid])) {
                    //static::mtrace('............User: '.$objectrec->moodleid.' already found in cohort: '.$cohort->id);
                    unset($cohortmembers[$objectrec->moodleid]);
                } else { //user does not exist in cohort, therefore add to cohort
                    static::mtrace('............Adding user: '.$objectrec->moodleid.' to cohort: '.$cohort->id);
                    cohort_add_member($cohort->id, $objectrec->moodleid);
                }
            }
        }

        //remaining users are enrolled but not in the SDS, therefore remove member from cohort
        if (!empty($cohortmembers)) {
            foreach ($cohortmembers as $user) {
                static::mtrace('............Removing user from cohort. User id: '.var_dump($user));
                cohort_remove_member($cohort->id,$user->userid);
            }
        }

    }

    /**
     * Get the SDS api client.
     *
     * @return \local_o365\rest\sds The SDS API client.
     */

    public static function get_apiclient() {
        $httpclient = new \local_o365\httpclient();
        $resource = \local_o365\rest\sds::get_resource();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        if (!empty($clientdata)) {
            $token = \local_o365\oauth2\systemapiusertoken::instance(null, $resource, $clientdata, $httpclient);
            if (!empty($token)) {
                $apiclient = new \local_o365\rest\sds($token, $httpclient);
                return $apiclient;
            } else {
                static::mtrace('Could not construct system API user token for SDS sync task.');
            }
        } else {
            static::mtrace('Could not construct client data object for SDS sync task.');
        }
        return null;
    }

    /**
     * Do the job.
     */
    public function execute() {
        global $DB, $CFG;

        if (\local_o365\utils::is_configured() !== true) {
            static::mtrace('local_o365 reported unconfigured during SDS sync task, so exiting.');
            return false;
        }

        $apiclient = static::get_apiclient();
        if (!empty($apiclient)) {
            return static::runsync($apiclient);
        } else {
            static::mtrace('Could not construct API client for SDS task, so exiting.');
            return false;
        }
    }

}
