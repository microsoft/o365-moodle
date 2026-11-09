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
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft';
$string['contactadmin'] = 'Pro více informací kontaktujte správce.';
$string['error_nomoodlenotebook'] = 'Nepodařilo se najít váš poznámkový blok Moodle.';
$string['error_urlrequiredwhenenabled'] = 'Tato adresa URL musí být nastavena, protože je výše povolena volba „Zobrazit“.';
$string['linkonedrive'] = 'Můj OneDrive';
$string['linkonenote'] = 'Můj poznámkový blok OneNote';
$string['linksways'] = 'Moje Sway';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsstreamclassic'] = 'Microsoft Stream (klasický)';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'Můj e-mail';
$string['linkonenote_unavailable'] = 'OneNote není k dispozici';
$string['linksharepoint'] = 'Web SharePoint kurzu';
$string['linkoutlook'] = 'Nastavení synchronizace kalendáře Outlook';
$string['linkprefs'] = 'Upravit nastavení';
$string['linkconnection'] = 'Nastavení připojení k Microsoft 365';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = 'Přidat nový blok Microsoft';
$string['microsoft:myaddinstance'] = 'Přidat nový blok Microsoft na Nástěnku';
$string['workonthis'] = 'Pracovat na tomto';
$string['o365matched_title'] = 'Jste <span style="color: #960">téměř</span> připojeni k Microsoft 365';
$string['o365matched_desc'] = 'Byli jste spárováni s uživatelem Microsoft 365 <b>„{$a}“</b>';
$string['o365matched_complete_authreq'] = 'Pro dokončení připojení klikněte na odkaz níže a přihlaste se k tomuto účtu Microsoft 365.';
$string['o365connected'] = '{$a->firstname}, jste aktuálně <span class="notifysuccess">připojeni</span> k Microsoft 365';
$string['notconnected'] = '<span class="notifyproblem">Nejste připojeni</span> k žádným službám Microsoft.';
$string['course_connected_to_team'] = 'Kurz je <span class="notifysuccess">připojen</span> k <b>týmu</b>.';
$string['course_connected_to_team_pending'] = 'Kurz je nastaven k připojení k <b>týmu</b>, ale vytvoření týmu <span class="notifyproblem">čeká na zpracování</span>.';
$string['course_connected_to_group_pending'] = 'Kurz je nastaven k připojení k <b>týmu</b>, ale vytvoření skupiny <span class="notifyproblem">čeká na zpracování</span>.';
$string['course_not_connected'] = 'Kurz <span class="notifyproblem">není připojen</span> k žádným službám Microsoft.';
$string['cachedef_onenotenotebook'] = 'Ukládá poznámkový blok OneNote.';
$string['logintoo365'] = 'Přihlásit se do Microsoft 365';
$string['connecttoo365'] = 'Připojit k Microsoft 365';
$string['install_office'] = 'Nainstalovat Office';

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
$string['settings_showemail'] = 'Zobrazit „Můj e-mail“';
$string['settings_showemail_desc'] = 'Povolí nebo zakáže odkaz „Můj e-mail“ v bloku.';
$string['settings_showmydelve'] = 'Zobrazit „Můj Delve“';
$string['settings_showmydelve_desc'] = 'Povolí nebo zakáže odkaz „Můj Delve“ v bloku.';
$string['settings_showmyforms'] = 'Zobrazit „Moje formuláře“';
$string['settings_showmyforms_desc'] = 'Povolí nebo zakáže odkaz „Moje formuláře“ v bloku.';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = 'Zobrazit „Nainstalovat Office“';
$string['settings_showo365download_desc'] = 'Povolí nebo zakáže odkaz „Nainstalovat Office“ v bloku.';
$string['settings_showsways'] = 'Zobrazit „Moje Sway“';
$string['settings_showsways_desc'] = 'Povolí nebo zakáže odkaz „Moje Sway“ v bloku.';
$string['settings_showmsstream'] = 'Zobrazit „Microsoft Stream (na SharePointu)“';
$string['settings_showmsstream_desc'] = 'Povolí nebo zakáže odkaz „Microsoft Stream (na SharePointu)“ v bloku.';
$string['settings_showmsstreamclassic'] = 'Zobrazit „Microsoft Stream (klasický)“';
$string['settings_showmsstreamclassic_desc'] = 'Povolí nebo zakáže odkaz „Microsoft Stream (klasický)“ v bloku.';
$string['settings_showmsteams'] = 'Zobrazit „Microsoft Teams“';
$string['settings_showmsteams_desc'] = 'Povolí nebo zakáže odkaz „Microsoft Teams“ v bloku.';
$string['settings_showonedrive'] = 'Zobrazit „Můj OneDrive“';
$string['settings_showonedrive_desc'] = 'Povolí nebo zakáže odkaz „Můj OneDrive“ v bloku.';
$string['settings_showonenotenotebook'] = 'Zobrazit „Můj poznámkový blok OneNote“';
$string['settings_showonenotenotebook_desc'] = 'Povolí nebo zakáže odkaz „Můj poznámkový blok OneNote“ v bloku.';
$string['settings_showoutlooksync'] = 'Zobrazit „Nastavení synchronizace kalendáře Outlook“';
$string['settings_showoutlooksync_desc'] = 'Povolí nebo zakáže odkaz „Nastavení synchronizace kalendáře Outlook“ v bloku.';
$string['settings_showpreferences'] = 'Zobrazit „Upravit nastavení“';
$string['settings_showpreferences_desc'] = 'Povolí nebo zakáže odkaz „Upravit nastavení“ v bloku.';
$string['settings_showo365connect'] = 'Zobrazit „Připojit k Microsoft 365“';
$string['settings_showo365connect_desc'] = 'Povolí nebo zakáže odkaz „Připojit k Microsoft 365“ v bloku. <br /><b>Poznámka:</b> Zobrazuje se uživatelům, kteří nejsou připojeni k Microsoft 365, a přesměruje je na stránku, kde si mohou připojení nastavit.';
$string['settings_showmanageo365conection'] = 'Zobrazit „Nastavení připojení k Microsoft 365“';
$string['settings_showmanageo365conection_desc'] = 'Povolí nebo zakáže odkaz „Nastavení připojení k Microsoft 365“ v bloku. <br /><b>Poznámka:</b> Zobrazuje se uživatelům připojeným k Microsoft 365 a přesměruje je na stránku správy připojení.';
$string['settings_showcoursespsite'] = 'Zobrazit „Web SharePoint kurzu“';
$string['settings_showcoursespsite_desc'] = 'Povolí nebo zakáže odkaz „Web SharePoint kurzu“ v bloku. <br /><b>Poznámka:</b> Zobrazuje se v bloku při prohlížení kurzu, který má přidružený web SharePoint.';
$string['settings_showcourselinks'] = 'Zobrazit odkazy kurzu';
$string['settings_showcourselinks_desc'] = 'Povolí nebo zakáže celou sekci kurzu v bloku, která se zobrazuje při prohlížení kurzu, včetně nadpisu se stavem kurzu a všech odkazů kurzu. <br /><b>Poznámka:</b> Pokud je zakázána, jednotlivá nastavení odkazů kurzu níže se ignorují.';
$string['settings_showcourseconfiguresync'] = 'Zobrazit „Nastavit synchronizaci kurzu“';
$string['settings_showcourseconfiguresync_desc'] = 'Povolí nebo zakáže odkaz „Nastavit synchronizaci kurzu“ v sekci kurzu v bloku.';
$string['settings_showcourseteam'] = 'Zobrazit „Tým“';
$string['settings_showcourseteam_desc'] = 'Povolí nebo zakáže odkaz „Tým“ v sekci kurzu v bloku.';
$string['settings_showcourseconversations'] = 'Zobrazit „Konverzace v Outlooku“';
$string['settings_showcourseconversations_desc'] = 'Povolí nebo zakáže odkaz „Konverzace v Outlooku“ v sekci kurzu v bloku.';
$string['settings_showcourseonedrive'] = 'Zobrazit „Soubory na OneDrivu“';
$string['settings_showcourseonedrive_desc'] = 'Povolí nebo zakáže odkaz „Soubory na OneDrivu“ v sekci kurzu v bloku.';
$string['settings_showcoursecalendar'] = 'Zobrazit „Kalendář Outlook“';
$string['settings_showcoursecalendar_desc'] = 'Povolí nebo zakáže odkaz „Kalendář Outlook“ v sekci kurzu v bloku.';
$string['settings_showcoursenotebook'] = 'Zobrazit „Poznámkový blok předmětu“';
$string['settings_showcoursenotebook_desc'] = 'Povolí nebo zakáže odkaz „Poznámkový blok předmětu“ v sekci kurzu v bloku.';
$string['settings_showcoursereset'] = 'Zobrazit „Možnosti resetu kurzu“';
$string['settings_showcoursereset_desc'] = 'Povolí nebo zakáže odkaz „Možnosti resetu kurzu“ v sekci kurzu v bloku.';
$string['settings_geto365link'] = 'Adresa URL ke stažení pro „Nainstalovat Office“';
$string['settings_geto365link_desc'] = 'Adresa URL použitá pro odkaz „Nainstalovat Office“.';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['settings_showword'] = 'Zobrazit „Word“';
$string['settings_showword_desc'] = 'Povolí nebo zakáže odkaz „Word“ v bloku.';
$string['settings_showexcel'] = 'Zobrazit „Excel“';
$string['settings_showexcel_desc'] = 'Povolí nebo zakáže odkaz „Excel“ v bloku.';
$string['settings_showpowerpoint'] = 'Zobrazit „PowerPoint“';
$string['settings_showpowerpoint_desc'] = 'Povolí nebo zakáže odkaz „PowerPoint“ v bloku.';
$string['settings_showvivaengage'] = 'Zobrazit „Viva Engage“';
$string['settings_showvivaengage_desc'] = 'Povolí nebo zakáže odkaz „Viva Engage“ v bloku.';
$string['settings_showvivaamplify'] = 'Zobrazit „Viva Amplify“';
$string['settings_showvivaamplify_desc'] = 'Povolí nebo zakáže odkaz „Viva Amplify“ v bloku. <br /><b>Poznámka:</b> Aby se odkaz zobrazil, musí být nastavena také adresa URL Viva Amplify níže.';
$string['settings_vivaamplifyurl'] = 'Adresa URL Viva Amplify';
$string['settings_vivaamplifyurl_desc'] = 'Adresa URL prostředí Viva Amplify vaší organizace, jak ji nastavil správce vašeho tenanta Microsoft 365, např. https://amplify.microsoft.com/. Přijímány jsou pouze adresy URL v doméně amplify.microsoft.com nebo amplify.cloud.microsoft.';
$string['settings_showvivaconnections'] = 'Zobrazit „Viva Connections“';
$string['settings_showvivaconnections_desc'] = 'Povolí nebo zakáže odkaz „Viva Connections“ v bloku. <br /><b>Poznámka:</b> Aby se odkaz zobrazil, musí být nastavena také adresa URL Viva Connections níže.';
$string['settings_vivaconnectionsurl'] = 'Adresa URL Viva Connections';
$string['settings_vivaconnectionsurl_desc'] = 'Adresa URL prostředí Viva Connections vaší organizace, jak ji nastavil správce vašeho tenanta Microsoft 365. Obvykle jde o domovský web SharePoint, např. https://yourtenant.sharepoint.com/sites/yourhomesite. Přijímány jsou pouze adresy URL v doméně *.sharepoint.com (nebo v odpovídající doméně suverénního cloudu).';
$string['settings_showvivaglint'] = 'Zobrazit „Viva Glint“';
$string['settings_showvivaglint_desc'] = 'Povolí nebo zakáže odkaz „Viva Glint“ v bloku.';
$string['settings_showvivagoals'] = 'Zobrazit „Viva Goals“';
$string['settings_showvivagoals_desc'] = 'Povolí nebo zakáže odkaz „Viva Goals“ v bloku.';
$string['settings_showvivainsights'] = 'Zobrazit „Viva Insights“';
$string['settings_showvivainsights_desc'] = 'Povolí nebo zakáže odkaz „Viva Insights“ v bloku.';
$string['settings_showvivalearning'] = 'Zobrazit „Viva Learning“';
$string['settings_showvivalearning_desc'] = 'Povolí nebo zakáže odkaz „Viva Learning“ v bloku. <br /><b>Poznámka:</b> Aby se odkaz zobrazil, musí být nastavena také adresa URL Viva Learning níže.';
$string['settings_vivalearningurl'] = 'Adresa URL Viva Learning';
$string['settings_vivalearningurl_desc'] = 'Adresa URL prostředí Viva Learning vaší organizace, jak ji nastavil správce vašeho tenanta Microsoft 365, např. https://web.viva.microsoft.com/learning. Přijímány jsou pouze adresy URL v doméně viva.microsoft.com nebo cloud.microsoft.';
$string['settings_showvivapulse'] = 'Zobrazit „Viva Pulse“';
$string['settings_showvivapulse_desc'] = 'Povolí nebo zakáže odkaz „Viva Pulse“ v bloku.';
$string['settings_showlinkedin'] = 'Zobrazit „LinkedIn“';
$string['settings_showlinkedin_desc'] = 'Povolí nebo zakáže odkaz „LinkedIn“ v bloku.';

