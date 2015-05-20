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
 * Create any needed groups in Office365.
 */
class groupcreate extends \core\task\scheduled_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_groupcreate', 'local_o365');
    }

    /**
     * Do the job.
     */
    public function execute() {
        global $DB;

        $configsetting = get_config('local_o365', 'creategroups');
        if (empty($configsetting)) {
            mtrace('Groups not enabled, skipping...');
            return true;
        }

        $now = time();

        $httpclient = new \local_o365\httpclient();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();

        $unifiedresource = \local_o365\rest\unified::get_resource();
        $unifiedtoken = \local_o365\oauth2\systemtoken::instance(null, $unifiedresource, $clientdata, $httpclient);
        if (empty($unifiedtoken)) {
            mtrace('Could not get unified API token.');
            return true;
        }
        $unifiedclient = new \local_o365\rest\unified($unifiedtoken, $httpclient);

        $aadresource = \local_o365\rest\azuread::get_resource();
        $aadtoken = \local_o365\oauth2\systemtoken::instance(null, $aadresource, $clientdata, $httpclient);
        if (empty($aadtoken)) {
            mtrace('Could not get AAD token.');
            return true;
        }
        $aadclient = new \local_o365\rest\azuread($aadtoken, $httpclient);

        $siterec = $DB->get_record('course', ['id' => SITEID]);
        $siteshortname = strtolower(preg_replace('/[^a-z0-9]+/iu', '', $siterec->shortname));

        $sql = 'SELECT crs.*
                  FROM {course} crs
             LEFT JOIN {local_o365_objects} obj ON obj.type = ? AND obj.subtype = ? AND obj.moodleid = crs.id
                 WHERE obj.id IS NULL AND crs.id != ?
                 LIMIT 0, 5';
        $params = ['group', 'course', SITEID];
        $courses = $DB->get_recordset_sql($sql, $params);
        foreach ($courses as $course) {
            // Create group.
            $groupname = $siterec->shortname.': '.$course->fullname;
            $groupshortname = $siteshortname.'_'.$course->shortname;
            $response = $unifiedclient->create_group($groupname, $groupshortname);
            if (empty($response) || !is_array($response) || empty($response['objectId'])) {
                mtrace('Could not create group for course #'.$course->id);
                var_dump($response);
                continue;
            }
            mtrace('Created group '.$response['objectId'].' for course #'.$course->id);
            $objectrec = [
                'type' => 'group',
                'subtype' => 'course',
                'objectid' => $response['objectId'],
                'moodleid' => $course->id,
                'o365name' => $groupname,
                'timecreated' => $now,
                'timemodified' => $now,
            ];
            $objectrec['id'] = $DB->insert_record('local_o365_objects', (object)$objectrec);
            mtrace('Recorded group object ('.$objectrec['objectid'].') into object table with record id '.$objectrec['id']);

            // It takes a little while for the group object to register.
            mtrace('Waiting 10 seconds for group to register...');
            sleep(10);

            // Add enrolled users to group.
            mtrace('Adding users to group ('.$objectrec['objectid'].')');
            $coursecontext = \context_course::instance($course->id);
            list($esql, $params) = get_enrolled_sql($coursecontext);
            $sql = "SELECT u.*,
                           tok.oidcuniqid as userobjectid
                      FROM {user} u
                      JOIN ($esql) je ON je.id = u.id
                      JOIN {auth_oidc_token} tok ON tok.username = u.username AND tok.resource = :tokresource
                     WHERE u.deleted = 0";
            $params['tokresource'] = 'https://graph.windows.net';
            $enrolled = $DB->get_recordset_sql($sql, $params);
            foreach ($enrolled as $user) {
                $response = $aadclient->add_member_to_group($objectrec['objectid'], $user->userobjectid);
                if ($response === true) {
                    mtrace('Added user #'.$user->id.' ('.$user->userobjectid.')');
                } else {
                    mtrace('Could not add user #'.$user->id.' ('.$user->userobjectid.')');
                    mtrace('Received: '.$response);
                }
            }
            $enrolled->close();
        }
        $courses->close();
    }
}