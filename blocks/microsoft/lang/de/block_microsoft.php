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
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft';
$string['contactadmin'] = 'Wenden Sie sich für weitere Informationen an die Administration.';
$string['error_nomoodlenotebook'] = 'Ihr Moodle-Notizbuch wurde nicht gefunden.';
$string['error_urlrequiredwhenenabled'] = 'Diese URL muss konfiguriert werden, da die Option "Anzeigen" oben aktiviert ist.';
$string['linkonedrive'] = 'Mein OneDrive';
$string['linkonenote'] = 'Mein OneNote-Notizbuch';
$string['linksways'] = 'Meine Sways';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsstreamclassic'] = 'Microsoft Stream (klassisch)';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'Meine E-Mail';
$string['linkonenote_unavailable'] = 'OneNote nicht verfügbar';
$string['linksharepoint'] = 'SharePoint-Website des Kurses';
$string['linkoutlook'] = 'Einstellungen für die Outlook-Kalendersynchronisierung';
$string['linkprefs'] = 'Einstellungen bearbeiten';
$string['linkconnection'] = 'Microsoft 365-Verbindungseinstellungen';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = 'Neuen Microsoft-Block hinzufügen';
$string['microsoft:myaddinstance'] = 'Neuen Microsoft-Block zum Dashboard hinzufügen';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Moodle-Notizbuch';
$string['workonthis'] = 'Hieran arbeiten';
$string['o365matched_title'] = 'Sie sind <span style="color: #960">fast</span> mit Microsoft 365 verbunden';
$string['o365matched_desc'] = 'Sie wurden dem Microsoft 365-Konto <b>"{$a}"</b> zugeordnet';
$string['o365matched_complete_authreq'] = 'Um die Verbindung abzuschließen, klicken Sie bitte auf den folgenden Link und melden Sie sich bei diesem Microsoft 365-Konto an.';
$string['o365connected'] = '{$a->firstname}, Sie sind derzeit mit Microsoft 365 <span class="notifysuccess">verbunden</span>';
$string['notconnected'] = 'Sie sind <span class="notifyproblem">nicht</span> mit Microsoft-Diensten verbunden.';
$string['course_connected_to_team'] = 'Der Kurs ist mit einem <b>Team</b> <span class="notifysuccess">verbunden</span>.';
$string['course_connected_to_team_pending'] = 'Der Kurs ist für die Verbindung mit einem <b>Team</b> konfiguriert, die Erstellung des Teams ist jedoch noch <span class="notifyproblem">ausstehend</span>.';
$string['course_connected_to_group_pending'] = 'Der Kurs ist für die Verbindung mit einem <b>Team</b> konfiguriert, die Erstellung der Gruppe ist jedoch noch <span class="notifyproblem">ausstehend</span>.';
$string['course_not_connected'] = 'Der Kurs ist <span class="notifyproblem">nicht</span> mit Microsoft-Diensten verbunden.';
$string['cachedef_onenotenotebook'] = 'Speichert das OneNote-Notizbuch.';
$string['logintoo365'] = 'Bei Microsoft 365 anmelden';
$string['connecttoo365'] = 'Mit Microsoft 365 verbinden';
$string['install_office'] = 'Office installieren';

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
$string['settings_showemail'] = '"Meine E-Mail" anzeigen';
$string['settings_showemail_desc'] = 'Aktiviert oder deaktiviert den Link "Meine E-Mail" im Block.';
$string['settings_showmydelve'] = '"Mein Delve" anzeigen';
$string['settings_showmydelve_desc'] = 'Aktiviert oder deaktiviert den Link "Mein Delve" im Block.';
$string['settings_showmyforms'] = '"Meine Formulare" anzeigen';
$string['settings_showmyforms_desc'] = 'Aktiviert oder deaktiviert den Link "Meine Formulare" im Block.';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = '"Office installieren" anzeigen';
$string['settings_showo365download_desc'] = 'Aktiviert oder deaktiviert den Link "Office installieren" im Block.';
$string['settings_showsways'] = '"Meine Sways" anzeigen';
$string['settings_showsways_desc'] = 'Aktiviert oder deaktiviert den Link "Meine Sways" im Block.';
$string['settings_showmsstream'] = '"Microsoft Stream (in SharePoint)" anzeigen';
$string['settings_showmsstream_desc'] = 'Aktiviert oder deaktiviert den Link "Microsoft Stream (in SharePoint)" im Block.';
$string['settings_showmsstreamclassic'] = '"Microsoft Stream (klassisch)" anzeigen';
$string['settings_showmsstreamclassic_desc'] = 'Aktiviert oder deaktiviert den Link "Microsoft Stream (klassisch)" im Block.';
$string['settings_showmsteams'] = '"Microsoft Teams" anzeigen';
$string['settings_showmsteams_desc'] = 'Aktiviert oder deaktiviert den Link "Microsoft Teams" im Block.';
$string['settings_showonedrive'] = '"Mein OneDrive" anzeigen';
$string['settings_showonedrive_desc'] = 'Aktiviert oder deaktiviert den Link "Mein OneDrive" im Block.';
$string['settings_showonenotenotebook'] = '"Mein OneNote-Notizbuch" anzeigen';
$string['settings_showonenotenotebook_desc'] = 'Aktiviert oder deaktiviert den Link "Mein OneNote-Notizbuch" im Block.';
$string['settings_showoutlooksync'] = '"Einstellungen für die Outlook-Kalendersynchronisierung" anzeigen';
$string['settings_showoutlooksync_desc'] = 'Aktiviert oder deaktiviert den Link "Einstellungen für die Outlook-Kalendersynchronisierung" im Block.';
$string['settings_showpreferences'] = '"Einstellungen bearbeiten" anzeigen';
$string['settings_showpreferences_desc'] = 'Aktiviert oder deaktiviert den Link "Einstellungen bearbeiten" im Block.';
$string['settings_showo365connect'] = '"Mit Microsoft 365 verbinden" anzeigen';
$string['settings_showo365connect_desc'] = 'Aktiviert oder deaktiviert den Link "Mit Microsoft 365 verbinden" im Block. <br /><b>Hinweis:</b> Dieser Link wird Nutzer/innen angezeigt, die nicht mit Microsoft 365 verbunden sind, und führt sie zu der Seite, auf der sie eine Verbindung einrichten können.';
$string['settings_showmanageo365conection'] = '"Microsoft 365-Verbindungseinstellungen" anzeigen';
$string['settings_showmanageo365conection_desc'] = 'Aktiviert oder deaktiviert den Link "Microsoft 365-Verbindungseinstellungen" im Block. <br /><b>Hinweis:</b> Dieser Link wird mit Microsoft 365 verbundenen Nutzer/innen angezeigt und führt sie zur Seite für die Verbindungsverwaltung.';
$string['settings_showcoursespsite'] = '"SharePoint-Website des Kurses" anzeigen';
$string['settings_showcoursespsite_desc'] = 'Aktiviert oder deaktiviert den Link "SharePoint-Website des Kurses" im Block. <br /><b>Hinweis:</b> Dieser Link wird im Block angezeigt, wenn ein Kurs aufgerufen wird, dem eine SharePoint-Website zugeordnet ist.';
$string['settings_showcourselinks'] = 'Kurslinks anzeigen';
$string['settings_showcourselinks_desc'] = 'Aktiviert oder deaktiviert den gesamten Kursbereich des Blocks, der beim Aufrufen eines Kurses angezeigt wird, einschließlich der Überschrift zum Kursstatus und aller Kurslinks. <br /><b>Hinweis:</b> Wenn diese Option deaktiviert ist, werden die einzelnen Einstellungen für Kurslinks unten ignoriert.';
$string['settings_showcourseconfiguresync'] = '"Kurssynchronisierung konfigurieren" anzeigen';
$string['settings_showcourseconfiguresync_desc'] = 'Aktiviert oder deaktiviert den Link "Kurssynchronisierung konfigurieren" im Kursbereich des Blocks.';
$string['settings_showcourseteam'] = '"Team" anzeigen';
$string['settings_showcourseteam_desc'] = 'Aktiviert oder deaktiviert den Link "Team" im Kursbereich des Blocks.';
$string['settings_showcourseconversations'] = '"Outlook-Unterhaltungen" anzeigen';
$string['settings_showcourseconversations_desc'] = 'Aktiviert oder deaktiviert den Link "Outlook-Unterhaltungen" im Kursbereich des Blocks.';
$string['settings_showcourseonedrive'] = '"OneDrive-Dateien" anzeigen';
$string['settings_showcourseonedrive_desc'] = 'Aktiviert oder deaktiviert den Link "OneDrive-Dateien" im Kursbereich des Blocks.';
$string['settings_showcoursecalendar'] = '"Outlook-Kalender" anzeigen';
$string['settings_showcoursecalendar_desc'] = 'Aktiviert oder deaktiviert den Link "Outlook-Kalender" im Kursbereich des Blocks.';
$string['settings_showcoursenotebook'] = '"Kursnotizbuch" anzeigen';
$string['settings_showcoursenotebook_desc'] = 'Aktiviert oder deaktiviert den Link "Kursnotizbuch" im Kursbereich des Blocks.';
$string['settings_showcoursereset'] = '"Optionen zum Zurücksetzen des Kurses" anzeigen';
$string['settings_showcoursereset_desc'] = 'Aktiviert oder deaktiviert den Link "Optionen zum Zurücksetzen des Kurses" im Kursbereich des Blocks.';
$string['settings_geto365link'] = 'Download-URL für "Office installieren"';
$string['settings_geto365link_desc'] = 'Die URL, die für den Link "Office installieren" verwendet wird.';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['settings_showword'] = '"Word" anzeigen';
$string['settings_showword_desc'] = 'Aktiviert oder deaktiviert den Link "Word" im Block.';
$string['settings_showexcel'] = '"Excel" anzeigen';
$string['settings_showexcel_desc'] = 'Aktiviert oder deaktiviert den Link "Excel" im Block.';
$string['settings_showpowerpoint'] = '"PowerPoint" anzeigen';
$string['settings_showpowerpoint_desc'] = 'Aktiviert oder deaktiviert den Link "PowerPoint" im Block.';
$string['settings_showvivaengage'] = '"Viva Engage" anzeigen';
$string['settings_showvivaengage_desc'] = 'Aktiviert oder deaktiviert den Link "Viva Engage" im Block.';
$string['settings_showvivaamplify'] = '"Viva Amplify" anzeigen';
$string['settings_showvivaamplify_desc'] = 'Aktiviert oder deaktiviert den Link "Viva Amplify" im Block. <br /><b>Hinweis:</b> Damit der Link angezeigt wird, muss außerdem die Viva Amplify-URL unten konfiguriert sein.';
$string['settings_vivaamplifyurl'] = 'Viva Amplify-URL';
$string['settings_vivaamplifyurl_desc'] = 'Die URL der Viva Amplify-Umgebung Ihrer Organisation, wie sie von Ihrem Microsoft 365-Mandantenadministrator konfiguriert wurde, z. B. https://amplify.microsoft.com/. Es werden nur URLs mit einer Domain amplify.microsoft.com oder amplify.cloud.microsoft akzeptiert.';
$string['settings_showvivaconnections'] = '"Viva Connections" anzeigen';
$string['settings_showvivaconnections_desc'] = 'Aktiviert oder deaktiviert den Link "Viva Connections" im Block. <br /><b>Hinweis:</b> Damit der Link angezeigt wird, muss außerdem die Viva Connections-URL unten konfiguriert sein.';
$string['settings_vivaconnectionsurl'] = 'Viva Connections-URL';
$string['settings_vivaconnectionsurl_desc'] = 'Die URL der Viva Connections-Umgebung Ihrer Organisation, wie sie von Ihrem Microsoft 365-Mandantenadministrator konfiguriert wurde. Dies ist in der Regel Ihre SharePoint-Startseitenwebsite, z. B. https://yourtenant.sharepoint.com/sites/yourhomesite. Es werden nur URLs mit einer Domain *.sharepoint.com (oder der entsprechenden Domain einer Sovereign Cloud) akzeptiert.';
$string['settings_showvivaglint'] = '"Viva Glint" anzeigen';
$string['settings_showvivaglint_desc'] = 'Aktiviert oder deaktiviert den Link "Viva Glint" im Block.';
$string['settings_showvivagoals'] = '"Viva Goals" anzeigen';
$string['settings_showvivagoals_desc'] = 'Aktiviert oder deaktiviert den Link "Viva Goals" im Block.';
$string['settings_showvivainsights'] = '"Viva Insights" anzeigen';
$string['settings_showvivainsights_desc'] = 'Aktiviert oder deaktiviert den Link "Viva Insights" im Block.';
$string['settings_showvivalearning'] = '"Viva Learning" anzeigen';
$string['settings_showvivalearning_desc'] = 'Aktiviert oder deaktiviert den Link "Viva Learning" im Block. <br /><b>Hinweis:</b> Damit der Link angezeigt wird, muss außerdem die Viva Learning-URL unten konfiguriert sein.';
$string['settings_vivalearningurl'] = 'Viva Learning-URL';
$string['settings_vivalearningurl_desc'] = 'Die URL der Viva Learning-Umgebung Ihrer Organisation, wie sie von Ihrem Microsoft 365-Mandantenadministrator konfiguriert wurde, z. B. https://web.viva.microsoft.com/learning. Es werden nur URLs mit einer Domain viva.microsoft.com oder cloud.microsoft akzeptiert.';
$string['settings_showvivapulse'] = '"Viva Pulse" anzeigen';
$string['settings_showvivapulse_desc'] = 'Aktiviert oder deaktiviert den Link "Viva Pulse" im Block.';
$string['settings_showlinkedin'] = '"LinkedIn" anzeigen';
$string['settings_showlinkedin_desc'] = 'Aktiviert oder deaktiviert den Link "LinkedIn" im Block.';

