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
$string['settings_pageheading'] = 'Konfiguracja {$a}';
$string['settings_page_other_settings'] = 'Pozostałe opcje';
$string['settings_page_application'] = 'IdP i uwierzytelnianie';
$string['settings_page_application_wizard'] = 'Kreator konfiguracji aplikacji';
$string['settings_page_binding_username_claim'] = 'Powiązanie z oświadczeniem nazwy użytkownika';
$string['settings_page_change_binding_username_claim_tool'] = 'Narzędzie zmiany powiązania z oświadczeniem nazwy użytkownika';
$string['settings_page_cleanup_oidc_tokens'] = 'Wyczyść tokeny OpenID Connect';
$string['settings_page_clear_user_tokens'] = 'Wyczyść tokeny użytkowników';
$string['settings_page_field_mapping'] = 'Mapowanie pól';
$string['heading_additional_options'] = 'Opcje dodatkowe';
$string['heading_additional_options_desc'] = '';
$string['heading_stateredirect'] = 'Strona błędu stanu logowania';
$string['heading_stateredirect_desc'] = 'Domyślnie, jeśli użytkownik zbyt długo kończy logowanie u dostawcy tożsamości (na przykład podczas zatwierdzania monitu uwierzytelniania wieloskładnikowego), a zapisany stan logowania został w międzyczasie wyczyszczony, Moodle wyświetla ogólną stronę błędu. Poniższe ustawienia pozwalają wydłużyć czas przechowywania stanu logowania oraz wyświetlać bardziej przyjazny, konfigurowalny komunikat zamiast ogólnej strony błędu, z automatycznym przekierowaniem użytkownika z powrotem na stronę logowania.';
$string['heading_user_restrictions'] = 'Ograniczenia użytkowników';
$string['heading_user_restrictions_desc'] = '';
$string['heading_sign_out'] = 'Integracja wylogowywania';
$string['heading_sign_out_desc'] = '';
$string['heading_display'] = 'Wyświetlanie';
$string['heading_display_desc'] = '';
$string['heading_debugging'] = 'Debugowanie';
$string['heading_debugging_desc'] = '';
$string['heading_tools'] = 'Narzędzia';
$string['microsoftcloud'] = 'Chmura Microsoft';
$string['microsoftcloud_help'] = 'Wybierz chmurę Microsoft, do której należy Twój dzierżawca Microsoft Entra. Dotyczy typów IdP Microsoft Entra ID i Microsoft identity platform.<br/>
Wybierz „Microsoft 365 operated by 21Vianet (China)”, jeśli Twoja organizacja korzysta z Microsoft 365 udostępnianego przez 21Vianet. Do żądań wysyłanych przez wtyczki będą wówczas używane usługa logowania i punkty końcowe Microsoft Graph tej chmury, a domyślne wartości punktów końcowych i zasobu poniżej będą z nią zgodne. Wartości już zapisane dla punktów końcowych, zasobu i punktu końcowego wylogowania nie są zmieniane, więc zaktualizuj je, jeśli nadal wskazują punkty końcowe chmury globalnej.';
$string['microsoftcloud_global'] = 'Microsoft 365 (globalna)';
$string['microsoftcloud_china'] = 'Microsoft 365 operated by 21Vianet (China)';
$string['idptype'] = 'Typ dostawcy tożsamości (IdP)';
$string['idptype_help'] = 'Obecnie obsługiwane są trzy typy IdP:
<ul>
<li><b>Microsoft Entra ID (v1.0)</b>: Microsoft Entra ID z punktami końcowymi oauth2 v1.0, np. https://login.microsoftonline.com/organizations/oauth2/authorize.</li>
<li><b>Microsoft identity platform (v2.0)</b>: Microsoft Entra ID z punktami końcowymi oauth2 v2.0, np. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize.</li>
<li><b>Inny</b>: dowolny dostawca tożsamości inny niż Microsoft.</li>
</ul>
Różnice między opcjami <b>Microsoft Entra ID (v1.0)</b> i <b>Microsoft identity platform (v2.0)</b> opisano pod adresem <a href="https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison">https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison</a>.<br/>
W szczególności skonfigurowana aplikacja może używać do uwierzytelniania <b>certyfikatu</b> zamiast <b>klucza tajnego</b>, gdy używany jest IdP <b>Microsoft identity platform (v2.0)</b>.<br/>
Punkty końcowe autoryzacji i tokenów należy skonfigurować zgodnie ze skonfigurowanym typem IdP.';
$string['idp_type_not_connected'] = 'Niepołączony';
$string['idp_type_microsoft_entra_id'] = 'Microsoft Entra ID (v1.0)';
$string['idp_type_microsoft_identity_platform'] = 'Microsoft identity platform (v2.0)';
$string['idp_type_other'] = 'Inny';
$string['settings_application_wizard_desc'] = 'Aby skonfigurować te ustawienia za pomocą formularza z instrukcjami krok po kroku i walidacją danych, użyj <a href="{$a}">Kreatora konfiguracji aplikacji</a>.';
$string['authendpoint'] = 'Punkt końcowy autoryzacji';
$string['authendpoint_help'] = 'Identyfikator URI punktu końcowego autoryzacji używanego z Twojego IdP.<br/>
Pamiętaj, że jeśli witryna ma umożliwiać dostęp użytkownikom z innych dzierżawców, nie można używać punktu końcowego autoryzacji właściwego dla jednego dzierżawcy.';
$string['clientid'] = 'Identyfikator aplikacji';
$string['clientid_help'] = 'Zarejestrowany identyfikator aplikacji / klienta w IdP.';
$string['clientauthmethod'] = 'Metoda uwierzytelniania klienta';
$string['clientauthmethod_help'] = '<ul>
<li>IdP wszystkich typów może używać metody uwierzytelniania „<b>Klucz tajny</b>”.</li>
<li>IdP typu <b>Microsoft identity platform (v2.0)</b> może dodatkowo używać metody uwierzytelniania <b>Certyfikat</b>.</li>
</ul>';
$string['auth_method_secret'] = 'Klucz tajny';
$string['auth_method_certificate'] = 'Certyfikat';
$string['clientsecret'] = 'Klucz tajny klienta';
$string['clientsecret_help'] = 'W przypadku metody uwierzytelniania <b>klucz tajny</b> jest to klucz tajny klienta w IdP. U niektórych dostawców nazywany jest także kluczem.';
$string['clientprivatekey'] = 'Klucz prywatny certyfikatu klienta';
$string['clientprivatekey_help'] = 'W przypadku metody uwierzytelniania <b>certyfikat</b> i źródła certyfikatu <b>Zwykły tekst</b> jest to klucz prywatny certyfikatu używanego do uwierzytelniania w IdP.';
$string['clientcert'] = 'Klucz publiczny certyfikatu klienta';
$string['clientcert_help'] = 'W przypadku metody uwierzytelniania <b>certyfikat</b> i źródła certyfikatu <b>Zwykły tekst</b> jest to klucz publiczny, czyli certyfikat, używany do uwierzytelniania w IdP.';
$string['clientcertsource'] = 'Źródło certyfikatu';
$string['clientcertsource_help'] = 'W przypadku metody uwierzytelniania <b>certyfikat</b> określa, skąd pobierany jest certyfikat.
<ul>
<li>Źródło <b>Zwykły tekst</b> wymaga podania zawartości pliku certyfikatu / klucza prywatnego w kolejnych polach tekstowych.</li>
<li>Źródło <b>Nazwa pliku</b> wymaga, aby pliki certyfikatu / klucza prywatnego znajdowały się w folderze <b>microsoft_certs</b> w folderze danych Moodle.</li>
</ul>';
$string['cert_source_text'] = 'Zwykły tekst';
$string['cert_source_path'] = 'Nazwa pliku';
$string['clientprivatekeyfile'] = 'Nazwa pliku klucza prywatnego certyfikatu klienta';
$string['clientprivatekeyfile_help'] = 'W przypadku metody uwierzytelniania <b>certyfikat</b> i źródła certyfikatu <b>Nazwa pliku</b> jest to nazwa pliku klucza prywatnego używanego do uwierzytelniania w IdP. Plik musi znajdować się w folderze <b>microsoft_certs</b> w folderze danych Moodle.';
$string['clientcertfile'] = 'Nazwa pliku klucza publicznego certyfikatu klienta';
$string['clientcertfile_help'] = 'W przypadku metody uwierzytelniania <b>certyfikat</b> i źródła certyfikatu <b>Nazwa pliku</b> jest to nazwa pliku klucza publicznego, czyli certyfikatu, używanego do uwierzytelniania w IdP. Plik musi znajdować się w folderze <b>microsoft_certs</b> w folderze danych Moodle.';
$string['clientcertpassphrase'] = 'Hasło certyfikatu klienta';
$string['clientcertpassphrase_help'] = 'Jeśli klucz prywatny certyfikatu klienta jest zaszyfrowany, jest to hasło służące do jego odszyfrowania.';
$string['change_client_secret'] = 'Zmień klucz tajny klienta';
$string['change_client_secret_desc'] = 'Zaznacz to pole, aby zaktualizować klucz tajny klienta. Ze względów bezpieczeństwa istniejące klucze tajne są maskowane i wyświetlane są tylko pierwsze 2 znaki.';
$string['change_cert_passphrase'] = 'Zmień hasło certyfikatu';
$string['change_cert_passphrase_desc'] = 'Zaznacz to pole, aby zaktualizować hasło certyfikatu. Ze względów bezpieczeństwa istniejące hasła są maskowane i wyświetlane są tylko pierwsze 2 znaki.';
$string['cfg_usepkce_key'] = 'Używaj PKCE';
$string['cfg_usepkce_desc'] = 'W przypadku przepływu logowania <b>Kod autoryzacji</b> wysyłaj w żądaniu autoryzacji parametr PKCE (RFC 7636) „code_challenge” z metodą S256, a podczas wymiany kodu autoryzacji odpowiadający mu „code_verifier”. Microsoft Entra ID obsługuje tę funkcję. W przypadku innych dostawców włącz tę opcję tylko wtedy, gdy dostawca obsługuje PKCE, ponieważ niektórzy dostawcy odrzucają żądania autoryzacji z nierozpoznawanymi parametrami.';
$string['cfg_domainhint_key'] = 'Wskazówka domeny';
$string['cfg_domainhint_desc'] = 'W przypadku przepływu logowania <b>Kod autoryzacji</b> przekaż tę wartość jako parametr „domain_hint”. Parametr „domain_hint” jest używany przez niektóre IdP OpenID Connect w celu ułatwienia użytkownikom procesu logowania. Sprawdź u dostawcy, czy obsługuje ten parametr.';
$string['cfg_forceselectaccount_key'] = 'Zawsze wyświetlaj wybór konta';
$string['cfg_forceselectaccount_desc'] = 'Jeśli włączone, użytkownicy są zawsze proszeni o wybranie konta, za pomocą którego się logują, zamiast być logowani automatycznie na konto aktywne w przeglądarce. Przydatne, gdy użytkownicy mają kilka kont, na przykład konto studenta i konto administratora.<br/>
Tryb logowania w tle ma pierwszeństwo: gdy jest włączony, wybór konta nie jest wymuszany podczas logowania w tle.';
$string['cfg_forceredirect_key'] = 'Wymuś przekierowanie';
$string['cfg_forceredirect_desc'] = 'Jeśli włączone, pomija stronę główną logowania i przekierowuje na stronę OpenID Connect. Można to ominąć za pomocą parametru URL ?noredirect=1';
$string['cfg_stateexpiry_key'] = 'Wygaśnięcie stanu logowania (minuty)';
$string['cfg_stateexpiry_desc'] = 'Jak długo rekord stanu logowania jest przechowywany, zanim usunie go zaplanowane zadanie czyszczenia. Zwiększ tę wartość, jeśli użytkownicy regularnie potrzebują więcej czasu na dokończenie logowania u dostawcy tożsamości (na przykład z powodu monitów uwierzytelniania wieloskładnikowego).';
$string['error_stateexpiry_min'] = 'Wygaśnięcie stanu logowania musi wynosić co najmniej 1 minutę. Wartość zero lub mniejsza spowodowałaby niepowodzenie aktualnie trwających logowań.';
$string['cfg_stateredirect_enabled_key'] = 'Wyświetlaj przyjazną stronę błędu';
$string['cfg_stateredirect_enabled_desc'] = 'Jeśli włączone, użytkownik, który zbyt długo kończy logowanie u dostawcy tożsamości (tak że zapisany stan logowania został w międzyczasie wyczyszczony), zobaczy poniższy konfigurowalny komunikat i zostanie automatycznie przekierowany z powrotem na stronę logowania, zamiast ogólnej strony błędu Moodle.';
$string['cfg_stateredirect_message_key'] = 'Komunikat';
$string['cfg_stateredirect_message_desc'] = 'Komunikat wyświetlany użytkownikowi na przyjaznej stronie błędu.';
$string['cfg_stateredirect_message_default'] = 'Wystąpił problem z logowaniem. Najprawdopodobniej logowanie trwało zbyt długo (na przykład podczas zatwierdzania monitu uwierzytelniania wieloskładnikowego). Zostaniesz automatycznie przekierowany na stronę logowania, aby spróbować ponownie.';
$string['cfg_stateredirect_delay_key'] = 'Opóźnienie przekierowania (sekundy)';
$string['cfg_stateredirect_delay_desc'] = 'Liczba sekund, przez które wyświetlany jest powyższy komunikat, zanim użytkownik zostanie automatycznie przekierowany z powrotem na stronę logowania.';
$string['cfg_set_pix_key'] = 'Wyświetlaj ikonę na stronie logowania';
$string['cfg_set_pix_desc'] = 'Jeśli włączone, wyświetla ikonę obok nazwy dostawcy na stronie logowania.';
$string['cfg_icon_key'] = 'Ikona';
$string['cfg_icon_desc'] = 'Ikona wyświetlana obok nazwy dostawcy na stronie logowania.';
$string['cfg_iconalt_o365'] = 'Ikona Office 365';
$string['cfg_iconalt_microsoft365'] = 'Logo Microsoft 365';
$string['cfg_iconalt_openid'] = 'Ikona OpenID';
$string['cfg_iconalt_keycloak'] = 'Ikona Keycloak';
$string['cfg_customicon_key'] = 'Niestandardowa ikona';
$string['cfg_customicon_desc'] = 'Jeśli chcesz użyć własnej ikony, prześlij ją tutaj. Zastępuje ona każdą ikonę wybraną powyżej. <br /><br /><b>Uwagi dotyczące używania niestandardowych ikon:</b><ul><li>Rozmiar przesłanego pliku nie jest zmieniany. Na stronie logowania będzie on wyświetlany w stałym rozmiarze 24x24 piksele, a przeglądarka dopasuje jego skalę, dlatego zalecamy przesłanie kwadratowego obrazu, aby uniknąć zniekształceń.</li><li>Jeśli przesłano ikonę niestandardową i chcesz wrócić do jednej ze standardowych ikon, kliknij ikonę niestandardową w polu powyżej, następnie kliknij „Usuń”, potem „OK”, a następnie „Zapisz zmiany” w dolnej części formularza. Wybrana ikona standardowa będzie wówczas wyświetlana na stronie logowania Moodle.</li></ul>';
$string['cfg_debugmode_key'] = 'Rejestruj komunikaty debugowania';
$string['cfg_debugmode_desc'] = 'Jeśli ta opcja jest włączona, informacje będą rejestrowane w pliku dziennika platformy Moodle, aby pomóc w identyfikacji problemów.';
$string['cfg_silentloginmode_key'] = 'Tryb logowania w tle';
$string['cfg_silentloginmode_desc'] = 'Jeśli włączone, Moodle będzie próbować zalogować użytkownika przy użyciu aktywnej sesji użytkownika uwierzytelnionego w skonfigurowanym punkcie końcowym autoryzacji.<br/>
Aby korzystać z tej funkcji, wymagana jest następująca konfiguracja:
<ul>
<li>Włączona opcja <b>Wymuszaj zalogowanie użytkowników</b> (forcelogin) w <a href="{$a}" target="_blank">sekcji Ustawienia zabezpieczeń witryny</a>.</li>
<li>Włączone powyżej ustawienie <b>Wymuś przekierowanie</b> (auth_oidc/forceredirect).</li>
</ul>
Aby Moodle nie próbował logować użytkowników za pomocą kont osobistych lub kont z innych dzierżawców, zaleca się także używanie punktów końcowych właściwych dla dzierżawcy, a nie ogólnych, ze ścieżkami „common”, „organizations” itp.<br/>
<br/>
W przypadku dostawców tożsamości Microsoft użytkownik zobaczy następujące zachowanie:
<ul>
<li>Jeśli nie znaleziono aktywnej sesji użytkownika, zostanie wyświetlona strona logowania Moodle.</li>
<li>Jeśli znaleziono tylko jedną aktywną sesję użytkownika, a użytkownik ma dostęp do aplikacji Entra ID (tzn. pochodzi z tego samego dzierżawcy lub jest użytkownikiem-gościem dzierżawcy), zostanie automatycznie zalogowany do Moodle przy użyciu logowania jednokrotnego (SSO).</li>
<li>Jeśli znaleziono tylko jedną aktywną sesję użytkownika, ale użytkownik nie ma dostępu do aplikacji Entra ID (np. pochodzi z innego dzierżawcy lub aplikacja wymaga przypisania użytkowników, a użytkownik nie został przypisany), zostanie wyświetlona strona logowania Moodle.</li>
<li>Jeśli istnieje wiele aktywnych sesji użytkowników mających dostęp do aplikacji Entra ID, zostanie wyświetlona strona umożliwiająca użytkownikowi wybranie konta, za pomocą którego ma się zalogować.</li>
</ul>';
$string['oidcresource'] = 'Zasób';
$string['oidcresource_help'] = 'Zasób OpenID Connect, dla którego wysyłane jest żądanie.<br/>
<b>Uwaga:</b> ten parametr nie jest obsługiwany w typie IdP <b>Microsoft identity platform (v2.0)</b>.';
$string['oidcscope'] = 'Zakres';
$string['oidcscope_help'] = 'Zakres OIDC do użycia.';
$string['customclaims'] = 'Oświadczenia niestandardowe';
$string['customclaims_help'] = 'Lista nazw oświadczeń niestandardowych z tokenów Twojego dostawcy tożsamości, oddzielonych spacjami.<br/>
<b>Ważne:</b>
<ul>
<li>Oświadczenia muszą istnieć w konfiguracji tokenów Twojego IdP (np. mappery protokołu Keycloak, opcjonalne/niestandardowe oświadczenia Microsoft Entra ID)</li>
<li>Jeśli oświadczenie nie istnieje w tokenie, mapowanie pól po cichu je pominie - nie zostanie wyświetlony żaden błąd</li>
<li>W nazwach oświadczeń rozróżniana jest wielkość liter i mogą one zawierać tylko znaki alfanumeryczne, myślniki i podkreślenia</li>
<li>Nazwa oświadczenia nie może być nazwą zarezerwowaną, taką jak standardowe oświadczenie JWT/OpenID Connect (np. <code>sub</code>, <code>email</code>), oświadczenie specyficzne dla Microsoft Entra ID (np. <code>oid</code>, <code>upn</code>) lub Keycloak (np. <code>realm_access</code>, <code>resource_access</code>) albo istniejąca opcja mapowania pól</li>
<li>Dozwolone są oświadczenie <code>roles</code> (role aplikacji w tokenach Microsoft Entra ID) i oświadczenie <code>groups</code> (identyfikatory grup). W mapowaniu pól są wymienione jako „roles (token claim)” i „groups (token claim)”, osobno od wbudowanych opcji „Roles” i „Groups”, które mapują role katalogu Microsoft Entra i nazwy grup z Microsoft Graph. Oświadczenia zawierające listę wartości są zapisywane jako lista oddzielona przecinkami</li>
<li>Przykłady: <code>employee_type badge_number costCenter custom_role</code></li>
<li>Podczas logowania oświadczenia niestandardowe są zawsze odczytywane z tokenu, niezależnie od tego, czy używany jest także Microsoft Graph. Podczas zaplanowanego zadania synchronizacji użytkowników nie ma tokenu użytkownika, z którego można odczytywać dane, więc oświadczenie niestandardowe jest synchronizowane tylko wtedy, gdy jego nazwa jest jednocześnie wybieralną właściwością użytkownika Microsoft Graph, taką jak atrybut rozszerzenia katalogu (np. <code>extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode</code>). Oświadczenie niestandardowe odrzucone przez Microsoft Graph jest pomijane w danym przebiegu synchronizacji, z ostrzeżeniem w dzienniku zadania, zamiast przerywać całą synchronizację.</li>
</ul>';
$string['secretexpiryrecipients'] = 'Odbiorcy powiadomień o wygaśnięciu klucza tajnego';
$string['secretexpiryrecipients_help'] = 'Lista adresów e-mail oddzielonych przecinkami, na które wysyłane są powiadomienia o wygaśnięciu klucza tajnego.<br/>
Jeśli nie wprowadzono żadnego adresu e-mail, powiadomienie otrzyma główny administrator witryny.<br/>
Domyślnie powiadomienia są wysyłane codziennie, od czterech tygodni przed wygaśnięciem do czasu odnowienia klucza tajnego.';
$string['cfg_showbutton_key'] = 'Wyświetlaj przycisk logowania';
$string['cfg_showbutton_desc'] = 'Jeśli wyłączone, przycisk logowania dostawcy nie jest wyświetlany na stronie logowania. Użytkownicy nadal mogą uwierzytelniać się za pośrednictwem tego dostawcy, przechodząc bezpośrednio pod jego adres URL logowania.';
$string['cfg_opname_key'] = 'Nazwa dostawcy';
$string['cfg_opname_desc'] = 'Jest to etykieta dla użytkownika końcowego określająca rodzaj danych logowania, których użytkownik musi użyć do logowania. Ta etykieta jest używana w obszarach wtyczki widocznych dla użytkownika w celu zidentyfikowania dostawcy.';
$string['cfg_redirecturi_key'] = 'Adres URI przekierowania';
$string['cfg_redirecturi_desc'] = 'Jest to identyfikator URI, który należy zarejestrować jako „Adres URI przekierowania”. Dostawca tożsamości wtyczki OpenID Connect powinien zapytać o ten identyfikator podczas rejestracji platformy Moodle jako klienta. <br /><b>UWAGA:</b> Należy go wprowadzić do dostawcy OpenID Connect *dokładnie* w takiej postaci, w jakiej występuje w tym miejscu. Dowolna różnica uniemożliwi logowanie za pomocą OpenID Connect.';
$string['tokenendpoint'] = 'Punkt końcowy tokenu';
$string['tokenendpoint_help'] = 'Identyfikator URI punktu końcowego tokenu używanego z Twojego IdP.<br/>
Pamiętaj, że jeśli witryna ma umożliwiać dostęp użytkownikom z innych dzierżawców, nie można używać punktu końcowego tokenu właściwego dla jednego dzierżawcy.';
$string['cfg_userrestrictions_key'] = 'Ograniczenia użytkowników';
$string['cfg_userrestrictions_desc'] = 'Zezwalaj na logowanie tylko użytkownikom spełniającym określone ograniczenia. <br /><b>Jak używać ograniczeń użytkowników: </b> <ul><li>Wprowadź wzorzec <a href="https://en.wikipedia.org/wiki/Regular_expression">wyrażenia regularnego</a> pasujący do nazw użytkowników, którym chcesz zezwolić na dostęp.</li><li>Wprowadzaj jeden wzorzec w wierszu</li><li>Jeśli wprowadzisz wiele wzorców, użytkownik będzie dopuszczony, jeśli pasuje do DOWOLNEGO z nich.</li><li>Znak „/” należy poprzedzić znakiem „\\”.</li><li>Jeśli powyżej nie wprowadzisz żadnych ograniczeń, Moodle zaakceptuje wszystkich użytkowników, którzy mogą się zalogować do IdP OpenID Connect.</li><li>Każdy użytkownik, który nie pasuje do żadnego z wprowadzonych wzorców, nie będzie mógł się logować za pomocą OpenID Connect.</li></ul>';
$string['cfg_userrestrictionscasesensitive_key'] = 'Ograniczenia użytkowników z uwzględnieniem wielkości liter';
$string['cfg_userrestrictionscasesensitive_desc'] = 'Określa, czy w dopasowaniu ograniczeń użytkowników używana jest opcja „/i” wyrażenia regularnego.<br/>Jeśli włączone, wszystkie kontrole ograniczeń użytkowników uwzględniają wielkość liter. Pamiętaj, że jeśli ta opcja jest wyłączona, wszelkie wzorce dotyczące wielkości liter są ignorowane.';
$string['heading_dummy_email'] = 'Zastępcze adresy e-mail';
$string['heading_dummy_email_desc'] = 'Moodle wymaga, aby każde konto użytkownika miało adres e-mail, ale konta Microsoft Entra ID nie muszą go mieć. Poniższe ustawienia pozwalają Moodle generować niedostarczalny zastępczy adres dla użytkowników, którzy nie mają użytecznego adresu e-mail z IdP, zamiast pozostawiać ich adres e-mail pusty.';
$string['cfg_generatedummyemail_key'] = 'Generuj zastępcze adresy e-mail';
$string['cfg_generatedummyemail_desc'] = 'Jeśli włączone, gdy użytkownik nie ma adresu e-mail ani użytecznej nazwy głównej użytkownika w formacie adresu e-mail z IdP, Moodle wygeneruje dla niego zastępczy adres e-mail przy użyciu jego nazwy głównej użytkownika Microsoft (lub identyfikatora obiektu, jeśli nazwa główna użytkownika jest niedostępna) oraz domeny skonfigurowanej poniżej, zamiast pozostawiać jego adres e-mail pusty. Dotyczy to zarówno logowania użytkownika, jak i aprowizacji przez zadanie synchronizacji użytkowników.';
$string['cfg_dummyemaildomain_key'] = 'Domena zastępczych adresów e-mail';
$string['cfg_dummyemaildomain_desc'] = 'Domena używana do generowania zastępczych adresów e-mail, na przykład „example.test”. Użyj domeny, która nie może odbierać poczty, aby wygenerowane adresy nigdy nie zostały pomylone z prawdziwymi, dostarczalnymi adresami.';
$string['cfg_signoffintegration_key'] = 'Wylogowanie jednokrotne (z Moodle do IdP)';
$string['cfg_signoffintegration_desc'] = 'Jeśli ta opcja jest włączona, gdy użytkownik Moodle połączony ze skonfigurowanym IdP wylogowuje się z Moodle, integracja wyśle żądanie do poniższego punktu końcowego wylogowania, próbując wylogować użytkownika także z IdP.<br/>
Pamiętaj, że w przypadku integracji z Microsoft Entra ID adres URL witryny Moodle ({$a}) musi zostać dodany jako identyfikator URI przekierowania w aplikacji Microsoft Entra ID utworzonej na potrzeby integracji Moodle i Microsoft 365.';
$string['cfg_logoutendpoint_key'] = 'Punkt końcowy wylogowania IdP';
$string['cfg_logoutendpoint_desc'] = 'Identyfikator URI punktu końcowego wylogowania używanego z Twojego IdP.';
$string['cfg_frontchannellogouturl_key'] = 'Adres URL wylogowania kanałem frontowym';
$string['cfg_frontchannellogouturl_desc'] = 'Jest to adres URL, który Twój IdP musi wywołać, gdy próbuje wylogować użytkowników z Moodle.<br/>
W przypadku Microsoft Entra ID / Microsoft identity platform to ustawienie nazywa się „Front-channel logout URL” i można je skonfigurować w aplikacji Microsoft Entra ID.';
$string['cfg_field_mapping_desc'] = 'Dane profilu użytkownika można mapować z IdP OpenID Connect do Moodle. Dostępne pola zdalne do zmapowania w dużym stopniu zależą od typu IdP.<br/>
<ul>
<li>Niektóre podstawowe pola profilu są dostępne w oświadczeniach tokenu dostępu i tokenu ID dla wszystkich typów IdP.</li>
<li>Jeśli skonfigurowano typ IdP Microsoft (v1.0 lub v2.0), dodatkowe dane profilu można udostępnić za pomocą wywołań Graph API, instalując i konfigurując <a href="https://moodle.org/plugins/local_o365">wtyczkę integracji z Microsoft 365 (local_o365)</a>.</li>
<li>Jeśli w wtyczce local_o365 włączono funkcję synchronizacji profili SDS, niektóre pola profilu mogą być synchronizowane z SDS do Moodle. Dzieje się tak tylko podczas uruchamiania zaplanowanego zadania „Synchronizuj z SDS” i nie ma to miejsca podczas uruchamiania zaplanowanego zadania „Synchronizuj użytkowników z usługi Microsoft Entra ID” ani podczas logowania użytkownika.</li>
</ul>

