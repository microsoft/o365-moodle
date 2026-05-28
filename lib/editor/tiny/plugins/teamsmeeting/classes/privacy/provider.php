<?php
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
 * Privacy API implementation for TinyMCE Teams Meeting plugin for Moodle.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tiny_teamsmeeting\privacy;

use context;
use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\transform;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

/**
 * Privacy API implementation for the Teams Meeting plugin.
 *
 * @package     tiny_teamsmeeting
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\core_userlist_provider,
    \core_privacy\local\request\plugin\provider {
    /**
     * Describe all data this plugin stores and the external systems it contacts.
     *
     * @param collection $collection The initialised collection to add items to.
     * @return collection The collection with information about the system.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_database_table(
            'tiny_teamsmeeting',
            [
                'userid' => 'privacy:metadata:tiny_teamsmeeting:userid',
                'contextid' => 'privacy:metadata:tiny_teamsmeeting:contextid',
                'title' => 'privacy:metadata:tiny_teamsmeeting:title',
                'link' => 'privacy:metadata:tiny_teamsmeeting:link',
                'options' => 'privacy:metadata:tiny_teamsmeeting:options',
                'timecreated' => 'privacy:metadata:tiny_teamsmeeting:timecreated',
            ],
            'privacy:metadata:tiny_teamsmeeting'
        );

        $collection->add_external_location_link(
            'msteamsapp',
            ['userlang' => 'privacy:metadata:msteamsapp:userlang'],
            'privacy:metadata:msteamsapp'
        );

        return $collection;
    }

    /**
     * Return the contexts that contain personal data for the given user.
     *
     * @param int $userid The user ID.
     * @return contextlist
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        $contextlist = new contextlist();
        $sql = 'SELECT contextid FROM {tiny_teamsmeeting} WHERE userid = :userid';
        $contextlist->add_from_sql($sql, ['userid' => $userid]);
        return $contextlist;
    }

    /**
     * Export all personal data for the user in the given approved contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export data for.
     */
    public static function export_user_data(approved_contextlist $contextlist): void {
        global $DB;

        if (!$contextlist->count()) {
            return;
        }

        $userid = $contextlist->get_user()->id;
        [$contextsql, $contextparams] = $DB->get_in_or_equal($contextlist->get_contextids(), SQL_PARAMS_NAMED);
        $contextparams['userid'] = $userid;

        $records = $DB->get_records_select(
            'tiny_teamsmeeting',
            "userid = :userid AND contextid $contextsql",
            $contextparams,
            'id ASC'
        );

        foreach ($records as $record) {
            $context = context::instance_by_id($record->contextid);
            $data = (object) [
                'title' => $record->title,
                'link' => $record->link,
                'options' => $record->options,
                'timecreated' => transform::datetime($record->timecreated),
            ];
            writer::with_context($context)->export_data(
                [get_string('pluginname', 'tiny_teamsmeeting')],
                $data
            );
        }
    }

    /**
     * Delete all personal data for all users in the given context.
     *
     * @param context $context The context to delete data in.
     */
    public static function delete_data_for_all_users_in_context(context $context): void {
        global $DB;
        $DB->delete_records('tiny_teamsmeeting', ['contextid' => $context->id]);
    }

    /**
     * Delete all personal data for the given user in the approved contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to delete data for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist): void {
        global $DB;

        if (!$contextlist->count()) {
            return;
        }

        $userid = $contextlist->get_user()->id;
        [$contextsql, $contextparams] = $DB->get_in_or_equal($contextlist->get_contextids(), SQL_PARAMS_NAMED);
        $contextparams['userid'] = $userid;

        $DB->delete_records_select(
            'tiny_teamsmeeting',
            "userid = :userid AND contextid $contextsql",
            $contextparams
        );
    }

    /**
     * Get the list of users who have data within a given context.
     *
     * @param userlist $userlist The userlist to add users to.
     */
    public static function get_users_in_context(userlist $userlist): void {
        $context = $userlist->get_context();
        $sql = 'SELECT userid FROM {tiny_teamsmeeting} WHERE contextid = :contextid';
        $userlist->add_from_sql('userid', $sql, ['contextid' => $context->id]);
    }

    /**
     * Delete personal data for multiple users within a single context.
     *
     * @param approved_userlist $userlist The approved userlist to delete data for.
     */
    public static function delete_data_for_users(approved_userlist $userlist): void {
        global $DB;

        $context = $userlist->get_context();
        [$usersql, $userparams] = $DB->get_in_or_equal($userlist->get_userids(), SQL_PARAMS_NAMED);
        $userparams['contextid'] = $context->id;

        $DB->delete_records_select(
            'tiny_teamsmeeting',
            "contextid = :contextid AND userid $usersql",
            $userparams
        );
    }
}
