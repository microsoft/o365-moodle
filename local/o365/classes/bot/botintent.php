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

namespace local_o365\bot;

defined('MOODLE_INTERNAL') || die();

class botintent {

    private $intetclass;
    private $userlanguage;
    private $entities;
    private $availableintents = [
            'student-assignment-comparison-results' => 'assignmentcomparison',
            'student-due-assignments' => 'dueassignments',
            'student-latest-grades' => 'latestgrades',
            'teacher-assignments-for-grading' => 'assignmentsforgrading',
            'teacher-absent-students' => 'absentstudents',
            'teacher-incomplete-assignments' => 'incompleteassignments',
            'teacher-last-student-login' => 'laststudentlogin',
            'teacher-late-submissions' => 'latesubmissions',
            'teacher-recent-students' => 'recentstudents',
            'teacher-latest-students' => 'lateststudents',
            'teacher-worst-students-last-assignment' => 'worststudentslastassignments',
            'get-help' => 'help'
    ];

    public function __construct($params) {
        global $USER;
        $this->userlanguage = $USER->lang;
        $this->entities = $params['entities'];
        $intent = $params['intent'];
        if ($intentclassname = $this->availableintents[$intent]) {
            $this->intetclass = "\\local_o365\\bot\\intents\\$intentclassname";
        } else {
            $this->intetobject = null;
        }
    }

    public function get_message() {
        if ($this->intetclass) {
            $message = $this->intetclass::get_message($this->userlanguage, $this->entities);
            $message['language'] = $this->userlanguage;
            return $message;
        } else {
            return array(
                    'message' => get_string('sorry_do_not_understand', 'local_o365'),
                    'listTitle' => '',
                    'listItems' => [],
                    'warnings' => [],
                    'language' => $this->userlanguage
            );
        }
    }
}