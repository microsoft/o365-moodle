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
 * Plugin library
 *
 * @package local_o365
 * @author  Remote-Learner.net Inc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/filestorage/zip_archive.php');

/**
 * TEAMS_MOODLE_APP_EXTERNAL_ID - app ID used to create Teams Moodle app.
 */
const TEAMS_MOODLE_APP_EXTERNAL_ID = '2e43119b-fcfe-44f8-b3e5-996ffcb7fb95';

// Teams/group course reset site settings.
const COURSE_SYNC_RESET_SITE_SETTING_DO_NOTHING = '1';
const COURSE_SYNC_RESET_SITE_SETTING_PER_COURSE = '2';
const COURSE_SYNC_RESET_SITE_SETTING_DISCONNECT_AND_CREATE_NEW = '3';
const COURSE_SYNC_RESET_SITE_SETTING_DISCONNECT_ONLY = '4';

// Course reset course settings.
const COURSE_SYNC_RESET_COURSE_SETTING_DO_NOTHING = '1';
const COURSE_SYNC_RESET_COURSE_SETTING_DISCONNECT_AND_CREATE_NEW = '2';
const COURSE_SYNC_RESET_COURSE_SETTING_DISCONNECT_ONLY = '3';

// Course sync options.
const MICROSOFT365_COURSE_SYNC_DISABLED = 0;
const MICROSOFT365_COURSE_SYNC_ENABLED = 1;

// Configuration tabs.
const LOCAL_O365_TAB_SETUP = 0; // Setup settings.
const LOCAL_O365_TAB_SYNC = 1; // Sync settings.
const LOCAL_O365_TAB_ADVANCED = 2; // Admin tools + advanced settings.
const LOCAL_O365_TAB_SDS = 3; // School data sync.
const LOCAL_O365_TAB_TEAMS = 5; // Teams integration settings.
const LOCAL_O365_TAB_MOODLE_APP = 6; // Teams Moodle app.

// Group roles.
const MICROSOFT365_GROUP_ROLE_OWNER = 'owner';
const MICROSOFT365_GROUP_ROLE_MEMBER = 'member';

// Team lock status.
const TEAM_LOCKED_STATUS_UNKNOWN = 0;
const TEAM_LOCKED = 1;
const TEAM_UNLOCKED = 2;

// Education license.
const EDUCATION_LICENSE_IDS = ['c33802dd-1b50-4b9a-8bb9-f13d2cdeadac', '500b6a2a-7a50-4f40-b5f9-160e5b8c2f48'];

// SDS sync school disabled actions.
const SDS_SCHOOL_DISABLED_ACTION_KEEP_CONNECTED = 1;
const SDS_SCHOOL_DISABLED_ACTION_DISCONNECT = 2;

// Course user sync directions.
const COURSE_USER_SYNC_DIRECTION_MOODLE_TO_TEAMS = 1;
const COURSE_USER_SYNC_DIRECTION_TEAMS_TO_MOODLE = 2;
const COURSE_USER_SYNC_DIRECTION_BOTH = 3;

/**
 * Check for link connection capabilities.
 *
 * @param int $userid Moodle user id to check permissions for.
 * @param string $mode Mode to check
 *                     'link' to check for connect specific capability
 *                     'unlink' to check for disconnect capability.
 * @param boolean $require Use require_capability rather than has_capability.
 *
 * @return boolean True if has capability.
 */
function local_o365_connectioncapability($userid, $mode = 'link', $require = false) {
    $check = $require ? 'require_capability' : 'has_capability';
    $cap = ($mode == 'link') ? 'local/o365:manageconnectionlink' : 'local/o365:manageconnectionunlink';
    $contextsys = \context_system::instance();
    $contextuser = \context_user::instance($userid);

    return has_capability($cap, $contextsys) || $check($cap, $contextuser);
}

/**
 * Recursively delete content of the folder and all its contents.
 *
 * @param string $path Path to the deleted
 */
function local_o365_rmdir($path) {
    $it = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it,
        RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file) {
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    rmdir($path);
}

/**
 * Attempt to create manifest file. Return error details and/or path to the manifest file.
 *
 * @return string[]
 */
