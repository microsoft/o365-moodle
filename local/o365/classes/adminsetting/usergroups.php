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
 * Admin setting to configure user groups.
 */
class usergroups extends \admin_setting {
    /**
     * Return the setting
     *
     * @return mixed returns config if successful else null
     */
    public function get_setting() {
        return $this->config_read($this->name);
    }

    /**
     * Store new setting
     *
     * @param mixed $data string or array, must not be NULL
     * @return string empty string if ok, string error message otherwise
     */
    public function write_setting($data) {
        $this->config_write($this->name, $data);
        return '';
    }

    /**
     * Return an XHTML string for the setting.
     *
     * @return string Returns an XHTML string
     */
    public function output_html($data, $query = '') {
        $settinghtml = '';

        $customizeurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'usergroupcustom']);
        $options = [
            'off' => get_string('acp_usergroupcustom_off', 'local_o365'),
            'oncustom' => get_string('acp_usergroupcustom_oncustom', 'local_o365', $customizeurl->out()),
            'onall' => get_string('acp_usergroupcustom_onall', 'local_o365'),
        ];
        $curval = (isset($options[$data])) ? $data : $this->get_defaultsetting();
        foreach ($options as $key => $desc) {
            $radioattrs = [
                'type' => 'radio',
                'id' => $this->get_id().'_'.$key,
                'name' => $this->get_full_name(),
                'value' => $key,
                'onchange' => 'teams_togglecustom()',
                'class' => 'acpoption',
            ];
            if ($curval === $key) {
                $radioattrs['checked'] = 'checked';
            }
            $settinghtml .= \html_writer::empty_tag('input', $radioattrs);
            $settinghtml .= \html_writer::label($desc, $this->get_id().'_'.$key, false);
            $settinghtml .= \html_writer::empty_tag('br');
            $settinghtml .= \html_writer::empty_tag('br');
        }
        $js = 'function teams_togglecustom() { if ($("#id_s_local_o365_createteams_oncustom").is(":checked")) { console.log("custom on"); $("#adminsetting_teams").show(); } else { console.log("custom off"); $("#adminsetting_teams").hide(); } };';
        $js .= 'teams_togglecustom();';
        $settinghtml .= \html_writer::script($js);
        return format_admin_setting($this, $this->visiblename, $settinghtml, $this->description);
    }
}