Oświadczenia dostępne w tokenach ID i tokenach dostępu różnią się w zależności od typu IdP, ale większość IdP pozwala w pewnym stopniu dostosować oświadczenia. Dokumentacja dotycząca IdP Microsoft jest dostępna pod poniższymi linkami:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Oświadczenia tokenu dostępu</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">Oświadczenia tokenu ID</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Konfiguracja oświadczeń opcjonalnych</a>: pamiętaj, że „Email” jest oświadczeniem opcjonalnym w typie IdP Microsoft Entra ID (v1.0).</li>
</ul>';

$string['cfg_cleanupoidctokens_key'] = 'Wyczyść tokeny OpenID Connect';
$string['cfg_cleanupoidctokens_desc'] = 'Jeśli użytkownicy mają problemy z logowaniem za pomocą konta Microsoft 365, spróbuj wyczyścić tokeny OpenID Connect. Spowoduje to usunięcie zbędnych i niekompletnych tokenów, które mogą powodować błędy. OSTRZEŻENIE: może to przerwać trwające logowania, więc najlepiej wykonać tę czynność w czasie przestoju.';
$string['settings_section_basic'] = 'Ustawienia podstawowe';
$string['settings_section_authentication'] = 'Uwierzytelnianie';
$string['settings_section_endpoints'] = 'Punkty końcowe';
$string['settings_section_other_params'] = 'Pozostałe parametry';
$string['settings_section_secret_expiry_notification'] = 'Powiadomienie o wygaśnięciu klucza tajnego';
$string['application_updated'] = 'Ustawienia aplikacji OpenID Connect zostały zaktualizowane.';
$string['application_updated_microsoft'] = 'Ustawienie aplikacji OpenID Connect zostało zaktualizowane.<br/>
<span class="warning" style="color: red;">Jeśli zaktualizowano ustawienia „Typ dostawcy tożsamości (IdP)” lub „Metoda uwierzytelniania klienta”, administrator Microsoft Entra ID będzie musiał ponownie <b>Udziel zgody administratora</b> i <b>Sprawdź konfigurację</b> na stronie konfiguracji integracji z Microsoft 365.</span>';
$string['application_updated_microsoft_notify'] = 'Ustawienie aplikacji OpenID Connect zostało zaktualizowane.<br/>
<span class="warning" style="color: red;">Jeśli zaktualizowano ustawienia „Typ dostawcy tożsamości (IdP)” lub „Metoda uwierzytelniania klienta”, administrator Microsoft Entra ID będzie musiał ponownie <b>Udziel zgody administratora</b> i <b>Sprawdź konfigurację</b> na <a href="{$a}">stronie konfiguracji integracji z Microsoft 365</a>.</span>';
$string['application_not_changed'] = 'Ustawienie aplikacji OpenID Connect nie zostało zmienione.';

