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

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft 365-Integration';

// Settings - tabs.
$string['settings_pageheading'] = '{$a}-Konfiguration';
$string['settings_header_setup'] = 'Einrichtung';
$string['settings_header_usersync'] = 'Nutzersynchronisierung';
$string['settings_header_coursesync'] = 'Kurssynchronisierung';
$string['settings_header_advanced'] = 'Erweitert';
$string['settings_header_sds'] = 'SDS-Synchronisierung';
$string['settings_header_teams'] = 'Teams-Einstellungen';
$string['settings_header_moodle_app'] = 'Teams-Moodle-App';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'Schritt 1/2: Moodle bei Microsoft Entra ID registrieren';
$string['settings_setup_step1_desc'] = 'Registrieren Sie mit PowerShell eine neue Microsoft Entra ID-App für die Moodle-Integration:

<a href="{$a}/local/o365/scripts/Moodle-EntraID-PowerShell.zip" class="btn btn-primary" target="_blank">PowerShell-Skript herunterladen</a>

<p style="margin-top:10px"><a href="{$a}/local/o365/scripts/README.md" target="_blank">Klicken Sie hier</a>, um die Anleitung zum Ausführen des Skripts zu lesen.</p>
<p>Wenn Sie dazu aufgefordert werden, verwenden Sie den folgenden Link als Moodle-URL:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />Nachdem das Skript erfolgreich ausgeführt wurde, kopieren Sie die vom Skript zurückgegebene Anwendungs-ID und den geheimen Clientschlüssel in die <a href="{$a}">Konfigurationsseite des OpenID Connect-Authentifizierungsplugins</a>.';
$string['settings_setup_step1_credentials_end'] = 'Wenn Sie die Microsoft Entra ID-App nicht über PowerShell einrichten können, <a href="{$a}" target="_blank">klicken Sie hier</a>, um die Anleitung zur manuellen Einrichtung aufzurufen.';
$string['settings_setup_step1_continue'] = '<b>Nachdem Sie Anwendungs-ID und geheimen Clientschlüssel eingegeben haben, klicken Sie unten auf der Seite auf "Änderungen speichern", um fortzufahren.</b><br /><br /><br /><br /><br />';
$string['features_disabled_external_id'] = 'Die Microsoft-365-Funktionen sind nicht verfügbar, wenn der Identitätsanbietertyp (IdP-Typ) des OpenID-Connect-Authentifizierungs-Plugins auf Microsoft Entra External ID eingestellt ist. Microsoft Entra External ID-Mandanten sind Kundenmandanten ohne Microsoft-365-Dienste (Exchange Online, Microsoft Teams, SharePoint/OneDrive oder School Data Sync), daher sind alle Funktionen dieses Plugins deaktiviert.';
$string['task_skipped_external_id'] = 'Die Aufgabe wurde übersprungen: Die Microsoft-365-Funktionen dieses Plugins sind deaktiviert, da der IdP-Typ des OpenID-Connect-Authentifizierungs-Plugins Microsoft Entra External ID ist.';
$string['settings_setup_step1_existing_settings'] = '<h5>Vorhandene Einstellungen</h5>';
$string['settings_setup_step2'] = 'Schritt 2/2: Administratorzustimmung &amp; zusätzliche Informationen';
$string['settings_setup_step2_desc'] = 'In diesem letzten Schritt können Sie die Administratorzustimmung zur Verwendung einiger Microsoft Entra ID-Berechtigungen erteilen. Außerdem werden einige zusätzliche Informationen über Ihre Microsoft 365-Umgebung erfasst.<br /><br />';
$string['settings_setup_step3'] = 'Einrichtung überprüfen';
$string['settings_setup_step3_desc'] = 'Die Einrichtung ist abgeschlossen. Klicken Sie unten auf "Aktualisieren", um Ihre Einrichtung zu überprüfen.';

// Settings in "Step 2/2" section of the "Setup" tab.
$string['settings_adminconsent'] = 'Administratorzustimmung';
$string['settings_adminconsent_btn'] = 'Administratorzustimmung erteilen';
$string['settings_adminconsent_details'] = 'Um den Zugriff auf einige der benötigten Berechtigungen zu erlauben, muss ein/e Administrator/in die Administratorzustimmung erteilen. Klicken Sie auf diese Schaltfläche und melden Sie sich mit einem Microsoft Entra ID-Administratorkonto an, um die Zustimmung zu erteilen. Dies ist jedes Mal erforderlich, wenn Sie "Admin"-Berechtigungen in Entra ID ändern.';
$string['settings_entratenant'] = 'Microsoft Entra-Mandant';
$string['settings_entratenant_details'] = 'Wird verwendet, um Ihre Organisation bei Microsoft zu identifizieren. Beispiel: "contoso.onmicrosoft.com".<br/>
So ermitteln Sie diesen Wert manuell:
<ul>
<li>Öffnen Sie das <a href="https://portal.azure.com" target="_blank">Azure Portal</a>.</li>
<li>Melden Sie sich mit Ihrem Administratorkonto an.</li>
<li>Geben Sie in der Suchleiste "Microsoft Entra ID" ein und öffnen Sie die Seite "Microsoft Entra ID".</li>
<li>Verwenden Sie den Wert im Feld <b>Primäre Domäne</b> im Abschnitt "Grundlegende Informationen".</li>
</ul>';
$string['settings_odburl'] = 'URL für OneDrive for Business';
$string['settings_odburl_details'] = 'Die für den Zugriff auf OneDrive for Business verwendete URL. Diese kann in der Regel anhand Ihres Microsoft Entra-Mandanten ermittelt werden. Wenn Ihr Microsoft Entra-Mandant z. B. "contoso.onmicrosoft.com" lautet, ist dies wahrscheinlich "contoso-my.sharepoint.com". Geben Sie nur den Domänennamen ein und lassen Sie http:// oder https:// weg.';
$string['settings_odburl_error_graph'] = 'Ihre URL für OneDrive for Business konnte nicht ermittelt werden. Bitte geben Sie sie manuell ein. In der Regel können Sie dafür die URL verwenden, mit der Sie auf OneDrive zugreifen.';
$string['settings_serviceresourceabstract_detect'] = 'Erkennen';
$string['settings_serviceresourceabstract_detecting'] = 'Wird erkannt...';
$string['settings_serviceresourceabstract_error'] = 'Beim Erkennen der Einstellung ist ein Fehler aufgetreten. Bitte legen Sie sie manuell fest.';
$string['settings_serviceresourceabstract_valid'] = '{$a} kann verwendet werden.';
$string['settings_serviceresourceabstract_invalid'] = 'Dieser Wert kann anscheinend nicht verwendet werden.';
$string['settings_serviceresourceabstract_nocreds'] = 'Legen Sie zunächst die Anwendungsanmeldeinformationen fest.';
$string['settings_serviceresourceabstract_empty'] = 'Geben Sie einen Wert ein oder klicken Sie auf "Erkennen", um zu versuchen, den richtigen Wert zu erkennen.';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_verifysetup'] = 'Einrichtung überprüfen';
$string['settings_verifysetup_appdataheader'] = 'Microsoft Entra ID-App-Registrierung';
$string['settings_verifysetup_appdatadesc'] = 'Überprüft, ob in der Entra ID-App die richtigen Parameter eingerichtet sind.';
$string['settings_verifysetup_appdatareplyurlcorrect'] = 'Antwort-URL korrekt';
$string['settings_verifysetup_appdatareplyurlincorrect'] = 'Antwort-URL nicht korrekt';
$string['settings_verifysetup_appdatareplyurlgeneralerror'] = 'Die Antwort-URL konnte nicht überprüft werden.';
$string['settings_verifysetup_appdatasignonurlcorrect'] = 'Anmelde-URL korrekt.';
$string['settings_verifysetup_appdatasignonurlincorrect'] = 'Anmelde-URL nicht korrekt';
$string['settings_verifysetup_appdatasignonurlgeneralerror'] = 'Die Anmelde-URL konnte nicht überprüft werden.';
$string['settings_verifysetup_apppermscorrect'] = 'Die Anwendungsberechtigungen sind korrekt.';
$string['settings_verifysetup_details'] = 'Dieses Tool prüft bei Microsoft Entra ID, ob alles korrekt eingerichtet ist. <br /><b>Hinweis:</b> Änderungen an der Microsoft Entra ID-App können einen Moment dauern, bis sie hier angezeigt werden. Wenn Sie eine Änderung an der Microsoft Entra ID-App vorgenommen haben und sie hier nicht sehen, warten Sie einen Moment und versuchen Sie es erneut.';
$string['settings_verifysetup_correctval'] = 'Korrekter Wert:';
$string['settings_verifysetup_detectedval'] = 'Erkannter Wert:';
$string['settings_verifysetup_update'] = 'Aktualisieren';
$string['settings_verifysetup_checking'] = 'Wird geprüft...';
$string['settings_verifysetup_missingappperms'] = 'Fehlende Anwendungsberechtigungen:';
$string['settings_verifysetup_notgranted'] = 'zur Anwendung hinzugefügt, aber die Administratorzustimmung wurde nicht erteilt';
$string['settings_verifysetup_missingperms'] = 'Fehlende delegierte Berechtigungen:';
$string['settings_verifysetup_permscorrect'] = 'Die delegierten Berechtigungen sind korrekt.';
$string['settings_verifysetup_errorcheck'] = 'Beim Überprüfen der Einrichtung ist ein Fehler aufgetreten.';
$string['settings_verifysetup_noinfo'] = 'Es liegen noch keine Informationen zur Einrichtung Ihrer Microsoft Entra ID-App vor. Klicken Sie zum Überprüfen auf "Aktualisieren".';
$string['settings_verifysetup_strunifiedpermerror'] = 'Beim Überprüfen der Microsoft Graph API-Berechtigungen ist ein Fehler aufgetreten.';
$string['settings_verifysetup_strtenanterror'] = 'Verwenden Sie die Schaltfläche "Erkennen", um Ihren Microsoft Entra-Mandanten festzulegen, bevor Sie die Einrichtung der Microsoft Entra ID-App aktualisieren.';
$string['settings_verifysetup_unifiedheader'] = 'Microsoft Graph API';
$string['settings_verifysetup_unifieddesc'] = 'Die Microsoft Graph API ermöglicht die Kommunikation zwischen Moodle und Microsoft 365.';
$string['settings_verifysetup_unifiederror'] = 'Beim Überprüfen der Unterstützung für die Microsoft Graph API ist ein Fehler aufgetreten.';
$string['settings_verifysetup_unifiedactive'] = 'Microsoft Graph API aktiv.';
$string['settings_verifysetup_unifiedmissing'] = 'Die Microsoft Graph API wurde in dieser Anwendung nicht gefunden.';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc_credsvalid'] = 'Die Anmeldeinformationen wurden festgelegt.';
$string['settings_detectoidc_credsvalid_link'] = 'Ändern';
$string['settings_detectoidc_credsinvalid'] = 'Die Anmeldeinformationen wurden nicht festgelegt oder sind unvollständig.';
$string['settings_detectoidc_credsinvalid_link'] = 'Anmeldeinformationen festlegen';
$string['settings_detectperms_nocreds'] = 'Zuerst müssen die Anwendungsanmeldeinformationen festgelegt werden. Siehe obige Einstellung.';
$string['settings_detectperms_errorfix'] = 'Beim Beheben der Berechtigungen ist ein Fehler aufgetreten. Bitte beheben Sie dies manuell in Microsoft Entra ID.';
$string['settings_detectperms_fixperms'] = 'Berechtigungen beheben';
$string['settings_detectperms_update'] = 'Aktualisieren';
$string['settings_detectperms_valid'] = 'Die Berechtigungen wurden eingerichtet.';
$string['settings_detectperms_invalid'] = 'Berechtigungen in Microsoft Entra ID prüfen';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_usersync_general'] = 'Allgemeine Nutzersynchronisierung';
$string['settings_usersync_suspension'] = 'Sperrung von Moodle-Konten';
$string['settings_usersync_matching'] = 'Nutzerzuordnung';
$string['settings_usersync_photos'] = 'Microsoft 365-Profilbilder mit Moodle synchronisieren';
$string['settings_usersync_timezone'] = 'Outlook-Zeitzone mit Moodle synchronisieren';
$string['settings_usersync'] = 'Nutzer/innen aus Microsoft Entra ID synchronisieren';
$string['settings_usersync_details'] = 'Wenn diese Option aktiviert ist, synchronisiert Moodle Nutzer/innen aus Microsoft Entra ID gemäß den obigen Optionen.<br /><br /><b>Hinweis: </b>Der Synchronisierungsvorgang wird im Moodle-Cron ausgeführt und synchronisiert jeweils 1.000 Nutzer/innen. Standardmäßig wird er einmal täglich um 01:00 Uhr in der Zeitzone Ihres Servers ausgeführt. Um große Nutzermengen schneller zu synchronisieren, können Sie die Häufigkeit des Tasks <b>Nutzer/innen aus Microsoft Entra ID synchronisieren</b> auf der <a href="{$a}">Seite zur Verwaltung geplanter Tasks erhöhen.</a><br /><br />';
$string['settings_usersync_create'] = 'Konten in Moodle für Nutzer/innen in Microsoft Entra ID erstellen';
$string['settings_usersync_update'] = 'Konten in Moodle für Nutzer/innen in Microsoft Entra ID aktualisieren';
$string['settings_usersync_suspend'] = 'Zuvor synchronisierte Konten in Moodle sperren, wenn sie aus Microsoft Entra ID gelöscht wurden';
$string['settings_usersync_delete'] = 'Zuvor synchronisierte Konten in Moodle löschen, wenn sie aus Microsoft Entra ID gelöscht wurden';
$string['settings_usersync_reenable'] = 'Gesperrte Konten für Nutzer/innen in Microsoft Entra ID wieder aktivieren';
$string['settings_usersync_disabledsyncsuspend'] = 'Konten in Moodle sperren, wenn sie in Microsoft Entra ID deaktiviert wurden';
$string['settings_usersync_disabledsyncreenable'] = 'Konten in Moodle wieder aktivieren, wenn sie in Microsoft Entra ID wieder aktiviert wurden';
$string['settings_usersync_suspendnolink'] = 'Verbundene Konten ohne gespeicherte Microsoft-Verknüpfung sperren, wenn sie aus Microsoft Entra ID gelöscht oder dort deaktiviert wurden';
$string['settings_usersync_groupsyncsuspend'] = 'Konten in Moodle sperren, wenn sie nicht in der konfigurierten Gruppe für die Nutzersynchronisierung sind';
$string['settings_usersync_match'] = 'Vorhandene Moodle-Nutzer/innen mit gleichnamigen Konten in Microsoft Entra ID abgleichen';
$string['settings_usersync_matchswitchauth'] = 'Authentifizierung abgeglichener Nutzer/innen auf Microsoft 365 (OpenID Connect) umstellen';
$string['settings_usersync_appassign'] = 'Nutzer/innen während der Synchronisierung der Anwendung zuweisen';
$string['settings_usersync_photosync'] = 'Microsoft 365-Profilbilder im Cron-Task mit Moodle synchronisieren';
$string['settings_usersync_photosynconlogin'] = 'Microsoft 365-Profilbilder bei der Anmeldung mit Moodle synchronisieren';
$string['settings_usersync_nodelta'] = 'Bei jedem Durchlauf eine vollständige Synchronisierung durchführen';
$string['settings_usersync_emailsync'] = 'Microsoft Entra ID-Anmeldenamen während der Synchronisierung mit Moodle-E-Mail-Adressen statt mit Moodle-Anmeldenamen abgleichen';
$string['settings_addsync_tzsync'] = 'Outlook-Zeitzone im Cron-Task mit Moodle synchronisieren';
$string['settings_addsync_tzsynconlogin'] = 'Outlook-Zeitzone bei der Anmeldung mit Moodle synchronisieren';
$string['settings_usersync_guestsync'] = 'Gastnutzer/innen synchronisieren';
$string['settings_suspend_delete_running_time'] = 'Ausführungszeit für Sperrung/Löschung von Nutzer/innen';
$string['settings_suspend_delete_running_time_desc'] = 'Wenn die Option aktiviert ist, wird die Sperr-/Löschfunktion der Nutzersynchronisierung einmal täglich zur konfigurierten Uhrzeit in der Standardzeitzone der Moodle-Instanz ausgeführt.';
$string['settings_usersync_delete_delay'] = 'Verzögerung vor dem Löschen gesperrter Nutzer/innen';
$string['settings_usersync_delete_delay_desc'] = 'Die Mindestdauer, die Nutzer/innen in Moodle gesperrt bleiben müssen, bevor die Nutzersynchronisierung das Konto löscht. Dies gilt zusätzlich zur Aufbewahrungsfrist für vorläufig gelöschte Objekte in Microsoft Entra ID, sodass das Löschen nie früher erfolgt. Setzen Sie den Wert auf 0, um zu löschen, sobald die Aufbewahrungsfrist in Microsoft Entra ID abgelaufen ist. Bei Nutzer/innen, die bereits vor Einführung dieser Einstellung gesperrt waren, wird ab dem ersten Durchlauf der Nutzersynchronisierung gezählt, der sie findet.';
$string['settings_support_user_identifier_change'] = 'Änderung des Werts des bindenden Anmeldenamen-Claims von Microsoft-Konten unterstützen';
$string['settings_support_user_identifier_change_desc'] = 'Wenn aktiviert, versucht Moodle zu reagieren, wenn sich der Wert des bindenden Anmeldenamen-Claims (normalerweise UPN) eines Microsoft-Kontos ändert, das mit einem Moodle-Konto verbunden ist.<br/>
<table class="flexible table table-striped table-hover generaltable generalbox table-sm">
    <tr>
        <th>Fall-ID</th>
        <th>Hat sich der/die Nutzer/in mit dem alten Anmeldenamen bereits angemeldet? (Token erstellt)<br/>
        <span class="support_user_identifier_change_case_detail">Ob ein Token in der Tabelle auth_oidc_token gespeichert ist</span>
        </th>
        <th>Erste Aktion nach der UPN-Umbenennung<br/>
        <span class="support_user_identifier_change_case_detail">Entweder Anmeldung oder Ausführung des Tasks zur Nutzersynchronisierung</span>
        </th>
        <th>Möglicher doppelter Anmeldename<br/>
        <span class="support_user_identifier_change_case_detail">Ob die Umbenennung einen Anmeldenamenkonflikt in Moodle verursachen würde</span>
        </th>
        <th>Erwartetes Verhalten</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Ja</td>
        <td>Anmeldung</td>
        <td>Nein</td>
        <td>
            <ol>
                <li>Moodle-Nutzer/in umbenennen.</li>
                <li>auth_oidc_token wird mit neuen Werten für die Felder "username" und "oidcusername" aktualisiert.</li>
                <li>Das Feld "o365name" des Nutzerverbindungsdatensatzes in local_o365_objects wird auf den neuen Wert aktualisiert.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Ja</td>
        <td>Nutzersynchronisierung</td>
        <td>Nein</td>
        <td>
            <ol>
                <li>Moodle-Nutzer/in umbenennen.</li>
                <li>Der Nutzerverbindungsdatensatz in local_o365_objects wird aktualisiert.</li>
                <li>auth_oidc_token wird aktualisiert.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>Nein</td>
        <td>Anmeldung</td>
        <td>Nein</td>
        <td>
            <ol>
                <li>Moodle-Nutzer/in umbenennen.</li>
                <li>Der Nutzerverbindungsdatensatz in local_o365_objects wird aktualisiert.</li>
                <li>auth_oidc_token wird aktualisiert.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>Nein</td>
        <td>Nutzersynchronisierung</td>
        <td>Nein</td>
        <td>
            <ol>
                <li>Moodle-Nutzer/in umbenennen.</li>
                <li>Der Nutzerverbindungsdatensatz in local_o365_objects wird aktualisiert.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>Ja</td>
        <td>Anmeldung</td>
        <td>Ja</td>
        <td>
            <ol>
                <li>Ausnahme auslösen und Moodle-Nutzer/in nicht umbenennen.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>Ja</td>
        <td>Nutzersynchronisierung</td>
        <td>Ja</td>
        <td>
            <ol>
                <li>Beim Durchlauf des Tasks zur Nutzersynchronisierung eine Fehlermeldung anzeigen, dass die Umbenennung fehlgeschlagen ist.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>Nein</td>
        <td>Anmeldung</td>
        <td>Ja</td>
        <td>
            <ol>
                <li>Ausnahme auslösen und Moodle-Nutzer/in nicht umbenennen.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>Nein</td>
        <td>Nutzersynchronisierung</td>
        <td>Ja</td>
        <td>
            <ol>
                <li>Beim Durchlauf des Tasks zur Nutzersynchronisierung eine Fehlermeldung anzeigen, dass die Umbenennung fehlgeschlagen ist.</li>
            </ol>
        </td>
    </tr>
