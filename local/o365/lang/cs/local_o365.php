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

$string['pluginname'] = 'Integrace Microsoft 365';

// Settings - tabs.
$string['settings_pageheading'] = 'Konfigurace {$a}';
$string['settings_header_setup'] = 'Nastavení';
$string['settings_header_usersync'] = 'Synchronizace uživatelů';
$string['settings_header_coursesync'] = 'Synchronizace kurzů';
$string['settings_header_advanced'] = 'Pokročilé';
$string['settings_header_sds'] = 'Synchronizace SDS';
$string['settings_header_teams'] = 'Nastavení Teams';
$string['settings_header_moodle_app'] = 'Aplikace Moodle pro Teams';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'Krok 1/2: Registrace Moodlu v Microsoft Entra ID';
$string['settings_setup_step1_desc'] = 'Zaregistrujte novou aplikaci Microsoft Entra ID pro integraci s Moodlem pomocí PowerShellu:

<a href="{$a}/local/o365/scripts/Moodle-EntraID-PowerShell.zip" class="btn btn-primary" target="_blank">Stáhnout skript PowerShellu</a>

<p style="margin-top:10px"><a href="{$a}/local/o365/scripts/README.md" target="_blank">Klikněte sem</a> a přečtěte si pokyny ke spuštění skriptu.</p>
<p>Až budete vyzváni, použijte jako URL Moodlu následující odkaz:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />Po úspěšném provedení skriptu zkopírujte ID aplikace a tajný klíč vrácené skriptem na <a href="{$a}">stránku konfigurace ověřovacího modulu OpenID Connect</a>.';
$string['settings_setup_step1_credentials_end'] = 'Pokud nemůžete nastavit aplikaci Microsoft Entra ID pomocí PowerShellu, <a href="{$a}" target="_blank">klikněte sem</a> pro pokyny k ručnímu nastavení.';
$string['settings_setup_step1_continue'] = '<b>Po zadání ID aplikace a tajného klíče pokračujte kliknutím na „Uložit změny“ v dolní části stránky.</b><br /><br /><br /><br /><br />';
$string['features_disabled_external_id'] = 'Funkce Microsoft 365 nejsou dostupné, pokud je typ poskytovatele identity (IdP) pluginu pro ověřování OpenID Connect nastaven na Microsoft Entra External ID. Tenanti Microsoft Entra External ID jsou zákaznické tenanty bez služeb Microsoft 365 (Exchange Online, Microsoft Teams, SharePoint/OneDrive nebo School Data Sync), proto jsou všechny funkce tohoto pluginu zakázány.';
$string['task_skipped_external_id'] = 'Úloha byla přeskočena: funkce Microsoft 365 tohoto pluginu jsou zakázány, protože typ IdP pluginu pro ověřování OpenID Connect je Microsoft Entra External ID.';
$string['settings_setup_step1_existing_settings'] = '<h5>Stávající nastavení</h5>';
$string['settings_setup_step2'] = 'Krok 2/2: Souhlas správce a další informace';
$string['settings_setup_step2_desc'] = 'Tento poslední krok vám umožní udělit souhlas správce s použitím některých oprávnění Microsoft Entra ID a shromáždí některé další informace o vašem prostředí Microsoft 365.<br /><br />';
$string['settings_setup_step3'] = 'Ověření nastavení';
$string['settings_setup_step3_desc'] = 'Nastavení je dokončeno. Kliknutím na tlačítko „Aktualizovat“ níže své nastavení ověříte.';

// Settings in "Step 2/2" section of the "Setup" tab.
$string['settings_adminconsent'] = 'Souhlas správce';
$string['settings_adminconsent_btn'] = 'Udělit souhlas správce';
$string['settings_adminconsent_details'] = 'Pro povolení přístupu k některým potřebným oprávněním musí správce udělit souhlas správce. Klikněte na toto tlačítko a poté se přihlaste účtem správce Microsoft Entra ID, abyste souhlas udělili. Toto bude nutné provést pokaždé, když změníte oprávnění typu „Admin“ v Entra ID.';
$string['settings_entratenant'] = 'Tenant Microsoft Entra';
$string['settings_entratenant_details'] = 'Slouží k identifikaci vaší organizace v rámci Microsoftu. Příklad: „contoso.onmicrosoft.com“.<br/>
Ruční zjištění této hodnoty:
<ul>
<li>Přejděte na <a href="https://portal.azure.com" target="_blank">Azure Portal</a>.</li>
<li>Přihlaste se svým účtem správce.</li>
<li>Do vyhledávacího pole zadejte „Microsoft Entra ID“ a přejděte na stránku „Microsoft Entra ID“.</li>
<li>Použijte hodnotu z pole <b>Primární doména</b> v sekci „Základní informace“.</li>
</ul>';
$string['settings_odburl'] = 'URL OneDrive pro firmy';
$string['settings_odburl_details'] = 'Adresa URL používaná pro přístup k OneDrive pro firmy. Tu lze obvykle určit podle vašeho tenanta Microsoft Entra. Pokud například váš tenant Microsoft Entra je „contoso.onmicrosoft.com“, tato adresa URL bude s největší pravděpodobností „contoso-my.sharepoint.com“. Zadejte pouze název domény bez http:// nebo https://';
$string['settings_odburl_error_graph'] = 'Nepodařilo se zjistit URL vašeho OneDrive pro firmy, zadejte ji prosím ručně. Obvykle ji lze určit podle adresy URL, kterou používáte pro přístup k OneDrive.';
$string['settings_serviceresourceabstract_detect'] = 'Detekovat';
$string['settings_serviceresourceabstract_detecting'] = 'Detekce...';
$string['settings_serviceresourceabstract_error'] = 'Při detekci nastavení došlo k chybě. Nastavte jej prosím ručně.';
$string['settings_serviceresourceabstract_valid'] = '{$a} je použitelné.';
$string['settings_serviceresourceabstract_invalid'] = 'Tato hodnota se nezdá být použitelná.';
$string['settings_serviceresourceabstract_nocreds'] = 'Nejprve nastavte přihlašovací údaje aplikace.';
$string['settings_serviceresourceabstract_empty'] = 'Zadejte hodnotu nebo klikněte na „Detekovat“ a pokuste se detekovat správnou hodnotu.';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_verifysetup'] = 'Ověření nastavení';
$string['settings_verifysetup_appdataheader'] = 'Registrace aplikace Microsoft Entra ID';
$string['settings_verifysetup_appdatadesc'] = 'Ověřuje, zda jsou v aplikaci Entra ID nastaveny správné parametry.';
$string['settings_verifysetup_appdatareplyurlcorrect'] = 'Adresa URL odpovědi je správná';
$string['settings_verifysetup_appdatareplyurlincorrect'] = 'Adresa URL odpovědi je nesprávná';
$string['settings_verifysetup_appdatareplyurlgeneralerror'] = 'Nepodařilo se zkontrolovat adresu URL odpovědi.';
$string['settings_verifysetup_appdatasignonurlcorrect'] = 'Adresa URL přihlášení je správná.';
$string['settings_verifysetup_appdatasignonurlincorrect'] = 'Adresa URL přihlášení je nesprávná';
$string['settings_verifysetup_appdatasignonurlgeneralerror'] = 'Nepodařilo se zkontrolovat adresu URL přihlášení.';
$string['settings_verifysetup_apppermscorrect'] = 'Oprávnění aplikace jsou správná.';
$string['settings_verifysetup_details'] = 'Tento nástroj kontroluje v Microsoft Entra ID, zda je vše nastaveno správně. <br /><b>Poznámka:</b> Změny v aplikaci Microsoft Entra ID se zde mohou projevit až po chvíli. Pokud jste v aplikaci Microsoft Entra ID provedli změnu a nevidíte ji zde, chvíli počkejte a zkuste to znovu.';
$string['settings_verifysetup_correctval'] = 'Správná hodnota:';
$string['settings_verifysetup_detectedval'] = 'Zjištěná hodnota:';
$string['settings_verifysetup_update'] = 'Aktualizovat';
$string['settings_verifysetup_checking'] = 'Kontrola...';
$string['settings_verifysetup_missingappperms'] = 'Chybějící oprávnění aplikace:';
$string['settings_verifysetup_notgranted'] = 'přidáno do aplikace, ale souhlas správce nebyl udělen';
$string['settings_verifysetup_missingperms'] = 'Chybějící delegovaná oprávnění:';
$string['settings_verifysetup_permscorrect'] = 'Delegovaná oprávnění jsou správná.';
$string['settings_verifysetup_errorcheck'] = 'Při pokusu o kontrolu nastavení došlo k chybě.';
$string['settings_verifysetup_noinfo'] = 'Zatím nemáme žádné informace o nastavení vaší aplikace Microsoft Entra ID. Klikněte prosím na tlačítko Aktualizovat a proveďte kontrolu.';
$string['settings_verifysetup_strunifiedpermerror'] = 'Při kontrole oprávnění Microsoft Graph API došlo k chybě.';
$string['settings_verifysetup_strtenanterror'] = 'Před aktualizací nastavení aplikace Microsoft Entra ID nastavte pomocí tlačítka Detekovat svého tenanta Microsoft Entra.';
$string['settings_verifysetup_unifiedheader'] = 'Microsoft Graph API';
$string['settings_verifysetup_unifieddesc'] = 'Microsoft Graph API umožňuje komunikaci mezi Moodlem a Microsoft 365.';
$string['settings_verifysetup_unifiederror'] = 'Při kontrole podpory Microsoft Graph API došlo k chybě.';
$string['settings_verifysetup_unifiedactive'] = 'Microsoft Graph API je aktivní.';
$string['settings_verifysetup_unifiedmissing'] = 'Microsoft Graph API nebylo v této aplikaci nalezeno.';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc_credsvalid'] = 'Přihlašovací údaje byly nastaveny.';
$string['settings_detectoidc_credsvalid_link'] = 'Změnit';
$string['settings_detectoidc_credsinvalid'] = 'Přihlašovací údaje nebyly nastaveny nebo jsou neúplné.';
$string['settings_detectoidc_credsinvalid_link'] = 'Nastavit přihlašovací údaje';
$string['settings_detectperms_nocreds'] = 'Nejprve je nutné nastavit přihlašovací údaje aplikace. Viz nastavení výše.';
$string['settings_detectperms_errorfix'] = 'Při pokusu opravit oprávnění došlo k chybě. Opravte je prosím ručně v Microsoft Entra ID.';
$string['settings_detectperms_fixperms'] = 'Opravit oprávnění';
$string['settings_detectperms_update'] = 'Aktualizovat';
$string['settings_detectperms_valid'] = 'Oprávnění byla nastavena.';
$string['settings_detectperms_invalid'] = 'Zkontrolovat oprávnění v Microsoft Entra ID';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_usersync_general'] = 'Obecná synchronizace uživatelů';
$string['settings_usersync_suspension'] = 'Pozastavení účtů v Moodlu';
$string['settings_usersync_matching'] = 'Párování uživatelů';
$string['settings_usersync_photos'] = 'Synchronizovat profilové fotografie Microsoft 365 do Moodlu';
$string['settings_usersync_timezone'] = 'Synchronizovat časové pásmo z Outlooku do Moodlu';
$string['settings_usersync'] = 'Synchronizovat uživatele z Microsoft Entra ID';
$string['settings_usersync_details'] = 'Když je toto nastavení povoleno, Moodle synchronizuje uživatele z Microsoft Entra ID podle možností výše.<br /><br /><b>Poznámka: </b>Úloha synchronizace běží v procesu cron v Moodlu a synchronizuje vždy 1000 uživatelů najednou. Ve výchozím nastavení se spouští jednou denně v 01:00 v časovém pásmu vašeho serveru. Chcete-li synchronizovat větší množství uživatelů rychleji, můžete zvýšit frekvenci spouštění úlohy <b>Synchronizovat uživatele z Microsoft Entra ID</b> pomocí <a href="{$a}">stránky správy naplánovaných úloh.</a><br /><br />';
$string['settings_usersync_create'] = 'Vytvořit účty v Moodlu pro uživatele v Microsoft Entra ID';
$string['settings_usersync_update'] = 'Aktualizovat účty v Moodlu pro uživatele v Microsoft Entra ID';
$string['settings_usersync_suspend'] = 'Pozastavit dříve synchronizované účty v Moodlu, když jsou odstraněny z Microsoft Entra ID';
$string['settings_usersync_delete'] = 'Odstranit dříve synchronizované účty v Moodlu, když jsou odstraněny z Microsoft Entra ID';
$string['settings_usersync_reenable'] = 'Znovu povolit pozastavené účty pro uživatele v Microsoft Entra ID';
$string['settings_usersync_disabledsyncsuspend'] = 'Pozastavit účty v Moodlu, když jsou zakázány v Microsoft Entra ID';
$string['settings_usersync_disabledsyncreenable'] = 'Znovu povolit účty v Moodlu, když jsou znovu povoleny v Microsoft Entra ID';
$string['settings_usersync_suspendnolink'] = 'Pozastavit připojené účty, které nemají uložené propojení s Microsoftem, když jsou odstraněny z Microsoft Entra ID nebo v něm zakázány';
$string['settings_usersync_groupsyncsuspend'] = 'Pozastavit účty v Moodlu, které nejsou v nakonfigurované skupině pro synchronizaci uživatelů';
$string['settings_usersync_match'] = 'Spárovat již existující uživatele Moodlu s účty se stejnými názvy v Microsoft Entra ID';
$string['settings_usersync_matchswitchauth'] = 'Přepnout spárované uživatele na ověřování Microsoft 365 (OpenID Connect)';
$string['settings_usersync_appassign'] = 'Během synchronizace přiřadit uživatele k aplikaci';
$string['settings_usersync_photosync'] = 'Synchronizovat profilové fotografie Microsoft 365 do Moodlu v úloze cron';
$string['settings_usersync_photosynconlogin'] = 'Synchronizovat profilové fotografie Microsoft 365 do Moodlu při přihlášení';
$string['settings_usersync_nodelta'] = 'Při každém spuštění provést úplnou synchronizaci';
$string['settings_usersync_emailsync'] = 'Během synchronizace párovat uživatelská jména Microsoft Entra ID s e-maily v Moodlu místo uživatelských jmen v Moodlu';
$string['settings_addsync_tzsync'] = 'Synchronizovat časové pásmo z Outlooku do Moodlu v úloze cron';
$string['settings_addsync_tzsynconlogin'] = 'Synchronizovat časové pásmo z Outlooku do Moodlu při přihlášení';
$string['settings_usersync_guestsync'] = 'Synchronizovat uživatele typu host';
$string['settings_suspend_delete_running_time'] = 'Čas spuštění pozastavení/odstranění uživatelů';
$string['settings_suspend_delete_running_time_desc'] = 'Pokud je tato možnost povolena, funkce pozastavení/odstranění v rámci synchronizace uživatelů se spustí jednou denně v nastaveném čase ve výchozím časovém pásmu instance Moodle.';
$string['settings_usersync_delete_delay'] = 'Prodleva před odstraněním pozastavených uživatelů';
$string['settings_usersync_delete_delay_desc'] = 'Minimální doba, po kterou musí být uživatel v Moodlu pozastaven, než synchronizace uživatelů jeho účet odstraní. Tato doba se přičítá k době uchování obnovitelně odstraněných uživatelů v Microsoft Entra ID, takže k odstranění nikdy nedojde dříve. Nastavte 0 pro odstranění ihned po uplynutí doby uchování v Microsoft Entra ID. U uživatelů, kteří byli pozastaveni již před zavedením tohoto nastavení, se doba počítá od prvního spuštění synchronizace uživatelů, které je najde.';
$string['settings_support_user_identifier_change'] = 'Podporovat změnu hodnoty deklarace uživatelského jména použité k propojení účtu Microsoft';
$string['settings_support_user_identifier_change_desc'] = 'Pokud je povoleno, Moodle se pokusí reagovat na změnu hodnoty deklarace uživatelského jména použité k propojení (obvykle UPN) účtu Microsoft, který je připojen k účtu Moodle.<br/>
<table class="flexible table table-striped table-hover generaltable generalbox table-sm">
    <tr>
        <th>ID případu</th>
        <th>Přihlásil se již uživatel se starým uživatelským jménem? (token vytvořen)<br/>
        <span class="support_user_identifier_change_case_detail">Zda je token uložen v tabulce auth_oidc_token</span>
        </th>
        <th>První akce po přejmenování UPN<br/>
        <span class="support_user_identifier_change_case_detail">Přihlášení, nebo spuštění úlohy synchronizace uživatelů</span>
        </th>
        <th>Možná duplicita uživatelského jména<br/>
        <span class="support_user_identifier_change_case_detail">Zda by přejmenování způsobilo konflikt uživatelských jmen v Moodlu</span>
        </th>
        <th>Očekávané chování</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Ano</td>
        <td>Přihlášení</td>
        <td>Ne</td>
        <td>
            <ol>
                <li>Přejmenovat uživatele Moodlu.</li>
                <li>V auth_oidc_token se aktualizují nové hodnoty polí „username“ i „oidcusername“.</li>
                <li>V záznamu připojení uživatele v local_o365_objects se pole „o365name“ aktualizuje na novou hodnotu.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Ano</td>
        <td>Synchronizace uživatelů</td>
        <td>Ne</td>
        <td>
            <ol>
                <li>Přejmenovat uživatele Moodlu.</li>
                <li>Záznam připojení uživatele v local_o365_objects se aktualizuje.</li>
                <li>auth_oidc_token se aktualizuje.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>Ne</td>
        <td>Přihlášení</td>
        <td>Ne</td>
        <td>
            <ol>
                <li>Přejmenovat uživatele Moodlu.</li>
                <li>Záznam připojení uživatele v local_o365_objects se aktualizuje.</li>
                <li>auth_oidc_token se aktualizuje.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>Ne</td>
        <td>Synchronizace uživatelů</td>
        <td>Ne</td>
        <td>
            <ol>
                <li>Přejmenovat uživatele Moodlu.</li>
                <li>Záznam připojení uživatele v local_o365_objects se aktualizuje.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>Ano</td>
        <td>Přihlášení</td>
        <td>Ano</td>
        <td>
            <ol>
                <li>Vyvolat výjimku a uživatele Moodlu nepřejmenovat.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>Ano</td>
        <td>Synchronizace uživatelů</td>
        <td>Ano</td>
        <td>
            <ol>
                <li>Při spuštění úlohy synchronizace uživatelů zobrazit chybovou zprávu, že pokus o přejmenování selhal.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>Ne</td>
        <td>Přihlášení</td>
        <td>Ano</td>
        <td>
            <ol>
                <li>Vyvolat výjimku a uživatele Moodlu nepřejmenovat.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>Ne</td>
        <td>Synchronizace uživatelů</td>
        <td>Ano</td>
        <td>
            <ol>
                <li>Při spuštění úlohy synchronizace uživatelů zobrazit chybovou zprávu, že pokus o přejmenování selhal.</li>
            </ol>
        </td>
    </tr>
