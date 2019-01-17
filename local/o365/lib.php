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
 * @package local_o365
 * @author  Remote-Learner.net Inc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

/**
 * Retrieve icon image and send to the browser for display.
 *
 * @param object $course Course object.
 * @param object $cm Course module object.
 * @param object $context Context.
 * @param string $filearea File area, icon or description.
 * @param array $args Array of arguments passed.
 * @param boolean $forcedownload True if download should be fored.
 * @param array $options Array of options.
 */
function local_o365_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB;
    // Check the contextlevel is as expected - if your plugin is a block, this becomes CONTEXT_BLOCK, etc.
    if ($context->contextlevel != CONTEXT_COURSE) {
        return false;
    }

    // Make sure the filearea is one of those used by the plugin.
    if ($filearea !== 'icon' && $filearea !== 'description') {
        return false;
    }

    // Make sure the user is logged in and has access to the module (plugins that are not course modules should leave out the 'cm' part).
    require_login($course, true, $cm);

    // Item id is the office 365 group id in local_o365_coursegroupdata.
    $itemid = array_shift($args); // The first item in the $args array.

    // Extract the filename / filepath from the $args array.
    $filename = array_pop($args); // The last item in the $args array.
    if (!$args) {
        $filepath = '/'; // $args is empty => the path is '/'
    } else {
        $filepath = '/'.implode('/', $args).'/'; // $args contains elements of the filepath
    }

    // Retrieve the file from the Files API.
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_o365', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        // The file does not exist.
        return false;
    }

    send_stored_file($file, null, 0, $forcedownload, $options);
}

/**
 * Check for link connection capabilities.
 *
 * @param int $userid Moodle user id to check permissions for.
 * @param string $mode Mode to check
 *                     'link' to check for connect specific capability
 *                     'unlink' to check for disconnect capability.
 * @param boolean $require Use require_capability rather than has_capability.
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
 * @param $path
 */
