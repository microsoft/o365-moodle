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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Intégration de Microsoft 365';

// Settings - tabs.
$string['settings_pageheading'] = 'Configuration de {$a}';
$string['settings_header_setup'] = 'Configuration';
$string['settings_header_usersync'] = 'Synchronisation des utilisateurs';
$string['settings_header_coursesync'] = 'Synchronisation des cours';
$string['settings_header_advanced'] = 'Avancé';
$string['settings_header_sds'] = 'Synchronisation SDS';
$string['settings_header_teams'] = 'Réglages Teams';
$string['settings_header_moodle_app'] = 'Application Moodle pour Teams';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'Étape 1/2 : Inscrire Moodle auprès de Microsoft Entra ID';
$string['settings_setup_step1_desc'] = 'Inscrivez une nouvelle application Microsoft Entra ID pour l’intégration de Moodle à l’aide de PowerShell :

<a href="{$a}/local/o365/scripts/Moodle-EntraID-PowerShell.zip" class="btn btn-primary" target="_blank">Télécharger le script PowerShell</a>

<p style="margin-top:10px"><a href="{$a}/local/o365/scripts/README.md" target="_blank">Cliquez ici</a> pour lire les instructions d’exécution du script.</p>
<p>Lorsque cela vous est demandé, utilisez le lien suivant comme URL Moodle :</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />Une fois le script exécuté avec succès, copiez l’ID d’application et le secret renvoyés par le script dans la <a href="{$a}">page de configuration du plugin d’authentification OpenID Connect</a>.';
$string['settings_setup_step1_credentials_end'] = 'Si vous ne parvenez pas à configurer l’application Microsoft Entra ID via PowerShell, <a href="{$a}" target="_blank">cliquez ici</a> pour obtenir les instructions de configuration manuelle.';
$string['settings_setup_step1_continue'] = '<b>Une fois l’ID d’application et le secret saisis, cliquez sur « Enregistrer » au bas de la page pour continuer.</b><br /><br /><br /><br /><br />';
$string['settings_setup_step1_existing_settings'] = '<h5>Réglages existants</h5>';
$string['settings_setup_step2'] = 'Étape 2/2 : Consentement administrateur et informations supplémentaires';
$string['settings_setup_step2_desc'] = 'Cette dernière étape vous permet de donner le consentement administrateur pour l’utilisation de certaines autorisations Microsoft Entra ID, et recueille des informations supplémentaires sur votre environnement Microsoft 365.<br /><br />';
$string['settings_setup_step3'] = 'Vérifier la configuration';
$string['settings_setup_step3_desc'] = 'La configuration est terminée. Cliquez sur le bouton « Mettre à jour » ci-dessous pour vérifier votre configuration.';

// Settings in "Step 2/2" section of the "Setup" tab.
$string['settings_adminconsent'] = 'Consentement administrateur';
$string['settings_adminconsent_btn'] = 'Donner le consentement administrateur';
$string['settings_adminconsent_details'] = 'Pour autoriser l’accès à certaines des autorisations nécessaires, un administrateur doit donner son consentement. Cliquez sur ce bouton, puis connectez-vous avec un compte administrateur Microsoft Entra ID pour donner ce consentement. Cette opération doit être effectuée chaque fois que vous modifiez des autorisations « Admin » dans Entra ID.';
$string['settings_entratenant'] = 'Locataire Microsoft Entra';
$string['settings_entratenant_details'] = 'Utilisé pour identifier votre organisation auprès de Microsoft. Par exemple : « contoso.onmicrosoft.com ».<br/>
Pour trouver cette valeur manuellement :
<ul>
<li>Accédez au <a href="https://portal.azure.com" target="_blank">Azure Portal</a>.</li>
<li>Connectez-vous avec votre compte administrateur.</li>
<li>Dans la barre de recherche, saisissez « Microsoft Entra ID », puis accédez à la page « Microsoft Entra ID ».</li>
<li>Utilisez la valeur du champ <b>Domaine principal</b> dans la section « Informations de base ».</li>
</ul>';
$string['settings_odburl'] = 'URL OneDrive Entreprise';
$string['settings_odburl_details'] = 'URL utilisée pour accéder à OneDrive Entreprise. Elle peut généralement être déterminée à partir de votre locataire Microsoft Entra. Par exemple, si votre locataire Microsoft Entra est « contoso.onmicrosoft.com », il s’agit très probablement de « contoso-my.sharepoint.com ». Saisissez uniquement le nom de domaine, sans http:// ni https://';
$string['settings_odburl_error_graph'] = 'Impossible de déterminer l’URL de votre OneDrive Entreprise, veuillez la saisir manuellement. Elle peut généralement être déterminée à partir de l’URL que vous utilisez pour accéder à OneDrive.';
$string['settings_serviceresourceabstract_detect'] = 'Détecter';
$string['settings_serviceresourceabstract_detecting'] = 'Détection...';
$string['settings_serviceresourceabstract_error'] = 'Une erreur est survenue lors de la détection du réglage. Veuillez le définir manuellement.';
$string['settings_serviceresourceabstract_valid'] = '{$a} est utilisable.';
$string['settings_serviceresourceabstract_invalid'] = 'Cette valeur ne semble pas utilisable.';
$string['settings_serviceresourceabstract_nocreds'] = 'Définissez d’abord les informations d’identification d’application.';
$string['settings_serviceresourceabstract_empty'] = 'Saisissez une valeur ou cliquez sur « Détecter » pour tenter de détecter la valeur correcte.';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_verifysetup'] = 'Vérifier la configuration';
$string['settings_verifysetup_appdataheader'] = 'Inscription d’application Microsoft Entra ID';
$string['settings_verifysetup_appdatadesc'] = 'Vérifie que les réglages corrects sont configurés dans l’application Entra ID.';
$string['settings_verifysetup_appdatareplyurlcorrect'] = 'URL de réponse correcte';
$string['settings_verifysetup_appdatareplyurlincorrect'] = 'URL de réponse incorrecte';
$string['settings_verifysetup_appdatareplyurlgeneralerror'] = 'Impossible de vérifier l’URL de réponse.';
$string['settings_verifysetup_appdatasignonurlcorrect'] = 'URL de connexion correcte.';
$string['settings_verifysetup_appdatasignonurlincorrect'] = 'URL de connexion incorrecte';
$string['settings_verifysetup_appdatasignonurlgeneralerror'] = 'Impossible de vérifier l’URL de connexion.';
$string['settings_verifysetup_apppermscorrect'] = 'Les autorisations d’application sont correctes.';
$string['settings_verifysetup_details'] = 'Cet outil vérifie auprès de Microsoft Entra ID que tout est configuré correctement. <br /><b>Remarque :</b> les modifications apportées à l’application Microsoft Entra ID peuvent mettre un moment à apparaître ici. Si vous avez modifié l’application Microsoft Entra ID et que la modification n’apparaît pas ici, patientez un moment et réessayez.';
$string['settings_verifysetup_correctval'] = 'Valeur correcte :';
$string['settings_verifysetup_detectedval'] = 'Valeur détectée :';
$string['settings_verifysetup_update'] = 'Mettre à jour';
$string['settings_verifysetup_checking'] = 'Vérification...';
$string['settings_verifysetup_missingappperms'] = 'Autorisations d’application manquantes :';
$string['settings_verifysetup_notgranted'] = 'ajoutée à l’application, mais le consentement administrateur n’a pas été accordé';
$string['settings_verifysetup_missingperms'] = 'Autorisations déléguées manquantes :';
$string['settings_verifysetup_permscorrect'] = 'Les autorisations déléguées sont correctes.';
$string['settings_verifysetup_errorcheck'] = 'Une erreur s’est produite lors de la tentative de vérification de la configuration.';
$string['settings_verifysetup_noinfo'] = 'Nous ne disposons encore d’aucune information sur la configuration de votre application Microsoft Entra ID. Cliquez sur le bouton « Mettre à jour » pour la vérifier.';
$string['settings_verifysetup_strunifiedpermerror'] = 'Une erreur est survenue lors de la vérification des autorisations de l’API Microsoft Graph.';
$string['settings_verifysetup_strtenanterror'] = 'Utilisez le bouton « Détecter » pour définir votre locataire Microsoft Entra avant de mettre à jour la configuration de l’application Microsoft Entra ID.';
$string['settings_verifysetup_unifiedheader'] = 'API Microsoft Graph';
$string['settings_verifysetup_unifieddesc'] = 'L’API Microsoft Graph permet la communication entre Moodle et Microsoft 365.';
$string['settings_verifysetup_unifiederror'] = 'Une erreur est survenue lors de la vérification de la prise en charge de l’API Microsoft Graph.';
$string['settings_verifysetup_unifiedactive'] = 'API Microsoft Graph active.';
$string['settings_verifysetup_unifiedmissing'] = 'L’API Microsoft Graph est introuvable dans cette application.';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc_credsvalid'] = 'Les informations d’identification ont été définies.';
$string['settings_detectoidc_credsvalid_link'] = 'Modifier';
$string['settings_detectoidc_credsinvalid'] = 'Les informations d’identification n’ont pas été définies ou sont incomplètes.';
$string['settings_detectoidc_credsinvalid_link'] = 'Définir des informations d’identification';
$string['settings_detectperms_nocreds'] = 'Vous devez d’abord définir les informations d’identification d’application. Reportez-vous au réglage ci-dessus.';
$string['settings_detectperms_errorfix'] = 'Une erreur est survenue lors de la tentative de correction des autorisations. Veuillez les corriger manuellement dans Microsoft Entra ID.';
$string['settings_detectperms_fixperms'] = 'Corriger les autorisations';
$string['settings_detectperms_update'] = 'Mettre à jour';
$string['settings_detectperms_valid'] = 'Les autorisations ont été configurées.';
$string['settings_detectperms_invalid'] = 'Vérifier les autorisations dans Microsoft Entra ID';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_usersync_general'] = 'Synchronisation générale des utilisateurs';
$string['settings_usersync_suspension'] = 'Suspension des comptes Moodle';
$string['settings_usersync_matching'] = 'Correspondance des utilisateurs';
$string['settings_usersync_photos'] = 'Synchroniser les photos de profil Microsoft 365 vers Moodle';
$string['settings_usersync_timezone'] = 'Synchroniser le fuseau horaire Outlook vers Moodle';
$string['settings_usersync'] = 'Synchroniser les utilisateurs depuis Microsoft Entra ID';
$string['settings_usersync_details'] = 'Lorsque ce réglage est activé, Moodle synchronise les utilisateurs depuis Microsoft Entra ID conformément aux options ci-dessus.<br /><br /><b>Remarque : </b>la tâche de synchronisation s’exécute dans le cron Moodle et synchronise 1 000 utilisateurs à la fois. Par défaut, elle est exécutée une fois par jour à 1h00 dans le fuseau horaire local de votre serveur. Pour synchroniser plus rapidement de nombreux utilisateurs, vous pouvez augmenter la fréquence de la tâche <b>Synchroniser les utilisateurs depuis Microsoft Entra ID</b> à l’aide de la <a href="{$a}">page de gestion des tâches programmées.</a><br /><br />';
$string['settings_usersync_create'] = 'Créer dans Moodle des comptes pour les utilisateurs de Microsoft Entra ID';
$string['settings_usersync_update'] = 'Mettre à jour dans Moodle les comptes des utilisateurs de Microsoft Entra ID';
$string['settings_usersync_suspend'] = 'Suspendre dans Moodle les comptes précédemment synchronisés lorsqu’ils sont supprimés de Microsoft Entra ID';
$string['settings_usersync_delete'] = 'Supprimer dans Moodle les comptes précédemment synchronisés lorsqu’ils sont supprimés de Microsoft Entra ID';
$string['settings_usersync_reenable'] = 'Réactiver les comptes suspendus des utilisateurs présents dans Microsoft Entra ID';
$string['settings_usersync_disabledsyncsuspend'] = 'Suspendre les comptes dans Moodle lorsqu’ils sont désactivés dans Microsoft Entra ID';
$string['settings_usersync_disabledsyncreenable'] = 'Réactiver les comptes dans Moodle lorsqu’ils sont réactivés dans Microsoft Entra ID';
$string['settings_usersync_suspendnolink'] = 'Suspendre les comptes connectés sans lien Microsoft enregistré lorsqu’ils sont supprimés ou désactivés dans Microsoft Entra ID';
$string['settings_usersync_groupsyncsuspend'] = 'Suspendre les comptes dans Moodle lorsqu’ils ne font pas partie du groupe de synchronisation des utilisateurs configuré';
$string['settings_usersync_match'] = 'Faire correspondre les utilisateurs Moodle préexistants avec les comptes du même nom dans Microsoft Entra ID';
$string['settings_usersync_matchswitchauth'] = 'Basculer les utilisateurs mis en correspondance vers l’authentification Microsoft 365 (OpenID Connect)';
$string['settings_usersync_appassign'] = 'Attribuer les utilisateurs à l’application lors de la synchronisation';
$string['settings_usersync_photosync'] = 'Synchroniser les photos de profil Microsoft 365 vers Moodle dans la tâche cron';
$string['settings_usersync_photosynconlogin'] = 'Synchroniser les photos de profil Microsoft 365 vers Moodle à la connexion';
$string['settings_usersync_nodelta'] = 'Effectuer une synchronisation complète à chaque exécution';
$string['settings_usersync_emailsync'] = 'Faire correspondre les noms d’utilisateur Microsoft Entra ID aux adresses de courriel Moodle plutôt qu’aux noms d’utilisateur Moodle lors de la synchronisation';
$string['settings_addsync_tzsync'] = 'Synchroniser le fuseau horaire Outlook vers Moodle dans la tâche cron';
$string['settings_addsync_tzsynconlogin'] = 'Synchroniser le fuseau horaire Outlook vers Moodle à la connexion';
$string['settings_usersync_guestsync'] = 'Synchroniser les utilisateurs invités';
$string['settings_suspend_delete_running_time'] = 'Heure d’exécution de la suspension/suppression des utilisateurs';
$string['settings_suspend_delete_running_time_desc'] = 'Si l’option est activée, la fonctionnalité de suspension/suppression de la synchronisation des utilisateurs s’exécutera une fois par jour, à l’heure configurée dans le fuseau horaire par défaut de l’instance Moodle.';
$string['settings_usersync_delete_delay'] = 'Délai avant la suppression des utilisateurs suspendus';
$string['settings_usersync_delete_delay_desc'] = 'Durée minimale pendant laquelle un utilisateur doit rester suspendu dans Moodle avant que la synchronisation des utilisateurs ne supprime le compte. Ce délai s’ajoute à la période de conservation après suppression réversible de Microsoft Entra ID, de sorte que la suppression n’a jamais lieu avant la fin de celle-ci. Indiquez 0 pour supprimer dès la fin de la période de conservation de Microsoft Entra ID. Pour les utilisateurs déjà suspendus avant l’introduction de ce réglage, le délai est compté à partir de la première exécution de la synchronisation des utilisateurs qui les détecte.';
$string['settings_support_user_identifier_change'] = 'Prendre en charge la modification de la valeur de la revendication de nom d’utilisateur liant le compte Microsoft';
$string['settings_support_user_identifier_change_desc'] = 'Si ce réglage est activé, Moodle tentera de réagir lorsque la valeur de la revendication de nom d’utilisateur de liaison (normalement l’UPN) d’un compte Microsoft connecté à un compte Moodle est modifiée.<br/>
<table class="flexible table table-striped table-hover generaltable generalbox table-sm">
    <tr>
        <th>N° de cas</th>
        <th>L’utilisateur s’est-il déjà connecté avec l’ancien nom d’utilisateur ? (jeton créé)<br/>
        <span class="support_user_identifier_change_case_detail">Indique si un jeton est enregistré dans la table auth_oidc_token</span>
        </th>
        <th>Première action après le changement d’UPN<br/>
        <span class="support_user_identifier_change_case_detail">Connexion ou exécution de la tâche de synchronisation des utilisateurs</span>
        </th>
        <th>Doublon potentiel de nom d’utilisateur<br/>
        <span class="support_user_identifier_change_case_detail">Indique si le renommage provoquerait un conflit de nom d’utilisateur dans Moodle</span>
        </th>
        <th>Comportements attendus</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Oui</td>
        <td>Connexion</td>
        <td>Non</td>
        <td>
            <ol>
                <li>Renommer l’utilisateur Moodle.</li>
                <li>auth_oidc_token mis à jour avec les nouvelles valeurs des champs « username » et « oidcusername ».</li>
                <li>Champ « o365name » de l’enregistrement de connexion utilisateur local_o365_objects mis à jour avec la nouvelle valeur.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Oui</td>
        <td>Synchronisation des utilisateurs</td>
        <td>Non</td>
        <td>
            <ol>
                <li>Renommer l’utilisateur Moodle.</li>
                <li>Enregistrement de connexion utilisateur local_o365_objects mis à jour.</li>
                <li>auth_oidc_token mis à jour.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>Non</td>
        <td>Connexion</td>
        <td>Non</td>
        <td>
            <ol>
                <li>Renommer l’utilisateur Moodle.</li>
                <li>Enregistrement de connexion utilisateur local_o365_objects mis à jour.</li>
                <li>auth_oidc_token mis à jour.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>Non</td>
        <td>Synchronisation des utilisateurs</td>
        <td>Non</td>
        <td>
            <ol>
                <li>Renommer l’utilisateur Moodle.</li>
                <li>Enregistrement de connexion utilisateur local_o365_objects mis à jour.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>Oui</td>
        <td>Connexion</td>
        <td>Oui</td>
        <td>
            <ol>
                <li>Lever une exception et ne pas renommer l’utilisateur Moodle.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>Oui</td>
        <td>Synchronisation des utilisateurs</td>
        <td>Oui</td>
        <td>
            <ol>
                <li>Afficher un message d’erreur indiquant l’échec de la tentative de renommage lors de l’exécution de la tâche de synchronisation des utilisateurs.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>Non</td>
        <td>Connexion</td>
        <td>Oui</td>
        <td>
            <ol>
                <li>Lever une exception et ne pas renommer l’utilisateur Moodle.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>Non</td>
        <td>Synchronisation des utilisateurs</td>
        <td>Oui</td>
        <td>
            <ol>
                <li>Afficher un message d’erreur indiquant l’échec de la tentative de renommage lors de l’exécution de la tâche de synchronisation des utilisateurs.</li>
            </ol>
        </td>
    </tr>
