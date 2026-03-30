/* eslint-disable max-len */
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
 * Commands helper for the Moodle tiny_teamsmeeting plugin.
 *
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import {getButtonImage} from 'editor_tiny/utils';
import {get_string as getString} from 'core/str';
import {component, createMeetingButtonName, icon} from './common';
import {getAppurl, getClientdomain, getLocaleValue, getMsession, getCourseId} from "./options";
import Ajax from 'core/ajax';

const dialogApiReference = { current: null };

/**
 * Regex matching the Teams meeting join URL format.
 * Used as a fallback to re-identify links whose marker attribute was stripped
 * by Moodle's server-side HTML filtering.
 *
 * @type {RegExp}
 */
const TEAMS_MEETING_URL_PATTERN = /^https:\/\/teams\.microsoft\.com\/l\/meetup-join\//i;

/**
 * Get the setup function for the buttons.
 *
 * This is performed in an async function which ultimately returns the registration function as the
 * Tiny.AddOnManager.Add() function does not support async functions.
 *
 * @returns {function} The registration function to call within the Plugin.add function.
 */
export const getSetup = async() => {
    const [createMeetingButtonNameTitle, buttonImage] = await Promise.all([getString('pluginname', component), getButtonImage('icon', component)]);

    return editor => {
        editor.ui.registry.addIcon(icon, buttonImage.html);
        editor.ui.registry.addToggleButton(createMeetingButtonName, {
            icon,
            tooltip: createMeetingButtonNameTitle,
            onAction: openDialog(editor),
            onSetup: toggleActiveState(editor)
        });

        // PreInit fires before content is loaded, making it the correct place to
        // extend the schema. Directly mutating the existing element rule adds
        // data-teams-meeting without touching href, target, or any other valid
        // attribute. Using addValidElements('a[...]') replaces the entire rule,
        // which strips href and target from anchor elements.
        editor.on('PreInit', () => {
            const rule = editor.schema.getElementRule('a');
            if (rule) {
                rule.attributes['data-teams-meeting'] = {};
                if (rule.attributesOrder && !rule.attributesOrder.includes('data-teams-meeting')) {
                    rule.attributesOrder.push('data-teams-meeting');
                }
            }
        });

        // After content is loaded, mark any links that have lost their attribute
        // due to server-side HTML filtering.
        editor.on('init', () => migrateLegacyLinks(editor));

        window.addEventListener('message', event => {
            if (event.data && event.data.action === 'meetingUrl') {
                updateMeetingUrlInput(event.data.url);
            }
        });
    };
};

/**
 * Opens a dialog for the editor to display a modal
 *
 * @param {Editor} editor - The editor object.
 * @returns {function} - The async function that opens the dialog.
 */
const openDialog = editor => async () => {
    const [
        modalTitle,
        buttonPrimaryLabel,
        buttonSecondaryLabel,
        inputUrlLabel,
        inputUrlPlaceholder,
        checkboxNewWindowLabel,
    ] = await Promise.all([
        getString('tiny_modal_title', component),
        getString('tiny_button_primary_label', component),
        getString('tiny_button_secondary_label', component),
        getString('tiny_input_url_label', component),
        getString('tiny_input_url_placeholder', component),
        getString('tiny_checkbox_new_window_label', component),
    ]);

    let iframeData = await getIframeData(editor);

    dialogApiReference.current = editor.windowManager.open({
        title: modalTitle,
        body: {
            type: 'panel',
            items: [
                { type: 'htmlpanel', html: `<iframe id="msteams-frame" src="${iframeData.url}" style="width: 100%; height: 480px"></iframe>` },
                { type: 'input', name: 'meetingUrl', label: inputUrlLabel, enabled: false, placeholder: inputUrlPlaceholder },
                { type: 'checkbox', name: 'newWindowCheckbox', label: checkboxNewWindowLabel }
            ]
        },
        buttons: [
            { type: 'cancel', text: buttonSecondaryLabel },
            { type: 'submit', text: buttonPrimaryLabel, primary: true }
        ],
        onSubmit: handleSubmitAction(editor)
    });

    dialogApiReference.current.setData({
        meetingUrl: iframeData.meetingUrl,
        newWindowCheckbox: iframeData.newWindow
    });
};

/**
 * Returns true if the URL looks like a Teams meeting join link.
 *
 * Used as a last-resort fallback for links whose marker attributes were stripped
 * by Moodle's server-side HTML filtering (HTML Purifier removes id and data-*
 * attributes from stored content). Such links survive in the database as plain
 * anchors with no identifying attribute, so the URL pattern is the only reliable
 * signal remaining.
 *
 * @param {string|null} url - The URL to test.
 * @returns {boolean}
 */
const isTeamsMeetingUrl = (url) => !!url && TEAMS_MEETING_URL_PATTERN.test(url);

/**
 * Determines whether a DOM node is a Teams meeting link.
 *
 * Checks in order of specificity:
 *  1. data-teams-meeting attribute (current marker)
 *  2. id="tiny_meeting_link" (legacy marker, may still be present in editor DOM
 *     if TinyMCE has not yet serialised the content)
 *  3. Teams meeting URL pattern (fallback for links that have lost all markers)
 *
 * @param {Element|null} node - The DOM node to test.
 * @returns {boolean} True if the node is a Teams meeting link.
 */
const isTeamsMeetingLink = (node) => {
    if (!node || node.nodeName !== 'A') {
        return false;
    }
    return !!node.dataset?.teamsMeeting ||
        node.id === 'tiny_meeting_link' ||
        isTeamsMeetingUrl(node.getAttribute('href'));
};

