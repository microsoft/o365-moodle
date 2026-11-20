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
 * Helper to find and remember the OneNote notebook that is used for Moodle in a user's OneNote account.
 *
 * @package local_onenote
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_onenote;

use dml_exception;
use stdClass;

/**
 * Helper to find and remember the OneNote notebook that is used for Moodle in a user's OneNote account.
 *
 * The notebook is identified by its OneNote id, which is stored the first time the notebook is found or created. The title of the
 * notebook is only used to create the notebook, and to find notebooks that were created before the id was stored. The title
 * depends on the language of the user and can be changed by the user in OneNote, so it must not be relied on after that.
 */
class notebook {
    /** The database table that stores the notebook id of each user. */
    const TABLE = 'local_onenote_user_notebooks';

    /**
     * Get the title to give to a new notebook.
     *
     * This is the title configured by the administrator, or the title in the language of the current user if none is configured.
     *
     * @return string The title.
     */
    public static function get_creation_title(): string {
        $title = trim((string) get_config('local_onenote', 'notebookname'));
        if ($title === '') {
            $title = get_string('notebookname', 'local_onenote');
        }

        return $title;
    }

    /**
     * Get all the titles that a notebook created for Moodle could have, in order of preference.
     *
     * Before the notebook id was stored, notebooks were found by a title that depended on the language of the user, so the title
     * in every installed language is a candidate, in addition to the configured title and the English title.
     *
     * @return string[] The unique, non-empty titles.
     */
    public static function get_candidate_titles(): array {
        $stringmanager = get_string_manager();

        $titles = [trim((string) get_config('local_onenote', 'notebookname'))];
        $titles[] = get_string('notebookname', 'local_onenote');
        foreach (array_keys($stringmanager->get_list_of_translations()) as $lang) {
            $titles[] = $stringmanager->get_string('notebookname', 'local_onenote', null, $lang);
        }
        $titles[] = $stringmanager->get_string('notebookname', 'local_onenote', null, 'en');

        $titles = array_map('trim', $titles);

        return array_values(array_unique(array_filter($titles, fn($title) => $title !== '')));
    }

    /**
     * Get the stored id of the OneNote notebook used for Moodle by a user.
     *
     * @param int $userid The id of the Moodle user.
     * @return string|null The OneNote notebook id, or null if none is stored.
     */
    public static function get_stored_id(int $userid): ?string {
        global $DB;

        $record = $DB->get_record(self::TABLE, ['userid' => $userid], 'id, notebookid');

        return $record ? (string) $record->notebookid : null;
    }

    /**
     * Store the id of the OneNote notebook used for Moodle by a user, replacing any previous one.
     *
     * @param int $userid The id of the Moodle user.
     * @param string $notebookid The OneNote notebook id.
     */
    public static function store_id(int $userid, string $notebookid): void {
        global $DB;

        $now = time();
        $record = $DB->get_record(self::TABLE, ['userid' => $userid]);

        if (!$record) {
            $record = new stdClass();
            $record->userid = $userid;
            $record->notebookid = $notebookid;
            $record->timecreated = $now;
            $record->timemodified = $now;
            try {
                $DB->insert_record(self::TABLE, $record);
                return;
            } catch (dml_exception $e) {
                // The record was created by a concurrent request, so update that one.
                $record = $DB->get_record(self::TABLE, ['userid' => $userid]);
                if (!$record) {
                    throw $e;
                }
            }
        }

        if ((string) $record->notebookid !== $notebookid) {
            $record->notebookid = $notebookid;
            $record->timemodified = $now;
            $DB->update_record(self::TABLE, $record);
        }
    }

    /**
     * Forget the stored OneNote notebook id of a user.
     *
     * @param int $userid The id of the Moodle user.
     */
    public static function delete_stored_id(int $userid): void {
        global $DB;

        $DB->delete_records(self::TABLE, ['userid' => $userid]);
    }

    /**
     * Find the OneNote notebook used for Moodle in the list of notebooks of a user.
     *
     * The notebook with the stored id is used if it is in the list. Otherwise the notebook is found by one of the candidate
     * titles, and its id is stored so it is found by id from then on.
     *
     * @param array[] $notebooks The notebooks in the OneNote account of the user, each with at least an 'id' and a 'title'.
     * @param int $userid The id of the Moodle user.
     * @return array|null The notebook, or null if it was not found.
     */
    public static function resolve(array $notebooks, int $userid): ?array {
        $storedid = self::get_stored_id($userid);
        if ($storedid !== null) {
            foreach ($notebooks as $notebook) {
                if (isset($notebook['id']) && (string) $notebook['id'] === $storedid) {
                    return $notebook;
                }
            }
        }

        foreach (self::get_candidate_titles() as $title) {
            foreach ($notebooks as $notebook) {
                if (isset($notebook['id'], $notebook['title']) && $notebook['title'] === $title) {
                    self::store_id($userid, (string) $notebook['id']);
                    return $notebook;
                }
            }
        }

        return null;
    }
}
