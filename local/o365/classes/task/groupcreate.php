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

namespace local_o365\task;

/**
 * Create any needed groups in Microsoft 365.
 */
class groupcreate extends \core\task\scheduled_task {
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('task_groupcreate', 'local_o365');
    }

    /**
     * Do the job.
     */
    public function execute() {
        global $DB;

        if (\local_o365\utils::is_configured() !== true) {
            return false;
        }

        if (\local_o365\feature\usergroups\utils::is_enabled() !== true) {
            mtrace('Groups not enabled, skipping...');
            return true;
        }

        $httpclient = new \local_o365\httpclient();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();

        $unifiedresource = \local_o365\rest\unified::get_resource();
        $unifiedtoken = \local_o365\utils::get_app_or_system_token($unifiedresource, $clientdata, $httpclient);
        if (empty($unifiedtoken)) {
            mtrace('Could not get graph API token.');
            return true;
        }
        $graphclient = new \local_o365\rest\unified($unifiedtoken, $httpclient);

        $coursegroups = new \local_o365\feature\usergroups\coursegroups($graphclient, $DB, true);
        $coursegroups->create_groups_for_new_courses();
        $coursegroups->sync_group_profile_photo();
        $coursegroups->update_teams_cache();
    }
}
