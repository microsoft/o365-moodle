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

require_once($CFG->dirroot . '/blocks/microsoft/lib.php');
require_once($CFG->dirroot . '/blocks/microsoft/classes/admin_setting_required_url.php');

// Settings to show My Delve link in block.
$label = get_string('settings_showmydelve', 'block_microsoft');
$desc = get_string('settings_showmydelve_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showmydelve', $label, $desc, 1));

// Settings to show email link in block.
$label = get_string('settings_showemail', 'block_microsoft');
$desc = get_string('settings_showemail_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showemail', $label, $desc, 1));

// Settings to show My Forms link in block.
$label = get_string('settings_showmyforms', 'block_microsoft');
$desc = get_string('settings_showmyforms_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showmyforms', $label, $desc, 1));

// Settings to show OneNote notebook link in the block.
$label = new lang_string('settings_showonenotenotebook', 'block_microsoft');
$desc = new lang_string('settings_showonenotenotebook_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showonenotenotebook', $label, $desc, 1));

// Settings to show OneDrive link in the block.
$label = new lang_string('settings_showonedrive', 'block_microsoft');
$desc = new lang_string('settings_showonedrive_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showonedrive', $label, $desc, 1));

// Settings to show Microsoft Stream (on SharePoint) link in the block.
$label = new lang_string('settings_showmsstream', 'block_microsoft');
$desc = new lang_string('settings_showmsstream_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showmsstreamonsharepoint', $label, $desc, 1));

// Settings to show Microsoft Stream (classic) link in the block.
$label = new lang_string('settings_showmsstreamclassic', 'block_microsoft');
$desc = new lang_string('settings_showmsstreamclassic_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showmsstream', $label, $desc, 1));

// Settings to show Microsoft Teams link in the block.
$label = new lang_string('settings_showmsteams', 'block_microsoft');
$desc = new lang_string('settings_showmsteams_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showmsteams', $label, $desc, 1));

// Settings to show sways link in the block.
$label = new lang_string('settings_showsways', 'block_microsoft');
$desc = new lang_string('settings_showsways_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showsways', $label, $desc, 1));

// Settings to show Outlook Calendar sync settings link in the block.
$label = new lang_string('settings_showoutlooksync', 'block_microsoft');
$desc = new lang_string('settings_showoutlooksync_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showoutlooksync', $label, $desc, 0));

// Settings to show Settings link in the block.
$label = new lang_string('settings_showpreferences', 'block_microsoft');
$desc = new lang_string('settings_showpreferences_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showpreferences', $label, $desc, 1));

// Settings to show Microsoft 365 Connect link in the block.
$label = new lang_string('settings_showo365connect', 'block_microsoft');
$desc = new lang_string('settings_showo365connect_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showo365connect', $label, $desc, 1));

// Settings to show Microsoft 365 connection settings link in the block.
$label = new lang_string('settings_showmanageo365conection', 'block_microsoft');
$desc = new lang_string('settings_showmanageo365conection_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showmanageo365conection', $label, $desc, 0));

// Settings to show Course SharePoint site link in the block.
$label = new lang_string('settings_showcoursespsite', 'block_microsoft');
$desc = new lang_string('settings_showcoursespsite_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/settings_showcoursespsite', $label, $desc, 1));

// Settings to show Microsoft 365 download links in block.
$label = new lang_string('settings_showo365download', 'block_microsoft');
$desc = new lang_string('settings_showo365download_desc', 'block_microsoft');
$settings->add(new admin_setting_configcheckbox('block_microsoft/showo365download', $label, $desc, 1));

// Settings to customize "Get Microsoft 365" URL.
$label = new lang_string('settings_geto365link', 'block_microsoft');
$desc = new lang_string('settings_geto365link_desc', 'block_microsoft');
$default = new lang_string('settings_geto365link_default', 'block_microsoft');
$settings->add(new admin_setting_configtext('block_microsoft/settings_geto365link', $label, $desc, $default, PARAM_TEXT));

