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
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'OpenID Connect';

// Configuration pages.
$string['settings_pageheading'] = 'Configuración de {$a}';
$string['settings_page_other_settings'] = 'Otras opciones';
$string['settings_page_application'] = 'IdP y autenticación';
$string['settings_page_application_wizard'] = 'Asistente de configuración de la aplicación';
$string['settings_page_binding_username_claim'] = 'Reclamación de nombre de usuario de vinculación';
$string['settings_page_change_binding_username_claim_tool'] = 'Herramienta para cambiar la reclamación de nombre de usuario de vinculación';
$string['settings_page_cleanup_oidc_tokens'] = 'Limpiar tokens de OpenID Connect';
$string['settings_page_clear_user_tokens'] = 'Borrar tokens de usuario';
$string['settings_page_field_mapping'] = 'Asignaciones de campos';
$string['heading_additional_options'] = 'Opciones adicionales';
$string['heading_additional_options_desc'] = '';
$string['heading_stateredirect'] = 'Página de error del estado de inicio de sesión';
$string['heading_stateredirect_desc'] = 'De forma predeterminada, si un usuario tarda demasiado en completar el inicio de sesión en el proveedor de identidad (por ejemplo, mientras aprueba una solicitud de autenticación multifactor) y el estado de inicio de sesión almacenado ya se ha limpiado, Moodle muestra su página de error genérica. Los ajustes siguientes le permiten ampliar el tiempo durante el que se conserva el estado de inicio de sesión y mostrar un mensaje más amigable y personalizable en lugar de la página de error genérica, redirigiendo automáticamente al usuario a la página de inicio de sesión.';
$string['heading_user_restrictions'] = 'Restricciones de usuario';
$string['heading_user_restrictions_desc'] = '';
$string['heading_sign_out'] = 'Integración del cierre de sesión';
$string['heading_sign_out_desc'] = '';
$string['heading_display'] = 'Visualización';
$string['heading_display_desc'] = '';
$string['heading_debugging'] = 'Depuración';
$string['heading_debugging_desc'] = '';
$string['heading_tools'] = 'Herramientas';
$string['microsoftcloud'] = 'Nube de Microsoft';
$string['microsoftcloud_help'] = 'Seleccione la nube de Microsoft a la que pertenece su inquilino de Microsoft Entra. Se aplica a los tipos de IdP Microsoft Entra ID y Microsoft identity platform.<br/>
Seleccione "Microsoft 365 operado por 21Vianet (China)" si su organización usa Microsoft 365 proporcionado por 21Vianet. En ese caso, las solicitudes realizadas por los complementos usan el servicio de inicio de sesión y los puntos de conexión de Microsoft Graph de esa nube, y los valores predeterminados de los puntos de conexión y del recurso que aparecen a continuación se ajustan a ella. Los valores ya guardados de los puntos de conexión, el recurso y el punto de conexión de cierre de sesión no se modifican, así que actualícelos si siguen configurados con los puntos de conexión de la nube global.';
$string['microsoftcloud_global'] = 'Microsoft 365 (global)';
$string['microsoftcloud_china'] = 'Microsoft 365 operado por 21Vianet (China)';
$string['idptype'] = 'Tipo de proveedor de identidad (IdP)';
$string['idptype_help'] = 'Actualmente se admiten tres tipos de IdP:
<ul>
<li><b>Microsoft Entra ID (v1.0)</b>: Microsoft Entra ID con puntos de conexión de oauth2 v1.0, p. ej. https://login.microsoftonline.com/organizations/oauth2/authorize.</li>
<li><b>Microsoft identity platform (v2.0)</b>: Microsoft Entra ID con puntos de conexión de oauth2 v2.0, p. ej. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize.</li>
<li><b>Otro</b>: cualquier IdP que no sea de Microsoft.</li>
</ul>
Las diferencias entre las opciones <b>Microsoft Entra ID (v1.0)</b> y <b>Microsoft identity platform (v2.0)</b> se pueden consultar en <a href="https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison">https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison</a>.<br/>
Cabe destacar que, al usar el IdP <b>Microsoft identity platform (v2.0)</b>, la aplicación configurada puede usar un <b>certificado</b> además de un <b>secreto</b> para la autenticación.<br/>
Los puntos de conexión de autorización y de token deben configurarse de acuerdo con el tipo de IdP configurado.';
$string['idp_type_not_connected'] = 'No conectado';
$string['idp_type_microsoft_entra_id'] = 'Microsoft Entra ID (v1.0)';
$string['idp_type_microsoft_identity_platform'] = 'Microsoft identity platform (v2.0)';
$string['idp_type_other'] = 'Otro';
$string['settings_application_wizard_desc'] = 'Para configurar estos ajustes mediante un formulario guiado con instrucciones paso a paso y validación de datos, use el <a href="{$a}">Asistente de configuración de la aplicación</a>.';
$string['authendpoint'] = 'Punto de conexión de autorización';
$string['authendpoint_help'] = 'La URI del punto de conexión de autorización de su IdP que se va a usar.<br/>
Tenga en cuenta que, si el sitio se va a configurar para permitir el acceso a usuarios de otros inquilinos, no se puede usar un punto de conexión de autorización específico del inquilino.';
$string['clientid'] = 'ID de la aplicación';
$string['clientid_help'] = 'El ID de aplicación / cliente registrado en el IdP.';
$string['clientauthmethod'] = 'Método de autenticación del cliente';
$string['clientauthmethod_help'] = '<ul>
<li>Los IdP de todos los tipos pueden usar el método de autenticación "<b>Secreto</b>".</li>
<li>Los IdP de tipo <b>Microsoft identity platform (v2.0)</b> pueden usar además el método de autenticación <b>Certificado</b>.</li>
</ul>';
$string['auth_method_secret'] = 'Secreto';
$string['auth_method_certificate'] = 'Certificado';
$string['clientsecret'] = 'Secreto de cliente';
$string['clientsecret_help'] = 'Al usar el método de autenticación <b>secreto</b>, este es el secreto de cliente del IdP. En algunos proveedores también se denomina clave.';
$string['clientprivatekey'] = 'Clave privada del certificado de cliente';
$string['clientprivatekey_help'] = 'Al usar el método de autenticación <b>certificado</b> y el origen de certificado <b>Texto sin formato</b>, esta es la clave privada del certificado que se usa para autenticarse con el IdP.';
$string['clientcert'] = 'Clave pública del certificado de cliente';
$string['clientcert_help'] = 'Al usar el método de autenticación <b>certificado</b> y el origen de certificado <b>Texto sin formato</b>, esta es la clave pública, o certificado, que se usa para autenticarse con el IdP.';
$string['clientcertsource'] = 'Origen del certificado';
$string['clientcertsource_help'] = 'Al usar el método de autenticación <b>certificado</b>, define de dónde se obtiene el certificado.
<ul>
<li>El origen <b>Texto sin formato</b> requiere que el contenido de los archivos del certificado y de la clave privada se configure en los ajustes de área de texto siguientes.</li>
<li>El origen <b>Nombre de archivo</b> requiere que los archivos del certificado y de la clave privada existan en una carpeta <b>microsoft_certs</b> dentro de la carpeta de datos de Moodle.</li>
</ul>';
$string['cert_source_text'] = 'Texto sin formato';
$string['cert_source_path'] = 'Nombre de archivo';
$string['clientprivatekeyfile'] = 'Nombre de archivo de la clave privada del certificado de cliente';
$string['clientprivatekeyfile_help'] = 'Al usar el método de autenticación <b>certificado</b> y el origen de certificado <b>Nombre de archivo</b>, este es el nombre del archivo de la clave privada que se usa para autenticarse con el IdP. El archivo debe estar en una carpeta <b>microsoft_certs</b> dentro de la carpeta de datos de Moodle.';
$string['clientcertfile'] = 'Nombre de archivo de la clave pública del certificado de cliente';
$string['clientcertfile_help'] = 'Al usar el método de autenticación <b>certificado</b> y el origen de certificado <b>Nombre de archivo</b>, este es el nombre del archivo de la clave pública, o certificado, que se usa para autenticarse con el IdP. El archivo debe estar en una carpeta <b>microsoft_certs</b> dentro de la carpeta de datos de Moodle.';
$string['clientcertpassphrase'] = 'Frase de contraseña del certificado de cliente';
$string['clientcertpassphrase_help'] = 'Si la clave privada del certificado de cliente está cifrada, esta es la frase de contraseña para descifrarla.';
$string['change_client_secret'] = 'Cambiar el secreto de cliente';
$string['change_client_secret_desc'] = 'Marque esta casilla para actualizar el secreto de cliente. Por seguridad, los secretos existentes se ocultan y solo se muestran los 2 primeros caracteres.';
$string['change_cert_passphrase'] = 'Cambiar la frase de contraseña del certificado';
$string['change_cert_passphrase_desc'] = 'Marque esta casilla para actualizar la frase de contraseña del certificado. Por seguridad, las frases de contraseña existentes se ocultan y solo se muestran los 2 primeros caracteres.';
$string['cfg_usepkce_key'] = 'Usar PKCE';
$string['cfg_usepkce_desc'] = 'Al usar el flujo de inicio de sesión <b>Código de autorización</b>, envía un "code_challenge" PKCE (RFC 7636) con el método S256 en la solicitud de autorización, y el "code_verifier" correspondiente al canjear el código de autorización. Microsoft Entra ID lo admite. Para otros proveedores, actívelo solo si su proveedor admite PKCE, ya que algunos proveedores rechazan las solicitudes de autorización con parámetros que no reconocen.';
$string['cfg_domainhint_key'] = 'Sugerencia de dominio';
$string['cfg_domainhint_desc'] = 'Al usar el flujo de inicio de sesión <b>Código de autorización</b>, pasa este valor como parámetro "domain_hint". Algunos IdP de OpenID Connect usan "domain_hint" para facilitar el proceso de inicio de sesión a los usuarios. Consulte con su proveedor si admite este parámetro.';
$string['cfg_forceselectaccount_key'] = 'Mostrar siempre la selección de cuenta';
$string['cfg_forceselectaccount_desc'] = 'Si está activado, siempre se pide a los usuarios que elijan con qué cuenta iniciar sesión, en lugar de iniciar sesión automáticamente con la cuenta activa en su navegador. Es útil cuando los usuarios tienen varias cuentas, por ejemplo una de estudiante y otra de administrador.<br/>
El modo de inicio de sesión silencioso tiene prioridad: mientras está activado, no se fuerza la selección de cuenta al iniciar sesión de forma silenciosa.';
$string['cfg_forceredirect_key'] = 'Forzar redirección';
$string['cfg_forceredirect_desc'] = 'Si está activado, se omitirá la página de inicio de sesión y se redirigirá a la página de OpenID Connect. Se puede evitar con el parámetro de URL ?noredirect=1';
$string['cfg_stateexpiry_key'] = 'Caducidad del estado de inicio de sesión (minutos)';
$string['cfg_stateexpiry_desc'] = 'Tiempo durante el que se conserva un registro de estado de inicio de sesión antes de que la tarea programada de limpieza lo elimine. Auméntelo si los usuarios suelen tardar más que esto en completar el inicio de sesión en el proveedor de identidad (por ejemplo, debido a solicitudes de autenticación multifactor).';
$string['error_stateexpiry_min'] = 'La caducidad del estado de inicio de sesión debe ser de al menos 1 minuto. Un valor de cero o menos haría que fallaran los inicios de sesión que estén en curso.';
$string['cfg_stateredirect_enabled_key'] = 'Mostrar página de error amigable';
$string['cfg_stateredirect_enabled_desc'] = 'Si está activado, a un usuario que tarde demasiado en completar el inicio de sesión en el proveedor de identidad (de modo que el estado de inicio de sesión almacenado ya se haya limpiado) se le muestra el mensaje personalizable siguiente y se le redirige automáticamente a la página de inicio de sesión, en lugar de mostrarle la página de error genérica de Moodle.';
$string['cfg_stateredirect_message_key'] = 'Mensaje';
$string['cfg_stateredirect_message_desc'] = 'El mensaje que se mostrará al usuario en la página de error amigable.';
$string['cfg_stateredirect_message_default'] = 'Se ha producido un problema al iniciar su sesión. Lo más probable es que el inicio de sesión haya tardado demasiado en completarse (por ejemplo, mientras aprobaba una solicitud de autenticación multifactor). Se le redirigirá automáticamente a la página de inicio de sesión para que pueda volver a intentarlo.';
$string['cfg_stateredirect_delay_key'] = 'Retraso de la redirección (segundos)';
$string['cfg_stateredirect_delay_desc'] = 'El número de segundos durante los que se muestra el mensaje anterior antes de redirigir automáticamente al usuario a la página de inicio de sesión.';
$string['cfg_set_pix_key'] = 'Mostrar icono en la página de inicio de sesión';
$string['cfg_set_pix_desc'] = 'Si está activado, muestra un icono junto al nombre del proveedor en la página de inicio de sesión.';
$string['cfg_icon_key'] = 'Icono';
$string['cfg_icon_desc'] = 'Un icono para mostrar junto al nombre del proveedor en la página de inicio de sesión.';
$string['cfg_iconalt_o365'] = 'Icono de Office 365';
$string['cfg_iconalt_microsoft365'] = 'Logotipo de Microsoft 365';
$string['cfg_iconalt_openid'] = 'Icono de OpenID';
$string['cfg_iconalt_keycloak'] = 'Icono de Keycloak';
$string['cfg_customicon_key'] = 'Icono personalizado';
$string['cfg_customicon_desc'] = 'Si desea utilizar su propio icono, cárguelo aquí. Esto anula cualquier icono que haya elegido arriba. <br /><br /><b>Notas sobre el uso de iconos personalizados:</b><ul><li>El archivo subido no se redimensiona. Se mostrará con un tamaño fijo de 24x24 píxeles en la página de inicio de sesión y su navegador lo escalará para que encaje, por lo que le recomendamos subir una imagen cuadrada para evitar distorsiones.</li><li>Si subió un icono personalizado y desea volver a alguno de los iconos predefinidos, haga clic en el icono personalizado en el cuadro de arriba, luego haga clic en "Borrar", luego en "OK" y luego en "Guardar cambios" en la parte inferior de este formulario. El icono predefinido seleccionado aparecerá ahora en la página de inicio de sesión de Moodle.</li></ul>';
$string['cfg_debugmode_key'] = 'Registrar mensajes de depuración';
$string['cfg_debugmode_desc'] = 'Si está habilitado, se registrará información en el registro de Moodle que puede ayudarlo a identificar problemas.';
$string['cfg_silentloginmode_key'] = 'Modo de inicio de sesión silencioso';
$string['cfg_silentloginmode_desc'] = 'Si está activado, Moodle intentará usar la sesión activa de un usuario autenticado en el punto de conexión de autorización configurado para iniciar su sesión.<br/>
Para usar esta función se requieren las siguientes configuraciones:
<ul>
<li><b>Forzar a los usuarios a iniciar sesión</b> (forcelogin) en la <a href="{$a}" target="_blank">sección Políticas del sitio</a> está activado.</li>
<li>El ajuste <b>Forzar redirección</b> (auth_oidc/forceredirect) anterior está activado.</li>
</ul>
Para evitar que Moodle intente usar cuentas personales o cuentas de otros inquilinos para iniciar sesión, también se recomienda usar puntos de conexión específicos del inquilino en lugar de genéricos que usen rutas como "common" u "organizations".<br/>
<br/>
Para los IdP de Microsoft, la experiencia del usuario es la siguiente:
<ul>
<li>Si no se encuentra ninguna sesión de usuario activa, se mostrará la página de inicio de sesión de Moodle.</li>
<li>Si solo se encuentra una sesión de usuario activa y el usuario tiene acceso a la aplicación de Entra ID (es decir, el usuario es del mismo inquilino o es un usuario invitado del inquilino), el usuario iniciará sesión en Moodle automáticamente mediante SSO.</li>
<li>Si solo se encuentra una sesión de usuario activa, pero el usuario no tiene acceso a la aplicación de Entra ID (p. ej. el usuario es de otro inquilino, o la aplicación requiere asignación de usuarios y el usuario no está asignado), se mostrará la página de inicio de sesión de Moodle.</li>
<li>Si hay varias sesiones de usuario activas con acceso a la aplicación de Entra ID, se mostrará una página para que el usuario seleccione la cuenta con la que iniciar sesión.</li>
</ul>';
$string['oidcresource'] = 'Recurso';
$string['oidcresource_help'] = 'El recurso de OpenID Connect para el que se envía la solicitud.<br/>
<b>Nota:</b> este parámetro no se admite en el tipo de IdP <b>Microsoft identity platform (v2.0)</b>.';
$string['oidcscope'] = 'Ámbito';
$string['oidcscope_help'] = 'El ámbito (scope) de OIDC que se va a usar.';
$string['customclaims'] = 'Reclamaciones personalizadas';
$string['customclaims_help'] = 'Lista separada por espacios de nombres de reclamaciones (claims) personalizadas de los tokens de su proveedor de identidad.<br/>
<b>Importante:</b>
<ul>
<li>Las reclamaciones deben existir en la configuración de tokens de su IdP (p. ej., mapeadores de protocolo de Keycloak, reclamaciones opcionales/personalizadas de Microsoft Entra ID)</li>
<li>Si una reclamación no existe en el token, la asignación de campos la omitirá sin avisar: no se mostrará ningún error</li>
<li>Los nombres de las reclamaciones distinguen entre mayúsculas y minúsculas y solo pueden contener caracteres alfanuméricos, guiones y guiones bajos</li>
<li>El nombre de una reclamación no puede ser un nombre reservado, como una reclamación estándar de JWT/OpenID Connect (p. ej., <code>sub</code>, <code>email</code>), una específica de Microsoft Entra ID (p. ej., <code>oid</code>, <code>upn</code>) o de Keycloak (p. ej., <code>realm_access</code>, <code>resource_access</code>), ni una opción de asignación de campos existente</li>
<li>Se permiten la reclamación <code>roles</code> (roles de aplicación en los tokens de Microsoft Entra ID) y la reclamación <code>groups</code> (ID de grupos). Aparecen como "roles (token claim)" y "groups (token claim)" en la asignación de campos, separadas de las opciones integradas "Roles" y "Grupos", que asignan los roles de directorio de Microsoft Entra y los nombres de grupos de Microsoft Graph. Las reclamaciones que contienen una lista de valores se almacenan como una lista separada por comas</li>
<li>Ejemplos: <code>employee_type badge_number costCenter custom_role</code></li>
<li>Al iniciar sesión, las reclamaciones personalizadas siempre se leen del token, se use o no también Microsoft Graph. Durante la tarea programada de sincronización de usuarios no hay ningún token de usuario del que leer, por lo que una reclamación personalizada solo se sincroniza si su nombre coincide también con una propiedad de usuario seleccionable de Microsoft Graph, como un atributo de extensión de directorio (p. ej., <code>extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode</code>). Una reclamación personalizada que Microsoft Graph rechace se omite en esa ejecución de la sincronización, con una advertencia en el registro de la tarea, en lugar de hacer fallar toda la sincronización.</li>
</ul>';
$string['secretexpiryrecipients'] = 'Destinatarios de las notificaciones de caducidad del secreto';
$string['secretexpiryrecipients_help'] = 'Una lista separada por comas de direcciones de correo electrónico a las que enviar las notificaciones de caducidad del secreto.<br/>
Si no se introduce ninguna dirección de correo electrónico, se notificará al administrador principal del sitio.<br/>
De forma predeterminada, las notificaciones se envían a diario desde cuatro semanas antes de la caducidad hasta que se renueva el secreto.';
$string['cfg_showbutton_key'] = 'Mostrar botón de inicio de sesión';
$string['cfg_showbutton_desc'] = 'Si está desactivado, el botón de inicio de sesión del proveedor no se muestra en la página de inicio de sesión. Los usuarios pueden seguir autenticándose mediante este proveedor accediendo directamente a su URL de inicio de sesión.';
$string['cfg_opname_key'] = 'Nombre visible del proveedor';
$string['cfg_opname_desc'] = 'Es una etiqueta visible para el usuario final que identifica el tipo de credenciales que el usuario debe usar para iniciar sesión. Esta etiqueta se usa en todas las partes de este complemento visibles para el usuario para identificar a su proveedor.';
$string['cfg_redirecturi_key'] = 'URI de redireccionamiento';
$string['cfg_redirecturi_desc'] = 'Esta es la URI que debe registrarse como "URI de redireccionamiento". Su proveedor de identidad de OpenID Connect debería solicitarla al registrar Moodle como cliente. <br /><b>NOTA:</b> Debe introducirla en su IdP de OpenID Connect *exactamente* como aparece aquí. Cualquier diferencia impedirá los inicios de sesión mediante OpenID Connect.';
$string['tokenendpoint'] = 'Punto de conexión de token';
$string['tokenendpoint_help'] = 'La URI del punto de conexión de token de su IdP que se va a usar.<br/>
Tenga en cuenta que, si el sitio se va a configurar para permitir el acceso a usuarios de otros inquilinos, no se puede usar un punto de conexión de token específico del inquilino.';
$string['cfg_userrestrictions_key'] = 'Restricciones de usuario';
$string['cfg_userrestrictions_desc'] = 'Permitir iniciar sesión solo a los usuarios que cumplan ciertas restricciones. <br /><b>Cómo usar las restricciones de usuario: </b> <ul><li>Introduzca un patrón de <a href="https://en.wikipedia.org/wiki/Regular_expression">expresión regular</a> que coincida con los nombres de usuario de los usuarios que desea permitir.</li><li>Introduzca un patrón por línea</li><li>Si introduce varios patrones, se permitirá a un usuario si coincide con CUALQUIERA de ellos.</li><li>El carácter "/" debe escaparse con "\\".</li><li>Si no introduce ninguna restricción arriba, Moodle aceptará a todos los usuarios que puedan iniciar sesión en el IdP de OpenID Connect.</li><li>Cualquier usuario que no coincida con ninguno de los patrones introducidos no podrá iniciar sesión mediante OpenID Connect.</li></ul>';
$string['cfg_userrestrictionscasesensitive_key'] = 'Restricciones de usuario sensibles a mayúsculas y minúsculas';
$string['cfg_userrestrictionscasesensitive_desc'] = 'Controla si se usa la opción "/i" de las expresiones regulares en la comprobación de las restricciones de usuario.<br/>Si está activado, todas las comprobaciones de restricciones de usuario distinguirán entre mayúsculas y minúsculas. Tenga en cuenta que, si está desactivado, se ignorará cualquier patrón relativo a mayúsculas y minúsculas.';
$string['heading_dummy_email'] = 'Direcciones de correo electrónico de marcador de posición';
$string['heading_dummy_email_desc'] = 'Moodle requiere que todas las cuentas de usuario tengan una dirección de correo electrónico, pero las cuentas de Microsoft Entra ID no están obligadas a tenerla. Los ajustes siguientes permiten que Moodle genere una dirección de marcador de posición no entregable para los usuarios que no tengan una dirección de correo electrónico utilizable procedente del IdP, en lugar de dejar su dirección de correo electrónico en blanco.';
$string['cfg_generatedummyemail_key'] = 'Generar direcciones de correo electrónico de marcador de posición';
$string['cfg_generatedummyemail_desc'] = 'Si está activado, cuando un usuario no tenga dirección de correo electrónico ni un nombre principal de usuario utilizable con formato de correo electrónico procedente del IdP, Moodle le generará una dirección de correo electrónico de marcador de posición usando su nombre principal de usuario de Microsoft (o el ID de objeto, si no hay nombre principal de usuario disponible) y el dominio configurado a continuación, en lugar de dejar su dirección de correo electrónico en blanco. Esto se aplica tanto cuando el usuario inicia sesión como cuando la tarea de sincronización de usuarios lo crea.';
$string['cfg_dummyemaildomain_key'] = 'Dominio de correo electrónico de marcador de posición';
$string['cfg_dummyemaildomain_desc'] = 'El dominio que se usará al generar direcciones de correo electrónico de marcador de posición, por ejemplo "example.test". Use un dominio que no pueda recibir correo, para que las direcciones generadas nunca se confundan con una dirección real y entregable.';
$string['cfg_signoffintegration_key'] = 'Cierre de sesión único (de Moodle al IdP)';
$string['cfg_signoffintegration_desc'] = 'Si la opción está activada, cuando un usuario de Moodle conectado al IdP configurado cierre sesión en Moodle, la integración enviará una solicitud al punto de conexión de cierre de sesión indicado a continuación, intentando cerrar también la sesión del usuario en el IdP.<br/>
Tenga en cuenta que, para la integración con Microsoft Entra ID, la URL del sitio Moodle ({$a}) debe agregarse como URI de redireccionamiento en la aplicación de Microsoft Entra ID creada para la integración de Moodle y Microsoft 365.';
$string['cfg_logoutendpoint_key'] = 'Punto de conexión de cierre de sesión del IdP';
$string['cfg_logoutendpoint_desc'] = 'La URI del punto de conexión de cierre de sesión de su IdP que se va a usar.';
$string['cfg_frontchannellogouturl_key'] = 'URL de cierre de sesión de canal frontal';
$string['cfg_frontchannellogouturl_desc'] = 'Esta es la URL que su IdP debe invocar cuando intente cerrar la sesión de los usuarios en Moodle.<br/>
En Microsoft Entra ID / Microsoft identity platform, el ajuste se llama "Front-channel logout URL" y se puede configurar en la aplicación de Microsoft Entra ID.';
$string['cfg_field_mapping_desc'] = 'Los datos del perfil de usuario se pueden asignar desde el IdP de OpenID Connect a Moodle. Los campos remotos disponibles para asignar dependen en gran medida del tipo de IdP.<br/>
<ul>
<li>Algunos campos básicos del perfil están disponibles a partir de las reclamaciones del token de acceso y del token de ID en todos los tipos de IdP.</li>
<li>Si se configura un tipo de IdP de Microsoft (v1.0 o v2.0), se pueden obtener datos de perfil adicionales mediante llamadas a la API de Graph instalando y configurando el <a href="https://moodle.org/plugins/local_o365">complemento de integración con Microsoft 365 (local_o365)</a>.</li>
<li>Si la función de sincronización de perfiles de SDS está activada en el complemento local_o365, algunos campos del perfil se pueden sincronizar desde SDS a Moodle. Esto solo ocurre al ejecutar la tarea programada "Sincronizar con SDS", y no ocurre al ejecutar la tarea programada "Sincronizar usuarios desde Microsoft Entra ID" ni cuando un usuario inicia sesión.</li>
</ul>