function local_o365_create_manifest_file() : array {
    global $CFG;

    $error = '';

    // Task 1: prepare manifest folder.
    $pathtomanifestfolder = $CFG->dataroot . '/temp/ms_teams_manifest';
    if (file_exists($pathtomanifestfolder)) {
        local_o365_rmdir($pathtomanifestfolder);
    }
    mkdir($pathtomanifestfolder, 0777, true);

    // Task 2: prepare manifest params.
    $teamsmoodleappexternalid = get_config('local_o365', 'teams_moodle_app_external_id');
    if (!$teamsmoodleappexternalid) {
        $teamsmoodleappexternalid = TEAMS_MOODLE_APP_EXTERNAL_ID;
    }

    $teamsmoodleappnameshortname = get_config('local_o365', 'teams_moodle_app_short_name');
    if (!$teamsmoodleappnameshortname) {
        $teamsmoodleappnameshortname = 'Moodle';
    }

    // Task 3: prepare manifest file.
    $manifest = [
        '$schema' => 'https://developer.microsoft.com/en-us/json-schemas/teams/v1.7/MicrosoftTeams.schema.json',
        'manifestVersion' => '1.7',
        'version' => '1.4',
        'id' => $teamsmoodleappexternalid,
        'packageName' => 'ie.enovation.microsoft.o365',
        'developer' => [
            'name' => 'Enovation Solutions',
            'websiteUrl' => 'https://enovation.ie',
            'privacyUrl' => 'https://enovation.ie/moodleteamsapp-privacy',
            'termsOfUseUrl' => 'https://enovation.ie/moodleteamsapp-termsofuse',
            'mpnId' => '1718735',
        ],
        'icons' => [
            'color' => 'color.png',
            'outline' => 'outline.png',
        ],
        'name' => [
            'short' => $teamsmoodleappnameshortname,
            'full' => 'Moodle integration with Microsoft Teams for ' . $CFG->wwwroot,
        ],
        'description' => [
            'short' => 'Access your Moodle courses and ask questions to your Moodle Assistant in Teams.',
            'full' => 'The Moodle app for Microsoft Teams allows you to easily access and collaborate around your Moodle ' .
                'courses from within your teams through tabs.',
        ],
        'accentColor' => '#FF7A00',
        'configurableTabs' => [
            [
                'configurationUrl' => $CFG->wwwroot . '/local/o365/teams_tab_configuration.php',
                'canUpdateConfiguration' => false,
                'scopes' => [
                    'team',
                ],
            ],
        ],
        'permissions' => [
            'identity',
            'messageTeamMembers',
        ],
        'validDomains' => [
            parse_url($CFG->wwwroot, PHP_URL_HOST),
        ],
        'webApplicationInfo' => [
            'id' => get_config('auth_oidc', 'clientid'),
            'resource' => 'api://' . preg_replace("(^https?://)", "", $CFG->wwwroot) . '/' . get_config('auth_oidc', 'clientid'),
        ],
    ];

    $file = $pathtomanifestfolder . '/manifest.json';
    file_put_contents($file, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    // Task 5: prepare icons.
    copy($CFG->dirroot . '/local/o365/pix/color.png', $pathtomanifestfolder . '/color.png');
    copy($CFG->dirroot . '/local/o365/pix/outline.png', $pathtomanifestfolder . '/outline.png');

    // Task 6: compress the folder.
    $ziparchive = new zip_archive();
    $zipfilename = $pathtomanifestfolder . '/manifest.zip';
    $ziparchive->open($zipfilename);
    $filenames = ['manifest.json', 'color.png', 'outline.png'];
    foreach ($filenames as $filename) {
        $ziparchive->add_file_from_pathname($filename, $pathtomanifestfolder . '/' . $filename);
    }
    $ziparchive->close();

    return [$errorcode, $zipfilename];
}

/**
 * Decodes JWT token elements
 *
 * @param string $data - encoded string
 *
 * @return string - decoded string
 */
function local_o365_base64urldecode($data) {
    $urlunsafedata = strtr($data, '-_', '+/');
    $paddeddata = str_pad($urlunsafedata, strlen($data) % 4, '=', STR_PAD_RIGHT);

    return base64_decode($paddeddata);
}

/**
 * Determine if "Teams Moodle app ID" tab needs to appear.
 *
 * @return bool
 */
function local_o365_show_teams_moodle_app_id_tab() {
    return (get_config('local_o365', 'manifest_downloaded'));
}

/**
 * Attempt to get authorization token from request header.
 *
 * @return false|string|null
 */
function local_o365_get_auth_token() {
    global $_SERVER;

    $authtoken = null;

    if (function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authtoken = substr($headers['Authorization'], 7);
        }
    }

    if (!$authtoken) {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authtoken = substr($_SERVER['HTTP_AUTHORIZATION'], 7);
        }
    }

    return $authtoken;
}

/**
 * Check if the suspension feature schedule in the user sync task has been set, and set the default value if not.
 *
 * @return void
 */
function local_o365_set_default_user_sync_suspension_feature_schedule() {
    if (get_config('local_o365', 'usersync_suspension_h') === false) {
        add_to_config_log('usersync_suspension_h', null, 2, 'local_o365');
        set_config('usersync_suspension_h', 2, 'local_o365');
    }
    if (get_config('local_o365', 'usersync_suspension_m') === false) {
        add_to_config_log('usersync_suspension_m', null, 30, 'local_o365');
        set_config('usersync_suspension_m', 30, 'local_o365');
    }
}

/**
 * Return all active users' duplicate email addresses.
 *
 * @return array
 */
function local_o365_get_duplicate_emails() {
    global $DB;
    
    $sql = 'SELECT LOWER(email) FROM {user}
        WHERE deleted = 0 and suspended = 0
        GROUP BY LOWER(email) HAVING COUNT(*) > 1';

    $records = $DB->get_records_sql($sql);
    return array_keys($records);
}
