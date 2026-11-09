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
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Repozytorium Microsoft 365 - identyfikatory ujednoliconych folderów';
$string['cachedef_unifiedgroupfolderids'] = 'Repozytorium Microsoft 365 - identyfikatory ujednoliconych folderów grup';
$string['configplugin'] = 'Skonfiguruj repozytorium Microsoft 365';
$string['controlledsharelinkdesc'] = 'Udostępniona kopia (tylko dla członków organizacji)';
$string['copiedfile'] = 'Kopia pliku';
$string['defaultgroupsfolder'] = 'Pliki kursu';
$string['directlinkdesc'] = 'Bezpośredni link (istniejące uprawnienia)';
$string['enableanonymousshare'] = 'Włącz opcję „{$a}”';
$string['enableanonymousshare_help'] = 'Po zaznaczeniu użytkownicy mogą utworzyć kopię pliku i udostępnić ją wszystkim w organizacji. Kopia jest przechowywana w OneDrive użytkownika i udostępniana wszystkim członkom organizacji.

**Jak to działa:**
* Tworzona jest kopia wybranego pliku z przyrostkiem „ - Shared”.
* Kopia jest zapisywana w OneDrive użytkownika (nie w oryginalnej lokalizacji).
* Dla kopii tworzony jest link udostępniania w zakresie organizacji.
* Oryginalny plik pozostaje niezmieniony, z dotychczasowymi uprawnieniami.

**Kontrola dostępu:**
* Dostęp do pliku mają tylko członkowie Twojej organizacji Microsoft 365.
* Każdy w organizacji, kto ma link, może WYŚWIETLIĆ plik.
* Użytkownicy zewnętrzni i anonimowi NIE mają dostępu do pliku.
* Link nie wygasa automatycznie.
* Właściciel pliku może zarządzać udostępnianiem lub je cofnąć w swoim OneDrive.

**Kiedy używać:**
* Chcesz udostępnić plik wszystkim członkom organizacji.
* Chcesz chronić oryginalny plik przed przypadkową zmianą.
* Istotna jest ilość miejsca w Moodle.
* Zawartość pliku jest odpowiednia do udostępnienia w całej organizacji.

**Ważne uwagi:**
* Kopiowanie dużych plików może potrwać kilka sekund.
* Użytkownicy powinni upewnić się, że zawartość pliku jest odpowiednia do udostępnienia w całej organizacji.
* Skopiowany plik pojawi się w OneDrive użytkownika z przyrostkiem „ - Shared”.
* Zmiany wprowadzone w oryginalnym pliku NIE będą widoczne w udostępnionej kopii, i odwrotnie.