</table>
Upozorňujeme na známý problém: pokud
<ol>
<li>Moodle a Microsoft 365 jsou propojeny metodou připojení „Microsoft identity platform (v2.0)“ a</li>
<li>Microsoft Entra je nakonfigurováno tak, aby povolovalo použití „e-mailu jako alternativního přihlašovacího ID“ a</li>
<li>tato možnost je povolena a</li>
<li>uživatelské jméno a e-mailová adresa účtu Microsoft se liší a</li>
<li>uživatel Microsoftu se přihlásí pomocí e-mailové adresy místo uživatelského jména,</li>
</ol>
pak modul auth_oidc bude považovat e-mailovou adresu za uživatelské jméno účtu Microsoft a aktualizuje uživatelské jméno v Moodlu.';

// User field mapping.
$string['settings_fieldmap'] = 'Mapování polí uživatele';
$string['settings_fieldmap_details'] = 'K dispozici v <a href="{$a}">ověřovacím modulu OpenID Connect</a>.';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'Synchronizace kurzů';
$string['settings_secthead_coursesync_desc'] = 'Následující nastavení řídí synchronizaci kurzů mezi Moodlem a Microsoft Teams.';
$string['settings_coursesync'] = 'Synchronizace kurzů';
$string['settings_coursesync_details'] = 'Pokud je povoleno, budou se pro kurzy na webu Moodle vytvářet a udržovat týmy Teams (výchozí: zakázáno). Při každém spuštění cronu se vytvoří potřebné týmy a všichni aktuálně zapsaní uživatelé se do nich přidají jako vlastníci nebo členové týmu, podle kontroly práv. Poté bude členství v týmu udržováno tak, jak jsou uživatelé zapisováni do kurzů Moodlu nebo z nich vyškrtáváni.';
$string['acp_coursesynccustom_off'] = 'Zakázáno<br />Zakázat vytváření týmů Teams pro všechny kurzy.';
$string['acp_coursesynccustom_oncustom'] = 'Přizpůsobit<br />Umožňuje oprávněným uživatelům vybrat, pro které kurzy se mají vytvářet týmy Teams.<br> <span id="adminsetting_coursesync" style="font-weight: bold"><a href="{$a}">Přizpůsobit synchronizaci kurzů</a></span>';
$string['acp_coursesynccustom_onall'] = 'Všechny funkce povoleny<br />Povolí vytváření týmů Teams pro všechny kurzy.';
$string['settings_coursesync_sync_hidden_courses'] = 'Synchronizovat skryté kurzy';
$string['settings_coursesync_sync_hidden_courses_desc'] = 'Ve výchozím nastavení modul ignoruje skryté kurzy, aby nedocházelo k synchronizaci kurzů, které se právě kopírují nebo obnovují. Povolením tohoto nastavení vynutíte vytváření týmů Teams i pro skryté kurzy.';
$string['acp_coursesync_hidden_course_note'] = 'Poznámka: Skryté kurzy nebudou zpracovány pro vytvoření skupin Teams. Chcete-li to povolit, musíte v konfiguraci modulu povolit nastavení „Synchronizovat skryté kurzy“.';
$string['settings_coursesync_delete_group_on_course_deletion'] = 'Odstranit skupiny Microsoft 365 při odstranění připojeného kurzu Moodlu';
$string['settings_coursesync_delete_group_on_course_deletion_details'] = 'Pokud je povoleno, Moodle se pokusí odstranit skupinu Microsoft 365 (a přidružený tým) při odstranění připojeného kurzu z Moodlu. Upozorňujeme, že se to netýká kurzů vytvořených synchronizací SDS.';
$string['settings_coursesync_delete_group_on_course_sync_disabled'] = 'Odstranit skupiny Microsoft 365 při vypnutí synchronizace kurzu';
$string['settings_coursesync_delete_group_on_course_sync_disabled_details'] = 'Pokud je povoleno, Moodle se pokusí odstranit připojenou skupinu Microsoft 365 (a přidružený tým), když je pro kurz Moodlu vypnuta synchronizace kurzu.';
$string['settings_coursesync_courses_per_task'] = 'Počet kurzů synchronizovaných při jednom spuštění úlohy';
$string['settings_coursesync_courses_per_task_details'] = 'Počet kurzů, jejichž stav synchronizace týmu/skupiny se zpracuje při každém spuštění úlohy.';
$string['settings_coursesync_team_type'] = 'Šablona týmu';
$string['settings_coursesync_team_type_desc'] = 'Šablona Microsoft Teams, která se použije při vytváření týmů z kurzů Moodlu. Vzdělávací šablony vyžadují licenci pro vzdělávání. <br><br><strong>Důležité:</strong> Nakonfigurovaná šablona určuje, jak se vytvářejí skupiny a týmy:<br>
&bull; Standardní šablona vytváří standardní skupiny a týmy (kompatibilní se všemi tenanty).<br>
&bull; Vzdělávací šablony vytvářejí vzdělávací skupiny/týmy (pouze pro vzdělávací tenanty; zpřístupňují funkce specifické pro vzdělávání).<br>
&bull; Vlastní šablony používají standardní skupiny (kvůli kompatibilitě s návrhem vlastní šablony).<br><br>
<strong>⚠️ UPOZORNĚNÍ: Jakmile je tým vytvořen s určitou šablonou, šablonu nelze změnit.</strong> Týmy zůstávají spojeny se svou původní šablonou. Změna tohoto nastavení ovlivní pouze nově vytvořené týmy, nikoli stávající. Výběr šablony pečlivě naplánujte před povolením synchronizace kurzů.';
$string['settings_coursesync_team_type_standard'] = 'Standardní';
$string['settings_coursesync_team_type_educationclass'] = 'Vzdělávání – tým třídy';
$string['settings_coursesync_team_type_educationstaff'] = 'Vzdělávání – tým zaměstnanců';
$string['settings_coursesync_team_type_educationplc'] = 'Vzdělávání – profesní vzdělávací komunita (PLC)';
$string['settings_coursesync_team_type_custom'] = 'Vlastní šablona';
$string['settings_coursesync_team_type_custom_id'] = 'ID vlastní šablony';
$string['settings_coursesync_team_type_custom_id_desc'] = 'Úplné ID vlastní šablony definované v centru pro správu Teams. Používá se pouze v případě, že je výše vybrána možnost „Vlastní šablona“. <br><br><strong>ID šablony musí být ve formátu GUID</strong> (např. e41de7bb-859a-4a0f-aa39-5725a0529c1c). ID šablony najdete v centru pro správu Teams při zobrazení podrobností vaší vlastní šablony. <br><br>
<strong>⚠️ VYŽADOVÁNO DALŠÍ OPRÁVNĚNÍ MICROSOFT ENTRA ID:</strong> Ověření a použití vlastních šablon týmů vyžaduje další aplikační oprávnění Microsoft Graph API (<strong>TeamTemplates.Read.All</strong>), které ve vaší registraci aplikace Microsoft Entra ID nemusí být. Bez tohoto oprávnění ověření selže a ID vlastní šablony nelze nastavit. Pokud ověření selže s chybou oprávnění, požádejte správce Microsoft Entra ID, aby toto oprávnění přidal do registrace vaší aplikace. <br><br>
<strong>⚠️ DŮLEŽITÉ OMEZENÍ:</strong> Rozhraní Microsoft Teams v současnosti podporuje vytváření týmů z vlastních šablon pouze tehdy, když šablona obsahuje <strong>definici národního prostředí en-US</strong>. Z vlastních šablon bez podpory národního prostředí en-US se týmy vytvořit nepodaří. Zajistěte prosím, aby vaše vlastní šablona měla v centru pro správu Teams definováno národní prostředí en-US. <br><br>
<strong>⚠️ UPOZORNĚNÍ: Jakmile je tým vytvořen pomocí této vlastní šablony, šablonu nelze změnit.</strong> Pokud potřebujete pro nové týmy použít jinou vlastní šablonu, musíte toto nastavení ponechat prázdné nebo jej změnit před dalším vytvořením týmu. Stávající týmy budou nadále používat svou původní šablonu. <br><br>
Pokud je nakonfigurováno nesprávné ID šablony, týmy se nevytvoří správně. Před spuštěním synchronizace kurzů ověřte ID šablony pomocí tlačítka „Ověřit ID vlastní šablony“.';
$string['error_custom_template_id_required'] = 'Při použití možnosti „Vlastní šablona“ je ID vlastní šablony povinné. Zadejte prosím platné ID šablony.';
$string['error_custom_template_id_not_found'] = 'ID vlastní šablony „{$a}“ nebylo nalezeno. Ověřte prosím, že ID šablony v centru pro správu Teams existuje.';
$string['error_custom_template_id_validation_failed'] = 'Ověření ID vlastní šablony selhalo. Šablona nemusí podporovat přímé vytvoření týmu nebo může jít o problém s konfigurací. Ověřte prosím ID šablony v centru pro správu Teams.';
$string['settings_team_type_custom_id_test_button'] = 'Ověřit ID vlastní šablony';
$string['settings_team_type_custom_id_validating'] = '🔄 Ověřování...';
$string['settings_team_type_custom_id_error_empty'] = '⚠️ Nejprve zadejte ID šablony.';
$string['settings_team_type_custom_id_error_not_found'] = '✗ Šablona nebyla nalezena. ID šablony „{$a}“ neexistuje. Ověřte je prosím v centru pro správu Teams.';
$string['settings_team_type_custom_id_error_validation'] = '✗ Chyba ověření. {$a}';
$string['settings_team_type_custom_id_error_default'] = 'Šablonu se nepodařilo ověřit. Zkuste to prosím znovu nebo kontaktujte správce.';
$string['settings_team_type_custom_id_error_timeout'] = '✗ Časový limit ověření vypršel. Požadavek trval déle než 10 sekund. Zkuste to prosím znovu.';
$string['settings_team_type_custom_id_error_network'] = '✗ Chyba sítě. Ověřovací službu nelze kontaktovat. Zkontrolujte prosím připojení k internetu a zkuste to znovu.';
$string['settings_team_type_custom_id_error_parsererror'] = '✗ Chyba odpovědi serveru. Ověřovací služba vrátila neplatná data. Zkontrolujte prosím integraci Microsoft 365.';
$string['settings_team_type_custom_id_error_http'] = '✗ Chyba ověření (HTTP {$a}). Zkuste to prosím znovu nebo kontaktujte správce.';
$string['settings_coursesync_group_channels'] = 'Vytvořit kanál pro každou skupinu Moodlu';
$string['settings_coursesync_group_channels_details'] = 'V připojeném týmu Microsoft Teams vytvoří pro každou skupinu v kurzu Moodlu soukromý kanál a udržuje členy každého kanálu v souladu se členy skupiny Moodlu. Členové skupiny, kteří jsou také připojeni k Microsoft 365, jsou do kanálu přidáni nebo z něj odebráni, když jsou přidáni do skupiny nebo z ní odebráni. Kdokoli, kdo je do kanálu přidán v Microsoft Teams a není členem skupiny Moodlu, je opět odebrán. Ve vzdělávacím týmu třídy, který ještě nebyl aktivován, nelze studenty do kanálů zařadit: zařazeni jsou pouze vlastníci a studenti jsou přidáni automaticky naplánovanou úlohou „Vytvořit kanály Teams pro skupiny Moodlu a synchronizovat jejich členy“ poté, co vlastník tým v Microsoft Teams aktivuje. Kanály se nepřejmenovávají ani neodstraňují, když je skupina Moodlu přejmenována nebo odstraněna. Členství v kanálech se synchronizuje vždy pouze z Moodlu do Teams a toto nastavení nemá žádný účinek, pokud je „Chování synchronizace uživatelů kurzu“ nastaveno na „Z Teams do Moodlu“. Microsoft Teams umožňuje v jednom týmu až 1 000 kanálů, včetně soukromých kanálů a kanálů odstraněných během posledních 30 dnů.<br /><br /><b>Toto nastavení vyžaduje dvě další aplikační oprávnění Microsoft Graph:</b><ul><li><b>Channel.Create</b> – pro vytváření kanálů.</li><li><b>ChannelMember.ReadWrite.All</b> – pro přidávání členů do kanálů a jejich odebírání.</li></ul>Obě musí být přidána do aplikace Microsoft Entra ID používané Moodlem a musí jim být udělen souhlas správce. Skript PowerShellu na kartě „Nastavení“ je již obsahuje při registraci nové aplikace. U již existující aplikace je přidejte ručně v části Registrace aplikací &gt; vaše aplikace &gt; Oprávnění API &gt; Přidat oprávnění &gt; Microsoft Graph &gt; Oprávnění aplikace a poté udělte souhlas správce. Dokud je toto nastavení povoleno, „Ověření nastavení“ na kartě „Nastavení“ hlásí tato oprávnění jako chybějící, dokud nejsou udělena.';
$string['settings_coursesync_sync_direction'] = 'Chování synchronizace uživatelů kurzu';
$string['settings_coursesync_sync_direction_details'] = 'Vyberte směr, ve kterém chcete synchronizovat uživatele mezi Moodlem a Microsoft Teams.';
$string['settings_coursesync_sync_moodle_to_teams'] = 'Z Moodlu do Teams';
$string['settings_coursesync_sync_teams_to_moodle'] = 'Z Teams do Moodlu';
$string['settings_coursesync_sync_both'] = 'Aktualizovat Teams i Moodle';
$string['settings_coursesync_enrolment_owner_role'] = 'Role vlastníka týmu';
$string['settings_coursesync_enrolment_owner_role_desc'] = 'Role, která bude během synchronizace přiřazena vlastníkovi týmu.';
$string['settings_coursesync_enrolment_member_role'] = 'Role člena týmu';
$string['settings_coursesync_enrolment_member_role_desc'] = 'Role, která bude během synchronizace přiřazena členům týmu.';