$string['event_debug'] = 'Komunikat debugowania';

$string['task_cleanup_oidc_state_and_token'] = 'Wyczyść stan OIDC i nieprawidłowe tokeny';
$string['task_cleanup_oidc_sid'] = 'Wyczyść rekordy SID OIDC';

$string['errorauthdisconnectemptypassword'] = 'Hasło nie może być puste';
$string['errorauthdisconnectemptyusername'] = 'Pole nazwy użytkownika nie może być puste';
$string['errorauthdisconnectusernameexists'] = 'Ta nazwa użytkownika jest już zajęta. Wybierz inną nazwę.';
$string['errorauthdisconnectnewmethod'] = 'Użyj sposobu logowania';
$string['errorauthdisconnectinvalidmethod'] = 'Otrzymano nieprawidłowy sposób logowania.';
$string['errorauthdisconnectifmanual'] = 'W przypadku korzystania z ręcznego sposobu logowania wprowadź dane logowania poniżej.';
$string['errorauthgeneral'] = 'Wystąpił problem z logowaniem. Skontaktuj się z administratorem w celu uzyskania pomocy.';
$string['errorauthinvalididtoken'] = 'Otrzymano nieprawidłowy token identyfikatora.';
$string['errorauthloginfailednouser'] = 'Nieprawidłowe logowanie: zalogowano jako „{$a}”, ale w tej witrynie nie istnieje pasujące konto, a nowe konta nie mogą być tworzone automatycznie. Skontaktuj się z administratorem witryny w celu uzyskania pomocy. Jeśli masz więcej niż jedno konto, wybierz Kontynuuj, aby zalogować się na inne.';
$string['errorauthloginfaileddupemail'] = 'Nieprawidłowe logowanie: istniejące konto w tym Moodle ma taki sam adres e-mail jak konto, które próbujesz utworzyć, a ustawienie „Zezwalaj na konta z tym samym adresem e-mail” (allowaccountssameemail) jest wyłączone.';
$string['errorauthmfarequired'] = 'Microsoft wymaga uwierzytelniania wieloskładnikowego do zakończenia logowania, ale nie udało się go ukończyć. Spróbuj ponownie lub zaloguj się do Microsoft 365 w nowej sesji przeglądarki i zatwierdź monit uwierzytelniania wieloskładnikowego.';
$string['errorauthnoauthcode'] = 'Nie otrzymano kodu autoryzacji z serwera tożsamości. Więcej informacji może znajdować się w dziennikach błędów.';
$string['errorauthnocredsandendpoints'] = 'Skonfiguruj dane uwierzytelniające klienta OpenID Connect oraz punkty końcowe.';
$string['errorauthnoidtoken'] = 'Nie otrzymano tokenu identyfikatora OpenID Connect.';
$string['errorauthnoaccesstoken'] = 'Nie otrzymano tokenu dostępu.';
$string['errorauthunknownstate'] = 'Stan nieznany.';
$string['errorauthuseralreadyconnected'] = 'Połączono już z innym użytkownikiem wtyczki OpenID Connect.';
$string['errorauthuserconnectedtodifferent'] = 'Uwierzytelniony użytkownik wtyczki OpenID Connect jest już połączony z użytkownikiem platformy Moodle.';
$string['errorbadloginflow'] = 'Określono nieprawidłowy typ uwierzytelniania. Uwaga: jeżeli ten komunikat jest wyświetlany po niedawnej instalacji lub aktualizacji, należy wyczyścić pamięć podręczną platformy Moodle.';
$string['errorjwtbadpayload'] = 'Nie udało się odczytać ładunku tokenu JWT.';
$string['errorjwtcouldnotreadheader'] = 'Nie udało się odczytać nagłówka tokenu JWT';
$string['errorjwtempty'] = 'Otrzymano token JWT, który jest pusty lub nie jest ciągiem.';
$string['errorjwtinvalidheader'] = 'Nieprawidłowy nagłówek tokenu JWT';
$string['errorjwtmalformed'] = 'Otrzymano nieprawidłowo utworzony token JWT.';
$string['errorjwtunsupportedalg'] = 'Tokeny JWS Alg lub JWE nie są obsługiwane';
$string['erroroidcnotenabled'] = 'Wtyczka uwierzytelniania OpenID Connect nie jest włączona.';
$string['errornodisconnectionauthmethod'] = 'Nie można odłączyć, ponieważ nie ma włączonej wtyczki uwierzytelniania, na którą można by przejść (poprzedni sposób logowania użytkownika lub sposób logowania ręcznego).';
$string['erroroidcclientinvalidendpoint'] = 'Otrzymano nieprawidłowy adres URI punktu końcowego.';
$string['erroroidcclientnocreds'] = 'Ustaw dane uwierzytelniające klienta za pomocą setcreds';
$string['erroroidcclientnoauthendpoint'] = 'Nie ustawiono punktu końcowego autoryzacji. Ustaw przy użyciu $this->setendpoints';
$string['erroroidcclientnotokenendpoint'] = 'Nie ustawiono punktu końcowego tokenu. Ustaw przy użyciu $this->setendpoints';
$string['errorrestricted'] = 'Ta witryna ma ograniczenia dotyczące użytkowników, którzy mogą się logować za pomocą OpenID Connect. Te ograniczenia uniemożliwiają obecnie ukończenie tej próby logowania.';
$string['errorucpinvalidaction'] = 'Otrzymano nieprawidłowe działanie.';
$string['erroroidccall'] = 'Błąd w OpenID Connect. Więcej informacji można znaleźć w dziennikach.';
$string['erroroidccall_message'] = 'Błąd w OpenID Connect: {$a}';
$string['errorinvalidredirect_message'] = 'Adres URL, na który próbujesz przekierować, nie istnieje.';
$string['errorinvalidcertificatesource'] = 'Nieprawidłowe źródło certyfikatu';
$string['error_invalid_client_authentication_method'] = 'Nieprawidłowa metoda uwierzytelniania klienta';
$string['error_certificate_requires_identity_platform'] = 'Uwierzytelnianie certyfikatem wymaga typu IdP „Microsoft identity platform (v2.0)”.';
$string['error_empty_client_secret'] = 'Klucz tajny klienta nie może być pusty, gdy używana jest metoda uwierzytelniania „klucz tajny”';
$string['error_empty_client_private_key'] = 'Klucz prywatny certyfikatu klienta nie może być pusty, gdy używana jest metoda uwierzytelniania „certyfikat”';
$string['error_empty_client_cert'] = 'Klucz publiczny certyfikatu klienta nie może być pusty, gdy używana jest metoda uwierzytelniania „certyfikat”';
$string['error_empty_client_private_key_file'] = 'Plik klucza prywatnego certyfikatu klienta nie może być pusty, gdy używana jest metoda uwierzytelniania „certyfikat”';
$string['error_empty_client_cert_file'] = 'Plik klucza publicznego certyfikatu klienta nie może być pusty, gdy używana jest metoda uwierzytelniania „certyfikat”';
$string['error_endpoint_mismatch_auth_endpoint'] = 'Skonfigurowany punkt końcowy autoryzacji nie pasuje do skonfigurowanego typu IdP. Dla „Microsoft Entra ID (v1.0)” użyj punktu końcowego v1.0 (np. https://login.microsoftonline.com/organizations/oauth2/authorize). Dla „Microsoft identity platform (v2.0)” użyj punktu końcowego v2.0 (np. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize).';
$string['error_endpoint_mismatch_token_endpoint'] = 'Skonfigurowany punkt końcowy tokenu nie pasuje do skonfigurowanego typu IdP. Dla „Microsoft Entra ID (v1.0)” użyj punktu końcowego v1.0 (np. https://login.microsoftonline.com/organizations/oauth2/token). Dla „Microsoft identity platform (v2.0)” użyj punktu końcowego v2.0 (np. https://login.microsoftonline.com/organizations/oauth2/v2.0/token).';
$string['error_tenant_specific_endpoint_required'] = 'Gdy używany jest typ IdP „Microsoft identity platform (v2.0)” i metoda uwierzytelniania „Certyfikat”, wymagany jest punkt końcowy właściwy dla dzierżawcy (tzn. inny niż common/organizations/consumers).';
$string['error_empty_oidcresource'] = 'Zasób nie może być pusty, gdy używany jest Microsoft Entra ID (v1.0) lub inne typy IdP.';
$string['error_invalid_custom_claim'] = 'Nieprawidłowe nazwy oświadczeń niestandardowych: {$a}. Nazwy oświadczeń niestandardowych mogą zawierać tylko znaki alfanumeryczne, myślniki i podkreślenia oraz nie mogą być nazwą zarezerwowaną (np. standardowe oświadczenie JWT/OpenID Connect lub oświadczenie specyficzne dla Microsoft Entra ID albo Keycloak) ani istniejącą opcją mapowania pól.';
$string['error_masked_secret_not_changed'] = 'Wprowadź nową wartość lub odznacz pole „Zmień”, aby zachować bieżącą wartość.';
$string['auth_settings_validation_error'] = 'Wykryto nieprawidłowe ustawienia uwierzytelniania. Aby uwierzytelnianie działało poprawnie, należy rozwiązać następujące problemy z konfiguracją:';
$string['error_secretexpiryrecipients_invalid'] = 'Następujący odbiorcy powiadomień o wygaśnięciu klucza tajnego nie mają prawidłowych adresów e-mail: {$a}';
$string['errorupnchangeisnotsupported'] = 'Nazwa UPN Twojego konta Microsoft uległa zmianie. Skontaktuj się z administratorem, aby zaktualizować Twoje konto Moodle.';
$string['erroruserwithusernamealreadyexists'] = 'Wystąpił błąd podczas próby zmiany nazwy Twojego konta Moodle. Użytkownik Moodle z nową nazwą użytkownika już istnieje. Poproś administratora witryny o wcześniejsze rozwiązanie tego problemu.';
$string['error_no_response_available'] = 'Brak dostępnych odpowiedzi.';

