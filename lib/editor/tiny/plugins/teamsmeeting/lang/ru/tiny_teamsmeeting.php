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
 * Strings for component 'tiny_teamsmeeting', language 'ru'.
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
$string['settings_meetings_app_link'] = 'URL-адрес приложения встреч';
$string['settings_meetings_app_link_desc'] = 'Это URL-адрес приложения встреч.';

// Capability.
$string['teamsmeeting:add'] = 'Добавить собрание Teams';

// IFrame.
$string['iframe_meeting_options'] = 'Параметры собрания';
$string['iframe_meeting_created'] = 'Собрание «{$a}» успешно создано!';
$string['iframe_meeting_details'] = 'Собрание «{$a}»';
$string['iframe_go_to_meeting'] = 'Перейти к собранию';
$string['iframe_add_link'] = 'Добавить ссылку';
$string['iframe_new_window_label'] = 'Открыть собрание в новом окне';
$string['iframe_not_found'] = 'Собрание не найдено';
$string['invalidtoken'] = 'Токен обратного вызова собрания отсутствует, недействителен или истёк. Закройте это окно и попробуйте создать собрание снова.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Создать собрание Teams';
$string['tiny_edit_modal_title'] = 'Собрание Teams';

// Privacy subsystem.
$string['privacy:metadata'] = 'Подключаемый модуль Tiny Teams Meeting сохраняет записи о собраниях, созданных пользователями, включая идентификатор пользователя и контекст, в котором было создано каждое собрание.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'Сведения о собраниях Teams, созданных с помощью редактора TinyMCE.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'Идентификатор пользователя, создавшего собрание.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Контекст, в котором было создано собрание.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Название собрания.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'URL-адрес для присоединения к собранию.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'URL-адрес страницы параметров собрания.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Время создания записи о собрании.';
$string['privacy:metadata:msteamsapp'] = 'Для создания собрания подключаемый модуль Tiny Teams Meeting обменивается данными с приложением собраний Microsoft Teams.';
$string['privacy:metadata:msteamsapp:courseid'] = 'Идентификатор курса, в котором создаётся собрание, отправляется в приложение собраний Microsoft Teams.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'URL-адрес этого сайта Moodle отправляется в приложение собраний Microsoft Teams, чтобы оно могло вернуть ссылку на собрание в нужное место.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Код языка пользователя отправляется в приложение собраний Microsoft Teams, чтобы его интерфейс соответствовал языку пользователя.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
