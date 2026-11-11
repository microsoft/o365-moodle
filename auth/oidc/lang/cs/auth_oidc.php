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
$string['settings_pageheading'] = 'Konfigurace {$a}';
$string['settings_page_other_settings'] = 'Další možnosti';
$string['settings_page_application'] = 'IdP a ověřování';
$string['settings_page_application_wizard'] = 'Průvodce konfigurací aplikace';
$string['settings_page_binding_username_claim'] = 'Deklarace pro vazbu uživatelského jména';
$string['settings_page_change_binding_username_claim_tool'] = 'Nástroj pro změnu deklarace pro vazbu uživatelského jména';
$string['settings_page_cleanup_oidc_tokens'] = 'Vyčistit tokeny OpenID Connect';
$string['settings_page_clear_user_tokens'] = 'Vymazat tokeny uživatelů';
$string['settings_page_field_mapping'] = 'Mapování polí';
$string['heading_additional_options'] = 'Další možnosti';
$string['heading_additional_options_desc'] = '';
$string['heading_stateredirect'] = 'Chybová stránka stavu přihlášení';
$string['heading_stateredirect_desc'] = 'Pokud uživateli trvá dokončení přihlášení u poskytovatele identity příliš dlouho (například při schvalování výzvy vícefaktorového ověřování) a uložený stav přihlášení byl mezitím vyčištěn, Moodle ve výchozím nastavení zobrazí svou obecnou chybovou stránku. Níže uvedená nastavení umožňují prodloužit dobu, po kterou se stav přihlášení uchovává, a místo obecné chybové stránky zobrazit vstřícnější, přizpůsobitelnou zprávu, která uživatele automaticky přesměruje zpět na přihlašovací stránku.';
$string['heading_user_restrictions'] = 'Omezení uživatelů';
$string['heading_user_restrictions_desc'] = '';
$string['heading_logout'] = 'Integrace odhlášení';
$string['heading_logout_desc'] = '';
$string['heading_display'] = 'Zobrazení';
$string['heading_display_desc'] = '';
$string['heading_debugging'] = 'Ladění';
$string['heading_debugging_desc'] = '';
$string['heading_tools'] = 'Nástroje';
$string['microsoftcloud'] = 'Cloud Microsoft';
$string['microsoftcloud_help'] = 'Vyberte cloud Microsoft, ke kterému patří váš tenant Microsoft Entra. Platí pro typy IdP Microsoft Entra ID a Microsoft identity platform.<br/>
Pokud vaše organizace používá Microsoft 365 poskytovaný společností 21Vianet, vyberte „Microsoft 365 provozovaný společností 21Vianet (Čína)“. Pro požadavky odesílané moduly se pak použijí přihlašovací služba a koncové body Microsoft Graph tohoto cloudu a výchozí hodnoty koncových bodů a prostředku níže se jím budou řídit. Již uložené hodnoty koncových bodů, prostředku a koncového bodu odhlášení se nemění, proto je aktualizujte, pokud jsou stále nastaveny na koncové body globálního cloudu.';
$string['microsoftcloud_global'] = 'Microsoft 365 (globální)';
$string['microsoftcloud_china'] = 'Microsoft 365 provozovaný společností 21Vianet (Čína)';
$string['idptype'] = 'Typ poskytovatele identity (IdP)';
$string['idptype_help'] = 'V současné době jsou podporovány čtyři typy IdP:
<ul>
<li><b>Microsoft Entra ID (v1.0)</b>: Microsoft Entra ID s koncovými body oauth2 v1.0, např. https://login.microsoftonline.com/organizations/oauth2/authorize.</li>
<li><b>Microsoft identity platform (v2.0)</b>: Microsoft Entra ID s koncovými body oauth2 v2.0, např. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize.</li>
<li><b>Microsoft Entra External ID</b>: tenant Microsoft Entra External ID (zákaznický) s koncovými body oauth2 v2.0 na hostiteli ciamlogin.com, např. https://contoso.ciamlogin.com/&lt;tenant-id&gt;/oauth2/v2.0/authorize. Funkce Microsoft 365 pluginu local_o365 nejsou pro tento typ IdP dostupné.</li>
<li><b>Jiný</b>: jakýkoli IdP jiný než od Microsoftu.</li>
</ul>
Rozdíly mezi možnostmi <b>Microsoft Entra ID (v1.0)</b> a <b>Microsoft identity platform (v2.0)</b> najdete na <a href="https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison">https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison</a>.<br/>
Zejména může nakonfigurovaná aplikace při použití IdP <b>Microsoft identity platform (v2.0)</b> k ověřování kromě <b>tajného klíče</b> použít také <b>certifikát</b>.<br/>
Koncové body autorizace a tokenů je třeba nakonfigurovat podle nastaveného typu IdP.';
$string['idp_type_not_connected'] = 'Nepřipojeno';
$string['idp_type_microsoft_entra_id'] = 'Microsoft Entra ID (v1.0)';
$string['idp_type_microsoft_identity_platform'] = 'Microsoft identity platform (v2.0)';
$string['idp_type_other'] = 'Jiný';
$string['idp_type_microsoft_entra_external_id'] = 'Microsoft Entra External ID';
$string['settings_application_wizard_desc'] = 'Chcete-li tato nastavení nakonfigurovat pomocí řízeného formuláře s podrobnými pokyny a ověřováním zadaných hodnot, použijte <a href="{$a}">Průvodce konfigurací aplikace</a>.';
$string['authendpoint'] = 'Koncový bod autorizace';
$string['authendpoint_help'] = 'URI koncového bodu autorizace vašeho IdP, který se má použít.<br/>
<span data-auth-oidc-idptypes="1,2">Pozor: pokud má být web nakonfigurován tak, aby k němu měli přístup uživatelé z jiných tenantů, nelze použít koncový bod autorizace specifický pro tenanta.</span><span data-auth-oidc-idptypes="4">U Microsoft Entra External ID použijte „OAuth 2.0 authorization endpoint (v2)“ zobrazený na stránce Endpoints registrace aplikace ve vašem tenantovi External ID. Musí jít o koncový bod v2.0 specifický pro váš tenant.</span>';
$string['clientid'] = 'ID aplikace';
$string['clientid_help'] = 'Registrované ID aplikace / klienta u IdP.';
$string['clientauthmethod'] = 'Metoda ověřování klienta';
$string['clientauthmethod_help'] = '<ul>
<li>IdP všech typů mohou používat metodu ověřování „<b>Tajný klíč</b>“.</li>
<li>IdP typu <b>Microsoft identity platform (v2.0)</b> mohou navíc používat metodu ověřování <b>Certifikát</b>.</li>
</ul>';
$string['auth_method_secret'] = 'Tajný klíč';
$string['auth_method_certificate'] = 'Certifikát';
$string['clientsecret'] = 'Tajný klíč klienta';
$string['clientsecret_help'] = 'Při použití metody ověřování <b>tajným klíčem</b> je to tajný klíč klienta u IdP. U některých poskytovatelů se označuje také jako klíč (key).';
$string['clientprivatekey'] = 'Soukromý klíč certifikátu klienta';
$string['clientprivatekey_help'] = 'Při použití metody ověřování <b>certifikátem</b> a zdroje certifikátu <b>Prostý text</b> je to soukromý klíč certifikátu používaného k ověřování u IdP.';
$string['clientcert'] = 'Veřejný klíč certifikátu klienta';
$string['clientcert_help'] = 'Při použití metody ověřování <b>certifikátem</b> a zdroje certifikátu <b>Prostý text</b> je to veřejný klíč neboli certifikát používaný k ověřování u IdP.';
$string['clientcertsource'] = 'Zdroj certifikátu';
$string['clientcertsource_help'] = 'Při použití metody ověřování <b>certifikátem</b> určuje, odkud se má certifikát načíst.
<ul>
<li>Zdroj <b>Prostý text</b> vyžaduje, aby byl obsah souborů certifikátu/soukromého klíče zadán v následujících textových polích nastavení.</li>
<li>Zdroj <b>Název souboru</b> vyžaduje, aby soubory certifikátu/soukromého klíče existovaly ve složce <b>microsoft_certs</b> v datové složce Moodle.</li>
</ul>';
$string['cert_source_text'] = 'Prostý text';
$string['cert_source_path'] = 'Název souboru';
$string['clientprivatekeyfile'] = 'Název souboru soukromého klíče certifikátu klienta';
$string['clientprivatekeyfile_help'] = 'Při použití metody ověřování <b>certifikátem</b> a zdroje certifikátu <b>Název souboru</b> je to název souboru soukromého klíče používaného k ověřování u IdP. Soubor musí být umístěn ve složce <b>microsoft_certs</b> v datové složce Moodle.';
$string['clientcertfile'] = 'Název souboru veřejného klíče certifikátu klienta';
$string['clientcertfile_help'] = 'Při použití metody ověřování <b>certifikátem</b> a zdroje certifikátu <b>Název souboru</b> je to název souboru veřejného klíče neboli certifikátu používaného k ověřování u IdP. Soubor musí být umístěn ve složce <b>microsoft_certs</b> v datové složce Moodle.';
$string['clientcertpassphrase'] = 'Heslo certifikátu klienta';
$string['clientcertpassphrase_help'] = 'Pokud je soukromý klíč certifikátu klienta zašifrován, je to heslo k jeho dešifrování.';
$string['change_client_secret'] = 'Změnit tajný klíč klienta';
$string['change_client_secret_desc'] = 'Zaškrtnutím tohoto políčka aktualizujete tajný klíč klienta. Z bezpečnostních důvodů jsou stávající tajné klíče maskovány a zobrazují se pouze první 2 znaky.';
$string['change_cert_passphrase'] = 'Změnit heslo certifikátu';
$string['change_cert_passphrase_desc'] = 'Zaškrtnutím tohoto políčka aktualizujete heslo certifikátu. Z bezpečnostních důvodů jsou stávající hesla maskována a zobrazují se pouze první 2 znaky.';
$string['cfg_usepkce_key'] = 'Použít PKCE';
$string['cfg_usepkce_desc'] = 'Při použití přihlašovacího toku <b>Authorization Code</b> odesílat v autorizačním požadavku PKCE (RFC 7636) „code_challenge“ s metodou S256 a při výměně autorizačního kódu odpovídající „code_verifier“. Microsoft Entra ID to podporuje. U jiných poskytovatelů tuto volbu povolte pouze tehdy, pokud váš poskytovatel PKCE podporuje, protože někteří poskytovatelé odmítají autorizační požadavky s parametry, které nerozpoznají.';
$string['cfg_domainhint_key'] = 'Nápověda domény (Domain Hint)';
$string['cfg_domainhint_desc'] = 'Při použití přihlašovacího toku <b>Authorization Code</b> předávat tuto hodnotu jako parametr „domain_hint“. „domain_hint“ používají někteří poskytovatelé identity OpenID Connect ke zjednodušení přihlašování uživatelů. Ověřte si u svého poskytovatele, zda tento parametr podporuje.';
$string['cfg_domainhint_external_id_note'] = 'U Microsoft Entra External ID tato hodnota odešle uživatele přímo k federovanému poskytovateli identity místo zobrazení přihlašovací stránky. Použijte google, facebook nebo apple, případně doménu vlastního poskytovatele OpenID Connect (například contoso.onmicrosoft.com pro tenanta Microsoft Entra ID). Nepoužívejte ID tenanta.';
$string['cfg_forceselectaccount_key'] = 'Vždy zobrazit výběr účtu';
$string['cfg_forceselectaccount_desc'] = 'Je-li povoleno, uživatelé jsou vždy vyzváni, aby vybrali účet, kterým se chtějí přihlásit, místo aby byli automaticky přihlášeni účtem aktivním v jejich prohlížeči. Užitečné, pokud mají uživatelé více účtů, například studentský a administrátorský účet.<br/>
Přednost má režim tichého přihlášení: je-li povolen, výběr účtu se při tichém přihlášení nevynucuje.';
$string['cfg_forceredirect_key'] = 'Vynutit přesměrování';
$string['cfg_forceredirect_desc'] = 'Je-li povoleno, přeskočí se úvodní přihlašovací stránka a uživatel bude přesměrován na stránku OpenID Connect. Lze obejít parametrem URL ?noredirect=1';
$string['cfg_stateexpiry_key'] = 'Platnost stavu přihlášení (minuty)';
$string['cfg_stateexpiry_desc'] = 'Jak dlouho se záznam o stavu přihlášení uchovává, než jej odstraní naplánovaná úloha čištění. Zvyšte tuto hodnotu, pokud uživatelům dokončení přihlášení u poskytovatele identity pravidelně trvá déle (například kvůli výzvám vícefaktorového ověřování).';
$string['error_stateexpiry_min'] = 'Platnost stavu přihlášení musí být alespoň 1 minuta. Hodnota nula nebo menší by způsobila selhání právě probíhajících přihlášení.';
$string['cfg_stateredirect_enabled_key'] = 'Zobrazit vstřícnou chybovou stránku';
$string['cfg_stateredirect_enabled_desc'] = 'Je-li povoleno, uživateli, jemuž dokončení přihlášení u poskytovatele identity trvá příliš dlouho (takže uložený stav přihlášení byl mezitím vyčištěn), se místo obecné chybové stránky Moodle zobrazí níže uvedená přizpůsobitelná zpráva a bude automaticky přesměrován zpět na přihlašovací stránku.';
$string['cfg_stateredirect_message_key'] = 'Zpráva';
$string['cfg_stateredirect_message_desc'] = 'Zpráva, která se uživateli zobrazí na vstřícné chybové stránce.';
$string['cfg_stateredirect_message_default'] = 'Při vašem přihlašování došlo k problému. Nejpravděpodobněji proto, že dokončení přihlášení trvalo příliš dlouho (například při schvalování výzvy vícefaktorového ověřování). Budete automaticky přesměrováni na přihlašovací stránku, abyste to mohli zkusit znovu.';
$string['cfg_stateredirect_delay_key'] = 'Prodleva přesměrování (sekundy)';
$string['cfg_stateredirect_delay_desc'] = 'Počet sekund, po který se zobrazuje výše uvedená zpráva, než je uživatel automaticky přesměrován zpět na přihlašovací stránku.';
$string['cfg_set_pix_key'] = 'Zobrazit ikonu na přihlašovací stránce';
$string['cfg_set_pix_desc'] = 'Je-li povoleno, zobrazí se na přihlašovací stránce vedle názvu poskytovatele ikona.';
$string['cfg_icon_key'] = 'Ikona';
$string['cfg_icon_desc'] = 'Ikona, která se bude zobrazovat na přihlašovací stránce vedle názvu poskytovatele.';
$string['cfg_iconalt_o365'] = 'Ikona Office 365';
$string['cfg_iconalt_microsoft365'] = 'Logo Microsoft 365';
$string['cfg_iconalt_openid'] = 'Ikona OpenID';
$string['cfg_iconalt_keycloak'] = 'Ikona Keycloak';
$string['cfg_customicon_key'] = 'Vlastní ikona';
$string['cfg_customicon_desc'] = 'Pokud chcete použít vlastní ikonu, nahrajte ji zde. To přepíše jakoukoli ikonu vybranou výše. <br /><br /><b>Poznámky k používání vlastních ikon:</b><ul><li>Velikost nahraného souboru se nemění. Na přihlašovací stránce se zobrazí v pevné velikosti 24x24 pixelů a prohlížeč jej přizpůsobí, proto doporučujeme nahrát čtvercový obrázek, aby nedošlo ke zkreslení.</li><li>Pokud jste nahráli vlastní ikonu a chcete se vrátit k některé ze standardních ikon, klikněte v poli výše na vlastní ikonu, poté klikněte na „Odstranit“, potom na „OK“ a nakonec dole v tomto formuláři na „Uložit změny“. Na přihlašovací stránce Moodlu se pak zobrazí vybraná standardní ikona.</li></ul>';
$string['cfg_debugmode_key'] = 'Zaznamenávat zprávy ladění';
$string['cfg_debugmode_desc'] = 'Pokud je toto nastavení povoleno, do protokolu Moodlu jsou zaznamenávány informace, které vám mohou pomoci identifikovat problémy.';
$string['cfg_silentloginmode_key'] = 'Režim tichého přihlášení';
$string['cfg_silentloginmode_desc'] = 'Je-li povoleno, Moodle se pokusí uživatele přihlásit pomocí jeho aktivní relace u nakonfigurovaného koncového bodu autorizace.<br/>
Pro použití této funkce jsou vyžadována následující nastavení:
<ul>
<li>Je povoleno nastavení <b>Vnutit přihlášení</b> (forcelogin) v <a href="{$a}" target="_blank">sekci Nastavení zabezpečení stránek</a>.</li>
<li>Je povoleno výše uvedené nastavení <b>Vynutit přesměrování</b> (auth_oidc/forceredirect).</li>
</ul>
Aby se Moodle nepokoušel k přihlášení použít osobní účty nebo účty z jiných tenantů, doporučuje se také používat koncové body specifické pro tenanta místo obecných koncových bodů s cestami jako „common“ nebo „organizations“.<br/>
<br/>
U poskytovatelů identity Microsoft vypadá uživatelský zážitek takto:
<ul>
<li>Pokud není nalezena žádná aktivní uživatelská relace, zobrazí se přihlašovací stránka Moodlu.</li>
<li>Pokud je nalezena pouze jedna aktivní uživatelská relace a uživatel má přístup k aplikaci Entra ID (tj. uživatel je ze stejného tenanta nebo je hostem tenanta), bude uživatel do Moodlu přihlášen automaticky pomocí SSO.</li>
<li>Pokud je nalezena pouze jedna aktivní uživatelská relace, ale uživatel nemá přístup k aplikaci Entra ID (např. uživatel je z jiného tenanta nebo aplikace vyžaduje přiřazení uživatelů a uživatel přiřazen není), zobrazí se přihlašovací stránka Moodlu.</li>
<li>Pokud existuje více aktivních uživatelských relací s přístupem k aplikaci Entra ID, zobrazí se stránka, na které si uživatel může vybrat účet, kterým se přihlásí.</li>
</ul>';
$string['oidcresource'] = 'Prostředek';
$string['oidcresource_help'] = 'Prostředek OpenID Connect, pro který se má požadavek odeslat.<br/>
<b>Poznámka:</b> tento parametr není podporován u typu IdP <b>Microsoft identity platform (v2.0)</b>.';
$string['oidcscope'] = 'Rozsah (scope)';
$string['oidcscope_help'] = 'Rozsah (scope) OIDC, který se má použít.';
$string['customclaims'] = 'Vlastní deklarace';
$string['customclaims_help'] = 'Mezerami oddělený seznam názvů vlastních deklarací z tokenů vašeho poskytovatele identity.<br/>
<b>Důležité:</b>
<ul>
<li>Deklarace musí existovat v konfiguraci tokenů vašeho IdP (např. mapovače protokolu v Keycloak, volitelné/vlastní deklarace v Microsoft Entra ID)</li>
<li>Pokud deklarace v tokenu neexistuje, mapování polí ji tiše přeskočí – nezobrazí se žádná chyba</li>
<li>V názvech deklarací se rozlišují velká a malá písmena a mohou obsahovat pouze alfanumerické znaky, pomlčky a podtržítka</li>
<li>Název deklarace nesmí být rezervovaný název, například standardní deklarace JWT/OpenID Connect (např. <code>sub</code>, <code>email</code>), deklarace specifická pro Microsoft Entra ID (např. <code>oid</code>, <code>upn</code>) nebo Keycloak (např. <code>realm_access</code>, <code>resource_access</code>), ani existující možnost mapování polí</li>
<li>Deklarace <code>roles</code> (role aplikace v tokenech Microsoft Entra ID) a deklarace <code>groups</code> (ID skupin) jsou povoleny. V mapování polí jsou uvedeny jako „roles (deklarace tokenu)“ a „groups (deklarace tokenu)“, odděleně od vestavěných možností „Role“ a „Skupiny“, které mapují role adresáře Microsoft Entra a názvy skupin z Microsoft Graph. Deklarace obsahující seznam hodnot se ukládají jako seznam oddělený čárkami</li>
<li>Příklady: <code>employee_type badge_number costCenter custom_role</code></li>
<li data-auth-oidc-idptypes="1,2">Při přihlášení se vlastní deklarace vždy čtou z tokenu bez ohledu na to, zda se používá také Microsoft Graph. Během naplánované úlohy synchronizace uživatelů není k dispozici žádný uživatelský token, ze kterého by bylo možné číst, proto se vlastní deklarace synchronizuje pouze tehdy, pokud je její název zároveň vybratelnou vlastností uživatele v Microsoft Graph, například atributem rozšíření adresáře (např. <code>extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode</code>). Vlastní deklarace, kterou Microsoft Graph odmítne, se v daném běhu synchronizace přeskočí s varováním v protokolu úlohy, místo aby selhala celá synchronizace.</li>
</ul>';
$string['secretexpiryrecipients'] = 'Příjemci upozornění na vypršení tajného klíče';
$string['secretexpiryrecipients_help'] = 'Čárkami oddělený seznam e-mailových adres, na které se mají odesílat upozornění na vypršení platnosti tajného klíče.<br/>
Pokud není zadána žádná e-mailová adresa, bude upozorněn hlavní správce webu.<br/>
Ve výchozím nastavení se upozornění odesílají denně od čtyř týdnů před vypršením platnosti, dokud není tajný klíč obnoven.';
$string['cfg_showbutton_key'] = 'Zobrazit přihlašovací tlačítko';
$string['cfg_showbutton_desc'] = 'Je-li zakázáno, přihlašovací tlačítko poskytovatele se na přihlašovací stránce nezobrazí. Uživatelé se přes tohoto poskytovatele mohou stále ověřit tak, že přejdou přímo na jeho přihlašovací URL.';
$string['cfg_opname_key'] = 'Název poskytovatele';
$string['cfg_opname_desc'] = 'Toto je údaj zobrazovaný koncovému uživateli, který identifikuje, jaký typ přihlašovacích údajů potřebuje uživatel použít k přihlášení. Tento údaj se používá na více místech rozhraní pro koncového uživatele v tomto modulu k identifikaci vašeho poskytovatele.';
$string['cfg_redirecturi_key'] = 'URI pro přesměrování';
$string['cfg_redirecturi_desc'] = 'Toto je identifikátor URI, který se registruje jako „URI pro přesměrování“. Váš poskytovatel identity OpenID Connect by vás měl o tento identifikátor požádat při registraci Moodlu jako klienta.<br /><b>Poznámka:</b> Tento identifikátor musíte ve svém poskytovateli identity OpenID Connect zadat *přesně* tak, jak je zde uveden. Jakákoli odchylka znemožní přihlášení s použitím OpenID Connect.';
$string['tokenendpoint'] = 'Koncový bod tokenů';
$string['tokenendpoint_help'] = 'URI koncového bodu tokenů vašeho IdP, který se má použít.<br/>
<span data-auth-oidc-idptypes="1,2">Pozor: pokud má být web nakonfigurován tak, aby k němu měli přístup uživatelé z jiných tenantů, nelze použít koncový bod tokenů specifický pro tenanta.</span><span data-auth-oidc-idptypes="4">U Microsoft Entra External ID použijte „OAuth 2.0 token endpoint (v2)“ zobrazený na stránce Endpoints registrace aplikace ve vašem tenantovi External ID. Musí jít o koncový bod v2.0 specifický pro váš tenant.</span>';
$string['cfg_userrestrictions_key'] = 'Omezení uživatelů';
$string['cfg_userrestrictions_desc'] = 'Povolit přihlášení pouze uživatelům, kteří splňují určitá omezení. <br /><b>Jak používat omezení uživatelů: </b> <ul><li>Zadejte vzor <a href="https://en.wikipedia.org/wiki/Regular_expression">regulárního výrazu</a>, který odpovídá uživatelským jménům uživatelů, které chcete povolit.</li><li>Zadejte jeden vzor na řádek.</li><li>Pokud zadáte více vzorů, uživatel bude povolen, pokud odpovídá KTERÉMUKOLI z nich.</li><li>Znak "/" je třeba escapovat pomocí "\\".</li><li>Pokud výše nezadáte žádná omezení, Moodle přijme všechny uživatele, kteří se mohou přihlásit k poskytovateli identity OpenID Connect.</li><li>Uživateli, který neodpovídá žádnému zadanému vzoru, bude přihlášení pomocí OpenID Connect znemožněno.</li></ul>';
$string['cfg_userrestrictions_disabled_external_id'] = 'Omezení uživatelů nejsou pro Microsoft Entra External ID dostupná, proto je toto nastavení zakázáno a omezení se při přihlášení uživatelů neuplatňují. Omezení se porovnávají s deklarací pro vazbu uživatelského jména, kterou je u uživatelů External ID ve výchozím nastavení ID objektu (oid), takže by vzory musely odpovídat GUID. Přístup na web raději řiďte ve svém tenantovi External ID, například pomocí uživatelských toků nebo přiřazení aplikace.';
$string['cfg_userrestrictionscasesensitive_key'] = 'Omezení uživatelů rozlišují velká a malá písmena';
$string['cfg_userrestrictionscasesensitive_desc'] = 'Určuje, zda se při porovnávání omezení uživatelů použije volba "/i" regulárního výrazu.<br/>Je-li povoleno, všechny kontroly omezení uživatelů budou rozlišovat velká a malá písmena. Pozor: je-li zakázáno, budou se ve vzorech ignorovat jakékoli rozdíly ve velikosti písmen.';
$string['heading_dummy_email'] = 'Zástupné e-mailové adresy';
$string['heading_dummy_email_desc'] = 'Moodle vyžaduje, aby každý uživatelský účet měl e-mailovou adresu, ale někteří poskytovatelé identity, například Microsoft Entra ID, ji u svých účtů nevyžadují. Níže uvedená nastavení umožňují Moodlu vygenerovat nedoručitelnou zástupnou adresu pro uživatele, kteří od IdP nemají použitelnou e-mailovou adresu, místo aby jejich e-mailová adresa zůstala prázdná.';
$string['cfg_generatedummyemail_key'] = 'Generovat zástupné e-mailové adresy';
$string['cfg_generatedummyemail_desc'] = 'Je-li povoleno a uživatel nemá od IdP e-mailovou adresu ani použitelný hlavní název uživatele (UPN) ve formátu e-mailu, Moodle mu vygeneruje zástupnou e-mailovou adresu z jeho hlavního názvu uživatele (nebo ID objektu, pokud hlavní název uživatele není k dispozici) a níže nastavené domény, místo aby jeho e-mailová adresa zůstala prázdná. To platí jak při přihlášení uživatele, tak při jeho zřízení úlohou synchronizace uživatelů. Hlavní název uživatele a ID objektu se čtou z deklarací tokenu od IdP, takže pokud IdP neposkytne ani jedno, adresa se nevygeneruje.';
$string['cfg_dummyemaildomain_key'] = 'Doména zástupných e-mailů';
$string['cfg_dummyemaildomain_desc'] = 'Doména, která se použije při generování zástupných e-mailových adres, například „example.test“. Použijte doménu, která nemůže přijímat poštu, aby vygenerované adresy nemohly být nikdy zaměněny za skutečné, doručitelné adresy.';
$string['cfg_singlelogout_key'] = 'Jednotné odhlášení (SLO) (z Moodlu k IdP)';
$string['cfg_singlelogout_desc'] = 'Je-li tato možnost povolena a uživatel Moodlu připojený k nakonfigurovanému IdP se z Moodlu odhlásí, integrace odešle požadavek na níže uvedený koncový bod odhlášení a pokusí se uživatele odhlásit také od IdP.<br/>
Pozor: pro integraci s Microsoft Entra ID je třeba přidat URL webu Moodle ({$a}) jako URI pro přesměrování v aplikaci Microsoft Entra ID vytvořené pro integraci Moodlu a Microsoft 365.<br/>Jednotné odhlášení ukončí pouze relaci přihlašovací služby, kterou použil Moodle. Ostatní relace stejného účtu v prohlížeči, například ta vytvořená přihlášením k portálu Azure, tím nejsou dotčeny.';
$string['cfg_logoutendpoint_key'] = 'Koncový bod odhlášení IdP';
$string['cfg_logoutendpoint_desc'] = 'URI koncového bodu odhlášení vašeho IdP, který se má použít.';
$string['cfg_logoutendpoint_external_id_note'] = 'U Microsoft Entra External ID jsou uživatelé na odhlašovací stránce Microsoftu vyzváni k výběru účtu, pokud se do tokenu ID v registraci aplikace nepřidá volitelná deklarace login_hint (Konfigurace tokenu > Přidat volitelnou deklaraci > ID > login_hint). Po přidání deklarace se uživatelé musí znovu přihlásit.';
$string['cfg_frontchannellogouturl_key'] = 'URL odhlášení front-channel';
$string['cfg_frontchannellogouturl_desc'] = 'Toto je URL, kterou musí váš IdP zavolat, když se pokouší odhlásit uživatele z Moodlu.<br/>
U Microsoft Entra ID / Microsoft identity platform se toto nastavení nazývá "Front-channel logout URL" a lze jej nakonfigurovat v aplikaci Microsoft Entra ID.';
$string['cfg_field_mapping_desc'] = 'Data uživatelského profilu lze mapovat z poskytovatele identity OpenID Connect do Moodlu. Vzdálená pole dostupná pro mapování výrazně závisí na typu IdP.<br/>
<ul>
<li>Některá základní pole profilu jsou dostupná z deklarací přístupového tokenu a tokenu ID u všech typů IdP.</li>
<li>Je-li nakonfigurován typ IdP od Microsoftu (v1.0 nebo v2.0), lze zpřístupnit další data profilu prostřednictvím volání Graph API instalací a konfigurací <a href="https://moodle.org/plugins/local_o365">modulu integrace Microsoft 365 (local_o365)</a>.</li>
<li>Je-li v modulu local_o365 povolena funkce synchronizace profilů ze SDS, lze určitá pole profilu synchronizovat ze SDS do Moodlu. K tomu dochází pouze při běhu naplánované úlohy „Synchronizace se SDS“, nikoli při běhu naplánované úlohy „Synchronizovat uživatele z Microsoft Entra ID“ ani při přihlášení uživatele.</li>
</ul>

