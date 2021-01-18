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
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['pluginname'] = 'Microsoft 365 Integration';

// Settings - tabs.
$string['settings_header_setup'] = 'Setup';
$string['settings_header_syncsettings'] = 'Sync Settings';
$string['settings_header_advanced'] = 'Advanced';
$string['settings_header_sds'] = 'School Data Sync (preview)';
$string['settings_header_teams'] = 'Teams Settings';
$string['settings_header_moodle_app'] = 'Teams Moodle app';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'Step 1/3: Register Moodle with Azure AD';
$string['settings_setup_step1_desc'] = 'Register a new AzureAD Application for your Microsoft 365 tenant by using Windows PowerShell:

<a href="{$a}/local/o365/scripts/Moodle-AzureAD-Powershell.zip" class="btn btn-primary" target="_blank">Download PowerShell Script</a>

<p style="margin-top:10px"><a href="https://aka.ms/MoodleTeamsPowerShellReadMe" target="_blank">Click here </a> to read the instructions for running the script. When prompted, use the following link as the Moodle URL:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />Once the script is successfully executed, copy the Application ID and Application Key returned by script into the fields below:';
$string['settings_setup_step1_credentials_end'] = 'If you are unable to setup the AzureAD app via PowerShell, <a href="https://aka.ms/MoodleTeamsManualSetup" target="_blank">click here</a> for manual setup instructions.

Note: These settings are saved in the OpenID Connect authentication plugin. To configure advanced login settings, go to the <a href="{$a->oidcsettings}">OpenID Connect settings page</a><br /><br />';
$string['settings_setup_step1_continue'] = '<b>Once you have entered your Application ID and Key, click "Save changes" at the bottom of the page to continue.</b><br /><br /><br /><br /><br />';
$string['settings_setup_step2'] = 'Step 2/3: Choose connection method';
$string['settings_setup_step2_desc'] = 'This section allows you to choose how the Microsoft 365 integration suite connects to Azure. Communication can be made using "Application Access", or on behalf of a user you have dedicated as the "system" user.';
$string['settings_setup_step2_continue'] = '<b>Choose a connection method, then click "Save changes" to continue.</b><br /><br /><br /><br /><br />';
$string['settings_setup_step3'] = 'Step 3/3: Admin consent &amp; additional information';
$string['settings_setup_step3_desc'] = 'This last step allows you to give administrator consent to use some Azure permissions, and gathers some additional information about your Microsoft 365 environment.<br /><br />';
$string['settings_setup_step4'] = 'Verify setup';
$string['settings_setup_step4_desc'] = 'Setup is complete. Click the "Update" button below to verify your setup.';

// Settings in the "Step 1/3" section of the "Setup" tab.
$string['settings_clientid'] = 'Application ID';
$string['settings_clientid_desc'] = '';
$string['settings_clientsecret'] = 'Application Key';
$string['settings_clientsecret_desc'] = '';

// Settings in "Step 2/3" of the "Setup" tab.
$string['settings_enableapponlyaccess'] = 'Application access';
$string['settings_enableapponlyaccess_details'] = '<b>Recommended</b>. Using this method, the integration accesses Microsoft 365 directly using Azure\'s "Application Permissions". This is the easiest, and recommended way to connect to Microsoft 365, but requires you enable a few extra permissions in Azure.<br /><br /><b>- Or -</b><br />';
$string['settings_systemapiuser'] = 'System API User';
$string['settings_systemapiuser_details'] = 'To use this method, disable "Application Access", click "Save Changes", then click the "Set User" button. <br />Using this connection method, the integration communicates to Azure on behalf of a user you choose. This requires less permissions, but requires a dedicated user. You might want to use this method if you cannot enable the additional permissions required for application access, or if you have special security concerns that would be contained in a dedicated user.';
$string['settings_systemapiuser_change'] = 'Change user';
$string['settings_systemapiuser_usernotset'] = 'No user set.';
$string['settings_systemapiuser_userset'] = '{$a}';
$string['settings_systemapiuser_setuser'] = 'Set User';

