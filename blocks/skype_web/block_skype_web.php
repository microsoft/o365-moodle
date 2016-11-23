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
 * @author Aashay Zajriya <aashay@introp.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */
defined('MOODLE_INTERNAL') || die();
// Checks weather Mustache_Engine is already defined or not as
// Moodle 2.9 onwards Mustache_Engine is already included in Moodle core.
if (!class_exists('Mustache_Engine')) {
    require_once('mustache.php');
}

/**
 * Skype Block.
 */
class block_skype_web extends block_base {

    /**
     * Initialize plugin.
     */
    public function init() {

        global $PAGE;
        // Adding Skype SDK in the $PAGE.
        $skypesdkurl = new moodle_url(get_string('skypesdkurl', 'block_skype_web'));
        $PAGE->requires->js($skypesdkurl, true);
        $this->title = get_string('skype_web', 'block_skype_web');
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

        // Adding jquery, jquery-ui, jquery-ui-css in the $PAGE.
        $PAGE->requires->jquery();
        $PAGE->requires->jquery_plugin('ui');
        $PAGE->requires->jquery_plugin('ui-css');

        // Getting the client ID from OpenID authentication plugin.
        $clientid = get_config('auth_oidc', 'clientid');
        $config = array('client_id' => $clientid,
                        'wwwroot' => $CFG->wwwroot,
                        'errormessage' => get_string('signinerror', 'block_skype_web'));

        $this->content = new stdClass;
        $this->content->text = '';
        if ($USER->auth == 'oidc' || !empty($SESSION->skype_login)) {
            // Added required Skype SDK's YUI module in the $PAGE.
            $PAGE->requires->yui_module('moodle-block_skype_web-groups', 'M.block_skype_web.groups.init', array($config));
            $PAGE->requires->yui_module('moodle-block_skype_web-signin', 'M.block_skype_web.signin.init', array($config));
            $PAGE->requires->yui_module('moodle-block_skype_web-contact', 'M.block_skype_web.contact.init', array($config));
            $PAGE->requires->yui_module('moodle-block_skype_web-self', 'M.block_skype_web.self.init', array($config));
            $this->content->text .= $this->get_template($CFG->dirroot . '/blocks/skype_web/html_templates/skype_block.html');
        } else {
            // Added required Skype SDK's authentication module in the $PAGE.
            $PAGE->requires->yui_module('moodle-block_skype_web-login', 'M.block_skype_web.login.init', array($config));
            $this->content->text .= $this->get_template($CFG->dirroot . '/blocks/skype_web/html_templates/skype_login.html');
        }

        $this->content->text = str_replace("@@wwwroot@@", $CFG->wwwroot, $this->content->text);
        $this->content->footer = '';
        return $this->content;
    }

    /**
     * Get block content's tamplate according to the user's login status.
     *
     * @param string $templatepath The HTML template path that we are using.
     * @return string Block content.
     */
    private function get_template($templatepath) {
        $templateengine = new Mustache_Engine();
        $output = $templateengine->render(file_get_contents($templatepath), array('get_string' => function($stringtolocalize) {
                return get_string($stringtolocalize, 'block_skype_web');
        }));
        return $output;
    }
}
