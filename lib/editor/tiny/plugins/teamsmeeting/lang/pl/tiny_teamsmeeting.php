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
 * Strings for component 'tiny_teamsmeeting', language 'pl'.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Teams Meeting';
$string['settings'] = 'Ustawienia Teams Meeting';

// Settings.
$string['settings_meetings_app_link'] = 'Link do Teams Meeting';
$string['settings_meetings_app_link_desc'] = 'Link do aplikacji Teams Meeting';

// iFrame.
$string['iframe_meeting_options'] = 'Opcje spotkania';
$string['iframe_meeting_created'] = 'Spotkanie online "{$a}" utworzone!';
$string['iframe_go_to_meeting'] = 'Go to meeting';
$string['iframe_not_found'] = 'Nie znaleziono spotkania';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Utwórz Teams Meeting';
$string['tiny_button_primary_label'] = 'Dodaj link';
$string['tiny_button_secondary_label'] = 'Anuluj';
$string['tiny_input_url_label'] = 'Link Twojego spotkania:';
$string['tiny_input_url_placeholder'] = 'Link zostanie wygenerowany po utworzeniu spotkania.';
$string['tiny_checkbox_new_window_label'] = 'Otwórz w nowym oknie';

// Privacy subsystem.
$string['privacy:metadata'] = 'Wtyczka Tiny Teams Meeting nie przechowuje żadnych danych osobowych.';
$string['privacy:metadata:msteamsapp'] = 'Wtyczka Tiny Teams Meeting nie przechowuje żadnych danych. Jednak wysyła kod języka użytkownika do aplikacji Microsoft Teams, aby zapewnić interfejs użytkownika oparty na języku użytkownika.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Kod języka użytkownika jest wysyłany do aplikacji Microsoft Teams.';
