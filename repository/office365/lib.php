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
 * @package repository_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
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
    protected $onedrive = ['configured' => false, 'token' => []];

    /** @var array Array of sharepoint status and token information. */
    protected $sharepoint = ['configured' => false, 'token' => []];

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
            throw new \Exception('AzureAD SSO not configured');
        }

        $this->onedrive['configured'] = \local_o365\rest\onedrive::is_configured();
        if ($this->onedrive['configured'] === true) {
            $onedriveresource = \local_o365\rest\onedrive::get_resource();
            $tokenrec = $DB->get_record('local_o365_token', ['user_id' => $USER->id, 'resource' => $onedriveresource]);
            if (!empty($tokenrec)) {
                $this->onedrive['token'] = $tokenrec;
            }
        }

        $this->sharepoint['configured'] = \local_o365\rest\sharepoint::is_configured();
        if ($this->sharepoint['configured'] === true) {
            if (!empty($this->o365config->systemtokens)) {
                $systemtokens = unserialize($this->o365config->systemtokens);
                $spresource = \local_o365\rest\sharepoint::get_resource();
                if (isset($systemtokens[$spresource])) {
                    $this->sharepoint['token'] = $systemtokens[$spresource];
                }
            }
        }
    }

    /**
     * Get a onedrive API client.
     *
     * @return \local_o365\rest\onedrive A onedrive API client object.
     */
    protected function get_onedrive_apiclient() {
        if ($this->onedrive['configured'] === true && !empty($this->onedrive['token'])) {
            $clientdata = new \local_o365\oauth2\clientdata($this->oidcconfig->clientid, $this->oidcconfig->clientsecret,
                    $this->oidcconfig->authendpoint, $this->oidcconfig->tokenendpoint);
            $token = new \local_o365\oauth2\token($this->onedrive['token']['token'], $this->onedrive['token']['expiry'],
                    $this->onedrive['token']['refreshtoken'], $this->onedrive['token']['scope'],
                    $this->onedrive['token']['resource'], $clientdata, $this->httpclient);
            return new \local_o365\rest\onedrive($token, $this->httpclient);
        }
        return false;
    }

    /**
     * Get a sharepoint API client.
     *
     * @return \local_o365\rest\sharepoint A sharepoint API client object.
     */
    protected function get_sharepoint_apiclient() {
        if ($this->sharepoint['configured'] === true && !empty($this->sharepoint['token'])) {
            $clientdata = new \local_o365\oauth2\clientdata($this->oidcconfig->clientid, $this->oidcconfig->clientsecret,
                    $this->oidcconfig->authendpoint, $this->oidcconfig->tokenendpoint);
            $token = new \local_o365\oauth2\token($this->sharepoint['token']['token'], $this->sharepoint['token']['expiry'],
                    $this->sharepoint['token']['refreshtoken'], $this->sharepoint['token']['scope'],
                    $this->sharepoint['token']['resource'], $clientdata, $this->httpclient);
            return new \local_o365\rest\sharepoint($token, $this->httpclient);
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
        global $OUTPUT;

        // If we were launched from a course context (or child of course context), initialize the file picker in the correct course.
        if (!empty($this->context)) {
            $context = $this->context->get_course_context(false);
        }
        if (empty($context)) {
            $context = \context_system::instance();
        }
        if ($context instanceof \context_course) {
            $path = '/courses/'.$context->instanceid;
        }

        $list = [];
        $breadcrumb = [['name' => $this->name, 'path' => '/']];

        if (strpos($path, '/my/') === 0) {
            if ($this->onedrive['configured'] === true && !empty($this->onedrive['token'])) {
                // Path is in my files.
                list($list, $breadcrumb) = $this->get_listing_my(substr($path, 3));
            }
        } elseif (strpos($path, '/courses/') === 0) {
            if ($this->sharepoint['configured'] === true && !empty($this->sharepoint['token'])) {
                // Path is in course files.
                list($list, $breadcrumb) = $this->get_listing_course(substr($path, 8));
            }
        } else {
            if ($this->onedrive['configured'] === true && !empty($this->onedrive['token'])) {
                $list[] = [
                    'title' => 'My Files',
                    'path' => '/my/',
                    'thumbnail' => $OUTPUT->pix_url(file_folder_icon(90))->out(false),
                    'children' => [],
                ];
            }
            if ($this->sharepoint['configured'] === true && !empty($this->sharepoint['token'])) {
                $list[] = [
                    'title' => 'Courses',
                    'path' => '/courses/',
                    'thumbnail' => $OUTPUT->pix_url(file_folder_icon(90))->out(false),
                    'children' => [],
                ];
            }
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

        $courses = enrol_get_users_courses($USER->id);
        if ($path === '/') {
            // Show available courses.
            foreach ($courses as $course) {
                $list[] = [
                    'title' => $course->shortname,
                    'path' => '/courses/'.$course->id,
                    'thumbnail' => $OUTPUT->pix_url(file_folder_icon(90))->out(false),
                    'children' => [],
                ];
            }
        } else {
            $pathparts = explode('/', $path);
            if (!is_numeric($pathparts[1])) {
                throw new \Exception('Bad path');
            }
            $courseid = (int)$pathparts[1];
            if (isset($courses[$courseid])) {
                $sharepointclient = $this->get_sharepoint_apiclient();
                if (!empty($sharepointclient)) {
                    $sharepointclient->set_site('moodle');
                    try {
                        $contents = $sharepointclient->get_files('/'.$courses[$courseid]->shortname);
                        $list = $this->contents_api_response_to_list($contents, 'sharepoint');
                    } catch (\Exception $e) {
                        $list = [];
                    }
                }
                $breadcrumb[] = ['name' => $courses[$courseid]->shortname, 'path' => '/courses/'.$courseid];
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
        $onedrive = $this->get_onedrive_apiclient();
        $contents = $onedrive->get_contents($path);

        // Generate listing.
        $list = $ths->contents_api_response_to_list($contents, 'onedrive');

        // Generate path.
        $breadcrumb = [['name' => $this->name, 'path' => '/'], ['name' => 'My Files', 'path' => '/my/']];
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
     * @param string $clienttype The type of client that the response is from. onedrive/sharepoint.
     * @return array A $list array to be used by the respository class in get_listing.
     */
    protected function contents_api_response_to_list($response, $clienttype) {
        global $OUTPUT;
        $list = [];
        if (isset($response['value'])) {
            foreach ($response['value'] as $content) {
                $itempath = ($path === '/')
                    ? '/my/'.$content['name']
                    : '/my'.$content['parentReference']['path'].'/'.$content['name'];
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
                } elseif ($content['type'] === 'File') {
                    $list[] = [
                        'title' => $content['name'],
                        'date' => strtotime($content['dateTimeCreated']),
                        'datemodified' => strtotime($content['dateTimeLastModified']),
                        'datecreated' => strtotime($content['dateTimeCreated']),
                        'size' => $content['size'],
                        'thumbnail' => $OUTPUT->pix_url(file_extension_icon($content['name'], 90))->out(false),
                        'author' => $content['createdBy']['user']['displayName'],
                        'source' => base64_encode(serialize(['id' => $content['id'], 'source' => $clienttype])),
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
        return FILE_INTERNAL;
    }

    /**
     * Downloads a file from external repository and saves it in temp dir
     *
     * @param string $fileid A base64_encoded, serialized array of the file's fileid and the file's source.
     * @param string $filename filename (without path) to save the downloaded file in the temporary directory, if omitted
     *                         or file already exists the new filename will be generated
     * @return array with elements:
     *   path: internal location of the file
     *   url: URL to the source (from parameters)
     */
    public function get_file($fileid, $filename = '') {
        $fileid = unserialize(base64_decode($fileid));

        if ($fileid['source'] === 'onedrive') {
            $sourceclient = $this->get_onedrive_apiclient();
        } elseif ($fileid['source'] === 'sharepoint') {
            $sourceclient = $this->get_sharepoint_apiclient();
            $sourceclient->set_site('moodle');
        }
        $file = $sourceclient->get_file_by_id($fileid['id']);

        if (!empty($file)) {
            $path = $this->prepare_file($filename);
            $result = file_put_contents($path, $file);
        }
        if (empty($result)) {
            throw new moodle_exception('errorwhiledownload', 'repository_office365');
        }
        return ['path' => $path, 'url' => $fileid];
    }
}
