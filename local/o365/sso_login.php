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
 * This page logs in user using SSO.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2018 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:ignore moodle.Files.RequireLogin.Missing -- This file is called from Microsoft Teams tab.
require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/o365/lib.php');

$url = new moodle_url('/local/o365/sso_login.php');

$PAGE->set_context(context_system::instance());

// Get the JWT token from Teams.
$authtoken = local_o365_get_auth_token();

if (empty($authtoken)) {
    http_response_code(401);
    die();
}

// Validate and decode the JWT token with full cryptographic verification.
// This includes signature verification, issuer validation, audience validation,
// algorithm validation, and timing checks (exp, nbf, iat).
try {
    $payload = local_o365_validate_teams_jwt($authtoken);
} catch (Exception $e) {
    // JWT validation failed - deny authentication.
    http_response_code(401);
    die();
}

// Extract username from various possible claims (in order of preference).
$username = null;
if (!empty($payload->upn)) {
    $username = $payload->upn;
} else if (!empty($payload->unique_name)) {
    $username = $payload->unique_name;
} else if (!empty($payload->preferred_username)) {
    $username = $payload->preferred_username;
} else if (!empty($payload->email)) {
    $username = $payload->email;
}

// Validate that we found a username claim.
if (empty($username)) {
    http_response_code(401);
    die();
}

// Store username back in payload for consistency in rest of code.
$payload->upn = $username;

$loginsuccess = false;
$user = null;

// Strategy 1: Try existing valid token record (backward compatibility).
if ($authoidctoken = $DB->get_record('auth_oidc_token', ['oidcusername' => $payload->upn])) {
    // Check if token is still valid and not expired.
    if ($authoidctoken->expiry > time()) {
        if ($user = core_user::get_user($authoidctoken->userid)) {
            // Use the proper authentication without relying on stored authcode.
            if ($user->auth === 'oidc' && !$user->deleted && !$user->suspended) {
                complete_user_login($user);
                $loginsuccess = true;
            }
        }
    }
}

// Strategy 2: Fallback to JWT-based authentication if Strategy 1 failed.
if (!$loginsuccess && !empty($payload->upn)) {
    // First, try to find user by stable oid (Object ID) if present.
    // This is more reliable than UPN which can change due to renames.
    if (!empty($payload->oid)) {
        $sql = "SELECT u.*
                  FROM {user} u
                  JOIN {auth_oidc_token} t ON t.userid = u.id
                 WHERE t.oidcuniqid = :oidcuniqid
                   AND u.deleted = 0
                   AND u.suspended = 0
                   AND u.auth = 'oidc'";

        $user = $DB->get_record_sql($sql, ['oidcuniqid' => $payload->oid]);
    }

    // Fallback: Try to find user by OIDC username (UPN).
    if (!$user) {
        $sql = "SELECT u.*
                  FROM {user} u
                  JOIN {auth_oidc_token} t ON t.userid = u.id
                 WHERE t.oidcusername = :oidcusername
                   AND u.deleted = 0
                   AND u.suspended = 0
                   AND u.auth = 'oidc'";

        $user = $DB->get_record_sql($sql, ['oidcusername' => $payload->upn]);
    }

    // If not found via token table, try direct username match.
    if (!$user) {
        $user = $DB->get_record('user', [
            'username' => $payload->upn,
            'auth' => 'oidc',
            'deleted' => 0,
            'suspended' => 0,
        ]);
    }

    // If we found a user, authenticate them based on the validated JWT.
    if ($user) {
        complete_user_login($user);
        $loginsuccess = true;

        // Update existing token record if available.
        $existingtoken = $DB->get_record('auth_oidc_token', ['userid' => $user->id]);
        if ($existingtoken) {
            // Update existing token record with new information.
            $existingtoken->oidcusername = $payload->upn;
            if (isset($payload->oid)) {
                $existingtoken->oidcuniqid = $payload->oid;
            }
            // Set a reasonable expiry (use JWT exp if available, otherwise 1 hour from now).
            $existingtoken->expiry = isset($payload->exp) ? $payload->exp : (time() + 3600);
            $DB->update_record('auth_oidc_token', $existingtoken);
        }
    }
}

// Strategy 3: If user still not found, they may need to complete initial OIDC setup.
if (!$loginsuccess && !empty($payload->upn)) {
    // Check if this is a user who exists but hasn't connected to O365 yet.
    $potentialuser = $DB->get_record('user', [
        'email' => $payload->upn,
        'deleted' => 0,
        'suspended' => 0,
    ]);

    if ($potentialuser) {
        // User exists with matching email but not set up for OIDC.
        // Redirect them to the OIDC authorization flow.
        $wantsurl = new moodle_url('/');
        $loginurl = new moodle_url('/auth/oidc/', ['wantsurl' => $wantsurl->out()]);
        redirect($loginurl);
    }
}

if ($loginsuccess) {
    http_response_code(200);
} else {
    http_response_code(401);
}
