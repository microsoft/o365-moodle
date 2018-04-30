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
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

/**
 * Initialize SharePoint site.
 */
class sharepointinit extends \core\task\adhoc_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_sharepointinit', 'local_o365');
    }

    /**
     * Do the job.
     */
    public function execute() {
        global $DB;

        if (\local_o365\utils::is_configured() !== true) {
            return false;
        }

        $this->execute_legacy();

        /*
        Uncomment when site creation is available in graph API.
        $graphconfigured = \local_o365\rest\unified::is_configured();
        if ($graphconfigured === true) {
            $this->execute_graph();
        } else {
            $this->execute_legacy();
        }
        */
    }

    protected function execute_graph() {
        global $DB;
        mtrace('SharePoint Init using Graph API...');

        try {
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            $httpclient = new \local_o365\httpclient();
            $resource = \local_o365\rest\unified::get_resource();
            $token = \local_o365\utils::get_app_or_system_token($resource, $clientdata, $httpclient);
            if (empty($token)) {
                throw new \moodle_exception('erroracpnosptoken', 'local_o365');
            }
            $apiclient = new \local_o365\rest\unified($token, $httpclient);
        } catch (\Exception $e) {
            $errmsg = 'ERROR: Problem initializing SharePoint API. Reason: '.$e->getMessage();
            mtrace($errmsg);
            \local_o365\utils::debug($errmsg, 'local_o365\task\sharepointinit::execute');
            set_config('sharepoint_initialized', 'error', 'local_o365');
            return false;
        }

        // Get configured site and validate.
        try {
            $spsiteurl = get_config('local_o365', 'sharepointlink');
            $valid = $apiclient->sharepoint_validate_site($spsiteurl);
            if ($valid === 'invalid') {
                throw new \Exception('Invalid sharepoint site URL');
            }
            mtrace('Using site '.$spsiteurl.'...');
            $parsedurl = parse_url($spsiteurl);
        } catch (\Exception $e) {
            $errmsg = 'ERROR: Problem initializing SharePoint integration. Reason: '.$e->getMessage();
            mtrace($errmsg);
            \local_o365\utils::debug($errmsg, 'local_o365\task\sharepointinit::execute');
            set_config('sharepoint_initialized', 'error', 'local_o365');
            return false;
        }

        // Create parent site(s).
        try {
            $nopath = (empty($parsedurl['path']) || $parsedurl['path'] === '/') ? true : false;
            if ($nopath === false && $valid === 'valid') {
                // We only have to create the parent site if there is a path and the site does not exist.
                mtrace('Requested site does not exist, creating it and any ancestors...');
                $path = trim($parsedurl['path'], '/');
                $currentparentsite = '';
                foreach ($path as $pathpart) {
                    $currentparentsite .= '/'.$pathpart;
                    $siteexists = $apiclient->sharepoint_site_exists($parsedurl['host'], $currentparentsite);
                    if ($siteexists === false) {
                        $moodlesitename = get_string('acp_parentsite_name', 'local_o365');
                        $moodlesitedesc = get_string('acp_parentsite_desc', 'local_o365');
                        $frontpagerec = $DB->get_record('course', ['id' => SITEID], 'id,shortname');
                        if (!empty($frontpagerec) && !empty($frontpagerec->shortname)) {
                            $moodlesitename = $frontpagerec->shortname;
                        }
                        mtrace('Setting parent site to "'.$currentparentsite.'", creating subsite "'.$partialurl.'"');
                        $result = $apiclient->sharepoint_create_site($parsedurl['host'], $currentparentsite, $moodlesitename, $moodlesitedesc);
                        mtrace('Created parent site "'.$currentparentsite.'"');
                    } else {
                        mtrace('Parent site "'.$currentparentsite.'" already exists.');
                    }
                }
                mtrace('Finished creating Moodle parent site(s).');
            }
        } catch (\Exception $e) {
            $errmsg = 'ERROR: Problem creating parent site. Reason: '.$e->getMessage();
            mtrace($errmsg);
            \local_o365\utils::debug($errmsg, 'local_o365\task\sharepointinit::execute');
            set_config('sharepoint_initialized', 'error', 'local_o365');
            return false;
        }

        // Create course sites.
        mtrace('Creating course subsites in "'.$spsiteurl.'"');
        $courses = $DB->get_recordset('course');
        $successes = [];
        $failures = [];
        foreach ($courses as $course) {
            if ($course->id == SITEID) {
                continue;
            }

            if (\local_o365\feature\sharepointcustom\utils::course_subsite_enabled($course) === true) {
                try {
                    // $sharepoint->create_course_site($course); TODO - Once site creation is enabled in graph API.
                    $successes[] = $course->id;
                    mtrace('Created course subsite for course '.$course->id);
                } catch (\Exception $e) {
                    mtrace('Encountered error creating course subsite for course '.$course->id);
                    $failures[$course->id] = $e->getMessage();
                }
            } else {
                mtrace('Skipping course '.$course->id.' (not enabled)');
            }
        }

        if (!empty($failures)) {
            $errmsg = 'ERROR: Encountered problems creating course sites.';
            mtrace($errmsg.' See logs.');
            \local_o365\utils::debug($errmsg, 'local_o365\task\sharepointinit::execute', $failures);
            set_config('sharepoint_initialized', 'error', 'local_o365');
        } else {
            set_config('sharepoint_initialized', '1', 'local_o365');
            mtrace('SharePoint successfully initialized.');
            return true;
        }
    }

    protected function execute_legacy() {
        global $DB;
        mtrace('SharePoint Init using Legacy API...');

        // API Setup.
        try {
            $spresource = \local_o365\rest\sharepoint::get_resource();
            if (empty($spresource)) {
                throw new \moodle_exception('erroracplocalo365notconfig', 'local_o365');
            }

            $httpclient = new \local_o365\httpclient();
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();

            $sptoken = \local_o365\utils::get_app_or_system_token($spresource, $clientdata, $httpclient);
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
        $courses = $DB->get_recordset('course');
        $successes = [];
        $failures = [];
        foreach ($courses as $course) {
            if ($course->id == SITEID) {
                continue;
            }

            if (\local_o365\feature\sharepointcustom\utils::course_subsite_enabled($course) === true) {
                try {
                    $sharepoint->create_course_site($course);
                    $successes[] = $course->id;
                    mtrace('Created course subsite for course '.$course->id);
                } catch (\Exception $e) {
                    mtrace('Encountered error creating course subsite for course '.$course->id);
                    $failures[$course->id] = $e->getMessage();
                }
            } else {
                mtrace('Skipping course '.$course->id.' (not enabled)');
            }
        }
        if (!empty($failures)) {
            $errmsg = 'ERROR: Encountered problems creating course sites.';
            mtrace($errmsg.' See logs.');
            \local_o365\utils::debug($errmsg, 'local_o365\task\sharepointinit::execute', $failures);
            set_config('sharepoint_initialized', 'error', 'local_o365');
        } else {
            set_config('sharepoint_initialized', '1', 'local_o365');
            mtrace('SharePoint successfully initialized.');
            return true;
        }
    }
}
