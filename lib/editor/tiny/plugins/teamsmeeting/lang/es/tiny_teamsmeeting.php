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
 * Strings for component 'tiny_teamsmeeting', language 'es'.
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
$string['settings_meetings_app_link'] = 'URL de la aplicación de reuniones';
$string['settings_meetings_app_link_desc'] = 'Esta es la URL de la aplicación de reuniones.';

// Capability.
$string['teamsmeeting:add'] = 'Añadir reunión de Teams';

// IFrame.
$string['iframe_meeting_options'] = 'Opciones de la reunión';
$string['iframe_meeting_created'] = '¡La reunión "{$a}" se ha creado correctamente!';
$string['iframe_meeting_details'] = 'Reunión "{$a}"';
$string['iframe_go_to_meeting'] = 'Ir a la reunión';
$string['iframe_add_link'] = 'Añadir enlace';
$string['iframe_new_window_label'] = 'Abrir la reunión en una ventana nueva';
$string['iframe_not_found'] = 'Reunión no encontrada';
$string['invalidtoken'] = 'El token de retorno de la reunión falta, no es válido o ha caducado. Cierre esta ventana e intente crear la reunión de nuevo.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Crear reunión de Teams';
$string['tiny_edit_modal_title'] = 'Reunión de Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'El complemento Tiny Teams Meeting almacena los registros de las reuniones creadas por los usuarios, incluido el identificador del usuario y el contexto en el que se creó cada reunión.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Detalles de las reuniones de Teams creadas mediante el editor TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'El identificador del usuario que creó la reunión.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'El contexto en el que se creó la reunión.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'El título de la reunión.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'La URL de acceso a la reunión.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'La URL de la página de opciones de la reunión.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'La fecha y hora en que se creó el registro de la reunión.';
$string['privacy:metadata:msteamsapp'] = 'Para crear una reunión, el complemento Tiny Teams Meeting intercambia datos con la aplicación de reuniones de Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'El identificador del curso en el que se crea la reunión se envía a la aplicación de reuniones de Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'La URL de este sitio Moodle se envía a la aplicación de reuniones de Microsoft Teams para que pueda devolver el enlace de la reunión al lugar correcto.';
$string['privacy:metadata:msteamsapp:userlang'] = 'El código de idioma del usuario se envía a la aplicación de reuniones de Microsoft Teams para que su interfaz coincida con el idioma del usuario.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
