<?php
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

        // TODO: For now, we are simply going to use the microsoft_onenote class that exists inside the onenote repository plugin. Eventually we will have to refactor this properly.
        $params['client_id'] = get_config('onenote', 'clientid');
        $params['client_secret'] = get_config('onenote', 'secret');
        $returnurl = new moodle_url('/repository/repository_callback.php');
        $returnurl->param('callback', 'yes');
        $returnurl->param('repo_id', $this->get_onenote_repo_id());
        $returnurl->param('sesskey', sesskey());
        $params['state'] = $returnurl->out_as_local_url(FALSE);
        $params['scope'] = 'office.onenote_update';
        $params['response_type'] = 'code';
        $onenoteapi = new microsoft_onenote($params['client_id'], $params['client_secret'], $returnurl);
        $params['redirect_uri'] = $onenoteapi->callback_url();
        $onenote_token = $onenoteapi->get_accesstoken();

        if(isset($onenote_token->token)) {
            $notes = $onenoteapi->get_items_list('');
            if($notes) {
                $content->items[] = '<b>Your Notebooks:</b>';
                foreach ($notes as $note) {                    
                    $content->items[] = '<a href="' . $note['url'] . '" target="_blank">' . $note['title'] . '</a>';
                }
            } else {
                $content->items[] = "No notes";
            }

            // add the "save to onenote" button if this is a file upload type of assignment
             $cm_instance_id = optional_param('id', null, PARAM_INT);
            if($cm_instance_id) {
                $content->items[] = '<br/><br/>';

                $action_params['action'] = 'save';
                $action_params['id'] = $cm_instance_id;
                $action_params['token'] = $onenote_token->token;
                $url = new moodle_url('/blocks/onenote/onenote_actions.php', $action_params);

                $content->items[] =
                    '<form action="' . $url->out(false) . '" method="post" id="mform1" class="mform">' .
                    '<input name="submitbutton" value="Save Assignment to OneNote" type="submit" id="id_savebutton">' .
                    '</form>';
            }
        } else {
            $url = new moodle_url('https://login.live.com/oauth20_authorize.srf',$params);
            $content->items[] =  '<a onclick="window.open(this.href,\'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=0\'); return false;"
            href="'.$url->out(false).'">'.get_string('login', 'repository').'</a>';
        }

        error_log('_get_content exited');
        return $content;
    }

    // get the repo id for the onenote repo
    private function get_onenote_repo_id() {
        global $DB;
        $repository = $DB->get_record('repository', array('type'=>'onenote'));
        return $repository->id;
    }
}
