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
 * Finnish language strings.
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
$string['settings_pageheading'] = '{$a} -asetukset';
$string['settings_page_other_settings'] = 'Muut asetukset';
$string['settings_page_application'] = 'IdP ja tunnistautuminen';
$string['settings_page_application_wizard'] = 'Sovelluksen määritysohjattu toiminto';
$string['settings_page_binding_username_claim'] = 'Sidonnan käyttäjätunnusväite';
$string['settings_page_change_binding_username_claim_tool'] = 'Sidonnan käyttäjätunnusväitteen muutostyökalu';
$string['settings_page_cleanup_oidc_tokens'] = 'Siivoa OpenID Connect -tunnukset';
$string['settings_page_clear_user_tokens'] = 'Tyhjennä käyttäjän tunnukset';
$string['settings_page_field_mapping'] = 'Kenttien vastaavuudet';
$string['heading_additional_options'] = 'Lisäasetukset';
$string['heading_additional_options_desc'] = '';
$string['heading_stateredirect'] = 'Kirjautumistilan virhesivu';
$string['heading_stateredirect_desc'] = 'Oletuksena, jos käyttäjältä kestää liian kauan suorittaa kirjautuminen loppuun identiteetintarjoajan palvelussa (esimerkiksi monivaiheisen tunnistautumisen kehotetta hyväksyttäessä) ja tallennettu kirjautumistila on sillä välin siivottu pois, Moodle näyttää yleisen virhesivunsa. Alla olevilla asetuksilla voit pidentää kirjautumistilan säilytysaikaa ja näyttää yleisen virhesivun sijaan ystävällisemmän, muokattavan viestin, jonka jälkeen käyttäjä ohjataan automaattisesti takaisin kirjautumissivulle.';
$string['heading_user_restrictions'] = 'Käyttäjärajoitukset';
$string['heading_user_restrictions_desc'] = '';
$string['heading_sign_out'] = 'Uloskirjautumisen integrointi';
$string['heading_sign_out_desc'] = '';
$string['heading_display'] = 'Näyttö';
$string['heading_display_desc'] = '';
$string['heading_debugging'] = 'Virheenkorjaus';
$string['heading_debugging_desc'] = '';
$string['heading_tools'] = 'Työkalut';
$string['microsoftcloud'] = 'Microsoft-pilvi';
$string['microsoftcloud_help'] = 'Valitse Microsoft-pilvi, johon Microsoft Entra -vuokraajasi kuuluu. Asetus koskee Microsoft Entra ID- ja Microsoft identity platform -tyyppisiä IdP:itä.<br/>
Valitse "Microsoft 365, jota operoi 21Vianet (Kiina)", jos organisaatiosi käyttää 21Vianetin tarjoamaa Microsoft 365:tä. Tällöin lisäosien tekemissä pyynnöissä käytetään kyseisen pilven kirjautumispalvelua ja Microsoft Graph -päätepisteitä, ja alla olevien päätepisteiden ja resurssin oletusarvot määräytyvät sen mukaan. Päätepisteille, resurssille ja uloskirjautumisen päätepisteelle jo tallennettuja arvoja ei muuteta, joten päivitä ne, jos ne on yhä asetettu globaalin pilven päätepisteisiin.';
$string['microsoftcloud_global'] = 'Microsoft 365 (globaali)';
$string['microsoftcloud_china'] = 'Microsoft 365, jota operoi 21Vianet (Kiina)';
$string['idptype'] = 'Identiteetintarjoajan (IdP) tyyppi';
$string['idptype_help'] = 'Tällä hetkellä tuetaan kolmea IdP-tyyppiä:
<ul>
<li><b>Microsoft Entra ID (v1.0)</b>: Microsoft Entra ID oauth2 v1.0 -päätepisteillä, esim. https://login.microsoftonline.com/organizations/oauth2/authorize.</li>
<li><b>Microsoft identity platform (v2.0)</b>: Microsoft Entra ID oauth2 v2.0 -päätepisteillä, esim. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize.</li>
<li><b>Muu</b>: mikä tahansa muu kuin Microsoftin IdP.</li>
</ul>
Vaihtoehtojen <b>Microsoft Entra ID (v1.0)</b> ja <b>Microsoft identity platform (v2.0)</b> erot löytyvät osoitteesta <a href="https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison">https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison</a>.<br/>
Huomaa erityisesti, että määritetty sovellus voi käyttää tunnistautumiseen <b>salaisuuden</b> lisäksi <b>varmennetta</b>, kun käytetään <b>Microsoft identity platform (v2.0)</b> -IdP:tä.<br/>
Valtuutus- ja tunnuspäätepisteet on määritettävä määritetyn IdP-tyypin mukaisesti.';
$string['idp_type_not_connected'] = 'Ei yhdistetty';
$string['idp_type_microsoft_entra_id'] = 'Microsoft Entra ID (v1.0)';
$string['idp_type_microsoft_identity_platform'] = 'Microsoft identity platform (v2.0)';
$string['idp_type_other'] = 'Muu';
$string['settings_application_wizard_desc'] = 'Jos haluat määrittää nämä asetukset ohjatulla lomakkeella, jossa on vaiheittaiset ohjeet ja syötteiden tarkistus, käytä <a href="{$a}">sovelluksen määritysohjattua toimintoa</a>.';
$string['authendpoint'] = 'Valtuutuksen päätepiste';
$string['authendpoint_help'] = 'IdP:n valtuutuspäätepisteen URI, jota käytetään.<br/>
Huomaa, että jos sivusto määritetään sallimaan pääsy myös muiden vuokraajien käyttäjille, vuokraajakohtaista valtuutuspäätepistettä ei voi käyttää.';
$string['clientid'] = 'Sovellustunnus';
$string['clientid_help'] = 'IdP:ssä rekisteröity sovellus- / asiakastunnus (Application / Client ID).';
$string['clientauthmethod'] = 'Asiakkaan tunnistautumistapa';
$string['clientauthmethod_help'] = '<ul>
<li>Kaikentyyppiset IdP:t voivat käyttää "<b>Salaisuus</b>"-tunnistautumistapaa.</li>
<li><b>Microsoft identity platform (v2.0)</b> -tyyppinen IdP voi lisäksi käyttää <b>Varmenne</b>-tunnistautumistapaa.</li>
</ul>';
$string['auth_method_secret'] = 'Salaisuus';
$string['auth_method_certificate'] = 'Varmenne';
$string['clientsecret'] = 'Asiakassalaisuus';
$string['clientsecret_help'] = 'Kun käytetään <b>salaisuus</b>-tunnistautumistapaa, tämä on IdP:n asiakassalaisuus. Joissakin palveluissa sitä kutsutaan myös avaimeksi.';
$string['clientprivatekey'] = 'Asiakasvarmenteen yksityinen avain';
$string['clientprivatekey_help'] = 'Kun käytetään <b>varmenne</b>-tunnistautumistapaa ja varmenteen lähteenä on <b>Pelkkä teksti</b>, tämä on IdP:hen tunnistautumisessa käytettävän varmenteen yksityinen avain.';
$string['clientcert'] = 'Asiakasvarmenteen julkinen avain';
$string['clientcert_help'] = 'Kun käytetään <b>varmenne</b>-tunnistautumistapaa ja varmenteen lähteenä on <b>Pelkkä teksti</b>, tämä on IdP:hen tunnistautumisessa käytettävä julkinen avain eli varmenne.';
$string['clientcertsource'] = 'Varmenteen lähde';
$string['clientcertsource_help'] = 'Kun käytetään <b>varmenne</b>-tunnistautumistapaa, tällä määritetään, mistä varmenne haetaan.
<ul>
<li><b>Pelkkä teksti</b> -lähde edellyttää, että varmenne- ja yksityisen avaimen tiedostojen sisältö määritetään seuraaviin tekstialueasetuksiin.</li>
<li><b>Tiedostonimi</b>-lähde edellyttää, että varmenne- ja yksityisen avaimen tiedostot ovat Moodlen datakansion kansiossa <b>microsoft_certs</b>.</li>
</ul>';
$string['cert_source_text'] = 'Pelkkä teksti';
$string['cert_source_path'] = 'Tiedostonimi';
$string['clientprivatekeyfile'] = 'Asiakasvarmenteen yksityisen avaimen tiedostonimi';
$string['clientprivatekeyfile_help'] = 'Kun käytetään <b>varmenne</b>-tunnistautumistapaa ja varmenteen lähteenä on <b>Tiedostonimi</b>, tämä on IdP:hen tunnistautumisessa käytettävän yksityisen avaimen tiedostonimi. Tiedoston on oltava Moodlen datakansion kansiossa <b>microsoft_certs</b>.';
$string['clientcertfile'] = 'Asiakasvarmenteen julkisen avaimen tiedostonimi';
$string['clientcertfile_help'] = 'Kun käytetään <b>varmenne</b>-tunnistautumistapaa ja varmenteen lähteenä on <b>Tiedostonimi</b>, tämä on IdP:hen tunnistautumisessa käytettävän julkisen avaimen eli varmenteen tiedostonimi. Tiedoston on oltava Moodlen datakansion kansiossa <b>microsoft_certs</b>.';
$string['clientcertpassphrase'] = 'Asiakasvarmenteen tunnuslause';
$string['clientcertpassphrase_help'] = 'Jos asiakasvarmenteen yksityinen avain on salattu, tämä on tunnuslause sen salauksen purkamiseen.';
$string['change_client_secret'] = 'Vaihda asiakassalaisuus';
$string['change_client_secret_desc'] = 'Valitse tämä ruutu päivittääksesi asiakassalaisuuden. Turvallisuussyistä olemassa olevat salaisuudet on peitetty, ja niistä näytetään vain kaksi ensimmäistä merkkiä.';
$string['change_cert_passphrase'] = 'Vaihda varmenteen tunnuslause';
$string['change_cert_passphrase_desc'] = 'Valitse tämä ruutu päivittääksesi varmenteen tunnuslauseen. Turvallisuussyistä olemassa olevat tunnuslauseet on peitetty, ja niistä näytetään vain kaksi ensimmäistä merkkiä.';
$string['cfg_usepkce_key'] = 'Käytä PKCE:tä';
$string['cfg_usepkce_desc'] = 'Kun käytetään <b>Authorization Code</b> -kirjautumiskulkua, valtuutuspyynnössä lähetetään PKCE (RFC 7636) -"code_challenge" S256-menetelmällä ja valtuutuskoodia vaihdettaessa vastaava "code_verifier". Microsoft Entra ID tukee tätä. Muiden palveluntarjoajien kohdalla ota tämä käyttöön vain, jos palveluntarjoajasi tukee PKCE:tä, sillä jotkin palveluntarjoajat hylkäävät valtuutuspyynnöt, joissa on niille tuntemattomia parametreja.';
$string['cfg_domainhint_key'] = 'Toimialuevihje';
$string['cfg_domainhint_desc'] = 'Kun käytetään <b>Authorization Code</b> -kirjautumiskulkua, tämä arvo välitetään "domain_hint"-parametrina. Jotkin OpenID Connect -IdP:t käyttävät "domain_hint"-parametria helpottamaan käyttäjien kirjautumista. Tarkista palveluntarjoajaltasi, tukeeko se tätä parametria.';
$string['cfg_forceselectaccount_key'] = 'Näytä aina tilin valinta';
$string['cfg_forceselectaccount_desc'] = 'Jos tämä on käytössä, käyttäjiltä kysytään aina, millä tilillä he kirjautuvat, sen sijaan että heidät kirjattaisiin automaattisesti sisään selaimessa aktiivisena olevalla tilillä. Hyödyllinen, kun käyttäjillä on useita tilejä, esimerkiksi opiskelija- ja ylläpitäjätili.<br/>
Hiljainen kirjautumistila on etusijalla: kun se on käytössä, tilin valintaa ei pakoteta hiljaisessa kirjautumisessa.';
$string['cfg_forceredirect_key'] = 'Pakota uudelleenohjaus';
$string['cfg_forceredirect_desc'] = 'Jos tämä on käytössä, kirjautumisen etusivu ohitetaan ja käyttäjä ohjataan OpenID Connect -sivulle. Tämän voi ohittaa URL-parametrilla ?noredirect=1';
$string['cfg_stateexpiry_key'] = 'Kirjautumistilan vanhenemisaika (minuuttia)';
$string['cfg_stateexpiry_desc'] = 'Kuinka kauan kirjautumistilatietue säilytetään, ennen kuin ajastettu siivoustehtävä poistaa sen. Kasvata arvoa, jos käyttäjiltä kuluu säännöllisesti tätä kauemmin kirjautumisen suorittamiseen identiteetintarjoajan palvelussa (esimerkiksi monivaiheisen tunnistautumisen kehotteiden vuoksi).';
$string['error_stateexpiry_min'] = 'Kirjautumistilan vanhenemisajan on oltava vähintään 1 minuutti. Nolla tai sitä pienempi arvo saisi parhaillaan käynnissä olevat kirjautumiset epäonnistumaan.';
$string['cfg_stateredirect_enabled_key'] = 'Näytä ystävällinen virhesivu';
$string['cfg_stateredirect_enabled_desc'] = 'Jos tämä on käytössä, käyttäjälle, jolta kirjautumisen suorittaminen identiteetintarjoajan palvelussa kestää liian kauan (niin että tallennettu kirjautumistila on sillä välin siivottu pois), näytetään Moodlen yleisen virhesivun sijaan alla oleva muokattava viesti, ja hänet ohjataan automaattisesti takaisin kirjautumissivulle.';
$string['cfg_stateredirect_message_key'] = 'Viesti';
$string['cfg_stateredirect_message_desc'] = 'Ystävällisellä virhesivulla käyttäjälle näytettävä viesti.';
$string['cfg_stateredirect_message_default'] = 'Kirjautumisessasi ilmeni ongelma. Todennäköisin syy on, että kirjautumisen suorittaminen kesti liian kauan (esimerkiksi monivaiheisen tunnistautumisen kehotetta hyväksyttäessä). Sinut ohjataan automaattisesti kirjautumissivulle, jotta voit yrittää uudelleen.';
$string['cfg_stateredirect_delay_key'] = 'Uudelleenohjauksen viive (sekuntia)';
$string['cfg_stateredirect_delay_desc'] = 'Kuinka monta sekuntia yllä oleva viesti näytetään, ennen kuin käyttäjä ohjataan automaattisesti takaisin kirjautumissivulle.';
$string['cfg_set_pix_key'] = 'Näytä kuvake kirjautumissivulla';
$string['cfg_set_pix_desc'] = 'Jos tämä on käytössä, kirjautumissivulla näytetään kuvake palveluntarjoajan nimen vieressä.';
$string['cfg_icon_key'] = 'Kuvake';
$string['cfg_icon_desc'] = 'Kirjautumissivulla palveluntarjoajan nimen vieressä näkyvä kuvake.';
$string['cfg_iconalt_o365'] = 'Office 365 -kuvake';
$string['cfg_iconalt_microsoft365'] = 'Microsoft 365 -logo';
$string['cfg_iconalt_openid'] = 'OpenID-kuvake';
$string['cfg_iconalt_keycloak'] = 'Keycloak-kuvake';
$string['cfg_customicon_key'] = 'Mukautettu kuvake';
$string['cfg_customicon_desc'] = 'Jos haluat käyttää omaa kuvaketta, lataa se tähän. Ladattu kuvake korvaa yllä valitun kuvakkeen. <br /><br /><b>Mukautettujen kuvakkeiden käytössä huomioitavaa:</b><ul><li>Ladatun tiedoston kokoa ei muuteta. Se näytetään kirjautumissivulla kiinteässä 24 x 24 pikselin koossa, ja selain skaalaa sen sopivaksi, joten suosittelemme lataamaan neliön muotoisen kuvan vääristymien välttämiseksi.</li><li>Jos olet ladannut mukautetun kuvakkeen ja haluat palata käyttämään jotakin vakiokuvakkeista, napsauta mukautettua kuvaketta yllä olevassa ruudussa, valitse "Poista", sitten "OK" ja lopuksi "Tallenna muutokset" tämän lomakkeen alaosassa. Valittu vakiokuvake näkyy tämän jälkeen Moodlen kirjautumissivulla.</li></ul>';
$string['cfg_debugmode_key'] = 'Kirjaa virheenkorjausviestit';
$string['cfg_debugmode_desc'] = 'Jos asetus on käytössä, tiedot kirjataan Moodlen lokiin ongelmien tunnistamista varten.';
$string['cfg_silentloginmode_key'] = 'Hiljainen kirjautumistila';
$string['cfg_silentloginmode_desc'] = 'Jos tämä on käytössä, Moodle yrittää kirjata käyttäjän sisään käyttämällä hänen aktiivista istuntoaan, jolla hän on tunnistautunut määritettyyn valtuutuspäätepisteeseen.<br/>
Toiminnon käyttö edellyttää seuraavia määrityksiä:
<ul>
<li><b>Pakota käyttäjät kirjautumaan sisään</b> (forcelogin) <a href="{$a}" target="_blank">Sivuston suojausasetukset -osiossa</a> on käytössä.</li>
<li>Yllä oleva <b>Pakota uudelleenohjaus</b> (auth_oidc/forceredirect) -asetus on käytössä.</li>
</ul>
Jotta Moodle ei yrittäisi kirjautua henkilökohtaisilla tileillä tai muiden vuokraajien tileillä, on myös suositeltavaa käyttää vuokraajakohtaisia päätepisteitä yleisten, esimerkiksi "common"- tai "organizations"-polkuja käyttävien päätepisteiden sijaan.<br/>
<br/>
Microsoftin IdP:itä käytettäessä käyttökokemus on seuraava:
<ul>
<li>Jos aktiivista käyttäjäistuntoa ei löydy, näytetään Moodlen kirjautumissivu.</li>
<li>Jos löytyy vain yksi aktiivinen käyttäjäistunto ja käyttäjällä on pääsy Entra ID -sovellukseen (eli käyttäjä on samasta vuokraajasta tai vuokraajan vieraskäyttäjä), käyttäjä kirjataan automaattisesti Moodleen kertakirjautumisella (SSO).</li>
<li>Jos löytyy vain yksi aktiivinen käyttäjäistunto, mutta käyttäjällä ei ole pääsyä Entra ID -sovellukseen (esim. käyttäjä on eri vuokraajasta tai sovellus edellyttää käyttäjän määrittämistä eikä käyttäjää ole määritetty), näytetään Moodlen kirjautumissivu.</li>
<li>Jos löytyy useita aktiivisia käyttäjäistuntoja, joilla on pääsy Entra ID -sovellukseen, näytetään sivu, jolla käyttäjä voi valita kirjautumiseen käytettävän tilin.</li>
</ul>';
$string['oidcresource'] = 'Resurssi';
$string['oidcresource_help'] = 'OpenID Connect -resurssi, jolle pyyntö lähetetään.<br/>
<b>Huomaa</b>, että tätä parametria ei tueta <b>Microsoft identity platform (v2.0)</b> -tyyppisessä IdP:ssä.';
$string['oidcscope'] = 'Käyttöalue (scope)';
$string['oidcscope_help'] = 'Käytettävä OIDC-käyttöalue (scope).';
$string['customclaims'] = 'Mukautetut väitteet';
$string['customclaims_help'] = 'Välilyönnein eroteltu luettelo identiteetintarjoajasi tunnuksissa olevien mukautettujen väitteiden (claim) nimistä.<br/>
<b>Tärkeää:</b>
<ul>
<li>Väitteiden on oltava olemassa IdP:n tunnusmäärityksissä (esim. Keycloakin protocol mapper -määritykset, Microsoft Entra ID:n valinnaiset/mukautetut väitteet)</li>
<li>Jos väitettä ei ole tunnuksessa, kenttien vastaavuusmääritys ohittaa sen huomaamatta – virheilmoitusta ei näytetä</li>
<li>Väitteiden nimissä kirjainkoolla on merkitystä, ja ne voivat sisältää vain kirjaimia, numeroita, yhdysmerkkejä ja alaviivoja</li>
<li>Väitteen nimi ei voi olla varattu nimi, kuten JWT:n/OpenID Connectin vakioväite (esim. <code>sub</code>, <code>email</code>), Microsoft Entra ID:lle (esim. <code>oid</code>, <code>upn</code>) tai Keycloakille (esim. <code>realm_access</code>, <code>resource_access</code>) ominainen väite tai olemassa oleva kenttävastaavuuden vaihtoehto</li>
<li>Väite <code>roles</code> (sovellusroolit Microsoft Entra ID -tunnuksissa) ja väite <code>groups</code> (ryhmätunnisteet) ovat sallittuja. Ne näkyvät kenttien vastaavuuksissa nimillä "roles (token claim)" ja "groups (token claim)" erillään sisäänrakennetuista "Roolit"- ja "Ryhmät"-vaihtoehdoista, jotka vastaavat Microsoft Graphista haettuja Microsoft Entran hakemistorooleja ja ryhmien nimiä. Useita arvoja sisältävät väitteet tallennetaan pilkuin eroteltuna luettelona</li>
<li>Esimerkkejä: <code>employee_type badge_number costCenter custom_role</code></li>
<li>Kirjautumisen yhteydessä mukautetut väitteet luetaan aina tunnuksesta riippumatta siitä, käytetäänkö myös Microsoft Graphia. Ajastetun käyttäjien synkronointitehtävän aikana luettavaa käyttäjätunnusta ei ole, joten mukautettu väite synkronoidaan vain, jos sen nimi sattuu olemaan myös valittavissa oleva Microsoft Graphin käyttäjäominaisuus, kuten hakemiston laajennusmäärite (esim. <code>extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode</code>). Mukautettu väite, jonka Microsoft Graph hylkää, ohitetaan kyseisellä synkronointikerralla ja tehtävän lokiin kirjataan varoitus sen sijaan, että koko synkronointi epäonnistuisi.</li>
</ul>';
$string['secretexpiryrecipients'] = 'Salaisuuden vanhenemisilmoitusten vastaanottajat';
$string['secretexpiryrecipients_help'] = 'Pilkuin eroteltu luettelo sähköpostiosoitteista, joihin salaisuuden vanhenemisilmoitukset lähetetään.<br/>
Jos sähköpostiosoitetta ei anneta, ilmoitus lähetetään sivuston pääylläpitäjälle.<br/>
Oletuksena ilmoituksia lähetetään päivittäin neljä viikkoa ennen vanhenemista alkaen, kunnes salaisuus on uusittu.';
$string['cfg_showbutton_key'] = 'Näytä kirjautumispainike';
$string['cfg_showbutton_desc'] = 'Jos tämä ei ole käytössä, palveluntarjoajan kirjautumispainiketta ei näytetä kirjautumissivulla. Käyttäjät voivat silti tunnistautua tämän palveluntarjoajan kautta siirtymällä suoraan sen kirjautumis-URL-osoitteeseen.';
$string['cfg_opname_key'] = 'Palveluntarjoajan nimi';
$string['cfg_opname_desc'] = 'Tämä on loppukäyttäjälle näkyvä selite, joka ilmoittaa kirjautumiseen käytettävien tunnistetietojen tyypin. Tätä palveluntarjoajan selitettä käytetään tämän lisäosan kaikissa käyttäjälle näkyvissä osioissa.';
$string['cfg_redirecturi_key'] = 'Uudelleenohjauksen URI';
$string['cfg_redirecturi_desc'] = 'Tämä on rekisteröitävä uudelleenohjauksen URI. OpenID Connect -identiteetintarjoaja pyytää tätä tietoa, kun rekisteröit Moodlen asiakkaaksi. <br /><b>HUOMAUTUS:</b> Anna URI OpenID Connect -palveluntarjoajan palveluun *täsmälleen* tässä näkyvässä muodossa. Muussa tapauksessa kirjautuminen OpenID Connect -palvelun avulla ei onnistu.';
$string['tokenendpoint'] = 'Tunnuspäätepiste';
$string['tokenendpoint_help'] = 'IdP:n tunnuspäätepisteen (token endpoint) URI, jota käytetään.<br/>
Huomaa, että jos sivusto määritetään sallimaan pääsy myös muiden vuokraajien käyttäjille, vuokraajakohtaista tunnuspäätepistettä ei voi käyttää.';
$string['cfg_userrestrictions_key'] = 'Käyttäjärajoitukset';
$string['cfg_userrestrictions_desc'] = 'Salli kirjautuminen vain käyttäjille, jotka täyttävät tietyt rajoitukset. <br /><b>Käyttäjärajoitusten käyttö: </b> <ul><li>Anna <a href="https://en.wikipedia.org/wiki/Regular_expression">säännöllisen lausekkeen</a> malli, joka vastaa sallittavien käyttäjien käyttäjätunnuksia.</li><li>Anna yksi malli riviä kohden</li><li>Jos annat useita malleja, käyttäjä sallitaan, jos hän vastaa MITÄ TAHANSA malleista.</li><li>Merkki "/" on suojattava merkillä "\\".</li><li>Jos et anna yllä mitään rajoituksia, Moodle hyväksyy kaikki käyttäjät, jotka voivat kirjautua OpenID Connect -IdP:hen.</li><li>Käyttäjä, joka ei vastaa mitään annetuista malleista, ei voi kirjautua OpenID Connectin avulla.</li></ul>';
$string['cfg_userrestrictionscasesensitive_key'] = 'Käyttäjärajoitusten kirjainkoon huomiointi';
$string['cfg_userrestrictionscasesensitive_desc'] = 'Tällä määritetään, käytetäänkö säännöllisen lausekkeen "/i"-valitsinta käyttäjärajoitusten vertailussa.<br/>Jos tämä on käytössä, kaikissa käyttäjärajoitusten tarkistuksissa kirjainkoolla on merkitystä. Huomaa, että jos tämä ei ole käytössä, mallien kirjainkokoa ei huomioida.';
$string['heading_dummy_email'] = 'Paikkamerkkisähköpostiosoitteet';
$string['heading_dummy_email_desc'] = 'Moodle edellyttää, että jokaisella käyttäjätilillä on sähköpostiosoite, mutta Microsoft Entra ID -tileillä sitä ei tarvitse olla. Alla olevilla asetuksilla Moodle voi luoda toimimattoman paikkamerkkiosoitteen käyttäjille, joilla ei ole IdP:ltä saatua käyttökelpoista sähköpostiosoitetta, sen sijaan että heidän sähköpostiosoitteensa jätettäisiin tyhjäksi.';
$string['cfg_generatedummyemail_key'] = 'Luo paikkamerkkisähköpostiosoitteet';
$string['cfg_generatedummyemail_desc'] = 'Jos tämä on käytössä ja käyttäjällä ei ole IdP:ltä saatua sähköpostiosoitetta eikä käyttökelpoista sähköpostiosoitteen muotoista käyttäjän päätunnusta (UPN), Moodle luo hänelle paikkamerkkisähköpostiosoitteen hänen Microsoft-käyttäjän päätunnuksestaan (tai objektitunnuksesta, jos päätunnusta ei ole saatavilla) ja alla määritetystä toimialueesta sen sijaan, että sähköpostiosoite jätettäisiin tyhjäksi. Tämä koskee sekä käyttäjän kirjautumista että käyttäjän luomista käyttäjien synkronointitehtävässä.';
$string['cfg_dummyemaildomain_key'] = 'Paikkamerkkisähköpostin toimialue';
$string['cfg_dummyemaildomain_desc'] = 'Paikkamerkkisähköpostiosoitteiden luonnissa käytettävä toimialue, esimerkiksi "example.test". Käytä toimialuetta, joka ei voi vastaanottaa postia, jotta luotuja osoitteita ei koskaan voi sekoittaa todellisiin, toimiviin osoitteisiin.';
$string['cfg_signoffintegration_key'] = 'Kertauloskirjautuminen (Moodlesta IdP:hen)';
$string['cfg_signoffintegration_desc'] = 'Jos asetus on käytössä ja määritettyyn IdP:hen yhdistetty Moodle-käyttäjä kirjautuu ulos Moodlesta, integraatio lähettää pyynnön alla olevaan uloskirjautumisen päätepisteeseen ja yrittää kirjata käyttäjän ulos myös IdP:stä.<br/>
Huomaa, että Microsoft Entra ID -integraatiossa Moodle-sivuston URL-osoite ({$a}) on lisättävä uudelleenohjauksen URI:ksi Moodle- ja Microsoft 365 -integraatiota varten luotuun Microsoft Entra ID -sovellukseen.';
$string['cfg_logoutendpoint_key'] = 'IdP:n uloskirjautumisen päätepiste';
$string['cfg_logoutendpoint_desc'] = 'IdP:n uloskirjautumispäätepisteen URI, jota käytetään.';
$string['cfg_frontchannellogouturl_key'] = 'Front-channel-uloskirjautumisen URL-osoite';
$string['cfg_frontchannellogouturl_desc'] = 'Tämä on URL-osoite, jota IdP:n on kutsuttava, kun se yrittää kirjata käyttäjiä ulos Moodlesta.<br/>
Microsoft Entra ID:ssä / Microsoft identity platformissa asetuksen nimi on "Front-channel logout URL", ja sen voi määrittää Microsoft Entra ID -sovelluksessa.';
$string['cfg_field_mapping_desc'] = 'Käyttäjäprofiilin tietoja voidaan siirtää OpenID Connect -IdP:stä Moodleen kenttien vastaavuuksien avulla. Käytettävissä olevat etäkentät riippuvat suuresti IdP-tyypistä.<br/>
<ul>
<li>Jotkin profiilin peruskentät ovat saatavilla kaikkien IdP-tyyppien käyttöoikeustunnusten ja ID-tunnusten väitteistä.</li>
<li>Jos määritettynä on Microsoftin IdP-tyyppi (v1.0 tai v2.0), lisää profiilitietoja voidaan saada Graph API -kutsuilla asentamalla ja määrittämällä <a href="https://moodle.org/plugins/local_o365">Microsoft 365 -integraatiolisäosa (local_o365)</a>.</li>
<li>Jos SDS-profiilisynkronointi on otettu käyttöön local_o365-lisäosassa, tiettyjä profiilikenttiä voidaan synkronoida SDS:stä Moodleen. Tämä tapahtuu vain ajettaessa ajastettua tehtävää "Synkronoi SDS:n kanssa", ei ajettaessa ajastettua tehtävää "Synkronoi käyttäjät Microsoft Entra ID:stä" eikä käyttäjän kirjautuessa.</li>
</ul>

