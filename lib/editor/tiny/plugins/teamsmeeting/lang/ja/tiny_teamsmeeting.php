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
 * Strings for component 'tiny_teamsmeeting', language 'ja'.
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
$string['settings_meetings_app_link'] = '会議アプリの URL';
$string['settings_meetings_app_link_desc'] = 'これは会議アプリの URL です。';

// Capability.
$string['teamsmeeting:add'] = 'Teams 会議を追加';

// IFrame.
$string['iframe_meeting_options'] = '会議のオプション';
$string['iframe_meeting_created'] = '会議「{$a}」が正常に作成されました。';
$string['iframe_meeting_details'] = '会議「{$a}」';
$string['iframe_go_to_meeting'] = '会議に移動';
$string['iframe_add_link'] = 'リンクを追加';
$string['iframe_new_window_label'] = '会議を新しいウィンドウで開く';
$string['iframe_not_found'] = '会議が見つかりません';
$string['invalidtoken'] = '会議のコールバック トークンが見つからないか、無効か、期限が切れています。このウィンドウを閉じて、もう一度会議の作成を試してください。';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Teams 会議を作成';
$string['tiny_edit_modal_title'] = 'Teams 会議';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tiny Teams Meeting プラグインは、ユーザーが作成した会議の記録を、ユーザー ID や各会議が作成されたコンテキストとともに保存します。';
$string['privacy:metadata:tiny_teamsmeeting'] = 'TinyMCE エディターを使用して作成された Teams 会議の詳細。';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = '会議を作成したユーザーの ID。';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = '会議が作成されたコンテキスト。';
$string['privacy:metadata:tiny_teamsmeeting:title'] = '会議のタイトル。';
$string['privacy:metadata:tiny_teamsmeeting:link'] = '会議に参加するための URL。';
$string['privacy:metadata:tiny_teamsmeeting:options'] = '会議のオプション ページの URL。';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = '会議の記録が作成された時刻。';
$string['privacy:metadata:msteamsapp'] = '会議を作成するために、Tiny Teams Meeting プラグインは Microsoft Teams 会議アプリとデータを交換します。';
$string['privacy:metadata:msteamsapp:courseid'] = '会議が作成されるコースの ID が Microsoft Teams 会議アプリに送信されます。';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'この Moodle サイトの URL が Microsoft Teams 会議アプリに送信され、会議へのリンクを正しい場所に返せるようになります。';
$string['privacy:metadata:msteamsapp:userlang'] = 'ユーザーの言語コードが Microsoft Teams 会議アプリに送信され、そのユーザー インターフェイスがユーザーの言語と一致するようになります。';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
