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

// Display the Skype Web Block's chat window page.

require_once(__DIR__ . '/../../config.php');

require_login();
// Getting the client ID from OpenID authentication plugin.
$clientid = get_config('auth_oidc', 'clientid');
$config = array('client_id' => $clientid, 'wwwroot' => $CFG->wwwroot);

global $PAGE;

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/blocks/skypeweb/skypechat.php');
$PAGE->set_title('skype chat');
// Adding Skype SDK in the $PAGE.
$skypesdkurl = new moodle_url(get_string('skypesdkurl', 'block_skypeweb'));
$PAGE->requires->js($skypesdkurl, true);
// Added required Skype SDK's YUI module in the $PAGE.
$PAGE->requires->jquery();
$PAGE->requires->jquery_plugin('ui');
$PAGE->requires->jquery_plugin('ui-css');
// Added required Skype SDK's YUI module in the $PAGE.
$PAGE->requires->yui_module('moodle-block_skypeweb-signin', 'M.block_skypeweb.signin.init', array($config));
$PAGE->requires->yui_module('moodle-block_skypeweb-chatservice', 'M.block_skypeweb.chatservice.init', array($config));

echo $OUTPUT->header();

echo \html_writer::start_div('block_skypeweb');
echo \html_writer::start_div('wrappingdiv block_skypeweb');
echo \html_writer::start_div();
echo \html_writer::start_div('chat-service');
echo \html_writer::div(get_string('chat_message', 'block_skypeweb'), 'noMe');
echo \html_writer::tag('h2', get_string('lbl_chat', 'block_skypeweb'));

echo \html_writer::start_div('conversation');

// Conversation header.
echo \html_writer::start_div('header', ['id' => 'start']);
$chatto = \html_writer::div('', 'editable', [
    'id' => 'chat-to',
    'contenteditable' => 'true',
    'placeholder' => get_string('email_placeholder', 'block_skypeweb'),
]);
$startmsgbutton = \html_writer::tag('a', '', [
    'id' => 'btn-start-messaging',
    'class' => 'iconfont chat',
    'title' => get_string('start_tooltip', 'block_skypeweb')
]);
echo \html_writer::div($chatto.$startmsgbutton);
echo \html_writer::end_div();

// Status header.
$stopmsgbutton = \html_writer::tag('a', '', [
    'id' => 'btn-stop-messaging',
    'class' => 'icon icon-small icon-close',
    'title' => get_string('stop_tooltip', 'block_skypeweb')
]);
$rightcontrols = \html_writer::div($stopmsgbutton, 'right-controls');
$statusheader = $rightcontrols;
$statusheader .= \html_writer::tag('h3', get_string('lbl_userfound', 'block_skypeweb'));
$statusheader .= \html_writer::div('', 'chat-name');
$statusheader .= \html_writer::div('', 'notification');
echo \html_writer::div($statusheader, 'header', ['id' => 'status-header', 'style' => 'display:none']);

// Message history.
echo \html_writer::div('', 'messages', ['id' => 'message-history']);

// Chat input.
echo \html_writer::div('', 'chatinput editable', [
    'id' => 'input-message',
    'contenteditable' => 'true',
    'placeholder' => get_string('type_placeholder', 'block_skypeweb'),
    'style' => 'display: none',
]);

// End conversation.
echo \html_writer::end_div();

echo \html_writer::end_div();
echo \html_writer::end_div();
echo \html_writer::end_div();
echo \html_writer::div('', '', ['id' => 'cc-conversations']);
echo \html_writer::end_div();
?>
<script type='text/javascript'>
    // Hide header and footer.
    $(function() {
        $("header,#page-footer").hide();
    });
</script>
<?php
echo $OUTPUT->footer();
