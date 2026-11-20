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
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft';
$string['contactadmin'] = 'Neem contact op met de beheerder voor meer informatie.';
$string['error_nomoodlenotebook'] = 'Je Moodle-notitieboek kon niet worden gevonden.';
$string['error_urlrequiredwhenenabled'] = 'Deze URL moet worden geconfigureerd, omdat de optie "Tonen" hierboven is ingeschakeld.';
$string['linkonedrive'] = 'Mijn OneDrive';
$string['linkonenote'] = 'Mijn OneNote-notitieboek';
$string['linksways'] = 'Mijn Sways';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsstreamclassic'] = 'Microsoft Stream (klassiek)';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'Mijn e-mail';
$string['linkonenote_unavailable'] = 'OneNote niet beschikbaar';
$string['linksharepoint'] = 'SharePoint-site van de cursus';
$string['linkoutlook'] = 'Synchronisatie-instellingen voor Outlook-agenda';
$string['linkprefs'] = 'Instellingen bewerken';
$string['linkconnection'] = 'Verbindingsinstellingen voor Microsoft 365';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = 'Een nieuw Microsoft-blok toevoegen';
$string['microsoft:myaddinstance'] = 'Een nieuw Microsoft-blok toevoegen aan de pagina Mijn Moodle';
$string['workonthis'] = 'Hieraan werken';
$string['o365matched_title'] = 'Je bent <span style="color: #960">bijna</span> verbonden met Microsoft 365';
$string['o365matched_desc'] = 'Je bent gekoppeld aan de Microsoft 365-gebruiker <b>"{$a}"</b>';
$string['o365matched_complete_authreq'] = 'Klik op de onderstaande link en meld je aan bij dit Microsoft 365-account om de verbinding te voltooien.';
$string['o365connected'] = '{$a->firstname}, je bent momenteel <span class="notifysuccess">verbonden</span> met Microsoft 365';
$string['notconnected'] = 'Je bent <span class="notifyproblem">niet verbonden</span> met Microsoft-diensten.';
$string['course_connected_to_team'] = 'De cursus is <span class="notifysuccess">verbonden</span> met een <b>Team</b>.';
$string['course_connected_to_team_pending'] = 'De cursus is geconfigureerd om te worden verbonden met een <b>Team</b>, maar het aanmaken van het Team is <span class="notifyproblem">in behandeling</span>.';
$string['course_connected_to_group_pending'] = 'De cursus is geconfigureerd om te worden verbonden met een <b>Team</b>, maar het aanmaken van de groep is <span class="notifyproblem">in behandeling</span>.';
$string['course_not_connected'] = 'De cursus is <span class="notifyproblem">niet verbonden</span> met Microsoft-diensten.';
$string['cachedef_onenotenotebook'] = 'Slaat het OneNote-notitieboek op.';
$string['logintoo365'] = 'Aanmelden bij Microsoft 365';
$string['connecttoo365'] = 'Verbinden met Microsoft 365';
$string['install_office'] = 'Office installeren';

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
$string['settings_showemail'] = '"Mijn e-mail" tonen';
$string['settings_showemail_desc'] = 'Schakel de link "Mijn e-mail" in het blok in of uit.';
$string['settings_showmydelve'] = '"Mijn Delve" tonen';
$string['settings_showmydelve_desc'] = 'Schakel de link "Mijn Delve" in het blok in of uit.';
$string['settings_showmyforms'] = '"Mijn Forms" tonen';
$string['settings_showmyforms_desc'] = 'Schakel de link "Mijn Forms" in het blok in of uit.';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = '"Office installeren" tonen';
$string['settings_showo365download_desc'] = 'Schakel de link "Office installeren" in het blok in of uit.';
$string['settings_showsways'] = '"Mijn Sways" tonen';
$string['settings_showsways_desc'] = 'Schakel de link "Mijn Sways" in het blok in of uit.';
$string['settings_showmsstream'] = '"Microsoft Stream (op SharePoint)" tonen';
$string['settings_showmsstream_desc'] = 'Schakel de link "Microsoft Stream (op SharePoint)" in het blok in of uit.';
$string['settings_showmsstreamclassic'] = '"Microsoft Stream (klassiek)" tonen';
$string['settings_showmsstreamclassic_desc'] = 'Schakel de link "Microsoft Stream (klassiek)" in het blok in of uit.';
$string['settings_showmsteams'] = '"Microsoft Teams" tonen';
$string['settings_showmsteams_desc'] = 'Schakel de link "Microsoft Teams" in het blok in of uit.';
$string['settings_showonedrive'] = '"Mijn OneDrive" tonen';
$string['settings_showonedrive_desc'] = 'Schakel de link "Mijn OneDrive" in het blok in of uit.';
$string['settings_showonenotenotebook'] = '"Mijn OneNote-notitieboek" tonen';
$string['settings_showonenotenotebook_desc'] = 'Schakel de link "Mijn OneNote-notitieboek" in het blok in of uit.';
$string['settings_showoutlooksync'] = '"Synchronisatie-instellingen voor Outlook-agenda" tonen';
$string['settings_showoutlooksync_desc'] = 'Schakel de link "Synchronisatie-instellingen voor Outlook-agenda" in het blok in of uit.';
$string['settings_showpreferences'] = '"Instellingen bewerken" tonen';
$string['settings_showpreferences_desc'] = 'Schakel de link "Instellingen bewerken" in het blok in of uit.';
$string['settings_showo365connect'] = '"Verbinden met Microsoft 365" tonen';
$string['settings_showo365connect_desc'] = 'Schakel de link "Verbinden met Microsoft 365" in het blok in of uit. <br /><b>Opmerking:</b> Deze wordt getoond aan gebruikers die niet met Microsoft 365 zijn verbonden en brengt hen naar de pagina waar ze een verbinding kunnen instellen.';
$string['settings_showmanageo365conection'] = '"Verbindingsinstellingen voor Microsoft 365" tonen';
$string['settings_showmanageo365conection_desc'] = 'Schakel de link "Verbindingsinstellingen voor Microsoft 365" in het blok in of uit. <br /><b>Opmerking:</b> Deze wordt getoond aan gebruikers die met Microsoft 365 zijn verbonden en brengt hen naar de pagina voor het beheren van de verbinding.';
$string['settings_showcoursespsite'] = '"SharePoint-site van de cursus" tonen';
$string['settings_showcoursespsite_desc'] = 'Schakel de link "SharePoint-site van de cursus" in het blok in of uit. <br /><b>Opmerking:</b> Deze wordt in het blok getoond bij het bekijken van een cursus met een gekoppelde SharePoint-site.';
$string['settings_showcourselinks'] = 'Cursuslinks tonen';
$string['settings_showcourselinks_desc'] = 'Schakel het hele cursusgedeelte van het blok in of uit dat wordt getoond bij het bekijken van een cursus, inclusief de koptekst met de cursusstatus en alle cursuslinks. <br /><b>Opmerking:</b> Als dit is uitgeschakeld, worden de onderstaande instellingen voor afzonderlijke cursuslinks genegeerd.';
$string['settings_showcourseconfiguresync'] = '"Cursussynchronisatie configureren" tonen';
$string['settings_showcourseconfiguresync_desc'] = 'Schakel de link "Cursussynchronisatie configureren" in het cursusgedeelte van het blok in of uit.';
$string['settings_showcourseteam'] = '"Team" tonen';
$string['settings_showcourseteam_desc'] = 'Schakel de link "Team" in het cursusgedeelte van het blok in of uit.';
$string['settings_showcourseconversations'] = '"Outlook-gesprekken" tonen';
$string['settings_showcourseconversations_desc'] = 'Schakel de link "Outlook-gesprekken" in het cursusgedeelte van het blok in of uit.';
$string['settings_showcourseonedrive'] = '"OneDrive-bestanden" tonen';
$string['settings_showcourseonedrive_desc'] = 'Schakel de link "OneDrive-bestanden" in het cursusgedeelte van het blok in of uit.';
$string['settings_showcoursecalendar'] = '"Outlook-agenda" tonen';
$string['settings_showcoursecalendar_desc'] = 'Schakel de link "Outlook-agenda" in het cursusgedeelte van het blok in of uit.';
$string['settings_showcoursenotebook'] = '"Klasnotitieboek" tonen';
$string['settings_showcoursenotebook_desc'] = 'Schakel de link "Klasnotitieboek" in het cursusgedeelte van het blok in of uit.';
$string['settings_showcoursereset'] = '"Opties voor cursusreset" tonen';
$string['settings_showcoursereset_desc'] = 'Schakel de link "Opties voor cursusreset" in het cursusgedeelte van het blok in of uit.';
$string['settings_geto365link'] = 'Download-URL voor Office installeren';
$string['settings_geto365link_desc'] = 'De URL die wordt gebruikt voor de link "Office installeren".';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['settings_showword'] = '"Word" tonen';
$string['settings_showword_desc'] = 'Schakel de link "Word" in het blok in of uit.';
$string['settings_showexcel'] = '"Excel" tonen';
$string['settings_showexcel_desc'] = 'Schakel de link "Excel" in het blok in of uit.';
$string['settings_showpowerpoint'] = '"PowerPoint" tonen';
$string['settings_showpowerpoint_desc'] = 'Schakel de link "PowerPoint" in het blok in of uit.';
$string['settings_showvivaengage'] = '"Viva Engage" tonen';
$string['settings_showvivaengage_desc'] = 'Schakel de link "Viva Engage" in het blok in of uit.';
$string['settings_showvivaamplify'] = '"Viva Amplify" tonen';
$string['settings_showvivaamplify_desc'] = 'Schakel de link "Viva Amplify" in het blok in of uit. <br /><b>Opmerking:</b> De onderstaande Viva Amplify-URL moet ook zijn geconfigureerd om de link te tonen.';
$string['settings_vivaamplifyurl'] = 'Viva Amplify-URL';
$string['settings_vivaamplifyurl_desc'] = 'De URL van de Viva Amplify-omgeving van je organisatie, zoals geconfigureerd door de beheerder van je Microsoft 365-tenant, bijvoorbeeld https://amplify.microsoft.com/. Alleen URL\'s op een amplify.microsoft.com- of amplify.cloud.microsoft-domein worden geaccepteerd.';
$string['settings_showvivaconnections'] = '"Viva Connections" tonen';
$string['settings_showvivaconnections_desc'] = 'Schakel de link "Viva Connections" in het blok in of uit. <br /><b>Opmerking:</b> De onderstaande Viva Connections-URL moet ook zijn geconfigureerd om de link te tonen.';
$string['settings_vivaconnectionsurl'] = 'Viva Connections-URL';
$string['settings_vivaconnectionsurl_desc'] = 'De URL van de Viva Connections-omgeving van je organisatie, zoals geconfigureerd door de beheerder van je Microsoft 365-tenant. Dit is doorgaans je SharePoint-startsite, bijvoorbeeld https://yourtenant.sharepoint.com/sites/yourhomesite. Alleen URL\'s op een *.sharepoint.com-domein (of het equivalent voor een soevereine cloud) worden geaccepteerd.';
$string['settings_showvivaglint'] = '"Viva Glint" tonen';
$string['settings_showvivaglint_desc'] = 'Schakel de link "Viva Glint" in het blok in of uit.';
$string['settings_showvivagoals'] = '"Viva Goals" tonen';
$string['settings_showvivagoals_desc'] = 'Schakel de link "Viva Goals" in het blok in of uit.';
$string['settings_showvivainsights'] = '"Viva Insights" tonen';
$string['settings_showvivainsights_desc'] = 'Schakel de link "Viva Insights" in het blok in of uit.';
$string['settings_showvivalearning'] = '"Viva Learning" tonen';
$string['settings_showvivalearning_desc'] = 'Schakel de link "Viva Learning" in het blok in of uit. <br /><b>Opmerking:</b> De onderstaande Viva Learning-URL moet ook zijn geconfigureerd om de link te tonen.';
$string['settings_vivalearningurl'] = 'Viva Learning-URL';
$string['settings_vivalearningurl_desc'] = 'De URL van de Viva Learning-omgeving van je organisatie, zoals geconfigureerd door de beheerder van je Microsoft 365-tenant, bijvoorbeeld https://web.viva.microsoft.com/learning. Alleen URL\'s op een viva.microsoft.com- of cloud.microsoft-domein worden geaccepteerd.';
$string['settings_showvivapulse'] = '"Viva Pulse" tonen';
$string['settings_showvivapulse_desc'] = 'Schakel de link "Viva Pulse" in het blok in of uit.';
$string['settings_showlinkedin'] = '"LinkedIn" tonen';
$string['settings_showlinkedin_desc'] = 'Schakel de link "LinkedIn" in het blok in of uit.';