Las reclamaciones disponibles en los tokens de ID y de acceso varían según el tipo de IdP, pero la mayoría de los IdP permiten cierto grado de personalización de las reclamaciones. A continuación se enlaza la documentación sobre los IdP de Microsoft:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Reclamaciones del token de acceso</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">Reclamaciones del token de ID</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Configuración de reclamaciones opcionales</a>: tenga en cuenta que "Email" es una reclamación opcional en el tipo de IdP Microsoft Entra ID (v1.0).</li>
</ul>';

$string['cfg_cleanupoidctokens_key'] = 'Limpiar tokens de OpenID Connect';
$string['cfg_cleanupoidctokens_desc'] = 'Si sus usuarios tienen problemas para iniciar sesión con su cuenta de Microsoft 365, pruebe a limpiar los tokens de OpenID Connect. Esto elimina los tokens huérfanos e incompletos que pueden causar errores. ADVERTENCIA: esto puede interrumpir los inicios de sesión en curso, por lo que es mejor hacerlo durante un período de inactividad.';
$string['settings_section_basic'] = 'Ajustes básicos';
$string['settings_section_authentication'] = 'Autenticación';
$string['settings_section_endpoints'] = 'Puntos de conexión';
$string['settings_section_other_params'] = 'Otros parámetros';
$string['settings_section_secret_expiry_notification'] = 'Notificación de caducidad del secreto';
$string['application_updated'] = 'Se han actualizado los ajustes de la aplicación de OpenID Connect.';
$string['application_updated_microsoft'] = 'Se ha actualizado el ajuste de la aplicación de OpenID Connect.<br/>
<span class="warning" style="color: red;">Un administrador de Microsoft Entra ID tendrá que volver a <b>Otorgar consentimiento del administrador</b> y <b>Verificar configuración</b> en la página de configuración de la integración con Microsoft 365 si se actualizan los ajustes "Tipo de proveedor de identidad (IdP)" o "Método de autenticación del cliente".</span>';
$string['application_updated_microsoft_notify'] = 'Se ha actualizado el ajuste de la aplicación de OpenID Connect.<br/>
<span class="warning" style="color: red;">Un administrador de Microsoft Entra ID tendrá que volver a <b>Otorgar consentimiento del administrador</b> y <b>Verificar configuración</b> en la <a href="{$a}">página de configuración de la integración con Microsoft 365</a> si se actualizan los ajustes "Tipo de proveedor de identidad (IdP)" o "Método de autenticación del cliente".</span>';
$string['application_not_changed'] = 'No se ha modificado el ajuste de la aplicación de OpenID Connect.';

