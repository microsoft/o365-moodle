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
 * German language strings.
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
$string['settings_pageheading'] = 'Konfiguration von {$a}';
$string['settings_page_other_settings'] = 'Weitere Optionen';
$string['settings_page_application'] = 'IdP und Authentifizierung';
$string['settings_page_application_wizard'] = 'Assistent zur Anwendungskonfiguration';
$string['settings_page_binding_username_claim'] = 'Claim für den verknüpften Anmeldenamen';
$string['settings_page_change_binding_username_claim_tool'] = 'Werkzeug zum Ändern des Claims für den verknüpften Anmeldenamen';
$string['settings_page_cleanup_oidc_tokens'] = 'OpenID Connect-Tokens bereinigen';
$string['settings_page_clear_user_tokens'] = 'Nutzertokens löschen';
$string['settings_page_field_mapping'] = 'Feldzuordnungen';
$string['heading_additional_options'] = 'Zusätzliche Optionen';
$string['heading_additional_options_desc'] = '';
$string['heading_stateredirect'] = 'Fehlerseite für den Anmeldestatus';
$string['heading_stateredirect_desc'] = 'Wenn Nutzer/innen zu lange brauchen, um die Anmeldung beim Identitätsanbieter abzuschließen (zum Beispiel beim Bestätigen einer Abfrage zur Multi-Faktor-Authentifizierung), und der gespeicherte Anmeldestatus inzwischen bereinigt wurde, zeigt Moodle standardmäßig seine allgemeine Fehlerseite an. Mit den folgenden Einstellungen können Sie festlegen, wie lange der Anmeldestatus aufbewahrt wird, und statt der allgemeinen Fehlerseite eine freundlichere, anpassbare Meldung anzeigen, nach der die Nutzer/innen automatisch zur Anmeldeseite zurückgeleitet werden.';
$string['heading_user_restrictions'] = 'Nutzerbeschränkungen';
$string['heading_user_restrictions_desc'] = '';
$string['heading_sign_out'] = 'Abmeldeintegration';
$string['heading_sign_out_desc'] = '';
$string['heading_display'] = 'Anzeige';
$string['heading_display_desc'] = '';
$string['heading_debugging'] = 'Debugging';
$string['heading_debugging_desc'] = '';
$string['heading_tools'] = 'Werkzeuge';
$string['microsoftcloud'] = 'Microsoft-Cloud';
$string['microsoftcloud_help'] = 'Wählen Sie die Microsoft-Cloud aus, zu der Ihr Microsoft Entra-Mandant gehört. Die Einstellung gilt für die IdP-Typen Microsoft Entra ID und Microsoft identity platform.<br/>
Wählen Sie "Microsoft 365 betrieben von 21Vianet (China)", wenn Ihre Organisation Microsoft 365 von 21Vianet nutzt. Für die Anfragen der Plugins werden dann der Anmeldedienst und die Microsoft Graph-Endpunkte dieser Cloud verwendet, und die Standardwerte der unten stehenden Endpunkte und der Ressource richten sich danach. Bereits gespeicherte Werte für die Endpunkte, die Ressource und den Abmelde-Endpunkt werden nicht geändert. Aktualisieren Sie diese daher, falls sie noch auf die Endpunkte der globalen Cloud gesetzt sind.';
$string['microsoftcloud_global'] = 'Microsoft 365 (global)';
$string['microsoftcloud_china'] = 'Microsoft 365 betrieben von 21Vianet (China)';
$string['idptype'] = 'Typ des Identitätsanbieters (IdP)';
$string['idptype_help'] = 'Derzeit werden drei IdP-Typen unterstützt:
<ul>
<li><b>Microsoft Entra ID (v1.0)</b>: Microsoft Entra ID mit oauth2-v1.0-Endpunkten, z. B. https://login.microsoftonline.com/organizations/oauth2/authorize.</li>
<li><b>Microsoft identity platform (v2.0)</b>: Microsoft Entra ID mit oauth2-v2.0-Endpunkten, z. B. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize.</li>
<li><b>Andere</b>: jeder IdP, der nicht von Microsoft stammt.</li>
</ul>
Die Unterschiede zwischen den Optionen <b>Microsoft Entra ID (v1.0)</b> und <b>Microsoft identity platform (v2.0)</b> finden Sie unter <a href="https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison">https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison</a>.<br/>
Beim IdP <b>Microsoft identity platform (v2.0)</b> kann sich die konfigurierte Anwendung außer mit einem <b>geheimen Schlüssel</b> auch mit einem <b>Zertifikat</b> authentifizieren.<br/>
Autorisierungs- und Token-Endpunkt müssen passend zum konfigurierten IdP-Typ eingerichtet werden.';
$string['idp_type_microsoft_entra_id'] = 'Microsoft Entra ID (v1.0)';
$string['idp_type_microsoft_identity_platform'] = 'Microsoft identity platform (v2.0)';
$string['idp_type_other'] = 'Andere';
$string['settings_application_wizard_desc'] = 'Um diese Einstellungen über ein geführtes Formular mit Schritt-für-Schritt-Anleitung und Eingabeprüfung zu konfigurieren, verwenden Sie den <a href="{$a}">Assistenten zur Anwendungskonfiguration</a>.';
$string['authendpoint'] = 'Autorisierungs-Endpunkt';
$string['authendpoint_help'] = 'Die URI des zu verwendenden Autorisierungs-Endpunkts Ihres IdP.<br/>
Hinweis: Wenn die Website so konfiguriert werden soll, dass auch Nutzer/innen aus anderen Mandanten zugreifen können, darf kein mandantenspezifischer Autorisierungs-Endpunkt verwendet werden.';
$string['clientid'] = 'Anwendungs-ID';
$string['clientid_help'] = 'Die beim IdP registrierte Anwendungs-/Client-ID.';
$string['clientauthmethod'] = 'Client-Authentifizierungsmethode';
$string['clientauthmethod_help'] = '<ul>
<li>IdPs aller Typen können die Authentifizierungsmethode "<b>Geheimer Schlüssel</b>" verwenden.</li>
<li>IdPs vom Typ <b>Microsoft identity platform (v2.0)</b> können zusätzlich die Authentifizierungsmethode <b>Zertifikat</b> verwenden.</li>
</ul>';
$string['auth_method_secret'] = 'Geheimer Schlüssel';
$string['auth_method_certificate'] = 'Zertifikat';
$string['clientsecret'] = 'Geheimer Clientschlüssel';
$string['clientsecret_help'] = 'Bei der Authentifizierungsmethode <b>Geheimer Schlüssel</b> ist dies der geheime Clientschlüssel beim IdP. Bei manchen Anbietern wird er auch als Schlüssel (Key) bezeichnet.';
$string['clientprivatekey'] = 'Privater Schlüssel des Clientzertifikats';
$string['clientprivatekey_help'] = 'Bei der Authentifizierungsmethode <b>Zertifikat</b> und der Zertifikatsquelle <b>Klartext</b> ist dies der private Schlüssel des Zertifikats, mit dem sich die Anwendung beim IdP authentifiziert.';
$string['clientcert'] = 'Öffentlicher Schlüssel des Clientzertifikats';
$string['clientcert_help'] = 'Bei der Authentifizierungsmethode <b>Zertifikat</b> und der Zertifikatsquelle <b>Klartext</b> ist dies der öffentliche Schlüssel bzw. das Zertifikat, mit dem sich die Anwendung beim IdP authentifiziert.';
$string['clientcertsource'] = 'Zertifikatsquelle';
$string['clientcertsource_help'] = 'Bei der Authentifizierungsmethode <b>Zertifikat</b> legt diese Einstellung fest, woher das Zertifikat abgerufen wird.
<ul>
<li>Bei der Quelle <b>Klartext</b> muss der Inhalt der Zertifikats- bzw. Schlüsseldatei in den nachfolgenden Textfeldern eingetragen werden.</li>
<li>Bei der Quelle <b>Dateiname</b> müssen die Zertifikats- bzw. Schlüsseldateien im Ordner <b>microsoft_certs</b> im Moodle-Datenverzeichnis vorhanden sein.</li>
</ul>';
$string['cert_source_text'] = 'Klartext';
$string['cert_source_path'] = 'Dateiname';
$string['clientprivatekeyfile'] = 'Dateiname des privaten Schlüssels des Clientzertifikats';
$string['clientprivatekeyfile_help'] = 'Bei der Authentifizierungsmethode <b>Zertifikat</b> und der Zertifikatsquelle <b>Dateiname</b> ist dies der Dateiname des privaten Schlüssels, mit dem sich die Anwendung beim IdP authentifiziert. Die Datei muss sich im Ordner <b>microsoft_certs</b> im Moodle-Datenverzeichnis befinden.';
$string['clientcertfile'] = 'Dateiname des öffentlichen Schlüssels des Clientzertifikats';
$string['clientcertfile_help'] = 'Bei der Authentifizierungsmethode <b>Zertifikat</b> und der Zertifikatsquelle <b>Dateiname</b> ist dies der Dateiname des öffentlichen Schlüssels bzw. Zertifikats, mit dem sich die Anwendung beim IdP authentifiziert. Die Datei muss sich im Ordner <b>microsoft_certs</b> im Moodle-Datenverzeichnis befinden.';
$string['clientcertpassphrase'] = 'Passphrase des Clientzertifikats';
$string['clientcertpassphrase_help'] = 'Wenn der private Schlüssel des Clientzertifikats verschlüsselt ist, ist dies die Passphrase zum Entschlüsseln.';
$string['change_client_secret'] = 'Geheimen Clientschlüssel ändern';
$string['change_client_secret_desc'] = 'Aktivieren Sie dieses Kästchen, um den geheimen Clientschlüssel zu aktualisieren. Aus Sicherheitsgründen werden vorhandene geheime Schlüssel maskiert und nur die ersten 2 Zeichen angezeigt.';
$string['change_cert_passphrase'] = 'Zertifikats-Passphrase ändern';
$string['change_cert_passphrase_desc'] = 'Aktivieren Sie dieses Kästchen, um die Zertifikats-Passphrase zu aktualisieren. Aus Sicherheitsgründen werden vorhandene Passphrasen maskiert und nur die ersten 2 Zeichen angezeigt.';
$string['cfg_usepkce_key'] = 'PKCE verwenden';
$string['cfg_usepkce_desc'] = 'Beim Anmeldeablauf <b>Autorisierungscode</b> wird in der Autorisierungsanfrage eine PKCE-"code_challenge" (RFC 7636) mit der Methode S256 gesendet und beim Einlösen des Autorisierungscodes der passende "code_verifier". Microsoft Entra ID unterstützt dies. Aktivieren Sie diese Option bei anderen Anbietern nur, wenn Ihr Anbieter PKCE unterstützt, da manche Anbieter Autorisierungsanfragen mit unbekannten Parametern ablehnen.';
$string['cfg_domainhint_key'] = 'Domänenhinweis';
$string['cfg_domainhint_desc'] = 'Beim Anmeldeablauf <b>Autorisierungscode</b> wird dieser Wert als Parameter "domain_hint" übergeben. "domain_hint" wird von einigen OpenID Connect-IdPs genutzt, um Nutzer/innen die Anmeldung zu erleichtern. Erkundigen Sie sich bei Ihrem Anbieter, ob dieser Parameter unterstützt wird.';
$string['cfg_forceselectaccount_key'] = 'Kontoauswahl immer anzeigen';
$string['cfg_forceselectaccount_desc'] = 'Wenn aktiviert, werden Nutzer/innen immer gefragt, mit welchem Konto sie sich anmelden möchten, statt automatisch mit dem im Browser aktiven Konto angemeldet zu werden. Nützlich, wenn Nutzer/innen mehrere Konten haben, zum Beispiel ein Konto als Teilnehmer/in und ein Administratorkonto.<br/>
Der stille Anmeldemodus hat Vorrang: Solange er aktiviert ist, wird die Kontoauswahl bei der stillen Anmeldung nicht erzwungen.';
$string['cfg_forceredirect_key'] = 'Weiterleitung erzwingen';
$string['cfg_forceredirect_desc'] = 'Wenn aktiviert, wird die Anmeldeseite übersprungen und direkt zur OpenID Connect-Seite weitergeleitet. Kann mit dem URL-Parameter ?noredirect=1 umgangen werden.';
$string['cfg_stateexpiry_key'] = 'Ablauf des Anmeldestatus (Minuten)';
$string['cfg_stateexpiry_desc'] = 'Wie lange ein Anmeldestatus-Datensatz aufbewahrt wird, bevor der geplante Task zur Bereinigung ihn entfernt. Erhöhen Sie diesen Wert, wenn Nutzer/innen regelmäßig länger brauchen, um die Anmeldung beim Identitätsanbieter abzuschließen (zum Beispiel wegen Abfragen zur Multi-Faktor-Authentifizierung).';
$string['error_stateexpiry_min'] = 'Der Ablauf des Anmeldestatus muss mindestens 1 Minute betragen. Ein Wert von null oder weniger würde dazu führen, dass gerade laufende Anmeldungen fehlschlagen.';
$string['cfg_stateredirect_enabled_key'] = 'Freundliche Fehlerseite anzeigen';
$string['cfg_stateredirect_enabled_desc'] = 'Wenn aktiviert, wird Nutzer/innen, die zu lange für die Anmeldung beim Identitätsanbieter brauchen (sodass der gespeicherte Anmeldestatus inzwischen bereinigt wurde), statt der allgemeinen Fehlerseite von Moodle die unten stehende anpassbare Meldung angezeigt, und sie werden automatisch zur Anmeldeseite zurückgeleitet.';
$string['cfg_stateredirect_message_key'] = 'Meldung';
$string['cfg_stateredirect_message_desc'] = 'Die Meldung, die Nutzer/innen auf der freundlichen Fehlerseite angezeigt wird.';
$string['cfg_stateredirect_message_default'] = 'Bei Ihrer Anmeldung ist ein Problem aufgetreten. Höchstwahrscheinlich hat die Anmeldung zu lange gedauert (zum Beispiel beim Bestätigen einer Abfrage zur Multi-Faktor-Authentifizierung). Sie werden automatisch zur Anmeldeseite weitergeleitet, damit Sie es erneut versuchen können.';
$string['cfg_stateredirect_delay_key'] = 'Verzögerung der Weiterleitung (Sekunden)';
$string['cfg_stateredirect_delay_desc'] = 'Anzahl der Sekunden, die die obige Meldung angezeigt wird, bevor Nutzer/innen automatisch zur Anmeldeseite zurückgeleitet werden.';
$string['cfg_set_pix_key'] = 'Symbol auf der Anmeldeseite anzeigen';
$string['cfg_set_pix_desc'] = 'Wenn aktiviert, wird auf der Anmeldeseite neben dem Namen des Anbieters ein Symbol angezeigt.';
$string['cfg_icon_key'] = 'Symbol';
$string['cfg_icon_desc'] = 'Ein Symbol, das auf der Anmeldeseite neben dem Namen des Anbieters angezeigt wird.';
$string['cfg_iconalt_o365'] = 'Office 365-Symbol';
$string['cfg_iconalt_microsoft365'] = 'Microsoft 365-Logo';
$string['cfg_iconalt_openid'] = 'OpenID-Symbol';
$string['cfg_iconalt_keycloak'] = 'Keycloak-Symbol';
$string['cfg_customicon_key'] = 'Symbol "Angepasst"';
$string['cfg_customicon_desc'] = 'Wenn Sie Ihr eigenes Symbol verwenden möchten, laden Sie es hier hoch. Damit werden alle oben ausgewählten Symbole überschrieben. <br /><br /><b>Hinweise zur Verwendung von benutzerdefinierten Symbolen:</b><ul><li>Die hochgeladene Datei wird nicht skaliert. Sie wird auf der Anmeldeseite in einer festen Größe von 24x24 Pixeln angezeigt, wobei Ihr Browser sie entsprechend skaliert. Wir empfehlen daher, ein quadratisches Bild hochzuladen, um Verzerrungen zu vermeiden.</li><li>Wenn Sie ein benutzerdefiniertes Symbol hochgeladen haben und wieder eines der Standardsymbole verwenden möchten, klicken Sie im Feld oben auf das benutzerdefinierte Symbol, dann auf "Löschen", dann auf "OK" und anschließend unten in diesem Formular auf "Änderungen speichern". Das ausgewählte Standardsymbol wird nun auf der Moodle-Anmeldeseite angezeigt.</li></ul>';
$string['cfg_debugmode_key'] = 'Debugmeldungen aufzeichnen';
$string['cfg_debugmode_desc'] = 'Wenn diese Option aktiviert ist, werden die Informationen im Moodle-Protokoll aufgezeichnet, das bei der Erkennung von Problemen helfen kann.';
$string['cfg_silentloginmode_key'] = 'Stiller Anmeldemodus';
$string['cfg_silentloginmode_desc'] = 'Wenn aktiviert, versucht Moodle, Nutzer/innen über eine aktive Sitzung anzumelden, mit der sie bereits beim konfigurierten Autorisierungs-Endpunkt authentifiziert sind.<br/>
Für diese Funktion sind folgende Konfigurationen erforderlich:
<ul>
<li><b>Anmeldung erzwingen</b> (forcelogin) im Bereich <a href="{$a}" target="_blank">Website-Richtlinien</a> ist aktiviert.</li>
<li>Die oben stehende Einstellung <b>Weiterleitung erzwingen</b> (auth_oidc/forceredirect) ist aktiviert.</li>
</ul>
Damit Moodle nicht versucht, persönliche Konten oder Konten aus anderen Mandanten für die Anmeldung zu verwenden, wird außerdem empfohlen, mandantenspezifische Endpunkte statt allgemeiner Endpunkte mit Pfaden wie "common" oder "organizations" zu verwenden.<br/>
<br/>
Bei Microsoft-IdPs sieht die Nutzererfahrung folgendermaßen aus:
<ul>
<li>Wird keine aktive Nutzersitzung gefunden, wird die Moodle-Anmeldeseite angezeigt.</li>
<li>Wird genau eine aktive Nutzersitzung gefunden und hat die Person Zugriff auf die Entra ID-App (d. h. sie gehört zum selben Mandanten oder ist Gast im Mandanten), wird sie per SSO automatisch bei Moodle angemeldet.</li>
<li>Wird genau eine aktive Nutzersitzung gefunden, die Person hat aber keinen Zugriff auf die Entra ID-App (z. B. weil sie zu einem anderen Mandanten gehört oder die App eine Nutzerzuweisung erfordert und sie nicht zugewiesen ist), wird die Moodle-Anmeldeseite angezeigt.</li>
<li>Gibt es mehrere aktive Nutzersitzungen mit Zugriff auf die Entra ID-App, wird eine Seite angezeigt, auf der das Konto für die Anmeldung ausgewählt werden kann.</li>
</ul>';
$string['oidcresource'] = 'Ressource';
$string['oidcresource_help'] = 'Die OpenID Connect-Ressource, für die die Anfrage gesendet wird.<br/>
<b>Hinweis:</b> Dieser Parameter wird beim IdP-Typ <b>Microsoft identity platform (v2.0)</b> nicht unterstützt.';
$string['oidcscope'] = 'Bereich (Scope)';
$string['oidcscope_help'] = 'Der zu verwendende OIDC-Bereich (Scope).';
$string['customclaims'] = 'Benutzerdefinierte Claims';
$string['customclaims_help'] = 'Durch Leerzeichen getrennte Liste benutzerdefinierter Claim-Namen aus den Tokens Ihres Identitätsanbieters.<br/>
<b>Wichtig:</b>
<ul>
<li>Die Claims müssen in der Token-Konfiguration Ihres IdP vorhanden sein (z. B. Keycloak-Protocol-Mapper, optionale/benutzerdefinierte Claims in Microsoft Entra ID)</li>
<li>Ist ein Claim nicht im Token enthalten, wird er bei der Feldzuordnung stillschweigend übersprungen – es wird kein Fehler angezeigt</li>
<li>Bei Claim-Namen wird zwischen Groß- und Kleinschreibung unterschieden. Sie dürfen nur alphanumerische Zeichen, Bindestriche und Unterstriche enthalten</li>
<li>Ein Claim-Name darf kein reservierter Name sein, etwa ein Standard-Claim von JWT/OpenID Connect (z. B. <code>sub</code>, <code>email</code>), ein spezifischer Claim von Microsoft Entra ID (z. B. <code>oid</code>, <code>upn</code>) oder Keycloak (z. B. <code>realm_access</code>, <code>resource_access</code>) oder eine bereits vorhandene Option der Feldzuordnung</li>
<li>Der Claim <code>roles</code> (App-Rollen in Microsoft Entra ID-Tokens) und der Claim <code>groups</code> (Gruppen-IDs) sind zulässig. Sie werden in der Feldzuordnung als "roles (Token-Claim)" und "groups (Token-Claim)" aufgeführt, getrennt von den integrierten Optionen "Rollen" und "Gruppen", die Microsoft Entra-Verzeichnisrollen und Gruppennamen aus Microsoft Graph zuordnen. Claims mit einer Liste von Werten werden als kommagetrennte Liste gespeichert</li>
<li>Beispiele: <code>employee_type badge_number costCenter custom_role</code></li>
<li>Bei der Anmeldung werden benutzerdefinierte Claims immer aus dem Token gelesen, unabhängig davon, ob zusätzlich Microsoft Graph verwendet wird. Beim geplanten Task zur Nutzersynchronisierung gibt es kein Nutzertoken, aus dem gelesen werden kann. Ein benutzerdefinierter Claim wird daher nur synchronisiert, wenn sein Name zugleich eine auswählbare Nutzereigenschaft von Microsoft Graph ist, etwa ein Verzeichniserweiterungsattribut (z. B. <code>extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode</code>). Ein benutzerdefinierter Claim, den Microsoft Graph ablehnt, wird für diesen Synchronisierungslauf mit einer Warnung im Aufgabenprotokoll übersprungen, statt die gesamte Synchronisierung abzubrechen.</li>
</ul>';
$string['secretexpiryrecipients'] = 'Empfänger/innen der Benachrichtigung über den Ablauf des geheimen Schlüssels';
$string['secretexpiryrecipients_help'] = 'Eine kommagetrennte Liste von E-Mail-Adressen, an die Benachrichtigungen über den Ablauf des geheimen Schlüssels gesendet werden.<br/>
Wenn keine E-Mail-Adresse eingegeben wird, wird die Hauptadministration der Website benachrichtigt.<br/>
Standardmäßig werden ab vier Wochen vor dem Ablauf täglich Benachrichtigungen gesendet, bis der geheime Schlüssel erneuert wurde.';
$string['cfg_showbutton_key'] = 'Anmeldeschaltfläche anzeigen';
$string['cfg_showbutton_desc'] = 'Wenn deaktiviert, wird die Anmeldeschaltfläche des Anbieters auf der Anmeldeseite nicht angezeigt. Nutzer/innen können sich weiterhin über diesen Anbieter authentifizieren, indem sie direkt dessen Anmelde-URL aufrufen.';
$string['cfg_opname_key'] = 'Anzeigename des Anbieters';
$string['cfg_opname_desc'] = 'Hierbei handelt es sich um eine Bezeichnung für die Nutzer/innen, die den Typ der Anmeldedaten kennzeichnet, die sie für die Anmeldung verwenden müssen. Diese Bezeichnung wird in allen nutzerorientierten Teilen dieses Plugins zur Identifizierung Ihres Identitätsanbieters verwendet.';
$string['cfg_redirecturi_key'] = 'Weiterleitungs-URI';
$string['cfg_redirecturi_desc'] = 'Dies ist die URI, die als "Weiterleitungs-URI" registriert werden muss. Ihr OpenID Connect-IdP sollte danach fragen, wenn Sie Moodle dort als Client registrieren. <br /><b>HINWEIS:</b> Sie müssen diese Zeichenfolge in Ihrem OpenID Connect-IdP *genau* so eingeben, wie sie hier angezeigt wird. Jede Abweichung führt dazu, dass keine Anmeldungen mit OpenID Connect möglich sind.';
$string['tokenendpoint'] = 'Token-Endpunkt';
$string['tokenendpoint_help'] = 'Die URI des zu verwendenden Token-Endpunkts Ihres IdP.<br/>
Hinweis: Wenn die Website so konfiguriert werden soll, dass auch Nutzer/innen aus anderen Mandanten zugreifen können, darf kein mandantenspezifischer Token-Endpunkt verwendet werden.';
$string['cfg_userrestrictions_key'] = 'Nutzerbeschränkungen';
$string['cfg_userrestrictions_desc'] = 'Nur Nutzer/innen, die bestimmte Beschränkungen erfüllen, dürfen sich anmelden. <br /><b>So verwenden Sie Nutzerbeschränkungen: </b> <ul><li>Geben Sie ein Muster als <a href="https://en.wikipedia.org/wiki/Regular_expression">regulären Ausdruck</a> ein, das auf die Anmeldenamen der zugelassenen Nutzer/innen passt.</li><li>Geben Sie ein Muster pro Zeile ein.</li><li>Wenn Sie mehrere Muster eingeben, werden Nutzer/innen zugelassen, wenn sie auf IRGENDEINES der Muster passen.</li><li>Das Zeichen "/" muss mit "\\" maskiert werden.</li><li>Wenn Sie oben keine Beschränkungen eingeben, akzeptiert Moodle alle Nutzer/innen, die sich beim OpenID Connect-IdP anmelden können.</li><li>Nutzer/innen, die auf keines der eingegebenen Muster passen, können sich nicht mit OpenID Connect anmelden.</li></ul>';
$string['cfg_userrestrictionscasesensitive_key'] = 'Groß-/Kleinschreibung bei Nutzerbeschränkungen beachten';
$string['cfg_userrestrictionscasesensitive_desc'] = 'Legt fest, ob die Option "/i" des regulären Ausdrucks beim Abgleich der Nutzerbeschränkungen verwendet wird.<br/>Wenn aktiviert, wird bei allen Prüfungen der Nutzerbeschränkungen zwischen Groß- und Kleinschreibung unterschieden. Hinweis: Wenn deaktiviert, werden Muster zur Groß-/Kleinschreibung ignoriert.';
$string['heading_dummy_email'] = 'Platzhalter-E-Mail-Adressen';
$string['heading_dummy_email_desc'] = 'Moodle verlangt für jedes Nutzerkonto eine E-Mail-Adresse, Konten in Microsoft Entra ID müssen jedoch keine haben. Mit den folgenden Einstellungen kann Moodle für Nutzer/innen ohne verwendbare E-Mail-Adresse vom IdP eine nicht zustellbare Platzhalteradresse erzeugen, statt die E-Mail-Adresse leer zu lassen.';
$string['cfg_generatedummyemail_key'] = 'Platzhalter-E-Mail-Adressen erzeugen';
$string['cfg_generatedummyemail_desc'] = 'Wenn aktiviert und Nutzer/innen vom IdP weder eine E-Mail-Adresse noch einen verwendbaren Benutzerprinzipalnamen im E-Mail-Format erhalten, erzeugt Moodle für sie eine Platzhalter-E-Mail-Adresse aus ihrem Microsoft-Benutzerprinzipalnamen (oder der Objekt-ID, falls kein Benutzerprinzipalname verfügbar ist) und der unten konfigurierten Domäne, statt die E-Mail-Adresse leer zu lassen. Dies gilt sowohl bei der Anmeldung als auch bei der Bereitstellung durch den Task zur Nutzersynchronisierung.';
$string['cfg_dummyemaildomain_key'] = 'Domäne für Platzhalter-E-Mail-Adressen';
$string['cfg_dummyemaildomain_desc'] = 'Die Domäne, die beim Erzeugen von Platzhalter-E-Mail-Adressen verwendet wird, zum Beispiel "example.test". Verwenden Sie eine Domäne, die keine E-Mails empfangen kann, damit erzeugte Adressen niemals mit einer echten, zustellbaren Adresse verwechselt werden können.';
$string['cfg_signoffintegration_key'] = 'Single Sign-Out (von Moodle zum IdP)';
$string['cfg_signoffintegration_desc'] = 'Wenn diese Option aktiviert ist und sich Moodle-Nutzer/innen, die mit dem konfigurierten IdP verbunden sind, von Moodle abmelden, sendet die Integration eine Anfrage an den unten stehenden Abmelde-Endpunkt, um sie auch beim IdP abzumelden.<br/>
Hinweis: Für die Integration mit Microsoft Entra ID muss die URL der Moodle-Website ({$a}) als Weiterleitungs-URI in der Microsoft Entra ID-App hinzugefügt werden, die für die Integration von Moodle und Microsoft 365 erstellt wurde.';
$string['cfg_logoutendpoint_key'] = 'Abmelde-Endpunkt des IdP';
$string['cfg_logoutendpoint_desc'] = 'Die URI des zu verwendenden Abmelde-Endpunkts Ihres IdP.';
$string['cfg_frontchannellogouturl_key'] = 'Front-Channel-Abmelde-URL';
$string['cfg_frontchannellogouturl_desc'] = 'Dies ist die URL, die Ihr IdP aufrufen muss, wenn er Nutzer/innen von Moodle abmelden möchte.<br/>
Bei Microsoft Entra ID / Microsoft identity platform heißt diese Einstellung "Front-channel logout URL" und kann in der Microsoft Entra ID-App konfiguriert werden.';
$string['cfg_field_mapping_desc'] = 'Daten des Nutzerprofils können vom OpenID Connect-IdP nach Moodle übernommen werden. Welche entfernten Felder zugeordnet werden können, hängt stark vom IdP-Typ ab.<br/>
<ul>
<li>Einige grundlegende Profilfelder stehen bei allen IdP-Typen über die Claims des Zugriffstokens und des ID-Tokens zur Verfügung.</li>
<li>Wenn ein Microsoft-IdP-Typ konfiguriert ist (v1.0 oder v2.0), können weitere Profildaten über Graph-API-Aufrufe bereitgestellt werden, indem das <a href="https://moodle.org/plugins/local_o365">Microsoft 365-Integrations-Plugin (local_o365)</a> installiert und konfiguriert wird.</li>
<li>Wenn im Plugin local_o365 die SDS-Profilsynchronisierung aktiviert ist, können bestimmte Profilfelder von SDS nach Moodle synchronisiert werden. Dies geschieht nur bei Ausführung des geplanten Tasks "Mit SDS synchronisieren", nicht jedoch bei Ausführung des geplanten Tasks "Nutzer/innen aus Microsoft Entra ID synchronisieren" oder bei der Anmeldung.</li>
</ul>

