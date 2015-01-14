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
 * @package block_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
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
        
        $content = new stdClass;
        $content->text = '';
        $content->footer = '';
        $onenoteapi = onenote_api::getinstance();
        
        if ($onenoteapi->is_logged_in()) {
            // Add the "save to onenote" button if we are on an assignment page.
            if ($PAGE->cm && ($PAGE->cm->modname == 'assign') && (optional_param('action', '', PARAM_TEXT) == 'editsubmission') &&
                    !$onenoteapi->is_teacher($COURSE->id, $USER->id)) {
                $content->text .= $onenoteapi->render_action_button(get_string('workonthis', 'block_onenote'), $PAGE->cm->id);
            } else {
                $notebooks = $onenoteapi->get_items_list('');
                
                if ($notebooks) {
                    // Find moodle notebook.
                    $moodlenotebook = null;
                    $notebookname = get_string('notebookname', 'block_onenote');
                    
                    foreach ($notebooks as $notebook) {
                        if ($notebook['title'] == $notebookname) {
                            $moodlenotebook = $notebook;
                            break;
                        }
                    }
                    
                    if ($moodlenotebook) {
                        $url = new moodle_url($moodlenotebook['url']);
                        $content->text .=
                            '<a onclick="window.open(this.href,\'_blank\'); return false;" href="' .
                            $url->out(false) .
                            '" class="local_onenote_linkbutton">' . get_string('opennotebook', 'block_onenote') . '</a>';
                    }
                }
            }
        } else {
            $content->text .= $onenoteapi->render_signin_widget();
            $content->text .= file_get_contents($CFG->dirroot.'/local/msaccount/login.html');
        }

        return $content;
    }
}
