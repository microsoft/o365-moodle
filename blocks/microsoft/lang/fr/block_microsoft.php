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
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft';
$string['contactadmin'] = 'Contactez l’administrateur pour plus d’informations.';
$string['error_nomoodlenotebook'] = 'Impossible de trouver votre bloc-notes Moodle.';
$string['error_urlrequiredwhenenabled'] = 'Cette URL doit être configurée, car l’option « Afficher » ci-dessus est activée.';
$string['linkonedrive'] = 'Mon OneDrive';
$string['linkonenote'] = 'Mon bloc-notes OneNote';
$string['linksways'] = 'Mes Sway';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsstreamclassic'] = 'Microsoft Stream (classique)';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'Mon courrier';
$string['linkonenote_unavailable'] = 'OneNote non disponible';
$string['linksharepoint'] = 'Site SharePoint du cours';
$string['linkoutlook'] = 'Réglages de synchronisation du calendrier Outlook';
$string['linkprefs'] = 'Modifier les réglages';
$string['linkconnection'] = 'Réglages de connexion à Microsoft 365';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = 'Ajouter un bloc Microsoft';
$string['microsoft:myaddinstance'] = 'Ajouter un bloc Microsoft au tableau de bord';
$string['workonthis'] = 'Travailler sur cet élément';
$string['o365matched_title'] = 'Vous êtes <span style="color: #960">presque</span> connecté à Microsoft 365';
$string['o365matched_desc'] = 'Vous avez été mis en correspondance avec l’utilisateur Microsoft 365 <b>« {$a} »</b>';
$string['o365matched_complete_authreq'] = 'Pour finaliser la connexion, veuillez cliquer sur le lien ci-dessous et vous connecter à ce compte Microsoft 365.';
$string['o365connected'] = '{$a->firstname}, vous êtes actuellement <span class="notifysuccess">connecté</span> à Microsoft 365';
$string['notconnected'] = 'Vous n’êtes <span class="notifyproblem">connecté</span> à aucun service Microsoft.';
$string['course_connected_to_team'] = 'Le cours est <span class="notifysuccess">connecté</span> à une <b>équipe</b>.';
$string['course_connected_to_team_pending'] = 'Le cours est configuré pour être connecté à une <b>équipe</b>, mais la création de l’équipe est <span class="notifyproblem">en attente</span>.';
$string['course_connected_to_group_pending'] = 'Le cours est configuré pour être connecté à une <b>équipe</b>, mais la création du groupe est <span class="notifyproblem">en attente</span>.';
$string['course_not_connected'] = 'Le cours n’est <span class="notifyproblem">connecté</span> à aucun service Microsoft.';
$string['cachedef_onenotenotebook'] = 'Stocke le bloc-notes OneNote.';
$string['logintoo365'] = 'Se connecter à Microsoft 365';
$string['connecttoo365'] = 'Connexion à Microsoft 365';
$string['install_office'] = 'Installer Office';

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
$string['settings_showemail'] = 'Afficher « Mon courrier »';
$string['settings_showemail_desc'] = 'Activer ou désactiver le lien « Mon courrier » dans le bloc.';
$string['settings_showmydelve'] = 'Afficher « Mon Delve »';
$string['settings_showmydelve_desc'] = 'Activer ou désactiver le lien « Mon Delve » dans le bloc.';
$string['settings_showmyforms'] = 'Afficher « Mes Forms »';
$string['settings_showmyforms_desc'] = 'Activer ou désactiver le lien « Mes Forms » dans le bloc.';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = 'Afficher « Installer Office »';
$string['settings_showo365download_desc'] = 'Activer ou désactiver le lien « Installer Office » dans le bloc.';
$string['settings_showsways'] = 'Afficher « Mes Sway »';
$string['settings_showsways_desc'] = 'Activer ou désactiver le lien « Mes Sway » dans le bloc.';
$string['settings_showmsstream'] = 'Afficher « Microsoft Stream (sur SharePoint) »';
$string['settings_showmsstream_desc'] = 'Activer ou désactiver le lien « Microsoft Stream (sur SharePoint) » dans le bloc.';
$string['settings_showmsstreamclassic'] = 'Afficher « Microsoft Stream (classique) »';
$string['settings_showmsstreamclassic_desc'] = 'Activer ou désactiver le lien « Microsoft Stream (classique) » dans le bloc.';
$string['settings_showmsteams'] = 'Afficher « Microsoft Teams »';
$string['settings_showmsteams_desc'] = 'Activer ou désactiver le lien « Microsoft Teams » dans le bloc.';
$string['settings_showonedrive'] = 'Afficher « Mon OneDrive »';
$string['settings_showonedrive_desc'] = 'Activer ou désactiver le lien « Mon OneDrive » dans le bloc.';
$string['settings_showonenotenotebook'] = 'Afficher « Mon bloc-notes OneNote »';
$string['settings_showonenotenotebook_desc'] = 'Activer ou désactiver le lien « Mon bloc-notes OneNote » dans le bloc.';
$string['settings_showoutlooksync'] = 'Afficher « Réglages de synchronisation du calendrier Outlook »';
$string['settings_showoutlooksync_desc'] = 'Activer ou désactiver le lien « Réglages de synchronisation du calendrier Outlook » dans le bloc.';
$string['settings_showpreferences'] = 'Afficher « Modifier les réglages »';
$string['settings_showpreferences_desc'] = 'Activer ou désactiver le lien « Modifier les réglages » dans le bloc.';
$string['settings_showo365connect'] = 'Afficher « Connexion à Microsoft 365 »';
$string['settings_showo365connect_desc'] = 'Activer ou désactiver le lien « Connexion à Microsoft 365 » dans le bloc. <br /><b>Remarque :</b> ce lien est affiché aux utilisateurs qui ne sont pas connectés à Microsoft 365 et les dirige vers la page leur permettant de configurer une connexion.';
$string['settings_showmanageo365conection'] = 'Afficher « Réglages de connexion à Microsoft 365 »';
$string['settings_showmanageo365conection_desc'] = 'Activer ou désactiver le lien « Réglages de connexion à Microsoft 365 » dans le bloc. <br /><b>Remarque :</b> ce lien est affiché aux utilisateurs connectés à Microsoft 365 et les dirige vers la page de gestion de la connexion.';
$string['settings_showcoursespsite'] = 'Afficher « Site SharePoint du cours »';
$string['settings_showcoursespsite_desc'] = 'Activer ou désactiver le lien « Site SharePoint du cours » dans le bloc. <br /><b>Remarque :</b> ce lien est affiché dans le bloc lors de la consultation d’un cours associé à un site SharePoint.';
$string['settings_showcourselinks'] = 'Afficher les liens du cours';
$string['settings_showcourselinks_desc'] = 'Activer ou désactiver l’ensemble de la section cours du bloc affichée lors de la consultation d’un cours, y compris l’en-tête d’état du cours et tous les liens du cours. <br /><b>Remarque :</b> lorsque cette option est désactivée, les réglages individuels des liens du cours ci-dessous sont ignorés.';
$string['settings_showcourseconfiguresync'] = 'Afficher « Configurer la synchronisation du cours »';
$string['settings_showcourseconfiguresync_desc'] = 'Activer ou désactiver le lien « Configurer la synchronisation du cours » dans la section cours du bloc.';
$string['settings_showcourseteam'] = 'Afficher « Équipe »';
$string['settings_showcourseteam_desc'] = 'Activer ou désactiver le lien « Équipe » dans la section cours du bloc.';
$string['settings_showcourseconversations'] = 'Afficher « Conversations Outlook »';
$string['settings_showcourseconversations_desc'] = 'Activer ou désactiver le lien « Conversations Outlook » dans la section cours du bloc.';
$string['settings_showcourseonedrive'] = 'Afficher « Fichiers OneDrive »';
$string['settings_showcourseonedrive_desc'] = 'Activer ou désactiver le lien « Fichiers OneDrive » dans la section cours du bloc.';
$string['settings_showcoursecalendar'] = 'Afficher « Calendrier Outlook »';
$string['settings_showcoursecalendar_desc'] = 'Activer ou désactiver le lien « Calendrier Outlook » dans la section cours du bloc.';
$string['settings_showcoursenotebook'] = 'Afficher « Bloc-notes pour la classe »';
$string['settings_showcoursenotebook_desc'] = 'Activer ou désactiver le lien « Bloc-notes pour la classe » dans la section cours du bloc.';
$string['settings_showcoursereset'] = 'Afficher « Options de réinitialisation du cours »';
$string['settings_showcoursereset_desc'] = 'Activer ou désactiver le lien « Options de réinitialisation du cours » dans la section cours du bloc.';
$string['settings_geto365link'] = 'URL de téléchargement « Installer Office »';
$string['settings_geto365link_desc'] = 'L’URL à utiliser pour le lien « Installer Office ».';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['settings_showword'] = 'Afficher « Word »';
$string['settings_showword_desc'] = 'Activer ou désactiver le lien « Word » dans le bloc.';
$string['settings_showexcel'] = 'Afficher « Excel »';
$string['settings_showexcel_desc'] = 'Activer ou désactiver le lien « Excel » dans le bloc.';
$string['settings_showpowerpoint'] = 'Afficher « PowerPoint »';
$string['settings_showpowerpoint_desc'] = 'Activer ou désactiver le lien « PowerPoint » dans le bloc.';
$string['settings_showvivaengage'] = 'Afficher « Viva Engage »';
$string['settings_showvivaengage_desc'] = 'Activer ou désactiver le lien « Viva Engage » dans le bloc.';
$string['settings_showvivaamplify'] = 'Afficher « Viva Amplify »';
$string['settings_showvivaamplify_desc'] = 'Activer ou désactiver le lien « Viva Amplify » dans le bloc. <br /><b>Remarque :</b> l’URL Viva Amplify ci-dessous doit également être configurée pour que le lien soit affiché.';
$string['settings_vivaamplifyurl'] = 'URL Viva Amplify';
$string['settings_vivaamplifyurl_desc'] = 'L’URL de l’expérience Viva Amplify de votre organisation, telle que configurée par l’administrateur de votre locataire Microsoft 365, par exemple https://amplify.microsoft.com/. Seules les URL d’un domaine amplify.microsoft.com ou amplify.cloud.microsoft sont acceptées.';
$string['settings_showvivaconnections'] = 'Afficher « Viva Connections »';
$string['settings_showvivaconnections_desc'] = 'Activer ou désactiver le lien « Viva Connections » dans le bloc. <br /><b>Remarque :</b> l’URL Viva Connections ci-dessous doit également être configurée pour que le lien soit affiché.';
$string['settings_vivaconnectionsurl'] = 'URL Viva Connections';
$string['settings_vivaconnectionsurl_desc'] = 'L’URL de l’expérience Viva Connections de votre organisation, telle que configurée par l’administrateur de votre locataire Microsoft 365. Il s’agit généralement du site d’accueil SharePoint, par exemple https://yourtenant.sharepoint.com/sites/yourhomesite. Seules les URL d’un domaine *.sharepoint.com (ou de son équivalent dans un cloud souverain) sont acceptées.';
$string['settings_showvivaglint'] = 'Afficher « Viva Glint »';
$string['settings_showvivaglint_desc'] = 'Activer ou désactiver le lien « Viva Glint » dans le bloc.';
$string['settings_showvivagoals'] = 'Afficher « Viva Goals »';
$string['settings_showvivagoals_desc'] = 'Activer ou désactiver le lien « Viva Goals » dans le bloc.';
$string['settings_showvivainsights'] = 'Afficher « Viva Insights »';
$string['settings_showvivainsights_desc'] = 'Activer ou désactiver le lien « Viva Insights » dans le bloc.';
$string['settings_showvivalearning'] = 'Afficher « Viva Learning »';
$string['settings_showvivalearning_desc'] = 'Activer ou désactiver le lien « Viva Learning » dans le bloc. <br /><b>Remarque :</b> l’URL Viva Learning ci-dessous doit également être configurée pour que le lien soit affiché.';
$string['settings_vivalearningurl'] = 'URL Viva Learning';
$string['settings_vivalearningurl_desc'] = 'L’URL de l’expérience Viva Learning de votre organisation, telle que configurée par l’administrateur de votre locataire Microsoft 365, par exemple https://web.viva.microsoft.com/learning. Seules les URL d’un domaine viva.microsoft.com ou cloud.microsoft sont acceptées.';
$string['settings_showvivapulse'] = 'Afficher « Viva Pulse »';
$string['settings_showvivapulse_desc'] = 'Activer ou désactiver le lien « Viva Pulse » dans le bloc.';
$string['settings_showlinkedin'] = 'Afficher « LinkedIn »';
$string['settings_showlinkedin_desc'] = 'Activer ou désactiver le lien « LinkedIn » dans le bloc.';