Welche Claims im ID- und im Zugriffstoken verfügbar sind, hängt vom IdP-Typ ab, die meisten IdPs erlauben jedoch eine gewisse Anpassung der Claims. Dokumentation zu Microsoft-IdPs finden Sie unter den folgenden Links:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Claims des Zugriffstokens</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">Claims des ID-Tokens</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Konfiguration optionaler Claims</a>: Hinweis: "Email" ist beim IdP-Typ Microsoft Entra ID (v1.0) ein optionaler Claim.</li>
</ul>';

$string['cfg_cleanupoidctokens_key'] = 'OpenID Connect-Tokens bereinigen';
$string['cfg_cleanupoidctokens_desc'] = 'Wenn Nutzer/innen Probleme bei der Anmeldung mit ihrem Microsoft 365-Konto haben, versuchen Sie, die OpenID Connect-Tokens zu bereinigen. Dabei werden verwaiste und unvollständige Tokens entfernt, die Fehler verursachen können. WARNUNG: Dies kann laufende Anmeldungen unterbrechen. Führen Sie es daher am besten während einer Wartungszeit durch.';
$string['settings_section_basic'] = 'Grundeinstellungen';
$string['settings_section_authentication'] = 'Authentifizierung';
$string['settings_section_endpoints'] = 'Endpunkte';
$string['settings_section_other_params'] = 'Weitere Parameter';
$string['settings_section_secret_expiry_notification'] = 'Benachrichtigung über den Ablauf des geheimen Schlüssels';
$string['application_updated'] = 'Die Anwendungseinstellungen für OpenID Connect wurden aktualisiert.';
$string['application_updated_microsoft'] = 'Die Anwendungseinstellung für OpenID Connect wurde aktualisiert.<br/>
<span class="warning" style="color: red;">Wenn die Einstellung "Typ des Identitätsanbieters (IdP)" oder "Client-Authentifizierungsmethode" geändert wurde, muss ein/e Microsoft Entra ID-Administrator/in auf der Konfigurationsseite der Microsoft 365-Integration erneut <b>Administratorzustimmung erteilen</b> und <b>Einrichtung überprüfen</b> ausführen.</span>';
$string['application_updated_microsoft_notify'] = 'Die Anwendungseinstellung für OpenID Connect wurde aktualisiert.<br/>
<span class="warning" style="color: red;">Wenn die Einstellung "Typ des Identitätsanbieters (IdP)" oder "Client-Authentifizierungsmethode" geändert wurde, muss ein/e Microsoft Entra ID-Administrator/in auf der <a href="{$a}">Konfigurationsseite der Microsoft 365-Integration</a> erneut <b>Administratorzustimmung erteilen</b> und <b>Einrichtung überprüfen</b> ausführen.</span>';
$string['application_not_changed'] = 'Die Anwendungseinstellung für OpenID Connect wurde nicht geändert.';

