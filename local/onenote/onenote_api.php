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
 * Convenient wrappers and helper for using the OneNote API
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com) Sushant Gawali (sushant@introp.net)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/local/msaccount/msaccount_client.php');

// File areas for OneNote submission assignment.
define('ASSIGNSUBMISSION_ONENOTE_MAXFILES', 1);
define('ASSIGNSUBMISSION_ONENOTE_MAXSUMMARYFILES', 5);
define('ASSIGNSUBMISSION_ONENOTE_FILEAREA', 'submission_onenote_files');

// File areas for onenote feedback assignment.
define('ASSIGNFEEDBACK_ONENOTE_FILEAREA', 'feedback_files');
define('ASSIGNFEEDBACK_ONENOTE_BATCH_FILEAREA', 'feedback_files_batch');
define('ASSIGNFEEDBACK_ONENOTE_IMPORT_FILEAREA', 'feedback_files_import');
define('ASSIGNFEEDBACK_ONENOTE_MAXSUMMARYFILES', 1);
define('ASSIGNFEEDBACK_ONENOTE_MAXSUMMARYUSERS', 5);
define('ASSIGNFEEDBACK_ONENOTE_MAXFILEUNZIPTIME', 120);

/**
 * A helper class to access Microsoft OneNote using the REST api. 
 * This is a singleton class.
 *
 * @package    local_onenote
 */
class onenote_api {
    /** @var string Base url to access API */
    // TODO: Switch to non-beta version
    const API = 'https://www.onenote.com/api/beta'; // 'https://www.onenote.com/api/v1.0';.
    
    private static $instance = null;
    private $msacountapi = null;
        
    protected function __construct() {
        $this->msaccountapi = msaccount_api::getinstance();
    }

    public static function getinstance() {
        if (null === self::$instance) {
            self::$instance = new static();
        }
        
        self::$instance->get_msaccount_api()->is_logged_in();

        return self::$instance;
    }
    
    public function get_msaccount_api() {
        return $this->msaccountapi;
    }
    
    /**
     * Downloads a OneNote page to a  file from onenote using authenticated request
     *
     * @param string $id id of page
     * @param string $path path to save page to
     * @return array stucture for repository download_file
     */
    public function download_page($pageid, $path) {

        $url = self::API."/pages/".$pageid."/content";

        $response = $this->get_msaccount_api()->myget($url);

        // On success, we get an HTML page as response. On failure, we get JSON error object, so we have to decode to check errors.
        $decodedresponse = json_decode($response);

        if (!$response || isset($decodedresponse->error)) {
            return null;
        }

        // See if the file contains any references to images or other files and if so, create a folder and download those, too.
        $doc = new DOMDocument();
        $doc->loadHTML($response);
        $xpath = new DOMXPath($doc);
        
        $this->handle_garbage_chars($xpath);

        // Process span tags to increase font size.
        $this->process_span_tags($xpath);

        $imgnodes = $xpath->query("//img");
        
        if ($imgnodes && (count($imgnodes) > 0)) {
            // Create temp folder.
            $tempfolder = $this->create_temp_folder();
            
            $filesfolder = join(DIRECTORY_SEPARATOR, array(rtrim($tempfolder, DIRECTORY_SEPARATOR), 'page_files'));
            if (!mkdir($filesfolder, 0777, true)) {
                echo('Failed to create folder: ' . $filesfolder);
                return null;
            }
            
            // Save images etc.
            $i = 1;
            foreach ($imgnodes as $imgnode) {
                $srcnode = $imgnode->attributes->getNamedItem("src");
                if (!$srcnode) {
                    continue;
                }
                $response = $this->get_msaccount_api()->myget($srcnode->nodeValue);
                file_put_contents($filesfolder . DIRECTORY_SEPARATOR . 'img_' . $i, $response);
                
                // Update img src paths in the html accordingly.
                $srcnode->nodeValue = '.' . DIRECTORY_SEPARATOR . 'page_files' . DIRECTORY_SEPARATOR . 'img_' . $i;
                
                // Remove data_fullres_src if present.
                if ($imgnode->attributes->getNamedItem("data-fullres-src")) {
                    $imgnode->removeAttribute("data-fullres-src");
                }
                $i++; 
            }
            
            // Save the html page itself.
            file_put_contents(join(DIRECTORY_SEPARATOR,
                array(rtrim($tempfolder, DIRECTORY_SEPARATOR), 'page.html')), $doc->saveHTML());
            
            // Zip up the folder so it can be attached as a single file.
            $fp = get_file_packer('application/zip');
            $filelist = array();
            $filelist[] = $tempfolder;
           
            $fp->archive_to_pathname($filelist, $path);
            
            fulldelete($tempfolder);
        } else {
            file_put_contents($path, $response);
        }
        
        return array('path' => $path, 'url' => $url);
    }

