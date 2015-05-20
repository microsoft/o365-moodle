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
 * Convenient wrappers and helper for using the OneNote API.
 *
 * @package local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com) Sushant Gawali (sushant@introp.net)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright Microsoft Open Technologies, Inc.
 */

namespace local_onenote\api;

/**
 * A helper class to access Microsoft OneNote using the REST api.
 */
abstract class base {
    /** The maximum number of files allowed for OneNote submissions. */
    const ASSIGNSUBMISSION_ONENOTE_MAXFILES = 1;

    /** The maximum number of summary files allowed for OneNote submissions. */
    const ASSIGNSUBMISSION_ONENOTE_MAXSUMMARYFILES = 5;

    /** File area for OneNote submission assignment. */
    const ASSIGNSUBMISSION_ONENOTE_FILEAREA = 'submission_onenote_files';

    /** The maximum number of summary files allowed for OneNote feedback. */
    const ASSIGNFEEDBACK_ONENOTE_MAXSUMMARYFILES = 1;

    /** The maximum number of summary users allowed for OneNote feedback. */
    const ASSIGNFEEDBACK_ONENOTE_MAXSUMMARYUSERS = 5;

    /** The maximum file unzip time allowed for OneNote feedback. */
    const ASSIGNFEEDBACK_ONENOTE_MAXFILEUNZIPTIME = 120;

    /** File area for OneNote feedback assignment. */
    const ASSIGNFEEDBACK_ONENOTE_FILEAREA = 'feedback_files';

    /** Batch file area for OneNote feedback assignment. */
    const ASSIGNFEEDBACK_ONENOTE_BATCH_FILEAREA = 'feedback_files_batch';

    /** Import file area for OneNote feedback assignment. */
    const ASSIGNFEEDBACK_ONENOTE_IMPORT_FILEAREA = 'feedback_files_import';

    /** @var \local_onenote\api\base The static stored singleton class. */
    protected static $instance = null;

    /**
     * Make an API call.
     *
     * @param string $httpmethod The HTTP method to use. get/post/patch/merge/delete.
     * @param string $apimethod The API endpoint/method to call.
     * @param string $params Additional paramters to include.
     * @param array $options Additional options for the request.
     * @return string The result of the API call.
     */
    abstract public function apicall($httpmethod, $apimethod, $params = '', $options = array());

    /**
     * Get a full URL and include auth token. This is useful for associated resources: attached images, etc.
     *
     * @param string $url A full URL to get.
     * @return string The result of the request.
     */
    abstract public function geturl($url, $options = array());

    /**
     * Get the token to authenticate with OneNote.
     *
     * @return string The token to authenticate with OneNote.
     */
    abstract public function get_token();

    /**
     * Determine whether the user is connected to OneNote.
     *
     * @return bool True if connected, false otherwise.
     */
    abstract public function is_logged_in();

    /**
     * Get the login url (if applicable).
     *
     * @return string The login URL.
     */
    abstract public function get_login_url();

    /**
     * End the connection to OneNote.
     */
    abstract public function log_out();

    /**
     * Return the HTML for the sign in widget for OneNote.
     * Please refer to the styles.css file for styling this widget.
     *
     * @return string HTML containing the sign in widget.
     */
    abstract public function render_signin_widget();

    /**
     * Gets the instance of the correct api class. Use this method to get an instance of the api class.
     *
     * @return \local_onenote\api\base An implementation of the OneNote API.
     */
    public static function getinstance() {
        global $USER, $SESSION, $CFG;

        $msaccountclass = '\local_onenote\api\msaccount';
        $o365class = '\local_onenote\api\o365';
        $iso365user = ($USER->auth === 'oidc' && class_exists('\local_o365\rest\onenote')) ? true : false;
        if ($iso365user === true) {
            require_once($CFG->dirroot.'/local/msaccount/msaccount_client.php');
            $sesskey = 'msaccount_client-'.md5(\msaccount_client::SCOPE);
            $disableo365onenote = get_user_preferences('local_o365_disableo365onenote', 0);
            $iso365user = (!empty($SESSION->$sesskey) || !empty($disableo365onenote)) ? false : $iso365user;

            if ($iso365user === true) {
                try {
                    $httpclient = new \local_o365\httpclient();
                    $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
                    $onenoteresource = \local_o365\rest\onenote::get_resource();
                    $token = \local_o365\oauth2\token::instance($USER->id, $onenoteresource, $clientdata, $httpclient);
                    if (empty($token)) {
                        $iso365user = false;
                    }
                } catch (\Exception $e) {
                    $iso365user = false;
                }
            }

            $class = ($iso365user === true) ? $o365class : $msaccountclass;
        } else {
            $class = $msaccountclass;
        }

        if (empty(self::$instance)) {
            self::$instance = new $class();
        }
        return self::$instance;
    }

