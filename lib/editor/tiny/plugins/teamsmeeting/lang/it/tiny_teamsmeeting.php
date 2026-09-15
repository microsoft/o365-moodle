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
 * Strings for component 'tiny_teamsmeeting', language 'it'.
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
$string['settings_meetings_app_link'] = 'URL dell’app Riunioni';
$string['settings_meetings_app_link_desc'] = 'Questo è l’URL dell’app Riunioni.';

// Capability.
$string['teamsmeeting:add'] = 'Aggiungi riunione Teams';

// IFrame.
$string['iframe_meeting_options'] = 'Opzioni riunione';
$string['iframe_meeting_created'] = 'Riunione "{$a}" creata correttamente!';
$string['iframe_meeting_details'] = 'Riunione "{$a}"';
$string['iframe_go_to_meeting'] = 'Vai alla riunione';
$string['iframe_add_link'] = 'Aggiungi link';
$string['iframe_new_window_label'] = 'Apri la riunione in una nuova finestra';
$string['iframe_not_found'] = 'Riunione non trovata';
$string['invalidtoken'] = 'Il token di callback della riunione è mancante, non valido o scaduto. Chiudi questa finestra e prova a creare di nuovo la riunione.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Crea riunione Teams';
$string['tiny_edit_modal_title'] = 'Riunione Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'Il plugin Tiny Teams Meeting memorizza i dati delle riunioni create dagli utenti, incluso l’ID utente e il contesto in cui è stata creata ciascuna riunione.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Dettagli delle riunioni Teams create tramite l’editor TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'L’ID dell’utente che ha creato la riunione.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Il contesto in cui è stata creata la riunione.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Il titolo della riunione.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'L’URL di partecipazione alla riunione.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'L’URL della pagina delle opzioni della riunione.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'La data e l’ora di creazione del record della riunione.';
$string['privacy:metadata:msteamsapp'] = 'Per creare una riunione, il plugin Tiny Teams Meeting scambia dati con l’app riunioni di Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'L’ID del corso in cui viene creata la riunione viene inviato all’app riunioni di Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'L’URL di questo sito Moodle viene inviato all’app riunioni di Microsoft Teams affinché possa restituire il link della riunione nel posto corretto.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Il codice lingua dell’utente viene inviato all’app riunioni di Microsoft Teams affinché la sua interfaccia corrisponda alla lingua dell’utente.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