</table>
Notez qu’il existe un problème connu : si
<ol>
<li>Moodle et Microsoft 365 sont connectés avec la méthode de connexion « Microsoft identity platform (v2.0) », et</li>
<li>Microsoft Entra est configuré pour autoriser l’utilisation de « l’adresse de courriel comme ID de connexion alternatif », et</li>
<li>cette option est activée, et</li>
<li>le nom d’utilisateur et l’adresse de courriel du compte Microsoft sont différents, et</li>
<li>l’utilisateur Microsoft se connecte avec son adresse de courriel plutôt qu’avec son nom d’utilisateur</li>
</ol>
alors le plugin auth_oidc traitera l’adresse de courriel comme le nom d’utilisateur du compte Microsoft et mettra à jour le nom d’utilisateur Moodle.';

// User field mapping.
$string['settings_fieldmap'] = 'Correspondance des champs utilisateur';
$string['settings_fieldmap_details'] = 'Disponible dans le <a href="{$a}">plugin d’authentification OpenID Connect</a>.';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'Synchronisation des cours';
$string['settings_secthead_coursesync_desc'] = 'Les réglages suivants contrôlent la synchronisation des cours entre Moodle et Microsoft Teams.';
$string['settings_coursesync'] = 'Synchronisation des cours';
$string['settings_coursesync_details'] = 'Si ce réglage est activé, des équipes seront créées et maintenues pour les cours du site Moodle (par défaut : désactivé). Les équipes nécessaires seront créées à chaque exécution du cron, et tous les utilisateurs actuellement inscrits y seront ajoutés comme propriétaires ou membres, selon la vérification des capacités. Ensuite, l’appartenance aux équipes sera maintenue à mesure que les utilisateurs sont inscrits aux cours Moodle ou désinscrits.';
$string['acp_coursesynccustom_off'] = 'Désactivé<br />Désactiver la création d’équipes pour tous les cours.';
$string['acp_coursesynccustom_oncustom'] = 'Personnaliser<br />Permet aux utilisateurs autorisés de choisir les cours pour lesquels créer des équipes.<br> <span id="adminsetting_coursesync" style="font-weight: bold"><a href="{$a}">Personnaliser la synchronisation des cours</a></span>';
$string['acp_coursesynccustom_onall'] = 'Toutes les fonctionnalités activées<br />Active la création d’équipes pour tous les cours.';
$string['settings_coursesync_sync_hidden_courses'] = 'Synchroniser les cours cachés';
$string['settings_coursesync_sync_hidden_courses_desc'] = 'Par défaut, le plugin ignore les cours cachés afin d’éviter de synchroniser des cours en cours de copie ou de restauration. Activez ce réglage pour forcer la création d’équipes pour les cours cachés.';
$string['acp_coursesync_hidden_course_note'] = 'Remarque : les cours cachés ne seront pas traités pour la création de groupes Teams. Pour l’autoriser, vous devez activer le réglage « Synchroniser les cours cachés » dans la configuration du plugin.';
$string['settings_coursesync_delete_group_on_course_deletion'] = 'Supprimer les groupes Microsoft 365 lorsque le cours Moodle connecté est supprimé';
$string['settings_coursesync_delete_group_on_course_deletion_details'] = 'Si ce réglage est activé, Moodle tentera de supprimer le groupe Microsoft 365 (et l’équipe associée) lorsque le cours connecté est supprimé de Moodle. Notez que cela ne s’applique pas aux cours créés par la synchronisation SDS.';
$string['settings_coursesync_delete_group_on_course_sync_disabled'] = 'Supprimer les groupes Microsoft 365 lorsque la synchronisation du cours est désactivée';
$string['settings_coursesync_delete_group_on_course_sync_disabled_details'] = 'Si ce réglage est activé, Moodle tentera de supprimer le groupe Microsoft 365 connecté (et l’équipe associée) lorsque la synchronisation est désactivée pour un cours Moodle.';
$string['settings_coursesync_courses_per_task'] = 'Cours à synchroniser par exécution de tâche';
$string['settings_coursesync_courses_per_task_details'] = 'Nombre de cours dont l’état de synchronisation équipe/groupe est traité à chaque exécution de la tâche.';
$string['settings_coursesync_team_type'] = 'Modèle d’équipe';
$string['settings_coursesync_team_type_desc'] = 'Modèle Microsoft Teams à utiliser lors de la création d’équipes à partir de cours Moodle. Les modèles Éducation nécessitent une licence Éducation. <br><br><strong>Important :</strong> le modèle configuré détermine la façon dont les groupes et les équipes sont créés :<br>
&bull; Le modèle Standard crée des groupes et des équipes standard (compatibles avec tous les locataires).<br>
&bull; Les modèles Éducation créent des groupes/équipes Éducation (locataires Éducation uniquement ; active les fonctionnalités propres à l’éducation).<br>
&bull; Les modèles personnalisés utilisent des groupes standard (pour la compatibilité avec la conception des modèles personnalisés).<br><br>
<strong>⚠️ AVERTISSEMENT : une fois qu’une équipe a été créée avec un modèle donné, ce modèle ne peut plus être modifié.</strong> Les équipes restent associées à leur modèle d’origine. La modification de ce réglage n’affecte que les équipes nouvellement créées, pas les équipes existantes. Choisissez soigneusement votre modèle avant d’activer la synchronisation des cours.';
$string['settings_coursesync_team_type_standard'] = 'Standard';
$string['settings_coursesync_team_type_educationclass'] = 'Éducation - Équipe de classe';
$string['settings_coursesync_team_type_educationstaff'] = 'Éducation - Équipe du personnel';
$string['settings_coursesync_team_type_educationplc'] = 'Éducation - Communauté d’apprentissage professionnel (PLC)';
$string['settings_coursesync_team_type_custom'] = 'Modèle personnalisé';
$string['settings_coursesync_team_type_custom_id'] = 'ID du modèle personnalisé';
$string['settings_coursesync_team_type_custom_id_desc'] = 'ID complet d’un modèle personnalisé défini dans le Centre d’administration Teams. Utilisé uniquement lorsque « Modèle personnalisé » est sélectionné ci-dessus. <br><br><strong>L’ID du modèle doit être au format GUID</strong> (par exemple e41de7bb-859a-4a0f-aa39-5725a0529c1c). Vous trouverez l’ID du modèle dans le Centre d’administration Teams en affichant les détails de votre modèle personnalisé. <br><br>
<strong>⚠️ AUTORISATION MICROSOFT ENTRA ID SUPPLÉMENTAIRE REQUISE :</strong> la validation et l’utilisation de modèles d’équipe personnalisés nécessitent une autorisation d’application supplémentaire de l’API Microsoft Graph (<strong>TeamTemplates.Read.All</strong>), qui peut être absente de l’inscription de votre application Microsoft Entra ID. Sans cette autorisation, l’étape de validation échouera et l’ID du modèle personnalisé ne pourra pas être défini. Si la validation échoue avec une erreur d’autorisation, demandez à votre administrateur Microsoft Entra ID d’ajouter cette autorisation à l’inscription de votre application. <br><br>
<strong>⚠️ LIMITATION IMPORTANTE :</strong> le framework Microsoft Teams ne prend actuellement en charge la création d’équipes à partir de modèles personnalisés que si le modèle comporte une <strong>définition de paramètres régionaux en-US</strong>. La création d’équipes échouera avec les modèles personnalisés sans prise en charge des paramètres régionaux en-US. Assurez-vous que votre modèle personnalisé dispose de paramètres régionaux en-US définis dans le Centre d’administration Teams. <br><br>
<strong>⚠️ AVERTISSEMENT : une fois qu’une équipe a été créée avec ce modèle personnalisé, ce modèle ne peut plus être modifié.</strong> Si vous devez utiliser un autre modèle personnalisé pour les nouvelles équipes, vous devez laisser ce réglage vide ou le modifier avant la prochaine création d’équipe. Les équipes existantes continueront d’utiliser leur modèle d’origine. <br><br>
Les équipes ne seront pas créées correctement si un ID de modèle incorrect est configuré. Utilisez le bouton « Valider l’ID du modèle personnalisé » pour valider l’ID du modèle avant de lancer la synchronisation des cours.';
$string['error_custom_template_id_required'] = 'L’ID du modèle personnalisé est requis lorsque l’option « Modèle personnalisé » est utilisée. Veuillez saisir un ID de modèle valide.';
$string['error_custom_template_id_not_found'] = 'ID de modèle personnalisé « {$a} » introuvable. Veuillez vérifier que l’ID du modèle existe dans le Centre d’administration Teams.';
$string['error_custom_template_id_validation_failed'] = 'La validation de l’ID du modèle personnalisé a échoué. Le modèle ne prend peut-être pas en charge la création directe d’équipes, ou il peut y avoir un problème de configuration. Veuillez vérifier l’ID du modèle dans le Centre d’administration Teams.';
$string['settings_team_type_custom_id_test_button'] = 'Valider l’ID du modèle personnalisé';
$string['settings_team_type_custom_id_validating'] = '🔄 Validation...';
$string['settings_team_type_custom_id_error_empty'] = '⚠️ Veuillez d’abord saisir un ID de modèle.';
$string['settings_team_type_custom_id_error_not_found'] = '✗ Modèle introuvable. L’ID de modèle « {$a} » n’existe pas. Veuillez le vérifier dans le Centre d’administration Teams.';
$string['settings_team_type_custom_id_error_validation'] = '✗ Erreur de validation. {$a}';
$string['settings_team_type_custom_id_error_default'] = 'Échec de la validation du modèle. Veuillez réessayer ou contacter votre administrateur.';
$string['settings_team_type_custom_id_error_timeout'] = '✗ Délai de validation dépassé. La requête a pris plus de 10 secondes. Veuillez réessayer.';
$string['settings_team_type_custom_id_error_network'] = '✗ Erreur réseau. Impossible de joindre le service de validation. Veuillez vérifier votre connexion Internet et réessayer.';
$string['settings_team_type_custom_id_error_parsererror'] = '✗ Erreur de réponse du serveur. Le service de validation a renvoyé des données non valides. Veuillez vérifier votre intégration Microsoft 365.';
$string['settings_team_type_custom_id_error_http'] = '✗ Erreur de validation (HTTP {$a}). Veuillez réessayer ou contacter votre administrateur.';
$string['settings_coursesync_group_channels'] = 'Créer un canal pour chaque groupe Moodle';
$string['settings_coursesync_group_channels_details'] = 'Crée un canal privé dans l’équipe Microsoft Teams connectée pour chaque groupe du cours Moodle, et maintient les membres de chaque canal en phase avec les membres du groupe Moodle. Les membres du groupe également connectés à Microsoft 365 sont ajoutés au canal ou en sont retirés lorsqu’ils sont ajoutés au groupe ou en sont retirés. Toute personne ajoutée à un canal dans Microsoft Teams qui n’est pas membre du groupe Moodle en est à nouveau retirée. Dans une équipe de classe Éducation qui n’a pas encore été activée, les étudiants ne peuvent pas être placés dans des canaux : seuls les propriétaires le sont, et les étudiants sont ajoutés automatiquement par la tâche programmée « Créer des canaux Teams pour les groupes Moodle et synchroniser leurs membres » après qu’un propriétaire a activé l’équipe dans Microsoft Teams. Les canaux ne sont ni renommés ni supprimés lorsqu’un groupe Moodle est renommé ou supprimé. L’appartenance aux canaux n’est synchronisée que de Moodle vers Teams, et ce réglage n’a aucun effet si « Comportement de synchronisation des utilisateurs du cours » est défini sur « De Teams vers Moodle ». Microsoft Teams autorise jusqu’à 1 000 canaux par équipe, en comptant les canaux privés et les canaux supprimés au cours des 30 derniers jours.<br /><br /><b>Ce réglage nécessite deux autorisations d’application Microsoft Graph supplémentaires :</b><ul><li><b>Channel.Create</b> - pour créer les canaux.</li><li><b>ChannelMember.ReadWrite.All</b> - pour ajouter des membres aux canaux et en retirer.</li></ul>Les deux doivent être ajoutées à l’application Microsoft Entra ID utilisée par Moodle, avec le consentement administrateur accordé. Le script PowerShell de l’onglet « Configuration » les inclut déjà lorsqu’il inscrit une nouvelle application. Pour une application existante, ajoutez-les manuellement sous Inscriptions d’applications &gt; votre application &gt; Autorisations d’API &gt; Ajouter une autorisation &gt; Microsoft Graph &gt; Autorisations d’application, puis accordez le consentement administrateur. Tant que ce réglage est activé, « Vérifier la configuration » dans l’onglet « Configuration » signale ces autorisations comme manquantes jusqu’à ce qu’elles soient accordées.';
$string['settings_coursesync_sync_direction'] = 'Comportement de synchronisation des utilisateurs du cours';
$string['settings_coursesync_sync_direction_details'] = 'Sélectionnez le sens dans lequel les utilisateurs doivent être synchronisés entre Moodle et Microsoft Teams.';
$string['settings_coursesync_sync_moodle_to_teams'] = 'De Moodle vers Teams';
$string['settings_coursesync_sync_teams_to_moodle'] = 'De Teams vers Moodle';
$string['settings_coursesync_sync_both'] = 'Mettre à jour Teams et Moodle';
$string['settings_coursesync_enrolment_owner_role'] = 'Rôle des propriétaires d’équipe';
$string['settings_coursesync_enrolment_owner_role_desc'] = 'Rôle qui sera attribué au propriétaire de l’équipe lors de la synchronisation.';
$string['settings_coursesync_enrolment_member_role'] = 'Rôle des membres d’équipe';
$string['settings_coursesync_enrolment_member_role_desc'] = 'Rôle qui sera attribué aux membres de l’équipe lors de la synchronisation.';

// Settings in the "Course sync customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_coursesynccustom'] = 'Personnalisation de la synchronisation des cours';
$string['acp_coursesynccustom_enabled'] = 'Activé';
$string['acp_coursesynccustom_enable_all'] = 'Activer la synchronisation sur tous les cours';
$string['acp_coursesynccustom_disable_all'] = 'Désactiver la synchronisation sur tous les cours';
$string['acp_coursesynccustom_bulk'] = 'Opérations groupées';
$string['acp_coursesynccustom_bulk_enable'] = 'Activer la synchronisation sur les cours de cette page';
$string['acp_coursesynccustom_bulk_disable'] = 'Désactiver la synchronisation sur les cours de cette page';
$string['acp_coursesynccustom_settings_header'] = 'Options de synchronisation';
$string['acp_coursesynccustom_new_course'] = 'Activé par défaut pour les nouveaux cours';
$string['acp_coursesynccustom_new_course_desc'] = 'Si ce réglage est activé, la synchronisation sera activée par défaut pour tous les cours nouvellement créés.';
$string['acp_coursesynccustom_controlled_per_course'] = 'Autoriser la configuration de la synchronisation dans les cours';
$string['acp_coursesynccustom_controlled_per_course_desc'] = 'Si ce réglage est activé, les utilisateurs inscrits aux cours Moodle qui peuvent être propriétaires d’équipe (disposant de la capacité « Propriétaire d’équipe » [local/o365:teamowner]) pourront contrôler la synchronisation du cours depuis le bloc Microsoft du cours.';
$string['acp_coursesynccustom_savemessage'] = 'Vos modifications ont été enregistrées.';
$string['acp_coursesynccustom_regex_search'] = 'Recherche par expression régulière';
$string['acp_coursesynccustom_regex_search_title'] = 'Si cette case est cochée, le contenu de la zone de recherche ci-dessus est appliqué comme une expression régulière PCRE (sans délimiteurs) au nom complet, au nom abrégé et au numéro d’identification, au lieu d’une recherche en texte brut.';
$string['acp_coursesynccustom_confirm_all_action'] = 'Voulez-vous vraiment modifier l’état de synchronisation de tous les cours ? Cette action est irréversible.';
$string['acp_coursesynccustom_sds_course'] = 'Verrouillé pour un cours SDS';
$string['acp_coursesynccustom_all_enabled_notice'] = 'La synchronisation est actuellement activée pour tous les cours. La personnalisation par cours est désactivée car le mode « Toutes les fonctionnalités activées » est actif.';
$string['acp_coursesynccustom_disabled_notice'] = 'La synchronisation des cours est actuellement désactivée globalement. La personnalisation par cours est désactivée car le mode « Désactivé » est actif.';
$string['acp_coursesynccustom_categories_header'] = 'Synchronisation par catégorie de cours';
$string['acp_coursesynccustom_categories_desc'] = 'Sélectionnez une ou plusieurs catégories de cours pour activer automatiquement la synchronisation de tous les cours de ces catégories, y compris de leurs sous-catégories. Cela s’applique également aux cours ajoutés ultérieurement aux catégories sélectionnées. Maintenez la touche Ctrl (Cmd sur Mac) enfoncée pour sélectionner plusieurs catégories, ou cliquez à nouveau en la maintenant enfoncée pour désélectionner.';
$string['acp_coursesynccustom_category_course'] = 'Verrouillé : activé par la catégorie de cours';

