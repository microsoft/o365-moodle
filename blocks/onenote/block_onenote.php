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
        $scopes = 'wl.signin';
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
            
            $param = array(
                      "name" => "testnote"   
                     );
            $encoded_param = json_encode($param);
            $curl = new curl();
            $header = array(
                        'Authorization: Bearer ' . $SESSION->onenotetoken,
                        'Content-Type: application/json'
            );
            $curl->setHeader($header);
            $eventresponse = $curl->post('https://www.onenote.com/api/v1.0/notebooks',$encoded_param); // TODO: Restrict time range to be the same as moodle events
        
            print_r($eventresponse);
            //Create a link and call the ajax on submit. Uncomemtn the onenote.html to get the ajax call.                     
            //$content->items[] = "<span>Create notebook</span>";
            /*$content->items[] = "<div id='create'>                                 
                                    <input id='token' type='hidden' name='token' value=".$SESSION->onenotetoken.">
                                    <input id='newnote' type='text' name='newnote' />
                                    <input type='submit' id='save' name='submit' value='Save'>                                
                                </div>";*/
           error_log(print_r($eventresponse, true));
           $content->items[] = "Create notbook";
        }

        return $content;
    }
}
//require_once($CFG->dirroot.'/blocks/onenote/onenote.html');