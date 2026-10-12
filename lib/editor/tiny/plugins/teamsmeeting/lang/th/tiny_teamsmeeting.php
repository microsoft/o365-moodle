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
 * Strings for component 'tiny_teamsmeeting', language 'th'.
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
$string['settings_meetings_app_link'] = 'URL ของแอปการประชุม';
$string['settings_meetings_app_link_desc'] = 'นี่คือ URL ของแอปการประชุม';

// Capability.
$string['teamsmeeting:add'] = 'เพิ่มการประชุม Teams';

// IFrame.
$string['iframe_meeting_options'] = 'ตัวเลือกการประชุม';
$string['iframe_meeting_created'] = 'สร้างการประชุม "{$a}" เรียบร้อยแล้ว!';
$string['iframe_meeting_details'] = 'การประชุม "{$a}"';
$string['iframe_go_to_meeting'] = 'ไปที่การประชุม';
$string['iframe_add_link'] = 'เพิ่มลิงก์';
$string['iframe_new_window_label'] = 'เปิดการประชุมในหน้าต่างใหม่';
$string['iframe_not_found'] = 'ไม่พบการประชุม';
$string['invalidtoken'] = 'โทเค็นการเรียกกลับของการประชุมหายไป ไม่ถูกต้อง หรือหมดอายุแล้ว โปรดปิดหน้าต่างนี้แล้วลองสร้างการประชุมใหม่อีกครั้ง';

// TinyMCE strings.
$string['tiny_modal_title'] = 'สร้างการประชุม Teams';
$string['tiny_edit_modal_title'] = 'การประชุม Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'ปลั๊กอิน Tiny Teams Meeting จะจัดเก็บบันทึกการประชุมที่ผู้ใช้สร้างขึ้น รวมถึงรหัสผู้ใช้และบริบทที่สร้างการประชุมแต่ละครั้ง';
$string['privacy:metadata:tiny_teamsmeeting'] = 'รายละเอียดของการประชุม Teams ที่สร้างขึ้นผ่านโปรแกรมแก้ไข TinyMCE';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'รหัสของผู้ใช้ที่สร้างการประชุม';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'บริบทที่สร้างการประชุม';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'ชื่อเรื่องของการประชุม';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'URL สำหรับเข้าร่วมการประชุม';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'URL ของหน้าตัวเลือกการประชุม';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'เวลาที่สร้างบันทึกการประชุม';
$string['privacy:metadata:msteamsapp'] = 'เพื่อสร้างการประชุม ปลั๊กอิน Tiny Teams Meeting จะแลกเปลี่ยนข้อมูลกับแอปการประชุมของ Microsoft Teams';
$string['privacy:metadata:msteamsapp:courseid'] = 'รหัสของรายวิชาที่สร้างการประชุมจะถูกส่งไปยังแอปการประชุมของ Microsoft Teams';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'URL ของไซต์ Moodle นี้จะถูกส่งไปยังแอปการประชุมของ Microsoft Teams เพื่อให้สามารถส่งลิงก์การประชุมกลับไปยังตำแหน่งที่ถูกต้อง';
$string['privacy:metadata:msteamsapp:userlang'] = 'รหัสภาษาของผู้ใช้จะถูกส่งไปยังแอปการประชุมของ Microsoft Teams เพื่อให้อินเทอร์เฟซผู้ใช้ตรงกับภาษาของผู้ใช้';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