$string['eventuserauthed'] = 'Zautoryzowano użytkownika przy użyciu wtyczki OpenID Connect';
$string['eventusercreated'] = 'Utworzono użytkownika we wtyczce OpenID Connect';
$string['eventuserconnected'] = 'Podłączono użytkownika do wtyczki OpenID Connect';
$string['eventuserloggedin'] = 'Zalogowano użytkownika za pomocą wtyczki OpenID Connect';
$string['eventuserdisconnected'] = 'Odłączono użytkownika od wtyczki OpenID Connect';
$string['eventuserrenameattempt'] = 'Wtyczka auth_oidc próbowała zmienić nazwę użytkownika';

$string['oidc:manageconnection'] = 'Zezwalaj na łączenie i odłączanie OpenID Connect';
$string['oidc:manageconnectionconnect'] = 'Zezwalaj na łączenie OpenID Connect';
$string['oidc:manageconnectiondisconnect'] = 'Zezwalaj na odłączanie OpenID Connect';

$string['privacy:metadata:auth_oidc'] = 'Uwierzytelnianie OpenID Connect';
$string['privacy:metadata:auth_oidc_prevlogin'] = 'Poprzednie sposoby logowania umożliwiające cofnięcie połączeń z Microsoft 365';
$string['privacy:metadata:auth_oidc_prevlogin:userid'] = 'Identyfikator użytkownika Moodle';
$string['privacy:metadata:auth_oidc_prevlogin:method'] = 'Poprzedni sposób logowania';
$string['privacy:metadata:auth_oidc_prevlogin:password'] = 'Poprzednie (zaszyfrowane) pole hasła użytkownika.';
$string['privacy:metadata:auth_oidc_token'] = 'Tokeny OpenID Connect';
$string['privacy:metadata:auth_oidc_token:oidcuniqid'] = 'Unikalny identyfikator użytkownika OIDC.';
$string['privacy:metadata:auth_oidc_token:username'] = 'Nazwa użytkownika Moodle';
$string['privacy:metadata:auth_oidc_token:userid'] = 'Identyfikator użytkownika Moodle';
$string['privacy:metadata:auth_oidc_token:oidcusername'] = 'Nazwa użytkownika OIDC';
$string['privacy:metadata:auth_oidc_token:useridentifier'] = 'Identyfikator użytkownika OIDC';
$string['privacy:metadata:auth_oidc_token:scope'] = 'Zakres tokenu';
$string['privacy:metadata:auth_oidc_token:tokenresource'] = 'Zasób tokenu';
$string['privacy:metadata:auth_oidc_token:authcode'] = 'Kod autoryzacji tokenu';
$string['privacy:metadata:auth_oidc_token:token'] = 'Token';
$string['privacy:metadata:auth_oidc_token:expiry'] = 'Wygaśnięcie tokenu';
$string['privacy:metadata:auth_oidc_token:refreshtoken'] = 'Token odświeżania';
$string['privacy:metadata:auth_oidc_token:idtoken'] = 'Token ID';
$string['privacy:metadata:auth_oidc_sid'] = 'Identyfikatory sesji IdP (sid) używane do znajdowania połączonych użytkowników Moodle, gdy SLO jest wyzwalane z IdP';
$string['privacy:metadata:auth_oidc_sid:userid'] = 'Identyfikator użytkownika Moodle';
$string['privacy:metadata:auth_oidc_sid:sid'] = 'Identyfikator sesji IdP (sid)';
$string['privacy:metadata:auth_oidc_sid:timecreated'] = 'Czas utworzenia mapowania';
$string['privacy:metadata:auth_oidc_sid:sessionid'] = 'Identyfikator sesji Moodle aktywnej w momencie utworzenia mapowania';
$string['privacy:metadata:auth_oidc_sid:iss'] = 'Wystawca (oświadczenie iss) tokenu id_token, na podstawie którego utworzono mapowanie';

