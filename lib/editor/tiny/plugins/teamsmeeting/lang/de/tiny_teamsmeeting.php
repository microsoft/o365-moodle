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
 * Strings for component 'tiny_teamsmeeting', language 'de'.
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
$string['settings_meetings_app_link'] = 'URL der Meetings-App';
$string['settings_meetings_app_link_desc'] = 'Dies ist die URL der Meetings-App.';

// Capability.
$string['teamsmeeting:add'] = 'Teams-Besprechung hinzufügen';

// IFrame.
$string['iframe_meeting_options'] = 'Besprechungsoptionen';
$string['iframe_meeting_created'] = 'Besprechung "{$a}" wurde erfolgreich erstellt!';
$string['iframe_meeting_details'] = 'Besprechung "{$a}"';
$string['iframe_go_to_meeting'] = 'Zur Besprechung wechseln';
$string['iframe_add_link'] = 'Link hinzufügen';
$string['iframe_new_window_label'] = 'Besprechung in neuem Fenster öffnen';
$string['iframe_not_found'] = 'Besprechung nicht gefunden';
$string['invalidtoken'] = 'Das Rückruf-Token der Besprechung fehlt, ist ungültig oder abgelaufen. Schließen Sie dieses Fenster und versuchen Sie erneut, die Besprechung zu erstellen.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Teams-Besprechung erstellen';
$string['tiny_edit_modal_title'] = 'Teams-Besprechung';

// Privacy subsystem.
$string['privacy:metadata'] = 'Das Tiny-Teams-Meeting-Plugin speichert von Benutzern erstellte Besprechungsdatensätze, einschließlich der Benutzer-ID und des Kontexts, in dem jede Besprechung erstellt wurde.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Details zu Teams-Besprechungen, die über den TinyMCE-Editor erstellt wurden.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'Die ID des Benutzers, der die Besprechung erstellt hat.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Der Kontext, in dem die Besprechung erstellt wurde.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Der Titel der Besprechung.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'Die Beitritts-URL für die Besprechung.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'Die URL für die Seite mit den Besprechungsoptionen.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Der Zeitpunkt, zu dem der Besprechungsdatensatz erstellt wurde.';
$string['privacy:metadata:msteamsapp'] = 'Um eine Besprechung zu erstellen, tauscht das Tiny-Teams-Meeting-Plugin Daten mit der Microsoft Teams-Besprechungsanwendung aus.';
$string['privacy:metadata:msteamsapp:courseid'] = 'Die ID des Kurses, in dem die Besprechung erstellt wird, wird an die Microsoft Teams-Besprechungsanwendung gesendet.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'Die URL dieser Moodle-Website wird an die Microsoft Teams-Besprechungsanwendung gesendet, damit sie den Besprechungslink an die richtige Stelle zurückgeben kann.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Der Sprachcode des Benutzers wird an die Microsoft Teams-Besprechungsanwendung gesendet, damit die Benutzeroberfläche der Sprache des Benutzers entspricht.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
