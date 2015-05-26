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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
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

    if ($result && $oldversion < 2014111703) {
        // Lengthen field.
        $table = new xmldb_table('auth_oidc_token');
        $field = new xmldb_field('scope', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'username');
        $dbman->change_field_type($table, $field);

        upgrade_plugin_savepoint($result, '2014111703', 'auth', 'oidc');
    }

    if ($result && $oldversion < 2015011604) {
        $table = new xmldb_table('auth_oidc_state');
        $field = new xmldb_field('additionaldata', XMLDB_TYPE_TEXT, null, null, null, null, null, 'timecreated');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        upgrade_plugin_savepoint($result, '2015011604', 'auth', 'oidc');
    }

    if ($result && $oldversion < 2015011605) {
        $table = new xmldb_table('auth_oidc_token');
        $field = new xmldb_field('oidcusername', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'username');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        upgrade_plugin_savepoint($result, '2015011605', 'auth', 'oidc');
    }

    if ($result && $oldversion < 2015011607) {
        // Update OIDC users.
        $sql = 'SELECT user.id as userid,
                       user.username as username,
                       tok.id as tokenid,
                       tok.oidcuniqid as oidcuniqid,
                       tok.idtoken as idtoken
                  FROM {auth_oidc_token} tok
                  JOIN {user} user ON user.username = tok.username
                 WHERE user.auth = ? AND deleted = 0';
        $params = ['oidc'];
        $userstoupdate = $DB->get_recordset_sql($sql, $params);
        foreach ($userstoupdate as $user) {
            if (empty($user->idtoken)) {
                continue;
            }

            try {
                // Decode idtoken and determine oidc username.
                $idtoken = \auth_oidc\jwt::instance_from_encoded($user->idtoken);
                $oidcusername = $idtoken->claim('upn');
                if (empty($oidcusername)) {
                    $oidcusername = $idtoken->claim('sub');
                }

                // Populate token oidcusername.
                $updatedtoken = new \stdClass;
                $updatedtoken->id = $user->tokenid;
                $updatedtoken->oidcusername = $oidcusername;
                $DB->update_record('auth_oidc_token', $updatedtoken);

                // Update user username (if applicable), so user can use rocreds loginflow.
                if ($user->username == strtolower($user->oidcuniqid)) {
                    // Old username, update to upn/sub.
                    if ($oidcusername != $user->username) {
                        // Update username.
                        $updateduser = new \stdClass;
                        $updateduser->id = $user->userid;
                        $updateduser->username = $oidcusername;
                        $DB->update_record('user', $updateduser);

                        $updatedtoken = new \stdClass;
                        $updatedtoken->id = $user->tokenid;
                        $updatedtoken->username = $oidcusername;
                        $DB->update_record('auth_oidc_token', $updatedtoken);
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        upgrade_plugin_savepoint($result, '2015011607', 'auth', 'oidc');
    }

    if ($result && $oldversion < 2015011612) {
        if (!$dbman->table_exists('auth_oidc_prevlogin')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'auth_oidc_prevlogin');
        }
        upgrade_plugin_savepoint($result, '2015011612', 'auth', 'oidc');
    }

    if ($result && $oldversion < 2015011615) {
        // Lengthen field.
        $table = new xmldb_table('auth_oidc_token');
        $field = new xmldb_field('scope', XMLDB_TYPE_TEXT, null, null, null, null, null, 'oidcusername');
        $dbman->change_field_type($table, $field);
        upgrade_plugin_savepoint($result, '2015011615', 'auth', 'oidc');
    }

    return $result;
}
