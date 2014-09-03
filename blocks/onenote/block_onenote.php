<?php
require_once($CFG->dirroot.'/blocks/onenote/onenote_lib.php');
class block_onenote extends block_list {
    public function init() {
        $this->title = get_string('onenote', 'block_onenote');
    }

    public function get_content() {
        if (!isloggedin()) {
            return null;

        }

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = $this->_get_content();

        return $this->content;
    }

    public function _get_content() {
        global $SESSION;

        error_log('_get_content called');
        $content = new stdClass;
        $content->items = array();
        $content->icons = '';
        $code = optional_param('code', '', PARAM_TEXT);

        if (!empty($code)) {
            $authprovider = required_param('authprovider', PARAM_ALPHANUMEXT);
        }
      
        // OneNote client application settings
        $client_id = '00000000401290EF'; //'Mc8gpyG9wYr7f5qSr8JoQ';
        $client_secret = 'cKyZUs3chL6Z9SXTG5y9Ub2vL-5SctWm'; //'hvzBKUtj3cFkmIxjioqvSpAnNkfTfTT5X7lP8lgIOP0';
        $redirect_uri = 'http://gopikalocal.com/blocks/onenote/onenote_redirect.php';//http://vinlocaldomain.com:88 // 'http://localhost/moodleapp/blocks/yammer/yammer_redirect.php';
        $scopes = 'office.onenote_create';
        $response_type = 'code';

        $curl = new curl();
        if($code && $authprovider == 'onenote') {            
            error_log(print_r($code, true));            
            $response = $curl->get('https://login.live.com/oauth20_token.srf?client_id='.$client_id.'&client_secret='.$client_secret.'&code='.$code.'&redirect_uri='.$redirect_uri.'&grant_type=authorization_code');
            
            error_log(print_r($response, true));
            $response = json_decode($response);            
            $SESSION->onenotetoken = $response->access_token;
        }  
        if(!isset($SESSION->onenotetoken) ) {
            $content->items[] = "<a class='zocial' href='https://login.live.com/oauth20_authorize.srf?client_id=$client_id&redirect_uri=$redirect_uri&scope=$scopes&response_type=$response_type'>Sign in with OneNote</a>";
        }
        else {
         
              $curl = new curl();
              $header = array(
                        'Authorization: Bearer ' . $SESSION->onenotetoken,
                        'Content-Type: application/json'
                 );
              $curl->setHeader($header);
              
              $noteresponse = get_oneNote_notes($SESSION->onenotetoken);                            
              $notes_array = array();              
              
              if(isset($noteresponse->value)) {
                foreach($noteresponse->value as $notes) {
                      $note[$notes->id] = $notes->name;    
                      array_push($notes_array,$note);                  
                  }    
              }
             $courses = enrol_get_my_courses();             
             if(count($notes_array) != ''){  
                 foreach($notes_array as $notes) {
                    if(!(in_array('MoodleNote', $notes))){                        
                     $param = array(
                          "name" => "MoodleNote"   
                         );
                         
                     $note_name = json_encode($param);
                     $created_notes = create_oneNote_notes($SESSION->onenotetoken,$note_name);                     
                     $note_id = $created_notes->id;         
                                 
                     if($courses) {            
                        foreach($courses as $course) {                            
                            $param_section = array(
                                     "name" => $course->fullname
                                        );                        
                            $section = json_encode($param_section);                            
                            $eventresponse = create_oneNote_section($SESSION->onenotetoken, $note_id, $section);
                        }
                     }                            
                 } else {                     
                     $note_id = array_search("MoodleNote", $notes);
                     $getsection = get_oneNote_section($SESSION->onenotetoken, $note_id);
                     
                     $sections = array();
                     if(isset($getsection->value)) {
                        foreach($getsection->value as $section) {      
                              array_push($sections,$section->name);                  
                          }             
                     }
                     if($courses) {            
                        foreach($courses as $course) {
                            if(!in_array($course->fullname, $sections)) {
                                $param_section = array(
                                     "name" => $course->fullname
                                        );                        
                                $section = json_encode($param_section);
                                $eventresponse = create_oneNote_section($SESSION->onenotetoken, $note_id, $section);
                             }
                            }
                         }
                     }
            
                 } 
             } else {                    
                    $param = array(
                          "name" => "MoodleNote"   
                         );
                         
                     $note_name = json_encode($param);
                     $created_notes = create_oneNote_notes($SESSION->onenotetoken,$note_name);
                     $note_id = $created_notes->id;
                  
                     if($courses) {            
                        foreach($courses as $course) {
                            $param_section = array(
                                     "name" => $course->fullname
                                        );                        
                            $section = json_encode($param_section);
                            $eventresponse = create_oneNote_section($SESSION->onenotetoken, $note_id, $section);
                            
            
                        }
                     } 
             }
            
           $content->items[] = "Notebook and section created";
        }

        return $content;
    }
}
