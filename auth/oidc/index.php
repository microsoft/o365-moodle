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
 * Authentication landing page.
 *
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:ignore moodle.Files.RequireLogin.Missing
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/auth.php');

$auth = new \auth_plugin_oidc('authcode');
$auth->set_httpclient(new \auth_oidc\httpclient());

try {
    $auth->handleredirect();
} catch (moodle_exception $e) {
    // If debugging is off, re-throw to let Moodle handle it with generic message.
    if (empty($CFG->debug) || $CFG->debug < DEBUG_MINIMAL) {
        throw $e;
    }

    // Only display detailed debug information if debug display is enabled.
    // This prevents leaking sensitive internal details to unauthenticated users.
    $showdetails = !empty($CFG->debugdisplay);

    if ($showdetails) {
        // Display error details when debug display is enabled.
        $errormessage = $e->getMessage();
        if (!empty($e->debuginfo)) {
            $errormessage .= ' (' . $e->debuginfo . ')';
        }
    } else {
        // Show generic error message to prevent information disclosure.
        $errormessage = get_string('errorauthgeneral', 'auth_oidc');
    }

    $PAGE->set_url('/auth/oidc/');
    $PAGE->set_context(context_system::instance());
    $PAGE->set_pagelayout('login');
    $PAGE->set_title(get_string('error'));

    echo $OUTPUT->header();
    echo $OUTPUT->notification($errormessage, 'error');
    echo $OUTPUT->single_button(new moodle_url('/login/index.php'), get_string('login'), 'get');
    echo $OUTPUT->footer();
    exit;
}