$string['linkmydelve'] = 'Mein Delve';
$string['linkmyforms'] = 'Meine Formulare';
$string['privacy:metadata'] = 'Der Microsoft-Block zeigt lediglich Links zu verschiedenen Funktionen und Diensten an.';

// Course sync features.
$string['course_feature_team'] = 'Team';
$string['course_feature_conversations'] = 'Outlook-Unterhaltungen';
$string['course_feature_onedrive'] = 'OneDrive-Dateien';
$string['course_feature_calendar'] = 'Outlook-Kalender';
$string['course_feature_notebook'] = 'Kursnotizbuch';

// Course sync settings.
$string['configure_sync'] = 'Kurssynchronisierung konfigurieren';
$string['error_course_sync_not_configurable_per_course'] = 'Die Kurssynchronisierung kann nicht pro Kurs konfiguriert werden.';
$string['sync_page_heading'] = 'Kurs {$a} mit Microsoft Teams synchronisieren';
$string['configure_course_sync'] = 'Kurssynchronisierung mit Microsoft Teams konfigurieren';
$string['course_sync_option'] = 'Synchronisierungsoption';
$string['course_sync_option_disabled'] = 'Deaktiviert';
$string['course_sync_option_enabled'] = 'Aktiviert';
$string['sync_setting_saved'] = 'Die Option zur Kurssynchronisierung wurde gespeichert';

