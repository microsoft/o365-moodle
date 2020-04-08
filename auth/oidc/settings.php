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
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

require_once(__DIR__.'/lib.php');

$configkey = new lang_string('cfg_opname_key', 'auth_oidc');
$configdesc = new lang_string('cfg_opname_desc', 'auth_oidc');
$configdefault = new lang_string('pluginname', 'auth_oidc');
$settings->add(new admin_setting_configtext('auth_oidc/opname', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$configkey = new lang_string('cfg_clientid_key', 'auth_oidc');
$configdesc = new lang_string('cfg_clientid_desc', 'auth_oidc');
$settings->add(new admin_setting_configtext('auth_oidc/clientid', $configkey, $configdesc, '', PARAM_TEXT));

$configkey = new lang_string('cfg_clientsecret_key', 'auth_oidc');
$configdesc = new lang_string('cfg_clientsecret_desc', 'auth_oidc');
$settings->add(new admin_setting_configtext('auth_oidc/clientsecret', $configkey, $configdesc, '', PARAM_TEXT));

$configkey = new lang_string('cfg_authendpoint_key', 'auth_oidc');
$configdesc = new lang_string('cfg_authendpoint_desc', 'auth_oidc');
$configdefault = 'https://login.microsoftonline.com/common/oauth2/authorize';
$settings->add(new admin_setting_configtext('auth_oidc/authendpoint', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$configkey = new lang_string('cfg_tokenendpoint_key', 'auth_oidc');
$configdesc = new lang_string('cfg_tokenendpoint_desc', 'auth_oidc');
$configdefault = 'https://login.microsoftonline.com/common/oauth2/token';
$settings->add(new admin_setting_configtext('auth_oidc/tokenendpoint', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$configkey = new lang_string('cfg_oidcresource_key', 'auth_oidc');
$configdesc = new lang_string('cfg_oidcresource_desc', 'auth_oidc');
$configdefault = 'https://graph.windows.net';
$settings->add(new admin_setting_configtext('auth_oidc/oidcresource', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$configkey = new lang_string('cfg_oidcscope_key', 'auth_oidc');
$configdesc = new lang_string('cfg_oidcscope_desc', 'auth_oidc');
$configdefault = 'openid profile email';
$settings->add(new admin_setting_configtext('auth_oidc/oidcscope', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$configkey = new lang_string('cfg_redirecturi_key', 'auth_oidc');
$configdesc = new lang_string('cfg_redirecturi_desc', 'auth_oidc');
$settings->add(new \auth_oidc\form\adminsetting\redirecturi('auth_oidc/redirecturi', $configkey, $configdesc));

$configkey = new lang_string('cfg_autoappend_key', 'auth_oidc');
$configdesc = new lang_string('cfg_autoappend_desc', 'auth_oidc');
$configdefault = '';
$settings->add(new admin_setting_configtext('auth_oidc/autoappend', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$configkey = new lang_string('cfg_domainhint_key', 'auth_oidc');
$configdesc = new lang_string('cfg_domainhint_desc', 'auth_oidc');
$configdefault = '';
$settings->add(new admin_setting_configtext('auth_oidc/domainhint', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$configkey = new lang_string('cfg_loginflow_key', 'auth_oidc');
$configdesc = '';
$configdefault = 'authcode';
$settings->add(new \auth_oidc\form\adminsetting\loginflow('auth_oidc/loginflow', $configkey, $configdesc, $configdefault));

$configkey = new lang_string('cfg_userrestrictions_key', 'auth_oidc');
$configdesc = new lang_string('cfg_userrestrictions_desc', 'auth_oidc');
$configdefault = '';
$settings->add(new admin_setting_configtextarea('auth_oidc/userrestrictions', $configkey, $configdesc, $configdefault, PARAM_TEXT));

$label = new lang_string('cfg_debugmode_key', 'auth_oidc');
$desc = new lang_string('cfg_debugmode_desc', 'auth_oidc');
$settings->add(new \admin_setting_configcheckbox('auth_oidc/debugmode', $label, $desc, '0'));

$configkey = new lang_string('cfg_icon_key', 'auth_oidc');
$configdesc = new lang_string('cfg_icon_desc', 'auth_oidc');
$configdefault = 'auth_oidc:o365';
$icons = [
    [
        'pix' => 'o365',
        'alt' => new lang_string('cfg_iconalt_o365', 'auth_oidc'),
        'component' => 'auth_oidc',
    ],
    [
        'pix' => 't/locked',
        'alt' => new lang_string('cfg_iconalt_locked', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/lock',
        'alt' => new lang_string('cfg_iconalt_lock', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/go',
        'alt' => new lang_string('cfg_iconalt_go', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/stop',
        'alt' => new lang_string('cfg_iconalt_stop', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/user',
        'alt' => new lang_string('cfg_iconalt_user', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'u/user35',
        'alt' => new lang_string('cfg_iconalt_user2', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'i/permissions',
        'alt' => new lang_string('cfg_iconalt_key', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'i/cohort',
        'alt' => new lang_string('cfg_iconalt_group', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'i/groups',
        'alt' => new lang_string('cfg_iconalt_group2', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'i/mnethost',
        'alt' => new lang_string('cfg_iconalt_mnet', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 'i/permissionlock',
        'alt' => new lang_string('cfg_iconalt_userlock', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/more',
        'alt' => new lang_string('cfg_iconalt_plus', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/approve',
        'alt' => new lang_string('cfg_iconalt_check', 'auth_oidc'),
        'component' => 'moodle',
    ],
    [
        'pix' => 't/right',
        'alt' => new lang_string('cfg_iconalt_rightarrow', 'auth_oidc'),
        'component' => 'moodle',
    ],
];
$settings->add(new \auth_oidc\form\adminsetting\iconselect('auth_oidc/icon', $configkey, $configdesc, $configdefault, $icons));

$configkey = new lang_string('cfg_customicon_key', 'auth_oidc');
$configdesc = new lang_string('cfg_customicon_desc', 'auth_oidc');
$setting = new admin_setting_configstoredfile('auth_oidc/customicon', $configkey, $configdesc, 'customicon');
$setting->set_updatedcallback('auth_oidc_initialize_customicon');
$settings->add($setting);