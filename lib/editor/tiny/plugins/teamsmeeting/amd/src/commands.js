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

// The whole workflow lives in a single URL dialog (windowManager.openUrl) that
// embeds result.php - it has to be a URL dialog rather than a plain modal with
// an htmlpanel because that is the only dialog type TinyMCE lets keyboard focus
// move into. result.php renders the "add link" controls, and posts an
// 'insertMeeting' message back here when the user confirms.
//
// Only one dialog can be open at a time (TinyMCE modals), so a single
// module-level record holds it and the editor that opened it. The postMessage
// handler (registered once, not per editor) routes to that editor.
const activeDialog = {api: null, editor: null};

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

    // Registered once for the page, not per editor: result.php posts the same
    // message regardless of which editor opened the dialog, so route it to the
    // editor that did (activeDialog.editor) and ignore it when no dialog is open.
    window.addEventListener('message', event => {
        if (!activeDialog.api || !event.data || event.data.action !== 'insertMeeting') {
            return;
        }
        // Only accept messages from the same Moodle origin (result.php).
        if (event.origin !== window.location.origin) {
            return;
        }
        // The dialog is a URL dialog, so its iframe carries no id we control.
        // Match the sender against every dialog iframe rather than assuming the
        // first one is ours.
        const iframes = Array.from(document.querySelectorAll('.tox-dialog__body-iframe iframe'));
        if (!iframes.some(iframe => event.source === iframe.contentWindow)) {
            return;
        }
        // Close only once the link has actually been inserted - a missing or
        // non-https URL leaves the dialog open so the user can retry.
        if (insertMeetingLink(activeDialog.editor, event.data.url || '', !!event.data.newWindow)) {
            activeDialog.api.close();
        }
    });

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
    };
};

/**
 * Opens the meeting dialog.
 *
 * A single URL dialog embeds result.php (directly for an existing link, or via
 * the Microsoft Teams meetings app for a new meeting). It has to be a URL dialog
 * rather than a plain modal with an htmlpanel because that is the only dialog
 * type TinyMCE lets keyboard focus move into. result.php renders the "add link"
 * controls and posts an 'insertMeeting' message back, handled in getSetup().
 *
 * @param {Editor} editor - The editor object.
 * @returns {function} - The async function that opens the dialog.
 */
const openDialog = editor => async() => {
    const [createTitle, editTitle] = await Promise.all([
        getString('tiny_modal_title', component),
        getString('tiny_edit_modal_title', component),
    ]);

    const iframeData = await getIframeData(editor);
    const editing = (iframeData.meetingUrl || '') !== '';

    // No footer buttons: the dialog's own close (X) dismisses it, and the
    // "add link" action lives in result.php inside the iframe.
    activeDialog.editor = editor;
    activeDialog.api = editor.windowManager.openUrl({
        title: editing ? editTitle : createTitle,
        url: iframeData.url,
        height: 500,
        width: 620,
        onClose: () => {
            activeDialog.api = null;
            activeDialog.editor = null;
        },
    });

    focusDialogIframe();
};

/**
 * Move keyboard focus into the dialog iframe once the dialog has rendered.
 *
 * TinyMCE's own focus manager runs while the dialog is still animating in, finds
 * no laid-out tab stop and gives up, so focus is left on the toolbar button and
 * the user has to tab through the whole page to reach the dialog. Focusing the
 * iframe directly sidesteps that (and lands the user straight on the meeting UI).
 * A few retries cover the dialog not being in the DOM yet and focus being reset
 * when the open animation finishes.
 *
 * @returns {void}
 */
