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
 * Functions for operating with the OneNote API
 *
 * @package    repository_onenote
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/oauthlib.php');

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
 * A helper class to access microsoft live resources using the api.
 *
 * This uses the microsoft API defined in
 * http://msdn.microsoft.com/en-us/library/hh243648.aspx
 *
 * @package    repository_onenote
 */
class microsoft_onenote extends oauth2_client {
    /** @var string OAuth 2.0 scope */
    const SCOPE = 'office.onenote_update';
    /** @var string Base url to access API */
    const API = 'https://www.onenote.com/api/beta'; //'https://www.onenote.com/api/v1.0';
    /** @var cache_session cache of notebooknames */
    var $itemnamecache = null;
    private $isget = TRUE;

    // Singleton instance
    protected static $_instance = null;
        
    /**-
     * Construct a onenote request object
     * TODO: Need to make this protected to ensure singleton usage
     *
     * @param string $clientid client id for OAuth 2.0 provided by microsoft
     * @param string $clientsecret secret for OAuth 2.0 provided by microsoft
     * @param moodle_url $returnurl url to return to after succseful auth
     */
    public function __construct($clientid, $clientsecret, $returnurl) {
        parent::__construct($clientid, $clientsecret, $returnurl, self::SCOPE);

        // error_log('microsoft_onenote constructor');
        // error_log(print_r($clientid, true));
        // error_log(print_r($clientsecret, true));
        // error_log(print_r($returnurl, true));

        // Make a session cache
        $this->itemnamecache = cache::make('repository_onenote', 'foldername');
    }

    // Singleton pattern implementation makes "clone" unavailable
    protected function __clone()
    {}
    
    // Singleton pattern implementation
    public static function getInstance()
    {
        if (null === self::$_instance) {
            $returnurl = new moodle_url('/repository/repository_callback.php');
            $returnurl->param('callback', 'yes');
            $returnurl->param('repo_id', microsoft_onenote::get_onenote_repo_id());
            $returnurl->param('sesskey', sesskey());
        
            self::$_instance = new self(get_config('onenote', 'clientid'), get_config('onenote', 'secret'), $returnurl);
        
            if (isset(self::$_instance)) {
                self::$_instance->is_logged_in();
            }
        }
    
        return self::$_instance;
    }
    
    /**
     * Should HTTP GET be used instead of POST?
     *
     * The Microsoft API does not support POST, so we should use
     * GET instead (with the auth_token passed as a GET param).
     *
     * @return bool true if GET should be used
     */
    protected function use_http_get() {
        return $this->isget;
    }

    /**
     * Returns the auth url for OAuth 2.0 request
     * @return string the auth url
     */
    protected function auth_url() {
        return 'https://login.live.com/oauth20_authorize.srf';
    }

    /**
     * Returns the token url for OAuth 12.0 request
     * @return string the auth url
     */
    protected function token_url() {
        return 'https://login.live.com/oauth20_token.srf';
    }

