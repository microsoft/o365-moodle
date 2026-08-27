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
 * Internal library of functions for the Teams Meeting atto plugin.
 *
 * @package    atto_teamsmeeting
 * @copyright  2020 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Get the stored meeting record for the given meeting link.
 *
 * @param string $url The meeting link to look up.
 * @return stdClass|null The meeting record, or null when no meeting matches.
 */
function atto_teamsmeeting_get_meeting($url) {
    global $DB;

    // The link column is a TEXT field, so a plain equality condition is rejected by the DB
    // layer (textconditionsnotallowed). Compare over the full link length via sql_compare_text()
    // rather than its 32-char default: Teams meeting links all share a long common prefix, so a
    // truncated comparison would match unrelated meetings.
    $comparelength = core_text::strlen($url);
    $select = $DB->sql_compare_text('link', $comparelength) . ' = ' . $DB->sql_compare_text(':url', $comparelength);
    $records = $DB->get_records_select('atto_teamsmeeting', $select, ['url' => $url], 'id ASC', '*', 0, 1);

    if (!$records) {
        return null;
    }

    return reset($records);
}

/**
 * Build the JSON payload returned to the editor for a meeting record.
 *
 * @param stdClass|null $record The meeting record, or null when the meeting was not found.
 * @return string JSON: [result-page url, title, link, options].
 */
function atto_teamsmeeting_meeting_url($record) {
    if (is_null($record)) {
        return json_encode([(new moodle_url('/lib/editor/atto/plugins/teamsmeeting/error.php'))->out(), '', '', '']);
    }

    return json_encode([(new moodle_url('/lib/editor/atto/plugins/teamsmeeting/result.php'))->out(), $record->title,
        $record->link, $record->options]);
}

/**
 * Reduce a URL to one that is safe to store and render as a link target.
 *
 * Only well-formed absolute http(s) URLs are accepted; javascript:, data:,
 * vbscript: and protocol-relative URLs are rejected so they can never reach an
 * href attribute.
 *
 * @param string|null $url The candidate URL.
 * @return string|null The URL when it is a well-formed http(s) URL, otherwise null.
 */
function atto_teamsmeeting_safe_external_url(?string $url): ?string {
    if ($url === null || trim($url) === '') {
        return null;
    }
    $url = trim($url);
    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return null;
    }
    // The filter_var() check accepts javascript:// and data:// style URLs on its
    // own, so pin the scheme down explicitly.
    $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
    if ($scheme !== 'http' && $scheme !== 'https') {
        return null;
    }
    return $url;
}
