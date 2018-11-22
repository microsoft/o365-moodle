<?php

namespace local_o365\bot\intents;

require_once($CFG->dirroot.'/mod/assign/lib.php');

class dueassignments implements \local_o365\bot\intents\intentinterface
{
    function get_message($language, $entities = [])
    {
        global $USER, $DB, $OUTPUT;
        $listitems = [];
        $warnings = [];
        $listTitle = '';
        $message = '';

        $fields = 'sortorder,shortname,fullname,timemodified';

        // We need to check for enrolments.
        $courses = enrol_get_users_courses($USER->id, true, $fields);

        if(!empty($courses)){
            $message = get_string_manager()->get_string('list_of_due_assignments', 'local_o365', null, $language);
            $courseids = implode(",", array_keys($courses));
            $assignments = $DB->get_records_sql("SELECT * FROM {assign} a WHERE a.course IN (".$courseids.") AND a.duedate > UNIX_TIMESTAMP() ORDER BY a.duedate ASC");
            foreach ($assignments as $assignment) {
                $cm = get_coursemodule_from_instance('assign', $assignment->id);
                $course = get_course($assignment->course);
                if(\assign_get_completion_state($course,$cm, $USER->id,false)){
                    continue;
                }

                $url = new \moodle_url('/mod/assign/view.php', ['id' => $cm->id]);
                $subtitledata = date('d/m/Y', $assignment->duedate);
                $assignment = array(
                    'title' => $assignment->name,
                    'subtitle' => get_string_manager()->get_string('due_date', 'local_o365', $subtitledata, $language),
                    'icon' => $OUTPUT->image_url('icon', 'assign')->out(),
                    'action' => $url->out(),
                    'actionType' => 'openUrl'
                );
                $listitems[] = $assignment;
                if(count($listitems) == self::DEFAULT_LIMIT_NUMBER){
                    break;
                }
            }
        }
        if(empty($listitems)){
            $message = get_string_manager()->get_string('no_due_assignments_found', 'local_o365', null, $language);
            $warnings[] = array(
                'item' => 'assignments',
                'itemid' => 0,
                'warningcode' => '1',
                'message' => 'No due assignments found'
            );
        }

        return array(
            'message' => $message,
            'listTitle' => $listTitle,
            'listItems' => $listitems,
            'warnings' => $warnings
        );
    }
}