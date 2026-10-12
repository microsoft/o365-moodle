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
 * Strings for component 'tiny_teamsmeeting', language 'zh_tw'.
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
$string['settings_meetings_app_link'] = '會議應用程式的 URL';
$string['settings_meetings_app_link_desc'] = '這是會議應用程式的 URL。';

// Capability.
$string['teamsmeeting:add'] = '新增 Teams 會議';

// IFrame.
$string['iframe_meeting_options'] = '會議選項';
$string['iframe_meeting_created'] = '會議「{$a}」已成功建立！';
$string['iframe_meeting_details'] = '會議「{$a}」';
$string['iframe_go_to_meeting'] = '前往會議';
$string['iframe_add_link'] = '新增連結';
$string['iframe_new_window_label'] = '在新視窗中開啟會議';
$string['iframe_not_found'] = '找不到會議';
$string['invalidtoken'] = '會議回撥權杖缺失、無效或已過期。請關閉此視窗並重新嘗試建立會議。';

// TinyMCE strings.
$string['tiny_modal_title'] = '建立 Teams 會議';
$string['tiny_edit_modal_title'] = 'Teams 會議';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tiny Teams Meeting 外掛程式會儲存使用者建立的會議記錄，包括使用者 ID 及建立每個會議時的內容。';
$string['privacy:metadata:tiny_teamsmeeting'] = '透過 TinyMCE 編輯器建立的 Teams 會議詳細資料。';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = '建立會議的使用者 ID。';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = '建立會議時的內容。';
$string['privacy:metadata:tiny_teamsmeeting:title'] = '會議的標題。';
$string['privacy:metadata:tiny_teamsmeeting:link'] = '加入會議的 URL。';
$string['privacy:metadata:tiny_teamsmeeting:options'] = '會議選項頁面的 URL。';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = '建立會議記錄的時間。';
$string['privacy:metadata:msteamsapp'] = '為了建立會議，Tiny Teams Meeting 外掛程式會與 Microsoft Teams 會議應用程式交換資料。';
$string['privacy:metadata:msteamsapp:courseid'] = '建立會議所在課程的 ID 會傳送至 Microsoft Teams 會議應用程式。';
$string['privacy:metadata:msteamsapp:moodleurl'] = '此 Moodle 網站的 URL 會傳送至 Microsoft Teams 會議應用程式，以便將會議連結傳回正確的位置。';
$string['privacy:metadata:msteamsapp:userlang'] = '使用者的語言代碼會傳送至 Microsoft Teams 會議應用程式，以便其使用者介面符合使用者的語言。';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
