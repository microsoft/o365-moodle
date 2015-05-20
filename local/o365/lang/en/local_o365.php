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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

$string['pluginname'] = 'Microsoft Office 365 Integration';

$string['acp_title'] = 'Office365 Administration Control Panel';
$string['acp_healthcheck'] = 'Health Check';
$string['acp_parentsite_name'] = 'Moodle';
$string['acp_parentsite_desc'] = 'Site for shared Moodle course data.';

$string['calendar_user'] = 'Personal (User) Calendar';
$string['calendar_site'] = 'Sitewide Calendar';

$string['erroracpauthoidcnotconfig'] = 'Please set application credentials in auth_oidc first.';
$string['erroracplocalo365notconfig'] = 'Please configure local_o365 first.';
$string['erroracpnosptoken'] = 'Did not have an available SharePoint token, and could not get one.';
$string['errorhttpclientbadtempfileloc'] = 'Could not open temporary location to store file.';
$string['errorhttpclientnofileinput'] = 'No file parameter in httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Could not refresh token';
$string['errorcreatingsharepointclient'] = 'Could not get SharePoint api client';
$string['errorcreatingsharepointclient'] = 'Could not get SharePoint api client';
$string['erroro365apibadcall'] = 'Error in API call.';
$string['erroro365apibadpermission'] = 'Permission not found';
$string['erroro365apicouldnotcreatesite'] = 'Problem creating site.';
$string['erroro365apicoursenotfound'] = 'Course not found.';
$string['erroro365apiinvalidtoken'] = 'Invalid or expired token.';
$string['erroro365apiinvalidmethod'] = 'Invalid httpmethod passed to apicall';
$string['erroro365apinoparentinfo'] = 'Could not find parent folder information';
$string['erroro365apinotimplemented'] = 'This should be overridden.';
$string['erroro365apinotoken'] = 'Did not have a token for the given resource and user, and could not get one. Is the user\'s refresh token expired?';
$string['erroro365apisiteexistsnolocal'] = 'Site already exists, but could not find local record.';
$string['errorcouldnotcreatespgroup'] = 'Could not create the SharePoint group.';

$string['eventcalendarsubscribed'] = 'User subscribed to a calendar';
$string['eventcalendarunsubscribed'] = 'User unsubscribed from a calendar';

$string['healthcheck_fixlink'] = 'Click here to fix it.';
$string['healthcheck_systemapiuser_title'] = 'System API User';
$string['healthcheck_systemtoken_result_notoken'] = 'Moodle does not have a token to communicate with Office365 as the system API user. This can usually be resolved by resetting the system API user.';
$string['healthcheck_systemtoken_result_noclientcreds'] = 'There are not application credentials present in the OpenID Connect plugin. Without these credentials, Moodle cannot perform any communication with Office 365. Click here to visit the settings page and enter your credentials.';
$string['healthcheck_systemtoken_result_badtoken'] = 'There was a problem communicating with Office365 as the system API user. This can usually be resolved by resetting the system API user.';
$string['healthcheck_systemtoken_result_passed'] = 'Moodle can communicate with Office 365 as the system API user.';