// Settings in "Step 3/3" section of the "Setup" tab.
$string['settings_adminconsent'] = 'Admin Consent';
$string['settings_adminconsent_btn'] = 'Provide Admin Consent';
$string['settings_adminconsent_details'] = 'To allow access to some of the permissions needed, an administrator will need to provide admin consent. Click this button, then log in with an Azure administrator account to provide consent. This will need to be done whenever you change "Admin" permissions in Azure.';
$string['settings_aadtenant'] = 'Azure AD Tenant';
$string['settings_aadtenant_details'] = 'Used to Identify your organization within Azure AD. For example: "contoso.onmicrosoft.com".';
$string['settings_aadtenant_error'] = 'We could not detect your Azure AD tenant.<br />Please ensure "Windows Azure Active Directory" has been added to your registered Azure AD application, and that the "Read directory data" permission is enabled.';
$string['settings_odburl'] = 'OneDrive for Business URL';
$string['settings_odburl_details'] = 'The URL used to access OneDrive for Business. This can usually be determined by your Azure AD tenant. For example, if your Azure AD tenant is "contoso.onmicrosoft.com", this is most likely "contoso-my.sharepoint.com". Enter only the domain name, do not include http:// or https://';
$string['settings_odburl_error'] = 'We could not determine your OneDrive for Business URL.<br />Please make sure "Microsoft 365 SharePoint Online" has been added to your registered application in Azure AD.';
$string['settings_odburl_error_graph'] = 'We could not determine your OneDrive for Business URL, please enter manually. This can usually be determined by using the URL you use to access OneDrive.';
$string['settings_serviceresourceabstract_detect'] = 'Detect';
$string['settings_serviceresourceabstract_detecting'] = 'Detecting...';
$string['settings_serviceresourceabstract_error'] = 'An error occurred detecting setting. Please set manually.';
$string['settings_serviceresourceabstract_noperms'] = 'We experienced a problem detecting this setting.<br />Please ensure "Windows Azure Active Directory" has been added to your registered Azure AD application, and that the "Read directory data" permission is enabled.';
$string['settings_serviceresourceabstract_valid'] = '{$a} is usable.';
$string['settings_serviceresourceabstract_invalid'] = 'This value doesn\'t seem to be usable.';
$string['settings_serviceresourceabstract_nocreds'] = 'Please set application credentials first.';
$string['settings_serviceresourceabstract_empty'] = 'Please enter a value or click "Detect" to attempt to detect correct value.';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_azuresetup'] = 'Azure AD setup';
$string['settings_azuresetup_appdataheader'] = 'Azure AD Application Registration';
$string['settings_azuresetup_appdatadesc'] = 'Verifies the correct parameters are set up in Azure AD.';
$string['settings_azuresetup_appdatareplyurlcorrect'] = 'Reply URL Correct';
$string['settings_azuresetup_appdatareplyurlincorrect'] = 'Reply URL Incorrect';
$string['settings_azuresetup_appdatareplyurlgeneralerror'] = 'Could not check reply url.';
$string['settings_azuresetup_appdatasignonurlcorrect'] = 'Sign-on URL Correct.';
$string['settings_azuresetup_appdatasignonurlincorrect'] = 'Sign-on URL Incorrect';
$string['settings_azuresetup_appdatasignonurlgeneralerror'] = 'Could not check sign-on url.';
$string['settings_azuresetup_apppermscorrect'] = 'Application Permissions Correct';
$string['settings_azuresetup_details'] = 'This tool checks with Azure AD to make sure everything is set up correctly. <br /><b>Note:</b> Changes in Azure AD can take a moment to appear here. If you have made a change in Azure AD and do not see it reflected here, wait a moment and try again.';
$string['settings_azuresetup_correctval'] = 'Correct Value:';
$string['settings_azuresetup_detectedval'] = 'Detected Value:';
$string['settings_azuresetup_update'] = 'Update';
$string['settings_azuresetup_checking'] = 'Checking...';
$string['settings_azuresetup_missingappperms'] = 'Missing Application Permissions:';
$string['settings_azuresetup_missingperms'] = 'Missing Permissions:';
$string['settings_azuresetup_permscorrect'] = 'Permissions are correct.';
$string['settings_azuresetup_errorcheck'] = 'An error occurred trying to check Azure AD setup.';
$string['settings_azuresetup_noinfo'] = 'We don\'t have any information about your Azure AD setup yet. Please click the Update button to check.';
$string['settings_azuresetup_strunifiedpermerror'] = 'There was an error checking Microsoft Graph API permissions.';
$string['settings_azuresetup_strtenanterror'] = 'Please use the dectect button to set your Azure AD Tenant before updating Azure AD setup.';
$string['settings_azuresetup_unifiedheader'] = 'Microsoft Graph API';
$string['settings_azuresetup_unifieddesc'] = 'The Microsoft Graph API allows communication between Moodle and Microsoft 365.';
$string['settings_azuresetup_unifiederror'] = 'There was an error checking for Microsoft Graph API support.';
$string['settings_azuresetup_unifiedactive'] = 'Microsoft Graph API active.';
$string['settings_azuresetup_unifiedmissing'] = 'The Microsoft Graph API was not found in this application.';
$string['settings_azuresetup_legacyheader'] = 'Microsoft 365 API';
$string['settings_azuresetup_legacydesc'] = 'The Microsoft 365 API is made up of application-specific APIs.';
$string['settings_azuresetup_legacyerror'] = 'There was an error checking Microsoft 365 API settings.';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc'] = 'Application Credentials';
$string['settings_detectoidc_details'] = 'To communicate with Microsoft 365, Moodle needs credentials to identify itself. These are set in the "OpenID Connect" authentication plugin.';
$string['settings_detectoidc_credsvalid'] = 'Credentials have been set.';
$string['settings_detectoidc_credsvalid_link'] = 'Change';
$string['settings_detectoidc_credsinvalid'] = 'Credentials have not been set or are incomplete.';
$string['settings_detectoidc_credsinvalid_link'] = 'Set Credentials';
$string['settings_migration'] = '<b>Note: This version removes the legacy Microsoft 365 API. If you cannot yet migrate to the Graph API, you can add "$CFG->local_o365_forcelegacyapi = true;" to your Moodle config.php. However, this option will be removed in the next version. For more information, please consult the <a href="https://docs.moodle.org/34/en/Office365">Integration Documentation</a></b>';
$string['settings_detectperms'] = 'Application Permissions';
$string['settings_detectperms_details'] = 'The use the plugin features, correct permissions must be set up for the application in Azure AD.';
$string['settings_detectperms_nocreds'] = 'Application credentials need to be set first. See above setting.';
$string['settings_detectperms_missing'] = 'Missing:';
$string['settings_detectperms_errorfix'] = 'An error occurred trying to fix permissions. Please set manually in Azure AD.';
$string['settings_detectperms_fixperms'] = 'Fix permissions';
$string['settings_detectperms_fixprereq'] = 'To fix this automatically, your system API user must be an administrator, and the "Access your organization\'s directory" permission must be enabled in Azure AD for the "Windows Azure Active Directory" application.';
$string['settings_detectperms_nounified'] = 'Microsoft Graph API not present, some new features may not work.';
$string['settings_detectperms_unifiednomissing'] = 'All unified permissions present.';
$string['settings_detectperms_update'] = 'Update';
$string['settings_detectperms_valid'] = 'Permissions have been set up.';
$string['settings_detectperms_invalid'] = 'Check permissions in Azure AD';
$string['settings_disablegraphapi'] = 'Disable Microsoft Graph API';
$string['settings_disablegraphapi_details'] = 'Disable use of the Microsoft Graph API and force API calls to use the legacy API. This should only be enabled if you are experiencing problems with the Graph API.';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_options_usersync'] = 'User Sync';
$string['settings_options_usersync_desc'] = 'The following settings control user synchronization between Microsoft 365 and Moodle.';
$string['settings_aadsync'] = 'Sync users with Azure AD';
$string['settings_aadsync_details'] = 'When enabled, Moodle and Azure AD users are synced according to the above options.<br /><br /><b>Note: </b>The sync job runs in the Moodle cron, and syncs 1000 users at a time. By default, this runs once per day at 1:00 AM in the time zone local to your server. To sync large sets of users more quickly, you can increase the frequency of the <b>Sync users with Azure AD</b> task using the <a href="{$a}">Scheduled tasks management page.</a><br /><br />';
$string['settings_aadsync_create'] = 'Create accounts in Moodle for users in Azure AD';
$string['settings_aadsync_update'] = 'Update all accounts in Moodle for users in Azure AD';
$string['settings_aadsync_delete'] = 'Delete previously synced accounts in Moodle when they are deleted from Azure AD';
$string['settings_aadsync_match'] = 'Match preexisting Moodle users with same-named accounts in Azure AD';
$string['settings_aadsync_matchswitchauth'] = 'Switch matched users to Microsoft 365 (OpenID Connect) authentication';
$string['settings_aadsync_appassign'] = 'Assign users to application during sync';
$string['settings_aadsync_photosync'] = 'Sync Microsoft 365 profile photos to Moodle in cron job';
$string['settings_aadsync_photosynconlogin'] = 'Sync Microsoft 365 profile photos to Moodle on login';
$string['settings_aadsync_nodelta'] = 'Perform a full sync each run';
$string['settings_aadsync_emailsync'] = 'Match Azure usernames to moodle emails instead of moodle usernames during the sync';
$string['settings_addsync_tzsync'] = 'Sync Outlook timezone to Moodle in cronjob';
$string['settings_addsync_tzsynconlogin'] = 'Sync Outlook timezone to Moodle on login';
$string['settings_fieldmap'] = 'User Field Mapping';
$string['settings_fieldmap_addmapping'] = 'Add Mapping';
$string['settings_fieldmap_details'] = 'Configure mapping between user fields in Microsoft 365 and Moodle.';
$string['settings_fieldmap_header_behavior'] = 'Updates';
$string['settings_fieldmap_header_local'] = 'Moodle Field';
$string['settings_fieldmap_header_remote'] = 'Active Directory Field';
$string['settings_fieldmap_field_city'] = 'City';
$string['settings_fieldmap_field_companyName'] = 'Company Name';
$string['settings_fieldmap_field_objectId'] = 'Object ID';
$string['settings_fieldmap_field_country'] = 'Country';
$string['settings_fieldmap_field_department'] = 'Department';
$string['settings_fieldmap_field_displayName'] = 'Display Name';
$string['settings_fieldmap_field_surname'] = 'Surname';
$string['settings_fieldmap_field_faxNumber'] = 'Fax Number';
$string['settings_fieldmap_field_telephoneNumber'] = 'Telephone Number';
$string['settings_fieldmap_field_givenName'] = 'Given Name';
$string['settings_fieldmap_field_jobTitle'] = 'Job Title';
$string['settings_fieldmap_field_mail'] = 'Email';
$string['settings_fieldmap_field_mobile'] = 'Mobile';
$string['settings_fieldmap_field_postalCode'] = 'Postal Code';
$string['settings_fieldmap_field_preferredLanguage'] = 'Language';
$string['settings_fieldmap_field_state'] = 'State';
$string['settings_fieldmap_field_streetAddress'] = 'Street Address';
$string['settings_fieldmap_field_userPrincipalName'] = 'Username (UPN)';
$string['settings_fieldmap_field_employeeId'] = 'Employee ID';
$string['settings_fieldmap_field_businessPhones'] = 'Office phone';
$string['settings_fieldmap_field_mobilePhone'] = 'Mobile phone';
$string['settings_fieldmap_field_officeLocation'] = 'Office';
$string['settings_fieldmap_field_preferredName'] = 'Preferred Name';
$string['settings_fieldmap_field_manager'] = 'Manager';
$string['settings_fieldmap_field_teams'] = 'Teams';
$string['settings_fieldmap_field_groups'] = 'Groups';
$string['settings_fieldmap_update_always'] = 'On login & creation';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'Course Sync';
$string['settings_secthead_coursesync_desc'] = 'These following settings control course synchronization between Moodle and Microsoft Teams / Microsoft 365 groups.';
$string['settings_usergroups'] = 'Teams';
$string['settings_usergroups_details'] = 'If enabled, this will create and maintain a Team for every course on the site (Default: Disabled). This will create any needed Teams each cron run (and add all current members). After that, Team membership will be maintained as users are enrolled or unenrolled from Moodle courses.';
$string['acp_usergroupcustom_off'] = 'Disabled<br />Disable Teams creation for all Moodle courses.';
$string['acp_usergroupcustom_oncustom'] = 'Customize<br />Allows you to select which courses to create Course Groups (i.e. Teams) for, as well as select which Group features are exposed in the Microsoft block for each course.<br> <span id="adminsetting_usergroups" style="font-weight: bold"><a href="{$a}">Customize groups</a></span>';
$string['acp_usergroupcustom_onall'] = 'All Features Enabled<br />Enables Course Groups (i.e. Teams) for all courses and exposes all Group features in the Microsoft block for all courses.';

// Settings in the "Teams customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_usergroupcustom'] = 'Teams Customization';
$string['acp_usergroupcustom_enabled'] = 'Enabled';
$string['acp_usrgroupcustom_enable_all'] = 'Enable course sync on all courses';
$string['acp_usergroupcustom_bulk'] = 'Bulk Operations';
$string['acp_usergroupcustom_bulk_help'] = 'The feature toggles only work on courses on the current page.';
$string['acp_usergroupcustom_bulk_enable'] = 'Enable All';
$string['acp_usergroupcustom_bulk_disable'] = 'Disable All';
$string['acp_usergroupcustom_new_course'] = 'Enabled by default for new course';
$string['acp_usergroupcustom_new_course_desc'] = 'If enabled, all newly created courses will have sync enabled by default';
$string['acp_usergroupcustom_savemessage'] = 'Your changes have been saved.';
$string['acp_usergroupcustom_searchwarning'] = 'Note: Searches will lose any unsaved progress. Press save changes to ensure your changes are saved.';
$string['groups_team'] = 'Teams';
$string['groups_onedrive'] = 'Files';
$string['groups_calendar'] = 'Calendar';
$string['groups_conversations'] = 'Conversations';
$string['groups_notebook'] = 'Class Notebook';

