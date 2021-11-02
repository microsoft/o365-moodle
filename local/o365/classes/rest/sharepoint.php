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
 * API client for SharePoint.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\rest;

/**
 * API client for SharePoint.
 */
class sharepoint extends \local_o365\rest\o365api {
    /**
     * @var string The general API area of the class.
     */
    public $apiarea = 'sharepoint';

    /** @var string The site we're accessing. */
    protected $parentsite = '';

    /**
     * Validate that a given SharePoint url is accessible with the given client data.
     *
     * @param string $uncleanurl Uncleaned, unvalidated URL to check.
     * @param \local_o365\oauth2\clientdata $clientdata oAuth2 Credentials
     * @param \local_o365\httpclientinterface $httpclient An HttpClient to use for transport.
     * @return string One of:
     *                    "invalid" : The URL is not a usable SharePoint url.
     *                    "notempty" : The URL is a usable SharePoint url, and the SharePoint site exists.
     *                    "valid" : The URL is a usable SharePoint url, and the SharePoint site doesn't exist.
     */
    public static function validate_site($uncleanurl, \local_o365\oauth2\clientdata $clientdata,
                                         \local_o365\httpclientinterface $httpclient) {
        // Ensure url starts with https.
        $uncleanurl = preg_replace('/^https?:\/\//', '', $uncleanurl);
        $uncleanurl = 'https://'.$uncleanurl;
        $siteinfo = static::parse_site_url($uncleanurl);
        if (empty($siteinfo)) {
            return 'invalid';
        }

        $token = \local_o365\utils::get_app_or_system_token($siteinfo['tokenresource'], $clientdata, $httpclient);
        if (empty($token)) {
            return 'invalid';
        }

        $sharepoint = new \local_o365\rest\sharepoint($token, $httpclient);
        $sharepoint->override_tokenresource($siteinfo['tokenresource']);

        // Try to get the / site's info to validate we can communicate with this parent SharePoint site.
        try {
            $mainsiteinfo = $sharepoint->get_site();
        } catch (\Exception $e) {
            return 'invalid';
        }

        if ($siteinfo['subsiteurl'] === '/') {
            // We just successfully got the / site's info, so if we're going to use that, it's obviously not empty.
            return 'notempty';
        }

        $subsiteexists = $sharepoint->site_exists($siteinfo['subsiteurl']);
        return ($subsiteexists === true) ? 'notempty' : 'valid';
    }

    /**
     * Validate and parse a SharePoint URL into a resource and subsite path.
     *
     * @param string $url The URL to validate and parse.
     * @return array|bool The parsed URL into 'resource' and 'subsiteurl' keys, or false if invalid.
     */
    public static function parse_site_url($url) {
        $caller = 'rest\sharepoint::parse_site_url';
        $cleanurl = clean_param($url, PARAM_URL);
        if ($cleanurl !== $url) {
            $errmsg = 'Site url failed clean_param';
            $debugdata = ['orig' => $url, 'clean' => $cleanurl];
            \local_o365\utils::debug($errmsg, $caller, $debugdata);
            return false;
        }
        if (strpos($cleanurl, 'https://') !== 0) {
            $errmsg = 'Site url was not https.';
            \local_o365\utils::debug($errmsg, $caller, $cleanurl);
            return false;
        }

        $cleanurlparts = parse_url($cleanurl);
        if (empty($cleanurlparts) || empty($cleanurlparts['host'])) {
            $errmsg = 'Site url failed parse_url.';
            $debugdata = ['cleanurl' => $cleanurl, 'parts' => $cleanurlparts];
            \local_o365\utils::debug($errmsg, $caller, $debugdata);
            return false;
        }

        return [
            'tokenresource' => 'https://'.$cleanurlparts['host'],
            'subsiteurl' => (!empty($cleanurlparts['path'])) ? $cleanurlparts['path'] : '/',
        ];
    }

