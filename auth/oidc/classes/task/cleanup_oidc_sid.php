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
 * A scheduled task to clean up oidc sid records.
 *
 * @package auth_oidc
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2021 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc\task;

use core\session\manager;
use core\task\scheduled_task;

/**
 * A scheduled task that cleans up OIDC SID records.
 */
class cleanup_oidc_sid extends scheduled_task {
    /**
     * Get a descriptive name for the task.
     */
    public function get_name() {
        return get_string('task_cleanup_oidc_sid', 'auth_oidc');
    }

    /**
     * Clean up OIDC SID records.
     *
     * A mapping is only removed once its Moodle session no longer exists, rather than after a fixed
     * time period, so that SSO logout keeps working for sessions that outlive that fixed period.
     */
    public function execute() {
        global $DB;

        // Legacy mappings with no recorded session id (created before sessionid was tracked) can never
        // be confirmed to have a live session, so delete them directly without a session_exists() check.
        $DB->delete_records_select('auth_oidc_sid', 'sessionid IS NULL OR sessionid = ?', ['']);

        // Fetch only the columns needed to decide what to keep, all into memory up front: issuing
        // further queries (session_exists, delete_records) while an unbuffered recordset cursor is open
        // can trigger "commands out of sync" errors on some DB drivers.
        $records = $DB->get_records('auth_oidc_sid', null, '', 'id, sessionid');

        $staleids = [];
        foreach ($records as $record) {
            if (!manager::session_exists($record->sessionid)) {
                $staleids[] = $record->id;
            }
        }

        // Delete in chunks to avoid hitting parameter/query-length limits on some DB drivers if a large
        // number of mappings have accumulated between cleanup runs.
        foreach (array_chunk($staleids, 1000) as $chunk) {
            $DB->delete_records_list('auth_oidc_sid', 'id', $chunk);
        }
    }
}
