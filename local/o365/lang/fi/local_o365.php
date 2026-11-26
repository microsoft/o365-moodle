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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft 365 -integrointi';

// Settings - tabs.
$string['settings_pageheading'] = '{$a}: määritykset';
$string['settings_header_setup'] = 'Määritys';
$string['settings_header_usersync'] = 'Käyttäjien synkronointi';
$string['settings_header_coursesync'] = 'Kurssien synkronointi';
$string['settings_header_advanced'] = 'Lisäasetukset';
$string['settings_header_sds'] = 'SDS-synkronointi';
$string['settings_header_teams'] = 'Teams-asetukset';
$string['settings_header_moodle_app'] = 'Teams Moodle -sovellus';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'Vaihe 1/2: Rekisteröi Moodle Microsoft Entra ID:ssä';
$string['settings_setup_step1_desc'] = 'Rekisteröi uusi Microsoft Entra ID -sovellus Moodle-integraatiota varten PowerShellin avulla:

<a href="{$a}/local/o365/scripts/Moodle-EntraID-PowerShell.zip" class="btn btn-primary" target="_blank">Lataa PowerShell-komentosarja</a>

<p style="margin-top:10px"><a href="{$a}/local/o365/scripts/README.md" target="_blank">Napsauta tästä</a> lukeaksesi ohjeet komentosarjan suorittamiseen.</p>
<p>Kun sinua pyydetään, käytä seuraavaa linkkiä Moodlen URL-osoitteena:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />Kun komentosarja on suoritettu onnistuneesti, kopioi sen palauttamat sovellustunnus (Application ID) ja salaisuus (Secret) <a href="{$a}">OpenID Connect -todennuslisäosan asetussivulle</a>.';
$string['settings_setup_step1_credentials_end'] = 'Jos et pysty määrittämään Microsoft Entra ID -sovellusta PowerShellin avulla, <a href="{$a}" target="_blank">napsauta tästä</a> saadaksesi ohjeet manuaaliseen määritykseen.';
$string['settings_setup_step1_continue'] = '<b>Kun olet antanut sovellustunnuksen ja salaisuuden, jatka valitsemalla sivun alareunasta "Tallenna muutokset".</b><br /><br /><br /><br /><br />';
$string['features_disabled_external_id'] = 'Microsoft 365 -toiminnot eivät ole käytettävissä, kun OpenID Connect -todennusliitännäisen identiteetintarjoajan (IdP) tyypiksi on asetettu Microsoft Entra External ID. Microsoft Entra External ID -vuokraajat ovat asiakasvuokraajia, joissa ei ole Microsoft 365 -palveluja (Exchange Online, Microsoft Teams, SharePoint/OneDrive tai School Data Sync), joten kaikki tämän liitännäisen toiminnot on poistettu käytöstä.';
$string['task_skipped_external_id'] = 'Tehtävä ohitettiin: tämän liitännäisen Microsoft 365 -toiminnot on poistettu käytöstä, koska OpenID Connect -todennusliitännäisen IdP-tyyppi on Microsoft Entra External ID.';
$string['settings_setup_step1_existing_settings'] = '<h5>Nykyiset asetukset</h5>';
$string['settings_setup_step2'] = 'Vaihe 2/2: Järjestelmänvalvojan suostumus ja lisätiedot';
$string['settings_setup_step2_desc'] = 'Tässä viimeisessä vaiheessa voit antaa järjestelmänvalvojan suostumuksen tiettyjen Microsoft Entra ID -käyttöoikeuksien käyttöön, ja lisäksi kerätään tietoja Microsoft 365 -ympäristöstäsi.<br /><br />';
$string['settings_setup_step3'] = 'Tarkista määritykset';
$string['settings_setup_step3_desc'] = 'Määritys on valmis. Tarkista määritykset valitsemalla alla oleva "Päivitä"-painike.';

// Settings in "Step 2/2" section of the "Setup" tab.
$string['settings_adminconsent'] = 'Järjestelmänvalvojan suostumus';
$string['settings_adminconsent_btn'] = 'Anna järjestelmänvalvojan suostumus';
$string['settings_adminconsent_details'] = 'Joidenkin tarvittavien käyttöoikeuksien käyttö edellyttää järjestelmänvalvojan suostumusta. Valitse tämä painike ja kirjaudu sisään Microsoft Entra ID -järjestelmänvalvojan tilillä antaaksesi suostumuksen. Tämä on tehtävä aina, kun muutat Entra ID:ssä "Admin"-käyttöoikeuksia.';
$string['settings_entratenant'] = 'Microsoft Entra -vuokraaja';
$string['settings_entratenant_details'] = 'Käytetään organisaatiosi tunnistamiseen Microsoftissa. Esimerkiksi: "contoso.onmicrosoft.com".<br/>
Arvon löytäminen manuaalisesti:
<ul>
<li>Siirry <a href="https://portal.azure.com" target="_blank">Azure Portaliin</a>.</li>
<li>Kirjaudu sisään järjestelmänvalvojan tililläsi.</li>
<li>Kirjoita hakukenttään "Microsoft Entra ID" ja siirry "Microsoft Entra ID" -sivulle.</li>
<li>Käytä "Basic information" -osion <b>Primary domain</b> -kentän arvoa.</li>
</ul>';
$string['settings_odburl'] = 'OneDrive for Businessin URL-osoite';
$string['settings_odburl_details'] = 'URL-osoite, jota käytetään OneDrive for Businessin käyttämiseen. Osoite voidaan yleensä päätellä Microsoft Entra -vuokraajan perusteella. Jos Microsoft Entra -vuokraajasi on esimerkiksi "contoso.onmicrosoft.com", osoite on todennäköisesti "contoso-my.sharepoint.com". Anna vain toimialuenimi ilman etuliitettä http:// tai https://';
$string['settings_odburl_error_graph'] = 'OneDrive for Businessin URL-osoitetta ei voitu selvittää, anna se manuaalisesti. Osoitteen voi yleensä päätellä URL-osoitteesta, jolla käytät OneDrivea.';
$string['settings_serviceresourceabstract_detect'] = 'Tunnista';
$string['settings_serviceresourceabstract_detecting'] = 'Tunnistetaan...';
$string['settings_serviceresourceabstract_error'] = 'Asetuksen tunnistamisessa tapahtui virhe. Määritä se manuaalisesti.';
$string['settings_serviceresourceabstract_valid'] = '{$a} on käytettävissä.';
$string['settings_serviceresourceabstract_invalid'] = 'Tämä arvo ei näytä olevan käytettävissä.';
$string['settings_serviceresourceabstract_nocreds'] = 'Määritä ensin sovelluksen tunnistetiedot.';
$string['settings_serviceresourceabstract_empty'] = 'Anna arvo tai yritä tunnistaa oikea arvo valitsemalla "Tunnista".';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_verifysetup'] = 'Tarkista määritykset';
$string['settings_verifysetup_appdataheader'] = 'Microsoft Entra ID -sovelluksen rekisteröinti';
$string['settings_verifysetup_appdatadesc'] = 'Tarkistaa, että Entra ID -sovelluksessa on määritetty oikeat parametrit.';
$string['settings_verifysetup_appdatareplyurlcorrect'] = 'Vastauksen URL-osoite on oikein';
$string['settings_verifysetup_appdatareplyurlincorrect'] = 'Vastauksen URL-osoite on virheellinen';
$string['settings_verifysetup_appdatareplyurlgeneralerror'] = 'Vastauksen URL-osoitetta ei voitu tarkistaa.';
$string['settings_verifysetup_appdatasignonurlcorrect'] = 'Kirjautumisen URL-osoite on oikein.';
$string['settings_verifysetup_appdatasignonurlincorrect'] = 'Kirjautumisen URL-osoite on virheellinen';
$string['settings_verifysetup_appdatasignonurlgeneralerror'] = 'Kirjautumisen URL-osoitetta ei voitu tarkistaa.';
$string['settings_verifysetup_apppermscorrect'] = 'Sovelluksen käyttöoikeudet ovat oikein.';
$string['settings_verifysetup_details'] = 'Tämä työkalu tarkistaa Microsoft Entra ID:stä, että kaikki on määritetty oikein. <br /><b>Huomautus:</b> Microsoft Entra ID -sovellukseen tehdyt muutokset voivat näkyä täällä pienellä viiveellä. Jos olet tehnyt muutoksen Microsoft Entra ID -sovellukseen etkä näe sitä täällä, odota hetki ja yritä uudelleen.';
$string['settings_verifysetup_correctval'] = 'Oikea arvo:';
$string['settings_verifysetup_detectedval'] = 'Tunnistettu arvo:';
$string['settings_verifysetup_update'] = 'Päivitä';
$string['settings_verifysetup_checking'] = 'Tarkistetaan...';
$string['settings_verifysetup_missingappperms'] = 'Puuttuvat sovelluksen käyttöoikeudet:';
$string['settings_verifysetup_notgranted'] = 'lisätty sovellukseen, mutta järjestelmänvalvojan suostumusta ei ole annettu';
$string['settings_verifysetup_missingperms'] = 'Puuttuvat delegoidut käyttöoikeudet:';
$string['settings_verifysetup_permscorrect'] = 'Delegoidut käyttöoikeudet ovat oikein.';
$string['settings_verifysetup_errorcheck'] = 'Määritysten tarkistamisen aikana tapahtui virhe.';
$string['settings_verifysetup_noinfo'] = 'Microsoft Entra ID -sovelluksesi määrityksistä ei ole vielä tietoja. Tarkista ne valitsemalla Päivitä-painike.';
$string['settings_verifysetup_strunifiedpermerror'] = 'Microsoft Graph API -käyttöoikeuksien tarkistamisessa tapahtui virhe.';
$string['settings_verifysetup_strtenanterror'] = 'Määritä Microsoft Entra -vuokraaja Tunnista-painikkeella ennen kuin päivität Microsoft Entra ID -sovelluksen määritykset.';
$string['settings_verifysetup_unifiedheader'] = 'Microsoft Graph API';
$string['settings_verifysetup_unifieddesc'] = 'Microsoft Graph API mahdollistaa tiedonvälityksen Moodlen ja Microsoft 365:n välillä.';
$string['settings_verifysetup_unifiederror'] = 'Microsoft Graph API -tuen tarkistamisessa tapahtui virhe.';
$string['settings_verifysetup_unifiedactive'] = 'Microsoft Graph API on aktiivinen.';
$string['settings_verifysetup_unifiedmissing'] = 'Tästä sovelluksesta ei löytynyt Microsoft Graph API:a.';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc_credsvalid'] = 'Tunnistetiedot on määritetty.';
$string['settings_detectoidc_credsvalid_link'] = 'Muuta';
$string['settings_detectoidc_credsinvalid'] = 'Tunnistetietoja ei ole määritetty tai ne ovat puutteelliset.';
$string['settings_detectoidc_credsinvalid_link'] = 'Määritä tunnistetiedot';
$string['settings_detectperms_nocreds'] = 'Määritä ensin sovelluksen tunnistetiedot. Katso lisätiedot edellisestä asetuksesta.';
$string['settings_detectperms_errorfix'] = 'Käyttöoikeuksien korjaamisen aikana tapahtui virhe. Korjaa oikeudet manuaalisesti Microsoft Entra ID:ssä.';
$string['settings_detectperms_fixperms'] = 'Korjaa käyttöoikeudet';
$string['settings_detectperms_update'] = 'Päivitä';
$string['settings_detectperms_valid'] = 'Käyttöoikeudet on määritetty.';
$string['settings_detectperms_invalid'] = 'Tarkista käyttöoikeudet Microsoft Entra ID:ssä';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_usersync_general'] = 'Yleinen käyttäjien synkronointi';
$string['settings_usersync_suspension'] = 'Moodle-tilien jäädyttäminen';
$string['settings_usersync_matching'] = 'Käyttäjien yhdistäminen';
$string['settings_usersync_photos'] = 'Synkronoi Microsoft 365 -profiilikuvat Moodleen';
$string['settings_usersync_timezone'] = 'Synkronoi Outlookin aikavyöhyke Moodleen';
$string['settings_usersync'] = 'Synkronoi käyttäjät Microsoft Entra ID:stä';
$string['settings_usersync_details'] = 'Kun asetus on käytössä, Moodle synkronoi käyttäjät Microsoft Entra ID:stä edellä olevien asetusten mukaisesti.<br /><br /><b>Huomautus: </b>Synkronointityö suoritetaan Moodlen cron-prosessissa, ja se synkronoi 1000 käyttäjää kerrallaan. Oletusarvoisesti työ suoritetaan kerran päivässä klo 1.00 palvelimen paikallisen aikavyöhykkeen mukaan. Jos haluat synkronoida suuria käyttäjäjoukkoja nopeammin, voit lisätä <b>Synkronoi käyttäjät Microsoft Entra ID:stä</b> -tehtävän suoritustiheyttä <a href="{$a}">ajastettujen tehtävien hallintasivulla.</a><br /><br />';
$string['settings_usersync_create'] = 'Luo Moodleen tilit Microsoft Entra ID:n käyttäjille';
$string['settings_usersync_update'] = 'Päivitä Moodlen tilit Microsoft Entra ID:n käyttäjille';
$string['settings_usersync_suspend'] = 'Jäädytä aiemmin synkronoidut tilit Moodlessa, kun ne poistetaan Microsoft Entra ID:stä';
$string['settings_usersync_delete'] = 'Poista aiemmin synkronoidut tilit Moodlesta, kun ne poistetaan Microsoft Entra ID:stä';
$string['settings_usersync_reenable'] = 'Ota jäädytetyt tilit uudelleen käyttöön Microsoft Entra ID:n käyttäjille';
$string['settings_usersync_disabledsyncsuspend'] = 'Jäädytä tilit Moodlessa, kun ne poistetaan käytöstä Microsoft Entra ID:ssä';
$string['settings_usersync_disabledsyncreenable'] = 'Ota tilit uudelleen käyttöön Moodlessa, kun ne otetaan uudelleen käyttöön Microsoft Entra ID:ssä';
$string['settings_usersync_suspendnolink'] = 'Jäädytä yhdistetyt tilit, joilla ei ole tallennettua Microsoft-linkitystä, kun ne poistetaan Microsoft Entra ID:stä tai poistetaan siellä käytöstä';
$string['settings_usersync_groupsyncsuspend'] = 'Jäädytä tilit Moodlessa, kun ne eivät kuulu määritettyyn käyttäjien synkronointiryhmään';
$string['settings_usersync_match'] = 'Yhdistä nykyiset Moodle-käyttäjät samannimisiin Microsoft Entra ID -tileihin';
$string['settings_usersync_matchswitchauth'] = 'Vaihda yhdistettyjen käyttäjien todennustavaksi Microsoft 365 (OpenID Connect)';
$string['settings_usersync_appassign'] = 'Liitä käyttäjät sovellukseen synkronoinnin aikana';
$string['settings_usersync_photosync'] = 'Synkronoi Microsoft 365 -profiilikuvat Moodleen cron-työssä';
$string['settings_usersync_photosynconlogin'] = 'Synkronoi Microsoft 365 -profiilikuvat Moodleen kirjautumisen yhteydessä';
$string['settings_usersync_nodelta'] = 'Suorita täydellinen synkronointi joka kerta';
$string['settings_usersync_emailsync'] = 'Yhdistä Microsoft Entra ID -käyttäjätunnukset synkronoinnissa Moodlen sähköpostiosoitteisiin Moodlen käyttäjätunnusten sijaan';
$string['settings_addsync_tzsync'] = 'Synkronoi Outlookin aikavyöhyke Moodleen cron-työssä';
$string['settings_addsync_tzsynconlogin'] = 'Synkronoi Outlookin aikavyöhyke Moodleen kirjautumisen yhteydessä';
$string['settings_usersync_guestsync'] = 'Synkronoi vieraskäyttäjät';
$string['settings_suspend_delete_running_time'] = 'Käyttäjien jäädytyksen/poiston suoritusaika';
$string['settings_suspend_delete_running_time_desc'] = 'Jos asetus on käytössä, käyttäjien synkronoinnin jäädytys-/poistotoiminto suoritetaan kerran päivässä määritettyyn aikaan Moodle-sivuston oletusaikavyöhykkeen mukaan.';
$string['settings_usersync_delete_delay'] = 'Viive ennen jäädytettyjen käyttäjien poistamista';
$string['settings_usersync_delete_delay_desc'] = 'Vähimmäisaika, jonka käyttäjän on oltava jäädytettynä Moodlessa ennen kuin käyttäjien synkronointi poistaa tilin. Tämä aika lisätään Microsoft Entra ID:n pehmeän poiston säilytysajan päälle, joten poisto ei koskaan tapahdu sitä aiemmin. Aseta arvoksi 0, jos haluat poistaa tilin heti Microsoft Entra ID:n säilytysajan päätyttyä. Käyttäjille, jotka oli jäädytetty jo ennen tämän asetuksen käyttöönottoa, aika lasketaan ensimmäisestä käyttäjien synkronoinnin suorituskerrasta, joka löytää heidät.';
$string['settings_support_user_identifier_change'] = 'Tue Microsoft-tilin sidonnan käyttäjätunnusväitteen arvon muutosta';
$string['settings_support_user_identifier_change_desc'] = 'Jos asetus on käytössä, Moodle yrittää reagoida, kun Moodle-tiliin yhdistetyn Microsoft-tilin sidonnan käyttäjätunnusväitteen arvo (yleensä UPN) muuttuu.<br/>
<table class="flexible table table-striped table-hover generaltable generalbox table-sm">
    <tr>
        <th>Tapauksen tunnus</th>
        <th>Onko vanhalla käyttäjätunnuksella oleva käyttäjä jo kirjautunut? (tunnus luotu)<br/>
        <span class="support_user_identifier_change_case_detail">Onko tunnus tallennettu auth_oidc_token-tauluun</span>
        </th>
        <th>Ensimmäinen toiminto UPN:n muuttamisen jälkeen<br/>
        <span class="support_user_identifier_change_case_detail">Joko kirjautuminen tai käyttäjien synkronointitehtävän suoritus</span>
        </th>
        <th>Mahdollinen päällekkäinen käyttäjätunnus<br/>
        <span class="support_user_identifier_change_case_detail">Aiheuttaisiko uudelleennimeäminen käyttäjätunnusristiriidan Moodlessa</span>
        </th>
        <th>Odotettu toiminta</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Kyllä</td>
        <td>Kirjautuminen</td>
        <td>Ei</td>
        <td>
            <ol>
                <li>Moodle-käyttäjä nimetään uudelleen.</li>
                <li>auth_oidc_token päivitetään uusilla arvoilla sekä "username"- että "oidcusername"-kenttään.</li>
                <li>local_o365_objects-taulun käyttäjäyhteystietueen "o365name"-kenttä päivitetään uuteen arvoon.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Kyllä</td>
        <td>Käyttäjien synkronointi</td>
        <td>Ei</td>
        <td>
            <ol>
                <li>Moodle-käyttäjä nimetään uudelleen.</li>
                <li>local_o365_objects-taulun käyttäjäyhteystietue päivitetään.</li>
                <li>auth_oidc_token päivitetään.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>Ei</td>
        <td>Kirjautuminen</td>
        <td>Ei</td>
        <td>
            <ol>
                <li>Moodle-käyttäjä nimetään uudelleen.</li>
                <li>local_o365_objects-taulun käyttäjäyhteystietue päivitetään.</li>
                <li>auth_oidc_token päivitetään.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>Ei</td>
        <td>Käyttäjien synkronointi</td>
        <td>Ei</td>
        <td>
            <ol>
                <li>Moodle-käyttäjä nimetään uudelleen.</li>
                <li>local_o365_objects-taulun käyttäjäyhteystietue päivitetään.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>Kyllä</td>
        <td>Kirjautuminen</td>
        <td>Kyllä</td>
        <td>
            <ol>
                <li>Heitetään poikkeus, eikä Moodle-käyttäjää nimetä uudelleen.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>Kyllä</td>
        <td>Käyttäjien synkronointi</td>
        <td>Kyllä</td>
        <td>
            <ol>
                <li>Käyttäjien synkronointitehtävän suorituksessa näytetään virheilmoitus, jonka mukaan uudelleennimeäminen epäonnistui.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>Ei</td>
        <td>Kirjautuminen</td>
        <td>Kyllä</td>
        <td>
            <ol>
                <li>Heitetään poikkeus, eikä Moodle-käyttäjää nimetä uudelleen.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>Ei</td>
        <td>Käyttäjien synkronointi</td>
        <td>Kyllä</td>
        <td>
            <ol>
                <li>Käyttäjien synkronointitehtävän suorituksessa näytetään virheilmoitus, jonka mukaan uudelleennimeäminen epäonnistui.</li>
            </ol>
        </td>
    </tr>
