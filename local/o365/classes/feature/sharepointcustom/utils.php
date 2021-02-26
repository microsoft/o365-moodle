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
 * @author Amy Groshek <amy@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\sharepointcustom;

class utils {
    /**
     * Enable or disable course subsite.
     *
     * @param int $courseid The ID of the course.
     * @param bool $enabled Whether to enable or disable.
     */
    public static function set_course_subsite_enabled($courseid, $enabled = true) {
        global $DB;

        $return = [];
        $customsubsitesenabled = get_config('local_o365', 'sharepointcourseselect');
        if ($customsubsitesenabled === 'oncustom') {
            $customsubsitesconfig = get_config('local_o365', 'sharepointsubsitescustom');
            $customsubsitesconfig = @json_decode($customsubsitesconfig, true);
            if (empty($customsubsitesconfig) || !is_array($customsubsitesconfig)) {
                $customsubsitesconfig = [];
            }
            if ($enabled === true) {
                // Update config JSON of enabled sites.
                $customsubsitesconfig[$courseid] = $enabled;
                set_config('sharepointsubsitescustom', json_encode($customsubsitesconfig), 'local_o365');

                try {
                    $sharepointtokenresource = \local_o365\rest\sharepoint::get_tokenresource();
                    if (empty($sharepointtokenresource)) {
                        throw new \moodle_exception('erroracplocalo365notconfig', 'local_o365');
                    }

                    $httpclient = new \local_o365\httpclient();
                    $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();

                    $sptoken = \local_o365\utils::get_app_or_system_token($sharepointtokenresource, $clientdata, $httpclient);
                    if (empty($sptoken)) {
                        throw new \moodle_exception('erroracpnosptoken', 'local_o365');
                    }

                    $sharepoint = new \local_o365\rest\sharepoint($sptoken, $httpclient);
                } catch (\Exception $e) {
                    $errmsg = 'ERROR: Problem initializing SharePoint API. Reason: '.$e->getMessage();
                    mtrace($errmsg);
                    \local_o365\utils::debug($errmsg, 'local_o365\task\sharepointinit::execute');
                    set_config('sharepoint_initialized', 'error', 'local_o365');
                    return false;
                }

                 // Create parent site(s).
                    try {
                        mtrace('Creating parent site for Moodle...');
                        $moodlesiteuri = $sharepoint->get_moodle_parent_site_uri();
                        mtrace($moodlesiteuri);
                        $sitelevels = explode('/', $moodlesiteuri);
                        $currentparentsite = '';
                        foreach ($sitelevels as $partialurl) {
                            $sharepoint->set_site($currentparentsite);
                            if ($sharepoint->site_exists($currentparentsite.'/'.$partialurl) === false) {
                                $moodlesitename = get_string('acp_parentsite_name', 'local_o365');
                                $moodlesitedesc = get_string('acp_parentsite_desc', 'local_o365');
                                $frontpagerec = $DB->get_record('course', ['id' => SITEID], 'id,shortname');
                                if (!empty($frontpagerec) && !empty($frontpagerec->shortname)) {
                                    $moodlesitename = $frontpagerec->shortname;
                                }
                                mtrace('Setting parent site to "'.$currentparentsite.'", creating subsite "'.$partialurl.'"');
                                $result = $sharepoint->create_site($moodlesitename, $partialurl, $moodlesitedesc);
                                $currentparentsite .= '/'.$partialurl;
                                mtrace('Created parent site "'.$currentparentsite.'"');
                            } else {
                                $currentparentsite .= '/'.$partialurl;
                                mtrace('Parent site "'.$currentparentsite.'" already exists.');
                            }
                        }
                        mtrace('Finished creating Moodle parent site.');
                    } catch (\Exception $e) {
                        $errmsg = 'ERROR: Problem creating parent site. Reason: '.$e->getMessage();
                        mtrace($errmsg);
                        \local_o365\utils::debug($errmsg, 'local_o365\task\sharepointinit::execute');
                        set_config('sharepoint_initialized', 'error', 'local_o365');
                        return false;
                    }

                    // Create course sites.
                    mtrace('Creating course subsites in "'.$moodlesiteuri.'"');
                    $sharepoint->set_site($moodlesiteuri);

                    $coursecreated = $sharepoint->create_course_site($courseid);
                    // return $coursecreated;
                    if (!empty($coursecreated)) {
                        $return[] = $coursecreated;
                    }

            } else {
                if (isset($customsubsitesconfig[$courseid])) {
                    unset($customsubsitesconfig[$courseid]);
                    set_config('sharepointsubsitescustom', json_encode($customsubsitesconfig), 'local_o365');
                    $return[] = false;
                }
            }
            $return[] = $customsubsitesconfig;
            return $return;
        }
    }

   /**
     * Determine whether a course subsite is enabled or disabled.
     *
     * @param int $courseid The ID of the course.
     * @param string $feature The feature to check.
     * @return bool Whether the feature is enabled or not.
     */
    public static function course_is_sharepoint_enabled($courseid) {
        $customsubsitesenabled = get_config('local_o365', 'sharepointcourseselect');
        if ($customsubsitesenabled === 'onall') {
            return true;
        } else if ($customsubsitesenabled === 'oncustom') {
            $config = get_config('local_o365', 'sharepointsubsitescustom');
            $config = @json_decode($config, true);
            return (!empty($config) && is_array($config) && isset($config[$courseid]))
                ? true : false;
        }
        return false;
    }

