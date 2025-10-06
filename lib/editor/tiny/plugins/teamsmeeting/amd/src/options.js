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
 * Options for the Moodle tiny_teamsmeeting plugin.
 *
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {getPluginOptionName} from 'editor_tiny/options';
import {pluginName} from './common';

const appurl = getPluginOptionName(pluginName, 'appurl');
const clientdomain = getPluginOptionName(pluginName, 'clientdomain');
const localevalue = getPluginOptionName(pluginName, 'localevalue');
const msession = getPluginOptionName(pluginName, 'msession');
const courseid = getPluginOptionName(pluginName, 'courseid');

export const register = (editor) => {
    const registerOption = editor.options.register;

    registerOption(appurl, {
        processor: 'string',
    });
    registerOption(clientdomain, {
        processor: 'string',
    });
    registerOption(localevalue, {
        processor: 'string',
    });
    registerOption(msession, {
        processor: 'string',
    });
    registerOption(courseid, {
        processor: 'int',
    });
};

/**
 * Fetch the myFirstProperty value for this editor instance.
 *
 * @param {tinyMCE} editor The editor instance to fetch the value for
 * @returns {object} The value of the myFirstProperty option
 */
export const getAppurl = (editor) => editor.options.get(appurl);
export const getClientdomain = (editor) => editor.options.get(clientdomain);
export const getLocaleValue = (editor) => editor.options.get(localevalue);
export const getMsession = (editor) => editor.options.get(msession);
export const getCourseId = (editor) => editor.options.get(courseid);
