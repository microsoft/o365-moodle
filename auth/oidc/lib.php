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
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

function auth_oidc_initialize_customicon($filefullname) {
    global $CFG;
    $file = get_config('auth_oidc', 'customicon');
    $systemcontext = \context_system::instance();
    $fullpath = "/{$systemcontext->id}/auth_oidc/customicon/0{$file}";

    $fs = get_file_storage();
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }
    $pixpluginsdir = 'pix_plugins/auth/oidc/0';
    $pixpluginsdirparts = explode('/', $pixpluginsdir);
    $curdir = $CFG->dataroot;
    foreach ($pixpluginsdirparts as $dir) {
        $curdir .= '/'.$dir;
        if (!file_exists($curdir)) {
            mkdir($curdir);
        }
    }

    if (file_exists($CFG->dataroot.'/pix_plugins/auth/oidc/0')) {
        $file->copy_content_to($CFG->dataroot.'/pix_plugins/auth/oidc/0/customicon.jpg');
        theme_reset_all_caches();
    }
}

/**
 * Check for connection abilities.
 *
 * @param int $userid Moodle user id to check permissions for.
 * @param string $mode Mode to check
 *                     'connect' to check for connect specific capability
 *                     'disconnect' to check for disconnect capability.
 *                     'both' to check for disconnect and connect capability.
 * @param boolean $require Use require_capability rather than has_capability.
 * @return boolean True if has capability.
 */
function auth_oidc_connectioncapability($userid, $mode = 'connect', $require = false) {
    $check = 'has_capability';
    if ($require) {
        // If requiring the capability and user has manageconnection than checking connect and disconnect is not needed.
        $check = 'require_capability';
        if (has_capability('auth/oidc:manageconnection', \context_user::instance($userid), $userid)) {
            return true;
        }
    } else if ($check('auth/oidc:manageconnection', \context_user::instance($userid), $userid)) {
        return true;
    }

    $result = false;
    switch ($mode) {
        case "connect":
            $result = $check('auth/oidc:manageconnectionconnect', \context_user::instance($userid), $userid);
            break;
        case "disconnect":
            $result = $check('auth/oidc:manageconnectiondisconnect', \context_user::instance($userid), $userid);
            break;
        case "both":
            $result = $check('auth/oidc:manageconnectionconnect', \context_user::instance($userid), $userid);
            $result = $result && $check('auth/oidc:manageconnectiondisconnect', \context_user::instance($userid), $userid);
    }
    if ($require) {
        return true;
    }
    return $result;
}

/**
 * Determine if local_o365 plugins is installed.
 *
 * @return bool
 */
function auth_oidc_is_local_365_installed() {
    global $CFG, $DB;

    $dbmanager = $DB->get_manager();

    return file_exists($CFG->dirroot . '/local/o365/version.php') &&
        $DB->record_exists('config_plugins', ['plugin' => 'local_o365', 'name' => 'version']) &&
        $dbmanager->table_exists('local_o365_objects') &&
        $dbmanager->table_exists('local_o365_connections');
}
