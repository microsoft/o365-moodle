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

require_once(__DIR__.'/../../config.php');

$mode = required_param('mode', PARAM_TEXT);

if (is_siteadmin() !== true) {
    throw new \Exception('Unauthorized');
}

if ($mode === 'setsystemuser') {
    $SESSION->auth_oidc_justevent = true;
    redirect(new \moodle_url('/auth/oidc/index.php'));
} else if ($mode === 'sharepointinit') {
    $oidcconfig = get_config('auth_oidc');
    if (empty($oidcconfig)) {
        throw new \Exception('Please set application credentials in auth_oidc first.');
    }

    $spresource = \local_o365\rest\sharepoint::get_resource();
    if (empty($spresource)) {
        throw new \Exception('Please configure local_o365 first.');
    }

    $httpclient = new \local_o365\httpclient();
    $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint,
            $oidcconfig->tokenendpoint);

    $sptoken = \local_o365\oauth2\systemtoken::instance($spresource, $clientdata, $httpclient);

    if (empty($sptoken)) {
        throw new \Exception('Did not have an available sharepoint token, and could not get one.');
    }

    $sharepoint = new \local_o365\rest\sharepoint($sptoken, $httpclient);
    $sharepoint->set_site('');

    $moodlesiteuri = $sharepoint->get_moodle_parent_site_uri();
    if ($sharepoint->site_exists($moodlesiteuri) === false) {
        $sharepoint->create_site('Moodle', $moodlesiteuri, 'Site for shared Moodle course data.');
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
        } catch (\Exception $e) {
            $failures[] = $course->id;
        }
    }
    set_config('sharepoint_initialized', '1', 'local_o365');
    redirect(new \moodle_url('/admin/settings.php?section=local_o365'));
}
