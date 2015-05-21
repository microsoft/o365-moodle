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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
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

    if ($result && $oldversion < 2014111710) {
        if (!$dbman->table_exists('local_o365_coursespsite')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'local_o365_coursespsite');
        }
        if (!$dbman->table_exists('local_o365_spgroupdata')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'local_o365_spgroupdata');
        }
        if (!$dbman->table_exists('local_o365_aaduserdata')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'local_o365_aaduserdata');
        }
        upgrade_plugin_savepoint($result, '2014111710', 'local', 'o365');
    }

    if ($result && $oldversion < 2014111711) {
        $table = new xmldb_table('local_o365_spgroupdata');
        $field = new xmldb_field('permtype', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'grouptitle');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        upgrade_plugin_savepoint($result, '2014111711', 'local', 'o365');
    }

    if ($result && $oldversion < 2014111715) {
        if (!$dbman->table_exists('local_o365_spgroupassign')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'local_o365_spgroupassign');
        }
        upgrade_plugin_savepoint($result, '2014111715', 'local', 'o365');
    }

    if ($result && $oldversion < 2014111716) {
        // Drop old index.
        $table = new xmldb_table('local_o365_token');
        $index = new xmldb_index('usrresscp', XMLDB_INDEX_NOTUNIQUE, ['user_id', 'resource', 'scope']);
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }

        // Lengthen field.
        $table = new xmldb_table('local_o365_token');
        $field = new xmldb_field('scope', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'user_id');
        $dbman->change_field_type($table, $field);

        // Create new index.
        $table = new xmldb_table('local_o365_token');
        $index = new xmldb_index('usrres', XMLDB_INDEX_NOTUNIQUE, ['user_id', 'resource']);
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        upgrade_plugin_savepoint($result, '2014111716', 'local', 'o365');
    }

    if ($result && $oldversion < 2015011604) {
        // Migrate settings.
        $config = get_config('local_o365');
        if (empty($config->sharepointlink) && isset($config->tenant) && isset($config->parentsiteuri)) {
            $sharepointlink = 'https://'.$config->tenant.'.sharepoint.com/'.$config->parentsiteuri;
            set_config('sharepointlink', $sharepointlink, 'local_o365');
        }
        upgrade_plugin_savepoint($result, '2015011604', 'local', 'o365');
    }

    if ($result && $oldversion < 2015011606) {
        $config = get_config('local_o365');
        if (!empty($config->tenant)) {
            set_config('aadtenant', $config->tenant.'.onmicrosoft.com', 'local_o365');
            set_config('odburl', $config->tenant.'-my.sharepoint.com', 'local_o365');
        }
        upgrade_plugin_savepoint($result, '2015011606', 'local', 'o365');
    }

    if ($result && $oldversion < 2015011609) {
        $table = new xmldb_table('local_o365_calsub');
        $field = new xmldb_field('o365calid', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'caltypeid');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        $field = new xmldb_field('syncbehav', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'o365calid');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        upgrade_plugin_savepoint($result, '2015011609', 'local', 'o365');
    }

    if ($result && $oldversion < 2015011610) {
        $table = new xmldb_table('local_o365_calidmap');
        $field = new xmldb_field('origin', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'outlookeventid');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $idmaps = $DB->get_recordset('local_o365_calidmap');
        foreach ($idmaps as $idmap) {
            $newidmap = new \stdClass;
            $newidmap->id = $idmap->id;
            $newidmap->origin = 'moodle';
            $DB->update_record('local_o365_calidmap', $newidmap);
        }
        $idmaps->close();

        upgrade_plugin_savepoint($result, '2015011610', 'local', 'o365');
    }

    if ($result && $oldversion < 2015011611) {
        $table = new xmldb_table('local_o365_calidmap');
        $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'origin');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('local_o365_calsub');
        $field = new xmldb_field('isprimary', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1', 'o365calid');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Update the calidmap with the user id of the user who created the event. Before multi-cal syncing, the o365 event was
        // always created in the calendar of the event creating user (with others as attendees).
        $sql = 'SELECT idmap.id as idmapid,
                       ev.userid as eventuserid
                  FROM {local_o365_calidmap} idmap
                  JOIN {event} ev ON idmap.eventid = ev.id';
        $idmaps = $DB->get_recordset_sql($sql);
        foreach ($idmaps as $idmap) {
            $newidmap = new \stdClass;
            $newidmap->id = $idmap->idmapid;
            $newidmap->userid = $idmap->eventuserid;
            $DB->update_record('local_o365_calidmap', $newidmap);
        }
        $idmaps->close();

        upgrade_plugin_savepoint($result, '2015011611', 'local', 'o365');
    }

    if ($result && $oldversion < 2015011612) {
        $calsubs = $DB->get_recordset('local_o365_calsub');
        foreach ($calsubs as $i => $calsub) {
            if (empty($calsub->syncbehav)) {
                $newcalsub = new \stdClass;
                $newcalsub->id = $calsub->id;
                $newcalsub->syncbehav = 'out';
                $DB->update_record('local_o365_calsub', $newcalsub);
            }
        }
        $calsubs->close();
        upgrade_plugin_savepoint($result, '2015011612', 'local', 'o365');
    }

    if ($result && $oldversion < 2015011616) {
        // Lengthen field.
        $table = new xmldb_table('local_o365_token');
        $field = new xmldb_field('scope', XMLDB_TYPE_TEXT, null, null, null, null, null, 'user_id');
        $dbman->change_field_type($table, $field);
        upgrade_plugin_savepoint($result, '2015011616', 'local', 'o365');
    }

    if ($result && $oldversion < 2015011617) {
        if (!$dbman->table_exists('local_o365_objects')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'local_o365_objects');
        }
        upgrade_plugin_savepoint($result, '2015011617', 'local', 'o365');
    }

    if ($result && $oldversion < 2015011618) {
        $table = new xmldb_table('local_o365_objects');
        $field = new xmldb_field('subtype', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'type');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        upgrade_plugin_savepoint($result, '2015011618', 'local', 'o365');
    }

    if ($result && $oldversion < 2015011620) {
        // Lengthen field.
        $table = new xmldb_table('local_o365_token');
        $field = new xmldb_field('scope', XMLDB_TYPE_TEXT, null, null, null, null, null, 'user_id');
        $dbman->change_field_type($table, $field);
        upgrade_plugin_savepoint($result, '2015011620', 'local', 'o365');
    }

    return $result;
}
