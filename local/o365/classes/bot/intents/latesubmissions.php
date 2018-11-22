<?php

namespace local_o365\bot\intents;

class latesubmissions implements \local_o365\bot\intents\intentinterface
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
            $sql = 'SELECT ass.id, ass.userid, ass.assignment, ass.timemodified, a.duedate, co.fullname as coursename FROM {assign_submission} ass
                    JOIN {assign} a ON ass.assignment = a.id 
                    JOIN {course} co ON co.id = a.course
                    WHERE a.course IN ('.$coursessqlparam.') AND ass.status LIKE "'.ASSIGN_SUBMISSION_STATUS_SUBMITTED.'" AND a.duedate < ass.timemodified 
                    ORDER BY ass.timecreated DESC';
            $sql .= ' LIMIT '.self::DEFAULT_LIMIT_NUMBER;

            $submissions = $DB->get_records_sql($sql);
        }else{
            $submissions = [];
        }

        if (empty($submissions)) {
            $message = get_string_manager()->get_string('no_late_submissions_found', 'local_o365', null, $language);
            $warnings[] = array(
                'item' => 'submissions',
                'itemid' => 0,
                'warningcode' => '1',
                'message' => 'No  late submissions found'
            );
        } else {
            $message = get_string_manager()->get_string('list_of_late_submissions', 'local_o365', null, $language);
            foreach ($submissions as $submission) {
                $cm = get_coursemodule_from_instance('assign', $submission->assignment);
                $user = $DB->get_record('user', ['id' => $submission->userid], 'id, username, firstname, lastname');
                $userpicture = new \user_picture($user);
                $userpicture->size = 1;
                $pictureurl = $userpicture->get_url($PAGE)->out(false);
                $url = new \moodle_url('/mod/assign/view.php', ['action' => 'grading', 'id'=> $cm->id, 'tsort' => 'timesubmitted']);
                $subtitledata = new \stdClass();
                $subtitledata->coursename = $submission->coursename;
                $subtitledata->assignment = $cm->name;
                $subtitledata->submittedon = date('d/mY', $submission->timemodified);
                $subtitledata->duedate = date('d/m/Y', $submission->duedate);
                $record = array(
                    'title' => $user->firstname.' '.$user->lastname,
                    'subtitle' => get_string_manager()->get_string('course_assignment_submitted_due', 'local_o365', $subtitledata, $language),
                    'icon' => $pictureurl,
                    'action' => $url->out(),
                    'actionType' => 'openUrl'
                );
                $listitems[] = $record;
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