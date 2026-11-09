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
 * Finnish language strings.
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = 'Palautus: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'Palaute: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['connction_error'] = 'OneNote-yhteyttä ei voitu muodostaa. Odota hetki ja yritä uudelleen.';
$string['onenote_page_error'] = 'Tämän palautuksen tai palautteen OneNote-sivua ei voitu avata.';
$string['error_noapiavailable'] = 'OneNote-ohjelmointirajapinta ei ole käytettävissä. OneNote-yhteyksiä voivat käyttää vain Microsoft 365:een yhdistetyt käyttäjät.';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Moodle-muistikirja';
$string['erroronenoteapibadcall'] = 'Virhe API-kutsussa.';
$string['erroronenoteapibadcall_message'] = 'Virhe API-kutsussa: {$a}';
$string['errornosection'] = 'OneNote-muistikirjastasi ei voitu hakea tai luoda osiota.';
$string['errornopostdata'] = 'OneNoteen lähetettäviä sivutietoja ei voitu luoda.';
$string['errorsubmissioninteachercontext'] = 'Yritettiin luoda palautus opettajan arviointikontekstista.';
$string['errorinvalidreference'] = 'Pyydetty palautus tai arvosana ei kuulu tähän tehtävään ja käyttäjälle.';
$string['errorfeedbackinstudentcontext'] = 'Yritettiin luoda palaute opiskelijan palautuskontekstissa.';

$string['privacy:metadata:local_onenote'] = 'Microsoft OneNote -paikallinen lisäosa';
$string['privacy:metadata:local_onenote_user_sections'] = 'OneNote-osiot Moodle-kursseille';
$string['privacy:metadata:local_onenote_user_sections:user_id'] = 'Moodle-käyttäjän tunnus';
$string['privacy:metadata:local_onenote_user_sections:course_id'] = 'Moodle-kurssin tunnus';
$string['privacy:metadata:local_onenote_user_sections:section_id'] = 'OneNote-osion tunnus.';
$string['privacy:metadata:local_onenote_assign_pages'] = 'OneNote-sivut tehtävän palautusta ja palautetta varten';
$string['privacy:metadata:local_onenote_assign_pages:user_id'] = 'Moodle-käyttäjän tunnus';
$string['privacy:metadata:local_onenote_assign_pages:assign_id'] = 'Tehtävän tunnus';
$string['privacy:metadata:local_onenote_assign_pages:submission_student_page_id'] = 'Opiskelijan palautuksen sivun tunnus';
$string['privacy:metadata:local_onenote_assign_pages:feedback_student_page_id'] = 'Opiskelijan palautteen sivun tunnus';
$string['privacy:metadata:local_onenote_assign_pages:submission_teacher_page_id'] = 'Sivun tunnus opettajan kopiolle opiskelijan palautuksesta';
$string['privacy:metadata:local_onenote_assign_pages:feedback_teacher_page_id'] = 'Opettajan palautteen sivun tunnus';
$string['privacy:metadata:local_onenote_assign_pages:teacher_lastviewed'] = 'Aika, jolloin opettaja viimeksi tarkasteli palautusta';
$string['privacy:metadata:local_onenote_assign_pages:student_lastmodified'] = 'Aika, jolloin opiskelija viimeksi muokkasi palautusta';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
