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
 * Czech language strings.
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Úložiště Microsoft 365 – jednotná ID složek';
$string['cachedef_unifiedgroupfolderids'] = 'Úložiště Microsoft 365 – jednotná ID složek pro skupiny';
$string['configplugin'] = 'Konfigurovat úložiště Microsoft 365';
$string['controlledsharelinkdesc'] = 'Sdílená kopie (pouze pro členy organizace)';
$string['copiedfile'] = 'Kopie souboru';
$string['defaultgroupsfolder'] = 'Soubory kurzu';
$string['directlinkdesc'] = 'Přímý odkaz (stávající oprávnění)';
$string['enableanonymousshare'] = 'Povolit možnost „{$a}“';
$string['enableanonymousshare_help'] = 'Pokud je zaškrtnuto, mohou uživatelé vytvořit kopii souboru a sdílet ji se všemi v organizaci. Kopie se uloží na OneDrive uživatele a sdílí se se všemi členy organizace.

**Jak to funguje:**
* Vytvoří se kopie vybraného souboru s příponou „ - Shared“.
* Kopie se uloží na OneDrive uživatele (ne do původního umístění).
* Pro kopii se vytvoří odkaz pro sdílení v rámci organizace.
* Původní soubor zůstane beze změny se svými stávajícími oprávněními.

**Řízení přístupu:**
* K souboru mají přístup pouze členové vaší organizace Microsoft 365.
* Kdokoli v organizaci, kdo má odkaz, může soubor ZOBRAZIT.
* Externí a anonymní uživatelé k souboru přístup NEMAJÍ.
* Platnost odkazu automaticky nevyprší.
* Vlastník souboru může sdílení spravovat nebo zrušit na svém OneDrivu.

**Kdy použít:**
* Chcete sdílet soubor se všemi členy organizace.
* Chcete chránit původní soubor před nechtěnými změnami.
* Úložný prostor v Moodlu je omezený.
* Obsah souboru je vhodný pro přístup v rámci celé organizace.

**Důležité poznámky:**
* U velkých souborů může kopírování trvat několik sekund.
* Uživatelé by se měli ujistit, že obsah souboru je vhodný ke sdílení v rámci celé organizace.
* Zkopírovaný soubor se na OneDrivu uživatele zobrazí s příponou „ - Shared“.
* Změny provedené v původním souboru se NEPROJEVÍ ve sdílené kopii a naopak.

