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
    global $CFG, $DB;

    $dbman = $DB->get_manager();

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

    if ($oldversion < 2026042000.01) {
        // Recompute linkhash using percent-encoding-normalised URLs so that
        // hashes are stable regardless of whether Moodle has uppercased %xx
        // sequences when saving HTML content (RFC 3986 normalisation).
        $records = $DB->get_records('tiny_teamsmeeting', null, 'id ASC', 'id, link');
        foreach ($records as $record) {
            $normalised = preg_replace_callback('/%[0-9a-f]{2}/i', fn($m) => strtoupper($m[0]), $record->link);
            $DB->set_field('tiny_teamsmeeting', 'linkhash', sha1($normalised), ['id' => $record->id]);
            $DB->set_field('tiny_teamsmeeting', 'link', $normalised, ['id' => $record->id]);
        }
        unset($records);

        upgrade_plugin_savepoint(true, 2026042000.01, 'tiny', 'teamsmeeting');
    }

    if ($oldversion < 2026042000.02) {
        $table = new xmldb_table('tiny_teamsmeeting');
        $columns = $DB->get_columns('tiny_teamsmeeting', false);

        // The 2025100207 step added linkhash as a nullable column. Bring such
        // databases in line with install.xml by making it NOT NULL. The column
        // cannot be altered in place while its unique index exists, so the
        // index is dropped and recreated around the change.
        if (!empty($columns['linkhash']) && empty($columns['linkhash']->not_null)) {
            $missing = $DB->get_records_select('tiny_teamsmeeting', 'linkhash IS NULL', null, 'id ASC', 'id, link');
            foreach ($missing as $record) {
                $normalised = preg_replace_callback('/%[0-9a-f]{2}/i', fn($m) => strtoupper($m[0]), (string) $record->link);
                $DB->set_field('tiny_teamsmeeting', 'linkhash', sha1($normalised), ['id' => $record->id]);
            }
            unset($missing);

            $index = new xmldb_index('linkhash', XMLDB_INDEX_UNIQUE, ['linkhash']);
            if ($dbman->index_exists($table, $index)) {
                $dbman->drop_index($table, $index);
            }

            $field = new xmldb_field('linkhash', XMLDB_TYPE_CHAR, '40', null, XMLDB_NOTNULL, null, null, 'link');
            $dbman->change_field_notnull($table, $field);

            $dbman->add_index($table, $index);
        }

        upgrade_plugin_savepoint(true, 2026042000.02, 'tiny', 'teamsmeeting');
    }

    if ($oldversion < 2026042001.01) {
        // Add the userid and contextid columns (plus their keys and indexes) if
        // they are missing, detected directly rather than via a version-number
        // savepoint. This step used to be keyed to savepoint 2025100205, but
        // that number was also used by the standalone plugin's own 1.x releases
        // (up to v1.6) for an unrelated upgrade step, so sites coming from that
        // line already had 2025100205 recorded and silently skipped the column
        // addition, even though the upgrade reported success.
        $table = new xmldb_table('tiny_teamsmeeting');
        $columns = $DB->get_columns('tiny_teamsmeeting', false);

        // Repair is needed whenever a column is missing entirely, or exists
        // but was left nullable by an earlier run of this step that added
        // the column but was interrupted before enforcing NOT NULL below
        // (the savepoint is only recorded once the whole step completes, so
        // such a site would retry this step, but field_exists() alone
        // wouldn't catch that half-finished state).
        $useridmissing = empty($columns['userid']);
        $useridneedsrepair = $useridmissing || empty($columns['userid']->not_null);

        $contextidmissing = empty($columns['contextid']);
        $contextidneedsrepair = $contextidmissing || empty($columns['contextid']->not_null);

        // Add whichever column(s) are missing, nullable first (matching
        // install.xml's field definitions, which have no default) so the
        // ALTER succeeds on non-empty tables, then backfill and tighten to
        // NOT NULL below.
        if ($useridmissing) {
            $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'id');
            $dbman->add_field($table, $field);
        }
        if ($contextidmissing) {
            $field = new xmldb_field('contextid', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'userid');
            $dbman->add_field($table, $field);
        }

        // Existing rows predate userid/contextid being tracked at all, so
        // there is no real value to recover. Point them at the guest user
        // and the system context, which always exist, rather than at a
        // fabricated id (e.g. 0) that references nothing.
        if ($useridneedsrepair) {
            $DB->execute('UPDATE {tiny_teamsmeeting} SET userid = ? WHERE userid IS NULL', [$CFG->siteguest]);
            $field = new xmldb_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null, 'id');
            $dbman->change_field_notnull($table, $field);
        }
        if ($contextidneedsrepair) {
            $DB->execute('UPDATE {tiny_teamsmeeting} SET contextid = ? WHERE contextid IS NULL', [\context_system::instance()->id]);
            $field = new xmldb_field('contextid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null, 'userid');
            $dbman->change_field_notnull($table, $field);
        }

        if ($useridneedsrepair) {
            $key = new xmldb_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);
            $dbman->add_key($table, $key);
        }
        if ($contextidneedsrepair) {
            $key = new xmldb_key('contextid', XMLDB_KEY_FOREIGN, ['contextid'], 'context', ['id']);
            $dbman->add_key($table, $key);
        }

        // Indexes are checked for existence directly, so these run whenever
        // needed regardless of which column(s) above were already present.
        $index = new xmldb_index('userid', XMLDB_INDEX_NOTUNIQUE, ['userid']);
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        $index = new xmldb_index('contextid', XMLDB_INDEX_NOTUNIQUE, ['contextid']);
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        upgrade_plugin_savepoint(true, 2026042001.01, 'tiny', 'teamsmeeting');
    }

    return true;
}