// Settings to show Request course from teams link in the block.
$label = new lang_string('settings_courserequest', 'block_microsoft');
$desc = new lang_string('settings_courserequest_desc', 'block_microsoft');
$settings->add(new \admin_setting_configcheckbox('block_microsoft/settings_courserequest', $label, $desc, 1));

// Settings to show additional Microsoft 365 and Viva app links in the block. Hidden by default.
$microsoft365apps = [
    'word', 'excel', 'powerpoint', 'vivaengage',
    'vivaglint', 'vivagoals', 'vivainsights', 'vivapulse', 'linkedin',
];
foreach ($microsoft365apps as $microsoft365app) {
    $label = new lang_string('settings_show' . $microsoft365app, 'block_microsoft');
    $desc = new lang_string('settings_show' . $microsoft365app . '_desc', 'block_microsoft');
    $settings->add(new admin_setting_configcheckbox('block_microsoft/settings_show' . $microsoft365app, $label, $desc, 0));
}

// Settings to show Viva Amplify link in the block.
// The link URL is tenant-specific and must be configured by the site administrator below.
$label = new lang_string('settings_showvivaamplify', 'block_microsoft');
$desc = new lang_string('settings_showvivaamplify_desc', 'block_microsoft');
$vivaamplifycheckbox = new admin_setting_configcheckbox('block_microsoft/settings_showvivaamplify', $label, $desc, 0);
$settings->add($vivaamplifycheckbox);

$label = new lang_string('settings_vivaamplifyurl', 'block_microsoft');
$desc = new lang_string('settings_vivaamplifyurl_desc', 'block_microsoft');
$settings->add(new block_microsoft_admin_setting_required_url(
    'block_microsoft/settings_vivaamplifyurl',
    $label,
    $desc,
    '',
    BLOCK_MICROSOFT_VIVAAMPLIFY_URL_REGEX,
    $vivaamplifycheckbox
));
$settings->hide_if(
    'block_microsoft/settings_vivaamplifyurl',
    'block_microsoft/settings_showvivaamplify',
    'notchecked'
);

// Settings to show Viva Connections link in the block.
// The link URL is tenant-specific and must be configured by the site administrator below.
$label = new lang_string('settings_showvivaconnections', 'block_microsoft');
$desc = new lang_string('settings_showvivaconnections_desc', 'block_microsoft');
$vivaconnectionscheckbox = new admin_setting_configcheckbox('block_microsoft/settings_showvivaconnections', $label, $desc, 0);
$settings->add($vivaconnectionscheckbox);

$label = new lang_string('settings_vivaconnectionsurl', 'block_microsoft');
$desc = new lang_string('settings_vivaconnectionsurl_desc', 'block_microsoft');
$settings->add(new block_microsoft_admin_setting_required_url(
    'block_microsoft/settings_vivaconnectionsurl',
    $label,
    $desc,
    '',
    BLOCK_MICROSOFT_VIVACONNECTIONS_URL_REGEX,
    $vivaconnectionscheckbox
));
$settings->hide_if(
    'block_microsoft/settings_vivaconnectionsurl',
    'block_microsoft/settings_showvivaconnections',
    'notchecked'
);

// Settings to show Viva Learning link in the block.
// The link URL is tenant-specific and must be configured by the site administrator below.
$label = new lang_string('settings_showvivalearning', 'block_microsoft');
$desc = new lang_string('settings_showvivalearning_desc', 'block_microsoft');
$vivalearningcheckbox = new admin_setting_configcheckbox('block_microsoft/settings_showvivalearning', $label, $desc, 0);
$settings->add($vivalearningcheckbox);

$label = new lang_string('settings_vivalearningurl', 'block_microsoft');
$desc = new lang_string('settings_vivalearningurl_desc', 'block_microsoft');
$settings->add(new block_microsoft_admin_setting_required_url(
    'block_microsoft/settings_vivalearningurl',
    $label,
    $desc,
    '',
    BLOCK_MICROSOFT_VIVALEARNING_URL_REGEX,
    $vivalearningcheckbox
));
$settings->hide_if(
    'block_microsoft/settings_vivalearningurl',
    'block_microsoft/settings_showvivalearning',
    'notchecked'
);
