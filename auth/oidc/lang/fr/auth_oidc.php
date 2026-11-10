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
 * French language strings.
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
$string['settings_pageheading'] = 'Configuration de {$a}';
$string['settings_page_other_settings'] = 'Autres options';
$string['settings_page_application'] = 'IdP et authentification';
$string['settings_page_application_wizard'] = 'Assistant de configuration de l’application';
$string['settings_page_binding_username_claim'] = 'Revendication de nom d’utilisateur de liaison';
$string['settings_page_change_binding_username_claim_tool'] = 'Outil de modification de la revendication de nom d’utilisateur de liaison';
$string['settings_page_cleanup_oidc_tokens'] = 'Nettoyer les jetons OpenID Connect';
$string['settings_page_clear_user_tokens'] = 'Effacer les jetons des utilisateurs';
$string['settings_page_field_mapping'] = 'Correspondances des champs';
$string['heading_additional_options'] = 'Options supplémentaires';
$string['heading_additional_options_desc'] = '';
$string['heading_stateredirect'] = 'Page d’erreur d’état de connexion';
$string['heading_stateredirect_desc'] = 'Par défaut, si un utilisateur met trop de temps à terminer sa connexion auprès du fournisseur d’identité (par exemple, en approuvant une demande d’authentification multifacteur) et que l’état de connexion enregistré a entre-temps été nettoyé, Moodle affiche sa page d’erreur générique. Les réglages ci-dessous permettent de prolonger la durée de conservation de l’état de connexion et d’afficher un message plus convivial et personnalisable à la place de la page d’erreur générique, en redirigeant automatiquement l’utilisateur vers la page de connexion.';
$string['heading_user_restrictions'] = 'Restrictions des utilisateurs';
$string['heading_user_restrictions_desc'] = '';
$string['heading_sign_out'] = 'Intégration de la déconnexion';
$string['heading_sign_out_desc'] = '';
$string['heading_display'] = 'Affichage';
$string['heading_display_desc'] = '';
$string['heading_debugging'] = 'Débogage';
$string['heading_debugging_desc'] = '';
$string['heading_tools'] = 'Outils';
$string['microsoftcloud'] = 'Cloud Microsoft';
$string['microsoftcloud_help'] = 'Sélectionnez le cloud Microsoft auquel appartient votre locataire Microsoft Entra. Ce réglage s’applique aux types d’IdP Microsoft Entra ID et Microsoft identity platform.<br/>
Sélectionnez « Microsoft 365 exploité par 21Vianet (Chine) » si votre organisation utilise Microsoft 365 fourni par 21Vianet. Le service de connexion et les points de terminaison Microsoft Graph de ce cloud sont alors utilisés pour les requêtes effectuées par les plugins, et les valeurs par défaut des points de terminaison et de la ressource ci-dessous s’y conforment. Les valeurs déjà enregistrées pour les points de terminaison, la ressource et le point de terminaison de déconnexion ne sont pas modifiées ; mettez-les donc à jour si elles pointent encore vers les points de terminaison du cloud mondial.';
$string['microsoftcloud_global'] = 'Microsoft 365 (mondial)';
$string['microsoftcloud_china'] = 'Microsoft 365 exploité par 21Vianet (Chine)';
$string['idptype'] = 'Type de fournisseur d’identité (IdP)';
$string['idptype_help'] = 'Trois types d’IdP sont actuellement pris en charge :
<ul>
<li><b>Microsoft Entra ID (v1.0)</b> : Microsoft Entra ID avec les points de terminaison oauth2 v1.0, par exemple https://login.microsoftonline.com/organizations/oauth2/authorize.</li>
<li><b>Microsoft identity platform (v2.0)</b> : Microsoft Entra ID avec les points de terminaison oauth2 v2.0, par exemple https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize.</li>
<li><b>Autre</b> : tout IdP non Microsoft.</li>
</ul>
Les différences entre les options <b>Microsoft Entra ID (v1.0)</b> et <b>Microsoft identity platform (v2.0)</b> sont décrites sur <a href="https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison">https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison</a>.<br/>
Notamment, l’application configurée peut utiliser un <b>certificat</b> en plus d’un <b>secret</b> pour l’authentification lorsque l’IdP <b>Microsoft identity platform (v2.0)</b> est utilisé.<br/>
Les points de terminaison d’autorisation et de jeton doivent être configurés en fonction du type d’IdP configuré.';
$string['idp_type_not_connected'] = 'Non connecté';
$string['idp_type_microsoft_entra_id'] = 'Microsoft Entra ID (v1.0)';
$string['idp_type_microsoft_identity_platform'] = 'Microsoft identity platform (v2.0)';
$string['idp_type_other'] = 'Autre';
$string['settings_application_wizard_desc'] = 'Pour configurer ces réglages à l’aide d’un formulaire guidé avec des instructions pas à pas et une validation des saisies, utilisez l’<a href="{$a}">Assistant de configuration de l’application</a>.';
$string['authendpoint'] = 'Point de terminaison d’autorisation';
$string['authendpoint_help'] = 'L’URI du point de terminaison d’autorisation de votre IdP à utiliser.<br/>
Notez que si le site doit être configuré pour autoriser l’accès aux utilisateurs d’autres locataires, un point de terminaison d’autorisation propre à un locataire ne peut pas être utilisé.';
$string['clientid'] = 'ID de l’application';
$string['clientid_help'] = 'L’ID d’application / ID client enregistré auprès de l’IdP.';
$string['clientauthmethod'] = 'Méthode d’authentification du client';
$string['clientauthmethod_help'] = '<ul>
<li>Les IdP de tous types peuvent utiliser la méthode d’authentification « <b>Secret</b> ».</li>
<li>Les IdP de type <b>Microsoft identity platform (v2.0)</b> peuvent en outre utiliser la méthode d’authentification <b>Certificat</b>.</li>
</ul>';
$string['auth_method_secret'] = 'Secret';
$string['auth_method_certificate'] = 'Certificat';
$string['clientsecret'] = 'Secret client';
$string['clientsecret_help'] = 'Avec la méthode d’authentification par <b>secret</b>, il s’agit du secret client défini sur l’IdP. Chez certains fournisseurs, il est également appelé clé.';
$string['clientprivatekey'] = 'Clé privée du certificat client';
$string['clientprivatekey_help'] = 'Avec la méthode d’authentification par <b>certificat</b> et la source de certificat <b>Texte brut</b>, il s’agit de la clé privée du certificat utilisé pour s’authentifier auprès de l’IdP.';
$string['clientcert'] = 'Clé publique du certificat client';
$string['clientcert_help'] = 'Avec la méthode d’authentification par <b>certificat</b> et la source de certificat <b>Texte brut</b>, il s’agit de la clé publique, ou du certificat, utilisé pour s’authentifier auprès de l’IdP.';
$string['clientcertsource'] = 'Source du certificat';
$string['clientcertsource_help'] = 'Avec la méthode d’authentification par <b>certificat</b>, ce réglage définit l’emplacement d’où le certificat est récupéré.
<ul>
<li>La source <b>Texte brut</b> nécessite que le contenu des fichiers du certificat et de la clé privée soit renseigné dans les zones de texte suivantes.</li>
<li>La source <b>Nom de fichier</b> nécessite que les fichiers du certificat et de la clé privée se trouvent dans un dossier <b>microsoft_certs</b> du dossier de données de Moodle.</li>
</ul>';
$string['cert_source_text'] = 'Texte brut';
$string['cert_source_path'] = 'Nom de fichier';
$string['clientprivatekeyfile'] = 'Nom du fichier de la clé privée du certificat client';
$string['clientprivatekeyfile_help'] = 'Avec la méthode d’authentification par <b>certificat</b> et la source de certificat <b>Nom de fichier</b>, il s’agit du nom du fichier de la clé privée utilisée pour s’authentifier auprès de l’IdP. Le fichier doit se trouver dans un dossier <b>microsoft_certs</b> du dossier de données de Moodle.';
$string['clientcertfile'] = 'Nom du fichier de la clé publique du certificat client';
$string['clientcertfile_help'] = 'Avec la méthode d’authentification par <b>certificat</b> et la source de certificat <b>Nom de fichier</b>, il s’agit du nom du fichier de la clé publique, ou du certificat, utilisé pour s’authentifier auprès de l’IdP. Le fichier doit se trouver dans un dossier <b>microsoft_certs</b> du dossier de données de Moodle.';
$string['clientcertpassphrase'] = 'Phrase secrète du certificat client';
$string['clientcertpassphrase_help'] = 'Si la clé privée du certificat client est chiffrée, il s’agit de la phrase secrète permettant de la déchiffrer.';
$string['change_client_secret'] = 'Modifier le secret client';
$string['change_client_secret_desc'] = 'Cochez cette case pour mettre à jour le secret client. Par sécurité, les secrets existants sont masqués et seuls les 2 premiers caractères sont affichés.';
$string['change_cert_passphrase'] = 'Modifier la phrase secrète du certificat';
$string['change_cert_passphrase_desc'] = 'Cochez cette case pour mettre à jour la phrase secrète du certificat. Par sécurité, les phrases secrètes existantes sont masquées et seuls les 2 premiers caractères sont affichés.';
$string['cfg_usepkce_key'] = 'Utiliser PKCE';
$string['cfg_usepkce_desc'] = 'Avec le flux de connexion <b>Code d’autorisation</b>, envoie un « code_challenge » PKCE (RFC 7636) avec la méthode S256 dans la demande d’autorisation, et le « code_verifier » correspondant lors de l’échange du code d’autorisation. Microsoft Entra ID le prend en charge. Pour les autres fournisseurs, n’activez cette option que si votre fournisseur prend en charge PKCE, car certains fournisseurs rejettent les demandes d’autorisation contenant des paramètres qu’ils ne reconnaissent pas.';
$string['cfg_domainhint_key'] = 'Indication de domaine';
$string['cfg_domainhint_desc'] = 'Avec le flux de connexion <b>Code d’autorisation</b>, transmet cette valeur dans le paramètre « domain_hint ». « domain_hint » est utilisé par certains IdP OpenID Connect pour simplifier le processus de connexion des utilisateurs. Vérifiez auprès de votre fournisseur s’il prend en charge ce paramètre.';
$string['cfg_forceselectaccount_key'] = 'Toujours afficher la sélection du compte';
$string['cfg_forceselectaccount_desc'] = 'Si cette option est activée, les utilisateurs doivent toujours choisir le compte avec lequel se connecter, au lieu d’être connectés automatiquement avec le compte actif dans leur navigateur. Utile lorsque les utilisateurs disposent de plusieurs comptes, par exemple un compte étudiant et un compte administrateur.<br/>
Le mode de connexion silencieuse est prioritaire : lorsqu’il est activé, la sélection du compte n’est pas imposée lors d’une connexion silencieuse.';
$string['cfg_forceredirect_key'] = 'Forcer la redirection';
$string['cfg_forceredirect_desc'] = 'Si cette option est activée, la page d’accueil de connexion est ignorée et l’utilisateur est redirigé vers la page OpenID Connect. Peut être contourné avec le paramètre d’URL ?noredirect=1';
$string['cfg_stateexpiry_key'] = 'Expiration de l’état de connexion (minutes)';
$string['cfg_stateexpiry_desc'] = 'Durée de conservation d’un enregistrement d’état de connexion avant que la tâche programmée de nettoyage ne le supprime. Augmentez cette valeur si les utilisateurs mettent régulièrement plus de temps que cela à terminer leur connexion auprès du fournisseur d’identité (par exemple, en raison de demandes d’authentification multifacteur).';
$string['error_stateexpiry_min'] = 'L’expiration de l’état de connexion doit être d’au moins 1 minute. Une valeur nulle ou négative ferait échouer les connexions en cours.';
$string['cfg_stateredirect_enabled_key'] = 'Afficher une page d’erreur conviviale';
$string['cfg_stateredirect_enabled_desc'] = 'Si cette option est activée, un utilisateur qui met trop de temps à terminer sa connexion auprès du fournisseur d’identité (de sorte que l’état de connexion enregistré a entre-temps été nettoyé) voit le message personnalisable ci-dessous et est automatiquement redirigé vers la page de connexion, au lieu de la page d’erreur générique de Moodle.';
$string['cfg_stateredirect_message_key'] = 'Message';
$string['cfg_stateredirect_message_desc'] = 'Le message à afficher à l’utilisateur sur la page d’erreur conviviale.';
$string['cfg_stateredirect_message_default'] = 'Un problème est survenu lors de votre connexion. Cela est très probablement dû au fait que la connexion a pris trop de temps (par exemple, lors de l’approbation d’une demande d’authentification multifacteur). Vous allez être redirigé automatiquement vers la page de connexion pour pouvoir réessayer.';
$string['cfg_stateredirect_delay_key'] = 'Délai de redirection (secondes)';
$string['cfg_stateredirect_delay_desc'] = 'Le nombre de secondes pendant lesquelles le message ci-dessus est affiché avant que l’utilisateur ne soit automatiquement redirigé vers la page de connexion.';
$string['cfg_set_pix_key'] = 'Afficher une icône sur la page de connexion';
$string['cfg_set_pix_desc'] = 'Si cette option est activée, une icône est affichée à côté du nom du fournisseur sur la page de connexion.';
$string['cfg_icon_key'] = 'Icône';
$string['cfg_icon_desc'] = 'Icône à afficher près du nom de fournisseur sur la page de connexion.';
$string['cfg_iconalt_o365'] = 'Icône Office 365';
$string['cfg_iconalt_microsoft365'] = 'Logo Microsoft 365';
$string['cfg_iconalt_openid'] = 'Icône OpenID';
$string['cfg_iconalt_keycloak'] = 'Icône Keycloak';
$string['cfg_customicon_key'] = 'Icône personnalisée';
$string['cfg_customicon_desc'] = 'Si vous souhaitez utiliser votre propre icône, déposez-la ici. Elle remplace toute icône choisie ci-dessus. <br /><br /><b>Remarques sur l’utilisation des icônes personnalisées :</b><ul><li>Le fichier déposé n’est pas redimensionné. Il sera affiché avec une taille fixe de 24x24 pixels sur la page de connexion, votre navigateur l’adaptant à cette taille ; nous recommandons donc de déposer une image carrée pour éviter toute déformation.</li><li>Si vous avez déposé une icône personnalisée et que vous souhaitez revenir à l’une des icônes standard, cliquez sur l’icône personnalisée dans la zone ci-dessus, puis sur « Supprimer », puis sur « OK », puis sur « Enregistrer » en bas de ce formulaire. L’icône standard sélectionnée apparaîtra alors sur la page de connexion de Moodle.</li></ul>';
$string['cfg_debugmode_key'] = 'Enregistrer les messages de débogage';
$string['cfg_debugmode_desc'] = 'Si ce réglage est activé, les informations seront enregistrées dans le journal Moodle, cela peut aider à identifier les problèmes.';
$string['cfg_silentloginmode_key'] = 'Mode de connexion silencieuse';
$string['cfg_silentloginmode_desc'] = 'Si cette option est activée, Moodle essaiera d’utiliser la session active d’un utilisateur authentifié auprès du point de terminaison d’autorisation configuré pour connecter cet utilisateur.<br/>
Pour utiliser cette fonctionnalité, les configurations suivantes sont requises :
<ul>
<li><b>Forcer la connexion</b> (forcelogin) dans la <a href="{$a}" target="_blank">section Politiques du site</a> est activé.</li>
<li>Le réglage <b>Forcer la redirection</b> (auth_oidc/forceredirect) ci-dessus est activé.</li>
</ul>
Afin d’éviter que Moodle n’essaie d’utiliser des comptes personnels ou des comptes d’autres locataires pour la connexion, il est également recommandé d’utiliser des points de terminaison propres au locataire plutôt que des points de terminaison génériques utilisant des chemins tels que « common » ou « organizations ».<br/>
<br/>
Pour les IdP Microsoft, l’expérience utilisateur est la suivante :
<ul>
<li>Si aucune session utilisateur active n’est trouvée, la page de connexion de Moodle s’affiche.</li>
<li>Si une seule session utilisateur active est trouvée et que l’utilisateur a accès à l’application Entra ID (c’est-à-dire que l’utilisateur appartient au même locataire ou est un invité du locataire), l’utilisateur est automatiquement connecté à Moodle par SSO.</li>
<li>Si une seule session utilisateur active est trouvée mais que l’utilisateur n’a pas accès à l’application Entra ID (par exemple, l’utilisateur appartient à un autre locataire, ou l’application exige une attribution des utilisateurs et l’utilisateur n’est pas attribué), la page de connexion de Moodle s’affiche.</li>
<li>S’il existe plusieurs sessions utilisateur actives ayant accès à l’application Entra ID, une page s’affiche pour permettre à l’utilisateur de choisir le compte avec lequel se connecter.</li>
</ul>';
$string['oidcresource'] = 'Ressource';
$string['oidcresource_help'] = 'La ressource OpenID Connect pour laquelle envoyer la requête.<br/>
<b>Remarque :</b> ce paramètre n’est pas pris en charge par le type d’IdP <b>Microsoft identity platform (v2.0)</b>.';
$string['oidcscope'] = 'Étendue';
$string['oidcscope_help'] = 'L’étendue (scope) OIDC à utiliser.';
$string['customclaims'] = 'Revendications personnalisées';
$string['customclaims_help'] = 'Liste, séparée par des espaces, des noms de revendications personnalisées présentes dans les jetons de votre fournisseur d’identité.<br/>
<b>Important :</b>
<ul>
<li>Les revendications doivent exister dans la configuration des jetons de votre IdP (par exemple, les mappeurs de protocole Keycloak ou les revendications facultatives/personnalisées de Microsoft Entra ID)</li>
<li>Si une revendication n’existe pas dans le jeton, la correspondance des champs l’ignore silencieusement ; aucune erreur n’est affichée</li>
<li>Les noms de revendications sont sensibles à la casse et ne peuvent contenir que des caractères alphanumériques, des traits d’union et des traits de soulignement</li>
<li>Un nom de revendication ne peut pas être un nom réservé, tel qu’une revendication JWT/OpenID Connect standard (par exemple, <code>sub</code>, <code>email</code>), une revendication propre à Microsoft Entra ID (par exemple, <code>oid</code>, <code>upn</code>) ou à Keycloak (par exemple, <code>realm_access</code>, <code>resource_access</code>), ou une option de correspondance de champ existante</li>
<li>La revendication <code>roles</code> (rôles d’application dans les jetons Microsoft Entra ID) et la revendication <code>groups</code> (ID de groupes) sont autorisées. Elles apparaissent sous les noms « roles (token claim) » et « groups (token claim) » dans la correspondance des champs, séparément des options intégrées « Rôles » et « Groupes », qui correspondent aux rôles d’annuaire Microsoft Entra et aux noms de groupes provenant de Microsoft Graph. Les revendications contenant une liste de valeurs sont enregistrées sous forme de liste séparée par des virgules</li>
<li>Exemples : <code>employee_type badge_number costCenter custom_role</code></li>
<li>Lors de la connexion, les revendications personnalisées sont toujours lues dans le jeton, que Microsoft Graph soit également utilisé ou non. Pendant la tâche programmée de synchronisation des utilisateurs, il n’y a pas de jeton utilisateur à lire ; une revendication personnalisée n’est donc synchronisée que si son nom correspond également à une propriété d’utilisateur Microsoft Graph sélectionnable, comme un attribut d’extension d’annuaire (par exemple, <code>extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode</code>). Une revendication personnalisée rejetée par Microsoft Graph est ignorée pour cette exécution de la synchronisation, avec un avertissement dans le journal de la tâche, au lieu de faire échouer toute la synchronisation.</li>
</ul>';
$string['secretexpiryrecipients'] = 'Destinataires des notifications d’expiration du secret';
$string['secretexpiryrecipients_help'] = 'Une liste, séparée par des virgules, des adresses de courriel auxquelles envoyer les notifications d’expiration du secret.<br/>
Si aucune adresse n’est saisie, l’administrateur principal du site sera notifié.<br/>
Par défaut, les notifications sont envoyées quotidiennement à partir de quatre semaines avant l’expiration, jusqu’au renouvellement du secret.';
$string['cfg_showbutton_key'] = 'Afficher le bouton de connexion';
$string['cfg_showbutton_desc'] = 'Si cette option est désactivée, le bouton de connexion du fournisseur n’est pas affiché sur la page de connexion. Les utilisateurs peuvent toujours s’authentifier via ce fournisseur en accédant directement à son URL de connexion.';
$string['cfg_opname_key'] = 'Nom d’affichage du fournisseur';
$string['cfg_opname_desc'] = 'Il s’agit d’une étiquette destinée à l’utilisateur final qui identifie le type d’informations d’identification dont l’utilisateur doit se servir pour se connecter. Cette étiquette est utilisée sur toutes les sections permettant d’identifier votre fournisseur et qui sont visibles par l’utilisateur.';
$string['cfg_redirecturi_key'] = 'URI de redirection';
$string['cfg_redirecturi_desc'] = 'URI à enregistrer comme « URI de redirection ». Votre fournisseur d’identité OpenID Connect doit demander cet URI lors de l’enregistrement de Moodle comme client. <br /><b>REMARQUE :</b> vous devez entrer cet URI dans votre fournisseur OpenID Connect *exactement* tel qu’il apparaît ici. La moindre différence empêchera les connexions d’utiliser OpenID Connect.';
$string['tokenendpoint'] = 'Point de terminaison de jeton';
$string['tokenendpoint_help'] = 'L’URI du point de terminaison de jeton de votre IdP à utiliser.<br/>
Notez que si le site doit être configuré pour autoriser l’accès aux utilisateurs d’autres locataires, un point de terminaison de jeton propre à un locataire ne peut pas être utilisé.';
$string['cfg_userrestrictions_key'] = 'Restrictions utilisateur';
$string['cfg_userrestrictions_desc'] = 'Ne permettre qu’aux utilisateurs correspondant à certains critères de se connecter. <br /><b>Comment utiliser les restrictions d’utilisateurs : </b> <ul><li>Entrez une <a href="https://en.wikipedia.org/wiki/Regular_expression">expression régulière</a> correspondant aux noms d’utilisateurs des utilisateurs que vous souhaitez autoriser.</li><li>Entrez une expression par ligne</li><li>Si vous entrez plusieurs expressions, l’utilisateur sera autorisé s’il correspond à N’IMPORTE LAQUELLE des expressions.</li><li>Le caractère « / » doit être échappé avec « \\ ».</li><li>Si vous n’entrez aucune restriction ci-dessus, tous les utilisateurs pouvant se connecter au fournisseur OpenID Connect seront acceptés par Moodle.</li><li>Tout utilisateur ne correspondant à aucune des expressions entrées ne pourra pas se connecter à l’aide d’OpenID Connect.</li></ul>';
$string['cfg_userrestrictionscasesensitive_key'] = 'Restrictions utilisateur sensibles à la casse';
$string['cfg_userrestrictionscasesensitive_desc'] = 'Ce réglage détermine si l’option « /i » des expressions régulières est utilisée pour la vérification des restrictions utilisateur.<br/>Si ce réglage est activé, toutes les vérifications des restrictions utilisateur seront sensibles à la casse. Notez que s’il est désactivé, toute distinction de casse dans les expressions sera ignorée.';
$string['heading_dummy_email'] = 'Adresses de courriel de substitution';
$string['heading_dummy_email_desc'] = 'Moodle exige que chaque compte utilisateur ait une adresse de courriel, mais les comptes Microsoft Entra ID n’en ont pas obligatoirement. Les réglages ci-dessous permettent à Moodle de générer une adresse de substitution non distribuable pour les utilisateurs qui n’ont pas d’adresse de courriel exploitable provenant de l’IdP, au lieu de laisser leur adresse de courriel vide.';
$string['cfg_generatedummyemail_key'] = 'Générer des adresses de courriel de substitution';
$string['cfg_generatedummyemail_desc'] = 'Si cette option est activée, lorsqu’un utilisateur n’a ni adresse de courriel ni nom d’utilisateur principal (UPN) au format courriel exploitable provenant de l’IdP, Moodle génère pour lui une adresse de courriel de substitution à partir de son nom d’utilisateur principal Microsoft (ou de son ID d’objet, si aucun nom d’utilisateur principal n’est disponible) et du domaine configuré ci-dessous, au lieu de laisser son adresse de courriel vide. Cela s’applique à la fois lorsque l’utilisateur se connecte et lorsqu’il est créé par la tâche de synchronisation des utilisateurs.';
$string['cfg_dummyemaildomain_key'] = 'Domaine des adresses de courriel de substitution';
$string['cfg_dummyemaildomain_desc'] = 'Le domaine à utiliser pour générer les adresses de courriel de substitution, par exemple « example.test ». Utilisez un domaine qui ne peut pas recevoir de courriel, afin que les adresses générées ne puissent jamais être confondues avec une adresse réelle et distribuable.';
$string['cfg_signoffintegration_key'] = 'Déconnexion unique (de Moodle vers l’IdP)';
$string['cfg_signoffintegration_desc'] = 'Si cette option est activée, lorsqu’un utilisateur Moodle connecté via l’IdP configuré se déconnecte de Moodle, l’intégration envoie une requête au point de terminaison de déconnexion ci-dessous afin de tenter de déconnecter également l’utilisateur de l’IdP.<br/>
Notez que pour l’intégration avec Microsoft Entra ID, l’URL du site Moodle ({$a}) doit être ajoutée comme URI de redirection dans l’application Microsoft Entra ID créée pour l’intégration de Moodle et Microsoft 365.';
$string['cfg_logoutendpoint_key'] = 'Point de terminaison de déconnexion de l’IdP';
$string['cfg_logoutendpoint_desc'] = 'L’URI du point de terminaison de déconnexion de votre IdP à utiliser.';
$string['cfg_frontchannellogouturl_key'] = 'URL de déconnexion front-channel';
$string['cfg_frontchannellogouturl_desc'] = 'Il s’agit de l’URL que votre IdP doit appeler lorsqu’il tente de déconnecter des utilisateurs de Moodle.<br/>
Pour Microsoft Entra ID / Microsoft identity platform, ce réglage s’appelle « Front-channel logout URL » et se configure dans l’application Microsoft Entra ID.';
$string['cfg_field_mapping_desc'] = 'Les données du profil utilisateur peuvent être mises en correspondance depuis l’IdP OpenID Connect vers Moodle. Les champs distants disponibles dépendent fortement du type d’IdP.<br/>
<ul>
<li>Certains champs de profil de base sont disponibles à partir des revendications du jeton d’accès et du jeton d’ID pour tous les types d’IdP.</li>
<li>Si un type d’IdP Microsoft est configuré (v1.0 ou v2.0), des données de profil supplémentaires peuvent être obtenues via des appels à l’API Graph en installant et en configurant le <a href="https://moodle.org/plugins/local_o365">plugin d’intégration Microsoft 365 (local_o365)</a>.</li>
<li>Si la fonctionnalité de synchronisation des profils SDS est activée dans le plugin local_o365, certains champs de profil peuvent être synchronisés de SDS vers Moodle. Cela ne se produit que lors de l’exécution de la tâche programmée « Synchroniser avec SDS », et non lors de l’exécution de la tâche programmée « Synchroniser les utilisateurs depuis Microsoft Entra ID », ni lors de la connexion d’un utilisateur.</li>
</ul>