// In the following strings, $a refers to a customizable name for the identity manager. For example, this could be
// "Microsoft 365", "OpenID Connect", etc.
$string['ucp_general_intro'] = 'Ta opcja umożliwia zarządzanie połączeniem z {$a}. Jeżeli jest włączona, użytkownik może korzystać z konta {$a} do logowania się do platformy Moodle zamiast używania oddzielnej nazwy użytkownika i hasła. Po połączeniu nie trzeba będzie pamiętać nazwy użytkownika ani hasła do platformy Moodle - wszystkie operacje logowania będą obsługiwane przez {$a}.';
$string['ucp_login_start'] = 'Używaj {$a} w celu logowania się do platformy Moodle';
$string['ucp_login_start_desc'] = 'Spowoduje to przełączenie konta na logowanie się do platformy Moodle przy użyciu {$a}. Po włączeniu tej opcji użytkownik będzie się logował przy użyciu danych logowania {$a} - bieżąca nazwa użytkownika i hasło do platformy Moodle nie będą działać. Można odłączyć konto w dowolnym momencie i powrócić do zwykłego sposobu logowania się.';
$string['ucp_login_stop'] = 'Przestań używać {$a} do logowania się do platformy Moodle';
$string['ucp_login_stop_desc'] = 'Obecnie używasz {$a}, aby logować się do platformy Moodle. Kliknięcie „Przestań używać {$a} do logowania się do platformy Moodle” spowoduje odłączenie konta na platformie Moodle od {$a}. Logowanie do platformy Moodle przy użyciu konta {$a} nie będzie już możliwe. Zostaniesz poproszony o utworzenie nazwy użytkownika i hasła, a od tego momentu będziesz mógł logować się do platformy Moodle bezpośrednio.';
$string['ucp_login_status'] = 'Logowanie przez {$a}:';
$string['ucp_status_enabled'] = 'Włączone';
$string['ucp_status_disabled'] = 'Wyłączone';
$string['ucp_disconnect_title'] = 'Odłączanie {$a}';
$string['ucp_disconnect_details'] = 'Spowoduje to odłączenie konta na platformie Moodle od {$a}. Konieczne będzie utworzenie nazwy użytkownika i hasła w celu zalogowania się do platformy Moodle.';
$string['ucp_title'] = 'Zarządzanie {$a}';
$string['ucp_o365accountconnected'] = 'To konto Microsoft 365 jest już połączone z innym kontem Moodle.';

