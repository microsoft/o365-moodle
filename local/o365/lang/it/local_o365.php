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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Integrazione Microsoft 365';

// Settings - tabs.
$string['settings_pageheading'] = 'Configurazione di {$a}';
$string['settings_header_setup'] = 'Configurazione';
$string['settings_header_usersync'] = 'Sincronizzazione utenti';
$string['settings_header_coursesync'] = 'Sincronizzazione corsi';
$string['settings_header_advanced'] = 'Avanzate';
$string['settings_header_sds'] = 'Sincronizzazione SDS';
$string['settings_header_teams'] = 'Impostazioni Teams';
$string['settings_header_moodle_app'] = 'App Moodle per Teams';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'Passo 1/2: registrare Moodle in Microsoft Entra ID';
$string['settings_setup_step1_desc'] = 'Registrare una nuova app Microsoft Entra ID per l\'integrazione con Moodle utilizzando PowerShell:

<a href="{$a}/local/o365/scripts/Moodle-EntraID-PowerShell.zip" class="btn btn-primary" target="_blank">Scarica script PowerShell</a>

<p style="margin-top:10px"><a href="{$a}/local/o365/scripts/README.md" target="_blank">Fare clic qui</a> per leggere le istruzioni per l\'esecuzione dello script.</p>
<p>Quando richiesto, utilizzare il seguente link come URL di Moodle:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />Una volta eseguito correttamente lo script, copiare l\'ID applicazione e il segreto restituiti dallo script nella <a href="{$a}">pagina di configurazione del plugin di autenticazione OpenID Connect</a>.';
$string['settings_setup_step1_credentials_end'] = 'Se non è possibile configurare l\'app Microsoft Entra ID tramite PowerShell, <a href="{$a}" target="_blank">fare clic qui</a> per le istruzioni di configurazione manuale.';
$string['settings_setup_step1_continue'] = '<b>Dopo aver inserito l\'ID applicazione e il segreto, fare clic su "Salva modifiche" in fondo alla pagina per continuare.</b><br /><br /><br /><br /><br />';
$string['settings_setup_step1_existing_settings'] = '<h5>Impostazioni esistenti</h5>';
$string['settings_setup_step2'] = 'Passo 2/2: consenso amministratore e informazioni aggiuntive';
$string['settings_setup_step2_desc'] = 'Quest\'ultimo passo consente di fornire il consenso amministratore per l\'utilizzo di alcune autorizzazioni di Microsoft Entra ID e raccoglie alcune informazioni aggiuntive sull\'ambiente Microsoft 365.<br /><br />';
$string['settings_setup_step3'] = 'Verifica configurazione';
$string['settings_setup_step3_desc'] = 'La configurazione è completa. Fare clic sul pulsante "Aggiorna" qui sotto per verificare la configurazione.';

// Settings in "Step 2/2" section of the "Setup" tab.
$string['settings_adminconsent'] = 'Consenso amministratore';
$string['settings_adminconsent_btn'] = 'Fornisci consenso amministratore';
$string['settings_adminconsent_details'] = 'Per consentire l\'accesso ad alcune delle autorizzazioni necessarie, un amministratore deve fornire il consenso amministratore. Fare clic su questo pulsante, quindi accedere con un account amministratore di Microsoft Entra ID per fornire il consenso. Questa operazione dovrà essere ripetuta ogni volta che si modificano le autorizzazioni "Admin" in Entra ID.';
$string['settings_entratenant'] = 'Tenant Microsoft Entra';
$string['settings_entratenant_details'] = 'Utilizzato per identificare l\'organizzazione all\'interno di Microsoft. Ad esempio: "contoso.onmicrosoft.com".<br/>
Per trovare manualmente questo valore:
<ul>
<li>Andare su <a href="https://portal.azure.com" target="_blank">Azure Portal</a>.</li>
<li>Accedere con l\'account amministratore.</li>
<li>Nella barra di ricerca, digitare "Microsoft Entra ID" e andare alla pagina "Microsoft Entra ID".</li>
<li>Utilizzare il valore del campo <b>Dominio primario</b> nella sezione "Informazioni di base".</li>
</ul>';
$string['settings_odburl'] = 'URL di OneDrive for Business';
$string['settings_odburl_details'] = 'L\'URL utilizzato per accedere a OneDrive for Business. Può essere in genere determinato dal tenant Microsoft Entra. Ad esempio, se il tenant Microsoft Entra è "contoso.onmicrosoft.com", è probabile che l\'URL sia "contoso-my.sharepoint.com". Immettere solo il nome del dominio senza includere http:// o https://';
$string['settings_odburl_error_graph'] = 'Impossibile determinare l\'URL di OneDrive for Business, inserirlo manualmente. In genere può essere ricavato dall\'URL utilizzato per accedere a OneDrive.';
$string['settings_serviceresourceabstract_detect'] = 'Rileva';
$string['settings_serviceresourceabstract_detecting'] = 'Rilevamento in corso...';
$string['settings_serviceresourceabstract_error'] = 'Si è verificato un errore durante il rilevamento dell\'impostazione. Impostarla manualmente.';
$string['settings_serviceresourceabstract_valid'] = '{$a} è utilizzabile.';
$string['settings_serviceresourceabstract_invalid'] = 'Il valore non sembra utilizzabile.';
$string['settings_serviceresourceabstract_nocreds'] = 'Impostare innanzitutto le credenziali dell\'applicazione.';
$string['settings_serviceresourceabstract_empty'] = 'Immettere un valore o fare clic su "Rileva" per rilevare il valore corretto.';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_verifysetup'] = 'Verifica configurazione';
$string['settings_verifysetup_appdataheader'] = 'Registrazione app Microsoft Entra ID';
$string['settings_verifysetup_appdatadesc'] = 'Verifica che i parametri corretti siano impostati nell\'app Entra ID.';
$string['settings_verifysetup_appdatareplyurlcorrect'] = 'URL di risposta corretto';
$string['settings_verifysetup_appdatareplyurlincorrect'] = 'URL di risposta non corretto';
$string['settings_verifysetup_appdatareplyurlgeneralerror'] = 'Impossibile verificare l\'URL di risposta.';
$string['settings_verifysetup_appdatasignonurlcorrect'] = 'URL di accesso corretto.';
$string['settings_verifysetup_appdatasignonurlincorrect'] = 'URL di accesso non corretto';
$string['settings_verifysetup_appdatasignonurlgeneralerror'] = 'Impossibile verificare l\'URL di accesso.';
$string['settings_verifysetup_apppermscorrect'] = 'Le autorizzazioni dell\'applicazione sono corrette.';
$string['settings_verifysetup_details'] = 'Questo strumento esegue una verifica con Microsoft Entra ID per assicurarsi che tutto sia configurato correttamente. <br /><b>Nota:</b> le modifiche apportate all\'app Microsoft Entra ID possono richiedere qualche istante prima di comparire qui. Se è stata apportata una modifica all\'app Microsoft Entra ID e non risulta qui, attendere qualche istante e riprovare.';
$string['settings_verifysetup_correctval'] = 'Valore corretto:';
$string['settings_verifysetup_detectedval'] = 'Valore rilevato:';
$string['settings_verifysetup_update'] = 'Aggiorna';
$string['settings_verifysetup_checking'] = 'Verifica in corso...';
$string['settings_verifysetup_missingappperms'] = 'Autorizzazioni dell\'applicazione mancanti:';
$string['settings_verifysetup_notgranted'] = 'aggiunta all\'applicazione, ma il consenso amministratore non è stato concesso';
$string['settings_verifysetup_missingperms'] = 'Autorizzazioni delegate mancanti:';
$string['settings_verifysetup_permscorrect'] = 'Le autorizzazioni delegate sono corrette.';
$string['settings_verifysetup_errorcheck'] = 'Si è verificato un errore durante il tentativo di verificare la configurazione.';
$string['settings_verifysetup_noinfo'] = 'Non sono ancora disponibili informazioni sulla configurazione dell\'app Microsoft Entra ID. Fare clic sul pulsante Aggiorna per verificare.';
$string['settings_verifysetup_strunifiedpermerror'] = 'Si è verificato un errore durante la verifica delle autorizzazioni di Microsoft Graph API.';
$string['settings_verifysetup_strtenanterror'] = 'Utilizzare il pulsante Rileva per impostare il tenant Microsoft Entra prima di aggiornare la configurazione dell\'app Microsoft Entra ID.';
$string['settings_verifysetup_unifiedheader'] = 'Microsoft Graph API';
$string['settings_verifysetup_unifieddesc'] = 'Microsoft Graph API consente la comunicazione tra Moodle e Microsoft 365.';
$string['settings_verifysetup_unifiederror'] = 'Si è verificato un errore durante la verifica del supporto di Microsoft Graph API.';
$string['settings_verifysetup_unifiedactive'] = 'Microsoft Graph API attiva.';
$string['settings_verifysetup_unifiedmissing'] = 'Microsoft Graph API non è stata trovata in questa applicazione.';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc_credsvalid'] = 'Le credenziali sono state impostate.';
$string['settings_detectoidc_credsvalid_link'] = 'Cambia';
$string['settings_detectoidc_credsinvalid'] = 'Le credenziali non sono state impostate o sono incomplete.';
$string['settings_detectoidc_credsinvalid_link'] = 'Imposta credenziali';
$string['settings_detectperms_nocreds'] = 'Impostare innanzitutto le credenziali applicazione. Consultare l\'impostazione precedente.';
$string['settings_detectperms_errorfix'] = 'Si è verificato un errore durante il tentativo di correzione delle autorizzazioni. Correggerle manualmente in Microsoft Entra ID.';
$string['settings_detectperms_fixperms'] = 'Correggi autorizzazioni';
$string['settings_detectperms_update'] = 'Aggiorna';
$string['settings_detectperms_valid'] = 'Le autorizzazioni sono state impostate.';
$string['settings_detectperms_invalid'] = 'Verifica autorizzazioni in Microsoft Entra ID';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_usersync_general'] = 'Sincronizzazione generale degli utenti';
$string['settings_usersync_suspension'] = 'Sospensione degli account Moodle';
$string['settings_usersync_matching'] = 'Abbinamento utenti';
$string['settings_usersync_photos'] = 'Sincronizza le foto del profilo Microsoft 365 in Moodle';
$string['settings_usersync_timezone'] = 'Sincronizza il fuso orario di Outlook in Moodle';
$string['settings_usersync'] = 'Sincronizza utenti da Microsoft Entra ID';
$string['settings_usersync_details'] = 'Se abilitata, Moodle sincronizza gli utenti da Microsoft Entra ID in base alle opzioni precedenti.<br /><br /><b>Nota: </b>il processo di sincronizzazione viene eseguito nel cron di Moodle e sincronizza 1000 utenti alla volta. Per impostazione predefinita, viene eseguito una volta al giorno alle 1:00 nel fuso orario locale del server. Per sincronizzare grandi insiemi di utenti più rapidamente, è possibile aumentare la frequenza dell\'elaborazione <b>Sincronizza utenti da Microsoft Entra ID</b> utilizzando la <a href="{$a}">pagina di gestione delle elaborazioni pianificate.</a><br /><br />';
$string['settings_usersync_create'] = 'Crea account in Moodle per utenti in Microsoft Entra ID';
$string['settings_usersync_update'] = 'Aggiorna gli account in Moodle per gli utenti in Microsoft Entra ID';
$string['settings_usersync_suspend'] = 'Sospendi gli account sincronizzati in precedenza in Moodle quando vengono eliminati da Microsoft Entra ID';
$string['settings_usersync_delete'] = 'Elimina gli account sincronizzati in precedenza in Moodle quando vengono eliminati da Microsoft Entra ID';
$string['settings_usersync_reenable'] = 'Riattiva gli account sospesi per gli utenti in Microsoft Entra ID';
$string['settings_usersync_disabledsyncsuspend'] = 'Sospendi gli account in Moodle quando vengono disabilitati in Microsoft Entra ID';
$string['settings_usersync_disabledsyncreenable'] = 'Riattiva gli account in Moodle quando vengono riabilitati in Microsoft Entra ID';
$string['settings_usersync_suspendnolink'] = 'Sospendi gli account collegati che non hanno un collegamento Microsoft memorizzato quando vengono eliminati da o disabilitati in Microsoft Entra ID';
$string['settings_usersync_groupsyncsuspend'] = 'Sospendi gli account in Moodle quando non appartengono al gruppo di sincronizzazione utenti configurato';
$string['settings_usersync_match'] = 'Abbina gli utenti Moodle preesistenti agli account con lo stesso nome in Microsoft Entra ID';
$string['settings_usersync_matchswitchauth'] = 'Passa gli utenti abbinati all\'autenticazione Microsoft 365 (OpenID Connect)';
$string['settings_usersync_appassign'] = 'Assegna gli utenti all\'applicazione durante la sincronizzazione';
$string['settings_usersync_photosync'] = 'Sincronizza le foto del profilo Microsoft 365 in Moodle nel processo cron';
$string['settings_usersync_photosynconlogin'] = 'Sincronizza le foto del profilo Microsoft 365 in Moodle al login';
$string['settings_usersync_nodelta'] = 'Esegui una sincronizzazione completa a ogni esecuzione';
$string['settings_usersync_emailsync'] = 'Durante la sincronizzazione, abbina i nomi utente di Microsoft Entra ID agli indirizzi email di Moodle anziché ai nomi utente di Moodle';
$string['settings_addsync_tzsync'] = 'Sincronizza il fuso orario di Outlook in Moodle nel processo cron';
$string['settings_addsync_tzsynconlogin'] = 'Sincronizza il fuso orario di Outlook in Moodle al login';
$string['settings_usersync_guestsync'] = 'Sincronizza gli utenti guest';
$string['settings_suspend_delete_running_time'] = 'Orario di esecuzione di sospensione/eliminazione utenti';
$string['settings_suspend_delete_running_time_desc'] = 'Se l\'opzione è abilitata, la funzione di sospensione/eliminazione della sincronizzazione utenti verrà eseguita una volta al giorno, all\'orario configurato nel fuso orario predefinito dell\'istanza Moodle.';
$string['settings_usersync_delete_delay'] = 'Ritardo prima dell\'eliminazione degli utenti sospesi';
$string['settings_usersync_delete_delay_desc'] = 'Il tempo minimo per cui un utente deve rimanere sospeso in Moodle prima che la sincronizzazione utenti elimini l\'account. Questo tempo si aggiunge al periodo di conservazione dell\'eliminazione temporanea (soft-delete) di Microsoft Entra ID, quindi l\'eliminazione non avviene mai prima di tale periodo. Impostare 0 per eliminare non appena è terminato il periodo di conservazione di Microsoft Entra ID. Per gli utenti già sospesi prima dell\'introduzione di questa impostazione, il tempo viene calcolato a partire dalla prima esecuzione della sincronizzazione utenti che li rileva.';
$string['settings_support_user_identifier_change'] = 'Supporta la modifica del valore del claim del nome utente di collegamento dell\'account Microsoft';
$string['settings_support_user_identifier_change_desc'] = 'Se abilitata, Moodle cercherà di reagire quando cambia il valore del claim del nome utente di collegamento (normalmente l\'UPN) di un account Microsoft collegato a un account Moodle.<br/>
<table class="flexible table table-striped table-hover generaltable generalbox table-sm">
    <tr>
        <th>ID del caso</th>
        <th>L\'utente con il vecchio nome utente ha già effettuato il login? (token creato)<br/>
        <span class="support_user_identifier_change_case_detail">Se un token è salvato nella tabella auth_oidc_token</span>
        </th>
        <th>Prima azione dopo la ridenominazione dell\'UPN<br/>
        <span class="support_user_identifier_change_case_detail">Login oppure esecuzione dell\'elaborazione di sincronizzazione utenti</span>
        </th>
        <th>Possibile nome utente duplicato<br/>
        <span class="support_user_identifier_change_case_detail">Se la ridenominazione causerebbe un conflitto di nomi utente in Moodle</span>
        </th>
        <th>Comportamenti previsti</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Sì</td>
        <td>Login</td>
        <td>No</td>
        <td>
            <ol>
                <li>Rinomina l\'utente Moodle.</li>
                <li>Il record in auth_oidc_token viene aggiornato con i nuovi valori per entrambi i campi "username" e "oidcusername".</li>
                <li>Il campo "o365name" del record di collegamento utente in local_o365_objects viene aggiornato al nuovo valore.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Sì</td>
        <td>Sincronizzazione utenti</td>
        <td>No</td>
        <td>
            <ol>
                <li>Rinomina l\'utente Moodle.</li>
                <li>Il record di collegamento utente in local_o365_objects viene aggiornato.</li>
                <li>Il record in auth_oidc_token viene aggiornato.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>No</td>
        <td>Login</td>
        <td>No</td>
        <td>
            <ol>
                <li>Rinomina l\'utente Moodle.</li>
                <li>Il record di collegamento utente in local_o365_objects viene aggiornato.</li>
                <li>Il record in auth_oidc_token viene aggiornato.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>No</td>
        <td>Sincronizzazione utenti</td>
        <td>No</td>
        <td>
            <ol>
                <li>Rinomina l\'utente Moodle.</li>
                <li>Il record di collegamento utente in local_o365_objects viene aggiornato.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>Sì</td>
        <td>Login</td>
        <td>Sì</td>
        <td>
            <ol>
                <li>Genera un\'eccezione e non rinomina l\'utente Moodle.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>Sì</td>
        <td>Sincronizzazione utenti</td>
        <td>Sì</td>
        <td>
            <ol>
                <li>Visualizza un messaggio di errore che indica che il tentativo di ridenominazione non è riuscito durante l\'esecuzione dell\'elaborazione di sincronizzazione utenti.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>No</td>
        <td>Login</td>
        <td>Sì</td>
        <td>
            <ol>
                <li>Genera un\'eccezione e non rinomina l\'utente Moodle.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>No</td>
        <td>Sincronizzazione utenti</td>
        <td>Sì</td>
        <td>
            <ol>
                <li>Visualizza un messaggio di errore che indica che il tentativo di ridenominazione non è riuscito durante l\'esecuzione dell\'elaborazione di sincronizzazione utenti.</li>
            </ol>
        </td>
    </tr>
