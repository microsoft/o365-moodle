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

// Display the Skype Web Block's chat window page.

require_once(__DIR__ . '/../../config.php');
// Checks weather Mustache_Engine is already defined or not as
// Moodle 2.9 onwards Mustache_Engine is already included in Moodle core.
if (!class_exists('Mustache_Engine')) {
    require_once('mustache.php');
}
require_login();
// Getting the client ID from OpenID authentication plugin.
$clientid = get_config('auth_oidc', 'clientid');
$config = array('client_id' => $clientid, 'wwwroot' => $CFG->wwwroot);

global $PAGE;

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/blocks/skype_web/skypechat.php');
$PAGE->set_title('skype chat');
// Adding Skype SDK in the $PAGE.
$skypesdkurl = new moodle_url(get_string('skypesdkurl', 'block_skype_web'));
$PAGE->requires->js($skypesdkurl, true);
// Added required Skype SDK's YUI module in the $PAGE.
$PAGE->requires->jquery();
$PAGE->requires->jquery_plugin('ui');
$PAGE->requires->jquery_plugin('ui-css');
// Added required Skype SDK's YUI module in the $PAGE.
$PAGE->requires->yui_module('moodle-block_skype_web-signin', 'M.block_skype_web.signin.init', array($config));
$PAGE->requires->yui_module('moodle-block_skype_web-chatservice', 'M.block_skype_web.chatservice.init', array($config));

echo $OUTPUT->header();
$templateengine = new Mustache_Engine();
$bodycontents = $templateengine->render(file_get_contents($CFG->dirroot . '/blocks/skype_web/html_templates/skype_chat.html'),
        array('get_string' => function($stringtolocalize) {
            return get_string($stringtolocalize, 'block_skype_web');
        }));

echo $bodycontents;
echo $OUTPUT->footer();