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
 * A script that handles the result of the meeting creation.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../../config.php');

/**
 * Render a same-site auto-submitting repost form when a cross-site POST from the Teams app
 * arrives without the session cookie (SameSite=Lax, MDL-83526), then exit; the second,
 * same-site request that follows carries the cookie, so a caller's require_login() then
 * succeeds normally. A no-op when already logged in or when this is that repost itself,
 * so callers can call it unconditionally before their own require_login().
 */
function tiny_teamsmeeting_handle_crosssite_repost(): void {
    global $PAGE;

    if (!empty($_POST['repost'])) {
        unset($_POST['repost']);
        return;
    }

    if (isloggedin()) {
        return;
    }

    $PAGE->set_context(context_system::instance());
    $PAGE->set_pagelayout('popup');
    header_remove('Set-Cookie');
    $output = $PAGE->get_renderer('mod_lti');
    $page = new \mod_lti\output\repost_crosssite_page($_SERVER['REQUEST_URI'], $_POST);
    echo $output->header();
    echo $output->render($page);
    echo $output->footer();
    exit;
}

$courseid = optional_param('courseid', 0, PARAM_INT);
$viewexisting = optional_param('viewexisting', 0, PARAM_INT);
$meetinglink = optional_param('link', null, PARAM_URL);
$title = optional_param('title', null, PARAM_TEXT);
$preview = optional_param('preview', null, PARAM_CLEANHTML);
$optionslink = optional_param('options', null, PARAM_URL);
$session = optional_param('session', '', PARAM_RAW_TRIMMED);

if ($viewexisting) {
    tiny_teamsmeeting_handle_crosssite_repost();
    require_login();
    require_sesskey();
    $viewrecord = $meetinglink
        ? $DB->get_record('tiny_teamsmeeting', ['linkhash' => sha1($meetinglink)])
        : null;
    $context = ($viewrecord && !empty($viewrecord->contextid))
        ? context::instance_by_id($viewrecord->contextid)
        : context_system::instance();
    require_capability('tiny/teamsmeeting:add', $context);
} else {
    if ($courseid) {
        $course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
        $context = context_course::instance($course->id);
    } else {
        $context = context_system::instance();
    }

    // The app's redirect back here is a subframe navigation from a cross-origin iframe,
    // so the browser may not send the Moodle session cookie. Authenticate via the
    // short-lived opaque token minted when the dialog was opened instead of
    // require_login()'s cookie check; older, already-rendered pages whose session value
    // predates this token fall back to the previous cookie-based flow.
    $tokenuserid = \tiny_teamsmeeting\result_token::validate($session, $context->id);
    if ($tokenuserid) {
        $tokenuser = $DB->get_record('user', ['id' => $tokenuserid]);
        if (
            $tokenuser
            && empty($tokenuser->suspended)
            && empty($tokenuser->deleted)
            && !empty($tokenuser->confirmed)
        ) {
            complete_user_login($tokenuser);
        } else {
            $tokenuserid = null;
        }
    }
    if (!$tokenuserid) {
        // Fall back to the cookie-based flow: the repost handshake (MDL-83526) ensures the
        // session cookie is present for require_login() even on a cross-site POST from the
        // Teams app, for pages rendered before the opaque token existed.
        tiny_teamsmeeting_handle_crosssite_repost();
        require_login();
        confirm_sesskey($session);
    }

    require_capability('tiny/teamsmeeting:add', $context, $tokenuserid ?: null);
}

$meetingoptions = null;