/**
 * Migrates legacy Teams meeting links in the editor content to use the current
 * data-teams-meeting attribute.
 *
 * Handles two cases:
 *  - Links with the old id="tiny_meeting_link" attribute still intact in the DOM
 *    (content saved before the attribute was stripped by server-side filtering).
 *  - Plain anchor links whose href matches the Teams meeting URL pattern
 *    (content where all markers have been stripped by server-side filtering).
 *
 * Running this on editor init ensures all recognised links are consistently
 * marked before any user interaction occurs.
 *
 * @param {Editor} editor - The TinyMCE editor instance.
 */
const migrateLegacyLinks = (editor) => {
    editor.dom.select('a').forEach(link => {
        if (link.dataset?.teamsMeeting) {
            return; // Already marked, nothing to do.
        }
        if (link.id === 'tiny_meeting_link' || isTeamsMeetingUrl(link.getAttribute('href'))) {
            if (link.id === 'tiny_meeting_link') {
                editor.dom.setAttrib(link, 'id', null);
            }
            editor.dom.setAttrib(link, 'data-teams-meeting', '1');
        }
    });
};

/**
 * Handle the action of submitting the dialog.
 *
 * @param {Editor} editor The tinyMCE editor instance.
 */
const handleSubmitAction = (editor) => (api) => {
    const data = api.getData();
    const meetingUrl = data.meetingUrl;
    const newWindow = data.newWindowCheckbox;
    const targetType = newWindow ? '_blank' : '';

    let selectedNode = editor.selection.getNode();
    let linkNode = null;

    if (selectedNode.nodeName === 'A' && isTeamsMeetingLink(selectedNode)) {
        linkNode = selectedNode;
    } else if (selectedNode.parentNode?.nodeName === 'A' && isTeamsMeetingLink(selectedNode.parentNode)) {
        linkNode = selectedNode.parentNode;
    }

    if (linkNode) {
        editor.dom.setAttrib(linkNode, 'href', meetingUrl);
        editor.dom.setAttrib(linkNode, 'target', targetType);
        // Migrate legacy id-based links to the data attribute on save.
        if (linkNode.id === 'tiny_meeting_link') {
            editor.dom.setAttrib(linkNode, 'id', null);
            editor.dom.setAttrib(linkNode, 'data-teams-meeting', '1');
        }
    } else {
        let selectedContent = editor.selection.getContent({ format: 'text' });
        let contentToInsert = (selectedContent) ? selectedContent : meetingUrl;
        editor.insertContent(`<a data-teams-meeting="1" href="${meetingUrl}" target="${targetType}">${contentToInsert}</a>`);
    }
    api.close();
};

/**
 * Updates the meeting URL in the dialog API.
 *
 * @param {string} url - The new meeting URL.
 */
const updateMeetingUrlInput = url => {
    if (dialogApiReference.current) {
        dialogApiReference.current.setData({ meetingUrl: url });
    }
};

/**
 * Retrieves data for an iframe.
 *
 * @param {Editor} editor - The editor object.
 * @returns {{url: String, meetingUrl: String, newWindow: Boolean}} - An object containing information about the iframe.
 */
const getIframeData = async (editor) => {
    let data = getMeetingUrlFormSelectedNode(editor);
    if (data && data['link']) {
        const result = await Ajax.call([{ methodname: 'tiny_teamsmeeting_get_meeting_details', args: { url: data['link'] } }])[0];
        return {
            url: result['url'],
            meetingUrl: result['status'] ? data['link'] : '',
            newWindow: data['target'] === '_blank'
        };
    }
    return {
        url: `${getAppurl(editor)}?url=${getClientdomain(editor)}&locale=${getLocaleValue(editor)}&msession=${getMsession(editor)}&editor=tiny&courseid=${getCourseId(editor)}`,
        meetingUrl: '',
        newWindow: false
    };
};

/**
 * Retrieves the meeting URL and target from the selected node in the editor.
 *
 * @param {Editor} editor - The editor instance.
 * @returns {{link: String, target: String} | null} - The meeting URL and target, or null if not found.
 */
const getMeetingUrlFormSelectedNode = editor => {
    let selectedNode = editor.selection.getNode();
    let linkNode = null;

    if (selectedNode.nodeName === 'A') {
        linkNode = selectedNode;
    } else if (selectedNode.parentNode?.nodeName === 'A') {
        linkNode = selectedNode.parentNode;
    }

    if (linkNode && isTeamsMeetingLink(linkNode)) {
        return {
            link: linkNode?.getAttribute('href'),
            target: linkNode?.getAttribute('target')
        };
    }

    return null;
};

/**
 * Toggles the active state of an editor.
 *
 * @param {Editor} editor - The editor instance.
 * @returns {Function} - A cleanup function to remove the event listener.
 * @throws {TypeError} - If editor parameter is not an instance of Editor.
 */
const toggleActiveState = editor => (buttonApi) => {
    editor.on('NodeChange', () => handleNodeChange(editor, buttonApi));

    return function cleanup () {
        editor.on('NodeChange', () => handleNodeChange(editor, buttonApi));
    };
};

/**
 * Handles the change in the selected node in the editor.
 *
 * @param {Object} editor - The editor object.
 * @param {Object} buttonApi - The button API object.
 *
 * @returns {void}
 */
const handleNodeChange = (editor, buttonApi) => {
    const selectedNode = editor.selection.getNode();
    const isActive = isTeamsMeetingLink(selectedNode) || isTeamsMeetingLink(selectedNode.parentNode);

    buttonApi.setActive(isActive);
};