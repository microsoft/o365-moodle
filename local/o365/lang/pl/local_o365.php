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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Integracja pakietu Microsoft 365';

// Settings - tabs.
$string['settings_pageheading'] = 'Konfiguracja {$a}';
$string['settings_header_setup'] = 'Konfiguracja';
$string['settings_header_usersync'] = 'Synchronizacja użytkowników';
$string['settings_header_coursesync'] = 'Synchronizacja kursów';
$string['settings_header_advanced'] = 'Zaawansowane';
$string['settings_header_sds'] = 'Synchronizacja SDS';
$string['settings_header_teams'] = 'Ustawienia usługi Teams';
$string['settings_header_moodle_app'] = 'Aplikacja Moodle w usłudze Teams';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'Krok 1/2: Zarejestruj platformę Moodle w usłudze Microsoft Entra ID';
$string['settings_setup_step1_desc'] = 'Zarejestruj nową aplikację Microsoft Entra ID na potrzeby integracji z platformą Moodle za pomocą programu PowerShell:

<a href="{$a}/local/o365/scripts/Moodle-EntraID-PowerShell.zip" class="btn btn-primary" target="_blank">Pobierz skrypt PowerShell</a>

<p style="margin-top:10px"><a href="{$a}/local/o365/scripts/README.md" target="_blank">Kliknij tutaj</a>, aby zapoznać się z instrukcjami uruchamiania skryptu.</p>
<p>Po wyświetleniu monitu użyj poniższego linku jako adresu URL platformy Moodle:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />Po pomyślnym wykonaniu skryptu skopiuj identyfikator aplikacji i klucz tajny zwrócone przez skrypt na <a href="{$a}">stronę konfiguracji wtyczki uwierzytelniania OpenID Connect</a>.';
$string['settings_setup_step1_credentials_end'] = 'Jeśli nie możesz skonfigurować aplikacji Microsoft Entra ID za pomocą programu PowerShell, <a href="{$a}" target="_blank">kliknij tutaj</a>, aby zobaczyć instrukcje konfiguracji ręcznej.';
$string['settings_setup_step1_continue'] = '<b>Po wprowadzeniu identyfikatora aplikacji i klucza tajnego kliknij „Zapisz zmiany” u dołu strony, aby kontynuować.</b><br /><br /><br /><br /><br />';
$string['settings_setup_step1_existing_settings'] = '<h5>Istniejące ustawienia</h5>';
$string['settings_setup_step2'] = 'Krok 2/2: Zgoda administratora &amp; dodatkowe informacje';
$string['settings_setup_step2_desc'] = 'Ten ostatni krok umożliwia udzielenie zgody administratora na korzystanie z niektórych uprawnień Microsoft Entra ID oraz zbiera dodatkowe informacje o środowisku Microsoft 365.<br /><br />';
$string['settings_setup_step3'] = 'Sprawdź konfigurację';
$string['settings_setup_step3_desc'] = 'Konfiguracja została zakończona. Kliknij poniższy przycisk „Aktualizuj”, aby sprawdzić konfigurację.';

// Settings in "Step 2/2" section of the "Setup" tab.
$string['settings_adminconsent'] = 'Zgoda administratora';
$string['settings_adminconsent_btn'] = 'Udziel zgody administratora';
$string['settings_adminconsent_details'] = 'Aby zezwolić na dostęp do niektórych wymaganych uprawnień, administrator musi udzielić zgody. Kliknij ten przycisk, a następnie zaloguj się za pomocą konta administratora Microsoft Entra ID, aby udzielić zgody. Trzeba to zrobić za każdym razem, gdy zmienisz uprawnienia „Admin” w usłudze Entra ID.';
$string['settings_entratenant'] = 'Dzierżawca Microsoft Entra';
$string['settings_entratenant_details'] = 'Służy do identyfikacji Twojej organizacji w usługach Microsoft. Na przykład: „contoso.onmicrosoft.com”.<br/>
Aby znaleźć tę wartość ręcznie:
<ul>
<li>Przejdź do <a href="https://portal.azure.com" target="_blank">Azure Portal</a>.</li>
<li>Zaloguj się za pomocą konta administratora.</li>
<li>W polu wyszukiwania wpisz „Microsoft Entra ID” i przejdź do strony „Microsoft Entra ID”.</li>
<li>Użyj wartości z pola <b>Domena podstawowa</b> w sekcji „Informacje podstawowe”.</li>
</ul>';
$string['settings_odburl'] = 'Adres URL usługi OneDrive dla firm';
$string['settings_odburl_details'] = 'Adres URL używany w celu uzyskania dostępu do usługi OneDrive dla firm. Zazwyczaj można go określić na podstawie dzierżawcy Microsoft Entra. Na przykład jeżeli dzierżawca Microsoft Entra to „contoso.onmicrosoft.com”, adres ten prawdopodobnie ma postać „contoso-my.sharepoint.com”. Należy wprowadzić tylko nazwę domeny bez ciągu http:// lub https://';
$string['settings_odburl_error_graph'] = 'Nie udało się ustalić adresu URL usługi OneDrive dla firm, wprowadź go ręcznie. Zazwyczaj można go określić na podstawie adresu URL używanego do uzyskiwania dostępu do usługi OneDrive.';
$string['settings_serviceresourceabstract_detect'] = 'Wykryj';
$string['settings_serviceresourceabstract_detecting'] = 'Wykrywanie...';
$string['settings_serviceresourceabstract_error'] = 'Wystąpił błąd podczas wykrywania ustawienia. Ustaw je ręcznie.';
$string['settings_serviceresourceabstract_valid'] = 'Można użyć {$a}.';
$string['settings_serviceresourceabstract_invalid'] = 'Tej wartości nie można użyć.';
$string['settings_serviceresourceabstract_nocreds'] = 'Najpierw ustaw dane logowania do aplikacji.';
$string['settings_serviceresourceabstract_empty'] = 'Wprowadź wartość lub kliknij opcję „Wykryj”, aby podjąć próbę wykrycia prawidłowej wartości.';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_verifysetup'] = 'Sprawdź konfigurację';
$string['settings_verifysetup_appdataheader'] = 'Rejestracja aplikacji Microsoft Entra ID';
$string['settings_verifysetup_appdatadesc'] = 'Sprawdza, czy w aplikacji Entra ID skonfigurowano prawidłowe parametry.';
$string['settings_verifysetup_appdatareplyurlcorrect'] = 'Adres URL odpowiedzi jest prawidłowy';
$string['settings_verifysetup_appdatareplyurlincorrect'] = 'Adres URL odpowiedzi jest nieprawidłowy';
$string['settings_verifysetup_appdatareplyurlgeneralerror'] = 'Nie udało się sprawdzić adresu URL odpowiedzi.';
$string['settings_verifysetup_appdatasignonurlcorrect'] = 'Adres URL logowania jest prawidłowy.';
$string['settings_verifysetup_appdatasignonurlincorrect'] = 'Adres URL logowania jest nieprawidłowy';
$string['settings_verifysetup_appdatasignonurlgeneralerror'] = 'Nie udało się sprawdzić adresu URL logowania.';
$string['settings_verifysetup_apppermscorrect'] = 'Uprawnienia aplikacji są prawidłowe.';
$string['settings_verifysetup_details'] = 'To narzędzie sprawdza w usłudze Microsoft Entra ID, czy wszystko zostało prawidłowo skonfigurowane. <br /><b>Uwaga:</b> Zmiany w aplikacji Microsoft Entra ID mogą pojawić się tutaj z pewnym opóźnieniem. Jeśli wprowadzono zmianę w aplikacji Microsoft Entra ID i nie jest ona tutaj widoczna, poczekaj chwilę i spróbuj ponownie.';
$string['settings_verifysetup_correctval'] = 'Prawidłowa wartość:';
$string['settings_verifysetup_detectedval'] = 'Wykryta wartość:';
$string['settings_verifysetup_update'] = 'Aktualizuj';
$string['settings_verifysetup_checking'] = 'Sprawdzanie...';
$string['settings_verifysetup_missingappperms'] = 'Brakujące uprawnienia aplikacji:';
$string['settings_verifysetup_notgranted'] = 'dodano do aplikacji, ale nie udzielono zgody administratora';
$string['settings_verifysetup_missingperms'] = 'Brakujące uprawnienia delegowane:';
$string['settings_verifysetup_permscorrect'] = 'Uprawnienia delegowane są prawidłowe.';
$string['settings_verifysetup_errorcheck'] = 'Wystąpił błąd podczas próby sprawdzenia konfiguracji.';
$string['settings_verifysetup_noinfo'] = 'Nie mamy jeszcze żadnych informacji o konfiguracji aplikacji Microsoft Entra ID. Kliknij przycisk Aktualizuj, aby sprawdzić.';
$string['settings_verifysetup_strunifiedpermerror'] = 'Wystąpił błąd podczas sprawdzania uprawnień interfejsu Microsoft Graph API.';
$string['settings_verifysetup_strtenanterror'] = 'Przed aktualizacją konfiguracji aplikacji Microsoft Entra ID użyj przycisku Wykryj, aby ustawić dzierżawcę Microsoft Entra.';
$string['settings_verifysetup_unifiedheader'] = 'Microsoft Graph API';
$string['settings_verifysetup_unifieddesc'] = 'Interfejs Microsoft Graph API umożliwia komunikację między platformą Moodle a pakietem Microsoft 365.';
$string['settings_verifysetup_unifiederror'] = 'Wystąpił błąd podczas sprawdzania obsługi interfejsu Microsoft Graph API.';
$string['settings_verifysetup_unifiedactive'] = 'Interfejs Microsoft Graph API jest aktywny.';
$string['settings_verifysetup_unifiedmissing'] = 'Nie znaleziono interfejsu Microsoft Graph API w tej aplikacji.';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc_credsvalid'] = 'Dane logowania zostały ustawione.';
$string['settings_detectoidc_credsvalid_link'] = 'Zmień';
$string['settings_detectoidc_credsinvalid'] = 'Dane logowania nie zostały ustawione lub są niepełne.';
$string['settings_detectoidc_credsinvalid_link'] = 'Ustaw dane logowania';
$string['settings_detectperms_nocreds'] = 'Najpierw należy ustawić dane logowania do aplikacji. Patrz ustawienie powyżej.';
$string['settings_detectperms_errorfix'] = 'Wystąpił błąd podczas próby naprawy uprawnień. Należy je naprawić ręcznie w usłudze Microsoft Entra ID.';
$string['settings_detectperms_fixperms'] = 'Napraw uprawnienia';
$string['settings_detectperms_update'] = 'Aktualizuj';
$string['settings_detectperms_valid'] = 'Uprawnienia zostały skonfigurowane.';
$string['settings_detectperms_invalid'] = 'Sprawdź uprawnienia w usłudze Microsoft Entra ID';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_usersync_general'] = 'Ogólna synchronizacja użytkowników';
$string['settings_usersync_suspension'] = 'Zawieszanie kont w Moodle';
$string['settings_usersync_matching'] = 'Dopasowywanie użytkowników';
$string['settings_usersync_photos'] = 'Synchronizuj zdjęcia profilowe Microsoft 365 z platformą Moodle';
$string['settings_usersync_timezone'] = 'Synchronizuj strefę czasową programu Outlook z platformą Moodle';
$string['settings_usersync'] = 'Synchronizuj użytkowników z usługi Microsoft Entra ID';
$string['settings_usersync_details'] = 'Gdy ta opcja jest włączona, platforma Moodle synchronizuje użytkowników z usługi Microsoft Entra ID zgodnie z powyższymi opcjami.<br /><br /><b>Uwaga: </b>Zadanie synchronizacji działa w ramach crona platformy Moodle i synchronizuje 1000 użytkowników na raz. Domyślnie jest uruchamiane raz dziennie o godz. 1:00 w strefie czasowej serwera. Aby szybciej synchronizować duże zestawy użytkowników, można zwiększyć częstotliwość wykonywania zadania <b>Synchronizuj użytkowników z usługi Microsoft Entra ID</b> na stronie <a href="{$a}">Zarządzanie zaplanowanymi zadaniami.</a><br /><br />';
$string['settings_usersync_create'] = 'Utwórz konta w Moodle dla użytkowników z usługi Microsoft Entra ID';
$string['settings_usersync_update'] = 'Aktualizuj konta w Moodle dla użytkowników z usługi Microsoft Entra ID';
$string['settings_usersync_suspend'] = 'Zawieszaj wcześniej zsynchronizowane konta w Moodle, gdy zostaną usunięte z usługi Microsoft Entra ID';
$string['settings_usersync_delete'] = 'Usuwaj poprzednio zsynchronizowane konta w Moodle, gdy zostaną usunięte z usługi Microsoft Entra ID';
$string['settings_usersync_reenable'] = 'Ponownie włączaj zawieszone konta użytkowników z usługi Microsoft Entra ID';
$string['settings_usersync_disabledsyncsuspend'] = 'Zawieszaj konta w Moodle, gdy zostaną wyłączone w usłudze Microsoft Entra ID';
$string['settings_usersync_disabledsyncreenable'] = 'Ponownie włączaj konta w Moodle, gdy zostaną ponownie włączone w usłudze Microsoft Entra ID';
$string['settings_usersync_suspendnolink'] = 'Zawieszaj połączone konta bez zapisanego linku do Microsoft, gdy zostaną usunięte lub wyłączone w usłudze Microsoft Entra ID';
$string['settings_usersync_groupsyncsuspend'] = 'Zawieszaj konta w Moodle, gdy nie należą do skonfigurowanej grupy synchronizacji użytkowników';
$string['settings_usersync_match'] = 'Dopasuj wcześniej istniejących użytkowników platformy Moodle do kont o tej samej nazwie w usłudze Microsoft Entra ID';
$string['settings_usersync_matchswitchauth'] = 'Przełącz dopasowanych użytkowników na uwierzytelnianie Microsoft 365 (OpenID Connect)';
$string['settings_usersync_appassign'] = 'Przypisuj użytkowników do aplikacji podczas synchronizacji';
$string['settings_usersync_photosync'] = 'Synchronizuj zdjęcia profilowe Microsoft 365 z platformą Moodle w zadaniu cron';
$string['settings_usersync_photosynconlogin'] = 'Synchronizuj zdjęcia profilowe Microsoft 365 z platformą Moodle przy logowaniu';
$string['settings_usersync_nodelta'] = 'Wykonuj pełną synchronizację przy każdym uruchomieniu';
$string['settings_usersync_emailsync'] = 'Podczas synchronizacji dopasowuj nazwy użytkowników Microsoft Entra ID do adresów e-mail w Moodle zamiast do nazw użytkowników w Moodle';
$string['settings_addsync_tzsync'] = 'Synchronizuj strefę czasową programu Outlook z platformą Moodle w zadaniu cron';
$string['settings_addsync_tzsynconlogin'] = 'Synchronizuj strefę czasową programu Outlook z platformą Moodle przy logowaniu';
$string['settings_usersync_guestsync'] = 'Synchronizuj użytkowników-gości';
$string['settings_usersync_delete_delay'] = 'Opóźnienie przed usunięciem zawieszonych użytkowników';
$string['settings_usersync_delete_delay_desc'] = 'Minimalny czas, przez jaki użytkownik musi pozostać zawieszony w Moodle, zanim synchronizacja użytkowników usunie konto. Dotyczy to dodatkowo okresu przechowywania usuniętych elementów w usłudze Microsoft Entra ID, więc usunięcie nigdy nie nastąpi wcześniej. Ustaw 0, aby usuwać konta zaraz po zakończeniu okresu przechowywania w usłudze Microsoft Entra ID. Użytkownicy, którzy byli już zawieszeni przed wprowadzeniem tego ustawienia, są liczeni od pierwszego uruchomienia synchronizacji użytkowników, które ich znajdzie.';
$string['settings_support_user_identifier_change'] = 'Obsługa zmiany wartości oświadczenia nazwy użytkownika powiązania konta Microsoft';
$string['settings_support_user_identifier_change_desc'] = 'Jeśli ta opcja jest włączona, Moodle spróbuje zareagować, gdy zmieni się wartość oświadczenia nazwy użytkownika powiązania, zwykle UPN, konta Microsoft połączonego z kontem Moodle.<br/>
<table class="flexible table table-striped table-hover generaltable generalbox table-sm">
    <tr>
        <th>Identyfikator przypadku</th>
        <th>Czy użytkownik ze starą nazwą użytkownika już się zalogował? (utworzono token)<br/>
        <span class="support_user_identifier_change_case_detail">Czy token jest zapisany w tabeli auth_oidc_token</span>
        </th>
        <th>Pierwsza czynność po zmianie nazwy UPN<br/>
        <span class="support_user_identifier_change_case_detail">Logowanie lub uruchomienie zadania synchronizacji użytkowników</span>
        </th>
        <th>Możliwy duplikat nazwy użytkownika<br/>
        <span class="support_user_identifier_change_case_detail">Czy zmiana nazwy spowodowałaby konflikt nazw użytkowników w Moodle</span>
        </th>
        <th>Oczekiwane zachowanie</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Tak</td>
        <td>Logowanie</td>
        <td>Nie</td>
        <td>
            <ol>
                <li>Zmień nazwę użytkownika Moodle.</li>
                <li>Tabela auth_oidc_token zostaje zaktualizowana o nowe wartości w polach „username” i „oidcusername”.</li>
                <li>Pole „o365name” rekordu połączenia użytkownika local_o365_objects zostaje zaktualizowane do nowej wartości.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Tak</td>
        <td>Synchronizacja użytkowników</td>
        <td>Nie</td>
        <td>
            <ol>
                <li>Zmień nazwę użytkownika Moodle.</li>
                <li>Rekord połączenia użytkownika local_o365_objects zostaje zaktualizowany.</li>
                <li>Tabela auth_oidc_token zostaje zaktualizowana.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>Nie</td>
        <td>Logowanie</td>
        <td>Nie</td>
        <td>
            <ol>
                <li>Zmień nazwę użytkownika Moodle.</li>
                <li>Rekord połączenia użytkownika local_o365_objects zostaje zaktualizowany.</li>
                <li>Tabela auth_oidc_token zostaje zaktualizowana.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>Nie</td>
        <td>Synchronizacja użytkowników</td>
        <td>Nie</td>
        <td>
            <ol>
                <li>Zmień nazwę użytkownika Moodle.</li>
                <li>Rekord połączenia użytkownika local_o365_objects zostaje zaktualizowany.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>Tak</td>
        <td>Logowanie</td>
        <td>Tak</td>
        <td>
            <ol>
                <li>Zgłoś wyjątek i nie zmieniaj nazwy użytkownika Moodle.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>Tak</td>
        <td>Synchronizacja użytkowników</td>
        <td>Tak</td>
        <td>
            <ol>
                <li>Wyświetl komunikat o błędzie informujący, że próba zmiany nazwy w zadaniu synchronizacji użytkowników nie powiodła się.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>Nie</td>
        <td>Logowanie</td>
        <td>Tak</td>
        <td>
            <ol>
                <li>Zgłoś wyjątek i nie zmieniaj nazwy użytkownika Moodle.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>Nie</td>
        <td>Synchronizacja użytkowników</td>
        <td>Tak</td>
        <td>
            <ol>
                <li>Wyświetl komunikat o błędzie informujący, że próba zmiany nazwy w zadaniu synchronizacji użytkowników nie powiodła się.</li>
            </ol>
        </td>
    </tr>