    /**
     * Downloads a OneNote page, including any associated images etc. to a zip file from OneNote using an authenticated request.
     *
     * @param string $id ID of OneNote page.
     * @param string $path Path to save the zip file to.
     * @return array Array containing the path to the downloaded zip file and the url to the original OneNote page.
     */
    public function download_page($pageid, $path) {
        $pageendpoint = '/pages/'.$pageid.'/content';
        $response = $this->apicall('get', $pageendpoint);

        // On success, we get an HTML page as response. On failure, we get JSON error object, so we have to decode to check errors.
        $decodedresponse = json_decode($response);

        if (empty($response) || !empty($decodedresponse->error)) {
            return null;
        }

        // See if the file contains any references to images or other files and if so, create a folder and download those, too.
        $doc = new \DOMDocument('1.0', 'UTF-8');
        $doc->loadHTML(mb_convert_encoding($response, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new \DOMXPath($doc);

        $this->handle_garbage_chars($xpath);

        // Process span tags to increase font size.
        $this->process_span_tags($xpath);

        $imgnodes = $xpath->query("//img");

        // Create temp folder.
        $tempfolder = $this->create_temp_folder();

        if ($imgnodes && ($imgnodes->length > 0)) {

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
                $response = $this->geturl($srcnode->nodeValue);
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
                array(rtrim($tempfolder, DIRECTORY_SEPARATOR), 'page.html')),
                mb_convert_encoding($doc->saveHTML($doc), 'HTML-ENTITIES', 'UTF-8'));

        } else {

            // Save the html page itself.
            file_put_contents(join(DIRECTORY_SEPARATOR,
                array(rtrim($tempfolder, DIRECTORY_SEPARATOR), 'page.html')),
                mb_convert_encoding($response, 'HTML-ENTITIES', 'UTF-8'));

        }

        // Zip up the folder so it can be attached as a single file.
        $fp = get_file_packer('application/zip');
        $filelist = array();
        $filelist[] = $tempfolder;

        $fp->archive_to_pathname($filelist, $path);

        fulldelete($tempfolder);
        return array('path' => $path, 'url' => static::API.$pageendpoint);
    }

    /**
     * Returns the name of the OneNote item (notebook or section) given its id.
     *
     * @param string $itemid the id of the OneNote notebook or section
     * @return string|bool item name or false in case of error
     */
    public function get_item_name($itemid) {
        if (empty($itemid)) {
            throw new \coding_exception('Empty item_id passed to get_item_name');
        }

        $response = json_decode($this->apicall('get', '/notebooks/'.$itemid));
        if (!$response || isset($response->error)) {
            $response = json_decode($this->apicall('get', '/sections/'.$itemid));
            if (!$response || isset($response->error)) {
                return false;
            }
        }

        return $response->name.".zip";
    }

