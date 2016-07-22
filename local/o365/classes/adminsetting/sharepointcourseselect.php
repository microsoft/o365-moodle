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
 * @author Amy Groshek <amy.groshek@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

global $CFG;
require_once($CFG->dirroot.'/lib/adminlib.php');

/**
 * Admin setting to configure sharepoint course selection.
 */
class sharepointcourseselect extends \admin_setting {
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
        $oldvalue = get_config($this->plugin, $this->name);
        $this->config_write($this->name, $data);
        if ($data === 'onall' && $oldvalue !== 'onall') {
            $this->config_write('sharepoint_initialized', '0');
            $sharepointinit = new \local_o365\task\sharepointinit();
            \core\task\manager::queue_adhoc_task($sharepointinit);
        }
        return '';
    }

    /**
     * Return an XHTML string for the setting.
     *
     * @return string Returns an XHTML string
     */
    public function output_html($data, $query = '') {
        $settinghtml = '';

        $customizeurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'sharepointcourseselect']);
        $options = [
            'none' => get_string('acp_sharepointcourseselect_none', 'local_o365'),
            'oncustom' => get_string('acp_sharepointcourseselect_oncustom', 'local_o365', $customizeurl->out()),
            'onall' => get_string('acp_sharepointcourseselect_onall', 'local_o365'),
        ];

        $curval = (isset($options[$data])) ? $data : $this->get_defaultsetting();
        $displayclass = 'link-disabled';
        if ($curval === 'oncustom') {
            $displayclass = '';
        }

        foreach ($options as $key => $desc) {
            $radioattrs = [
                'type' => 'radio',
                'id' => $this->get_id().'_'.$key,
                'name' => $this->get_full_name(),
                'value' => $key,
            ];
            if ($curval === $key) {
                $radioattrs['checked'] = 'checked';
            }
            $settinghtml .= \html_writer::empty_tag('input', $radioattrs);
            $settinghtml .= \html_writer::label($desc, $this->get_id().'_'.$key, false, array('class' => $displayclass));
            $settinghtml .= \html_writer::empty_tag('br');
            $settinghtml .= \html_writer::empty_tag('br');
        }
        return format_admin_setting($this, $this->visiblename, $settinghtml, $this->description);
    }
}