$string['event_debug'] = 'Debug-Meldung';

$string['task_cleanup_oidc_state_and_token'] = 'OIDC-Status und ungültige Tokens bereinigen';
$string['task_cleanup_oidc_sid'] = 'OIDC-SID-Datensätze bereinigen';

$string['errorauthdisconnectemptypassword'] = 'Das Kennwort darf nicht leer sein.';
$string['errorauthdisconnectemptyusername'] = 'Der Anmeldename darf nicht leer sein';
$string['errorauthdisconnectusernameexists'] = 'Dieser Anmeldename wurde bereits verwendet. Bitte wählen Sie einen anderen Anmeldenamen.';
$string['errorauthdisconnectnewmethod'] = 'Anmeldemethode verwenden';
$string['errorauthdisconnectinvalidmethod'] = 'Ungültige Anmeldemethode empfangen.';
$string['errorauthdisconnectifmanual'] = 'Wenn Sie die manuelle Anmeldemethode verwenden, geben Sie Ihre Anmeldedaten unten ein.';
$string['errorauthgeneral'] = 'Bei Ihrer Anmeldung ist ein Problem aufgetreten. Bitte wenden Sie sich an Ihre Administration.';
$string['errorauthinvalididtoken'] = 'Ungültigen id_token empfangen.';
$string['errorauthloginfailednouser'] = 'Ungültige Anmeldung: Sie haben sich als "{$a}" angemeldet, aber auf dieser Website gibt es kein passendes Konto, und neue Konten können nicht automatisch angelegt werden. Bitte wenden Sie sich an die Administration der Website. Wenn Sie mehrere Konten haben, wählen Sie "Weiter", um sich mit einem anderen Konto anzumelden.';
$string['errorauthloginfaileddupemail'] = 'Ungültige Anmeldung: Ein vorhandenes Konto in diesem Moodle hat dieselbe E-Mail-Adresse wie das Konto, das Sie anlegen möchten, und die Einstellung "Konten mit gleicher E-Mail-Adresse erlauben" (allowaccountssameemail) ist deaktiviert.';
$string['errorauthmfarequired'] = 'Microsoft verlangt eine Multi-Faktor-Authentifizierung, um Ihre Anmeldung abzuschließen, diese konnte jedoch nicht abgeschlossen werden. Bitte versuchen Sie es erneut oder melden Sie sich in einer neuen Browsersitzung bei Microsoft 365 an und schließen Sie die Abfrage zur Multi-Faktor-Authentifizierung ab.';
$string['errorauthnoauthcode'] = 'Vom Identitätsserver wurde kein Autorisierungscode empfangen. Weitere Informationen finden Sie möglicherweise in den Fehlerprotokollen.';
$string['errorauthnocredsandendpoints'] = 'Bitte konfigurieren Sie die Client-Anmeldedaten und Endpunkte für OpenID Connect.';
$string['errorauthnoidtoken'] = 'OpenID Connect-id_token wurde nicht empfangen.';
$string['errorauthnoaccesstoken'] = 'Zugriffstoken wurde nicht empfangen.';
$string['errorauthunknownstate'] = 'Unbekannter Status.';
$string['errorauthuseralreadyconnected'] = 'Sie sind bereits mit einem anderen OpenID Connect-Nutzerkonto verbunden.';
$string['errorauthuserconnectedtodifferent'] = 'Das authentifizierte OpenID Connect-Nutzerkonto ist bereits mit einem Moodle-Nutzerkonto verbunden.';
$string['errorbadloginflow'] = 'Ungültiger Authentifizierungstyp angegeben. Hinweis: Wenn Sie diese Meldung kurz nach einer Installation oder einem Upgrade erhalten, leeren Sie bitte den Moodle-Cache.';
$string['errorjwtbadpayload'] = 'JWT-Payload konnte nicht gelesen werden.';
$string['errorjwtcouldnotreadheader'] = 'JWT-Kopf konnte nicht gelesen werden.';
$string['errorjwtempty'] = 'Empfangener JWT ist leer oder enthält keine Zeichenfolge.';
$string['errorjwtinvalidheader'] = 'Ungültiger JWT-Kopf';
$string['errorjwtmalformed'] = 'Empfangener JWT ist nicht wohlgeformt.';
$string['errorjwtunsupportedalg'] = 'JWS-Alg. oder JWE wird nicht unterstützt.';
$string['erroroidcnotenabled'] = 'Das OpenID Connect-Authentifizierungs-Plugin ist nicht aktiviert.';
$string['errornodisconnectionauthmethod'] = 'Die Verbindung kann nicht getrennt werden, da es kein aktiviertes Authentifizierungs-Plugin gibt, auf das zurückgegriffen werden kann (weder die vorherige Anmeldemethode der Person noch die manuelle Anmeldemethode).';
$string['erroroidcclientinvalidendpoint'] = 'Empfangene Endpunkt-URI ist ungültig.';
$string['erroroidcclientnocreds'] = 'Legen Sie die Client-Anmeldedaten mit setcreds fest.';
$string['erroroidcclientnoauthendpoint'] = 'Kein Autorisierungsendpunkt festgelegt. Legen Sie ihn mit $this->setendpoints fest.';
$string['erroroidcclientnotokenendpoint'] = 'Kein Token-Endpunkt festgelegt. Legen Sie ihn mit $this->setendpoints fest.';
$string['errorrestricted'] = 'Auf dieser Website gelten Beschränkungen dafür, welche Nutzer/innen sich mit OpenID Connect anmelden können. Diese Beschränkungen verhindern derzeit, dass Sie diesen Anmeldeversuch abschließen.';
$string['errorucpinvalidaction'] = 'Empfangene Aktion ist ungültig.';
$string['erroroidccall'] = 'Fehler in OpenID Connect. Weitere Informationen finden Sie in den Protokollen.';
$string['erroroidccall_message'] = 'Fehler in OpenID Connect: {$a}';
$string['errorinvalidredirect_message'] = 'Die URL, zu der Sie weitergeleitet werden sollen, existiert nicht.';
$string['errorinvalidcertificatesource'] = 'Ungültige Zertifikatsquelle';
$string['error_invalid_client_authentication_method'] = 'Ungültige Client-Authentifizierungsmethode';
$string['error_empty_client_secret'] = 'Der geheime Clientschlüssel darf bei der Authentifizierungsmethode "Geheimer Schlüssel" nicht leer sein';
$string['error_empty_client_private_key'] = 'Der private Schlüssel des Clientzertifikats darf bei der Authentifizierungsmethode "Zertifikat" nicht leer sein';
$string['error_empty_client_cert'] = 'Der öffentliche Schlüssel des Clientzertifikats darf bei der Authentifizierungsmethode "Zertifikat" nicht leer sein';
$string['error_empty_client_private_key_file'] = 'Die Datei mit dem privaten Schlüssel des Clientzertifikats darf bei der Authentifizierungsmethode "Zertifikat" nicht leer sein';
$string['error_empty_client_cert_file'] = 'Die Datei mit dem öffentlichen Schlüssel des Clientzertifikats darf bei der Authentifizierungsmethode "Zertifikat" nicht leer sein';
$string['error_endpoint_mismatch_auth_endpoint'] = 'Der konfigurierte Autorisierungs-Endpunkt passt nicht zum konfigurierten IdP-Typ. Verwenden Sie für "Microsoft Entra ID (v1.0)" einen v1.0-Endpunkt (z. B. https://login.microsoftonline.com/organizations/oauth2/authorize). Verwenden Sie für "Microsoft identity platform (v2.0)" einen v2.0-Endpunkt (z. B. https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize).';
$string['error_endpoint_mismatch_token_endpoint'] = 'Der konfigurierte Token-Endpunkt passt nicht zum konfigurierten IdP-Typ. Verwenden Sie für "Microsoft Entra ID (v1.0)" einen v1.0-Endpunkt (z. B. https://login.microsoftonline.com/organizations/oauth2/token). Verwenden Sie für "Microsoft identity platform (v2.0)" einen v2.0-Endpunkt (z. B. https://login.microsoftonline.com/organizations/oauth2/v2.0/token).';
$string['error_tenant_specific_endpoint_required'] = 'Beim IdP-Typ "Microsoft identity platform (v2.0)" und der Authentifizierungsmethode "Zertifikat" ist ein mandantenspezifischer Endpunkt (d. h. nicht common/organizations/consumers) erforderlich.';
$string['error_empty_oidcresource'] = 'Die Ressource darf bei Microsoft Entra ID (v1.0) oder anderen IdP-Typen nicht leer sein.';
$string['error_invalid_custom_claim'] = 'Ungültige(r) Name(n) benutzerdefinierter Claims: {$a}. Namen benutzerdefinierter Claims dürfen nur alphanumerische Zeichen, Bindestriche und Unterstriche enthalten und dürfen kein reservierter Claim-Name (z. B. ein Standard-Claim von JWT/OpenID Connect oder ein spezifischer Claim von Microsoft Entra ID oder Keycloak) und keine bereits vorhandene Option der Feldzuordnung sein.';
$string['error_masked_secret_not_changed'] = 'Bitte geben Sie einen neuen Wert ein oder deaktivieren Sie das Kontrollkästchen "Ändern", um den aktuellen Wert beizubehalten.';
$string['error_secretexpiryrecipients_invalid'] = 'Die folgenden Empfänger/innen der Benachrichtigung über den Ablauf des geheimen Schlüssels sind keine gültigen E-Mail-Adressen: {$a}';
$string['auth_settings_validation_error'] = 'Ungültige Authentifizierungseinstellungen erkannt. Die folgenden Konfigurationsprobleme müssen behoben werden, damit die Authentifizierung erfolgreich ist:';
$string['errorupnchangeisnotsupported'] = 'Der UPN Ihres Microsoft-Kontos hat sich geändert. Bitte wenden Sie sich an Ihre Administration, um Ihr Moodle-Konto zu aktualisieren.';
$string['erroruserwithusernamealreadyexists'] = 'Beim Umbenennen Ihres Moodle-Kontos ist ein Fehler aufgetreten. Es gibt bereits ein Moodle-Konto mit dem neuen Anmeldenamen. Bitten Sie die Administration Ihrer Website, dies zuerst zu beheben.';
$string['error_no_response_available'] = 'Keine Antworten verfügbar.';

