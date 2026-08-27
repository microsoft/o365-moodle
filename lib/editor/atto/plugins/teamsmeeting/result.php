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
 * Atto text editor integration result file.
 *
 * @package    atto_teamsmeeting
 * @copyright  2020 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../../config.php');
require_once(__DIR__ . '/locallib.php');

$meetinglink = optional_param('link', null, PARAM_URL);
$title = optional_param('title', null, PARAM_TEXT);
$preview = optional_param('preview', null, PARAM_RAW);
$optionslink = optional_param('options', null, PARAM_RAW);
$session = optional_param('session', '', PARAM_ALPHANUM);

$context = context_system::instance();

// The app's redirect back here is a subframe navigation from a cross-origin iframe,
// so the browser may not send the Moodle session cookie. Authenticate via the
// short-lived signed token minted when the dialogue was opened instead of
// require_login()'s cookie check; if the token is missing, expired or mismatched,
// fall back to the previous cookie-based login.
$tokenuserid = \atto_teamsmeeting\result_token::validate($session, $context->id);
if ($tokenuserid) {
    $tokenuser = $DB->get_record('user', ['id' => $tokenuserid], '*', MUST_EXIST);
    if (empty($tokenuser->suspended) && empty($tokenuser->deleted) && !empty($tokenuser->confirmed)) {
        \core\session\manager::set_user($tokenuser);
    } else {
        $tokenuserid = null;
    }
}
if (!$tokenuserid) {
    require_login();
}

// This endpoint is entered by a cross-origin redirect, so it cannot rely on a
// sesskey to guard against forged requests. The single-use token is unguessable
// and consumed on use, so treat it as the CSRF guard: only persist a meeting
// record when the request carried a valid token. Cookie-authenticated fallback
// requests still render the confirmation page but write nothing.
$cansave = !empty($tokenuserid);

$meetingoptions = null;

if (!empty($preview)) {
    // The options link is embedded in the editor preview HTML passed back by the app.
    $htmldom = new DOMDocument;
    @$htmldom->loadHTML($preview);
    foreach ($htmldom->getElementsByTagName('a') as $link) {
        $href = $link->getAttribute('href');
        if ($href && strpos($href, 'meetingOptions') !== false
                && atto_teamsmeeting_safe_external_url($href) !== null) {
            $meetingoptions = $href;
            break;
        }
    }
} else if (atto_teamsmeeting_safe_external_url($optionslink) !== null) {
    $meetingoptions = $optionslink;
}

// Persist the meeting so its options link can be looked up later. Only on a
// token-authenticated request (see $cansave above), only when we have both a
// link and a title, and only once per link.
if ($cansave && !empty($meetinglink) && !empty($title)) {
    // The link column is a TEXT field, so a plain equality condition is rejected by the DB
    // layer (textconditionsnotallowed). Compare the full link length via sql_compare_text()
    // instead of the 32-char default, since Teams meeting links share a common URL prefix.
    $comparelength = core_text::strlen($meetinglink);
    $select = $DB->sql_compare_text('link', $comparelength) . ' = ' . $DB->sql_compare_text(':link', $comparelength);

    if (!$DB->record_exists_select('atto_teamsmeeting', $select, ['link' => $meetinglink])) {
        $meetingdata = new stdClass();
        $meetingdata->title = $title;
        $meetingdata->link = $meetinglink;
        $meetingdata->options = $meetingoptions;
        $meetingdata->timecreated = time();
        $DB->insert_record('atto_teamsmeeting', $meetingdata);
    }
}

$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_url(new moodle_url('/lib/editor/atto/plugins/teamsmeeting/result.php', ['link' => $meetinglink, 'title' => $title,
    'preview' => $preview, 'options' => $optionslink]));
echo '<div style="display: flex; flex-direction: column; margin-top: 2rem;padding: 2rem;">
    <svg class="meetingsuccess" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width:100px; align-self: center;
        display: flex; margin-bottom: 1.5rem;">
        <path d="M24 0c2.2 0 4.3.3 6.4.9 2 .6 3.9 1.4 5.7 2.4 1.8 1 3.4 2.3 4.9 3.8 1.5 1.5 2.7 3.1 3.8 4.9 1 1.8 1.8 3.7
        2.4 5.7.6 2 .9 4.2.9 6.4s-.3 4.3-.9 6.3c-.6 2-1.4 3.9-2.4 5.7-1 1.8-2.3 3.4-3.8 4.9-1.5 1.5-3.1 2.7-4.9 3.8-1.8 1-3.7
        1.9-5.7 2.4-2 .6-4.1.9-6.4.9-2.2
        0-4.3-.3-6.3-.9-2-.6-3.9-1.4-5.7-2.4-1.8-1-3.4-2.3-4.9-3.8-1.5-1.5-2.7-3.1-3.8-4.9-1-1.8-1.9-3.7-2.4-5.7C.3 28.3
        0 26.2 0 24s.3-4.3.9-6.4c.6-2 1.4-3.9 2.4-5.7 1-1.8 2.3-3.4 3.8-4.9 1.5-1.5 3.1-2.7 4.9-3.8 1.8-1 3.7-1.9 5.7-2.4S21.8
        0 24 0zm7.9 17.1c-.6 0-1.2.2-1.6.7l-8.5 8.5-3-3c-.4-.4-1-.7-1.6-.7-.3 0-.6.1-.8.2-.3.1-.5.3-.7.5s-.4.4-.5.7c-.2.3-.2.5-.2.8
        0 .6.2 1.2.7 1.6l4.6 4.6c.4.4 1 .7 1.6.7.6 0 1.2-.2 1.6-.7l10.1-10.1c.4-.5.7-1
        .7-1.6 0-.3-.1-.6-.2-.8-.1-.3-.3-.5-.5-.7s-.4-.4-.7-.5c-.4-.2-.7-.2-1-.2z" fill="#599c00"></path></svg>
        <span class="meetingcreatedheader" style="font-size: 20px; font-weight: 600; display: block; text-align: center;">' .
    get_string('meetingcreatedsuccess', 'atto_teamsmeeting', s($title)) .
    '</span>';
if (!empty($meetinglink)) {
    echo '<span class="meetinglink" style="display: block; text-align: center;"><a class="btn btn-primary" href="' .
        s($meetinglink) . '" style="display: inline-block; font-weight: 600; text-align: center; vertical-align: middle;
        border: 1px solid hsla(0,0%,100%,.04); user-select: none; font-size: .875rem; line-height: 1.5; border-radius: 3px;
        color: #fff; background-color: #6264a7; margin-top: 1rem; padding: .375rem .75rem; text-decoration: none;" target="_blank">' .
        get_string('gotomeeting', 'atto_teamsmeeting') . '</a></span>';
}
if (!empty($meetingoptions)) {
    echo '<span class="meetingoptions" style="display: block; text-align: center;"><a class="btn btn-primary" href="' .
        s($meetingoptions) . '" style="display: inline-block; font-weight: 600; text-align: center; vertical-align: middle;
        border: 1px solid hsla(0,0%,100%,.04); user-select: none; font-size: .875rem; line-height: 1.5; border-radius: 3px;
        color: #fff; background-color: #6264a7; margin-top: 1rem; padding: .375rem .75rem; text-decoration: none;" target="_blank">' .
        get_string('meetingoptions', 'atto_teamsmeeting') . '</a></span>';
}
echo '</div>';

exit;