ID- ja käyttöoikeustunnuksista saatavat väitteet vaihtelevat IdP-tyypin mukaan, mutta useimmat IdP:t sallivat väitteiden jonkinasteisen mukauttamisen. Microsoftin IdP:iden dokumentaatio on linkitetty alla:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Käyttöoikeustunnuksen väitteet</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">ID-tunnuksen väitteet</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Valinnaisten väitteiden määritys</a>: Huomaa, että "Email" on valinnainen väite Microsoft Entra ID (v1.0) -IdP-tyypissä.</li>
</ul>';

$string['cfg_cleanupoidctokens_key'] = 'Siivoa OpenID Connect -tunnukset';
$string['cfg_cleanupoidctokens_desc'] = 'Jos käyttäjilläsi on ongelmia kirjautua Microsoft 365 -tilillään, kokeile siivota OpenID Connect -tunnukset. Tämä poistaa irralliset ja keskeneräiset tunnukset, jotka voivat aiheuttaa virheitä. VAROITUS: Tämä voi keskeyttää käynnissä olevat kirjautumiset, joten se kannattaa tehdä huoltokatkon aikana.';
$string['settings_section_basic'] = 'Perusasetukset';
$string['settings_section_authentication'] = 'Tunnistautuminen';
$string['settings_section_endpoints'] = 'Päätepisteet';
$string['settings_section_other_params'] = 'Muut parametrit';
$string['settings_section_secret_expiry_notification'] = 'Salaisuuden vanhenemisilmoitus';
$string['application_updated'] = 'OpenID Connect -sovelluksen asetukset on päivitetty.';
$string['application_updated_microsoft'] = 'OpenID Connect -sovelluksen asetus päivitettiin.<br/>
<span class="warning" style="color: red;">Microsoft Entra ID -järjestelmänvalvojan on tehtävä <b>Anna järjestelmänvalvojan suostumus</b> ja <b>Tarkista määritykset</b> uudelleen Microsoft 365 -integraation määrityssivulla, jos asetuksia "Identiteetintarjoajan (IdP) tyyppi" tai "Asiakkaan tunnistautumistapa" päivitetään.</span>';
$string['application_updated_microsoft_notify'] = 'OpenID Connect -sovelluksen asetus päivitettiin.<br/>
<span class="warning" style="color: red;">Microsoft Entra ID -järjestelmänvalvojan on tehtävä <b>Anna järjestelmänvalvojan suostumus</b> ja <b>Tarkista määritykset</b> uudelleen <a href="{$a}">Microsoft 365 -integraation määrityssivulla</a>, jos asetuksia "Identiteetintarjoajan (IdP) tyyppi" tai "Asiakkaan tunnistautumistapa" päivitetään.</span>';
$string['application_not_changed'] = 'OpenID Connect -sovelluksen asetusta ei muutettu.';

