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
 * Tiny Teams Meeting edit meeting web service function.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tiny_teamsmeeting;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');

use external_api;
use external_function_parameters;
use external_single_structure;
use external_value;
use moodle_url;

/**
 * Get existing meeting from database.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class edit_meeting_api extends external_api {

    /**
     * Returns description of method parameters.
     *
     * @return external_function_parameters
     */
    public static function edit_meeting_parameters() {
        return new external_function_parameters([
                'url' => new external_value(PARAM_URL, 'URL link', VALUE_REQUIRED),
        ]);
    }

    /**
     * Returns url whether the operation was successful.
     *
     * @param string $url
     * @return array
     */
    public static function edit_meeting($url) {
        $record = self::get_meeting($url);
        $url = self::get_meeting_url($record);

        if ($record == null) {
            return [
                    'status' => false,
                    'url' => $url
            ];
        }

        return [
                'status' => true,
                'url' => $url
        ];
    }

    /**
     * Retrieve a meeting record from the database based on the URL.
     *
     * @param string $url The URL of the meeting.
     * @return mixed|null The meeting record if found, or null if not found.
     */
    private static function get_meeting($url) {
        global $DB;
        $sql = 'SELECT *
                  FROM {tiny_teamsmeeting}
                 WHERE ' . $DB->sql_compare_text('link') . ' = ' . $DB->sql_compare_text(':url') . ' ORDER BY id ASC';
        $records = $DB->get_records_sql($sql, ['url' => $url]);

        $count = count($records);
        if ($count == 0) {
            return null;
        }

        $result = reset($records);
        if ($count > 1) {
            array_shift($records);
            $ids = [];
            foreach ($records as $record) {
                $ids[] = $record->id;
            }
            $DB->delete_records_list('tiny_teamsmeeting', 'id', $ids);
        }

        return $result;
    }

    /**
     * Returns the URL for a meeting record.
     *
     * @param object $record The meeting record object.
     * @return string The URL link for the meeting.
     */
    private static function get_meeting_url($record) {
        if ($record == null) {
            return (new moodle_url('/lib/editor/tiny/plugins/teamsmeeting/error.php'))->out();
        }

        return (new moodle_url('/lib/editor/tiny/plugins/teamsmeeting/result.php', [
                'title' => $record->title, 'link' => $record->link, 'options' => $record->options]))->out();
    }

    /**
     * Returns description of method result value.
     *
     * @return external_single_structure
     */
    public static function edit_meeting_returns() {
        return new external_single_structure(
                [
                        'status' => new external_value(PARAM_BOOL, 'Status of the operation'),
                        'url' => new external_value(PARAM_URL, 'URL link')
                ]
        );
    }
}
