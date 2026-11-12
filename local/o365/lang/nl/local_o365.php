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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Integratie met Microsoft 365';

// Settings - tabs.
$string['settings_pageheading'] = 'Configuratie van {$a}';
$string['settings_header_setup'] = 'Instellingen';
$string['settings_header_usersync'] = 'Gebruikerssynchronisatie';
$string['settings_header_coursesync'] = 'Cursussynchronisatie';
$string['settings_header_advanced'] = 'Geavanceerd';
$string['settings_header_sds'] = 'SDS-synchronisatie';
$string['settings_header_teams'] = 'Teams-instellingen';
$string['settings_header_moodle_app'] = 'Teams Moodle-app';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'Stap 1/2: Moodle registreren bij Microsoft Entra ID';
$string['settings_setup_step1_desc'] = 'Registreer een nieuwe Microsoft Entra ID-app voor de Moodle-integratie met behulp van PowerShell:

<a href="{$a}/local/o365/scripts/Moodle-EntraID-PowerShell.zip" class="btn btn-primary" target="_blank">PowerShell-script downloaden</a>

<p style="margin-top:10px"><a href="{$a}/local/o365/scripts/README.md" target="_blank">Klik hier</a> om de instructies voor het uitvoeren van het script te lezen.</p>
<p>Gebruik de volgende link als Moodle-URL wanneer daarom wordt gevraagd:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />Kopieer na het succesvol uitvoeren van het script de door het script geretourneerde toepassings-ID en het geheim naar de <a href="{$a}">configuratiepagina van de OpenID Connect-authenticatieplugin</a>.';
$string['settings_setup_step1_credentials_end'] = 'Als je de Microsoft Entra ID-app niet via PowerShell kunt instellen, <a href="{$a}" target="_blank">klik dan hier</a> voor instructies voor handmatige installatie.';
$string['settings_setup_step1_continue'] = '<b>Klik nadat je je toepassings-ID en geheim hebt ingevoerd onderaan de pagina op "Bewaar wijzigingen" om door te gaan.</b><br /><br /><br /><br /><br />';
$string['settings_setup_step1_existing_settings'] = '<h5>Bestaande instellingen</h5>';
$string['settings_setup_step2'] = 'Stap 2/2: Beheerderstoestemming &amp; aanvullende informatie';
$string['settings_setup_step2_desc'] = 'Met deze laatste stap kun je beheerderstoestemming geven voor het gebruik van enkele Microsoft Entra ID-machtigingen en worden aanvullende gegevens over je Microsoft 365-omgeving verzameld.<br /><br />';
$string['settings_setup_step3'] = 'Configuratie controleren';
$string['settings_setup_step3_desc'] = 'De configuratie is voltooid. Klik op de knop "Bijwerken" hieronder om je configuratie te controleren.';

// Settings in "Step 2/2" section of the "Setup" tab.
$string['settings_adminconsent'] = 'Beheerderstoestemming';
$string['settings_adminconsent_btn'] = 'Beheerderstoestemming geven';
$string['settings_adminconsent_details'] = 'Om toegang te geven tot enkele van de benodigde machtigingen moet een beheerder toestemming geven. Klik op deze knop en meld je aan met een Microsoft Entra ID-beheerdersaccount om toestemming te geven. Dit moet opnieuw gebeuren wanneer je "Beheerder"-machtigingen in Entra ID wijzigt.';
$string['settings_entratenant'] = 'Microsoft Entra-tenant';
$string['settings_entratenant_details'] = 'Wordt gebruikt om je organisatie binnen Microsoft te identificeren, bijvoorbeeld \'contoso.onmicrosoft.com\'.<br/>
Zo vind je deze waarde handmatig:
<ul>
<li>Ga naar de <a href="https://portal.azure.com" target="_blank">Azure Portal</a>.</li>
<li>Meld je aan met je beheerdersaccount.</li>
<li>Typ in de zoekbalk "Microsoft Entra ID" en ga naar de pagina "Microsoft Entra ID".</li>
<li>Gebruik de waarde in het veld <b>Primair domein</b> in de sectie "Basisinformatie".</li>
</ul>';
$string['settings_odburl'] = 'URL voor OneDrive voor Bedrijven';
$string['settings_odburl_details'] = 'De URL die wordt gebruikt om OneDrive voor Bedrijven te openen. Deze kan gewoonlijk worden bepaald aan de hand van je Microsoft Entra-tenant. Als je Microsoft Entra-tenant bijvoorbeeld "contoso.onmicrosoft.com" is, is het hoogstwaarschijnlijk "contoso-my.sharepoint.com". Voer alleen de domeinnaam in, zonder http:// of https://';
$string['settings_odburl_error_graph'] = 'We konden je URL voor OneDrive voor Bedrijven niet bepalen. Voer deze handmatig in. Deze kan gewoonlijk worden bepaald aan de hand van de URL die je gebruikt om OneDrive te openen.';
$string['settings_serviceresourceabstract_detect'] = 'Detecteren';
$string['settings_serviceresourceabstract_detecting'] = 'Detecteren...';
$string['settings_serviceresourceabstract_error'] = 'Er is een fout opgetreden bij het detecteren van de instelling. Stel deze handmatig in.';
$string['settings_serviceresourceabstract_valid'] = '{$a} is bruikbaar.';
$string['settings_serviceresourceabstract_invalid'] = 'Deze waarde lijkt niet bruikbaar.';
$string['settings_serviceresourceabstract_nocreds'] = 'Stel eerst toepassingsreferenties in.';
$string['settings_serviceresourceabstract_empty'] = 'Voer een waarde in of klik op Detecteren om te proberen de juiste waarde te detecteren.';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_verifysetup'] = 'Controleer de configuratie';
$string['settings_verifysetup_appdataheader'] = 'Microsoft Entra ID-appregistratie';
$string['settings_verifysetup_appdatadesc'] = 'Controleert of de juiste parameters zijn ingesteld in de Entra ID-app.';
$string['settings_verifysetup_appdatareplyurlcorrect'] = 'Antwoord-URL correct';
$string['settings_verifysetup_appdatareplyurlincorrect'] = 'Antwoord-URL onjuist';
$string['settings_verifysetup_appdatareplyurlgeneralerror'] = 'Kon de antwoord-URL niet controleren.';
$string['settings_verifysetup_appdatasignonurlcorrect'] = 'Aanmeld-URL correct.';
$string['settings_verifysetup_appdatasignonurlincorrect'] = 'Aanmeld-URL onjuist';
$string['settings_verifysetup_appdatasignonurlgeneralerror'] = 'Kon de aanmeld-URL niet controleren.';
$string['settings_verifysetup_apppermscorrect'] = 'Toepassingsmachtigingen zijn correct.';
$string['settings_verifysetup_details'] = 'Dit hulpprogramma controleert bij Microsoft Entra ID of alles correct is ingesteld. <br /><b>Opmerking:</b> Wijzigingen in de Microsoft Entra ID-app kunnen even duren voordat ze hier verschijnen. Als je een wijziging in de Microsoft Entra ID-app hebt aangebracht en deze hier niet ziet, wacht dan even en probeer het opnieuw.';
$string['settings_verifysetup_correctval'] = 'Juiste waarde:';
$string['settings_verifysetup_detectedval'] = 'Gedetecteerde waarde:';
$string['settings_verifysetup_update'] = 'Bijwerken';
$string['settings_verifysetup_checking'] = 'Controleren...';
$string['settings_verifysetup_missingappperms'] = 'Ontbrekende toepassingsmachtigingen:';
$string['settings_verifysetup_notgranted'] = 'toegevoegd aan de toepassing, maar er is geen beheerderstoestemming verleend';
$string['settings_verifysetup_missingperms'] = 'Ontbrekende gedelegeerde machtigingen:';
$string['settings_verifysetup_permscorrect'] = 'Gedelegeerde machtigingen zijn correct.';
$string['settings_verifysetup_errorcheck'] = 'Er is een fout opgetreden tijdens het controleren van de configuratie.';
$string['settings_verifysetup_noinfo'] = 'We hebben nog geen informatie over de configuratie van je Microsoft Entra ID-app. Klik op de knop Bijwerken om te controleren.';
$string['settings_verifysetup_strunifiedpermerror'] = 'Er is een fout opgetreden bij het controleren van de machtigingen voor de Microsoft Graph API.';
$string['settings_verifysetup_strtenanterror'] = 'Gebruik de knop Detecteren om je Microsoft Entra-tenant in te stellen voordat je de configuratie van de Microsoft Entra ID-app bijwerkt.';
$string['settings_verifysetup_unifiedheader'] = 'Microsoft Graph API';
$string['settings_verifysetup_unifieddesc'] = 'De Microsoft Graph API maakt communicatie tussen Moodle en Microsoft 365 mogelijk.';
$string['settings_verifysetup_unifiederror'] = 'Er is een fout opgetreden bij het controleren van de ondersteuning voor de Microsoft Graph API.';
$string['settings_verifysetup_unifiedactive'] = 'Microsoft Graph API actief.';
$string['settings_verifysetup_unifiedmissing'] = 'De Microsoft Graph API is niet gevonden in deze toepassing.';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc_credsvalid'] = 'Referenties zijn ingesteld.';
$string['settings_detectoidc_credsvalid_link'] = 'Wijzigen';
$string['settings_detectoidc_credsinvalid'] = 'Referenties zijn niet ingesteld of zijn onvolledig.';
$string['settings_detectoidc_credsinvalid_link'] = 'Referenties instellen';
$string['settings_detectperms_nocreds'] = 'Eerst moeten toepassingsreferenties worden ingesteld. Zie instelling hierboven.';
$string['settings_detectperms_errorfix'] = 'Er is een fout opgetreden tijdens het herstellen van machtigingen. Herstel deze handmatig in Microsoft Entra ID.';
$string['settings_detectperms_fixperms'] = 'Machtigingen herstellen';
$string['settings_detectperms_update'] = 'Bijwerken';
$string['settings_detectperms_valid'] = 'Machtigingen zijn ingesteld.';
$string['settings_detectperms_invalid'] = 'Machtigingen controleren in Microsoft Entra ID';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_usersync_general'] = 'Algemene gebruikerssynchronisatie';
$string['settings_usersync_suspension'] = 'Opschorting van Moodle-accounts';
$string['settings_usersync_matching'] = 'Gebruikers koppelen';
$string['settings_usersync_photos'] = 'Microsoft 365-profielfoto\'s synchroniseren naar Moodle';
$string['settings_usersync_timezone'] = 'Outlook-tijdzone synchroniseren naar Moodle';
$string['settings_usersync'] = 'Gebruikers synchroniseren met Microsoft Entra ID';
$string['settings_usersync_details'] = 'Als deze optie is ingeschakeld, synchroniseert Moodle gebruikers vanuit Microsoft Entra ID volgens bovenstaande opties.<br /><br /><b>Opmerking: </b>de synchronisatietaak wordt uitgevoerd in de Moodle-cron en synchroniseert 1000 gebruikers tegelijk. Standaard wordt deze taak eenmaal per dag uitgevoerd om 1:00 uur in de lokale tijdzone van je server. Als je grote sets gebruikers sneller wilt synchroniseren, kun je de frequentie van de taak <b>Gebruikers synchroniseren met Microsoft Entra ID</b> verhogen op de <a href="{$a}">beheerpagina Geplande taken.</a><br /><br />';
$string['settings_usersync_create'] = 'Accounts in Moodle maken voor gebruikers in Microsoft Entra ID';
$string['settings_usersync_update'] = 'Accounts in Moodle bijwerken voor gebruikers in Microsoft Entra ID';
$string['settings_usersync_suspend'] = 'Eerder gesynchroniseerde accounts in Moodle opschorten wanneer ze worden verwijderd uit Microsoft Entra ID';
$string['settings_usersync_delete'] = 'Eerder gesynchroniseerde accounts in Moodle verwijderen wanneer ze worden verwijderd uit Microsoft Entra ID';
$string['settings_usersync_reenable'] = 'Opgeschorte accounts opnieuw inschakelen voor gebruikers in Microsoft Entra ID';
$string['settings_usersync_disabledsyncsuspend'] = 'Accounts in Moodle opschorten wanneer ze zijn uitgeschakeld in Microsoft Entra ID';
$string['settings_usersync_disabledsyncreenable'] = 'Accounts in Moodle opnieuw inschakelen wanneer ze opnieuw zijn ingeschakeld in Microsoft Entra ID';
$string['settings_usersync_suspendnolink'] = 'Gekoppelde accounts zonder opgeslagen Microsoft-koppeling opschorten wanneer ze worden verwijderd uit of uitgeschakeld in Microsoft Entra ID';
$string['settings_usersync_groupsyncsuspend'] = 'Accounts in Moodle opschorten wanneer ze niet in de geconfigureerde groep voor gebruikerssynchronisatie zitten';
$string['settings_usersync_match'] = 'Vooraf bestaande Moodle-gebruikers koppelen aan gelijknamige accounts in Microsoft Entra ID';
$string['settings_usersync_matchswitchauth'] = 'Gekoppelde gebruikers overzetten naar Microsoft 365-authenticatie (OpenID Connect)';
$string['settings_usersync_appassign'] = 'Gebruikers tijdens de synchronisatie aan de toepassing toewijzen';
$string['settings_usersync_photosync'] = 'Microsoft 365-profielfoto\'s synchroniseren naar Moodle in de cronjob';
$string['settings_usersync_photosynconlogin'] = 'Microsoft 365-profielfoto\'s synchroniseren naar Moodle bij aanmelden';
$string['settings_usersync_nodelta'] = 'Bij elke uitvoering een volledige synchronisatie uitvoeren';
$string['settings_usersync_emailsync'] = 'Tijdens de synchronisatie Microsoft Entra ID-gebruikersnamen koppelen aan Moodle-e-mailadressen in plaats van Moodle-gebruikersnamen';
$string['settings_addsync_tzsync'] = 'Outlook-tijdzone synchroniseren naar Moodle in de cronjob';
$string['settings_addsync_tzsynconlogin'] = 'Outlook-tijdzone synchroniseren naar Moodle bij aanmelden';
$string['settings_usersync_guestsync'] = 'Gastgebruikers synchroniseren';
$string['settings_usersync_delete_delay'] = 'Wachttijd voordat opgeschorte gebruikers worden verwijderd';
$string['settings_usersync_delete_delay_desc'] = 'De minimale tijd dat een gebruiker in Moodle opgeschort moet blijven voordat de gebruikerssynchronisatie het account verwijdert. Dit komt bovenop de bewaartermijn voor voorlopig verwijderen van Microsoft Entra ID, zodat verwijdering nooit eerder plaatsvindt. Stel in op 0 om te verwijderen zodra de bewaartermijn van Microsoft Entra ID is verstreken. Gebruikers die al waren opgeschort voordat deze instelling werd geïntroduceerd, worden geteld vanaf de eerste uitvoering van de gebruikerssynchronisatie die ze aantreft.';
$string['settings_support_user_identifier_change'] = 'Wijziging van de waarde van de gebruikersnaamclaim voor de koppeling met een Microsoft-account ondersteunen';
$string['settings_support_user_identifier_change_desc'] = 'Als deze optie is ingeschakeld, probeert Moodle te reageren wanneer de waarde van de gebruikersnaamclaim voor de koppeling, normaal gesproken de UPN, van een Microsoft-account dat is gekoppeld aan een Moodle-account wordt gewijzigd.<br/>
<table class="flexible table table-striped table-hover generaltable generalbox table-sm">
    <tr>
        <th>Case-ID</th>
        <th>Is de gebruiker met de oude gebruikersnaam al aangemeld? (token aangemaakt)<br/>
        <span class="support_user_identifier_change_case_detail">Of een token is opgeslagen in de tabel auth_oidc_token</span>
        </th>
        <th>Eerste actie na hernoemen van de UPN<br/>
        <span class="support_user_identifier_change_case_detail">Aanmelden of uitvoering van de taak Gebruikerssynchronisatie</span>
        </th>
        <th>Mogelijk dubbele gebruikersnaam<br/>
        <span class="support_user_identifier_change_case_detail">Of hernoemen een conflict met een gebruikersnaam in Moodle zou veroorzaken</span>
        </th>
        <th>Verwacht gedrag</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Ja</td>
        <td>Aanmelden</td>
        <td>Nee</td>
        <td>
            <ol>
                <li>De Moodle-gebruiker wordt hernoemd.</li>
                <li>auth_oidc_token wordt bijgewerkt met nieuwe waarden voor zowel de velden "username" als "oidcusername".</li>
                <li>Het veld "o365name" van de gebruikersverbindingsrecord in local_o365_objects wordt bijgewerkt naar de nieuwe waarde.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Ja</td>
        <td>Gebruikerssynchronisatie</td>
        <td>Nee</td>
        <td>
            <ol>
                <li>De Moodle-gebruiker wordt hernoemd.</li>
                <li>De gebruikersverbindingsrecord in local_o365_objects wordt bijgewerkt.</li>
                <li>auth_oidc_token wordt bijgewerkt.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>Nee</td>
        <td>Aanmelden</td>
        <td>Nee</td>
        <td>
            <ol>
                <li>De Moodle-gebruiker wordt hernoemd.</li>
                <li>De gebruikersverbindingsrecord in local_o365_objects wordt bijgewerkt.</li>
                <li>auth_oidc_token wordt bijgewerkt.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>Nee</td>
        <td>Gebruikerssynchronisatie</td>
        <td>Nee</td>
        <td>
            <ol>
                <li>De Moodle-gebruiker wordt hernoemd.</li>
                <li>De gebruikersverbindingsrecord in local_o365_objects wordt bijgewerkt.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>Ja</td>
        <td>Aanmelden</td>
        <td>Ja</td>
        <td>
            <ol>
                <li>Er wordt een uitzondering gegenereerd en de Moodle-gebruiker wordt niet hernoemd.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>Ja</td>
        <td>Gebruikerssynchronisatie</td>
        <td>Ja</td>
        <td>
            <ol>
                <li>Er wordt een foutmelding weergegeven dat de poging tot hernoemen is mislukt tijdens de uitvoering van de taak Gebruikerssynchronisatie.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>Nee</td>
        <td>Aanmelden</td>
        <td>Ja</td>
        <td>
            <ol>
                <li>Er wordt een uitzondering gegenereerd en de Moodle-gebruiker wordt niet hernoemd.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>Nee</td>
        <td>Gebruikerssynchronisatie</td>
        <td>Ja</td>
        <td>
            <ol>
                <li>Er wordt een foutmelding weergegeven dat de poging tot hernoemen is mislukt tijdens de uitvoering van de taak Gebruikerssynchronisatie.</li>
            </ol>
        </td>
    </tr>
