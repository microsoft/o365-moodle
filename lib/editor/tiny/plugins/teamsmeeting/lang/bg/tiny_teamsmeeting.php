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
 * Strings for component 'tiny_teamsmeeting', language 'bg'.
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
$string['settings_meetings_app_link'] = 'URL адрес на приложението за срещи';
$string['settings_meetings_app_link_desc'] = 'Това е URL адресът на приложението за срещи.';

// Capability.
$string['teamsmeeting:add'] = 'Добавяне на среща в Teams';

// IFrame.
$string['iframe_meeting_options'] = 'Опции на срещата';
$string['iframe_meeting_created'] = 'Срещата „{$a}“ беше създадена успешно!';
$string['iframe_meeting_details'] = 'Среща „{$a}“';
$string['iframe_go_to_meeting'] = 'Отиване към срещата';
$string['iframe_add_link'] = 'Добавяне на връзка';
$string['iframe_new_window_label'] = 'Отваряне на срещата в нов прозорец';
$string['iframe_not_found'] = 'Срещата не е намерена';
$string['invalidtoken'] = 'Токенът за обратно извикване на срещата липсва, невалиден е или е изтекъл. Затворете това прозорче и опитайте да създадете срещата отново.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Създаване на среща в Teams';
$string['tiny_edit_modal_title'] = 'Среща в Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'Приставката Tiny Teams Meeting съхранява записи за срещи, създадени от потребителите, включително идентификатора на потребителя и контекста, в който е създадена всяка среща.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Подробности за срещите в Teams, създадени чрез редактора TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'Идентификаторът на потребителя, който е създал срещата.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Контекстът, в който е създадена срещата.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Заглавието на срещата.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'URL адресът за присъединяване към срещата.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'URL адресът на страницата с опции на срещата.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Времето, в което е създаден записът за срещата.';
$string['privacy:metadata:msteamsapp'] = 'За да се създаде среща, приставката Tiny Teams Meeting обменя данни с приложението за срещи на Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'Идентификаторът на курса, в който се създава срещата, се изпраща на приложението за срещи на Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'URL адресът на този сайт на Moodle се изпраща на приложението за срещи на Microsoft Teams, за да може то да върне връзката към срещата на правилното място.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Кодът на езика на потребителя се изпраща на приложението за срещи на Microsoft Teams, за да съответства неговият потребителски интерфейс на езика на потребителя.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
