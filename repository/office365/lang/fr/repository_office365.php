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
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Dépôt Microsoft 365 - ID de dossiers unifiés';
$string['cachedef_unifiedgroupfolderids'] = 'Dépôt Microsoft 365 - ID de dossiers unifiés des groupes';
$string['configplugin'] = 'Configurer le dépôt Microsoft 365';
$string['controlledsharelinkdesc'] = 'Copie partagée (membres de l’organisation uniquement)';
$string['copiedfile'] = 'Copie du fichier';
$string['defaultgroupsfolder'] = 'Fichiers du cours';
$string['directlinkdesc'] = 'Lien direct (autorisations existantes)';
$string['enableanonymousshare'] = 'Activer l’option « {$a} »';
$string['enableanonymousshare_help'] = 'Si cette case est cochée, les utilisateurs peuvent choisir de créer une copie d’un fichier et de la partager avec toutes les personnes de l’organisation. La copie est stockée dans le OneDrive de l’utilisateur et partagée avec tous les membres de l’organisation.

**Fonctionnement :**
* Une copie du fichier sélectionné est créée avec le suffixe « - Shared ».
* La copie est enregistrée dans le OneDrive de l’utilisateur (et non à l’emplacement d’origine).
* Un lien de partage limité à l’organisation est créé pour la copie.
* Le fichier d’origine reste inchangé, avec ses autorisations existantes.

**Contrôle d’accès :**
* Seuls les membres de votre organisation Microsoft 365 peuvent accéder au fichier.
* Toute personne de l’organisation disposant du lien peut CONSULTER le fichier.
* Les utilisateurs externes et anonymes NE PEUVENT PAS accéder au fichier.
* Le lien n’expire pas automatiquement.
* Le propriétaire du fichier peut gérer ou révoquer le partage depuis son OneDrive.

**Quand l’utiliser :**
* Vous souhaitez partager un fichier avec tous les membres de l’organisation.
* Vous souhaitez protéger le fichier d’origine contre les modifications accidentelles.
* L’espace de stockage dans Moodle est une préoccupation.
* Le contenu du fichier convient à un accès à l’échelle de l’organisation.

**Remarques importantes :**
* La copie peut prendre quelques secondes pour les fichiers volumineux.
* Les utilisateurs doivent s’assurer que le contenu du fichier convient à un partage à l’échelle de l’organisation.
* Le fichier copié apparaîtra dans le OneDrive de l’utilisateur avec le suffixe « - Shared ».
* Les modifications apportées au fichier d’origine ne seront PAS répercutées dans la copie partagée, et inversement.

