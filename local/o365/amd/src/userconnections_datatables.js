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
 * AMD module for the manage user connections DataTables initialization.
 *
 * @module     local_o365/userconnections_datatables
 * @copyright  2025 Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/log'], function($, Log) {
    'use strict';

    return {
        /**
         * Initialize DataTables for the manage user connections page.
         *
         * @param {string} ajaxUrl The AJAX endpoint URL for server-side processing
         */
        init: function(ajaxUrl) {
            // Expose Moodle's jQuery globally so DataTables attaches to the correct instance.
            window.jQuery = $;

            // DataTables is a plain browser library, not an AMD module. Temporarily disable AMD so it does not
            // register itself, and make sure AMD is restored whether the script loads or fails.
            var hasDefine = typeof window.define === 'function';
            var originalAmd = hasDefine ? window.define.amd : undefined;
            var amdRestored = false;
            var restoreAmd = function() {
                if (hasDefine && !amdRestored) {
                    window.define.amd = originalAmd;
                    amdRestored = true;
                }
            };

            if (hasDefine) {
                window.define.amd = false;
            }

            var script = document.createElement('script');
            script.src = M.cfg.wwwroot + '/local/o365/lib/datatables/js/jquery.dataTables.min.js';

            script.onload = function() {
                restoreAmd();

                $(document).ready(function() {
                    $("#local_o365_userconnections_table").DataTable({
                        "serverSide": true,
                        "ajax": {
                            "url": ajaxUrl,
                            "dataSrc": "data"
                        },
                        "paging": true,
                        "pageLength": 25,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "order": [[0, "asc"]],
                        "columnDefs": [
                            {"orderable": true, "searchable": true, "targets": 0},
                            {"orderable": true, "searchable": true, "targets": 1},
                            {"orderable": false, "searchable": false, "targets": [2, 3, 4]}
                        ]
                    });
                });
            };

            script.onerror = function() {
                restoreAmd();
                Log.error('local_o365/userconnections_datatables: could not load DataTables from ' + script.src);
            };

            document.head.appendChild(script);
        }
    };
});
