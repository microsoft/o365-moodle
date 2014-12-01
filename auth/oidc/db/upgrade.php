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
 * @package auth_oidc
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
function xmldb_auth_oidc_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();
    $result = true;

    if ($result && $oldversion < 2014110800) {
        if (!$dbman->table_exists('auth_oidc_state')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'auth_oidc_state');
        }
        upgrade_plugin_savepoint($result, '2014110800', 'auth', 'oidc');
    }

    if ($result && $oldversion < 2014111000) {
        if (!$dbman->table_exists('auth_oidc_token')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'auth_oidc_token');
        }
        upgrade_plugin_savepoint($result, '2014111000', 'auth', 'oidc');
    }

    if ($result && $oldversion < 2014111002) {
        $table = new \xmldb_table('auth_oidc_token');
        $field = new \xmldb_field('username', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, false, '0', 'sub');
        $dbman->add_field($table, $field);
        upgrade_plugin_savepoint($result, '2014111002', 'auth', 'oidc');
    }

    if ($result && $oldversion < 2014111003) {
        $table = new \xmldb_table('auth_oidc_token');
        $field = new \xmldb_field('authcode', XMLDB_TYPE_TEXT, null, null, null, false, null, 'sub');
        $dbman->add_field($table, $field);
        upgrade_plugin_savepoint($result, '2014111003', 'auth', 'oidc');
    }

    if ($result && $oldversion < 2014111004) {
        $table = new \xmldb_table('auth_oidc_state');
        $field = new \xmldb_field('nonce', XMLDB_TYPE_CHAR, '15', null, XMLDB_NOTNULL, false, '0', 'state');
        $dbman->add_field($table, $field);
        upgrade_plugin_savepoint($result, '2014111004', 'auth', 'oidc');
    }


    return $result;
}