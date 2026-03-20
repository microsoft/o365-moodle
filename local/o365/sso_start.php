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

// phpcs:ignore moodle.Files.RequireLogin.Missing -- This file is called from Microsoft Teams tab.
require_once(__DIR__ . '/../../config.php');

echo "<script src=\"" . $CFG->wwwroot . "/local/o365/js/MicrosoftTeams.min.js\"></script>";
echo "<script src=\"" . $CFG->wwwroot . "/local/o365/js/msal-browser.min.js\"></script>";

$js = '
// Initialize Teams SDK - must wait for it to complete before using other Teams APIs
microsoftTeams.app.initialize().then(function() {
    // Get the tab context, and use the information to navigate to Microsoft login page
    return microsoftTeams.app.getContext();
}).then(function (context) {
    // MSAL configuration
    const msalConfig = {
        auth: {
            clientId: "' . get_config('auth_oidc', 'clientid') . '",
            authority: "https://login.microsoftonline.com/" + context.user.tenant.id,
            redirectUri: "' . $CFG->wwwroot . '/local/o365/sso_end.php",
            navigateToLoginRequestUrl: false
        },
        cache: {
            cacheLocation: "localStorage",
            storeAuthStateInCookie: false
        }
    };

    const loginRequest = {
        scopes: ["openid", "profile"],
        loginHint: context.user.loginHint
    };

    // Navigate to the Entra ID login page
    const msalInstance = new msal.PublicClientApplication(msalConfig);
    return msalInstance.initialize().then(() => {
        return msalInstance.loginRedirect(loginRequest);
    });
}).catch((error) => {
    console.error("Teams SDK or MSAL initialization/login failed: " + error);
    microsoftTeams.authentication.notifyFailure(error.message || "Authentication initialization failed");
});
';

echo html_writer::script($js);