$string['eventuserauthed'] = 'Nutzer/in wurde mit OpenID Connect autorisiert.';
$string['eventusercreated'] = 'Nutzer/in wurde mit OpenID Connect erstellt.';
$string['eventuserconnected'] = 'Nutzer/in ist mit OpenID Connect verbunden.';
$string['eventuserloggedin'] = 'Nutzer/in wurde mit OpenID Connect angemeldet.';
$string['eventuserdisconnected'] = 'Nutzer/in ist von OpenID Connect getrennt.';
$string['eventuserrenameattempt'] = 'Das Plugin auth_oidc hat versucht, ein Nutzerkonto umzubenennen';

$string['oidc:manageconnection'] = 'OpenID Connect-Verbindung herstellen und trennen';
$string['oidc:manageconnectionconnect'] = 'OpenID Connect-Verbindung herstellen';
$string['oidc:manageconnectiondisconnect'] = 'OpenID Connect-Verbindung trennen';

$string['privacy:metadata:auth_oidc'] = 'OpenID Connect-Authentifizierung';
$string['privacy:metadata:auth_oidc_prevlogin'] = 'Vorherige Anmeldemethoden zum Rückgängigmachen von Microsoft 365-Verbindungen';
$string['privacy:metadata:auth_oidc_prevlogin:userid'] = 'Die ID des Moodle-Nutzerkontos';
$string['privacy:metadata:auth_oidc_prevlogin:method'] = 'Die vorherige Anmeldemethode';
$string['privacy:metadata:auth_oidc_prevlogin:password'] = 'Das vorherige (verschlüsselte) Kennwortfeld des Nutzerkontos.';
$string['privacy:metadata:auth_oidc_token'] = 'OpenID Connect-Tokens';
$string['privacy:metadata:auth_oidc_token:oidcuniqid'] = 'Die eindeutige OIDC-Nutzerkennung.';
$string['privacy:metadata:auth_oidc_token:username'] = 'Der Anmeldename des Moodle-Nutzerkontos';
$string['privacy:metadata:auth_oidc_token:userid'] = 'Die Nutzer-ID des Moodle-Nutzerkontos';
$string['privacy:metadata:auth_oidc_token:oidcusername'] = 'Der Anmeldename des OIDC-Nutzerkontos';
$string['privacy:metadata:auth_oidc_token:useridentifier'] = 'Die Nutzerkennung des OIDC-Nutzerkontos';
$string['privacy:metadata:auth_oidc_token:scope'] = 'Der Bereich (Scope) des Tokens';
$string['privacy:metadata:auth_oidc_token:tokenresource'] = 'Die Ressource des Tokens';
$string['privacy:metadata:auth_oidc_token:authcode'] = 'Der Autorisierungscode für das Token';
$string['privacy:metadata:auth_oidc_token:token'] = 'Das Token';
$string['privacy:metadata:auth_oidc_token:expiry'] = 'Der Ablaufzeitpunkt des Tokens';
$string['privacy:metadata:auth_oidc_token:refreshtoken'] = 'Das Aktualisierungstoken';
$string['privacy:metadata:auth_oidc_token:idtoken'] = 'Das ID-Token';
$string['privacy:metadata:auth_oidc_sid'] = 'Sitzungskennungen (sid) des IdP, mit denen verbundene Moodle-Nutzerkonten gefunden werden, wenn der IdP ein SLO auslöst';
$string['privacy:metadata:auth_oidc_sid:userid'] = 'Die ID des Moodle-Nutzerkontos';
$string['privacy:metadata:auth_oidc_sid:sid'] = 'Die Sitzungskennung (sid) des IdP';
$string['privacy:metadata:auth_oidc_sid:timecreated'] = 'Der Zeitpunkt, zu dem die Zuordnung erstellt wurde';
$string['privacy:metadata:auth_oidc_sid:sessionid'] = 'Die Moodle-Sitzungs-ID, die beim Erstellen der Zuordnung aktiv war';
$string['privacy:metadata:auth_oidc_sid:iss'] = 'Der Aussteller (Claim iss) des id_token, aus dem die Zuordnung erstellt wurde';

