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
 * Strings for component 'tiny_teamsmeeting', language 'he'.
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
$string['settings_meetings_app_link'] = 'כתובת ה-URL של אפליקציית הפגישות';
$string['settings_meetings_app_link_desc'] = 'זוהי כתובת ה-URL של אפליקציית הפגישות.';

// Capability.
$string['teamsmeeting:add'] = 'הוספת פגישת Teams';

// IFrame.
$string['iframe_meeting_options'] = 'אפשרויות פגישה';
$string['iframe_meeting_created'] = 'הפגישה "{$a}" נוצרה בהצלחה!';
$string['iframe_meeting_details'] = 'פגישה "{$a}"';
$string['iframe_go_to_meeting'] = 'עבור לפגישה';
$string['iframe_add_link'] = 'הוסף קישור';
$string['iframe_new_window_label'] = 'פתח את הפגישה בחלון חדש';
$string['iframe_not_found'] = 'הפגישה לא נמצאה';
$string['invalidtoken'] = 'אסימון הקריאה החוזרת של הפגישה חסר, אינו תקין או שפג תוקפו. סגרו את החלון הזה וניסו ליצור את הפגישה מחדש.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'יצירת פגישת Teams';
$string['tiny_edit_modal_title'] = 'פגישת Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'התוסף Tiny Teams Meeting שומר רשומות של פגישות שנוצרו על ידי משתמשים, כולל מזהה המשתמש וההקשר שבו נוצרה כל פגישה.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'פרטים על פגישות Teams שנוצרו באמצעות עורך TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'המזהה של המשתמש שיצר את הפגישה.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'ההקשר שבו נוצרה הפגישה.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'כותרת הפגישה.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'כתובת ה-URL להצטרפות לפגישה.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'כתובת ה-URL של דף אפשרויות הפגישה.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'הזמן שבו נוצרה רשומת הפגישה.';
$string['privacy:metadata:msteamsapp'] = 'כדי ליצור פגישה, התוסף Tiny Teams Meeting מחליף נתונים עם אפליקציית הפגישות של Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'מזהה הקורס שבו נוצרת הפגישה נשלח לאפליקציית הפגישות של Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'כתובת ה-URL של אתר Moodle זה נשלחת לאפליקציית הפגישות של Microsoft Teams כדי שתוכל להחזיר את קישור הפגישה למקום הנכון.';
$string['privacy:metadata:msteamsapp:userlang'] = 'קוד השפה של המשתמש נשלח לאפליקציית הפגישות של Microsoft Teams כדי שממשק המשתמש שלה יתאים לשפת המשתמש.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
