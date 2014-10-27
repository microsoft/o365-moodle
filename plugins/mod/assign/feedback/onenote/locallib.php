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
 * This file contains the definition for the library class for onenote feedback plugin
 *
 *
 * @package   assignfeedback_onenote
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Library class for ONENOTE feedback plugin extending feedback plugin base class.
 *
 * @package   assignfeedback_onenote
 */
class assign_feedback_onenote extends assign_feedback_plugin {

    /**
     * Get the name of the onenote feedback plugin.
     *
     * @return string
     */
    public function get_name() {
        return get_string('onenote', 'assignfeedback_onenote');
    }

    /**
     * Get file feedback information from the database.
     *
     * @param int $gradeid
     * @return mixed
     */
    public function get_onenote_feedback($gradeid) {
        global $DB;
        return $DB->get_record('assignfeedback_onenote', array('grade'=>$gradeid));
    }

    /**
     * File format options.
     *
     * @return array
     */
    private function get_file_options() {
        global $COURSE;

        $fileoptions = array('subdirs'=>1,
                             'maxbytes'=>$COURSE->maxbytes,
                             'accepted_types'=>'*',
                             'return_types'=>FILE_INTERNAL);
        return $fileoptions;
    }

    /**
     * Copy all the files from one file area to another.
     *
     * @param file_storage $fs - The source context id
     * @param int $fromcontextid - The source context id
     * @param string $fromcomponent - The source component
     * @param string $fromfilearea - The source filearea
     * @param int $fromitemid - The source item id
     * @param int $tocontextid - The destination context id
     * @param string $tocomponent - The destination component
     * @param string $tofilearea - The destination filearea
     * @param int $toitemid - The destination item id
     * @return boolean
     */
    private function copy_area_files(file_storage $fs,
                                     $fromcontextid,
                                     $fromcomponent,
                                     $fromfilearea,
                                     $fromitemid,
                                     $tocontextid,
                                     $tocomponent,
                                     $tofilearea,
                                     $toitemid) {

        $newfilerecord = new stdClass();
        $newfilerecord->contextid = $tocontextid;
        $newfilerecord->component = $tocomponent;
        $newfilerecord->filearea = $tofilearea;
        $newfilerecord->itemid = $toitemid;

        if ($files = $fs->get_area_files($fromcontextid, $fromcomponent, $fromfilearea, $fromitemid)) {
            foreach ($files as $file) {
                if ($file->is_directory() and $file->get_filepath() === '/') {
                    // We need a way to mark the age of each draft area.
                    // By not copying the root dir we force it to be created
                    // automatically with current timestamp.
                    continue;
                }
                $newfile = $fs->create_file_from_storedfile($newfilerecord, $file);
            }
        }
        return true;
    }

    /**
     * Get form elements for grading form.
     *
     * @param stdClass $grade
     * @param MoodleQuickForm $mform
     * @param stdClass $data
     * @param int $userid The userid we are currently grading
     * @return bool true if elements were added to the form
     */
    public function get_form_elements_for_user($grade, MoodleQuickForm $mform, stdClass $data, $userid) {
        global $USER;
        
        $gradeid = $grade ? $grade->id : 0;
        $o = '<hr/><b>OneNote actions:</b>&nbsp;&nbsp;&nbsp;&nbsp;';
        
        if (microsoft_onenote::get_onenote_token()) {
            // show a link to open the OneNote page
            $submission = $this->assignment->get_user_submission($userid, false);
            $is_teacher = microsoft_onenote::is_teacher($this->assignment->get_course()->id, $USER->id);
            $o .= microsoft_onenote:: render_action_button('Add feedback in OneNote',
                    $this->assignment->get_course_module()->id, true, $is_teacher,
                    $userid, $submission->id, $grade ? $grade->id : null);
            $o .= '<br/><p>Click on the button above to add your feedback for the student\'s submission in OneNote. You can come back here later on to save your work back into Moodle.</p>';
        } else {
            $o .= microsoft_onenote::get_onenote_signin_widget();
            $o .= '<br/><br/><p>Click on the button above to sign in to OneNote so you can add your feedback to the student\'s submission there.</p>';
        }
        
        $o .= '<hr/>';
        
        $mform->addElement('html', $o);
        
        return true;
    }

    /**
     * Count the number of files.
     *
     * @param int $gradeid
     * @param string $area
     * @return int
     */
    private function count_files($gradeid, $area) {

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->assignment->get_context()->id,
                                     'assignfeedback_onenote',
                                     $area,
                                     $gradeid,
                                     'id',
                                     false);