</table>
Beachten Sie das bekannte Problem: Wenn
<ol>
<li>Moodle und Microsoft 365 über die Verbindungsmethode "Microsoft identity platform (v2.0)" verbunden sind und</li>
<li>Microsoft Entra so konfiguriert ist, dass "E-Mail als alternative Anmelde-ID" verwendet werden darf, und</li>
<li>diese Option aktiviert ist und</li>
<li>Anmeldename und E-Mail-Adresse des Microsoft-Kontos sich unterscheiden und</li>
<li>der/die Microsoft-Nutzer/in sich mit der E-Mail-Adresse statt mit dem Anmeldenamen anmeldet,</li>
</ol>
behandelt das Plugin auth_oidc die E-Mail-Adresse als Anmeldenamen des Microsoft-Kontos und aktualisiert den Moodle-Anmeldenamen.';

// User field mapping.
$string['settings_fieldmap'] = 'Zuordnung der Nutzerfelder';
$string['settings_fieldmap_details'] = 'Verfügbar im <a href="{$a}">OpenID Connect-Authentifizierungsplugin</a>.';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'Kurssynchronisierung';
$string['settings_secthead_coursesync_desc'] = 'Die folgenden Einstellungen steuern die Kurssynchronisierung zwischen Moodle und Microsoft Teams.';
$string['settings_coursesync'] = 'Kurssynchronisierung';
$string['settings_coursesync_details'] = 'Wenn aktiviert, werden Teams für Kurse auf der Moodle-Website erstellt und gepflegt (Standard: deaktiviert). Bei jedem Cron-Durchlauf werden alle benötigten Teams erstellt und alle aktuell eingeschriebenen Nutzer/innen je nach Rechteprüfung als Teambesitzer/innen oder Teammitglieder hinzugefügt. Danach wird die Teammitgliedschaft gepflegt, wenn Nutzer/innen in Moodle-Kurse eingeschrieben oder daraus abgemeldet werden.';
$string['acp_coursesynccustom_off'] = 'Deaktiviert<br />Erstellung von Teams für alle Kurse deaktivieren.';
$string['acp_coursesynccustom_oncustom'] = 'Anpassen<br />Ermöglicht berechtigten Nutzer/innen, auszuwählen, für welche Kurse Teams erstellt werden.<br> <span id="adminsetting_coursesync" style="font-weight: bold"><a href="{$a}">Kurssynchronisierung anpassen</a></span>';
$string['acp_coursesynccustom_onall'] = 'Alle Funktionen aktiviert<br />Aktiviert die Erstellung von Teams für alle Kurse.';
$string['settings_coursesync_sync_hidden_courses'] = 'Verborgene Kurse synchronisieren';
$string['settings_coursesync_sync_hidden_courses_desc'] = 'Standardmäßig ignoriert das Plugin verborgene Kurse, um zu verhindern, dass Kurse synchronisiert werden, die gerade kopiert oder wiederhergestellt werden. Aktivieren Sie diese Einstellung, um die Erstellung von Teams für verborgene Kurse zu erzwingen.';
$string['acp_coursesync_hidden_course_note'] = 'Hinweis: Verborgene Kurse werden bei der Erstellung von Teams-Gruppen nicht verarbeitet. Um dies zu ermöglichen, müssen Sie die Einstellung "Verborgene Kurse synchronisieren" in der Plugin-Konfiguration aktivieren.';
$string['settings_coursesync_delete_group_on_course_deletion'] = 'Microsoft 365-Gruppen löschen, wenn der verbundene Moodle-Kurs gelöscht wird';
$string['settings_coursesync_delete_group_on_course_deletion_details'] = 'Wenn aktiviert, versucht Moodle, die Microsoft 365-Gruppe (und das zugehörige Team) zu löschen, wenn der verbundene Kurs aus Moodle gelöscht wird. Dies gilt nicht für Kurse, die durch die SDS-Synchronisierung erstellt wurden.';
$string['settings_coursesync_delete_group_on_course_sync_disabled'] = 'Microsoft 365-Gruppen löschen, wenn die Kurssynchronisierung deaktiviert wird';
$string['settings_coursesync_delete_group_on_course_sync_disabled_details'] = 'Wenn aktiviert, versucht Moodle, die verbundene Microsoft 365-Gruppe (und das zugehörige Team) zu löschen, wenn die Kurssynchronisierung für einen Moodle-Kurs deaktiviert wird.';
$string['settings_coursesync_courses_per_task'] = 'Zu synchronisierende Kurse pro Task-Durchlauf';
$string['settings_coursesync_courses_per_task_details'] = 'Die Anzahl der Kurse, deren Team-/Gruppensynchronisierungsstatus bei jedem Task-Durchlauf verarbeitet wird.';
$string['settings_coursesync_team_type'] = 'Teamvorlage';
$string['settings_coursesync_team_type_desc'] = 'Die Microsoft Teams-Vorlage, die beim Erstellen von Teams aus Moodle-Kursen verwendet wird. Bildungsvorlagen erfordern eine Bildungslizenz. <br><br><strong>Wichtig:</strong> Die konfigurierte Vorlage bestimmt, wie Gruppen und Teams erstellt werden:<br>
&bull; Die Standardvorlage erstellt Standardgruppen und -teams (mit allen Mandanten kompatibel).<br>
&bull; Bildungsvorlagen erstellen Bildungsgruppen/-teams (nur Bildungsmandanten; aktiviert bildungsspezifische Funktionen).<br>
&bull; Benutzerdefinierte Vorlagen verwenden Standardgruppen (zur Kompatibilität mit dem Design benutzerdefinierter Vorlagen).<br><br>
<strong>⚠️ WARNUNG: Sobald ein Team mit einer bestimmten Vorlage erstellt wurde, kann die Vorlage nicht mehr geändert werden.</strong> Teams bleiben ihrer ursprünglichen Vorlage zugeordnet. Eine Änderung dieser Einstellung wirkt sich nur auf neu erstellte Teams aus, nicht auf bestehende. Planen Sie die Auswahl der Vorlage sorgfältig, bevor Sie die Kurssynchronisierung aktivieren.';
$string['settings_coursesync_team_type_standard'] = 'Standard';
$string['settings_coursesync_team_type_educationclass'] = 'Bildung - Kursteam';
$string['settings_coursesync_team_type_educationstaff'] = 'Bildung - Mitarbeiterteam';
$string['settings_coursesync_team_type_educationplc'] = 'Bildung - Professionelle Lerngemeinschaft (PLC)';
$string['settings_coursesync_team_type_custom'] = 'Benutzerdefinierte Vorlage';
$string['settings_coursesync_team_type_custom_id'] = 'ID der benutzerdefinierten Vorlage';
$string['settings_coursesync_team_type_custom_id_desc'] = 'Die vollständige ID einer im Teams Admin Center definierten benutzerdefinierten Vorlage. Wird nur verwendet, wenn oben "Benutzerdefinierte Vorlage" ausgewählt ist. <br><br><strong>Die Vorlagen-ID muss im GUID-Format vorliegen</strong> (z. B. e41de7bb-859a-4a0f-aa39-5725a0529c1c). Sie finden die Vorlagen-ID im Teams Admin Center in den Details Ihrer benutzerdefinierten Vorlage. <br><br>
<strong>⚠️ ZUSÄTZLICHE MICROSOFT ENTRA ID-BERECHTIGUNG ERFORDERLICH:</strong> Das Validieren und Verwenden benutzerdefinierter Teamvorlagen erfordert eine zusätzliche Microsoft Graph API-Anwendungsberechtigung (<strong>TeamTemplates.Read.All</strong>), die in Ihrer Microsoft Entra ID-App-Registrierung möglicherweise nicht vorhanden ist. Ohne diese Berechtigung schlägt die Validierung fehl und die ID der benutzerdefinierten Vorlage kann nicht festgelegt werden. Wenn die Validierung mit einem Berechtigungsfehler fehlschlägt, bitten Sie Ihre/n Microsoft Entra ID-Administrator/in, diese Berechtigung zu Ihrer App-Registrierung hinzuzufügen. <br><br>
<strong>⚠️ WICHTIGE EINSCHRÄNKUNG:</strong> Das Microsoft Teams-Framework unterstützt derzeit das Erstellen von Teams aus benutzerdefinierten Vorlagen nur, wenn die Vorlage eine <strong>en-US-Gebietsschemadefinition</strong> enthält. Mit benutzerdefinierten Vorlagen ohne en-US-Gebietsschema können keine Teams erstellt werden. Stellen Sie sicher, dass für Ihre benutzerdefinierte Vorlage im Teams Admin Center ein en-US-Gebietsschema definiert ist. <br><br>
<strong>⚠️ WARNUNG: Sobald ein Team mit dieser benutzerdefinierten Vorlage erstellt wurde, kann die Vorlage nicht mehr geändert werden.</strong> Wenn Sie für neue Teams eine andere benutzerdefinierte Vorlage verwenden möchten, müssen Sie diese Einstellung leer lassen oder sie vor der nächsten Teamerstellung ändern. Bestehende Teams verwenden weiterhin ihre ursprüngliche Vorlage. <br><br>
Teams werden nicht korrekt erstellt, wenn eine falsche Vorlagen-ID konfiguriert ist. Verwenden Sie die Schaltfläche "ID der benutzerdefinierten Vorlage validieren", um die Vorlagen-ID vor der Kurssynchronisierung zu validieren.';
$string['error_custom_template_id_required'] = 'Bei Verwendung der Option "Benutzerdefinierte Vorlage" ist eine ID der benutzerdefinierten Vorlage erforderlich. Bitte geben Sie eine gültige Vorlagen-ID ein.';
$string['error_custom_template_id_not_found'] = 'Die ID der benutzerdefinierten Vorlage "{$a}" wurde nicht gefunden. Bitte prüfen Sie, ob die Vorlagen-ID im Teams Admin Center vorhanden ist.';
$string['error_custom_template_id_validation_failed'] = 'Die Validierung der ID der benutzerdefinierten Vorlage ist fehlgeschlagen. Möglicherweise unterstützt die Vorlage das direkte Erstellen von Teams nicht oder es liegt ein Konfigurationsproblem vor. Bitte prüfen Sie die Vorlagen-ID im Teams Admin Center.';
$string['settings_team_type_custom_id_test_button'] = 'ID der benutzerdefinierten Vorlage validieren';
$string['settings_team_type_custom_id_validating'] = '🔄 Wird validiert...';
$string['settings_team_type_custom_id_error_empty'] = '⚠️ Bitte geben Sie zuerst eine Vorlagen-ID ein.';
$string['settings_team_type_custom_id_error_not_found'] = '✗ Vorlage nicht gefunden. Die Vorlagen-ID "{$a}" existiert nicht. Bitte prüfen Sie sie im Teams Admin Center.';
$string['settings_team_type_custom_id_error_validation'] = '✗ Validierungsfehler. {$a}';
$string['settings_team_type_custom_id_error_default'] = 'Die Vorlage konnte nicht validiert werden. Bitte versuchen Sie es erneut oder wenden Sie sich an Ihre/n Administrator/in.';
$string['settings_team_type_custom_id_error_timeout'] = '✗ Zeitüberschreitung bei der Validierung. Die Anfrage hat länger als 10 Sekunden gedauert. Bitte versuchen Sie es erneut.';
$string['settings_team_type_custom_id_error_network'] = '✗ Netzwerkfehler. Der Validierungsdienst ist nicht erreichbar. Bitte prüfen Sie Ihre Internetverbindung und versuchen Sie es erneut.';
$string['settings_team_type_custom_id_error_parsererror'] = '✗ Fehler in der Serverantwort. Der Validierungsdienst hat ungültige Daten zurückgegeben. Bitte prüfen Sie Ihre Microsoft 365-Integration.';
$string['settings_team_type_custom_id_error_http'] = '✗ Validierungsfehler (HTTP {$a}). Bitte versuchen Sie es erneut oder wenden Sie sich an Ihre/n Administrator/in.';
$string['settings_coursesync_group_channels'] = 'Einen Kanal für jede Moodle-Gruppe erstellen';
$string['settings_coursesync_group_channels_details'] = 'Erstellt im verbundenen Microsoft-Team für jede Gruppe des Moodle-Kurses einen privaten Kanal und hält die Mitglieder jedes Kanals mit den Mitgliedern der Moodle-Gruppe abgeglichen. Gruppenmitglieder, die ebenfalls mit Microsoft 365 verbunden sind, werden dem Kanal hinzugefügt bzw. daraus entfernt, wenn sie der Gruppe hinzugefügt bzw. daraus entfernt werden. Personen, die in Microsoft Teams zu einem Kanal hinzugefügt werden, aber nicht Mitglied der Moodle-Gruppe sind, werden wieder entfernt. In einem Bildungs-Kursteam, das noch nicht aktiviert wurde, können Teilnehmer/innen nicht in Kanäle aufgenommen werden: Nur die Besitzer/innen werden hinzugefügt, und die Teilnehmer/innen werden automatisch durch den geplanten Task "Teams-Kanäle für Moodle-Gruppen erstellen und deren Mitglieder synchronisieren" hinzugefügt, nachdem ein/e Besitzer/in das Team in Microsoft Teams aktiviert hat. Kanäle werden nicht umbenannt oder gelöscht, wenn eine Moodle-Gruppe umbenannt oder gelöscht wird. Die Kanalmitgliedschaft wird immer nur von Moodle nach Teams synchronisiert, und diese Einstellung hat keine Wirkung, wenn "Verhalten der Kursnutzersynchronisierung" auf "Von Teams nach Moodle" gesetzt ist. Microsoft Teams erlaubt bis zu 1.000 Kanäle pro Team, einschließlich privater Kanäle und Kanäle, die in den letzten 30 Tagen gelöscht wurden.<br /><br /><b>Diese Einstellung benötigt zwei zusätzliche Microsoft Graph-Anwendungsberechtigungen:</b><ul><li><b>Channel.Create</b> – zum Erstellen der Kanäle.</li><li><b>ChannelMember.ReadWrite.All</b> – zum Hinzufügen und Entfernen von Kanalmitgliedern.</li></ul>Beide müssen zur von Moodle verwendeten Microsoft Entra ID-Anwendung hinzugefügt und mit Administratorzustimmung erteilt werden. Das PowerShell-Skript auf der Registerkarte "Einrichtung" enthält sie bereits, wenn es eine neue Anwendung registriert. Fügen Sie sie bei einer bereits vorhandenen Anwendung manuell unter App-Registrierungen &gt; Ihre Anwendung &gt; API-Berechtigungen &gt; Berechtigung hinzufügen &gt; Microsoft Graph &gt; Anwendungsberechtigungen hinzu und erteilen Sie anschließend die Administratorzustimmung. Solange diese Einstellung aktiviert ist, meldet "Einrichtung überprüfen" auf der Registerkarte "Einrichtung" diese Berechtigungen als fehlend, bis sie erteilt wurden.';
$string['settings_coursesync_sync_direction'] = 'Verhalten der Kursnutzersynchronisierung';
$string['settings_coursesync_sync_direction_details'] = 'Wählen Sie die Richtung, in der Nutzer/innen zwischen Moodle und Microsoft Teams synchronisiert werden sollen.';
$string['settings_coursesync_sync_moodle_to_teams'] = 'Von Moodle nach Teams';
$string['settings_coursesync_sync_teams_to_moodle'] = 'Von Teams nach Moodle';
$string['settings_coursesync_sync_both'] = 'Sowohl Teams als auch Moodle aktualisieren';
$string['settings_coursesync_enrolment_owner_role'] = 'Rolle für Teambesitzer/innen';
$string['settings_coursesync_enrolment_owner_role_desc'] = 'Die Rolle, die Teambesitzer/innen während der Synchronisierung zugewiesen wird.';
$string['settings_coursesync_enrolment_member_role'] = 'Rolle für Teammitglieder';
$string['settings_coursesync_enrolment_member_role_desc'] = 'Die Rolle, die Teammitgliedern während der Synchronisierung zugewiesen wird.';