Les revendications disponibles dans les jetons d’ID et d’accès varient selon le type d’IdP, mais la plupart des IdP permettent un certain niveau de personnalisation des revendications. La documentation relative aux IdP Microsoft est accessible ci-dessous :
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Revendications du jeton d’accès</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">Revendications du jeton d’ID</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Configuration des revendications facultatives</a> : notez que « Email » est une revendication facultative pour le type d’IdP Microsoft Entra ID (v1.0).</li>
</ul>';

$string['cfg_cleanupoidctokens_key'] = 'Nettoyer les jetons OpenID Connect';
$string['cfg_cleanupoidctokens_desc'] = 'Si vos utilisateurs rencontrent des problèmes pour se connecter avec leur compte Microsoft 365, essayez de nettoyer les jetons OpenID Connect. Cela supprime les jetons orphelins et incomplets susceptibles de provoquer des erreurs. ATTENTION : cette opération peut interrompre les connexions en cours ; il est donc préférable de l’effectuer pendant une période d’inactivité.';
$string['settings_section_basic'] = 'Réglages de base';
$string['settings_section_authentication'] = 'Authentification';
$string['settings_section_endpoints'] = 'Points de terminaison';
$string['settings_section_other_params'] = 'Autres paramètres';
$string['settings_section_secret_expiry_notification'] = 'Notification d’expiration du secret';
$string['application_updated'] = 'Les réglages de l’application OpenID Connect ont été mis à jour.';
$string['application_updated_microsoft'] = 'Le réglage de l’application OpenID Connect a été mis à jour.<br/>
<span class="warning" style="color: red;">Un administrateur Microsoft Entra ID devra <b>Donner le consentement administrateur</b> et <b>Vérifier la configuration</b> à nouveau sur la page de configuration de l’intégration Microsoft 365 si les réglages « Type de fournisseur d’identité (IdP) » ou « Méthode d’authentification du client » sont modifiés.</span>';
$string['application_updated_microsoft_notify'] = 'Le réglage de l’application OpenID Connect a été mis à jour.<br/>
<span class="warning" style="color: red;">Un administrateur Microsoft Entra ID devra <b>Donner le consentement administrateur</b> et <b>Vérifier la configuration</b> à nouveau sur la <a href="{$a}">page de configuration de l’intégration Microsoft 365</a> si les réglages « Type de fournisseur d’identité (IdP) » ou « Méthode d’authentification du client » sont modifiés.</span>';
$string['application_not_changed'] = 'Le réglage de l’application OpenID Connect n’a pas été modifié.';

