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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Admin setting class for the OIDC login state expiry setting.
 *
 * @package    auth_oidc
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc\adminsetting;

/**
 * Admin setting for the OIDC login state expiry, in minutes.
 *
 * Extends the standard text setting with validation that rejects values below one minute. A
 * value of zero (or less) would cause the state cleanup task to delete login state records
 * almost immediately, breaking any login that is currently in progress.
 */
class auth_oidc_admin_setting_stateexpiry extends \admin_setting_configtext {
    /**
     * Validate the submitted expiry value.
     *
     * @param string $data The submitted value.
     * @return string|true True when valid; a translatable error string otherwise.
     */
    public function validate($data) {
        $result = parent::validate($data);
        if ($result !== true) {
            return $result;
        }

        if ((int) $data < 1) {
            return get_string('error_stateexpiry_min', 'auth_oidc');
        }

        return true;
    }
}
