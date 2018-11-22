<?php

namespace local_o365\bot\intents;

class help implements \local_o365\bot\intents\intentinterface
{
    function get_message($language, $entities = [])
    {
        global $CFG, $USER, $DB;
        $listitems = [];
        $warnings = [];
        $listTitle = '';
        $message = '';

        $questions = file_get_contents($CFG->dirroot.'/local/o365/classes/bot/bot_questions_list.json');
        $questions = json_decode($questions);

        $roles = $DB->get_fieldset_sql('SELECT DISTINCT(r.shortname) FROM {role_assignments} ra 
                            JOIN {role} r ON r.id = ra.roleid
                            WHERE ra.userid = :userid ', ['userid' => $USER->id]);
        $message = get_string_manager()->get_string('help_message', 'local_o365', null, $language);
        foreach($roles as $role){
            if($questions->{$role}){
                foreach($questions->{$role} as $question){
                    $text = get_string_manager()->get_string($question->text, 'local_o365', null, $language);
                    $action = ($question->clickable ? $text : null);
                    $actionType = ($question->clickable ? 'imBack' : null);
                    $listitems[] = [
                        'title' => $text,
                        'subtitle' => null,
                        'icon' => 'http://www.e-technology.com.au/wp-content/uploads/2018/05/moodle-logo-39b36ce704607472-512x512-300x300.png',
                        'action' => $action,
                        'actionType' => $actionType
                    ];

                }
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