Deklarace dostupné z tokenu ID a přístupového tokenu se liší podle typu IdP, ale většina poskytovatelů identity umožňuje deklarace do určité míry přizpůsobit. Dokumentace k poskytovatelům identity Microsoft je uvedena níže:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Deklarace přístupového tokenu</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">Deklarace tokenu ID</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Konfigurace volitelných deklarací</a>: Pozor, „Email“ je u typu IdP Microsoft Entra ID (v1.0) volitelná deklarace.</li>
</ul>';
$string['cfg_field_mapping_desc_generic'] = 'Data uživatelského profilu lze mapovat z IdP OpenID Connect do Moodle. Vzdálená pole dostupná pro mapování závisejí na typu IdP.<br/>
<ul>
<li>Základní pole profilu jsou dostupná z deklarací ID tokenu a přístupového tokenu, které váš IdP vydává. Pole, která lze mapovat, například jméno, příjmení a e-mailová adresa, proto závisejí na deklaracích, které váš IdP do těchto tokenů zahrnuje.</li>
<li>Další deklarace lze přidat do seznamu polí dostupných pro mapování pomocí nastavení „{$a}“.</li>
</ul>
Většina IdP umožňuje určitou úpravu vydávaných deklarací. Podporované deklarace najdete v dokumentaci svého IdP.';
$string['cfg_field_mapping_desc_external_id'] = 'Data uživatelského profilu lze mapovat z Microsoft Entra External ID do Moodle. Vzdálená pole dostupná pro mapování jsou deklarace ID tokenu a přístupového tokenu, protože pro tento typ IdP se Microsoft Graph nepoužívá.<br/>
<ul>
<li>Základní pole profilu jsou dostupná z deklarací ID tokenu a přístupového tokenu.</li>
<li>Ve výchozím nastavení obsahuje ID token tenanta External ID pouze jméno, ID objektu a přihlašovací jméno uživatele. Chcete-li mapovat jméno, příjmení a e-mailovou adresu, přidejte deklarace given_name, family_name a email jako volitelné deklarace do ID tokenu v registraci aplikace ve svém tenantovi External ID (Konfigurace tokenu). Deklarace email se vydává, pouze pokud má uživatel v tenantovi e-mailovou adresu.</li>
<li>Další deklarace lze přidat do seznamu polí dostupných pro mapování pomocí nastavení „{$a}“.</li>
</ul>
Dokumentace k deklaracím tokenů Microsoft je odkazována níže:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Deklarace přístupového tokenu</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">Deklarace tokenu ID</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Konfigurace volitelných deklarací</a></li>
</ul>';

