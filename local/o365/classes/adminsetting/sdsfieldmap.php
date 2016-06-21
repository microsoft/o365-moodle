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
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

global $CFG;
require_once($CFG->dirroot.'/lib/adminlib.php');

/**
 * Admin setting to control field mappings for users.
 */
class sdsfieldmap extends fieldmap {
    /** string The string ID to use for the remote field column. */
    protected $remotefieldstrid = 'settings_sds_fieldmap_remotecolumn';

    /**
     * Constructor
     * @param string $name unique ascii name, either 'mysetting' for settings that in config,
     *                     or 'myplugin/mysetting' for ones in config_plugins.
     * @param string $visiblename localised name
     * @param string $description localised long description
     * @param mixed $defaultsetting string or array depending on implementation
     * @param array $remotefields Array of remote fields (ignored + overridden in this child class)
     * @param array $localfields Array of local fields (ignored + overridden in this child class)
     * @param array $syncbehav Array of sync behaviours. (ignored + overridden in this child class)
     */
    public function __construct($name, $visiblename, $description, $defaultsetting, $remotefields = [], $localfields = [], $syncbehav = []) {
        global $DB;

        $syncbehav = [
            'oncreate' => get_string('update_oncreate', 'auth'),
            'onlogin' => get_string('update_onlogin', 'auth'),
            'always' => get_string('settings_fieldmap_update_always', 'local_o365'),
        ];

        $sdsfields = [
            'mailNickname',
            'userPrincipalName',
            'givenName',
            'surname',
            'pre_MiddleName',
            'pre_SyncSource_StudentId',
            'pre_SyncSource_SchoolId',
            'pre_Email',
            'pre_StateId',
            'pre_StudentNumber',
            'pre_MailingAddress',
            'pre_MailingCity',
            'pre_MailingState',
            'pre_MailingZip',
            'pre_MailingLatitude',
            'pre_MailingLongitude',
            'pre_MailingCountry',
            'pre_ResidenceAddress',
            'pre_ResidenceCity',
            'pre_ResidenceState',
            'pre_ResidenceZip',
            'pre_ResidenceLatitude',
            'pre_ResidenceLongitude',
            'pre_ResidenceCountry',
            'pre_Gender',
            'pre_DateOfBirth',
            'pre_Grade',
            'pre_EnglishLanguageLearnersStatus',
            'pre_FederalRace',
            'pre_GraduationYear',
            'pre_StudentStatus',
            'pre_AnchorId',
            'pre_ObjectType',
        ];
        $remotefields = [];
        foreach ($sdsfields as $field) {
            $remotefields[$field] = get_string('settings_sds_fieldmap_f_'.$field, 'local_o365');
        }

        $localfields = [
            'idnumber' => get_string('idnumber'),
            'firstname' => get_string('firstname'),
            'lastname' => get_string('lastname'),
            'email' => get_string('email'),
            'address' => get_string('address'),
            'city' => get_string('city'),
            'country' => get_string('country'),
            'department' => get_string('department'),
            'institution' => get_string('institution'),
            'phone1' => get_string('phone'),
            'phone2' => get_string('phone2'),
            'lang' => get_string('language'),
            'theme' => get_string('theme'),
        ];
        $customfields = $DB->get_records_select('user_info_field', 'datatype = ? OR datatype = ?', ['text', 'textarea']);
        foreach ($customfields as $field) {
            $localfields['profile_field_'.$field->shortname] = $field->name;
        }

        return parent::__construct($name, $visiblename, $description, $defaultsetting, $remotefields, $localfields, $syncbehav);
    }
}
