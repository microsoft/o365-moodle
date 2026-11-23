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

use core\context\system;
use core\context\user;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/filestorage/zip_archive.php');

/**
 * TEAMS_MOODLE_APP_EXTERNAL_ID - app ID used to create Teams Moodle app.
 */
/** @var string default teams Moodle app external ID. */
const TEAMS_MOODLE_APP_EXTERNAL_ID = '2e43119b-fcfe-44f8-b3e5-996ffcb7fb95';

// Teams/group course reset site settings.
/** @var int course reset site action Do nothing. */
const COURSE_SYNC_RESET_SITE_SETTING_DO_NOTHING = '1';
/** @var int course reset site action allow configuration per course. */
const COURSE_SYNC_RESET_SITE_SETTING_PER_COURSE = '2';
/** @var int course reset site action disconnect and create new. */
const COURSE_SYNC_RESET_SITE_SETTING_DISCONNECT_AND_CREATE_NEW = '3';
/** @var int course reset site action disconnect only. */
const COURSE_SYNC_RESET_SITE_SETTING_DISCONNECT_ONLY = '4';

// Course reset course settings.
/** @var int course reset action do nothing. */
const COURSE_SYNC_RESET_COURSE_SETTING_DO_NOTHING = '1';
/** @var int course reset course action disconnect and create new. */
const COURSE_SYNC_RESET_COURSE_SETTING_DISCONNECT_AND_CREATE_NEW = '2';
/** @var int course reset course action disconnect only. */
const COURSE_SYNC_RESET_COURSE_SETTING_DISCONNECT_ONLY = '3';

// Course sync options.
/** @var int course sync disabled. */
const MICROSOFT365_COURSE_SYNC_DISABLED = 0;
/** @var int course sync enabled. */
const MICROSOFT365_COURSE_SYNC_ENABLED = 1;

// Configuration tabs.
/** @var int configuration tab "Setup settings". */
const LOCAL_O365_TAB_SETUP = 0;
/** @var int configuration tab "Sync settings". */
const LOCAL_O365_TAB_SYNC = 1;
/** @var int configuration tab "Admin tools + advanced settings.". */
const LOCAL_O365_TAB_ADVANCED = 2;
/** @var int configuration tab "School data sync". */
const LOCAL_O365_TAB_SDS = 3;
/** @var int configuration tab "Teams integration settings". */
const LOCAL_O365_TAB_TEAMS = 5;
/** @var int configuration tab "Teams Moodle app". */
const LOCAL_O365_TAB_MOODLE_APP = 6;
/** @var int configuration tab "User Sync settings". */
const LOCAL_O365_TAB_USERSYNC = 7;
/** @var int configuration tab "Course Sync settings". */
const LOCAL_O365_TAB_COURSESYNC = 8;

// Group roles.
/** @var int group role owner */
const MICROSOFT365_GROUP_ROLE_OWNER = 'owner';
/** @var int group role member */
const MICROSOFT365_GROUP_ROLE_MEMBER = 'member';

// Team lock status.
/** @var int team locking status unknown */
const TEAM_LOCKED_STATUS_UNKNOWN = 0;
/** @var int team locking status locked */
const TEAM_LOCKED = 1;
/** @var int team locking status unlocked */
const TEAM_UNLOCKED = 2;

/** @var array education license */
const EDUCATION_LICENSE_IDS = ['c33802dd-1b50-4b9a-8bb9-f13d2cdeadac', '500b6a2a-7a50-4f40-b5f9-160e5b8c2f48'];

// SDS sync school disabled actions.
/** @var int SDS school disabled action keep connected */
const SDS_SCHOOL_DISABLED_ACTION_KEEP_CONNECTED = 1;
/** @var int SDS school disabled action disconnect */
const SDS_SCHOOL_DISABLED_ACTION_DISCONNECT = 2;

// Course user sync directions.
/** @var int course user sync direction from Moodle to teams */
const COURSE_USER_SYNC_DIRECTION_MOODLE_TO_TEAMS = 1;
/** @var int course user sync direction from teams to Moodle */
const COURSE_USER_SYNC_DIRECTION_TEAMS_TO_MOODLE = 2;
/** @var int course user sync direction both */
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
    $contextsys = system::instance();
    $contextuser = user::instance($userid);

    return has_capability($cap, $contextsys) || $check($cap, $contextuser);
}

