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
 * Strings for component 'tiny_teamsmeeting', language 'fr_ca'.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2026 Enovation Solutions
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Teams Meeting';

// Settings.
$string['settings_meetings_app_link'] = 'URL de l’application Réunions';
$string['settings_meetings_app_link_desc'] = 'Voici l’URL de l’application Réunions.';

// Capability.
$string['teamsmeeting:add'] = 'Ajouter une réunion Teams';

// IFrame.
$string['iframe_meeting_options'] = 'Options de la réunion';
$string['iframe_meeting_created'] = 'La réunion « {$a} » a été créée avec succès!';
$string['iframe_meeting_details'] = 'Réunion « {$a} »';
$string['iframe_go_to_meeting'] = 'Rejoindre la réunion';
$string['iframe_add_link'] = 'Ajouter le lien';
$string['iframe_new_window_label'] = 'Ouvrir la réunion dans une nouvelle fenêtre';
$string['iframe_not_found'] = 'Réunion introuvable';
$string['invalidtoken'] = 'Le jeton de rappel de la réunion est manquant, invalide ou expiré. Fermez cette fenêtre et essayez de créer la réunion à nouveau.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Créer une réunion Teams';
$string['tiny_edit_modal_title'] = 'Réunion Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'Le plugiciel Tiny Teams Meeting enregistre les réunions créées par les utilisateurs, y compris l’identifiant de l’utilisateur et le contexte dans lequel chaque réunion a été créée.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Détails des réunions Teams créées à partir de l’éditeur TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'L’identifiant de l’utilisateur qui a créé la réunion.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Le contexte dans lequel la réunion a été créée.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Le titre de la réunion.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'L’URL pour se joindre à la réunion.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'L’URL de la page des options de la réunion.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'La date et l’heure de création de l’enregistrement de la réunion.';
$string['privacy:metadata:msteamsapp'] = 'Afin de créer une réunion, le plugiciel Tiny Teams Meeting échange des données avec l’application de réunions Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'L’identifiant du cours dans lequel la réunion est créée est envoyé à l’application de réunions Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'L’URL de ce site Moodle est envoyée à l’application de réunions Microsoft Teams afin qu’elle puisse renvoyer le lien de la réunion au bon endroit.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Le code de langue de l’utilisateur est envoyé à l’application de réunions Microsoft Teams afin que son interface corresponde à la langue de l’utilisateur.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