$string['event_debug'] = 'Mensaje de depuración';

$string['task_cleanup_oidc_state_and_token'] = 'Limpiar el estado de OIDC y los tokens no válidos';
$string['task_cleanup_oidc_sid'] = 'Limpiar los registros de SID de OIDC';

$string['errorauthdisconnectemptypassword'] = 'La contraseña no puede estar vacía';
$string['errorauthdisconnectemptyusername'] = 'El nombre de usuario no puede estar vacío';
$string['errorauthdisconnectusernameexists'] = 'Ese nombre de usuario ya está en uso. Elija uno distinto.';
$string['errorauthdisconnectnewmethod'] = 'Usar método de inicio de sesión';
$string['errorauthdisconnectinvalidmethod'] = 'Se recibió un método de inicio de sesión no válido.';
$string['errorauthdisconnectifmanual'] = 'Si utiliza un método de inicio de sesión manual, introduzca las credenciales a continuación.';
$string['errorauthgeneral'] = 'Se ha producido un problema al iniciar su sesión. Póngase en contacto con su administrador para obtener ayuda.';
$string['errorauthinvalididtoken'] = 'Se recibió un id_token no válido.';
$string['errorauthloginfailednouser'] = 'Inicio de sesión no válido: ha iniciado sesión como "{$a}", pero no hay ninguna cuenta correspondiente en este sitio y no se pueden crear cuentas nuevas automáticamente. Póngase en contacto con el administrador del sitio para obtener ayuda. Si tiene más de una cuenta, seleccione Continuar para iniciar sesión con otra.';
$string['errorauthloginfaileddupemail'] = 'Inicio de sesión no válido: una cuenta existente en este Moodle tiene la misma dirección de correo electrónico que la cuenta que intenta crear, y el ajuste "Permitir cuentas con la misma dirección de correo" (allowaccountssameemail) está desactivado.';
$string['errorauthmfarequired'] = 'Microsoft requiere autenticación multifactor para completar su inicio de sesión, pero no se ha podido completar. Vuelva a intentarlo, o inicie sesión en Microsoft 365 en una nueva sesión del navegador y complete la solicitud de autenticación multifactor.';
$string['errorauthnoauthcode'] = 'No se recibió ningún código de autorización del servidor de identidad. Los registros de errores pueden contener más información.';
$string['errorauthnocredsandendpoints'] = 'Configure las credenciales de cliente y los puntos de conexión de OpenID Connect.';
$string['errorauthnoidtoken'] = 'No se recibió el id_token de OpenID Connect.';
$string['errorauthnoaccesstoken'] = 'No se recibió el token de acceso.';
$string['errorauthunknownstate'] = 'Estado desconocido.';
$string['errorauthuseralreadyconnected'] = 'Ya está conectado a un usuario distinto de OpenID Connect.';
$string['errorauthuserconnectedtodifferent'] = 'El usuario de OpenID Connect que se autenticó ya está conectado a un usuario de Moodle.';
$string['errorbadloginflow'] = 'Se especificó un tipo de autenticación no válido. Nota: si recibe este mensaje después de una instalación o actualización reciente, borre la caché de Moodle.';
$string['errorjwtbadpayload'] = 'No se pudo leer la carga útil del JWT.';
$string['errorjwtcouldnotreadheader'] = 'No se pudo leer el encabezado de JWT';
$string['errorjwtempty'] = 'Se recibió un JWT vacío o que no es cadena.';
$string['errorjwtinvalidheader'] = 'Encabezado de JWT no válido';
$string['errorjwtmalformed'] = 'Se recibió un JWT incorrecto.';
$string['errorjwtunsupportedalg'] = 'JWS Alg o JWE no compatible';
$string['erroroidcnotenabled'] = 'El complemento de autenticación de OpenID Connect no está habilitado.';
$string['errornodisconnectionauthmethod'] = 'No se puede desconectar porque no hay un complemento de autenticación habilitado para volver (el método de inicio de sesión anterior del usuario o el método de inicio de sesión manual).';
$string['erroroidcclientinvalidendpoint'] = 'Se recibió una URI de punto de conexión no válida.';
$string['erroroidcclientnocreds'] = 'Establezca las credenciales del cliente con setcreds';
$string['erroroidcclientnoauthendpoint'] = 'No se configuró el punto de conexión de autorización. Configúrelo con $this->setendpoints';
$string['erroroidcclientnotokenendpoint'] = 'No se configuró el punto de conexión de token. Configúrelo con $this->setendpoints';
$string['errorrestricted'] = 'Este sitio tiene restricciones sobre los usuarios que pueden iniciar sesión con OpenID Connect. Actualmente, estas restricciones le impiden completar este intento de inicio de sesión.';
$string['errorucpinvalidaction'] = 'Se recibió una acción no válida.';
$string['erroroidccall'] = 'Error en OpenID Connect. Revise los registros para obtener más información.';
$string['erroroidccall_message'] = 'Error en OpenID Connect: {$a}';
$string['errorinvalidredirect_message'] = 'La URL a la que intenta redirigir no existe.';
$string['errorinvalidcertificatesource'] = 'Origen de certificado no válido';
$string['error_invalid_client_authentication_method'] = 'Método de autenticación del cliente no válido';
$string['error_certificate_requires_identity_platform'] = 'La autenticación con certificado requiere el tipo de IdP «Microsoft identity platform (v2.0)».';
$string['error_empty_client_secret'] = 'El secreto de cliente no puede estar vacío al usar el método de autenticación "secreto"';
$string['error_empty_client_private_key'] = 'La clave privada del certificado de cliente no puede estar vacía al usar el método de autenticación "certificado"';
$string['error_empty_client_cert'] = 'La clave pública del certificado de cliente no puede estar vacía al usar el método de autenticación "certificado"';
$string['error_empty_client_private_key_file'] = 'El archivo de la clave privada del certificado de cliente no puede estar vacío al usar el método de autenticación "certificado"';
$string['error_empty_client_cert_file'] = 'El archivo de la clave pública del certificado de cliente no puede estar vacío al usar el método de autenticación "certificado"';
$string['error_endpoint_mismatch_auth_endpoint'] = 'El punto de conexión de autorización configurado no se corresponde con el tipo de IdP configurado. Para "Microsoft Entra ID (v1.0)" use un punto de conexión v1.0 (p. ej. https://login.microsoftonline.com/organizations/oauth2/authorize). Para "Microsoft identity platform (v2.0)" use un punto de conexión v2.0 (p. ej. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize).';
$string['error_endpoint_mismatch_token_endpoint'] = 'El punto de conexión de token configurado no se corresponde con el tipo de IdP configurado. Para "Microsoft Entra ID (v1.0)" use un punto de conexión v1.0 (p. ej. https://login.microsoftonline.com/organizations/oauth2/token). Para "Microsoft identity platform (v2.0)" use un punto de conexión v2.0 (p. ej. https://login.microsoftonline.com/organizations/oauth2/v2.0/token).';
$string['error_tenant_specific_endpoint_required'] = 'Al usar el tipo de IdP "Microsoft identity platform (v2.0)" y el método de autenticación "Certificado", se requiere un punto de conexión específico del inquilino (es decir, no common/organizations/consumers).';
$string['error_empty_oidcresource'] = 'El recurso no puede estar vacío al usar Microsoft Entra ID (v1.0) u otros tipos de IdP.';
$string['error_invalid_custom_claim'] = 'Nombre(s) de reclamación personalizada no válido(s): {$a}. Los nombres de reclamaciones personalizadas solo pueden contener caracteres alfanuméricos, guiones y guiones bajos, y no pueden ser un nombre de reclamación reservado (p. ej. una reclamación estándar de JWT/OpenID Connect, o una específica de Microsoft Entra ID o Keycloak) ni una opción de asignación de campos existente.';
$string['error_masked_secret_not_changed'] = 'Introduzca un nuevo valor o desmarque la casilla "Cambiar" para conservar el valor actual.';
$string['error_secretexpiryrecipients_invalid'] = 'Los siguientes destinatarios de las notificaciones de caducidad del secreto no son direcciones de correo electrónico válidas: {$a}';
$string['auth_settings_validation_error'] = 'Se han detectado ajustes de autenticación no válidos. Deben resolverse los siguientes problemas de configuración para que la autenticación funcione correctamente:';
$string['errorupnchangeisnotsupported'] = 'El UPN de su cuenta de Microsoft ha cambiado. Póngase en contacto con su administrador para que actualice su cuenta de Moodle.';
$string['erroruserwithusernamealreadyexists'] = 'Se ha producido un error al intentar cambiar el nombre de su cuenta de Moodle. Ya existe un usuario de Moodle con el nuevo nombre de usuario. Pida al administrador del sitio que lo resuelva primero.';
$string['error_no_response_available'] = 'No hay respuestas disponibles.';

