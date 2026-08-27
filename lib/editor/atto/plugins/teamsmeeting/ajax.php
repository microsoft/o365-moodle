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
 * Gets data from DB about the meeting.
 *
 * @package    atto_teamsmeeting
 * @copyright  2020 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../../../config.php');

require_login();

$url = required_param('url', PARAM_URL);
$result = '';
if (!empty($url)) {
    $record = atto_teamsmeeting_get_meeting($url);
    $result = atto_teamsmeeting_meeting_url($record);
}

echo $result;
die();

/**
 * Gets data from the database about the meeting.
 *
 * @param string $url The URL of the meeting.
 * @return stdClass|null The meeting data or null if meeting not found.
 */
function atto_teamsmeeting_get_meeting($url) {
    global $DB;

    // The link column is a TEXT field, so a plain equality condition is rejected by the DB
    // layer (textconditionsnotallowed). Compare over the full link length via sql_compare_text()
    // rather than its 32-char default: Teams meeting links all share a long common prefix, so a
    // truncated comparison would match unrelated meetings (and previously deleted them as
    // "duplicates").
    $comparelength = core_text::strlen($url);
    $select = $DB->sql_compare_text('link', $comparelength) . ' = ' . $DB->sql_compare_text(':url', $comparelength);
    $records = $DB->get_records_select('atto_teamsmeeting', $select, ['url' => $url], 'id ASC', '*', 0, 1);

    if (!$records) {
        return null;
    }

    return reset($records);
}

/**
 * Gets the meeting URL from the given record.
 *
 * @param object|null $record The record containing meeting data.
 * @return string Returns the JSON-encoded meeting URL and related data.
 */
function atto_teamsmeeting_meeting_url($record) {
    if (is_null($record)) {
        return json_encode([(new moodle_url('/lib/editor/atto/plugins/teamsmeeting/error.php'))->out(), '', '', '']);
    }

    return json_encode([(new moodle_url('/lib/editor/atto/plugins/teamsmeeting/result.php'))->out(), $record->title, $record->link,
            $record->options]);
}