$string['event_debug'] = 'Virheenkorjausviesti';

$string['task_cleanup_oidc_state_and_token'] = 'Siivoa OIDC-tila ja virheelliset tunnukset';
$string['task_cleanup_oidc_sid'] = 'Siivoa OIDC SID -tietueet';

$string['errorauthdisconnectemptypassword'] = 'Salasana ei voi olla tyhjä';
$string['errorauthdisconnectemptyusername'] = 'Käyttäjätunnus ei voi olla tyhjä';
$string['errorauthdisconnectusernameexists'] = 'Annettu käyttäjätunnus on jo käytössä. Valitse toinen käyttäjätunnus.';
$string['errorauthdisconnectnewmethod'] = 'Käytä kirjautumismenetelmää';
$string['errorauthdisconnectinvalidmethod'] = 'Virheellinen kirjautumismenetelmä vastaanotettiin.';
$string['errorauthdisconnectifmanual'] = 'Jos käytät manuaalista kirjautumismenetelmää, anna tunnistetiedot alla.';
$string['errorauthgeneral'] = 'Kirjautumisessasi ilmeni ongelma. Ota yhteyttä ylläpitäjään saadaksesi apua.';
$string['errorauthinvalididtoken'] = 'Virheellinen id_token vastaanotettiin.';
$string['errorauthloginfailednouser'] = 'Virheellinen kirjautuminen: Kirjauduit tunnuksella "{$a}", mutta tällä sivustolla ei ole vastaavaa tiliä eikä uusia tilejä voida luoda automaattisesti. Ota yhteyttä sivuston ylläpitäjään saadaksesi apua. Jos sinulla on useampi kuin yksi tili, valitse Jatka kirjautuaksesi toisella tilillä.';
$string['errorauthloginfaileddupemail'] = 'Virheellinen kirjautuminen: Tässä Moodlessa on jo tili, jolla on sama sähköpostiosoite kuin luotavalla tilillä, ja asetus "Salli käyttäjätunnukset, joilla on sama sähköpostiosoite" (allowaccountssameemail) ei ole käytössä.';
$string['errorauthmfarequired'] = 'Microsoft edellyttää monivaiheista tunnistautumista kirjautumisesi suorittamiseksi, mutta sitä ei voitu suorittaa loppuun. Yritä uudelleen tai kirjaudu Microsoft 365:een uudessa selainistunnossa ja suorita monivaiheisen tunnistautumisen kehote loppuun.';
$string['errorauthnoauthcode'] = 'Identiteettipalvelimelta ei vastaanotettu valtuutuskoodia. Virhelokeissa voi olla lisätietoja.';
$string['errorauthnocredsandendpoints'] = 'Määritä OpenID Connect -asiakkaan tunnistetiedot ja päätepisteet.';
$string['errorauthnoidtoken'] = 'OpenID Connectin id_token-tunnusta ei vastaanotettu.';
$string['errorauthnoaccesstoken'] = 'Käyttöoikeustunnusta ei vastaanotettu.';
$string['errorauthunknownstate'] = 'Tuntematon tila.';
$string['errorauthuseralreadyconnected'] = 'Yhteys on jo muodostettu toiseen OpenID Connect -käyttäjään.';
$string['errorauthuserconnectedtodifferent'] = 'Todennettu OpenID Connect -käyttäjä on jo yhdistetty Moodle-käyttäjään.';
$string['errorbadloginflow'] = 'Määritetty tunnistautumistyyppi on virheellinen. Huomautus: Jos saat tämän viestin äskettäisen asennuksen tai päivityksen jälkeen, tyhjennä Moodlen välimuisti.';
$string['errorjwtbadpayload'] = 'JWT-tietoja ei voitu lukea.';
$string['errorjwtcouldnotreadheader'] = 'JWT-otsikkoa ei voitu lukea';
$string['errorjwtempty'] = 'Vastaanotettu JWT on tyhjä, tai se ei ole kelvollinen merkkijono.';
$string['errorjwtinvalidheader'] = 'Virheellinen JWT-otsikko';
$string['errorjwtmalformed'] = 'Vastaanotettu JWT on virheellinen.';
$string['errorjwtunsupportedalg'] = 'JWS Alg tai JWE ei ole tuettu';
$string['erroroidcnotenabled'] = 'OpenID Connect -todennuslisäosa ei ole käytössä.';
$string['errornodisconnectionauthmethod'] = 'Yhteyttä ei voi katkaista, koska käytössä ei ole todennuslisäosaa, johon voitaisiin palata (joko käyttäjän edellinen kirjautumismenetelmä tai manuaalinen kirjautumismenetelmä).';
$string['erroroidcclientinvalidendpoint'] = 'Virheellinen päätepisteen URI vastaanotettiin.';
$string['erroroidcclientnocreds'] = 'Määritä asiakkaan tunnistetiedot setcreds-komennolla';
$string['erroroidcclientnoauthendpoint'] = 'Valtuutuksen päätepistettä ei ole määritetty. Määritä komennolla $this->setendpoints';
$string['erroroidcclientnotokenendpoint'] = 'Tunnuspäätepistettä ei ole määritetty. Määritä komennolla $this->setendpoints';
$string['errorrestricted'] = 'Tällä sivustolla on rajoituksia sille, ketkä käyttäjät voivat kirjautua OpenID Connectin avulla. Nämä rajoitukset estävät tällä hetkellä sinua suorittamasta tätä kirjautumisyritystä loppuun.';
$string['errorucpinvalidaction'] = 'Virheellinen toiminto vastaanotettiin.';
$string['erroroidccall'] = 'OpenID Connect -palvelussa tapahtui virhe. Lisätietoja on lokeissa.';
$string['erroroidccall_message'] = 'Virhe OpenID Connect -palvelussa: {$a}';
$string['errorinvalidredirect_message'] = 'URL-osoitetta, johon yrität ohjata, ei ole olemassa.';
$string['errorinvalidcertificatesource'] = 'Virheellinen varmenteen lähde';
$string['error_invalid_client_authentication_method'] = 'Virheellinen asiakkaan tunnistautumistapa';
$string['error_certificate_requires_identity_platform'] = 'Varmennetunnistautuminen edellyttää IdP-tyyppiä ”Microsoft identity platform (v2.0)”.';
$string['error_empty_client_secret'] = 'Asiakassalaisuus ei voi olla tyhjä, kun käytetään "salaisuus"-tunnistautumistapaa';
$string['error_empty_client_private_key'] = 'Asiakasvarmenteen yksityinen avain ei voi olla tyhjä, kun käytetään "varmenne"-tunnistautumistapaa';
$string['error_empty_client_cert'] = 'Asiakasvarmenteen julkinen avain ei voi olla tyhjä, kun käytetään "varmenne"-tunnistautumistapaa';
$string['error_empty_client_private_key_file'] = 'Asiakasvarmenteen yksityisen avaimen tiedosto ei voi olla tyhjä, kun käytetään "varmenne"-tunnistautumistapaa';
$string['error_empty_client_cert_file'] = 'Asiakasvarmenteen julkisen avaimen tiedosto ei voi olla tyhjä, kun käytetään "varmenne"-tunnistautumistapaa';
$string['error_endpoint_mismatch_auth_endpoint'] = 'Määritetty valtuutuksen päätepiste ei vastaa määritettyä IdP-tyyppiä. Käytä tyypille "Microsoft Entra ID (v1.0)" v1.0-päätepistettä (esim. https://login.microsoftonline.com/organizations/oauth2/authorize). Käytä tyypille "Microsoft identity platform (v2.0)" v2.0-päätepistettä (esim. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize).';
$string['error_endpoint_mismatch_token_endpoint'] = 'Määritetty tunnuspäätepiste ei vastaa määritettyä IdP-tyyppiä. Käytä tyypille "Microsoft Entra ID (v1.0)" v1.0-päätepistettä (esim. https://login.microsoftonline.com/organizations/oauth2/token). Käytä tyypille "Microsoft identity platform (v2.0)" v2.0-päätepistettä (esim. https://login.microsoftonline.com/organizations/oauth2/v2.0/token).';
$string['error_tenant_specific_endpoint_required'] = 'Kun käytetään IdP-tyyppiä "Microsoft identity platform (v2.0)" ja tunnistautumistapaa "Varmenne", vuokraajakohtainen päätepiste (eli ei common/organizations/consumers) on pakollinen.';
$string['error_empty_oidcresource'] = 'Resurssi ei voi olla tyhjä, kun käytetään Microsoft Entra ID (v1.0) -tyyppistä tai muun tyyppistä IdP:tä.';
$string['error_invalid_custom_claim'] = 'Virheelliset mukautettujen väitteiden nimet: {$a}. Mukautettujen väitteiden nimet voivat sisältää vain kirjaimia, numeroita, yhdysmerkkejä ja alaviivoja, eivätkä ne voi olla varattuja väitteiden nimiä (esim. JWT:n/OpenID Connectin vakioväite tai Microsoft Entra ID:lle tai Keycloakille ominainen väite) tai olemassa oleva kenttävastaavuuden vaihtoehto.';
$string['error_masked_secret_not_changed'] = 'Anna uusi arvo tai poista valinta "Vaihda"-valintaruudusta säilyttääksesi nykyisen arvon.';
$string['auth_settings_validation_error'] = 'Tunnistautumisasetuksissa havaittiin virheitä. Seuraavat määritysongelmat on korjattava, jotta tunnistautuminen onnistuu:';
$string['error_secretexpiryrecipients_invalid'] = 'Seuraavat salaisuuden vanhenemisilmoitusten vastaanottajat eivät ole kelvollisia sähköpostiosoitteita: {$a}';
$string['errorupnchangeisnotsupported'] = 'Microsoft-tilisi UPN on muuttunut. Ota yhteyttä ylläpitäjään Moodle-tilisi päivittämiseksi.';
$string['erroruserwithusernamealreadyexists'] = 'Moodle-tilisi nimeämisessä uudelleen tapahtui virhe. Moodle-käyttäjä, jolla on uusi käyttäjätunnus, on jo olemassa. Pyydä sivuston ylläpitäjää ratkaisemaan tämä ensin.';
$string['error_no_response_available'] = 'Vastauksia ei ole saatavilla.';

