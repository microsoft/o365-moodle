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
 * @package    atto_teamsmeeting
 * @copyright  2020 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * @module moodle-atto_teamsmeeting-button
 */

/**
 * Atto text editor teamsmeeting plugin.
 *
 * The meeting dialogue is a small hand-rolled modal rather than Moodle's
 * usual M.core.dialogue: M.core.dialogue's keyboard focus trap
 * (core/local/aria/focuslock, also used by the AMD core/modal) builds its
 * "focusable elements" list from a fixed set of tag/attribute selectors that
 * does not include <iframe>, so building the dialogue on either of those
 * risked losing keyboard access to the iframe (the entire point of the
 * dialogue) as the plugin evolved. This dialogue instead traps focus with a
 * pair of invisible sentinel elements either side of its content: when focus
 * lands on one (meaning the user tabbed past the last/first real control),
 * it is redirected back inside. Nothing in between is special-cased, so the
 * browser's own native (iframe-aware) tab order handles moving in and out of
 * the iframe itself.
 *
 * @namespace M.atto_teamsmeeting
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */
var COMPONENTNAME = 'atto_teamsmeeting',
    // Only one instance of the dialogue is ever open at a time.
    activeDialogue = {plugin: null};

/**
 * Reduce a URL to one that is safe to insert as a link target.
 *
 * Only absolute http(s) links are accepted, since a meeting link is always
 * one - never a same-page or site-relative one. Protocol-relative and
 * scheme-less values are normalised to https; anything carrying another
 * scheme (javascript:, data:, ...), and any relative or hash-only value, is
 * rejected so it can never become an unsafe (or simply nonsensical) href.
 *
 * @param {String} url
 * @return {String} The safe URL, normalised where needed, or '' when unsafe.
 */
