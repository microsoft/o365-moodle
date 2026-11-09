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
 * Italian language strings.
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
$string['contactadmin'] = 'Contatta l\'amministratore per maggiori informazioni.';
$string['error_nomoodlenotebook'] = 'Impossibile trovare il tuo blocco appunti Moodle.';
$string['error_urlrequiredwhenenabled'] = 'Questo URL deve essere configurato, poiché l\'opzione "Mostra" sopra è abilitata.';
$string['linkonedrive'] = 'Il mio OneDrive';
$string['linkonenote'] = 'Il mio blocco appunti OneNote';
$string['linksways'] = 'I miei Sway';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsstreamclassic'] = 'Microsoft Stream (classico)';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'La mia posta';
$string['linkonenote_unavailable'] = 'OneNote non disponibile';
$string['linksharepoint'] = 'Sito SharePoint del corso';
$string['linkoutlook'] = 'Impostazioni di sincronizzazione del calendario di Outlook';
$string['linkprefs'] = 'Modifica impostazioni';
$string['linkconnection'] = 'Impostazioni di connessione a Microsoft 365';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = 'Aggiungere un nuovo blocco Microsoft';
$string['microsoft:myaddinstance'] = 'Aggiungere un nuovo blocco Microsoft alla Dashboard';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Blocco appunti Moodle';
$string['workonthis'] = 'Lavora su questo';
$string['o365matched_title'] = 'Sei <span style="color: #960">quasi</span> connesso a Microsoft 365';
$string['o365matched_desc'] = 'Sei stato associato all\'utente Microsoft 365 <b>"{$a}"</b>';
$string['o365matched_complete_authreq'] = 'Per completare la connessione, fai clic sul link sottostante e accedi con questo account Microsoft 365.';
$string['o365connected'] = '{$a->firstname}, sei attualmente <span class="notifysuccess">connesso</span> a Microsoft 365';
$string['notconnected'] = '<span class="notifyproblem">Non sei connesso</span> ad alcun servizio Microsoft.';
$string['course_connected_to_team'] = 'Il corso è <span class="notifysuccess">connesso</span> a un <b>Team</b>.';
$string['course_connected_to_team_pending'] = 'Il corso è configurato per essere connesso a un <b>Team</b>, ma la creazione del Team è <span class="notifyproblem">in sospeso</span>.';
$string['course_connected_to_group_pending'] = 'Il corso è configurato per essere connesso a un <b>Team</b>, ma la creazione del gruppo è <span class="notifyproblem">in sospeso</span>.';
$string['course_not_connected'] = 'Il corso <span class="notifyproblem">non è connesso</span> ad alcun servizio Microsoft.';
$string['cachedef_onenotenotebook'] = 'Memorizza il blocco appunti OneNote.';
$string['logintoo365'] = 'Accedi a Microsoft 365';
$string['connecttoo365'] = 'Connetti a Microsoft 365';
$string['install_office'] = 'Installa Office';

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
$string['settings_showemail'] = 'Mostra "La mia posta"';
$string['settings_showemail_desc'] = 'Abilita o disabilita il link "La mia posta" nel blocco.';
$string['settings_showmydelve'] = 'Mostra "Il mio Delve"';
$string['settings_showmydelve_desc'] = 'Abilita o disabilita il link "Il mio Delve" nel blocco.';
$string['settings_showmyforms'] = 'Mostra "I miei moduli"';
$string['settings_showmyforms_desc'] = 'Abilita o disabilita il link "I miei moduli" nel blocco.';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = 'Mostra "Installa Office"';
$string['settings_showo365download_desc'] = 'Abilita o disabilita il link "Installa Office" nel blocco.';
$string['settings_showsways'] = 'Mostra "I miei Sway"';
$string['settings_showsways_desc'] = 'Abilita o disabilita il link "I miei Sway" nel blocco.';
$string['settings_showmsstream'] = 'Mostra "Microsoft Stream (su SharePoint)"';
$string['settings_showmsstream_desc'] = 'Abilita o disabilita il link "Microsoft Stream (su SharePoint)" nel blocco.';
$string['settings_showmsstreamclassic'] = 'Mostra "Microsoft Stream (classico)"';
$string['settings_showmsstreamclassic_desc'] = 'Abilita o disabilita il link "Microsoft Stream (classico)" nel blocco.';
$string['settings_showmsteams'] = 'Mostra "Microsoft Teams"';
$string['settings_showmsteams_desc'] = 'Abilita o disabilita il link "Microsoft Teams" nel blocco.';
$string['settings_showonedrive'] = 'Mostra "Il mio OneDrive"';
$string['settings_showonedrive_desc'] = 'Abilita o disabilita il link "Il mio OneDrive" nel blocco.';
$string['settings_showonenotenotebook'] = 'Mostra "Il mio blocco appunti OneNote"';
$string['settings_showonenotenotebook_desc'] = 'Abilita o disabilita il link "Il mio blocco appunti OneNote" nel blocco.';
$string['settings_showoutlooksync'] = 'Mostra "Impostazioni di sincronizzazione del calendario di Outlook"';
$string['settings_showoutlooksync_desc'] = 'Abilita o disabilita il link "Impostazioni di sincronizzazione del calendario di Outlook" nel blocco.';
$string['settings_showpreferences'] = 'Mostra "Modifica impostazioni"';
$string['settings_showpreferences_desc'] = 'Abilita o disabilita il link "Modifica impostazioni" nel blocco.';
$string['settings_showo365connect'] = 'Mostra "Connetti a Microsoft 365"';
$string['settings_showo365connect_desc'] = 'Abilita o disabilita il link "Connetti a Microsoft 365" nel blocco. <br /><b>Nota:</b> viene mostrato agli utenti non connessi a Microsoft 365 e li porta alla pagina che consente di configurare una connessione.';
$string['settings_showmanageo365conection'] = 'Mostra "Impostazioni di connessione a Microsoft 365"';
$string['settings_showmanageo365conection_desc'] = 'Abilita o disabilita il link "Impostazioni di connessione a Microsoft 365" nel blocco. <br /><b>Nota:</b> viene mostrato agli utenti connessi a Microsoft 365 e li porta alla pagina di gestione della connessione.';
$string['settings_showcoursespsite'] = 'Mostra "Sito SharePoint del corso"';
$string['settings_showcoursespsite_desc'] = 'Abilita o disabilita il link "Sito SharePoint del corso" nel blocco. <br /><b>Nota:</b> viene mostrato nel blocco quando si visualizza un corso che ha un sito SharePoint associato.';
$string['settings_showcourselinks'] = 'Mostra i link del corso';
$string['settings_showcourselinks_desc'] = 'Abilita o disabilita l\'intera sezione del corso del blocco mostrata durante la visualizzazione di un corso, inclusa l\'intestazione sullo stato del corso e tutti i link del corso. <br /><b>Nota:</b> quando è disabilitata, le impostazioni dei singoli link del corso riportate sotto vengono ignorate.';
$string['settings_showcourseconfiguresync'] = 'Mostra "Configura sincronizzazione del corso"';
$string['settings_showcourseconfiguresync_desc'] = 'Abilita o disabilita il link "Configura sincronizzazione del corso" nella sezione del corso del blocco.';
$string['settings_showcourseteam'] = 'Mostra "Team"';
$string['settings_showcourseteam_desc'] = 'Abilita o disabilita il link "Team" nella sezione del corso del blocco.';
$string['settings_showcourseconversations'] = 'Mostra "Conversazioni di Outlook"';
$string['settings_showcourseconversations_desc'] = 'Abilita o disabilita il link "Conversazioni di Outlook" nella sezione del corso del blocco.';
$string['settings_showcourseonedrive'] = 'Mostra "File di OneDrive"';
$string['settings_showcourseonedrive_desc'] = 'Abilita o disabilita il link "File di OneDrive" nella sezione del corso del blocco.';
$string['settings_showcoursecalendar'] = 'Mostra "Calendario di Outlook"';
$string['settings_showcoursecalendar_desc'] = 'Abilita o disabilita il link "Calendario di Outlook" nella sezione del corso del blocco.';
$string['settings_showcoursenotebook'] = 'Mostra "Blocco appunti per la classe"';
$string['settings_showcoursenotebook_desc'] = 'Abilita o disabilita il link "Blocco appunti per la classe" nella sezione del corso del blocco.';
$string['settings_showcoursereset'] = 'Mostra "Opzioni di reset del corso"';
$string['settings_showcoursereset_desc'] = 'Abilita o disabilita il link "Opzioni di reset del corso" nella sezione del corso del blocco.';
$string['settings_geto365link'] = 'URL di download di Installa Office';
$string['settings_geto365link_desc'] = 'L\'URL da utilizzare per il link "Installa Office".';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['settings_showword'] = 'Mostra "Word"';
$string['settings_showword_desc'] = 'Abilita o disabilita il link "Word" nel blocco.';
$string['settings_showexcel'] = 'Mostra "Excel"';
$string['settings_showexcel_desc'] = 'Abilita o disabilita il link "Excel" nel blocco.';
$string['settings_showpowerpoint'] = 'Mostra "PowerPoint"';
$string['settings_showpowerpoint_desc'] = 'Abilita o disabilita il link "PowerPoint" nel blocco.';
$string['settings_showvivaengage'] = 'Mostra "Viva Engage"';
$string['settings_showvivaengage_desc'] = 'Abilita o disabilita il link "Viva Engage" nel blocco.';
$string['settings_showvivaamplify'] = 'Mostra "Viva Amplify"';
$string['settings_showvivaamplify_desc'] = 'Abilita o disabilita il link "Viva Amplify" nel blocco. <br /><b>Nota:</b> affinché il link venga mostrato, è necessario configurare anche l\'URL di Viva Amplify riportato sotto.';
$string['settings_vivaamplifyurl'] = 'URL di Viva Amplify';
$string['settings_vivaamplifyurl_desc'] = 'L\'URL dell\'esperienza Viva Amplify della tua organizzazione, come configurato dall\'amministratore del tenant Microsoft 365, ad es. https://amplify.microsoft.com/. Sono accettati solo URL su un dominio amplify.microsoft.com o amplify.cloud.microsoft.';
$string['settings_showvivaconnections'] = 'Mostra "Viva Connections"';
$string['settings_showvivaconnections_desc'] = 'Abilita o disabilita il link "Viva Connections" nel blocco. <br /><b>Nota:</b> affinché il link venga mostrato, è necessario configurare anche l\'URL di Viva Connections riportato sotto.';
$string['settings_vivaconnectionsurl'] = 'URL di Viva Connections';
$string['settings_vivaconnectionsurl_desc'] = 'L\'URL dell\'esperienza Viva Connections della tua organizzazione, come configurato dall\'amministratore del tenant Microsoft 365. Di solito corrisponde al sito home di SharePoint, ad es. https://yourtenant.sharepoint.com/sites/yourhomesite. Sono accettati solo URL su un dominio *.sharepoint.com (o equivalente per cloud sovrani).';
$string['settings_showvivaglint'] = 'Mostra "Viva Glint"';
$string['settings_showvivaglint_desc'] = 'Abilita o disabilita il link "Viva Glint" nel blocco.';
$string['settings_showvivagoals'] = 'Mostra "Viva Goals"';
$string['settings_showvivagoals_desc'] = 'Abilita o disabilita il link "Viva Goals" nel blocco.';
$string['settings_showvivainsights'] = 'Mostra "Viva Insights"';
$string['settings_showvivainsights_desc'] = 'Abilita o disabilita il link "Viva Insights" nel blocco.';
$string['settings_showvivalearning'] = 'Mostra "Viva Learning"';
$string['settings_showvivalearning_desc'] = 'Abilita o disabilita il link "Viva Learning" nel blocco. <br /><b>Nota:</b> affinché il link venga mostrato, è necessario configurare anche l\'URL di Viva Learning riportato sotto.';
$string['settings_vivalearningurl'] = 'URL di Viva Learning';
$string['settings_vivalearningurl_desc'] = 'L\'URL dell\'esperienza Viva Learning della tua organizzazione, come configurato dall\'amministratore del tenant Microsoft 365, ad es. https://web.viva.microsoft.com/learning. Sono accettati solo URL su un dominio viva.microsoft.com o cloud.microsoft.';
$string['settings_showvivapulse'] = 'Mostra "Viva Pulse"';
$string['settings_showvivapulse_desc'] = 'Abilita o disabilita il link "Viva Pulse" nel blocco.';
$string['settings_showlinkedin'] = 'Mostra "LinkedIn"';
$string['settings_showlinkedin_desc'] = 'Abilita o disabilita il link "LinkedIn" nel blocco.';

