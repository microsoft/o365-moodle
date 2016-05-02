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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\usergroups;

class utils {
    /**
     * Determine whether course usergroups are enabled or not.
     *
     * @return bool True if group creation is enabled. False otherwise.
     */
    public static function is_enabled() {
        $creategroups = get_config('local_o365', 'creategroups');
        return ($creategroups === 'oncustom' || $creategroups === 'onall') ? true : false;
    }

    /**
     * Get an array of enabled courses.
     *
     * @return array Array of course IDs, or TRUE if all courses enabled.
     */
    public static function get_enabled_courses() {
        $creategroups = get_config('local_o365', 'creategroups');
        if ($creategroups === 'onall') {
            return true;
        } else if ($creategroups === 'oncustom') {
            $coursesenabled = get_config('local_o365', 'usergroupcustom');
            $coursesenabled = @json_decode($coursesenabled, true);
            if (!empty($coursesenabled) && is_array($coursesenabled)) {
                return array_keys($coursesenabled);
            }
        }
        return [];
    }

    /**
     * Determine whether a course is group-enabled.
     *
     * @param int $courseid The Moodle course ID to check.
     * @return bool Whether the course is group enabled or not.
     */
    public static function course_is_group_enabled($courseid) {
        $creategroups = get_config('local_o365', 'creategroups');
        if ($creategroups === 'onall') {
            return true;
        } else if ($creategroups === 'oncustom') {
            $coursesenabled = get_config('local_o365', 'usergroupcustom');
            $coursesenabled = @json_decode($coursesenabled, true);
            if (!empty($coursesenabled) && is_array($coursesenabled) && isset($coursesenabled[$courseid])) {
                return true;
            }
        }
        return false;
    }
}
