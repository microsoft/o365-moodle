<?php

namespace local_o365\bot\intents;

class lateststudents implements \local_o365\bot\intents\intentinterface
{
    function get_message($language, $entities = [])
    {
        global $USER, $DB, $PAGE;
        $listitems = [];
        $warnings = [];
        $listTitle = '';
        $message = '';

        $lastloggedsql = "SELECT u.id, u.username, CONCAT(u.firstname, ' ', u.lastname) as fullname, u.lastaccess FROM {user} u
                    WHERE u.suspended = 0 AND u.deleted = 0 AND u.lastaccess > 0";

        if(!is_siteadmin()){
            $courses = array_keys(enrol_get_users_courses($USER->id, true, 'id'));
            $teachercourses = [];
            foreach($courses as $course){
                $context = \context_course::instance($course, IGNORE_MISSING);
                if (!has_capability('moodle/grade:edit', $context)) {
                    continue;
                }
                $teachercourses[] = $course;
            }
            $courses = $teachercourses;
            if(!empty($courses)){
                $userssql = 'SELECT u.id FROM {user} u ';
                $coursessqlparam = join(',', $courses);
                $userssql .= " JOIN {role_assignments} ra ON u.id = ra.userid 
                               JOIN {role} r ON ra.roleid = r.id AND r.shortname = 'student'
                               JOIN {context} c ON c.id = ra.contextid AND c.contextlevel = 50 AND c.instanceid IN ($coursessqlparam)
                               ";
                $userssql .= ' WHERE u.deleted = 0 AND u.suspended = 0';

                $userslist = $DB->get_fieldset_sql($userssql);
                $userssqlparam = join(',', $userslist);
                $lastloggedsql .= ' AND u.id IN ('.$userssqlparam.')';
            }else{
                $lastloggedsql .= ' AND u.id IN ('.$USER->id.')';
            }
        }
        $lastloggedsql .= ' ORDER BY u.lastaccess ASC';
        $lastloggedsql .= ' LIMIT '.self::DEFAULT_LIMIT_NUMBER;

        $users = $DB->get_records_sql($lastloggedsql);

        if (empty($users)) {
            $message = get_string_manager()->get_string('no_users_found', 'local_o365', null, $language);
            $warnings[] = array(
                'item' => 'users',
                'itemid' => 0,
                'warningcode' => '1',
                'message' => 'No  users found'
            );
        }else{
            $message = get_string_manager()->get_string('list_of_latest_logged_students', 'local_o365', null, $language);
            foreach($users as $user){
                $userpicture = new \user_picture($user);
                $userpicture->size = 1;
                $pictureurl = $userpicture->get_url($PAGE)->out(false);
                $subtitledata = date('d/m/Y H:i', $user->lastaccess);
                $listitems[] = [
                    'title' => $user->fullname,
                    'subtitle' => get_string_manager()->get_string('last_login_date', 'local_o365', $subtitledata, $language),
                    'icon' => $pictureurl,
                    'action' => null,
                    'actionType' => null
                ];
            }
        }

        return array(
            'message' => $message,
            'listTitle' => $listTitle,
            'listItems' => $listitems,
            'warnings' => $warnings
        );
    }
}