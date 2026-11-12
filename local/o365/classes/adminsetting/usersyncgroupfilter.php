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

use admin_setting_configtextarea;
use local_o365\feature\usersync\main;
use moodle_exception;

/**
 * Admin setting for group-based user sync filtering.
 * Stores the object IDs of the Microsoft 365 groups whose members (including members of nested groups) will be synced to Moodle.
 */
class usersyncgroupfilter extends admin_setting_configtextarea {
    /**
     * Constructor.
     *
     * @param string $name unique ascii name
     * @param string $visiblename localised name
     * @param string $description localised long description
     * @param mixed $defaultsetting string or array depending on implementation
     */
    public function __construct($name, $visiblename, $description, $defaultsetting = '') {
        parent::__construct($name, $visiblename, $description, $defaultsetting, PARAM_TEXT, '60', '3');
    }

    /**
     * Write the setting to the database with GUID format validation of every group ID.
     *
     * The IDs are stored normalised as a comma separated list, so a single group ID is stored exactly as before.
     *
     * @param string $data The value to write
     * @return string Empty string if successful, error message if validation fails
     */
    public function write_setting($data) {
        $ids = main::split_group_ids((string) $data);

        // Empty value is allowed (optional setting).
        if (empty($ids)) {
            return parent::write_setting('');
        }

        // Check every ID, so that all problems are reported at once instead of one per save.
        $malformed = [];
        $wellformed = [];
        foreach ($ids as $id) {
            // GUID format: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx.
            if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $id)) {
                $wellformed[] = $id;
            } else {
                $malformed[] = $id;
            }
        }

        $errors = [];
        if (!empty($malformed)) {
            $errors[] = get_string('settings_usersyncgroupfilter_validation_error', 'local_o365', implode(', ', $malformed));
        }

        // Check that the groups exist. This only covers the moment of saving: a group can still be deleted later, which the
        // user sync reports when it runs.
        $verified = true;
        if (!empty($wellformed)) {
            try {
                $foundgroups = $this->get_group_api_client()->get_groups_batch($wellformed);
                $notfound = [];
                foreach ($wellformed as $id) {
                    if (empty($foundgroups[$id]['id'])) {
                        $notfound[] = $id;
                    }
                }
                if (!empty($notfound)) {
                    $errors[] = get_string('settings_usersyncgroupfilter_notfound', 'local_o365', implode(', ', $notfound));
                }
            } catch (moodle_exception $e) {
                // Microsoft Graph is not configured or not reachable, which says nothing about the groups.
                $verified = false;
            }
        }

        if (!empty($errors)) {
            return implode(' ', $errors);
        }

        if (!$verified) {
            \core\notification::warning(get_string('settings_usersyncgroupfilter_notverified', 'local_o365'));
        }

        return parent::write_setting(implode(',', $ids));
    }

    /**
     * Construct the Microsoft Graph API client used to check that the groups exist.
     *
     * Extracted into its own method so tests can override it to inject a stub API client.
     *
     * @return object An API client exposing get_groups_batch().
     * @throws moodle_exception
     */
    protected function get_group_api_client() {
        $usersync = new main();

        return $usersync->construct_user_api();
    }
}
