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
 * @package assignsubmission_onenote
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace assignsubmission_onenote\privacy;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/assign/locallib.php');

use \core_privacy\local\metadata\collection;
use \core_privacy\local\metadata\provider as metadataprovider;
use \core_privacy\local\request\writer;
use \core_privacy\local\request\contextlist;
use \mod_assign\privacy\assign_plugin_request_data;

class provider implements metadataprovider, \mod_assign\privacy\assignsubmission_provider {
    /**
     * Return meta data about this plugin.
     *
     * @param  collection $collection A list of information to add to.
     * @return collection Return the collection after adding to it.
     */
    public static function get_metadata(collection $collection) : collection {
        $detail = [
            'assignment' => 'privacy:metadata:assignmentid',
            'submission' => 'privacy:metadata:submissionpurpose',
            'numfiles' => 'privacy:metadata:numfiles'
        ];
        $collection->add_database_table('assignsubmission_onenote', $detail, 'privacy:metadata:tablepurpose');
        return $collection;
    }

    /**
     * This is covered by the mod_assign provider.
     *
     * @param int $userid The user ID to get context IDs for.
     * @param \core_privacy\local\request\contextlist $contextlist Use add_from_sql with this object to add your context IDs.
     */
    public static function get_context_for_userid_within_submission(int $userid, contextlist $contextlist) {
    }

    /**
     * This is covered by the mod_assign provider.
     *
     * @param  useridlist $useridlist A user ID list object that you can append your user IDs to.
     */
    public static function get_student_user_ids(\mod_assign\privacy\useridlist $useridlist) {
    }

    /**
     * This method is used to export any user data this sub-plugin has using the assign_plugin_request_data object to get the
     * context and userid.
     * assign_plugin_request_data contains:
     * - context
     * - submission object
     * - current path (subcontext)
     * - user object
     *
     * @param  assign_plugin_request_data $exportdata Information to use to export user data for this sub-plugin.
     */
    public static function export_submission_user_data(assign_plugin_request_data $exportdata) {
        global $DB;
        if ($exportdata->get_user() != null) {
            return null;
        }

        $currentpath = $exportdata->get_subcontext();
        $currentpath[] = get_string('privacy:path', 'assignsubmission_onenote');

        $context = $exportdata->get_context();
        $submissionid = $exportdata->get_pluginobject()->id;
        $assignmentid = $exportdata->get_assign()->get_instance()->id;
        $filters = ['assignment' => $assignmentid, 'submission' => $submissionid];
        $records = $DB->get_records('assignsubmission_onenote', $filters);
        foreach ($records as $record) {
            writer::with_context($context)
                ->export_data($currentpath, $record);
        }
    }

    /**
     * Any call to this method should delete all user data for the context defined in the deletion_criteria.
     * assign_plugin_request_data contains:
     * - context
     * - assign object
     *
     * @param assign_plugin_request_data $requestdata Information to use to delete user data for this submission.
     */
    public static function delete_submission_for_context(assign_plugin_request_data $requestdata) {
        global $DB;
        $filters = ['assignment' => $requestdata->get_assign()->get_instance()->id];
        $DB->delete_records('assignsubmission_onenote', $filters);
    }

    /**
     * A call to this method should delete user data (where practicle) from the userid and context.
     * assign_plugin_request_data contains:
     * - context
     * - submission object
     * - user object
     * - assign object
     *
     * @param  assign_plugin_request_data $exportdata Details about the user and context to focus the deletion.
     */
    public static function delete_submission_for_userid(assign_plugin_request_data $deletedata) {
        global $DB;

        $submissionid = $deletedata->get_pluginobject()->id;
        $assignmentid = $deletedata->get_assign()->get_instance()->id;
        $filters = ['assignment' => $assignmentid, 'submission' => $submissionid];

        // Delete the records in the table.
        $DB->delete_records('assignsubmission_onenote', $filters);
    }
}