$string['event_debug'] = 'Message de débogage';

$string['task_cleanup_oidc_state_and_token'] = 'Nettoyer les états OIDC et les jetons non valides';
$string['task_cleanup_oidc_sid'] = 'Nettoyer les enregistrements SID OIDC';

$string['errorauthdisconnectemptypassword'] = 'Le mot de passe ne peut pas être vide';
$string['errorauthdisconnectemptyusername'] = 'Le nom d’utilisateur ne peut pas être vide';
$string['errorauthdisconnectusernameexists'] = 'Ce nom d’utilisateur est déjà attribué. Choisissez-en un autre.';
$string['errorauthdisconnectnewmethod'] = 'Utiliser une méthode de connexion';
$string['errorauthdisconnectinvalidmethod'] = 'Méthode de connexion non valide reçue.';
$string['errorauthdisconnectifmanual'] = 'Si vous utilisez la méthode de connexion manuelle, saisissez les informations d’identification ci-dessous.';
$string['errorauthgeneral'] = 'Il y a eu un problème lors de votre connexion. Veuillez contacter votre administrateur pour de l’aide.';
$string['errorauthinvalididtoken'] = 'id_token reçu non valide.';
$string['errorauthloginfailednouser'] = 'Connexion non valide : vous vous êtes connecté en tant que « {$a} », mais aucun compte correspondant n’existe sur ce site et les nouveaux comptes ne peuvent pas être créés automatiquement. Veuillez contacter l’administrateur du site pour obtenir de l’aide. Si vous avez plusieurs comptes, sélectionnez Continuer pour vous connecter avec un autre compte.';
$string['errorauthloginfaileddupemail'] = 'Connexion non valide : un compte existant sur ce Moodle a la même adresse de courriel que le compte que vous essayez de créer, et le réglage « Autoriser des comptes avec la même adresse de courriel » (allowaccountssameemail) est désactivé.';
$string['errorauthmfarequired'] = 'Microsoft exige une authentification multifacteur pour terminer votre connexion, mais celle-ci n’a pas pu être effectuée. Veuillez réessayer, ou connectez-vous à Microsoft 365 dans une nouvelle session de navigateur et répondez à la demande d’authentification multifacteur.';
$string['errorauthnoauthcode'] = 'Aucun code d’autorisation n’a été reçu du serveur d’identité. Les journaux d’erreurs peuvent contenir plus d’informations.';
$string['errorauthnocredsandendpoints'] = 'Veuillez configurer les identifiants client et les points de terminaison OpenID Connect.';
$string['errorauthnoidtoken'] = 'Jeton OpenID Connect id_token non reçu.';
$string['errorauthnoaccesstoken'] = 'Jeton d’accès non reçu.';
$string['errorauthunknownstate'] = 'État inconnu.';
$string['errorauthuseralreadyconnected'] = 'Vous êtes déjà connecté à un autre utilisateur OpenID Connect.';
$string['errorauthuserconnectedtodifferent'] = 'L’utilisateur OpenID Connect qui s’est authentifié est déjà connecté à un utilisateur Moodle.';
$string['errorbadloginflow'] = 'Méthode d’authentification spécifiée non valide. Remarque : si vous recevez ce message après une installation ou une mise à niveau récente, effacez votre cache Moodle.';
$string['errorjwtbadpayload'] = 'Impossible de lire la charge JWT.';
$string['errorjwtcouldnotreadheader'] = 'Impossible de lire l’en-tête JWT';
$string['errorjwtempty'] = 'JWT reçu vide ou n’étant pas une chaîne de caractères.';
$string['errorjwtinvalidheader'] = 'En-tête JWT non valide';
$string['errorjwtmalformed'] = 'JWT malformé reçu.';
$string['errorjwtunsupportedalg'] = 'JWS Alg ou JWE non pris en charge';
$string['erroroidcnotenabled'] = 'Le plugin d’authentification OpenID Connect n’est pas activé.';
$string['errornodisconnectionauthmethod'] = 'Déconnexion impossible, car aucun plugin d’authentification activé n’est disponible comme solution de repli (ni la méthode de connexion précédente de l’utilisateur, ni la méthode de connexion manuelle).';
$string['erroroidcclientinvalidendpoint'] = 'URI du point de terminaison non valide reçu.';
$string['erroroidcclientnocreds'] = 'Définissez les informations d’identification client avec setcreds';
$string['erroroidcclientnoauthendpoint'] = 'Aucun point de terminaison d’autorisation défini. Définissez-le avec $this->setendpoints';
$string['erroroidcclientnotokenendpoint'] = 'Aucun point de terminaison de jeton défini. Définissez-le avec $this->setendpoints';
$string['errorrestricted'] = 'Ce site impose des restrictions quant aux utilisateurs pouvant se connecter avec OpenID Connect. Ces restrictions vous empêchent actuellement de vous connecter.';
$string['errorucpinvalidaction'] = 'Action non valide reçue.';
$string['erroroidccall'] = 'Erreur dans OpenID Connect. Pour plus d’informations, consultez les journaux d’erreurs.';
$string['erroroidccall_message'] = 'Erreur dans OpenID Connect : {$a}';
$string['errorinvalidredirect_message'] = 'L’URL à laquelle vous tentez de vous rediriger n’existe pas.';
$string['errorinvalidcertificatesource'] = 'Source de certificat non valide';
$string['error_invalid_client_authentication_method'] = 'Méthode d’authentification du client non valide';
$string['error_certificate_requires_identity_platform'] = 'L’authentification par certificat nécessite le type d’IdP « Microsoft identity platform (v2.0) ».';
$string['error_empty_client_secret'] = 'Le secret client ne peut pas être vide avec la méthode d’authentification « secret »';
$string['error_empty_client_private_key'] = 'La clé privée du certificat client ne peut pas être vide avec la méthode d’authentification « certificat »';
$string['error_empty_client_cert'] = 'La clé publique du certificat client ne peut pas être vide avec la méthode d’authentification « certificat »';
$string['error_empty_client_private_key_file'] = 'Le fichier de la clé privée du certificat client ne peut pas être vide avec la méthode d’authentification « certificat »';
$string['error_empty_client_cert_file'] = 'Le fichier de la clé publique du certificat client ne peut pas être vide avec la méthode d’authentification « certificat »';
$string['error_endpoint_mismatch_auth_endpoint'] = 'Le point de terminaison d’autorisation configuré ne correspond pas au type d’IdP configuré. Pour « Microsoft Entra ID (v1.0) », utilisez un point de terminaison v1.0 (par exemple https://login.microsoftonline.com/organizations/oauth2/authorize). Pour « Microsoft identity platform (v2.0) », utilisez un point de terminaison v2.0 (par exemple https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize).';
$string['error_endpoint_mismatch_token_endpoint'] = 'Le point de terminaison de jeton configuré ne correspond pas au type d’IdP configuré. Pour « Microsoft Entra ID (v1.0) », utilisez un point de terminaison v1.0 (par exemple https://login.microsoftonline.com/organizations/oauth2/token). Pour « Microsoft identity platform (v2.0) », utilisez un point de terminaison v2.0 (par exemple https://login.microsoftonline.com/organizations/oauth2/v2.0/token).';
$string['error_tenant_specific_endpoint_required'] = 'Avec le type d’IdP « Microsoft identity platform (v2.0) » et la méthode d’authentification « Certificat », un point de terminaison propre au locataire (c’est-à-dire autre que common/organizations/consumers) est requis.';
$string['error_empty_oidcresource'] = 'La ressource ne peut pas être vide avec le type d’IdP Microsoft Entra ID (v1.0) ou les autres types d’IdP.';
$string['error_invalid_custom_claim'] = 'Nom(s) de revendication personnalisée non valide(s) : {$a}. Les noms de revendications personnalisées ne peuvent contenir que des caractères alphanumériques, des traits d’union et des traits de soulignement, et ne peuvent pas être un nom de revendication réservé (par exemple une revendication JWT/OpenID Connect standard, ou une revendication propre à Microsoft Entra ID ou à Keycloak) ni une option de correspondance de champ existante.';
$string['error_masked_secret_not_changed'] = 'Veuillez saisir une nouvelle valeur ou décocher la case « Modifier » pour conserver la valeur actuelle.';
$string['auth_settings_validation_error'] = 'Des réglages d’authentification non valides ont été détectés. Les problèmes de configuration suivants doivent être résolus pour garantir le bon fonctionnement de l’authentification :';
$string['error_secretexpiryrecipients_invalid'] = 'Les destinataires suivants des notifications d’expiration du secret ne sont pas des adresses de courriel valides : {$a}';
$string['errorupnchangeisnotsupported'] = 'L’UPN de votre compte Microsoft a changé. Veuillez contacter votre administrateur pour mettre à jour votre compte Moodle.';
$string['erroruserwithusernamealreadyexists'] = 'Une erreur s’est produite lors de la tentative de renommage de votre compte Moodle. Un utilisateur Moodle avec le nouveau nom d’utilisateur existe déjà. Demandez d’abord à l’administrateur de votre site de résoudre ce problème.';
$string['error_no_response_available'] = 'Aucune réponse disponible.';

