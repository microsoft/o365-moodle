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
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft';
$string['contactadmin'] = 'Ota yhteyttä ylläpitäjään saadaksesi lisätietoja.';
$string['error_nomoodlenotebook'] = 'Moodle-muistikirjaasi ei löytynyt.';
$string['error_urlrequiredwhenenabled'] = 'Tämä URL-osoite on määritettävä, koska yllä oleva "Näytä"-asetus on käytössä.';
$string['linkonedrive'] = 'Oma OneDrive';
$string['linkonenote'] = 'Oma OneNote-muistikirja';
$string['linksways'] = 'Omat Swayt';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsstreamclassic'] = 'Microsoft Stream (perinteinen)';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'Oma sähköposti';
$string['linkonenote_unavailable'] = 'OneNote ei ole käytettävissä';
$string['linksharepoint'] = 'Kurssin SharePoint-sivusto';
$string['linkoutlook'] = 'Outlook-kalenterin synkronointiasetukset';
$string['linkprefs'] = 'Muokkaa asetuksia';
$string['linkconnection'] = 'Microsoft 365 -yhteysasetukset';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = 'Lisää uusi Microsoft-lohko';
$string['microsoft:myaddinstance'] = 'Lisää Työpöydälle uusi Microsoft-lohko';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Moodle-muistikirja';
$string['workonthis'] = 'Työskentele tämän parissa';
$string['o365matched_title'] = 'Olet <span style="color: #960">melkein</span> yhdistetty Microsoft 365:een';
$string['o365matched_desc'] = 'Sinut on yhdistetty Microsoft 365 -käyttäjään <b>"{$a}"</b>';
$string['o365matched_complete_authreq'] = 'Viimeistele yhteys napsauttamalla alla olevaa linkkiä ja kirjautumalla tälle Microsoft 365 -tilille.';
$string['o365connected'] = '{$a->firstname}, olet tällä hetkellä <span class="notifysuccess">yhdistetty</span> Microsoft 365:een';
$string['notconnected'] = 'Et ole <span class="notifyproblem">yhdistetty</span> mihinkään Microsoft-palveluun.';
$string['course_connected_to_team'] = 'Kurssi on <span class="notifysuccess">yhdistetty</span> <b>tiimiin</b>.';
$string['course_connected_to_team_pending'] = 'Kurssi on määritetty yhdistettäväksi <b>tiimiin</b>, mutta tiimin luonti <span class="notifyproblem">odottaa</span>.';
$string['course_connected_to_group_pending'] = 'Kurssi on määritetty yhdistettäväksi <b>tiimiin</b>, mutta ryhmän luonti <span class="notifyproblem">odottaa</span>.';
$string['course_not_connected'] = 'Kurssia <span class="notifyproblem">ei ole yhdistetty</span> mihinkään Microsoft-palveluun.';
$string['cachedef_onenotenotebook'] = 'Tallentaa OneNote-muistikirjan.';
$string['logintoo365'] = 'Kirjaudu Microsoft 365:een';
$string['connecttoo365'] = 'Yhdistä Microsoft 365:een';
$string['install_office'] = 'Asenna Office';

// Microsoft 365 and Viva apps.
$string['linkword'] = 'Word';
$string['linkexcel'] = 'Excel';
$string['linkpowerpoint'] = 'PowerPoint';
$string['linkvivaengage'] = 'Viva Engage';
$string['linkvivaamplify'] = 'Viva Amplify';
$string['linkvivaconnections'] = 'Viva Connections';
$string['linkvivaglint'] = 'Viva Glint';
$string['linkvivagoals'] = 'Viva Goals';
$string['linkvivainsights'] = 'Viva Insights';
$string['linkvivalearning'] = 'Viva Learning';
$string['linkvivapulse'] = 'Viva Pulse';
$string['linklinkedin'] = 'LinkedIn';

