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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$(function() {

    $.fn.verifysetup = function(options) {
        var defaultopts = {
            url: 'localhost',
            iconsuccess: '',
            iconinfo: '',
            iconerror: '',

            strupdate: 'Update',
            strchecking: 'Checking...',
            strmissingperms: 'Missing Delegated Permissions:',
            strmissingappperms: 'Missing Application Permissions:',
            strpermscorrect: 'Permissions correct.',
            strapppermscorrect: 'Application Permissions correct.',
            strfixperms: 'Fix Permissions',
            strerrorfix: 'An error occurred trying to fix permissions.',
            strerrorcheck: 'An error occurred trying to check Azure setup.',
            strnoinfo: 'We don\'t have any information about your Azure setup yet. Please click the Update button to check.',

            strappdataheader: 'Azure app',
            strappdatadesc: 'Verifies the correct parameters are set up in Azure.',
            strappdatareplyurlcorrect: 'Reply URL Correct',
            strappdatareplyurlincorrect: 'Reply URL Incorrect',
            strappdatareplyurlgeneralerror: 'Could not check reply url.',
            strappdatasignonurlcorrect: 'Sign-on URL Correct.',
            strappdatasignonurlincorrect: 'Sign-on URL Incorrect',
            strappdatasignonurlgeneralerror: 'Could not check sign-on url.',
            strdetectedval: 'Detected Value:',
            strcorrectval: 'Correct Value:',

            strunifiedheader: 'Unified API',
            strunifieddesc: 'The unified API replaces the existing application-specific APIs. If available, you should add this to your Azure app.',
            strunifiederror: 'There was an error checking Unified API settings.',
            strunifiedpermerror: 'There was an error checking Unified API permissions.',
            strunifiedmissing: 'The unified API was not found in this application.',
            strunifiedactive: 'Unified API active.',

            strtenanterror: 'Please use the detect button to set your Microsoft Tenant before updating Azure Setup.',
        };
        var opts = $.extend({}, defaultopts, options);
        var main = this;
        this.refreshbutton = this.find('button.refreshperms');

        this.fixperms = function(e) {
            e.preventDefault();
            e.stopPropagation();
            $.ajax({
                url: opts.url,
                type: 'GET',
                data: {mode: 'fixappperms'},
                dataType: 'json',
                success: function(data) {
                    if (typeof(data.success) != 'undefined' && data.success === true) {
                        main.find('.statusmessage').html('').hide();
                        main.find('.local_o365_statusmessage')
                            .removeClass('alert-error').addClass('alert-success')
                            .find('img.smallicon').replaceWith(opts.iconsuccess);
                        main.find('.permmessage').html(opts.strpermscorrect);
                    } else {
                        main.find('.statusmessage').empty().append($('<div></div>').text(opts.strerrorfix));
                    }
                    return true;
                },
                error: function(data) {
                    main.setstatus('invalid');
                }
            });
        }

        /**
         * Safely append box body content, whether it is a plain text string or
         * a jQuery object already built out of safe DOM elements/text nodes.
         *
         * @param object body jQuery object for the box body element.
         * @param string|object content Text to escape, or a pre-built jQuery object.
         */
        this.appendboxcontent = function(body, content) {
            if (content && typeof content === 'object' && content.jquery) {
                body.append(content);
            } else {
                body.text(content);
            }
        }

        /**
         * Render an error box.
         *
         * @param string|object content Text to use as box body, or a jQuery object of safe HTML.
         * @return object jQuery object representing rendered box.
         */
        this.rendererrorbox = function(content) {
            var box = $('<div></div>').addClass('alert-error alert local_o365_statusmessage');
            box.append(opts.iconerror);
            var body = $('<div style="display: inline-block"></div>');
            main.appendboxcontent(body, content);
            box.append(body);
            return box;
        }

        /**
         * Render an info box.
         *
         * @param string|object content Text to use as box body, or a jQuery object of safe HTML.
         * @return object jQuery object representing rendered box.
         */
        this.renderinfobox = function(content) {
            var box = $('<div></div>').addClass('alert-info alert local_o365_statusmessage');
            box.append(opts.iconinfo);
            var body = $('<div style="display: inline-block"></div>');
            main.appendboxcontent(body, content);
            box.append(body);
            return box;
        }

        /**
         * Render an success box.
         *
         * @param string|object content Text to use as box body, or a jQuery object of safe HTML.
         * @return object jQuery object representing rendered box.
         */
        this.rendersuccessbox = function(content) {
            var box = $('<div></div>').addClass('alert-success alert local_o365_statusmessage');
            box.append(opts.iconsuccess);
            var body = $('<div style="display: inline-block"></div>');
            main.appendboxcontent(body, content);
            box.append(body);
            return box;
        }

        /**
         * Update tool display.
         *
         * @param string|object content HTML or jQuery object to display.
         */
        this.updatedisplay = function(content) {
            main.find('.results').html(content);
        }

        /**
         * Build a safe "missing permissions" list box, escaping the permission
         * name and description before inserting them into the DOM.
         *
         * @param string header Header text to show above the list.
         * @param object missingperms Map of permission name to description.
         * @return object jQuery object representing the built content.
         */
        this.buildmissingpermsbox = function(header, missingperms) {
            var box = $('<div></div>');
            box.append($('<span></span>').text(header));
            var ul = $('<ul></ul>');
            Object.keys(missingperms).forEach(function(perm) {
                var li = $('<li></li>');
                li.append($('<b></b>').text(perm));
                li.append(document.createTextNode(': ' + missingperms[perm]));
                ul.append(li);
            });
            box.append(ul);
            return box;
        }

        /**
         * Build a safe "value mismatch" box (e.g. detected vs. correct URL),
         * escaping the detected/intended values before inserting them into the DOM.
         *
         * @param string introtext Header text describing the mismatch.
         * @param string detected Detected value, as reported by Azure.
         * @param string intended Intended/correct value.
         * @return object jQuery object representing the built content.
         */
        this.buildvaluemismatchbox = function(introtext, detected, intended) {
            var box = $('<span></span>');
            box.append(document.createTextNode(introtext));
            box.append(document.createElement('br'));
            box.append(document.createTextNode(opts.strdetectedval + ' '));
            box.append($('<b></b>').text(detected));
            box.append(document.createElement('br'));
            box.append(document.createTextNode(opts.strcorrectval + ' '));
            box.append($('<b></b>').text(intended));
            return box;
        }

        /**
         * Render unified API setup results.
         *
         * @param object data Data returned from ajax call.
         * @return object jQuery object for rendered results section.
         */
        this.rendersection_unifiedapi = function(data) {
            if (typeof(data.error) !== 'undefined') {
                return main.rendererrorbox(data.error);
            }

            var unifiedactive = (typeof(data.active) !== 'undefined' && data.active === true) ? true : false;
            if (unifiedactive === true) {
                var content = $('<div></div>');
                content.append(main.rendersuccessbox(opts.strunifiedactive));

                // App-only perms.
                if (typeof(data.missingappperms) === 'object') {
                    if (Object.keys(data.missingappperms).length > 0) {
                        var missingpermsbox = main.buildmissingpermsbox(opts.strmissingappperms, data.missingappperms);
                        content.append(main.rendererrorbox(missingpermsbox));
                    } else {
                        content.append(main.rendersuccessbox(opts.strapppermscorrect));
                    }

                }

                // Delegated perms.
                if (typeof(data.missingperms) === 'object' && data.missingperms !== null) {
                    if (Object.keys(data.missingperms).length > 0) {
                        var missingdelegatedpermsbox = main.buildmissingpermsbox(opts.strmissingperms, data.missingperms);
                        content.append(main.rendererrorbox(missingdelegatedpermsbox));
                    } else {
                        content.append(main.rendersuccessbox(opts.strpermscorrect));
                    }
                } else {
                    content.append(main.rendererrorbox(opts.strunifiedpermerror));
                }
                return content;
            } else {
                return main.rendererrorbox(opts.strunifiedmissing);
            }
        }

        /**
         * Render all results.
         *
         * @param object results Results object.
         */
        this.renderresults = function(results) {
            var content = $('<div class="local_o365_adminsetting_verifysetup_results"></div>');
            if (results === false) {
                content.append(main.renderinfobox(opts.strnoinfo));
                main.updatedisplay(content);
                return true;
            }
            if (typeof(results.success) != 'undefined') {
                if (results.success === true && typeof(results.data) != 'undefined') {
                    // Azure app check.
                    if (typeof(results.data.appdata) !== 'undefined') {
                        var appdata = $('<section></section>');
                        appdata.append($('<h5></h5>').text(opts.strappdataheader));
                        appdata.append($('<span></span>').text(opts.strappdatadesc));

                        if (typeof(results.data.appdata.error) === 'undefined') {
                            if (typeof(results.data.appdata.replyurl) !== 'undefined') {
                                if (results.data.appdata.replyurl.correct === true) {
                                    appdata.append(main.rendersuccessbox(opts.strappdatareplyurlcorrect));
                                } else {
                                    var replyurlerrbox = main.buildvaluemismatchbox(opts.strappdatareplyurlincorrect,
                                        results.data.appdata.replyurl.detected, results.data.appdata.replyurl.intended);
                                    appdata.append(main.rendererrorbox(replyurlerrbox));
                                }
                            } else {
                                appdata.append(main.renderinfobox(opts.strappdatareplyurlgeneralerror));
                            }

                            if (typeof(results.data.appdata.signonurl) !== 'undefined') {
                                if (results.data.appdata.signonurl.correct === true) {
                                    appdata.append(main.rendersuccessbox(opts.strappdatasignonurlcorrect));
                                } else {
                                    var signonurlerrbox = main.buildvaluemismatchbox(opts.strappdatasignonurlincorrect,
                                        results.data.appdata.signonurl.detected, results.data.appdata.signonurl.intended);
                                    appdata.append(main.rendererrorbox(signonurlerrbox));
                                }
                            }
                        } else {
                            appdata.append(main.rendererrorbox(results.data.appdata.error));
                        }
                        content.append(appdata);
                    }

                    // Unified API.
                    var unified = $('<section></section>');
                    unified.append($('<h5></h5>').text(opts.strunifiedheader));
                    unified.append($('<span></span>').text(opts.strunifieddesc));
                    if (typeof(results.data.unifiedapi) !== 'undefined') {
                        unified.append(main.rendersection_unifiedapi(results.data.unifiedapi));
                    } else {
                        unified.append(main.rendererrorbox(opts.strunifiederror));
                    }
                    content.append(unified);

                    main.updatedisplay(content);
                    return true;
                }

                if (results.success === false && typeof(results.errormessage) != 'undefined') {
                    content.append(main.rendererrorbox(results.errormessage));
                    main.updatedisplay(content);
                    return true;
                }
            }

            content.append(main.rendererrorbox(opts.strerrorcheck));
            main.updatedisplay(content);
            return true;
        }

        this.checksetup = function() {
            // Check to see if Microsoft tenant is set.
            if ($('#id_s_local_o365_entratenant').val().length == 0) {
                 main.refreshbutton.html(opts.strupdate);
                var content = main.rendererrorbox(opts.strerrorcheck + ' (' + opts.strtenanterror + ')');
                main.updatedisplay(content);
                return;
            }
            this.refreshbutton.html(opts.strchecking);
            $.ajax({
                url: opts.url,
                type: 'GET',
                data: {
                    mode: 'checksetup',
                    entratenant: $('#id_s_local_o365_entratenant').val(),
                    odburl: $('#id_s_local_o365_odburl').val(),
                },
                dataType: 'json',
                success: function(resp) {
                    main.refreshbutton.html(opts.strupdate);
                    main.renderresults(resp);
                },
                error: function(data, errorThrown, textStatus) {
                    main.refreshbutton.html(opts.strupdate);
                    var content = main.rendererrorbox(opts.strerrorcheck + ' (' + textStatus + ')');
                    main.updatedisplay(content);
                }
            });
        }

        this.init = function() {
            if (typeof(opts.lastresults) !== 'undefined') {
                main.renderresults(opts.lastresults);
            }
            this.refreshbutton.click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                main.checksetup();
            });
        }
        this.init();
    }

});
