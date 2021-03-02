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

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/o365/lib.php');

$url = new moodle_url('/local/o365/sso_login.php');

$PAGE->set_context(context_system::instance());

$headers = apache_request_headers();

$authtoken = substr($headers['Authorization'], 7);
list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $authtoken);

$payload = json_decode(local_o365_base64UrlDecode($payloadEncoded));

$loginsuccess = false;
if ($authoidctoken = $DB->get_record('auth_oidc_token', ['oidcusername' => $payload->upn])) {
    if ($user = core_user::get_user($authoidctoken->userid)) {
        $_POST['code'] = $authoidctoken->authcode;
        $user = authenticate_user_login($user->username, null, true);
        if ($user) {
            complete_user_login($user);
            $loginsuccess = true;
        }
    }
}

if ($loginsuccess) {
    http_response_code(200);
} else {
    http_response_code(401);
}