</table>
Huomaa tunnettu ongelma: jos
<ol>
<li>Moodle ja Microsoft 365 on yhdistetty "Microsoft identity platform (v2.0)" -yhteystavalla, ja</li>
<li>Microsoft Entra on määritetty sallimaan "Email as an alternate login ID" -toiminnon käyttö, ja</li>
<li>tämä asetus on käytössä, ja</li>
<li>Microsoft-tilin käyttäjätunnus ja sähköpostiosoite ovat erilaiset, ja</li>
<li>Microsoft-käyttäjä kirjautuu sisään sähköpostiosoitteella käyttäjätunnuksen sijaan,</li>
</ol>
auth_oidc-lisäosa käsittelee sähköpostiosoitetta Microsoft-tilin käyttäjätunnuksena ja päivittää Moodlen käyttäjätunnuksen.';

// User field mapping.
$string['settings_fieldmap'] = 'Käyttäjäkenttien määritys';
$string['settings_fieldmap_details'] = 'Käytettävissä <a href="{$a}">OpenID Connect -todennuslisäosassa</a>.';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'Kurssien synkronointi';
$string['settings_secthead_coursesync_desc'] = 'Seuraavat asetukset ohjaavat kurssien synkronointia Moodlen ja Microsoft Teamsin välillä.';
$string['settings_coursesync'] = 'Kurssien synkronointi';
$string['settings_coursesync_details'] = 'Jos asetus on käytössä, Moodle-sivuston kursseille luodaan ja ylläpidetään Teams-tiimejä (oletus: ei käytössä). Tarvittavat tiimit luodaan jokaisella cron-suorituskerralla, ja kaikki kurssille tällä hetkellä rekisteröityneet käyttäjät lisätään tiimin omistajiksi tai jäseniksi oikeustarkistuksen perusteella. Tämän jälkeen tiimin jäsenyyksiä ylläpidetään sitä mukaa, kun käyttäjiä rekisteröidään Moodlen kursseille tai heidän rekisteröitymisensä poistetaan.';
$string['acp_coursesynccustom_off'] = 'Ei käytössä<br />Poista tiimien luonti käytöstä kaikilta kursseilta.';
$string['acp_coursesynccustom_oncustom'] = 'Mukauta<br />Antaa valtuutettujen käyttäjien valita, mille kursseille tiimit luodaan.<br> <span id="adminsetting_coursesync" style="font-weight: bold"><a href="{$a}">Mukauta kurssien synkronointia</a></span>';
$string['acp_coursesynccustom_onall'] = 'Kaikki toiminnot käytössä<br />Ottaa tiimien luonnin käyttöön kaikille kursseille.';
$string['settings_coursesync_sync_hidden_courses'] = 'Synkronoi piilotetut kurssit';
$string['settings_coursesync_sync_hidden_courses_desc'] = 'Oletusarvoisesti lisäosa ohittaa piilotetut kurssit, jotta kopioitavia tai palautettavia kursseja ei synkronoida. Ota tämä asetus käyttöön, jos haluat pakottaa tiimien luonnin myös piilotetuille kursseille.';
$string['acp_coursesync_hidden_course_note'] = 'Huomautus: Piilotettuja kursseja ei käsitellä Teams-ryhmien luonnissa. Jos haluat sallia tämän, ota lisäosan asetuksista käyttöön "Synkronoi piilotetut kurssit" -asetus.';
$string['settings_coursesync_delete_group_on_course_deletion'] = 'Poista Microsoft 365 -ryhmät, kun yhdistetty Moodle-kurssi poistetaan';
$string['settings_coursesync_delete_group_on_course_deletion_details'] = 'Jos asetus on käytössä, Moodle yrittää poistaa Microsoft 365 -ryhmän (ja siihen liittyvän tiimin), kun yhdistetty kurssi poistetaan Moodlesta. Huomaa, että tämä ei koske SDS-synkronoinnilla luotuja kursseja.';
$string['settings_coursesync_delete_group_on_course_sync_disabled'] = 'Poista Microsoft 365 -ryhmät, kun kurssien synkronointi poistetaan käytöstä';
$string['settings_coursesync_delete_group_on_course_sync_disabled_details'] = 'Jos asetus on käytössä, Moodle yrittää poistaa yhdistetyn Microsoft 365 -ryhmän (ja siihen liittyvän tiimin), kun kurssien synkronointi poistetaan käytöstä Moodle-kurssilta.';
$string['settings_coursesync_courses_per_task'] = 'Synkronoitavien kurssien määrä tehtävän suorituskertaa kohden';
$string['settings_coursesync_courses_per_task_details'] = 'Niiden kurssien määrä, joiden tiimi-/ryhmäsynkronoinnin tila käsitellään kullakin tehtävän suorituskerralla.';
$string['settings_coursesync_team_type'] = 'Tiimimalli';
$string['settings_coursesync_team_type_desc'] = 'Microsoft Teams -malli, jota käytetään luotaessa tiimejä Moodle-kursseista. Koulutusmallit edellyttävät koulutuslisenssiä. <br><br><strong>Tärkeää:</strong> Määritetty malli ratkaisee, miten ryhmät ja tiimit luodaan:<br>
&bull; Vakiomalli luo tavallisia ryhmiä ja tiimejä (yhteensopiva kaikkien vuokraajien kanssa).<br>
&bull; Koulutusmallit luovat koulutusryhmiä/-tiimejä (vain koulutusvuokraajat; ottaa käyttöön koulutuskohtaiset toiminnot).<br>
&bull; Mukautetut mallit käyttävät tavallisia ryhmiä (yhteensopivuuden vuoksi mukautetun mallin rakenteen kanssa).<br><br>
<strong>⚠️ VAROITUS: Kun tiimi on luotu tietyllä mallilla, mallia ei voi vaihtaa.</strong> Tiimit pysyvät sidottuina alkuperäiseen malliinsa. Tämän asetuksen muuttaminen vaikuttaa vain uusiin tiimeihin, ei olemassa oleviin. Suunnittele mallin valinta huolellisesti ennen kurssien synkronoinnin käyttöönottoa.';
$string['settings_coursesync_team_type_standard'] = 'Vakio';
$string['settings_coursesync_team_type_educationclass'] = 'Koulutus - Luokkatiimi';
$string['settings_coursesync_team_type_educationstaff'] = 'Koulutus - Henkilöstötiimi';
$string['settings_coursesync_team_type_educationplc'] = 'Koulutus - Ammatillinen oppimisyhteisö (PLC)';
$string['settings_coursesync_team_type_custom'] = 'Mukautettu malli';
$string['settings_coursesync_team_type_custom_id'] = 'Mukautetun mallin tunnus';
$string['settings_coursesync_team_type_custom_id_desc'] = 'Teams-hallintakeskuksessa määritetyn mukautetun mallin täydellinen tunnus. Käytetään vain, kun yllä on valittu "Mukautettu malli". <br><br><strong>Mallin tunnuksen on oltava GUID-muodossa</strong> (esim. e41de7bb-859a-4a0f-aa39-5725a0529c1c). Löydät mallin tunnuksen Teams-hallintakeskuksesta tarkastelemalla mukautetun mallisi tietoja. <br><br>
<strong>⚠️ TARVITAAN LISÄKSI MICROSOFT ENTRA ID -KÄYTTÖOIKEUS:</strong> Mukautettujen tiimimallien tarkistaminen ja käyttäminen edellyttää Microsoft Graph API -sovelluskäyttöoikeutta (<strong>TeamTemplates.Read.All</strong>), jota Microsoft Entra ID -sovellusrekisteröinnissäsi ei välttämättä ole. Ilman tätä käyttöoikeutta tarkistus epäonnistuu, eikä mukautetun mallin tunnusta voi määrittää. Jos tarkistus epäonnistuu käyttöoikeusvirheeseen, pyydä Microsoft Entra ID -järjestelmänvalvojaa lisäämään tämä käyttöoikeus sovellusrekisteröintiin. <br><br>
<strong>⚠️ TÄRKEÄ RAJOITUS:</strong> Microsoft Teams tukee tällä hetkellä tiimien luontia mukautetuista malleista vain, jos mallissa on <strong>en-US-kielialueen määritys</strong>. Tiimien luonti epäonnistuu mukautetuilla malleilla, joissa ei ole en-US-kielialuetta. Varmista, että mukautetulle mallillesi on määritetty en-US-kielialue Teams-hallintakeskuksessa. <br><br>
<strong>⚠️ VAROITUS: Kun tiimi on luotu tällä mukautetulla mallilla, mallia ei voi vaihtaa.</strong> Jos haluat käyttää uusille tiimeille toista mukautettua mallia, sinun on jätettävä tämä asetus tyhjäksi tai muutettava sitä ennen seuraavaa tiimin luontia. Olemassa olevat tiimit käyttävät edelleen alkuperäistä malliaan. <br><br>
Tiimejä ei luoda oikein, jos määritetty mallin tunnus on virheellinen. Tarkista mallin tunnus "Tarkista mukautetun mallin tunnus" -painikkeella ennen kurssien synkronoinnin suorittamista.';
$string['error_custom_template_id_required'] = 'Mukautetun mallin tunnus vaaditaan, kun käytetään "Mukautettu malli" -vaihtoehtoa. Anna kelvollinen mallin tunnus.';
$string['error_custom_template_id_not_found'] = 'Mukautetun mallin tunnusta "{$a}" ei löytynyt. Varmista, että mallin tunnus on olemassa Teams-hallintakeskuksessa.';
$string['error_custom_template_id_validation_failed'] = 'Mukautetun mallin tunnuksen tarkistus epäonnistui. Malli ei ehkä tue suoraa tiimin luontia, tai määrityksissä voi olla ongelma. Tarkista mallin tunnus Teams-hallintakeskuksessa.';
$string['settings_team_type_custom_id_test_button'] = 'Tarkista mukautetun mallin tunnus';
$string['settings_team_type_custom_id_validating'] = '🔄 Tarkistetaan...';
$string['settings_team_type_custom_id_error_empty'] = '⚠️ Anna ensin mallin tunnus.';
$string['settings_team_type_custom_id_error_not_found'] = '✗ Mallia ei löytynyt. Mallin tunnusta "{$a}" ei ole olemassa. Tarkista se Teams-hallintakeskuksessa.';
$string['settings_team_type_custom_id_error_validation'] = '✗ Tarkistusvirhe. {$a}';
$string['settings_team_type_custom_id_error_default'] = 'Mallin tarkistus epäonnistui. Yritä uudelleen tai ota yhteyttä ylläpitäjään.';
$string['settings_team_type_custom_id_error_timeout'] = '✗ Tarkistus aikakatkaistiin. Pyyntö kesti yli 10 sekuntia. Yritä uudelleen.';
$string['settings_team_type_custom_id_error_network'] = '✗ Verkkovirhe. Tarkistuspalveluun ei saada yhteyttä. Tarkista internetyhteys ja yritä uudelleen.';
$string['settings_team_type_custom_id_error_parsererror'] = '✗ Palvelimen vastausvirhe. Tarkistuspalvelu palautti virheellisiä tietoja. Tarkista Microsoft 365 -integraatio.';
$string['settings_team_type_custom_id_error_http'] = '✗ Tarkistusvirhe (HTTP {$a}). Yritä uudelleen tai ota yhteyttä ylläpitäjään.';
$string['settings_coursesync_group_channels'] = 'Luo kanava jokaiselle Moodle-ryhmälle';
$string['settings_coursesync_group_channels_details'] = 'Luo yhdistettyyn Microsoft Teams -tiimiin yksityinen kanava jokaiselle Moodle-kurssin ryhmälle ja pidä kunkin kanavan jäsenet samoina kuin Moodle-ryhmän jäsenet. Ryhmän jäsenet, jotka on yhdistetty myös Microsoft 365:een, lisätään kanavalle tai poistetaan kanavalta, kun heidät lisätään ryhmään tai poistetaan ryhmästä. Microsoft Teamsissa kanavalle lisätyt henkilöt, jotka eivät ole Moodle-ryhmän jäseniä, poistetaan uudelleen. Koulutuksen luokkatiimissä, jota ei ole vielä aktivoitu, opiskelijoita ei voi lisätä kanaville: vain omistajat lisätään, ja opiskelijat lisätään automaattisesti ajastetulla tehtävällä "Luo Teams-kanavat Moodle-ryhmille ja synkronoi niiden jäsenet", kun omistaja on aktivoinut tiimin Microsoft Teamsissa. Kanavia ei nimetä uudelleen eikä poisteta, kun Moodle-ryhmä nimetään uudelleen tai poistetaan. Kanavien jäsenyys synkronoidaan aina vain Moodlesta Teamsiin, eikä tämä tee mitään, jos "Kurssin käyttäjien synkronoinnin suunta" -asetuksen arvo on "Teamsista Moodleen". Microsoft Teams sallii enintään 1 000 kanavaa tiimiä kohden, mukaan lukien yksityiset kanavat ja viimeisten 30 päivän aikana poistetut kanavat.<br /><br /><b>Tämä asetus edellyttää kahta Microsoft Graph -lisäsovelluskäyttöoikeutta:</b><ul><li><b>Channel.Create</b> - kanavien luomiseen.</li><li><b>ChannelMember.ReadWrite.All</b> - jäsenten lisäämiseen kanaville ja poistamiseen kanavilta.</li></ul>Molemmat on lisättävä Moodlen käyttämään Microsoft Entra ID -sovellukseen, ja niille on annettava järjestelmänvalvojan suostumus. "Määritys"-välilehden PowerShell-komentosarja sisältää ne jo, kun se rekisteröi uuden sovelluksen. Jo olemassa olevaan sovellukseen ne on lisättävä manuaalisesti kohdassa App registrations &gt; sovelluksesi &gt; API permissions &gt; Add a permission &gt; Microsoft Graph &gt; Application permissions, minkä jälkeen on annettava järjestelmänvalvojan suostumus. Kun tämä asetus on käytössä, "Määritys"-välilehden "Tarkista määritykset" ilmoittaa nämä käyttöoikeudet puuttuviksi, kunnes ne on myönnetty.';
$string['settings_coursesync_sync_direction'] = 'Kurssin käyttäjien synkronoinnin suunta';
$string['settings_coursesync_sync_direction_details'] = 'Valitse, mihin suuntaan käyttäjät synkronoidaan Moodlen ja Microsoft Teamsin välillä.';
$string['settings_coursesync_sync_moodle_to_teams'] = 'Moodlesta Teamsiin';
$string['settings_coursesync_sync_teams_to_moodle'] = 'Teamsista Moodleen';
$string['settings_coursesync_sync_both'] = 'Päivitä sekä Teams että Moodle';
$string['settings_coursesync_enrolment_owner_role'] = 'Tiimin omistajan rooli';
$string['settings_coursesync_enrolment_owner_role_desc'] = 'Rooli, joka annetaan tiimin omistajalle synkronoinnin aikana.';
$string['settings_coursesync_enrolment_member_role'] = 'Tiimin jäsenen rooli';
$string['settings_coursesync_enrolment_member_role_desc'] = 'Rooli, joka annetaan tiimin jäsenille synkronoinnin aikana.';