$string['cfg_cleanupoidctokens_key'] = 'Vyčistit tokeny OpenID Connect';
$string['cfg_cleanupoidctokens_desc'] = 'Pokud mají vaši uživatelé potíže s přihlášením pomocí účtu Microsoft 365, zkuste vyčistit tokeny OpenID Connect. Tím se odstraní osiřelé a neúplné tokeny, které mohou způsobovat chyby. UPOZORNĚNÍ: Může to přerušit probíhající přihlášení, proto je nejlepší to provést v době odstávky.';
$string['settings_section_basic'] = 'Základní nastavení';
$string['settings_section_authentication'] = 'Ověřování';
$string['settings_section_endpoints'] = 'Koncové body';
$string['settings_section_other_params'] = 'Další parametry';
$string['settings_section_secret_expiry_notification'] = 'Upozornění na vypršení tajného klíče';
$string['application_updated'] = 'Nastavení aplikace OpenID Connect byla aktualizována.';
$string['application_updated_microsoft'] = 'Nastavení aplikace OpenID Connect bylo aktualizováno.<br/>
<span class="warning" style="color: red;">Pokud byla změněna nastavení „Typ poskytovatele identity (IdP)“ nebo „Metoda ověřování klienta“, bude muset správce Microsoft Entra ID znovu provést <b>Udělit souhlas správce</b> a <b>Ověření nastavení</b> na stránce konfigurace integrace Microsoft 365.</span>';
$string['application_updated_microsoft_notify'] = 'Nastavení aplikace OpenID Connect bylo aktualizováno.<br/>
<span class="warning" style="color: red;">Pokud byla změněna nastavení „Typ poskytovatele identity (IdP)“ nebo „Metoda ověřování klienta“, bude muset správce Microsoft Entra ID znovu provést <b>Udělit souhlas správce</b> a <b>Ověření nastavení</b> na <a href="{$a}">stránce konfigurace integrace Microsoft 365</a>.</span>';
$string['application_not_changed'] = 'Nastavení aplikace OpenID Connect nebylo změněno.';

