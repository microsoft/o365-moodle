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
 * Admin setting for group-based user sync filtering.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

use admin_setting_configtext;


/**
 * Admin setting for group-based user sync filtering.
 * Stores the Microsoft 365 group ID whose members will be synced to Moodle.
 */
class usersyncgroupfilter extends admin_setting_configtext {
    /**
     * Constructor.
     *
     * @param string $name unique ascii name
     * @param string $visiblename localised name
     * @param string $description localised long description
     * @param mixed $defaultsetting string or array depending on implementation
     */
    public function __construct($name, $visiblename, $description, $defaultsetting = '') {
        parent::__construct($name, $visiblename, $description, $defaultsetting, PARAM_TEXT);
    }

    /**
     * Write the setting to the database with GUID format validation.
     *
     * @param string $data The value to write
     * @return string Empty string if successful, error message if validation fails
     */
    public function write_setting($data) {
        $data = trim((string) $data);

        // Empty value is allowed (optional setting).
        if ($data === '') {
            return parent::write_setting($data);
        }

        // Check if the value matches GUID format: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx.
        // Pattern: 8 hex digits, dash, 4 hex digits, dash, 4 hex digits, dash, 4 hex digits, dash, 12 hex digits.
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $data)) {
            return get_string('settings_usersyncgroupfilter_validation_error', 'local_o365');
        }

        return parent::write_setting($data);
    }
}
