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
 * Polish language strings.
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
$string['contactadmin'] = 'Skontaktuj się z administratorem, aby uzyskać więcej informacji.';
$string['error_nomoodlenotebook'] = 'Nie można znaleźć Twojego notatnika Moodle.';
$string['error_urlrequiredwhenenabled'] = 'Ten adres URL musi zostać skonfigurowany, ponieważ opcja „Pokaż” powyżej jest włączona.';
$string['linkonedrive'] = 'Mój OneDrive';
$string['linkonenote'] = 'Mój notatnik OneNote';
$string['linksways'] = 'Moje Sways';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsstreamclassic'] = 'Microsoft Stream (klasyczny)';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'Moja poczta e-mail';
$string['linkonenote_unavailable'] = 'OneNote jest niedostępny';
$string['linksharepoint'] = 'Witryna SharePoint kursu';
$string['linkoutlook'] = 'Ustawienia synchronizacji kalendarza Outlook';
$string['linkprefs'] = 'Edytuj ustawienia';
$string['linkconnection'] = 'Ustawienia połączenia z Microsoft 365';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = 'Dodaj nowy blok Microsoft';
$string['microsoft:myaddinstance'] = 'Dodaj nowy blok Microsoft na stronie Moja Moodle';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Notatnik na platformie Moodle';
$string['workonthis'] = 'Pracuj nad tym';
$string['o365matched_title'] = 'Jesteś <span style="color: #960">prawie</span> połączony z Microsoft 365';
$string['o365matched_desc'] = 'Zostałeś dopasowany do użytkownika Microsoft 365 <b>„{$a}”</b>';
$string['o365matched_complete_authreq'] = 'Aby zakończyć łączenie, kliknij poniższy link i zaloguj się na to konto Microsoft 365.';
$string['o365connected'] = '{$a->firstname}, jesteś obecnie <span class="notifysuccess">połączony</span> z Microsoft 365';
$string['notconnected'] = '<span class="notifyproblem">Nie jesteś połączony</span> z żadnymi usługami Microsoft.';
$string['course_connected_to_team'] = 'Kurs jest <span class="notifysuccess">połączony</span> z zespołem (<b>Team</b>).';
$string['course_connected_to_team_pending'] = 'Kurs jest skonfigurowany do połączenia z zespołem (<b>Team</b>), ale tworzenie zespołu jest <span class="notifyproblem">oczekujące</span>.';
$string['course_connected_to_group_pending'] = 'Kurs jest skonfigurowany do połączenia z zespołem (<b>Team</b>), ale tworzenie grupy jest <span class="notifyproblem">oczekujące</span>.';
$string['course_not_connected'] = 'Kurs <span class="notifyproblem">nie jest połączony</span> z żadnymi usługami Microsoft.';
$string['cachedef_onenotenotebook'] = 'Przechowuje notatnik OneNote.';
$string['logintoo365'] = 'Zaloguj się do Microsoft 365';
$string['connecttoo365'] = 'Połącz z Microsoft 365';
$string['install_office'] = 'Zainstaluj pakiet Office';

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
$string['settings_showemail'] = 'Pokaż „Moja poczta e-mail”';
$string['settings_showemail_desc'] = 'Włącz lub wyłącz link „Moja poczta e-mail” w bloku.';
$string['settings_showmydelve'] = 'Pokaż „Mój Delve”';
$string['settings_showmydelve_desc'] = 'Włącz lub wyłącz link „Mój Delve” w bloku.';
$string['settings_showmyforms'] = 'Pokaż „Moje Forms”';
$string['settings_showmyforms_desc'] = 'Włącz lub wyłącz link „Moje Forms” w bloku.';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = 'Pokaż „Zainstaluj pakiet Office”';
$string['settings_showo365download_desc'] = 'Włącz lub wyłącz link „Zainstaluj pakiet Office” w bloku.';
$string['settings_showsways'] = 'Pokaż „Moje Sways”';
$string['settings_showsways_desc'] = 'Włącz lub wyłącz link „Moje Sways” w bloku.';
$string['settings_showmsstream'] = 'Pokaż „Microsoft Stream (on SharePoint)”';
$string['settings_showmsstream_desc'] = 'Włącz lub wyłącz link „Microsoft Stream (on SharePoint)” w bloku.';
$string['settings_showmsstreamclassic'] = 'Pokaż „Microsoft Stream (klasyczny)”';
$string['settings_showmsstreamclassic_desc'] = 'Włącz lub wyłącz link „Microsoft Stream (klasyczny)” w bloku.';
$string['settings_showmsteams'] = 'Pokaż „Microsoft Teams”';
$string['settings_showmsteams_desc'] = 'Włącz lub wyłącz link „Microsoft Teams” w bloku.';
$string['settings_showonedrive'] = 'Pokaż „Mój OneDrive”';
$string['settings_showonedrive_desc'] = 'Włącz lub wyłącz link „Mój OneDrive” w bloku.';
$string['settings_showonenotenotebook'] = 'Pokaż „Mój notatnik OneNote”';
$string['settings_showonenotenotebook_desc'] = 'Włącz lub wyłącz link „Mój notatnik OneNote” w bloku.';
$string['settings_showoutlooksync'] = 'Pokaż „Ustawienia synchronizacji kalendarza Outlook”';
$string['settings_showoutlooksync_desc'] = 'Włącz lub wyłącz link „Ustawienia synchronizacji kalendarza Outlook” w bloku.';
$string['settings_showpreferences'] = 'Pokaż „Edytuj ustawienia”';
$string['settings_showpreferences_desc'] = 'Włącz lub wyłącz link „Edytuj ustawienia” w bloku.';
$string['settings_showo365connect'] = 'Pokaż „Połącz z Microsoft 365”';
$string['settings_showo365connect_desc'] = 'Włącz lub wyłącz link „Połącz z Microsoft 365” w bloku. <br /><b>Uwaga:</b> Jest on wyświetlany użytkownikom, którzy nie są połączeni z Microsoft 365, i przenosi ich na stronę umożliwiającą skonfigurowanie połączenia.';
$string['settings_showmanageo365conection'] = 'Pokaż „Ustawienia połączenia z Microsoft 365”';
$string['settings_showmanageo365conection_desc'] = 'Włącz lub wyłącz link „Ustawienia połączenia z Microsoft 365” w bloku. <br /><b>Uwaga:</b> Jest on wyświetlany użytkownikom połączonym z Microsoft 365 i przenosi ich na stronę zarządzania połączeniem.';
$string['settings_showcoursespsite'] = 'Pokaż „Witryna SharePoint kursu”';
$string['settings_showcoursespsite_desc'] = 'Włącz lub wyłącz link „Witryna SharePoint kursu” w bloku. <br /><b>Uwaga:</b> Jest on wyświetlany w bloku podczas przeglądania kursu, z którym powiązana jest witryna SharePoint.';
$string['settings_showcourselinks'] = 'Pokaż linki kursu';
$string['settings_showcourselinks_desc'] = 'Włącz lub wyłącz całą sekcję kursu w bloku wyświetlaną podczas przeglądania kursu, w tym nagłówek stanu kursu i wszystkie linki kursu. <br /><b>Uwaga:</b> Po wyłączeniu poniższe ustawienia poszczególnych linków kursu są ignorowane.';
$string['settings_showcourseconfiguresync'] = 'Pokaż „Konfiguruj synchronizację kursu”';
$string['settings_showcourseconfiguresync_desc'] = 'Włącz lub wyłącz link „Konfiguruj synchronizację kursu” w sekcji kursu w bloku.';
$string['settings_showcourseteam'] = 'Pokaż „Zespół”';
$string['settings_showcourseteam_desc'] = 'Włącz lub wyłącz link „Zespół” w sekcji kursu w bloku.';
$string['settings_showcourseconversations'] = 'Pokaż „Konwersacje Outlook”';
$string['settings_showcourseconversations_desc'] = 'Włącz lub wyłącz link „Konwersacje Outlook” w sekcji kursu w bloku.';
$string['settings_showcourseonedrive'] = 'Pokaż „Pliki OneDrive”';
$string['settings_showcourseonedrive_desc'] = 'Włącz lub wyłącz link „Pliki OneDrive” w sekcji kursu w bloku.';
$string['settings_showcoursecalendar'] = 'Pokaż „Kalendarz Outlook”';
$string['settings_showcoursecalendar_desc'] = 'Włącz lub wyłącz link „Kalendarz Outlook” w sekcji kursu w bloku.';
$string['settings_showcoursenotebook'] = 'Pokaż „Notatnik zajęć”';
$string['settings_showcoursenotebook_desc'] = 'Włącz lub wyłącz link „Notatnik zajęć” w sekcji kursu w bloku.';
$string['settings_showcoursereset'] = 'Pokaż „Opcje resetowania kursu”';
$string['settings_showcoursereset_desc'] = 'Włącz lub wyłącz link „Opcje resetowania kursu” w sekcji kursu w bloku.';
$string['settings_geto365link'] = 'Adres URL pobierania pakietu Office';
$string['settings_geto365link_desc'] = 'Adres URL używany dla linku „Zainstaluj pakiet Office”.';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['settings_showword'] = 'Pokaż „Word”';
$string['settings_showword_desc'] = 'Włącz lub wyłącz link „Word” w bloku.';
$string['settings_showexcel'] = 'Pokaż „Excel”';
$string['settings_showexcel_desc'] = 'Włącz lub wyłącz link „Excel” w bloku.';
$string['settings_showpowerpoint'] = 'Pokaż „PowerPoint”';
$string['settings_showpowerpoint_desc'] = 'Włącz lub wyłącz link „PowerPoint” w bloku.';
$string['settings_showvivaengage'] = 'Pokaż „Viva Engage”';
$string['settings_showvivaengage_desc'] = 'Włącz lub wyłącz link „Viva Engage” w bloku.';
$string['settings_showvivaamplify'] = 'Pokaż „Viva Amplify”';
$string['settings_showvivaamplify_desc'] = 'Włącz lub wyłącz link „Viva Amplify” w bloku. <br /><b>Uwaga:</b> Aby link był wyświetlany, należy również skonfigurować poniższy adres URL Viva Amplify.';
$string['settings_vivaamplifyurl'] = 'Adres URL Viva Amplify';
$string['settings_vivaamplifyurl_desc'] = 'Adres URL środowiska Viva Amplify Twojej organizacji, skonfigurowany przez administratora dzierżawcy Microsoft 365, np. https://amplify.microsoft.com/. Akceptowane są tylko adresy URL w domenie amplify.microsoft.com lub amplify.cloud.microsoft.';
$string['settings_showvivaconnections'] = 'Pokaż „Viva Connections”';
$string['settings_showvivaconnections_desc'] = 'Włącz lub wyłącz link „Viva Connections” w bloku. <br /><b>Uwaga:</b> Aby link był wyświetlany, należy również skonfigurować poniższy adres URL Viva Connections.';
$string['settings_vivaconnectionsurl'] = 'Adres URL Viva Connections';
$string['settings_vivaconnectionsurl_desc'] = 'Adres URL środowiska Viva Connections Twojej organizacji, skonfigurowany przez administratora dzierżawcy Microsoft 365. Jest to zazwyczaj główna witryna SharePoint, np. https://yourtenant.sharepoint.com/sites/yourhomesite. Akceptowane są tylko adresy URL w domenie *.sharepoint.com (lub jej odpowiedniku w chmurze suwerennej).';
$string['settings_showvivaglint'] = 'Pokaż „Viva Glint”';
$string['settings_showvivaglint_desc'] = 'Włącz lub wyłącz link „Viva Glint” w bloku.';
$string['settings_showvivagoals'] = 'Pokaż „Viva Goals”';
$string['settings_showvivagoals_desc'] = 'Włącz lub wyłącz link „Viva Goals” w bloku.';
$string['settings_showvivainsights'] = 'Pokaż „Viva Insights”';
$string['settings_showvivainsights_desc'] = 'Włącz lub wyłącz link „Viva Insights” w bloku.';
$string['settings_showvivalearning'] = 'Pokaż „Viva Learning”';
$string['settings_showvivalearning_desc'] = 'Włącz lub wyłącz link „Viva Learning” w bloku. <br /><b>Uwaga:</b> Aby link był wyświetlany, należy również skonfigurować poniższy adres URL Viva Learning.';
$string['settings_vivalearningurl'] = 'Adres URL Viva Learning';
$string['settings_vivalearningurl_desc'] = 'Adres URL środowiska Viva Learning Twojej organizacji, skonfigurowany przez administratora dzierżawcy Microsoft 365, np. https://web.viva.microsoft.com/learning. Akceptowane są tylko adresy URL w domenie viva.microsoft.com lub cloud.microsoft.';
$string['settings_showvivapulse'] = 'Pokaż „Viva Pulse”';
$string['settings_showvivapulse_desc'] = 'Włącz lub wyłącz link „Viva Pulse” w bloku.';
$string['settings_showlinkedin'] = 'Pokaż „LinkedIn”';
$string['settings_showlinkedin_desc'] = 'Włącz lub wyłącz link „LinkedIn” w bloku.';

