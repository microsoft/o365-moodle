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
 * Plugin local library.
 *
 * @package block_microsoft
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2021 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

use local_o365\feature\coursesync\utils;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/o365/lib.php');

// Regex used to validate the tenant-configured Viva Connections URL (typically the tenant's SharePoint home site).
// An empty value is also accepted, since the admin setting form is validated even while the link is disabled.
// Note: admin_setting_configtext only recognises a custom regex paramtype when it is delimited with literal
// forward slashes and has no trailing modifiers (see admin_setting::validate() in lib/adminlib.php), so the
// domain part is matched case-sensitively; URLs should be entered in lowercase.
define(
    'BLOCK_MICROSOFT_VIVACONNECTIONS_URL_REGEX',
    '/^$|^https:\/\/([a-zA-Z0-9-]+\.)*sharepoint\.(com|us|de|cn)(\/.*)?$/'
);

// Regex used to validate the tenant-configured Viva Learning URL.
// An empty value is also accepted, since the admin setting form is validated even while the link is disabled.
define(
    'BLOCK_MICROSOFT_VIVALEARNING_URL_REGEX',
    '/^$|^https:\/\/([a-zA-Z0-9-]+\.)*(viva\.microsoft\.com|cloud\.microsoft)(\/.*)?$/'
);

// Regex used to validate the tenant-configured Viva Amplify URL.
// An empty value is also accepted, since the admin setting form is validated even while the link is disabled.
define(
    'BLOCK_MICROSOFT_VIVAAMPLIFY_URL_REGEX',
    '/^$|^https:\/\/([a-zA-Z0-9-]+\.)*(amplify\.microsoft\.com|amplify\.cloud\.microsoft)(\/.*)?$/'
);

// File area holding the icons of the custom links. The item ID is the custom link ID.
define('BLOCK_MICROSOFT_CUSTOMLINKS_ICON_FILEAREA', 'customlinkicon');

/**
 * Return the course sync option of the course with the given ID.
 *
 * @param int $courseid
 *
 * @return int
 */
function block_microsoft_get_course_sync_option(int $courseid) {
    $coursesyncoption = MICROSOFT365_COURSE_SYNC_DISABLED;

    $syncenabledcourseids = utils::get_enabled_courses();

    if ($syncenabledcourseids === true) {
        // Sync is enabled on all courses.
        $coursesyncoption = MICROSOFT365_COURSE_SYNC_ENABLED;
    } else if (in_array($courseid, $syncenabledcourseids)) {
        $coursesyncoption = MICROSOFT365_COURSE_SYNC_ENABLED;
    }

    return $coursesyncoption;
}

/**
 * Set course sync options.
 *
 * @param int $courseid
 * @param int $syncsetting
 */
function block_microsoft_set_course_sync_option(int $courseid, int $syncsetting) {
    if ($syncsetting == MICROSOFT365_COURSE_SYNC_ENABLED) {
        utils::set_course_sync_enabled($courseid);
    } else {
        utils::set_course_sync_enabled($courseid, false);
    }
}

/**
 * Return the existing course reset setting of the course with the given ID.
 *
 * @param int $courseid
 *
 * @return string|null
 */
function block_microsoft_get_course_reset_setting(int $courseid) {
    $courseresetsettings = get_config('local_o365', 'courseresetsettings');
    $courseresetsettings = @json_decode($courseresetsettings, true);
    if (!empty($courseresetsettings) && is_array($courseresetsettings)) {
        if (isset($courseresetsettings[$courseid])) {
            return $courseresetsettings[$courseid];
        }
    }

    return null;
}

/**
 * Set course reset settings for the given course to the given value.
 *
 * @param int $courseid
 * @param string $resetsetting
 */
function block_microsoft_set_course_reset_setting(int $courseid, string $resetsetting) {
    $courseresetsettings = get_config('local_o365', 'courseresetsettings');
    $originalcourseresetsettings = $courseresetsettings;
    $courseresetsettings = @json_decode($courseresetsettings, true);
    if (empty($courseresetsettings) || !is_array($courseresetsettings)) {
        $courseresetsettings = [$courseid => $resetsetting];
    } else {
        $courseresetsettings[$courseid] = $resetsetting;
    }

    if ($originalcourseresetsettings != json_encode($courseresetsettings)) {
        add_to_config_log('courseresetsettings', $originalcourseresetsettings, json_encode($courseresetsettings), 'local_o365');
    }

    set_config('courseresetsettings', json_encode($courseresetsettings), 'local_o365');
}

