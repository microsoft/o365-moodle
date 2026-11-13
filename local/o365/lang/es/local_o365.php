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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Integración de Microsoft 365';

// Settings - tabs.
$string['settings_pageheading'] = 'Configuración de {$a}';
$string['settings_header_setup'] = 'Configuración inicial';
$string['settings_header_usersync'] = 'Sincronización de usuarios';
$string['settings_header_coursesync'] = 'Sincronización de cursos';
$string['settings_header_advanced'] = 'Avanzado';
$string['settings_header_sds'] = 'Sincronización de SDS';
$string['settings_header_teams'] = 'Configuración de Teams';
$string['settings_header_moodle_app'] = 'Aplicación de Moodle para Teams';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'Paso 1/2: Registrar Moodle en Microsoft Entra ID';
$string['settings_setup_step1_desc'] = 'Registre una nueva aplicación de Microsoft Entra ID para la integración con Moodle mediante PowerShell:

<a href="{$a}/local/o365/scripts/Moodle-EntraID-PowerShell.zip" class="btn btn-primary" target="_blank">Descargar script de PowerShell</a>

<p style="margin-top:10px"><a href="{$a}/local/o365/scripts/README.md" target="_blank">Haga clic aquí</a> para leer las instrucciones de ejecución del script.</p>
<p>Cuando se le solicite, utilice el siguiente enlace como URL de Moodle:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />Una vez que el script se haya ejecutado correctamente, copie el ID de aplicación y el secreto devueltos por el script en la <a href="{$a}">página de configuración del complemento de autenticación OpenID Connect</a>.';
$string['settings_setup_step1_credentials_end'] = 'Si no puede configurar la aplicación de Microsoft Entra ID mediante PowerShell, <a href="{$a}" target="_blank">haga clic aquí</a> para ver las instrucciones de configuración manual.';
$string['settings_setup_step1_continue'] = '<b>Una vez que haya introducido el ID de aplicación y el secreto, haga clic en "Guardar cambios" en la parte inferior de la página para continuar.</b><br /><br /><br /><br /><br />';
$string['settings_setup_step1_existing_settings'] = '<h5>Configuración existente</h5>';
$string['settings_setup_step2'] = 'Paso 2/2: Consentimiento del administrador e información adicional';
$string['settings_setup_step2_desc'] = 'Este último paso le permite otorgar el consentimiento del administrador para usar algunos permisos de Microsoft Entra ID y recopila información adicional sobre su entorno de Microsoft 365.<br /><br />';
$string['settings_setup_step3'] = 'Verificar configuración';
$string['settings_setup_step3_desc'] = 'La configuración se ha completado. Haga clic en el botón "Actualizar" a continuación para verificar la configuración.';

// Settings in "Step 2/2" section of the "Setup" tab.
$string['settings_adminconsent'] = 'Consentimiento del administrador';
$string['settings_adminconsent_btn'] = 'Otorgar consentimiento del administrador';
$string['settings_adminconsent_details'] = 'Para permitir el acceso a algunos de los permisos necesarios, un administrador deberá otorgar el consentimiento del administrador. Haga clic en este botón y, a continuación, inicie sesión con una cuenta de administrador de Microsoft Entra ID para otorgar el consentimiento. Deberá hacerlo cada vez que cambie los permisos de tipo "Administrador" en Entra ID.';
$string['settings_entratenant'] = 'Inquilino de Microsoft Entra';
$string['settings_entratenant_details'] = 'Se utiliza para identificar a su organización dentro de Microsoft. Por ejemplo: "contoso.onmicrosoft.com".<br/>
Para encontrar este valor manualmente:
<ul>
<li>Vaya a <a href="https://portal.azure.com" target="_blank">Azure Portal</a>.</li>
<li>Inicie sesión con su cuenta de administrador.</li>
<li>En la barra de búsqueda, escriba "Microsoft Entra ID" y vaya a la página "Microsoft Entra ID".</li>
<li>Utilice el valor del campo <b>Dominio principal</b> de la sección "Información básica".</li>
</ul>';
$string['settings_odburl'] = 'URL de OneDrive for Business';
$string['settings_odburl_details'] = 'La URL utilizada para acceder a OneDrive for Business. Generalmente, puede determinarse a partir de su inquilino de Microsoft Entra. Por ejemplo, si su inquilino de Microsoft Entra es "contoso.onmicrosoft.com", lo más probable es que sea "contoso-my.sharepoint.com". Introduzca solo el nombre de dominio, sin incluir http:// ni https://';
$string['settings_odburl_error_graph'] = 'No se pudo determinar la URL de OneDrive for Business; introdúzcala manualmente. Generalmente, puede determinarse a partir de la URL que utiliza para acceder a OneDrive.';
$string['settings_serviceresourceabstract_detect'] = 'Detectar';
$string['settings_serviceresourceabstract_detecting'] = 'Detectando...';
$string['settings_serviceresourceabstract_error'] = 'Se produjo un error al detectar el ajuste. Establézcalo manualmente.';
$string['settings_serviceresourceabstract_valid'] = '{$a} se puede usar.';
$string['settings_serviceresourceabstract_invalid'] = 'Al parecer, este valor no se puede usar.';
$string['settings_serviceresourceabstract_nocreds'] = 'Configure las credenciales de la aplicación primero.';
$string['settings_serviceresourceabstract_empty'] = 'Introduzca un valor o haga clic en "Detectar" para intentar detectar el valor correcto.';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_verifysetup'] = 'Verificar configuración';
$string['settings_verifysetup_appdataheader'] = 'Registro de la aplicación de Microsoft Entra ID';
$string['settings_verifysetup_appdatadesc'] = 'Verifica que los parámetros correctos estén configurados en la aplicación de Entra ID.';
$string['settings_verifysetup_appdatareplyurlcorrect'] = 'URL de respuesta correcta';
$string['settings_verifysetup_appdatareplyurlincorrect'] = 'URL de respuesta incorrecta';
$string['settings_verifysetup_appdatareplyurlgeneralerror'] = 'No se pudo comprobar la URL de respuesta.';
$string['settings_verifysetup_appdatasignonurlcorrect'] = 'URL de inicio de sesión correcta.';
$string['settings_verifysetup_appdatasignonurlincorrect'] = 'URL de inicio de sesión incorrecta';
$string['settings_verifysetup_appdatasignonurlgeneralerror'] = 'No se pudo comprobar la URL de inicio de sesión.';
$string['settings_verifysetup_apppermscorrect'] = 'Los permisos de aplicación son correctos.';
$string['settings_verifysetup_details'] = 'Esta herramienta consulta Microsoft Entra ID para asegurarse de que todo esté configurado correctamente. <br /><b>Nota:</b> Los cambios en la aplicación de Microsoft Entra ID pueden tardar un momento en aparecer aquí. Si ha realizado un cambio en la aplicación de Microsoft Entra ID y no lo ve reflejado aquí, espere un momento y vuelva a intentarlo.';
$string['settings_verifysetup_correctval'] = 'Valor correcto:';
$string['settings_verifysetup_detectedval'] = 'Valor detectado:';
$string['settings_verifysetup_update'] = 'Actualizar';
$string['settings_verifysetup_checking'] = 'Verificando...';
$string['settings_verifysetup_missingappperms'] = 'Permisos de aplicación faltantes:';
$string['settings_verifysetup_notgranted'] = 'agregado a la aplicación, pero no se ha otorgado el consentimiento del administrador';
$string['settings_verifysetup_missingperms'] = 'Permisos delegados faltantes:';
$string['settings_verifysetup_permscorrect'] = 'Los permisos delegados son correctos.';
$string['settings_verifysetup_errorcheck'] = 'Se produjo un error al intentar verificar la configuración.';
$string['settings_verifysetup_noinfo'] = 'Aún no tenemos información sobre la configuración de su aplicación de Microsoft Entra ID. Haga clic en el botón Actualizar para comprobarla.';
$string['settings_verifysetup_strunifiedpermerror'] = 'Se produjo un error al comprobar los permisos de la API de Microsoft Graph.';
$string['settings_verifysetup_strtenanterror'] = 'Utilice el botón Detectar para establecer su inquilino de Microsoft Entra antes de actualizar la configuración de la aplicación de Microsoft Entra ID.';
$string['settings_verifysetup_unifiedheader'] = 'API de Microsoft Graph';
$string['settings_verifysetup_unifieddesc'] = 'La API de Microsoft Graph permite la comunicación entre Moodle y Microsoft 365.';
$string['settings_verifysetup_unifiederror'] = 'Se produjo un error al comprobar la compatibilidad con la API de Microsoft Graph.';
$string['settings_verifysetup_unifiedactive'] = 'API de Microsoft Graph activa.';
$string['settings_verifysetup_unifiedmissing'] = 'No se encontró la API de Microsoft Graph en esta aplicación.';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc_credsvalid'] = 'Se establecieron las credenciales.';
$string['settings_detectoidc_credsvalid_link'] = 'Cambiar';
$string['settings_detectoidc_credsinvalid'] = 'No se establecieron las credenciales o están incompletas.';
$string['settings_detectoidc_credsinvalid_link'] = 'Establecer credenciales';
$string['settings_detectperms_nocreds'] = 'Debe establecer las credenciales primero. Consulte la configuración anterior.';
$string['settings_detectperms_errorfix'] = 'Se produjo un error al intentar corregir los permisos. Corríjalos manualmente en Microsoft Entra ID.';
$string['settings_detectperms_fixperms'] = 'Corregir permisos';
$string['settings_detectperms_update'] = 'Actualizar';
$string['settings_detectperms_valid'] = 'Se configuraron los permisos.';
$string['settings_detectperms_invalid'] = 'Compruebe los permisos en Microsoft Entra ID';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_usersync_general'] = 'Sincronización general de usuarios';
$string['settings_usersync_suspension'] = 'Suspensión de cuentas de Moodle';
$string['settings_usersync_matching'] = 'Coincidencia de usuarios';
$string['settings_usersync_photos'] = 'Sincronizar fotos de perfil de Microsoft 365 con Moodle';
$string['settings_usersync_timezone'] = 'Sincronizar zona horaria de Outlook con Moodle';
$string['settings_usersync'] = 'Sincronizar usuarios desde Microsoft Entra ID';
$string['settings_usersync_details'] = 'Cuando está habilitado, Moodle sincroniza los usuarios desde Microsoft Entra ID según las opciones anteriores.<br /><br /><b>Nota: </b>El trabajo de sincronización se ejecuta en el cron de Moodle y sincroniza 1000 usuarios por vez. De manera predeterminada, se ejecuta una vez por día a la 1:00 a. m. en la zona horaria local del servidor. Para sincronizar conjuntos grandes de usuarios más rápidamente, puede aumentar la frecuencia de la tarea <b>Sincronizar usuarios desde Microsoft Entra ID</b> utilizando la <a href="{$a}">página de gestión de Tareas programadas.</a><br /><br />';
$string['settings_usersync_create'] = 'Crear cuentas en Moodle para usuarios en Microsoft Entra ID';
$string['settings_usersync_update'] = 'Actualizar cuentas en Moodle para usuarios en Microsoft Entra ID';
$string['settings_usersync_suspend'] = 'Suspender cuentas previamente sincronizadas en Moodle cuando se eliminen de Microsoft Entra ID';
$string['settings_usersync_delete'] = 'Eliminar cuentas previamente sincronizadas en Moodle cuando se eliminen de Microsoft Entra ID';
$string['settings_usersync_reenable'] = 'Volver a habilitar cuentas suspendidas para usuarios en Microsoft Entra ID';
$string['settings_usersync_disabledsyncsuspend'] = 'Suspender cuentas en Moodle cuando se deshabiliten en Microsoft Entra ID';
$string['settings_usersync_disabledsyncreenable'] = 'Volver a habilitar cuentas en Moodle cuando se vuelvan a habilitar en Microsoft Entra ID';
$string['settings_usersync_suspendnolink'] = 'Suspender cuentas conectadas que no tienen un vínculo de Microsoft almacenado cuando se eliminen o deshabiliten en Microsoft Entra ID';
$string['settings_usersync_groupsyncsuspend'] = 'Suspender cuentas en Moodle cuando no estén en el grupo de sincronización de usuarios configurado';
$string['settings_usersync_match'] = 'Hacer coincidir a los usuarios preexistentes de Moodle con las cuentas del mismo nombre en Microsoft Entra ID';
$string['settings_usersync_matchswitchauth'] = 'Cambiar usuarios coincidentes a la autenticación de Microsoft 365 (OpenID Connect)';
$string['settings_usersync_appassign'] = 'Asignar usuarios a la aplicación durante la sincronización';
$string['settings_usersync_photosync'] = 'Sincronizar fotos de perfil de Microsoft 365 con Moodle en la tarea cron';
$string['settings_usersync_photosynconlogin'] = 'Sincronizar fotos de perfil de Microsoft 365 con Moodle al iniciar sesión';
$string['settings_usersync_nodelta'] = 'Realizar una sincronización completa en cada ejecución';
$string['settings_usersync_emailsync'] = 'Hacer coincidir los nombres de usuario de Microsoft Entra ID con las direcciones de correo electrónico de Moodle en lugar de con los nombres de usuario de Moodle durante la sincronización';
$string['settings_addsync_tzsync'] = 'Sincronizar zona horaria de Outlook con Moodle en la tarea cron';
$string['settings_addsync_tzsynconlogin'] = 'Sincronizar zona horaria de Outlook con Moodle al iniciar sesión';
$string['settings_usersync_guestsync'] = 'Sincronizar usuarios invitados';
$string['settings_suspend_delete_running_time'] = 'Hora de ejecución de la suspensión/eliminación de usuarios';
$string['settings_suspend_delete_running_time_desc'] = 'Si la opción está habilitada, la función de suspensión/eliminación de la sincronización de usuarios se ejecutará una vez al día, a la hora configurada en la zona horaria predeterminada de la instancia de Moodle.';
$string['settings_usersync_delete_delay'] = 'Retraso antes de eliminar usuarios suspendidos';
$string['settings_usersync_delete_delay_desc'] = 'El tiempo mínimo que un usuario debe permanecer suspendido en Moodle antes de que la sincronización de usuarios elimine la cuenta. Esto se aplica además del período de retención de eliminación temporal de Microsoft Entra ID, por lo que la eliminación nunca se produce antes de que este finalice. Establézcalo en 0 para eliminar en cuanto haya finalizado el período de retención de Microsoft Entra ID. Para los usuarios que ya estaban suspendidos antes de que se introdujera este ajuste, el tiempo se cuenta a partir de la primera ejecución de la sincronización de usuarios que los encuentre.';
$string['settings_support_user_identifier_change'] = 'Admitir el cambio del valor de la notificación de nombre de usuario vinculante de la cuenta de Microsoft';
$string['settings_support_user_identifier_change_desc'] = 'Si está habilitado, Moodle intentará reaccionar cuando cambie el valor de la notificación de nombre de usuario vinculante, que normalmente es el UPN, de una cuenta de Microsoft conectada a una cuenta de Moodle.<br/>
<table class="flexible table table-striped table-hover generaltable generalbox table-sm">
    <tr>
        <th>ID del caso</th>
        <th>¿El usuario con el nombre de usuario anterior ya ha iniciado sesión? (token creado)<br/>
        <span class="support_user_identifier_change_case_detail">Si hay un token guardado en la tabla auth_oidc_token</span>
        </th>
        <th>Primera acción tras el cambio de nombre del UPN<br/>
        <span class="support_user_identifier_change_case_detail">Inicio de sesión o ejecución de la tarea de sincronización de usuarios</span>
        </th>
        <th>Posible nombre de usuario duplicado<br/>
        <span class="support_user_identifier_change_case_detail">Si el cambio de nombre provocaría un conflicto de nombres de usuario en Moodle</span>
        </th>
        <th>Comportamiento esperado</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Sí</td>
        <td>Inicio de sesión</td>
        <td>No</td>
        <td>
            <ol>
                <li>Se cambia el nombre del usuario de Moodle.</li>
                <li>auth_oidc_token se actualiza con los nuevos valores de los campos "username" y "oidcusername".</li>
                <li>El campo "o365name" del registro de conexión de usuario de local_o365_objects se actualiza con el nuevo valor.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Sí</td>
        <td>Sincronización de usuarios</td>
        <td>No</td>
        <td>
            <ol>
                <li>Se cambia el nombre del usuario de Moodle.</li>
                <li>Se actualiza el registro de conexión de usuario de local_o365_objects.</li>
                <li>Se actualiza auth_oidc_token.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>No</td>
        <td>Inicio de sesión</td>
        <td>No</td>
        <td>
            <ol>
                <li>Se cambia el nombre del usuario de Moodle.</li>
                <li>Se actualiza el registro de conexión de usuario de local_o365_objects.</li>
                <li>Se actualiza auth_oidc_token.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>No</td>
        <td>Sincronización de usuarios</td>
        <td>No</td>
        <td>
            <ol>
                <li>Se cambia el nombre del usuario de Moodle.</li>
                <li>Se actualiza el registro de conexión de usuario de local_o365_objects.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>Sí</td>
        <td>Inicio de sesión</td>
        <td>Sí</td>
        <td>
            <ol>
                <li>Se lanza una excepción y no se cambia el nombre del usuario de Moodle.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>Sí</td>
        <td>Sincronización de usuarios</td>
        <td>Sí</td>
        <td>
            <ol>
                <li>Se muestra un mensaje de error indicando que el intento de cambio de nombre falló en la ejecución de la tarea de sincronización de usuarios.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>No</td>
        <td>Inicio de sesión</td>
        <td>Sí</td>
        <td>
            <ol>
                <li>Se lanza una excepción y no se cambia el nombre del usuario de Moodle.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>No</td>
        <td>Sincronización de usuarios</td>
        <td>Sí</td>
        <td>
            <ol>
                <li>Se muestra un mensaje de error indicando que el intento de cambio de nombre falló en la ejecución de la tarea de sincronización de usuarios.</li>
            </ol>
        </td>
    </tr>
