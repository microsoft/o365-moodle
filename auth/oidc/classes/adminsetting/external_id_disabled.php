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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Trait for admin settings that are disabled for the Microsoft Entra External ID IdP type.
 *
 * @package    auth_oidc
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc\adminsetting;

/**
 * Disables an admin setting, and ignores its submitted value, while the IdP type is Microsoft Entra External ID.
 *
 * The saved value is kept, so the setting is back as it was when another IdP type is chosen.
 */
trait external_id_disabled {
    /**
     * Save the submitted value, unless the setting is disabled for the IdP type.
     *
     * @param mixed $data The submitted value.
     * @return string Empty string on success, error message otherwise.
     */
    public function write_setting($data) {
        if (auth_oidc_is_entra_external_id()) {
            return '';
        }

        return parent::write_setting($data);
    }

    /**
     * Return the HTML of the setting, with its controls disabled for the Microsoft Entra External ID IdP type.
     *
     * The setting is wrapped in a disabled fieldset, which disables all the controls inside of it, whatever their type
     * is, without depending on the markup that the setting renders. Bootstrap removes the border and the spacing of the
     * fieldset, so the setting looks the same as without it.
     *
     * @param mixed $data The current value.
     * @param string $query Search query being highlighted.
     * @return string
     */
    public function output_html($data, $query = '') {
        $html = parent::output_html($data, $query);
        if (auth_oidc_is_entra_external_id()) {
            $html = \html_writer::tag('fieldset', $html, ['disabled' => 'disabled', 'class' => 'border-0 p-0 m-0 min-w-0']);
        }

        return $html;
    }
}
