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
 * This file contains the definition for the library class for OneNote submission plugin
 *
 * This class provides all the functionality for the new assign module.
 *
 * @package assignsubmission_onenote
 */

require_once($CFG->libdir.'/eventslib.php');
require_once($CFG->libdir.'/oauthlib.php');
require_once($CFG->dirroot.'/repository/onenote/onenote_api.php');

defined('MOODLE_INTERNAL') || die();

// File areas for OneNote submission assignment.
define('ASSIGNSUBMISSION_ONENOTE_MAXFILES', 1);
define('ASSIGNSUBMISSION_ONENOTE_MAXSUMMARYFILES', 5);
define('ASSIGNSUBMISSION_ONENOTE_FILEAREA', 'submission_onenote_files');

/**
 * Library class for OneNote submission plugin extending submission plugin base class
 *
 * @package   assignsubmission_onenote
 */
class assign_submission_onenote extends assign_submission_plugin {

    /**
     * Get the name of the onenote submission plugin
     * @return string
     */
    public function get_name() {
        return get_string('onenote', 'assignsubmission_onenote');
    }

    /**
     * Get file submission information from the database
     *
     * @param int $submissionid
     * @return mixed
     */
    private function get_file_submission($submissionid) {
        global $DB;
        return $DB->get_record('assignsubmission_onenote', array('submission'=>$submissionid));
    }

    /**
     * Get the default setting for OneNote submission plugin
     *
     * @param MoodleQuickForm $mform The form to add elements to
     * @return void
     */
    public function get_settings(MoodleQuickForm $mform) {
        global $CFG, $COURSE;

        $defaultmaxfilesubmissions = $this->get_config('maxfilesubmissions');
        $defaultmaxsubmissionsizebytes = $this->get_config('maxsubmissionsizebytes');

        $settings = array();
        $options = array();
        for ($i = 1; $i <= ASSIGNSUBMISSION_ONENOTE_MAXFILES; $i++) {
            $options[$i] = $i;
        }

        $name = get_string('maxfilessubmission', 'assignsubmission_onenote');
        $mform->addElement('select', 'assignsubmission_onenote_maxfiles', $name, $options);
        $mform->addHelpButton('assignsubmission_onenote_maxfiles',
                              'maxfilessubmission',
                              'assignsubmission_onenote');
        $mform->setDefault('assignsubmission_onenote_maxfiles', $defaultmaxfilesubmissions);
        $mform->disabledIf('assignsubmission_onenote_maxfiles', 'assignsubmission_onenote_enabled', 'notchecked');

        $choices = get_max_upload_sizes($CFG->maxbytes,
                                        $COURSE->maxbytes,
                                        get_config('assignsubmission_onenote', 'maxbytes'));

        $settings[] = array('type' => 'select',
                            'name' => 'maxsubmissionsizebytes',
                            'description' => get_string('maximumsubmissionsize', 'assignsubmission_onenote'),
                            'options'=> $choices,
                            'default'=> $defaultmaxsubmissionsizebytes);

        $name = get_string('maximumsubmissionsize', 'assignsubmission_onenote');
        $mform->addElement('select', 'assignsubmission_onenote_maxsizebytes', $name, $choices);
        $mform->addHelpButton('assignsubmission_onenote_maxsizebytes',
                              'maximumsubmissionsize',
                              'assignsubmission_onenote');
        $mform->setDefault('assignsubmission_onenote_maxsizebytes', $defaultmaxsubmissionsizebytes);
        $mform->disabledIf('assignsubmission_onenote_maxsizebytes',
                           'assignsubmission_onenote_enabled',
                           'notchecked');
    }

    /**
     * Save the settings for onenote submission plugin
     *
     * @param stdClass $data
     * @return bool
     */
    public function save_settings(stdClass $data) {
        $this->set_config('maxfilesubmissions', $data->assignsubmission_onenote_maxfiles);
        $this->set_config('maxsubmissionsizebytes', $data->assignsubmission_onenote_maxsizebytes);
        return true;
    }