$string['linkmydelve'] = 'Můj Delve';
$string['linkmyforms'] = 'Moje formuláře';
$string['privacy:metadata'] = 'Blok Microsoft pouze zobrazuje odkazy na různé funkce a služby.';

// Course sync features.
$string['course_feature_team'] = 'Tým';
$string['course_feature_conversations'] = 'Konverzace v Outlooku';
$string['course_feature_onedrive'] = 'Soubory na OneDrivu';
$string['course_feature_calendar'] = 'Kalendář Outlook';
$string['course_feature_notebook'] = 'Poznámkový blok předmětu';

// Course sync settings.
$string['configure_sync'] = 'Nastavit synchronizaci kurzu';
$string['error_course_sync_not_configurable_per_course'] = 'Synchronizaci kurzu nelze nastavit pro jednotlivé kurzy.';
$string['sync_page_heading'] = 'Synchronizace kurzu {$a} s Microsoft Teams';
$string['configure_course_sync'] = 'Nastavit synchronizaci kurzu s Microsoft Teams';
$string['course_sync_option'] = 'Možnost synchronizace';
$string['course_sync_option_disabled'] = 'Zakázáno';
$string['course_sync_option_enabled'] = 'Povoleno';
$string['sync_setting_saved'] = 'Možnost synchronizace kurzu byla uložena';

