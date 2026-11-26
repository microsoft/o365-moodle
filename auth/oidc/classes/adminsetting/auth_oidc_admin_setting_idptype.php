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
 * Admin setting class for the IdP type.
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
 * Admin setting for the IdP type, which also updates the logout endpoint, that is on another settings page, when changed.
 */
class auth_oidc_admin_setting_idptype extends \admin_setting_configselect {
    /**
     * Save the IdP type, and update the saved logout endpoint when the type has changed.
     *
     * @param mixed $data The submitted IdP type.
     * @return string An empty string when saved, an error message otherwise.
     */
    public function write_setting($data) {
        $previous = (int) get_config('auth_oidc', 'idptype');
        $result = parent::write_setting($data);

        if ($result === '') {
            // The authorization endpoint and the Microsoft cloud are saved after the IdP type, so use the submitted values.
            auth_oidc_convert_logout_endpoint(
                $previous,
                (int) $data,
                (string) auth_oidc_get_submitted_or_saved_config('authendpoint'),
                (int) auth_oidc_get_submitted_or_saved_config('microsoftcloud')
            );
        }

        return $result;
    }
}