    /**
     * Returns the name of the OneNote item (notebook or section) given its id.
     *
     * @param string $itemid the id which is passed
     * @return mixed item name or false in case of error
     */
    public function get_item_name($itemid) {

        if (empty($itemid)) {
            throw new coding_exception('Empty item_id passed to get_item_name');
        }

        $url = self::API."/notebooks/{$itemid}";
        $response = json_decode($this->get_msaccount_api()->myget($url));

        if (!$response || isset($response->error)) {
            // TODO: Hack: See if it is a section id.
            $url = self::API."/sections/{$itemid}";
            $response = json_decode($this->get_msaccount_api()->myget($url));

            if (!$response || isset($response->error)) {
                return false;
            }
        }

        return $response->name.".zip";
    }

    /**
     * Returns a list of items (notebooks and sections)
     *
     * @param string $path the path which we are in
     * @return mixed Array of items formatted for fileapi
     */
    public function get_items_list($path = '') {
        global $OUTPUT;

        if (empty($path)) {
            $itemtype = 'notebook';
            $url = self::API."/notebooks";
        } else {
            $parts = explode('/', $path);
            $part1 = array_pop($parts);
            $part2 = array_pop($parts);

            if ($part2) {
                $itemtype = 'page';
                $url = self::API."/sections/{$part1}/pages";
            } else {
                $itemtype = 'section';
                $url = self::API."/notebooks/{$part1}/sections";
            }
        }

        $response = json_decode($this->get_msaccount_api()->myget($url));

        $items = array();

        if (isset($response->error)) {
            return $items;
        }

        if ($response && $response->value) {
            foreach ($response->value as $item) {
                switch ($itemtype) {
                case 'notebook':
                    $items[] = array(
                        'title' => $item->name,
                        'path' => $path.'/'.urlencode($item->id),
                        'date' => strtotime($item->lastModifiedTime),
                        'thumbnail' => $OUTPUT->pix_url(file_extension_icon($item->name, 90))->out(false),
                        'source' => $item->id,
                        'url' => $item->links->oneNoteWebUrl->href,
                        'author' => $item->createdBy,
                        'id' => $item->id,
                        'children' => array()
                    );
                    break;

                case 'section':
                    $items[] = array(
                        'title' => $item->name,
                        'path' => $path.'/'.urlencode($item->id),
                        'date' => strtotime($item->lastModifiedTime),
                        'thumbnail' => $OUTPUT->pix_url(file_extension_icon($item->name, 90))->out(false),
                        'source' => $item->id,
                        'url' => $item->self,
                        'author' => $item->createdBy,
                        'id' => $item->id,
                        'children' => array()
                    );
                    break;

                case 'page':
                    $items[] = array(
                        'title' => $item->title.".zip",
                        'path' => $path.'/'.urlencode($item->id),
                        'date' => strtotime($item->createdTime),
                        'thumbnail' => $OUTPUT->pix_url(file_extension_icon($item->title, 90))->out(false),
                        'source' => $item->id,
                        'url' => $item->links->oneNoteWebUrl->href,
                        'author' => $item->createdByAppId,
                        'id' => $item->id
                    );
                    break;
                }
            }
        }

        return $items;
    }

