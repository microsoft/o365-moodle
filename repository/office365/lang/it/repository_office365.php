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
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Repository Microsoft 365 - ID delle cartelle unificate';
$string['cachedef_unifiedgroupfolderids'] = 'Repository Microsoft 365 - ID delle cartelle unificate per i gruppi';
$string['configplugin'] = 'Configura il repository Microsoft 365';
$string['controlledsharelinkdesc'] = 'Copia condivisa (solo membri dell\'organizzazione)';
$string['copiedfile'] = 'Copia del file';
$string['defaultgroupsfolder'] = 'File del corso';
$string['directlinkdesc'] = 'Link diretto (autorizzazioni esistenti)';
$string['enableanonymousshare'] = 'Abilita l\'opzione "{$a}"';
$string['enableanonymousshare_help'] = 'Se selezionata, gli utenti possono scegliere di creare una copia di un file e condividerla con tutti i membri dell\'organizzazione. La copia viene memorizzata nel OneDrive dell\'utente e condivisa con tutti i membri dell\'organizzazione.

**Come funziona:**
* Crea una copia del file selezionato con il suffisso " - Shared".
* La copia viene salvata nel OneDrive dell\'utente (non nella posizione originale).
* Per la copia viene creato un link di condivisione limitato all\'organizzazione.
* Il file originale rimane invariato, con le autorizzazioni esistenti.

**Controllo dell\'accesso:**
* Solo i membri della tua organizzazione Microsoft 365 possono accedere al file.
* Chiunque nell\'organizzazione disponga del link può VISUALIZZARE il file.
* Gli utenti esterni e anonimi NON possono accedere al file.
* Il link non scade automaticamente.
* Il proprietario del file può gestire o revocare la condivisione dal proprio OneDrive.

**Quando usarla:**
* Vuoi condividere un file con tutti i membri dell\'organizzazione.
* Vuoi proteggere il file originale da modifiche accidentali.
* Lo spazio di archiviazione in Moodle è un problema.
* Il contenuto del file è adatto all\'accesso da parte di tutta l\'organizzazione.

**Note importanti:**
* Per i file di grandi dimensioni l\'operazione di copia può richiedere alcuni secondi.
* Gli utenti devono assicurarsi che il contenuto del file sia adatto alla condivisione con tutta l\'organizzazione.
* Il file copiato comparirà nel OneDrive dell\'utente con il suffisso " - Shared".
* Le modifiche apportate al file originale NON verranno riportate nella copia condivisa, e viceversa.