$string['settings_aadsync'] = 'Sync users from AzureAD';
$string['settings_aadsync_details'] = 'When enabled, users in the associated AzureAD directory are synced to Moodle. This creates users in Moodle that exist in AzureAD, and deletes the users from Moodle that were synced when they are deleted from AzureAD.';
$string['settings_aadtenant'] = 'AzureAD Tenant';
$string['settings_aadtenant_details'] = 'Used to Identify your organization within Azure AD. For example: "contoso.onmicrosoft.com"';
$string['settings_creategroups'] = 'Create User Groups';
$string['settings_creategroups_details'] = 'If enabled, this will create and maintain a teacher and student group in Office365 for every course on the site. This will create any needed groups each cron run (and add all current members). After that, group membership will be maintained as users are enrolled or unenrolled from Moodle courses.<br /><b>Note: </b>This feature requires the Office365 unified API added to the application added in Azure. <a href="https://docs.moodle.org/27/en/Office365#User_groups">Setup instructions and documentation.</a>';
$string['settings_o365china'] = 'Office 365 for China';
$string['settings_o365china_details'] = 'Check this if you are using Office 365 for China.';
$string['settings_detectoidc'] = 'Application Credentials';
$string['settings_detectoidc_details'] = 'To communicate with Office365, Moodle needs credentials to identify itself. These are set in the "OpenID Connect" authentication plugin.';
$string['settings_detectoidc_credsvalid'] = 'Credentials have been set.';
$string['settings_detectoidc_credsvalid_link'] = 'Change';
$string['settings_detectoidc_credsinvalid'] = 'Credentials have not been set or are incomplete.';
$string['settings_detectoidc_credsinvalid_link'] = 'Set Credentials';
$string['settings_detectperms'] = 'Application Permissions';
$string['settings_detectperms_details'] = 'The use the plugin features, correct permissions must be set up for the application in AzureAD.';
$string['settings_detectperms_nocreds'] = 'Application credentials need to be set first. See above setting.';
$string['settings_detectperms_missing'] = 'Missing:';
$string['settings_detectperms_errorcheck'] = 'An error occurred trying to check permissions.';
$string['settings_detectperms_errorfix'] = 'An error occurred trying to fix permissions. Please set manually in Azure.';
$string['settings_detectperms_fixperms'] = 'Fix permissions';
$string['settings_detectperms_fixprereq'] = 'To fix this automatically, your system API user must be an administrator, and the "Access your organization\'s directory" permission must be enabled in Azure for the "Windows Azure Active Directory" application.';
$string['settings_detectperms_nounified'] = 'Unified API not present, some new features may not work.';
$string['settings_detectperms_unifiedheader'] = 'Unified API: This is a beta API required for "Create User Groups"';
$string['settings_detectperms_unifiednomissing'] = 'All unified permissions present.';
$string['settings_detectperms_update'] = 'Update';
$string['settings_detectperms_valid'] = 'Permissions have been set up.';
$string['settings_detectperms_invalid'] = 'Check permissions in AzureAD';
$string['settings_header_setup'] = 'Setup';
$string['settings_header_options'] = 'Options';
$string['settings_healthcheck'] = 'Health Check';
$string['settings_healthcheck_details'] = 'If something isn\'t working correctly, performing a health check can usually identify the problem and propose solutions';
$string['settings_healthcheck_linktext'] = 'Perform health check';
$string['settings_odburl'] = 'OneDrive for Business URL';
$string['settings_odburl_details'] = 'The URL used to access OneDrive for Business. This can usually be determined by your AzureAD tenant. For example, if your AzureAD tenant is "contoso.onmicrosoft.com", this is most likely "contoso-my.sharepoint.com". Enter only the domain name, do not include http:// or https://';
$string['settings_serviceresourceabstract_valid'] = '{$a} is usable.';
$string['settings_serviceresourceabstract_invalid'] = 'This value doesn\'t seem to be usable.';
$string['settings_serviceresourceabstract_nocreds'] = 'Please set application credentials first.';
$string['settings_serviceresourceabstract_empty'] = 'Please enter a value or click "Detect" to attempt to detect correct value.';
$string['settings_sharepointlink'] = 'SharePoint Link';
$string['settings_sharepointlink_connected'] = 'Moodle is connected to this SharePoint site.';
$string['settings_sharepointlink_changelink'] = 'Change Site';
$string['settings_sharepointlink_initializing'] = 'Moodle is setting up this SharePoint site.';
$string['settings_sharepointlink_enterurl'] = 'Enter a URL above.';
$string['settings_sharepointlink_details'] = 'To connect Moodle and SharePoint, enter the full URL of a SharePoint site for Moodle to connect to. If the site doesn\'t exist, Moodle will attempt to create it.<br /><a href="https://docs.moodle.org/27/en/Office365/SharePoint">Read more about connecting Moodle and SharePoint</a>';
$string['settings_sharepointlink_status_invalid'] = 'This is not a usable SharePoint site.';
$string['settings_sharepointlink_status_notempty'] = 'This site is usable, but already exists. Moodle may conflict with existing content. For best results, enter a SharePoint site that doesn\'t exist and Moodle will create it.';
$string['settings_sharepointlink_status_valid'] = 'This SharePoint site will be created by Moodle and used for Moodle content.';
$string['settings_sharepointlink_status_checking'] = 'Checking entered SharePoint site...';
$string['settings_systemapiuser'] = 'System API User';
$string['settings_systemapiuser_details'] = 'Any Azure AD user, but it should be either the account of an administrator, or a dedicated account. This account is used to perform operations that are not user-specific. For example, managing course SharePoint sites.';
$string['settings_systemapiuser_change'] = 'Change User';
$string['settings_systemapiuser_usernotset'] = 'No user set.';
$string['settings_systemapiuser_userset'] = '{$a}';
$string['settings_systemapiuser_setuser'] = 'Set User';

$string['spsite_group_contributors_name'] = '{$a} contributors';
$string['spsite_group_contributors_desc'] = 'All users who have access to manage files for course {$a}';

$string['task_calendarsyncin'] = 'Sync o365 events in to Moodle';
$string['task_groupcreate'] = 'Create user groups in Office365';
$string['task_refreshsystemrefreshtoken'] = 'Refresh system API user refresh token';
$string['task_syncusers'] = 'Sync users with AAD.';
$string['task_sharepointinit'] = 'Initialize SharePoint.';

$string['ucp_connectionstatus'] = 'Connection Status';
$string['ucp_calsync_availcal'] = 'Available Moodle Calendars';
$string['ucp_calsync_title'] = 'Outlook Calendar Sync';
$string['ucp_calsync_desc'] = 'Checked calendars will be synced from Moodle to your Outlook calendar.';
$string['ucp_connection_status'] = 'Office365 connection is:';
$string['ucp_connection_start'] = 'Connect to Office365';
$string['ucp_connection_stop'] = 'Disconnect from Office365';
$string['ucp_features'] = 'Office365 Features';
$string['ucp_general_intro'] = 'Here you can manage your connection to Office 365.';
$string['ucp_notconnected'] = 'Please connect to Office365 before visiting here.';
$string['ucp_onenote_title'] = 'OneNote';
$string['ucp_onenote_desc'] = 'This page provides options for Office365 OneNote.';
$string['ucp_onenote_disable'] = 'Disable Office365 OneNote';
$string['ucp_status_enabled'] = 'Active';
$string['ucp_status_disabled'] = 'Not Connected';
$string['ucp_syncwith_title'] = 'Sync With:';
$string['ucp_syncdir_title'] = 'Sync Behavior:';
$string['ucp_syncdir_out'] = 'From Moodle to Outlook';
$string['ucp_syncdir_in'] = 'From Outlook To Moodle';
$string['ucp_syncdir_both'] = 'Update both Outlook and Moodle';
$string['ucp_title'] = 'Office365 Connection Management';
$string['ucp_options'] = 'Options';