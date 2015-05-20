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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

$(function() {


$.fn.detectperms = function(options) {
    var defaultopts = {
        url: 'localhost',
        strvalid: '',
        iconvalid: '',
        strinvalid: '',
        iconinvalid: '',
        strfixperms: '',
        strerrorcheck: '',
        strerrorfix: '',
        strfixprereq: '',
        strmissing: '',
        strunifiedheader: '',
        strunifiednomissing: '',
        strnounified: ''
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
                            .find('img.smallicon').replaceWith(opts.iconvalid);
                    main.find('.permmessage').html(opts.strvalid);
                } else {
                    main.find('.statusmessage').html('<div>'+opts.strerrorfix+'</div>');
                }
                return true;
            },
            error: function(data) {
                main.setstatus('invalid');
            }
        });
    }

    this.checkmissingperms = function() {
        this.refreshbutton.html('Checking...');
        $.ajax({
            url: opts.url,
            type: 'GET',
            data: {mode: 'getappperms'},
            dataType: 'json',
            success: function(data) {
                main.refreshbutton.html('Update');
                if (typeof(data.success) != 'undefined' && typeof(data.missingperms) != 'undefined' && data.success === true) {
                    if (Object.keys(data.missingperms).length > 0) {
                        var status = $('<div>'+opts.strmissing+'<br /></div>');
                        for (var appname in data.missingperms) {
                            status.append('<h5>'+appname+'</h5>');
                            var listhtml = '<ul>';
                            for (var permname in data.missingperms[appname]) {
                                listhtml += '<li>'+data.missingperms[appname][permname]+'</li>';
                            }
                            listhtml += '</ul>';
                            status.append(listhtml);
                        }

                        if (typeof(data.haswrite) !== 'undefined' && data.haswrite === true) {
                            main.fixbutton = $('<button>'+opts.strfixperms+'</button>');
                            main.fixbutton.click(main.fixperms);
                            status.append(main.fixbutton);
                        } else {
                            status.append('<span>'+opts.strfixprereq+'</span>');
                        }

                        main.find('.statusmessage').html(status).show();
                        main.find('.local_o365_statusmessage')
                            .removeClass('alert-success').addClass('alert-error')
                             .find('img.smallicon').replaceWith(opts.iconinvalid);
                        main.find('.permmessage').html(opts.strinvalid);
                    } else {
                        // Permissions are correct.
                        main.find('.statusmessage').html('').hide();
                        main.find('.local_o365_statusmessage')
                            .removeClass('alert-error').addClass('alert-success')
                            .find('img.smallicon').replaceWith(opts.iconvalid);
                        main.find('.permmessage').html(opts.strvalid);
                    }

                    if (typeof(data.hasunified) !== 'undefined') {
                        main.find('.statusmessage').show();
                        main.find('.statusmessage').append('<h5>'+opts.strunifiedheader+'</h5>');
                        if (data.hasunified === true) {
                            if (Object.keys(data.missingunifiedperms).length > 0) {
                                main.find('.statusmessage').append(opts.strmissing+'<ul>');
                                for (var perm in data.missingunifiedperms) {
                                    main.find('.statusmessage').append('<li>'+perm+'</li>');
                                }
                                main.find('.statusmessage').append('</ul>');
                            } else {
                                main.find('.statusmessage').append('<ul><li>'+opts.strunifiednomissing+'</li></ul>');
                            }
                        } else {
                            main.find('.statusmessage').append('<ul><li>'+opts.strnounified+'</li></ul>');
                        }
                    }
                } else {
                    main.find('.statusmessage').html('<div>'+opts.strerrorcheck+'</div>');
                }
                return true;
            },
            error: function(data) {
                main.find('.statusmessage').html('<div>'+opts.strerrorcheck+'</div>');
            }
        });
    }

    this.init = function() {
        this.refreshbutton.click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            main.checkmissingperms();
        });
    }
    this.init();
}

});