    /**
     * Downloads a OneNote page to a  file from onenote using authenticated request
     *
     * @param string $id id of page
     * @param string $path path to save page to
     * @return array stucture for repository download_file
     */
     public function download_page($page_id, $path) {
        error_log('download_page called: ' . print_r($page_id, true));

        $url = self::API."/pages/".$page_id."/content";
        //error_log(print_r($url,true));

        $this->isget = FALSE;
        $response = $this->get($url);
        $this->isget = TRUE;

        // on success, we get an HTML page as response. On failure, we get JSON error object, so we have to decode to check errors
        $decoded_response = json_decode($response);
        error_log("response: " . print_r($response, true));

        if (!$response || isset($decoded_response->error)) {
            return null;
        }

        // see if the file contains any references to images or other files and if so, create a folder and download those, too
        $doc = new DOMDocument();
        $doc->loadHTML($response);
        $xpath = new DOMXPath($doc);
        $img_nodes = $xpath->query("//img");
        
        if ($img_nodes && (count($img_nodes) > 0)) {
            // create temp folder
            $temp_folder = microsoft_onenote::create_temp_folder();
            
            $files_folder = join(DIRECTORY_SEPARATOR, array(trim($temp_folder, DIRECTORY_SEPARATOR), 'page_files'));
            if (!mkdir($files_folder))
                return null;
            
            $this->isget = FALSE;
        
            // save images etc.
            $i = 1;
            foreach ($img_nodes as $img_node) {
                $src_node = $img_node->attributes->getNamedItem("src");
                $response = $this->get($src_node->nodeValue);
                file_put_contents($files_folder . DIRECTORY_SEPARATOR . 'img_' . $i, $response);
                
                // update img src paths in the html accordingly
                $src_node->nodeValue = '.' . DIRECTORY_SEPARATOR . 'page_files' . DIRECTORY_SEPARATOR . 'img_' . $i;
                
                // remove data_fullres_src if present
                if ($img_node->attributes->getNamedItem("data-fullres-src"))
                    $img_node->removeAttribute("data-fullres-src");
                
                $i++; 
            }
            
            $this->isget = TRUE;

            // save the html page itself
            file_put_contents(join(DIRECTORY_SEPARATOR, array(trim($temp_folder, DIRECTORY_SEPARATOR), 'page.html')), $doc->saveHTML());
            
            // zip up the folder so it can be attached as a single file
            $fp = get_file_packer('application/zip');
            $filelist = array();
            $filelist[] = $temp_folder;
           
            $fp->archive_to_pathname($filelist, $path);
            
            fulldelete($temp_folder);
        } else {
            file_put_contents($path, $response);
        }
        
        return array('path'=>$path, 'url'=>$url);
    }

    /**
     * Returns the name of the OneNote item (notebook or section) given its id.
     *
     * @param string $item_id the id which is passed
     * @return mixed item name or false in case of error
     */
    public function get_item_name($item_id) {
        error_log('get_item_name called: ' . print_r($item_id, true));

        if (empty($item_id)) {
            throw new coding_exception('Empty item_id passed to get_item_name');
        }

        // Cache based on oauthtoken and item_id.
        $cachekey = $this->item_cache_key($item_id);

        if ($item_name = $this->itemnamecache->get($cachekey)) {
            return $item_name;
        }

        $url = self::API."/notebooks/{$item_id}";
        $this->isget = FALSE;
        $this->request($url);
        $response = json_decode($this->get($url));
        $this->isget = TRUE;
        //error_log('response: ' . print_r($response, true));

        if (!$response || isset($response->error)) {
            // TODO: Hack: See if it is a section id
            $url = self::API."/sections/{$item_id}";
            $this->isget = FALSE;
            $this->request($url);
            $response = json_decode($this->get($url));
            $this->isget = TRUE;
            //error_log('response: ' . print_r($response, true));

            if (!$response || isset($response->error)) {
                return false;
            }
        }

        $this->itemnamecache->set($cachekey, $response->value[0]->name);
        return $response->value[0]->name.".zip";
    }

