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
 * Admin setting class for the custom claims setting.
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
 * Admin setting for the space-separated list of custom claim names.
 *
 * Extends the standard text setting with validation that rejects the value when any entry is
 * not a valid claim name, matching the validation applied on the application configuration wizard.
 */
class auth_oidc_admin_setting_customclaims extends \admin_setting_configtext {
    /**
     * Validate the submitted list of custom claim names.
     *
     * @param string $data The submitted value.
     * @return string|true True when valid; a translatable error string otherwise.
     */
    public function validate($data) {
        $result = parent::validate($data);
        if ($result !== true) {
            return $result;
        }

        $invalidclaims = auth_oidc_validate_custom_claims((string) $data);
        if ($invalidclaims) {
            return get_string('error_invalid_custom_claim', 'auth_oidc', implode(', ', $invalidclaims));
        }

        return true;
    }
}