$string['eventuserauthed'] = 'Usuario autorizado con OpenID Connect';
$string['eventusercreated'] = 'Usuario creado con OpenID Connect';
$string['eventuserconnected'] = 'Usuario conectado a OpenID Connect';
$string['eventuserloggedin'] = 'Usuario inició sesión con OpenID Connect';
$string['eventuserdisconnected'] = 'Usuario desconectado de OpenID Connect';
$string['eventuserrenameattempt'] = 'El complemento auth_oidc intentó cambiar el nombre de un usuario';

$string['oidc:manageconnection'] = 'Permitir la conexión y desconexión de OpenID Connect';
$string['oidc:manageconnectionconnect'] = 'Permitir la conexión de OpenID Connect';
$string['oidc:manageconnectiondisconnect'] = 'Permitir la desconexión de OpenID Connect';

$string['privacy:metadata:auth_oidc'] = 'Autenticación OpenID Connect';
$string['privacy:metadata:auth_oidc_prevlogin'] = 'Métodos de inicio de sesión anteriores para deshacer las conexiones con Microsoft 365';
$string['privacy:metadata:auth_oidc_prevlogin:userid'] = 'El ID del usuario de Moodle';
$string['privacy:metadata:auth_oidc_prevlogin:method'] = 'El método de inicio de sesión anterior';
$string['privacy:metadata:auth_oidc_prevlogin:password'] = 'El campo de contraseña (cifrada) anterior del usuario.';
$string['privacy:metadata:auth_oidc_token'] = 'Tokens de OpenID Connect';
$string['privacy:metadata:auth_oidc_token:oidcuniqid'] = 'El identificador único de usuario de OIDC.';
$string['privacy:metadata:auth_oidc_token:username'] = 'El nombre de usuario del usuario de Moodle';
$string['privacy:metadata:auth_oidc_token:userid'] = 'El ID de usuario del usuario de Moodle';
$string['privacy:metadata:auth_oidc_token:oidcusername'] = 'El nombre de usuario del usuario de OIDC';
$string['privacy:metadata:auth_oidc_token:useridentifier'] = 'El identificador de usuario del usuario de OIDC';
$string['privacy:metadata:auth_oidc_token:scope'] = 'El ámbito del token';
$string['privacy:metadata:auth_oidc_token:tokenresource'] = 'El recurso del token';
$string['privacy:metadata:auth_oidc_token:authcode'] = 'El código de autorización del token';
$string['privacy:metadata:auth_oidc_token:token'] = 'El token';
$string['privacy:metadata:auth_oidc_token:expiry'] = 'La caducidad del token';
$string['privacy:metadata:auth_oidc_token:refreshtoken'] = 'El token de actualización';
$string['privacy:metadata:auth_oidc_token:idtoken'] = 'El token de ID';
$string['privacy:metadata:auth_oidc_sid'] = 'Identificadores de sesión (sid) del IdP usados para encontrar los usuarios de Moodle conectados cuando el IdP inicia un cierre de sesión único (SLO)';
$string['privacy:metadata:auth_oidc_sid:userid'] = 'El ID del usuario de Moodle';
$string['privacy:metadata:auth_oidc_sid:sid'] = 'El identificador de sesión (sid) del IdP';
$string['privacy:metadata:auth_oidc_sid:timecreated'] = 'La hora en que se creó la asociación';
$string['privacy:metadata:auth_oidc_sid:sessionid'] = 'El ID de la sesión de Moodle activa en el momento en que se creó la asociación';
$string['privacy:metadata:auth_oidc_sid:iss'] = 'El emisor (reclamación iss) del id_token a partir del cual se creó la asociación';

