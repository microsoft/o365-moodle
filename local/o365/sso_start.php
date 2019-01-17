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
 * This page contains the SSO login page.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2018 onwards Microsoft, Inc. (http://microsoft.com/)
 */

require_once(__DIR__ . '/../../config.php');

require_logout();

$redirect = required_param('redirect', PARAM_TEXT);
$SESSION->wantsurl = $redirect;

echo "<script src=\"https://statics.teams.microsoft.com/sdk/v1.0/js/MicrosoftTeams.min.js\"
    integrity=\"sha384-SNENyRfvDvybst1u0LawETYF6L5yMx5Ya1dIqWoG4UDTZ/5UAMB15h37ktdBbyFh\"
    crossorigin=\"anonymous\"></script>";
echo "<script src=\"https://secure.aadcdn.microsoftonline-p.com/lib/1.0.15/js/adal.min.js\"
    integrity=\"sha384-lIk8T3uMxKqXQVVfFbiw0K/Nq+kt1P3NtGt/pNexiDby2rKU6xnDY8p16gIwKqgI\"
    crossorigin=\"anonymous\"></script>";

$js = '
microsoftTeams.initialize();

// Get the tab context, and use the information to navigate to Azure AD login page
microsoftTeams.getContext(function (context) {
    // ADAL.js configuration
    let config = {
        clientId: "' . get_config('auth_oidc', 'clientid') . '",
        redirectUri: "' . $CFG->wwwroot . '/local/o365/sso_end.php",
        cacheLocation: "localStorage",
        navigateToLoginRequestUrl: false,
    };

    // Setup extra query parameters for ADAL
    // - openid and profile scope adds profile information to the id_token
    // - login_hint provides the expected user name
    if (context.upn) {
        config.extraQueryParameters = "scope=openid+profile&login_hint=" + encodeURIComponent(context.upn);
    } else {
        config.extraQueryParameters = "scope=openid+profile";
    }

    // Use a custom displayCall function to add extra query parameters to the url before navigating to it
    config.displayCall = function (urlNavigate) {
        if (urlNavigate) {
            if (config.extraQueryParameters) {
                urlNavigate += "&" + config.extraQueryParameters;
            }
            window.location.replace(urlNavigate);
        }
    }

    // Navigate to the AzureAD login page
    let authContext = new AuthenticationContext(config);
    authContext.login();
});
';

echo html_writer::script($js);