</table>
Tenga en cuenta que existe un problema conocido: si
<ol>
<li>Moodle y Microsoft 365 están conectados mediante el método de conexión "Microsoft identity platform (v2.0)", y</li>
<li>Microsoft Entra está configurado para permitir el uso del "Correo electrónico como identificador de inicio de sesión alternativo", y</li>
<li>esta opción está habilitada, y</li>
<li>el nombre de usuario y la dirección de correo electrónico de la cuenta de Microsoft son diferentes, y</li>
<li>el usuario de Microsoft inicia sesión con la dirección de correo electrónico en lugar del nombre de usuario,</li>
</ol>
entonces el complemento auth_oidc tratará la dirección de correo electrónico como el nombre de usuario de la cuenta de Microsoft y actualizará el nombre de usuario de Moodle.';

// User field mapping.
$string['settings_fieldmap'] = 'Asignación de campos de usuario';
$string['settings_fieldmap_details'] = 'Disponible en el <a href="{$a}">complemento de autenticación OpenID Connect</a>.';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'Sincronización de cursos';
$string['settings_secthead_coursesync_desc'] = 'Los siguientes ajustes controlan la sincronización de cursos entre Moodle y Microsoft Teams.';
$string['settings_coursesync'] = 'Sincronización de cursos';
$string['settings_coursesync_details'] = 'Si está habilitado, se crearán y mantendrán equipos de Teams para los cursos del sitio de Moodle (predeterminado: deshabilitado). Se crearán los equipos necesarios en cada ejecución del cron y se agregarán todos los usuarios matriculados actualmente como propietarios o miembros del equipo, según la comprobación de capacidades. Después, la pertenencia al equipo se mantendrá a medida que los usuarios se matriculen o se den de baja de los cursos de Moodle.';
$string['acp_coursesynccustom_off'] = 'Deshabilitado<br />Deshabilitar la creación de equipos de Teams para todos los cursos.';
$string['acp_coursesynccustom_oncustom'] = 'Personalizar<br />Permite a los usuarios autorizados seleccionar para qué cursos crear equipos de Teams.<br> <span id="adminsetting_coursesync" style="font-weight: bold"><a href="{$a}">Personalizar la sincronización de cursos</a></span>';
$string['acp_coursesynccustom_onall'] = 'Todas las características habilitadas<br />Habilita la creación de equipos de Teams para todos los cursos.';
$string['settings_coursesync_sync_hidden_courses'] = 'Sincronizar cursos ocultos';
$string['settings_coursesync_sync_hidden_courses_desc'] = 'De manera predeterminada, el complemento ignora los cursos ocultos para evitar sincronizar cursos que se están copiando o restaurando. Habilite este ajuste para forzar la creación de equipos de Teams para los cursos ocultos.';
$string['acp_coursesync_hidden_course_note'] = 'Nota: Los cursos ocultos no se procesarán para la creación de grupos de Teams. Para permitirlo, debe habilitar el ajuste "Sincronizar cursos ocultos" en la configuración del complemento.';
$string['settings_coursesync_delete_group_on_course_deletion'] = 'Eliminar grupos de Microsoft 365 cuando se elimine el curso de Moodle conectado';
$string['settings_coursesync_delete_group_on_course_deletion_details'] = 'Si está habilitado, Moodle intentará eliminar el grupo de Microsoft 365 (y el equipo asociado) cuando el curso conectado se elimine de Moodle. Tenga en cuenta que esto no se aplica a los cursos creados mediante la sincronización de SDS.';
$string['settings_coursesync_delete_group_on_course_sync_disabled'] = 'Eliminar grupos de Microsoft 365 cuando se deshabilite la sincronización de cursos';
$string['settings_coursesync_delete_group_on_course_sync_disabled_details'] = 'Si está habilitado, Moodle intentará eliminar el grupo de Microsoft 365 conectado (y el equipo asociado) cuando se desactive la sincronización de cursos para un curso de Moodle.';
$string['settings_coursesync_courses_per_task'] = 'Cursos que se sincronizarán por ejecución de la tarea';
$string['settings_coursesync_courses_per_task_details'] = 'El número de cursos cuyo estado de sincronización de equipo/grupo se procesará en cada ejecución de la tarea.';
$string['settings_coursesync_team_type'] = 'Plantilla de equipo';
$string['settings_coursesync_team_type_desc'] = 'La plantilla de Microsoft Teams que se utilizará al crear equipos a partir de cursos de Moodle. Las plantillas de educación requieren una licencia de educación. <br><br><strong>Importante:</strong> La plantilla configurada determina cómo se crean los grupos y los equipos:<br>
&bull; La plantilla estándar crea grupos y equipos estándar (compatible con todos los inquilinos).<br>
&bull; Las plantillas de educación crean grupos/equipos de educación (solo inquilinos de educación; habilitan características específicas de educación).<br>
&bull; Las plantillas personalizadas utilizan grupos estándar (por compatibilidad con el diseño de plantillas personalizadas).<br><br>
<strong>⚠️ ADVERTENCIA: Una vez creado un equipo con una plantilla específica, no se puede cambiar la plantilla.</strong> Los equipos permanecen asociados a su plantilla original. Cambiar este ajuste solo afecta a los equipos creados a partir de entonces, no a los existentes. Planifique cuidadosamente la selección de la plantilla antes de habilitar la sincronización de cursos.';
$string['settings_coursesync_team_type_standard'] = 'Estándar';
$string['settings_coursesync_team_type_educationclass'] = 'Educación - Equipo de clase';
$string['settings_coursesync_team_type_educationstaff'] = 'Educación - Equipo de personal';
$string['settings_coursesync_team_type_educationplc'] = 'Educación - Comunidad de aprendizaje profesional (PLC)';
$string['settings_coursesync_team_type_custom'] = 'Plantilla personalizada';
$string['settings_coursesync_team_type_custom_id'] = 'ID de plantilla personalizada';
$string['settings_coursesync_team_type_custom_id_desc'] = 'El ID completo de una plantilla personalizada definida en el Centro de administración de Teams. Solo se utiliza cuando se selecciona "Plantilla personalizada" arriba. <br><br><strong>El ID de plantilla debe tener formato GUID</strong> (por ejemplo, e41de7bb-859a-4a0f-aa39-5725a0529c1c). Puede encontrar el ID de plantilla en el Centro de administración de Teams al ver los detalles de su plantilla personalizada. <br><br>
<strong>⚠️ SE REQUIERE UN PERMISO ADICIONAL DE MICROSOFT ENTRA ID:</strong> Validar y utilizar plantillas de equipo personalizadas requiere un permiso de aplicación adicional de la API de Microsoft Graph (<strong>TeamTemplates.Read.All</strong>) que puede no estar presente en el registro de aplicación de Microsoft Entra ID. Sin este permiso, el paso de validación fallará y no se podrá establecer el ID de plantilla personalizada. Si la validación falla con un error de permisos, póngase en contacto con su administrador de Microsoft Entra ID para agregar este permiso al registro de la aplicación. <br><br>
<strong>⚠️ LIMITACIÓN IMPORTANTE:</strong> Actualmente, el marco de Microsoft Teams solo admite la creación de equipos a partir de plantillas personalizadas cuando la plantilla incluye una <strong>definición de configuración regional en-US</strong>. No se podrán crear equipos con plantillas personalizadas que no admitan la configuración regional en-US. Asegúrese de que su plantilla personalizada tenga definida la configuración regional en-US en el Centro de administración de Teams. <br><br>
<strong>⚠️ ADVERTENCIA: Una vez creado un equipo con esta plantilla personalizada, no se puede cambiar la plantilla.</strong> Si necesita utilizar otra plantilla personalizada para los nuevos equipos, debe dejar este ajuste vacío o cambiarlo antes de la siguiente creación de equipos. Los equipos existentes seguirán utilizando su plantilla original. <br><br>
Los equipos no se crearán correctamente si se configura un ID de plantilla incorrecto. Utilice el botón "Validar ID de plantilla personalizada" para validar el ID de plantilla antes de ejecutar la sincronización de cursos.';
$string['error_custom_template_id_required'] = 'El ID de plantilla personalizada es obligatorio al utilizar la opción "Plantilla personalizada". Introduzca un ID de plantilla válido.';
$string['error_custom_template_id_not_found'] = 'No se encontró el ID de plantilla personalizada "{$a}". Verifique que el ID de plantilla exista en el Centro de administración de Teams.';
$string['error_custom_template_id_validation_failed'] = 'Falló la validación del ID de plantilla personalizada. Es posible que la plantilla no admita la creación directa de equipos o que haya un problema de configuración. Verifique el ID de plantilla en el Centro de administración de Teams.';
$string['settings_team_type_custom_id_test_button'] = 'Validar ID de plantilla personalizada';
$string['settings_team_type_custom_id_validating'] = '🔄 Validando...';
$string['settings_team_type_custom_id_error_empty'] = '⚠️ Introduzca primero un ID de plantilla.';
$string['settings_team_type_custom_id_error_not_found'] = '✗ No se encontró la plantilla. El ID de plantilla "{$a}" no existe. Verifíquelo en el Centro de administración de Teams.';
$string['settings_team_type_custom_id_error_validation'] = '✗ Error de validación. {$a}';
$string['settings_team_type_custom_id_error_default'] = 'No se pudo validar la plantilla. Inténtelo de nuevo o póngase en contacto con su administrador.';
$string['settings_team_type_custom_id_error_timeout'] = '✗ Se agotó el tiempo de espera de la validación. La solicitud tardó más de 10 segundos. Inténtelo de nuevo.';
$string['settings_team_type_custom_id_error_network'] = '✗ Error de red. No se puede acceder al servicio de validación. Compruebe su conexión a Internet e inténtelo de nuevo.';
$string['settings_team_type_custom_id_error_parsererror'] = '✗ Error en la respuesta del servidor. El servicio de validación devolvió datos no válidos. Compruebe su integración con Microsoft 365.';
$string['settings_team_type_custom_id_error_http'] = '✗ Error de validación (HTTP {$a}). Inténtelo de nuevo o póngase en contacto con su administrador.';
$string['settings_coursesync_group_channels'] = 'Crear un canal para cada grupo de Moodle';
$string['settings_coursesync_group_channels_details'] = 'Crea un canal privado en el equipo de Microsoft Teams conectado para cada grupo del curso de Moodle y mantiene los miembros de cada canal en consonancia con los miembros del grupo de Moodle. Los miembros del grupo que también están conectados a Microsoft 365 se agregan al canal o se quitan de él cuando se agregan al grupo o se quitan de él. Cualquier persona agregada a un canal en Microsoft Teams que no sea miembro del grupo de Moodle se vuelve a quitar. En un equipo de clase de educación que aún no se ha activado, los estudiantes no pueden incluirse en canales: solo se incluyen los propietarios, y los estudiantes se agregan automáticamente mediante la tarea programada "Crear canales de Teams para grupos de Moodle y sincronizar sus miembros" después de que un propietario active el equipo en Microsoft Teams. Los canales no se renombran ni se eliminan cuando se renombra o elimina un grupo de Moodle. La pertenencia a los canales solo se sincroniza de Moodle a Teams, y este ajuste no tiene efecto si "Comportamiento de sincronización de usuarios del curso" está establecido en "De Teams a Moodle". Microsoft Teams permite hasta 1000 canales en un equipo, contando los canales privados y los canales eliminados en los últimos 30 días.<br /><br /><b>Este ajuste necesita dos permisos de aplicación adicionales de Microsoft Graph:</b><ul><li><b>Channel.Create</b>: para crear los canales.</li><li><b>ChannelMember.ReadWrite.All</b>: para agregar miembros a los canales y quitarlos de ellos.</li></ul>Ambos deben agregarse a la aplicación de Microsoft Entra ID utilizada por Moodle y debe otorgarse el consentimiento del administrador. El script de PowerShell de la pestaña "Configuración inicial" ya los incluye cuando registra una nueva aplicación. Para una aplicación existente, agréguelos manualmente en Registros de aplicaciones &gt; su aplicación &gt; Permisos de API &gt; Agregar un permiso &gt; Microsoft Graph &gt; Permisos de aplicación y, a continuación, otorgue el consentimiento del administrador. Mientras este ajuste esté habilitado, "Verificar configuración" en la pestaña "Configuración inicial" indicará que faltan estos permisos hasta que se otorguen.';
$string['settings_coursesync_sync_direction'] = 'Comportamiento de sincronización de usuarios del curso';
$string['settings_coursesync_sync_direction_details'] = 'Seleccione la dirección en la que desea que se sincronicen los usuarios entre Moodle y Microsoft Teams.';
$string['settings_coursesync_sync_moodle_to_teams'] = 'De Moodle a Teams';
$string['settings_coursesync_sync_teams_to_moodle'] = 'De Teams a Moodle';
$string['settings_coursesync_sync_both'] = 'Actualizar tanto Teams como Moodle';
$string['settings_coursesync_enrolment_owner_role'] = 'Rol de propietario del equipo';
$string['settings_coursesync_enrolment_owner_role_desc'] = 'El rol que se asignará al propietario del equipo durante la sincronización.';
$string['settings_coursesync_enrolment_member_role'] = 'Rol de miembro del equipo';
$string['settings_coursesync_enrolment_member_role_desc'] = 'El rol que se asignará a los miembros del equipo durante la sincronización.';

