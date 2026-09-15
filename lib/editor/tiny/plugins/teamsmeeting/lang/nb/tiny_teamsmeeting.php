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
 * Strings for component 'tiny_teamsmeeting', language 'nb'.
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
$string['iframe_meeting_options'] = 'Møtealternativer';
$string['iframe_meeting_created'] = 'Møtet "{$a}" ble opprettet!';
$string['iframe_meeting_details'] = 'Møte "{$a}"';
$string['iframe_go_to_meeting'] = 'Gå til møtet';
$string['iframe_add_link'] = 'Legg til lenke';
$string['iframe_new_window_label'] = 'Åpne møtet i et nytt vindu';
$string['iframe_not_found'] = 'Møtet ble ikke funnet';
$string['invalidtoken'] = 'Møtets tilbakekalls-token mangler, er ugyldig eller er utløpt. Lukk dette vinduet og prøv å opprette møtet på nytt.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Opprett Teams-møte';
$string['tiny_edit_modal_title'] = 'Teams-møte';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tillegget Tiny Teams Meeting lagrer møter som er opprettet av brukere, inkludert bruker-ID og konteksten møtet ble opprettet i.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Detaljer om Teams-møter opprettet via TinyMCE-redigeringsprogrammet.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'ID-en til brukeren som opprettet møtet.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Konteksten møtet ble opprettet i.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Møtets tittel.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'URL-en for å delta i møtet.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'URL-en til siden med møtealternativer.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Tidspunktet møteposten ble opprettet.';
$string['privacy:metadata:msteamsapp'] = 'For å opprette et møte utveksler tillegget Tiny Teams Meeting data med Microsoft Teams-møteappen.';
$string['privacy:metadata:msteamsapp:courseid'] = 'ID-en til kurset møtet opprettes i, sendes til Microsoft Teams-møteappen.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'URL-en til dette Moodle-nettstedet sendes til Microsoft Teams-møteappen, slik at den kan returnere møtelenken til riktig sted.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Brukerens språkkode sendes til Microsoft Teams-møteappen, slik at brukergrensesnittet samsvarer med brukerens språk.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