// In the following strings, $a refers to a customizable name for the identity manager. For example, this could be
// "Microsoft 365", "OpenID Connect", etc.
$string['ucp_general_intro'] = 'Hier können Sie Ihre Verbindung mit {$a} verwalten. Ist die Option aktiviert, können Sie sich mit Ihrem {$a}-Konto statt mit einem separaten Anmeldenamen und Kennwort bei Moodle anmelden. Sobald die Verbindung besteht, müssen Sie sich keinen Anmeldenamen und kein Kennwort für Moodle mehr merken. Die gesamte Anmeldung wird von {$a} durchgeführt.';
$string['ucp_login_start'] = 'Mit {$a} bei Moodle anmelden';
$string['ucp_login_start_desc'] = 'Damit wird Ihr Konto umgeschaltet und es wird {$a} für die Anmeldung in Moodle verwendet. Sobald diese Option aktiviert ist, melden Sie sich mit Ihren {$a}-Anmeldedaten an. Ihr aktueller Anmeldename und das Kennwort von Moodle funktionieren nicht mehr. Sie können Ihr Konto jederzeit trennen und zur normalen Anmeldung zurückkehren.';
$string['ucp_login_stop'] = '{$a} nicht mehr zur Anmeldung bei Moodle verwenden';
$string['ucp_login_stop_desc'] = 'Derzeit verwenden Sie {$a} für die Anmeldung bei Moodle. Wenn Sie auf "{$a} nicht mehr zur Anmeldung bei Moodle verwenden" klicken, wird Ihr Moodle-Konto von {$a} getrennt. Sie können sich dann nicht mehr mit Ihrem {$a}-Konto bei Moodle anmelden. Sie werden aufgefordert, einen Anmeldenamen und ein Kennwort zu erstellen. Danach können Sie sich direkt bei Moodle anmelden.';
$string['ucp_login_status'] = '{$a}-Anmeldung ist:';
$string['ucp_status_enabled'] = 'Aktiviert';
$string['ucp_status_disabled'] = 'Deaktiviert';
$string['ucp_disconnect_title'] = '{$a} Trennung';
$string['ucp_disconnect_details'] = 'Damit wird Ihr Moodle-Konto von {$a} getrennt. Sie müssen einen Anmeldenamen und ein Kennwort erstellen, um sich bei Moodle anzumelden.';
$string['ucp_title'] = '{$a} Verwaltung';
$string['ucp_o365accountconnected'] = 'Dieses Microsoft 365-Konto ist bereits mit einem anderen Moodle-Konto verbunden.';

