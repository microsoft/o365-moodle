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
 * Italian language strings.
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = 'Consegna: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'Feedback: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['connction_error'] = 'Impossibile connettersi a OneNote. Attendi alcuni istanti e riprova.';
$string['onenote_page_error'] = 'Non è possibile aprire la pagina OneNote per questa consegna o feedback.';
$string['error_noapiavailable'] = 'Nessuna API OneNote disponibile. Le connessioni a OneNote possono essere utilizzate solo dagli utenti connessi a Microsoft 365.';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Blocco appunti Moodle';
$string['erroronenoteapibadcall'] = 'Errore nella chiamata API.';
$string['erroronenoteapibadcall_message'] = 'Errore nella chiamata API: {$a}';
$string['errornosection'] = 'Impossibile ottenere o creare una sezione nel tuo blocco appunti OneNote.';
$string['errornopostdata'] = 'Impossibile creare i dati della pagina da inviare a OneNote.';
$string['errorsubmissioninteachercontext'] = 'Tentativo di creare una consegna dal contesto di valutazione del docente.';
$string['errorinvalidreference'] = 'La consegna o la valutazione richiesta non appartiene a questo compito e a questo utente.';
$string['errorfeedbackinstudentcontext'] = 'Tentativo di creare un feedback nel contesto di consegna dello studente.';

$string['privacy:metadata:local_onenote'] = 'Plugin locale Microsoft OneNote';
$string['privacy:metadata:local_onenote_user_sections'] = 'Sezioni OneNote per i corsi Moodle';
$string['privacy:metadata:local_onenote_user_sections:user_id'] = 'L\'ID dell\'utente Moodle';
$string['privacy:metadata:local_onenote_user_sections:course_id'] = 'L\'ID del corso Moodle';
$string['privacy:metadata:local_onenote_user_sections:section_id'] = 'L\'ID della sezione OneNote.';
$string['privacy:metadata:local_onenote_assign_pages'] = 'Pagine OneNote per le consegne e i feedback dei compiti';
$string['privacy:metadata:local_onenote_assign_pages:user_id'] = 'L\'ID dell\'utente Moodle';
$string['privacy:metadata:local_onenote_assign_pages:assign_id'] = 'L\'ID del compito';
$string['privacy:metadata:local_onenote_assign_pages:submission_student_page_id'] = 'L\'ID della pagina per la consegna dello studente';
$string['privacy:metadata:local_onenote_assign_pages:feedback_student_page_id'] = 'L\'ID della pagina per il feedback dello studente';
$string['privacy:metadata:local_onenote_assign_pages:submission_teacher_page_id'] = 'L\'ID della pagina per la copia del docente della consegna dello studente';
$string['privacy:metadata:local_onenote_assign_pages:feedback_teacher_page_id'] = 'L\'ID della pagina per il feedback del docente';
$string['privacy:metadata:local_onenote_assign_pages:teacher_lastviewed'] = 'La data e l\'ora in cui il docente ha visualizzato per l\'ultima volta la consegna';
$string['privacy:metadata:local_onenote_assign_pages:student_lastmodified'] = 'La data e l\'ora in cui lo studente ha modificato per l\'ultima volta la consegna';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
