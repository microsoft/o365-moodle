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

namespace auth_oidc\privacy;

use \core_privacy\local\metadata\collection;
use \core_privacy\local\request\contextlist;
use \core_privacy\local\request\approved_contextlist;
use \core_privacy\local\request\writer;

class provider implements
    \core_privacy\local\request\plugin\provider,
    \core_privacy\local\metadata\provider {

    /**
     * Returns meta data about this system.
     *
     * @param   collection     $collection The initialised collection to add items to.
     * @return  collection     A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection): collection {

        $tables = [
            'auth_oidc_prevlogin' => [
                'userid',
                'method',
                'password',
            ],
            'auth_oidc_token' => [
                'oidcuniqid',
                'username',
                'userid',
                'oidcusername',
                'scope',
                'resource',
                'authcode',
                'token',
                'expiry',
                'refreshtoken',
                'idtoken',
            ],
        ];

        foreach ($tables as $table => $fields) {
            $fielddata = [];
            foreach ($fields as $field) {
                $fielddata[$field] = 'privacy:metadata:'.$table.':'.$field;
            }
            $collection->add_database_table(
                $table,
                $fielddata,
                'privacy:metadata:'.$table
            );
        }

        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param   int         $userid     The user to search.
     * @return  contextlist   $contextlist  The contextlist containing the list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid) : contextlist {
        $contextlist = new \core_privacy\local\request\contextlist();
        $contextlist->add_system_context();
        return $contextlist;
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param   approved_contextlist    $contextlist    The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;
        $user = $contextlist->get_user();
        $context = \context_system::instance();
        $tables = static::get_table_user_map($user);
        foreach ($tables as $table => $filterparams) {
            $records = $DB->get_recordset($table, $filterparams);
            foreach ($records as $record) {
                writer::with_context($context)->export_data([], $record);
            }
        }
    }

    /**
     * Delete all data for all users in the specified context.
     *
     * @param   context                 $context   The specific context to delete data for.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        // We only have data at the system context.
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param   approved_contextlist    $contextlist    The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;
        $user = $contextlist->get_user();
        $tables = static::get_table_user_map($user);
        foreach ($tables as $table => $filterparams) {
            $DB->delete_records($table, $filterparams);
        }
    }

    /**
     * Get a map of database tables that contain user data, and the filters to get records for a user.
     *
     * @param \stdClass $user The user to get the map for.
     * @return array The table user map.
     */
    protected static function get_table_user_map(\stdClass $user): array {
        $tables = [
            'auth_oidc_prevlogin' => ['userid' => $user->id],
            'auth_oidc_token' => ['userid' => $user->id],
        ];
        return $tables;
    }
}
