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
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/auth.php');

require_login();

require_capability('auth/oidc:manageconnection', \context_user::instance($USER->id), $USER->id);

$action = optional_param('action', null, PARAM_TEXT);
$oidctoken = $DB->get_record('auth_oidc_token', ['username' => $USER->username]);
$oidcconnected = (!empty($oidctoken)) ? true : false;

if (!empty($action)) {
    if ($action === 'connect' && $oidcconnected === false) {
        $auth = new \auth_plugin_oidc;
        $auth->set_httpclient(new \auth_oidc\httpclient());
        $auth->initiateauthrequest();
    } else if ($action === 'disconnect' && $oidcconnected === true) {
        if (is_enabled_auth('manual') === true) {
            $auth = new \auth_plugin_oidc;
            $auth->set_httpclient(new \auth_oidc\httpclient());
            $auth->disconnect();
        }
    } else {
        throw new \moodle_exception('errorucpinvalidaction', 'auth_oidc');
    }
} else {
    $PAGE->set_url('/auth/oidc/ucp.php');
    $usercontext = \context_user::instance($USER->id);
    $PAGE->set_context(\context_system::instance());
    $PAGE->set_pagelayout('standard');
    $USER->editing = false;
    $authconfig = get_config('auth_oidc');
    $opname = (!empty($authconfig->opname)) ? $authconfig->opname : get_string('pluginname', 'auth_oidc');

    $ucptitle = get_string('ucp_title', 'auth_oidc', $opname);
    $PAGE->navbar->add($ucptitle, $PAGE->url);
    $PAGE->set_title($ucptitle);

    echo $OUTPUT->header();
    echo \html_writer::tag('h2', $ucptitle);
    echo get_string('ucp_general_intro', 'auth_oidc', $opname);
    echo '<br /><br />';

    echo \html_writer::start_div();
    $style = ['style' => 'display: inline-block; margin-right: 0.5rem;'];
    echo \html_writer::tag('h4', get_string('ucp_status', 'auth_oidc', $opname), $style);
    if ($oidcconnected === true) {
        $style = ['class' => 'notifysuccess', 'style' => 'display: inline-block'];
        echo \html_writer::tag('h4', get_string('ucp_status_enabled', 'auth_oidc'), $style);
    } else {
        $style = ['class' => 'notifyproblem', 'style' => 'display: inline-block'];
        echo \html_writer::tag('h4', get_string('ucp_status_disabled', 'auth_oidc'), $style);
    }
    echo \html_writer::end_div();
    echo '<br />';

    if ($oidcconnected === true) {
        if (is_enabled_auth('manual') === true) {
            echo \html_writer::start_div();
            $connectlinkuri = new \moodle_url('/auth/oidc/ucp.php', ['action' => 'disconnect']);
            $strdisconnect = get_string('ucp_connected_disconnect', 'auth_oidc', $opname);
            $linkhtml = \html_writer::link($connectlinkuri, $strdisconnect);
            echo \html_writer::tag('h5', $linkhtml);
            echo \html_writer::span(get_string('ucp_connected_disconnect_details', 'auth_oidc', $opname));
            echo \html_writer::end_div();
        }
    } else {
        echo \html_writer::start_div();
        $connectlinkuri = new \moodle_url('/auth/oidc/ucp.php', ['action' => 'connect']);
        $linkhtml = \html_writer::link($connectlinkuri, get_string('ucp_notconnected_start', 'auth_oidc', $opname));
        echo \html_writer::tag('h5', $linkhtml);
        echo \html_writer::span(get_string('ucp_notconnected_start_details', 'auth_oidc', $opname));
        echo \html_writer::end_div();
    }
    echo $OUTPUT->footer();
}