function local_o365_rmdir($path) {
    $it = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it,
        RecursiveIteratorIterator::CHILD_FIRST);
    foreach($files as $file) {
        if ($file->isDir()){
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    rmdir($path);
}

/**
 * Create manifest file and return its contents in string.
 *
 * @return false|string
 * @throws coding_exception
 * @throws dml_exception
 */
function local_o365_get_manifest_file_content() {
    $filecontent = '';

    $manifestfilepath = local_o365_create_manifest_file();

    if ($manifestfilepath) {
        $filecontent = file_get_contents($manifestfilepath);
    }

    return $filecontent;
}

/**
 * Attempt to create manifest file. Return error details and/or path to the manifest file.
 *
 * @return string
 * @throws coding_exception
 * @throws dml_exception
 */
function local_o365_create_manifest_file() {
    global $CFG;
    require_once($CFG->libdir . '/filestorage/zip_archive.php');

    $error = '';
    $zipfilename = '';

    // Task 1: check if bot settings are consistent.
    $botappid = get_config('local_o365', 'bot_app_id');
    $botfeatureenabled = get_config('local_o365', 'bot_feature_enabled');
    if ($botfeatureenabled) {
        if (!$botappid || $botappid == '00000000-0000-0000-0000-000000000000') {
            // bot id not configured, cannot create manifest file
            $error = get_string('error_missing_app_id', 'local_o365');
            return [$error, $zipfilename];
        }

        $botapppassword = get_config('local_o365', 'bot_app_password');
        $botwebhookendpoint = get_config('local_o365', 'bot_webhook_endpoint');
        if (!$botapppassword || !$botwebhookendpoint) {
            $error = get_string('error_missing_bot_settings', 'local_o365');
            return [$error, $zipfilename];
        }
    }

    // Task 2: prepare manifest folder.
    $pathtomanifestfolder = $CFG->dataroot . '/temp/ms_teams_manifest';
    if (file_exists($pathtomanifestfolder)) {
        local_o365_rmdir($pathtomanifestfolder);
    }
    mkdir($pathtomanifestfolder, 0777, true);

    // Task 3: prepare manifest file.
    $manifest = array(
        '$schema' => 'https://developer.microsoft.com/en-us/json-schemas/teams/v1.3/MicrosoftTeams.schema.json',
        'manifestVersion' => '1.3',
        'version' => '1.2.1',
        'id' => '2e43119b-fcfe-44f8-b3e5-996ffcb7fb95',
        'packageName' => 'ie.enovation.microsoft.o365',
        'developer' => array(
            'name' => 'Enovation Solutions',
            'websiteUrl' => 'https://enovation.ie',
            'privacyUrl' => 'https://enovation.ie/moodleteamsapp-privacy',
            'termsOfUseUrl' => 'https://enovation.ie/moodleteamsapp-termsofuse',
        ),
        'icons' => array(
            'color' => 'color.png',
            'outline' => 'outline.png',
        ),
        'name' => array(
            'short' => 'Moodle',
            'full' => 'Moodle integration with Microsoft Teams',
        ),
        'description' => array(
            'short' => 'Access your Moodle courses and ask questions to your Moodle Assistant in Teams.',
            'full' => 'The Moodle app for Microsoft Teams allows you to easily access and collaborate around your Moodle courses from within your teams through tabs. You can also get regular notifications from Moodle and ask questions about your courses, assignments, grades and students using the Moodle Assistant bot.',
        ),
        'accentColor' => '#FF7A00',
        'configurableTabs' => array(
            array(
                'configurationUrl' => $CFG->wwwroot . '/local/o365/teams_tab_configuration.php',
                'canUpdateConfiguration' => false,
                'scopes' => array(
                    'team',
                ),
            ),
        ),
        'permissions' => array(
            'identity',
            'messageTeamMembers',
        ),
        'validDomains' => array(
            parse_url($CFG->wwwroot, PHP_URL_HOST),
            'token.botframework.com',
        ),
    );

    // Task 4: add bot part to manifest if enabled.
    if ($botfeatureenabled) {
        $manifest['bots'] = array(
            array(
                'botId' => $botappid,
                'needsChannelSelector' => false,
                'isNotificationOnly' => false,
                'scopes' => array(
                    'team',
                    'personal',
                ),
                'commandLists' => array(
                    array(
                        'scopes' => array(
                            'team',
                            'personal',
                        ),
                        'commands' => array(
                            array(
                                'title' => 'Help',
                                'description' => 'Displays help dialog'
                            ),
                            array(
                                'title' => 'Feedback',
                                'description' => 'Displays feedback dialog'
                            ),
                        ),
                    ),
                ),
            ),
        );
    }

    $file = $pathtomanifestfolder . '/manifest.json';
    file_put_contents($file, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    // Task 5: prepare icons.
    copy($CFG->dirroot . '/local/o365/pix/color.png', $pathtomanifestfolder . '/color.png');
    copy($CFG->dirroot . '/local/o365/pix/outline.png', $pathtomanifestfolder . '/outline.png');

    // Task 6: compress the folder.
    $ziparchive = new zip_archive();
    $zipfilename = $pathtomanifestfolder . '/manifest.zip';
    $ziparchive->open($zipfilename);
    $filenames = array('manifest.json', 'color.png', 'outline.png');
    foreach ($filenames as $filename) {
        $ziparchive->add_file_from_pathname($filename, $pathtomanifestfolder . '/' . $filename);
    }
    $ziparchive->close();

    return [$error, $zipfilename];
}

/**
 * Decodes JWT token elements
 *
 * @param string $data - encoded string
 * @return string - decoded string
 */
function base64UrlDecode($data){
    $urlUnsafeData = strtr($data, '-_', '+/');
    $paddedData = str_pad($urlUnsafeData, strlen($data) % 4, '=', STR_PAD_RIGHT);
    return base64_decode($paddedData);
}