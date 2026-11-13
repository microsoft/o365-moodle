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
 * Admin setting for the claim role sync mapping.
 *
 * @package auth_oidc
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc\adminsetting;

use admin_setting_configtextarea;
use auth_oidc\rolesync;

/**
 * Textarea setting holding one "claim|value=roleshortname[,roleshortname...]" mapping per line.
 */
class auth_oidc_admin_setting_rolesyncmapping extends admin_setting_configtextarea {
    /**
     * Constructor.
     *
     * @param string $name Unique setting name.
     * @param string $visiblename Localised name.
     * @param string $description Localised long description.
     */
    public function __construct($name, $visiblename, $description) {
        parent::__construct($name, $visiblename, $description, '', PARAM_RAW, '60', '8');
    }

    /**
     * Validate the mapping.
     *
     * @param string $data The submitted value.
     * @return bool|string True if valid, an error message otherwise.
     */
    public function validate($data) {
        $result = parent::validate($data);
        if ($result !== true) {
            return $result;
        }

        [, $errors] = rolesync::parse_claim_mapping((string) $data);
        if (empty($errors)) {
            return true;
        }

        $messages = [];
        foreach ($errors as [$type, $value]) {
            // An invalid "claim|value" key is reported like any other badly formatted line.
            $stringkey = $type === 'key' ? 'format' : $type;
            $messages[] = get_string('settings_role_sync_error_' . $stringkey, 'auth_oidc', s($value));
        }

        return implode('<br>', array_unique($messages));
    }
}
