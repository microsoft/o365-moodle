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

require_once($CFG->dirroot . '/mod/assign/locallib.php');

class assignmentsforgrading implements \local_o365\bot\intents\intentinterface {
    public function get_message($language, $entities = []) {
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
            $sql = 'SELECT assign.id FROM
                    (SELECT a.id FROM {assign} a JOIN {assign_submission} asub ON asub.assignment = a.id WHERE a.course IN ('
                    . $coursessqlparam . ') ORDER BY asub.timecreated DESC) assign GROUP BY assign.id';
            $assignments = $DB->get_fieldset_sql($sql);
        } else {
            $assignments = [];
        }

        if (empty($assignments)) {
            $message = get_string_manager()->get_string('no_assignments_for_grading_found', 'local_o365', null, $language);
            $warnings[] = array(
                    'item' => 'assignments',
                    'itemid' => 0,
                    'warningcode' => '1',
                    'message' => 'No  assignments for grading found'
            );
        } else {
            $message = get_string_manager()->get_string('list_of_assignments_needs_grading', 'local_o365', null, $language);
            foreach ($assignments as $aid) {
                $cm = get_coursemodule_from_instance('assign', $aid);
                $cmcontext = \context_module::instance($cm->id);
                $assign = new \assign($cmcontext, $cm, $cm->course);
                $url = new \moodle_url("/mod/assign/view.php", ['id' => $cm->id]);
                $currentgroup = groups_get_activity_group($assign->get_course_module(), true);
                $needsgrading = $assign->count_submissions_need_grading($currentgroup);
                if ($needsgrading == 0) {
                    continue;
                }
                $subtitledata = new \stdClass();
                $subtitledata->participants = $assign->count_participants($currentgroup);
                $subtitledata->submitted = $assign->count_submissions_with_status(ASSIGN_SUBMISSION_STATUS_SUBMITTED, $currentgroup);
                $subtitledata->needsgrading = $assign->count_submissions_need_grading($currentgroup);
                $assignment = array(
                        'title' => $cm->name,
                        'subtitle' => get_string_manager()->get_string('participants_submitted_needs_grading', 'local_o365',
                                $subtitledata, $language),
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
            $message = get_string_manager()->get_string('no_assignments_for_grading_found', 'local_o365', null, $language);
            $warnings[] = array(
                    'item' => 'assignments',
                    'itemid' => 0,
                    'warningcode' => '2',
                    'message' => 'No assignments that needs grading found'
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