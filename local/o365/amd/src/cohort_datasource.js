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
 * Cohort autocomplete datasource for cohort sync.
 *
 * @module local_o365/group_datasource
 * @copyright   Enovation Solutions Ltd. {@link https://enovation.ie}
 * @author      Patryk Mroczko <patryk.mroczko@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
define(['jquery', 'core/ajax'], function($, Ajax) {
    return {
        processResults: function(selector, results) {
            var cohorts = [];
            $.each(results, function(index, cohort) {
                cohorts.push({
                    value: cohort.id,
                    label: cohort.name
                });
            });
            return cohorts;
        },
        transport: function(selector, query, success, failure) {
            Ajax.call([{
                methodname: 'local_o365_search_cohorts',
                args: {
                    query: query
                }
            }])[0].then(success).fail(failure);
        }
    };
});