// Settings in the "Course sync customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_coursesynccustom'] = 'Přizpůsobení synchronizace kurzů';
$string['acp_coursesynccustom_enabled'] = 'Povoleno';
$string['acp_coursesynccustom_enable_all'] = 'Povolit synchronizaci kurzů u všech kurzů';
$string['acp_coursesynccustom_disable_all'] = 'Zakázat synchronizaci kurzů u všech kurzů';
$string['acp_coursesynccustom_bulk'] = 'Hromadné operace';
$string['acp_coursesynccustom_bulk_enable'] = 'Povolit synchronizaci kurzů u kurzů na této stránce';
$string['acp_coursesynccustom_bulk_disable'] = 'Zakázat synchronizaci kurzů u kurzů na této stránce';
$string['acp_coursesynccustom_settings_header'] = 'Možnosti synchronizace';
$string['acp_coursesynccustom_new_course'] = 'Ve výchozím nastavení povoleno pro nové kurzy';
$string['acp_coursesynccustom_new_course_desc'] = 'Pokud je povoleno, všechny nově vytvořené kurzy budou mít synchronizaci ve výchozím nastavení povolenou.';
$string['acp_coursesynccustom_controlled_per_course'] = 'Povolit konfiguraci synchronizace kurzu v kurzech';
$string['acp_coursesynccustom_controlled_per_course_desc'] = 'Pokud je povoleno, uživatelé zapsaní v kurzech Moodlu, kteří mohou působit jako vlastníci týmu (mají právo „Vlastník týmu“ [local/o365:teamowner]), budou moci ovládat synchronizaci kurzu z bloku Microsoft v kurzu.';
$string['acp_coursesynccustom_savemessage'] = 'Vaše změny byly uloženy.';
$string['acp_coursesynccustom_regex_search'] = 'Hledání regulárním výrazem';
$string['acp_coursesynccustom_regex_search_title'] = 'Je-li zaškrtnuto, obsah vyhledávacího pole výše se porovnává jako regulární výraz PCRE (bez oddělovačů) s celým názvem, krátkým názvem a identifikátorem, namísto prostého textového hledání.';
$string['acp_coursesynccustom_confirm_all_action'] = 'Opravdu chcete změnit stav synchronizace všech kurzů? Tuto akci nelze vrátit zpět.';
$string['acp_coursesynccustom_sds_course'] = 'Uzamčeno pro kurz SDS';
$string['acp_coursesynccustom_all_enabled_notice'] = 'Synchronizace kurzů je aktuálně povolena pro všechny kurzy. Přizpůsobení jednotlivých kurzů je zakázáno, protože je aktivní režim „Všechny funkce povoleny“.';
$string['acp_coursesynccustom_disabled_notice'] = 'Synchronizace kurzů je aktuálně globálně zakázána. Přizpůsobení jednotlivých kurzů je zakázáno, protože je aktivní režim „Zakázáno“.';
$string['acp_coursesynccustom_categories_header'] = 'Synchronizace podle kategorie kurzů';
$string['acp_coursesynccustom_categories_desc'] = 'Vyberte jednu nebo více kategorií kurzů, aby se synchronizace kurzů automaticky povolila pro všechny kurzy v těchto kategoriích včetně jejich podkategorií. To platí i pro kurzy, které budou do vybraných kategorií přidány později. Pro výběr více kategorií podržte Ctrl (na Macu Cmd), pro zrušení výběru klikněte znovu se stisknutou klávesou.';
$string['acp_coursesynccustom_category_course'] = 'Uzamčeno: povoleno kategorií kurzů';

// Settings in the "Cohort sync" section of the "Sync settings" tab.
$string['settings_secthead_cohortsync'] = 'Synchronizace globálních skupin';
$string['settings_secthead_cohortsync_desc'] = 'Tato funkce umožňuje synchronizaci mezi skupinami Microsoft 365 a globálními skupinami Moodlu.';
$string['settings_cohortsync'] = 'Synchronizace globálních skupin';
$string['settings_cohortsync_linktext'] = 'Spravovat synchronizaci globálních skupin';
$string['settings_cohortsync_details'] = 'Kontrola a správa synchronizace mezi globálními skupinami Moodlu a skupinami Microsoft 365.';
$string['settings_cohortsync_title'] = 'Synchronizace globálních skupin';
$string['settings_cohortsync_excludeowners'] = 'Vyloučit vlastníky skupin ze synchronizace globálních skupin';
$string['settings_cohortsync_excludeowners_desc'] = 'Pokud je povoleno, vlastníci skupin se nesynchronizují do globálních skupin Moodlu, i když jsou zároveň členy skupiny. Vlastníci, kteří již v globální skupině jsou, budou při příštím spuštění synchronizace odebráni.';