if (!empty($preview)) {
    $htmldom = new DOMDocument();
    @$htmldom->loadHTML($preview);
    $links = $htmldom->getElementsByTagName('a');
    foreach ($links as $link) {
        $href = $link->getAttribute('href');
        if ($href && strpos($href, 'meetingOptions') !== false && filter_var($href, FILTER_VALIDATE_URL)) {
            $meetingoptions = $href;
            break;
        }
    }

    $linkhash = sha1($meetinglink);
    if (!$DB->record_exists('tiny_teamsmeeting', ['linkhash' => $linkhash])) {
        $meetingdata = new stdClass();
        $meetingdata->title = $title;
        $meetingdata->link = $meetinglink;
        $meetingdata->linkhash = $linkhash;
        $meetingdata->options = $meetingoptions;
        $meetingdata->timecreated = time();
        $meetingdata->userid = $USER->id;
        $meetingdata->contextid = $context->id;
        $DB->insert_record('tiny_teamsmeeting', $meetingdata);
    }
} else if (
    !empty($optionslink)
    && filter_var($optionslink, FILTER_VALIDATE_URL)
    && parse_url($optionslink, PHP_URL_SCHEME) === 'https'
) {
    $meetingoptions = $optionslink;

    if (!empty($meetinglink) && !empty($title)) {
        $linkhash = sha1($meetinglink);
        $existingrecord = $DB->get_record('tiny_teamsmeeting', ['linkhash' => $linkhash]);
        if (!$existingrecord) {
            $meetingdata = new stdClass();
            $meetingdata->title = $title;
            $meetingdata->link = $meetinglink;
            $meetingdata->linkhash = $linkhash;
            $meetingdata->options = $meetingoptions;
            $meetingdata->timecreated = time();
            $meetingdata->userid = $USER->id;
            $meetingdata->contextid = $context->id;
            $DB->insert_record('tiny_teamsmeeting', $meetingdata);
        } else if ($existingrecord->options !== $meetingoptions) {
            $existingrecord->options = $meetingoptions;
            $DB->update_record('tiny_teamsmeeting', $existingrecord);
        }
    }
}

$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_url(new moodle_url('/lib/editor/tiny/plugins/teamsmeeting/result.php', [
    'courseid'    => $courseid,
    'viewexisting' => $viewexisting,
]));

// Build success SVG icon.
$svgattributes = [
    'class' => 'meetingsuccess',
    'xmlns' => 'http://www.w3.org/2000/svg',
    'viewBox' => '0 0 48 48',
    'style' => 'width:100px; align-self: center; display: flex; margin-bottom: 1.5rem;',
];

$pathattributes = [
    'd' => 'M24 0c2.2 0 4.3.3 6.4.9 2 .6 3.9 1.4 5.7 2.4 1.8 1 3.4 2.3 4.9 3.8 1.5 1.5 2.7 3.1 3.8 4.9 ' .
        '1 1.8 1.8 3.7 2.4 5.7.6 2 .9 4.2.9 6.4s-.3 4.3-.9 6.3c-.6 2-1.4 3.9-2.4 5.7-1 ' .
        '1.8-2.3 3.4-3.8 4.9-1.5 1.5-3.1 2.7-4.9 3.8-1.8 1-3.7 1.9-5.7 2.4-2 .6-4.1.9-6.4.9-2.2 ' .
        '0-4.3-.3-6.3-.9-2-.6-3.9-1.4-5.7-2.4-1.8-1-3.4-2.3-4.9-3.8-1.5-1.5-2.7-3.1-3.8-4.9-1-' .
        '1.8-1.9-3.7-2.4-5.7C.3 28.3 0 26.2 0 24s.3-4.3.9-6.4c.6-2 1.4-3.9 2.4-5.7 1-1.8 2.3-' .
        '3.4 3.8-4.9 1.5-1.5 3.1-2.7 4.9-3.8 1.8-1 3.7-1.9 5.7-2.4S21.8 0 24 0zm7.9 17.1c-.6 ' .
        '0-1.2.2-1.6.7l-8.5 8.5-3-3c-.4-.4-1-.7-1.6-.7-.3 0-.6.1-.8.2-.3.1-.5.3-.7.5s-.4.4-.5.7c-' .
        '.2.3-.2.5-.2.8 0 .6.2 1.2.7 1.6l4.6 4.6c.4.4 1 .7 1.6.7.6 0 1.2-.2 1.6-.7l10.1-10.1c.4-' .
        '.5.7-1 .7-1.6 0-.3-.1-.6-.2-.8-.1-.3-.3-.5-.5-.7s-.4-.4-.7-.5c-.4-.2-.7-.2-1-.2z',
    'fill' => '#599c00',
];

