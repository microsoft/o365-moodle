<?php
require_once($CFG->dirroot.'/blocks/yammer/yammer_lib.php');


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
        $content->icons = '';
        $code = optional_param('code', '', PARAM_TEXT);
        if (!empty($code)) {
            $authprovider = required_param('authprovider', PARAM_ALPHANUMEXT);
        }

        //Yammer client application settings
        $client_id = 'eK7Bh1rNgtYKPwDjyBOLZQ'; //'Mc8gpyG9wYr7f5qSr8JoQ';
        $client_secret = 'WsarbiIcRPGUuvj9ADYA4MbT9oi9ilY6NA2VQJeuw'; //'hvzBKUtj3cFkmIxjioqvSpAnNkfTfTT5X7lP8lgIOP0';
        $redirect_uri = 'http://localhost:88/blocks/yammer/yammer_redirect.php'; // 'http://localhost/moodleapp/blocks/yammer/yammer_redirect.php';

        $curl = new curl();
        if($code && $authprovider == 'yammer') {

            $response = $curl->get('https://www.yammer.com/oauth2/access_token.json?client_id='.$client_id.'&client_secret='.$client_secret.'&code='.$code);
            $response = json_decode($response);
            $SESSION->yammertoken = $response->access_token->token;
        }

        if(!isset($SESSION->yammertoken) ) {
            $content->items[] = "<a class='zocial' href='https://www.yammer.com/dialog/oauth?client_id=$client_id&redirect_uri=$redirect_uri'>Sign in with Yammer</a>";
        }
        else {
            $messages = get_yammer_private_messages($SESSION->yammertoken);
            $messages = json_decode($messages);
            $reference_array =$messages->references;

            $content->items[] = "<table border='0' cellpadding='4' cellspacing='4'><tr><td style='width:70px;font-weight:bold;'>From</td><td style='font-weight:bold;'>Message</td><td style='width:70px;font-weight:bold;'>Date</td></tr>";
            foreach($messages->messages as $message) {
                foreach($reference_array as $sender) {
                    if($message->sender_id == $sender->id) {
                        $name = $sender->full_name;
                    }
                }

                $created_at = strtotime($message->created_at);            
                $created_at = date("M j G:i:s",$created_at);

                $content->items[] ="<tr><td style='vertical-align:top;width:70px;'>".$name.
                    "</td><td style='vertical-align:top;'>".$message->body->plain."</td><td style='vertical-align:top;width:70px;'>".$created_at."</td></tr>";
            }

            $content->items[] = "</table>";
        }
         return $content;
      }
    }
