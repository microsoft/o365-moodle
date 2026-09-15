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
 * Strings for component 'tiny_teamsmeeting', language 'da'.
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
$string['settings_meetings_app_link'] = 'URL-adresse til mødeapp';
$string['settings_meetings_app_link_desc'] = 'Dette er URL-adressen til mødeappen.';

// Capability.
$string['teamsmeeting:add'] = 'Tilføj Teams-møde';

// IFrame.
$string['iframe_meeting_options'] = 'Mødeindstillinger';
$string['iframe_meeting_created'] = 'Mødet "{$a}" blev oprettet!';
$string['iframe_meeting_details'] = 'Møde "{$a}"';
$string['iframe_go_to_meeting'] = 'Gå til mødet';
$string['iframe_add_link'] = 'Tilføj link';
$string['iframe_new_window_label'] = 'Åbn mødet i et nyt vindue';
$string['iframe_not_found'] = 'Møde ikke fundet';
$string['invalidtoken'] = 'Mødets callback-token mangler, er ugyldigt eller er udløbet. Luk dette vindue, og forsøg at oprette mødet igen.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Opret Teams-møde';
$string['tiny_edit_modal_title'] = 'Teams-møde';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tiny Teams Meeting-udvidelsen gemmer møder oprettet af brugere, herunder bruger-id og den kontekst, hvor hvert møde blev oprettet.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Oplysninger om Teams-møder oprettet via TinyMCE-editoren.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'ID for den bruger, der oprettede mødet.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Den kontekst, hvor mødet blev oprettet.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Mødets titel.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'URL-adressen for at deltage i mødet.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'URL-adressen til siden med mødeindstillinger.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Tidspunktet, hvor mødeposten blev oprettet.';
$string['privacy:metadata:msteamsapp'] = 'For at oprette et møde udveksler Tiny Teams Meeting-udvidelsen data med Microsoft Teams-mødeappen.';
$string['privacy:metadata:msteamsapp:courseid'] = 'ID for det kursus, mødet oprettes i, sendes til Microsoft Teams-mødeappen.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'URL-adressen for dette Moodle-websted sendes til Microsoft Teams-mødeappen, så den kan returnere mødelinket til det korrekte sted.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Brugerens sprogkode sendes til Microsoft Teams-mødeappen, så dens brugergrænseflade svarer til brugerens sprog.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