**Cette option est désactivée par défaut en raison de limitations d’affichage et de risques de confusion. Ne cochez cette case que si vous souhaitez permettre aux utilisateurs de créer des copies partagées avec l’organisation.**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>Remarque :</strong> lors de l’utilisation de l’option « {$a} », une copie du fichier d’origine est créée et partagée avec tous les membres de l’organisation. Le fichier d’origine reste inchangé. Les utilisateurs doivent s’assurer que le contenu du fichier convient à un accès à l’échelle de l’organisation.
<br><br><strong>Limitations d’affichage :</strong> les fichiers partagés avec cette option présentent des limitations selon le type de fichier et l’option d’affichage utilisée dans les ressources. Le comportement varie comme suit :
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Option d’affichage</th>
<th>Images</th>
<th>Fichiers (par exemple .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatique</strong></td>
<td style="background-color: #ffdddd;">Ne fonctionne pas - rien n’est affiché, connexion bloquée</td>
<td>Fonctionne - redirection vers OneDrive</td>
</tr>
<tr>
<td><strong>Intégrer</strong></td>
<td>Fonctionne - l’image est intégrée</td>
<td style="background-color: #ffdddd;">Ne fonctionne pas - l’iframe affiche une erreur de connexion refusée</td>
</tr>
<tr>
<td><strong>Forcer le téléchargement</strong></td>
<td colspan="2">Fonctionne - redirection vers OneDrive</td>
</tr>
<tr>
<td><strong>Ouvrir</strong></td>
<td colspan="2">Fonctionne - redirection vers OneDrive</td>
</tr>
<tr>
<td><strong>Dans une fenêtre surgissante</strong></td>
<td colspan="2">Fonctionne - ouverture dans une fenêtre surgissante</td>
</tr>
</tbody>
</table>
Pour une compatibilité optimale avec toutes les options d’affichage, envisagez plutôt de copier le fichier dans Moodle.</div>';
$string['enablecoursegroup'] = 'Activer le dossier Groupes (cours) dans le sélecteur de fichiers';
$string['enabledirectlink'] = 'Activer l’option « {$a} »';
$string['enabledirectlink_help'] = 'Si cette case est cochée, les utilisateurs peuvent ajouter un lien direct vers un fichier de leur OneDrive au lieu de le copier dans Moodle. Le fichier reste dans OneDrive et Moodle ne stocke qu’un lien de référence.

**Points importants concernant le contrôle d’accès :**
* Les autorisations OneDrive existantes du fichier ne sont PAS modifiées.
* Les utilisateurs qui accèdent au lien doivent disposer des autorisations appropriées dans OneDrive pour consulter le fichier.
* Il incombe à l’utilisateur qui ajoute le lien de s’assurer que les autorisations d’accès sont correctes.
* Si les autorisations OneDrive ne sont pas correctement définies, les autres utilisateurs risquent de ne pas pouvoir accéder au fichier.

**Quand utiliser cette option :**
* Les fichiers sont déjà partagés avec le public visé dans Microsoft 365.
* Vous souhaitez conserver une source unique de référence dans OneDrive.
* L’espace de stockage dans Moodle est une préoccupation.
* Les modifications apportées au fichier OneDrive doivent être reflétées dans Moodle.

**Cette option est désactivée par défaut en raison de limitations d’affichage et de la complexité du contrôle d’accès. Ne cochez cette case que si vous souhaitez permettre aux utilisateurs de lier des fichiers directement depuis OneDrive.**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>Remarque :</strong> lors de l’utilisation de l’option « {$a} », aucun réglage de partage du fichier OneDrive n’est modifié. Les utilisateurs qui ajoutent le fichier doivent s’assurer que les autorisations du fichier dans OneDrive sont correctement définies.
<br><br><strong>Limitations d’affichage :</strong> les fichiers liés avec cette option présentent des limitations selon le type de fichier et l’option d’affichage utilisée dans les ressources. Le comportement varie comme suit :
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Option d’affichage</th>
<th>Images</th>
<th>Fichiers (par exemple .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatique</strong></td>
<td style="background-color: #ffdddd;">Ne fonctionne pas - rien n’est affiché, connexion bloquée</td>
<td>Redirection vers OneDrive ; fonctionne si l’utilisateur a l’autorisation d’accéder au fichier OneDrive, sinon une page d’autorisation refusée s’affiche</td>
</tr>
<tr>
<td><strong>Intégrer</strong></td>
<td style="background-color: #ffdddd;">Ne fonctionne pas - rien n’est affiché, connexion bloquée</td>
<td style="background-color: #ffdddd;">Ne fonctionne pas - une erreur de connexion refusée s’affiche dans l’iframe intégrée</td>
</tr>
<tr>
<td><strong>Forcer le téléchargement</strong></td>
<td colspan="2">Redirection vers OneDrive ; fonctionne si l’utilisateur a l’autorisation d’accéder au fichier OneDrive, sinon une page d’autorisation refusée s’affiche</td>
</tr>
<tr>
<td><strong>Ouvrir</strong></td>
<td colspan="2">Redirection vers OneDrive ; fonctionne si l’utilisateur a l’autorisation d’accéder au fichier OneDrive, sinon une page d’autorisation refusée s’affiche</td>
</tr>
<tr>
<td><strong>Dans une fenêtre surgissante</strong></td>
<td colspan="2">Ouverture dans une fenêtre surgissante ; fonctionne si l’utilisateur a l’autorisation d’accéder au fichier OneDrive, sinon une page d’autorisation refusée s’affiche</td>
</tr>
</tbody>
</table>
Pour une compatibilité optimale, envisagez de copier le fichier dans Moodle plutôt que d’utiliser un lien direct.</div>';
$string['enableinternal'] = 'Activer l’option « {$a} »';
$string['enableinternal_help'] = 'Si cette case est cochée (par défaut), les utilisateurs peuvent choisir de copier un fichier de OneDrive dans Moodle. Décochez-la et activez les options « Lien vers le fichier » et/ou « Créer un lien à accès contrôlé pour le fichier » ci-dessous pour obliger les utilisateurs à créer des liens vers les fichiers.

Au moins une des trois options de liaison de fichiers doit être activée.';
$string['enableonedrivegroup'] = 'Activer le dossier Mon OneDrive dans le sélecteur de fichiers';
$string['enabletrendinggroup'] = 'Activer le dossier Fichiers populaires autour de moi dans le sélecteur de fichiers';

$string['errorauthoidcnotconfig'] = 'Veuillez configurer le plugin d’authentification OpenID Connect avant d’essayer d’utiliser le dépôt Microsoft 365.';
$string['errorbadclienttype'] = 'Type de client non valide.';
$string['errorbadpath'] = 'Chemin incorrect';
$string['errorencodingreference'] = 'Échec de l’encodage de la référence du fichier';
$string['errornofilelinkoption'] = 'Au moins une option de liaison de fichiers doit être activée.';
$string['erroro365required'] = 'Ce fichier n’est actuellement disponible que pour les utilisateurs Microsoft 365.';
$string['errorwhiledownload'] = 'Une erreur est survenue lors du téléchargement du fichier';
$string['errorwhilesharing'] = 'Une erreur est survenue lors de la création d’un lien de partage';

$string['file'] = 'Fichier';
$string['filelinkingheader'] = 'Options de liaison de fichiers';
$string['filereferencewarning'] = 'Aucune modification de partage n’est apportée au fichier OneDrive. Seules les personnes ayant déjà accès au fichier dans OneDrive peuvent ouvrir ce lien.';
$string['groups'] = 'Groupes (cours)';
$string['invalidfilereference'] = 'Référence de fichier non valide ou mal formée';
$string['myfiles'] = 'Mon OneDrive';
$string['notconfigured'] = '<p class="error">Pour utiliser ce plugin, vous devez d’abord configurer les <a href="{$a}/admin/settings.php?section=local_o365">plugins Microsoft 365</a></p>';
$string['office365:view'] = 'Afficher le dépôt Microsoft 365';
$string['pluginname'] = 'Microsoft 365';
$string['privacy:metadata'] = 'Ce plugin communique avec l’API Microsoft Graph (OneDrive) au nom de l’utilisateur actuel. Tous les fichiers déposés seront envoyés au serveur distant.';
$string['trendingaround'] = 'Fichiers populaires autour de moi';
$string['upload'] = 'Déposer un nouveau fichier';