</table>
Należy pamiętać o znanym problemie: jeśli
<ol>
<li>Moodle i Microsoft 365 są połączone za pomocą metody połączenia „Microsoft identity platform (v2.0)”, oraz</li>
<li>w Microsoft Entra skonfigurowano zezwolenie na używanie „adresu e-mail jako alternatywnego identyfikatora logowania”, oraz</li>
<li>ta opcja jest włączona, oraz</li>
<li>nazwa użytkownika i adres e-mail konta Microsoft są różne, oraz</li>
<li>użytkownik Microsoft loguje się za pomocą adresu e-mail zamiast nazwy użytkownika,</li>
</ol>
to wtyczka auth_oidc potraktuje adres e-mail jako nazwę użytkownika konta Microsoft i zaktualizuje nazwę użytkownika w Moodle.';

// User field mapping.
$string['settings_fieldmap'] = 'Mapowanie pól użytkownika';
$string['settings_fieldmap_details'] = 'Dostępne we <a href="{$a}">wtyczce uwierzytelniania OpenID Connect</a>.';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'Synchronizacja kursów';
$string['settings_secthead_coursesync_desc'] = 'Poniższe ustawienia kontrolują synchronizację kursów między platformą Moodle a usługą Microsoft Teams.';
$string['settings_coursesync'] = 'Synchronizacja kursów';
$string['settings_coursesync_details'] = 'Jeśli ta opcja jest włączona, zespoły usługi Teams dla kursów w witrynie Moodle będą tworzone i utrzymywane (domyślnie: wyłączona). Wymagane zespoły będą tworzone przy każdym uruchomieniu crona, a wszyscy aktualnie zapisani użytkownicy zostaną dodani jako właściciele lub członkowie zespołu, w zależności od sprawdzenia uprawnień. Następnie członkostwo w zespole będzie utrzymywane w miarę zapisywania użytkowników na kursy Moodle lub wypisywania z nich.';
$string['acp_coursesynccustom_off'] = 'Wyłączone<br />Wyłącza tworzenie zespołów usługi Teams dla wszystkich kursów.';
$string['acp_coursesynccustom_oncustom'] = 'Dostosuj<br />Umożliwia uprawnionym użytkownikom wybór kursów, dla których będą tworzone zespoły usługi Teams.<br> <span id="adminsetting_coursesync" style="font-weight: bold"><a href="{$a}">Dostosuj synchronizację kursów</a></span>';
$string['acp_coursesynccustom_onall'] = 'Wszystkie funkcje włączone<br />Włącza tworzenie zespołów usługi Teams dla wszystkich kursów.';
$string['settings_coursesync_sync_hidden_courses'] = 'Synchronizuj ukryte kursy';
$string['settings_coursesync_sync_hidden_courses_desc'] = 'Domyślnie wtyczka ignoruje ukryte kursy, aby nie synchronizować kursów, które są kopiowane lub przywracane. Włącz to ustawienie, aby wymusić tworzenie zespołów usługi Teams dla ukrytych kursów.';
$string['acp_coursesync_hidden_course_note'] = 'Uwaga: ukryte kursy nie będą przetwarzane pod kątem tworzenia grup usługi Teams. Aby to umożliwić, należy włączyć ustawienie „Synchronizuj ukryte kursy” w konfiguracji wtyczki.';
$string['settings_coursesync_delete_group_on_course_deletion'] = 'Usuwaj grupy Microsoft 365, gdy połączony kurs Moodle zostanie usunięty';
$string['settings_coursesync_delete_group_on_course_deletion_details'] = 'Jeśli ta opcja jest włączona, Moodle spróbuje usunąć grupę Microsoft 365 (i powiązany zespół), gdy połączony kurs zostanie usunięty z Moodle. Należy pamiętać, że nie dotyczy to kursów utworzonych za pomocą synchronizacji SDS.';
$string['settings_coursesync_delete_group_on_course_sync_disabled'] = 'Usuwaj grupy Microsoft 365, gdy synchronizacja kursu zostanie wyłączona';
$string['settings_coursesync_delete_group_on_course_sync_disabled_details'] = 'Jeśli ta opcja jest włączona, Moodle spróbuje usunąć połączoną grupę Microsoft 365 (i powiązany zespół), gdy synchronizacja kursu zostanie wyłączona dla kursu Moodle.';
$string['settings_coursesync_courses_per_task'] = 'Liczba kursów do synchronizacji przy każdym uruchomieniu zadania';
$string['settings_coursesync_courses_per_task_details'] = 'Liczba kursów, dla których stan synchronizacji zespołu/grupy ma być przetwarzany przy każdym uruchomieniu zadania.';
$string['settings_coursesync_team_type'] = 'Szablon zespołu';
$string['settings_coursesync_team_type_desc'] = 'Szablon usługi Microsoft Teams używany podczas tworzenia zespołów z kursów Moodle. Szablony edukacyjne wymagają licencji edukacyjnej. <br><br><strong>Ważne:</strong> Skonfigurowany szablon określa sposób tworzenia grup i zespołów:<br>
&bull; Szablon standardowy tworzy standardowe grupy i zespoły (zgodne ze wszystkimi dzierżawcami).<br>
&bull; Szablony edukacyjne tworzą grupy/zespoły edukacyjne (tylko dla dzierżawców edukacyjnych; włącza funkcje specyficzne dla edukacji).<br>
&bull; Szablony niestandardowe używają grup standardowych (dla zgodności z projektem szablonu niestandardowego).<br><br>
<strong>⚠️ OSTRZEŻENIE: Po utworzeniu zespołu przy użyciu danego szablonu nie można go zmienić.</strong> Zespoły pozostają powiązane ze swoim pierwotnym szablonem. Zmiana tego ustawienia dotyczy tylko nowo tworzonych zespołów, a nie istniejących. Starannie zaplanuj wybór szablonu przed włączeniem synchronizacji kursów.';
$string['settings_coursesync_team_type_standard'] = 'Standardowy';
$string['settings_coursesync_team_type_educationclass'] = 'Edukacja - zespół klasy';
$string['settings_coursesync_team_type_educationstaff'] = 'Edukacja - zespół pracowników';
$string['settings_coursesync_team_type_educationplc'] = 'Edukacja - społeczność uczenia się zawodowego (PLC)';
$string['settings_coursesync_team_type_custom'] = 'Szablon niestandardowy';
$string['settings_coursesync_team_type_custom_id'] = 'Identyfikator szablonu niestandardowego';
$string['settings_coursesync_team_type_custom_id_desc'] = 'Pełny identyfikator szablonu niestandardowego zdefiniowanego w centrum administracyjnym usługi Teams. Używany tylko wtedy, gdy powyżej wybrano „Szablon niestandardowy”. <br><br><strong>Identyfikator szablonu musi mieć format GUID</strong> (np. e41de7bb-859a-4a0f-aa39-5725a0529c1c). Identyfikator szablonu można znaleźć w centrum administracyjnym usługi Teams podczas wyświetlania szczegółów szablonu niestandardowego. <br><br>
<strong>⚠️ WYMAGANE DODATKOWE UPRAWNIENIE MICROSOFT ENTRA ID:</strong> Weryfikacja i używanie niestandardowych szablonów zespołów wymaga dodatkowego uprawnienia aplikacji Microsoft Graph API (<strong>TeamTemplates.Read.All</strong>), które może nie być obecne w rejestracji aplikacji Microsoft Entra ID. Bez tego uprawnienia krok weryfikacji zakończy się niepowodzeniem i nie będzie można ustawić identyfikatora szablonu niestandardowego. Jeśli weryfikacja nie powiedzie się z powodu błędu uprawnień, skontaktuj się z administratorem Microsoft Entra ID, aby dodał to uprawnienie do rejestracji aplikacji. <br><br>
<strong>⚠️ WAŻNE OGRANICZENIE:</strong> Platforma Microsoft Teams obecnie obsługuje tworzenie zespołów z szablonów niestandardowych tylko wtedy, gdy szablon zawiera <strong>definicję ustawień regionalnych en-US</strong>. Tworzenie zespołów z szablonów niestandardowych bez obsługi ustawień regionalnych en-US zakończy się niepowodzeniem. Upewnij się, że szablon niestandardowy ma zdefiniowane ustawienia regionalne en-US w centrum administracyjnym usługi Teams. <br><br>
<strong>⚠️ OSTRZEŻENIE: Po utworzeniu zespołu przy użyciu tego szablonu niestandardowego nie można go zmienić.</strong> Jeśli chcesz użyć innego szablonu niestandardowego dla nowych zespołów, musisz pozostawić to ustawienie puste lub zmienić je przed utworzeniem kolejnego zespołu. Istniejące zespoły nadal będą korzystać ze swojego pierwotnego szablonu. <br><br>
Zespoły nie zostaną utworzone prawidłowo, jeśli skonfigurowano nieprawidłowy identyfikator szablonu. Użyj przycisku „Zweryfikuj identyfikator szablonu niestandardowego”, aby zweryfikować identyfikator szablonu przed uruchomieniem synchronizacji kursów.';
$string['error_custom_template_id_required'] = 'Identyfikator szablonu niestandardowego jest wymagany w przypadku opcji „Szablon niestandardowy”. Wprowadź prawidłowy identyfikator szablonu.';
$string['error_custom_template_id_not_found'] = 'Nie znaleziono identyfikatora szablonu niestandardowego „{$a}”. Sprawdź, czy identyfikator szablonu istnieje w centrum administracyjnym usługi Teams.';
$string['error_custom_template_id_validation_failed'] = 'Weryfikacja identyfikatora szablonu niestandardowego nie powiodła się. Szablon może nie obsługiwać bezpośredniego tworzenia zespołów lub wystąpił problem z konfiguracją. Sprawdź identyfikator szablonu w centrum administracyjnym usługi Teams.';
$string['settings_team_type_custom_id_test_button'] = 'Zweryfikuj identyfikator szablonu niestandardowego';
$string['settings_team_type_custom_id_validating'] = '🔄 Weryfikowanie...';
$string['settings_team_type_custom_id_error_empty'] = '⚠️ Najpierw wprowadź identyfikator szablonu.';
$string['settings_team_type_custom_id_error_not_found'] = '✗ Nie znaleziono szablonu. Identyfikator szablonu „{$a}” nie istnieje. Sprawdź go w centrum administracyjnym usługi Teams.';
$string['settings_team_type_custom_id_error_validation'] = '✗ Błąd weryfikacji. {$a}';
$string['settings_team_type_custom_id_error_default'] = 'Nie udało się zweryfikować szablonu. Spróbuj ponownie lub skontaktuj się z administratorem.';
$string['settings_team_type_custom_id_error_timeout'] = '✗ Przekroczono limit czasu weryfikacji. Żądanie trwało dłużej niż 10 sekund. Spróbuj ponownie.';
$string['settings_team_type_custom_id_error_network'] = '✗ Błąd sieci. Nie można połączyć się z usługą weryfikacji. Sprawdź połączenie z Internetem i spróbuj ponownie.';
$string['settings_team_type_custom_id_error_parsererror'] = '✗ Błąd odpowiedzi serwera. Usługa weryfikacji zwróciła nieprawidłowe dane. Sprawdź integrację z pakietem Microsoft 365.';
$string['settings_team_type_custom_id_error_http'] = '✗ Błąd weryfikacji (HTTP {$a}). Spróbuj ponownie lub skontaktuj się z administratorem.';
$string['settings_coursesync_group_channels'] = 'Utwórz kanał dla każdej grupy Moodle';
$string['settings_coursesync_group_channels_details'] = 'Tworzy kanał prywatny w połączonym zespole Microsoft Teams dla każdej grupy w kursie Moodle i utrzymuje członków każdego kanału zgodnie z członkami grupy Moodle. Członkowie grupy, którzy są również połączeni z Microsoft 365, są dodawani do kanału lub usuwani z niego po dodaniu do grupy lub usunięciu z niej. Każda osoba dodana do kanału w usłudze Microsoft Teams, która nie jest członkiem grupy Moodle, zostanie ponownie usunięta. W zespole klasy edukacyjnej, który nie został jeszcze aktywowany, nie można umieścić uczniów w kanałach: dodawani są tylko właściciele, a uczniowie są dodawani automatycznie przez zaplanowane zadanie „Utwórz kanały Teams dla grup Moodle i synchronizuj ich członków” po aktywowaniu zespołu przez właściciela w usłudze Microsoft Teams. Kanały nie są zmieniane ani usuwane po zmianie nazwy lub usunięciu grupy Moodle. Członkostwo w kanałach jest synchronizowane wyłącznie z Moodle do Teams, a to ustawienie nie działa, jeśli opcja „Zachowanie synchronizacji użytkowników kursu” ma wartość „Z Teams do Moodle”. Usługa Microsoft Teams dopuszcza do 1000 kanałów w zespole, wliczając kanały prywatne i kanały usunięte w ciągu ostatnich 30 dni.<br /><br /><b>To ustawienie wymaga dwóch dodatkowych uprawnień aplikacji Microsoft Graph:</b><ul><li><b>Channel.Create</b> - do tworzenia kanałów.</li><li><b>ChannelMember.ReadWrite.All</b> - do dodawania członków do kanałów i usuwania ich z kanałów.</li></ul>Oba muszą zostać dodane do aplikacji Microsoft Entra ID używanej przez Moodle i objęte zgodą administratora. Skrypt PowerShell na karcie „Konfiguracja” już je zawiera podczas rejestracji nowej aplikacji. W przypadku istniejącej aplikacji dodaj je ręcznie w sekcji Rejestracje aplikacji &gt; Twoja aplikacja &gt; Uprawnienia interfejsu API &gt; Dodaj uprawnienie &gt; Microsoft Graph &gt; Uprawnienia aplikacji, a następnie udziel zgody administratora. Gdy to ustawienie jest włączone, opcja „Sprawdź konfigurację” na karcie „Konfiguracja” zgłasza te uprawnienia jako brakujące, dopóki nie zostaną przyznane.';
$string['settings_coursesync_sync_direction'] = 'Zachowanie synchronizacji użytkowników kursu';
$string['settings_coursesync_sync_direction_details'] = 'Wybierz kierunek synchronizacji użytkowników między platformą Moodle a usługą Microsoft Teams.';
$string['settings_coursesync_sync_moodle_to_teams'] = 'Z Moodle do Teams';
$string['settings_coursesync_sync_teams_to_moodle'] = 'Z Teams do Moodle';
$string['settings_coursesync_sync_both'] = 'Aktualizuj zarówno Teams, jak i Moodle';
$string['settings_coursesync_enrolment_owner_role'] = 'Rola właściciela zespołu';
$string['settings_coursesync_enrolment_owner_role_desc'] = 'Rola, która zostanie przypisana właścicielowi zespołu podczas synchronizacji.';
$string['settings_coursesync_enrolment_member_role'] = 'Rola członka zespołu';
$string['settings_coursesync_enrolment_member_role_desc'] = 'Rola, która zostanie przypisana członkom zespołu podczas synchronizacji.';

