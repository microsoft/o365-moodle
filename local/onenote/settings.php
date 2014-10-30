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
 * Local onenote settings.
 *
 * @package    local_onenote
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_onenote', 'Microsoft OneNote');
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_configtext('local_onenote_clientid', get_string('clientid', 'local_onenote'),
                   get_string('clientiddetails', 'local_onenote'), '', PARAM_ALPHANUMEXT));
    $settings->add(new admin_setting_configtext('local_onenote_clientsecret', get_string('clientsecret', 'local_onenote'),
                   get_string('clientsecretdetails', 'local_onenote'), '', PARAM_ALPHANUMEXT));
    $settings->add(new admin_setting_configtext('local_onenote_redirect', get_string('redirect', 'local_onenote'),
                   get_string('redirectdetails', 'local_onenote'), '', PARAM_URL));
}