$string['eventuserauthed'] = 'Käyttäjä valtuutettiin OpenID Connectin avulla';
$string['eventusercreated'] = 'Käyttäjä luotiin OpenID Connectin avulla';
$string['eventuserconnected'] = 'Käyttäjä yhdistettiin OpenID Connectiin';
$string['eventuserloggedin'] = 'Käyttäjä kirjautui OpenID Connectin avulla';
$string['eventuserdisconnected'] = 'Käyttäjän OpenID Connect -yhteys katkaistiin';
$string['eventuserrenameattempt'] = 'auth_oidc-lisäosa yritti nimetä käyttäjän uudelleen';

$string['oidc:manageconnection'] = 'Salli OpenID Connect -yhteyden muodostaminen ja katkaiseminen';
$string['oidc:manageconnectionconnect'] = 'Salli OpenID Connect -yhteyden muodostaminen';
$string['oidc:manageconnectiondisconnect'] = 'Salli OpenID Connect -yhteyden katkaiseminen';

$string['privacy:metadata:auth_oidc'] = 'OpenID Connect -tunnistautuminen';
$string['privacy:metadata:auth_oidc_prevlogin'] = 'Aiemmat kirjautumismenetelmät Microsoft 365 -yhteyksien kumoamista varten';
$string['privacy:metadata:auth_oidc_prevlogin:userid'] = 'Moodle-käyttäjän tunnus (ID)';
$string['privacy:metadata:auth_oidc_prevlogin:method'] = 'Aiempi kirjautumismenetelmä';
$string['privacy:metadata:auth_oidc_prevlogin:password'] = 'Käyttäjän aiempi (salattu) salasanakenttä.';
$string['privacy:metadata:auth_oidc_token'] = 'OpenID Connect -tunnukset';
$string['privacy:metadata:auth_oidc_token:oidcuniqid'] = 'OIDC-käyttäjän yksilöllinen tunniste.';
$string['privacy:metadata:auth_oidc_token:username'] = 'Moodle-käyttäjän käyttäjätunnus';
$string['privacy:metadata:auth_oidc_token:userid'] = 'Moodle-käyttäjän tunnus (ID)';
$string['privacy:metadata:auth_oidc_token:oidcusername'] = 'OIDC-käyttäjän käyttäjätunnus';
$string['privacy:metadata:auth_oidc_token:useridentifier'] = 'OIDC-käyttäjän käyttäjätunniste';
$string['privacy:metadata:auth_oidc_token:scope'] = 'Tunnuksen käyttöalue (scope)';
$string['privacy:metadata:auth_oidc_token:tokenresource'] = 'Tunnuksen resurssi';
$string['privacy:metadata:auth_oidc_token:authcode'] = 'Tunnuksen valtuutuskoodi';
$string['privacy:metadata:auth_oidc_token:token'] = 'Tunnus';
$string['privacy:metadata:auth_oidc_token:expiry'] = 'Tunnuksen vanhenemisaika';
$string['privacy:metadata:auth_oidc_token:refreshtoken'] = 'Päivitystunnus';
$string['privacy:metadata:auth_oidc_token:idtoken'] = 'ID-tunnus';
$string['privacy:metadata:auth_oidc_sid'] = 'IdP:n istuntotunnisteet (sid), joiden avulla löydetään yhdistetyt Moodle-käyttäjät, kun kertauloskirjautuminen (SLO) käynnistetään IdP:stä';
$string['privacy:metadata:auth_oidc_sid:userid'] = 'Moodle-käyttäjän tunnus (ID)';
$string['privacy:metadata:auth_oidc_sid:sid'] = 'IdP:n istuntotunniste (sid)';
$string['privacy:metadata:auth_oidc_sid:timecreated'] = 'Vastaavuuden luontiaika';
$string['privacy:metadata:auth_oidc_sid:sessionid'] = 'Vastaavuuden luontihetkellä aktiivinen Moodlen istuntotunniste';
$string['privacy:metadata:auth_oidc_sid:iss'] = 'Sen id_tokenin myöntäjä (iss-väite), josta vastaavuus luotiin';

