// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * AMD module for course sync customization DataTables initialization.
 *
 * @module     local_o365/coursesynccustom_datatables
 * @package
 * @copyright  2025 Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery'], function($) {
    'use strict';

    return {
        /**
         * Initialize DataTables for course sync customization page.
         *
         * @param {string} ajaxUrl The AJAX endpoint URL for server-side processing
         * @param {boolean} isEditable Whether the page is editable
         * @param {string} regexLabel Label for the "search as regex" checkbox
         * @param {string} regexTitle Tooltip text for the "search as regex" checkbox
         */
        init: function(ajaxUrl, isEditable, regexLabel, regexTitle) {
            // Expose Moodle's jQuery globally so DataTables attaches to the correct instance
            window.jQuery = $;

            // Temporarily disable AMD to prevent DataTables from registering as an AMD module
            var originalAmd = window.define.amd;
            window.define.amd = false;

            var script = document.createElement('script');
            script.src = M.cfg.wwwroot + '/local/o365/lib/datatables/js/jquery.dataTables.min.js';

            script.onload = function() {
                // Re-enable AMD after DataTables has loaded
                window.define.amd = originalAmd;

                $(document).ready(function() {
                    $("#coursesynccustom_table").DataTable({
                        "serverSide": true,
                        "ajax": {
                            "url": ajaxUrl,
                            "dataSrc": "data"
                        },
                        "paging": true,
                        "pageLength": 50,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "order": [[0, "asc"]],
                        "columnDefs": [
                            {"orderable": true, "searchable": true, "targets": 0},
                            {"orderable": true, "searchable": true, "targets": 1},
                            {"orderable": true, "searchable": true, "targets": 2},
                            {"orderable": false, "searchable": false, "targets": 3},
                            {"orderable": false, "searchable": false, "targets": 4}
                        ],
                        "drawCallback": function() {
                            if (!isEditable) {
                                $("input.course_sync_enabled").prop("disabled", true);
                            }
                        },
                        "initComplete": function() {
                            // Add a checkbox next to the search box to let the search be treated as a regex.
                            var api = this.api();
                            var checkboxId = "coursesynccustom_regex_search";
                            var $label = $("<label>", {
                                "for": checkboxId,
                                "class": "ml-2",
                                "style": "font-weight: normal; margin-left: 1em;",
                                "title": regexTitle
                            });
                            var $checkbox = $("<input>", {"type": "checkbox", "id": checkboxId});
                            $label.append($checkbox).append(document.createTextNode(" " + regexLabel));
                            $(api.table().container()).find(".dataTables_filter").append($label);

                            $checkbox.on("change", function() {
                                api.search(api.search(), $(this).is(":checked")).draw();
                            });
                        }
                    });

                    if (!isEditable) {
                        $("input.course_sync_enabled").prop("disabled", true);
                    }
                });
            };

            document.head.appendChild(script);
        }
    };
});