$string['linkmydelve'] = 'Mój Delve';
$string['linkmyforms'] = 'Moje Forms';
$string['privacy:metadata'] = 'Blok Microsoft wyświetla jedynie linki do różnych funkcji i usług.';

// Course sync features.
$string['course_feature_team'] = 'Zespół';
$string['course_feature_conversations'] = 'Konwersacje Outlook';
$string['course_feature_onedrive'] = 'Pliki OneDrive';
$string['course_feature_calendar'] = 'Kalendarz Outlook';
$string['course_feature_notebook'] = 'Notatnik zajęć';

// Course sync settings.
$string['configure_sync'] = 'Konfiguruj synchronizację kursu';
$string['error_course_sync_not_configurable_per_course'] = 'Synchronizacji kursu nie można konfigurować dla poszczególnych kursów.';
$string['sync_page_heading'] = 'Synchronizuj kurs {$a} z Microsoft Teams';
$string['configure_course_sync'] = 'Konfiguruj synchronizację kursu z Microsoft Teams';
$string['course_sync_option'] = 'Opcja synchronizacji';
$string['course_sync_option_disabled'] = 'Wyłączona';
$string['course_sync_option_enabled'] = 'Włączona';
$string['sync_setting_saved'] = 'Opcja synchronizacji kursu została zapisana';

