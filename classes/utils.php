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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365;

/**
 * General purpose utility class.
 */
class utils {
    /**
     * Determine if a user is connected to Office365.
     *
     * @param int $userid The user's ID.
     * @return bool Whether they are connected (true) or not (false).
     */
    public static function is_o365_connected($userid) {
        global $DB;
        try {
            if ($DB->record_exists('local_o365_token', ['user_id' => $userid])) {
                return true;
            } else {
                $sql = 'SELECT *
                          FROM {auth_oidc_token} tok
                          JOIN {user} u ON tok.username = u.username
                         WHERE tok.resource = ? AND u.id = ?
                         LIMIT 0, 1';
                $params = ['https://graph.windows.net', $userid];
                $records = $DB->get_records_sql($sql, $params);
                if (!empty($records)) {
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function tostring($val) {
        if (is_scalar($val)) {
            if (is_bool($val)) {
                return '(bool)'.(string)(int)$val;
            } else {
                return (string)$val;
            }
        } else {
            return print_r($val, true);
        }
    }

    /**
     * Record a debug message.
     *
     * @param string $message The debug message to log.
     */
    public static function debug($message, $where = '', $debugdata = null) {
        $debugmode = (bool)get_config('local_o365', 'debugmode');
        if ($debugmode === true) {
            $fullmessage = (!empty($where)) ? $where : 'Unknown function';
            $fullmessage .= ': '.$message;
            if (!empty($debugdata)) {
                $fullmessage .= ' Data: '.static::tostring($debugdata);
            }
            $event = \local_o365\event\api_call_failed::create(['other' => $fullmessage]);
            $event->trigger();
        }
    }
}