// Clean up OIDC tokens.
$string['cleanup_oidc_tokens'] = 'OpenID Connect-Tokens bereinigen';
$string['unmatched'] = 'Nicht zugeordnet';
$string['delete_token'] = 'Token löschen';
$string['mismatched'] = 'Abweichend';
$string['na'] = 'k. A.';
$string['mismatched_details'] = 'Der Token-Datensatz enthält den Anmeldenamen "{$a->tokenusername}"; das zugeordnete Moodle-Nutzerkonto hat den Anmeldenamen "{$a->moodleusername}".';
$string['delete_token_and_reference'] = 'Token und Verweis löschen';
$string['table_token_id'] = 'ID des Token-Datensatzes';
$string['table_oidc_username'] = 'OIDC-Anmeldename';
$string['table_oidc_unique_identifier'] = 'Eindeutige OIDC-Kennung';
$string['table_token_unique_id'] = 'Eindeutige OIDC-ID';
$string['table_matching_status'] = 'Zuordnungsstatus';
$string['table_matching_details'] = 'Details';
$string['table_action'] = 'Aktion';
$string['token_deleted'] = 'Das Token wurde erfolgreich gelöscht';
$string['no_token_to_cleanup'] = 'Es gibt keine OIDC-Tokens zum Bereinigen.';

$string['errorusermatched'] = 'Das Microsoft 365-Konto "{$a->entraidupn}" ist bereits dem Moodle-Nutzerkonto "{$a->username}" zugeordnet. Um die Verbindung abzuschließen, melden Sie sich zuerst mit diesem Moodle-Nutzerkonto an und folgen Sie den Anweisungen im Microsoft-Block.';

// User mapping options.
$string['update_oncreate_and_onlogin'] = 'Beim Anlegen und bei jeder Anmeldung';
$string['update_oncreate_and_onlogin_and_usersync'] = 'Beim Anlegen, bei jeder Anmeldung und bei jedem Lauf des Tasks zur Nutzersynchronisierung';
$string['update_oncreate_and_usersync'] = 'Beim Anlegen und bei jedem Lauf des Tasks zur Nutzersynchronisierung';
$string['update_onlogin_and_usersync'] = 'Bei jeder Anmeldung und bei jedem Lauf des Tasks zur Nutzersynchronisierung';
$string['upgradeoidcuniqidtoolong'] = 'Die Aktualisierung kann nicht fortgesetzt werden: Einige Datensätze in auth_oidc_token haben eine oidcuniqid mit mehr als 200 Zeichen, die durch die neue Spaltenlänge abgeschnitten würde. Bitte löschen Sie diese Token-Datensätze und führen Sie die Aktualisierung erneut aus.';