// Settings in the "Course sync customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_coursesynccustom'] = 'Anpassung der Kurssynchronisierung';
$string['acp_coursesynccustom_enabled'] = 'Aktiviert';
$string['acp_coursesynccustom_enable_all'] = 'Kurssynchronisierung für alle Kurse aktivieren';
$string['acp_coursesynccustom_disable_all'] = 'Kurssynchronisierung für alle Kurse deaktivieren';
$string['acp_coursesynccustom_bulk'] = 'Massenoperationen';
$string['acp_coursesynccustom_bulk_enable'] = 'Kurssynchronisierung für die Kurse auf dieser Seite aktivieren';
$string['acp_coursesynccustom_bulk_disable'] = 'Kurssynchronisierung für die Kurse auf dieser Seite deaktivieren';
$string['acp_coursesynccustom_settings_header'] = 'Synchronisierungsoptionen';
$string['acp_coursesynccustom_new_course'] = 'Für neue Kurse standardmäßig aktiviert';
$string['acp_coursesynccustom_new_course_desc'] = 'Wenn aktiviert, ist die Synchronisierung für alle neu erstellten Kurse standardmäßig aktiviert.';
$string['acp_coursesynccustom_controlled_per_course'] = 'Konfiguration der Kurssynchronisierung in Kursen erlauben';
$string['acp_coursesynccustom_controlled_per_course_desc'] = 'Wenn aktiviert, können in Moodle-Kurse eingeschriebene Nutzer/innen, die als Teambesitzer/innen in Frage kommen (mit dem Recht "Teambesitzer/in" [local/o365:teamowner]), die Kurssynchronisierung über den Microsoft-Block im Kurs steuern.';
$string['acp_coursesynccustom_savemessage'] = 'Ihre Änderungen wurden gespeichert.';
$string['acp_coursesynccustom_regex_search'] = 'Regex-Suche';
$string['acp_coursesynccustom_regex_search_title'] = 'Wenn aktiviert, wird der Inhalt des Suchfelds oben als regulärer PCRE-Ausdruck (ohne Begrenzer) mit vollständigem Kursnamen, kurzem Kursnamen und ID-Nummer abgeglichen, statt eine einfache Textsuche durchzuführen.';
$string['acp_coursesynccustom_confirm_all_action'] = 'Möchten Sie den Synchronisierungsstatus aller Kurse wirklich ändern? Diese Aktion kann nicht rückgängig gemacht werden.';
$string['acp_coursesynccustom_sds_course'] = 'Für SDS-Kurs gesperrt';
$string['acp_coursesynccustom_all_enabled_notice'] = 'Die Kurssynchronisierung ist derzeit für alle Kurse aktiviert. Die Anpassung einzelner Kurse ist deaktiviert, weil der Modus "Alle Funktionen aktiviert" aktiv ist.';
$string['acp_coursesynccustom_disabled_notice'] = 'Die Kurssynchronisierung ist derzeit global deaktiviert. Die Anpassung einzelner Kurse ist deaktiviert, weil der Modus "Deaktiviert" aktiv ist.';
$string['acp_coursesynccustom_categories_header'] = 'Synchronisierung nach Kursbereich';
$string['acp_coursesynccustom_categories_desc'] = 'Wählen Sie einen oder mehrere Kursbereiche aus, um die Kurssynchronisierung für alle Kurse in diesen Kursbereichen einschließlich ihrer Unterbereiche automatisch zu aktivieren. Dies gilt auch für Kurse, die den ausgewählten Kursbereichen später hinzugefügt werden. Halten Sie Strg (Cmd auf dem Mac) gedrückt, um mehrere Kursbereiche auszuwählen, oder klicken Sie mit gedrückter Taste erneut, um die Auswahl aufzuheben.';
$string['acp_coursesynccustom_category_course'] = 'Gesperrt: durch Kursbereich aktiviert';

// Settings in the "Cohort sync" section of the "Sync settings" tab.
$string['settings_secthead_cohortsync'] = 'Synchronisierung globaler Gruppen';
$string['settings_secthead_cohortsync_desc'] = 'Diese Funktion ermöglicht die Synchronisierung zwischen Microsoft 365-Gruppen und globalen Gruppen in Moodle.';
$string['settings_cohortsync'] = 'Synchronisierung globaler Gruppen';
$string['settings_cohortsync_linktext'] = 'Synchronisierung globaler Gruppen verwalten';
$string['settings_cohortsync_details'] = 'Synchronisierung zwischen globalen Gruppen in Moodle und Microsoft 365-Gruppen prüfen und verwalten.';
$string['settings_cohortsync_title'] = 'Synchronisierung globaler Gruppen';
$string['settings_cohortsync_excludeowners'] = 'Gruppenbesitzer/innen von der Synchronisierung globaler Gruppen ausschließen';
$string['settings_cohortsync_excludeowners_desc'] = 'Wenn aktiviert, werden Gruppenbesitzer/innen nicht mit globalen Gruppen in Moodle synchronisiert, auch wenn sie ebenfalls Gruppenmitglieder sind. Besitzer/innen, die bereits in einer globalen Gruppe sind, werden beim nächsten Synchronisierungsdurchlauf entfernt.';