// In the following strings, $a refers to a customizable name for the identity manager. For example, this could be
// "Microsoft 365", "OpenID Connect", etc.
$string['ucp_general_intro'] = 'Tässä kohdassa voit hallita {$a} -yhteyttä. Jos asetus on käytössä, voit kirjautua Moodleen käyttämällä {$a} -tiliäsi erillisen käyttäjätunnuksen ja salasanan sijaan. Kun yhteys on luotu, sinun ei tarvitse muistaa Moodle-käyttäjätunnusta ja -salasanaa, koska {$a} huolehtii kirjautumisesta.';
$string['ucp_login_start'] = 'Aloita palvelun {$a} käyttö Moodle-kirjautumiseen';
$string['ucp_login_start_desc'] = 'Voit käyttää {$a} -tiliäsi Moodle-kirjautumiseen. Kun asetus on käytössä, kirjaudut Moodleen käyttämällä {$a} -tunnistetietojasi. Nykyinen Moodle-käyttäjätunnus ja -salasana eivät enää toimi. Voit katkaista tilisi yhteyden milloin tahansa ja palata käyttämään normaalia kirjautumista.';
$string['ucp_login_stop'] = 'Lopeta palvelun {$a} käyttö Moodle-kirjautumiseen';
$string['ucp_login_stop_desc'] = '{$a} on tällä hetkellä käytössä Moodle-kirjautumiseen. Jos valitset "Lopeta palvelun {$a} käyttö Moodle-kirjautumiseen", Moodle-tilisi yhteys palveluun {$a} katkaistaan. Tämän jälkeen et voi kirjautua Moodleen käyttämällä {$a} -tiliäsi. Sinua pyydetään luomaan käyttäjätunnus ja salasana, joiden avulla voit jatkossa kirjautua suoraan Moodleen.';
$string['ucp_login_status'] = '{$a} -kirjautuminen:';
$string['ucp_status_enabled'] = 'Käytössä';
$string['ucp_status_disabled'] = 'Ei käytössä';
$string['ucp_disconnect_title'] = '{$a} -yhteyden katkaisu';
$string['ucp_disconnect_details'] = 'Tämä katkaisee Moodle-tilin yhteyden kohteesta {$a}. Tarvitset käyttäjätunnuksen ja salasanan, jotta voit kirjautua Moodleen.';
$string['ucp_title'] = '{$a} -hallinta';
$string['ucp_o365accountconnected'] = 'Tämä Microsoft 365 -tili on jo yhdistetty toiseen Moodle-tiliin.';

