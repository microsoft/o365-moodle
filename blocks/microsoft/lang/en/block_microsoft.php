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
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['pluginname'] = 'Microsoft block';
$string['contactadmin'] = 'Contact administrator for more information.';
$string['error_nomoodlenotebook'] = 'Could not find your Moodle notebook.';
$string['linkonedrive'] = 'My OneDrive';
$string['linkonenote'] = 'My OneNote Notebook';
$string['linksways'] = 'My Sways';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'My Email';
$string['linkdocsdotcom'] = 'My Docs.com';
$string['linkonenote_unavailable'] = 'OneNote unavailable';
$string['linkcoursegroup'] = 'Course Group';
$string['linksharepoint'] = 'Course SharePoint site';
$string['linkoutlook'] = 'Outlook Calendar sync settings';
$string['linkprefs'] = 'Edit settings';
$string['linkconnection'] = 'Office&nbsp;365 connection settings';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = 'Add a new Microsoft block';
$string['microsoft:myaddinstance'] = 'Add a New Microsoft block to the My Moodle page';
$string['microsoft:viewgroups'] = 'Allow the ablity to view the groups control panel';
$string['microsoft:managegroups'] = 'Allow the ablity to manage groups';
$string['notebookname'] = 'Moodle Notebook';
$string['opennotebook'] = 'Open your notebook';
$string['workonthis'] = 'Work on this';
$string['o365matched_title'] = 'You are <span style="color: #960">almost</span> connected to Office&nbsp;365';
$string['o365matched_desc'] = 'You have been matched with the Office&nbsp;365 user <b>"{$a}"</b>';
$string['o365matched_complete_userpass'] = 'To complete the connection, please enter the password for this Office&nbsp;365 user and click "Connect"';
$string['o365matched_complete_authreq'] = 'To complete the connection, please click the link below and log in to this Office&nbsp;365 account.';
$string['o365connected'] = '{$a->firstname} you are currently <span class="notifysuccess">connected</span> to Office&nbsp;365';
$string['notconnected'] = 'You are <span class="notifyproblem">not connected</span> to any Microsoft services.';
$string['cachedef_onenotenotebook'] = 'Stores OneNote notebook.';
$string['cachedef_groups'] = 'Caches Office 365 group information.';
$string['msalogin'] = 'Log in with Microsoft Account';
$string['logintoo365'] = 'Log in to Office&nbsp;365';
$string['connecttoo365'] = 'Connect to Office 365';
$string['geto365'] = 'Install Office';
$string['settings_showemail'] = 'Show "My Email"';
$string['settings_showemail_desc'] = 'Enable or disable the "My Email" link in the block.';
$string['settings_showmydelve'] = 'Show "My Delve"';
$string['settings_showmydelve_desc'] = 'Enable or disable the "My Delve" link in the block.';
$string['settings_showmyforms'] = 'Show "My Forms"';
$string['settings_showmyforms_desc'] = 'Enable or disable the "My Forms" link in the block.';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = 'Show "Install Office"';
$string['settings_showo365download_desc'] = 'Enable or disable the "Install Office" link in the block.';
$string['settings_showdocsdotcom'] = 'Show "My Docs.com"';
$string['settings_showdocsdotcom_desc'] = 'Enable or disable the "My Docs.com" link in the block.';
$string['settings_showsways'] = 'Show "My Sways"';
$string['settings_showsways_desc'] = 'Enable or disable the "My Sways" link in the block.';
$string['settings_showmsstream'] = 'Show "Microsoft Stream"';
$string['settings_showmsstream_desc'] = 'Enable or disable the "Microsoft Stream" link in the block.';
$string['settings_showmsteams'] = 'Show "Microsoft Teams"';
$string['settings_showmsteams_desc'] = 'Enable or disable the "Microsoft Teams" link in the block.';
$string['settings_showonedrive'] = 'Show "My OneDrive"';
$string['settings_showonedrive_desc'] = 'Enable or disable the "My OneDrive" link in the block.';
$string['settings_showonenotenotebook'] = 'Show "My OneNote Notebook"';
$string['settings_showonenotenotebook_desc'] = 'Enable or disable the "My OneNote Notebook" link in the block.';
$string['settings_showoutlooksync'] = 'Show "Outlook Calendar sync settings"';
$string['settings_showoutlooksync_desc'] = 'Enable or disable the "Outlook Calendar sync settings" link in the block.';
$string['settings_showpreferences'] = 'Show "Edit Settings"';
$string['settings_showpreferences_desc'] = 'Enable or disable the "Edit Settings" link in the block.';
$string['settings_showo365connect'] = 'Show "Connect to Office 365"';
$string['settings_showo365connect_desc'] = 'Enable or disable the "Connect to Office 365" link in the block. <br /><b>Note:</b> This is shown to users who are not connected to Office 365 and takes them to the page that allows them to set up a connection.';
$string['settings_showmanageo365conection'] = 'Show "Office 365 connection settings"';
$string['settings_showmanageo365conection_desc'] = 'Enable or disable the "Office 365 connection settings" link in the block. <br /><b>Note:</b> This is shown to Office 365 connected users and takes them to connection management page.';
$string['settings_showcoursespsite'] = 'Show "Course SharePoint site"';
$string['settings_showcoursespsite_desc'] = 'Enable or disable the "Course SharePoint site" link in the block. <br /><b>Note:</b> This is shown in the block when viewing a course that has an associated SharePoint site.';
$string['settings_showcoursegroup'] = 'Show "Course Group"';
$string['settings_showcoursegroup_desc'] = 'Enable or disable the "Course Group" link in the block. <br /><b>Note:</b> This is shown when viewing a course that has an associated Office 365 group.';
$string['defaultprofile'] = 'Profile image';
$string['groupsnotenabledforcourse'] = 'Office Groups are not enabled for this course.';
$string['settings_geto365link'] = 'Install Office download URL';
$string['settings_geto365link_desc'] = 'The URL to use for the "Install Office" link.';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['linkmydelve'] = 'My Delve';
$string['linkmyforms'] = 'My Forms';
