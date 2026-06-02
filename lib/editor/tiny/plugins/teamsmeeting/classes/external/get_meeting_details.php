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
 * tiny_teamsmeeting get meeting details web service function.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2025 Enovation Solutions
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tiny_teamsmeeting\external;

use context;
use context_system;
use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;
use moodle_exception;
use moodle_url;
use required_capability_exception;
use stdClass;

/**
 * Get existing meeting details from database.
 *
 * @package     tiny_teamsmeeting
 */
class get_meeting_details extends external_api {
    /**
     * Web service function parameter definition for get_meeting_details function.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'url' => new external_value(PARAM_URL, 'Link to the Teams meeting', VALUE_REQUIRED),
        ]);
    }

    /**
     * Get meeting details from database by url.
     *
     * @param string $url
     * @return array
     * @throws moodle_exception
     * @throws required_capability_exception
     */
    public static function execute(string $url): array {
        global $USER;

        $params = self::validate_parameters(self::execute_parameters(), ['url' => $url]);

        self::validate_context(context_system::instance());

        $record = self::get_meeting($params['url']);
        if (!$record) {
            return [
                'status' => false,
                'url' => (new moodle_url('/lib/editor/tiny/plugins/teamsmeeting/error.php'))->out(),
            ];
        }

        $context = !empty($record->contextid)
            ? context::instance_by_id($record->contextid)
            : context_system::instance();
        require_capability('tiny/teamsmeeting:add', $context);

        if ((int) $record->userid !== (int) $USER->id) {
            throw new moodle_exception('nopermissions', 'error', '', get_string('pluginname', 'tiny_teamsmeeting'));
        }

        $resulturl = new moodle_url('/lib/editor/tiny/plugins/teamsmeeting/result.php', [
            'title' => $record->title,
            'link' => $record->link,
            'options' => $record->options,
            'viewexisting' => 1,
            'sesskey' => sesskey(),
        ]);
        return [
            'status' => true,
            'url' => $resulturl->out(),
        ];
    }

    /**
     * Find the existing meeting record in the database for the given URL.
     *
     * The lookup uses the indexed linkhash column (SHA1 of the URL) rather than
     * a full TEXT comparison so it benefits from the unique index. Duplicates are
     * prevented at insert time, so at most one row will match.
     *
     * @param string $url
     * @return stdClass|null
     */
    private static function get_meeting(string $url): ?stdClass {
        global $DB;

        $record = $DB->get_record('tiny_teamsmeeting', ['linkhash' => sha1($url)]);
        return $record ?: null;
    }

    /**
     * Return value definition of get_meeting_details function.
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return new external_single_structure(
            [
                'status' => new external_value(PARAM_BOOL, 'Status of the operation'),
                'url' => new external_value(PARAM_URL, 'URL link'),
            ]
        );
    }
}
