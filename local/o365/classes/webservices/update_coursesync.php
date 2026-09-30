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
 * Enable or disable Teams sync for one or more courses.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\webservices;

use core\context\system;
use local_o365\feature\coursesync\utils as coursesyncutils;
use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_multiple_structure;
use core_external\external_single_structure;
use core_external\external_value;
use core_external\external_warnings;

/**
 * Enable or disable Teams sync for one or more courses.
 */
class update_coursesync extends external_api {
    /**
     * Returns description of method parameters.
     *
     * @return external_function_parameters
     */
    public static function coursesync_update_parameters(): external_function_parameters {
        return new external_function_parameters(
            [
                'courses' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'id' => new external_value(PARAM_INT, 'The Moodle course ID.'),
                            'sync' => new external_value(
                                PARAM_BOOL,
                                'Whether Teams sync should be enabled (true) or disabled (false) for the course.'
                            ),
                        ]
                    ),
                    'Courses to enable or disable Teams sync for.'
                ),
            ]
        );
    }

    /**
     * Enable or disable Teams sync for the given courses.
     *
     * @param array $courses Array of ['id' => int, 'sync' => bool] entries.
     * @return array
     */
    public static function coursesync_update($courses) {
        global $DB;

        $params = self::validate_parameters(self::coursesync_update_parameters(), ['courses' => $courses]);

        $context = system::instance();
        self::validate_context($context);
        require_capability('local/o365:managecoursesync', $context);

        $data = [];
        $warnings = [];

        $coursesyncmode = get_config('local_o365', 'coursesync');

        if ($coursesyncmode !== 'oncustom' && $coursesyncmode !== 'onall') {
            foreach ($params['courses'] as $course) {
                $warnings[] = [
                    'item' => 'course',
                    'itemid' => $course['id'],
                    'warningcode' => 'coursesyncdisabled',
                    'message' => 'Course sync to Microsoft 365 Groups / Teams is not enabled on this site.',
                ];
            }

            return ['data' => $data, 'warnings' => $warnings];
        }

        foreach ($params['courses'] as $course) {
            $courseid = $course['id'];

            if ($courseid == SITEID || !$DB->record_exists('course', ['id' => $courseid])) {
                $warnings[] = [
                    'item' => 'course',
                    'itemid' => $courseid,
                    'warningcode' => 'coursenotfound',
                    'message' => 'The course with the given ID could not be found.',
                ];
                continue;
            }

            if ($coursesyncmode === 'onall') {
                $warnings[] = [
                    'item' => 'course',
                    'itemid' => $courseid,
                    'warningcode' => 'coursesyncmodeonall',
                    'message' => 'Course sync is set to "All Features Enabled" for the whole site, so sync cannot be ' .
                        'enabled or disabled for individual courses. This course remains synced regardless of the ' .
                        'requested value.',
                ];
                continue;
            }

            coursesyncutils::set_course_sync_enabled($courseid, $course['sync']);

            $data[] = [
                'id' => $courseid,
                'sync' => coursesyncutils::is_course_sync_enabled($courseid),
            ];
        }

        return ['data' => $data, 'warnings' => $warnings];
    }

    /**
     * Returns description of method result value.
     *
     * @return external_single_structure
     */
    public static function coursesync_update_returns(): external_single_structure {
        return new external_single_structure(
            [
                'data' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'id' => new external_value(PARAM_INT, 'The Moodle course ID.'),
                            'sync' => new external_value(
                                PARAM_BOOL,
                                'Whether Teams sync is now enabled (true) or disabled (false) for the course.'
                            ),
                        ]
                    )
                ),
                'warnings' => new external_warnings(),
            ]
        );
    }
}