// Settings in the "Teams name" section of the "Sync settings" tab.
$string['settings_secthead_team_name'] = 'Teams name';
$string['settings_secthead_team_name_desc'] = 'If a course is configured to create Microsoft Teams, the name of the Team will be constructed as follows.<br/>
<ul>
<li>Only Team display names can be defined. Associated group short names will be automatically generated.</li>
<li>Group naming policies are not applied when creating Teams.</li>
<li>Changes made here will only affect future Team creation, and not existing ones.</li>
</ul>';
$string['settings_team_name_prefix'] = 'Teams name prefix';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'Course part of the Teams name';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'Teams name suffix';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'For a course with
<ul>
<li>Full name: <b>Sample course</b> 
<li>Short name: <b>sample 15</b></li>
<li>Moodle created ID: <b>2</b></li>
<li>ID number: <b>Sample ID 15</b></li>
</ul>
Your current setting will create use "<b>{$a}</b>" to create a Team.';

$string['settings_main_name_option_full_name'] = 'Full name';
$string['settings_main_name_option_short_name'] = 'Short name';
$string['settings_main_name_option_id'] = 'Moodle created ID';
$string['settings_main_name_option_id_number'] = 'ID number';

// Settings in the "Group name" section of the "Sync settings" tab.
$string['settings_secthead_group_name'] = 'Group name';
$string['settings_secthead_group_name_desc'] = 'If a course is configured to create Outlook group instead of Microsoft Teams, the display name and short name of the group will be constructed as follows.<br/>
<ul>
<li>Both display name (displayName) and mail alias (mailNickname) of the group can be defined, and they can be different.</li>
<li>Group naming policy applies to mail alias settings; attempting to create a group with mail alias not matching the group naming policy as defined in your organisation will fail.</li>
<li>Mail alias of the group needs to be unique, otherwise group creation will fail.</li>
<li>Changes made here will only affect future groups creation, and not existing ones.</li>
<li>All spaces will be removed from the group mail alias.</li>
<li>Only upper and lower case letters, numbers, - and _ are allowed in the group mail alias.</li>
<li>Group mail alias, including prefix and suffix cannot exceed 64 characters.</li>
</ul>';
$string['settings_group_display_name_prefix'] = 'Group display name prefix';
$string['settings_group_display_name_prefix_desc'] = '';
$string['settings_group_display_name_course'] = 'Course part of the group display name';
$string['settings_group_display_name_course_desc'] = '';
$string['settings_group_display_name_suffix'] = 'Group display name suffix';
$string['settings_group_short_name_prefix'] = 'Group mail alias prefix';
$string['settings_group_short_name_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'Course part of the group mail alias';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'Group mail alias suffix';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_group_names_sample'] = '
For a course with
<ul>
<li>Full name: <b>Sample course 15</b> 
<li>Short name: <b>sample 15</b></li>
<li>Moodle created ID: <b>2</b></li>
<li>ID number: <b>Sample ID 15</b></li>
</ul>
Your current setting will create use display name "<b>{$a->displayname}</b>" and mail alias "<b>{$a->mailalias}</b>" to create a group.
';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'Tools';
$string['settings_secthead_advanced'] = 'Advanced Settings';
$string['settings_secthead_advanced_desc'] = 'These settings control other features of the plugin suite. Be careful! These may cause unintended effects.';
$string['settings_secthead_legacy'] = 'Legacy';
$string['settings_secthead_legacy_desc'] = 'These settings and features are deprecated and likely to be removed soon.';
$string['settings_secthead_preview'] = 'Preview Features';
$string['settings_secthead_preview_desc'] = '';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'Tenants';
$string['settings_tools_tenants_linktext'] = 'Configure additional tenants';
$string['settings_tools_tenants_details'] = 'Manage access to additional Microsoft 365 tenants.';
$string['settings_healthcheck'] = 'Health Check';
$string['settings_healthcheck_details'] = 'If something isn\'t working correctly, performing a health check can usually identify the problem and propose solutions';
$string['settings_healthcheck_linktext'] = 'Perform health check';
$string['settings_userconnections'] = 'Connections';
$string['settings_userconnections_linktext'] = 'Manage User Connections';
$string['settings_userconnections_details'] = 'Review and manage connections between Moodle and Microsoft 365 users.';
$string['settings_usermatch'] = 'User Matching';
$string['settings_usermatch_details'] = 'This tool allows you to match Moodle users with Microsoft 365 users based on a custom uploaded data file.';
$string['settings_usersynccreationrestriction'] = 'User Creation Restriction';
$string['settings_usersynccreationrestriction_details'] = 'If enabled, only users that have the specified value for the specified Azure AD field will be created during user sync.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Field value';
$string['settings_usersynccreationrestriction_o365group'] = 'Microsoft 365 Group Membership';
$string['settings_usersynccreationrestriction_regex'] = 'Value is a regular expression';
$string['settings_maintenance'] = 'Maintenance';
$string['settings_maintenance_details'] = 'Various maintenance tasks are available to resolve some common issues.';
$string['settings_maintenance_linktext'] = 'View maintenance tools';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'Multitenancy';
$string['acp_tenants_title_desc'] = 'This page helps you set up multitenant access to Moodle from Microsoft 365.';
$string['acp_tenants_add'] = 'Add New Tenant';
$string['acp_tenants_errornotsetup'] = 'Please complete the plugin setup process before adding additional tenants.';
$string['acp_tenants_hosttenant'] = 'Host Tenant: {$a}';
$string['acp_tenants_intro'] = '<b>How Multitenancy Works:</b><br />Multitenancy allows multiple Microsoft 365 tenants to access your Moodle site. <br /><br />
    Here\'s how to get set up:
    <ol>
        <li>Log in to Moodle as a administrator user that is not using the OpenID Connect authentication plugin.</li>
        <li>Disable the OpenID Connect authentication plugin in Moodle. (Use <a href="{$a}/admin/settings.php?section=manageauths">the authentication plugins administration page</a>.)</li>
        <li>Navigate to Azure AD, and find the application you configured for Moodle.</li>
        <li>Enable multitenancy in the Azure AD application and save changes.</li>
        <li>For each tenant you want to enable, click "Add New Tenant" and log in with an administrator account from the tenant you want to enable.</li>
        <li>Once you have added all the tenants you want, re-enable the OpenID Connect authentication plugin in Moodle.</li>
        <li>You\'re done! To add additional tenants in the future, just click the "Add New Tenant" button and log in with an administrator account from that tenant.</li>
    </ol>
    <b>Important Note:</b> Azure AD multitenancy allows all Microsoft 365 tenants to access your application when enabled. Adding the tenants here allows us to restrict Moodle access to tenants you configure. <b>If you remove all the tenants from this list before disabling multitenancy in Azure AD, or enable OpenID Connect authentication in Moodle with an empty list, your Moodle site will be open to all Microsoft 365 tenants.</b>';
