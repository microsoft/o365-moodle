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
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
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
$string['erroracpnosptoken'] = 'Did not have an available sharepoint token, and could not get one.';
$string['errorhttpclientbadtempfileloc'] = 'Could not open temporary location to store file.';
$string['errorhttpclientnofileinput'] = 'No file parameter in httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Could not refresh token';
$string['errorcreatingsharepointclient'] = 'Could not get sharepoint api client';
$string['errorcreatingsharepointclient'] = 'Could not get sharepoint api client';
$string['erroro365apibadcall'] = 'Error in API call.';
$string['erroro365apibadpermission'] = 'Permission not found';
$string['erroro365apicouldnotcreatesite'] = 'Problem creating site.';
$string['erroro365apicoursenotfound'] = 'Course not found.';
$string['erroro365apiinvalidtoken'] = 'Invalid or expired token.';
$string['erroro365apiinvalidmethod'] = 'Invalid httpmethod passed to apicall';
$string['erroro365apinoparentinfo'] = 'Could not find parent folder information';
$string['erroro365apinotimplemented'] = 'This should be overridden.';
$string['erroro365apisiteexistsnolocal'] = 'Site already exists, but could not find local record.';

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
$string['settings_healthcheck'] = 'Health Check';
$string['settings_healthcheck_details'] = 'If something isn\'t working correctly, performing a health check can usually identify the problem and propose solutions';
$string['settings_healthcheck_linktext'] = 'Perform health check';
$string['settings_parentsiteuri'] = 'Course sharepoint sites parent site URI';
$string['settings_parentsiteuri_details'] = 'The URI to use for the parent site of all course SharePoint sites. "moodle" is a good default, but you can change it if it conflicts with a site you already have.<br /><b>Important - </b>If you change this after sites have been initialized, the sites must be reinitialized. New sites will be created, but the old ones will be left intact. Any files in the old sites will have to be manually migrated to the new sites.';
$string['settings_sharepointinit'] = 'Initialize Sharepoint Sites';
$string['settings_sharepointinit_details'] = 'This will create a SharePoint site for Moodle and subsites for all courses. Once initialized, courses will be able to use these SharePoint sites to share information between users.';
$string['settings_sharepointinit_initialize'] = 'Initialize';
$string['settings_sharepointinit_reinitialize'] = 'Reinitialize';
$string['settings_sharepointinit_initialized'] = 'Sharepoint has been initialized';
$string['settings_sharepointinit_setsystemapiuser'] = 'Set the system API user first.';
$string['settings_systemapiuser'] = 'System API User';
$string['settings_systemapiuser_details'] = 'Any Azure AD user, but it should be either the account of an administrator, or a dedicated account. This account is used to perform operations that are not user-specific. For example, managing course SharePoint sites.';
$string['settings_systemapiuser_change'] = 'Change User';
$string['settings_systemapiuser_usernotset'] = 'No user set.';
$string['settings_systemapiuser_userset'] = '{$a}';
$string['settings_systemapiuser_setuser'] = 'Set User';
$string['settings_tenant'] = 'Azure Active Directory Tenant';
$string['settings_tenant_details'] = 'The AzureAD tenant';

$string['spsite_group_contributors_name'] = '{$a} contributors';
$string['spsite_group_contributors_desc'] = 'All users who have access to manage files for course {$a}';

$string['task_refreshsystemrefreshtoken'] = 'Refresh system API user refresh token';
$string['task_syncusers'] = 'Sync users with AAD.';

$string['ucp_general_intro'] = 'Here you can manage your connection to Office 365.';
$string['ucp_title'] = 'Office365 Connection Management';
$string['ucp_calsync_title'] = 'Outlook Calendar Sync';
$string['ucp_calsync_desc'] = 'Checked calendars will be synced from Moodle to your Outlook calendar.';