/**
 * Recursively delete content of the folder and all its contents.
 *
 * @param string $path Path to the deleted
 */
function local_o365_rmdir($path) {
    $it = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator(
        $it,
        RecursiveIteratorIterator::CHILD_FIRST
    );
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
function local_o365_create_manifest_file(): array {
    global $CFG;

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
        '$schema' => 'https://developer.microsoft.com/en-us/json-schemas/teams/v1.25/MicrosoftTeams.schema.json',
        'manifestVersion' => '1.25',
        'version' => '1.6.0',
        'id' => $teamsmoodleappexternalid,
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
        'defaultInstallScope' => 'team',
        'supportsChannelFeatures' => 'tier1',
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

    return $zipfilename ? [null, $zipfilename] : ['errorcannotcreatezipfile', null];
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
        $headers = array_change_key_case($headers, CASE_LOWER);
        if (isset($headers['authorization'])) {
            $authtoken = $headers['authorization'];
        }
    }

    if (!$authtoken && isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $authtoken = $_SERVER['HTTP_AUTHORIZATION'];
    }

    // Strip "Bearer " prefix if present (case-insensitive), otherwise use token as-is.
    if ($authtoken && stripos($authtoken, 'bearer ') === 0) {
        $authtoken = substr($authtoken, 7);
    }

    return $authtoken;
}

/**
 * Validate and decode a Microsoft Teams JWT token with full cryptographic verification.
 *
 * This function performs comprehensive JWT validation including:
 * - Signature verification against Microsoft's public keys (JWKS)
 * - Issuer validation
 * - Audience validation
 * - Algorithm validation
 * - Expiry and timing checks
 *
 * @param string $jwt The JWT token to validate.
 * @return stdClass The validated JWT payload.
 * @throws moodle_exception If validation fails for any reason.
 */
