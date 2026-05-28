<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin upgrade steps.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Execute tiny_teamsmeeting upgrade from the given old version.
 *
 * @param int $oldversion Old plugin version.
 * @return bool
 */
function xmldb_tiny_teamsmeeting_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2025100205) {
        $table = new xmldb_table('tiny_teamsmeeting');

        // Add userid field.
        $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'id');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Add contextid field.
        $field = new xmldb_field('contextid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'userid');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Add foreign key for userid.
        $key = new xmldb_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);
        $dbman->add_key($table, $key);

        // Add foreign key for contextid.
        $key = new xmldb_key('contextid', XMLDB_KEY_FOREIGN, ['contextid'], 'context', ['id']);
        $dbman->add_key($table, $key);

        // Add index on userid.
        $index = new xmldb_index('userid', XMLDB_INDEX_NOTUNIQUE, ['userid']);
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Add index on contextid.
        $index = new xmldb_index('contextid', XMLDB_INDEX_NOTUNIQUE, ['contextid']);
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        upgrade_plugin_savepoint(true, 2025100205, 'tiny', 'teamsmeeting');
    }

    if ($oldversion < 2025100206) {
        // Remove duplicate meeting rows, keeping the oldest record (lowest id)
        // for each unique link. Deduplication is now enforced at the insert
        // site in result.php, so this is a one-time clean-up for existing data.
        $records = $DB->get_records('tiny_teamsmeeting', null, 'id ASC', 'id, link');
        $seen = [];
        $duplicateids = [];
        foreach ($records as $record) {
            if (isset($seen[$record->link])) {
                $duplicateids[] = $record->id;
            } else {
                $seen[$record->link] = true;
            }
        }
        if (!empty($duplicateids)) {
            $DB->delete_records_list('tiny_teamsmeeting', 'id', $duplicateids);
        }
        unset($seen, $duplicateids);

        upgrade_plugin_savepoint(true, 2025100206, 'tiny', 'teamsmeeting');
    }

    if ($oldversion < 2025100207) {
        $table = new xmldb_table('tiny_teamsmeeting');

        // Add the linkhash column (nullable initially so the ALTER succeeds on
        // non-empty tables before the values are populated below).
        $field = new xmldb_field('linkhash', XMLDB_TYPE_CHAR, '40', null, null, null, null, 'link');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Populate linkhash for all existing rows using PHP's sha1() so the
        // computation is portable across every database Moodle supports.
        $records = $DB->get_records('tiny_teamsmeeting', null, 'id ASC', 'id, link');
        foreach ($records as $record) {
            $DB->set_field('tiny_teamsmeeting', 'linkhash', sha1($record->link), ['id' => $record->id]);
        }
        unset($records);

        // Add the unique index now that every row has a value. Step 2025100206
        // already removed duplicate link rows, so no hash collisions remain.
        $index = new xmldb_index('linkhash', XMLDB_INDEX_UNIQUE, ['linkhash']);
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        upgrade_plugin_savepoint(true, 2025100207, 'tiny', 'teamsmeeting');
    }

    return true;
}
