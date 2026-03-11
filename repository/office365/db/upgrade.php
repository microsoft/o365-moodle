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
 * Upgrade script for repository_office365.
 *
 * @package    repository_office365
 * @copyright  2026 Microsoft, Inc.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade function for repository_office365.
 *
 * @param int $oldversion The old version number.
 * @return bool True on success.
 */
function xmldb_repository_office365_upgrade($oldversion) {
    global $DB;

    if ($oldversion < 2025100600.01) {
        // Migrate old 'disable' settings to new 'enable' settings with flipped logic.

        // Migrate disabledirectlink to enabledirectlink.
        $olddirectlink = get_config('office365', 'disabledirectlink');
        if ($olddirectlink !== false) {
            // Flip the logic: disabled=1 becomes enabled=0, disabled=0 becomes enabled=1.
            $newdirectlink = empty($olddirectlink) ? 1 : 0;
            set_config('enabledirectlink', $newdirectlink, 'office365');
            unset_config('disabledirectlink', 'office365');
        }

        // Migrate disableanonymousshare to enableanonymousshare.
        $oldanonymousshare = get_config('office365', 'disableanonymousshare');
        if ($oldanonymousshare !== false) {
            // Flip the logic: disabled=1 becomes enabled=0, disabled=0 becomes enabled=1.
            $newanonymousshare = empty($oldanonymousshare) ? 1 : 0;
            set_config('enableanonymousshare', $newanonymousshare, 'office365');
            unset_config('disableanonymousshare', 'office365');
        }

        // Savepoint reached.
        upgrade_plugin_savepoint(true, 2025100600.01, 'repository', 'office365');
    }

    return true;
}
