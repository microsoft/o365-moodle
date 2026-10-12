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
use tiny_teamsmeeting\token;

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
            'newwindow' => new external_value(PARAM_BOOL, 'Whether the link opens in a new window', VALUE_DEFAULT, false),
        ]);
    }

    /**
     * Get meeting details from database by url.
     *
     * @param string $url
     * @param bool $newwindow Whether the selected link currently opens in a new window.
     * @return array
     * @throws moodle_exception
     * @throws required_capability_exception
     */
    public static function execute(string $url, bool $newwindow = false): array {
        $params = self::validate_parameters(self::execute_parameters(), ['url' => $url, 'newwindow' => $newwindow]);

        self::validate_context(context_system::instance());

        $record = self::get_meeting($params['url']);
        if (!$record) {
            return [
                'status' => false,
                // Unescaped: the caller loads this straight into an iframe src,
                // so ampersands must stay raw, not be HTML-escaped to &amp;.
                'url' => (new moodle_url('/lib/editor/tiny/plugins/teamsmeeting/error.php'))->out(false),
            ];
        }

        // Access is gated on holding the capability in the meeting's context,
        // not on being the original creator: content containing a meeting link
        // is routinely edited by more than one teacher, and every editor with
        // the capability must be able to load its details.
        $context = null;
        if (!empty($record->contextid)) {
            // The course the meeting was created in may since have been deleted.
            $context = context::instance_by_id($record->contextid, IGNORE_MISSING) ?: null;
        }
        if (!$context) {
            $context = context_system::instance();
        }
        require_capability('tiny/teamsmeeting:add', $context);

        // The result.php page runs without a session and authenticates from this token.
        $resulturl = new moodle_url('/lib/editor/tiny/plugins/teamsmeeting/result.php', [
            'title' => $record->title,
            'link' => $record->link,
            'options' => $record->options,
            'viewexisting' => 1,
            'newwindow' => $params['newwindow'] ? 1 : 0,
            'session' => token::generate(self::resolve_language($context)),
        ]);
        return [
            'status' => true,
            // Unescaped: the caller loads this straight into an iframe src, so
            // the query separators must stay as raw '&', not HTML-escaped '&amp;'
            // (otherwise 'session' arrives as 'amp;session' and the token check
            // in result.php fails with 'invalidtoken').
            'url' => $resulturl->out(false),
        ];
    }

    /**
     * Resolve the effective language for the meeting's own context.
     *
     * execute() runs inside Moodle's generic AJAX dispatcher
     * (lib/ajax/service.php), which never points $PAGE->course/$COURSE at the
     * course the meeting actually lives in - it stays the frontpage course for
     * the whole request. That leaves current_language() structurally unable
     * to see a course-forced language here, even though the session/profile
     * language it falls back to is otherwise correct for this user. Replicate
     * current_language()'s priority, but resolve the course-forced check
     * against the meeting's own context instead of the ambient $PAGE->course.
     *
     * Meetings are only ever created in a course or system context (see
     * result.php), never a module context, so activity-forced language
     * ($PAGE->cm->lang) has no equivalent to check here.
     *
     * @param context $context The context the meeting was created in.
     * @return string The resolved language code.
     */
    private static function resolve_language(context $context): string {
        global $SESSION, $USER, $CFG, $DB;

        if (!empty($SESSION->forcelang)) {
            return $SESSION->forcelang;
        }

        $coursecontext = $context->get_course_context(false);
        if ($coursecontext && $coursecontext->instanceid != SITEID) {
            $courselang = $DB->get_field('course', 'lang', ['id' => $coursecontext->instanceid]);
            if (!empty($courselang)) {
                return $courselang;
            }
        }

        if (!empty($SESSION->lang)) {
            return $SESSION->lang;
        }
        if (!empty($USER->lang)) {
            return $USER->lang;
        }

        return $CFG->lang ?? 'en';
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

        // Normalise percent-encoding to uppercase before hashing so lookups
        // succeed whether or not Moodle re-saved the HTML (which uppercases %xx).
        $normalised = preg_replace_callback('/%[0-9a-f]{2}/i', fn($m) => strtoupper($m[0]), $url);
        $record = $DB->get_record('tiny_teamsmeeting', ['linkhash' => sha1($normalised)]);

        if (!$record) {
            // Fallback for rows created before normalisation: try lowercase hex digits.
            $lowercased = preg_replace_callback('/%[0-9A-F]{2}/', fn($m) => strtolower($m[0]), $normalised);
            if ($lowercased !== $normalised) {
                $record = $DB->get_record('tiny_teamsmeeting', ['linkhash' => sha1($lowercased)]);
            }
        }

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