$string['acp_tenants_none'] = 'You have not configured any tenants. If you have enabled multitenancy in Azure AD, you\'re Moodle site may be open to all Microsoft 365 users.';
$string['acp_tenants_revokeaccess'] = 'Revoke Access';
$string['acp_tenants_tenant'] = 'Tenant';
$string['acp_tenants_actions'] = 'Actions';
$string['acp_tenantsadd_desc'] = 'To grant access to an additional tenant, click the button below and log in to Microsoft 365 using an adminitrator account of the new tenant. You will be returned to the list of additional tenants where the new tenant will be listed. You will then be able to use Moodle with the new tenant.';
$string['acp_tenantsadd_linktext'] = 'Proceed to Microsoft 365 login page';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = 'Health Check';
$string['healthcheck_fixlink'] = 'Click here to fix it.';
$string['healthcheck_systemapiuser_title'] = 'System API User';
$string['healthcheck_systemtoken_result_notoken'] = 'Moodle does not have a token to communicate with Microsoft 365 as the system API user. This can usually be resolved by resetting the system API user.';
$string['healthcheck_systemtoken_result_noclientcreds'] = 'There are not application credentials present in the OpenID Connect plugin. Without these credentials, Moodle cannot perform any communication with Microsoft 365. Click here to visit the settings page and enter your credentials.';
$string['healthcheck_systemtoken_result_badtoken'] = 'There was a problem communicating with Microsoft 365 as the system API user. This can usually be resolved by resetting the system API user.';
$string['healthcheck_systemtoken_result_passed'] = 'Moodle can communicate with Microsoft 365 as the system API user.';
$string['healthcheck_ratelimit_title'] = 'API Throttling';
$string['healthcheck_ratelimit_result_notice'] = 'Slight throttling has been enabled to handle increased Moodle site load. <br /><br />All Microsoft 365 features are functional, this just spaces out requests slightly to prevent interruption of Microsoft 365 services. Once Moodle activity decreases, everything will return to normal. <br />(Level {$a->level} / started {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'Increased throttling has been enabled to handle significant Moodle site load. <br /><br />All Microsoft 365 features are still functional, but Microsoft 365 requests may take longer to complete. Once Moodle site activity has decreased, everything will return to normal. <br />(Level {$a->level} / started {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'Rate limiting features have been disabled.';
$string['healthcheck_ratelimit_result_passed'] = 'Microsoft 365 API calls are executing at full speed.';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'User Connections';
$string['acp_userconnections_column_muser'] = 'Moodle User';
$string['acp_userconnections_column_o365user'] = 'Microsoft 365 User';
$string['acp_userconnections_column_status'] = 'Connection Status';
$string['acp_userconnections_column_actions'] = 'Actions';
$string['acp_userconnections_column_usinglogin'] = 'Using Login';
$string['acp_userconnections_filtering_muserfullname'] = 'Moodle user full name';
$string['acp_userconnections_filtering_musername'] = 'Moodle username';
$string['acp_userconnections_filtering_o365username'] = 'Microsoft 365 username';
$string['acp_userconnections_manualmatch_title'] = 'Manual user match';
$string['acp_userconnections_manualmatch_details'] = 'This page allows you to match a single Moodle user with a single Microsoft 365 user.';
$string['acp_userconnections_manualmatch_musername'] = 'Moodle user';
$string['acp_userconnections_manualmatch_uselogin'] = 'Log in with Microsoft 365';
$string['acp_userconnections_manualmatch_o365username'] = 'Microsoft 365 username';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'The Moodle user is already connected to an Microsoft 365 user';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'The Moodle user is already connected to an Microsoft 365 user (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'The Moodle user is already matched to an Microsoft 365 user';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'The Microsoft 365 user is already matched to another Moodle user';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'The Microsoft 365 user is already connected to another Moodle user';
$string['acp_userconnections_resync_notconnected'] = 'This user is not connected to Microsoft 365';
$string['acp_userconnections_resync_nodata'] = 'Could not find stored Microsoft 365 information for this user.';
$string['acp_userconnections_table_connected'] = 'Connected';
$string['acp_userconnections_table_disconnect'] = 'Disconnect';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'This will disconnect the Moodle user "{$a}" from Microsoft 365. Click the link below to proceed.';
$string['acp_userconnections_table_match'] = 'Match';
$string['acp_userconnections_table_matched'] = 'Matched with existing user.<br />Awaiting completion.';
$string['acp_userconnections_table_noconnection'] = 'No Connection';
$string['acp_userconnections_table_resync'] = 'Resync';
$string['acp_userconnections_table_synced'] = 'Synced from Azure AD.<br />Awaiting initial login.';
$string['acp_userconnections_table_unmatch'] = 'Unmatch';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'This will unmatch the Moodle user "{$a}" from Microsoft 365. Click the link below to proceed.';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'User Matching';
$string['acp_usermatch_desc'] = 'This tool allows you to match Moodle users to Microsoft 365 users. You will upload a file containing Moodle users and associated Microsoft 365 users, and a cron task will verify the data and set up the match.';
$string['acp_usermatch_upload'] = 'Step 1: Upload New Matches';
$string['acp_usermatch_upload_desc'] = 'Upload a data file containing Moodle and Microsoft 365 usernames to match Moodle users to Microsoft 365 users.<br /><br />This file should be a simple plain-text CSV file containing three items per line: the Moodle username, the Microsoft 365 username and 1 or 0 to change the users authenticaton method to OpenID Connect or a linked account respectively. Do not include any headers or additional data.<br />For example: <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'Type {$a} is not supported. Please upload a plain-text CSV.';
$string['acp_usermatch_upload_err_data'] = 'Line #{$a} contained invalid data. Each line in the CSV file should have two items: the Moodle username and the Microsoft 365 username.';
$string['acp_usermatch_upload_err_fileopen'] = 'Could not open file for processing. Are the permissions correct in your Moodledata directory?';
$string['acp_usermatch_upload_err_nofile'] = 'No file was received to add to the queue.';
$string['acp_usermatch_upload_submit'] = 'Add Data File To Match Queue';
$string['acp_usermatch_matchqueue'] = 'Step 2: Match Queue';
$string['acp_usermatch_matchqueue_clearall'] = 'Clear All';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Clear Errors';
$string['acp_usermatch_matchqueue_clearqueued'] = 'Clear Queued';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Clear Successful';
$string['acp_usermatch_matchqueue_column_muser'] = 'Moodle Username';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Microsoft 365 Username';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Status';
$string['acp_usermatch_matchqueue_desc'] = 'This table shows the current status of the match operation. Every time the matching cron job runs, a batch of the following users will be processed.<br /><b>Note:</b> This page will not update dynamically, refresh this page to view the current status.';
$string['acp_usermatch_matchqueue_empty'] = 'The match queue is currently empty. Upload a data file using the file picker above to add users to the queue.';
$string['acp_usermatch_matchqueue_status_error'] = 'Error: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'Queued';
$string['acp_usermatch_matchqueue_status_success'] = 'Successful';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'Maintenance Tools';
$string['acp_maintenance_desc'] = 'These tools can help you resolve some common issues.';
$string['acp_maintenance_warning'] = 'Warning: These are advanced tools. Please use them only if you understand what you are doing.';
$string['acp_maintenance_coursegroupusers'] = 'Resync users in groups for courses';
$string['acp_maintenance_coursegroupusers_desc'] = 'This will resync the user membership for all Microsoft 365 groups created for all Moodle courses. This will ensure all, and only, users enrolled in the Moodle course are in the Microsoft 365 group. <br /><b>Note:</b> If you have added any additional users to a course group that are not enrolled in the associated Moodle course, they will be removed.';
$string['acp_maintenance_coursegroupscheck'] = 'Recreate deleted Microsoft 365 groups';
$string['acp_maintenance_coursegroupscheck_desc'] = 'This will check for any Microsoft 365 Teams that may have been manually deleted and recreate them.';
$string['acp_maintenance_debugdata'] = 'Generate debug data package';
$string['acp_maintenance_debugdata_desc'] = 'This will generate a package containing various pieces of information about your Moodle and Microsoft 365 environment to assist developers in solving any issues you may have. If requested by a developer, run this tool and send the resulting file download. Note: Although this package does not contain sensitive token data, we ask that you do not post this file publicly or send it to an untrusted party.';
$string['acp_maintenance_cleanoidctokens'] = 'Cleanup OpenID Connect Tokens';
$string['acp_maintenance_cleanoidctokens_desc'] = 'If your users are experiencing problems logging in using their Microsoft 365 account, trying cleaning up OpenID Connect tokens. This removes stray and incomplete tokens that can cause errors. WARNING: This may interrupt logins in-process, so it\'s best to do this during downtime.';
$string['acp_maintenance_cleandeltatoken'] = 'Cleanup User Sync Delta Tokens';
$string['acp_maintenance_cleandeltatoken_desc'] = 'If user synchronisation is not fully working after updating it user sync settings, it may be caused by an old delta sync token. Cleaning up the token will remove force a complete re-sync the next time when the user sync is run.';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_o365china'] = 'Microsoft 365 for China';
$string['settings_o365china_details'] = 'Check this if you are using Microsoft 365 for China.';
$string['settings_debugmode'] = 'Record debug messages';
$string['settings_debugmode_details'] = 'If enabled, information will be logged to the Moodle log that can help in identifying problems. <a href="{$a}">View recorded log messages.</a>';
$string['settings_switchauthminupnsplit0'] = 'Minimum inexact username length to switch to Microsoft 365';
$string['settings_switchauthminupnsplit0_details'] = 'If you enable the "Switch matched users to Microsoft 365 authentication" setting, this sets the minimum length for usernames without a tenant (the @example.onmicrosoft.com part) which will be switched. This helps to avoid switching accounts with generic names, like "admin", which aren\'t necessarily same in Moodle and Azure AD.';
$string['settings_photoexpire'] = 'Profile photo refresh time';
$string['settings_photoexpire_details'] = 'The number of hours to wait before refreshing profile photos. Longer times can increase performance.';
$string['settings_customtheme'] = 'Custom theme (Advanced)';
$string['settings_customtheme_desc'] = 'Recommended theme is boost_o365teams. However, you can select different theme if you have
a custom theme which is adapted to be used in the Teams tab.';

// Settings in the "Legacy" section of the "Advanced" tab.
$string['settings_sharepointlink'] = 'SharePoint Link';
$string['settings_sharepointlink_error'] = 'There was a problem setting up SharePoint. <br /><br /><ul><li>If you have debug logging enabled ("Record debug messages" setting above), more information may be available in the Moodle log report. (Site Administration > Reports > Logs).</li><li>To retry setup, click "Change Site", choose a new SharePoint site, click "Save Changes" at the bottom of this page, and run the Moodle cron.</ul>';
$string['settings_sharepointlink_connected'] = 'Moodle is connected to this SharePoint site.';
$string['settings_sharepointlink_changelink'] = 'Change Site';
$string['settings_sharepointlink_initializing'] = 'Moodle is setting up this SharePoint site. This will occur during the next run of the Moodle cron.';
$string['settings_sharepointlink_enterurl'] = 'Enter a URL above.';
$string['settings_sharepointlink_details'] = 'To connect Moodle and SharePoint, enter the full URL of a SharePoint site for Moodle to connect to. If the site doesn\'t exist, Moodle will attempt to create it.';
$string['settings_sharepointlink_status_invalid'] = 'This is not a usable SharePoint site.';
$string['settings_sharepointlink_status_notempty'] = 'This site is usable, but already exists. Moodle may conflict with existing content. For best results, enter a SharePoint site that doesn\'t exist and Moodle will create it.';
$string['settings_sharepointlink_status_valid'] = 'This SharePoint site will be created by Moodle and used for Moodle content.';
$string['settings_sharepointlink_status_checking'] = 'Checking entered SharePoint site...';
$string['acp_sharepointcourseselect'] = 'SharePoint Course Selection';
$string['acp_sharepointcourseselect_searchwarning'] = 'Note: Searches will lose any unsaved progress. Press save changes to ensure your changes are saved.';
$string['acp_sharepointcourseselect_applyfilter'] = 'Apply Filter';
$string['acp_sharepointcourseselect_bulk'] = 'Bulk Operations';
$string['acp_sharepointcourseselect_desc'] = 'Choose which courses will have SharePoint sites created for them. By default, no sites will be created. You can then choose to select specific courses ("Custom"), or create a SharePoint site for all Moodle courses ("Sync All").';
$string['acp_sharepointcourseselect_none'] = 'None<br />No SharePoint sites will be created.';
$string['acp_sharepointcourseselect_onall'] = 'Sync All<br />A SharePoint site will be generated for every Moodle course on this site.';
$string['acp_sharepointcourseselect_oncustom'] = 'Custom <a href="{$a}">Customize</a><br />Choose which Moodle courses will be associated with a SharePoint site.';
$string['acp_sharepointcourseselect_enableshown'] = 'Return to Settings';
$string['acp_sharepointcourseselectlabel_enabled'] = 'Enable';
$string['acp_sharepointcourseselect_filter'] = 'Filter Courses';
$string['acp_sharepointcourseselect_filtercategory'] = 'Filter by course category';
$string['acp_sharepointcourseselect_filterstring'] = 'Filter by string search';
$string['acp_sharepointcourseselect_instr'] = 'To sort by column, select the column header. Select the checkbox for all courses to be associated with a SharePoint resource. To enable all courses by default, disable this custom feature in the admin settings.';
$string['acp_sharepointcourseselect_instr_header'] = 'Instructions';
$string['acp_sharepointcourseselect_off_header'] = 'Not Enabled';
$string['acp_sharepointcourseselect_off_instr'] = 'SharePoint custom course selection is not enabled. Enable it in the plugin admin settings to use this feature.';
$string['acp_sharepointcustom_savemessage'] = 'Your changes have been saved.';
$string['acp_sharepointcourseselect_syncopt'] = 'Sync SharePoint Subsites';
$string['acp_sharepointcourseselect_syncopt_btn'] = 'Sync to SharePoint Subsites';
$string['acp_sharepointcourseselect_syncopt_inst'] = 'Because this functionality was recently upgraded, the information shown here may not be accurate. Use the button below to sync this display with existing course subsites on SharePoint. This operation may take some time.';

// Settings in the "Legacy" section of the "Advanced" tab.
$string['settings_previewfeatures'] = 'Enable preview features';
$string['settings_previewfeatures_details'] = 'Enable features provided on a "preview" basis. These features use brand new APIs, or are experimental in some way. These features may be more prone to break, but will give you a sneak peak at what\'s coming in the near future.';

// Settings in the "School Data Sync (preview)" tab.
$string['settings_sds_intro'] = '';
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>This is a preview feature</b><br />Preview features may not work as intended or may break without warning. Please proceed with caution.</div>';
$string['settings_sds_intro_desc'] = 'The school data sync ("SDS") tool allows you to sync information imported into Azure AD from external SIS systems into Moodle. <a href="https://sis.microsoft.com/" target="_blank">Learn More</a><br /><br />The school data sync process happens in the Moodle cron, at 3am local server time. To change this schedule, please visit the <a href="{$a}">Scheduled tasks management page.</a><br /><br />';
$string['settings_sds_coursecreation'] = 'Course Creation';
$string['settings_sds_coursecreation_desc'] = 'These options control course creation in Moodle based on information in SDS.';
$string['settings_sds_coursecreation_enabled'] = 'Create Courses';
$string['settings_sds_coursecreation_enabled_desc'] = 'Create courses for these schools.';
$string['settings_sds_enrolment_enabled'] = 'Enrol users';
$string['settings_sds_enrolment_enabled_desc'] = 'Enrol students and teachers into courses created from SDS.';
$string['settings_sds_profilesync'] = 'Profile Data Sync';
$string['settings_sds_profilesync_desc'] = 'These options control profile data syncing between SDS data and Moodle.';
$string['settings_sds_profilesync_enabled'] = 'Enable';
$string['settings_sds_profilesync_enabled_desc'] = 'Enable profile data syncing when we sync with SDS';
$string['settings_sds_fieldmap'] = 'Field Mapping';
$string['settings_sds_fieldmap_details'] = 'This controls how fields are mapped between SDS and Moodle.';
$string['settings_sds_fieldmap_remotecolumn'] = 'SDS Field';
$string['settings_sds_fieldmap_f_mailNickname'] = 'Unique student alias';
$string['settings_sds_fieldmap_f_userPrincipalName'] = 'Official email address';
$string['settings_sds_fieldmap_f_givenName'] = 'First name';
$string['settings_sds_fieldmap_f_surname'] = 'Last name';
$string['settings_sds_fieldmap_f_pre_MiddleName'] = 'Middle name';
$string['settings_sds_fieldmap_f_pre_SyncSource_StudentId'] = 'SIS assigned student ID';
$string['settings_sds_fieldmap_f_pre_SyncSource_SchoolId'] = 'School ID';
$string['settings_sds_fieldmap_f_pre_Email'] = 'Personal email address';
$string['settings_sds_fieldmap_f_pre_StateId'] = 'State assigned number';
$string['settings_sds_fieldmap_f_pre_StudentNumber'] = 'Disctrict/School assigned number';
$string['settings_sds_fieldmap_f_pre_MailingAddress'] = 'Mailing address';
$string['settings_sds_fieldmap_f_pre_MailingCity'] = 'Mailing address city';
$string['settings_sds_fieldmap_f_pre_MailingState'] = 'Mailing address state';
$string['settings_sds_fieldmap_f_pre_MailingZip'] = 'Mailing address zip';
$string['settings_sds_fieldmap_f_pre_MailingLatitude'] = 'Mailing address latitude';
$string['settings_sds_fieldmap_f_pre_MailingLongitude'] = 'Mailing address longitude';
$string['settings_sds_fieldmap_f_pre_MailingCountry'] = 'Mailing address country';
$string['settings_sds_fieldmap_f_pre_ResidenceAddress'] = 'Residence address';
$string['settings_sds_fieldmap_f_pre_ResidenceCity'] = 'Residence city';
$string['settings_sds_fieldmap_f_pre_ResidenceState'] = 'Residence state';
$string['settings_sds_fieldmap_f_pre_ResidenceZip'] = 'Residence zip';
$string['settings_sds_fieldmap_f_pre_ResidenceLatitude'] = 'Residence address latitude';
$string['settings_sds_fieldmap_f_pre_ResidenceLongitude'] = 'Residence address longitude';
$string['settings_sds_fieldmap_f_pre_ResidenceCountry'] = 'Residence country';
$string['settings_sds_fieldmap_f_pre_Gender'] = 'Gender';
$string['settings_sds_fieldmap_f_pre_DateOfBirth'] = 'Date of birth';
$string['settings_sds_fieldmap_f_pre_Grade'] = 'Grade level';
$string['settings_sds_fieldmap_f_pre_EnglishLanguageLearnersStatus'] = 'English language learner status';
$string['settings_sds_fieldmap_f_pre_FederalRace'] = 'Federal race';
$string['settings_sds_fieldmap_f_pre_GraduationYear'] = 'Graduation year';
$string['settings_sds_fieldmap_f_pre_StudentStatus'] = 'Student status';
$string['settings_sds_fieldmap_f_pre_AnchorId'] = 'Internal unique student identifier.';
$string['settings_sds_fieldmap_f_pre_ObjectType'] = 'The object type ("Student")';
$string['settings_sds_noschools'] = '<div class="alert alert-info">You do not have any schools available in School data sync.</div>';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner_1'] = 'The Moodle app for <a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teams</a> allows you to easily access and collaborate around your Moodle courses in Teams. The Moodle app also consists of a Moodle Assistant bot, which will send Moodle notifications to students and teachers and answer questions about their courses, assignments, grades and students -- right within Teams!';
$string['settings_teams_banner_2'] = 'To provision the Moodle Assistant Bot for your Microsoft 365 tenant, you need to deploy it to <a href="https://aka.ms/MoodleLearnAzure" target="_blank">Microsoft Azure</a>. If you don\'t have an active Azure subscription, you can <a href="https://aka.ms/MoodleTeamsAzureFree" target="_blank">get one for free</a> today!';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Setup your Moodle app for Microsoft Teams</h4>';
$string['settings_moodlesettingssetup'] = 'Configure Moodle';
$string['settings_check_moodle_settings'] = 'Check Moodle settings';
$string['settings_moodlesetup_checking'] = 'Checking...';
$string['settings_notice_oidcenabled'] = 'Open ID Connect enabled successfully';
$string['settings_notice_oidcnotenabled'] = 'Open ID Connect could not be enabled';
$string['settings_notice_oidcalreadyenabled'] = 'Open ID Connect was already enabled';
$string['settings_notice_webservicesframealreadyenabled'] = 'Webservices were already enabled and frame embedding is also allowed';
$string['settings_notice_webservicesframeenabled'] = 'Webservices enabled successfully and frame embedding is also allowed now';
$string['settings_notice_restenabled'] = 'REST Protocol enabled successfully';
$string['settings_notice_restnotenabled'] = 'REST Protocol could not be enabled';
$string['settings_notice_restalreadyenabled'] = 'REST Protocol was already enabled';
$string['settings_notice_o365serviceenabled'] = 'O365 Webservices enabled successfully';
$string['settings_notice_o365servicealreadyenabled'] = 'O365 Webservices were already enabled';
$string['settings_notice_createtokenallowed'] = 'Permission to create a web service token granted';
$string['settings_notice_createtokenalreadyallowed'] = 'Permission to create a web service token was already granted';
$string['settings_notice_createtokennotallowed'] = 'There was an issue giving permission to create a web service token';
$string['settings_notice_restusageallowed'] = 'Permission to use REST Protocol granted';
$string['settings_notice_restusagealreadyallowed'] = 'Permission to use REST Protocol was already granted';
$string['settings_notice_restusagenotallowed'] = 'There was an issue giving permission to use REST Protocol';
$string['settings_moodlesettingssetup_details'] = 'This will make sure that:
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>Open ID is enabled.</li>
<li>Frame Embedding is enabled.</li>
<li>Web Services is enabled.</li>
<li>Rest Protocol is enabled.</li>
<li>Microsoft 365 Webservices is enabled.</li>
<li>Authenticated user has permission to create a web service token.</li>
<li>Authenticated user has permission to use Rest Protocol.</li>
</ul>';
$string['settings_teams_additional_instructions'] = '<p class="local_o365_settings_teams_horizontal_spacer">
Go to the <a href="https://aka.ms/MoodleBotRegistration" target="_blank">App registrations section of Azure Portal</a> and register a new app. Enter the application ID and client secret below:
</p>';
$string['settings_teams_deploy_bot_1'] = 'Once you have completed the above steps and have an active Azure subscription, click here to deploy the bot:';
$string['settings_teams_deploy_bot_2'] = 'Need help?';
$string['settings_bot_feature_enabled'] = 'Bot feature enabled';
$string['settings_bot_feature_enabled_desc'] = '';
$string['settings_bot_app_id'] = 'Application ID';
$string['settings_bot_app_id_desc'] = '';
$string['settings_bot_app_password'] = 'Client Secret';
$string['settings_bot_app_password_desc'] = 'Go to \'Certificates & secrets\' section under \'Manage\' in application settings, and click \'New client secret\', and paste the one-time secret';
$string['settings_bot_webhook_endpoint'] = 'Bot webhook end point';
$string['settings_bot_webhook_endpoint_desc'] = 'Format: https://<moodlebotname\>.azurewebsites.net/api/webhook';
$string['settings_teams_moodle_app_external_id'] = 'Microsoft app ID for the Moodle Teams app';
$string['settings_teams_moodle_app_external_id_desc'] = 'This should be set to the default value, unless multiple Moodle Teams apps are required in your tenant to connect to different Moodle sites.';
$string['settings_teams_moodle_app_short_name'] = 'Teams app name';
$string['settings_teams_moodle_app_short_name_desc'] = 'This can be set as default, unless multiple Moodle Teams apps are required in your tenant to connect to different Moodle sites.';
$string['settings_bot_sharedsecret'] = 'Shared Moodle Secret';
$string['settings_bot_sharedsecret_desc'] = 'Please paste this secret to the \'Shared Moodle Secret\' field in the Azure Bot template';
$string['settings_download_teams_tab_app_manifest'] = 'Download manifest file';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Please save all your changes before downloading the manifest.';
$string['settings_publish_manifest_instruction'] = '<a href="https://docs.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Click here</a> to learn how to publish your downloaded Moodle app manifest file to all users in Teams.';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'Moodle app ID';
$string['settings_moodle_app_id_desc'] = 'ID of uploaded Moodle app in Teams app catalogs';
$string['settings_set_moodle_app_id_instruction'] = 'To find the Moodle app ID manually, follow these steps:
<ol>
<li>Upload the downloaded manifest file to Teams app catalog of your tenant.</li>
<li>In Teams app catalog, find the app.</li>
<li>Click the option icon of the app, which is located at the top right corner of the app image.</li>
<li>Click "Copy link".</li>
<li>In a text editor, paste the copied content. It should contain a URL such as https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
The last part of the URL, i.e. <span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>, is the app ID.';

// Settings for sharepoint features.
$string['acp_parentsite_name'] = 'Moodle';
$string['acp_parentsite_desc'] = 'Site for shared Moodle course data.';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Enable Outlook Calendar Sync';
$string['calendar_user'] = 'Personal (User) Calendar';
$string['calendar_site'] = 'Sitewide Calendar';
$string['personal_calendar'] = 'Personal';
$string['calendar_event'] = 'View details';
$string['eventcalendarsubscribed'] = 'User subscribed to a calendar';
$string['eventcalendarunsubscribed'] = 'User unsubscribed from a calendar';

// Errors.
$string['erroracpauthoidcnotconfig'] = 'Please set application credentials in auth_oidc first.';
$string['erroracplocalo365notconfig'] = 'Please configure local_o365 first.';
$string['erroracpnosptoken'] = 'Did not have an available SharePoint token, and could not get one.';
$string['errorhttpclientbadtempfileloc'] = 'Could not open temporary location to store file.';
$string['errorhttpclientnofileinput'] = 'No file parameter in httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Could not refresh token';
$string['errorcreatingsharepointclient'] = 'Could not get SharePoint api client';
$string['errorchecksystemapiuser'] = 'Could not get a system API user token, please run the health check, ensure that your Moodle cron is running, and refresh the system API user if necessary.';
$string['erroracpapcantgettenant'] = 'Could not get Azure AD tenant, please enter manually.';
$string['erroracpcantgettenant'] = 'Could not get OneDrive URL, please enter manually.';
$string['errorcreatingteamfromgroup'] = 'Could not create team from group. Please check group exists and group has owner.';
$string['errorprovisioningapp'] = 'Could not provision the Moodle app in the Team.';
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
$string['errorcoursenotsubsiteenabled'] = 'This course is not SharePoint subsite enabled.';
$string['errorusermatched'] = 'The Microsoft 365 account "{$a->aadupn}" is already matched with Moodle user "{$a->username}". To complete the connection, please log in as that Moodle user first and follow the instructions in the Microsoft block.';
$string['eventapifail'] = 'API failure';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Microsoft 365 Local Plugin';
$string['privacy:metadata:local_o365_calidmap'] = 'Information about links between Microsoft 365 calendar events and Moodle calendar events.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'The ID of the user who owns the event.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'Where the event originated. Either Moodle or Microsoft 365.';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'The ID of the event in Outlook.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'The ID of the event in Moodle.';
$string['privacy:metadata:local_o365_calsub'] = 'Information about sync subscriptions between Moodle and Outlook calendars';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'The ID of the Moodle user the subscription is for';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'The type of Moodle calendar (site,course,user)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'The associated ID of the Moodle calendar';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'The ID of the Microsoft 365 calendar';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Whether this is the primary calendar';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'The sync behaviour (i.e. Moodle to Outlook or Outlook to Moodle)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'The time the subscription was created.';
$string['privacy:metadata:local_o365_connections'] = 'Information about connections between Moodle and Microsoft 365 users that have not yet been confirmed';
$string['privacy:metadata:local_o365_connections:muserid'] = 'The ID of the Moodle user';
$string['privacy:metadata:local_o365_connections:aadupn'] = 'The UPN of the Microsoft 365 user.';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Whether to switch the user\'s authentication method when completed.';
$string['privacy:metadata:local_o365_token'] = 'Information about Microsoft 365 API tokens for users';
$string['privacy:metadata:local_o365_token:user_id'] = 'The ID of the Moodle user';
$string['privacy:metadata:local_o365_token:scope'] = 'The token scope.';
$string['privacy:metadata:local_o365_token:resource'] = 'The token resource.';
$string['privacy:metadata:local_o365_token:token'] = 'The token.';
$string['privacy:metadata:local_o365_token:expiry'] = 'The token\'s expiry time.';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'The refresh token.';
$string['privacy:metadata:local_o365_objects'] = 'Information about the relationship between Moodle and Microsoft 365 objects';
$string['privacy:metadata:local_o365_objects:type'] = 'The type of object (group, user, course, etc)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'The subtype of object.';
$string['privacy:metadata:local_o365_objects:objectid'] = 'The Microsoft 365 object id';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'The ID of the object in Moodle';
$string['privacy:metadata:local_o365_objects:o365name'] = 'The human-readable name of the object in Microsoft 365';
$string['privacy:metadata:local_o365_objects:tenant'] = 'The tenant the object belongs to (in multi-tenancy environments)';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Any associated metadata';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'The time the record was created.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'The time the record was modified.';
$string['privacy:metadata:local_o365_spgroupassign'] = 'Information about group assignments';
$string['privacy:metadata:local_o365_spgroupassign:userid'] = 'The ID of the Moodle user';
$string['privacy:metadata:local_o365_spgroupassign:groupid'] = 'The ID of the group in Microsoft 365';
$string['privacy:metadata:local_o365_spgroupassign:timecreated'] = 'The time the record was created';
$string['privacy:metadata:local_o365_appassign'] = 'Information about Microsoft 365 app role assignments';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'The ID of the Moodle user';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Whether the user has been assigned to the app';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'The ID of the user\'s photo in Microsoft 365';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'When the user\'s photo was last updated from Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue'] = 'Information about Moodle user to Microsoft 365 user matching';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'The username of the Moodle user.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'The username of the Microsoft 365 user.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Whether to switch the user to OpenID Connect authentication when the match is made';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Whether the record has been processed';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'The error message (if any)';
$string['privacy:metadata:local_o365_calsettings'] = 'Information about calendar sync settings';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'The ID of the Moodle user';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'The ID of the calendar in Microsoft 365';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'The time the record was created.';

// "Microsoft 365 / Moodle Control Panel" page in the Microsoft block.
$string['ucp_title'] = 'Microsoft 365 / Moodle Control Panel';
$string['ucp_general_intro'] = 'Here you can manage your connection to Microsoft 365.';
$string['ucp_connectionstatus'] = 'Connection Status';
$string['ucp_calsync_availcal'] = 'Available Moodle Calendars';
$string['ucp_calsync_title'] = 'Outlook Calendar sync settings';
$string['ucp_calsync_desc'] = 'Checked calendars will be synced from Moodle to your Outlook calendar.';
$string['ucp_connection_status'] = 'Microsoft 365 connection is:';
$string['ucp_connection_start'] = 'Connect to Microsoft 365';
$string['ucp_connection_stop'] = 'Disconnect from Microsoft 365';
$string['ucp_connection_options'] = 'Connection Options:';
$string['ucp_connection_desc'] = 'Here you can configure how you connect to Microsoft 365. To use Microsoft 365 features, you must be connected to an Microsoft 365 account. This can be accomplished as outlined below.';
$string['ucp_connection_aadlogin'] = 'Use your Microsoft 365 credentials to log in to Moodle<br />';
$string['ucp_connection_aadlogin_desc_rocreds'] = 'Instead of your Moodle username and password, you will enter your Microsoft 365 username and password on the Moodle login page.';
$string['ucp_connection_aadlogin_desc_authcode'] = 'Instead of entering a username and password on the Moodle login page, you will see a section that says "Login using your account on {$a}" on the login page. You will click the link and be redirected to Microsoft 365 to log in. After you have logged in to Microsoft 365 successfully, you will be returned to Moodle and logged in to your account.';
$string['ucp_connection_aadlogin_start'] = 'Start using Microsoft 365 to log in to Moodle.';
$string['ucp_connection_aadlogin_stop'] = 'Stop using Microsoft 365 to log in to Moodle.';
$string['ucp_connection_aadlogin_active'] = 'You are using the Microsoft 365 account "{$a}" to log in to Moodle.';
$string['ucp_connection_linked'] = 'Link your Moodle and Microsoft 365 accounts';
$string['ucp_connection_linked_desc'] = 'Linking your Moodle and Microsoft 365 accounts allows you to use Microsoft 365 Moodle features without changing how you log in to Moodle. <br />Clicking the link below will send you to Microsoft 365 to perform a one-time login, after which you will be returned here. You will be able to use all the Microsoft 365 features without making any other changes to your Moodle account - you will log in to Moodle as you always have.';
$string['ucp_connection_linked_active'] = 'You are linked to Microsoft 365 account "{$a}".';
$string['ucp_connection_linked_start'] = 'Link your Moodle account to an Microsoft 365 account.';
$string['ucp_connection_linked_migrate'] = 'Switch to linked account.';
$string['ucp_connection_linked_stop'] = 'Unlink your Moodle account from the Microsoft 365 account.';
$string['ucp_connection_disconnected'] = 'You are not connected to Microsoft 365.';
$string['ucp_features'] = 'Microsoft 365 Features';
$string['ucp_features_intro'] = 'Below is a list of the features you can use to enhance Moodle with Microsoft 365.';
$string['ucp_features_intro_notconnected'] = ' Some of these may not be available until you are connected to Microsoft 365.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'To connect to Microsoft 365 you will need to contact your site administrator.';
$string['ucp_index_aadlogin_title'] = 'Microsoft 365 Login';
$string['ucp_index_aadlogin_desc'] = 'You can use your Microsoft 365 credentials to log in to Moodle. ';
$string['ucp_index_aadlogin_active'] = 'You are currently using Microsoft 365 to log in to Moodle';
$string['ucp_index_aadlogin_inactive'] = 'You are not currently using Microsoft 365 to log in to Moodle';
$string['ucp_index_calendar_title'] = 'Outlook Calendar sync settings';
$string['ucp_index_calendar_desc'] = 'Here you can set up syncing between your Moodle and Outlook calendars. You can export Moodle calendar events to Outlook, and bring Outlook events into Moodle.';
$string['ucp_index_connection_title'] = 'Microsoft 365 connection settings';
$string['ucp_index_connection_desc'] = 'Configure how you connect to Microsoft 365.';
$string['ucp_index_connectionstatus_title'] = 'Connection Status';
$string['ucp_index_connectionstatus_login'] = 'Click here to log in.';
$string['ucp_index_connectionstatus_usinglogin'] = 'You are currently using Microsoft 365 to log in to Moodle.';
$string['ucp_index_connectionstatus_usinglinked'] = 'You are linked to a Microsoft 365 account.';
$string['ucp_index_connectionstatus_connect'] = 'Click here to connect.';
$string['ucp_index_connectionstatus_manage'] = 'Manage Connection';
$string['ucp_index_connectionstatus_disconnect'] = 'Disconnect';
$string['ucp_index_connectionstatus_reconnect'] = 'Refresh Connection';
$string['ucp_index_connectionstatus_connected'] = 'You are currently connected to Microsoft 365';
$string['ucp_index_connectionstatus_matched'] = 'You have been matched with Microsoft 365 user <small>"{$a}"</small>. To complete this connection, please click the link below and log in to Microsoft 365.';
$string['ucp_index_connectionstatus_notconnected'] = 'You are not currently connected to Microsoft 365';
$string['ucp_index_onenote_title'] = 'OneNote';
$string['ucp_index_onenote_desc'] = 'OneNote integration allows you to use Microsoft 365 OneNote with Moodle. You can complete assignments using OneNote and easily take notes for your courses.';
$string['ucp_notconnected'] = 'Please connect to Microsoft 365 before visiting here.';
$string['ucp_status_enabled'] = 'Active';
$string['ucp_status_disabled'] = 'Not Connected';
$string['ucp_syncwith_title'] = 'Name of Outlook calendar to sync with:';
$string['ucp_syncdir_title'] = 'Sync Behavior:';
$string['ucp_syncdir_out'] = 'From Moodle to Outlook';
$string['ucp_syncdir_in'] = 'From Outlook To Moodle';
$string['ucp_syncdir_both'] = 'Update both Outlook and Moodle';
$string['ucp_options'] = 'Options';
$string['ucp_o365accountconnected'] = 'This Microsoft 365 account is already connected with another Moodle account.';

// "Group control panel" page in the Microsoft block.
$string['groups'] = 'Microsoft 365 Groups';
$string['groups_edit_name'] = 'Group name';
$string['groups_edit_nameexists'] = 'The group with the {$a} currently exists, please choose another name.';
$string['groups_edit_description'] = 'Group description';
$string['groups_edit_newpicture'] = 'Group icon';
$string['groups_edit_newpicture_help'] = 'The image uploaded for the group icon will be used for the Moodle Group and the Microsoft 365 group';
$string['groups_columnname'] = 'Name';
$string['groups_studygroups'] = 'Study groups';
$string['groups_studygroup'] = 'Study group';
$string['groups_pending'] = 'This Microsoft 365 group will be created shortly, please try again later.';
$string['groups_manage_pending'] = 'Your Microsoft 365 group will be created shortly.';
$string['groups_notenabled'] = 'Microsoft 365 Groups are not enabled for this course.';
$string['groups_notenabledforcourse'] = 'Microsoft 365 Groups are not enabled for this course.';
$string['groups_editsettings'] = 'Edit group settings';
$string['groups_manage'] = 'Manage groups';
$string['groups_more'] = 'More...';
$string['groups_total'] = 'Total groups: {$a}';

// Tasks.
$string['task_bot'] = 'Bot message task';
$string['task_calendarsyncin'] = 'Sync o365 events in to Moodle';
$string['task_groupcreate'] = 'Create user groups in Microsoft 365';
$string['task_refreshsystemrefreshtoken'] = 'Refresh system API user refresh token';
$string['task_sds_sync'] = 'Sync with SDS';
$string['task_syncusers'] = 'Sync users with Azure AD.';
$string['task_sharepointinit'] = 'Initialize SharePoint.';
$string['task_processmatchqueue'] = 'Process Match Queue';
$string['task_processmatchqueue_err_museralreadymatched'] = 'Moodle user is already matched to a Microsoft 365 user.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'Moodle user is already connected to Microsoft 365.';
$string['task_processmatchqueue_err_nomuser'] = 'No Moodle user found with this username.';
$string['task_processmatchqueue_err_noo365user'] = 'No Microsoft 365 user found with this username.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'Microsoft 365 user is already matched to a Moodle user.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'Microsoft 365 user is already connected to a Moodle user.';

// Capabilities.
$string['o365:manageconnectionlink'] = 'Manage Connection Link';
$string['o365:manageconnectionunlink'] = 'Manage Connection Unlink';
$string['o365:managegroups'] = 'Manage Groups';
$string['o365:teammember'] = 'Team member';
$string['o365:teamowner'] = 'Team owner';
$string['o365:viewgroups'] = 'View Groups';

// Web service errors.
$string['webservices_error_assignnotfound'] = 'The received module\'s assignment record could not be found.';
$string['webservices_error_invalidassignment'] = 'The received assignment ID cannot be used with this webservices function.';
$string['webservices_error_modulenotfound'] = 'The received module ID could not be found.';
$string['webservices_error_sectionnotfound'] = 'The course section could not be found.';
$string['webservices_error_couldnotsavegrade'] = 'Could not save grade.';

$string['help_user_create'] = 'Create Accounts Help';
$string['help_user_create_help'] = 'This will create users in Moodle from each user in the linked Azure Active Directory. Only users which do not currently have Moodle accounts will have accounts created. New accounts will be set up to use their Microsoft 365 credentials to log in to Moodle (using the OpenID Connect authentication plugin), and will be able to use all Microsoft 365/Moodle integration features.';
$string['help_user_update'] = 'Update All Accounts Help';
$string['help_user_update_help'] = 'This will update all users in Moodle from each user in the linked Azure Active Directory.';
$string['help_user_delete'] = 'Delete Accounts Help';
$string['help_user_delete_help'] = 'This will delete users from Moodle if they are marked as deleted in Azure Active Directory. The Moodle account will be deleted and all associated user information will be removed from Moodle. Be careful!';
$string['help_user_match'] = 'Match Accounts Help';
$string['help_user_match_help'] = 'This will look at the each user in the linked Azure Active Directory and try to match them with a user in Moodle. This match is based on usernames in Azure AD and Moodle. Matches are case-insentitive and ignore the Microsoft 365 tenant. For example, "BoB.SmiTh" in Moodle would match "bob.smith@example.onmicrosoft.com". Users who are matched will have their Moodle and Microsoft 365 accounts connected and will be able to use all Microsoft 365/Moodle integration features. The user\'s authentication method will not change unless the setting below is enabled.';
$string['help_user_matchswitchauth'] = 'Switch Matched Accounts Help';
$string['help_user_matchswitchauth_help'] = 'This requires the "Match preexisting Moodle users" setting above to be enabled. When a user is matched, enabling this setting will switch their authentication method to OpenID Connect. They will then be able to log in to Moodle with their Microsoft 365 credentials. Note: Please ensure that the OpenID Connect authentication plugin is enabled if you want to use this setting.';
$string['help_user_appassign'] = 'Assign Users To Application Help';
$string['help_user_appassign_help'] = 'This will cause all the Azure AD accounts with matching Moodle accounts to be assigned to the Azure application created for this Moodle installation, if not already assigned.';
$string['help_user_photosync'] = 'Sync Microsoft 365 Profile Photos (Cron) Help';
$string['help_user_photosync_help'] = 'This will cause all users\' Moodle profile photos to get synced with their Microsoft 365 profile photos.';
$string['help_user_photosynconlogin'] = 'Sync Microsoft 365 Profile Photos (Login) Help';
$string['help_user_photosynconlogin_help'] = 'This will cause a user\'s Moodle profile photo to get synced with their Microsoft 365 profile photo when that user logs in. Note this requires user visiting a page containing the Microsoft block in Moodle.';
$string['help_user_nodelta'] = 'Perform a full sync help';
$string['help_user_nodelta_help'] = 'By default, user sync will only sync changes from Azure AD. Checking this option will force a full user sync each time.';
$string['help_user_emailsync'] = 'Sync azure usernames to moodle emails Help';
$string['help_user_emailsync_help'] = 'Enabling this option will match azure usernames to moodle emails, instead of the default behaviour which is azure usernames to moodle usernames.';
$string['help_user_tzsync'] = 'Sync Outlook timezone (Cron) Help';
$string['help_user_tzsync_help'] = 'This will cause all users\' Moodle timezone to get synced with their Outlook timezone preference.';
$string['help_user_tzsynconlogin'] = 'Sync Outlook timezone (Login) Help';
$string['help_user_tzsynconlogin_help'] = 'This will cause a user\'s Moodle timezone to get synced with their Outlook timezone preference. Note this requires user visiting a page containing the Microsoft block in Moodle.';

$string['assignment'] = 'Assignment';
$string['course_assignment_submitted_due'] = 'Course - {$a->course} &nbsp; |  &nbsp; Assignment -{$a->assignment} <br />
                        Submitted on - {$a->submittedon} &nbsp; |  &nbsp; Due date - {$a->duedate}';
$string['due_date'] = 'Due date - {$a}';
$string['grade_date'] = 'Grade - {$a->grade} &nbsp; | &nbsp; Date - {$a->date}';
$string['help_message'] = 'Hi there! I am your Moodle assistant. You can ask me the following questions:';
$string['last_login_date'] = 'Last login date - {$a}';
$string['list_of_absent_students'] = 'This is the list of students that were absent this month:';
$string['list_of_assignments_grades_compared'] = 'This is the list of your assignments grades compared with class average:';
$string['list_of_assignments_needs_grading'] = 'This is the list of the assignments that need grading:';
$string['list_of_due_assignments'] = 'This is the list of due assignments';
$string['list_of_incomplete_assignments'] = 'This is the list of the assignments that are incomplete:';
$string['list_of_last_logged_students'] = 'This is the list of last logged students:';
$string['list_of_late_submissions'] = 'This is the list of students who made late submissions:';
$string['list_of_latest_logged_students'] = 'This is the list of latest logged students:';
$string['list_of_recent_grades'] = 'This is the list of your recent grades:';
$string['list_of_students_with_least_score'] = 'This is the list of students with least score in the latest assignment:';
$string['list_of_students_with_name'] = 'These are the students with the name {$a}:';
$string['never'] = 'Never';
$string['no_absent_users_found'] = 'No absent users found';
$string['no_assignments_for_grading_found'] = 'No assignments for grading found';
$string['no_assignments_found'] = 'No assignments found';
$string['no_due_assignments_found'] = 'No due assignments found';
$string['no_due_incomplete_assignments_found'] = 'No due and incomplete assignments found';
$string['no_graded_assignments_found'] = 'No graded assignments found';
$string['no_grades_found'] = 'No grades found';
$string['no_late_submissions_found'] = 'No late submissions found';
$string['no_users_found'] = 'No users found';
$string['no_user_with_name_found'] = 'No user with such name found';
$string['participants_submitted_needs_grading'] = 'Participants - {$a->participants}  &nbsp; |  &nbsp; Submitted - {$a->submitted}  &nbsp; |  &nbsp;
                        Needs grading - {$a->needsgrading}';
$string['pending_submissions_due_date'] = 'Pending submissions - {$a->incomplete} / {$a->total} &nbsp; |  &nbsp; Due - {$a->duedate}';
$string['sorry_do_not_understand'] = 'Sorry, I do not understand';
$string['question_student_assignments_compared'] = "How did I do in my latest assignments compared to the class?";
$string['question_student_assignments_due'] = "Which assignments are due next?";
$string['question_student_latest_grades'] = "What are the latest grades I've received?";
$string['question_teacher_absent_students'] = "Which students have been absent this month?";
$string['question_teacher_assignments_incomplete_submissions'] = "How many assignments have incomplete submissions?";
$string['question_teacher_assignments_for_grading'] = "Which assignments are yet to be graded?";
$string['question_teacher_last_logged_students'] = "Which students have logged into Moodle (most recent first)?";
$string['question_teacher_late_submissions'] = "Which students have made late submissions?";
$string['question_teacher_latest_logged_students'] = "Which students have logged into Moodle (oldest first)?";
$string['question_teacher_least_scored_in_assignment'] = "Which students scored the least in the last assignment?";
$string['question_teacher_student_last_logged'] = "When did Firstname Lastname last log into moodle?";
$string['your_grade'] = 'Your grade - {$a}';
$string['your_grade_class_grade'] = 'Your grade - {$a->usergrade} &nbsp; |  &nbsp; Class average grade - {$a->classgrade}';
$string['error_missing_app_id'] = 'Missing Application ID setting.';
$string['error_missing_bot_settings'] = 'Bot feature is enabled, but bot settings are missing.';
$string['errornodirectaccess'] = 'Direct access to the page is prohibited';

// Teams page.
$string['teams_no_course'] = 'You don\'t have any course to add.';
$string['tab_name'] = 'Tab name';
$string['tab_moodle'] = 'Moodle';
$string['sso_login'] = 'Login to Microsoft 365';
$string['other_login'] = 'Login manually';
$string['course_selector_label'] = "Select existing course";