// Settings in the "Course sync customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_coursesynccustom'] = 'Kurssien synkronoinnin mukautus';
$string['acp_coursesynccustom_enabled'] = 'Käytössä';
$string['acp_coursesynccustom_enable_all'] = 'Ota kurssien synkronointi käyttöön kaikilla kursseilla';
$string['acp_coursesynccustom_disable_all'] = 'Poista kurssien synkronointi käytöstä kaikilta kursseilta';
$string['acp_coursesynccustom_bulk'] = 'Joukkotoiminnot';
$string['acp_coursesynccustom_bulk_enable'] = 'Ota kurssien synkronointi käyttöön tämän sivun kursseilla';
$string['acp_coursesynccustom_bulk_disable'] = 'Poista kurssien synkronointi käytöstä tämän sivun kursseilta';
$string['acp_coursesynccustom_settings_header'] = 'Synkronoinnin asetukset';
$string['acp_coursesynccustom_new_course'] = 'Oletusarvoisesti käytössä uusilla kursseilla';
$string['acp_coursesynccustom_new_course_desc'] = 'Jos asetus on käytössä, synkronointi on oletusarvoisesti käytössä kaikilla uusilla kursseilla.';
$string['acp_coursesynccustom_controlled_per_course'] = 'Salli kurssien synkronoinnin määrittäminen kursseilla';
$string['acp_coursesynccustom_controlled_per_course_desc'] = 'Jos asetus on käytössä, Moodle-kursseille rekisteröityneet käyttäjät, jotka voivat toimia tiimin omistajina (joilla on "Tiimin omistaja" [local/o365:teamowner] -oikeus), voivat hallita kurssin synkronointia kurssin Microsoft-lohkosta.';
$string['acp_coursesynccustom_savemessage'] = 'Muutokset on tallennettu.';
$string['acp_coursesynccustom_regex_search'] = 'Säännöllisen lausekkeen haku';
$string['acp_coursesynccustom_regex_search_title'] = 'Kun valittuna, yllä olevan hakukentän sisältöä verrataan PCRE-säännöllisenä lausekkeena (ilman erottimia) kurssin koko nimeen, lyhyeen nimeen ja tunnisteeseen tavallisen tekstihaun sijaan.';
$string['acp_coursesynccustom_confirm_all_action'] = 'Haluatko varmasti muuttaa kaikkien kurssien synkronoinnin tilaa? Toimintoa ei voi kumota.';
$string['acp_coursesynccustom_sds_course'] = 'Lukittu SDS-kurssille';
$string['acp_coursesynccustom_all_enabled_notice'] = 'Kurssien synkronointi on tällä hetkellä käytössä kaikilla kursseilla. Kurssikohtainen mukautus ei ole käytettävissä, koska "Kaikki toiminnot käytössä" -tila on aktiivinen.';
$string['acp_coursesynccustom_disabled_notice'] = 'Kurssien synkronointi on tällä hetkellä poistettu käytöstä koko sivustolla. Kurssikohtainen mukautus ei ole käytettävissä, koska "Ei käytössä" -tila on aktiivinen.';
$string['acp_coursesynccustom_categories_header'] = 'Synkronointi kurssikategorian mukaan';
$string['acp_coursesynccustom_categories_desc'] = 'Valitse yksi tai useampi kurssikategoria, jos haluat ottaa kurssien synkronoinnin automaattisesti käyttöön kaikilla näiden kategorioiden kursseilla, myös alakategorioissa. Tämä koskee myös kursseja, jotka lisätään valittuihin kategorioihin myöhemmin. Voit valita useita kategorioita pitämällä Ctrl-näppäintä (Macissa Cmd) painettuna, ja poistaa valinnan napsauttamalla uudelleen näppäintä painettuna pitäen.';
$string['acp_coursesynccustom_category_course'] = 'Lukittu: otettu käyttöön kurssikategorian perusteella';

// Settings in the "Cohort sync" section of the "Sync settings" tab.
$string['settings_secthead_cohortsync'] = 'Kohorttien synkronointi';
$string['settings_secthead_cohortsync_desc'] = 'Tämä toiminto mahdollistaa synkronoinnin Microsoft 365 -ryhmien ja Moodlen kohorttien välillä.';
$string['settings_cohortsync'] = 'Kohorttien synkronointi';
$string['settings_cohortsync_linktext'] = 'Hallitse kohorttien synkronointia';
$string['settings_cohortsync_details'] = 'Tarkastele ja hallitse Moodlen kohorttien ja Microsoft 365 -ryhmien välistä synkronointia.';
$string['settings_cohortsync_title'] = 'Kohorttien synkronointi';
$string['settings_cohortsync_excludeowners'] = 'Jätä ryhmien omistajat pois kohorttien synkronoinnista';
$string['settings_cohortsync_excludeowners_desc'] = 'Jos asetus on käytössä, ryhmien omistajia ei synkronoida Moodlen kohortteihin, vaikka he olisivat myös ryhmän jäseniä. Jo kohortissa olevat omistajat poistetaan seuraavalla synkronointikerralla.';