// Clean up OIDC tokens.
$string['cleanup_oidc_tokens'] = 'Wyczyść tokeny OpenID Connect';
$string['unmatched'] = 'Niedopasowane';
$string['delete_token'] = 'Usuń token';
$string['mismatched'] = 'Niezgodne';
$string['na'] = 'brak';
$string['mismatched_details'] = 'Rekord tokenu zawiera nazwę użytkownika „{$a->tokenusername}”; dopasowany użytkownik Moodle ma nazwę użytkownika „{$a->moodleusername}”.';
$string['delete_token_and_reference'] = 'Usuń token i odwołanie';
$string['table_token_id'] = 'Identyfikator rekordu tokenu';
$string['table_oidc_username'] = 'Nazwa użytkownika OIDC';
$string['table_oidc_unique_identifier'] = 'Unikalny identyfikator OIDC';
$string['table_token_unique_id'] = 'Unikalny identyfikator OIDC';
$string['table_matching_status'] = 'Stan dopasowania';
$string['table_matching_details'] = 'Szczegóły';
$string['table_action'] = 'Akcja';
$string['token_deleted'] = 'Token został pomyślnie usunięty';
$string['no_token_to_cleanup'] = 'Nie ma tokenów OIDC do wyczyszczenia.';

$string['errorusermatched'] = 'Konto Microsoft 365 „{$a->entraidupn}” jest już dopasowane do użytkownika Moodle „{$a->username}”. Aby dokończyć łączenie, zaloguj się najpierw jako ten użytkownik Moodle i postępuj zgodnie z instrukcjami w bloku Microsoft.';

// User mapping options.
$string['update_oncreate_and_onlogin'] = 'Podczas tworzenia i przy każdym logowaniu';
$string['update_oncreate_and_onlogin_and_usersync'] = 'Podczas tworzenia, przy każdym logowaniu i przy każdym uruchomieniu zadania synchronizacji użytkowników';
$string['update_oncreate_and_usersync'] = 'Podczas tworzenia i przy każdym uruchomieniu zadania synchronizacji użytkowników';
$string['update_onlogin_and_usersync'] = 'Przy każdym logowaniu i przy każdym uruchomieniu zadania synchronizacji użytkowników';
$string['upgradeoidcuniqidtoolong'] = 'Nie można kontynuować aktualizacji: niektóre rekordy auth_oidc_token mają wartość oidcuniqid dłuższą niż 200 znaków, którą nowa długość kolumny ucięłaby. Usuń te rekordy tokenów i uruchom aktualizację ponownie.';

