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
 * Dutch language strings.
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
$string['settings_pageheading'] = 'Configuratie van {$a}';
$string['settings_page_other_settings'] = 'Overige opties';
$string['settings_page_application'] = 'IdP en authenticatie';
$string['settings_page_application_wizard'] = 'Wizard voor toepassingsconfiguratie';
$string['settings_page_binding_username_claim'] = 'Claim voor koppeling van gebruikersnaam';
$string['settings_page_change_binding_username_claim_tool'] = 'Hulpmiddel voor wijzigen van claim voor koppeling van gebruikersnaam';
$string['settings_page_cleanup_oidc_tokens'] = 'OpenID Connect-tokens opschonen';
$string['settings_page_clear_user_tokens'] = 'Gebruikerstokens wissen';
$string['settings_page_field_mapping'] = 'Veldkoppelingen';
$string['heading_additional_options'] = 'Aanvullende opties';
$string['heading_additional_options_desc'] = '';
$string['heading_stateredirect'] = 'Foutpagina voor aanmeldstatus';
$string['heading_stateredirect_desc'] = 'Als een gebruiker er standaard te lang over doet om de aanmelding bij de identiteitsprovider te voltooien (bijvoorbeeld tijdens het goedkeuren van een multifactorauthenticatieverzoek) en de opgeslagen aanmeldstatus inmiddels is opgeschoond, toont Moodle zijn algemene foutpagina. Met de onderstaande instellingen kun je de bewaartermijn van de aanmeldstatus verlengen en in plaats van de algemene foutpagina een vriendelijker, aanpasbaar bericht tonen, waarbij de gebruiker automatisch wordt teruggestuurd naar de aanmeldpagina.';
$string['heading_user_restrictions'] = 'Gebruikersbeperkingen';
$string['heading_user_restrictions_desc'] = '';
$string['heading_sign_out'] = 'Integratie voor afmelden';
$string['heading_sign_out_desc'] = '';
$string['heading_display'] = 'Weergave';
$string['heading_display_desc'] = '';
$string['heading_debugging'] = 'Foutopsporing';
$string['heading_debugging_desc'] = '';
$string['heading_tools'] = 'Hulpmiddelen';
$string['microsoftcloud'] = 'Microsoft-cloud';
$string['microsoftcloud_help'] = 'Selecteer de Microsoft-cloud waartoe je Microsoft Entra-tenant behoort. Dit geldt voor de IdP-typen Microsoft Entra ID en Microsoft identity platform.<br/>
Selecteer "Microsoft 365 operated by 21Vianet (China)" als je organisatie Microsoft 365 gebruikt dat door 21Vianet wordt geleverd. De aanmeldservice en Microsoft Graph-endpoints van die cloud worden dan gebruikt voor de verzoeken van de plugins, en de standaardwaarden van de onderstaande endpoints en resource volgen die keuze. De reeds opgeslagen waarden voor de endpoints, de resource en het afmeldendpoint worden niet gewijzigd. Werk ze dus bij als ze nog op de endpoints van de globale cloud staan.';
$string['microsoftcloud_global'] = 'Microsoft 365 (globaal)';
$string['microsoftcloud_china'] = 'Microsoft 365 operated by 21Vianet (China)';
$string['idptype'] = 'Type identiteitsprovider (IdP)';
$string['idptype_help'] = 'Er worden momenteel drie typen IdP ondersteund:
<ul>
<li><b>Microsoft Entra ID (v1.0)</b>: Microsoft Entra ID met oauth2 v1.0-endpoints, bijvoorbeeld https://login.microsoftonline.com/organizations/oauth2/authorize.</li>
<li><b>Microsoft identity platform (v2.0)</b>: Microsoft Entra ID met oauth2 v2.0-endpoints, bijvoorbeeld https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize.</li>
<li><b>Overig</b>: elke IdP die niet van Microsoft is.</li>
</ul>
De verschillen tussen de opties <b>Microsoft Entra ID (v1.0)</b> en <b>Microsoft identity platform (v2.0)</b> vind je op <a href="https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison">https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison</a>.<br/>
De geconfigureerde toepassing kan bij de IdP <b>Microsoft identity platform (v2.0)</b> naast een <b>geheim</b> ook een <b>certificaat</b> gebruiken voor authenticatie.<br/>
De autorisatie- en tokenendpoints moeten worden geconfigureerd volgens het geconfigureerde IdP-type.';
$string['idp_type_microsoft_entra_id'] = 'Microsoft Entra ID (v1.0)';
$string['idp_type_microsoft_identity_platform'] = 'Microsoft identity platform (v2.0)';
$string['idp_type_other'] = 'Overig';
$string['settings_application_wizard_desc'] = 'Om deze instellingen te configureren met een begeleid formulier met stapsgewijze instructies en invoervalidatie, gebruik je de <a href="{$a}">wizard voor toepassingsconfiguratie</a>.';
$string['authendpoint'] = 'Autorisatie-endpoint';
$string['authendpoint_help'] = 'De URI van het autorisatie-endpoint van je IdP dat gebruikt moet worden.<br/>
Let op: als de site is geconfigureerd om gebruikers van andere tenants toegang te geven, kan geen tenantspecifiek autorisatie-endpoint worden gebruikt.';
$string['clientid'] = 'Toepassings-ID';
$string['clientid_help'] = 'De geregistreerde toepassings-/client-ID bij de IdP.';
$string['clientauthmethod'] = 'Clientauthenticatiemethode';
$string['clientauthmethod_help'] = '<ul>
<li>IdP\'s van alle typen kunnen de authenticatiemethode "<b>Geheim</b>" gebruiken.</li>
<li>Een IdP van het type <b>Microsoft identity platform (v2.0)</b> kan daarnaast de authenticatiemethode <b>Certificaat</b> gebruiken.</li>
</ul>';
$string['auth_method_secret'] = 'Geheim';
$string['auth_method_certificate'] = 'Certificaat';
$string['clientsecret'] = 'Clientgeheim';
$string['clientsecret_help'] = 'Bij de authenticatiemethode <b>geheim</b> is dit het clientgeheim bij de IdP. Bij sommige providers wordt dit ook een sleutel genoemd.';
$string['clientprivatekey'] = 'Privésleutel van clientcertificaat';
$string['clientprivatekey_help'] = 'Bij de authenticatiemethode <b>certificaat</b> en de certificaatbron <b>Platte tekst</b> is dit de privésleutel van het certificaat dat wordt gebruikt voor authenticatie bij de IdP.';
$string['clientcert'] = 'Openbare sleutel van clientcertificaat';
$string['clientcert_help'] = 'Bij de authenticatiemethode <b>certificaat</b> en de certificaatbron <b>Platte tekst</b> is dit de openbare sleutel, of het certificaat, dat wordt gebruikt voor authenticatie bij de IdP.';
$string['clientcertsource'] = 'Certificaatbron';
$string['clientcertsource_help'] = 'Bij de authenticatiemethode <b>certificaat</b> bepaal je hiermee waar het certificaat vandaan wordt gehaald.
<ul>
<li>De bron <b>Platte tekst</b> vereist dat de inhoud van het certificaat en de privésleutel wordt ingevuld in de volgende tekstvakinstellingen.</li>
<li>De bron <b>Bestandsnaam</b> vereist dat de bestanden van het certificaat en de privésleutel aanwezig zijn in een map <b>microsoft_certs</b> in de Moodle-datamap.</li>
</ul>';
$string['cert_source_text'] = 'Platte tekst';
$string['cert_source_path'] = 'Bestandsnaam';
$string['clientprivatekeyfile'] = 'Bestandsnaam van privésleutel van clientcertificaat';
$string['clientprivatekeyfile_help'] = 'Bij de authenticatiemethode <b>certificaat</b> en de certificaatbron <b>Bestandsnaam</b> is dit de bestandsnaam van de privésleutel die wordt gebruikt voor authenticatie bij de IdP. Het bestand moet aanwezig zijn in een map <b>microsoft_certs</b> in de Moodle-datamap.';
$string['clientcertfile'] = 'Bestandsnaam van openbare sleutel van clientcertificaat';
$string['clientcertfile_help'] = 'Bij de authenticatiemethode <b>certificaat</b> en de certificaatbron <b>Bestandsnaam</b> is dit de bestandsnaam van de openbare sleutel, of het certificaat, dat wordt gebruikt voor authenticatie bij de IdP. Het bestand moet aanwezig zijn in een map <b>microsoft_certs</b> in de Moodle-datamap.';
$string['clientcertpassphrase'] = 'Wachtwoordzin van clientcertificaat';
$string['clientcertpassphrase_help'] = 'Als de privésleutel van het clientcertificaat is versleuteld, is dit de wachtwoordzin om deze te ontsleutelen.';
$string['change_client_secret'] = 'Clientgeheim wijzigen';
$string['change_client_secret_desc'] = 'Vink dit vakje aan om het clientgeheim bij te werken. Om veiligheidsredenen worden bestaande geheimen gemaskeerd en worden alleen de eerste 2 tekens getoond.';
$string['change_cert_passphrase'] = 'Wachtwoordzin van certificaat wijzigen';
$string['change_cert_passphrase_desc'] = 'Vink dit vakje aan om de wachtwoordzin van het certificaat bij te werken. Om veiligheidsredenen worden bestaande wachtwoordzinnen gemaskeerd en worden alleen de eerste 2 tekens getoond.';
$string['cfg_usepkce_key'] = 'PKCE gebruiken';
$string['cfg_usepkce_desc'] = 'Bij de aanmeldprocedure <b>Authorization Code</b> wordt een PKCE-"code_challenge" (RFC 7636) met de S256-methode meegestuurd in het autorisatieverzoek, en de bijbehorende "code_verifier" bij het inwisselen van de autorisatiecode. Microsoft Entra ID ondersteunt dit. Schakel dit bij andere providers alleen in als je provider PKCE ondersteunt, omdat sommige providers autorisatieverzoeken met onbekende parameters weigeren.';
$string['cfg_domainhint_key'] = 'Domeinhint';
$string['cfg_domainhint_desc'] = 'Bij de aanmeldprocedure <b>Authorization Code</b> wordt deze waarde meegegeven als de parameter "domain_hint". "domain_hint" wordt door sommige OpenID Connect-IdP\'s gebruikt om het aanmeldproces voor gebruikers te vergemakkelijken. Vraag je provider of deze parameter wordt ondersteund.';
$string['cfg_forceselectaccount_key'] = 'Accountselectie altijd tonen';
$string['cfg_forceselectaccount_desc'] = 'Indien ingeschakeld wordt gebruikers altijd gevraagd met welk account ze zich willen aanmelden, in plaats van automatisch aangemeld te worden met het account dat actief is in hun browser. Handig als gebruikers meerdere accounts hebben, bijvoorbeeld een leerlingen- en een beheerdersaccount.<br/>
De stille aanmeldmodus heeft voorrang: zolang deze is ingeschakeld, wordt de accountselectie niet afgedwongen bij stil aanmelden.';
$string['cfg_forceredirect_key'] = 'Doorverwijzing afdwingen';
$string['cfg_forceredirect_desc'] = 'Indien ingeschakeld wordt de aanmeldindexpagina overgeslagen en word je doorverwezen naar de OpenID Connect-pagina. Kan worden omzeild met de URL-parameter ?noredirect=1';
$string['cfg_stateexpiry_key'] = 'Verlooptijd aanmeldstatus (minuten)';
$string['cfg_stateexpiry_desc'] = 'Hoe lang een record van de aanmeldstatus wordt bewaard voordat de geplande opschoontaak het verwijdert. Verhoog dit als gebruikers regelmatig langer nodig hebben om de aanmelding bij de identiteitsprovider te voltooien (bijvoorbeeld door multifactorauthenticatieverzoeken).';
$string['error_stateexpiry_min'] = 'De verlooptijd van de aanmeldstatus moet minimaal 1 minuut zijn. Een waarde van nul of lager zou ertoe leiden dat aanmeldingen die momenteel bezig zijn mislukken.';
$string['cfg_stateredirect_enabled_key'] = 'Vriendelijke foutpagina tonen';
$string['cfg_stateredirect_enabled_desc'] = 'Indien ingeschakeld krijgt een gebruiker die er te lang over doet om de aanmelding bij de identiteitsprovider te voltooien (waardoor de opgeslagen aanmeldstatus inmiddels is opgeschoond) het onderstaande aanpasbare bericht te zien en wordt automatisch teruggestuurd naar de aanmeldpagina, in plaats van de algemene foutpagina van Moodle.';
$string['cfg_stateredirect_message_key'] = 'Bericht';
$string['cfg_stateredirect_message_desc'] = 'Het bericht dat aan de gebruiker wordt getoond op de vriendelijke foutpagina.';
$string['cfg_stateredirect_message_default'] = 'Er is een probleem opgetreden bij het aanmelden. Dit komt waarschijnlijk doordat het aanmelden te lang duurde (bijvoorbeeld tijdens het goedkeuren van een multifactorauthenticatieverzoek). Je wordt automatisch doorgestuurd naar de aanmeldpagina, zodat je het opnieuw kunt proberen.';
$string['cfg_stateredirect_delay_key'] = 'Vertraging voor doorverwijzing (seconden)';
$string['cfg_stateredirect_delay_desc'] = 'Het aantal seconden dat het bovenstaande bericht wordt getoond voordat de gebruiker automatisch wordt teruggestuurd naar de aanmeldpagina.';
$string['cfg_set_pix_key'] = 'Pictogram tonen op aanmeldpagina';
$string['cfg_set_pix_desc'] = 'Indien ingeschakeld wordt een pictogram getoond naast de naam van de provider op de aanmeldpagina.';
$string['cfg_icon_key'] = 'Pictogram';
$string['cfg_icon_desc'] = 'Een pictogram dat naast de naam van de provider op de aanmeldingspagina wordt weergegeven.';
$string['cfg_iconalt_o365'] = 'Office 365-pictogram';
$string['cfg_iconalt_microsoft365'] = 'Microsoft 365-logo';
$string['cfg_iconalt_openid'] = 'OpenID-pictogram';
$string['cfg_iconalt_keycloak'] = 'Keycloak-pictogram';
$string['cfg_customicon_key'] = 'Aangepast pictogram';
$string['cfg_customicon_desc'] = 'Als je een eigen pictogram wilt gebruiken, kun je dat hier uploaden. Je overschrijft daarmee een hierboven gekozen pictogram. <br /><br /><b>Opmerkingen bij het gebruik van aangepaste pictogrammen:</b><ul><li>Het formaat van het geüploade bestand wordt niet aangepast. Het wordt op de aanmeldingspagina weergegeven op een vaste grootte van 24x24 pixels, waarbij je browser het schaalt, dus we raden aan een vierkante afbeelding te uploaden om vervorming te voorkomen.</li><li>Als je een aangepast pictogram hebt geüpload en toch liever een van de standaardpictogrammen wilt gebruiken, klik dan in het vak hierboven op het aangepaste pictogram, klik op Verwijderen en op OK. Klik daarna onder in dit formulier op Wijzigingen opslaan. Het geselecteerde standaardpictogram wordt dan op de aanmeldingspagina van Moodle weergegeven.</li></ul>';
$string['cfg_debugmode_key'] = 'Foutopsporingsberichten registreren';
$string['cfg_debugmode_desc'] = 'Als deze optie is ingeschakeld, worden gegevens in het Moodle-logboek geregistreerd die kunnen helpen bij het identificeren van problemen.';
$string['cfg_silentloginmode_key'] = 'Stille aanmeldmodus';
$string['cfg_silentloginmode_desc'] = 'Indien ingeschakeld probeert Moodle de actieve sessie van een gebruiker die is geauthenticeerd bij het geconfigureerde autorisatie-endpoint te gebruiken om de gebruiker aan te melden.<br/>
Om deze functie te gebruiken zijn de volgende configuraties vereist:
<ul>
<li><b>Verplicht aanmelden</b> (forcelogin) in de <a href="{$a}" target="_blank">sectie Site beveiligingsinstellingen</a> is ingeschakeld.</li>
<li>De bovenstaande instelling <b>Doorverwijzing afdwingen</b> (auth_oidc/forceredirect) is ingeschakeld.</li>
</ul>
Om te voorkomen dat Moodle probeert persoonlijke accounts of accounts van andere tenants te gebruiken om aan te melden, wordt ook aanbevolen om tenantspecifieke endpoints te gebruiken in plaats van generieke endpoints met paden als "common" of "organizations".<br/>
<br/>
Voor Microsoft-IdP\'s ziet de gebruikerservaring er als volgt uit:
<ul>
<li>Als er geen actieve gebruikerssessie wordt gevonden, wordt de aanmeldpagina van Moodle getoond.</li>
<li>Als er slechts één actieve gebruikerssessie wordt gevonden en de gebruiker toegang heeft tot de Entra ID-app (dat wil zeggen dat de gebruiker van dezelfde tenant is of een gastgebruiker van de tenant), wordt de gebruiker automatisch met SSO aangemeld bij Moodle.</li>
<li>Als er slechts één actieve gebruikerssessie wordt gevonden, maar de gebruiker geen toegang heeft tot de Entra ID-app (bijvoorbeeld omdat de gebruiker van een andere tenant is, of de app gebruikerstoewijzing vereist en de gebruiker niet is toegewezen), wordt de aanmeldpagina van Moodle getoond.</li>
<li>Als er meerdere actieve gebruikerssessies zijn die toegang hebben tot de Entra ID-app, wordt een pagina getoond waarop de gebruiker het account kan kiezen waarmee wordt aangemeld.</li>
</ul>';
$string['oidcresource'] = 'Resource';
$string['oidcresource_help'] = 'De OpenID Connect-resource waarvoor het verzoek wordt verzonden.<br/>
<b>Let op:</b> deze parameter wordt niet ondersteund bij het IdP-type <b>Microsoft identity platform (v2.0)</b>.';
$string['oidcscope'] = 'Scope';
$string['oidcscope_help'] = 'De te gebruiken OIDC-scope.';
$string['customclaims'] = 'Aangepaste claims';
$string['customclaims_help'] = 'Door spaties gescheiden lijst met namen van aangepaste claims uit de tokens van je identiteitsprovider.<br/>
<b>Belangrijk:</b>
<ul>
<li>Claims moeten bestaan in de tokenconfiguratie van je IdP (bijvoorbeeld Keycloak-protocolmappers, optionele/aangepaste claims van Microsoft Entra ID)</li>
<li>Als een claim niet in het token voorkomt, wordt deze bij de veldkoppeling stilzwijgend overgeslagen: er wordt geen fout getoond</li>
<li>Claimnamen zijn hoofdlettergevoelig en mogen alleen alfanumerieke tekens, koppeltekens en underscores bevatten</li>
<li>Een claimnaam mag geen gereserveerde naam zijn, zoals een standaard JWT-/OpenID Connect-claim (bijvoorbeeld <code>sub</code>, <code>email</code>), een claim die specifiek is voor Microsoft Entra ID (bijvoorbeeld <code>oid</code>, <code>upn</code>) of Keycloak (bijvoorbeeld <code>realm_access</code>, <code>resource_access</code>), of een bestaande optie voor veldkoppeling</li>
<li>De claim <code>roles</code> (app-rollen in Microsoft Entra ID-tokens) en de claim <code>groups</code> (groeps-ID\'s) zijn toegestaan. Ze worden bij de veldkoppeling vermeld als "roles (token claim)" en "groups (token claim)", los van de ingebouwde opties "Rollen" en "Groepen", die Microsoft Entra-maprollen en groepsnamen uit Microsoft Graph koppelen. Claims met een lijst van waarden worden opgeslagen als een door komma\'s gescheiden lijst</li>
<li>Voorbeelden: <code>employee_type badge_number costCenter custom_role</code></li>
<li>Bij het aanmelden worden aangepaste claims altijd uit het token gelezen, ongeacht of ook Microsoft Graph wordt gebruikt. Tijdens de geplande taak voor gebruikerssynchronisatie is er geen gebruikerstoken om uit te lezen, dus een aangepaste claim wordt alleen gesynchroniseerd als de naam ervan toevallig ook een selecteerbare Microsoft Graph-gebruikerseigenschap is, zoals een directory-extensieattribuut (bijvoorbeeld <code>extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode</code>). Een aangepaste claim die door Microsoft Graph wordt geweigerd, wordt voor die synchronisatie overgeslagen, met een waarschuwing in het taaklogboek, in plaats van dat de hele synchronisatie mislukt.</li>
</ul>';
$string['secretexpiryrecipients'] = 'Ontvangers van meldingen over verlopen geheim';
$string['secretexpiryrecipients_help'] = 'Een door komma\'s gescheiden lijst met e-mailadressen waarnaar meldingen over het verlopen van het geheim worden verzonden.<br/>
Als er geen e-mailadres is ingevuld, wordt de hoofdbeheerder van de site op de hoogte gebracht.<br/>
Standaard worden meldingen dagelijks verzonden, vanaf vier weken voor het verlopen totdat het geheim is vernieuwd.';
$string['cfg_showbutton_key'] = 'Aanmeldknop tonen';
$string['cfg_showbutton_desc'] = 'Indien uitgeschakeld wordt de aanmeldknop van de provider niet getoond op de aanmeldpagina. Gebruikers kunnen zich nog steeds via deze provider authenticeren door rechtstreeks naar de aanmeld-URL te gaan.';
$string['cfg_opname_key'] = 'Naam provider';
$string['cfg_opname_desc'] = 'Dit is een voor de gebruiker zichtbaar label dat aangeeft met welke type referenties de gebruiker zich moet aanmelden. Dit label wordt in alle voor de gebruiker zichtbare delen van deze plugin gebruikt om de provider aan te geven.';
$string['cfg_redirecturi_key'] = 'Omleidings-URI';
$string['cfg_redirecturi_desc'] = 'Dit is de URI die als "Omleidings-URI" moet worden geregistreerd. Je OpenID Connect-IdP vraagt hier naar wanneer je Moodle als client registreert. <br /><b>LET OP:</b> je moet dit *exact* zo invullen in je OpenID Connect-IdP als het hier wordt weergegeven. Elk verschil maakt aanmelden met OpenID Connect onmogelijk.';
$string['tokenendpoint'] = 'Token-endpoint';
$string['tokenendpoint_help'] = 'De URI van het token-endpoint van je IdP dat gebruikt moet worden.<br/>
Let op: als de site is geconfigureerd om gebruikers van andere tenants toegang te geven, kan geen tenantspecifiek token-endpoint worden gebruikt.';
$string['cfg_userrestrictions_key'] = 'Gebruikersbeperkingen';
$string['cfg_userrestrictions_desc'] = 'Laat alleen gebruikers aanmelden die aan bepaalde beperkingen voldoen. <br /><b>Gebruikersbeperkingen gebruiken: </b> <ul><li>Voer een patroon met een <a href="https://en.wikipedia.org/wiki/Regular_expression">reguliere expressie</a> in dat overeenkomt met de gebruikersnamen van gebruikers die je wilt toestaan.</li><li>Voer één patroon per regel in</li><li>Als je meerdere patronen invoert, wordt een gebruiker toegestaan als deze aan EEN VAN de patronen voldoet.</li><li>Het teken "/" moet worden ge-escaped met "\\".</li><li>Als je hierboven geen beperkingen invoert, worden alle gebruikers die zich kunnen aanmelden bij de OpenID Connect-IdP door Moodle geaccepteerd.</li><li>Elke gebruiker die niet aan de ingevoerde patro(o)n(en) voldoet, kan zich niet aanmelden met OpenID Connect.</li></ul>';
$string['cfg_userrestrictionscasesensitive_key'] = 'Gebruikersbeperkingen hoofdlettergevoelig';
$string['cfg_userrestrictionscasesensitive_desc'] = 'Dit bepaalt of de optie "/i" van de reguliere expressie wordt gebruikt bij het controleren van de gebruikersbeperkingen.<br/>Indien ingeschakeld zijn alle controles van gebruikersbeperkingen hoofdlettergevoelig. Let op: als dit is uitgeschakeld, worden patronen op basis van hoofd- en kleine letters genegeerd.';
$string['heading_dummy_email'] = 'Tijdelijke e-mailadressen';
$string['heading_dummy_email_desc'] = 'Moodle vereist dat elk gebruikersaccount een e-mailadres heeft, maar Microsoft Entra ID-accounts hoeven er geen te hebben. Met de onderstaande instellingen kan Moodle voor gebruikers zonder bruikbaar e-mailadres van de IdP een niet-bezorgbaar tijdelijk adres genereren, in plaats van hun e-mailadres leeg te laten.';
$string['cfg_generatedummyemail_key'] = 'Tijdelijke e-mailadressen genereren';
$string['cfg_generatedummyemail_desc'] = 'Indien ingeschakeld genereert Moodle, wanneer een gebruiker geen e-mailadres en geen bruikbare, als e-mailadres opgemaakte user principal name van de IdP heeft, een tijdelijk e-mailadres voor die gebruiker met hun Microsoft user principal name (of object-ID, als er geen user principal name beschikbaar is) en het hieronder geconfigureerde domein, in plaats van het e-mailadres leeg te laten. Dit geldt zowel wanneer een gebruiker zich aanmeldt als wanneer deze wordt aangemaakt door de taak voor gebruikerssynchronisatie.';
$string['cfg_dummyemaildomain_key'] = 'Domein voor tijdelijke e-mailadressen';
$string['cfg_dummyemaildomain_desc'] = 'Het domein dat wordt gebruikt bij het genereren van tijdelijke e-mailadressen, bijvoorbeeld "example.test". Gebruik een domein dat geen e-mail kan ontvangen, zodat gegenereerde adressen nooit voor een echt, bezorgbaar adres kunnen worden aangezien.';
$string['cfg_signoffintegration_key'] = 'Eenmalig afmelden (van Moodle naar IdP)';
$string['cfg_signoffintegration_desc'] = 'Als deze optie is ingeschakeld, activeert de integratie wanneer een Moodle-gebruiker die met de geconfigureerde IdP is verbonden zich afmeldt bij Moodle een verzoek bij het onderstaande afmeldendpoint, in een poging de gebruiker ook van de IdP af te melden.<br/>
Let op: voor integratie met Microsoft Entra ID moet de URL van de Moodle-site ({$a}) worden toegevoegd als omleidings-URI in de Microsoft Entra ID-app die is aangemaakt voor de integratie van Moodle en Microsoft 365.';
$string['cfg_logoutendpoint_key'] = 'Afmeldendpoint van IdP';
$string['cfg_logoutendpoint_desc'] = 'De URI van het afmeldendpoint van je IdP dat gebruikt moet worden.';
$string['cfg_frontchannellogouturl_key'] = 'Front-channel-afmeld-URL';
$string['cfg_frontchannellogouturl_desc'] = 'Dit is de URL die je IdP moet activeren wanneer deze probeert gebruikers af te melden bij Moodle.<br/>
Voor Microsoft Entra ID / Microsoft identity platform heet de instelling "Front-channel logout URL" en deze kan worden geconfigureerd in de Microsoft Entra ID-app.';
$string['cfg_field_mapping_desc'] = 'Gebruikersprofielgegevens kunnen van de OpenID Connect-IdP naar Moodle worden gekoppeld. De beschikbare externe velden hangen sterk af van het IdP-type.<br/>
<ul>
<li>Enkele basisprofielvelden zijn bij alle IdP-typen beschikbaar via claims van het toegangstoken en het ID-token.</li>
<li>Als een Microsoft-IdP-type is geconfigureerd (v1.0 of v2.0), kunnen aanvullende profielgegevens beschikbaar worden gemaakt via Graph API-aanroepen door de <a href="https://moodle.org/plugins/local_o365">Microsoft 365-integratieplugin (local_o365)</a> te installeren en te configureren.</li>
<li>Als de functie voor SDS-profielsynchronisatie is ingeschakeld in de plugin local_o365, kunnen bepaalde profielvelden van SDS naar Moodle worden gesynchroniseerd. Dit gebeurt alleen bij het uitvoeren van de geplande taak "Synchroniseren met SDS" en niet bij het uitvoeren van de geplande taak "Gebruikers synchroniseren met Microsoft Entra ID", noch wanneer een gebruiker zich aanmeldt.</li>
</ul>

De beschikbare claims in de ID- en toegangstokens verschillen per IdP-type, maar de meeste IdP\'s staan enige aanpassing van de claims toe. Documentatie over Microsoft-IdP\'s is hieronder gelinkt:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Claims van toegangstokens</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">Claims van ID-tokens</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Configuratie van optionele claims</a>: let op: "Email" is een optionele claim bij het IdP-type Microsoft Entra ID (v1.0).</li>
</ul>';

$string['cfg_cleanupoidctokens_key'] = 'OpenID Connect-tokens opschonen';
$string['cfg_cleanupoidctokens_desc'] = 'Als je gebruikers problemen ondervinden bij het aanmelden met hun Microsoft 365-account, probeer dan de OpenID Connect-tokens op te schonen. Hiermee worden losse en onvolledige tokens verwijderd die fouten kunnen veroorzaken. WAARSCHUWING: dit kan aanmeldingen die bezig zijn onderbreken, dus doe dit bij voorkeur tijdens een onderhoudsperiode.';
$string['settings_section_basic'] = 'Basisinstellingen';
$string['settings_section_authentication'] = 'Authenticatie';
$string['settings_section_endpoints'] = 'Endpoints';
$string['settings_section_other_params'] = 'Overige parameters';
$string['settings_section_secret_expiry_notification'] = 'Melding over verlopen geheim';
$string['application_updated'] = 'De toepassingsinstellingen van OpenID Connect zijn bijgewerkt.';
$string['application_updated_microsoft'] = 'De toepassingsinstelling van OpenID Connect is bijgewerkt.<br/>
<span class="warning" style="color: red;">Een Microsoft Entra ID-beheerder moet opnieuw <b>Beheerderstoestemming geven</b> en <b>Controleer de configuratie</b> op de configuratiepagina van de Microsoft 365-integratie als de instellingen "Type identiteitsprovider (IdP)" of "Clientauthenticatiemethode" worden gewijzigd.</span>';
$string['application_updated_microsoft_notify'] = 'De toepassingsinstelling van OpenID Connect is bijgewerkt.<br/>
<span class="warning" style="color: red;">Een Microsoft Entra ID-beheerder moet opnieuw <b>Beheerderstoestemming geven</b> en <b>Controleer de configuratie</b> op de <a href="{$a}">configuratiepagina van de Microsoft 365-integratie</a> als de instellingen "Type identiteitsprovider (IdP)" of "Clientauthenticatiemethode" worden gewijzigd.</span>';
$string['application_not_changed'] = 'De toepassingsinstelling van OpenID Connect is niet gewijzigd.';

$string['event_debug'] = 'Foutopsporingsmelding';

$string['task_cleanup_oidc_state_and_token'] = 'OIDC-status en ongeldige tokens opschonen';
$string['task_cleanup_oidc_sid'] = 'OIDC-SID-records opschonen';

$string['errorauthdisconnectemptypassword'] = 'Wachtwoord kan niet leeg zijn';
$string['errorauthdisconnectemptyusername'] = 'Gebruikersnaam kan niet leeg zijn';
$string['errorauthdisconnectusernameexists'] = 'Deze gebruikersnaam wordt al gebruikt. Kies een andere.';
$string['errorauthdisconnectnewmethod'] = 'Aanmeldingsmethode gebruiken';
$string['errorauthdisconnectinvalidmethod'] = 'Ongeldige aanmeldingsmethode ontvangen.';
$string['errorauthdisconnectifmanual'] = 'Voer hieronder je referenties in als je de handmatige aanmeldingsmethode gebruikt.';
$string['errorauthgeneral'] = 'Er is een probleem opgetreden bij het aanmelden. Neem contact op met je beheerder voor hulp.';
$string['errorauthinvalididtoken'] = 'Ongeldige id_token ontvangen.';
$string['errorauthloginfailednouser'] = 'Ongeldige aanmelding: je hebt je aangemeld als "{$a}", maar er is geen overeenkomend account op deze site en nieuwe accounts kunnen niet automatisch worden aangemaakt. Neem contact op met de sitebeheerder voor hulp. Als je meer dan één account hebt, selecteer dan "Ga door" om je met een ander account aan te melden.';
$string['errorauthloginfaileddupemail'] = 'Ongeldige aanmelding: een bestaand account in deze Moodle heeft hetzelfde e-mailadres als het account dat je probeert aan te maken, en de instelling "Accounts met hetzelfde e-mailadres toestaan" (allowaccountssameemail) is uitgeschakeld.';
$string['errorauthmfarequired'] = 'Microsoft vereist multifactorauthenticatie om je aanmelding te voltooien, maar dit kon niet worden voltooid. Probeer het opnieuw, of meld je aan bij Microsoft 365 in een nieuwe browsersessie en voltooi het multifactorauthenticatieverzoek.';
$string['errorauthnoauthcode'] = 'Er is geen autorisatiecode ontvangen van de identiteitsserver. De foutenlogboeken bevatten mogelijk meer informatie.';
$string['errorauthnocredsandendpoints'] = 'Configureer de clientreferenties en endpoints van OpenID Connect.';
$string['errorauthnoidtoken'] = 'OpenID Connect id_token niet ontvangen.';
$string['errorauthnoaccesstoken'] = 'Toegangstoken niet ontvangen.';
$string['errorauthunknownstate'] = 'Onbekende toestand.';
$string['errorauthuseralreadyconnected'] = 'Je bent al verbonden met een andere OpenID Connect-gebruiker.';
$string['errorauthuserconnectedtodifferent'] = 'De geauthenticeerde OpenID Connect-gebruiker is al verbonden met een Moodle-gebruiker.';
$string['errorbadloginflow'] = 'Ongeldige aanmeldingsflow opgegeven. Opmerking: maak je Moodle-cache leeg als je dit bericht ontvangt na een recente installatie of upgrade.';
$string['errorjwtbadpayload'] = 'Kan JWT-payload niet lezen.';
$string['errorjwtcouldnotreadheader'] = 'Kan JWT-header niet lezen';
$string['errorjwtempty'] = 'JWT leeg of geen tekenreeks.';
$string['errorjwtinvalidheader'] = 'Ongeldige JWT-header';
$string['errorjwtmalformed'] = 'JWT met verkeerde indeling ontvangen.';
$string['errorjwtunsupportedalg'] = 'JWS-algoritme of JWE niet ondersteund';
$string['erroroidcnotenabled'] = 'De authenticatie-plugin van OpenID Connect is niet ingeschakeld.';
$string['errornodisconnectionauthmethod'] = 'Kan verbinding niet verbreken omdat er geen ingeschakelde authenticatie-plugin is om op terug te vallen (vorige aanmeldingsmethode van gebruiker of handmatige aanmeldingsmethode).';
$string['erroroidcclientinvalidendpoint'] = 'Ongeldige endpoint-URI ontvangen.';
$string['erroroidcclientnocreds'] = 'Stel clientreferenties in met setcreds';
$string['erroroidcclientnoauthendpoint'] = 'Geen autorisatie-endpoint ingesteld. Stel in met $this->setendpoints';
$string['erroroidcclientnotokenendpoint'] = 'Geen token-endpoint ingesteld. Stel in met $this->setendpoints';
$string['errorrestricted'] = 'Deze site heeft beperkingen voor de gebruikers die zich met OpenID Connect kunnen aanmelden. Deze beperkingen verhinderen momenteel dat je deze aanmeldpoging kunt voltooien.';
$string['errorucpinvalidaction'] = 'Ongeldige actie ontvangen.';
$string['erroroidccall'] = 'Fout in OpenID Connect. Controleer de logboeken voor meer informatie.';
$string['erroroidccall_message'] = 'Fout in OpenID Connect: {$a}';
$string['errorinvalidredirect_message'] = 'De URL waarnaar je probeert door te verwijzen bestaat niet.';
$string['errorinvalidcertificatesource'] = 'Ongeldige certificaatbron';
$string['error_invalid_client_authentication_method'] = 'Ongeldige clientauthenticatiemethode';
$string['error_empty_client_secret'] = 'Het clientgeheim mag niet leeg zijn bij de authenticatiemethode "geheim"';
$string['error_empty_client_private_key'] = 'De privésleutel van het clientcertificaat mag niet leeg zijn bij de authenticatiemethode "certificaat"';
$string['error_empty_client_cert'] = 'De openbare sleutel van het clientcertificaat mag niet leeg zijn bij de authenticatiemethode "certificaat"';
$string['error_empty_client_private_key_file'] = 'Het bestand met de privésleutel van het clientcertificaat mag niet leeg zijn bij de authenticatiemethode "certificaat"';
$string['error_empty_client_cert_file'] = 'Het bestand met de openbare sleutel van het clientcertificaat mag niet leeg zijn bij de authenticatiemethode "certificaat"';
$string['error_endpoint_mismatch_auth_endpoint'] = 'Het geconfigureerde autorisatie-endpoint komt niet overeen met het geconfigureerde IdP-type. Gebruik voor "Microsoft Entra ID (v1.0)" een v1.0-endpoint (bijvoorbeeld https://login.microsoftonline.com/organizations/oauth2/authorize). Gebruik voor "Microsoft identity platform (v2.0)" een v2.0-endpoint (bijvoorbeeld https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize).';
$string['error_endpoint_mismatch_token_endpoint'] = 'Het geconfigureerde token-endpoint komt niet overeen met het geconfigureerde IdP-type. Gebruik voor "Microsoft Entra ID (v1.0)" een v1.0-endpoint (bijvoorbeeld https://login.microsoftonline.com/organizations/oauth2/token). Gebruik voor "Microsoft identity platform (v2.0)" een v2.0-endpoint (bijvoorbeeld https://login.microsoftonline.com/organizations/oauth2/v2.0/token).';
$string['error_tenant_specific_endpoint_required'] = 'Bij het IdP-type "Microsoft identity platform (v2.0)" en de authenticatiemethode "Certificaat" is een tenantspecifiek endpoint vereist (dus niet common/organizations/consumers).';
$string['error_empty_oidcresource'] = 'De resource mag niet leeg zijn bij Microsoft Entra ID (v1.0) of andere typen IdP.';
$string['error_invalid_custom_claim'] = 'Ongeldige naam/namen van aangepaste claim: {$a}. Namen van aangepaste claims mogen alleen alfanumerieke tekens, koppeltekens en underscores bevatten en mogen geen gereserveerde claimnaam zijn (bijvoorbeeld een standaard JWT-/OpenID Connect-claim, of een claim die specifiek is voor Microsoft Entra ID of Keycloak) of een bestaande optie voor veldkoppeling.';
$string['error_masked_secret_not_changed'] = 'Voer een nieuwe waarde in of schakel het selectievakje "Wijzigen" uit om de huidige waarde te behouden.';
$string['error_secretexpiryrecipients_invalid'] = 'De volgende ontvangers van meldingen over verlopen geheim zijn geen geldige e-mailadressen: {$a}';
$string['auth_settings_validation_error'] = 'Ongeldige authenticatie-instellingen aangetroffen. De volgende configuratieproblemen moeten worden opgelost om succesvolle authenticatie te garanderen:';
$string['errorupnchangeisnotsupported'] = 'De UPN van je Microsoft-account is gewijzigd. Neem contact op met je beheerder om je Moodle-account bij te werken.';
$string['erroruserwithusernamealreadyexists'] = 'Er is een fout opgetreden bij het proberen je Moodle-account te hernoemen. Er bestaat al een Moodle-gebruiker met de nieuwe gebruikersnaam. Vraag je sitebeheerder dit eerst op te lossen.';
$string['error_no_response_available'] = 'Geen antwoorden beschikbaar.';

$string['eventuserauthed'] = 'Gebruiker geautoriseerd met OpenID Connect';
$string['eventusercreated'] = 'Gebruiker gemaakt met OpenID Connect';
$string['eventuserconnected'] = 'Gebruiker verbonden met OpenID Connect';
$string['eventuserloggedin'] = 'Gebruiker aangemeld met OpenID Connect';
$string['eventuserdisconnected'] = 'Verbinding tussen gebruiker en OpenID Connect verbroken';
$string['eventuserrenameattempt'] = 'De plugin auth_oidc probeerde een gebruiker te hernoemen';

$string['oidc:manageconnection'] = 'OpenID Connect-verbinding en -verbreking toestaan';
$string['oidc:manageconnectionconnect'] = 'OpenID Connect-verbinding toestaan';
$string['oidc:manageconnectiondisconnect'] = 'OpenID Connect-verbreking toestaan';

$string['privacy:metadata:auth_oidc'] = 'OpenID Connect-authenticatie';
$string['privacy:metadata:auth_oidc_prevlogin'] = 'Eerdere aanmeldingsmethoden om Microsoft 365-verbindingen ongedaan te maken';
$string['privacy:metadata:auth_oidc_prevlogin:userid'] = 'De ID van de Moodle-gebruiker';
$string['privacy:metadata:auth_oidc_prevlogin:method'] = 'De vorige aanmeldingsmethode';
$string['privacy:metadata:auth_oidc_prevlogin:password'] = 'Het vorige (versleutelde) wachtwoordveld van de gebruiker.';
$string['privacy:metadata:auth_oidc_token'] = 'OpenID Connect-tokens';
$string['privacy:metadata:auth_oidc_token:oidcuniqid'] = 'De unieke OIDC-gebruikersidentificatie.';
$string['privacy:metadata:auth_oidc_token:username'] = 'De gebruikersnaam van de Moodle-gebruiker';
$string['privacy:metadata:auth_oidc_token:userid'] = 'De gebruikers-ID van de Moodle-gebruiker';
$string['privacy:metadata:auth_oidc_token:oidcusername'] = 'De gebruikersnaam van de OIDC-gebruiker';
$string['privacy:metadata:auth_oidc_token:useridentifier'] = 'De gebruikersidentificatie van de OIDC-gebruiker';
$string['privacy:metadata:auth_oidc_token:scope'] = 'De scope van het token';
$string['privacy:metadata:auth_oidc_token:tokenresource'] = 'De resource van het token';
$string['privacy:metadata:auth_oidc_token:authcode'] = 'De autorisatiecode voor het token';
$string['privacy:metadata:auth_oidc_token:token'] = 'Het token';
$string['privacy:metadata:auth_oidc_token:expiry'] = 'De verlooptijd van het token';
$string['privacy:metadata:auth_oidc_token:refreshtoken'] = 'Het vernieuwingstoken';
$string['privacy:metadata:auth_oidc_token:idtoken'] = 'Het ID-token';
$string['privacy:metadata:auth_oidc_sid'] = 'IdP-sessie-identificaties (sid) die worden gebruikt om verbonden Moodle-gebruikers te vinden wanneer SLO vanuit de IdP wordt geactiveerd';
$string['privacy:metadata:auth_oidc_sid:userid'] = 'De ID van de Moodle-gebruiker';
$string['privacy:metadata:auth_oidc_sid:sid'] = 'De IdP-sessie-identificatie (sid)';
$string['privacy:metadata:auth_oidc_sid:timecreated'] = 'Het tijdstip waarop de koppeling is gemaakt';
$string['privacy:metadata:auth_oidc_sid:sessionid'] = 'De Moodle-sessie-ID die actief was op het moment dat de koppeling werd gemaakt';
$string['privacy:metadata:auth_oidc_sid:iss'] = 'De uitgever (iss-claim) van het id_token waaruit de koppeling is gemaakt';

// In the following strings, $a refers to a customizable name for the identity manager. For example, this could be
// "Microsoft 365", "OpenID Connect", etc.
$string['ucp_general_intro'] = 'Hier kun je de verbinding met {$a} beheren. Als deze optie is ingeschakeld, kun je je bij Moodle aanmelden met je {$a}-account in plaats van een aparte gebruikersnaam en wachtwoord. Als de verbinding is gemaakt, hoef je je gebruikersnaam en wachtwoord voor Moodle niet meer te onthouden. Alle aanmeldingen worden afgehandeld door {$a}.';
$string['ucp_login_start'] = '{$a} gebruiken om je aan te melden bij Moodle';
$string['ucp_login_start_desc'] = 'Hiermee stel je je account in voor het gebruik van {$a} om je aan te melden bij Moodle. Als deze optie is ingeschakeld, meld je je aan met je {$a}-referenties. Je huidige Moodle-gebruikersnaam en -wachtwoord werken niet meer. Je kunt op elk moment de verbinding met je account verbreken en terugkeren naar de normale aanmelding.';
$string['ucp_login_stop'] = '{$a} niet meer gebruiken om je aan te melden bij Moodle';
$string['ucp_login_stop_desc'] = 'Op dit moment gebruik je {$a} om je aan te melden bij Moodle. Als je op "{$a} niet meer gebruiken om je aan te melden bij Moodle" klikt, wordt de verbinding tussen je Moodle-account en {$a} verbroken. Je kunt je niet meer bij Moodle aanmelden met je {$a}-account. Je wordt gevraagd een gebruikersnaam en wachtwoord op te geven, en vanaf dat moment kun je je direct aanmelden bij Moodle.';
$string['ucp_login_status'] = '{$a}-aanmelding is:';
$string['ucp_status_enabled'] = 'Ingeschakeld';
$string['ucp_status_disabled'] = 'Uitgeschakeld';
$string['ucp_disconnect_title'] = 'Verbinding met {$a} verbroken';
$string['ucp_disconnect_details'] = 'Hiermee wordt de verbinding tussen je Moodle-account en {$a} verbroken. Je moet een gebruikersnaam en wachtwoord maken om je aan te melden bij Moodle.';
$string['ucp_title'] = '{$a}-beheer';
$string['ucp_o365accountconnected'] = 'Dit Microsoft 365-account is al verbonden met een ander Moodle-account.';

// Clean up OIDC tokens.
$string['cleanup_oidc_tokens'] = 'OpenID Connect-tokens opschonen';
$string['unmatched'] = 'Niet overeenkomend';
$string['delete_token'] = 'Token verwijderen';
$string['mismatched'] = 'Afwijkend';
$string['na'] = 'n.v.t.';
$string['mismatched_details'] = 'Het tokenrecord bevat de gebruikersnaam "{$a->tokenusername}"; de gekoppelde Moodle-gebruiker heeft de gebruikersnaam "{$a->moodleusername}".';
$string['delete_token_and_reference'] = 'Token en verwijzing verwijderen';
$string['table_token_id'] = 'ID van tokenrecord';
$string['table_oidc_username'] = 'OIDC-gebruikersnaam';
$string['table_oidc_unique_identifier'] = 'Unieke OIDC-identificatie';
$string['table_token_unique_id'] = 'Unieke OIDC-ID';
$string['table_matching_status'] = 'Koppelingsstatus';
$string['table_matching_details'] = 'Details';
$string['table_action'] = 'Actie';
$string['token_deleted'] = 'Het token is verwijderd';
$string['no_token_to_cleanup'] = 'Er zijn geen OIDC-tokens om op te schonen.';

$string['errorusermatched'] = 'Het Microsoft 365-account "{$a->entraidupn}" is al gekoppeld aan Moodle-gebruiker "{$a->username}". Meld je eerst aan als die Moodle-gebruiker en volg de instructies in het Microsoft-blok om de verbinding te voltooien.';

// User mapping options.
$string['update_oncreate_and_onlogin'] = 'Bij aanmaken en elke aanmelding';
$string['update_oncreate_and_onlogin_and_usersync'] = 'Bij aanmaken, elke aanmelding en elke uitvoering van de taak voor gebruikerssynchronisatie';
$string['update_oncreate_and_usersync'] = 'Bij aanmaken en elke uitvoering van de taak voor gebruikerssynchronisatie';
$string['update_onlogin_and_usersync'] = 'Bij elke aanmelding en elke uitvoering van de taak voor gebruikerssynchronisatie';
$string['upgradeoidcuniqidtoolong'] = 'De upgrade kan niet doorgaan: sommige auth_oidc_token-records hebben een oidcuniqid van meer dan 200 tekens, wat door de nieuwe kolomlengte zou worden afgekapt. Verwijder die tokenrecords en voer de upgrade opnieuw uit.';

// Remote fields.
$string['settings_fieldmap_feild_not_mapped'] = '(niet gekoppeld)';
$string['settings_fieldmap_field_bindingusernameclaim'] = 'Claim voor koppeling van gebruikersnaam (kan alleen tijdens het aanmelden worden gekoppeld)';
$string['settings_fieldmap_field_city'] = 'Plaats';
$string['settings_fieldmap_field_companyName'] = 'Bedrijfsnaam';
$string['settings_fieldmap_field_objectId'] = 'Object-ID';
$string['settings_fieldmap_field_country'] = 'Land';
$string['settings_fieldmap_field_department'] = 'Afdeling';
$string['settings_fieldmap_field_displayName'] = 'Weergavenaam';
$string['settings_fieldmap_field_surname'] = 'Achternaam';
$string['settings_fieldmap_field_faxNumber'] = 'Faxnummer';
$string['settings_fieldmap_field_telephoneNumber'] = 'Telefoonnummer';
$string['settings_fieldmap_field_givenName'] = 'Voornaam';
$string['settings_fieldmap_field_jobTitle'] = 'Functie';
$string['settings_fieldmap_field_mail'] = 'E-mail';
$string['settings_fieldmap_field_mobile'] = 'Mobiel';
$string['settings_fieldmap_field_postalCode'] = 'Postcode';
$string['settings_fieldmap_field_preferredLanguage'] = 'Taal';
$string['settings_fieldmap_field_state'] = 'Provincie';
$string['settings_fieldmap_field_streetAddress'] = 'Straatadres';
$string['settings_fieldmap_field_userPrincipalName'] = 'User principal name';
$string['settings_fieldmap_field_employeeId'] = 'Werknemers-ID';
$string['settings_fieldmap_field_employeeType'] = 'Werknemerstype';
$string['settings_fieldmap_field_accountEnabled'] = 'Account ingeschakeld';
$string['settings_fieldmap_field_businessPhones'] = 'Telefoon kantoor';
$string['settings_fieldmap_field_mobilePhone'] = 'Mobiele telefoon';
$string['settings_fieldmap_field_officeLocation'] = 'Kantoor';
$string['settings_fieldmap_field_preferredName'] = 'Voorkeursnaam';
$string['settings_fieldmap_field_manager'] = 'Naam leidinggevende';
$string['settings_fieldmap_field_manager_email'] = 'E-mailadres leidinggevende';
$string['settings_fieldmap_field_teams'] = 'Teams';
$string['settings_fieldmap_field_groups'] = 'Groepen';
$string['settings_fieldmap_field_roles'] = 'Rollen';
$string['settings_fieldmap_field_tokenclaim'] = '{$a} (tokenclaim)';
$string['settings_fieldmap_field_onPremisesSamAccountName'] = 'On-premises SAM-accountnaam';
$string['settings_fieldmap_field_extensionattribute'] = 'Extensieattribuut {$a}';
$string['settings_fieldmap_field_sds_school_id'] = 'SDS-school-ID ({$a})';
$string['settings_fieldmap_field_sds_school_name'] = 'SDS-schoolnaam ({$a})';
$string['settings_fieldmap_field_sds_school_role'] = 'SDS-schoolrol ("Student" of "Teacher")';
$string['settings_fieldmap_field_sds_student_externalId'] = 'Externe ID van SDS-leerling';
$string['settings_fieldmap_field_sds_student_birthDate'] = 'Geboortedatum van SDS-leerling';
$string['settings_fieldmap_field_sds_student_grade'] = 'Leerjaar van SDS-leerling';
$string['settings_fieldmap_field_sds_student_graduationYear'] = 'Afstudeerjaar van SDS-leerling';
$string['settings_fieldmap_field_sds_student_studentNumber'] = 'Leerlingnummer van SDS-leerling';
$string['settings_fieldmap_field_sds_teacher_externalId'] = 'Externe ID van SDS-leraar';
$string['settings_fieldmap_field_sds_teacher_teacherNumber'] = 'Leraarnummer van SDS-leraar';

// Binding username claim options.
$string['binding_username_claim_warning'] = 'Dit is een geavanceerde functie. In de meeste gevallen moet dit op "Automatisch kiezen" blijven staan; een onjuiste configuratie kan gebruikersrecords beïnvloeden en eenmalige aanmelding (SSO) verstoren.';
$string['binding_username_auto'] = 'Automatisch kiezen';
$string['binding_username_custom'] = 'Aangepast';
$string['bindingusernameclaim'] = 'Claim voor koppeling van gebruikersnaam';
$string['customclaimname'] = 'Naam van aangepaste claim';
$string['customclaimname_description'] = 'Dit veld wordt alleen gebruikt wanneer de instelling <b>claim voor koppeling van gebruikersnaam</b> op <b>Aangepast</b> staat.';
$string['binding_username_claim_tool_link_desc'] = 'Om de claim voor koppeling van gebruikersnaam voor bestaande gebruikers bij te werken, gebruik je het <a href="{$a}">hulpmiddel voor wijzigen van claim voor koppeling van gebruikersnaam</a>.';
$string['cleanup_oidc_tokens_link_desc'] = 'Om verouderde OpenID Connect-tokens op te schonen, gebruik je het hulpmiddel <a href="{$a}">OpenID Connect-tokens opschonen</a>.';
$string['clear_user_tokens_link_desc'] = 'Om de opgeslagen tokens van alle gebruikers, of van geselecteerde gebruikers, te verwijderen, gebruik je het hulpmiddel <a href="{$a}">Gebruikerstokens wissen</a>.';
$string['clear_user_tokens'] = 'Gebruikerstokens wissen';
$string['clear_user_tokens_desc'] = 'Verwijdert de OpenID Connect- en Microsoft 365-tokens die voor gebruikers zijn opgeslagen. Betrokken gebruikers krijgen nieuwe tokens de volgende keer dat ze zich aanmelden met OpenID Connect of verbinding maken met Microsoft 365. Hun koppelingen met Microsoft 365-accounts blijven behouden. WAARSCHUWING: dit kan aanmeldingen die bezig zijn onderbreken, dus doe dit bij voorkeur tijdens een onderhoudsperiode.';
$string['clear_user_tokens_scope_selected'] = 'Geselecteerde gebruikers';
$string['clear_user_tokens_scope_all'] = 'Alle gebruikers';
$string['clear_user_tokens_users'] = 'Gebruikers';
$string['clear_user_tokens_submit'] = 'Tokens wissen';
$string['clear_user_tokens_no_name'] = '(geen naam)';
$string['clear_user_tokens_no_user_selected'] = 'Selecteer ten minste één gebruiker.';
$string['clear_user_tokens_confirm_all'] = 'Weet je zeker dat je de tokens van alle gebruikers wilt wissen? {$a} gebruiker(s) hebben momenteel tokens.';
$string['clear_user_tokens_confirm_selected'] = 'Weet je zeker dat je de tokens van de geselecteerde gebruikers wilt wissen? {$a} van de geselecteerde gebruiker(s) hebben momenteel tokens.';
$string['clear_user_tokens_success'] = '{$a} tokenrecord(s) gewist.';
$string['binding_username_claim_help_ms_no_user_sync'] = 'De opties voor een Microsoft-IdP zonder ingeschakelde functie voor gebruikerssynchronisatie zijn onder meer:
<ul>
<li><b>Automatisch kiezen</b>: gebruikt de huidige logica, waarbij het token wordt bepaald op basis van het IdP-type en wordt teruggevallen op <b>sub</b> als er geen claim wordt gevonden.</li>
<li><b>preferred_username</b>: standaard voor het IdP-type Microsoft identity platform (v2.0). <span class="not_support_user_sync">Ondersteunt geen gebruikerssynchronisatie.</span></li>
<li><b>email</b>: terugval voor Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: standaard voor Microsoft Entra ID (v1.0) en andere IdP-typen.</li>
<li><b>unique_name</b>: terugval voor Microsoft Entra ID (v1.0) en andere IdP-typen. <span class="not_support_user_sync">Ondersteunt geen gebruikerssynchronisatie.</span></li>
<li><b>oid</b>: terugval als er geen andere claims aanwezig zijn. Alleen aanwezig bij Microsoft-IdP\'s.</li>
<li><b>sub</b>: terugval als er geen andere claims aanwezig zijn. <span class="not_support_user_sync">Ondersteunt geen gebruikerssynchronisatie.</span></li>
<li><b>samaccountname</b>: aangepaste claim.</li>
<li><b>Aangepast</b>: laat de sitebeheerder een aangepaste waarde invoeren. <span class="not_support_user_sync">Ondersteunt geen gebruikerssynchronisatie.</span></li>
</ul>
Let op: sommige opties ondersteunen geen gebruikerssynchronisatie.';
$string['binding_username_claim_help_ms_with_user_sync'] = 'De opties voor een Microsoft-IdP met ingeschakelde functie voor gebruikerssynchronisatie zijn onder meer:
<ul>
<li><b>Automatisch kiezen</b>: gebruikt de huidige logica, waarbij het token wordt bepaald op basis van het IdP-type en wordt teruggevallen op <b>sub</b> als er geen claim wordt gevonden.</li>
<li><b>email</b>: terugval voor Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: standaard voor Microsoft Entra ID (v1.0) en andere IdP-typen.</li>
<li><b>oid</b>: terugval als er geen andere claims aanwezig zijn. Alleen aanwezig bij Microsoft-IdP\'s.</li>
<li><b>samaccountname</b>: aangepaste claim.</li>
</ul>';
$string['binding_username_claim_help_non_ms'] = 'De opties voor niet-Microsoft-IdP\'s zijn onder meer:
<ul>
<li><b>Automatisch kiezen</b>: gebruikt de huidige logica, waarbij het token wordt bepaald op basis van het IdP-type en wordt teruggevallen op <b>sub</b> als er geen claim wordt gevonden.</li>
<li><b>preferred_username</b></li>
<li><b>email</b></li>
<li><b>unique_name</b></li>
<li><b>sub</b></li>
<li><b>samaccountname</b></li>
<li><b>custom</b>: aangepaste claim.</li>
</ul>';
$string['warning_binding_username_claim_custom_unsupported'] = 'De instelling "Claim voor koppeling van gebruikersnaam" staat momenteel op "Aangepast", wat niet wordt ondersteund voor het geconfigureerde IdP-type met ingeschakelde gebruikerssynchronisatie. Controleer de instellingen voor de <a href="{$a}">claim voor koppeling van gebruikersnaam</a>.';
$string['examplecsv'] = 'Voorbeeldbestand voor uploaden';
$string['usernamefile'] = 'Bestand';
$string['csvdelimiter'] = 'CSV-scheidingsteken';
$string['encoding'] = 'Codering';
$string['rowpreviewnum'] = 'Rijen in voorbeeld';
$string['upload_usernames'] = 'Gekoppelde gebruikersnamen bijwerken';
$string['update_stats_users_updated'] = '{$a} gebruikers zijn bijgewerkt';
$string['update_stats_users_errors'] = 'Bij {$a} gebruikers zijn fouten opgetreden';
$string['update_error_incomplete_line'] = 'De regel bevat niet de vereiste velden.';
$string['update_error_user_not_found'] = 'Geen gebruiker gevonden die overeenkomt met de gebruikersnaam. Er wordt geprobeerd de handmatig gekoppelde gebruiker bij te werken.';
$string['update_error_user_not_oidc'] = 'De gebruiker gebruikt de authenticatiemethode OpenID Connect niet. Er wordt geprobeerd de handmatig gekoppelde gebruiker bij te werken.';
$string['update_error_invalid_new_username'] = 'De nieuwe gebruikersnaam is ongeldig.';
$string['update_error_user_update_failed'] = 'Bijwerken van de gebruiker is mislukt.';
$string['update_warning_email_match'] = 'E-mailadres komt overeen met een bestaande gebruiker.';
$string['update_success_username'] = 'Gebruikersnaam succesvol bijgewerkt.';
$string['update_success_token'] = 'Token succesvol bijgewerkt.';
$string['update_success_o365'] = 'Microsoft 365-verbindingsrecord succesvol bijgewerkt.';
$string['update_error_nothing_updated'] = 'Er is niets bijgewerkt.';
$string['error_invalid_upload_file'] = 'Ongeldig uploadbestand.';
$string['csvline'] = 'CSV-regel';
$string['change_binding_username_claim_tool_description'] = '<p class="warning_header">Dit is een geavanceerde functie. Onjuist gebruik kan gebruikersrecords beïnvloeden en eenmalige aanmelding (SSO) verstoren.</p>
<p>Met dit hulpmiddel kunnen sitebeheerders de volgende records in bulk bijwerken:</p>
<ul>
<li>Gebruikersnamen van Moodle-accounts,</li>
<li>Gekoppelde gebruikersnamen in opgeslagen OpenID Connect-ID-tokens,</li>
<li>Verbindingsrecords tussen Moodle- en Microsoft-accounts.</li>
</ul>
<p>Dit mag alleen worden gebruikt bij het wijzigen van de instellingen voor de <b>claim voor koppeling van gebruikersnaam</b>.</p>
<p>Het hulpmiddel accepteert een eenvoudig CSV-bestand met twee kolommen:</p>
<ul>
<li><b><span class="auth_oidc_code">username</span></b>: de huidige gebruikersnaam van het bij te werken Moodle-account, of, als de huidige gebruiker handmatig is gekoppeld, de huidige waarde van de koppelingsclaim.</li>
<li><b><span class="auth_oidc_code">new_username</span></b>: de hoofdlettergevoelige waarde van de nieuwe tokenclaim die als claim voor koppeling van gebruikersnaam moet worden gebruikt. Als de gebruiker automatisch is gekoppeld en het authenticatietype OpenID Connect gebruikt, wordt de kleine-lettersversie van deze waarde gebruikt als Moodle-gebruikersnaam.</li>
</ul>
<p>Wanneer het bestand is geüpload, voert het hulpmiddel de volgende acties uit:</p>
<ol>
<li>Zoek een bestaande Moodle-gebruiker met de opgegeven <span class="auth_oidc_code">username</span> als gebruikersnaam of e-mailadres, die de authenticatiemethode OpenID Connect gebruikt, en werk, als er een wordt gevonden, de gebruikersnaam van de gebruiker bij naar de kleine-lettersversie van <span class="auth_oidc_code">new_username</span>.</li>
<li>Werk het OpenID Connect-tokenrecord bij.
<ul>
<li>Als in stap 1 hierboven een gebruiker is gevonden, zoek dan het tokenrecord van de gebruiker in de tabel <span class="auth_oidc_code">auth_oidc_token</span> en werk de kolom <span class="auth_oidc_code">username</span> bij naar de kleine-lettersversie van <span class="auth_oidc_code">new_username</span> en de kolom <span class="auth_oidc_code">oidcusername</span> naar dezelfde waarde als <span class="auth_oidc_code">new_username</span>.</li>
<li>Als hierboven geen record wordt gevonden, wordt geprobeerd een record in de tabel <span class="auth_oidc_code">auth_oidc_token</span> te vinden waarvan de kolom <span class="auth_oidc_code">oidcusername</span> overeenkomt met de oude <span class="auth_oidc_code">username</span>, en dit bij te werken naar <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
<li>Mits de plugin <span class="auth_oidc_code">local_o365</span> is geïnstalleerd, werk het verbindingsrecord van de gebruiker bij.
<ul>
<li>Als in stap 1 hierboven een gebruiker is gevonden, zoek dan het verbindingsrecord van de gebruiker in de tabel <span class="auth_oidc_code">local_o365_objects</span> en werk de kolom <span class="auth_oidc_code">o365name</span> bij naar dezelfde waarde als <span class="auth_oidc_code">new_username</span>.</li>
<li>Als in stap 1 geen gebruiker is gevonden, wordt geprobeerd een record van een gebruiker in de tabel <span class="auth_oidc_code">local_o365_objects</span> te vinden waarvan <span class="auth_oidc_code">o365name</span> overeenkomt met de waarde van <span class="auth_oidc_code">username</span>, en dit bij te werken naar de waarde van <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
</ol>
<p>Het onderstaande voorbeeldbestand zou de claim voor koppeling van gebruikersnaam wijzigen van <span class="auth_oidc_code">upn</span> of <span class="auth_oidc_code">email</span> naar <span class="auth_oidc_code">oid</span>.</p>';
$string['change_binding_username_claim_tool_result'] = 'Updateresultaten';
$string['update_username_results'] = 'Resultaten van bijwerken van gebruikersnamen';
$string['new_username'] = 'Nieuwe gebruikersnaam';

// Role sync.
$string['settings_page_role_sync'] = 'Rolsynchronisatie';
$string['settings_role_sync_intro'] = 'Wijst automatisch Moodle-systeemrollen (bijvoorbeeld Manager of Cursusmaker) toe aan gebruikers op basis van een claim in hun OIDC-ID-token. De claim wordt beoordeeld telkens wanneer een gebruiker inlogt via OIDC en werkt met elke OIDC-identiteitsprovider. Deze functie verwijdert alleen rollen die ze zelf heeft toegewezen; handmatig toegewezen rollen worden nooit gewijzigd.';
$string['settings_role_sync_claimmap'] = 'Claimwaarde-naar-rol-toewijzing';
$string['settings_role_sync_claimmap_details'] = 'Eén toewijzing per regel, in het formaat <code>claim|waarde=korte naam van de rol</code>, bijvoorbeeld <code>roles|moodle-managers=manager</code>, of <code>groups|object-ID van de groep=coursecreator</code> bij gebruik van de Entra ID-groups-claim. Meerdere rollen kunnen met komma\'s worden gescheiden. Verschillende regels kunnen verschillende claims gebruiken en de gebruiker krijgt de rollen van elke overeenkomende regel. Waarden worden hoofdletterongevoelig vergeleken en regels die met # beginnen worden genegeerd. De claims moeten aanwezig zijn in het ID-token dat door uw identiteitsprovider wordt uitgegeven; configureer voor Microsoft Entra ID de optionele groups-claim of app-rollen in de app-registratie. Als Entra ID de groups-claim weglaat omdat de gebruiker lid is van te veel groepen, blijven de rollen van die gebruiker ongewijzigd. Rollen worden toegepast in de systeemcontext wanneer de gebruiker inlogt.';
$string['settings_role_sync_revoke'] = 'Rollen verwijderen die niet meer overeenkomen';
$string['settings_role_sync_revoke_details'] = 'Indien ingeschakeld, worden rollen die eerder door deze functie zijn toegewezen bij de volgende login van een gebruiker verwijderd wanneer de claim geen toegewezen waarde meer bevat. Handmatig of op andere wijze toegewezen rollen worden nooit verwijderd.';
$string['settings_role_sync_error_format'] = 'Ongeldige toewijzingsregel "{$a}". Gebruik het formaat claim|waarde=kortenaam[,kortenaam].';
$string['settings_role_sync_error_role'] = 'Onbekende of niet-ondersteunde korte naam van rol "{$a}". Alleen rollen die in de systeemcontext kunnen worden toegewezen, kunnen worden gebruikt.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
