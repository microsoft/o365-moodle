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
 * Strings for component 'tiny_teamsmeeting', language 'zh_cn'.
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
$string['settings_meetings_app_link'] = '会议应用的 URL';
$string['settings_meetings_app_link_desc'] = '这是会议应用的 URL。';

// Capability.
$string['teamsmeeting:add'] = '添加 Teams 会议';

// IFrame.
$string['iframe_meeting_options'] = '会议选项';
$string['iframe_meeting_created'] = '会议“{$a}”已成功创建！';
$string['iframe_meeting_details'] = '会议“{$a}”';
$string['iframe_go_to_meeting'] = '转到会议';
$string['iframe_add_link'] = '添加链接';
$string['iframe_new_window_label'] = '在新窗口中打开会议';
$string['iframe_not_found'] = '未找到会议';
$string['invalidtoken'] = '会议回调令牌缺失、无效或已过期。请关闭此窗口并重试创建会议。';

// TinyMCE strings.
$string['tiny_modal_title'] = '创建 Teams 会议';
$string['tiny_edit_modal_title'] = 'Teams 会议';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tiny Teams Meeting 插件存储用户创建的会议记录，包括用户 ID 以及创建每个会议时的上下文。';
$string['privacy:metadata:tiny_teamsmeeting'] = '通过 TinyMCE 编辑器创建的 Teams 会议的详细信息。';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = '创建会议的用户的 ID。';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = '创建会议时的上下文。';
$string['privacy:metadata:tiny_teamsmeeting:title'] = '会议的标题。';
$string['privacy:metadata:tiny_teamsmeeting:link'] = '加入会议的 URL。';
$string['privacy:metadata:tiny_teamsmeeting:options'] = '会议选项页面的 URL。';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = '创建会议记录的时间。';
$string['privacy:metadata:msteamsapp'] = '为了创建会议，Tiny Teams Meeting 插件会与 Microsoft Teams 会议应用交换数据。';
$string['privacy:metadata:msteamsapp:courseid'] = '创建会议所在课程的 ID 会发送到 Microsoft Teams 会议应用。';
$string['privacy:metadata:msteamsapp:moodleurl'] = '此 Moodle 站点的 URL 会发送到 Microsoft Teams 会议应用，以便它可以将会议链接返回到正确的位置。';
$string['privacy:metadata:msteamsapp:userlang'] = '用户的语言代码会发送到 Microsoft Teams 会议应用，以便其用户界面与用户的语言相匹配。';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