$string['linkmydelve'] = 'Mijn Delve';
$string['linkmyforms'] = 'Mijn Forms';
$string['privacy:metadata'] = 'Het Microsoft-blok toont alleen links naar verschillende functies en diensten.';

// Course sync features.
$string['course_feature_team'] = 'Team';
$string['course_feature_conversations'] = 'Outlook-gesprekken';
$string['course_feature_onedrive'] = 'OneDrive-bestanden';
$string['course_feature_calendar'] = 'Outlook-agenda';
$string['course_feature_notebook'] = 'Klasnotitieboek';

// Course sync settings.
$string['configure_sync'] = 'Cursussynchronisatie configureren';
$string['error_course_sync_not_configurable_per_course'] = 'Cursussynchronisatie kan niet per cursus worden geconfigureerd.';
$string['sync_page_heading'] = 'Cursus {$a} synchroniseren met Microsoft Teams';
$string['configure_course_sync'] = 'Cursussynchronisatie met Microsoft Teams configureren';
$string['course_sync_option'] = 'Synchronisatieoptie';
$string['course_sync_option_disabled'] = 'Uitgeschakeld';
$string['course_sync_option_enabled'] = 'Ingeschakeld';
$string['sync_setting_saved'] = 'De optie voor cursussynchronisatie is opgeslagen';

