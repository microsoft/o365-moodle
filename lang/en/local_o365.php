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

$string['acp_title'] = 'Office&nbsp;365 Administration Control Panel';
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
$string['errorchecksystemapiuser'] = 'Could not get a system API user token, please run the health check, ensure that your Moodle cron is running, and refresh the system API user if necessary.';
$string['erroro365apibadcall'] = 'Error in API call.';
$string['erroro365apibadcall_message'] = 'Error in API call: {$a}';
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

$string['eventapifail'] = 'API failure';
$string['eventcalendarsubscribed'] = 'User subscribed to a calendar';
$string['eventcalendarunsubscribed'] = 'User unsubscribed from a calendar';

$string['healthcheck_fixlink'] = 'Click here to fix it.';
$string['healthcheck_systemapiuser_title'] = 'System API User';
$string['healthcheck_systemtoken_result_notoken'] = 'Moodle does not have a token to communicate with Office&nbsp;365 as the system API user. This can usually be resolved by resetting the system API user.';
$string['healthcheck_systemtoken_result_noclientcreds'] = 'There are not application credentials present in the OpenID Connect plugin. Without these credentials, Moodle cannot perform any communication with Office&nbsp;365. Click here to visit the settings page and enter your credentials.';
$string['healthcheck_systemtoken_result_badtoken'] = 'There was a problem communicating with Office&nbsp;365 as the system API user. This can usually be resolved by resetting the system API user.';
$string['healthcheck_systemtoken_result_passed'] = 'Moodle can communicate with Office&nbsp;365 as the system API user.';

$string['settings_aadsync'] = 'Sync users with Azure AD';
$string['settings_aadsync_details'] = 'When enabled, Moodle and Azure AD users are synced according to the above options.<br /><br /><b>Note: </b>The sync job runs in the Moodle cron, and syncs 1000 users at a time. By default, this runs once per day at 1:00 AM in the time zone local to your server. To sync large sets of users more quickly, you can increase the freqency of the <b>Sync users with Azure AD</b> task using the <a href="{$a}">Scheduled tasks management page.</a><br /><br />For more detailed instructions, see the <a href="https://docs.moodle.org/27/en/Office365#User_sync">user sync documentation</a><br /><br />';
$string['settings_aadsync_create'] = 'Create accounts in Moodle for users in Azure AD';
$string['settings_aadsync_delete'] = 'Delete previously synced accounts in Moodle when they are deleted from Azure AD';
$string['settings_aadsync_match'] = 'Match preexisting Moodle users with same-named accounts in Azure AD';
$string['settings_aadsync_matchswitchauth'] = 'Connect matched users by switching authentication to OpenID Connect';
$string['settings_aadtenant'] = 'Azure AD Tenant';
$string['settings_aadtenant_details'] = 'Used to Identify your organization within Azure AD. For example: "contoso.onmicrosoft.com"';

$string['settings_azuresetup'] = 'Azure Setup';
$string['settings_azuresetup_details'] = 'This tool checks with Azure to make sure everything is set up correctly. It can also fix some common errors.';
$string['settings_azuresetup_update'] = 'Update';
$string['settings_azuresetup_checking'] = 'Checking...';
$string['settings_azuresetup_missingperms'] = 'Missing Permissions:';
$string['settings_azuresetup_permscorrect'] = 'Permissions are correct.';
$string['settings_azuresetup_errorcheck'] = 'An error occurred trying to check Azure setup.';
$string['settings_azuresetup_unifiedheader'] = 'Unified API';
$string['settings_azuresetup_unifieddesc'] = 'The unified API replaces the existing application-specific APIs. If available, you should add this to your Azure application to be ready for the future. Eventually, this will replace the legacy API.';
$string['settings_azuresetup_unifiederror'] = 'There was an error checking for Unified API support.';
$string['settings_azuresetup_unifiedactive'] = 'Unified API active.';
$string['settings_azuresetup_unifiedmissing'] = 'The unified API was not found in this application.';
$string['settings_azuresetup_legacyheader'] = 'Office&nbsp;365 API';
$string['settings_azuresetup_legacydesc'] = 'The Office&nbsp;365 API is made up of application-specific APIs.';
$string['settings_azuresetup_legacyerror'] = 'There was an error checking Office&nbsp;365 API settings.';

