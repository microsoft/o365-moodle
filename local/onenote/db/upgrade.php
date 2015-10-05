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
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft Open Technologies, Inc.
 */

/**
 * Upgrade the local_onenote plugin.
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_local_onenote_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014110503) {
        if (!$dbman->table_exists('onenote_user_sections')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'onenote_user_sections');
        }

        if (!$dbman->table_exists('onenote_assign_pages')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'onenote_assign_pages');
        }
        upgrade_plugin_savepoint(true, 2014110503, 'local', 'onenote');
    }

    return true;
}
