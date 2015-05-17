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

$string['pluginname'] = 'OpenID Connect';
$string['auth_oidcdescription'] = 'The OpenID Connect plugin provides single-sign-on functionality using configurable identity providers.';

$string['cfg_authendpoint_key'] = 'Auth Endpoint';
$string['cfg_authendpoint_desc'] = 'The URI of the auth endoint from your identity provider to use.';
$string['cfg_clientid_key'] = 'Client ID';
$string['cfg_clientid_desc'] = 'Your registered Client ID on the identity provider';
$string['cfg_clientsecret_key'] = 'Client Secret';
$string['cfg_clientsecret_desc'] = 'Your registered Client Secret on the identity provider. On some providers, it is also referred to as a key.';
$string['cfg_err_invalidauthendpoint'] = 'Invalid Auth Endpoint';
$string['cfg_err_invalidtokenendpoint'] = 'Invalid Token Endpoint';
$string['cfg_err_invalidclientid'] = 'Invalid client ID';
$string['cfg_err_invalidclientsecret'] = 'Invalid client secret';
$string['cfg_icon_key'] = 'Icon';
$string['cfg_icon_desc'] = 'An icon to display next to the provider name on the login page.';
$string['cfg_iconalt_o365'] = 'Office365 icon';
$string['cfg_iconalt_locked'] = 'Locked icon';
$string['cfg_iconalt_lock'] = 'Lock icon';
$string['cfg_iconalt_go'] = 'Green circle';
$string['cfg_iconalt_stop'] = 'Red circle';
$string['cfg_iconalt_user'] = 'User icon';
$string['cfg_iconalt_user2'] = 'User icon alternate';
$string['cfg_iconalt_key'] = 'Key icon';
$string['cfg_iconalt_group'] = 'Group icon';
$string['cfg_iconalt_group2'] = 'Group icon alternate';
$string['cfg_iconalt_mnet'] = 'MNET icon';
$string['cfg_iconalt_userlock'] = 'User with lock icon';
$string['cfg_iconalt_plus'] = 'Plus icon';
$string['cfg_iconalt_check'] = 'Checkmark icon';
$string['cfg_iconalt_rightarrow'] = 'Right-facing arrow icon';
$string['cfg_customicon_key'] = 'Custom Icon';
$string['cfg_customicon_desc'] = 'If you\'d like to use your own icon, upload it here. This overrides any icon chosen above. <br /><br /><b>Notes on using custom icons:</b><ul><li>This image will <b>not</b> be resized on the login page, so we recommend uploading an image no bigger than 35x35 pixels.</li><li>If you have uploaded a custom icon and want to go back to one of the stock icons, click the custom icon in the box above, then click "Delete", then click "OK", then click "Save Changes" at the bottom of this form. The selected stock icon will now appear on the Moodle login page.</li></ul>';
$string['cfg_loginflow_key'] = 'Login Flow';
$string['cfg_loginflow_authcode'] = 'Authorization Request';
$string['cfg_loginflow_authcode_desc'] = 'Using this flow, the user clicks the name of the identity provider (See "Provider Name" above) on the Moodle login page and is redirected to the provider to log in. Once successfully logged in, the user is redirected back to Moodle where the Moodle login takes place transparently. This is the most standardized, secure way for the user log in.';
$string['cfg_loginflow_rocreds'] = 'Username/Password Authentication';
$string['cfg_loginflow_rocreds_desc'] = 'Using this flow, the user enters their username and password into the Moodle login form like they would with a manual login. Their credentials are then passed to the identity provider in the background to obtain authentication. This flow is the most transparent to the user as they have no direct interaction with the identity provider. Note that not all identity providers support this flow.';
$string['cfg_opname_key'] = 'Provider Name';
$string['cfg_opname_desc'] = 'This is an end-user-facing label that identifies the type of credentials the user must use to login. This label is used throughout the user-facing portions of this plugin to identify your provider.';
$string['cfg_redirecturi_key'] = 'Redirect URI';
$string['cfg_redirecturi_desc'] = 'This is the URI to register as the "Redirect URI"<br />Your OpenID Connect identity provider should ask for this when registering Moodle as a client.';
$string['cfg_tokenendpoint_key'] = 'Token Endpoint';
$string['cfg_tokenendpoint_desc'] = 'The URI of the token endpoint from your identity provider to use.';