</table>
Nota: esiste un problema noto per cui se
<ol>
<li>Moodle e Microsoft 365 sono collegati con il metodo di connessione "Microsoft identity platform (v2.0)", e</li>
<li>Microsoft Entra è configurato per consentire l\'uso di "Email come ID di accesso alternativo", e</li>
<li>questa opzione è abilitata, e</li>
<li>il nome utente e l\'indirizzo email dell\'account Microsoft sono diversi, e</li>
<li>l\'utente Microsoft accede utilizzando l\'indirizzo email anziché il nome utente</li>
</ol>
allora il plugin auth_oidc tratterà l\'indirizzo email come nome utente dell\'account Microsoft e aggiornerà il nome utente Moodle.';

// User field mapping.
$string['settings_fieldmap'] = 'Mappatura dei campi utente';
$string['settings_fieldmap_details'] = 'Disponibile nel <a href="{$a}">plugin di autenticazione OpenID Connect</a>.';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'Sincronizzazione corsi';
$string['settings_secthead_coursesync_desc'] = 'Le seguenti impostazioni controllano la sincronizzazione dei corsi tra Moodle e Microsoft Teams.';
$string['settings_coursesync'] = 'Sincronizzazione corsi';
$string['settings_coursesync_details'] = 'Se abilitata, questa opzione crea e mantiene i Team per i corsi del sito Moodle (impostazione predefinita: disabilitata). A ogni esecuzione del cron verranno creati i Team necessari e tutti gli utenti attualmente iscritti verranno aggiunti come proprietari o membri del Team, in base alla verifica dei privilegi. Successivamente, l\'appartenenza ai Team verrà mantenuta man mano che gli utenti vengono iscritti o disiscritti dai corsi Moodle.';
$string['acp_coursesynccustom_off'] = 'Disabilitata<br />Disabilita la creazione dei Team per tutti i corsi.';
$string['acp_coursesynccustom_oncustom'] = 'Personalizza<br />Consente agli utenti autorizzati di selezionare per quali corsi creare i Team.<br> <span id="adminsetting_coursesync" style="font-weight: bold"><a href="{$a}">Personalizza sincronizzazione corsi</a></span>';
$string['acp_coursesynccustom_onall'] = 'Tutte le funzionalità abilitate<br />Abilita la creazione dei Team per tutti i corsi.';
$string['settings_coursesync_sync_hidden_courses'] = 'Sincronizza i corsi nascosti';
$string['settings_coursesync_sync_hidden_courses_desc'] = 'Per impostazione predefinita, il plugin ignora i corsi nascosti per evitare di sincronizzare corsi in fase di copia o ripristino. Abilitare questa impostazione per forzare la creazione dei Team per i corsi nascosti.';
$string['acp_coursesync_hidden_course_note'] = 'Nota: i corsi nascosti non verranno elaborati per la creazione dei gruppi Teams. Per consentirlo, è necessario abilitare l\'impostazione "Sincronizza i corsi nascosti" nella configurazione del plugin.';
$string['settings_coursesync_delete_group_on_course_deletion'] = 'Elimina i gruppi Microsoft 365 quando il corso Moodle collegato viene eliminato';
$string['settings_coursesync_delete_group_on_course_deletion_details'] = 'Se abilitata, Moodle tenterà di eliminare il gruppo Microsoft 365 (e il Team associato) quando il corso collegato viene eliminato da Moodle. Nota: ciò non si applica ai corsi creati dalla sincronizzazione SDS.';
$string['settings_coursesync_delete_group_on_course_sync_disabled'] = 'Elimina i gruppi Microsoft 365 quando la sincronizzazione del corso viene disabilitata';
$string['settings_coursesync_delete_group_on_course_sync_disabled_details'] = 'Se abilitata, Moodle tenterà di eliminare il gruppo Microsoft 365 collegato (e il Team associato) quando la sincronizzazione del corso viene disattivata per un corso Moodle.';
$string['settings_coursesync_courses_per_task'] = 'Corsi da sincronizzare per esecuzione dell\'elaborazione';
$string['settings_coursesync_courses_per_task_details'] = 'Il numero di corsi di cui elaborare lo stato di sincronizzazione Team/gruppo a ogni esecuzione dell\'elaborazione.';
$string['settings_coursesync_team_type'] = 'Modello di Team';
$string['settings_coursesync_team_type_desc'] = 'Il modello di Microsoft Teams da utilizzare per la creazione dei Team dai corsi Moodle. I modelli Education richiedono una licenza Education. <br><br><strong>Importante:</strong> il modello configurato determina il modo in cui vengono creati gruppi e team:<br>
&bull; Il modello Standard crea gruppi e team standard (compatibili con tutti i tenant).<br>
&bull; I modelli Education creano gruppi/team Education (solo tenant Education; abilitano funzionalità specifiche per l\'istruzione).<br>
&bull; I modelli personalizzati utilizzano gruppi standard (per compatibilità con la struttura dei modelli personalizzati).<br><br>
<strong>⚠️ ATTENZIONE: una volta creato un team con un modello specifico, il modello non può essere modificato.</strong> I team restano associati al modello originale. La modifica di questa impostazione riguarda solo i team creati successivamente, non quelli esistenti. Pianificare con attenzione la scelta del modello prima di abilitare la sincronizzazione dei corsi.';
$string['settings_coursesync_team_type_standard'] = 'Standard';
$string['settings_coursesync_team_type_educationclass'] = 'Education - Team della classe';
$string['settings_coursesync_team_type_educationstaff'] = 'Education - Team del personale';
$string['settings_coursesync_team_type_educationplc'] = 'Education - Comunità di apprendimento professionale (PLC)';
$string['settings_coursesync_team_type_custom'] = 'Modello personalizzato';
$string['settings_coursesync_team_type_custom_id'] = 'ID modello personalizzato';
$string['settings_coursesync_team_type_custom_id_desc'] = 'L\'ID completo di un modello personalizzato definito nell\'interfaccia di amministrazione di Teams. Utilizzato solo quando è selezionato "Modello personalizzato" qui sopra. <br><br><strong>L\'ID del modello deve essere in formato GUID</strong> (ad es. e41de7bb-859a-4a0f-aa39-5725a0529c1c). L\'ID del modello è disponibile nell\'interfaccia di amministrazione di Teams visualizzando i dettagli del modello personalizzato. <br><br>
<strong>⚠️ È RICHIESTA UN\'AUTORIZZAZIONE AGGIUNTIVA DI MICROSOFT ENTRA ID:</strong> la convalida e l\'utilizzo dei modelli di team personalizzati richiedono un\'autorizzazione applicazione aggiuntiva di Microsoft Graph API (<strong>TeamTemplates.Read.All</strong>) che potrebbe non essere presente nella registrazione dell\'app Microsoft Entra ID. Senza questa autorizzazione, il passaggio di convalida non riuscirà e l\'ID del modello personalizzato non potrà essere impostato. Se la convalida non riesce con un errore di autorizzazione, contattare l\'amministratore di Microsoft Entra ID per aggiungere questa autorizzazione alla registrazione dell\'app. <br><br>
<strong>⚠️ LIMITAZIONE IMPORTANTE:</strong> attualmente il framework di Microsoft Teams supporta la creazione di team da modelli personalizzati solo quando il modello include una <strong>definizione per la lingua en-US</strong>. I modelli personalizzati senza supporto per la lingua en-US non riusciranno a creare i team. Assicurarsi che il modello personalizzato abbia una lingua en-US definita nell\'interfaccia di amministrazione di Teams. <br><br>
<strong>⚠️ ATTENZIONE: una volta creato un team con questo modello personalizzato, il modello non può essere modificato.</strong> Se occorre utilizzare un modello personalizzato diverso per i nuovi team, è necessario lasciare vuota questa impostazione o modificarla prima della successiva creazione di un team. I team esistenti continueranno a utilizzare il modello originale. <br><br>
I team non verranno creati correttamente se viene configurato un ID modello non corretto. Utilizzare il pulsante "Convalida ID modello personalizzato" per convalidare l\'ID del modello prima di eseguire la sincronizzazione dei corsi.';
$string['error_custom_template_id_required'] = 'L\'ID del modello personalizzato è obbligatorio quando si utilizza l\'opzione "Modello personalizzato". Inserire un ID modello valido.';
$string['error_custom_template_id_not_found'] = 'ID modello personalizzato "{$a}" non trovato. Verificare che l\'ID del modello esista nell\'interfaccia di amministrazione di Teams.';
$string['error_custom_template_id_validation_failed'] = 'Convalida dell\'ID modello personalizzato non riuscita. Il modello potrebbe non supportare la creazione diretta di team oppure potrebbe esserci un problema di configurazione. Verificare l\'ID del modello nell\'interfaccia di amministrazione di Teams.';
$string['settings_team_type_custom_id_test_button'] = 'Convalida ID modello personalizzato';
$string['settings_team_type_custom_id_validating'] = '🔄 Convalida in corso...';
$string['settings_team_type_custom_id_error_empty'] = '⚠️ Inserire prima un ID modello.';
$string['settings_team_type_custom_id_error_not_found'] = '✗ Modello non trovato. L\'ID modello "{$a}" non esiste. Verificarlo nell\'interfaccia di amministrazione di Teams.';
$string['settings_team_type_custom_id_error_validation'] = '✗ Errore di convalida. {$a}';
$string['settings_team_type_custom_id_error_default'] = 'Impossibile convalidare il modello. Riprovare o contattare l\'amministratore.';
$string['settings_team_type_custom_id_error_timeout'] = '✗ Timeout della convalida. La richiesta ha richiesto più di 10 secondi. Riprovare.';
$string['settings_team_type_custom_id_error_network'] = '✗ Errore di rete. Impossibile raggiungere il servizio di convalida. Verificare la connessione Internet e riprovare.';
$string['settings_team_type_custom_id_error_parsererror'] = '✗ Errore nella risposta del server. Il servizio di convalida ha restituito dati non validi. Verificare l\'integrazione con Microsoft 365.';
$string['settings_team_type_custom_id_error_http'] = '✗ Errore di convalida (HTTP {$a}). Riprovare o contattare l\'amministratore.';
$string['settings_coursesync_group_channels'] = 'Crea un canale per ogni gruppo Moodle';
$string['settings_coursesync_group_channels_details'] = 'Crea un canale privato nel Team Microsoft collegato per ogni gruppo del corso Moodle e mantiene i membri di ciascun canale allineati ai membri del gruppo Moodle. I membri del gruppo che sono anche collegati a Microsoft 365 vengono aggiunti al canale o rimossi da esso quando vengono aggiunti al gruppo o rimossi dal gruppo. Chiunque venga aggiunto a un canale in Microsoft Teams senza essere membro del gruppo Moodle viene nuovamente rimosso. In un Team della classe Education non ancora attivato, gli studenti non possono essere inseriti nei canali: vengono inseriti solo i proprietari, mentre gli studenti vengono aggiunti automaticamente dall\'elaborazione pianificata "Crea canali Teams per i gruppi Moodle e sincronizza i relativi membri" dopo che un proprietario ha attivato il Team in Microsoft Teams. I canali non vengono rinominati né eliminati quando un gruppo Moodle viene rinominato o eliminato. L\'appartenenza ai canali viene sincronizzata solo da Moodle a Teams e questa opzione non ha alcun effetto se "Comportamento della sincronizzazione utenti dei corsi" è impostato su "Da Teams a Moodle". Microsoft Teams consente fino a 1.000 canali per Team, contando i canali privati e i canali eliminati negli ultimi 30 giorni.<br /><br /><b>Questa impostazione richiede due autorizzazioni applicazione aggiuntive di Microsoft Graph:</b><ul><li><b>Channel.Create</b> - per creare i canali.</li><li><b>ChannelMember.ReadWrite.All</b> - per aggiungere e rimuovere membri dai canali.</li></ul>Entrambe devono essere aggiunte all\'applicazione Microsoft Entra ID utilizzata da Moodle e deve essere concesso il consenso amministratore. Lo script PowerShell nella scheda "Configurazione" le include già quando registra una nuova applicazione. Per un\'applicazione esistente, aggiungerle manualmente in Registrazioni app &gt; la propria applicazione &gt; Autorizzazioni API &gt; Aggiungi un\'autorizzazione &gt; Microsoft Graph &gt; Autorizzazioni applicazione, quindi concedere il consenso amministratore. Finché questa impostazione è abilitata, "Verifica configurazione" nella scheda "Configurazione" segnala queste autorizzazioni come mancanti fino a quando non vengono concesse.';
$string['settings_coursesync_sync_direction'] = 'Comportamento della sincronizzazione utenti dei corsi';
$string['settings_coursesync_sync_direction_details'] = 'Selezionare la direzione in cui sincronizzare gli utenti tra Moodle e Microsoft Teams.';
$string['settings_coursesync_sync_moodle_to_teams'] = 'Da Moodle a Teams';
$string['settings_coursesync_sync_teams_to_moodle'] = 'Da Teams a Moodle';
$string['settings_coursesync_sync_both'] = 'Aggiorna sia Teams sia Moodle';
$string['settings_coursesync_enrolment_owner_role'] = 'Ruolo del proprietario del Team';
$string['settings_coursesync_enrolment_owner_role_desc'] = 'Il ruolo che verrà assegnato al proprietario del Team durante la sincronizzazione.';
$string['settings_coursesync_enrolment_member_role'] = 'Ruolo dei membri del Team';
$string['settings_coursesync_enrolment_member_role_desc'] = 'Il ruolo che verrà assegnato ai membri del Team durante la sincronizzazione.';

// Settings in the "Course sync customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_coursesynccustom'] = 'Personalizzazione della sincronizzazione corsi';
$string['acp_coursesynccustom_enabled'] = 'Abilitata';
$string['acp_coursesynccustom_enable_all'] = 'Abilita la sincronizzazione su tutti i corsi';
$string['acp_coursesynccustom_disable_all'] = 'Disabilita la sincronizzazione su tutti i corsi';
$string['acp_coursesynccustom_bulk'] = 'Operazioni in blocco';
$string['acp_coursesynccustom_bulk_enable'] = 'Abilita la sincronizzazione sui corsi di questa pagina';
$string['acp_coursesynccustom_bulk_disable'] = 'Disabilita la sincronizzazione sui corsi di questa pagina';
$string['acp_coursesynccustom_settings_header'] = 'Opzioni di sincronizzazione';
$string['acp_coursesynccustom_new_course'] = 'Abilitata per impostazione predefinita per i nuovi corsi';
$string['acp_coursesynccustom_new_course_desc'] = 'Se abilitata, tutti i nuovi corsi avranno la sincronizzazione abilitata per impostazione predefinita.';
$string['acp_coursesynccustom_controlled_per_course'] = 'Consenti la configurazione della sincronizzazione nei corsi';
$string['acp_coursesynccustom_controlled_per_course_desc'] = 'Se abilitata, gli utenti iscritti ai corsi Moodle che possono agire come proprietari del Team (con il privilegio "Proprietario del Team" [local/o365:teamowner]) potranno controllare la sincronizzazione del corso dal blocco Microsoft nel corso.';
$string['acp_coursesynccustom_savemessage'] = 'Le modifiche sono state salvate.';
$string['acp_coursesynccustom_regex_search'] = 'Ricerca con espressione regolare';
$string['acp_coursesynccustom_regex_search_title'] = 'Se selezionata, il contenuto della casella di ricerca qui sopra viene confrontato come espressione regolare PCRE (senza delimitatori) con il nome completo, il nome breve e il codice identificativo, anziché eseguire una ricerca di testo semplice.';
$string['acp_coursesynccustom_confirm_all_action'] = 'Modificare lo stato di sincronizzazione di tutti i corsi? L\'azione non può essere annullata.';
$string['acp_coursesynccustom_sds_course'] = 'Bloccato per corso SDS';
$string['acp_coursesynccustom_all_enabled_notice'] = 'La sincronizzazione dei corsi è attualmente abilitata per tutti i corsi. La personalizzazione dei singoli corsi è disabilitata perché è attiva la modalità "Tutte le funzionalità abilitate".';
$string['acp_coursesynccustom_disabled_notice'] = 'La sincronizzazione dei corsi è attualmente disabilitata a livello globale. La personalizzazione dei singoli corsi è disabilitata perché è attiva la modalità "Disabilitata".';
$string['acp_coursesynccustom_categories_header'] = 'Sincronizzazione per categoria di corsi';
$string['acp_coursesynccustom_categories_desc'] = 'Selezionare una o più categorie di corsi per abilitare automaticamente la sincronizzazione per tutti i corsi di tali categorie, incluse le relative sottocategorie. Ciò si applica anche ai corsi aggiunti successivamente alle categorie selezionate. Tenere premuto Ctrl (Cmd su Mac) per selezionare più categorie oppure fare di nuovo clic tenendolo premuto per deselezionare.';
$string['acp_coursesynccustom_category_course'] = 'Bloccato: abilitato dalla categoria di corsi';

// Settings in the "Cohort sync" section of the "Sync settings" tab.
$string['settings_secthead_cohortsync'] = 'Sincronizzazione gruppi globali';
$string['settings_secthead_cohortsync_desc'] = 'Questa funzionalità abilita la sincronizzazione tra i gruppi Microsoft 365 e i gruppi globali Moodle.';
$string['settings_cohortsync'] = 'Sincronizzazione gruppi globali';
$string['settings_cohortsync_linktext'] = 'Gestisci sincronizzazione gruppi globali';
$string['settings_cohortsync_details'] = 'Esaminare e gestire la sincronizzazione tra i gruppi globali Moodle e i gruppi Microsoft 365.';
$string['settings_cohortsync_title'] = 'Sincronizzazione gruppi globali';
$string['settings_cohortsync_excludeowners'] = 'Escludi i proprietari dei gruppi dalla sincronizzazione gruppi globali';
$string['settings_cohortsync_excludeowners_desc'] = 'Se abilitata, i proprietari dei gruppi non vengono sincronizzati nei gruppi globali Moodle, anche se sono anche membri del gruppo. I proprietari già presenti in un gruppo globale verranno rimossi alla successiva esecuzione della sincronizzazione.';

// Settings in the "Team / group names" section of the "Sync settings" tab.
$string['settings_secthead_team_group_name'] = 'Nomi di Team / gruppi';
$string['settings_secthead_team_group_name_desc'] = 'Se un corso è configurato per la sincronizzazione, il nome del Team e del gruppo verrà costruito come segue.<br/>
<ul>
<li>È possibile definire l\'alias di posta del gruppo e il nome visualizzato del team.</li>
<li>Verrà creato prima il gruppo Microsoft 365 utilizzando il mailNickname del gruppo e il nome visualizzato del team configurati, quindi verrà creato un Team dal gruppo.</li>
<li>Se viene utilizzato il criterio di denominazione di Microsoft Entra ID per i gruppi Microsoft 365, i gruppi non verranno creati se il nome visualizzato generato in base alla configurazione non rispetta i criteri.</li>
<li>Le modifiche apportate qui influiranno solo sulla creazione futura dei Team e non su quelli esistenti.</li>
<li>Tutti gli spazi verranno rimossi dall\'alias di posta del gruppo.</li>
<li>Nell\'alias di posta del gruppo sono consentiti solo lettere maiuscole e minuscole, numeri, - e _.</li>
<li>L\'alias di posta del gruppo, inclusi prefisso e suffisso, non può superare i 64 caratteri.</li>
<li>L\'alias di posta del gruppo deve essere univoco, altrimenti verrà aggiunto un numero casuale di 4 cifre per garantirne l\'univocità.</li>
</ul>';
$string['settings_team_name_prefix'] = 'Prefisso del nome del Team';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'Parte del nome del Team relativa al corso';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'Suffisso del nome del Team';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_group_mail_alias_prefix'] = 'Prefisso dell\'alias di posta del gruppo';
$string['settings_group_mail_alias_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'Parte dell\'alias di posta del gruppo relativa al corso';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'Suffisso dell\'alias di posta del gruppo';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'Si supponga che un corso abbia:
<ul>
<li>Nome completo: <b>Sample course</b></li>
<li>Nome breve: <b>sample 15</b></li>
<li>ID creato da Moodle: <b>2</b></li>
<li>Codice identificativo: <b>Sample ID 15</b></li>
</ul>
Con l\'impostazione attuale verrà creato un gruppo con alias di posta "<b>{$a->mailalias}</b>" e un Team con nome "<b>{$a->teamname}</b>".<br/>
Fare clic sul pulsante "Salva modifiche" qui sotto per vedere come le impostazioni modificheranno questi valori.';
$string['settings_main_name_option_full_name'] = 'Nome completo';
$string['settings_main_name_option_short_name'] = 'Nome breve';
$string['settings_main_name_option_id'] = 'ID creato da Moodle';
$string['settings_main_name_option_id_number'] = 'Codice identificativo';
$string['settings_team_name_sync'] = 'Aggiorna il nome del Team all\'aggiornamento del corso';
$string['settings_team_name_sync_desc'] = 'Se abilitata, quando il corso Moodle viene aggiornato, il nome del Team verrà aggiornato in base alle impostazioni più recenti dei nomi dei Team.';

// Settings in the "Course request" section of the "Sync settings" tab.
$string['settings_secthead_course_request'] = 'Richiesta di corso';
$string['settings_secthead_course_request_desc'] = 'Impostazioni per la mappatura dei ruoli nella funzionalità di richiesta di corsi da Teams.';
$string['settings_course_request_enrolment_owner_role'] = 'Ruolo del proprietario del Team';
$string['settings_course_request_enrolment_owner_role_desc'] = 'Il ruolo che verrà assegnato al proprietario del Team quando la richiesta di corso viene approvata.';
$string['settings_course_request_enrolment_member_role'] = 'Ruolo dei membri del Team';
$string['settings_course_request_enrolment_member_role_desc'] = 'Il ruolo che verrà assegnato ai membri del Team quando la richiesta di corso viene approvata.';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'Strumenti';
$string['settings_secthead_calsync'] = 'Sincronizzazione calendario';
$string['settings_calsyncsubscribemode'] = 'Sottoscrizione della sincronizzazione calendario';
$string['settings_calsyncsubscribemode_details'] = 'Determina se gli utenti devono attivare autonomamente la sincronizzazione del calendario di Outlook.<ul><li><b>Opt-in</b>: gli utenti abilitano la sincronizzazione del calendario e selezionano i calendari da sincronizzare nella propria pagina delle impostazioni di sincronizzazione calendario.</li><li><b>Opt-out</b>: per gli utenti collegati a Microsoft 365 la sincronizzazione del calendario viene abilitata automaticamente e vengono sottoscritti ai calendari scelti qui sotto (per i corsi, tutti i corsi a cui sono iscritti, ora e in futuro), con sincronizzazione da Moodle al proprio calendario principale di Outlook. Gli utenti possono comunque modificarla o disattivarla nella propria pagina delle impostazioni di sincronizzazione calendario e gli utenti che disattivano la sincronizzazione del calendario non vengono sottoscritti nuovamente.</li></ul>Tornare a "Opt-in" non rimuove le sottoscrizioni esistenti.';
$string['settings_calsyncsubscribetypes'] = 'Calendari a cui sottoscrivere automaticamente gli utenti';
$string['settings_calsyncsubscribetypes_details'] = 'Si applica solo a "Opt-out". Scegliere a quali calendari Moodle sottoscrivere automaticamente gli utenti collegati. Sottoscrivere tutti al calendario del sito aggiunge ogni utente come partecipante di ciascun evento del sito, pertanto non è selezionato per impostazione predefinita.';
$string['settings_calsyncsubscribetypes_site'] = 'Calendario del sito';
$string['settings_calsyncsubscribetypes_user'] = 'Calendario personale';
$string['settings_calsyncsubscribetypes_course'] = 'Calendari dei corsi (tutti i corsi a cui l\'utente è iscritto)';
$string['settings_calsyncsubscribemode_optin'] = 'Opt-in (gli utenti abilitano autonomamente la sincronizzazione del calendario)';
$string['settings_calsyncsubscribemode_optout'] = 'Opt-out (abilita automaticamente la sincronizzazione del calendario per tutti gli utenti collegati)';
$string['settings_secthead_advanced'] = 'Impostazioni avanzate';
$string['settings_secthead_advanced_desc'] = 'Queste impostazioni controllano altre funzionalità della suite di plugin. Attenzione: potrebbero causare effetti indesiderati.';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'Tenant';
$string['settings_tools_tenants_linktext'] = 'Configura tenant aggiuntivi';
$string['settings_tools_tenants_details'] = 'Gestire l\'accesso a tenant Microsoft Entra aggiuntivi.';
$string['settings_healthcheck'] = 'Controllo stato';
$string['settings_healthcheck_details'] = 'Se il funzionamento non è quello previsto, l\'esecuzione di un controllo stato consente in genere di identificare il problema e proporre soluzioni.';
$string['settings_healthcheck_linktext'] = 'Esegui controllo stato';
$string['settings_userconnections'] = 'Collegamenti utenti';
$string['settings_userconnections_linktext'] = 'Gestisci collegamenti utenti';
$string['settings_userconnections_details'] = 'Esaminare e gestire i collegamenti tra gli utenti Moodle e Microsoft 365.';
$string['settings_teamconnections'] = 'Collegamenti Team';
$string['settings_teamconnections_linktext'] = 'Gestisci collegamenti Team';
$string['settings_teamconnections_details'] = 'Esaminare e gestire i collegamenti tra i corsi Moodle e Microsoft Teams.';
$string['settings_usermatch'] = 'Abbinamento utenti';
$string['settings_usermatch_details'] = 'Questo strumento consente di abbinare gli utenti Moodle agli utenti Microsoft 365 in base a un file di dati personalizzato caricato.';
$string['settings_usersyncgroupfilter'] = 'Filtro di gruppo per la sincronizzazione utenti';
$string['settings_usersyncgroupfilter_details'] = 'Se qui viene inserito l\'ID oggetto (GUID) di un gruppo, le sincronizzazioni complete degli utenti saranno limitate ai membri e ai proprietari di tale gruppo Microsoft 365. Lasciare vuoto per sincronizzare tutti gli utenti con licenza del tenant.<br><br>
<strong>ATTENZIONE: questa è un\'impostazione avanzata. Una configurazione errata può causare gravi problemi di sincronizzazione dei dati.</strong><br><br>
<strong>Se configurata, si applica quanto segue:</strong><br>
(1) Gli aggiornamenti del profilo, del fuso orario e della foto verranno applicati solo agli utenti membri o proprietari del gruppo<br>
(2) I nuovi account Moodle verranno creati solo per gli utenti membri o proprietari del gruppo<br>
(3) Gli account Moodle degli utenti non membri non riceveranno più aggiornamenti e potrebbero non essere più sincronizzati con Microsoft 365<br>
(4) Gli utenti disabilitati in Microsoft 365 verranno comunque sospesi in Moodle dalla sincronizzazione dello stato di abilitazione, che viene eseguita indipendentemente dal filtro di gruppo<br>
(5) La rimozione di un utente dal gruppo interrompe le sincronizzazioni future per tale account. L\'account Moodle non viene eliminato e viene sospeso solo se è abilitata l\'opzione "Sospendi gli account in Moodle quando non appartengono al gruppo di sincronizzazione utenti configurato", che sospende ogni utente sincronizzato che non appartiene al gruppo, indipendentemente dal fatto che vi abbia mai appartenuto<br><br>
<strong>Limitazione della sincronizzazione incrementale (delta):</strong> Microsoft Graph non supporta le query delta sugli endpoint di appartenenza ai gruppi. Quando questa impostazione è configurata, le sincronizzazioni delta eseguiranno una sincronizzazione completa dei membri del gruppo anziché un aggiornamento incrementale. Si tratta del comportamento corretto, ma potrebbe essere più lento di una normale sincronizzazione delta.<br><br>
Convalidare l\'ID oggetto del gruppo prima di salvare. Inserire l\'ID oggetto del gruppo (GUID).';
$string['settings_usersyncgroupfilter_validation_error'] = 'Formato dell\'ID gruppo non valido. L\'ID gruppo deve essere un GUID valido (ad es. 550e8400-e29b-41d4-a716-446655440000).';
$string['settings_usersynccreationrestriction'] = 'Restrizione sulla creazione degli utenti';
$string['settings_usersynccreationrestriction_details'] = 'Se abilitata, durante la sincronizzazione utenti verranno creati solo gli utenti Microsoft Entra ID che soddisfano la condizione. Per Appartenenza a gruppo Microsoft 365 (ID oggetto del gruppo), inserire un ID oggetto di gruppo o più ID oggetto di gruppo separati da virgole.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Valore del campo';
$string['settings_usersynccreationrestriction_o365group'] = 'Appartenenza a gruppo Microsoft 365 (nome del gruppo)';
$string['settings_usersynccreationrestriction_o365groupid'] = 'Appartenenza a gruppo Microsoft 365 (ID oggetto del gruppo)';
$string['settings_usersynccreationrestriction_invalidgroupid'] = 'Impossibile trovare l\'ID oggetto del gruppo Microsoft 365 "{$a}". Verificare l\'ID e riprovare.';
$string['settings_usersynccreationrestriction_groupvalidationerror'] = 'Impossibile convalidare gli ID oggetto dei gruppi Microsoft 365. Verificare gli ID e la configurazione di Microsoft Graph, quindi riprovare.';
$string['settings_usersynccreationrestriction_regex'] = 'Il valore è un\'espressione regolare';
$string['settings_maintenance'] = 'Manutenzione';
$string['settings_maintenance_details'] = 'Sono disponibili varie operazioni di manutenzione per risolvere alcuni problemi comuni.';
$string['settings_maintenance_linktext'] = 'Visualizza strumenti di manutenzione';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'Multitenancy';
$string['acp_tenants_title_desc'] = 'Questa pagina consente di configurare l\'accesso multitenant a Moodle da Microsoft 365.';
$string['acp_tenants_add'] = 'Aggiungi nuovo tenant';
$string['acp_tenants_errornotsetup'] = 'Completare la procedura di configurazione del plugin prima di aggiungere altri tenant.';
$string['acp_tenants_hosttenant'] = 'Tenant host: {$a}';
$string['acp_tenants_intro'] = '<b>Come funziona la multitenancy:</b><br />La multitenancy consente a più tenant Microsoft Entra di accedere al sito Moodle. <br /><br />
    Ecco come configurarla:
    <ol>
        <li>Accedere a Moodle come utente amministratore del sito che non utilizza il plugin di autenticazione OpenID Connect.</li>
        <li>Assicurarsi che le impostazioni <b>Authorization Endpoint</b> e <b>Token Endpoint</b> del plugin di autenticazione OpenID Connect utilizzino i valori predefiniti non specifici per un tenant.</li>
        <li>Disabilitare il plugin di autenticazione OpenID Connect in Moodle. (Utilizzare <a href="{$a}/admin/settings.php?section=manageauths">la pagina di amministrazione dei plugin di autenticazione</a>.)</li>
        <li>Andare in Microsoft Entra ID e individuare l\'applicazione configurata per Moodle.</li>
        <li>Abilitare la multitenancy nell\'app Microsoft Entra ID e salvare le modifiche.</li>
        <li>Concedere all\'app almeno una delle seguenti autorizzazioni delegate di Graph: <b>Directory.Read.All</b>, <b>Domain.Read.All</b> o <b>Domain.ReadWrite.All</b>. Il consenso amministratore per l\'organizzazione non è richiesto.</li>
        <li>Se è già stato effettuato il login con l\'account Microsoft del tenant aggiuntivo, disconnettersi completamente e accedere di nuovo.</li>
        <li>Per ogni tenant da abilitare, fare clic su "Aggiungi nuovo tenant" e accedere con un account amministratore del tenant da abilitare.</li>
        <li>Dopo aver aggiunto tutti i tenant desiderati, riabilitare il plugin di autenticazione OpenID Connect in Moodle.</li>
        <li>Fatto! Per aggiungere altri tenant in futuro, è sufficiente fare clic sul pulsante "Aggiungi nuovo tenant" e accedere con un account amministratore di quel tenant.</li>
    </ol>
    <b>Nota importante:</b> l\'abilitazione della multitenancy nell\'app Microsoft Entra ID consente a tutti i tenant Microsoft Entra di accedere all\'applicazione. L\'aggiunta dei tenant qui consente di limitare l\'accesso a Moodle ai tenant configurati. <b>Se si rimuovono tutti i tenant da questo elenco prima di disabilitare la multitenancy nell\'app Microsoft Entra ID, oppure si abilita l\'autenticazione OpenID Connect in Moodle con un elenco vuoto, il sito Moodle sarà aperto a tutti i tenant Microsoft Entra.</b>';
$string['acp_tenants_none'] = 'Non è stato configurato alcun tenant. Se la multitenancy è stata abilitata nell\'app Microsoft Entra ID, il sito Moodle potrebbe essere aperto a tutti gli utenti Microsoft 365.';
$string['acp_tenants_revokeaccess'] = 'Revoca accesso';
$string['acp_tenants_tenant'] = 'Tenant';
$string['acp_tenants_actions'] = 'Azioni';
$string['acp_tenants_delete'] = 'Elimina';
$string['acp_tenantsadd_desc'] = 'Per concedere l\'accesso a un tenant aggiuntivo, fare clic sul pulsante qui sotto e accedere a Microsoft 365 con un account amministratore del nuovo tenant. Si tornerà all\'elenco dei tenant aggiuntivi, in cui sarà presente il nuovo tenant. Sarà quindi possibile utilizzare Moodle con il nuovo tenant.';
$string['acp_tenantsadd_linktext'] = 'Vai alla pagina di login di Microsoft 365';
$string['acp_tenants_legacy_tenants'] = 'Tenant legacy (azione richiesta)';
$string['acp_tenants_legacy_tenants_help'] = 'I tenant aggiuntivi elencati qui sotto, aggiunti in precedenza, potrebbero non funzionare con la nuova procedura di multitenancy e devono essere corretti.<br/>
Utilizzare il pulsante "Aggiungi nuovo tenant" qui sopra per aggiungerli di nuovo.';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = 'Controllo stato';
$string['healthcheck_fixlink'] = 'Fare clic qui per correggere.';
$string['healthcheck_ratelimit_title'] = 'Limitazione delle API';
$string['healthcheck_ratelimit_result_notice'] = 'È stata abilitata una leggera limitazione per gestire l\'aumento del carico sul sito Moodle. <br /><br />Tutte le funzionalità di Microsoft 365 sono operative; le richieste vengono solo leggermente distanziate per evitare interruzioni dei servizi Microsoft 365. Quando l\'attività di Moodle diminuirà, tutto tornerà alla normalità. <br />(Livello {$a->level} / avviata {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'È stata abilitata una limitazione maggiore per gestire un carico significativo sul sito Moodle. <br /><br />Tutte le funzionalità di Microsoft 365 sono ancora operative, ma il completamento delle richieste a Microsoft 365 potrebbe richiedere più tempo. Quando l\'attività del sito Moodle diminuirà, tutto tornerà alla normalità. <br />(Livello {$a->level} / avviata {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'Le funzionalità di limitazione della frequenza sono state disabilitate.';
$string['healthcheck_ratelimit_result_passed'] = 'Le chiamate API di Microsoft 365 vengono eseguite alla massima velocità.';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'Gestisci collegamenti utenti';
$string['acp_userconnections_column_muser'] = 'Utente Moodle';
$string['acp_userconnections_column_o365user'] = 'Utente Microsoft 365';
$string['acp_userconnections_column_status'] = 'Stato del collegamento';
$string['acp_userconnections_column_actions'] = 'Azioni';
$string['acp_userconnections_column_usinglogin'] = 'Utilizza il login';
$string['acp_userconnections_column_status_help'] = 'Lo stato del collegamento indica come un account Moodle è collegato a un account Microsoft 365 (Microsoft Entra ID).

* **Collegato** – L\'utente ha completato il collegamento accedendo a Moodle con il proprio account Microsoft 365, oppure un amministratore ha collegato attivamente l\'account. Funzionalità come la sincronizzazione del calendario e OneDrive sono operative per questo utente.
* **Abbinato** – Un amministratore (o lo strumento di abbinamento utenti in blocco) ha registrato a quale account Microsoft 365 appartiene questo utente Moodle, ma il collegamento non è ancora attivo. Viene completato la prima volta che l\'utente accede con Microsoft 365. Finché un utente è solo abbinato, non viene sincronizzato nulla.
* **Sincronizzato** – L\'account Moodle è stato creato da Microsoft Entra ID dall\'elaborazione di sincronizzazione utenti, ma l\'utente non ha ancora effettuato il login. L\'account si attiva al primo login.
* **Nessun collegamento** – L\'account Moodle non è collegato ad alcun account Microsoft 365.';
$string['acp_userconnections_column_actions_help'] = 'Le azioni disponibili per una riga dipendono dal relativo stato del collegamento.

* **Scollega** – Rimuove il collegamento tra l\'account Moodle e l\'account Microsoft 365. La persona mantiene il proprio account Moodle, ma non può più utilizzare le funzionalità di Microsoft 365 né accedere con Microsoft 365 finché non si collega di nuovo. Visualizzata per gli utenti collegati.
* **Risincronizza** – Esegue subito la sincronizzazione dei dati Microsoft 365 per questo utente (campi del profilo, foto, calendario e così via) anziché attendere l\'elaborazione pianificata, e mostra il risultato. Visualizzata per gli utenti collegati e sincronizzati.
* **Abbina** – Registra a quale account Microsoft 365 appartiene questo utente Moodle. Il collegamento non è attivo finché la persona non accede con Microsoft 365. Visualizzata per gli utenti senza collegamento.
* **Annulla abbinamento** – Rimuove un abbinamento non ancora completato. Visualizzata per gli utenti abbinati.';
$string['acp_userconnections_accountstatus_active'] = 'Attivo';
$string['acp_userconnections_accountstatus_suspended'] = 'Sospeso';
$string['acp_userconnections_connectionstatus_connected'] = 'Collegato';
$string['acp_userconnections_connectionstatus_matched'] = 'Abbinato';
$string['acp_userconnections_connectionstatus_noconnection'] = 'Nessun collegamento';
$string['acp_userconnections_connectionstatus_synced'] = 'Sincronizzato';
$string['acp_userconnections_filtering_accountstatus'] = 'Stato dell\'account';
$string['acp_userconnections_filtering_connectionstatus'] = 'Stato del collegamento';
$string['acp_userconnections_filtering_muserfullname'] = 'Nome completo dell\'utente Moodle';
$string['acp_userconnections_filtering_musername'] = 'Nome utente Moodle';
$string['acp_userconnections_filtering_o365username'] = 'Nome utente Microsoft 365';
$string['acp_userconnections_manualmatch_title'] = 'Abbinamento manuale utente';
$string['acp_userconnections_manualmatch_details'] = 'Questa pagina consente di abbinare un singolo utente Moodle a un singolo utente Microsoft 365.';
$string['acp_userconnections_manualmatch_musername'] = 'Utente Moodle';
$string['acp_userconnections_manualmatch_uselogin'] = 'Accedi con Microsoft 365';
$string['acp_userconnections_manualmatch_o365username'] = 'Nome utente Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'L\'utente Moodle è già collegato a un utente Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'L\'utente Moodle è già collegato a un utente Microsoft 365 (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'L\'utente Moodle è già abbinato a un utente Microsoft 365';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'L\'utente Microsoft 365 è già abbinato a un altro utente Moodle';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'L\'utente Microsoft 365 è già collegato a un altro utente Moodle';
$string['acp_userconnections_resync_nodata'] = 'Impossibile trovare informazioni Microsoft 365 memorizzate per questo utente.';
$string['acp_userconnections_resync_notfound'] = 'Nessun dato sincronizzato. L\'account "{$a->username}" è collegato all\'oggetto Microsoft Entra ID {$a->objectid}, ma tale oggetto non è stato trovato. Molto probabilmente l\'utente è stato eliminato o disabilitato in Microsoft 365, oppure l\'ID oggetto memorizzato non è più valido.';
$string['acp_userconnections_resync_nooutput'] = 'La risincronizzazione è terminata senza segnalare modifiche.';
$string['acp_userconnections_table_disconnect'] = 'Scollega';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'L\'utente Moodle "{$a}" verrà scollegato da Microsoft 365. Fare clic sul link qui sotto per procedere.';
$string['acp_userconnections_table_match'] = 'Abbina';
$string['acp_userconnections_table_resync'] = 'Risincronizza';
$string['acp_userconnections_table_unmatch'] = 'Annulla abbinamento';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'L\'abbinamento dell\'utente Moodle "{$a}" con Microsoft 365 verrà annullato. Fare clic sul link qui sotto per procedere.';

// Settings in the "Manage Team Connections" feature of the "Advanced" tab.
$string['acp_teamconnections'] = 'Gestisci collegamenti Team';
$string['acp_teamconnection'] = 'Gestisci collegamento Team';
$string['acp_teamconnections_actions'] = 'Azioni';
$string['acp_teamconnections_cache_last_updated'] = 'La cache dei Team è stata aggiornata l\'ultima volta il {$a->lastupdated}. Fare clic <a href="{$a->updateurl}">qui</a> per aggiornare la cache.';
$string['acp_teamconnections_cache_never_updated'] = 'La cache dei Team non è mai stata aggiornata. Fare clic <a href="{$a->updateurl}">qui</a> per aggiornarla.';
$string['acp_teamconnections_connected_team'] = 'Team collegato';
$string['acp_teamconnections_course_connected'] = 'Il corso è stato collegato correttamente al Team.';
$string['acp_teamconnections_course_disconnected'] = 'Il corso è stato scollegato dal Team.';
$string['acp_teamconnections_team_linked'] = 'Il corso è stato collegato al Team.';
$string['acp_teamconnections_current_connection'] = 'COLLEGAMENTO ATTUALE';
$string['acp_teamconnections_exception_course_not_exist'] = 'Il corso da collegare non esiste.';
$string['acp_teamconnections_exception_invalid_team_id'] = 'ID Team non valido';
$string['acp_teamconnections_exception_not_configured'] = 'Microsoft 365 non è completamente configurato.';
$string['acp_teamconnections_exception_team_already_connected'] = 'Il Team è già collegato a un altro corso';
$string['acp_teamconnections_form_connect_course'] = 'Gestisci collegamento Team per il corso {$a}';
$string['acp_teamconnections_form_sds_warning'] = 'NOTA: i Team creati da Student Data Sync (SDS) non possono essere collegati manualmente qui, poiché ciò entrerebbe in conflitto con la sincronizzazione SDS. Sono esclusi dai risultati della ricerca qui sotto.';
$string['acp_teamconnections_form_team'] = 'Seleziona Team';
$string['acp_teamconnections_form_team_noselection'] = 'Cerca un Team...';
$string['acp_teamconnections_no_teams_found'] = 'Nessun Team trovato per "{$a}"';
$string['acp_teamconnections_group_only'] = ' (Solo gruppo)';
$string['acp_teamconnections_team_missing'] = '(Team mancante)';
$string['acp_teamconnections_not_connected'] = 'Non collegato';
$string['acp_teamconnections_sync_disabled'] = 'Per gestire i collegamenti Team è necessario prima abilitare la sincronizzazione dei corsi.';
$string['acp_teamconnections_table_connect'] = 'Collega';
$string['acp_teamconnections_table_connect_to_different_team'] = 'Collega a un Team diverso';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'Impossibile creare il Team dal gruppo - nessun proprietario';
$string['acp_teamconnections_table_link_team'] = 'Link al Team "{$a}"';
$string['acp_teamconnections_table_missing_team'] = 'Il corso è collegato a un team inesistente. Il collegamento verrà rimosso alla successiva esecuzione dell\'elaborazione pianificata di sincronizzazione dei corsi.';
$string['acp_teamconnections_table_resync'] = 'Risincronizza';
$string['acp_teamconnections_table_update'] = 'Aggiorna';
$string['acp_teamconnections_teams_cache_updated'] = 'Cache dei Team aggiornata correttamente.';
$string['acp_teamconnections_no_owner'] = 'Aggiungere un proprietario per collegare a Teams.';
$string['acp_teamconnections_resync'] = 'Risincronizza proprietari / membri del Team';
$string['acp_teamconnections_resync_title'] = 'Risincronizza proprietari / membri del Team per il corso {$a}';
$string['acp_teamconnections_resync_desc'] = 'Confronta gli utenti iscritti al corso con i proprietari e i membri del gruppo/Team Microsoft 365 collegato e aggiunge chi manca. Scegliere se rimuovere anche gli utenti presenti nel Team ma non iscritti al corso Moodle.';
$string['acp_teamconnections_resync_keep'] = 'Risincronizza (mantieni i membri aggiuntivi del Team)';
$string['acp_teamconnections_resync_keep_desc'] = 'Gli utenti iscritti al corso Moodle che mancano nel Team verranno aggiunti. I proprietari / membri esistenti del Team non iscritti al corso Moodle non verranno modificati.';
$string['acp_teamconnections_resync_remove'] = 'Risincronizza e rimuovi i membri aggiuntivi del Team';
$string['acp_teamconnections_resync_remove_desc'] = 'Attenzione: qualsiasi proprietario o membro del Team non iscritto al corso Moodle verrà rimosso dal Team, anche se è stato aggiunto direttamente in Microsoft Teams.';
$string['acp_teamconnections_resync_completed'] = 'I proprietari / membri del Team sono stati risincronizzati.';
$string['acp_teamconnections_resync_failed'] = 'Impossibile risincronizzare i proprietari / membri del Team. Consultare l\'output qui sopra per i dettagli.';
$string['acp_teamconnections_last_resync'] = 'Ultima risincronizzazione: {$a}';
$string['acp_teamconnections_never_resynced'] = 'Mai risincronizzato';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'Abbinamento utenti';
$string['acp_usermatch_desc'] = 'Questo strumento consente di abbinare gli utenti Moodle agli utenti Microsoft 365. Si caricherà un file contenente gli utenti Moodle e gli utenti Microsoft 365 associati, e un\'elaborazione cron verificherà i dati e imposterà l\'abbinamento.';
$string['acp_usermatch_upload'] = 'Passo 1: caricare nuovi abbinamenti';
$string['acp_usermatch_upload_desc'] = 'Caricare un file di dati contenente i nomi utente Moodle e Microsoft 365 per abbinare gli utenti Moodle agli utenti Microsoft 365.<br />
<br />
Il file deve essere un semplice file CSV di testo con tre elementi per riga:
<ul>
<li>il nome utente Moodle,</li>
<li>il nome utente Microsoft 365,</li>
<li>1 o 0, dove 1 significa cambiare il metodo di autenticazione dell\'utente in OpenID Connect e 0 significa mantenere il metodo di autenticazione esistente e utilizzarlo come account collegato.</li>
</ul>
Non includere intestazioni o dati aggiuntivi.<br />
Ad esempio: <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'Il tipo {$a} non è supportato. Caricare un file CSV di testo semplice.';
$string['acp_usermatch_upload_err_data'] = 'La riga n. {$a} contiene dati non validi. Ogni riga del file CSV deve contenere almeno due elementi: il nome utente Moodle e il nome utente Microsoft 365.';
$string['acp_usermatch_upload_err_fileopen'] = 'Impossibile aprire il file per l\'elaborazione. I permessi della directory moodledata sono corretti?';
$string['acp_usermatch_upload_err_nofile'] = 'Non è stato ricevuto alcun file da aggiungere alla coda.';
$string['acp_usermatch_upload_submit'] = 'Aggiungi file di dati alla coda di abbinamento';
$string['acp_usermatch_matchqueue'] = 'Passo 2: coda di abbinamento';
$string['acp_usermatch_matchqueue_clearall'] = 'Cancella tutto';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Cancella errori';
$string['acp_usermatch_matchqueue_clearqueued'] = 'Cancella in coda';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Cancella completati';
$string['acp_usermatch_matchqueue_column_muser'] = 'Nome utente Moodle';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Nome utente Microsoft 365';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Stato';
$string['acp_usermatch_matchqueue_desc'] = 'Questa tabella mostra lo stato attuale dell\'operazione di abbinamento. A ogni esecuzione dell\'elaborazione pianificata <b>Elabora coda di abbinamento</b>, verrà elaborato un gruppo dei seguenti utenti.<br /><b>Nota:</b> questa pagina non si aggiorna dinamicamente, ricaricarla per visualizzare lo stato attuale.';
$string['acp_usermatch_matchqueue_empty'] = 'La coda di abbinamento è attualmente vuota. Caricare un file di dati utilizzando il selettore di file qui sopra per aggiungere utenti alla coda.';
$string['acp_usermatch_matchqueue_status_error'] = 'Errore: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'In coda';
$string['acp_usermatch_matchqueue_status_success'] = 'Completato';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'Strumenti di manutenzione';
$string['acp_maintenance_desc'] = 'Questi strumenti possono aiutare a risolvere alcuni problemi comuni.';
$string['acp_maintenance_warning'] = 'Attenzione: questi sono strumenti avanzati. Utilizzarli solo se si è consapevoli di ciò che si sta facendo.';
$string['acp_maintenance_resyncgroupusers'] = 'Risincronizza gli utenti nei gruppi Microsoft 365 dei corsi';
$string['acp_maintenance_resyncgroupusers_desc'] = 'Risincronizza l\'appartenenza degli utenti per tutti i gruppi Microsoft 365 creati per tutti i corsi Moodle. In questo modo nel gruppo Microsoft 365 saranno presenti tutti e soli gli utenti iscritti al corso Moodle. <br /><b>Nota:</b> gli eventuali utenti aggiuntivi aggiunti a un gruppo Microsoft 365 che non sono iscritti al corso Moodle associato verranno rimossi.';
$string['acp_maintenance_recreatedeletedgroups'] = 'Ricrea i gruppi Microsoft 365 eliminati';
$string['acp_maintenance_recreatedeletedgroups_desc'] = 'Verifica la presenza di gruppi Microsoft 365 collegati ai corsi Moodle che potrebbero essere stati eliminati manualmente e li ricrea.';
$string['acp_maintenance_debugdata'] = 'Genera pacchetto di dati di debug';
$string['acp_maintenance_debugdata_desc'] = 'Genera un pacchetto contenente varie informazioni sull\'ambiente Moodle e Microsoft 365 per aiutare gli sviluppatori a risolvere eventuali problemi. Se richiesto da uno sviluppatore, eseguire questo strumento e inviare il file scaricato. Nota: sebbene il pacchetto non contenga dati sensibili dei token, si chiede di non pubblicare questo file né di inviarlo a terzi non attendibili.';
$string['acp_maintenance_cleandeltatoken'] = 'Pulisci i token delta della sincronizzazione utenti';
$string['acp_maintenance_cleandeltatoken_desc'] = 'Se la sincronizzazione utenti non funziona completamente dopo aver aggiornato le relative impostazioni, la causa potrebbe essere un vecchio token di sincronizzazione delta. La pulizia del token forzerà una risincronizzazione completa alla successiva esecuzione della sincronizzazione utenti.';
$string['acp_maintenance_cleanapptokens'] = 'Pulisci i token dell\'applicazione';
$string['acp_maintenance_cleanapptokens_desc'] = 'Rimuove i token dell\'applicazione memorizzati, che il plugin utilizza per le chiamate alle API Microsoft non eseguite come utente. I nuovi token dell\'applicazione vengono richiesti automaticamente quando sono di nuovo necessari, e i risultati dell\'ultima verifica "Verifica configurazione" nella scheda Configurazione vengono cancellati. Se le chiamate effettuate con autorizzazioni applicazione non riescono con errori di autenticazione, ad esempio dopo una modifica delle autorizzazioni dell\'applicazione Microsoft Entra ID o delle relative credenziali, la pulizia dei token può essere utile. I token degli utenti non vengono modificati.';

// Settings in the "Resync users in Microsoft 365 groups for courses" feature in the "Maintenance Tools" feature of the
// "Advanced" tab.
$string['acp_maintenance_resyncgroupusers_course_output'] = 'Output della risincronizzazione';
$string['acp_maintenance_resyncgroupusers_no_course'] = 'Nessun corso collegato a Microsoft 365';
$string['acp_maintenance_coursesync_disabled'] = 'Questo strumento è disponibile solo quando la sincronizzazione dei corsi è abilitata. <a href="{$a}">Gestisci sincronizzazione corsi</a>.';

// Settings in the "Recreate deleted Microsoft 365 groups" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_recreatedeletedgroups_group_type'] = 'Tipo di oggetto Moodle';
$string['acp_maintenance_recreatedeletedgroups_group_type_course'] = 'Corso';
$string['acp_maintenance_recreatedeletedgroups_group_type_course_group'] = 'Gruppo del corso';
$string['acp_maintenance_recreatedeletedgroups_course'] = 'Corso';
$string['acp_maintenance_recreatedeletedgroups_course_group'] = 'Gruppo del corso';
$string['acp_maintenance_recreatedeletedgroups_status'] = 'Stato';
$string['acp_maintenance_recreatedeletedgroups_status_sync_disabled'] = 'La sincronizzazione del corso è disabilitata';
$string['acp_maintenance_recreatedeletedgroups_status_created_success'] = 'Il gruppo è stato ricreato';
$string['acp_maintenance_recreatedeletedgroups_status_created_fail'] = 'Ricreazione del gruppo non riuscita';
$string['acp_maintenance_recreatedeletedgroups_all_groups_exist'] = 'Tutti i gruppi collegati ai corsi Moodle e ai gruppi dei corsi esistono.';

// Settings in the "Cleanup User Sync Delta Tokens" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_cleandeltatoken_completed'] = 'Il token delta e lo skip token delta della sincronizzazione utenti sono stati puliti.';
$string['acp_maintenance_cleanapptokens_confirm'] = 'Pulire i token dell\'applicazione? Attualmente sono memorizzati {$a} token dell\'applicazione.';
$string['acp_maintenance_cleanapptokens_completed'] = 'I token dell\'applicazione e gli ultimi risultati di "Verifica configurazione" sono stati puliti.';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_course_reset_teams'] = 'Azioni su Team/gruppo all\'azzeramento del corso';
$string['settings_course_reset_teams_details'] = 'Azioni da eseguire su un Team o gruppo collegato a un corso quando il corso viene azzerato.';
$string['settings_course_reset_teams_option_do_nothing'] = 'Non fare nulla<br/>Il Team o gruppo resta collegato al corso. La disiscrizione degli utenti comporterà la rimozione della loro appartenenza al Team o gruppo.';
$string['settings_course_reset_teams_option_per_course'] = 'Consenti impostazioni per corso<br/>Richiede l\'aggiunta del blocco Microsoft al corso. Gli utenti con il privilegio di azzerare il corso possono scegliere nel blocco cosa fare durante l\'azzeramento del corso.';
$string['settings_course_reset_teams_option_force_archive'] = 'Scollega il corso dal Team o gruppo e creane uno nuovo<br/>Il Team o gruppo esistente collegato al corso verrà rinominato come configurato. Se è collegato un Team, questo verrà archiviato. Verrà creato un nuovo Team o gruppo e collegato al corso.';
$string['settings_course_reset_teams_option_archive_only'] = 'Scollega soltanto il corso dal Team o gruppo<br />Il Team o gruppo esistente collegato al corso verrà rinominato come configurato. Se è collegato un Team, questo verrà archiviato. Non verrà creato alcun nuovo Team o gruppo.';
$string['settings_reset_team_name_prefix'] = 'Prefisso del nome del Team all\'azzeramento';
$string['settings_reset_team_name_prefix_details'] = 'Quando si azzera un corso collegato a un Team, al nome del Team collegato esistente verrà aggiunto questo prefisso.';
$string['settings_reset_group_name_prefix'] = 'Prefisso del nome del gruppo all\'azzeramento';
$string['settings_reset_group_name_prefix_details'] = 'Quando si azzera un corso collegato a un gruppo, al nome del gruppo esistente verrà aggiunto questo prefisso.';
$string['settings_calsync_courseeventmode'] = 'Eventi Outlook per gli eventi del calendario del corso';
$string['settings_calsync_courseeventmode_details'] = 'Determina come un evento del calendario di un corso Moodle viene creato in Outlook per gli utenti che hanno sottoscritto il calendario del corso.
<ul>
<li><strong>Un unico evento condiviso con gli utenti del corso come partecipanti:</strong> viene creato un singolo evento nel calendario di Outlook dell\'utente che ha creato l\'evento Moodle (o nel calendario del gruppo Microsoft 365 del corso, se il corso è collegato a un gruppo) e gli utenti del corso vengono aggiunti come partecipanti.</li>
<li><strong>Un evento individuale per ogni utente:</strong> viene creato un evento separato direttamente nel calendario di Outlook di ciascun utente iscritto. Non esiste un evento condiviso né un elenco di partecipanti, e non viene aggiunto nulla al calendario del gruppo Microsoft 365.</li>
</ul>
La modifica di questa impostazione riguarda solo gli eventi sincronizzati successivamente; gli eventi già presenti in Outlook non vengono convertiti.';
$string['settings_calsync_courseeventmode_shared'] = 'Un unico evento condiviso con gli utenti del corso come partecipanti';
$string['settings_calsync_courseeventmode_individual'] = 'Un evento individuale per ogni utente';
$string['settings_debugmode'] = 'Registra messaggi di debug';
$string['settings_debugmode_details'] = 'Se abilitata, nel log di Moodle verranno registrate informazioni utili per identificare eventuali problemi. <a href="{$a}">Visualizza i messaggi di log registrati.</a>';
$string['settings_switchauthminupnsplit0'] = 'Lunghezza minima del nome utente non esatto per il passaggio a Microsoft 365';
$string['settings_switchauthminupnsplit0_details'] = 'Se si abilita l\'impostazione "Passa gli utenti abbinati all\'autenticazione Microsoft 365 (OpenID Connect)", questo valore imposta la lunghezza minima dei nomi utente senza tenant (la parte @example.onmicrosoft.com) che verranno convertiti. Ciò aiuta a evitare la conversione di account con nomi generici, come "admin", che non sono necessariamente gli stessi in Moodle e in Microsoft Entra ID. Impostare 0 per convertire gli utenti abbinati indipendentemente dalla lunghezza del nome utente. Gli utenti il cui metodo di autenticazione non è stato convertito a causa di questa impostazione vengono registrati come "Utente abbinato, ma il nome utente non corrisponde esattamente all\'UPN di Microsoft Entra ID e non soddisfa i requisiti di corrispondenza esatta per il passaggio a OIDC..." nell\'output dell\'elaborazione di sincronizzazione e vengono visualizzati come "Abbinato a utente esistente - In attesa di completamento" nella pagina Gestisci collegamenti utenti.';
$string['settings_customtheme'] = 'Tema personalizzato (avanzato)';
$string['settings_customtheme_desc'] = 'Il tema consigliato è "boost_o365teams". Tuttavia, è possibile selezionare un tema diverso se si dispone di un tema personalizzato adattato per l\'uso nella scheda di Teams.<br/>
Tenere presente che un tema personalizzato impostato a livello di corso o di categoria ha la precedenza su queste impostazioni, ovvero per impostazione predefinita un corso utilizzerà il tema del corso o della categoria nell\'app Moodle in Teams. Ciò può essere risolto aggiornando $CFG->themeorder in config.php a "array(\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\');".';

// Settings in the "SDS sync" tab.
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>Questa è una funzionalità in anteprima</b><br />Le funzionalità in anteprima potrebbero non funzionare come previsto o smettere di funzionare senza preavviso. Procedere con cautela.</div>';
$string['settings_sds_intro_desc'] = 'Microsoft School Data Sync ("SDS") semplifica la gestione delle classi in Microsoft 365 leggendo gli elenchi da un SIS esterno e creando classi e gruppi in Microsoft 365. <a href="https://sds.microsoft.com/" target="_blank">Ulteriori informazioni</a><br/>
<br/>
La funzionalità di sincronizzazione SDS è in grado di sincronizzare i dati degli elenchi da SDS a Moodle, incluse classi, docenti e studenti.<br/>
<br/>
Per utilizzare la funzionalità di sincronizzazione SDS, assicurarsi che l\'app Microsoft Entra ID utilizzata per l\'integrazione disponga delle autorizzazioni applicazione di Microsoft Graph <b>EduRoster.Read.All</b> e <b>Member.Read.Hidden</b>, che non vengono aggiunte automaticamente dalla configurazione predefinita. Anche per queste è necessario concedere il consenso amministratore.<br/>
<br/>
Per impostazione predefinita, il processo di sincronizzazione SDS viene eseguito quotidianamente nel cron di Moodle, alle 3:00 ora del server. Per modificare questa pianificazione, visitare la <a href="{$a}">pagina di gestione delle elaborazioni pianificate.</a><br/><br/>';
$string['settings_sds_coursecreation'] = 'Sincronizzazione da classe a corso';
$string['settings_sds_coursecreation_desc'] = 'Queste opzioni controllano la creazione di corsi Moodle in base alle classi delle scuole SDS.';
$string['settings_sds_coursecreation_enabled'] = 'Scuole sincronizzate';
$string['settings_sds_coursecreation_enabled_desc'] = 'Crea corsi per le classi di queste scuole.';
$string['settings_sds_teams_enabled'] = 'Le classi SDS hanno già dei Team?';
$string['settings_sds_teams_enabled_desc'] = 'Selezionare questa opzione se le classi SDS hanno già dei Team creati dalla configurazione SDS. Se selezionata, Moodle non tenterà di creare Team dai corsi Moodle creati dalle classi SDS, per evitare conflitti.';
$string['settings_sds_courseenrolsync'] = 'Sincronizzazione iscrizioni ai corsi';
$string['settings_sds_courseenrolsync_desc'] = 'Queste opzioni controllano la sincronizzazione delle iscrizioni ai corsi dalle classi delle scuole SDS.';
$string['settings_sds_enrolment_enabled'] = 'Sincronizza le iscrizioni da SDS a Moodle';
$string['settings_sds_enrolment_enabled_desc'] = 'Se abilitata, l\'elaborazione pianificata di sincronizzazione SDS iscriverà docenti e studenti delle classi SDS ai corrispondenti corsi Moodle e rimuoverà gli utenti che non fanno più parte della classe SDS. Richiede la configurazione di <b>Ruolo del docente della classe SDS in Moodle</b> e <b>Ruolo dello studente della classe SDS in Moodle</b>.';
$string['settings_sds_sync_enrolment_to_sds'] = 'Sincronizza le iscrizioni da Moodle a SDS';
$string['settings_sds_sync_enrolment_to_sds_desc'] = 'Se abilitata, le modifiche alle iscrizioni effettuate nei corsi Moodle collegati alle classi SDS verranno sincronizzate nelle classi SDS. Lo stato di proprietario / membro dell\'utente in SDS dipenderà dai privilegi "local/o365:teamowner" e "local/o365:teammember" nel contesto del corso.';
$string['settings_sds_suspend_enrolment'] = 'Sospendi le iscrizioni degli utenti anziché disiscriverli';
$string['settings_sds_suspend_enrolment_desc'] = 'Se questa opzione è abilitata, gli utenti rimossi da una classe SDS avranno l\'iscrizione sospesa nel corso Moodle collegato anziché essere completamente disiscritti. In questo modo vengono conservati i dati dell\'utente, come valutazioni, consegne e completamento delle attività. Quando gli utenti vengono aggiunti di nuovo alla classe SDS, la loro iscrizione verrà riattivata automaticamente.<br />
<b>Nota:</b> i docenti non vengono mai sospesi né disiscritti dalla sincronizzazione SDS. Questa impostazione riguarda solo gli studenti.';
$string['settings_sds_enable_course_sync'] = 'Abilita la sincronizzazione bidirezionale dei corsi';
$string['settings_sds_enable_course_sync_desc'] = 'Se abilitata, ogni corso Moodle creato da una classe SDS verrà collegato nel database al relativo gruppo Microsoft 365, attivando per quel corso l\'integrazione completa della sincronizzazione dei corsi di Microsoft 365 (Teams, file, calendario, ecc.). Se la classe SDS ha già un Team, viene creato anche un record di associazione con Teams.';
$string['settings_sds_course_field_mailnickname'] = 'Nickname di posta (mailNickname)';
$string['settings_sds_course_field_displayname'] = 'Nome visualizzato (displayName)';
$string['settings_sds_course_field_classcode'] = 'Codice della classe (classCode)';
$string['settings_sds_course_field_externalname'] = 'Nome esterno (externalName)';
$string['settings_sds_course_shortname_field'] = 'Origine del nome breve del corso';
$string['settings_sds_course_shortname_field_desc'] = 'La proprietà della classe SDS utilizzata come nome breve dei nuovi corsi Moodle. Moodle richiede che i nomi brevi dei corsi siano univoci. Se la proprietà scelta è vuota, oppure il suo valore è già utilizzato da un corso collegato a un\'altra classe SDS, viene utilizzato il nickname di posta. La modifica di questa impostazione non rinomina i corsi già creati.';
$string['settings_sds_course_fullname_field'] = 'Origine del nome completo del corso';
$string['settings_sds_course_fullname_field_desc'] = 'La proprietà della classe SDS utilizzata come nome completo dei nuovi corsi Moodle. Se la proprietà scelta è vuota, viene utilizzato il nome visualizzato. La modifica di questa impostazione non rinomina i corsi già creati.';
$string['settings_sds_categorize_by_subject'] = 'Organizza i corsi per materia';
$string['settings_sds_categorize_by_subject_desc'] = 'Se abilitata, i corsi verranno organizzati in categorie per materia all\'interno della categoria di ciascuna scuola. Il nome della materia viene ricavato dalle informazioni della classe in SDS. Se disabilitata, tutti i corsi vengono inseriti direttamente nella categoria della scuola.';
$string['settings_sds_ignore_past_courses'] = 'Ignora le classi scadute/passate';
$string['settings_sds_ignore_past_courses_desc'] = 'Se abilitata, le classi scadute o terminate verranno ignorate durante la sincronizzazione. Ciò include:<br />
<ul>
<li>Classi con il prefisso di scadenza configurato nel nome (predefinito: "Exp")</li>
<li>Classi con una data di fine nel passato</li>
</ul>
Ciò aiuta a mantenere ordinato il catalogo dei corsi evitando di creare corsi per classi vecchie o archiviate.';
$string['settings_sds_expired_course_prefix'] = 'Prefisso del nome delle classi scadute';
$string['settings_sds_expired_course_prefix_desc'] = 'I nomi delle classi che iniziano con questo prefisso verranno considerati scaduti e ignorati durante la sincronizzazione (se "Ignora le classi scadute/passate" è abilitata). Predefinito: "Exp"';
$string['settings_sds_cohortsync'] = 'Sincronizzazione gruppi globali';
$string['settings_sds_cohortsync_desc'] = 'Queste opzioni controllano la creazione e la sincronizzazione dei gruppi globali dalle classi SDS. I gruppi globali offrono un modo alternativo di raggruppare gli utenti, utilizzabile per l\'iscrizione a livello di sito o per altre funzionalità di Moodle.';
$string['settings_sds_create_cohorts'] = 'Crea gruppi globali dalle classi SDS';
$string['settings_sds_create_cohorts_desc'] = 'Se abilitata, verrà creato un gruppo globale per ogni classe SDS e l\'appartenenza verrà mantenuta sincronizzata con la classe SDS. I gruppi globali vengono creati nel contesto della categoria di corsi (categoria della scuola o della materia, a seconda delle impostazioni di organizzazione per categorie).<br />
<b>Nota:</b> i gruppi globali vengono creati in aggiunta ai corsi, non al loro posto. Ciò consente di utilizzare i gruppi globali per l\'iscrizione o il raggruppamento a livello di sito, mantenendo comunque i corsi sincronizzati con SDS.';
$string['settings_sds_cohort_include_teachers'] = 'Includi i docenti nei gruppi globali';
$string['settings_sds_cohort_include_teachers_desc'] = 'Se abilitata, i docenti della classe SDS verranno aggiunti al gruppo globale insieme agli studenti. Se disabilitata, ai gruppi globali verranno aggiunti solo gli studenti.';
$string['settings_sds_enrolment_teacher_role'] = 'Ruolo del docente della classe SDS in Moodle';
$string['settings_sds_enrolment_teacher_role_desc'] = 'Se "Sincronizza le iscrizioni da SDS a Moodle" è abilitata, i docenti della classe SDS verranno iscritti al corso Moodle collegato con questo ruolo.';
$string['settings_sds_enrolment_student_role'] = 'Ruolo dello studente della classe SDS in Moodle';
$string['settings_sds_enrolment_student_role_desc'] = 'Se "Sincronizza le iscrizioni da SDS a Moodle" è abilitata, gli studenti della classe SDS verranno iscritti al corso Moodle collegato con questo ruolo.';
$string['settings_sds_profilesync_header'] = 'Sincronizzazione del profilo utente';
$string['settings_sds_profilesync_header_desc'] = 'Ogni scuola SDS può memorizzare il profilo utente dei docenti e dei membri della scuola. Il campo è specifico della scuola, ovvero scuole diverse possono avere valori diversi nello stesso campo per lo stesso utente.<br/>
Se in questa sezione viene selezionata una scuola, i campi del profilo utente SDS possono essere configurati nella mappatura dei campi utente.
<ul>
<li>Nota: la sincronizzazione dei campi SDS avviene solo durante l\'esecuzione dell\'elaborazione pianificata "Sincronizza con SDS" e non durante l\'esecuzione dell\'elaborazione pianificata "Sincronizza utenti da Microsoft Entra ID", né quando un utente effettua il login.</li>
<li>Nota: esiste un problema noto in Microsoft Graph API, utilizzata da questa funzionalità, per cui alcuni campi del profilo scolastico di studenti e docenti non vengono restituiti e pertanto non sono disponibili per la sincronizzazione anche se configurati.</li>
</ul>
';
$string['settings_sds_profilesync_disabled'] = 'Disabilitata';
$string['settings_sds_profilesync'] = 'Sincronizza i dati del profilo dalla scuola';
$string['settings_sds_profilesync_desc'] = 'Selezionare la scuola SDS da cui Moodle sincronizza i dati del profilo specifici di SDS.';
$string['settings_sds_noschools'] = '<div class="alert alert-info">Non sono disponibili scuole in SDS.</div>';
$string['settings_sds_get_schools_error'] = '<div class="alert alert-info error">Impossibile ottenere le scuole SDS. Verificare che l\'app Microsoft Entra ID disponga delle autorizzazioni necessarie.</div>';
$string['settings_sds_school_disabled_action'] = 'Azione alla disattivazione della sincronizzazione della scuola';
$string['settings_sds_school_disabled_action_desc'] = 'Azione da eseguire sui corsi Moodle già collegati quando la sincronizzazione viene disabilitata per una scuola SDS.';
$string['settings_sds_school_disabled_action_keep_connected'] = 'Mantieni il corso Moodle collegato al Team';
$string['settings_sds_school_disabled_action_disconnect'] = 'Scollega il corso Moodle dal Team';
$string['settings_sds_school_unavailable'] = '{$a} (elenco delle scuole SDS attualmente non disponibile)';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner'] = 'L\'app Moodle per <a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teams</a> consente di accedere facilmente ai corsi Moodle e di collaborare su di essi in Teams.';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Configurare l\'app Moodle per Microsoft Teams</h4>';
$string['settings_moodlesettingssetup'] = 'Configura Moodle';
$string['settings_check_moodle_settings'] = 'Verifica impostazioni di Moodle';
$string['settings_moodlesetup_checking'] = 'Verifica in corso...';
$string['settings_notice_cookiesecureenabled'] = 'Solo cookie sicuri abilitato correttamente';
$string['settings_notice_cookiesecurealreadyenabled'] = 'Solo cookie sicuri era già abilitato';
$string['settings_notice_oidcenabled'] = 'OpenID Connect abilitato correttamente';
$string['settings_notice_oidcnotenabled'] = 'Impossibile abilitare OpenID Connect';
$string['settings_notice_oidcalreadyenabled'] = 'OpenID Connect era già abilitato';
$string['settings_notice_webservicesframealreadyenabled'] = 'I web service erano già abilitati e anche l\'incorporamento in frame è consentito';
$string['settings_notice_webservicesframeenabled'] = 'Web service abilitati correttamente; ora è consentito anche l\'incorporamento in frame';
$string['settings_notice_restenabled'] = 'Protocollo REST abilitato correttamente';
$string['settings_notice_restnotenabled'] = 'Impossibile abilitare il protocollo REST';
$string['settings_notice_restalreadyenabled'] = 'Il protocollo REST era già abilitato';
$string['settings_notice_o365serviceenabled'] = 'Web service di Microsoft 365 abilitati correttamente';
$string['settings_notice_o365servicealreadyenabled'] = 'I web service di Microsoft 365 erano già abilitati';
$string['settings_notice_createtokenallowed'] = 'Concesso il privilegio di creare un token per web service';
$string['settings_notice_createtokenalreadyallowed'] = 'Il privilegio di creare un token per web service era già stato concesso';
$string['settings_notice_createtokennotallowed'] = 'Si è verificato un problema durante la concessione del permesso di creare un token per web service';
$string['settings_notice_restusageallowed'] = 'Concesso il privilegio di utilizzare il protocollo REST';
$string['settings_notice_restusagealreadyallowed'] = 'Il privilegio di utilizzare il protocollo REST era già stato concesso';
$string['settings_notice_restusagenotallowed'] = 'Si è verificato un problema durante la concessione del permesso di utilizzare il protocollo REST';
$string['settings_moodlesettingssetup_details'] = 'Questa operazione assicura che:
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>Solo cookie sicuri sia abilitato.</li>
<li>OpenID Connect sia abilitato.</li>
<li>L\'incorporamento in frame sia abilitato.</li>
<li>I web service siano abilitati.</li>
<li>Il protocollo REST sia abilitato.</li>
<li>I web service di Microsoft 365 siano abilitati.</li>
<li>L\'utente autenticato abbia il privilegio di creare un token per web service.</li>
<li>L\'utente autenticato abbia il privilegio di utilizzare il protocollo REST.</li>
</ul>';
$string['settings_teams_moodle_app_external_id'] = 'ID app Microsoft per l\'app Moodle per Teams';
$string['settings_teams_moodle_app_external_id_desc'] = 'Deve essere impostato sul valore predefinito, a meno che nel tenant non siano necessarie più app Moodle per Teams per collegarsi a siti Moodle diversi.';
$string['settings_teams_moodle_app_short_name'] = 'Nome dell\'app Teams';
$string['settings_teams_moodle_app_short_name_desc'] = 'Può essere lasciato al valore predefinito, a meno che nel tenant non siano necessarie più app Moodle per Teams per collegarsi a siti Moodle diversi.';
$string['settings_download_teams_tab_app_manifest'] = 'Scarica file manifesto';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Salvare tutte le modifiche prima di scaricare il manifesto.';
$string['settings_publish_manifest_instruction'] = '<a href="https://learn.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Fare clic qui</a> per scoprire come pubblicare il file manifesto dell\'app Moodle scaricato per tutti gli utenti in Teams.';
$string['settings_teams_moodle_tab_name'] = 'Nome della scheda Moodle in Teams';
$string['settings_teams_moodle_tab_name_desc'] = 'Questo è il nome della scheda Moodle in Teams.';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'ID app Moodle';
$string['settings_moodle_app_id_desc'] = 'ID dell\'app Moodle caricata nei cataloghi delle app di Teams.<br/>
Se configurato, Moodle tenterà di creare una scheda Moodle con un collegamento al corso Moodle nel canale "Generale" del Team creato/collegato.';
$string['settings_moodle_app_id_desc_auto_id'] = '<br/>
Il valore rilevato automaticamente è "<span class="local_o365_settings_moodle_app_id">{$a}</span>".';
$string['settings_set_moodle_app_id_instruction'] = 'Per trovare manualmente l\'ID dell\'app Moodle, seguire questi passaggi:
<ol>
<li>Caricare il file manifesto scaricato nel catalogo delle app di Teams del tenant.</li>
<li>Nel catalogo delle app di Teams, individuare l\'app.</li>
<li>Fare clic sull\'icona delle opzioni dell\'app, situata nell\'angolo in alto a destra dell\'immagine dell\'app.</li>
<li>Fare clic su "Copia link".</li>
<li>Incollare il contenuto copiato in un editor di testo. Dovrebbe contenere un URL come https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
L\'ultima parte dell\'URL, ovvero <span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>, è l\'ID dell\'app.';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Abilita sincronizzazione del calendario di Outlook';
$string['calendar_user'] = 'Calendario personale (utente)';
$string['calendar_site'] = 'Calendario del sito';
$string['personal_calendar'] = 'Personale';
$string['calendar_event'] = 'Visualizza dettagli';
$string['eventcalendarsubscribed'] = 'L\'utente ha effettuato la sottoscrizione a un calendario';
$string['eventcalendarunsubscribed'] = 'L\'utente ha annullato la sottoscrizione a un calendario';

// Errors.
$string['erroracpauthoidcnotconfig'] = 'Impostare innanzitutto le credenziali dell\'applicazione in auth_oidc.';
$string['errorhttpclientbadtempfileloc'] = 'Impossibile aprire percorso temporaneo per memorizzare file.';
$string['errorhttpclientnofileinput'] = 'Nessun parametro file in httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Impossibile aggiornare token';
$string['errormfarequired'] = 'Microsoft richiede l\'autenticazione a più fattori prima che Moodle possa accedere all\'account Microsoft 365. Disconnettersi da Moodle, quindi accedere di nuovo con l\'account Microsoft 365 e completare la richiesta di autenticazione a più fattori.';
$string['errorgetapplicationtoken'] = 'Impossibile ottenere il token dell\'applicazione. Verificare la configurazione dell\'integrazione.';
$string['erroracpapcantgettenant'] = 'Impossibile ottenere il tenant Microsoft Entra, inserirlo manualmente.';
$string['erroracpcantgettenant'] = 'Impossibile ottenere l\'URL di OneDrive, inserirlo manualmente.';
$string['errorprovisioningapp'] = 'Impossibile effettuare il provisioning dell\'app Moodle nel Team.';
$string['erroro365apibadcall'] = 'Errore nella chiamata API.';
$string['erroro365apibadcall_message'] = 'Errore nella chiamata API: {$a}';
$string['erroro365apiinvalidtoken'] = 'Token non valido o scaduto.';
$string['erroro365apiinvalidmethod'] = 'httpmethod non valido passato ad apicall';
$string['erroro365apinotimplemented'] = 'Questo metodo deve essere sovrascritto.';
$string['erroro365apinotoken'] = 'Non era disponibile un token per la risorsa e l\'utente specificati e non è stato possibile ottenerne uno. Il token di aggiornamento dell\'utente è scaduto?';
$string['errorusermatched'] = 'L\'account Microsoft 365 "{$a->entraidupn}" è già abbinato all\'utente Moodle "{$a->username}". Per completare il collegamento, accedere prima come tale utente Moodle e seguire le istruzioni nel blocco Microsoft.';
$string['errornodirectaccess'] = 'L\'accesso diretto alla pagina non è consentito';
$string['eventapifail'] = 'Errore API';
$string['errorunabletofindgraphapi'] = 'Impossibile trovare Microsoft Graph API nell\'applicazione.';
$string['erroremptyjwt'] = 'È stato fornito un token JWT vuoto';
$string['errornocachedjwks'] = 'Nessun JWKS trovato nella cache';
$string['errorfetchjwks'] = 'Impossibile recuperare il JWKS da Microsoft';
$string['errorinvalidjwks'] = 'Formato JWKS non valido ricevuto da Microsoft';
$string['errorjwtvalidation'] = 'Convalida JWT non riuscita';
$string['errorjwtinvalidissuer'] = 'Convalida dell\'emittente JWT non riuscita';
$string['errorcannotgettoken'] = 'Impossibile ottenere il token dell\'app o di sistema.';
$string['errornotokenforsysmemuser'] = 'Nessun token disponibile per l\'utente di sistema. Eseguire il controllo stato di local_o365.';
$string['errornotoken'] = 'Nessun token disponibile per l\'utente n. {$a}';
$string['errornotokenforusersync'] = 'Nessun token disponibile per la sincronizzazione utenti.';
$string['errornoapifound'] = 'Nessuna API trovata con identificatore {$a}.';
$string['errornoresponsesavailable'] = 'Nessuna risposta disponibile.';
$string['erroro365badphoto'] = 'Foto del profilo non valida ricevuta da Microsoft 365.';
$string['erroro365nophoto'] = 'Questo utente non ha una foto in Microsoft 365.';
$string['errorcannotgetapiclient'] = 'Impossibile ottenere il client di Graph API.';
$string['errorfailedtogetsecrets'] = 'Impossibile ottenere i segreti.';
$string['errorfailedtosendnotification'] = 'Impossibile inviare l\'email di notifica a uno o più destinatari.';
$string['errorsecretexpiryrecipientundeliverable'] = 'Uno o più destinatari configurati per la notifica di scadenza del segreto non possono ricevere email (indirizzo non valido o dominio senza record MX/A): {$a}. Aggiornare i destinatari delle notifiche nelle impostazioni di OpenID Connect.';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Plugin locale Microsoft 365';
$string['privacy:metadata:local_o365_calidmap'] = 'Informazioni sui collegamenti tra gli eventi del calendario di Microsoft 365 e gli eventi del calendario di Moodle.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'L\'ID dell\'utente proprietario dell\'evento.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'Origine dell\'evento. Moodle o Microsoft 365.';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'L\'ID dell\'evento in Outlook.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'L\'ID dell\'evento in Moodle.';
$string['privacy:metadata:local_o365_calsub'] = 'Informazioni sulle sottoscrizioni di sincronizzazione tra i calendari di Moodle e di Outlook';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'L\'ID dell\'utente Moodle a cui si riferisce la sottoscrizione';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'Il tipo di calendario Moodle (site,course,user)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'L\'ID associato del calendario Moodle';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'L\'ID del calendario di Microsoft 365';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Se si tratta del calendario principale';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'Il comportamento di sincronizzazione (ad es. da Moodle a Outlook o da Outlook a Moodle)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'L\'ora di creazione della sottoscrizione.';
$string['privacy:metadata:local_o365_connections'] = 'Informazioni sui collegamenti tra utenti Moodle e Microsoft 365 non ancora confermati';
$string['privacy:metadata:local_o365_connections:muserid'] = 'L\'ID dell\'utente Moodle';
$string['privacy:metadata:local_o365_connections:entraidupn'] = 'L\'UPN dell\'utente Microsoft Entra ID.';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Se modificare il metodo di autenticazione dell\'utente al completamento.';
$string['privacy:metadata:local_o365_token'] = 'Informazioni sui token delle API di Microsoft 365 per gli utenti';
$string['privacy:metadata:local_o365_token:user_id'] = 'L\'ID dell\'utente Moodle';
$string['privacy:metadata:local_o365_token:scope'] = 'L\'ambito del token.';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'La risorsa del token.';
$string['privacy:metadata:local_o365_token:token'] = 'Il token.';
$string['privacy:metadata:local_o365_token:expiry'] = 'L\'ora di scadenza del token.';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'Il token di aggiornamento.';
$string['privacy:metadata:local_o365_objects'] = 'Informazioni sulla relazione tra oggetti Moodle e Microsoft 365';
$string['privacy:metadata:local_o365_objects:type'] = 'Il tipo di oggetto (gruppo, utente, corso, ecc.)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'Il sottotipo dell\'oggetto.';
$string['privacy:metadata:local_o365_objects:objectid'] = 'L\'ID oggetto di Microsoft 365';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'L\'ID dell\'oggetto in Moodle';
$string['privacy:metadata:local_o365_objects:o365name'] = 'Il nome leggibile dell\'oggetto in Microsoft 365';
$string['privacy:metadata:local_o365_objects:tenant'] = 'Il tenant a cui appartiene l\'oggetto (in ambienti multitenant)';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Eventuali metadati associati';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'L\'ora di creazione del record.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'L\'ora di modifica del record.';
$string['privacy:metadata:local_o365_appassign'] = 'Informazioni sulle assegnazioni dei ruoli app di Microsoft 365';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'L\'ID dell\'utente Moodle';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Se l\'utente è stato assegnato all\'app';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'L\'ID della foto dell\'utente in Microsoft 365';
$string['privacy:metadata:local_o365_appassign:photohash'] = 'Un hash SHA-256 dei byte della foto del profilo dell\'utente, memorizzato per rilevare le modifiche della foto senza scaricare di nuovo l\'immagine completa';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Quando la foto dell\'utente è stata aggiornata l\'ultima volta da Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue'] = 'Informazioni sull\'abbinamento tra utenti Moodle e utenti Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'Il nome utente dell\'utente Moodle.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'Il nome utente dell\'utente Microsoft 365.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Se passare l\'utente all\'autenticazione OpenID Connect quando viene effettuato l\'abbinamento';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Se il record è stato elaborato';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'Il messaggio di errore (se presente)';
$string['privacy:metadata:preference:suspendedtime'] = 'L\'ora in cui l\'utente è stato sospeso dalla sincronizzazione utenti, perché l\'account Microsoft Entra ID corrispondente è stato eliminato o disabilitato.';
$string['privacy:metadata:local_o365_calsettings'] = 'Informazioni sulle impostazioni di sincronizzazione del calendario';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'L\'ID dell\'utente Moodle';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'L\'ID del calendario in Microsoft 365';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'L\'ora di creazione del record.';
$string['privacy:metadata:preference:calsync_initialised'] = 'Se le scelte di sincronizzazione del calendario di Outlook dell\'utente sono state inizializzate, in modo che non vengano abilitate di nuovo automaticamente.';

// Page "Microsoft 365 / Moodle Control Panel" in the Microsoft block.
$string['ucp_title'] = 'Pannello di controllo di Microsoft 365 / Moodle';
$string['ucp_general_intro'] = 'Qui puoi gestire la connessione a Microsoft 365.';
$string['ucp_calsync_availcal'] = 'Calendari Moodle disponibili';
$string['ucp_calsync_title'] = 'Impostazioni di sincronizzazione del calendario di Outlook';
$string['ucp_calsync_desc'] = 'I calendari selezionati verranno sincronizzati da Moodle nel calendario di Outlook.';
$string['ucp_connection_options'] = 'Opzioni di connessione:';
$string['ucp_connection_desc'] = 'Qui puoi configurare come connetterti a Microsoft 365. Per utilizzare le funzionalità di Microsoft 365, devi essere connesso a un account Microsoft 365. Puoi farlo come descritto di seguito.';
$string['ucp_connection_entraidlogin'] = 'Utilizza le credenziali di Microsoft 365 per accedere a Moodle<br />';
$string['ucp_connection_entraidlogin_desc_authcode'] = 'Invece di inserire nome utente e password nella pagina di login di Moodle, nella pagina di login vedrai una sezione con la dicitura "Accedi con il tuo account su {$a}". Fai clic sul link e verrai reindirizzato a Microsoft 365 per accedere. Dopo aver effettuato correttamente il login a Microsoft 365, tornerai a Moodle e accederai al tuo account.';
$string['ucp_connection_entraidlogin_start'] = 'Inizia a utilizzare Microsoft 365 per accedere a Moodle.';
$string['ucp_connection_entraidlogin_stop'] = 'Smetti di utilizzare Microsoft 365 per accedere a Moodle.';
$string['ucp_connection_entraidlogin_active'] = 'Stai utilizzando l\'account Microsoft 365 "{$a}" per accedere a Moodle.';
$string['ucp_connection_linked'] = 'Collega gli account Moodle e Microsoft 365';
$string['ucp_connection_linked_desc'] = 'Collegando gli account Moodle e Microsoft 365 puoi utilizzare le funzionalità di Microsoft 365 per Moodle senza cambiare il modo in cui accedi a Moodle. <br />Facendo clic sul link sottostante verrai inviato a Microsoft 365 per effettuare un login una tantum, dopodiché tornerai qui. Potrai utilizzare tutte le funzionalità di Microsoft 365 senza apportare altre modifiche al tuo account Moodle: accederai a Moodle come hai sempre fatto.';
$string['ucp_connection_linked_active'] = 'Sei collegato all\'account Microsoft 365 "{$a}".';
$string['ucp_connection_linked_start'] = 'Collega il tuo account Moodle a un account Microsoft 365.';
$string['ucp_connection_linked_migrate'] = 'Passa all\'account collegato.';
$string['ucp_connection_linked_stop'] = 'Scollega il tuo account Moodle dall\'account Microsoft 365.';
$string['ucp_connection_disconnected'] = 'Non sei connesso a Microsoft 365.';
$string['ucp_features'] = 'Funzionalità di Microsoft 365';
$string['ucp_features_intro'] = 'Di seguito è disponibile un elenco delle funzionalità che è possibile utilizzare per migliorare Moodle con Microsoft 365.';
$string['ucp_features_intro_notconnected'] = ' Alcune di queste potrebbero non essere disponibili finché non si è connessi a Microsoft 365.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Per connetterti a Microsoft 365 devi contattare l\'amministratore del sito.';
$string['ucp_index_calendar_title'] = 'Impostazioni di sincronizzazione del calendario di Outlook';
$string['ucp_index_calendar_desc'] = 'Qui puoi impostare la sincronizzazione tra i calendari Moodle e Outlook. Puoi esportare eventi del calendario Moodle in Outlook e portare gli eventi Outlook in Moodle.';
$string['ucp_index_connection_title'] = 'Impostazioni di connessione a Microsoft 365';
$string['ucp_index_connection_desc'] = 'Configura come connetterti a Microsoft 365.';
$string['ucp_index_connectionstatus_title'] = 'Stato della connessione';
$string['ucp_index_connectionstatus_login'] = 'Fai clic qui per accedere.';
$string['ucp_index_connectionstatus_usinglogin'] = 'Attualmente stai utilizzando Microsoft 365 per accedere a Moodle.';
$string['ucp_index_connectionstatus_usinglinked'] = 'Sei collegato a un account Microsoft 365.';
$string['ucp_index_connectionstatus_manage'] = 'Gestisci connessione';
$string['ucp_index_connectionstatus_reconnect'] = 'Aggiorna connessione';
$string['ucp_index_connectionstatus_connected'] = 'Sei attualmente connesso a Microsoft 365';
$string['ucp_index_connectionstatus_matched'] = 'Sei stato abbinato all\'utente Microsoft 365 <small>"{$a}"</small>. Per completare questa connessione, fai clic sul link sottostante e accedi a Microsoft 365.';
$string['ucp_index_connectionstatus_notconnected'] = 'Non sei attualmente connesso a Microsoft 365';
$string['ucp_notconnected'] = 'Connettiti a Microsoft 365 prima di visitare questa pagina.';
$string['ucp_status_enabled'] = 'Attivo';
$string['ucp_status_disabled'] = 'Non connesso';
$string['ucp_syncwith_title'] = 'Nome del calendario di Outlook con cui sincronizzare:';
$string['ucp_syncdir_title'] = 'Comportamento di sincronizzazione:';
$string['ucp_syncdir_out'] = 'Da Moodle a Outlook';
$string['ucp_syncdir_in'] = 'Da Outlook a Moodle';
$string['ucp_syncdir_both'] = 'Aggiorna sia Outlook sia Moodle';
$string['ucp_o365accountconnected'] = 'Questo account Microsoft 365 è già connesso a un altro account Moodle.';

// Tasks.
$string['task_calendarsyncin'] = 'Sincronizza gli eventi di Microsoft 365 in Moodle';
$string['task_coursesync'] = 'Sincronizza i corsi Moodle con Microsoft Teams';
$string['task_coursemembershipsync'] = 'Sincronizza proprietari e membri di Microsoft Teams nei corsi Moodle';
$string['task_groupmembershipsync'] = 'Sincronizza proprietari e membri dei corsi Moodle nei gruppi Microsoft 365';
$string['task_sds_sync'] = 'Sincronizza con SDS';
$string['task_syncusers'] = 'Sincronizza utenti da Microsoft Entra ID';
$string['task_syncusersphotostimezones'] = 'Sincronizza foto e fusi orari degli utenti da Microsoft Entra ID';
$string['task_calsyncautosubscribe'] = 'Abilita automaticamente la sincronizzazione del calendario per gli utenti collegati';
$string['task_groupchannelsync'] = 'Crea canali Teams per i gruppi Moodle e sincronizza i relativi membri';
$string['task_groupchannelsyncgroup'] = 'Crea il canale Teams di un gruppo Moodle e sincronizza i relativi membri';
$string['task_userenabledstatussync'] = 'Sospendi/riattiva/elimina utenti in base allo stato di Microsoft Entra ID';
$string['task_processmatchqueue'] = 'Elabora coda di abbinamento';
$string['task_notifysecretexpiry'] = 'Notifica all\'amministratore del sito la scadenza del segreto dell\'app Microsoft Entra ID';
$string['task_checkinvalidconfiglog'] = 'Verifica e pulisci i record non validi del log di configurazione';
$string['task_usergroupmembershipsync'] = 'Sincronizza l\'appartenenza degli utenti ai gruppi dei corsi in Microsoft 365';
$string['task_processmatchqueue_err_museralreadymatched'] = 'L\'utente Moodle è già abbinato a un utente Microsoft 365.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'L\'utente Moodle è già connesso a Microsoft 365.';
$string['task_processmatchqueue_err_nomuser'] = 'Nessun utente Moodle trovato con questo nome utente.';
$string['task_processmatchqueue_err_noo365user'] = 'Nessun utente Microsoft 365 trovato con questo nome utente.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'L\'utente Microsoft 365 è già abbinato a un utente Moodle.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'L\'utente Microsoft 365 è già connesso a un utente Moodle.';

// Capabilities.
$string['o365:manageconnectionlink'] = 'Gestisci collegamento della connessione';
$string['o365:manageconnectionunlink'] = 'Gestisci scollegamento della connessione';
$string['o365:managecoursesync'] = 'Abilita o disabilita la sincronizzazione Teams per i corsi tramite web service';
$string['o365:viewgroups'] = 'Visualizza i link ai servizi Microsoft 365 nel blocco Microsoft nei corsi con sincronizzazione abilitata';
$string['o365:managegroups'] = 'Visualizza i link ai servizi Microsoft 365 e le opzioni di gestione nel blocco Microsoft nei corsi con sincronizzazione abilitata';
$string['o365:teammember'] = 'Membro del Team';
$string['o365:teamowner'] = 'Proprietario del Team';

// Cache Stores.
$string['cachedef_groups'] = 'Memorizza i dati dei gruppi Microsoft 365';
$string['cachedef_jwks'] = 'Memorizza le chiavi JWKS di Microsoft';

// Web service errors.
$string['webservices_error_assignnotfound'] = 'Impossibile trovare il record del compito del modulo ricevuto.';
$string['webservices_error_invalidassignment'] = 'L\'ID del compito ricevuto non può essere utilizzato con questa funzione del web service.';
$string['webservices_error_modulenotfound'] = 'Impossibile trovare l\'ID del modulo ricevuto.';
$string['webservices_error_sectionnotfound'] = 'Impossibile trovare la sezione del corso.';
$string['webservices_error_couldnotsavegrade'] = 'Impossibile salvare la valutazione.';

// User sync task help text.
$string['help_user_create'] = 'Guida a Crea account';
$string['help_user_create_help'] = 'Crea in Moodle gli utenti corrispondenti a ciascun utente del Microsoft Entra ID collegato. Verranno creati account solo per gli utenti che non hanno già un account Moodle. I nuovi account verranno configurati con il metodo di autenticazione OpenID Connect utilizzando il profilo Microsoft Entra ID e potranno utilizzare tutte le funzionalità di integrazione Microsoft 365/Moodle.';
$string['help_user_update'] = 'Guida a Aggiorna tutti gli account';
$string['help_user_update_help'] = 'Aggiorna in Moodle tutti gli utenti a partire da ciascun utente del Microsoft Entra ID collegato.';
$string['help_user_suspend'] = 'Guida a Sospendi account';
$string['help_user_suspend_help'] = 'Sospende gli utenti in Moodle se sono contrassegnati come eliminati in Microsoft Entra ID.';
$string['help_user_delete'] = 'Guida a Elimina account';
$string['help_user_delete_help'] = 'Elimina gli utenti da Moodle se sono contrassegnati come eliminati in Microsoft Entra ID. Funziona solo se l\'opzione di sospensione degli utenti è abilitata. L\'account Moodle verrà eliminato e tutte le informazioni associate all\'utente verranno rimosse da Moodle. Attenzione! Nota: per impostazione predefinita, l\'eliminazione avviene 30 giorni dopo l\'eliminazione dell\'account in Microsoft Entra ID, a causa del periodo di conservazione dell\'eliminazione temporanea (soft-delete) di Entra ID (in tale periodo gli account possono essere ripristinati). È possibile configurare un ritardo più lungo tra sospensione ed eliminazione con l\'impostazione "Ritardo prima dell\'eliminazione degli utenti sospesi".';
$string['help_user_reenable'] = 'Guida a Riattiva account';
$string['help_user_reenable_help'] = 'Riattiva gli account Moodle sospesi se vengono restituiti da Microsoft Entra ID e sono autorizzati ad accedere. Gli account a cui è bloccato l\'accesso (disabilitati) in Microsoft Entra ID resteranno sospesi.';
$string['help_user_disabledsyncsuspend'] = 'Guida a Sospendi account alla disabilitazione';
$string['help_user_disabledsyncsuspend_help'] = 'Sospende gli utenti in Moodle se ai loro account collegati in Microsoft Entra ID è impedito l\'accesso (disabilitati), senza modificare la riattivazione automatica nel caso in cui l\'account Microsoft Entra ID venga abilitato di nuovo. Utilizzare l\'opzione "Riattiva gli account in Moodle quando vengono riabilitati in Microsoft Entra ID" qui sotto per controllarla separatamente.';
$string['help_user_groupsyncsuspend'] = 'Guida a Sospendi account non presenti nel gruppo di sincronizzazione';
$string['help_user_groupsyncsuspend_help'] = 'Sospende gli utenti in Moodle se sono ancora attivi in Microsoft Entra ID ma non sono membri né proprietari del gruppo configurato nell\'impostazione "Filtro di gruppo per la sincronizzazione utenti". La verifica riguarda solo l\'appartenenza attuale: vengono sospesi anche gli utenti sincronizzati esistenti che non sono mai stati nel gruppo, non solo quelli che lo hanno lasciato, pertanto verificare il gruppo prima di abilitare questa opzione. Questa opzione è disponibile solo quando è configurato un filtro di gruppo per la sincronizzazione utenti. Per evitare sospensioni di massa, non viene sospeso nessun utente se il gruppo risulta vuoto o se non è possibile recuperarne i membri. Gli utenti sospesi non vengono riattivati finché non sono nel gruppo.';
$string['help_user_disabledsyncreenable'] = 'Guida a Riattiva account all\'abilitazione';
$string['help_user_disabledsyncreenable_help'] = 'Riattiva gli utenti sospesi in Moodle se ai loro account collegati in Microsoft Entra ID è di nuovo consentito l\'accesso (abilitati).';
$string['help_user_suspendnolink'] = 'Guida a Sospendi account senza collegamento Microsoft';
$string['help_user_suspendnolink_help'] = 'Normalmente le opzioni di sospensione/disabilitazione precedenti agiscono solo sugli account che hanno un record di oggetto Microsoft Entra ID memorizzato (creato quando l\'account è stato sincronizzato o collegato). Alcuni account OpenID Connect non hanno tale record, ad esempio perché si sono collegati prima della configurazione di Microsoft Graph API, oppure perché il record è stato rimosso da uno scollegamento o da un\'azione "cancella utenti abbinati". Questa opzione fa sì che l\'operazione di verifica dello stato controlli anche tali account, confrontando il nome utente Moodle con il valore del claim del nome utente di collegamento configurato in Entra ID.

Gli account abbinati che non sono presenti in Entra ID, o che lì sono disabilitati, vengono <strong>solo sospesi</strong>: non vengono mai eliminati (senza un ID oggetto memorizzato non è possibile verificare il periodo di conservazione dell\'eliminazione temporanea di Entra ID) e non vengono mai riattivati automaticamente. Gli account guest vengono ignorati.

Questa opzione funziona solo quando il claim del nome utente di collegamento di OpenID Connect è impostato su un campo specifico che può essere cercato in Entra ID: "upn", "oid", "email" o "samaccountname". Con "auto" (in cui il claim effettivo viene scelto a ogni login e può differire tra gli utenti) o con qualsiasi altro claim, il nome utente Moodle non può essere abbinato in modo affidabile a un singolo account e questa opzione non ha alcun effetto.

Dopo la prima esecuzione, controllare gli utenti sospesi: un account passato manualmente a questo metodo di autenticazione che non è mai stato un vero utente Entra ID verrà sospeso da questa opzione.';
$string['help_user_match'] = 'Guida a Abbina account';
$string['help_user_match_help'] = 'Esamina ogni utente del Microsoft Entra ID collegato e tenta di abbinarlo a un utente di Moodle. L\'abbinamento si basa sull\'UPN di Microsoft Entra ID e sul nome utente di Moodle. Il confronto non distingue maiuscole e minuscole e ignora la parte di dominio dell\'UPN di Microsoft Entra ID. Ad esempio, "BoB.SmiTh" in Moodle corrisponde a "bob.smith@example.onmicrosoft.com". Gli account Moodle e Microsoft Entra ID degli utenti abbinati verranno collegati e gli utenti potranno utilizzare tutte le funzionalità di integrazione Microsoft 365 e Moodle. Il metodo di autenticazione dell\'utente non cambierà a meno che non sia abilitata l\'impostazione indicata sotto.';
$string['help_user_matchswitchauth'] = 'Guida a Passa gli account abbinati';
$string['help_user_matchswitchauth_help'] = 'Richiede che l\'impostazione "Abbina gli utenti Moodle preesistenti" sopra indicata sia abilitata. Quando un utente viene abbinato, l\'abilitazione di questa impostazione ne converte il metodo di autenticazione in OpenID Connect. L\'utente potrà quindi accedere a Moodle con le proprie credenziali di Microsoft 365. Nota: assicurarsi che il plugin di autenticazione OpenID Connect sia abilitato se si desidera utilizzare questa impostazione. Attenzione: se un nome utente Moodle corrisponde solo alla parte dell\'UPN di Microsoft Entra ID che precede la "@" (anziché all\'UPN completo), l\'impostazione avanzata "Lunghezza minima del nome utente non esatto per il passaggio a Microsoft 365" può impedire la conversione del metodo di autenticazione per gli utenti con nomi utente brevi.';
$string['help_user_appassign'] = 'Guida a Assegna utenti all\'applicazione';
$string['help_user_appassign_help'] = 'Fa sì che tutti gli account Microsoft Entra ID con account Moodle corrispondenti vengano assegnati all\'app Microsoft Entra ID creata per questa installazione di Moodle, se non già assegnati.';
$string['help_user_photosync'] = 'Guida a Sincronizza le foto del profilo Microsoft 365 (cron)';
$string['help_user_photosync_help'] = 'Fa sì che le foto del profilo Moodle di tutti gli utenti vengano sincronizzate con le rispettive foto del profilo Microsoft 365.';
$string['help_user_photosynconlogin'] = 'Guida a Sincronizza le foto del profilo Microsoft 365 (login)';
$string['help_user_photosynconlogin_help'] = 'Fa sì che la foto del profilo Moodle di un utente venga sincronizzata con la sua foto del profilo Microsoft 365 quando l\'utente accede. Nota: ciò richiede che l\'utente visiti una pagina contenente il blocco Microsoft in Moodle.';
$string['help_user_nodelta'] = 'Guida a Esegui una sincronizzazione completa';
$string['help_user_nodelta_help'] = 'Per impostazione predefinita, la sincronizzazione utenti sincronizza solo le modifiche apportate in Microsoft Entra ID dall\'ultima esecuzione. Selezionando questa opzione si forza una sincronizzazione completa degli utenti a ogni esecuzione.';
$string['help_user_emailsync'] = 'Guida a Sincronizza i nomi utente di Microsoft Entra ID con gli indirizzi email di Moodle';
$string['help_user_emailsync_help'] = 'L\'abilitazione di questa opzione abbina i nomi utente di Microsoft Entra ID agli indirizzi email di Moodle, anziché ai nomi utente di Moodle come avviene per impostazione predefinita.';
$string['help_user_tzsync'] = 'Guida a Sincronizza il fuso orario di Outlook (cron)';
$string['help_user_tzsync_help'] = 'Fa sì che il fuso orario Moodle di tutti gli utenti venga sincronizzato con la preferenza di fuso orario di Outlook.';
$string['help_user_tzsynconlogin'] = 'Guida a Sincronizza il fuso orario di Outlook (login)';
$string['help_user_tzsynconlogin_help'] = 'Fa sì che il fuso orario Moodle di un utente venga sincronizzato con la sua preferenza di fuso orario di Outlook. Nota: ciò richiede che l\'utente visiti una pagina contenente il blocco Microsoft in Moodle.';
$string['help_user_guestsync'] = 'Guida a Sincronizza gli utenti guest';
$string['help_user_guestsync_help'] = 'Se abilitata, gli utenti guest di Microsoft Entra ID verranno sincronizzati in Moodle dall\'elaborazione di sincronizzazione utenti.';

// Cohort sync feature.
$string['cohortsync_title'] = 'Sincronizzazione gruppi globali';
$string['cohortsync_taskname'] = 'Sincronizzazione gruppi globali';
$string['cohortsync_mappingadded'] = 'Nuovo collegamento aggiunto correttamente';
$string['cohortsync_mappingdeleted'] = 'Collegamento eliminato correttamente';
$string['cohortsync_addmapping'] = 'Aggiungi collegamento';
$string['cohortsync_deletemapping'] = 'Elimina collegamento';
$string['cohortsync_desc'] = 'Questa pagina consente la sincronizzazione unidirezionale dai gruppi Microsoft 365 ai gruppi globali Moodle nel contesto di sistema. L\'aggiunta di un nuovo collegamento avvia il processo di sincronizzazione: gli utenti del gruppo Microsoft 365 selezionato che sono connessi a Microsoft verranno aggiunti al gruppo globale Moodle selezionato.';
$string['cohortsync_tabledesc'] = 'Collegamenti attuali tra i gruppi Microsoft 365 e i gruppi globali Moodle';
$string['cohortsync_typetosearch'] = 'Digitare per cercare un gruppo Microsoft 365';
$string['cohortsync_typetosearch_cohort'] = 'Digitare per cercare un gruppo globale Moodle';
$string['cohortsync_emptymatchings'] = 'Nessun collegamento trovato';
$string['cohortsync_select_cohort'] = 'Gruppo globale Moodle';
$string['cohortsync_select_group'] = 'Gruppo Microsoft 365';
$string['cohortsync_tablehead_group'] = 'Gruppo Microsoft 365';
$string['cohortsync_tablehead_cohort'] = 'Gruppo globale Moodle';
$string['cohortsync_tablehead_actions'] = 'Azioni';
$string['cohortsync_search'] = 'Cerca';
$string['cohortsync_load_more'] = 'Carica altri...';
$string['cohortsync_no_groups_found'] = 'Nessun gruppo Microsoft 365 trovato per "{$a}"';
$string['cohortsync_no_cohorts_found'] = 'Nessun gruppo globale Moodle trovato per "{$a}"';
$string['cohortsync_error_no_group'] = 'Selezionare un gruppo Microsoft 365.';
$string['cohortsync_error_no_cohort'] = 'Selezionare un gruppo globale Moodle.';
$string['cohortsync_mappingfailed'] = 'Errore durante l\'aggiunta del collegamento tra gruppo globale e gruppo. Possibili cause: il gruppo o il gruppo globale non esistono, il gruppo è già collegato a un altro gruppo globale, il gruppo è già collegato a questo gruppo globale.';
$string['cohortsync_connectionnotfound'] = 'Richiesta non valida: collegamento non trovato.';
$string['cohortsync_connectionnotcohortsync'] = 'Richiesta non valida: tipo di collegamento non corrispondente.';
$string['cohortsync_unifiedapierror'] = 'Errore durante il recupero dell\'elenco dei gruppi da Microsoft.';

// Course request.
$string['courserequest_teams'] = 'Team Microsoft';
$string['courserequest_teams_help'] = 'Selezionare il Team Microsoft che verrà collegato al corso. I proprietari e i membri esistenti del Team verranno iscritti al corso creato una volta approvata la richiesta di corso.';
$string['courserequest_emptyteams'] = 'Nessun Microsoft Teams disponibile';
$string['courserequest_title'] = 'Richiedi corso da Teams';
$string['courserequest_updatecourserequeststatus_taskname'] = 'Aggiorna lo stato della richiesta di corso';
$string['courserequest_customrequestnote'] = '
| Questa richiesta è stata effettuata dalla pagina di richiesta di corsi di Microsoft Teams e, all\'approvazione, verrà collegata al Team: "{$a->name}" con URL {$a->url}.';
$string['courserequest_graphapi_disabled'] = 'La connessione a Microsoft Teams non è disponibile. Contattare l\'amministratore del sito.';
$string['courserequest_invalid_team'] = 'Team non valido utilizzato nella richiesta di corso.';
$string['courserequest_duplicate'] = 'Esiste già una richiesta di corso in sospeso o approvata dallo stesso Team.';

// Teams page.
$string['teams_no_course'] = 'Non hai alcun corso da aggiungere.';
$string['tab_name'] = 'Nome della scheda';
$string['sso_login'] = 'Accedi a Microsoft 365';
$string['other_login'] = 'Accedi manualmente';
$string['course_selector_label'] = 'Seleziona un corso esistente';

// Notifications to site admin about Microsoft Entra ID app secret.
$string['notification_subject_secret_expired'] = 'Azione richiesta: il segreto dell\'app Microsoft Entra ID è scaduto';
$string['notification_content_secret_expired'] = 'Gentile amministratore del sito,

Il segreto dell\'app Microsoft Entra ID utilizzato nell\'integrazione tra Moodle e Microsoft 365 è scaduto.
Per ripristinare l\'integrazione, creare un nuovo segreto in Microsoft Entra ID e aggiornarlo nella configurazione dell\'integrazione.';
$string['notification_subject_secret_almost_expired'] = 'Azione richiesta: il segreto dell\'app Microsoft Entra ID sta per scadere';
$string['notification_content_secret_almost_expired'] = 'Gentile amministratore del sito,

Il segreto dell\'app Microsoft Entra ID utilizzato nell\'integrazione tra Moodle e Microsoft 365 scadrà tra {$a}.
Per evitare interruzioni dell\'integrazione, creare un nuovo segreto in Microsoft Entra ID e aggiornarlo nella configurazione dell\'integrazione.';
$string['notification_days_less_than_one_day'] = 'meno di 1 giorno';
$string['notification_days_one_day'] = '1 giorno';
$string['notification_days_days'] = '{$a} giorni';
$string['notification_subject_invalid_secret'] = 'Azione richiesta: rilevato segreto dell\'app Microsoft Entra ID non valido';
$string['notification_content_invalid_secret'] = 'Gentile amministratore del sito,

Il segreto dell\'app Microsoft Entra ID utilizzato nell\'integrazione tra Moodle e Microsoft 365 sembra non valido. Ciò può essere dovuto al fatto che il segreto è scaduto o è stato eliminato.
Verificare il segreto per assicurarsi che l\'integrazione funzioni come previsto.';

// Async operations.
$string['teamsasyncfailed'] = 'Operazione asincrona di creazione del Team non riuscita: {$a}';
$string['unknownasyncstate'] = 'Stato dell\'operazione asincrona sconosciuto: {$a}';

// Template ID validation.
$string['error_template_id_empty'] = 'L\'ID del modello non può essere vuoto.';
$string['error_not_connected'] = 'Non connesso a Microsoft 365. Configurare prima l\'integrazione con Microsoft 365.';
$string['error_graph_client_not_available'] = 'Impossibile connettersi a Microsoft Graph API. Verificare la configurazione dell\'integrazione con Microsoft 365.';
$string['success_template_id_valid'] = '✓ L\'ID modello "{$a}" è valido e accessibile.';
$string['error_template_id_not_found'] = '✗ L\'ID modello "{$a}" non è stato trovato. Verificare l\'ID del modello nell\'interfaccia di amministrazione di Teams.';
$string['error_template_validation_failed'] = '✗ Convalida del modello non riuscita: {$a}';
$string['error_template_validation_error'] = '✗ Si è verificato un errore durante la convalida del modello. Riprovare o contattare l\'amministratore.';

// Role sync feature.
$string['settings_header_rolesync'] = 'Sincronizzazione dei ruoli';
$string['task_rolesync'] = 'Sincronizza i ruoli di sistema dai gruppi Microsoft 365';
$string['settings_rolesync_intro'] = 'Assegna automaticamente i ruoli di sistema di Moodle (ad esempio Manager o Creatore di corsi) agli utenti in base all\'appartenenza ai gruppi Microsoft 365. Questa funzionalità rimuove solo i ruoli da essa assegnati; i ruoli assegnati manualmente non vengono mai modificati. Per assegnare i ruoli da un claim del token ID OIDC, il che funziona con qualsiasi provider di identità, usare la <a href="{$a}">pagina Sincronizzazione dei ruoli del plugin di autenticazione OpenID Connect</a>.';
$string['settings_rolesync_groupheading'] = 'Sincronizzazione dei ruoli dai gruppi Microsoft 365';
$string['settings_rolesync_groupheading_desc'] = 'Viene eseguita dall\'attività pianificata "Sincronizza i ruoli di sistema dai gruppi Microsoft 365" (ogni 15 minuti per impostazione predefinita), indipendentemente dalla sincronizzazione degli utenti. Non viene eseguita all\'accesso, quindi una modifica dell\'appartenenza al gruppo ha effetto alla successiva esecuzione dell\'attività. Vengono elaborati solo gli utenti già connessi a Microsoft 365.';
$string['settings_rolesync_groupmap'] = 'Mappatura gruppo-ruolo';
$string['settings_rolesync_groupmap_details'] = 'Una mappatura per riga, nel formato <code>ID oggetto del gruppo=nome breve del ruolo</code>. Più ruoli possono essere separati da virgole, ad esempio <code>550e8400-e29b-41d4-a716-446655440000=manager,coursecreator</code>. I membri e i proprietari del gruppo, inclusi i membri dei gruppi nidificati, ricevono i ruoli nel contesto di sistema. Sono interessati solo gli utenti connessi a Microsoft 365. Le righe che iniziano con # vengono ignorate.';
$string['settings_rolesync_revoke'] = 'Rimuovi i ruoli non più corrispondenti';
$string['settings_rolesync_revoke_details'] = 'Se abilitata, i ruoli assegnati in precedenza dalla sincronizzazione dei ruoli dei gruppi vengono rimossi da un utente alla successiva esecuzione dell\'attività pianificata quando non appartiene più a un gruppo mappato. I ruoli assegnati manualmente o in altro modo non vengono mai rimossi.';
$string['settings_rolesync_error_format'] = 'Riga di mappatura non valida "{$a}". Usare il formato origine=nomebreve[,nomebreve].';
$string['settings_rolesync_error_group'] = 'ID oggetto del gruppo non valido "{$a}". Deve essere un GUID.';
$string['settings_rolesync_error_role'] = 'Nome breve del ruolo sconosciuto o non supportato "{$a}". Possono essere usati solo ruoli assegnabili nel contesto di sistema.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