$string['settings_creategroups'] = 'Create User Groups';
$string['settings_creategroups_details'] = 'If enabled, this will create and maintain a teacher and student group in Office&nbsp;365 for every course on the site. This will create any needed groups each cron run (and add all current members). After that, group membership will be maintained as users are enrolled or unenrolled from Moodle courses.<br /><b>Note: </b>This feature requires the Office&nbsp;365 unified API added to the application added in Azure. <a href="https://docs.moodle.org/27/en/Office365#User_groups">Setup instructions and documentation.</a>';
$string['settings_o365china'] = 'Office&nbsp;365 for China';
$string['settings_o365china_details'] = 'Check this if you are using Office&nbsp;365 for China.';
$string['settings_debugmode'] = 'Record debug messages';
$string['settings_debugmode_details'] = 'If enabled, information will be logged to the Moodle log that can help in identifying problems.';
$string['settings_detectoidc'] = 'Application Credentials';
$string['settings_detectoidc_details'] = 'To communicate with Office&nbsp;365, Moodle needs credentials to identify itself. These are set in the "OpenID Connect" authentication plugin.';
$string['settings_detectoidc_credsvalid'] = 'Credentials have been set.';
$string['settings_detectoidc_credsvalid_link'] = 'Change';
$string['settings_detectoidc_credsinvalid'] = 'Credentials have not been set or are incomplete.';
$string['settings_detectoidc_credsinvalid_link'] = 'Set Credentials';

$string['settings_detectperms'] = 'Application Permissions';
$string['settings_detectperms_details'] = 'The use the plugin features, correct permissions must be set up for the application in Azure AD.';
$string['settings_detectperms_nocreds'] = 'Application credentials need to be set first. See above setting.';
$string['settings_detectperms_missing'] = 'Missing:';
$string['settings_detectperms_errorfix'] = 'An error occurred trying to fix permissions. Please set manually in Azure.';
$string['settings_detectperms_fixperms'] = 'Fix permissions';
$string['settings_detectperms_fixprereq'] = 'To fix this automatically, your system API user must be an administrator, and the "Access your organization\'s directory" permission must be enabled in Azure for the "Windows Azure Active Directory" application.';
$string['settings_detectperms_nounified'] = 'Unified API not present, some new features may not work.';

$string['settings_detectperms_unifiednomissing'] = 'All unified permissions present.';
$string['settings_detectperms_update'] = 'Update';
$string['settings_detectperms_valid'] = 'Permissions have been set up.';
$string['settings_detectperms_invalid'] = 'Check permissions in Azure AD';
$string['settings_enableunifiedapi'] = 'Enable Unified API';
$string['settings_enableunifiedapi_details'] = 'The unified API is a preview API that provides some new features like the "Create user groups" setting below. It will eventually replace the application-specific Office APIs, however it is still in preview and is subject to change which may break some functionality. If you\'d like to try it out, enable this setting and click "Save changes". Add the "Unified API" to your application in Azure then return here and run the "Azure Setup" tool below.';
$string['settings_header_setup'] = 'Setup';
$string['settings_header_options'] = 'Options';
$string['settings_healthcheck'] = 'Health Check';
$string['settings_healthcheck_details'] = 'If something isn\'t working correctly, performing a health check can usually identify the problem and propose solutions';
$string['settings_healthcheck_linktext'] = 'Perform health check';
$string['settings_odburl'] = 'OneDrive for Business URL';
$string['settings_odburl_details'] = 'The URL used to access OneDrive for Business. This can usually be determined by your Azure AD tenant. For example, if your Azure AD tenant is "contoso.onmicrosoft.com", this is most likely "contoso-my.sharepoint.com". Enter only the domain name, do not include http:// or https://';
$string['settings_serviceresourceabstract_valid'] = '{$a} is usable.';
$string['settings_serviceresourceabstract_invalid'] = 'This value doesn\'t seem to be usable.';
$string['settings_serviceresourceabstract_nocreds'] = 'Please set application credentials first.';
$string['settings_serviceresourceabstract_empty'] = 'Please enter a value or click "Detect" to attempt to detect correct value.';
$string['settings_sharepointlink'] = 'SharePoint Link';
$string['settings_sharepointlink_connected'] = 'Moodle is connected to this SharePoint site.';
$string['settings_sharepointlink_changelink'] = 'Change Site';
$string['settings_sharepointlink_initializing'] = 'Moodle is setting up this SharePoint site. This will occur during the next run of the Moodle cron.';
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
$string['task_groupcreate'] = 'Create user groups in Office&nbsp;365';
$string['task_refreshsystemrefreshtoken'] = 'Refresh system API user refresh token';
$string['task_syncusers'] = 'Sync users with Azure AD.';
$string['task_sharepointinit'] = 'Initialize SharePoint.';