    // Ensure that data about the notebooks and sections in OneNote are sync'ed up with our database.
    private function sync_notebook_data() {
        global $DB;
        
        $notebooks = $this->get_items_list('');
        
        $notebookname = get_string('notebookname', 'block_onenote');
        $notebooksurl = self::API . "/notebooks/";
        $courses = enrol_get_my_courses(); // Get the current user enrolled courses.
        $notebooksarray = array();
        
        if ($notebooks) {
            foreach ($notebooks as $notebook) {
                if ($notebook['id']) {
                    $notebooksarray[$notebook['id']] = $notebook['title'];
                }
            }
        }

        if (count($notebooksarray) > 0) {
            if (!(in_array($notebookname, $notebooksarray))) {
                $param = array(
                    "name" => $notebookname
                );

                $notebookname = json_encode($param);
                $creatednotebook = json_decode($this->get_msaccount_api()->mypost($notebooksurl, $notebookname));
                $sections = array();
                
                if ($creatednotebook) {
                    $notebookid = $creatednotebook->id;
                }

                if ($courses) {
                    $this->sync_sections($courses, $notebookid, $sections);
                }
            } else {
                $notebookid = array_search($notebookname, $notebooksarray);
                $sectionurl = self::API . "/notebooks/" . $notebookid . "/sections/";
                $getsection = json_decode($this->get_msaccount_api()->myget($sectionurl));
                $sections = array();
                
                if (isset($getsection->value)) {
                    foreach ($getsection->value as $section) {
                        $sections[$section->id] = $section->name;
                    }
                }

                if ($courses) {
                    $this->sync_sections($courses, $notebookid, $sections);
                }
            }
        }
    }
    
    private function sync_sections($courses, $notebookid, array $sections) {
        $sectionurl = self::API . "/notebooks/" . $notebookid . "/sections/";

        foreach ($courses as $course) {
            if (!in_array($course->fullname, $sections)) {
                $paramsection = array(
                    "name" => $course->fullname
                );

                $section = json_encode($paramsection);
                $response = $this->get_msaccount_api()->mypost($sectionurl, $section);
                $response = json_decode($response);

                if ($response && $response->id) {
                    $this->upsert_user_section($course->id, $response->id);
                }
            } else {
                $sectionid = array_search($course->fullname, $sections);
                $this->upsert_user_section($course->id, $sectionid);
            }
        }
    }

    private function upsert_user_section($courseid, $sectionid) {
        global $DB, $USER;
        $newsection = new stdClass();
        $newsection->user_id = $USER->id;
        $newsection->course_id = $courseid;
        $newsection->section_id = $sectionid;
        
        $section = $DB->get_record('onenote_user_sections', array("course_id" => $courseid, "user_id" => $USER->id));

        if ($section) {
            $newsection->id = $section->id;
            $update = $DB->update_record("onenote_user_sections", $newsection);
        } else {
            $insert = $DB->insert_record("onenote_user_sections", $newsection);
        }
    }
    
    // Helper methods.
    public function is_logged_in() {
        return $this->get_msaccount_api()->is_logged_in();
    }
    
    public function get_login_url() {
        return $this->get_msaccount_api()->get_login_url();
    }
    
    public function log_out() {
        return $this->get_msaccount_api()->log_out();
    }
    
    public function render_signin_widget() {
        return $this->get_msaccount_api()->render_signin_widget();
    }
    
    public function render_action_button($buttontext, $cmid, $wantfeedbackpage = false, $isteacher = false,
        $submissionuserid = null, $submissionid = null, $gradeid = null) {
        
        $actionparams['action'] = 'openpage';
        $actionparams['cmid'] = $cmid;
        $actionparams['wantfeedback'] = $wantfeedbackpage;
        $actionparams['isteacher'] = $isteacher;
        $actionparams['submissionuserid'] = $submissionuserid;
        $actionparams['submissionid'] = $submissionid;
        $actionparams['gradeid'] = $gradeid;
        
        $url = new moodle_url('/local/onenote/onenote_actions.php', $actionparams);
        
        return '<a onclick="window.open(this.href,\'_blank\'); return false;" href="' .
            $url->out(false) . '" class="onenote_linkbutton">' . $buttontext . '</a>';
    }
    