// Settings in the "Course sync customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_coursesynccustom'] = 'Dostosowanie synchronizacji kursów';
$string['acp_coursesynccustom_enabled'] = 'Włączone';
$string['acp_coursesynccustom_enable_all'] = 'Włącz synchronizację kursów dla wszystkich kursów';
$string['acp_coursesynccustom_disable_all'] = 'Wyłącz synchronizację kursów dla wszystkich kursów';
$string['acp_coursesynccustom_bulk'] = 'Operacje zbiorcze';
$string['acp_coursesynccustom_bulk_enable'] = 'Włącz synchronizację kursów dla kursów na tej stronie';
$string['acp_coursesynccustom_bulk_disable'] = 'Wyłącz synchronizację kursów dla kursów na tej stronie';
$string['acp_coursesynccustom_settings_header'] = 'Opcje synchronizacji';
$string['acp_coursesynccustom_new_course'] = 'Domyślnie włączone dla nowych kursów';
$string['acp_coursesynccustom_new_course_desc'] = 'Jeśli ta opcja jest włączona, wszystkie nowo utworzone kursy będą miały domyślnie włączoną synchronizację.';
$string['acp_coursesynccustom_controlled_per_course'] = 'Zezwalaj na konfigurowanie synchronizacji kursu w kursach';
$string['acp_coursesynccustom_controlled_per_course_desc'] = 'Jeśli ta opcja jest włączona, użytkownicy zapisani na kursy Moodle, którzy mogą pełnić rolę właścicieli zespołu (mają uprawnienie „Właściciel zespołu” [local/o365:teamowner]), będą mogli kontrolować synchronizację kursu za pomocą bloku Microsoft w kursie.';
$string['acp_coursesynccustom_savemessage'] = 'Twoje zmiany zostały zapisane.';
$string['acp_coursesynccustom_regex_search'] = 'Wyszukiwanie wyrażeniem regularnym';
$string['acp_coursesynccustom_regex_search_title'] = 'Po zaznaczeniu tekst z powyższego pola wyszukiwania jest dopasowywany jako wyrażenie regularne PCRE (bez ograniczników) do pełnej nazwy, nazwy skróconej i numeru ID, zamiast zwykłego wyszukiwania tekstu.';
$string['acp_coursesynccustom_confirm_all_action'] = 'Czy na pewno chcesz zmienić stan synchronizacji wszystkich kursów? Tej czynności nie można cofnąć.';
$string['acp_coursesynccustom_sds_course'] = 'Zablokowane dla kursu SDS';
$string['acp_coursesynccustom_all_enabled_notice'] = 'Synchronizacja kursów jest obecnie włączona dla wszystkich kursów. Dostosowanie poszczególnych kursów jest wyłączone, ponieważ aktywny jest tryb „Wszystkie funkcje włączone”.';
$string['acp_coursesynccustom_disabled_notice'] = 'Synchronizacja kursów jest obecnie globalnie wyłączona. Dostosowanie poszczególnych kursów jest wyłączone, ponieważ aktywny jest tryb „Wyłączone”.';
$string['acp_coursesynccustom_categories_header'] = 'Synchronizacja według kategorii kursów';
$string['acp_coursesynccustom_categories_desc'] = 'Wybierz jedną lub więcej kategorii kursów, aby automatycznie włączyć synchronizację kursów dla wszystkich kursów w tych kategoriach, łącznie z ich podkategoriami. Dotyczy to również kursów dodanych do wybranych kategorii w przyszłości. Przytrzymaj klawisz Ctrl (Cmd na komputerze Mac), aby wybrać wiele kategorii, lub kliknij ponownie, przytrzymując go, aby anulować wybór.';
$string['acp_coursesynccustom_category_course'] = 'Zablokowane: włączone według kategorii kursów';

// Settings in the "Cohort sync" section of the "Sync settings" tab.
$string['settings_secthead_cohortsync'] = 'Synchronizacja kohort';
$string['settings_secthead_cohortsync_desc'] = 'Ta funkcja umożliwia synchronizację między grupami Microsoft 365 a kohortami Moodle.';
$string['settings_cohortsync'] = 'Synchronizacja kohort';
$string['settings_cohortsync_linktext'] = 'Zarządzaj synchronizacją kohort';
$string['settings_cohortsync_details'] = 'Przeglądaj synchronizację między kohortami Moodle a grupami Microsoft 365 i zarządzaj nią.';
$string['settings_cohortsync_title'] = 'Synchronizacja kohort';
$string['settings_cohortsync_excludeowners'] = 'Wyklucz właścicieli grup z synchronizacji kohort';
$string['settings_cohortsync_excludeowners_desc'] = 'Jeśli ta opcja jest włączona, właściciele grup nie są synchronizowani z kohortami Moodle, nawet jeśli są również członkami grupy. Właściciele, którzy już należą do kohorty, zostaną z niej usunięci przy następnym uruchomieniu synchronizacji.';