$string['event_debug'] = 'Zpráva ladění';

$string['task_cleanup_oidc_state_and_token'] = 'Vyčištění stavů OIDC a neplatných tokenů';
$string['task_cleanup_oidc_sid'] = 'Vyčištění záznamů SID OIDC';

$string['errorauthdisconnectemptypassword'] = 'Heslo nemůže být prázdné.';
$string['errorauthdisconnectemptyusername'] = 'Uživatelské jméno nemůže být prázdné.';
$string['errorauthdisconnectusernameexists'] = 'Toto uživatelské jméno se již používá. Zvolte jiné.';
$string['errorauthdisconnectnewmethod'] = 'Použít metodu přihlášení';
$string['errorauthdisconnectinvalidmethod'] = 'Přijata neplatná metoda přihlášení.';
$string['errorauthdisconnectifmanual'] = 'Pokud používáte metodu ručního přihlášení, zadejte níže přihlašovací údaje.';
$string['errorauthgeneral'] = 'Při vašem přihlašování došlo k problému. Požádejte o pomoc svého správce.';
$string['errorauthinvalididtoken'] = 'Přijato neplatné id_token.';
$string['errorauthloginfailednouser'] = 'Neplatné přihlášení: Přihlásili jste se jako „{$a}“, ale na tomto webu neexistuje odpovídající účet a nové účty nelze vytvářet automaticky. Požádejte o pomoc správce webu. Máte-li více účtů, vyberte Pokračovat a přihlaste se jiným účtem.';
$string['errorauthloginfaileddupemail'] = 'Neplatné přihlášení: Existující účet v tomto Moodlu má stejnou e-mailovou adresu jako účet, který se pokoušíte vytvořit, a nastavení „Povolit účty se stejným e-mailem“ (allowaccountssameemail) je zakázáno.';
$string['errorauthmfarequired'] = 'Microsoft k dokončení vašeho přihlášení vyžaduje vícefaktorové ověřování, které se však nepodařilo dokončit. Zkuste to znovu nebo se přihlaste k Microsoft 365 v nové relaci prohlížeče a dokončete výzvu vícefaktorového ověřování.';
$string['errorauthnoauthcode'] = 'Ze serveru identit nebyl přijat žádný autorizační kód. Další informace mohou obsahovat protokoly chyb.';
$string['errorauthnocredsandendpoints'] = 'Nakonfigurujte přihlašovací údaje klienta OpenID Connect a koncové body.';
$string['errorauthnoidtoken'] = 'Nebylo přijato id_token OpenID Connect.';
$string['errorauthnoaccesstoken'] = 'Nebyl přijat přístupový token.';
$string['errorauthunknownstate'] = 'Neznámý stav.';
$string['errorauthuseralreadyconnected'] = 'Jste již připojeni k jinému uživateli OpenID Connect.';
$string['errorauthuserconnectedtodifferent'] = 'Uživatel OpenID Connect, který byl ověřen, je již připojen k uživateli Moodle.';
$string['errorbadloginflow'] = 'Byl zadán neplatný typ ověřování. Poznámka: Pokud se vám tato zpráva zobrazuje po nedávné instalaci nebo upgradu, vymažte mezipaměť Moodlu.';
$string['errorjwtbadpayload'] = 'Nejde přečíst datovou část JWT.';
$string['errorjwtcouldnotreadheader'] = 'Nelze číst hlavičku JWT.';
$string['errorjwtempty'] = 'Přijato prázdné nebo ne-řetězec JWT.';
$string['errorjwtinvalidheader'] = 'Neplatná hlavička JWT';
$string['errorjwtmalformed'] = 'Přijato poškozené JWT.';
$string['errorjwtunsupportedalg'] = 'JWS Alg nebo JWE není podporováno';
$string['erroroidcnotenabled'] = 'Ověřovací modul OpenID Connect není povolen.';
$string['errornodisconnectionauthmethod'] = 'Nelze se odpojit, protože není povolen žádný ověřovací modul, na který by bylo možné přejít (buď uživatelova předchozí metoda přihlášení, nebo metoda ručního přihlášení).';
$string['erroroidcclientinvalidendpoint'] = 'Přijato neplatné URI koncového bodu.';
$string['erroroidcclientnocreds'] = 'Nastavte přihlašovací údaje klienta pomocí setcreds';
$string['erroroidcclientnoauthendpoint'] = 'Není nastaven žádný koncový bod autorizace. Nastavte pomocí $this->setendpoints';
$string['erroroidcclientnotokenendpoint'] = 'Není nastaven žádný koncový bod tokenu. Nastavte pomocí $this->setendpoints';
$string['errorrestricted'] = 'Tento web má zavedena omezení pro uživatele, kteří se mohou přihlásit pomocí OpenID Connect. Tato omezení vám v současné době brání dokončit tento pokus o přihlášení.';
$string['errorucpinvalidaction'] = 'Přijata neplatná akce.';
$string['erroroidccall'] = 'Chyba v OpenID Connect. Další informace naleznete v protokolech.';
$string['erroroidccall_message'] = 'Chyba v OpenID Connect: {$a}';
$string['errorinvalidredirect_message'] = 'URL, na kterou se pokoušíte přesměrovat, neexistuje.';
$string['errorinvalidcertificatesource'] = 'Neplatný zdroj certifikátu';
$string['error_invalid_client_authentication_method'] = 'Neplatná metoda ověřování klienta';
$string['error_certificate_requires_identity_platform'] = 'Ověřování certifikátem vyžaduje typ IdP „Microsoft identity platform (v2.0)“.';
$string['error_empty_client_secret'] = 'Při použití metody ověřování „tajným klíčem“ nemůže být tajný klíč klienta prázdný';
$string['error_empty_client_private_key'] = 'Při použití metody ověřování „certifikátem“ nemůže být soukromý klíč certifikátu klienta prázdný';
$string['error_empty_client_cert'] = 'Při použití metody ověřování „certifikátem“ nemůže být veřejný klíč certifikátu klienta prázdný';
$string['error_empty_client_private_key_file'] = 'Při použití metody ověřování „certifikátem“ nemůže být soubor soukromého klíče certifikátu klienta prázdný';
$string['error_empty_client_cert_file'] = 'Při použití metody ověřování „certifikátem“ nemůže být soubor veřejného klíče certifikátu klienta prázdný';
$string['error_endpoint_mismatch_auth_endpoint'] = 'Nakonfigurovaný koncový bod autorizace neodpovídá nastavenému typu IdP. Pro „Microsoft Entra ID (v1.0)“ použijte koncový bod v1.0 (např. https://login.microsoftonline.com/organizations/oauth2/authorize). Pro „Microsoft identity platform (v2.0)“ použijte koncový bod v2.0 (např. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize).';
$string['error_endpoint_mismatch_token_endpoint'] = 'Nakonfigurovaný koncový bod tokenů neodpovídá nastavenému typu IdP. Pro „Microsoft Entra ID (v1.0)“ použijte koncový bod v1.0 (např. https://login.microsoftonline.com/organizations/oauth2/token). Pro „Microsoft identity platform (v2.0)“ použijte koncový bod v2.0 (např. https://login.microsoftonline.com/organizations/oauth2/v2.0/token).';
$string['error_endpoint_external_id'] = 'Koncový bod musí být koncový bod Microsoft Entra External ID v2.0 na hostiteli ciamlogin.com, např. https://contoso.ciamlogin.com/[tenant-id]/oauth2/v2.0/authorize.';
$string['error_logoutendpoint_external_id'] = 'Koncový bod odhlášení musí být koncový bod Microsoft Entra External ID v2.0 na hostiteli ciamlogin.com, např. https://contoso.ciamlogin.com/[tenant-id]/oauth2/v2.0/logout. Ponecháte-li pole prázdné, použije se koncový bod odvozený z koncového bodu autorizace.';
$string['error_endpoint_external_id_placeholder'] = 'Nahraďte zástupné symboly [tenant-name] a [tenant-id] hodnotami svého tenanta Microsoft Entra External ID.';
$string['error_endpoint_external_id_tenant'] = 'Tenanti Microsoft Entra External ID jsou jednotenantové. V koncovém bodě použijte ID nebo název tenanta místo common, organizations nebo consumers.';
$string['error_endpoint_external_id_v1'] = 'Toto je koncový bod v1.0. Microsoft Entra External ID vyžaduje koncový bod v2.0 s /oauth2/v2.0/ v cestě.';
$string['error_endpoint_external_id_kind'] = 'Koncový bod musí končit na /{$a}.';
$string['error_endpoint_external_id_mismatch'] = 'Koncové body autorizace a tokenu musí patřit ke stejnému tenantovi Microsoft Entra External ID.';
$string['error_endpoint_is_external_id'] = 'Toto je koncový bod Microsoft Entra External ID. Nastavte typ IdP na Microsoft Entra External ID, nebo pro tento typ IdP použijte koncový bod login.microsoftonline.com.';
$string['error_tenant_specific_endpoint_required'] = 'Při použití typu IdP „Microsoft identity platform (v2.0)“ a metody ověřování „Certifikát“ je vyžadován koncový bod specifický pro tenanta (tj. ne common/organizations/consumers).';
$string['error_empty_oidcresource'] = 'Zdroj nesmí být prázdný při použití Microsoft Entra ID (v1.0).';
$string['error_invalid_custom_claim'] = 'Neplatné názvy vlastních deklarací: {$a}. Názvy vlastních deklarací mohou obsahovat pouze alfanumerické znaky, pomlčky a podtržítka a nesmí to být rezervovaný název deklarace (např. standardní deklarace JWT/OpenID Connect nebo deklarace specifická pro Microsoft Entra ID či Keycloak) ani existující možnost mapování polí.';
$string['error_masked_secret_not_changed'] = 'Zadejte novou hodnotu, nebo zrušte zaškrtnutí políčka „Změnit“, chcete-li zachovat aktuální hodnotu.';
$string['auth_settings_validation_error'] = 'Byla zjištěna neplatná nastavení ověřování. Pro úspěšné ověřování je třeba vyřešit následující problémy s konfigurací:';
$string['error_secretexpiryrecipients_invalid'] = 'Následující příjemci upozornění na vypršení tajného klíče nejsou platné e-mailové adresy: {$a}';
$string['errorupnchangeisnotsupported'] = 'UPN vašeho účtu Microsoft se změnil. Požádejte svého správce o aktualizaci vašeho účtu Moodle.';
$string['erroruserwithusernamealreadyexists'] = 'Při pokusu o přejmenování vašeho účtu Moodle došlo k chybě. Uživatel Moodle s novým uživatelským jménem již existuje. Požádejte nejprve správce webu, aby to vyřešil.';
$string['error_no_response_available'] = 'Nejsou k dispozici žádné odpovědi.';

