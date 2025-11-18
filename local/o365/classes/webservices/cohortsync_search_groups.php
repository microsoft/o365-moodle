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
 * Search Microsoft 365 groups for cohort sync using existing functions.
 *
 * @package local_o365
 * @subpackage webservices
 * @copyright   Enovation Solutions Ltd. {@link https://enovation.ie}
 * @author      Patryk Mroczko <patryk.mroczko@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_o365\webservices;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/externallib.php');

class cohortsync_search_groups extends \external_api {

    /**
     * Parameters for search_groups.
     *
     * @return \external_function_parameters
     */
    public static function search_groups_parameters() {
        return new \external_function_parameters([
                'query' => new \external_value(PARAM_TEXT, 'Search query', VALUE_REQUIRED),
        ]);
    }

    /**
     * Search Microsoft 365 groups using existing cache functions.
     *
     * @param string $query The search query.
     * @return array Groups matching the query, excluding already mapped ones.
     */
    public static function search_groups($query) {
        global $DB;

        $params = self::validate_parameters(self::search_groups_parameters(), ['query' => $query]);

        self::validate_context(\context_system::instance());
        require_capability('moodle/site:config', \context_system::instance());

        $apiclient = \local_o365\feature\cohortsync\main::get_unified_api(__METHOD__);
        if (empty($apiclient)) {
            throw new \moodle_exception('cohortsync_unifiedapierror', 'local_o365');
        }
        $cohortsyncmain = new \local_o365\feature\cohortsync\main($apiclient);
        $cohortsyncmain->fetch_groups_from_cache();
        $allgroups = $cohortsyncmain->get_grouplist();

        // Get mapped to exclude
        $mappedgroupoids = [];
        $mappings = $DB->get_records('local_o365_objects', ['type' => 'group', 'subtype' => 'cohort'], '', 'objectid');
        foreach ($mappings as $mapping) {
            $mappedgroupoids[] = $mapping->objectid;
        }

        // Filter in PHP
        $result = [];
        foreach ($allgroups as $group) {
            if (!in_array($group['id'], $mappedgroupoids) && stripos($group['displayName'], $params['query']) !== false) {
                $result[] = [
                        'id' => $group['id'],
                        'displayName' => $group['displayName'],
                ];
            }
        }

        usort($result, function($a, $b) {
            return strcasecmp($a['displayName'], $b['displayName']);
        });
        $result = array_slice($result, 0, 30);

        return $result;
    }

    /**
     * Returns for search_groups.
     *
     * @return \external_description
     */
    public static function search_groups_returns() {
        return new \external_multiple_structure(
                new \external_single_structure([
                        'id' => new \external_value(PARAM_TEXT, 'Group ID'),
                        'displayName' => new \external_value(PARAM_TEXT, 'Group display name'),
                ])
        );
    }
}