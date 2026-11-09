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
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Repositorio de Microsoft 365 - ID de carpetas unificadas';
$string['cachedef_unifiedgroupfolderids'] = 'Repositorio de Microsoft 365 - ID de carpetas unificadas de grupos';
$string['configplugin'] = 'Configurar el repositorio de Microsoft 365';
$string['controlledsharelinkdesc'] = 'Copia compartida (solo miembros de la organización)';
$string['copiedfile'] = 'Copia del archivo';
$string['defaultgroupsfolder'] = 'Archivos del curso';
$string['directlinkdesc'] = 'Enlace directo (permisos existentes)';
$string['enableanonymousshare'] = 'Habilitar la opción "{$a}"';
$string['enableanonymousshare_help'] = 'Si se marca, los usuarios pueden optar por crear una copia de un archivo y compartirla con todos los miembros de la organización. La copia se almacena en el OneDrive del usuario y se comparte con todos los miembros de la organización.

**Cómo funciona:**
* Crea una copia del archivo seleccionado con el sufijo " - Shared".
* La copia se guarda en el OneDrive del usuario (no en la ubicación original).
* Se crea un enlace de uso compartido limitado a la organización para la copia.
* El archivo original permanece sin cambios, con sus permisos existentes.

**Control de acceso:**
* Solo los miembros de su organización de Microsoft 365 pueden acceder al archivo.
* Cualquier persona de la organización que tenga el enlace puede VER el archivo.
* Los usuarios externos y los usuarios anónimos NO pueden acceder al archivo.
* El enlace no caduca automáticamente.
* El propietario del archivo puede gestionar o revocar el uso compartido desde su OneDrive.

**Cuándo usarla:**
* Quiere compartir un archivo con todos los miembros de la organización.
* Quiere proteger el archivo original frente a cambios accidentales.
* El espacio de almacenamiento en Moodle es un problema.
* El contenido del archivo es apropiado para el acceso de toda la organización.

**Notas importantes:**
* La operación de copia puede tardar unos segundos en el caso de archivos grandes.
* Los usuarios deben asegurarse de que el contenido del archivo sea apropiado para compartirlo con toda la organización.
* El archivo copiado aparecerá en el OneDrive del usuario con el sufijo " - Shared".
* Los cambios realizados en el archivo original NO se reflejarán en la copia compartida, y viceversa.