</table>
Er is een bekend probleem: als
<ol>
<li>Moodle en Microsoft 365 zijn gekoppeld via de verbindingsmethode "Microsoft identity platform (v2.0)", en</li>
<li>Microsoft Entra is geconfigureerd om "E-mailadres als alternatieve aanmeldings-ID" toe te staan, en</li>
<li>deze optie is ingeschakeld, en</li>
<li>de gebruikersnaam en het e-mailadres van het Microsoft-account verschillend zijn, en</li>
<li>de Microsoft-gebruiker zich aanmeldt met het e-mailadres in plaats van de gebruikersnaam</li>
</ol>
de auth_oidc-plugin het e-mailadres behandelt als de gebruikersnaam van het Microsoft-account en de Moodle-gebruikersnaam bijwerkt.';

// User field mapping.
$string['settings_fieldmap'] = 'Gebruikersveldtoewijzing';
$string['settings_fieldmap_details'] = 'Beschikbaar in de <a href="{$a}">OpenID Connect-authenticatieplugin</a>.';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'Cursussynchronisatie';
$string['settings_secthead_coursesync_desc'] = 'De volgende instellingen bepalen de cursussynchronisatie tussen Moodle en Microsoft Teams.';
$string['settings_coursesync'] = 'Cursussynchronisatie';
$string['settings_coursesync_details'] = 'Als deze optie is ingeschakeld, worden Teams voor cursussen op de Moodle-site aangemaakt en bijgehouden (standaard: uitgeschakeld). Hiermee worden bij elke cronrun de benodigde Teams aangemaakt en alle momenteel ingeschreven gebruikers toegevoegd als Team-eigenaar of -lid, afhankelijk van de controle op bevoegdheden. Daarna wordt het Team-lidmaatschap bijgehouden naarmate gebruikers worden ingeschreven voor of uitgeschreven uit Moodle-cursussen.';
$string['acp_coursesynccustom_off'] = 'Uitgeschakeld<br />Schakel het aanmaken van Teams voor alle cursussen uit.';
$string['acp_coursesynccustom_oncustom'] = 'Aanpassen<br />Staat bevoegde gebruikers toe te kiezen voor welke cursussen Teams worden aangemaakt.<br> <span id="adminsetting_coursesync" style="font-weight: bold"><a href="{$a}">Cursussynchronisatie aanpassen</a></span>';
$string['acp_coursesynccustom_onall'] = 'Alle functies ingeschakeld<br />Schakelt het aanmaken van Teams in voor alle cursussen.';
$string['settings_coursesync_sync_hidden_courses'] = 'Verborgen cursussen synchroniseren';
$string['settings_coursesync_sync_hidden_courses_desc'] = 'Standaard negeert de plugin verborgen cursussen om te voorkomen dat cursussen worden gesynchroniseerd die worden gekopieerd of hersteld. Schakel deze instelling in om het aanmaken van Teams voor verborgen cursussen af te dwingen.';
$string['acp_coursesync_hidden_course_note'] = 'Opmerking: Verborgen cursussen worden niet verwerkt voor het aanmaken van Teams-groepen. Om dit toe te staan, moet je de instelling "Verborgen cursussen synchroniseren" inschakelen in de pluginconfiguratie.';
$string['settings_coursesync_delete_group_on_course_deletion'] = 'Microsoft 365-groepen verwijderen wanneer de gekoppelde Moodle-cursus wordt verwijderd';
$string['settings_coursesync_delete_group_on_course_deletion_details'] = 'Als deze optie is ingeschakeld, probeert Moodle de Microsoft 365-groep (en het bijbehorende Team) te verwijderen wanneer de gekoppelde cursus uit Moodle wordt verwijderd. Dit geldt niet voor cursussen die zijn aangemaakt via SDS-synchronisatie.';
$string['settings_coursesync_delete_group_on_course_sync_disabled'] = 'Microsoft 365-groepen verwijderen wanneer cursussynchronisatie is uitgeschakeld';
$string['settings_coursesync_delete_group_on_course_sync_disabled_details'] = 'Als deze optie is ingeschakeld, probeert Moodle de gekoppelde Microsoft 365-groep (en het bijbehorende Team) te verwijderen wanneer cursussynchronisatie voor een Moodle-cursus wordt uitgeschakeld.';
$string['settings_coursesync_courses_per_task'] = 'Te synchroniseren cursussen per taakuitvoering';
$string['settings_coursesync_courses_per_task_details'] = 'Het aantal cursussen waarvan de Team-/groepssynchronisatiestatus bij elke taakuitvoering wordt verwerkt.';
$string['settings_coursesync_team_type'] = 'Team-sjabloon';
$string['settings_coursesync_team_type_desc'] = 'De Microsoft Teams-sjabloon die wordt gebruikt bij het aanmaken van Teams vanuit Moodle-cursussen. Onderwijssjablonen vereisen een onderwijslicentie. <br><br><strong>Belangrijk:</strong> De geconfigureerde sjabloon bepaalt hoe groepen en Teams worden aangemaakt:<br>
&bull; De standaardsjabloon maakt standaardgroepen en -Teams aan (compatibel met alle tenants).<br>
&bull; Onderwijssjablonen maken onderwijsgroepen/-Teams aan (alleen onderwijstenants; schakelt onderwijsspecifieke functies in).<br>
&bull; Aangepaste sjablonen gebruiken standaardgroepen (voor compatibiliteit met het ontwerp van de aangepaste sjabloon).<br><br>
<strong>⚠️ WAARSCHUWING: Zodra een Team met een bepaalde sjabloon is aangemaakt, kan de sjabloon niet meer worden gewijzigd.</strong> Teams blijven gekoppeld aan hun oorspronkelijke sjabloon. Het wijzigen van deze instelling heeft alleen effect op nieuw aangemaakte Teams, niet op bestaande. Plan je sjabloonkeuze zorgvuldig voordat je cursussynchronisatie inschakelt.';
$string['settings_coursesync_team_type_standard'] = 'Standaard';
$string['settings_coursesync_team_type_educationclass'] = 'Onderwijs - Klas-Team';
$string['settings_coursesync_team_type_educationstaff'] = 'Onderwijs - Personeels-Team';
$string['settings_coursesync_team_type_educationplc'] = 'Onderwijs - Professionele leergemeenschap (PLC)';
$string['settings_coursesync_team_type_custom'] = 'Aangepaste sjabloon';
$string['settings_coursesync_team_type_custom_id'] = 'ID van aangepaste sjabloon';
$string['settings_coursesync_team_type_custom_id_desc'] = 'De volledige ID van een aangepaste sjabloon die is gedefinieerd in het Teams-beheercentrum. Wordt alleen gebruikt wanneer hierboven "Aangepaste sjabloon" is geselecteerd. <br><br><strong>De sjabloon-ID moet de GUID-indeling hebben</strong> (bijv. e41de7bb-859a-4a0f-aa39-5725a0529c1c). Je vindt de sjabloon-ID in het Teams-beheercentrum wanneer je de details van je aangepaste sjabloon bekijkt. <br><br>
<strong>⚠️ EXTRA MICROSOFT ENTRA ID-MACHTIGING VEREIST:</strong> Voor het valideren en gebruiken van aangepaste Team-sjablonen is een extra toepassingsmachtiging voor de Microsoft Graph API vereist (<strong>TeamTemplates.Read.All</strong>) die mogelijk niet aanwezig is in je Microsoft Entra ID-appregistratie. Zonder deze machtiging mislukt de validatiestap en kan de ID van de aangepaste sjabloon niet worden ingesteld. Als de validatie mislukt met een machtigingsfout, neem dan contact op met je Microsoft Entra ID-beheerder om deze machtiging aan je appregistratie toe te voegen. <br><br>
<strong>⚠️ BELANGRIJKE BEPERKING:</strong> Het Microsoft Teams-framework ondersteunt het aanmaken van Teams vanuit aangepaste sjablonen momenteel alleen wanneer de sjabloon een <strong>en-US-landinstellingsdefinitie</strong> bevat. Aangepaste sjablonen zonder en-US-ondersteuning kunnen geen Teams aanmaken. Zorg ervoor dat je aangepaste sjabloon een en-US-landinstelling heeft gedefinieerd in het Teams-beheercentrum. <br><br>
<strong>⚠️ WAARSCHUWING: Zodra een Team met deze aangepaste sjabloon is aangemaakt, kan de sjabloon niet meer worden gewijzigd.</strong> Als je een andere aangepaste sjabloon voor nieuwe Teams wilt gebruiken, moet je deze instelling leeg laten of wijzigen vóór het aanmaken van het volgende Team. Bestaande Teams blijven hun oorspronkelijke sjabloon gebruiken. <br><br>
Teams worden niet correct aangemaakt als een onjuiste sjabloon-ID is geconfigureerd. Gebruik de knop "ID van aangepaste sjabloon valideren" om de sjabloon-ID te valideren voordat je cursussynchronisatie uitvoert.';
$string['error_custom_template_id_required'] = 'Een ID van een aangepaste sjabloon is vereist bij gebruik van de optie "Aangepaste sjabloon". Voer een geldige sjabloon-ID in.';
$string['error_custom_template_id_not_found'] = 'ID van aangepaste sjabloon "{$a}" niet gevonden. Controleer of de sjabloon-ID bestaat in het Teams-beheercentrum.';
$string['error_custom_template_id_validation_failed'] = 'Validatie van de ID van de aangepaste sjabloon mislukt. De sjabloon ondersteunt mogelijk het rechtstreeks aanmaken van Teams niet of er is een configuratieprobleem. Controleer de sjabloon-ID in het Teams-beheercentrum.';
$string['settings_team_type_custom_id_test_button'] = 'ID van aangepaste sjabloon valideren';
$string['settings_team_type_custom_id_validating'] = '🔄 Valideren...';
$string['settings_team_type_custom_id_error_empty'] = '⚠️ Voer eerst een sjabloon-ID in.';
$string['settings_team_type_custom_id_error_not_found'] = '✗ Sjabloon niet gevonden. De sjabloon-ID "{$a}" bestaat niet. Controleer deze in het Teams-beheercentrum.';
$string['settings_team_type_custom_id_error_validation'] = '✗ Validatiefout. {$a}';
$string['settings_team_type_custom_id_error_default'] = 'Het valideren van de sjabloon is mislukt. Probeer het opnieuw of neem contact op met je beheerder.';
$string['settings_team_type_custom_id_error_timeout'] = '✗ Time-out bij validatie. Het verzoek duurde langer dan 10 seconden. Probeer het opnieuw.';
$string['settings_team_type_custom_id_error_network'] = '✗ Netwerkfout. De validatieservice is niet bereikbaar. Controleer je internetverbinding en probeer het opnieuw.';
$string['settings_team_type_custom_id_error_parsererror'] = '✗ Fout in serverantwoord. De validatieservice heeft ongeldige gegevens geretourneerd. Controleer je Microsoft 365-integratie.';
$string['settings_team_type_custom_id_error_http'] = '✗ Validatiefout (HTTP {$a}). Probeer het opnieuw of neem contact op met je beheerder.';
$string['settings_coursesync_group_channels'] = 'Een kanaal aanmaken voor elke Moodle-groep';
$string['settings_coursesync_group_channels_details'] = 'Maak voor elke groep in de Moodle-cursus een privékanaal aan in het gekoppelde Microsoft Team en houd de leden van elk kanaal gelijk aan de leden van de Moodle-groep. Groepsleden die ook zijn gekoppeld aan Microsoft 365 worden aan het kanaal toegevoegd of eruit verwijderd wanneer ze aan de groep worden toegevoegd of eruit worden verwijderd. Iedereen die in Microsoft Teams aan een kanaal is toegevoegd maar geen lid is van de Moodle-groep, wordt weer verwijderd. In een onderwijsklas-Team dat nog niet is geactiveerd, kunnen leerlingen niet in kanalen worden geplaatst: alleen de eigenaars worden toegevoegd, en de leerlingen worden automatisch toegevoegd door de geplande taak "Teams-kanalen voor Moodle-groepen aanmaken en hun leden synchroniseren" nadat een eigenaar het Team in Microsoft Teams heeft geactiveerd. Kanalen worden niet hernoemd of verwijderd wanneer een Moodle-groep wordt hernoemd of verwijderd. Kanaallidmaatschap wordt alleen van Moodle naar Teams gesynchroniseerd en dit doet niets als "Gedrag van gebruikerssynchronisatie voor cursussen" is ingesteld op "Van Teams naar Moodle". Microsoft Teams staat maximaal 1.000 kanalen in een Team toe, inclusief privékanalen en kanalen die in de afgelopen 30 dagen zijn verwijderd.<br /><br /><b>Voor deze instelling zijn twee extra toepassingsmachtigingen voor Microsoft Graph nodig:</b><ul><li><b>Channel.Create</b> - om de kanalen aan te maken.</li><li><b>ChannelMember.ReadWrite.All</b> - om leden aan de kanalen toe te voegen en eruit te verwijderen.</li></ul>Beide moeten worden toegevoegd aan de Microsoft Entra ID-toepassing die door Moodle wordt gebruikt en er moet beheerderstoestemming voor worden verleend. Het PowerShell-script op het tabblad "Instellingen" bevat ze al wanneer het een nieuwe toepassing registreert. Voeg ze voor een bestaande toepassing handmatig toe via App-registraties &gt; je toepassing &gt; API-machtigingen &gt; Een machtiging toevoegen &gt; Microsoft Graph &gt; Toepassingsmachtigingen en verleen vervolgens beheerderstoestemming. Zolang deze instelling is ingeschakeld, meldt "Configuratie controleren" op het tabblad "Instellingen" deze machtigingen als ontbrekend totdat ze zijn verleend.';
$string['settings_coursesync_sync_direction'] = 'Gedrag van gebruikerssynchronisatie voor cursussen';
$string['settings_coursesync_sync_direction_details'] = 'Selecteer de richting waarin je de gebruikers tussen Moodle en Microsoft Teams wilt synchroniseren.';
$string['settings_coursesync_sync_moodle_to_teams'] = 'Van Moodle naar Teams';
$string['settings_coursesync_sync_teams_to_moodle'] = 'Van Teams naar Moodle';
$string['settings_coursesync_sync_both'] = 'Zowel Teams als Moodle bijwerken';
$string['settings_coursesync_enrolment_owner_role'] = 'Rol van Team-eigenaar';
$string['settings_coursesync_enrolment_owner_role_desc'] = 'De rol die tijdens de synchronisatie aan de Team-eigenaar wordt toegewezen.';
$string['settings_coursesync_enrolment_member_role'] = 'Rol van Team-lid';
$string['settings_coursesync_enrolment_member_role_desc'] = 'De rol die tijdens de synchronisatie aan de Team-leden wordt toegewezen.';

// Settings in the "Course sync customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_coursesynccustom'] = 'Aanpassing van cursussynchronisatie';
$string['acp_coursesynccustom_enabled'] = 'Ingeschakeld';
$string['acp_coursesynccustom_enable_all'] = 'Cursussynchronisatie inschakelen voor alle cursussen';
$string['acp_coursesynccustom_disable_all'] = 'Cursussynchronisatie uitschakelen voor alle cursussen';
$string['acp_coursesynccustom_bulk'] = 'Bulkbewerkingen';
$string['acp_coursesynccustom_bulk_enable'] = 'Cursussynchronisatie inschakelen voor cursussen op deze pagina';
$string['acp_coursesynccustom_bulk_disable'] = 'Cursussynchronisatie uitschakelen voor cursussen op deze pagina';
$string['acp_coursesynccustom_settings_header'] = 'Synchronisatieopties';
$string['acp_coursesynccustom_new_course'] = 'Standaard ingeschakeld voor nieuwe cursussen';
$string['acp_coursesynccustom_new_course_desc'] = 'Als deze optie is ingeschakeld, is synchronisatie standaard ingeschakeld voor alle nieuw aangemaakte cursussen.';
$string['acp_coursesynccustom_controlled_per_course'] = 'Configuratie van cursussynchronisatie in cursussen toestaan';
$string['acp_coursesynccustom_controlled_per_course_desc'] = 'Als deze optie is ingeschakeld, kunnen ingeschreven gebruikers in Moodle-cursussen die als Team-eigenaar kunnen optreden (met de bevoegdheid "Team-eigenaar" [local/o365:teamowner]) de cursussynchronisatie beheren via het Microsoft-blok in de cursus.';
$string['acp_coursesynccustom_savemessage'] = 'Je wijzigingen zijn opgeslagen.';
$string['acp_coursesynccustom_regex_search'] = 'Zoeken met reguliere expressie';
$string['acp_coursesynccustom_regex_search_title'] = 'Indien aangevinkt, wordt het zoekvak hierboven vergeleken als een PCRE-reguliere expressie (zonder scheidingstekens) met de volledige naam, korte naam en ID-nummer, in plaats van een gewone tekstzoekopdracht.';
$string['acp_coursesynccustom_confirm_all_action'] = 'Weet je zeker dat je de synchronisatiestatus van alle cursussen wilt wijzigen? Deze actie kan niet ongedaan worden gemaakt.';
$string['acp_coursesynccustom_sds_course'] = 'Vergrendeld voor SDS-cursus';
$string['acp_coursesynccustom_all_enabled_notice'] = 'Cursussynchronisatie is momenteel ingeschakeld voor alle cursussen. Aanpassing per cursus is uitgeschakeld omdat de modus "Alle functies ingeschakeld" actief is.';
$string['acp_coursesynccustom_disabled_notice'] = 'Cursussynchronisatie is momenteel globaal uitgeschakeld. Aanpassing per cursus is uitgeschakeld omdat de modus "Uitgeschakeld" actief is.';
$string['acp_coursesynccustom_categories_header'] = 'Synchroniseren per cursuscategorie';
$string['acp_coursesynccustom_categories_desc'] = 'Selecteer een of meer cursuscategorieën om cursussynchronisatie automatisch in te schakelen voor alle cursussen in die categorieën, inclusief hun subcategorieën. Dit geldt ook voor cursussen die later aan de geselecteerde categorieën worden toegevoegd. Houd Ctrl (Cmd op Mac) ingedrukt om meerdere categorieën te selecteren, of klik opnieuw terwijl je de toets ingedrukt houdt om de selectie ongedaan te maken.';
$string['acp_coursesynccustom_category_course'] = 'Vergrendeld: ingeschakeld via cursuscategorie';

