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
namespace tiny_teamsmeeting;

defined('MOODLE_INTERNAL') || die();

use external_api;
use external_function_parameters;
use external_value;

/**
 * Get existing meeting from database.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class edit_meeting_api extends external_api {

    public static function edit_meeting_parameters() {
        return new external_function_parameters([
            'url' => new external_value(PARAM_URL, 'URL link', true),
        ]);
    }

    public static function edit_meeting($url) {
        global $DB, $CFG;

        $record = $DB->get_record_sql('SELECT * FROM {tiny_teamsmeeting} WHERE ' . $DB->sql_compare_text('link') . ' = ' . $DB->sql_compare_text(':url'), array('url' => $url), IGNORE_MISSING);
        $result = $CFG->wwwroot.'/lib/editor/tiny/plugins/teamsmeeting/result.php?title=' . urlencode($record->title) . '&link=' . urlencode($record->link) . '&options=' . urlencode($record->options);

        return $result;
    }

    public static function edit_meeting_returns() {
        return new external_value(PARAM_URL, 'Returns url whether the operation was successful');
    }
}