$string['linkmydelve'] = 'Il mio Delve';
$string['linkmyforms'] = 'I miei moduli';
$string['privacy:metadata'] = 'Il blocco Microsoft visualizza solo link a varie funzionalità e servizi.';

// Course sync features.
$string['course_feature_team'] = 'Team';
$string['course_feature_conversations'] = 'Conversazioni di Outlook';
$string['course_feature_onedrive'] = 'File di OneDrive';
$string['course_feature_calendar'] = 'Calendario di Outlook';
$string['course_feature_notebook'] = 'Blocco appunti per la classe';

// Course sync settings.
$string['configure_sync'] = 'Configura sincronizzazione del corso';
$string['error_course_sync_not_configurable_per_course'] = 'La sincronizzazione del corso non può essere configurata per singolo corso.';
$string['sync_page_heading'] = 'Sincronizza il corso {$a} con Microsoft Teams';
$string['configure_course_sync'] = 'Configura la sincronizzazione del corso con Microsoft Teams';
$string['course_sync_option'] = 'Opzione di sincronizzazione';
$string['course_sync_option_disabled'] = 'Disabilitata';
$string['course_sync_option_enabled'] = 'Abilitata';
$string['sync_setting_saved'] = 'L\'opzione di sincronizzazione del corso è stata salvata';