// Settings in the "Cohort sync" section of the "Sync settings" tab.
$string['settings_secthead_cohortsync'] = 'Cohortsynchronisatie';
$string['settings_secthead_cohortsync_desc'] = 'Deze functie maakt synchronisatie mogelijk tussen Microsoft 365-groepen en Moodle-cohorten.';
$string['settings_cohortsync'] = 'Cohortsynchronisatie';
$string['settings_cohortsync_linktext'] = 'Cohortsynchronisatie beheren';
$string['settings_cohortsync_details'] = 'Bekijk en beheer de synchronisatie tussen Moodle-cohorten en Microsoft 365-groepen.';
$string['settings_cohortsync_title'] = 'Cohortsynchronisatie';
$string['settings_cohortsync_excludeowners'] = 'Groepseigenaars uitsluiten van cohortsynchronisatie';
$string['settings_cohortsync_excludeowners_desc'] = 'Als deze optie is ingeschakeld, worden groepseigenaars niet gesynchroniseerd naar Moodle-cohorten, ook niet als ze tevens groepslid zijn. Eigenaars die al in een cohort zitten, worden bij de volgende synchronisatie verwijderd.';

// Settings in the "Team / group names" section of the "Sync settings" tab.
$string['settings_secthead_team_group_name'] = 'Team-/groepsnamen';
$string['settings_secthead_team_group_name_desc'] = 'Als een cursus is geconfigureerd om te worden gesynchroniseerd, worden de namen van het Team en de groep als volgt samengesteld.<br/>
<ul>
<li>Het e-mailalias van de groep en de weergavenamen van het Team kunnen worden gedefinieerd.</li>
<li>De Microsoft 365-groep wordt eerst aangemaakt met de geconfigureerde mailNickname van de groep en weergavenaam van het Team, en vanuit de groep wordt een Team aangemaakt.</li>
<li>Als het Microsoft Entra ID-naamgevingsbeleid voor Microsoft 365-groepen wordt gebruikt, worden groepen niet aangemaakt als de volgens de configuratie samengestelde weergavenaam niet overeenkomt met het beleid.</li>
<li>Wijzigingen die hier worden aangebracht, gelden alleen voor het toekomstig aanmaken van Teams en niet voor bestaande.</li>
<li>Alle spaties worden uit het e-mailalias van de groep verwijderd.</li>
<li>In het e-mailalias van de groep zijn alleen hoofdletters, kleine letters, cijfers, - en _ toegestaan.</li>
<li>Het e-mailalias van de groep, inclusief voor- en achtervoegsel, mag niet langer zijn dan 64 tekens.</li>
<li>Het e-mailalias van de groep moet uniek zijn, anders wordt een willekeurig getal van 4 cijfers toegevoegd om uniekheid te garanderen.</li>
</ul>';
$string['settings_team_name_prefix'] = 'Voorvoegsel van Team-naam';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'Cursusgedeelte van de Team-naam';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'Achtervoegsel van Team-naam';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_group_mail_alias_prefix'] = 'Voorvoegsel van e-mailalias van groep';
$string['settings_group_mail_alias_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'Cursusgedeelte van het e-mailalias van de groep';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'Achtervoegsel van e-mailalias van groep';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'Stel dat een cursus het volgende heeft:
<ul>
<li>Volledige naam: <b>Voorbeeldcursus</b></li>
<li>Korte naam: <b>voorbeeld 15</b></li>
<li>Door Moodle aangemaakte ID: <b>2</b></li>
<li>ID-nummer: <b>Voorbeeld-ID 15</b></li>
</ul>
Je huidige instelling maakt een groep aan met e-mailalias "<b>{$a->mailalias}</b>" en een Team met de naam "<b>{$a->teamname}</b>".<br/>
Klik op de knop "Bewaar wijzigingen" hieronder om te zien hoe je instellingen dit veranderen.';
$string['settings_main_name_option_full_name'] = 'Volledige naam';
$string['settings_main_name_option_short_name'] = 'Korte naam';
$string['settings_main_name_option_id'] = 'Door Moodle aangemaakte ID';
$string['settings_main_name_option_id_number'] = 'ID-nummer';
$string['settings_team_name_sync'] = 'Team-naam bijwerken bij bijwerken van cursus';
$string['settings_team_name_sync_desc'] = 'Als deze optie is ingeschakeld, wordt de naam van het Team bijgewerkt volgens de meest recente instellingen voor Team-namen wanneer de Moodle-cursus wordt bijgewerkt.';

// Settings in the "Course request" section of the "Sync settings" tab.
$string['settings_secthead_course_request'] = 'Cursusaanvraag';
$string['settings_secthead_course_request_desc'] = 'Instellingen voor roltoewijzingen in de functie voor cursusaanvragen vanuit Teams.';
$string['settings_course_request_enrolment_owner_role'] = 'Rol van Team-eigenaar';
$string['settings_course_request_enrolment_owner_role_desc'] = 'De rol die aan de Team-eigenaar wordt toegewezen wanneer de cursusaanvraag wordt goedgekeurd.';
$string['settings_course_request_enrolment_member_role'] = 'Rol van Team-lid';
$string['settings_course_request_enrolment_member_role_desc'] = 'De rol die aan de Team-leden wordt toegewezen wanneer de cursusaanvraag wordt goedgekeurd.';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'Hulpmiddelen';
$string['settings_secthead_calsync'] = 'Agendasynchronisatie';
$string['settings_calsyncsubscribemode'] = 'Abonnement op agendasynchronisatie';
$string['settings_calsyncsubscribemode_details'] = 'Bepaalt of gebruikers de synchronisatie van de Outlook-agenda zelf moeten inschakelen.<ul><li><b>Opt-in</b>: gebruikers schakelen agendasynchronisatie in en vinken op hun instellingenpagina voor agendasynchronisatie de te synchroniseren agenda\'s aan.</li><li><b>Opt-out</b>: gebruikers die met Microsoft 365 zijn verbonden, krijgen automatisch agendasynchronisatie ingeschakeld en worden geabonneerd op de hieronder gekozen agenda\'s (voor cursussen: alle cursussen waarvoor ze zijn ingeschreven, nu en in de toekomst), waarbij van Moodle naar hun primaire Outlook-agenda wordt gesynchroniseerd. Gebruikers kunnen dit nog steeds wijzigen of uitschakelen op hun instellingenpagina voor agendasynchronisatie, en gebruikers die agendasynchronisatie uitschakelen, worden niet opnieuw geabonneerd.</li></ul>Terugschakelen naar "Opt-in" verwijdert bestaande abonnementen niet.';
$string['settings_calsyncsubscribetypes'] = 'Agenda\'s waarop gebruikers automatisch worden geabonneerd';
$string['settings_calsyncsubscribetypes_details'] = 'Geldt alleen voor "Opt-out". Kies op welke Moodle-agenda\'s verbonden gebruikers automatisch worden geabonneerd. Als iedereen wordt geabonneerd op de sitekalender, wordt elke gebruiker toegevoegd als deelnemer aan elke sitegebeurtenis. Daarom is dit standaard niet geselecteerd.';
$string['settings_calsyncsubscribetypes_site'] = 'Sitekalender';
$string['settings_calsyncsubscribetypes_user'] = 'Persoonlijke agenda';
$string['settings_calsyncsubscribetypes_course'] = 'Cursusagenda\'s (alle cursussen waarvoor de gebruiker is ingeschreven)';
$string['settings_calsyncsubscribemode_optin'] = 'Opt-in (gebruikers schakelen agendasynchronisatie zelf in)';
$string['settings_calsyncsubscribemode_optout'] = 'Opt-out (agendasynchronisatie automatisch inschakelen voor alle verbonden gebruikers)';
$string['settings_secthead_advanced'] = 'Geavanceerde instellingen';
$string['settings_secthead_advanced_desc'] = 'Deze instellingen bepalen andere functies van de pluginsuite. Wees voorzichtig! Ze kunnen onbedoelde effecten veroorzaken.';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'Tenants';
$string['settings_tools_tenants_linktext'] = 'Aanvullende tenants configureren';
$string['settings_tools_tenants_details'] = 'Beheer de toegang tot aanvullende Microsoft Entra-tenants.';
$string['settings_healthcheck'] = 'Statuscontrole';
$string['settings_healthcheck_details'] = 'Als iets niet correct werkt, kan een statuscontrole doorgaans het probleem identificeren en oplossingen voorstellen.';
$string['settings_healthcheck_linktext'] = 'Statuscontrole uitvoeren';
$string['settings_userconnections'] = 'Gebruikersverbindingen';
$string['settings_userconnections_linktext'] = 'Gebruikersverbindingen beheren';
$string['settings_userconnections_details'] = 'Bekijk en beheer verbindingen tussen Moodle- en Microsoft 365-gebruikers.';
$string['settings_teamconnections'] = 'Team-verbindingen';
$string['settings_teamconnections_linktext'] = 'Team-verbindingen beheren';
$string['settings_teamconnections_details'] = 'Bekijk en beheer verbindingen tussen Moodle-cursussen en Microsoft Teams.';
$string['settings_usermatch'] = 'Gebruikers koppelen';
$string['settings_usermatch_details'] = 'Met dit hulpmiddel kun je Moodle-gebruikers koppelen aan Microsoft 365-gebruikers op basis van een aangepast geüpload gegevensbestand.';
$string['settings_usersyncgroupfilter'] = 'Groepsfilter voor gebruikerssynchronisatie';
$string['settings_usersyncgroupfilter_details'] = 'Wanneer hier een of meer object-ID\'s (GUID\'s) van groepen worden ingevoerd, worden volledige gebruikerssynchronisaties beperkt tot de leden en eigenaars van die Microsoft 365-groepen, inclusief leden van geneste groepen. Laat leeg om alle gebruikers met een licentie in je tenant te synchroniseren.<br><br>
<strong>LET OP: Dit is een geavanceerde instelling. Onjuiste configuratie kan aanzienlijke problemen met gegevenssynchronisatie veroorzaken.</strong><br><br>
<strong>Wanneer geconfigureerd, geldt het volgende:</strong><br>
(1) Profielupdates, tijdzone-updates en fotoupdates worden alleen toegepast op gebruikers die lid of eigenaar van de groep zijn<br>
(2) Nieuwe Moodle-accounts worden alleen aangemaakt voor gebruikers die lid of eigenaar van de groep zijn<br>
(3) Moodle-accounts van gebruikers die geen lid zijn, krijgen geen updates meer en kunnen niet meer synchroon lopen met Microsoft 365<br>
(4) Gebruikers die in Microsoft 365 zijn uitgeschakeld, worden nog steeds in Moodle opgeschort door de synchronisatie van de ingeschakeldstatus, die onafhankelijk van groepsfiltering wordt uitgevoerd<br>
(5) Wanneer een gebruiker uit de groep wordt verwijderd, worden toekomstige synchronisaties voor dat account gestopt. Het Moodle-account wordt niet verwijderd en wordt alleen opgeschort als de optie \'Accounts in Moodle opschorten wanneer ze niet in de geconfigureerde groep voor gebruikerssynchronisatie zitten\' is ingeschakeld. Die optie schort elke gesynchroniseerde gebruiker op die niet in de groep zit, ongeacht of de gebruiker er ooit in heeft gezeten. Deze optie geldt alleen voor accounts die minstens één keer zijn gesynchroniseerd en dus een opgeslagen Microsoft-koppeling hebben; andere accounts worden niet opgeschort<br><br>
<strong>Beperking van incrementele (delta) synchronisatie:</strong> Microsoft Graph ondersteunt geen deltaquery\'s op eindpunten voor groepslidmaatschap. Wanneer deze instelling is geconfigureerd, voeren deltasynchronisaties in plaats van een incrementele update een volledige synchronisatie van groepsleden uit. Dit is correct gedrag, maar kan trager zijn dan een normale deltasynchronisatie.<br><br>
Valideer de object-ID\'s van de groepen voordat je opslaat. Voer één object-ID (GUID) van een groep per regel in, of scheid meerdere ID\'s met komma\'s.';
$string['settings_usersyncgroupfilter_notfound'] = 'Niet gevonden in Microsoft Entra ID: {$a}. Controleer de object-ID\'s van de groepen.';
$string['settings_usersyncgroupfilter_notverified'] = 'De object-ID\'s van de groepen konden niet worden gecontroleerd in Microsoft Entra ID en zijn zonder controle opgeslagen. Controleer of de ID\'s juist zijn.';
$string['settings_usersyncgroupfilter_validation_error'] = 'Ongeldige indeling van de groeps-ID: {$a}. Elke groeps-ID moet een geldige GUID zijn (bijv. 550e8400-e29b-41d4-a716-446655440000).';
$string['settings_usersynccreationrestriction'] = 'Beperking voor het aanmaken van gebruikers';
$string['settings_usersynccreationrestriction_details'] = 'Als deze optie is ingeschakeld, worden tijdens de gebruikerssynchronisatie alleen Microsoft Entra ID-gebruikers aangemaakt die aan de voorwaarde voldoen. Voer voor Microsoft 365-groepslidmaatschap (object-ID van de groep) één object-ID van een groep in, of meerdere object-ID\'s van groepen gescheiden door komma\'s.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Veldwaarde';
$string['settings_usersynccreationrestriction_o365group'] = 'Microsoft 365-groepslidmaatschap (groepsnaam)';
$string['settings_usersynccreationrestriction_o365groupid'] = 'Microsoft 365-groepslidmaatschap (object-ID van groep)';
$string['settings_usersynccreationrestriction_invalidgroupid'] = 'De object-ID "{$a}" van de Microsoft 365-groep kon niet worden gevonden. Controleer de ID en probeer het opnieuw.';
$string['settings_usersynccreationrestriction_groupvalidationerror'] = 'De object-ID\'s van de Microsoft 365-groep konden niet worden gevalideerd. Controleer de ID\'s en de Microsoft Graph-configuratie en probeer het opnieuw.';
$string['settings_usersynccreationrestriction_regex'] = 'Waarde is een reguliere expressie';
$string['settings_maintenance'] = 'Onderhoud';
$string['settings_maintenance_details'] = 'Er zijn verschillende onderhoudstaken beschikbaar om enkele veelvoorkomende problemen op te lossen.';
$string['settings_maintenance_linktext'] = 'Onderhoudshulpmiddelen bekijken';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'Multitenancy';
$string['acp_tenants_title_desc'] = 'Deze pagina helpt je bij het instellen van multitenant-toegang tot Moodle vanuit Microsoft 365.';
$string['acp_tenants_add'] = 'Nieuwe tenant toevoegen';
$string['acp_tenants_errornotsetup'] = 'Voltooi het installatieproces van de plugin voordat je aanvullende tenants toevoegt.';
$string['acp_tenants_hosttenant'] = 'Hosttenant: {$a}';
$string['acp_tenants_intro'] = '<b>Hoe multitenancy werkt:</b><br />Met multitenancy kunnen meerdere Microsoft Entra-tenants toegang krijgen tot je Moodle-site. <br /><br />
    Zo stel je het in:
    <ol>
        <li>Meld je aan bij Moodle als sitebeheerder die de OpenID Connect-authenticatieplugin niet gebruikt.</li>
        <li>Zorg ervoor dat de instellingen <b>Autorisatie-endpoint</b> en <b>Token-endpoint</b> van de OpenID Connect-authenticatieplugin de standaardinstellingen zonder tenantspecificatie gebruiken.</li>
        <li>Schakel de OpenID Connect-authenticatieplugin in Moodle uit. (Gebruik <a href="{$a}/admin/settings.php?section=manageauths">de beheerpagina Authenticatieplugins</a>.)</li>
        <li>Ga naar Microsoft Entra ID en zoek de toepassing die je voor Moodle hebt geconfigureerd.</li>
        <li>Schakel multitenancy in de Microsoft Entra ID-app in en sla de wijzigingen op.</li>
        <li>Geef de app ten minste een van de volgende gedelegeerde Graph-machtigingen: <b>Directory.Read.All</b>, <b>Domain.Read.All</b> of <b>Domain.ReadWrite.All</b>. Beheerderstoestemming voor je organisatie is niet vereist.</li>
        <li>Als je al bent aangemeld met je Microsoft-account van de aanvullende tenant, meld je dan volledig af en weer aan.</li>
        <li>Klik voor elke tenant die je wilt inschakelen op "Nieuwe tenant toevoegen" en meld je aan met een beheerdersaccount van de tenant die je wilt inschakelen.</li>
        <li>Schakel de OpenID Connect-authenticatieplugin in Moodle opnieuw in zodra je alle gewenste tenants hebt toegevoegd.</li>
        <li>Klaar! Om in de toekomst aanvullende tenants toe te voegen, klik je op de knop "Nieuwe tenant toevoegen" en meld je je aan met een beheerdersaccount van die tenant.</li>
    </ol>
    <b>Belangrijke opmerking:</b> Wanneer multitenancy in de Microsoft Entra ID-app is ingeschakeld, hebben alle Microsoft Entra-tenants toegang tot je toepassing. Door de tenants hier toe te voegen, kunnen we de toegang tot Moodle beperken tot de tenants die je configureert. <b>Als je alle tenants uit deze lijst verwijdert voordat je multitenancy in de Microsoft Entra ID-app uitschakelt, of OpenID Connect-authenticatie in Moodle inschakelt met een lege lijst, staat je Moodle-site open voor alle Microsoft Entra-tenants.</b>';
$string['acp_tenants_none'] = 'Je hebt geen tenants geconfigureerd. Als je multitenancy in de Microsoft Entra ID-app hebt ingeschakeld, staat je Moodle-site mogelijk open voor alle Microsoft 365-gebruikers.';
$string['acp_tenants_revokeaccess'] = 'Toegang intrekken';
$string['acp_tenants_tenant'] = 'Tenant';
$string['acp_tenants_actions'] = 'Acties';
$string['acp_tenants_delete'] = 'Verwijderen';
$string['acp_tenantsadd_desc'] = 'Om toegang te verlenen aan een aanvullende tenant, klik je op de knop hieronder en meld je je aan bij Microsoft 365 met een beheerdersaccount van de nieuwe tenant. Je wordt teruggestuurd naar de lijst met aanvullende tenants, waar de nieuwe tenant wordt vermeld. Daarna kun je Moodle gebruiken met de nieuwe tenant.';
$string['acp_tenantsadd_linktext'] = 'Doorgaan naar de aanmeldpagina van Microsoft 365';
$string['acp_tenants_legacy_tenants'] = 'Verouderde tenants (actie vereist)';
$string['acp_tenants_legacy_tenants_help'] = 'Eerder toegevoegde aanvullende tenants hieronder werken mogelijk niet in de bijgewerkte multitenancy-workflow en moeten worden hersteld.<br/>
Gebruik de knop "Nieuwe tenant toevoegen" hierboven om ze opnieuw toe te voegen.';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = 'Statuscontrole';
$string['healthcheck_fixlink'] = 'Klik hier om het te herstellen.';
$string['healthcheck_ratelimit_title'] = 'API-throttling';
$string['healthcheck_ratelimit_result_notice'] = 'Lichte throttling is ingeschakeld om de verhoogde belasting van de Moodle-site op te vangen. <br /><br />Alle Microsoft 365-functies werken, de verzoeken worden alleen iets meer gespreid om onderbreking van Microsoft 365-services te voorkomen. Zodra de Moodle-activiteit afneemt, keert alles terug naar normaal. <br />(Niveau {$a->level} / gestart {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'Verhoogde throttling is ingeschakeld om de aanzienlijke belasting van de Moodle-site op te vangen. <br /><br />Alle Microsoft 365-functies werken nog steeds, maar Microsoft 365-verzoeken kunnen langer duren. Zodra de activiteit op de Moodle-site is afgenomen, keert alles terug naar normaal. <br />(Niveau {$a->level} / gestart {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'Functies voor snelheidsbeperking zijn uitgeschakeld.';
$string['healthcheck_ratelimit_result_passed'] = 'Microsoft 365 API-aanroepen worden op volle snelheid uitgevoerd.';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'Gebruikersverbindingen beheren';
$string['acp_userconnections_column_muser'] = 'Moodle-gebruiker';
$string['acp_userconnections_column_o365user'] = 'Microsoft 365-gebruiker';
$string['acp_userconnections_column_status'] = 'Verbindingsstatus';
$string['acp_userconnections_column_actions'] = 'Acties';
$string['acp_userconnections_column_usinglogin'] = 'Aanmelden gebruiken';
$string['acp_userconnections_column_status_help'] = 'De verbindingsstatus toont hoe een Moodle-account is gekoppeld aan een Microsoft 365-account (Microsoft Entra ID).

* **Verbonden** – De gebruiker heeft de verbinding voltooid door zich bij Moodle aan te melden met zijn of haar Microsoft 365-account, of een beheerder heeft het account actief verbonden. Functies zoals agendasynchronisatie en OneDrive werken voor deze gebruiker.
* **Gekoppeld** – Een beheerder (of het hulpmiddel voor bulksgewijs koppelen van gebruikers) heeft vastgelegd bij welk Microsoft 365-account deze Moodle-gebruiker hoort, maar de verbinding is nog niet actief. Deze wordt voltooid wanneer de gebruiker zich voor het eerst met Microsoft 365 aanmeldt. Er wordt niets gesynchroniseerd zolang een gebruiker alleen gekoppeld is.
* **Gesynchroniseerd** – Het Moodle-account is vanuit Microsoft Entra ID aangemaakt door de taak voor gebruikerssynchronisatie, maar de gebruiker heeft zich nog niet aangemeld. Het account wordt geactiveerd bij de eerste aanmelding.
* **Geen verbinding** – Het Moodle-account is niet gekoppeld aan een Microsoft 365-account.';
$string['acp_userconnections_column_actions_help'] = 'De beschikbare acties voor een rij hangen af van de verbindingsstatus.

* **Verbinding verbreken** – Verwijdert de koppeling tussen het Moodle-account en het Microsoft 365-account. De persoon houdt zijn of haar Moodle-account, maar kan geen Microsoft 365-functies meer gebruiken of zich met Microsoft 365 aanmelden totdat opnieuw verbinding wordt gemaakt. Wordt getoond voor verbonden gebruikers.
* **Opnieuw synchroniseren** – Voert de synchronisatie van Microsoft 365-gegevens voor deze gebruiker meteen uit (profielvelden, foto, agenda enzovoort) in plaats van te wachten op de geplande taak, en toont het resultaat. Wordt getoond voor verbonden en gesynchroniseerde gebruikers.
* **Koppelen** – Legt vast bij welk Microsoft 365-account deze Moodle-gebruiker hoort. De verbinding is pas actief wanneer de persoon zich met Microsoft 365 aanmeldt. Wordt getoond voor gebruikers zonder verbinding.
* **Koppeling opheffen** – Verwijdert een koppeling die nog niet is voltooid. Wordt getoond voor gekoppelde gebruikers.';
$string['acp_userconnections_accountstatus_active'] = 'Actief';
$string['acp_userconnections_accountstatus_suspended'] = 'Opgeschort';
$string['acp_userconnections_connectionstatus_connected'] = 'Verbonden';
$string['acp_userconnections_connectionstatus_matched'] = 'Gekoppeld';
$string['acp_userconnections_connectionstatus_noconnection'] = 'Geen verbinding';
$string['acp_userconnections_connectionstatus_synced'] = 'Gesynchroniseerd';
$string['acp_userconnections_filtering_accountstatus'] = 'Accountstatus';
$string['acp_userconnections_filtering_connectionstatus'] = 'Verbindingsstatus';
$string['acp_userconnections_filtering_muserfullname'] = 'Volledige naam van Moodle-gebruiker';
$string['acp_userconnections_filtering_musername'] = 'Moodle-gebruikersnaam';
$string['acp_userconnections_filtering_o365username'] = 'Microsoft 365-gebruikersnaam';
$string['acp_userconnections_manualmatch_title'] = 'Handmatige gebruikerskoppeling';
$string['acp_userconnections_manualmatch_details'] = 'Op deze pagina kun je één Moodle-gebruiker koppelen aan één Microsoft 365-gebruiker.';
$string['acp_userconnections_manualmatch_musername'] = 'Moodle-gebruiker';
$string['acp_userconnections_manualmatch_uselogin'] = 'Aanmelden met Microsoft 365';
$string['acp_userconnections_manualmatch_o365username'] = 'Microsoft 365-gebruikersnaam';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'De Moodle-gebruiker is al verbonden met een Microsoft 365-gebruiker';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'De Moodle-gebruiker is al verbonden met een Microsoft 365-gebruiker (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'De Moodle-gebruiker is al gekoppeld aan een Microsoft 365-gebruiker';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'De Microsoft 365-gebruiker is al gekoppeld aan een andere Moodle-gebruiker';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'De Microsoft 365-gebruiker is al verbonden met een andere Moodle-gebruiker';
$string['acp_userconnections_resync_nodata'] = 'Kon geen opgeslagen Microsoft 365-informatie voor deze gebruiker vinden.';
$string['acp_userconnections_resync_notfound'] = 'Er zijn geen gegevens gesynchroniseerd. Het account "{$a->username}" is gekoppeld aan Microsoft Entra ID-object {$a->objectid}, maar dat object kon niet worden gevonden. De gebruiker is hoogstwaarschijnlijk verwijderd of uitgeschakeld in Microsoft 365, of de opgeslagen object-ID is verouderd.';
$string['acp_userconnections_resync_nooutput'] = 'De hersynchronisatie is voltooid zonder wijzigingen te melden.';
$string['acp_userconnections_table_disconnect'] = 'Verbinding verbreken';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'Hiermee wordt de verbinding van Moodle-gebruiker "{$a}" met Microsoft 365 verbroken. Klik op de link hieronder om door te gaan.';
$string['acp_userconnections_table_match'] = 'Koppelen';
$string['acp_userconnections_table_resync'] = 'Opnieuw synchroniseren';
$string['acp_userconnections_table_unmatch'] = 'Koppeling opheffen';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'Hiermee wordt de koppeling van Moodle-gebruiker "{$a}" met Microsoft 365 opgeheven. Klik op de link hieronder om door te gaan.';

// Settings in the "Manage Team Connections" feature of the "Advanced" tab.
$string['acp_teamconnections'] = 'Team-verbindingen beheren';
$string['acp_teamconnection'] = 'Team-verbinding beheren';
$string['acp_teamconnections_actions'] = 'Acties';
$string['acp_teamconnections_cache_last_updated'] = 'De Teams-cache is voor het laatst bijgewerkt op {$a->lastupdated}. Klik <a href="{$a->updateurl}">hier</a> om de cache bij te werken.';
$string['acp_teamconnections_cache_never_updated'] = 'De Teams-cache is nog nooit bijgewerkt. Klik <a href="{$a->updateurl}">hier</a> om bij te werken.';
$string['acp_teamconnections_connected_team'] = 'Verbonden Team';
$string['acp_teamconnections_course_connected'] = 'De cursus is succesvol verbonden met het Team.';
$string['acp_teamconnections_course_disconnected'] = 'De verbinding van de cursus met het Team is verbroken.';
$string['acp_teamconnections_team_linked'] = 'De cursus is gekoppeld aan het Team.';
$string['acp_teamconnections_current_connection'] = 'HUIDIGE VERBINDING';
$string['acp_teamconnections_exception_course_not_exist'] = 'De te verbinden cursus bestaat niet.';
$string['acp_teamconnections_exception_invalid_team_id'] = 'Ongeldige Team-ID';
$string['acp_teamconnections_exception_not_configured'] = 'Microsoft 365 is niet volledig geconfigureerd.';
$string['acp_teamconnections_exception_team_already_connected'] = 'Het Team is al verbonden met een andere cursus';
$string['acp_teamconnections_form_connect_course'] = 'Team-verbinding beheren voor cursus {$a}';
$string['acp_teamconnections_form_sds_warning'] = 'OPMERKING: Teams die door Student Data Sync (SDS) zijn aangemaakt, kunnen hier niet handmatig worden verbonden, omdat dit zou conflicteren met de SDS-synchronisatie. Ze zijn uitgesloten van de zoekresultaten hieronder.';
$string['acp_teamconnections_form_team'] = 'Team selecteren';
$string['acp_teamconnections_form_team_noselection'] = 'Zoek naar een Team...';
$string['acp_teamconnections_no_teams_found'] = 'Geen Teams gevonden voor "{$a}"';
$string['acp_teamconnections_group_only'] = ' (Alleen groep)';
$string['acp_teamconnections_team_missing'] = '(Team ontbreekt)';
$string['acp_teamconnections_not_connected'] = 'Niet verbonden';
$string['acp_teamconnections_sync_disabled'] = 'Cursussynchronisatie moet eerst worden ingeschakeld voordat je Teams-verbindingen kunt beheren.';
$string['acp_teamconnections_table_connect'] = 'Verbinden';
$string['acp_teamconnections_table_connect_to_different_team'] = 'Verbinden met een ander Team';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'Kan geen Team aanmaken vanuit de groep - geen eigenaar';
$string['acp_teamconnections_table_link_team'] = 'Koppelen aan Team "{$a}"';
$string['acp_teamconnections_table_missing_team'] = 'De cursus is verbonden met een niet-bestaand Team. Dit wordt opgeschoond bij de volgende uitvoering van de geplande taak voor cursussynchronisatie.';
$string['acp_teamconnections_table_resync'] = 'Opnieuw synchroniseren';
$string['acp_teamconnections_table_update'] = 'Bijwerken';
$string['acp_teamconnections_teams_cache_updated'] = 'De Teams-cache is succesvol bijgewerkt.';
$string['acp_teamconnections_no_owner'] = 'Voeg een eigenaar toe om verbinding te maken met Teams.';
$string['acp_teamconnections_resync'] = 'Team-eigenaars/-leden opnieuw synchroniseren';
$string['acp_teamconnections_resync_title'] = 'Team-eigenaars/-leden opnieuw synchroniseren voor cursus {$a}';
$string['acp_teamconnections_resync_desc'] = 'Hiermee worden de ingeschreven gebruikers van de cursus vergeleken met de eigenaars en leden van de verbonden Microsoft 365-groep/het verbonden Team, en worden ontbrekende personen toegevoegd. Kies of gebruikers die wel in het Team zitten maar niet zijn ingeschreven voor de Moodle-cursus ook moeten worden verwijderd.';
$string['acp_teamconnections_resync_keep'] = 'Opnieuw synchroniseren (extra Team-leden behouden)';
$string['acp_teamconnections_resync_keep_desc'] = 'Gebruikers die voor de Moodle-cursus zijn ingeschreven maar ontbreken in het Team, worden toegevoegd. Bestaande Team-eigenaars/-leden die niet voor de Moodle-cursus zijn ingeschreven, worden niet gewijzigd.';
$string['acp_teamconnections_resync_remove'] = 'Opnieuw synchroniseren en extra Team-leden verwijderen';
$string['acp_teamconnections_resync_remove_desc'] = 'Waarschuwing: elke Team-eigenaar of elk Team-lid die niet voor de Moodle-cursus is ingeschreven, wordt uit het Team verwijderd, ook als deze rechtstreeks in Microsoft Teams is toegevoegd.';
$string['acp_teamconnections_resync_completed'] = 'Team-eigenaars/-leden zijn opnieuw gesynchroniseerd.';
$string['acp_teamconnections_resync_failed'] = 'Kon Team-eigenaars/-leden niet opnieuw synchroniseren. Zie de uitvoer hierboven voor details.';
$string['acp_teamconnections_last_resync'] = 'Laatst opnieuw gesynchroniseerd: {$a}';
$string['acp_teamconnections_never_resynced'] = 'Nooit opnieuw gesynchroniseerd';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'Gebruikers koppelen';
$string['acp_usermatch_desc'] = 'Met dit hulpmiddel kun je Moodle-gebruikers koppelen aan Microsoft 365-gebruikers. Je uploadt een bestand met Moodle-gebruikers en bijbehorende Microsoft 365-gebruikers, en een cron-taak controleert de gegevens en stelt de koppeling in.';
$string['acp_usermatch_upload'] = 'Stap 1: Nieuwe koppelingen uploaden';
$string['acp_usermatch_upload_desc'] = 'Upload een gegevensbestand met Moodle- en Microsoft 365-gebruikersnamen om Moodle-gebruikers te koppelen aan Microsoft 365-gebruikers.<br />
<br />
Dit bestand moet een eenvoudig CSV-bestand met platte tekst zijn met drie items per regel:
<ul>
<li>de Moodle-gebruikersnaam,</li>
<li>de Microsoft 365-gebruikersnaam,</li>
<li>1 of 0, waarbij 1 betekent dat de authenticatiemethode van de gebruiker wordt gewijzigd naar OpenID Connect en 0 betekent dat de bestaande authenticatiemethode behouden blijft en als gekoppeld account wordt gebruikt.</li>
</ul>
Neem geen kopteksten of aanvullende gegevens op.<br />
Bijvoorbeeld: <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'Type {$a} wordt niet ondersteund. Upload een CSV met platte tekst.';
$string['acp_usermatch_upload_err_data'] = 'Regel #{$a} bevatte ongeldige gegevens. Elke regel in het CSV-bestand moet ten minste twee items bevatten: de Moodle-gebruikersnaam en de Microsoft 365-gebruikersnaam.';
$string['acp_usermatch_upload_err_fileopen'] = 'Kon het bestand niet openen voor verwerking. Zijn de rechten in je Moodledata-map correct?';
$string['acp_usermatch_upload_err_nofile'] = 'Er is geen bestand ontvangen om aan de wachtrij toe te voegen.';
$string['acp_usermatch_upload_submit'] = 'Gegevensbestand aan koppelwachtrij toevoegen';
$string['acp_usermatch_matchqueue'] = 'Stap 2: Koppelwachtrij';
$string['acp_usermatch_matchqueue_clearall'] = 'Alles wissen';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Fouten wissen';
$string['acp_usermatch_matchqueue_clearqueued'] = 'In wachtrij wissen';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Geslaagde wissen';
$string['acp_usermatch_matchqueue_column_muser'] = 'Moodle-gebruikersnaam';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Microsoft 365-gebruikersnaam';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Status';
$string['acp_usermatch_matchqueue_desc'] = 'Deze tabel toont de huidige status van de koppelbewerking. Telkens wanneer de geplande taak <b>Koppelwachtrij verwerken</b> wordt uitgevoerd, wordt een batch van de volgende gebruikers verwerkt.<br /><b>Opmerking:</b> Deze pagina wordt niet dynamisch bijgewerkt. Vernieuw de pagina om de huidige status te bekijken.';
$string['acp_usermatch_matchqueue_empty'] = 'De koppelwachtrij is momenteel leeg. Upload een gegevensbestand met de bestandskiezer hierboven om gebruikers aan de wachtrij toe te voegen.';
$string['acp_usermatch_matchqueue_status_error'] = 'Fout: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'In wachtrij';
$string['acp_usermatch_matchqueue_status_success'] = 'Geslaagd';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'Onderhoudshulpmiddelen';
$string['acp_maintenance_desc'] = 'Deze hulpmiddelen kunnen je helpen bij het oplossen van enkele veelvoorkomende problemen.';
$string['acp_maintenance_warning'] = 'Waarschuwing: Dit zijn geavanceerde hulpmiddelen. Gebruik ze alleen als je begrijpt wat je doet.';
$string['acp_maintenance_resyncgroupusers'] = 'Gebruikers in Microsoft 365-groepen voor cursussen opnieuw synchroniseren';
$string['acp_maintenance_resyncgroupusers_desc'] = 'Hiermee wordt het gebruikerslidmaatschap van alle Microsoft 365-groepen die voor alle Moodle-cursussen zijn aangemaakt opnieuw gesynchroniseerd. Zo zit iedereen die voor de Moodle-cursus is ingeschreven, en alleen die gebruikers, in de Microsoft 365-groep. <br /><b>Opmerking:</b> Als je extra gebruikers aan een Microsoft 365-groep hebt toegevoegd die niet voor de bijbehorende Moodle-cursus zijn ingeschreven, worden ze verwijderd.';
$string['acp_maintenance_recreatedeletedgroups'] = 'Verwijderde Microsoft 365-groepen opnieuw aanmaken';
$string['acp_maintenance_recreatedeletedgroups_desc'] = 'Hiermee wordt gecontroleerd of Microsoft 365-groepen die met Moodle-cursussen zijn verbonden mogelijk handmatig zijn verwijderd, en worden ze opnieuw aangemaakt.';
$string['acp_maintenance_debugdata'] = 'Pakket met foutopsporingsgegevens genereren';
$string['acp_maintenance_debugdata_desc'] = 'Hiermee wordt een pakket gegenereerd met diverse informatie over je Moodle- en Microsoft 365-omgeving om ontwikkelaars te helpen bij het oplossen van eventuele problemen. Voer dit hulpmiddel uit als een ontwikkelaar daarom vraagt en stuur het gedownloade bestand op. Opmerking: Hoewel dit pakket geen gevoelige tokengegevens bevat, vragen we je dit bestand niet openbaar te plaatsen of naar een niet-vertrouwde partij te sturen.';
$string['acp_maintenance_cleandeltatoken'] = 'Deltatokens voor gebruikerssynchronisatie opschonen';
$string['acp_maintenance_cleandeltatoken_desc'] = 'Als gebruikerssynchronisatie na het bijwerken van de instellingen niet volledig werkt, kan dit worden veroorzaakt door een oud deltasynchronisatietoken. Het opschonen van het token dwingt een volledige hersynchronisatie af wanneer de gebruikerssynchronisatie de volgende keer wordt uitgevoerd.';
$string['acp_maintenance_cleanapptokens'] = 'Toepassingstokens opschonen';
$string['acp_maintenance_cleanapptokens_desc'] = 'Verwijdert de opgeslagen toepassingstokens, die de plugin gebruikt voor aanroepen naar Microsoft API\'s die niet als gebruiker worden uitgevoerd. Nieuwe toepassingstokens worden automatisch aangevraagd wanneer ze de volgende keer nodig zijn, en de resultaten van de laatste controle "Configuratie controleren" op het tabblad Instellingen worden gewist. Als aanroepen met toepassingsmachtigingen mislukken met authenticatiefouten, bijvoorbeeld nadat de machtigingen van de Microsoft Entra ID-toepassing of de bijbehorende referenties zijn gewijzigd, kan het opschonen van de tokens helpen. Tokens van gebruikers worden niet beïnvloed.';

// Settings in the "Resync users in Microsoft 365 groups for courses" feature in the "Maintenance Tools" feature of the
// "Advanced" tab.
$string['acp_maintenance_resyncgroupusers_course_output'] = 'Uitvoer van hersynchronisatie';
$string['acp_maintenance_resyncgroupusers_no_course'] = 'Geen cursus verbonden met Microsoft 365';
$string['acp_maintenance_coursesync_disabled'] = 'Dit hulpmiddel is alleen beschikbaar wanneer cursussynchronisatie is ingeschakeld. <a href="{$a}">Cursussynchronisatie beheren</a>.';

// Settings in the "Recreate deleted Microsoft 365 groups" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_recreatedeletedgroups_group_type'] = 'Moodle-objecttype';
$string['acp_maintenance_recreatedeletedgroups_group_type_course'] = 'Cursus';
$string['acp_maintenance_recreatedeletedgroups_group_type_course_group'] = 'Cursusgroep';
$string['acp_maintenance_recreatedeletedgroups_course'] = 'Cursus';
$string['acp_maintenance_recreatedeletedgroups_course_group'] = 'Cursusgroep';
$string['acp_maintenance_recreatedeletedgroups_status'] = 'Status';
$string['acp_maintenance_recreatedeletedgroups_status_sync_disabled'] = 'Cursussynchronisatie is uitgeschakeld';
$string['acp_maintenance_recreatedeletedgroups_status_created_success'] = 'Groep is opnieuw aangemaakt';
$string['acp_maintenance_recreatedeletedgroups_status_created_fail'] = 'Opnieuw aanmaken van groep mislukt';
$string['acp_maintenance_recreatedeletedgroups_all_groups_exist'] = 'Alle groepen die met Moodle-cursussen en cursusgroepen zijn verbonden, bestaan.';

// Settings in the "Cleanup User Sync Delta Tokens" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_cleandeltatoken_completed'] = 'Het deltatoken en het overslaan-deltatoken van de gebruikerssynchronisatie zijn opgeschoond.';
$string['acp_maintenance_cleanapptokens_confirm'] = 'Weet je zeker dat je de toepassingstokens wilt opschonen? Er zijn momenteel {$a} toepassingstoken(s) opgeslagen.';
$string['acp_maintenance_cleanapptokens_completed'] = 'Toepassingstokens en de laatste resultaten van "Configuratie controleren" zijn opgeschoond.';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_course_reset_teams'] = 'Team-/groepsacties bij het resetten van een cursus';
$string['settings_course_reset_teams_details'] = 'Acties die worden uitgevoerd op een Team of groep dat met een cursus is verbonden wanneer de cursus wordt gereset.';
$string['settings_course_reset_teams_option_do_nothing'] = 'Niets doen<br/>Het Team of de groep blijft met de cursus verbonden. Het uitschrijven van gebruikers leidt tot verwijdering van het Team- of groepslidmaatschap van de gebruiker.';
$string['settings_course_reset_teams_option_per_course'] = 'Instellingen per cursus toestaan<br/>Hiervoor moet het Microsoft-blok aan de cursus zijn toegevoegd. Gebruikers met de bevoegdheid om de cursus te resetten, kunnen in het blok kiezen wat er tijdens het resetten van de cursus gebeurt.';
$string['settings_course_reset_teams_option_force_archive'] = 'De verbinding tussen de cursus en het Team of de groep verbreken en een nieuw Team of nieuwe groep aanmaken<br/>Het bestaande Team of de bestaande groep die met de cursus is verbonden, wordt hernoemd zoals geconfigureerd. Als een Team is verbonden, wordt het gearchiveerd. Er wordt een nieuw Team of een nieuwe groep aangemaakt en met de cursus verbonden.';
$string['settings_course_reset_teams_option_archive_only'] = 'Alleen de verbinding tussen de cursus en het Team of de groep verbreken<br />Het bestaande Team of de bestaande groep die met de cursus is verbonden, wordt hernoemd zoals geconfigureerd. Als een Team is verbonden, wordt het gearchiveerd. Er wordt geen nieuw Team of nieuwe groep aangemaakt.';
$string['settings_reset_team_name_prefix'] = 'Voorvoegsel voor Team-naam bij resetten';
$string['settings_reset_team_name_prefix_details'] = 'Bij het resetten van een cursus die met een Team is verbonden, wordt dit voorvoegsel voor de naam van het bestaande verbonden Team geplaatst.';
$string['settings_reset_group_name_prefix'] = 'Voorvoegsel voor groepsnaam bij resetten';
$string['settings_reset_group_name_prefix_details'] = 'Bij het resetten van een cursus die met een groep is verbonden, wordt dit voorvoegsel voor de naam van de bestaande groep geplaatst.';
$string['settings_calsync_courseeventmode'] = 'Outlook-afspraken voor cursusagenda-gebeurtenissen';
$string['settings_calsync_courseeventmode_details'] = 'Bepaalt hoe een Moodle-cursusagenda-gebeurtenis in Outlook wordt aangemaakt voor gebruikers die zijn geabonneerd op de cursusagenda.
<ul>
<li><strong>Eén gedeelde afspraak met cursusgebruikers als deelnemers:</strong> er wordt één afspraak aangemaakt in de Outlook-agenda van de gebruiker die de Moodle-gebeurtenis heeft aangemaakt (of in de agenda van de Microsoft 365-groep van de cursus, als de cursus aan een groep is gekoppeld), en de cursusgebruikers worden eraan toegevoegd als deelnemers.</li>
<li><strong>Eén afzonderlijke afspraak per gebruiker:</strong> er wordt een afzonderlijke afspraak aangemaakt rechtstreeks in de eigen Outlook-agenda van elke geabonneerde gebruiker. Er is geen gedeelde afspraak, geen deelnemerslijst en er wordt niets toegevoegd aan de agenda van de Microsoft 365-groep.</li>
</ul>
Het wijzigen van deze instelling heeft alleen invloed op gebeurtenissen die daarna worden gesynchroniseerd; gebeurtenissen die al in Outlook staan, worden niet omgezet.';
$string['settings_calsync_courseeventmode_shared'] = 'Eén gedeelde afspraak met cursusgebruikers als deelnemers';
$string['settings_calsync_courseeventmode_individual'] = 'Eén afzonderlijke afspraak per gebruiker';
$string['settings_debugmode'] = 'Foutopsporingsberichten registreren';
$string['settings_debugmode_details'] = 'Als deze optie is ingeschakeld, worden gegevens in het Moodle-logboek geregistreerd die kunnen helpen bij het identificeren van problemen. <a href="{$a}">Geregistreerde logberichten bekijken.</a>';
$string['settings_switchauthminupnsplit0'] = 'Minimale lengte van onnauwkeurige gebruikersnaam om over te zetten naar Microsoft 365';
$string['settings_switchauthminupnsplit0_details'] = 'Als je de instelling \'Gekoppelde gebruikers overzetten naar Microsoft 365-authenticatie (OpenID Connect)\' inschakelt, stelt dit de minimale lengte in van gebruikersnamen zonder tenant (het gedeelte @example.onmicrosoft.com) die worden overgezet. Dit helpt te voorkomen dat accounts met generieke namen, zoals "admin", worden overgezet; die zijn in Moodle en Microsoft Entra ID niet noodzakelijk hetzelfde. Stel in op 0 om gekoppelde gebruikers over te zetten ongeacht de lengte van de gebruikersnaam. Gebruikers wier authenticatiemethode vanwege deze instelling niet is overgezet, worden in de uitvoer van de synchronisatietaak gelogd als "Matched user, but the username is not an exact match to the Microsoft Entra ID UPN and does not meet the exact-match requirements for switching to OIDC..." en verschijnen als "Matched with existing user - Awaiting completion" op de pagina Gebruikersverbindingen beheren.';
$string['settings_customtheme'] = 'Aangepast thema (geavanceerd)';
$string['settings_customtheme_desc'] = 'Aanbevolen thema is "boost_o365teams". Je kunt echter een ander thema selecteren als je een aangepast thema hebt dat is aangepast voor gebruik in het Teams-tabblad.<br/>
Houd er rekening mee dat een aangepast thema dat op cursus- of categorieniveau is ingesteld voorrang heeft op de instellingen hier, d.w.z. een cursus gebruikt standaard het cursus- of categoriethema in de Moodle-app in Teams. Dit kan worden opgelost door $CFG->themeorder in config.php bij te werken naar "array(\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\');".';

// Settings in the "SDS sync" tab.
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>Dit is een previewfunctie</b><br />Previewfuncties werken mogelijk niet zoals bedoeld of kunnen zonder waarschuwing defect raken. Ga voorzichtig te werk.</div>';
$string['settings_sds_intro_desc'] = 'Microsoft School Data Sync ("SDS") vereenvoudigt klasbeheer in Microsoft 365 door roosters uit een extern SIS te lezen en klassen en groepen in Microsoft 365 aan te maken. <a href="https://sds.microsoft.com/" target="_blank">Meer informatie</a><br/>
<br/>
De SDS-synchronisatiefunctie kan roostergegevens uit SDS synchroniseren naar Moodle, waaronder klassen, leraren en leerlingen.<br/>
<br/>
Om de SDS-synchronisatiefunctie te gebruiken, moet je ervoor zorgen dat de Microsoft Entra ID-app die voor de integratie wordt gebruikt de Microsoft Graph-toepassingsmachtigingen <b>EduRoster.Read.All</b> en <b>Member.Read.Hidden</b> heeft, die niet automatisch door de standaardinstallatie worden toegevoegd. Hiervoor moet ook beheerderstoestemming worden verleend.<br/>
<br/>
Standaard vindt het SDS-synchronisatieproces dagelijks plaats in de Moodle-cron, om 3:00 uur servertijd. Om dit schema te wijzigen, ga je naar de <a href="{$a}">beheerpagina Geplande taken.</a><br/><br/>';
$string['settings_sds_coursecreation'] = 'Synchronisatie van klas naar cursus';
$string['settings_sds_coursecreation_desc'] = 'Deze opties bepalen het aanmaken van Moodle-cursussen op basis van SDS-schoolklassen.';
$string['settings_sds_coursecreation_enabled'] = 'Gesynchroniseerde scholen';
$string['settings_sds_coursecreation_enabled_desc'] = 'Maak cursussen aan voor klassen in deze scholen.';
$string['settings_sds_teams_enabled'] = 'Hebben SDS-klassen al Teams?';
$string['settings_sds_teams_enabled_desc'] = 'Vink dit aan als de SDS-klassen al Teams hebben die door de SDS-configuratie zijn aangemaakt. Indien aangevinkt, probeert Moodle geen Teams aan te maken vanuit de Moodle-cursussen die uit SDS-klassen zijn aangemaakt, om conflicten te voorkomen.';
$string['settings_sds_courseenrolsync'] = 'Synchronisatie van cursusinschrijvingen';
$string['settings_sds_courseenrolsync_desc'] = 'Deze opties bepalen het synchroniseren van cursusinschrijvingen vanuit SDS-schoolklassen.';
$string['settings_sds_enrolment_enabled'] = 'Inschrijvingen van SDS naar Moodle synchroniseren';
$string['settings_sds_enrolment_enabled_desc'] = 'Als deze optie is ingeschakeld, schrijft de geplande SDS-synchronisatietaak leraren en leerlingen uit SDS-klassen in voor hun bijbehorende Moodle-cursussen en verwijdert ze gebruikers die niet meer in de SDS-klas zitten. Hiervoor moeten <b>Rol van SDS-klasleraar in Moodle</b> en <b>Rol van SDS-klasleerling in Moodle</b> zijn geconfigureerd.';
$string['settings_sds_sync_enrolment_to_sds'] = 'Inschrijvingen van Moodle naar SDS synchroniseren';
$string['settings_sds_sync_enrolment_to_sds_desc'] = 'Als deze optie is ingeschakeld, worden inschrijvingswijzigingen in Moodle-cursussen die met SDS-klassen zijn verbonden teruggesynchroniseerd naar de SDS-klassen. De eigenaars-/lidmaatschapsstatus van de gebruiker in SDS hangt af van de bevoegdheden "local/o365:teamowner" en "local/o365:teammember" in de cursuscontext.';
$string['settings_sds_suspend_enrolment'] = 'Inschrijvingen van gebruikers opschorten in plaats van uitschrijven';
$string['settings_sds_suspend_enrolment_desc'] = 'Als deze optie is ingeschakeld, wordt de inschrijving van gebruikers die uit een SDS-klas worden verwijderd opgeschort in de verbonden Moodle-cursus in plaats van volledig uitgeschreven. Zo blijven gebruikersgegevens zoals beoordelingen, inzendingen en activiteitsvoltooiing bewaard. Wanneer gebruikers weer aan de SDS-klas worden toegevoegd, wordt hun inschrijving automatisch opnieuw geactiveerd.<br />
<b>Opmerking:</b> Leraren worden nooit opgeschort of uitgeschreven door de SDS-synchronisatie. Deze instelling heeft alleen invloed op leerlingen.';
$string['settings_sds_enable_course_sync'] = 'Tweerichtingscursussynchronisatie inschakelen';
$string['settings_sds_enable_course_sync_desc'] = 'Als deze optie is ingeschakeld, wordt elke Moodle-cursus die uit een SDS-klas is aangemaakt in de database gekoppeld aan zijn Microsoft 365-groep, waardoor de volledige Microsoft 365-cursussynchronisatie-integratie (Teams, bestanden, agenda, enz.) voor die cursus wordt geactiveerd. Als de SDS-klas al een Team heeft, wordt ook een Teams-koppelingsrecord aangemaakt.';
$string['settings_sds_course_field_mailnickname'] = 'E-mailalias (mailNickname)';
$string['settings_sds_course_field_displayname'] = 'Weergavenaam (displayName)';
$string['settings_sds_course_field_classcode'] = 'Klascode (classCode)';
$string['settings_sds_course_field_externalname'] = 'Externe naam (externalName)';
$string['settings_sds_course_shortname_field'] = 'Bron van korte cursusnaam';
$string['settings_sds_course_shortname_field_desc'] = 'De eigenschap van de SDS-klas die wordt gebruikt als korte naam van nieuw aangemaakte Moodle-cursussen. Moodle vereist dat korte cursusnamen uniek zijn. Als de gekozen eigenschap leeg is, of de waarde al wordt gebruikt door een cursus die aan een andere SDS-klas is gekoppeld, wordt in plaats daarvan het e-mailalias gebruikt. Het wijzigen van deze instelling hernoemt reeds aangemaakte cursussen niet.';
$string['settings_sds_course_fullname_field'] = 'Bron van volledige cursusnaam';
$string['settings_sds_course_fullname_field_desc'] = 'De eigenschap van de SDS-klas die wordt gebruikt als volledige naam van nieuw aangemaakte Moodle-cursussen. Als de gekozen eigenschap leeg is, wordt in plaats daarvan de weergavenaam gebruikt. Het wijzigen van deze instelling hernoemt reeds aangemaakte cursussen niet.';
$string['settings_sds_categorize_by_subject'] = 'Cursussen indelen op vak';
$string['settings_sds_categorize_by_subject_desc'] = 'Als deze optie is ingeschakeld, worden cursussen binnen elke schoolcategorie georganiseerd in categorieën op basis van vak. De naam van het vak wordt uit de klasinformatie in SDS gehaald. Als de optie is uitgeschakeld, worden alle cursussen rechtstreeks in de schoolcategorie geplaatst.';
$string['settings_sds_ignore_past_courses'] = 'Verlopen/afgelopen klassen negeren';
$string['settings_sds_ignore_past_courses_desc'] = 'Als deze optie is ingeschakeld, worden klassen die zijn verlopen of beëindigd overgeslagen tijdens de synchronisatie. Dit omvat:<br />
<ul>
<li>Klassen met het geconfigureerde voorvoegsel voor verlopen klassen in hun naam (standaard: "Exp")</li>
<li>Klassen met een einddatum in het verleden</li>
</ul>
Dit helpt je cursuscatalogus schoon te houden door geen cursussen aan te maken voor oude of gearchiveerde klassen.';
$string['settings_sds_expired_course_prefix'] = 'Voorvoegsel voor namen van verlopen klassen';
$string['settings_sds_expired_course_prefix_desc'] = 'Klassennamen die met dit voorvoegsel beginnen, worden beschouwd als verlopen en overgeslagen tijdens de synchronisatie (als "Verlopen/afgelopen klassen negeren" is ingeschakeld). Standaard: "Exp"';
$string['settings_sds_cohortsync'] = 'Cohortsynchronisatie';
$string['settings_sds_cohortsync_desc'] = 'Deze opties bepalen het aanmaken en synchroniseren van cohorten vanuit SDS-klassen. Cohorten bieden een alternatieve manier om gebruikers te groeperen, die kan worden gebruikt voor site-brede inschrijving of andere Moodle-functies.';
$string['settings_sds_create_cohorts'] = 'Cohorten aanmaken vanuit SDS-klassen';
$string['settings_sds_create_cohorts_desc'] = 'Als deze optie is ingeschakeld, wordt voor elke SDS-klas een cohort aangemaakt en wordt het lidmaatschap gesynchroniseerd met de SDS-klas. Cohorten worden aangemaakt in de context van de cursuscategorie (school- of vakcategorie, afhankelijk van je categorie-instellingen).<br />
<b>Opmerking:</b> Cohorten worden aangemaakt naast cursussen, niet in plaats daarvan. Zo kun je cohorten gebruiken voor site-brede inschrijving of groepering en toch met SDS gesynchroniseerde cursussen behouden.';
$string['settings_sds_cohort_include_teachers'] = 'Leraren in cohorten opnemen';
$string['settings_sds_cohort_include_teachers_desc'] = 'Als deze optie is ingeschakeld, worden leraren uit de SDS-klas samen met leerlingen aan het cohort toegevoegd. Als de optie is uitgeschakeld, worden alleen leerlingen aan cohorten toegevoegd.';
$string['settings_sds_enrolment_teacher_role'] = 'Rol van SDS-klasleraar in Moodle';
$string['settings_sds_enrolment_teacher_role_desc'] = 'Als "Inschrijvingen van SDS naar Moodle synchroniseren" is ingeschakeld, worden leraren in de SDS-klas met deze rol ingeschreven voor de verbonden Moodle-cursus.';
$string['settings_sds_enrolment_student_role'] = 'Rol van SDS-klasleerling in Moodle';
$string['settings_sds_enrolment_student_role_desc'] = 'Als "Inschrijvingen van SDS naar Moodle synchroniseren" is ingeschakeld, worden leerlingen in de SDS-klas met deze rol ingeschreven voor de verbonden Moodle-cursus.';
$string['settings_sds_profilesync_header'] = 'Synchronisatie van gebruikersprofiel';
$string['settings_sds_profilesync_header_desc'] = 'Elke SDS-school kan een gebruikersprofiel opslaan voor leraren en leden van de school. Het veld is schoolspecifiek, d.w.z. verschillende scholen kunnen verschillende waarden hebben in hetzelfde veld voor dezelfde gebruiker.<br/>
Als in deze sectie een school is geselecteerd, kunnen de SDS-gebruikersprofielvelden worden geconfigureerd in de gebruikersveldtoewijzing.
<ul>
<li>Houd er rekening mee dat synchronisatie van SDS-velden alleen plaatsvindt bij het uitvoeren van de geplande taak "Synchroniseren met SDS" en niet bij het uitvoeren van de geplande taak "Gebruikers synchroniseren met Microsoft Entra ID", noch wanneer een gebruiker zich aanmeldt.</li>
<li>Houd er rekening mee dat er een bekend probleem is in de Microsoft Graph API die door deze functie wordt gebruikt, waardoor bepaalde schoolprofielvelden van leerlingen en leraren niet worden geretourneerd en dus niet beschikbaar zijn voor synchronisatie, ook al zijn ze geconfigureerd.</li>
</ul>
';
$string['settings_sds_profilesync_disabled'] = 'Uitgeschakeld';
$string['settings_sds_profilesync'] = 'Profielgegevens van school synchroniseren';
$string['settings_sds_profilesync_desc'] = 'Selecteer de SDS-school waarvan Moodle SDS-specifieke profielgegevens synchroniseert.';
$string['settings_sds_noschools'] = '<div class="alert alert-info">Je hebt geen scholen beschikbaar in SDS.</div>';
$string['settings_sds_get_schools_error'] = '<div class="alert alert-info error">Het ophalen van SDS-scholen is mislukt. Controleer of de Microsoft Entra ID-app de vereiste machtiging heeft.</div>';
$string['settings_sds_school_disabled_action'] = 'Actie bij uitgeschakelde schoolsynchronisatie';
$string['settings_sds_school_disabled_action_desc'] = 'Actie die wordt uitgevoerd op reeds verbonden Moodle-cursussen wanneer synchronisatie voor een SDS-school wordt uitgeschakeld.';
$string['settings_sds_school_disabled_action_keep_connected'] = 'De Moodle-cursus verbonden houden met het Team';
$string['settings_sds_school_disabled_action_disconnect'] = 'De verbinding tussen de Moodle-cursus en het Team verbreken';
$string['settings_sds_school_unavailable'] = '{$a} (SDS-schoollijst momenteel niet beschikbaar)';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner'] = 'Met de Moodle-app voor <a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teams</a> heb je eenvoudig toegang tot je Moodle-cursussen en kun je erover samenwerken in Teams.';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Je Moodle-app voor Microsoft Teams instellen</h4>';
$string['settings_moodlesettingssetup'] = 'Moodle configureren';
$string['settings_check_moodle_settings'] = 'Moodle-instellingen controleren';
$string['settings_moodlesetup_checking'] = 'Controleren...';
$string['settings_notice_cookiesecureenabled'] = 'Alleen beveiligde cookies is succesvol ingeschakeld';
$string['settings_notice_cookiesecurealreadyenabled'] = 'Alleen beveiligde cookies was al ingeschakeld';
$string['settings_notice_oidcenabled'] = 'OpenID Connect is succesvol ingeschakeld';
$string['settings_notice_oidcnotenabled'] = 'OpenID Connect kon niet worden ingeschakeld';
$string['settings_notice_oidcalreadyenabled'] = 'OpenID Connect was al ingeschakeld';
$string['settings_notice_webservicesframealreadyenabled'] = 'Webservices waren al ingeschakeld en het insluiten van frames is ook toegestaan';
$string['settings_notice_webservicesframeenabled'] = 'Webservices zijn succesvol ingeschakeld en het insluiten van frames is nu ook toegestaan';
$string['settings_notice_restenabled'] = 'REST-protocol is succesvol ingeschakeld';
$string['settings_notice_restnotenabled'] = 'REST-protocol kon niet worden ingeschakeld';
$string['settings_notice_restalreadyenabled'] = 'REST-protocol was al ingeschakeld';
$string['settings_notice_o365serviceenabled'] = 'Microsoft 365-webservices zijn succesvol ingeschakeld';
$string['settings_notice_o365servicealreadyenabled'] = 'Microsoft 365-webservices waren al ingeschakeld';
$string['settings_notice_createtokenallowed'] = 'Toestemming om een webservicetoken aan te maken is verleend';
$string['settings_notice_createtokenalreadyallowed'] = 'Toestemming om een webservicetoken aan te maken was al verleend';
$string['settings_notice_createtokennotallowed'] = 'Er is een probleem opgetreden bij het verlenen van toestemming om een webservicetoken aan te maken';
$string['settings_notice_restusageallowed'] = 'Toestemming om het REST-protocol te gebruiken is verleend';
$string['settings_notice_restusagealreadyallowed'] = 'Toestemming om het REST-protocol te gebruiken was al verleend';
$string['settings_notice_restusagenotallowed'] = 'Er is een probleem opgetreden bij het verlenen van toestemming om het REST-protocol te gebruiken';
$string['settings_moodlesettingssetup_details'] = 'Hiermee wordt gezorgd dat:
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>Alleen beveiligde cookies is ingeschakeld.</li>
<li>OpenID Connect is ingeschakeld.</li>
<li>Insluiten van frames is ingeschakeld.</li>
<li>Webservices zijn ingeschakeld.</li>
<li>REST-protocol is ingeschakeld.</li>
<li>Microsoft 365-webservices zijn ingeschakeld.</li>
<li>De geauthenticeerde gebruiker toestemming heeft om een webservicetoken aan te maken.</li>
<li>De geauthenticeerde gebruiker toestemming heeft om het REST-protocol te gebruiken.</li>
</ul>';
$string['settings_teams_moodle_app_external_id'] = 'Microsoft-app-ID voor de Moodle Teams-app';
$string['settings_teams_moodle_app_external_id_desc'] = 'Dit moet op de standaardwaarde zijn ingesteld, tenzij in je tenant meerdere Moodle Teams-apps nodig zijn om verbinding te maken met verschillende Moodle-sites.';
$string['settings_teams_moodle_app_short_name'] = 'Naam van de Teams-app';
$string['settings_teams_moodle_app_short_name_desc'] = 'Dit kan op de standaardwaarde worden ingesteld, tenzij in je tenant meerdere Moodle Teams-apps nodig zijn om verbinding te maken met verschillende Moodle-sites.';
$string['settings_download_teams_tab_app_manifest'] = 'Manifestbestand downloaden';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Sla al je wijzigingen op voordat je het manifest downloadt.';
$string['settings_publish_manifest_instruction'] = '<a href="https://learn.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Klik hier</a> om te leren hoe je je gedownloade Moodle-app-manifestbestand publiceert voor alle gebruikers in Teams.';
$string['settings_teams_moodle_tab_name'] = 'Naam van het Moodle-tabblad in Teams';
$string['settings_teams_moodle_tab_name_desc'] = 'Dit is de naam van het Moodle-tabblad in Teams.';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'Moodle-app-ID';
$string['settings_moodle_app_id_desc'] = 'ID van de geüploade Moodle-app in de Teams-appcatalogi.<br/>
Indien geconfigureerd, probeert Moodle een Moodle-tabblad aan te maken dat linkt naar de Moodle-cursus in het kanaal "Algemeen" van het aangemaakte/verbonden Team.';
$string['settings_moodle_app_id_desc_auto_id'] = '<br/>
Automatisch gedetecteerde waarde is "<span class="local_o365_settings_moodle_app_id">{$a}</span>".';
$string['settings_set_moodle_app_id_instruction'] = 'Volg deze stappen om de Moodle-app-ID handmatig te vinden:
<ol>
<li>Upload het gedownloade manifestbestand naar de Teams-appcatalogus van je tenant.</li>
<li>Zoek de app in de Teams-appcatalogus.</li>
<li>Klik op het optiepictogram van de app, dat zich in de rechterbovenhoek van de afbeelding van de app bevindt.</li>
<li>Klik op "Link kopiëren".</li>
<li>Plak de gekopieerde inhoud in een teksteditor. Deze zou een URL moeten bevatten zoals https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
Het laatste deel van de URL, d.w.z. <span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>, is de app-ID.';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Outlook-agendasynchronisatie inschakelen';
$string['calendar_user'] = 'Persoonlijke kalender (gebruiker)';
$string['calendar_site'] = 'Sitekalender';
$string['personal_calendar'] = 'Persoonlijk';
$string['calendar_event'] = 'Details bekijken';
$string['eventcalendarsubscribed'] = 'Gebruiker heeft zich geabonneerd op een kalender';
$string['eventcalendarunsubscribed'] = 'Gebruiker heeft abonnement op een kalender opgezegd';

// Errors.
$string['erroracpauthoidcnotconfig'] = 'Stel eerst in auth_oidc toepassingsreferenties in.';
$string['errorhttpclientbadtempfileloc'] = 'Kan tijdelijke locatie niet openen om bestand op te slaan.';
$string['errorhttpclientnofileinput'] = 'Geen bestandsparameter in httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Kan vernieuwingstoken niet vernieuwen';
$string['errormfarequired'] = 'Microsoft vereist meervoudige verificatie voordat Moodle toegang kan krijgen tot je Microsoft 365-account. Meld je af bij Moodle, meld je vervolgens opnieuw aan met je Microsoft 365-account en voltooi de melding voor meervoudige verificatie.';
$string['errorgetapplicationtoken'] = 'Kon het toepassingstoken niet ophalen. Controleer je integratieconfiguratie.';
$string['erroracpapcantgettenant'] = 'Kon de Microsoft Entra-tenant niet ophalen. Voer deze handmatig in.';
$string['erroracpcantgettenant'] = 'Kon de OneDrive-URL niet ophalen. Voer deze handmatig in.';
$string['errorprovisioningapp'] = 'Kon de Moodle-app niet inrichten in het Team.';
$string['erroro365apibadcall'] = 'Fout in API-aanroep.';
$string['erroro365apibadcall_message'] = 'Fout in API-aanroep: {$a}';
$string['erroro365apiinvalidtoken'] = 'Ongeldige of verlopen token.';
$string['erroro365apiinvalidmethod'] = 'Ongeldige httpmethod doorgegeven aan apicall';
$string['erroro365apinotimplemented'] = 'Dit moet worden overschreven.';
$string['erroro365apinotoken'] = 'Heb geen token voor gegeven bron en gebruiker en kan er geen krijgen. Is de vernieuwingstoken van de gebruiker verlopen?';
$string['errorusermatched'] = 'Het Microsoft 365-account "{$a->entraidupn}" is al gekoppeld aan Moodle-gebruiker "{$a->username}". Om de verbinding te voltooien, meld je je eerst aan als die Moodle-gebruiker en volg je de instructies in het Microsoft-blok.';
$string['errornodirectaccess'] = 'Directe toegang tot de pagina is verboden';
$string['eventapifail'] = 'API-fout';
$string['errorunabletofindgraphapi'] = 'Kan de Microsoft Graph API niet vinden in de toepassing.';
$string['erroremptyjwt'] = 'Leeg JWT-token opgegeven';
$string['errornocachedjwks'] = 'Geen gecachete JWKS gevonden';
$string['errorfetchjwks'] = 'Ophalen van JWKS van Microsoft mislukt';
$string['errorinvalidjwks'] = 'Ongeldige JWKS-indeling ontvangen van Microsoft';
$string['errorjwtvalidation'] = 'JWT-validatie mislukt';
$string['errorjwtinvalidissuer'] = 'Validatie van JWT-uitgever mislukt';
$string['errorcannotgettoken'] = 'Kon geen app- of systeemtoken ophalen.';
$string['errornotokenforsysmemuser'] = 'Geen token beschikbaar voor de systeemgebruiker. Voer de statuscontrole van local_o365 uit.';
$string['errornotoken'] = 'Geen token beschikbaar voor gebruiker #{$a}';
$string['errornotokenforusersync'] = 'Geen token beschikbaar voor gebruikerssynchronisatie.';
$string['errornoapifound'] = 'Geen API met identificatie {$a} gevonden.';
$string['errornoresponsesavailable'] = 'Geen antwoorden beschikbaar.';
$string['erroro365badphoto'] = 'Ongeldige profielfoto ontvangen van Microsoft 365.';
$string['erroro365nophoto'] = 'Deze gebruiker heeft geen foto in Microsoft 365.';
$string['errorcannotgetapiclient'] = 'Kan de Graph API-client niet ophalen.';
$string['errorfailedtogetsecrets'] = 'Kon geheimen niet ophalen.';
$string['errorfailedtosendnotification'] = 'Kon de notificatie-e-mail niet naar een of meer ontvangers verzenden.';
$string['errorsecretexpiryrecipientundeliverable'] = 'Een of meer geconfigureerde ontvangers van de notificatie over het verlopen van geheimen kunnen geen e-mail ontvangen (ongeldig adres, of een domein zonder MX/A-record): {$a}. Werk de notificatieontvangers bij in de OpenID Connect-instellingen.';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Lokale plugin voor Microsoft 365';
$string['privacy:metadata:local_o365_calidmap'] = 'Informatie over koppelingen tussen Microsoft 365-agenda-gebeurtenissen en Moodle-agenda-gebeurtenissen.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'De ID van de gebruiker die eigenaar is van de gebeurtenis.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'Waar de gebeurtenis vandaan komt. Moodle of Microsoft 365.';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'De ID van de gebeurtenis in Outlook.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'De ID van de gebeurtenis in Moodle.';
$string['privacy:metadata:local_o365_calsub'] = 'Informatie over synchronisatieabonnementen tussen Moodle- en Outlook-agenda\'s';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'De ID van de Moodle-gebruiker voor wie het abonnement is';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'Het type Moodle-agenda (site, cursus, gebruiker)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'De bijbehorende ID van de Moodle-agenda';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'De ID van de Microsoft 365-agenda';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Of dit de primaire agenda is';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'Het synchronisatiegedrag (d.w.z. van Moodle naar Outlook of van Outlook naar Moodle)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'Het tijdstip waarop het abonnement is aangemaakt.';
$string['privacy:metadata:local_o365_connections'] = 'Informatie over verbindingen tussen Moodle- en Microsoft 365-gebruikers die nog niet zijn bevestigd';
$string['privacy:metadata:local_o365_connections:muserid'] = 'De ID van de Moodle-gebruiker';
$string['privacy:metadata:local_o365_connections:entraidupn'] = 'De UPN van de Microsoft Entra ID-gebruiker.';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Of de authenticatiemethode van de gebruiker moet worden gewijzigd wanneer de koppeling is voltooid.';
$string['privacy:metadata:local_o365_token'] = 'Informatie over Microsoft 365 API-tokens voor gebruikers';
$string['privacy:metadata:local_o365_token:user_id'] = 'De ID van de Moodle-gebruiker';
$string['privacy:metadata:local_o365_token:scope'] = 'De scope van het token.';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'De bron van het token.';
$string['privacy:metadata:local_o365_token:token'] = 'Het token.';
$string['privacy:metadata:local_o365_token:expiry'] = 'De verlooptijd van het token.';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'Het vernieuwingstoken.';
$string['privacy:metadata:local_o365_objects'] = 'Informatie over de relatie tussen Moodle- en Microsoft 365-objecten';
$string['privacy:metadata:local_o365_objects:type'] = 'Het type object (groep, gebruiker, cursus, enz.)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'Het subtype van het object.';
$string['privacy:metadata:local_o365_objects:objectid'] = 'De Microsoft 365-object-ID';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'De ID van het object in Moodle';
$string['privacy:metadata:local_o365_objects:o365name'] = 'De leesbare naam van het object in Microsoft 365';
$string['privacy:metadata:local_o365_objects:tenant'] = 'De tenant waartoe het object behoort (in multitenancy-omgevingen)';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Eventuele bijbehorende metagegevens';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'Het tijdstip waarop de record is aangemaakt.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'Het tijdstip waarop de record is gewijzigd.';
$string['privacy:metadata:local_o365_appassign'] = 'Informatie over roltoewijzingen voor Microsoft 365-apps';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'De ID van de Moodle-gebruiker';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Of de gebruiker aan de app is toegewezen';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'De ID van de foto van de gebruiker in Microsoft 365';
$string['privacy:metadata:local_o365_appassign:photohash'] = 'Een SHA-256-hash van de bytes van de profielfoto van de gebruiker, opgeslagen om fotowijzigingen te detecteren zonder de volledige afbeelding opnieuw op te halen';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Wanneer de foto van de gebruiker voor het laatst vanuit Microsoft 365 is bijgewerkt';
$string['privacy:metadata:local_o365_matchqueue'] = 'Informatie over het koppelen van Moodle-gebruikers aan Microsoft 365-gebruikers';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'De gebruikersnaam van de Moodle-gebruiker.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'De gebruikersnaam van de Microsoft 365-gebruiker.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Of de gebruiker moet worden overgezet naar OpenID Connect-authenticatie wanneer de koppeling tot stand komt';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Of de record is verwerkt';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'De foutmelding (indien aanwezig)';
$string['privacy:metadata:preference:suspendedtime'] = 'Het tijdstip waarop de gebruiker door de gebruikerssynchronisatie is opgeschort, omdat het bijbehorende Microsoft Entra ID-account is verwijderd of is uitgeschakeld.';
$string['privacy:metadata:local_o365_calsettings'] = 'Informatie over instellingen voor agendasynchronisatie';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'De ID van de Moodle-gebruiker';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'De ID van de agenda in Microsoft 365';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'Het tijdstip waarop de record is aangemaakt.';
$string['privacy:metadata:preference:calsync_initialised'] = 'Of de keuzes voor Outlook-agendasynchronisatie van de gebruiker zijn geïnitialiseerd, zodat ze niet opnieuw automatisch worden ingeschakeld.';

// Page "Microsoft 365 / Moodle Control Panel" in the Microsoft block.
$string['ucp_title'] = 'Microsoft 365-/Moodle-configuratiescherm';
$string['ucp_general_intro'] = 'Hier kun je de verbinding met Microsoft 365 beheren.';
$string['ucp_calsync_availcal'] = 'Beschikbare Moodle-kalenders';
$string['ucp_calsync_title'] = 'Outlook Agenda synchroniseren';
$string['ucp_calsync_desc'] = 'Gecontroleerde kalenders in Moodle worden gesynchroniseerd met je Outlook Agenda.';
$string['ucp_connection_options'] = 'Verbindingsopties:';
$string['ucp_connection_desc'] = 'Hier kun je configureren hoe je verbinding maakt met Microsoft 365. Om Microsoft 365-functies te gebruiken, moet je zijn verbonden met een Microsoft 365-account. Dit kan zoals hieronder beschreven.';
$string['ucp_connection_entraidlogin'] = 'Gebruik je Microsoft 365-referenties om je aan te melden bij Moodle<br />';
$string['ucp_connection_entraidlogin_desc_authcode'] = 'In plaats van een gebruikersnaam en wachtwoord in te voeren op de Moodle-aanmeldpagina, zie je op de aanmeldpagina een sectie met de tekst "Aanmelden met je account op {$a}". Je klikt op de link en wordt doorgestuurd naar Microsoft 365 om je aan te melden. Nadat je je succesvol bij Microsoft 365 hebt aangemeld, word je teruggestuurd naar Moodle en ben je aangemeld bij je account.';
$string['ucp_connection_entraidlogin_start'] = 'Begin Microsoft 365 te gebruiken om je aan te melden bij Moodle.';
$string['ucp_connection_entraidlogin_stop'] = 'Stop met het gebruik van Microsoft 365 om je aan te melden bij Moodle.';
$string['ucp_connection_entraidlogin_active'] = 'Je gebruikt het Microsoft 365-account "{$a}" om je aan te melden bij Moodle.';
$string['ucp_connection_linked'] = 'Je Moodle- en Microsoft 365-accounts koppelen';
$string['ucp_connection_linked_desc'] = 'Door je Moodle- en Microsoft 365-accounts te koppelen, kun je Microsoft 365-functies in Moodle gebruiken zonder te wijzigen hoe je je bij Moodle aanmeldt. <br />Als je op de link hieronder klikt, word je naar Microsoft 365 gestuurd om je eenmalig aan te melden, waarna je hier wordt teruggestuurd. Je kunt dan alle Microsoft 365-functies gebruiken zonder andere wijzigingen in je Moodle-account aan te brengen - je meldt je bij Moodle aan zoals je altijd hebt gedaan.';
$string['ucp_connection_linked_active'] = 'Je bent gekoppeld aan Microsoft 365-account "{$a}".';
$string['ucp_connection_linked_start'] = 'Koppel je Moodle-account aan een Microsoft 365-account.';
$string['ucp_connection_linked_migrate'] = 'Overschakelen naar gekoppeld account.';
$string['ucp_connection_linked_stop'] = 'Heft de koppeling van je Moodle-account met het Microsoft 365-account op.';
$string['ucp_connection_disconnected'] = 'Je bent niet verbonden met Microsoft 365.';
$string['ucp_features'] = 'Microsoft 365-functies';
$string['ucp_features_intro'] = 'Hieronder vind je een lijst met functies waarmee je Moodle met Microsoft 365 kunt verbeteren.';
$string['ucp_features_intro_notconnected'] = ' Enkele daarvan zijn misschien pas beschikbaar wanneer je bent verbonden met Microsoft 365.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Om verbinding te maken met Microsoft 365 moet je contact opnemen met je sitebeheerder.';
$string['ucp_index_calendar_title'] = 'Outlook Agenda synchroniseren';
$string['ucp_index_calendar_desc'] = 'Hier kun je de synchronisatie tussen je Moodle- en Outlook-kalenders instellen. Je kunt Moodle-kalendergebeurtenissen exporteren naar Outlook en je Outlook-gebeurtenissen importeren in Moodle.';
$string['ucp_index_connection_title'] = 'Verbindingsinstellingen voor Microsoft 365';
$string['ucp_index_connection_desc'] = 'Configureer hoe je verbinding maakt met Microsoft 365.';
$string['ucp_index_connectionstatus_title'] = 'Verbindingsstatus';
$string['ucp_index_connectionstatus_login'] = 'Klik hier om je aan te melden.';
$string['ucp_index_connectionstatus_usinglogin'] = 'Je gebruikt momenteel Microsoft 365 om je aan te melden bij Moodle.';
$string['ucp_index_connectionstatus_usinglinked'] = 'Je bent gekoppeld aan een Microsoft 365-account.';
$string['ucp_index_connectionstatus_manage'] = 'Verbinding beheren';
$string['ucp_index_connectionstatus_reconnect'] = 'Verbinding vernieuwen';
$string['ucp_index_connectionstatus_connected'] = 'Je bent momenteel verbonden met Microsoft 365';
$string['ucp_index_connectionstatus_matched'] = 'Je bent gekoppeld aan Microsoft 365-gebruiker <small>"{$a}"</small>. Klik op onderstaande koppeling en meld je aan bij Microsoft 365 om deze verbinding te voltooien.';
$string['ucp_index_connectionstatus_notconnected'] = 'Je bent momenteel niet verbonden met Microsoft 365';
$string['ucp_notconnected'] = 'Maak eerst verbinding met Microsoft 365 voordat je hier naartoe gaat.';
$string['ucp_status_enabled'] = 'Actief';
$string['ucp_status_disabled'] = 'Niet verbonden';
$string['ucp_syncwith_title'] = 'Naam van de Outlook-agenda waarmee moet worden gesynchroniseerd:';
$string['ucp_syncdir_title'] = 'Synchronisatiegedrag:';
$string['ucp_syncdir_out'] = 'Van Moodle naar Outlook';
$string['ucp_syncdir_in'] = 'Van Outlook naar Moodle';
$string['ucp_syncdir_both'] = 'Zowel Outlook als Moodle bijwerken';
$string['ucp_o365accountconnected'] = 'Dit Microsoft 365-account is al verbonden met een ander Moodle-account.';

// Tasks.
$string['task_calendarsyncin'] = 'Microsoft 365-gebeurtenissen synchroniseren met Moodle';
$string['task_coursesync'] = 'Moodle-cursussen synchroniseren met Microsoft Teams';
$string['task_coursemembershipsync'] = 'Microsoft Teams-eigenaars en -leden synchroniseren met Moodle-cursussen';
$string['task_groupmembershipsync'] = 'Moodle-cursuseigenaars en -deelnemers synchroniseren met Microsoft 365-groepen';
$string['task_sds_sync'] = 'Synchroniseren met SDS';
$string['task_syncusers'] = 'Gebruikers synchroniseren met Microsoft Entra ID';
$string['task_syncusersphotostimezones'] = 'Gebruikersfoto\'s en tijdzones synchroniseren vanuit Microsoft Entra ID';
$string['task_calsyncautosubscribe'] = 'Agendasynchronisatie automatisch inschakelen voor verbonden gebruikers';
$string['task_groupchannelsync'] = 'Teams-kanalen voor Moodle-groepen aanmaken en hun leden synchroniseren';
$string['task_groupchannelsyncgroup'] = 'Het Teams-kanaal van een Moodle-groep aanmaken en de leden ervan synchroniseren';
$string['task_userenabledstatussync'] = 'Gebruikers opschorten/opnieuw inschakelen/verwijderen op basis van de status in Microsoft Entra ID';
$string['task_processmatchqueue'] = 'Koppelwachtrij verwerken';
$string['task_notifysecretexpiry'] = 'Sitebeheerder informeren over het verlopen van het geheim van de Microsoft Entra ID-app';
$string['task_checkinvalidconfiglog'] = 'Ongeldige configuratielogrecords controleren en opschonen';
$string['task_usergroupmembershipsync'] = 'Cursusgroepslidmaatschap van gebruikers synchroniseren met Microsoft 365';
$string['task_processmatchqueue_err_museralreadymatched'] = 'Moodle-gebruiker is al gekoppeld aan een Microsoft 365-gebruiker.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'Moodle-gebruiker is al verbonden met Microsoft 365.';
$string['task_processmatchqueue_err_nomuser'] = 'Geen Moodle-gebruiker gevonden met deze gebruikersnaam.';
$string['task_processmatchqueue_err_noo365user'] = 'Geen Microsoft 365-gebruiker gevonden met deze gebruikersnaam.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'Microsoft 365-gebruiker is al gekoppeld aan een Moodle-gebruiker.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'Microsoft 365-gebruiker is al verbonden met een Moodle-gebruiker.';

// Capabilities.
$string['o365:manageconnectionlink'] = 'Koppeling van verbinding beheren';
$string['o365:manageconnectionunlink'] = 'Opheffen van koppeling van verbinding beheren';
$string['o365:managecoursesync'] = 'Teams-synchronisatie voor cursussen in- of uitschakelen via webservices';
$string['o365:viewgroups'] = 'Links naar Microsoft 365-services bekijken in het Microsoft-blok in cursussen waarvoor synchronisatie is ingeschakeld';
$string['o365:managegroups'] = 'Links naar Microsoft 365-services en beheeropties bekijken in het Microsoft-blok in cursussen waarvoor synchronisatie is ingeschakeld';
$string['o365:teammember'] = 'Team-lid';
$string['o365:teamowner'] = 'Team-eigenaar';

// Cache Stores.
$string['cachedef_groups'] = 'Slaat Microsoft 365-groepsgegevens op';
$string['cachedef_jwks'] = 'Slaat Microsoft JWKS-sleutels op';

// Web service errors.
$string['webservices_error_assignnotfound'] = 'De opdrachtrecord van de ontvangen module kon niet worden gevonden.';
$string['webservices_error_invalidassignment'] = 'De ontvangen opdracht-ID kan niet worden gebruikt met deze webservicefunctie.';
$string['webservices_error_modulenotfound'] = 'De ontvangen module-ID kon niet worden gevonden.';
$string['webservices_error_sectionnotfound'] = 'De cursussectie kon niet worden gevonden.';
$string['webservices_error_couldnotsavegrade'] = 'Kon de beoordeling niet opslaan.';

// User sync task help text.
$string['help_user_create'] = 'Help bij accounts aanmaken';
$string['help_user_create_help'] = 'Hiermee worden in Moodle gebruikers aangemaakt voor elke gebruiker in de gekoppelde Microsoft Entra ID. Alleen voor gebruikers die momenteel geen Moodle-account hebben, worden accounts aangemaakt. Nieuwe accounts worden ingesteld met de OpenID Connect-authenticatiemethode met hun Microsoft Entra ID-profiel en kunnen alle integratiefuncties van Microsoft 365/Moodle gebruiken.';
$string['help_user_update'] = 'Help bij alle accounts bijwerken';
$string['help_user_update_help'] = 'Hiermee worden alle gebruikers in Moodle bijgewerkt vanuit elke gebruiker in de gekoppelde Microsoft Entra ID.';
$string['help_user_suspend'] = 'Help bij accounts opschorten';
$string['help_user_suspend_help'] = 'Hiermee worden gebruikers in Moodle opgeschort als ze in Microsoft Entra ID als verwijderd zijn gemarkeerd.';
$string['help_user_delete'] = 'Help bij accounts verwijderen';
$string['help_user_delete_help'] = 'Hiermee worden gebruikers uit Moodle verwijderd als ze in Microsoft Entra ID als verwijderd zijn gemarkeerd. Dit werkt alleen als de optie voor het opschorten van gebruikers is ingeschakeld. Het Moodle-account wordt verwijderd en alle bijbehorende gebruikersgegevens worden uit Moodle verwijderd. Wees voorzichtig! Opmerking: Standaard vindt verwijdering 30 dagen nadat het account in Microsoft Entra ID is verwijderd plaats, vanwege de bewaartermijn voor voorlopig verwijderen van Entra ID (accounts kunnen in die periode worden hersteld). Met de instelling "Wachttijd voordat opgeschorte gebruikers worden verwijderd" kan een langere vertraging tussen opschorting en verwijdering worden ingesteld.';
$string['help_user_reenable'] = 'Help bij accounts opnieuw inschakelen';
$string['help_user_reenable_help'] = 'Hiermee worden opgeschorte Moodle-accounts opnieuw ingeschakeld als ze uit Microsoft Entra ID worden geretourneerd en zich mogen aanmelden. Accounts die in Microsoft Entra ID zijn geblokkeerd voor aanmelden (uitgeschakeld), blijven opgeschort.';
$string['help_user_disabledsyncsuspend'] = 'Help bij accounts opschorten bij uitschakelen';
$string['help_user_disabledsyncsuspend_help'] = 'Hiermee worden gebruikers in Moodle opgeschort als hun verbonden accounts in Microsoft Entra ID geen toestemming hebben om zich aan te melden (uitgeschakeld), zonder te wijzigen of ze automatisch opnieuw worden ingeschakeld als hun Microsoft Entra ID-account weer wordt ingeschakeld. Gebruik de optie \'Accounts in Moodle opnieuw inschakelen wanneer ze opnieuw zijn ingeschakeld in Microsoft Entra ID\' hieronder om dat afzonderlijk te regelen.';
$string['help_user_groupsyncsuspend'] = 'Help bij accounts opschorten die niet in de synchronisatiegroep zitten';
$string['help_user_groupsyncsuspend_help'] = 'Hiermee worden gebruikers in Moodle opgeschort als ze nog actief zijn in Microsoft Entra ID maar geen lid of eigenaar zijn van de groep die is geconfigureerd in de instelling "Groepsfilter voor gebruikerssynchronisatie". De controle gebeurt alleen op het huidige lidmaatschap: er worden ook bestaande gesynchroniseerde gebruikers opgeschort die nooit in de groep hebben gezeten, niet alleen gebruikers die de groep hebben verlaten. Controleer je groep dus voordat je deze optie inschakelt. Deze optie is alleen beschikbaar wanneer een groepsfilter voor gebruikerssynchronisatie is geconfigureerd. Om massale opschorting te voorkomen, wordt niets opgeschort als de groep leeg blijkt te zijn of de leden niet kunnen worden opgehaald. Opgeschorte gebruikers worden niet opnieuw ingeschakeld zolang ze niet in de groep zitten.';
$string['help_user_disabledsyncreenable'] = 'Help bij accounts opnieuw inschakelen bij inschakelen';
$string['help_user_disabledsyncreenable_help'] = 'Hiermee wordt de opschorting van opgeschorte gebruikers in Moodle opgeheven als hun verbonden accounts in Microsoft Entra ID zich weer mogen aanmelden (ingeschakeld).';
$string['help_user_suspendnolink'] = 'Help bij accounts zonder Microsoft-koppeling opschorten';
$string['help_user_suspendnolink_help'] = 'Normaal gesproken werken de bovenstaande opties voor opschorten/uitschakelen alleen op accounts die een opgeslagen Microsoft Entra ID-objectrecord hebben (aangemaakt toen het account werd gesynchroniseerd of verbonden). Sommige OpenID Connect-accounts hebben zo\'n record niet - bijvoorbeeld omdat ze verbinding hebben gemaakt voordat de Microsoft Graph API was geconfigureerd, of omdat de record is verwijderd door een verbreking van de verbinding of een actie \'gekoppelde gebruikers wissen\'. Met deze optie controleert de statustaak ook die accounts, door de Moodle-gebruikersnaam te vergelijken met de geconfigureerde waarde van de gebruikersnaamclaim voor de koppeling in Entra ID.

Gekoppelde accounts die in Entra ID ontbreken of daar zijn uitgeschakeld, worden <strong>alleen opgeschort</strong>: ze worden nooit verwijderd (zonder opgeslagen object-ID kan de bewaartermijn voor voorlopig verwijderen van Entra ID niet worden gecontroleerd) en nooit automatisch opnieuw ingeschakeld. Gastaccounts worden overgeslagen.

Deze optie werkt wanneer de gebruikersnaamclaim voor de koppeling van OpenID Connect is ingesteld op "auto" of op een specifiek veld dat in Entra ID kan worden opgezocht - "upn", "oid", "email" of "samaccountname". Bij "auto" wordt de Moodle-gebruikersnaam vergeleken met de user principal name van Entra ID, en een account wordt ook als aanwezig in Entra ID beschouwd wanneer de gebruikersnaam of het e-mailadres overeenkomt met een e-mailadres in Entra ID, zodat het niet per vergissing wordt opgeschort. Bij een andere claim kan de Moodle-gebruikersnaam niet betrouwbaar aan één account worden gekoppeld en doet deze optie niets.

Controleer je opgeschorte gebruikers na de eerste uitvoering: een account dat handmatig naar deze authenticatiemethode is overgezet en nooit een echte Entra ID-gebruiker was, wordt door deze optie opgeschort.';
$string['help_user_match'] = 'Help bij accounts koppelen';
$string['help_user_match_help'] = 'Hiermee wordt elke gebruiker in de gekoppelde Microsoft Entra ID bekeken en wordt geprobeerd deze te koppelen aan een gebruiker in Moodle. Deze koppeling is gebaseerd op de Microsoft Entra ID-UPN en de Moodle-gebruikersnaam. Overeenkomsten zijn niet hoofdlettergevoelig en negeren het domeingedeelte van de Microsoft Entra ID-UPN. Zo komt "BoB.SmiTh" in Moodle overeen met "bob.smith@example.onmicrosoft.com". Bij gekoppelde gebruikers worden hun Moodle- en Microsoft Entra ID-accounts verbonden en kunnen ze alle integratiefuncties van Microsoft 365 en Moodle gebruiken. De authenticatiemethode van de gebruiker wijzigt niet, tenzij de onderstaande instelling is ingeschakeld.';
$string['help_user_matchswitchauth'] = 'Help bij gekoppelde accounts overzetten';
$string['help_user_matchswitchauth_help'] = 'Hiervoor moet de bovenstaande instelling "Vooraf bestaande Moodle-gebruikers koppelen" zijn ingeschakeld. Wanneer een gebruiker is gekoppeld, wordt bij het inschakelen van deze instelling zijn of haar authenticatiemethode overgezet naar OpenID Connect. De gebruiker kan zich dan bij Moodle aanmelden met zijn of haar Microsoft 365-referenties. Opmerking: Zorg ervoor dat de OpenID Connect-authenticatieplugin is ingeschakeld als je deze instelling wilt gebruiken. Waarschuwing: als een Moodle-gebruikersnaam alleen overeenkomt met het gedeelte van de Microsoft Entra ID-UPN vóór de "@" (in plaats van de volledige UPN), kan de geavanceerde instelling \'Minimale lengte van onnauwkeurige gebruikersnaam om over te zetten naar Microsoft 365\' voorkomen dat de authenticatiemethode wordt overgezet voor gebruikers met korte gebruikersnamen.';
$string['help_user_appassign'] = 'Help bij gebruikers aan toepassing toewijzen';
$string['help_user_appassign_help'] = 'Hiermee worden alle Microsoft Entra ID-accounts met bijbehorende Moodle-accounts toegewezen aan de Microsoft Entra ID-app die voor deze Moodle-installatie is aangemaakt, als ze nog niet zijn toegewezen.';
$string['help_user_photosync'] = 'Help bij Microsoft 365-profielfoto\'s synchroniseren (cron)';
$string['help_user_photosync_help'] = 'Hiermee worden de Moodle-profielfoto\'s van alle gebruikers gesynchroniseerd met hun Microsoft 365-profielfoto\'s.';
$string['help_user_photosynconlogin'] = 'Help bij Microsoft 365-profielfoto\'s synchroniseren (aanmelden)';
$string['help_user_photosynconlogin_help'] = 'Hiermee wordt de Moodle-profielfoto van een gebruiker gesynchroniseerd met zijn of haar Microsoft 365-profielfoto wanneer die gebruiker zich aanmeldt. Dit vereist dat de gebruiker een pagina bezoekt die het Microsoft-blok in Moodle bevat.';
$string['help_user_nodelta'] = 'Help bij een volledige synchronisatie uitvoeren';
$string['help_user_nodelta_help'] = 'Standaard synchroniseert de gebruikerssynchronisatie alleen wijzigingen uit Microsoft Entra ID sinds de laatste keer dat de synchronisatie is uitgevoerd. Als je deze optie aanvinkt, wordt elke keer een volledige gebruikerssynchronisatie afgedwongen.';
$string['help_user_emailsync'] = 'Help bij Microsoft Entra ID-gebruikersnamen synchroniseren met Moodle-e-mailadressen';
$string['help_user_emailsync_help'] = 'Als je deze optie inschakelt, worden Microsoft Entra ID-gebruikersnamen gekoppeld aan Moodle-e-mailadressen, in plaats van het standaardgedrag waarbij Microsoft Entra ID-gebruikersnamen aan Moodle-gebruikersnamen worden gekoppeld.';
$string['help_user_tzsync'] = 'Help bij Outlook-tijdzone synchroniseren (cron)';
$string['help_user_tzsync_help'] = 'Hiermee wordt de Moodle-tijdzone van alle gebruikers gesynchroniseerd met hun Outlook-tijdzonevoorkeur.';
$string['help_user_tzsynconlogin'] = 'Help bij Outlook-tijdzone synchroniseren (aanmelden)';
$string['help_user_tzsynconlogin_help'] = 'Hiermee wordt de Moodle-tijdzone van een gebruiker gesynchroniseerd met zijn of haar Outlook-tijdzonevoorkeur. Dit vereist dat de gebruiker een pagina bezoekt die het Microsoft-blok in Moodle bevat.';
$string['help_user_guestsync'] = 'Help bij gastgebruikers synchroniseren';
$string['help_user_guestsync_help'] = 'Als deze optie is ingeschakeld, worden gastgebruikers in Microsoft Entra ID in de taak voor gebruikerssynchronisatie gesynchroniseerd naar Moodle.';

// Cohort sync feature.
$string['cohortsync_title'] = 'Cohortsynchronisatie';
$string['cohortsync_taskname'] = 'Cohortsynchronisatie';
$string['cohortsync_mappingadded'] = 'Nieuwe verbinding succesvol toegevoegd';
$string['cohortsync_mappingdeleted'] = 'Verbinding succesvol verwijderd';
$string['cohortsync_addmapping'] = 'Verbinding toevoegen';
$string['cohortsync_deletemapping'] = 'Verbinding verwijderen';
$string['cohortsync_desc'] = 'Deze pagina maakt eenrichtingssynchronisatie mogelijk van Microsoft 365-groepen naar Moodle-cohorten op systeemcontextniveau. Het toevoegen van een nieuwe verbinding start het synchronisatieproces - gebruikers uit de geselecteerde Microsoft 365-groep die met Microsoft zijn verbonden, worden toegevoegd aan het geselecteerde Moodle-cohort.';
$string['cohortsync_tabledesc'] = 'Huidige verbindingen tussen Microsoft 365-groepen en Moodle-cohorten';
$string['cohortsync_typetosearch'] = 'Typ om te zoeken naar een Microsoft 365-groep';
$string['cohortsync_typetosearch_cohort'] = 'Typ om te zoeken naar een Moodle-cohort';
$string['cohortsync_emptymatchings'] = 'Geen verbindingen gevonden';
$string['cohortsync_select_cohort'] = 'Moodle-cohort';
$string['cohortsync_select_group'] = 'Microsoft 365-groep';
$string['cohortsync_tablehead_group'] = 'Microsoft 365-groep';
$string['cohortsync_tablehead_cohort'] = 'Moodle-cohort';
$string['cohortsync_tablehead_actions'] = 'Acties';
$string['cohortsync_search'] = 'Zoeken';
$string['cohortsync_load_more'] = 'Meer laden...';
$string['cohortsync_no_groups_found'] = 'Geen Microsoft 365-groepen gevonden voor "{$a}"';
$string['cohortsync_no_cohorts_found'] = 'Geen Moodle-cohorten gevonden voor "{$a}"';
$string['cohortsync_error_no_group'] = 'Selecteer een Microsoft 365-groep.';
$string['cohortsync_error_no_cohort'] = 'Selecteer een Moodle-cohort.';
$string['cohortsync_mappingfailed'] = 'Fout bij het toevoegen van de verbinding tussen cohort en groep. Mogelijke oorzaken: de groep of het cohort bestaat niet, de groep is al verbonden met een ander cohort, de groep is al verbonden met dit cohort.';
$string['cohortsync_connectionnotfound'] = 'Ongeldig verzoek: verbinding niet gevonden.';
$string['cohortsync_connectionnotcohortsync'] = 'Ongeldig verzoek: verbindingstype komt niet overeen.';
$string['cohortsync_unifiedapierror'] = 'Fout bij het ophalen van de lijst met groepen van Microsoft.';

// Course request.
$string['courserequest_teams'] = 'Microsoft Team';
$string['courserequest_teams_help'] = 'Selecteer het Microsoft Team dat met de cursus wordt verbonden. Bestaande Team-eigenaars en -leden worden ingeschreven voor de aangemaakte cursus zodra de cursusaanvraag is goedgekeurd.';
$string['courserequest_emptyteams'] = 'Geen Microsoft Teams beschikbaar';
$string['courserequest_title'] = 'Cursus aanvragen vanuit Teams';
$string['courserequest_updatecourserequeststatus_taskname'] = 'Status van cursusaanvraag bijwerken';
$string['courserequest_customrequestnote'] = '
| Dit verzoek is gedaan vanaf de pagina voor cursusaanvragen van Microsoft Teams en wordt na goedkeuring verbonden met Team: "{$a->name}" met URL {$a->url}.';
$string['courserequest_graphapi_disabled'] = 'De verbinding met Microsoft Teams is niet beschikbaar. Neem contact op met je sitebeheerder.';
$string['courserequest_invalid_team'] = 'Ongeldig Team gebruikt in de cursusaanvraag.';
$string['courserequest_duplicate'] = 'Er bestaat al een openstaande of goedgekeurde cursusaanvraag van hetzelfde Team.';

// Teams page.
$string['teams_no_course'] = 'Je hebt geen cursus om toe te voegen.';
$string['tab_name'] = 'Tabbladnaam';
$string['sso_login'] = 'Aanmelden bij Microsoft 365';
$string['other_login'] = 'Handmatig aanmelden';
$string['course_selector_label'] = 'Bestaande cursus selecteren';

// Notifications to site admin about Microsoft Entra ID app secret.
$string['notification_subject_secret_expired'] = 'Actie vereist: geheim van Microsoft Entra ID-app is verlopen';
$string['notification_content_secret_expired'] = 'Geachte sitebeheerder,

Het geheim van de Microsoft Entra ID-app dat wordt gebruikt in je integratie van Moodle en Microsoft 365 is verlopen.
Maak een nieuw geheim aan in Microsoft Entra ID en werk het bij in de integratieconfiguratie om de integratie te herstellen.';
$string['notification_subject_secret_almost_expired'] = 'Actie vereist: geheim van Microsoft Entra ID-app verloopt binnenkort';
$string['notification_content_secret_almost_expired'] = 'Geachte sitebeheerder,

Het geheim van de Microsoft Entra ID-app dat wordt gebruikt in je integratie van Moodle en Microsoft 365 verloopt over {$a}.
Maak een nieuw geheim aan in Microsoft Entra ID en werk het bij in de integratieconfiguratie om verstoring van de integratie te voorkomen.';
$string['notification_days_less_than_one_day'] = 'minder dan 1 dag';
$string['notification_days_one_day'] = '1 dag';
$string['notification_days_days'] = '{$a} dagen';
$string['notification_subject_invalid_secret'] = 'Actie vereist: ongeldig geheim van Microsoft Entra ID-app aangetroffen';
$string['notification_content_invalid_secret'] = 'Geachte sitebeheerder,

Het geheim van de Microsoft Entra ID-app dat wordt gebruikt in je integratie van Moodle en Microsoft 365 lijkt ongeldig te zijn. Dit kan zijn veroorzaakt doordat het geheim is verlopen of is verwijderd.
Controleer het geheim om ervoor te zorgen dat de integratie werkt zoals verwacht.';

// Async operations.
$string['teamsasyncfailed'] = 'Asynchrone bewerking voor het aanmaken van een Team mislukt: {$a}';
$string['unknownasyncstate'] = 'Onbekende status van asynchrone bewerking: {$a}';

// Template ID validation.
$string['error_template_id_empty'] = 'De sjabloon-ID mag niet leeg zijn.';
$string['error_not_connected'] = 'Niet verbonden met Microsoft 365. Stel eerst de Microsoft 365-integratie in.';
$string['error_graph_client_not_available'] = 'Kan geen verbinding maken met de Microsoft Graph API. Controleer de installatie van je Microsoft 365-integratie.';
$string['success_template_id_valid'] = '✓ Sjabloon-ID "{$a}" is geldig en toegankelijk.';
$string['error_template_id_not_found'] = '✗ Sjabloon-ID "{$a}" is niet gevonden. Controleer de sjabloon-ID in het Teams-beheercentrum.';
$string['error_template_validation_failed'] = '✗ Validatie van sjabloon mislukt: {$a}';
$string['error_template_validation_error'] = '✗ Er is een fout opgetreden bij het valideren van de sjabloon. Probeer het opnieuw of neem contact op met je beheerder.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
