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
 * French language strings.
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = 'Remise : {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'Feedback : {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['connction_error'] = 'Connexion à OneNote impossible. Patientez quelques instants avant de réessayer.';
$string['onenote_page_error'] = 'Impossible d’ouvrir la page OneNote pour cette remise ou ce feedback.';
$string['error_noapiavailable'] = 'Aucune API OneNote n’est disponible. Les connexions à OneNote ne peuvent être utilisées que par les utilisateurs connectés à Microsoft 365.';
// The default title of the notebook created in the user's OneNote account. It is also used to find notebooks created before the
// notebook id was stored, so do not change an existing translation, or those users will get a second notebook.
$string['notebookname'] = 'Carnet de notes Moodle';
$string['settings_notebookname'] = 'Titre du carnet de notes';
$string['settings_notebookname_desc'] = 'Le titre du carnet de notes créé pour Moodle dans le compte OneNote de chaque utilisateur. Laissez vide pour utiliser le titre par défaut, dans la langue de l’utilisateur. La modification du titre n’a aucune incidence sur les carnets de notes existants, car ils sont retrouvés grâce à leur ID.<br />Le titre ne peut pas dépasser 128 caractères et ne peut contenir aucun des caractères suivants : <code>? * \\ / : &lt; &gt; | &amp; # &quot; \' % ~</code>';
$string['erroronenoteapibadcall'] = 'Erreur lors de l’appel à l’API.';
$string['erroronenoteapibadcall_message'] = 'Erreur lors de l’appel à l’API : {$a}';
$string['errornosection'] = 'Impossible d’obtenir ou de créer une section dans votre bloc-notes OneNote.';
$string['errornopostdata'] = 'Impossible de créer les données de page à envoyer à OneNote.';
$string['errorsubmissioninteachercontext'] = 'Tentative de création d’une remise depuis le contexte de notation de l’enseignant.';
$string['errorinvalidreference'] = 'La remise ou la note demandée n’appartient pas à ce devoir et à cet utilisateur.';
$string['errorfeedbackinstudentcontext'] = 'Tentative de création d’un feedback dans le contexte de remise de l’étudiant.';

$string['privacy:metadata:local_onenote'] = 'Plugin local Microsoft OneNote';
$string['privacy:metadata:local_onenote_user_sections'] = 'Sections OneNote pour les cours Moodle';
$string['privacy:metadata:local_onenote_user_sections:user_id'] = 'L’ID de l’utilisateur Moodle';
$string['privacy:metadata:local_onenote_user_sections:course_id'] = 'L’ID du cours Moodle';
$string['privacy:metadata:local_onenote_user_sections:section_id'] = 'L’ID de la section OneNote.';
$string['privacy:metadata:local_onenote_user_notebooks'] = 'Carnets de notes OneNote utilisés pour Moodle';
$string['privacy:metadata:local_onenote_user_notebooks:userid'] = 'L’ID de l’utilisateur Moodle';
$string['privacy:metadata:local_onenote_user_notebooks:notebookid'] = 'L’ID du carnet de notes OneNote.';
$string['privacy:metadata:local_onenote_user_notebooks:timecreated'] = 'Date de création de l’enregistrement.';
$string['privacy:metadata:local_onenote_user_notebooks:timemodified'] = 'Date de modification de l’enregistrement.';
$string['privacy:metadata:local_onenote_assign_pages'] = 'Pages OneNote pour la remise et le feedback des devoirs';
$string['privacy:metadata:local_onenote_assign_pages:user_id'] = 'L’ID de l’utilisateur Moodle';
$string['privacy:metadata:local_onenote_assign_pages:assign_id'] = 'L’ID du devoir';
$string['privacy:metadata:local_onenote_assign_pages:submission_student_page_id'] = 'L’ID de la page pour la remise de l’étudiant';
$string['privacy:metadata:local_onenote_assign_pages:feedback_student_page_id'] = 'L’ID de la page pour le feedback de l’étudiant';
$string['privacy:metadata:local_onenote_assign_pages:submission_teacher_page_id'] = 'L’ID de la page pour la copie de l’enseignant de la remise de l’étudiant';
$string['privacy:metadata:local_onenote_assign_pages:feedback_teacher_page_id'] = 'L’ID de la page pour le feedback de l’enseignant';
$string['privacy:metadata:local_onenote_assign_pages:teacher_lastviewed'] = 'L’heure de la dernière consultation de la remise par l’enseignant';
$string['privacy:metadata:local_onenote_assign_pages:student_lastmodified'] = 'L’heure de la dernière modification de la remise par l’étudiant';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