// Settings in the "Course sync customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_coursesynccustom'] = 'Personalización de la sincronización de cursos';
$string['acp_coursesynccustom_enabled'] = 'Habilitado';
$string['acp_coursesynccustom_enable_all'] = 'Habilitar la sincronización de cursos en todos los cursos';
$string['acp_coursesynccustom_disable_all'] = 'Deshabilitar la sincronización de cursos en todos los cursos';
$string['acp_coursesynccustom_bulk'] = 'Operaciones masivas';
$string['acp_coursesynccustom_bulk_enable'] = 'Habilitar la sincronización de cursos en los cursos de esta página';
$string['acp_coursesynccustom_bulk_disable'] = 'Deshabilitar la sincronización de cursos en los cursos de esta página';
$string['acp_coursesynccustom_settings_header'] = 'Opciones de sincronización';
$string['acp_coursesynccustom_new_course'] = 'Habilitado de manera predeterminada para los cursos nuevos';
$string['acp_coursesynccustom_new_course_desc'] = 'Si está habilitado, todos los cursos de nueva creación tendrán la sincronización habilitada de manera predeterminada.';
$string['acp_coursesynccustom_controlled_per_course'] = 'Permitir configurar la sincronización de cursos en los cursos';
$string['acp_coursesynccustom_controlled_per_course_desc'] = 'Si está habilitado, los usuarios matriculados en cursos de Moodle que puedan actuar como propietarios del equipo (con la capacidad "Propietario del equipo" [local/o365:teamowner]) podrán controlar la sincronización del curso desde el bloque Microsoft del curso.';
$string['acp_coursesynccustom_savemessage'] = 'Se han guardado los cambios.';
$string['acp_coursesynccustom_regex_search'] = 'Búsqueda por expresión regular';
$string['acp_coursesynccustom_regex_search_title'] = 'Si está marcado, el contenido del cuadro de búsqueda anterior se compara como una expresión regular PCRE (sin delimitadores) con el nombre completo, el nombre corto y el número ID, en lugar de realizar una búsqueda de texto simple.';
$string['acp_coursesynccustom_confirm_all_action'] = '¿Está seguro de que desea cambiar el estado de sincronización de todos los cursos? La acción no se puede deshacer.';
$string['acp_coursesynccustom_sds_course'] = 'Bloqueado para curso de SDS';
$string['acp_coursesynccustom_all_enabled_notice'] = 'La sincronización de cursos está habilitada actualmente para todos los cursos. La personalización por curso está deshabilitada porque el modo "Todas las características habilitadas" está activo.';
$string['acp_coursesynccustom_disabled_notice'] = 'La sincronización de cursos está deshabilitada globalmente en este momento. La personalización por curso está deshabilitada porque el modo "Deshabilitado" está activo.';
$string['acp_coursesynccustom_categories_header'] = 'Sincronizar por categoría de cursos';
$string['acp_coursesynccustom_categories_desc'] = 'Seleccione una o más categorías de cursos para habilitar automáticamente la sincronización de cursos para todos los cursos de esas categorías, incluidas sus subcategorías. Esto también se aplica a los cursos que se agreguen más adelante a las categorías seleccionadas. Mantenga pulsada la tecla Ctrl (Cmd en Mac) para seleccionar varias categorías, o vuelva a hacer clic mientras la mantiene pulsada para anular la selección.';
$string['acp_coursesynccustom_category_course'] = 'Bloqueado: habilitado por categoría de cursos';

// Settings in the "Cohort sync" section of the "Sync settings" tab.
$string['settings_secthead_cohortsync'] = 'Sincronización de cohortes';
$string['settings_secthead_cohortsync_desc'] = 'Esta característica permite la sincronización entre grupos de Microsoft 365 y cohortes de Moodle.';
$string['settings_cohortsync'] = 'Sincronización de cohortes';
$string['settings_cohortsync_linktext'] = 'Gestionar la sincronización de cohortes';
$string['settings_cohortsync_details'] = 'Revise y gestione la sincronización entre cohortes de Moodle y grupos de Microsoft 365.';
$string['settings_cohortsync_title'] = 'Sincronización de cohortes';
$string['settings_cohortsync_excludeowners'] = 'Excluir a los propietarios de grupos de la sincronización de cohortes';
$string['settings_cohortsync_excludeowners_desc'] = 'Si está habilitado, los propietarios de grupos no se sincronizan con las cohortes de Moodle, aunque también sean miembros del grupo. Los propietarios que ya estén en una cohorte se quitarán en la siguiente ejecución de la sincronización.';