// Course reset status.
$string['course_reset_disconnect_and_create_new'] = 'Po zresetowaniu kursu zespół (Team) połączony z kursem zostanie przemianowany zgodnie z konfiguracją i zarchiwizowany. Zostanie utworzony nowy zespół (Team) i połączony z kursem.';
$string['course_reset_do_nothing'] = 'Po zresetowaniu kursu połączenie między kursem a zespołem (Team) pozostanie. Wszystkie zmiany użytkowników wprowadzone w kursie będą synchronizowane z zespołem (Team).';
$string['course_reset_disconnect_only'] = 'Po zresetowaniu kursu zespół (Team) połączony z kursem zostanie przemianowany zgodnie z konfiguracją i zarchiwizowany. Nowy zespół (Team) nie zostanie utworzony.';
$string['configure_reset'] = 'Wybierz akcję Microsoft Teams przy resetowaniu kursu';

// Course reset settings page.
$string['reset_page_heading'] = 'Akcja przy resetowaniu kursu {$a}';
$string['configure_course_reset'] = 'Konfiguruj ustawienie resetowania kursu';
$string['course_reset_option'] = 'Akcja dla zespołu (Team) przy resetowaniu kursu';
$string['reset_option_do_nothing'] = 'Nie rób nic.<br/>Zespół (Team) nadal będzie połączony z kursem. Wypisanie użytkowników z kursu spowoduje usunięcie ich jako właścicieli lub członków zespołu (Team).';
$string['reset_option_disconnect_and_create_new'] = 'Odłącz i utwórz nowy zespół (Team).<br/>Istniejący zespół (Team) połączony z kursem zostanie przemianowany zgodnie z konfiguracją i zarchiwizowany. Zostanie utworzony nowy zespół (Team) i połączony z kursem.';
$string['reset_option_disconnect_only'] = 'Tylko odłącz.<br/>Istniejący zespół (Team) połączony z kursem zostanie przemianowany zgodnie z konfiguracją i zarchiwizowany. Nowy zespół (Team) nie zostanie utworzony.';
$string['reset_setting_saved'] = 'Ustawienie resetowania kursu zostało zapisane.';
$string['error_site_course_sync_disabled'] = 'Synchronizacja kursów nie jest włączona';
$string['error_reset_setting_not_managed_per_course'] = 'Konfiguracja akcji resetowania jest zarządzana centralnie przez administratorów witryny.';
$string['error_connected_team_missing'] = 'Kurs jest skonfigurowany do synchronizacji, ale nie można znaleźć zespołu (Team).';
$string['error_course_sync_disabled'] = 'Kurs nie jest skonfigurowany do synchronizacji.';