    /**
     * File format options
     *
     * @return array
     */
    private function get_file_options() {
        $fileoptions = array('subdirs'=>1,
                                'maxbytes'=>$this->get_config('maxsubmissionsizebytes'),
                                'maxfiles'=>$this->get_config('maxfilesubmissions'),
                                'accepted_types'=>'*',
                                'return_types'=>FILE_INTERNAL);
        return $fileoptions;
    }

    /**
     * Add elements to submission form
     *
     * @param mixed $submission stdClass|null
     * @param MoodleQuickForm $mform
     * @param stdClass $data
     * @return bool
     */
    public function get_form_elements($submission, MoodleQuickForm $mform, stdClass $data) {
        if ($this->get_config('maxfilesubmissions') <= 0) {
            return false;
        }

        $fileoptions = $this->get_file_options();
        $submissionid = $submission ? $submission->id : 0;

        $o = '<hr/><b>OneNote actions:</b>&nbsp;&nbsp;&nbsp;&nbsp;';
        
        $onenote_token = microsoft_onenote::get_onenote_token();

        if (isset($onenote_token)) {
            $action_params['action'] = 'save';
            $cm_instance_id = optional_param('id', null, PARAM_INT);
            $action_params['id'] = $cm_instance_id;
            $action_params['token'] = $onenote_token;
            $url = new moodle_url('/blocks/onenote/onenote_actions.php', $action_params);
            
            $o .= '<a onclick="window.open(this.href,\'_blank\'); return false;" href="' . $url->out(false) . '" style="' . microsoft_onenote::get_linkbutton_style() . '">' . 'Work on the assignment in OneNote' . '</a>';
            //$o .= '<a onclick="window.open(this.href,\'_blank\'); setTimeout(function(){ location.reload(); }, 2000); return false;" href="' . $url->out(false) . '" style="' . microsoft_onenote::get_linkbutton_style() . '">' . 'Work on the assignment in OneNote' . '</a>';
            $o .= '<br/><br/><p>Click on the button above to export the assignment to OneNote and work on it there. You can come back here later on to import your work back into Moodle.</p>';
        } else {
            $o .= microsoft_onenote::get_onenote_signin_widget();
            $o .= '<br/><br/><p>Click on the button above to sign in to OneNote so you can work on the assignment there.</p>';
        }
        
        $o .= '<hr/>';
        
        $mform->addElement('html', $o);
        return true;
    }

    /**
     * Count the number of files
     *
     * @param int $submissionid
     * @param string $area
     * @return int
     */
    private function count_files($submissionid, $area) {

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->assignment->get_context()->id,
                                     'assignsubmission_onenote',
                                     $area,
                                     $submissionid,
                                     'id',
                                     false);

