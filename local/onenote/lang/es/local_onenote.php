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
 * Spanish language strings.
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = 'Entrega: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'Retroalimentación: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['connction_error'] = 'No se puede conectar a OneNote. Espere unos minutos e intente más tarde.';
$string['onenote_page_error'] = 'No se pudo abrir la página de OneNote para esta entrega o retroalimentación.';
$string['error_noapiavailable'] = 'No hay ninguna API de OneNote disponible. Solo los usuarios conectados a Microsoft 365 pueden usar las conexiones con OneNote.';
// The default title of the notebook created in the user's OneNote account. It is also used to find notebooks created before the
// notebook id was stored, so do not change an existing translation, or those users will get a second notebook.
$string['notebookname'] = 'Cuaderno de Moodle';
$string['settings_notebookname'] = 'Título del cuaderno';
$string['settings_notebookname_desc'] = 'El título del cuaderno que se crea para Moodle en la cuenta de OneNote de cada usuario. Déjelo vacío para usar el título predeterminado, en el idioma del usuario. Cambiar el título no afecta a los cuadernos que ya existen, ya que se encuentran por su ID.<br />El título no puede tener más de 128 caracteres ni contener ninguno de estos caracteres: <code>? * \\ / : &lt; &gt; | &amp; # &quot; \' % ~</code>';
$string['erroronenoteapibadcall'] = 'Error en la llamada a la API.';
$string['erroronenoteapibadcall_message'] = 'Error en la llamada a la API: {$a}';
$string['errornosection'] = 'No se ha podido obtener ni crear una sección en su cuaderno de OneNote.';
$string['errornopostdata'] = 'No se han podido crear los datos de la página para enviarlos a OneNote.';
$string['errorsubmissioninteachercontext'] = 'Se ha intentado crear una entrega desde el contexto de calificación del profesor.';
$string['errorinvalidreference'] = 'La entrega o calificación solicitada no pertenece a esta tarea y usuario.';
$string['errorfeedbackinstudentcontext'] = 'Se ha intentado crear retroalimentación en el contexto de entrega del estudiante.';

$string['privacy:metadata:local_onenote'] = 'Complemento local Microsoft OneNote';
$string['privacy:metadata:local_onenote_user_sections'] = 'Secciones de OneNote para los cursos de Moodle';
$string['privacy:metadata:local_onenote_user_sections:user_id'] = 'El ID del usuario de Moodle';
$string['privacy:metadata:local_onenote_user_sections:course_id'] = 'El ID del curso de Moodle';
$string['privacy:metadata:local_onenote_user_sections:section_id'] = 'El ID de la sección de OneNote.';
$string['privacy:metadata:local_onenote_user_notebooks'] = 'Cuadernos de OneNote usados para Moodle';
$string['privacy:metadata:local_onenote_user_notebooks:userid'] = 'El ID del usuario de Moodle';
$string['privacy:metadata:local_onenote_user_notebooks:notebookid'] = 'El ID del cuaderno de OneNote.';
$string['privacy:metadata:local_onenote_user_notebooks:timecreated'] = 'La hora en que se creó el registro.';
$string['privacy:metadata:local_onenote_user_notebooks:timemodified'] = 'La hora en que se modificó el registro.';
$string['privacy:metadata:local_onenote_assign_pages'] = 'Páginas de OneNote para las entregas y la retroalimentación de las tareas';
$string['privacy:metadata:local_onenote_assign_pages:user_id'] = 'El ID del usuario de Moodle';
$string['privacy:metadata:local_onenote_assign_pages:assign_id'] = 'El ID de la tarea';
$string['privacy:metadata:local_onenote_assign_pages:submission_student_page_id'] = 'El ID de la página de la entrega del estudiante';
$string['privacy:metadata:local_onenote_assign_pages:feedback_student_page_id'] = 'El ID de la página de la retroalimentación del estudiante';
$string['privacy:metadata:local_onenote_assign_pages:submission_teacher_page_id'] = 'El ID de la página de la copia del profesor de la entrega del estudiante';
$string['privacy:metadata:local_onenote_assign_pages:feedback_teacher_page_id'] = 'El ID de la página de la retroalimentación del profesor';
$string['privacy:metadata:local_onenote_assign_pages:teacher_lastviewed'] = 'La última vez que el profesor vio la entrega';
$string['privacy:metadata:local_onenote_assign_pages:student_lastmodified'] = 'La última vez que el estudiante modificó la entrega';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
