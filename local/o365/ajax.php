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

$httpclient = new \local_o365\httpclient();
$oidccfg = get_config('auth_oidc');
$clientcredspresent = (!empty($oidccfg->clientid) && !empty($oidccfg->clientsecret)) ? true : false;
$endpointspresent = (!empty($oidccfg->authendpoint) && !empty($oidccfg->tokenendpoint)) ? true : false;
if ($clientcredspresent !== true || $endpointspresent !== true) {
    echo json_encode($result);
    die();
}
$clientdata = new \local_o365\oauth2\clientdata($oidccfg->clientid, $oidccfg->clientsecret, $oidccfg->authendpoint,
        $oidccfg->tokenendpoint);

if ($mode === 'checksharepointsite') {
    $uncleanurl = required_param('site', PARAM_TEXT);
    $result->response = \local_o365\rest\sharepoint::validate_site($uncleanurl, $clientdata, $httpclient);
    $result->success = true;
} else if ($mode === 'checkserviceresource') {
    $setting = required_param('setting', PARAM_TEXT);
    $value = required_param('value', PARAM_TEXT);
    if ($setting === 'aadtenant') {
        $resource = \local_o365\rest\azuread::get_resource();
        $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
        $apiclient = new \local_o365\rest\azuread($token, $httpclient);
        $result->success = $apiclient->test_tenant($value);
    } else if ($setting === 'odburl') {
        $result->success = \local_o365\rest\onedrive::validate_resource($value, $clientdata, $httpclient);
    }
} else if ($mode === 'detectserviceresource') {
    $setting = required_param('setting', PARAM_TEXT);
    $resource = \local_o365\rest\discovery::get_resource();
    $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
    $discovery = new \local_o365\rest\discovery($token, $httpclient);
    if ($setting === 'aadtenant') {
        $entitykey = 'Directory@AZURE';
        $service = $discovery->get_service($entitykey);
        if (!empty($service) && isset($service['serviceEndpointUri'])) {
            $result->settingval = trim(parse_url($service['serviceEndpointUri'], PHP_URL_PATH), '/');
            $result->success = true;
        }
    } else if ($setting === 'odburl') {
        $entitykey = 'MyFiles@O365_SHAREPOINT';
        $service = $discovery->get_service($entitykey);
        if (!empty($service) && isset($service['serviceResourceId'])) {
            $result->settingval = trim(parse_url($service['serviceResourceId'], PHP_URL_HOST), '/');
            $result->success = true;
        }
    }
} else if ($mode === 'fixappperms') {
    $resource = \local_o365\rest\azuread::get_resource();
    $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
    $apiclient = new \local_o365\rest\azuread($token, $httpclient);
    $result->success = $apiclient->push_permissions();
    if ($result->success === true) {
        set_config('detectperms', 1, 'local_o365');
    }
} else if ($mode === 'getappperms') {
    $resource = \local_o365\rest\azuread::get_resource();
    $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
    $aadapiclient = new \local_o365\rest\azuread($token, $httpclient);
    list($missingperms, $haswrite) = $aadapiclient->check_permissions();
    $result->missingperms = $missingperms;
    $result->haswrite = $haswrite;
    $result->hasunified = false;
    $httpclient = new \local_o365\httpclient();
    try {
        $unifiedresource = \local_o365\rest\unified::get_resource();
        $token = \local_o365\oauth2\systemtoken::instance(null, $unifiedresource, $clientdata, $httpclient);
        $unifiedapiclient = new \local_o365\rest\unified($token, $httpclient);
        $result->hasunified = true;
        $result->missingunifiedperms = $unifiedapiclient->check_permissions();
    } catch (\Exception $e) {
        // TODO: Better error reporting.
    }

    if (empty($result->missingperms)) {
        set_config('detectperms', 1, 'local_o365');
    } else {
        set_config('detectperms', 0, 'local_o365');
    }
    $result->success = true;
}

echo json_encode($result);
die();