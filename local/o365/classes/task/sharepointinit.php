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
        $oidcconfig = get_config('auth_oidc');
        if (empty($oidcconfig)) {
            throw new \moodle_exception('erroracpauthoidcnotconfig', 'local_o365');
        }

        $spresource = \local_o365\rest\sharepoint::get_resource();
        if (empty($spresource)) {
            throw new \moodle_exception('erroracplocalo365notconfig', 'local_o365');
        }

        $httpclient = new \local_o365\httpclient();
        $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint,
                $oidcconfig->tokenendpoint);

        $sptoken = \local_o365\oauth2\systemtoken::instance(null, $spresource, $clientdata, $httpclient);

        if (empty($sptoken)) {
            throw new \moodle_exception('erroracpnosptoken', 'local_o365');
        }

        $sharepoint = new \local_o365\rest\sharepoint($sptoken, $httpclient);
        $sharepoint->set_site('');

        $moodlesiteuri = $sharepoint->get_moodle_parent_site_uri();

        if ($sharepoint->site_exists($moodlesiteuri) === false) {
            $moodlesitename = get_string('acp_parentsite_name', 'local_o365');
            $moodlesitedesc = get_string('acp_parentsite_desc', 'local_o365');
            $frontpagerec = $DB->get_record('course', ['id' => SITEID], 'id,shortname');
            if (!empty($frontpagerec) && !empty($frontpagerec->shortname)) {
                $moodlesitename = $frontpagerec->shortname;
            }
            $sharepoint->create_site($moodlesitename, $moodlesiteuri, $moodlesitedesc);
            mtrace('Created parent site');
        }

        $courses = $DB->get_recordset('course');
        $successes = [];
        $failures = [];
        foreach ($courses as $course) {
            if ($course->id == SITEID) {
                continue;
            }

            try {
                $sharepoint->create_course_site($course);
                $successes[] = $course->id;
                mtrace('Created course subsite for course '.$course->id);
            } catch (\Exception $e) {
                $failures[$course->id] = $e->getMessage();
            }
        }
        set_config('sharepoint_initialized', '1', 'local_o365');
    }
}