    /**
     * Determine if the API client is configured.
     *
     * @return bool Whether the API client is configured.
     */
    public static function is_configured() {
        $config = get_config('local_o365');
        return (!empty($config->sharepointlink)) ? true : false;
    }

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_tokenresource() {
        $config = get_config('local_o365');
        if (!empty($config->sharepointlink)) {
            $siteinfo = static::parse_site_url($config->sharepointlink);
            if (!empty($siteinfo)) {
                return $siteinfo['tokenresource'];
            } else {
                $errmsg = 'SharePoint link URL was not valid';
                \local_o365\utils::debug($errmsg, 'rest\sharepoint::get_tokenresource', $config->sharepointlink);
            }
        } else {
            $errmsg = 'No SharePoint link URL was found. Plugin not configured?';
            \local_o365\utils::debug($errmsg, 'rest\sharepoint::get_tokenresource');
        }
        return false;
    }

    /**
     * Override the configured resource.
     *
     * @param string $tokenresource The new resource to set.
     *
     * @return bool Success/Failure.
     */
    public function override_tokenresource($tokenresource) {
        $this->tokenresource = $tokenresource;
        return true;
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        $tokenresource = (!empty($this->tokenresource)) ? $this->tokenresource : static::get_tokenresource();
        if (empty($this->parentsite)) {
            return $tokenresource.'/_api';
        } else {
            return $tokenresource.'/'.$this->parentsite.'/_api';
        }
    }

    /**
     * Get the URI of the site that serves as the parent site for all sharepoint course sites.
     *
     * @return string The URI of the parent site.
     */
    public static function get_moodle_parent_site_uri() {
        $config = get_config('local_o365');
        if (!empty($config->sharepointlink)) {
            $siteinfo = static::parse_site_url($config->sharepointlink);
            if (!empty($siteinfo)) {
                return trim($siteinfo['subsiteurl'], '/');
            }
        }
        return 'moodle';
    }

    /**
     * Set the site to use when making API calls.
     *
     * @param string $site The site's relative URL. i.e. /site/subsite
     */
    public function set_site($site) {
        if (empty($site)) {
            $this->parentsite = '';
        } else {
            $site = trim($site, '/');
            if (strpos($site, '/') === false) {
                $this->parentsite = rawurlencode($site);
            } else {
                $sites = explode('/', $site);
                $sites = array_map('rawurlencode', $sites);
                $this->parentsite = implode('/', $sites);
            }
        }
    }

    /**
     * Get files in a folder.
     *
     * @param string $path The path to query.
     * @param bool $useo365api Whether to use the o365 API (true) or the sharepoint API (false)
     * @return array|null Returned response, or null if error.
     */
    public function get_files($path, $useo365api = true) {
        if ($useo365api === true) {
            $path = rawurlencode($path);
            $contents = $this->apicall('get', "/v1.0/files/getByPath('{$path}')/children");
            return $this->process_apicall_response($contents, ['value' => null]);
        } else {
            $path = rawurlencode('/'.$this->parentsite.'/Shared Documents'.$path);
            $responsefolders = $this->apicall('get', "/web/getfolderbyserverrelativeurl('{$path}')/folders");
            $responsefolders = $this->process_apicall_response($responsefolders, ['value' => null]);
            $responsefiles = $this->apicall('get', "/web/getfolderbyserverrelativeurl('{$path}')/files");
            $responsefiles = $this->process_apicall_response($responsefiles, ['value' => null]);
            $contents = array_merge($responsefolders['value'], $responsefiles['value']);
        }
        return $contents;
    }

    /**
     * Get a file by it's ID.
     *
     * @param string $fileid The o365 file id.
     * @return string The file's contents.
     */
    public function get_file_by_id($fileid) {
        return $this->apicall('get', "/v1.0/files/{$fileid}/content");
    }