// Remote fields.
$string['settings_fieldmap_feild_not_mapped'] = '(nicht zugeordnet)';
$string['settings_fieldmap_field_bindingusernameclaim'] = 'Claim für den verknüpften Anmeldenamen (kann nur bei der Anmeldung zugeordnet werden)';
$string['settings_fieldmap_field_city'] = 'Stadt';
$string['settings_fieldmap_field_companyName'] = 'Firmenname';
$string['settings_fieldmap_field_objectId'] = 'Objekt-ID';
$string['settings_fieldmap_field_country'] = 'Land';
$string['settings_fieldmap_field_department'] = 'Abteilung';
$string['settings_fieldmap_field_displayName'] = 'Anzeigename';
$string['settings_fieldmap_field_surname'] = 'Nachname';
$string['settings_fieldmap_field_faxNumber'] = 'Faxnummer';
$string['settings_fieldmap_field_telephoneNumber'] = 'Telefonnummer';
$string['settings_fieldmap_field_givenName'] = 'Vorname';
$string['settings_fieldmap_field_jobTitle'] = 'Position';
$string['settings_fieldmap_field_mail'] = 'E-Mail';
$string['settings_fieldmap_field_mobile'] = 'Mobiltelefon';
$string['settings_fieldmap_field_postalCode'] = 'Postleitzahl';
$string['settings_fieldmap_field_preferredLanguage'] = 'Sprache';
$string['settings_fieldmap_field_state'] = 'Bundesland';
$string['settings_fieldmap_field_streetAddress'] = 'Straße und Hausnummer';
$string['settings_fieldmap_field_userPrincipalName'] = 'Benutzerprinzipalname';
$string['settings_fieldmap_field_employeeId'] = 'Personalnummer';
$string['settings_fieldmap_field_employeeType'] = 'Mitarbeitertyp';
$string['settings_fieldmap_field_accountEnabled'] = 'Konto aktiviert';
$string['settings_fieldmap_field_businessPhones'] = 'Telefon (geschäftlich)';
$string['settings_fieldmap_field_mobilePhone'] = 'Mobiltelefon';
$string['settings_fieldmap_field_officeLocation'] = 'Büro';
$string['settings_fieldmap_field_preferredName'] = 'Bevorzugter Name';
$string['settings_fieldmap_field_manager'] = 'Name der/des Vorgesetzten';
$string['settings_fieldmap_field_manager_email'] = 'E-Mail der/des Vorgesetzten';
$string['settings_fieldmap_field_teams'] = 'Teams';
$string['settings_fieldmap_field_groups'] = 'Gruppen';
$string['settings_fieldmap_field_roles'] = 'Rollen';
$string['settings_fieldmap_field_tokenclaim'] = '{$a} (Token-Claim)';
$string['settings_fieldmap_field_onPremisesSamAccountName'] = 'Lokaler SAM-Kontoname';
$string['settings_fieldmap_field_extensionattribute'] = 'Erweiterungsattribut {$a}';
$string['settings_fieldmap_field_sds_school_id'] = 'SDS-Schul-ID ({$a})';
$string['settings_fieldmap_field_sds_school_name'] = 'SDS-Schulname ({$a})';
$string['settings_fieldmap_field_sds_school_role'] = 'SDS-Schulrolle ("Student" oder "Teacher")';
$string['settings_fieldmap_field_sds_student_externalId'] = 'Externe ID des SDS-Schülers/der SDS-Schülerin';
$string['settings_fieldmap_field_sds_student_birthDate'] = 'Geburtsdatum des SDS-Schülers/der SDS-Schülerin';
$string['settings_fieldmap_field_sds_student_grade'] = 'Klassenstufe des SDS-Schülers/der SDS-Schülerin';
$string['settings_fieldmap_field_sds_student_graduationYear'] = 'Abschlussjahr des SDS-Schülers/der SDS-Schülerin';
$string['settings_fieldmap_field_sds_student_studentNumber'] = 'SDS-Schülernummer';
$string['settings_fieldmap_field_sds_teacher_externalId'] = 'Externe ID der SDS-Lehrkraft';
$string['settings_fieldmap_field_sds_teacher_teacherNumber'] = 'SDS-Lehrernummer';