$string['eventuserauthed'] = 'Utilisateur autorisé avec OpenID Connect';
$string['eventusercreated'] = 'Utilisateur créé avec OpenID Connect';
$string['eventuserconnected'] = 'Utilisateur connecté à OpenID Connect';
$string['eventuserloggedin'] = 'Utilisateur identifié avec OpenID Connect';
$string['eventuserdisconnected'] = 'Utilisateur déconnecté d’OpenID Connect';
$string['eventuserrenameattempt'] = 'Le plugin auth_oidc a tenté de renommer un utilisateur';

$string['oidc:manageconnection'] = 'Permettre la connexion et la déconnexion OpenID Connect';
$string['oidc:manageconnectionconnect'] = 'Permettre la connexion OpenID Connect';
$string['oidc:manageconnectiondisconnect'] = 'Permettre la déconnexion OpenID Connect';

$string['privacy:metadata:auth_oidc'] = 'Authentification OpenID Connect';
$string['privacy:metadata:auth_oidc_prevlogin'] = 'Méthodes de connexion précédentes pour annuler les connexions Microsoft 365';
$string['privacy:metadata:auth_oidc_prevlogin:userid'] = 'L’identifiant de l’utilisateur Moodle';
$string['privacy:metadata:auth_oidc_prevlogin:method'] = 'La méthode de connexion précédente';
$string['privacy:metadata:auth_oidc_prevlogin:password'] = 'Le mot de passe précédent de l’utilisateur (chiffré)';
$string['privacy:metadata:auth_oidc_token'] = 'Jetons OpenID Connect';
$string['privacy:metadata:auth_oidc_token:oidcuniqid'] = 'L’identifiant unique de l’utilisateur OIDC.';
$string['privacy:metadata:auth_oidc_token:username'] = 'Le nom d’utilisateur de l’utilisateur Moodle';
$string['privacy:metadata:auth_oidc_token:userid'] = 'L’ID de l’utilisateur Moodle';
$string['privacy:metadata:auth_oidc_token:oidcusername'] = 'Le nom d’utilisateur de l’utilisateur OIDC';
$string['privacy:metadata:auth_oidc_token:useridentifier'] = 'L’identifiant de l’utilisateur OIDC';
$string['privacy:metadata:auth_oidc_token:scope'] = 'L’étendue du jeton';
$string['privacy:metadata:auth_oidc_token:tokenresource'] = 'La ressource du jeton';
$string['privacy:metadata:auth_oidc_token:authcode'] = 'Le code d’authentification du jeton';
$string['privacy:metadata:auth_oidc_token:token'] = 'Le jeton';
$string['privacy:metadata:auth_oidc_token:expiry'] = 'L’expiration du jeton';
$string['privacy:metadata:auth_oidc_token:refreshtoken'] = 'Le jeton de rafraîchissement';
$string['privacy:metadata:auth_oidc_token:idtoken'] = 'Le jeton ID';
$string['privacy:metadata:auth_oidc_sid'] = 'Identifiants de session de l’IdP (sid) utilisés pour retrouver les utilisateurs Moodle connectés lorsqu’une déconnexion unique (SLO) est déclenchée depuis l’IdP';
$string['privacy:metadata:auth_oidc_sid:userid'] = 'L’ID de l’utilisateur Moodle';
$string['privacy:metadata:auth_oidc_sid:sid'] = 'L’identifiant de session de l’IdP (sid)';
$string['privacy:metadata:auth_oidc_sid:timecreated'] = 'La date de création de la correspondance';
$string['privacy:metadata:auth_oidc_sid:sessionid'] = 'L’ID de la session Moodle active au moment de la création de la correspondance';
$string['privacy:metadata:auth_oidc_sid:iss'] = 'L’émetteur (revendication iss) de l’id_token à partir duquel la correspondance a été créée';

