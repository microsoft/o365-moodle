<?php
require_once($CFG->dirroot.'/lib/oauthlib.php');
require_once($CFG->dirroot.'/repository/onenote/onenote_api.php');

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
        error_log('_get_content called');
        $content = new stdClass;
        $content->items = array();
        $content->icons = '';

        $onenote_api = get_onenote_api();
        $onenote_token = $onenote_api->get_accesstoken();
        
        if (isset($onenote_token)) {
            $notes = $onenote_api->get_items_list('');
            if ($notes) {
                $content->items[] = '<b>Your Notebooks:</b>';
                foreach ($notes as $note) {
                    $content->items[] = '<a href="' . $note['url'] . '" target="_blank">' . $note['title'] . '</a>';
                }
            } else {
                $content->items[] = "No notebooks";
            }

            // add the "save to onenote" button if this is a file upload type of assignment
            $cm_instance_id = optional_param('id', null, PARAM_INT);
            if ($cm_instance_id) {
                $action_params['action'] = 'save';
                $action_params['id'] = $cm_instance_id;
                $url = new moodle_url('/blocks/onenote/onenote_actions.php', $action_params);

                $content->items[] = '<br/>';
                $content->items[] =
                    '<a onclick="window.open(this.href,\'_blank\'); setTimeout(function(){ location.reload(); }, 2000); return false;" href="' . $url->out(false) . '" style="' . get_linkbutton_style() . '">' . 'Save assignment to OneNote' . '</a>';

                // TODO: Add username of logged in person and signout button
//                 $action_params['action'] = 'signout';
//                 $url = new moodle_url('/blocks/onenote/onenote_actions.php', $action_params);

//                 $content->items[] = 
//                     '<input type="button" value="Sign out" onclick="window.location.href=\'' . $url->out(false) . '\';"/>';
            }
        } else {
            $content->items[] = get_onenote_signin_widget();
        }

        return $content;
    }
}

require_once($CFG->dirroot.'/blocks/onenote/onenote.html');
