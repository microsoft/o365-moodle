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

namespace atto_teamsmeeting\task;

/**
 * Scheduled task that deletes stored meetings older than the configured retention period.
 *
 * @package    atto_teamsmeeting
 * @copyright  2020 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class purge_old_meetings extends \core\task\scheduled_task {
    /**
     * Return the task name shown in the admin interface.
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_purge_old_meetings', 'atto_teamsmeeting');
    }

    /**
     * Delete stored meeting records whose creation time is older than the retention period.
     *
     * A retention of 0 keeps records indefinitely.
     */
    public function execute() {
        global $DB;

        $retentiondays = (int) get_config('atto_teamsmeeting', 'meetingdataretention');
        if ($retentiondays <= 0) {
            return;
        }

        $cutoff = time() - ($retentiondays * DAYSECS);
        $count = $DB->count_records_select('atto_teamsmeeting', 'timecreated < :cutoff', ['cutoff' => $cutoff]);
        if ($count) {
            $DB->delete_records_select('atto_teamsmeeting', 'timecreated < :cutoff', ['cutoff' => $cutoff]);
            mtrace("atto_teamsmeeting: deleted {$count} meeting record(s) older than {$retentiondays} days.");
        }
    }
}