**Esta opción está deshabilitada de forma predeterminada debido a las limitaciones de visualización y a la posible confusión. Marque esta casilla solo si quiere permitir que los usuarios creen copias compartidas con la organización.**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>Nota:</strong> Al usar la opción "{$a}", se crea una copia del archivo original y se comparte con todos los miembros de la organización. El archivo original permanece sin cambios. Los usuarios deben asegurarse de que el contenido del archivo sea apropiado para el acceso de toda la organización.
<br><br><strong>Limitaciones de visualización:</strong> Los archivos compartidos con esta opción tienen limitaciones según el tipo de archivo y la opción de visualización utilizada en los recursos. El comportamiento varía de la siguiente manera:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Opción de visualización</th>
<th>Imágenes</th>
<th>Archivos (p. ej. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automático</strong></td>
<td style="background-color: #ffdddd;">No funciona: no se muestra nada, la conexión se bloquea</td>
<td>Funciona: redirige a OneDrive</td>
</tr>
<tr>
<td><strong>Incrustar</strong></td>
<td>Funciona: la imagen se incrusta</td>
<td style="background-color: #ffdddd;">No funciona: el iframe muestra el error "se rechazó la conexión"</td>
</tr>
<tr>
<td><strong>Forzar descarga</strong></td>
<td colspan="2">Funciona: redirige a OneDrive</td>
</tr>
<tr>
<td><strong>Abrir</strong></td>
<td colspan="2">Funciona: redirige a OneDrive</td>
</tr>
<tr>
<td><strong>En ventana emergente</strong></td>
<td colspan="2">Funciona: se abre en una ventana emergente</td>
</tr>
</tbody>
</table>
Para obtener la mejor compatibilidad con todas las opciones de visualización, considere copiar el archivo en Moodle en su lugar.</div>';
$string['enablecoursegroup'] = 'Habilitar la carpeta Grupos (cursos) en el selector de archivos';
$string['enabledirectlink'] = 'Habilitar la opción "{$a}"';
$string['enabledirectlink_help'] = 'Si se marca, los usuarios pueden agregar un enlace directo a un archivo de su OneDrive en lugar de copiarlo en Moodle. El archivo permanece en OneDrive y Moodle solo almacena un enlace de referencia.

**Consideraciones importantes sobre el control de acceso:**
* Los permisos existentes del archivo en OneDrive NO se modifican.
* Los usuarios que accedan al enlace deben tener los permisos adecuados en OneDrive para ver el archivo.
* Es responsabilidad del usuario que agrega el enlace garantizar los permisos de acceso adecuados.
* Si los permisos de OneDrive no están configurados correctamente, es posible que otros usuarios no puedan acceder al archivo.

**Cuándo usar esta opción:**
* Los archivos ya están compartidos con el público previsto en Microsoft 365.
* Quiere mantener una única fuente de verdad en OneDrive.
* El espacio de almacenamiento en Moodle es un problema.
* Las modificaciones del archivo en OneDrive deben reflejarse en Moodle.

**Esta opción está deshabilitada de forma predeterminada debido a las limitaciones de visualización y a la complejidad del control de acceso. Marque esta casilla solo si quiere permitir que los usuarios enlacen archivos directamente desde OneDrive.**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>Nota:</strong> Al usar la opción "{$a}", no se realiza ningún cambio en la configuración de uso compartido del archivo de OneDrive. Los usuarios que agregan el archivo deben asegurarse de que los permisos del archivo en OneDrive estén configurados correctamente.
<br><br><strong>Limitaciones de visualización:</strong> Los archivos enlazados con esta opción tienen limitaciones según el tipo de archivo y la opción de visualización utilizada en los recursos. El comportamiento varía de la siguiente manera:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Opción de visualización</th>
<th>Imágenes</th>
<th>Archivos (p. ej. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automático</strong></td>
<td style="background-color: #ffdddd;">No funciona: no se muestra nada, la conexión se bloquea</td>
<td>Redirige a OneDrive; funciona si el usuario tiene permiso para acceder al archivo de OneDrive y, en caso contrario, muestra una página de permiso denegado</td>
</tr>
<tr>
<td><strong>Incrustar</strong></td>
<td style="background-color: #ffdddd;">No funciona: no se muestra nada, la conexión se bloquea</td>
<td style="background-color: #ffdddd;">No funciona: se muestra un error de conexión rechazada en el iframe incrustado</td>
</tr>
<tr>
<td><strong>Forzar descarga</strong></td>
<td colspan="2">Redirige a OneDrive; funciona si el usuario tiene permiso para acceder al archivo de OneDrive y, en caso contrario, muestra una página de permiso denegado</td>
</tr>
<tr>
<td><strong>Abrir</strong></td>
<td colspan="2">Redirige a OneDrive; funciona si el usuario tiene permiso para acceder al archivo de OneDrive y, en caso contrario, muestra una página de permiso denegado</td>
</tr>
<tr>
<td><strong>En ventana emergente</strong></td>
<td colspan="2">Se abre en una ventana emergente; funciona si el usuario tiene permiso para acceder al archivo de OneDrive y, en caso contrario, muestra una página de permiso denegado</td>
</tr>
</tbody>
</table>
Para obtener la mejor compatibilidad, considere copiar el archivo en Moodle en lugar de usar un enlace directo.</div>';
$string['enableinternal'] = 'Habilitar la opción "{$a}"';
$string['enableinternal_help'] = 'Si se marca (valor predeterminado), los usuarios pueden optar por copiar un archivo de OneDrive en Moodle. Desmarque esta opción y habilite las opciones "Enlazar al archivo" y/o "Crear un enlace de acceso controlado al archivo" que aparecen a continuación para obligar a los usuarios a enlazar los archivos en su lugar.

Debe estar habilitada al menos una de las tres opciones de enlace de archivos.';
$string['enableonedrivegroup'] = 'Habilitar la carpeta Mi OneDrive en el selector de archivos';
$string['enabletrendinggroup'] = 'Habilitar la carpeta Archivos populares a mi alrededor en el selector de archivos';

$string['errorauthoidcnotconfig'] = 'Configure el complemento de autenticación OpenID Connect antes de intentar usar el repositorio de Microsoft 365.';
$string['errorbadclienttype'] = 'Tipo de cliente no válido.';
$string['errorbadpath'] = 'Ruta incorrecta';
$string['errorencodingreference'] = 'No se ha podido codificar la referencia del archivo';
$string['errornofilelinkoption'] = 'Debe estar habilitada al menos una opción de enlace de archivos.';
$string['erroro365required'] = 'Actualmente, este archivo solo está disponible para usuarios de Microsoft 365.';
$string['errorwhiledownload'] = 'Ocurrió un error al descargar el archivo';
$string['errorwhilesharing'] = 'Ocurrió un error al crear un enlace para compartir';

$string['file'] = 'Archivo';
$string['filelinkingheader'] = 'Opciones de enlace de archivos';
$string['filereferencewarning'] = 'No se realiza ningún cambio de uso compartido en el archivo de OneDrive. Solo las personas que ya tienen acceso al archivo en OneDrive pueden abrir este enlace.';
$string['groups'] = 'Grupos (cursos)';
$string['invalidfilereference'] = 'Referencia de archivo no válida o con formato incorrecto';
$string['myfiles'] = 'Mi OneDrive';
$string['notconfigured'] = '<p class="error">Para usar este complemento, primero debe configurar los <a href="{$a}/admin/settings.php?section=local_o365">complementos de Microsoft 365</a></p>';
$string['office365:view'] = 'Ver el repositorio de Microsoft 365';
$string['pluginname'] = 'Microsoft 365';
$string['privacy:metadata'] = 'Este complemento se comunica con la API de Microsoft Graph (OneDrive) como el usuario actual. Todos los archivos subidos se enviarán al servidor remoto.';
$string['trendingaround'] = 'Archivos populares a mi alrededor';
$string['upload'] = 'Subir nuevo archivo';