// Course reset status.
$string['course_reset_disconnect_and_create_new'] = 'Při resetu kurzu bude tým připojený ke kurzu přejmenován podle nastavení a archivován. Bude vytvořen nový tým a připojen ke kurzu.';
$string['course_reset_do_nothing'] = 'Při resetu kurzu zůstane propojení mezi kurzem a týmem zachováno. Všechny změny uživatelů provedené v kurzu budou synchronizovány s týmem.';
$string['course_reset_disconnect_only'] = 'Při resetu kurzu bude tým připojený ke kurzu přejmenován podle nastavení a archivován. Žádný nový tým nebude vytvořen.';
$string['configure_reset'] = 'Zvolit akci Microsoft Teams při resetu kurzu';

// Course reset settings page.
$string['reset_page_heading'] = 'Akce při resetu kurzu {$a}';
$string['configure_course_reset'] = 'Nastavit reset kurzu';
$string['course_reset_option'] = 'Akce pro tým při resetu kurzu';
$string['reset_option_do_nothing'] = 'Nedělat nic.<br/>Tým zůstane připojen ke kurzu. Vyškrtnutí uživatelů z kurzu povede k odebrání jejich vlastnictví/členství v týmu.';
$string['reset_option_disconnect_and_create_new'] = 'Odpojit a vytvořit nový tým.<br/>Stávající tým připojený ke kurzu bude přejmenován podle nastavení a archivován. Bude vytvořen nový tým a připojen ke kurzu.';
$string['reset_option_disconnect_only'] = 'Pouze odpojit.<br/>Stávající tým připojený ke kurzu bude přejmenován podle nastavení a archivován. Žádný nový tým nebude vytvořen.';
$string['reset_setting_saved'] = 'Nastavení resetu kurzu bylo uloženo.';
$string['error_site_course_sync_disabled'] = 'Synchronizace kurzů není povolena';
$string['error_reset_setting_not_managed_per_course'] = 'Nastavení akce při resetu je centrálně spravováno správci serveru.';
$string['error_connected_team_missing'] = 'Kurz je nastaven k synchronizaci, ale tým nelze najít.';
$string['error_course_sync_disabled'] = 'Kurz není nastaven k synchronizaci.';