    /* Gets (or creates) the submission page or feedback page in OneNote for the given student assignment.
    * Note: For each assignment, each student has a record in the db that contains the OneNote page ID's
    * of corresponding submission and feedback pages
    * Basic logic:
    * if the required submission or feedback OneNote page and corresponding record already exists in db and in OneNote,
    * weburl to the page is returned
    * if either OneNote page or corresponding record in db does not exist,
    *     if we are being called for getting a feedback page
    *         if a zip package for the feedback page exists,
    *             create OneNote page from it (for student or teacher)
    *         else
    *             if this is a teacher, it means they are just looking at the student's submission for the first time,
    *                  so create a feedback page from the submission
    *             else bail out
    *     else (we are being called for getting a submission page)
    *         if a zip package exists for the submission
    *             unzip the zip package and create page from it
    *         else
    *             if this is a student, this must be the first time they are working on the submission,
    *                  so create the page from the assignment prompt
    *             else bail out
    * return the weburl to the OneNote page created or obtained
    */
    public function get_page($cmid, $wantfeedbackpage = false, $isteacher = false, $submissionuserid = null,
                             $submissionid = null, $gradeid = null) {
        global $USER, $DB;
        
        $cm = get_coursemodule_from_id('assign', $cmid, 0, false, MUST_EXIST);
        $assign = $DB->get_record('assign', array('id' => $cm->instance)); 
        $context = context_module::instance($cm->id);
        $userid = $USER->id;
        
        // If $submission_userId is given, then it contains the student's user id.
        // If it is null, it means a student is just looking at the assignment to start working on it, so use the logged in user id.
        if ($submissionuserid) {
            $studentuserid = $submissionuserid;
        } else {
            $studentuserid = $userid;
        }
        
        $student = $DB->get_record('user', array('id' => $studentuserid));
        
        // If the required submission or feedback OneNote page and corresponding record already exists in db and in OneNote,
        // weburl to the page is returned.
        $record = $DB->get_record('onenote_assign_pages', array("assign_id" => $assign->id, "user_id" => $studentuserid));
        if ($record) {
            $pageid = $wantfeedbackpage ? ($isteacher ? $record->feedback_teacher_page_id : $record->feedback_student_page_id) :
                                          ($isteacher ? $record->submission_teacher_page_id : $record->submission_student_page_id);
            if ($pageid) {
                $page = json_decode($this->get_msaccount_api()->myget(self::API . '/pages/' . $pageid));
                if ($page && !isset($page->error)) {
                    $url = $page->links->oneNoteWebUrl->href;
                    return $url;
                }
            }

            // Probably user deleted page, so we will update the db record to reflect it and continue to recreate the page.
            if ($wantfeedbackpage) {
                if ($isteacher) {
                    $record->feedback_teacher_page_id = null;
                } else {
                    $record->feedback_student_page_id = null;
                }
            } else {
                if ($isteacher) {
                    $record->submission_teacher_page_id = null;
                } else {
                    $record->submission_student_page_id = null;
                }
            }
                
            $DB->update_record('onenote_assign_pages', $record);
        } else {
            // Prepare record object since we will use it further down to insert into database.
            $record = new object();
            $record->assign_id = $assign->id;
            $record->user_id = $studentuserid;
        }
        
        // Get the section id for the course so we can create the page in the approp section.
        $section = $this->get_section($cm->course, $userid);
        if (!$section) {
            return false;
        }
        $sectionid = $section->section_id;
        $boundary = hash('sha256', rand());
        $fs = get_file_storage();
        
        // If we are being called for getting a feedback page.
        if ($wantfeedbackpage) {
            // If previously saved feedback does not exist.
            if (!$gradeid ||
                !($files = $fs->get_area_files($context->id, 'assignfeedback_onenote', ASSIGNFEEDBACK_ONENOTE_FILEAREA, 
                        $gradeid, 'id', false))) {
                if ($isteacher) {
                    // This must be the first time teacher is looking at student's submission
                    // So prepare feedback page from submission zip package.
                    $files = $fs->get_area_files($context->id, 'assignsubmission_onenote', ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                        $submissionid, 'id', false);
                    
                    if ($files) {
                        // Unzip the submission and prepare postdata from it.
                        $tempfolder = $this->create_temp_folder();
                        $fp = get_file_packer('application/zip');
                        $filelist = $fp->extract_to_pathname(reset($files), $tempfolder);
                        
                        $a = new stdClass();
                        $a->assign_name = $assign->name;
                        $a->student_firstname = $student->firstname;
                        $a->student_lastname = $student->lastname;
                        $postdata = $this->create_postdata_from_folder(
                            get_string('feedbacktitle', 'local_onenote', $a),
                            join(DIRECTORY_SEPARATOR, array(rtrim($tempfolder, DIRECTORY_SEPARATOR), '0')), $boundary);
                    } else {
                        // Student did not turn in a submission, so create an empty one.
                        $a = new stdClass();
                        $a->assign_name = $assign->name;
                        $a->student_firstname = $student->firstname;
                        $a->student_lastname = $student->lastname;
                        $postdata = $this->create_postdata(
                            get_string('feedbacktitle', 'local_onenote', $a),
                            $assign->intro, $context->id, $boundary);
                    }
                } else {
                    return null;
                }
            } else {
                // Create postdata from the zip package of teacher's feedback.
                $tempfolder = $this->create_temp_folder();
                $fp = get_file_packer('application/zip');
                $filelist = $fp->extract_to_pathname(reset($files), $tempfolder);
                
                $a = new stdClass();
                $a->assign_name = $assign->name;
                $a->student_firstname = $student->firstname;
                $a->student_lastname = $student->lastname;
                $postdata = $this->create_postdata_from_folder(
                    get_string('feedbacktitle', 'local_onenote', $a),
                    join(DIRECTORY_SEPARATOR, array(rtrim($tempfolder, DIRECTORY_SEPARATOR), '0')), $boundary);
            }
        } else {
            // We want submission page.
            if (!$submissionid ||
                !($files = $fs->get_area_files($context->id, 'assignsubmission_onenote', ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                    $submissionid, 'id', false))) {
                if ($isteacher) {
                    return null;
                } else {
                    // This is a student and they are just starting to work on this assignment.
                    // So prepare page from the assignment prompt.
                    $a = new stdClass();
                    $a->assign_name = $assign->name;
                    $a->student_firstname = $student->firstname;
                    $a->student_lastname = $student->lastname;
                    $postdata = $this->create_postdata(
                        get_string('submissiontitle', 'local_onenote', $a),
                        $assign->intro, $context->id, $boundary);
                }
            } else {
                // Unzip the submission and prepare postdata from it.
                $tempfolder = $this->create_temp_folder();
                $fp = get_file_packer('application/zip');
                $filelist = $fp->extract_to_pathname(reset($files), $tempfolder);
                
                $a = new stdClass();
                $a->assign_name = $assign->name;
                $a->student_firstname = $student->firstname;
                $a->student_lastname = $student->lastname;
                $postdata = $this->create_postdata_from_folder(
                    get_string('submissiontitle', 'local_onenote', $a),
                    join(DIRECTORY_SEPARATOR, array(rtrim($tempfolder, DIRECTORY_SEPARATOR), '0')), $boundary);
            }
        }
            
        $response = $this->create_page_from_postdata($sectionid, $postdata, $boundary);

        // If there is connection error, repeat curl call for 3 times by pausing 0.5 sec in between.
        if($response == 'connection_error'){
            for($i = 0; $i <3; $i++){
                $response = $this->create_page_from_postdata($sectionid, $postdata, $boundary);

                // If we get proper response then break the loop.
                if($response != 'connection_error'){
                    break;
                }
                usleep(500000);
            }
        }

        // If still there is connection error, return it.
        if($response == 'connection_error'){
            return $response;
        }

        if ($response) {
            // Remember page id in the same db record or insert a new one if it did not exist before.
            if ($wantfeedbackpage) {
                if ($isteacher) {
                    $record->feedback_teacher_page_id = $response->id;
                } else {
                    $record->feedback_student_page_id = $response->id;
                }
            } else {
                if ($isteacher) {
                    $record->submission_teacher_page_id = $response->id;
                } else {
                    $record->submission_student_page_id = $response->id;
                }
            }
                
            if (isset($record->id)) {
                $DB->update_record('onenote_assign_pages', $record);
            } else {
                $DB->insert_record('onenote_assign_pages', $record);
            }
            // Return weburl to that onenote page.
            $url = $response->links->oneNoteWebUrl->href;
            return $url;
        }
        
        return null;
    }