var toSafeHttpsUrl = function(url) {
    url = (url || '').trim();
    if (url === '') {
        return '';
    }
    if (/^\/\//.test(url)) {
        return 'https:' + url;
    }
    if (/^[a-z][a-z0-9+.-]*:\/\//i.test(url)) {
        return (/^https?:\/\//i).test(url) ? url : '';
    }
    if (/^[a-z][a-z0-9+.-]*:(?!\d)/i.test(url)) {
        return '';
    }
    if (/^[#/]/.test(url)) {
        return '';
    }
    return 'https://' + url;
};

/**
 * Hide the rest of the page from assistive technology while the dialogue is
 * open (mirroring what a proper modal dialog is expected to do).
 *
 * @param {Node} exclude Element to leave alone (the dialogue's own overlay).
 * @return {Function} Call to restore the elements this hid.
 */
var hideBackgroundFromScreenReaders = function(exclude) {
    var hidden = [],
        children = document.body.children,
        i,
        node;

    for (i = 0; i < children.length; i++) {
        node = children[i];
        if (node === exclude || node.hasAttribute('aria-hidden')) {
            continue;
        }
        node.setAttribute('aria-hidden', 'true');
        hidden.push(node);
    }

    return function() {
        Y.Array.each(hidden, function(node) {
            node.removeAttribute('aria-hidden');
        });
    };
};

Y.namespace('M.atto_teamsmeeting').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {

    /**
     * A reference to the current selection at the time that the dialogue
     * was opened.
     *
     * @property _currentSelection
     * @type Range
     * @private
     */
    _currentSelection: null,

    /**
     * A reference to the dialogue's iframe, once it is open.
     *
     * @property _content
     * @type Node
     * @private
     */
    _content: null,

    /**
     * Moodle base url to pass for Meetings app.
     *
     * @param _clientdomain
     * @type String
     * @private
     */
    _clientdomain: null,

    /**
     * The Meetings app url.
     *
     * @param _appurl
     * @type String
     * @private
     */
    _appurl: null,

    /**
     * Moodle user language to pass for Meetings app.
     *
     * @param _locale
     * @type String
     * @private
     */
    _locale: null,

    initializer: function() {
        this._clientdomain = this.get('clientdomain');
        this._appurl = this.get('appurl');
        this._locale = this.get('locale');
        // Add the teamsmeeting button first.
        this.addButton({
            icon: 'icon',
            iconComponent: 'atto_teamsmeeting',
            callback: this._displayDialogue,
            tags: 'a',
            tagMatchRequiresAll: false
        });
    },

    /**
     * Display the teamsmeeting dialogue.
     *
     * @method _displayDialogue
     * @private
     */
    _displayDialogue: function() {
        var selectedanchor;

        // Store the current selection.
        this._currentSelection = this.get('host').getSelection();
        if (this._currentSelection === false) {
            return;
        }

        selectedanchor = this._getSelectedAnchor();

        if (activeDialogue.plugin) {
            activeDialogue.plugin._closeMeetingDialogue();
        }
        activeDialogue.plugin = this;

        this._buildMeetingDialogue(selectedanchor);

        if (selectedanchor) {
            // There is selected text and it is part of an anchor teamsmeeting:
            // load its details (and current target) into the iframe.
            this._loadExistingMeeting(selectedanchor);
        } else {
            this._loadNewMeeting();
        }

        this._focusIframe();
    },

    /**
     * If there is selected text and it is part of an anchor teamsmeeting,
     * find it and extract the url (and target).
     *
     * @method _getSelectedAnchor
     * @return {Object|null} {url: String, newwindow: Boolean}, or null when no
     *     anchor is selected.
     * @private
     */
    _getSelectedAnchor: function() {
        var selectednode = this.get('host').getSelectionParentNode(),
            anchornodes,
            anchornode,
            url;

        // Note this is a document fragment and YUI doesn't like them.
        if (!selectednode) {
            return null;
        }

        anchornodes = this._findSelectedAnchors(Y.one(selectednode));
        if (anchornodes.length === 0) {
            return null;
        }

        anchornode = anchornodes[0];
        this._currentSelection = this.get('host').getSelectionFromNode(anchornode);
        url = anchornode.getAttribute('href');
        if (url === '') {
            return null;
        }

        return {
            url: url,
            newwindow: anchornode.getAttribute('target') === '_blank'
        };
    },

    /**
     * Build the dialogue's DOM (overlay, chrome and iframe), wire up its
     * focus trap, and insert it into the page.
     *
     * @method _buildMeetingDialogue
     * @param {Object|null} selectedanchor Result of _getSelectedAnchor().
     * @private
     */
    _buildMeetingDialogue: function(selectedanchor) {
        var header,
            title,
            titleid = Y.guid('atto_teamsmeeting-title-'),
            self = this;

        this._overlay = Y.Node.create('<div class="atto_teamsmeeting-overlay"></div>');
        this._modalnode = Y.Node.create('<div class="atto_teamsmeeting-modal" role="dialog" aria-modal="true"></div>');
        this._modalnode.setAttribute('aria-labelledby', titleid);
        this._startsentinel = Y.Node.create('<div class="atto_teamsmeeting-sentinel" tabindex="0"></div>');
        this._startsentinel.setAttribute('aria-label', M.util.get_string('dialoguestart', COMPONENTNAME));
        this._endsentinel = Y.Node.create('<div class="atto_teamsmeeting-sentinel" tabindex="0"></div>');
        this._endsentinel.setAttribute('aria-label', M.util.get_string('dialogueend', COMPONENTNAME));
        this._closebutton = Y.Node.create('<button type="button" class="atto_teamsmeeting-modal-close">&times;</button>');
        this._closebutton.setAttribute('aria-label', M.util.get_string('closebuttontitle', 'moodle'));
        this._content = Y.Node.create('<iframe id="meetingapp"></iframe>');
        this._content.setAttribute('title', M.util.get_string('pluginname', COMPONENTNAME));

        header = Y.Node.create('<div class="atto_teamsmeeting-modal-header"></div>');
        title = Y.Node.create('<span class="atto_teamsmeeting-modal-title"></span>');
        title.setAttribute('id', titleid);
        title.set(
            'text',
            M.util.get_string(selectedanchor ? 'editteamsmeeting' : 'createteamsmeeting', COMPONENTNAME)
        );
        header.append(title);
        header.append(this._closebutton);

        this._modalnode.append(this._startsentinel);
        this._modalnode.append(header);
        this._modalnode.append(this._content);
        this._modalnode.append(this._endsentinel);
        this._overlay.append(this._modalnode);
        Y.one(document.body).append(this._overlay);

        this._restoreariahidden = hideBackgroundFromScreenReaders(this._overlay.getDOMNode());
        this._previouslyfocused = document.activeElement;

        // Wrap the trap around: tabbing forward out of the dialogue lands on
        // the end sentinel (next in DOM order after everything else) - send
        // focus back to the first real control. Shift+tabbing backward out of
        // it lands on the start sentinel - send focus into the iframe, which
        // is the most useful place to land (the browser resolves exactly
        // which control inside it gets focus).
        this._startsentinel.on('focus', function() {
            self._focusIframe();
        });
        this._endsentinel.on('focus', function() {
            if (self._closebutton) {
                self._closebutton.focus();
            }
        });
        this._closebutton.on('click', this._closeMeetingDialogue, this);

        this._onkeydown = function(e) {
            if (e.keyCode === 27) {
                // Escape.
                self._closeMeetingDialogue();
            }
        };
        this._onmessage = function(e) {
            self._handleMessage(e);
        };
        document.addEventListener('keydown', this._onkeydown, true);
        window.addEventListener('message', this._onmessage);
    },

    /**
     * Tear down the dialogue built by _buildMeetingDialogue.
     *
     * @method _closeMeetingDialogue
     * @private
     */
    _closeMeetingDialogue: function() {
        if (!this._overlay) {
            return;
        }

        document.removeEventListener('keydown', this._onkeydown, true);
        window.removeEventListener('message', this._onmessage);
        if (this._restoreariahidden) {
            this._restoreariahidden();
        }
        this._overlay.remove(true);

        this._overlay = null;
        this._modalnode = null;
        this._content = null;
        this._closebutton = null;
        this._startsentinel = null;
        this._endsentinel = null;

        if (activeDialogue.plugin === this) {
            activeDialogue.plugin = null;
        }
        if (this._previouslyfocused && document.body.contains(this._previouslyfocused)) {
            this._previouslyfocused.focus();
        }
    },

    /**
     * Move keyboard focus into the iframe, retrying a few times.
     *
     * A single attempt is usually enough, but the dialogue may not be laid
     * out yet immediately after being inserted into the DOM.
     *
     * @method _focusIframe
     * @private
     */
    _focusIframe: function() {
        var iframe = this._content,
            attempts = 0,
            tick;

        if (!iframe) {
            return;
        }
        tick = function() {
            if (iframe && document.activeElement !== iframe.getDOMNode()) {
                iframe.focus();
            }
            if (attempts++ < 6) {
                setTimeout(tick, 60);
            }
        };
        tick();
    },

    /**
     * Handle a postMessage from the iframe (result.php's "add link" button).
     *
     * @method _handleMessage
     * @param {MessageEvent} event
     * @private
     */
    _handleMessage: function(event) {
        if (!this._content || !event.data || event.data.action !== 'insertMeeting') {
            return;
        }
        // Only accept messages from the same Moodle origin (result.php), and
        // only from this dialogue's own iframe.
        if (event.origin !== window.location.origin || event.source !== this._content.getDOMNode().contentWindow) {
            return;
        }
        // Close only once the link has actually been inserted - a missing or
        // non-https URL leaves the dialogue open so the user can retry.
        if (this._insertMeetingLink(event.data.url || '', !!event.data.newWindow)) {
            this._closeMeetingDialogue();
        }
    },

    /**
     * Fetch a fresh single-use token and load the Meetings app's
     * create-meeting flow into the iframe.
     *
     * The token authenticates the app's return trip to result.php once the
     * meeting is created, in place of the (possibly dropped) session cookie.
     * It is single-use (result.php consumes it), so a fresh one is fetched
     * here for every dialogue open rather than reusing one generated at page
     * load: reusing an already-consumed token would send the user to
     * Moodle's login page instead of the confirmation screen for the second
     * (and every subsequent) meeting created on the same page.
     *
     * @method _loadNewMeeting
     * @private
     */
    _loadNewMeeting: function() {
        var tokenurl = M.cfg.wwwroot + '/lib/editor/atto/plugins/teamsmeeting/token.php';
        // Minting a token is a state-changing request, so token.php requires
        // POST with a valid sesskey (see token.php for why).
        Y.io(tokenurl, {
            method: 'POST',
            data: {
                sesskey: M.cfg.sesskey
            },
            context: this,
            timeout: 10000,
            on: {
                complete: this._insertNewMeetingSrc
            }
        });
    },

    /**
     * Point the iframe at the Meetings app's create-meeting flow, using the
     * token fetched by _loadNewMeeting.
     *
     * @method _insertNewMeetingSrc
     * @param {String} id
     * @param {EventFacade} data
     * @private
     */
    _insertNewMeetingSrc: function(id, data) {
        if (data.status === 200 && this._content) {
            var session = JSON.parse(data.responseText).session;
            this._content.set('src', this._appurl + '?url=' + this._clientdomain + '&locale=' + this._locale +
                '&msession=' + session + '&editor=atto&previewmode=options');
        }
    },

    /**
     * Look up an existing meeting's details and load them into the iframe.
     *
     * @method _loadExistingMeeting
     * @param {Object} anchordata {url, newwindow} describing the selected link.
     * @private
     */
    _loadExistingMeeting: function(anchordata) {
        var ajaxurl = M.cfg.wwwroot + '/lib/editor/atto/plugins/teamsmeeting/ajax.php';
        Y.io(ajaxurl, {
            context: this,
            data: {
                url: anchordata.url,
                newwindow: anchordata.newwindow ? 1 : 0
            },
            timeout: 10000,
            on: {
                complete: this._updateIframe
            }
        });
    },

    /**
     * The teamsmeeting iframe update.
     *
     * @method _updateIframe
     * @param {String} id
     * @param {EventFacade} data
     * @private
     */
    _updateIframe:  function(id, data) {
        if (data.status === 200 && this._content) {
            var dataobject = JSON.parse(data.responseText);
            if (dataobject[2] !== null) {
                var url = dataobject[0] + '?title=' + encodeURIComponent(dataobject[1]) +
                    '&link=' + encodeURIComponent(dataobject[2]) +
                    '&options=' + encodeURIComponent(dataobject[3]) +
                    '&viewexisting=1&newwindow=' + (dataobject[4] ? '1' : '0');
                this._content.set('src', url);
            }
        }
    },

    /**
     * Insert a new Teams meeting link, or update the currently selected one.
     *
     * @method _insertMeetingLink
     * @param {String} url The meeting join URL.
     * @param {Boolean} newwindow Whether the link should open in a new window.
     * @return {Boolean} True when a link was inserted or updated, false when
     *     the URL was missing or not an http(s) URL (nothing is changed).
     * @private
     */
    _insertMeetingLink: function(url, newwindow) {
        url = toSafeHttpsUrl(url);
        if (url === '') {
            return false;
        }

        // Add the teamsmeeting.
        this._setteamsmeetingOnSelection(url, newwindow);

        this.markUpdated();

        return true;
    },

    /**
     * Final step setting the anchor on the selection.
     *
     * @private
     * @method _setteamsmeetingOnSelection
     * @param  {String} url URL the teamsmeeting will point to.
     * @param  {Boolean} newwindow Whether the link should open in a new window.
     * @return {Node|null} The added Node, or null if no node was selected.
     */
    _setteamsmeetingOnSelection: function(url, newwindow) {
        var host = this.get('host'),
            teamsmeeting,
            selectednode,
            anchornodes;

        this.editor.focus();
        host.setSelection(this._currentSelection);

        if (this._currentSelection[0].collapsed) {
            // Firefox cannot add teamsmeetings when the selection is empty so we will add it manually.
            teamsmeeting = Y.Node.create('<a>' + url + '</a>');
            teamsmeeting.setAttribute('href', url);

            // Add the node and select it to replicate the behaviour of execCommand.
            selectednode = host.insertContentAtFocusPoint(teamsmeeting.get('outerHTML'));
            host.setSelection(host.getSelectionFromNode(selectednode));
        } else {
            document.execCommand('unlink', false, null);
            document.execCommand('createlink', false, url);

            // Now set the target.
            selectednode = host.getSelectionParentNode();
        }

        // Note this is a document fragment and YUI doesn't like them.
        if (!selectednode) {
            return null;
        }

        anchornodes = this._findSelectedAnchors(Y.one(selectednode));
        // Add new window attributes if requested.
        Y.Array.each(anchornodes, function(anchornode) {
            if (newwindow) {
                anchornode.setAttribute('target', '_blank');
            } else {
                anchornode.removeAttribute('target');
            }
        });

        return selectednode;
    },

    /**
     * Look up and down for the nearest anchor tags that are least partly contained in the selection.
     *
     * @method _findSelectedAnchors
     * @param {Node} node The node to search under for the selected anchor.
     * @return {Node|Boolean} The Node, or false if not found.
     * @private
     */
    _findSelectedAnchors: function(node) {
        var tagname = node.get('tagName'),
            hit, hits;

        // Direct hit.
        if (tagname && tagname.toLowerCase() === 'a') {
            return [node];
        }

        // Search down but check that each node is part of the selection.
        hits = [];
        node.all('a').each(function(n) {
            if (!hit && this.get('host').selectionContainsNode(n)) {
                hits.push(n);
            }
        }, this);
        if (hits.length > 0) {
            return hits;
        }
        // Search up.
        hit = node.ancestor('a');
        if (hit) {
            return [hit];
        }
        return [];
    }
}, {
    ATTRS: {
        /**
         * The domain of client.
         *
         * @attribute allowedmethods
         * @type String
         */
        clientdomain: {
            value: null
        },
        /**
         * The meeting app url.
         *
         * @attribute allowedmethods
         * @type String
         */
        appurl: {
            value: null
        },
        /**
         * User locale.
         *
         * @attribute allowedmethods
         * @type String
         */
        locale: {
            value: null
        }
    }
});
