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
 * Strings for component 'auth_google', language 'en'
 *
 * @package   auth_google
 * @author Jerome Mouneyrac
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Oauth2';
$string['auth_facebookclientid'] = 'Your App ID/Secret can be generated in your <a href="https://developers.facebook.com/apps/">Facebook developer page</a>:
<br/>Site URL: {$a->siteurl}
<br/>Site domain: {$a->sitedomain}';
$string['auth_facebookclientid_key'] = 'Facebook App ID';
$string['auth_facebookclientsecret'] = 'See above.';
$string['auth_facebookclientsecret_key'] = 'Facebook App secret';
$string['auth_githubclientid'] = 'Your client ID/Secret can be generated in your <a href="https://github.com/settings/applications/new">Github register application page</a>:
<br/>Homepage URL: {$a->siteurl}
<br/>Authorization callback URL: {$a->callbackurl}';
$string['auth_githubclientid_key'] = 'Github client ID';
$string['auth_githubclientsecret'] = 'See above.';
$string['auth_githubclientsecret_key'] = 'Github client secret';
$string['auth_googleclientid'] = 'Your client ID/Secret can be generated in the <a href="https://code.google.com/apis/console">Google console API</a>:
<br/>
Google console API > API Access > Create another client ID...
<br/>
Redirect URLs: {$a->redirecturls}
<br/>
Javascript origins: {$a->jsorigins}';
$string['auth_googleclientid_key'] = 'Google Client ID';
$string['auth_googleclientsecret'] = 'See above.';
$string['auth_googleclientsecret_key'] = 'Google Client secret';
$string['auth_googleipinfodbkey'] = 'IPinfoDB is a service that let you find out what is the country and city of the visitor. This setting is optional. You can subscribe to <a href="http://www.ipinfodb.com/register.php">IPinfoDB</a> to get a free key.<br/>
Website: {$a->website}';
$string['auth_googleipinfodbkey_key'] = 'IPinfoDB Key';
$string['auth_googleuserprefix'] = 'The created user\'s username will start with this prefix. On a basic Moodle site you don\'t need to change it.';
$string['auth_googleuserprefix_key'] = 'Username prefix';
$string['auth_googleoauth2description'] = 'Allow a user to connect to the site with an external service: Google/Facebook/Windows Live. The first time the user connect with an external service, a new account is created. <a href="'.$CFG->wwwroot.'/admin/search.php?query=authpreventaccountcreation">Prevent account creation when authenticating</a> <b>must</b> be unset.
<br/><br/>
<i>Warning about Windows Live: Microsoft doesn\'t tell the plugin if the user\'s email address has been verified. More info in the <a href="https://github.com/mouneyrac/auth_googleoauth2/wiki/FAQ">FAQ</a>.</i>';
$string['auth_linkedinclientid'] = 'Your API/Secret keys can be generated in your <a href="https://www.linkedin.com/secure/developer">Linkedin register application page</a>:
<br/>Website URL: {$a->siteurl}
<br/>OAuth 1.0 Accept Redirect URL: {$a->callbackurl}';
$string['auth_linkedinclientid_key'] = 'Linkedin API Key';
$string['auth_linkedinclientsecret'] = 'See above.';
$string['auth_linkedinclientsecret_key'] = 'Linkedin Secret key';
$string['auth_messengerclientid'] = 'Your Client ID/Secret can be generated in your <a href="https://account.live.com/developers/applications">Windows Live apps page</a>:
<br/>Redirect domain: {$a->domain}';
$string['auth_messengerclientid_key'] = 'Messenger Client ID';
$string['auth_messengerclientsecret'] = 'See above.';
$string['auth_messengerclientsecret_key'] = 'Messenger Client secret';

$string['auth_googlesettings'] = 'Settings';
$string['couldnotgetgoogleaccesstoken'] = 'The authentication provider sent us a communication error. Please try to sign-in again.';
$string['emailaddressmustbeverified'] = 'Your email address is not verified by the authentication method you selected. You likely have forgotten to click on a "verify email address" link that Google or Facebook should have sent you during your subscribtion to their service.';
$string['moreproviderlink'] = 'Sign-in with another service.';
$string['signinwithanaccount'] = 'Log in with:';
$string['noaccountyet'] = 'You do not have permission to use the site yet. Please contact your administrator and ask them to activate your account.';
