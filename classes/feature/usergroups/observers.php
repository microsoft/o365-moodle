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
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365\feature\usergroups;

class observers {

    /**
     * Get an Azure AD API instance.
     *
     * @param string $caller The calling function, used for logging.
     * @return \local_o365\rest\azuread An Azure AD API instance.
     */
    public static function get_azuread_api($caller = 'get_azuread_api') {
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();
        $resource = \local_o365\rest\azuread::get_resource();
        $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
        if (!empty($token)) {
            return new \local_o365\rest\azuread($token, $httpclient);
        } else {
            $msg = 'Couldn\'t construct azuread api client because we didn\'t have a system API user token.';
            $caller = '\local_o365\feature\usergroups\observers::'.$caller;
            \local_o365\utils::debug($msg, $caller);
            return false;
        }
    }

    /**
     * Get a Unified API instance.
     *
     * @param string $caller The calling function, used for logging.
     * @return \local_o365\rest\unified A Unified API instance.
     */
    public static function get_unified_api($caller = 'get_unified_api') {
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $httpclient = new \local_o365\httpclient();
        $resource = \local_o365\rest\unified::get_resource();
        $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
        if (!empty($token)) {
            return new \local_o365\rest\unified($token, $httpclient);
        } else {
            $msg = 'Couldn\'t construct unified api client because we didn\'t have a system API user token.';
            $caller = '\local_o365\feature\usergroups\observers::'.$caller;
            \local_o365\utils::debug($msg, $caller);
            return false;
        }
    }

    /**
     * Get stored O365 information for a Moodle user group.
     *
     * @param int $usergroupid The ID of a Moodle user group.
     * @param string $caller The calling function, used for logging.
     * @return stdClass|false The database record if found, or false if not found.
     */
    public static function get_stored_groupdata($usergroupid, $caller) {
        global $DB;
        $conditions = ['type' => 'group', 'subtype' => 'usergroup', 'moodleid' => $usergroupid];
        $groupobjectrec = $DB->get_record('local_o365_objects', $conditions);
        if (empty($groupobjectrec)) {
            $caller = '\local_o365\feature\usergroups\observers::'.$caller;
            $msg = 'Could not find stored data for moodle group with id "'.$usergroupid.'"';
            \local_o365\utils::debug($msg, $caller);
            return false;
        }
        return $groupobjectrec;
    }

