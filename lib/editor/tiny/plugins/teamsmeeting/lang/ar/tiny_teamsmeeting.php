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
 * Strings for component 'tiny_teamsmeeting', language 'ar'.
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
$string['settings_meetings_app_link'] = 'عنوان URL لتطبيق الاجتماعات';
$string['settings_meetings_app_link_desc'] = 'هذا هو عنوان URL لتطبيق الاجتماعات.';

// Capability.
$string['teamsmeeting:add'] = 'إضافة اجتماع Teams';

// IFrame.
$string['iframe_meeting_options'] = 'خيارات الاجتماع';
$string['iframe_meeting_created'] = 'تم إنشاء الاجتماع "{$a}" بنجاح!';
$string['iframe_meeting_details'] = 'الاجتماع "{$a}"';
$string['iframe_go_to_meeting'] = 'الانتقال إلى الاجتماع';
$string['iframe_add_link'] = 'إضافة رابط';
$string['iframe_new_window_label'] = 'فتح الاجتماع في نافذة جديدة';
$string['iframe_not_found'] = 'الاجتماع غير موجود';
$string['invalidtoken'] = 'رمز استدعاء الاجتماع مفقود أو غير صالح أو منتهي الصلاحية. أغلق هذه النافذة وحاول إنشاء الاجتماع مرة أخرى.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'إنشاء اجتماع Teams';
$string['tiny_edit_modal_title'] = 'اجتماع Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'يخزّن مكوّن Tiny Teams Meeting سجلات الاجتماعات التي ينشئها المستخدمون، بما في ذلك معرف المستخدم والسياق الذي تم فيه إنشاء كل اجتماع.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'تفاصيل اجتماعات Teams التي تم إنشاؤها عبر محرر TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'معرف المستخدم الذي أنشأ الاجتماع.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'السياق الذي تم فيه إنشاء الاجتماع.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'عنوان الاجتماع.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'عنوان URL للانضمام إلى الاجتماع.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'عنوان URL لصفحة خيارات الاجتماع.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'الوقت الذي تم فيه إنشاء سجل الاجتماع.';
$string['privacy:metadata:msteamsapp'] = 'من أجل إنشاء اجتماع، يتبادل مكوّن Tiny Teams Meeting البيانات مع تطبيق اجتماعات Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'يتم إرسال معرف الدورة التي يتم إنشاء الاجتماع فيها إلى تطبيق اجتماعات Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'يتم إرسال عنوان URL لموقع Moodle هذا إلى تطبيق اجتماعات Microsoft Teams حتى يتمكن من إعادة رابط الاجتماع إلى الموقع الصحيح.';
$string['privacy:metadata:msteamsapp:userlang'] = 'يتم إرسال رمز لغة المستخدم إلى تطبيق اجتماعات Microsoft Teams حتى تتطابق واجهة المستخدم الخاصة به مع لغة المستخدم.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