// In the following strings, $a refers to a customizable name for the identity manager. For example, this could be
// "Microsoft 365", "OpenID Connect", etc.
$string['ucp_general_intro'] = 'Vous pouvez gérer votre connexion à {$a} ici. Si cette option est activée, vous pourrez utiliser votre compte {$a} pour vous connecter à Moodle au lieu d’un nom d’utilisateur et d’un mot de passe distincts. Une fois connecté, vous n’aurez plus à mémoriser votre nom d’utilisateur et votre mot de passe pour Moodle ; toutes les connexions seront gérées par {$a}.';
$string['ucp_login_start'] = 'Commencer à utiliser {$a} pour se connecter à Moodle';
$string['ucp_login_start_desc'] = 'Votre compte passera à {$a} pour la connexion à Moodle. Une fois ce réglage activé, vous vous connecterez à l’aide de vos informations d’identification {$a} (votre mot de passe et votre nom d’utilisateur Moodle actuels ne fonctionneront pas). Vous pouvez vous déconnecter de votre compte à tout moment et utiliser de nouveau la méthode d’authentification habituelle Moodle.';
$string['ucp_login_stop'] = 'Cesser d’utiliser {$a} pour se connecter à Moodle';
$string['ucp_login_stop_desc'] = 'Vous utilisez actuellement {$a} pour vous connecter à Moodle. Cliquez sur « Cesser d’utiliser {$a} pour se connecter à Moodle » pour déconnecter votre compte Moodle de {$a}. Vous ne pourrez plus vous connecter à Moodle avec votre compte {$a}. Vous serez invité à créer un nom d’utilisateur et un mot de passe, et vous pourrez ensuite vous connecter directement à Moodle.';
$string['ucp_login_status'] = 'Connexion {$a} :';
$string['ucp_status_enabled'] = 'Activé';
$string['ucp_status_disabled'] = 'Désactivé';
$string['ucp_disconnect_title'] = 'Déconnexion {$a}';
$string['ucp_disconnect_details'] = 'Cette opération déconnectera votre compte Moodle de {$a}. Vous aurez besoin de créer un nom d’utilisateur et un mot de passe pour vous connecter à Moodle.';
$string['ucp_title'] = 'Gestion de {$a}';
$string['ucp_o365accountconnected'] = 'Ce compte Microsoft 365 est déjà associé à un autre compte Moodle.';