$string['eventuserauthed'] = 'Uživatel autorizován s OpenID Connect';
$string['eventusercreated'] = 'Uživatel vytvořen s OpenID Connect';
$string['eventuserconnected'] = 'Uživatel připojen k OpenID Connect';
$string['eventuserloggedin'] = 'Uživatel přihlášen s OpenID Connect';
$string['eventuserdisconnected'] = 'Uživatel odpojen od OpenID Connect';
$string['eventuserrenameattempt'] = 'Modul auth_oidc se pokusil přejmenovat uživatele';

$string['oidc:manageconnection'] = 'Povolit připojení a odpojení OpenID Connect';
$string['oidc:manageconnectionconnect'] = 'Povolit připojení OpenID Connect';
$string['oidc:manageconnectiondisconnect'] = 'Povolit odpojení OpenID Connect';

$string['privacy:metadata:auth_oidc'] = 'Ověřování OpenID Connect';
$string['privacy:metadata:auth_oidc_prevlogin'] = 'Předchozí metody přihlášení pro zrušení připojení k Microsoft 365';
$string['privacy:metadata:auth_oidc_prevlogin:userid'] = 'ID uživatele Moodle';
$string['privacy:metadata:auth_oidc_prevlogin:method'] = 'Předchozí metoda přihlášení';
$string['privacy:metadata:auth_oidc_prevlogin:password'] = 'Předchozí (zašifrované) pole hesla uživatele.';
$string['privacy:metadata:auth_oidc_token'] = 'Tokeny OpenID Connect';
$string['privacy:metadata:auth_oidc_token:oidcuniqid'] = 'Jedinečný identifikátor uživatele OIDC.';
$string['privacy:metadata:auth_oidc_token:username'] = 'Uživatelské jméno uživatele Moodle';
$string['privacy:metadata:auth_oidc_token:userid'] = 'ID uživatele Moodle';
$string['privacy:metadata:auth_oidc_token:oidcusername'] = 'Uživatelské jméno uživatele OIDC';
$string['privacy:metadata:auth_oidc_token:useridentifier'] = 'Identifikátor uživatele OIDC';
$string['privacy:metadata:auth_oidc_token:scope'] = 'Rozsah (scope) tokenu';
$string['privacy:metadata:auth_oidc_token:tokenresource'] = 'Prostředek tokenu';
$string['privacy:metadata:auth_oidc_token:authcode'] = 'Autorizační kód pro token';
$string['privacy:metadata:auth_oidc_token:token'] = 'Token';
$string['privacy:metadata:auth_oidc_token:expiry'] = 'Vypršení platnosti tokenu';
$string['privacy:metadata:auth_oidc_token:refreshtoken'] = 'Obnovovací token';
$string['privacy:metadata:auth_oidc_token:idtoken'] = 'Token ID';
$string['privacy:metadata:auth_oidc_sid'] = 'Identifikátory relací IdP (sid) používané k nalezení připojených uživatelů Moodle, když IdP spustí jednotné odhlášení (SLO)';
$string['privacy:metadata:auth_oidc_sid:userid'] = 'ID uživatele Moodle';
$string['privacy:metadata:auth_oidc_sid:sid'] = 'Identifikátor relace IdP (sid)';
$string['privacy:metadata:auth_oidc_sid:timecreated'] = 'Čas vytvoření mapování';
$string['privacy:metadata:auth_oidc_sid:sessionid'] = 'ID relace Moodle aktivní v době vytvoření mapování';
$string['privacy:metadata:auth_oidc_sid:iss'] = 'Vydavatel (deklarace iss) tokenu id_token, ze kterého bylo mapování vytvořeno';

