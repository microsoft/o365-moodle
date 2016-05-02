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

    $.fn.sharepointlink = function(options) {
        var defaultopts = {
            url: 'localhost'
        };
        var opts = $.extend({}, defaultopts, options);
        var main = this;
        var checktimeout = null;
        this.inputelement = this.find('input.maininput');
        this.checkstatusempty = this.find('.local_o365_adminsetting_sharepointlink_status.empty');
        this.checkstatusinvalid = this.find('.local_o365_adminsetting_sharepointlink_status.siteinvalid');
        this.checkstatusnotempty = this.find('.local_o365_adminsetting_sharepointlink_status.sitenotempty');
        this.checkstatusvalid = this.find('.local_o365_adminsetting_sharepointlink_status.sitevalid');
        this.checkstatuschecking = this.find('.local_o365_adminsetting_sharepointlink_status.checkingsite');
        this.seturlui = this.find('.sharepointlink_seturl');
        this.viewstatusui = this.find('.local_o365_sharepointlink_viewstatus');

        this.setstatus = function(status) {
            main.find('.local_o365_adminsetting_sharepointlink_status').hide();
            if (status === 'empty') {
                main.checkstatusempty.show();
            } else if (status === 'checking') {
                main.checkstatuschecking.show();
            } else if (status === 'valid') {
                main.checkstatusvalid.show();
            } else if (status === 'invalid') {
                main.checkstatusinvalid.show();
            } else if (status === 'notempty') {
                main.checkstatusnotempty.show();
            }
        }

        this.queuecheck = function(q) {
            if (q !== '') {
                if (checktimeout != null) {
                    clearTimeout(checktimeout);
                }
                checktimeout = setTimeout(function() { main.docheck(q); }, 500);
            } else {
                main.setstatus('empty');
            }
        }

        this.docheck = function(q) {
            main.setstatus('checking');
            $.ajax({
                url: opts.url,
                type: 'GET',
                data: {mode: 'checksharepointsite', site: q},
                dataType: 'json',
                success: function(resp) {
                    if (typeof(resp.success) != 'undefined') {
                        if (resp.success === true && typeof(resp.data) != 'undefined' && typeof(resp.data.result) != 'undefined') {
                            if (resp.data.result === 'valid') {
                                main.setstatus('valid');
                            } else if (resp.data.result === 'notempty') {
                                main.setstatus('notempty');
                            } else {
                                main.setstatus('invalid');
                            }
                            return true;
                        }
                    }
                    main.setstatus('invalid');
                    return true;
                },
                error: function(data) {
                    main.setstatus('invalid');
                }
            });
        }

        this.inputelement.on('input',function() {
            main.queuecheck($(this).val());
        });

        this.find('.changesitelink').click(function() {
            main.seturlui.show();
            main.inputelement.show();
            main.viewstatusui.hide();
        });
    }

});