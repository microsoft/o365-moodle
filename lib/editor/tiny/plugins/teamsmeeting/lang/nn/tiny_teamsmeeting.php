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
 * Strings for component 'tiny_teamsmeeting', language 'nn'.
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
$string['settings_meetings_app_link'] = 'URL til møteappen';
$string['settings_meetings_app_link_desc'] = 'Dette er URL-en til møteappen.';

// Capability.
$string['teamsmeeting:add'] = 'Legg til Teams-møte';

// IFrame.
$string['iframe_meeting_options'] = 'Møtealternativ';
$string['iframe_meeting_created'] = 'Møtet "{$a}" blei oppretta!';
$string['iframe_meeting_details'] = 'Møte "{$a}"';
$string['iframe_go_to_meeting'] = 'Gå til møtet';
$string['iframe_add_link'] = 'Legg til lenke';
$string['iframe_new_window_label'] = 'Opne møtet i eit nytt vindauge';
$string['iframe_not_found'] = 'Møtet blei ikkje funne';
$string['invalidtoken'] = 'Tilbakekalls-tokenet til møtet manglar, er ugyldig eller har gått ut. Lat att dette vindauget og prøv å opprette møtet på nytt.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Opprett Teams-møte';
$string['tiny_edit_modal_title'] = 'Teams-møte';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tillegget Tiny Teams Meeting lagrar møte som er oppretta av brukarar, inkludert bruker-ID-en og konteksten møtet blei oppretta i.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Detaljar om Teams-møte oppretta via TinyMCE-redigeringsprogrammet.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'ID-en til brukaren som oppretta møtet.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Konteksten møtet blei oppretta i.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Tittelen på møtet.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'URL-en for å delta i møtet.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'URL-en til sida med møtealternativ.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Tidspunktet møteposten blei oppretta.';
$string['privacy:metadata:msteamsapp'] = 'For å opprette eit møte utvekslar tillegget Tiny Teams Meeting data med Microsoft Teams-møteappen.';
$string['privacy:metadata:msteamsapp:courseid'] = 'ID-en til kurset møtet blir oppretta i, blir sendt til Microsoft Teams-møteappen.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'URL-en til denne Moodle-nettstaden blir sendt til Microsoft Teams-møteappen, slik at den kan returnere møtelenka til rett plass.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Språkkoden til brukaren blir sendt til Microsoft Teams-møteappen, slik at brukargrensesnittet samsvarer med språket til brukaren.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
