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

require_once('/var/www/html/config.php');

// force theme
if (get_config('theme_boost_o365teams', 'version')) {
    $SESSION->theme = 'boost_o365teams';
}

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\">";
echo "<script src=\"https://statics.teams.microsoft.com/sdk/v1.0/js/MicrosoftTeams.min.js\" crossorigin=\"anonymous\"></script>";
echo "<script src=\"https://secure.aadcdn.microsoftonline-p.com/lib/1.0.15/js/adal.min.js\" crossorigin=\"anonymous\"></script>";
echo "<script src=\"https://code.jquery.com/jquery-3.1.1.js\" crossorigin=\"anonymous\"></script>";

$id = required_param('id', PARAM_INT);

$USER->editing = false; // turn off editing if the page is opened in iframe

$redirecturl = new moodle_url('/local/o365/tab_redirect.php');
$coursepageurl = new moodle_url('/course/view.php', array('id' => $id));
$ssostarturl = new moodle_url('/local/o365/sso_start.php');
$ssoendurl = new moodle_url('/local/o365/sso_end.php');
$oidcloginurl = new moodle_url('/auth/oidc/index.php');
$externalloginurl = new moodle_url('/login/index.php');

// output login pages
echo html_writer::start_div('manuallogin');
// Azure AD login box
echo html_writer::tag('button', get_string('sso_login', 'local_o365'),
    array('onclick' => 'login()', 'class' => 'manualloginbutton'));
// Manual login link
echo html_writer::tag('button', get_string('other_login', 'local_o365'),
    array('onclick' => 'otherLogin()', 'class' => 'manualloginbutton'));
echo html_writer::end_div();

$SESSION->wantsurl = $coursepageurl;

if ($USER->id != 0) {
    redirect($coursepageurl);
}

$js = '
microsoftTeams.initialize();

if (!inIframe()) {
    window.location.href = "' . $redirecturl->out() . '";
    sleep(20);
}

// ADAL.js configuration
let config = {
    clientId: "' . get_config('auth_oidc', 'clientid') . '",
    redirectUri: "' . $ssoendurl->out() . '",
    cacheLocation: "localStorage",
    navigateToLoginRequestUrl: false,
};

let upn = undefined;
microsoftTeams.getContext(function (context) {
    theme = context.theme;
    setPageTheme(theme);

    upn = context.upn;
    loadData(upn);
});

// Loads data for the given user
function loadData(upn) {
    // Setup extra query parameters for ADAL
    // - openid and profile scope adds profile information to the id_token
    // - login_hint provides the expected user name
    if (upn) {
        config.extraQueryParameters = "scope=openid+profile&login_hint=" + encodeURIComponent(upn);
    } else {
        config.extraQueryParameters = "scope=openid+profile";
    }

    let authContext = new AuthenticationContext(config);

    // See if there is a cached user and it matches the expected user
    let user = authContext.getCachedUser();
    if (user) {
        if (user.userName !== upn) {
            // User does not match, clear the cache
            authContext.clearCache();
        }
    }

    // Get the id token (which is the access token for resource = clientId)
    let token = authContext.getCachedToken(config.clientId);
    if (!token) {
        // No token, or token is expired
        authContext._renewIdToken(function (err, idToken) {
            if (err) {
                console.log("Renewal failed: " + err);
                
                // Failed to get the token silently; need to show the login button
                $(".manuallogin").css("display", "block");
            } else {
                // login using the token
                window.location.href = "' . $oidcloginurl->out() . '";
            }
        });
    } else {
        // login using the token
        window.location.href = "' . $oidcloginurl->out() . '";
        sleep(20);
    }
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