// Remote fields.
$string['settings_fieldmap_feild_not_mapped'] = '(niezmapowane)';
$string['settings_fieldmap_field_bindingusernameclaim'] = 'Powiązanie z oświadczeniem nazwy użytkownika (można mapować tylko podczas logowania)';
$string['settings_fieldmap_field_city'] = 'Miasto';
$string['settings_fieldmap_field_companyName'] = 'Nazwa firmy';
$string['settings_fieldmap_field_objectId'] = 'Identyfikator obiektu';
$string['settings_fieldmap_field_country'] = 'Kraj';
$string['settings_fieldmap_field_department'] = 'Dział';
$string['settings_fieldmap_field_displayName'] = 'Wyświetlana nazwa';
$string['settings_fieldmap_field_surname'] = 'Nazwisko';
$string['settings_fieldmap_field_faxNumber'] = 'Numer faksu';
$string['settings_fieldmap_field_telephoneNumber'] = 'Numer telefonu';
$string['settings_fieldmap_field_givenName'] = 'Imię';
$string['settings_fieldmap_field_jobTitle'] = 'Stanowisko';
$string['settings_fieldmap_field_mail'] = 'E-mail';
$string['settings_fieldmap_field_mobile'] = 'Telefon komórkowy';
$string['settings_fieldmap_field_postalCode'] = 'Kod pocztowy';
$string['settings_fieldmap_field_preferredLanguage'] = 'Język';
$string['settings_fieldmap_field_state'] = 'Województwo';
$string['settings_fieldmap_field_streetAddress'] = 'Adres';
$string['settings_fieldmap_field_userPrincipalName'] = 'Główna nazwa użytkownika';
$string['settings_fieldmap_field_employeeId'] = 'Identyfikator pracownika';
$string['settings_fieldmap_field_employeeType'] = 'Typ pracownika';
$string['settings_fieldmap_field_accountEnabled'] = 'Konto włączone';
$string['settings_fieldmap_field_businessPhones'] = 'Telefon służbowy';
$string['settings_fieldmap_field_mobilePhone'] = 'Telefon komórkowy';
$string['settings_fieldmap_field_officeLocation'] = 'Biuro';
$string['settings_fieldmap_field_preferredName'] = 'Preferowana nazwa';
$string['settings_fieldmap_field_manager'] = 'Imię i nazwisko przełożonego';
$string['settings_fieldmap_field_manager_email'] = 'E-mail przełożonego';
$string['settings_fieldmap_field_teams'] = 'Teams';
$string['settings_fieldmap_field_groups'] = 'Grupy';
$string['settings_fieldmap_field_roles'] = 'Role';
$string['settings_fieldmap_field_tokenclaim'] = '{$a} (oświadczenie tokenu)';
$string['settings_fieldmap_field_onPremisesSamAccountName'] = 'Nazwa konta SAM w środowisku lokalnym';
$string['settings_fieldmap_field_extensionattribute'] = 'Atrybut rozszerzenia {$a}';
$string['settings_fieldmap_field_sds_school_id'] = 'Identyfikator szkoły SDS ({$a})';
$string['settings_fieldmap_field_sds_school_name'] = 'Nazwa szkoły SDS ({$a})';
$string['settings_fieldmap_field_sds_school_role'] = 'Rola w szkole SDS („Student” lub „Teacher”)';
$string['settings_fieldmap_field_sds_student_externalId'] = 'Zewnętrzny identyfikator ucznia SDS';
$string['settings_fieldmap_field_sds_student_birthDate'] = 'Data urodzenia ucznia SDS';
$string['settings_fieldmap_field_sds_student_grade'] = 'Klasa ucznia SDS';
$string['settings_fieldmap_field_sds_student_graduationYear'] = 'Rok ukończenia szkoły przez ucznia SDS';
$string['settings_fieldmap_field_sds_student_studentNumber'] = 'Numer ucznia SDS';
$string['settings_fieldmap_field_sds_teacher_externalId'] = 'Zewnętrzny identyfikator nauczyciela SDS';
$string['settings_fieldmap_field_sds_teacher_teacherNumber'] = 'Numer nauczyciela SDS';

