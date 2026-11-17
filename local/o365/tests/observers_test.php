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
 * Test cases for observer functions.
 *
 * @package local_o365
 * @author Remote-Learner.net Inc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365;

use advanced_testcase;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/auth/oidc/lib.php');

/**
 * Tests event observers.
 *
 * @group local_o365
 * @group office365
 */
final class observers_test extends advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test users disconnect method.
     *
     * @covers \local_o365\observers::handle_oidc_user_disconnected
     */
    public function test_user_disconnected(): void {
        $user = $this->getDataGenerator()->create_user(['auth' => 'oidc']);
        $this->create_member_entities($user->id);
        $this->assertTrue($this->has_member_entities($user->id));
        $eventdata = ['objectid' => $user->id, 'userid' => $user->id];
        $event = \auth_oidc\event\user_disconnected::create($eventdata);
        $event->trigger();
        $this->assertFalse($this->has_member_entities($user->id));
    }

    /**
     * Test users deleted method.
     *
     * @covers \local_o365\observers::handle_user_deleted
     */
    public function test_user_deleted(): void {
        $user = $this->getDataGenerator()->create_user(['auth' => 'oidc']);
        $this->create_member_entities($user->id);
        $this->assertTrue($this->has_member_entities($user->id));
        delete_user($user);
        $this->assertFalse($this->has_member_entities($user->id));
    }

    /**
     * Data provider for test_verifysetup_results_cleared_when_setting_updated().
     *
     * @return array
     */
    public static function verifysetup_setting_provider(): array {
        $settings = [];
        foreach (AUTH_OIDC_VERIFYSETUP_SETTINGS as $name) {
            $settings['auth_oidc ' . $name] = ['auth_oidc', $name, true];
        }

        // The application token is requested from the tenant's endpoint, so it is cleared when the tenant changes.
        $settings['local_o365 entratenant'] = ['local_o365', 'entratenant', true];
        $settings['local_o365 entratenantid'] = ['local_o365', 'entratenantid', true];

        // Only the verify setup results are cleared for this, because the application token is still valid.
        $settings['local_o365 coursesyncgroupchannels'] = ['local_o365', 'coursesyncgroupchannels', false];

        return $settings;
    }

    /**
     * Test the verify setup results are cleared when a setting they depend on is updated.
     *
     * @dataProvider verifysetup_setting_provider
     * @covers \local_o365\observers::handle_config_log_created
     * @param string $plugin The plugin of the setting.
     * @param string $name The name of the setting.
     * @param bool $clearsapptokens Whether the application tokens are cleared too.
     */
    public function test_verifysetup_results_cleared_when_setting_updated(
        string $plugin,
        string $name,
        bool $clearsapptokens
    ): void {
        $this->set_connected();

        add_to_config_log($name, 'old', 'new', $plugin);

        $this->assertEmpty(get_config('local_o365', 'verifysetupresult'));
        if ($clearsapptokens) {
            $this->assertEmpty(get_config('local_o365', 'apptokens'));
        } else {
            $this->assertNotEmpty(get_config('local_o365', 'apptokens'));
        }
    }

    /**
     * Data provider for test_verifysetup_results_kept_when_other_setting_updated().
     *
     * @return array
     */
    public static function verifysetup_unrelated_setting_provider(): array {
        return [
            'auth_oidc customclaims' => ['auth_oidc', 'customclaims'],
            'auth_oidc secretexpiryrecipients' => ['auth_oidc', 'secretexpiryrecipients'],
            'local_o365 odburl' => ['local_o365', 'odburl'],
            'local_o365 usersync' => ['local_o365', 'usersync'],
        ];
    }

    /**
     * Test the verify setup results are kept when a setting they don't depend on is updated.
     *
     * @dataProvider verifysetup_unrelated_setting_provider
     * @covers \local_o365\observers::handle_config_log_created
     * @param string $plugin The plugin of the setting.
     * @param string $name The name of the setting.
     */
    public function test_verifysetup_results_kept_when_other_setting_updated(string $plugin, string $name): void {
        $this->set_connected();

        add_to_config_log($name, 'old', 'new', $plugin);

        $this->assertNotEmpty(get_config('local_o365', 'verifysetupresult'));
        $this->assertNotEmpty(get_config('local_o365', 'apptokens'));
    }

    /**
     * Data provider for test_verifysetup_results_and_tokens_for_clientcertsource_update().
     *
     * @return array
     */
    public static function clientcertsource_update_provider(): array {
        return [
            'default initialisation, from false' => [false, AUTH_OIDC_AUTH_CERT_SOURCE_TEXT, false],
            'default initialisation, from null' => [null, AUTH_OIDC_AUTH_CERT_SOURCE_TEXT, false],
            'default initialisation, from empty string' => ['', AUTH_OIDC_AUTH_CERT_SOURCE_TEXT, false],
            'missing to file' => [false, AUTH_OIDC_AUTH_CERT_SOURCE_FILE, true],
            'text to file' => [AUTH_OIDC_AUTH_CERT_SOURCE_TEXT, AUTH_OIDC_AUTH_CERT_SOURCE_FILE, true],
            'file to text' => [AUTH_OIDC_AUTH_CERT_SOURCE_FILE, AUTH_OIDC_AUTH_CERT_SOURCE_TEXT, true],
        ];
    }

    /**
     * Test the application tokens and verify setup results are kept when a missing certificate source is initialised to the
     * default, and cleared when the certificate source is changed.
     *
     * @dataProvider clientcertsource_update_provider
     * @covers \local_o365\observers::handle_config_log_created
     * @param mixed $oldvalue The previous value of the certificate source.
     * @param int $newvalue The new value of the certificate source.
     * @param bool $invalidated Whether the application tokens and verify setup results are cleared.
     */
    public function test_verifysetup_results_and_tokens_for_clientcertsource_update(
        mixed $oldvalue,
        int $newvalue,
        bool $invalidated
    ): void {
        $this->set_connected();

        add_to_config_log('clientcertsource', $oldvalue, $newvalue, 'auth_oidc');

        if ($invalidated) {
            $this->assertEmpty(get_config('local_o365', 'verifysetupresult'));
            $this->assertEmpty(get_config('local_o365', 'apptokens'));
        } else {
            $this->assertNotEmpty(get_config('local_o365', 'verifysetupresult'));
            $this->assertNotEmpty(get_config('local_o365', 'apptokens'));
        }
    }

    /**
     * Test the application tokens and verify setup results are cleared for each updated setting, but the caches are only purged
     * once, at the end of the request.
     *
     * @covers \local_o365\observers::handle_config_log_created
     */
    public function test_cache_purge_scheduled_once_when_multiple_settings_updated(): void {
        foreach (['clientid', 'clientsecret', 'tokenendpoint'] as $name) {
            $this->set_connected();

            add_to_config_log($name, 'old', 'new', 'auth_oidc');

            $this->assertEmpty(get_config('local_o365', 'verifysetupresult'));
            $this->assertEmpty(get_config('local_o365', 'apptokens'));
        }

        // The purge is scheduled as a shutdown function only once per request, however many settings were updated.
        $callbacks = (new \ReflectionClass(\core_shutdown_manager::class))->getProperty('callbacks')->getValue();
        $purges = array_filter($callbacks, fn($callback) => $callback[0] === 'purge_all_caches');
        $this->assertCount(1, $purges);
    }

    /**
     * Test the site is only connected to Microsoft Graph with a stored application token or cached verify setup results.
     *
     * @covers ::auth_oidc_is_graph_api_connected
     */
    public function test_is_graph_api_connected(): void {
        $this->assertFalse(auth_oidc_is_graph_api_connected());

        // An empty list of application tokens isn't a token.
        set_config('apptokens', serialize([]), 'local_o365');
        $this->assertFalse(auth_oidc_is_graph_api_connected());

        set_config('apptokens', serialize(['https://graph.microsoft.com' => ['token' => 'token']]), 'local_o365');
        $this->assertTrue(auth_oidc_is_graph_api_connected());

        unset_config('apptokens', 'local_o365');
        $this->assertFalse(auth_oidc_is_graph_api_connected());

        set_config('verifysetupresult', serialize((object) ['unifiedapi' => (object) ['active' => true]]), 'local_o365');
        $this->assertTrue(auth_oidc_is_graph_api_connected());
    }

    /**
     * Test the site admin is asked to verify the setup again after saving an admin setting, if the site was connected.
     *
     * @covers \local_o365\observers::handle_config_log_created
     * @covers ::auth_oidc_request_verifysetup
     */
    public function test_verifysetup_requested_when_saving_admin_settings(): void {
        global $PAGE, $SESSION;

        $this->set_connected();
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        $PAGE->set_url('/admin/settings.php', ['section' => 'local_o365_coursesync']);
        $_POST['action'] = 'save-settings';

        add_to_config_log('coursesyncgroupchannels', '0', '1', 'local_o365');

        $this->assertNotEmpty($SESSION->auth_oidc_verifysetuprequested);
    }

    /**
     * Test the site admin isn't asked to verify the setup again if the site wasn't connected.
     *
     * @covers \local_o365\observers::handle_config_log_created
     * @covers ::auth_oidc_request_verifysetup
     */
    public function test_verifysetup_not_requested_when_site_not_connected(): void {
        global $PAGE, $SESSION;

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        $PAGE->set_url('/admin/settings.php', ['section' => 'local_o365_coursesync']);
        $_POST['action'] = 'save-settings';

        add_to_config_log('coursesyncgroupchannels', '0', '1', 'local_o365');

        $this->assertEmpty($SESSION->auth_oidc_verifysetuprequested ?? null);
    }

    /**
     * Test the site admin isn't asked to verify the setup again when the setting isn't saved on an admin settings page.
     *
     * @covers \local_o365\observers::handle_config_log_created
     * @covers ::auth_oidc_request_verifysetup
     */
    public function test_verifysetup_not_requested_outside_admin_settings(): void {
        global $PAGE, $SESSION;

        $this->set_connected();
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        $PAGE->set_url('/auth/oidc/manageapplication.php');
        $_POST['action'] = 'save-settings';

        add_to_config_log('clientid', 'old', 'new', 'auth_oidc');

        $this->assertEmpty($SESSION->auth_oidc_verifysetuprequested ?? null);
    }

    /**
     * Test the site admin isn't asked to verify the setup again when the IdP isn't a Microsoft one.
     *
     * @covers \local_o365\observers::handle_config_log_created
     * @covers ::auth_oidc_request_verifysetup
     */
    public function test_verifysetup_not_requested_for_other_idp(): void {
        global $PAGE, $SESSION;

        $this->set_connected();
        set_config('idptype', AUTH_OIDC_IDP_TYPE_OTHER, 'auth_oidc');
        $PAGE->set_url('/admin/settings.php', ['section' => 'authsettingoidc']);
        $_POST['action'] = 'save-settings';

        add_to_config_log('idptype', '1', '3', 'auth_oidc');

        $this->assertEmpty($SESSION->auth_oidc_verifysetuprequested ?? null);
    }

    /**
     * Test the site admin is redirected to the verify setup page when it was requested.
     *
     * @covers ::auth_oidc_redirect_to_verifysetup
     */
    public function test_redirect_to_verifysetup(): void {
        global $PAGE, $SESSION;

        $SESSION->auth_oidc_verifysetuprequested = true;
        $PAGE->set_url('/admin/settings.php', ['section' => 'local_o365_coursesync']);

        try {
            auth_oidc_redirect_to_verifysetup();
            $this->fail('Expected a redirect to the verify setup page.');
        } catch (\moodle_exception $e) {
            // Redirects aren't supported in unit tests, and are reported with this exception.
            $this->assertEquals('redirecterrordetected', $e->errorcode);
        }

        $this->assertEmpty($SESSION->auth_oidc_verifysetuprequested ?? null);
    }

    /**
     * Test the site admin isn't redirected when already on the verify setup page, or when nothing was requested.
     *
     * @covers ::auth_oidc_redirect_to_verifysetup
     */
    public function test_no_redirect_to_verifysetup_when_not_needed(): void {
        global $PAGE, $SESSION;

        // Already on the verify setup page.
        $SESSION->auth_oidc_verifysetuprequested = true;
        $PAGE->set_url('/admin/settings.php', ['section' => 'local_o365']);
        auth_oidc_redirect_to_verifysetup();
        $this->assertEmpty($SESSION->auth_oidc_verifysetuprequested ?? null);

        // Nothing was requested.
        $PAGE->set_url('/admin/settings.php', ['section' => 'local_o365_coursesync']);
        auth_oidc_redirect_to_verifysetup();

        // Not an admin settings page, so the request is kept for when one is loaded.
        $SESSION->auth_oidc_verifysetuprequested = true;
        $PAGE->set_url('/auth/oidc/manageapplication.php');
        auth_oidc_redirect_to_verifysetup();
        $this->assertTrue($SESSION->auth_oidc_verifysetuprequested);
    }

    /**
     * Store an application token and verify setup results, as a site connected to Microsoft Graph has.
     */
    private function set_connected(): void {
        set_config('apptokens', serialize(['https://graph.microsoft.com' => ['token' => 'token']]), 'local_o365');
        set_config('verifysetupresult', serialize((object) ['unifiedapi' => (object) ['active' => true]]), 'local_o365');
    }

    /**
     * Create Microsoft 365 entities.
     *
     * @param int $userid
     */
    public function create_member_entities($userid) {
        global $DB;
        $token = (object) [
            'user_id' => $userid,
            'scope' => 'scope',
            'tokenresource' => 'resource',
            'token' => rand() * 1000,
            'expiry' => time() + 1000000,
            'refreshtoken' => time() + 100000,
        ];
        $DB->insert_record('local_o365_token', $token);
        $entraiduserdata = (object) [
            'type' => 'user',
            'subtype' => '',
            'objectid' => '',
            'moodleid' => $userid,
            'o365name' => 'test@example.onmicrosoft.com',
            'timecreated' => time(),
            'timemodified' => time(),
        ];
        $DB->insert_record('local_o365_objects', $entraiduserdata);
        $DB->insert_record('local_o365_connections', ['muserid' => $userid]);
        $object = (object) [
            'muserid' => $userid,
            'assigned' => 1,
            'photoid' => 'abc',
            'photoupdated' => 1,
        ];
        $DB->insert_record('local_o365_appassign', $object);
    }

    /**
     * Test if user has any entities.
     *
     * @param int $userid User id to check for Microsoft 365 entities.
     * @return boolean Returns true if any entities exist for user.
     */
    public function has_member_entities($userid) {
        global $DB;
        $result = $DB->count_records('local_o365_token', ['user_id' => $userid]);
        $result = $result || $DB->count_records('local_o365_objects', ['type' => 'user', 'moodleid' => $userid]);
        $result = $result || $DB->count_records('local_o365_connections', ['muserid' => $userid]);

        return $result || $DB->count_records('local_o365_appassign', ['muserid' => $userid]);
    }
}
