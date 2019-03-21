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
class usersyncfieldmap extends fieldmap {
    /** @var bool Use the update behavior column. */
    protected $showbehavcolumn = true;

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
    public function __construct($name, $visiblename, $description, $defaultsetting, $remotefields = [], $localfields = [], $syncbehav = [], $lockoptions = []) {
        global $DB;

        $lockoptions = [
            'unlocked' => get_string('unlocked', 'auth'),
            'unlockedifempty' => get_string('unlockedifempty', 'auth'),
            'locked'          => get_string('locked', 'auth'),
        ];

        $syncbehav = [
            'oncreate' => get_string('update_oncreate', 'auth'),
            'onlogin' => get_string('update_onlogin', 'auth'),
            'always' => get_string('settings_fieldmap_update_always', 'local_o365'),
        ];

        $remotefields = [
            'objectId' => get_string('settings_fieldmap_field_objectId', 'local_o365'),
            'displayName' => get_string('settings_fieldmap_field_displayName', 'local_o365'),
            'givenName' => get_string('settings_fieldmap_field_givenName', 'local_o365'),
            'surname' => get_string('settings_fieldmap_field_surname', 'local_o365'),
            'mail' => get_string('settings_fieldmap_field_mail', 'local_o365'),
            'streetAddress' => get_string('settings_fieldmap_field_streetAddress', 'local_o365'),
            'city' => get_string('settings_fieldmap_field_city', 'local_o365'),
            'postalCode' => get_string('settings_fieldmap_field_postalCode', 'local_o365'),
            'state' => get_string('settings_fieldmap_field_state', 'local_o365'),
            'country' => get_string('settings_fieldmap_field_country', 'local_o365'),
            'jobTitle' => get_string('settings_fieldmap_field_jobTitle', 'local_o365'),
            'department' => get_string('settings_fieldmap_field_department', 'local_o365'),
            'companyName' => get_string('settings_fieldmap_field_companyName', 'local_o365'),
            'preferredLanguage' => get_string('settings_fieldmap_field_preferredLanguage', 'local_o365'),
        ];

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

        return parent::__construct($name, $visiblename, $description, $defaultsetting, $remotefields, $localfields, $syncbehav, $lockoptions);
    }
}
