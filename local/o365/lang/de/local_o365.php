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
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'Microsoft 365-Integration';
$string['acp_title'] = 'Microsoft 365-Systemsteuerung';
$string['acp_healthcheck'] = 'Health Check';
$string['acp_parentsite_name'] = 'Moodle';
$string['acp_parentsite_desc'] = 'Website für Moodle-Kursdaten.';
$string['calendar_user'] = 'Persönlicher (Benutzer) Kalender';
$string['calendar_site'] = 'Websiteweiter Kalender';
$string['erroracpauthoidcnotconfig'] = 'Legen Sie zunächst die Anwendungsanmeldeinformationen in auth_oidc fest.';
$string['erroracplocalo365notconfig'] = 'Konfigurieren Sie zunächst local_o365.';
$string['errorhttpclientbadtempfileloc'] = 'Temporärer Speicherort konnte nicht zum Speichern der Datei geöffnet werden.';
$string['errorhttpclientnofileinput'] = 'Kein Dateiparameter in httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Token konnte nicht aktualisiert werden';
$string['erroro365apibadcall'] = 'Fehler in API-Aufruf.';
$string['erroro365apibadcall_message'] = 'Fehler bei API-Aufruf: {$a}';
$string['erroro365apibadpermission'] = 'Berechtigung nicht gefunden';
$string['erroro365apicouldnotcreatesite'] = 'Problem beim Erstellen der Website.';
$string['erroro365apicoursenotfound'] = 'Kurs nicht gefunden';
$string['erroro365apiinvalidtoken'] = 'Ungültiges oder abgelaufenes Token.';
$string['erroro365apiinvalidmethod'] = 'Ungültige HTTP-Methode an API-Aufruf übergeben';
$string['erroro365apinoparentinfo'] = 'Informationen zum übergeordneten Ordner konnten nicht gefunden werden';
$string['erroro365apinotimplemented'] = 'Dies sollte überschrieben werden.';
$string['erroro365apinotoken'] = 'Kein Token für angegebene Ressource und angegebenen Benutzer vorhanden und es konnte auch kein Token abgerufen werden. Ist das Aktualisierungstoken des Benutzers abgelaufen?';
$string['erroro365apisiteexistsnolocal'] = 'Website ist bereits vorhanden, aber es konnte kein lokaler Eintrag gefunden werden.';
$string['eventapifail'] = 'API-Fehler';
$string['eventcalendarsubscribed'] = 'Benutzer hat einen Kalender abonniert';
$string['eventcalendarunsubscribed'] = 'Benutzer hat Abonnement eines Kalenders gekündigt';
$string['healthcheck_fixlink'] = 'Klicken Sie hier zum Beheben.';

$string['help_user_reenable'] = 'Hilfe für die Kontenreaktivierung';
$string['help_user_reenable_help'] = 'Mit Entra ID verknüpfte gesperrte Moodle-Konten werden reaktiviert, wenn sie auf Entra ID als aktiv markiert sind.';

