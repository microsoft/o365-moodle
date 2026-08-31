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
 * Definition of a section heading admin setting that can be hidden with hide_if().
 *
 * @package auth_oidc
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2021 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc\adminsetting;

use admin_setting_heading;
use html_writer;

/**
 * A section heading that participates in admin settings hide_if() dependencies.
 *
 * The core {@see admin_setting_heading} renders only a bare <h3>, with no named
 * form control and no .form-item wrapper, so the admin settings show/hide
 * JavaScript (lib/amd/src/showhidesettings.js) cannot target it and any
 * hide_if() condition applied to it is silently ignored. This subclass wraps the
 * heading in a .form-item container and adds a hidden input carrying the
 * setting's form field name, so the heading is shown and hidden together with
 * the settings it introduces.
 */
class auth_oidc_admin_setting_section_heading extends admin_setting_heading {
    /**
     * Output the heading wrapped so that hide_if() dependencies can act on it.
     *
     * @param mixed $data
     * @param string $query
     * @return string
     */
    public function output_html($data, $query = '') {
        $heading = parent::output_html($data, $query);
        $hiddeninput = html_writer::empty_tag('input', [
            'type' => 'hidden',
            'name' => 's_' . $this->plugin . '_' . $this->name,
            'value' => 1,
        ]);

        return html_writer::div($hiddeninput . $heading, 'form-item', ['id' => 'admin-' . $this->name]);
    }
}