// In the following strings, $a refers to a customizable name for the identity manager. For example, this could be
// "Microsoft 365", "OpenID Connect", etc.
$string['ucp_general_intro'] = 'Aquí puede administrar su conexión a {$a}. Si está habilitado, podrá utilizar su cuenta de {$a} para iniciar sesión en Moodle en lugar de un nombre de usuario y contraseña separados. Una vez conectado, ya no tendrá que recordar el nombre de usuario y la contraseña para Moodle, todos los inicios de sesión serán gestionados por {$a}.';
$string['ucp_login_start'] = 'Comenzar a usar {$a} para iniciar sesión en Moodle';
$string['ucp_login_start_desc'] = 'Esto cambiará su cuenta para usar {$a} para iniciar sesión en Moodle. Una vez habilitado, deberá iniciar sesión con sus credenciales de {$a} - su nombre de usuario y contraseña actuales de Moodle no funcionarán. Puede desconectar su cuenta en cualquier momento y volver a iniciar sesión normalmente.';
$string['ucp_login_stop'] = 'Dejar de usar {$a} para iniciar sesión en Moodle';
$string['ucp_login_stop_desc'] = 'Actualmente, está utilizando {$a} para iniciar sesión en Moodle. Si hace clic en "Dejar de usar {$a} para iniciar sesión en Moodle", su cuenta de Moodle se desconectará de {$a}. Ya no podrá iniciar sesión en Moodle con su cuenta de {$a}. Se le solicitará que cree un nombre de usuario y una contraseña, y a partir de ese momento podrá iniciar sesión en Moodle directamente.';
$string['ucp_login_status'] = 'El inicio de sesión de {$a} es:';
$string['ucp_status_enabled'] = 'Habilitado';
$string['ucp_status_disabled'] = 'Desactivado';
$string['ucp_disconnect_title'] = 'Desconexión de {$a}';
$string['ucp_disconnect_details'] = 'Esto desconectará su cuenta de Moodle de {$a}. Deberá crear un nombre de usuario y una contraseña para iniciar sesión en Moodle.';
$string['ucp_title'] = 'Administración de {$a}';
$string['ucp_o365accountconnected'] = 'Esta cuenta de Microsoft 365 ya está conectada a otra cuenta de Moodle.';

