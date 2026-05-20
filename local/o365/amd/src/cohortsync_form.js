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
 * Cohort sync form enhancements: clears field-level validation errors
 * from a previous submission once the user selects a value.
 *
 * @module local_o365/cohortsync_form
 * @copyright   Enovation Solutions Ltd. {@link https://enovation.ie}
 * @author      Patryk Mroczko <patryk.mroczko@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define([], function() {
    /**
     * Remove the Moodle error span for a field once it has a value.
     *
     * @param {string} fieldName The name attribute of the select element.
     */
    function clearErrorOnChange(fieldName) {
        var select = document.getElementById('id_' + fieldName);
        if (!select) {
            return;
        }
        select.addEventListener('change', function() {
            if (!this.value) {
                return;
            }
            var errorSpan = document.getElementById('id_error_' + fieldName);
            if (errorSpan) {
                errorSpan.remove();
            }
            var errorBreak = document.getElementById('id_error_break_' + fieldName);
            if (errorBreak) {
                errorBreak.remove();
            }
        });
    }

    return {
        /**
         * Initialise error-clearing listeners on the group and cohort selectors.
         */
        init: function() {
            clearErrorOnChange('groupoid');
            clearErrorOnChange('cohortid');
        }
    };
});