// Course reset status.
$string['course_reset_disconnect_and_create_new'] = 'Beim Zurücksetzen des Kurses wird das mit dem Kurs verbundene Team gemäß der Konfiguration umbenannt und archiviert. Ein neues Team wird erstellt und mit dem Kurs verbunden.';
$string['course_reset_do_nothing'] = 'Beim Zurücksetzen des Kurses bleibt die Verbindung zwischen dem Kurs und dem Team bestehen. Alle Änderungen an den Nutzer/innen des Kurses werden mit dem Team synchronisiert.';
$string['course_reset_disconnect_only'] = 'Beim Zurücksetzen des Kurses wird das mit dem Kurs verbundene Team gemäß der Konfiguration umbenannt und archiviert. Es wird kein neues Team erstellt.';
$string['configure_reset'] = 'Microsoft Teams-Aktion beim Zurücksetzen des Kurses auswählen';

// Course reset settings page.
$string['reset_page_heading'] = 'Aktion beim Zurücksetzen des Kurses für {$a}';
$string['configure_course_reset'] = 'Einstellung zum Zurücksetzen des Kurses konfigurieren';
$string['course_reset_option'] = 'Aktion für das Team beim Zurücksetzen des Kurses';
$string['reset_option_do_nothing'] = 'Nichts tun.<br/>Das Team bleibt mit dem Kurs verbunden. Wenn Nutzer/innen aus dem Kurs abgemeldet werden, wird ihre Besitzer- bzw. Mitgliedschaft im Team entfernt.';
$string['reset_option_disconnect_and_create_new'] = 'Verbindung trennen und ein neues Team erstellen.<br/>Das bestehende, mit dem Kurs verbundene Team wird gemäß der Konfiguration umbenannt und archiviert. Ein neues Team wird erstellt und mit dem Kurs verbunden.';
$string['reset_option_disconnect_only'] = 'Nur Verbindung trennen.<br/>Das bestehende, mit dem Kurs verbundene Team wird gemäß der Konfiguration umbenannt und archiviert. Es wird kein neues Team erstellt.';
$string['reset_setting_saved'] = 'Die Einstellung zum Zurücksetzen des Kurses wurde gespeichert.';
$string['error_site_course_sync_disabled'] = 'Die Kurssynchronisierung ist nicht aktiviert';
$string['error_reset_setting_not_managed_per_course'] = 'Die Konfiguration der Aktion beim Zurücksetzen wird zentral von der Website-Administration verwaltet.';
$string['error_connected_team_missing'] = 'Der Kurs ist für die Synchronisierung konfiguriert, aber das Team wurde nicht gefunden.';
$string['error_course_sync_disabled'] = 'Der Kurs ist nicht für die Synchronisierung konfiguriert.';