// In the following strings, $a refers to a customizable name for the identity manager. For example, this could be
// "Microsoft 365", "OpenID Connect", etc.
$string['ucp_general_intro'] = 'Zde můžete spravovat své připojení k {$a}. Pokud je nastavení povoleno, budete moci použít svůj účet {$a} k přihlášení do Moodlu namísto používání samostatného uživatelského jména a hesla. Jakmile se připojíte, nebudete si muset nadále pamatovat svoje uživatelské jméno a heslo pro Moodle, veškerá přihlášení budou probíhat přes {$a}.';
$string['ucp_login_start'] = 'Začít používat {$a} k přihlašování do Moodlu';
$string['ucp_login_start_desc'] = 'Toto přepne váš účet, aby k přihlašování do Moodlu používal {$a}. Jakmile nastavení povolíte, budete se přihlašovat se svými přihlašovacími údaji {$a} – vaše aktuální uživatelské jméno a heslo pro Moodle nebudou fungovat. Kdykoli můžete svůj účet odpojit a vrátit se k normálnímu přihlašování.';
$string['ucp_login_stop'] = 'Přestat používat {$a} k přihlašování do Moodlu';
$string['ucp_login_stop_desc'] = 'Aktuálně k přihlašování do Moodlu používáte {$a}. Když kliknete na „Přestat používat {$a} k přihlašování do Moodlu“, váš účet Moodle se odpojí od {$a}. Nebudete se nadále moci přihlašovat do Moodlu pomocí účtu {$a}. Budete požádáni, abyste si vytvořili uživatelské jméno a heslo, a od té chvíle se pak budete moci do Moodlu přihlašovat přímo.';
$string['ucp_login_status'] = 'Přihlašování {$a} je:';
$string['ucp_status_enabled'] = 'Povoleno';
$string['ucp_status_disabled'] = 'Zakázáno';
$string['ucp_disconnect_title'] = 'Odpojení {$a}';
$string['ucp_disconnect_details'] = 'Váš účet Moodle bude odpojen od {$a}. Budete si muset vytvořit uživatelské jméno a heslo pro přihlašování do Moodlu.';
$string['ucp_title'] = 'Správa {$a}';
$string['ucp_o365accountconnected'] = 'Tento účet Microsoft 365 je již připojen k jinému účtu Moodle.';

// Clean up OIDC tokens.
$string['cleanup_oidc_tokens'] = 'Vyčistit tokeny OpenID Connect';
$string['unmatched'] = 'Nespárováno';
$string['delete_token'] = 'Odstranit token';
$string['mismatched'] = 'Neshoda';
$string['na'] = 'neuvedeno';
$string['mismatched_details'] = 'Záznam tokenu obsahuje uživatelské jméno „{$a->tokenusername}“; spárovaný uživatel Moodle má uživatelské jméno „{$a->moodleusername}“.';
$string['delete_token_and_reference'] = 'Odstranit token a odkaz';
$string['table_token_id'] = 'ID záznamu tokenu';
$string['table_oidc_username'] = 'Uživatelské jméno OIDC';
$string['table_oidc_unique_identifier'] = 'Jedinečný identifikátor OIDC';
$string['table_token_unique_id'] = 'Jedinečné ID OIDC';
$string['table_matching_status'] = 'Stav párování';
$string['table_matching_details'] = 'Podrobnosti';
$string['table_action'] = 'Akce';
$string['token_deleted'] = 'Token byl úspěšně odstraněn';
$string['no_token_to_cleanup'] = 'Nejsou žádné tokeny OIDC k vyčištění.';

$string['errorusermatched'] = 'Účet Microsoft 365 „{$a->entraidupn}“ je již spárován s uživatelem Moodle „{$a->username}“. Chcete-li připojení dokončit, přihlaste se nejprve jako tento uživatel Moodle a postupujte podle pokynů v bloku Microsoft.';

