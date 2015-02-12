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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

define('AJAX_SCRIPT', true);
require_once(__DIR__.'/../../config.php');
$mode = required_param('mode', PARAM_TEXT);

require_login();
require_capability('moodle/site:config', \context_system::instance());
echo $OUTPUT->header();

$result = new \stdClass;
$result->success = false;

if ($mode === 'checksharepointsite') {
    $uncleanurl = required_param('site', PARAM_TEXT);
    $oidcconfig = get_config('auth_oidc');
    $httpclient = new \local_o365\httpclient();
    $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret,
            $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
    $result->response = \local_o365\rest\sharepoint::validate_site($uncleanurl, $clientdata, $httpclient);
    $result->success = true;
}

echo json_encode($result);
die();