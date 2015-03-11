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


$.fn.serviceresource = function(options) {
    var defaultopts = {
        url: 'localhost',
        setting: '',
        strvalid: '',
        iconvalid: '',
        strinvalid: '',
        iconinvalid: '',
        strerror: 'An error occurred detecting setting. Please set manually.'
    };
    var opts = $.extend({}, defaultopts, options);
    var main = this;
    var checktimeout = null;
    var checkrequest = null;
    this.detectbutton = this.find('button.detect');
    this.input = this.find('input.maininput');

    this.queuecheck = function(q) {
        if (q !== '') {
            if (checktimeout != null) {
                clearTimeout(checktimeout);
            }
            checktimeout = setTimeout(function() { main.checksetting(q); }, 500);
        }
    }

    this.abortsearch = function() {
        if (checkrequest && checkrequest.readyState != 4) {
            checkrequest.abort();
        }
    }

    this.checksetting = function(val) {
        main.abortsearch();
        checkrequest = $.ajax({
            url: opts.url,
            type: 'GET',
            data: {
                mode: 'checkserviceresource',
                setting: opts.setting,
                value: val
            },
            dataType: 'json',
            success: function(data) {
                if (typeof(data.success) != 'undefined' && data.success === true) {
                    main.find('.local_o365_statusmessage').show().removeClass('alert-error').removeClass('alert-info').addClass('alert-success');
                    main.find('.local_o365_statusmessage').find('img.smallicon').replaceWith(opts.iconvalid);
                    main.find('.local_o365_statusmessage').find('.statusmessage').html(opts.strvalid);
                } else {
                    main.find('.local_o365_statusmessage').show().removeClass('alert-success').removeClass('alert-info').addClass('alert-error');
                    main.find('.local_o365_statusmessage').find('img.smallicon').replaceWith(opts.iconinvalid);
                    main.find('.local_o365_statusmessage').find('.statusmessage').html(opts.strinvalid);
                }
                return true;
            },
            error: function(data) {
                main.find('.local_o365_statusmessage').show().removeClass('alert-success').removeClass('alert-info').addClass('alert-error');
                main.find('.local_o365_statusmessage').find('img.smallicon').replaceWith(opts.iconinvalid);
                main.find('.local_o365_statusmessage').find('.statusmessage').html(opts.strerror);
            }
        });
    }

    this.detectsetting = function() {
        $.ajax({
            url: opts.url,
            type: 'GET',
            data: {
                mode: 'detectserviceresource',
                setting: opts.setting
            },
            dataType: 'json',
            success: function(data) {
                if (typeof(data.success) != 'undefined' && typeof(data.settingval) === 'string' && data.success === true) {
                    main.input.val(data.settingval);
                    main.find('.local_o365_statusmessage').show().removeClass('alert-error').removeClass('alert-info').addClass('alert-success');
                    main.find('.local_o365_statusmessage').find('img.smallicon').replaceWith(opts.iconvalid);
                    main.find('.local_o365_statusmessage').find('.statusmessage').html(opts.strvalid);
                } else {
                    main.find('.local_o365_statusmessage').show().removeClass('alert-success').removeClass('alert-info').addClass('alert-error');
                    main.find('.local_o365_statusmessage').find('img.smallicon').replaceWith(opts.iconinvalid);
                    main.find('.local_o365_statusmessage').find('.statusmessage').html(opts.strerror);
                }
                return true;
            },
            error: function(data) {
                main.find('.local_o365_statusmessage').show().removeClass('alert-success').removeClass('alert-info').addClass('alert-error');
                main.find('.local_o365_statusmessage').find('img.smallicon').replaceWith(opts.iconinvalid);
                main.find('.local_o365_statusmessage').find('.statusmessage').html(opts.strerror);
            }
        });
    }

    this.input.on('input', function(e) {
        main.queuecheck($(this).val());
    });

    this.detectbutton.click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        main.detectsetting();
    });
}

});