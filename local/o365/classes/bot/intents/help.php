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

class help implements \local_o365\bot\intents\intentinterface {
    public function get_message($language, $entities = []) {
        global $CFG, $USER, $DB;
        $listitems = [];
        $warnings = [];
        $listtitle = '';
        $message = '';

        $questions = file_get_contents($CFG->dirroot . '/local/o365/classes/bot/bot_questions_list.json');
        $questions = json_decode($questions);

        $roles = $DB->get_fieldset_sql('SELECT DISTINCT(r.shortname) FROM {role_assignments} ra
                            JOIN {role} r ON r.id = ra.roleid
                            WHERE ra.userid = :userid ', ['userid' => $USER->id]);
        $message = get_string_manager()->get_string('help_message', 'local_o365', null, $language);
        foreach ($roles as $role) {
            if ($questions->{$role}) {
                foreach ($questions->{$role} as $question) {
                    $text = get_string_manager()->get_string($question->text, 'local_o365', null, $language);
                    $action = ($question->clickable ? $text : null);
                    $actiontype = ($question->clickable ? 'imBack' : null);
                    $listitems[] = [
                            'title' => $text,
                            'subtitle' => null,
                            'icon' => 'http://www.e-technology.com.au/wp-content/uploads/2018/05/moodle-logo-39b36ce704607472-512x512-300x300.png',
                            'action' => $action,
                            'actionType' => $actiontype
                    ];

                }
            }
        }
        return array(
                'message' => $message,
                'listTitle' => $listtitle,
                'listItems' => $listitems,
                'warnings' => $warnings
        );
    }
}