        return count($files);
    }

    /**
     * Update the number of files in the file area.
     *
     * @param stdClass $grade The grade record
     * @return bool - true if the value was saved
     */
    public function update_file_count($grade) {
        global $DB;

        $filefeedback = $this->get_onenote_feedback($grade->id);
        if ($filefeedback) {
            $filefeedback->numfiles = $this->count_files($grade->id, ASSIGNFEEDBACK_ONENOTE_FILEAREA);
            return $DB->update_record('assignfeedback_onenote', $filefeedback);
        } else {
            $filefeedback = new stdClass();
            $filefeedback->numfiles = $this->count_files($grade->id, ASSIGNFEEDBACK_ONENOTE_FILEAREA);
            $filefeedback->grade = $grade->id;
            $filefeedback->assignment = $this->assignment->get_instance()->id;
            return $DB->insert_record('assignfeedback_onenote', $filefeedback) > 0;
        }
    }

    /**
     * Save the feedback files.
     *
     * @param stdClass $grade
     * @param stdClass $data
     * @return bool
     */
    public function save(stdClass $grade, stdClass $data) {
        global $DB;
        
        // get the OneNote page id corresponding to the teacher's feedback for this submission
        $record = $DB->get_record('assign_user_ext', array("assign_id" => $grade->assignment, "user_id" => $grade->userid));
        $temp_folder = microsoft_onenote::create_temp_folder();
        $temp_file = join(DIRECTORY_SEPARATOR, array(trim($temp_folder, DIRECTORY_SEPARATOR), uniqid('asg_'))) . '.zip';
        
        // Create zip file containing onenote page and related files
        $onenote_api = microsoft_onenote::get_onenote_api();
        $download_info = $onenote_api->download_page($record->feedback_teacher_page_id, $temp_file);
        
        if ($download_info) {
            $fs = get_file_storage();
            
            // delete any previous feedbacks
            $fs->delete_area_files($this->assignment->get_context()->id, 'assignfeedback_onenote', ASSIGNFEEDBACK_ONENOTE_FILEAREA, $grade->id);
            
            // Prepare file record object
            $fileinfo = array(
                'contextid' => $this->assignment->get_context()->id,
                'component' => 'assignfeedback_onenote',
                'filearea' => ASSIGNFEEDBACK_ONENOTE_FILEAREA,
                'itemid' => $grade->id,
                'filepath' => '/',
                'filename' => 'OneNote_' . time() . '.zip');
            
            // save it
            $fs->create_file_from_pathname($fileinfo, $download_info['path']);
            fulldelete($temp_folder);
        }
        
        return $this->update_file_count($grade);
    }

    /**
     * Display the list of files in the feedback status table.
     *
     * @param stdClass $grade
     * @param bool $showviewlink - Set to true to show a link to see the full list of files
     * @return string
     */
    public function view_summary(stdClass $grade, & $showviewlink) {
        global $USER;
        
        // Show a view all link if the number of files is over this limit.
        $count = $this->count_files($grade->id, ASSIGNFEEDBACK_ONENOTE_FILEAREA);
        $showviewlink = $count > ASSIGNFEEDBACK_ONENOTE_MAXSUMMARYFILES;
     
        $o = '';
        
        if ($count <= ASSIGNFEEDBACK_ONENOTE_MAXSUMMARYFILES) {
            if (($grade->grade !== null) && ($grade->grade >= 0)) {
                if (microsoft_onenote::get_onenote_token()) {                    
                    // show a link to open the OneNote page
                    $submission = $this->assignment->get_user_submission($grade->userid, false);
                    $is_teacher = microsoft_onenote::is_teacher($this->assignment->get_course()->id, $USER->id);
                    $o .= microsoft_onenote:: render_action_button('View feedback in OneNote',
                            $this->assignment->get_course_module()->id, true, $is_teacher,
                            $submission->userid, $submission->id, $grade->id);
                } else {
                    $o .= microsoft_onenote::get_onenote_signin_widget();
                    $o .= '<br/><br/><p>Click on the button above to sign in to OneNote if you want to view the submission there.</p>';
                }
            }
            
            // show standard link to download zip package
            $o .= '<p>Download:</p>';
            $o .= $this->assignment->render_area_files('assignfeedback_onenote',
                                                        ASSIGNFEEDBACK_ONENOTE_FILEAREA,
                                                        $grade->id);
            
            return $o;
        } else {
            return get_string('countfiles', 'assignfeedback_onenote', $count);
        }
    }

    /**
     * Display the list of files in the feedback status table.
     *
     * @param stdClass $grade
     * @return string
     */
    public function view(stdClass $grade) {
        return $this->assignment->render_area_files('assignfeedback_onenote',
                                                    ASSIGNFEEDBACK_ONENOTE_FILEAREA,
                                                    $grade->id);
    }

    /**
     * The assignment has been deleted - cleanup.
     *
     * @return bool
     */
    public function delete_instance() {
        global $DB;
        // Will throw exception on failure.
        $DB->delete_records('assignfeedback_onenote',
                            array('assignment'=>$this->assignment->get_instance()->id));

        return true;
    }

    /**
     * Return true if there are no feedback files.
     *
     * @param stdClass $grade
     */
    public function is_empty(stdClass $grade) {
        return $this->count_files($grade->id, ASSIGNFEEDBACK_ONENOTE_FILEAREA) == 0;
    }

    /**
     * Get file areas returns a list of areas this plugin stores files.
     *
     * @return array - An array of fileareas (keys) and descriptions (values)
     */
    public function get_file_areas() {
        return array(ASSIGNFEEDBACK_ONENOTE_FILEAREA=>$this->get_name());
    }

    /**
     * Return true if this plugin can upgrade an old Moodle 2.2 assignment of this type
     * and version.
     *
     * @param string $type old assignment subtype
     * @param int $version old assignment version
     * @return bool True if upgrade is possible
     */
    public function can_upgrade($type, $version) {
        if (($type == 'upload' || $type == 'uploadsingle') && $version >= 2011112900) {
            return true;
        }
        return false;
    }

    /**
     * Upgrade the settings from the old assignment to the new plugin based one.
     *
     * @param context $oldcontext - the context for the old assignment
     * @param stdClass $oldassignment - the data for the old assignment
     * @param string $log - can be appended to by the upgrade
     * @return bool was it a success? (false will trigger a rollback)
     */
    public function upgrade_settings(context $oldcontext, stdClass $oldassignment, & $log) {
        // First upgrade settings (nothing to do).
        return true;
    }

    /**
     * Upgrade the feedback from the old assignment to the new one.
     *
     * @param context $oldcontext - the database for the old assignment context
     * @param stdClass $oldassignment The data record for the old assignment
     * @param stdClass $oldsubmission The data record for the old submission
     * @param stdClass $grade The data record for the new grade
     * @param string $log Record upgrade messages in the log
     * @return bool true or false - false will trigger a rollback
     */
    public function upgrade(context $oldcontext,
                            stdClass $oldassignment,
                            stdClass $oldsubmission,
                            stdClass $grade,
                            & $log) {
        global $DB;

        // Now copy the area files.
        $this->assignment->copy_area_files_for_upgrade($oldcontext->id,
                                                        'mod_assignment',
                                                        'response',
                                                        $oldsubmission->id,
                                                        $this->assignment->get_context()->id,
                                                        'assignfeedback_onenote',
                                                        ASSIGNFEEDBACK_ONENOTE_FILEAREA,
                                                        $grade->id);

        // Now count them!
        $filefeedback = new stdClass();
        $filefeedback->numfiles = $this->count_files($grade->id, ASSIGNFEEDBACK_ONENOTE_FILEAREA);
        $filefeedback->grade = $grade->id;
        $filefeedback->assignment = $this->assignment->get_instance()->id;
        if (!$DB->insert_record('assignfeedback_onenote', $filefeedback) > 0) {
            $log .= get_string('couldnotconvertgrade', 'mod_assign', $grade->userid);
            return false;
        }
        return true;
    }

    /**
     * Return a list of the batch grading operations performed by this plugin.
     * This plugin supports batch upload files and upload zip.
     *
     * @return array The list of batch grading operations
     */
    public function get_grading_batch_operations() {
        return array('uploadfiles'=>get_string('uploadfiles', 'assignfeedback_onenote'));
    }

    /**
     * Upload files and send them to multiple users.
     *
     * @param array $users - An array of user ids
     * @return string - The response html
     */
    public function view_batch_upload_files($users) {
        global $CFG, $DB, $USER;

        require_capability('mod/assign:grade', $this->assignment->get_context());
        require_once($CFG->dirroot . '/mod/assign/feedback/onenote/batchuploadfilesform.php');
        require_once($CFG->dirroot . '/mod/assign/renderable.php');

        $formparams = array('cm'=>$this->assignment->get_course_module()->id,
                            'users'=>$users,
                            'context'=>$this->assignment->get_context());

        $usershtml = '';

        $usercount = 0;
        foreach ($users as $userid) {
            if ($usercount >= ASSIGNFEEDBACK_ONENOTE_MAXSUMMARYUSERS) {
                $moreuserscount = count($users) - ASSIGNFEEDBACK_ONENOTE_MAXSUMMARYUSERS;
                $usershtml .= get_string('moreusers', 'assignfeedback_onenote', $moreuserscount);
                break;
            }
            $user = $DB->get_record('user', array('id'=>$userid), '*', MUST_EXIST);

            $usersummary = new assign_user_summary($user,
                                                   $this->assignment->get_course()->id,
                                                   has_capability('moodle/site:viewfullnames',
                                                   $this->assignment->get_course_context()),
                                                   $this->assignment->is_blind_marking(),
                                                   $this->assignment->get_uniqueid_for_user($user->id),
                                                   get_extra_user_fields($this->assignment->get_context()));
            $usershtml .= $this->assignment->get_renderer()->render($usersummary);
            $usercount += 1;
        }

        $formparams['usershtml'] = $usershtml;

        $mform = new assignfeedback_onenote_batch_upload_files_form(null, $formparams);

        if ($mform->is_cancelled()) {
            redirect(new moodle_url('view.php',
                                    array('id'=>$this->assignment->get_course_module()->id,
                                          'action'=>'grading')));
            return;
        } else if ($data = $mform->get_data()) {
            // Copy the files from the draft area to a temporary import area.
            $data = file_postupdate_standard_filemanager($data,
                                                         'onenotes',
                                                         $this->get_file_options(),
                                                         $this->assignment->get_context(),
                                                         'assignfeedback_onenote',
                                                         ASSIGNFEEDBACK_ONENOTE_BATCH_FILEAREA,
                                                         $USER->id);
            $fs = get_file_storage();

            // Now copy each of these files to the users feedback file area.
            foreach ($users as $userid) {
                $grade = $this->assignment->get_user_grade($userid, true);
                $this->assignment->notify_grade_modified($grade);

                $this->copy_area_files($fs,
                                       $this->assignment->get_context()->id,
                                       'assignfeedback_onenote',
                                       ASSIGNFEEDBACK_ONENOTE_BATCH_FILEAREA,
                                       $USER->id,
                                       $this->assignment->get_context()->id,
                                       'assignfeedback_onenote',
                                       ASSIGNFEEDBACK_ONENOTE_FILEAREA,
                                       $grade->id);

                $filefeedback = $this->get_onenote_feedback($grade->id);
                if ($filefeedback) {
                    $filefeedback->numfiles = $this->count_files($grade->id,
                                                                 ASSIGNFEEDBACK_ONENOTE_FILEAREA);
                    $DB->update_record('assignfeedback_onenote', $filefeedback);
                } else {
                    $filefeedback = new stdClass();
                    $filefeedback->numfiles = $this->count_files($grade->id,
                                                                 ASSIGNFEEDBACK_ONENOTE_FILEAREA);
                    $filefeedback->grade = $grade->id;
                    $filefeedback->assignment = $this->assignment->get_instance()->id;
                    $DB->insert_record('assignfeedback_onenote', $filefeedback);
                }
            }

            // Now delete the temporary import area.
            $fs->delete_area_files($this->assignment->get_context()->id,
                                   'assignfeedback_onenote',
                                   ASSIGNFEEDBACK_ONENOTE_BATCH_FILEAREA,
                                   $USER->id);

            redirect(new moodle_url('view.php',
                                    array('id'=>$this->assignment->get_course_module()->id,
                                          'action'=>'grading')));
            return;
        } else {

            $header = new assign_header($this->assignment->get_instance(),
                                        $this->assignment->get_context(),
                                        false,
                                        $this->assignment->get_course_module()->id,
                                        get_string('batchuploadfiles', 'assignfeedback_onenote'));
            $o = '';
            $o .= $this->assignment->get_renderer()->render($header);
            $o .= $this->assignment->get_renderer()->render(new assign_form('batchuploadfiles', $mform));
            $o .= $this->assignment->get_renderer()->render_footer();
        }

        return $o;
    }

    /**
     * User has chosen a custom grading batch operation and selected some users.
     *
     * @param string $action - The chosen action
     * @param array $users - An array of user ids
     * @return string - The response html
     */
    public function grading_batch_operation($action, $users) {

        if ($action == 'uploadfiles') {
            return $this->view_batch_upload_files($users);
        }
        return '';
    }

    /**
     * View the upload zip form.
     *
     * @return string - The html response
     */
    public function view_upload_zip() {
        global $CFG, $USER;

        require_capability('mod/assign:grade', $this->assignment->get_context());
        require_once($CFG->dirroot . '/mod/assign/feedback/onenote/uploadzipform.php');
        require_once($CFG->dirroot . '/mod/assign/feedback/onenote/importziplib.php');
        require_once($CFG->dirroot . '/mod/assign/feedback/onenote/importzipform.php');

        $formparams = array('context'=>$this->assignment->get_context(),
                            'cm'=>$this->assignment->get_course_module()->id);
        $mform = new assignfeedback_onenote_upload_zip_form(null, $formparams);

        $o = '';

        $confirm = optional_param('confirm', 0, PARAM_BOOL);
        $renderer = $this->assignment->get_renderer();

        // Delete any existing files.
        $importer = new assignfeedback_onenote_zip_importer();
        $contextid = $this->assignment->get_context()->id;

        if ($mform->is_cancelled()) {
            $importer->delete_import_files($contextid);
            $urlparams = array('id'=>$this->assignment->get_course_module()->id,
                               'action'=>'grading');
            $url = new moodle_url('view.php', $urlparams);
            redirect($url);
            return;
        } else if ($confirm) {
            $params = array('assignment'=>$this->assignment, 'importer'=>$importer);

            $mform = new assignfeedback_onenote_import_zip_form(null, $params);
            if ($mform->is_cancelled()) {
                $importer->delete_import_files($contextid);
                $urlparams = array('id'=>$this->assignment->get_course_module()->id,
                                   'action'=>'grading');
                $url = new moodle_url('view.php', $urlparams);
                redirect($url);
                return;
            }

            $o .= $importer->import_zip_files($this->assignment, $this);
            $importer->delete_import_files($contextid);
        } else if (($data = $mform->get_data()) &&
                   ($zipfile = $mform->save_stored_file('feedbackzip',
                                                        $contextid,
                                                        'assignfeedback_onenote',
                                                        ASSIGNFEEDBACK_ONENOTE_IMPORT_FILEAREA,
                                                        $USER->id,
                                                        '/',
                                                        'import.zip',
                                                        true))) {

            $importer->extract_files_from_zip($zipfile, $contextid);

            $params = array('assignment'=>$this->assignment, 'importer'=>$importer);

            $mform = new assignfeedback_onenote_import_zip_form(null, $params);

            $header = new assign_header($this->assignment->get_instance(),
                                        $this->assignment->get_context(),
                                        false,
                                        $this->assignment->get_course_module()->id,
                                        get_string('confirmuploadzip', 'assignfeedback_onenote'));
            $o .= $renderer->render($header);
            $o .= $renderer->render(new assign_form('confirmimportzip', $mform));
            $o .= $renderer->render_footer();

        } else {

            $header = new assign_header($this->assignment->get_instance(),
                                        $this->assignment->get_context(),
                                        false,
                                        $this->assignment->get_course_module()->id,
                                        get_string('uploadzip', 'assignfeedback_onenote'));
            $o .= $renderer->render($header);
            $o .= $renderer->render(new assign_form('uploadfeedbackzip', $mform));
            $o .= $renderer->render_footer();
        }

        return $o;
    }

    /**
     * Called by the assignment module when someone chooses something from the
     * grading navigation or batch operations list.
     *
     * @param string $action - The page to view
     * @return string - The html response
     */
    public function view_page($action) {
        if ($action == 'uploadfiles') {
            $users = required_param('selectedusers', PARAM_SEQUENCE);
            return $this->view_batch_upload_files(explode(',', $users));
        }
        if ($action == 'uploadzip') {
            return $this->view_upload_zip();
        }

        return '';
    }

    /**
     * Return a list of the grading actions performed by this plugin.
     * This plugin supports upload zip.
     *
     * @return array The list of grading actions
     */
    public function get_grading_actions() {
        return array('uploadzip'=>get_string('uploadzip', 'assignfeedback_onenote'));
    }

    /**
     * Return a description of external params suitable for uploading a feedback file from a webservice.
     *
     * @return external_description|null
     */
    public function get_external_parameters() {
        return array(
            'onenotes_filemanager' => new external_value(
                PARAM_INT,
                'The id of a draft area containing OneNote files for this feedback.'
            )
        );
    }

}
