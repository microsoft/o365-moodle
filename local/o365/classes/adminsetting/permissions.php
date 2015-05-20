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
 * Admin setting to detect and set permissions in AAD.
 */
class permissions extends \admin_setting {

    /**
     * Constructor.
     *
     * @param string $name Name of the setting.
     * @param string $visiblename Visible name of the setting.
     * @param string $description Description of the setting.
     * @param array $defaultsetting Default value.
     * @param array $choices Array of icon choices.
     */
    public function __construct($name, $heading, $description) {
        $this->nosave = true;
        parent::__construct($name, $heading, $description, '0');
    }

    /**
     * Return the setting
     *
     * @return mixed returns config if successful else null
     */
    public function get_setting() {
        return true;
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
        return '';
    }

    /**
     * Return an XHTML string for the setting
     * @return string Returns an XHTML string
     */
    public function output_html($data, $query = '') {
        global $CFG, $OUTPUT;

        $oidcconfig = get_config('auth_oidc');
        $clientcredspresent = (!empty($oidcconfig->clientid) && !empty($oidcconfig->clientsecret)) ? true : false;
        $endpointspresent = (!empty($oidcconfig->authendpoint) && !empty($oidcconfig->tokenendpoint)) ? true : false;
        $settinghtml = '';
        if ($clientcredspresent === true && $endpointspresent === true) {

            $existingsetting = $this->config_read($this->name);

            if (!empty($existingsetting)) {
                $icon = $OUTPUT->pix_icon('t/check', 'valid', 'moodle');
                $messageattrs = [
                    'class' => 'permmessage'
                ];
                $message = \html_writer::tag('span', get_string('settings_detectperms_valid', 'local_o365'), $messageattrs);
                $buttonattrs = [
                    'class' => 'refreshperms',
                    'style' => 'margin: 0 0 0 1rem;'
                ];
                $button = \html_writer::tag('button', get_string('settings_detectperms_update', 'local_o365'), $buttonattrs);
                $statusmessage = \html_writer::tag('div', '', ['class' => 'statusmessage']);
                $wrapperattrs = [
                    'class' => 'alert-success local_o365_statusmessage',
                    'style' => 'display: inline-block; width: 100%; box-sizing: border-box;'
                ];
                $settinghtml .= \html_writer::tag('div', $icon.$message.$button.$statusmessage, $wrapperattrs);
            } else {
                $icon = $OUTPUT->pix_icon('t/delete', 'invalid', 'moodle');
                $messageattrs = [
                    'class' => 'permmessage'
                ];
                $message = \html_writer::tag('span', get_string('settings_detectperms_invalid', 'local_o365'), $messageattrs);
                $buttonattrs = [
                    'class' => 'refreshperms',
                    'style' => 'margin: 0 0 0 1rem;'
                ];
                $button = \html_writer::tag('button', get_string('settings_detectperms_update', 'local_o365'), $buttonattrs);

                $statusmessage = \html_writer::tag('div', '', ['class' => 'statusmessage']);

                $wrapperattrs = [
                    'class' => 'alert-error local_o365_statusmessage',
                    'style' => 'display: inline-block; width: 100%; box-sizing: border-box;'
                ];
                $settinghtml .= \html_writer::tag('div', $icon.$message.$button.$statusmessage, $wrapperattrs);
            }
        } else {
            $icon = $OUTPUT->pix_icon('i/warning', 'prerequisite not complete', 'moodle');
            $message = \html_writer::tag('span', get_string('settings_detectperms_nocreds', 'local_o365'));
            $settinghtml .= \html_writer::tag('div', $icon.$message, ['class' => 'alert-info local_o365_statusmessage']);
        }

        // Using a <script> tag here instead of $PAGE->requires->js() because using $PAGE object loads file too late.
        $scripturl = new \moodle_url('/local/o365/classes/adminsetting/permissions.js');
        $settinghtml .= '<script src="'.$scripturl->out().'"></script>';

        $ajaxurl = new \moodle_url('/local/o365/ajax.php');
        $settinghtml .= '<script>
                            $(function() {
                                var opts = {
                                    url: "'.$ajaxurl->out().'",
                                    strvalid: "'.get_string('settings_detectperms_valid', 'local_o365').'",
                                    iconvalid: "'.addslashes($OUTPUT->pix_icon('t/check', 'valid', 'moodle')).'",
                                    strinvalid: "'.get_string('settings_detectperms_invalid', 'local_o365').'",
                                    iconinvalid: "'.addslashes($OUTPUT->pix_icon('t/delete', 'invalid', 'moodle')).'",
                                    strfixperms: "'.get_string('settings_detectperms_fixperms', 'local_o365').'",
                                    strerrorcheck: "'.get_string('settings_detectperms_errorcheck', 'local_o365').'",
                                    strerrorfix: "'.get_string('settings_detectperms_errorfix', 'local_o365').'",
                                    strfixprereq: "'.addslashes(get_string('settings_detectperms_fixprereq', 'local_o365')).'",
                                    strmissing: "'.get_string('settings_detectperms_missing', 'local_o365').'",
                                    strunifiedheader: "'.addslashes(get_string('settings_detectperms_unifiedheader', 'local_o365')).'",
                                    strunifiednomissing: "'.addslashes(get_string('settings_detectperms_unifiednomissing', 'local_o365')).'",
                                    strnounified: "'.addslashes(get_string('settings_detectperms_nounified', 'local_o365')).'",
                                };
                                $("#admin-'.$this->name.'").detectperms(opts);
                            });
                        </script>';

        return format_admin_setting($this, $this->visiblename, $settinghtml, $this->description, true, '', null, $query);
    }
}
