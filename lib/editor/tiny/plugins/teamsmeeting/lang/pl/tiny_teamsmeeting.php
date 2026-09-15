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

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Teams Meeting';

// Settings.
$string['settings_meetings_app_link'] = 'Link do Teams Meeting';
$string['settings_meetings_app_link_desc'] = 'Link do aplikacji Teams Meeting';

// Capability.
$string['teamsmeeting:add'] = 'Dodawanie spotkania Teams';

// IFrame.
$string['iframe_meeting_options'] = 'Opcje spotkania';
$string['iframe_meeting_created'] = 'Spotkanie online "{$a}" utworzone!';
$string['iframe_meeting_details'] = 'Spotkanie "{$a}"';
$string['iframe_go_to_meeting'] = 'Przejdź do spotkania';
$string['iframe_add_link'] = 'Dodaj link';
$string['iframe_new_window_label'] = 'Otwórz spotkanie w nowym oknie';
$string['iframe_not_found'] = 'Nie znaleziono spotkania';
$string['invalidtoken'] = 'Token wywołania zwrotnego spotkania jest nieprawidłowy lub wygasł. Zamknij to okno i spróbuj ponownie utworzyć spotkanie.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Utwórz Teams Meeting';
$string['tiny_edit_modal_title'] = 'Spotkanie Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'Wtyczka Tiny Teams Meeting przechowuje rekordy spotkań utworzonych przez użytkowników, w tym identyfikator użytkownika oraz kontekst, w którym utworzono spotkanie.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Szczegóły spotkań Teams utworzonych za pomocą edytora TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'Identyfikator użytkownika, który utworzył spotkanie.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Kontekst, w którym utworzono spotkanie.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Tytuł spotkania.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'Adres URL dołączenia do spotkania.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'Adres URL strony opcji spotkania.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Czas utworzenia rekordu spotkania.';
$string['privacy:metadata:msteamsapp'] = 'Aby utworzyć spotkanie, wtyczka Tiny Teams Meeting wymienia dane z aplikacją spotkań Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'Identyfikator kursu, w którym tworzone jest spotkanie, jest wysyłany do aplikacji spotkań Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'Adres URL tej witryny Moodle jest wysyłany do aplikacji spotkań Microsoft Teams, aby mogła zwrócić link do spotkania we właściwe miejsce.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Kod języka użytkownika jest wysyłany do aplikacji spotkań Microsoft Teams, aby jej interfejs był zgodny z językiem użytkownika.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