// Configuration settings.
$string['settings_showemail'] = 'Näytä "Oma sähköposti"';
$string['settings_showemail_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Oma sähköposti" -linkki.';
$string['settings_showmydelve'] = 'Näytä "Oma Delve"';
$string['settings_showmydelve_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Oma Delve" -linkki.';
$string['settings_showmyforms'] = 'Näytä "Omat Formsit"';
$string['settings_showmyforms_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Omat Formsit" -linkki.';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = 'Näytä "Asenna Office"';
$string['settings_showo365download_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Asenna Office" -linkki.';
$string['settings_showsways'] = 'Näytä "Omat Swayt"';
$string['settings_showsways_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Omat Swayt" -linkki.';
$string['settings_showmsstream'] = 'Näytä "Microsoft Stream (SharePointissa)"';
$string['settings_showmsstream_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Microsoft Stream (SharePointissa)" -linkki.';
$string['settings_showmsstreamclassic'] = 'Näytä "Microsoft Stream (perinteinen)"';
$string['settings_showmsstreamclassic_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Microsoft Stream (perinteinen)" -linkki.';
$string['settings_showmsteams'] = 'Näytä "Microsoft Teams"';
$string['settings_showmsteams_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Microsoft Teams" -linkki.';
$string['settings_showonedrive'] = 'Näytä "Oma OneDrive"';
$string['settings_showonedrive_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Oma OneDrive" -linkki.';
$string['settings_showonenotenotebook'] = 'Näytä "Oma OneNote-muistikirja"';
$string['settings_showonenotenotebook_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Oma OneNote-muistikirja" -linkki.';
$string['settings_showoutlooksync'] = 'Näytä "Outlook-kalenterin synkronointiasetukset"';
$string['settings_showoutlooksync_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Outlook-kalenterin synkronointiasetukset" -linkki.';
$string['settings_showpreferences'] = 'Näytä "Muokkaa asetuksia"';
$string['settings_showpreferences_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Muokkaa asetuksia" -linkki.';
$string['settings_showo365connect'] = 'Näytä "Yhdistä Microsoft 365:een"';
$string['settings_showo365connect_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Yhdistä Microsoft 365:een" -linkki. <br /><b>Huomautus:</b> Linkki näytetään käyttäjille, joita ei ole yhdistetty Microsoft 365:een, ja se vie heidät sivulle, jolla he voivat muodostaa yhteyden.';
$string['settings_showmanageo365conection'] = 'Näytä "Microsoft 365 -yhteysasetukset"';
$string['settings_showmanageo365conection_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Microsoft 365 -yhteysasetukset" -linkki. <br /><b>Huomautus:</b> Linkki näytetään Microsoft 365:een yhdistetyille käyttäjille, ja se vie heidät yhteyden hallintasivulle.';
$string['settings_showcoursespsite'] = 'Näytä "Kurssin SharePoint-sivusto"';
$string['settings_showcoursespsite_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Kurssin SharePoint-sivusto" -linkki. <br /><b>Huomautus:</b> Linkki näytetään lohkossa, kun tarkastellaan kurssia, jolla on siihen liitetty SharePoint-sivusto.';
$string['settings_showcourselinks'] = 'Näytä kurssilinkit';
$string['settings_showcourselinks_desc'] = 'Ota käyttöön tai poista käytöstä koko lohkon kurssiosio, joka näytetään kurssia tarkasteltaessa, mukaan lukien kurssin tilaotsikko ja kaikki kurssilinkit. <br /><b>Huomautus:</b> Kun osio on poistettu käytöstä, alla olevat yksittäisten kurssilinkkien asetukset ohitetaan.';
$string['settings_showcourseconfiguresync'] = 'Näytä "Määritä kurssin synkronointi"';
$string['settings_showcourseconfiguresync_desc'] = 'Ota käyttöön tai poista käytöstä "Määritä kurssin synkronointi" -linkki lohkon kurssiosiossa.';
$string['settings_showcourseteam'] = 'Näytä "Tiimi"';
$string['settings_showcourseteam_desc'] = 'Ota käyttöön tai poista käytöstä "Tiimi"-linkki lohkon kurssiosiossa.';
$string['settings_showcourseconversations'] = 'Näytä "Outlook-keskustelut"';
$string['settings_showcourseconversations_desc'] = 'Ota käyttöön tai poista käytöstä "Outlook-keskustelut" -linkki lohkon kurssiosiossa.';
$string['settings_showcourseonedrive'] = 'Näytä "OneDrive-tiedostot"';
$string['settings_showcourseonedrive_desc'] = 'Ota käyttöön tai poista käytöstä "OneDrive-tiedostot" -linkki lohkon kurssiosiossa.';
$string['settings_showcoursecalendar'] = 'Näytä "Outlook-kalenteri"';
$string['settings_showcoursecalendar_desc'] = 'Ota käyttöön tai poista käytöstä "Outlook-kalenteri" -linkki lohkon kurssiosiossa.';
$string['settings_showcoursenotebook'] = 'Näytä "Luokan muistikirja"';
$string['settings_showcoursenotebook_desc'] = 'Ota käyttöön tai poista käytöstä "Luokan muistikirja" -linkki lohkon kurssiosiossa.';
$string['settings_showcoursereset'] = 'Näytä "Kurssin nollauksen asetukset"';
$string['settings_showcoursereset_desc'] = 'Ota käyttöön tai poista käytöstä "Kurssin nollauksen asetukset" -linkki lohkon kurssiosiossa.';
$string['settings_geto365link'] = 'Asenna Office -latauksen URL-osoite';
$string['settings_geto365link_desc'] = 'URL-osoite, jota käytetään "Asenna Office" -linkissä.';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['settings_showword'] = 'Näytä "Word"';
$string['settings_showword_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Word"-linkki.';
$string['settings_showexcel'] = 'Näytä "Excel"';
$string['settings_showexcel_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Excel"-linkki.';
$string['settings_showpowerpoint'] = 'Näytä "PowerPoint"';
$string['settings_showpowerpoint_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "PowerPoint"-linkki.';
$string['settings_showvivaengage'] = 'Näytä "Viva Engage"';
$string['settings_showvivaengage_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Viva Engage" -linkki.';
$string['settings_showvivaamplify'] = 'Näytä "Viva Amplify"';
$string['settings_showvivaamplify_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Viva Amplify" -linkki. <br /><b>Huomautus:</b> Myös alla oleva Viva Amplify -URL-osoite on määritettävä, jotta linkki näytetään.';
$string['settings_vivaamplifyurl'] = 'Viva Amplify -URL-osoite';
$string['settings_vivaamplifyurl_desc'] = 'Organisaatiosi Viva Amplify -palvelun URL-osoite Microsoft 365 -vuokraajasi järjestelmänvalvojan määrittämänä, esim. https://amplify.microsoft.com/. Vain amplify.microsoft.com- tai amplify.cloud.microsoft-toimialueen URL-osoitteet hyväksytään.';
$string['settings_showvivaconnections'] = 'Näytä "Viva Connections"';
$string['settings_showvivaconnections_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Viva Connections" -linkki. <br /><b>Huomautus:</b> Myös alla oleva Viva Connections -URL-osoite on määritettävä, jotta linkki näytetään.';
$string['settings_vivaconnectionsurl'] = 'Viva Connections -URL-osoite';
$string['settings_vivaconnectionsurl_desc'] = 'Organisaatiosi Viva Connections -palvelun URL-osoite Microsoft 365 -vuokraajasi järjestelmänvalvojan määrittämänä. Tämä on yleensä SharePoint-kotisivustosi, esim. https://yourtenant.sharepoint.com/sites/yourhomesite. Vain *.sharepoint.com-toimialueen (tai vastaavan kansallisen pilven toimialueen) URL-osoitteet hyväksytään.';
$string['settings_showvivaglint'] = 'Näytä "Viva Glint"';
$string['settings_showvivaglint_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Viva Glint" -linkki.';
$string['settings_showvivagoals'] = 'Näytä "Viva Goals"';
$string['settings_showvivagoals_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Viva Goals" -linkki.';
$string['settings_showvivainsights'] = 'Näytä "Viva Insights"';
$string['settings_showvivainsights_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Viva Insights" -linkki.';
$string['settings_showvivalearning'] = 'Näytä "Viva Learning"';
$string['settings_showvivalearning_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Viva Learning" -linkki. <br /><b>Huomautus:</b> Myös alla oleva Viva Learning -URL-osoite on määritettävä, jotta linkki näytetään.';
$string['settings_vivalearningurl'] = 'Viva Learning -URL-osoite';
$string['settings_vivalearningurl_desc'] = 'Organisaatiosi Viva Learning -palvelun URL-osoite Microsoft 365 -vuokraajasi järjestelmänvalvojan määrittämänä, esim. https://web.viva.microsoft.com/learning. Vain viva.microsoft.com- tai cloud.microsoft-toimialueen URL-osoitteet hyväksytään.';
$string['settings_showvivapulse'] = 'Näytä "Viva Pulse"';
$string['settings_showvivapulse_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "Viva Pulse" -linkki.';
$string['settings_showlinkedin'] = 'Näytä "LinkedIn"';
$string['settings_showlinkedin_desc'] = 'Ota käyttöön tai poista käytöstä lohkon "LinkedIn"-linkki.';

$string['linkmydelve'] = 'Oma Delve';
$string['linkmyforms'] = 'Omat Formsit';
$string['privacy:metadata'] = 'Microsoft-lohko näyttää vain linkkejä eri ominaisuuksiin ja palveluihin.';

// Course sync features.
$string['course_feature_team'] = 'Tiimi';
$string['course_feature_conversations'] = 'Outlook-keskustelut';
$string['course_feature_onedrive'] = 'OneDrive-tiedostot';
$string['course_feature_calendar'] = 'Outlook-kalenteri';
$string['course_feature_notebook'] = 'Luokan muistikirja';

// Course sync settings.
$string['configure_sync'] = 'Määritä kurssin synkronointi';
$string['error_course_sync_not_configurable_per_course'] = 'Kurssin synkronointia ei voi määrittää kurssikohtaisesti.';
$string['sync_page_heading'] = 'Synkronoi kurssi {$a} Microsoft Teamsiin';
$string['configure_course_sync'] = 'Määritä kurssin synkronointi Microsoft Teamsiin';
$string['course_sync_option'] = 'Synkronointiasetus';
$string['course_sync_option_disabled'] = 'Pois päältä';
$string['course_sync_option_enabled'] = 'Käytössä';
$string['sync_setting_saved'] = 'Kurssin synkronointiasetus on tallennettu';

// Course reset status.
$string['course_reset_disconnect_and_create_new'] = 'Kun kurssi nollataan, kurssiin yhdistetty tiimi nimetään uudelleen määritysten mukaisesti ja arkistoidaan. Uusi tiimi luodaan ja yhdistetään kurssiin.';
$string['course_reset_do_nothing'] = 'Kun kurssi nollataan, kurssin ja tiimin välinen yhteys säilyy. Kaikki kurssin käyttäjiin tehdyt muutokset synkronoidaan tiimiin.';
$string['course_reset_disconnect_only'] = 'Kun kurssi nollataan, kurssiin yhdistetty tiimi nimetään uudelleen määritysten mukaisesti ja arkistoidaan. Uutta tiimiä ei luoda.';
$string['configure_reset'] = 'Valitse Microsoft Teamsin toiminto kurssin nollauksessa';

// Course reset settings page.
$string['reset_page_heading'] = 'Kurssin nollaustoiminto: {$a}';
$string['configure_course_reset'] = 'Määritä kurssin nollausasetus';
$string['course_reset_option'] = 'Tiimiä koskeva toiminto kurssia nollattaessa';
$string['reset_option_do_nothing'] = 'Älä tee mitään.<br/>Tiimi pysyy yhdistettynä kurssiin. Käyttäjien poistaminen kurssilta poistaa heidän tiimin omistajuutensa/jäsenyytensä.';
$string['reset_option_disconnect_and_create_new'] = 'Katkaise yhteys ja luo uusi tiimi.<br/>Kurssiin yhdistetty nykyinen tiimi nimetään uudelleen määritysten mukaisesti ja arkistoidaan. Uusi tiimi luodaan ja yhdistetään kurssiin.';
$string['reset_option_disconnect_only'] = 'Katkaise vain yhteys.<br/>Kurssiin yhdistetty nykyinen tiimi nimetään uudelleen määritysten mukaisesti ja arkistoidaan. Uutta tiimiä ei luoda.';
$string['reset_setting_saved'] = 'Kurssin nollausasetus on tallennettu.';
$string['error_site_course_sync_disabled'] = 'Kurssin synkronointi ei ole käytössä';
$string['error_reset_setting_not_managed_per_course'] = 'Sivuston ylläpitäjät hallinnoivat nollaustoiminnon määritystä keskitetysti.';
$string['error_connected_team_missing'] = 'Kurssi on määritetty synkronoitavaksi, mutta tiimiä ei löydy.';
$string['error_course_sync_disabled'] = 'Kurssia ei ole määritetty synkronoitavaksi.';

// Course request.
$string['linkcourserequest'] = 'Pyydä kurssia Teamsista';
$string['settings_courserequest'] = 'Pyydä kurssia Teamsista';
$string['settings_courserequest_desc'] = 'Pyydä uutta kurssia Microsoft Teamsista. Hyväksynnän jälkeen kurssi luodaan ja yhdistetään tiimiin. Tiimin jäsenet rekisteröidään kurssille.';

$string['customlinks'] = 'Mukautetut linkit';
$string['customlink_addanother'] = 'Lisää toinen linkki';
$string['customlink_delete'] = 'Poista tämä linkki';
$string['customlink_error_url'] = 'Anna kelvollinen URL-osoite, joka alkaa http:// tai https://';
$string['customlink_icon'] = 'Kuvake';
$string['customlink_name'] = 'Nimi';
$string['customlink_nochanges'] = 'Mukautettuja linkkejä ei annettu, joten tallennettavaa ei ole.';
$string['customlink_showall'] = 'Näytä myös käyttäjille, joita ei ole yhdistetty Microsoft 365:een';
$string['customlink_target'] = 'Avaa linkki';
$string['customlink_url'] = 'URL-osoite';
$string['customlink_visibility'] = 'Näkyvyys';
$string['settings_header_general'] = 'Yleiset';
$string['settings_pageheading'] = 'Microsoft-lohkon määritykset';
$string['settings_customlinkheading'] = 'Linkki {$a}';
$string['settings_customlinktarget_blank'] = 'Uudessa ikkunassa tai välilehdessä';
$string['settings_customlinktarget_self'] = 'Samassa ikkunassa';
$string['settings_customlinks_desc'] = 'Lisää lohkoon omia linkkejäsi (esim. sisäinen chatbot tai intranet-sivusto). Kunkin linkin nimi, URL-osoite ja kuvake ovat pakollisia. Poista linkki valitsemalla "Poista tämä linkki" ja tallentamalla.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
