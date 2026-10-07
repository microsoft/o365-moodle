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
 * Search cached Teams for the team connection autocomplete field on the "Manage Team Connections" admin page.
 *
 * @package local_o365
 * @subpackage webservices
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_o365\webservices;

use core\context\system;
use core_text;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/externallib.php');

/**
 * Class coursesync_search_teams.
 *
 * @package local_o365\webservices
 */
class coursesync_search_teams extends \external_api {
    /**
     * Parameters for search_teams.
     *
     * @return \external_function_parameters
     */
    public static function search_teams_parameters() {
        return new \external_function_parameters([
            'query' => new \external_value(PARAM_TEXT, 'Search query', VALUE_REQUIRED),
            'courseid' => new \external_value(PARAM_INT, 'Course being connected to a Team', VALUE_REQUIRED),
            'offset' => new \external_value(PARAM_INT, 'Pagination offset', VALUE_DEFAULT, 0),
            'limit' => new \external_value(PARAM_INT, 'Maximum results per page', VALUE_DEFAULT, 20),
        ]);
    }

    /**
     * Search cached Teams-enabled groups using direct SQL with paging.
     *
     * Filtering, sorting, and paging are all performed in SQL so only the
     * requested page is transferred from the database.
     *
     * @param string $query The search query.
     * @param int $courseid The course being connected to a Team.
     * @param int $offset Pagination offset.
     * @param int $limit Maximum results per page.
     * @return array Results page and whether more exist.
     */
    public static function search_teams($query, $courseid, $offset = 0, $limit = 20) {
        global $DB;

        $params = self::validate_parameters(self::search_teams_parameters(), [
            'query' => $query,
            'courseid' => $courseid,
            'offset' => $offset,
            'limit' => $limit,
        ]);

        self::validate_context(system::instance());
        require_capability('moodle/site:config', system::instance());

        $query = trim($params['query']);
        $offset = max(0, $params['offset']);
        $limit = min(max(1, $params['limit']), 50);

        if (core_text::strlen($query) < 2) {
            return ['results' => [], 'hasmore' => false];
        }

        $currentoid = '';
        $groupobject = $DB->get_record(
            'local_o365_objects',
            ['type' => 'group', 'subtype' => 'course', 'moodleid' => $params['courseid']]
        );
        if ($groupobject) {
            $currentoid = $groupobject->objectid;
        }

        return \local_o365\feature\coursesync\utils::search_matching_teams($query, $currentoid, $offset, $limit);
    }

    /**
     * Returns for search_teams.
     *
     * @return \external_description
     */
    public static function search_teams_returns() {
        return new \external_single_structure([
            'results' => new \external_multiple_structure(
                new \external_single_structure([
                    'id' => new \external_value(PARAM_INT, 'Team cache record ID'),
                    'name' => new \external_value(PARAM_TEXT, 'Team display name'),
                ])
            ),
            'hasmore' => new \external_value(PARAM_BOOL, 'Whether more results exist beyond this page'),
        ]);
    }
}
