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
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

namespace local_o365\rest;

/**
 * API client for Sharepoint.
 */
class sharepoint extends \local_o365\rest\o365api {
    /** @var string The site we're accessing. */
    protected $parentsite = '';

    /**
     * Determine if the API client is configured.
     *
     * @return bool Whether the API client is configured.
     */
    public static function is_configured() {
        $config = get_config('local_o365');
        return (!empty($config->tenant)) ? true : false;
    }

    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_resource() {
        $config = get_config('local_o365');
        if (!empty($config->tenant)) {
            return 'https://'.$config->tenant.'.sharepoint.com';
        } else {
            return false;
        }
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        if (empty($this->parentsite)) {
            return static::get_resource().'/_api';
        } else {
            return static::get_resource().'/'.$this->parentsite.'/_api';
        }
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
                throw new \Exception('Error in API call.');
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
            throw new \Exception('Error in API call.');
        }
        return $result;
    }

    /**
     * Get information about the set site.
     *
     * @return array|false Information about the site, or false if failure.
     */
    public function get_site() {
        $result = $this->apicall('get', '/web');
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
     * @param string $subsiteurl The URL of the subsite to check.
     * @return bool Whether the site exists or not.
     */
    public function site_exists($subsiteurl) {
        $cursite = $this->parentsite;
        $this->set_site($subsiteurl);
        $siteinfo = $this->get_site();
        $this->parentsite = $cursite;
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
            throw new \Exception('Error in API call.');
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
            throw new \Exception('Error in API call.');
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
            throw new \Exception('Error in API call.');
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
            throw new \Exception('Error in API call.');
        }
        return $result;
    }

    /**
     * Add a user to a group.
     *
     * @param string $user An AAD user's LoginName.
     * @param string $groupname The group's name.
     * @return array|null Returned response, or null if error.
     */
    public function add_user_to_group($user, $groupname) {
        $userdata = ['LoginName' => $user];
        $userdata = json_encode($userdata);
        $result = $this->apicall('post', '/web/sitegroups/getbyname(\''.$groupname.'\')/users', $userdata);
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new \Exception('Error in API call.');
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
            throw new \Exception('Permission not found');
        }
        $roledefid = $permdefids[$permissiontype];
        return $this->apicall('post', "/web/roleassignments/addroleassignment(principalid={$principalid},roledefid={$roledefid})");
    }
}