// Settings in the "Team / group names" section of the "Sync settings" tab.
$string['settings_secthead_team_group_name'] = 'Nombres de equipos / grupos';
$string['settings_secthead_team_group_name_desc'] = 'Si un curso está configurado para sincronizarse, el nombre del equipo y del grupo se construirá de la siguiente manera.<br/>
<ul>
<li>Se pueden definir el alias de correo del grupo y el nombre para mostrar del equipo.</li>
<li>Primero se creará el grupo de Microsoft 365 utilizando el mailNickname del grupo y el nombre para mostrar del equipo configurados, y a continuación se creará un equipo a partir del grupo.</li>
<li>Si se utiliza la directiva de nomenclatura de Microsoft Entra ID para grupos de Microsoft 365, los grupos no se crearán si el nombre para mostrar generado según la configuración no cumple las directivas.</li>
<li>Los cambios realizados aquí solo afectarán a la creación de equipos futuros, no a los existentes.</li>
<li>Se quitarán todos los espacios del alias de correo del grupo.</li>
<li>En el alias de correo del grupo solo se permiten letras mayúsculas y minúsculas, números, - y _.</li>
<li>El alias de correo del grupo, incluidos el prefijo y el sufijo, no puede superar los 64 caracteres.</li>
<li>El alias de correo del grupo debe ser único; de lo contrario, se le agregará un número aleatorio de 4 dígitos para garantizar que sea único.</li>
</ul>';
$string['settings_team_name_prefix'] = 'Prefijo del nombre del equipo';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'Parte del curso en el nombre del equipo';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'Sufijo del nombre del equipo';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_group_mail_alias_prefix'] = 'Prefijo del alias de correo del grupo';
$string['settings_group_mail_alias_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'Parte del curso en el alias de correo del grupo';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'Sufijo del alias de correo del grupo';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'Suponga que un curso tiene:
<ul>
<li>Nombre completo: <b>Sample course</b></li>
<li>Nombre corto: <b>sample 15</b></li>
<li>ID creado por Moodle: <b>2</b></li>
<li>Número ID: <b>Sample ID 15</b></li>
</ul>
Con la configuración actual se creará un grupo con el alias de correo "<b>{$a->mailalias}</b>" y un equipo con el nombre "<b>{$a->teamname}</b>".<br/>
Haga clic en el botón "Guardar cambios" a continuación para ver cómo cambiará esto con su configuración.';
$string['settings_main_name_option_full_name'] = 'Nombre completo';
$string['settings_main_name_option_short_name'] = 'Nombre corto';
$string['settings_main_name_option_id'] = 'ID creado por Moodle';
$string['settings_main_name_option_id_number'] = 'Número ID';
$string['settings_team_name_sync'] = 'Actualizar el nombre del equipo al actualizar el curso';
$string['settings_team_name_sync_desc'] = 'Si está habilitado, cuando se actualice el curso de Moodle, el nombre del equipo se actualizará según la configuración más reciente de nombres de equipos.';

// Settings in the "Course request" section of the "Sync settings" tab.
$string['settings_secthead_course_request'] = 'Solicitud de curso';
$string['settings_secthead_course_request_desc'] = 'Ajustes de asignación de roles para la característica de solicitud de cursos desde Teams.';
$string['settings_course_request_enrolment_owner_role'] = 'Rol de propietario del equipo';
$string['settings_course_request_enrolment_owner_role_desc'] = 'El rol que se asignará al propietario del equipo cuando se apruebe la solicitud de curso.';
$string['settings_course_request_enrolment_member_role'] = 'Rol de miembro del equipo';
$string['settings_course_request_enrolment_member_role_desc'] = 'El rol que se asignará a los miembros del equipo cuando se apruebe la solicitud de curso.';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'Herramientas';
$string['settings_secthead_calsync'] = 'Sincronización del calendario';
$string['settings_calsyncsubscribemode'] = 'Suscripción a la sincronización del calendario';
$string['settings_calsyncsubscribemode_details'] = 'Controla si los usuarios tienen que activar ellos mismos la sincronización con el calendario de Outlook.<ul><li><b>Participación voluntaria</b>: los usuarios habilitan la sincronización del calendario y marcan los calendarios que desean sincronizar en su página de configuración de sincronización del calendario.</li><li><b>Participación automática</b>: los usuarios conectados a Microsoft 365 obtienen automáticamente la sincronización del calendario habilitada y quedan suscritos a los calendarios elegidos a continuación (en el caso de los cursos, todos los cursos en los que estén matriculados, ahora y en el futuro), sincronizando de Moodle a su calendario principal de Outlook. Los usuarios pueden cambiarlo o desactivarlo en su página de configuración de sincronización del calendario, y los usuarios que desactiven la sincronización del calendario no se vuelven a suscribir.</li></ul>Volver a "Participación voluntaria" no elimina las suscripciones existentes.';
$string['settings_calsyncsubscribetypes'] = 'Calendarios a los que suscribir automáticamente a los usuarios';
$string['settings_calsyncsubscribetypes_details'] = 'Solo se aplica a "Participación automática". Elija a qué calendarios de Moodle se suscriben automáticamente los usuarios conectados. Suscribir a todos al calendario del sitio agrega a cada usuario como asistente de cada evento del sitio, por lo que no está seleccionado de manera predeterminada.';
$string['settings_calsyncsubscribetypes_site'] = 'Calendario del sitio';
$string['settings_calsyncsubscribetypes_user'] = 'Calendario personal';
$string['settings_calsyncsubscribetypes_course'] = 'Calendarios de cursos (todos los cursos en los que está matriculado el usuario)';
$string['settings_calsyncsubscribemode_optin'] = 'Participación voluntaria (los usuarios habilitan ellos mismos la sincronización del calendario)';
$string['settings_calsyncsubscribemode_optout'] = 'Participación automática (habilitar automáticamente la sincronización del calendario para todos los usuarios conectados)';
$string['settings_secthead_advanced'] = 'Configuración avanzada';
$string['settings_secthead_advanced_desc'] = 'Estos ajustes controlan otras características del conjunto de complementos. ¡Tenga cuidado! Pueden provocar efectos no deseados.';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'Inquilinos';
$string['settings_tools_tenants_linktext'] = 'Configurar inquilinos adicionales';
$string['settings_tools_tenants_details'] = 'Gestione el acceso a inquilinos adicionales de Microsoft Entra.';
$string['settings_healthcheck'] = 'Comprobación de estado';
$string['settings_healthcheck_details'] = 'Si algo no está funcionando correctamente, puede realizar una comprobación de estado para identificar el problema y proponer soluciones.';
$string['settings_healthcheck_linktext'] = 'Realizar comprobación de estado';
$string['settings_userconnections'] = 'Conexiones de usuarios';
$string['settings_userconnections_linktext'] = 'Gestionar conexiones de usuarios';
$string['settings_userconnections_details'] = 'Revise y gestione las conexiones entre usuarios de Moodle y de Microsoft 365.';
$string['settings_teamconnections'] = 'Conexiones de equipos';
$string['settings_teamconnections_linktext'] = 'Gestionar conexiones de equipos';
$string['settings_teamconnections_details'] = 'Revise y gestione las conexiones entre cursos de Moodle y Microsoft Teams.';
$string['settings_usermatch'] = 'Coincidencia de usuarios';
$string['settings_usermatch_details'] = 'Esta herramienta le permite hacer coincidir usuarios de Moodle con usuarios de Microsoft 365 a partir de un archivo de datos personalizado subido.';
$string['settings_usersyncgroupfilter'] = 'Filtro de grupo para la sincronización de usuarios';
$string['settings_usersyncgroupfilter_details'] = 'Cuando se introduce aquí un ID de objeto de grupo (GUID), las sincronizaciones completas de usuarios se limitarán a los miembros y propietarios de ese grupo de Microsoft 365. Déjelo en blanco para sincronizar todos los usuarios con licencia de su inquilino.<br><br>
<strong>PRECAUCIÓN: Este es un ajuste avanzado. Una configuración incorrecta puede provocar problemas importantes de sincronización de datos.</strong><br><br>
<strong>Cuando está configurado, se aplica lo siguiente:</strong><br>
(1) Las actualizaciones de perfil, de zona horaria y de fotos solo se aplicarán a los usuarios que sean miembros o propietarios del grupo<br>
(2) Solo se crearán nuevas cuentas de Moodle para los usuarios que sean miembros o propietarios del grupo<br>
(3) Las cuentas de Moodle de los usuarios que no sean miembros dejarán de recibir actualizaciones y pueden quedar desincronizadas con Microsoft 365<br>
(4) Los usuarios deshabilitados en Microsoft 365 se seguirán suspendiendo en Moodle mediante la sincronización del estado de habilitación, que se ejecuta de forma independiente del filtrado por grupo<br>
(5) Quitar a un usuario del grupo detiene las sincronizaciones futuras de esa cuenta. Su cuenta de Moodle no se elimina, y solo se suspende si la opción "Suspender cuentas en Moodle cuando no estén en el grupo de sincronización de usuarios configurado" está habilitada, la cual suspende a todos los usuarios sincronizados que no estén en el grupo, hayan estado o no en él alguna vez<br><br>
<strong>Limitación de la sincronización incremental (delta):</strong> Microsoft Graph no admite consultas delta en los puntos de conexión de pertenencia a grupos. Cuando este ajuste está configurado, las sincronizaciones delta realizarán una sincronización completa de los miembros del grupo en lugar de una actualización incremental. Este es el comportamiento correcto, pero puede ser más lento que una sincronización delta normal.<br><br>
Valide el ID de objeto del grupo antes de guardar. Introduzca el ID de objeto del grupo (GUID).';
$string['settings_usersyncgroupfilter_validation_error'] = 'Formato de ID de grupo no válido. El ID de grupo debe ser un GUID válido (por ejemplo, 550e8400-e29b-41d4-a716-446655440000).';
$string['settings_usersynccreationrestriction'] = 'Restricción de creación de usuarios';
$string['settings_usersynccreationrestriction_details'] = 'Si está habilitado, durante la sincronización de usuarios solo se crearán los usuarios de Microsoft Entra ID que cumplan la condición. Para Pertenencia a grupo de Microsoft 365 (ID de objeto del grupo), introduzca un ID de objeto de grupo o varios ID de objeto de grupo separados por comas.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Valor del campo';
$string['settings_usersynccreationrestriction_o365group'] = 'Pertenencia a grupo de Microsoft 365 (nombre del grupo)';
$string['settings_usersynccreationrestriction_o365groupid'] = 'Pertenencia a grupo de Microsoft 365 (ID de objeto del grupo)';
$string['settings_usersynccreationrestriction_invalidgroupid'] = 'No se encontró el ID de objeto de grupo de Microsoft 365 "{$a}". Compruebe el ID e inténtelo de nuevo.';
$string['settings_usersynccreationrestriction_groupvalidationerror'] = 'No se pudieron validar los ID de objeto de grupo de Microsoft 365. Compruebe los ID y la configuración de Microsoft Graph e inténtelo de nuevo.';
$string['settings_usersynccreationrestriction_regex'] = 'El valor es una expresión regular';
$string['settings_maintenance'] = 'Mantenimiento';
$string['settings_maintenance_details'] = 'Hay varias tareas de mantenimiento disponibles para resolver algunos problemas comunes.';
$string['settings_maintenance_linktext'] = 'Ver herramientas de mantenimiento';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'Multiinquilino';
$string['acp_tenants_title_desc'] = 'Esta página le ayuda a configurar el acceso multiinquilino a Moodle desde Microsoft 365.';
$string['acp_tenants_add'] = 'Agregar nuevo inquilino';
$string['acp_tenants_errornotsetup'] = 'Complete el proceso de configuración del complemento antes de agregar inquilinos adicionales.';
$string['acp_tenants_hosttenant'] = 'Inquilino anfitrión: {$a}';
$string['acp_tenants_intro'] = '<b>Cómo funciona el modo multiinquilino:</b><br />El modo multiinquilino permite que varios inquilinos de Microsoft Entra accedan a su sitio de Moodle. <br /><br />
    A continuación se indica cómo configurarlo:
    <ol>
        <li>Inicie sesión en Moodle como un usuario administrador del sitio que no utilice el complemento de autenticación OpenID Connect.</li>
        <li>Asegúrese de que los ajustes <b>Punto de conexión de autorización</b> y <b>Punto de conexión de token</b> del complemento de autenticación OpenID Connect utilicen los valores predeterminados no específicos de un inquilino.</li>
        <li>Deshabilite el complemento de autenticación OpenID Connect en Moodle. (Utilice <a href="{$a}/admin/settings.php?section=manageauths">la página de administración de complementos de autenticación</a>).</li>
        <li>Vaya a Microsoft Entra ID y busque la aplicación que configuró para Moodle.</li>
        <li>Habilite el modo multiinquilino en la aplicación de Microsoft Entra ID y guarde los cambios.</li>
        <li>Otorgue a la aplicación al menos uno de los siguientes permisos delegados de Graph: <b>Directory.Read.All</b>, <b>Domain.Read.All</b> o <b>Domain.ReadWrite.All</b>. No se requiere el consentimiento del administrador para su organización.</li>
        <li>Si ya ha iniciado sesión con su cuenta de Microsoft del inquilino adicional, cierre la sesión por completo y vuelva a iniciarla.</li>
        <li>Para cada inquilino que desee habilitar, haga clic en "Agregar nuevo inquilino" e inicie sesión con una cuenta de administrador del inquilino que desea habilitar.</li>
        <li>Una vez que haya agregado todos los inquilinos que desee, vuelva a habilitar el complemento de autenticación OpenID Connect en Moodle.</li>
        <li>¡Listo! Para agregar más inquilinos en el futuro, solo tiene que hacer clic en el botón "Agregar nuevo inquilino" e iniciar sesión con una cuenta de administrador de ese inquilino.</li>
    </ol>
    <b>Nota importante:</b> Habilitar el modo multiinquilino en la aplicación de Microsoft Entra ID permite que todos los inquilinos de Microsoft Entra accedan a su aplicación. Agregar los inquilinos aquí nos permite restringir el acceso a Moodle a los inquilinos que configure. <b>Si quita todos los inquilinos de esta lista antes de deshabilitar el modo multiinquilino en la aplicación de Microsoft Entra ID, o habilita la autenticación OpenID Connect en Moodle con la lista vacía, su sitio de Moodle quedará abierto a todos los inquilinos de Microsoft Entra.</b>';
$string['acp_tenants_none'] = 'No ha configurado ningún inquilino. Si ha habilitado el modo multiinquilino en la aplicación de Microsoft Entra ID, su sitio de Moodle puede estar abierto a todos los usuarios de Microsoft 365.';
$string['acp_tenants_revokeaccess'] = 'Revocar acceso';
$string['acp_tenants_tenant'] = 'Inquilino';
$string['acp_tenants_actions'] = 'Acciones';
$string['acp_tenants_delete'] = 'Eliminar';
$string['acp_tenantsadd_desc'] = 'Para otorgar acceso a un inquilino adicional, haga clic en el botón siguiente e inicie sesión en Microsoft 365 con una cuenta de administrador del nuevo inquilino. Volverá a la lista de inquilinos adicionales, donde aparecerá el nuevo inquilino. A continuación, podrá utilizar Moodle con el nuevo inquilino.';
$string['acp_tenantsadd_linktext'] = 'Ir a la página de inicio de sesión de Microsoft 365';
$string['acp_tenants_legacy_tenants'] = 'Inquilinos heredados (se requiere acción)';
$string['acp_tenants_legacy_tenants_help'] = 'Es posible que los inquilinos adicionales agregados anteriormente que aparecen a continuación no funcionen con el flujo de trabajo multiinquilino actualizado y deban corregirse.<br/>
Utilice el botón "Agregar nuevo inquilino" de arriba para volver a agregarlos.';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = 'Comprobación de estado';
$string['healthcheck_fixlink'] = 'Haga clic aquí para corregirlo.';
$string['healthcheck_ratelimit_title'] = 'Limitación de la API';
$string['healthcheck_ratelimit_result_notice'] = 'Se ha habilitado una ligera limitación para gestionar el aumento de carga del sitio de Moodle. <br /><br />Todas las características de Microsoft 365 funcionan; simplemente se espacian un poco las solicitudes para evitar la interrupción de los servicios de Microsoft 365. Cuando disminuya la actividad de Moodle, todo volverá a la normalidad. <br />(Nivel {$a->level} / iniciado {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'Se ha habilitado una limitación mayor para gestionar una carga considerable del sitio de Moodle. <br /><br />Todas las características de Microsoft 365 siguen funcionando, pero las solicitudes a Microsoft 365 pueden tardar más en completarse. Cuando disminuya la actividad del sitio de Moodle, todo volverá a la normalidad. <br />(Nivel {$a->level} / iniciado {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'Las características de limitación de velocidad se han deshabilitado.';
$string['healthcheck_ratelimit_result_passed'] = 'Las llamadas a la API de Microsoft 365 se están ejecutando a máxima velocidad.';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'Gestionar conexiones de usuarios';
$string['acp_userconnections_column_muser'] = 'Usuario de Moodle';
$string['acp_userconnections_column_o365user'] = 'Usuario de Microsoft 365';
$string['acp_userconnections_column_status'] = 'Estado de la conexión';
$string['acp_userconnections_column_actions'] = 'Acciones';
$string['acp_userconnections_column_usinglogin'] = 'Usa inicio de sesión';
$string['acp_userconnections_column_status_help'] = 'El estado de la conexión muestra cómo está vinculada una cuenta de Moodle a una cuenta de Microsoft 365 (Microsoft Entra ID).

* **Conectado** – El usuario ha completado la conexión iniciando sesión en Moodle con su cuenta de Microsoft 365, o un administrador ha conectado activamente la cuenta. Las características como la sincronización del calendario y OneDrive funcionan para este usuario.
* **Coincidente** – Un administrador (o la herramienta de coincidencia masiva de usuarios) ha registrado a qué cuenta de Microsoft 365 pertenece este usuario de Moodle, pero la conexión aún no está activa. Se completa la primera vez que el usuario inicia sesión con Microsoft 365. No se sincroniza nada mientras un usuario solo es coincidente.
* **Sincronizado** – La cuenta de Moodle fue creada a partir de Microsoft Entra ID por la tarea de sincronización de usuarios, pero el usuario aún no ha iniciado sesión. La cuenta se activa en el primer inicio de sesión.
* **Sin conexión** – La cuenta de Moodle no está vinculada a ninguna cuenta de Microsoft 365.';
$string['acp_userconnections_column_actions_help'] = 'Las acciones disponibles para una fila dependen de su estado de conexión.

* **Desconectar** – Elimina el vínculo entre la cuenta de Moodle y la cuenta de Microsoft 365. La persona conserva su cuenta de Moodle, pero ya no puede utilizar las características de Microsoft 365 ni iniciar sesión con Microsoft 365 hasta que vuelva a conectarse. Se muestra para los usuarios conectados.
* **Resincronizar** – Ejecuta de inmediato la sincronización de datos de Microsoft 365 para este usuario (campos de perfil, foto, calendario, etc.) en lugar de esperar a la tarea programada, y muestra el resultado. Se muestra para los usuarios conectados y sincronizados.
* **Hacer coincidir** – Registra a qué cuenta de Microsoft 365 pertenece este usuario de Moodle. La conexión no está activa hasta que la persona inicia sesión con Microsoft 365. Se muestra para los usuarios sin conexión.
* **Deshacer coincidencia** – Elimina una coincidencia que aún no se ha completado. Se muestra para los usuarios coincidentes.';
$string['acp_userconnections_accountstatus_active'] = 'Activo';
$string['acp_userconnections_accountstatus_suspended'] = 'Suspendido';
$string['acp_userconnections_connectionstatus_connected'] = 'Conectado';
$string['acp_userconnections_connectionstatus_matched'] = 'Coincidente';
$string['acp_userconnections_connectionstatus_noconnection'] = 'Sin conexión';
$string['acp_userconnections_connectionstatus_synced'] = 'Sincronizado';
$string['acp_userconnections_filtering_accountstatus'] = 'Estado de la cuenta';
$string['acp_userconnections_filtering_connectionstatus'] = 'Estado de la conexión';
$string['acp_userconnections_filtering_muserfullname'] = 'Nombre completo del usuario de Moodle';
$string['acp_userconnections_filtering_musername'] = 'Nombre de usuario de Moodle';
$string['acp_userconnections_filtering_o365username'] = 'Nombre de usuario de Microsoft 365';
$string['acp_userconnections_manualmatch_title'] = 'Coincidencia manual de usuarios';
$string['acp_userconnections_manualmatch_details'] = 'Esta página le permite hacer coincidir un único usuario de Moodle con un único usuario de Microsoft 365.';
$string['acp_userconnections_manualmatch_musername'] = 'Usuario de Moodle';
$string['acp_userconnections_manualmatch_uselogin'] = 'Iniciar sesión con Microsoft 365';
$string['acp_userconnections_manualmatch_o365username'] = 'Nombre de usuario de Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'El usuario de Moodle ya está conectado a un usuario de Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'El usuario de Moodle ya está conectado a un usuario de Microsoft 365 (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'El usuario de Moodle ya coincide con un usuario de Microsoft 365';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'El usuario de Microsoft 365 ya coincide con otro usuario de Moodle';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'El usuario de Microsoft 365 ya está conectado a otro usuario de Moodle';
$string['acp_userconnections_resync_nodata'] = 'No se encontró información de Microsoft 365 almacenada para este usuario.';
$string['acp_userconnections_resync_notfound'] = 'No se sincronizó ningún dato. La cuenta "{$a->username}" está vinculada al objeto de Microsoft Entra ID {$a->objectid}, pero no se encontró ese objeto. Lo más probable es que el usuario se haya eliminado o deshabilitado en Microsoft 365, o que el ID de objeto almacenado esté obsoleto.';
$string['acp_userconnections_resync_nooutput'] = 'La resincronización finalizó sin informar de ningún cambio.';
$string['acp_userconnections_table_disconnect'] = 'Desconectar';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'Esto desconectará al usuario de Moodle "{$a}" de Microsoft 365. Haga clic en el enlace siguiente para continuar.';
$string['acp_userconnections_table_match'] = 'Hacer coincidir';
$string['acp_userconnections_table_resync'] = 'Resincronizar';
$string['acp_userconnections_table_unmatch'] = 'Deshacer coincidencia';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'Esto deshará la coincidencia del usuario de Moodle "{$a}" con Microsoft 365. Haga clic en el enlace siguiente para continuar.';

// Settings in the "Manage Team Connections" feature of the "Advanced" tab.
$string['acp_teamconnections'] = 'Gestionar conexiones de equipos';
$string['acp_teamconnection'] = 'Gestionar conexión de equipo';
$string['acp_teamconnections_actions'] = 'Acciones';
$string['acp_teamconnections_cache_last_updated'] = 'La caché de Teams se actualizó por última vez el {$a->lastupdated}. Haga clic <a href="{$a->updateurl}">aquí</a> para actualizar la caché.';
$string['acp_teamconnections_cache_never_updated'] = 'La caché de Teams nunca se ha actualizado. Haga clic <a href="{$a->updateurl}">aquí</a> para actualizarla.';
$string['acp_teamconnections_connected_team'] = 'Equipo conectado';
$string['acp_teamconnections_course_connected'] = 'El curso se ha conectado correctamente con el equipo.';
$string['acp_teamconnections_course_disconnected'] = 'El curso se ha desconectado del equipo.';
$string['acp_teamconnections_team_linked'] = 'El curso se ha vinculado al equipo.';
$string['acp_teamconnections_current_connection'] = 'CONEXIÓN ACTUAL';
$string['acp_teamconnections_exception_course_not_exist'] = 'El curso que se va a conectar no existe.';
$string['acp_teamconnections_exception_invalid_team_id'] = 'ID de equipo no válido';
$string['acp_teamconnections_exception_not_configured'] = 'Microsoft 365 no está totalmente configurado.';
$string['acp_teamconnections_exception_team_already_connected'] = 'El equipo ya está conectado a otro curso';
$string['acp_teamconnections_form_connect_course'] = 'Gestionar la conexión de equipo para el curso {$a}';
$string['acp_teamconnections_form_sds_warning'] = 'NOTA: Los equipos creados por Student Data Sync (SDS) no se pueden conectar manualmente aquí, ya que entraría en conflicto con la sincronización de SDS. Se excluyen de los resultados de búsqueda siguientes.';
$string['acp_teamconnections_form_team'] = 'Seleccionar equipo';
$string['acp_teamconnections_form_team_noselection'] = 'Buscar un equipo...';
$string['acp_teamconnections_no_teams_found'] = 'No se encontraron equipos para "{$a}"';
$string['acp_teamconnections_group_only'] = ' (Solo grupo)';
$string['acp_teamconnections_team_missing'] = '(Falta el equipo)';
$string['acp_teamconnections_not_connected'] = 'No conectado';
$string['acp_teamconnections_sync_disabled'] = 'Es necesario habilitar primero la sincronización de cursos antes de gestionar las conexiones de equipos.';
$string['acp_teamconnections_table_connect'] = 'Conectar';
$string['acp_teamconnections_table_connect_to_different_team'] = 'Conectar a otro equipo';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'No se puede crear el equipo a partir del grupo: no tiene propietario';
$string['acp_teamconnections_table_link_team'] = 'Vincular al equipo "{$a}"';
$string['acp_teamconnections_table_missing_team'] = 'El curso está conectado a un equipo que no existe. Esto se limpiará en la siguiente ejecución de la tarea programada de sincronización de cursos.';
$string['acp_teamconnections_table_resync'] = 'Resincronizar';
$string['acp_teamconnections_table_update'] = 'Actualizar';
$string['acp_teamconnections_teams_cache_updated'] = 'La caché de Teams se actualizó correctamente.';
$string['acp_teamconnections_no_owner'] = 'Agregue un propietario para conectar con Teams.';
$string['acp_teamconnections_resync'] = 'Resincronizar propietarios / miembros del equipo';
$string['acp_teamconnections_resync_title'] = 'Resincronizar propietarios / miembros del equipo para el curso {$a}';
$string['acp_teamconnections_resync_desc'] = 'Compara los usuarios matriculados en el curso con los propietarios y miembros del grupo/equipo de Microsoft 365 conectado, y agrega a quien falte. Elija si también deben quitarse los usuarios que están en el equipo pero no están matriculados en el curso de Moodle.';
$string['acp_teamconnections_resync_keep'] = 'Resincronizar (conservar los miembros adicionales del equipo)';
$string['acp_teamconnections_resync_keep_desc'] = 'Se agregarán los usuarios matriculados en el curso de Moodle que falten en el equipo. No se modificarán los propietarios / miembros existentes del equipo que no estén matriculados en el curso de Moodle.';
$string['acp_teamconnections_resync_remove'] = 'Resincronizar y quitar los miembros adicionales del equipo';
$string['acp_teamconnections_resync_remove_desc'] = 'Advertencia: cualquier propietario o miembro del equipo que no esté matriculado en el curso de Moodle se quitará del equipo, incluso si se agregó directamente en Microsoft Teams.';
$string['acp_teamconnections_resync_completed'] = 'Se han resincronizado los propietarios / miembros del equipo.';
$string['acp_teamconnections_resync_failed'] = 'No se pudieron resincronizar los propietarios / miembros del equipo. Consulte la salida anterior para obtener más detalles.';
$string['acp_teamconnections_last_resync'] = 'Última resincronización: {$a}';
$string['acp_teamconnections_never_resynced'] = 'Nunca se ha resincronizado';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'Coincidencia de usuarios';
$string['acp_usermatch_desc'] = 'Esta herramienta le permite hacer coincidir usuarios de Moodle con usuarios de Microsoft 365. Deberá subir un archivo que contenga los usuarios de Moodle y los usuarios de Microsoft 365 asociados, y una tarea cron verificará los datos y establecerá la coincidencia.';
$string['acp_usermatch_upload'] = 'Paso 1: Subir nuevas coincidencias';
$string['acp_usermatch_upload_desc'] = 'Suba un archivo de datos que contenga nombres de usuario de Moodle y de Microsoft 365 para hacer coincidir usuarios de Moodle con usuarios de Microsoft 365.<br />
<br />
Este archivo debe ser un archivo CSV de texto sin formato que contenga tres elementos por línea:
<ul>
<li>el nombre de usuario de Moodle,</li>
<li>el nombre de usuario de Microsoft 365,</li>
<li>1 o 0, donde 1 significa cambiar el método de autenticación del usuario a OpenID Connect, y 0 significa mantener el método de autenticación existente y utilizarla como cuenta vinculada.</li>
</ul>
No incluya encabezados ni datos adicionales.<br />
Por ejemplo: <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'El tipo {$a} no es compatible. Suba un archivo CSV de texto sin formato.';
$string['acp_usermatch_upload_err_data'] = 'La línea n.º {$a} contenía datos no válidos. Cada línea del archivo CSV debe tener al menos dos elementos: el nombre de usuario de Moodle y el nombre de usuario de Microsoft 365.';
$string['acp_usermatch_upload_err_fileopen'] = 'No se pudo abrir el archivo para procesarlo. ¿Son correctos los permisos del directorio moodledata?';
$string['acp_usermatch_upload_err_nofile'] = 'No se recibió ningún archivo para agregar a la cola.';
$string['acp_usermatch_upload_submit'] = 'Agregar archivo de datos a la cola de coincidencias';
$string['acp_usermatch_matchqueue'] = 'Paso 2: Cola de coincidencias';
$string['acp_usermatch_matchqueue_clearall'] = 'Borrar todo';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Borrar errores';
$string['acp_usermatch_matchqueue_clearqueued'] = 'Borrar en cola';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Borrar correctos';
$string['acp_usermatch_matchqueue_column_muser'] = 'Nombre de usuario de Moodle';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Nombre de usuario de Microsoft 365';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Estado';
$string['acp_usermatch_matchqueue_desc'] = 'Esta tabla muestra el estado actual de la operación de coincidencia. Cada vez que se ejecute la tarea programada <b>Procesar cola de coincidencias</b>, se procesará un lote de los siguientes usuarios.<br /><b>Nota:</b> Esta página no se actualiza dinámicamente; actualice la página para ver el estado actual.';
$string['acp_usermatch_matchqueue_empty'] = 'La cola de coincidencias está vacía. Suba un archivo de datos mediante el selector de archivos anterior para agregar usuarios a la cola.';
$string['acp_usermatch_matchqueue_status_error'] = 'Error: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'En cola';
$string['acp_usermatch_matchqueue_status_success'] = 'Correcto';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'Herramientas de mantenimiento';
$string['acp_maintenance_desc'] = 'Estas herramientas pueden ayudarle a resolver algunos problemas comunes.';
$string['acp_maintenance_warning'] = 'Advertencia: Estas son herramientas avanzadas. Utilícelas solo si entiende lo que está haciendo.';
$string['acp_maintenance_resyncgroupusers'] = 'Resincronizar usuarios en grupos de Microsoft 365 de los cursos';
$string['acp_maintenance_resyncgroupusers_desc'] = 'Esto resincronizará la pertenencia de usuarios de todos los grupos de Microsoft 365 creados para todos los cursos de Moodle. Así se garantiza que todos los usuarios matriculados en el curso de Moodle, y solo ellos, estén en el grupo de Microsoft 365. <br /><b>Nota:</b> Si ha agregado a un grupo de Microsoft 365 usuarios adicionales que no están matriculados en el curso de Moodle asociado, se quitarán.';
$string['acp_maintenance_recreatedeletedgroups'] = 'Volver a crear grupos de Microsoft 365 eliminados';
$string['acp_maintenance_recreatedeletedgroups_desc'] = 'Esto comprobará si hay grupos de Microsoft 365 conectados a cursos de Moodle que se hayan eliminado manualmente y los volverá a crear.';
$string['acp_maintenance_debugdata'] = 'Generar paquete de datos de depuración';
$string['acp_maintenance_debugdata_desc'] = 'Esto generará un paquete con diversa información sobre su entorno de Moodle y Microsoft 365 para ayudar a los desarrolladores a resolver cualquier problema que pueda tener. Si un desarrollador se lo solicita, ejecute esta herramienta y envíe el archivo descargado resultante. Nota: Aunque este paquete no contiene datos confidenciales de tokens, le pedimos que no publique este archivo ni lo envíe a terceros que no sean de confianza.';
$string['acp_maintenance_cleandeltatoken'] = 'Limpiar tokens delta de la sincronización de usuarios';
$string['acp_maintenance_cleandeltatoken_desc'] = 'Si la sincronización de usuarios no funciona completamente después de actualizar sus ajustes, puede deberse a un token de sincronización delta antiguo. Limpiar el token forzará una resincronización completa la próxima vez que se ejecute la sincronización de usuarios.';
$string['acp_maintenance_cleanapptokens'] = 'Limpiar tokens de aplicación';
$string['acp_maintenance_cleanapptokens_desc'] = 'Elimina los tokens de aplicación almacenados, que el complemento utiliza para las llamadas a las API de Microsoft que no se ejecutan como un usuario. Se solicitan automáticamente nuevos tokens de aplicación la próxima vez que se necesiten, y se borran los resultados de la última comprobación de "Verificar configuración" de la pestaña Configuración inicial. Si las llamadas realizadas con permisos de aplicación fallan con errores de autenticación, por ejemplo después de cambiar los permisos de la aplicación de Microsoft Entra ID o sus credenciales, limpiar los tokens puede ayudar. Los tokens de los usuarios no se ven afectados.';

// Settings in the "Resync users in Microsoft 365 groups for courses" feature in the "Maintenance Tools" feature of the
// "Advanced" tab.
$string['acp_maintenance_resyncgroupusers_course_output'] = 'Salida de la resincronización';
$string['acp_maintenance_resyncgroupusers_no_course'] = 'No hay ningún curso conectado a Microsoft 365';
$string['acp_maintenance_coursesync_disabled'] = 'Esta herramienta solo está disponible cuando la sincronización de cursos está habilitada. <a href="{$a}">Gestionar la sincronización de cursos</a>.';

// Settings in the "Recreate deleted Microsoft 365 groups" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_recreatedeletedgroups_group_type'] = 'Tipo de objeto de Moodle';
$string['acp_maintenance_recreatedeletedgroups_group_type_course'] = 'Curso';
$string['acp_maintenance_recreatedeletedgroups_group_type_course_group'] = 'Grupo del curso';
$string['acp_maintenance_recreatedeletedgroups_course'] = 'Curso';
$string['acp_maintenance_recreatedeletedgroups_course_group'] = 'Grupo del curso';
$string['acp_maintenance_recreatedeletedgroups_status'] = 'Estado';
$string['acp_maintenance_recreatedeletedgroups_status_sync_disabled'] = 'La sincronización de cursos está deshabilitada';
$string['acp_maintenance_recreatedeletedgroups_status_created_success'] = 'Se volvió a crear el grupo';
$string['acp_maintenance_recreatedeletedgroups_status_created_fail'] = 'Falló la recreación del grupo';
$string['acp_maintenance_recreatedeletedgroups_all_groups_exist'] = 'Existen todos los grupos conectados a cursos de Moodle y a grupos de cursos.';

// Settings in the "Cleanup User Sync Delta Tokens" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_cleandeltatoken_completed'] = 'Se limpiaron el token delta y el token skip delta de la sincronización de usuarios.';
$string['acp_maintenance_cleanapptokens_confirm'] = '¿Está seguro de que desea limpiar los tokens de aplicación? Actualmente hay {$a} token(s) de aplicación almacenado(s).';
$string['acp_maintenance_cleanapptokens_completed'] = 'Se limpiaron los tokens de aplicación y los últimos resultados de "Verificar configuración".';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_course_reset_teams'] = 'Acciones sobre el equipo/grupo al reiniciar el curso';
$string['settings_course_reset_teams_details'] = 'Acciones que se realizarán sobre un equipo o grupo conectado a un curso cuando se reinicie el curso.';
$string['settings_course_reset_teams_option_do_nothing'] = 'No hacer nada<br/>El equipo o grupo sigue conectado al curso. Al dar de baja a los usuarios se les quitará como miembros del equipo o grupo.';
$string['settings_course_reset_teams_option_per_course'] = 'Permitir la configuración por curso<br/>Esto requiere que se agregue el bloque Microsoft al curso. Los usuarios con la capacidad de reiniciar el curso pueden elegir en el bloque qué hacer durante el reinicio del curso.';
$string['settings_course_reset_teams_option_force_archive'] = 'Desconectar el curso del equipo o grupo y crear uno nuevo<br/>Se cambiará el nombre del equipo o grupo existente conectado al curso según lo configurado. Si hay un equipo conectado, se archivará. Se creará un nuevo equipo o grupo y se conectará al curso.';
$string['settings_course_reset_teams_option_archive_only'] = 'Solo desconectar el curso del equipo o grupo<br />Se cambiará el nombre del equipo o grupo existente conectado al curso según lo configurado. Si hay un equipo conectado, se archivará. No se creará ningún equipo o grupo nuevo.';
$string['settings_reset_team_name_prefix'] = 'Prefijo del nombre del equipo al reiniciar';
$string['settings_reset_team_name_prefix_details'] = 'Al reiniciar un curso conectado a un equipo, se antepondrá este prefijo al nombre del equipo conectado existente.';
$string['settings_reset_group_name_prefix'] = 'Prefijo del nombre del grupo al reiniciar';
$string['settings_reset_group_name_prefix_details'] = 'Al reiniciar un curso conectado a un grupo, se antepondrá este prefijo al nombre del grupo existente.';
$string['settings_calsync_courseeventmode'] = 'Eventos de Outlook para eventos del calendario del curso';
$string['settings_calsync_courseeventmode_details'] = 'Controla cómo se crea en Outlook un evento del calendario de un curso de Moodle para los usuarios que se han suscrito al calendario del curso.
<ul>
<li><strong>Un evento compartido con los usuarios del curso como asistentes:</strong> se crea un único evento en el calendario de Outlook del usuario que creó el evento de Moodle (o en el calendario del grupo de Microsoft 365 del curso, si el curso está vinculado a un grupo), y se agregan los usuarios del curso como asistentes.</li>
<li><strong>Un evento individual por usuario:</strong> se crea un evento independiente directamente en el calendario de Outlook de cada usuario suscrito. No hay evento compartido ni lista de asistentes, y no se agrega nada al calendario del grupo de Microsoft 365.</li>
</ul>
Cambiar este ajuste solo afecta a los eventos sincronizados a partir de entonces; los eventos que ya están en Outlook no se convierten.';
$string['settings_calsync_courseeventmode_shared'] = 'Un evento compartido con los usuarios del curso como asistentes';
$string['settings_calsync_courseeventmode_individual'] = 'Un evento individual por usuario';
$string['settings_debugmode'] = 'Grabar mensajes de depuración';
$string['settings_debugmode_details'] = 'Si está habilitado, se registrará en el registro de Moodle información que puede ayudar a identificar problemas. <a href="{$a}">Ver los mensajes de registro grabados.</a>';
$string['settings_switchauthminupnsplit0'] = 'Longitud mínima del nombre de usuario no exacto para cambiar a Microsoft 365';
$string['settings_switchauthminupnsplit0_details'] = 'Si habilita el ajuste "Cambiar usuarios coincidentes a la autenticación de Microsoft 365 (OpenID Connect)", este ajuste establece la longitud mínima de los nombres de usuario sin inquilino (la parte @example.onmicrosoft.com) que se cambiarán. Esto ayuda a evitar el cambio de cuentas con nombres genéricos, como "admin", que no son necesariamente las mismas en Moodle y en Microsoft Entra ID. Establézcalo en 0 para cambiar los usuarios coincidentes independientemente de la longitud del nombre de usuario. Los usuarios cuyo método de autenticación no se cambió debido a este ajuste se registran como "Usuario coincidente, pero el nombre de usuario no coincide exactamente con el UPN de Microsoft Entra ID y no cumple los requisitos de coincidencia exacta para cambiar a OIDC..." en la salida de la tarea de sincronización, y se muestran como "Coincidente con usuario existente - Pendiente de completar" en la página Gestionar conexiones de usuarios.';
$string['settings_customtheme'] = 'Tema personalizado (avanzado)';
$string['settings_customtheme_desc'] = 'El tema recomendado es "boost_o365teams". No obstante, puede seleccionar otro tema si tiene un tema personalizado adaptado para usarse en la pestaña de Teams.<br/>
Tenga en cuenta que un tema personalizado establecido a nivel de curso o de categoría tendrá prioridad sobre los ajustes de aquí, es decir, un curso utilizará de manera predeterminada el tema del curso o de la categoría en la aplicación de Moodle en Teams. Esto se puede solucionar actualizando $CFG->themeorder en config.php a "array(\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\');".';

// Settings in the "SDS sync" tab.
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>Esta es una característica en versión preliminar</b><br />Es posible que las características en versión preliminar no funcionen como se espera o dejen de funcionar sin previo aviso. Proceda con precaución.</div>';
$string['settings_sds_intro_desc'] = 'Microsoft School Data Sync ("SDS") simplifica la gestión de clases en Microsoft 365, leyendo las listas de clase de un SIS externo y creando clases y grupos en Microsoft 365. <a href="https://sds.microsoft.com/" target="_blank">Más información</a><br/>
<br/>
La característica de sincronización de SDS puede sincronizar los datos de las listas de clase de SDS con Moodle, incluidas las clases, los profesores y los estudiantes.<br/>
<br/>
Para utilizar la característica de sincronización de SDS, asegúrese de que la aplicación de Microsoft Entra ID utilizada para la integración tenga los permisos de aplicación de Microsoft Graph <b>EduRoster.Read.All</b> y <b>Member.Read.Hidden</b>, que la configuración predeterminada no agrega automáticamente. También se debe otorgar el consentimiento del administrador para ellos.<br/>
<br/>
De manera predeterminada, el proceso de sincronización de SDS se ejecuta diariamente en el cron de Moodle, a las 3 a. m. hora del servidor. Para cambiar esta programación, visite la <a href="{$a}">página de gestión de Tareas programadas.</a><br/><br/>';
$string['settings_sds_coursecreation'] = 'Sincronización de clases con cursos';
$string['settings_sds_coursecreation_desc'] = 'Estas opciones controlan la creación de cursos de Moodle a partir de las clases de las escuelas de SDS.';
$string['settings_sds_coursecreation_enabled'] = 'Escuelas sincronizadas';
$string['settings_sds_coursecreation_enabled_desc'] = 'Crear cursos para las clases de estas escuelas.';
$string['settings_sds_teams_enabled'] = '¿Las clases de SDS ya tienen equipos?';
$string['settings_sds_teams_enabled_desc'] = 'Marque esta opción si las clases de SDS ya tienen equipos creados por la configuración de SDS. Si está marcada, Moodle no intentará crear equipos a partir de los cursos de Moodle creados desde clases de SDS para evitar conflictos.';
$string['settings_sds_courseenrolsync'] = 'Sincronización de matriculaciones en cursos';
$string['settings_sds_courseenrolsync_desc'] = 'Estas opciones controlan la sincronización de las matriculaciones en cursos a partir de las clases de las escuelas de SDS.';
$string['settings_sds_enrolment_enabled'] = 'Sincronizar matriculaciones de SDS a Moodle';
$string['settings_sds_enrolment_enabled_desc'] = 'Si está habilitado, la tarea programada de sincronización de SDS matriculará a los profesores y estudiantes de las clases de SDS en sus cursos de Moodle correspondientes, y quitará a los usuarios que ya no estén en la clase de SDS. Requiere que estén configurados <b>Rol de profesor de clase de SDS en Moodle</b> y <b>Rol de estudiante de clase de SDS en Moodle</b>.';
$string['settings_sds_sync_enrolment_to_sds'] = 'Sincronizar matriculaciones de Moodle a SDS';
$string['settings_sds_sync_enrolment_to_sds_desc'] = 'Si está habilitado, los cambios de matriculación realizados en cursos de Moodle conectados a clases de SDS se sincronizarán de vuelta con las clases de SDS. El estado de propietario / miembro del usuario en SDS dependerá de las capacidades "local/o365:teamowner" y "local/o365:teammember" en el contexto del curso.';
$string['settings_sds_suspend_enrolment'] = 'Suspender las matriculaciones de los usuarios en lugar de darlos de baja';
$string['settings_sds_suspend_enrolment_desc'] = 'Si esta opción está habilitada, a los usuarios que se quiten de una clase de SDS se les suspenderá la matriculación en el curso de Moodle conectado en lugar de darlos de baja por completo. Así se conservan los datos del usuario, como las calificaciones, los envíos y la finalización de actividades. Cuando los usuarios se vuelvan a agregar a la clase de SDS, su matriculación se reactivará automáticamente.<br />
<b>Nota:</b> La sincronización de SDS nunca suspende ni da de baja a los profesores. Este ajuste solo afecta a los estudiantes.';
$string['settings_sds_enable_course_sync'] = 'Habilitar la sincronización bidireccional de cursos';
$string['settings_sds_enable_course_sync_desc'] = 'Si está habilitado, cada curso de Moodle creado a partir de una clase de SDS se vinculará a su grupo de Microsoft 365 en la base de datos, lo que activa la integración completa de sincronización de cursos de Microsoft 365 (Teams, archivos, calendario, etc.) para ese curso. Si la clase de SDS ya tiene un equipo, también se crea un registro de asociación con Teams.';
$string['settings_sds_course_field_mailnickname'] = 'Alias de correo (mailNickname)';
$string['settings_sds_course_field_displayname'] = 'Nombre para mostrar (displayName)';
$string['settings_sds_course_field_classcode'] = 'Código de clase (classCode)';
$string['settings_sds_course_field_externalname'] = 'Nombre externo (externalName)';
$string['settings_sds_course_shortname_field'] = 'Origen del nombre corto del curso';
$string['settings_sds_course_shortname_field_desc'] = 'La propiedad de la clase de SDS que se utiliza como nombre corto de los cursos de Moodle recién creados. Moodle requiere que los nombres cortos de los cursos sean únicos. Si la propiedad elegida está vacía, o su valor ya lo utiliza un curso vinculado a otra clase de SDS, se utiliza en su lugar el alias de correo. Cambiar este ajuste no cambia el nombre de los cursos ya creados.';
$string['settings_sds_course_fullname_field'] = 'Origen del nombre completo del curso';
$string['settings_sds_course_fullname_field_desc'] = 'La propiedad de la clase de SDS que se utiliza como nombre completo de los cursos de Moodle recién creados. Si la propiedad elegida está vacía, se utiliza en su lugar el nombre para mostrar. Cambiar este ajuste no cambia el nombre de los cursos ya creados.';
$string['settings_sds_categorize_by_subject'] = 'Categorizar cursos por asignatura';
$string['settings_sds_categorize_by_subject_desc'] = 'Si está habilitado, los cursos se organizarán en categorías por asignatura dentro de la categoría de cada escuela. El nombre de la asignatura se extrae de la información de la clase en SDS. Si está deshabilitado, todos los cursos se colocan directamente en la categoría de la escuela.';
$string['settings_sds_ignore_past_courses'] = 'Ignorar clases caducadas/pasadas';
$string['settings_sds_ignore_past_courses_desc'] = 'Si está habilitado, las clases que hayan caducado o finalizado se omitirán durante la sincronización. Esto incluye:<br />
<ul>
<li>Las clases con el prefijo de caducidad configurado en su nombre (predeterminado: "Exp")</li>
<li>Las clases con una fecha de finalización pasada</li>
</ul>
Esto ayuda a mantener limpio el catálogo de cursos al no crear cursos para clases antiguas o archivadas.';
$string['settings_sds_expired_course_prefix'] = 'Prefijo del nombre de clase caducada';
$string['settings_sds_expired_course_prefix_desc'] = 'Los nombres de clase que comiencen con este prefijo se considerarán caducados y se omitirán durante la sincronización (si "Ignorar clases caducadas/pasadas" está habilitado). Predeterminado: "Exp"';
$string['settings_sds_cohortsync'] = 'Sincronización de cohortes';
$string['settings_sds_cohortsync_desc'] = 'Estas opciones controlan la creación y sincronización de cohortes a partir de las clases de SDS. Las cohortes ofrecen una forma alternativa de agrupar usuarios que puede utilizarse para la matriculación en todo el sitio u otras características de Moodle.';
$string['settings_sds_create_cohorts'] = 'Crear cohortes a partir de las clases de SDS';
$string['settings_sds_create_cohorts_desc'] = 'Si está habilitado, se creará una cohorte para cada clase de SDS y sus miembros se mantendrán sincronizados con la clase de SDS. Las cohortes se crean en el contexto de la categoría de cursos (categoría de escuela o de asignatura, según los ajustes de categorización).<br />
<b>Nota:</b> Las cohortes se crean además de los cursos, no en lugar de ellos. Esto le permite utilizar las cohortes para la matriculación o agrupación en todo el sitio, manteniendo al mismo tiempo los cursos sincronizados con SDS.';
$string['settings_sds_cohort_include_teachers'] = 'Incluir a los profesores en las cohortes';
$string['settings_sds_cohort_include_teachers_desc'] = 'Si está habilitado, los profesores de la clase de SDS se agregarán a la cohorte junto con los estudiantes. Si está deshabilitado, solo se agregarán los estudiantes a las cohortes.';
$string['settings_sds_enrolment_teacher_role'] = 'Rol de profesor de clase de SDS en Moodle';
$string['settings_sds_enrolment_teacher_role_desc'] = 'Si "Sincronizar matriculaciones de SDS a Moodle" está habilitado, los profesores de la clase de SDS se matricularán en el curso de Moodle conectado con este rol.';
$string['settings_sds_enrolment_student_role'] = 'Rol de estudiante de clase de SDS en Moodle';
$string['settings_sds_enrolment_student_role_desc'] = 'Si "Sincronizar matriculaciones de SDS a Moodle" está habilitado, los estudiantes de la clase de SDS se matricularán en el curso de Moodle conectado con este rol.';
$string['settings_sds_profilesync_header'] = 'Sincronización del perfil de usuario';
$string['settings_sds_profilesync_header_desc'] = 'Cada escuela de SDS puede almacenar el perfil de usuario de los profesores y miembros de la escuela. El campo es específico de cada escuela, es decir, distintas escuelas pueden tener valores diferentes en el mismo campo para el mismo usuario.<br/>
Si se selecciona una escuela en esta sección, los campos de perfil de usuario de SDS se pueden configurar en la asignación de campos de usuario.
<ul>
<li>Tenga en cuenta que la sincronización de los campos de SDS solo se producirá al ejecutar la tarea programada "Sincronizar con SDS", y no al ejecutar la tarea programada "Sincronizar usuarios desde Microsoft Entra ID" ni cuando un usuario inicie sesión.</li>
<li>Tenga en cuenta que existe un problema conocido en la API de Microsoft Graph utilizada por esta característica por el que no se devuelven ciertos campos del perfil escolar de estudiantes y profesores, por lo que no están disponibles para sincronizar aunque estén configurados.</li>
</ul>
';
$string['settings_sds_profilesync_disabled'] = 'Deshabilitado';
$string['settings_sds_profilesync'] = 'Sincronizar datos de perfil de la escuela';
$string['settings_sds_profilesync_desc'] = 'Seleccione la escuela de SDS desde la que Moodle sincroniza los datos de perfil específicos de SDS.';
$string['settings_sds_noschools'] = '<div class="alert alert-info">No tiene ninguna escuela disponible en SDS.</div>';
$string['settings_sds_get_schools_error'] = '<div class="alert alert-info error">No se pudieron obtener las escuelas de SDS. Compruebe que la aplicación de Microsoft Entra ID tenga el permiso necesario.</div>';
$string['settings_sds_school_disabled_action'] = 'Acción al deshabilitar la sincronización de una escuela';
$string['settings_sds_school_disabled_action_desc'] = 'Acción que se realizará sobre los cursos de Moodle ya conectados cuando se deshabilite la sincronización de una escuela de SDS.';
$string['settings_sds_school_disabled_action_keep_connected'] = 'Mantener el curso de Moodle conectado al equipo';
$string['settings_sds_school_disabled_action_disconnect'] = 'Desconectar el curso de Moodle del equipo';
$string['settings_sds_school_unavailable'] = '{$a} (la lista de escuelas de SDS no está disponible en este momento)';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner'] = 'La aplicación de Moodle para <a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teams</a> le permite acceder fácilmente a sus cursos de Moodle y colaborar en torno a ellos en Teams.';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Configure su aplicación de Moodle para Microsoft Teams</h4>';
$string['settings_moodlesettingssetup'] = 'Configurar Moodle';
$string['settings_check_moodle_settings'] = 'Comprobar la configuración de Moodle';
$string['settings_moodlesetup_checking'] = 'Verificando...';
$string['settings_notice_cookiesecureenabled'] = 'Se habilitó correctamente Solo cookies seguras';
$string['settings_notice_cookiesecurealreadyenabled'] = 'Solo cookies seguras ya estaba habilitado';
$string['settings_notice_oidcenabled'] = 'OpenID Connect se habilitó correctamente';
$string['settings_notice_oidcnotenabled'] = 'No se pudo habilitar OpenID Connect';
$string['settings_notice_oidcalreadyenabled'] = 'OpenID Connect ya estaba habilitado';
$string['settings_notice_webservicesframealreadyenabled'] = 'Los servicios web ya estaban habilitados y la incrustación de marcos también está permitida';
$string['settings_notice_webservicesframeenabled'] = 'Los servicios web se habilitaron correctamente y ahora también se permite la incrustación de marcos';
$string['settings_notice_restenabled'] = 'El protocolo REST se habilitó correctamente';
$string['settings_notice_restnotenabled'] = 'No se pudo habilitar el protocolo REST';
$string['settings_notice_restalreadyenabled'] = 'El protocolo REST ya estaba habilitado';
$string['settings_notice_o365serviceenabled'] = 'Los servicios web de Microsoft 365 se habilitaron correctamente';
$string['settings_notice_o365servicealreadyenabled'] = 'Los servicios web de Microsoft 365 ya estaban habilitados';
$string['settings_notice_createtokenallowed'] = 'Se otorgó el permiso para crear un token de servicio web';
$string['settings_notice_createtokenalreadyallowed'] = 'El permiso para crear un token de servicio web ya estaba otorgado';
$string['settings_notice_createtokennotallowed'] = 'Hubo un problema al otorgar el permiso para crear un token de servicio web';
$string['settings_notice_restusageallowed'] = 'Se otorgó el permiso para usar el protocolo REST';
$string['settings_notice_restusagealreadyallowed'] = 'El permiso para usar el protocolo REST ya estaba otorgado';
$string['settings_notice_restusagenotallowed'] = 'Hubo un problema al otorgar el permiso para usar el protocolo REST';
$string['settings_moodlesettingssetup_details'] = 'Esto garantizará que:
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>Solo cookies seguras esté habilitado.</li>
<li>OpenID Connect esté habilitado.</li>
<li>La incrustación de marcos esté habilitada.</li>
<li>Los servicios web estén habilitados.</li>
<li>El protocolo REST esté habilitado.</li>
<li>Los servicios web de Microsoft 365 estén habilitados.</li>
<li>El usuario autenticado tenga permiso para crear un token de servicio web.</li>
<li>El usuario autenticado tenga permiso para usar el protocolo REST.</li>
</ul>';
$string['settings_teams_moodle_app_external_id'] = 'ID de aplicación de Microsoft para la aplicación de Moodle para Teams';
$string['settings_teams_moodle_app_external_id_desc'] = 'Debe establecerse en el valor predeterminado, a menos que se necesiten varias aplicaciones de Moodle para Teams en su inquilino para conectarse a distintos sitios de Moodle.';
$string['settings_teams_moodle_app_short_name'] = 'Nombre de la aplicación de Teams';
$string['settings_teams_moodle_app_short_name_desc'] = 'Puede dejarse con el valor predeterminado, a menos que se necesiten varias aplicaciones de Moodle para Teams en su inquilino para conectarse a distintos sitios de Moodle.';
$string['settings_download_teams_tab_app_manifest'] = 'Descargar archivo de manifiesto';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Guarde todos los cambios antes de descargar el manifiesto.';
$string['settings_publish_manifest_instruction'] = '<a href="https://learn.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Haga clic aquí</a> para saber cómo publicar el archivo de manifiesto de la aplicación de Moodle descargado para todos los usuarios de Teams.';
$string['settings_teams_moodle_tab_name'] = 'Nombre de la pestaña de Moodle en Teams';
$string['settings_teams_moodle_tab_name_desc'] = 'Este es el nombre de la pestaña de Moodle en Teams.';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'ID de la aplicación de Moodle';
$string['settings_moodle_app_id_desc'] = 'ID de la aplicación de Moodle subida en los catálogos de aplicaciones de Teams.<br/>
Si está configurado, Moodle intentará crear una pestaña de Moodle que enlace al curso de Moodle en el canal "General" del equipo creado/conectado.';
$string['settings_moodle_app_id_desc_auto_id'] = '<br/>
El valor detectado automáticamente es "<span class="local_o365_settings_moodle_app_id">{$a}</span>".';
$string['settings_set_moodle_app_id_instruction'] = 'Para encontrar manualmente el ID de la aplicación de Moodle, siga estos pasos:
<ol>
<li>Suba el archivo de manifiesto descargado en el catálogo de aplicaciones de Teams de su inquilino.</li>
<li>En el catálogo de aplicaciones de Teams, busque la aplicación.</li>
<li>Haga clic en el icono de opciones de la aplicación, situado en la esquina superior derecha de la imagen de la aplicación.</li>
<li>Haga clic en "Copiar vínculo".</li>
<li>Pegue el contenido copiado en un editor de texto. Debe contener una URL como https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
La última parte de la URL, es decir, <span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>, es el ID de la aplicación.';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Habilitar la sincronización del calendario de Outlook';
$string['calendar_user'] = 'Calendario personal (usuario)';
$string['calendar_site'] = 'Calendario de todo el sitio';
$string['personal_calendar'] = 'Personal';
$string['calendar_event'] = 'Ver detalles';
$string['eventcalendarsubscribed'] = 'El usuario se suscribió a un calendario';
$string['eventcalendarunsubscribed'] = 'El usuario canceló la suscripción a un calendario';

// Errors.
$string['erroracpauthoidcnotconfig'] = 'Establezca las credenciales de la aplicación en auth_oidc primero.';
$string['errorhttpclientbadtempfileloc'] = 'No se pudo abrir la ubicación temporal para almacenar el archivo.';
$string['errorhttpclientnofileinput'] = 'No hay parámetros del archivo en httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'No se pudo actualizar el token';
$string['errormfarequired'] = 'Microsoft requiere la autenticación multifactor antes de que Moodle pueda acceder a su cuenta de Microsoft 365. Seleccione Continuar para iniciar sesión de nuevo en Microsoft 365 y complete la solicitud de autenticación multifactor.';
$string['errorgetapplicationtoken'] = 'No se pudo obtener el token de aplicación. Verifique la configuración de la integración.';
$string['erroracpapcantgettenant'] = 'No se pudo obtener el inquilino de Microsoft Entra; introdúzcalo manualmente.';
$string['erroracpcantgettenant'] = 'No se pudo obtener la URL de OneDrive; introdúzcala manualmente.';
$string['errorprovisioningapp'] = 'No se pudo aprovisionar la aplicación de Moodle en el equipo.';
$string['erroro365apibadcall'] = 'Error en la llamada a API.';
$string['erroro365apibadcall_message'] = 'Error en la llamada a la API: {$a}';
$string['erroro365apiinvalidtoken'] = 'Token no válido o vencido.';
$string['erroro365apiinvalidmethod'] = 'Método http no válido pasado a llamada de api';
$string['erroro365apinotimplemented'] = 'Este debe ser anulado.';
$string['erroro365apinotoken'] = 'No había un token para el recurso y el usuario indicados, y no se pudo obtener uno. ¿Ha caducado el token de actualización del usuario?';
$string['errorusermatched'] = 'La cuenta de Microsoft 365 "{$a->entraidupn}" ya coincide con el usuario de Moodle "{$a->username}". Para completar la conexión, inicie sesión primero como ese usuario de Moodle y siga las instrucciones del bloque Microsoft.';
$string['errornodirectaccess'] = 'Está prohibido el acceso directo a la página';
$string['eventapifail'] = 'Falla de API';
$string['errorunabletofindgraphapi'] = 'No se encontró la API de Microsoft Graph en la aplicación.';
$string['erroremptyjwt'] = 'Se proporcionó un token JWT vacío';
$string['errornocachedjwks'] = 'No se encontró ningún JWKS en caché';
$string['errorfetchjwks'] = 'No se pudo obtener el JWKS de Microsoft';
$string['errorinvalidjwks'] = 'Se recibió un JWKS con formato no válido de Microsoft';
$string['errorjwtvalidation'] = 'Falló la validación del JWT';
$string['errorjwtinvalidissuer'] = 'Falló la validación del emisor del JWT';
$string['errorcannotgettoken'] = 'No se pudo obtener el token de aplicación o del sistema.';
$string['errornotokenforsysmemuser'] = 'No hay ningún token disponible para el usuario del sistema. Ejecute la comprobación de estado de local_o365.';
$string['errornotoken'] = 'No hay ningún token disponible para el usuario n.º {$a}';
$string['errornotokenforusersync'] = 'No hay ningún token disponible para la sincronización de usuarios.';
$string['errornoapifound'] = 'No se encontró ninguna API con el identificador {$a}.';
$string['errornoresponsesavailable'] = 'No hay respuestas disponibles.';
$string['erroro365badphoto'] = 'Se recibió una foto de perfil no válida de Microsoft 365.';
$string['erroro365nophoto'] = 'Este usuario no tiene foto en Microsoft 365.';
$string['errorcannotgetapiclient'] = 'No se puede obtener el cliente de la API de Graph.';
$string['errorfailedtogetsecrets'] = 'No se pudieron obtener los secretos.';
$string['errorfailedtosendnotification'] = 'No se pudo enviar el correo electrónico de notificación a uno o más destinatarios.';
$string['errorsecretexpiryrecipientundeliverable'] = 'Uno o más destinatarios configurados de la notificación de caducidad del secreto no pueden recibir correo electrónico (dirección no válida o dominio sin registro MX/A): {$a}. Actualice los destinatarios de la notificación en la configuración de OpenID Connect.';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Complemento local de Microsoft 365';
$string['privacy:metadata:local_o365_calidmap'] = 'Información sobre los vínculos entre los eventos del calendario de Microsoft 365 y los eventos del calendario de Moodle.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'El ID del usuario propietario del evento.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'Dónde se originó el evento: en Moodle o en Microsoft 365.';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'El ID del evento en Outlook.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'El ID del evento en Moodle.';
$string['privacy:metadata:local_o365_calsub'] = 'Información sobre las suscripciones de sincronización entre los calendarios de Moodle y Outlook';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'El ID del usuario de Moodle al que corresponde la suscripción';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'El tipo de calendario de Moodle (site,course,user)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'El ID asociado del calendario de Moodle';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'El ID del calendario de Microsoft 365';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Si este es el calendario principal';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'El comportamiento de la sincronización (es decir, de Moodle a Outlook o de Outlook a Moodle)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'La hora en que se creó la suscripción.';
$string['privacy:metadata:local_o365_connections'] = 'Información sobre las conexiones entre usuarios de Moodle y de Microsoft 365 que aún no se han confirmado';
$string['privacy:metadata:local_o365_connections:muserid'] = 'El ID del usuario de Moodle';
$string['privacy:metadata:local_o365_connections:entraidupn'] = 'El UPN del usuario de Microsoft Entra ID.';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Si se debe cambiar el método de autenticación del usuario al completarse.';
$string['privacy:metadata:local_o365_token'] = 'Información sobre los tokens de la API de Microsoft 365 de los usuarios';
$string['privacy:metadata:local_o365_token:user_id'] = 'El ID del usuario de Moodle';
$string['privacy:metadata:local_o365_token:scope'] = 'El ámbito del token.';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'El recurso del token.';
$string['privacy:metadata:local_o365_token:token'] = 'El token.';
$string['privacy:metadata:local_o365_token:expiry'] = 'La hora de caducidad del token.';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'El token de actualización.';
$string['privacy:metadata:local_o365_objects'] = 'Información sobre la relación entre los objetos de Moodle y de Microsoft 365';
$string['privacy:metadata:local_o365_objects:type'] = 'El tipo de objeto (grupo, usuario, curso, etc.)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'El subtipo del objeto.';
$string['privacy:metadata:local_o365_objects:objectid'] = 'El ID del objeto de Microsoft 365';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'El ID del objeto en Moodle';
$string['privacy:metadata:local_o365_objects:o365name'] = 'El nombre legible del objeto en Microsoft 365';
$string['privacy:metadata:local_o365_objects:tenant'] = 'El inquilino al que pertenece el objeto (en entornos multiinquilino)';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Cualquier metadato asociado';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'La hora en que se creó el registro.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'La hora en que se modificó el registro.';
$string['privacy:metadata:local_o365_appassign'] = 'Información sobre las asignaciones de roles de aplicación de Microsoft 365';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'El ID del usuario de Moodle';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Si el usuario se ha asignado a la aplicación';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'El ID de la foto del usuario en Microsoft 365';
$string['privacy:metadata:local_o365_appassign:photohash'] = 'Un hash SHA-256 de los bytes de la foto de perfil del usuario, almacenado para detectar cambios en la foto sin volver a obtener la imagen completa';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Cuándo se actualizó por última vez la foto del usuario desde Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue'] = 'Información sobre la coincidencia de usuarios de Moodle con usuarios de Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'El nombre de usuario del usuario de Moodle.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'El nombre de usuario del usuario de Microsoft 365.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Si se debe cambiar el usuario a la autenticación OpenID Connect cuando se establezca la coincidencia';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Si el registro se ha procesado';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'El mensaje de error (si lo hay)';
$string['privacy:metadata:preference:suspendedtime'] = 'La hora en que la sincronización de usuarios suspendió al usuario, ya sea porque se eliminó la cuenta de Microsoft Entra ID coincidente o porque se deshabilitó.';
$string['privacy:metadata:local_o365_calsettings'] = 'Información sobre la configuración de sincronización del calendario';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'El ID del usuario de Moodle';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'El ID del calendario en Microsoft 365';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'La hora en que se creó el registro.';
$string['privacy:metadata:preference:calsync_initialised'] = 'Si se han inicializado las opciones de sincronización del calendario de Outlook del usuario, para que no se vuelvan a habilitar automáticamente.';

// Page "Microsoft 365 / Moodle Control Panel" in the Microsoft block.
$string['ucp_title'] = 'Panel de control de Microsoft 365/Moodle';
$string['ucp_general_intro'] = 'Aquí puede gestionar su conexión a Microsoft 365.';
$string['ucp_calsync_availcal'] = 'Calendarios de Moodle disponibles';
$string['ucp_calsync_title'] = 'Configuración de sincronización del calendario de Outlook';
$string['ucp_calsync_desc'] = 'Los calendarios seleccionados se sincronizarán desde Moodle con el calendario de Outlook.';
$string['ucp_connection_options'] = 'Opciones de conexión:';
$string['ucp_connection_desc'] = 'Aquí puede configurar cómo se conecta a Microsoft 365. Para utilizar las características de Microsoft 365, debe estar conectado a una cuenta de Microsoft 365. Puede hacerlo como se indica a continuación.';
$string['ucp_connection_entraidlogin'] = 'Usar sus credenciales de Microsoft 365 para iniciar sesión en Moodle<br />';
$string['ucp_connection_entraidlogin_desc_authcode'] = 'En lugar de introducir un nombre de usuario y una contraseña en la página de inicio de sesión de Moodle, verá en la página de inicio de sesión una sección que dice "Iniciar sesión con su cuenta de {$a}". Hará clic en el enlace y se le redirigirá a Microsoft 365 para iniciar sesión. Una vez que haya iniciado sesión correctamente en Microsoft 365, volverá a Moodle con la sesión iniciada en su cuenta.';
$string['ucp_connection_entraidlogin_start'] = 'Empezar a usar Microsoft 365 para iniciar sesión en Moodle.';
$string['ucp_connection_entraidlogin_stop'] = 'Dejar de usar Microsoft 365 para iniciar sesión en Moodle.';
$string['ucp_connection_entraidlogin_active'] = 'Está utilizando la cuenta de Microsoft 365 "{$a}" para iniciar sesión en Moodle.';
$string['ucp_connection_linked'] = 'Vincular sus cuentas de Moodle y Microsoft 365';
$string['ucp_connection_linked_desc'] = 'Vincular sus cuentas de Moodle y Microsoft 365 le permite utilizar las características de Microsoft 365 en Moodle sin cambiar la forma en que inicia sesión en Moodle. <br />Al hacer clic en el enlace siguiente, se le enviará a Microsoft 365 para iniciar sesión una única vez, tras lo cual volverá aquí. Podrá utilizar todas las características de Microsoft 365 sin realizar ningún otro cambio en su cuenta de Moodle: iniciará sesión en Moodle como siempre.';
$string['ucp_connection_linked_active'] = 'Está vinculado a la cuenta de Microsoft 365 "{$a}".';
$string['ucp_connection_linked_start'] = 'Vincular su cuenta de Moodle a una cuenta de Microsoft 365.';
$string['ucp_connection_linked_migrate'] = 'Cambiar a cuenta vinculada.';
$string['ucp_connection_linked_stop'] = 'Desvincular su cuenta de Moodle de la cuenta de Microsoft 365.';
$string['ucp_connection_disconnected'] = 'No está conectado a Microsoft 365.';
$string['ucp_features'] = 'Características de Microsoft 365';
$string['ucp_features_intro'] = 'A continuación encontrará una lista de características que puede utilizar para mejorar Moodle con Microsoft 365.';
$string['ucp_features_intro_notconnected'] = ' Es posible que algunas no estén disponibles hasta que se conecte a Microsoft 365.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Para conectarse a Microsoft 365, deberá ponerse en contacto con el administrador del sitio.';
$string['ucp_index_calendar_title'] = 'Configuración de sincronización del calendario de Outlook';
$string['ucp_index_calendar_desc'] = 'Aquí puede configurar la sincronización entre sus calendarios de Moodle y Outlook. Puede exportar eventos del calendario de Moodle a Outlook y traer eventos de Outlook a Moodle.';
$string['ucp_index_connection_title'] = 'Configuración de la conexión de Microsoft 365';
$string['ucp_index_connection_desc'] = 'Configure cómo se conecta a Microsoft 365.';
$string['ucp_index_connectionstatus_title'] = 'Estado de la conexión';
$string['ucp_index_connectionstatus_login'] = 'Haga clic aquí para iniciar sesión.';
$string['ucp_index_connectionstatus_usinglogin'] = 'Actualmente está utilizando Microsoft 365 para iniciar sesión en Moodle.';
$string['ucp_index_connectionstatus_usinglinked'] = 'Está vinculado a una cuenta de Microsoft 365.';
$string['ucp_index_connectionstatus_manage'] = 'Gestionar conexión';
$string['ucp_index_connectionstatus_reconnect'] = 'Actualizar conexión';
$string['ucp_index_connectionstatus_connected'] = 'Actualmente, está conectado a Microsoft 365';
$string['ucp_index_connectionstatus_matched'] = 'Ha coincidido con el usuario de Microsoft 365 <small>"{$a}"</small>. Para completar esta conexión, haga clic en el enlace a continuación e inicie sesión en Microsoft 365.';
$string['ucp_index_connectionstatus_notconnected'] = 'Actualmente, no está conectado a Microsoft 365';
$string['ucp_notconnected'] = 'Conéctese a Microsoft 365 antes de entrar aquí.';
$string['ucp_status_enabled'] = 'Activa';
$string['ucp_status_disabled'] = 'No conectado';
$string['ucp_syncwith_title'] = 'Nombre del calendario de Outlook con el que sincronizar:';
$string['ucp_syncdir_title'] = 'Comportamiento de sincronización:';
$string['ucp_syncdir_out'] = 'De Moodle a Outlook';
$string['ucp_syncdir_in'] = 'De Outlook a Moodle';
$string['ucp_syncdir_both'] = 'Actualizar Outlook y Moodle';
$string['ucp_o365accountconnected'] = 'Esta cuenta de Microsoft 365 ya está conectada a otra cuenta de Moodle.';

// Tasks.
$string['task_calendarsyncin'] = 'Sincronizar eventos de Microsoft 365 en Moodle';
$string['task_coursesync'] = 'Sincronizar cursos de Moodle con Microsoft Teams';
$string['task_coursemembershipsync'] = 'Sincronizar propietarios y miembros de Microsoft Teams con cursos de Moodle';
$string['task_groupmembershipsync'] = 'Sincronizar propietarios y miembros de cursos de Moodle con grupos de Microsoft 365';
$string['task_sds_sync'] = 'Sincronizar con SDS';
$string['task_syncusers'] = 'Sincronizar usuarios desde Microsoft Entra ID';
$string['task_syncusersphotostimezones'] = 'Sincronizar fotos y zonas horarias de usuarios desde Microsoft Entra ID';
$string['task_calsyncautosubscribe'] = 'Habilitar automáticamente la sincronización del calendario para usuarios conectados';
$string['task_groupchannelsync'] = 'Crear canales de Teams para grupos de Moodle y sincronizar sus miembros';
$string['task_groupchannelsyncgroup'] = 'Crear el canal de Teams de un grupo de Moodle y sincronizar sus miembros';
$string['task_userenabledstatussync'] = 'Suspender/volver a habilitar/eliminar usuarios según su estado en Microsoft Entra ID';
$string['task_processmatchqueue'] = 'Procesar cola de coincidencias';
$string['task_notifysecretexpiry'] = 'Notificar al administrador del sitio la caducidad del secreto de la aplicación de Microsoft Entra ID';
$string['task_checkinvalidconfiglog'] = 'Comprobar y limpiar registros de configuración no válidos';
$string['task_usergroupmembershipsync'] = 'Sincronizar la pertenencia de usuarios a grupos de curso con Microsoft 365';
$string['task_processmatchqueue_err_museralreadymatched'] = 'El usuario de Moodle ya coincide con un usuario de Microsoft 365.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'El usuario de Moodle ya está conectado a Microsoft 365.';
$string['task_processmatchqueue_err_nomuser'] = 'No se encontró ningún usuario de Moodle con este nombre de usuario.';
$string['task_processmatchqueue_err_noo365user'] = 'No se encontró ningún usuario de Microsoft 365 con este nombre de usuario.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'El usuario de Microsoft 365 ya coincide con un usuario de Moodle.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'El usuario de Microsoft 365 ya está conectado a un usuario de Moodle.';

// Capabilities.
$string['o365:manageconnectionlink'] = 'Gestionar vinculación de conexión';
$string['o365:manageconnectionunlink'] = 'Gestionar desvinculación de conexión';
$string['o365:managecoursesync'] = 'Habilitar o deshabilitar la sincronización de Teams para cursos mediante servicios web';
$string['o365:viewgroups'] = 'Ver enlaces a servicios de Microsoft 365 en el bloque Microsoft en cursos con la sincronización habilitada';
$string['o365:managegroups'] = 'Ver enlaces a servicios de Microsoft 365 y opciones de gestión en el bloque Microsoft en cursos con la sincronización habilitada';
$string['o365:teammember'] = 'Miembro del equipo';
$string['o365:teamowner'] = 'Propietario del equipo';

// Cache Stores.
$string['cachedef_groups'] = 'Almacena datos de grupos de Microsoft 365';
$string['cachedef_jwks'] = 'Almacena claves JWKS de Microsoft';

// Web service errors.
$string['webservices_error_assignnotfound'] = 'No se pudo encontrar el registro de la tarea del módulo recibido.';
$string['webservices_error_invalidassignment'] = 'El ID de tarea recibido no se puede utilizar con esta función de servicio web.';
$string['webservices_error_modulenotfound'] = 'No se pudo encontrar el ID de módulo recibido.';
$string['webservices_error_sectionnotfound'] = 'No se pudo encontrar la sección del curso.';
$string['webservices_error_couldnotsavegrade'] = 'No se pudo guardar la calificación.';

// User sync task help text.
$string['help_user_create'] = 'Ayuda de Crear cuentas';
$string['help_user_create_help'] = 'Esto creará usuarios en Moodle a partir de cada usuario del Microsoft Entra ID vinculado. Solo se crearán cuentas para los usuarios que no tengan actualmente cuentas de Moodle. Las nuevas cuentas se configurarán con el método de autenticación OpenID Connect utilizando su perfil de Microsoft Entra ID, y podrán utilizar todas las características de integración de Microsoft 365/Moodle.';
$string['help_user_update'] = 'Ayuda de Actualizar todas las cuentas';
$string['help_user_update_help'] = 'Esto actualizará todos los usuarios de Moodle a partir de cada usuario del Microsoft Entra ID vinculado.';
$string['help_user_suspend'] = 'Ayuda de Suspender cuentas';
$string['help_user_suspend_help'] = 'Esto suspenderá a los usuarios de Moodle si están marcados como eliminados en Microsoft Entra ID.';
$string['help_user_delete'] = 'Ayuda de Eliminar cuentas';
$string['help_user_delete_help'] = 'Esto eliminará a los usuarios de Moodle si están marcados como eliminados en Microsoft Entra ID. Solo funcionará si la opción de suspender usuarios está habilitada. La cuenta de Moodle se eliminará y toda la información de usuario asociada se quitará de Moodle. ¡Tenga cuidado! Nota: De manera predeterminada, la eliminación se produce 30 días después de que se eliminó la cuenta en Microsoft Entra ID debido al período de retención de eliminación temporal de Entra ID (las cuentas se pueden restaurar durante este tiempo). Se puede configurar un retraso mayor entre la suspensión y la eliminación con el ajuste "Retraso antes de eliminar usuarios suspendidos".';
$string['help_user_reenable'] = 'Ayuda de Volver a habilitar cuentas';
$string['help_user_reenable_help'] = 'Esto volverá a habilitar las cuentas de Moodle suspendidas si Microsoft Entra ID las devuelve y se les permite iniciar sesión. Las cuentas a las que se les bloquea el inicio de sesión (deshabilitadas) en Microsoft Entra ID permanecerán suspendidas.';
$string['help_user_disabledsyncsuspend'] = 'Ayuda de Suspender cuentas al deshabilitarlas';
$string['help_user_disabledsyncsuspend_help'] = 'Esto suspenderá a los usuarios en Moodle si sus cuentas conectadas en Microsoft Entra ID tienen impedido el inicio de sesión (deshabilitadas), sin cambiar si se vuelven a habilitar automáticamente cuando su cuenta de Microsoft Entra ID se habilite de nuevo. Utilice la opción "Volver a habilitar cuentas en Moodle cuando se vuelvan a habilitar en Microsoft Entra ID" que aparece a continuación para controlarlo por separado.';
$string['help_user_groupsyncsuspend'] = 'Ayuda de Suspender cuentas que no están en el grupo de sincronización';
$string['help_user_groupsyncsuspend_help'] = 'Esto suspenderá a los usuarios en Moodle si siguen activos en Microsoft Entra ID pero no son miembros ni propietarios del grupo configurado en el ajuste "Filtro de grupo para la sincronización de usuarios". La comprobación se basa solo en la pertenencia actual: también suspende a los usuarios sincronizados existentes que nunca estuvieron en el grupo, no solo a los que lo abandonaron, así que revise su grupo antes de habilitar esta opción. Esta opción solo está disponible cuando se ha configurado un filtro de grupo para la sincronización de usuarios. Para evitar suspensiones masivas, no se suspende a nadie si el grupo está vacío o si no se pueden obtener sus miembros. Los usuarios suspendidos no se vuelven a habilitar mientras no estén en el grupo.';
$string['help_user_disabledsyncreenable'] = 'Ayuda de Volver a habilitar cuentas al habilitarlas';
$string['help_user_disabledsyncreenable_help'] = 'Esto quitará la suspensión de los usuarios suspendidos en Moodle si a sus cuentas conectadas en Microsoft Entra ID se les permite iniciar sesión (habilitadas) de nuevo.';
$string['help_user_suspendnolink'] = 'Ayuda de Suspender cuentas sin vínculo de Microsoft';
$string['help_user_suspendnolink_help'] = 'Normalmente, las opciones de suspender/deshabilitar anteriores solo actúan sobre las cuentas que tienen un registro de objeto de Microsoft Entra ID almacenado (creado cuando la cuenta se sincronizó o se conectó). Algunas cuentas de OpenID Connect no tienen ese registro; por ejemplo, se conectaron antes de que se configurara la API de Microsoft Graph, o el registro se eliminó mediante una desconexión o una acción de "borrar usuarios coincidentes". Esta opción hace que la tarea de estado también compruebe esas cuentas, haciendo coincidir el nombre de usuario de Moodle con el valor de la notificación de nombre de usuario vinculante configurada en Entra ID.

Las cuentas coincidentes que faltan en Entra ID, o que están deshabilitadas allí, se <strong>suspenden únicamente</strong>: nunca se eliminan (sin un ID de objeto almacenado no se puede comprobar el período de retención de eliminación temporal de Entra ID) y nunca se vuelven a habilitar automáticamente. Las cuentas de invitado se omiten.

Esta opción solo funciona cuando la notificación de nombre de usuario vinculante de OpenID Connect está establecida en un campo específico que se puede consultar en Entra ID: "upn", "oid", "email" o "samaccountname". Con "auto" (donde la notificación efectiva se elige en cada inicio de sesión y puede diferir entre usuarios) o cualquier otra notificación, el nombre de usuario de Moodle no se puede hacer coincidir de forma fiable con una única cuenta, y esta opción no hace nada.

Revise sus usuarios suspendidos tras la primera ejecución: una cuenta cambiada manualmente a este método de autenticación que nunca fue un usuario real de Entra ID será suspendida por esta opción.';
$string['help_user_match'] = 'Ayuda de Hacer coincidir cuentas';
$string['help_user_match_help'] = 'Esto examinará a cada usuario del Microsoft Entra ID vinculado e intentará hacerlo coincidir con un usuario de Moodle. Esta coincidencia se basa en el UPN de Microsoft Entra ID y el nombre de usuario de Moodle. Las coincidencias no distinguen mayúsculas de minúsculas e ignoran la parte del dominio del UPN de Microsoft Entra ID. Por ejemplo, "BoB.SmiTh" en Moodle coincidiría con "bob.smith@example.onmicrosoft.com". Los usuarios que coincidan tendrán sus cuentas de Moodle y de Microsoft Entra ID conectadas y podrán utilizar todas las características de integración de Microsoft 365 y Moodle. El método de autenticación del usuario no cambiará a menos que se habilite el ajuste siguiente.';
$string['help_user_matchswitchauth'] = 'Ayuda de Cambiar cuentas coincidentes';
$string['help_user_matchswitchauth_help'] = 'Esto requiere que el ajuste "Hacer coincidir a los usuarios preexistentes de Moodle" anterior esté habilitado. Cuando se hace coincidir a un usuario, al habilitar este ajuste se cambia su método de autenticación a OpenID Connect. Entonces podrá iniciar sesión en Moodle con sus credenciales de Microsoft 365. Nota: Asegúrese de que el complemento de autenticación OpenID Connect esté habilitado si desea utilizar este ajuste. Advertencia: si un nombre de usuario de Moodle solo coincide con la parte del UPN de Microsoft Entra ID anterior al "@" (en lugar del UPN completo), el ajuste avanzado "Longitud mínima del nombre de usuario no exacto para cambiar a Microsoft 365" puede impedir que se cambie el método de autenticación de los usuarios con nombres de usuario cortos.';
$string['help_user_appassign'] = 'Ayuda de Asignar usuarios a la aplicación';
$string['help_user_appassign_help'] = 'Esto hará que todas las cuentas de Microsoft Entra ID con cuentas de Moodle coincidentes se asignen a la aplicación de Microsoft Entra ID creada para esta instalación de Moodle, si aún no están asignadas.';
$string['help_user_photosync'] = 'Ayuda de Sincronizar fotos de perfil de Microsoft 365 (cron)';
$string['help_user_photosync_help'] = 'Esto hará que las fotos de perfil de Moodle de todos los usuarios se sincronicen con sus fotos de perfil de Microsoft 365.';
$string['help_user_photosynconlogin'] = 'Ayuda de Sincronizar fotos de perfil de Microsoft 365 (inicio de sesión)';
$string['help_user_photosynconlogin_help'] = 'Esto hará que la foto de perfil de Moodle de un usuario se sincronice con su foto de perfil de Microsoft 365 cuando ese usuario inicie sesión. Tenga en cuenta que esto requiere que el usuario visite una página de Moodle que contenga el bloque Microsoft.';
$string['help_user_nodelta'] = 'Ayuda de Realizar una sincronización completa';
$string['help_user_nodelta_help'] = 'De manera predeterminada, la sincronización de usuarios solo sincroniza los cambios de Microsoft Entra ID desde la última vez que se ejecutó la sincronización. Al marcar esta opción se forzará una sincronización completa de usuarios cada vez.';
$string['help_user_emailsync'] = 'Ayuda de Sincronizar nombres de usuario de Microsoft Entra ID con correos electrónicos de Moodle';
$string['help_user_emailsync_help'] = 'Al habilitar esta opción, los nombres de usuario de Microsoft Entra ID se harán coincidir con los correos electrónicos de Moodle, en lugar del comportamiento predeterminado, que es hacerlos coincidir con los nombres de usuario de Moodle.';
$string['help_user_tzsync'] = 'Ayuda de Sincronizar zona horaria de Outlook (cron)';
$string['help_user_tzsync_help'] = 'Esto hará que la zona horaria de Moodle de todos los usuarios se sincronice con su preferencia de zona horaria de Outlook.';
$string['help_user_tzsynconlogin'] = 'Ayuda de Sincronizar zona horaria de Outlook (inicio de sesión)';
$string['help_user_tzsynconlogin_help'] = 'Esto hará que la zona horaria de Moodle de un usuario se sincronice con su preferencia de zona horaria de Outlook. Tenga en cuenta que esto requiere que el usuario visite una página de Moodle que contenga el bloque Microsoft.';
$string['help_user_guestsync'] = 'Ayuda de Sincronizar usuarios invitados';
$string['help_user_guestsync_help'] = 'Si está habilitado, los usuarios invitados de Microsoft Entra ID se sincronizarán con Moodle en la tarea de sincronización de usuarios.';

// Cohort sync feature.
$string['cohortsync_title'] = 'Sincronización de cohortes';
$string['cohortsync_taskname'] = 'Sincronización de cohortes';
$string['cohortsync_mappingadded'] = 'La nueva conexión se agregó correctamente';
$string['cohortsync_mappingdeleted'] = 'La conexión se eliminó correctamente';
$string['cohortsync_addmapping'] = 'Agregar conexión';
$string['cohortsync_deletemapping'] = 'Eliminar conexión';
$string['cohortsync_desc'] = 'Esta página permite la sincronización unidireccional de grupos de Microsoft 365 a cohortes de Moodle en el contexto del sistema. Al agregar una nueva conexión se iniciará el proceso de sincronización: los usuarios del grupo de Microsoft 365 seleccionado que estén conectados con Microsoft se agregarán a la cohorte de Moodle seleccionada.';
$string['cohortsync_tabledesc'] = 'Conexiones actuales entre grupos de Microsoft 365 y cohortes de Moodle';
$string['cohortsync_typetosearch'] = 'Escriba para buscar un grupo de Microsoft 365';
$string['cohortsync_typetosearch_cohort'] = 'Escriba para buscar una cohorte de Moodle';
$string['cohortsync_emptymatchings'] = 'No se encontraron conexiones';
$string['cohortsync_select_cohort'] = 'Cohorte de Moodle';
$string['cohortsync_select_group'] = 'Grupo de Microsoft 365';
$string['cohortsync_tablehead_group'] = 'Grupo de Microsoft 365';
$string['cohortsync_tablehead_cohort'] = 'Cohorte de Moodle';
$string['cohortsync_tablehead_actions'] = 'Acciones';
$string['cohortsync_search'] = 'Buscar';
$string['cohortsync_load_more'] = 'Cargar más...';
$string['cohortsync_no_groups_found'] = 'No se encontraron grupos de Microsoft 365 para "{$a}"';
$string['cohortsync_no_cohorts_found'] = 'No se encontraron cohortes de Moodle para "{$a}"';
$string['cohortsync_error_no_group'] = 'Seleccione un grupo de Microsoft 365.';
$string['cohortsync_error_no_cohort'] = 'Seleccione una cohorte de Moodle.';
$string['cohortsync_mappingfailed'] = 'Error al agregar la conexión entre cohorte y grupo. Posibles motivos: el grupo o la cohorte no existe, el grupo ya está conectado a otra cohorte, o el grupo ya está conectado a esta cohorte.';
$string['cohortsync_connectionnotfound'] = 'Solicitud no válida: no se encontró la conexión.';
$string['cohortsync_connectionnotcohortsync'] = 'Solicitud no válida: el tipo de conexión no coincide.';
$string['cohortsync_unifiedapierror'] = 'Error al obtener la lista de grupos de Microsoft.';

// Course request.
$string['courserequest_teams'] = 'Equipo de Microsoft';
$string['courserequest_teams_help'] = 'Seleccione el equipo de Microsoft que se conectará al curso. Los propietarios y miembros existentes del equipo se matricularán en el curso creado una vez que se apruebe la solicitud de curso.';
$string['courserequest_emptyteams'] = 'No hay equipos de Microsoft Teams disponibles';
$string['courserequest_title'] = 'Solicitar curso desde Teams';
$string['courserequest_updatecourserequeststatus_taskname'] = 'Actualizar el estado de la solicitud de curso';
$string['courserequest_customrequestnote'] = '
| Esta solicitud se realiza desde la página de solicitud de cursos de Microsoft Teams y se conectará al equipo: "{$a->name}" con la URL {$a->url} al aprobarse.';
$string['courserequest_graphapi_disabled'] = 'La conexión con Microsoft Teams no está disponible. Póngase en contacto con el administrador del sitio.';
$string['courserequest_invalid_team'] = 'Se utilizó un equipo no válido en la solicitud de curso.';
$string['courserequest_duplicate'] = 'Ya existe una solicitud de curso pendiente o aprobada del mismo equipo.';

// Teams page.
$string['teams_no_course'] = 'No tiene ningún curso que agregar.';
$string['tab_name'] = 'Nombre de la pestaña';
$string['sso_login'] = 'Iniciar sesión en Microsoft 365';
$string['other_login'] = 'Iniciar sesión manualmente';
$string['course_selector_label'] = 'Seleccionar curso existente';

// Notifications to site admin about Microsoft Entra ID app secret.
$string['notification_subject_secret_expired'] = 'Acción requerida: el secreto de la aplicación de Microsoft Entra ID ha caducado';
$string['notification_content_secret_expired'] = 'Estimado administrador del sitio:

El secreto de la aplicación de Microsoft Entra ID utilizado en su integración de Moodle y Microsoft 365 ha caducado.
Cree un nuevo secreto en Microsoft Entra ID y actualícelo en la configuración de la integración para restablecer la integración.';
$string['notification_subject_secret_almost_expired'] = 'Acción requerida: el secreto de la aplicación de Microsoft Entra ID caducará pronto';
$string['notification_content_secret_almost_expired'] = 'Estimado administrador del sitio:

El secreto de la aplicación de Microsoft Entra ID utilizado en su integración de Moodle y Microsoft 365 caducará en {$a}.
Cree un nuevo secreto en Microsoft Entra ID y actualícelo en la configuración de la integración para evitar interrupciones en la integración.';
$string['notification_days_less_than_one_day'] = 'menos de 1 día';
$string['notification_days_one_day'] = '1 día';
$string['notification_days_days'] = '{$a} días';
$string['notification_subject_invalid_secret'] = 'Acción requerida: se encontró un secreto de aplicación de Microsoft Entra ID no válido';
$string['notification_content_invalid_secret'] = 'Estimado administrador del sitio:

El secreto de la aplicación de Microsoft Entra ID utilizado en su integración de Moodle y Microsoft 365 parece no ser válido. Esto puede deberse a que el secreto haya caducado o se haya eliminado.
Revise el secreto para asegurarse de que la integración funcione como se espera.';

// Async operations.
$string['teamsasyncfailed'] = 'Falló la operación asíncrona de creación del equipo: {$a}';
$string['unknownasyncstate'] = 'Estado de operación asíncrona desconocido: {$a}';

// Template ID validation.
$string['error_template_id_empty'] = 'El ID de plantilla no puede estar vacío.';
$string['error_not_connected'] = 'No está conectado a Microsoft 365. Configure primero la integración con Microsoft 365.';
$string['error_graph_client_not_available'] = 'No se puede conectar a la API de Microsoft Graph. Compruebe la configuración de su integración con Microsoft 365.';
$string['success_template_id_valid'] = '✓ El ID de plantilla "{$a}" es válido y accesible.';
$string['error_template_id_not_found'] = '✗ No se encontró el ID de plantilla "{$a}". Verifique el ID de plantilla en el Centro de administración de Teams.';
$string['error_template_validation_failed'] = '✗ Falló la validación de la plantilla: {$a}';
$string['error_template_validation_error'] = '✗ Se produjo un error al validar la plantilla. Inténtelo de nuevo o póngase en contacto con su administrador.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
