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
 * Microsoft Entra ID user sync options.
 *
 * @package local_o365
 * @author Nagesh Tembhurnikar <nagesh@introp.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

use admin_setting_configmulticheckbox;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/lib/adminlib.php');

/**
 * Microsoft Entra ID user sync options.
 */
class usersyncoptions extends admin_setting_configmulticheckbox {
    /** @var array Array of choices value=>label */
    public $choices;

    /**
     * Constructor: uses parent::__construct
     *
     * @param string $name unique ascii name, either 'mysetting' for settings that in config, or 'myplugin/mysetting' for ones in
     * config_plugins.
     * @param string $visiblename localised
     * @param string $description long localised info
     */
    public function __construct($name, $visiblename, $description) {
        $choices = [
            'create' => new \lang_string('settings_usersync_create', 'local_o365'),
            'update' => new \lang_string('settings_usersync_update', 'local_o365'),
            'suspend' => new \lang_string('settings_usersync_suspend', 'local_o365'),
            'delete' => new \lang_string('settings_usersync_delete', 'local_o365'),
            'reenable' => new \lang_string('settings_usersync_reenable', 'local_o365'),
            'disabledsync' => new \lang_string('settings_usersync_disabledsync', 'local_o365'),
            'match' => new \lang_string('settings_usersync_match', 'local_o365'),
            'matchswitchauth' => new \lang_string('settings_usersync_matchswitchauth', 'local_o365'),
            'appassign' => new \lang_string('settings_usersync_appassign', 'local_o365'),
            'photosync' => new \lang_string('settings_usersync_photosync', 'local_o365'),
            'photosynconlogin' => new \lang_string('settings_usersync_photosynconlogin', 'local_o365'),
            'tzsync' => new \lang_string('settings_addsync_tzsync', 'local_o365'),
            'tzsynconlogin' => new \lang_string('settings_addsync_tzsynconlogin', 'local_o365'),
            'nodelta' => new \lang_string('settings_usersync_nodelta', 'local_o365'),
            'emailsync' => new \lang_string('settings_usersync_emailsync', 'local_o365'),
            'guestsync' => new \lang_string('settings_usersync_guestsync', 'local_o365'),
        ];
        parent::__construct($name, $visiblename, $description, [], $choices);
    }

    /**
     * Returns XHTML field(s) as required by choices.
     *
     * Rely on data being an array should data ever be another valid vartype with acceptable value this may cause a warning/error
     * if (!is_array($data)) would fix the problem.
     *
     * @param array $data An array of checked values
     * @param string $query
     * @return string XHTML field
     */
    public function output_html($data, $query = '') {
        global $OUTPUT;
        if (!$this->load_choices() || empty($this->choices)) {
            return '';
        }
        $default = $this->get_defaultsetting();
        if (is_null($default)) {
            $default = [];
        }
        if (is_null($data)) {
            $data = [];
        }

        $groups = [
                'general' => [
                        'title' => new \lang_string('settings_usersync_general', 'local_o365'),
                        'options' => ['create', 'update', 'appassign', 'nodelta', 'guestsync'],
                ],
                'suspension' => [
                        'title' => new \lang_string('settings_usersync_suspension', 'local_o365'),
                        'options' => ['suspend', 'delete', 'reenable', 'disabledsync'],
                ],
                'matching' => [
                        'title' => new \lang_string('settings_usersync_matching', 'local_o365'),
                        'options' => ['match', 'matchswitchauth', 'emailsync'],
                ],
                'photos' => [
                        'title' => new \lang_string('settings_usersync_photos', 'local_o365'),
                        'options' => ['photosync', 'photosynconlogin'],
                ],
                'timezone' => [
                        'title' => new \lang_string('settings_usersync_timezone', 'local_o365'),
                        'options' => ['tzsync', 'tzsynconlogin'],
                ],
        ];

        $dependents = ['delete', 'matchswitchauth'];

        $return = '<div class="form-multicheckbox">';
        $return .= '<input type="hidden" name="' . $this->get_full_name() . '[xxxxx]" value="1" />';

        foreach ($groups as $group) {
            $return .= '<h3>' . $group['title'] . '</h3>';
            $options = [];
            $defaults = [];
            foreach ($group['options'] as $key) {
                if (!isset($this->choices[$key])) {
                    continue;
                }
                $description = $this->choices[$key];
                if (!empty($data[$key])) {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                }
                if (!empty($default[$key])) {
                    $defaults[] = $description;
                }
                $helphtml = $OUTPUT->help_icon('help_user_' . $key, 'local_o365');
                $optionhtml = '<input type="checkbox" id="' . $this->get_id() . '_' . $key . '" name="' . $this->get_full_name()
                        . '[' . $key . ']" value="1" ' . $checked . ' />' . ' <label for="' . $this->get_id() . '_' . $key . '">'
                        . highlightfast($query, $description) . '</label>' . $helphtml;
                $style = (in_array($key, $dependents)) ? ' style="margin-left:20px;"' : '';
                $options[] = '<li' . $style . '>' . $optionhtml . '</li>';
            }
            if ($options) {
                $return .= '<ul>';
                $return .= implode('', $options);
                $return .= '</ul>';
            }
        }

        $return .= '</div>';

        // Add JavaScript for dependencies.
        $return .= '<script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                var suspendChk = document.getElementById("' . $this->get_id() . '_suspend");
                var deleteChk = document.getElementById("' . $this->get_id() . '_delete");
                var matchChk = document.getElementById("' . $this->get_id() . '_match");
                var matchswitchauthChk = document.getElementById("' . $this->get_id() . '_matchswitchauth");

                function updateDependencies() {
                    if (deleteChk) {
                        deleteChk.disabled = !suspendChk.checked;
                        if (!suspendChk.checked && deleteChk.checked) {
                            deleteChk.checked = false;
                        }
                    }
                    if (matchswitchauthChk) {
                        matchswitchauthChk.disabled = !matchChk.checked;
                        if (!matchChk.checked && matchswitchauthChk.checked) {
                            matchswitchauthChk.checked = false;
                        }
                    }
                }

                if (suspendChk) suspendChk.addEventListener("change", updateDependencies);
                if (matchChk) matchChk.addEventListener("change", updateDependencies);
                updateDependencies();
            });
        </script>';

        if (is_null($default)) {
            $defaultinfo = null;
        } else if (!empty($defaults)) {
            $defaultinfo = implode(', ', $defaults);
        } else {
            $defaultinfo = get_string('none');
        }

        return format_admin_setting($this, $this->visiblename, $return, $this->description, false, '', $defaultinfo, $query);
    }

    /**
     * Data cleanup before saving.
     *
     * @param array $data
     *
     * @return mixed|string
     */
    public function write_setting($data) {
        // Option 'delete' can only be set if option 'suspend' is checked.
        if (!isset($data['suspend']) && isset($data['delete'])) {
            unset($data['delete']);
        }

        // Option 'matchswitchauth' can only be set if option 'match' is checked.
        if (!isset($data['match']) && isset($data['matchswitchauth'])) {
            unset($data['matchswitchauth']);
        }

        return parent::write_setting($data);
    }
}
