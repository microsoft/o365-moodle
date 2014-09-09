<?php
require_once($CFG->dirroot.'/blocks/onenote/onenote_lib.php');
require_once($CFG->dirroot.'/blocks/onenote/onenote.html');
require_once($CFG->dirroot.'/repository/onenote/onenote_api.php');
require_once($CFG->dirroot.'/lib/oauthlib.php');

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
        
        $params['client_id'] = get_config('onenote', 'clientid'); //'Mc8gpyG9wYr7f5qSr8JoQ';
        $params['client_secret'] = get_config('onenote', 'secret'); //'hvzBKUtj3cFkmIxjioqvSpAnNkfTfTT5X7lP8lgIOP0';        
        $returnurl = new moodle_url('/repository/repository_callback.php');
        $returnurl->param('callback', 'yes');
        $returnurl->param('repo_id', 9);
        $returnurl->param('sesskey', sesskey());         
        $params['state'] = $returnurl->out_as_local_url(FALSE);
        $params['scope'] = 'office.onenote_update';
        $params['response_type'] = 'code';
        $onenoteapi = new microsoft_onenote($params['client_id'], $params['client_secret'], $returnurl);
        $params['redirect_uri'] = $onenoteapi->callback_url();
        $access_token = $onenoteapi->get_accesstoken();        
        
        if(isset($access_token->token)) {            
            $notes = $onenoteapi->get_items_list('',$access_token->token);
            $notes_array = array();
            if($notes) {
              foreach ($notes as $note) {
                $not[$note['id']] = $note['title'];                
                array_push($notes_array,$not);                
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
                     $created_notes = create_oneNote_notes($access_token->token,$note_name);                     
                     if(isset($created_notes)) {
                        $note_id = $created_notes->id;    
                     }
                                                               
                     if($courses) {            
                        foreach($courses as $course) {                            
                            $param_section = array(
                                     "name" => $course->fullname
                                        );                        
                            $section = json_encode($param_section);                            
                            $eventresponse = create_oneNote_section($access_token->token, $note_id, $section);
                        }
                     }                            
                 } else {                     
                     $note_id = array_search("MoodleNote", $notes);
                     $getsection = get_oneNote_section($access_token->token, $note_id);
                     
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
                                $eventresponse = create_oneNote_section($access_token->token, $note_id, $section);
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
                     $created_notes = create_oneNote_notes($access_token->token,$note_name);
                     $note_id = $created_notes->id;
                  
                     if($courses) {            
                        foreach($courses as $course) {
                            $param_section = array(
                                     "name" => $course->fullname
                                        );                        
                            $section = json_encode($param_section);
                            $eventresponse = create_oneNote_section($access_token->token, $note_id, $section);
                            
            
                        }
                     } 
             }  
            $notes = $onenoteapi->get_items_list('',$access_token->token);
            if($notes) {
              foreach ($notes as $note) {
                $content->items[] = $note['title'];
               }    
            }             
            
            
        } else {
            $url = new moodle_url('https://login.live.com/oauth20_authorize.srf',$params);         
            $content->items[] =  '<a onclick="window.open(this.href,\'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=0\'); return false;" 
            href="'.$url->out(false).'">'.get_string('login', 'repository').'</a>';//target="_blank"
            
        }
        return $content;
      }
}
