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
 * Admin setting class for the secret expiry notification recipients setting.
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
 * Admin setting for the comma-separated list of secret expiry notification recipients.
 *
 * Extends the standard text setting with validation that rejects the value when any entry is
 * not a valid email address, so the local_o365 notifysecretexpiry task is not left silently
 * dropping recipients at run time.
 */
class auth_oidc_admin_setting_secretexpiryrecipients extends \admin_setting_configtext {
    /**
     * Validate the submitted list of recipient email addresses.
     *
     * @param string $data The submitted value.
     * @return string|true True when valid; a translatable error string otherwise.
     */
    public function validate($data) {
        $result = parent::validate($data);
        if ($result !== true) {
            return $result;
        }

        $invalidemails = auth_oidc_validate_secret_expiry_recipients((string) $data);
        if ($invalidemails) {
            return get_string('error_secretexpiryrecipients_invalid', 'auth_oidc', implode(', ', $invalidemails));
        }

        return true;
    }
}
