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
 *
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft';
$string['contactadmin'] = 'Póngase en contacto con el administrador para obtener más información.';
$string['error_nomoodlenotebook'] = 'No se ha encontrado su cuaderno de Moodle.';
$string['error_urlrequiredwhenenabled'] = 'Esta URL debe estar configurada, ya que la opción "Mostrar" anterior está habilitada.';
$string['linkonedrive'] = 'Mi OneDrive';
$string['linkonenote'] = 'Mi cuaderno de OneNote';
$string['linksways'] = 'Mis Sways';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsstreamclassic'] = 'Microsoft Stream (clásico)';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'Mi correo electrónico';
$string['linkonenote_unavailable'] = 'OneNote no disponible';
$string['linksharepoint'] = 'Sitio de SharePoint del curso';
$string['linkoutlook'] = 'Configuración de sincronización del calendario de Outlook';
$string['linkprefs'] = 'Editar configuración';
$string['linkconnection'] = 'Configuración de la conexión con Microsoft 365';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = 'Agregar un nuevo bloque Microsoft';
$string['microsoft:myaddinstance'] = 'Agregar un nuevo bloque Microsoft al Área personal';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Cuaderno de Moodle';
$string['workonthis'] = 'Trabajar en esto';
$string['o365matched_title'] = '<span style="color: #960">Casi</span> está conectado a Microsoft 365';
$string['o365matched_desc'] = 'Se le ha asociado con el usuario de Microsoft 365 <b>"{$a}"</b>';
$string['o365matched_complete_authreq'] = 'Para completar la conexión, haga clic en el enlace siguiente e inicie sesión con esta cuenta de Microsoft 365.';
$string['o365connected'] = '{$a->firstname}, actualmente está <span class="notifysuccess">conectado</span> a Microsoft 365';
$string['notconnected'] = '<span class="notifyproblem">No está conectado</span> a ningún servicio de Microsoft.';
$string['course_connected_to_team'] = 'El curso está <span class="notifysuccess">conectado</span> a un <b>equipo</b>.';
$string['course_connected_to_team_pending'] = 'El curso está configurado para conectarse a un <b>equipo</b>, pero la creación del equipo está <span class="notifyproblem">pendiente</span>.';
$string['course_connected_to_group_pending'] = 'El curso está configurado para conectarse a un <b>equipo</b>, pero la creación del grupo está <span class="notifyproblem">pendiente</span>.';
$string['course_not_connected'] = 'El curso <span class="notifyproblem">no está conectado</span> a ningún servicio de Microsoft.';
$string['cachedef_onenotenotebook'] = 'Almacena el cuaderno de OneNote.';
$string['logintoo365'] = 'Iniciar sesión en Microsoft 365';
$string['connecttoo365'] = 'Conectar con Microsoft 365';
$string['install_office'] = 'Instalar Office';

// Microsoft 365 and Viva apps.
$string['linkword'] = 'Word';
$string['linkexcel'] = 'Excel';
$string['linkpowerpoint'] = 'PowerPoint';
$string['linkvivaengage'] = 'Viva Engage';
$string['linkvivaamplify'] = 'Viva Amplify';
$string['linkvivaconnections'] = 'Viva Connections';
$string['linkvivaglint'] = 'Viva Glint';
$string['linkvivagoals'] = 'Viva Goals';
$string['linkvivainsights'] = 'Viva Insights';
$string['linkvivalearning'] = 'Viva Learning';
$string['linkvivapulse'] = 'Viva Pulse';
$string['linklinkedin'] = 'LinkedIn';