    /**
     * Handle group_created event to create o365 groups.
     *
     * @param \core\event\group_created $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_group_created(\core\event\group_created $event) {
        global $DB;

        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }

        $apiclient = static::get_unified_api('handle_group_created');
        if (empty($apiclient)) {
            return false;
        }

        $usergroupid = $event->objectid;

        $grouprec = $DB->get_record('groups', ['id' => $usergroupid]);
        if (empty($grouprec)) {
            $caller = 'feature\usergroups\observers::handle_group_created';
            \local_o365\utils::debug('Could not find group with id "'.$usergroupid.'"', $caller);
            return false;
        }

        $courserec = $DB->get_record('course', ['id' => $grouprec->courseid]);
        if (empty($courserec)) {
            $msg = 'Could not find course with id "'.$grouprec->courseid.'" for group with id "'.$usergroupid.'"';
            $caller = 'feature\usergroups\observers::handle_group_created';
            \local_o365\utils::debug($msg, $caller);
            return false;
        }

        $o365groupname = $courserec->shortname.': '.$grouprec->name;

        // Create o365 group.
        try {
            $o365group = $apiclient->create_group($o365groupname);
        } catch (\Exception $e) {
            return false;
        }

        // Store group in database.
        $now = time();
        $rec = [
            'type' => 'group',
            'subtype' => 'usergroup',
            'moodleid' => $usergroupid,
            'objectid' => $o365group['id'],
            'o365name' => '',
            'timecreated' => $now,
            'timemodified' => $now,
        ];
        $DB->insert_record('local_o365_objects', $rec);
    }

    /**
     * Handle group_updated event to update o365 groups.
     *
     * @param \core\event\group_updated $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_group_updated(\core\event\group_updated $event) {
        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }
        $apiclient = static::get_unified_api('handle_group_updated');
        if (empty($apiclient)) {
            return false;
        }
    }

    /**
     * Handle group_deleted event to delete o365 groups.
     *
     * @param \core\event\group_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_group_deleted(\core\event\group_deleted $event) {
        global $DB;

        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }

        $apiclient = static::get_unified_api('handle_group_deleted');
        if (empty($apiclient)) {
            return false;
        }

        $usergroupid = $event->objectid;

        // Look up group.
        $groupobjectrec = static::get_stored_groupdata($usergroupid, 'handle_group_deleted');
        if (empty($groupobjectrec)) {
            return false;
        }

        // Delete o365 group.
        try {
            $result = $apiclient->delete_group($groupobjectrec->objectid);
        } catch (\Exception $e) {
            return false;
        }

        if ($result !== true) {
            $caller = '\local_o365\feature\usergroups\observers::handle_group_deleted';
            \local_o365\utils::debug('Couldn\'t delete group', $caller, $result);
            return false;
        } else {
            $DB->delete_records('local_o365_objects', ['id' => $groupobjectrec->id]);
        }
        return true;
    }

    /**
     * Handle group_member_added event to add a user to an o365 group.
     *
     * @param \core\event\group_member_added $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_group_member_added(\core\event\group_member_added $event) {
        global $DB;

        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }

        $unifiedapiclient = static::get_unified_api('handle_group_member_added');
        if (empty($unifiedapiclient)) {
            return false;
        }

        $azureadapiclient = static::get_azuread_api('handle_group_member_added');
        if (empty($azureadapiclient)) {
            return false;
        }

        $newmemberid = $event->relateduserid;
        $usergroupid = $event->objectid;

        // Look up group.
        $groupobjectrec = static::get_stored_groupdata($usergroupid, 'handle_group_member_added');
        if (empty($groupobjectrec)) {
            return false;
        }

        // Look up user.
        $userobjectdata = $DB->get_record('local_o365_objects', ['type' => 'user', 'moodleid' => $newmemberid]);
        if (empty($userobjectdata)) {
            $msg = 'Not adding user "'.$newmemberid.'" to group "'.$usergroupid.'" because we don\'t have Azure AD data for them.';
            $caller = '\local_o365\feature\usergroups\observers::handle_group_member_added';
            \local_o365\utils::debug($msg, $caller);
            return false;
        }

        $result = $azureadapiclient->add_member_to_group($groupobjectrec->objectid, $userobjectdata->objectid);
        if ($result !== true) {
            $msg = 'Couldn\'t add user to group.';
            $caller = '\local_o365\feature\usergroups\observers::handle_group_member_added';
            \local_o365\utils::debug($msg, $caller, $result);
            return false;
        }
        return true;
    }

    /**
     * Handle group_member_removed event to remove a user from an o365 group.
     *
     * @param \core\event\group_member_removed $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_group_member_removed(\core\event\group_member_removed $event) {
        global $DB;

        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }

        $unifiedapiclient = static::get_unified_api('handle_group_member_removed');
        if (empty($unifiedapiclient)) {
            return false;
        }

        $azureadapiclient = static::get_azuread_api('handle_group_member_removed');
        if (empty($azureadapiclient)) {
            return false;
        }

        $newmemberid = $event->relateduserid;
        $usergroupid = $event->objectid;

        // Look up group.
        $groupobjectrec = static::get_stored_groupdata($usergroupid, 'handle_group_member_removed');
        if (empty($groupobjectrec)) {
            return false;
        }

        // Look up user.
        $userobjectdata = $DB->get_record('local_o365_objects', ['type' => 'user', 'moodleid' => $newmemberid]);
        if (empty($userobjectdata)) {
            $msg = 'Not removing user "'.$newmemberid.'" from group "'.$usergroupid.'". No Azure AD data for user found.';
            $caller = '\local_o365\feature\usergroups\observers::handle_group_member_removed';
            \local_o365\utils::debug($msg, $caller);
            return false;
        }

        $result = $azureadapiclient->remove_member_from_group($groupobjectrec->objectid, $userobjectdata->objectid);
        if ($result !== true) {
            $msg = 'Couldn\'t remove user from group.';
            $caller = '\local_o365\feature\usergroups\observers::handle_group_member_removed';
            \local_o365\utils::debug($msg, $caller, $result);
            return false;
        }
        return true;
    }
}
