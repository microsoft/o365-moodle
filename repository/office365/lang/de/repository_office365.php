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
 * German language strings.
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Microsoft 365-Repository – Einheitliche Ordner-IDs';
$string['cachedef_unifiedgroupfolderids'] = 'Microsoft 365-Repository – Einheitliche Ordner-IDs für Gruppen';
$string['configplugin'] = 'Microsoft 365-Repository konfigurieren';
$string['controlledsharelinkdesc'] = 'Freigegebene Kopie (nur Mitglieder der Organisation)';
$string['copiedfile'] = 'Kopie der Datei';
$string['defaultgroupsfolder'] = 'Kursdateien';
$string['directlinkdesc'] = 'Direkter Link (bestehende Berechtigungen)';
$string['enableanonymousshare'] = 'Option "{$a}" aktivieren';
$string['enableanonymousshare_help'] = 'Wenn diese Option aktiviert ist, können Nutzer/innen eine Kopie einer Datei erstellen und sie für alle Personen in der Organisation freigeben. Die Kopie wird im OneDrive des Nutzers/der Nutzerin gespeichert und für alle Mitglieder der Organisation freigegeben.

**Funktionsweise:**
* Es wird eine Kopie der ausgewählten Datei mit dem Suffix " - Shared" erstellt.
* Die Kopie wird im OneDrive des Nutzers/der Nutzerin gespeichert (nicht am ursprünglichen Speicherort).
* Für die Kopie wird ein auf die Organisation beschränkter Freigabelink erstellt.
* Die Originaldatei bleibt mit ihren bestehenden Berechtigungen unverändert.

**Zugriffssteuerung:**
* Nur Mitglieder Ihrer Microsoft 365-Organisation können auf die Datei zugreifen.
* Jede Person in der Organisation, die den Link hat, kann die Datei ANZEIGEN.
* Externe und anonyme Nutzer/innen können NICHT auf die Datei zugreifen.
* Der Link läuft nicht automatisch ab.
* Die Besitzerin oder der Besitzer der Datei kann die Freigabe im eigenen OneDrive verwalten oder widerrufen.

**Wann diese Option sinnvoll ist:**
* Sie möchten eine Datei für alle Mitglieder der Organisation freigeben.
* Sie möchten die Originaldatei vor versehentlichen Änderungen schützen.
* Der Speicherplatz in Moodle ist knapp.
* Der Inhalt der Datei ist für den Zugriff durch die gesamte Organisation geeignet.

**Wichtige Hinweise:**
* Bei großen Dateien kann der Kopiervorgang einige Sekunden dauern.
* Nutzer/innen sollten sicherstellen, dass der Inhalt der Datei für die Freigabe in der gesamten Organisation geeignet ist.
* Die kopierte Datei erscheint im OneDrive des Nutzers/der Nutzerin mit dem Suffix " - Shared".
* Änderungen an der Originaldatei werden NICHT in die freigegebene Kopie übernommen und umgekehrt.

