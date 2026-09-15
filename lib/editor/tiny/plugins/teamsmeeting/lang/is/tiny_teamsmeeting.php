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
 * Strings for component 'tiny_teamsmeeting', language 'is'.
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
$string['settings_meetings_app_link'] = 'Vefslóð fundaforritsins';
$string['settings_meetings_app_link_desc'] = 'Þetta er vefslóð fundaforritsins.';

// Capability.
$string['teamsmeeting:add'] = 'Bæta við Teams-fundi';

// IFrame.
$string['iframe_meeting_options'] = 'Fundarvalkostir';
$string['iframe_meeting_created'] = 'Fundurinn "{$a}" var stofnaður!';
$string['iframe_meeting_details'] = 'Fundur "{$a}"';
$string['iframe_go_to_meeting'] = 'Fara á fundinn';
$string['iframe_add_link'] = 'Bæta við tengli';
$string['iframe_new_window_label'] = 'Opna fundinn í nýjum glugga';
$string['iframe_not_found'] = 'Fundur fannst ekki';
$string['invalidtoken'] = 'Endurkvaðningarteikn fundarins er ekki til staðar, ógilt eða útrunnið. Lokaðu þessum glugga og reyndu að stofna fundinn aftur.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Stofna Teams-fund';
$string['tiny_edit_modal_title'] = 'Teams-fundur';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tiny Teams Meeting-viðbótin vistar fundaskrár sem notendur stofna, þar á meðal auðkenni notandans og samhengið sem hver fundur var stofnaður í.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Upplýsingar um Teams-fundi sem stofnaðir eru með TinyMCE-ritlinum.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'Auðkenni notandans sem stofnaði fundinn.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Samhengið sem fundurinn var stofnaður í.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Titill fundarins.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'Vefslóðin til að taka þátt í fundinum.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'Vefslóð síðunnar með fundarvalkostum.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Tímasetningin þegar fundarskráin var stofnuð.';
$string['privacy:metadata:msteamsapp'] = 'Til að stofna fund skiptist Tiny Teams Meeting-viðbótin á gögnum við fundarforrit Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'Auðkenni námskeiðsins sem fundurinn er stofnaður í er sent til fundarforrits Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'Vefslóð þessa Moodle-vefsvæðis er send til fundarforrits Microsoft Teams svo að það geti sent fundartengilinn á réttan stað.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Tungumálakóði notandans er sendur til fundarforrits Microsoft Teams svo að notandaviðmót þess samsvari tungumáli notandans.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