// Settings in the "Team / group names" section of the "Sync settings" tab.
$string['settings_secthead_team_group_name'] = 'Team-/Gruppennamen';
$string['settings_secthead_team_group_name_desc'] = 'Wenn ein Kurs für die Synchronisierung konfiguriert ist, wird der Name des Teams und der Gruppe wie folgt gebildet.<br/>
<ul>
<li>Gruppen-Mail-Alias und Team-Anzeigenamen können festgelegt werden.</li>
<li>Zuerst wird die Microsoft 365-Gruppe mit dem konfigurierten Gruppen-mailNickname und Team-Anzeigenamen erstellt, und anschließend wird aus der Gruppe ein Team erstellt.</li>
<li>Wenn die Microsoft Entra ID-Benennungsrichtlinie für Microsoft 365-Gruppen verwendet wird, werden keine Gruppen erstellt, wenn der gemäß der Konfiguration gebildete Anzeigename nicht den Richtlinien entspricht.</li>
<li>Hier vorgenommene Änderungen wirken sich nur auf künftig erstellte Teams aus, nicht auf bestehende.</li>
<li>Alle Leerzeichen werden aus dem Gruppen-Mail-Alias entfernt.</li>
<li>Im Gruppen-Mail-Alias sind nur Groß- und Kleinbuchstaben, Ziffern, - und _ erlaubt.</li>
<li>Der Gruppen-Mail-Alias darf einschließlich Präfix und Suffix 64 Zeichen nicht überschreiten.</li>
<li>Der Mail-Alias der Gruppe muss eindeutig sein, andernfalls wird eine zufällige 4-stellige Zahl angehängt, um die Eindeutigkeit sicherzustellen.</li>
</ul>';
$string['settings_team_name_prefix'] = 'Präfix des Teamnamens';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'Kursbestandteil des Teamnamens';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'Suffix des Teamnamens';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_group_mail_alias_prefix'] = 'Präfix des Gruppen-Mail-Alias';
$string['settings_group_mail_alias_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'Kursbestandteil des Gruppen-Mail-Alias';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'Suffix des Gruppen-Mail-Alias';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'Angenommen, ein Kurs hat folgende Werte:
<ul>
<li>Vollständiger Kursname: <b>Sample course</b></li>
<li>Kurzer Kursname: <b>sample 15</b></li>
<li>Von Moodle erstellte ID: <b>2</b></li>
<li>ID-Nummer: <b>Sample ID 15</b></li>
</ul>
Mit Ihrer aktuellen Einstellung wird eine Gruppe mit dem Mail-Alias "<b>{$a->mailalias}</b>" und ein Team mit dem Namen "<b>{$a->teamname}</b>" erstellt.<br/>
Klicken Sie unten auf "Änderungen speichern", um zu sehen, wie sich Ihre Einstellungen darauf auswirken.';
$string['settings_main_name_option_full_name'] = 'Vollständiger Kursname';
$string['settings_main_name_option_short_name'] = 'Kurzer Kursname';
$string['settings_main_name_option_id'] = 'Von Moodle erstellte ID';
$string['settings_main_name_option_id_number'] = 'ID-Nummer';
$string['settings_team_name_sync'] = 'Teamnamen bei Kursaktualisierung aktualisieren';
$string['settings_team_name_sync_desc'] = 'Wenn aktiviert, wird beim Aktualisieren eines Moodle-Kurses der Name des Teams gemäß den aktuellen Einstellungen für Teamnamen aktualisiert.';

// Settings in the "Course request" section of the "Sync settings" tab.
$string['settings_secthead_course_request'] = 'Kursanfrage';
$string['settings_secthead_course_request_desc'] = 'Einstellungen für Rollenzuordnungen bei der Funktion für Kursanfragen aus Teams.';
$string['settings_course_request_enrolment_owner_role'] = 'Rolle für Teambesitzer/innen';
$string['settings_course_request_enrolment_owner_role_desc'] = 'Die Rolle, die Teambesitzer/innen zugewiesen wird, wenn die Kursanfrage genehmigt wird.';
$string['settings_course_request_enrolment_member_role'] = 'Rolle für Teammitglieder';
$string['settings_course_request_enrolment_member_role_desc'] = 'Die Rolle, die Teammitgliedern zugewiesen wird, wenn die Kursanfrage genehmigt wird.';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'Werkzeuge';
$string['settings_secthead_calsync'] = 'Kalendersynchronisierung';
$string['settings_calsyncsubscribemode'] = 'Abonnement der Kalendersynchronisierung';
$string['settings_calsyncsubscribemode_details'] = 'Legt fest, ob Nutzer/innen die Outlook-Kalendersynchronisierung selbst aktivieren müssen.<ul><li><b>Opt-in</b>: Nutzer/innen aktivieren die Kalendersynchronisierung und wählen auf ihrer Seite mit den Einstellungen zur Kalendersynchronisierung die zu synchronisierenden Kalender aus.</li><li><b>Opt-out</b>: Bei mit Microsoft 365 verbundenen Nutzer/innen wird die Kalendersynchronisierung automatisch aktiviert und sie werden für die unten ausgewählten Kalender angemeldet (bei Kursen für alle Kurse, in die sie jetzt und künftig eingeschrieben sind). Synchronisiert wird von Moodle in ihren primären Outlook-Kalender. Nutzer/innen können dies auf ihrer Seite mit den Einstellungen zur Kalendersynchronisierung weiterhin ändern oder deaktivieren, und Nutzer/innen, die die Kalendersynchronisierung deaktivieren, werden nicht erneut angemeldet.</li></ul>Ein Zurückwechseln zu "Opt-in" entfernt vorhandene Abonnements nicht.';
$string['settings_calsyncsubscribetypes'] = 'Kalender, für die Nutzer/innen automatisch angemeldet werden';
$string['settings_calsyncsubscribetypes_details'] = 'Gilt nur für "Opt-out". Wählen Sie aus, für welche Moodle-Kalender verbundene Nutzer/innen automatisch angemeldet werden. Werden alle für den Website-Kalender angemeldet, wird jede/r Nutzer/in als Teilnehmer/in zu jedem Website-Termin hinzugefügt, daher ist diese Option standardmäßig nicht ausgewählt.';
$string['settings_calsyncsubscribetypes_site'] = 'Website-Kalender';
$string['settings_calsyncsubscribetypes_user'] = 'Persönlicher Kalender';
$string['settings_calsyncsubscribetypes_course'] = 'Kurskalender (alle Kurse, in die der/die Nutzer/in eingeschrieben ist)';
$string['settings_calsyncsubscribemode_optin'] = 'Opt-in (Nutzer/innen aktivieren die Kalendersynchronisierung selbst)';
$string['settings_calsyncsubscribemode_optout'] = 'Opt-out (Kalendersynchronisierung für alle verbundenen Nutzer/innen automatisch aktivieren)';
$string['settings_secthead_advanced'] = 'Erweiterte Einstellungen';
$string['settings_secthead_advanced_desc'] = 'Diese Einstellungen steuern weitere Funktionen der Plugin-Suite. Vorsicht! Sie können unbeabsichtigte Auswirkungen haben.';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'Mandanten';
$string['settings_tools_tenants_linktext'] = 'Zusätzliche Mandanten konfigurieren';
$string['settings_tools_tenants_details'] = 'Zugriff auf zusätzliche Microsoft Entra-Mandanten verwalten.';
$string['settings_healthcheck'] = 'Health Check';
$string['settings_healthcheck_details'] = 'Wenn etwas nicht ordnungsgemäß funktioniert, kann ein Health Check das Problem in der Regel ermitteln und Lösungen vorschlagen.';
$string['settings_healthcheck_linktext'] = 'Health Check ausführen';
$string['settings_userconnections'] = 'Nutzerverbindungen';
$string['settings_userconnections_linktext'] = 'Nutzerverbindungen verwalten';
$string['settings_userconnections_details'] = 'Verbindungen zwischen Moodle- und Microsoft 365-Nutzer/innen prüfen und verwalten.';
$string['settings_teamconnections'] = 'Teamverbindungen';
$string['settings_teamconnections_linktext'] = 'Teamverbindungen verwalten';
$string['settings_teamconnections_details'] = 'Verbindungen zwischen Moodle-Kursen und Microsoft Teams prüfen und verwalten.';
$string['settings_usermatch'] = 'Nutzerzuordnung';
$string['settings_usermatch_details'] = 'Mit diesem Werkzeug können Sie Moodle-Nutzer/innen anhand einer hochgeladenen Datendatei Microsoft 365-Nutzer/innen zuordnen.';
$string['settings_usersyncgroupfilter'] = 'Gruppenfilter für die Nutzersynchronisierung';
$string['settings_usersyncgroupfilter_details'] = 'Wenn hier eine Gruppenobjekt-ID (GUID) eingegeben wird, werden vollständige Nutzersynchronisierungen auf Mitglieder und Besitzer/innen dieser Microsoft 365-Gruppe beschränkt. Lassen Sie das Feld leer, um alle lizenzierten Nutzer/innen in Ihrem Mandanten zu synchronisieren.<br><br>
<strong>VORSICHT: Dies ist eine erweiterte Einstellung. Eine Fehlkonfiguration kann erhebliche Probleme bei der Datensynchronisierung verursachen.</strong><br><br>
<strong>Wenn konfiguriert, gilt Folgendes:</strong><br>
(1) Profil-, Zeitzonen- und Bildaktualisierungen werden nur für Nutzer/innen übernommen, die Mitglieder oder Besitzer/innen der Gruppe sind<br>
(2) Neue Moodle-Konten werden nur für Nutzer/innen erstellt, die Mitglieder oder Besitzer/innen der Gruppe sind<br>
(3) Moodle-Konten von Nicht-Mitgliedern erhalten keine Aktualisierungen mehr und können von Microsoft 365 abweichen<br>
(4) In Microsoft 365 deaktivierte Nutzer/innen werden weiterhin durch die Synchronisierung des Aktivierungsstatus in Moodle gesperrt, die unabhängig von der Gruppenfilterung ausgeführt wird<br>
(5) Wird ein/e Nutzer/in aus der Gruppe entfernt, wird das Konto künftig nicht mehr synchronisiert. Das Moodle-Konto wird nicht gelöscht und nur dann gesperrt, wenn die Option "Konten in Moodle sperren, wenn sie nicht in der konfigurierten Gruppe für die Nutzersynchronisierung sind" aktiviert ist. Diese sperrt alle synchronisierten Nutzer/innen, die nicht in der Gruppe sind, unabhängig davon, ob sie jemals Mitglied waren<br><br>
<strong>Einschränkung der inkrementellen (Delta-)Synchronisierung:</strong> Microsoft Graph unterstützt keine Delta-Abfragen für Endpunkte der Gruppenmitgliedschaft. Wenn diese Einstellung konfiguriert ist, führen Delta-Synchronisierungen statt einer inkrementellen Aktualisierung eine vollständige Synchronisierung der Gruppenmitglieder durch. Dies ist korrektes Verhalten, kann aber langsamer sein als eine normale Delta-Synchronisierung.<br><br>
Validieren Sie die Gruppenobjekt-ID vor dem Speichern. Geben Sie die Gruppenobjekt-ID (GUID) ein.';
$string['settings_usersyncgroupfilter_validation_error'] = 'Ungültiges Format der Gruppen-ID. Die Gruppen-ID muss eine gültige GUID sein (z. B. 550e8400-e29b-41d4-a716-446655440000).';
$string['settings_usersynccreationrestriction'] = 'Einschränkung der Nutzererstellung';
$string['settings_usersynccreationrestriction_details'] = 'Wenn aktiviert, werden bei der Nutzersynchronisierung nur Microsoft Entra ID-Nutzer/innen erstellt, die die Bedingung erfüllen. Geben Sie für "Microsoft 365-Gruppenmitgliedschaft (Gruppenobjekt-ID)" eine Gruppenobjekt-ID oder mehrere durch Kommas getrennte Gruppenobjekt-IDs ein.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Feldwert';
$string['settings_usersynccreationrestriction_o365group'] = 'Microsoft 365-Gruppenmitgliedschaft (Gruppenname)';
$string['settings_usersynccreationrestriction_o365groupid'] = 'Microsoft 365-Gruppenmitgliedschaft (Gruppenobjekt-ID)';
$string['settings_usersynccreationrestriction_invalidgroupid'] = 'Die Microsoft 365-Gruppenobjekt-ID "{$a}" wurde nicht gefunden. Prüfen Sie die ID und versuchen Sie es erneut.';
$string['settings_usersynccreationrestriction_groupvalidationerror'] = 'Die Microsoft 365-Gruppenobjekt-IDs konnten nicht validiert werden. Prüfen Sie die IDs und die Microsoft Graph-Konfiguration und versuchen Sie es dann erneut.';
$string['settings_usersynccreationrestriction_regex'] = 'Wert ist ein regulärer Ausdruck';
$string['settings_maintenance'] = 'Wartung';
$string['settings_maintenance_details'] = 'Verschiedene Wartungsvorgänge stehen zur Verfügung, um einige häufige Probleme zu beheben.';
$string['settings_maintenance_linktext'] = 'Wartungswerkzeuge anzeigen';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'Mandantenfähigkeit';
$string['acp_tenants_title_desc'] = 'Auf dieser Seite können Sie den mandantenübergreifenden Zugriff von Microsoft 365 auf Moodle einrichten.';
$string['acp_tenants_add'] = 'Neuen Mandanten hinzufügen';
$string['acp_tenants_errornotsetup'] = 'Bitte schließen Sie die Einrichtung des Plugins ab, bevor Sie zusätzliche Mandanten hinzufügen.';
$string['acp_tenants_hosttenant'] = 'Host-Mandant: {$a}';
$string['acp_tenants_intro'] = '<b>So funktioniert die Mandantenfähigkeit:</b><br />Die Mandantenfähigkeit ermöglicht mehreren Microsoft Entra-Mandanten den Zugriff auf Ihre Moodle-Website. <br /><br />
    So richten Sie sie ein:
    <ol>
        <li>Melden Sie sich in Moodle als Administrator/in an, der/die nicht das OpenID Connect-Authentifizierungsplugin verwendet.</li>
        <li>Stellen Sie sicher, dass die Einstellungen <b>Autorisierungsendpunkt</b> und <b>Token-Endpunkt</b> des OpenID Connect-Authentifizierungsplugins die standardmäßigen, nicht mandantenspezifischen Werte verwenden.</li>
        <li>Deaktivieren Sie das OpenID Connect-Authentifizierungsplugin in Moodle. (Verwenden Sie dazu <a href="{$a}/admin/settings.php?section=manageauths">die Verwaltungsseite der Authentifizierungsplugins</a>.)</li>
        <li>Öffnen Sie Microsoft Entra ID und suchen Sie die Anwendung, die Sie für Moodle konfiguriert haben.</li>
        <li>Aktivieren Sie die Mandantenfähigkeit in der Microsoft Entra ID-App und speichern Sie die Änderungen.</li>
        <li>Erteilen Sie der App mindestens eine der folgenden delegierten Graph-Berechtigungen: <b>Directory.Read.All</b>, <b>Domain.Read.All</b> oder <b>Domain.ReadWrite.All</b>. Eine Administratorzustimmung für Ihre Organisation ist nicht erforderlich.</li>
        <li>Wenn Sie bereits mit Ihrem Microsoft-Konto aus dem zusätzlichen Mandanten angemeldet sind, melden Sie sich vollständig ab und wieder an.</li>
        <li>Klicken Sie für jeden Mandanten, den Sie aktivieren möchten, auf "Neuen Mandanten hinzufügen" und melden Sie sich mit einem Administratorkonto dieses Mandanten an.</li>
        <li>Nachdem Sie alle gewünschten Mandanten hinzugefügt haben, aktivieren Sie das OpenID Connect-Authentifizierungsplugin in Moodle wieder.</li>
        <li>Fertig! Um künftig weitere Mandanten hinzuzufügen, klicken Sie einfach auf "Neuen Mandanten hinzufügen" und melden Sie sich mit einem Administratorkonto dieses Mandanten an.</li>
    </ol>
    <b>Wichtiger Hinweis:</b> Wenn die Mandantenfähigkeit in der Microsoft Entra ID-App aktiviert ist, können alle Microsoft Entra-Mandanten auf Ihre Anwendung zugreifen. Durch das Hinzufügen der Mandanten hier können wir den Zugriff auf Moodle auf die von Ihnen konfigurierten Mandanten beschränken. <b>Wenn Sie alle Mandanten aus dieser Liste entfernen, bevor Sie die Mandantenfähigkeit in der Microsoft Entra ID-App deaktivieren, oder die OpenID Connect-Authentifizierung in Moodle mit einer leeren Liste aktivieren, ist Ihre Moodle-Website für alle Microsoft Entra-Mandanten offen.</b>';
$string['acp_tenants_none'] = 'Sie haben keine Mandanten konfiguriert. Wenn Sie die Mandantenfähigkeit in der Microsoft Entra ID-App aktiviert haben, ist Ihre Moodle-Website möglicherweise für alle Microsoft 365-Nutzer/innen offen.';
$string['acp_tenants_revokeaccess'] = 'Zugriff widerrufen';
$string['acp_tenants_tenant'] = 'Mandant';
$string['acp_tenants_actions'] = 'Aktionen';
$string['acp_tenants_delete'] = 'Löschen';
$string['acp_tenantsadd_desc'] = 'Um einem zusätzlichen Mandanten Zugriff zu gewähren, klicken Sie auf die Schaltfläche unten und melden Sie sich mit einem Administratorkonto des neuen Mandanten bei Microsoft 365 an. Sie werden dann zur Liste der zusätzlichen Mandanten zurückgeleitet, in der der neue Mandant aufgeführt ist. Anschließend können Sie Moodle mit dem neuen Mandanten verwenden.';
$string['acp_tenantsadd_linktext'] = 'Weiter zur Microsoft 365-Anmeldeseite';
$string['acp_tenants_legacy_tenants'] = 'Ältere Mandanten (Aktion erforderlich)';
$string['acp_tenants_legacy_tenants_help'] = 'Die unten aufgeführten, früher hinzugefügten zusätzlichen Mandanten funktionieren mit dem aktualisierten Ablauf für Mandantenfähigkeit möglicherweise nicht und müssen korrigiert werden.<br/>
Bitte verwenden Sie die Schaltfläche "Neuen Mandanten hinzufügen" oben, um sie erneut hinzuzufügen.';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = 'Health Check';
$string['healthcheck_fixlink'] = 'Klicken Sie hier, um das Problem zu beheben.';
$string['healthcheck_ratelimit_title'] = 'API-Drosselung';
$string['healthcheck_ratelimit_result_notice'] = 'Eine leichte Drosselung wurde aktiviert, um die erhöhte Last der Moodle-Website zu bewältigen. <br /><br />Alle Microsoft 365-Funktionen sind verfügbar. Anfragen werden lediglich leicht zeitlich gestreckt, um Unterbrechungen der Microsoft 365-Dienste zu vermeiden. Sobald die Moodle-Aktivität zurückgeht, normalisiert sich alles wieder. <br />(Stufe {$a->level} / gestartet {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'Eine stärkere Drosselung wurde aktiviert, um die erhebliche Last der Moodle-Website zu bewältigen. <br /><br />Alle Microsoft 365-Funktionen sind weiterhin verfügbar, aber Microsoft 365-Anfragen können länger dauern. Sobald die Aktivität auf der Moodle-Website zurückgeht, normalisiert sich alles wieder. <br />(Stufe {$a->level} / gestartet {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'Die Funktionen zur Ratenbegrenzung wurden deaktiviert.';
$string['healthcheck_ratelimit_result_passed'] = 'Microsoft 365-API-Aufrufe werden mit voller Geschwindigkeit ausgeführt.';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'Nutzerverbindungen verwalten';
$string['acp_userconnections_column_muser'] = 'Moodle-Nutzer/in';
$string['acp_userconnections_column_o365user'] = 'Microsoft 365-Nutzer/in';
$string['acp_userconnections_column_status'] = 'Verbindungsstatus';
$string['acp_userconnections_column_actions'] = 'Aktionen';
$string['acp_userconnections_column_usinglogin'] = 'Anmeldung verwenden';
$string['acp_userconnections_column_status_help'] = 'Der Verbindungsstatus zeigt, wie ein Moodle-Konto mit einem Microsoft 365-Konto (Microsoft Entra ID) verknüpft ist.

* **Verbunden** – Der/die Nutzer/in hat die Verbindung durch die Anmeldung in Moodle mit dem Microsoft 365-Konto abgeschlossen, oder ein/e Administrator/in hat das Konto aktiv verbunden. Funktionen wie Kalendersynchronisierung und OneDrive funktionieren für diese Person.
* **Zugeordnet** – Ein/e Administrator/in (oder das Werkzeug zur Massenzuordnung von Nutzer/innen) hat festgehalten, zu welchem Microsoft 365-Konto diese/r Moodle-Nutzer/in gehört, aber die Verbindung ist noch nicht aktiv. Sie wird bei der ersten Anmeldung mit Microsoft 365 abgeschlossen. Solange ein/e Nutzer/in nur zugeordnet ist, wird nichts synchronisiert.
* **Synchronisiert** – Das Moodle-Konto wurde durch den Task zur Nutzersynchronisierung aus Microsoft Entra ID erstellt, aber der/die Nutzer/in hat sich noch nicht angemeldet. Das Konto wird bei der ersten Anmeldung aktiviert.
* **Keine Verbindung** – Das Moodle-Konto ist mit keinem Microsoft 365-Konto verknüpft.';
$string['acp_userconnections_column_actions_help'] = 'Welche Aktionen für eine Zeile verfügbar sind, hängt vom Verbindungsstatus ab.

* **Trennen** – Entfernt die Verknüpfung zwischen dem Moodle-Konto und dem Microsoft 365-Konto. Die Person behält ihr Moodle-Konto, kann aber keine Microsoft 365-Funktionen mehr nutzen oder sich mit Microsoft 365 anmelden, bis sie sich erneut verbindet. Wird für verbundene Nutzer/innen angezeigt.
* **Erneut synchronisieren** – Führt die Microsoft 365-Datensynchronisierung für diese Person sofort aus (Profilfelder, Bild, Kalender usw.), statt auf den geplanten Task zu warten, und zeigt das Ergebnis an. Wird für verbundene und synchronisierte Nutzer/innen angezeigt.
* **Zuordnen** – Hält fest, zu welchem Microsoft 365-Konto diese/r Moodle-Nutzer/in gehört. Die Verbindung ist erst aktiv, wenn sich die Person mit Microsoft 365 anmeldet. Wird für Nutzer/innen ohne Verbindung angezeigt.
* **Zuordnung aufheben** – Entfernt eine noch nicht abgeschlossene Zuordnung. Wird für zugeordnete Nutzer/innen angezeigt.';
$string['acp_userconnections_accountstatus_active'] = 'Aktiv';
$string['acp_userconnections_accountstatus_suspended'] = 'Gesperrt';
$string['acp_userconnections_connectionstatus_connected'] = 'Verbunden';
$string['acp_userconnections_connectionstatus_matched'] = 'Zugeordnet';
$string['acp_userconnections_connectionstatus_noconnection'] = 'Keine Verbindung';
$string['acp_userconnections_connectionstatus_synced'] = 'Synchronisiert';
$string['acp_userconnections_filtering_accountstatus'] = 'Kontostatus';
$string['acp_userconnections_filtering_connectionstatus'] = 'Verbindungsstatus';
$string['acp_userconnections_filtering_muserfullname'] = 'Vollständiger Name der Moodle-Nutzer/in';
$string['acp_userconnections_filtering_musername'] = 'Moodle-Anmeldename';
$string['acp_userconnections_filtering_o365username'] = 'Microsoft 365-Anmeldename';
$string['acp_userconnections_manualmatch_title'] = 'Manuelle Nutzerzuordnung';
$string['acp_userconnections_manualmatch_details'] = 'Auf dieser Seite können Sie eine/n einzelne/n Moodle-Nutzer/in einer/m einzelnen Microsoft 365-Nutzer/in zuordnen.';
$string['acp_userconnections_manualmatch_musername'] = 'Moodle-Nutzer/in';
$string['acp_userconnections_manualmatch_uselogin'] = 'Mit Microsoft 365 anmelden';
$string['acp_userconnections_manualmatch_o365username'] = 'Microsoft 365-Anmeldename';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'Der/die Moodle-Nutzer/in ist bereits mit einer/m Microsoft 365-Nutzer/in verbunden';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'Der/die Moodle-Nutzer/in ist bereits mit einer/m Microsoft 365-Nutzer/in verbunden (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'Der/die Moodle-Nutzer/in ist bereits einer/m Microsoft 365-Nutzer/in zugeordnet';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'Der/die Microsoft 365-Nutzer/in ist bereits einer/m anderen Moodle-Nutzer/in zugeordnet';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'Der/die Microsoft 365-Nutzer/in ist bereits mit einer/m anderen Moodle-Nutzer/in verbunden';
$string['acp_userconnections_resync_nodata'] = 'Für diese Person wurden keine gespeicherten Microsoft 365-Informationen gefunden.';
$string['acp_userconnections_resync_notfound'] = 'Es wurden keine Daten synchronisiert. Das Konto "{$a->username}" ist mit dem Microsoft Entra ID-Objekt {$a->objectid} verknüpft, aber dieses Objekt wurde nicht gefunden. Der/die Nutzer/in wurde höchstwahrscheinlich in Microsoft 365 gelöscht oder deaktiviert, oder die gespeicherte Objekt-ID ist veraltet.';
$string['acp_userconnections_resync_nooutput'] = 'Die erneute Synchronisierung wurde abgeschlossen, ohne Änderungen zu melden.';
$string['acp_userconnections_table_disconnect'] = 'Trennen';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'Hierdurch wird die Verbindung des Moodle-Nutzers/der Moodle-Nutzerin "{$a}" mit Microsoft 365 getrennt. Klicken Sie auf den Link unten, um fortzufahren.';
$string['acp_userconnections_table_match'] = 'Zuordnen';
$string['acp_userconnections_table_resync'] = 'Erneut synchronisieren';
$string['acp_userconnections_table_unmatch'] = 'Zuordnung aufheben';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'Hierdurch wird die Zuordnung des Moodle-Nutzers/der Moodle-Nutzerin "{$a}" zu Microsoft 365 aufgehoben. Klicken Sie auf den Link unten, um fortzufahren.';

// Settings in the "Manage Team Connections" feature of the "Advanced" tab.
$string['acp_teamconnections'] = 'Teamverbindungen verwalten';
$string['acp_teamconnection'] = 'Teamverbindung verwalten';
$string['acp_teamconnections_actions'] = 'Aktionen';
$string['acp_teamconnections_cache_last_updated'] = 'Der Teams-Cache wurde zuletzt am {$a->lastupdated} aktualisiert. Klicken Sie <a href="{$a->updateurl}">hier</a>, um den Cache zu aktualisieren.';
$string['acp_teamconnections_cache_never_updated'] = 'Der Teams-Cache wurde noch nie aktualisiert. Klicken Sie <a href="{$a->updateurl}">hier</a>, um ihn zu aktualisieren.';
$string['acp_teamconnections_connected_team'] = 'Verbundenes Team';
$string['acp_teamconnections_course_connected'] = 'Der Kurs wurde erfolgreich mit dem Team verbunden.';
$string['acp_teamconnections_course_disconnected'] = 'Die Verbindung des Kurses mit dem Team wurde getrennt.';
$string['acp_teamconnections_team_linked'] = 'Der Kurs wurde mit dem Team verknüpft.';
$string['acp_teamconnections_current_connection'] = 'AKTUELLE VERBINDUNG';
$string['acp_teamconnections_exception_course_not_exist'] = 'Der zu verbindende Kurs existiert nicht.';
$string['acp_teamconnections_exception_invalid_team_id'] = 'Ungültige Team-ID';
$string['acp_teamconnections_exception_not_configured'] = 'Microsoft 365 ist nicht vollständig konfiguriert.';
$string['acp_teamconnections_exception_team_already_connected'] = 'Das Team ist bereits mit einem anderen Kurs verbunden';
$string['acp_teamconnections_form_connect_course'] = 'Teamverbindung für Kurs {$a} verwalten';
$string['acp_teamconnections_form_sds_warning'] = 'HINWEIS: Teams, die durch Student Data Sync (SDS) erstellt wurden, können hier nicht manuell verbunden werden, da dies zu Konflikten mit der SDS-Synchronisierung führen würde. Sie sind in den Suchergebnissen unten nicht enthalten.';
$string['acp_teamconnections_form_team'] = 'Team auswählen';
$string['acp_teamconnections_form_team_noselection'] = 'Nach einem Team suchen...';
$string['acp_teamconnections_no_teams_found'] = 'Keine Teams für "{$a}" gefunden';
$string['acp_teamconnections_group_only'] = ' (Nur Gruppe)';
$string['acp_teamconnections_team_missing'] = '(Team fehlt)';
$string['acp_teamconnections_not_connected'] = 'Nicht verbunden';
$string['acp_teamconnections_sync_disabled'] = 'Die Kurssynchronisierung muss zuerst aktiviert werden, bevor Teamverbindungen verwaltet werden können.';
$string['acp_teamconnections_table_connect'] = 'Verbinden';
$string['acp_teamconnections_table_connect_to_different_team'] = 'Mit einem anderen Team verbinden';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'Team kann nicht aus der Gruppe erstellt werden – kein/e Besitzer/in';
$string['acp_teamconnections_table_link_team'] = 'Link zum Team "{$a}"';
$string['acp_teamconnections_table_missing_team'] = 'Der Kurs ist mit einem nicht existierenden Team verbunden. Dies wird beim nächsten Durchlauf des geplanten Tasks zur Kurssynchronisierung bereinigt.';
$string['acp_teamconnections_table_resync'] = 'Erneut synchronisieren';
$string['acp_teamconnections_table_update'] = 'Aktualisieren';
$string['acp_teamconnections_teams_cache_updated'] = 'Der Teams-Cache wurde erfolgreich aktualisiert.';
$string['acp_teamconnections_no_owner'] = 'Fügen Sie eine/n Besitzer/in hinzu, um mit Teams zu verbinden.';
$string['acp_teamconnections_resync'] = 'Teambesitzer/innen / -mitglieder erneut synchronisieren';
$string['acp_teamconnections_resync_title'] = 'Teambesitzer/innen / -mitglieder für Kurs {$a} erneut synchronisieren';
$string['acp_teamconnections_resync_desc'] = 'Hierbei werden die im Kurs eingeschriebenen Nutzer/innen mit den Besitzer/innen und Mitgliedern der verbundenen Microsoft 365-Gruppe bzw. des Teams verglichen, und alle Fehlenden werden hinzugefügt. Wählen Sie aus, ob Nutzer/innen, die im Team, aber nicht im Moodle-Kurs eingeschrieben sind, ebenfalls entfernt werden sollen.';
$string['acp_teamconnections_resync_keep'] = 'Erneut synchronisieren (zusätzliche Teammitglieder behalten)';
$string['acp_teamconnections_resync_keep_desc'] = 'Im Moodle-Kurs eingeschriebene Nutzer/innen, die im Team fehlen, werden hinzugefügt. Bestehende Teambesitzer/innen und -mitglieder, die nicht im Moodle-Kurs eingeschrieben sind, bleiben unverändert.';
$string['acp_teamconnections_resync_remove'] = 'Erneut synchronisieren und zusätzliche Teammitglieder entfernen';
$string['acp_teamconnections_resync_remove_desc'] = 'Warnung: Alle Teambesitzer/innen und -mitglieder, die nicht im Moodle-Kurs eingeschrieben sind, werden aus dem Team entfernt, auch wenn sie direkt in Microsoft Teams hinzugefügt wurden.';
$string['acp_teamconnections_resync_completed'] = 'Teambesitzer/innen und -mitglieder wurden erneut synchronisiert.';
$string['acp_teamconnections_resync_failed'] = 'Teambesitzer/innen und -mitglieder konnten nicht erneut synchronisiert werden. Details finden Sie in der Ausgabe oben.';
$string['acp_teamconnections_last_resync'] = 'Zuletzt erneut synchronisiert: {$a}';
$string['acp_teamconnections_never_resynced'] = 'Nie erneut synchronisiert';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'Nutzerzuordnung';
$string['acp_usermatch_desc'] = 'Mit diesem Werkzeug können Sie Moodle-Nutzer/innen Microsoft 365-Nutzer/innen zuordnen. Sie laden eine Datei mit Moodle-Nutzer/innen und den zugehörigen Microsoft 365-Nutzer/innen hoch, und ein Cron-Task überprüft die Daten und richtet die Zuordnung ein.';
$string['acp_usermatch_upload'] = 'Schritt 1: Neue Zuordnungen hochladen';
$string['acp_usermatch_upload_desc'] = 'Laden Sie eine Datendatei mit Moodle- und Microsoft 365-Anmeldenamen hoch, um Moodle-Nutzer/innen Microsoft 365-Nutzer/innen zuzuordnen.<br />
<br />
Diese Datei sollte eine einfache CSV-Textdatei mit drei Einträgen pro Zeile sein:
<ul>
<li>der Moodle-Anmeldename,</li>
<li>der Microsoft 365-Anmeldename,</li>
<li>1 oder 0, wobei 1 bedeutet, dass die Authentifizierungsmethode des Nutzers/der Nutzerin auf OpenID Connect umgestellt wird, und 0 bedeutet, dass die bestehende Authentifizierungsmethode beibehalten und das Konto als verknüpftes Konto verwendet wird.</li>
</ul>
Fügen Sie keine Kopfzeilen oder zusätzlichen Daten hinzu.<br />
Beispiel: <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'Der Typ {$a} wird nicht unterstützt. Bitte laden Sie eine CSV-Textdatei hoch.';
$string['acp_usermatch_upload_err_data'] = 'Zeile #{$a} enthielt ungültige Daten. Jede Zeile der CSV-Datei sollte mindestens zwei Einträge enthalten: den Moodle-Anmeldenamen und den Microsoft 365-Anmeldenamen.';
$string['acp_usermatch_upload_err_fileopen'] = 'Die Datei konnte nicht zur Verarbeitung geöffnet werden. Sind die Berechtigungen in Ihrem Moodledata-Verzeichnis korrekt?';
$string['acp_usermatch_upload_err_nofile'] = 'Es wurde keine Datei zum Hinzufügen zur Warteschlange empfangen.';
$string['acp_usermatch_upload_submit'] = 'Datendatei zur Zuordnungswarteschlange hinzufügen';
$string['acp_usermatch_matchqueue'] = 'Schritt 2: Zuordnungswarteschlange';
$string['acp_usermatch_matchqueue_clearall'] = 'Alle löschen';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Fehler löschen';
$string['acp_usermatch_matchqueue_clearqueued'] = 'Wartende löschen';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Erfolgreiche löschen';
$string['acp_usermatch_matchqueue_column_muser'] = 'Moodle-Anmeldename';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Microsoft 365-Anmeldename';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Status';
$string['acp_usermatch_matchqueue_desc'] = 'Diese Tabelle zeigt den aktuellen Status des Zuordnungsvorgangs. Bei jedem Durchlauf des geplanten Tasks <b>Zuordnungswarteschlange verarbeiten</b> wird ein Stapel der folgenden Nutzer/innen verarbeitet.<br /><b>Hinweis:</b> Diese Seite wird nicht dynamisch aktualisiert. Laden Sie die Seite neu, um den aktuellen Status anzuzeigen.';
$string['acp_usermatch_matchqueue_empty'] = 'Die Zuordnungswarteschlange ist derzeit leer. Laden Sie über die Dateiauswahl oben eine Datendatei hoch, um Nutzer/innen zur Warteschlange hinzuzufügen.';
$string['acp_usermatch_matchqueue_status_error'] = 'Fehler: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'In Warteschlange';
$string['acp_usermatch_matchqueue_status_success'] = 'Erfolgreich';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'Wartungswerkzeuge';
$string['acp_maintenance_desc'] = 'Diese Werkzeuge können Ihnen helfen, einige häufige Probleme zu beheben.';
$string['acp_maintenance_warning'] = 'Warnung: Dies sind erweiterte Werkzeuge. Bitte verwenden Sie sie nur, wenn Sie wissen, was Sie tun.';
$string['acp_maintenance_resyncgroupusers'] = 'Nutzer/innen in Microsoft 365-Gruppen für Kurse erneut synchronisieren';
$string['acp_maintenance_resyncgroupusers_desc'] = 'Hierdurch wird die Nutzermitgliedschaft aller Microsoft 365-Gruppen, die für Moodle-Kurse erstellt wurden, erneut synchronisiert. So wird sichergestellt, dass alle im Moodle-Kurs eingeschriebenen Nutzer/innen und nur diese in der Microsoft 365-Gruppe sind. <br /><b>Hinweis:</b> Wenn Sie einer Microsoft 365-Gruppe zusätzliche Nutzer/innen hinzugefügt haben, die nicht im zugehörigen Moodle-Kurs eingeschrieben sind, werden diese entfernt.';
$string['acp_maintenance_recreatedeletedgroups'] = 'Gelöschte Microsoft 365-Gruppen neu erstellen';
$string['acp_maintenance_recreatedeletedgroups_desc'] = 'Hierdurch wird nach mit Moodle-Kursen verbundenen Microsoft 365-Gruppen gesucht, die möglicherweise manuell gelöscht wurden, und diese werden neu erstellt.';
$string['acp_maintenance_debugdata'] = 'Debug-Datenpaket erstellen';
$string['acp_maintenance_debugdata_desc'] = 'Hierdurch wird ein Paket mit verschiedenen Informationen über Ihre Moodle- und Microsoft 365-Umgebung erstellt, das Entwickler/innen bei der Lösung von Problemen unterstützt. Wenn Sie von Entwickler/innen darum gebeten werden, führen Sie dieses Werkzeug aus und senden Sie die heruntergeladene Datei. Hinweis: Obwohl dieses Paket keine sensiblen Tokendaten enthält, bitten wir Sie, diese Datei nicht öffentlich zu posten oder an nicht vertrauenswürdige Dritte zu senden.';
$string['acp_maintenance_cleandeltatoken'] = 'Delta-Tokens der Nutzersynchronisierung bereinigen';
$string['acp_maintenance_cleandeltatoken_desc'] = 'Wenn die Nutzersynchronisierung nach dem Ändern ihrer Einstellungen nicht vollständig funktioniert, kann dies an einem alten Delta-Synchronisierungstoken liegen. Durch das Bereinigen des Tokens wird bei der nächsten Ausführung der Nutzersynchronisierung eine vollständige Neusynchronisierung erzwungen.';
$string['acp_maintenance_cleanapptokens'] = 'Anwendungstokens bereinigen';
$string['acp_maintenance_cleanapptokens_desc'] = 'Entfernt die gespeicherten Anwendungstokens, die das Plugin für Aufrufe von Microsoft-APIs verwendet, die nicht im Namen eines Nutzers/einer Nutzerin ausgeführt werden. Neue Anwendungstokens werden automatisch angefordert, wenn sie das nächste Mal benötigt werden, und die Ergebnisse der letzten Prüfung "Einrichtung überprüfen" auf der Registerkarte "Einrichtung" werden gelöscht. Wenn Aufrufe mit Anwendungsberechtigungen mit Authentifizierungsfehlern fehlschlagen, z. B. nachdem sich die Berechtigungen der Microsoft Entra ID-Anwendung oder ihre Anmeldeinformationen geändert haben, kann das Bereinigen der Tokens helfen. Tokens von Nutzer/innen sind nicht betroffen.';

// Settings in the "Resync users in Microsoft 365 groups for courses" feature in the "Maintenance Tools" feature of the
// "Advanced" tab.
$string['acp_maintenance_resyncgroupusers_course_output'] = 'Ausgabe der erneuten Synchronisierung';
$string['acp_maintenance_resyncgroupusers_no_course'] = 'Kein Kurs mit Microsoft 365 verbunden';
$string['acp_maintenance_coursesync_disabled'] = 'Dieses Werkzeug ist nur verfügbar, wenn die Kurssynchronisierung aktiviert ist. <a href="{$a}">Kurssynchronisierung verwalten</a>.';

// Settings in the "Recreate deleted Microsoft 365 groups" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_recreatedeletedgroups_group_type'] = 'Moodle-Objekttyp';
$string['acp_maintenance_recreatedeletedgroups_group_type_course'] = 'Kurs';
$string['acp_maintenance_recreatedeletedgroups_group_type_course_group'] = 'Kursgruppe';
$string['acp_maintenance_recreatedeletedgroups_course'] = 'Kurs';
$string['acp_maintenance_recreatedeletedgroups_course_group'] = 'Kursgruppe';
$string['acp_maintenance_recreatedeletedgroups_status'] = 'Status';
$string['acp_maintenance_recreatedeletedgroups_status_sync_disabled'] = 'Die Kurssynchronisierung ist deaktiviert';
$string['acp_maintenance_recreatedeletedgroups_status_created_success'] = 'Die Gruppe wurde neu erstellt';
$string['acp_maintenance_recreatedeletedgroups_status_created_fail'] = 'Die Neuerstellung der Gruppe ist fehlgeschlagen';
$string['acp_maintenance_recreatedeletedgroups_all_groups_exist'] = 'Alle mit Moodle-Kursen und Kursgruppen verbundenen Gruppen sind vorhanden.';

// Settings in the "Cleanup User Sync Delta Tokens" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_cleandeltatoken_completed'] = 'Das Delta-Token und das Skip-Delta-Token der Nutzersynchronisierung wurden bereinigt.';
$string['acp_maintenance_cleanapptokens_confirm'] = 'Möchten Sie die Anwendungstokens wirklich bereinigen? Derzeit sind {$a} Anwendungstoken(s) gespeichert.';
$string['acp_maintenance_cleanapptokens_completed'] = 'Die Anwendungstokens und die letzten Ergebnisse von "Einrichtung überprüfen" wurden bereinigt.';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_course_reset_teams'] = 'Team-/Gruppenaktionen beim Zurücksetzen des Kurses';
$string['settings_course_reset_teams_details'] = 'Aktionen, die beim Zurücksetzen eines Kurses für das mit dem Kurs verbundene Team bzw. die verbundene Gruppe ausgeführt werden.';
$string['settings_course_reset_teams_option_do_nothing'] = 'Nichts tun<br/>Das Team bzw. die Gruppe bleibt mit dem Kurs verbunden. Abmeldungen von Nutzer/innen aus dem Kurs führen zur Entfernung aus dem Team bzw. der Gruppe.';
$string['settings_course_reset_teams_option_per_course'] = 'Einstellungen pro Kurs erlauben<br/>Hierfür muss der Microsoft-Block zum Kurs hinzugefügt werden. Nutzer/innen mit dem Recht, den Kurs zurückzusetzen, können im Block auswählen, was beim Zurücksetzen des Kurses geschehen soll.';
$string['settings_course_reset_teams_option_force_archive'] = 'Kurs vom Team bzw. von der Gruppe trennen und ein neues Team bzw. eine neue Gruppe erstellen<br/>Das bestehende, mit dem Kurs verbundene Team bzw. die Gruppe wird wie konfiguriert umbenannt. Wenn ein Team verbunden ist, wird es archiviert. Ein neues Team bzw. eine neue Gruppe wird erstellt und mit dem Kurs verbunden.';
$string['settings_course_reset_teams_option_archive_only'] = 'Kurs nur vom Team bzw. von der Gruppe trennen<br />Das bestehende, mit dem Kurs verbundene Team bzw. die Gruppe wird wie konfiguriert umbenannt. Wenn ein Team verbunden ist, wird es archiviert. Es wird kein neues Team bzw. keine neue Gruppe erstellt.';
$string['settings_reset_team_name_prefix'] = 'Präfix des Teamnamens beim Zurücksetzen';
$string['settings_reset_team_name_prefix_details'] = 'Beim Zurücksetzen eines mit einem Team verbundenen Kurses wird dem Namen des bestehenden verbundenen Teams dieses Präfix vorangestellt.';
$string['settings_reset_group_name_prefix'] = 'Präfix des Gruppennamens beim Zurücksetzen';
$string['settings_reset_group_name_prefix_details'] = 'Beim Zurücksetzen eines mit einer Gruppe verbundenen Kurses wird dem Namen der bestehenden Gruppe dieses Präfix vorangestellt.';
$string['settings_calsync_courseeventmode'] = 'Outlook-Termine für Kurskalendertermine';
$string['settings_calsync_courseeventmode_details'] = 'Legt fest, wie ein Termin aus dem Moodle-Kurskalender in Outlook für Nutzer/innen erstellt wird, die den Kurskalender abonniert haben.
<ul>
<li><strong>Ein gemeinsamer Termin mit Kursnutzer/innen als Teilnehmer/innen:</strong> Ein einzelner Termin wird im Outlook-Kalender der Person erstellt, die den Moodle-Termin angelegt hat (oder im Kalender der Microsoft 365-Gruppe des Kurses, wenn der Kurs mit einer Gruppe verknüpft ist), und die Kursnutzer/innen werden als Teilnehmer/innen hinzugefügt.</li>
<li><strong>Ein einzelner Termin pro Nutzer/in:</strong> Für jede/n abonnierte/n Nutzer/in wird direkt im eigenen Outlook-Kalender ein separater Termin erstellt. Es gibt keinen gemeinsamen Termin, keine Teilnehmerliste, und dem Kalender der Microsoft 365-Gruppe wird nichts hinzugefügt.</li>
</ul>
Eine Änderung dieser Einstellung wirkt sich nur auf danach synchronisierte Termine aus; bereits in Outlook vorhandene Termine werden nicht umgewandelt.';
$string['settings_calsync_courseeventmode_shared'] = 'Ein gemeinsamer Termin mit Kursnutzer/innen als Teilnehmer/innen';
$string['settings_calsync_courseeventmode_individual'] = 'Ein einzelner Termin pro Nutzer/in';
$string['settings_debugmode'] = 'Debugmeldungen aufzeichnen';
$string['settings_debugmode_details'] = 'Wenn aktiviert, werden Informationen im Moodle-Protokoll aufgezeichnet, die bei der Erkennung von Problemen helfen können. <a href="{$a}">Aufgezeichnete Protokollmeldungen anzeigen.</a>';
$string['settings_switchauthminupnsplit0'] = 'Mindestlänge nicht exakt übereinstimmender Anmeldenamen für die Umstellung auf Microsoft 365';
$string['settings_switchauthminupnsplit0_details'] = 'Wenn Sie die Einstellung "Authentifizierung abgeglichener Nutzer/innen auf Microsoft 365 (OpenID Connect) umstellen" aktivieren, legt diese Einstellung die Mindestlänge für Anmeldenamen ohne Mandant (den Teil @example.onmicrosoft.com) fest, die umgestellt werden. So wird vermieden, dass Konten mit generischen Namen wie "admin" umgestellt werden, die in Moodle und Microsoft Entra ID nicht unbedingt identisch sind. Setzen Sie den Wert auf 0, um abgeglichene Nutzer/innen unabhängig von der Länge des Anmeldenamens umzustellen. Nutzer/innen, deren Authentifizierungsmethode aufgrund dieser Einstellung nicht umgestellt wurde, werden in der Ausgabe des Synchronisierungsvorgangs als "Matched user, but the username is not an exact match to the Microsoft Entra ID UPN and does not meet the exact-match requirements for switching to OIDC..." protokolliert und auf der Seite "Nutzerverbindungen verwalten" als "Mit vorhandenem/r Nutzer/in abgeglichen - Abschluss ausstehend" angezeigt.';
$string['settings_customtheme'] = 'Benutzerdefiniertes Design (erweitert)';
$string['settings_customtheme_desc'] = 'Das empfohlene Design ist "boost_o365teams". Sie können jedoch ein anderes Design auswählen, wenn Sie ein benutzerdefiniertes Design haben, das für die Verwendung im Teams-Tab angepasst ist.<br/>
Beachten Sie, dass ein auf Kurs- oder Kursbereichsebene festgelegtes benutzerdefiniertes Design Vorrang vor den Einstellungen hier hat, d. h. ein Kurs verwendet in der Moodle-App in Teams standardmäßig das Kurs- oder Kursbereichsdesign. Dies kann behoben werden, indem $CFG->themeorder in config.php auf "array(\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\');" gesetzt wird.';

// Settings in the "SDS sync" tab.
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>Dies ist eine Vorschaufunktion</b><br />Vorschaufunktionen funktionieren möglicherweise nicht wie vorgesehen oder können ohne Vorwarnung ausfallen. Bitte gehen Sie mit Vorsicht vor.</div>';
$string['settings_sds_intro_desc'] = 'Microsoft School Data Sync ("SDS") vereinfacht die Klassenverwaltung in Microsoft 365, indem Klassenlisten aus einem externen SIS gelesen und Klassen und Gruppen in Microsoft 365 erstellt werden. <a href="https://sds.microsoft.com/" target="_blank">Weitere Informationen</a><br/>
<br/>
Die SDS-Synchronisierung kann Klassenlistendaten von SDS nach Moodle synchronisieren, einschließlich Klassen, Lehrkräften und Schüler/innen.<br/>
<br/>
Um die SDS-Synchronisierung zu verwenden, stellen Sie sicher, dass die für die Integration verwendete Microsoft Entra ID-App über die Microsoft Graph-Anwendungsberechtigungen <b>EduRoster.Read.All</b> und <b>Member.Read.Hidden</b> verfügt, die bei der Standardeinrichtung nicht automatisch hinzugefügt werden. Auch für diese muss die Administratorzustimmung erteilt werden.<br/>
<br/>
Standardmäßig wird die SDS-Synchronisierung täglich im Moodle-Cron um 3 Uhr Serverzeit ausgeführt. Um diesen Zeitplan zu ändern, besuchen Sie die <a href="{$a}">Seite zur Verwaltung geplanter Tasks.</a><br/><br/>';
$string['settings_sds_coursecreation'] = 'Synchronisierung von Klassen zu Kursen';
$string['settings_sds_coursecreation_desc'] = 'Diese Optionen steuern das Erstellen von Moodle-Kursen auf Basis von SDS-Schulklassen.';
$string['settings_sds_coursecreation_enabled'] = 'Synchronisierte Schulen';
$string['settings_sds_coursecreation_enabled_desc'] = 'Kurse für Klassen in diesen Schulen erstellen.';
$string['settings_sds_teams_enabled'] = 'Haben SDS-Klassen bereits Teams?';
$string['settings_sds_teams_enabled_desc'] = 'Aktivieren Sie diese Option, wenn für die SDS-Klassen bereits durch die SDS-Konfiguration Teams erstellt wurden. Wenn aktiviert, versucht Moodle nicht, aus den aus SDS-Klassen erstellten Moodle-Kursen Teams zu erstellen, um Konflikte zu vermeiden.';
$string['settings_sds_courseenrolsync'] = 'Synchronisierung der Kurseinschreibungen';
$string['settings_sds_courseenrolsync_desc'] = 'Diese Optionen steuern die Synchronisierung von Kurseinschreibungen aus SDS-Schulklassen.';
$string['settings_sds_enrolment_enabled'] = 'Einschreibungen von SDS nach Moodle synchronisieren';
$string['settings_sds_enrolment_enabled_desc'] = 'Wenn aktiviert, schreibt der geplante Task zur SDS-Synchronisierung Lehrkräfte und Schüler/innen aus SDS-Klassen in die entsprechenden Moodle-Kurse ein und entfernt Nutzer/innen, die nicht mehr in der SDS-Klasse sind. Erfordert, dass <b>Rolle für Lehrkräfte von SDS-Klassen in Moodle</b> und <b>Rolle für Schüler/innen von SDS-Klassen in Moodle</b> konfiguriert sind.';
$string['settings_sds_sync_enrolment_to_sds'] = 'Einschreibungen von Moodle nach SDS synchronisieren';
$string['settings_sds_sync_enrolment_to_sds_desc'] = 'Wenn aktiviert, werden Änderungen an Einschreibungen in Moodle-Kursen, die mit SDS-Klassen verbunden sind, zurück in die SDS-Klassen synchronisiert. Der Besitzer-/Mitgliedsstatus des Nutzers/der Nutzerin in SDS hängt von den Fähigkeiten "local/o365:teamowner" und "local/o365:teammember" im Kurskontext ab.';
$string['settings_sds_suspend_enrolment'] = 'Einschreibungen von Nutzer/innen sperren statt sie abzumelden';
$string['settings_sds_suspend_enrolment_desc'] = 'Wenn diese Option aktiviert ist, wird bei Nutzer/innen, die aus einer SDS-Klasse entfernt werden, die Einschreibung im verbundenen Moodle-Kurs gesperrt, statt sie vollständig abzumelden. So bleiben Nutzerdaten wie Bewertungen, Abgaben und Aktivitätsabschluss erhalten. Wenn Nutzer/innen wieder zur SDS-Klasse hinzugefügt werden, wird ihre Einschreibung automatisch reaktiviert.<br />
<b>Hinweis:</b> Lehrkräfte werden durch die SDS-Synchronisierung nie gesperrt oder abgemeldet. Diese Einstellung betrifft nur Schüler/innen.';
$string['settings_sds_enable_course_sync'] = 'Zwei-Wege-Kurssynchronisierung aktivieren';
$string['settings_sds_enable_course_sync_desc'] = 'Wenn aktiviert, wird jeder aus einer SDS-Klasse erstellte Moodle-Kurs in der Datenbank mit seiner Microsoft 365-Gruppe verknüpft, wodurch die vollständige Microsoft 365-Kurssynchronisierung (Teams, Dateien, Kalender usw.) für diesen Kurs aktiviert wird. Wenn die SDS-Klasse bereits ein Team hat, wird auch ein Datensatz für die Teamzuordnung erstellt.';
$string['settings_sds_course_field_mailnickname'] = 'Mail-Spitzname (mailNickname)';
$string['settings_sds_course_field_displayname'] = 'Anzeigename (displayName)';
$string['settings_sds_course_field_classcode'] = 'Klassencode (classCode)';
$string['settings_sds_course_field_externalname'] = 'Externer Name (externalName)';
$string['settings_sds_course_shortname_field'] = 'Quelle für den kurzen Kursnamen';
$string['settings_sds_course_shortname_field_desc'] = 'Die Eigenschaft der SDS-Klasse, die als kurzer Kursname neu erstellter Moodle-Kurse verwendet wird. Moodle verlangt eindeutige kurze Kursnamen. Wenn die gewählte Eigenschaft leer ist oder ihr Wert bereits von einem Kurs verwendet wird, der mit einer anderen SDS-Klasse verknüpft ist, wird stattdessen der Mail-Spitzname verwendet. Eine Änderung dieser Einstellung benennt bereits erstellte Kurse nicht um.';
$string['settings_sds_course_fullname_field'] = 'Quelle für den vollständigen Kursnamen';
$string['settings_sds_course_fullname_field_desc'] = 'Die Eigenschaft der SDS-Klasse, die als vollständiger Kursname neu erstellter Moodle-Kurse verwendet wird. Wenn die gewählte Eigenschaft leer ist, wird stattdessen der Anzeigename verwendet. Eine Änderung dieser Einstellung benennt bereits erstellte Kurse nicht um.';
$string['settings_sds_categorize_by_subject'] = 'Kurse nach Fach kategorisieren';
$string['settings_sds_categorize_by_subject_desc'] = 'Wenn aktiviert, werden Kurse innerhalb jedes Schul-Kursbereichs in fachbezogene Kursbereiche eingeordnet. Der Fachname wird aus den Klasseninformationen in SDS übernommen. Wenn deaktiviert, werden alle Kurse direkt im Schul-Kursbereich abgelegt.';
$string['settings_sds_ignore_past_courses'] = 'Abgelaufene/vergangene Klassen ignorieren';
$string['settings_sds_ignore_past_courses_desc'] = 'Wenn aktiviert, werden abgelaufene oder beendete Klassen bei der Synchronisierung übersprungen. Dazu gehören:<br />
<ul>
<li>Klassen, deren Name das konfigurierte Präfix für abgelaufene Klassen enthält (Standard: "Exp")</li>
<li>Klassen mit einem Enddatum in der Vergangenheit</li>
</ul>
So bleibt Ihr Kurskatalog übersichtlich, da keine Kurse für alte oder archivierte Klassen erstellt werden.';
$string['settings_sds_expired_course_prefix'] = 'Namenspräfix für abgelaufene Klassen';
$string['settings_sds_expired_course_prefix_desc'] = 'Klassennamen, die mit diesem Präfix beginnen, gelten als abgelaufen und werden bei der Synchronisierung übersprungen (wenn "Abgelaufene/vergangene Klassen ignorieren" aktiviert ist). Standard: "Exp"';
$string['settings_sds_cohortsync'] = 'Synchronisierung globaler Gruppen';
$string['settings_sds_cohortsync_desc'] = 'Diese Optionen steuern das Erstellen und Synchronisieren globaler Gruppen aus SDS-Klassen. Globale Gruppen bieten eine alternative Möglichkeit, Nutzer/innen zu gruppieren, die für websiteweite Einschreibungen oder andere Moodle-Funktionen genutzt werden kann.';
$string['settings_sds_create_cohorts'] = 'Globale Gruppen aus SDS-Klassen erstellen';
$string['settings_sds_create_cohorts_desc'] = 'Wenn aktiviert, wird für jede SDS-Klasse eine globale Gruppe erstellt und deren Mitgliedschaft mit der SDS-Klasse synchronisiert. Globale Gruppen werden im Kontext des Kursbereichs erstellt (Schul- oder Fach-Kursbereich, je nach Ihren Kategorisierungseinstellungen).<br />
<b>Hinweis:</b> Globale Gruppen werden zusätzlich zu Kursen erstellt, nicht an deren Stelle. So können Sie globale Gruppen für websiteweite Einschreibungen oder Gruppierungen verwenden und gleichzeitig SDS-synchronisierte Kurse beibehalten.';
$string['settings_sds_cohort_include_teachers'] = 'Lehrkräfte in globale Gruppen aufnehmen';
$string['settings_sds_cohort_include_teachers_desc'] = 'Wenn aktiviert, werden Lehrkräfte aus der SDS-Klasse zusammen mit den Schüler/innen zur globalen Gruppe hinzugefügt. Wenn deaktiviert, werden nur Schüler/innen zu globalen Gruppen hinzugefügt.';
$string['settings_sds_enrolment_teacher_role'] = 'Rolle für Lehrkräfte von SDS-Klassen in Moodle';
$string['settings_sds_enrolment_teacher_role_desc'] = 'Wenn "Einschreibungen von SDS nach Moodle synchronisieren" aktiviert ist, werden Lehrkräfte der SDS-Klasse mit dieser Rolle in den verbundenen Moodle-Kurs eingeschrieben.';
$string['settings_sds_enrolment_student_role'] = 'Rolle für Schüler/innen von SDS-Klassen in Moodle';
$string['settings_sds_enrolment_student_role_desc'] = 'Wenn "Einschreibungen von SDS nach Moodle synchronisieren" aktiviert ist, werden Schüler/innen der SDS-Klasse mit dieser Rolle in den verbundenen Moodle-Kurs eingeschrieben.';
$string['settings_sds_profilesync_header'] = 'Synchronisierung der Nutzerprofile';
$string['settings_sds_profilesync_header_desc'] = 'Jede SDS-Schule kann Nutzerprofile für Lehrkräfte und Mitglieder der Schule speichern. Das Feld ist schulspezifisch, d. h. verschiedene Schulen können im selben Feld für dieselbe Person unterschiedliche Werte haben.<br/>
Wenn in diesem Abschnitt eine Schule ausgewählt ist, können die SDS-Nutzerprofilfelder in der Zuordnung der Nutzerfelder konfiguriert werden.
<ul>
<li>Beachten Sie, dass SDS-Felder nur beim Ausführen des geplanten Tasks "Mit SDS synchronisieren" synchronisiert werden, nicht jedoch beim Ausführen des geplanten Tasks "Nutzer/innen aus Microsoft Entra ID synchronisieren" oder bei der Anmeldung eines Nutzers/einer Nutzerin.</li>
<li>Beachten Sie das bekannte Problem in der von dieser Funktion verwendeten Microsoft Graph API, dass bestimmte Schulprofilfelder von Schüler/innen und Lehrkräften nicht zurückgegeben werden und daher auch bei entsprechender Konfiguration nicht synchronisiert werden können.</li>
</ul>
';
$string['settings_sds_profilesync_disabled'] = 'Deaktiviert';
$string['settings_sds_profilesync'] = 'Profildaten aus Schule synchronisieren';
$string['settings_sds_profilesync_desc'] = 'Wählen Sie die SDS-Schule aus, aus der Moodle SDS-spezifische Profildaten synchronisiert.';
$string['settings_sds_noschools'] = '<div class="alert alert-info">In SDS sind keine Schulen verfügbar.</div>';
$string['settings_sds_get_schools_error'] = '<div class="alert alert-info error">SDS-Schulen konnten nicht abgerufen werden. Prüfen Sie, ob die Microsoft Entra ID-App die erforderliche Berechtigung hat.</div>';
$string['settings_sds_school_disabled_action'] = 'Aktion bei deaktivierter Schulsynchronisierung';
$string['settings_sds_school_disabled_action_desc'] = 'Aktion, die für bereits verbundene Moodle-Kurse ausgeführt wird, wenn die Synchronisierung für eine SDS-Schule deaktiviert wird.';
$string['settings_sds_school_disabled_action_keep_connected'] = 'Moodle-Kurs mit dem Team verbunden lassen';
$string['settings_sds_school_disabled_action_disconnect'] = 'Moodle-Kurs vom Team trennen';
$string['settings_sds_school_unavailable'] = '{$a} (SDS-Schulliste derzeit nicht verfügbar)';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner'] = 'Mit der Moodle-App für <a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teams</a> können Sie in Teams einfach auf Ihre Moodle-Kurse zugreifen und gemeinsam daran arbeiten.';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Moodle-App für Microsoft Teams einrichten</h4>';
$string['settings_moodlesettingssetup'] = 'Moodle konfigurieren';
$string['settings_check_moodle_settings'] = 'Moodle-Einstellungen prüfen';
$string['settings_moodlesetup_checking'] = 'Wird geprüft...';
$string['settings_notice_cookiesecureenabled'] = 'Ausschließlich sichere Cookies wurde erfolgreich aktiviert';
$string['settings_notice_cookiesecurealreadyenabled'] = 'Ausschließlich sichere Cookies war bereits aktiviert';
$string['settings_notice_oidcenabled'] = 'OpenID Connect wurde erfolgreich aktiviert';
$string['settings_notice_oidcnotenabled'] = 'OpenID Connect konnte nicht aktiviert werden';
$string['settings_notice_oidcalreadyenabled'] = 'OpenID Connect war bereits aktiviert';
$string['settings_notice_webservicesframealreadyenabled'] = 'Webservices waren bereits aktiviert und das Einbetten in Frames ist ebenfalls erlaubt';
$string['settings_notice_webservicesframeenabled'] = 'Webservices wurden erfolgreich aktiviert und das Einbetten in Frames ist jetzt ebenfalls erlaubt';
$string['settings_notice_restenabled'] = 'REST-Protokoll wurde erfolgreich aktiviert';
$string['settings_notice_restnotenabled'] = 'REST-Protokoll konnte nicht aktiviert werden';
$string['settings_notice_restalreadyenabled'] = 'REST-Protokoll war bereits aktiviert';
$string['settings_notice_o365serviceenabled'] = 'Microsoft 365-Webservices wurden erfolgreich aktiviert';
$string['settings_notice_o365servicealreadyenabled'] = 'Microsoft 365-Webservices waren bereits aktiviert';
$string['settings_notice_createtokenallowed'] = 'Die Berechtigung zum Erstellen eines Webservice-Tokens wurde erteilt';
$string['settings_notice_createtokenalreadyallowed'] = 'Die Berechtigung zum Erstellen eines Webservice-Tokens war bereits erteilt';
$string['settings_notice_createtokennotallowed'] = 'Beim Erteilen der Berechtigung zum Erstellen eines Webservice-Tokens ist ein Problem aufgetreten';
$string['settings_notice_restusageallowed'] = 'Die Berechtigung zur Verwendung des REST-Protokolls wurde erteilt';
$string['settings_notice_restusagealreadyallowed'] = 'Die Berechtigung zur Verwendung des REST-Protokolls war bereits erteilt';
$string['settings_notice_restusagenotallowed'] = 'Beim Erteilen der Berechtigung zur Verwendung des REST-Protokolls ist ein Problem aufgetreten';
$string['settings_moodlesettingssetup_details'] = 'Hierdurch wird sichergestellt, dass:
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>Ausschließlich sichere Cookies aktiviert ist.</li>
<li>OpenID Connect aktiviert ist.</li>
<li>Das Einbetten in Frames aktiviert ist.</li>
<li>Webservices aktiviert sind.</li>
<li>Das REST-Protokoll aktiviert ist.</li>
<li>Microsoft 365-Webservices aktiviert sind.</li>
<li>Der/die angemeldete Nutzer/in die Berechtigung zum Erstellen eines Webservice-Tokens hat.</li>
<li>Der/die angemeldete Nutzer/in die Berechtigung zur Verwendung des REST-Protokolls hat.</li>
</ul>';
$string['settings_teams_moodle_app_external_id'] = 'Microsoft-App-ID für die Moodle-Teams-App';
$string['settings_teams_moodle_app_external_id_desc'] = 'Dies sollte auf den Standardwert gesetzt sein, es sei denn, in Ihrem Mandanten werden mehrere Moodle-Teams-Apps benötigt, um sich mit verschiedenen Moodle-Websites zu verbinden.';
$string['settings_teams_moodle_app_short_name'] = 'Name der Teams-App';
$string['settings_teams_moodle_app_short_name_desc'] = 'Dies kann auf den Standardwert gesetzt bleiben, es sei denn, in Ihrem Mandanten werden mehrere Moodle-Teams-Apps benötigt, um sich mit verschiedenen Moodle-Websites zu verbinden.';
$string['settings_download_teams_tab_app_manifest'] = 'Manifestdatei herunterladen';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Bitte speichern Sie alle Ihre Änderungen, bevor Sie das Manifest herunterladen.';
$string['settings_publish_manifest_instruction'] = '<a href="https://learn.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Klicken Sie hier</a>, um zu erfahren, wie Sie Ihre heruntergeladene Manifestdatei der Moodle-App für alle Nutzer/innen in Teams veröffentlichen.';
$string['settings_teams_moodle_tab_name'] = 'Name des Moodle-Tabs in Teams';
$string['settings_teams_moodle_tab_name_desc'] = 'Dies ist der Name des Moodle-Tabs in Teams.';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'Moodle-App-ID';
$string['settings_moodle_app_id_desc'] = 'ID der hochgeladenen Moodle-App in den Teams-App-Katalogen.<br/>
Wenn konfiguriert, versucht Moodle, im Kanal "Allgemein" des erstellten bzw. verbundenen Teams einen Moodle-Tab zu erstellen, der auf den Moodle-Kurs verweist.';
$string['settings_moodle_app_id_desc_auto_id'] = '<br/>
Automatisch erkannter Wert ist "<span class="local_o365_settings_moodle_app_id">{$a}</span>".';
$string['settings_set_moodle_app_id_instruction'] = 'So finden Sie die Moodle-App-ID manuell:
<ol>
<li>Laden Sie die heruntergeladene Manifestdatei in den Teams-App-Katalog Ihres Mandanten hoch.</li>
<li>Suchen Sie die App im Teams-App-Katalog.</li>
<li>Klicken Sie auf das Optionssymbol der App, das sich oben rechts im App-Bild befindet.</li>
<li>Klicken Sie auf "Link kopieren".</li>
<li>Fügen Sie den kopierten Inhalt in einen Texteditor ein. Er sollte eine URL in dieser Form enthalten: https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
Der letzte Teil der URL, d. h. <span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>, ist die App-ID.';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Outlook-Kalendersynchronisierung aktivieren';
$string['calendar_user'] = 'Persönlicher Kalender';
$string['calendar_site'] = 'Websiteweiter Kalender';
$string['personal_calendar'] = 'Persönlich';
$string['calendar_event'] = 'Details anzeigen';
$string['eventcalendarsubscribed'] = 'Nutzer/in hat einen Kalender abonniert';
$string['eventcalendarunsubscribed'] = 'Nutzer/in hat das Abonnement eines Kalenders beendet';

// Errors.
$string['erroracpauthoidcnotconfig'] = 'Legen Sie zunächst die Anwendungsanmeldeinformationen in auth_oidc fest.';
$string['errorhttpclientbadtempfileloc'] = 'Der temporäre Speicherort zum Speichern der Datei konnte nicht geöffnet werden.';
$string['errorhttpclientnofileinput'] = 'Kein Dateiparameter in httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Token konnte nicht aktualisiert werden';
$string['errormfarequired'] = 'Microsoft verlangt eine Multi-Faktor-Authentifizierung, bevor Moodle auf Ihr Microsoft 365-Konto zugreifen kann. Bitte melden Sie sich von Moodle ab, melden Sie sich dann erneut mit Ihrem Microsoft 365-Konto an und schließen Sie die Aufforderung zur Multi-Faktor-Authentifizierung ab.';
$string['errorgetapplicationtoken'] = 'Das Anwendungstoken konnte nicht abgerufen werden. Bitte überprüfen Sie Ihre Integrationskonfiguration.';
$string['erroracpapcantgettenant'] = 'Der Microsoft Entra-Mandant konnte nicht ermittelt werden, bitte geben Sie ihn manuell ein.';
$string['erroracpcantgettenant'] = 'Die OneDrive-URL konnte nicht ermittelt werden, bitte geben Sie sie manuell ein.';
$string['errorprovisioningapp'] = 'Die Moodle-App konnte im Team nicht bereitgestellt werden.';
$string['erroro365apibadcall'] = 'Fehler beim API-Aufruf.';
$string['erroro365apibadcall_message'] = 'Fehler beim API-Aufruf: {$a}';
$string['erroro365apiinvalidtoken'] = 'Ungültiges oder abgelaufenes Token.';
$string['erroro365apiinvalidmethod'] = 'Ungültige HTTP-Methode an API-Aufruf übergeben';
$string['erroro365apinotimplemented'] = 'Dies sollte überschrieben werden.';
$string['erroro365apinotoken'] = 'Für die angegebene Ressource und den/die angegebene/n Nutzer/in war kein Token vorhanden und es konnte auch keines abgerufen werden. Ist das Aktualisierungstoken des Nutzers/der Nutzerin abgelaufen?';
$string['errorusermatched'] = 'Das Microsoft 365-Konto "{$a->entraidupn}" ist bereits dem Moodle-Nutzerkonto "{$a->username}" zugeordnet. Um die Verbindung abzuschließen, melden Sie sich bitte zuerst mit diesem Moodle-Nutzerkonto an und folgen Sie den Anweisungen im Microsoft-Block.';
$string['errornodirectaccess'] = 'Der direkte Zugriff auf die Seite ist nicht erlaubt';
$string['eventapifail'] = 'API-Fehler';
$string['errorunabletofindgraphapi'] = 'Die Microsoft Graph API wurde in der Anwendung nicht gefunden.';
$string['erroremptyjwt'] = 'Leeres JWT-Token übergeben';
$string['errornocachedjwks'] = 'Kein zwischengespeichertes JWKS gefunden';
$string['errorfetchjwks'] = 'JWKS konnte nicht von Microsoft abgerufen werden';
$string['errorinvalidjwks'] = 'Von Microsoft wurde ein ungültiges JWKS-Format empfangen';
$string['errorjwtvalidation'] = 'JWT-Validierung fehlgeschlagen';
$string['errorjwtinvalidissuer'] = 'Validierung des JWT-Ausstellers fehlgeschlagen';
$string['errorcannotgettoken'] = 'Das App- oder Systemtoken konnte nicht abgerufen werden.';
$string['errornotokenforsysmemuser'] = 'Für den Systemnutzer ist kein Token verfügbar. Bitte führen Sie den Health Check von local_o365 aus.';
$string['errornotoken'] = 'Für Nutzer/in #{$a} ist kein Token verfügbar';
$string['errornotokenforusersync'] = 'Für die Nutzersynchronisierung ist kein Token verfügbar.';
$string['errornoapifound'] = 'Es wurde keine API mit der Kennung {$a} gefunden.';
$string['errornoresponsesavailable'] = 'Keine Antworten verfügbar.';
$string['erroro365badphoto'] = 'Von Microsoft 365 wurde ein ungültiges Profilbild empfangen.';
$string['erroro365nophoto'] = 'Diese/r Nutzer/in hat in Microsoft 365 kein Bild.';
$string['errorcannotgetapiclient'] = 'Der Graph-API-Client kann nicht abgerufen werden.';
$string['errorfailedtogetsecrets'] = 'Die geheimen Clientschlüssel konnten nicht abgerufen werden.';
$string['errorfailedtosendnotification'] = 'Die Benachrichtigungs-E-Mail konnte nicht an einen oder mehrere Empfänger gesendet werden.';
$string['errorsecretexpiryrecipientundeliverable'] = 'Ein oder mehrere konfigurierte Empfänger der Benachrichtigung über den Ablauf geheimer Clientschlüssel können keine E-Mails empfangen (ungültige Adresse oder eine Domain ohne MX-/A-Eintrag): {$a}. Aktualisieren Sie die Benachrichtigungsempfänger in den OpenID Connect-Einstellungen.';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Lokales Plugin Microsoft 365';
$string['privacy:metadata:local_o365_calidmap'] = 'Informationen über Verknüpfungen zwischen Microsoft 365-Kalenderterminen und Moodle-Kalenderterminen.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'Die ID des Nutzerkontos, dem der Termin gehört.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'Woher der Termin stammt. Entweder Moodle oder Microsoft 365.';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'Die ID des Termins in Outlook.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'Die ID des Termins in Moodle.';
$string['privacy:metadata:local_o365_calsub'] = 'Informationen über Synchronisierungsabonnements zwischen Moodle- und Outlook-Kalendern';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'Die ID des Moodle-Nutzerkontos, für das das Abonnement gilt';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'Der Typ des Moodle-Kalenders (site, course, user)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'Die zugehörige ID des Moodle-Kalenders';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'Die ID des Microsoft 365-Kalenders';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Ob dies der primäre Kalender ist';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'Das Synchronisierungsverhalten (d. h. Moodle zu Outlook oder Outlook zu Moodle)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'Der Zeitpunkt, zu dem das Abonnement erstellt wurde.';
$string['privacy:metadata:local_o365_connections'] = 'Informationen über Verbindungen zwischen Moodle- und Microsoft 365-Nutzer/innen, die noch nicht bestätigt wurden';
$string['privacy:metadata:local_o365_connections:muserid'] = 'Die ID des Moodle-Nutzerkontos';
$string['privacy:metadata:local_o365_connections:entraidupn'] = 'Der UPN des Microsoft Entra ID-Kontos.';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Ob die Authentifizierungsmethode des Nutzerkontos nach Abschluss umgestellt werden soll.';
$string['privacy:metadata:local_o365_token'] = 'Informationen über Microsoft 365-API-Tokens für Nutzer';
$string['privacy:metadata:local_o365_token:user_id'] = 'Die ID des Moodle-Nutzerkontos';
$string['privacy:metadata:local_o365_token:scope'] = 'Der Geltungsbereich des Tokens.';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'Die Ressource des Tokens.';
$string['privacy:metadata:local_o365_token:token'] = 'Das Token.';
$string['privacy:metadata:local_o365_token:expiry'] = 'Der Ablaufzeitpunkt des Tokens.';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'Das Aktualisierungstoken.';
$string['privacy:metadata:local_o365_objects'] = 'Informationen über die Beziehung zwischen Moodle- und Microsoft 365-Objekten';
$string['privacy:metadata:local_o365_objects:type'] = 'Der Objekttyp (Gruppe, Nutzer/in, Kurs usw.)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'Der Untertyp des Objekts.';
$string['privacy:metadata:local_o365_objects:objectid'] = 'Die Microsoft 365-Objekt-ID';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'Die ID des Objekts in Moodle';
$string['privacy:metadata:local_o365_objects:o365name'] = 'Der lesbare Name des Objekts in Microsoft 365';
$string['privacy:metadata:local_o365_objects:tenant'] = 'Der Mandant, zu dem das Objekt gehört (in mandantenfähigen Umgebungen)';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Zugehörige Metadaten';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'Der Zeitpunkt, zu dem der Datensatz erstellt wurde.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'Der Zeitpunkt, zu dem der Datensatz geändert wurde.';
$string['privacy:metadata:local_o365_appassign'] = 'Informationen über Microsoft 365-App-Rollenzuweisungen';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'Die ID des Moodle-Nutzerkontos';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Ob das Nutzerkonto der App zugewiesen wurde';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'Die ID des Nutzerbilds in Microsoft 365';
$string['privacy:metadata:local_o365_appassign:photohash'] = 'Ein SHA-256-Hash der Bytes des Profilbilds des Nutzers/der Nutzerin, gespeichert, um Bildänderungen zu erkennen, ohne das vollständige Bild erneut abzurufen';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Wann das Bild des Nutzers/der Nutzerin zuletzt aus Microsoft 365 aktualisiert wurde';
$string['privacy:metadata:local_o365_matchqueue'] = 'Informationen über die Zuordnung von Moodle-Nutzer/innen zu Microsoft 365-Nutzer/innen';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'Der Anmeldename des Moodle-Nutzerkontos.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'Der Anmeldename des Microsoft 365-Kontos.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Ob das Nutzerkonto bei der Zuordnung auf die OpenID Connect-Authentifizierung umgestellt werden soll';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Ob der Datensatz verarbeitet wurde';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'Die Fehlermeldung (falls vorhanden)';
$string['privacy:metadata:preference:suspendedtime'] = 'Der Zeitpunkt, zu dem das Nutzerkonto durch die Nutzersynchronisierung gesperrt wurde, entweder weil das zugehörige Microsoft Entra ID-Konto gelöscht oder weil es deaktiviert wurde.';
$string['privacy:metadata:local_o365_calsettings'] = 'Informationen über Einstellungen der Kalendersynchronisierung';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'Die ID des Moodle-Nutzerkontos';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'Die ID des Kalenders in Microsoft 365';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'Der Zeitpunkt, zu dem der Datensatz erstellt wurde.';
$string['privacy:metadata:preference:calsync_initialised'] = 'Ob die Auswahl des Nutzers/der Nutzerin zur Outlook-Kalendersynchronisierung initialisiert wurde, sodass sie nicht erneut automatisch aktiviert wird.';

// Page "Microsoft 365 / Moodle Control Panel" in the Microsoft block.
$string['ucp_title'] = 'Microsoft 365-/Moodle-Systemsteuerung';
$string['ucp_general_intro'] = 'Hier können Sie Ihre Verbindung mit Microsoft 365 verwalten.';
$string['ucp_calsync_availcal'] = 'Verfügbare Moodle-Kalender';
$string['ucp_calsync_title'] = 'Einstellungen der Outlook-Kalendersynchronisierung';
$string['ucp_calsync_desc'] = 'Aktivierte Kalender werden von Moodle mit Ihrem Outlook-Kalender synchronisiert.';
$string['ucp_connection_options'] = 'Verbindungsoptionen:';
$string['ucp_connection_desc'] = 'Hier können Sie konfigurieren, wie Sie sich mit Microsoft 365 verbinden. Um Microsoft 365-Funktionen zu verwenden, müssen Sie mit einem Microsoft 365-Konto verbunden sein. Dies kann wie unten beschrieben erfolgen.';
$string['ucp_connection_entraidlogin'] = 'Verwenden Sie Ihre Microsoft 365-Anmeldeinformationen, um sich bei Moodle anzumelden<br />';
$string['ucp_connection_entraidlogin_desc_authcode'] = 'Statt Anmeldename und Kennwort auf der Moodle-Anmeldeseite einzugeben, sehen Sie dort einen Abschnitt mit der Aufschrift "Anmeldung mit Ihrem Konto bei {$a}". Sie klicken auf den Link und werden zur Anmeldung zu Microsoft 365 weitergeleitet. Nach erfolgreicher Anmeldung bei Microsoft 365 kehren Sie zu Moodle zurück und sind in Ihrem Konto angemeldet.';
$string['ucp_connection_entraidlogin_start'] = 'Microsoft 365 für die Anmeldung bei Moodle verwenden.';
$string['ucp_connection_entraidlogin_stop'] = 'Microsoft 365 nicht mehr für die Anmeldung bei Moodle verwenden.';
$string['ucp_connection_entraidlogin_active'] = 'Sie verwenden das Microsoft 365-Konto "{$a}" für die Anmeldung bei Moodle.';
$string['ucp_connection_linked'] = 'Moodle- und Microsoft 365-Konto verknüpfen';
$string['ucp_connection_linked_desc'] = 'Wenn Sie Ihr Moodle- und Ihr Microsoft 365-Konto verknüpfen, können Sie Microsoft 365-Funktionen in Moodle nutzen, ohne die Art Ihrer Anmeldung bei Moodle zu ändern. <br />Wenn Sie auf den Link unten klicken, werden Sie zu einer einmaligen Anmeldung bei Microsoft 365 weitergeleitet und anschließend hierher zurückgeleitet. Sie können dann alle Microsoft 365-Funktionen nutzen, ohne weitere Änderungen an Ihrem Moodle-Konto vorzunehmen – Sie melden sich weiterhin wie gewohnt bei Moodle an.';
$string['ucp_connection_linked_active'] = 'Sie sind mit dem Microsoft 365-Konto "{$a}" verknüpft.';
$string['ucp_connection_linked_start'] = 'Ihr Moodle-Konto mit einem Microsoft 365-Konto verknüpfen.';
$string['ucp_connection_linked_migrate'] = 'Zum verknüpften Konto wechseln.';
$string['ucp_connection_linked_stop'] = 'Die Verknüpfung Ihres Moodle-Kontos mit dem Microsoft 365-Konto aufheben.';
$string['ucp_connection_disconnected'] = 'Sie sind nicht mit Microsoft 365 verbunden.';
$string['ucp_features'] = 'Microsoft 365-Funktionen';
$string['ucp_features_intro'] = 'Nachstehend finden Sie eine Liste der Funktionen, mit denen Sie Moodle mit Microsoft 365 erweitern können.';
$string['ucp_features_intro_notconnected'] = ' Einige davon sind möglicherweise erst verfügbar, wenn Sie mit Microsoft 365 verbunden sind.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Um sich mit Microsoft 365 zu verbinden, wenden Sie sich bitte an Ihre Website-Administration.';
$string['ucp_index_calendar_title'] = 'Einstellungen der Outlook-Kalendersynchronisierung';
$string['ucp_index_calendar_desc'] = 'Hier können Sie die Synchronisierung zwischen Ihren Moodle- und Outlook-Kalendern einrichten. Sie können Moodle-Kalendertermine nach Outlook exportieren und Outlook-Termine in Moodle übernehmen.';
$string['ucp_index_connection_title'] = 'Microsoft 365-Verbindungseinstellungen';
$string['ucp_index_connection_desc'] = 'Konfigurieren Sie, wie Sie sich mit Microsoft 365 verbinden.';
$string['ucp_index_connectionstatus_title'] = 'Verbindungsstatus';
$string['ucp_index_connectionstatus_login'] = 'Klicken Sie hier, um sich anzumelden.';
$string['ucp_index_connectionstatus_usinglogin'] = 'Sie verwenden derzeit Microsoft 365 für die Anmeldung bei Moodle.';
$string['ucp_index_connectionstatus_usinglinked'] = 'Sie sind mit einem Microsoft 365-Konto verknüpft.';
$string['ucp_index_connectionstatus_manage'] = 'Verbindung verwalten';
$string['ucp_index_connectionstatus_reconnect'] = 'Verbindung aktualisieren';
$string['ucp_index_connectionstatus_connected'] = 'Sie sind derzeit mit Microsoft 365 verbunden';
$string['ucp_index_connectionstatus_matched'] = 'Sie wurden dem Microsoft 365-Konto <small>"{$a}"</small> zugeordnet. Um diese Verbindung abzuschließen, klicken Sie auf den Link unten und melden Sie sich bei Microsoft 365 an.';
$string['ucp_index_connectionstatus_notconnected'] = 'Sie sind derzeit nicht mit Microsoft 365 verbunden';
$string['ucp_notconnected'] = 'Bitte verbinden Sie sich mit Microsoft 365, bevor Sie diese Seite aufrufen.';
$string['ucp_status_enabled'] = 'Aktiv';
$string['ucp_status_disabled'] = 'Nicht verbunden';
$string['ucp_syncwith_title'] = 'Name des Outlook-Kalenders, mit dem synchronisiert wird:';
$string['ucp_syncdir_title'] = 'Synchronisierungsverhalten:';
$string['ucp_syncdir_out'] = 'Von Moodle zu Outlook';
$string['ucp_syncdir_in'] = 'Von Outlook zu Moodle';
$string['ucp_syncdir_both'] = 'Sowohl Outlook als auch Moodle aktualisieren';
$string['ucp_o365accountconnected'] = 'Dieses Microsoft 365-Konto ist bereits mit einem anderen Moodle-Konto verbunden.';

// Tasks.
$string['task_calendarsyncin'] = 'Microsoft 365-Termine mit Moodle synchronisieren';
$string['task_coursesync'] = 'Moodle-Kurse mit Microsoft Teams synchronisieren';
$string['task_coursemembershipsync'] = 'Microsoft Teams-Besitzer/innen und -Mitglieder mit Moodle-Kursen synchronisieren';
$string['task_groupmembershipsync'] = 'Moodle-Kursbesitzer/innen und -mitglieder mit Microsoft 365-Gruppen synchronisieren';
$string['task_sds_sync'] = 'Mit SDS synchronisieren';
$string['task_syncusers'] = 'Nutzer/innen aus Microsoft Entra ID synchronisieren';
$string['task_syncusersphotostimezones'] = 'Nutzerbilder und Zeitzonen aus Microsoft Entra ID synchronisieren';
$string['task_calsyncautosubscribe'] = 'Kalendersynchronisierung für verbundene Nutzer/innen automatisch aktivieren';
$string['task_groupchannelsync'] = 'Teams-Kanäle für Moodle-Gruppen erstellen und deren Mitglieder synchronisieren';
$string['task_groupchannelsyncgroup'] = 'Den Teams-Kanal einer Moodle-Gruppe erstellen und dessen Mitglieder synchronisieren';
$string['task_userenabledstatussync'] = 'Nutzer/innen anhand des Microsoft Entra ID-Status sperren/wieder aktivieren/löschen';
$string['task_processmatchqueue'] = 'Zuordnungswarteschlange verarbeiten';
$string['task_notifysecretexpiry'] = 'Website-Administration über den Ablauf des geheimen Clientschlüssels der Microsoft Entra ID-App benachrichtigen';
$string['task_checkinvalidconfiglog'] = 'Ungültige Datensätze des Konfigurationsprotokolls prüfen und bereinigen';
$string['task_usergroupmembershipsync'] = 'Kursgruppenmitgliedschaft von Nutzer/innen mit Microsoft 365 synchronisieren';
$string['task_processmatchqueue_err_museralreadymatched'] = 'Das Moodle-Nutzerkonto ist bereits einem Microsoft 365-Nutzerkonto zugeordnet.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'Das Moodle-Nutzerkonto ist bereits mit Microsoft 365 verbunden.';
$string['task_processmatchqueue_err_nomuser'] = 'Es wurde kein Moodle-Nutzerkonto mit diesem Anmeldenamen gefunden.';
$string['task_processmatchqueue_err_noo365user'] = 'Es wurde kein Microsoft 365-Nutzerkonto mit diesem Anmeldenamen gefunden.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'Das Microsoft 365-Nutzerkonto ist bereits einem Moodle-Nutzerkonto zugeordnet.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'Das Microsoft 365-Nutzerkonto ist bereits mit einem Moodle-Nutzerkonto verbunden.';

// Capabilities.
$string['o365:manageconnectionlink'] = 'Verknüpfung von Verbindungen verwalten';
$string['o365:manageconnectionunlink'] = 'Aufhebung der Verknüpfung von Verbindungen verwalten';
$string['o365:managecoursesync'] = 'Teams-Synchronisierung für Kurse über Webservices aktivieren oder deaktivieren';
$string['o365:viewgroups'] = 'Links zu Microsoft 365-Diensten im Microsoft-Block in Kursen mit aktivierter Synchronisierung anzeigen';
$string['o365:managegroups'] = 'Links zu Microsoft 365-Diensten und Verwaltungsoptionen im Microsoft-Block in Kursen mit aktivierter Synchronisierung anzeigen';
$string['o365:teammember'] = 'Teammitglied';
$string['o365:teamowner'] = 'Teambesitzer/in';

// Cache Stores.
$string['cachedef_groups'] = 'Speichert Microsoft 365-Gruppendaten';
$string['cachedef_jwks'] = 'Speichert Microsoft JWKS-Schlüssel';

// Web service errors.
$string['webservices_error_assignnotfound'] = 'Der Aufgabendatensatz des übergebenen Moduls wurde nicht gefunden.';
$string['webservices_error_invalidassignment'] = 'Die übergebene Aufgaben-ID kann mit dieser Webservice-Funktion nicht verwendet werden.';
$string['webservices_error_modulenotfound'] = 'Die übergebene Modul-ID wurde nicht gefunden.';
$string['webservices_error_sectionnotfound'] = 'Der Kursabschnitt wurde nicht gefunden.';
$string['webservices_error_couldnotsavegrade'] = 'Die Bewertung konnte nicht gespeichert werden.';

// User sync task help text.
$string['help_user_create'] = 'Hilfe zum Erstellen von Konten';
$string['help_user_create_help'] = 'Hierdurch werden in Moodle Nutzer/innen für jede/n Nutzer/in im verknüpften Microsoft Entra ID erstellt. Nur für Nutzer/innen, die derzeit kein Moodle-Konto haben, werden Konten erstellt. Neue Konten werden mit der OpenID Connect-Authentifizierungsmethode anhand ihres Microsoft Entra ID-Profils eingerichtet, und sie können alle Funktionen der Microsoft 365-/Moodle-Integration nutzen.';
$string['help_user_update'] = 'Hilfe zum Aktualisieren aller Konten';
$string['help_user_update_help'] = 'Hierdurch werden alle Nutzer/innen in Moodle anhand der Nutzer/innen im verknüpften Microsoft Entra ID aktualisiert.';
$string['help_user_suspend'] = 'Hilfe zum Sperren von Konten';
$string['help_user_suspend_help'] = 'Hierdurch werden Nutzer/innen in Moodle gesperrt, wenn sie in Microsoft Entra ID als gelöscht markiert sind.';
$string['help_user_delete'] = 'Hilfe zum Löschen von Konten';
$string['help_user_delete_help'] = 'Hierdurch werden Nutzer/innen aus Moodle gelöscht, wenn sie in Microsoft Entra ID als gelöscht markiert sind. Dies funktioniert nur, wenn die Option zum Sperren von Nutzer/innen aktiviert ist. Das Moodle-Konto wird gelöscht und alle zugehörigen Nutzerinformationen werden aus Moodle entfernt. Vorsicht! Hinweis: Standardmäßig erfolgt das Löschen 30 Tage nachdem das Konto in Microsoft Entra ID gelöscht wurde, aufgrund der Aufbewahrungsfrist für vorläufig gelöschte Objekte in Entra ID (in dieser Zeit können Konten wiederhergestellt werden). Mit der Einstellung "Verzögerung vor dem Löschen gesperrter Nutzer/innen" kann eine längere Verzögerung zwischen Sperrung und Löschung konfiguriert werden.';
$string['help_user_reenable'] = 'Hilfe zum Wiederaktivieren von Konten';
$string['help_user_reenable_help'] = 'Hierdurch werden gesperrte Moodle-Konten wieder aktiviert, wenn sie von Microsoft Entra ID zurückgegeben werden und sich anmelden dürfen. Konten, deren Anmeldung in Microsoft Entra ID blockiert (deaktiviert) ist, bleiben gesperrt.';
$string['help_user_disabledsyncsuspend'] = 'Hilfe zum Sperren von Konten bei Deaktivierung';
$string['help_user_disabledsyncsuspend_help'] = 'Hierdurch werden Nutzer/innen in Moodle gesperrt, wenn für ihre verbundenen Konten in Microsoft Entra ID die Anmeldung verhindert wird (deaktiviert), ohne zu ändern, ob sie automatisch wieder aktiviert werden, wenn ihr Microsoft Entra ID-Konto wieder aktiviert wird. Verwenden Sie die Option "Konten in Moodle wieder aktivieren, wenn sie in Microsoft Entra ID wieder aktiviert wurden" unten, um dies separat zu steuern.';
$string['help_user_groupsyncsuspend'] = 'Hilfe zum Sperren von Konten, die nicht in der Synchronisierungsgruppe sind';
$string['help_user_groupsyncsuspend_help'] = 'Hierdurch werden Nutzer/innen in Moodle gesperrt, wenn sie in Microsoft Entra ID noch aktiv, aber weder Mitglieder noch Besitzer/innen der in der Einstellung "Gruppenfilter für die Nutzersynchronisierung" konfigurierten Gruppe sind. Geprüft wird nur die aktuelle Mitgliedschaft: Es werden auch bestehende synchronisierte Nutzer/innen gesperrt, die nie in der Gruppe waren, nicht nur solche, die sie verlassen haben. Prüfen Sie daher Ihre Gruppe, bevor Sie diese Option aktivieren. Diese Option ist nur verfügbar, wenn ein Gruppenfilter für die Nutzersynchronisierung konfiguriert ist. Um Massensperrungen zu vermeiden, wird nichts gesperrt, wenn die Gruppe leer ist oder ihre Mitglieder nicht abgerufen werden können. Gesperrte Nutzer/innen werden nicht wieder aktiviert, solange sie nicht in der Gruppe sind.';
$string['help_user_disabledsyncreenable'] = 'Hilfe zum Wiederaktivieren von Konten bei Aktivierung';
$string['help_user_disabledsyncreenable_help'] = 'Hierdurch wird die Sperrung gesperrter Nutzer/innen in Moodle aufgehoben, wenn ihre verbundenen Konten in Microsoft Entra ID sich wieder anmelden dürfen (aktiviert).';
$string['help_user_suspendnolink'] = 'Hilfe zum Sperren von Konten ohne Microsoft-Verknüpfung';
$string['help_user_suspendnolink_help'] = 'Normalerweise wirken die obigen Optionen zum Sperren/Deaktivieren nur auf Konten, die einen gespeicherten Microsoft Entra ID-Objektdatensatz haben (erstellt, als das Konto synchronisiert oder verbunden wurde). Einige OpenID Connect-Konten haben keinen solchen Datensatz – zum Beispiel, weil sie sich verbunden haben, bevor die Microsoft Graph API konfiguriert war, oder weil der Datensatz durch eine Trennung oder die Aktion "Zugeordnete Nutzer/innen zurücksetzen" entfernt wurde. Mit dieser Option prüft der Status-Task auch diese Konten, indem der Moodle-Anmeldename mit dem konfigurierten Wert des bindenden Anmeldenamen-Claims in Entra ID abgeglichen wird.

Zugeordnete Konten, die in Entra ID fehlen oder dort deaktiviert sind, werden <strong>nur gesperrt</strong>: Sie werden nie gelöscht (ohne gespeicherte Objekt-ID kann die Aufbewahrungsfrist für vorläufig gelöschte Objekte in Entra ID nicht geprüft werden) und nie automatisch wieder aktiviert. Gastkonten werden übersprungen.

Diese Option funktioniert nur, wenn der bindende Anmeldenamen-Claim von OpenID Connect auf ein bestimmtes Feld gesetzt ist, das in Entra ID nachgeschlagen werden kann – "upn", "oid", "email" oder "samaccountname". Bei "auto" (wobei der wirksame Claim pro Anmeldung gewählt wird und sich zwischen Nutzer/innen unterscheiden kann) oder einem anderen Claim kann der Moodle-Anmeldename nicht zuverlässig einem einzelnen Konto zugeordnet werden, und diese Option bewirkt nichts.

Prüfen Sie Ihre gesperrten Nutzer/innen nach dem ersten Durchlauf: Ein Konto, das manuell auf diese Authentifizierungsmethode umgestellt wurde und nie ein echtes Entra ID-Konto war, wird durch diese Option gesperrt.';
$string['help_user_match'] = 'Hilfe zum Abgleichen von Konten';
$string['help_user_match_help'] = 'Hierdurch wird jede/r Nutzer/in im verknüpften Microsoft Entra ID betrachtet und versucht, ihn/sie einem/einer Nutzer/in in Moodle zuzuordnen. Der Abgleich basiert auf dem Microsoft Entra ID-UPN und dem Moodle-Anmeldenamen. Beim Abgleich wird die Groß- und Kleinschreibung nicht beachtet und der Domänenteil des Microsoft Entra ID-UPN ignoriert. Beispielsweise stimmt "BoB.SmiTh" in Moodle mit "bob.smith@example.onmicrosoft.com" überein. Bei abgeglichenen Nutzer/innen werden ihr Moodle- und ihr Microsoft Entra ID-Konto verbunden, und sie können alle Funktionen der Microsoft 365- und Moodle-Integration nutzen. Die Authentifizierungsmethode des Nutzers/der Nutzerin ändert sich nicht, es sei denn, die Einstellung unten ist aktiviert.';
$string['help_user_matchswitchauth'] = 'Hilfe zum Umstellen abgeglichener Konten';
$string['help_user_matchswitchauth_help'] = 'Hierfür muss die obige Einstellung "Vorhandene Moodle-Nutzer/innen abgleichen" aktiviert sein. Wenn ein/e Nutzer/in abgeglichen wird, stellt die Aktivierung dieser Einstellung seine/ihre Authentifizierungsmethode auf OpenID Connect um. Er/sie kann sich dann mit den Microsoft 365-Anmeldeinformationen bei Moodle anmelden. Hinweis: Stellen Sie sicher, dass das OpenID Connect-Authentifizierungsplugin aktiviert ist, wenn Sie diese Einstellung verwenden möchten. Warnung: Wenn ein Moodle-Anmeldename nur mit dem Teil des Microsoft Entra ID-UPN vor dem "@" übereinstimmt (und nicht mit dem vollständigen UPN), kann die erweiterte Einstellung "Mindestlänge nicht exakt übereinstimmender Anmeldenamen für die Umstellung auf Microsoft 365" verhindern, dass die Authentifizierungsmethode bei Nutzer/innen mit kurzen Anmeldenamen umgestellt wird.';
$string['help_user_appassign'] = 'Hilfe zum Zuweisen von Nutzer/innen zur Anwendung';
$string['help_user_appassign_help'] = 'Hierdurch werden alle Microsoft Entra ID-Konten mit passenden Moodle-Konten der für diese Moodle-Installation erstellten Microsoft Entra ID-App zugewiesen, sofern sie noch nicht zugewiesen sind.';
$string['help_user_photosync'] = 'Hilfe zur Synchronisierung von Microsoft 365-Profilbildern (Cron)';
$string['help_user_photosync_help'] = 'Hierdurch werden die Moodle-Profilbilder aller Nutzer/innen mit ihren Microsoft 365-Profilbildern synchronisiert.';
$string['help_user_photosynconlogin'] = 'Hilfe zur Synchronisierung von Microsoft 365-Profilbildern (Anmeldung)';
$string['help_user_photosynconlogin_help'] = 'Hierdurch wird das Moodle-Profilbild eines Nutzers/einer Nutzerin mit seinem/ihrem Microsoft 365-Profilbild synchronisiert, wenn er/sie sich anmeldet. Beachten Sie, dass dafür erforderlich ist, dass der/die Nutzer/in in Moodle eine Seite mit dem Microsoft-Block aufruft.';
$string['help_user_nodelta'] = 'Hilfe zur vollständigen Synchronisierung';
$string['help_user_nodelta_help'] = 'Standardmäßig synchronisiert die Nutzersynchronisierung nur die Änderungen aus Microsoft Entra ID seit der letzten Ausführung. Wenn Sie diese Option aktivieren, wird jedes Mal eine vollständige Nutzersynchronisierung erzwungen.';
$string['help_user_emailsync'] = 'Hilfe zum Abgleich von Microsoft Entra ID-Anmeldenamen mit Moodle-E-Mail-Adressen';
$string['help_user_emailsync_help'] = 'Wenn Sie diese Option aktivieren, werden Microsoft Entra ID-Anmeldenamen mit Moodle-E-Mail-Adressen abgeglichen, statt wie standardmäßig Microsoft Entra ID-Anmeldenamen mit Moodle-Anmeldenamen.';
$string['help_user_tzsync'] = 'Hilfe zur Synchronisierung der Outlook-Zeitzone (Cron)';
$string['help_user_tzsync_help'] = 'Hierdurch wird die Moodle-Zeitzone aller Nutzer/innen mit ihrer Outlook-Zeitzoneneinstellung synchronisiert.';
$string['help_user_tzsynconlogin'] = 'Hilfe zur Synchronisierung der Outlook-Zeitzone (Anmeldung)';
$string['help_user_tzsynconlogin_help'] = 'Hierdurch wird die Moodle-Zeitzone eines Nutzers/einer Nutzerin mit seiner/ihrer Outlook-Zeitzoneneinstellung synchronisiert. Beachten Sie, dass dafür erforderlich ist, dass der/die Nutzer/in in Moodle eine Seite mit dem Microsoft-Block aufruft.';
$string['help_user_guestsync'] = 'Hilfe zur Synchronisierung von Gastnutzer/innen';
$string['help_user_guestsync_help'] = 'Wenn aktiviert, werden Gastnutzer/innen in Microsoft Entra ID im Task zur Nutzersynchronisierung mit Moodle synchronisiert.';

// Cohort sync feature.
$string['cohortsync_title'] = 'Synchronisierung globaler Gruppen';
$string['cohortsync_taskname'] = 'Synchronisierung globaler Gruppen';
$string['cohortsync_mappingadded'] = 'Neue Verbindung erfolgreich hinzugefügt';
$string['cohortsync_mappingdeleted'] = 'Verbindung erfolgreich gelöscht';
$string['cohortsync_addmapping'] = 'Verbindung hinzufügen';
$string['cohortsync_deletemapping'] = 'Verbindung löschen';
$string['cohortsync_desc'] = 'Diese Seite ermöglicht die einseitige Synchronisierung von Microsoft 365-Gruppen zu globalen Gruppen in Moodle auf Systemebene. Das Hinzufügen einer neuen Verbindung startet den Synchronisierungsvorgang – Nutzer/innen der ausgewählten Microsoft 365-Gruppe, die mit Microsoft verbunden sind, werden zur ausgewählten globalen Gruppe in Moodle hinzugefügt.';
$string['cohortsync_tabledesc'] = 'Aktuelle Verbindungen zwischen Microsoft 365-Gruppen und globalen Gruppen in Moodle';
$string['cohortsync_typetosearch'] = 'Eingeben, um nach einer Microsoft 365-Gruppe zu suchen';
$string['cohortsync_typetosearch_cohort'] = 'Eingeben, um nach einer globalen Gruppe in Moodle zu suchen';
$string['cohortsync_emptymatchings'] = 'Keine Verbindungen gefunden';
$string['cohortsync_select_cohort'] = 'Globale Gruppe in Moodle';
$string['cohortsync_select_group'] = 'Microsoft 365-Gruppe';
$string['cohortsync_tablehead_group'] = 'Microsoft 365-Gruppe';
$string['cohortsync_tablehead_cohort'] = 'Globale Gruppe in Moodle';
$string['cohortsync_tablehead_actions'] = 'Aktionen';
$string['cohortsync_search'] = 'Suchen';
$string['cohortsync_load_more'] = 'Mehr laden...';
$string['cohortsync_no_groups_found'] = 'Keine Microsoft 365-Gruppen für "{$a}" gefunden';
$string['cohortsync_no_cohorts_found'] = 'Keine globalen Gruppen in Moodle für "{$a}" gefunden';
$string['cohortsync_error_no_group'] = 'Bitte wählen Sie eine Microsoft 365-Gruppe aus.';
$string['cohortsync_error_no_cohort'] = 'Bitte wählen Sie eine globale Gruppe in Moodle aus.';
$string['cohortsync_mappingfailed'] = 'Fehler beim Hinzufügen der Verbindung zwischen globaler Gruppe und Gruppe. Mögliche Ursachen: Die Gruppe oder die globale Gruppe existiert nicht, die Gruppe ist bereits mit einer anderen globalen Gruppe verbunden, die Gruppe ist bereits mit dieser globalen Gruppe verbunden.';
$string['cohortsync_connectionnotfound'] = 'Ungültige Anfrage: Verbindung nicht gefunden.';
$string['cohortsync_connectionnotcohortsync'] = 'Ungültige Anfrage: Verbindungstyp stimmt nicht überein.';
$string['cohortsync_unifiedapierror'] = 'Fehler beim Abrufen der Gruppenliste von Microsoft.';

// Course request.
$string['courserequest_teams'] = 'Microsoft Team';
$string['courserequest_teams_help'] = 'Wählen Sie das Microsoft Team aus, das mit dem Kurs verbunden wird. Bestehende Teambesitzer/innen und -mitglieder werden in den erstellten Kurs eingeschrieben, sobald die Kursanfrage genehmigt wird.';
$string['courserequest_emptyteams'] = 'Keine Microsoft Teams verfügbar';
$string['courserequest_title'] = 'Kurs aus Teams anfragen';
$string['courserequest_updatecourserequeststatus_taskname'] = 'Status der Kursanfrage aktualisieren';
$string['courserequest_customrequestnote'] = '
| Diese Anfrage wurde auf der Kursanfrageseite von Microsoft Teams gestellt und wird bei Genehmigung mit dem Team "{$a->name}" mit der URL {$a->url} verbunden.';
$string['courserequest_graphapi_disabled'] = 'Die Verbindung zu Microsoft Teams ist nicht verfügbar. Bitte wenden Sie sich an Ihre Website-Administration.';
$string['courserequest_invalid_team'] = 'In der Kursanfrage wurde ein ungültiges Team verwendet.';
$string['courserequest_duplicate'] = 'Es existiert bereits eine ausstehende oder genehmigte Kursanfrage desselben Teams.';

// Teams page.
$string['teams_no_course'] = 'Sie haben keinen Kurs, der hinzugefügt werden kann.';
$string['tab_name'] = 'Tab-Name';
$string['sso_login'] = 'Bei Microsoft 365 anmelden';
$string['other_login'] = 'Manuell anmelden';
$string['course_selector_label'] = 'Vorhandenen Kurs auswählen';

// Notifications to site admin about Microsoft Entra ID app secret.
$string['notification_subject_secret_expired'] = 'Aktion erforderlich: Der geheime Clientschlüssel der Microsoft Entra ID-App ist abgelaufen';
$string['notification_content_secret_expired'] = 'Sehr geehrte Website-Administration,

der geheime Clientschlüssel der Microsoft Entra ID-App, der in Ihrer Moodle- und Microsoft 365-Integration verwendet wird, ist abgelaufen.
Bitte erstellen Sie in Microsoft Entra ID einen neuen geheimen Clientschlüssel und aktualisieren Sie ihn in der Konfiguration der Integration, um die Integration wiederherzustellen.';
$string['notification_subject_secret_almost_expired'] = 'Aktion erforderlich: Der geheime Clientschlüssel der Microsoft Entra ID-App läuft bald ab';
$string['notification_content_secret_almost_expired'] = 'Sehr geehrte Website-Administration,

der geheime Clientschlüssel der Microsoft Entra ID-App, der in Ihrer Moodle- und Microsoft 365-Integration verwendet wird, läuft in {$a} ab.
Bitte erstellen Sie in Microsoft Entra ID einen neuen geheimen Clientschlüssel und aktualisieren Sie ihn in der Konfiguration der Integration, um Unterbrechungen der Integration zu vermeiden.';
$string['notification_days_less_than_one_day'] = 'weniger als 1 Tag';
$string['notification_days_one_day'] = '1 Tag';
$string['notification_days_days'] = '{$a} Tagen';
$string['notification_subject_invalid_secret'] = 'Aktion erforderlich: Ungültiger geheimer Clientschlüssel der Microsoft Entra ID-App gefunden';
$string['notification_content_invalid_secret'] = 'Sehr geehrte Website-Administration,

der geheime Clientschlüssel der Microsoft Entra ID-App, der in Ihrer Moodle- und Microsoft 365-Integration verwendet wird, scheint ungültig zu sein. Ursache kann sein, dass der geheime Clientschlüssel abgelaufen ist oder gelöscht wurde.
Bitte prüfen Sie den geheimen Clientschlüssel, um sicherzustellen, dass die Integration wie erwartet funktioniert.';

// Async operations.
$string['teamsasyncfailed'] = 'Der asynchrone Vorgang zur Teamerstellung ist fehlgeschlagen: {$a}';
$string['unknownasyncstate'] = 'Unbekannter Status des asynchronen Vorgangs: {$a}';

// Template ID validation.
$string['error_template_id_empty'] = 'Die Vorlagen-ID darf nicht leer sein.';
$string['error_not_connected'] = 'Nicht mit Microsoft 365 verbunden. Bitte richten Sie zuerst die Microsoft 365-Integration ein.';
$string['error_graph_client_not_available'] = 'Es kann keine Verbindung zur Microsoft Graph API hergestellt werden. Bitte prüfen Sie die Einrichtung Ihrer Microsoft 365-Integration.';
$string['success_template_id_valid'] = '✓ Die Vorlagen-ID "{$a}" ist gültig und zugänglich.';
$string['error_template_id_not_found'] = '✗ Die Vorlagen-ID "{$a}" wurde nicht gefunden. Bitte prüfen Sie die Vorlagen-ID im Teams Admin Center.';
$string['error_template_validation_failed'] = '✗ Validierung der Vorlage fehlgeschlagen: {$a}';
$string['error_template_validation_error'] = '✗ Beim Validieren der Vorlage ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut oder wenden Sie sich an Ihre Administration.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
