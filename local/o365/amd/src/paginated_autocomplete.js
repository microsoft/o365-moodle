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
 * Factory for paginated Moodle autocomplete datasources backed by a web service.
 *
 * Supports paginated search: 20 results per page with an injected "Load more..."
 * button that appends the next page without closing the dropdown or selecting a value.
 * All per-widget state is keyed by selector so multiple widgets on the same page
 * (or AJAX re-renders) remain fully isolated.
 *
 * @module local_o365/paginated_autocomplete
 * @copyright   Enovation Solutions Ltd. {@link https://enovation.ie}
 * @author      Patryk Mroczko <patryk.mroczko@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['core/ajax', 'core/str'], function(Ajax, Str) {
    var PAGE_SIZE = 20;

    /**
     * Create a paginated autocomplete datasource.
     *
     * @param {Object} options
     * @param {string} options.methodname   Web service method to call for search.
     * @param {Function} options.mapResult  Maps one WS result item to {value, label}.
     * @param {string} options.noResultsKey Lang string key for the zero-results notice (component: local_o365).
     * @return {{processResults: Function, transport: Function}} Moodle autocomplete datasource.
     */
    function create(options) {
        var selectorStates = new Map();
        var strCache = {};

        Str.get_strings([
            {key: 'cohortsync_search', component: 'local_o365'},
            {key: 'cohortsync_load_more', component: 'local_o365'},
        ]).then(function(results) {
            strCache.search = results[0];
            strCache.loadMore = results[1];
            return results;
        }).catch(function() {
            // Fallback values are used at call sites via the || operator.
        });

        /**
         * Return the per-selector state object, creating it on first access.
         *
         * @param {string} selector CSS selector for the original <select> element.
         * @return {Object}
         */
        function getState(selector) {
            if (!selectorStates.has(selector)) {
                selectorStates.set(selector, {
                    query: null,
                    offset: 0,
                    accumulated: [],
                    success: null,
                    failure: null,
                    injectTimeoutId: null,
                    inputListenerAttached: false
                });
            }
            return selectorStates.get(selector);
        }

        /**
         * Cancel any pending "Load more" button injection timeout.
         *
         * @param {Object} st Per-selector state object.
         */
        function cancelInject(st) {
            if (st.injectTimeoutId !== null) {
                clearTimeout(st.injectTimeoutId);
                st.injectTimeoutId = null;
            }
        }

        /**
         * Find the suggestions listbox for the given CSS selector.
         *
         * @param {string} selector CSS selector for the original <select> element.
         * @return {Element|null}
         */
        function findListbox(selector) {
            var original = document.querySelector(selector);
            if (!original) {
                return null;
            }
            return original.parentElement.querySelector('[role="listbox"]');
        }

        /**
         * Remove the "Load more" button from the DOM immediately.
         *
         * @param {string} selector CSS selector for the original <select> element.
         */
        function removeButton(selector) {
            var listbox = findListbox(selector);
            if (!listbox) {
                return;
            }
            var btn = listbox.querySelector('.local-o365-load-more');
            if (btn) {
                btn.remove();
            }
        }

        /**
         * Attach a direct input listener to the autocomplete text field so the button
         * is removed as soon as the query drops below 2 characters — bypassing Moodle's
         * 300 ms transport throttle which would otherwise leave the button visible.
         *
         * @param {string} selector CSS selector for the original <select> element.
         */
        function attachInputListener(selector) {
            var st = getState(selector);
            if (st.inputListenerAttached) {
                return;
            }
            var original = document.querySelector(selector);
            if (!original) {
                return;
            }
            var textInput = original.parentElement.querySelector('input[data-fieldtype="autocomplete"]');
            if (!textInput) {
                return;
            }
            textInput.addEventListener('input', function() {
                if (this.value.length < 2) {
                    cancelInject(getState(selector));
                    removeButton(selector);
                }
            });
            st.inputListenerAttached = true;
        }

        /**
         * Inject the "Load more..." button into the listbox after Moodle's async
         * template re-render (~50 ms). The <li> carries role="button" and tabindex="0"
         * so it is keyboard-focusable and announced correctly by screen readers.
         * mousedown preventDefault keeps focus on the input so the dropdown stays open.
         * Enter and Space trigger the same action as a click.
         *
         * @param {string} selector CSS selector for the original <select> element.
         */
        function scheduleInject(selector) {
            var st = getState(selector);
            cancelInject(st);
            st.injectTimeoutId = setTimeout(function() {
                st.injectTimeoutId = null;

                var listbox = findListbox(selector);
                if (!listbox) {
                    return;
                }

                var existing = listbox.querySelector('.local-o365-load-more');
                if (existing) {
                    existing.remove();
                }

                var btn = document.createElement('li');
                btn.className = 'local-o365-load-more';
                btn.setAttribute('role', 'button');
                btn.setAttribute('tabindex', '0');
                btn.textContent = strCache.loadMore || 'Load more...';

                btn.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                });
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    loadPage(selector);
                });
                btn.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        e.stopPropagation();
                        loadPage(selector);
                    }
                });

                listbox.appendChild(btn);
            }, 50);
        }

        /**
         * Fetch the next page, accumulate results, and call state.success.
         * Schedules injection only when hasmore; explicitly removes the button
         * (after Moodle re-renders) when the last page is reached.
         *
         * @param {string} selector CSS selector for the original <select> element.
         */
        function loadPage(selector) {
            var st = getState(selector);
            var query = st.query;

            Ajax.call([{
                methodname: options.methodname,
                args: {
                    query: query,
                    offset: st.offset,
                    limit: PAGE_SIZE
                }
            }])[0].then(function(response) {
                if (query !== st.query) {
                    return null;
                }

                var newItems = response.results.map(options.mapResult);
                st.accumulated = st.accumulated.concat(newItems);
                st.offset += newItems.length;

                if (response.hasmore) {
                    st.success(st.accumulated.slice());
                    scheduleInject(selector);
                    return null;
                }

                cancelInject(st);
                // Moodle's re-render is async; remove after it completes.
                setTimeout(function() {
                    removeButton(selector);
                }, 100);

                if (st.accumulated.length === 0) {
                    // Return the string promise so the chained .then() below can call
                    // st.success without nesting a .then() inside this callback.
                    return Str.get_string(options.noResultsKey, 'local_o365', query);
                }

                st.success(st.accumulated.slice());
                return null;
            }).then(function(str) {
                if (typeof str === 'string' && query === st.query) {
                    st.success('<li class="local-o365-dropdown-notice">' + str + '</li>');
                }
                return null;
            }).fail(st.failure);
        }

        return {
            processResults: function(selector, results) {
                return results;
            },

            transport: function(selector, query, success, failure) {
                var st = getState(selector);

                if (query.length < 2) {
                    cancelInject(st);
                    removeButton(selector);
                    st.query = null;
                    st.offset = 0;
                    st.accumulated = [];
                    st.success = null;
                    st.failure = null;
                    var searchStr = strCache.search || 'Search';
                    success('<li class="local-o365-dropdown-notice">' + searchStr + '</li>');
                    return;
                }

                if (query !== st.query) {
                    cancelInject(st);
                    removeButton(selector);
                    st.query = query;
                    st.offset = 0;
                    st.accumulated = [];
                    st.success = success;
                    st.failure = failure;
                    attachInputListener(selector);
                } else {
                    st.success = success;
                    st.failure = failure;
                }

                loadPage(selector);
            }
        };
    }

    return {create: create};
});
