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

    if ($oldversion < 2026042000.01) {
        // The migration above only converted 'disabledirectlink' / 'disableanonymousshare' when those
        // legacy settings had been explicitly saved. Sites that never opened the repository type
        // settings form (the common case, since the previous default already allowed both options)
        // never had those settings stored, so the migration silently skipped them. Those sites ended
        // up with 'enabledirectlink' / 'enableanonymousshare' unset, which the new opt-in logic treats
        // as disabled, even though the options were enabled by default before this change.
        //
        // Restore the original enabled-by-default behaviour wherever the new setting is still unset,
        // without touching sites that have already explicitly configured it either way.
        if (get_config('office365', 'enabledirectlink') === false) {
            set_config('enabledirectlink', 1, 'office365');
        }

        if (get_config('office365', 'enableanonymousshare') === false) {
            set_config('enableanonymousshare', 1, 'office365');
        }

        // Savepoint reached.
        upgrade_plugin_savepoint(true, 2026042000.01, 'repository', 'office365');
    }

    return true;
}