        return count($files);
    }

    /**
     * Save the files and trigger plagiarism plugin, if enabled,
     * to scan the uploaded files via events trigger
     *
     * @param stdClass $submission
     * @param stdClass $data
     * @return bool
     */
    public function save(stdClass $submission, stdClass $data) {
        global $USER, $DB;

        // get OneNote page id
        $record = $DB->get_record('assign_user_ext', array("assign_id" => $submission->assignment, "user_id" => $submission->userid));
        $page_id = $record->page_id;
        $temp_folder = microsoft_onenote::create_temp_folder();
        $temp_file = join(DIRECTORY_SEPARATOR, array(trim($temp_folder, DIRECTORY_SEPARATOR), uniqid('asg_'))) . '.zip';
        
        // Create zip file containing onenote page and related files
        $onenote_api = microsoft_onenote::get_onenote_api();
        $download_info = $onenote_api->download_page($page_id, $temp_file);
        
        // save it to approp area
        $fs = get_file_storage();
        
        // Prepare file record object
        $fileinfo = array(
            'contextid' => $this->assignment->get_context()->id,
            'component' => 'assignsubmission_onenote',
            'filearea' => ASSIGNSUBMISSION_ONENOTE_FILEAREA,
            'itemid' => $submission->id,
            'filepath' => '/',
            'filename' => 'OneNote_' . time() . '.zip');
        
        $fs->create_file_from_pathname($fileinfo, $download_info['path']);
        fulldelete($temp_folder);
        
        $filesubmission = $this->get_file_submission($submission->id);
        
        // Plagiarism code event trigger when files are uploaded.
        $files = $fs->get_area_files($this->assignment->get_context()->id,
                                     'assignsubmission_onenote',
                                     ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                                     $submission->id,
                                     'id',
                                     false);

        $count = $this->count_files($submission->id, ASSIGNSUBMISSION_ONENOTE_FILEAREA);

        $params = array(
            'context' => context_module::instance($this->assignment->get_course_module()->id),
            'courseid' => $this->assignment->get_course()->id,
            'objectid' => $submission->id,
            'other' => array(
                'content' => '',
                'pathnamehashes' => array_keys($files)
            )
        );
        
        if (!empty($submission->userid) && ($submission->userid != $USER->id)) {
            $params['relateduserid'] = $submission->userid;
        }
        
        $event = \assignsubmission_onenote\event\assessable_uploaded::create($params);
        $event->set_legacy_files($files);
        $event->trigger();

        $groupname = null;
        $groupid = 0;
        // Get the group name as other fields are not transcribed in the logs and this information is important.
        if (empty($submission->userid) && !empty($submission->groupid)) {
            $groupname = $DB->get_field('groups', 'name', array('id' => $submission->groupid), '*', MUST_EXIST);
            $groupid = $submission->groupid;
        } else {
            $params['relateduserid'] = $submission->userid;
        }

        // Unset the objectid and other field from params for use in submission events.
        unset($params['objectid']);
        unset($params['other']);
        $params['other'] = array(
            'submissionid' => $submission->id,
            'submissionattempt' => $submission->attemptnumber,
            'submissionstatus' => $submission->status,
            'filesubmissioncount' => $count,
            'groupid' => $groupid,
            'groupname' => $groupname
        );

        if ($filesubmission) {
            $filesubmission->numfiles = $this->count_files($submission->id,
                                                           ASSIGNSUBMISSION_ONENOTE_FILEAREA);
            $updatestatus = $DB->update_record('assignsubmission_onenote', $filesubmission);
            $params['objectid'] = $filesubmission->id;

            $event = \assignsubmission_onenote\event\submission_updated::create($params);
            $event->set_assign($this->assignment);
            $event->trigger();
            return $updatestatus;
        } else {
            $filesubmission = new stdClass();
            $filesubmission->numfiles = $this->count_files($submission->id,
                                                           ASSIGNSUBMISSION_ONENOTE_FILEAREA);
            $filesubmission->submission = $submission->id;
            $filesubmission->assignment = $this->assignment->get_instance()->id;
            $filesubmission->id = $DB->insert_record('assignsubmission_onenote', $filesubmission);
            $params['objectid'] = $filesubmission->id;

            $event = \assignsubmission_onenote\event\submission_created::create($params);
            $event->set_assign($this->assignment);
            $event->trigger();
            return $filesubmission->id > 0;
        }
    }

    /**
     * Produce a list of files suitable for export that represent this feedback or submission
     *
     * @param stdClass $submission The submission
     * @param stdClass $user The user record - unused
     * @return array - return an array of files indexed by filename
     */
    public function get_files(stdClass $submission, stdClass $user) {
        $result = array();
        $fs = get_file_storage();

        $files = $fs->get_area_files($this->assignment->get_context()->id,
                                     'assignsubmission_onenote',
                                     ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                                     $submission->id,
                                     'timemodified',
                                     false);

        foreach ($files as $file) {
            $result[$file->get_filename()] = $file;
        }
        return $result;
    }

    /**
     * Display the list of files  in the submission status table
     *
     * @param stdClass $submission
     * @param bool $showviewlink Set this to true if the list of files is long
     * @return string
     */
    public function view_summary(stdClass $submission, & $showviewlink) {
        global $DB;
        
        $o = '';
        
        $count = $this->count_files($submission->id, ASSIGNSUBMISSION_ONENOTE_FILEAREA);

        // Show we show a link to view all files for this plugin?
        $showviewlink = $count > ASSIGNSUBMISSION_ONENOTE_MAXSUMMARYFILES;
        if ($count <= ASSIGNSUBMISSION_ONENOTE_MAXSUMMARYFILES) {
            // get page id of the OneNote page for this assignment
            $record = $DB->get_record('assign_user_ext', array("assign_id" => $submission->assignment, "user_id" => $submission->userid));
            if ($record) {
                $onenote_token = microsoft_onenote::get_onenote_token();
                
                if (isset($onenote_token)) {
                    $page = microsoft_onenote::get_onenote_page($onenote_token, $record->page_id);
                    if ($page) {
                        $url = new moodle_url($page->links->oneNoteWebUrl->href);
                        
                        // show a link to the OneNote page
                        $o .= '<p><a onclick="window.open(this.href,\'_blank\'); return false;" href="' . $url->out(false) . '" style="' . microsoft_onenote::get_linkbutton_style() . '">' . 'View in OneNote' . '</a></p>';
                    } else {
                        $o .= '<p>The OneNote page corresponding to this assignment appears to have been deleted. Luckily, you had saved it into Moodle and you can dwonload it as a Zip file below.</p>';
                    }
                } else {
                    $o .= microsoft_onenote::get_onenote_signin_widget();
                    $o .= '<br/><br/><p>Click on the button above to sign in to OneNote if you want to view your submission there.</p>';
                }
            }
            
            // show standard link to download zip package
            $o .= '<p>Download as a Zip file:</p>';
            $o .= $this->assignment->render_area_files('assignsubmission_onenote',
                                                        ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                                                        $submission->id);
            
            //error_log(print_r($this->assignment, true));
            //error_log(print_r($submission, true));
            
            return $o;
        } else {
            return get_string('countfiles', 'assignsubmission_onenote', $count);
        }
    }

    /**
     * No full submission view - the summary contains the list of files and that is the whole submission
     *
     * @param stdClass $submission
     * @return string
     */
    public function view(stdClass $submission) {
        return $this->assignment->render_area_files('assignsubmission_onenote',
                                                    ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                                                    $submission->id);
    }



    /**
     * Return true if this plugin can upgrade an old Moodle 2.2 assignment of this type
     * and version.
     *
     * @param string $type
     * @param int $version
     * @return bool True if upgrade is possible
     */
    public function can_upgrade($type, $version) {

        $uploadsingletype ='uploadsingle';
        $uploadtype ='upload';

        if (($type == $uploadsingletype || $type == $uploadtype) && $version >= 2011112900) {
            return true;
        }
        return false;
    }


    /**
     * Upgrade the settings from the old assignment
     * to the new plugin based one
     *
     * @param context $oldcontext - the old assignment context
     * @param stdClass $oldassignment - the old assignment data record
     * @param string $log record log events here
     * @return bool Was it a success? (false will trigger rollback)
     */
    public function upgrade_settings(context $oldcontext, stdClass $oldassignment, & $log) {
        global $DB;

        if ($oldassignment->assignmenttype == 'uploadsingle') {
            $this->set_config('maxfilesubmissions', 1);
            $this->set_config('maxsubmissionsizebytes', $oldassignment->maxbytes);
            return true;
        } else if ($oldassignment->assignmenttype == 'upload') {
            $this->set_config('maxfilesubmissions', $oldassignment->var1);
            $this->set_config('maxsubmissionsizebytes', $oldassignment->maxbytes);

            // Advanced file upload uses a different setting to do the same thing.
            $DB->set_field('assign',
                           'submissiondrafts',
                           $oldassignment->var4,
                           array('id'=>$this->assignment->get_instance()->id));

            // Convert advanced file upload "hide description before due date" setting.
            $alwaysshow = 0;
            if (!$oldassignment->var3) {
                $alwaysshow = 1;
            }
            $DB->set_field('assign',
                           'alwaysshowdescription',
                           $alwaysshow,
                           array('id'=>$this->assignment->get_instance()->id));
            return true;
        }
    }

    /**
     * Upgrade the submission from the old assignment to the new one
     *
     * @param context $oldcontext The context of the old assignment
     * @param stdClass $oldassignment The data record for the old oldassignment
     * @param stdClass $oldsubmission The data record for the old submission
     * @param stdClass $submission The data record for the new submission
     * @param string $log Record upgrade messages in the log
     * @return bool true or false - false will trigger a rollback
     */
    public function upgrade(context $oldcontext,
                            stdClass $oldassignment,
                            stdClass $oldsubmission,
                            stdClass $submission,
                            & $log) {
        global $DB;

        $filesubmission = new stdClass();

        $filesubmission->numfiles = $oldsubmission->numfiles;
        $filesubmission->submission = $submission->id;
        $filesubmission->assignment = $this->assignment->get_instance()->id;

        if (!$DB->insert_record('assignsubmission_onenote', $filesubmission) > 0) {
            $log .= get_string('couldnotconvertsubmission', 'mod_assign', $submission->userid);
            return false;
        }

        // Now copy the area files.
        $this->assignment->copy_area_files_for_upgrade($oldcontext->id,
                                                        'mod_assignment',
                                                        'submission',
                                                        $oldsubmission->id,
                                                        $this->assignment->get_context()->id,
                                                        'assignsubmission_onenote',
                                                        ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                                                        $submission->id);

        return true;
    }

    /**
     * The assignment has been deleted - cleanup
     *
     * @return bool
     */
    public function delete_instance() {
        global $DB;
        // Will throw exception on failure.
        $DB->delete_records('assignsubmission_onenote',
                            array('assignment'=>$this->assignment->get_instance()->id));

        return true;
    }

    /**
     * Formatting for log info
     *
     * @param stdClass $submission The submission
     * @return string
     */
    public function format_for_log(stdClass $submission) {
        // Format the info for each submission plugin (will be added to log).
        $filecount = $this->count_files($submission->id, ASSIGNSUBMISSION_ONENOTE_FILEAREA);

        return get_string('numfilesforlog', 'assignsubmission_onenote', $filecount);
    }

    /**
     * Return true if there are no submission files
     * @param stdClass $submission
     */
    public function is_empty(stdClass $submission) {
        return $this->count_files($submission->id, ASSIGNSUBMISSION_ONENOTE_FILEAREA) == 0;
    }

    /**
     * Get file areas returns a list of areas this plugin stores files
     * @return array - An array of fileareas (keys) and descriptions (values)
     */
    public function get_file_areas() {
        return array(ASSIGNSUBMISSION_ONENOTE_FILEAREA=>$this->get_name());
    }

    /**
     * Copy the student's submission from a previous submission. Used when a student opts to base their resubmission
     * on the last submission.
     * @param stdClass $sourcesubmission
     * @param stdClass $destsubmission
     */
    public function copy_submission(stdClass $sourcesubmission, stdClass $destsubmission) {
        global $DB;

        // Copy the files across.
        $contextid = $this->assignment->get_context()->id;
        $fs = get_file_storage();
        $files = $fs->get_area_files($contextid,
                                     'assignsubmission_onenote',
                                     ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                                     $sourcesubmission->id,
                                     'id',
                                     false);
        foreach ($files as $file) {
            $fieldupdates = array('itemid' => $destsubmission->id);
            $fs->create_file_from_storedfile($fieldupdates, $file);
        }

        // Copy the assignsubmission_file record.
        if ($filesubmission = $this->get_file_submission($sourcesubmission->id)) {
            unset($filesubmission->id);
            $filesubmission->submission = $destsubmission->id;
            $DB->insert_record('assignsubmission_onenote', $filesubmission);
        }
        return true;
    }

    /**
     * Return a description of external params suitable for uploading a file submission from a webservice.
     *
     * @return external_description|null
     */
    public function get_external_parameters() {
        return array(
            'onenotes_filemanager' => new external_value(
                PARAM_INT,
                'The id of a draft area containing files for this submission.'
            )
        );
    }
}