// Clean up OIDC tokens.
$string['cleanup_oidc_tokens'] = 'Siivoa OpenID Connect -tunnukset';
$string['unmatched'] = 'Ei vastaavuutta';
$string['delete_token'] = 'Poista tunnus';
$string['mismatched'] = 'Ristiriitainen';
$string['na'] = '–';
$string['mismatched_details'] = 'Tunnustietueessa on käyttäjätunnus "{$a->tokenusername}"; vastaavan Moodle-käyttäjän käyttäjätunnus on "{$a->moodleusername}".';
$string['delete_token_and_reference'] = 'Poista tunnus ja viittaus';
$string['table_token_id'] = 'Tunnustietueen ID';
$string['table_oidc_username'] = 'OIDC-käyttäjätunnus';
$string['table_oidc_unique_identifier'] = 'OIDC:n yksilöllinen tunniste';
$string['table_token_unique_id'] = 'OIDC:n yksilöllinen ID';
$string['table_matching_status'] = 'Vastaavuuden tila';
$string['table_matching_details'] = 'Tiedot';
$string['table_action'] = 'Toiminto';
$string['token_deleted'] = 'Tunnus poistettiin onnistuneesti';
$string['no_token_to_cleanup'] = 'Siivottavia OIDC-tunnuksia ei ole.';

$string['errorusermatched'] = 'Microsoft 365 -tili "{$a->entraidupn}" on jo yhdistetty Moodle-käyttäjään "{$a->username}". Viimeistele yhteys kirjautumalla ensin sisään kyseisenä Moodle-käyttäjänä ja noudattamalla Microsoft-lohkon ohjeita.';

// User mapping options.
$string['update_oncreate_and_onlogin'] = 'Luotaessa ja jokaisella kirjautumiskerralla';
$string['update_oncreate_and_onlogin_and_usersync'] = 'Luotaessa, jokaisella kirjautumiskerralla ja jokaisella käyttäjien synkronointitehtävän ajokerralla';
$string['update_oncreate_and_usersync'] = 'Luotaessa ja jokaisella käyttäjien synkronointitehtävän ajokerralla';
$string['update_onlogin_and_usersync'] = 'Jokaisella kirjautumiskerralla ja jokaisella käyttäjien synkronointitehtävän ajokerralla';
$string['upgradeoidcuniqidtoolong'] = 'Päivitystä ei voi jatkaa: joissakin auth_oidc_token-tietueissa oidcuniqid on yli 200 merkkiä pitkä, jolloin uusi sarakepituus katkaisisi sen. Poista kyseiset tunnustietueet ja suorita päivitys uudelleen.';