// Configuration settings.
$string['settings_showemail'] = 'Mostrar "Mi correo electrónico"';
$string['settings_showemail_desc'] = 'Habilitar o deshabilitar el enlace "Mi correo electrónico" en el bloque.';
$string['settings_showmydelve'] = 'Mostrar "Mi Delve"';
$string['settings_showmydelve_desc'] = 'Habilitar o deshabilitar el enlace "Mi Delve" en el bloque.';
$string['settings_showmyforms'] = 'Mostrar "Mis formularios"';
$string['settings_showmyforms_desc'] = 'Habilitar o deshabilitar el enlace "Mis formularios" en el bloque.';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = 'Mostrar "Instalar Office"';
$string['settings_showo365download_desc'] = 'Habilitar o deshabilitar el enlace "Instalar Office" en el bloque.';
$string['settings_showsways'] = 'Mostrar "Mis Sways"';
$string['settings_showsways_desc'] = 'Habilitar o deshabilitar el enlace "Mis Sways" en el bloque.';
$string['settings_showmsstream'] = 'Mostrar "Microsoft Stream (en SharePoint)"';
$string['settings_showmsstream_desc'] = 'Habilitar o deshabilitar el enlace "Microsoft Stream (en SharePoint)" en el bloque.';
$string['settings_showmsstreamclassic'] = 'Mostrar "Microsoft Stream (clásico)"';
$string['settings_showmsstreamclassic_desc'] = 'Habilitar o deshabilitar el enlace "Microsoft Stream (clásico)" en el bloque.';
$string['settings_showmsteams'] = 'Mostrar "Microsoft Teams"';
$string['settings_showmsteams_desc'] = 'Habilitar o deshabilitar el enlace "Microsoft Teams" en el bloque.';
$string['settings_showonedrive'] = 'Mostrar "Mi OneDrive"';
$string['settings_showonedrive_desc'] = 'Habilitar o deshabilitar el enlace "Mi OneDrive" en el bloque.';
$string['settings_showonenotenotebook'] = 'Mostrar "Mi cuaderno de OneNote"';
$string['settings_showonenotenotebook_desc'] = 'Habilitar o deshabilitar el enlace "Mi cuaderno de OneNote" en el bloque.';
$string['settings_showoutlooksync'] = 'Mostrar "Configuración de sincronización del calendario de Outlook"';
$string['settings_showoutlooksync_desc'] = 'Habilitar o deshabilitar el enlace "Configuración de sincronización del calendario de Outlook" en el bloque.';
$string['settings_showpreferences'] = 'Mostrar "Editar configuración"';
$string['settings_showpreferences_desc'] = 'Habilitar o deshabilitar el enlace "Editar configuración" en el bloque.';
$string['settings_showo365connect'] = 'Mostrar "Conectar con Microsoft 365"';
$string['settings_showo365connect_desc'] = 'Habilitar o deshabilitar el enlace "Conectar con Microsoft 365" en el bloque. <br /><b>Nota:</b> Se muestra a los usuarios que no están conectados a Microsoft 365 y los lleva a la página que les permite configurar una conexión.';
$string['settings_showmanageo365conection'] = 'Mostrar "Configuración de la conexión con Microsoft 365"';
$string['settings_showmanageo365conection_desc'] = 'Habilitar o deshabilitar el enlace "Configuración de la conexión con Microsoft 365" en el bloque. <br /><b>Nota:</b> Se muestra a los usuarios conectados a Microsoft 365 y los lleva a la página de gestión de la conexión.';
$string['settings_showcoursespsite'] = 'Mostrar "Sitio de SharePoint del curso"';
$string['settings_showcoursespsite_desc'] = 'Habilitar o deshabilitar el enlace "Sitio de SharePoint del curso" en el bloque. <br /><b>Nota:</b> Se muestra en el bloque al ver un curso que tiene un sitio de SharePoint asociado.';
$string['settings_showcourselinks'] = 'Mostrar enlaces del curso';
$string['settings_showcourselinks_desc'] = 'Habilitar o deshabilitar toda la sección del curso del bloque que se muestra al ver un curso, incluido el encabezado de estado del curso y todos los enlaces del curso. <br /><b>Nota:</b> Cuando está deshabilitada, se ignoran los ajustes individuales de enlaces del curso que aparecen a continuación.';
$string['settings_showcourseconfiguresync'] = 'Mostrar "Configurar la sincronización del curso"';
$string['settings_showcourseconfiguresync_desc'] = 'Habilitar o deshabilitar el enlace "Configurar la sincronización del curso" en la sección del curso del bloque.';
$string['settings_showcourseteam'] = 'Mostrar "Equipo"';
$string['settings_showcourseteam_desc'] = 'Habilitar o deshabilitar el enlace "Equipo" en la sección del curso del bloque.';
$string['settings_showcourseconversations'] = 'Mostrar "Conversaciones de Outlook"';
$string['settings_showcourseconversations_desc'] = 'Habilitar o deshabilitar el enlace "Conversaciones de Outlook" en la sección del curso del bloque.';
$string['settings_showcourseonedrive'] = 'Mostrar "Archivos de OneDrive"';
$string['settings_showcourseonedrive_desc'] = 'Habilitar o deshabilitar el enlace "Archivos de OneDrive" en la sección del curso del bloque.';
$string['settings_showcoursecalendar'] = 'Mostrar "Calendario de Outlook"';
$string['settings_showcoursecalendar_desc'] = 'Habilitar o deshabilitar el enlace "Calendario de Outlook" en la sección del curso del bloque.';
$string['settings_showcoursenotebook'] = 'Mostrar "Bloc de notas de clase"';
$string['settings_showcoursenotebook_desc'] = 'Habilitar o deshabilitar el enlace "Bloc de notas de clase" en la sección del curso del bloque.';
$string['settings_showcoursereset'] = 'Mostrar "Opciones de reinicio del curso"';
$string['settings_showcoursereset_desc'] = 'Habilitar o deshabilitar el enlace "Opciones de reinicio del curso" en la sección del curso del bloque.';
$string['settings_geto365link'] = 'URL de descarga de "Instalar Office"';
$string['settings_geto365link_desc'] = 'La URL que se utilizará para el enlace "Instalar Office".';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['settings_showword'] = 'Mostrar "Word"';
$string['settings_showword_desc'] = 'Habilitar o deshabilitar el enlace "Word" en el bloque.';
$string['settings_showexcel'] = 'Mostrar "Excel"';
$string['settings_showexcel_desc'] = 'Habilitar o deshabilitar el enlace "Excel" en el bloque.';
$string['settings_showpowerpoint'] = 'Mostrar "PowerPoint"';
$string['settings_showpowerpoint_desc'] = 'Habilitar o deshabilitar el enlace "PowerPoint" en el bloque.';
$string['settings_showvivaengage'] = 'Mostrar "Viva Engage"';
$string['settings_showvivaengage_desc'] = 'Habilitar o deshabilitar el enlace "Viva Engage" en el bloque.';
$string['settings_showvivaamplify'] = 'Mostrar "Viva Amplify"';
$string['settings_showvivaamplify_desc'] = 'Habilitar o deshabilitar el enlace "Viva Amplify" en el bloque. <br /><b>Nota:</b> También debe configurarse la URL de Viva Amplify que aparece a continuación para que se muestre el enlace.';
$string['settings_vivaamplifyurl'] = 'URL de Viva Amplify';
$string['settings_vivaamplifyurl_desc'] = 'La URL de la experiencia de Viva Amplify de su organización, tal como la haya configurado el administrador de su inquilino de Microsoft 365, p. ej. https://amplify.microsoft.com/. Solo se aceptan URL de los dominios amplify.microsoft.com o amplify.cloud.microsoft.';
$string['settings_showvivaconnections'] = 'Mostrar "Viva Connections"';
$string['settings_showvivaconnections_desc'] = 'Habilitar o deshabilitar el enlace "Viva Connections" en el bloque. <br /><b>Nota:</b> También debe configurarse la URL de Viva Connections que aparece a continuación para que se muestre el enlace.';
$string['settings_vivaconnectionsurl'] = 'URL de Viva Connections';
$string['settings_vivaconnectionsurl_desc'] = 'La URL de la experiencia de Viva Connections de su organización, tal como la haya configurado el administrador de su inquilino de Microsoft 365. Normalmente es el sitio principal de SharePoint, p. ej. https://yourtenant.sharepoint.com/sites/yourhomesite. Solo se aceptan URL de un dominio *.sharepoint.com (o su equivalente en la nube soberana).';
$string['settings_showvivaglint'] = 'Mostrar "Viva Glint"';
$string['settings_showvivaglint_desc'] = 'Habilitar o deshabilitar el enlace "Viva Glint" en el bloque.';
$string['settings_showvivagoals'] = 'Mostrar "Viva Goals"';
$string['settings_showvivagoals_desc'] = 'Habilitar o deshabilitar el enlace "Viva Goals" en el bloque.';
$string['settings_showvivainsights'] = 'Mostrar "Viva Insights"';
$string['settings_showvivainsights_desc'] = 'Habilitar o deshabilitar el enlace "Viva Insights" en el bloque.';
$string['settings_showvivalearning'] = 'Mostrar "Viva Learning"';
$string['settings_showvivalearning_desc'] = 'Habilitar o deshabilitar el enlace "Viva Learning" en el bloque. <br /><b>Nota:</b> También debe configurarse la URL de Viva Learning que aparece a continuación para que se muestre el enlace.';
$string['settings_vivalearningurl'] = 'URL de Viva Learning';
$string['settings_vivalearningurl_desc'] = 'La URL de la experiencia de Viva Learning de su organización, tal como la haya configurado el administrador de su inquilino de Microsoft 365, p. ej. https://web.viva.microsoft.com/learning. Solo se aceptan URL de los dominios viva.microsoft.com o cloud.microsoft.';
$string['settings_showvivapulse'] = 'Mostrar "Viva Pulse"';
$string['settings_showvivapulse_desc'] = 'Habilitar o deshabilitar el enlace "Viva Pulse" en el bloque.';
$string['settings_showlinkedin'] = 'Mostrar "LinkedIn"';
$string['settings_showlinkedin_desc'] = 'Habilitar o deshabilitar el enlace "LinkedIn" en el bloque.';

