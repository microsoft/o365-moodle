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
 * Scheduled task to automatically enable calendar sync for connected users.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\task;

use core\task\scheduled_task;
use local_o365\feature\calsync\autosubscribe;
use local_o365\rest\unified;
use local_o365\utils;

/**
 * Scheduled task to enable calendar sync and subscribe to course calendars for users connected to Microsoft 365.
 *
 * Only does anything when the site is set to subscribe users automatically (opt-out). Each user is processed once.
 */
class calsyncautosubscribe extends scheduled_task {
    /** @var int Maximum number of users to process in one run. */
    protected const BATCH_SIZE = 200;

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_calsyncautosubscribe', 'local_o365');
    }

    /**
     * Do the job.
     *
     * @return bool
     */
    public function execute() {
        global $DB;

        if (!autosubscribe::is_optout_mode()) {
            utils::mtrace('Calendar sync subscription is set to opt-in, nothing to do.', 1);
            return true;
        }

        if (utils::is_connected() !== true) {
            utils::mtrace('Microsoft 365 integration is not configured, nothing to do.', 1);
            return true;
        }

        $sql = "SELECT u.id, u.username, u.firstname, u.lastname
                  FROM {user} u
                 WHERE u.deleted = 0
                   AND u.suspended = 0
                   AND EXISTS (SELECT 1
                                 FROM {auth_oidc_token} t
                                WHERE t.userid = u.id AND t.tokenresource = :tokenresource)
                   AND NOT EXISTS (SELECT 1
                                     FROM {user_preferences} p
                                    WHERE p.userid = u.id AND p.name = :prefname)
              ORDER BY u.id";
        $params = [
            'tokenresource' => unified::get_tokenresource(),
            'prefname' => autosubscribe::PREF_INITIALISED,
        ];

        $count = 0;
        $users = $DB->get_recordset_sql($sql, $params, 0, self::BATCH_SIZE);
        foreach ($users as $user) {
            $subscribed = autosubscribe::initialise_user((int)$user->id);
            if ($subscribed !== null) {
                $count++;
                utils::mtrace(
                    "Enabled calendar sync for user #{$user->id} ({$user->username}, {$user->firstname} {$user->lastname}), " .
                        "subscribed to $subscribed calendar(s).",
                    1
                );
            }
        }
        $users->close();

        utils::mtrace("Enabled calendar sync for $count user(s).", 1);

        return true;
    }
}
