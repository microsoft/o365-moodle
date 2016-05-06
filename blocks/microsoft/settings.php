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
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die;

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

// Settings to show Manage Office 365 Connection link in the block.
$label = get_string('settings_showmanageo365conection', 'block_microsoft');
$desc = get_string('settings_showmanageo365conection_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_showmanageo365conection', $label, $desc, 1));

// Settings to show Course SharePoint site link in the block.
$label = get_string('settings_showcoursespsite', 'block_microsoft');
$desc = get_string('settings_showcoursespsite_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_showcoursespsite', $label, $desc, 1));

// Settings to show Office 365 download links in block.
$label = get_string('settings_showo365download', 'block_microsoft');
$desc = get_string('settings_showo365download_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/showo365download', $label, $desc, 1));

// Settings to customize "Get Office 365" URL.
$label = get_string('settings_geto365link', 'block_microsoft');
$desc = get_string('settings_geto365link_desc', 'block_microsoft');
$default = get_string('settings_geto365link_default', 'block_microsoft');
$settings->add(new admin_setting_configtext('block_microsoft/settings_geto365link', $label, $desc, $default, PARAM_TEXT));

$title = get_string('settings_cpmanageurlsheader', 'block_microsoft');
$desc = get_string('settings_cpmanageurlsheader_desc', 'block_microsoft');
$settings->add(new admin_setting_heading('settings_cpmanageurlsheader', $title, $desc));

// Settings to show course group link in the block.
$label = get_string('settings_showcoursegroup', 'block_microsoft');
$desc = get_string('settings_showcoursegroup_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_showcoursegroup', $label, $desc, 1));

// Settings to show study groups link in the block.
$label = get_string('settings_showstudygroups', 'block_microsoft');
$desc = get_string('settings_showstudygroups_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_showstudygroups', $label, $desc, 1));

// Settings to show OneDrive link in the group control panel.
$label = get_string('settings_cpshowonedrive', 'block_microsoft');
$desc = get_string('settings_cpshowonedrive_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_cpshowonedrive', $label, $desc, 1));

// Settings to show group notebook link in the block.
$label = get_string('settings_cpshownotebook', 'block_microsoft');
$desc = get_string('settings_cpshownotebook_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_cpshownotebook', $label, $desc, 1));

// Settings to show group calendar link in the block.
$label = get_string('settings_cpshowcalendar', 'block_microsoft');
$desc = get_string('settings_cpshowcalendar_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_cpshowcalendar', $label, $desc, 1));

// Settings to show group conversations link in the block.
$label = get_string('settings_cpshowconversations', 'block_microsoft');
$desc = get_string('settings_cpshowconversations_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_cpshowconversations', $label, $desc, 1));