    /**
     * Returns a list of items (notebooks and sections)
     *
     * @param string $path the path which we are in
     * @return mixed Array of items formatted for fileapi
     */
    public function get_items_list($path = '') {
        global $OUTPUT;

        error_log('get_items_list called: ' . $path);
        $precedingpath = '';

        if (empty($path)) {
            $item_type = 'notebook';
            $url = self::API."/notebooks";
        } else {
            $parts = explode('/', $path);
            $part1 = array_pop($parts);
            $part2 = array_pop($parts);
            //error_log('part1: ' . print_r($part1, true));
            //error_log('part2: ' . print_r($part2, true));

            if ($part2) {
                $item_type = 'page';
                $url = self::API."/sections/{$part1}/pages";
            } else {
                $item_type = 'section';
                $url = self::API."/notebooks/{$part1}/sections";
            }
        }

        //error_log('request: ' . print_r($url, true));
        $this->isget = FALSE;
        $this->request($url);
        $response = json_decode($this->get($url));
        $this->isget = TRUE;

        //error_log('response: ' . print_r($response, true));

        $items = array();

        if (isset($response->error)) {
            return $items;
        }

        if ($response && $response->value) {
            foreach ($response->value as $item) {
                switch ($item_type) {
                case 'notebook':
                    $items[] = array(
                        'title' => $item->name,
                        'path' => $path.'/'.urlencode($item->id),
                        //'size' => $item->size,
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
                        //'size' => $item->size,
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
                        //'size' => $item->size,
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

        if (empty($path)) {
            $this->insert_notes($items);
       }

        return $items;
    }

    /**
     * Returns a key for itemname cache
     *
     * @param string $item_id the id which is to be cached
     * @return string the cache key to use
     */
    private function item_cache_key($item_id) {
        // Cache based on oauthtoken and item_id.
        return $this->get_tokenname().'_'.$item_id;
    }

    private function insert_notes($notes) {
        global $DB;
        $notebook_name = get_string('notebookname','block_onenote');
        $noteurl = self::API."/notebooks/";
        $courses = enrol_get_my_courses(); //get the current user enrolled courses
        $notes_array = array();
        if($notes) {
            foreach ($notes as $note) {
                if($note['id']) {
                    $notes_array[$note['id']] = $note['title'];
                }
            }
        }

        if(count($notes_array) > 0){
                if(!(in_array($notebook_name, $notes_array))){
                    $param = array(
                        "name" => $notebook_name
                    );

                    $note_name = json_encode($param);
                    $this->isget = FALSE;
                    $this->setHeader('Content-Type: application/json');
                    $this->request($noteurl);
                    $created_notes = json_decode($this->post($noteurl,$note_name));
                    $this->isget = TRUE;
                    $sections = array();
                    if($created_notes) {
                        $note_id = $created_notes->id;
                    }
                    if($courses) {
                        $this->create_sections_onenote($courses,$note_id,$sections);
                    }
                } else {
                    $note_id = array_search($notebook_name, $notes_array);
                    $sectionurl = self::API."/notebooks/".$note_id."/sections/";
                    $this->setHeader('Content-Type: application/json');
                    $this->isget = FALSE;
                    $this->request($sectionurl);
                    $getsection = json_decode($this->get($sectionurl));
                    $this->isget = TRUE;
                    $sections = array();
                    if(isset($getsection->value)) {
                        foreach($getsection->value as $section) {
                            $sections[$section->id] = $section->name;
                        }
                    }

                    if($courses) {
                        $this->create_sections_onenote($courses, $note_id, $sections);

                    }
                }
            //}
        }
    }
    
    private function insert_sectionid_table($course_id,$section_id) {
        global $DB,$USER;
        $course_onenote = new stdClass();
        $course_onenote->user_id = $USER->id;
        $course_onenote->course_id = $course_id;
        $course_onenote->section_id = $section_id;
        $course_ext = $DB->get_record('course_user_ext', array("course_id" => $course_id,"user_id" => $USER->id));
        if($course_ext) {
            $course_onenote->id = $course_ext->id;
            $update = $DB->update_record("course_user_ext", $course_onenote);
        }else {
            $insert = $DB->insert_record("course_user_ext", $course_onenote);
        }

    }
    
    private function create_sections_onenote($courses,$note_id, array $sections){
        $sectionurl = self::API."/notebooks/".$note_id."/sections/";

        foreach($courses as $course) {
            if(!in_array($course->fullname, $sections)) {
                $param_section = array(
                        "name" => $course->fullname
                );
                $section = json_encode($param_section);
                $this->setHeader('Content-Type: application/json');
                $this->isget = FALSE;
                $this->request($sectionurl);
                $eventresponse = $this->post($sectionurl,$section);
                $this->isget = TRUE;
                $eventresponse = json_decode($eventresponse);
                //mapping course id and section id
                if($eventresponse)
                $this->insert_sectionid_table($course->id, $eventresponse->id);
            } else {
                $section_id = array_search($course->fullname, $sections);
                $this->insert_sectionid_table($course->id, $section_id);

            }

        }
    }

    // -------------------------------------------------------------------------------------------------------------------------
    // Helper methods
    public static function get_onenote_api() {
        return microsoft_onenote::getInstance();
    }
    
    public static function get_onenote_token() {
        $onenote_api = microsoft_onenote::getInstance();
        if (!$onenote_api)
            return null;
    
        $tokenobj = $onenote_api->get_accesstoken();
    
        if (isset($tokenobj)) {
            return $tokenobj->token;
        }
    
        return null;
    }
    
    public static function get_onenote_signin_widget() {
        $params['client_id'] = get_config('onenote', 'clientid');
        $params['client_secret'] = get_config('onenote', 'secret');
        $returnurl = new moodle_url('/repository/repository_callback.php');
        $returnurl->param('callback', 'yes');
        $returnurl->param('repo_id', microsoft_onenote::get_onenote_repo_id());
        $returnurl->param('sesskey', sesskey());
        $params['state'] = $returnurl->out_as_local_url(FALSE);
        $params['scope'] = 'office.onenote_update';
        $params['response_type'] = 'code';
        $params['redirect_uri'] = microsoft_onenote::callback_url();
    
        $url = new moodle_url('https://login.live.com/oauth20_authorize.srf', $params);
    
        return '<a onclick="window.open(this.href,\'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=0\'); return false;"
           href="'.$url->out(false).'" class="onenote_linkbutton">' . 'Sign in to OneNote' . '</a>';
    }
    
    public static function render_action_button($button_text, $cmid, $want_feedback_page = false, $is_teacher = false, 
        $submission_user_id = null, $submission_id = null, $grade_id = null) {
        
        $action_params['action'] = 'openpage';
        $action_params['cmid'] = $cmid;
        $action_params['wantfeedback'] = $want_feedback_page;
        $action_params['isteacher'] = $is_teacher;
        $action_params['submissionuserid'] = $submission_user_id;
        $action_params['submissionid'] = $submission_id;
        $action_params['gradeid'] = $grade_id;
        
        $url = new moodle_url('/blocks/onenote/onenote_actions.php', $action_params);
        
        return '<a onclick="window.open(this.href,\'_blank\'); return false;" href="' .
            $url->out(false) . '" class="onenote_linkbutton">' . $button_text . '</a>';
    }
    
    // Gets (or creates) the submission page or feedback page in OneNote for the given student assignment.
    // Note: For each assignment, each student has a record in the db that contains the OneNote page ID's of corresponding submission and feedback pages
    // Basic logic:
    // if the required submission or feedback OneNote page and corresponding record already exists in db and in OneNote, weburl to the page is returned
    // if either OneNote page or corresponding record in db does not exist,
    //     if we are being called for getting a feedback page
    //         if a zip package for the feedback page exists, 
    //             create OneNote page from it (for student or teacher)
    //         else
    //             if this is a teacher, it means they are just looking at the student's submission for the first time, so create a feedback page from the submission
    //             else bail out
    //     else (we are being called for getting a submission page) 
    //         if a zip package exists for the submission
    //             unzip the zip package and create page from it
    //         else 
    //             if this is a student, this must be the first time they are working on the submission, so create the page from the assignment prompt
    //             else bail out
    // return the weburl to the OneNote page created or obtained
    public static function get_page($cmid, $want_feedback_page = false, $is_teacher = false, $submission_user_id = null, $submission_id = null, $grade_id = null) {
        global $USER, $DB;
        
        $token = microsoft_onenote::get_onenote_token();
        if (!$token)
            return null;
        
        $cm = get_coursemodule_from_id('assign', $cmid, 0, false, MUST_EXIST);
        $assign = $DB->get_record('assign', array('id' => $cm->instance)); 
        $context = context_module::instance($cm->id);
        $user_id = $USER->id;
        
        // if $submission_userId is given, then it contains the student's user id. If it is null, it means a student is just looking at the assignment to start working on it, so use the logged in user id
        if ($submission_user_id)
            $student_user_id = $submission_user_id;
        else
            $student_user_id = $user_id;
        
        $student_name = $DB->get_field('user', 'username', array('id' => $student_user_id));
        
        // if the required submission or feedback OneNote page and corresponding record already exists in db and in OneNote, weburl to the page is returned
        $record = $DB->get_record('assign_user_ext', array("assign_id" => $assign->id, "user_id" => $student_user_id));
        if ($record) {
            $page = microsoft_onenote::get_onenote_page($token, 
                    $want_feedback_page ? ($is_teacher ? $record->feedback_teacher_page_id : $record->feedback_student_page_id) : 
                                          ($is_teacher ? $record->submission_teacher_page_id : $record->submission_student_page_id));
        
            if ($page) {
                $url = $page->links->oneNoteWebUrl->href;
                return $url;
            }

            // probably user deleted page, so we will update the db record to reflect it and continue to recreate the page
            if ($want_feedback_page) {
                if ($is_teacher)
                    $record->feedback_teacher_page_id = null;
                else
                    $record->feedback_student_page_id = null;
            } else {
                if ($is_teacher)
                    $record->submission_teacher_page_id = null;
                else
                    $record->submission_student_page_id = null;
            }
                
            $DB->update_record('assign_user_ext', $record);
        } else {
            // prepare record object since we will use it further down to insert into database
            $record = new object();
            $record->assign_id = $assign->id;
            $record->user_id = $student_user_id;
        }
        
        // get the section id for the course so we can create the page in the approp section
        $section = $DB->get_record('course_user_ext', array("course_id" => $cm->course, "user_id" => $user_id));
        $section_id = $section->section_id;
        
        $BOUNDARY = hash('sha256',rand());
        
        $fs = get_file_storage();
        
        // if we are being called for getting a feedback page 
        if ($want_feedback_page) {
            // if previously saved fedback does not exist
            if (!$grade_id || 
                !($files = $fs->get_area_files($context->id, 'assignfeedback_onenote', ASSIGNFEEDBACK_ONENOTE_FILEAREA, 
                        $grade_id, 'id', false))) {
                if ($is_teacher) {
                    // this must be the first time teacher is looking at student's submission
                    // so prepare feedback page from submission zip package
                    $files = $fs->get_area_files($context->id, 'assignsubmission_onenote', ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                        $submission_id, 'id', false);
                    
                    if (!$files)
                        return null;
                    
                // unzip the submission and prepare postdata from it
                $temp_folder = microsoft_onenote::create_temp_folder();
                $fp = get_file_packer('application/zip');
                $filelist = $fp->extract_to_pathname(reset($files), $temp_folder);
                
                $postdata = microsoft_onenote::create_postdata_from_folder(
                        microsoft_onenote::format_assignment_title($assign, $student_name, false), 
                        join(DIRECTORY_SEPARATOR, array(trim($temp_folder, DIRECTORY_SEPARATOR), '0')), $BOUNDARY);
                } else {
                    return null;
                }
            } else {
                // create postdata from the zip package of teacher's feedback
                $temp_folder = microsoft_onenote::create_temp_folder();
                $fp = get_file_packer('application/zip');
                $filelist = $fp->extract_to_pathname(reset($files), $temp_folder);
                
                $postdata = microsoft_onenote::create_postdata_from_folder(
                        microsoft_onenote::format_assignment_title($assign, $student_name, true), 
                        join(DIRECTORY_SEPARATOR, array(trim($temp_folder, DIRECTORY_SEPARATOR), '0')), $BOUNDARY);
            }
        } else {
            // we want submission page
            if (!$submission_id || 
                !($files = $fs->get_area_files($context->id, 'assignsubmission_onenote', ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                    $submission_id, 'id', false))) {
                if ($is_teacher) {
                    return null;
                } else {
                    // this is a student and they are just starting to work on this assignment, so prepare page from the assignment prompt
                    $postdata = microsoft_onenote::create_postdata(
                        microsoft_onenote::format_assignment_title($assign, $student_name, false), 
                        $assign->intro, $context->id, $BOUNDARY);
                }
            } else {
                // unzip the submission and prepare postdata from it
                $temp_folder = microsoft_onenote::create_temp_folder();
                $fp = get_file_packer('application/zip');
                $filelist = $fp->extract_to_pathname(reset($files), $temp_folder);
                
                $postdata = microsoft_onenote::create_postdata_from_folder(
                        microsoft_onenote::format_assignment_title($assign, $student_name, false), 
                        join(DIRECTORY_SEPARATOR, array(trim($temp_folder, DIRECTORY_SEPARATOR), '0')), $BOUNDARY);
            }
        }
            
        $response = microsoft_onenote::create_page_from_postdata($token, $section_id, $postdata, $BOUNDARY);
        
        if ($response)
        {
            // remember page id in the same db record or insert a new one if it did not exist before
            if ($want_feedback_page) {
                if ($is_teacher)
                    $record->feedback_teacher_page_id = $response->id;
                else
                    $record->feedback_student_page_id = $response->id;
            } else {
                if ($is_teacher)
                    $record->submission_teacher_page_id = $response->id;
                else
                    $record->submission_student_page_id = $response->id;
            }
                
            if (isset($record->id))
                $DB->update_record('assign_user_ext', $record);
            else
                $DB->insert_record('assign_user_ext', $record);

            // return weburl to that onenote page
            $url = $response->links->oneNoteWebUrl->href;
            return $url;
        }
        
        return null;
    }
    
    private static function format_assignment_title($assign, $student_name, $is_feedback) {
        return ($is_feedback ? 'Feedback: ' : 'Submission: ') . $assign->name . ' [' . $student_name . ']';
    }
    
    public static function get_file_contents($path,$filename,$context_id) {
        // get file contents
        $fs = get_file_storage();
    
        // Prepare file record object
        $fileinfo = array(
            'component' => 'mod_assign',     // usually = table name
            'filearea' => 'intro',     // usually = table name
            'itemid' => 0,               // usually = ID of row in table
            'contextid' => $context_id, // ID of context
            'filepath' => $path,           // any path beginning and ending in /
            'filename' => $filename);
    
        // Get file
        //error_log(print_r($fileinfo, true));
        $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
                $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
    
        $contents = array();
    
        if ($file) {
            $filesize =  $file->get_filesize();
            $filedata = $file->get_filepath();
    
            $contents['filename'] = $file->get_filename();
            $contents['content'] = $file->get_content();
        }
    
        return $contents;
    }
    
    public static function create_postdata($title, $body_content, $context_id, $BOUNDARY) {
        $dom = new DOMDocument();
        $dom->loadHTML($body_content);
    
        $xpath = new DOMXPath($dom);
        $doc = $dom->getElementsByTagName("body")->item(0);
        
        // add p tags inside td tags so we can specify correct font
        $td_nodes = $xpath->query('//td');
        if ($td_nodes) {
            $td_nodes_array = array();
            
            foreach ($td_nodes as $td_node) {
                $td_nodes_array[] = $td_node;
            }
            
            foreach ($td_nodes_array as $td_node) {
                $child_nodes = $td_node->childNodes;
                $child_nodes_array = array();
                
                foreach ($child_nodes as $child_node) {
                    $child_nodes_array[] = $child_node;
                }
                
                foreach ($child_nodes_array as $child_node) {
                    $node_name = $child_node->nodeName;
                    if (($node_name == '#text') || ($node_name == 'b') || ($node_name == 'a') || ($node_name == 'i') || 
                        ($node_name == 'span') || ($node_name == 'em') || ($node_name == 'strong')) {
                        $p_node = $dom->createElement('span');
                        $p_node->setAttribute("style", "font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:12px; color:rgb(51,51,51);");
                        $p_node->appendChild($td_node->removeChild($child_node));
                        $td_node->insertBefore($p_node);
                    } else {
                        $td_node->insertBefore($td_node->removeChild($child_node));                        
                    }
                }
            }
        }
                
            // handle <br/> problem
        $br_nodes = $xpath->query('//br');
        if ($br_nodes) {
            $count = $br_nodes->length;
            $index = 0;
            
            while ($index < $count) {
                $br_node = $br_nodes->item($index);
                
                // replace only the last br in a sequence with a p
                $next_sibling = $br_node->nextSibling;
                while($next_sibling && ($next_sibling->nodeName == 'br')) {
                    $br_node = $next_sibling;
                    $next_sibling = $br_node->nextSibling;    
                    $index++;
                }
                
                $p_node = new DOMElement('p');
                $br_node->parentNode->replaceChild($p_node, $br_node);
                $index++;
            }
        }
        
        // process images
        $src = $xpath->query("//@src");
    
        if($src) {
            $img_data = "";
            foreach ($src as $s) {
                $path_parts = pathinfo(urldecode($s->nodeValue));
                $path = substr($path_parts['dirname'], strlen('@@PLUGINFILE@@')) . DIRECTORY_SEPARATOR;
                $contents = microsoft_onenote::get_file_contents($path, $path_parts['basename'], $context_id);
    
                if (!$contents || (count($contents) == 0))
                    continue;
    
                $path_parts['filename'] = urlencode($path_parts['filename']);
                $contents['filename'] = urlencode($contents['filename']);
    
                $s->nodeValue = "name:" . $path_parts['filename'];
    
                $img_data .= <<<IMGDATA
--{$BOUNDARY}
Content-Disposition: form-data; name="$path_parts[filename]"; filename="$contents[filename]"
Content-Type: image/jpeg

$contents[content]
IMGDATA;

                $img_data .="\r\n";
            }
        }
    
        // extract just the content of the body
        $dom_clone = new DOMDocument;
        foreach ($doc->childNodes as $child){
            $dom_clone->appendChild($dom_clone->importNode($child, true));
        }
    
        $output = $dom_clone->saveHTML();
        $date = date("Y-m-d H:i:s");
    
        $BODY=<<<POSTDATA
--{$BOUNDARY}
Content-Disposition: form-data; name="Presentation"
Content-Type: text/html; charset=utf-8

<!DOCTYPE html>
<html>
<head>
<title>$title</title>
<meta name="created" value="$date"/>
</head>
<body style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:12px; color:rgb(51,51,51);">$output</body>
</html>
$img_data
--{$BOUNDARY}--
POSTDATA;
    
        error_log(print_r($BODY, true));
        return $BODY;
    }
    
    public static function create_postdata_from_folder($title, $folder, $BOUNDARY) {
        $dom = new DOMDocument();
        
        $page_file = join(DIRECTORY_SEPARATOR, array(trim($folder, DIRECTORY_SEPARATOR), 'page.html'));
        if (!$dom->loadHTMLFile($page_file))
            return null;
        
        $xpath = new DOMXPath($dom);
        $doc = $dom->getElementsByTagName("body")->item(0);
        $img_nodes = $xpath->query("//img");
        $img_data = "";
        
        if($img_nodes) {
            foreach ($img_nodes as $img_node) {
                $src_node = $img_node->attributes->getNamedItem("src");
                $src_relpath = urldecode($src_node->nodeValue);
                $src_filename = substr($src_relpath, strlen('./page_files/'));
                $src_path = join(DIRECTORY_SEPARATOR, array(trim($folder, DIRECTORY_SEPARATOR), substr($src_relpath, 2)));
                $contents = file_get_contents($src_path);
    
                if (!$contents || (count($contents) == 0))
                    continue;
    
                $src_filename = urlencode($src_filename);
                $src_node->nodeValue = "name:" . $src_filename;
                
                // remove data_fullres_src if present
                if ($img_node->attributes->getNamedItem("data-fullres-src"))
                    $img_node->removeAttribute("data-fullres-src");
    
                $img_data .= <<<IMGDATA
--{$BOUNDARY}
Content-Disposition: form-data; name="$src_filename"; filename="$src_filename"
Content-Type: image/jpeg

$contents
IMGDATA;

                $img_data .="\r\n";
            }
        }
    
        // extract just the content of the body
        $dom_clone = new DOMDocument;
        foreach ($doc->childNodes as $child){
            $dom_clone->appendChild($dom_clone->importNode($child, true));
        }
    
        $output = $dom_clone->saveHTML();
        $date = date("Y-m-d H:i:s");
    
        $BODY=<<<POSTDATA
--{$BOUNDARY}
Content-Disposition: form-data; name="Presentation"
Content-Type: text/html; charset=utf-8

<!DOCTYPE html>
<html>
<head>
<title>$title</title>
<meta name="created" value="$date"/>
</head>
<body style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px; color:rgb(3,3,3);"><font face="'Helvetica Neue',Helvetica,Arial,sans-serif;" size="14px" color="rgb(3,3,3)">$output</font></body>
</html>
$img_data
--{$BOUNDARY}--
POSTDATA;
    
        error_log(print_r($BODY, true));
        return $BODY;
    }
    
    public static function create_page_from_postdata($token, $section_id, $postdata, $BOUNDARY) {
        $url = 'https://www.onenote.com/api/beta/sections/' . $section_id . '/pages';
        $encodedAccessToken = rawurlencode($token);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: multipart/form-data; boundary=$BOUNDARY\r\n".
                "Authorization: Bearer ".$encodedAccessToken));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        
        $raw_response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        if ($info['http_code'] == 201)
        {
            $response_without_header = substr($raw_response,$info['header_size']);
            $response = json_decode($response_without_header);
            return $response;
        }
        
        return null;
    }
    
    public static function get_onenote_page($onenote_token, $page_id) {
        if (!$onenote_token || !$page_id)
            return null;
        
        $curl = new curl();
    
        $header = array(
            'Authorization: Bearer ' . $onenote_token,
            'Content-Type: application/json'
        );
    
        $curl->setHeader($header);
    
        $response = $curl->get(microsoft_onenote::API . '/pages/' . $page_id);
        $response = json_decode($response);
    
        if (!$response || isset($response->error)) {
            return null;
        }
    
        return $response;
    }
    
    // get the repo id for the onenote repo
    public static function get_onenote_repo_id() {
        global $DB;
        $repository = $DB->get_record('repository', array('type'=>'onenote'));
        return $repository->id;
    }
    
    public static function create_temp_folder() {
        $temp_folder = join(DIRECTORY_SEPARATOR, array(trim(sys_get_temp_dir(), DIRECTORY_SEPARATOR), uniqid('asg_')));
        if (file_exists($temp_folder)) {
            fulldelete($temp_folder);
        }
    
        if (!mkdir($temp_folder))
            return null;
    
        return $temp_folder;
    }

    // check if given user is a teacher in the given course
    public static function is_teacher($course_id, $user_id) {
        //teacher role comes with courses.
        $context = context_course::instance($course_id);//get_context_instance(CONTEXT_COURSE, $course_id, true);
        
        $roles = get_user_roles($context, $user_id, true);
    
        foreach ($roles as $role) {
            if ($role->roleid == 3) {
                return true;
            }
        }
    
        return false;
    }

    // TODO: Update for onenote
    private function check_token_expiry() {
        global $SESSION;

        date_default_timezone_set('UTC');
        if(isset($SESSION->expires)) {
        if (time() > $SESSION->expires) {
            $refresh = array();
            if(isset($SESSION->params_office)) {
                $refresh['client_id'] = $SESSION->params_office['client_id'];
                $refresh['client_secret'] = $SESSION->params_office['client_secret'];
                $refresh['grant_type'] = "refresh_token";
                $refresh['refresh_token'] = $SESSION->refreshtoken;
                $refresh['resource'] = $SESSION->params_office['resource'];    
            }
            
            $requestaccesstokenurl = "https://login.windows.net/common/oauth2/token";

            $curl = new curl();
            $refresh_token_access = $curl->post($requestaccesstokenurl, $refresh);

            $access_token = json_decode($refresh_token_access)->access_token;
            $refresh_token = json_decode($refresh_token_access)->refresh_token;
            $expires_on = json_decode($refresh_token_access)->expires_on;

            $SESSION->accesstoken =  $access_token;
            $SESSION->refreshtoken = $refresh_token;
            $SESSION->expires = $expires_on;
         }
        }
      }
}
