<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Admin setting class for the IdP logout endpoint URL.
 *
 * @package    auth_oidc
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2023 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc\adminsetting;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/auth/oidc/lib.php');

/**
 * Admin setting for the IdP logout endpoint URL, with a default that depends on the configured IdP type.
 */
class auth_oidc_admin_setting_logoutendpoint extends \admin_setting_configtext {
    /**
     * Constructor.
     *
     * @param string $name Setting name in 'plugin/settingname' format.
     * @param string $visiblename Visible label shown to the administrator.
     * @param string $description Help text shown below the field.
     * @param string $defaultsetting Default URL value.
     */
    public function __construct(string $name, string $visiblename, string $description, string $defaultsetting) {
        parent::__construct($name, $visiblename, $description, $defaultsetting, PARAM_URL, 100);
    }

    /**
     * Validate the logout endpoint.
     *
     * For Microsoft Entra External ID, the endpoint has to be a ciamlogin.com v2.0 endpoint. This is only checked when single
     * logout is enabled, as the field is not in use otherwise.
     *
     * @param string $data The submitted URL value.
     * @return string|true True when valid; a translatable error string otherwise.
     */
    public function validate($data) {
        $idptype = (int) auth_oidc_get_submitted_or_saved_config('idptype');
        $singlelogout = auth_oidc_get_submitted_or_saved_config('single_logout');

        if ($idptype === AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID && !empty($singlelogout) && trim((string) $data) !== '') {
            // An empty value is valid, the endpoint is then derived from the authorization endpoint.
            $errorid = auth_oidc_get_external_id_endpoint_error((string) $data, 'logout');
            if ($errorid === 'error_endpoint_external_id') {
                // The general message describes the authorization and token endpoints.
                $errorid = 'error_logoutendpoint_external_id';
            }
            if ($errorid !== null) {
                return get_string($errorid, 'auth_oidc', $errorid === 'error_endpoint_external_id_kind' ? 'logout' : null);
            }
        }

        return parent::validate($data);
    }

    /**
     * Return the HTML of the setting, with the default of the configured IdP type.
     *
     * The IdP type is on another settings page, so the saved type is used.
     *
     * @param mixed $data The current value.
     * @param string $query Search query being highlighted.
     * @return string
     */
    public function output_html($data, $query = '') {
        $idptype = (int) get_config('auth_oidc', 'idptype');
        $originaldefault = $this->defaultsetting;
        if ($idptype !== AUTH_OIDC_IDP_TYPE_NOT_CONNECTED) {
            $this->defaultsetting = auth_oidc_get_default_logout_endpoint($idptype);
        }
        $html = parent::output_html($data, $query);
        $this->defaultsetting = $originaldefault;

        return $html;
    }
}
