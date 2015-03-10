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
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

require_once(__DIR__.'/lib.php');

$configkey = get_string('cfg_opname_key', 'auth_oidc');
$configdesc = get_string('cfg_opname_desc', 'auth_oidc');
$configdefault = get_string('pluginname', 'auth_oidc');
$settings->add(new admin_setting_configtext('auth_oidc/opname', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$configkey = get_string('cfg_clientid_key', 'auth_oidc');
$configdesc = get_string('cfg_clientid_desc', 'auth_oidc');
$settings->add(new admin_setting_configtext('auth_oidc/clientid', $configkey, $configdesc, '', PARAM_TEXT));

$configkey = get_string('cfg_clientsecret_key', 'auth_oidc');
$configdesc = get_string('cfg_clientsecret_desc', 'auth_oidc');
$settings->add(new admin_setting_configtext('auth_oidc/clientsecret', $configkey, $configdesc, '', PARAM_TEXT));

$configkey = get_string('cfg_authendpoint_key', 'auth_oidc');
$configdesc = get_string('cfg_authendpoint_desc', 'auth_oidc');
$configdefault = 'https://login.windows.net/common/oauth2/authorize';
$settings->add(new admin_setting_configtext('auth_oidc/authendpoint', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$configkey = get_string('cfg_tokenendpoint_key', 'auth_oidc');
$configdesc = get_string('cfg_tokenendpoint_desc', 'auth_oidc');
$configdefault = 'https://login.windows.net/common/oauth2/token';
$settings->add(new admin_setting_configtext('auth_oidc/tokenendpoint', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$configkey = get_string('cfg_redirecturi_key', 'auth_oidc');
$configdesc = get_string('cfg_redirecturi_desc', 'auth_oidc');
$settings->add(new \auth_oidc\form\adminsetting\redirecturi('auth_oidc/redirecturi', $configkey, $configdesc));

$configkey = get_string('cfg_loginflow_key', 'auth_oidc');
$configdesc = '';
$configdefault = 'authcode';
$settings->add(new \auth_oidc\form\adminsetting\loginflow('auth_oidc/loginflow', $configkey, $configdesc, $configdefault));

$configkey = get_string('cfg_icon_key', 'auth_oidc');
$configdesc = get_string('cfg_icon_desc', 'auth_oidc');
$configdefault = 'auth_oidc:o365';
$icons = [
    [
        'pix' => 'o365',
        'alt' => get_string('cfg_iconalt_o365', 'auth_oidc'),
        'component' => 'auth_oidc',
    ],
    [
        'pix' => 't/locked',
        'alt' => get_string('cfg_iconalt_locked', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/lock',
        'alt' => get_string('cfg_iconalt_lock', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/go',
        'alt' => get_string('cfg_iconalt_go', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/stop',
        'alt' => get_string('cfg_iconalt_stop', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/user',
        'alt' => get_string('cfg_iconalt_user', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'u/user35',
        'alt' => get_string('cfg_iconalt_user2', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'i/permissions',
        'alt' => get_string('cfg_iconalt_key', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'i/cohort',
        'alt' => get_string('cfg_iconalt_group', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'i/groups',
        'alt' => get_string('cfg_iconalt_group2', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'i/mnethost',
        'alt' => get_string('cfg_iconalt_mnet', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'i/permissionlock',
        'alt' => get_string('cfg_iconalt_userlock', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/more',
        'alt' => get_string('cfg_iconalt_plus', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/approve',
        'alt' => get_string('cfg_iconalt_check', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/right',
        'alt' => get_string('cfg_iconalt_rightarrow', 'auth_oidc'),
        'component' => 'moodle',
    ],
];
$settings->add(new \auth_oidc\form\adminsetting\iconselect('auth_oidc/icon', $configkey, $configdesc, $configdefault, $icons));

$configkey = get_string('cfg_customicon_key', 'auth_oidc');
$configdesc = get_string('cfg_customicon_desc', 'auth_oidc');
$setting = new admin_setting_configstoredfile('auth_oidc/customicon', $configkey, $configdesc, 'customicon');
$setting->set_updatedcallback('auth_oidc_initialize_customicon');
$settings->add($setting);