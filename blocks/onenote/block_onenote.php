<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Microsoft OneNote block Plugin
 *
 * @package    block_onenote
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/local/onenote/onenote_api.php');

class block_onenote extends block_base {
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
        global $USER, $COURSE, $PAGE, $CFG;
        
        error_log('_get_content called');
        $content = new stdClass;
        $content->text = '';
        $content->footer = '';
        $onenote_api = onenote_api::getInstance();
        
        if ($onenote_api->is_logged_in()) {
            // add the "save to onenote" button if we are on an assignment page
            if ($PAGE->cm && (optional_param('action', '', PARAM_TEXT) == 'editsubmission') && 
                    !$onenote_api->is_teacher($COURSE->id, $USER->id)) {
                $content->text .= $onenote_api->render_action_button(get_string('workonthis', 'block_onenote'), $PAGE->cm->id);
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
                        $content->text .=
                            '<a onclick="window.open(this.href,\'_blank\'); return false;" href="' .
                            $url->out(false) .
                            '" class="onenote_linkbutton">' . get_string('opennotebook', 'block_onenote') . '</a>';
                    }
                }
            }
        } else {
            $content->text .= $onenote_api->render_signin_widget();
            $content->text .= file_get_contents($CFG->dirroot.'/local/onenote/onenote.html');
        }

        return $content;
    }
}
