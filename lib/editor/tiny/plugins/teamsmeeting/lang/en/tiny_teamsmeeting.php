<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Strings for component 'tiny_teamsmeeting', language 'en'.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Teams Meeting';

// Settings.
$string['settings_meetings_app_link'] = 'Meetings App URL';
$string['settings_meetings_app_link_desc'] = 'This is the URL of the Meetings app.';

// Capability.
$string['teamsmeeting:add'] = 'Add Teams Meeting';

// IFrame.
$string['iframe_meeting_options'] = 'Meeting Options';
$string['iframe_meeting_created'] = 'Meeting "{$a}" was created successfully!';
$string['iframe_go_to_meeting'] = 'Go to meeting';
$string['iframe_not_found'] = 'Meeting not found';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Create Teams meeting';
$string['tiny_button_primary_label'] = 'Add link';
$string['tiny_button_secondary_label'] = 'Cancel';
$string['tiny_input_url_label'] = 'Your meeting URL:';
$string['tiny_input_url_placeholder'] = 'Link will be generated after you create the meeting.';
$string['tiny_checkbox_new_window_label'] = 'Open meeting in new window';

// Privacy subsystem.
$string['privacy:metadata'] = 'The Tiny Teams Meeting plugin stores meeting records created by users, including the user ID and the context in which each meeting was created.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Details of Teams meetings created via the TinyMCE editor.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'The ID of the user who created the meeting.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'The context in which the meeting was created.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'The title of the meeting.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'The join URL for the meeting.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'The URL for the meeting options page.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'The time at which the meeting record was created.';
$string['privacy:metadata:msteamsapp'] = 'The Tiny Teams Meeting plugin does not store any data. However, it sends user language code to Microsoft Teams application to provide user interface based on user language.';
$string['privacy:metadata:msteamsapp:userlang'] = 'User language code sent to Microsoft Teams application.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
