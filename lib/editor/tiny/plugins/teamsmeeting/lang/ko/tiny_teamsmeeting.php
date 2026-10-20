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
 * Strings for component 'tiny_teamsmeeting', language 'ko'.
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
$string['settings_meetings_app_link'] = '회의 앱 URL';
$string['settings_meetings_app_link_desc'] = '이것은 회의 앱의 URL입니다.';

// Capability.
$string['teamsmeeting:add'] = 'Teams 회의 추가';

// IFrame.
$string['iframe_meeting_options'] = '회의 옵션';
$string['iframe_meeting_created'] = '"{$a}" 회의가 성공적으로 생성되었습니다!';
$string['iframe_meeting_details'] = '회의 "{$a}"';
$string['iframe_go_to_meeting'] = '회의로 이동';
$string['iframe_add_link'] = '링크 추가';
$string['iframe_new_window_label'] = '새 창에서 회의 열기';
$string['iframe_not_found'] = '회의를 찾을 수 없습니다';
$string['invalidtoken'] = '회의 콜백 토큰이 없거나 잘못되었거나 만료되었습니다. 이 창을 닫고 회의를 다시 만들어 보세요.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Teams 회의 만들기';
$string['tiny_edit_modal_title'] = 'Teams 회의';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tiny Teams Meeting 플러그인은 사용자가 만든 회의 기록을 사용자 ID 및 각 회의가 만들어진 컨텍스트와 함께 저장합니다.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'TinyMCE 편집기를 통해 만들어진 Teams 회의의 세부 정보입니다.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = '회의를 만든 사용자의 ID입니다.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = '회의가 만들어진 컨텍스트입니다.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = '회의의 제목입니다.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = '회의 참가 URL입니다.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = '회의 옵션 페이지의 URL입니다.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = '회의 기록이 생성된 시간입니다.';
$string['privacy:metadata:msteamsapp'] = '회의를 만들기 위해 Tiny Teams Meeting 플러그인은 Microsoft Teams 회의 앱과 데이터를 교환합니다.';
$string['privacy:metadata:msteamsapp:courseid'] = '회의가 생성되는 강좌의 ID가 Microsoft Teams 회의 앱으로 전송됩니다.';
$string['privacy:metadata:msteamsapp:moodleurl'] = '이 Moodle 사이트의 URL이 Microsoft Teams 회의 앱으로 전송되어 회의 링크를 올바른 위치로 반환할 수 있습니다.';
$string['privacy:metadata:msteamsapp:userlang'] = '사용자의 언어 코드가 Microsoft Teams 회의 앱으로 전송되어 해당 사용자 인터페이스가 사용자의 언어와 일치하도록 합니다.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
