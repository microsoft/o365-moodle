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
 * API client for o365 onedrive.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\rest;

defined('MOODLE_INTERNAL') || die();

/**
 * API client for o365 onedrive.
 */
class onedrive extends \local_o365\rest\o365api {
    /**
     * @var string The general API area of the class.
     */
    public $apiarea = 'onedrive';

    /**
     * @var string An override for the API url.
     */
    protected $apiurioverride = null;

    /**
     * @var bool
     */
    public $usespapi = false;

    /**
     * Determine if the API client is configured.
     *
     * @return bool Whether the API client is configured.
     */
    public static function is_configured() {
        $config = get_config('local_o365');
        return (!empty($config->odburl)) ? true : false;
    }

    /**
     * Validate that a given url is a valid OneDrive for Business SharePoint URL.
     *
     * @param string $resource Uncleaned, unvalidated URL to check.
     * @param \local_o365\oauth2\clientdata $clientdata oAuth2 Credentials
     * @param \local_o365\httpclientinterface $httpclient An HttpClient to use for transport.
     * @return bool Whether the received resource is valid or not.
     */
    public static function validate_resource($resource, \local_o365\oauth2\clientdata $clientdata,
                                             \local_o365\httpclientinterface $httpclient) {
        $cleanresource = clean_param($resource, PARAM_URL);
        if ($cleanresource !== $resource) {
            return false;
        }
        $fullcleanresource = 'https://'.$cleanresource;
        $token = \local_o365\utils::get_app_or_system_token($fullcleanresource, $clientdata, $httpclient);
        return (!empty($token)) ? true : false;
    }

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_tokenresource() {
        $config = get_config('local_o365');
        if (!empty($config->odburl)) {
            return 'https://'.$config->odburl;
        } else {
            return false;
        }
    }

    /**
     * Get the embedding URL for a given file id.
     *
     * @param string $fileid The ID of the file (from the odb api).
     * @param string $fileurl The o365 webUrl property of the file.
     * @return string|null The URL to be embedded, or null if error.
     */
    public function get_embed_url($fileid, $fileurl = '') {
        if (empty($fileurl)) {
            $fileinfo = $this->get_file_metadata($fileid);
            if (isset($fileinfo['webUrl'])) {
                $fileurl = $fileinfo['webUrl'];
            }
        }
        if (!empty($fileurl)) {
            $odburl = $this->get_tokenresource();
            if (strpos($fileurl, $odburl) === 0) {
                $filerelative = substr($fileurl, strlen($odburl));
                $filerelativeparts = explode('/', trim($filerelative, '/'));
                $spapiurl = $odburl.'/'.$filerelativeparts[0].'/'.$filerelativeparts[1].'/_api';
                $this->apiurioverride = $spapiurl;
                if (substr($filerelative, -6) === '?web=1') {
                    $filerelative = substr($filerelative, 0, -6);
                }
                $endpoint = '/web/GetFileByServerRelativeUrl(\''.$filerelative.'\')/ListItemAllFields/GetWOPIFrameUrl(3)';
                $response = $this->apicall('post', $endpoint);
                unset($this->apiurioverride);
                $expectedparams = ['value' => null];
                return $this->process_apicall_response($response, $expectedparams);
            }
        }
        return null;
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        if (!empty($this->apiurioverride)) {
            return $this->apiurioverride;
        }
        if ($this->usespapi === true) {
            return static::get_tokenresource().'/_api';
        } else {
            return static::get_tokenresource().'/_api/v1.0/me/Files';
        }
    }

    /**
     * Get the contents of a folder.
     *
     * @param string $path The path to read.
     * @return array|null Returned response, or null if error.
     */
    public function get_contents($path) {
        $path = rawurlencode($path);
        $response = $this->apicall('get', "/getByPath('{$path}')/children");
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a file by it's file id.
     *
     * @param string $fileid The file's ID.
     * @return string The file's content.
     */
    public function get_file_by_id($fileid) {
        return $this->apicall('get', "/{$fileid}/content");
    }

    /**
     * Get a file's metadata by it's file id.
     *
     * @param string $fileid The file's ID.
     * @return string The file's content.
     */
    public function get_file_metadata($fileid) {
        $response = $this->apicall('get', "/{$fileid}");
        $expectedparams = ['id' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get information about a folder.
     *
     * @param string $path The folder path.
     * @return array Array of folder information.
     */
    public function get_folder_metadata($path) {
        $path = rawurlencode($path);
        $response = $this->apicall('get', "/getByPath('{$path}')");
        $expectedparams = ['id' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Create a new file.
     *
     * @param string $folderpath The path to the file.
     * @param string $filename The name of the file.
     * @param string $content The file's contents.
     * @return array Result.
     */
    public function create_file($folderpath, $filename, $content) {
        $parentinfo = $this->get_folder_metadata($folderpath);
        if (is_array($parentinfo) && isset($parentinfo['id'])) {
            $filename = rawurlencode($filename);
            $url = '/'.$parentinfo['id'].'/children/'.$filename.'/content?nameConflict=overwrite';
            $params = ['file' => $content];
            $response = $this->apicall('put', $url, $params);
            $expectedparams = ['id' => null];
            return $this->process_apicall_response($response, $expectedparams);
        } else {
            throw new \moodle_exception('erroro365apinoparentinfo', 'local_o365');
        }
    }

    /**
     * Make an API call.
     *
     * @param string $httpmethod The HTTP method to use. get/post/patch/merge/delete.
     * @param string $apimethod The API endpoint/method to call.
     * @param string $params Additional paramters to include.
     * @param array $options Additional options for the request.
     * @return string The result of the API call.
     */
    public function apicall($httpmethod, $apimethod, $params = '', $options = array()) {
        $options['CURLOPT_SSLVERSION'] = 4;
        return parent::apicall($httpmethod, $apimethod, $params, $options);
    }
}