// Binding username claim options.
$string['binding_username_claim_warning'] = 'Dies ist eine erweiterte Funktion. In den meisten Fällen sollte die Einstellung auf "Automatisch wählen" bleiben; eine falsche Konfiguration kann Nutzerdatensätze beeinträchtigen und das Single Sign-On (SSO) stören.';
$string['binding_username_auto'] = 'Automatisch wählen';
$string['binding_username_custom'] = 'Benutzerdefiniert';
$string['bindingusernameclaim'] = 'Claim für den verknüpften Anmeldenamen';
$string['customclaimname'] = 'Name des benutzerdefinierten Claims';
$string['customclaimname_description'] = 'Dieses Feld wird nur verwendet, wenn die Einstellung <b>Claim für den verknüpften Anmeldenamen</b> auf <b>Benutzerdefiniert</b> gesetzt ist.';
$string['binding_username_claim_tool_link_desc'] = 'Um den Claim für den verknüpften Anmeldenamen bei vorhandenen Nutzer/innen zu aktualisieren, verwenden Sie das <a href="{$a}">Werkzeug zum Ändern des Claims für den verknüpften Anmeldenamen</a>.';
$string['cleanup_oidc_tokens_link_desc'] = 'Um veraltete OpenID Connect-Tokens zu bereinigen, verwenden Sie das Werkzeug <a href="{$a}">OpenID Connect-Tokens bereinigen</a>.';
$string['clear_user_tokens_link_desc'] = 'Um die gespeicherten Tokens aller oder ausgewählter Nutzer/innen zu entfernen, verwenden Sie das Werkzeug <a href="{$a}">Nutzertokens löschen</a>.';
$string['clear_user_tokens'] = 'Nutzertokens löschen';
$string['clear_user_tokens_desc'] = 'Entfernt die für Nutzer/innen gespeicherten OpenID Connect- und Microsoft 365-Tokens. Betroffene Nutzer/innen erhalten neue Tokens, wenn sie sich das nächste Mal mit OpenID Connect anmelden oder mit Microsoft 365 verbinden. Ihre Verknüpfungen mit Microsoft 365-Konten bleiben erhalten. WARNUNG: Dies kann laufende Anmeldungen unterbrechen. Führen Sie es daher am besten während einer Wartungszeit durch.';
$string['clear_user_tokens_scope_selected'] = 'Ausgewählte Nutzer/innen';
$string['clear_user_tokens_scope_all'] = 'Alle Nutzer/innen';
$string['clear_user_tokens_users'] = 'Nutzer/innen';
$string['clear_user_tokens_submit'] = 'Tokens löschen';
$string['clear_user_tokens_no_name'] = '(kein Name)';
$string['clear_user_tokens_no_user_selected'] = 'Wählen Sie mindestens eine Person aus.';
$string['clear_user_tokens_confirm_all'] = 'Möchten Sie die Tokens aller Nutzer/innen wirklich löschen? Derzeit haben {$a} Nutzer/innen Tokens.';
$string['clear_user_tokens_confirm_selected'] = 'Möchten Sie die Tokens der ausgewählten Nutzer/innen wirklich löschen? Derzeit haben {$a} der ausgewählten Nutzer/innen Tokens.';
$string['clear_user_tokens_success'] = '{$a} Token-Datensätze gelöscht.';
$string['binding_username_claim_help_ms_no_user_sync'] = 'Für Microsoft-IdPs ohne aktivierte Nutzersynchronisierung stehen folgende Optionen zur Verfügung:
<ul>
<li><b>Automatisch wählen</b>: Verwendet die aktuelle Logik, die das Token anhand des IdP-Typs bestimmt und auf <b>sub</b> zurückgreift, wenn kein Claim gefunden wird.</li>
<li><b>preferred_username</b>: Standard für den IdP-Typ Microsoft identity platform (v2.0). <span class="not_support_user_sync">Unterstützt keine Nutzersynchronisierung.</span></li>
<li><b>email</b>: Ersatzwert für Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: Standard für Microsoft Entra ID (v1.0) und andere IdP-Typen.</li>
<li><b>unique_name</b>: Ersatzwert für Microsoft Entra ID (v1.0) und andere IdP-Typen. <span class="not_support_user_sync">Unterstützt keine Nutzersynchronisierung.</span></li>
<li><b>oid</b>: Ersatzwert, wenn keine anderen Claims vorhanden sind. Nur bei Microsoft-IdPs vorhanden.</li>
<li><b>sub</b>: Ersatzwert, wenn keine anderen Claims vorhanden sind. <span class="not_support_user_sync">Unterstützt keine Nutzersynchronisierung.</span></li>
<li><b>samaccountname</b>: Benutzerdefinierter Claim.</li>
<li><b>Benutzerdefiniert</b>: Ermöglicht der Website-Administration, einen eigenen Wert einzugeben. <span class="not_support_user_sync">Unterstützt keine Nutzersynchronisierung.</span></li>
</ul>
Hinweis: Einige Optionen unterstützen keine Nutzersynchronisierung.';
$string['binding_username_claim_help_ms_with_user_sync'] = 'Für Microsoft-IdPs mit aktivierter Nutzersynchronisierung stehen folgende Optionen zur Verfügung:
<ul>
<li><b>Automatisch wählen</b>: Verwendet die aktuelle Logik, die das Token anhand des IdP-Typs bestimmt und auf <b>sub</b> zurückgreift, wenn kein Claim gefunden wird.</li>
<li><b>email</b>: Ersatzwert für Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: Standard für Microsoft Entra ID (v1.0) und andere IdP-Typen.</li>
<li><b>oid</b>: Ersatzwert, wenn keine anderen Claims vorhanden sind. Nur bei Microsoft-IdPs vorhanden.</li>
<li><b>samaccountname</b>: Benutzerdefinierter Claim.</li>
</ul>';
$string['binding_username_claim_help_non_ms'] = 'Für IdPs, die nicht von Microsoft stammen, stehen folgende Optionen zur Verfügung:
<ul>
<li><b>Automatisch wählen</b>: Verwendet die aktuelle Logik, die das Token anhand des IdP-Typs bestimmt und auf <b>sub</b> zurückgreift, wenn kein Claim gefunden wird.</li>
<li><b>preferred_username</b></li>
<li><b>email</b></li>
<li><b>unique_name</b></li>
<li><b>sub</b></li>
<li><b>samaccountname</b></li>
<li><b>custom</b>: Benutzerdefinierter Claim.</li>
</ul>';
$string['warning_binding_username_claim_custom_unsupported'] = 'Die Einstellung "Claim für den verknüpften Anmeldenamen" ist derzeit auf "Benutzerdefiniert" gesetzt. Dies wird für den konfigurierten IdP-Typ bei aktivierter Nutzersynchronisierung nicht unterstützt. Überprüfen Sie die Einstellungen unter <a href="{$a}">Claim für den verknüpften Anmeldenamen</a>.';
$string['examplecsv'] = 'Beispieldatei zum Hochladen';
$string['usernamefile'] = 'Datei';
$string['csvdelimiter'] = 'CSV-Trennzeichen';
$string['encoding'] = 'Kodierung';
$string['rowpreviewnum'] = 'Vorschauzeilen';
$string['upload_usernames'] = 'Verknüpfte Anmeldenamen aktualisieren';
$string['update_stats_users_updated'] = '{$a} Nutzer/innen wurden aktualisiert';
$string['update_stats_users_errors'] = 'Bei {$a} Nutzer/innen sind Fehler aufgetreten';
$string['update_error_incomplete_line'] = 'Die Zeile enthält nicht alle erforderlichen Felder.';
$string['update_error_user_not_found'] = 'Kein Nutzerkonto mit diesem Anmeldenamen gefunden. Es wird versucht, das manuell zugeordnete Nutzerkonto zu aktualisieren.';
$string['update_error_user_not_oidc'] = 'Das Nutzerkonto verwendet nicht die Authentifizierungsmethode OpenID Connect. Es wird versucht, das manuell zugeordnete Nutzerkonto zu aktualisieren.';
$string['update_error_invalid_new_username'] = 'Der neue Anmeldename ist ungültig.';
$string['update_error_user_update_failed'] = 'Das Nutzerkonto konnte nicht aktualisiert werden.';
$string['update_warning_email_match'] = 'Die E-Mail-Adresse stimmt mit einem vorhandenen Nutzerkonto überein.';
$string['update_success_username'] = 'Anmeldename erfolgreich aktualisiert.';
$string['update_success_token'] = 'Token erfolgreich aktualisiert.';
$string['update_success_o365'] = 'Microsoft 365-Verbindungsdatensatz erfolgreich aktualisiert.';
$string['update_error_nothing_updated'] = 'Es wurde nichts aktualisiert.';
$string['error_invalid_upload_file'] = 'Ungültige hochgeladene Datei.';
$string['csvline'] = 'CSV-Zeile';
$string['change_binding_username_claim_tool_description'] = '<p class="warning_header">Dies ist eine erweiterte Funktion. Eine falsche Verwendung kann Nutzerdatensätze beeinträchtigen und das Single Sign-On (SSO) stören.</p>
<p>Mit diesem Werkzeug kann die Website-Administration folgende Datensätze in einem Schritt aktualisieren:</p>
<ul>
<li>Anmeldenamen von Moodle-Konten,</li>
<li>verknüpfte Anmeldenamen in gespeicherten OpenID Connect-ID-Tokens,</li>
<li>Verbindungsdatensätze zwischen Moodle- und Microsoft-Konten.</li>
</ul>
<p>Es sollte nur verwendet werden, wenn die Einstellung <b>Claim für den verknüpften Anmeldenamen</b> geändert wird.</p>
<p>Das Werkzeug akzeptiert eine einfache CSV-Datei mit zwei Spalten:</p>
<ul>
<li><b><span class="auth_oidc_code">username</span></b>: Der aktuelle Anmeldename des zu aktualisierenden Moodle-Kontos bzw. bei manuell zugeordneten Nutzer/innen der aktuelle Wert des verknüpften Claims.</li>
<li><b><span class="auth_oidc_code">new_username</span></b>: Der Wert (mit Beachtung der Groß-/Kleinschreibung) des neuen Token-Claims, der als Claim für den verknüpften Anmeldenamen verwendet werden soll. Wenn das Nutzerkonto automatisch zugeordnet ist und die Authentifizierungsart OpenID Connect verwendet, wird dieser Wert in Kleinbuchstaben als Moodle-Anmeldename verwendet.</li>
</ul>
<p>Nach dem Hochladen der Datei führt das Werkzeug folgende Aktionen aus:</p>
<ol>
<li>Es sucht ein vorhandenes Moodle-Nutzerkonto mit der Authentifizierungsmethode OpenID Connect, dessen Anmeldename oder E-Mail-Adresse dem angegebenen <span class="auth_oidc_code">username</span> entspricht, und ändert, falls eines gefunden wird, dessen Anmeldenamen in <span class="auth_oidc_code">new_username</span> in Kleinbuchstaben.</li>
<li>Es aktualisiert den OpenID Connect-Token-Datensatz.
<ul>
<li>Wurde in Schritt 1 ein Nutzerkonto gefunden, wird dessen Token-Datensatz in der Tabelle <span class="auth_oidc_code">auth_oidc_token</span> gesucht und die Spalte <span class="auth_oidc_code">username</span> auf <span class="auth_oidc_code">new_username</span> in Kleinbuchstaben sowie die Spalte <span class="auth_oidc_code">oidcusername</span> auf <span class="auth_oidc_code">new_username</span> gesetzt.</li>
<li>Wird oben kein Datensatz gefunden, wird versucht, in der Tabelle <span class="auth_oidc_code">auth_oidc_token</span> einen Datensatz zu finden, dessen Spalte <span class="auth_oidc_code">oidcusername</span> dem alten <span class="auth_oidc_code">username</span> entspricht, und diesen auf <span class="auth_oidc_code">new_username</span> zu aktualisieren.</li>
</ul>
</li>
<li>Sofern das Plugin <span class="auth_oidc_code">local_o365</span> installiert ist, aktualisiert es den Verbindungsdatensatz des Nutzerkontos.
<ul>
<li>Wurde in Schritt 1 ein Nutzerkonto gefunden, wird dessen Verbindungsdatensatz in der Tabelle <span class="auth_oidc_code">local_o365_objects</span> gesucht und die Spalte <span class="auth_oidc_code">o365name</span> auf <span class="auth_oidc_code">new_username</span> gesetzt.</li>
<li>Wurde in Schritt 1 kein Nutzerkonto gefunden, wird versucht, in der Tabelle <span class="auth_oidc_code">local_o365_objects</span> einen Nutzerdatensatz zu finden, dessen <span class="auth_oidc_code">o365name</span> dem Wert von <span class="auth_oidc_code">username</span> entspricht, und diesen auf den Wert von <span class="auth_oidc_code">new_username</span> zu aktualisieren.</li>
</ul>
</li>
</ol>
<p>Die folgende Beispieldatei würde den Claim für den verknüpften Anmeldenamen von <span class="auth_oidc_code">upn</span> oder <span class="auth_oidc_code">email</span> auf <span class="auth_oidc_code">oid</span> umstellen.</p>';
$string['change_binding_username_claim_tool_result'] = 'Ergebnisse der Aktualisierung';
$string['update_username_results'] = 'Ergebnisse der Aktualisierung der Anmeldenamen';
$string['new_username'] = 'Neuer Anmeldename';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
