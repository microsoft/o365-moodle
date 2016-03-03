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
 * Microsoft block settings.
 *
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

defined('MOODLE_INTERNAL') || die;

// Settings to show Office 365 download links in block.
$label = get_string('settings_showo365download', 'block_microsoft');
$desc = get_string('settings_showo365download_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/showo365download', $label, $desc, 1));

// Settings to show OneNote notebook link in the block.
$label = get_string('settings_showonenotenotebook', 'block_microsoft');
$desc = get_string('settings_showonenotenotebook_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_showonenotenotebook', $label, $desc, 1));

// Settings to show Configure Outlook sync link in the block.
$label = get_string('settings_showoutlooksync', 'block_microsoft');
$desc = get_string('settings_showoutlooksync_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_showoutlooksync', $label, $desc, 1));

// Settings to show Preferences link in the block.
$label = get_string('settings_showpreferences', 'block_microsoft');
$desc = get_string('settings_showpreferences_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_showpreferences', $label, $desc, 1));

// Settings to show Office 365 Connect link in the block.
$label = get_string('settings_showo365connect', 'block_microsoft');
$desc = get_string('settings_showo365connect_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_showo365connect', $label, $desc, 1));