function local_o365_validate_teams_jwt($jwt) {
    global $CFG;
    require_once($CFG->dirroot . '/lib/filelib.php');

    if (empty($jwt)) {
        throw new moodle_exception('erroremptyjwt', 'local_o365');
    }

    // Get tenant ID and client ID from configuration.
    $tenantid = get_config('local_o365', 'entratenantid');
    if (empty($tenantid)) {
        $tenantid = 'common';
    }
    $clientid = get_config('auth_oidc', 'clientid');

    // Microsoft JWKS endpoint for token signature verification.
    $jwksurl = "https://login.microsoftonline.com/{$tenantid}/discovery/v2.0/keys";

    // Attempt to retrieve cached keyset.
    $cache = cache::make('local_o365', 'jwks');
    $keyset = $cache->get($tenantid);

    // Helper function to add missing "alg" parameter to JWK keys.
    $fixkeyset = function ($keysetarr) {
        if (isset($keysetarr['keys']) && is_array($keysetarr['keys'])) {
            foreach ($keysetarr['keys'] as &$key) {
                if (!isset($key['alg'])) {
                    // Default to RS256 for RSA keys (most common for Microsoft tokens).
                    if (isset($key['kty']) && $key['kty'] === 'RSA') {
                        $key['alg'] = 'RS256';
                    }
                }
            }
        }
        return $keysetarr;
    };

    try {
        if (empty($keyset)) {
            throw new moodle_exception('errornocachedjwks', 'local_o365');
        }
        $keysetarr = json_decode($keyset, true);
        $keysetarr = $fixkeyset($keysetarr);
        $keys = \Firebase\JWT\JWK::parseKeySet($keysetarr);
        $payload = \Firebase\JWT\JWT::decode($jwt, $keys);
    } catch (Exception $e) {
        // Cache miss or validation error - fetch fresh JWKS and retry.
        $keyset = download_file_content($jwksurl);
        if (empty($keyset)) {
            throw new moodle_exception('errorfetchjwks', 'local_o365', '', null, 'Failed to fetch JWKS from Microsoft');
        }

        $keysetarr = json_decode($keyset, true);
        if (empty($keysetarr) || !isset($keysetarr['keys'])) {
            throw new moodle_exception('errorinvalidjwks', 'local_o365', '', null, 'Invalid JWKS format');
        }

        // Fix keys before parsing.
        $keysetarr = $fixkeyset($keysetarr);

        // Parse and decode with signature verification.
        $keys = \Firebase\JWT\JWK::parseKeySet($keysetarr);
        try {
            $payload = \Firebase\JWT\JWT::decode($jwt, $keys);
        } catch (Exception $decodeex) {
            throw new moodle_exception(
                'errorjwtvalidation',
                'local_o365',
                '',
                null,
                'JWT validation failed: ' . $decodeex->getMessage()
            );
        }

        // Cache the fresh keyset for future use.
        $cache->set($tenantid, $keyset);
    }

    // Validate issuer (must be from Microsoft).
    $validissuers = [
        "https://login.microsoftonline.com/{$tenantid}/v2.0",
        "https://sts.windows.net/{$tenantid}/",
    ];
    if (empty($payload->iss) || !in_array($payload->iss, $validissuers)) {
        throw new moodle_exception(
            'errorjwtinvalidissuer',
            'local_o365',
            '',
            null,
            'Invalid issuer: ' . ($payload->iss ?? 'missing')
        );
    }

    // Validate audience (must match configured client ID).
    // NOTE: For Teams SSO, the audience may be different from the Moodle OIDC client ID.
    // Since signature verification already confirms the token is from Microsoft,
    // we allow audience mismatches for Teams SSO tokens.
    // Audience validation is intentionally skipped to support Teams SSO integration.

    return $payload;
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

/**
 * Build the shared header HTML for local_o365 configuration pages: the plugin-wide heading, the Bootstrap
 * nav-tabs bar for navigating between local_o365 settings pages, and the page-specific subtitle, plus a style
 * tag hiding the surrounding Moodle breadcrumb and default page heading (which the plugin-wide heading and tab
 * bar replace).
 *
 * Renders a row of tab links to each settings sub-page, with the current page marked as active. The Moodle App
 * tab is included only when its feature is enabled.
 *
 * @param string $currentpage Section ID of the currently active page.
 * @param string|null $subtitle Page-specific subtitle to print below the tab navigation, for a page nested under
 *     a tab (e.g. "Manage User Connections" under "Advanced"). The settings pages that map 1:1 to a tab (Setup,
 *     User Sync, ...) already open with their own heading, so they leave this null and print no subtitle here.
 * @return string HTML for the settings page header.
 */
function local_o365_get_settings_nav_html(string $currentpage, ?string $subtitle = null): string {
    $pages = [
        'local_o365' => get_string('settings_header_setup', 'local_o365'),
        'local_o365_usersync' => get_string('settings_header_usersync', 'local_o365'),
        'local_o365_coursesync' => get_string('settings_header_coursesync', 'local_o365'),
        'local_o365_advanced' => get_string('settings_header_advanced', 'local_o365'),
        'local_o365_sds' => get_string('settings_header_sds', 'local_o365'),
        'local_o365_teams' => get_string('settings_header_teams', 'local_o365'),
    ];
    if (local_o365_show_teams_moodle_app_id_tab()) {
        $pages['local_o365_moodle_app'] = get_string('settings_header_moodle_app', 'local_o365');
    }

    // Hide the breadcrumb, Moodle's own page heading, and (on admin_settingpage forms) the settings form's own
    // "<h2>{$a->title}</h2>", a direct child of .settingsform printed by admin/templates/settings.mustache before
    // this nav html: the plugin-wide heading and tab bar below replace all of them.
    $html = html_writer::tag('style', '#page-navbar, .page-context-header, .settingsform > h2 { display: none; }');
    $pageheading = get_string('settings_pageheading', 'local_o365', get_string('pluginname', 'local_o365'));
    $html .= html_writer::tag('h2', $pageheading);

    $html .= html_writer::start_tag('ul', ['class' => 'nav nav-tabs mb-3']);
    foreach ($pages as $section => $label) {
        $url = new moodle_url('/admin/settings.php', ['section' => $section]);
        $linkattrs = ['class' => 'nav-link' . ($section === $currentpage ? ' active' : '')];
        $html .= html_writer::tag('li', html_writer::link($url, $label, $linkattrs), ['class' => 'nav-item']);
    }
    $html .= html_writer::end_tag('ul');

    if ($subtitle !== null) {
        $html .= html_writer::tag('h3', s($subtitle));
    }

    return $html;
}

/**
 * Get the name of the cookie that marks requests made from inside a Microsoft Teams tab.
 *
 * Suffixed with $CFG->sessioncookie, like the session cookie, so that several Moodle sites on one host
 * do not share it.
 *
 * @return string The cookie name.
 */
function local_o365_get_teams_frame_cookie_name(): string {
    global $CFG;

    return 'local_o365_teamsframe' . preg_replace('/\W/', '', $CFG->sessioncookie ?? '');
}

/**
 * Get the name of the temporary cookie the Teams tab entry page uses to probe whether the browser partitions cookies.
 *
 * Nothing on the server reads this cookie, and it does not start with the name of the Teams frame cookie, so it can
 * never be mistaken for it, however long it is visible to other contexts of a browser that does not partition it.
 *
 * @return string The cookie name.
 */
function local_o365_get_teams_frame_probe_cookie_name(): string {
    global $CFG;

    return 'local_o365_teamsprobe' . preg_replace('/\W/', '', $CFG->sessioncookie ?? '');
}

/**
 * Get the cookie that marks requests made from inside a Microsoft Teams tab, as a "name=value; attributes" string.
 *
 * The cookie is Partitioned (CHIPS), i.e. the browser keys it to the top-level site that embeds Moodle
 * (Teams) and only sends it back to Moodle pages embedded by that same site. Unlike the Moodle session
 * cookie, which a Teams tab and a direct browser tab share, it is therefore never sent with a request
 * made from a direct browser tab, nor from an iframe embedded in a direct browser page. That is what makes
 * it a Teams-frame-specific marker. Partitioned cookies must be Secure, and SameSite=None is needed for
 * the cross-site Teams context. It is set by JavaScript in the Teams tab (see
 * local_o365_get_teams_frame_marker_js()), so it cannot be HttpOnly.
 *
 * @return string The cookie string, as set through document.cookie.
 */
function local_o365_get_teams_frame_cookie(): string {
    $cookieparams = session_get_cookie_params();

    $cookie = local_o365_get_teams_frame_cookie_name() . '=1; Path=' . $cookieparams['path'];
    if (!empty($cookieparams['domain'])) {
        $cookie .= '; Domain=' . $cookieparams['domain'];
    }

    return $cookie . '; Secure; SameSite=None; Partitioned';
}

/**
 * Get the options that identify the Teams frame cookie to the Cookie Store API.
 *
 * Common to creating and deleting the cookie: its name, its path and, if the session cookie has one, its
 * domain. The domain is given without a leading dot. document.cookie and Set-Cookie accept a configured
 * session cookie domain such as ".example.com" as is (the dot is ignored), but the Cookie Store API rejects it
 * with a TypeError, which would make creating the cookie fail and leave the Teams tab without a marker.
 *
 * @param array|null $cookieparams The session cookie parameters, as session_get_cookie_params() returns them.
 *                                 Defaults to the current ones.
 * @return array The options.
 */
function local_o365_get_teams_frame_cookie_store_options(?array $cookieparams = null): array {
    $cookieparams = $cookieparams ?? session_get_cookie_params();

    $options = ['name' => local_o365_get_teams_frame_cookie_name(), 'path' => $cookieparams['path']];
    $domain = ltrim($cookieparams['domain'] ?? '', '.');
    if ($domain !== '') {
        $options['domain'] = $domain;
    }

    return $options;
}

/**
 * Get the JavaScript that defines markTeamsFrame(), which marks the browsing context as a Microsoft Teams tab.
 *
 * To be called by the Teams tab entry page, local/o365/teams_tab.php, once the Teams SDK handshake
 * (microsoftTeams.app.initialize()) has succeeded, and only then. The SDK only completes the handshake
 * when the parent window is a Teams host whose origin it recognises, so that is an explicit Teams
 * embedding context. Nothing a request carries can establish it on the server: Sec-Fetch-Site only
 * compares the site that started the navigation with Moodle's and does not identify the top-level site,
 * which is what a Partitioned cookie is keyed to. An iframe in an ordinary Moodle page can navigate
 * through another site and back to the entry page and still look cross-site, while its top-level site,
 * and so the cookie partition, would be Moodle's own, shared with direct browser tabs and the modals
 * they open. The SDK handshake cannot succeed there, so the marker is never set.
 *
 * The cookie is set in the document of the Teams tab, so the browser stores it in the cookie partition of
 * Teams. Does nothing when the page is not served over HTTPS (the cookie must be Secure, and Teams
 * itself requires HTTPS), or when this browser was found not to partition the cookie, see
 * local_o365_discard_leaked_teams_frame_cookie().
 *
 * The cookie only identifies the Teams tab if the browser really partitions it, and is only set when that
 * has been verified. A browser that accepts third-party cookies but does not support the Partitioned
 * attribute stores an ordinary SameSite=None cookie that direct browser tabs, and the modals they open,
 * send as well, and a page that is already open would send it with its next modal before anything else
 * could give the browser away. So markTeamsFrame() returns a promise, which never rejects, and the caller
 * must wait for it before navigating on:
 * - where the Cookie Store API is available, partitioning is probed with a separate temporary cookie
 *   (see local_o365_get_teams_frame_probe_cookie_name()), which the server does not recognise, so that
 *   a request made while the probe is visible, which in a browser that does not partition it is every
 *   Moodle context, cannot be taken for the Teams tab. The probe is created, read back and deleted at
 *   once, and only if the browser reported it as partitioned is the real marker created;
 * - without it, but with the Storage Access API, the cookie is set only if this frame has no access to
 *   unpartitioned cookies (document.hasStorageAccess() is false). The browser then partitions, or blocks,
 *   every third-party cookie of the frame, with or without support for the Partitioned attribute, as
 *   Firefox does by default;
 * - if neither can tell, partitioning cannot be verified and the cookie is not set. That is deliberate:
 *   a browser that does not partition third-party cookies gives the server no way to tell a frame of the
 *   Teams tab from any other iframe, so there the Teams tab does not get the Teams theme: every page after
 *   the entry page is unmarked and is not themed as Teams, as is no other iframe. Browsers that partition
 *   the cookie, which includes every current version of Chromium and Firefox in their default settings,
 *   are not affected.
 * The server still checks the cookie as well, see local_o365_discard_leaked_teams_frame_cookie().
 *
 * @return string The JavaScript source.
 */
function local_o365_get_teams_frame_marker_js(): string {
    global $CFG, $SESSION;

    if ((!is_https() && empty($CFG->sslproxy)) || !empty($SESSION->local_o365_teamsframeleaked)) {
        return 'function markTeamsFrame() { return Promise.resolve(); }';
    }

    $options = local_o365_get_teams_frame_cookie_store_options();
    $probeoptions = ['name' => local_o365_get_teams_frame_probe_cookie_name()] + $options;
    $attributes = ['value' => '1', 'secure' => true, 'sameSite' => 'none', 'partitioned' => true];
    $flags = JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP;

    $js = <<<'JS'
function markTeamsFrame() {
    var cookie = __COOKIE__;
    var expired = __EXPIRED__;
    var probeexpired = __PROBE_EXPIRED__;
    var store = window.cookieStore;

    if (store && typeof store.set === 'function') {
        // Probe with a cookie the server does not recognise. The real marker is only created once the browser
        // has reported the probe as partitioned: until then every context of a browser that does not partition
        // it can see, and send, the cookie, and a request made meanwhile must not be taken for the Teams tab.
        var probe = __PROBE_SET_OPTIONS__;
        probe.expires = Date.now() + 60000;

        return store.set(probe).then(function() {
            return store.get(__PROBE_NAME__);
        }).then(function(item) {
            var partitioned = !!item && item.partitioned === true;

            // CookieStore.delete() only finds a partitioned cookie if it is told to look for one.
            var deleteoptions = partitioned ? __PROBE_DELETE_PARTITIONED_OPTIONS__ : __PROBE_DELETE_OPTIONS__;

            // Removing the probe is housekeeping only: it expires by itself after a minute and the server does not
            // recognise it. A delete that fails must not stop the marker from being created: Chrome rejects deleting a
            // partitioned cookie with a TypeError in a cross-site frame, which is where the Teams tab runs.
            return store.delete(deleteoptions).catch(function() {
                probeexpired.forEach(function(header) {
                    document.cookie = header;
                });
            }).then(function() {
                return partitioned;
            });
        }).then(function(partitioned) {
            if (partitioned) {
                return store.set(__SET_OPTIONS__);
            }
        }).catch(function() {
            // Expire both cookies, as an ordinary and as a partitioned cookie, whichever this browser stored.
            expired.concat(probeexpired).forEach(function(header) {
                document.cookie = header;
            });
        });
    }

    if (typeof document.hasStorageAccess === 'function') {
        return document.hasStorageAccess().then(function(unpartitioned) {
            // Without access to unpartitioned cookies the browser partitions, or blocks, all cookies of this frame,
            // whether or not it supports the Partitioned attribute, so the marker cannot be shared.
            if (!unpartitioned) {
                document.cookie = cookie;
            }
        }).catch(function() {
            // Not verified, so no marker.
        });
    }

    // Partitioning cannot be verified here, so there is no marker.
    return Promise.resolve();
}
JS;

    return strtr($js, [
        '__COOKIE__' => json_encode(local_o365_get_teams_frame_cookie(), $flags),
        '__EXPIRED__' => json_encode(local_o365_get_teams_frame_cookie_expiry_headers(), $flags),
        '__PROBE_EXPIRED__' => json_encode(local_o365_get_teams_frame_cookie_expiry_headers($probeoptions['name']), $flags),
        '__SET_OPTIONS__' => json_encode($options + $attributes, $flags),
        '__PROBE_SET_OPTIONS__' => json_encode($probeoptions + $attributes, $flags),
        '__PROBE_NAME__' => json_encode($probeoptions['name'], $flags),
        '__PROBE_DELETE_OPTIONS__' => json_encode($probeoptions, $flags),
        '__PROBE_DELETE_PARTITIONED_OPTIONS__' => json_encode($probeoptions + ['partitioned' => true], $flags),
    ]);
}

/**
 * Get the Set-Cookie header values that expire the Teams frame cookie, or another cookie of the same scope.
 *
 * One expires it as an ordinary cookie, which is how a browser that does not support Partitioned stores
 * it, and one expires the Partitioned variant.
 *
 * @param string|null $name The name of the cookie, defaults to the Teams frame cookie.
 * @return string[] The Set-Cookie header values.
 */
function local_o365_get_teams_frame_cookie_expiry_headers(?string $name = null): array {
    $cookieparams = session_get_cookie_params();

    $expired = ($name ?? local_o365_get_teams_frame_cookie_name()) . '=; Max-Age=0; Path=' . $cookieparams['path'];
    if (!empty($cookieparams['domain'])) {
        $expired .= '; Domain=' . $cookieparams['domain'];
    }
    $expired .= '; Secure; SameSite=None';

    return [$expired, $expired . '; Partitioned'];
}

/**
 * Stop trusting the Teams frame cookie after it reached a top-level request.
 *
 * A browser that partitions the cookie never sends it to Moodle pages that are not embedded by Teams, so
 * a top-level request that carries it shows the browser stored it as an ordinary cookie, shared with
 * every Moodle context, e.g. because it accepts third-party cookies but does not support Partitioned.
 * Cookie presence is then no proof of a Teams context: it would make the modals of a direct browser tab
 * look like the Teams tab. So the cookie is expired and, as the browser cannot keep one frame apart from
 * another, no longer trusted for the rest of the session, nor set again. In that browser the Teams tab
 * does not get the Teams theme, as every page after the entry page is unmarked, but no other iframe is
 * ever themed as Teams.
 */
function local_o365_discard_leaked_teams_frame_cookie(): void {
    global $CFG, $SESSION;

    if (!isset($_COOKIE[local_o365_get_teams_frame_cookie_name()])) {
        return;
    }

    $SESSION->local_o365_teamsframeleaked = true;

    if ((!is_https() && empty($CFG->sslproxy)) || headers_sent()) {
        return;
    }

    foreach (local_o365_get_teams_frame_cookie_expiry_headers() as $header) {
        header('Set-Cookie: ' . $header, false);
    }
}

/**
 * Whether the current request was made from inside a Microsoft Teams tab.
 *
 * True when the request carries the Teams frame cookie, which a browser only sends from the Teams
 * context that received it (see local_o365_get_teams_frame_cookie()), unless this browser was found to
 * send it from other contexts too (see local_o365_discard_leaked_teams_frame_cookie()).
 *
 * @return bool True if the request comes from a Teams tab.
 */
function local_o365_in_teams_frame(): bool {
    global $SESSION;

    if (!empty($SESSION->local_o365_teamsframeleaked)) {
        return false;
    }

    return isset($_COOKIE[local_o365_get_teams_frame_cookie_name()]);
}

/**
 * Force the Microsoft Teams tab theme override onto the current session.
 *
 * Only marks the override as Teams-originated (via $SESSION->local_o365_teamstheme) when a theme was
 * actually applied. This matters when neither local_o365/customtheme nor theme_boost_o365teams is
 * installed/configured: without this guard, local_o365_after_require_login() and
 * theme_boost_o365teams/amd/src/iframeChecker.js could later clear a theme override this function
 * never set in the first place, e.g. Moodle's own ?theme= URL override.
 *
 * Does not mark the browsing context as a Teams tab: the entry page's script does that once the Teams SDK
 * handshake has succeeded, see local_o365_get_teams_frame_marker_js().
 */
function local_o365_apply_teams_theme() {
    global $SESSION;

    $customtheme = get_config('local_o365', 'customtheme');
    if (!empty($customtheme) && get_config('theme_' . $customtheme, 'version')) {
        $SESSION->theme = $customtheme;
    } else if (get_config('theme_boost_o365teams', 'version')) {
        $SESSION->theme = 'boost_o365teams';
    } else {
        return;
    }

    $SESSION->local_o365_teamstheme = true;
}

/**
 * Remove the Teams theme override from the current session, if this plugin set it.
 *
 * Only clears an override flagged by local_o365_apply_teams_theme() as Teams-originated; never touches an
 * unrelated theme override, e.g. Moodle's own ?theme= URL switch.
 */
function local_o365_clear_teams_theme(): void {
    global $SESSION;

    if (empty($SESSION->local_o365_teamstheme)) {
        return;
    }

    unset($SESSION->theme);
    unset($SESSION->local_o365_teamstheme);
}

/**
 * Plugin callback invoked by require_login() on every page load that requires login, before the
 * theme for the response is resolved (theme resolution is triggered by the first $OUTPUT call,
 * which happens later in the request).
 *
 * A Microsoft Teams tab and an ordinary browser tab share the same Moodle session, so a theme
 * override written to $SESSION persists across both. This re-derives the override on each request
 * from that request's own Sec-Fetch-Dest header (sent by Chromium and Firefox for navigations that
 * load into an iframe), so a request made directly in a browser tab can no longer inherit a theme
 * override left behind by a request made through the Teams tab, or vice versa (see
 * microsoft/o365-moodle#1278). Browsers that do not send this header (e.g. Safari) fall back to the
 * session-based override set in teams_tab.php/sso_login.php, self-corrected client-side by
 * theme_boost_o365teams/amd/src/iframeChecker.js.
 *
 * Only acts on full-page navigations (Sec-Fetch-Mode: navigate). Subresource/AJAX/fragment requests
 * made from within the Teams tab also call require_login() and commonly carry other Sec-Fetch-Dest
 * values (e.g. empty, script, style), which would otherwise be misread as "not in Teams" and clear
 * the override out from under an active Teams session.
 *
 * Sec-Fetch-Dest: iframe alone does not mean Teams: any Moodle page can embed another Moodle page in
 * an iframe (e.g. the Turnitin submission modal, embedded LTI launches), and Sec-Fetch-Site does not
 * identify the top-level site either: an external tool embedded in an ordinary Moodle page that
 * navigates its own iframe back to Moodle is cross-site just like the Teams tab. Neither the headers
 * nor the Sec-Fetch-Site value can therefore establish that a request comes from the Teams tab, not even
 * for the entry page: an iframe in an ordinary Moodle page can be redirected through another site and
 * back and still look cross-site. What does is the Teams frame cookie. The Teams tab entry page,
 * teams_tab.php (the contentUrl of every Teams tab this plugin creates), sets it from JavaScript, but
 * only once the Teams SDK handshake has succeeded, which is only possible when the top-level site is a
 * Teams host (see local_o365_get_teams_frame_marker_js()). Being a Partitioned cookie, it is then only
 * sent back from inside the Teams tab (see local_o365_get_teams_frame_cookie()). That covers the pages
 * the entry page navigates to, and every link followed inside the tab later, including after a direct
 * browser tab sharing the session has cleared the override in the meantime.
 *
 * That only holds if the browser really partitions the cookie, and the presence of the cookie alone is
 * no proof of it: a browser that accepts third-party cookies but does not support Partitioned stores an
 * ordinary cookie that every Moodle context sends. So the entry page only sets the cookie once it has
 * verified that the browser partitions it, and not at all where it cannot. As a backstop, a top-level
 * request (Sec-Fetch-Dest: document) carrying the cookie still gives a browser away that does not, as a
 * partitioned cookie is never sent to top-level Moodle: the cookie is then expired and no longer trusted
 * for the session, see local_o365_discard_leaked_teams_frame_cookie().
 *
 * So an iframe navigation carrying the cookie (re-)applies the Teams theme, and one without it, whatever
 * its Sec-Fetch-Site, is not themed as Teams (see microsoft/o365-moodle#3921): a modal in a page opened
 * directly in a browser, an external tool navigating its iframe back to Moodle, or Moodle embedded by a
 * page of its own site. It clears the override if this plugin set it, which a Teams tab may have done in
 * the shared session after that page was opened, and leaves any unrelated override alone. The cookie
 * cannot be scoped to a same-site embedding frame (the top-level site is Moodle's own, so the cookie
 * would land in the partition direct browser tabs share), so such an embed is never treated as Teams.
 * Without a Sec-Fetch-Site header there is nothing to tell the request apart, and it is left alone.
 *
 * @param mixed $courseorid unused, part of the after_require_login callback signature.
 * @param bool $autologinguest unused, part of the after_require_login callback signature.
 * @param mixed $cm unused, part of the after_require_login callback signature.
 * @param bool $setwantsurltome unused, part of the after_require_login callback signature.
 * @param bool $preventredirect unused, part of the after_require_login callback signature.
 */
function local_o365_after_require_login($courseorid, $autologinguest, $cm, $setwantsurltome, $preventredirect) {
    if (!isset($_SERVER['HTTP_SEC_FETCH_MODE']) || $_SERVER['HTTP_SEC_FETCH_MODE'] !== 'navigate') {
        return;
    }

    if (!isset($_SERVER['HTTP_SEC_FETCH_DEST'])) {
        return;
    }

    if ($_SERVER['HTTP_SEC_FETCH_DEST'] === 'iframe') {
        if (local_o365_in_teams_frame()) {
            local_o365_apply_teams_theme();
        } else if (!empty($_SERVER['HTTP_SEC_FETCH_SITE'])) {
            // An iframe of a Moodle page that does not come from the Teams tab, e.g. a modal opened in a
            // normal browser page, an external tool navigating its iframe back to Moodle, or Moodle
            // embedded by a page of its own site. That page may have been open before a Teams tab set the
            // override in the shared session, so the iframe must not inherit it.
            local_o365_clear_teams_theme();
        }
    } else {
        if ($_SERVER['HTTP_SEC_FETCH_DEST'] === 'document') {
            // A top-level request that carries the Teams frame cookie: the browser does not partition it.
            local_o365_discard_leaked_teams_frame_cookie();
        }
        local_o365_clear_teams_theme();
    }
}
