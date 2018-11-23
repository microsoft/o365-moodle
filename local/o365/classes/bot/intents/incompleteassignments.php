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

class incompleteassignments implements \local_o365\bot\intents\intentinterface {
    public function get_message($language, $entities = null) {
        global $USER, $DB, $OUTPUT;
        $listitems = [];
        $warnings = [];
        $listtitle = '';
        $message = '';

        $courses = array_keys(enrol_get_users_courses($USER->id, true, 'id'));
        $teachercourses = [];
        foreach ($courses as $course) {
            $context = \context_course::instance($course, IGNORE_MISSING);
            if (!has_capability('moodle/grade:edit', $context)) {
                continue;
            }
            $teachercourses[] = $course;
        }
        $courses = $teachercourses;
        if (!empty($courses)) {
            $coursessqlparam = join(',', $courses);
            $sql = "SELECT id, duedate FROM {assign}
                    WHERE course IN ($coursessqlparam) AND duedate > UNIX_TIMESTAMP()
                    ORDER BY duedate ASC";
            $assignments = $DB->get_records_sql($sql);
        } else {
            $assignments = [];
        }

        if (empty($assignments)) {
            $message = get_string_manager()->get_string('no_due_assignments_found', 'local_o365', null, $language);
            $warnings[] = array(
                    'item' => 'assignments',
                    'itemid' => 0,
                    'warningcode' => '1',
                    'message' => 'No due assignments found'
            );
        } else {
            $message = get_string_manager()->get_string('list_of_incomplete_assignments', 'local_o365', null, $language);
            foreach ($assignments as $assign) {
                $cm = get_coursemodule_from_instance('assign', $assign->id);
                $url = new \moodle_url("/mod/assign/view.php", ['id' => $cm->id]);
                $coursecontext = \context_course::instance($cm->course);
                $enrolledusers = get_enrolled_users($coursecontext, '', 0, 'u.id', null, 0, 0, true);
                $enrolledusers = array_keys($enrolledusers);
                $enrolledteachers = get_enrolled_users($coursecontext, 'moodle/grade:edit', 0, 'u.id', null, 0, 0, true);
                $enrolledteachers = array_keys($enrolledteachers);
                $enrolledusers = array_diff($enrolledusers, $enrolledteachers);
                $total = count($enrolledusers);
                $completedusers = $DB->get_fieldset_sql('SELECT DISTINCT(userid) FROM {course_modules_completion}
                                        WHERE coursemoduleid = :cmid AND completionstate > 0', array('cmid' => $cm->id));
                $completedusers = array_diff($completedusers, $enrolledteachers);
                $completedusers = count($completedusers);
                $incomplete = $total - $completedusers;
                if ($incomplete == 0) {
                    continue;
                }
                $subtitledata = new \stdClass();
                $subtitledata->incomplete = $incomplete;
                $subtitledata->total = $total;
                $subtitledata->duedate = date('d/m/Y', $assign->duedate);
                $assignment = array(
                        'title' => $cm->name,
                        'subtitle' => get_string_manager()->get_string('pending_submissions_due_date', 'local_o365', $subtitledata,
                                $language),
                        'icon' => $OUTPUT->image_url('icon', 'assign')->out(),
                        'action' => $url->out(),
                        'actionType' => 'openUrl'
                );
                $listitems[] = $assignment;
                if (count($listitems) == self::DEFAULT_LIMIT_NUMBER) {
                    break;
                }
            }
        }
        if (empty($listitems)) {
            $message = get_string_manager()->get_string('no_due_incomplete_assignments_found', 'local_o365', null, $language);
            $warnings[] = array(
                    'item' => 'assignments',
                    'itemid' => 0,
                    'warningcode' => '2',
                    'message' => 'No due and incomplete assignments found'
            );
        }
        return array(
                'message' => $message,
                'listTitle' => $listtitle,
                'listItems' => $listitems,
                'warnings' => $warnings
        );
    }
}