// Clean up OIDC tokens.
$string['cleanup_oidc_tokens'] = 'Limpiar tokens de OpenID Connect';
$string['unmatched'] = 'Sin correspondencia';
$string['delete_token'] = 'Eliminar token';
$string['mismatched'] = 'No coincidente';
$string['na'] = 'n/d';
$string['mismatched_details'] = 'El registro del token contiene el nombre de usuario "{$a->tokenusername}"; el usuario de Moodle correspondiente tiene el nombre de usuario "{$a->moodleusername}".';
$string['delete_token_and_reference'] = 'Eliminar token y referencia';
$string['table_token_id'] = 'ID del registro del token';
$string['table_oidc_username'] = 'Nombre de usuario de OIDC';
$string['table_oidc_unique_identifier'] = 'Identificador único de OIDC';
$string['table_token_unique_id'] = 'ID único de OIDC';
$string['table_matching_status'] = 'Estado de correspondencia';
$string['table_matching_details'] = 'Detalles';
$string['table_action'] = 'Acción';
$string['token_deleted'] = 'El token se eliminó correctamente';
$string['no_token_to_cleanup'] = 'No hay tokens de OIDC que limpiar.';

$string['errorusermatched'] = 'La cuenta de Microsoft 365 "{$a->entraidupn}" ya está asociada al usuario de Moodle "{$a->username}". Para completar la conexión, inicie sesión primero como ese usuario de Moodle y siga las instrucciones del bloque Microsoft.';

// User mapping options.
$string['update_oncreate_and_onlogin'] = 'Al crear y en cada inicio de sesión';
$string['update_oncreate_and_onlogin_and_usersync'] = 'Al crear, en cada inicio de sesión y en cada ejecución de la tarea de sincronización de usuarios';
$string['update_oncreate_and_usersync'] = 'Al crear y en cada ejecución de la tarea de sincronización de usuarios';
$string['update_onlogin_and_usersync'] = 'En cada inicio de sesión y en cada ejecución de la tarea de sincronización de usuarios';
$string['upgradeoidcuniqidtoolong'] = 'La actualización no puede continuar: algunos registros de auth_oidc_token tienen un oidcuniqid de más de 200 caracteres, que la nueva longitud de la columna truncaría. Elimine esos registros de token y vuelva a ejecutar la actualización.';

