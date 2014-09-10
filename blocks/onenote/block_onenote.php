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
            $notes = $onenoteapi->get_items_list('');
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