    // Check if we are in sync with OneNote notebooks and section and try to sync up if we are not.
    private function get_section($courseid, $userid) {
        global $DB;
        
        $section = $DB->get_record('onenote_user_sections', array("course_id" => $courseid, "user_id" => $userid));

        // Need to make sure section actually exists in case user may have deleted it.
        if ($section && $section->section_id) {
            $onenotesection = json_decode($this->get_msaccount_api()->myget(self::API . '/sections/' . $section->section_id));
            if ($onenotesection && !isset($onenotesection->error)) {
                return $section;
            }
        }
        
        $this->sync_notebook_data();
            
        $section = $DB->get_record('onenote_user_sections', array("course_id" => $courseid, "user_id" => $userid));
        if ($section && $section->section_id) {
            return $section;
        }
        return null;
    }

    private function get_file_contents($path, $filename, $contextid) {
        // Get file contents.
        $fs = get_file_storage();
    
        // Prepare file record object.
        $fileinfo = array(
            'component' => 'mod_assign',     // Usually = table name.
            'filearea' => 'intro',     // Usually = table name.
            'itemid' => 0,               // Usually = ID of row in table.
            'contextid' => $contextid, // ID of context.
            'filepath' => $path,           // Any path beginning and ending in /.
            'filename' => $filename);
    
        // Get file.
        $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
                $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
    
        $contents = array();
    
        if ($file) {
            $filesize = $file->get_filesize();
            $filedata = $file->get_filepath();
    
            $contents['filename'] = $file->get_filename();
            $contents['content'] = $file->get_content();
        }
    
        return $contents;
    }
    