**Diese Option ist aufgrund von Anzeigeeinschränkungen und möglichen Missverständnissen standardmäßig deaktiviert. Aktivieren Sie dieses Kontrollkästchen nur, wenn Nutzer/innen für die Organisation freigegebene Kopien erstellen dürfen sollen.**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>Hinweis:</strong> Bei Verwendung der Option "{$a}" wird eine Kopie der Originaldatei erstellt und für alle Mitglieder der Organisation freigegeben. Die Originaldatei bleibt unverändert. Nutzer/innen sollten sicherstellen, dass der Inhalt der Datei für den Zugriff durch die gesamte Organisation geeignet ist.
<br><br><strong>Anzeigeeinschränkungen:</strong> Für Dateien, die mit dieser Option freigegeben werden, gelten je nach Dateityp und der in Arbeitsmaterialien verwendeten Anzeigeoption Einschränkungen. Das Verhalten ist wie folgt:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Anzeigeoption</th>
<th>Bilder</th>
<th>Dateien (z. B. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatisch</strong></td>
<td style="background-color: #ffdddd;">Funktioniert nicht – nichts wird angezeigt, Verbindung blockiert</td>
<td>Funktioniert – Weiterleitung zu OneDrive</td>
</tr>
<tr>
<td><strong>Einbetten</strong></td>
<td>Funktioniert – Bild wird eingebettet</td>
<td style="background-color: #ffdddd;">Funktioniert nicht – iframe zeigt den Fehler "Verbindung verweigert"</td>
</tr>
<tr>
<td><strong>Download erzwingen</strong></td>
<td colspan="2">Funktioniert – Weiterleitung zu OneDrive</td>
</tr>
<tr>
<td><strong>Öffnen</strong></td>
<td colspan="2">Funktioniert – Weiterleitung zu OneDrive</td>
</tr>
<tr>
<td><strong>Als Popup-Fenster</strong></td>
<td colspan="2">Funktioniert – wird im Popup-Fenster geöffnet</td>
</tr>
</tbody>
</table>
Für die beste Kompatibilität mit allen Anzeigeoptionen sollten Sie die Datei stattdessen nach Moodle kopieren.</div>';
$string['enablecoursegroup'] = 'Ordner "Gruppen (Kurse)" in der Dateiauswahl aktivieren';
$string['enabledirectlink'] = 'Option "{$a}" aktivieren';
$string['enabledirectlink_help'] = 'Wenn diese Option aktiviert ist, können Nutzer/innen einen direkten Link zu einer Datei in ihrem OneDrive hinzufügen, anstatt sie nach Moodle zu kopieren. Die Datei verbleibt in OneDrive, und Moodle speichert nur einen Referenzlink.

**Wichtige Hinweise zur Zugriffssteuerung:**
* Die bestehenden OneDrive-Berechtigungen der Datei werden NICHT geändert.
* Nutzer/innen, die den Link aufrufen, benötigen die entsprechenden Berechtigungen in OneDrive, um die Datei anzuzeigen.
* Wer den Link hinzufügt, ist dafür verantwortlich, die richtigen Zugriffsberechtigungen sicherzustellen.
* Wenn die OneDrive-Berechtigungen nicht korrekt gesetzt sind, können andere Nutzer/innen möglicherweise nicht auf die Datei zugreifen.

**Wann diese Option sinnvoll ist:**
* Die Dateien sind in Microsoft 365 bereits für die vorgesehene Zielgruppe freigegeben.
* Sie möchten OneDrive als einzige verbindliche Quelle beibehalten.
* Der Speicherplatz in Moodle ist knapp.
* Änderungen an der Datei in OneDrive sollen in Moodle sichtbar sein.

**Diese Option ist aufgrund von Anzeigeeinschränkungen und der Komplexität der Zugriffssteuerung standardmäßig deaktiviert. Aktivieren Sie dieses Kontrollkästchen nur, wenn Nutzer/innen Dateien direkt aus OneDrive verlinken dürfen sollen.**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>Hinweis:</strong> Bei Verwendung der Option "{$a}" werden die Freigabeeinstellungen der OneDrive-Datei nicht geändert. Nutzer/innen, die die Datei hinzufügen, müssen sicherstellen, dass die Dateiberechtigungen in OneDrive korrekt gesetzt sind.
<br><br><strong>Anzeigeeinschränkungen:</strong> Für Dateien, die mit dieser Option verlinkt werden, gelten je nach Dateityp und der in Arbeitsmaterialien verwendeten Anzeigeoption Einschränkungen. Das Verhalten ist wie folgt:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Anzeigeoption</th>
<th>Bilder</th>
<th>Dateien (z. B. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatisch</strong></td>
<td style="background-color: #ffdddd;">Funktioniert nicht – nichts wird angezeigt, Verbindung blockiert</td>
<td>Weiterleitung zu OneDrive; funktioniert, wenn der/die Nutzer/in Zugriffsrechte für die OneDrive-Datei hat, andernfalls wird eine Seite "Zugriff verweigert" angezeigt</td>
</tr>
<tr>
<td><strong>Einbetten</strong></td>
<td style="background-color: #ffdddd;">Funktioniert nicht – nichts wird angezeigt, Verbindung blockiert</td>
<td style="background-color: #ffdddd;">Funktioniert nicht – im eingebetteten iframe wird der Fehler "Verbindung verweigert" angezeigt</td>
</tr>
<tr>
<td><strong>Download erzwingen</strong></td>
<td colspan="2">Weiterleitung zu OneDrive; funktioniert, wenn der/die Nutzer/in Zugriffsrechte für die OneDrive-Datei hat, andernfalls wird eine Seite "Zugriff verweigert" angezeigt</td>
</tr>
<tr>
<td><strong>Öffnen</strong></td>
<td colspan="2">Weiterleitung zu OneDrive; funktioniert, wenn der/die Nutzer/in Zugriffsrechte für die OneDrive-Datei hat, andernfalls wird eine Seite "Zugriff verweigert" angezeigt</td>
</tr>
<tr>
<td><strong>Als Popup-Fenster</strong></td>
<td colspan="2">Öffnet im Popup-Fenster; funktioniert, wenn der/die Nutzer/in Zugriffsrechte für die OneDrive-Datei hat, andernfalls wird eine Seite "Zugriff verweigert" angezeigt</td>
</tr>
</tbody>
</table>
Für die beste Kompatibilität sollten Sie die Datei nach Moodle kopieren, anstatt einen direkten Link zu verwenden.</div>';
$string['enableinternal'] = 'Option "{$a}" aktivieren';
$string['enableinternal_help'] = 'Wenn diese Option aktiviert ist (Standard), können Nutzer/innen eine Datei aus OneDrive nach Moodle kopieren. Deaktivieren Sie diese Option und aktivieren Sie unten die Optionen "Link zur Datei anlegen" und/oder "Zugriffsgesteuerten Link anlegen", um Nutzer/innen zu zwingen, stattdessen auf Dateien zu verlinken.

Mindestens eine der drei Optionen zum Verlinken von Dateien muss aktiviert sein.';
$string['enableonedrivegroup'] = 'Ordner "Mein OneDrive" in der Dateiauswahl aktivieren';
$string['enabletrendinggroup'] = 'Ordner "Angesagte Dateien in meinem Umfeld" in der Dateiauswahl aktivieren';

$string['errorauthoidcnotconfig'] = 'Bitte konfigurieren Sie das OpenID Connect-Authentifizierungsplugin, bevor Sie das Microsoft 365-Repository verwenden.';
$string['errorbadclienttype'] = 'Ungültiger Clienttyp';
$string['errorbadpath'] = 'Falscher Pfad';
$string['errorencodingreference'] = 'Die Dateireferenz konnte nicht kodiert werden';
$string['errornofilelinkoption'] = 'Mindestens eine Option zum Verlinken von Dateien muss aktiviert sein.';
$string['erroro365required'] = 'Diese Datei ist derzeit nur für Microsoft 365-Nutzer/innen verfügbar.';
$string['errorwhiledownload'] = 'Beim Download der Datei trat ein Fehler auf';
$string['errorwhilesharing'] = 'Beim Erstellen eines Freigabelinks ist ein Fehler aufgetreten';

$string['file'] = 'Datei';
$string['filelinkingheader'] = 'Optionen zum Verlinken von Dateien';
$string['filereferencewarning'] = 'An den Freigabeeinstellungen der OneDrive-Datei werden keine Änderungen vorgenommen. Nur Personen, die in OneDrive bereits Zugriff auf die Datei haben, können diesen Link öffnen.';
$string['groups'] = 'Gruppen (Kurse)';
$string['invalidfilereference'] = 'Ungültige oder fehlerhafte Dateireferenz';
$string['myfiles'] = 'Mein OneDrive';
$string['notconfigured'] = '<p class="error">Um dieses Plugin zu verwenden, müssen Sie zuerst die <a href="{$a}/admin/settings.php?section=local_o365">Microsoft 365-Plugins</a> konfigurieren</p>';
$string['office365:view'] = 'Microsoft 365-Repository anzeigen';
$string['pluginname'] = 'Microsoft 365';
$string['privacy:metadata'] = 'Dieses Plugin kommuniziert als aktuelle/r Nutzer/in mit der Microsoft Graph-API (OneDrive). Alle hochgeladenen Dateien werden an den Remote-Server gesendet.';
$string['trendingaround'] = 'Angesagte Dateien in meinem Umfeld';
$string['upload'] = 'Neue Datei hochladen';
