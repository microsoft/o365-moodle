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
class fieldmap extends \admin_setting {

    /**
     * Constructor
     * @param string $name unique ascii name, either 'mysetting' for settings that in config,
     *                     or 'myplugin/mysetting' for ones in config_plugins.
     * @param string $visiblename localised name
     * @param string $description localised long description
     * @param mixed $defaultsetting string or array depending on implementation
     */
    public function __construct($name, $visiblename, $description, $defaultsetting) {
        global $DB;

        $this->syncbehavopts = [
            'oncreate' => get_string('update_oncreate', 'auth'),
            'onlogin' => get_string('update_onlogin', 'auth'),
            'always' => get_string('settings_fieldmap_update_always', 'local_o365'),
        ];

        $this->remotefields = [
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
            'telephoneNumber' => get_string('settings_fieldmap_field_telephoneNumber', 'local_o365'),
            'facsimileTelephoneNumber' => get_string('settings_fieldmap_field_facsimileTelephoneNumber', 'local_o365'),
            'mobile' => get_string('settings_fieldmap_field_mobile', 'local_o365'),
            'preferredLanguage' => get_string('settings_fieldmap_field_preferredLanguage', 'local_o365'),
        ];

        $this->localfields = [
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
            $this->localfields['profile_field_'.$field->shortname] = $field->name;
        }

        return parent::__construct($name, $visiblename, $description, $defaultsetting);
    }

    /**
     * Return the setting
     *
     * @return mixed returns config if successful else null
     */
    public function get_setting() {
        return unserialize($this->config_read($this->name));
    }

    /**
     * Write the setting.
     *
     * We do this manually so just pretend here.
     *
     * @param mixed $data Incoming form data.
     * @return string Always empty string representing no issues.
     */
    public function write_setting($data) {
        $newconfig = [];

        if (empty($data) || $data === $this->get_defaultsetting()) {
            $this->config_write($this->name, serialize($this->get_defaultsetting()));
            return '';
        }

        if (!isset($data['remotefield']) || !is_array($data['remotefield'])) {
            // Broken data, wipe setting.
            $this->config_write($this->name, serialize($newconfig));
            return '';
        }
        if (!isset($data['localfield']) || !is_array($data['localfield'])) {
            // Broken data, wipe setting.
            $this->config_write($this->name, serialize($newconfig));
            return '';
        }
        if (!isset($data['behavior']) || !is_array($data['behavior'])) {
            // Broken data, wipe setting.
            $this->config_write($this->name, serialize($newconfig));
            return '';
        }

        foreach ($data['remotefield'] as $i => $fieldname) {
            if (!isset($data['localfield'][$i]) || !isset($data['behavior'][$i])) {
                continue;
            }
            $newconfig[] = $data['remotefield'][$i].'/'.$data['localfield'][$i].'/'.$data['behavior'][$i];
        }
        $this->config_write($this->name, serialize($newconfig));
        return '';
    }

    /**
     * Return an XHTML string for the setting.
     *
     * @return string Returns an XHTML string
     */
    public function output_html($data, $query = '') {
        global $DB, $OUTPUT;

        $html = \html_writer::start_tag('div');

        $style = 'button.addmapping, .fieldlist select, .fieldlist button {vertical-align:middle;margin:0;}';
        $style .= '.fieldlist {margin-bottom:0.5rem;}';
        $html .= \html_writer::tag('style', $style);
        $hiddenattrs = ['type' => 'hidden', 'name' => $this->get_full_name().'[save]', 'value' => 'save'];
        $html .= \html_writer::empty_tag('input', $hiddenattrs);

        $fieldlist = new \html_table;
        $fieldlist->attributes['class'] = 'fieldlist';
        $fieldlist->head = [
            get_string('settings_fieldmap_header_remote', 'local_o365'),
            '',
            get_string('settings_fieldmap_header_local', 'local_o365'),
            get_string('settings_fieldmap_header_behavior', 'local_o365'),
        ];
        $fieldlist->data = [];

        if ($data === false) {
            $data = $this->get_defaultsetting();
        }
        if (empty($data) || !is_array($data)) {
            $data = [];
        }
        foreach ($data as $fieldmap) {
            $fieldmap = explode('/', $fieldmap);
            if (count($fieldmap) !== 3) {
                continue;
            }
            list($remotefield, $localfield, $behavior) = $fieldmap;
            if (!isset($this->remotefields[$remotefield])) {
                continue;
            }
            if (!isset($this->localfields[$localfield])) {
                continue;
            }
            if (!isset($this->syncbehavopts[$behavior])) {
                continue;
            }

            $fieldlist->data[] = [
                \html_writer::select($this->remotefields, $this->get_full_name().'[remotefield][]', $remotefield, false),
                \html_writer::tag('span', '&rarr;'),
                \html_writer::select($this->localfields, $this->get_full_name().'[localfield][]', $localfield, false),
                \html_writer::select($this->syncbehavopts, $this->get_full_name().'[behavior][]', $behavior, false),
                \html_writer::tag('button', 'X', ['class' => 'removerow']),
            ];
        }
        $html .= \html_writer::table($fieldlist);

        $html .= \html_writer::tag('button', get_string('settings_fieldmap_addmapping', 'local_o365'), ['class' => 'addmapping']);

        // Add row template.
        $maptpl = \html_writer::start_tag('tr');
        $maptpl .= \html_writer::tag('td', \html_writer::select($this->remotefields, $this->get_full_name().'[remotefield][]', ''));
        $maptpl .= \html_writer::tag('td', \html_writer::tag('span', '&rarr;'));
        $maptpl .= \html_writer::tag('td', \html_writer::select($this->localfields, $this->get_full_name().'[localfield][]', ''));
        $maptpl .= \html_writer::tag('td', \html_writer::select($this->syncbehavopts, $this->get_full_name().'[behavior][]', '', false));
        $maptpl .= \html_writer::tag('td', \html_writer::tag('button', 'X', ['class' => 'removerow']));
        $maptpl .= \html_writer::end_tag('tr');
        $html .= \html_writer::tag('textarea', htmlentities($maptpl), ['class' => 'maptpl', 'style' => 'display:none;']);

        // Using a <script> tag here instead of $PAGE->requires->js() because using $PAGE object loads file too late.
        $scripturl = new \moodle_url('/local/o365/classes/adminsetting/fieldmap.js');
        $html .= \html_writer::script('', $scripturl->out());
        $html .= \html_writer::script('$(function() { $("#admin-'.$this->name.'").fieldmap({}); });');

        $html .= \html_writer::end_tag('div');

        return format_admin_setting($this, $this->visiblename, $html, $this->description, true, '', null, $query);
    }
}