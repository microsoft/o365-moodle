<?php

namespace local_o365\bot\intents;

class worststudentslastassignments implements \local_o365\bot\intents\intentinterface
{
    function get_message($language, $entities = [])
    {
        global $USER, $DB, $PAGE;
        $listitems = [];
        $warnings = [];
        $listTitle = '';
        $message = '';

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
            $coursessqlparam = join(',', $courses);
            $sql = 'SELECT ag.assignment FROM {assign_grades} ag
                    JOIN {assign} a ON a.id = ag.assignment
                    WHERE a.course IN ('.$coursessqlparam.')
                    ORDER BY ag.timemodified DESC
                    LIMIT 1';
            $assignment = $DB->get_field_sql($sql);
        }

        if (empty($assignment)) {
            $message = get_string_manager()->get_string('no_graded_assignments_found', 'local_o365', null, $language);
            $warnings[] = array(
                'item' => 'assignments',
                'itemid' => 0,
                'warningcode' => '1',
                'message' => 'No  graded assignments found'
            );
        } else {
            $cm = get_coursemodule_from_instance('assign',$assignment);
            $listTitle = get_string_manager()->get_string('assignment', 'local_o365', null, $language).' - '.$cm->name;
            $message = get_string_manager()->get_string('list_of_students_with_least_score', 'local_o365', null, $language);
            $sql = 'SELECT * FROM {assign_grades} WHERE assignment = :aid AND grade != :gradenotgraded ORDER BY grade ASC';
            $sql .= ' LIMIT '.self::DEFAULT_LIMIT_NUMBER;

            $params = ['aid' => $assignment, 'gradenotgraded' => ASSIGN_GRADE_NOT_SET];
            $grades = $DB->get_records_sql($sql, $params);
            foreach ($grades as $g) {
                $user = $DB->get_record('user', ['id' => $g->userid], 'id, username, firstname, lastname');
                $userpicture = new \user_picture($user);
                $userpicture->size = 1;
                $pictureurl = $userpicture->get_url($PAGE)->out(false);
                $subtitledata = new \stdClass();
                $subtitledata->grade = $g->grade;
                $subtitledata->date = date('d/m/Y', $g->timemodified);
                $grade = array(
                    'title' => $user->firstname.' '.$user->lastname,
                    'subtitle' => get_string_manager()->get_string('grade_date', 'local_o365', $subtitledata, $language),
                    'icon' => $pictureurl,
                    'action' => null,
                    'actionType' => null
                );
                $listitems[] = $grade;
            }

            if (empty($listitems)) {
                $message = get_string_manager()->get_string('no_grades_found', 'local_o365', null, $language);
                $warnings[] = array(
                    'item' => 'grades',
                    'itemid' => 0,
                    'warningcode' => '2',
                    'message' => 'No grades found'
                );
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