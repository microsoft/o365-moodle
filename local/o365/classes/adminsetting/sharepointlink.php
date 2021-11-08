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
 * Admin setting to manage sharepoint link.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

require_once($CFG->dirroot.'/lib/adminlib.php');

/**
 * Admin setting to manage sharepoint link.
 */
class sharepointlink extends \admin_setting {
    /** @var mixed int means PARAM_XXX type, string is a allowed format in regex */
    public $paramtype;

    /** @var int default field size */
    public $size;

    /**
     * Config text constructor
     *
     * @param string $name unique ascii name.
     * @param string $visiblename localised
     * @param string $description long localised info
     * @param string $defaultsetting
     * @param mixed $paramtype int means PARAM_XXX type, string is a allowed format in regex
     */
    public function __construct($name, $visiblename, $description, $defaultsetting, $paramtype=PARAM_RAW) {
        $this->paramtype = $paramtype;
        $this->size = 45;
        parent::__construct($name, $visiblename, $description, $defaultsetting);
    }

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
        if ($oldvalue == $data && !empty($data)) {
            return '';
        }
        if (!empty($data)) {
            $this->config_write($this->name, $data);
            $this->config_write('sharepoint_initialized', '0');
            $sharepointinit = new \local_o365\task\sharepointinit();
            \core\task\manager::queue_adhoc_task($sharepointinit);
        } else {
            // Support default value so it doesn't prompt for setting on install.
            $this->config_write($this->name, '');
        }
        return '';
    }

    /**
     * Return an XHTML string for the setting.
     *
     * @param mixed $data
     * @param string $query
     * @return string
     */
    public function output_html($data, $query = '') {
        global $OUTPUT, $PAGE;

        $inputattrs = [
            'type' => 'text',
            'class' => 'maininput',
            'size' => $this->size,
            'id' => $this->get_id(),
            'name' => $this->get_full_name(),
            'value' => s($data),
        ];

        if (empty($data)) {
            $seturlattrs = ['class' => 'sharepointlink_seturl'];
            $viewstatusattrs = ['class' => 'local_o365_sharepointlink_viewstatus', 'style' => 'display: none'];
        } else {
            $seturlattrs = ['class' => 'sharepointlink_seturl', 'style' => 'display: none'];
            $viewstatusattrs = ['class' => 'local_o365_sharepointlink_viewstatus'];
            $inputattrs['style'] = 'display: none';
        }

        $settinghtml = \html_writer::empty_tag('input', $inputattrs);

        // UI when setting the site URL.
        $settinghtml .= \html_writer::start_tag('div', $seturlattrs);
        $message = \html_writer::tag('span', get_string('settings_sharepointlink_enterurl', 'local_o365'));
        $messageattrs = ['class' => 'local_o365_adminsetting_sharepointlink_status empty'];
        $settinghtml .= \html_writer::tag('div', $message, $messageattrs);
        $icon = $OUTPUT->pix_icon('i/ajaxloader', 'loading', 'moodle');
        $message = \html_writer::tag('span', get_string('settings_sharepointlink_status_checking', 'local_o365'));
        $messageattrs = ['class' => 'local_o365_adminsetting_sharepointlink_status checkingsite'];
        $settinghtml .= \html_writer::tag('div', $icon.$message, $messageattrs);
        $icon = $OUTPUT->pix_icon('t/delete', 'problem', 'moodle');
        $message = \html_writer::tag('span', get_string('settings_sharepointlink_status_invalid', 'local_o365'));
        $messageattrs = ['class' => 'local_o365_adminsetting_sharepointlink_status siteinvalid alert alert-error'];
        $settinghtml .= \html_writer::tag('div', $icon.$message, $messageattrs);
        $icon = $OUTPUT->pix_icon('i/warning', 'warning', 'moodle');
        $message = \html_writer::tag('span', get_string('settings_sharepointlink_status_notempty', 'local_o365'));
        $messageattrs = ['class' => 'local_o365_adminsetting_sharepointlink_status sitenotempty alert alert-info'];
        $settinghtml .= \html_writer::tag('div', $icon.$message, $messageattrs);
        $icon = $OUTPUT->pix_icon('t/check', 'success', 'moodle');
        $message = \html_writer::tag('span', get_string('settings_sharepointlink_status_valid', 'local_o365'));
        $messageattrs = ['class' => 'local_o365_adminsetting_sharepointlink_status sitevalid alert alert-success'];
        $settinghtml .= \html_writer::tag('div', $icon.$message, $messageattrs);
        $settinghtml .= \html_writer::end_tag('div', []);

        // UI when viewing connection status.
        $settinghtml .= \html_writer::start_tag('div', $viewstatusattrs);
        $settinghtml .= \html_writer::link($data, $data);
        $changestr = get_string('settings_sharepointlink_changelink', 'local_o365');
        $settinghtml .= \html_writer::link('javascript:;', $changestr, ['class' => 'changesitelink']);
        $sitesinitialized = get_config('local_o365', 'sharepoint_initialized');
        if ($sitesinitialized === '0') {
            $icon = $OUTPUT->pix_icon('i/ajaxloader', 'loading', 'moodle');
            $message = \html_writer::tag('span', get_string('settings_sharepointlink_initializing', 'local_o365'));
            $messageattrs = ['class' => 'local_o365_adminsetting_sharepointlink_message loading'];
            $settinghtml .= \html_writer::tag('div', $icon.$message, $messageattrs);
        } else if ($sitesinitialized === '1') {
            $icon = $OUTPUT->pix_icon('t/check', 'success', 'moodle');
            $message = \html_writer::tag('span', get_string('settings_sharepointlink_connected', 'local_o365'));
            $messageattrs = ['class' => 'local_o365_adminsetting_sharepointlink_message alert alert-success'];
            $settinghtml .= \html_writer::tag('div', $icon.$message, $messageattrs);
        } else {
            // Error reported.
            $icon = $OUTPUT->pix_icon('i/warning', 'error', 'moodle');
            $message = \html_writer::tag('span', get_string('settings_sharepointlink_error', 'local_o365'));
            $messageattrs = ['class' => 'local_o365_adminsetting_sharepointlink_message alert alert-error'];
            $settinghtml .= \html_writer::tag('div', $icon.$message, $messageattrs);
        }
        $settinghtml .= \html_writer::end_tag('div', []);

        // Using a <script> tag here instead of $PAGE->requires->js() because using $PAGE object loads file too late.
        $scripturl = new \moodle_url('/local/o365/classes/adminsetting/sharepointlink.js');
        $settinghtml .= '<script src="'.$scripturl->out().'"></script>';

        $ajaxurl = new \moodle_url('/local/o365/ajax.php');
        $settinghtml .= '<script>$(function() {';
        $settinghtml .= "var opts = { url: '{$ajaxurl->out()}' };";
        $settinghtml .= "$('#admin-sharepointlink').sharepointlink(opts);";
        $settinghtml .= '});</script>';

        return format_admin_setting($this, $this->visiblename, $settinghtml, $this->description);
    }
}
