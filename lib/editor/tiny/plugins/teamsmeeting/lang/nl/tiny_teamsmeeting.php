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
 * Strings for component 'tiny_teamsmeeting', language 'nl'.
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
$string['settings_meetings_app_link'] = 'URL van de vergader-app';
$string['settings_meetings_app_link_desc'] = 'Dit is de URL van de vergader-app.';

// Capability.
$string['teamsmeeting:add'] = 'Teams-vergadering toevoegen';

// IFrame.
$string['iframe_meeting_options'] = 'Vergaderopties';
$string['iframe_meeting_created'] = 'Vergadering "{$a}" is met succes aangemaakt!';
$string['iframe_meeting_details'] = 'Vergadering "{$a}"';
$string['iframe_go_to_meeting'] = 'Ga naar de vergadering';
$string['iframe_add_link'] = 'Koppeling toevoegen';
$string['iframe_new_window_label'] = 'Vergadering openen in een nieuw venster';
$string['iframe_not_found'] = 'Vergadering niet gevonden';
$string['invalidtoken'] = 'Het callback-token van de vergadering ontbreekt, is ongeldig of is verlopen. Sluit dit venster en probeer de vergadering opnieuw aan te maken.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Teams-vergadering maken';
$string['tiny_edit_modal_title'] = 'Teams-vergadering';

// Privacy subsystem.
$string['privacy:metadata'] = 'De Tiny Teams Meeting-plug-in slaat vergaderingen op die door gebruikers zijn aangemaakt, inclusief de gebruikers-ID en de context waarin elke vergadering is aangemaakt.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Details van Teams-vergaderingen die zijn aangemaakt via de TinyMCE-editor.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'De ID van de gebruiker die de vergadering heeft aangemaakt.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'De context waarin de vergadering is aangemaakt.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'De titel van de vergadering.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'De deelname-URL voor de vergadering.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'De URL voor de pagina met vergaderopties.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Het tijdstip waarop het vergaderrecord is aangemaakt.';
$string['privacy:metadata:msteamsapp'] = 'Om een vergadering aan te maken, wisselt de Tiny Teams Meeting-plug-in gegevens uit met de Microsoft Teams-vergaderapp.';
$string['privacy:metadata:msteamsapp:courseid'] = 'De ID van de cursus waarin de vergadering wordt aangemaakt, wordt naar de Microsoft Teams-vergaderapp verzonden.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'De URL van deze Moodle-site wordt naar de Microsoft Teams-vergaderapp verzonden, zodat deze de vergaderkoppeling naar de juiste plaats kan terugsturen.';
$string['privacy:metadata:msteamsapp:userlang'] = 'De taalcode van de gebruiker wordt naar de Microsoft Teams-vergaderapp verzonden, zodat de gebruikersinterface overeenkomt met de taal van de gebruiker.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