$svg = html_writer::start_tag('svg', $svgattributes);
$svg .= html_writer::empty_tag('path', $pathattributes);
$svg .= html_writer::end_tag('svg');

// Build header message.
$headerattributes = [
    'class' => 'meetingcreatedheader',
    'style' => 'font-size: 20px; font-weight: 600; display: block; text-align: center;',
];
$headermessage = html_writer::tag('span', get_string('iframe_meeting_created', 'tiny_teamsmeeting', $title), $headerattributes);

$content = $svg . $headermessage;

// Build meeting link button if available.
if (!empty($meetinglink)) {
    $buttonattributes = [
        'class' => 'btn btn-primary',
        'href' => $meetinglink,
        'style' => 'display: inline-block; font-weight: 600; text-align: center; vertical-align: middle; ' .
           'border: 1px solid hsla(0,0%,100%,.04); user-select: none; font-size: .875rem; line-height: 1.5; border-radius: 3px; ' .
           'color: #fff; background-color: #6264a7; margin-top: 1rem; padding: .375rem .75rem; text-decoration: none;',
        'target' => '_blank',
    ];
    $button = html_writer::link($meetinglink, get_string('iframe_go_to_meeting', 'tiny_teamsmeeting'), $buttonattributes);
    $spanattributes = [
        'class' => 'meetinglink',
        'style' => 'display: block; text-align: center;',
    ];
    $content .= html_writer::tag('span', $button, $spanattributes);
}

// Build meeting options button if available.
if (!empty($meetingoptions)) {
    $buttonattributes = [
        'class' => 'btn btn-primary',
        'href' => $meetingoptions,
        'style' => 'display: inline-block; font-weight: 600; text-align: center; vertical-align: middle; ' .
           'border: 1px solid hsla(0,0%,100%,.04); user-select: none; font-size: .875rem; line-height: 1.5; border-radius: 3px; ' .
           'color: #fff; background-color: #6264a7; margin-top: 1rem; padding: .375rem .75rem; text-decoration: none;',
        'target' => '_blank',
    ];
    $button = html_writer::link($meetingoptions, get_string('iframe_meeting_options', 'tiny_teamsmeeting'), $buttonattributes);
    $spanattributes = [
        'class' => 'meetingoptions',
        'style' => 'display: block; text-align: center;',
    ];
    $content .= html_writer::tag('span', $button, $spanattributes);
}

// Build container div.
$divattributes = [
    'style' => 'display: flex; flex-direction: column; margin-top: 2rem; padding: 2rem; font-family: sans-serif;',
];
echo html_writer::div($content, '', $divattributes);

$parsed = parse_url($CFG->wwwroot);
$origin = $parsed['scheme'] . '://' . $parsed['host'];
if (!empty($parsed['port'])) {
    $origin .= ':' . $parsed['port'];
}

$payload = json_encode(['action' => 'meetingUrl', 'url' => $meetinglink ?? '']);
$encodedorigin = json_encode($origin);
$scriptcontent = <<<JS
(function() {
    var moodleOrigin = {$encodedorigin};
    if (window.parent === window) {
        return;
    }
    try {
        if (window.parent.location.origin !== moodleOrigin) {
            return;
        }
    } catch (e) {
        // Cross-origin parent: suppress the postMessage call.
        return;
    }
    window.parent.postMessage({$payload}, moodleOrigin);
}());
JS;
echo html_writer::script($scriptcontent);

exit;