**Questa opzione è disabilitata per impostazione predefinita a causa dei limiti di visualizzazione e di possibili confusioni. Seleziona questa casella solo se vuoi consentire agli utenti di creare copie condivise con l\'organizzazione.**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>Nota:</strong> quando si usa l\'opzione "{$a}", viene creata una copia del file originale, condivisa con tutti i membri dell\'organizzazione. Il file originale rimane invariato. Gli utenti devono assicurarsi che il contenuto del file sia adatto all\'accesso da parte di tutta l\'organizzazione.
<br><br><strong>Limiti di visualizzazione:</strong> i file condivisi con questa opzione presentano dei limiti che dipendono dal tipo di file e dall\'opzione di visualizzazione utilizzata nelle risorse. Il comportamento varia come segue:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Opzione di visualizzazione</th>
<th>Immagini</th>
<th>File (ad es. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatica</strong></td>
<td style="background-color: #ffdddd;">Non funziona - non viene visualizzato nulla, connessione bloccata</td>
<td>Funziona - reindirizzamento a OneDrive</td>
</tr>
<tr>
<td><strong>Incorpora</strong></td>
<td>Funziona - l\'immagine viene incorporata</td>
<td style="background-color: #ffdddd;">Non funziona - l\'iframe mostra l\'errore "connessione rifiutata"</td>
</tr>
<tr>
<td><strong>Forza scaricamento</strong></td>
<td colspan="2">Funziona - reindirizzamento a OneDrive</td>
</tr>
<tr>
<td><strong>Apri</strong></td>
<td colspan="2">Funziona - reindirizzamento a OneDrive</td>
</tr>
<tr>
<td><strong>Popup</strong></td>
<td colspan="2">Funziona - apertura in finestra popup</td>
</tr>
</tbody>
</table>
Per la massima compatibilità con tutte le opzioni di visualizzazione, valuta invece di copiare il file in Moodle.</div>';
$string['enablecoursegroup'] = 'Abilita la cartella Gruppi (corsi) nel selettore file';
$string['enabledirectlink'] = 'Abilita l\'opzione "{$a}"';
$string['enabledirectlink_help'] = 'Se selezionata, gli utenti possono aggiungere un link diretto a un file nel proprio OneDrive invece di copiarlo in Moodle. Il file rimane in OneDrive e Moodle memorizza solo un link di riferimento.

**Considerazioni importanti sul controllo dell\'accesso:**
* Le autorizzazioni esistenti del file in OneDrive NON vengono modificate.
* Gli utenti che accedono al link devono disporre delle autorizzazioni appropriate in OneDrive per visualizzare il file.
* È responsabilità dell\'utente che aggiunge il link garantire le corrette autorizzazioni di accesso.
* Se le autorizzazioni in OneDrive non sono impostate correttamente, altri utenti potrebbero non riuscire ad accedere al file.

**Quando usare questa opzione:**
* I file sono già condivisi con i destinatari previsti in Microsoft 365.
* Vuoi mantenere un\'unica fonte attendibile in OneDrive.
* Lo spazio di archiviazione in Moodle è un problema.
* Le modifiche al file in OneDrive devono riflettersi in Moodle.

**Questa opzione è disabilitata per impostazione predefinita a causa dei limiti di visualizzazione e della complessità del controllo dell\'accesso. Seleziona questa casella solo se vuoi consentire agli utenti di collegare i file direttamente da OneDrive.**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>Nota:</strong> quando si usa l\'opzione "{$a}", le impostazioni di condivisione del file in OneDrive non vengono modificate. Gli utenti che aggiungono il file devono assicurarsi che le autorizzazioni del file in OneDrive siano impostate correttamente.
<br><br><strong>Limiti di visualizzazione:</strong> i file collegati con questa opzione presentano dei limiti che dipendono dal tipo di file e dall\'opzione di visualizzazione utilizzata nelle risorse. Il comportamento varia come segue:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Opzione di visualizzazione</th>
<th>Immagini</th>
<th>File (ad es. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatica</strong></td>
<td style="background-color: #ffdddd;">Non funziona - non viene visualizzato nulla, connessione bloccata</td>
<td>Reindirizzamento a OneDrive; funziona se l\'utente ha l\'autorizzazione ad accedere al file in OneDrive, altrimenti viene mostrata una pagina di accesso negato</td>
</tr>
<tr>
<td><strong>Incorpora</strong></td>
<td style="background-color: #ffdddd;">Non funziona - non viene visualizzato nulla, connessione bloccata</td>
<td style="background-color: #ffdddd;">Non funziona - nell\'iframe incorporato viene visualizzato l\'errore di connessione rifiutata</td>
</tr>
<tr>
<td><strong>Forza scaricamento</strong></td>
<td colspan="2">Reindirizzamento a OneDrive; funziona se l\'utente ha l\'autorizzazione ad accedere al file in OneDrive, altrimenti viene mostrata una pagina di accesso negato</td>
</tr>
<tr>
<td><strong>Apri</strong></td>
<td colspan="2">Reindirizzamento a OneDrive; funziona se l\'utente ha l\'autorizzazione ad accedere al file in OneDrive, altrimenti viene mostrata una pagina di accesso negato</td>
</tr>
<tr>
<td><strong>Popup</strong></td>
<td colspan="2">Apertura in finestra popup; funziona se l\'utente ha l\'autorizzazione ad accedere al file in OneDrive, altrimenti viene mostrata una pagina di accesso negato</td>
</tr>
</tbody>
</table>
Per la massima compatibilità, valuta di copiare il file in Moodle invece di usare un link diretto.</div>';
$string['enableinternal'] = 'Abilita l\'opzione "{$a}"';
$string['enableinternal_help'] = 'Se selezionata (impostazione predefinita), gli utenti possono scegliere di copiare un file da OneDrive in Moodle. Deseleziona questa opzione e abilita le opzioni "Crea un alias/scorciatoia al file" e/o "Crea un link al file sotto controllo" riportate sotto per obbligare gli utenti a collegare i file.

Deve essere abilitata almeno una delle tre opzioni di collegamento dei file.';
$string['enableonedrivegroup'] = 'Abilita la cartella Il mio OneDrive nel selettore file';
$string['enabletrendinggroup'] = 'Abilita la cartella File di tendenza intorno a me nel selettore file';

$string['errorauthoidcnotconfig'] = 'Configura il plugin di autenticazione OpenID Connect prima di provare a usare il repository Microsoft 365.';
$string['errorbadclienttype'] = 'Tipo di client non valido.';
$string['errorbadpath'] = 'Percorso errato';
$string['errorencodingreference'] = 'Impossibile codificare il riferimento al file';
$string['errornofilelinkoption'] = 'Deve essere abilitata almeno un\'opzione di collegamento dei file.';
$string['erroro365required'] = 'Questo file è attualmente disponibile solo per gli utenti Microsoft 365.';
$string['errorwhiledownload'] = 'Si è verificato un errore durante lo scaricamento del file';
$string['errorwhilesharing'] = 'Si è verificato un errore durante la creazione di un link condivisibile';

$string['file'] = 'File';
$string['filelinkingheader'] = 'Opzioni di collegamento dei file';
$string['filereferencewarning'] = 'Le impostazioni di condivisione del file in OneDrive non vengono modificate. Solo le persone che hanno già accesso al file in OneDrive possono aprire questo link.';
$string['groups'] = 'Gruppi (corsi)';
$string['invalidfilereference'] = 'Riferimento al file non valido o malformato';
$string['myfiles'] = 'Il mio OneDrive';
$string['notconfigured'] = '<p class="error">Per usare questo plugin, devi prima configurare i <a href="{$a}/admin/settings.php?section=local_o365">plugin Microsoft 365</a></p>';
$string['office365:view'] = 'Visualizzare il repository Microsoft 365';
$string['pluginname'] = 'Microsoft 365';
$string['privacy:metadata'] = 'Questo plugin comunica con l\'API Microsoft Graph (OneDrive) per conto dell\'utente corrente. Tutti i file caricati verranno inviati al server remoto.';
$string['trendingaround'] = 'File di tendenza intorno a me';
$string['upload'] = 'Carica nuovo file';
