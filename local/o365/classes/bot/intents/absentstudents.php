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
 * @author  Enovation Solutions
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365\bot\intents;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/accesslib.php');

/**
 * Class absentstudents implements bot intent interface for teacher-absent-students intent
 * @package local_o365\bot\intents
 */
class absentstudents implements \local_o365\bot\intents\intentinterface {
    /**
     * Gets absent students message for bot with all required params
     * @param $language - Message language
     * @param mixed $entities - Intent entities (optional and not used at the moment)
     * @return array|string - Bot message structure with data
     */
    public function get_message($language, $entities = null) {
        global $USER, $DB, $PAGE;
        $listitems = [];
        $warnings = [];
        $courses = [];

        if (!is_siteadmin()) {
            $courses = \local_o365\bot\intents\intentshelper::getteachercourses($USER->id);
        }
        if (!empty($courses) || is_siteadmin()) {
            $monthstart = mktime(0, 0, 0, date("n"), 1);
            $userssql = 'SELECT u.id, u.username, u.firstname, u.lastname, u.lastaccess, u.picture FROM {user} u ';
            $sqlparams = [];
            if (!empty($courses)) {
                list($coursessql, $coursesparams) = $DB->get_in_or_equal($courses, SQL_PARAMS_NAMED);
                $userssql .= " JOIN {role_assignments} ra ON u.id = ra.userid
                    JOIN {role} r ON ra.roleid = r.id AND r.shortname = :studentstr
                    JOIN {context} c ON c.id = ra.contextid AND c.contextlevel = :contextcourse AND c.instanceid $coursessql
                ";
                $sqlparams['studentstr'] = 'student';
                $sqlparams['contextcourse'] = CONTEXT_COURSE;
                $sqlparams = array_merge($sqlparams, $coursesparams);
            }
            $userssql .= ' WHERE u.lastaccess < :monthstart AND u.deleted = 0 AND u.suspended = 0';
            $sqlparams['monthstart'] = $monthstart;
            $userssql .= ' ORDER BY u.lastaccess DESC';
            $userssql .= ' LIMIT ' . self::DEFAULT_LIMIT_NUMBER;
            $userslist = $DB->get_records_sql($userssql, $sqlparams);
        }
        if (empty($userslist)) {
            $message = get_string_manager()->get_string('no_absent_users_found', 'local_o365', null, $language);
            $warnings[] = array(
                    'item' => 'users',
                    'itemid' => 0,
                    'warningcode' => '1',
                    'message' => 'No  absent users found'
            );
        } else {
            $message = get_string_manager()->get_string('list_of_absent_students', 'local_o365', null, $language);
            foreach ($userslist as $user) {
                $userpicture = new \user_picture($user);
                $userpicture->size = 1;
                $pictureurl = $userpicture->get_url($PAGE)->out(false);
                $date = (empty($user->lastaccess) ? get_string('never', 'local_o365') : date('d/m/Y', $user->lastaccess));
                $listitems[] = array(
                        'title' => $user->firstname . ' ' . $user->lastname,
                        'subtitle' => get_string_manager()->get_string('last_login_date', 'local_o365', $date, $language),
                        'icon' => $pictureurl,
                        'action' => null,
                        'actionType' => null
                );
            }
        }
        return array(
                'message' => $message,
                'listTitle' => '',
                'listItems' => $listitems,
                'warnings' => $warnings
        );
    }
}