    /**
     * Determine whether or not a subsite can be created for a course.
     *
     * @param string $course A course record to create the subsite from.
     * @return bool True if course subsite can be created, false otherwise.
     */
    public static function course_subsite_enabled($course) {
        $sharepointcourseselect = get_config('local_o365', 'sharepointcourseselect');
        if ($sharepointcourseselect === 'onall') {
            return true;
        } else if ($sharepointcourseselect !== 'oncustom') {
            return false;
        }

        $subsitesconfig = get_config('local_o365', 'sharepointsubsitescustom');
        $subsitesconfig = json_decode($subsitesconfig, true);
        $courseid = $course->id;
        $courseinconfig = null;
        if ($subsitesconfig) {
            $courseinconfig = array_key_exists($courseid, $subsitesconfig);
        }
        $courseconfigval = false;
        if ($courseinconfig) {
            $courseconfigval = $subsitesconfig[$courseid];
        }
        if ($courseinconfig == true && $courseconfigval == true) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update sharepoint subsite json object upon upgrade.
     *
     * @param object $return Object with results of update.
     */
    public static function update_enabled_subsites_json() {
        global $DB;
        $now = time();
        // Get all Moodle site courses.
        $allcourses = get_courses('all', 'c.id ASC', 'c.id, c.shortname, c.fullname');
        // Get JSON of enabled courses.
        $subsitesconfig = get_config('local_o365', 'sharepointsubsitescustom');
        $subsitesconfig = json_decode($subsitesconfig, true);
        $subsitesconfig = $subsitesconfig ? $subsitesconfig : array();
        // Get sharepoint.
        try {
            $sharepointtokenresource = \local_o365\rest\sharepoint::get_tokenresource();
            if (empty($sharepointtokenresource)) {
                throw new \moodle_exception('erroracplocalo365notconfig', 'local_o365');
            }

            $httpclient = new \local_o365\httpclient();
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();

            $sptoken = \local_o365\utils::get_app_or_system_token($sharepointtokenresource, $clientdata, $httpclient);
            if (empty($sptoken)) {
                throw new \moodle_exception('erroracpnosptoken', 'local_o365');
            }

            $sharepoint = new \local_o365\rest\sharepoint($sptoken, $httpclient);
        } catch (\Exception $e) {
            $errmsg = 'ERROR: Problem initializing SharePoint API. Reason: '.$e->getMessage();
            mtrace($errmsg);
            \local_o365\utils::debug($errmsg, 'local_o365\task\sharepointinit::execute');
            set_config('sharepoint_initialized', 'error', 'local_o365');
            return false;
        }
        // Set up sharepoint access info.
        $tokenresource = \local_o365\rest\sharepoint::get_tokenresource();
        $parentsite = \local_o365\rest\sharepoint::get_moodle_parent_site_uri();
        // Check each Moodle course.
        foreach ($allcourses as $key => $value) {
            $isonsp = false;
            $isindb = false;
            $isinjson = false;
            // If there's a course in the array, and it's not the frontpage, look for it on sharepoint, in db, and in JSON.
            if (array_key_exists($key, $allcourses) && $key > 1) {
                // Look on sharepoint.
                $siteurl = strtolower(preg_replace('/[^a-z0-9_]+/iu', '', $allcourses[$key]->shortname));
                $fullsiteurl = $tokenresource.'/'.$parentsite.'/'.$siteurl;
                $sitespvalid = \local_o365\rest\sharepoint::validate_site($fullsiteurl, $clientdata, $httpclient);
                // If the course is on sharepoint already, make sure it's in the json.
                if ($sitespvalid === 'notempty') {
                    // If not in json, add to json.
                    $isinjson = array_key_exists($allcourses[$key]->id, $subsitesconfig);
                    if (!$isinjson) {
                        // Add to json.
                        $subsitesconfig[$allcourses[$key]->id] = true;
                    }
                    // Get subsite DB record.
                    $spsite = $DB->get_record('local_o365_coursespsite', ['courseid' => $allcourses[$key]->id]);
                    // Get site data.
                    $sitedata = $sharepoint->get_site();
                    // If not in DB, add to DB.
                    if (!$spsite) {
                        $siterec = new \stdClass;
                        $siterec->courseid = $allcourses[$key]->id;
                        $siterec->siteid = $sitedata['Id'];
                        $siterec->siteurl = $sitedata['ServerRelativeUrl'];
                        $siterec->timecreated = $now;
                        $siterec->timemodified = $now;
                        $siterec->id = $DB->insert_record('local_o365_coursespsite', $siterec);
                    }
                }
            }
        }
        // Save and return the JSON object.
        set_config('sharepointsubsitescustom', json_encode($subsitesconfig), 'local_o365');
        return $subsitesconfig;
    }
}