// Course reset status.
$string['course_reset_disconnect_and_create_new'] = 'Quando il corso viene resettato, il Team connesso al corso verrà rinominato come configurato e archiviato. Verrà creato un nuovo Team, che sarà connesso al corso.';
$string['course_reset_do_nothing'] = 'Quando il corso viene resettato, la connessione tra il corso e il Team verrà mantenuta. Tutte le modifiche agli utenti apportate al corso verranno sincronizzate con il Team.';
$string['course_reset_disconnect_only'] = 'Quando il corso viene resettato, il Team connesso al corso verrà rinominato come configurato e archiviato. Non verrà creato alcun nuovo Team.';
$string['configure_reset'] = 'Scegli l\'azione di Microsoft Teams al reset del corso';

// Course reset settings page.
$string['reset_page_heading'] = 'Azione al reset del corso per {$a}';
$string['configure_course_reset'] = 'Configura l\'impostazione di reset del corso';
$string['course_reset_option'] = 'Azione per il Team al reset del corso';
$string['reset_option_do_nothing'] = 'Non fare nulla.<br/>Il Team resterà connesso al corso. Le disiscrizioni degli utenti comporteranno la rimozione della loro appartenenza o proprietà nel Team.';
$string['reset_option_disconnect_and_create_new'] = 'Disconnetti e crea un nuovo Team.<br/>Il Team esistente connesso al corso verrà rinominato come configurato e archiviato. Verrà creato un nuovo Team, che sarà connesso al corso.';
$string['reset_option_disconnect_only'] = 'Solo disconnessione.<br/>Il Team esistente connesso al corso verrà rinominato come configurato e archiviato. Non verrà creato alcun nuovo Team.';
$string['reset_setting_saved'] = 'L\'impostazione di reset del corso è stata salvata.';
$string['error_site_course_sync_disabled'] = 'La sincronizzazione dei corsi non è abilitata';
$string['error_reset_setting_not_managed_per_course'] = 'La configurazione dell\'azione di reset è gestita centralmente dagli amministratori del sito.';
$string['error_connected_team_missing'] = 'Il corso è configurato per essere sincronizzato, ma il Team non è stato trovato.';
$string['error_course_sync_disabled'] = 'Il corso non è configurato per essere sincronizzato.';

