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
 * Admin setting for the role sync mappings.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

use admin_setting_configtextarea;
use local_o365\feature\rolesync\main;

/**
 * Textarea setting holding one "group object ID=roleshortname[,roleshortname...]" mapping per line.
 */
class rolesyncmapping extends admin_setting_configtextarea {
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

        [, $errors] = main::parse_mapping((string) $data);
        if (empty($errors)) {
            return true;
        }

        $messages = [];
        foreach ($errors as [$type, $value]) {
            $messages[] = get_string('settings_rolesync_error_' . $type, 'local_o365', s($value));
        }

        return implode('<br>', array_unique($messages));
    }
}
