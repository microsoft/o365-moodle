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
 * Strings for component 'tiny_teamsmeeting', language 'pt'.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2026 Enovation Solutions
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Teams Meeting';

// Settings.
$string['settings_meetings_app_link'] = 'URL da aplicação de reuniões';
$string['settings_meetings_app_link_desc'] = 'Este é o URL da aplicação de reuniões.';

// Capability.
$string['teamsmeeting:add'] = 'Adicionar reunião do Teams';

// IFrame.
$string['iframe_meeting_options'] = 'Opções da reunião';
$string['iframe_meeting_created'] = 'A reunião "{$a}" foi criada com sucesso!';
$string['iframe_meeting_details'] = 'Reunião "{$a}"';
$string['iframe_go_to_meeting'] = 'Ir para a reunião';
$string['iframe_add_link'] = 'Adicionar ligação';
$string['iframe_new_window_label'] = 'Abrir a reunião numa nova janela';
$string['iframe_not_found'] = 'Reunião não encontrada';
$string['invalidtoken'] = 'O token de retorno da reunião está em falta, é inválido ou expirou. Feche esta janela e tente criar a reunião novamente.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Criar reunião do Teams';
$string['tiny_edit_modal_title'] = 'Reunião do Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'O plugin Tiny Teams Meeting armazena os registos de reuniões criadas pelos utilizadores, incluindo o ID do utilizador e o contexto em que cada reunião foi criada.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Detalhes das reuniões do Teams criadas através do editor TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'O ID do utilizador que criou a reunião.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'O contexto em que a reunião foi criada.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'O título da reunião.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'O URL de participação na reunião.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'O URL da página de opções da reunião.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'A data e hora em que o registo da reunião foi criado.';
$string['privacy:metadata:msteamsapp'] = 'Para criar uma reunião, o plugin Tiny Teams Meeting troca dados com a aplicação de reuniões do Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'O ID do curso em que a reunião está a ser criada é enviado para a aplicação de reuniões do Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'O URL deste site Moodle é enviado para a aplicação de reuniões do Microsoft Teams para que esta possa devolver a ligação da reunião ao local correto.';
$string['privacy:metadata:msteamsapp:userlang'] = 'O código de idioma do utilizador é enviado para a aplicação de reuniões do Microsoft Teams para que a sua interface corresponda ao idioma do utilizador.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