    private function create_postdata($title, $bodycontent, $contextid, $boundary) {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($bodycontent);
        libxml_clear_errors();
        
        $xpath = new DOMXPath($dom);
        $doc = $dom->getElementsByTagName("body")->item(0);
        
        // Process heading and td tags.
        $this->process_tags($dom, $xpath);

        // Handle <br/> problem.
        $this->process_br_tags($xpath);
        
        // Process images.
        $src = $xpath->query("//@src");
        $imgdata = '';
        $eol = "\r\n";
        
        if ($src) {
            foreach ($src as $s) {
                $pathparts = pathinfo(urldecode($s->nodeValue));
                $path = substr($pathparts['dirname'], strlen('@@PLUGINFILE@@')) . DIRECTORY_SEPARATOR;
                $contents = $this->get_file_contents($path, $pathparts['basename'], $contextid);
    
                if (!$contents || (count($contents) == 0)) {
                    continue;
                }
                $pathparts['filename'] = urlencode($pathparts['filename']);
                $contents['filename'] = urlencode($contents['filename']);
    
                $s->nodeValue = "name:" . $pathparts['filename'];
    
                $imgdata .= '--' . $boundary . $eol;
                $imgdata .= 'Content-Disposition: form-data; name="' . $pathparts['filename'] . '"; filename="' .
                    $contents['filename'] . '"' . $eol;
                $imgdata .= 'Content-Type: image/jpeg' . $eol .$eol;
                $imgdata .= $contents['content'] . $eol;
            }
        }
    
        // Extract just the content of the body.
        $domclone = new DOMDocument;
        foreach ($doc->childNodes as $child) {
            $domclone->appendChild($domclone->importNode($child, true));
        }
    
        $output = $domclone->saveHTML();

        $date = date("Y-m-d H:i:s");

        $postdata = '';
        $postdata .= '--' . $boundary . $eol;
        $postdata .= 'Content-Disposition: form-data; name="Presentation"' . $eol;
        $postdata .= 'Content-Type: application/xhtml+xml' . $eol . $eol;
        $postdata .= '<?xml version="1.0" encoding="utf-8" ?><html xmlns="http://www.w3.org/1999/xhtml" lang="en-us">' . $eol;
        $postdata .= '<head><title>' . $title . '</title>' . '<meta name="created" value="' . $date . '"/></head>' . $eol;
        $postdata .= '<body style="font-family:\'Helvetica\',Arial,sans-serif;font-size:12px; color:rgb(51,51,51);">' .
            $output . '</body>' . $eol;
        $postdata .= '</html>' . $eol;
        $postdata .= $imgdata . $eol;
        $postdata .= '--' . $boundary . '--' . $eol . $eol;

        return $postdata;
    }
    