$string['ucp_connectionstatus'] = 'Connection Status';
$string['ucp_calsync_availcal'] = 'Available Moodle Calendars';
$string['ucp_calsync_title'] = 'Outlook Calendar Sync';
$string['ucp_calsync_desc'] = 'Checked calendars will be synced from Moodle to your Outlook calendar.';
$string['ucp_connection_status'] = 'Office&nbsp;365 connection is:';
$string['ucp_connection_start'] = 'Connect to Office&nbsp;365';
$string['ucp_connection_stop'] = 'Disconnect from Office&nbsp;365';
$string['ucp_features'] = 'Office&nbsp;365 Features';
$string['ucp_features_intro'] = 'Below is a list of the features you can use to enhance Moodle with Office&nbsp;365.';
$string['ucp_features_intro_notconnected'] = 'Some of these may not be available until you are connected to Office&nbsp;365.';
$string['ucp_general_intro'] = 'Here you can manage your connection to Office&nbsp;365.';
$string['ucp_index_aadlogin_title'] = 'Office&nbsp;365 Login';
$string['ucp_index_aadlogin_desc'] = 'You can use your Office&nbsp;365 credentials to log in to Moodle. ';
$string['ucp_index_calendar_title'] = 'Outlook Calendar Sync';
$string['ucp_index_calendar_desc'] = 'Here you can set up syncing between your Moodle and Outlook calendars. You can export Moodle calendar events to Outlook, and bring Outlook events into Moodle.';
$string['ucp_index_connectionstatus_connected'] = 'You are currently connected to Office&nbsp;365';
$string['ucp_index_connectionstatus_matched'] = 'You have been matched with Office&nbsp;365 user <small>"{$a}"</small>. To complete this connection, please click the link below and log in to Office&nbsp;365.';
$string['ucp_index_connectionstatus_notconnected'] = 'You are not currently connected to Office&nbsp;365';
$string['ucp_index_onenote_title'] = 'OneNote';
$string['ucp_index_onenote_desc'] = 'OneNote integration allows you to use Office&nbsp;365 OneNote with Moodle. You can complete assignments using OneNote and easily take notes for your courses.';
$string['ucp_notconnected'] = 'Please connect to Office&nbsp;365 before visiting here.';
$string['ucp_onenote_title'] = 'OneNote';
$string['ucp_onenote_desc'] = 'This page provides options for Office&nbsp;365 OneNote.';
$string['ucp_onenote_disable'] = 'Disable Office&nbsp;365 OneNote';
$string['ucp_status_enabled'] = 'Active';
$string['ucp_status_disabled'] = 'Not Connected';
$string['ucp_syncwith_title'] = 'Sync With:';
$string['ucp_syncdir_title'] = 'Sync Behavior:';
$string['ucp_syncdir_out'] = 'From Moodle to Outlook';
$string['ucp_syncdir_in'] = 'From Outlook To Moodle';
$string['ucp_syncdir_both'] = 'Update both Outlook and Moodle';
$string['ucp_title'] = 'Office&nbsp;365 / Moodle Control Panel';
$string['ucp_options'] = 'Options';