/**
 * Build the shared header HTML for block_microsoft configuration pages: the plugin-wide heading, the Bootstrap
 * nav-tabs bar for navigating between the block configuration pages, and the page-specific subtitle, plus a style
 * tag hiding the surrounding Moodle breadcrumb and default page heading (which the plugin-wide heading and tab
 * bar replace). This mirrors local_o365_get_settings_nav_html() so that the configuration pages of both plugins
 * look the same.
 *
 * @param string $currentpage Key of the currently active tab: 'settings' or 'customlinks'.
 * @param string|null $subtitle Page-specific subtitle to print below the tab navigation. The settings page already
 *     opens with its own settings, so it leaves this null and prints no subtitle here.
 * @return string HTML for the configuration page header.
 */
function block_microsoft_get_settings_nav_html(string $currentpage, ?string $subtitle = null): string {
    $pages = [
        'settings' => [
            new moodle_url('/admin/settings.php', ['section' => 'blocksettingmicrosoft']),
            get_string('settings_header_general', 'block_microsoft'),
        ],
        'customlinks' => [
            new moodle_url('/blocks/microsoft/customlinks.php'),
            get_string('customlinks', 'block_microsoft'),
        ],
    ];

    // Hide the breadcrumb, Moodle's own page heading, and (on admin_settingpage forms) the settings form's own
    // "<h2>{$a->title}</h2>", a direct child of .settingsform printed by admin/templates/settings.mustache before
    // this nav html: the plugin-wide heading and tab bar below replace all of them.
    $html = html_writer::tag('style', '#page-navbar, .page-context-header, .settingsform > h2 { display: none; }');
    $pageheading = get_string('settings_pageheading', 'block_microsoft');
    $html .= html_writer::tag('h2', $pageheading);

    $html .= html_writer::start_tag('ul', ['class' => 'nav nav-tabs mb-3']);
    foreach ($pages as $key => [$url, $label]) {
        $linkattrs = ['class' => 'nav-link' . ($key === $currentpage ? ' active' : '')];
        $html .= html_writer::tag('li', html_writer::link($url, $label, $linkattrs), ['class' => 'nav-item']);
    }
    $html .= html_writer::end_tag('ul');

    if ($subtitle !== null) {
        $html .= html_writer::tag('h3', s($subtitle));
    }

    return $html;
}

/**
 * Return the file manager options of the custom link icons.
 *
 * @return array
 */
function block_microsoft_get_custom_link_icon_options(): array {
    return ['maxfiles' => 1, 'subdirs' => 0, 'accepted_types' => ['web_image']];
}

/**
 * Check whether a URL is acceptable for a custom link: an absolute http or https URL.
 *
 * @param string $url
 * @return bool
 */
function block_microsoft_is_valid_custom_link_url(string $url): bool {
    if (!preg_match('#^https?://[^\s/?\#]+#i', $url)) {
        return false;
    }

    return filter_var($url, FILTER_VALIDATE_URL) !== false && clean_param($url, PARAM_URL) === $url;
}

/**
 * Return the custom links as stored in the config, indexed by link ID.
 *
 * @return array[] Each link has the keys id, name, url, target and showall.
 */
function block_microsoft_get_stored_custom_links(): array {
    $links = [];
    $stored = json_decode((string) get_config('block_microsoft', 'customlinks'), true);
    if (!is_array($stored)) {
        return $links;
    }

    foreach ($stored as $link) {
        if (empty($link['id']) || !isset($link['name'], $link['url'])) {
            continue;
        }
        $links[(int) $link['id']] = [
            'id' => (int) $link['id'],
            'name' => (string) $link['name'],
            'url' => (string) $link['url'],
            'target' => ($link['target'] ?? '_blank') === '_self' ? '_self' : '_blank',
            // Links are only shown to connected users unless configured otherwise.
            'showall' => !empty($link['showall']),
        ];
    }

    return $links;
}

