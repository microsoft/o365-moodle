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
 * @copyright  Microsoft, Inc.
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Onenote Block.
 */
class block_onenote extends block_base {
    /**
     * Initialize plugin.
     */
    public function init() {
        $this->title = get_string('onenote', 'block_onenote');
    }

    /**
     * Get the content of the block.
     *
     * @return stdObject
     */
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

    /**
     * Get the content of the block.
     *
     * @return stdObject
     */
    public function _get_content() {
        global $USER, $COURSE, $PAGE, $CFG;

        $action = optional_param('action', '', PARAM_TEXT);

        $content = new \stdClass;
        $content->text = '';
        $content->footer = '';

        try {
            $onenoteapi = \local_onenote\api\base::getinstance();
            if ($onenoteapi->is_logged_in()) {
                // Add the "save to onenote" button if we are on an assignment page.
                $onassignpage = ($PAGE->cm && $PAGE->cm->modname == 'assign' && $action == 'editsubmission') ? true : false;
                if ($onassignpage === true && $onenoteapi->is_student($PAGE->cm->id, $USER->id)) {
                    $content->text .= $onenoteapi->render_action_button(get_string('workonthis', 'block_onenote'), $PAGE->cm->id);
                } else {
                    // Find moodle notebook, create if not found.
                    $moodlenotebook = null;
                    for ($i = 0; $i < 2; $i++) {
                        $notebooks = $onenoteapi->get_items_list('');
                        if (!empty($notebooks)) {
                            $notebookname = get_string('notebookname', 'block_onenote');
                            foreach ($notebooks as $notebook) {
                                if ($notebook['title'] == $notebookname) {
                                    $moodlenotebook = $notebook;
                                    break;
                                }
                            }
                        }
                        if (empty($moodlenotebook)) {
                            $onenoteapi->sync_notebook_data();
                        } else {
                            break;
                        }
                    }

                    if (!empty($moodlenotebook)) {
                        $url = new \moodle_url($moodlenotebook['url']);
                        $stropennotebook = get_string('opennotebook', 'block_onenote');
                        $linkattrs = [
                            'onclick' => 'window.open(this.href,\'_blank\'); return false;',
                            'class' => 'local_onenote_linkbutton',
                        ];
                        $content->text = \html_writer::link($url->out(false), $stropennotebook, $linkattrs);
                    } else {
                        $content->text = get_string('error_nomoodlenotebook', 'block_onenote');
                    }
                }
                if (empty($content->text)) {
                    $content->text = get_string('connction_error', 'local_onenote');
                }
            } else {
                if (\local_o365\utils::is_configured_msaccount()) {
                    $content->text .= $onenoteapi->render_signin_widget();
                    $content->text .= file_get_contents($CFG->dirroot.'/local/msaccount/login.html');
                }
            }
        } catch (\Exception $e) {
            $content->text = $e->getMessage();
        }

        return $content;
    }
}
