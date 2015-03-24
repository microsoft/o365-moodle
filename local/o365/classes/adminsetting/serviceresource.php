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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365\adminsetting;

/**
 * Admin setting to configure an o365 service.
 */
class serviceresource extends \admin_setting_configtext {
    /**
     * Return an XHTML string for the setting.
     *
     * @return string Returns an XHTML string.
     */
    public function output_html($data, $query = '') {
        global $OUTPUT;
        $settinghtml = '';

        $oidcconfig = get_config('auth_oidc');
        $clientcredspresent = (!empty($oidcconfig->clientid) && !empty($oidcconfig->clientsecret)) ? true : false;
        $endpointspresent = (!empty($oidcconfig->authendpoint) && !empty($oidcconfig->tokenendpoint)) ? true : false;

        // Input + detect button.
        $inputattrs = [
            'type' => 'text',
            'class' => 'maininput',
            'size' => 30,
            'id' => $this->get_id(),
            'name' => $this->get_full_name(),
            'value' => s($data),
        ];
        $input = \html_writer::empty_tag('input', $inputattrs);
        if ($clientcredspresent === true && $endpointspresent === true) {
            $buttonattrs = ['class' => 'detect'];
            $detectbutton = \html_writer::tag('button', 'Detect', $buttonattrs);
            $settinghtml .= \html_writer::div($input.$detectbutton);
            if (!empty($data)) {
                $icon = $OUTPUT->pix_icon('t/check', 'valid', 'moodle');
                $strvalid = get_string('settings_serviceresourceabstract_valid', 'local_o365', $this->visiblename);
                $statusmessage = \html_writer::tag('span', $strvalid, ['class' => 'statusmessage']);
                $settinghtml .= \html_writer::div($icon.$statusmessage, 'alert-success local_o365_statusmessage');
            } else {
                $icon = $OUTPUT->pix_icon('i/warning', 'valid', 'moodle');
                $strnocreds = get_string('settings_serviceresourceabstract_empty', 'local_o365');
                $statusmessage = \html_writer::tag('span', $strnocreds, ['class' => 'statusmessage']);
                $settinghtml .= \html_writer::div($icon.$statusmessage, 'alert-info local_o365_statusmessage');
            }

            // Using a <script> tag here instead of $PAGE->requires->js() because using $PAGE object loads file too late.
            $scripturl = new \moodle_url('/local/o365/classes/adminsetting/serviceresource.js');
            $settinghtml .= '<script src="'.$scripturl->out().'"></script>';

            $strvalid = get_string('settings_serviceresourceabstract_valid', 'local_o365', $this->visiblename);
            $strinvalid = get_string('settings_serviceresourceabstract_invalid', 'local_o365', $this->visiblename);
            $iconvalid = addslashes($OUTPUT->pix_icon('t/check', 'valid', 'moodle'));
            $iconinvalid = addslashes($OUTPUT->pix_icon('t/delete', 'invalid', 'moodle'));
            $ajaxurl = new \moodle_url('/local/o365/ajax.php');
            $settinghtml .= '<script>
                                $(function() {
                                    var opts = {
                                        url: "'.$ajaxurl->out().'",
                                        setting: "'.$this->name.'",
                                        strvalid: "'.$strvalid.'",
                                        strinvalid: "'.$strinvalid.'",
                                        iconvalid: "'.$iconvalid.'",
                                        iconinvalid: "'.$iconinvalid.'",
                                    };
                                    $("#admin-'.$this->name.'").serviceresource(opts);
                                });
                            </script>';
        } else {
            $settinghtml .= \html_writer::div($input);
            $icon = $OUTPUT->pix_icon('i/warning', 'valid', 'moodle');
            $strnocreds = get_string('settings_serviceresourceabstract_nocreds', 'local_o365');
            $statusmessage = \html_writer::tag('span', $strnocreds, ['class' => 'statusmessage']);
            $settinghtml .= \html_writer::div($icon.$statusmessage, 'alert-info local_o365_statusmessage');
        }

        return format_admin_setting($this, $this->visiblename, $settinghtml, $this->description);
    }
}