// Settings in the "Team / group names" section of the "Sync settings" tab.
$string['settings_secthead_team_group_name'] = 'Nazwy zespołów / grup';
$string['settings_secthead_team_group_name_desc'] = 'Jeśli kurs jest skonfigurowany do synchronizacji, nazwa zespołu i grupy zostanie utworzona w następujący sposób.<br/>
<ul>
<li>Można zdefiniować alias pocztowy grupy i nazwy wyświetlane zespołu.</li>
<li>Najpierw zostanie utworzona grupa Microsoft 365 przy użyciu skonfigurowanego aliasu mailNickname grupy i nazwy wyświetlanej zespołu, a następnie z grupy zostanie utworzony zespół.</li>
<li>Jeśli używane są zasady nazewnictwa Microsoft Entra ID dla grup Microsoft 365, grupy nie zostaną utworzone, gdy nazwa wyświetlana utworzona zgodnie z konfiguracją nie spełnia tych zasad.</li>
<li>Zmiany wprowadzone tutaj będą miały wpływ tylko na przyszłe tworzenie zespołów, a nie na istniejące.</li>
<li>Wszystkie spacje zostaną usunięte z aliasu pocztowego grupy.</li>
<li>W aliasie pocztowym grupy dozwolone są tylko wielkie i małe litery, cyfry oraz znaki - i _.</li>
<li>Alias pocztowy grupy, wraz z prefiksem i sufiksem, nie może przekraczać 64 znaków.</li>
<li>Alias pocztowy grupy musi być unikalny, w przeciwnym razie zostanie dołączona losowa liczba 4-cyfrowa, aby zapewnić unikalność.</li>
</ul>';
$string['settings_team_name_prefix'] = 'Prefiks nazwy zespołu';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'Część nazwy zespołu pochodząca z kursu';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'Sufiks nazwy zespołu';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_group_mail_alias_prefix'] = 'Prefiks aliasu pocztowego grupy';
$string['settings_group_mail_alias_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'Część aliasu pocztowego grupy pochodząca z kursu';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'Sufiks aliasu pocztowego grupy';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'Załóżmy, że kurs ma:
<ul>
<li>Pełna nazwa: <b>Sample course</b></li>
<li>Nazwa skrócona: <b>sample 15</b></li>
<li>Identyfikator utworzony przez Moodle: <b>2</b></li>
<li>Numer ID: <b>Sample ID 15</b></li>
</ul>
Bieżące ustawienie utworzy grupę z aliasem pocztowym „<b>{$a->mailalias}</b>” oraz zespół o nazwie „<b>{$a->teamname}</b>”.<br/>
Kliknij poniższy przycisk „Zapisz zmiany”, aby zobaczyć, jak zmienią się te wartości po zastosowaniu ustawień.';
$string['settings_main_name_option_full_name'] = 'Pełna nazwa';
$string['settings_main_name_option_short_name'] = 'Nazwa skrócona';
$string['settings_main_name_option_id'] = 'Identyfikator utworzony przez Moodle';
$string['settings_main_name_option_id_number'] = 'Numer ID';
$string['settings_team_name_sync'] = 'Aktualizuj nazwę zespołu przy aktualizacji kursu';
$string['settings_team_name_sync_desc'] = 'Jeśli ta opcja jest włączona, po zaktualizowaniu kursu Moodle nazwa zespołu zostanie zaktualizowana zgodnie z najnowszymi ustawieniami nazw zespołów.';

// Settings in the "Course request" section of the "Sync settings" tab.
$string['settings_secthead_course_request'] = 'Żądanie kursu';
$string['settings_secthead_course_request_desc'] = 'Ustawienia mapowania ról w funkcji żądania kursu z usługi Teams.';
$string['settings_course_request_enrolment_owner_role'] = 'Rola właściciela zespołu';
$string['settings_course_request_enrolment_owner_role_desc'] = 'Rola, która zostanie przypisana właścicielowi zespołu po zatwierdzeniu żądania kursu.';
$string['settings_course_request_enrolment_member_role'] = 'Rola członka zespołu';
$string['settings_course_request_enrolment_member_role_desc'] = 'Rola, która zostanie przypisana członkom zespołu po zatwierdzeniu żądania kursu.';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'Narzędzia';
$string['settings_secthead_calsync'] = 'Synchronizacja kalendarza';
$string['settings_calsyncsubscribemode'] = 'Subskrypcja synchronizacji kalendarza';
$string['settings_calsyncsubscribemode_details'] = 'Określa, czy użytkownicy muszą sami włączyć synchronizację kalendarza programu Outlook.<ul><li><b>Dobrowolna (opt-in)</b>: użytkownicy włączają synchronizację kalendarza i zaznaczają kalendarze do synchronizacji na stronie ustawień synchronizacji kalendarza.</li><li><b>Automatyczna (opt-out)</b>: użytkownicy połączeni z Microsoft 365 automatycznie mają włączoną synchronizację kalendarza i są subskrybowani do kalendarzy wybranych poniżej (w przypadku kursów są to wszystkie kursy, na które są zapisani, teraz i w przyszłości), a synchronizacja odbywa się z Moodle do ich głównego kalendarza programu Outlook. Użytkownicy nadal mogą to zmienić lub wyłączyć na stronie ustawień synchronizacji kalendarza, a użytkownicy, którzy wyłączą synchronizację kalendarza, nie są ponownie subskrybowani.</li></ul>Przełączenie z powrotem na „Dobrowolna (opt-in)” nie usuwa istniejących subskrypcji.';
$string['settings_calsyncsubscribetypes'] = 'Kalendarze, do których użytkownicy są automatycznie subskrybowani';
$string['settings_calsyncsubscribetypes_details'] = 'Dotyczy tylko trybu „Automatyczna (opt-out)”. Wybierz, do których kalendarzy Moodle połączeni użytkownicy są automatycznie subskrybowani. Zasubskrybowanie wszystkich do kalendarza witryny powoduje dodanie każdego użytkownika jako uczestnika każdego wydarzenia witryny, dlatego opcja ta nie jest domyślnie wybrana.';
$string['settings_calsyncsubscribetypes_site'] = 'Kalendarz witryny';
$string['settings_calsyncsubscribetypes_user'] = 'Kalendarz osobisty';
$string['settings_calsyncsubscribetypes_course'] = 'Kalendarze kursów (wszystkie kursy, na które zapisany jest użytkownik)';
$string['settings_calsyncsubscribemode_optin'] = 'Dobrowolna (opt-in) (użytkownicy sami włączają synchronizację kalendarza)';
$string['settings_calsyncsubscribemode_optout'] = 'Automatyczna (opt-out) (automatycznie włącz synchronizację kalendarza dla wszystkich połączonych użytkowników)';
$string['settings_secthead_advanced'] = 'Ustawienia zaawansowane';
$string['settings_secthead_advanced_desc'] = 'Te ustawienia kontrolują inne funkcje pakietu wtyczek. Zachowaj ostrożność! Mogą one powodować niezamierzone skutki.';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'Dzierżawcy';
$string['settings_tools_tenants_linktext'] = 'Skonfiguruj dodatkowych dzierżawców';
$string['settings_tools_tenants_details'] = 'Zarządzaj dostępem do dodatkowych dzierżawców Microsoft Entra.';
$string['settings_healthcheck'] = 'Sprawdzanie kondycji';
$string['settings_healthcheck_details'] = 'Jeśli coś nie działa prawidłowo, sprawdzenie kondycji zazwyczaj pozwala zidentyfikować problem i zaproponować rozwiązania.';
$string['settings_healthcheck_linktext'] = 'Sprawdź kondycję';
$string['settings_userconnections'] = 'Połączenia użytkowników';
$string['settings_userconnections_linktext'] = 'Zarządzaj połączeniami użytkowników';
$string['settings_userconnections_details'] = 'Przeglądaj połączenia między użytkownikami Moodle a Microsoft 365 i zarządzaj nimi.';
$string['settings_teamconnections'] = 'Połączenia zespołów';
$string['settings_teamconnections_linktext'] = 'Zarządzaj połączeniami zespołów';
$string['settings_teamconnections_details'] = 'Przeglądaj połączenia między kursami Moodle a usługą Microsoft Teams i zarządzaj nimi.';
$string['settings_usermatch'] = 'Dopasowywanie użytkowników';
$string['settings_usermatch_details'] = 'To narzędzie umożliwia dopasowanie użytkowników Moodle do użytkowników Microsoft 365 na podstawie przesłanego niestandardowego pliku danych.';
$string['settings_usersyncgroupfilter'] = 'Filtr grupy synchronizacji użytkowników';
$string['settings_usersyncgroupfilter_details'] = 'Po wprowadzeniu tutaj jednego lub kilku identyfikatorów obiektów grup (GUID) pełna synchronizacja użytkowników zostanie ograniczona do członków i właścicieli tych grup Microsoft 365, w tym członków grup zagnieżdżonych. Pozostaw puste, aby synchronizować wszystkich użytkowników z licencją w dzierżawcy.<br><br>
<strong>UWAGA: To jest ustawienie zaawansowane. Nieprawidłowa konfiguracja może powodować poważne problemy z synchronizacją danych.</strong><br><br>
<strong>Po skonfigurowaniu obowiązują następujące zasady:</strong><br>
(1) Aktualizacje profilu, strefy czasowej i zdjęcia będą stosowane tylko do użytkowników, którzy są członkami lub właścicielami grupy<br>
(2) Nowe konta Moodle będą tworzone tylko dla użytkowników, którzy są członkami lub właścicielami grupy<br>
(3) Konta Moodle użytkowników niebędących członkami nie będą już otrzymywać aktualizacji i mogą przestać być zsynchronizowane z Microsoft 365<br>
(4) Użytkownicy wyłączeni w Microsoft 365 nadal będą zawieszani w Moodle przez synchronizację stanu włączenia, która działa niezależnie od filtrowania grup<br>
(5) Usunięcie użytkownika z grupy zatrzymuje przyszłe synchronizacje dla jego konta. Jego konto Moodle nie jest usuwane i jest zawieszane tylko wtedy, gdy włączona jest opcja „Zawieszaj konta w Moodle, gdy nie należą do skonfigurowanej grupy synchronizacji użytkowników”, która zawiesza każdego zsynchronizowanego użytkownika spoza grupy, niezależnie od tego, czy kiedykolwiek do niej należał. Ta opcja dotyczy tylko kont, które zostały zsynchronizowane co najmniej raz i mają zapisane połączenie z Microsoft; pozostałe konta nie są zawieszane<br><br>
<strong>Ograniczenie synchronizacji przyrostowej (delta):</strong> Microsoft Graph nie obsługuje zapytań delta w punktach końcowych członkostwa w grupach. Po skonfigurowaniu tego ustawienia synchronizacje delta będą wykonywać pełną synchronizację członków grupy zamiast aktualizacji przyrostowej. Jest to prawidłowe zachowanie, ale może być wolniejsze niż zwykła synchronizacja delta.<br><br>
Zweryfikuj identyfikatory obiektów grup przed zapisaniem. Wprowadź jeden identyfikator obiektu grupy (GUID) w wierszu lub oddziel kilka identyfikatorów przecinkami.';
$string['settings_usersyncgroupfilter_notfound'] = 'Nie znaleziono w Microsoft Entra ID: {$a}. Sprawdź identyfikatory obiektów grup.';
$string['settings_usersyncgroupfilter_notverified'] = 'Nie udało się sprawdzić identyfikatorów obiektów grup w Microsoft Entra ID i zapisano je bez weryfikacji. Upewnij się, że identyfikatory są prawidłowe.';
$string['settings_usersyncgroupfilter_validation_error'] = 'Nieprawidłowy format identyfikatora grupy: {$a}. Każdy identyfikator grupy musi być prawidłowym identyfikatorem GUID (np. 550e8400-e29b-41d4-a716-446655440000).';
$string['settings_usersynccreationrestriction'] = 'Ograniczenie tworzenia użytkowników';
$string['settings_usersynccreationrestriction_details'] = 'Jeśli ta opcja jest włączona, podczas synchronizacji użytkowników będą tworzeni tylko użytkownicy Microsoft Entra ID spełniający warunek. W przypadku członkostwa w grupie Microsoft 365 (identyfikator obiektu grupy) wprowadź jeden identyfikator obiektu grupy lub wiele identyfikatorów oddzielonych przecinkami.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Wartość pola';
$string['settings_usersynccreationrestriction_o365group'] = 'Członkostwo w grupie Microsoft 365 (nazwa grupy)';
$string['settings_usersynccreationrestriction_o365groupid'] = 'Członkostwo w grupie Microsoft 365 (identyfikator obiektu grupy)';
$string['settings_usersynccreationrestriction_invalidgroupid'] = 'Nie znaleziono identyfikatora obiektu grupy Microsoft 365 „{$a}”. Sprawdź identyfikator i spróbuj ponownie.';
$string['settings_usersynccreationrestriction_groupvalidationerror'] = 'Nie udało się zweryfikować identyfikatorów obiektów grup Microsoft 365. Sprawdź identyfikatory oraz konfigurację Microsoft Graph, a następnie spróbuj ponownie.';
$string['settings_usersynccreationrestriction_regex'] = 'Wartość jest wyrażeniem regularnym';
$string['settings_maintenance'] = 'Konserwacja';
$string['settings_maintenance_details'] = 'Dostępne są różne zadania konserwacyjne umożliwiające rozwiązanie niektórych typowych problemów.';
$string['settings_maintenance_linktext'] = 'Wyświetl narzędzia konserwacyjne';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'Wielu dzierżawców';
$string['acp_tenants_title_desc'] = 'Ta strona pomaga skonfigurować dostęp do Moodle z Microsoft 365 dla wielu dzierżawców.';
$string['acp_tenants_add'] = 'Dodaj nowego dzierżawcę';
$string['acp_tenants_errornotsetup'] = 'Przed dodaniem dodatkowych dzierżawców ukończ proces konfiguracji wtyczki.';
$string['acp_tenants_hosttenant'] = 'Dzierżawca hosta: {$a}';
$string['acp_tenants_intro'] = '<b>Jak działa obsługa wielu dzierżawców:</b><br />Obsługa wielu dzierżawców umożliwia dostęp do witryny Moodle wielu dzierżawcom Microsoft Entra. <br /><br />
    Oto jak to skonfigurować:
    <ol>
        <li>Zaloguj się do Moodle jako administrator witryny, który nie korzysta z wtyczki uwierzytelniania OpenID Connect.</li>
        <li>Upewnij się, że ustawienia <b>Punkt końcowy autoryzacji</b> i <b>Punkt końcowy tokenu</b> wtyczki uwierzytelniania OpenID Connect używają domyślnych ustawień niezależnych od dzierżawcy.</li>
        <li>Wyłącz wtyczkę uwierzytelniania OpenID Connect w Moodle. (Użyj <a href="{$a}/admin/settings.php?section=manageauths">strony administracji wtyczkami uwierzytelniania</a>.)</li>
        <li>Przejdź do Microsoft Entra ID i znajdź aplikację skonfigurowaną dla Moodle.</li>
        <li>Włącz obsługę wielu dzierżawców w aplikacji Microsoft Entra ID i zapisz zmiany.</li>
        <li>Nadaj aplikacji co najmniej jedno z następujących uprawnień delegowanych Graph: <b>Directory.Read.All</b>, <b>Domain.Read.All</b> lub <b>Domain.ReadWrite.All</b>. Zgoda administratora dla Twojej organizacji nie jest wymagana.</li>
        <li>Jeśli jesteś już zalogowany za pomocą konta Microsoft z dodatkowego dzierżawcy, wyloguj się całkowicie i zaloguj ponownie.</li>
        <li>Dla każdego dzierżawcy, którego chcesz włączyć, kliknij „Dodaj nowego dzierżawcę” i zaloguj się za pomocą konta administratora z tego dzierżawcy.</li>
        <li>Po dodaniu wszystkich wymaganych dzierżawców ponownie włącz wtyczkę uwierzytelniania OpenID Connect w Moodle.</li>
        <li>Gotowe! Aby w przyszłości dodać kolejnych dzierżawców, wystarczy kliknąć przycisk „Dodaj nowego dzierżawcę” i zalogować się za pomocą konta administratora z tego dzierżawcy.</li>
    </ol>
    <b>Ważna uwaga:</b> Włączenie obsługi wielu dzierżawców w aplikacji Microsoft Entra ID zezwala na dostęp do aplikacji wszystkim dzierżawcom Microsoft Entra. Dodanie dzierżawców tutaj pozwala ograniczyć dostęp do Moodle do skonfigurowanych dzierżawców. <b>Jeśli usuniesz wszystkich dzierżawców z tej listy przed wyłączeniem obsługi wielu dzierżawców w aplikacji Microsoft Entra ID lub włączysz uwierzytelnianie OpenID Connect w Moodle przy pustej liście, Twoja witryna Moodle będzie otwarta dla wszystkich dzierżawców Microsoft Entra.</b>';
$string['acp_tenants_none'] = 'Nie skonfigurowano żadnych dzierżawców. Jeśli w aplikacji Microsoft Entra ID włączono obsługę wielu dzierżawców, Twoja witryna Moodle może być otwarta dla wszystkich użytkowników Microsoft 365.';
$string['acp_tenants_revokeaccess'] = 'Cofnij dostęp';
$string['acp_tenants_tenant'] = 'Dzierżawca';
$string['acp_tenants_actions'] = 'Akcje';
$string['acp_tenants_delete'] = 'Usuń';
$string['acp_tenantsadd_desc'] = 'Aby przyznać dostęp dodatkowemu dzierżawcy, kliknij poniższy przycisk i zaloguj się do Microsoft 365 za pomocą konta administratora nowego dzierżawcy. Nastąpi powrót do listy dodatkowych dzierżawców, na której pojawi się nowy dzierżawca. Następnie będzie można korzystać z Moodle z nowym dzierżawcą.';
$string['acp_tenantsadd_linktext'] = 'Przejdź do strony logowania Microsoft 365';
$string['acp_tenants_legacy_tenants'] = 'Starsi dzierżawcy (wymagane działanie)';
$string['acp_tenants_legacy_tenants_help'] = 'Dodatkowi dzierżawcy wymienieni poniżej, dodani wcześniej, mogą nie działać w zaktualizowanym przepływie obsługi wielu dzierżawców i wymagają naprawy.<br/>
Użyj przycisku „Dodaj nowego dzierżawcę” powyżej, aby dodać ich ponownie.';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = 'Sprawdzanie kondycji';
$string['healthcheck_fixlink'] = 'Kliknij tutaj, aby rozwiązać problem.';
$string['healthcheck_ratelimit_title'] = 'Ograniczanie przepustowości API';
$string['healthcheck_ratelimit_result_notice'] = 'Włączono niewielkie ograniczanie przepustowości, aby obsłużyć zwiększone obciążenie witryny Moodle. <br /><br />Wszystkie funkcje Microsoft 365 działają, żądania są jedynie nieco rozłożone w czasie, aby zapobiec przerwaniu usług Microsoft 365. Gdy aktywność w Moodle się zmniejszy, wszystko wróci do normy. <br />(Poziom {$a->level} / rozpoczęto {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'Włączono zwiększone ograniczanie przepustowości, aby obsłużyć znaczne obciążenie witryny Moodle. <br /><br />Wszystkie funkcje Microsoft 365 nadal działają, ale wykonanie żądań Microsoft 365 może trwać dłużej. Gdy aktywność w witrynie Moodle się zmniejszy, wszystko wróci do normy. <br />(Poziom {$a->level} / rozpoczęto {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'Funkcje ograniczania liczby żądań zostały wyłączone.';
$string['healthcheck_ratelimit_result_passed'] = 'Wywołania API Microsoft 365 są wykonywane z pełną szybkością.';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'Zarządzaj połączeniami użytkowników';
$string['acp_userconnections_column_muser'] = 'Użytkownik Moodle';
$string['acp_userconnections_column_o365user'] = 'Użytkownik Microsoft 365';
$string['acp_userconnections_column_status'] = 'Stan połączenia';
$string['acp_userconnections_column_actions'] = 'Akcje';
$string['acp_userconnections_column_usinglogin'] = 'Używa logowania';
$string['acp_userconnections_column_status_help'] = 'Stan połączenia pokazuje, w jaki sposób konto Moodle jest powiązane z kontem Microsoft 365 (Microsoft Entra ID).

* **Połączone** – Użytkownik ukończył połączenie, logując się do Moodle za pomocą konta Microsoft 365, lub administrator aktywnie połączył konto. Funkcje takie jak synchronizacja kalendarza i OneDrive działają dla tego użytkownika.
* **Dopasowane** – Administrator (lub narzędzie do zbiorczego dopasowywania użytkowników) zapisał, do którego konta Microsoft 365 należy ten użytkownik Moodle, ale połączenie nie jest jeszcze aktywne. Zostanie ukończone przy pierwszym zalogowaniu użytkownika za pomocą Microsoft 365. Dopóki użytkownik jest tylko dopasowany, nic nie jest synchronizowane.
* **Zsynchronizowane** – Konto Moodle zostało utworzone z Microsoft Entra ID przez zadanie synchronizacji użytkowników, ale użytkownik jeszcze się nie zalogował. Konto aktywuje się przy pierwszym logowaniu.
* **Brak połączenia** – Konto Moodle nie jest powiązane z żadnym kontem Microsoft 365.';
$string['acp_userconnections_column_actions_help'] = 'Akcje dostępne dla wiersza zależą od jego stanu połączenia.

* **Rozłącz** – Usuwa powiązanie między kontem Moodle a kontem Microsoft 365. Osoba zachowuje swoje konto Moodle, ale nie może już korzystać z funkcji Microsoft 365 ani logować się za pomocą Microsoft 365, dopóki nie połączy się ponownie. Wyświetlane dla połączonych użytkowników.
* **Synchronizuj ponownie** – Natychmiast uruchamia synchronizację danych Microsoft 365 dla tego użytkownika (pola profilu, zdjęcie, kalendarz itd.) zamiast czekać na zaplanowane zadanie i wyświetla wynik. Wyświetlane dla połączonych i zsynchronizowanych użytkowników.
* **Dopasuj** – Zapisuje, do którego konta Microsoft 365 należy ten użytkownik Moodle. Połączenie nie jest aktywne, dopóki osoba nie zaloguje się za pomocą Microsoft 365. Wyświetlane dla użytkowników bez połączenia.
* **Cofnij dopasowanie** – Usuwa dopasowanie, które nie zostało jeszcze ukończone. Wyświetlane dla dopasowanych użytkowników.';
$string['acp_userconnections_accountstatus_active'] = 'Aktywne';
$string['acp_userconnections_accountstatus_suspended'] = 'Zawieszone';
$string['acp_userconnections_connectionstatus_connected'] = 'Połączone';
$string['acp_userconnections_connectionstatus_matched'] = 'Dopasowane';
$string['acp_userconnections_connectionstatus_noconnection'] = 'Brak połączenia';
$string['acp_userconnections_connectionstatus_synced'] = 'Zsynchronizowane';
$string['acp_userconnections_filtering_accountstatus'] = 'Stan konta';
$string['acp_userconnections_filtering_connectionstatus'] = 'Stan połączenia';
$string['acp_userconnections_filtering_muserfullname'] = 'Imię i nazwisko użytkownika Moodle';
$string['acp_userconnections_filtering_musername'] = 'Nazwa użytkownika Moodle';
$string['acp_userconnections_filtering_o365username'] = 'Nazwa użytkownika Microsoft 365';
$string['acp_userconnections_manualmatch_title'] = 'Ręczne dopasowanie użytkownika';
$string['acp_userconnections_manualmatch_details'] = 'Ta strona umożliwia dopasowanie pojedynczego użytkownika Moodle do pojedynczego użytkownika Microsoft 365.';
$string['acp_userconnections_manualmatch_musername'] = 'Użytkownik Moodle';
$string['acp_userconnections_manualmatch_uselogin'] = 'Zaloguj się za pomocą Microsoft 365';
$string['acp_userconnections_manualmatch_o365username'] = 'Nazwa użytkownika Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'Użytkownik Moodle jest już połączony z użytkownikiem Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'Użytkownik Moodle jest już połączony z użytkownikiem Microsoft 365 (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'Użytkownik Moodle jest już dopasowany do użytkownika Microsoft 365';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'Użytkownik Microsoft 365 jest już dopasowany do innego użytkownika Moodle';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'Użytkownik Microsoft 365 jest już połączony z innym użytkownikiem Moodle';
$string['acp_userconnections_resync_nodata'] = 'Nie znaleziono zapisanych informacji Microsoft 365 dla tego użytkownika.';
$string['acp_userconnections_resync_notfound'] = 'Nie zsynchronizowano żadnych danych. Konto „{$a->username}” jest powiązane z obiektem Microsoft Entra ID {$a->objectid}, ale nie można znaleźć tego obiektu. Użytkownik został prawdopodobnie usunięty lub wyłączony w Microsoft 365 albo zapisany identyfikator obiektu jest nieaktualny.';
$string['acp_userconnections_resync_nooutput'] = 'Ponowna synchronizacja zakończyła się bez zgłoszenia żadnych zmian.';
$string['acp_userconnections_table_disconnect'] = 'Rozłącz';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'Spowoduje to rozłączenie użytkownika Moodle „{$a}” z Microsoft 365. Kliknij poniższy link, aby kontynuować.';
$string['acp_userconnections_table_match'] = 'Dopasuj';
$string['acp_userconnections_table_resync'] = 'Synchronizuj ponownie';
$string['acp_userconnections_table_unmatch'] = 'Cofnij dopasowanie';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'Spowoduje to cofnięcie dopasowania użytkownika Moodle „{$a}” do Microsoft 365. Kliknij poniższy link, aby kontynuować.';

// Settings in the "Manage Team Connections" feature of the "Advanced" tab.
$string['acp_teamconnections'] = 'Zarządzaj połączeniami zespołów';
$string['acp_teamconnection'] = 'Zarządzaj połączeniem zespołu';
$string['acp_teamconnections_actions'] = 'Akcje';
$string['acp_teamconnections_cache_last_updated'] = 'Pamięć podręczna usługi Teams została ostatnio zaktualizowana: {$a->lastupdated}. Kliknij <a href="{$a->updateurl}">tutaj</a>, aby zaktualizować pamięć podręczną.';
$string['acp_teamconnections_cache_never_updated'] = 'Pamięć podręczna usługi Teams nigdy nie była aktualizowana. Kliknij <a href="{$a->updateurl}">tutaj</a>, aby ją zaktualizować.';
$string['acp_teamconnections_connected_team'] = 'Połączony zespół';
$string['acp_teamconnections_course_connected'] = 'Kurs został pomyślnie połączony z zespołem.';
$string['acp_teamconnections_course_disconnected'] = 'Kurs został odłączony od zespołu.';
$string['acp_teamconnections_team_linked'] = 'Kurs został powiązany z zespołem.';
$string['acp_teamconnections_current_connection'] = 'BIEŻĄCE POŁĄCZENIE';
$string['acp_teamconnections_exception_course_not_exist'] = 'Kurs, który ma zostać połączony, nie istnieje.';
$string['acp_teamconnections_exception_invalid_team_id'] = 'Nieprawidłowy identyfikator zespołu';
$string['acp_teamconnections_exception_not_configured'] = 'Microsoft 365 nie jest w pełni skonfigurowany.';
$string['acp_teamconnections_exception_team_already_connected'] = 'Zespół jest już połączony z innym kursem';
$string['acp_teamconnections_form_connect_course'] = 'Zarządzaj połączeniem zespołu dla kursu {$a}';
$string['acp_teamconnections_form_sds_warning'] = 'UWAGA: Zespoły utworzone przez School Data Sync (SDS) nie mogą być tutaj łączone ręcznie, ponieważ byłoby to sprzeczne z synchronizacją SDS. Są one wykluczone z poniższych wyników wyszukiwania.';
$string['acp_teamconnections_form_team'] = 'Wybierz zespół';
$string['acp_teamconnections_form_team_noselection'] = 'Wyszukaj zespół...';
$string['acp_teamconnections_no_teams_found'] = 'Nie znaleziono zespołów dla „{$a}”';
$string['acp_teamconnections_group_only'] = ' (tylko grupa)';
$string['acp_teamconnections_team_missing'] = '(brak zespołu)';
$string['acp_teamconnections_not_connected'] = 'Niepołączone';
$string['acp_teamconnections_sync_disabled'] = 'Przed zarządzaniem połączeniami zespołów należy najpierw włączyć synchronizację kursów.';
$string['acp_teamconnections_table_connect'] = 'Połącz';
$string['acp_teamconnections_table_connect_to_different_team'] = 'Połącz z innym zespołem';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'Nie można utworzyć zespołu z grupy - brak właściciela';
$string['acp_teamconnections_table_link_team'] = 'Powiąż z zespołem „{$a}”';
$string['acp_teamconnections_table_missing_team'] = 'Kurs jest połączony z nieistniejącym zespołem. Zostanie to wyczyszczone przy następnym uruchomieniu zaplanowanego zadania synchronizacji kursów.';
$string['acp_teamconnections_table_resync'] = 'Synchronizuj ponownie';
$string['acp_teamconnections_table_update'] = 'Aktualizuj';
$string['acp_teamconnections_teams_cache_updated'] = 'Pamięć podręczna usługi Teams została pomyślnie zaktualizowana.';
$string['acp_teamconnections_no_owner'] = 'Dodaj właściciela, aby połączyć z usługą Teams.';
$string['acp_teamconnections_resync'] = 'Synchronizuj ponownie właścicieli / członków zespołu';
$string['acp_teamconnections_resync_title'] = 'Synchronizuj ponownie właścicieli / członków zespołu dla kursu {$a}';
$string['acp_teamconnections_resync_desc'] = 'Porównuje użytkowników zapisanych na kurs z właścicielami i członkami połączonej grupy/zespołu Microsoft 365 i dodaje wszystkich brakujących. Wybierz, czy użytkownicy, którzy są w zespole, ale nie są zapisani na kurs Moodle, mają również zostać usunięci.';
$string['acp_teamconnections_resync_keep'] = 'Synchronizuj ponownie (zachowaj dodatkowych członków zespołu)';
$string['acp_teamconnections_resync_keep_desc'] = 'Użytkownicy zapisani na kurs Moodle, których brakuje w zespole, zostaną dodani. Istniejący właściciele / członkowie zespołu, którzy nie są zapisani na kurs Moodle, nie zostaną zmienieni.';
$string['acp_teamconnections_resync_remove'] = 'Synchronizuj ponownie i usuń dodatkowych członków zespołu';
$string['acp_teamconnections_resync_remove_desc'] = 'Ostrzeżenie: każdy właściciel lub członek zespołu, który nie jest zapisany na kurs Moodle, zostanie usunięty z zespołu, nawet jeśli został dodany bezpośrednio w usłudze Microsoft Teams.';
$string['acp_teamconnections_resync_completed'] = 'Właściciele / członkowie zespołu zostali zsynchronizowani ponownie.';
$string['acp_teamconnections_resync_failed'] = 'Nie udało się ponownie zsynchronizować właścicieli / członków zespołu. Szczegóły znajdują się w powyższych danych wyjściowych.';
$string['acp_teamconnections_last_resync'] = 'Ostatnia ponowna synchronizacja: {$a}';
$string['acp_teamconnections_never_resynced'] = 'Nigdy nie synchronizowano ponownie';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'Dopasowywanie użytkowników';
$string['acp_usermatch_desc'] = 'To narzędzie umożliwia dopasowanie użytkowników Moodle do użytkowników Microsoft 365. Przesyłasz plik zawierający użytkowników Moodle i powiązanych z nimi użytkowników Microsoft 365, a zadanie cron zweryfikuje dane i skonfiguruje dopasowanie.';
$string['acp_usermatch_upload'] = 'Krok 1: Prześlij nowe dopasowania';
$string['acp_usermatch_upload_desc'] = 'Prześlij plik danych zawierający nazwy użytkowników Moodle i Microsoft 365, aby dopasować użytkowników Moodle do użytkowników Microsoft 365.<br />
<br />
Plik powinien być prostym plikiem CSV w formacie zwykłego tekstu, zawierającym trzy elementy w każdym wierszu:
<ul>
<li>nazwę użytkownika Moodle,</li>
<li>nazwę użytkownika Microsoft 365,</li>
<li>1 lub 0, gdzie 1 oznacza zmianę metody uwierzytelniania użytkownika na OpenID Connect, a 0 oznacza zachowanie istniejącej metody uwierzytelniania i używanie jej jako konta powiązanego.</li>
</ul>
Nie dołączaj nagłówków ani dodatkowych danych.<br />
Na przykład: <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'Typ {$a} nie jest obsługiwany. Prześlij plik CSV w formacie zwykłego tekstu.';
$string['acp_usermatch_upload_err_data'] = 'Wiersz nr {$a} zawierał nieprawidłowe dane. Każdy wiersz pliku CSV powinien zawierać co najmniej dwa elementy: nazwę użytkownika Moodle i nazwę użytkownika Microsoft 365.';
$string['acp_usermatch_upload_err_fileopen'] = 'Nie można otworzyć pliku do przetworzenia. Czy uprawnienia w katalogu Moodledata są prawidłowe?';
$string['acp_usermatch_upload_err_nofile'] = 'Nie otrzymano pliku do dodania do kolejki.';
$string['acp_usermatch_upload_submit'] = 'Dodaj plik danych do kolejki dopasowań';
$string['acp_usermatch_matchqueue'] = 'Krok 2: Kolejka dopasowań';
$string['acp_usermatch_matchqueue_clearall'] = 'Wyczyść wszystko';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Wyczyść błędy';
$string['acp_usermatch_matchqueue_clearqueued'] = 'Wyczyść oczekujące';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Wyczyść pomyślne';
$string['acp_usermatch_matchqueue_column_muser'] = 'Nazwa użytkownika Moodle';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Nazwa użytkownika Microsoft 365';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Stan';
$string['acp_usermatch_matchqueue_desc'] = 'Ta tabela pokazuje bieżący stan operacji dopasowywania. Za każdym razem, gdy uruchamiane jest zaplanowane zadanie <b>Przetwórz kolejkę dopasowań</b>, przetwarzana jest partia poniższych użytkowników.<br /><b>Uwaga:</b> Ta strona nie aktualizuje się dynamicznie, odśwież ją, aby zobaczyć bieżący stan.';
$string['acp_usermatch_matchqueue_empty'] = 'Kolejka dopasowań jest obecnie pusta. Prześlij plik danych za pomocą powyższego selektora plików, aby dodać użytkowników do kolejki.';
$string['acp_usermatch_matchqueue_status_error'] = 'Błąd: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'W kolejce';
$string['acp_usermatch_matchqueue_status_success'] = 'Pomyślnie';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'Narzędzia konserwacyjne';
$string['acp_maintenance_desc'] = 'Te narzędzia mogą pomóc w rozwiązaniu niektórych typowych problemów.';
$string['acp_maintenance_warning'] = 'Ostrzeżenie: To są zaawansowane narzędzia. Używaj ich tylko wtedy, gdy rozumiesz, co robisz.';
$string['acp_maintenance_resyncgroupusers'] = 'Synchronizuj ponownie użytkowników w grupach Microsoft 365 dla kursów';
$string['acp_maintenance_resyncgroupusers_desc'] = 'Ponownie zsynchronizuje członkostwo użytkowników we wszystkich grupach Microsoft 365 utworzonych dla wszystkich kursów Moodle. Zapewni to, że w grupie Microsoft 365 będą wszyscy i tylko ci użytkownicy, którzy są zapisani na kurs Moodle. <br /><b>Uwaga:</b> Jeśli do grupy Microsoft 365 dodano dodatkowych użytkowników, którzy nie są zapisani na powiązany kurs Moodle, zostaną oni usunięci.';
$string['acp_maintenance_recreatedeletedgroups'] = 'Utwórz ponownie usunięte grupy Microsoft 365';
$string['acp_maintenance_recreatedeletedgroups_desc'] = 'Sprawdzi, czy grupy Microsoft 365 połączone z kursami Moodle nie zostały ręcznie usunięte, i utworzy je ponownie.';
$string['acp_maintenance_debugdata'] = 'Wygeneruj pakiet danych debugowania';
$string['acp_maintenance_debugdata_desc'] = 'Wygeneruje pakiet zawierający różne informacje o środowisku Moodle i Microsoft 365, aby pomóc programistom w rozwiązywaniu ewentualnych problemów. Na prośbę programisty uruchom to narzędzie i wyślij pobrany plik. Uwaga: Chociaż ten pakiet nie zawiera poufnych danych tokenów, prosimy o niepublikowanie tego pliku publicznie ani nieprzesyłanie go niezaufanej stronie.';
$string['acp_maintenance_cleandeltatoken'] = 'Wyczyść tokeny delta synchronizacji użytkowników';
$string['acp_maintenance_cleandeltatoken_desc'] = 'Jeśli synchronizacja użytkowników nie działa w pełni po zaktualizowaniu jej ustawień, przyczyną może być stary token synchronizacji delta. Wyczyszczenie tokenu wymusi pełną ponowną synchronizację przy następnym uruchomieniu synchronizacji użytkowników.';
$string['acp_maintenance_cleanapptokens'] = 'Wyczyść tokeny aplikacji';
$string['acp_maintenance_cleanapptokens_desc'] = 'Usuwa zapisane tokeny aplikacji, których wtyczka używa do wywołań interfejsów API Microsoft niewykonywanych w imieniu użytkownika. Nowe tokeny aplikacji są żądane automatycznie, gdy będą potrzebne następnym razem, a wyniki ostatniego sprawdzenia „Sprawdź konfigurację” na karcie Konfiguracja zostają wyczyszczone. Jeśli wywołania wykonywane z uprawnieniami aplikacji kończą się błędami uwierzytelniania, na przykład po zmianie uprawnień aplikacji Microsoft Entra ID lub jej danych logowania, pomocne może być wyczyszczenie tokenów. Tokeny użytkowników nie są dotknięte.';

// Settings in the "Resync users in Microsoft 365 groups for courses" feature in the "Maintenance Tools" feature of the
// "Advanced" tab.
$string['acp_maintenance_resyncgroupusers_course_output'] = 'Dane wyjściowe ponownej synchronizacji';
$string['acp_maintenance_resyncgroupusers_no_course'] = 'Brak kursu połączonego z Microsoft 365';
$string['acp_maintenance_coursesync_disabled'] = 'To narzędzie jest dostępne tylko wtedy, gdy synchronizacja kursów jest włączona. <a href="{$a}">Zarządzaj synchronizacją kursów</a>.';

// Settings in the "Recreate deleted Microsoft 365 groups" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_recreatedeletedgroups_group_type'] = 'Typ obiektu Moodle';
$string['acp_maintenance_recreatedeletedgroups_group_type_course'] = 'Kurs';
$string['acp_maintenance_recreatedeletedgroups_group_type_course_group'] = 'Grupa kursu';
$string['acp_maintenance_recreatedeletedgroups_course'] = 'Kurs';
$string['acp_maintenance_recreatedeletedgroups_course_group'] = 'Grupa kursu';
$string['acp_maintenance_recreatedeletedgroups_status'] = 'Stan';
$string['acp_maintenance_recreatedeletedgroups_status_sync_disabled'] = 'Synchronizacja kursu jest wyłączona';
$string['acp_maintenance_recreatedeletedgroups_status_created_success'] = 'Grupa została utworzona ponownie';
$string['acp_maintenance_recreatedeletedgroups_status_created_fail'] = 'Nie udało się ponownie utworzyć grupy';
$string['acp_maintenance_recreatedeletedgroups_all_groups_exist'] = 'Wszystkie grupy połączone z kursami Moodle i grupami kursów istnieją.';

// Settings in the "Cleanup User Sync Delta Tokens" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_cleandeltatoken_completed'] = 'Token delta synchronizacji użytkowników oraz token pomijania delta zostały wyczyszczone.';
$string['acp_maintenance_cleanapptokens_confirm'] = 'Czy na pewno chcesz wyczyścić tokeny aplikacji? Liczba aktualnie zapisanych tokenów aplikacji: {$a}.';
$string['acp_maintenance_cleanapptokens_completed'] = 'Tokeny aplikacji oraz wyniki ostatniego sprawdzenia „Sprawdź konfigurację” zostały wyczyszczone.';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_course_reset_teams'] = 'Akcje dla zespołu/grupy przy resetowaniu kursu';
$string['settings_course_reset_teams_details'] = 'Akcje wykonywane na zespole lub grupie połączonej z kursem, gdy kurs jest resetowany.';
$string['settings_course_reset_teams_option_do_nothing'] = 'Nie rób nic<br/>Zespół lub grupa nadal jest połączona z kursem. Wypisanie użytkowników spowoduje usunięcie ich z członkostwa w zespole lub grupie.';
$string['settings_course_reset_teams_option_per_course'] = 'Zezwalaj na ustawienia dla poszczególnych kursów<br/>Wymaga dodania bloku Microsoft do kursu. Użytkownicy z uprawnieniem do resetowania kursu mogą w tym bloku wybrać, co zrobić podczas resetowania kursu.';
$string['settings_course_reset_teams_option_force_archive'] = 'Odłącz kurs od zespołu lub grupy i utwórz nowy<br/>Istniejący zespół lub grupa połączona z kursem zostanie przemianowana zgodnie z konfiguracją. Jeśli połączony jest zespół, zostanie zarchiwizowany. Zostanie utworzony i połączony z kursem nowy zespół lub nowa grupa.';
$string['settings_course_reset_teams_option_archive_only'] = 'Tylko odłącz kurs od zespołu lub grupy<br />Istniejący zespół lub grupa połączona z kursem zostanie przemianowana zgodnie z konfiguracją. Jeśli połączony jest zespół, zostanie zarchiwizowany. Nowy zespół ani nowa grupa nie zostaną utworzone.';
$string['settings_reset_team_name_prefix'] = 'Prefiks nazwy zespołu przy resetowaniu';
$string['settings_reset_team_name_prefix_details'] = 'Podczas resetowania kursu połączonego z zespołem nazwa istniejącego połączonego zespołu zostanie poprzedzona tym prefiksem.';
$string['settings_reset_group_name_prefix'] = 'Prefiks nazwy grupy przy resetowaniu';
$string['settings_reset_group_name_prefix_details'] = 'Podczas resetowania kursu połączonego z grupą nazwa istniejącej grupy zostanie poprzedzona tym prefiksem.';
$string['settings_calsync_courseeventmode'] = 'Wydarzenia programu Outlook dla wydarzeń kalendarza kursu';
$string['settings_calsync_courseeventmode_details'] = 'Określa, w jaki sposób wydarzenie kalendarza kursu Moodle jest tworzone w programie Outlook dla użytkowników, którzy zasubskrybowali kalendarz kursu.
<ul>
<li><strong>Jedno wspólne wydarzenie z użytkownikami kursu jako uczestnikami:</strong> tworzone jest jedno wydarzenie w kalendarzu programu Outlook użytkownika, który utworzył wydarzenie w Moodle (lub w kalendarzu grupy Microsoft 365 kursu, jeśli kurs jest powiązany z grupą), a użytkownicy kursu są do niego dodawani jako uczestnicy.</li>
<li><strong>Jedno osobne wydarzenie na użytkownika:</strong> osobne wydarzenie jest tworzone bezpośrednio w kalendarzu programu Outlook każdego subskrybującego użytkownika. Nie ma wspólnego wydarzenia ani listy uczestników, a do kalendarza grupy Microsoft 365 nic nie jest dodawane.</li>
</ul>
Zmiana tego ustawienia dotyczy tylko wydarzeń synchronizowanych później; wydarzenia już istniejące w programie Outlook nie są konwertowane.';
$string['settings_calsync_courseeventmode_shared'] = 'Jedno wspólne wydarzenie z użytkownikami kursu jako uczestnikami';
$string['settings_calsync_courseeventmode_individual'] = 'Jedno osobne wydarzenie na użytkownika';
$string['settings_debugmode'] = 'Rejestruj komunikaty debugowania';
$string['settings_debugmode_details'] = 'Jeśli ta opcja jest włączona, informacje pomocne w identyfikacji problemów będą rejestrowane w dzienniku Moodle. <a href="{$a}">Wyświetl zarejestrowane komunikaty dziennika.</a>';
$string['settings_switchauthminupnsplit0'] = 'Minimalna długość niedokładnej nazwy użytkownika do przełączenia na Microsoft 365';
$string['settings_switchauthminupnsplit0_details'] = 'Jeśli włączono ustawienie „Przełącz dopasowanych użytkowników na uwierzytelnianie Microsoft 365 (OpenID Connect)”, określa ono minimalną długość nazw użytkowników bez dzierżawcy (część @example.onmicrosoft.com), które zostaną przełączone. Pomaga to uniknąć przełączania kont o ogólnych nazwach, takich jak „admin”, które niekoniecznie są tym samym kontem w Moodle i Microsoft Entra ID. Ustaw 0, aby przełączać dopasowanych użytkowników niezależnie od długości nazwy użytkownika. Użytkownicy, których metoda uwierzytelniania nie została przełączona z powodu tego ustawienia, są rejestrowani jako „Matched user, but the username is not an exact match to the Microsoft Entra ID UPN and does not meet the exact-match requirements for switching to OIDC...” w danych wyjściowych zadania synchronizacji i są wyświetlani jako „Matched with existing user - Awaiting completion” na stronie Zarządzaj połączeniami użytkowników.';
$string['settings_customtheme'] = 'Motyw niestandardowy (zaawansowane)';
$string['settings_customtheme_desc'] = 'Zalecanym motywem jest „boost_o365teams”. Można jednak wybrać inny motyw, jeśli masz motyw niestandardowy dostosowany do użycia na karcie usługi Teams.<br/>
Należy pamiętać, że motyw niestandardowy ustawiony na poziomie kursu lub kategorii ma pierwszeństwo przed ustawieniami tutaj, tzn. kurs będzie domyślnie używać motywu kursu lub kategorii w aplikacji Moodle w usłudze Teams. Można to naprawić, aktualizując $CFG->themeorder w pliku config.php do wartości „array(\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\');”.';

// Settings in the "SDS sync" tab.
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>To jest funkcja w wersji zapoznawczej</b><br />Funkcje w wersji zapoznawczej mogą nie działać zgodnie z założeniami lub przestać działać bez ostrzeżenia. Zachowaj ostrożność.</div>';
$string['settings_sds_intro_desc'] = 'Microsoft School Data Sync („SDS”) upraszcza zarządzanie klasami w Microsoft 365, odczytując listy uczestników z zewnętrznego systemu SIS oraz tworząc klasy i grupy w Microsoft 365. <a href="https://sds.microsoft.com/" target="_blank">Dowiedz się więcej</a><br/>
<br/>
Funkcja synchronizacji SDS umożliwia synchronizację danych list uczestników z SDS do Moodle, w tym klas, nauczycieli i uczniów.<br/>
<br/>
Aby korzystać z funkcji synchronizacji SDS, upewnij się, że aplikacja Microsoft Entra ID używana do integracji ma uprawnienia aplikacji Microsoft Graph <b>EduRoster.Read.All</b> i <b>Member.Read.Hidden</b>, które nie są automatycznie dodawane w domyślnej konfiguracji. Należy również udzielić dla nich zgody administratora.<br/>
<br/>
Domyślnie proces synchronizacji SDS odbywa się codziennie w cronie Moodle o godzinie 3:00 czasu serwera. Aby zmienić ten harmonogram, odwiedź <a href="{$a}">stronę zarządzania zaplanowanymi zadaniami.</a><br/><br/>';
$string['settings_sds_coursecreation'] = 'Synchronizacja klas z kursami';
$string['settings_sds_coursecreation_desc'] = 'Te opcje kontrolują tworzenie kursów Moodle na podstawie klas szkolnych SDS.';
$string['settings_sds_coursecreation_enabled'] = 'Synchronizowane szkoły';
$string['settings_sds_coursecreation_enabled_desc'] = 'Utwórz kursy dla klas w tych szkołach.';
$string['settings_sds_teams_enabled'] = 'Czy klasy SDS mają już zespoły Teams?';
$string['settings_sds_teams_enabled_desc'] = 'Zaznacz tę opcję, jeśli klasy SDS mają już zespoły Teams utworzone przez konfigurację SDS. Jeśli jest zaznaczona, Moodle nie będzie próbować tworzyć zespołów Teams z kursów Moodle utworzonych z klas SDS, aby uniknąć konfliktów.';
$string['settings_sds_courseenrolsync'] = 'Synchronizacja zapisów na kursy';
$string['settings_sds_courseenrolsync_desc'] = 'Te opcje kontrolują synchronizację zapisów na kursy z klas szkolnych SDS.';
$string['settings_sds_enrolment_enabled'] = 'Synchronizuj zapisy z SDS do Moodle';
$string['settings_sds_enrolment_enabled_desc'] = 'Gdy ta opcja jest włączona, zaplanowane zadanie synchronizacji SDS zapisuje nauczycieli i uczniów z klas SDS na odpowiadające im kursy Moodle oraz usuwa użytkowników, którzy nie należą już do klasy SDS. Wymaga skonfigurowania ustawień <b>Rola nauczyciela klasy SDS w Moodle</b> i <b>Rola ucznia klasy SDS w Moodle</b>.';
$string['settings_sds_sync_enrolment_to_sds'] = 'Synchronizuj zapisy z Moodle do SDS';
$string['settings_sds_sync_enrolment_to_sds_desc'] = 'Gdy ta opcja jest włączona, zmiany zapisów wprowadzone w kursach Moodle połączonych z klasami SDS będą synchronizowane z powrotem do klas SDS. Status właściciela / członka użytkownika w SDS będzie zależeć od uprawnień „local/o365:teamowner” i „local/o365:teammember” w kontekście kursu.';
$string['settings_sds_suspend_enrolment'] = 'Zawieszaj zapisy użytkowników zamiast ich wypisywać';
$string['settings_sds_suspend_enrolment_desc'] = 'Gdy ta opcja jest włączona, zapisy użytkowników usuniętych z klasy SDS będą zawieszane w połączonym kursie Moodle zamiast całkowitego wypisania. Zachowuje to dane użytkownika, takie jak oceny, prace i ukończenie aktywności. Gdy użytkownicy zostaną ponownie dodani do klasy SDS, ich zapis zostanie automatycznie reaktywowany.<br />
<b>Uwaga:</b> Nauczyciele nigdy nie są zawieszani ani wypisywani przez synchronizację SDS. To ustawienie dotyczy tylko uczniów.';
$string['settings_sds_enable_course_sync'] = 'Włącz dwukierunkową synchronizację kursów';
$string['settings_sds_enable_course_sync_desc'] = 'Gdy ta opcja jest włączona, każdy kurs Moodle utworzony z klasy SDS zostanie powiązany w bazie danych ze swoją grupą Microsoft 365, co aktywuje pełną integrację synchronizacji kursów Microsoft 365 (Teams, pliki, kalendarz itd.) dla tego kursu. Jeśli klasa SDS ma już zespół Teams, tworzony jest również rekord powiązania z usługą Teams.';
$string['settings_sds_course_field_mailnickname'] = 'Alias pocztowy (mailNickname)';
$string['settings_sds_course_field_displayname'] = 'Nazwa wyświetlana (displayName)';
$string['settings_sds_course_field_classcode'] = 'Kod klasy (classCode)';
$string['settings_sds_course_field_externalname'] = 'Nazwa zewnętrzna (externalName)';
$string['settings_sds_course_shortname_field'] = 'Źródło nazwy skróconej kursu';
$string['settings_sds_course_shortname_field_desc'] = 'Właściwość klasy SDS używana jako nazwa skrócona nowo tworzonych kursów Moodle. Moodle wymaga, aby nazwy skrócone kursów były unikalne. Jeśli wybrana właściwość jest pusta lub jej wartość jest już używana przez kurs powiązany z inną klasą SDS, zamiast niej używany jest alias pocztowy. Zmiana tego ustawienia nie zmienia nazw kursów, które zostały już utworzone.';
$string['settings_sds_course_fullname_field'] = 'Źródło pełnej nazwy kursu';
$string['settings_sds_course_fullname_field_desc'] = 'Właściwość klasy SDS używana jako pełna nazwa nowo tworzonych kursów Moodle. Jeśli wybrana właściwość jest pusta, zamiast niej używana jest nazwa wyświetlana. Zmiana tego ustawienia nie zmienia nazw kursów, które zostały już utworzone.';
$string['settings_sds_categorize_by_subject'] = 'Kategoryzuj kursy według przedmiotu';
$string['settings_sds_categorize_by_subject_desc'] = 'Gdy ta opcja jest włączona, kursy będą porządkowane w kategorie oparte na przedmiocie w ramach każdej kategorii szkoły. Nazwa przedmiotu jest pobierana z informacji o klasie w SDS. Gdy opcja jest wyłączona, wszystkie kursy są umieszczane bezpośrednio w kategorii szkoły.';
$string['settings_sds_ignore_past_courses'] = 'Ignoruj wygasłe/minione klasy';
$string['settings_sds_ignore_past_courses_desc'] = 'Gdy ta opcja jest włączona, klasy, które wygasły lub się zakończyły, będą pomijane podczas synchronizacji. Dotyczy to:<br />
<ul>
<li>Klas ze skonfigurowanym prefiksem wygasłych klas w nazwie (domyślnie: „Exp”)</li>
<li>Klas z datą zakończenia w przeszłości</li>
</ul>
Pomaga to utrzymać porządek w katalogu kursów, ponieważ nie są tworzone kursy dla starych lub zarchiwizowanych klas.';
$string['settings_sds_expired_course_prefix'] = 'Prefiks nazwy wygasłej klasy';
$string['settings_sds_expired_course_prefix_desc'] = 'Klasy, których nazwy zaczynają się od tego prefiksu, będą uznawane za wygasłe i pomijane podczas synchronizacji (jeśli włączono opcję „Ignoruj wygasłe/minione klasy”). Domyślnie: „Exp”';
$string['settings_sds_cohortsync'] = 'Synchronizacja kohort';
$string['settings_sds_cohortsync_desc'] = 'Te opcje kontrolują tworzenie i synchronizowanie kohort z klas SDS. Kohorty stanowią alternatywny sposób grupowania użytkowników, który można wykorzystać do zapisów w całej witrynie lub innych funkcji Moodle.';
$string['settings_sds_create_cohorts'] = 'Utwórz kohorty z klas SDS';
$string['settings_sds_create_cohorts_desc'] = 'Gdy ta opcja jest włączona, dla każdej klasy SDS zostanie utworzona kohorta, a jej członkostwo będzie synchronizowane z klasą SDS. Kohorty są tworzone w kontekście kategorii kursów (kategorii szkoły lub przedmiotu, w zależności od ustawień kategoryzacji).<br />
<b>Uwaga:</b> Kohorty są tworzone dodatkowo do kursów, a nie zamiast nich. Umożliwia to korzystanie z kohort do zapisów w całej witrynie lub grupowania, przy jednoczesnym utrzymywaniu kursów synchronizowanych z SDS.';
$string['settings_sds_cohort_include_teachers'] = 'Uwzględnij nauczycieli w kohortach';
$string['settings_sds_cohort_include_teachers_desc'] = 'Gdy ta opcja jest włączona, nauczyciele z klasy SDS będą dodawani do kohorty wraz z uczniami. Gdy jest wyłączona, do kohort będą dodawani tylko uczniowie.';
$string['settings_sds_enrolment_teacher_role'] = 'Rola nauczyciela klasy SDS w Moodle';
$string['settings_sds_enrolment_teacher_role_desc'] = 'Jeśli włączono opcję „Synchronizuj zapisy z SDS do Moodle”, nauczyciele z klasy SDS będą zapisywani na połączony kurs Moodle z tą rolą.';
$string['settings_sds_enrolment_student_role'] = 'Rola ucznia klasy SDS w Moodle';
$string['settings_sds_enrolment_student_role_desc'] = 'Jeśli włączono opcję „Synchronizuj zapisy z SDS do Moodle”, uczniowie z klasy SDS będą zapisywani na połączony kurs Moodle z tą rolą.';
$string['settings_sds_profilesync_header'] = 'Synchronizacja profilu użytkownika';
$string['settings_sds_profilesync_header_desc'] = 'Każda szkoła SDS może przechowywać profil użytkownika dla nauczycieli i członków szkoły. Pole jest specyficzne dla szkoły, tzn. różne szkoły mogą mieć różne wartości w tym samym polu dla tego samego użytkownika.<br/>
Jeśli w tej sekcji wybrano szkołę, pola profilu użytkownika SDS można skonfigurować w mapowaniu pól użytkownika.
<ul>
<li>Należy pamiętać, że synchronizacja pól SDS nastąpi tylko podczas uruchamiania zaplanowanego zadania „Synchronizuj z SDS”, a nie podczas uruchamiania zaplanowanego zadania „Synchronizuj użytkowników z usługi Microsoft Entra ID” ani podczas logowania użytkownika.</li>
<li>Należy pamiętać, że w interfejsie Microsoft Graph API używanym przez tę funkcję występuje znany problem polegający na tym, że niektóre pola profilu szkolnego uczniów i nauczycieli nie są zwracane, a więc nie są dostępne do synchronizacji, nawet jeśli zostały skonfigurowane.</li>
</ul>
';
$string['settings_sds_profilesync_disabled'] = 'Wyłączone';
$string['settings_sds_profilesync'] = 'Synchronizuj dane profilu ze szkoły';
$string['settings_sds_profilesync_desc'] = 'Wybierz szkołę SDS, z której Moodle synchronizuje dane profilu specyficzne dla SDS.';
$string['settings_sds_noschools'] = '<div class="alert alert-info">Nie masz żadnych szkół dostępnych w SDS.</div>';
$string['settings_sds_get_schools_error'] = '<div class="alert alert-info error">Nie udało się pobrać szkół SDS. Sprawdź, czy aplikacja Microsoft Entra ID ma wymagane uprawnienia.</div>';
$string['settings_sds_school_disabled_action'] = 'Akcja po wyłączeniu synchronizacji szkoły';
$string['settings_sds_school_disabled_action_desc'] = 'Akcja wykonywana na już połączonych kursach Moodle, gdy synchronizacja zostanie wyłączona dla szkoły SDS.';
$string['settings_sds_school_disabled_action_keep_connected'] = 'Pozostaw kurs Moodle połączony z zespołem';
$string['settings_sds_school_disabled_action_disconnect'] = 'Odłącz kurs Moodle od zespołu';
$string['settings_sds_school_unavailable'] = '{$a} (lista szkół SDS jest obecnie niedostępna)';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner'] = 'Aplikacja Moodle dla <a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teams</a> umożliwia łatwy dostęp do kursów Moodle i współpracę wokół nich w usłudze Teams.';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Skonfiguruj aplikację Moodle dla Microsoft Teams</h4>';
$string['settings_moodlesettingssetup'] = 'Skonfiguruj Moodle';
$string['settings_check_moodle_settings'] = 'Sprawdź ustawienia Moodle';
$string['settings_moodlesetup_checking'] = 'Sprawdzanie...';
$string['settings_notice_cookiesecureenabled'] = 'Opcja „Tylko bezpieczne pliki cookie” została pomyślnie włączona';
$string['settings_notice_cookiesecurealreadyenabled'] = 'Opcja „Tylko bezpieczne pliki cookie” była już włączona';
$string['settings_notice_oidcenabled'] = 'OpenID Connect został pomyślnie włączony';
$string['settings_notice_oidcnotenabled'] = 'Nie udało się włączyć OpenID Connect';
$string['settings_notice_oidcalreadyenabled'] = 'OpenID Connect był już włączony';
$string['settings_notice_webservicesframealreadyenabled'] = 'Usługi sieciowe były już włączone, a osadzanie w ramkach jest również dozwolone';
$string['settings_notice_webservicesframeenabled'] = 'Usługi sieciowe zostały pomyślnie włączone, a osadzanie w ramkach jest teraz również dozwolone';
$string['settings_notice_restenabled'] = 'Protokół REST został pomyślnie włączony';
$string['settings_notice_restnotenabled'] = 'Nie udało się włączyć protokołu REST';
$string['settings_notice_restalreadyenabled'] = 'Protokół REST był już włączony';
$string['settings_notice_o365serviceenabled'] = 'Usługi sieciowe Microsoft 365 zostały pomyślnie włączone';
$string['settings_notice_o365servicealreadyenabled'] = 'Usługi sieciowe Microsoft 365 były już włączone';
$string['settings_notice_createtokenallowed'] = 'Przyznano uprawnienie do tworzenia tokenu usługi sieciowej';
$string['settings_notice_createtokenalreadyallowed'] = 'Uprawnienie do tworzenia tokenu usługi sieciowej zostało już przyznane';
$string['settings_notice_createtokennotallowed'] = 'Wystąpił problem z przyznaniem uprawnienia do tworzenia tokenu usługi sieciowej';
$string['settings_notice_restusageallowed'] = 'Przyznano uprawnienie do korzystania z protokołu REST';
$string['settings_notice_restusagealreadyallowed'] = 'Uprawnienie do korzystania z protokołu REST zostało już przyznane';
$string['settings_notice_restusagenotallowed'] = 'Wystąpił problem z przyznaniem uprawnienia do korzystania z protokołu REST';
$string['settings_moodlesettingssetup_details'] = 'Zapewni to, że:
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>Opcja „Tylko bezpieczne pliki cookie” jest włączona.</li>
<li>OpenID Connect jest włączony.</li>
<li>Osadzanie w ramkach jest włączone.</li>
<li>Usługi sieciowe są włączone.</li>
<li>Protokół REST jest włączony.</li>
<li>Usługi sieciowe Microsoft 365 są włączone.</li>
<li>Uwierzytelniony użytkownik ma uprawnienie do tworzenia tokenu usługi sieciowej.</li>
<li>Uwierzytelniony użytkownik ma uprawnienie do korzystania z protokołu REST.</li>
</ul>';
$string['settings_teams_moodle_app_external_id'] = 'Identyfikator aplikacji Microsoft dla aplikacji Moodle w usłudze Teams';
$string['settings_teams_moodle_app_external_id_desc'] = 'Powinna być ustawiona wartość domyślna, chyba że w Twoim dzierżawcy wymaganych jest wiele aplikacji Moodle w usłudze Teams do łączenia z różnymi witrynami Moodle.';
$string['settings_teams_moodle_app_short_name'] = 'Nazwa aplikacji Teams';
$string['settings_teams_moodle_app_short_name_desc'] = 'Można ustawić wartość domyślną, chyba że w Twoim dzierżawcy wymaganych jest wiele aplikacji Moodle w usłudze Teams do łączenia z różnymi witrynami Moodle.';
$string['settings_download_teams_tab_app_manifest'] = 'Pobierz plik manifestu';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Zapisz wszystkie zmiany przed pobraniem manifestu.';
$string['settings_publish_manifest_instruction'] = '<a href="https://learn.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Kliknij tutaj</a>, aby dowiedzieć się, jak opublikować pobrany plik manifestu aplikacji Moodle dla wszystkich użytkowników w usłudze Teams.';
$string['settings_teams_moodle_tab_name'] = 'Nazwa karty Moodle w usłudze Teams';
$string['settings_teams_moodle_tab_name_desc'] = 'To jest nazwa karty Moodle w usłudze Teams.';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'Identyfikator aplikacji Moodle';
$string['settings_moodle_app_id_desc'] = 'Identyfikator przesłanej aplikacji Moodle w katalogach aplikacji usługi Teams.<br/>
Jeśli jest skonfigurowany, Moodle spróbuje utworzyć kartę Moodle z linkiem do kursu Moodle w kanale „Ogólne” utworzonego/połączonego zespołu.';
$string['settings_moodle_app_id_desc_auto_id'] = '<br/>
Automatycznie wykryta wartość to „<span class="local_o365_settings_moodle_app_id">{$a}</span>”.';
$string['settings_set_moodle_app_id_instruction'] = 'Aby ręcznie znaleźć identyfikator aplikacji Moodle, wykonaj następujące kroki:
<ol>
<li>Prześlij pobrany plik manifestu do katalogu aplikacji Teams swojego dzierżawcy.</li>
<li>W katalogu aplikacji Teams znajdź aplikację.</li>
<li>Kliknij ikonę opcji aplikacji, która znajduje się w prawym górnym rogu obrazu aplikacji.</li>
<li>Kliknij „Kopiuj link”.</li>
<li>W edytorze tekstu wklej skopiowaną zawartość. Powinna zawierać adres URL, taki jak https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
Ostatnia część adresu URL, tj. <span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>, jest identyfikatorem aplikacji.';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Włącz synchronizację kalendarza programu Outlook';
$string['calendar_user'] = 'Kalendarz osobisty (użytkownika)';
$string['calendar_site'] = 'Kalendarz witryny';
$string['personal_calendar'] = 'Osobisty';
$string['calendar_event'] = 'Wyświetl szczegóły';
$string['eventcalendarsubscribed'] = 'Użytkownik włączył subskrypcję kalendarza';
$string['eventcalendarunsubscribed'] = 'Użytkownik wyłączył subskrypcję kalendarza';

// Errors.
$string['erroracpauthoidcnotconfig'] = 'Najpierw ustaw poświadczenia aplikacji w parametrze auth_oidc.';
$string['errorhttpclientbadtempfileloc'] = 'Nie można otworzyć lokalizacji tymczasowej, aby zapisać plik.';
$string['errorhttpclientnofileinput'] = 'Brak parametru pliku w httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Nie udało się odświeżyć tokenu';
$string['errormfarequired'] = 'Microsoft wymaga uwierzytelniania wieloskładnikowego, zanim Moodle będzie mógł uzyskać dostęp do Twojego konta Microsoft 365. Wyloguj się z Moodle, a następnie zaloguj się ponownie za pomocą konta Microsoft 365 i ukończ monit uwierzytelniania wieloskładnikowego.';
$string['errorgetapplicationtoken'] = 'Nie udało się uzyskać tokenu aplikacji. Sprawdź konfigurację integracji.';
$string['erroracpapcantgettenant'] = 'Nie udało się uzyskać dzierżawcy Microsoft Entra, wprowadź go ręcznie.';
$string['erroracpcantgettenant'] = 'Nie udało się uzyskać adresu URL usługi OneDrive, wprowadź go ręcznie.';
$string['errorprovisioningapp'] = 'Nie udało się zainicjować aplikacji Moodle w zespole.';
$string['erroro365apibadcall'] = 'Błąd w wywołaniu interfejsu API.';
$string['erroro365apibadcall_message'] = 'Błąd w wywołaniu interfejsu API: {$a}';
$string['erroro365apiinvalidtoken'] = 'Nieprawidłowy lub wygasły token.';
$string['erroro365apiinvalidmethod'] = 'Nieprawidłowy element httpmethod przekazany do wywołania interfejsu API';
$string['erroro365apinotimplemented'] = 'Ta metoda powinna zostać zastąpiona.';
$string['erroro365apinotoken'] = 'Brak tokenu dla danego zasobu i użytkownika. Nie udało się pobrać tokenu. Czy odświeżony token użytkownika wygasł?';
$string['errorusermatched'] = 'Konto Microsoft 365 „{$a->entraidupn}” jest już dopasowane do użytkownika Moodle „{$a->username}”. Aby ukończyć połączenie, zaloguj się najpierw jako ten użytkownik Moodle i postępuj zgodnie z instrukcjami w bloku Microsoft.';
$string['errornodirectaccess'] = 'Bezpośredni dostęp do strony jest zabroniony';
$string['eventapifail'] = 'Błąd interfejsu API';
$string['errorunabletofindgraphapi'] = 'Nie można znaleźć interfejsu Microsoft Graph API w aplikacji.';
$string['erroremptyjwt'] = 'Podano pusty token JWT';
$string['errornocachedjwks'] = 'Nie znaleziono zapisanego w pamięci podręcznej zestawu JWKS';
$string['errorfetchjwks'] = 'Nie udało się pobrać zestawu JWKS z Microsoft';
$string['errorinvalidjwks'] = 'Otrzymano z Microsoft zestaw JWKS w nieprawidłowym formacie';
$string['errorjwtvalidation'] = 'Weryfikacja tokenu JWT nie powiodła się';
$string['errorjwtinvalidissuer'] = 'Weryfikacja wystawcy tokenu JWT nie powiodła się';
$string['errorcannotgettoken'] = 'Nie udało się uzyskać tokenu aplikacji lub systemu.';
$string['errornotokenforsysmemuser'] = 'Brak dostępnego tokenu dla użytkownika systemowego. Uruchom sprawdzenie kondycji local_o365.';
$string['errornotoken'] = 'Brak dostępnego tokenu dla użytkownika nr {$a}';
$string['errornotokenforusersync'] = 'Brak dostępnego tokenu dla synchronizacji użytkowników.';
$string['errornoapifound'] = 'Nie znaleziono interfejsu API o identyfikatorze {$a}.';
$string['errornoresponsesavailable'] = 'Brak dostępnych odpowiedzi.';
$string['erroro365badphoto'] = 'Otrzymano z Microsoft 365 nieprawidłowe zdjęcie profilowe.';
$string['erroro365nophoto'] = 'Ten użytkownik nie ma zdjęcia w Microsoft 365.';
$string['errorcannotgetapiclient'] = 'Nie można uzyskać klienta Graph API.';
$string['errorfailedtogetsecrets'] = 'Nie udało się pobrać kluczy tajnych.';
$string['errorfailedtosendnotification'] = 'Nie udało się wysłać wiadomości e-mail z powiadomieniem do jednego lub kilku odbiorców.';
$string['errorsecretexpiryrecipientundeliverable'] = 'Jeden lub kilku skonfigurowanych odbiorców powiadomień o wygaśnięciu klucza tajnego nie może odbierać poczty e-mail (nieprawidłowy adres lub domena bez rekordu MX/A): {$a}. Zaktualizuj odbiorców powiadomień w ustawieniach OpenID Connect.';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Lokalna wtyczka Microsoft 365';
$string['privacy:metadata:local_o365_calidmap'] = 'Informacje o powiązaniach między wydarzeniami kalendarza Microsoft 365 a wydarzeniami kalendarza Moodle.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'Identyfikator użytkownika, który jest właścicielem wydarzenia.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'Miejsce pochodzenia wydarzenia. Moodle lub Microsoft 365.';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'Identyfikator wydarzenia w programie Outlook.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'Identyfikator wydarzenia w Moodle.';
$string['privacy:metadata:local_o365_calsub'] = 'Informacje o subskrypcjach synchronizacji między kalendarzami Moodle i Outlook';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'Identyfikator użytkownika Moodle, którego dotyczy subskrypcja';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'Typ kalendarza Moodle (witryna, kurs, użytkownik)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'Powiązany identyfikator kalendarza Moodle';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'Identyfikator kalendarza Microsoft 365';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Czy jest to kalendarz główny';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'Sposób synchronizacji (tj. z Moodle do programu Outlook lub z programu Outlook do Moodle)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'Czas utworzenia subskrypcji.';
$string['privacy:metadata:local_o365_connections'] = 'Informacje o jeszcze niepotwierdzonych połączeniach między użytkownikami Moodle i Microsoft 365';
$string['privacy:metadata:local_o365_connections:muserid'] = 'Identyfikator użytkownika Moodle';
$string['privacy:metadata:local_o365_connections:entraidupn'] = 'Nazwa UPN użytkownika Microsoft Entra ID.';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Czy po zakończeniu przełączyć metodę uwierzytelniania użytkownika.';
$string['privacy:metadata:local_o365_token'] = 'Informacje o tokenach API Microsoft 365 użytkowników';
$string['privacy:metadata:local_o365_token:user_id'] = 'Identyfikator użytkownika Moodle';
$string['privacy:metadata:local_o365_token:scope'] = 'Zakres tokenu.';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'Zasób tokenu.';
$string['privacy:metadata:local_o365_token:token'] = 'Token.';
$string['privacy:metadata:local_o365_token:expiry'] = 'Czas wygaśnięcia tokenu.';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'Token odświeżania.';
$string['privacy:metadata:local_o365_objects'] = 'Informacje o relacjach między obiektami Moodle i Microsoft 365';
$string['privacy:metadata:local_o365_objects:type'] = 'Typ obiektu (grupa, użytkownik, kurs itd.)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'Podtyp obiektu.';
$string['privacy:metadata:local_o365_objects:objectid'] = 'Identyfikator obiektu Microsoft 365';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'Identyfikator obiektu w Moodle';
$string['privacy:metadata:local_o365_objects:o365name'] = 'Czytelna dla człowieka nazwa obiektu w Microsoft 365';
$string['privacy:metadata:local_o365_objects:tenant'] = 'Dzierżawca, do którego należy obiekt (w środowiskach z wieloma dzierżawcami)';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Wszelkie powiązane metadane';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'Czas utworzenia rekordu.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'Czas modyfikacji rekordu.';
$string['privacy:metadata:local_o365_appassign'] = 'Informacje o przypisaniach ról aplikacji Microsoft 365';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'Identyfikator użytkownika Moodle';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Czy użytkownik został przypisany do aplikacji';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'Identyfikator zdjęcia użytkownika w Microsoft 365';
$string['privacy:metadata:local_o365_appassign:photohash'] = 'Skrót SHA-256 bajtów zdjęcia profilowego użytkownika, przechowywany w celu wykrywania zmian zdjęcia bez ponownego pobierania całego obrazu';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Kiedy zdjęcie użytkownika zostało ostatnio zaktualizowane z Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue'] = 'Informacje o dopasowywaniu użytkowników Moodle do użytkowników Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'Nazwa użytkownika Moodle.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'Nazwa użytkownika Microsoft 365.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Czy po dokonaniu dopasowania przełączyć użytkownika na uwierzytelnianie OpenID Connect';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Czy rekord został przetworzony';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'Komunikat o błędzie (jeśli wystąpił)';
$string['privacy:metadata:preference:suspendedtime'] = 'Czas zawieszenia użytkownika przez synchronizację użytkowników, ponieważ odpowiadające mu konto Microsoft Entra ID zostało usunięte lub wyłączone.';
$string['privacy:metadata:local_o365_calsettings'] = 'Informacje o ustawieniach synchronizacji kalendarza';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'Identyfikator użytkownika Moodle';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'Identyfikator kalendarza w Microsoft 365';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'Czas utworzenia rekordu.';
$string['privacy:metadata:preference:calsync_initialised'] = 'Czy wybory użytkownika dotyczące synchronizacji kalendarza programu Outlook zostały zainicjowane, aby nie były ponownie włączane automatycznie.';

// Page "Microsoft 365 / Moodle Control Panel" in the Microsoft block.
$string['ucp_title'] = 'Panel sterowania Microsoft 365 / Moodle';
$string['ucp_general_intro'] = 'Tutaj możesz zarządzać połączeniem z pakietem Microsoft 365.';
$string['ucp_calsync_availcal'] = 'Dostępne kalendarze platformy Moodle';
$string['ucp_calsync_title'] = 'Ustawienia synchronizacji kalendarza programu Outlook';
$string['ucp_calsync_desc'] = 'Zaznaczone kalendarze zostaną zsynchronizowane z Moodle do Twojego kalendarza programu Outlook.';
$string['ucp_connection_options'] = 'Opcje połączenia:';
$string['ucp_connection_desc'] = 'Tutaj możesz skonfigurować sposób łączenia się z Microsoft 365. Aby korzystać z funkcji Microsoft 365, musisz być połączony z kontem Microsoft 365. Można to zrobić w sposób opisany poniżej.';
$string['ucp_connection_entraidlogin'] = 'Użyj swoich poświadczeń Microsoft 365, aby logować się do Moodle<br />';
$string['ucp_connection_entraidlogin_desc_authcode'] = 'Zamiast wprowadzać nazwę użytkownika i hasło na stronie logowania Moodle, zobaczysz na niej sekcję z napisem „Zaloguj się za pomocą konta w {$a}”. Kliknij link, a nastąpi przekierowanie do Microsoft 365 w celu zalogowania się. Po pomyślnym zalogowaniu do Microsoft 365 zostaniesz zwrócony do Moodle i zalogowany na swoje konto.';
$string['ucp_connection_entraidlogin_start'] = 'Zacznij używać Microsoft 365 do logowania do Moodle.';
$string['ucp_connection_entraidlogin_stop'] = 'Przestań używać Microsoft 365 do logowania do Moodle.';
$string['ucp_connection_entraidlogin_active'] = 'Do logowania do Moodle używasz konta Microsoft 365 „{$a}”.';
$string['ucp_connection_linked'] = 'Powiąż swoje konta Moodle i Microsoft 365';
$string['ucp_connection_linked_desc'] = 'Powiązanie kont Moodle i Microsoft 365 umożliwia korzystanie z funkcji Microsoft 365 w Moodle bez zmiany sposobu logowania do Moodle. <br />Kliknięcie poniższego linku przeniesie Cię do Microsoft 365 w celu jednorazowego zalogowania, po którym nastąpi powrót tutaj. Będziesz mógł korzystać ze wszystkich funkcji Microsoft 365 bez wprowadzania innych zmian na swoim koncie Moodle - do Moodle będziesz logować się tak jak dotychczas.';
$string['ucp_connection_linked_active'] = 'Jesteś powiązany z kontem Microsoft 365 „{$a}”.';
$string['ucp_connection_linked_start'] = 'Powiąż swoje konto Moodle z kontem Microsoft 365.';
$string['ucp_connection_linked_migrate'] = 'Przełącz na konto powiązane.';
$string['ucp_connection_linked_stop'] = 'Usuń powiązanie swojego konta Moodle z kontem Microsoft 365.';
$string['ucp_connection_disconnected'] = 'Nie jesteś połączony z Microsoft 365.';
$string['ucp_features'] = 'Funkcje pakietu Microsoft 365';
$string['ucp_features_intro'] = 'Poniżej podano listę funkcji pakietu Microsoft 365, których można używać, aby usprawnić pracę w platformie Moodle.';
$string['ucp_features_intro_notconnected'] = ' Niektóre funkcje mogą być dostępne dopiero po połączeniu z pakietem Microsoft 365.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Aby połączyć się z Microsoft 365, skontaktuj się z administratorem witryny.';
$string['ucp_index_calendar_title'] = 'Ustawienia synchronizacji kalendarza programu Outlook';
$string['ucp_index_calendar_desc'] = 'Ta opcja umożliwia skonfigurowanie ustawień synchronizacji kalendarzy platformy Moodle z kalendarzem programu Outlook. Można wyeksportować wydarzenia z kalendarza platformy Moodle do programu Outlook, a także przenieść wydarzenia z kalendarza programu Outlook do platformy Moodle.';
$string['ucp_index_connection_title'] = 'Ustawienia połączenia z Microsoft 365';
$string['ucp_index_connection_desc'] = 'Skonfiguruj sposób łączenia się z Microsoft 365.';
$string['ucp_index_connectionstatus_title'] = 'Stan połączenia';
$string['ucp_index_connectionstatus_login'] = 'Kliknij tutaj, aby się zalogować.';
$string['ucp_index_connectionstatus_usinglogin'] = 'Obecnie używasz Microsoft 365 do logowania do Moodle.';
$string['ucp_index_connectionstatus_usinglinked'] = 'Jesteś powiązany z kontem Microsoft 365.';
$string['ucp_index_connectionstatus_manage'] = 'Zarządzaj połączeniem';
$string['ucp_index_connectionstatus_reconnect'] = 'Odśwież połączenie';
$string['ucp_index_connectionstatus_connected'] = 'Użytkownik jest obecnie połączony z pakietem Microsoft 365';
$string['ucp_index_connectionstatus_matched'] = 'Konto użytkownika zostało dopasowane do konta użytkownika <small>„{$a}”</small> pakietu Microsoft 365. Aby zakończyć proces nawiązywania połączenia, kliknij link poniżej i zaloguj się do pakietu Microsoft 365.';
$string['ucp_index_connectionstatus_notconnected'] = 'Użytkownik nie jest obecnie połączony z pakietem Microsoft 365';
$string['ucp_notconnected'] = 'Połącz się z pakietem Microsoft 365 przed odwiedzeniem tej strony.';
$string['ucp_status_enabled'] = 'Aktywny';
$string['ucp_status_disabled'] = 'Nie połączono';
$string['ucp_syncwith_title'] = 'Nazwa kalendarza programu Outlook, z którym ma być wykonywana synchronizacja:';
$string['ucp_syncdir_title'] = 'Zachowanie funkcji synchronizacji:';
$string['ucp_syncdir_out'] = 'Z platformy Moodle do programu Outlook';
$string['ucp_syncdir_in'] = 'Z programu Outlook do platformy Moodle';
$string['ucp_syncdir_both'] = 'Zaktualizuj dane w programie Outlook i na platformie Moodle';
$string['ucp_o365accountconnected'] = 'To konto Microsoft 365 jest już połączone z innym kontem Moodle.';

// Tasks.
$string['task_calendarsyncin'] = 'Synchronizuj wydarzenia Microsoft 365 w platformie Moodle';
$string['task_coursesync'] = 'Synchronizuj kursy Moodle z Microsoft Teams';
$string['task_coursemembershipsync'] = 'Synchronizuj właścicieli i członków Microsoft Teams z kursami Moodle';
$string['task_groupmembershipsync'] = 'Synchronizuj właścicieli i członków kursów Moodle z grupami Microsoft 365';
$string['task_sds_sync'] = 'Synchronizuj z SDS';
$string['task_syncusers'] = 'Synchronizuj użytkowników z usługi Microsoft Entra ID';
$string['task_syncusersphotostimezones'] = 'Synchronizuj zdjęcia i strefy czasowe użytkowników z usługi Microsoft Entra ID';
$string['task_calsyncautosubscribe'] = 'Automatycznie włączaj synchronizację kalendarza dla połączonych użytkowników';
$string['task_groupchannelsync'] = 'Utwórz kanały Teams dla grup Moodle i synchronizuj ich członków';
$string['task_groupchannelsyncgroup'] = 'Utwórz kanał Teams grupy Moodle i synchronizuj jego członków';
$string['task_userenabledstatussync'] = 'Zawieszaj/ponownie włączaj/usuwaj użytkowników na podstawie stanu w Microsoft Entra ID';
$string['task_processmatchqueue'] = 'Przetwórz kolejkę dopasowań';
$string['task_notifysecretexpiry'] = 'Powiadom administratora witryny o wygaśnięciu klucza tajnego aplikacji Microsoft Entra ID';
$string['task_checkinvalidconfiglog'] = 'Sprawdź i wyczyść nieprawidłowe rekordy dziennika konfiguracji';
$string['task_usergroupmembershipsync'] = 'Synchronizuj członkostwo użytkowników w grupach kursów z Microsoft 365';
$string['task_processmatchqueue_err_museralreadymatched'] = 'Użytkownik Moodle jest już dopasowany do użytkownika Microsoft 365.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'Użytkownik Moodle jest już połączony z Microsoft 365.';
$string['task_processmatchqueue_err_nomuser'] = 'Nie znaleziono użytkownika Moodle o tej nazwie użytkownika.';
$string['task_processmatchqueue_err_noo365user'] = 'Nie znaleziono użytkownika Microsoft 365 o tej nazwie użytkownika.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'Użytkownik Microsoft 365 jest już dopasowany do użytkownika Moodle.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'Użytkownik Microsoft 365 jest już połączony z użytkownikiem Moodle.';

// Capabilities.
$string['o365:manageconnectionlink'] = 'Zarządzaj powiązaniem połączenia';
$string['o365:manageconnectionunlink'] = 'Zarządzaj usuwaniem powiązania połączenia';
$string['o365:managecoursesync'] = 'Włączaj lub wyłączaj synchronizację z Teams dla kursów za pomocą usług sieciowych';
$string['o365:viewgroups'] = 'Wyświetlaj linki do usług Microsoft 365 w bloku Microsoft w kursach z włączoną synchronizacją';
$string['o365:managegroups'] = 'Wyświetlaj linki do usług Microsoft 365 i opcje zarządzania w bloku Microsoft w kursach z włączoną synchronizacją';
$string['o365:teammember'] = 'Członek zespołu';
$string['o365:teamowner'] = 'Właściciel zespołu';

// Cache Stores.
$string['cachedef_groups'] = 'Przechowuje dane grup Microsoft 365';
$string['cachedef_jwks'] = 'Przechowuje klucze JWKS Microsoft';

// Web service errors.
$string['webservices_error_assignnotfound'] = 'Nie można znaleźć rekordu zadania otrzymanego modułu.';
$string['webservices_error_invalidassignment'] = 'Otrzymanego identyfikatora zadania nie można używać z tą funkcją usługi sieciowej.';
$string['webservices_error_modulenotfound'] = 'Nie można znaleźć otrzymanego identyfikatora modułu.';
$string['webservices_error_sectionnotfound'] = 'Nie można znaleźć sekcji kursu.';
$string['webservices_error_couldnotsavegrade'] = 'Nie udało się zapisać oceny.';

// User sync task help text.
$string['help_user_create'] = 'Pomoc dotycząca tworzenia kont';
$string['help_user_create_help'] = 'Spowoduje to utworzenie w Moodle użytkowników dla każdego użytkownika z połączonej usługi Microsoft Entra ID. Konta zostaną utworzone tylko dla użytkowników, którzy nie mają jeszcze kont Moodle. Nowe konta zostaną skonfigurowane z metodą uwierzytelniania OpenID Connect przy użyciu profilu Microsoft Entra ID i będą mogły korzystać ze wszystkich funkcji integracji Microsoft 365/Moodle.';
$string['help_user_update'] = 'Pomoc dotycząca aktualizacji wszystkich kont';
$string['help_user_update_help'] = 'Spowoduje to zaktualizowanie wszystkich użytkowników w Moodle na podstawie każdego użytkownika z połączonej usługi Microsoft Entra ID.';
$string['help_user_suspend'] = 'Pomoc dotycząca zawieszania kont';
$string['help_user_suspend_help'] = 'Spowoduje to zawieszenie użytkowników w Moodle, jeśli są oznaczeni jako usunięci w Microsoft Entra ID.';
$string['help_user_delete'] = 'Pomoc dotycząca usuwania kont';
$string['help_user_delete_help'] = 'Spowoduje to usunięcie użytkowników z Moodle, jeśli są oznaczeni jako usunięci w Microsoft Entra ID. Działa to tylko wtedy, gdy włączona jest opcja zawieszania użytkowników. Konto Moodle zostanie usunięte, a wszystkie powiązane informacje o użytkowniku zostaną usunięte z Moodle. Zachowaj ostrożność! Uwaga: Domyślnie usunięcie następuje 30 dni po usunięciu konta w Microsoft Entra ID ze względu na okres przechowywania usuniętych elementów w Entra ID (w tym czasie konta można przywrócić). Dłuższe opóźnienie między zawieszeniem a usunięciem można skonfigurować za pomocą ustawienia „Opóźnienie przed usunięciem zawieszonych użytkowników”.';
$string['help_user_reenable'] = 'Pomoc dotycząca ponownego włączania kont';
$string['help_user_reenable_help'] = 'Spowoduje to ponowne włączenie zawieszonych kont Moodle, jeśli są zwracane z Microsoft Entra ID i mają zezwolenie na logowanie. Konta, którym zablokowano logowanie (wyłączone) w Microsoft Entra ID, pozostaną zawieszone.';
$string['help_user_disabledsyncsuspend'] = 'Pomoc dotycząca zawieszania kont po wyłączeniu';
$string['help_user_disabledsyncsuspend_help'] = 'Spowoduje to zawieszenie użytkowników w Moodle, jeśli ich połączone konta w Microsoft Entra ID mają zablokowane logowanie (są wyłączone), bez zmiany tego, czy są automatycznie ponownie włączane, gdy ich konto Microsoft Entra ID zostanie ponownie włączone. Użyj poniższej opcji „Ponownie włączaj konta w Moodle, gdy zostaną ponownie włączone w usłudze Microsoft Entra ID”, aby kontrolować to osobno.';
$string['help_user_groupsyncsuspend'] = 'Pomoc dotycząca zawieszania kont spoza grupy synchronizacji';
$string['help_user_groupsyncsuspend_help'] = 'Spowoduje to zawieszenie użytkowników w Moodle, jeśli nadal są aktywni w Microsoft Entra ID, ale nie są członkami ani właścicielami grupy skonfigurowanej w ustawieniu „Filtr grupy synchronizacji użytkowników”. Sprawdzane jest tylko bieżące członkostwo: zawieszani są również istniejący zsynchronizowani użytkownicy, którzy nigdy nie należeli do grupy, a nie tylko ci, którzy ją opuścili, dlatego przed włączeniem tej opcji sprawdź swoją grupę. Ta opcja jest dostępna tylko wtedy, gdy skonfigurowano filtr grupy synchronizacji użytkowników. Aby uniknąć masowego zawieszania, nic nie jest zawieszane, jeśli grupa okaże się pusta lub nie można pobrać jej członków. Zawieszeni użytkownicy nie są ponownie włączani, dopóki nie należą do grupy.';
$string['help_user_disabledsyncreenable'] = 'Pomoc dotycząca ponownego włączania kont po włączeniu';
$string['help_user_disabledsyncreenable_help'] = 'Spowoduje to cofnięcie zawieszenia użytkowników w Moodle, jeśli ich połączone konta w Microsoft Entra ID ponownie mają zezwolenie na logowanie (są włączone).';
$string['help_user_suspendnolink'] = 'Pomoc dotycząca zawieszania kont bez linku do Microsoft';
$string['help_user_suspendnolink_help'] = 'Zwykle powyższe opcje zawieszania/wyłączania działają tylko na kontach, które mają zapisany rekord obiektu Microsoft Entra ID (utworzony podczas synchronizacji lub połączenia konta). Niektóre konta OpenID Connect nie mają takiego rekordu - na przykład połączyły się przed skonfigurowaniem Microsoft Graph API lub rekord został usunięty przez rozłączenie albo akcję „wyczyść dopasowanych użytkowników”. Ta opcja sprawia, że zadanie sprawdzania stanu sprawdza również te konta, dopasowując nazwę użytkownika Moodle do skonfigurowanej wartości oświadczenia nazwy użytkownika powiązania w Entra ID.

Dopasowane konta, których brakuje w Entra ID lub które są tam wyłączone, są <strong>tylko zawieszane</strong>: nigdy nie są usuwane (bez zapisanego identyfikatora obiektu nie można sprawdzić okresu przechowywania usuniętych elementów w Entra ID) i nigdy nie są automatycznie ponownie włączane. Konta gości są pomijane.

Ta opcja działa, gdy oświadczenie nazwy użytkownika powiązania OpenID Connect jest ustawione na „auto” lub na konkretne pole, które można wyszukać w Entra ID - „upn”, „oid”, „email” lub „samaccountname”. W przypadku wartości „auto” nazwa użytkownika Moodle jest dopasowywana do głównej nazwy użytkownika (UPN) w Entra ID, a konto jest również uznawane za istniejące w Entra ID, gdy jego nazwa użytkownika lub adres e-mail jest zgodny z adresem e-mail w Entra ID, aby nie zostało zawieszone przez pomyłkę. W przypadku dowolnego innego oświadczenia nazwy użytkownika Moodle nie można wiarygodnie dopasować do pojedynczego konta, a ta opcja nie robi nic.

Po pierwszym uruchomieniu sprawdź zawieszonych użytkowników: konto ręcznie przełączone na tę metodę uwierzytelniania, które nigdy nie było prawdziwym użytkownikiem Entra ID, zostanie zawieszone przez tę opcję.';
$string['help_user_match'] = 'Pomoc dotycząca dopasowywania kont';
$string['help_user_match_help'] = 'Spowoduje to przejrzenie każdego użytkownika w połączonej usłudze Microsoft Entra ID i próbę dopasowania go do użytkownika w Moodle. Dopasowanie opiera się na nazwie UPN Microsoft Entra ID i nazwie użytkownika Moodle. W dopasowaniach wielkość liter nie jest rozróżniana, a część domeny nazwy UPN Microsoft Entra ID jest ignorowana. Na przykład „BoB.SmiTh” w Moodle zostałoby dopasowane do „bob.smith@example.onmicrosoft.com”. Konta Moodle i Microsoft Entra ID użytkowników, dla których znaleziono dopasowanie, zostaną połączone i będą oni mogli korzystać ze wszystkich funkcji integracji Microsoft 365 i Moodle. Metoda uwierzytelniania użytkownika nie zmieni się, o ile nie zostanie włączone poniższe ustawienie.';
$string['help_user_matchswitchauth'] = 'Pomoc dotycząca przełączania dopasowanych kont';
$string['help_user_matchswitchauth_help'] = 'Wymaga to włączenia powyższego ustawienia „Dopasuj wcześniej istniejących użytkowników Moodle”. Gdy użytkownik zostanie dopasowany, włączenie tego ustawienia spowoduje przełączenie jego metody uwierzytelniania na OpenID Connect. Będzie on mógł wtedy logować się do Moodle za pomocą poświadczeń Microsoft 365. Uwaga: Aby korzystać z tego ustawienia, upewnij się, że wtyczka uwierzytelniania OpenID Connect jest włączona. Ostrzeżenie: jeśli nazwa użytkownika Moodle pasuje tylko do części nazwy UPN Microsoft Entra ID przed znakiem „@” (a nie do pełnej nazwy UPN), zaawansowane ustawienie „Minimalna długość niedokładnej nazwy użytkownika do przełączenia na Microsoft 365” może uniemożliwić przełączenie metody uwierzytelniania dla użytkowników z krótkimi nazwami użytkownika.';
$string['help_user_appassign'] = 'Pomoc dotycząca przypisywania użytkowników do aplikacji';
$string['help_user_appassign_help'] = 'Spowoduje to przypisanie wszystkich kont Microsoft Entra ID z pasującymi kontami Moodle do aplikacji Microsoft Entra ID utworzonej dla tej instalacji Moodle, jeśli nie zostały jeszcze przypisane.';
$string['help_user_photosync'] = 'Pomoc dotycząca synchronizacji zdjęć profilowych Microsoft 365 (cron)';
$string['help_user_photosync_help'] = 'Spowoduje to synchronizację zdjęć profilowych wszystkich użytkowników w Moodle z ich zdjęciami profilowymi Microsoft 365.';
$string['help_user_photosynconlogin'] = 'Pomoc dotycząca synchronizacji zdjęć profilowych Microsoft 365 (logowanie)';
$string['help_user_photosynconlogin_help'] = 'Spowoduje to synchronizację zdjęcia profilowego użytkownika w Moodle z jego zdjęciem profilowym Microsoft 365 podczas logowania. Należy pamiętać, że wymaga to odwiedzenia przez użytkownika strony zawierającej blok Microsoft w Moodle.';
$string['help_user_nodelta'] = 'Pomoc dotycząca pełnej synchronizacji';
$string['help_user_nodelta_help'] = 'Domyślnie synchronizacja użytkowników synchronizuje tylko zmiany z Microsoft Entra ID od ostatniego uruchomienia synchronizacji. Zaznaczenie tej opcji wymusi pełną synchronizację użytkowników za każdym razem.';
$string['help_user_emailsync'] = 'Pomoc dotycząca synchronizacji nazw użytkowników Microsoft Entra ID z adresami e-mail w Moodle';
$string['help_user_emailsync_help'] = 'Włączenie tej opcji spowoduje dopasowywanie nazw użytkowników Microsoft Entra ID do adresów e-mail w Moodle, zamiast domyślnego zachowania, czyli dopasowywania nazw użytkowników Microsoft Entra ID do nazw użytkowników w Moodle.';
$string['help_user_tzsync'] = 'Pomoc dotycząca synchronizacji strefy czasowej programu Outlook (cron)';
$string['help_user_tzsync_help'] = 'Spowoduje to synchronizację strefy czasowej wszystkich użytkowników w Moodle z ich preferowaną strefą czasową programu Outlook.';
$string['help_user_tzsynconlogin'] = 'Pomoc dotycząca synchronizacji strefy czasowej programu Outlook (logowanie)';
$string['help_user_tzsynconlogin_help'] = 'Spowoduje to synchronizację strefy czasowej użytkownika w Moodle z jego preferowaną strefą czasową programu Outlook. Należy pamiętać, że wymaga to odwiedzenia przez użytkownika strony zawierającej blok Microsoft w Moodle.';
$string['help_user_guestsync'] = 'Pomoc dotycząca synchronizacji użytkowników-gości';
$string['help_user_guestsync_help'] = 'Jeśli ta opcja jest włączona, goście w Microsoft Entra ID będą synchronizowani z Moodle w zadaniu synchronizacji użytkowników.';

// Cohort sync feature.
$string['cohortsync_title'] = 'Synchronizacja kohort';
$string['cohortsync_taskname'] = 'Synchronizacja kohort';
$string['cohortsync_mappingadded'] = 'Nowe połączenie zostało pomyślnie dodane';
$string['cohortsync_mappingdeleted'] = 'Połączenie zostało pomyślnie usunięte';
$string['cohortsync_addmapping'] = 'Dodaj połączenie';
$string['cohortsync_deletemapping'] = 'Usuń połączenie';
$string['cohortsync_desc'] = 'Ta strona umożliwia jednokierunkową synchronizację z grup Microsoft 365 do kohort Moodle w kontekście systemowym. Dodanie nowego połączenia rozpocznie proces synchronizacji - użytkownicy z wybranej grupy Microsoft 365, którzy są połączeni z Microsoft, zostaną dodani do wybranej kohorty Moodle.';
$string['cohortsync_tabledesc'] = 'Bieżące połączenia między grupami Microsoft 365 a kohortami Moodle';
$string['cohortsync_typetosearch'] = 'Wpisz, aby wyszukać grupę Microsoft 365';
$string['cohortsync_typetosearch_cohort'] = 'Wpisz, aby wyszukać kohortę Moodle';
$string['cohortsync_emptymatchings'] = 'Nie znaleziono połączeń';
$string['cohortsync_select_cohort'] = 'Kohorta Moodle';
$string['cohortsync_select_group'] = 'Grupa Microsoft 365';
$string['cohortsync_tablehead_group'] = 'Grupa Microsoft 365';
$string['cohortsync_tablehead_cohort'] = 'Kohorta Moodle';
$string['cohortsync_tablehead_actions'] = 'Akcje';
$string['cohortsync_search'] = 'Szukaj';
$string['cohortsync_load_more'] = 'Załaduj więcej...';
$string['cohortsync_no_groups_found'] = 'Nie znaleziono grup Microsoft 365 dla „{$a}”';
$string['cohortsync_no_cohorts_found'] = 'Nie znaleziono kohort Moodle dla „{$a}”';
$string['cohortsync_error_no_group'] = 'Wybierz grupę Microsoft 365.';
$string['cohortsync_error_no_cohort'] = 'Wybierz kohortę Moodle.';
$string['cohortsync_mappingfailed'] = 'Błąd podczas dodawania połączenia kohorty i grupy. Możliwe przyczyny: grupa lub kohorta nie istnieje, grupa jest już połączona z inną kohortą, grupa jest już połączona z tą kohortą.';
$string['cohortsync_connectionnotfound'] = 'Nieprawidłowe żądanie: nie znaleziono połączenia.';
$string['cohortsync_connectionnotcohortsync'] = 'Nieprawidłowe żądanie: niezgodny typ połączenia.';
$string['cohortsync_unifiedapierror'] = 'Błąd podczas pobierania listy grup z Microsoft.';

// Course request.
$string['courserequest_teams'] = 'Zespół Microsoft Teams';
$string['courserequest_teams_help'] = 'Wybierz zespół Microsoft Teams, który zostanie połączony z kursem. Istniejący właściciele i członkowie zespołu zostaną zapisani na utworzony kurs po zatwierdzeniu żądania kursu.';
$string['courserequest_emptyteams'] = 'Brak dostępnych zespołów Microsoft Teams';
$string['courserequest_title'] = 'Zażądaj kursu z usługi Teams';
$string['courserequest_updatecourserequeststatus_taskname'] = 'Aktualizuj stan żądania kursu';
$string['courserequest_customrequestnote'] = '
| To żądanie zostało wysłane ze strony żądania kursu w Microsoft Teams i po zatwierdzeniu zostanie połączone z zespołem: „{$a->name}” o adresie URL {$a->url}.';
$string['courserequest_graphapi_disabled'] = 'Połączenie z Microsoft Teams jest niedostępne. Skontaktuj się z administratorem witryny.';
$string['courserequest_invalid_team'] = 'W żądaniu kursu użyto nieprawidłowego zespołu.';
$string['courserequest_duplicate'] = 'Oczekujące lub zatwierdzone żądanie kursu z tego samego zespołu już istnieje.';

// Teams page.
$string['teams_no_course'] = 'Nie masz żadnego kursu do dodania.';
$string['tab_name'] = 'Nazwa karty';
$string['sso_login'] = 'Zaloguj się do Microsoft 365';
$string['other_login'] = 'Zaloguj się ręcznie';
$string['course_selector_label'] = 'Wybierz istniejący kurs';

// Notifications to site admin about Microsoft Entra ID app secret.
$string['notification_subject_secret_expired'] = 'Wymagane działanie: klucz tajny aplikacji Microsoft Entra ID wygasł';
$string['notification_content_secret_expired'] = 'Szanowny administratorze witryny,

Klucz tajny aplikacji Microsoft Entra ID używany w integracji Moodle i Microsoft 365 wygasł.
Utwórz nowy klucz tajny w Microsoft Entra ID i zaktualizuj go w konfiguracji integracji, aby przywrócić działanie integracji.';
$string['notification_subject_secret_almost_expired'] = 'Wymagane działanie: klucz tajny aplikacji Microsoft Entra ID wkrótce wygaśnie';
$string['notification_content_secret_almost_expired'] = 'Szanowny administratorze witryny,

Klucz tajny aplikacji Microsoft Entra ID używany w integracji Moodle i Microsoft 365 wygaśnie za {$a}.
Utwórz nowy klucz tajny w Microsoft Entra ID i zaktualizuj go w konfiguracji integracji, aby uniknąć zakłóceń w działaniu integracji.';
$string['notification_days_less_than_one_day'] = 'mniej niż 1 dzień';
$string['notification_days_one_day'] = '1 dzień';
$string['notification_days_days'] = '{$a} dni';
$string['notification_subject_invalid_secret'] = 'Wymagane działanie: znaleziono nieprawidłowy klucz tajny aplikacji Microsoft Entra ID';
$string['notification_content_invalid_secret'] = 'Szanowny administratorze witryny,

Klucz tajny aplikacji Microsoft Entra ID używany w integracji Moodle i Microsoft 365 wydaje się nieprawidłowy. Przyczyną może być wygaśnięcie lub usunięcie klucza tajnego.
Sprawdź klucz tajny, aby upewnić się, że integracja działa zgodnie z oczekiwaniami.';

// Async operations.
$string['teamsasyncfailed'] = 'Asynchroniczna operacja tworzenia zespołu nie powiodła się: {$a}';
$string['unknownasyncstate'] = 'Nieznany stan operacji asynchronicznej: {$a}';

// Template ID validation.
$string['error_template_id_empty'] = 'Identyfikator szablonu nie może być pusty.';
$string['error_not_connected'] = 'Brak połączenia z Microsoft 365. Najpierw skonfiguruj integrację z Microsoft 365.';
$string['error_graph_client_not_available'] = 'Nie można połączyć się z Microsoft Graph API. Sprawdź konfigurację integracji z Microsoft 365.';
$string['success_template_id_valid'] = '✓ Identyfikator szablonu „{$a}” jest prawidłowy i dostępny.';
$string['error_template_id_not_found'] = '✗ Nie znaleziono identyfikatora szablonu „{$a}”. Sprawdź identyfikator szablonu w centrum administracyjnym usługi Teams.';
$string['error_template_validation_failed'] = '✗ Weryfikacja szablonu nie powiodła się: {$a}';
$string['error_template_validation_error'] = '✗ Wystąpił błąd podczas weryfikacji szablonu. Spróbuj ponownie lub skontaktuj się z administratorem.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
