<?php
require_once($CFG->dirroot.'/blocks/onenote/onenote_lib.php');
require_once($CFG->dirroot.'/blocks/onenote/onenote.html');


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

        $content = new stdClass;
        $content->items = array();
        $content->icons = '';
       /* $code = optional_param('code', '', PARAM_TEXT);
        if (!empty($code)) {
            $authprovider = required_param('authprovider', PARAM_ALPHANUMEXT);
        }*/ 

        //Yammer client application settings
     //   $client_id = '000000004C124AA0'; //'eK7Bh1rNgtYKPwDjyBOLZQ';
      //  $client_secret = 'Qpa5MN9UK215hqRcefdtVMaSGwHoX2H5'; //'WsarbiIcRPGUuvj9ADYA4MbT9oi9ilY6NA2VQJeuw';
       // $redirect_uri = 'http://localhost/moodleapp/blocks/onenote/onenote_redirect.php'; // 'http://localhost:88/blocks/yammer/yammer_redirect.php';
      //  $content->items[] = ' <script src="//js.live.net/v5.0/wl.js" type="text/javascript"></script>'; 
          

        //if(!isset($SESSION->yammertoken) ) {
            $content->items[] = "<div id='signin'></div>";
        //}
                 return $content;
      }
    }