**Tato možnost je ve výchozím nastavení zakázána kvůli omezením zobrazení a možným nejasnostem. Zaškrtněte toto políčko pouze tehdy, pokud chcete uživatelům povolit vytváření kopií sdílených v rámci organizace.**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>Poznámka:</strong> Při použití možnosti „{$a}“ se vytvoří kopie původního souboru, která se sdílí se všemi členy organizace. Původní soubor zůstane beze změny. Uživatelé by se měli ujistit, že obsah souboru je vhodný pro přístup v rámci celé organizace.
<br><br><strong>Omezení zobrazení:</strong> Soubory sdílené pomocí této možnosti mají omezení v závislosti na typu souboru a možnosti zobrazení použité ve zdrojích. Chování se liší takto:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Možnost zobrazení</th>
<th>Obrázky</th>
<th>Soubory (např. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automaticky</strong></td>
<td style="background-color: #ffdddd;">Nefunguje – nic se nezobrazí, připojení je zablokováno</td>
<td>Funguje – přesměrování na OneDrive</td>
</tr>
<tr>
<td><strong>Vsadit do stránky</strong></td>
<td>Funguje – obrázek je vložen</td>
<td style="background-color: #ffdddd;">Nefunguje – v iframe se zobrazí chyba „odmítl připojení“</td>
</tr>
<tr>
<td><strong>Vynutit stažení</strong></td>
<td colspan="2">Funguje – přesměrování na OneDrive</td>
</tr>
<tr>
<td><strong>Otevřít</strong></td>
<td colspan="2">Funguje – přesměrování na OneDrive</td>
</tr>
<tr>
<td><strong>Pop-up okno</strong></td>
<td colspan="2">Funguje – otevře se ve vyskakovacím okně</td>
</tr>
</tbody>
</table>
Pro nejlepší kompatibilitu se všemi možnostmi zobrazení zvažte raději zkopírování souboru do Moodlu.</div>';
$string['enablecoursegroup'] = 'Povolit složku Skupiny (kurzy) ve výběru souborů';
$string['enabledirectlink'] = 'Povolit možnost „{$a}“';
$string['enabledirectlink_help'] = 'Pokud je zaškrtnuto, mohou uživatelé místo zkopírování souboru do Moodlu přidat přímý odkaz na soubor na svém OneDrivu. Soubor zůstane na OneDrivu a Moodle ukládá pouze odkaz na něj.

**Důležité aspekty řízení přístupu:**
* Stávající oprávnění souboru na OneDrivu se NEMĚNÍ.
* Uživatelé, kteří odkaz otevírají, musí mít na OneDrivu příslušná oprávnění k zobrazení souboru.
* Za nastavení správných přístupových oprávnění odpovídá uživatel, který odkaz přidává.
* Pokud oprávnění na OneDrivu nejsou nastavena správně, ostatní uživatelé nemusí mít k souboru přístup.

**Kdy tuto možnost použít:**
* Soubory jsou již v Microsoft 365 sdíleny se zamýšleným publikem.
* Chcete zachovat jediný zdroj pravdy na OneDrivu.
* Úložný prostor v Moodlu je omezený.
* Úpravy souboru na OneDrivu se mají projevit v Moodlu.

**Tato možnost je ve výchozím nastavení zakázána kvůli omezením zobrazení a složitosti řízení přístupu. Zaškrtněte toto políčko pouze tehdy, pokud chcete uživatelům povolit propojování souborů přímo z OneDrivu.**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>Poznámka:</strong> Při použití možnosti „{$a}“ se u souboru na OneDrivu nemění žádná nastavení sdílení. Uživatelé, kteří soubor přidávají, musí zajistit, aby byla oprávnění souboru na OneDrivu nastavena správně.
<br><br><strong>Omezení zobrazení:</strong> Soubory propojené pomocí této možnosti mají omezení v závislosti na typu souboru a možnosti zobrazení použité ve zdrojích. Chování se liší takto:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Možnost zobrazení</th>
<th>Obrázky</th>
<th>Soubory (např. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automaticky</strong></td>
<td style="background-color: #ffdddd;">Nefunguje – nic se nezobrazí, připojení je zablokováno</td>
<td>Přesměrování na OneDrive; funguje, pokud má uživatel oprávnění k přístupu k souboru na OneDrivu, jinak se zobrazí stránka s odepřeným přístupem</td>
</tr>
<tr>
<td><strong>Vsadit do stránky</strong></td>
<td style="background-color: #ffdddd;">Nefunguje – nic se nezobrazí, připojení je zablokováno</td>
<td style="background-color: #ffdddd;">Nefunguje – ve vloženém iframe se zobrazí chyba odmítnutí připojení</td>
</tr>
<tr>
<td><strong>Vynutit stažení</strong></td>
<td colspan="2">Přesměrování na OneDrive; funguje, pokud má uživatel oprávnění k přístupu k souboru na OneDrivu, jinak se zobrazí stránka s odepřeným přístupem</td>
</tr>
<tr>
<td><strong>Otevřít</strong></td>
<td colspan="2">Přesměrování na OneDrive; funguje, pokud má uživatel oprávnění k přístupu k souboru na OneDrivu, jinak se zobrazí stránka s odepřeným přístupem</td>
</tr>
<tr>
<td><strong>Pop-up okno</strong></td>
<td colspan="2">Otevře se ve vyskakovacím okně; funguje, pokud má uživatel oprávnění k přístupu k souboru na OneDrivu, jinak se zobrazí stránka s odepřeným přístupem</td>
</tr>
</tbody>
</table>
Pro nejlepší kompatibilitu zvažte místo přímého odkazu raději zkopírování souboru do Moodlu.</div>';
$string['enableinternal'] = 'Povolit možnost „{$a}“';
$string['enableinternal_help'] = 'Pokud je zaškrtnuto (výchozí stav), mohou uživatelé zkopírovat soubor z OneDrivu do Moodlu. Chcete-li uživatele přimět, aby místo toho na soubory odkazovali, zrušte zaškrtnutí a povolte níže možnosti „Odkaz na soubor“ a/nebo „Vytvořte přístupový odkaz k souboru“.

Alespoň jedna ze tří možností propojení souborů musí být povolena.';
$string['enableonedrivegroup'] = 'Povolit složku Můj OneDrive ve výběru souborů';
$string['enabletrendinggroup'] = 'Povolit složku Oblíbené soubory v mém okolí ve výběru souborů';

$string['errorauthoidcnotconfig'] = 'Před použitím úložiště Microsoft 365 nakonfigurujte prosím ověřovací modul OpenID Connect.';
$string['errorbadclienttype'] = 'Neplatný typ klienta.';
$string['errorbadpath'] = 'Nesprávná cesta';
$string['errorencodingreference'] = 'Nepodařilo se zakódovat odkaz na soubor';
$string['errornofilelinkoption'] = 'Alespoň jedna možnost propojení souborů musí být povolena.';
$string['erroro365required'] = 'Tento soubor je aktuálně dostupný pouze uživatelům Microsoft 365.';
$string['errorwhiledownload'] = 'Při stahování souboru došlo k chybě.';
$string['errorwhilesharing'] = 'Při vytváření odkazu pro sdílení došlo k chybě';

$string['file'] = 'Soubor';
$string['filelinkingheader'] = 'Možnosti propojení souborů';
$string['filereferencewarning'] = 'U souboru na OneDrivu se nemění žádná nastavení sdílení. Tento odkaz mohou otevřít pouze lidé, kteří již k souboru na OneDrivu mají přístup.';
$string['groups'] = 'Skupiny (kurzy)';
$string['invalidfilereference'] = 'Neplatný nebo poškozený odkaz na soubor';
$string['myfiles'] = 'Můj OneDrive';
$string['notconfigured'] = '<p class="error">Chcete-li tento modul používat, musíte nejprve nakonfigurovat <a href="{$a}/admin/settings.php?section=local_o365">moduly Microsoft 365</a></p>';
$string['office365:view'] = 'Zobrazit úložiště Microsoft 365';
$string['pluginname'] = 'Microsoft 365';
$string['privacy:metadata'] = 'Tento modul komunikuje s rozhraním Microsoft Graph API (OneDrive) jménem aktuálního uživatele. Všechny nahrané soubory budou odeslány na vzdálený server.';
$string['trendingaround'] = 'Oblíbené soubory v mém okolí';
$string['upload'] = 'Nahrát nový soubor';