// Remote fields.
$string['settings_fieldmap_feild_not_mapped'] = '(sin asignar)';
$string['settings_fieldmap_field_bindingusernameclaim'] = 'Reclamación de nombre de usuario de vinculación (solo se puede asignar durante el inicio de sesión)';
$string['settings_fieldmap_field_city'] = 'Ciudad';
$string['settings_fieldmap_field_companyName'] = 'Nombre de la empresa';
$string['settings_fieldmap_field_objectId'] = 'ID de objeto';
$string['settings_fieldmap_field_country'] = 'País';
$string['settings_fieldmap_field_department'] = 'Departamento';
$string['settings_fieldmap_field_displayName'] = 'Nombre para mostrar';
$string['settings_fieldmap_field_surname'] = 'Apellido';
$string['settings_fieldmap_field_faxNumber'] = 'Número de fax';
$string['settings_fieldmap_field_telephoneNumber'] = 'Número de teléfono';
$string['settings_fieldmap_field_givenName'] = 'Nombre';
$string['settings_fieldmap_field_jobTitle'] = 'Puesto';
$string['settings_fieldmap_field_mail'] = 'Correo electrónico';
$string['settings_fieldmap_field_mobile'] = 'Móvil';
$string['settings_fieldmap_field_postalCode'] = 'Código postal';
$string['settings_fieldmap_field_preferredLanguage'] = 'Idioma';
$string['settings_fieldmap_field_state'] = 'Estado/provincia';
$string['settings_fieldmap_field_streetAddress'] = 'Dirección';
$string['settings_fieldmap_field_userPrincipalName'] = 'Nombre principal de usuario';
$string['settings_fieldmap_field_employeeId'] = 'ID de empleado';
$string['settings_fieldmap_field_employeeType'] = 'Tipo de empleado';
$string['settings_fieldmap_field_accountEnabled'] = 'Cuenta habilitada';
$string['settings_fieldmap_field_businessPhones'] = 'Teléfono de la oficina';
$string['settings_fieldmap_field_mobilePhone'] = 'Teléfono móvil';
$string['settings_fieldmap_field_officeLocation'] = 'Oficina';
$string['settings_fieldmap_field_preferredName'] = 'Nombre preferido';
$string['settings_fieldmap_field_manager'] = 'Nombre del responsable';
$string['settings_fieldmap_field_manager_email'] = 'Correo electrónico del responsable';
$string['settings_fieldmap_field_teams'] = 'Equipos';
$string['settings_fieldmap_field_groups'] = 'Grupos';
$string['settings_fieldmap_field_roles'] = 'Roles';
$string['settings_fieldmap_field_tokenclaim'] = '{$a} (reclamación del token)';
$string['settings_fieldmap_field_onPremisesSamAccountName'] = 'Nombre de cuenta SAM local';
$string['settings_fieldmap_field_extensionattribute'] = 'Atributo de extensión {$a}';
$string['settings_fieldmap_field_sds_school_id'] = 'ID de centro educativo de SDS ({$a})';
$string['settings_fieldmap_field_sds_school_name'] = 'Nombre de centro educativo de SDS ({$a})';
$string['settings_fieldmap_field_sds_school_role'] = 'Rol en el centro educativo de SDS ("Student" o "Teacher")';
$string['settings_fieldmap_field_sds_student_externalId'] = 'ID externo de estudiante de SDS';
$string['settings_fieldmap_field_sds_student_birthDate'] = 'Fecha de nacimiento de estudiante de SDS';
$string['settings_fieldmap_field_sds_student_grade'] = 'Curso de estudiante de SDS';
$string['settings_fieldmap_field_sds_student_graduationYear'] = 'Año de graduación de estudiante de SDS';
$string['settings_fieldmap_field_sds_student_studentNumber'] = 'Número de estudiante de SDS';
$string['settings_fieldmap_field_sds_teacher_externalId'] = 'ID externo de profesor de SDS';
$string['settings_fieldmap_field_sds_teacher_teacherNumber'] = 'Número de profesor de SDS';

