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
 * Dutch language strings.
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = 'Inzending: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'Feedback: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['connction_error'] = 'Kan geen verbinding maken met OneNote. Wacht even en probeer het daarna opnieuw.';
$string['onenote_page_error'] = 'Kan de OneNote-pagina voor deze inzending of feedback niet openen.';
$string['error_noapiavailable'] = 'Er is geen OneNote API beschikbaar. Verbindingen met OneNote kunnen alleen worden gebruikt door gebruikers die met Microsoft 365 zijn verbonden.';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Moodle Notebook';
$string['erroronenoteapibadcall'] = 'Fout in API-aanroep.';
$string['erroronenoteapibadcall_message'] = 'Fout in API-aanroep: {$a}';
$string['errornosection'] = 'Kan geen sectie in je OneNote-notitieboek ophalen of aanmaken.';
$string['errornopostdata'] = 'Kan geen paginagegevens aanmaken om naar OneNote te verzenden.';
$string['errorsubmissioninteachercontext'] = 'Poging om een inzending aan te maken vanuit de beoordelingscontext van de leraar.';
$string['errorinvalidreference'] = 'De opgevraagde inzending of beoordeling hoort niet bij deze opdracht en gebruiker.';
$string['errorfeedbackinstudentcontext'] = 'Poging om feedback aan te maken in de inzendingscontext van de leerling.';

$string['privacy:metadata:local_onenote'] = 'Microsoft OneNote lokale plugin';
$string['privacy:metadata:local_onenote_user_sections'] = 'OneNote-secties voor Moodle-cursussen';
$string['privacy:metadata:local_onenote_user_sections:user_id'] = 'De ID van de Moodle-gebruiker';
$string['privacy:metadata:local_onenote_user_sections:course_id'] = 'De ID van de Moodle-cursus';
$string['privacy:metadata:local_onenote_user_sections:section_id'] = 'De ID van de OneNote-sectie.';
$string['privacy:metadata:local_onenote_assign_pages'] = 'OneNote-pagina\'s voor opdrachtinzendingen en feedback';
$string['privacy:metadata:local_onenote_assign_pages:user_id'] = 'De ID van de Moodle-gebruiker';
$string['privacy:metadata:local_onenote_assign_pages:assign_id'] = 'De ID van de opdracht';
$string['privacy:metadata:local_onenote_assign_pages:submission_student_page_id'] = 'De pagina-ID voor de inzending van de leerling';
$string['privacy:metadata:local_onenote_assign_pages:feedback_student_page_id'] = 'De pagina-ID voor de feedback aan de leerling';
$string['privacy:metadata:local_onenote_assign_pages:submission_teacher_page_id'] = 'De pagina-ID voor de kopie van de leerlinginzending van de leraar';
$string['privacy:metadata:local_onenote_assign_pages:feedback_teacher_page_id'] = 'De pagina-ID voor de feedback van de leraar';
$string['privacy:metadata:local_onenote_assign_pages:teacher_lastviewed'] = 'Het tijdstip waarop de leraar de inzending het laatst heeft bekeken';
$string['privacy:metadata:local_onenote_assign_pages:student_lastmodified'] = 'Het tijdstip waarop de leerling de inzending het laatst heeft gewijzigd';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
