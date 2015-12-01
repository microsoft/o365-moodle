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
            $token->refresh();
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
        $token->refresh();

        $discovery = new \local_o365\rest\discovery($token, $httpclient);

        if ($setting === 'aadtenant') {
            $entitykey = 'Directory@AZURE';
            try {
                $service = $discovery->get_service($entitykey);
                if (!empty($service) && isset($service['serviceEndpointUri'])) {
                    $data->settingval = trim(parse_url($service['serviceEndpointUri'], PHP_URL_PATH), '/');
                    $success = true;
                } else {
                    echo $this->error_response(get_string('settings_aadtenant_error', 'local_o365'));
                    die();
                }
            } catch (\Exception $e) {
                \local_o365\utils::debug($e->getMessage(), 'detect aadtenant');
                echo $this->error_response(get_string('settings_serviceresourceabstract_noperms', 'local_o365'));
                die();
            }
        } else if ($setting === 'odburl') {
            $entitykey = 'MyFiles@O365_SHAREPOINT';
            try {
                $service = $discovery->get_service($entitykey);
                if (!empty($service) && isset($service['serviceResourceId'])) {
                    $data->settingval = trim(parse_url($service['serviceResourceId'], PHP_URL_HOST), '/');
                    $success = true;
                } else {
                    echo $this->error_response(get_string('settings_odburl_error', 'local_o365'));
                    die();
                }
            } catch (\Exception $e) {
                \local_o365\utils::debug($e->getMessage(), 'detect odburl');
                echo $this->error_response(get_string('settings_serviceresourceabstract_noperms', 'local_o365'));
                die();
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

        $enableunifiedapi = optional_param('enableunifiedapi', 0, PARAM_INT);
        set_config('enableunifiedapi', $enableunifiedapi, 'local_o365');

        $chineseapi = optional_param('chineseapi', 0, PARAM_INT);
        set_config('chineseapi', $chineseapi, 'local_o365');

        $aadtenant = required_param('aadtenant', PARAM_TEXT);
        set_config('aadtenant', $aadtenant, 'local_o365');

        $odburl = required_param('odburl', PARAM_TEXT);
        set_config('odburl', $odburl, 'local_o365');

        $resource = \local_o365\rest\azuread::get_resource();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();
        $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
        if (empty($token)) {
            throw new \moodle_exception('errorchecksystemapiuser', 'local_o365');
        }

        // Legacy API.
        $legacyapi = new \stdClass;
        try {
            $aadapiclient = new \local_o365\rest\azuread($token, $httpclient);
            list($missingperms, $haswrite) = $aadapiclient->check_permissions();
            $legacyapi->missingperms = $missingperms;
            $legacyapi->haswrite = $haswrite;
        } catch (\Exception $e) {
            \local_o365\utils::debug($e->getMessage(), 'mode_checksetup:legacy');
            $legacyapi->error = $e->getMessage();
        }
        $data->legacyapi = $legacyapi;

        // Unified API.
        $unifiedapi = new \stdClass;
        $unifiedapi->active = false;
        if (\local_o365\rest\unified::is_enabled() === true) {
            try {
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
            } catch (\Exception $e) {
                $unifiedapi->active = false;
                \local_o365\utils::debug($e->getMessage(), 'mode_checksetup:unified');
                $unifiedapi->error = $e->getMessage();
            }
        }
        $data->unifiedapi = $unifiedapi;
        set_config('unifiedapiactive', (int)$unifiedapi->active, 'local_o365');
        set_config('azuresetupresult', serialize($data), 'local_o365');

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
