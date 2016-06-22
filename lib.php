<?php
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
 * @author  Remote-Learner.net Inc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

/**
 * Retrieve icon image and send to the browser for display.
 *
 * @param object $course Course object.
 * @param object $cm Course module object.
 * @param object $context Context.
 * @param string $filearea File area, icon or description.
 * @param array $args Array of arguments passed.
 * @param boolean $forcedownload True if download should be fored.
 * @param array $options Array of options.
 */
function local_o365_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB;
    // Check the contextlevel is as expected - if your plugin is a block, this becomes CONTEXT_BLOCK, etc.
    if ($context->contextlevel != CONTEXT_COURSE) {
        return false;
    }

    // Make sure the filearea is one of those used by the plugin.
    if ($filearea !== 'icon' && $filearea !== 'description') {
        return false;
    }

    // Make sure the user is logged in and has access to the module (plugins that are not course modules should leave out the 'cm' part).
    require_login($course, true, $cm);

    // Item id is the office 365 group id in local_o365_coursegroupdata.
    $itemid = array_shift($args); // The first item in the $args array.

    // Extract the filename / filepath from the $args array.
    $filename = array_pop($args); // The last item in the $args array.
    if (!$args) {
        $filepath = '/'; // $args is empty => the path is '/'
    } else {
        $filepath = '/'.implode('/', $args).'/'; // $args contains elements of the filepath
    }

    // Retrieve the file from the Files API.
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_o365', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        // The file does not exist.
        return false;
    }

    send_stored_file($file, null, 0, $forcedownload, $options);
}

/**
 * Check for link connection capabilities.
 *
 * @param int $userid Moodle user id to check permissions for.
 * @param string $mode Mode to check
 *                     'link' to check for connect specific capability
 *                     'unlink' to check for disconnect capability.
 * @param boolean $require Use require_capability rather than has_capability.
 * @return boolean True if has capability.
 */
function local_o365_connectioncapability($userid, $mode = 'link', $require = false) {
    $check = $require ? 'require_capability' : 'has_capability';
    $cap = ($mode == 'link') ? 'local/o365:manageconnectionlink' : 'local/o365:manageconnectionunlink';
    $contextsys = \context_system::instance();
    $contextuser = \context_user::instance($userid);
    return has_capability($cap, $contextsys) || $check($cap, $contextuser);
}
