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
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

/**
 * Office 365 repository.
 */
class repository_office365 extends \repository {
    /** @var \stdClass The auth_oidc config options. */
    protected $oidcconfig;

    /** @var \stdClass The local_o365 config options. */
    protected $o365config;

    /** @var \local_o365\httpclient An HTTP client to use. */
    protected $httpclient;

    /** @var array Array of onedrive status and token information. */
    protected $onedrive = ['configured' => false];

    /** @var array Array of sharepoint status and token information. */
    protected $sharepoint = ['configured' => false];

    /** @var \local_o365\oauth2\clientdata A clientdata object to use with an o365 api class. */
    protected $clientdata = null;

    /**
     * Constructor
     *
     * @param int $repositoryid repository instance id
     * @param int|stdClass $context a context id or context object
     * @param array $options repository options
     * @param int $readonly indicate this repo is readonly or not
     */
    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = array(), $readonly = 0) {
        parent::__construct($repositoryid, $context, $options, $readonly);
        global $DB, $USER;

        $this->o365config = get_config('local_o365');
        $this->oidcconfig = get_config('auth_oidc');
        $this->httpclient = new \local_o365\httpclient();

        if (empty($this->oidcconfig)) {
            throw new \moodle_exception('errorauthoidcnotconfig', 'repository_office365');
        }

        $this->clientdata = new \local_o365\oauth2\clientdata($this->oidcconfig->clientid, $this->oidcconfig->clientsecret,
                    $this->oidcconfig->authendpoint, $this->oidcconfig->tokenendpoint);

        $this->onedrive['configured'] = \local_o365\rest\onedrive::is_configured();
        $this->sharepoint['configured'] = \local_o365\rest\sharepoint::is_configured();
    }

    /**
     * Get a OneDrive token.
     *
     * @return \local_o365\oauth2\token A OneDrive token object.
     */
    protected function get_onedrive_token() {
        global $USER;
        $resource = \local_o365\rest\onedrive::get_resource();
        return \local_o365\oauth2\token::instance($USER->id, $resource, $this->clientdata, $this->httpclient);
    }

    /**
     * Get a SharePoint token.
     *
     * @return \local_o365\oauth2\token A SharePoint token object.
     */
    protected function get_sharepoint_token() {
        global $USER;
        $resource = \local_o365\rest\sharepoint::get_resource();
        return \local_o365\oauth2\token::instance($USER->id, $resource, $this->clientdata, $this->httpclient);
    }

    /**
     * Get a onedrive API client.
     *
     * @return \local_o365\rest\onedrive A onedrive API client object.
     */
    protected function get_onedrive_apiclient() {
        if ($this->onedrive['configured'] === true) {
            $token = $this->get_onedrive_token();
            if (!empty($token)) {
                return new \local_o365\rest\onedrive($token, $this->httpclient);
            }
        }
        return false;
    }

    /**
     * Get a sharepoint API client.
     *
     * @return \local_o365\rest\sharepoint A sharepoint API client object.
     */
    protected function get_sharepoint_apiclient() {
        if ($this->sharepoint['configured'] === true) {
            $token = $this->get_sharepoint_token();
            if (!empty($token)) {
                return new \local_o365\rest\sharepoint($token, $this->httpclient);
            }
        }
        return false;
    }

    /**
     * Given a path, and perhaps a search, get a list of files.
     *
     * See details on {@link http://docs.moodle.org/dev/Repository_plugins}
     *
     * @param string $path this parameter can a folder name, or a identification of folder
     * @param string $page the page number of file list
     * @return array the list of files, including meta infomation, containing the following keys
     *           manage, url to manage url
     *           client_id
     *           login, login form
     *           repo_id, active repository id
     *           login_btn_action, the login button action
     *           login_btn_label, the login button label
     *           total, number of results
     *           perpage, items per page
     *           page
     *           pages, total pages
     *           issearchresult, is it a search result?
     *           list, file list
     *           path, current path and parent path
     */
    public function get_listing($path = '', $page = '') {
        global $OUTPUT, $SESSION;

        $clientid = optional_param('client_id', '', PARAM_TEXT);
        if (!empty($clientid)) {
            $SESSION->repository_office365['curpath'][$clientid] = $path;
        }

        // If we were launched from a course context (or child of course context), initialize the file picker in the correct course.
        if (!empty($this->context)) {
            $context = $this->context->get_course_context(false);
        }
        if (empty($context)) {
            $context = \context_system::instance();
        }
        if ($context instanceof \context_course) {
            if (empty($path)) {
                $path = '/courses/'.$context->instanceid;
            }
        }

        $list = [];
        $breadcrumb = [['name' => $this->name, 'path' => '/']];

        $onedriveactive = false;
        if ($this->onedrive['configured'] === true) {
            $onedrivetoken = $this->get_onedrive_token();
            if (!empty($onedrivetoken)) {
                $onedriveactive = true;
            }
        }

        $sharepointactive = false;
        if ($this->sharepoint['configured'] === true) {
            $sharepointtoken = $this->get_sharepoint_token();
            if (!empty($sharepointtoken)) {
                $sharepointactive = true;
            }
        }

        if (strpos($path, '/my/') === 0) {
            if ($onedriveactive === true) {
                // Path is in my files.
                list($list, $breadcrumb) = $this->get_listing_my(substr($path, 3));
            }
        } else if (strpos($path, '/courses/') === 0) {
            if ($sharepointactive === true) {
                // Path is in course files.
                list($list, $breadcrumb) = $this->get_listing_course(substr($path, 8));
            }
        } else {
            if ($onedriveactive === true) {
                $list[] = [
                    'title' => get_string('myfiles', 'repository_office365'),
                    'path' => '/my/',
                    'thumbnail' => $OUTPUT->pix_url(file_folder_icon(90))->out(false),
                    'children' => [],
                ];
            }
            if ($sharepointactive === true) {
                $list[] = [
                    'title' => get_string('courses', 'repository_office365'),
                    'path' => '/courses/',
                    'thumbnail' => $OUTPUT->pix_url(file_folder_icon(90))->out(false),
                    'children' => [],
                ];
            }
        }

        if ($this->path_is_upload($path) === true) {
            return [
                'dynload' => true,
                'nologin' => true,
                'nosearch' => true,
                'path' => $breadcrumb,
                'upload' => [
                    'label' => get_string('file', 'repository_office365'),
                ],
            ];
        }

        return [
            'dynload' => true,
            'nologin' => true,
            'nosearch' => true,
            'list' => $list,
            'path' => $breadcrumb,
        ];
    }

    /**
     * Determine whether a given path is an upload path.
     *
     * @param string $path A path to check.
     * @return bool Whether the path is an upload path.
     */
    protected function path_is_upload($path) {
        return (substr($path, -strlen('/upload/')) === '/upload/') ? true : false;
    }

    /**
     * Process uploaded file.
     *
     * @return array Array of uploaded file information.
     */
    public function upload($saveasfilename, $maxbytes) {
        global $CFG, $USER, $SESSION;

        $types = optional_param_array('accepted_types', '*', PARAM_RAW);
        $savepath = optional_param('savepath', '/', PARAM_PATH);
        $itemid = optional_param('itemid', 0, PARAM_INT);
        $license = optional_param('license', $CFG->sitedefaultlicense, PARAM_TEXT);
        $author = optional_param('author', '', PARAM_TEXT);
        $areamaxbytes = optional_param('areamaxbytes', FILE_AREA_MAX_BYTES_UNLIMITED, PARAM_INT);
        $overwriteexisting = optional_param('overwrite', false, PARAM_BOOL);
        $clientid = optional_param('client_id', '', PARAM_TEXT);

        $filepath = '/';
        if (!empty($SESSION->repository_office365)) {
            if (isset($SESSION->repository_office365['curpath']) && isset($SESSION->repository_office365['curpath'][$clientid])) {
                $filepath = $SESSION->repository_office365['curpath'][$clientid];
                if (strpos($filepath, '/my/') === 0) {
                    $clienttype = 'onedrive';
                    $filepath = substr($filepath, 3);
                } else if (strpos($filepath, '/courses/') === 0) {
                    $clienttype = 'sharepoint';
                    $filepath = substr($filepath, 8);
                } else {
                    throw new \moodle_exception('errorbadclienttype', 'repository_office365');
                }
            }
        }
        if ($this->path_is_upload($filepath) === true) {
            $filepath = substr($filepath, 0, -strlen('/upload/'));
        }
        $filename = (!empty($saveasfilename)) ? $saveasfilename : $_FILES['repo_upload_file']['name'];
        $filename = clean_param($filename, PARAM_FILE);
        $content = file_get_contents($_FILES['repo_upload_file']['tmp_name']);

        if ($clienttype === 'onedrive') {
            $onedrive = $this->get_onedrive_apiclient();
            $result = $onedrive->create_file($filepath, $filename, $content);
            $source = $this->pack_reference(['id' => $result['id'], 'source' => $clienttype]);
        } else if ($clienttype === 'sharepoint') {
            $pathtrimmed = trim($filepath, '/');
            $pathparts = explode('/', $pathtrimmed);
            if (!is_numeric($pathparts[0])) {
                throw new \moodle_exception('errorbadpath', 'repository_office365');
            }
            $courseid = (int)$pathparts[0];
            unset($pathparts[0]);
            $relpath = (!empty($pathparts)) ? implode('/', $pathparts) : '';
            $fullpath = (!empty($relpath)) ? '/'.$relpath : '/';
            $courses = enrol_get_users_courses($USER->id);
            if (!isset($courses[$courseid])) {
                throw new \moodle_exception('erroraccessdenied', 'repository_office365');
            }
            $curcourse = $courses[$courseid];
            unset($courses);
            $sharepoint = $this->get_sharepoint_apiclient();
            $parentsiteuri = $sharepoint->get_course_subsite_uri($curcourse->id);
            $sharepoint->set_site($parentsiteuri);
            $result = $sharepoint->create_file($fullpath, $filename, $content);
            $source = $this->pack_reference(['id' => $result['id'], 'source' => $clienttype, 'parentsiteuri' => $parentsiteuri]);
        } else {
            throw new \moodle_exception('errorbadclienttype', 'repository_office365');
        }

        $downloadedfile = $this->get_file($source, $filename);
        $record = new \stdClass;
        $record->filename = $filename;
        $record->filepath = $savepath;
        $record->component = 'user';
        $record->filearea = 'draft';
        $record->itemid = $itemid;
        $record->license = $license;
        $record->author = $author;
        $usercontext = \context_user::instance($USER->id);
        $now = time();
        $record->contextid = $usercontext->id;
        $record->timecreated = $now;
        $record->timemodified = $now;
        $record->userid = $USER->id;
        $record->sortorder = 0;
        $record->source = $this->build_source_field($source);
        $info = \repository::move_to_filepool($downloadedfile['path'], $record);
        return $info;
    }

    /**
     * Get listing for a course folder.
     *
     * @param string $path Folder path.
     * @return array List of $list array and $path array.
     */
    protected function get_listing_course($path = '') {
        global $USER, $OUTPUT;

        $list = [];
        $breadcrumb = [
            ['name' => $this->name, 'path' => '/'],
            ['name' => 'Courses', 'path' => '/courses/'],
        ];

        $reqcap = \local_o365\rest\sharepoint::get_course_site_required_capability();
        $courses = get_user_capability_course($reqcap, $USER->id, true, 'shortname');
        // Reindex courses array using course id.
        $coursesbyid = [];
        foreach ($courses as $i => $course) {
            $coursesbyid[$course->id] = $course;
            unset($courses[$i]);
        }
        unset($courses);

        if ($path === '/') {
            // Show available courses.
            foreach ($coursesbyid as $course) {
                $list[] = [
                    'title' => $course->shortname,
                    'path' => '/courses/'.$course->id,
                    'thumbnail' => $OUTPUT->pix_url(file_folder_icon(90))->out(false),
                    'children' => [],
                ];
            }
        } else {
            $pathtrimmed = trim($path, '/');
            $pathparts = explode('/', $pathtrimmed);
            if (!is_numeric($pathparts[0])) {
                throw new \moodle_exception('errorbadpath', 'repository_office365');
            }
            $courseid = (int)$pathparts[0];
            unset($pathparts[0]);
            $relpath = (!empty($pathparts)) ? implode('/', $pathparts) : '';
            if (isset($coursesbyid[$courseid])) {
                if ($this->path_is_upload($path) === false) {
                    $sharepointclient = $this->get_sharepoint_apiclient();
                    if (!empty($sharepointclient)) {
                        $parentsiteuri = $sharepointclient->get_course_subsite_uri($coursesbyid[$courseid]->id);
                        $sharepointclient->set_site($parentsiteuri);
                        try {
                            $fullpath = (!empty($relpath)) ? '/'.$relpath : '/';
                            $contents = $sharepointclient->get_files($fullpath);
                            $list = $this->contents_api_response_to_list($contents, $path, 'sharepoint', $parentsiteuri);
                        } catch (\Exception $e) {
                            $list = [];
                        }
                    }
                }

                $curpath = '/courses/'.$courseid;
                $breadcrumb[] = ['name' => $coursesbyid[$courseid]->shortname, 'path' => $curpath];
                foreach ($pathparts as $pathpart) {
                    if (!empty($pathpart)) {
                        $curpath .= '/'.$pathpart;
                        $breadcrumb[] = ['name' => $pathpart, 'path' => $curpath];
                    }
                }
            }
        }

        return [$list, $breadcrumb];
    }

    /**
     * Get listing for a personal onedrive folder.
     *
     * @param string $path Folder path.
     * @return array List of $list array and $path array.
     */
    protected function get_listing_my($path = '') {
        global $OUTPUT;
        $path = (empty($path)) ? '/' : $path;

        $list = [];
        if ($this->path_is_upload($path) !== true) {
            $onedrive = $this->get_onedrive_apiclient();
            $contents = $onedrive->get_contents($path);
            $list = $this->contents_api_response_to_list($contents, $path, 'onedrive');
        } else {
            $list = [];
        }

        // Generate path.
        $strmyfiles = get_string('myfiles', 'repository_office365');
        $breadcrumb = [['name' => $this->name, 'path' => '/'], ['name' => $strmyfiles, 'path' => '/my/']];
        $pathparts = explode('/', $path);
        $curpath = '/my';
        foreach ($pathparts as $pathpart) {
            if (!empty($pathpart)) {
                $curpath .= '/'.$pathpart;
                $breadcrumb[] = ['name' => $pathpart, 'path' => $curpath];
            }
        }
        return [$list, $breadcrumb];
    }

    /**
     * Transform a onedrive API response for a folder into a list parameter that the respository class can understand.
     *
     * @param string $response The response from the API.
     * @param string $path The list path.
     * @param string $clienttype The type of client that the response is from. onedrive/sharepoint.
     * @param string $spparentsiteuri If using the Sharepoint clienttype, this is the parent site URI.
     * @return array A $list array to be used by the respository class in get_listing.
     */
    protected function contents_api_response_to_list($response, $path, $clienttype, $spparentsiteuri = null) {
        global $OUTPUT, $DB;
        $list = [];
        if ($clienttype === 'onedrive') {
            $pathprefix = '/my'.$path;
        } else if ($clienttype === 'sharepoint') {
            $pathprefix = '/courses'.$path;
        }

        $list[] = [
            'title' => get_string('upload', 'repository_office365'),
            'path' => $pathprefix.'/upload/',
            'thumbnail' => $OUTPUT->pix_url('a/add_file')->out(false),
            'children' => [],
        ];

        if (isset($response['value'])) {
            foreach ($response['value'] as $content) {
                $itempath = $pathprefix.'/'.$content['name'];
                if ($content['type'] === 'Folder') {
                    $list[] = [
                        'title' => $content['name'],
                        'path' => $itempath,
                        'thumbnail' => $OUTPUT->pix_url(file_folder_icon(90))->out(false),
                        'date' => strtotime($content['dateTimeCreated']),
                        'datemodified' => strtotime($content['dateTimeLastModified']),
                        'datecreated' => strtotime($content['dateTimeCreated']),
                        'children' => [],
                    ];
                } else if ($content['type'] === 'File') {
                    $url = $content['webUrl'].'?web=1';
                    $source = [
                        'id' => $content['id'],
                        'source' => $clienttype,
                    ];
                    if ($clienttype === 'sharepoint') {
                        $source['parentsiteuri'] = $spparentsiteuri;
                    }

                    $author = '';
                    if (!empty($content['createdBy']['user']['displayName'])) {
                        $author = $content['createdBy']['user']['displayName'];
                        $author = explode(',', $author);
                        $author = $author[0];
                    }

                    $list[] = [
                        'title' => $content['name'],
                        'date' => strtotime($content['dateTimeCreated']),
                        'datemodified' => strtotime($content['dateTimeLastModified']),
                        'datecreated' => strtotime($content['dateTimeCreated']),
                        'size' => $content['size'],
                        'url' => $url,
                        'thumbnail' => $OUTPUT->pix_url(file_extension_icon($content['name'], 90))->out(false),
                        'author' => $author,
                        'source' => $this->pack_reference($source),
                    ];
                }
            }

        }
        return $list;
    }

    /**
     * Tells how the file can be picked from this repository
     *
     * Maximum value is FILE_INTERNAL | FILE_EXTERNAL | FILE_REFERENCE
     *
     * @return int
     */
    public function supported_returntypes() {
        return FILE_INTERNAL | FILE_EXTERNAL | FILE_REFERENCE;
    }

    /**
     * Downloads a file from external repository and saves it in temp dir
     *
     * @param string $reference The file reference.
     * @param string $filename filename (without path) to save the downloaded file in the temporary directory, if omitted
     *                         or file already exists the new filename will be generated
     * @return array with elements:
     *   path: internal location of the file
     *   url: URL to the source (from parameters)
     */
    public function get_file($reference, $filename = '') {
        $reference = $this->unpack_reference($reference);

        if ($reference['source'] === 'onedrive') {
            $sourceclient = $this->get_onedrive_apiclient();
        } else if ($reference['source'] === 'sharepoint') {
            $sourceclient = $this->get_sharepoint_apiclient();
            if (isset($reference['parentsiteuri'])) {
                $parentsiteuri = $reference['parentsiteuri'];
            } else {
                $parentsiteuri = $sourceclient->get_moodle_parent_site_uri();
            }
            $sourceclient->set_site($parentsiteuri);
        }
        $file = $sourceclient->get_file_by_id($reference['id']);

        if (!empty($file)) {
            $path = $this->prepare_file($filename);
            if (!empty($path)) {
                $result = file_put_contents($path, $file);
            }
        }
        if (empty($result)) {
            throw new \moodle_exception('errorwhiledownload', 'repository_office365');
        }
        return ['path' => $path, 'url' => $reference];
    }

    /**
     * Pack file reference information into a string.
     *
     * @param array $reference The information to pack.
     * @return string The packed information.
     */
    protected function pack_reference($reference) {
        return base64_encode(serialize($reference));
    }

    /**
     * Unpack file reference information from a string.
     *
     * @param string $reference The information to unpack.
     * @return array The unpacked information.
     */
    protected function unpack_reference($reference) {
        return unserialize(base64_decode($reference));
    }

    /**
     * Prepare file reference information
     *
     * @param string $source source of the file, returned by repository as 'source' and received back from user (not cleaned)
     * @return string file reference, ready to be stored
     */
    public function get_file_reference($source) {
        $sourceunpacked = $this->unpack_reference($source);
        if (isset($sourceunpacked['source']) && isset($sourceunpacked['id'])) {
            $fileid = $sourceunpacked['id'];
            $filesource = $sourceunpacked['source'];

            $reference = [
                'source' => $filesource,
                'id' => $fileid,
                'url' => '',
            ];

            try {
                if ($filesource === 'onedrive') {
                    $sourceclient = $this->get_onedrive_apiclient();
                } else if ($filesource === 'sharepoint') {
                    $sourceclient = $this->get_sharepoint_apiclient();
                    if (isset($sourceunpacked['parentsiteuri'])) {
                        $parentsiteuri = $sourceunpacked['parentsiteuri'];
                    } else {
                        $parentsiteuri = $sourceclient->get_moodle_parent_site_uri();
                    }
                    $sourceclient->set_site($parentsiteuri);
                    $reference['parentsiteuri'] = $parentsiteuri;
                }

                $filemetadata = $sourceclient->get_file_metadata($fileid);
                if (isset($filemetadata['webUrl'])) {
                    $reference['url'] = $filemetadata['webUrl'].'?web=1';
                }
            } catch (\Exception $e) {
                // There was a problem making the API call.
            }

            return $this->pack_reference($reference);
        }
        return $source;
    }

    /**
     * Return file URL, for most plugins, the parameter is the original
     * url, but some plugins use a file id, so we need this function to
     * convert file id to original url.
     *
     * @param string $url the url of file
     * @return string
     */
    public function get_link($url) {
        $reference = $this->unpack_reference($url);
        return $reference['url'];
    }

    /**
     * Repository method to serve the referenced file
     *
     * @see send_stored_file
     *
     * @param stored_file $storedfile the file that contains the reference
     * @param int $lifetime Number of seconds before the file should expire from caches (null means $CFG->filelifetime)
     * @param int $filter 0 (default)=no filtering, 1=all files, 2=html files only
     * @param bool $forcedownload If true (default false), forces download of file rather than view in browser/plugin
     * @param array $options additional options affecting the file serving
     */
    public function send_file($storedfile, $lifetime=null , $filter=0, $forcedownload=false, array $options = null) {
        $reference = $this->unpack_reference($storedfile->get_reference());

        if ($_SERVER['SCRIPT_NAME'] !== '/draftfile.php') {
            if ($reference['source'] === 'onedrive') {
                $sourceclient = $this->get_onedrive_apiclient();
                $fileurl = (isset($reference['url'])) ? $reference['url'] : '';
                $embedurl = $sourceclient->get_embed_url($reference['id'], $fileurl);
                if (!empty($embedurl)) {
                    header('Location: '.$embedurl);
                    die();
                } else if (!empty($fileurl)) {
                    header('Location: '.$fileurl);
                    die();
                }
            }
        }

        try {
            $fileinfo = $this->get_file($storedfile->get_reference());
            if (isset($fileinfo['path'])) {
                $fs = get_file_storage();
                list($contenthash, $filesize, $newfile) = $fs->add_file_to_pool($fileinfo['path']);
                // Set this file and other similar aliases synchronised.
                $storedfile->set_synchronized($contenthash, $filesize);
            } else {
                throw new \moodle_exception('errorwhiledownload', 'repository_office365');
            }
            if (!is_array($options)) {
                $options = [];
            }
            $options['sendcachedexternalfile'] = true;
            send_stored_file($storedfile, $lifetime, $filter, $forcedownload, $options);
        } catch (\Exception $e) {
            send_file_not_found();
        }
    }
}
