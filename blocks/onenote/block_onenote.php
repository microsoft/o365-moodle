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
        global $USER, $COURSE, $PAGE;
        
        error_log('_get_content called');
        $content = new stdClass;
        $content->items = array();
        $content->icons = '';
        $onenote_api = microsoft_onenote::get_onenote_api();
        $onenote_token = $onenote_api->get_accesstoken();
        
        if (isset($onenote_token)) {
            // add the "save to onenote" button if we are on an assignment page
            if ($PAGE->cm && !microsoft_onenote::is_teacher($COURSE->id, $USER->id)) {
                $content->items[] = microsoft_onenote::render_action_button('Work on the assignment in OneNote', $PAGE->cm->id);
            } else {
                $notebooks = $onenote_api->get_items_list('');
                
                if ($notebooks) {
                    // find moodle notebook
                    $moodle_notebook = null;
                    $notebook_name = get_string('notebookname', 'block_onenote');
                    
                    foreach($notebooks as $notebook) {
                        if ($notebook['title'] == $notebook_name) {
                            $moodle_notebook = $notebook;
                            break;
                        }
                    }
                    
                    if ($moodle_notebook) {
                        $url = new moodle_url($moodle_notebook['url']);
                        $content->items[] =
                            '<a onclick="window.open(this.href,\'_blank\'); setTimeout(function(){ location.reload(); }, 2000); return false;" href="' .
                            $url->out(false) .
                            '" class="onenote_linkbutton">' . 'Open your Moodle notebook' . '</a>';
                    }
                }
            }
        } else {
            $content->items[] = microsoft_onenote::get_onenote_signin_widget();
        }

        return $content;
    }
}

require_once($CFG->dirroot.'/blocks/onenote/onenote.html');