/**
 * Return the custom links to display in the block, including the URL of their icons.
 *
 * @return array[] Each link has the keys name, url, target, showall and iconurl (null if no icon was uploaded).
 */
function block_microsoft_get_custom_links(): array {
    $links = [];
    $systemcontextid = \core\context\system::instance()->id;
    $fs = get_file_storage();

    foreach (block_microsoft_get_stored_custom_links() as $link) {
        if (trim($link['name']) === '' || !block_microsoft_is_valid_custom_link_url($link['url'])) {
            continue;
        }

        $link['iconurl'] = null;
        $files = $fs->get_area_files(
            $systemcontextid,
            'block_microsoft',
            BLOCK_MICROSOFT_CUSTOMLINKS_ICON_FILEAREA,
            $link['id'],
            'itemid, filepath, filename',
            false
        );
        if ($file = reset($files)) {
            $link['iconurl'] = \core\url::make_pluginfile_url(
                $systemcontextid,
                'block_microsoft',
                BLOCK_MICROSOFT_CUSTOMLINKS_ICON_FILEAREA,
                $link['id'],
                $file->get_filepath(),
                $file->get_filename()
            )->out(false);
        }

        unset($link['id']);
        $links[] = $link;
    }

    return $links;
}

/**
 * Save the submitted custom links form data: store the links and their icons, and clean up removed links.
 *
 * @param stdClass $data Submitted form data.
 * @param array[] $storedlinks The links stored before this submission, indexed by link ID.
 * @param context $context System context.
 * @return bool False if there was nothing to save (no links submitted and none stored before), otherwise true.
 */
function block_microsoft_save_custom_links(stdClass $data, array $storedlinks, context $context): bool {
    $fs = get_file_storage();
    $nextid = $storedlinks ? max(array_keys($storedlinks)) + 1 : 1;
    $newlinks = [];

    foreach ($data->linkname as $i => $name) {
        $name = trim($name);
        $url = trim($data->linkurl[$i]);
        if (!empty($data->linkdelete[$i]) || ($name === '' && $url === '')) {
            continue;
        }

        $linkid = (int) $data->linkid[$i];
        if ($linkid <= 0 || !isset($storedlinks[$linkid])) {
            $linkid = $nextid++;
        }

        file_save_draft_area_files(
            $data->linkicon[$i],
            $context->id,
            'block_microsoft',
            BLOCK_MICROSOFT_CUSTOMLINKS_ICON_FILEAREA,
            $linkid,
            block_microsoft_get_custom_link_icon_options()
        );

        $newlinks[$linkid] = [
            'id' => $linkid,
            'name' => $name,
            'url' => $url,
            'target' => $data->linktarget[$i] === '_self' ? '_self' : '_blank',
            'showall' => !empty($data->linkshowall[$i]),
        ];
    }

    foreach (array_diff_key($storedlinks, $newlinks) as $removedid => $removed) {
        $fs->delete_area_files($context->id, 'block_microsoft', BLOCK_MICROSOFT_CUSTOMLINKS_ICON_FILEAREA, $removedid);
    }

    if (!$newlinks && !$storedlinks) {
        return false;
    }

    set_config('customlinks', json_encode(array_values($newlinks)), 'block_microsoft');

    return true;
}

/**
 * Serve the icon files of the custom links.
 *
 * @param stdClass $course
 * @param stdClass|null $birecord
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool False if the file was not found, otherwise the function does not return.
 */
function block_microsoft_pluginfile($course, $birecord, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel != CONTEXT_SYSTEM || $filearea !== BLOCK_MICROSOFT_CUSTOMLINKS_ICON_FILEAREA) {
        return false;
    }

    // The block is only shown to logged-in users, so the icons never need to be served anonymously.
    require_login();

    $itemid = (int) array_shift($args);
    $filename = array_pop($args);
    $filepath = $args ? '/' . implode('/', $args) . '/' : '/';

    $file = get_file_storage()->get_file($context->id, 'block_microsoft', $filearea, $itemid, $filepath, $filename);
    if (!$file || $file->is_directory()) {
        return false;
    }

    send_stored_file($file, null, 0, $forcedownload, $options);
}