// Course reset status.
$string['course_reset_disconnect_and_create_new'] = 'Wanneer de cursus wordt gereset, wordt het Team dat met de cursus is verbonden hernoemd zoals geconfigureerd en gearchiveerd. Er wordt een nieuw Team aangemaakt en met de cursus verbonden.';
$string['course_reset_do_nothing'] = 'Wanneer de cursus wordt gereset, blijft de verbinding tussen de cursus en het Team bestaan. Alle wijzigingen van gebruikers in de cursus worden met het Team gesynchroniseerd.';
$string['course_reset_disconnect_only'] = 'Wanneer de cursus wordt gereset, wordt het Team dat met de cursus is verbonden hernoemd zoals geconfigureerd en gearchiveerd. Er wordt geen nieuw Team aangemaakt.';
$string['configure_reset'] = 'Kies de actie voor Microsoft Teams bij het resetten van de cursus';

// Course reset settings page.
$string['reset_page_heading'] = 'Actie bij cursusreset voor {$a}';
$string['configure_course_reset'] = 'Instelling voor cursusreset configureren';
$string['course_reset_option'] = 'Actie voor het Team bij het resetten van de cursus';
$string['reset_option_do_nothing'] = 'Niets doen.<br/>Het Team blijft met de cursus verbonden. Bij het uitschrijven van gebruikers wordt hun eigenaarschap of lidmaatschap van het Team verwijderd.';
$string['reset_option_disconnect_and_create_new'] = 'Verbinding verbreken en een nieuw Team aanmaken.<br/>Het bestaande Team dat met de cursus is verbonden wordt hernoemd zoals geconfigureerd en gearchiveerd. Er wordt een nieuw Team aangemaakt en met de cursus verbonden.';
$string['reset_option_disconnect_only'] = 'Alleen de verbinding verbreken.<br/>Het bestaande Team dat met de cursus is verbonden wordt hernoemd zoals geconfigureerd en gearchiveerd. Er wordt geen nieuw Team aangemaakt.';
$string['reset_setting_saved'] = 'De instelling voor cursusreset is opgeslagen.';
$string['error_site_course_sync_disabled'] = 'Cursussynchronisatie is niet ingeschakeld';
$string['error_reset_setting_not_managed_per_course'] = 'De configuratie van de resetactie wordt centraal beheerd door sitebeheerders.';
$string['error_connected_team_missing'] = 'De cursus is geconfigureerd om te worden gesynchroniseerd, maar het Team kan niet worden gevonden.';
$string['error_course_sync_disabled'] = 'De cursus is niet geconfigureerd om te worden gesynchroniseerd.';

