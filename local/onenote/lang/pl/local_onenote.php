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
 * Polish language strings.
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = 'Przesłana praca: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'Informacja zwrotna: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['connction_error'] = 'Nie można nawiązać połączenia z programem OneNote. Zaczekaj chwilę i ponów próbę.';
$string['onenote_page_error'] = 'Nie można otworzyć strony programu OneNote dla tej przesłanej pracy lub informacji zwrotnej.';
$string['error_noapiavailable'] = 'Interfejs OneNote API nie jest dostępny. Połączenia z programem OneNote mogą być używane tylko przez użytkowników połączonych z Microsoft 365.';
// The default title of the notebook created in the user's OneNote account. It is also used to find notebooks created before the
// notebook id was stored, so do not change an existing translation, or those users will get a second notebook.
$string['notebookname'] = 'Notatnik na platformie Moodle';
$string['settings_notebookname'] = 'Tytuł notatnika';
$string['settings_notebookname_desc'] = 'Tytuł notatnika tworzonego dla Moodle na koncie OneNote każdego użytkownika. Pozostaw puste, aby użyć tytułu domyślnego, w języku użytkownika. Zmiana tytułu nie wpływa na już istniejące notatniki, ponieważ są one wyszukiwane według identyfikatora.<br />Tytuł nie może być dłuższy niż 128 znaków i nie może zawierać żadnego z tych znaków: <code>? * \\ / : &lt; &gt; | &amp; # &quot; \' % ~</code>';
$string['erroronenoteapibadcall'] = 'Błąd w wywołaniu API.';
$string['erroronenoteapibadcall_message'] = 'Błąd w wywołaniu API: {$a}';
$string['errornosection'] = 'Nie można pobrać ani utworzyć sekcji w Twoim notatniku OneNote.';
$string['errornopostdata'] = 'Nie można utworzyć danych strony do wysłania do programu OneNote.';
$string['errorsubmissioninteachercontext'] = 'Podjęto próbę utworzenia przesłanej pracy z kontekstu oceniania przez nauczyciela.';
$string['errorinvalidreference'] = 'Żądana przesłana praca lub ocena nie należy do tego zadania i użytkownika.';
$string['errorfeedbackinstudentcontext'] = 'Podjęto próbę utworzenia informacji zwrotnej w kontekście pracy przesłanej przez studenta.';

$string['privacy:metadata:local_onenote'] = 'Wtyczka lokalna Microsoft OneNote';
$string['privacy:metadata:local_onenote_user_sections'] = 'Sekcje OneNote dla kursów Moodle';
$string['privacy:metadata:local_onenote_user_sections:user_id'] = 'Identyfikator użytkownika Moodle';
$string['privacy:metadata:local_onenote_user_sections:course_id'] = 'Identyfikator kursu Moodle';
$string['privacy:metadata:local_onenote_user_sections:section_id'] = 'Identyfikator sekcji OneNote.';
$string['privacy:metadata:local_onenote_user_notebooks'] = 'Notatniki OneNote używane przez Moodle';
$string['privacy:metadata:local_onenote_user_notebooks:userid'] = 'Identyfikator użytkownika Moodle';
$string['privacy:metadata:local_onenote_user_notebooks:notebookid'] = 'Identyfikator notatnika OneNote.';
$string['privacy:metadata:local_onenote_user_notebooks:timecreated'] = 'Czas utworzenia rekordu.';
$string['privacy:metadata:local_onenote_user_notebooks:timemodified'] = 'Czas modyfikacji rekordu.';
$string['privacy:metadata:local_onenote_assign_pages'] = 'Strony OneNote dla prac przesłanych w zadaniach i informacji zwrotnej';
$string['privacy:metadata:local_onenote_assign_pages:user_id'] = 'Identyfikator użytkownika Moodle';
$string['privacy:metadata:local_onenote_assign_pages:assign_id'] = 'Identyfikator zadania';
$string['privacy:metadata:local_onenote_assign_pages:submission_student_page_id'] = 'Identyfikator strony przesłanej pracy studenta';
$string['privacy:metadata:local_onenote_assign_pages:feedback_student_page_id'] = 'Identyfikator strony informacji zwrotnej dla studenta';
$string['privacy:metadata:local_onenote_assign_pages:submission_teacher_page_id'] = 'Identyfikator strony z kopią przesłanej pracy studenta dla nauczyciela';
$string['privacy:metadata:local_onenote_assign_pages:feedback_teacher_page_id'] = 'Identyfikator strony informacji zwrotnej nauczyciela';
$string['privacy:metadata:local_onenote_assign_pages:teacher_lastviewed'] = 'Czas ostatniego wyświetlenia przesłanej pracy przez nauczyciela';
$string['privacy:metadata:local_onenote_assign_pages:student_lastmodified'] = 'Czas ostatniej modyfikacji przesłanej pracy przez studenta';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
