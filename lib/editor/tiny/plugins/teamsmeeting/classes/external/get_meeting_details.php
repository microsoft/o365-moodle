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

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;
use moodle_url;
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
     */
    public static function execute(string $url): array {
        $params = self::validate_parameters(self::execute_parameters(), ['url' => $url]);

        $record = self::get_meeting($params['url']);
        if (!$record) {
            return [
                'status' => false,
                'url' => (new moodle_url('/lib/editor/tiny/plugins/teamsmeeting/error.php'))->out(),
            ];
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
     * Find existing meeting in database by url.
     *
     * @param string $url
     * @return stdClass|null
     */
    private static function get_meeting(string $url): ?stdClass {
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