// Settings in the "Cohort sync" section of the "Sync settings" tab.
$string['settings_secthead_cohortsync'] = 'Synchronisation des cohortes';
$string['settings_secthead_cohortsync_desc'] = 'Cette fonctionnalité permet la synchronisation entre les groupes Microsoft 365 et les cohortes Moodle.';
$string['settings_cohortsync'] = 'Synchronisation des cohortes';
$string['settings_cohortsync_linktext'] = 'Gérer la synchronisation des cohortes';
$string['settings_cohortsync_details'] = 'Consulter et gérer la synchronisation entre les cohortes Moodle et les groupes Microsoft 365.';
$string['settings_cohortsync_title'] = 'Synchronisation des cohortes';
$string['settings_cohortsync_excludeowners'] = 'Exclure les propriétaires de groupe de la synchronisation des cohortes';
$string['settings_cohortsync_excludeowners_desc'] = 'Si ce réglage est activé, les propriétaires de groupe ne sont pas synchronisés vers les cohortes Moodle, même s’ils sont également membres du groupe. Les propriétaires déjà présents dans une cohorte en seront retirés lors de la prochaine synchronisation.';

// Settings in the "Team / group names" section of the "Sync settings" tab.
$string['settings_secthead_team_group_name'] = 'Noms des équipes / groupes';
$string['settings_secthead_team_group_name_desc'] = 'Si un cours est configuré pour être synchronisé, le nom de l’équipe et du groupe sera construit comme suit.<br/>
<ul>
<li>L’alias de messagerie du groupe et le nom d’affichage de l’équipe peuvent être définis.</li>
<li>Le groupe Microsoft 365 est d’abord créé à l’aide du mailNickname de groupe et du nom d’affichage d’équipe configurés, puis une équipe est créée à partir du groupe.</li>
<li>Si une stratégie de nommage Microsoft Entra ID est utilisée pour les groupes Microsoft 365, les groupes ne seront pas créés si le nom d’affichage construit selon la configuration n’est pas conforme aux stratégies.</li>
<li>Les modifications effectuées ici n’affecteront que les futures créations d’équipes, et non les équipes existantes.</li>
<li>Tous les espaces seront supprimés de l’alias de messagerie du groupe.</li>
<li>Seuls les lettres majuscules et minuscules, les chiffres, - et _ sont autorisés dans l’alias de messagerie du groupe.</li>
<li>L’alias de messagerie du groupe, préfixe et suffixe compris, ne peut pas dépasser 64 caractères.</li>
<li>L’alias de messagerie du groupe doit être unique ; sinon, un nombre aléatoire à 4 chiffres y sera ajouté pour garantir son unicité.</li>
</ul>';
$string['settings_team_name_prefix'] = 'Préfixe du nom d’équipe';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'Partie cours du nom d’équipe';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'Suffixe du nom d’équipe';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_group_mail_alias_prefix'] = 'Préfixe de l’alias de messagerie du groupe';
$string['settings_group_mail_alias_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'Partie cours de l’alias de messagerie du groupe';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'Suffixe de l’alias de messagerie du groupe';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'Supposons qu’un cours ait :
<ul>
<li>Nom complet : <b>Sample course</b></li>
<li>Nom abrégé : <b>sample 15</b></li>
<li>ID créé par Moodle : <b>2</b></li>
<li>Numéro d’identification : <b>Sample ID 15</b></li>
</ul>
Vos réglages actuels créeront un groupe avec l’alias de messagerie « <b>{$a->mailalias}</b> » et une équipe nommée « <b>{$a->teamname}</b> ».<br/>
Cliquez sur le bouton « Enregistrer » ci-dessous pour voir l’effet de vos réglages.';
$string['settings_main_name_option_full_name'] = 'Nom complet';
$string['settings_main_name_option_short_name'] = 'Nom abrégé';
$string['settings_main_name_option_id'] = 'ID créé par Moodle';
$string['settings_main_name_option_id_number'] = 'Numéro d’identification';
$string['settings_team_name_sync'] = 'Mettre à jour le nom de l’équipe lors de la mise à jour du cours';
$string['settings_team_name_sync_desc'] = 'Si ce réglage est activé, lorsque le cours Moodle est mis à jour, le nom de l’équipe sera mis à jour selon les derniers réglages de nom d’équipe.';

// Settings in the "Course request" section of the "Sync settings" tab.
$string['settings_secthead_course_request'] = 'Demande de cours';
$string['settings_secthead_course_request_desc'] = 'Réglages de correspondance des rôles pour la fonctionnalité de demande de cours depuis Teams.';
$string['settings_course_request_enrolment_owner_role'] = 'Rôle des propriétaires d’équipe';
$string['settings_course_request_enrolment_owner_role_desc'] = 'Rôle qui sera attribué au propriétaire de l’équipe lorsque la demande de cours est approuvée.';
$string['settings_course_request_enrolment_member_role'] = 'Rôle des membres d’équipe';
$string['settings_course_request_enrolment_member_role_desc'] = 'Rôle qui sera attribué aux membres de l’équipe lorsque la demande de cours est approuvée.';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'Outils';
$string['settings_secthead_calsync'] = 'Synchronisation du calendrier';
$string['settings_calsyncsubscribemode'] = 'Abonnement à la synchronisation du calendrier';
$string['settings_calsyncsubscribemode_details'] = 'Détermine si les utilisateurs doivent activer eux-mêmes la synchronisation du calendrier Outlook.<ul><li><b>Inscription volontaire</b> : les utilisateurs activent la synchronisation du calendrier et cochent les calendriers à synchroniser sur leur page de réglages de synchronisation du calendrier.</li><li><b>Désinscription volontaire</b> : la synchronisation du calendrier est automatiquement activée pour les utilisateurs connectés à Microsoft 365, qui sont abonnés aux calendriers choisis ci-dessous (pour les cours, tous les cours auxquels ils sont inscrits, actuels et futurs), avec synchronisation de Moodle vers leur calendrier Outlook principal. Les utilisateurs peuvent toujours modifier ou désactiver cela sur leur page de réglages de synchronisation du calendrier, et ceux qui désactivent la synchronisation ne sont pas abonnés à nouveau.</li></ul>Le retour à « Inscription volontaire » ne supprime pas les abonnements existants.';
$string['settings_calsyncsubscribetypes'] = 'Calendriers auxquels abonner automatiquement les utilisateurs';
$string['settings_calsyncsubscribetypes_details'] = 'S’applique uniquement à « Désinscription volontaire ». Choisissez les calendriers Moodle auxquels les utilisateurs connectés sont automatiquement abonnés. Abonner tout le monde au calendrier du site ajoute chaque utilisateur comme participant à chaque événement du site ; c’est pourquoi cette option n’est pas sélectionnée par défaut.';
$string['settings_calsyncsubscribetypes_site'] = 'Calendrier du site';
$string['settings_calsyncsubscribetypes_user'] = 'Calendrier personnel';
$string['settings_calsyncsubscribetypes_course'] = 'Calendriers des cours (tous les cours auxquels l’utilisateur est inscrit)';
$string['settings_calsyncsubscribemode_optin'] = 'Inscription volontaire (les utilisateurs activent eux-mêmes la synchronisation du calendrier)';
$string['settings_calsyncsubscribemode_optout'] = 'Désinscription volontaire (activer automatiquement la synchronisation du calendrier pour tous les utilisateurs connectés)';
$string['settings_secthead_advanced'] = 'Réglages avancés';
$string['settings_secthead_advanced_desc'] = 'Ces réglages contrôlent d’autres fonctionnalités de la suite de plugins. Soyez prudent ! Ils peuvent avoir des effets inattendus.';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'Locataires';
$string['settings_tools_tenants_linktext'] = 'Configurer des locataires supplémentaires';
$string['settings_tools_tenants_details'] = 'Gérer l’accès à des locataires Microsoft Entra supplémentaires.';
$string['settings_healthcheck'] = 'Contrôle de l’état';
$string['settings_healthcheck_details'] = 'En cas de dysfonctionnement, la réalisation d’un contrôle de l’état peut généralement identifier le problème et proposer des solutions.';
$string['settings_healthcheck_linktext'] = 'Effectuer un contrôle de l’état';
$string['settings_userconnections'] = 'Connexions des utilisateurs';
$string['settings_userconnections_linktext'] = 'Gérer les connexions des utilisateurs';
$string['settings_userconnections_details'] = 'Consulter et gérer les connexions entre les utilisateurs Moodle et Microsoft 365.';
$string['settings_teamconnections'] = 'Connexions des équipes';
$string['settings_teamconnections_linktext'] = 'Gérer les connexions des équipes';
$string['settings_teamconnections_details'] = 'Consulter et gérer les connexions entre les cours Moodle et Microsoft Teams.';
$string['settings_usermatch'] = 'Correspondance des utilisateurs';
$string['settings_usermatch_details'] = 'Cet outil vous permet de faire correspondre des utilisateurs Moodle avec des utilisateurs Microsoft 365 à partir d’un fichier de données personnalisé téléversé.';
$string['settings_usersyncgroupfilter'] = 'Filtre de groupe pour la synchronisation des utilisateurs';
$string['settings_usersyncgroupfilter_details'] = 'Lorsqu’un ID d’objet de groupe (GUID) est saisi ici, les synchronisations complètes des utilisateurs sont limitées aux membres et propriétaires de ce groupe Microsoft 365. Laissez vide pour synchroniser tous les utilisateurs disposant d’une licence dans votre locataire.<br><br>
<strong>ATTENTION : il s’agit d’un réglage avancé. Une mauvaise configuration peut entraîner d’importants problèmes de synchronisation des données.</strong><br><br>
<strong>Lorsqu’il est configuré, les règles suivantes s’appliquent :</strong><br>
(1) Les mises à jour de profil, de fuseau horaire et de photo ne sont appliquées qu’aux utilisateurs membres ou propriétaires du groupe<br>
(2) Les nouveaux comptes Moodle ne sont créés que pour les utilisateurs membres ou propriétaires du groupe<br>
(3) Les comptes Moodle des utilisateurs non membres ne reçoivent plus de mises à jour et peuvent se désynchroniser de Microsoft 365<br>
(4) Les utilisateurs désactivés dans Microsoft 365 sont toujours suspendus dans Moodle par la synchronisation de l’état d’activation, qui s’exécute indépendamment du filtrage par groupe<br>
(5) Le retrait d’un utilisateur du groupe arrête les synchronisations futures pour ce compte. Son compte Moodle n’est pas supprimé, et n’est suspendu que si l’option « Suspendre les comptes dans Moodle lorsqu’ils ne font pas partie du groupe de synchronisation des utilisateurs configuré » est activée ; celle-ci suspend tous les utilisateurs synchronisés qui ne sont pas dans le groupe, qu’ils en aient fait partie ou non<br><br>
<strong>Limitation de la synchronisation incrémentielle (delta) :</strong> Microsoft Graph ne prend pas en charge les requêtes delta sur les points de terminaison d’appartenance aux groupes. Lorsque ce réglage est configuré, les synchronisations delta effectuent une synchronisation complète des membres du groupe au lieu d’une mise à jour incrémentielle. Ce comportement est correct mais peut être plus lent qu’une synchronisation delta normale.<br><br>
Validez l’ID d’objet du groupe avant d’enregistrer. Saisissez l’ID d’objet du groupe (GUID).';
$string['settings_usersyncgroupfilter_validation_error'] = 'Format d’ID de groupe non valide. L’ID de groupe doit être un GUID valide (par exemple 550e8400-e29b-41d4-a716-446655440000).';
$string['settings_usersynccreationrestriction'] = 'Restriction de création d’utilisateurs';
$string['settings_usersynccreationrestriction_details'] = 'Si ce réglage est activé, seuls les utilisateurs Microsoft Entra ID remplissant la condition seront créés lors de la synchronisation des utilisateurs. Pour « Appartenance à un groupe Microsoft 365 (ID d’objet du groupe) », saisissez un ID d’objet de groupe ou plusieurs ID d’objet de groupe séparés par des virgules.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Valeur du champ';
$string['settings_usersynccreationrestriction_o365group'] = 'Appartenance à un groupe Microsoft 365 (nom du groupe)';
$string['settings_usersynccreationrestriction_o365groupid'] = 'Appartenance à un groupe Microsoft 365 (ID d’objet du groupe)';
$string['settings_usersynccreationrestriction_invalidgroupid'] = 'L’ID d’objet du groupe Microsoft 365 « {$a} » est introuvable. Vérifiez l’ID et réessayez.';
$string['settings_usersynccreationrestriction_groupvalidationerror'] = 'Les ID d’objet des groupes Microsoft 365 n’ont pas pu être validés. Vérifiez les ID et la configuration de Microsoft Graph, puis réessayez.';
$string['settings_usersynccreationrestriction_regex'] = 'La valeur est une expression régulière';
$string['settings_maintenance'] = 'Maintenance';
$string['settings_maintenance_details'] = 'Diverses tâches de maintenance sont disponibles pour résoudre certains problèmes courants.';
$string['settings_maintenance_linktext'] = 'Afficher les outils de maintenance';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'Multilocataire';
$string['acp_tenants_title_desc'] = 'Cette page vous aide à configurer l’accès multilocataire à Moodle depuis Microsoft 365.';
$string['acp_tenants_add'] = 'Ajouter un nouveau locataire';
$string['acp_tenants_errornotsetup'] = 'Veuillez terminer la configuration du plugin avant d’ajouter des locataires supplémentaires.';
$string['acp_tenants_hosttenant'] = 'Locataire hôte : {$a}';
$string['acp_tenants_intro'] = '<b>Fonctionnement du mode multilocataire :</b><br />Le mode multilocataire permet à plusieurs locataires Microsoft Entra d’accéder à votre site Moodle. <br /><br />
    Voici comment le configurer :
    <ol>
        <li>Connectez-vous à Moodle en tant qu’administrateur du site n’utilisant pas le plugin d’authentification OpenID Connect.</li>
        <li>Vérifiez que les réglages <b>Point de terminaison d’autorisation</b> et <b>Point de terminaison de jeton</b> du plugin d’authentification OpenID Connect utilisent les valeurs par défaut non spécifiques à un locataire.</li>
        <li>Désactivez le plugin d’authentification OpenID Connect dans Moodle. (Utilisez <a href="{$a}/admin/settings.php?section=manageauths">la page d’administration des plugins d’authentification</a>.)</li>
        <li>Accédez à Microsoft Entra ID et trouvez l’application que vous avez configurée pour Moodle.</li>
        <li>Activez le mode multilocataire dans l’application Microsoft Entra ID et enregistrez les modifications.</li>
        <li>Accordez à l’application au moins l’une des autorisations déléguées Graph suivantes : <b>Directory.Read.All</b>, <b>Domain.Read.All</b> ou <b>Domain.ReadWrite.All</b>. Le consentement administrateur pour votre organisation n’est pas nécessaire.</li>
        <li>Si vous êtes déjà connecté avec votre compte Microsoft du locataire supplémentaire, déconnectez-vous complètement et reconnectez-vous.</li>
        <li>Pour chaque locataire à activer, cliquez sur « Ajouter un nouveau locataire » et connectez-vous avec un compte administrateur du locataire concerné.</li>
        <li>Une fois tous les locataires souhaités ajoutés, réactivez le plugin d’authentification OpenID Connect dans Moodle.</li>
        <li>C’est terminé ! Pour ajouter d’autres locataires à l’avenir, cliquez simplement sur le bouton « Ajouter un nouveau locataire » et connectez-vous avec un compte administrateur de ce locataire.</li>
    </ol>
    <b>Remarque importante :</b> l’activation du mode multilocataire dans l’application Microsoft Entra ID permet à tous les locataires Microsoft Entra d’accéder à votre application. L’ajout des locataires ici nous permet de restreindre l’accès à Moodle aux locataires que vous configurez. <b>Si vous supprimez tous les locataires de cette liste avant de désactiver le mode multilocataire dans l’application Microsoft Entra ID, ou si vous activez l’authentification OpenID Connect dans Moodle avec une liste vide, votre site Moodle sera ouvert à tous les locataires Microsoft Entra.</b>';
$string['acp_tenants_none'] = 'Vous n’avez configuré aucun locataire. Si vous avez activé le mode multilocataire dans l’application Microsoft Entra ID, votre site Moodle peut être ouvert à tous les utilisateurs Microsoft 365.';
$string['acp_tenants_revokeaccess'] = 'Révoquer l’accès';
$string['acp_tenants_tenant'] = 'Locataire';
$string['acp_tenants_actions'] = 'Actions';
$string['acp_tenants_delete'] = 'Supprimer';
$string['acp_tenantsadd_desc'] = 'Pour accorder l’accès à un locataire supplémentaire, cliquez sur le bouton ci-dessous et connectez-vous à Microsoft 365 avec un compte administrateur du nouveau locataire. Vous serez redirigé vers la liste des locataires supplémentaires, dans laquelle figurera le nouveau locataire. Vous pourrez alors utiliser Moodle avec ce nouveau locataire.';
$string['acp_tenantsadd_linktext'] = 'Accéder à la page de connexion Microsoft 365';
$string['acp_tenants_legacy_tenants'] = 'Anciens locataires (action requise)';
$string['acp_tenants_legacy_tenants_help'] = 'Les locataires supplémentaires ci-dessous, ajoutés précédemment, risquent de ne pas fonctionner avec le nouveau processus multilocataire et doivent être corrigés.<br/>
Veuillez utiliser le bouton « Ajouter un nouveau locataire » ci-dessus pour les ajouter à nouveau.';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = 'Contrôle de l’état';
$string['healthcheck_fixlink'] = 'Cliquez ici pour résoudre le problème.';
$string['healthcheck_ratelimit_title'] = 'Limitation des appels API';
$string['healthcheck_ratelimit_result_notice'] = 'Une légère limitation a été activée pour gérer l’augmentation de la charge du site Moodle. <br /><br />Toutes les fonctionnalités Microsoft 365 sont opérationnelles ; les requêtes sont simplement un peu espacées pour éviter toute interruption des services Microsoft 365. Dès que l’activité de Moodle diminuera, tout reviendra à la normale. <br />(Niveau {$a->level} / démarré le {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'Une limitation accrue a été activée pour gérer une charge importante du site Moodle. <br /><br />Toutes les fonctionnalités Microsoft 365 restent opérationnelles, mais les requêtes Microsoft 365 peuvent prendre plus de temps. Dès que l’activité du site Moodle aura diminué, tout reviendra à la normale. <br />(Niveau {$a->level} / démarré le {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'Les fonctionnalités de limitation du débit ont été désactivées.';
$string['healthcheck_ratelimit_result_passed'] = 'Les appels à l’API Microsoft 365 s’exécutent à pleine vitesse.';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'Gérer les connexions des utilisateurs';
$string['acp_userconnections_column_muser'] = 'Utilisateur Moodle';
$string['acp_userconnections_column_o365user'] = 'Utilisateur Microsoft 365';
$string['acp_userconnections_column_status'] = 'État de la connexion';
$string['acp_userconnections_column_actions'] = 'Actions';
$string['acp_userconnections_column_usinglogin'] = 'Utilise la connexion';
$string['acp_userconnections_column_status_help'] = 'L’état de la connexion indique comment un compte Moodle est lié à un compte Microsoft 365 (Microsoft Entra ID).

* **Connecté** – L’utilisateur a finalisé la connexion en se connectant à Moodle avec son compte Microsoft 365, ou un administrateur a activement connecté le compte. Les fonctionnalités telles que la synchronisation du calendrier et OneDrive fonctionnent pour cet utilisateur.
* **Mis en correspondance** – Un administrateur (ou l’outil de correspondance groupée des utilisateurs) a enregistré le compte Microsoft 365 auquel correspond cet utilisateur Moodle, mais la connexion n’est pas encore active. Elle est finalisée la première fois que l’utilisateur se connecte avec Microsoft 365. Rien n’est synchronisé tant qu’un utilisateur est seulement mis en correspondance.
* **Synchronisé** – Le compte Moodle a été créé depuis Microsoft Entra ID par la tâche de synchronisation des utilisateurs, mais l’utilisateur ne s’est pas encore connecté. Le compte est activé lors de la première connexion.
* **Aucune connexion** – Le compte Moodle n’est lié à aucun compte Microsoft 365.';
$string['acp_userconnections_column_actions_help'] = 'Les actions disponibles pour une ligne dépendent de son état de connexion.

* **Déconnecter** – Supprime le lien entre le compte Moodle et le compte Microsoft 365. La personne conserve son compte Moodle mais ne peut plus utiliser les fonctionnalités Microsoft 365 ni se connecter avec Microsoft 365 jusqu’à ce qu’elle se connecte à nouveau. Affiché pour les utilisateurs connectés.
* **Resynchroniser** – Exécute immédiatement la synchronisation des données Microsoft 365 pour cet utilisateur (champs de profil, photo, calendrier, etc.) au lieu d’attendre la tâche programmée, et affiche le résultat. Affiché pour les utilisateurs connectés et synchronisés.
* **Mettre en correspondance** – Enregistre le compte Microsoft 365 auquel correspond cet utilisateur Moodle. La connexion n’est active qu’une fois que la personne s’est connectée avec Microsoft 365. Affiché pour les utilisateurs sans connexion.
* **Annuler la correspondance** – Supprime une correspondance qui n’a pas encore été finalisée. Affiché pour les utilisateurs mis en correspondance.';
$string['acp_userconnections_accountstatus_active'] = 'Actif';
$string['acp_userconnections_accountstatus_suspended'] = 'Suspendu';
$string['acp_userconnections_connectionstatus_connected'] = 'Connecté';
$string['acp_userconnections_connectionstatus_matched'] = 'Mis en correspondance';
$string['acp_userconnections_connectionstatus_noconnection'] = 'Aucune connexion';
$string['acp_userconnections_connectionstatus_synced'] = 'Synchronisé';
$string['acp_userconnections_filtering_accountstatus'] = 'État du compte';
$string['acp_userconnections_filtering_connectionstatus'] = 'État de la connexion';
$string['acp_userconnections_filtering_muserfullname'] = 'Nom complet de l’utilisateur Moodle';
$string['acp_userconnections_filtering_musername'] = 'Nom d’utilisateur Moodle';
$string['acp_userconnections_filtering_o365username'] = 'Nom d’utilisateur Microsoft 365';
$string['acp_userconnections_manualmatch_title'] = 'Correspondance manuelle d’utilisateur';
$string['acp_userconnections_manualmatch_details'] = 'Cette page vous permet de faire correspondre un utilisateur Moodle avec un utilisateur Microsoft 365.';
$string['acp_userconnections_manualmatch_musername'] = 'Utilisateur Moodle';
$string['acp_userconnections_manualmatch_uselogin'] = 'Se connecter avec Microsoft 365';
$string['acp_userconnections_manualmatch_o365username'] = 'Nom d’utilisateur Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'L’utilisateur Moodle est déjà connecté à un utilisateur Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'L’utilisateur Moodle est déjà connecté à un utilisateur Microsoft 365 (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'L’utilisateur Moodle est déjà mis en correspondance avec un utilisateur Microsoft 365';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'L’utilisateur Microsoft 365 est déjà mis en correspondance avec un autre utilisateur Moodle';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'L’utilisateur Microsoft 365 est déjà connecté à un autre utilisateur Moodle';
$string['acp_userconnections_resync_nodata'] = 'Impossible de trouver des informations Microsoft 365 enregistrées pour cet utilisateur.';
$string['acp_userconnections_resync_notfound'] = 'Aucune donnée n’a été synchronisée. Le compte « {$a->username} » est lié à l’objet Microsoft Entra ID {$a->objectid}, mais cet objet est introuvable. L’utilisateur a très probablement été supprimé ou désactivé dans Microsoft 365, ou l’ID d’objet enregistré est obsolète.';
$string['acp_userconnections_resync_nooutput'] = 'La resynchronisation s’est terminée sans signaler de modification.';
$string['acp_userconnections_table_disconnect'] = 'Déconnecter';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'L’utilisateur Moodle « {$a} » va être déconnecté de Microsoft 365. Cliquez sur le lien ci-dessous pour continuer.';
$string['acp_userconnections_table_match'] = 'Mettre en correspondance';
$string['acp_userconnections_table_resync'] = 'Resynchroniser';
$string['acp_userconnections_table_unmatch'] = 'Annuler la correspondance';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'La correspondance de l’utilisateur Moodle « {$a} » avec Microsoft 365 va être annulée. Cliquez sur le lien ci-dessous pour continuer.';

// Settings in the "Manage Team Connections" feature of the "Advanced" tab.
$string['acp_teamconnections'] = 'Gérer les connexions des équipes';
$string['acp_teamconnection'] = 'Gérer la connexion de l’équipe';
$string['acp_teamconnections_actions'] = 'Actions';
$string['acp_teamconnections_cache_last_updated'] = 'Le cache Teams a été mis à jour pour la dernière fois le {$a->lastupdated}. Cliquez <a href="{$a->updateurl}">ici</a> pour mettre à jour le cache.';
$string['acp_teamconnections_cache_never_updated'] = 'Le cache Teams n’a jamais été mis à jour. Cliquez <a href="{$a->updateurl}">ici</a> pour le mettre à jour.';
$string['acp_teamconnections_connected_team'] = 'Équipe connectée';
$string['acp_teamconnections_course_connected'] = 'Le cours a bien été connecté à l’équipe.';
$string['acp_teamconnections_course_disconnected'] = 'Le cours a été déconnecté de l’équipe.';
$string['acp_teamconnections_team_linked'] = 'Le cours a été lié à l’équipe.';
$string['acp_teamconnections_current_connection'] = 'CONNEXION ACTUELLE';
$string['acp_teamconnections_exception_course_not_exist'] = 'Le cours à connecter n’existe pas.';
$string['acp_teamconnections_exception_invalid_team_id'] = 'ID d’équipe non valide';
$string['acp_teamconnections_exception_not_configured'] = 'Microsoft 365 n’est pas entièrement configuré.';
$string['acp_teamconnections_exception_team_already_connected'] = 'L’équipe est déjà connectée à un autre cours';
$string['acp_teamconnections_form_connect_course'] = 'Gérer la connexion de l’équipe pour le cours {$a}';
$string['acp_teamconnections_form_sds_warning'] = 'REMARQUE : les équipes créées par Student Data Sync (SDS) ne peuvent pas être connectées manuellement ici, car cela entrerait en conflit avec la synchronisation SDS. Elles sont exclues des résultats de recherche ci-dessous.';
$string['acp_teamconnections_form_team'] = 'Sélectionner une équipe';
$string['acp_teamconnections_form_team_noselection'] = 'Rechercher une équipe...';
$string['acp_teamconnections_no_teams_found'] = 'Aucune équipe trouvée pour « {$a} »';
$string['acp_teamconnections_group_only'] = ' (groupe uniquement)';
$string['acp_teamconnections_team_missing'] = '(équipe manquante)';
$string['acp_teamconnections_not_connected'] = 'Non connecté';
$string['acp_teamconnections_sync_disabled'] = 'La synchronisation des cours doit d’abord être activée avant de pouvoir gérer les connexions des équipes.';
$string['acp_teamconnections_table_connect'] = 'Connecter';
$string['acp_teamconnections_table_connect_to_different_team'] = 'Connecter à une autre équipe';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'Impossible de créer une équipe à partir du groupe - aucun propriétaire';
$string['acp_teamconnections_table_link_team'] = 'Lien vers l’équipe « {$a} »';
$string['acp_teamconnections_table_missing_team'] = 'Le cours est connecté à une équipe qui n’existe pas. Cela sera corrigé lors de la prochaine exécution de la tâche programmée de synchronisation des cours.';
$string['acp_teamconnections_table_resync'] = 'Resynchroniser';
$string['acp_teamconnections_table_update'] = 'Mettre à jour';
$string['acp_teamconnections_teams_cache_updated'] = 'Le cache Teams a bien été mis à jour.';
$string['acp_teamconnections_no_owner'] = 'Ajoutez un propriétaire pour connecter à Teams.';
$string['acp_teamconnections_resync'] = 'Resynchroniser les propriétaires / membres de l’équipe';
$string['acp_teamconnections_resync_title'] = 'Resynchroniser les propriétaires / membres de l’équipe pour le cours {$a}';
$string['acp_teamconnections_resync_desc'] = 'Compare les utilisateurs inscrits au cours avec les propriétaires et membres du groupe/de l’équipe Microsoft 365 connecté(e), et ajoute les personnes manquantes. Choisissez si les utilisateurs présents dans l’équipe mais non inscrits au cours Moodle doivent également être retirés.';
$string['acp_teamconnections_resync_keep'] = 'Resynchroniser (conserver les membres supplémentaires de l’équipe)';
$string['acp_teamconnections_resync_keep_desc'] = 'Les utilisateurs inscrits au cours Moodle qui sont absents de l’équipe seront ajoutés. Les propriétaires / membres existants de l’équipe qui ne sont pas inscrits au cours Moodle ne seront pas modifiés.';
$string['acp_teamconnections_resync_remove'] = 'Resynchroniser et retirer les membres supplémentaires de l’équipe';
$string['acp_teamconnections_resync_remove_desc'] = 'Attention : tout propriétaire ou membre de l’équipe qui n’est pas inscrit au cours Moodle sera retiré de l’équipe, même s’il a été ajouté directement dans Microsoft Teams.';
$string['acp_teamconnections_resync_completed'] = 'Les propriétaires / membres de l’équipe ont été resynchronisés.';
$string['acp_teamconnections_resync_failed'] = 'Impossible de resynchroniser les propriétaires / membres de l’équipe. Consultez la sortie ci-dessus pour plus de détails.';
$string['acp_teamconnections_last_resync'] = 'Dernière resynchronisation : {$a}';
$string['acp_teamconnections_never_resynced'] = 'Jamais resynchronisé';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'Correspondance des utilisateurs';
$string['acp_usermatch_desc'] = 'Cet outil vous permet de faire correspondre des utilisateurs Moodle avec des utilisateurs Microsoft 365. Vous téléverserez un fichier contenant les utilisateurs Moodle et les utilisateurs Microsoft 365 associés, puis une tâche cron vérifiera les données et établira la correspondance.';
$string['acp_usermatch_upload'] = 'Étape 1 : Téléverser de nouvelles correspondances';
$string['acp_usermatch_upload_desc'] = 'Téléversez un fichier de données contenant des noms d’utilisateur Moodle et Microsoft 365 pour faire correspondre les utilisateurs Moodle avec les utilisateurs Microsoft 365.<br />
<br />
Ce fichier doit être un simple fichier CSV en texte brut contenant trois éléments par ligne :
<ul>
<li>le nom d’utilisateur Moodle,</li>
<li>le nom d’utilisateur Microsoft 365,</li>
<li>1 ou 0, où 1 signifie que la méthode d’authentification de l’utilisateur passe à OpenID Connect, et 0 que la méthode d’authentification existante est conservée et que le compte est utilisé comme compte lié.</li>
</ul>
N’incluez pas d’en-têtes ni de données supplémentaires.<br />
Par exemple : <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'Le type {$a} n’est pas pris en charge. Veuillez téléverser un fichier CSV en texte brut.';
$string['acp_usermatch_upload_err_data'] = 'La ligne n° {$a} contient des données non valides. Chaque ligne du fichier CSV doit comporter au moins deux éléments : le nom d’utilisateur Moodle et le nom d’utilisateur Microsoft 365.';
$string['acp_usermatch_upload_err_fileopen'] = 'Impossible d’ouvrir le fichier pour le traiter. Les permissions de votre dossier Moodledata sont-elles correctes ?';
$string['acp_usermatch_upload_err_nofile'] = 'Aucun fichier n’a été reçu pour être ajouté à la file d’attente.';
$string['acp_usermatch_upload_submit'] = 'Ajouter le fichier de données à la file d’attente de correspondance';
$string['acp_usermatch_matchqueue'] = 'Étape 2 : File d’attente de correspondance';
$string['acp_usermatch_matchqueue_clearall'] = 'Tout effacer';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Effacer les erreurs';
$string['acp_usermatch_matchqueue_clearqueued'] = 'Effacer les éléments en attente';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Effacer les éléments réussis';
$string['acp_usermatch_matchqueue_column_muser'] = 'Nom d’utilisateur Moodle';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Nom d’utilisateur Microsoft 365';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Statut';
$string['acp_usermatch_matchqueue_desc'] = 'Ce tableau indique l’état actuel de l’opération de correspondance. À chaque exécution de la tâche programmée <b>Traiter la file d’attente de correspondance</b>, un lot des utilisateurs suivants est traité.<br /><b>Remarque :</b> cette page ne se met pas à jour automatiquement ; actualisez-la pour voir l’état actuel.';
$string['acp_usermatch_matchqueue_empty'] = 'La file d’attente de correspondance est actuellement vide. Téléversez un fichier de données à l’aide du sélecteur de fichiers ci-dessus pour ajouter des utilisateurs à la file d’attente.';
$string['acp_usermatch_matchqueue_status_error'] = 'Erreur : {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'En attente';
$string['acp_usermatch_matchqueue_status_success'] = 'Réussi';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'Outils de maintenance';
$string['acp_maintenance_desc'] = 'Ces outils peuvent vous aider à résoudre certains problèmes courants.';
$string['acp_maintenance_warning'] = 'Attention : il s’agit d’outils avancés. Ne les utilisez que si vous comprenez ce que vous faites.';
$string['acp_maintenance_resyncgroupusers'] = 'Resynchroniser les utilisateurs des groupes Microsoft 365 des cours';
$string['acp_maintenance_resyncgroupusers_desc'] = 'Resynchronise l’appartenance des utilisateurs à tous les groupes Microsoft 365 créés pour tous les cours Moodle. Cela garantit que tous les utilisateurs inscrits au cours Moodle, et eux seuls, sont dans le groupe Microsoft 365. <br /><b>Remarque :</b> si vous avez ajouté à un groupe Microsoft 365 des utilisateurs qui ne sont pas inscrits au cours Moodle associé, ils en seront retirés.';
$string['acp_maintenance_recreatedeletedgroups'] = 'Recréer les groupes Microsoft 365 supprimés';
$string['acp_maintenance_recreatedeletedgroups_desc'] = 'Recherche les groupes Microsoft 365 connectés à des cours Moodle qui ont pu être supprimés manuellement, et les recrée.';
$string['acp_maintenance_debugdata'] = 'Générer un paquet de données de débogage';
$string['acp_maintenance_debugdata_desc'] = 'Génère un paquet contenant diverses informations sur votre environnement Moodle et Microsoft 365 afin d’aider les développeurs à résoudre vos éventuels problèmes. Si un développeur vous le demande, exécutez cet outil et envoyez le fichier téléchargé obtenu. Remarque : bien que ce paquet ne contienne pas de données de jeton sensibles, nous vous demandons de ne pas publier ce fichier ni de l’envoyer à une partie non fiable.';
$string['acp_maintenance_cleandeltatoken'] = 'Nettoyer les jetons delta de synchronisation des utilisateurs';
$string['acp_maintenance_cleandeltatoken_desc'] = 'Si la synchronisation des utilisateurs ne fonctionne pas entièrement après la modification de ses réglages, cela peut être dû à un ancien jeton de synchronisation delta. Le nettoyage du jeton forcera une resynchronisation complète lors de la prochaine exécution de la synchronisation des utilisateurs.';
$string['acp_maintenance_cleanapptokens'] = 'Nettoyer les jetons d’application';
$string['acp_maintenance_cleanapptokens_desc'] = 'Supprime les jetons d’application enregistrés, que le plugin utilise pour les appels aux API Microsoft qui ne s’exécutent pas au nom d’un utilisateur. De nouveaux jetons d’application sont demandés automatiquement dès qu’ils sont nécessaires, et les résultats de la dernière vérification « Vérifier la configuration » de l’onglet Configuration sont effacés. Si les appels effectués avec des autorisations d’application échouent avec des erreurs d’authentification, par exemple après une modification des autorisations de l’application Microsoft Entra ID ou de ses informations d’identification, le nettoyage des jetons peut aider. Les jetons des utilisateurs ne sont pas concernés.';

// Settings in the "Resync users in Microsoft 365 groups for courses" feature in the "Maintenance Tools" feature of the
// "Advanced" tab.
$string['acp_maintenance_resyncgroupusers_course_output'] = 'Sortie de la resynchronisation';
$string['acp_maintenance_resyncgroupusers_no_course'] = 'Aucun cours connecté à Microsoft 365';
$string['acp_maintenance_coursesync_disabled'] = 'Cet outil n’est disponible que lorsque la synchronisation des cours est activée. <a href="{$a}">Gérer la synchronisation des cours</a>.';

// Settings in the "Recreate deleted Microsoft 365 groups" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_recreatedeletedgroups_group_type'] = 'Type d’objet Moodle';
$string['acp_maintenance_recreatedeletedgroups_group_type_course'] = 'Cours';
$string['acp_maintenance_recreatedeletedgroups_group_type_course_group'] = 'Groupe de cours';
$string['acp_maintenance_recreatedeletedgroups_course'] = 'Cours';
$string['acp_maintenance_recreatedeletedgroups_course_group'] = 'Groupe de cours';
$string['acp_maintenance_recreatedeletedgroups_status'] = 'Statut';
$string['acp_maintenance_recreatedeletedgroups_status_sync_disabled'] = 'La synchronisation du cours est désactivée';
$string['acp_maintenance_recreatedeletedgroups_status_created_success'] = 'Le groupe a été recréé';
$string['acp_maintenance_recreatedeletedgroups_status_created_fail'] = 'Échec de la recréation du groupe';
$string['acp_maintenance_recreatedeletedgroups_all_groups_exist'] = 'Tous les groupes connectés aux cours Moodle et aux groupes de cours existent.';

// Settings in the "Cleanup User Sync Delta Tokens" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_cleandeltatoken_completed'] = 'Le jeton delta et le jeton skip delta de synchronisation des utilisateurs ont été nettoyés.';
$string['acp_maintenance_cleanapptokens_confirm'] = 'Voulez-vous vraiment nettoyer les jetons d’application ? {$a} jeton(s) d’application sont actuellement enregistrés.';
$string['acp_maintenance_cleanapptokens_completed'] = 'Les jetons d’application et les derniers résultats de « Vérifier la configuration » ont été nettoyés.';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_course_reset_teams'] = 'Actions sur l’équipe/le groupe lors de la réinitialisation du cours';
$string['settings_course_reset_teams_details'] = 'Actions à effectuer sur une équipe ou un groupe connecté à un cours lorsque le cours est réinitialisé.';
$string['settings_course_reset_teams_option_do_nothing'] = 'Ne rien faire<br/>L’équipe ou le groupe reste connecté(e) au cours. Les désinscriptions d’utilisateurs entraînent leur retrait de l’équipe ou du groupe.';
$string['settings_course_reset_teams_option_per_course'] = 'Autoriser des réglages par cours<br/>Le bloc Microsoft doit être ajouté au cours. Les utilisateurs ayant la capacité de réinitialiser le cours peuvent choisir dans le bloc ce qu’il faut faire lors de la réinitialisation.';
$string['settings_course_reset_teams_option_force_archive'] = 'Déconnecter le cours de l’équipe ou du groupe et en créer un(e) nouveau/nouvelle<br/>L’équipe ou le groupe existant connecté au cours sera renommé(e) comme configuré. Si une équipe est connectée, elle sera archivée. Une nouvelle équipe ou un nouveau groupe sera créé(e) et connecté(e) au cours.';
$string['settings_course_reset_teams_option_archive_only'] = 'Déconnecter uniquement le cours de l’équipe ou du groupe<br />L’équipe ou le groupe existant connecté au cours sera renommé(e) comme configuré. Si une équipe est connectée, elle sera archivée. Aucune nouvelle équipe ni aucun nouveau groupe ne sera créé.';
$string['settings_reset_team_name_prefix'] = 'Préfixe du nom d’équipe lors de la réinitialisation';
$string['settings_reset_team_name_prefix_details'] = 'Lors de la réinitialisation d’un cours connecté à une équipe, ce préfixe sera ajouté au nom de l’équipe connectée existante.';
$string['settings_reset_group_name_prefix'] = 'Préfixe du nom de groupe lors de la réinitialisation';
$string['settings_reset_group_name_prefix_details'] = 'Lors de la réinitialisation d’un cours connecté à un groupe, ce préfixe sera ajouté au nom du groupe existant.';
$string['settings_calsync_courseeventmode'] = 'Événements Outlook pour les événements du calendrier de cours';
$string['settings_calsync_courseeventmode_details'] = 'Détermine la façon dont un événement du calendrier d’un cours Moodle est créé dans Outlook pour les utilisateurs abonnés au calendrier du cours.
<ul>
<li><strong>Un événement partagé avec les utilisateurs du cours comme participants :</strong> un seul événement est créé dans le calendrier Outlook de l’utilisateur qui a créé l’événement Moodle (ou dans le calendrier du groupe Microsoft 365 du cours, si le cours est lié à un groupe), et les utilisateurs du cours y sont ajoutés comme participants.</li>
<li><strong>Un événement individuel par utilisateur :</strong> un événement distinct est créé directement dans le calendrier Outlook de chaque utilisateur abonné. Il n’y a ni événement partagé, ni liste de participants, et rien n’est ajouté au calendrier du groupe Microsoft 365.</li>
</ul>
La modification de ce réglage n’affecte que les événements synchronisés ensuite ; les événements déjà présents dans Outlook ne sont pas convertis.';
$string['settings_calsync_courseeventmode_shared'] = 'Un événement partagé avec les utilisateurs du cours comme participants';
$string['settings_calsync_courseeventmode_individual'] = 'Un événement individuel par utilisateur';
$string['settings_debugmode'] = 'Enregistrer les messages de débogage';
$string['settings_debugmode_details'] = 'Si ce réglage est activé, des informations pouvant aider à identifier les problèmes sont consignées dans le journal Moodle. <a href="{$a}">Afficher les messages consignés.</a>';
$string['settings_switchauthminupnsplit0'] = 'Longueur minimale d’un nom d’utilisateur inexact pour basculer vers Microsoft 365';
$string['settings_switchauthminupnsplit0_details'] = 'Si vous activez le réglage « Basculer les utilisateurs mis en correspondance vers l’authentification Microsoft 365 (OpenID Connect) », ce réglage définit la longueur minimale des noms d’utilisateur sans locataire (la partie @example.onmicrosoft.com) qui seront basculés. Cela permet d’éviter de basculer des comptes aux noms génériques, comme « admin », qui ne sont pas nécessairement les mêmes dans Moodle et dans Microsoft Entra ID. Indiquez 0 pour basculer les utilisateurs mis en correspondance quelle que soit la longueur du nom d’utilisateur. Les utilisateurs dont la méthode d’authentification n’a pas été basculée en raison de ce réglage sont consignés sous la forme « Utilisateur mis en correspondance, mais le nom d’utilisateur ne correspond pas exactement à l’UPN Microsoft Entra ID et ne remplit pas les conditions de correspondance exacte pour basculer vers OIDC... » dans la sortie de la tâche de synchronisation, et apparaissent comme « Mis en correspondance avec un utilisateur existant - En attente de finalisation » sur la page Gérer les connexions des utilisateurs.';
$string['settings_customtheme'] = 'Thème personnalisé (avancé)';
$string['settings_customtheme_desc'] = 'Le thème recommandé est « boost_o365teams ». Vous pouvez cependant sélectionner un autre thème si vous disposez d’un thème personnalisé adapté à une utilisation dans l’onglet Teams.<br/>
Notez qu\'un thème personnalisé défini au niveau du cours ou de la catégorie a priorité sur les réglages définis ici ; autrement dit, un cours utilisera par défaut le thème du cours ou de la catégorie dans l\'application Moodle dans Teams. Pour y remédier, définissez $CFG->themeorder dans config.php sur « array(\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\'); ».';

// Settings in the "SDS sync" tab.
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>Ceci est une fonctionnalité en préversion</b><br />Les fonctionnalités en préversion peuvent ne pas fonctionner comme prévu ou cesser de fonctionner sans avertissement. Procédez avec prudence.</div>';
$string['settings_sds_intro_desc'] = 'Microsoft School Data Sync (« SDS ») simplifie la gestion des classes dans Microsoft 365 en lisant les listes de classe d’un SIS externe et en créant des classes et des groupes dans Microsoft 365. <a href="https://sds.microsoft.com/" target="_blank">En savoir plus</a><br/>
<br/>
La fonctionnalité de synchronisation SDS permet de synchroniser les données de listes de classe depuis SDS vers Moodle, y compris les classes, les enseignants et les étudiants.<br/>
<br/>
Pour utiliser la fonctionnalité de synchronisation SDS, assurez-vous que l’application Microsoft Entra ID utilisée pour l’intégration dispose des autorisations d’application Microsoft Graph <b>EduRoster.Read.All</b> et <b>Member.Read.Hidden</b>, qui ne sont pas ajoutées automatiquement par la configuration par défaut. Le consentement administrateur doit également leur être accordé.<br/>
<br/>
Par défaut, la synchronisation SDS s’exécute chaque jour dans le cron Moodle, à 3h00 heure du serveur. Pour modifier cette planification, rendez-vous sur la <a href="{$a}">page de gestion des tâches programmées.</a><br/><br/>';
$string['settings_sds_coursecreation'] = 'Synchronisation des classes vers les cours';
$string['settings_sds_coursecreation_desc'] = 'Ces options contrôlent la création de cours Moodle à partir des classes des établissements SDS.';
$string['settings_sds_coursecreation_enabled'] = 'Établissements synchronisés';
$string['settings_sds_coursecreation_enabled_desc'] = 'Créer des cours pour les classes de ces établissements.';
$string['settings_sds_teams_enabled'] = 'Les classes SDS ont-elles déjà des équipes ?';
$string['settings_sds_teams_enabled_desc'] = 'Cochez cette case si des équipes ont déjà été créées pour les classes SDS par la configuration SDS. Si elle est cochée, Moodle ne tentera pas de créer des équipes à partir des cours Moodle créés depuis les classes SDS, afin d’éviter les conflits.';
$string['settings_sds_courseenrolsync'] = 'Synchronisation des inscriptions aux cours';
$string['settings_sds_courseenrolsync_desc'] = 'Ces options contrôlent la synchronisation des inscriptions aux cours à partir des classes des établissements SDS.';
$string['settings_sds_enrolment_enabled'] = 'Synchroniser les inscriptions de SDS vers Moodle';
$string['settings_sds_enrolment_enabled_desc'] = 'Lorsque ce réglage est activé, la tâche programmée de synchronisation SDS inscrit les enseignants et les étudiants des classes SDS dans les cours Moodle correspondants, et retire les utilisateurs qui ne font plus partie de la classe SDS. Nécessite la configuration de <b>Rôle des enseignants des classes SDS dans Moodle</b> et de <b>Rôle des étudiants des classes SDS dans Moodle</b>.';
$string['settings_sds_sync_enrolment_to_sds'] = 'Synchroniser les inscriptions de Moodle vers SDS';
$string['settings_sds_sync_enrolment_to_sds_desc'] = 'Lorsque ce réglage est activé, les modifications d’inscription effectuées dans les cours Moodle connectés à des classes SDS seront répercutées dans les classes SDS. Le statut de propriétaire / membre de l’utilisateur dans SDS dépendra des capacités « local/o365:teamowner » et « local/o365:teammember » dans le contexte du cours.';
$string['settings_sds_suspend_enrolment'] = 'Suspendre les inscriptions des utilisateurs au lieu de les désinscrire';
$string['settings_sds_suspend_enrolment_desc'] = 'Lorsque cette option est activée, l’inscription des utilisateurs retirés d’une classe SDS est suspendue dans le cours Moodle connecté au lieu d’être complètement supprimée. Cela préserve les données de l’utilisateur telles que les notes, les travaux remis et l’achèvement des activités. Lorsque les utilisateurs sont réintégrés à la classe SDS, leur inscription est automatiquement réactivée.<br />
<b>Remarque :</b> les enseignants ne sont jamais suspendus ni désinscrits par la synchronisation SDS. Ce réglage ne concerne que les étudiants.';
$string['settings_sds_enable_course_sync'] = 'Activer la synchronisation bidirectionnelle des cours';
$string['settings_sds_enable_course_sync_desc'] = 'Lorsque ce réglage est activé, chaque cours Moodle créé à partir d’une classe SDS est lié à son groupe Microsoft 365 dans la base de données, ce qui active l’intégration complète de la synchronisation des cours Microsoft 365 (Teams, fichiers, calendrier, etc.) pour ce cours. Si la classe SDS dispose déjà d’une équipe, un enregistrement d’association Teams est également créé.';
$string['settings_sds_course_field_mailnickname'] = 'Alias de messagerie (mailNickname)';
$string['settings_sds_course_field_displayname'] = 'Nom d’affichage (displayName)';
$string['settings_sds_course_field_classcode'] = 'Code de classe (classCode)';
$string['settings_sds_course_field_externalname'] = 'Nom externe (externalName)';
$string['settings_sds_course_shortname_field'] = 'Source du nom abrégé du cours';
$string['settings_sds_course_shortname_field_desc'] = 'Propriété de la classe SDS utilisée comme nom abrégé des cours Moodle nouvellement créés. Moodle exige que les noms abrégés des cours soient uniques. Si la propriété choisie est vide, ou si sa valeur est déjà utilisée par un cours lié à une autre classe SDS, l’alias de messagerie est utilisé à la place. La modification de ce réglage ne renomme pas les cours déjà créés.';
$string['settings_sds_course_fullname_field'] = 'Source du nom complet du cours';
$string['settings_sds_course_fullname_field_desc'] = 'Propriété de la classe SDS utilisée comme nom complet des cours Moodle nouvellement créés. Si la propriété choisie est vide, le nom d’affichage est utilisé à la place. La modification de ce réglage ne renomme pas les cours déjà créés.';
$string['settings_sds_categorize_by_subject'] = 'Classer les cours par matière';
$string['settings_sds_categorize_by_subject_desc'] = 'Lorsque ce réglage est activé, les cours sont organisés en catégories par matière au sein de chaque catégorie d’établissement. Le nom de la matière est extrait des informations de la classe dans SDS. Lorsqu’il est désactivé, tous les cours sont placés directement dans la catégorie de l’établissement.';
$string['settings_sds_ignore_past_courses'] = 'Ignorer les classes expirées/passées';
$string['settings_sds_ignore_past_courses_desc'] = 'Lorsque ce réglage est activé, les classes expirées ou terminées sont ignorées lors de la synchronisation. Cela comprend :<br />
<ul>
<li>les classes dont le nom comporte le préfixe d’expiration configuré (par défaut : « Exp »)</li>
<li>les classes dont la date de fin est passée</li>
</ul>
Cela permet de garder votre catalogue de cours propre en ne créant pas de cours pour des classes anciennes ou archivées.';
$string['settings_sds_expired_course_prefix'] = 'Préfixe des noms de classes expirées';
$string['settings_sds_expired_course_prefix_desc'] = 'Les classes dont le nom commence par ce préfixe sont considérées comme expirées et ignorées lors de la synchronisation (si « Ignorer les classes expirées/passées » est activé). Par défaut : « Exp »';
$string['settings_sds_cohortsync'] = 'Synchronisation des cohortes';
$string['settings_sds_cohortsync_desc'] = 'Ces options contrôlent la création et la synchronisation de cohortes à partir des classes SDS. Les cohortes offrent un autre moyen de regrouper les utilisateurs, utilisable pour les inscriptions à l’échelle du site ou d’autres fonctionnalités de Moodle.';
$string['settings_sds_create_cohorts'] = 'Créer des cohortes à partir des classes SDS';
$string['settings_sds_create_cohorts_desc'] = 'Lorsque ce réglage est activé, une cohorte est créée pour chaque classe SDS et ses membres sont maintenus synchronisés avec la classe SDS. Les cohortes sont créées dans le contexte de la catégorie de cours (catégorie d’établissement ou de matière selon vos réglages de classement).<br />
<b>Remarque :</b> les cohortes sont créées en plus des cours, et non à leur place. Vous pouvez ainsi utiliser les cohortes pour des inscriptions ou des regroupements à l’échelle du site tout en conservant les cours synchronisés avec SDS.';
$string['settings_sds_cohort_include_teachers'] = 'Inclure les enseignants dans les cohortes';
$string['settings_sds_cohort_include_teachers_desc'] = 'Lorsque ce réglage est activé, les enseignants de la classe SDS sont ajoutés à la cohorte avec les étudiants. Lorsqu’il est désactivé, seuls les étudiants sont ajoutés aux cohortes.';
$string['settings_sds_enrolment_teacher_role'] = 'Rôle des enseignants des classes SDS dans Moodle';
$string['settings_sds_enrolment_teacher_role_desc'] = 'Si « Synchroniser les inscriptions de SDS vers Moodle » est activé, les enseignants de la classe SDS seront inscrits au cours Moodle connecté avec ce rôle.';
$string['settings_sds_enrolment_student_role'] = 'Rôle des étudiants des classes SDS dans Moodle';
$string['settings_sds_enrolment_student_role_desc'] = 'Si « Synchroniser les inscriptions de SDS vers Moodle » est activé, les étudiants de la classe SDS seront inscrits au cours Moodle connecté avec ce rôle.';
$string['settings_sds_profilesync_header'] = 'Synchronisation des profils utilisateur';
$string['settings_sds_profilesync_header_desc'] = 'Chaque établissement SDS peut stocker un profil utilisateur pour les enseignants et les membres de l’établissement. Ces champs sont propres à chaque établissement : différents établissements peuvent avoir des valeurs différentes dans le même champ pour le même utilisateur.<br/>
Si un établissement est sélectionné dans cette section, les champs de profil utilisateur SDS peuvent être configurés dans la correspondance des champs utilisateur.
<ul>
<li>Notez que la synchronisation des champs SDS n’a lieu que lors de l’exécution de la tâche programmée « Synchroniser avec SDS », et non lors de l’exécution de la tâche programmée « Synchroniser les utilisateurs depuis Microsoft Entra ID », ni lors de la connexion d’un utilisateur.</li>
<li>Notez qu’il existe un problème connu dans l’API Microsoft Graph utilisée par cette fonctionnalité : certains champs de profil scolaire des étudiants et des enseignants ne sont pas renvoyés et ne peuvent donc pas être synchronisés, même s’ils sont configurés.</li>
</ul>
';
$string['settings_sds_profilesync_disabled'] = 'Désactivé';
$string['settings_sds_profilesync'] = 'Synchroniser les données de profil depuis l’établissement';
$string['settings_sds_profilesync_desc'] = 'Sélectionnez l’établissement SDS depuis lequel Moodle synchronise les données de profil propres à SDS.';
$string['settings_sds_noschools'] = '<div class="alert alert-info">Aucun établissement n’est disponible dans SDS.</div>';
$string['settings_sds_get_schools_error'] = '<div class="alert alert-info error">Impossible de récupérer les établissements SDS. Vérifiez que l’application Microsoft Entra ID dispose de l’autorisation requise.</div>';
$string['settings_sds_school_disabled_action'] = 'Action lors de la désactivation de la synchronisation d’un établissement';
$string['settings_sds_school_disabled_action_desc'] = 'Action à effectuer sur les cours Moodle déjà connectés lorsque la synchronisation est désactivée pour un établissement SDS.';
$string['settings_sds_school_disabled_action_keep_connected'] = 'Garder le cours Moodle connecté à l’équipe';
$string['settings_sds_school_disabled_action_disconnect'] = 'Déconnecter le cours Moodle de l’équipe';
$string['settings_sds_school_unavailable'] = '{$a} (liste des établissements SDS actuellement indisponible)';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner'] = 'L’application Moodle pour <a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teams</a> vous permet d’accéder facilement à vos cours Moodle et de collaborer autour de ceux-ci dans Teams.';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Configurer votre application Moodle pour Microsoft Teams</h4>';
$string['settings_moodlesettingssetup'] = 'Configurer Moodle';
$string['settings_check_moodle_settings'] = 'Vérifier les réglages de Moodle';
$string['settings_moodlesetup_checking'] = 'Vérification...';
$string['settings_notice_cookiesecureenabled'] = 'L’option « Cookies sécurisé uniquement » a bien été activée';
$string['settings_notice_cookiesecurealreadyenabled'] = 'L’option « Cookies sécurisé uniquement » était déjà activée';
$string['settings_notice_oidcenabled'] = 'OpenID Connect a bien été activé';
$string['settings_notice_oidcnotenabled'] = 'OpenID Connect n’a pas pu être activé';
$string['settings_notice_oidcalreadyenabled'] = 'OpenID Connect était déjà activé';
$string['settings_notice_webservicesframealreadyenabled'] = 'Les services web étaient déjà activés et l’intégration dans des cadres est également autorisée';
$string['settings_notice_webservicesframeenabled'] = 'Les services web ont bien été activés et l’intégration dans des cadres est désormais également autorisée';
$string['settings_notice_restenabled'] = 'Le protocole REST a bien été activé';
$string['settings_notice_restnotenabled'] = 'Le protocole REST n’a pas pu être activé';
$string['settings_notice_restalreadyenabled'] = 'Le protocole REST était déjà activé';
$string['settings_notice_o365serviceenabled'] = 'Les services web Microsoft 365 ont bien été activés';
$string['settings_notice_o365servicealreadyenabled'] = 'Les services web Microsoft 365 étaient déjà activés';
$string['settings_notice_createtokenallowed'] = 'L’autorisation de créer un jeton de service web a été accordée';
$string['settings_notice_createtokenalreadyallowed'] = 'L’autorisation de créer un jeton de service web était déjà accordée';
$string['settings_notice_createtokennotallowed'] = 'Un problème est survenu lors de l’octroi de l’autorisation de créer un jeton de service web';
$string['settings_notice_restusageallowed'] = 'L’autorisation d’utiliser le protocole REST a été accordée';
$string['settings_notice_restusagealreadyallowed'] = 'L’autorisation d’utiliser le protocole REST était déjà accordée';
$string['settings_notice_restusagenotallowed'] = 'Un problème est survenu lors de l’octroi de l’autorisation d’utiliser le protocole REST';
$string['settings_moodlesettingssetup_details'] = 'Cette action s’assure que :
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>l’option « Cookies sécurisé uniquement » est activée ;</li>
<li>OpenID Connect est activé ;</li>
<li>l’intégration dans des cadres est activée ;</li>
<li>les services web sont activés ;</li>
<li>le protocole REST est activé ;</li>
<li>les services web Microsoft 365 sont activés ;</li>
<li>l’utilisateur authentifié a l’autorisation de créer un jeton de service web ;</li>
<li>l’utilisateur authentifié a l’autorisation d’utiliser le protocole REST.</li>
</ul>';
$string['settings_teams_moodle_app_external_id'] = 'ID d’application Microsoft pour l’application Moodle pour Teams';
$string['settings_teams_moodle_app_external_id_desc'] = 'Ce réglage doit conserver la valeur par défaut, sauf si plusieurs applications Moodle pour Teams sont nécessaires dans votre locataire pour se connecter à différents sites Moodle.';
$string['settings_teams_moodle_app_short_name'] = 'Nom de l’application Teams';
$string['settings_teams_moodle_app_short_name_desc'] = 'Ce réglage peut conserver la valeur par défaut, sauf si plusieurs applications Moodle pour Teams sont nécessaires dans votre locataire pour se connecter à différents sites Moodle.';
$string['settings_download_teams_tab_app_manifest'] = 'Télécharger le fichier manifeste';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Veuillez enregistrer toutes vos modifications avant de télécharger le manifeste.';
$string['settings_publish_manifest_instruction'] = '<a href="https://learn.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Cliquez ici</a> pour savoir comment publier le fichier manifeste de l’application Moodle téléchargé auprès de tous les utilisateurs de Teams.';
$string['settings_teams_moodle_tab_name'] = 'Nom de l’onglet Moodle dans Teams';
$string['settings_teams_moodle_tab_name_desc'] = 'Nom de l’onglet Moodle dans Teams.';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'ID de l’application Moodle';
$string['settings_moodle_app_id_desc'] = 'ID de l’application Moodle téléversée dans les catalogues d’applications Teams.<br/>
Si ce réglage est configuré, Moodle tentera de créer un onglet Moodle renvoyant vers le cours Moodle dans le canal « Général » de l’équipe créée/connectée.';
$string['settings_moodle_app_id_desc_auto_id'] = '<br/>
La valeur détectée automatiquement est « <span class="local_o365_settings_moodle_app_id">{$a}</span> ».';
$string['settings_set_moodle_app_id_instruction'] = 'Pour trouver manuellement l’ID de l’application Moodle, procédez comme suit :
<ol>
<li>Téléversez le fichier manifeste téléchargé dans le catalogue d’applications Teams de votre locataire.</li>
<li>Dans le catalogue d’applications Teams, recherchez l’application.</li>
<li>Cliquez sur l’icône d’options de l’application, située dans le coin supérieur droit de l’image de l’application.</li>
<li>Cliquez sur « Copier le lien ».</li>
<li>Collez le contenu copié dans un éditeur de texte. Il doit contenir une URL telle que https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
La dernière partie de l’URL, c’est-à-dire <span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>, est l’ID de l’application.';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Activer la synchronisation du calendrier Outlook';
$string['calendar_user'] = 'Calendrier (utilisateur) personnel';
$string['calendar_site'] = 'Calendrier du site';
$string['personal_calendar'] = 'Personnel';
$string['calendar_event'] = 'Afficher les détails';
$string['eventcalendarsubscribed'] = 'Utilisateur abonné à un calendrier';
$string['eventcalendarunsubscribed'] = 'Utilisateur désabonné d’un calendrier';

// Errors.
$string['erroracpauthoidcnotconfig'] = 'Veuillez d’abord définir les données d’identification d’application dans auth_oidc.';
$string['errorhttpclientbadtempfileloc'] = 'Impossible d’ouvrir l’emplacement temporaire pour stocker le fichier.';
$string['errorhttpclientnofileinput'] = 'Aucun paramètre de fichier dans httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Impossible d’actualiser le jeton';
$string['errormfarequired'] = 'Microsoft exige une authentification multifacteur avant que Moodle puisse accéder à votre compte Microsoft 365. Veuillez vous déconnecter de Moodle, puis vous reconnecter avec votre compte Microsoft 365 et répondre à la demande d’authentification multifacteur.';
$string['errorgetapplicationtoken'] = 'Impossible d’obtenir le jeton d’application. Veuillez vérifier la configuration de votre intégration.';
$string['erroracpapcantgettenant'] = 'Impossible d’obtenir le locataire Microsoft Entra, veuillez le saisir manuellement.';
$string['erroracpcantgettenant'] = 'Impossible d’obtenir l’URL OneDrive, veuillez la saisir manuellement.';
$string['errorprovisioningapp'] = 'Impossible de déployer l’application Moodle dans l’équipe.';
$string['erroro365apibadcall'] = 'Erreur d’appel API.';
$string['erroro365apibadcall_message'] = 'Erreur lors de l’appel de l’API : {$a}';
$string['erroro365apiinvalidtoken'] = 'Jeton non valide ou expiré.';
$string['erroro365apiinvalidmethod'] = 'Méthode httpmethod non valide transmise à apicall';
$string['erroro365apinotimplemented'] = 'Cette méthode doit être redéfinie.';
$string['erroro365apinotoken'] = 'Aucun jeton n’était disponible pour la ressource et l’utilisateur donnés, et il a été impossible d’en obtenir un. Le jeton d’actualisation de l’utilisateur a-t-il expiré ?';
$string['errorusermatched'] = 'Le compte Microsoft 365 « {$a->entraidupn} » est déjà mis en correspondance avec l’utilisateur Moodle « {$a->username} ». Pour finaliser la connexion, veuillez d’abord vous connecter en tant que cet utilisateur Moodle et suivre les instructions du bloc Microsoft.';
$string['errornodirectaccess'] = 'L’accès direct à la page est interdit';
$string['eventapifail'] = 'Échec de l’API';
$string['errorunabletofindgraphapi'] = 'Impossible de trouver l’API Microsoft Graph dans l’application.';
$string['erroremptyjwt'] = 'Jeton JWT vide fourni';
$string['errornocachedjwks'] = 'Aucun JWKS en cache trouvé';
$string['errorfetchjwks'] = 'Impossible de récupérer le JWKS auprès de Microsoft';
$string['errorinvalidjwks'] = 'Format JWKS non valide reçu de Microsoft';
$string['errorjwtvalidation'] = 'Échec de la validation du JWT';
$string['errorjwtinvalidissuer'] = 'Échec de la validation de l’émetteur du JWT';
$string['errorcannotgettoken'] = 'Impossible d’obtenir le jeton d’application ou système.';
$string['errornotokenforsysmemuser'] = 'Aucun jeton disponible pour l’utilisateur système. Veuillez exécuter le contrôle de l’état de local_o365.';
$string['errornotoken'] = 'Aucun jeton disponible pour l’utilisateur n° {$a}';
$string['errornotokenforusersync'] = 'Aucun jeton disponible pour la synchronisation des utilisateurs.';
$string['errornoapifound'] = 'Aucune API trouvée avec l’identifiant {$a}.';
$string['errornoresponsesavailable'] = 'Aucune réponse disponible.';
$string['erroro365badphoto'] = 'Photo de profil non valide reçue de Microsoft 365.';
$string['erroro365nophoto'] = 'Cet utilisateur n’a pas de photo dans Microsoft 365.';
$string['errorcannotgetapiclient'] = 'Impossible d’obtenir le client de l’API Graph.';
$string['errorfailedtogetsecrets'] = 'Impossible d’obtenir les secrets.';
$string['errorfailedtosendnotification'] = 'Impossible d’envoyer le courriel de notification à un ou plusieurs destinataires.';
$string['errorsecretexpiryrecipientundeliverable'] = 'Un ou plusieurs destinataires configurés pour la notification d’expiration du secret ne peuvent pas recevoir de courriel (adresse non valide, ou domaine sans enregistrement MX/A) : {$a}. Mettez à jour les destinataires des notifications dans les réglages OpenID Connect.';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Plugin local Microsoft 365';
$string['privacy:metadata:local_o365_calidmap'] = 'Informations sur les liens entre les événements de calendrier Microsoft 365 et les événements de calendrier Moodle.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'ID de l’utilisateur propriétaire de l’événement.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'Origine de l’événement : Moodle ou Microsoft 365.';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'ID de l’événement dans Outlook.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'ID de l’événement dans Moodle.';
$string['privacy:metadata:local_o365_calsub'] = 'Informations sur les abonnements de synchronisation entre les calendriers Moodle et Outlook';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'ID de l’utilisateur Moodle concerné par l’abonnement';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'Type de calendrier Moodle (site, cours, utilisateur)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'ID associé du calendrier Moodle';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'ID du calendrier Microsoft 365';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Indique s’il s’agit du calendrier principal';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'Comportement de synchronisation (c.-à-d. de Moodle vers Outlook ou d’Outlook vers Moodle)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'Date de création de l’abonnement.';
$string['privacy:metadata:local_o365_connections'] = 'Informations sur les connexions entre utilisateurs Moodle et Microsoft 365 qui n’ont pas encore été confirmées';
$string['privacy:metadata:local_o365_connections:muserid'] = 'ID de l’utilisateur Moodle';
$string['privacy:metadata:local_o365_connections:entraidupn'] = 'UPN de l’utilisateur Microsoft Entra ID.';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Indique s’il faut changer la méthode d’authentification de l’utilisateur une fois la connexion finalisée.';
$string['privacy:metadata:local_o365_token'] = 'Informations sur les jetons d’API Microsoft 365 des utilisateurs';
$string['privacy:metadata:local_o365_token:user_id'] = 'ID de l’utilisateur Moodle';
$string['privacy:metadata:local_o365_token:scope'] = 'Étendue du jeton.';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'Ressource du jeton.';
$string['privacy:metadata:local_o365_token:token'] = 'Le jeton.';
$string['privacy:metadata:local_o365_token:expiry'] = 'Date d’expiration du jeton.';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'Jeton d’actualisation.';
$string['privacy:metadata:local_o365_objects'] = 'Informations sur la relation entre les objets Moodle et Microsoft 365';
$string['privacy:metadata:local_o365_objects:type'] = 'Type d’objet (groupe, utilisateur, cours, etc.)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'Sous-type de l’objet.';
$string['privacy:metadata:local_o365_objects:objectid'] = 'ID de l’objet Microsoft 365';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'ID de l’objet dans Moodle';
$string['privacy:metadata:local_o365_objects:o365name'] = 'Nom lisible de l’objet dans Microsoft 365';
$string['privacy:metadata:local_o365_objects:tenant'] = 'Locataire auquel appartient l’objet (dans les environnements multilocataires)';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Toutes métadonnées associées';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'Date de création de l’enregistrement.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'Date de modification de l’enregistrement.';
$string['privacy:metadata:local_o365_appassign'] = 'Informations sur les attributions de rôles d’application Microsoft 365';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'ID de l’utilisateur Moodle';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Indique si l’utilisateur a été attribué à l’application';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'ID de la photo de l’utilisateur dans Microsoft 365';
$string['privacy:metadata:local_o365_appassign:photohash'] = 'Hachage SHA-256 des octets de la photo de profil de l’utilisateur, enregistré pour détecter les changements de photo sans récupérer à nouveau l’image complète';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Date de la dernière mise à jour de la photo de l’utilisateur depuis Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue'] = 'Informations sur la correspondance entre utilisateurs Moodle et utilisateurs Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'Nom d’utilisateur de l’utilisateur Moodle.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'Nom d’utilisateur de l’utilisateur Microsoft 365.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Indique s’il faut basculer l’utilisateur vers l’authentification OpenID Connect lorsque la correspondance est établie';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Indique si l’enregistrement a été traité';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'Le message d’erreur (le cas échéant)';
$string['privacy:metadata:preference:suspendedtime'] = 'Date à laquelle l’utilisateur a été suspendu par la synchronisation des utilisateurs, parce que le compte Microsoft Entra ID correspondant a été supprimé ou désactivé.';
$string['privacy:metadata:local_o365_calsettings'] = 'Informations sur les réglages de synchronisation du calendrier';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'ID de l’utilisateur Moodle';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'ID du calendrier dans Microsoft 365';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'Date de création de l’enregistrement.';
$string['privacy:metadata:preference:calsync_initialised'] = 'Indique si les choix de synchronisation du calendrier Outlook de l’utilisateur ont été initialisés, afin qu’ils ne soient pas à nouveau activés automatiquement.';

// Page "Microsoft 365 / Moodle Control Panel" in the Microsoft block.
$string['ucp_title'] = 'Panneau de configuration Microsoft 365 / Moodle';
$string['ucp_general_intro'] = 'Vous pouvez gérer ici votre connexion à Microsoft 365.';
$string['ucp_calsync_availcal'] = 'Calendriers Moodle disponibles';
$string['ucp_calsync_title'] = 'Réglages de synchronisation du calendrier Outlook';
$string['ucp_calsync_desc'] = 'Les calendriers cochés seront synchronisés de Moodle vers votre calendrier Outlook.';
$string['ucp_connection_options'] = 'Options de connexion :';
$string['ucp_connection_desc'] = 'Vous pouvez configurer ici la façon dont vous vous connectez à Microsoft 365. Pour utiliser les fonctionnalités Microsoft 365, vous devez être connecté à un compte Microsoft 365. Cela peut se faire comme indiqué ci-dessous.';
$string['ucp_connection_entraidlogin'] = 'Utiliser vos identifiants Microsoft 365 pour vous connecter à Moodle<br />';
$string['ucp_connection_entraidlogin_desc_authcode'] = 'Au lieu de saisir un nom d’utilisateur et un mot de passe sur la page de connexion de Moodle, vous verrez sur la page de connexion une section indiquant « Se connecter avec votre compte sur {$a} ». Cliquez sur le lien pour être redirigé vers Microsoft 365 et vous y connecter. Une fois connecté avec succès à Microsoft 365, vous serez renvoyé vers Moodle et connecté à votre compte.';
$string['ucp_connection_entraidlogin_start'] = 'Commencer à utiliser Microsoft 365 pour se connecter à Moodle.';
$string['ucp_connection_entraidlogin_stop'] = 'Cesser d’utiliser Microsoft 365 pour se connecter à Moodle.';
$string['ucp_connection_entraidlogin_active'] = 'Vous utilisez le compte Microsoft 365 « {$a} » pour vous connecter à Moodle.';
$string['ucp_connection_linked'] = 'Lier vos comptes Moodle et Microsoft 365';
$string['ucp_connection_linked_desc'] = 'Lier vos comptes Moodle et Microsoft 365 vous permet d’utiliser les fonctionnalités Microsoft 365 de Moodle sans changer votre façon de vous connecter à Moodle. <br />En cliquant sur le lien ci-dessous, vous serez dirigé vers Microsoft 365 pour une connexion unique, après quoi vous serez renvoyé ici. Vous pourrez utiliser toutes les fonctionnalités Microsoft 365 sans autre modification de votre compte Moodle : vous vous connecterez à Moodle comme vous l’avez toujours fait.';
$string['ucp_connection_linked_active'] = 'Vous êtes lié au compte Microsoft 365 « {$a} ».';
$string['ucp_connection_linked_start'] = 'Lier votre compte Moodle à un compte Microsoft 365.';
$string['ucp_connection_linked_migrate'] = 'Passer à un compte lié.';
$string['ucp_connection_linked_stop'] = 'Dissocier votre compte Moodle du compte Microsoft 365.';
$string['ucp_connection_disconnected'] = 'Vous n’êtes pas connecté à Microsoft 365.';
$string['ucp_features'] = 'Fonctionnalités Microsoft 365';
$string['ucp_features_intro'] = 'Voici une liste des fonctionnalités que vous pouvez utiliser pour améliorer Moodle avec Microsoft 365.';
$string['ucp_features_intro_notconnected'] = ' Certaines de ces fonctionnalités ne seront peut-être pas disponibles tant que vous ne vous serez pas connecté à Microsoft 365.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Pour vous connecter à Microsoft 365, vous devez contacter l’administrateur de votre site.';
$string['ucp_index_calendar_title'] = 'Réglages de synchronisation du calendrier Outlook';
$string['ucp_index_calendar_desc'] = 'Vous pouvez configurer ici la synchronisation entre vos calendriers Moodle et Outlook. Vous pouvez exporter des événements de calendrier Moodle dans Outlook, et importer des événements Outlook dans Moodle.';
$string['ucp_index_connection_title'] = 'Réglages de connexion Microsoft 365';
$string['ucp_index_connection_desc'] = 'Configurez la façon dont vous vous connectez à Microsoft 365.';
$string['ucp_index_connectionstatus_title'] = 'État de la connexion';
$string['ucp_index_connectionstatus_login'] = 'Cliquez ici pour vous connecter.';
$string['ucp_index_connectionstatus_usinglogin'] = 'Vous utilisez actuellement Microsoft 365 pour vous connecter à Moodle.';
$string['ucp_index_connectionstatus_usinglinked'] = 'Vous êtes lié à un compte Microsoft 365.';
$string['ucp_index_connectionstatus_manage'] = 'Gérer la connexion';
$string['ucp_index_connectionstatus_reconnect'] = 'Actualiser la connexion';
$string['ucp_index_connectionstatus_connected'] = 'Vous êtes actuellement connecté à Microsoft 365';
$string['ucp_index_connectionstatus_matched'] = 'Vous avez été mis en correspondance avec l’utilisateur Microsoft 365 <small>« {$a} »</small>. Pour finaliser cette connexion, cliquez sur le lien ci-dessous et connectez-vous à Microsoft 365.';
$string['ucp_index_connectionstatus_notconnected'] = 'Actuellement, vous n’êtes pas connecté à Microsoft 365';
$string['ucp_notconnected'] = 'Connectez-vous à Microsoft 365 avant d’accéder à cette page.';
$string['ucp_status_enabled'] = 'Actif';
$string['ucp_status_disabled'] = 'Non connecté';
$string['ucp_syncwith_title'] = 'Nom du calendrier Outlook avec lequel synchroniser :';
$string['ucp_syncdir_title'] = 'Comportement de synchronisation :';
$string['ucp_syncdir_out'] = 'De Moodle vers Outlook';
$string['ucp_syncdir_in'] = 'D’Outlook vers Moodle';
$string['ucp_syncdir_both'] = 'Mettre à jour Outlook et Moodle';
$string['ucp_o365accountconnected'] = 'Ce compte Microsoft 365 est déjà connecté à un autre compte Moodle.';

// Tasks.
$string['task_calendarsyncin'] = 'Synchroniser les événements Microsoft 365 dans Moodle';
$string['task_coursesync'] = 'Synchroniser les cours Moodle vers Microsoft Teams';
$string['task_coursemembershipsync'] = 'Synchroniser les propriétaires et membres Microsoft Teams vers les cours Moodle';
$string['task_groupmembershipsync'] = 'Synchroniser les propriétaires et membres des cours Moodle vers les groupes Microsoft 365';
$string['task_sds_sync'] = 'Synchroniser avec SDS';
$string['task_syncusers'] = 'Synchroniser les utilisateurs depuis Microsoft Entra ID';
$string['task_syncusersphotostimezones'] = 'Synchroniser les photos et fuseaux horaires des utilisateurs depuis Microsoft Entra ID';
$string['task_calsyncautosubscribe'] = 'Activer automatiquement la synchronisation du calendrier pour les utilisateurs connectés';
$string['task_groupchannelsync'] = 'Créer des canaux Teams pour les groupes Moodle et synchroniser leurs membres';
$string['task_groupchannelsyncgroup'] = 'Créer le canal Teams d’un groupe Moodle et synchroniser ses membres';
$string['task_userenabledstatussync'] = 'Suspendre/réactiver/supprimer les utilisateurs selon leur état dans Microsoft Entra ID';
$string['task_processmatchqueue'] = 'Traiter la file d’attente de correspondance';
$string['task_notifysecretexpiry'] = 'Avertir l’administrateur du site de l’expiration du secret de l’application Microsoft Entra ID';
$string['task_checkinvalidconfiglog'] = 'Vérifier et nettoyer les enregistrements non valides du journal de configuration';
$string['task_usergroupmembershipsync'] = 'Synchroniser l’appartenance des utilisateurs aux groupes de cours vers Microsoft 365';
$string['task_processmatchqueue_err_museralreadymatched'] = 'L’utilisateur Moodle est déjà mis en correspondance avec un utilisateur Microsoft 365.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'L’utilisateur Moodle est déjà connecté à Microsoft 365.';
$string['task_processmatchqueue_err_nomuser'] = 'Aucun utilisateur Moodle trouvé avec ce nom d’utilisateur.';
$string['task_processmatchqueue_err_noo365user'] = 'Aucun utilisateur Microsoft 365 trouvé avec ce nom d’utilisateur.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'L’utilisateur Microsoft 365 est déjà mis en correspondance avec un utilisateur Moodle.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'L’utilisateur Microsoft 365 est déjà connecté à un utilisateur Moodle.';

// Capabilities.
$string['o365:manageconnectionlink'] = 'Gérer la liaison de connexion';
$string['o365:manageconnectionunlink'] = 'Gérer la dissociation de connexion';
$string['o365:managecoursesync'] = 'Activer ou désactiver la synchronisation Teams des cours via les services web';
$string['o365:viewgroups'] = 'Voir les liens vers les services Microsoft 365 dans le bloc Microsoft des cours où la synchronisation est activée';
$string['o365:managegroups'] = 'Voir les liens vers les services Microsoft 365 et les options de gestion dans le bloc Microsoft des cours où la synchronisation est activée';
$string['o365:teammember'] = 'Membre d’équipe';
$string['o365:teamowner'] = 'Propriétaire d’équipe';

// Cache Stores.
$string['cachedef_groups'] = 'Stocke les données des groupes Microsoft 365';
$string['cachedef_jwks'] = 'Stocke les clés JWKS de Microsoft';

// Web service errors.
$string['webservices_error_assignnotfound'] = 'L’enregistrement de devoir du module reçu est introuvable.';
$string['webservices_error_invalidassignment'] = 'L’ID de devoir reçu ne peut pas être utilisé avec cette fonction de service web.';
$string['webservices_error_modulenotfound'] = 'L’ID de module reçu est introuvable.';
$string['webservices_error_sectionnotfound'] = 'La section du cours est introuvable.';
$string['webservices_error_couldnotsavegrade'] = 'Impossible d’enregistrer la note.';

// User sync task help text.
$string['help_user_create'] = 'Aide sur la création de comptes';
$string['help_user_create_help'] = 'Cette option crée dans Moodle un utilisateur pour chaque utilisateur du Microsoft Entra ID lié. Seuls les utilisateurs qui n’ont pas encore de compte Moodle verront un compte créé. Les nouveaux comptes sont configurés avec la méthode d’authentification OpenID Connect à partir de leur profil Microsoft Entra ID, et pourront utiliser toutes les fonctionnalités d’intégration Microsoft 365/Moodle.';
$string['help_user_update'] = 'Aide sur la mise à jour de tous les comptes';
$string['help_user_update_help'] = 'Cette option met à jour dans Moodle tous les utilisateurs à partir de chaque utilisateur du Microsoft Entra ID lié.';
$string['help_user_suspend'] = 'Aide sur la suspension des comptes';
$string['help_user_suspend_help'] = 'Cette option suspend les utilisateurs dans Moodle s’ils sont marqués comme supprimés dans Microsoft Entra ID.';
$string['help_user_delete'] = 'Aide sur la suppression des comptes';
$string['help_user_delete_help'] = 'Cette option supprime les utilisateurs de Moodle s’ils sont marqués comme supprimés dans Microsoft Entra ID. Elle ne fonctionne que si l’option de suspension des utilisateurs est activée. Le compte Moodle sera supprimé et toutes les informations utilisateur associées seront retirées de Moodle. Soyez prudent ! Remarque : par défaut, la suppression a lieu 30 jours après la suppression du compte dans Microsoft Entra ID, en raison de la période de conservation après suppression réversible d’Entra ID (les comptes peuvent être restaurés pendant cette période). Un délai plus long entre la suspension et la suppression peut être configuré avec le réglage « Délai avant la suppression des utilisateurs suspendus ».';
$string['help_user_reenable'] = 'Aide sur la réactivation des comptes';
$string['help_user_reenable_help'] = 'Cette option réactive les comptes Moodle suspendus s’ils sont renvoyés par Microsoft Entra ID et sont autorisés à se connecter. Les comptes dont la connexion est bloquée (désactivés) dans Microsoft Entra ID resteront suspendus.';
$string['help_user_disabledsyncsuspend'] = 'Aide sur la suspension des comptes à la désactivation';
$string['help_user_disabledsyncsuspend_help'] = 'Cette option suspend les utilisateurs dans Moodle si leurs comptes connectés dans Microsoft Entra ID ne peuvent plus se connecter (désactivés), sans modifier le fait qu’ils soient ou non réactivés automatiquement si leur compte Microsoft Entra ID est de nouveau activé. Utilisez l’option « Réactiver les comptes dans Moodle lorsqu’ils sont réactivés dans Microsoft Entra ID » ci-dessous pour contrôler cela séparément.';
$string['help_user_groupsyncsuspend'] = 'Aide sur la suspension des comptes hors du groupe de synchronisation';
$string['help_user_groupsyncsuspend_help'] = 'Cette option suspend les utilisateurs dans Moodle s’ils sont toujours actifs dans Microsoft Entra ID mais ne sont ni membres ni propriétaires du groupe configuré dans le réglage « Filtre de groupe pour la synchronisation des utilisateurs ». La vérification porte uniquement sur l’appartenance actuelle : elle suspend aussi les utilisateurs synchronisés existants qui n’ont jamais fait partie du groupe, et pas seulement ceux qui l’ont quitté ; vérifiez donc votre groupe avant d’activer cette option. Cette option n’est disponible que lorsqu’un filtre de groupe pour la synchronisation des utilisateurs est configuré. Pour éviter une suspension massive, aucun utilisateur n’est suspendu si le groupe est vide ou si ses membres ne peuvent pas être récupérés. Les utilisateurs suspendus ne sont pas réactivés tant qu’ils ne sont pas dans le groupe.';
$string['help_user_disabledsyncreenable'] = 'Aide sur la réactivation des comptes à l’activation';
$string['help_user_disabledsyncreenable_help'] = 'Cette option réactive les utilisateurs suspendus dans Moodle si leurs comptes connectés dans Microsoft Entra ID sont de nouveau autorisés à se connecter (activés).';
$string['help_user_suspendnolink'] = 'Aide sur la suspension des comptes sans lien Microsoft';
$string['help_user_suspendnolink_help'] = 'Normalement, les options de suspension/désactivation ci-dessus ne concernent que les comptes disposant d’un enregistrement d’objet Microsoft Entra ID (créé lors de la synchronisation ou de la connexion du compte). Certains comptes OpenID Connect n’ont pas un tel enregistrement - par exemple parce qu’ils se sont connectés avant la configuration de l’API Microsoft Graph, ou parce que l’enregistrement a été supprimé par une déconnexion ou par une action « effacer les utilisateurs mis en correspondance ». Cette option fait en sorte que la tâche d’état vérifie aussi ces comptes, en faisant correspondre le nom d’utilisateur Moodle avec la valeur configurée de la revendication de nom d’utilisateur de liaison dans Entra ID.

Les comptes correspondants qui sont absents d’Entra ID, ou désactivés dans Entra ID, sont <strong>uniquement suspendus</strong> : ils ne sont jamais supprimés (sans ID d’objet enregistré, la période de conservation après suppression réversible d’Entra ID ne peut pas être vérifiée) et ne sont jamais réactivés automatiquement. Les comptes invités sont ignorés.

Cette option ne fonctionne que lorsque la revendication de nom d’utilisateur de liaison OpenID Connect est définie sur un champ précis pouvant être recherché dans Entra ID - « upn », « oid », « email » ou « samaccountname ». Avec « auto » (où la revendication effective est choisie à chaque connexion et peut différer d’un utilisateur à l’autre) ou toute autre revendication, le nom d’utilisateur Moodle ne peut pas être mis en correspondance de manière fiable avec un seul compte, et cette option ne fait rien.

Vérifiez vos utilisateurs suspendus après la première exécution : un compte basculé manuellement vers cette méthode d’authentification qui n’a jamais été un véritable utilisateur Entra ID sera suspendu par cette option.';
$string['help_user_match'] = 'Aide sur la mise en correspondance des comptes';
$string['help_user_match_help'] = 'Cette option examine chaque utilisateur du Microsoft Entra ID lié et tente de le faire correspondre à un utilisateur de Moodle. La correspondance repose sur l’UPN Microsoft Entra ID et le nom d’utilisateur Moodle. La comparaison ne tient pas compte de la casse et ignore la partie domaine de l’UPN Microsoft Entra ID. Par exemple, « BoB.SmiTh » dans Moodle correspondrait à « bob.smith@example.onmicrosoft.com ». Les comptes Moodle et Microsoft Entra ID des utilisateurs mis en correspondance seront connectés et ces utilisateurs pourront utiliser toutes les fonctionnalités d’intégration Microsoft 365 et Moodle. La méthode d’authentification de l’utilisateur ne change pas, sauf si le réglage ci-dessous est activé.';
$string['help_user_matchswitchauth'] = 'Aide sur le basculement des comptes mis en correspondance';
$string['help_user_matchswitchauth_help'] = 'Cette option nécessite que le réglage « Faire correspondre les utilisateurs Moodle préexistants » ci-dessus soit activé. Lorsqu’un utilisateur est mis en correspondance, l’activation de ce réglage fait passer sa méthode d’authentification à OpenID Connect. Il pourra alors se connecter à Moodle avec ses identifiants Microsoft 365. Remarque : assurez-vous que le plugin d’authentification OpenID Connect est activé si vous souhaitez utiliser ce réglage. Attention : si un nom d’utilisateur Moodle ne correspond qu’à la partie de l’UPN Microsoft Entra ID située avant le « @ » (et non à l’UPN complet), le réglage avancé « Longueur minimale d’un nom d’utilisateur inexact pour basculer vers Microsoft 365 » peut empêcher le basculement de la méthode d’authentification pour les utilisateurs dont le nom d’utilisateur est court.';
$string['help_user_appassign'] = 'Aide sur l’attribution des utilisateurs à l’application';
$string['help_user_appassign_help'] = 'Cette option attribue tous les comptes Microsoft Entra ID ayant un compte Moodle correspondant à l’application Microsoft Entra ID créée pour cette installation de Moodle, s’ils n’y sont pas déjà attribués.';
$string['help_user_photosync'] = 'Aide sur la synchronisation des photos de profil Microsoft 365 (cron)';
$string['help_user_photosync_help'] = 'Cette option synchronise les photos de profil Moodle de tous les utilisateurs avec leurs photos de profil Microsoft 365.';
$string['help_user_photosynconlogin'] = 'Aide sur la synchronisation des photos de profil Microsoft 365 (connexion)';
$string['help_user_photosynconlogin_help'] = 'Cette option synchronise la photo de profil Moodle d’un utilisateur avec sa photo de profil Microsoft 365 lorsqu’il se connecte. Notez que l’utilisateur doit pour cela consulter une page contenant le bloc Microsoft dans Moodle.';
$string['help_user_nodelta'] = 'Aide sur la synchronisation complète';
$string['help_user_nodelta_help'] = 'Par défaut, la synchronisation des utilisateurs ne synchronise que les modifications apportées dans Microsoft Entra ID depuis la dernière exécution. Cocher cette option force une synchronisation complète des utilisateurs à chaque exécution.';
$string['help_user_emailsync'] = 'Aide sur la synchronisation des noms d’utilisateur Microsoft Entra ID vers les adresses de courriel Moodle';
$string['help_user_emailsync_help'] = 'L’activation de cette option fait correspondre les noms d’utilisateur Microsoft Entra ID aux adresses de courriel Moodle, au lieu du comportement par défaut qui les fait correspondre aux noms d’utilisateur Moodle.';
$string['help_user_tzsync'] = 'Aide sur la synchronisation du fuseau horaire Outlook (cron)';
$string['help_user_tzsync_help'] = 'Cette option synchronise le fuseau horaire Moodle de tous les utilisateurs avec leur préférence de fuseau horaire Outlook.';
$string['help_user_tzsynconlogin'] = 'Aide sur la synchronisation du fuseau horaire Outlook (connexion)';
$string['help_user_tzsynconlogin_help'] = 'Cette option synchronise le fuseau horaire Moodle d’un utilisateur avec sa préférence de fuseau horaire Outlook. Notez que l’utilisateur doit pour cela consulter une page contenant le bloc Microsoft dans Moodle.';
$string['help_user_guestsync'] = 'Aide sur la synchronisation des utilisateurs invités';
$string['help_user_guestsync_help'] = 'Si cette option est activée, les utilisateurs invités de Microsoft Entra ID seront synchronisés vers Moodle par la tâche de synchronisation des utilisateurs.';

// Cohort sync feature.
$string['cohortsync_title'] = 'Synchronisation des cohortes';
$string['cohortsync_taskname'] = 'Synchronisation des cohortes';
$string['cohortsync_mappingadded'] = 'Nouvelle connexion ajoutée avec succès';
$string['cohortsync_mappingdeleted'] = 'Connexion supprimée avec succès';
$string['cohortsync_addmapping'] = 'Ajouter une connexion';
$string['cohortsync_deletemapping'] = 'Supprimer la connexion';
$string['cohortsync_desc'] = 'Cette page permet la synchronisation unidirectionnelle des groupes Microsoft 365 vers les cohortes Moodle au niveau du contexte système. L’ajout d’une nouvelle connexion lance le processus de synchronisation : les utilisateurs du groupe Microsoft 365 sélectionné qui sont connectés à Microsoft seront ajoutés à la cohorte Moodle sélectionnée.';
$string['cohortsync_tabledesc'] = 'Connexions actuelles entre les groupes Microsoft 365 et les cohortes Moodle';
$string['cohortsync_typetosearch'] = 'Saisissez pour rechercher un groupe Microsoft 365';
$string['cohortsync_typetosearch_cohort'] = 'Saisissez pour rechercher une cohorte Moodle';
$string['cohortsync_emptymatchings'] = 'Aucune connexion trouvée';
$string['cohortsync_select_cohort'] = 'Cohorte Moodle';
$string['cohortsync_select_group'] = 'Groupe Microsoft 365';
$string['cohortsync_tablehead_group'] = 'Groupe Microsoft 365';
$string['cohortsync_tablehead_cohort'] = 'Cohorte Moodle';
$string['cohortsync_tablehead_actions'] = 'Actions';
$string['cohortsync_search'] = 'Rechercher';
$string['cohortsync_load_more'] = 'Charger plus...';
$string['cohortsync_no_groups_found'] = 'Aucun groupe Microsoft 365 trouvé pour « {$a} »';
$string['cohortsync_no_cohorts_found'] = 'Aucune cohorte Moodle trouvée pour « {$a} »';
$string['cohortsync_error_no_group'] = 'Veuillez sélectionner un groupe Microsoft 365.';
$string['cohortsync_error_no_cohort'] = 'Veuillez sélectionner une cohorte Moodle.';
$string['cohortsync_mappingfailed'] = 'Erreur lors de l’ajout de la connexion entre la cohorte et le groupe. Causes possibles : le groupe ou la cohorte n’existe pas, le groupe est déjà connecté à une autre cohorte, le groupe est déjà connecté à cette cohorte.';
$string['cohortsync_connectionnotfound'] = 'Requête non valide : connexion introuvable.';
$string['cohortsync_connectionnotcohortsync'] = 'Requête non valide : type de connexion incompatible.';
$string['cohortsync_unifiedapierror'] = 'Erreur lors de la récupération de la liste des groupes depuis Microsoft.';

// Course request.
$string['courserequest_teams'] = 'Équipe Microsoft';
$string['courserequest_teams_help'] = 'Sélectionnez l’équipe Microsoft qui sera connectée au cours. Les propriétaires et membres existants de l’équipe seront inscrits au cours créé une fois la demande de cours approuvée.';
$string['courserequest_emptyteams'] = 'Aucune équipe Microsoft Teams disponible';
$string['courserequest_title'] = 'Demander un cours depuis Teams';
$string['courserequest_updatecourserequeststatus_taskname'] = 'Mettre à jour le statut des demandes de cours';
$string['courserequest_customrequestnote'] = '
| Cette demande est effectuée depuis la page de demande de cours de Microsoft Teams et sera connectée, après approbation, à l’équipe « {$a->name} » dont l’URL est {$a->url}.';
$string['courserequest_graphapi_disabled'] = 'La connexion à Microsoft Teams n’est pas disponible. Veuillez contacter l’administrateur de votre site.';
$string['courserequest_invalid_team'] = 'Équipe non valide utilisée dans la demande de cours.';
$string['courserequest_duplicate'] = 'Une demande de cours en attente ou approuvée existe déjà pour la même équipe.';

// Teams page.
$string['teams_no_course'] = 'Vous n’avez aucun cours à ajouter.';
$string['tab_name'] = 'Nom de l’onglet';
$string['sso_login'] = 'Se connecter à Microsoft 365';
$string['other_login'] = 'Se connecter manuellement';
$string['course_selector_label'] = 'Sélectionner un cours existant';

// Notifications to site admin about Microsoft Entra ID app secret.
$string['notification_subject_secret_expired'] = 'Action requise : le secret de l’application Microsoft Entra ID a expiré';
$string['notification_content_secret_expired'] = 'Cher administrateur du site,

Le secret de l’application Microsoft Entra ID utilisé dans votre intégration Moodle et Microsoft 365 a expiré.
Veuillez créer un nouveau secret dans Microsoft Entra ID et le mettre à jour dans la configuration de l’intégration afin de rétablir celle-ci.';
$string['notification_subject_secret_almost_expired'] = 'Action requise : le secret de l’application Microsoft Entra ID expire bientôt';
$string['notification_content_secret_almost_expired'] = 'Cher administrateur du site,

Le secret de l’application Microsoft Entra ID utilisé dans votre intégration Moodle et Microsoft 365 expirera dans {$a}.
Veuillez créer un nouveau secret dans Microsoft Entra ID et le mettre à jour dans la configuration de l’intégration afin d’éviter toute interruption de l’intégration.';
$string['notification_days_less_than_one_day'] = 'moins d’un jour';
$string['notification_days_one_day'] = '1 jour';
$string['notification_days_days'] = '{$a} jours';
$string['notification_subject_invalid_secret'] = 'Action requise : secret d’application Microsoft Entra ID non valide détecté';
$string['notification_content_invalid_secret'] = 'Cher administrateur du site,

Le secret de l’application Microsoft Entra ID utilisé dans votre intégration Moodle et Microsoft 365 semble non valide. Cela peut être dû à l’expiration ou à la suppression du secret.
Veuillez vérifier le secret afin de garantir le bon fonctionnement de l’intégration.';

// Async operations.
$string['teamsasyncfailed'] = 'Échec de l’opération asynchrone de création d’équipe : {$a}';
$string['unknownasyncstate'] = 'État d’opération asynchrone inconnu : {$a}';

// Template ID validation.
$string['error_template_id_empty'] = 'L’ID du modèle ne peut pas être vide.';
$string['error_not_connected'] = 'Non connecté à Microsoft 365. Veuillez d’abord configurer l’intégration Microsoft 365.';
$string['error_graph_client_not_available'] = 'Impossible de se connecter à l’API Microsoft Graph. Veuillez vérifier la configuration de votre intégration Microsoft 365.';
$string['success_template_id_valid'] = '✓ L’ID de modèle « {$a} » est valide et accessible.';
$string['error_template_id_not_found'] = '✗ L’ID de modèle « {$a} » est introuvable. Veuillez le vérifier dans le Centre d’administration Teams.';
$string['error_template_validation_failed'] = '✗ Échec de la validation du modèle : {$a}';
$string['error_template_validation_error'] = '✗ Une erreur est survenue lors de la validation du modèle. Veuillez réessayer ou contacter votre administrateur.';

// Role sync feature.
$string['settings_header_rolesync'] = 'Synchronisation des rôles';
$string['task_rolesync'] = 'Synchroniser les rôles système depuis les groupes Microsoft 365';
$string['settings_rolesync_intro'] = 'Attribue automatiquement des rôles système Moodle (par exemple Gestionnaire ou Créateur de cours) aux utilisateurs en fonction de leur appartenance à un groupe Microsoft 365. Cette fonctionnalité ne supprime que les rôles qu\'elle a elle-même attribués ; les rôles attribués manuellement ne sont jamais modifiés. Pour attribuer des rôles à partir d\'une revendication du jeton d\'ID OIDC, ce qui fonctionne avec tout fournisseur d\'identité, utilisez la <a href="{$a}">page Synchronisation des rôles du plugin d\'authentification OpenID Connect</a>.';
$string['settings_rolesync_groupheading'] = 'Synchronisation des rôles depuis les groupes Microsoft 365';
$string['settings_rolesync_groupheading_desc'] = 'S\'exécute via la tâche planifiée « Synchroniser les rôles système depuis les groupes Microsoft 365 » (toutes les 15 minutes par défaut), indépendamment de la synchronisation des utilisateurs. Elle ne s\'exécute pas à la connexion : une modification de l\'appartenance à un groupe prend effet à la prochaine exécution de la tâche. Seuls les utilisateurs déjà connectés à Microsoft 365 sont traités.';
$string['settings_rolesync_groupmap'] = 'Correspondance groupe-rôle';
$string['settings_rolesync_groupmap_details'] = 'Une correspondance par ligne, au format <code>ID d\'objet du groupe=nom abrégé du rôle</code>. Plusieurs rôles peuvent être séparés par des virgules, par exemple <code>550e8400-e29b-41d4-a716-446655440000=manager,coursecreator</code>. Les membres et les propriétaires du groupe, y compris les membres des groupes imbriqués, reçoivent les rôles dans le contexte système. Seuls les utilisateurs connectés à Microsoft 365 sont concernés. Les lignes commençant par # sont ignorées.';
$string['settings_rolesync_revoke'] = 'Supprimer les rôles qui ne correspondent plus';
$string['settings_rolesync_revoke_details'] = 'Si cette option est activée, les rôles précédemment attribués par la synchronisation des rôles par groupe sont retirés d\'un utilisateur lors de la prochaine exécution de la tâche planifiée, lorsqu\'il n\'appartient plus à un groupe associé. Les rôles attribués manuellement ou autrement ne sont jamais supprimés.';
$string['settings_rolesync_error_format'] = 'Ligne de correspondance non valide « {$a} ». Utilisez le format source=nomabrégé[,nomabrégé].';
$string['settings_rolesync_error_group'] = 'ID d\'objet de groupe non valide « {$a} ». Il doit s\'agir d\'un GUID.';
$string['settings_rolesync_error_role'] = 'Nom abrégé de rôle inconnu ou non pris en charge « {$a} ». Seuls les rôles pouvant être attribués dans le contexte système peuvent être utilisés.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