**Ta opcja jest domyślnie wyłączona ze względu na ograniczenia wyświetlania i możliwe nieporozumienia. Zaznacz to pole tylko wtedy, gdy chcesz zezwolić użytkownikom na tworzenie kopii udostępnianych w organizacji.**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>Uwaga:</strong> Przy użyciu opcji „{$a}” tworzona jest kopia oryginalnego pliku i udostępniana wszystkim członkom organizacji. Oryginalny plik pozostaje niezmieniony. Użytkownicy powinni upewnić się, że zawartość pliku jest odpowiednia do dostępu w całej organizacji.
<br><br><strong>Ograniczenia wyświetlania:</strong> Pliki udostępnione za pomocą tej opcji mają ograniczenia zależne od typu pliku i opcji wyświetlania używanej w zasobach. Zachowanie jest następujące:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Opcja wyświetlania</th>
<th>Obrazy</th>
<th>Pliki (np. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatycznie</strong></td>
<td style="background-color: #ffdddd;">Nie działa - nic nie jest wyświetlane, połączenie zablokowane</td>
<td>Działa - przekierowanie do OneDrive</td>
</tr>
<tr>
<td><strong>Osadzone</strong></td>
<td>Działa - obraz jest osadzony</td>
<td style="background-color: #ffdddd;">Nie działa - ramka iframe wyświetla błąd „refused to connect”</td>
</tr>
<tr>
<td><strong>Wymuś pobieranie</strong></td>
<td colspan="2">Działa - przekierowanie do OneDrive</td>
</tr>
<tr>
<td><strong>Otwórz</strong></td>
<td colspan="2">Działa - przekierowanie do OneDrive</td>
</tr>
<tr>
<td><strong>W wyskakującym oknie</strong></td>
<td colspan="2">Działa - otwarcie w oknie podręcznym</td>
</tr>
</tbody>
</table>
Aby zapewnić najlepszą zgodność ze wszystkimi opcjami wyświetlania, rozważ skopiowanie pliku do Moodle.</div>';
$string['enablecoursegroup'] = 'Włącz folder Grupy (Kursy) w selektorze plików';
$string['enabledirectlink'] = 'Włącz opcję „{$a}”';
$string['enabledirectlink_help'] = 'Po zaznaczeniu użytkownicy mogą dodać bezpośredni link do pliku w swoim OneDrive zamiast kopiować go do Moodle. Plik pozostaje w OneDrive, a Moodle przechowuje tylko link odwołujący się do niego.

**Ważne kwestie dotyczące kontroli dostępu:**
* Istniejące uprawnienia pliku w OneDrive NIE są zmieniane.
* Użytkownicy otwierający link muszą mieć odpowiednie uprawnienia w OneDrive, aby wyświetlić plik.
* Użytkownik dodający link odpowiada za zapewnienie odpowiednich uprawnień dostępu.
* Jeśli uprawnienia w OneDrive nie są ustawione poprawnie, inni użytkownicy mogą nie mieć dostępu do pliku.

**Kiedy używać tej opcji:**
* Pliki są już udostępnione zamierzonym odbiorcom w Microsoft 365.
* Chcesz zachować jedno źródło prawdy w OneDrive.
* Istotna jest ilość miejsca w Moodle.
* Zmiany w pliku w OneDrive powinny być widoczne w Moodle.

**Ta opcja jest domyślnie wyłączona ze względu na ograniczenia wyświetlania i złożoność kontroli dostępu. Zaznacz to pole tylko wtedy, gdy chcesz zezwolić użytkownikom na linkowanie plików bezpośrednio z OneDrive.**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>Uwaga:</strong> Przy użyciu opcji „{$a}” nie są wprowadzane żadne zmiany ustawień udostępniania pliku w OneDrive. Użytkownicy dodający plik muszą upewnić się, że uprawnienia do pliku w OneDrive są ustawione poprawnie.
<br><br><strong>Ograniczenia wyświetlania:</strong> Pliki połączone za pomocą tej opcji mają ograniczenia zależne od typu pliku i opcji wyświetlania używanej w zasobach. Zachowanie jest następujące:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Opcja wyświetlania</th>
<th>Obrazy</th>
<th>Pliki (np. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatycznie</strong></td>
<td style="background-color: #ffdddd;">Nie działa - nic nie jest wyświetlane, połączenie zablokowane</td>
<td>Przekierowanie do OneDrive; działa, jeśli użytkownik ma uprawnienia dostępu do pliku w OneDrive, w przeciwnym razie wyświetlana jest strona odmowy dostępu</td>
</tr>
<tr>
<td><strong>Osadzone</strong></td>
<td style="background-color: #ffdddd;">Nie działa - nic nie jest wyświetlane, połączenie zablokowane</td>
<td style="background-color: #ffdddd;">Nie działa - w osadzonej ramce iframe wyświetlany jest błąd „refused to connect”</td>
</tr>
<tr>
<td><strong>Wymuś pobieranie</strong></td>
<td colspan="2">Przekierowanie do OneDrive; działa, jeśli użytkownik ma uprawnienia dostępu do pliku w OneDrive, w przeciwnym razie wyświetlana jest strona odmowy dostępu</td>
</tr>
<tr>
<td><strong>Otwórz</strong></td>
<td colspan="2">Przekierowanie do OneDrive; działa, jeśli użytkownik ma uprawnienia dostępu do pliku w OneDrive, w przeciwnym razie wyświetlana jest strona odmowy dostępu</td>
</tr>
<tr>
<td><strong>W wyskakującym oknie</strong></td>
<td colspan="2">Otwarcie w oknie podręcznym; działa, jeśli użytkownik ma uprawnienia dostępu do pliku w OneDrive, w przeciwnym razie wyświetlana jest strona odmowy dostępu</td>
</tr>
</tbody>
</table>
Aby zapewnić najlepszą zgodność, rozważ skopiowanie pliku do Moodle zamiast używania bezpośredniego linku.</div>';
$string['enableinternal'] = 'Włącz opcję „{$a}”';
$string['enableinternal_help'] = 'Po zaznaczeniu (ustawienie domyślne) użytkownicy mogą skopiować plik z OneDrive do Moodle. Odznacz tę opcję i włącz poniżej opcje „Link do pliku” i/lub „Utwórz łącze z kontrolą dostępu do pliku”, aby wymusić na użytkownikach linkowanie plików.

Co najmniej jedna z trzech opcji linkowania plików musi być włączona.';
$string['enableonedrivegroup'] = 'Włącz folder Mój OneDrive w selektorze plików';
$string['enabletrendinggroup'] = 'Włącz folder Popularne pliki wokół mnie w selektorze plików';

$string['errorauthoidcnotconfig'] = 'Skonfiguruj wtyczkę uwierzytelniania OpenID Connect przed próbą użycia repozytorium Microsoft 365.';
$string['errorbadclienttype'] = 'Nieprawidłowy typ klienta.';
$string['errorbadpath'] = 'Nieprawidłowa ścieżka';
$string['errorencodingreference'] = 'Nie udało się zakodować odwołania do pliku';
$string['errornofilelinkoption'] = 'Co najmniej jedna opcja linkowania plików musi być włączona.';
$string['erroro365required'] = 'Ten plik jest obecnie dostępny tylko dla użytkowników Microsoft 365.';
$string['errorwhiledownload'] = 'Wystąpił błąd podczas pobierania pliku';
$string['errorwhilesharing'] = 'Wystąpił błąd podczas tworzenia linku do udostępniania';

$string['file'] = 'Plik';
$string['filelinkingheader'] = 'Opcje linkowania plików';
$string['filereferencewarning'] = 'Nie są wprowadzane żadne zmiany w udostępnianiu pliku w OneDrive. Ten link mogą otworzyć tylko osoby, które mają już dostęp do pliku w OneDrive.';
$string['groups'] = 'Grupy (Kursy)';
$string['invalidfilereference'] = 'Nieprawidłowe lub błędnie sformułowane odwołanie do pliku';
$string['myfiles'] = 'Mój OneDrive';
$string['notconfigured'] = '<p class="error">Aby korzystać z tej wtyczki, musisz najpierw skonfigurować <a href="{$a}/admin/settings.php?section=local_o365">wtyczki Microsoft 365</a></p>';
$string['office365:view'] = 'Wyświetl repozytorium Microsoft 365';
$string['pluginname'] = 'Microsoft 365';
$string['privacy:metadata'] = 'Ta wtyczka komunikuje się z interfejsem Microsoft Graph API (OneDrive) w imieniu bieżącego użytkownika. Wszystkie przesłane pliki zostaną wysłane na zdalny serwer.';
$string['trendingaround'] = 'Popularne pliki wokół mnie';
$string['upload'] = 'Prześlij nowy plik';