// Clean up OIDC tokens.
$string['cleanup_oidc_tokens'] = 'Nettoyer les jetons OpenID Connect';
$string['unmatched'] = 'Sans correspondance';
$string['delete_token'] = 'Supprimer le jeton';
$string['mismatched'] = 'Incohérent';
$string['na'] = 'n/d';
$string['mismatched_details'] = 'L’enregistrement du jeton contient le nom d’utilisateur « {$a->tokenusername} » ; l’utilisateur Moodle correspondant a le nom d’utilisateur « {$a->moodleusername} ».';
$string['delete_token_and_reference'] = 'Supprimer le jeton et la référence';
$string['table_token_id'] = 'ID de l’enregistrement du jeton';
$string['table_oidc_username'] = 'Nom d’utilisateur OIDC';
$string['table_oidc_unique_identifier'] = 'Identifiant unique OIDC';
$string['table_token_unique_id'] = 'ID unique OIDC';
$string['table_matching_status'] = 'Statut de correspondance';
$string['table_matching_details'] = 'Détails';
$string['table_action'] = 'Action';
$string['token_deleted'] = 'Le jeton a été supprimé';
$string['no_token_to_cleanup'] = 'Il n’y a aucun jeton OIDC à nettoyer.';

$string['errorusermatched'] = 'Le compte Microsoft 365 « {$a->entraidupn} » est déjà mis en correspondance avec l’utilisateur Moodle « {$a->username} ». Pour terminer la connexion, veuillez d’abord vous connecter en tant que cet utilisateur Moodle et suivre les instructions du bloc Microsoft.';

// User mapping options.
$string['update_oncreate_and_onlogin'] = 'À la création et à chaque connexion';
$string['update_oncreate_and_onlogin_and_usersync'] = 'À la création, à chaque connexion et à chaque exécution de la tâche de synchronisation des utilisateurs';
$string['update_oncreate_and_usersync'] = 'À la création et à chaque exécution de la tâche de synchronisation des utilisateurs';
$string['update_onlogin_and_usersync'] = 'À chaque connexion et à chaque exécution de la tâche de synchronisation des utilisateurs';
$string['upgradeoidcuniqidtoolong'] = 'La mise à niveau ne peut pas continuer : certains enregistrements auth_oidc_token ont un oidcuniqid de plus de 200 caractères, que la nouvelle longueur de colonne tronquerait. Veuillez supprimer ces enregistrements de jetons et relancer la mise à niveau.';

