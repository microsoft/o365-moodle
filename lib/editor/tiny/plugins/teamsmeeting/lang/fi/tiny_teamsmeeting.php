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
 * Strings for component 'tiny_teamsmeeting', language 'fi'.
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
$string['settings_meetings_app_link'] = 'Kokoussovelluksen URL-osoite';
$string['settings_meetings_app_link_desc'] = 'Tämä on kokoussovelluksen URL-osoite.';

// Capability.
$string['teamsmeeting:add'] = 'Lisää Teams-kokous';

// IFrame.
$string['iframe_meeting_options'] = 'Kokousasetukset';
$string['iframe_meeting_created'] = 'Kokous "{$a}" luotiin onnistuneesti!';
$string['iframe_meeting_details'] = 'Kokous "{$a}"';
$string['iframe_go_to_meeting'] = 'Siirry kokoukseen';
$string['iframe_add_link'] = 'Lisää linkki';
$string['iframe_new_window_label'] = 'Avaa kokous uudessa ikkunassa';
$string['iframe_not_found'] = 'Kokousta ei löytynyt';
$string['invalidtoken'] = 'Kokouksen callback-tunniste puuttuu, on virheellinen tai on vanhentunut. Sulje tämä ikkuna ja yritä luoda kokous uudelleen.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Luo Teams-kokous';
$string['tiny_edit_modal_title'] = 'Teams-kokous';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tiny Teams Meeting -lisäosa tallentaa käyttäjien luomat kokoustiedot, mukaan lukien käyttäjätunnuksen ja kontekstin, jossa kukin kokous luotiin.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Tietoja TinyMCE-editorin avulla luoduista Teams-kokouksista.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'Kokouksen luoneen käyttäjän tunniste.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Konteksti, jossa kokous luotiin.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Kokouksen otsikko.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'Kokoukseen liittymisen URL-osoite.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'Kokousasetussivun URL-osoite.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Ajankohta, jolloin kokoustietue luotiin.';
$string['privacy:metadata:msteamsapp'] = 'Kokouksen luomista varten Tiny Teams Meeting -lisäosa vaihtaa tietoja Microsoft Teams -kokoussovelluksen kanssa.';
$string['privacy:metadata:msteamsapp:courseid'] = 'Kurssin tunniste, jolla kokous luodaan, lähetetään Microsoft Teams -kokoussovellukseen.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'Tämän Moodle-sivuston URL-osoite lähetetään Microsoft Teams -kokoussovellukseen, jotta se voi palauttaa kokouslinkin oikeaan paikkaan.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Käyttäjän kielikoodi lähetetään Microsoft Teams -kokoussovellukseen, jotta sen käyttöliittymä vastaa käyttäjän kieltä.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