    /**
     * Returns a list of OneNote item(s) at the given path (notebooks or sections or pages).
     *
     * @param string $path The path containing notebook id / section id / page id.
     * @return array Array of items formatted for fileapi.
     */
    public function get_items_list($path = '') {
        global $OUTPUT;

        if (empty($path)) {
            $itemtype = 'notebook';
            $endpoint = '/notebooks';
        } else {
            $parts = explode('/', $path);
            $part1 = array_pop($parts);
            $part2 = array_pop($parts);

            if ($part2) {
                $itemtype = 'page';
                $endpoint = '/sections/'.$part1.'/pages';
            } else {
                $itemtype = 'section';
                $endpoint = '/notebooks/'.$part1.'/sections';
            }
        }

        $response = json_decode($this->apicall('get', $endpoint));

        $items = array();

        if (isset($response->error)) {
            throw new \Exception($response->error);
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

    /**
     * Ensure that notebook and section data in the logged-in user's OneNote account are in sync with our database tables.
     */
    public function sync_notebook_data() {
        global $DB;
        $notebookname = get_string('notebookname', 'block_onenote');
        $courses = enrol_get_my_courses(); // Get the current user enrolled courses.
        $notebooksarray = [];
        $notebooks = $this->get_items_list('');
        if ($notebooks) {
            foreach ($notebooks as $notebook) {
                if (isset($notebook['id'])) {
                    $notebooksarray[$notebook['id']] = $notebook['title'];
                }
            }
        }
        if (!(in_array($notebookname, $notebooksarray))) {
            $notebookname = json_encode(['name' => $notebookname]);
            $creatednotebook = json_decode($this->apicall('post', '/notebooks', $notebookname));
            $sections = [];
            if (!empty($creatednotebook)) {
                if (!empty($courses)) {
                    $this->sync_sections($courses, $creatednotebook->id, $sections);
                }
            }
        } else {
            $notebookid = array_search($notebookname, $notebooksarray);
            $getsection = json_decode($this->apicall('get', '/notebooks/'.$notebookid.'/sections/'));
            $sections = [];
            if (isset($getsection->value)) {
                foreach ($getsection->value as $section) {
                    $sections[$section->id] = $section->name;
                }
            }
            if (!empty($courses)) {
                $this->sync_sections($courses, $notebookid, $sections);
            }
        }
    }

    /**
     * Sync OneNote notebook sections in the currently logged-in user's account with our database.
     *
     * @param array $courses Array of courses for the current user.
     * @param string $notebookid The id of the OneNote notebook associated with the current user.
     * @param array $sections Array of sections within the this notebook.
     */
    protected function sync_sections($courses, $notebookid, array $sections) {
        $sectionendpoint = '/notebooks/'.$notebookid.'/sections/';

        foreach ($courses as $course) {
            if (!in_array($course->fullname, $sections)) {
                $response = $this->apicall('post', $sectionendpoint, json_encode(['name' => $course->fullname]));
                $response = json_decode($response);
                if ($response && isset($response->id)) {
                    $this->upsert_user_section($course->id, $response->id);
                }
            } else {
                $sectionid = array_search($course->fullname, $sections);
                $this->upsert_user_section($course->id, $sectionid);
            }
        }
    }

    /**
     * Insert or update OneNote notebook sections discovered during the sync process into the database.
     *
     * @param $courseid Course id.
     * @param $sectionid OneNote section id.
     */
    protected function upsert_user_section($courseid, $sectionid) {
        global $DB, $USER;
        $newsection = new \stdClass;
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

    /**
     * Render an action button for OneNote actions such as the user wanting to go to OneNote to view or work on their assignment
     * or viewing or adding feedback.
     *
     * @param string $buttontext Text to display inside the button.
     * @param int $cmid course module id.
     * @param bool $wantfeedbackpage True if this action is for a feedback page. False if it is for a submission page.
     * @param bool $isteacher Is the current user a teacher or a student?
     * @param null $submissionuserid User id associated with the submission.
     * @param null $submissionid Submission id. This could be null if student has not submitted anything.
     * @param null $gradeid Grade id associated with the submission. Null if this calls is for a submission page.
     * @return string HTML string containing the widget to display on the page.
     */
    public function render_action_button($buttontext, $cmid, $wantfeedbackpage = false, $isteacher = false,
                                         $submissionuserid = null, $submissionid = null, $gradeid = null) {
        $actionparams['action'] = 'openpage';
        $actionparams['cmid'] = $cmid;
        $actionparams['wantfeedback'] = $wantfeedbackpage;
        $actionparams['isteacher'] = $isteacher;
        $actionparams['submissionuserid'] = $submissionuserid;
        $actionparams['submissionid'] = $submissionid;
        $actionparams['gradeid'] = $gradeid;

        $url = new \moodle_url('/local/onenote/onenote_actions.php', $actionparams);

        $attrs = [
            'onclick' => 'window.open(this.href,\'_blank\'); return false;',
            'class' => 'local_onenote_linkbutton',
        ];
        return \html_writer::link($url->out(false), $buttontext, $attrs);
    }

    /**
     * Gets (or creates) the submission page or feedback page in OneNote for the given student assignment.
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
     *
     * @param int $cmid course module id.
     * @param bool $wantfeedbackpage True if this action is for a feedback page. False if it is for a submission page.
     * @param bool $isteacher Is the current user a teacher or a student?
     * @param null $submissionuserid User id associated with the submission.
     * @param null $submissionid Submission id. This could be null if student has not submitted anything.
     * @param null $gradeid Grade id associated with the submission. Null if this call is for a submission page.
     * @return string|bool The weburl to the OneNote page created or obtained, or false if failure.
     */
    public function get_page($cmid, $wantfeedbackpage = false, $isteacher = false, $submissionuserid = null,
                             $submissionid = null, $gradeid = null) {
        global $USER, $DB;

        $cm = get_coursemodule_from_id('assign', $cmid, 0, false, MUST_EXIST);
        $assign = $DB->get_record('assign', array('id' => $cm->instance));
        $context = \context_module::instance($cm->id);
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
                $page = json_decode($this->apicall('get', '/pages/'.$pageid));
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
            $record = new \stdClass;
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
                !($files = $fs->get_area_files($context->id, 'assignfeedback_onenote', self::ASSIGNFEEDBACK_ONENOTE_FILEAREA,
                        $gradeid, 'id', false))) {
                if ($isteacher) {
                    // This must be the first time teacher is looking at student's submission
                    // So prepare feedback page from submission zip package.
                    $files = $fs->get_area_files($context->id, 'assignsubmission_onenote', self::ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                        $submissionid, 'id', false);

                    if ($files) {
                        // Unzip the submission and prepare postdata from it.
                        $tempfolder = $this->create_temp_folder();
                        $fp = get_file_packer('application/zip');
                        $filelist = $fp->extract_to_pathname(reset($files), $tempfolder);

                        $a = new \stdClass;
                        $a->assign_name = $assign->name;
                        $a->student_firstname = $student->firstname;
                        $a->student_lastname = $student->lastname;
                        $postdata = $this->create_postdata_from_folder(
                            get_string('feedbacktitle', 'local_onenote', $a),
                            join(DIRECTORY_SEPARATOR, array(rtrim($tempfolder, DIRECTORY_SEPARATOR), '0')), $boundary);
                    } else {
                        // Student did not turn in a submission, so create an empty one.
                        $a = new \stdClass;
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

                $a = new \stdClass;
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
                !($files = $fs->get_area_files($context->id, 'assignsubmission_onenote', self::ASSIGNSUBMISSION_ONENOTE_FILEAREA,
                    $submissionid, 'id', false))) {
                if ($isteacher) {
                    return null;
                } else {
                    // This is a student and they are just starting to work on this assignment.
                    // So prepare page from the assignment prompt.
                    $a = new \stdClass;
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

                $a = new \stdClass;
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
        if ($response == 'connection_error') {
            for ($i = 0; $i < 3; $i++) {
                $response = $this->create_page_from_postdata($sectionid, $postdata, $boundary);

                // If we get proper response then break the loop.
                if ($response != 'connection_error') {
                    break;
                }
                usleep(500000);
            }
        }

        // If still there is connection error, return it.
        if ($response == 'connection_error') {
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

    /**
     * Returns the section record associated with the given course and student.
     * Also ensures that we are in sync with OneNote notebooks and section and try to sync up if we are not.
     *
     * @param int $courseid Course ID to get.
     * @param int $userid ID of user to get.
     * @return stdClass|null Either the found section, or null if not found.
     */
    protected function get_section($courseid, $userid) {
        global $DB;

        $section = $DB->get_record('onenote_user_sections', array("course_id" => $courseid, "user_id" => $userid));

        // Need to make sure section actually exists in case user may have deleted it.
        if ($section && $section->section_id) {
            $onenotesection = json_decode($this->apicall('get', '/sections/'.$section->section_id));
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

    /**
     * Return the contents of the file, given its path, filename, and context.
     * @param string $path Path to the file.
     * @param string $filename File name.
     * @param int $contextid The context associated with the file.
     * @return array Array containing the file name and content.
     */
    protected function get_file_contents($path, $filename, $contextid) {
        // Get file contents.
        $fs = get_file_storage();

        // Prepare file record object.
        $fileinfo = [
            'component' => 'mod_assign',     // Usually = table name.
            'filearea' => 'intro',     // Usually = table name.
            'itemid' => 0,               // Usually = ID of row in table.
            'contextid' => $contextid, // ID of context.
            'filepath' => $path,           // Any path beginning and ending in /.
            'filename' => $filename
        ];

        // Get file.
        $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'],
                $fileinfo['filepath'], $fileinfo['filename']);

        $contents = array();

        if ($file) {
            $contents['filename'] = $file->get_filename();
            $contents['content'] = $file->get_content();
        }

        return $contents;
    }

    /**
     * Given the content of an HTML page, create postdata suitable for posting to OneNote for creating the page.
     *
     * @param string $title Page title.
     * @param string $bodycontent String containing HTML for the page body.
     * @param int $contextid Context associated with the page.
     * @param string $boundary Boundary string to be used during the POST request.
     * @return string Postdata suitable for posting to OneNote to create the page.
     */
    protected function create_postdata($title, $bodycontent, $contextid, $boundary) {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($bodycontent, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);
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
        $domclone = new \DOMDocument('1.0', 'UTF-8');
        foreach ($doc->childNodes as $child) {
            $domclone->appendChild($domclone->importNode($child, true));
        }

        $output = $domclone->saveHTML($domclone);

        $date = date("Y-m-d H:i:s");

        $postdata = '';
        $postdata .= '--' . $boundary . $eol;
        $postdata .= 'Content-Disposition: form-data; name="Presentation"' . $eol;
        $postdata .= 'Content-Type: application/xhtml+xml' . $eol . $eol;
        $postdata .= '<?xml version="1.0" encoding="utf-8" ?><html xmlns="http://www.w3.org/1999/xhtml" lang="en-us">' . $eol;
        $postdata .= '<head><title>' . $title . '</title>' . '<meta name="created" value="' . $date . '"/></head>' . $eol;
        $postdata .= '<body style="font-family:\'Helvetica\',Arial,sans-serif;font-size:10.5pt; color:rgb(51,51,51);">' .
                $output . '</body>' . $eol;
        $postdata .= '</html>' . $eol;
        $postdata .= $imgdata . $eol;
        $postdata .= '--' . $boundary . '--' . $eol . $eol;

        return $postdata;
    }

    /**
     * Given the path to the HTML page folder, create postdata suitable for posting to OneNote for creating the page.
     * @param string $title Page title.
     * @param string $folder Path to the folder that contains the page HTML and subfolders containing any associated images.
     * @param string $boundary Boundary string to be used during the POST request.
     * @return string Postdata suitable for posting to OneNote to create the page.
     */
    protected function create_postdata_from_folder($title, $folder, $boundary) {
        $dom = new \DOMDocument();

        $pagefile = join(DIRECTORY_SEPARATOR, array(rtrim($folder, DIRECTORY_SEPARATOR), 'page.html'));
        if (!$dom->loadHTML(mb_convert_encoding(file_get_contents($pagefile), 'HTML-ENTITIES', 'UTF-8'))) {
            return null;
        }
        $xpath = new \DOMXPath($dom);
        $doc = $dom->getElementsByTagName("body")->item(0);

        $this->handle_garbage_chars($xpath);

        $imgnodes = $xpath->query("//img");
        $imgdata = '';
        $eol = "\r\n";

        if ($imgnodes && ($imgnodes->length > 0)) {
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
        $domclone = new \DOMDocument('1.0', 'UTF-8');
        foreach ($doc->childNodes as $child) {
            $domclone->appendChild($domclone->importNode($child, true));
        }

        $output = $domclone->saveHTML($domclone);
        $date = date("Y-m-d H:i:s");

        $postdata = '';
        $postdata .= '--' . $boundary . $eol;
        $postdata .= 'Content-Disposition: form-data; name="Presentation"' . $eol;
        $postdata .= 'Content-Type: application/xhtml+xml' . $eol . $eol;
        $postdata .= '<?xml version="1.0" encoding="utf-8" ?><html xmlns="http://www.w3.org/1999/xhtml" lang="en-us">' . $eol;
        $postdata .= '<head><title>' . $title . '</title>' . '<meta name="created" value="' . $date . '"/></head>' . $eol;
        $postdata .= '<body style="font-family:\'Helvetica\',\'Helvetica Neue\', Arial, \'Lucida Grande\',';
        $postdata .= 'sans-serif;font-size:10.5pt; color:rgb(51,51,51);">' . $output . '</body>' . $eol;
        $postdata .= '</html>' . $eol;
        $postdata .= $imgdata . $eol;
        $postdata .= '--' . $boundary . '--' . $eol . $eol;

        return $postdata;
    }

    /**
     * Create a OneNote page inside the given section using the postdata containing the content of the page.
     * @param string $sectionid Id of OneNote section which the page will be created in.
     * @param string $postdata String containing the postdata containing the contents of the page.
     * @param string $boundary Boundary string to be used during the POST request.
     * @return mixed|null|string The HTTP response object from the POST request.
     */
    protected function create_page_from_postdata($sectionid, $postdata, $boundary) {

        $url = static::API.'/sections/'.$sectionid.'/pages';
        $token = $this->get_token();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $headers = [
            'Content-Type: multipart/form-data; boundary='.$boundary,
            'Authorization: Bearer '.rawurlencode($token)
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

        $rawresponse = curl_exec($ch);

        // Check if curl call fails.
        if ($rawresponse === false) {
            $errorno = curl_errno($ch);
            curl_close($ch);

            // If curl call fails and reason is net connectivity return it or return null.
            return (in_array($errorno, ['6', '7', '28'])) ? 'connection_error' : null;
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

    /**
     * HACKHACK: Remove this once OneNote fixes their bug.
     * OneNote has a bug that occurs with HTML containing consecutive <br/> tags.
     * The workaround is to replace the last <br/> in a sequence with a <p/>.
     * @param $xpath The xpath object associdated with the HTML DOM for the page.
     */
    protected function process_br_tags($xpath) {
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

                $pnode = new \DOMElement('p', '&nbsp;');
                $brnode->parentNode->replaceChild($pnode, $brnode);
                $index++;
            }
        }
    }

    /**
     * HACKHACK: Remove this once OneNote fixes their bug.
     * OneNote has a bug that occurs with HTML containing consecutive <br/> tags.
     * They get converted into garbage chars like ￼. Replace them with <p/> tags.
     * @param $xpath The xpath object associdated with the HTML DOM for the page.
     */
    protected function handle_garbage_chars($xpath) {
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
                    $pnode = new \DOMElement('p', '&nbsp;');
                    $garbagenode->parentNode->insertBefore($pnode, $garbagenode->nextSibling);
                }

                $index++;
            }
        }
    }

    /**
     * Create a temporary folder for storing the contents of an assignment submission or feedback page and return its path.
     *
     * @return null|string Path to the temp folder created.
     */
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


    /**
     * Check if given user is a teacher capable of grading assignments in the given course.
     *
     * @param int $cmid Course module id.
     * @param int $userid User id to be checked.
     * @return bool Whether the user is a grading user within a course.
     */
    public function is_teacher($cmid, $userid) {
        $context = \context_module::instance($cmid);
        return has_capability('mod/assign:grade', $context, $userid);

    }

    /**
     * Check if given user is a student capable of submitting assignment in the given course.
     *
     * @param int $cmid Course module id.
     * @param int $userid User id to be checked.
     * @return bool Whether the user can submit assignments.
     */
    public function is_student($cmid, $userid) {
        $context = \context_module::instance($cmid);
        return has_capability('mod/assign:submit', $context, $userid);

    }

    /**
     * Function to add span elements for heading and td tags and respective font sizes.
     * This is done becaues OneNote supports a subset of the full HTML and it needs a span element to specify font attributes.
     *
     * @param $dom HTML DOM of the page being processed.
     * @param $xpath XPath object associated with the HTML page.
     */
    protected function process_tags($dom, $xpath) {

        // List of tags we are processing.
        $tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'td');

        // Font sizes for each tag.
        $tagfontsizes = array('h1' => '24px', 'h2' => '22px', 'h3' => '18px',
            'h4' => '16px', 'h5' => '12px', 'h6' => '10px' , 'td' => '10.5pt');

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
     * HACKHACK: Remove this once OneNote supports more font related features.
     * Function to increase the span font size to make downloaded html look better. This is used to process
     * the HTML of the page downloaded from OneNote.
     *
     * @param $xpath XPath object assoicated with the HTML page.
     */
    protected function process_span_tags($xpath) {

        // Get all the span tags.
        $spannodes = $xpath->query('//span');

        if ($spannodes->length) {

            foreach ($spannodes as $span) {
                $style = $span->getAttribute('style');
                // Replace 12px font size with 10.5pt.
                $span->setAttribute('style', str_replace('font-size:12px', 'font-size:10.5pt', $style));
            }
        }
    }
}