// Remote fields.
$string['settings_fieldmap_feild_not_mapped'] = '(non mis en correspondance)';
$string['settings_fieldmap_field_bindingusernameclaim'] = 'Revendication de nom d’utilisateur de liaison (ne peut être mise en correspondance que lors de la connexion)';
$string['settings_fieldmap_field_city'] = 'Ville';
$string['settings_fieldmap_field_companyName'] = 'Nom de l’entreprise';
$string['settings_fieldmap_field_objectId'] = 'ID d’objet';
$string['settings_fieldmap_field_country'] = 'Pays';
$string['settings_fieldmap_field_department'] = 'Service';
$string['settings_fieldmap_field_displayName'] = 'Nom d’affichage';
$string['settings_fieldmap_field_surname'] = 'Nom de famille';
$string['settings_fieldmap_field_faxNumber'] = 'Numéro de fax';
$string['settings_fieldmap_field_telephoneNumber'] = 'Numéro de téléphone';
$string['settings_fieldmap_field_givenName'] = 'Prénom';
$string['settings_fieldmap_field_jobTitle'] = 'Fonction';
$string['settings_fieldmap_field_mail'] = 'Adresse de courriel';
$string['settings_fieldmap_field_mobile'] = 'Mobile';
$string['settings_fieldmap_field_postalCode'] = 'Code postal';
$string['settings_fieldmap_field_preferredLanguage'] = 'Langue';
$string['settings_fieldmap_field_state'] = 'État/Région';
$string['settings_fieldmap_field_streetAddress'] = 'Adresse postale';
$string['settings_fieldmap_field_userPrincipalName'] = 'Nom d’utilisateur principal (UPN)';
$string['settings_fieldmap_field_employeeId'] = 'ID d’employé';
$string['settings_fieldmap_field_employeeType'] = 'Type d’employé';
$string['settings_fieldmap_field_accountEnabled'] = 'Compte activé';
$string['settings_fieldmap_field_businessPhones'] = 'Téléphone professionnel';
$string['settings_fieldmap_field_mobilePhone'] = 'Téléphone mobile';
$string['settings_fieldmap_field_officeLocation'] = 'Bureau';
$string['settings_fieldmap_field_preferredName'] = 'Nom préféré';
$string['settings_fieldmap_field_manager'] = 'Nom du responsable';
$string['settings_fieldmap_field_manager_email'] = 'Adresse de courriel du responsable';
$string['settings_fieldmap_field_teams'] = 'Teams';
$string['settings_fieldmap_field_groups'] = 'Groupes';
$string['settings_fieldmap_field_roles'] = 'Rôles';
$string['settings_fieldmap_field_tokenclaim'] = '{$a} (revendication du jeton)';
$string['settings_fieldmap_field_onPremisesSamAccountName'] = 'Nom de compte SAM local';
$string['settings_fieldmap_field_extensionattribute'] = 'Attribut d’extension {$a}';
$string['settings_fieldmap_field_sds_school_id'] = 'ID d’établissement SDS ({$a})';
$string['settings_fieldmap_field_sds_school_name'] = 'Nom d’établissement SDS ({$a})';
$string['settings_fieldmap_field_sds_school_role'] = 'Rôle dans l’établissement SDS (« Student » ou « Teacher »)';
$string['settings_fieldmap_field_sds_student_externalId'] = 'ID externe de l’étudiant SDS';
$string['settings_fieldmap_field_sds_student_birthDate'] = 'Date de naissance de l’étudiant SDS';
$string['settings_fieldmap_field_sds_student_grade'] = 'Niveau scolaire de l’étudiant SDS';
$string['settings_fieldmap_field_sds_student_graduationYear'] = 'Année d’obtention du diplôme de l’étudiant SDS';
$string['settings_fieldmap_field_sds_student_studentNumber'] = 'Numéro d’étudiant SDS';
$string['settings_fieldmap_field_sds_teacher_externalId'] = 'ID externe de l’enseignant SDS';
$string['settings_fieldmap_field_sds_teacher_teacherNumber'] = 'Numéro d’enseignant SDS';