// User mapping options.
$string['update_oncreate_and_onlogin'] = 'Při vytvoření a při každém přihlášení';
$string['update_oncreate_and_onlogin_and_usersync'] = 'Při vytvoření, při každém přihlášení a při každém běhu úlohy synchronizace uživatelů';
$string['update_oncreate_and_usersync'] = 'Při vytvoření a při každém běhu úlohy synchronizace uživatelů';
$string['update_onlogin_and_usersync'] = 'Při každém přihlášení a při každém běhu úlohy synchronizace uživatelů';
$string['upgradeoidcuniqidtoolong'] = 'Upgrade nemůže pokračovat: některé záznamy auth_oidc_token mají oidcuniqid delší než 200 znaků, který by nová délka sloupce zkrátila. Odstraňte tyto záznamy tokenů a spusťte upgrade znovu.';

// Remote fields.
$string['settings_fieldmap_feild_not_mapped'] = '(nemapováno)';
$string['settings_fieldmap_field_bindingusernameclaim'] = 'Deklarace pro vazbu uživatelského jména (lze mapovat pouze při přihlášení)';
$string['settings_fieldmap_field_city'] = 'Město';
$string['settings_fieldmap_field_companyName'] = 'Název společnosti';
$string['settings_fieldmap_field_objectId'] = 'ID objektu';
$string['settings_fieldmap_field_country'] = 'Země';
$string['settings_fieldmap_field_department'] = 'Oddělení';
$string['settings_fieldmap_field_displayName'] = 'Zobrazované jméno';
$string['settings_fieldmap_field_surname'] = 'Příjmení';
$string['settings_fieldmap_field_faxNumber'] = 'Číslo faxu';
$string['settings_fieldmap_field_telephoneNumber'] = 'Telefonní číslo';
$string['settings_fieldmap_field_givenName'] = 'Křestní jméno';
$string['settings_fieldmap_field_jobTitle'] = 'Pracovní pozice';
$string['settings_fieldmap_field_mail'] = 'E-mail';
$string['settings_fieldmap_field_mobile'] = 'Mobil';
$string['settings_fieldmap_field_postalCode'] = 'PSČ';
$string['settings_fieldmap_field_preferredLanguage'] = 'Jazyk';
$string['settings_fieldmap_field_state'] = 'Kraj/stát';
$string['settings_fieldmap_field_streetAddress'] = 'Ulice a číslo';
$string['settings_fieldmap_field_userPrincipalName'] = 'Hlavní název uživatele (UPN)';
$string['settings_fieldmap_field_employeeId'] = 'ID zaměstnance';
$string['settings_fieldmap_field_employeeType'] = 'Typ zaměstnance';
$string['settings_fieldmap_field_accountEnabled'] = 'Účet povolen';
$string['settings_fieldmap_field_businessPhones'] = 'Telefon do kanceláře';
$string['settings_fieldmap_field_mobilePhone'] = 'Mobilní telefon';
$string['settings_fieldmap_field_officeLocation'] = 'Kancelář';
$string['settings_fieldmap_field_preferredName'] = 'Preferované jméno';
$string['settings_fieldmap_field_manager'] = 'Jméno nadřízeného';
$string['settings_fieldmap_field_manager_email'] = 'E-mail nadřízeného';
$string['settings_fieldmap_field_teams'] = 'Týmy';
$string['settings_fieldmap_field_groups'] = 'Skupiny';
$string['settings_fieldmap_field_roles'] = 'Role';
$string['settings_fieldmap_field_tokenclaim'] = '{$a} (deklarace tokenu)';
$string['settings_fieldmap_field_onPremisesSamAccountName'] = 'Místní název účtu SAM';
$string['settings_fieldmap_field_extensionattribute'] = 'Atribut rozšíření {$a}';
$string['settings_fieldmap_field_sds_school_id'] = 'ID školy SDS ({$a})';
$string['settings_fieldmap_field_sds_school_name'] = 'Název školy SDS ({$a})';
$string['settings_fieldmap_field_sds_school_role'] = 'Role ve škole SDS („Student“ nebo „Teacher“)';
$string['settings_fieldmap_field_sds_student_externalId'] = 'Externí ID studenta SDS';
$string['settings_fieldmap_field_sds_student_birthDate'] = 'Datum narození studenta SDS';
$string['settings_fieldmap_field_sds_student_grade'] = 'Ročník studenta SDS';
$string['settings_fieldmap_field_sds_student_graduationYear'] = 'Rok absolvování studenta SDS';
$string['settings_fieldmap_field_sds_student_studentNumber'] = 'Číslo studenta SDS';
$string['settings_fieldmap_field_sds_teacher_externalId'] = 'Externí ID učitele SDS';
$string['settings_fieldmap_field_sds_teacher_teacherNumber'] = 'Číslo učitele SDS';