$string['linkmydelve'] = 'Mon Delve';
$string['linkmyforms'] = 'Mes Forms';
$string['privacy:metadata'] = 'Le bloc Microsoft affiche uniquement des liens vers diverses fonctionnalités et services.';

// Course sync features.
$string['course_feature_team'] = 'Équipe';
$string['course_feature_conversations'] = 'Conversations Outlook';
$string['course_feature_onedrive'] = 'Fichiers OneDrive';
$string['course_feature_calendar'] = 'Calendrier Outlook';
$string['course_feature_notebook'] = 'Bloc-notes pour la classe';

// Course sync settings.
$string['configure_sync'] = 'Configurer la synchronisation du cours';
$string['error_course_sync_not_configurable_per_course'] = 'La synchronisation des cours ne peut pas être configurée cours par cours.';
$string['sync_page_heading'] = 'Synchroniser le cours {$a} avec Microsoft Teams';
$string['configure_course_sync'] = 'Configurer la synchronisation du cours avec Microsoft Teams';
$string['course_sync_option'] = 'Option de synchronisation';
$string['course_sync_option_disabled'] = 'Désactivée';
$string['course_sync_option_enabled'] = 'Activée';
$string['sync_setting_saved'] = 'L’option de synchronisation du cours a été enregistrée';

