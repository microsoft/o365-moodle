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
 * Admin setting for a URL that becomes mandatory once a companion checkbox setting is enabled.
 *
 * @package block_microsoft
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

/**
 * Admin setting for a URL that becomes mandatory once a companion checkbox setting is enabled.
 *
 * This must only be required (directly or indirectly) from settings.php, since admin_setting_configtext
 * is only guaranteed to be loaded in the admin settings context.
 */
class block_microsoft_admin_setting_required_url extends admin_setting_configtext {
    /** @var admin_setting_configcheckbox The checkbox setting that makes this URL mandatory when checked. */
    protected $requiredifsetting;

    /**
     * Constructor.
     *
     * @param string $name Setting name, in the 'component/settingname' format.
     * @param string $visiblename Localised setting name.
     * @param string $description Localised setting description.
     * @param string $defaultsetting Default value.
     * @param string $paramtype PARAM_XXX type, or a '/regex/' string.
     * @param admin_setting_configcheckbox $requiredifsetting The checkbox setting that makes this URL mandatory
     *                                                         when checked.
     */
    public function __construct(
        $name,
        $visiblename,
        $description,
        $defaultsetting,
        $paramtype,
        admin_setting_configcheckbox $requiredifsetting
    ) {
        parent::__construct($name, $visiblename, $description, $defaultsetting, $paramtype);
        $this->requiredifsetting = $requiredifsetting;
    }

    /**
     * Validate the submitted URL, also requiring a non-empty value when the companion checkbox is checked.
     *
     * @param string $data
     * @return string|true True if valid, otherwise an error message.
     */
    public function validate($data) {
        $parentvalidation = parent::validate($data);
        if ($parentvalidation !== true) {
            return $parentvalidation;
        }

        $checkboxname = $this->requiredifsetting->get_full_name();
        $checkboxvalue = optional_param($checkboxname, $this->requiredifsetting->no, PARAM_RAW);
        $ischecked = ((string) $checkboxvalue === (string) $this->requiredifsetting->yes);

        if ($ischecked && trim((string) $data) === '') {
            return get_string('error_urlrequiredwhenenabled', 'block_microsoft');
        }

        return true;
    }
}