// Binding username claim options.
$string['binding_username_claim_warning'] = 'Toto je pokročilá funkce. Ve většině případů by měla zůstat nastavena na „Vybrat automaticky“; nesprávná konfigurace může ovlivnit záznamy uživatelů a narušit jednotné přihlašování (SSO).';
$string['binding_username_auto'] = 'Vybrat automaticky';
$string['binding_username_custom'] = 'Vlastní';
$string['bindingusernameclaim'] = 'Deklarace pro vazbu uživatelského jména';
$string['customclaimname'] = 'Název vlastní deklarace';
$string['customclaimname_description'] = 'Toto pole se použije pouze tehdy, je-li nastavení <b>Deklarace pro vazbu uživatelského jména</b> nastaveno na <b>Vlastní</b>.';
$string['binding_username_claim_tool_link_desc'] = 'Chcete-li aktualizovat deklaraci pro vazbu uživatelského jména u stávajících uživatelů, použijte <a href="{$a}">Nástroj pro změnu deklarace pro vazbu uživatelského jména</a>.';
$string['cleanup_oidc_tokens_link_desc'] = 'Chcete-li vyčistit zastaralé tokeny OpenID Connect, použijte nástroj <a href="{$a}">Vyčistit tokeny OpenID Connect</a>.';
$string['clear_user_tokens_link_desc'] = 'Chcete-li odstranit uložené tokeny všech uživatelů nebo vybraných uživatelů, použijte nástroj <a href="{$a}">Vymazat tokeny uživatelů</a>.';
$string['clear_user_tokens'] = 'Vymazat tokeny uživatelů';
$string['clear_user_tokens_desc'] = 'Odstraní tokeny OpenID Connect a Microsoft 365 uložené pro uživatele. Dotčení uživatelé získají nové tokeny při příštím přihlášení pomocí OpenID Connect nebo při připojení k Microsoft 365. Jejich propojení s účty Microsoft 365 zůstanou zachována. UPOZORNĚNÍ: Může to přerušit probíhající přihlášení, proto je nejlepší to provést v době odstávky.';
$string['clear_user_tokens_desc_generic'] = 'Odstraní tokeny OpenID Connect uložené pro uživatele. Dotčení uživatelé získají nové tokeny při dalším přihlášení pomocí OpenID Connect. UPOZORNĚNÍ: Může to přerušit probíhající přihlášení, proto je nejlepší to provést během odstávky.';
$string['clear_user_tokens_scope_selected'] = 'Vybraní uživatelé';
$string['clear_user_tokens_scope_all'] = 'Všichni uživatelé';
$string['clear_user_tokens_users'] = 'Uživatelé';
$string['clear_user_tokens_submit'] = 'Vymazat tokeny';
$string['clear_user_tokens_no_name'] = '(bez jména)';
$string['clear_user_tokens_no_user_selected'] = 'Vyberte alespoň jednoho uživatele.';
$string['clear_user_tokens_confirm_all'] = 'Opravdu chcete vymazat tokeny všech uživatelů? Počet uživatelů, kteří aktuálně mají tokeny: {$a}.';
$string['clear_user_tokens_confirm_selected'] = 'Opravdu chcete vymazat tokeny vybraných uživatelů? Počet vybraných uživatelů, kteří aktuálně mají tokeny: {$a}.';
$string['clear_user_tokens_success'] = 'Počet vymazaných záznamů tokenů: {$a}.';
$string['binding_username_claim_help_ms_no_user_sync'] = 'Možnosti pro IdP od Microsoftu bez povolené funkce synchronizace uživatelů:
<ul>
<li><b>Vybrat automaticky</b>: Použije aktuální logiku, která určí token podle typu IdP, a pokud žádná deklarace není nalezena, použije <b>sub</b>.</li>
<li><b>preferred_username</b>: Výchozí pro typ IdP Microsoft identity platform (v2.0). <span class="not_support_user_sync">Nepodporuje synchronizaci uživatelů.</span></li>
<li><b>email</b>: Záložní možnost pro Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: Výchozí pro Microsoft Entra ID (v1.0) a jiné typy IdP.</li>
<li><b>unique_name</b>: Záložní možnost pro Microsoft Entra ID (v1.0) a jiné typy IdP. <span class="not_support_user_sync">Nepodporuje synchronizaci uživatelů.</span></li>
<li><b>oid</b>: Záložní možnost, pokud nejsou k dispozici žádné jiné deklarace. Je k dispozici pouze u IdP od Microsoftu.</li>
<li><b>sub</b>: Záložní možnost, pokud nejsou k dispozici žádné jiné deklarace. <span class="not_support_user_sync">Nepodporuje synchronizaci uživatelů.</span></li>
<li><b>samaccountname</b>: Vlastní deklarace.</li>
<li><b>Vlastní</b>: Umožňuje správci webu zadat vlastní hodnotu. <span class="not_support_user_sync">Nepodporuje synchronizaci uživatelů.</span></li>
</ul>
Pozor: některé možnosti nepodporují synchronizaci uživatelů.';
$string['binding_username_claim_help_ms_with_user_sync'] = 'Možnosti pro IdP od Microsoftu s povolenou funkcí synchronizace uživatelů:
<ul>
<li><b>Vybrat automaticky</b>: Použije aktuální logiku, která určí token podle typu IdP, a pokud žádná deklarace není nalezena, použije <b>sub</b>.</li>
<li><b>email</b>: Záložní možnost pro Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: Výchozí pro Microsoft Entra ID (v1.0) a jiné typy IdP.</li>
<li><b>oid</b>: Záložní možnost, pokud nejsou k dispozici žádné jiné deklarace. Je k dispozici pouze u IdP od Microsoftu.</li>
<li><b>samaccountname</b>: Vlastní deklarace.</li>
</ul>';
$string['binding_username_claim_help_non_ms'] = 'Možnosti pro IdP jiné než od Microsoftu:
<ul>
<li><b>Vybrat automaticky</b>: Použije aktuální logiku, která určí token podle typu IdP, a pokud žádná deklarace není nalezena, použije <b>sub</b>.</li>
<li><b>preferred_username</b></li>
<li><b>email</b></li>
<li><b>unique_name</b></li>
<li><b>sub</b></li>
<li><b>samaccountname</b></li>
<li><b>custom</b>: Vlastní deklarace.</li>
</ul>';
$string['binding_username_claim_help_external_id'] = 'Možnosti pro Microsoft Entra External ID zahrnují:
<ul>
<li><b>Vybrat automaticky</b>: Použije <b>oid</b>, poté <b>sub</b>.</li>
<li><b>oid</b>: Jedinečné a stabilní ID objektu uživatele v tenantovi (doporučeno).</li>
<li><b>sub</b></li>
<li><b>email</b>: E-mailová adresa uživatele. Může se změnit, čímž se přeruší propojení s účtem Moodle.</li>
<li><b>preferred_username</b>: Přihlašovací jméno uživatele. Může se změnit, čímž se přeruší propojení s účtem Moodle.</li>
<li><b>vlastní</b>: Vlastní deklarace.</li>
</ul>
Tokeny External ID neobsahují deklarace pro zaměstnance, například upn nebo samaccountname. Zajistěte, aby zvolená deklarace byla jedinečná a stabilní.';
$string['warning_binding_username_claim_custom_unsupported'] = 'Nastavení „Deklarace pro vazbu uživatelského jména“ je aktuálně nastaveno na „Vlastní“, což u nakonfigurovaného typu IdP s povolenou synchronizací uživatelů není podporováno. Zkontrolujte nastavení <a href="{$a}">Deklarace pro vazbu uživatelského jména</a>.';
$string['examplecsv'] = 'Příklad souboru pro nahrání';
$string['usernamefile'] = 'Soubor';
$string['csvdelimiter'] = 'Oddělovač CSV';
$string['encoding'] = 'Kódování';
$string['rowpreviewnum'] = 'Řádky náhledu';
$string['upload_usernames'] = 'Aktualizovat vazební uživatelská jména';
$string['update_stats_users_updated'] = 'Počet aktualizovaných uživatelů: {$a}';
$string['update_stats_users_errors'] = 'Počet uživatelů s chybami: {$a}';
$string['update_error_incomplete_line'] = 'Řádek neobsahuje povinná pole.';
$string['update_error_user_not_found'] = 'Nebyl nalezen žádný uživatel odpovídající uživatelskému jménu. Bude proveden pokus o aktualizaci ručně spárovaného uživatele.';
$string['update_error_user_not_oidc'] = 'Uživatel nepoužívá metodu ověřování OpenID Connect. Bude proveden pokus o aktualizaci ručně spárovaného uživatele.';
$string['update_error_invalid_new_username'] = 'Nové uživatelské jméno je neplatné.';
$string['update_error_user_update_failed'] = 'Aktualizace uživatele se nezdařila.';
$string['update_warning_email_match'] = 'E-mail odpovídá existujícímu uživateli.';
$string['update_success_username'] = 'Uživatelské jméno bylo úspěšně aktualizováno.';
$string['update_success_token'] = 'Token byl úspěšně aktualizován.';
$string['update_success_o365'] = 'Záznam o připojení k Microsoft 365 byl úspěšně aktualizován.';
$string['update_error_nothing_updated'] = 'Nic nebylo aktualizováno.';
$string['error_invalid_upload_file'] = 'Neplatný nahraný soubor.';
$string['csvline'] = 'Řádek CSV';
$string['change_binding_username_claim_tool_description'] = '<p class="warning_header">Toto je pokročilá funkce. Nesprávné použití může ovlivnit záznamy uživatelů a narušit jednotné přihlašování (SSO).</p>
<p>Tento nástroj umožňuje správcům webu hromadně aktualizovat následující záznamy:</p>
<ul>
<li>uživatelská jména účtů Moodle,</li>
<li>vazební uživatelská jména v uložených tokenech ID OpenID Connect,</li>
<!--o365-start--><li>záznamy o propojení účtů Moodle a Microsoft.</li><!--o365-end-->
</ul>
<p>Měl by se používat pouze při změně nastavení <b>Deklarace pro vazbu uživatelského jména</b>.</p>
<p>Nástroj přijímá jednoduchý soubor CSV se dvěma sloupci:</p>
<ul>
<li><b><span class="auth_oidc_code">username</span></b>: Aktuální uživatelské jméno účtu Moodle, který se má aktualizovat, nebo – pokud je aktuální uživatel spárován ručně – aktuální hodnota vazební deklarace.</li>
<li><b><span class="auth_oidc_code">new_username</span></b>: Hodnota nové deklarace tokenu (s rozlišením velkých a malých písmen), která se použije jako deklarace pro vazbu uživatelského jména. Pokud je uživatel spárován automaticky a používá typ ověřování OpenID Connect, použije se tato hodnota převedená na malá písmena jako uživatelské jméno v Moodlu.</li>
</ul>
<p>Po nahrání souboru nástroj provede následující akce:</p>
<ol>
<li>Vyhledá existujícího uživatele Moodle, jehož uživatelské jméno nebo e-mailová adresa odpovídá zadané hodnotě <span class="auth_oidc_code">username</span> a který používá metodu ověřování OpenID Connect, a pokud jej najde, změní jeho uživatelské jméno na hodnotu <span class="auth_oidc_code">new_username</span> převedenou na malá písmena.</li>
<li>Aktualizuje záznam tokenu OpenID Connect.
<ul>
<li>Pokud byl v kroku 1 nalezen uživatel, vyhledá záznam tokenu tohoto uživatele v tabulce <span class="auth_oidc_code">auth_oidc_token</span> a nastaví sloupec <span class="auth_oidc_code">username</span> na hodnotu <span class="auth_oidc_code">new_username</span> převedenou na malá písmena a sloupec <span class="auth_oidc_code">oidcusername</span> na hodnotu <span class="auth_oidc_code">new_username</span>.</li>
<li>Pokud výše nebyl nalezen žádný záznam, pokusí se v tabulce <span class="auth_oidc_code">auth_oidc_token</span> najít záznam, jehož sloupec <span class="auth_oidc_code">oidcusername</span> odpovídá starému <span class="auth_oidc_code">username</span>, a změní jej na <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
<!--o365-start--><li>Je-li nainstalován modul <span class="auth_oidc_code">local_o365</span>, aktualizuje záznam o připojení uživatele.
<ul>
<li>Pokud byl v kroku 1 nalezen uživatel, vyhledá záznam o připojení tohoto uživatele v tabulce <span class="auth_oidc_code">local_o365_objects</span> a nastaví sloupec <span class="auth_oidc_code">o365name</span> na hodnotu <span class="auth_oidc_code">new_username</span>.</li>
<li>Pokud v kroku 1 nebyl nalezen žádný uživatel, pokusí se v tabulce <span class="auth_oidc_code">local_o365_objects</span> najít záznam uživatele, jehož <span class="auth_oidc_code">o365name</span> odpovídá hodnotě <span class="auth_oidc_code">username</span>, a změní jej na hodnotu <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li><!--o365-end-->
</ol>
<p>Níže uvedený vzorový soubor by změnil deklaraci pro vazbu uživatelského jména z <span class="auth_oidc_code">upn</span> nebo <span class="auth_oidc_code">email</span> na <span class="auth_oidc_code">oid</span>.</p>';
$string['change_binding_username_claim_tool_result'] = 'Výsledky aktualizace';
$string['update_username_results'] = 'Výsledky aktualizace uživatelských jmen';
$string['new_username'] = 'Nové uživatelské jméno';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