$string['settings_usersync'] = 'Benutzer mit Microsoft Entra ID synchronisieren';
$string['settings_usersync_details'] = 'Wenn diese Option aktiviert ist, werden Moodle- und Microsoft Entra ID-Benutzer gemäß der obigen Optionen synchronisiert.<br /><br /><b>Hinweis: </b>Der Synchronisierungsauftrag wird im Moodle-Cron ausgeführt. Er synchronisiert 1.000 Benutzer gleichzeitig. Dieser Vorgang wird standardmäßig einmal täglich um 01:00 Uhr in der Zeitzone Ihres Servers ausgeführt. Um große Benutzermengen schneller zu synchronisieren, können Sie die Häufigkeit der Aufgabe <b>Benutzer mit Microsoft Entra ID synchronisieren</b> mithilfe der Seite für die <a href="{$a}">Verwaltung geplanter Aufgaben erhöhen.</a><br /><br />Ausführlichere Anweisungen finden Sie in der <a href="https://docs.moodle.org/30/en/Office365#User_sync">Dokumentation zur Benutzersynchronisierung</a><br /><br />';
$string['settings_usersync_create'] = 'Konten für Benutzer in Microsoft Entra ID in Moodle erstellen';
$string['settings_usersync_delete'] = 'Zuvor synchronisierte Konten in Moodle löschen, wenn diese aus Microsoft Entra ID gelöscht wurden';
$string['settings_usersync_match'] = 'Vorhandene Moodle-Nutzer mit gleichnamigen Konten in Microsoft Entra ID vergleichen<br /><small>Hierbei werden die Nutzernamen in Microsoft 365 und Moodle miteinander verglichen, um Übereinstimmungen zu finden. Bei Übereinstimmungen wird die Groß- und Kleinschreibung nicht beachtet und der Microsoft 365-Mandant ignoriert. Beispielsweise stimmt "BeN.SchmidT" in Moodle mit "ben.schmidt@example.onmicrosoft.com" überein. Die Moodle- und Office-Konten von Nutzern, für die eine Übereinstimmung festgestellt wird, werden miteinander verknüpft, sodass alle Microsoft 365- und Moodle-Integrationsfunktionen verwendet werden können. Die Authentifizierungsmethode des Nutzers ändert sich nicht, es sei denn, die nachfolgende Einstellung ist aktiviert.</small>';
$string['settings_usersync_matchswitchauth'] = 'Wechsel der Authentifizierung abgestimmter Nutzer zu Microsoft 365 (OpenID Connect)<br /><small>Hierzu muss die obige Vergleichseinstellung aktiviert sein. Wenn ein Nutzer abgestimmt wird, ändert sich die Authentifizierungsmethode durch die Aktivierung dieser Einstellung zu OpenID Connect. Der Nutzer meldet sich dann mit seinen Microsoft 365-Anmeldeinformationen bei Moodle an. <b>Hinweis:</b> Stellen Sie sicher, dass das OpenID Connect-Authentifizierungs-Plugin aktiviert ist, wenn Sie diese Einstellung verwenden möchten.</small>';
$string['settings_entratenant'] = 'Microsoft Entra ID-Mandant';
$string['settings_entratenant_details'] = 'Wird zum Identifizieren Ihres Unternehmens in Microsoft Entra ID verwendet. Beispiel: "contoso.onmicrosoft.com"';
$string['settings_verifysetup'] = 'Überprüfen Sie die Einrichtung';
$string['settings_verifysetup_details'] = 'Dieses Tool prüft mit Azure, um sicherzustellen, dass alle Optionen ordnungsgemäß eingerichtet sind. Es kann auch einige allgemeine Fehler beheben.';
$string['settings_verifysetup_update'] = 'Aktualisieren';
$string['settings_verifysetup_checking'] = 'Wird geprüft...';
$string['settings_verifysetup_missingperms'] = 'Fehlende Berechtigungen:';
$string['settings_verifysetup_permscorrect'] = 'Die Berechtigungen sind korrekt.';
$string['settings_verifysetup_errorcheck'] = 'Beim Prüfen des Azure-Setups ist ein Fehler aufgetreten.';
$string['settings_verifysetup_unifiedheader'] = 'Unified API';
$string['settings_verifysetup_unifieddesc'] = 'Die Unified API ersetzt die vorhandenen anwendungsspezifischen APIs. Sofern diese verfügbar ist, sollten Sie sie zu Ihrer Azure-Anwendung hinzufügen, um für die Zukunft gerüstet zu sein. Diese wird letztendlich die vorhandene API ersetzen.';
$string['settings_verifysetup_unifiederror'] = 'Fehler beim Überprüfen, ob die Unified API unterstützt wird.';
$string['settings_verifysetup_unifiedactive'] = 'Die Unified API ist aktiv.';
$string['settings_verifysetup_unifiedmissing'] = 'Die Unified API konnte in dieser Anwendung nicht gefunden werden.';
$string['settings_creategroups'] = 'Benutzergruppen erstellen';
$string['settings_creategroups_details'] = 'Wenn diese Option aktiviert ist, wird für jeden Kurs auf der Website in Microsoft 365 eine Gruppe mit Trainern und Teilnehmern erstellt und verwaltet. Dadurch werden bei jeder Cron-Ausführung alle erforderlichen Gruppen erstellt (und alle aktuellen Mitglieder hinzugefügt). Anschließend wird die Gruppenmitgliedschaft verwaltet, während die Nutzer für Moodle-Kurse registriert werden bzw. ihre Registrierung aufgehoben wird.<br /><b>Hinweis: </b>Diese Funktion erfordert, dass die Unified API von Microsoft 365 zur Anwendung hinzugefügt wird, die in Azure hinzugefügt wurde. <a href="https://docs.moodle.org/30/en/Office365#User_groups">Setup-Anweisungen und Dokumentation.</a>';
$string['settings_o365china'] = 'Microsoft 365 für China';
$string['settings_o365china_details'] = 'Lesen Sie diese Informationen, wenn Sie Microsoft 365 für China verwenden.';
$string['settings_debugmode'] = 'Debugmeldungen aufzeichnen';
$string['settings_debugmode_details'] = 'Wenn diese Option aktiviert ist, werden die Informationen im Moodle-Protokoll protokolliert, das bei der Erkennung von Problemen helfen kann.';
$string['settings_detectoidc'] = 'Anwendungsanmeldeinformationen';
$string['settings_detectoidc_details'] = 'Moodle benötigt Anmeldeinformationen, um sich für die Kommunikation mit Microsoft 365 selbst zu identifizieren. Diese sind im Authentifizierungs-Plugin "OpenID Connect" festgelegt.';
$string['settings_detectoidc_credsvalid'] = 'Die Anmeldeinformationen wurden festgelegt.';
$string['settings_detectoidc_credsvalid_link'] = 'Ändern';
$string['settings_detectoidc_credsinvalid'] = 'Die Anmeldeinformationen wurden nicht festgelegt oder sind unvollständig.';
$string['settings_detectoidc_credsinvalid_link'] = 'Anmeldeinformationen festlegen';
$string['settings_detectperms'] = 'Anwendungsberechtigungen';
$string['settings_detectperms_details'] = 'Die richtigen Berechtigungen müssen für die Anwendung in Microsoft Entra ID eingerichtet sein, damit die Plug-In-Funktionen verwendet werden können.';
$string['settings_detectperms_nocreds'] = 'Zuerst müssen die Anwendungsanmeldeinformationen festgelegt werden. Siehe obige Einstellung.';
$string['settings_detectperms_missing'] = 'Fehlend:';
$string['settings_detectperms_errorfix'] = 'Beim Beheben der Berechtigungen ist ein Fehler aufgetreten. Legen Sie diese in Azure manuell fest.';
$string['settings_detectperms_fixperms'] = 'Berechtigungen beheben';
$string['settings_detectperms_nounified'] = 'Die Unified API ist nicht vorhanden. Einige neue Funktionen funktionieren möglicherweise nicht.';
$string['settings_detectperms_unifiednomissing'] = 'Alle vereinheitlichten Berechtigungen sind vorhanden.';
$string['settings_detectperms_update'] = 'Aktualisieren';
$string['settings_detectperms_valid'] = 'Die Berechtigungen wurden eingerichtet.';
$string['settings_detectperms_invalid'] = 'Berechtigungen prüfen in Microsoft Entra ID';
$string['settings_header_setup'] = 'Setup';
$string['settings_header_options'] = 'Optionen';
$string['settings_healthcheck'] = 'Health Check';
$string['settings_healthcheck_details'] = 'Wenn etwas nicht ordnungsgemäß funktioniert, kann das Problem durch Ausführen eines Health Checks ermittelt und mögliche Problemlösungen angezeigt werden';
$string['settings_healthcheck_linktext'] = 'Health Check ausführen';
$string['settings_odburl'] = 'URL für OneDrive for Business';
$string['settings_odburl_details'] = 'Die für den Zugriff auf OneDrive for Business verwendete URL. Diese kann in der Regel mithilfe Ihres Microsoft Entra ID-Mandanten ermittelt werden. Wenn Ihr Microsoft Entra ID-Mandant z. B. "contoso.onmicrosoft.com" lautet, ist dies wahrscheinlich "contoso-my.sharepoint.com". Geben Sie nur den Domänennamen ein und lassen Sie das "http://" oder "https://" weg.';
$string['settings_usersync_reenable'] = 'Erlaube die Reaktivierung von gesperrten Moodle-Nutzerkonten über den Entra ID User sync';
$string['settings_usersync_suspend'] = 'Sperre Moodle-Nutzerkonten, wenn diese in Entra ID als gelöscht markiert wurden';
$string['settings_usersync_update'] = 'Aktualisiere mit Entra ID verknüpfte Moodle-Konten mit Entra ID-Daten';
$string['settings_serviceresourceabstract_valid'] = '{$a} kann verwendet werden.';
$string['settings_serviceresourceabstract_invalid'] = 'Dieser Wert kann anscheinend nicht verwendet werden.';
$string['settings_serviceresourceabstract_nocreds'] = 'Legen Sie zunächst die Anwendungsanmeldeinformationen fest.';
$string['settings_serviceresourceabstract_empty'] = 'Geben Sie einen Wert ein oder klicken Sie auf "Erkennen", um zu versuchen, den richtigen Wert zu erkennen.';
$string['spsite_group_contributors_name'] = '{$a} Mitwirkende';
$string['spsite_group_contributors_desc'] = 'Alle Benutzer, die Zugriff zum Verwalten der Dateien für Kurs {$a} haben';
$string['task_calendarsyncin'] = 'Microsoft 365-Ereignisse mit Moodle synchronisieren';
$string['task_coursesync'] = 'Nutzergruppen in Microsoft 365 erstellen';
$string['task_syncusers'] = 'Synchronisieren Sie Benutzer mit Microsoft Entra ID.';
$string['ucp_connectionstatus'] = 'Verbindungsstatus';
$string['ucp_calsync_availcal'] = 'Verfügbare Moodle-Kalender';
$string['ucp_calsync_title'] = 'Outlook-Kalendersynchronisierung';
$string['ucp_calsync_desc'] = 'Aktivierte Kalender werden von Moodle mit Ihrem Outlook-Kalender synchronisiert.';
$string['ucp_connection_status'] = 'Die Microsoft 365-Verbindung ist:';
$string['ucp_connection_start'] = 'Mit Microsoft 365 verbinden';
$string['ucp_connection_stop'] = 'Verbindung mit Microsoft 365 trennen';
$string['ucp_features'] = 'Microsoft 365-Funktionen';
$string['ucp_features_intro'] = 'Nachstehend finden Sie eine Liste der Funktionen, mit denen Sie Moodle mit Office&amp;nbsp;365 erweitern können.';
$string['ucp_features_intro_notconnected'] = 'Einige dieser Funktionen sind möglicherweise nicht verfügbar, bevor Sie die Verbindung mit Microsoft 365 hergestellt haben.';
$string['ucp_general_intro'] = 'Hier können Sie Ihre Verbindung mit Microsoft 365 verwalten.';
$string['ucp_index_entraidlogin_title'] = 'Microsoft 365-Anmeldung';
$string['ucp_index_entraidlogin_desc'] = 'Sie können sich mit Ihren Microsoft 365-Anmeldeinformationen bei Moodle anmelden. ';
$string['ucp_index_calendar_title'] = 'Outlook-Kalendersynchronisierung';
$string['ucp_index_calendar_desc'] = 'Hier können Sie die Synchronisierung zwischen Ihren Moodle- und Outlook-Kalendern einrichten. Sie können Moodle-Kalenderereignisse für Outlook exportieren und Outlook-Ereignisse in Moodle übernehmen.';
$string['ucp_index_connectionstatus_connected'] = 'Sie sind derzeit mit Microsoft 365 verbunden';
$string['ucp_index_connectionstatus_matched'] = 'Sie wurden mit Microsoft 365-Benutzer <small>"{$a}" zusammengeführt. Klicken Sie auf den nachfolgenden Link, und melden Sie sich bei Microsoft 365 an, um diese Verbindung herzustellen.';
$string['ucp_index_connectionstatus_notconnected'] = 'Sie sind derzeit nicht mit Microsoft 365 verbunden';
$string['ucp_index_onenote_title'] = 'OneNote';
$string['ucp_index_onenote_desc'] = 'Die OneNote-Integration ermöglicht die Verwendung von Microsoft 365 OneNote mit Moodle. Sie können Zuweisungen mithilfe von OneNote abschließen und problemlos Notizen zu Ihren Kursen machen.';
$string['ucp_notconnected'] = 'Stellen Sie zunächst die Verbindung mit Microsoft 365 her, bevor Sie dies öffnen.';
$string['settings_onenote'] = 'Microsoft 365 OneNote deaktivieren';
$string['ucp_status_enabled'] = 'Aktiv';
$string['ucp_status_disabled'] = 'Nicht verbunden';
$string['ucp_syncwith_title'] = 'Synchronisieren mit:';
$string['ucp_syncdir_title'] = 'Synchronisierungsverhalten:';
$string['ucp_syncdir_out'] = 'Von Moodle zu Outlook';
$string['ucp_syncdir_in'] = 'Von Outlook zu Moodle';
$string['ucp_syncdir_both'] = 'Sowohl Outlook als auch Moodle aktualisieren';
$string['ucp_title'] = 'Microsoft 365/Moodle-Systemsteuerung';
$string['ucp_options'] = 'Optionen';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
