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
 * Search Moodle cohorts for cohort sync using existing functions.
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

/**
 * Class cohortsync_search_cohorts.
 *
 * @package local_o365\webservices
 */
class cohortsync_search_cohorts extends \external_api {
    /**
     * Parameters for search_cohorts.
     *
     * @return \external_function_parameters
     */
    public static function search_cohorts_parameters() {
        return new \external_function_parameters([
                'query' => new \external_value(PARAM_TEXT, 'Search query', VALUE_REQUIRED),
        ]);
    }

    /**
     * Search Moodle cohorts using existing functions.
     *
     * @param string $query The search query.
     * @return array Cohorts matching the query, excluding already mapped ones.
     */
    public static function search_cohorts($query) {
        global $DB;

        $params = self::validate_parameters(self::search_cohorts_parameters(), ['query' => $query]);

        self::validate_context(\context_system::instance());
        require_capability('moodle/site:config', \context_system::instance());

        $apiclient = \local_o365\feature\cohortsync\main::get_unified_api(__METHOD__);
        if (empty($apiclient)) {
            throw new \moodle_exception('cohortsync_unifiedapierror', 'local_o365');
        }

        $cohortsyncmain = new \local_o365\feature\cohortsync\main($apiclient);
        $allcohorts = $cohortsyncmain->get_cohortlist();

        // Get mapped to exclude.
        $mappedcohortids = [];
        $mappings = $DB->get_records('local_o365_objects', ['type' => 'group', 'subtype' => 'cohort'], '', 'moodleid');
        foreach ($mappings as $mapping) {
            $mappedcohortids[] = $mapping->moodleid;
        }

        $result = [];
        foreach ($allcohorts as $cohort) {
            if (!in_array($cohort->id, $mappedcohortids) && stripos($cohort->name, $params['query']) !== false) {
                $result[] = [
                        'id' => $cohort->id,
                        'name' => $cohort->name,
                ];
            }
        }

        usort($result, function ($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });
        $result = array_slice($result, 0, 30);

        return $result;
    }

    /**
     * Returns for search_cohorts.
     *
     * @return \external_description
     */
    public static function search_cohorts_returns() {
        return new \external_multiple_structure(
            new \external_single_structure([
                        'id' => new \external_value(PARAM_INT, 'Cohort ID'),
                        'name' => new \external_value(PARAM_TEXT, 'Cohort name'),
                ])
        );
    }
}
