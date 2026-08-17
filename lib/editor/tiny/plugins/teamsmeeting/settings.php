<?php
// This file is part of Moodle - https://moodle.org/
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
 * Plugin settings.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$ADMIN->add('editortiny', new admin_category('tiny_teamsmeeting', new lang_string('pluginname', 'tiny_teamsmeeting')));

$settings = new admin_settingpage('tiny_teamsmeeting_settings', new lang_string('pluginname', 'tiny_teamsmeeting'));

if ($ADMIN->fulltree) {
    $name = new lang_string('settings_meetings_app_link', 'tiny_teamsmeeting');
    $desc = new lang_string('settings_meetings_app_link_desc', 'tiny_teamsmeeting');
    $default = 'https://enomsteams.z16.web.core.windows.net';
    $setting = new admin_setting_configtext('tiny_teamsmeeting/meetingapplink', $name, $desc, $default);
    $settings->add($setting);
}
