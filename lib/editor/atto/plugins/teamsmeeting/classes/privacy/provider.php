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
 * Privacy Subsystem implementation for atto_teamsmeeting.
 *
 * @package    atto_teamsmeeting
 * @copyright  2020 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace atto_teamsmeeting\privacy;

use context;
use context_user;
use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\transform;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

/**
 * Privacy Subsystem for atto_teamsmeeting.
 *
 * @copyright  2020 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\core_userlist_provider,
    \core_privacy\local\request\plugin\provider {
    /**
     * Return the metadata about this plugin.
     *
     * @param collection $collection The initialised collection to add items to.
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_database_table('atto_teamsmeeting', [
            'userid' => 'privacy:metadata:atto_teamsmeeting:userid',
            'title' => 'privacy:metadata:atto_teamsmeeting:title',
            'link' => 'privacy:metadata:atto_teamsmeeting:link',
            'options' => 'privacy:metadata:atto_teamsmeeting:options',
            'timecreated' => 'privacy:metadata:atto_teamsmeeting:timecreated',
        ], 'privacy:metadata:atto_teamsmeeting');

        $collection->add_external_location_link('msteamsapp', [
            'userlang' => 'privacy:metadata:msteamsapp:userlang',
        ], 'privacy:metadata:msteamsapp');

        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param int $userid The user to search.
     * @return contextlist The contextlist containing the list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        $contextlist = new contextlist();
        if (self::user_has_data($userid)) {
            $contextlist->add_user_context($userid);
        }
        return $contextlist;
    }

    /**
     * Get the list of users who have data within a context.
     *
     * @param userlist $userlist The userlist containing the list of users who have data in this context/plugin combination.
     */
    public static function get_users_in_context(userlist $userlist) {
        $context = $userlist->get_context();
        if ($context instanceof context_user && self::user_has_data($context->instanceid)) {
            $userlist->add_user($context->instanceid);
        }
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        $user = $contextlist->get_user();
        foreach ($contextlist->get_contexts() as $context) {
            if (!$context instanceof context_user || $context->instanceid != $user->id) {
                continue;
            }

            $meetings = $DB->get_records('atto_teamsmeeting', ['userid' => $user->id], 'timecreated ASC');
            if (!$meetings) {
                continue;
            }

            $data = [];
            foreach ($meetings as $meeting) {
                $data[] = (object) [
                    'title' => $meeting->title,
                    'link' => $meeting->link,
                    'options' => $meeting->options,
                    'timecreated' => transform::datetime($meeting->timecreated),
                ];
            }

            writer::with_context($context)->export_data(
                [get_string('pluginname', 'atto_teamsmeeting')],
                (object) ['meetings' => $data]
            );
        }
    }

    /**
     * Delete all user data which matches the specified context.
     *
     * @param context $context A user context.
     */
    public static function delete_data_for_all_users_in_context(context $context) {
        global $DB;
        if ($context instanceof context_user) {
            $DB->delete_records('atto_teamsmeeting', ['userid' => $context->instanceid]);
        }
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;

        $userid = $contextlist->get_user()->id;
        foreach ($contextlist->get_contexts() as $context) {
            if ($context instanceof context_user && $context->instanceid == $userid) {
                $DB->delete_records('atto_teamsmeeting', ['userid' => $userid]);
            }
        }
    }

    /**
     * Delete multiple users within a single context.
     *
     * @param approved_userlist $userlist The approved context and user information to delete information for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $context = $userlist->get_context();
        if (!$context instanceof context_user) {
            return;
        }

        if (in_array($context->instanceid, $userlist->get_userids())) {
            $DB->delete_records('atto_teamsmeeting', ['userid' => $context->instanceid]);
        }
    }

    /**
     * Whether the given user has any stored meeting records.
     *
     * @param int $userid The user id to check.
     * @return bool
     */
    protected static function user_has_data(int $userid): bool {
        global $DB;
        return $DB->record_exists('atto_teamsmeeting', ['userid' => $userid]);
    }
}