// Course reset status.
$string['course_reset_disconnect_and_create_new'] = 'Lors de la réinitialisation du cours, l’équipe connectée au cours sera renommée selon la configuration, puis archivée. Une nouvelle équipe sera créée et connectée au cours.';
$string['course_reset_do_nothing'] = 'Lors de la réinitialisation du cours, la connexion entre le cours et l’équipe sera conservée. Toutes les modifications d’utilisateurs apportées au cours seront synchronisées avec l’équipe.';
$string['course_reset_disconnect_only'] = 'Lors de la réinitialisation du cours, l’équipe connectée au cours sera renommée selon la configuration, puis archivée. Aucune nouvelle équipe ne sera créée.';
$string['configure_reset'] = 'Choisir l’action Microsoft Teams lors de la réinitialisation du cours';

// Course reset settings page.
$string['reset_page_heading'] = 'Action de réinitialisation du cours {$a}';
$string['configure_course_reset'] = 'Configurer le réglage de réinitialisation du cours';
$string['course_reset_option'] = 'Action sur l’équipe lors de la réinitialisation du cours';
$string['reset_option_do_nothing'] = 'Ne rien faire.<br/>L’équipe restera connectée au cours. Les désinscriptions d’utilisateurs entraîneront le retrait de leur statut de propriétaire ou de membre de l’équipe.';
$string['reset_option_disconnect_and_create_new'] = 'Déconnecter et créer une nouvelle équipe.<br/>L’équipe existante connectée au cours sera renommée selon la configuration, puis archivée. Une nouvelle équipe sera créée et connectée au cours.';
$string['reset_option_disconnect_only'] = 'Déconnecter uniquement.<br/>L’équipe existante connectée au cours sera renommée selon la configuration, puis archivée. Aucune nouvelle équipe ne sera créée.';
$string['reset_setting_saved'] = 'Le réglage de réinitialisation du cours a été enregistré.';
$string['error_site_course_sync_disabled'] = 'La synchronisation des cours n’est pas activée';
$string['error_reset_setting_not_managed_per_course'] = 'La configuration de l’action de réinitialisation est gérée de manière centralisée par les administrateurs du site.';
$string['error_connected_team_missing'] = 'Le cours est configuré pour être synchronisé, mais l’équipe est introuvable.';
$string['error_course_sync_disabled'] = 'Le cours n’est pas configuré pour être synchronisé.';

