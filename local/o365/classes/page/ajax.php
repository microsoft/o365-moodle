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

namespace local_o365\page;

/**
 * Ajax page.
 */
class ajax extends base {
    /**
     * Hook function run before the main page mode.
     *
     * @return bool True.
     */
    public function header() {
        global $OUTPUT;
        echo $OUTPUT->header();
    }

    /**
     * Run a page mode.
     *
     * @param string $mode The page mode to run.
     */
    public function run($mode) {
        try {
            $this->header();
            $methodname = (!empty($mode)) ? 'mode_'.$mode : 'mode_default';
            if (!method_exists($this, $methodname)) {
                $methodname = 'mode_default';
            }
            $this->$methodname();
        } catch (\Exception $e) {
            echo $this->error_response($e->getMessage());
        }
    }

    /**
     * Build an error ajax response.
     *
     * @param mixed $data Wrapper for response data.
     * @param bool $success General success indicator.
     */
    protected function error_response($errormessage, $errorcode = '') {
        $result = new \stdClass;
        $result->success = false;
        $result->errorcode = $errorcode;
        $result->errormessage = $errormessage;
        return json_encode($result);
    }

    /**
     * Build a generic ajax response.
     *
     * @param mixed $data Wrapper for response data.
     * @param bool $success General success indicator.
     */
    protected function ajax_response($data, $success = true) {
        $result = new \stdClass;
        $result->success = $success;
        $result->data = $data;
        return json_encode($result);
    }

    /**
     * Check if a given URL is a valid SharePoint site.
     */
    public function mode_checksharepointsite() {
        $data = new \stdClass;
        $success = false;

        $uncleanurl = required_param('site', PARAM_TEXT);

        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();

        $data->result = \local_o365\rest\sharepoint::validate_site($uncleanurl, $clientdata, $httpclient);
        $success = true;

        echo $this->ajax_response($data, $success);
    }

    /**
     * Check if a service resource is valid.
     */
    public function mode_checkserviceresource() {
        $data = new \stdClass;
        $success = false;

        $setting = required_param('setting', PARAM_TEXT);
        $value = required_param('value', PARAM_TEXT);

        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();

        if ($setting === 'aadtenant') {
            $resource = \local_o365\rest\azuread::get_resource();
            $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
            if (empty($token)) {
                throw new \moodle_exception('errorchecksystemapiuser', 'local_o365');
            }
            $apiclient = new \local_o365\rest\azuread($token, $httpclient);
            $data->valid = $apiclient->test_tenant($value);
            $success = true;
        } else if ($setting === 'odburl') {
            $data->valid = \local_o365\rest\onedrive::validate_resource($value, $clientdata, $httpclient);
            $success = true;
        }

        echo $this->ajax_response($data, $success);
    }

    /**
     * Detect the correct value for a service resource.
     */
    public function mode_detectserviceresource() {
        $data = new \stdClass;
        $success = false;

        $setting = required_param('setting', PARAM_TEXT);

        $resource = \local_o365\rest\discovery::get_resource();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();
        $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
        if (empty($token)) {
            throw new \moodle_exception('errorchecksystemapiuser', 'local_o365');
        }

        $discovery = new \local_o365\rest\discovery($token, $httpclient);

        if ($setting === 'aadtenant') {
            $entitykey = 'Directory@AZURE';
            $service = $discovery->get_service($entitykey);
            if (!empty($service) && isset($service['serviceEndpointUri'])) {
                $data->settingval = trim(parse_url($service['serviceEndpointUri'], PHP_URL_PATH), '/');
                $success = true;
            }
        } else if ($setting === 'odburl') {
            $entitykey = 'MyFiles@O365_SHAREPOINT';
            $service = $discovery->get_service($entitykey);
            if (!empty($service) && isset($service['serviceResourceId'])) {
                $data->settingval = trim(parse_url($service['serviceResourceId'], PHP_URL_HOST), '/');
                $success = true;
            }
        }

        echo $this->ajax_response($data, $success);
    }

    /**
     * Check setup in Azure.
     */
    public function mode_checksetup() {
        $data = new \stdClass;
        $success = false;

        $resource = \local_o365\rest\azuread::get_resource();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();
        $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
        if (empty($token)) {
            throw new \moodle_exception('errorchecksystemapiuser', 'local_o365');
        }

        // Legacy API.
        $legacyapi = new \stdClass;
        $aadapiclient = new \local_o365\rest\azuread($token, $httpclient);
        list($missingperms, $haswrite) = $aadapiclient->check_permissions();
        $legacyapi->missingperms = $missingperms;
        $legacyapi->haswrite = $haswrite;

        // Unified API.
        $unifiedapi = new \stdClass;
        $unifiedapi->active = false;
        $httpclient = new \local_o365\httpclient();
        $unifiedresource = \local_o365\rest\unified::get_resource();
        $token = \local_o365\oauth2\systemtoken::instance(null, $unifiedresource, $clientdata, $httpclient);
        if (empty($token)) {
            throw new \moodle_exception('errorchecksystemapiuser', 'local_o365');
        }
        $unifiedapiclient = new \local_o365\rest\unified($token, $httpclient);
        $unifiedpermsresult = $unifiedapiclient->check_permissions();
        if ($unifiedpermsresult === null) {
            $unifiedapi->active = false;
        } else {
            $unifiedapi->active = true;
            $unifiedapi->missingperms = $unifiedpermsresult;
        }

        $data->legacyapi = $legacyapi;
        $data->unifiedapi = $unifiedapi;
        set_config('azuresetupresult', serialize($data), 'local_o365');
        set_config('unifiedapiactive', (int)$unifiedapi->active, 'local_o365');

        $success = true;
        echo $this->ajax_response($data, $success);
    }

    /**
     * Attempt to fix application permissions.
     */
    public function mode_fixappperms() {
        $data = new \stdClass;
        $success = false;

        $resource = \local_o365\rest\azuread::get_resource();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();
        $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
        if (empty($token)) {
            throw new \moodle_exception('errorchecksystemapiuser', 'local_o365');
        }

        $apiclient = new \local_o365\rest\azuread($token, $httpclient);
        $success = $apiclient->push_permissions();

        $data->success = $success;

        if ($success === true) {
            set_config('detectperms', 1, 'local_o365');
        }

        echo $this->ajax_response($data, $success);
    }
}
