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
 * Admin setting class for the client authentication method.
 *
 * @package    auth_oidc
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc\adminsetting;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/auth/oidc/lib.php');

/**
 * Admin setting for the client authentication method.
 *
 * Certificate authentication is only supported by the Microsoft identity platform (v2.0) IdP type, so the certificate
 * option is disabled in the form for the other IdP types and rejected when saved with them.
 *
 * The IdP type is read from the current form submission via optional_param(), falling back to the saved value, so the
 * check reflects the values being saved together.
 */
class auth_oidc_admin_setting_clientauthmethod extends \admin_setting_configselect {
    /**
     * Get the IdP type being saved, or the saved one when it is not part of the current request.
     *
     * @return int
     */
    protected function get_idptype(): int {
        return (int) optional_param('s_auth_oidc_idptype', get_config('auth_oidc', 'idptype'), PARAM_INT);
    }

    /**
     * Save the submitted authentication method, unless it is certificate and the IdP type does not support it.
     *
     * @param string $data The submitted value.
     * @return string Empty string on success, error message otherwise.
     */
    public function write_setting($data) {
        if (
            $data == AUTH_OIDC_AUTH_METHOD_CERTIFICATE &&
            $this->get_idptype() != AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM
        ) {
            return get_string('error_certificate_requires_identity_platform', 'auth_oidc');
        }

        return parent::write_setting($data);
    }

    /**
     * Return the HTML of the setting, with a script that disables the certificate option for unsupported IdP types.
     *
     * When the IdP type selector is not on the page, the saved IdP type is used, so an existing certificate selection is
     * not reset.
     *
     * @param mixed $data The current value.
     * @param string $query Search query being highlighted.
     * @return string
     */
    public function output_html($data, $query = '') {
        global $PAGE;

        $idptypeid = 'id_s_auth_oidc_idptype';
        $methodid = 'id_' . $this->get_full_name();
        $PAGE->requires->js_amd_inline(sprintf(
            "require(['jquery'], function($) {
                var idptype = $('#%s');
                var method = $('#%s');
                var certificate = method.find('option[value=\"%d\"]');
                function update() {
                    // The IdP type selector is not on the page when the setting is rendered on its own, for example in
                    // the admin settings search results, so fall back to the current IdP type.
                    var currentidptype = idptype.length ? idptype.val() : '%d';
                    var supported = currentidptype == '%d';
                    // Reset the selected method before disabling the option, as val() returns null while the selected
                    // option is disabled, and a disabled selected option would be left out of the submission.
                    if (!supported && method.val() == '%d') {
                        method.val('%d').trigger('change');
                    }
                    certificate.prop('disabled', !supported);
                }
                idptype.on('change', update);
                update();
            });",
            $idptypeid,
            $methodid,
            AUTH_OIDC_AUTH_METHOD_CERTIFICATE,
            $this->get_idptype(),
            AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM,
            AUTH_OIDC_AUTH_METHOD_CERTIFICATE,
            AUTH_OIDC_AUTH_METHOD_SECRET
        ));

        return parent::output_html($data, $query);
    }
}