// Course request.
$string['linkcourserequest'] = 'Richiedi corso da Teams';
$string['settings_courserequest'] = 'Richiedi corso da Teams';
$string['settings_courserequest_desc'] = 'Richiedi un nuovo corso da Microsoft Teams. Dopo l\'approvazione, il corso verrà creato e connesso a un Team. I membri del Team verranno iscritti al corso.';

$string['customlinks'] = 'Link personalizzati';
$string['customlink_addanother'] = 'Aggiungi un altro link';
$string['customlink_delete'] = 'Elimina questo link';
$string['customlink_error_url'] = 'Inserisci un URL valido che inizi con http:// o https://';
$string['customlink_icon'] = 'Icona';
$string['customlink_name'] = 'Nome';
$string['customlink_nochanges'] = 'Non è stato inserito alcun link personalizzato, quindi non c\'è nulla da salvare.';
$string['customlink_showall'] = 'Mostra anche agli utenti non connessi a Microsoft 365';
$string['customlink_target'] = 'Apri link in';
$string['customlink_url'] = 'URL';
$string['customlink_visibility'] = 'Visibilità';
$string['settings_header_general'] = 'Generale';
$string['settings_pageheading'] = 'Configurazione del blocco Microsoft';
$string['settings_customlinkheading'] = 'Link {$a}';
$string['settings_customlinktarget_blank'] = 'Nuova finestra o scheda';
$string['settings_customlinktarget_self'] = 'Stessa finestra';
$string['settings_customlinks_desc'] = 'Aggiungi al blocco i tuoi link personalizzati (ad es. un chatbot interno o un sito intranet). Per ogni link sono obbligatori nome, URL e icona. Per rimuovere un link, seleziona "Elimina questo link" e salva.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
