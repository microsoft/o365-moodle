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

use repository_office365\upgrade_helper;

/**
 * Upgrade function for repository_office365.
 *
 * @param int $oldversion The old version number.
 * @return bool True on success.
 */
function xmldb_repository_office365_upgrade($oldversion) {
    global $DB;

    $oldbehaviour = upgrade_helper::get_link_options_behaviour($oldversion);

    if ($oldversion < 2024100720.01) {
        // Migrate old 'disable' settings to new 'enable' settings with flipped logic.
        if ($oldbehaviour !== upgrade_helper::LINK_OPTIONS_NONE) {
            // The old version had the link options, so there is a setting to migrate.

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
        } else {
            // The link options did not exist yet, so there is nothing to migrate and they must stay off.
            unset_config('disabledirectlink', 'office365');
            unset_config('disableanonymousshare', 'office365');
        }

        // Savepoint reached.
        upgrade_plugin_savepoint(true, 2024100720.01, 'repository', 'office365');
    }

    if ($oldversion < 2024100735.01) {
        // The migration above only converted 'disabledirectlink' / 'disableanonymousshare' when those
        // legacy settings had been explicitly saved. Sites that never opened the repository type
        // settings form never had those settings stored, so the migration silently skipped them and
        // left 'enabledirectlink' / 'enableanonymousshare' unset, which the opt-in logic treats as disabled.
        //
        // Whether an unset setting should become enabled depends on what the site had before:
        // Before the options existed they stay off. Enabling them would expose a "Link to the file" option
        // that does not change sharing permissions, which students can not open.
        // While the options were opt-out, unset means they were on.
        // While the options were opt-in, unset means off, so they are only restored when the site holds
        // references that were created with the option.
        // Settings that are already configured are never changed.
        $optionlinktypes = ['enabledirectlink' => 'directlink', 'enableanonymousshare' => 'controlledshare'];
        $usedlinktypes = null;
        foreach ($optionlinktypes as $option => $linktype) {
            if (get_config('office365', $option) !== false || $oldbehaviour === upgrade_helper::LINK_OPTIONS_NONE) {
                continue;
            }

            if ($oldbehaviour === upgrade_helper::LINK_OPTIONS_OPTOUT) {
                set_config($option, 1, 'office365');
                continue;
            }

            if ($usedlinktypes === null) {
                $usedlinktypes = upgrade_helper::get_used_link_types();
            }

            if (in_array($linktype, $usedlinktypes)) {
                set_config($option, 1, 'office365');
            }
        }

        // Savepoint reached.
        upgrade_plugin_savepoint(true, 2024100735.01, 'repository', 'office365');
    }

    return true;
}
