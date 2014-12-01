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

$string['eventcalendarsubscribed'] = 'User subscribed to a calendar';
$string['eventcalendarunsubscribed'] = 'User unsubscribed from a calendar';

$string['settings_aadsync'] = 'Sync users from AzureAD';
$string['settings_aadsync_details'] = 'If enabled, users in the associated AzureAD directory will be synced to Moodle. This will create users in Moodle that exist in AzureAD, and delete Moodle users created from AzureAD when they are deleted from AzureAD.';
$string['settings_sharepointinit'] = 'Initialize Sharepoint Sites';
$string['settings_sharepointinit_details'] = 'This will create a sharepoint site for Moodle and subsites for all courses. Once initialized, courses will be able to use these sharepoint sites to share information between users.';
$string['settings_sharepointinit_initialize'] = 'Initialize';
$string['settings_sharepointinit_initialized'] = 'Sharepoint has been initialized';
$string['settings_sharepointinit_setsystemapiuser'] = 'Set the system API user first.';
$string['settings_systemapiuser'] = 'System API User';
$string['settings_systemapiuser_details'] = 'For operations that are not user-specific, ex. managing course sharepoint sites, Moodle needs a user to communicate as. This can be any AzureAD user, but should be either the account of an administrator, or a dedicated account.';
$string['settings_systemapiuser_change'] = 'Change User';
$string['settings_systemapiuser_usernotset'] = 'No user set.';
$string['settings_systemapiuser_userset'] = '{$a}';
$string['settings_systemapiuser_setuser'] = 'Set User';
$string['settings_tenant'] = 'AAD Tenant';
$string['settings_tenant_details'] = 'The AAD tenant';

$string['ucp_general_intro'] = 'Here you can manage your connection to Office 365.';
$string['ucp_title'] = 'Office365 Connection Management';
$string['ucp_calsync_title'] = 'Outlook Calendar Sync';
$string['ucp_calsync_desc'] = 'Checked calendars will be synced from Moodle to your Outlook calendar.';