    /**
     * Get information about a folder.
     *
     * @param string $path The folder path.
     * @return array Array of folder information.
     */
    public function get_folder_metadata($path) {
        $path = rawurlencode($path);
        $response = $this->apicall('get', "/v1.0/files/getByPath('{$path}')");
        $expectedparams = ['@odata.type' => '#Microsoft.FileServices.Folder', 'id' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get a file's metadata by it's file id.
     *
     * @param string $fileid The file's ID.
     * @return array The file's metadata.
     */
    public function get_file_metadata($fileid) {
        $response = $this->apicall('get', "/v1.0/files/{$fileid}");
        $expectedparams = ['@odata.type' => '#Microsoft.FileServices.File', 'id' => null];
        return $this->process_apicall_response($response, $expectedparams);
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
            $spurl = $this->get_tokenresource();
            if (strpos($fileurl, $spurl) === 0) {
                $filerelative = substr($fileurl, strlen($spurl));
                $filerelativeparts = explode('/', trim($filerelative, '/'));
                if (substr($filerelative, -6) === '?web=1') {
                    $filerelative = substr($filerelative, 0, -6);
                }
                $endpoint = '/web/GetFileByServerRelativeUrl(\''.$filerelative.'\')/ListItemAllFields/GetWOPIFrameUrl(3)';
                $response = $this->apicall('post', $endpoint);
                $expectedparams = ['value' => null];
                return $this->process_apicall_response($response, $expectedparams);
            }
        }
        return null;
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
        $filename = rawurlencode($filename);
        $url = '/v1.0/files/'.$parentinfo['id'].'/children/'.$filename.'/content?nameConflict=overwrite';
        $params = ['file' => $content];
        $response = $this->apicall('put', $url, $params);
        $expectedparams = ['@odata.type' => '#Microsoft.FileServices.File', 'id' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Create a new subsite.
     *
     * @param string $title The site's title.
     * @param string $url The site's URL.
     * @param string $description The site's description.
     * @return array|null Returned response, or null if error.
     */
    public function create_site($title, $url, $description) {
        $webcreationinformation = [
            'parameters' => [
                'Title' => $title,
                'Url' => $url,
                'Description' => $description,
                'Language' => 1033,
                'WebTemplate' => 'STS#0',
                'UseSamePermissionsAsParentSite' => false,
            ],
        ];
        $webcreationinformation = json_encode($webcreationinformation);
        $response = $this->apicall('post', '/web/webs/add', $webcreationinformation);
        $expectedparams = ['odata.type' => 'SP.Web', 'Id' => null, 'ServerRelativeUrl' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get information about the set site.
     *
     * @param string $subsiteurl The URL of the subsite to check, or null for the current site.
     * @return array|false Information about the site, or false if failure.
     */
    public function get_site($subsiteurl = null) {
        // Temporarily set the site to the requested site.
        if (!empty($subsiteurl)) {
            $cursite = $this->parentsite;
            $this->set_site($subsiteurl);
        }
        $response = $this->apicall('get', '/web');

        // Reset the current site to the original value for subsequent calls.
        if (!empty($subsiteurl)) {
            $this->parentsite = $cursite;
        }

        $expectedparams = ['odata.type' => 'SP.Web', 'Id' => null, 'ServerRelativeUrl' => null, 'WebTemplate' => 'STS'];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Determine whether a subsite exists.
     *
     * @param string $subsiteurl The URL of the subsite to check, or null for the current site.
     * @return bool Whether the site exists or not.
     */
    public function site_exists($subsiteurl = null) {
        if (!empty($subsiteurl)) {
            $cursite = $this->parentsite;
            $this->set_site($subsiteurl);
        }
        $response = $this->apicall('get', '/web');

        // Reset the current site to the original value for subsequent calls.
        if (!empty($subsiteurl)) {
            $this->parentsite = $cursite;
        }

        if ($response === '404 FILE NOT FOUND') {
            $response = '';
        }

        return (!empty($response)) ? true : false;
    }

    /**
     * Update the set site.
     *
     * @param array $updated Array of updated parameters.
     * @return array|null Returned response, or null if error.
     */
    public function update_site(array $updated) {
        $response = $this->apicall('merge', '/web', json_encode($updated));
        if ($response === '') {
            // Empty response indicates success.
            return true;
        } else {
            return $this->process_apicall_response($response);
        }
    }

    /**
     * Delete the set site.
     *
     * @return string Returned response.
     */
    public function delete_site() {
        $response = $this->apicall('delete', '/web');
        if ($response === '') {
            // Empty response indicates success.
            return true;
        } else {
            return $this->process_apicall_response($response);
        }
    }

    /**
     * Get groups.
     *
     * @return array|null Returned response, or null if error.
     */
    public function get_groups() {
        $response = $this->apicall('get', '/web/sitegroups');
        return $this->process_apicall_response($response);
    }

    /**
     * Create a user group.
     *
     * @param string $name The name of the group.
     * @param string $description The description of the group.
     * @return array|null Returned response, or null if error.
     */
    public function create_group($name, $description) {
        $groupdata = [
            'Title' => $name,
            'Description' => $description,
        ];
        $groupdata = json_encode($groupdata);
        $response = $this->apicall('post', '/web/sitegroups', $groupdata);
        $expectedparams = ['odata.type' => 'SP.Group', 'Id' => null, 'Title' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get group information.
     *
     * @param string $name The group's name.
     * @return array|null Returned response, or null if error.
     */
    public function get_group($name) {
        $response = $this->apicall('get', '/web/sitegroups/getbyname(\''.$name.'\')');
        $expectedparams = ['odata.type' => 'SP.Group', 'Id' => null, 'Title' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Determine if a group exists.
     *
     * @param string $name The group's name.
     * @return bool True if it exists, false otherwise.
     */
    public function group_exists($name) {
        try {
            $group = $this->get_group($name);
            return true;
        } catch (\Exception $e) {
            // An API call error here would indicate the group doesn't exist.
            return false;
        }
    }

    /**
     * Get group information.
     *
     * @param string $id The group's id.
     * @return array|null Returned response, or null if error.
     */
    public function get_group_by_id($id) {
        $response = $this->apicall('get', '/web/sitegroups/getbyid(\''.$id.'\')');
        $expectedparams = ['odata.type' => 'SP.Group', 'Id' => null, 'Title' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Delete group.
     *
     * @param string $id The group's id.
     * @return array|null Returned response, or null if error.
     */
    public function delete_group_by_id($id) {
        $response = $this->apicall('post', '/web/sitegroups/removebyid(\''.$id.'\')');
        $expectedparams = ['odata.null' => true];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get users in a group.
     *
     * @param string $name The group's name.
     * @return array|null Returned response, or null if error.
     */
    public function get_group_users($name) {
        $name = rawurlencode($name);
        $response = $this->apicall('get', '/web/sitegroups/getbyname(\''.$name.'\')/users');
        $expectedparams = ['value' => null];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Add a user to a group.
     *
     * @param string $userupn An Azure AD user's UPN.
     * @param string $groupid The group's SharePoint id.
     * @param int $muserid Optional. If present, will record assignment in database.
     * @return array|null Returned response, or null if error.
     */
    public function add_user_to_group($userupn, $groupid, $muserid = null) {
        global $DB;
        $loginname = 'i:0#.f|membership|'.$userupn;
        $userdata = ['LoginName' => $loginname];
        $userdata = json_encode($userdata);
        $response = $this->apicall('post', '/web/sitegroups/getbyid(\''.$groupid.'\')/users', $userdata);
        $expectedparams = ['odata.type' => 'SP.User', 'Id' => null];
        $response = $this->process_apicall_response($response, $expectedparams);
        if (!empty($muserid)) {
            $recorded = $DB->record_exists('local_o365_spgroupassign', ['userid' => $muserid, 'groupid' => $groupid]);
            if (empty($recorded)) {
                $record = new \stdClass;
                $record->userid = $muserid;
                $record->groupid = $groupid;
                $record->timecreated = time();
                $DB->insert_record('local_o365_spgroupassign', $record);
            }
        }
        return $response;
    }

    /**
     * Remove a user from a group.
     *
     * @param string $userupn An Azure AD user's UPN.
     * @param string $groupid The group's id.
     * @param int $muserid Optional. If present, will removed record of assignment in database.
     * @return array|null Returned response, or null if error.
     */
    public function remove_user_from_group($userupn, $groupid, $muserid) {
        global $DB;
        $loginname = 'i:0#.f|membership|'.$userupn;
        $loginname = urlencode($loginname);
        $endpoint = '/web/sitegroups/getbyid('.$groupid.')/users/removebyloginname(@v)?@v=\''.$loginname.'\'';
        $response = $this->apicall('post', $endpoint, '');
        $expectedparams = ['odata.null' => true];
        $response = $this->process_apicall_response($response, $expectedparams);
        if (!empty($muserid)) {
            $recorded = $DB->delete_records('local_o365_spgroupassign', ['userid' => $muserid, 'groupid' => $groupid]);
        }
        return $response;
    }

    /**
     * Assign permissions on a group.
     *
     * @param string $groupid The group's ID (Principal ID)
     * @param string $permissiontype The type of permission to grant. full/contribute/read.
     * @return string The returned response.
     */
    public function assign_group_permissions($groupid, $permissiontype) {
        $permdefids = [
            'full' => 1073741829,
            'contribute' => 1073741827,
            'read' => 1073741826,
        ];
        if (!isset($permdefids[$permissiontype])) {
            throw new \moodle_exception('erroro365apibadpermission', 'local_o365');
        }
        $roledefid = $permdefids[$permissiontype];
        $response = $this->apicall('post', "/web/roleassignments/addroleassignment(principalid={$groupid},roledefid={$roledefid})");
        $expectedparams = ['odata.null' => true];
        return $this->process_apicall_response($response, $expectedparams);
    }

    /**
     * Get the URI of the subsite created for a course.
     * @param int $courseid The ID of the course.
     * @return string The relative URI of the sharepoint subsite.
     */
    public static function get_course_subsite_uri($courseid) {
        global $DB;
        return $DB->get_field('local_o365_coursespsite', 'siteurl', ['courseid' => $courseid]);
    }

    /**
     * Create a course subsite.
     *
     * @param \stdClass $course A course record to create the subsite from.
     * @return \stdClass An association record.
     */
    protected function create_course_subsite($course) {
        global $DB;
        $now = time();
        $caller = '\local_o365\rest\sharepoint::create_course_subsite';

        // To account for times when the course shortname might change, look for a coursespsite record for the course with the same
        // parent site URL.
        $siterec = $DB->get_record('local_o365_coursespsite', ['courseid' => $course->id]);
        if (!empty($siterec) && strpos($siterec->siteurl, '/'.$this->parentsite.'/') === 0) {
            $debugdata = ['courseid' => $course->id, 'spsiteid' => $siterec->id];
            \local_o365\utils::debug('Found a stored subsite record for this course.', $caller, $debugdata);
            return $siterec;
        }

        $siteurl = strtolower(preg_replace('/[^a-z0-9_]+/iu', '', $course->shortname));
        $fullsiteurl = '/'.$this->parentsite.'/'.$siteurl;

        // Check if site exists.
        if ($this->site_exists($fullsiteurl) !== true) {
            // Create site.
            \local_o365\utils::debug('Creating site '.$fullsiteurl, $caller);
            $DB->delete_records('local_o365_coursespsite', ['courseid' => $course->id]);
            $sitedata = $this->create_site($course->fullname, $siteurl, $course->summary);
            $siterec = new \stdClass;
            $siterec->courseid = $course->id;
            $siterec->siteid = $sitedata['Id'];
            $siterec->siteurl = $sitedata['ServerRelativeUrl'];
            $siterec->timecreated = $now;
            $siterec->timemodified = $now;
            $siterec->id = $DB->insert_record('local_o365_coursespsite', $siterec);
            return $siterec;
        } else {
            $debugmsg = 'Subsite already exists, looking for local data.';
            \local_o365\utils::debug($debugmsg, $caller, $fullsiteurl);
            if (!empty($siterec)) {
                // We have a local spsite record for the course, but for a different parent site, so our record is out of date.
                $sitedata = $this->get_site($fullsiteurl);
                $DB->delete_records('local_o365_coursespsite', ['courseid' => $course->id]);
                // Save site data.
                $siterec = new \stdClass;
                $siterec->courseid = $course->id;
                $siterec->siteid = $sitedata['Id'];
                $siterec->siteurl = $sitedata['ServerRelativeUrl'];
                $siterec->timecreated = $now;
                $siterec->timemodified = $now;
                $siterec->id = $DB->insert_record('local_o365_coursespsite', $siterec);
                return $siterec;
            } else {
                $errmsg = 'Can\'t create a SharePoint subsite site because one exists but we don\'t have a local record.';
                $debugdata = [
                    'fullsiteurl' => $fullsiteurl,
                    'courseid' => $course->id,
                    'courseshortname' => $course->shortname
                ];
                \local_o365\utils::debug($errmsg, $caller, $debugdata);
                throw new \moodle_exception('erroro365apisiteexistsnolocal', 'local_o365');
            }
        }
    }

    /**
     * Add users with a given capability in a given context to a SharePoint group.
     *
     * @param \context $context The context to check for the capability.
     * @param string $capability The capability to check for.
     * @param int $spgroupid The sharepoint group ID to add users to.
     */
    public function add_users_with_capability_to_group($context, $capability, $spgroupid) {
        $now = time();

        $users = get_users_by_capability($context, $capability);
        $results = [];

        // Assign users to group.
        foreach ($users as $user) {
            // Only Azure AD users can be added to sharepoint.
            if (\local_o365\utils::is_o365_connected($user->id) !== true) {
                continue;
            }

            try {
                if (\local_o365\rest\unified::is_configured()) {
                    $userupn = \local_o365\rest\unified::get_muser_upn($user);
                } else {
                    $userupn = \local_o365\rest\azuread::get_muser_upn($user);
                }
            } catch (\Exception $e) {
                continue;
            }

            if (!empty($userupn)) {
                $results[$user->id] = $this->add_user_to_group($userupn, $spgroupid, $user->id);
            }
        }
        return $results;
    }

    /**
     * Create a subsite for a course and assign appropriate permissions.
     *
     * @param int|\stdClass $course A course record or course ID.
     * @return bool Success/Failure.
     * @uses exit
     */
    public function create_course_site($course) {
        global $DB;
        $now = time();

        $this->set_site($this->get_moodle_parent_site_uri());

        // Get course data.
        if (is_numeric($course)) {
            $course = $DB->get_record('course', ['id' => $course]);
            if (empty($course)) {
                throw new \moodle_exception('erroro365apicoursenotfound', 'local_o365');
            }
        }

        $coursesubsiteenabled = \local_o365\feature\sharepointcustom\utils::course_subsite_enabled($course);
        if (!$coursesubsiteenabled) {
            $errmsg = 'SharePoint subsite not enabled for this course. Cannot create a subsite.';
            \local_o365\utils::debug($errmsg, 'rest\sharepoint\update_course_site', $course->id);
            return false;
        } else {
            $requiredcapability = static::get_course_site_required_capability();

            $siterec = $this->create_course_subsite($course);
            $this->set_site($siterec->siteurl);

            // Create teacher group and save in db.
            $grouprec = $DB->get_record('local_o365_spgroupdata', ['coursespsiteid' => $siterec->id, 'permtype' => 'contribute']);
            if (empty($grouprec)) {
                $groupname = $siterec->siteurl.' contribute';
                $description = get_string('spsite_group_contributors_desc', 'local_o365', $siterec->siteurl);
                $groupname = trim(base64_encode($groupname), '=');

                // Get or create the group.
                try {
                    $groupdata = $this->get_group($groupname);
                } catch (\Exception $e) {
                    // An error here indicates the group does not exist. Create it.
                    $groupdata = $this->create_group($groupname, $description);
                }

                if (!empty($groupdata) && isset($groupdata['Id']) && isset($groupdata['Title'])) {
                    $grouprec = new \stdClass;
                    $grouprec->coursespsiteid = $siterec->id;
                    $grouprec->groupid = $groupdata['Id'];
                    $grouprec->grouptitle = $groupdata['Title'];
                    $grouprec->permtype = 'contribute';
                    $grouprec->timecreated = $now;
                    $grouprec->timemodified = $now;
                    $grouprec->id = $DB->insert_record('local_o365_spgroupdata', $grouprec);
                } else {
                    throw new \moodle_exception('errorcouldnotcreatespgroup', 'local_o365');
                }
            }

            // Assign group permissions.
            $this->assign_group_permissions($grouprec->groupid, $grouprec->permtype);

            // Get users who need access.
            $coursecontext = \context_course::instance($course->id);
            $results = $this->add_users_with_capability_to_group($coursecontext, $requiredcapability, $grouprec->groupid);
            return true;
        }
    }

    /**
     * Update a subsite for a course.
     *
     * @param int $courseid
     * @param string $shortname
     * @param string $fullname
     * @return bool Success/Failure.
     */
    public function update_course_site($courseid, $shortname, $fullname) {
        global $DB;

        $spsite = $DB->get_record('local_o365_coursespsite', ['courseid' => $courseid]);
        if (empty($spsite)) {
            $errmsg = 'Did not update SharePoint course site because we found no record of one.';
            \local_o365\utils::debug($errmsg, 'rest\sharepoint\update_course_site', $courseid);
            return false;
        }

        $this->set_site($spsite->siteurl);

        // Cannot update URL at the moment, just update Title.
        try {
            $updated = ['Title' => $fullname];
            $this->update_site($updated);
        } catch (\Exception $e) {
            // API call errors are logged in update_site().
            return false;
        }
        return true;
    }

    /**
     * Get the Moodle capability a user must have in the course context to access the course's sharepoint site.
     *
     * @return string A moodle capability.
     */
    public static function get_course_site_required_capability() {
        return 'moodle/course:managefiles';
    }

    /**
     * Delete a course site and it's associated groups.
     * @param int $courseid The ID of the course to delete the site for.
     * @return bool Success/Failure.
     */
    public function delete_course_site($courseid) {
        global $DB;
        $spsite = $DB->get_record('local_o365_coursespsite', ['courseid' => $courseid]);
        if (empty($spsite)) {
            // No site created (that we know about).
            $errmsg = 'Did not delete course SharePoint site because no record of a SharePoint site for that course was found.';
            \local_o365\utils::debug($errmsg, 'rest\sharepoint\delete_course_site', $courseid);
            return false;
        }
        $this->set_site($spsite->siteurl);

        $spgroupsql = 'SELECT spgroup.*
                         FROM {local_o365_spgroupdata} spgroup
                         JOIN {local_o365_coursespsite} spsite
                              ON spgroup.coursespsiteid = spsite.id
                        WHERE spsite.courseid = ?';
        $spgroups = $DB->get_records_sql($sqlgroupsql, [$courseid]);
        foreach ($spgroups as $spgroup) {
            try {
                $this->delete_group_by_id($spgroup->groupid);
                $DB->delete_records('local_o365_spgroupdata', ['id' => $spgroup->id]);
            } catch (\Exception $e) {
                // If the API call failed we can still continue.
                // Error is logged in API call function if failed.
            }
        }
        $this->delete_site();
        $DB->delete_records('local_o365_coursespsite', ['courseid' => $courseid]);

        return true;
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

    /**
     * Get video embed code.
     *
     * @param string $channelid The ID of the channel which contains the video.
     * @param string $videoid The ID of the video.
     * @param int $width Width of video in pixels.
     * @param int $height Height of video.
     * @return string Return embed code.
     */
    public function get_video_embed_code($channelid, $videoid, $width = 640, $height = 360) {
        $endpoint = "/VideoService/Channels('$channelid')/Videos('$videoid')/GetVideoEmbedCode?width=$width&height=$height";
        $response = $this->apicall('get', $endpoint);
        $expectedparams = ['value' => null];
        $response = $this->process_apicall_response($response, $expectedparams);
        return $response['value'];
    }

    /**
     * Get video service url.
     *
     * @return string Video service portal api url.
     */
    public function videoservice_discover() {
        $response = $this->apicall('get', "/VideoService.Discover");
        $expectedparams = ['IsVideoPortalEnabled' => null, 'VideoPortalUrl' => null];
        $response = $this->process_apicall_response($response, $expectedparams);
        return $response['VideoPortalUrl'];
    }

    /**
     * Get list of channels to which the user can upload videos.
     *
     * @return list of Channel objects.
     */
    public function get_video_channels() {
        $response = $this->apicall('get', "/VideoService/Channels");
        $expectedparams = ['value' => null];
        $response = $this->process_apicall_response($response, $expectedparams);
        return $response;
    }

    /**
     * Get a channel to which the user can upload video.
     *
     * @param string $channelid The ID of the channel.
     * @return a Channel objects.
     */
    public function get_video_channel($channelid) {
        $response = $this->apicall('get', "/VideoService/Channels('$channelid')");
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Get list of all videos on a channel.
     *
     * @param string $channelid The ID of the channel.
     * @return a list of Video objects.
     */
    public function get_all_channel_videos($channelid) {
        $response = $this->apicall('get', "/VideoService/Channels('$channelid')/Videos");
        $expectedparams = ['value' => null];
        $response = $this->process_apicall_response($response, $expectedparams);
        return $response;
    }

    /**
     * Craete a place holder for where one can upload the video.
     *
     * @param string $channelid The ID of the channel where video need to uploaded.
     * @param string $description The description of the video need to uploaded.
     * @param string $title The title of the video need to uploaded.
     * @param string $filename The file name of the video need to uploaded.
     * @return VideoObject -- The object into which to upload the video.
     */
    public function create_video_placeholder($channelid, $description = '', $title = '', $filename = '') {
        $params = '{ \'__metadata\': { \'type\': \'SP.Publishing.VideoItem\' }, \'Description\': \''.$description.'\', '.
            '\'Title\': \''.$title.'\', \'FileName\' : \''.$filename.'\' }';
        $options = array('contenttype' => 'application/json;odata=verbose', 'Accept' => 'application/json;odata=verbose');
        $response = $this->apicall('post', "/VideoService/Channels('$channelid')/Videos", $params, $options);
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Upload a smaller video in a single post.
     *
     * @param string $channelid The ID of the channel where video need to uploaded.
     * @param string $videoid video ID.
     * @param string $content file content need to uploaded.
     * @return Response code
     */
    protected function upload_video_small($channelid, $videoid, $content) {
        $response = $this->apicall('post', "/VideoService/Channels('$channelid')/Videos('$videoid')/GetFile()/SaveBinaryStream",
            $content);
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Upload a larger video in chunks.
     *
     * @param string $channelid The ID of the channel where video need to uploaded.
     * @param string $videoid video ID.
     * @param string $filename The name of file on disk with full path ...
     * @param string $guid
     * @param int $filesize
     * @param int $offsetsize
     * @return Response code
     */
    protected function upload_video_large($channelid, $videoid, $filename, $guid, $filesize, $offsetsize) {
        @set_time_limit(0);
        $endpoint = "/VideoService/Channels('$channelid')/Videos('$videoid')/GetFile()/StartUpload(uploadId=guid'$guid')";
        $response = $this->apicall('post', $endpoint);
        $response = $this->process_apicall_response($response);
        $uploadedsize = 0;
        while ($uploadedsize + $offsetsize < $filesize) {
            $endpoint = "/VideoService/Channels('$channelid')/Videos('$videoid')/GetFile()/" .
                "ContinueUpload(uploadId=guid'$guid',fileOffset='$uploadedsize')";
            $response = $this->apicall('post', $endpoint, file_get_contents($filename, false, null, $uploadedsize, $offsetsize));
            $uploadedsize += $offsetsize;
            $response = $this->process_apicall_response($response);
            if (!$response['value']) {
                return $response;
            }
        }
        $endpoint = "/VideoService/Channels('$channelid')/Videos('$videoid')/GetFile()/" .
            "FinishUpload(uploadId=guid'$guid',fileOffset='$uploadedsize')";
        $response = $this->apicall('post', $endpoint, file_get_contents($filename, false, null, $uploadedsize, $offsetsize));
        $response = $this->process_apicall_response($response);
        return $response;
    }

    /**
     * Upload a video.
     *
     * @param string $channelid The ID of the channel where video need to be uploaded.
     * @param string $videoid video ID.
     * @param string $filename The name of file on disk with full path ...
     * @param int $offsetsize Upload chunk size (default 8192 * 1024).
     * @return Response code
     */
    public function upload_video($channelid, $videoid, $filename, $offsetsize = 8388608) {
        $filesize = filesize($filename);
        if ($filesize < (8192 * 1024)) {
            $result = $this->upload_video_small($channelid, $videoid, file_get_contents($filename));
        } else {
            $result = $this->upload_video_large($channelid, $videoid, $filename, static::new_guid(), $filesize, $offsetsize);
        }
        return $result;
    }

    /**
     * Generate a new GUID.
     *
     * @return GUID as a string.
     */
    public static function new_guid() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
                mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479),
                mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * Get video file's metadata by url.
     *
     * @param string $url The file's URL.
     * @return array The file's metadata.
     */
    public function get_video_file($url) {
        $header = [
            'Authorization: Bearer '.$this->token->get_token(),
        ];
        $options = array();
        $options['CURLOPT_FAILONERROR'] = true;
        $options['CURLOPT_FOLLOWLOCATION'] = true;
        $options['CURLOPT_RETURNTRANSFER'] = true;
        $options['CURLOPT_TIMEOUT'] = 30 * 60;
        $options['CURLOPT_HTTPGET'] = true;
        $options['CURLOPT_HEADER'] = false;
        $options['CURLOPT_HTTPHEADER'] = $header;
        return $this->httpclient->download_file($url, $options);
    }
}