// Course request.
$string['linkcourserequest'] = 'Demander un cours depuis Teams';
$string['settings_courserequest'] = 'Demander un cours depuis Teams';
$string['settings_courserequest_desc'] = 'Demander un nouveau cours depuis Microsoft Teams. Après approbation, le cours sera créé et connecté à une équipe. Les membres de l’équipe seront inscrits au cours.';

$string['customlinks'] = 'Liens personnalisés';
$string['customlink_addanother'] = 'Ajouter un autre lien';
$string['customlink_delete'] = 'Supprimer ce lien';
$string['customlink_error_url'] = 'Saisissez une URL valide commençant par http:// ou https://';
$string['customlink_icon'] = 'Icône';
$string['customlink_name'] = 'Nom';
$string['customlink_nochanges'] = 'Aucun lien personnalisé n’a été saisi ; il n’y a donc rien à enregistrer.';
$string['customlink_showall'] = 'Afficher également aux utilisateurs qui ne sont pas connectés à Microsoft 365';
$string['customlink_target'] = 'Ouvrir le lien dans';
$string['customlink_url'] = 'URL';
$string['customlink_visibility'] = 'Visibilité';
$string['settings_header_general'] = 'Général';
$string['settings_pageheading'] = 'Configuration du bloc Microsoft';
$string['settings_customlinkheading'] = 'Lien {$a}';
$string['settings_customlinktarget_blank'] = 'Nouvelle fenêtre ou nouvel onglet';
$string['settings_customlinktarget_self'] = 'Même fenêtre';
$string['settings_customlinks_desc'] = 'Ajoutez vos propres liens (par exemple un chatbot interne ou un site intranet) au bloc. Le nom, l’URL et l’icône de chaque lien sont obligatoires. Pour supprimer un lien, cochez « Supprimer ce lien » et enregistrez.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
