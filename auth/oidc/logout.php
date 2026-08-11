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
 * Single Sign Out end point.
 *
 * @package auth_oidc
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

use core\context\system;
use core\session\manager;

// phpcs:ignore moodle.Files.RequireLogin.Missing
require_once(__DIR__ . '/../../config.php');

$PAGE->set_url('/auth/oidc/logout.php');
$PAGE->set_context(system::instance());

$sid = optional_param('sid', '', PARAM_TEXT);
$iss = optional_param('iss', '', PARAM_TEXT);

if ($sid) {
    // This request is made by the IdP directly (e.g. via a hidden iframe), so it will not carry the
    // MoodleSession cookie of the user(s) being logged out, and there is no way to authenticate it.
    // Do not call auth plugin logout hooks here: this is an unauthenticated endpoint, so anyone could
    // trigger them merely by supplying a known sid.
    $conditions = ['sid' => $sid];
    if ($iss) {
        // When the IdP includes iss, use it as an extra check that the mapping was created for this
        // issuer, so a sid alone (without also knowing the issuer it was created for) cannot be used to
        // force a logout. Not all IdPs include iss on front-channel logout requests (e.g. Azure AD
        // currently does not), so this is applied only when present rather than required.
        $conditions['iss'] = $iss;
    }

    $authoidcsidrecords = $DB->get_records('auth_oidc_sid', $conditions);
    if ($authoidcsidrecords) {
        // The same IdP sid can be mapped to more than one Moodle session (e.g. logins from different
        // browsers/devices during the same IdP session), so destroy every session mapped to this sid.
        $matchedids = [];
        foreach ($authoidcsidrecords as $authoidcsidrecord) {
            if (!empty($authoidcsidrecord->sessionid)) {
                manager::destroy($authoidcsidrecord->sessionid);
            }
            $matchedids[] = $authoidcsidrecord->id;
        }

        $DB->delete_records_list('auth_oidc_sid', 'id', $matchedids);
    }
}

die();
