<?php

namespace local_o365\bot\intents;

class assignmentcomparison implements \local_o365\bot\intents\intentinterface
{
    function get_message($language, $entities = [])
    {
        global $USER, $DB, $OUTPUT;
        $listitems = [];
        $warnings = [];
        $listTitle = '';
        $message = '';

        $sql = "SELECT gi.iteminstance, g.itemid, g.finalgrade, g.timemodified FROM {grade_grades} g
                JOIN {grade_items} gi ON gi.id = g.itemid
                WHERE g.userid = ? AND gi.itemmodule LIKE 'assign' AND g.finalgrade IS NOT NULL
                ORDER BY g.timemodified DESC";

        $sql .= " LIMIT ".self::DEFAULT_LIMIT_NUMBER;

        $sqlparams = [$USER->id];
        $assignments = $DB->get_records_sql($sql, $sqlparams);

        if (empty($assignments)) {
            $message = get_string_manager()->get_string('no_assignments_found', 'local_o365', null, $language);
            $warnings[] = array(
                'item' => 'grades',
                'itemid' => 0,
                'warningcode' => '1',
                'message' => 'No assignments found'
            );
        } else {
            $message = get_string_manager()->get_string('list_of_assignments_grades_compared', 'local_o365', null, $language);
            foreach($assignments as $assign){
                $cm = get_coursemodule_from_instance('assign', $assign->iteminstance);
                $coursecontext = \context_course::instance($cm->course);
                $course = get_course($cm->course);
                $group = groups_get_course_group($course);
                $participants = get_enrolled_users($coursecontext,'',$group,'u.id',null,0,0,false);
                $participants = join(',', array_keys($participants));
                $url = new \moodle_url("/mod/assign/view.php", ['id' => $cm->id]);
                $sql = "SELECT g.itemid, COUNT(*) AS amount, SUM(g.finalgrade) AS sum
                      FROM {grade_items} gi
                      JOIN {grade_grades} g ON g.itemid = gi.id
                      JOIN {user} u ON u.id = g.userid                      
                     WHERE gi.itemmodule LIKE 'assign' 
                       AND gi.iteminstance = :assignmentid
                       AND u.deleted = 0
                       AND g.finalgrade IS NOT NULL
                       AND u.id IN ($participants)                      
                     GROUP BY g.itemid";
                $sqlparams = ['assignmentid' => $assign->iteminstance];
                $average = $DB->get_record_sql($sql, $sqlparams);
                $subtitledata = new \stdClass();
                $subtitledata->usergrade = $assign->finalgrade;
                $subtitledata->classgrade = $average->sum / $average->amount;
                $assignment = array(
                    'title' => $cm->name,
                    'subtitle' => get_string_manager()->get_string('your_grade_class_grade', 'local_o365', $subtitledata, $language),
                    'icon' => $OUTPUT->image_url('icon', 'assign')->out(),
                    'action' => $url->out(),
                    'actionType' => 'openUrl'
                );
                $listitems[] = $assignment;
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