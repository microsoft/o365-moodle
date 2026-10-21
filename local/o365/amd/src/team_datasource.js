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
 * Team autocomplete datasource for the team connection form.
 *
 * Delegates all paginated-search logic to local_o365/paginated_autocomplete.
 *
 * @module local_o365/team_datasource
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['local_o365/paginated_autocomplete'], function(PaginatedAutocomplete) {
    return PaginatedAutocomplete.create({
        methodname: 'local_o365_search_teams',
        mapResult: function(t) {
            return {value: t.id, label: t.name};
        },
        noResultsKey: 'acp_teamconnections_no_teams_found',
        extraArgs: function(selector) {
            var original = document.querySelector(selector);
            var courseid = original ? parseInt(original.dataset.courseid, 10) : 0;
            return {courseid: courseid || 0};
        },
        getStaticOption: function(selector) {
            var original = document.querySelector(selector);
            var label = original ? original.dataset.unsetLabel : '';
            return label ? {value: '0', label: label} : null;
        },
    });
});
