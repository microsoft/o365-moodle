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
 * Czech language strings.
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = 'Odeslané řešení: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'Zpětná vazba: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['connction_error'] = 'Nelze se připojit k OneNote. Chvilku počkejte a zkuste to znovu.';
$string['onenote_page_error'] = 'Nelze otevřít stránku OneNote pro toto řešení nebo zpětnou vazbu.';
$string['error_noapiavailable'] = 'Není k dispozici žádné rozhraní OneNote API. Připojení k OneNote mohou používat pouze uživatelé připojení k Microsoft 365.';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Poznámkový blok Moodle';
$string['erroronenoteapibadcall'] = 'Chyba při volání API.';
$string['erroronenoteapibadcall_message'] = 'Chyba při volání API: {$a}';
$string['errornosection'] = 'Nepodařilo se získat ani vytvořit oddíl ve vašem poznámkovém bloku OneNote.';
$string['errornopostdata'] = 'Nepodařilo se vytvořit data stránky k odeslání do OneNote.';
$string['errorsubmissioninteachercontext'] = 'Pokus o vytvoření řešení z kontextu hodnocení učitelem.';
$string['errorinvalidreference'] = 'Požadované řešení nebo známka nepatří k tomuto úkolu a uživateli.';
$string['errorfeedbackinstudentcontext'] = 'Pokus o vytvoření zpětné vazby v kontextu odevzdávání řešení studentem.';

$string['privacy:metadata:local_onenote'] = 'Lokální modul Microsoft OneNote';
$string['privacy:metadata:local_onenote_user_sections'] = 'Oddíly OneNote pro kurzy Moodle';
$string['privacy:metadata:local_onenote_user_sections:user_id'] = 'ID uživatele Moodle';
$string['privacy:metadata:local_onenote_user_sections:course_id'] = 'ID kurzu Moodle';
$string['privacy:metadata:local_onenote_user_sections:section_id'] = 'ID oddílu OneNote.';
$string['privacy:metadata:local_onenote_assign_pages'] = 'Stránky OneNote pro řešení a zpětnou vazbu k úkolům';
$string['privacy:metadata:local_onenote_assign_pages:user_id'] = 'ID uživatele Moodle';
$string['privacy:metadata:local_onenote_assign_pages:assign_id'] = 'ID úkolu';
$string['privacy:metadata:local_onenote_assign_pages:submission_student_page_id'] = 'ID stránky s řešením studenta';
$string['privacy:metadata:local_onenote_assign_pages:feedback_student_page_id'] = 'ID stránky se zpětnou vazbou pro studenta';
$string['privacy:metadata:local_onenote_assign_pages:submission_teacher_page_id'] = 'ID stránky s kopií řešení studenta pro učitele';
$string['privacy:metadata:local_onenote_assign_pages:feedback_teacher_page_id'] = 'ID stránky se zpětnou vazbou učitele';
$string['privacy:metadata:local_onenote_assign_pages:teacher_lastviewed'] = 'Čas, kdy učitel naposledy zobrazil řešení';
$string['privacy:metadata:local_onenote_assign_pages:student_lastmodified'] = 'Čas, kdy student naposledy upravil řešení';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
