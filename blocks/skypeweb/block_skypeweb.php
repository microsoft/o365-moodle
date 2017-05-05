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
 * @package block_skypeweb
 * @author Aashay Zajriya <aashay@introp.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Skype Block.
 */
class block_skypeweb extends \block_base {

    /**
     * Initialize plugin.
     */
    public function init() {
        global $PAGE;
        // Adding Skype SDK in the $PAGE.
        $skypesdkurl = new \moodle_url(get_string('skypesdkurl', 'block_skypeweb'));
        $PAGE->requires->js($skypesdkurl, true);
        $this->title = get_string('skypeweb', 'block_skypeweb');
    }

    /**
     * Whether the block has settings.
     *
     * @return bool Has settings or not.
     */
    public function has_config() {
        return true;
    }

    /**
     * Get the content of the block.
     *
     * @return stdObject
     */
    public function get_content() {
        global $PAGE, $CFG, $USER, $SESSION;

        if (empty($USER->id)) {
            return '';
        }

        // To avoid duplication of block code and JavaScript inclusion.
        // Ref: https://moodle.org/mod/forum/discuss.php?d=170193.
        if ($this->content != null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';

        // Adding jquery, jquery-ui, jquery-ui-css in the $PAGE.
        $PAGE->requires->jquery();
        $PAGE->requires->jquery_plugin('ui');
        $PAGE->requires->jquery_plugin('ui-css');

        $renderer = $this->page->get_renderer('block_skypeweb');
        $block = new \block_skypeweb\output\block();

        // Getting the client ID from OpenID authentication plugin.
        $clientid = get_config('auth_oidc', 'clientid');
        $config = [
            'client_id' => $clientid,
            'wwwroot' => $CFG->wwwroot,
            'errormessage' => get_string('signinerror', 'block_skypeweb'),
        ];

        if ($USER->auth == 'oidc' || !empty($SESSION->skype_login)) {
            // Added required Skype SDK's YUI module in the $PAGE.
            $PAGE->requires->yui_module('moodle-block_skypeweb-groups', 'M.block_skypeweb.groups.init', array($config));
            $PAGE->requires->yui_module('moodle-block_skypeweb-signin', 'M.block_skypeweb.signin.init', array($config));
            $PAGE->requires->yui_module('moodle-block_skypeweb-contact', 'M.block_skypeweb.contact.init', array($config));
            $PAGE->requires->yui_module('moodle-block_skypeweb-self', 'M.block_skypeweb.self.init', array($config));
            $this->content->text = $renderer->render_block($block);
        } else {
            // Added required Skype SDK's authentication module in the $PAGE.
            $PAGE->requires->yui_module('moodle-block_skypeweb-login', 'M.block_skypeweb.login.init', array($config));
            $this->content->text = $renderer->render_login($block);
        }

        $this->content->footer = '';
        return $this->content;
    }
}