// Course request.
$string['linkcourserequest'] = 'Kurs aus Teams anfordern';
$string['settings_courserequest'] = 'Kurs aus Teams anfordern';
$string['settings_courserequest_desc'] = 'Fordern Sie einen neuen Kurs aus Microsoft Teams an. Nach der Genehmigung wird der Kurs erstellt und mit einem Team verbunden. Die Teammitglieder werden in den Kurs eingeschrieben.';

$string['customlinks'] = 'Benutzerdefinierte Links';
$string['customlink_addanother'] = 'Weiteren Link hinzufügen';
$string['customlink_delete'] = 'Diesen Link löschen';
$string['customlink_error_url'] = 'Geben Sie eine gültige URL ein, die mit http:// oder https:// beginnt';
$string['customlink_icon'] = 'Symbol';
$string['customlink_name'] = 'Name';
$string['customlink_nochanges'] = 'Es wurden keine benutzerdefinierten Links eingegeben, daher gibt es nichts zu speichern.';
$string['customlink_showall'] = 'Auch Nutzer/innen anzeigen, die nicht mit Microsoft 365 verbunden sind';
$string['customlink_target'] = 'Link öffnen in';
$string['customlink_url'] = 'URL';
$string['customlink_visibility'] = 'Sichtbarkeit';
$string['settings_header_general'] = 'Allgemein';
$string['settings_pageheading'] = 'Konfiguration des Microsoft-Blocks';
$string['settings_customlinkheading'] = 'Link {$a}';
$string['settings_customlinktarget_blank'] = 'Neues Fenster oder neuer Tab';
$string['settings_customlinktarget_self'] = 'Gleiches Fenster';
$string['settings_customlinks_desc'] = 'Fügen Sie dem Block eigene Links hinzu (z. B. zu einem internen Chatbot oder einer Intranetseite). Name, URL und Symbol sind für jeden Link erforderlich. Um einen Link zu entfernen, aktivieren Sie "Diesen Link löschen" und speichern Sie.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
