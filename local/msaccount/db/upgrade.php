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
 * @package    local_msaccount
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

/**
 * Upgrade the local_msaccount plugin.
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_local_msaccount_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014111702) {
        // Define table to be created.
        $table = new xmldb_table('msaccount_refresh_tokens');

        // Adding fields to table.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('user_id', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('refresh_token', XMLDB_TYPE_CHAR, '500', null, null, null, null);

        // Adding keys to table.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Create table.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }
        $dbman->create_table($table);

        // Msaccount savepoint reached.
        upgrade_plugin_savepoint(true, 2014111702, 'local', 'msaccount');
    }

    if ($oldversion < 2016062001) {
        // Define table to be modified.
        $table = new xmldb_table('msaccount_refresh_tokens');

        if ($dbman->table_exists($table)) {
            // Rename the table to use the correct Moodle naming convention.
            $dbman->rename_table($table, 'local_msaccount_refreshtok');
        }

        // Msaccount savepoint reached.
        upgrade_plugin_savepoint(true, 2016062001, 'local', 'msaccount');
    }

    return true;
}
