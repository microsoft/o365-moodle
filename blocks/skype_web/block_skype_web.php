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
 * @package block_skype_web
 * @author Sushant Gawali <sushant@introp.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Skype Block.
 */
class block_skype_web extends block_base
{
    /**
     * Initialize plugin.
     */
    public function init()
    {
        global $PAGE;
        $this->title = get_string('skype_web', 'block_skype_web');
        $client_id = get_config('auth_oidc', 'clientid');
        $PAGE->requires->yui_module('moodle-block_skype_web-skype', 'M.block_skype_web.init_skype', array(array('client_id' => $client_id)));

    }

    /**
     * Whether the block has settings.
     *
     * @return bool Has settings or not.
     */
    public function has_config() {
        return false;
    }

    /**
     * Get the content of the block.
     *
     * @return stdObject
     */
    public function get_content() {

        global $PAGE;

        $skypesdkurl = new moodle_url('https://swx.cdn.skype.com/shared/v/1.2.9/SkypeBootstrap.js');
        $PAGE->requires->js($skypesdkurl, true);

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->text = '<div class="conference">';
        $this->content->text .= '<h2>Conferance</h2><h3 style="margin-left: 20px">Skype Status : <span id="skype_status"></span></h3>';
        $this->content->text .= '<div class="conversation" style="padding: 10px 0px 10px 10px;display: none" id="new_meeting"><div id="startNewVideoMeeting" class="button">Start a new video meeting</div><br>';
        $this->content->text .= '<h3 id="starting" style="display: none">Starting new meeting...</h3><br><div id="meeting" style="display: none"><input id="newMeetingUri" class="input" placeholder="Meeting URI" />';
        $this->content->text .= '<div class="add-p-container">';
        $this->content->text .= '<br>Add Participants: <br><input type="text" id="txt-contact" placeholder="sip:someone@example.com" />';
        $this->content->text .= '<button id="btn-add-participant">Add</button><br>';
        $this->content->text .= '<h4>Participants :</h4><ul id="participants"></ul></div></div></div>';
        $this->content->text .= '<div class="conversation" style="display: none" id="self_video"><div class="header"><h3>Self Camera</h3></div>';
        $this->content->text .= '<div id="av-self" class="av-container"><div id="previewWindow" class="render-window"></div></div></div></div>';

        $this->content->footer = '';

        return $this->content;
    }
}