// Course request.
$string['linkcourserequest'] = 'Poproś o kurs z Teams';
$string['settings_courserequest'] = 'Poproś o kurs z Teams';
$string['settings_courserequest_desc'] = 'Poproś o nowy kurs z Microsoft Teams. Po zatwierdzeniu kurs zostanie utworzony i połączony z zespołem (Team). Członkowie zespołu zostaną zapisani na kurs.';

$string['customlinks'] = 'Własne linki';
$string['customlink_addanother'] = 'Dodaj kolejny link';
$string['customlink_delete'] = 'Usuń ten link';
$string['customlink_error_url'] = 'Wprowadź prawidłowy adres URL zaczynający się od http:// lub https://';
$string['customlink_icon'] = 'Ikona';
$string['customlink_name'] = 'Nazwa';
$string['customlink_nochanges'] = 'Nie wprowadzono żadnych własnych linków, więc nie ma nic do zapisania.';
$string['customlink_showall'] = 'Pokaż także użytkownikom niepołączonym z Microsoft 365';
$string['customlink_target'] = 'Otwórz link w';
$string['customlink_url'] = 'Adres URL';
$string['customlink_visibility'] = 'Widoczność';
$string['settings_header_general'] = 'Ogólne';
$string['settings_pageheading'] = 'Konfiguracja bloku Microsoft';
$string['settings_customlinkheading'] = 'Link {$a}';
$string['settings_customlinktarget_blank'] = 'Nowe okno lub karta';
$string['settings_customlinktarget_self'] = 'To samo okno';
$string['settings_customlinks_desc'] = 'Dodaj własne linki (np. do wewnętrznego chatbota lub witryny intranetowej) do bloku. Nazwa, adres URL i ikona każdego linku są wymagane. Aby usunąć link, zaznacz „Usuń ten link” i zapisz.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
