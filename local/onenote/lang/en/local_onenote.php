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
 * Language file definitions for OneNote local plugin
 *
 * @package    local_onenote
 */

$string['configplugin'] = 'Configure Microsoft OneNote';
$string['oauthinfo'] = '<p>To use this plugin, you must register your site <a href=\'https://account.live.com/developers/applications\'>with Microsoft</a>.<p>As part of the registration process, you will need to enter the following URL as \'Redirect domain\':</p><p>{$a->callbackurl}</p>Once registered, you will be provided with a client ID and secret which can be entered here.</p>';
$string['pluginname'] = 'Microsoft OneNote';
$string['secret'] = 'Secret';
$string['signin'] = 'Sign in to OneNote';
$string['submissiontitle'] = 'Submission: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'Feedback: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['clientid'] = 'OneNote client ID';
$string['clientiddetails'] = 'Enter the OneNote client ID from the <a target="_blank" href="https://account.live.com/developers/applications\">Live App management site</a>';
$string['clientsecret'] = 'OneNote client secret';
$string['clientsecretdetails'] = 'Enter the OneNote client secret from the <a target="_blank" href="https://account.live.com/developers/applications\">Live App management site</a>';
$string['redirect'] = 'OneNote redirect URI';
$string['redirectdetails'] = 'Redirect uri from the <a target="_blank" href="https://account.live.com/developers/applications\">Live App management site</a>';