// Remote fields.
$string['settings_fieldmap_feild_not_mapped'] = '(ei vastaavuutta)';
$string['settings_fieldmap_field_bindingusernameclaim'] = 'Sidonnan käyttäjätunnusväite (voidaan määrittää vain kirjautumisen yhteydessä)';
$string['settings_fieldmap_field_city'] = 'Paikkakunta';
$string['settings_fieldmap_field_companyName'] = 'Yrityksen nimi';
$string['settings_fieldmap_field_objectId'] = 'Objektitunnus';
$string['settings_fieldmap_field_country'] = 'Maa';
$string['settings_fieldmap_field_department'] = 'Osasto';
$string['settings_fieldmap_field_displayName'] = 'Näyttönimi';
$string['settings_fieldmap_field_surname'] = 'Sukunimi';
$string['settings_fieldmap_field_faxNumber'] = 'Faksinumero';
$string['settings_fieldmap_field_telephoneNumber'] = 'Puhelinnumero';
$string['settings_fieldmap_field_givenName'] = 'Etunimi';
$string['settings_fieldmap_field_jobTitle'] = 'Tehtävänimike';
$string['settings_fieldmap_field_mail'] = 'Sähköposti';
$string['settings_fieldmap_field_mobile'] = 'Matkapuhelin';
$string['settings_fieldmap_field_postalCode'] = 'Postinumero';
$string['settings_fieldmap_field_preferredLanguage'] = 'Kieli';
$string['settings_fieldmap_field_state'] = 'Osavaltio/alue';
$string['settings_fieldmap_field_streetAddress'] = 'Katuosoite';
$string['settings_fieldmap_field_userPrincipalName'] = 'Käyttäjän päätunnus (UPN)';
$string['settings_fieldmap_field_employeeId'] = 'Työntekijätunnus';
$string['settings_fieldmap_field_employeeType'] = 'Työntekijätyyppi';
$string['settings_fieldmap_field_accountEnabled'] = 'Tili käytössä';
$string['settings_fieldmap_field_businessPhones'] = 'Työpuhelin';
$string['settings_fieldmap_field_mobilePhone'] = 'Matkapuhelin';
$string['settings_fieldmap_field_officeLocation'] = 'Toimipiste';
$string['settings_fieldmap_field_preferredName'] = 'Ensisijainen nimi';
$string['settings_fieldmap_field_manager'] = 'Esihenkilön nimi';
$string['settings_fieldmap_field_manager_email'] = 'Esihenkilön sähköposti';
$string['settings_fieldmap_field_teams'] = 'Teams';
$string['settings_fieldmap_field_groups'] = 'Ryhmät';
$string['settings_fieldmap_field_roles'] = 'Roolit';
$string['settings_fieldmap_field_tokenclaim'] = '{$a} (tunnuksen väite)';
$string['settings_fieldmap_field_onPremisesSamAccountName'] = 'Paikallinen SAM-tilinimi';
$string['settings_fieldmap_field_extensionattribute'] = 'Laajennusmäärite {$a}';
$string['settings_fieldmap_field_sds_school_id'] = 'SDS-koulun tunnus ({$a})';
$string['settings_fieldmap_field_sds_school_name'] = 'SDS-koulun nimi ({$a})';
$string['settings_fieldmap_field_sds_school_role'] = 'SDS-koulurooli ("Student" tai "Teacher")';
$string['settings_fieldmap_field_sds_student_externalId'] = 'SDS-opiskelijan ulkoinen tunnus';
$string['settings_fieldmap_field_sds_student_birthDate'] = 'SDS-opiskelijan syntymäaika';
$string['settings_fieldmap_field_sds_student_grade'] = 'SDS-opiskelijan luokka-aste';
$string['settings_fieldmap_field_sds_student_graduationYear'] = 'SDS-opiskelijan valmistumisvuosi';
$string['settings_fieldmap_field_sds_student_studentNumber'] = 'SDS-opiskelijanumero';
$string['settings_fieldmap_field_sds_teacher_externalId'] = 'SDS-opettajan ulkoinen tunnus';
$string['settings_fieldmap_field_sds_teacher_teacherNumber'] = 'SDS-opettajanumero';

