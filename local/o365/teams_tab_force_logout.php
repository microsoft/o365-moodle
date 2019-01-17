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
 * This page displays a course page in a Microsoft Teams tab.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2018 onwards Microsoft, Inc. (http://microsoft.com/)
 */

require_once(__DIR__ . '/../../config.php');

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\">";
echo "<script src=\"https://statics.teams.microsoft.com/sdk/v1.0/js/MicrosoftTeams.min.js\" crossorigin=\"anonymous\"></script>";
echo "<script src=\"https://secure.aadcdn.microsoftonline-p.com/lib/1.0.15/js/adal.min.js\" crossorigin=\"anonymous\"></script>";
echo "<script src=\"https://code.jquery.com/jquery-3.1.1.js\" crossorigin=\"anonymous\"></script>";

$teamsredirecturl = required_param('redirect', PARAM_TEXT);

$redirecturl = new moodle_url('/local/o365/teams_tab_redirect.php');
$ssostarturl = new moodle_url('/local/o365/sso_start.php');
$ssoendurl = new moodle_url('/local/o365/sso_end.php');
$oidcloginurl = new moodle_url('/auth/oidc/index.php');
$externalloginurl = new moodle_url('/login/index.php');
$forcelogouturl = new moodle_url('/local/o365/teams_tab_force_logout.php');

// Output login pages.
echo html_writer::start_div('local_o365_manual_login');
// Azure AD login box.
echo html_writer::tag('button', get_string('sso_login', 'local_o365'),
    array('onclick' => 'login()', 'class' => 'local_o365_manual_login_button'));
// Manual login link.
echo html_writer::tag('button', get_string('other_login', 'local_o365'),
    array('onclick' => 'otherLogin()', 'class' => 'local_o365_manual_login_button'));
echo html_writer::end_div();

// Log out user.
require_logout();

$SESSION->wantsurl = $teamsredirecturl;

$js = '
microsoftTeams.initialize();

if (!inIframe()) {
    window.location.href = "' . $redirecturl->out() . '";
    sleep(20);
}

function login() {
    microsoftTeams.authentication.authenticate({
        url: "' . $ssostarturl->out() . '",
        width: 600,
        height: 400,
        successCallback: function (result) {
            // AuthenticationContext is a singleton
            let authContext = new AuthenticationContext();
            let idToken = authContext.getCachedToken(config.clientId);
            if (idToken) {
                // login using the token
                window.location.href = "' . $oidcloginurl->out() . '";
                sleep(20);
            } else {
                console.error("Error getting cached id token. This should never happen.");
                // At this point sso login does not work. redirect to normal Moodle login page.
                window.location.href = "' . $externalloginurl->out() . '";
            };
        },
        failureCallback: function (reason) {
            console.log("Login failed: " + reason);
            if (reason === "CancelledByUser" || reason === "FailedToOpenWindow") {
                console.log("Login was blocked by popup blocker or canceled by user.");
            }
            // At this point sso login does not work. redirect to normal Moodle login page.
            window.location.href = "' . $externalloginurl->out() . '";
        }
    });
}

function otherLogin() {
    window.location.href = "' . $externalloginurl->out() . '";
}

function inIframe () {
    try {
        return window.self !== window.top;
    } catch (e) {
        return true;
    }
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function setPageTheme(theme) {
    $("body").addClass(theme);
}
';

echo html_writer::script($js);