// Course request.
$string['linkcourserequest'] = 'Požádat o kurz z Teams';
$string['settings_courserequest'] = 'Požádat o kurz z Teams';
$string['settings_courserequest_desc'] = 'Požádá o nový kurz z Microsoft Teams. Po schválení bude kurz vytvořen a připojen k týmu. Členové týmu budou zapsáni do kurzu.';

$string['customlinks'] = 'Vlastní odkazy';
$string['customlink_addanother'] = 'Přidat další odkaz';
$string['customlink_delete'] = 'Odstranit tento odkaz';
$string['customlink_error_url'] = 'Zadejte platnou adresu URL začínající http:// nebo https://';
$string['customlink_icon'] = 'Ikona';
$string['customlink_name'] = 'Název';
$string['customlink_nochanges'] = 'Nebyly zadány žádné vlastní odkazy, není tedy co uložit.';
$string['customlink_showall'] = 'Zobrazit také uživatelům, kteří nejsou připojeni k Microsoft 365';
$string['customlink_target'] = 'Otevřít odkaz v';
$string['customlink_url'] = 'URL';
$string['customlink_visibility'] = 'Viditelnost';
$string['settings_header_general'] = 'Obecné';
$string['settings_pageheading'] = 'Konfigurace bloku Microsoft';
$string['settings_customlinkheading'] = 'Odkaz {$a}';
$string['settings_customlinktarget_blank'] = 'Novém okně nebo kartě';
$string['settings_customlinktarget_self'] = 'Stejném okně';
$string['settings_customlinks_desc'] = 'Přidejte do bloku vlastní odkazy (např. na interní chatbot nebo intranet). Název, adresa URL a ikona jsou u každého odkazu povinné. Chcete-li odkaz odebrat, zaškrtněte „Odstranit tento odkaz“ a uložte.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
