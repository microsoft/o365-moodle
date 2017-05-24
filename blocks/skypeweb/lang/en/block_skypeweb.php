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
 * @package block_skypeweb
 * @author Aashay Zajriya <aashay@introp.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['pluginname'] = 'Skype Web';
$string['chat_message'] = 'Ability to receive chat, audio, and video invitations is not available in the current release.';
$string['email_placeholder'] = 'someone@example.com';
$string['lbl_button'] = 'Open Chat';
$string['lbl_chat'] = 'Chat Service';
$string['lbl_contact'] = 'Find Contact';
$string['lbl_contact_go'] = 'Go';
$string['lbl_email'] = 'Email';
$string['lbl_group'] = 'Groups';
$string['lbl_self'] = 'Self';
$string['lbl_title'] = 'Title';
$string['lbl_userfound'] = 'Found User';
$string['location_placeholder'] = 'Enter a Location';
$string['option_available'] = 'Available';
$string['option_away'] = 'Appear away';
$string['option_back'] = 'Be right back';
$string['option_busy'] = 'Busy';
$string['option_disturb'] = 'Do not disturb';
$string['settings_clientid'] = 'Client ID';
$string['settings_clientid_desc'] = 'Your Azure Active Directory application client ID.';
$string['setup_title'] = 'Setup Instructions';
$string['setup_desc'] = 'There are a few setup steps you will need to perform to set up this plugin.
    <br /><br />
<b>If you are currently using the Moodle / Microsoft Office 365 integration plugins:</b>
<ol>
    <li>Navigate to your registered Azure Active Directory application in the <a href="https://portal.azure.com" target="_blank">Azure Portal</a>.</li>
    <li>Click "All settings", then "Reply URLs".</li>
    <li>Add <b>{$a->wwwroot}/blocks/skypeweb/skypeloginreturn.php</b> to the list of reply URLs for the application. Click Save.</li>
    <li>Follow the steps in the last section to add Skype permissions.</li>
</ol>
<br />
<b>If you are not using the Moodle / Microsoft Office 365 integration plugins, and do not have an Azure Active Directory application set up:</b>
<ol>
    <li>Navigate to the <a href="https://portal.azure.com" target="_blank">Azure Portal</a>, click on "Azure Active Directory", then "App registrations".</li>
    <li>Click "New application registration".</li>
    <li>Enter a name of your choosing, and use <b>{$a->wwwroot}/blocks/skypeweb/skypeloginreturn.php</b> as the "Sign-on URL".</li>
    <li>Click "Create".</li>
    <li>Click the name of your application in the list of registered applications.</li>
    <li>Copy the value for "Application ID" into the "Client ID" setting above, and click "Save changes" on this page.</li>
    <li>Follow the steps in the next section.</li>
</ol>
<br />
<b>Add Skype permissions to your Azure Active Directory application:</b>
<ol>
    <li>Navigate to your registered Azure Active Directory application.</li>
    <li>Click "Manifest", and change "oauth2AllowImplicitFlow" from false to true. Click Save.</li>
    <li>Click "All settings", then "Required permissions".</li>
    <li>Click "Add", then "Select an API".</li>
    <li>Find "Skype for Business Online" in the list, click it, and click "Select" at the bottom of the screen.</li>
    <li>Enable all of the permissions in the "Delegated Permissions" section, and click "Select" at the bottom of the screen.</li>
    <li>Click the "Done" button.</li>
</ol>
When your Azure Active Directory application has been set up and you have entered a value for the "Client ID" setting above, you can add the Skype
Web block to any Moodle page, just like a regular block. If you are not signed in, the block will show a sign-in button. If you are
signed in, you will see your Skype information displayed.';

$string['signinerror'] = "Can't sign in, please check the user name and password.";
$string['skypelogin_button'] = 'Login To Skype';
$string['skypesdkurl'] = 'https://swx.cdn.skype.com/shared/v/1.2.9/SkypeBootstrap.js';
$string['skypeweb'] = 'Skype Web';
$string['skypeweb:addinstance'] = 'Add a new Skype Web block';
$string['skypeweb:myaddinstance'] = 'Add a new Skype Web block to the My Moodle page';
$string['start_tooltip'] = 'Start Instant Messaging';
$string['status_placeholder'] = 'What\'s happening today?';
$string['stop_tooltip'] = 'Stop Instant Messaging';
$string['type_placeholder'] = 'Type a message here';
$string['waitmessage'] = 'Please wait while system redirects to moodle ...!';