    private function create_postdata_from_folder($title, $folder, $boundary) {
        $dom = new DOMDocument();
        
        $pagefile = join(DIRECTORY_SEPARATOR, array(rtrim($folder, DIRECTORY_SEPARATOR), 'page.html'));
        if (!$dom->loadHTMLFile($pagefile)) {
            return null;
        }
        $xpath = new DOMXPath($dom);
        $doc = $dom->getElementsByTagName("body")->item(0);
        
        $this->handle_garbage_chars($xpath);

        $imgnodes = $xpath->query("//img");
        $imgdata = '';
        $eol = "\r\n";
        
        if ($imgnodes) {
            foreach ($imgnodes as $imgnode) {
                $srcnode = $imgnode->attributes->getNamedItem("src");
                if (!$srcnode) {
                    continue;
                }
                $srcrelpath = urldecode($srcnode->nodeValue);
                $srcfilename = substr($srcrelpath, strlen('./page_files/'));
                $srcpath = join(DIRECTORY_SEPARATOR, array(rtrim($folder, DIRECTORY_SEPARATOR), substr($srcrelpath, 2)));
                $contents = file_get_contents($srcpath);
    
                if (!$contents || (count($contents) == 0)) {
                    continue;
                }
                $srcfilename = urlencode($srcfilename);
                $srcnode->nodeValue = "name:" . $srcfilename;
                
                // Remove data_fullres_src if present.
                if ($imgnode->attributes->getNamedItem("data-fullres-src")) {
                    $imgnode->removeAttribute("data-fullres-src");
                }
                $imgdata .= '--' . $boundary . $eol;
                $imgdata .= 'Content-Disposition: form-data; name="' . $srcfilename . '"; filename="' . $srcfilename . '"' . $eol;
                $imgdata .= 'Content-Type: image/jpeg' . $eol .$eol;
                $imgdata .= $contents . $eol;
            }
        }
    
        // Extract just the content of the body.
        $domclone = new DOMDocument;
        foreach ($doc->childNodes as $child) {
            $domclone->appendChild($domclone->importNode($child, true));
        }
    
        $output = $domclone->saveHTML();
        $date = date("Y-m-d H:i:s");
    
        $postdata = '';
        $postdata .= '--' . $boundary . $eol;
        $postdata .= 'Content-Disposition: form-data; name="Presentation"' . $eol;
        $postdata .= 'Content-Type: application/xhtml+xml' . $eol . $eol;
        $postdata .= '<?xml version="1.0" encoding="utf-8" ?><html xmlns="http://www.w3.org/1999/xhtml" lang="en-us">' . $eol;
        $postdata .= '<head><title>' . $title . '</title>' . '<meta name="created" value="' . $date . '"/></head>' . $eol;
        $postdata .= '<body style="font-family:\'Helvetica\',\'Helvetica Neue\', Arial, \'Lucida Grande\',';
        $postdata .= 'sans-serif;font-size:12px; color:rgb(51,51,51);">' . $output . '</body>' . $eol;
        $postdata .= '</html>' . $eol;
        $postdata .= $imgdata . $eol;
        $postdata .= '--' . $boundary . '--' . $eol . $eol;
        
        return $postdata;
    }
    
