<?php
require_once($CFG->dirroot.'/blocks/onenote/onenote_lib.php');
//require_once($CFG->dirroot.'/blocks/onenote/onenote.html');


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
        echo "CODE".$code;
        echo "<br>";
        //echo "AACODE".$authprovider;
      
        // OneNote client application settings
        $client_id = '00000000401290EF'; //'Mc8gpyG9wYr7f5qSr8JoQ';
        $client_secret = 'Qpa5MN9UK215hqRcefdtVMaSGwHoX2H5'; //'hvzBKUtj3cFkmIxjioqvSpAnNkfTfTT5X7lP8lgIOP0';
        $redirect_uri = 'http://gopikalocal.com/blocks/onenote/onenote_redirect.php';//http://vinlocaldomain.com:88 // 'http://localhost/moodleapp/blocks/yammer/yammer_redirect.php';
        $scopes = 'wl.signin';
        $response_type = 'token';

        $curl = new curl();
        if($code && $authprovider == 'onenote') {            
            error_log(print_r($code, true));            
            $response = $curl->get('https://login.live.com/oauth20_token.srf?client_id='.$client_id.'&client_secret='.$client_secret.'&code='.$code.'&redirect_uri='.$redirect_uri.'&grant_type=authorization_code');
            
            error_log(print_r($response, true));
           // $response = json_decode($response);
            //$SESSION->onenotetoken = $response->access_token->token;
        }  
        if(!isset($SESSION->onenotetoken) ) {
            $content->items[] = "<a class='zocial' href='https://login.live.com/oauth20_authorize.srf?client_id=$client_id&redirect_uri=$redirect_uri&scope=$scopes&response_type=$response_type'>Sign in with OneNote</a>";
        }
        else {
            // $messages = get_yammer_private_messages($SESSION->yammertoken);
            // $messages = json_decode($messages);
            // $reference_array =$messages->references;

            // $content->items[] = "<table border='0' cellpadding='4' cellspacing='4'><tr><td style='width:70px;font-weight:bold;'>From</td><td style='font-weight:bold;'>Message</td><td style='width:70px;font-weight:bold;'>Date</td></tr>";
            // foreach($messages->messages as $message) {
                // foreach($reference_array as $sender) {
                    // if($message->sender_id == $sender->id) {
                        // $name = $sender->full_name;
                    // }
                // }

                // $created_at = strtotime($message->created_at);
                // $created_at = date("M j G:i:s",$created_at);

                // $content->items[] ="<tr><td style='vertical-align:top;width:70px;'>".$name.
                    // "</td><td style='vertical-align:top;'>".$message->body->plain."</td><td style='vertical-align:top;width:70px;'>".$created_at."</td></tr>";
            // }

            // $content->items[] = "</table>";
        }

        return $content;
    }
}
