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
 * Strings for component 'tiny_teamsmeeting', language 'sv'.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2026 Enovation Solutions
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Teams Meeting';

// Settings.
$string['settings_meetings_app_link'] = 'URL till mötesappen';
$string['settings_meetings_app_link_desc'] = 'Detta är URL:en till mötesappen.';

// Capability.
$string['teamsmeeting:add'] = 'Lägg till Teams-möte';

// IFrame.
$string['iframe_meeting_options'] = 'Mötesalternativ';
$string['iframe_meeting_created'] = 'Mötet "{$a}" har skapats!';
$string['iframe_meeting_details'] = 'Möte "{$a}"';
$string['iframe_go_to_meeting'] = 'Gå till mötet';
$string['iframe_add_link'] = 'Lägg till länk';
$string['iframe_new_window_label'] = 'Öppna mötet i ett nytt fönster';
$string['iframe_not_found'] = 'Mötet hittades inte';
$string['invalidtoken'] = 'Mötets återanropstoken saknas, är ogiltig eller har gått ut. Stäng det här fönstret och försök skapa mötet igen.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Skapa Teams-möte';
$string['tiny_edit_modal_title'] = 'Teams-möte';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tillägget Tiny Teams Meeting lagrar möten som skapats av användare, inklusive användar-ID och den kontext där varje möte skapades.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Information om Teams-möten som skapats via TinyMCE-redigeraren.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'ID för den användare som skapade mötet.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Kontexten där mötet skapades.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Mötets titel.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'URL för att delta i mötet.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'URL till sidan med mötesalternativ.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Tidpunkten då mötesposten skapades.';
$string['privacy:metadata:msteamsapp'] = 'För att skapa ett möte utbyter tillägget Tiny Teams Meeting data med Microsoft Teams-mötesappen.';
$string['privacy:metadata:msteamsapp:courseid'] = 'ID för den kurs där mötet skapas skickas till Microsoft Teams-mötesappen.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'URL:en till den här Moodle-webbplatsen skickas till Microsoft Teams-mötesappen så att den kan skicka tillbaka möteslänken till rätt plats.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Användarens språkkod skickas till Microsoft Teams-mötesappen så att dess användargränssnitt matchar användarens språk.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
