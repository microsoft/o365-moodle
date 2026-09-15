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
 * Strings for component 'tiny_teamsmeeting', language 'cy'.
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
$string['settings_meetings_app_link'] = 'URL yr ap Cyfarfodydd';
$string['settings_meetings_app_link_desc'] = 'Hwn yw URL yr ap Cyfarfodydd.';

// Capability.
$string['teamsmeeting:add'] = 'Ychwanegu Cyfarfod Teams';

// IFrame.
$string['iframe_meeting_options'] = 'Dewisiadau’r cyfarfod';
$string['iframe_meeting_created'] = 'Crëwyd y cyfarfod "{$a}" yn llwyddiannus!';
$string['iframe_meeting_details'] = 'Cyfarfod "{$a}"';
$string['iframe_go_to_meeting'] = 'Ewch i’r cyfarfod';
$string['iframe_add_link'] = 'Ychwanegu dolen';
$string['iframe_new_window_label'] = 'Agor y cyfarfod mewn ffenestr newydd';
$string['iframe_not_found'] = 'Ni chanfuwyd y cyfarfod';
$string['invalidtoken'] = 'Mae tocyn galwad-nôl y cyfarfod ar goll, yn annilys, neu wedi dod i ben. Caewch y ffenestr hon a cheisiwch greu’r cyfarfod eto.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Creu Cyfarfod Teams';
$string['tiny_edit_modal_title'] = 'Cyfarfod Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'Mae ategyn Tiny Teams Meeting yn storio cofnodion cyfarfodydd a grëwyd gan ddefnyddwyr, gan gynnwys ID y defnyddiwr a’r cyd-destun lle crëwyd pob cyfarfod.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Manylion cyfarfodydd Teams a grëwyd drwy’r golygydd TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'ID y defnyddiwr a greodd y cyfarfod.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Y cyd-destun lle crëwyd y cyfarfod.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Teitl y cyfarfod.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'URL ymuno â’r cyfarfod.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'URL tudalen dewisiadau’r cyfarfod.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Yr amser y crëwyd cofnod y cyfarfod.';
$string['privacy:metadata:msteamsapp'] = 'Er mwyn creu cyfarfod, mae ategyn Tiny Teams Meeting yn cyfnewid data gyda chymhwysiad cyfarfodydd Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'Anfonir ID y cwrs lle mae’r cyfarfod yn cael ei greu at gymhwysiad cyfarfodydd Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'Anfonir URL y wefan Moodle hon at gymhwysiad cyfarfodydd Microsoft Teams er mwyn iddo allu dychwelyd dolen y cyfarfod i’r lle cywir.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Anfonir cod iaith y defnyddiwr at gymhwysiad cyfarfodydd Microsoft Teams er mwyn i’w ryngwyneb defnyddiwr gyfateb i iaith y defnyddiwr.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