$string['errorauthdisconnectemptypassword'] = 'Password cannot be empty';
$string['errorauthdisconnectemptyusername'] = 'Username cannot be empty';
$string['errorauthdisconnectusernameexists'] = 'That username is already taken. Please choose a different one.';
$string['errorauthdisconnectnewmethod'] = 'Use Login Method';
$string['errorauthdisconnectinvalidmethod'] = 'Invalid login method received.';
$string['errorauthdisconnectifmanual'] = 'If using the manual login method, enter credentials below.';
$string['errorauthdisconnectinvalidmethod'] = 'Invalid login method received.';
$string['errorauthinvalididtoken'] = 'Invalid id_token received.';
$string['errorauthloginfailed'] = 'Invalid login.';
$string['errorauthnoauthcode'] = 'Auth code not received.';
$string['errorauthnocreds'] = 'Please configure OpenID Connect client credentials.';
$string['errorauthnoendpoints'] = 'Please configure OpenID Connect server endpoints.';
$string['errorauthnohttpclient'] = 'Please set an HTTP client.';
$string['errorauthnoidtoken'] = 'OIDC id_token not received.';
$string['errorauthunknownstate'] = 'Unknown state.';
$string['errorauthuseralreadyconnected'] = 'You\'re already connected to a different OpenID Connect user.';
$string['errorauthuserconnectedtodifferent'] = 'The OpenID Connect user that authenticated is already connected to a Moodle user.';
$string['errorbadloginflow'] = 'Invalid login flow specified. Note: If you are receiving this after a recent installation or upgrade, please clear your Moodle cache.';
$string['errorjwtbadpayload'] = 'Could not read JWT payload.';
$string['errorjwtcouldnotreadheader'] = 'Could not read JWT header';
$string['errorjwtempty'] = 'Empty or non-string JWT received.';
$string['errorjwtinvalidheader'] = 'Invalid JWT header';
$string['errorjwtmalformed'] = 'Malformed JWT received.';
$string['errorjwtunsupportedalg'] = 'JWS Alg or JWE not supported';
$string['erroroidcnotenabled'] = 'The OpenID Connect authentication plugin is not enabled.';
$string['errornodisconnectionauthmethod'] = 'Cannot disconnect because there is no enabled auth plugin to fall back to. (either user\'s previous login method or the manual login method).';
$string['erroroidcclientinvalidendpoint'] = 'Invalid Endpoint URI received.';
$string['erroroidcclientnocreds'] = 'Please set client credentials with setcreds';
$string['erroroidcclientnoauthendpoint'] = 'No auth endpoint set. Please set with $this->setendpoints';
$string['erroroidcclientnotokenendpoint'] = 'No token endpoint set. Please set with $this->setendpoints';
$string['erroroidcclientinsecuretokenendpoint'] = 'The token endpoint must be using SSL/TLS for this.';
$string['errorucpinvalidaction'] = 'Invalid action received.';

$string['eventuserauthed'] = 'User Authorized with OpenID Connect';
$string['eventusercreated'] = 'User created with OpenID Connect';
$string['eventuserconnected'] = 'User connected to OpenID Connect';
$string['eventuserloggedin'] = 'User Logged In with OpenID Connect';
$string['eventuserdisconnected'] = 'User disconnected from OpenID Connect';

$string['oidc:manageconnection'] = 'Manage OpenID Connect Connection';

$string['ucp_general_intro'] = 'Here you can manage your connection to {$a}. If enabled, you will be able to use your {$a} account to log in to Moodle instead of a separate username and password. Once connected, you\'ll no longer have to remember a username and password for Moodle, all log-ins will be handled by {$a}.';
$string['ucp_login_start'] = 'Start using {$a} to log in to Moodle';
$string['ucp_login_start_desc'] = 'This will switch your account to use {$a} to log in to Moodle. Once enabled, you will log in using your {$a} credentials - your current Moodle username and password will not work. You can disconnect your account at any time and return to logging in normally.';
$string['ucp_login_stop'] = 'Stop using {$a} to log in to Moodle';
$string['ucp_login_stop_desc'] = 'You are currently using {$a} to log in to Moodle. Clicking "Stop using {$a} login" will disconnect your Moodle account from {$a}. You will no longer be able to log in to Moodle with your {$a} account. You\'ll be asked to create a username and password, and from then on you will then be able to log in to Moodle directly.';
$string['ucp_login_status'] = '{$a} login is:';
$string['ucp_status_enabled'] = 'Enabled';
$string['ucp_status_disabled'] = 'Disabled';
$string['ucp_disconnect_title'] = '{$a} Disconnection';
$string['ucp_disconnect_details'] = 'This will disconnect your Moodle account from {$a}. You\'ll need to create a username and password to log in to Moodle.';
$string['ucp_title'] = '{$a} Management';
