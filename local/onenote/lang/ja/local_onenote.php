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
 * Japanese language strings.
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = '提出: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'フィードバック: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['connction_error'] = 'OneNoteに接続できません。しばらくしてから再度お試しください。';
$string['onenote_page_error'] = 'この提出またはフィードバックのOneNoteページを開けませんでした。';
$string['error_noapiavailable'] = '利用可能なOneNote APIがありません。OneNoteへの接続は、Microsoft 365に接続しているユーザのみが使用できます。';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Moodleノートブック';
$string['erroronenoteapibadcall'] = 'API呼び出しでエラーが発生しました。';
$string['erroronenoteapibadcall_message'] = 'API呼び出しでエラーが発生しました: {$a}';
$string['errornosection'] = 'OneNoteノートブック内のセクションを取得または作成できませんでした。';
$string['errornopostdata'] = 'OneNoteに送信するページデータを作成できませんでした。';
$string['errorsubmissioninteachercontext'] = '教師の採点コンテキストから提出を作成しようとしました。';
$string['errorinvalidreference'] = 'リクエストされた提出または成績は、この課題およびユーザに属していません。';
$string['errorfeedbackinstudentcontext'] = '学生の提出コンテキストでフィードバックを作成しようとしました。';

$string['privacy:metadata:local_onenote'] = 'Microsoft OneNoteローカルプラグイン';
$string['privacy:metadata:local_onenote_user_sections'] = 'Moodleコースに対応するOneNoteセクション';
$string['privacy:metadata:local_onenote_user_sections:user_id'] = 'MoodleユーザのID';
$string['privacy:metadata:local_onenote_user_sections:course_id'] = 'MoodleコースのID';
$string['privacy:metadata:local_onenote_user_sections:section_id'] = 'OneNoteセクションのID';
$string['privacy:metadata:local_onenote_assign_pages'] = '課題の提出とフィードバック用のOneNoteページ';
$string['privacy:metadata:local_onenote_assign_pages:user_id'] = 'MoodleユーザのID';
$string['privacy:metadata:local_onenote_assign_pages:assign_id'] = '課題のID';
$string['privacy:metadata:local_onenote_assign_pages:submission_student_page_id'] = '学生の提出のページID';
$string['privacy:metadata:local_onenote_assign_pages:feedback_student_page_id'] = '学生のフィードバックのページID';
$string['privacy:metadata:local_onenote_assign_pages:submission_teacher_page_id'] = '教師用にコピーされた学生の提出のページID';
$string['privacy:metadata:local_onenote_assign_pages:feedback_teacher_page_id'] = '教師のフィードバックのページID';
$string['privacy:metadata:local_onenote_assign_pages:teacher_lastviewed'] = '教師が提出を最後に閲覧した日時';
$string['privacy:metadata:local_onenote_assign_pages:student_lastmodified'] = '学生が提出を最後に変更した日時';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