// Settings in the "Team / group names" section of the "Sync settings" tab.
$string['settings_secthead_team_group_name'] = 'Názvy týmů / skupin';
$string['settings_secthead_team_group_name_desc'] = 'Pokud je kurz nakonfigurován k synchronizaci, název týmu a skupiny se sestaví následovně.<br/>
<ul>
<li>Lze definovat e-mailový alias skupiny a zobrazovaný název týmu.</li>
<li>Nejprve se vytvoří skupina Microsoft 365 pomocí nakonfigurovaného mailNickname skupiny a zobrazovaného názvu týmu a ze skupiny se poté vytvoří tým.</li>
<li>Pokud se používají zásady pojmenování Microsoft Entra ID pro skupiny Microsoft 365, skupiny nebudou vytvořeny, pokud zobrazovaný název vytvořený podle konfigurace neodpovídá zásadám.</li>
<li>Zde provedené změny ovlivní pouze budoucí vytváření týmů, nikoli stávající týmy.</li>
<li>Z e-mailového aliasu skupiny budou odstraněny všechny mezery.</li>
<li>V e-mailovém aliasu skupiny jsou povolena pouze velká a malá písmena, číslice, - a _.</li>
<li>E-mailový alias skupiny včetně předpony a přípony nesmí přesáhnout 64 znaků.</li>
<li>E-mailový alias skupiny musí být jedinečný, jinak se k němu pro zajištění jedinečnosti připojí náhodné čtyřmístné číslo.</li>
</ul>';
$string['settings_team_name_prefix'] = 'Předpona názvu týmu';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'Část názvu týmu z kurzu';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'Přípona názvu týmu';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_group_mail_alias_prefix'] = 'Předpona e-mailového aliasu skupiny';
$string['settings_group_mail_alias_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'Část e-mailového aliasu skupiny z kurzu';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'Přípona e-mailového aliasu skupiny';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'Předpokládejme, že kurz má:
<ul>
<li>Celý název: <b>Ukázkový kurz</b></li>
<li>Krátký název: <b>sample 15</b></li>
<li>ID vytvořené Moodlem: <b>2</b></li>
<li>Identifikátor: <b>Sample ID 15</b></li>
</ul>
Vaše aktuální nastavení vytvoří skupinu s e-mailovým aliasem „<b>{$a->mailalias}</b>“ a tým s názvem „<b>{$a->teamname}</b>“.<br/>
Kliknutím na tlačítko „Uložit změny“ níže zobrazíte, jak vaše nastavení tento výsledek změní.';
$string['settings_main_name_option_full_name'] = 'Celý název';
$string['settings_main_name_option_short_name'] = 'Krátký název';
$string['settings_main_name_option_id'] = 'ID vytvořené Moodlem';
$string['settings_main_name_option_id_number'] = 'Identifikátor';
$string['settings_team_name_sync'] = 'Aktualizovat název týmu při aktualizaci kurzu';
$string['settings_team_name_sync_desc'] = 'Pokud je povoleno, při aktualizaci kurzu Moodlu se název týmu aktualizuje podle nejnovějšího nastavení názvů týmů.';

// Settings in the "Course request" section of the "Sync settings" tab.
$string['settings_secthead_course_request'] = 'Žádost o kurz';
$string['settings_secthead_course_request_desc'] = 'Nastavení mapování rolí ve funkci žádosti o kurz z Teams.';
$string['settings_course_request_enrolment_owner_role'] = 'Role vlastníka týmu';
$string['settings_course_request_enrolment_owner_role_desc'] = 'Role, která bude přiřazena vlastníkovi týmu při schválení žádosti o kurz.';
$string['settings_course_request_enrolment_member_role'] = 'Role člena týmu';
$string['settings_course_request_enrolment_member_role_desc'] = 'Role, která bude přiřazena členům týmu při schválení žádosti o kurz.';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'Nástroje';
$string['settings_secthead_calsync'] = 'Synchronizace kalendáře';
$string['settings_calsyncsubscribemode'] = 'Odběr synchronizace kalendáře';
$string['settings_calsyncsubscribemode_details'] = 'Určuje, zda si uživatelé musí synchronizaci s kalendářem Outlooku zapnout sami.<ul><li><b>Dobrovolná účast (opt-in)</b>: uživatelé si synchronizaci kalendáře zapnou a zaškrtnou kalendáře k synchronizaci na své stránce nastavení synchronizace kalendáře.</li><li><b>Automatická účast (opt-out)</b>: uživatelé připojení k Microsoft 365 mají synchronizaci kalendáře automaticky povolenou a jsou přihlášeni k odběru kalendářů vybraných níže (u kurzů všech kurzů, do kterých jsou zapsáni, nyní i v budoucnu), přičemž se synchronizuje z Moodlu do jejich primárního kalendáře Outlooku. Uživatelé to mohou na své stránce nastavení synchronizace kalendáře stále změnit nebo vypnout a uživatelé, kteří synchronizaci kalendáře vypnou, nejsou znovu přihlášeni k odběru.</li></ul>Přepnutí zpět na „Dobrovolná účast (opt-in)“ stávající odběry neodstraní.';
$string['settings_calsyncsubscribetypes'] = 'Kalendáře, k jejichž odběru budou uživatelé přihlášeni automaticky';
$string['settings_calsyncsubscribetypes_details'] = 'Platí pouze pro režim „Automatická účast (opt-out)“. Vyberte, k odběru kterých kalendářů Moodlu budou připojení uživatelé automaticky přihlášeni. Přihlášení všech k odběru kalendáře webu přidá každého uživatele jako účastníka každé události webu, proto není ve výchozím nastavení vybráno.';
$string['settings_calsyncsubscribetypes_site'] = 'Kalendář webu';
$string['settings_calsyncsubscribetypes_user'] = 'Osobní kalendář';
$string['settings_calsyncsubscribetypes_course'] = 'Kalendáře kurzů (všechny kurzy, do kterých je uživatel zapsán)';
$string['settings_calsyncsubscribemode_optin'] = 'Dobrovolná účast (opt-in) (uživatelé si synchronizaci kalendáře povolí sami)';
$string['settings_calsyncsubscribemode_optout'] = 'Automatická účast (opt-out) (automaticky povolit synchronizaci kalendáře všem připojeným uživatelům)';
$string['settings_secthead_advanced'] = 'Pokročilá nastavení';
$string['settings_secthead_advanced_desc'] = 'Tato nastavení řídí další funkce sady modulů. Buďte opatrní! Mohou způsobit nezamýšlené účinky.';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'Tenanty';
$string['settings_tools_tenants_linktext'] = 'Konfigurovat další tenanty';
$string['settings_tools_tenants_details'] = 'Správa přístupu k dalším tenantům Microsoft Entra.';
$string['settings_healthcheck'] = 'Kontrola stavu';
$string['settings_healthcheck_details'] = 'Pokud něco nefunguje správně, kontrola stavu může obvykle identifikovat problém a navrhnout řešení.';
$string['settings_healthcheck_linktext'] = 'Provést kontrolu stavu';
$string['settings_userconnections'] = 'Připojení uživatelů';
$string['settings_userconnections_linktext'] = 'Spravovat připojení uživatelů';
$string['settings_userconnections_details'] = 'Kontrola a správa připojení mezi uživateli Moodlu a Microsoft 365.';
$string['settings_teamconnections'] = 'Připojení týmů';
$string['settings_teamconnections_linktext'] = 'Spravovat připojení týmů';
$string['settings_teamconnections_details'] = 'Kontrola a správa připojení mezi kurzy Moodlu a Microsoft Teams.';
$string['settings_usermatch'] = 'Párování uživatelů';
$string['settings_usermatch_details'] = 'Tento nástroj umožňuje párovat uživatele Moodlu s uživateli Microsoft 365 na základě nahraného vlastního datového souboru.';
$string['settings_usersyncgroupfilter'] = 'Filtr skupiny pro synchronizaci uživatelů';
$string['settings_usersyncgroupfilter_details'] = 'Pokud zde zadáte ID objektu skupiny (GUID), úplné synchronizace uživatelů budou omezeny na členy a vlastníky této skupiny Microsoft 365. Ponechte prázdné, chcete-li synchronizovat všechny licencované uživatele ve vašem tenantu.<br><br>
<strong>POZOR: Toto je pokročilé nastavení. Chybná konfigurace může způsobit závažné problémy se synchronizací dat.</strong><br><br>
<strong>Je-li nakonfigurováno, platí následující:</strong><br>
(1) Aktualizace profilu, časového pásma a fotografie se použijí pouze u uživatelů, kteří jsou členy nebo vlastníky skupiny<br>
(2) Nové účty Moodlu se vytvoří pouze pro uživatele, kteří jsou členy nebo vlastníky skupiny<br>
(3) Účty Moodlu uživatelů, kteří nejsou členy, již nebudou dostávat aktualizace a mohou se rozejít s Microsoft 365<br>
(4) Uživatelé zakázaní v Microsoft 365 budou v Moodlu i nadále pozastaveni synchronizací stavu povolení, která běží nezávisle na filtrování podle skupiny<br>
(5) Odebrání uživatele ze skupiny zastaví budoucí synchronizace tohoto účtu. Jeho účet v Moodlu se neodstraní a pozastaví se pouze v případě, že je povolena možnost „Pozastavit účty v Moodlu, které nejsou v nakonfigurované skupině pro synchronizaci uživatelů“, která pozastaví každého synchronizovaného uživatele, který ve skupině není, bez ohledu na to, zda v ní někdy byl<br><br>
<strong>Omezení přírůstkové (delta) synchronizace:</strong> Microsoft Graph nepodporuje delta dotazy na koncové body členství ve skupinách. Je-li toto nastavení nakonfigurováno, delta synchronizace místo přírůstkové aktualizace provedou úplnou synchronizaci členů skupiny. Jde o správné chování, ale může být pomalejší než běžná delta synchronizace.<br><br>
Před uložením ID objektu skupiny ověřte. Zadejte ID objektu skupiny (GUID).';
$string['settings_usersyncgroupfilter_validation_error'] = 'Neplatný formát ID skupiny. ID skupiny musí být platný GUID (např. 550e8400-e29b-41d4-a716-446655440000).';
$string['settings_usersynccreationrestriction'] = 'Omezení vytváření uživatelů';
$string['settings_usersynccreationrestriction_details'] = 'Pokud je povoleno, budou během synchronizace uživatelů vytvořeni pouze uživatelé Microsoft Entra ID, kteří splňují podmínku. Pro členství ve skupině Microsoft 365 (ID objektu skupiny) zadejte jedno ID objektu skupiny nebo více ID objektů skupin oddělených čárkami.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Hodnota pole';
$string['settings_usersynccreationrestriction_o365group'] = 'Členství ve skupině Microsoft 365 (název skupiny)';
$string['settings_usersynccreationrestriction_o365groupid'] = 'Členství ve skupině Microsoft 365 (ID objektu skupiny)';
$string['settings_usersynccreationrestriction_invalidgroupid'] = 'ID objektu skupiny Microsoft 365 „{$a}“ nebylo nalezeno. Zkontrolujte ID a zkuste to znovu.';
$string['settings_usersynccreationrestriction_groupvalidationerror'] = 'ID objektů skupin Microsoft 365 nebylo možné ověřit. Zkontrolujte ID a konfiguraci Microsoft Graph a zkuste to znovu.';
$string['settings_usersynccreationrestriction_regex'] = 'Hodnota je regulární výraz';
$string['settings_maintenance'] = 'Údržba';
$string['settings_maintenance_details'] = 'K dispozici jsou různé úlohy údržby pro řešení některých běžných problémů.';
$string['settings_maintenance_linktext'] = 'Zobrazit nástroje údržby';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'Více tenantů';
$string['acp_tenants_title_desc'] = 'Tato stránka vám pomůže nastavit přístup do Moodlu z Microsoft 365 pro více tenantů.';
$string['acp_tenants_add'] = 'Přidat nový tenant';
$string['acp_tenants_errornotsetup'] = 'Před přidáním dalších tenantů prosím dokončete proces nastavení modulu.';
$string['acp_tenants_hosttenant'] = 'Hostitelský tenant: {$a}';
$string['acp_tenants_intro'] = '<b>Jak funguje podpora více tenantů:</b><br />Podpora více tenantů umožňuje přístup k vašemu webu Moodle více tenantům Microsoft Entra. <br /><br />
    Postup nastavení:
    <ol>
        <li>Přihlaste se do Moodlu jako uživatel se správou webu, který nepoužívá ověřovací modul OpenID Connect.</li>
        <li>Zajistěte, aby nastavení <b>Koncový bod autorizace</b> a <b>Koncový bod tokenu</b> ověřovacího modulu OpenID Connect používala výchozí nastavení nespecifická pro tenant.</li>
        <li>V Moodlu zakažte ověřovací modul OpenID Connect. (Použijte <a href="{$a}/admin/settings.php?section=manageauths">stránku správy ověřovacích modulů</a>.)</li>
        <li>Přejděte do Microsoft Entra ID a vyhledejte aplikaci, kterou jste pro Moodle nakonfigurovali.</li>
        <li>V aplikaci Microsoft Entra ID povolte podporu více tenantů a uložte změny.</li>
        <li>Udělte aplikaci alespoň jedno z následujících delegovaných oprávnění Graph: <b>Directory.Read.All</b>, <b>Domain.Read.All</b> nebo <b>Domain.ReadWrite.All</b>. Souhlas správce pro vaši organizaci není vyžadován.</li>
        <li>Pokud jste již přihlášeni svým účtem Microsoft z dalšího tenanta, úplně se odhlaste a znovu se přihlaste.</li>
        <li>Pro každý tenant, který chcete povolit, klikněte na „Přidat nový tenant“ a přihlaste se účtem správce daného tenanta.</li>
        <li>Po přidání všech požadovaných tenantů v Moodlu znovu povolte ověřovací modul OpenID Connect.</li>
        <li>Hotovo! Chcete-li v budoucnu přidat další tenanty, stačí kliknout na tlačítko „Přidat nový tenant“ a přihlásit se účtem správce daného tenanta.</li>
    </ol>
    <b>Důležité upozornění:</b> Povolení podpory více tenantů v aplikaci Microsoft Entra ID umožní přístup k vaší aplikaci všem tenantům Microsoft Entra. Přidáním tenantů zde můžeme omezit přístup do Moodlu na tenanty, které nakonfigurujete. <b>Pokud z tohoto seznamu odeberete všechny tenanty dříve, než zakážete podporu více tenantů v aplikaci Microsoft Entra ID, nebo povolíte ověřování OpenID Connect v Moodlu s prázdným seznamem, bude váš web Moodle otevřen všem tenantům Microsoft Entra.</b>';
$string['acp_tenants_none'] = 'Nenakonfigurovali jste žádné tenanty. Pokud jste v aplikaci Microsoft Entra ID povolili podporu více tenantů, váš web Moodle může být otevřen všem uživatelům Microsoft 365.';
$string['acp_tenants_revokeaccess'] = 'Odvolat přístup';
$string['acp_tenants_tenant'] = 'Tenant';
$string['acp_tenants_actions'] = 'Akce';
$string['acp_tenants_delete'] = 'Odstranit';
$string['acp_tenantsadd_desc'] = 'Chcete-li udělit přístup dalšímu tenantu, klikněte na tlačítko níže a přihlaste se do Microsoft 365 účtem správce nového tenanta. Budete vráceni na seznam dalších tenantů, kde bude nový tenant uveden. Poté budete moci používat Moodle s novým tenantem.';
$string['acp_tenantsadd_linktext'] = 'Pokračovat na přihlašovací stránku Microsoft 365';
$string['acp_tenants_legacy_tenants'] = 'Starší tenanty (vyžadována akce)';
$string['acp_tenants_legacy_tenants_help'] = 'Další tenanty níže, které byly přidány dříve, nemusí v aktualizovaném postupu pro více tenantů fungovat a je třeba je opravit.<br/>
Přidejte je prosím znovu pomocí tlačítka „Přidat nový tenant“ výše.';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = 'Kontrola stavu';
$string['healthcheck_fixlink'] = 'Klikněte sem a opravte to.';
$string['healthcheck_ratelimit_title'] = 'Omezování API';
$string['healthcheck_ratelimit_result_notice'] = 'Bylo zapnuto mírné omezování kvůli zvýšenému zatížení webu Moodle. <br /><br />Všechny funkce Microsoft 365 fungují, požadavky jsou jen mírně rozloženy v čase, aby nedošlo k přerušení služeb Microsoft 365. Jakmile aktivita v Moodlu klesne, vše se vrátí do normálu. <br />(Úroveň {$a->level} / zahájeno {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'Bylo zapnuto zvýšené omezování kvůli výraznému zatížení webu Moodle. <br /><br />Všechny funkce Microsoft 365 stále fungují, ale vyřízení požadavků Microsoft 365 může trvat déle. Jakmile aktivita na webu Moodle klesne, vše se vrátí do normálu. <br />(Úroveň {$a->level} / zahájeno {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'Funkce omezování četnosti požadavků byly zakázány.';
$string['healthcheck_ratelimit_result_passed'] = 'Volání API Microsoft 365 probíhají plnou rychlostí.';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'Spravovat připojení uživatelů';
$string['acp_userconnections_column_muser'] = 'Uživatel Moodlu';
$string['acp_userconnections_column_o365user'] = 'Uživatel Microsoft 365';
$string['acp_userconnections_column_status'] = 'Stav připojení';
$string['acp_userconnections_column_actions'] = 'Akce';
$string['acp_userconnections_column_usinglogin'] = 'Používá přihlášení';
$string['acp_userconnections_column_status_help'] = 'Stav připojení ukazuje, jak je účet Moodlu propojen s účtem Microsoft 365 (Microsoft Entra ID).

* **Připojeno** – Uživatel dokončil připojení přihlášením do Moodlu svým účtem Microsoft 365, nebo účet aktivně připojil správce. Funkce jako synchronizace kalendáře a OneDrive pro tohoto uživatele fungují.
* **Spárováno** – Správce (nebo nástroj hromadného párování uživatelů) zaznamenal, ke kterému účtu Microsoft 365 tento uživatel Moodlu patří, ale připojení ještě není aktivní. Dokončí se při prvním přihlášení uživatele přes Microsoft 365. Dokud je uživatel pouze spárován, nic se nesynchronizuje.
* **Synchronizováno** – Účet Moodlu byl vytvořen z Microsoft Entra ID úlohou synchronizace uživatelů, ale uživatel se zatím nepřihlásil. Účet se aktivuje při prvním přihlášení.
* **Bez připojení** – Účet Moodlu není propojen s žádným účtem Microsoft 365.';
$string['acp_userconnections_column_actions_help'] = 'Akce dostupné pro řádek závisí na jeho stavu připojení.

* **Odpojit** – Odstraní propojení mezi účtem Moodlu a účtem Microsoft 365. Osoba si ponechá svůj účet Moodlu, ale nemůže používat funkce Microsoft 365 ani se přihlašovat přes Microsoft 365, dokud se znovu nepřipojí. Zobrazuje se u připojených uživatelů.
* **Znovu synchronizovat** – Okamžitě spustí synchronizaci dat Microsoft 365 pro tohoto uživatele (pole profilu, fotografie, kalendář atd.) místo čekání na naplánovanou úlohu a zobrazí výsledek. Zobrazuje se u připojených a synchronizovaných uživatelů.
* **Spárovat** – Zaznamená, ke kterému účtu Microsoft 365 tento uživatel Moodlu patří. Připojení není aktivní, dokud se osoba nepřihlásí přes Microsoft 365. Zobrazuje se u uživatelů bez připojení.
* **Zrušit spárování** – Odstraní spárování, které ještě nebylo dokončeno. Zobrazuje se u spárovaných uživatelů.';
$string['acp_userconnections_accountstatus_active'] = 'Aktivní';
$string['acp_userconnections_accountstatus_suspended'] = 'Pozastaveno';
$string['acp_userconnections_connectionstatus_connected'] = 'Připojeno';
$string['acp_userconnections_connectionstatus_matched'] = 'Spárováno';
$string['acp_userconnections_connectionstatus_noconnection'] = 'Bez připojení';
$string['acp_userconnections_connectionstatus_synced'] = 'Synchronizováno';
$string['acp_userconnections_filtering_accountstatus'] = 'Stav účtu';
$string['acp_userconnections_filtering_connectionstatus'] = 'Stav připojení';
$string['acp_userconnections_filtering_muserfullname'] = 'Celé jméno uživatele Moodlu';
$string['acp_userconnections_filtering_musername'] = 'Uživatelské jméno v Moodlu';
$string['acp_userconnections_filtering_o365username'] = 'Uživatelské jméno Microsoft 365';
$string['acp_userconnections_manualmatch_title'] = 'Ruční spárování uživatele';
$string['acp_userconnections_manualmatch_details'] = 'Tato stránka umožňuje spárovat jednoho uživatele Moodlu s jedním uživatelem Microsoft 365.';
$string['acp_userconnections_manualmatch_musername'] = 'Uživatel Moodlu';
$string['acp_userconnections_manualmatch_uselogin'] = 'Přihlásit se přes Microsoft 365';
$string['acp_userconnections_manualmatch_o365username'] = 'Uživatelské jméno Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'Uživatel Moodlu je již připojen k uživateli Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'Uživatel Moodlu je již připojen k uživateli Microsoft 365 (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'Uživatel Moodlu je již spárován s uživatelem Microsoft 365';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'Uživatel Microsoft 365 je již spárován s jiným uživatelem Moodlu';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'Uživatel Microsoft 365 je již připojen k jinému uživateli Moodlu';
$string['acp_userconnections_resync_nodata'] = 'Pro tohoto uživatele nebyly nalezeny uložené informace Microsoft 365.';
$string['acp_userconnections_resync_notfound'] = 'Nebyla synchronizována žádná data. Účet „{$a->username}“ je propojen s objektem Microsoft Entra ID {$a->objectid}, ale tento objekt nebyl nalezen. Uživatel byl nejspíše v Microsoft 365 odstraněn nebo zakázán, případně je uložené ID objektu zastaralé.';
$string['acp_userconnections_resync_nooutput'] = 'Opětovná synchronizace skončila, aniž by hlásila jakékoli změny.';
$string['acp_userconnections_table_disconnect'] = 'Odpojit';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'Tímto bude uživatel Moodlu „{$a}“ odpojen od Microsoft 365. Pokračujte kliknutím na odkaz níže.';
$string['acp_userconnections_table_match'] = 'Spárovat';
$string['acp_userconnections_table_resync'] = 'Znovu synchronizovat';
$string['acp_userconnections_table_unmatch'] = 'Zrušit spárování';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'Tímto bude zrušeno spárování uživatele Moodlu „{$a}“ s Microsoft 365. Pokračujte kliknutím na odkaz níže.';

// Settings in the "Manage Team Connections" feature of the "Advanced" tab.
$string['acp_teamconnections'] = 'Spravovat připojení týmů';
$string['acp_teamconnection'] = 'Spravovat připojení týmu';
$string['acp_teamconnections_actions'] = 'Akce';
$string['acp_teamconnections_cache_last_updated'] = 'Mezipaměť týmů byla naposledy aktualizována {$a->lastupdated}. Klikněte <a href="{$a->updateurl}">sem</a> pro aktualizaci mezipaměti.';
$string['acp_teamconnections_cache_never_updated'] = 'Mezipaměť týmů nebyla nikdy aktualizována. Klikněte <a href="{$a->updateurl}">sem</a> pro aktualizaci.';
$string['acp_teamconnections_connected_team'] = 'Připojený tým';
$string['acp_teamconnections_course_connected'] = 'Kurz byl úspěšně připojen k týmu.';
$string['acp_teamconnections_course_disconnected'] = 'Kurz byl odpojen od týmu.';
$string['acp_teamconnections_team_linked'] = 'Kurz byl propojen s týmem.';
$string['acp_teamconnections_current_connection'] = 'AKTUÁLNÍ PŘIPOJENÍ';
$string['acp_teamconnections_exception_course_not_exist'] = 'Kurz, který má být připojen, neexistuje.';
$string['acp_teamconnections_exception_invalid_team_id'] = 'Neplatné ID týmu';
$string['acp_teamconnections_exception_not_configured'] = 'Microsoft 365 není plně nakonfigurován.';
$string['acp_teamconnections_exception_team_already_connected'] = 'Tým je již připojen k jinému kurzu';
$string['acp_teamconnections_form_connect_course'] = 'Spravovat připojení týmu pro kurz {$a}';
$string['acp_teamconnections_form_sds_warning'] = 'POZNÁMKA: Týmy vytvořené službou Student Data Sync (SDS) zde nelze ručně připojit, protože by to bylo v konfliktu se synchronizací SDS. Jsou vyloučeny z výsledků hledání níže.';
$string['acp_teamconnections_form_team'] = 'Vybrat tým';
$string['acp_teamconnections_form_team_noselection'] = 'Hledat tým...';
$string['acp_teamconnections_no_teams_found'] = 'Pro „{$a}“ nebyly nalezeny žádné týmy';
$string['acp_teamconnections_group_only'] = ' (Pouze skupina)';
$string['acp_teamconnections_team_missing'] = '(Tým chybí)';
$string['acp_teamconnections_not_connected'] = 'Nepřipojeno';
$string['acp_teamconnections_sync_disabled'] = 'Před správou připojení týmů je nejprve nutné povolit synchronizaci kurzů.';
$string['acp_teamconnections_table_connect'] = 'Připojit';
$string['acp_teamconnections_table_connect_to_different_team'] = 'Připojit k jinému týmu';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'Ze skupiny nelze vytvořit tým – chybí vlastník';
$string['acp_teamconnections_table_link_team'] = 'Odkaz na tým „{$a}“';
$string['acp_teamconnections_table_missing_team'] = 'Kurz je připojen k neexistujícímu týmu. To bude vyčištěno při příštím spuštění naplánované úlohy synchronizace kurzů.';
$string['acp_teamconnections_table_resync'] = 'Znovu synchronizovat';
$string['acp_teamconnections_table_update'] = 'Aktualizovat';
$string['acp_teamconnections_teams_cache_updated'] = 'Mezipaměť týmů byla úspěšně aktualizována.';
$string['acp_teamconnections_no_owner'] = 'Pro připojení k Teams přidejte vlastníka.';
$string['acp_teamconnections_resync'] = 'Znovu synchronizovat vlastníky / členy týmu';
$string['acp_teamconnections_resync_title'] = 'Znovu synchronizovat vlastníky / členy týmu pro kurz {$a}';
$string['acp_teamconnections_resync_desc'] = 'Porovná uživatele zapsané v kurzu s vlastníky a členy připojené skupiny/týmu Microsoft 365 a přidá všechny, kteří chybí. Zvolte, zda mají být odebráni také uživatelé, kteří jsou v týmu, ale nejsou zapsáni v kurzu Moodlu.';
$string['acp_teamconnections_resync_keep'] = 'Znovu synchronizovat (ponechat další členy týmu)';
$string['acp_teamconnections_resync_keep_desc'] = 'Uživatelé zapsaní v kurzu Moodlu, kteří v týmu chybí, budou přidáni. Stávající vlastníci / členové týmu, kteří nejsou zapsáni v kurzu Moodlu, nebudou změněni.';
$string['acp_teamconnections_resync_remove'] = 'Znovu synchronizovat a odebrat další členy týmu';
$string['acp_teamconnections_resync_remove_desc'] = 'Upozornění: každý vlastník nebo člen týmu, který není zapsán v kurzu Moodlu, bude z týmu odebrán, i když byl přidán přímo v Microsoft Teams.';
$string['acp_teamconnections_resync_completed'] = 'Vlastníci / členové týmu byli znovu synchronizováni.';
$string['acp_teamconnections_resync_failed'] = 'Vlastníky / členy týmu se nepodařilo znovu synchronizovat. Podrobnosti naleznete ve výstupu výše.';
$string['acp_teamconnections_last_resync'] = 'Naposledy znovu synchronizováno: {$a}';
$string['acp_teamconnections_never_resynced'] = 'Nikdy znovu nesynchronizováno';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'Párování uživatelů';
$string['acp_usermatch_desc'] = 'Tento nástroj umožňuje párovat uživatele Moodlu s uživateli Microsoft 365. Nahrajete soubor obsahující uživatele Moodlu a přidružené uživatele Microsoft 365 a úloha cron data ověří a nastaví spárování.';
$string['acp_usermatch_upload'] = 'Krok 1: Nahrát nová spárování';
$string['acp_usermatch_upload_desc'] = 'Nahrajte datový soubor obsahující uživatelská jména Moodlu a Microsoft 365, abyste spárovali uživatele Moodlu s uživateli Microsoft 365.<br />
<br />
Tento soubor by měl být jednoduchý textový soubor CSV obsahující na každém řádku tři položky:
<ul>
<li>uživatelské jméno v Moodlu,</li>
<li>uživatelské jméno Microsoft 365,</li>
<li>1 nebo 0, kde 1 znamená změnu metody ověřování uživatele na OpenID Connect a 0 znamená ponechání stávající metody ověřování a použití jako propojeného účtu.</li>
</ul>
Neuvádějte žádné záhlaví ani další data.<br />
Příklad: <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'Typ {$a} není podporován. Nahrajte prosím textový soubor CSV.';
$string['acp_usermatch_upload_err_data'] = 'Řádek č. {$a} obsahoval neplatná data. Každý řádek v souboru CSV by měl obsahovat alespoň dvě položky: uživatelské jméno v Moodlu a uživatelské jméno Microsoft 365.';
$string['acp_usermatch_upload_err_fileopen'] = 'Soubor nelze otevřít ke zpracování. Jsou oprávnění ve vašem adresáři moodledata správná?';
$string['acp_usermatch_upload_err_nofile'] = 'Nebyl přijat žádný soubor k přidání do fronty.';
$string['acp_usermatch_upload_submit'] = 'Přidat datový soubor do fronty párování';
$string['acp_usermatch_matchqueue'] = 'Krok 2: Fronta párování';
$string['acp_usermatch_matchqueue_clearall'] = 'Vymazat vše';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Vymazat chyby';
$string['acp_usermatch_matchqueue_clearqueued'] = 'Vymazat čekající';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Vymazat úspěšné';
$string['acp_usermatch_matchqueue_column_muser'] = 'Uživatelské jméno v Moodlu';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Uživatelské jméno Microsoft 365';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Stav';
$string['acp_usermatch_matchqueue_desc'] = 'Tato tabulka zobrazuje aktuální stav operace párování. Při každém spuštění naplánované úlohy <b>Zpracovat frontu párování</b> bude zpracována dávka následujících uživatelů.<br /><b>Poznámka:</b> Tato stránka se neaktualizuje dynamicky, pro zobrazení aktuálního stavu ji obnovte.';
$string['acp_usermatch_matchqueue_empty'] = 'Fronta párování je momentálně prázdná. Nahrajte datový soubor pomocí výběru souborů výše a přidejte uživatele do fronty.';
$string['acp_usermatch_matchqueue_status_error'] = 'Chyba: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'Ve frontě';
$string['acp_usermatch_matchqueue_status_success'] = 'Úspěšné';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'Nástroje údržby';
$string['acp_maintenance_desc'] = 'Tyto nástroje vám mohou pomoci vyřešit některé běžné problémy.';
$string['acp_maintenance_warning'] = 'Upozornění: Jde o pokročilé nástroje. Používejte je prosím, pouze pokud rozumíte tomu, co děláte.';
$string['acp_maintenance_resyncgroupusers'] = 'Znovu synchronizovat uživatele ve skupinách Microsoft 365 pro kurzy';
$string['acp_maintenance_resyncgroupusers_desc'] = 'Znovu se synchronizuje členství uživatelů ve všech skupinách Microsoft 365 vytvořených pro všechny kurzy Moodlu. Zajistí se tak, že ve skupině Microsoft 365 budou všichni uživatelé zapsaní v kurzu Moodlu, a pouze oni. <br /><b>Poznámka:</b> Pokud jste do skupiny Microsoft 365 přidali další uživatele, kteří nejsou zapsáni v přidruženém kurzu Moodlu, budou odebráni.';
$string['acp_maintenance_recreatedeletedgroups'] = 'Znovu vytvořit odstraněné skupiny Microsoft 365';
$string['acp_maintenance_recreatedeletedgroups_desc'] = 'Zkontroluje, zda nebyly ručně odstraněny některé skupiny Microsoft 365 připojené ke kurzům Moodlu, a znovu je vytvoří.';
$string['acp_maintenance_debugdata'] = 'Vygenerovat balíček ladicích dat';
$string['acp_maintenance_debugdata_desc'] = 'Vygeneruje balíček obsahující různé informace o vašem prostředí Moodle a Microsoft 365, který vývojářům pomůže vyřešit případné problémy. Pokud o to vývojář požádá, spusťte tento nástroj a pošlete výsledný stažený soubor. Poznámka: Přestože tento balíček neobsahuje citlivá data tokenů, žádáme vás, abyste tento soubor nezveřejňovali ani jej neposílali nedůvěryhodné straně.';
$string['acp_maintenance_cleandeltatoken'] = 'Vyčistit delta tokeny synchronizace uživatelů';
$string['acp_maintenance_cleandeltatoken_desc'] = 'Pokud synchronizace uživatelů po aktualizaci jejího nastavení plně nefunguje, může to být způsobeno starým tokenem delta synchronizace. Vyčištění tokenu vynutí při příštím spuštění synchronizace uživatelů úplnou opětovnou synchronizaci.';
$string['acp_maintenance_cleanapptokens'] = 'Vyčistit tokeny aplikace';
$string['acp_maintenance_cleanapptokens_desc'] = 'Odstraní uložené tokeny aplikace, které modul používá pro volání rozhraní API Microsoftu, jež neprobíhají jménem uživatele. Nové tokeny aplikace se automaticky vyžádají, až budou příště potřeba, a výsledky poslední kontroly „Ověření nastavení“ na kartě Nastavení se vymažou. Pokud volání prováděná s oprávněními aplikace selhávají s chybami ověření, například po změně oprávnění aplikace Microsoft Entra ID nebo jejích přihlašovacích údajů, může vyčištění tokenů pomoci. Tokeny uživatelů nejsou dotčeny.';

// Settings in the "Resync users in Microsoft 365 groups for courses" feature in the "Maintenance Tools" feature of the
// "Advanced" tab.
$string['acp_maintenance_resyncgroupusers_course_output'] = 'Výstup opětovné synchronizace';
$string['acp_maintenance_resyncgroupusers_no_course'] = 'Žádný kurz není připojen k Microsoft 365';
$string['acp_maintenance_coursesync_disabled'] = 'Tento nástroj je k dispozici, pouze pokud je povolena synchronizace kurzů. <a href="{$a}">Spravovat synchronizaci kurzů</a>.';

// Settings in the "Recreate deleted Microsoft 365 groups" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_recreatedeletedgroups_group_type'] = 'Typ objektu Moodlu';
$string['acp_maintenance_recreatedeletedgroups_group_type_course'] = 'Kurz';
$string['acp_maintenance_recreatedeletedgroups_group_type_course_group'] = 'Skupina kurzu';
$string['acp_maintenance_recreatedeletedgroups_course'] = 'Kurz';
$string['acp_maintenance_recreatedeletedgroups_course_group'] = 'Skupina kurzu';
$string['acp_maintenance_recreatedeletedgroups_status'] = 'Stav';
$string['acp_maintenance_recreatedeletedgroups_status_sync_disabled'] = 'Synchronizace kurzů je zakázána';
$string['acp_maintenance_recreatedeletedgroups_status_created_success'] = 'Skupina byla znovu vytvořena';
$string['acp_maintenance_recreatedeletedgroups_status_created_fail'] = 'Opětovné vytvoření skupiny selhalo';
$string['acp_maintenance_recreatedeletedgroups_all_groups_exist'] = 'Všechny skupiny připojené ke kurzům a skupinám kurzů Moodlu existují.';

// Settings in the "Cleanup User Sync Delta Tokens" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_cleandeltatoken_completed'] = 'Delta token a skip delta token synchronizace uživatelů byly vyčištěny.';
$string['acp_maintenance_cleanapptokens_confirm'] = 'Opravdu chcete vyčistit tokeny aplikace? Aktuálně je uloženo tokenů aplikace: {$a}.';
$string['acp_maintenance_cleanapptokens_completed'] = 'Tokeny aplikace a poslední výsledky „Ověření nastavení“ byly vyčištěny.';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_course_reset_teams'] = 'Akce s týmem/skupinou při resetu kurzu';
$string['settings_course_reset_teams_details'] = 'Akce, které se provedou s týmem nebo skupinou připojenou ke kurzu při resetu kurzu.';
$string['settings_course_reset_teams_option_do_nothing'] = 'Nedělat nic<br/>Tým nebo skupina zůstane připojena ke kurzu. Vyškrtnutí uživatelů z kurzu povede k odebrání jejich členství v týmu nebo skupině.';
$string['settings_course_reset_teams_option_per_course'] = 'Povolit nastavení pro jednotlivé kurzy<br/>Vyžaduje přidání bloku Microsoft do kurzu. Uživatelé s právem resetovat kurz mohou v bloku zvolit, co se má při resetu kurzu provést.';
$string['settings_course_reset_teams_option_force_archive'] = 'Odpojit kurz od týmu nebo skupiny a vytvořit nový<br/>Stávající tým nebo skupina připojená ke kurzu bude přejmenována podle konfigurace. Pokud je připojen tým, bude archivován. Vytvoří se nový tým nebo skupina a připojí se ke kurzu.';
$string['settings_course_reset_teams_option_archive_only'] = 'Pouze odpojit kurz od týmu nebo skupiny<br />Stávající tým nebo skupina připojená ke kurzu bude přejmenována podle konfigurace. Pokud je připojen tým, bude archivován. Nový tým ani skupina se nevytvoří.';
$string['settings_reset_team_name_prefix'] = 'Předpona názvu týmu při resetu';
$string['settings_reset_team_name_prefix_details'] = 'Při resetu kurzu, který je připojen k týmu, bude k názvu stávajícího připojeného týmu přidána tato předpona.';
$string['settings_reset_group_name_prefix'] = 'Předpona názvu skupiny při resetu';
$string['settings_reset_group_name_prefix_details'] = 'Při resetu kurzu, který je připojen ke skupině, bude k názvu stávající skupiny přidána tato předpona.';
$string['settings_calsync_courseeventmode'] = 'Události Outlooku pro události kalendáře kurzu';
$string['settings_calsync_courseeventmode_details'] = 'Určuje, jak se událost kalendáře kurzu Moodlu vytvoří v Outlooku pro uživatele, kteří odebírají kalendář kurzu.
<ul>
<li><strong>Jedna sdílená událost s uživateli kurzu jako účastníky:</strong> v kalendáři Outlooku uživatele, který událost v Moodlu vytvořil (nebo v kalendáři skupiny Microsoft 365 kurzu, pokud je kurz propojen se skupinou), se vytvoří jediná událost a uživatelé kurzu jsou do ní přidáni jako účastníci.</li>
<li><strong>Jedna samostatná událost pro každého uživatele:</strong> samostatná událost se vytvoří přímo ve vlastním kalendáři Outlooku každého přihlášeného uživatele. Neexistuje žádná sdílená událost ani seznam účastníků a do kalendáře skupiny Microsoft 365 se nic nepřidává.</li>
</ul>
Změna tohoto nastavení ovlivní pouze události synchronizované poté; události, které již v Outlooku jsou, se nepřevádějí.';
$string['settings_calsync_courseeventmode_shared'] = 'Jedna sdílená událost s uživateli kurzu jako účastníky';
$string['settings_calsync_courseeventmode_individual'] = 'Jedna samostatná událost pro každého uživatele';
$string['settings_debugmode'] = 'Zaznamenávat zprávy ladění';
$string['settings_debugmode_details'] = 'Pokud je toto nastavení povoleno, do protokolu Moodlu jsou zaznamenávány informace, které vám mohou pomoci identifikovat problémy. <a href="{$a}">Zobrazit zaznamenané zprávy protokolu.</a>';
$string['settings_switchauthminupnsplit0'] = 'Minimální délka nepřesného uživatelského jména pro přepnutí na Microsoft 365';
$string['settings_switchauthminupnsplit0_details'] = 'Pokud povolíte nastavení „Přepnout spárované uživatele na ověřování Microsoft 365 (OpenID Connect)“, určuje toto nastavení minimální délku uživatelských jmen bez tenanta (části @example.onmicrosoft.com), která budou přepnuta. Pomáhá to zabránit přepnutí účtů s obecnými názvy, jako je „admin“, které nemusí být v Moodlu a Microsoft Entra ID totožné. Nastavte 0 pro přepnutí spárovaných uživatelů bez ohledu na délku uživatelského jména. Uživatelé, jejichž metoda ověřování nebyla kvůli tomuto nastavení přepnuta, jsou ve výstupu úlohy synchronizace zaznamenáni jako „Matched user, but the username is not an exact match to the Microsoft Entra ID UPN and does not meet the exact-match requirements for switching to OIDC...“ a na stránce Spravovat připojení uživatelů se zobrazují jako „Spárováno se stávajícím uživatelem – čeká na dokončení“.';
$string['settings_customtheme'] = 'Vlastní motiv (pokročilé)';
$string['settings_customtheme_desc'] = 'Doporučený motiv je „boost_o365teams“. Můžete však vybrat jiný motiv, pokud máte vlastní motiv upravený pro použití na kartě Teams.<br/>
Upozorňujeme, že vlastní motiv nastavený na úrovni kurzu nebo kategorie má přednost před zdejším nastavením, tj. kurz bude v aplikaci Moodle v Teams ve výchozím nastavení používat motiv kurzu nebo kategorie. To lze vyřešit úpravou $CFG->themeorder v souboru config.php na „array(\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\');“.';

// Settings in the "SDS sync" tab.
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>Toto je funkce ve verzi preview</b><br />Funkce ve verzi preview nemusí fungovat podle očekávání nebo mohou bez varování přestat fungovat. Postupujte prosím opatrně.</div>';
$string['settings_sds_intro_desc'] = 'Microsoft School Data Sync („SDS“) zjednodušuje správu tříd v Microsoft 365 tím, že načítá seznamy z externího SIS a vytváří třídy a skupiny v Microsoft 365. <a href="https://sds.microsoft.com/" target="_blank">Další informace</a><br/>
<br/>
Funkce synchronizace SDS dokáže synchronizovat data seznamů ze SDS do Moodlu, včetně tříd, učitelů a studentů.<br/>
<br/>
Abyste mohli funkci synchronizace SDS používat, zajistěte, aby aplikace Microsoft Entra ID použitá pro integraci měla aplikační oprávnění Microsoft Graph <b>EduRoster.Read.All</b> a <b>Member.Read.Hidden</b>, která výchozí nastavení automaticky nepřidává. Je pro ně také nutné udělit souhlas správce.<br/>
<br/>
Ve výchozím nastavení probíhá synchronizace SDS denně v rámci cronu Moodlu ve 3:00 času serveru. Chcete-li tento plán změnit, navštivte <a href="{$a}">stránku správy naplánovaných úloh.</a><br/><br/>';
$string['settings_sds_coursecreation'] = 'Synchronizace tříd do kurzů';
$string['settings_sds_coursecreation_desc'] = 'Tyto možnosti řídí vytváření kurzů Moodlu na základě školních tříd SDS.';
$string['settings_sds_coursecreation_enabled'] = 'Synchronizované školy';
$string['settings_sds_coursecreation_enabled_desc'] = 'Vytvářet kurzy pro třídy v těchto školách.';
$string['settings_sds_teams_enabled'] = 'Mají třídy SDS již týmy?';
$string['settings_sds_teams_enabled_desc'] = 'Zaškrtněte, pokud třídy SDS již mají týmy vytvořené konfigurací SDS. Je-li zaškrtnuto, Moodle se nebude pokoušet vytvářet týmy z kurzů Moodlu vytvořených ze tříd SDS, aby nedošlo ke konfliktům.';
$string['settings_sds_courseenrolsync'] = 'Synchronizace zápisů do kurzů';
$string['settings_sds_courseenrolsync_desc'] = 'Tyto možnosti řídí synchronizaci zápisů do kurzů ze školních tříd SDS.';
$string['settings_sds_enrolment_enabled'] = 'Synchronizovat zápisy ze SDS do Moodlu';
$string['settings_sds_enrolment_enabled_desc'] = 'Je-li povoleno, naplánovaná úloha synchronizace SDS zapíše učitele a studenty ze tříd SDS do odpovídajících kurzů Moodlu a odebere uživatele, kteří již ve třídě SDS nejsou. Vyžaduje konfiguraci nastavení <b>Role učitele třídy SDS v Moodlu</b> a <b>Role studenta třídy SDS v Moodlu</b>.';
$string['settings_sds_sync_enrolment_to_sds'] = 'Synchronizovat zápisy z Moodlu do SDS';
$string['settings_sds_sync_enrolment_to_sds_desc'] = 'Je-li povoleno, změny zápisů provedené v kurzech Moodlu připojených ke třídám SDS budou synchronizovány zpět do tříd SDS. Stav vlastnictví / členství uživatele v SDS bude záviset na právech „local/o365:teamowner“ a „local/o365:teammember“ v kontextu kurzu.';
$string['settings_sds_suspend_enrolment'] = 'Místo vyškrtnutí pozastavit zápisy uživatelů';
$string['settings_sds_suspend_enrolment_desc'] = 'Je-li tato možnost povolena, uživatelům, kteří jsou odebráni ze třídy SDS, bude zápis v připojeném kurzu Moodlu pozastaven, místo aby byli úplně vyškrtnuti. Tím se zachovají data uživatele, jako jsou známky, odevzdané úkoly a plnění činností. Když jsou uživatelé do třídy SDS znovu přidáni, jejich zápis se automaticky znovu aktivuje.<br />
<b>Poznámka:</b> Učitelé nejsou synchronizací SDS nikdy pozastaveni ani vyškrtnuti. Toto nastavení se týká pouze studentů.';
$string['settings_sds_enable_course_sync'] = 'Povolit obousměrnou synchronizaci kurzů';
$string['settings_sds_enable_course_sync_desc'] = 'Je-li povoleno, každý kurz Moodlu vytvořený ze třídy SDS bude v databázi propojen se svou skupinou Microsoft 365, čímž se pro tento kurz aktivuje plná integrace synchronizace kurzů Microsoft 365 (Teams, soubory, kalendář atd.). Pokud třída SDS již má tým, vytvoří se také záznam o přidružení k Teams.';
$string['settings_sds_course_field_mailnickname'] = 'Poštovní přezdívka (mailNickname)';
$string['settings_sds_course_field_displayname'] = 'Zobrazovaný název (displayName)';
$string['settings_sds_course_field_classcode'] = 'Kód třídy (classCode)';
$string['settings_sds_course_field_externalname'] = 'Externí název (externalName)';
$string['settings_sds_course_shortname_field'] = 'Zdroj krátkého názvu kurzu';
$string['settings_sds_course_shortname_field_desc'] = 'Vlastnost třídy SDS použitá jako krátký název nově vytvořených kurzů Moodlu. Moodle vyžaduje, aby krátké názvy kurzů byly jedinečné. Pokud je zvolená vlastnost prázdná nebo je její hodnota již použita kurzem propojeným s jinou třídou SDS, použije se místo ní poštovní přezdívka. Změna tohoto nastavení nepřejmenuje již vytvořené kurzy.';
$string['settings_sds_course_fullname_field'] = 'Zdroj celého názvu kurzu';
$string['settings_sds_course_fullname_field_desc'] = 'Vlastnost třídy SDS použitá jako celý název nově vytvořených kurzů Moodlu. Pokud je zvolená vlastnost prázdná, použije se místo ní zobrazovaný název. Změna tohoto nastavení nepřejmenuje již vytvořené kurzy.';
$string['settings_sds_categorize_by_subject'] = 'Kategorizovat kurzy podle předmětu';
$string['settings_sds_categorize_by_subject_desc'] = 'Je-li povoleno, kurzy budou uspořádány do kategorií podle předmětů v rámci kategorie každé školy. Název předmětu se získá z informací o třídě v SDS. Je-li zakázáno, všechny kurzy se umístí přímo do kategorie školy.';
$string['settings_sds_ignore_past_courses'] = 'Ignorovat prošlé/minulé třídy';
$string['settings_sds_ignore_past_courses_desc'] = 'Je-li povoleno, třídy, které vypršely nebo skončily, budou při synchronizaci přeskočeny. To zahrnuje:<br />
<ul>
<li>Třídy, jejichž název obsahuje nakonfigurovanou předponu prošlých tříd (výchozí: „Exp“)</li>
<li>Třídy s datem ukončení v minulosti</li>
</ul>
Pomáhá to udržet katalog kurzů přehledný, protože se nevytvářejí kurzy pro staré nebo archivované třídy.';
$string['settings_sds_expired_course_prefix'] = 'Předpona názvu prošlé třídy';
$string['settings_sds_expired_course_prefix_desc'] = 'Třídy, jejichž název začíná touto předponou, budou považovány za prošlé a při synchronizaci přeskočeny (pokud je povoleno „Ignorovat prošlé/minulé třídy“). Výchozí: „Exp“';
$string['settings_sds_cohortsync'] = 'Synchronizace globálních skupin';
$string['settings_sds_cohortsync_desc'] = 'Tyto možnosti řídí vytváření a synchronizaci globálních skupin ze tříd SDS. Globální skupiny představují alternativní způsob seskupení uživatelů, který lze použít pro zápis na úrovni celého webu nebo jiné funkce Moodlu.';
$string['settings_sds_create_cohorts'] = 'Vytvářet globální skupiny ze tříd SDS';
$string['settings_sds_create_cohorts_desc'] = 'Je-li povoleno, pro každou třídu SDS se vytvoří globální skupina a její členství bude synchronizováno s třídou SDS. Globální skupiny se vytvářejí v kontextu kategorie kurzů (kategorie školy nebo předmětu v závislosti na nastavení kategorizace).<br />
<b>Poznámka:</b> Globální skupiny se vytvářejí navíc ke kurzům, nikoli místo nich. Umožňuje to používat globální skupiny pro zápis nebo seskupování na úrovni celého webu a přitom zachovat kurzy synchronizované se SDS.';
$string['settings_sds_cohort_include_teachers'] = 'Zahrnout učitele do globálních skupin';
$string['settings_sds_cohort_include_teachers_desc'] = 'Je-li povoleno, učitelé ze třídy SDS budou do globální skupiny přidáni spolu se studenty. Je-li zakázáno, do globálních skupin budou přidáni pouze studenti.';
$string['settings_sds_enrolment_teacher_role'] = 'Role učitele třídy SDS v Moodlu';
$string['settings_sds_enrolment_teacher_role_desc'] = 'Je-li povoleno „Synchronizovat zápisy ze SDS do Moodlu“, učitelé ve třídě SDS budou zapsáni do připojeného kurzu Moodlu s touto rolí.';
$string['settings_sds_enrolment_student_role'] = 'Role studenta třídy SDS v Moodlu';
$string['settings_sds_enrolment_student_role_desc'] = 'Je-li povoleno „Synchronizovat zápisy ze SDS do Moodlu“, studenti ve třídě SDS budou zapsáni do připojeného kurzu Moodlu s touto rolí.';
$string['settings_sds_profilesync_header'] = 'Synchronizace profilů uživatelů';
$string['settings_sds_profilesync_header_desc'] = 'Každá škola SDS může ukládat profil uživatele pro učitele a členy školy. Pole je specifické pro školu, tj. různé školy mohou mít pro stejného uživatele ve stejném poli různé hodnoty.<br/>
Pokud je v této sekci vybrána škola, lze pole profilu uživatele SDS nakonfigurovat v mapování polí uživatele.
<ul>
<li>Upozorňujeme, že synchronizace polí SDS proběhne pouze při spuštění naplánované úlohy „Synchronizace se SDS“, nikoli při spuštění naplánované úlohy „Synchronizovat uživatele z Microsoft Entra ID“ ani při přihlášení uživatele.</li>
<li>Upozorňujeme na známý problém v Microsoft Graph API používaném touto funkcí: některá pole školního profilu studentů a učitelů nejsou vracena, a proto je nelze synchronizovat, ani když jsou nakonfigurována.</li>
</ul>
';
$string['settings_sds_profilesync_disabled'] = 'Zakázáno';
$string['settings_sds_profilesync'] = 'Synchronizovat data profilu ze školy';
$string['settings_sds_profilesync_desc'] = 'Vyberte školu SDS, ze které Moodle synchronizuje data profilu specifická pro SDS.';
$string['settings_sds_noschools'] = '<div class="alert alert-info">V SDS nemáte k dispozici žádné školy.</div>';
$string['settings_sds_get_schools_error'] = '<div class="alert alert-info error">Nepodařilo se získat školy SDS. Zkontrolujte, zda má aplikace Microsoft Entra ID požadované oprávnění.</div>';
$string['settings_sds_school_disabled_action'] = 'Akce při zakázání synchronizace školy';
$string['settings_sds_school_disabled_action_desc'] = 'Akce, která se provede s již připojenými kurzy Moodlu, když je synchronizace zakázána u školy SDS.';
$string['settings_sds_school_disabled_action_keep_connected'] = 'Ponechat kurz Moodlu připojený k týmu';
$string['settings_sds_school_disabled_action_disconnect'] = 'Odpojit kurz Moodlu od týmu';
$string['settings_sds_school_unavailable'] = '{$a} (seznam škol SDS momentálně není k dispozici)';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner'] = 'Aplikace Moodle pro <a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teams</a> vám umožňuje snadno přistupovat ke kurzům Moodlu a spolupracovat na nich v Teams.';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Nastavení aplikace Moodle pro Microsoft Teams</h4>';
$string['settings_moodlesettingssetup'] = 'Konfigurovat Moodle';
$string['settings_check_moodle_settings'] = 'Zkontrolovat nastavení Moodlu';
$string['settings_moodlesetup_checking'] = 'Kontrola...';
$string['settings_notice_cookiesecureenabled'] = 'Pouze zabezpečené cookies – úspěšně povoleno';
$string['settings_notice_cookiesecurealreadyenabled'] = 'Pouze zabezpečené cookies – již bylo povoleno';
$string['settings_notice_oidcenabled'] = 'OpenID Connect byl úspěšně povolen';
$string['settings_notice_oidcnotenabled'] = 'OpenID Connect nebylo možné povolit';
$string['settings_notice_oidcalreadyenabled'] = 'OpenID Connect již byl povolen';
$string['settings_notice_webservicesframealreadyenabled'] = 'Webové služby již byly povoleny a vkládání do rámců je také povoleno';
$string['settings_notice_webservicesframeenabled'] = 'Webové služby byly úspěšně povoleny a nyní je povoleno i vkládání do rámců';
$string['settings_notice_restenabled'] = 'Protokol REST byl úspěšně povolen';
$string['settings_notice_restnotenabled'] = 'Protokol REST nebylo možné povolit';
$string['settings_notice_restalreadyenabled'] = 'Protokol REST již byl povolen';
$string['settings_notice_o365serviceenabled'] = 'Webové služby Microsoft 365 byly úspěšně povoleny';
$string['settings_notice_o365servicealreadyenabled'] = 'Webové služby Microsoft 365 již byly povoleny';
$string['settings_notice_createtokenallowed'] = 'Oprávnění k vytvoření tokenu webové služby bylo uděleno';
$string['settings_notice_createtokenalreadyallowed'] = 'Oprávnění k vytvoření tokenu webové služby již bylo uděleno';
$string['settings_notice_createtokennotallowed'] = 'Při udělování oprávnění k vytvoření tokenu webové služby došlo k problému';
$string['settings_notice_restusageallowed'] = 'Oprávnění k použití protokolu REST bylo uděleno';
$string['settings_notice_restusagealreadyallowed'] = 'Oprávnění k použití protokolu REST již bylo uděleno';
$string['settings_notice_restusagenotallowed'] = 'Při udělování oprávnění k použití protokolu REST došlo k problému';
$string['settings_moodlesettingssetup_details'] = 'Tímto se zajistí, že:
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>Je povoleno nastavení Pouze zabezpečené cookies.</li>
<li>Je povolen OpenID Connect.</li>
<li>Je povoleno vkládání do rámců.</li>
<li>Jsou povoleny webové služby.</li>
<li>Je povolen protokol REST.</li>
<li>Jsou povoleny webové služby Microsoft 365.</li>
<li>Ověřený uživatel má oprávnění vytvořit token webové služby.</li>
<li>Ověřený uživatel má oprávnění používat protokol REST.</li>
</ul>';
$string['settings_teams_moodle_app_external_id'] = 'ID aplikace Microsoft pro aplikaci Moodle pro Teams';
$string['settings_teams_moodle_app_external_id_desc'] = 'Mělo by být nastaveno na výchozí hodnotu, pokud ve vašem tenantu nepotřebujete více aplikací Moodle pro Teams pro připojení k různým webům Moodle.';
$string['settings_teams_moodle_app_short_name'] = 'Název aplikace Teams';
$string['settings_teams_moodle_app_short_name_desc'] = 'Může zůstat výchozí, pokud ve vašem tenantu nepotřebujete více aplikací Moodle pro Teams pro připojení k různým webům Moodle.';
$string['settings_download_teams_tab_app_manifest'] = 'Stáhnout soubor manifestu';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Před stažením manifestu prosím uložte všechny změny.';
$string['settings_publish_manifest_instruction'] = '<a href="https://learn.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Klikněte sem</a> a zjistěte, jak publikovat stažený soubor manifestu aplikace Moodle pro všechny uživatele v Teams.';
$string['settings_teams_moodle_tab_name'] = 'Název karty Moodle v Teams';
$string['settings_teams_moodle_tab_name_desc'] = 'Toto je název karty Moodle v Teams.';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'ID aplikace Moodle';
$string['settings_moodle_app_id_desc'] = 'ID nahrané aplikace Moodle v katalozích aplikací Teams.<br/>
Pokud je nakonfigurováno, Moodle se pokusí v kanálu „Obecné“ vytvořeného/připojeného týmu vytvořit kartu Moodle s odkazem na kurz Moodlu.';
$string['settings_moodle_app_id_desc_auto_id'] = '<br/>
Automaticky zjištěná hodnota je „<span class="local_o365_settings_moodle_app_id">{$a}</span>“.';
$string['settings_set_moodle_app_id_instruction'] = 'Chcete-li ID aplikace Moodle zjistit ručně, postupujte takto:
<ol>
<li>Nahrajte stažený soubor manifestu do katalogu aplikací Teams vašeho tenanta.</li>
<li>V katalogu aplikací Teams vyhledejte aplikaci.</li>
<li>Klikněte na ikonu možností aplikace, která se nachází v pravém horním rohu obrázku aplikace.</li>
<li>Klikněte na „Kopírovat odkaz“.</li>
<li>Vložte zkopírovaný obsah do textového editoru. Měl by obsahovat URL, například https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
Poslední část URL, tj. <span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>, je ID aplikace.';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Povolit synchronizaci s kalendářem Outlooku';
$string['calendar_user'] = 'Osobní kalendář (uživatele)';
$string['calendar_site'] = 'Kalendář pro celý web';
$string['personal_calendar'] = 'Osobní';
$string['calendar_event'] = 'Zobrazit podrobnosti';
$string['eventcalendarsubscribed'] = 'Uživatel se přihlásil k odběru kalendáře';
$string['eventcalendarunsubscribed'] = 'Uživatel zrušil odběr kalendáře';

// Errors.
$string['erroracpauthoidcnotconfig'] = 'Nejprve prosím nastavte přihlašovací údaje aplikace v auth_oidc.';
$string['errorhttpclientbadtempfileloc'] = 'Nelze otevřít dočasné umístění pro uložení souboru.';
$string['errorhttpclientnofileinput'] = 'Žádný parametr souboru v httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Nelze obnovit token';
$string['errormfarequired'] = 'Microsoft vyžaduje vícefaktorové ověřování, než bude mít Moodle přístup k vašemu účtu Microsoft 365. Odhlaste se prosím z Moodlu, poté se znovu přihlaste svým účtem Microsoft 365 a dokončete výzvu k vícefaktorovému ověřování.';
$string['errorgetapplicationtoken'] = 'Nepodařilo se získat token aplikace. Ověřte prosím konfiguraci integrace.';
$string['erroracpapcantgettenant'] = 'Nepodařilo se zjistit tenant Microsoft Entra, zadejte jej prosím ručně.';
$string['erroracpcantgettenant'] = 'Nepodařilo se zjistit URL OneDrive, zadejte ji prosím ručně.';
$string['errorprovisioningapp'] = 'Aplikaci Moodle se v týmu nepodařilo zřídit.';
$string['erroro365apibadcall'] = 'Chyba při volání API.';
$string['erroro365apibadcall_message'] = 'Chyba při volání API: {$a}';
$string['erroro365apiinvalidtoken'] = 'Token je neplatný, nebo jeho platnost vypršela.';
$string['erroro365apiinvalidmethod'] = 'Předáno neplatné httpmethod do apicall';
$string['erroro365apinotimplemented'] = 'Toto by mělo být přepsáno.';
$string['erroro365apinotoken'] = 'Pro zadaný zdroj a uživatele nebyl k dispozici token a nebylo možné žádný získat. Nevypršela platnost obnovovacího tokenu uživatele?';
$string['errorusermatched'] = 'Účet Microsoft 365 „{$a->entraidupn}“ je již spárován s uživatelem Moodlu „{$a->username}“. Chcete-li připojení dokončit, nejprve se přihlaste jako tento uživatel Moodlu a postupujte podle pokynů v bloku Microsoft.';
$string['errornodirectaccess'] = 'Přímý přístup na stránku je zakázán';
$string['eventapifail'] = 'Selhání API';
$string['errorunabletofindgraphapi'] = 'V aplikaci nebylo nalezeno Microsoft Graph API.';
$string['erroremptyjwt'] = 'Byl poskytnut prázdný token JWT';
$string['errornocachedjwks'] = 'Nebyly nalezeny žádné JWKS v mezipaměti';
$string['errorfetchjwks'] = 'Nepodařilo se načíst JWKS od Microsoftu';
$string['errorinvalidjwks'] = 'Od Microsoftu byl přijat neplatný formát JWKS';
$string['errorjwtvalidation'] = 'Ověření JWT selhalo';
$string['errorjwtinvalidissuer'] = 'Ověření vystavitele JWT selhalo';
$string['errorcannotgettoken'] = 'Nepodařilo se získat token aplikace ani systémový token.';
$string['errornotokenforsysmemuser'] = 'Pro systémového uživatele není k dispozici žádný token. Spusťte prosím kontrolu stavu local_o365.';
$string['errornotoken'] = 'Pro uživatele č. {$a} není k dispozici žádný token';
$string['errornotokenforusersync'] = 'Pro synchronizaci uživatelů není k dispozici žádný token.';
$string['errornoapifound'] = 'Nebylo nalezeno žádné API s identifikátorem {$a}.';
$string['errornoresponsesavailable'] = 'Nejsou k dispozici žádné odpovědi.';
$string['erroro365badphoto'] = 'Z Microsoft 365 byla přijata neplatná profilová fotografie.';
$string['erroro365nophoto'] = 'Tento uživatel nemá v Microsoft 365 fotografii.';
$string['errorcannotgetapiclient'] = 'Nelze získat klienta Graph API.';
$string['errorfailedtogetsecrets'] = 'Nepodařilo se získat tajné klíče.';
$string['errorfailedtosendnotification'] = 'Nepodařilo se odeslat e-mail s oznámením jednomu nebo více příjemcům.';
$string['errorsecretexpiryrecipientundeliverable'] = 'Jeden nebo více nakonfigurovaných příjemců oznámení o vypršení tajného klíče nemůže přijímat e-maily (neplatná adresa nebo doména bez záznamu MX/A): {$a}. Aktualizujte příjemce oznámení v nastavení OpenID Connect.';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Lokální modul Microsoft 365';
$string['privacy:metadata:local_o365_calidmap'] = 'Informace o propojení událostí kalendáře Microsoft 365 a událostí kalendáře Moodlu.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'ID uživatele, který událost vlastní.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'Odkud událost pochází. Buď z Moodlu, nebo z Microsoft 365.';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'ID události v Outlooku.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'ID události v Moodlu.';
$string['privacy:metadata:local_o365_calsub'] = 'Informace o odběrech synchronizace mezi kalendáři Moodlu a Outlooku';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'ID uživatele Moodlu, pro kterého je odběr určen';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'Typ kalendáře Moodlu (web, kurz, uživatel)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'Přidružené ID kalendáře Moodlu';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'ID kalendáře Microsoft 365';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Zda jde o primární kalendář';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'Chování synchronizace (tj. z Moodlu do Outlooku nebo z Outlooku do Moodlu)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'Čas vytvoření odběru.';
$string['privacy:metadata:local_o365_connections'] = 'Informace o dosud nepotvrzených připojeních mezi uživateli Moodlu a Microsoft 365';
$string['privacy:metadata:local_o365_connections:muserid'] = 'ID uživatele Moodlu';
$string['privacy:metadata:local_o365_connections:entraidupn'] = 'UPN uživatele Microsoft Entra ID.';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Zda se má po dokončení změnit metoda ověřování uživatele.';
$string['privacy:metadata:local_o365_token'] = 'Informace o tokenech API Microsoft 365 pro uživatele';
$string['privacy:metadata:local_o365_token:user_id'] = 'ID uživatele Moodlu';
$string['privacy:metadata:local_o365_token:scope'] = 'Rozsah tokenu.';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'Zdroj tokenu.';
$string['privacy:metadata:local_o365_token:token'] = 'Token.';
$string['privacy:metadata:local_o365_token:expiry'] = 'Čas vypršení platnosti tokenu.';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'Obnovovací token.';
$string['privacy:metadata:local_o365_objects'] = 'Informace o vztahu mezi objekty Moodlu a Microsoft 365';
$string['privacy:metadata:local_o365_objects:type'] = 'Typ objektu (skupina, uživatel, kurz atd.)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'Podtyp objektu.';
$string['privacy:metadata:local_o365_objects:objectid'] = 'ID objektu Microsoft 365';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'ID objektu v Moodlu';
$string['privacy:metadata:local_o365_objects:o365name'] = 'Název objektu v Microsoft 365 čitelný pro člověka';
$string['privacy:metadata:local_o365_objects:tenant'] = 'Tenant, ke kterému objekt patří (v prostředích s více tenanty)';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Jakákoli přidružená metadata';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'Čas vytvoření záznamu.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'Čas úpravy záznamu.';
$string['privacy:metadata:local_o365_appassign'] = 'Informace o přiřazeních rolí aplikace Microsoft 365';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'ID uživatele Moodlu';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Zda byl uživatel přiřazen k aplikaci';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'ID fotografie uživatele v Microsoft 365';
$string['privacy:metadata:local_o365_appassign:photohash'] = 'Hash SHA-256 bajtů profilové fotografie uživatele, uložený pro zjištění změn fotografie bez opětovného načítání celého obrázku';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Kdy byla fotografie uživatele naposledy aktualizována z Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue'] = 'Informace o párování uživatelů Moodlu s uživateli Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'Uživatelské jméno uživatele Moodlu.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'Uživatelské jméno uživatele Microsoft 365.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Zda se má uživatel při spárování přepnout na ověřování OpenID Connect';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Zda byl záznam zpracován';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'Chybová zpráva (pokud existuje)';
$string['privacy:metadata:preference:suspendedtime'] = 'Čas, kdy byl uživatel pozastaven synchronizací uživatelů, ať už proto, že odpovídající účet Microsoft Entra ID byl odstraněn, nebo proto, že byl zakázán.';
$string['privacy:metadata:local_o365_calsettings'] = 'Informace o nastavení synchronizace kalendáře';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'ID uživatele Moodlu';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'ID kalendáře v Microsoft 365';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'Čas vytvoření záznamu.';
$string['privacy:metadata:preference:calsync_initialised'] = 'Zda byly inicializovány volby uživatele pro synchronizaci kalendáře Outlooku, aby se znovu nepovolovaly automaticky.';

// Page "Microsoft 365 / Moodle Control Panel" in the Microsoft block.
$string['ucp_title'] = 'Ovládací panel Microsoft 365 / Moodle';
$string['ucp_general_intro'] = 'Zde můžete spravovat svoje připojení k Microsoft 365.';
$string['ucp_calsync_availcal'] = 'Dostupné kalendáře Moodle';
$string['ucp_calsync_title'] = 'Synchronizace kalendáře Outlook';
$string['ucp_calsync_desc'] = 'Zaškrtnuté kalendáře budou synchronizovány z Moodlu do vašeho kalendáře Outlook.';
$string['ucp_connection_options'] = 'Možnosti připojení:';
$string['ucp_connection_desc'] = 'Zde můžete nastavit, jak se připojujete k Microsoft 365. Chcete-li používat funkce Microsoft 365, musíte být připojeni k účtu Microsoft 365. Toho lze dosáhnout způsobem popsaným níže.';
$string['ucp_connection_entraidlogin'] = 'Používat své přihlašovací údaje Microsoft 365 k přihlášení do Moodlu<br />';
$string['ucp_connection_entraidlogin_desc_authcode'] = 'Místo zadávání uživatelského jména a hesla na přihlašovací stránce Moodlu uvidíte na přihlašovací stránce sekci s textem „Přihlásit se pomocí účtu na {$a}“. Kliknete na odkaz a budete přesměrováni do Microsoft 365, kde se přihlásíte. Po úspěšném přihlášení do Microsoft 365 se vrátíte do Moodlu a budete přihlášeni ke svému účtu.';
$string['ucp_connection_entraidlogin_start'] = 'Začít používat Microsoft 365 k přihlášení do Moodlu.';
$string['ucp_connection_entraidlogin_stop'] = 'Přestat používat Microsoft 365 k přihlášení do Moodlu.';
$string['ucp_connection_entraidlogin_active'] = 'K přihlášení do Moodlu používáte účet Microsoft 365 „{$a}“.';
$string['ucp_connection_linked'] = 'Propojit své účty Moodle a Microsoft 365';
$string['ucp_connection_linked_desc'] = 'Propojení vašich účtů Moodle a Microsoft 365 vám umožní používat funkce Moodlu s Microsoft 365, aniž byste museli měnit způsob přihlašování do Moodlu. <br />Kliknutím na odkaz níže budete přesměrováni do Microsoft 365 k jednorázovému přihlášení, po kterém se vrátíte sem. Budete moci používat všechny funkce Microsoft 365 bez dalších změn svého účtu Moodle – do Moodlu se budete přihlašovat jako dosud.';
$string['ucp_connection_linked_active'] = 'Jste propojeni s účtem Microsoft 365 „{$a}“.';
$string['ucp_connection_linked_start'] = 'Propojit svůj účet Moodle s účtem Microsoft 365.';
$string['ucp_connection_linked_migrate'] = 'Přepnout na propojený účet.';
$string['ucp_connection_linked_stop'] = 'Zrušit propojení svého účtu Moodle s účtem Microsoft 365.';
$string['ucp_connection_disconnected'] = 'Nejste připojeni k Microsoft 365.';
$string['ucp_features'] = 'Funkce Microsoft 365';
$string['ucp_features_intro'] = 'Níže naleznete seznam funkcí, které můžete použít ke zlepšení práce v Moodlu s Microsoft 365.';
$string['ucp_features_intro_notconnected'] = ' Některé z nich nemusí být k dispozici, dokud se nepřipojíte k Microsoft 365.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Chcete-li se připojit k Microsoft 365, musíte kontaktovat správce webu.';
$string['ucp_index_calendar_title'] = 'Synchronizace kalendáře Outlook';
$string['ucp_index_calendar_desc'] = 'Zde můžete nastavit synchronizaci mezi vašimi kalendáři Moodle a Outlook. Můžete exportovat události z kalendáře Moodle do Outlooku a naopak přenést události z Outlooku do Moodlu.';
$string['ucp_index_connection_title'] = 'Nastavení připojení k Microsoft 365';
$string['ucp_index_connection_desc'] = 'Nastavte, jak se připojujete k Microsoft 365.';
$string['ucp_index_connectionstatus_title'] = 'Stav připojení';
$string['ucp_index_connectionstatus_login'] = 'Kliknutím sem se přihlaste.';
$string['ucp_index_connectionstatus_usinglogin'] = 'K přihlášení do Moodlu aktuálně používáte Microsoft 365.';
$string['ucp_index_connectionstatus_usinglinked'] = 'Jste propojeni s účtem Microsoft 365.';
$string['ucp_index_connectionstatus_manage'] = 'Spravovat připojení';
$string['ucp_index_connectionstatus_reconnect'] = 'Obnovit připojení';
$string['ucp_index_connectionstatus_connected'] = 'Aktuálně jste připojeni k Microsoft 365';
$string['ucp_index_connectionstatus_matched'] = 'Byli jste spárováni s uživatelem <small>„{$a}“</small> v Microsoft 365. Chcete-li propojení dokončit, klikněte na následující odkaz a přihlaste se do Microsoft 365.';
$string['ucp_index_connectionstatus_notconnected'] = 'Aktuálně nejste připojeni k Microsoft 365';
$string['ucp_notconnected'] = 'Před navštívením této stránky se připojte k Microsoft 365.';
$string['ucp_status_enabled'] = 'Aktivní';
$string['ucp_status_disabled'] = 'Nepřipojeno';
$string['ucp_syncwith_title'] = 'Název kalendáře Outlook, se kterým se má synchronizovat:';
$string['ucp_syncdir_title'] = 'Chování synchronizace:';
$string['ucp_syncdir_out'] = 'Z Moodlu do Outlooku';
$string['ucp_syncdir_in'] = 'Z Outlooku do Moodlu';
$string['ucp_syncdir_both'] = 'Aktualizovat Outlook i Moodle';
$string['ucp_o365accountconnected'] = 'Tento účet Microsoft 365 je již připojen k jinému účtu Moodlu.';

// Tasks.
$string['task_calendarsyncin'] = 'Synchronizovat události Microsoft 365 do Moodlu';
$string['task_coursesync'] = 'Synchronizovat kurzy Moodlu do Microsoft Teams';
$string['task_coursemembershipsync'] = 'Synchronizovat vlastníky a členy Microsoft Teams do kurzů Moodlu';
$string['task_groupmembershipsync'] = 'Synchronizovat vlastníky a členy kurzů Moodlu do skupin Microsoft 365';
$string['task_sds_sync'] = 'Synchronizace se SDS';
$string['task_syncusers'] = 'Synchronizovat uživatele z Microsoft Entra ID';
$string['task_syncusersphotostimezones'] = 'Synchronizovat fotografie a časová pásma uživatelů z Microsoft Entra ID';
$string['task_calsyncautosubscribe'] = 'Automaticky povolit synchronizaci kalendáře pro připojené uživatele';
$string['task_groupchannelsync'] = 'Vytvořit kanály Teams pro skupiny Moodlu a synchronizovat jejich členy';
$string['task_groupchannelsyncgroup'] = 'Vytvořit kanál Teams pro skupinu Moodlu a synchronizovat její členy';
$string['task_userenabledstatussync'] = 'Pozastavit/znovu povolit/odstranit uživatele podle stavu v Microsoft Entra ID';
$string['task_processmatchqueue'] = 'Zpracovat frontu párování';
$string['task_notifysecretexpiry'] = 'Upozornit správce webu na vypršení tajného klíče aplikace Microsoft Entra ID';
$string['task_checkinvalidconfiglog'] = 'Zkontrolovat a vyčistit záznamy protokolu neplatné konfigurace';
$string['task_usergroupmembershipsync'] = 'Synchronizovat členství uživatelů ve skupinách kurzů do Microsoft 365';
$string['task_processmatchqueue_err_museralreadymatched'] = 'Uživatel Moodlu je již spárován s uživatelem Microsoft 365.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'Uživatel Moodlu je již připojen k Microsoft 365.';
$string['task_processmatchqueue_err_nomuser'] = 'Nebyl nalezen žádný uživatel Moodlu s tímto uživatelským jménem.';
$string['task_processmatchqueue_err_noo365user'] = 'Nebyl nalezen žádný uživatel Microsoft 365 s tímto uživatelským jménem.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'Uživatel Microsoft 365 je již spárován s uživatelem Moodlu.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'Uživatel Microsoft 365 je již připojen k uživateli Moodlu.';

// Capabilities.
$string['o365:manageconnectionlink'] = 'Spravovat propojování účtů';
$string['o365:manageconnectionunlink'] = 'Spravovat rušení propojení účtů';
$string['o365:managecoursesync'] = 'Povolit nebo zakázat synchronizaci Teams pro kurzy prostřednictvím webových služeb';
$string['o365:viewgroups'] = 'Zobrazit odkazy na služby Microsoft 365 v bloku Microsoft v kurzech s povolenou synchronizací';
$string['o365:managegroups'] = 'Zobrazit odkazy na služby Microsoft 365 a možnosti správy v bloku Microsoft v kurzech s povolenou synchronizací';
$string['o365:teammember'] = 'Člen týmu';
$string['o365:teamowner'] = 'Vlastník týmu';

// Cache Stores.
$string['cachedef_groups'] = 'Ukládá data skupin Microsoft 365';
$string['cachedef_jwks'] = 'Ukládá klíče JWKS Microsoftu';

// Web service errors.
$string['webservices_error_assignnotfound'] = 'Záznam úkolu přijatého modulu nebyl nalezen.';
$string['webservices_error_invalidassignment'] = 'Přijaté ID úkolu nelze s touto funkcí webové služby použít.';
$string['webservices_error_modulenotfound'] = 'Přijaté ID modulu nebylo nalezeno.';
$string['webservices_error_sectionnotfound'] = 'Sekce kurzu nebyla nalezena.';
$string['webservices_error_couldnotsavegrade'] = 'Známku se nepodařilo uložit.';

// User sync task help text.
$string['help_user_create'] = 'Nápověda k vytváření účtů';
$string['help_user_create_help'] = 'Pro každého uživatele v propojeném Microsoft Entra ID se vytvoří uživatel v Moodlu. Účty budou vytvořeny pouze pro uživatele, kteří zatím nemají účet v Moodlu. Nové účty budou nastaveny s metodou ověřování OpenID Connect pomocí jejich profilu Microsoft Entra ID a budou moci používat všechny funkce integrace Microsoft 365/Moodle.';
$string['help_user_update'] = 'Nápověda k aktualizaci všech účtů';
$string['help_user_update_help'] = 'Aktualizuje všechny uživatele v Moodlu podle jednotlivých uživatelů v propojeném Microsoft Entra ID.';
$string['help_user_suspend'] = 'Nápověda k pozastavení účtů';
$string['help_user_suspend_help'] = 'Pozastaví uživatele v Moodlu, pokud jsou v Microsoft Entra ID označeni jako odstranění.';
$string['help_user_delete'] = 'Nápověda k odstranění účtů';
$string['help_user_delete_help'] = 'Odstraní uživatele z Moodlu, pokud jsou v Microsoft Entra ID označeni jako odstranění. Funguje to pouze v případě, že je povolena možnost pozastavení uživatelů. Účet Moodlu bude odstraněn a všechny přidružené informace o uživateli budou z Moodlu odebrány. Buďte opatrní! Poznámka: Ve výchozím nastavení k odstranění dochází 30 dnů poté, co byl účet odstraněn v Microsoft Entra ID, kvůli době uchování obnovitelně odstraněných účtů v Entra ID (během této doby lze účty obnovit). Delší prodlevu mezi pozastavením a odstraněním lze nastavit pomocí nastavení „Prodleva před odstraněním pozastavených uživatelů“.';
$string['help_user_reenable'] = 'Nápověda k opětovnému povolení účtů';
$string['help_user_reenable_help'] = 'Znovu povolí pozastavené účty Moodlu, pokud jsou vráceny z Microsoft Entra ID a mají povoleno přihlášení. Účty, kterým je v Microsoft Entra ID zablokováno přihlášení (zakázané), zůstanou pozastaveny.';
$string['help_user_disabledsyncsuspend'] = 'Nápověda k pozastavení účtů při zakázání';
$string['help_user_disabledsyncsuspend_help'] = 'Pozastaví uživatele v Moodlu, pokud jejich připojeným účtům v Microsoft Entra ID bylo zabráněno v přihlášení (jsou zakázané), aniž by se změnilo, zda jsou automaticky znovu povoleni, když je jejich účet Microsoft Entra ID opět povolen. Pro samostatné řízení použijte níže uvedenou možnost „Znovu povolit účty v Moodlu, když jsou znovu povoleny v Microsoft Entra ID“.';
$string['help_user_groupsyncsuspend'] = 'Nápověda k pozastavení účtů, které nejsou v synchronizační skupině';
$string['help_user_groupsyncsuspend_help'] = 'Pozastaví uživatele v Moodlu, pokud jsou v Microsoft Entra ID stále aktivní, ale nejsou členy ani vlastníky skupiny nakonfigurované v nastavení „Filtr skupiny pro synchronizaci uživatelů“. Kontroluje se pouze aktuální členství: pozastaveni jsou i stávající synchronizovaní uživatelé, kteří ve skupině nikdy nebyli, nejen ti, kteří ji opustili, proto před povolením této možnosti svou skupinu zkontrolujte. Tato možnost je k dispozici, pouze pokud je nakonfigurován filtr skupiny pro synchronizaci uživatelů. Aby se zabránilo hromadnému pozastavení, nic se nepozastaví, pokud je skupina prázdná nebo nelze načíst její členy. Pozastavení uživatelé nejsou znovu povoleni, dokud nejsou ve skupině.';
$string['help_user_disabledsyncreenable'] = 'Nápověda k opětovnému povolení účtů při povolení';
$string['help_user_disabledsyncreenable_help'] = 'Zruší pozastavení pozastavených uživatelů v Moodlu, pokud je jejich připojeným účtům v Microsoft Entra ID opět povoleno přihlášení (jsou povolené).';
$string['help_user_suspendnolink'] = 'Nápověda k pozastavení účtů bez propojení s Microsoftem';
$string['help_user_suspendnolink_help'] = 'Výše uvedené možnosti pozastavení/zakázání normálně působí pouze na účty, které mají uložený záznam objektu Microsoft Entra ID (vytvořený při synchronizaci nebo připojení účtu). Některé účty OpenID Connect takový záznam nemají – například se připojily dříve, než bylo nakonfigurováno Microsoft Graph API, nebo byl záznam odstraněn odpojením či akcí „vymazat spárované uživatele“. Tato možnost způsobí, že úloha kontroly stavu zkontroluje i tyto účty, přičemž uživatelské jméno v Moodlu porovná s nakonfigurovanou hodnotou deklarace uživatelského jména pro propojení v Entra ID.

Spárované účty, které v Entra ID chybí nebo jsou tam zakázané, jsou <strong>pouze pozastaveny</strong>: nikdy nejsou odstraněny (bez uloženého ID objektu nelze zkontrolovat dobu uchování obnovitelně odstraněných objektů v Entra ID) a nikdy nejsou automaticky znovu povoleny. Účty hostů se přeskakují.

Tato možnost funguje pouze tehdy, když je deklarace uživatelského jména pro propojení OpenID Connect nastavena na konkrétní pole, které lze v Entra ID vyhledat – „upn“, „oid“, „email“ nebo „samaccountname“. U hodnoty „auto“ (kdy se účinná deklarace volí při každém přihlášení a může se mezi uživateli lišit) nebo jakékoli jiné deklarace nelze uživatelské jméno v Moodlu spolehlivě spárovat s jediným účtem a tato možnost nic nedělá.

Po prvním spuštění zkontrolujte své pozastavené uživatele: účet ručně přepnutý na tuto metodu ověřování, který nikdy nebyl skutečným uživatelem Entra ID, bude touto možností pozastaven.';
$string['help_user_match'] = 'Nápověda k párování účtů';
$string['help_user_match_help'] = 'Projde se každý uživatel v propojeném Microsoft Entra ID a pokusí se ho spárovat s uživatelem v Moodlu. Párování vychází z UPN v Microsoft Entra ID a uživatelského jména v Moodlu. Při porovnávání se nerozlišují velká a malá písmena a ignoruje se doménová část UPN v Microsoft Entra ID. Například „BoB.SmiTh“ v Moodlu by odpovídalo „bob.smith@example.onmicrosoft.com“. Spárovaní uživatelé budou mít své účty Moodle a Microsoft Entra ID propojeny a budou moci používat všechny funkce integrace Microsoft 365 a Moodle. Metoda ověřování uživatele se nezmění, pokud není povoleno níže uvedené nastavení.';
$string['help_user_matchswitchauth'] = 'Nápověda k přepnutí spárovaných účtů';
$string['help_user_matchswitchauth_help'] = 'Vyžaduje povolení výše uvedeného nastavení „Spárovat již existující uživatele Moodlu“. Když je uživatel spárován, povolení tohoto nastavení přepne jeho metodu ověřování na OpenID Connect. Poté se bude moci přihlašovat do Moodlu pomocí svých přihlašovacích údajů Microsoft 365. Poznámka: Chcete-li toto nastavení používat, zajistěte, aby byl povolen ověřovací modul OpenID Connect. Upozornění: pokud uživatelské jméno v Moodlu odpovídá pouze části UPN v Microsoft Entra ID před znakem „@“ (nikoli celému UPN), může pokročilé nastavení „Minimální délka nepřesného uživatelského jména pro přepnutí na Microsoft 365“ zabránit přepnutí metody ověřování u uživatelů s krátkými uživatelskými jmény.';
$string['help_user_appassign'] = 'Nápověda k přiřazení uživatelů k aplikaci';
$string['help_user_appassign_help'] = 'Všechny účty Microsoft Entra ID s odpovídajícími účty v Moodlu budou přiřazeny k aplikaci Microsoft Entra ID vytvořené pro tuto instalaci Moodlu, pokud již nejsou přiřazeny.';
$string['help_user_photosync'] = 'Nápověda k synchronizaci profilových fotografií Microsoft 365 (cron)';
$string['help_user_photosync_help'] = 'Profilové fotografie všech uživatelů v Moodlu budou synchronizovány s jejich profilovými fotografiemi v Microsoft 365.';
$string['help_user_photosynconlogin'] = 'Nápověda k synchronizaci profilových fotografií Microsoft 365 (přihlášení)';
$string['help_user_photosynconlogin_help'] = 'Profilová fotografie uživatele v Moodlu bude synchronizována s jeho profilovou fotografií v Microsoft 365 při přihlášení uživatele. Upozorňujeme, že to vyžaduje, aby uživatel navštívil stránku obsahující blok Microsoft v Moodlu.';
$string['help_user_nodelta'] = 'Nápověda k úplné synchronizaci';
$string['help_user_nodelta_help'] = 'Ve výchozím nastavení synchronizace uživatelů přenáší pouze změny z Microsoft Entra ID od posledního spuštění synchronizace. Zaškrtnutím této možnosti vynutíte pokaždé úplnou synchronizaci uživatelů.';
$string['help_user_emailsync'] = 'Nápověda k synchronizaci uživatelských jmen Microsoft Entra ID s e-maily v Moodlu';
$string['help_user_emailsync_help'] = 'Povolením této možnosti se uživatelská jména Microsoft Entra ID budou párovat s e-maily v Moodlu místo výchozího chování, kdy se párují s uživatelskými jmény v Moodlu.';
$string['help_user_tzsync'] = 'Nápověda k synchronizaci časového pásma Outlooku (cron)';
$string['help_user_tzsync_help'] = 'Časové pásmo všech uživatelů v Moodlu bude synchronizováno s jejich předvolbou časového pásma v Outlooku.';
$string['help_user_tzsynconlogin'] = 'Nápověda k synchronizaci časového pásma Outlooku (přihlášení)';
$string['help_user_tzsynconlogin_help'] = 'Časové pásmo uživatele v Moodlu bude synchronizováno s jeho předvolbou časového pásma v Outlooku. Upozorňujeme, že to vyžaduje, aby uživatel navštívil stránku obsahující blok Microsoft v Moodlu.';
$string['help_user_guestsync'] = 'Nápověda k synchronizaci uživatelů typu host';
$string['help_user_guestsync_help'] = 'Je-li povoleno, uživatelé typu host v Microsoft Entra ID budou synchronizováni do Moodlu v úloze synchronizace uživatelů.';

// Cohort sync feature.
$string['cohortsync_title'] = 'Synchronizace globálních skupin';
$string['cohortsync_taskname'] = 'Synchronizace globálních skupin';
$string['cohortsync_mappingadded'] = 'Nové připojení bylo úspěšně přidáno';
$string['cohortsync_mappingdeleted'] = 'Připojení bylo úspěšně odstraněno';
$string['cohortsync_addmapping'] = 'Přidat připojení';
$string['cohortsync_deletemapping'] = 'Odstranit připojení';
$string['cohortsync_desc'] = 'Tato stránka umožňuje jednosměrnou synchronizaci ze skupin Microsoft 365 do globálních skupin Moodlu v kontextu systému. Přidání nového připojení zahájí proces synchronizace – uživatelé z vybrané skupiny Microsoft 365, kteří jsou připojeni k Microsoftu, budou přidáni do vybrané globální skupiny Moodlu.';
$string['cohortsync_tabledesc'] = 'Aktuální připojení mezi skupinami Microsoft 365 a globálními skupinami Moodlu';
$string['cohortsync_typetosearch'] = 'Zadáním vyhledejte skupinu Microsoft 365';
$string['cohortsync_typetosearch_cohort'] = 'Zadáním vyhledejte globální skupinu Moodlu';
$string['cohortsync_emptymatchings'] = 'Nebyla nalezena žádná připojení';
$string['cohortsync_select_cohort'] = 'Globální skupina Moodlu';
$string['cohortsync_select_group'] = 'Skupina Microsoft 365';
$string['cohortsync_tablehead_group'] = 'Skupina Microsoft 365';
$string['cohortsync_tablehead_cohort'] = 'Globální skupina Moodlu';
$string['cohortsync_tablehead_actions'] = 'Akce';
$string['cohortsync_search'] = 'Hledat';
$string['cohortsync_load_more'] = 'Načíst další...';
$string['cohortsync_no_groups_found'] = 'Pro „{$a}“ nebyly nalezeny žádné skupiny Microsoft 365';
$string['cohortsync_no_cohorts_found'] = 'Pro „{$a}“ nebyly nalezeny žádné globální skupiny Moodlu';
$string['cohortsync_error_no_group'] = 'Vyberte prosím skupinu Microsoft 365.';
$string['cohortsync_error_no_cohort'] = 'Vyberte prosím globální skupinu Moodlu.';
$string['cohortsync_mappingfailed'] = 'Chyba při přidávání připojení globální skupiny a skupiny. Možné příčiny: skupina nebo globální skupina neexistuje, skupina je již připojena k jiné globální skupině, skupina je již připojena k této globální skupině.';
$string['cohortsync_connectionnotfound'] = 'Neplatný požadavek: připojení nebylo nalezeno.';
$string['cohortsync_connectionnotcohortsync'] = 'Neplatný požadavek: neodpovídající typ připojení.';
$string['cohortsync_unifiedapierror'] = 'Chyba při získávání seznamu skupin od Microsoftu.';

// Course request.
$string['courserequest_teams'] = 'Tým Microsoft';
$string['courserequest_teams_help'] = 'Vyberte tým Microsoft, který bude připojen ke kurzu. Stávající vlastníci a členové týmu budou po schválení žádosti o kurz zapsáni do vytvořeného kurzu.';
$string['courserequest_emptyteams'] = 'Nejsou k dispozici žádné týmy Microsoft Teams';
$string['courserequest_title'] = 'Požádat o kurz z Teams';
$string['courserequest_updatecourserequeststatus_taskname'] = 'Aktualizovat stav žádosti o kurz';
$string['courserequest_customrequestnote'] = '
| Tato žádost byla podána ze stránky žádosti o kurz v Microsoft Teams a po schválení bude připojena k týmu: „{$a->name}“ s URL {$a->url}.';
$string['courserequest_graphapi_disabled'] = 'Připojení k Microsoft Teams není dostupné. Kontaktujte prosím správce webu.';
$string['courserequest_invalid_team'] = 'V žádosti o kurz byl použit neplatný tým.';
$string['courserequest_duplicate'] = 'Čekající nebo schválená žádost o kurz ze stejného týmu již existuje.';

// Teams page.
$string['teams_no_course'] = 'Nemáte žádný kurz, který byste mohli přidat.';
$string['tab_name'] = 'Název karty';
$string['sso_login'] = 'Přihlásit se do Microsoft 365';
$string['other_login'] = 'Přihlásit se ručně';
$string['course_selector_label'] = 'Vybrat existující kurz';

// Notifications to site admin about Microsoft Entra ID app secret.
$string['notification_subject_secret_expired'] = 'Vyžadována akce: platnost tajného klíče aplikace Microsoft Entra ID vypršela';
$string['notification_content_secret_expired'] = 'Vážený správce webu,

platnost tajného klíče aplikace Microsoft Entra ID, který se používá v integraci Moodlu a Microsoft 365, vypršela.
Abyste integraci obnovili, vytvořte prosím v Microsoft Entra ID nový tajný klíč a aktualizujte jej v konfiguraci integrace.';
$string['notification_subject_secret_almost_expired'] = 'Vyžadována akce: platnost tajného klíče aplikace Microsoft Entra ID brzy vyprší';
$string['notification_content_secret_almost_expired'] = 'Vážený správce webu,

platnost tajného klíče aplikace Microsoft Entra ID, který se používá v integraci Moodlu a Microsoft 365, vyprší za {$a}.
Abyste předešli narušení integrace, vytvořte prosím v Microsoft Entra ID nový tajný klíč a aktualizujte jej v konfiguraci integrace.';
$string['notification_days_less_than_one_day'] = 'méně než 1 den';
$string['notification_days_one_day'] = '1 den';
$string['notification_days_days'] = '{$a} dní';
$string['notification_subject_invalid_secret'] = 'Vyžadována akce: byl nalezen neplatný tajný klíč aplikace Microsoft Entra ID';
$string['notification_content_invalid_secret'] = 'Vážený správce webu,

tajný klíč aplikace Microsoft Entra ID, který se používá v integraci Moodlu a Microsoft 365, se zdá být neplatný. Příčinou může být vypršení platnosti nebo odstranění tajného klíče.
Zkontrolujte prosím tajný klíč, aby integrace fungovala podle očekávání.';

// Async operations.
$string['teamsasyncfailed'] = 'Asynchronní operace vytvoření týmu selhala: {$a}';
$string['unknownasyncstate'] = 'Neznámý stav asynchronní operace: {$a}';

// Template ID validation.
$string['error_template_id_empty'] = 'ID šablony nesmí být prázdné.';
$string['error_not_connected'] = 'Nejste připojeni k Microsoft 365. Nejprve prosím nastavte integraci Microsoft 365.';
$string['error_graph_client_not_available'] = 'Nelze se připojit k Microsoft Graph API. Zkontrolujte prosím nastavení integrace Microsoft 365.';
$string['success_template_id_valid'] = '✓ ID šablony „{$a}“ je platné a přístupné.';
$string['error_template_id_not_found'] = '✗ ID šablony „{$a}“ nebylo nalezeno. Ověřte prosím ID šablony v centru pro správu Teams.';
$string['error_template_validation_failed'] = '✗ Ověření šablony selhalo: {$a}';
$string['error_template_validation_error'] = '✗ Při ověřování šablony došlo k chybě. Zkuste to prosím znovu nebo kontaktujte správce.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
