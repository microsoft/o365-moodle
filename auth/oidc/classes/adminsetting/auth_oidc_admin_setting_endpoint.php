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
 * Admin setting class for Microsoft authorization and token endpoint URLs.
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
 * Admin setting for Microsoft authorization or token endpoint URLs.
 *
 * Extends the standard text setting with validation that ensures the endpoint
 * URL version (v1 / v2) matches the selected IdP type, and that tenant-specific
 * endpoints are used when certificate authentication is configured on the
 * Microsoft Identity Platform (v2) IdP type.
 *
 * Cross-field validation reads the co-submitted idptype and clientauthmethod
 * values from the current request via optional_param() so that the checks
 * reflect the values being saved in the same form submission.
 */
class auth_oidc_admin_setting_endpoint extends \admin_setting_configtext {
    /** @var string Endpoint type: 'auth' for the authorization endpoint, 'token' for the token endpoint. */
    protected string $endpointtype;

    /**
     * Constructor.
     *
     * @param string $name           Setting name in 'plugin/settingname' format.
     * @param string $visiblename    Visible label shown to the administrator.
     * @param string $description    Help text shown below the field.
     * @param string $defaultsetting Default URL value.
     * @param string $endpointtype   Either 'auth' or 'token'; governs which version-mismatch
     *                               error string is used.
     */
    public function __construct(
        string $name,
        string $visiblename,
        string $description,
        string $defaultsetting,
        string $endpointtype = 'auth'
    ) {
        // The fields are wide enough to show a complete endpoint, including a tenant ID.
        parent::__construct($name, $visiblename, $description, $defaultsetting, PARAM_URL, 100);
        $this->endpointtype = $endpointtype;
    }

    /**
     * Validate the endpoint URL against the IdP type and client authentication method.
     *
     * For Microsoft IdP types the URL scheme (v1 vs v2) must match the IdP type value.
     * When using certificate authentication on the Microsoft Identity Platform (v2), the
     * URL must point to a tenant-specific endpoint (not /common/, /organizations/, or
     * /consumers/).
     *
     * @param string $data The submitted URL value.
     * @return string|true True when valid; a translatable error string otherwise.
     */
    public function validate($data) {
        // Read the IdP type and auth method from the current form submission,
        // falling back to the saved configuration when the values are absent.
        $idptype = (int) optional_param(
            's_auth_oidc_idptype',
            get_config('auth_oidc', 'idptype'),
            PARAM_INT
        );
        $clientauthmethod = (int) optional_param(
            's_auth_oidc_clientauthmethod',
            get_config('auth_oidc', 'clientauthmethod'),
            PARAM_INT
        );

        if ($idptype === AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID) {
            // External ID endpoints must use the ciamlogin.com authority host and the v2.0 endpoint style. This is checked
            // before the generic URL validation, so the placeholders of the default template get a specific message.
            $kind = $this->endpointtype === 'token' ? 'token' : 'authorize';
            $error = auth_oidc_validate_external_id_endpoint((string) $data, $kind);
            if ($error !== null) {
                return $error;
            }

            // Both endpoints have to belong to the same tenant.
            if ($this->endpointtype === 'token') {
                $authendpoint = (string) optional_param(
                    's_auth_oidc_authendpoint',
                    get_config('auth_oidc', 'authendpoint'),
                    PARAM_RAW
                );
                if (
                    auth_oidc_validate_external_id_endpoint($authendpoint, 'authorize') === null &&
                    !auth_oidc_is_same_external_id_tenant($authendpoint, (string) $data)
                ) {
                    return get_string('error_endpoint_external_id_mismatch', 'auth_oidc');
                }
            }

            return parent::validate($data);
        }

        $result = parent::validate($data);
        if ($result !== true) {
            return $result;
        }

        if (!in_array($idptype, [AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM])) {
            // Non-Microsoft IdP types have no endpoint version requirements.
            return true;
        }

        // A Microsoft Entra External ID endpoint does not work with the workforce IdP types.
        if (auth_oidc_is_external_id_host((string) $data)) {
            return get_string('error_endpoint_is_external_id', 'auth_oidc');
        }

        // The endpoint URL version must match the configured IdP type.
        $endpointversion = auth_oidc_determine_endpoint_version($data);
        if ($endpointversion !== $idptype) {
            $mismatchkey = $this->endpointtype === 'token'
                ? 'error_endpoint_mismatch_token_endpoint'
                : 'error_endpoint_mismatch_auth_endpoint';
            return get_string($mismatchkey, 'auth_oidc');
        }

        // Certificate authentication on Identity Platform requires tenant-specific endpoints.
        if (
            $idptype === AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM &&
            $clientauthmethod === AUTH_OIDC_AUTH_METHOD_CERTIFICATE
        ) {
            if (
                strpos($data, '/common/') !== false ||
                strpos($data, '/organizations/') !== false ||
                strpos($data, '/consumers/') !== false
            ) {
                return get_string('error_tenant_specific_endpoint_required', 'auth_oidc');
            }
        }

        return true;
    }

    /**
     * Return the HTML of the setting, with the script that updates the endpoints when the IdP type is changed.
     *
     * @param mixed $data The current value.
     * @param string $query Search query being highlighted.
     * @return string
     */
    public function output_html($data, $query = '') {
        auth_oidc_require_endpoint_autoupdate_js(
            'id_s_auth_oidc_idptype',
            'id_s_auth_oidc_authendpoint',
            'id_s_auth_oidc_tokenendpoint',
            true
        );

        // The default shown next to the field follows the IdP type, as the default of the type is what the field is
        // updated to when the type is changed. Without it, the generic default would show a Microsoft Entra ID endpoint
        // for the other IdP types. The type is only known to differ from "Not connected" once it has been configured.
        $idptype = (int) get_config('auth_oidc', 'idptype');
        $originaldefault = $this->defaultsetting;
        if ($idptype !== AUTH_OIDC_IDP_TYPE_NOT_CONNECTED) {
            $defaults = auth_oidc_get_default_endpoints($idptype);
            $this->defaultsetting = $defaults[$this->endpointtype === 'token' ? 'token' : 'authorize'];
        }
        $html = parent::output_html($data, $query);
        $this->defaultsetting = $originaldefault;

        return $html;
    }
}
