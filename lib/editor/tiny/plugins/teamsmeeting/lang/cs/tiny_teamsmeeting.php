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
 * Strings for component 'tiny_teamsmeeting', language 'cs'.
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
$string['settings_meetings_app_link'] = 'URL adresa aplikace Schůzky';
$string['settings_meetings_app_link_desc'] = 'Toto je URL adresa aplikace Schůzky.';

// Capability.
$string['teamsmeeting:add'] = 'Přidat schůzku Teams';

// IFrame.
$string['iframe_meeting_options'] = 'Možnosti schůzky';
$string['iframe_meeting_created'] = 'Schůzka "{$a}" byla úspěšně vytvořena!';
$string['iframe_meeting_details'] = 'Schůzka "{$a}"';
$string['iframe_go_to_meeting'] = 'Přejít na schůzku';
$string['iframe_add_link'] = 'Přidat odkaz';
$string['iframe_new_window_label'] = 'Otevřít schůzku v novém okně';
$string['iframe_not_found'] = 'Schůzka nebyla nalezena';
$string['invalidtoken'] = 'Token pro zpětné volání schůzky chybí, je neplatný nebo vypršel. Zavřete toto okno a zkuste schůzku vytvořit znovu.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Vytvořit schůzku Teams';
$string['tiny_edit_modal_title'] = 'Schůzka Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'Modul Tiny Teams Meeting ukládá záznamy o schůzkách vytvořených uživateli, včetně ID uživatele a kontextu, ve kterém byla každá schůzka vytvořena.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Podrobnosti o schůzkách Teams vytvořených prostřednictvím editoru TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'ID uživatele, který schůzku vytvořil.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Kontext, ve kterém byla schůzka vytvořena.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Název schůzky.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'URL adresa pro připojení ke schůzce.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'URL adresa stránky s možnostmi schůzky.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Čas, kdy byl záznam o schůzce vytvořen.';
$string['privacy:metadata:msteamsapp'] = 'Za účelem vytvoření schůzky si modul Tiny Teams Meeting vyměňuje data s aplikací Microsoft Teams pro schůzky.';
$string['privacy:metadata:msteamsapp:courseid'] = 'ID kurzu, ve kterém je schůzka vytvářena, je odesláno do aplikace Microsoft Teams pro schůzky.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'URL adresa tohoto webu Moodle je odeslána do aplikace Microsoft Teams pro schůzky, aby mohla odkaz na schůzku vrátit na správné místo.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Jazykový kód uživatele je odeslán do aplikace Microsoft Teams pro schůzky, aby jeho uživatelské rozhraní odpovídalo jazyku uživatele.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
