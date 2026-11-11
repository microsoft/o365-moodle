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
$string['settings_pageheading'] = 'Configurazione di {$a}';
$string['settings_page_other_settings'] = 'Altre opzioni';
$string['settings_page_application'] = 'IdP e autenticazione';
$string['settings_page_application_wizard'] = 'Procedura guidata di configurazione dell\'applicazione';
$string['settings_page_binding_username_claim'] = 'Claim del nome utente di collegamento';
$string['settings_page_change_binding_username_claim_tool'] = 'Strumento di modifica del claim del nome utente di collegamento';
$string['settings_page_cleanup_oidc_tokens'] = 'Pulizia dei token OpenID Connect';
$string['settings_page_clear_user_tokens'] = 'Cancella token utente';
$string['settings_page_field_mapping'] = 'Mappatura dei campi';
$string['heading_additional_options'] = 'Opzioni aggiuntive';
$string['heading_additional_options_desc'] = '';
$string['heading_stateredirect'] = 'Pagina di errore dello stato di login';
$string['heading_stateredirect_desc'] = 'Per impostazione predefinita, se un utente impiega troppo tempo a completare il login presso il provider di identità (ad esempio mentre approva una richiesta di autenticazione a più fattori) e lo stato di login memorizzato è stato nel frattempo eliminato, Moodle mostra la sua pagina di errore generica. Le impostazioni seguenti consentono di prolungare la durata di conservazione dello stato di login e di mostrare, al posto della pagina di errore generica, un messaggio più chiaro e personalizzabile, reindirizzando automaticamente l\'utente alla pagina di login.';
$string['heading_user_restrictions'] = 'Restrizioni utente';
$string['heading_user_restrictions_desc'] = '';
$string['heading_logout'] = 'Integrazione della disconnessione';
$string['heading_logout_desc'] = '';
$string['heading_display'] = 'Visualizzazione';
$string['heading_display_desc'] = '';
$string['heading_debugging'] = 'Debug';
$string['heading_debugging_desc'] = '';
$string['heading_tools'] = 'Strumenti';
$string['microsoftcloud'] = 'Cloud Microsoft';
$string['microsoftcloud_help'] = 'Selezionare il cloud Microsoft a cui appartiene il tenant Microsoft Entra. Si applica ai tipi di IdP Microsoft Entra ID e Microsoft identity platform.<br/>
Selezionare "Microsoft 365 gestito da 21Vianet (Cina)" se l\'organizzazione utilizza Microsoft 365 fornito da 21Vianet. In tal caso, per le richieste effettuate dai plugin vengono utilizzati il servizio di accesso e gli endpoint di Microsoft Graph di quel cloud, e i valori predefiniti degli endpoint e della risorsa riportati di seguito si adeguano di conseguenza. I valori già salvati per gli endpoint, la risorsa e l\'endpoint di logout non vengono modificati: aggiornarli se sono ancora impostati sugli endpoint del cloud globale.';
$string['microsoftcloud_global'] = 'Microsoft 365 (globale)';
$string['microsoftcloud_china'] = 'Microsoft 365 gestito da 21Vianet (Cina)';
$string['idptype'] = 'Tipo di Identity Provider (IdP)';
$string['idptype_help'] = 'Attualmente sono supportati quattro tipi di IdP:
<ul>
<li><b>Microsoft Entra ID (v1.0)</b>: Microsoft Entra ID con endpoint oauth2 v1.0, ad es. https://login.microsoftonline.com/organizations/oauth2/authorize.</li>
<li><b>Microsoft identity platform (v2.0)</b>: Microsoft Entra ID con endpoint oauth2 v2.0, ad es. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize.</li>
<li><b>Microsoft Entra External ID</b>: un tenant Microsoft Entra External ID (clienti), con endpoint oauth2 v2.0 sull\'host ciamlogin.com, ad es. https://contoso.ciamlogin.com/&lt;tenant-id&gt;/oauth2/v2.0/authorize. Le funzionalità Microsoft 365 del plugin local_o365 non sono disponibili per questo tipo di IdP.</li>
<li><b>Altro</b>: qualsiasi IdP non Microsoft.</li>
</ul>
Le differenze tra le opzioni <b>Microsoft Entra ID (v1.0)</b> e <b>Microsoft identity platform (v2.0)</b> sono descritte in <a href="https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison">https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison</a>.<br/>
In particolare, con l\'IdP <b>Microsoft identity platform (v2.0)</b> l\'applicazione configurata può utilizzare per l\'autenticazione un <b>certificato</b> oltre al <b>segreto</b>.<br/>
Gli endpoint di autorizzazione e del token devono essere configurati in base al tipo di IdP configurato.';
$string['idp_type_not_connected'] = 'Non connesso';
$string['idp_type_microsoft_entra_id'] = 'Microsoft Entra ID (v1.0)';
$string['idp_type_microsoft_identity_platform'] = 'Microsoft identity platform (v2.0)';
$string['idp_type_other'] = 'Altro';
$string['idp_type_microsoft_entra_external_id'] = 'Microsoft Entra External ID';
$string['settings_application_wizard_desc'] = 'Per configurare queste impostazioni tramite un modulo guidato con istruzioni passo passo e convalida dei dati inseriti, utilizzare la <a href="{$a}">Procedura guidata di configurazione dell\'applicazione</a>.';
$string['authendpoint'] = 'Endpoint di autorizzazione';
$string['authendpoint_help'] = 'L\'URI dell\'endpoint di autorizzazione dell\'IdP da utilizzare.<br/>
<span data-auth-oidc-idptypes="1,2">Se il sito deve essere configurato per consentire l\'accesso a utenti di altri tenant, non è possibile utilizzare un endpoint di autorizzazione specifico del tenant.</span><span data-auth-oidc-idptypes="4">Per Microsoft Entra External ID, usare l\'"OAuth 2.0 authorization endpoint (v2)" mostrato nella pagina Endpoints della registrazione dell\'applicazione nel proprio tenant External ID. Deve essere un endpoint v2.0 specifico del proprio tenant.</span>';
$string['clientid'] = 'ID applicazione';
$string['clientid_help'] = 'L\'ID applicazione / client registrato presso l\'IdP.';
$string['clientauthmethod'] = 'Metodo di autenticazione del client';
$string['clientauthmethod_help'] = '<ul>
<li>Gli IdP di tutti i tipi possono utilizzare il metodo di autenticazione "<b>Segreto</b>".</li>
<li>Gli IdP di tipo <b>Microsoft identity platform (v2.0)</b> possono utilizzare anche il metodo di autenticazione <b>Certificato</b>.</li>
</ul>';
$string['auth_method_secret'] = 'Segreto';
$string['auth_method_certificate'] = 'Certificato';
$string['clientsecret'] = 'Segreto client';
$string['clientsecret_help'] = 'Se si utilizza il metodo di autenticazione con <b>segreto</b>, questo è il segreto client presso l\'IdP. Alcuni provider lo chiamano anche chiave.';
$string['clientprivatekey'] = 'Chiave privata del certificato client';
$string['clientprivatekey_help'] = 'Se si utilizza il metodo di autenticazione con <b>certificato</b> e l\'origine del certificato <b>Testo semplice</b>, questa è la chiave privata del certificato utilizzato per l\'autenticazione presso l\'IdP.';
$string['clientcert'] = 'Chiave pubblica del certificato client';
$string['clientcert_help'] = 'Se si utilizza il metodo di autenticazione con <b>certificato</b> e l\'origine del certificato <b>Testo semplice</b>, questa è la chiave pubblica, o certificato, utilizzata per l\'autenticazione presso l\'IdP.';
$string['clientcertsource'] = 'Origine del certificato';
$string['clientcertsource_help'] = 'Se si utilizza il metodo di autenticazione con <b>certificato</b>, definisce da dove recuperare il certificato.
<ul>
<li>L\'origine <b>Testo semplice</b> richiede che il contenuto dei file del certificato e della chiave privata sia inserito nelle successive aree di testo delle impostazioni.</li>
<li>L\'origine <b>Nome file</b> richiede che i file del certificato e della chiave privata si trovino in una cartella <b>microsoft_certs</b> nella cartella dati di Moodle.</li>
</ul>';
$string['cert_source_text'] = 'Testo semplice';
$string['cert_source_path'] = 'Nome file';
$string['clientprivatekeyfile'] = 'Nome file della chiave privata del certificato client';
$string['clientprivatekeyfile_help'] = 'Se si utilizza il metodo di autenticazione con <b>certificato</b> e l\'origine del certificato <b>Nome file</b>, questo è il nome del file della chiave privata utilizzata per l\'autenticazione presso l\'IdP. Il file deve trovarsi in una cartella <b>microsoft_certs</b> nella cartella dati di Moodle.';
$string['clientcertfile'] = 'Nome file della chiave pubblica del certificato client';
$string['clientcertfile_help'] = 'Se si utilizza il metodo di autenticazione con <b>certificato</b> e l\'origine del certificato <b>Nome file</b>, questo è il nome del file della chiave pubblica, o certificato, utilizzata per l\'autenticazione presso l\'IdP. Il file deve trovarsi in una cartella <b>microsoft_certs</b> nella cartella dati di Moodle.';
$string['clientcertpassphrase'] = 'Passphrase del certificato client';
$string['clientcertpassphrase_help'] = 'Se la chiave privata del certificato client è cifrata, questa è la passphrase per decifrarla.';
$string['change_client_secret'] = 'Modifica segreto client';
$string['change_client_secret_desc'] = 'Selezionare questa casella per aggiornare il segreto client. Per sicurezza, i segreti esistenti sono mascherati e vengono mostrati solo i primi 2 caratteri.';
$string['change_cert_passphrase'] = 'Modifica passphrase del certificato';
$string['change_cert_passphrase_desc'] = 'Selezionare questa casella per aggiornare la passphrase del certificato. Per sicurezza, le passphrase esistenti sono mascherate e vengono mostrati solo i primi 2 caratteri.';
$string['cfg_usepkce_key'] = 'Usa PKCE';
$string['cfg_usepkce_desc'] = 'Se si utilizza il flusso di login <b>Authorization Code</b>, invia nella richiesta di autorizzazione un "code_challenge" PKCE (RFC 7636) con il metodo S256 e il corrispondente "code_verifier" durante lo scambio del codice di autorizzazione. Microsoft Entra ID lo supporta. Per altri provider, abilitare questa opzione solo se il provider supporta PKCE, poiché alcuni provider rifiutano le richieste di autorizzazione contenenti parametri che non riconoscono.';
$string['cfg_domainhint_key'] = 'Domain Hint';
$string['cfg_domainhint_desc'] = 'Se si utilizza il flusso di login <b>Authorization Code</b>, viene passato questo valore come parametro "domain_hint". "domain_hint" è utilizzato da alcuni IdP OpenID Connect per semplificare il processo di login per gli utenti. Verificare con il proprio provider se supporta questo parametro.';
$string['cfg_domainhint_external_id_note'] = 'Per Microsoft Entra External ID, questo valore invia gli utenti direttamente a un provider di identità federato invece di mostrare la pagina di accesso. Usare google, facebook o apple, oppure il dominio di un provider OpenID Connect personalizzato (ad esempio contoso.onmicrosoft.com per un tenant Microsoft Entra ID). Non usare un ID tenant.';
$string['cfg_forceselectaccount_key'] = 'Mostra sempre la selezione dell\'account';
$string['cfg_forceselectaccount_desc'] = 'Se abilitato, agli utenti viene sempre chiesto di scegliere con quale account accedere, invece di accedere automaticamente con l\'account attivo nel browser. Utile quando gli utenti hanno più account, ad esempio un account studente e uno di amministratore.<br/>
La modalità di login silenzioso ha la precedenza: quando è abilitata, la selezione dell\'account non viene forzata durante il login silenzioso.';
$string['cfg_forceredirect_key'] = 'Forza reindirizzamento';
$string['cfg_forceredirect_desc'] = 'Se abilitato, la pagina indice di login viene saltata e l\'utente viene reindirizzato alla pagina OpenID Connect. Può essere aggirato con il parametro URL ?noredirect=1';
$string['cfg_stateexpiry_key'] = 'Scadenza dello stato di login (minuti)';
$string['cfg_stateexpiry_desc'] = 'Per quanto tempo un record di stato di login viene conservato prima che l\'elaborazione pianificata di pulizia lo rimuova. Aumentare questo valore se gli utenti impiegano regolarmente più tempo per completare il login presso il provider di identità (ad esempio a causa delle richieste di autenticazione a più fattori).';
$string['error_stateexpiry_min'] = 'La scadenza dello stato di login deve essere di almeno 1 minuto. Un valore pari a zero o inferiore farebbe fallire i login in corso.';
$string['cfg_stateredirect_enabled_key'] = 'Mostra pagina di errore semplificata';
$string['cfg_stateredirect_enabled_desc'] = 'Se abilitato, a un utente che impiega troppo tempo a completare il login presso il provider di identità (tanto che lo stato di login memorizzato è stato nel frattempo eliminato) viene mostrato il messaggio personalizzabile riportato di seguito e viene automaticamente reindirizzato alla pagina di login, invece della pagina di errore generica di Moodle.';
$string['cfg_stateredirect_message_key'] = 'Messaggio';
$string['cfg_stateredirect_message_desc'] = 'Il messaggio da mostrare all\'utente nella pagina di errore semplificata.';
$string['cfg_stateredirect_message_default'] = 'Si è verificato un problema durante il login. Molto probabilmente il login ha richiesto troppo tempo per essere completato (ad esempio mentre approvavi una richiesta di autenticazione a più fattori). Verrai reindirizzato automaticamente alla pagina di login per riprovare.';
$string['cfg_stateredirect_delay_key'] = 'Ritardo del reindirizzamento (secondi)';
$string['cfg_stateredirect_delay_desc'] = 'Il numero di secondi durante i quali mostrare il messaggio precedente prima di reindirizzare automaticamente l\'utente alla pagina di login.';
$string['cfg_set_pix_key'] = 'Mostra icona nella pagina di login';
$string['cfg_set_pix_desc'] = 'Se abilitato, mostra un\'icona accanto al nome del provider nella pagina di login.';
$string['cfg_icon_key'] = 'Icona';
$string['cfg_icon_desc'] = 'Un\'icona visualizzata accanto al nome del provider sulla pagina di login.';
$string['cfg_iconalt_o365'] = 'Icona Office 365';
$string['cfg_iconalt_microsoft365'] = 'Logo Microsoft 365';
$string['cfg_iconalt_openid'] = 'Icona OpenID';
$string['cfg_iconalt_keycloak'] = 'Icona Keycloak';
$string['cfg_customicon_key'] = 'Icona personalizzata';
$string['cfg_customicon_desc'] = 'Per utilizzare un\'icona personalizzata, caricarla qui. Questa ha la precedenza su qualsiasi icona scelta in precedenza. <br /><br /><b>Note sull\'utilizzo di icone personalizzate:</b><ul><li>Il file caricato non viene ridimensionato. Verrà visualizzato con una dimensione fissa di 24x24 pixel nella pagina di login, adattato dal browser, pertanto si consiglia di caricare un\'immagine quadrata per evitare distorsioni.</li><li>Se è stata caricata un\'icona personalizzata e si desidera tornare a una delle icone predefinite, fare clic sull\'icona personalizzata nella casella precedente, quindi su "Elimina", poi su "OK" e infine su "Salva modifiche" nella parte inferiore di questo modulo. L\'icona predefinita selezionata verrà visualizzata nella pagina di login di Moodle.</li></ul>';
$string['cfg_debugmode_key'] = 'Registra messaggi di debug';
$string['cfg_debugmode_desc'] = 'Se abilitato, nel log di Moodle verranno registrate informazioni utili per individuare eventuali problemi.';
$string['cfg_silentloginmode_key'] = 'Modalità di login silenzioso';
$string['cfg_silentloginmode_desc'] = 'Se abilitato, Moodle tenterà di utilizzare la sessione attiva di un utente autenticato presso l\'endpoint di autorizzazione configurato per effettuarne il login.<br/>
Per utilizzare questa funzionalità sono necessarie le seguenti configurazioni:
<ul>
<li>L\'impostazione <b>Autenticazione obbligatoria</b> (forcelogin) nella <a href="{$a}" target="_blank">sezione Impostazioni di sicurezza del sito</a> è abilitata.</li>
<li>L\'impostazione <b>Forza reindirizzamento</b> (auth_oidc/forceredirect) riportata sopra è abilitata.</li>
</ul>
Per evitare che Moodle tenti di effettuare il login con account personali o account di altri tenant, si consiglia inoltre di utilizzare endpoint specifici del tenant anziché quelli generici con percorsi "common", "organizations" e simili.<br/>
<br/>
Per gli IdP Microsoft, l\'esperienza utente è la seguente:
<ul>
<li>Se non viene trovata alcuna sessione utente attiva, viene mostrata la pagina di login di Moodle.</li>
<li>Se viene trovata una sola sessione utente attiva e l\'utente ha accesso all\'app Entra ID (ovvero l\'utente appartiene allo stesso tenant o è un utente guest del tenant), l\'utente accede automaticamente a Moodle tramite SSO.</li>
<li>Se viene trovata una sola sessione utente attiva, ma l\'utente non ha accesso all\'app Entra ID (ad es. l\'utente appartiene a un altro tenant oppure l\'app richiede l\'assegnazione degli utenti e l\'utente non è assegnato), viene mostrata la pagina di login di Moodle.</li>
<li>Se sono presenti più sessioni utente attive con accesso all\'app Entra ID, viene mostrata una pagina che consente all\'utente di selezionare l\'account con cui accedere.</li>
</ul>';
$string['oidcresource'] = 'Risorsa';
$string['oidcresource_help'] = 'La risorsa OpenID Connect per la quale inviare la richiesta.<br/>
<b>Nota:</b> questo parametro non è supportato con il tipo di IdP <b>Microsoft identity platform (v2.0)</b>.';
$string['oidcscope'] = 'Ambito';
$string['oidcscope_help'] = 'L\'ambito (scope) OIDC da utilizzare.';
$string['customclaims'] = 'Claim personalizzati';
$string['customclaims_help'] = 'Elenco separato da spazi dei nomi dei claim personalizzati presenti nei token del provider di identità.<br/>
<b>Importante:</b>
<ul>
<li>I claim devono esistere nella configurazione dei token dell\'IdP (ad es. protocol mapper di Keycloak, claim facoltativi/personalizzati di Microsoft Entra ID)</li>
<li>Se un claim non è presente nel token, la mappatura dei campi lo ignora senza segnalarlo: non viene mostrato alcun errore</li>
<li>I nomi dei claim distinguono tra maiuscole e minuscole e possono contenere solo caratteri alfanumerici, trattini e trattini bassi</li>
<li>Il nome di un claim non può essere un nome riservato, come un claim standard JWT/OpenID Connect (ad es. <code>sub</code>, <code>email</code>), un claim specifico di Microsoft Entra ID (ad es. <code>oid</code>, <code>upn</code>) o di Keycloak (ad es. <code>realm_access</code>, <code>resource_access</code>), oppure un\'opzione di mappatura dei campi già esistente</li>
<li>Sono consentiti il claim <code>roles</code> (ruoli dell\'app nei token Microsoft Entra ID) e il claim <code>groups</code> (ID dei gruppi). Nella mappatura dei campi sono elencati come "roles (claim del token)" e "groups (claim del token)", distinti dalle opzioni predefinite "Ruoli" e "Gruppi", che mappano i ruoli di directory di Microsoft Entra e i nomi dei gruppi da Microsoft Graph. I claim contenenti un elenco di valori vengono memorizzati come elenco separato da virgole</li>
<li>Esempi: <code>employee_type badge_number costCenter custom_role</code></li>
<li data-auth-oidc-idptypes="1,2">Al login, i claim personalizzati vengono sempre letti dal token, indipendentemente dall\'uso di Microsoft Graph. Durante l\'elaborazione pianificata di sincronizzazione degli utenti non è disponibile alcun token utente da cui leggerli, quindi un claim personalizzato viene sincronizzato solo se il suo nome corrisponde anche a una proprietà utente selezionabile di Microsoft Graph, come un attributo di estensione della directory (ad es. <code>extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode</code>). Un claim personalizzato rifiutato da Microsoft Graph viene ignorato per quell\'esecuzione della sincronizzazione, con un avviso nel log dell\'operazione, invece di far fallire l\'intera sincronizzazione.</li>
</ul>';
$string['secretexpiryrecipients'] = 'Destinatari delle notifiche di scadenza del segreto';
$string['secretexpiryrecipients_help'] = 'Elenco separato da virgole degli indirizzi email a cui inviare le notifiche di scadenza del segreto.<br/>
Se non viene inserito alcun indirizzo email, verrà notificato l\'amministratore principale del sito.<br/>
Per impostazione predefinita, le notifiche vengono inviate ogni giorno a partire da quattro settimane prima della scadenza fino al rinnovo del segreto.';
$string['cfg_showbutton_key'] = 'Mostra pulsante di login';
$string['cfg_showbutton_desc'] = 'Se disabilitato, il pulsante di login del provider non viene visualizzato nella pagina di login. Gli utenti possono comunque autenticarsi tramite questo provider accedendo direttamente al relativo URL di login.';
$string['cfg_opname_key'] = 'Nome visualizzato del provider';
$string['cfg_opname_desc'] = 'Si tratta di un\'etichetta presentata all\'utente finale che identifica il tipo di credenziali che l\'utente deve utilizzare per eseguire il login. Questa etichetta viene utilizzata in tutta la parte rivolta all\'utente del plugin per identificare il provider.';
$string['cfg_redirecturi_key'] = 'URI di reindirizzamento';
$string['cfg_redirecturi_desc'] = 'Si tratta dell\'URI da registrare come "URI di reindirizzamento". L\'IdP OpenID Connect dovrebbe richiederlo durante la registrazione di Moodle come client. <br /><b>NOTA:</b> è necessario immettere questo valore nell\'IdP OpenID Connect *esattamente* come appare qui. Qualsiasi differenza impedirà il login con OpenID Connect.';
$string['tokenendpoint'] = 'Endpoint del token';
$string['tokenendpoint_help'] = 'L\'URI dell\'endpoint del token dell\'IdP da utilizzare.<br/>
<span data-auth-oidc-idptypes="1,2">Se il sito deve essere configurato per consentire l\'accesso a utenti di altri tenant, non è possibile utilizzare un endpoint del token specifico del tenant.</span><span data-auth-oidc-idptypes="4">Per Microsoft Entra External ID, usare l\'"OAuth 2.0 token endpoint (v2)" mostrato nella pagina Endpoints della registrazione dell\'applicazione nel proprio tenant External ID. Deve essere un endpoint v2.0 specifico del proprio tenant.</span>';
$string['cfg_userrestrictions_key'] = 'Restrizioni utente';
$string['cfg_userrestrictions_desc'] = 'Consente il login solo agli utenti che soddisfano determinate restrizioni. <br /><b>Come utilizzare le restrizioni utente: </b> <ul><li>Inserire un\'<a href="https://en.wikipedia.org/wiki/Regular_expression">espressione regolare</a> che corrisponda ai nomi utente degli utenti da consentire.</li><li>Inserire un\'espressione per riga</li><li>Se vengono inserite più espressioni, un utente sarà consentito se corrisponde a QUALSIASI di esse.</li><li>Il carattere "/" deve essere preceduto dal carattere di escape "\\".</li><li>Se non viene inserita alcuna restrizione, Moodle accetterà tutti gli utenti in grado di effettuare il login presso l\'IdP OpenID Connect.</li><li>A qualsiasi utente che non corrisponda ad alcuna delle espressioni inserite verrà impedito il login tramite OpenID Connect.</li></ul>';
$string['cfg_userrestrictions_disabled_external_id'] = 'Le restrizioni utente non sono disponibili per Microsoft Entra External ID, pertanto questa impostazione è disabilitata e le restrizioni non vengono applicate quando gli utenti accedono. Le restrizioni vengono confrontate con il claim di associazione del nome utente, che per gli utenti External ID è per impostazione predefinita l\'ID oggetto (oid), quindi i modelli dovrebbero corrispondere a GUID. Controllare invece chi può accedere al sito nel proprio tenant External ID, ad esempio con i flussi utente o l\'assegnazione dell\'applicazione.';
$string['cfg_userrestrictionscasesensitive_key'] = 'Restrizioni utente sensibili a maiuscole/minuscole';
$string['cfg_userrestrictionscasesensitive_desc'] = 'Determina se nella verifica delle restrizioni utente viene utilizzata l\'opzione "/i" delle espressioni regolari.<br/>Se abilitato, tutte le verifiche delle restrizioni utente distingueranno tra maiuscole e minuscole. Se disabilitato, eventuali distinzioni tra maiuscole e minuscole nelle espressioni verranno ignorate.';
$string['heading_dummy_email'] = 'Indirizzi email segnaposto';
$string['heading_dummy_email_desc'] = 'Moodle richiede che ogni account utente abbia un indirizzo email, ma alcuni provider di identità, come Microsoft Entra ID, non lo richiedono per i propri account. Le impostazioni seguenti consentono a Moodle di generare un indirizzo segnaposto non recapitabile per gli utenti che non dispongono di un indirizzo email utilizzabile proveniente dall\'IdP, invece di lasciare vuoto il loro indirizzo email.';
$string['cfg_generatedummyemail_key'] = 'Genera indirizzi email segnaposto';
$string['cfg_generatedummyemail_desc'] = 'Se abilitato, quando un utente non ha un indirizzo email né un nome dell\'entità utente (UPN) in formato email utilizzabile proveniente dall\'IdP, Moodle genererà per lui un indirizzo email segnaposto utilizzando il suo nome dell\'entità utente (o l\'ID oggetto, se il nome dell\'entità utente non è disponibile) e il dominio configurato di seguito, invece di lasciare vuoto il suo indirizzo email. Ciò si applica sia quando l\'utente effettua il login sia quando viene creato dall\'elaborazione di sincronizzazione degli utenti. Il nome dell\'entità utente e l\'ID oggetto vengono letti dai claim del token dell\'IdP, quindi non viene generato alcun indirizzo se l\'IdP non fornisce nessuno dei due.';
$string['cfg_dummyemaildomain_key'] = 'Dominio email segnaposto';
$string['cfg_dummyemaildomain_desc'] = 'Il dominio da utilizzare per generare gli indirizzi email segnaposto, ad esempio "example.test". Utilizzare un dominio che non possa ricevere posta, in modo che gli indirizzi generati non possano mai essere scambiati per indirizzi reali e recapitabili.';
$string['cfg_singlelogout_key'] = 'Single Logout (SLO) (da Moodle all\'IdP)';
$string['cfg_singlelogout_desc'] = 'Se l\'opzione è abilitata, quando un utente Moodle connesso all\'IdP configurato esegue il logout da Moodle, l\'integrazione invierà una richiesta all\'endpoint di logout riportato di seguito, tentando di disconnettere l\'utente anche dall\'IdP.<br/>
Per l\'integrazione con Microsoft Entra ID, l\'URL del sito Moodle ({$a}) deve essere aggiunto come URI di reindirizzamento nell\'app Microsoft Entra ID creata per l\'integrazione tra Moodle e Microsoft 365.<br/>La disconnessione unica termina solo la sessione del servizio di accesso utilizzato da Moodle. Le altre sessioni dello stesso account nel browser, ad esempio quella creata accedendo al portale di Azure, non sono interessate.';
$string['cfg_logoutendpoint_key'] = 'Endpoint di logout dell\'IdP';
$string['cfg_logoutendpoint_desc'] = 'L\'URI dell\'endpoint di logout dell\'IdP da utilizzare.';
$string['cfg_logoutendpoint_external_id_note'] = 'Con Microsoft Entra External ID, agli utenti viene chiesto di scegliere un account nella pagina di disconnessione di Microsoft, a meno che la dichiarazione facoltativa login_hint non venga aggiunta al token ID nella registrazione dell\'app (Configurazione token > Aggiungi dichiarazione facoltativa > ID > login_hint). Gli utenti devono accedere di nuovo dopo l\'aggiunta della dichiarazione.';
$string['cfg_frontchannellogouturl_key'] = 'URL di logout front-channel';
$string['cfg_frontchannellogouturl_desc'] = 'Si tratta dell\'URL che l\'IdP deve richiamare quando tenta di disconnettere gli utenti da Moodle.<br/>
Per Microsoft Entra ID / Microsoft identity platform, l\'impostazione si chiama "Front-channel logout URL" ed è configurabile nell\'app Microsoft Entra ID.';
$string['cfg_field_mapping_desc'] = 'I dati del profilo utente possono essere mappati dall\'IdP OpenID Connect a Moodle. I campi remoti disponibili per la mappatura dipendono in larga misura dal tipo di IdP.<br/>
<ul>
<li>Alcuni campi di base del profilo sono disponibili dai claim dell\'access token e dell\'ID token con tutti i tipi di IdP.</li>
<li>Se è configurato un tipo di IdP Microsoft (v1.0 o v2.0), è possibile rendere disponibili ulteriori dati del profilo tramite chiamate alla Graph API installando e configurando il <a href="https://moodle.org/plugins/local_o365">plugin di integrazione Microsoft 365 (local_o365)</a>.</li>
<li>Se nel plugin local_o365 è abilitata la funzionalità di sincronizzazione dei profili SDS, alcuni campi del profilo possono essere sincronizzati da SDS a Moodle. Ciò avviene solo durante l\'esecuzione dell\'elaborazione pianificata "Sincronizza con SDS" e non durante l\'esecuzione dell\'elaborazione pianificata "Sincronizza utenti da Microsoft Entra ID", né quando un utente effettua il login.</li>
</ul>

I claim disponibili dall\'ID token e dall\'access token variano a seconda del tipo di IdP, ma la maggior parte degli IdP consente un certo livello di personalizzazione dei claim. Di seguito i collegamenti alla documentazione sugli IdP Microsoft:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Claim dell\'access token</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">Claim dell\'ID token</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Configurazione dei claim facoltativi</a>: nota che "Email" è un claim facoltativo con il tipo di IdP Microsoft Entra ID (v1.0).</li>
</ul>';
$string['cfg_field_mapping_desc_generic'] = 'I dati del profilo utente possono essere mappati dall\'IdP OpenID Connect a Moodle. I campi remoti disponibili per la mappatura dipendono dal tipo di IdP.<br/>
<ul>
<li>I campi di base del profilo sono disponibili dai claim dell\'ID token e dell\'access token emessi dal proprio IdP. I campi mappabili, come nome, cognome e indirizzo e-mail, dipendono quindi dai claim che l\'IdP include in questi token.</li>
<li>È possibile aggiungere altri claim all\'elenco dei campi disponibili per la mappatura con l\'impostazione "{$a}".</li>
</ul>
La maggior parte degli IdP consente una certa personalizzazione dei claim emessi. Consultare la documentazione del proprio IdP per i claim supportati.';
$string['cfg_field_mapping_desc_external_id'] = 'I dati del profilo utente possono essere mappati da Microsoft Entra External ID a Moodle. I campi remoti disponibili per la mappatura sono i claim dell\'ID token e dell\'access token, perché Microsoft Graph non viene usato per questo tipo di IdP.<br/>
<ul>
<li>I campi di base del profilo sono disponibili dai claim dell\'ID token e dell\'access token.</li>
<li>Per impostazione predefinita, l\'ID token di un tenant External ID contiene solo il nome, l\'ID oggetto e il nome di accesso dell\'utente. Per mappare nome, cognome e indirizzo e-mail, aggiungere i claim given_name, family_name ed email come claim facoltativi all\'ID token nella registrazione dell\'applicazione del proprio tenant External ID (Configurazione dei token). Il claim email viene emesso solo se l\'utente ha un indirizzo e-mail nel tenant.</li>
<li>È possibile aggiungere altri claim all\'elenco dei campi disponibili per la mappatura con l\'impostazione "{$a}".</li>
</ul>
La documentazione sui claim dei token Microsoft è collegata di seguito:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Claim dell\'access token</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">Claim dell\'ID token</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Configurazione dei claim facoltativi</a></li>
</ul>';

$string['cfg_cleanupoidctokens_key'] = 'Pulizia dei token OpenID Connect';
$string['cfg_cleanupoidctokens_desc'] = 'Se gli utenti riscontrano problemi nell\'effettuare il login con il proprio account Microsoft 365, provare a eseguire la pulizia dei token OpenID Connect. Questa operazione rimuove i token orfani e incompleti che possono causare errori. ATTENZIONE: potrebbe interrompere i login in corso, quindi è consigliabile eseguirla durante un periodo di inattività.';
$string['settings_section_basic'] = 'Impostazioni di base';
$string['settings_section_authentication'] = 'Autenticazione';
$string['settings_section_endpoints'] = 'Endpoint';
$string['settings_section_other_params'] = 'Altri parametri';
$string['settings_section_secret_expiry_notification'] = 'Notifica di scadenza del segreto';
$string['application_updated'] = 'Le impostazioni dell\'applicazione OpenID Connect sono state aggiornate.';
$string['application_updated_microsoft'] = 'L\'impostazione dell\'applicazione OpenID Connect è stata aggiornata.<br/>
<span class="warning" style="color: red;">Se vengono modificate le impostazioni "Tipo di Identity Provider (IdP)" o "Metodo di autenticazione del client", un amministratore di Microsoft Entra ID dovrà eseguire nuovamente <b>Fornisci consenso amministratore</b> e <b>Verifica configurazione</b> nella pagina di configurazione dell\'integrazione Microsoft 365.</span>';
$string['application_updated_microsoft_notify'] = 'L\'impostazione dell\'applicazione OpenID Connect è stata aggiornata.<br/>
<span class="warning" style="color: red;">Se vengono modificate le impostazioni "Tipo di Identity Provider (IdP)" o "Metodo di autenticazione del client", un amministratore di Microsoft Entra ID dovrà eseguire nuovamente <b>Fornisci consenso amministratore</b> e <b>Verifica configurazione</b> nella <a href="{$a}">pagina di configurazione dell\'integrazione Microsoft 365</a>.</span>';
$string['application_not_changed'] = 'L\'impostazione dell\'applicazione OpenID Connect non è stata modificata.';

$string['event_debug'] = 'Messaggio di debug';

$string['task_cleanup_oidc_state_and_token'] = 'Pulizia dello stato OIDC e dei token non validi';
$string['task_cleanup_oidc_sid'] = 'Pulizia dei record SID OIDC';

$string['errorauthdisconnectemptypassword'] = 'La password non può essere vuota';
$string['errorauthdisconnectemptyusername'] = 'Il nome utente non può essere vuoto';
$string['errorauthdisconnectusernameexists'] = 'Questo nome utente è già in uso. Sceglierne uno diverso.';
$string['errorauthdisconnectnewmethod'] = 'Utilizza metodo di login';
$string['errorauthdisconnectinvalidmethod'] = 'Ricevuto metodo di login non valido.';
$string['errorauthdisconnectifmanual'] = 'Se si utilizza il metodo di login manuale, immettere le credenziali sottostanti.';
$string['errorauthgeneral'] = 'Si è verificato un problema durante il login. Contatta l\'amministratore per ricevere assistenza.';
$string['errorauthinvalididtoken'] = 'id_token non valido ricevuto.';
$string['errorauthloginfailednouser'] = 'Login non valido: hai effettuato il login come "{$a}", ma su questo sito non esiste un account corrispondente e non è possibile creare automaticamente nuovi account. Contatta l\'amministratore del sito per ricevere assistenza. Se hai più di un account, seleziona Continua per accedere con un account diverso.';
$string['errorauthloginfaileddupemail'] = 'Login non valido: un account esistente su questo Moodle ha lo stesso indirizzo email dell\'account che stai cercando di creare e l\'impostazione "Consenti utenti con email duplicate" (allowaccountssameemail) è disabilitata.';
$string['errorauthmfarequired'] = 'Microsoft richiede l\'autenticazione a più fattori per completare il login, ma non è stato possibile completarla. Riprova oppure accedi a Microsoft 365 in una nuova sessione del browser e completa la richiesta di autenticazione a più fattori.';
$string['errorauthnoauthcode'] = 'Non è stato ricevuto alcun codice di autorizzazione dal server di identità. I log degli errori potrebbero contenere ulteriori informazioni.';
$string['errorauthnocredsandendpoints'] = 'Configurare le credenziali client e gli endpoint di OpenID Connect.';
$string['errorauthnoidtoken'] = 'OpenID Connect id_token non ricevuto.';
$string['errorauthnoaccesstoken'] = 'Access token non ricevuto.';
$string['errorauthunknownstate'] = 'Stato sconosciuto.';
$string['errorauthuseralreadyconnected'] = 'Sei già connesso a un utente OpenID Connect diverso.';
$string['errorauthuserconnectedtodifferent'] = 'L\'utente OpenID Connect autenticato è già connesso a un utente Moodle.';
$string['errorbadloginflow'] = 'Specificato tipo di autenticazione non valido. Nota: se stai ricevendo questo messaggio dopo un\'installazione o un aggiornamento recente, svuota la cache di Moodle.';
$string['errorjwtbadpayload'] = 'Impossibile leggere payload JWT.';
$string['errorjwtcouldnotreadheader'] = 'Impossibile leggere intestazione JWT';
$string['errorjwtempty'] = 'Ricevuto JWT vuoto o di tipo non stringa.';
$string['errorjwtinvalidheader'] = 'Intestazione JWT non valida';
$string['errorjwtmalformed'] = 'Ricevuto JWT danneggiato.';
$string['errorjwtunsupportedalg'] = 'JWS Alg o JWE non supportato';
$string['erroroidcnotenabled'] = 'Il plugin di autenticazione OpenID Connect non è abilitato.';
$string['errornodisconnectionauthmethod'] = 'Impossibile disconnettersi perché non esiste un plugin di autenticazione abilitato verso cui eseguire il fallback (metodo di login precedente dell\'utente o metodo di login manuale).';
$string['erroroidcclientinvalidendpoint'] = 'Ricevuto URI endpoint non valido.';
$string['erroroidcclientnocreds'] = 'Impostare le credenziali client con setcreds';
$string['erroroidcclientnoauthendpoint'] = 'Nessun endpoint di autorizzazione impostato. Impostarlo con $this->setendpoints';
$string['erroroidcclientnotokenendpoint'] = 'Nessun endpoint token impostato. Impostare con $this->setendpoints';
$string['errorrestricted'] = 'Questo sito applica delle restrizioni agli utenti che possono effettuare il login con OpenID Connect. Queste restrizioni al momento ti impediscono di completare questo tentativo di login.';
$string['errorucpinvalidaction'] = 'Ricevuta azione non valida.';
$string['erroroidccall'] = 'Si è verificato un errore in OpenID Connect. Consultare i log per ulteriori informazioni.';
$string['erroroidccall_message'] = 'Si è verificato un errore in OpenID Connect: {$a}';
$string['errorinvalidredirect_message'] = 'L\'URL verso cui stai tentando di essere reindirizzato non esiste.';
$string['errorinvalidcertificatesource'] = 'Origine del certificato non valida';
$string['error_invalid_client_authentication_method'] = 'Metodo di autenticazione del client non valido';
$string['error_certificate_requires_identity_platform'] = 'L\'autenticazione con certificato richiede il tipo di IdP "Microsoft identity platform (v2.0)".';
$string['error_empty_client_secret'] = 'Il segreto client non può essere vuoto se si utilizza il metodo di autenticazione "segreto"';
$string['error_empty_client_private_key'] = 'La chiave privata del certificato client non può essere vuota se si utilizza il metodo di autenticazione "certificato"';
$string['error_empty_client_cert'] = 'La chiave pubblica del certificato client non può essere vuota se si utilizza il metodo di autenticazione "certificato"';
$string['error_empty_client_private_key_file'] = 'Il file della chiave privata del certificato client non può essere vuoto se si utilizza il metodo di autenticazione "certificato"';
$string['error_empty_client_cert_file'] = 'Il file della chiave pubblica del certificato client non può essere vuoto se si utilizza il metodo di autenticazione "certificato"';
$string['error_endpoint_mismatch_auth_endpoint'] = 'L\'endpoint di autorizzazione configurato non corrisponde al tipo di IdP configurato. Per "Microsoft Entra ID (v1.0)" utilizzare un endpoint v1.0 (ad es. https://login.microsoftonline.com/organizations/oauth2/authorize). Per "Microsoft identity platform (v2.0)" utilizzare un endpoint v2.0 (ad es. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize).';
$string['error_endpoint_mismatch_token_endpoint'] = 'L\'endpoint del token configurato non corrisponde al tipo di IdP configurato. Per "Microsoft Entra ID (v1.0)" utilizzare un endpoint v1.0 (ad es. https://login.microsoftonline.com/organizations/oauth2/token). Per "Microsoft identity platform (v2.0)" utilizzare un endpoint v2.0 (ad es. https://login.microsoftonline.com/organizations/oauth2/v2.0/token).';
$string['error_endpoint_external_id'] = 'L\'endpoint deve essere un endpoint v2.0 di Microsoft Entra External ID sull\'host ciamlogin.com, ad es. https://contoso.ciamlogin.com/[tenant-id]/oauth2/v2.0/authorize.';
$string['error_logoutendpoint_external_id'] = 'L\'endpoint di disconnessione deve essere un endpoint v2.0 di Microsoft Entra External ID sull\'host ciamlogin.com, ad es. https://contoso.ciamlogin.com/[tenant-id]/oauth2/v2.0/logout. Lascia il campo vuoto per usare l\'endpoint derivato dall\'endpoint di autorizzazione.';
$string['error_endpoint_external_id_placeholder'] = 'Sostituire i segnaposto [tenant-name] e [tenant-id] con i valori del proprio tenant Microsoft Entra External ID.';
$string['error_endpoint_external_id_tenant'] = 'I tenant Microsoft Entra External ID sono a tenant singolo. Usare nell\'endpoint l\'ID o il nome del tenant al posto di common, organizations o consumers.';
$string['error_endpoint_external_id_v1'] = 'Questo è un endpoint v1.0. Microsoft Entra External ID richiede l\'endpoint v2.0, con /oauth2/v2.0/ nel percorso.';
$string['error_endpoint_external_id_kind'] = 'L\'endpoint deve terminare con /{$a}.';
$string['error_endpoint_external_id_mismatch'] = 'Gli endpoint di autorizzazione e di token devono appartenere allo stesso tenant Microsoft Entra External ID.';
$string['error_endpoint_is_external_id'] = 'Questo è un endpoint Microsoft Entra External ID. Impostare il tipo di IdP su Microsoft Entra External ID oppure usare un endpoint login.microsoftonline.com per questo tipo di IdP.';
$string['error_tenant_specific_endpoint_required'] = 'Se si utilizzano il tipo di IdP "Microsoft identity platform (v2.0)" e il metodo di autenticazione "Certificato", è necessario un endpoint specifico del tenant (ovvero non common/organizations/consumers).';
$string['error_empty_oidcresource'] = 'La risorsa non può essere vuota quando si usa Microsoft Entra ID (v1.0).';
$string['error_invalid_custom_claim'] = 'Nomi di claim personalizzati non validi: {$a}. I nomi dei claim personalizzati possono contenere solo caratteri alfanumerici, trattini e trattini bassi e non possono essere un nome di claim riservato (ad es. un claim standard JWT/OpenID Connect o un claim specifico di Microsoft Entra ID o Keycloak) né un\'opzione di mappatura dei campi già esistente.';
$string['error_masked_secret_not_changed'] = 'Inserire un nuovo valore oppure deselezionare la casella "Modifica" per mantenere il valore attuale.';
$string['error_secretexpiryrecipients_invalid'] = 'I seguenti destinatari delle notifiche di scadenza del segreto non sono indirizzi email validi: {$a}';
$string['auth_settings_validation_error'] = 'Sono state rilevate impostazioni di autenticazione non valide. Per garantire il corretto funzionamento dell\'autenticazione è necessario risolvere i seguenti problemi di configurazione:';
$string['errorupnchangeisnotsupported'] = 'L\'UPN del tuo account Microsoft è cambiato. Contatta l\'amministratore per aggiornare il tuo account Moodle.';
$string['erroruserwithusernamealreadyexists'] = 'Si è verificato un errore durante il tentativo di rinominare il tuo account Moodle. Esiste già un utente Moodle con il nuovo nome utente. Chiedi all\'amministratore del sito di risolvere prima questo problema.';
$string['error_no_response_available'] = 'Nessuna risposta disponibile.';

$string['eventuserauthed'] = 'Utente autorizzato con OpenID Connect';
$string['eventusercreated'] = 'Utente creato con OpenID Connect';
$string['eventuserconnected'] = 'Utente connesso a OpenID Connect';
$string['eventuserloggedin'] = 'Utente autenticato con OpenID Connect';
$string['eventuserdisconnected'] = 'Utente disconnesso da OpenID Connect';
$string['eventuserrenameattempt'] = 'Il plugin auth_oidc ha tentato di rinominare un utente';

$string['oidc:manageconnection'] = 'Consentire connessione e disconnessione OpenID Connect';
$string['oidc:manageconnectionconnect'] = 'Consentire connessione OpenID Connect';
$string['oidc:manageconnectiondisconnect'] = 'Consentire disconnessione OpenID Connect';

$string['privacy:metadata:auth_oidc'] = 'Autenticazione OpenID Connect';
$string['privacy:metadata:auth_oidc_prevlogin'] = 'Metodi di login precedenti per annullare le connessioni a Microsoft 365';
$string['privacy:metadata:auth_oidc_prevlogin:userid'] = 'L\'ID dell\'utente Moodle';
$string['privacy:metadata:auth_oidc_prevlogin:method'] = 'Il metodo di login precedente';
$string['privacy:metadata:auth_oidc_prevlogin:password'] = 'Il campo della password utente precedente (cifrata).';
$string['privacy:metadata:auth_oidc_token'] = 'Token OpenID Connect';
$string['privacy:metadata:auth_oidc_token:oidcuniqid'] = 'L\'identificatore univoco OIDC dell\'utente.';
$string['privacy:metadata:auth_oidc_token:username'] = 'Il nome utente dell\'utente Moodle';
$string['privacy:metadata:auth_oidc_token:userid'] = 'L\'ID utente dell\'utente Moodle';
$string['privacy:metadata:auth_oidc_token:oidcusername'] = 'Il nome utente dell\'utente OIDC';
$string['privacy:metadata:auth_oidc_token:useridentifier'] = 'L\'identificatore utente dell\'utente OIDC';
$string['privacy:metadata:auth_oidc_token:scope'] = 'L\'ambito del token';
$string['privacy:metadata:auth_oidc_token:tokenresource'] = 'La risorsa del token';
$string['privacy:metadata:auth_oidc_token:authcode'] = 'Il codice di autorizzazione del token';
$string['privacy:metadata:auth_oidc_token:token'] = 'Il token';
$string['privacy:metadata:auth_oidc_token:expiry'] = 'La scadenza del token';
$string['privacy:metadata:auth_oidc_token:refreshtoken'] = 'Il refresh token';
$string['privacy:metadata:auth_oidc_token:idtoken'] = 'L\'ID token';
$string['privacy:metadata:auth_oidc_sid'] = 'Identificatori di sessione dell\'IdP (sid) utilizzati per individuare gli utenti Moodle connessi quando il Single Logout (SLO) viene avviato dall\'IdP';
$string['privacy:metadata:auth_oidc_sid:userid'] = 'L\'ID dell\'utente Moodle';
$string['privacy:metadata:auth_oidc_sid:sid'] = 'L\'identificatore di sessione dell\'IdP (sid)';
$string['privacy:metadata:auth_oidc_sid:timecreated'] = 'Il momento in cui è stata creata l\'associazione';
$string['privacy:metadata:auth_oidc_sid:sessionid'] = 'L\'ID della sessione Moodle attiva al momento della creazione dell\'associazione';
$string['privacy:metadata:auth_oidc_sid:iss'] = 'L\'emittente (claim iss) dell\'id_token da cui è stata creata l\'associazione';

// In the following strings, $a refers to a customizable name for the identity manager. For example, this could be
// "Microsoft 365", "OpenID Connect", etc.
$string['ucp_general_intro'] = 'Qui puoi gestire la connessione a {$a}. Abilitando questa opzione, sarai in grado di utilizzare il tuo account {$a} per accedere a Moodle anziché un nome utente e una password separati. Dopo la connessione, non dovrai più ricordare il nome utente e la password per Moodle, tutti i login verranno gestiti da {$a}.';
$string['ucp_login_start'] = 'Inizia a utilizzare {$a} per accedere a Moodle';
$string['ucp_login_start_desc'] = 'Il tuo account verrà cambiato per utilizzare {$a} per accedere a Moodle. Dopo che è stato abilitato, il login verrà eseguito utilizzando le tue credenziali {$a} - il nome utente e la password Moodle correnti non funzioneranno. In qualsiasi momento puoi disconnetterti dal tuo account e tornare a eseguire il login normalmente.';
$string['ucp_login_stop'] = 'Non utilizzare più {$a} per accedere a Moodle';
$string['ucp_login_stop_desc'] = 'Stai attualmente utilizzando {$a} per accedere a Moodle. Facendo clic su "Non utilizzare più {$a} per accedere a Moodle", l\'account Moodle verrà disconnesso da {$a}. Non potrai più accedere a Moodle con il tuo account {$a}. Ti verrà chiesto di creare un nome utente e una password, con cui da quel momento potrai accedere a Moodle direttamente.';
$string['ucp_login_status'] = 'Il login con {$a} è:';
$string['ucp_status_enabled'] = 'Abilitato';
$string['ucp_status_disabled'] = 'Disabilitato';
$string['ucp_disconnect_title'] = 'Disconnessione {$a}';
$string['ucp_disconnect_details'] = 'Il tuo account Moodle verrà disconnesso da {$a}. Per accedere a Moodle dovrai creare un nome utente e una password.';
$string['ucp_title'] = 'Gestione {$a}';
$string['ucp_o365accountconnected'] = 'Questo account Microsoft 365 è già connesso a un altro account Moodle.';

// Clean up OIDC tokens.
$string['cleanup_oidc_tokens'] = 'Pulizia dei token OpenID Connect';
$string['unmatched'] = 'Non associato';
$string['delete_token'] = 'Elimina token';
$string['mismatched'] = 'Non corrispondente';
$string['na'] = 'n/d';
$string['mismatched_details'] = 'Il record del token contiene il nome utente "{$a->tokenusername}"; l\'utente Moodle associato ha il nome utente "{$a->moodleusername}".';
$string['delete_token_and_reference'] = 'Elimina token e riferimento';
$string['table_token_id'] = 'ID del record del token';
$string['table_oidc_username'] = 'Nome utente OIDC';
$string['table_oidc_unique_identifier'] = 'Identificatore univoco OIDC';
$string['table_token_unique_id'] = 'ID univoco OIDC';
$string['table_matching_status'] = 'Stato dell\'associazione';
$string['table_matching_details'] = 'Dettagli';
$string['table_action'] = 'Azione';
$string['token_deleted'] = 'Il token è stato eliminato';
$string['no_token_to_cleanup'] = 'Non ci sono token OIDC da eliminare.';

$string['errorusermatched'] = 'L\'account Microsoft 365 "{$a->entraidupn}" è già associato all\'utente Moodle "{$a->username}". Per completare la connessione, effettua prima il login come quell\'utente Moodle e segui le istruzioni nel blocco Microsoft.';

// User mapping options.
$string['update_oncreate_and_onlogin'] = 'Alla creazione e a ogni login';
$string['update_oncreate_and_onlogin_and_usersync'] = 'Alla creazione, a ogni login e a ogni esecuzione dell\'elaborazione di sincronizzazione degli utenti';
$string['update_oncreate_and_usersync'] = 'Alla creazione e a ogni esecuzione dell\'elaborazione di sincronizzazione degli utenti';
$string['update_onlogin_and_usersync'] = 'A ogni login e a ogni esecuzione dell\'elaborazione di sincronizzazione degli utenti';
$string['upgradeoidcuniqidtoolong'] = 'L\'aggiornamento non può proseguire: alcuni record di auth_oidc_token hanno un oidcuniqid più lungo di 200 caratteri, che verrebbe troncato dalla nuova lunghezza della colonna. Eliminare questi record dei token ed eseguire nuovamente l\'aggiornamento.';

// Remote fields.
$string['settings_fieldmap_feild_not_mapped'] = '(non mappato)';
$string['settings_fieldmap_field_bindingusernameclaim'] = 'Claim del nome utente di collegamento (mappabile solo durante il login)';
$string['settings_fieldmap_field_city'] = 'Città';
$string['settings_fieldmap_field_companyName'] = 'Nome dell\'azienda';
$string['settings_fieldmap_field_objectId'] = 'ID oggetto';
$string['settings_fieldmap_field_country'] = 'Nazione';
$string['settings_fieldmap_field_department'] = 'Dipartimento';
$string['settings_fieldmap_field_displayName'] = 'Nome visualizzato';
$string['settings_fieldmap_field_surname'] = 'Cognome';
$string['settings_fieldmap_field_faxNumber'] = 'Numero di fax';
$string['settings_fieldmap_field_telephoneNumber'] = 'Numero di telefono';
$string['settings_fieldmap_field_givenName'] = 'Nome';
$string['settings_fieldmap_field_jobTitle'] = 'Qualifica';
$string['settings_fieldmap_field_mail'] = 'Email';
$string['settings_fieldmap_field_mobile'] = 'Cellulare';
$string['settings_fieldmap_field_postalCode'] = 'CAP';
$string['settings_fieldmap_field_preferredLanguage'] = 'Lingua';
$string['settings_fieldmap_field_state'] = 'Stato/Provincia';
$string['settings_fieldmap_field_streetAddress'] = 'Indirizzo';
$string['settings_fieldmap_field_userPrincipalName'] = 'Nome dell\'entità utente (UPN)';
$string['settings_fieldmap_field_employeeId'] = 'ID dipendente';
$string['settings_fieldmap_field_employeeType'] = 'Tipo di dipendente';
$string['settings_fieldmap_field_accountEnabled'] = 'Account abilitato';
$string['settings_fieldmap_field_businessPhones'] = 'Telefono ufficio';
$string['settings_fieldmap_field_mobilePhone'] = 'Telefono cellulare';
$string['settings_fieldmap_field_officeLocation'] = 'Ufficio';
$string['settings_fieldmap_field_preferredName'] = 'Nome preferito';
$string['settings_fieldmap_field_manager'] = 'Nome del responsabile';
$string['settings_fieldmap_field_manager_email'] = 'Email del responsabile';
$string['settings_fieldmap_field_teams'] = 'Teams';
$string['settings_fieldmap_field_groups'] = 'Gruppi';
$string['settings_fieldmap_field_roles'] = 'Ruoli';
$string['settings_fieldmap_field_tokenclaim'] = '{$a} (claim del token)';
$string['settings_fieldmap_field_onPremisesSamAccountName'] = 'Nome account SAM locale (on-premises)';
$string['settings_fieldmap_field_extensionattribute'] = 'Attributo di estensione {$a}';
$string['settings_fieldmap_field_sds_school_id'] = 'ID scuola SDS ({$a})';
$string['settings_fieldmap_field_sds_school_name'] = 'Nome scuola SDS ({$a})';
$string['settings_fieldmap_field_sds_school_role'] = 'Ruolo scolastico SDS ("Student" o "Teacher")';
$string['settings_fieldmap_field_sds_student_externalId'] = 'ID esterno studente SDS';
$string['settings_fieldmap_field_sds_student_birthDate'] = 'Data di nascita studente SDS';
$string['settings_fieldmap_field_sds_student_grade'] = 'Classe studente SDS';
$string['settings_fieldmap_field_sds_student_graduationYear'] = 'Anno di diploma studente SDS';
$string['settings_fieldmap_field_sds_student_studentNumber'] = 'Numero studente SDS';
$string['settings_fieldmap_field_sds_teacher_externalId'] = 'ID esterno docente SDS';
$string['settings_fieldmap_field_sds_teacher_teacherNumber'] = 'Numero docente SDS';

// Binding username claim options.
$string['binding_username_claim_warning'] = 'Questa è una funzionalità avanzata. Nella maggior parte dei casi deve rimanere impostata su "Scegli automaticamente"; una configurazione errata può compromettere i record degli utenti e interrompere il single sign-on (SSO).';
$string['binding_username_auto'] = 'Scegli automaticamente';
$string['binding_username_custom'] = 'Personalizzato';
$string['bindingusernameclaim'] = 'Claim del nome utente di collegamento';
$string['customclaimname'] = 'Nome del claim personalizzato';
$string['customclaimname_description'] = 'Questo campo viene utilizzato solo quando l\'impostazione <b>Claim del nome utente di collegamento</b> è impostata su <b>Personalizzato</b>.';
$string['binding_username_claim_tool_link_desc'] = 'Per aggiornare il claim del nome utente di collegamento per gli utenti esistenti, utilizzare lo <a href="{$a}">Strumento di modifica del claim del nome utente di collegamento</a>.';
$string['cleanup_oidc_tokens_link_desc'] = 'Per eliminare i token OpenID Connect obsoleti, utilizzare lo strumento <a href="{$a}">Pulizia dei token OpenID Connect</a>.';
$string['clear_user_tokens_link_desc'] = 'Per rimuovere i token memorizzati di tutti gli utenti o degli utenti selezionati, utilizzare lo strumento <a href="{$a}">Cancella token utente</a>.';
$string['clear_user_tokens'] = 'Cancella token utente';
$string['clear_user_tokens_desc'] = 'Rimuove i token OpenID Connect e Microsoft 365 memorizzati per gli utenti. Gli utenti interessati otterranno nuovi token al successivo login con OpenID Connect o alla successiva connessione a Microsoft 365. I collegamenti agli account Microsoft 365 vengono mantenuti. ATTENZIONE: potrebbe interrompere i login in corso, quindi è consigliabile eseguire questa operazione durante un periodo di inattività.';
$string['clear_user_tokens_desc_generic'] = 'Rimuove i token OpenID Connect memorizzati per gli utenti. Gli utenti interessati otterranno nuovi token al successivo accesso tramite OpenID Connect. ATTENZIONE: questo può interrompere gli accessi in corso, quindi è meglio farlo durante un periodo di inattività.';
$string['clear_user_tokens_scope_selected'] = 'Utenti selezionati';
$string['clear_user_tokens_scope_all'] = 'Tutti gli utenti';
$string['clear_user_tokens_users'] = 'Utenti';
$string['clear_user_tokens_submit'] = 'Cancella token';
$string['clear_user_tokens_no_name'] = '(nessun nome)';
$string['clear_user_tokens_no_user_selected'] = 'Selezionare almeno un utente.';
$string['clear_user_tokens_confirm_all'] = 'Cancellare i token di tutti gli utenti? Al momento {$a} utenti hanno dei token.';
$string['clear_user_tokens_confirm_selected'] = 'Cancellare i token degli utenti selezionati? Al momento {$a} degli utenti selezionati hanno dei token.';
$string['clear_user_tokens_success'] = 'Record dei token cancellati: {$a}.';
$string['binding_username_claim_help_ms_no_user_sync'] = 'Le opzioni per gli IdP Microsoft senza la funzionalità di sincronizzazione degli utenti abilitata includono:
<ul>
<li><b>Scegli automaticamente</b>: utilizza la logica attuale, determinando il token in base al tipo di IdP e ricorrendo a <b>sub</b> se non viene trovato alcun claim.</li>
<li><b>preferred_username</b>: predefinito per il tipo di IdP Microsoft identity platform (v2.0). <span class="not_support_user_sync">Non supporta la sincronizzazione degli utenti.</span></li>
<li><b>email</b>: alternativa per Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: predefinito per Microsoft Entra ID (v1.0) e gli altri tipi di IdP.</li>
<li><b>unique_name</b>: alternativa per Microsoft Entra ID (v1.0) e gli altri tipi di IdP. <span class="not_support_user_sync">Non supporta la sincronizzazione degli utenti.</span></li>
<li><b>oid</b>: alternativa se non sono presenti altri claim. Presente solo negli IdP Microsoft.</li>
<li><b>sub</b>: alternativa se non sono presenti altri claim. <span class="not_support_user_sync">Non supporta la sincronizzazione degli utenti.</span></li>
<li><b>samaccountname</b>: claim personalizzato.</li>
<li><b>Personalizzato</b>: consente all\'amministratore del sito di inserire un valore personalizzato. <span class="not_support_user_sync">Non supporta la sincronizzazione degli utenti.</span></li>
</ul>
Nota: alcune opzioni non supportano la sincronizzazione degli utenti.';
$string['binding_username_claim_help_ms_with_user_sync'] = 'Le opzioni per gli IdP Microsoft con la funzionalità di sincronizzazione degli utenti abilitata includono:
<ul>
<li><b>Scegli automaticamente</b>: utilizza la logica attuale, determinando il token in base al tipo di IdP e ricorrendo a <b>sub</b> se non viene trovato alcun claim.</li>
<li><b>email</b>: alternativa per Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: predefinito per Microsoft Entra ID (v1.0) e gli altri tipi di IdP.</li>
<li><b>oid</b>: alternativa se non sono presenti altri claim. Presente solo negli IdP Microsoft.</li>
<li><b>samaccountname</b>: claim personalizzato.</li>
</ul>';
$string['binding_username_claim_help_non_ms'] = 'Le opzioni per gli IdP non Microsoft includono:
<ul>
<li><b>Scegli automaticamente</b>: utilizza la logica attuale, determinando il token in base al tipo di IdP e ricorrendo a <b>sub</b> se non viene trovato alcun claim.</li>
<li><b>preferred_username</b></li>
<li><b>email</b></li>
<li><b>unique_name</b></li>
<li><b>sub</b></li>
<li><b>samaccountname</b></li>
<li><b>custom</b>: claim personalizzato.</li>
</ul>';
$string['binding_username_claim_help_external_id'] = 'Le opzioni per Microsoft Entra External ID includono:
<ul>
<li><b>Scegli automaticamente</b>: Usa <b>oid</b>, poi <b>sub</b>.</li>
<li><b>oid</b>: ID oggetto univoco e stabile dell\'utente nel tenant (consigliato).</li>
<li><b>sub</b></li>
<li><b>email</b>: L\'indirizzo e-mail dell\'utente. Può cambiare, interrompendo il collegamento con l\'account Moodle.</li>
<li><b>preferred_username</b>: Il nome di accesso dell\'utente. Può cambiare, interrompendo il collegamento con l\'account Moodle.</li>
<li><b>custom</b>: Claim personalizzato.</li>
</ul>
I token External ID non contengono claim aziendali come upn o samaccountname. Assicurarsi che il claim scelto sia univoco e stabile.';
$string['warning_binding_username_claim_custom_unsupported'] = 'L\'impostazione "Claim del nome utente di collegamento" è attualmente impostata su "Personalizzato", che non è supportato per il tipo di IdP configurato con la sincronizzazione degli utenti abilitata. Verificare le impostazioni <a href="{$a}">Claim del nome utente di collegamento</a>.';
$string['examplecsv'] = 'File di esempio';
$string['usernamefile'] = 'File';
$string['csvdelimiter'] = 'Separatore CSV';
$string['encoding'] = 'Codifica';
$string['rowpreviewnum'] = 'Righe da visualizzare in anteprima';
$string['upload_usernames'] = 'Aggiorna nomi utente di collegamento';
$string['update_stats_users_updated'] = '{$a} utenti aggiornati';
$string['update_stats_users_errors'] = '{$a} utenti con errori';
$string['update_error_incomplete_line'] = 'La riga non contiene i campi obbligatori.';
$string['update_error_user_not_found'] = 'Nessun utente trovato corrispondente al nome utente. Verrà tentato l\'aggiornamento dell\'utente associato manualmente.';
$string['update_error_user_not_oidc'] = 'L\'utente non utilizza il metodo di autenticazione OpenID Connect. Verrà tentato l\'aggiornamento dell\'utente associato manualmente.';
$string['update_error_invalid_new_username'] = 'Il nuovo nome utente non è valido.';
$string['update_error_user_update_failed'] = 'Aggiornamento dell\'utente non riuscito.';
$string['update_warning_email_match'] = 'L\'email corrisponde a un utente esistente.';
$string['update_success_username'] = 'Nome utente aggiornato.';
$string['update_success_token'] = 'Token aggiornato.';
$string['update_success_o365'] = 'Record di connessione a Microsoft 365 aggiornato.';
$string['update_error_nothing_updated'] = 'Non è stato aggiornato nulla.';
$string['error_invalid_upload_file'] = 'File caricato non valido.';
$string['csvline'] = 'Riga CSV';
$string['change_binding_username_claim_tool_description'] = '<p class="warning_header">Questa è una funzionalità avanzata. Un uso errato può compromettere i record degli utenti e interrompere il single sign-on (SSO).</p>
<p>Questo strumento consente agli amministratori del sito di aggiornare in blocco i seguenti record:</p>
<ul>
<li>i nomi utente degli account Moodle,</li>
<li>i nomi utente di collegamento negli ID token OpenID Connect memorizzati,</li>
<!--o365-start--><li>i record di connessione tra account Moodle e Microsoft.</li><!--o365-end-->
</ul>
<p>Deve essere utilizzato solo quando si modificano le impostazioni <b>Claim del nome utente di collegamento</b>.</p>
<p>Lo strumento accetta un semplice file CSV con due colonne:</p>
<ul>
<li><b><span class="auth_oidc_code">username</span></b>: il nome utente attuale dell\'account Moodle da aggiornare oppure, se l\'utente attuale è associato manualmente, il valore attuale del claim di collegamento.</li>
<li><b><span class="auth_oidc_code">new_username</span></b>: il valore, con distinzione tra maiuscole e minuscole, del nuovo claim del token da utilizzare come claim del nome utente di collegamento. Se l\'utente è associato automaticamente e utilizza il tipo di autenticazione OpenID Connect, questo valore in minuscolo verrà utilizzato come nome utente Moodle.</li>
</ul>
<p>Quando il file viene caricato, lo strumento esegue le seguenti azioni:</p>
<ol>
<li>Cerca un utente Moodle esistente che abbia il valore <span class="auth_oidc_code">username</span> indicato come nome utente o indirizzo email e che utilizzi il metodo di autenticazione OpenID Connect; se lo trova, imposta il nome utente dell\'utente sul valore di <span class="auth_oidc_code">new_username</span> in minuscolo.</li>
<li>Aggiorna il record del token OpenID Connect.
<ul>
<li>Se al passaggio 1 è stato trovato un utente, cerca il record del token dell\'utente nella tabella <span class="auth_oidc_code">auth_oidc_token</span> e imposta la colonna <span class="auth_oidc_code">username</span> sul valore di <span class="auth_oidc_code">new_username</span> in minuscolo e la colonna <span class="auth_oidc_code">oidcusername</span> sullo stesso valore di <span class="auth_oidc_code">new_username</span>.</li>
<li>Se non viene trovato alcun record, tenta di trovare nella tabella <span class="auth_oidc_code">auth_oidc_token</span> un record la cui colonna <span class="auth_oidc_code">oidcusername</span> corrisponda al vecchio <span class="auth_oidc_code">username</span> e lo aggiorna con <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
<!--o365-start--><li>Se il plugin <span class="auth_oidc_code">local_o365</span> è installato, aggiorna il record di connessione dell\'utente.
<ul>
<li>Se al passaggio 1 è stato trovato un utente, cerca il record di connessione dell\'utente nella tabella <span class="auth_oidc_code">local_o365_objects</span> e imposta la colonna <span class="auth_oidc_code">o365name</span> sullo stesso valore di <span class="auth_oidc_code">new_username</span>.</li>
<li>Se al passaggio 1 non è stato trovato alcun utente, tenta di trovare nella tabella <span class="auth_oidc_code">local_o365_objects</span> un record di un utente con <span class="auth_oidc_code">o365name</span> corrispondente al valore di <span class="auth_oidc_code">username</span> e lo aggiorna con il valore di <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li><!--o365-end-->
</ol>
<p>Il file di esempio riportato di seguito modificherebbe il claim del nome utente di collegamento da <span class="auth_oidc_code">upn</span> o <span class="auth_oidc_code">email</span> a <span class="auth_oidc_code">oid</span>.</p>';
$string['change_binding_username_claim_tool_result'] = 'Risultati dell\'aggiornamento';
$string['update_username_results'] = 'Risultati dell\'aggiornamento dei nomi utente';
$string['new_username'] = 'Nuovo nome utente';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
