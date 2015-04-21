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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365\rest;

/**
 * API client for Sharepoint.
 */
class sharepoint extends \local_o365\rest\o365api {
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
        $siteinfo = static::parse_site_url($uncleanurl);
        if (empty($siteinfo)) {
            return 'invalid';
        }

        $token = \local_o365\oauth2\systemtoken::get_for_new_resource(null, $siteinfo['resource'], $clientdata, $httpclient);
        if (empty($token)) {
            return 'invalid';
        }

        $sharepoint = new \local_o365\rest\sharepoint($token, $httpclient);
        $sharepoint->override_resource($siteinfo['resource']);
        $mainsiteinfo = $sharepoint->get_site();
        if (!empty($mainsiteinfo) && !isset($mainsiteinfo['error']) && !empty($mainsiteinfo['Id'])) {
            if ($siteinfo['subsiteurl'] !== '/') {
                $subsiteinfo = $sharepoint->get_site($siteinfo['subsiteurl']);
                if (empty($subsiteinfo)) {
                    return 'valid';
                } else {
                    return 'notempty';
                }
            } else {
                return 'notempty';
            }
        }

        return 'invalid';
    }

    /**
     * Validate and parse a SharePoint URL into a resource and subsite path.
     *
     * @param string $url The URL to validate and parse.
     * @return array|bool The parsed URL into 'resource' and 'subsiteurl' keys, or false if invalid.
     */
    public static function parse_site_url($url) {
        $cleanurl = clean_param($url, PARAM_URL);
        if ($cleanurl !== $url) {
            return false;
        }
        if (strpos($cleanurl, 'https://') !== 0) {
            return false;
        }

        $cleanurlparts = parse_url($cleanurl);
        if (empty($cleanurlparts) || empty($cleanurlparts['host'])) {
            return false;
        }

        return [
            'resource' => 'https://'.$cleanurlparts['host'],
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
    public static function get_resource() {
        $config = get_config('local_o365');
        if (!empty($config->sharepointlink)) {
            $siteinfo = static::parse_site_url($config->sharepointlink);
            if (!empty($siteinfo)) {
                return $siteinfo['resource'];
            }
        }
        return false;
    }

    /**
     * Override the configured resource.
     *
     * @param string $resource The new resource to set.
     * @return bool Success/Failure.
     */
    public function override_resource($resource) {
        $this->resource = $resource;
        return true;
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        $resource = (!empty($this->resource)) ? $this->resource : static::get_resource();
        if (empty($this->parentsite)) {
            return $resource.'/_api';
        } else {
            return $resource.'/'.$this->parentsite.'/_api';
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
            $contents = json_decode($contents, true);
            if (empty($contents)) {
                throw new \moodle_exception('erroro365apibadcall', 'local_o365');
            }
        } else {
            $path = rawurlencode('/'.$this->parentsite.'/Shared Documents'.$path);
            $responsefolders = $this->apicall('get', "/web/getfolderbyserverrelativeurl('{$path}')/folders");
            $responsefolders = json_decode($responsefolders, true);
            $responsefiles = $this->apicall('get', "/web/getfolderbyserverrelativeurl('{$path}')/files");
            $responsefiles = json_decode($responsefiles, true);
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
        $response = json_decode($response, true);
        if (empty($response)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }
        return $response;
    }

    /**
     * Get a file's metadata by it's file id.
     *
     * @param string $fileid The file's ID.
     * @return array The file's metadata.
     */
    public function get_file_metadata($fileid) {
        $response = $this->apicall('get', "/v1.0/files/{$fileid}");
        $response = json_decode($response, true);
        if (empty($response)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }
        return $response;
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
            $url = '/v1.0/files/'.$parentinfo['id'].'/children/'.$filename.'/content?nameConflict=overwrite';
            $params = ['file' => $content];
            $response = $this->apicall('put', $url, $params);
            $response = json_decode($response, true);
            if (empty($response)) {
                throw new \moodle_exception('erroro365apibadcall', 'local_o365');
            }
            return $response;
        } else {
            throw new \moodle_exception('erroro365apinoparentinfo', 'local_o365');
        }
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
        $result = $this->apicall('post', '/web/webs/add', $webcreationinformation);
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }
        return $result;
    }

    /**
     * Get information about the set site.
     *
     * @param string $subsiteurl The URL of the subsite to check, or null for the current site.
     * @return array|false Information about the site, or false if failure.
     */
    public function get_site($subsiteurl = null) {
        if (!empty($subsiteurl)) {
            $cursite = $this->parentsite;
            $this->set_site($subsiteurl);
        }
        $result = $this->apicall('get', '/web');
        if (!empty($subsiteurl)) {
            $this->parentsite = $cursite;
        }
        if (!empty($result)) {
            $result = json_decode($result, true);
            if (!empty($result) && is_array($result)) {
                return $result;
            }
        }
        return false;
    }

    /**
     * Determine whether a subsite exists.
     *
     * @param string $subsiteurl The URL of the subsite to check, or null for the current site.
     * @return bool Whether the site exists or not.
     */
    public function site_exists($subsiteurl = null) {
        $siteinfo = $this->get_site($subsiteurl);
        return (!empty($siteinfo)) ? true : false;
    }

    /**
     * Update the set site.
     *
     * @param array $updated Array of updated parameters.
     * @return array|null Returned response, or null if error.
     */
    public function update_site(array $updated) {
        $updated = json_encode($updated);
        $result = $this->apicall('merge', '/web', $updated);
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }
        return $result;
    }

    /**
     * Delete the set site.
     *
     * @return string Returned response.
     */
    public function delete_site() {
        return $this->apicall('delete', '/web');
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
        $result = $this->apicall('post', '/web/sitegroups', $groupdata);
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }
        return $result;
    }

    /**
     * Get group information.
     *
     * @param string $name The group's name.
     * @return array|null Returned response, or null if error.
     */
    public function get_group($name) {
        $result = $this->apicall('get', '/web/sitegroups/getbyname(\''.$name.'\')');
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }
        return $result;
    }

    /**
     * Get group information.
     *
     * @param string $id The group's id.
     * @return array|null Returned response, or null if error.
     */
    public function get_group_by_id($id) {
        $result = $this->apicall('get', '/web/sitegroups/getbyid(\''.$id.'\')');
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }
        return $result;
    }

    /**
     * Delete group.
     *
     * @param string $id The group's id.
     * @return array|null Returned response, or null if error.
     */
    public function delete_group_by_id($id) {
        $result = $this->apicall('post', '/web/sitegroups/removebyid(\''.$id.'\')');
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }
        return $result;
    }

    /**
     * Get users in a group.
     *
     * @param string $name The group's name.
     * @return array|null Returned response, or null if error.
     */
    public function get_group_users($name) {
        $result = $this->apicall('get', '/web/sitegroups/getbyname(\''.$name.'\')/users');
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }
        return $result;
    }

    /**
     * Add a user to a group.
     *
     * @param string $userupn An AAD user's UPN.
     * @param string $groupid The group's id.
     * @param int $muserid Optional. If present, will record assignment in database.
     * @return array|null Returned response, or null if error.
     */
    public function add_user_to_group($userupn, $groupid, $muserid = null) {
        global $DB;
        $loginname = 'i:0#.f|membership|'.$userupn;
        $userdata = ['LoginName' => $loginname];
        $userdata = json_encode($userdata);
        $result = $this->apicall('post', '/web/sitegroups/getbyid(\''.$groupid.'\')/users', $userdata);
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }

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
        return $result;
    }

    /**
     * Remove a user from a group.
     *
     * @param string $userupn An AAD user's UPN.
     * @param string $groupid The group's id.
     * @param int $muserid Optional. If present, will removed record of assignment in database.
     * @return array|null Returned response, or null if error.
     */
    public function remove_user_from_group($userupn, $groupid, $muserid) {
        global $DB;
        $loginname = 'i:0#.f|membership|'.$userupn;
        $loginname = urlencode($loginname);
        $endpoint = '/web/sitegroups/getbyid('.$groupid.')/users/removebyloginname(@v)?@v=\''.$loginname.'\'';
        $result = $this->apicall('post', $endpoint, '');
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new \moodle_exception('erroro365apibadcall', 'local_o365');
        }
        if (!empty($muserid)) {
            $recorded = $DB->delete_records('local_o365_spgroupassign', ['userid' => $muserid, 'groupid' => $groupid]);
        }
        return $result;
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
        return $response;
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

        $siteurl = $course->shortname;
        $fullsiteurl = '/'.$this->parentsite.'/'.$siteurl;

        // Check if site exists.
        if ($this->site_exists($fullsiteurl) !== true) {
            // Create site.
            $DB->delete_records('local_o365_coursespsite', ['courseid' => $course->id]);
            $sitedata = $this->create_site($course->fullname, $siteurl, $course->summary);
            if (!empty($sitedata) && isset($sitedata['Id']) && isset($sitedata['ServerRelativeUrl'])) {
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
                throw new \moodle_exception('erroro365apicouldnotcreatesite', 'local_o365');
            }
        } else {
            $siterec = $DB->get_record('local_o365_coursespsite', ['courseid' => $course->id]);
            if (!empty($siterec) && $siterec->siteurl == $fullsiteurl) {
                return $siterec;
            } else {
                $sitedata = $this->get_site($fullsiteurl);
                if (!empty($sitedata) && isset($sitedata['Id']) && isset($sitedata['ServerRelativeUrl'])) {
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
                    throw new \moodle_exception('erroro365apisiteexistsnolocal', 'local_o365');
                }
            }
        }
    }

    /**
     * Add users with a given capability in a given context to a Sharepoint group.
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
            // Only AAD users can be added to sharepoint.
            if ($user->auth !== 'oidc') {
                continue;
            }

            try {
                $userupn = \local_o365\rest\azuread::get_muser_upn($user);
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

        $requiredcapability = static::get_course_site_required_capability();

        $siterec = $this->create_course_subsite($course);
        $this->set_site($siterec->siteurl);

        // Create teacher group and save in db.
        $grouprec = $DB->get_record('local_o365_spgroupdata', ['coursespsiteid' => $siterec->id, 'permtype' => 'contribute']);
        if (empty($grouprec)) {
            $groupname = $siterec->siteurl.' contribute';
            $description = get_string('spsite_group_contributors_desc', 'local_o365', $siterec->siteurl);
            $groupname = trim(base64_encode($groupname), '=');
            $groupdata = $this->get_group($groupname);
            if (empty($groupdata) || !isset($groupdata['Id']) || !isset($groupdata['Title'])) {
                // Group does not exist, create it.
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

    /**
     * Update a subsite for a course.
     *
     * @param int|\stdClass $course A course record or course ID.
     * @return bool Success/Failure.
     */
    public function update_course_site($courseid, $shortname, $fullname) {
        global $DB;

        $spsite = $DB->get_record('local_o365_coursespsite', ['courseid' => $courseid]);
        if (empty($spsite)) {
            return false;
        }

        $this->set_site($spsite->siteurl);

        // Cannot update URL at the moment, just update Title.
        try {
            $updated = ['Title' => $fullname];
            $this->update_site($updated);
        } catch (\Exception $e) {
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
}
