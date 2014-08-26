<?php
//require_once($CFG->dirroot.'/local/oevents/office_lib.php');
//require_once($CFG->dirroot.'/local/oevents/util.php');

class block_yammer extends block_list {
    public function init() {
        $this->title = get_string('yammer', 'block_yammer');
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
        $content = new stdClass;
        $content->items = array();     
        $code = optional_param('code', '', PARAM_TEXT);
        $client_id = 'Mc8gpyG9wYr7f5qSr8JoQ';
        $client_secret = 'hvzBKUtj3cFkmIxjioqvSpAnNkfTfTT5X7lP8lgIOP0';
        
        if(!($SESSION->yammer_token)) {
            $curl = new curl();        
            $response = $curl->get('https://www.yammer.com/oauth2/access_token.json?client_id='.$client_id.'&client_secret='.$client_secret.'&code='.$code);
            $response = json_decode($response);    
        }
         
        //echo "<pre>";
      //  print_r(json_decode($response));exit;
        if($response->access_token == '') {
            $content->items[] = "<a class='zocial' href='https://www.yammer.com/dialog/oauth?client_id=Mc8gpyG9wYr7f5qSr8JoQ&redirect_uri=http://localhost/moodleapp'>Sign in with Yammer</a>";    
        }   else {
            $response->access_token->token;
            echo $SESSION->yammertoken = $response->access_token->token;
            $content->items[] = "Successfully signed in";
        }
        
       //https://www.yammer.com/dialog/oauth?client_id=[:client_id]&redirect_uri=[:redirect_uri]&response_type=token
         return $content;
  
      }
  
    }