// Binding username claim options.
$string['binding_username_claim_warning'] = 'Esta es una función avanzada. En la mayoría de los casos debería mantenerse en "Elegir automáticamente"; una configuración incorrecta puede afectar a los registros de usuario e interrumpir el inicio de sesión único (SSO).';
$string['binding_username_auto'] = 'Elegir automáticamente';
$string['binding_username_custom'] = 'Personalizado';
$string['bindingusernameclaim'] = 'Reclamación de nombre de usuario de vinculación';
$string['customclaimname'] = 'Nombre de la reclamación personalizada';
$string['customclaimname_description'] = 'Este campo solo se usa cuando el ajuste <b>Reclamación de nombre de usuario de vinculación</b> está establecido en <b>Personalizado</b>.';
$string['binding_username_claim_tool_link_desc'] = 'Para actualizar la reclamación de nombre de usuario de vinculación de los usuarios existentes, use la <a href="{$a}">Herramienta para cambiar la reclamación de nombre de usuario de vinculación</a>.';
$string['cleanup_oidc_tokens_link_desc'] = 'Para limpiar los tokens de OpenID Connect obsoletos, use la herramienta <a href="{$a}">Limpiar tokens de OpenID Connect</a>.';
$string['clear_user_tokens_link_desc'] = 'Para eliminar los tokens almacenados de todos los usuarios, o de los usuarios seleccionados, use la herramienta <a href="{$a}">Borrar tokens de usuario</a>.';
$string['clear_user_tokens'] = 'Borrar tokens de usuario';
$string['clear_user_tokens_desc'] = 'Elimina los tokens de OpenID Connect y de Microsoft 365 almacenados para los usuarios. Los usuarios afectados obtendrán tokens nuevos la próxima vez que inicien sesión mediante OpenID Connect o se conecten a Microsoft 365. Se conservan sus vínculos con las cuentas de Microsoft 365. ADVERTENCIA: esto puede interrumpir los inicios de sesión en curso, por lo que es mejor hacerlo durante un período de inactividad.';
$string['clear_user_tokens_scope_selected'] = 'Usuarios seleccionados';
$string['clear_user_tokens_scope_all'] = 'Todos los usuarios';
$string['clear_user_tokens_users'] = 'Usuarios';
$string['clear_user_tokens_submit'] = 'Borrar tokens';
$string['clear_user_tokens_no_name'] = '(sin nombre)';
$string['clear_user_tokens_no_user_selected'] = 'Seleccione al menos un usuario.';
$string['clear_user_tokens_confirm_all'] = '¿Está seguro de que desea borrar los tokens de todos los usuarios? Actualmente, {$a} usuario(s) tienen tokens.';
$string['clear_user_tokens_confirm_selected'] = '¿Está seguro de que desea borrar los tokens de los usuarios seleccionados? Actualmente, {$a} de los usuarios seleccionados tienen tokens.';
$string['clear_user_tokens_success'] = 'Se han borrado {$a} registro(s) de token.';
$string['binding_username_claim_help_ms_no_user_sync'] = 'Las opciones para un IdP de Microsoft sin la función de sincronización de usuarios activada incluyen:
<ul>
<li><b>Elegir automáticamente</b>: usa la lógica actual, que determina el token según el tipo de IdP y recurre a <b>sub</b> si no se encuentra ninguna reclamación.</li>
<li><b>preferred_username</b>: valor predeterminado para el tipo de IdP Microsoft identity platform (v2.0). <span class="not_support_user_sync">No admite la sincronización de usuarios.</span></li>
<li><b>email</b>: alternativa para Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: valor predeterminado para Microsoft Entra ID (v1.0) y otros tipos de IdP.</li>
<li><b>unique_name</b>: alternativa para Microsoft Entra ID (v1.0) y otros tipos de IdP. <span class="not_support_user_sync">No admite la sincronización de usuarios.</span></li>
<li><b>oid</b>: alternativa si no hay ninguna otra reclamación. Solo está presente en los IdP de Microsoft.</li>
<li><b>sub</b>: alternativa si no hay ninguna otra reclamación. <span class="not_support_user_sync">No admite la sincronización de usuarios.</span></li>
<li><b>samaccountname</b>: reclamación personalizada.</li>
<li><b>Personalizado</b>: permite al administrador del sitio introducir un valor personalizado. <span class="not_support_user_sync">No admite la sincronización de usuarios.</span></li>
</ul>
Tenga en cuenta que algunas opciones no admiten la sincronización de usuarios.';
$string['binding_username_claim_help_ms_with_user_sync'] = 'Las opciones para un IdP de Microsoft con la función de sincronización de usuarios activada incluyen:
<ul>
<li><b>Elegir automáticamente</b>: usa la lógica actual, que determina el token según el tipo de IdP y recurre a <b>sub</b> si no se encuentra ninguna reclamación.</li>
<li><b>email</b>: alternativa para Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: valor predeterminado para Microsoft Entra ID (v1.0) y otros tipos de IdP.</li>
<li><b>oid</b>: alternativa si no hay ninguna otra reclamación. Solo está presente en los IdP de Microsoft.</li>
<li><b>samaccountname</b>: reclamación personalizada.</li>
</ul>';
$string['binding_username_claim_help_non_ms'] = 'Las opciones para los IdP que no son de Microsoft incluyen:
<ul>
<li><b>Elegir automáticamente</b>: usa la lógica actual, que determina el token según el tipo de IdP y recurre a <b>sub</b> si no se encuentra ninguna reclamación.</li>
<li><b>preferred_username</b></li>
<li><b>email</b></li>
<li><b>unique_name</b></li>
<li><b>sub</b></li>
<li><b>samaccountname</b></li>
<li><b>custom</b>: reclamación personalizada.</li>
</ul>';
$string['warning_binding_username_claim_custom_unsupported'] = 'El ajuste "Reclamación de nombre de usuario de vinculación" está establecido actualmente en "Personalizado", lo que no se admite para el tipo de IdP configurado con la sincronización de usuarios activada. Revise los ajustes de <a href="{$a}">Reclamación de nombre de usuario de vinculación</a>.';
$string['examplecsv'] = 'Archivo de ejemplo';
$string['usernamefile'] = 'Archivo';
$string['csvdelimiter'] = 'Separador CSV';
$string['encoding'] = 'Codificación';
$string['rowpreviewnum'] = 'Filas de vista previa';
$string['upload_usernames'] = 'Actualizar nombres de usuario de vinculación';
$string['update_stats_users_updated'] = 'Se actualizaron {$a} usuarios';
$string['update_stats_users_errors'] = '{$a} usuarios tuvieron errores';
$string['update_error_incomplete_line'] = 'La línea no contiene los campos obligatorios.';
$string['update_error_user_not_found'] = 'No se encontró ningún usuario que coincida con el nombre de usuario. Se intentará actualizar el usuario asociado manualmente.';
$string['update_error_user_not_oidc'] = 'El usuario no usa el método de autenticación OpenID Connect. Se intentará actualizar el usuario asociado manualmente.';
$string['update_error_invalid_new_username'] = 'El nuevo nombre de usuario no es válido.';
$string['update_error_user_update_failed'] = 'No se pudo actualizar el usuario.';
$string['update_warning_email_match'] = 'El correo electrónico coincide con un usuario existente.';
$string['update_success_username'] = 'Nombre de usuario actualizado correctamente.';
$string['update_success_token'] = 'Token actualizado correctamente.';
$string['update_success_o365'] = 'Registro de conexión de Microsoft 365 actualizado correctamente.';
$string['update_error_nothing_updated'] = 'No se actualizó nada.';
$string['error_invalid_upload_file'] = 'Archivo subido no válido.';
$string['csvline'] = 'Línea CSV';
$string['change_binding_username_claim_tool_description'] = '<p class="warning_header">Esta es una función avanzada. Un uso incorrecto puede afectar a los registros de usuario e interrumpir el inicio de sesión único (SSO).</p>
<p>Esta herramienta permite a los administradores del sitio actualizar de forma masiva los siguientes registros:</p>
<ul>
<li>Nombres de usuario de las cuentas de Moodle,</li>
<li>Nombres de usuario de vinculación en los tokens de ID de OpenID Connect almacenados,</li>
<li>Registros de conexión entre cuentas de Moodle y de Microsoft.</li>
</ul>
<p>Solo debe usarse al cambiar los ajustes de <b>Reclamación de nombre de usuario de vinculación</b>.</p>
<p>La herramienta acepta un archivo CSV sencillo con dos columnas:</p>
<ul>
<li><b><span class="auth_oidc_code">username</span></b>: el nombre de usuario actual de la cuenta de Moodle que se va a actualizar o, si el usuario actual está asociado manualmente, el valor actual de la reclamación de vinculación.</li>
<li><b><span class="auth_oidc_code">new_username</span></b>: el valor (que distingue entre mayúsculas y minúsculas) de la nueva reclamación del token que se usará como reclamación de nombre de usuario de vinculación. Si el usuario está asociado automáticamente y usa el tipo de autenticación OpenID Connect, este valor en minúsculas se usará como nombre de usuario de Moodle.</li>
</ul>
<p>Al subir el archivo, la herramienta realizará las siguientes acciones:</p>
<ol>
<li>Buscar un usuario de Moodle existente cuyo nombre de usuario o dirección de correo electrónico sea el <span class="auth_oidc_code">username</span> indicado y que use el método de autenticación OpenID Connect y, si se encuentra, actualizar su nombre de usuario con el valor en minúsculas de <span class="auth_oidc_code">new_username</span>.</li>
<li>Actualizar el registro del token de OpenID Connect.
<ul>
<li>Si se encuentra un usuario en el paso 1 anterior, buscar el registro del token del usuario en la tabla <span class="auth_oidc_code">auth_oidc_token</span> y actualizar la columna <span class="auth_oidc_code">username</span> con el valor en minúsculas de <span class="auth_oidc_code">new_username</span>, y la columna <span class="auth_oidc_code">oidcusername</span> con el mismo valor que <span class="auth_oidc_code">new_username</span>.</li>
<li>Si no se encuentra ningún registro, intentará buscar un registro en la tabla <span class="auth_oidc_code">auth_oidc_token</span> cuya columna <span class="auth_oidc_code">oidcusername</span> coincida con el <span class="auth_oidc_code">username</span> anterior, y lo actualizará a <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
<li>Si el complemento <span class="auth_oidc_code">local_o365</span> está instalado, actualizar el registro de conexión del usuario.
<ul>
<li>Si se encuentra un usuario en el paso 1 anterior, buscar el registro de conexión del usuario en la tabla <span class="auth_oidc_code">local_o365_objects</span> y actualizar la columna <span class="auth_oidc_code">o365name</span> con el mismo valor que <span class="auth_oidc_code">new_username</span>.</li>
<li>Si no se encuentra ningún usuario en el paso 1, intentará buscar un registro de un usuario en la tabla <span class="auth_oidc_code">local_o365_objects</span> cuyo <span class="auth_oidc_code">o365name</span> coincida con el valor de <span class="auth_oidc_code">username</span>, y lo actualizará al valor de <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
</ol>
<p>El archivo de ejemplo siguiente cambiaría la reclamación de nombre de usuario de vinculación de <span class="auth_oidc_code">upn</span> o <span class="auth_oidc_code">email</span> a <span class="auth_oidc_code">oid</span>.</p>';
$string['change_binding_username_claim_tool_result'] = 'Resultados de la actualización';
$string['update_username_results'] = 'Resultados de la actualización de nombres de usuario';
$string['new_username'] = 'Nuevo nombre de usuario';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