const focusDialogIframe = () => {
    let attempts = 0;
    const tick = () => {
        const iframe = document.querySelector('.tox-dialog__body-iframe iframe');
        if (iframe && document.activeElement !== iframe) {
            iframe.focus();
        }
        if (attempts++ < 6) {
            setTimeout(tick, 60);
        }
    };
    tick();
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
 * Return url if it uses the https protocol, otherwise return an empty string.
 * Prevents javascript: and other dangerous protocol injections into href attributes.
 *
 * @param {string} url - The URL to validate.
 * @returns {string} The original URL when safe, or an empty string.
 */
const toSafeHttpsUrl = (url) => {
    try {
        return new URL(url).protocol === 'https:' ? url : '';
    } catch {
        return '';
    }
};

/**
 * Insert a new Teams meeting link, or update the currently selected one.
 *
 * @param {Editor} editor - The tinyMCE editor instance.
 * @param {string} url - The meeting join URL.
 * @param {boolean} newWindow - Whether the link should open in a new window.
 * @returns {boolean} True when a link was inserted or updated, false when the
 *     URL was missing or not an https URL (nothing is changed).
 */
const insertMeetingLink = (editor, url, newWindow) => {
    // Validate the protocol before using the URL anywhere in the DOM so that
    // a malicious value received via postMessage cannot inject javascript: hrefs.
    const meetingUrl = toSafeHttpsUrl(url);
    if (!meetingUrl) {
        return false;
    }
    const targetType = newWindow ? '_blank' : '';

    let selectedNode = editor.selection.getNode();
    let linkNode = null;

    if (selectedNode.nodeName === 'A' && isTeamsMeetingLink(selectedNode)) {
        linkNode = selectedNode;
    } else if (selectedNode.parentNode?.nodeName === 'A' && isTeamsMeetingLink(selectedNode.parentNode)) {
        linkNode = selectedNode.parentNode;
    }

    if (linkNode) {
        // Editor.dom.setAttrib encodes attribute values — safe as-is.
        editor.dom.setAttrib(linkNode, 'href', meetingUrl);
        editor.dom.setAttrib(linkNode, 'target', targetType);
        // Migrate legacy id-based links to the data attribute on save.
        if (linkNode.id === 'tiny_meeting_link') {
            editor.dom.setAttrib(linkNode, 'id', null);
            editor.dom.setAttrib(linkNode, 'data-teams-meeting', '1');
        }
    } else {
        const selectedContent = editor.selection.getContent({format: 'text'});
        const contentToInsert = selectedContent || meetingUrl;
        // Use TinyMCE's DOM API to build the anchor element so that attribute
        // values and inner text are properly escaped — never interpolate
        // user-controlled data into a raw HTML string.
        editor.insertContent(
            editor.dom.createHTML(
                'a',
                {'data-teams-meeting': '1', href: meetingUrl, target: targetType},
                editor.dom.encode(contentToInsert)
            )
        );
    }

    return true;
};

/**
 * Retrieves the dialog iframe URL, and the selected meeting link if any.
 *
 * @param {Editor} editor - The editor object.
 * @returns {{url: String, meetingUrl: String}} The iframe src, and the currently
 *     selected Teams meeting link ('' when creating a new meeting).
 */
const getIframeData = async(editor) => {
    let data = getMeetingUrlFromSelectedNode(editor);
    if (data && data.link) {
        const result = await Ajax.call([{
            methodname: 'tiny_teamsmeeting_get_meeting_details',
            args: {url: data.link, newwindow: data.target === '_blank'},
        }])[0];
        return {
            url: result.url,
            meetingUrl: result.status ? data.link : '',
        };
    }
    const params = new URLSearchParams({
        url: getClientdomain(editor),
        locale: getLocaleValue(editor),
        msession: getMsession(editor),
        editor: 'tiny',
        courseid: getCourseId(editor),
        previewmode: 'options',
    });
    return {
        url: `${getAppurl(editor)}?${params.toString()}`,
        meetingUrl: '',
    };
};

/**
 * Retrieves the meeting URL and target from the selected node in the editor.
 *
 * @param {Editor} editor - The editor instance.
 * @returns {{link: String, target: String} | null} - The meeting URL and target, or null if not found.
 */
const getMeetingUrlFromSelectedNode = editor => {
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
    const handler = () => handleNodeChange(editor, buttonApi);
    editor.on('NodeChange', handler);

    return function cleanup() {
        editor.off('NodeChange', handler);
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