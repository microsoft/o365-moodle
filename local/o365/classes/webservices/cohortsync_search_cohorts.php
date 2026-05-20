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

use core\context\system;

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
            'offset' => new \external_value(PARAM_INT, 'Pagination offset', VALUE_DEFAULT, 0),
            'limit' => new \external_value(PARAM_INT, 'Maximum results per page', VALUE_DEFAULT, 20),
        ]);
    }

    /**
     * Search Moodle cohorts using direct SQL with paging.
     *
     * Filtering, sorting, and paging are all performed in SQL so only the
     * requested page is transferred from the database.
     *
     * @param string $query The search query.
     * @param int $offset Pagination offset.
     * @param int $limit Maximum results per page.
     * @return array Results page and whether more exist.
     */
    public static function search_cohorts($query, $offset = 0, $limit = 20) {
        global $DB;

        $params = self::validate_parameters(self::search_cohorts_parameters(), [
            'query' => $query,
            'offset' => $offset,
            'limit' => $limit,
        ]);

        self::validate_context(system::instance());
        require_capability('moodle/site:config', system::instance());

        $query = trim($params['query']);
        $offset = max(0, $params['offset']);
        $limit = min(max(1, $params['limit']), 50);

        if (strlen($query) < 2) {
            return ['results' => [], 'hasmore' => false];
        }

        $systemcontext = system::instance();
        $likename = $DB->sql_like('name', ':query', false, false);
        $sqlparams = [
            'query' => '%' . $DB->sql_like_escape($query) . '%',
            'contextid' => $systemcontext->id,
        ];

        $sql = "SELECT id, name
                  FROM {cohort}
                 WHERE contextid = :contextid
                   AND $likename
                   AND id NOT IN (
                       SELECT moodleid
                         FROM {local_o365_objects}
                        WHERE type = 'group' AND subtype = 'cohort'
                   )
                 ORDER BY name";

        // Fetch one extra row to detect whether a further page exists.
        $records = array_values($DB->get_records_sql($sql, $sqlparams, $offset, $limit + 1));
        $hasmore = count($records) > $limit;
        $page = array_slice($records, 0, $limit);

        $results = array_map(function ($r) {
            return ['id' => (int)$r->id, 'name' => $r->name];
        }, $page);

        return ['results' => $results, 'hasmore' => $hasmore];
    }

    /**
     * Returns for search_cohorts.
     *
     * @return \external_description
     */
    public static function search_cohorts_returns() {
        return new \external_single_structure([
            'results' => new \external_multiple_structure(
                new \external_single_structure([
                    'id' => new \external_value(PARAM_INT, 'Cohort ID'),
                    'name' => new \external_value(PARAM_TEXT, 'Cohort name'),
                ])
            ),
            'hasmore' => new \external_value(PARAM_BOOL, 'Whether more results exist beyond this page'),
        ]);
    }
}