$string['linkmydelve'] = 'Mi Delve';
$string['linkmyforms'] = 'Mis formularios';
$string['privacy:metadata'] = 'El bloque Microsoft solo muestra enlaces a diversas funciones y servicios.';

// Course sync features.
$string['course_feature_team'] = 'Equipo';
$string['course_feature_conversations'] = 'Conversaciones de Outlook';
$string['course_feature_onedrive'] = 'Archivos de OneDrive';
$string['course_feature_calendar'] = 'Calendario de Outlook';
$string['course_feature_notebook'] = 'Bloc de notas de clase';

// Course sync settings.
$string['configure_sync'] = 'Configurar la sincronización del curso';
$string['error_course_sync_not_configurable_per_course'] = 'La sincronización del curso no se puede configurar por curso.';
$string['sync_page_heading'] = 'Sincronizar el curso {$a} con Microsoft Teams';
$string['configure_course_sync'] = 'Configurar la sincronización del curso con Microsoft Teams';
$string['course_sync_option'] = 'Opción de sincronización';
$string['course_sync_option_disabled'] = 'Deshabilitada';
$string['course_sync_option_enabled'] = 'Habilitada';
$string['sync_setting_saved'] = 'Se ha guardado la opción de sincronización del curso';

// Course reset status.
$string['course_reset_disconnect_and_create_new'] = 'Cuando se reinicie el curso, el equipo conectado al curso se renombrará según la configuración y se archivará. Se creará un nuevo equipo y se conectará al curso.';
$string['course_reset_do_nothing'] = 'Cuando se reinicie el curso, se mantendrá la conexión entre el curso y el equipo. Todos los cambios de usuarios realizados en el curso se sincronizarán con el equipo.';
$string['course_reset_disconnect_only'] = 'Cuando se reinicie el curso, el equipo conectado al curso se renombrará según la configuración y se archivará. No se creará ningún equipo nuevo.';
$string['configure_reset'] = 'Elegir la acción de Microsoft Teams al reiniciar el curso';

