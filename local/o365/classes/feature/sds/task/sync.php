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

        require_once($CFG->dirroot.'/lib/accesslib.php');
        require_once($CFG->dirroot.'/lib/enrollib.php');

        $schools = get_config('local_o365', 'sdsschools');
        $profilesyncenabled = get_config('local_o365', 'sdsprofilesyncenabled');
        $fieldmap = get_config('local_o365', 'sdsfieldmap');
        $fieldmap = (!empty($fieldmap)) ? @unserialize($fieldmap) : [];
        if (empty($fieldmap) || !is_array($fieldmap)) {
            $fieldmap = [];
        }
        if (empty($fieldmap)) {
            $profilesyncenabled = false;
        }
        $enrolenabled = get_config('local_o365', 'sdsenrolmentenabled');

        // Get role records.
        $studentrole = $DB->get_record('role', ['shortname' => 'student']);
        if (empty($studentrole)) {
            throw new \Exception('Could not find the student role.');
        }
        $teacherrole = $DB->get_record('role', ['shortname' => 'manager']);
        if (empty($teacherrole)) {
            throw new \Exception('Could not find the teacher role');
        }

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
            $coursecat = static::get_or_create_school_coursecategory($schooldata['objectId'], $schooldata['displayName']);
            static::mtrace('... Processing '.$schooldata['displayName']);
            $schoolnumber = $schooldata[$apiclient::PREFIX.'_SyncSource_SchoolId'];
            $sections = $apiclient->get_school_sections($schoolnumber);
            foreach ($sections['value'] as $section) {
                static::mtrace('...... Processing '.$section['displayName']);
                // Create the course.
                $fullname = $section[$apiclient::PREFIX.'_CourseName'];
                $fullname .= ' '.$section[$apiclient::PREFIX.'_SectionNumber'];
                $course = static::get_or_create_section_course($section['objectId'], $section['displayName'], $fullname, $coursecat->id);
                $coursecontext = \context_course::instance($course->id);

                // Associate the section group with the course.
                $groupobjectparams = [
                    'type' => 'group',
                    'subtype' => 'course',
                    'objectid' => $section['objectId'],
                    'moodleid' => $course->id,
                ];
                $groupobjectrec = $DB->get_record('local_o365_objects', $groupobjectparams);
                if (empty($groupobjectrec)) {
                    $now = time();
                    $groupobjectrec = $groupobjectparams;
                    $groupobjectrec['o365name'] = $section['displayName'];
                    $groupobjectrec['timecreated'] = $now;
                    $groupobjectrec['timemodified'] = $now;
                    $groupobjectrec['id'] = $DB->insert_record('local_o365_objects', (object)$groupobjectrec);
                }

                // Sync membership.
                if (!empty($enrolenabled) || !empty($profilesyncenabled)) {
                    $members = $apiclient->get_section_members($section['objectId']);
                    foreach ($members['value'] as $member) {
                        $objectrec = $DB->get_record('local_o365_objects', ['type' => 'user', 'objectid' => $member['objectId']]);
                        if (!empty($objectrec)) {
                            if (!empty($enrolenabled)) {
                                $role = null;
                                $type = $member[$apiclient::PREFIX.'_ObjectType'];
                                switch ($type) {
                                    case 'Student':
                                        $role = $studentrole;
                                        break;
                                    case 'Teacher':
                                        $role = $teacherrole;
                                        break;
                                }

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
                                $ra = $DB->get_record('role_assignments', $roleparams, 'id');
                                if (empty($ra)) {
                                    static::mtrace('......... Assigning role for user '.$objectrec->moodleid.' in course '.$course->id);
                                    role_assign($role->id, $objectrec->moodleid, $coursecontext->id);
                                    static::mtrace('......... Enrolling user '.$objectrec->moodleid.' into course '.$course->id);
                                    enrol_try_internal_enrol($course->id, $objectrec->moodleid);
                                }
                            }
                        }
                    }
                }
            }

            if (!empty($profilesyncenabled)) {
                static::mtrace('...... Running profile sync');
                $skiptoken = get_config('local_o365', 'sdsprofilesync_skiptoken');
                $students = $apiclient->get_school_users($schooldata['objectId'], $skiptoken);
                foreach ($students['value'] as $student) {
                    $objectrec = $DB->get_record('local_o365_objects', ['type' => 'user', 'objectid' => $student['objectId']]);
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
     * Retrieve or create a course for a section.
     *
     * @param string $sectionobjectid The object ID of the section.
     * @param string $sectionshortname The shortname of the section.
     * @param string $sectionfullname The fullname of the section.
     * @param int $categoryid The ID of the category to create the course in (if necessary).
     * @return object The course object.
     */
    public static function get_or_create_section_course($sectionobjectid, $sectionshortname, $sectionfullname, $categoryid = 0) {
        global $DB, $CFG;
        require_once($CFG->dirroot.'/course/lib.php');

        // Look for existing category.
        $params = ['type' => 'sdssection', 'subtype' => 'course', 'objectid' => $sectionobjectid];
        $objectrec = $DB->get_record('local_o365_objects', $params);
        if (!empty($objectrec)) {
            $course = $DB->get_record('course', ['id' => $objectrec->moodleid]);
            if (!empty($course)) {
                return $course;
            } else {
                // Course was deleted, remove object record and recreate.
                $DB->delete_records('local_o365_objects', ['id' => $objectrec->id]);
                $objectrec = null;
            }
        }

        // Create new course category and object record.
        $data = [
            'category' => $categoryid,
            'shortname' => $sectionshortname,
            'fullname' => $sectionfullname,
            'idnumber' => $sectionobjectid,
        ];
        $course = create_course((object)$data);

        $now = time();
        $objectrec = [
            'type' => 'sdssection',
            'subtype' => 'course',
            'objectid' => $sectionobjectid,
            'moodleid' => $course->id,
            'o365name' => $sectionshortname,
            'tenant' => '',
            'timecreated' => $now,
            'timemodified' => $now,
        ];
        $DB->insert_record('local_o365_objects', $objectrec);
        return $course;
    }

    /**
     * Get or create the course category for a school.
     *
     * @param string $schoolobjectid The Microsoft 365 object ID of the school.
     * @param string $schoolname The name of the school.
     * @return \coursecat A coursecat object for the retrieved or created course category.
     */
    public static function get_or_create_school_coursecategory($schoolobjectid, $schoolname) {
        global $DB, $CFG;

        // Look for existing category.
        $params = ['type' => 'sdsschool', 'subtype' => 'coursecat', 'objectid' => $schoolobjectid];
        $existingobject = $DB->get_record('local_o365_objects', $params);
        if (!empty($existingobject)) {
            $coursecat = \core_course_category::get($existingobject->moodleid, IGNORE_MISSING, true);
            if (!empty($coursecat)) {
                return $coursecat;
            } else {
                // Course category was deleted, remove object record and recreate.
                $DB->delete_records('local_o365_objects', ['id' => $existingobject->id]);
                $existingobject = null;
            }
        }

        // Create new course category and object record.
        $data = [
            'visible' => 1,
            'name' => $schoolname,
            'idnumber' => $schoolobjectid,

        ];
        if (strlen($data['name']) > 255) {
            static::mtrace('School name was over 255 chrs when creating course category, truncating to 255.');
            $data['name'] = substr($data['name'], 0, 255);
        }

        $coursecat = \core_course_category::create($data);

        $now = time();
        $objectrec = [
            'type' => 'sdsschool',
            'subtype' => 'coursecat',
            'objectid' => $schoolobjectid,
            'moodleid' => $coursecat->id,
            'o365name' => $schoolname,
            'tenant' => '',
            'timecreated' => $now,
            'timemodified' => $now,
        ];
        $DB->insert_record('local_o365_objects', $objectrec);
        return $coursecat;
    }

    /**
     * Get the SDS api client.
     *
     * @return \local_o365\rest\sds The SDS API client.
     */
    public static function get_apiclient() {
        $httpclient = new \local_o365\httpclient();
        $tokenresource = \local_o365\rest\sds::get_tokenresource();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        if (!empty($clientdata)) {
            $token = \local_o365\oauth2\systemapiusertoken::instance(null, $tokenresource, $clientdata, $httpclient);
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