// Binding username claim options.
$string['binding_username_claim_warning'] = 'Tämä on edistynyt toiminto. Useimmissa tapauksissa asetuksen tulee olla "Valitse automaattisesti"; virheellinen määritys voi vaikuttaa käyttäjätietueisiin ja häiritä kertakirjautumista (SSO).';
$string['binding_username_auto'] = 'Valitse automaattisesti';
$string['binding_username_custom'] = 'Mukautettu';
$string['bindingusernameclaim'] = 'Sidonnan käyttäjätunnusväite';
$string['customclaimname'] = 'Mukautetun väitteen nimi';
$string['customclaimname_description'] = 'Tätä kenttää käytetään vain, kun <b>sidonnan käyttäjätunnusväite</b> -asetuksen arvo on <b>Mukautettu</b>.';
$string['binding_username_claim_tool_link_desc'] = 'Voit päivittää olemassa olevien käyttäjien sidonnan käyttäjätunnusväitteen <a href="{$a}">sidonnan käyttäjätunnusväitteen muutostyökalulla</a>.';
$string['cleanup_oidc_tokens_link_desc'] = 'Voit siivota vanhentuneet OpenID Connect -tunnukset <a href="{$a}">Siivoa OpenID Connect -tunnukset</a> -työkalulla.';
$string['clear_user_tokens_link_desc'] = 'Voit poistaa kaikkien käyttäjien tai valittujen käyttäjien tallennetut tunnukset <a href="{$a}">Tyhjennä käyttäjän tunnukset</a> -työkalulla.';
$string['clear_user_tokens'] = 'Tyhjennä käyttäjän tunnukset';
$string['clear_user_tokens_desc'] = 'Poistaa käyttäjille tallennetut OpenID Connect- ja Microsoft 365 -tunnukset. Käyttäjät saavat uudet tunnukset, kun he seuraavan kerran kirjautuvat OpenID Connectin avulla tai muodostavat yhteyden Microsoft 365:een. Heidän linkkinsä Microsoft 365 -tileihin säilytetään. VAROITUS: Tämä voi keskeyttää käynnissä olevat kirjautumiset, joten se kannattaa tehdä huoltokatkon aikana.';
$string['clear_user_tokens_scope_selected'] = 'Valitut käyttäjät';
$string['clear_user_tokens_scope_all'] = 'Kaikki käyttäjät';
$string['clear_user_tokens_users'] = 'Käyttäjät';
$string['clear_user_tokens_submit'] = 'Tyhjennä tunnukset';
$string['clear_user_tokens_no_name'] = '(ei nimeä)';
$string['clear_user_tokens_no_user_selected'] = 'Valitse vähintään yksi käyttäjä.';
$string['clear_user_tokens_confirm_all'] = 'Haluatko varmasti tyhjentää kaikkien käyttäjien tunnukset? Tällä hetkellä tunnuksia on {$a} käyttäjällä.';
$string['clear_user_tokens_confirm_selected'] = 'Haluatko varmasti tyhjentää valittujen käyttäjien tunnukset? Valituista käyttäjistä {$a} käyttäjällä on tällä hetkellä tunnuksia.';
$string['clear_user_tokens_success'] = 'Tyhjennettiin {$a} tunnustietuetta.';
$string['binding_username_claim_help_ms_no_user_sync'] = 'Microsoftin IdP:n vaihtoehdot, kun käyttäjien synkronointi ei ole käytössä:
<ul>
<li><b>Valitse automaattisesti</b>: Käyttää nykyistä logiikkaa, jossa tunnus määräytyy IdP-tyypin mukaan, ja palaa käyttämään väitettä <b>sub</b>, jos väitettä ei löydy.</li>
<li><b>preferred_username</b>: Oletus Microsoft identity platform (v2.0) -IdP-tyypille. <span class="not_support_user_sync">Ei tue käyttäjien synkronointia.</span></li>
<li><b>email</b>: Varavaihtoehto Microsoft identity platformille (v2.0).</li>
<li><b>upn</b>: Oletus Microsoft Entra ID (v1.0) -tyypille ja muille IdP-tyypeille.</li>
<li><b>unique_name</b>: Varavaihtoehto Microsoft Entra ID (v1.0) -tyypille ja muille IdP-tyypeille. <span class="not_support_user_sync">Ei tue käyttäjien synkronointia.</span></li>
<li><b>oid</b>: Varavaihtoehto, jos muita väitteitä ei ole. Esiintyy vain Microsoftin IdP:ssä.</li>
<li><b>sub</b>: Varavaihtoehto, jos muita väitteitä ei ole. <span class="not_support_user_sync">Ei tue käyttäjien synkronointia.</span></li>
<li><b>samaccountname</b>: Mukautettu väite.</li>
<li><b>Mukautettu</b>: Sivuston ylläpitäjä voi antaa mukautetun arvon. <span class="not_support_user_sync">Ei tue käyttäjien synkronointia.</span></li>
</ul>
Huomaa, että jotkin vaihtoehdot eivät tue käyttäjien synkronointia.';
$string['binding_username_claim_help_ms_with_user_sync'] = 'Microsoftin IdP:n vaihtoehdot, kun käyttäjien synkronointi on käytössä:
<ul>
<li><b>Valitse automaattisesti</b>: Käyttää nykyistä logiikkaa, jossa tunnus määräytyy IdP-tyypin mukaan, ja palaa käyttämään väitettä <b>sub</b>, jos väitettä ei löydy.</li>
<li><b>email</b>: Varavaihtoehto Microsoft identity platformille (v2.0).</li>
<li><b>upn</b>: Oletus Microsoft Entra ID (v1.0) -tyypille ja muille IdP-tyypeille.</li>
<li><b>oid</b>: Varavaihtoehto, jos muita väitteitä ei ole. Esiintyy vain Microsoftin IdP:ssä.</li>
<li><b>samaccountname</b>: Mukautettu väite.</li>
</ul>';
$string['binding_username_claim_help_non_ms'] = 'Muiden kuin Microsoftin IdP:iden vaihtoehdot:
<ul>
<li><b>Valitse automaattisesti</b>: Käyttää nykyistä logiikkaa, jossa tunnus määräytyy IdP-tyypin mukaan, ja palaa käyttämään väitettä <b>sub</b>, jos väitettä ei löydy.</li>
<li><b>preferred_username</b></li>
<li><b>email</b></li>
<li><b>unique_name</b></li>
<li><b>sub</b></li>
<li><b>samaccountname</b></li>
<li><b>custom</b>: Mukautettu väite.</li>
</ul>';
$string['warning_binding_username_claim_custom_unsupported'] = '"Sidonnan käyttäjätunnusväite" -asetuksen arvo on tällä hetkellä "Mukautettu", jota ei tueta määritetyllä IdP-tyypillä, kun käyttäjien synkronointi on käytössä. Tarkista <a href="{$a}">sidonnan käyttäjätunnusväitteen</a> asetukset.';
$string['examplecsv'] = 'Esimerkki ladattavasta tiedostosta';
$string['usernamefile'] = 'Tiedosto';
$string['csvdelimiter'] = 'CSV-erotin';
$string['encoding'] = 'Merkistökoodaus';
$string['rowpreviewnum'] = 'Esikatseltavat rivit';
$string['upload_usernames'] = 'Päivitä sidonnan käyttäjätunnukset';
$string['update_stats_users_updated'] = '{$a} käyttäjää päivitettiin';
$string['update_stats_users_errors'] = '{$a} käyttäjän kohdalla ilmeni virheitä';
$string['update_error_incomplete_line'] = 'Rivillä ei ole pakollisia kenttiä.';
$string['update_error_user_not_found'] = 'Käyttäjätunnusta vastaavaa käyttäjää ei löytynyt. Yritetään päivittää manuaalisesti yhdistetty käyttäjä.';
$string['update_error_user_not_oidc'] = 'Käyttäjä ei käytä OpenID Connect -tunnistautumistapaa. Yritetään päivittää manuaalisesti yhdistetty käyttäjä.';
$string['update_error_invalid_new_username'] = 'Uusi käyttäjätunnus on virheellinen.';
$string['update_error_user_update_failed'] = 'Käyttäjän päivittäminen epäonnistui.';
$string['update_warning_email_match'] = 'Sähköpostiosoite vastaa olemassa olevaa käyttäjää.';
$string['update_success_username'] = 'Käyttäjätunnus päivitettiin onnistuneesti.';
$string['update_success_token'] = 'Tunnus päivitettiin onnistuneesti.';
$string['update_success_o365'] = 'Microsoft 365 -yhteystietue päivitettiin onnistuneesti.';
$string['update_error_nothing_updated'] = 'Mitään ei päivitetty.';
$string['error_invalid_upload_file'] = 'Virheellinen ladattu tiedosto.';
$string['csvline'] = 'CSV-rivi';
$string['change_binding_username_claim_tool_description'] = '<p class="warning_header">Tämä on edistynyt toiminto. Virheellinen käyttö voi vaikuttaa käyttäjätietueisiin ja häiritä kertakirjautumista (SSO).</p>
<p>Tällä työkalulla sivuston ylläpitäjät voivat joukkopäivittää seuraavat tietueet:</p>
<ul>
<li>Moodle-tilien käyttäjätunnukset,</li>
<li>tallennettujen OpenID Connect -ID-tunnusten sidonnan käyttäjätunnukset,</li>
<li>Moodle- ja Microsoft-tilien yhteystietueet.</li>
</ul>
<p>Työkalua tulee käyttää vain, kun <b>sidonnan käyttäjätunnusväite</b> -asetuksia muutetaan.</p>
<p>Työkalu hyväksyy yksinkertaisen CSV-tiedoston, jossa on kaksi saraketta:</p>
<ul>
<li><b><span class="auth_oidc_code">username</span></b>: Päivitettävän Moodle-tilin nykyinen käyttäjätunnus, tai jos nykyinen käyttäjä on yhdistetty manuaalisesti, nykyinen sidontaväitteen arvo.</li>
<li><b><span class="auth_oidc_code">new_username</span></b>: Sidonnan käyttäjätunnusväitteenä käytettävän uuden tunnusväitteen arvo (kirjainkoolla on merkitystä). Jos käyttäjä on yhdistetty automaattisesti ja käyttää OpenID Connect -tunnistautumistyyppiä, tämän arvon pienaakkosmuotoa käytetään Moodlen käyttäjätunnuksena.</li>
</ul>
<p>Kun tiedosto on ladattu, työkalu suorittaa seuraavat toiminnot:</p>
<ol>
<li>Etsii olemassa olevan Moodle-käyttäjän, jonka käyttäjätunnus tai sähköpostiosoite on annettu <span class="auth_oidc_code">username</span> ja joka käyttää OpenID Connect -tunnistautumistapaa, ja jos sellainen löytyy, päivittää käyttäjän käyttäjätunnukseksi arvon <span class="auth_oidc_code">new_username</span> pienaakkosin.</li>
<li>Päivittää OpenID Connect -tunnustietueen.
<ul>
<li>Jos käyttäjä löytyi yllä olevassa vaiheessa 1, etsii käyttäjän tunnustietueen taulusta <span class="auth_oidc_code">auth_oidc_token</span> ja päivittää sarakkeen <span class="auth_oidc_code">username</span> arvoksi <span class="auth_oidc_code">new_username</span> pienaakkosin ja sarakkeen <span class="auth_oidc_code">oidcusername</span> arvoksi <span class="auth_oidc_code">new_username</span> sellaisenaan.</li>
<li>Jos tietuetta ei löytynyt yllä, yrittää etsiä taulusta <span class="auth_oidc_code">auth_oidc_token</span> tietueen, jonka sarake <span class="auth_oidc_code">oidcusername</span> vastaa vanhaa arvoa <span class="auth_oidc_code">username</span>, ja päivittää sen arvoksi <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
<li>Jos <span class="auth_oidc_code">local_o365</span>-lisäosa on asennettu, päivittää käyttäjän yhteystietueen.
<ul>
<li>Jos käyttäjä löytyi yllä olevassa vaiheessa 1, etsii käyttäjän yhteystietueen taulusta <span class="auth_oidc_code">local_o365_objects</span> ja päivittää sarakkeen <span class="auth_oidc_code">o365name</span> arvoksi <span class="auth_oidc_code">new_username</span>.</li>
<li>Jos käyttäjää ei löytynyt vaiheessa 1, yrittää etsiä taulusta <span class="auth_oidc_code">local_o365_objects</span> käyttäjän tietueen, jonka <span class="auth_oidc_code">o365name</span> vastaa arvoa <span class="auth_oidc_code">username</span>, ja päivittää sen arvoksi <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
</ol>
<p>Alla oleva esimerkkitiedosto muuttaisi sidonnan käyttäjätunnusväitteen arvosta <span class="auth_oidc_code">upn</span> tai <span class="auth_oidc_code">email</span> arvoon <span class="auth_oidc_code">oid</span>.</p>';
$string['change_binding_username_claim_tool_result'] = 'Päivityksen tulokset';
$string['update_username_results'] = 'Käyttäjätunnusten päivityksen tulokset';
$string['new_username'] = 'Uusi käyttäjätunnus';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
