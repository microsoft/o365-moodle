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
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

$string['pluginname'] = 'OpenID Connect';
$string['auth_oidcdescription'] = 'This method uses OpenID Connect to provide single-sign-on functionality with a configurable identity providers.';

$string['cfg_authendpoint_key'] = 'Auth Endpoint';
$string['cfg_authendpoint_desc'] = 'The URI of the auth endoint to use.';
$string['cfg_clientid_key'] = 'Client ID';
$string['cfg_clientid_desc'] = 'Your registered Client ID';
$string['cfg_clientsecret_key'] = 'Client Secret';
$string['cfg_clientsecret_desc'] = 'Your registered Client Secret';
$string['cfg_opname_key'] = 'Provider Name';
$string['cfg_opname_desc'] = 'The name of the identity provider. This will be used throughout the user-facing portions of this plugin to identify your provider.';
$string['cfg_redirecturi_key'] = 'Redirect URI';
$string['cfg_redirecturi_desc'] = 'This is the URI to register as the "Redirect URI"<br />Your OpenID Connect identity provider should ask for this when registering Moodle as a client.';
$string['cfg_tokenendpoint_key'] = 'Token Endpoint';
$string['cfg_tokenendpoint_desc'] = 'The URI of the token endpoint to use.';

$string['oidc:manageconnection'] = 'Manage OpenID Connect Connection';

$string['eventuserauthed'] = 'User Authorized with OpenID Connect';
$string['eventusercreated'] = 'User created with OpenID Connect';
$string['eventuserconnected'] = 'User connected to OpenID Connect';
$string['eventuserloggedin'] = 'User Logged In with OpenID Connect';
$string['eventuserdisconnected'] = 'User disconnected from OpenID Connect';

$string['ucp_general_intro'] = 'Here you can manage your connection to {$a}. If enabled, you will be able to use your {$a} account to log in to Moodle instead of a separate username and password. Once connected, you\'ll no longer have to remember a username and password for Moodle, all log-ins will be handled by {$a}.';
$string['ucp_status'] = '{$a} is:';
$string['ucp_status_enabled'] = 'Enabled';
$string['ucp_status_disabled'] = 'Disabled';
$string['ucp_connected_disconnect'] = 'Stop using {$a}';
$string['ucp_connected_disconnect_details'] = 'Clicking the link above will disconnect your Moodle account from {$a}. You will no longer be able to log in to Moodle with your {$a} account. You\'ll be asked to create a username and password, and from then on you will then be able to log in to Moodle directly.';
$string['ucp_disconnect_title'] = '{$a} Disconnection';
$string['ucp_disconnect_details'] = 'This will disconnect your Moodle account from {$a}. You\'ll need to create a username and password to log in to Moodle.';
$string['ucp_notconnected_start'] = 'Start using {$a}';
$string['ucp_notconnected_start_details'] = '<b>Note that once connected you must use {$a} to log in</b> - your current username and password will not work. However, you can disconnect your account at any time and return to logging in normally.';
$string['ucp_title'] = '{$a} Management';