    private function create_page_from_postdata($sectionid, $postdata, $boundary) {
        $token = $this->get_msaccount_api()->get_accesstoken()->token;
        $url = self::API . '/sections/' . $sectionid . '/pages';
        $encodedaccesstoken = rawurlencode($token);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data; boundary=$boundary" . PHP_EOL .
                "Authorization: Bearer " . $encodedaccesstoken));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        
        $rawresponse = curl_exec($ch);

        // Check if curl call fails.
        if($rawresponse === false){
            $errorno = curl_errno($ch);
            curl_close($ch);

            // If curl call fails and reason is net connectivity return it or return null.
            if (in_array($errorno, array('6', '7', '28'))) {
                return 'connection_error';
            } else {
                return null;
            }
        }

        $info = curl_getinfo($ch);
        curl_close($ch);
        
        if ($info['http_code'] == 201) {
            $responsewithoutheader = substr($rawresponse, $info['header_size']);
            $response = json_decode($responsewithoutheader);
            return $response;
        }
        
        return null;
    }

    // HACKHACK: Remove this once OneNote fixes their bug.
    // OneNote has a bug that occurs with HTML containing consecutive <br/> tags.
    // The workaround is to replace the last <br/> in a sequence with a <p/>.
    private function process_br_tags($xpath) {
        $brnodes = $xpath->query('//br');
        
        if ($brnodes) {
            $count = $brnodes->length;
            $index = 0;
            
            while ($index < $count) {
                $brnode = $brnodes->item($index);
                
                // Replace only the last br in a sequence with a p.
                $nextsibling = $brnode->nextSibling;
                while ($nextsibling && ($nextsibling->nodeName == 'br')) {
                    $brnode = $nextsibling;
                    $nextsibling = $brnode->nextSibling;
                    $index++;
                }
                
                $pnode = new DOMElement('p', '&nbsp;');
                $brnode->parentNode->replaceChild($pnode, $brnode);
                $index++;
            }
        }    
    }
    
    // HACKHACK: Remove this once OneNote fixes their bug.
    // OneNote has a bug that occurs with HTML containing consecutive <br/> tags.
    // They get converted into garbage chars like ￼. Replace them with <p/> tags.
    private function handle_garbage_chars($xpath) {
        $garbagenodes = $xpath->query("//p[contains(., 'ï¿¼')]");
        
        if ($garbagenodes) {
            $count = $garbagenodes->length;
            $index = 0;
            
            while ($index < $count) {
                $garbagenode = $garbagenodes->item($index);
                
                // Count the number of garbage char sequences in the node value.
                $nodevalue = $garbagenode->nodeValue;
                $replaced = 0;
                $nodevalue = str_replace("ï¿¼", "", $nodevalue, $replaced);
                $garbagenode->nodeValue = $nodevalue;

                while ($replaced-- > 0) {
                    $pnode = new DOMElement('p', '&nbsp;');
                    $garbagenode->parentNode->insertBefore($pnode, $garbagenode->nextSibling);
                }

                $index++;
            }
        }    
    }
    
    // Get the repo id for the onenote repo.
    public function get_onenote_repo_id() {
        global $DB;
        $repository = $DB->get_record('repository', array('type' => ' onenote'));
        return $repository->id;
    }
    
    public function create_temp_folder() {
        $tempfolder = join(DIRECTORY_SEPARATOR, array(rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR), uniqid('asg_')));
        if (file_exists($tempfolder)) {
            fulldelete($tempfolder);
        }
    
        if (!mkdir($tempfolder, 0777, true)) {
            echo('Failed to create temp folder: ' . $tempfolder);
            return null;
        }
    
        return $tempfolder;
    }

    // Check if given user is a teacher in the given course.
    public function is_teacher($courseid, $userid) {
        // Teacher role comes with courses.
        $context = context_course::instance($courseid); // Get_context_instance(CONTEXT_COURSE, $courseid, true);.
        
        $roles = get_user_roles($context, $userid, true);
    
        foreach ($roles as $role) {
            if ($role->roleid == 3) {
                return true;
            }
        }
    
        return false;
    }

    /**
     * Function to add span for heading and td tags and respective font sizes
     * @param $dom
     * @param $xpath
     */
    private function process_tags($dom, $xpath) {

        // List of tags we are processing.
        $tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'td');

        // Font sizes for each tag.
        $tagfontsizes = array('h1' => '24px', 'h2' => '22px', 'h3' => '18px',
            'h4' => '16px', 'h5' => '12px', 'h6' => '10px' , 'td' => '12px');

        // Process each tag.
        foreach ($tags as $tag) {

            $nodes = $xpath->query('//'.$tag);
            if ($nodes->length) {

                $nodesarray = array();

                foreach ($nodes as $tagnode) {
                    $nodesarray[] = $tagnode;
                }

                foreach ($nodesarray as $node) {
                    $childnodes = $node->childNodes;

                    $childnodesarray = array();

                    foreach ($childnodes as $child) {
                        $childnodesarray[] = $child;
                    }

                    foreach ($childnodesarray as $childnode) {

                        if (in_array($childnode->nodeName, array('#text', 'b', 'a', 'i', 'span', 'em', 'strong'))) {

                            $spannode = $dom->createElement('span');

                            $style = "font-family:'Helvetica',Arial,sans-serif;";
                            $style .= "font-size:". $tagfontsizes[$tag] ."; color:rgb(51,51,51);";

                            $spannode->setAttribute("style", $style);

                            $spannode->appendChild($node->removeChild($childnode));
                            $node->insertBefore($spannode);

                        } else {
                            $node->insertBefore($node->removeChild($childnode));
                        }
                    }
                }
            }
        }

         // Get all tables.
         $tables = $xpath->query('//table');

         if ($tables) {
             foreach ($tables as $table) {
                 // Check if table have border attribute set.
                 $border = $table->getAttribute('border');

                 // If not, set default border of table.
                 if ($border == '') {
                     $table->setAttribute("border", "2");
                 }
             }
         }
    }

    /**
     * Function to increase the span font size to 14px to make downloaded html look better
     * @param $xpath
     */
    private function process_span_tags($xpath) {

        // Get all the span tags.
        $spannodes = $xpath->query('//span');

        if ($spannodes->length) {

            foreach ($spannodes as $span) {
                $style = $span->getAttribute('style');
                // Replace 12px font size with 14px.
                $span->setAttribute('style', str_replace('font-size:12px', 'font-size:14px', $style));
            }
        }
    }
}