// Binding username claim options.
$string['binding_username_claim_warning'] = 'Il s’agit d’une fonctionnalité avancée. Dans la plupart des cas, elle doit rester réglée sur « Choisir automatiquement » ; une configuration incorrecte peut affecter les enregistrements des utilisateurs et perturber l’authentification unique (SSO).';
$string['binding_username_auto'] = 'Choisir automatiquement';
$string['binding_username_custom'] = 'Personnalisé';
$string['bindingusernameclaim'] = 'Revendication de nom d’utilisateur de liaison';
$string['customclaimname'] = 'Nom de la revendication personnalisée';
$string['customclaimname_description'] = 'Ce champ n’est utilisé que lorsque le réglage <b>Revendication de nom d’utilisateur de liaison</b> est défini sur <b>Personnalisé</b>.';
$string['binding_username_claim_tool_link_desc'] = 'Pour mettre à jour la revendication de nom d’utilisateur de liaison des utilisateurs existants, utilisez l’<a href="{$a}">Outil de modification de la revendication de nom d’utilisateur de liaison</a>.';
$string['cleanup_oidc_tokens_link_desc'] = 'Pour nettoyer les jetons OpenID Connect obsolètes, utilisez l’outil <a href="{$a}">Nettoyer les jetons OpenID Connect</a>.';
$string['clear_user_tokens_link_desc'] = 'Pour supprimer les jetons enregistrés de tous les utilisateurs ou d’utilisateurs sélectionnés, utilisez l’outil <a href="{$a}">Effacer les jetons des utilisateurs</a>.';
$string['clear_user_tokens'] = 'Effacer les jetons des utilisateurs';
$string['clear_user_tokens_desc'] = 'Supprime les jetons OpenID Connect et Microsoft 365 enregistrés pour les utilisateurs. Les utilisateurs concernés obtiendront de nouveaux jetons lors de leur prochaine connexion via OpenID Connect ou de leur prochaine connexion à Microsoft 365. Leurs liens avec les comptes Microsoft 365 sont conservés. ATTENTION : cette opération peut interrompre les connexions en cours ; il est donc préférable de l’effectuer pendant une période d’inactivité.';
$string['clear_user_tokens_scope_selected'] = 'Utilisateurs sélectionnés';
$string['clear_user_tokens_scope_all'] = 'Tous les utilisateurs';
$string['clear_user_tokens_users'] = 'Utilisateurs';
$string['clear_user_tokens_submit'] = 'Effacer les jetons';
$string['clear_user_tokens_no_name'] = '(sans nom)';
$string['clear_user_tokens_no_user_selected'] = 'Sélectionnez au moins un utilisateur.';
$string['clear_user_tokens_confirm_all'] = 'Voulez-vous vraiment effacer les jetons de tous les utilisateurs ? {$a} utilisateur(s) possède(nt) actuellement des jetons.';
$string['clear_user_tokens_confirm_selected'] = 'Voulez-vous vraiment effacer les jetons des utilisateurs sélectionnés ? {$a} des utilisateurs sélectionnés possède(nt) actuellement des jetons.';
$string['clear_user_tokens_success'] = '{$a} enregistrement(s) de jetons effacé(s).';
$string['binding_username_claim_help_ms_no_user_sync'] = 'Les options disponibles pour un IdP Microsoft sans la fonctionnalité de synchronisation des utilisateurs activée sont :
<ul>
<li><b>Choisir automatiquement</b> : utilise la logique actuelle, en déterminant le jeton selon le type d’IdP et en se rabattant sur <b>sub</b> si aucune revendication n’est trouvée.</li>
<li><b>preferred_username</b> : valeur par défaut pour le type d’IdP Microsoft identity platform (v2.0). <span class="not_support_user_sync">Ne prend pas en charge la synchronisation des utilisateurs.</span></li>
<li><b>email</b> : solution de repli pour Microsoft identity platform (v2.0).</li>
<li><b>upn</b> : valeur par défaut pour Microsoft Entra ID (v1.0) et les autres types d’IdP.</li>
<li><b>unique_name</b> : solution de repli pour Microsoft Entra ID (v1.0) et les autres types d’IdP. <span class="not_support_user_sync">Ne prend pas en charge la synchronisation des utilisateurs.</span></li>
<li><b>oid</b> : solution de repli si aucune autre revendication n’est présente. Présente uniquement dans les IdP Microsoft.</li>
<li><b>sub</b> : solution de repli si aucune autre revendication n’est présente. <span class="not_support_user_sync">Ne prend pas en charge la synchronisation des utilisateurs.</span></li>
<li><b>samaccountname</b> : revendication personnalisée.</li>
<li><b>Personnalisé</b> : permet à l’administrateur du site de saisir une valeur personnalisée. <span class="not_support_user_sync">Ne prend pas en charge la synchronisation des utilisateurs.</span></li>
</ul>
Notez que certaines options ne prennent pas en charge la synchronisation des utilisateurs.';
$string['binding_username_claim_help_ms_with_user_sync'] = 'Les options disponibles pour un IdP Microsoft avec la fonctionnalité de synchronisation des utilisateurs activée sont :
<ul>
<li><b>Choisir automatiquement</b> : utilise la logique actuelle, en déterminant le jeton selon le type d’IdP et en se rabattant sur <b>sub</b> si aucune revendication n’est trouvée.</li>
<li><b>email</b> : solution de repli pour Microsoft identity platform (v2.0).</li>
<li><b>upn</b> : valeur par défaut pour Microsoft Entra ID (v1.0) et les autres types d’IdP.</li>
<li><b>oid</b> : solution de repli si aucune autre revendication n’est présente. Présente uniquement dans les IdP Microsoft.</li>
<li><b>samaccountname</b> : revendication personnalisée.</li>
</ul>';
$string['binding_username_claim_help_non_ms'] = 'Les options disponibles pour les IdP non Microsoft sont :
<ul>
<li><b>Choisir automatiquement</b> : utilise la logique actuelle, en déterminant le jeton selon le type d’IdP et en se rabattant sur <b>sub</b> si aucune revendication n’est trouvée.</li>
<li><b>preferred_username</b></li>
<li><b>email</b></li>
<li><b>unique_name</b></li>
<li><b>sub</b></li>
<li><b>samaccountname</b></li>
<li><b>custom</b> : revendication personnalisée.</li>
</ul>';
$string['warning_binding_username_claim_custom_unsupported'] = 'Le réglage « Revendication de nom d’utilisateur de liaison » est actuellement défini sur « Personnalisé », ce qui n’est pas pris en charge pour le type d’IdP configuré lorsque la synchronisation des utilisateurs est activée. Vérifiez les réglages de la <a href="{$a}">Revendication de nom d’utilisateur de liaison</a>.';
$string['examplecsv'] = 'Exemple de fichier à déposer';
$string['usernamefile'] = 'Fichier';
$string['csvdelimiter'] = 'Séparateur CSV';
$string['encoding'] = 'Codage';
$string['rowpreviewnum'] = 'Lignes à prévisualiser';
$string['upload_usernames'] = 'Mettre à jour les noms d’utilisateur de liaison';
$string['update_stats_users_updated'] = '{$a} utilisateurs ont été mis à jour';
$string['update_stats_users_errors'] = '{$a} utilisateurs ont rencontré des erreurs';
$string['update_error_incomplete_line'] = 'La ligne ne contient pas les champs requis.';
$string['update_error_user_not_found'] = 'Aucun utilisateur ne correspond au nom d’utilisateur. Une tentative de mise à jour de l’utilisateur mis en correspondance manuellement va être effectuée.';
$string['update_error_user_not_oidc'] = 'L’utilisateur n’utilise pas la méthode d’authentification OpenID Connect. Une tentative de mise à jour de l’utilisateur mis en correspondance manuellement va être effectuée.';
$string['update_error_invalid_new_username'] = 'Le nouveau nom d’utilisateur n’est pas valide.';
$string['update_error_user_update_failed'] = 'Échec de la mise à jour de l’utilisateur.';
$string['update_warning_email_match'] = 'L’adresse de courriel correspond à un utilisateur existant.';
$string['update_success_username'] = 'Nom d’utilisateur mis à jour.';
$string['update_success_token'] = 'Jeton mis à jour.';
$string['update_success_o365'] = 'Enregistrement de connexion Microsoft 365 mis à jour.';
$string['update_error_nothing_updated'] = 'Rien n’a été mis à jour.';
$string['error_invalid_upload_file'] = 'Fichier déposé non valide.';
$string['csvline'] = 'Ligne CSV';
$string['change_binding_username_claim_tool_description'] = '<p class="warning_header">Il s’agit d’une fonctionnalité avancée. Une utilisation incorrecte peut affecter les enregistrements des utilisateurs et perturber l’authentification unique (SSO).</p>
<p>Cet outil permet aux administrateurs du site de mettre à jour en masse les enregistrements suivants :</p>
<ul>
<li>les noms d’utilisateur des comptes Moodle,</li>
<li>les noms d’utilisateur de liaison dans les jetons d’ID OpenID Connect enregistrés,</li>
<li>les enregistrements de connexion entre les comptes Moodle et Microsoft.</li>
</ul>
<p>Il ne doit être utilisé que lors de la modification des réglages de <b>Revendication de nom d’utilisateur de liaison</b>.</p>
<p>L’outil accepte un simple fichier CSV à deux colonnes :</p>
<ul>
<li><b><span class="auth_oidc_code">username</span></b> : le nom d’utilisateur actuel du compte Moodle à mettre à jour ou, si l’utilisateur actuel est mis en correspondance manuellement, la valeur actuelle de la revendication de liaison.</li>
<li><b><span class="auth_oidc_code">new_username</span></b> : la valeur, sensible à la casse, de la nouvelle revendication du jeton à utiliser comme revendication de nom d’utilisateur de liaison. Si l’utilisateur est mis en correspondance automatiquement et utilise le type d’authentification OpenID Connect, cette valeur en minuscules sera utilisée comme nom d’utilisateur Moodle.</li>
</ul>
<p>Lorsque le fichier est déposé, l’outil effectue les actions suivantes :</p>
<ol>
<li>Rechercher un utilisateur Moodle existant dont le nom d’utilisateur ou l’adresse de courriel correspond au <span class="auth_oidc_code">username</span> indiqué et qui utilise la méthode d’authentification OpenID Connect ; s’il est trouvé, remplacer son nom d’utilisateur par la valeur en minuscules de <span class="auth_oidc_code">new_username</span>.</li>
<li>Mettre à jour l’enregistrement du jeton OpenID Connect.
<ul>
<li>Si un utilisateur a été trouvé à l’étape 1 ci-dessus, rechercher l’enregistrement de son jeton dans la table <span class="auth_oidc_code">auth_oidc_token</span>, puis définir la colonne <span class="auth_oidc_code">username</span> sur la valeur en minuscules de <span class="auth_oidc_code">new_username</span> et la colonne <span class="auth_oidc_code">oidcusername</span> sur la valeur de <span class="auth_oidc_code">new_username</span>.</li>
<li>Si aucun enregistrement n’a été trouvé ci-dessus, l’outil tente de trouver un enregistrement dans la table <span class="auth_oidc_code">auth_oidc_token</span> dont la colonne <span class="auth_oidc_code">oidcusername</span> correspond à l’ancien <span class="auth_oidc_code">username</span>, et le met à jour avec <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
<li>Si le plugin <span class="auth_oidc_code">local_o365</span> est installé, mettre à jour l’enregistrement de connexion de l’utilisateur.
<ul>
<li>Si un utilisateur a été trouvé à l’étape 1 ci-dessus, rechercher son enregistrement de connexion dans la table <span class="auth_oidc_code">local_o365_objects</span>, puis définir la colonne <span class="auth_oidc_code">o365name</span> sur la valeur de <span class="auth_oidc_code">new_username</span>.</li>
<li>Si aucun utilisateur n’a été trouvé à l’étape 1, l’outil tente de trouver un enregistrement d’utilisateur dans la table <span class="auth_oidc_code">local_o365_objects</span> dont la colonne <span class="auth_oidc_code">o365name</span> correspond à la valeur de <span class="auth_oidc_code">username</span>, et le met à jour avec la valeur de <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
</ol>
<p>L’exemple de fichier ci-dessous changerait la revendication de nom d’utilisateur de liaison de <span class="auth_oidc_code">upn</span> ou <span class="auth_oidc_code">email</span> à <span class="auth_oidc_code">oid</span>.</p>';
$string['change_binding_username_claim_tool_result'] = 'Résultats de la mise à jour';
$string['update_username_results'] = 'Résultats de la mise à jour des noms d’utilisateur';
$string['new_username'] = 'Nouveau nom d’utilisateur';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
