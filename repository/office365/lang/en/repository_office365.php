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
 * Language file
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Microsoft 365 Repository - Unified folder IDs';
$string['cachedef_unifiedgroupfolderids'] = 'Microsoft 365 Repository - Unified folder IDs for groups';
$string['configplugin'] = 'Configure Microsoft 365 Repository';
$string['controlledsharelinkdesc'] = 'Shared copy (organization members only)';
$string['copiedfile'] = 'Copy of file';
$string['coursegroup'] = 'Disable Groups (Courses) folder in file picker';
$string['defaultgroupsfolder'] = 'Course Files';
$string['directlinkdesc'] = 'Direct link (existing permissions)';
$string['enableanonymousshare'] = 'Enable "{$a}" option';
$string['enableanonymousshare_help'] = 'When checked, users can choose to create a copy of a file and share it with everyone in the organization. The copy is stored in the user\'s OneDrive and shared with all organization members.

**How It Works:**
* Creates a copy of the selected file with a " - Shared" suffix.
* The copy is saved to the user\'s OneDrive (not the original location).
* An organization-scoped sharing link is created for the copy.
* The original file remains unchanged with its existing permissions.

**Access Control:**
* Only members of your Microsoft 365 organization can access the file.
* Anyone in the organization with the link can VIEW the file.
* External users and anonymous users CANNOT access the file.
* The link does not expire automatically.
* The file owner can manage or revoke sharing from their OneDrive.

**When to Use:**
* You want to share a file with all organization members.
* You want to protect the original file from accidental changes.
* Storage space in Moodle is a concern.
* The file content is appropriate for organization-wide access.

**Important Notes:**
* The copy operation may take a few seconds for large files.
* Users should ensure the file content is appropriate for organization-wide sharing.
* The copied file will appear in the user\'s OneDrive with " - Shared" suffix.
* Changes made to the original file will NOT be reflected in the shared copy, and vice versa.

**This option is disabled by default due to display limitations and potential confusion. Check this box only if you want to allow users to create organization-shared copies.**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>Note:</strong> When using the "{$a}" option, a copy of the original file is created and shared with all organization members. The original file remains unchanged. Users should ensure the file content is appropriate for organization-wide access.
<br><br><strong>Display Limitations:</strong> Files shared using this option have limitations depending on the file type and display option used in resources. The behavior varies as follows:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Display Option</th>
<th>Images</th>
<th>Files (e.g. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatic</strong></td>
<td style="background-color: #ffdddd;">Not working - nothing displayed, connection blocked</td>
<td>Working - redirected to OneDrive</td>
</tr>
<tr>
<td><strong>Embed</strong></td>
<td>Working - image is embedded</td>
<td style="background-color: #ffdddd;">Not working - iframe showing refused to connect error</td>
</tr>
<tr>
<td><strong>Force download</strong></td>
<td colspan="2">Working - redirect to OneDrive</td>
</tr>
<tr>
<td><strong>Open</strong></td>
<td colspan="2">Working - redirect to OneDrive</td>
</tr>
<tr>
<td><strong>In pop-up</strong></td>
<td colspan="2">Working - open in pop-up</td>
</tr>
</tbody>
</table>
For best compatibility with all display options, consider copying the file to Moodle instead.</div>';
$string['enabledirectlink'] = 'Enable "{$a}" option';
$string['enabledirectlink_help'] = 'When checked, users can add a direct link to a file in their OneDrive instead of copying it to Moodle. The file remains in OneDrive and Moodle stores only a reference link.

**Important Access Control Considerations:**
* The file\'s existing OneDrive permissions are NOT changed.
* Users accessing the link must have appropriate permissions in OneDrive to view the file.
* It is the responsibility of the user adding the link to ensure proper access permissions.
* If OneDrive permissions are not set correctly, other users may be unable to access the file.

**When to use this option:**
* Files are already shared with the intended audience in Microsoft 365.
* You want to maintain a single source of truth in OneDrive.
* Storage space in Moodle is a concern.
* Edits to the OneDrive file should be reflected in Moodle.

**This option is disabled by default due to display limitations and access control complexities. Check this box only if you want to allow users to link files directly from OneDrive.**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>Note:</strong> When using the "{$a}" option, no sharing setting changes are made to the OneDrive file. Users adding the file must ensure that file permissions in OneDrive are set correctly.
<br><br><strong>Display Limitations:</strong> Files linked using this option have limitations depending on the file type and display option used in resources. The behavior varies as follows:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Display Option</th>
<th>Images</th>
<th>Files (e.g. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatic</strong></td>
<td style="background-color: #ffdddd;">Not working - nothing displayed, connection blocked</td>
<td>Redirected to OneDrive, working if the user has permission to access the OneDrive file, otherwise showing permission denied page</td>
</tr>
<tr>
<td><strong>Embed</strong></td>
<td style="background-color: #ffdddd;">Not working - nothing displayed, connection blocked</td>
<td style="background-color: #ffdddd;">Not working - refused to connect error displayed in embedded iframe</td>
</tr>
<tr>
<td><strong>Force download</strong></td>
<td colspan="2">Redirected to OneDrive, working if the user has permission to access the OneDrive file, otherwise showing permission denied page</td>
</tr>
<tr>
<td><strong>Open</strong></td>
<td colspan="2">Redirected to OneDrive, working if the user has permission to access the OneDrive file, otherwise showing permission denied page</td>
</tr>
<tr>
<td><strong>In pop-up</strong></td>
<td colspan="2">Open in pop-up, working if the user has permission to access the OneDrive file, otherwise showing permission denied page</td>
</tr>
</tbody>
</table>
For best compatibility, consider copying the file to Moodle instead of using a direct link.</div>';

$string['erroraccessdenied'] = 'Access denied';
$string['errorauthoidcnotconfig'] = 'Please configure the OpenID Connect authentication plugin before attempting to use the Microsoft 365 repository.';
$string['errorbadclienttype'] = 'Invalid client type.';
$string['errorbadpath'] = 'Bad Path';
$string['errorcoursenotfound'] = 'Course not found';
$string['erroro365required'] = 'This file is currently only available to Microsoft 365 users.';
$string['errorwhiledownload'] = 'An error occurred while downloading the file';
$string['errorwhilesharing'] = 'An error occurred while creating a sharable link';

$string['file'] = 'File';
$string['filelinkingheader'] = 'File linking options';
$string['groups'] = 'Groups (Courses)';
$string['myfiles'] = 'My OneDrive';
$string['notconfigured'] = '<p class="error">To use this plugin, you must first configure the <a href="{$a}/admin/settings.php?section=local_o365">Microsoft 365 plugins</a></p>';
$string['office365:view'] = 'View Microsoft 365 repository';
$string['onedrivegroup'] = 'Disable My OneDrive folder in file picker';
$string['pluginname'] = 'Microsoft 365';
$string['pluginname_help'] = 'A Microsoft 365 Repository';
$string['privacy:metadata'] = 'This plugin communicates with the Microsoft 365 OneDrive API as the current user. Any files uploaded will be sent to the remote server';
$string['trendingaround'] = 'Files Trending Around Me';
$string['trendinggroup'] = 'Disable Files Trending Around Me folder in file picker';
$string['upload'] = 'Upload New File';