// Course reset settings page.
$string['reset_page_heading'] = 'Acción de reinicio del curso para {$a}';
$string['configure_course_reset'] = 'Configurar el ajuste de reinicio del curso';
$string['course_reset_option'] = 'Acción para el equipo al reiniciar el curso';
$string['reset_option_do_nothing'] = 'No hacer nada.<br/>El equipo seguirá conectado al curso. Las bajas de matrícula de usuarios supondrán la eliminación de su propiedad o pertenencia al equipo.';
$string['reset_option_disconnect_and_create_new'] = 'Desconectar y crear un nuevo equipo.<br/>El equipo existente conectado al curso se renombrará según la configuración y se archivará. Se creará un nuevo equipo y se conectará al curso.';
$string['reset_option_disconnect_only'] = 'Solo desconectar.<br/>El equipo existente conectado al curso se renombrará según la configuración y se archivará. No se creará ningún equipo nuevo.';
$string['reset_setting_saved'] = 'Se ha guardado el ajuste de reinicio del curso.';
$string['error_site_course_sync_disabled'] = 'La sincronización de cursos no está habilitada';
$string['error_reset_setting_not_managed_per_course'] = 'La configuración de la acción de reinicio la gestionan de forma centralizada los administradores del sitio.';
$string['error_connected_team_missing'] = 'El curso está configurado para sincronizarse, pero no se encuentra el equipo.';
$string['error_course_sync_disabled'] = 'El curso no está configurado para sincronizarse.';

// Course request.
$string['linkcourserequest'] = 'Solicitar un curso desde Teams';
$string['settings_courserequest'] = 'Solicitar un curso desde Teams';
$string['settings_courserequest_desc'] = 'Solicitar un nuevo curso desde Microsoft Teams. Tras la aprobación, se creará el curso y se conectará a un equipo. Los miembros del equipo se matricularán en el curso.';

$string['customlinks'] = 'Enlaces personalizados';
$string['customlink_addanother'] = 'Agregar otro enlace';
$string['customlink_delete'] = 'Eliminar este enlace';
$string['customlink_error_url'] = 'Introduzca una URL válida que empiece por http:// o https://';
$string['customlink_icon'] = 'Icono';
$string['customlink_name'] = 'Nombre';
$string['customlink_nochanges'] = 'No se ha introducido ningún enlace personalizado, por lo que no hay nada que guardar.';
$string['customlink_showall'] = 'Mostrar también a los usuarios que no están conectados a Microsoft 365';
$string['customlink_target'] = 'Abrir el enlace en';
$string['customlink_url'] = 'URL';
$string['customlink_visibility'] = 'Visibilidad';
$string['settings_header_general'] = 'General';
$string['settings_pageheading'] = 'Configuración del bloque Microsoft';
$string['settings_customlinkheading'] = 'Enlace {$a}';
$string['settings_customlinktarget_blank'] = 'Nueva ventana o pestaña';
$string['settings_customlinktarget_self'] = 'Misma ventana';
$string['settings_customlinks_desc'] = 'Agregue sus propios enlaces (p. ej., un chatbot interno o un sitio de intranet) al bloque. El nombre, la URL y el icono de cada enlace son obligatorios. Para eliminar un enlace, marque "Eliminar este enlace" y guarde.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