// Course request.
$string['linkcourserequest'] = 'Cursus aanvragen vanuit Teams';
$string['settings_courserequest'] = 'Cursus aanvragen vanuit Teams';
$string['settings_courserequest_desc'] = 'Vraag een nieuwe cursus aan vanuit Microsoft Teams. Na goedkeuring wordt de cursus aangemaakt en met een Team verbonden. Teamleden worden ingeschreven in de cursus.';

$string['customlinks'] = 'Aangepaste links';
$string['customlink_addanother'] = 'Nog een link toevoegen';
$string['customlink_delete'] = 'Deze link verwijderen';
$string['customlink_error_url'] = 'Voer een geldige URL in die begint met http:// of https://';
$string['customlink_icon'] = 'Pictogram';
$string['customlink_name'] = 'Naam';
$string['customlink_nochanges'] = 'Er zijn geen aangepaste links ingevoerd, dus er valt niets op te slaan.';
$string['customlink_showall'] = 'Ook tonen aan gebruikers die niet met Microsoft 365 zijn verbonden';
$string['customlink_target'] = 'Link openen in';
$string['customlink_url'] = 'URL';
$string['customlink_visibility'] = 'Zichtbaarheid';
$string['settings_header_general'] = 'Algemeen';
$string['settings_pageheading'] = 'Configuratie van het Microsoft-blok';
$string['settings_customlinkheading'] = 'Link {$a}';
$string['settings_customlinktarget_blank'] = 'Nieuw venster of nieuw tabblad';
$string['settings_customlinktarget_self'] = 'Hetzelfde venster';
$string['settings_customlinks_desc'] = 'Voeg je eigen links (bijvoorbeeld een interne chatbot of intranetsite) toe aan het blok. De naam, URL en het pictogram van elke link zijn verplicht. Om een link te verwijderen, vink je "Deze link verwijderen" aan en sla je op.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
