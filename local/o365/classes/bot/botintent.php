<?php
/**
* @package local_o365
* @author  Remote-Learner.net Inc
* @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
* @copyright (C) 2016 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
*/

namespace local_o365\bot;

class botintent{

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
        'get-help'=> 'help'
    ];

    public function __construct($params){
        global $USER;
        $this->userlanguage = $USER->lang;
        $this->entities = $params['entities'];
        $intent = $params['intent'];
        if($intentclassname = $this->availableintents[$intent]){
            $this->intetclass = "\\local_o365\\bot\\intents\\$intentclassname";
        }else{
            $this->intetobject = null;
        }
    }

    public function get_message(){
        if($this->intetclass){
            $message = $this->intetclass::get_message($this->userlanguage, $this->entities);
            $message['language'] = $this->userlanguage;
            return $message;
        }else{
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