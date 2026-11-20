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
 * Portuguese (Brazil) language strings.
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = 'Envio: {$a->assign_name} ({$a->student_firstname} {$a->student_lastname})';
$string['feedbacktitle'] = 'Feedback: {$a->assign_name} ({$a->student_firstname} {$a->student_lastname})';
$string['connction_error'] = 'Não foi possível conectar-se ao OneNote. Aguarde alguns instantes e tente novamente.';
$string['onenote_page_error'] = 'Não foi possível abrir a página do OneNote para este envio ou feedback.';
$string['error_noapiavailable'] = 'Nenhuma API do OneNote está disponível. As conexões com o OneNote só podem ser usadas por usuários conectados ao Microsoft 365.';
// The default title of the notebook created in the user's OneNote account. It is also used to find notebooks created before the
// notebook id was stored, so do not change an existing translation, or those users will get a second notebook.
$string['notebookname'] = 'Bloco de anotações do Moodle';
$string['settings_notebookname'] = 'Título do bloco de anotações';
$string['settings_notebookname_desc'] = 'O título do bloco de anotações criado para o Moodle na conta do OneNote de cada usuário. Deixe em branco para usar o título padrão, no idioma do usuário. Alterar o título não afeta os blocos de anotações que já existem, pois eles são encontrados pelo ID.<br />O título não pode ter mais de 128 caracteres nem conter nenhum destes caracteres: <code>? * \\ / : &lt; &gt; | &amp; # &quot; \' % ~</code>';
$string['erroronenoteapibadcall'] = 'Erro na chamada da API.';
$string['erroronenoteapibadcall_message'] = 'Erro na chamada da API: {$a}';
$string['errornosection'] = 'Não foi possível obter ou criar uma seção no seu bloco de anotações do OneNote.';
$string['errornopostdata'] = 'Não foi possível criar os dados da página a serem enviados ao OneNote.';
$string['errorsubmissioninteachercontext'] = 'Tentativa de criar um envio a partir do contexto de avaliação do professor.';
$string['errorinvalidreference'] = 'O envio ou a nota solicitada não pertence a esta tarefa e a este usuário.';
$string['errorfeedbackinstudentcontext'] = 'Tentativa de criar um feedback no contexto de envio do estudante.';

$string['privacy:metadata:local_onenote'] = 'Plugin local Microsoft OneNote';
$string['privacy:metadata:local_onenote_user_sections'] = 'Seções do OneNote para cursos do Moodle';
$string['privacy:metadata:local_onenote_user_sections:user_id'] = 'O ID do usuário do Moodle';
$string['privacy:metadata:local_onenote_user_sections:course_id'] = 'O ID do curso do Moodle';
$string['privacy:metadata:local_onenote_user_sections:section_id'] = 'O ID da seção do OneNote.';
$string['privacy:metadata:local_onenote_user_notebooks'] = 'Blocos de anotações do OneNote usados para o Moodle';
$string['privacy:metadata:local_onenote_user_notebooks:userid'] = 'O ID do usuário do Moodle';
$string['privacy:metadata:local_onenote_user_notebooks:notebookid'] = 'O ID do bloco de anotações do OneNote.';
$string['privacy:metadata:local_onenote_user_notebooks:timecreated'] = 'O momento em que o registro foi criado.';
$string['privacy:metadata:local_onenote_user_notebooks:timemodified'] = 'O momento em que o registro foi modificado.';
$string['privacy:metadata:local_onenote_assign_pages'] = 'Páginas do OneNote para envio e feedback de tarefas';
$string['privacy:metadata:local_onenote_assign_pages:user_id'] = 'O ID do usuário do Moodle';
$string['privacy:metadata:local_onenote_assign_pages:assign_id'] = 'O ID da tarefa';
$string['privacy:metadata:local_onenote_assign_pages:submission_student_page_id'] = 'O ID da página do envio do estudante';
$string['privacy:metadata:local_onenote_assign_pages:feedback_student_page_id'] = 'O ID da página do feedback do estudante';
$string['privacy:metadata:local_onenote_assign_pages:submission_teacher_page_id'] = 'O ID da página da cópia do professor do envio do estudante';
$string['privacy:metadata:local_onenote_assign_pages:feedback_teacher_page_id'] = 'O ID da página do feedback do professor';
$string['privacy:metadata:local_onenote_assign_pages:teacher_lastviewed'] = 'A hora em que o professor visualizou o envio pela última vez';
$string['privacy:metadata:local_onenote_assign_pages:student_lastmodified'] = 'A hora em que o estudante modificou o envio pela última vez';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