// Settings in the "Team / group names" section of the "Sync settings" tab.
$string['settings_secthead_team_group_name'] = 'Tiimien / ryhmien nimet';
$string['settings_secthead_team_group_name_desc'] = 'Jos kurssi on määritetty synkronoitavaksi, tiimin ja ryhmän nimi muodostetaan seuraavasti.<br/>
<ul>
<li>Ryhmän sähköpostialias ja tiimin näyttönimi voidaan määrittää.</li>
<li>Ensin luodaan Microsoft 365 -ryhmä käyttäen määritettyä ryhmän mailNickname-arvoa ja tiimin näyttönimeä, minkä jälkeen ryhmästä luodaan tiimi.</li>
<li>Jos Microsoft 365 -ryhmille on käytössä Microsoft Entra ID:n nimeämiskäytäntö, ryhmiä ei luoda, jos määritysten mukaan muodostettu näyttönimi ei vastaa käytäntöjä.</li>
<li>Tässä tehdyt muutokset vaikuttavat vain tulevaisuudessa luotaviin tiimeihin, eivät olemassa oleviin.</li>
<li>Ryhmän sähköpostialiaksesta poistetaan kaikki välilyönnit.</li>
<li>Ryhmän sähköpostialiaksessa sallitaan vain isot ja pienet kirjaimet, numerot sekä merkit - ja _.</li>
<li>Ryhmän sähköpostialias etu- ja jälkiliitteineen voi olla enintään 64 merkkiä pitkä.</li>
<li>Ryhmän sähköpostialiaksen on oltava yksilöllinen, muuten siihen lisätään satunnainen 4-numeroinen luku yksilöllisyyden varmistamiseksi.</li>
</ul>';
$string['settings_team_name_prefix'] = 'Tiimin nimen etuliite';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'Tiimin nimen kurssiosa';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'Tiimin nimen jälkiliite';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_group_mail_alias_prefix'] = 'Ryhmän sähköpostialiaksen etuliite';
$string['settings_group_mail_alias_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'Ryhmän sähköpostialiaksen kurssiosa';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'Ryhmän sähköpostialiaksen jälkiliite';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'Oletetaan, että kurssilla on:
<ul>
<li>Koko nimi: <b>Sample course</b></li>
<li>Lyhyt nimi: <b>sample 15</b></li>
<li>Moodlen luoma tunnus: <b>2</b></li>
<li>Tunniste: <b>Sample ID 15</b></li>
</ul>
Nykyisillä asetuksillasi luodaan ryhmä, jonka sähköpostialias on "<b>{$a->mailalias}</b>", ja tiimi, jonka nimi on "<b>{$a->teamname}</b>".<br/>
Näet, miten asetuksesi muuttavat tätä, valitsemalla alta "Tallenna muutokset".';
$string['settings_main_name_option_full_name'] = 'Koko nimi';
$string['settings_main_name_option_short_name'] = 'Lyhyt nimi';
$string['settings_main_name_option_id'] = 'Moodlen luoma tunnus';
$string['settings_main_name_option_id_number'] = 'Tunniste';
$string['settings_team_name_sync'] = 'Päivitä tiimin nimi kurssin päivityksen yhteydessä';
$string['settings_team_name_sync_desc'] = 'Jos asetus on käytössä, tiimin nimi päivitetään uusimpien tiimin nimiasetusten mukaisesti, kun Moodle-kurssia päivitetään.';

// Settings in the "Course request" section of the "Sync settings" tab.
$string['settings_secthead_course_request'] = 'Kurssipyyntö';
$string['settings_secthead_course_request_desc'] = 'Roolien määritykset Teamsista tehtävien kurssipyyntöjen toimintoa varten.';
$string['settings_course_request_enrolment_owner_role'] = 'Tiimin omistajan rooli';
$string['settings_course_request_enrolment_owner_role_desc'] = 'Rooli, joka annetaan tiimin omistajalle, kun kurssipyyntö hyväksytään.';
$string['settings_course_request_enrolment_member_role'] = 'Tiimin jäsenen rooli';
$string['settings_course_request_enrolment_member_role_desc'] = 'Rooli, joka annetaan tiimin jäsenille, kun kurssipyyntö hyväksytään.';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'Työkalut';
$string['settings_secthead_calsync'] = 'Kalenterin synkronointi';
$string['settings_calsyncsubscribemode'] = 'Kalenterin synkronoinnin tilaus';
$string['settings_calsyncsubscribemode_details'] = 'Määrittää, pitääkö käyttäjien ottaa Outlook-kalenterin synkronointi käyttöön itse.<ul><li><b>Vapaaehtoinen liittyminen</b>: käyttäjät ottavat kalenterin synkronoinnin käyttöön ja valitsevat synkronoitavat kalenterit kalenterin synkronoinnin asetussivullaan.</li><li><b>Automaattinen liittyminen</b>: Microsoft 365:een yhdistetyille käyttäjille otetaan kalenterin synkronointi automaattisesti käyttöön, ja heidät tilataan alla valittuihin kalentereihin (kurssien osalta kaikkiin kursseihin, joille he ovat rekisteröityneet nyt tai tulevaisuudessa), jolloin tiedot synkronoidaan Moodlesta heidän Outlookin ensisijaiseen kalenteriinsa. Käyttäjät voivat edelleen muuttaa tätä tai poistaa sen käytöstä kalenterin synkronoinnin asetussivullaan, eikä kalenterin synkronoinnin käytöstä poistaneita käyttäjiä tilata uudelleen.</li></ul>Palaaminen "Vapaaehtoinen liittyminen" -tilaan ei poista olemassa olevia tilauksia.';
$string['settings_calsyncsubscribetypes'] = 'Kalenterit, joihin käyttäjät tilataan automaattisesti';
$string['settings_calsyncsubscribetypes_details'] = 'Koskee vain "Automaattinen liittyminen" -tilaa. Valitse, mihin Moodlen kalentereihin yhdistetyt käyttäjät tilataan automaattisesti. Kaikkien käyttäjien tilaaminen sivuston kalenteriin lisää jokaisen käyttäjän osallistujaksi jokaiseen sivuston tapahtumaan, joten sitä ei ole valittu oletuksena.';
$string['settings_calsyncsubscribetypes_site'] = 'Sivuston kalenteri';
$string['settings_calsyncsubscribetypes_user'] = 'Henkilökohtainen kalenteri';
$string['settings_calsyncsubscribetypes_course'] = 'Kurssien kalenterit (kaikki kurssit, joille käyttäjä on rekisteröitynyt)';
$string['settings_calsyncsubscribemode_optin'] = 'Vapaaehtoinen liittyminen (käyttäjät ottavat kalenterin synkronoinnin käyttöön itse)';
$string['settings_calsyncsubscribemode_optout'] = 'Automaattinen liittyminen (ota kalenterin synkronointi automaattisesti käyttöön kaikille yhdistetyille käyttäjille)';
$string['settings_secthead_advanced'] = 'Lisäasetukset';
$string['settings_secthead_advanced_desc'] = 'Nämä asetukset ohjaavat lisäosakokonaisuuden muita toimintoja. Ole varovainen! Niillä voi olla ei-toivottuja vaikutuksia.';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'Vuokraajat';
$string['settings_tools_tenants_linktext'] = 'Määritä lisävuokraajat';
$string['settings_tools_tenants_details'] = 'Hallitse pääsyä muihin Microsoft Entra -vuokraajiin.';
$string['settings_healthcheck'] = 'Kuntotarkistus';
$string['settings_healthcheck_details'] = 'Jos jokin ei toimi oikein, kuntotarkistus pystyy yleensä tunnistamaan ongelman ja ehdottamaan ratkaisuja.';
$string['settings_healthcheck_linktext'] = 'Suorita kuntotarkistus';
$string['settings_userconnections'] = 'Käyttäjäyhteydet';
$string['settings_userconnections_linktext'] = 'Hallitse käyttäjäyhteyksiä';
$string['settings_userconnections_details'] = 'Tarkastele ja hallitse Moodle- ja Microsoft 365 -käyttäjien välisiä yhteyksiä.';
$string['settings_teamconnections'] = 'Tiimiyhteydet';
$string['settings_teamconnections_linktext'] = 'Hallitse tiimiyhteyksiä';
$string['settings_teamconnections_details'] = 'Tarkastele ja hallitse Moodle-kurssien ja Microsoft Teamsin välisiä yhteyksiä.';
$string['settings_usermatch'] = 'Käyttäjien yhdistäminen';
$string['settings_usermatch_details'] = 'Tällä työkalulla voit yhdistää Moodle-käyttäjiä Microsoft 365 -käyttäjiin ladatun mukautetun datatiedoston perusteella.';
$string['settings_usersyncgroupfilter'] = 'Käyttäjien synkronoinnin ryhmäsuodatin';
$string['settings_usersyncgroupfilter_details'] = 'Kun tähän annetaan ryhmäobjektin tunnus (GUID), täydet käyttäjien synkronoinnit rajoitetaan kyseisen Microsoft 365 -ryhmän jäseniin ja omistajiin. Jätä tyhjäksi, jos haluat synkronoida kaikki vuokraajasi lisensoidut käyttäjät.<br><br>
<strong>VAROITUS: Tämä on edistynyt asetus. Virheelliset määritykset voivat aiheuttaa merkittäviä tietojen synkronointiongelmia.</strong><br><br>
<strong>Kun asetus on määritetty, seuraavat koskevat synkronointia:</strong><br>
(1) Profiilin, aikavyöhykkeen ja kuvan päivitykset tehdään vain käyttäjille, jotka ovat ryhmän jäseniä tai omistajia<br>
(2) Uudet Moodle-tilit luodaan vain käyttäjille, jotka ovat ryhmän jäseniä tai omistajia<br>
(3) Ryhmään kuulumattomien käyttäjien Moodle-tilit eivät enää saa päivityksiä ja voivat joutua epäsynkronoiduiksi Microsoft 365:n kanssa<br>
(4) Microsoft 365:ssä käytöstä poistetut käyttäjät jäädytetään Moodlessa edelleen käyttöönottotilan synkronoinnin avulla, joka toimii ryhmäsuodatuksesta riippumatta<br>
(5) Käyttäjän poistaminen ryhmästä lopettaa tilin tulevat synkronoinnit. Hänen Moodle-tiliään ei poisteta, ja se jäädytetään vain, jos "Jäädytä tilit Moodlessa, kun ne eivät kuulu määritettyyn käyttäjien synkronointiryhmään" -asetus on käytössä. Tämä asetus jäädyttää jokaisen synkronoidun käyttäjän, joka ei ole ryhmässä, riippumatta siitä, onko hän koskaan kuulunut siihen<br><br>
<strong>Inkrementaalisen (delta-) synkronoinnin rajoitus:</strong> Microsoft Graph ei tue delta-kyselyitä ryhmän jäsenyyden päätepisteissä. Kun tämä asetus on määritetty, delta-synkronoinnit suorittavat inkrementaalisen päivityksen sijaan ryhmän jäsenten täyden synkronoinnin. Tämä on oikea toiminta, mutta voi olla tavallista delta-synkronointia hitaampaa.<br><br>
Tarkista ryhmäobjektin tunnus ennen tallentamista. Anna ryhmäobjektin tunnus (GUID).';
$string['settings_usersyncgroupfilter_validation_error'] = 'Virheellinen ryhmätunnuksen muoto. Ryhmätunnuksen on oltava kelvollinen GUID (esim. 550e8400-e29b-41d4-a716-446655440000).';
$string['settings_usersynccreationrestriction'] = 'Käyttäjien luonnin rajoitus';
$string['settings_usersynccreationrestriction_details'] = 'Jos asetus on käytössä, käyttäjien synkronoinnissa luodaan vain ne Microsoft Entra ID -käyttäjät, jotka täyttävät ehdon. Microsoft 365 -ryhmän jäsenyyttä (ryhmäobjektin tunnus) varten anna yksi ryhmäobjektin tunnus tai useita pilkuilla erotettuja tunnuksia.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Kentän arvo';
$string['settings_usersynccreationrestriction_o365group'] = 'Microsoft 365 -ryhmän jäsenyys (ryhmän nimi)';
$string['settings_usersynccreationrestriction_o365groupid'] = 'Microsoft 365 -ryhmän jäsenyys (ryhmäobjektin tunnus)';
$string['settings_usersynccreationrestriction_invalidgroupid'] = 'Microsoft 365 -ryhmäobjektin tunnusta "{$a}" ei löytynyt. Tarkista tunnus ja yritä uudelleen.';
$string['settings_usersynccreationrestriction_groupvalidationerror'] = 'Microsoft 365 -ryhmäobjektien tunnuksia ei voitu tarkistaa. Tarkista tunnukset ja Microsoft Graph -määritykset ja yritä sitten uudelleen.';
$string['settings_usersynccreationrestriction_regex'] = 'Arvo on säännöllinen lauseke';
$string['settings_maintenance'] = 'Ylläpito';
$string['settings_maintenance_details'] = 'Käytettävissä on useita ylläpitotehtäviä joidenkin yleisten ongelmien ratkaisemiseksi.';
$string['settings_maintenance_linktext'] = 'Näytä ylläpitotyökalut';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'Monivuokraajuus';
$string['acp_tenants_title_desc'] = 'Tämän sivun avulla voit määrittää Moodlen monivuokraajakäytön Microsoft 365:stä.';
$string['acp_tenants_add'] = 'Lisää uusi vuokraaja';
$string['acp_tenants_errornotsetup'] = 'Suorita lisäosan määritys loppuun ennen kuin lisäät muita vuokraajia.';
$string['acp_tenants_hosttenant'] = 'Isäntävuokraaja: {$a}';
$string['acp_tenants_intro'] = '<b>Monivuokraajuuden toiminta:</b><br />Monivuokraajuus mahdollistaa useiden Microsoft Entra -vuokraajien pääsyn Moodle-sivustollesi. <br /><br />
    Määritys tehdään näin:
    <ol>
        <li>Kirjaudu Moodleen sivuston ylläpitäjänä, joka ei käytä OpenID Connect -todennuslisäosaa.</li>
        <li>Varmista, että OpenID Connect -todennuslisäosan <b>Authorization Endpoint</b>- ja <b>Token Endpoint</b> -asetuksissa käytetään oletusarvoisia, vuokraajasta riippumattomia arvoja.</li>
        <li>Poista OpenID Connect -todennuslisäosa käytöstä Moodlessa. (Käytä <a href="{$a}/admin/settings.php?section=manageauths">todennuslisäosien hallintasivua</a>.)</li>
        <li>Siirry Microsoft Entra ID:hen ja etsi Moodlea varten määrittämäsi sovellus.</li>
        <li>Ota monivuokraajuus käyttöön Microsoft Entra ID -sovelluksessa ja tallenna muutokset.</li>
        <li>Anna sovellukselle vähintään yksi seuraavista delegoiduista Graph-käyttöoikeuksista: <b>Directory.Read.All</b>, <b>Domain.Read.All</b> tai <b>Domain.ReadWrite.All</b>. Organisaatiosi järjestelmänvalvojan suostumusta ei tarvita.</li>
        <li>Jos olet jo kirjautunut sisään lisävuokraajan Microsoft-tililläsi, kirjaudu kokonaan ulos ja kirjaudu takaisin sisään.</li>
        <li>Valitse jokaiselle käyttöön otettavalle vuokraajalle "Lisää uusi vuokraaja" ja kirjaudu sisään kyseisen vuokraajan järjestelmänvalvojan tilillä.</li>
        <li>Kun olet lisännyt kaikki haluamasi vuokraajat, ota OpenID Connect -todennuslisäosa uudelleen käyttöön Moodlessa.</li>
        <li>Valmista! Jos haluat myöhemmin lisätä muita vuokraajia, valitse "Lisää uusi vuokraaja" -painike ja kirjaudu sisään kyseisen vuokraajan järjestelmänvalvojan tilillä.</li>
    </ol>
    <b>Tärkeä huomautus:</b> Kun monivuokraajuus on otettu käyttöön Microsoft Entra ID -sovelluksessa, kaikki Microsoft Entra -vuokraajat pääsevät käyttämään sovellustasi. Lisäämällä vuokraajat tähän voimme rajoittaa Moodlen käytön määrittämiisi vuokraajiin. <b>Jos poistat kaikki vuokraajat tästä luettelosta ennen kuin poistat monivuokraajuuden käytöstä Microsoft Entra ID -sovelluksessa, tai otat OpenID Connect -todennuksen käyttöön Moodlessa tyhjällä luettelolla, Moodle-sivustosi on avoin kaikille Microsoft Entra -vuokraajille.</b>';
$string['acp_tenants_none'] = 'Et ole määrittänyt yhtään vuokraajaa. Jos olet ottanut monivuokraajuuden käyttöön Microsoft Entra ID -sovelluksessa, Moodle-sivustosi voi olla avoin kaikille Microsoft 365 -käyttäjille.';
$string['acp_tenants_revokeaccess'] = 'Peruuta käyttöoikeus';
$string['acp_tenants_tenant'] = 'Vuokraaja';
$string['acp_tenants_actions'] = 'Toiminnot';
$string['acp_tenants_delete'] = 'Poista';
$string['acp_tenantsadd_desc'] = 'Jos haluat myöntää käyttöoikeuden lisävuokraajalle, valitse alla oleva painike ja kirjaudu Microsoft 365:een uuden vuokraajan järjestelmänvalvojan tilillä. Sinut palautetaan lisävuokraajien luetteloon, jossa uusi vuokraaja näkyy. Tämän jälkeen voit käyttää Moodlea uuden vuokraajan kanssa.';
$string['acp_tenantsadd_linktext'] = 'Siirry Microsoft 365:n kirjautumissivulle';
$string['acp_tenants_legacy_tenants'] = 'Vanhat vuokraajat (toimenpiteitä tarvitaan)';
$string['acp_tenants_legacy_tenants_help'] = 'Alla olevat aiemmin lisätyt lisävuokraajat eivät välttämättä toimi päivitetyssä monivuokraajuuden työnkulussa, ja ne on korjattava.<br/>
Lisää ne uudelleen yllä olevalla "Lisää uusi vuokraaja" -painikkeella.';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = 'Kuntotarkistus';
$string['healthcheck_fixlink'] = 'Korjaa ongelma napsauttamalla tätä.';
$string['healthcheck_ratelimit_title'] = 'API-rajoitus';
$string['healthcheck_ratelimit_result_notice'] = 'Lievä rajoitus on otettu käyttöön Moodle-sivuston kasvaneen kuormituksen käsittelemiseksi. <br /><br />Kaikki Microsoft 365 -toiminnot toimivat, pyyntöjä vain hajautetaan hieman, jotta Microsoft 365 -palvelut eivät keskeytyisi. Kun Moodlen käyttö vähenee, kaikki palaa normaaliksi. <br />(Taso {$a->level} / alkoi {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'Voimakkaampi rajoitus on otettu käyttöön Moodle-sivuston merkittävän kuormituksen käsittelemiseksi. <br /><br />Kaikki Microsoft 365 -toiminnot toimivat edelleen, mutta Microsoft 365 -pyyntöjen valmistuminen voi kestää tavallista kauemmin. Kun Moodle-sivuston käyttö on vähentynyt, kaikki palaa normaaliksi. <br />(Taso {$a->level} / alkoi {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'Pyyntöjen rajoitustoiminnot on poistettu käytöstä.';
$string['healthcheck_ratelimit_result_passed'] = 'Microsoft 365 API -kutsut suoritetaan täydellä nopeudella.';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'Hallitse käyttäjäyhteyksiä';
$string['acp_userconnections_column_muser'] = 'Moodle-käyttäjä';
$string['acp_userconnections_column_o365user'] = 'Microsoft 365 -käyttäjä';
$string['acp_userconnections_column_status'] = 'Yhteyden tila';
$string['acp_userconnections_column_actions'] = 'Toiminnot';
$string['acp_userconnections_column_usinglogin'] = 'Käyttää kirjautumista';
$string['acp_userconnections_column_status_help'] = 'Yhteyden tila näyttää, miten Moodle-tili on linkitetty Microsoft 365 (Microsoft Entra ID) -tiliin.

* **Yhdistetty** – Käyttäjä on viimeistellyt yhteyden kirjautumalla Moodleen Microsoft 365 -tilillään, tai ylläpitäjä on yhdistänyt tilin. Toiminnot, kuten kalenterin synkronointi ja OneDrive, toimivat tälle käyttäjälle.
* **Täsmätty** – Ylläpitäjä (tai käyttäjien joukkotäsmäystyökalu) on tallentanut, mihin Microsoft 365 -tiliin tämä Moodle-käyttäjä kuuluu, mutta yhteys ei ole vielä aktiivinen. Se viimeistellään, kun käyttäjä kirjautuu ensimmäisen kerran Microsoft 365:llä. Mitään ei synkronoida, kun käyttäjä on vain täsmätty.
* **Synkronoitu** – Käyttäjien synkronointitehtävä on luonut Moodle-tilin Microsoft Entra ID:stä, mutta käyttäjä ei ole vielä kirjautunut. Tili aktivoituu ensimmäisellä kirjautumiskerralla.
* **Ei yhteyttä** – Moodle-tiliä ei ole linkitetty mihinkään Microsoft 365 -tiliin.';
$string['acp_userconnections_column_actions_help'] = 'Riville käytettävissä olevat toiminnot riippuvat sen yhteyden tilasta.

* **Katkaise yhteys** – Poistaa Moodle-tilin ja Microsoft 365 -tilin välisen linkin. Henkilö säilyttää Moodle-tilinsä, mutta ei voi enää käyttää Microsoft 365 -toimintoja tai kirjautua Microsoft 365:llä, ennen kuin hän yhdistää tilin uudelleen. Näytetään yhdistetyille käyttäjille.
* **Synkronoi uudelleen** – Suorittaa tämän käyttäjän Microsoft 365 -tietojen synkronoinnin heti (profiilikentät, kuva, kalenteri jne.) ajastettua tehtävää odottamatta ja näyttää tuloksen. Näytetään yhdistetyille ja synkronoiduille käyttäjille.
* **Täsmää** – Tallentaa, mihin Microsoft 365 -tiliin tämä Moodle-käyttäjä kuuluu. Yhteys ei ole aktiivinen ennen kuin henkilö kirjautuu Microsoft 365:llä. Näytetään käyttäjille, joilla ei ole yhteyttä.
* **Poista täsmäys** – Poistaa täsmäyksen, jota ei ole vielä viimeistelty. Näytetään täsmätyille käyttäjille.';
$string['acp_userconnections_accountstatus_active'] = 'Aktiivinen';
$string['acp_userconnections_accountstatus_suspended'] = 'Jäädytetty';
$string['acp_userconnections_connectionstatus_connected'] = 'Yhdistetty';
$string['acp_userconnections_connectionstatus_matched'] = 'Täsmätty';
$string['acp_userconnections_connectionstatus_noconnection'] = 'Ei yhteyttä';
$string['acp_userconnections_connectionstatus_synced'] = 'Synkronoitu';
$string['acp_userconnections_filtering_accountstatus'] = 'Tilin tila';
$string['acp_userconnections_filtering_connectionstatus'] = 'Yhteyden tila';
$string['acp_userconnections_filtering_muserfullname'] = 'Moodle-käyttäjän koko nimi';
$string['acp_userconnections_filtering_musername'] = 'Moodle-käyttäjätunnus';
$string['acp_userconnections_filtering_o365username'] = 'Microsoft 365 -käyttäjätunnus';
$string['acp_userconnections_manualmatch_title'] = 'Käyttäjän manuaalinen täsmäys';
$string['acp_userconnections_manualmatch_details'] = 'Tällä sivulla voit täsmätä yksittäisen Moodle-käyttäjän yksittäiseen Microsoft 365 -käyttäjään.';
$string['acp_userconnections_manualmatch_musername'] = 'Moodle-käyttäjä';
$string['acp_userconnections_manualmatch_uselogin'] = 'Kirjaudu Microsoft 365:llä';
$string['acp_userconnections_manualmatch_o365username'] = 'Microsoft 365 -käyttäjätunnus';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'Moodle-käyttäjä on jo yhdistetty Microsoft 365 -käyttäjään';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'Moodle-käyttäjä on jo yhdistetty Microsoft 365 -käyttäjään (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'Moodle-käyttäjä on jo täsmätty Microsoft 365 -käyttäjään';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'Microsoft 365 -käyttäjä on jo täsmätty toiseen Moodle-käyttäjään';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'Microsoft 365 -käyttäjä on jo yhdistetty toiseen Moodle-käyttäjään';
$string['acp_userconnections_resync_nodata'] = 'Tälle käyttäjälle ei löytynyt tallennettuja Microsoft 365 -tietoja.';
$string['acp_userconnections_resync_notfound'] = 'Tietoja ei synkronoitu. Tili "{$a->username}" on linkitetty Microsoft Entra ID -objektiin {$a->objectid}, mutta objektia ei löytynyt. Käyttäjä on todennäköisesti poistettu tai poistettu käytöstä Microsoft 365:ssä, tai tallennettu objektin tunnus on vanhentunut.';
$string['acp_userconnections_resync_nooutput'] = 'Uudelleensynkronointi valmistui ilmoittamatta muutoksista.';
$string['acp_userconnections_table_disconnect'] = 'Katkaise yhteys';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'Tämä katkaisee Moodle-käyttäjän "{$a}" yhteyden Microsoft 365:een. Jatka napsauttamalla alla olevaa linkkiä.';
$string['acp_userconnections_table_match'] = 'Täsmää';
$string['acp_userconnections_table_resync'] = 'Synkronoi uudelleen';
$string['acp_userconnections_table_unmatch'] = 'Poista täsmäys';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'Tämä poistaa Moodle-käyttäjän "{$a}" täsmäyksen Microsoft 365:een. Jatka napsauttamalla alla olevaa linkkiä.';

// Settings in the "Manage Team Connections" feature of the "Advanced" tab.
$string['acp_teamconnections'] = 'Hallitse tiimiyhteyksiä';
$string['acp_teamconnection'] = 'Hallitse tiimiyhteyttä';
$string['acp_teamconnections_actions'] = 'Toiminnot';
$string['acp_teamconnections_cache_last_updated'] = 'Teams-välimuisti päivitettiin viimeksi {$a->lastupdated}. Päivitä välimuisti napsauttamalla <a href="{$a->updateurl}">tästä</a>.';
$string['acp_teamconnections_cache_never_updated'] = 'Teams-välimuistia ei ole koskaan päivitetty. Päivitä napsauttamalla <a href="{$a->updateurl}">tästä</a>.';
$string['acp_teamconnections_connected_team'] = 'Yhdistetty tiimi';
$string['acp_teamconnections_course_connected'] = 'Kurssi on yhdistetty tiimiin.';
$string['acp_teamconnections_course_disconnected'] = 'Kurssin yhteys tiimiin on katkaistu.';
$string['acp_teamconnections_team_linked'] = 'Kurssi on linkitetty tiimiin.';
$string['acp_teamconnections_current_connection'] = 'NYKYINEN YHTEYS';
$string['acp_teamconnections_exception_course_not_exist'] = 'Yhdistettävää kurssia ei ole olemassa.';
$string['acp_teamconnections_exception_invalid_team_id'] = 'Virheellinen tiimin tunnus';
$string['acp_teamconnections_exception_not_configured'] = 'Microsoft 365:tä ei ole määritetty kokonaan.';
$string['acp_teamconnections_exception_team_already_connected'] = 'Tiimi on jo yhdistetty toiseen kurssiin';
$string['acp_teamconnections_form_connect_course'] = 'Hallitse kurssin {$a} tiimiyhteyttä';
$string['acp_teamconnections_form_sds_warning'] = 'HUOMAUTUS: Student Data Syncin (SDS) luomia tiimejä ei voi yhdistää tässä manuaalisesti, koska se olisi ristiriidassa SDS-synkronoinnin kanssa. Ne on jätetty pois alla olevista hakutuloksista.';
$string['acp_teamconnections_form_team'] = 'Valitse tiimi';
$string['acp_teamconnections_form_team_noselection'] = 'Hae tiimiä...';
$string['acp_teamconnections_no_teams_found'] = 'Tiimejä ei löytynyt hakusanalla "{$a}"';
$string['acp_teamconnections_group_only'] = ' (Vain ryhmä)';
$string['acp_teamconnections_team_missing'] = '(Tiimi puuttuu)';
$string['acp_teamconnections_not_connected'] = 'Ei yhdistetty';
$string['acp_teamconnections_sync_disabled'] = 'Kurssien synkronointi on otettava ensin käyttöön ennen tiimiyhteyksien hallintaa.';
$string['acp_teamconnections_table_connect'] = 'Yhdistä';
$string['acp_teamconnections_table_connect_to_different_team'] = 'Yhdistä toiseen tiimiin';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'Tiimiä ei voi luoda ryhmästä - ei omistajaa';
$string['acp_teamconnections_table_link_team'] = 'Linkitä tiimiin "{$a}"';
$string['acp_teamconnections_table_missing_team'] = 'Kurssi on yhdistetty tiimiin, jota ei ole olemassa. Tämä siivotaan, kun kurssien synkronoinnin ajastettu tehtävä suoritetaan seuraavan kerran.';
$string['acp_teamconnections_table_resync'] = 'Synkronoi uudelleen';
$string['acp_teamconnections_table_update'] = 'Päivitä';
$string['acp_teamconnections_teams_cache_updated'] = 'Teams-välimuisti päivitettiin onnistuneesti.';
$string['acp_teamconnections_no_owner'] = 'Lisää omistaja, jotta voit yhdistää Teamsiin.';
$string['acp_teamconnections_resync'] = 'Synkronoi tiimin omistajat / jäsenet uudelleen';
$string['acp_teamconnections_resync_title'] = 'Synkronoi kurssin {$a} tiimin omistajat / jäsenet uudelleen';
$string['acp_teamconnections_resync_desc'] = 'Tämä vertaa kurssille rekisteröityneitä käyttäjiä yhdistetyn Microsoft 365 -ryhmän/tiimin omistajiin ja jäseniin ja lisää puuttuvat käyttäjät. Valitse, poistetaanko myös käyttäjät, jotka ovat tiimissä mutta eivät ole rekisteröityneet Moodle-kurssille.';
$string['acp_teamconnections_resync_keep'] = 'Synkronoi uudelleen (säilytä tiimin ylimääräiset jäsenet)';
$string['acp_teamconnections_resync_keep_desc'] = 'Moodle-kurssille rekisteröityneet käyttäjät, jotka puuttuvat tiimistä, lisätään. Nykyisiä tiimin omistajia / jäseniä, jotka eivät ole rekisteröityneet Moodle-kurssille, ei muuteta.';
$string['acp_teamconnections_resync_remove'] = 'Synkronoi uudelleen ja poista tiimin ylimääräiset jäsenet';
$string['acp_teamconnections_resync_remove_desc'] = 'Varoitus: kaikki tiimin omistajat ja jäsenet, jotka eivät ole rekisteröityneet Moodle-kurssille, poistetaan tiimistä, vaikka heidät olisi lisätty suoraan Microsoft Teamsissa.';
$string['acp_teamconnections_resync_completed'] = 'Tiimin omistajat / jäsenet on synkronoitu uudelleen.';
$string['acp_teamconnections_resync_failed'] = 'Tiimin omistajia / jäseniä ei voitu synkronoida uudelleen. Katso lisätiedot yllä olevasta tulosteesta.';
$string['acp_teamconnections_last_resync'] = 'Viimeksi synkronoitu uudelleen: {$a}';
$string['acp_teamconnections_never_resynced'] = 'Ei koskaan synkronoitu uudelleen';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'Käyttäjien täsmäys';
$string['acp_usermatch_desc'] = 'Tällä työkalulla voit täsmätä Moodle-käyttäjiä Microsoft 365 -käyttäjiin. Lataat tiedoston, joka sisältää Moodle-käyttäjät ja niihin liittyvät Microsoft 365 -käyttäjät, ja cron-tehtävä tarkistaa tiedot ja muodostaa täsmäykset.';
$string['acp_usermatch_upload'] = 'Vaihe 1: Lataa uudet täsmäykset';
$string['acp_usermatch_upload_desc'] = 'Lataa datatiedosto, joka sisältää Moodle- ja Microsoft 365 -käyttäjätunnukset, täsmätäksesi Moodle-käyttäjät Microsoft 365 -käyttäjiin.<br />
<br />
Tiedoston tulee olla yksinkertainen pelkkää tekstiä sisältävä CSV-tiedosto, jonka jokaisella rivillä on kolme kohdetta:
<ul>
<li>Moodle-käyttäjätunnus,</li>
<li>Microsoft 365 -käyttäjätunnus,</li>
<li>1 tai 0, missä 1 tarkoittaa käyttäjän todennustavan vaihtamista OpenID Connectiin ja 0 nykyisen todennustavan säilyttämistä ja tilin käyttämistä linkitettynä tilinä.</li>
</ul>
Älä lisää otsikkorivejä tai muita tietoja.<br />
Esimerkiksi: <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'Tyyppiä {$a} ei tueta. Lataa pelkkää tekstiä sisältävä CSV-tiedosto.';
$string['acp_usermatch_upload_err_data'] = 'Rivillä {$a} oli virheellisiä tietoja. CSV-tiedoston jokaisella rivillä tulee olla vähintään kaksi kohdetta: Moodle-käyttäjätunnus ja Microsoft 365 -käyttäjätunnus.';
$string['acp_usermatch_upload_err_fileopen'] = 'Tiedostoa ei voitu avata käsittelyä varten. Ovatko Moodledata-hakemiston käyttöoikeudet oikein?';
$string['acp_usermatch_upload_err_nofile'] = 'Jonoon lisättävää tiedostoa ei vastaanotettu.';
$string['acp_usermatch_upload_submit'] = 'Lisää datatiedosto täsmäysjonoon';
$string['acp_usermatch_matchqueue'] = 'Vaihe 2: Täsmäysjono';
$string['acp_usermatch_matchqueue_clearall'] = 'Tyhjennä kaikki';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Tyhjennä virheet';
$string['acp_usermatch_matchqueue_clearqueued'] = 'Tyhjennä jonossa olevat';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Tyhjennä onnistuneet';
$string['acp_usermatch_matchqueue_column_muser'] = 'Moodle-käyttäjätunnus';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Microsoft 365 -käyttäjätunnus';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Tila';
$string['acp_usermatch_matchqueue_desc'] = 'Tämä taulukko näyttää täsmäystoiminnon nykyisen tilan. Aina kun ajastettu tehtävä <b>Käsittele täsmäysjono</b> suoritetaan, osa seuraavista käyttäjistä käsitellään.<br /><b>Huomautus:</b> Tämä sivu ei päivity automaattisesti. Näet nykyisen tilan päivittämällä sivun.';
$string['acp_usermatch_matchqueue_empty'] = 'Täsmäysjono on tällä hetkellä tyhjä. Lisää käyttäjiä jonoon lataamalla datatiedosto yllä olevalla tiedostovalitsimella.';
$string['acp_usermatch_matchqueue_status_error'] = 'Virhe: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'Jonossa';
$string['acp_usermatch_matchqueue_status_success'] = 'Onnistui';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'Ylläpitotyökalut';
$string['acp_maintenance_desc'] = 'Nämä työkalut voivat auttaa ratkaisemaan joitakin yleisiä ongelmia.';
$string['acp_maintenance_warning'] = 'Varoitus: Nämä ovat edistyneitä työkaluja. Käytä niitä vain, jos ymmärrät, mitä olet tekemässä.';
$string['acp_maintenance_resyncgroupusers'] = 'Synkronoi kurssien Microsoft 365 -ryhmien käyttäjät uudelleen';
$string['acp_maintenance_resyncgroupusers_desc'] = 'Tämä synkronoi uudelleen kaikille Moodle-kursseille luotujen Microsoft 365 -ryhmien jäsenyydet. Näin varmistetaan, että Microsoft 365 -ryhmässä ovat kaikki Moodle-kurssille rekisteröityneet käyttäjät ja vain he. <br /><b>Huomautus:</b> Jos olet lisännyt Microsoft 365 -ryhmään käyttäjiä, jotka eivät ole rekisteröityneet vastaavalle Moodle-kurssille, heidät poistetaan.';
$string['acp_maintenance_recreatedeletedgroups'] = 'Luo poistetut Microsoft 365 -ryhmät uudelleen';
$string['acp_maintenance_recreatedeletedgroups_desc'] = 'Tämä etsii Moodle-kursseihin yhdistettyjä Microsoft 365 -ryhmiä, jotka on mahdollisesti poistettu manuaalisesti, ja luo ne uudelleen.';
$string['acp_maintenance_debugdata'] = 'Luo vianmäärityspaketti';
$string['acp_maintenance_debugdata_desc'] = 'Tämä luo paketin, joka sisältää erilaisia tietoja Moodle- ja Microsoft 365 -ympäristöstäsi ongelmien ratkaisemisen helpottamiseksi kehittäjille. Jos kehittäjä pyytää, suorita tämä työkalu ja lähetä ladattu tiedosto. Huomautus: Vaikka paketti ei sisällä arkaluonteisia tunnistetietoja, pyydämme, ettet julkaise tiedostoa julkisesti tai lähetä sitä epäluotettavalle osapuolelle.';
$string['acp_maintenance_cleandeltatoken'] = 'Siivoa käyttäjien synkronoinnin delta-tunnukset';
$string['acp_maintenance_cleandeltatoken_desc'] = 'Jos käyttäjien synkronointi ei toimi kunnolla synkronointiasetusten päivittämisen jälkeen, syynä voi olla vanha delta-synkronoinnin tunnus. Tunnuksen siivoaminen pakottaa täydellisen uudelleensynkronoinnin, kun käyttäjien synkronointi suoritetaan seuraavan kerran.';
$string['acp_maintenance_cleanapptokens'] = 'Siivoa sovelluksen käyttöoikeustunnukset';
$string['acp_maintenance_cleanapptokens_desc'] = 'Poistaa tallennetut sovelluksen käyttöoikeustunnukset, joita lisäosa käyttää Microsoftin ohjelmointirajapintojen kutsuihin, joita ei suoriteta käyttäjänä. Uudet sovelluksen käyttöoikeustunnukset pyydetään automaattisesti, kun niitä seuraavan kerran tarvitaan, ja Määritys-välilehden viimeisimmän "Tarkista määritykset" -tarkistuksen tulokset tyhjennetään. Jos sovelluskäyttöoikeuksilla tehdyt kutsut epäonnistuvat todennusvirheisiin esimerkiksi sen jälkeen, kun Microsoft Entra ID -sovelluksen käyttöoikeudet tai tunnistetiedot ovat muuttuneet, tunnusten siivoaminen voi auttaa. Käyttäjien tunnuksiin tämä ei vaikuta.';

// Settings in the "Resync users in Microsoft 365 groups for courses" feature in the "Maintenance Tools" feature of the
// "Advanced" tab.
$string['acp_maintenance_resyncgroupusers_course_output'] = 'Uudelleensynkronoinnin tuloste';
$string['acp_maintenance_resyncgroupusers_no_course'] = 'Microsoft 365:een ei ole yhdistetty yhtään kurssia';
$string['acp_maintenance_coursesync_disabled'] = 'Tämä työkalu on käytettävissä vain, kun kurssien synkronointi on käytössä. <a href="{$a}">Hallitse kurssien synkronointia</a>.';

// Settings in the "Recreate deleted Microsoft 365 groups" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_recreatedeletedgroups_group_type'] = 'Moodle-objektin tyyppi';
$string['acp_maintenance_recreatedeletedgroups_group_type_course'] = 'Kurssi';
$string['acp_maintenance_recreatedeletedgroups_group_type_course_group'] = 'Kurssin ryhmä';
$string['acp_maintenance_recreatedeletedgroups_course'] = 'Kurssi';
$string['acp_maintenance_recreatedeletedgroups_course_group'] = 'Kurssin ryhmä';
$string['acp_maintenance_recreatedeletedgroups_status'] = 'Tila';
$string['acp_maintenance_recreatedeletedgroups_status_sync_disabled'] = 'Kurssien synkronointi ei ole käytössä';
$string['acp_maintenance_recreatedeletedgroups_status_created_success'] = 'Ryhmä luotiin uudelleen';
$string['acp_maintenance_recreatedeletedgroups_status_created_fail'] = 'Ryhmän uudelleenluonti epäonnistui';
$string['acp_maintenance_recreatedeletedgroups_all_groups_exist'] = 'Kaikki Moodle-kursseihin ja kurssien ryhmiin yhdistetyt ryhmät ovat olemassa.';

// Settings in the "Cleanup User Sync Delta Tokens" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_cleandeltatoken_completed'] = 'Käyttäjien synkronoinnin delta-tunnus ja skip delta -tunnus siivottiin.';
$string['acp_maintenance_cleanapptokens_confirm'] = 'Haluatko varmasti siivota sovelluksen käyttöoikeustunnukset? Tallennettuna on tällä hetkellä {$a} sovelluksen käyttöoikeustunnus(ta).';
$string['acp_maintenance_cleanapptokens_completed'] = 'Sovelluksen käyttöoikeustunnukset ja viimeisimmät "Tarkista määritykset" -tulokset siivottiin.';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_course_reset_teams'] = 'Kurssin nollauksen tiimi-/ryhmätoiminnot';
$string['settings_course_reset_teams_details'] = 'Toiminnot, jotka suoritetaan kurssiin yhdistetylle tiimille tai ryhmälle, kun kurssi nollataan.';
$string['settings_course_reset_teams_option_do_nothing'] = 'Älä tee mitään<br/>Tiimi tai ryhmä pysyy yhdistettynä kurssiin. Käyttäjien kurssirekisteröitymisen poistaminen poistaa heidät tiimin tai ryhmän jäsenyydestä.';
$string['settings_course_reset_teams_option_per_course'] = 'Salli kurssikohtaiset asetukset<br/>Tämä edellyttää, että Microsoft-lohko on lisätty kurssille. Käyttäjät, joilla on oikeus nollata kurssi, voivat valita lohkossa, mitä kurssin nollauksen yhteydessä tehdään.';
$string['settings_course_reset_teams_option_force_archive'] = 'Katkaise kurssin yhteys tiimiin tai ryhmään ja luo uusi<br/>Kurssiin yhdistetty nykyinen tiimi tai ryhmä nimetään uudelleen määritysten mukaisesti. Jos kurssiin on yhdistetty tiimi, se arkistoidaan. Uusi tiimi tai ryhmä luodaan ja yhdistetään kurssiin.';
$string['settings_course_reset_teams_option_archive_only'] = 'Katkaise vain kurssin yhteys tiimiin tai ryhmään<br />Kurssiin yhdistetty nykyinen tiimi tai ryhmä nimetään uudelleen määritysten mukaisesti. Jos kurssiin on yhdistetty tiimi, se arkistoidaan. Uutta tiimiä tai ryhmää ei luoda.';
$string['settings_reset_team_name_prefix'] = 'Nollatun tiimin nimen etuliite';
$string['settings_reset_team_name_prefix_details'] = 'Kun tiimiin yhdistetty kurssi nollataan, nykyisen yhdistetyn tiimin nimen alkuun lisätään tämä etuliite.';
$string['settings_reset_group_name_prefix'] = 'Nollatun ryhmän nimen etuliite';
$string['settings_reset_group_name_prefix_details'] = 'Kun ryhmään yhdistetty kurssi nollataan, nykyisen ryhmän nimen alkuun lisätään tämä etuliite.';
$string['settings_calsync_courseeventmode'] = 'Outlook-tapahtumat kurssin kalenteritapahtumille';
$string['settings_calsync_courseeventmode_details'] = 'Määrittää, miten Moodlen kurssikalenterin tapahtuma luodaan Outlookiin käyttäjille, jotka ovat tilanneet kurssin kalenterin.
<ul>
<li><strong>Yksi jaettu tapahtuma, jonka osallistujina ovat kurssin käyttäjät:</strong> Moodle-tapahtuman luoneen käyttäjän Outlook-kalenteriin (tai kurssin Microsoft 365 -ryhmän kalenteriin, jos kurssi on linkitetty ryhmään) luodaan yksi tapahtuma, johon kurssin käyttäjät lisätään osallistujiksi.</li>
<li><strong>Yksi erillinen tapahtuma käyttäjää kohden:</strong> jokaisen tilaajan omaan Outlook-kalenteriin luodaan suoraan erillinen tapahtuma. Jaettua tapahtumaa tai osallistujaluetteloa ei ole, eikä Microsoft 365 -ryhmän kalenteriin lisätä mitään.</li>
</ul>
Tämän asetuksen muuttaminen vaikuttaa vain sen jälkeen synkronoitaviin tapahtumiin; Outlookissa jo olevia tapahtumia ei muunneta.';
$string['settings_calsync_courseeventmode_shared'] = 'Yksi jaettu tapahtuma, jonka osallistujina ovat kurssin käyttäjät';
$string['settings_calsync_courseeventmode_individual'] = 'Yksi erillinen tapahtuma käyttäjää kohden';
$string['settings_debugmode'] = 'Kirjaa virheenkorjausviestit';
$string['settings_debugmode_details'] = 'Jos asetus on käytössä, Moodlen lokiin kirjataan tietoja, jotka voivat auttaa ongelmien tunnistamisessa. <a href="{$a}">Näytä kirjatut lokiviestit.</a>';
$string['settings_switchauthminupnsplit0'] = 'Microsoft 365:een vaihdettavan epätarkan käyttäjätunnuksen vähimmäispituus';
$string['settings_switchauthminupnsplit0_details'] = 'Jos otat käyttöön asetuksen "Vaihda yhdistettyjen käyttäjien todennustavaksi Microsoft 365 (OpenID Connect)", tämä määrittää vaihdettavien käyttäjätunnusten vähimmäispituuden ilman vuokraajaosaa (@example.onmicrosoft.com). Näin vältetään yleisnimisten tilien, kuten "admin", vaihtaminen, sillä ne eivät välttämättä ole samoja Moodlessa ja Microsoft Entra ID:ssä. Aseta arvoksi 0, jos haluat vaihtaa yhdistetyt käyttäjät käyttäjätunnuksen pituudesta riippumatta. Käyttäjät, joiden todennustapaa ei vaihdettu tämän asetuksen vuoksi, kirjataan synkronointitehtävän tulosteeseen ilmoituksella "Matched user, but the username is not an exact match to the Microsoft Entra ID UPN and does not meet the exact-match requirements for switching to OIDC...", ja ne näkyvät Hallitse käyttäjäyhteyksiä -sivulla tilassa "Matched with existing user - Awaiting completion".';
$string['settings_customtheme'] = 'Mukautettu teema (edistynyt)';
$string['settings_customtheme_desc'] = 'Suositeltu teema on "boost_o365teams". Voit kuitenkin valita toisen teeman, jos sinulla on mukautettu teema, joka on sovitettu käytettäväksi Teams-välilehdellä.<br/>
Huomaa, että kurssi- tai kategoriatasolla määritetty mukautettu teema ohittaa tässä tehdyt asetukset, eli kurssi käyttää Teamsin Moodle-sovelluksessa oletusarvoisesti kurssin tai kategorian teemaa. Tämän voi korjata päivittämällä config.php-tiedoston $CFG->themeorder-arvoksi "array(\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\');".';

// Settings in the "SDS sync" tab.
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>Tämä on esikatselutoiminto</b><br />Esikatselutoiminnot eivät välttämättä toimi tarkoitetulla tavalla tai voivat lakata toimimasta ilman varoitusta. Etene varoen.</div>';
$string['settings_sds_intro_desc'] = 'Microsoft School Data Sync ("SDS") yksinkertaistaa luokkien hallintaa Microsoft 365:ssä lukemalla nimilistat ulkoisesta opiskelijahallintojärjestelmästä (SIS) ja luomalla luokkia ja ryhmiä Microsoft 365:een. <a href="https://sds.microsoft.com/" target="_blank">Lue lisää</a><br/>
<br/>
SDS-synkronointitoiminto pystyy synkronoimaan nimilistatiedot SDS:stä Moodleen, mukaan lukien luokat, opettajat ja opiskelijat.<br/>
<br/>
SDS-synkronointitoiminnon käyttö edellyttää, että integraatiossa käytetyllä Microsoft Entra ID -sovelluksella on Microsoft Graph -sovelluskäyttöoikeudet <b>EduRoster.Read.All</b> ja <b>Member.Read.Hidden</b>, joita oletusmääritys ei lisää automaattisesti. Niille on myös annettava järjestelmänvalvojan suostumus.<br/>
<br/>
Oletusarvoisesti SDS-synkronointi suoritetaan päivittäin Moodlen cron-prosessissa klo 3 palvelimen aikaa. Voit muuttaa aikataulua <a href="{$a}">ajastettujen tehtävien hallintasivulla.</a><br/><br/>';
$string['settings_sds_coursecreation'] = 'Luokkien synkronointi kursseiksi';
$string['settings_sds_coursecreation_desc'] = 'Nämä asetukset ohjaavat Moodle-kurssien luomista SDS-koulujen luokkien perusteella.';
$string['settings_sds_coursecreation_enabled'] = 'Synkronoidut koulut';
$string['settings_sds_coursecreation_enabled_desc'] = 'Luo kurssit näiden koulujen luokille.';
$string['settings_sds_teams_enabled'] = 'Onko SDS-luokilla jo tiimit?';
$string['settings_sds_teams_enabled_desc'] = 'Valitse tämä, jos SDS-määritys on jo luonut SDS-luokille tiimit. Jos valittuna, Moodle ei yritä luoda tiimejä SDS-luokista luoduista Moodle-kursseista ristiriitojen välttämiseksi.';
$string['settings_sds_courseenrolsync'] = 'Kurssirekisteröintien synkronointi';
$string['settings_sds_courseenrolsync_desc'] = 'Nämä asetukset ohjaavat kurssirekisteröintien synkronointia SDS-koulujen luokista.';
$string['settings_sds_enrolment_enabled'] = 'Synkronoi rekisteröinnit SDS:stä Moodleen';
$string['settings_sds_enrolment_enabled_desc'] = 'Kun asetus on käytössä, SDS-synkronoinnin ajastettu tehtävä rekisteröi SDS-luokkien opettajat ja opiskelijat vastaaville Moodle-kursseille ja poistaa käyttäjät, jotka eivät enää ole SDS-luokassa. Edellyttää, että asetukset <b>SDS-luokan opettajan rooli Moodlessa</b> ja <b>SDS-luokan opiskelijan rooli Moodlessa</b> on määritetty.';
$string['settings_sds_sync_enrolment_to_sds'] = 'Synkronoi rekisteröinnit Moodlesta SDS:ään';
$string['settings_sds_sync_enrolment_to_sds_desc'] = 'Kun asetus on käytössä, SDS-luokkiin yhdistetyillä Moodle-kursseilla tehdyt rekisteröintimuutokset synkronoidaan takaisin SDS-luokkiin. Käyttäjän omistajuus-/jäsenyystila SDS:ssä määräytyy kurssikontekstin "local/o365:teamowner"- ja "local/o365:teammember"-oikeuksien perusteella.';
$string['settings_sds_suspend_enrolment'] = 'Jäädytä käyttäjien rekisteröinnit rekisteröinnin poistamisen sijaan';
$string['settings_sds_suspend_enrolment_desc'] = 'Kun tämä asetus on käytössä, SDS-luokasta poistettujen käyttäjien rekisteröinti yhdistetylle Moodle-kurssille jäädytetään sen sijaan, että rekisteröinti poistettaisiin kokonaan. Näin käyttäjän tiedot, kuten arvosanat, palautukset ja aktiviteettien suoritukset, säilyvät. Kun käyttäjät lisätään takaisin SDS-luokkaan, heidän rekisteröintinsä aktivoidaan automaattisesti uudelleen.<br />
<b>Huomautus:</b> SDS-synkronointi ei koskaan jäädytä opettajia eikä poista heidän rekisteröintiään. Tämä asetus koskee vain opiskelijoita.';
$string['settings_sds_enable_course_sync'] = 'Ota kaksisuuntainen kurssien synkronointi käyttöön';
$string['settings_sds_enable_course_sync_desc'] = 'Kun asetus on käytössä, jokainen SDS-luokasta luotu Moodle-kurssi linkitetään tietokannassa sen Microsoft 365 -ryhmään, mikä aktivoi kurssille täyden Microsoft 365 -kurssisynkronoinnin integraation (Teams, tiedostot, kalenteri jne.). Jos SDS-luokalla on jo tiimi, luodaan myös Teams-liitostietue.';
$string['settings_sds_course_field_mailnickname'] = 'Sähköpostin lempinimi (mailNickname)';
$string['settings_sds_course_field_displayname'] = 'Näyttönimi (displayName)';
$string['settings_sds_course_field_classcode'] = 'Luokkakoodi (classCode)';
$string['settings_sds_course_field_externalname'] = 'Ulkoinen nimi (externalName)';
$string['settings_sds_course_shortname_field'] = 'Kurssin lyhyen nimen lähde';
$string['settings_sds_course_shortname_field_desc'] = 'SDS-luokan ominaisuus, jota käytetään uusien Moodle-kurssien lyhyenä nimenä. Moodle edellyttää, että kurssien lyhyet nimet ovat yksilöllisiä. Jos valittu ominaisuus on tyhjä tai sen arvo on jo toiseen SDS-luokkaan linkitetyn kurssin käytössä, käytetään sen sijaan sähköpostin lempinimeä. Tämän asetuksen muuttaminen ei nimeä uudelleen jo luotuja kursseja.';
$string['settings_sds_course_fullname_field'] = 'Kurssin koko nimen lähde';
$string['settings_sds_course_fullname_field_desc'] = 'SDS-luokan ominaisuus, jota käytetään uusien Moodle-kurssien koko nimenä. Jos valittu ominaisuus on tyhjä, käytetään sen sijaan näyttönimeä. Tämän asetuksen muuttaminen ei nimeä uudelleen jo luotuja kursseja.';
$string['settings_sds_categorize_by_subject'] = 'Luokittele kurssit oppiaineen mukaan';
$string['settings_sds_categorize_by_subject_desc'] = 'Kun asetus on käytössä, kurssit järjestetään oppiainekohtaisiin kategorioihin kunkin koulun kategorian sisällä. Oppiaineen nimi poimitaan SDS:n luokkatiedoista. Kun asetus ei ole käytössä, kaikki kurssit sijoitetaan suoraan koulun kategoriaan.';
$string['settings_sds_ignore_past_courses'] = 'Ohita vanhentuneet/menneet luokat';
$string['settings_sds_ignore_past_courses_desc'] = 'Kun asetus on käytössä, vanhentuneet tai päättyneet luokat ohitetaan synkronoinnissa. Näitä ovat:<br />
<ul>
<li>Luokat, joiden nimessä on määritetty vanhentuneen luokan etuliite (oletus: "Exp")</li>
<li>Luokat, joiden päättymispäivä on menneisyydessä</li>
</ul>
Tämä auttaa pitämään kurssiluettelon siistinä, koska vanhoille tai arkistoiduille luokille ei luoda kursseja.';
$string['settings_sds_expired_course_prefix'] = 'Vanhentuneen luokan nimen etuliite';
$string['settings_sds_expired_course_prefix_desc'] = 'Luokat, joiden nimi alkaa tällä etuliitteellä, katsotaan vanhentuneiksi ja ohitetaan synkronoinnissa (jos "Ohita vanhentuneet/menneet luokat" on käytössä). Oletus: "Exp"';
$string['settings_sds_cohortsync'] = 'Kohorttien synkronointi';
$string['settings_sds_cohortsync_desc'] = 'Nämä asetukset ohjaavat kohorttien luomista ja synkronointia SDS-luokista. Kohortit tarjoavat vaihtoehtoisen tavan ryhmitellä käyttäjiä, ja niitä voidaan käyttää koko sivuston laajuisiin rekisteröinteihin tai muihin Moodlen toimintoihin.';
$string['settings_sds_create_cohorts'] = 'Luo kohortit SDS-luokista';
$string['settings_sds_create_cohorts_desc'] = 'Kun asetus on käytössä, jokaiselle SDS-luokalle luodaan kohortti, jonka jäsenyys pidetään synkronoituna SDS-luokan kanssa. Kohortit luodaan kurssikategorian kontekstiin (koulun tai oppiaineen kategoriaan luokitteluasetuksistasi riippuen).<br />
<b>Huomautus:</b> Kohortit luodaan kurssien lisäksi, ei niiden sijaan. Näin voit käyttää kohortteja koko sivuston laajuisiin rekisteröinteihin tai ryhmittelyyn ja säilyttää silti SDS:n kanssa synkronoidut kurssit.';
$string['settings_sds_cohort_include_teachers'] = 'Sisällytä opettajat kohortteihin';
$string['settings_sds_cohort_include_teachers_desc'] = 'Kun asetus on käytössä, SDS-luokan opettajat lisätään kohorttiin opiskelijoiden lisäksi. Kun asetus ei ole käytössä, kohortteihin lisätään vain opiskelijat.';
$string['settings_sds_enrolment_teacher_role'] = 'SDS-luokan opettajan rooli Moodlessa';
$string['settings_sds_enrolment_teacher_role_desc'] = 'Jos "Synkronoi rekisteröinnit SDS:stä Moodleen" on käytössä, SDS-luokan opettajat rekisteröidään yhdistetylle Moodle-kurssille tällä roolilla.';
$string['settings_sds_enrolment_student_role'] = 'SDS-luokan opiskelijan rooli Moodlessa';
$string['settings_sds_enrolment_student_role_desc'] = 'Jos "Synkronoi rekisteröinnit SDS:stä Moodleen" on käytössä, SDS-luokan opiskelijat rekisteröidään yhdistetylle Moodle-kurssille tällä roolilla.';
$string['settings_sds_profilesync_header'] = 'Käyttäjäprofiilien synkronointi';
$string['settings_sds_profilesync_header_desc'] = 'Jokainen SDS-koulu voi tallentaa koulun opettajien ja jäsenten käyttäjäprofiilin. Kentät ovat koulukohtaisia, eli eri kouluilla voi olla samassa kentässä eri arvot samalle käyttäjälle.<br/>
Jos tässä osiossa valitaan koulu, SDS-käyttäjäprofiilin kentät voidaan määrittää käyttäjäkenttien määrityksessä.
<ul>
<li>Huomaa, että SDS-kenttien synkronointi tapahtuu vain suoritettaessa ajastettua tehtävää "Synkronoi SDS:n kanssa", eikä sitä tapahdu suoritettaessa ajastettua tehtävää "Synkronoi käyttäjät Microsoft Entra ID:stä" tai käyttäjän kirjautuessa.</li>
<li>Huomaa, että tämän toiminnon käyttämässä Microsoft Graph API:ssa on tunnettu ongelma, jonka vuoksi tiettyjä opiskelijoiden ja opettajien kouluprofiilin kenttiä ei palauteta, joten niitä ei voi synkronoida, vaikka ne olisi määritetty.</li>
</ul>
';
$string['settings_sds_profilesync_disabled'] = 'Ei käytössä';
$string['settings_sds_profilesync'] = 'Synkronoi profiilitiedot koulusta';
$string['settings_sds_profilesync_desc'] = 'Valitse SDS-koulu, josta Moodle synkronoi SDS-kohtaiset profiilitiedot.';
$string['settings_sds_noschools'] = '<div class="alert alert-info">SDS:ssä ei ole käytettävissäsi yhtään koulua.</div>';
$string['settings_sds_get_schools_error'] = '<div class="alert alert-info error">SDS-koulujen hakeminen epäonnistui. Tarkista, että Microsoft Entra ID -sovelluksella on tarvittavat käyttöoikeudet.</div>';
$string['settings_sds_school_disabled_action'] = 'Toiminto, kun koulun synkronointi poistetaan käytöstä';
$string['settings_sds_school_disabled_action_desc'] = 'Toiminto, joka suoritetaan jo yhdistetyille Moodle-kursseille, kun synkronointi poistetaan käytöstä SDS-koululta.';
$string['settings_sds_school_disabled_action_keep_connected'] = 'Pidä Moodle-kurssi yhdistettynä tiimiin';
$string['settings_sds_school_disabled_action_disconnect'] = 'Katkaise Moodle-kurssin yhteys tiimiin';
$string['settings_sds_school_unavailable'] = '{$a} (SDS-koulujen luettelo ei ole tällä hetkellä käytettävissä)';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner'] = '<a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teamsin</a> Moodle-sovelluksen avulla voit helposti käyttää Moodle-kurssejasi ja tehdä niiden parissa yhteistyötä Teamsissa.';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Määritä Moodle-sovellus Microsoft Teamsia varten</h4>';
$string['settings_moodlesettingssetup'] = 'Määritä Moodle';
$string['settings_check_moodle_settings'] = 'Tarkista Moodlen asetukset';
$string['settings_moodlesetup_checking'] = 'Tarkistetaan...';
$string['settings_notice_cookiesecureenabled'] = 'Vain suojatut evästeet otettiin käyttöön onnistuneesti';
$string['settings_notice_cookiesecurealreadyenabled'] = 'Vain suojatut evästeet oli jo käytössä';
$string['settings_notice_oidcenabled'] = 'OpenID Connect otettiin käyttöön onnistuneesti';
$string['settings_notice_oidcnotenabled'] = 'OpenID Connectia ei voitu ottaa käyttöön';
$string['settings_notice_oidcalreadyenabled'] = 'OpenID Connect oli jo käytössä';
$string['settings_notice_webservicesframealreadyenabled'] = 'Verkkopalvelut olivat jo käytössä ja kehysten upottaminen on myös sallittu';
$string['settings_notice_webservicesframeenabled'] = 'Verkkopalvelut otettiin käyttöön onnistuneesti ja kehysten upottaminen on nyt myös sallittu';
$string['settings_notice_restenabled'] = 'REST-protokolla otettiin käyttöön onnistuneesti';
$string['settings_notice_restnotenabled'] = 'REST-protokollaa ei voitu ottaa käyttöön';
$string['settings_notice_restalreadyenabled'] = 'REST-protokolla oli jo käytössä';
$string['settings_notice_o365serviceenabled'] = 'Microsoft 365 -verkkopalvelut otettiin käyttöön onnistuneesti';
$string['settings_notice_o365servicealreadyenabled'] = 'Microsoft 365 -verkkopalvelut olivat jo käytössä';
$string['settings_notice_createtokenallowed'] = 'Oikeus luoda verkkopalvelun avain myönnettiin';
$string['settings_notice_createtokenalreadyallowed'] = 'Oikeus luoda verkkopalvelun avain oli jo myönnetty';
$string['settings_notice_createtokennotallowed'] = 'Oikeuden myöntämisessä verkkopalvelun avaimen luomiseen ilmeni ongelma';
$string['settings_notice_restusageallowed'] = 'Oikeus käyttää REST-protokollaa myönnettiin';
$string['settings_notice_restusagealreadyallowed'] = 'Oikeus käyttää REST-protokollaa oli jo myönnetty';
$string['settings_notice_restusagenotallowed'] = 'Oikeuden myöntämisessä REST-protokollan käyttöön ilmeni ongelma';
$string['settings_moodlesettingssetup_details'] = 'Tämä varmistaa, että:
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>Vain suojatut evästeet on käytössä.</li>
<li>OpenID Connect on käytössä.</li>
<li>Kehysten upottaminen on käytössä.</li>
<li>Verkkopalvelut ovat käytössä.</li>
<li>REST-protokolla on käytössä.</li>
<li>Microsoft 365 -verkkopalvelut ovat käytössä.</li>
<li>Todennetulla käyttäjällä on oikeus luoda verkkopalvelun avain.</li>
<li>Todennetulla käyttäjällä on oikeus käyttää REST-protokollaa.</li>
</ul>';
$string['settings_teams_moodle_app_external_id'] = 'Moodle Teams -sovelluksen Microsoft-sovellustunnus';
$string['settings_teams_moodle_app_external_id_desc'] = 'Tämän tulee olla oletusarvo, ellei vuokraajassasi tarvita useita Moodle Teams -sovelluksia eri Moodle-sivustoihin yhdistämistä varten.';
$string['settings_teams_moodle_app_short_name'] = 'Teams-sovelluksen nimi';
$string['settings_teams_moodle_app_short_name_desc'] = 'Tämä voi olla oletusarvo, ellei vuokraajassasi tarvita useita Moodle Teams -sovelluksia eri Moodle-sivustoihin yhdistämistä varten.';
$string['settings_download_teams_tab_app_manifest'] = 'Lataa manifestitiedosto';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Tallenna kaikki muutokset ennen manifestin lataamista.';
$string['settings_publish_manifest_instruction'] = '<a href="https://learn.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Napsauta tästä</a>, niin saat ohjeet ladatun Moodle-sovelluksen manifestitiedoston julkaisemiseen kaikille Teamsin käyttäjille.';
$string['settings_teams_moodle_tab_name'] = 'Moodle-välilehden nimi Teamsissa';
$string['settings_teams_moodle_tab_name_desc'] = 'Tämä on Teamsin Moodle-välilehden nimi.';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'Moodle-sovelluksen tunnus';
$string['settings_moodle_app_id_desc'] = 'Teamsin sovellusluetteloihin ladatun Moodle-sovelluksen tunnus.<br/>
Jos asetus on määritetty, Moodle yrittää luoda Moodle-kurssiin linkittävän Moodle-välilehden luodun/yhdistetyn tiimin "General"-kanavalle.';
$string['settings_moodle_app_id_desc_auto_id'] = '<br/>
Automaattisesti tunnistettu arvo on "<span class="local_o365_settings_moodle_app_id">{$a}</span>".';
$string['settings_set_moodle_app_id_instruction'] = 'Löydät Moodle-sovelluksen tunnuksen manuaalisesti seuraavasti:
<ol>
<li>Lataa ladattu manifestitiedosto vuokraajasi Teams-sovellusluetteloon.</li>
<li>Etsi sovellus Teams-sovellusluettelosta.</li>
<li>Napsauta sovelluksen asetuskuvaketta, joka sijaitsee sovelluksen kuvan oikeassa yläkulmassa.</li>
<li>Valitse "Copy link".</li>
<li>Liitä kopioitu sisältö tekstieditoriin. Sen pitäisi sisältää URL-osoite, kuten https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
URL-osoitteen viimeinen osa, eli <span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>, on sovelluksen tunnus.';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Ota Outlook-kalenterin synkronointi käyttöön';
$string['calendar_user'] = 'Oma (käyttäjän) kalenteri';
$string['calendar_site'] = 'Sivuston kalenteri';
$string['personal_calendar'] = 'Henkilökohtainen';
$string['calendar_event'] = 'Näytä tiedot';
$string['eventcalendarsubscribed'] = 'Käyttäjä tilasi kalenterin';
$string['eventcalendarunsubscribed'] = 'Käyttäjä lopetti kalenterin tilauksen';

// Errors.
$string['erroracpauthoidcnotconfig'] = 'Määritä sovelluksen tunnistetiedot ensin auth_oidc-lisäosaan.';
$string['errorhttpclientbadtempfileloc'] = 'Väliaikaista sijaintia ei voitu avata tiedoston tallentamista varten.';
$string['errorhttpclientnofileinput'] = 'Tiedostoparametri puuttuu pyynnöstä httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Tunnusta ei voitu päivittää';
$string['errormfarequired'] = 'Microsoft vaatii monivaiheisen todennuksen, ennen kuin Moodle voi käyttää Microsoft 365 -tiliäsi. Kirjaudu ulos Moodlesta, kirjaudu sitten uudelleen sisään Microsoft 365 -tililläsi ja suorita monivaiheinen todennus.';
$string['errorgetapplicationtoken'] = 'Sovelluksen käyttöoikeustunnusta ei voitu hakea. Tarkista integraation määritykset.';
$string['erroracpapcantgettenant'] = 'Microsoft Entra -vuokraajaa ei voitu hakea, anna se manuaalisesti.';
$string['erroracpcantgettenant'] = 'OneDriven URL-osoitetta ei voitu hakea, anna se manuaalisesti.';
$string['errorprovisioningapp'] = 'Moodle-sovellusta ei voitu ottaa käyttöön tiimissä.';
$string['erroro365apibadcall'] = 'Virhe ohjelmointirajapinnan kutsussa.';
$string['erroro365apibadcall_message'] = 'Virhe ohjelmointirajapinnan kutsussa: {$a}';
$string['erroro365apiinvalidtoken'] = 'Tunnus on virheellinen tai vanhentunut.';
$string['erroro365apiinvalidmethod'] = 'API-kutsuun välitettiin virheellinen HttpMethod-ominaisuus';
$string['erroro365apinotimplemented'] = 'Tämä pitäisi korvata.';
$string['erroro365apinotoken'] = 'Määritetyn resurssin ja käyttäjän tunnus puuttuu, eikä sitä voitu hakea. Onko käyttäjän päivitystunnus vanhentunut?';
$string['errorusermatched'] = 'Microsoft 365 -tili "{$a->entraidupn}" on jo täsmätty Moodle-käyttäjään "{$a->username}". Viimeistele yhteys kirjautumalla ensin kyseisenä Moodle-käyttäjänä ja noudattamalla Microsoft-lohkon ohjeita.';
$string['errornodirectaccess'] = 'Suora pääsy sivulle on estetty';
$string['eventapifail'] = 'Ohjelmointirajapinnan virhe';
$string['errorunabletofindgraphapi'] = 'Microsoft Graph API:a ei löytynyt sovelluksesta.';
$string['erroremptyjwt'] = 'Tyhjä JWT-tunnus annettu';
$string['errornocachedjwks'] = 'Välimuistissa olevaa JWKS:ää ei löytynyt';
$string['errorfetchjwks'] = 'JWKS:n hakeminen Microsoftilta epäonnistui';
$string['errorinvalidjwks'] = 'Microsoftilta saatiin virheellisen muotoinen JWKS';
$string['errorjwtvalidation'] = 'JWT:n tarkistus epäonnistui';
$string['errorjwtinvalidissuer'] = 'JWT:n myöntäjän tarkistus epäonnistui';
$string['errorcannotgettoken'] = 'Sovelluksen tai järjestelmän käyttöoikeustunnusta ei voitu hakea.';
$string['errornotokenforsysmemuser'] = 'Järjestelmäkäyttäjälle ei ole saatavilla tunnusta. Suorita local_o365:n kuntotarkistus.';
$string['errornotoken'] = 'Käyttäjälle #{$a} ei ole saatavilla tunnusta';
$string['errornotokenforusersync'] = 'Käyttäjien synkronoinnille ei ole saatavilla tunnusta.';
$string['errornoapifound'] = 'Tunnisteella {$a} varustettua API:a ei löytynyt.';
$string['errornoresponsesavailable'] = 'Vastauksia ei ole saatavilla.';
$string['erroro365badphoto'] = 'Microsoft 365:stä saatiin virheellinen profiilikuva.';
$string['erroro365nophoto'] = 'Tällä käyttäjällä ei ole kuvaa Microsoft 365:ssä.';
$string['errorcannotgetapiclient'] = 'Graph API -asiakasta ei voitu hakea.';
$string['errorfailedtogetsecrets'] = 'Salaisuuksien hakeminen epäonnistui.';
$string['errorfailedtosendnotification'] = 'Ilmoitussähköpostin lähettäminen yhdelle tai useammalle vastaanottajalle epäonnistui.';
$string['errorsecretexpiryrecipientundeliverable'] = 'Yksi tai useampi määritetty salaisuuden vanhenemisilmoituksen vastaanottaja ei voi vastaanottaa sähköpostia (virheellinen osoite tai toimialue, jolla ei ole MX-/A-tietuetta): {$a}. Päivitä ilmoitusten vastaanottajat OpenID Connect -asetuksissa.';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Microsoft 365 -paikallinen lisäosa';
$string['privacy:metadata:local_o365_calidmap'] = 'Tietoja Microsoft 365 -kalenteritapahtumien ja Moodlen kalenteritapahtumien välisistä linkeistä.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'Tapahtuman omistavan käyttäjän tunnus.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'Tapahtuman alkuperä. Joko Moodle tai Microsoft 365.';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'Tapahtuman tunnus Outlookissa.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'Tapahtuman tunnus Moodlessa.';
$string['privacy:metadata:local_o365_calsub'] = 'Tietoja Moodlen ja Outlookin kalentereiden välisistä synkronointitilauksista';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'Moodle-käyttäjän tunnus, jolle tilaus kuuluu';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'Moodle-kalenterin tyyppi (site, course, user)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'Moodle-kalenterin liittyvä tunnus';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'Microsoft 365 -kalenterin tunnus';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Onko tämä ensisijainen kalenteri';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'Synkronoinnin toiminta (eli Moodlesta Outlookiin tai Outlookista Moodleen)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'Tilauksen luontiaika.';
$string['privacy:metadata:local_o365_connections'] = 'Tietoja Moodle- ja Microsoft 365 -käyttäjien välisistä yhteyksistä, joita ei ole vielä vahvistettu';
$string['privacy:metadata:local_o365_connections:muserid'] = 'Moodle-käyttäjän tunnus';
$string['privacy:metadata:local_o365_connections:entraidupn'] = 'Microsoft Entra ID -käyttäjän UPN.';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Vaihdetaanko käyttäjän todennustapa valmistuttaessa.';
$string['privacy:metadata:local_o365_token'] = 'Tietoja käyttäjien Microsoft 365 API -tunnuksista';
$string['privacy:metadata:local_o365_token:user_id'] = 'Moodle-käyttäjän tunnus';
$string['privacy:metadata:local_o365_token:scope'] = 'Tunnisteen laajuus.';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'Tunnisteen resurssi.';
$string['privacy:metadata:local_o365_token:token'] = 'Tunniste.';
$string['privacy:metadata:local_o365_token:expiry'] = 'Tunnisteen vanhenemisaika.';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'Päivitystunnus.';
$string['privacy:metadata:local_o365_objects'] = 'Tietoja Moodlen ja Microsoft 365:n objektien välisestä suhteesta';
$string['privacy:metadata:local_o365_objects:type'] = 'Objektin tyyppi (ryhmä, käyttäjä, kurssi jne.)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'Objektin alatyyppi.';
$string['privacy:metadata:local_o365_objects:objectid'] = 'Microsoft 365 -objektin tunnus';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'Objektin tunnus Moodlessa';
$string['privacy:metadata:local_o365_objects:o365name'] = 'Objektin ihmisen luettava nimi Microsoft 365:ssä';
$string['privacy:metadata:local_o365_objects:tenant'] = 'Vuokraaja, johon objekti kuuluu (monivuokraajaympäristöissä)';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Mahdolliset liittyvät metatiedot';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'Tietueen luontiaika.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'Tietueen muokkausaika.';
$string['privacy:metadata:local_o365_appassign'] = 'Tietoja Microsoft 365 -sovellusroolien määrityksistä';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'Moodle-käyttäjän tunnus';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Onko käyttäjä liitetty sovellukseen';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'Käyttäjän kuvan tunnus Microsoft 365:ssä';
$string['privacy:metadata:local_o365_appassign:photohash'] = 'Käyttäjän profiilikuvan tavujen SHA-256-tiiviste, tallennetaan kuvan muutosten havaitsemiseksi hakematta koko kuvaa uudelleen';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Milloin käyttäjän kuva päivitettiin viimeksi Microsoft 365:stä';
$string['privacy:metadata:local_o365_matchqueue'] = 'Tietoja Moodle-käyttäjien täsmäyksestä Microsoft 365 -käyttäjiin';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'Moodle-käyttäjän käyttäjätunnus.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'Microsoft 365 -käyttäjän käyttäjätunnus.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Vaihdetaanko käyttäjän todennustavaksi OpenID Connect, kun täsmäys tehdään';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Onko tietue käsitelty';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'Virheilmoitus (jos on)';
$string['privacy:metadata:preference:suspendedtime'] = 'Aika, jolloin käyttäjien synkronointi jäädytti käyttäjän, joko koska vastaava Microsoft Entra ID -tili poistettiin tai koska se poistettiin käytöstä.';
$string['privacy:metadata:local_o365_calsettings'] = 'Tietoja kalenterin synkronoinnin asetuksista';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'Moodle-käyttäjän tunnus';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'Kalenterin tunnus Microsoft 365:ssä';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'Tietueen luontiaika.';
$string['privacy:metadata:preference:calsync_initialised'] = 'Onko käyttäjän Outlook-kalenterin synkronoinnin valinnat alustettu, jotta niitä ei oteta automaattisesti käyttöön uudelleen.';

// Page "Microsoft 365 / Moodle Control Panel" in the Microsoft block.
$string['ucp_title'] = 'Microsoft 365 / Moodle -ohjauspaneeli';
$string['ucp_general_intro'] = 'Tässä kohdassa voit hallita Microsoft 365 -yhteyden asetuksia.';
$string['ucp_calsync_availcal'] = 'Käytettävissä olevat Moodle-kalenterit';
$string['ucp_calsync_title'] = 'Outlook-kalenterin synkronointi';
$string['ucp_calsync_desc'] = 'Valitut kalenterit synkronoidaan Moodlesta Outlookin kalenteriin.';
$string['ucp_connection_options'] = 'Yhteysasetukset:';
$string['ucp_connection_desc'] = 'Tässä voit määrittää, miten muodostat yhteyden Microsoft 365:een. Microsoft 365 -toimintojen käyttö edellyttää yhteyttä Microsoft 365 -tiliin. Yhteyden voi muodostaa jäljempänä kuvatulla tavalla.';
$string['ucp_connection_entraidlogin'] = 'Käytä Microsoft 365 -tunnistetietojasi Moodleen kirjautumiseen<br />';
$string['ucp_connection_entraidlogin_desc_authcode'] = 'Käyttäjätunnuksen ja salasanan antamisen sijaan Moodlen kirjautumissivulla näkyy osio "Kirjaudu käyttämällä tiliäsi palvelussa {$a}". Napsautat linkkiä ja sinut ohjataan Microsoft 365:een kirjautumista varten. Kun olet kirjautunut Microsoft 365:een onnistuneesti, palaat Moodleen ja sinut kirjataan sisään tilillesi.';
$string['ucp_connection_entraidlogin_start'] = 'Ala käyttää Microsoft 365:tä Moodleen kirjautumiseen.';
$string['ucp_connection_entraidlogin_stop'] = 'Lopeta Microsoft 365:n käyttö Moodleen kirjautumiseen.';
$string['ucp_connection_entraidlogin_active'] = 'Käytät Microsoft 365 -tiliä "{$a}" Moodleen kirjautumiseen.';
$string['ucp_connection_linked'] = 'Linkitä Moodle- ja Microsoft 365 -tilisi';
$string['ucp_connection_linked_desc'] = 'Moodle- ja Microsoft 365 -tilisi linkittäminen mahdollistaa Microsoft 365:n Moodle-toimintojen käytön muuttamatta tapaasi kirjautua Moodleen. <br />Alla olevaa linkkiä napsauttamalla siirryt Microsoft 365:een kertaluonteista kirjautumista varten, minkä jälkeen palaat tänne. Voit käyttää kaikkia Microsoft 365 -toimintoja tekemättä muita muutoksia Moodle-tiliisi - kirjaudut Moodleen kuten aina ennenkin.';
$string['ucp_connection_linked_active'] = 'Olet linkitetty Microsoft 365 -tiliin "{$a}".';
$string['ucp_connection_linked_start'] = 'Linkitä Moodle-tilisi Microsoft 365 -tiliin.';
$string['ucp_connection_linked_migrate'] = 'Vaihda linkitettyyn tiliin.';
$string['ucp_connection_linked_stop'] = 'Poista Moodle-tilisi linkitys Microsoft 365 -tiliin.';
$string['ucp_connection_disconnected'] = 'Et ole yhteydessä Microsoft 365:een.';
$string['ucp_features'] = 'Microsoft 365:n toiminnot';
$string['ucp_features_intro'] = 'Seuraavassa on luettelo Microsoft 365:n toiminnoista, joilla voit tehostaa Moodlen käyttöä.';
$string['ucp_features_intro_notconnected'] = ' Osa toiminnoista edellyttää Microsoft 365 -yhteyden muodostamista.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Microsoft 365 -yhteyden muodostaminen edellyttää, että otat yhteyttä sivuston ylläpitäjään.';
$string['ucp_index_calendar_title'] = 'Outlook-kalenterin synkronointi';
$string['ucp_index_calendar_desc'] = 'Voit synkronoida Moodlen ja Outlookin kalenterit. Voit viedä Moodle-kalenterin tapahtumat Outlookiin ja tuoda Outlook-tapahtumat Moodleen.';
$string['ucp_index_connection_title'] = 'Microsoft 365 -yhteyden asetukset';
$string['ucp_index_connection_desc'] = 'Määritä, miten muodostat yhteyden Microsoft 365:een.';
$string['ucp_index_connectionstatus_title'] = 'Yhteyden tila';
$string['ucp_index_connectionstatus_login'] = 'Kirjaudu napsauttamalla tästä.';
$string['ucp_index_connectionstatus_usinglogin'] = 'Käytät tällä hetkellä Microsoft 365:tä Moodleen kirjautumiseen.';
$string['ucp_index_connectionstatus_usinglinked'] = 'Olet linkitetty Microsoft 365 -tiliin.';
$string['ucp_index_connectionstatus_manage'] = 'Hallitse yhteyttä';
$string['ucp_index_connectionstatus_reconnect'] = 'Päivitä yhteys';
$string['ucp_index_connectionstatus_connected'] = 'Olet tällä hetkellä yhteydessä Microsoft 365:een';
$string['ucp_index_connectionstatus_matched'] = 'Sinut on täsmätty Microsoft 365 -käyttäjään <small>"{$a}"</small>. Viimeistele yhteys napsauttamalla alla olevaa linkkiä ja kirjautumalla Microsoft 365:een.';
$string['ucp_index_connectionstatus_notconnected'] = 'Microsoft 365 -yhteyttä ei tällä hetkellä ole muodostettu';
$string['ucp_notconnected'] = 'Muodosta Microsoft 365 -yhteys ennen tämän sivun avaamista.';
$string['ucp_status_enabled'] = 'Aktiivinen';
$string['ucp_status_disabled'] = 'Ei yhteyttä';
$string['ucp_syncwith_title'] = 'Synkronoitavan Outlook-kalenterin nimi:';
$string['ucp_syncdir_title'] = 'Synkronointitoiminta:';
$string['ucp_syncdir_out'] = 'Moodlesta Outlookiin';
$string['ucp_syncdir_in'] = 'Outlookista Moodleen';
$string['ucp_syncdir_both'] = 'Päivitä sekä Outlook että Moodle';
$string['ucp_o365accountconnected'] = 'Tämä Microsoft 365 -tili on jo yhdistetty toiseen Moodle-tiliin.';

// Tasks.
$string['task_calendarsyncin'] = 'Synkronoi Microsoft 365 -tapahtumat Moodleen';
$string['task_coursesync'] = 'Synkronoi Moodle-kurssit Microsoft Teamsiin';
$string['task_coursemembershipsync'] = 'Synkronoi Microsoft Teamsin omistajat ja jäsenet Moodle-kursseille';
$string['task_groupmembershipsync'] = 'Synkronoi Moodle-kurssien omistajat ja jäsenet Microsoft 365 -ryhmiin';
$string['task_sds_sync'] = 'Synkronoi SDS:n kanssa';
$string['task_syncusers'] = 'Synkronoi käyttäjät Microsoft Entra ID:stä';
$string['task_syncusersphotostimezones'] = 'Synkronoi käyttäjien kuvat ja aikavyöhykkeet Microsoft Entra ID:stä';
$string['task_calsyncautosubscribe'] = 'Ota kalenterin synkronointi automaattisesti käyttöön yhdistetyille käyttäjille';
$string['task_groupchannelsync'] = 'Luo Teams-kanavat Moodle-ryhmille ja synkronoi niiden jäsenet';
$string['task_groupchannelsyncgroup'] = 'Luo Moodle-ryhmän Teams-kanava ja synkronoi sen jäsenet';
$string['task_userenabledstatussync'] = 'Jäädytä/ota uudelleen käyttöön/poista käyttäjät Microsoft Entra ID:n tilan perusteella';
$string['task_processmatchqueue'] = 'Käsittele täsmäysjono';
$string['task_notifysecretexpiry'] = 'Ilmoita sivuston ylläpitäjälle Microsoft Entra ID -sovelluksen salaisuuden vanhenemisesta';
$string['task_checkinvalidconfiglog'] = 'Tarkista ja siivoa virheelliset asetusten lokitietueet';
$string['task_usergroupmembershipsync'] = 'Synkronoi käyttäjän kurssiryhmäjäsenyys Microsoft 365:een';
$string['task_processmatchqueue_err_museralreadymatched'] = 'Moodle-käyttäjä on jo täsmätty Microsoft 365 -käyttäjään.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'Moodle-käyttäjä on jo yhdistetty Microsoft 365:een.';
$string['task_processmatchqueue_err_nomuser'] = 'Tällä käyttäjätunnuksella ei löytynyt Moodle-käyttäjää.';
$string['task_processmatchqueue_err_noo365user'] = 'Tällä käyttäjätunnuksella ei löytynyt Microsoft 365 -käyttäjää.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'Microsoft 365 -käyttäjä on jo täsmätty Moodle-käyttäjään.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'Microsoft 365 -käyttäjä on jo yhdistetty Moodle-käyttäjään.';

// Capabilities.
$string['o365:manageconnectionlink'] = 'Hallitse yhteyden linkitystä';
$string['o365:manageconnectionunlink'] = 'Hallitse yhteyden linkityksen poistoa';
$string['o365:managecoursesync'] = 'Ota Teams-synkronointi käyttöön tai poista se käytöstä kursseilla verkkopalvelujen kautta';
$string['o365:viewgroups'] = 'Näytä linkit Microsoft 365 -palveluihin Microsoft-lohkossa kursseilla, joilla synkronointi on käytössä';
$string['o365:managegroups'] = 'Näytä linkit Microsoft 365 -palveluihin ja hallinta-asetukset Microsoft-lohkossa kursseilla, joilla synkronointi on käytössä';
$string['o365:teammember'] = 'Tiimin jäsen';
$string['o365:teamowner'] = 'Tiimin omistaja';

// Cache Stores.
$string['cachedef_groups'] = 'Tallentaa Microsoft 365 -ryhmien tietoja';
$string['cachedef_jwks'] = 'Tallentaa Microsoftin JWKS-avaimet';

// Web service errors.
$string['webservices_error_assignnotfound'] = 'Vastaanotetun moduulin tehtävätietuetta ei löytynyt.';
$string['webservices_error_invalidassignment'] = 'Vastaanotettua tehtävän tunnusta ei voi käyttää tämän verkkopalvelun toiminnon kanssa.';
$string['webservices_error_modulenotfound'] = 'Vastaanotettua moduulin tunnusta ei löytynyt.';
$string['webservices_error_sectionnotfound'] = 'Kurssin osiota ei löytynyt.';
$string['webservices_error_couldnotsavegrade'] = 'Arvosanaa ei voitu tallentaa.';

// User sync task help text.
$string['help_user_create'] = 'Tilien luonnin ohje';
$string['help_user_create_help'] = 'Tämä luo Moodleen käyttäjän jokaisesta linkitetyn Microsoft Entra ID:n käyttäjästä. Tilit luodaan vain käyttäjille, joilla ei vielä ole Moodle-tiliä. Uudet tilit määritetään käyttämään OpenID Connect -todennustapaa Microsoft Entra ID -profiilin avulla, ja ne voivat käyttää kaikkia Microsoft 365:n ja Moodlen integraatiotoimintoja.';
$string['help_user_update'] = 'Kaikkien tilien päivityksen ohje';
$string['help_user_update_help'] = 'Tämä päivittää kaikki Moodlen käyttäjät linkitetyn Microsoft Entra ID:n vastaavien käyttäjien tiedoilla.';
$string['help_user_suspend'] = 'Tilien jäädytyksen ohje';
$string['help_user_suspend_help'] = 'Tämä jäädyttää käyttäjät Moodlessa, jos ne on merkitty poistetuiksi Microsoft Entra ID:ssä.';
$string['help_user_delete'] = 'Tilien poiston ohje';
$string['help_user_delete_help'] = 'Tämä poistaa käyttäjät Moodlesta, jos ne on merkitty poistetuiksi Microsoft Entra ID:ssä. Tämä toimii vain, jos käyttäjien jäädytysasetus on käytössä. Moodle-tili poistetaan ja kaikki siihen liittyvät käyttäjätiedot poistetaan Moodlesta. Ole varovainen! Huomautus: Oletusarvoisesti poisto tapahtuu 30 päivää sen jälkeen, kun tili poistettiin Microsoft Entra ID:ssä, koska Entra ID:n pehmeän poiston säilytysaika on tämä (tilit voi palauttaa tänä aikana). Pidempi viive jäädytyksen ja poiston välille voidaan määrittää asetuksella "Viive ennen jäädytettyjen käyttäjien poistamista".';
$string['help_user_reenable'] = 'Tilien uudelleenkäyttöönoton ohje';
$string['help_user_reenable_help'] = 'Tämä ottaa jäädytetyt Moodle-tilit uudelleen käyttöön, jos ne palautuvat Microsoft Entra ID:stä ja niillä on lupa kirjautua sisään. Tilit, joiden kirjautuminen on estetty (poistettu käytöstä) Microsoft Entra ID:ssä, pysyvät jäädytettyinä.';
$string['help_user_disabledsyncsuspend'] = 'Tilien jäädytyksen käytöstä poiston yhteydessä ohje';
$string['help_user_disabledsyncsuspend_help'] = 'Tämä jäädyttää käyttäjät Moodlessa, jos heidän yhdistetyiltä Microsoft Entra ID -tileiltään on estetty kirjautuminen (poistettu käytöstä), vaikuttamatta siihen, otetaanko tilit automaattisesti uudelleen käyttöön, kun Microsoft Entra ID -tili otetaan uudelleen käyttöön. Hallitse sitä erikseen alla olevalla asetuksella "Ota tilit uudelleen käyttöön Moodlessa, kun ne otetaan uudelleen käyttöön Microsoft Entra ID:ssä".';
$string['help_user_groupsyncsuspend'] = 'Synkronointiryhmään kuulumattomien tilien jäädytyksen ohje';
$string['help_user_groupsyncsuspend_help'] = 'Tämä jäädyttää käyttäjät Moodlessa, jos he ovat edelleen aktiivisia Microsoft Entra ID:ssä mutta eivät ole "Käyttäjien synkronoinnin ryhmäsuodatin" -asetuksessa määritetyn ryhmän jäseniä tai omistajia. Tarkistus koskee vain nykyistä jäsenyyttä: se jäädyttää myös olemassa olevat synkronoidut käyttäjät, jotka eivät ole koskaan olleet ryhmässä, ei vain ryhmästä lähteneitä, joten tarkista ryhmäsi ennen tämän asetuksen käyttöönottoa. Tämä asetus on käytettävissä vain, kun käyttäjien synkronoinnin ryhmäsuodatin on määritetty. Massajäädytyksen välttämiseksi mitään ei jäädytetä, jos ryhmä todetaan tyhjäksi tai sen jäseniä ei voida hakea. Jäädytettyjä käyttäjiä ei oteta uudelleen käyttöön, kun he eivät ole ryhmässä.';
$string['help_user_disabledsyncreenable'] = 'Tilien uudelleenkäyttöönoton käyttöönoton yhteydessä ohje';
$string['help_user_disabledsyncreenable_help'] = 'Tämä poistaa jäädytyksen Moodlen jäädytetyiltä käyttäjiltä, jos heidän yhdistetyillä Microsoft Entra ID -tileillään on jälleen lupa kirjautua sisään (otettu käyttöön).';
$string['help_user_suspendnolink'] = 'Tilien, joilla ei ole Microsoft-linkitystä, jäädytyksen ohje';
$string['help_user_suspendnolink_help'] = 'Normaalisti yllä olevat jäädytys-/käytöstä poisto -asetukset koskevat vain tilejä, joilla on tallennettu Microsoft Entra ID -objektitietue (luotu, kun tili synkronoitiin tai yhdistettiin). Joillakin OpenID Connect -tileillä ei ole tällaista tietuetta - esimerkiksi ne yhdistettiin ennen kuin Microsoft Graph API määritettiin, tai tietue poistettiin yhteyden katkaisun tai "tyhjennä täsmätyt käyttäjät" -toiminnon seurauksena. Tämä asetus saa tilan tarkistustehtävän tarkistamaan myös nämä tilit vertaamalla Moodle-käyttäjätunnusta Entra ID:ssä määritettyyn sidonnan käyttäjätunnusväitteen arvoon.

Täsmätyt tilit, jotka puuttuvat Entra ID:stä tai on poistettu siellä käytöstä, <strong>vain jäädytetään</strong>: niitä ei koskaan poisteta (ilman tallennettua objektin tunnusta Entra ID:n pehmeän poiston säilytysaikaa ei voi tarkistaa) eikä niitä oteta koskaan automaattisesti uudelleen käyttöön. Vierastilit ohitetaan.

Tämä asetus toimii vain, kun OpenID Connectin sidonnan käyttäjätunnusväite on asetettu tiettyyn kenttään, joka voidaan hakea Entra ID:stä - "upn", "oid", "email" tai "samaccountname". Arvolla "auto" (jolloin käytettävä väite valitaan kirjautumiskohtaisesti ja voi vaihdella käyttäjien välillä) tai millä tahansa muulla väitteellä Moodle-käyttäjätunnusta ei voi luotettavasti täsmätä yhteen tiliin, eikä tämä asetus tee mitään.

Tarkista jäädytetyt käyttäjät ensimmäisen suorituskerran jälkeen: tämä asetus jäädyttää tilin, joka vaihdettiin manuaalisesti tähän todennustapaan ja joka ei koskaan ollut oikea Entra ID -käyttäjä.';
$string['help_user_match'] = 'Tilien täsmäyksen ohje';
$string['help_user_match_help'] = 'Tämä käy läpi jokaisen linkitetyn Microsoft Entra ID:n käyttäjän ja yrittää täsmätä hänet Moodlen käyttäjään. Täsmäys perustuu Microsoft Entra ID:n UPN:ään ja Moodlen käyttäjätunnukseen. Täsmäys ei erota kirjainkokoa ja ohittaa Microsoft Entra ID:n UPN:n toimialueosan. Esimerkiksi Moodlen "BoB.SmiTh" täsmäisi arvoon "bob.smith@example.onmicrosoft.com". Täsmättyjen käyttäjien Moodle- ja Microsoft Entra ID -tilit yhdistetään, ja he voivat käyttää kaikkia Microsoft 365:n ja Moodlen integraatiotoimintoja. Käyttäjän todennustapa ei muutu, ellei alla olevaa asetusta oteta käyttöön.';
$string['help_user_matchswitchauth'] = 'Täsmättyjen tilien vaihdon ohje';
$string['help_user_matchswitchauth_help'] = 'Tämä edellyttää, että yllä oleva asetus "Yhdistä nykyiset Moodle-käyttäjät" on käytössä. Kun käyttäjä täsmätään, tämän asetuksen käyttöönotto vaihtaa hänen todennustavakseen OpenID Connectin. Tämän jälkeen hän voi kirjautua Moodleen Microsoft 365 -tunnistetiedoillaan. Huomautus: Varmista, että OpenID Connect -todennuslisäosa on otettu käyttöön, jos haluat käyttää tätä asetusta. Varoitus: jos Moodle-käyttäjätunnus vastaa vain Microsoft Entra ID:n UPN:n osaa ennen "@"-merkkiä (eikä koko UPN:ää), lisäasetus "Microsoft 365:een vaihdettavan epätarkan käyttäjätunnuksen vähimmäispituus" voi estää todennustavan vaihtamisen käyttäjille, joilla on lyhyt käyttäjätunnus.';
$string['help_user_appassign'] = 'Käyttäjien liittämisen sovellukseen ohje';
$string['help_user_appassign_help'] = 'Tämä liittää kaikki Microsoft Entra ID -tilit, joilla on vastaava Moodle-tili, tälle Moodle-asennukselle luotuun Microsoft Entra ID -sovellukseen, jos niitä ei ole jo liitetty.';
$string['help_user_photosync'] = 'Microsoft 365 -profiilikuvien synkronoinnin (cron) ohje';
$string['help_user_photosync_help'] = 'Tämä synkronoi kaikkien käyttäjien Moodle-profiilikuvat heidän Microsoft 365 -profiilikuviensa kanssa.';
$string['help_user_photosynconlogin'] = 'Microsoft 365 -profiilikuvien synkronoinnin (kirjautuminen) ohje';
$string['help_user_photosynconlogin_help'] = 'Tämä synkronoi käyttäjän Moodle-profiilikuvan hänen Microsoft 365 -profiilikuvansa kanssa, kun käyttäjä kirjautuu sisään. Huomaa, että tämä edellyttää, että käyttäjä avaa Moodlessa sivun, jolla on Microsoft-lohko.';
$string['help_user_nodelta'] = 'Täydellisen synkronoinnin ohje';
$string['help_user_nodelta_help'] = 'Oletusarvoisesti käyttäjien synkronointi synkronoi vain Microsoft Entra ID:n muutokset edellisen synkronoinnin jälkeen. Tämän asetuksen valitseminen pakottaa täydellisen käyttäjien synkronoinnin joka kerta.';
$string['help_user_emailsync'] = 'Microsoft Entra ID -käyttäjätunnusten synkronoinnin Moodlen sähköpostiosoitteisiin ohje';
$string['help_user_emailsync_help'] = 'Tämän asetuksen käyttöönotto yhdistää Microsoft Entra ID -käyttäjätunnukset Moodlen sähköpostiosoitteisiin oletustoiminnan sijaan, jossa Microsoft Entra ID -käyttäjätunnukset yhdistetään Moodlen käyttäjätunnuksiin.';
$string['help_user_tzsync'] = 'Outlookin aikavyöhykkeen synkronoinnin (cron) ohje';
$string['help_user_tzsync_help'] = 'Tämä synkronoi kaikkien käyttäjien Moodle-aikavyöhykkeen heidän Outlookin aikavyöhykeasetuksensa kanssa.';
$string['help_user_tzsynconlogin'] = 'Outlookin aikavyöhykkeen synkronoinnin (kirjautuminen) ohje';
$string['help_user_tzsynconlogin_help'] = 'Tämä synkronoi käyttäjän Moodle-aikavyöhykkeen hänen Outlookin aikavyöhykeasetuksensa kanssa. Huomaa, että tämä edellyttää, että käyttäjä avaa Moodlessa sivun, jolla on Microsoft-lohko.';
$string['help_user_guestsync'] = 'Vieraskäyttäjien synkronoinnin ohje';
$string['help_user_guestsync_help'] = 'Jos asetus on käytössä, Microsoft Entra ID:n vieraskäyttäjät synkronoidaan Moodleen käyttäjien synkronointitehtävässä.';

// Cohort sync feature.
$string['cohortsync_title'] = 'Kohorttien synkronointi';
$string['cohortsync_taskname'] = 'Kohorttien synkronointi';
$string['cohortsync_mappingadded'] = 'Uusi yhteys lisättiin onnistuneesti';
$string['cohortsync_mappingdeleted'] = 'Yhteys poistettiin onnistuneesti';
$string['cohortsync_addmapping'] = 'Lisää yhteys';
$string['cohortsync_deletemapping'] = 'Poista yhteys';
$string['cohortsync_desc'] = 'Tällä sivulla voit määrittää yksisuuntaisen synkronoinnin Microsoft 365 -ryhmistä Moodlen kohortteihin järjestelmätason kontekstissa. Uuden yhteyden lisääminen käynnistää synkronoinnin - valitun Microsoft 365 -ryhmän käyttäjät, jotka on yhdistetty Microsoftiin, lisätään valittuun Moodle-kohorttiin.';
$string['cohortsync_tabledesc'] = 'Microsoft 365 -ryhmien ja Moodle-kohorttien väliset nykyiset yhteydet';
$string['cohortsync_typetosearch'] = 'Kirjoita hakeaksesi Microsoft 365 -ryhmää';
$string['cohortsync_typetosearch_cohort'] = 'Kirjoita hakeaksesi Moodle-kohorttia';
$string['cohortsync_emptymatchings'] = 'Yhteyksiä ei löytynyt';
$string['cohortsync_select_cohort'] = 'Moodle-kohortti';
$string['cohortsync_select_group'] = 'Microsoft 365 -ryhmä';
$string['cohortsync_tablehead_group'] = 'Microsoft 365 -ryhmä';
$string['cohortsync_tablehead_cohort'] = 'Moodle-kohortti';
$string['cohortsync_tablehead_actions'] = 'Toiminnot';
$string['cohortsync_search'] = 'Hae';
$string['cohortsync_load_more'] = 'Lataa lisää...';
$string['cohortsync_no_groups_found'] = 'Microsoft 365 -ryhmiä ei löytynyt hakusanalla "{$a}"';
$string['cohortsync_no_cohorts_found'] = 'Moodle-kohortteja ei löytynyt hakusanalla "{$a}"';
$string['cohortsync_error_no_group'] = 'Valitse Microsoft 365 -ryhmä.';
$string['cohortsync_error_no_cohort'] = 'Valitse Moodle-kohortti.';
$string['cohortsync_mappingfailed'] = 'Virhe kohortin ja ryhmän välisen yhteyden lisäämisessä. Mahdollisia syitä: ryhmää tai kohorttia ei ole olemassa, ryhmä on jo yhdistetty toiseen kohorttiin tai ryhmä on jo yhdistetty tähän kohorttiin.';
$string['cohortsync_connectionnotfound'] = 'Virheellinen pyyntö: yhteyttä ei löytynyt.';
$string['cohortsync_connectionnotcohortsync'] = 'Virheellinen pyyntö: yhteyden tyyppi ei täsmää.';
$string['cohortsync_unifiedapierror'] = 'Virhe ryhmien luettelon hakemisessa Microsoftilta.';

// Course request.
$string['courserequest_teams'] = 'Microsoft-tiimi';
$string['courserequest_teams_help'] = 'Valitse Microsoft-tiimi, joka yhdistetään kurssiin. Tiimin nykyiset omistajat ja jäsenet rekisteröidään luotuun kurssiin, kun kurssipyyntö on hyväksytty.';
$string['courserequest_emptyteams'] = 'Microsoft Teams -tiimejä ei ole saatavilla';
$string['courserequest_title'] = 'Pyydä kurssi Teamsista';
$string['courserequest_updatecourserequeststatus_taskname'] = 'Päivitä kurssipyynnön tila';
$string['courserequest_customrequestnote'] = '
| Tämä pyyntö on tehty Microsoft Teamsin kurssipyyntösivulta, ja se yhdistetään hyväksynnän yhteydessä tiimiin: "{$a->name}", URL-osoite {$a->url}.';
$string['courserequest_graphapi_disabled'] = 'Microsoft Teams -yhteys ei ole käytettävissä. Ota yhteyttä sivuston ylläpitäjään.';
$string['courserequest_invalid_team'] = 'Kurssipyynnössä käytettiin virheellistä tiimiä.';
$string['courserequest_duplicate'] = 'Samasta tiimistä on jo odottava tai hyväksytty kurssipyyntö.';

// Teams page.
$string['teams_no_course'] = 'Sinulla ei ole lisättäviä kursseja.';
$string['tab_name'] = 'Välilehden nimi';
$string['sso_login'] = 'Kirjaudu Microsoft 365:een';
$string['other_login'] = 'Kirjaudu manuaalisesti';
$string['course_selector_label'] = 'Valitse olemassa oleva kurssi';

// Notifications to site admin about Microsoft Entra ID app secret.
$string['notification_subject_secret_expired'] = 'Toimenpide vaaditaan: Microsoft Entra ID -sovelluksen salaisuus on vanhentunut';
$string['notification_content_secret_expired'] = 'Hyvä sivuston ylläpitäjä,

Moodlen ja Microsoft 365:n integraatiossa käytetty Microsoft Entra ID -sovelluksen salaisuus on vanhentunut.
Luo uusi salaisuus Microsoft Entra ID:ssä ja päivitä se integraation määrityksiin integraation palauttamiseksi.';
$string['notification_subject_secret_almost_expired'] = 'Toimenpide vaaditaan: Microsoft Entra ID -sovelluksen salaisuus vanhenee pian';
$string['notification_content_secret_almost_expired'] = 'Hyvä sivuston ylläpitäjä,

Moodlen ja Microsoft 365:n integraatiossa käytetty Microsoft Entra ID -sovelluksen salaisuus vanhenee {$a} kuluttua.
Luo uusi salaisuus Microsoft Entra ID:ssä ja päivitä se integraation määrityksiin integraation häiriöiden välttämiseksi.';
$string['notification_days_less_than_one_day'] = 'alle 1 päivä';
$string['notification_days_one_day'] = '1 päivä';
$string['notification_days_days'] = '{$a} päivää';
$string['notification_subject_invalid_secret'] = 'Toimenpide vaaditaan: virheellinen Microsoft Entra ID -sovelluksen salaisuus löytyi';
$string['notification_content_invalid_secret'] = 'Hyvä sivuston ylläpitäjä,

Moodlen ja Microsoft 365:n integraatiossa käytetty Microsoft Entra ID -sovelluksen salaisuus vaikuttaa virheelliseltä. Syynä voi olla, että salaisuus on vanhentunut tai poistettu.
Tarkista salaisuus varmistaaksesi, että integraatio toimii odotetusti.';

// Async operations.
$string['teamsasyncfailed'] = 'Tiimin luonnin asynkroninen toiminto epäonnistui: {$a}';
$string['unknownasyncstate'] = 'Tuntematon asynkronisen toiminnon tila: {$a}';

// Template ID validation.
$string['error_template_id_empty'] = 'Mallin tunnus ei voi olla tyhjä.';
$string['error_not_connected'] = 'Ei yhteyttä Microsoft 365:een. Määritä ensin Microsoft 365 -integraatio.';
$string['error_graph_client_not_available'] = 'Microsoft Graph API:iin ei saada yhteyttä. Tarkista Microsoft 365 -integraation määritykset.';
$string['success_template_id_valid'] = '✓ Mallin tunnus "{$a}" on kelvollinen ja käytettävissä.';
$string['error_template_id_not_found'] = '✗ Mallin tunnusta "{$a}" ei löytynyt. Tarkista mallin tunnus Teams-hallintakeskuksessa.';
$string['error_template_validation_failed'] = '✗ Mallin tarkistus epäonnistui: {$a}';
$string['error_template_validation_error'] = '✗ Mallin tarkistuksessa tapahtui virhe. Yritä uudelleen tai ota yhteyttä ylläpitäjään.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
