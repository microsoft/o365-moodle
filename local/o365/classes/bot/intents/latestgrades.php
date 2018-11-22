<?php

namespace local_o365\bot\intents;

class latestgrades implements \local_o365\bot\intents\intentinterface
{
    function get_message($language, $entities = [])
    {
        global $USER, $DB, $OUTPUT;
        $listitems = [];
        $warnings = [];
        $listTitle = '';
        $message = '';

        $activities = [
            'assign',
            'quiz'
        ];
        $activities = join("','", $activities);
        $sql = "SELECT g.id, gi.itemmodule, gi.iteminstance, g.finalgrade, g.timemodified FROM {grade_grades} g
                JOIN {grade_items} gi ON gi.id = g.itemid
                WHERE g.userid = ? AND gi.itemmodule IN ('$activities') AND g.finalgrade IS NOT NULL
                ORDER BY g.timemodified DESC";
        $sql .= " LIMIT ".self::DEFAULT_LIMIT_NUMBER;
        $sqlparams = [$USER->id];
        $grades = $DB->get_records_sql($sql, $sqlparams);
        if (empty($grades)) {
            $message = get_string_manager()->get_string('no_grades_found', 'local_o365', null, $language);
            $warnings[] = array(
                'item' => 'grades',
                'itemid' => 0,
                'warningcode' => '1',
                'message' => 'No grades found'
            );
        } else {
            $message = get_string_manager()->get_string('list_of_recent_grades', 'local_o365', null, $language);
            foreach($grades as $grade){
                $cm = get_coursemodule_from_instance($grade->itemmodule, $grade->iteminstance);
                $url = new \moodle_url("/mod/{$grade->itemmodule}/view.php", ['id' => $grade->iteminstance]);
                $subtitledata = $grade->finalgrade;
                $grade = array(
                    'title' => $cm->name,
                    'subtitle' => get_string_manager()->get_string('your_grade', 'local_o365', $subtitledata, $language),
                    'icon' => $OUTPUT->image_url('icon',  $grade->itemmodule)->out(),
                    'action' => $url->out(),
                    'actionType' => 'openUrl'
                );
                $listitems[] = $grade;
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