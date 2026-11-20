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
 * German language strings.
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = 'Abgabe: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'Feedback: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['connction_error'] = 'Es kann keine Verbindung mit OneNote hergestellt werden. Warten Sie einen Moment, und versuchen Sie es erneut.';
$string['onenote_page_error'] = 'Die OneNote-Seite für diese Abgabe oder dieses Feedback konnte nicht geöffnet werden.';
$string['error_noapiavailable'] = 'Es ist keine OneNote-API verfügbar. Verbindungen zu OneNote können nur von Nutzer/innen verwendet werden, die mit Microsoft 365 verbunden sind.';
// The default title of the notebook created in the user's OneNote account. It is also used to find notebooks created before the
// notebook id was stored, so do not change an existing translation, or those users will get a second notebook.
$string['notebookname'] = 'Moodle-Notizbuch';
$string['settings_notebookname'] = 'Titel des Notizbuchs';
$string['settings_notebookname_desc'] = 'Der Titel des Notizbuchs, das für Moodle im OneNote-Konto jedes Nutzers bzw. jeder Nutzerin angelegt wird. Lassen Sie das Feld leer, um den Standardtitel in der Sprache des Nutzers bzw. der Nutzerin zu verwenden. Eine Änderung des Titels hat keine Auswirkungen auf bereits vorhandene Notizbücher, da diese anhand ihrer ID gefunden werden.<br />Der Titel darf höchstens 128 Zeichen lang sein und keines dieser Zeichen enthalten: <code>? * \\ / : &lt; &gt; | &amp; # &quot; \' % ~</code>';
$string['erroronenoteapibadcall'] = 'Fehler beim API-Aufruf.';
$string['erroronenoteapibadcall_message'] = 'Fehler beim API-Aufruf: {$a}';
$string['errornosection'] = 'Es konnte kein Abschnitt in Ihrem OneNote-Notizbuch abgerufen oder erstellt werden.';
$string['errornopostdata'] = 'Die an OneNote zu sendenden Seitendaten konnten nicht erstellt werden.';
$string['errorsubmissioninteachercontext'] = 'Es wurde versucht, im Bewertungskontext des Trainers/der Trainerin eine Abgabe zu erstellen.';
$string['errorinvalidreference'] = 'Die angeforderte Abgabe oder Bewertung gehört nicht zu dieser Aufgabe und diesem Nutzerkonto.';
$string['errorfeedbackinstudentcontext'] = 'Es wurde versucht, im Abgabekontext des Teilnehmers/der Teilnehmerin Feedback zu erstellen.';

$string['privacy:metadata:local_onenote'] = 'Lokales Plugin Microsoft OneNote';
$string['privacy:metadata:local_onenote_user_sections'] = 'OneNote-Abschnitte für Moodle-Kurse';
$string['privacy:metadata:local_onenote_user_sections:user_id'] = 'Die ID des Moodle-Nutzerkontos';
$string['privacy:metadata:local_onenote_user_sections:course_id'] = 'Die ID des Moodle-Kurses';
$string['privacy:metadata:local_onenote_user_sections:section_id'] = 'Die ID des OneNote-Abschnitts.';
$string['privacy:metadata:local_onenote_user_notebooks'] = 'OneNote-Notizbücher für Moodle';
$string['privacy:metadata:local_onenote_user_notebooks:userid'] = 'Die ID des Moodle-Nutzerkontos';
$string['privacy:metadata:local_onenote_user_notebooks:notebookid'] = 'Die ID des OneNote-Notizbuchs.';
$string['privacy:metadata:local_onenote_user_notebooks:timecreated'] = 'Der Zeitpunkt, zu dem der Datensatz erstellt wurde.';
$string['privacy:metadata:local_onenote_user_notebooks:timemodified'] = 'Der Zeitpunkt, zu dem der Datensatz geändert wurde.';
$string['privacy:metadata:local_onenote_assign_pages'] = 'OneNote-Seiten für Aufgabenabgaben und Feedback';
$string['privacy:metadata:local_onenote_assign_pages:user_id'] = 'Die ID des Moodle-Nutzerkontos';
$string['privacy:metadata:local_onenote_assign_pages:assign_id'] = 'Die ID der Aufgabe';
$string['privacy:metadata:local_onenote_assign_pages:submission_student_page_id'] = 'Die Seiten-ID für die Abgabe des Teilnehmers/der Teilnehmerin';
$string['privacy:metadata:local_onenote_assign_pages:feedback_student_page_id'] = 'Die Seiten-ID für das Feedback an den Teilnehmer/die Teilnehmerin';
$string['privacy:metadata:local_onenote_assign_pages:submission_teacher_page_id'] = 'Die Seiten-ID für die Kopie der Abgabe des Teilnehmers/der Teilnehmerin beim Trainer/bei der Trainerin';
$string['privacy:metadata:local_onenote_assign_pages:feedback_teacher_page_id'] = 'Die Seiten-ID für das Feedback des Trainers/der Trainerin';
$string['privacy:metadata:local_onenote_assign_pages:teacher_lastviewed'] = 'Der Zeitpunkt, zu dem der Trainer/die Trainerin die Abgabe zuletzt angesehen hat';
$string['privacy:metadata:local_onenote_assign_pages:student_lastmodified'] = 'Der Zeitpunkt, zu dem der Teilnehmer/die Teilnehmerin die Abgabe zuletzt geändert hat';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
