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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

/**
 * Update plugin.
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_local_o365_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();
    $result = true;

    if ($result && $oldversion < 2014111700) {
        if (!$dbman->table_exists('local_o365_token')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'local_o365_token');
        }
        upgrade_plugin_savepoint($result, '2014111700', 'local', 'o365');
    }

    if ($result && $oldversion < 2014111702) {
        if (!$dbman->table_exists('local_o365_calsub')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'local_o365_calsub');
        }
        if (!$dbman->table_exists('local_o365_calidmap')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'local_o365_calidmap');
        }
        upgrade_plugin_savepoint($result, '2014111702', 'local', 'o365');
    }

    if ($result && $oldversion < 2014111703) {
        $table = new xmldb_table('local_o365_calidmap');
        $field = new xmldb_field('outlookeventid', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'eventid');
        $dbman->change_field_type($table, $field);
        upgrade_plugin_savepoint($result, '2014111703', 'local', 'o365');
    }

    if ($result && $oldversion < 2014111707) {
        if (!$dbman->table_exists('local_o365_cronqueue')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'local_o365_cronqueue');
        }
        upgrade_plugin_savepoint($result, '2014111707', 'local', 'o365');
    }

    return $result;
}