// Binding username claim options.
$string['binding_username_claim_warning'] = 'Jest to funkcja zaawansowana. W większości przypadków powinna pozostać ustawiona na „Wybierz automatycznie”; nieprawidłowa konfiguracja może wpłynąć na rekordy użytkowników i zakłócić logowanie jednokrotne (SSO).';
$string['binding_username_auto'] = 'Wybierz automatycznie';
$string['binding_username_custom'] = 'Niestandardowe';
$string['bindingusernameclaim'] = 'Powiązanie z oświadczeniem nazwy użytkownika';
$string['customclaimname'] = 'Nazwa oświadczenia niestandardowego';
$string['customclaimname_description'] = 'To pole jest używane tylko wtedy, gdy ustawienie <b>powiązania z oświadczeniem nazwy użytkownika</b> ma wartość <b>Niestandardowe</b>.';
$string['binding_username_claim_tool_link_desc'] = 'Aby zaktualizować powiązanie z oświadczeniem nazwy użytkownika dla istniejących użytkowników, użyj <a href="{$a}">Narzędzia zmiany powiązania z oświadczeniem nazwy użytkownika</a>.';
$string['cleanup_oidc_tokens_link_desc'] = 'Aby wyczyścić nieaktualne tokeny OpenID Connect, użyj narzędzia <a href="{$a}">Wyczyść tokeny OpenID Connect</a>.';
$string['clear_user_tokens_link_desc'] = 'Aby usunąć zapisane tokeny wszystkich użytkowników lub wybranych użytkowników, użyj narzędzia <a href="{$a}">Wyczyść tokeny użytkowników</a>.';
$string['clear_user_tokens'] = 'Wyczyść tokeny użytkowników';
$string['clear_user_tokens_desc'] = 'Usuwa tokeny OpenID Connect i Microsoft 365 zapisane dla użytkowników. Użytkownicy, których to dotyczy, otrzymają nowe tokeny przy następnym logowaniu za pomocą OpenID Connect lub połączeniu z Microsoft 365. Ich powiązania z kontami Microsoft 365 zostaną zachowane. OSTRZEŻENIE: może to przerwać trwające logowania, więc najlepiej wykonać tę czynność w czasie przestoju.';
$string['clear_user_tokens_scope_selected'] = 'Wybrani użytkownicy';
$string['clear_user_tokens_scope_all'] = 'Wszyscy użytkownicy';
$string['clear_user_tokens_users'] = 'Użytkownicy';
$string['clear_user_tokens_submit'] = 'Wyczyść tokeny';
$string['clear_user_tokens_no_name'] = '(brak nazwy)';
$string['clear_user_tokens_no_user_selected'] = 'Wybierz co najmniej jednego użytkownika.';
$string['clear_user_tokens_confirm_all'] = 'Czy na pewno chcesz wyczyścić tokeny wszystkich użytkowników? Liczba użytkowników, którzy obecnie mają tokeny: {$a}.';
$string['clear_user_tokens_confirm_selected'] = 'Czy na pewno chcesz wyczyścić tokeny wybranych użytkowników? Liczba wybranych użytkowników, którzy obecnie mają tokeny: {$a}.';
$string['clear_user_tokens_success'] = 'Liczba wyczyszczonych rekordów tokenów: {$a}.';
$string['binding_username_claim_help_ms_no_user_sync'] = 'Opcje dla IdP Microsoft bez włączonej funkcji synchronizacji użytkowników obejmują:
<ul>
<li><b>Wybierz automatycznie</b>: używa bieżącej logiki, określając token na podstawie typu IdP i wracając do <b>sub</b>, jeśli nie znaleziono oświadczenia.</li>
<li><b>preferred_username</b>: domyślne dla typu IdP Microsoft identity platform (v2.0). <span class="not_support_user_sync">Nie obsługuje synchronizacji użytkowników.</span></li>
<li><b>email</b>: rozwiązanie zastępcze dla Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: domyślne dla typu Microsoft Entra ID (v1.0) i innych typów IdP.</li>
<li><b>unique_name</b>: rozwiązanie zastępcze dla Microsoft Entra ID (v1.0) i innych typów IdP. <span class="not_support_user_sync">Nie obsługuje synchronizacji użytkowników.</span></li>
<li><b>oid</b>: rozwiązanie zastępcze, gdy nie ma innych oświadczeń. Występuje tylko w IdP Microsoft.</li>
<li><b>sub</b>: rozwiązanie zastępcze, gdy nie ma innych oświadczeń. <span class="not_support_user_sync">Nie obsługuje synchronizacji użytkowników.</span></li>
<li><b>samaccountname</b>: oświadczenie niestandardowe.</li>
<li><b>Niestandardowe</b>: umożliwia administratorowi witryny wprowadzenie wartości niestandardowej. <span class="not_support_user_sync">Nie obsługuje synchronizacji użytkowników.</span></li>
</ul>
Pamiętaj, że niektóre opcje nie obsługują synchronizacji użytkowników.';
$string['binding_username_claim_help_ms_with_user_sync'] = 'Opcje dla IdP Microsoft z włączoną funkcją synchronizacji użytkowników obejmują:
<ul>
<li><b>Wybierz automatycznie</b>: używa bieżącej logiki, określając token na podstawie typu IdP i wracając do <b>sub</b>, jeśli nie znaleziono oświadczenia.</li>
<li><b>email</b>: rozwiązanie zastępcze dla Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: domyślne dla typu Microsoft Entra ID (v1.0) i innych typów IdP.</li>
<li><b>oid</b>: rozwiązanie zastępcze, gdy nie ma innych oświadczeń. Występuje tylko w IdP Microsoft.</li>
<li><b>samaccountname</b>: oświadczenie niestandardowe.</li>
</ul>';
$string['binding_username_claim_help_non_ms'] = 'Opcje dla IdP innych niż Microsoft obejmują:
<ul>
<li><b>Wybierz automatycznie</b>: używa bieżącej logiki, określając token na podstawie typu IdP i wracając do <b>sub</b>, jeśli nie znaleziono oświadczenia.</li>
<li><b>preferred_username</b></li>
<li><b>email</b></li>
<li><b>unique_name</b></li>
<li><b>sub</b></li>
<li><b>samaccountname</b></li>
<li><b>custom</b>: oświadczenie niestandardowe.</li>
</ul>';
$string['warning_binding_username_claim_custom_unsupported'] = 'Ustawienie „Powiązanie z oświadczeniem nazwy użytkownika” ma obecnie wartość „Niestandardowe”, która nie jest obsługiwana dla skonfigurowanego typu IdP z włączoną synchronizacją użytkowników. Sprawdź ustawienia <a href="{$a}">Powiązania z oświadczeniem nazwy użytkownika</a>.';
$string['examplecsv'] = 'Przykładowy plik do przesłania';
$string['usernamefile'] = 'Plik';
$string['csvdelimiter'] = 'Separator CSV';
$string['encoding'] = 'Kodowanie';
$string['rowpreviewnum'] = 'Wiersze podglądu';
$string['upload_usernames'] = 'Zaktualizuj powiązane nazwy użytkowników';
$string['update_stats_users_updated'] = 'Liczba zaktualizowanych użytkowników: {$a}';
$string['update_stats_users_errors'] = 'Liczba użytkowników, u których wystąpiły błędy: {$a}';
$string['update_error_incomplete_line'] = 'Wiersz nie zawiera wymaganych pól.';
$string['update_error_user_not_found'] = 'Nie znaleziono użytkownika pasującego do nazwy użytkownika. Zostanie podjęta próba zaktualizowania ręcznie dopasowanego użytkownika.';
$string['update_error_user_not_oidc'] = 'Użytkownik nie korzysta z metody uwierzytelniania OpenID Connect. Zostanie podjęta próba zaktualizowania ręcznie dopasowanego użytkownika.';
$string['update_error_invalid_new_username'] = 'Nowa nazwa użytkownika jest nieprawidłowa.';
$string['update_error_user_update_failed'] = 'Nie udało się zaktualizować użytkownika.';
$string['update_warning_email_match'] = 'Adres e-mail pasuje do istniejącego użytkownika.';
$string['update_success_username'] = 'Nazwa użytkownika została zaktualizowana.';
$string['update_success_token'] = 'Token został zaktualizowany.';
$string['update_success_o365'] = 'Rekord połączenia z Microsoft 365 został zaktualizowany.';
$string['update_error_nothing_updated'] = 'Nic nie zostało zaktualizowane.';
$string['error_invalid_upload_file'] = 'Nieprawidłowy plik do przesłania.';
$string['csvline'] = 'Wiersz CSV';
$string['change_binding_username_claim_tool_description'] = '<p class="warning_header">Jest to funkcja zaawansowana. Nieprawidłowe użycie może wpłynąć na rekordy użytkowników i zakłócić logowanie jednokrotne (SSO).</p>
<p>To narzędzie umożliwia administratorom witryny zbiorczą aktualizację następujących rekordów:</p>
<ul>
<li>nazw użytkowników kont Moodle,</li>
<li>powiązanych nazw użytkowników w zapisanych tokenach ID OpenID Connect,</li>
<li>rekordów połączeń kont Moodle i Microsoft.</li>
</ul>
<p>Należy go używać tylko podczas zmiany ustawień <b>Powiązania z oświadczeniem nazwy użytkownika</b>.</p>
<p>Narzędzie przyjmuje prosty plik CSV z dwiema kolumnami:</p>
<ul>
<li><b><span class="auth_oidc_code">username</span></b>: bieżąca nazwa użytkownika aktualizowanego konta Moodle, lub, jeśli bieżący użytkownik jest dopasowany ręcznie, bieżąca wartość oświadczenia powiązania.</li>
<li><b><span class="auth_oidc_code">new_username</span></b>: wartość nowego oświadczenia tokenu, które ma być używane jako powiązane oświadczenie nazwy użytkownika, z uwzględnieniem wielkości liter. Jeśli użytkownik jest dopasowany automatycznie i korzysta z typu uwierzytelniania OpenID Connect, jako nazwa użytkownika Moodle zostanie użyta ta wartość zapisana małymi literami.</li>
</ul>
<p>Po przesłaniu pliku narzędzie wykona następujące czynności:</p>
<ol>
<li>Znajdzie istniejącego użytkownika Moodle z podaną wartością <span class="auth_oidc_code">username</span> jako nazwą użytkownika lub adresem e-mail, korzystającego z metody uwierzytelniania OpenID Connect, a jeśli taki zostanie znaleziony, zmieni nazwę użytkownika na wartość <span class="auth_oidc_code">new_username</span> zapisaną małymi literami.</li>
<li>Zaktualizuje rekord tokenu OpenID Connect.
<ul>
<li>Jeśli w kroku 1 powyżej znaleziono użytkownika, znajdzie rekord tokenu tego użytkownika w tabeli <span class="auth_oidc_code">auth_oidc_token</span> i zaktualizuje kolumnę <span class="auth_oidc_code">username</span> na wartość <span class="auth_oidc_code">new_username</span> zapisaną małymi literami, a kolumnę <span class="auth_oidc_code">oidcusername</span> na wartość identyczną z <span class="auth_oidc_code">new_username</span>.</li>
<li>Jeśli powyżej nie znaleziono rekordu, spróbuje znaleźć rekord w tabeli <span class="auth_oidc_code">auth_oidc_token</span>, w którym kolumna <span class="auth_oidc_code">oidcusername</span> odpowiada starej wartości <span class="auth_oidc_code">username</span>, i zaktualizuje go na <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
<li>Jeśli zainstalowana jest wtyczka <span class="auth_oidc_code">local_o365</span>, zaktualizuje rekord połączenia użytkownika.
<ul>
<li>Jeśli w kroku 1 powyżej znaleziono użytkownika, znajdzie rekord połączenia tego użytkownika w tabeli <span class="auth_oidc_code">local_o365_objects</span> i zaktualizuje kolumnę <span class="auth_oidc_code">o365name</span> na wartość identyczną z <span class="auth_oidc_code">new_username</span>.</li>
<li>Jeśli w kroku 1 nie znaleziono użytkownika, spróbuje znaleźć rekord użytkownika w tabeli <span class="auth_oidc_code">local_o365_objects</span>, w którym kolumna <span class="auth_oidc_code">o365name</span> odpowiada wartości <span class="auth_oidc_code">username</span>, i zaktualizuje go na wartość <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
</ol>
<p>Poniższy przykładowy plik zmieniłby powiązane oświadczenie nazwy użytkownika z <span class="auth_oidc_code">upn</span> lub <span class="auth_oidc_code">email</span> na <span class="auth_oidc_code">oid</span>.</p>';
$string['change_binding_username_claim_tool_result'] = 'Wyniki aktualizacji';
$string['update_username_results'] = 'Wyniki aktualizacji nazw użytkowników';
$string['new_username'] = 'Nowa nazwa użytkownika';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
