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
 * Strings for component 'tiny_teamsmeeting', language 'tr'.
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
$string['settings_meetings_app_link'] = 'Toplantılar uygulamasının URL adresi';
$string['settings_meetings_app_link_desc'] = 'Bu, Toplantılar uygulamasının URL adresidir.';

// Capability.
$string['teamsmeeting:add'] = 'Teams toplantısı ekle';

// IFrame.
$string['iframe_meeting_options'] = 'Toplantı seçenekleri';
$string['iframe_meeting_created'] = '"{$a}" toplantısı başarıyla oluşturuldu!';
$string['iframe_meeting_details'] = '"{$a}" toplantısı';
$string['iframe_go_to_meeting'] = 'Toplantıya git';
$string['iframe_add_link'] = 'Bağlantı ekle';
$string['iframe_new_window_label'] = 'Toplantıyı yeni bir pencerede aç';
$string['iframe_not_found'] = 'Toplantı bulunamadı';
$string['invalidtoken'] = 'Toplantı geri çağırma belirteci eksik, geçersiz veya süresi dolmuş. Bu pencereyi kapatın ve toplantıyı yeniden oluşturmayı deneyin.';

// TinyMCE strings.
$string['tiny_modal_title'] = 'Teams toplantısı oluştur';
$string['tiny_edit_modal_title'] = 'Teams toplantısı';

// Privacy subsystem.
$string['privacy:metadata'] = 'Tiny Teams Meeting eklentisi, kullanıcı kimliği ve her toplantının oluşturulduğu bağlam da dahil olmak üzere, kullanıcılar tarafından oluşturulan toplantı kayıtlarını depolar.';
$string['privacy:metadata:tiny_teamsmeeting'] = 'TinyMCE düzenleyicisi aracılığıyla oluşturulan Teams toplantılarının ayrıntıları.';
$string['privacy:metadata:tiny_teamsmeeting:userid'] = 'Toplantıyı oluşturan kullanıcının kimliği.';
$string['privacy:metadata:tiny_teamsmeeting:contextid'] = 'Toplantının oluşturulduğu bağlam.';
$string['privacy:metadata:tiny_teamsmeeting:title'] = 'Toplantının başlığı.';
$string['privacy:metadata:tiny_teamsmeeting:link'] = 'Toplantıya katılım URL adresi.';
$string['privacy:metadata:tiny_teamsmeeting:options'] = 'Toplantı seçenekleri sayfasının URL adresi.';
$string['privacy:metadata:tiny_teamsmeeting:timecreated'] = 'Toplantı kaydının oluşturulduğu zaman.';
$string['privacy:metadata:msteamsapp'] = 'Bir toplantı oluşturmak için Tiny Teams Meeting eklentisi, Microsoft Teams toplantı uygulamasıyla veri alışverişinde bulunur.';
$string['privacy:metadata:msteamsapp:courseid'] = 'Toplantının oluşturulduğu kursun kimliği Microsoft Teams toplantı uygulamasına gönderilir.';
$string['privacy:metadata:msteamsapp:moodleurl'] = 'Bu Moodle sitesinin URL adresi, toplantı bağlantısını doğru konuma döndürebilmesi için Microsoft Teams toplantı uygulamasına gönderilir.';
$string['privacy:metadata:msteamsapp:userlang'] = 'Kullanıcının dil kodu, kullanıcı arabiriminin kullanıcının diliyle eşleşmesi için Microsoft Teams toplantı uygulamasına gönderilir.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
