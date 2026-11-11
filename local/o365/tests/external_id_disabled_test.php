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

namespace local_o365;

use advanced_testcase;
use core\event\user_created;
use core\event\user_deleted;
use core\task\manager;
use local_o365\feature\calsync\observers as calsync_observers;
use local_o365\feature\coursesync\observers as coursesync_observers;
use local_o365\task\groupchannelsyncgroup;
use moodle_exception;
use ReflectionClass;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/auth/oidc/lib.php');
require_once($CFG->dirroot . '/local/o365/lib.php');

/**
 * Tests for the features of the plugin that are disabled when the IdP type of auth_oidc is Microsoft Entra External ID.
 *
 * @package   local_o365
 * @author    Lai Wei <lai.wei@enovation.ie>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 * @group local_o365
 * @group office365
 */
final class external_id_disabled_test extends advanced_testcase {
    /**
     * Set the IdP type of the OpenID Connect authentication plugin.
     *
     * @param int $idptype One of the AUTH_OIDC_IDP_TYPE_* constants.
     * @return void
     */
    private function set_idp_type(int $idptype): void {
        set_config('idptype', $idptype, 'auth_oidc');
    }

    /**
     * Data provider for the IdP types.
     *
     * @return array
     */
    public static function idp_type_provider(): array {
        return [
            'not connected' => [AUTH_OIDC_IDP_TYPE_NOT_CONNECTED, false],
            'Microsoft Entra ID (v1.0)' => [AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, false],
            'Microsoft identity platform (v2.0)' => [AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, false],
            'other' => [AUTH_OIDC_IDP_TYPE_OTHER, false],
            'Microsoft Entra External ID' => [AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, true],
        ];
    }

    /**
     * Only the Microsoft Entra External ID IdP type disables the features.
     *
     * @dataProvider idp_type_provider
     * @param int $idptype
     * @param bool $expected
     * @return void
     * @covers \local_o365\utils::is_disabled_for_idp_type
     */
    public function test_is_disabled_for_idp_type(int $idptype, bool $expected): void {
        $this->resetAfterTest();

        $this->set_idp_type($idptype);

        $this->assertSame($expected, utils::is_disabled_for_idp_type());
    }

    /**
     * Requiring the features to be enabled throws an exception for Microsoft Entra External ID only.
     *
     * @dataProvider idp_type_provider
     * @param int $idptype
     * @param bool $disabled
     * @return void
     * @covers \local_o365\utils::require_features_enabled
     */
    public function test_require_features_enabled(int $idptype, bool $disabled): void {
        $this->resetAfterTest();

        $this->set_idp_type($idptype);

        if ($disabled) {
            $this->expectException(moodle_exception::class);
            $this->expectExceptionMessage(get_string('features_disabled_external_id', 'local_o365'));
        }

        utils::require_features_enabled();

        $this->assertFalse($disabled);
    }

    /**
     * Tasks are skipped, with an explanation in their output, for Microsoft Entra External ID only.
     *
     * @dataProvider idp_type_provider
     * @param int $idptype
     * @param bool $disabled
     * @return void
     * @covers \local_o365\utils::skip_task_for_idp_type
     */
    public function test_skip_task_for_idp_type(int $idptype, bool $disabled): void {
        $this->resetAfterTest();

        $this->set_idp_type($idptype);

        $this->expectOutputString($disabled ? get_string('task_skipped_external_id', 'local_o365') . "\n" : '');

        $this->assertSame($disabled, utils::skip_task_for_idp_type());
    }

    /**
     * Discover the scheduled and ad hoc task classes of the plugin.
     *
     * @return array The task class names and the files they are in, indexed by class name.
     */
    public static function task_class_provider(): array {
        $classesdir = dirname(__DIR__) . '/classes';
        $patterns = [
            $classesdir . '/task/*.php' => 'local_o365\\task\\',
        ];
        foreach (glob($classesdir . '/feature/*/task', GLOB_ONLYDIR) as $featuretaskdir) {
            $feature = basename(dirname($featuretaskdir));
            $patterns[$featuretaskdir . '/*.php'] = 'local_o365\\feature\\' . $feature . '\\task\\';
        }

        $tasks = [];
        foreach ($patterns as $pattern => $namespace) {
            foreach (glob($pattern) as $file) {
                $classname = $namespace . basename($file, '.php');
                $tasks[$classname] = [$classname, $file];
            }
        }
        ksort($tasks);

        return $tasks;
    }

    /**
     * Every task of the plugin starts with the check that skips it for Microsoft Entra External ID, so a task that is added
     * without the check fails this test.
     *
     * @dataProvider task_class_provider
     * @param string $classname
     * @param string $file
     * @return void
     * @coversNothing
     */
    public function test_tasks_start_with_idp_type_check(string $classname, string $file): void {
        $source = file_get_contents($file);

        $pattern = '/function execute\([^)]*\)[^{]*\{\s*' .
            'if \(\\\\local_o365\\\\utils::skip_task_for_idp_type\(\)\) \{\s*return( true)?;\s*\}/';
        $this->assertMatchesRegularExpression(
            $pattern,
            $source,
            "The execute() method of {$classname} has to start with the skip_task_for_idp_type() check."
        );
    }

    /**
     * Tasks do nothing, and explain why in their output, when the IdP type is Microsoft Entra External ID.
     *
     * @dataProvider task_class_provider
     * @param string $classname
     * @param string $file
     * @return void
     * @coversNothing
     */
    public function test_tasks_are_skipped(string $classname, string $file): void {
        $this->resetAfterTest();

        $this->assertTrue(class_exists($classname), "The class {$classname} cannot be loaded from {$file}.");
        $reflection = new ReflectionClass($classname);
        $constructor = $reflection->getConstructor();
        if ($reflection->isAbstract() || ($constructor && $constructor->getNumberOfRequiredParameters() > 0)) {
            $this->markTestSkipped("{$classname} cannot be instantiated without arguments.");
        }

        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);

        $task = new $classname();

        $this->expectOutputString(get_string('task_skipped_external_id', 'local_o365') . "\n");

        // The tasks return true, or nothing, when they are skipped, and false when they fail.
        $this->assertNotFalse($task->execute());
    }

    /**
     * The observer of a user being created does nothing for Microsoft Entra External ID.
     *
     * @return void
     * @covers \local_o365\observers::handle_user_created
     */
    public function test_observer_user_created(): void {
        $this->resetAfterTest();

        $user = $this->getDataGenerator()->create_user();
        $event = user_created::create_from_userid($user->id);

        // Without an IdP that has Microsoft 365 services, the observer does not handle the event.
        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_OTHER);
        $this->assertFalse(observers::handle_user_created($event));

        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);
        $this->assertTrue(observers::handle_user_created($event));
    }

    /**
     * The observer of a user logging in with OpenID Connect does nothing for Microsoft Entra External ID.
     *
     * @return void
     * @covers \local_o365\observers::handle_oidc_user_loggedin
     */
    public function test_observer_oidc_user_loggedin(): void {
        $this->resetAfterTest();

        $user = $this->getDataGenerator()->create_user();
        $event = \auth_oidc\event\user_loggedin::create([
            'objectid' => $user->id,
            'userid' => $user->id,
            'other' => ['username' => $user->username],
        ]);

        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_OTHER);
        $this->assertFalse(observers::handle_oidc_user_loggedin($event));

        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);
        $this->assertTrue(observers::handle_oidc_user_loggedin($event));
    }

    /**
     * The calendar sync observer of a user being deleted leaves the calendar data alone for Microsoft Entra External ID.
     *
     * @return void
     * @covers \local_o365\feature\calsync\observers::handle_user_deleted
     */
    public function test_calsync_observer_user_deleted(): void {
        global $DB;

        $this->resetAfterTest();

        $user = $this->getDataGenerator()->create_user();
        $event = user_deleted::create([
            'objectid' => $user->id,
            'relateduserid' => $user->id,
            'context' => \context_user::instance($user->id),
            'other' => [
                'username' => $user->username,
                'email' => $user->email,
                'idnumber' => $user->idnumber,
                'picture' => $user->picture,
                'mnethostid' => $user->mnethostid,
            ],
        ]);
        $DB->insert_record('local_o365_calsub', (object) [
            'user_id' => $user->id,
            'caltype' => 'user',
            'caltypeid' => $user->id,
            'o365calid' => 'calendarid',
            'isprimary' => 1,
            'syncbehav' => 'out',
            'timecreated' => time(),
        ]);

        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);
        $this->assertTrue(calsync_observers::handle_user_deleted($event));
        $this->assertTrue($DB->record_exists('local_o365_calsub', ['user_id' => $user->id]));

        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_OTHER);
        $this->assertTrue(calsync_observers::handle_user_deleted($event));
        $this->assertFalse($DB->record_exists('local_o365_calsub', ['user_id' => $user->id]));
    }

    /**
     * The course sync observer of a group member being added does not queue a channel sync for Microsoft Entra External ID.
     *
     * @return void
     * @covers \local_o365\feature\coursesync\observers::handle_group_member_added
     */
    public function test_coursesync_observer_group_member_added(): void {
        $this->resetAfterTest();

        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id);
        $group = $this->getDataGenerator()->create_group(['courseid' => $course->id]);
        $event = \core\event\group_member_added::create([
            'objectid' => $group->id,
            'context' => \context_course::instance($course->id),
            'relateduserid' => $user->id,
            'other' => ['component' => '', 'itemid' => 0],
        ]);

        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_OTHER);
        $this->assertFalse(coursesync_observers::handle_group_member_added($event));

        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);
        $this->assertTrue(coursesync_observers::handle_group_member_added($event));
        $this->assertEmpty(manager::get_adhoc_tasks(groupchannelsyncgroup::class));
    }

    /**
     * Data provider for the web service methods of the plugin, with arguments that are enough to call them.
     *
     * @return array
     */
    public static function web_service_provider(): array {
        return [
            'create_onenoteassignment' => [\local_o365\webservices\create_onenoteassignment::class, 'assignment_create', [[]]],
            'delete_onenoteassignment' => [\local_o365\webservices\delete_onenoteassignment::class, 'assignment_delete', [[]]],
            'read_assignments' => [\local_o365\webservices\read_assignments::class, 'assignments_read', []],
            'read_courseusers' => [\local_o365\webservices\read_courseusers::class, 'courseusers_read', [1]],
            'read_onenoteassignment' => [\local_o365\webservices\read_onenoteassignment::class, 'assignment_read', [[]]],
            'read_teachercourses' => [\local_o365\webservices\read_teachercourses::class, 'teachercourses_read', []],
            'update_coursesync' => [\local_o365\webservices\update_coursesync::class, 'coursesync_update', [[]]],
            'update_grade' => [\local_o365\webservices\update_grade::class, 'grade_update', [1, 1, 1, 0, false, '', false]],
            'update_onenoteassignment' => [\local_o365\webservices\update_onenoteassignment::class, 'assignment_update', [[]]],
        ];
    }

    /**
     * Data provider for the web service methods that load the deprecated lib/externallib.php file.
     *
     * Moodle only allows that file to be included in an isolated process when running unit tests.
     *
     * @return array
     */
    public static function isolated_web_service_provider(): array {
        return [
            'cohortsync_search_cohorts' => [\local_o365\webservices\cohortsync_search_cohorts::class, 'search_cohorts', ['a']],
            'cohortsync_search_groups' => [\local_o365\webservices\cohortsync_search_groups::class, 'search_groups', ['a']],
            'coursesync_search_teams' => [\local_o365\webservices\coursesync_search_teams::class, 'search_teams', ['a', 1]],
        ];
    }

    /**
     * Call a web service method with Microsoft Entra External ID set, and expect it to be refused.
     *
     * @param string $classname
     * @param string $method
     * @param array $arguments
     * @return void
     */
    private function assert_web_service_is_disabled(string $classname, string $method, array $arguments): void {
        $this->resetAfterTest();

        $this->setAdminUser();
        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);

        $this->expectException(moodle_exception::class);
        $this->expectExceptionMessage(get_string('features_disabled_external_id', 'local_o365'));

        call_user_func_array([$classname, $method], $arguments);
    }

    /**
     * The web service methods of the plugin refuse to run for Microsoft Entra External ID.
     *
     * @dataProvider web_service_provider
     * @param string $classname
     * @param string $method
     * @param array $arguments
     * @return void
     * @coversNothing
     */
    public function test_web_services_are_disabled(string $classname, string $method, array $arguments): void {
        $this->assert_web_service_is_disabled($classname, $method, $arguments);
    }

    /**
     * The web service methods that load lib/externallib.php refuse to run for Microsoft Entra External ID.
     *
     * @dataProvider isolated_web_service_provider
     * @runInSeparateProcess
     * @param string $classname
     * @param string $method
     * @param array $arguments
     * @return void
     * @coversNothing
     */
    public function test_web_services_with_deprecated_include_are_disabled(
        string $classname,
        string $method,
        array $arguments
    ): void {
        $this->assert_web_service_is_disabled($classname, $method, $arguments);
    }

    /**
     * The plugin is not configured for Microsoft Entra External ID, even when the authentication plugin is set up.
     *
     * @return void
     * @covers \local_o365\utils::is_configured
     */
    public function test_is_not_configured_for_external_id(): void {
        $this->resetAfterTest();

        set_config('clientid', 'clientid', 'auth_oidc');
        set_config('clientsecret', 'secret', 'auth_oidc');
        set_config('clientauthmethod', AUTH_OIDC_AUTH_METHOD_SECRET, 'auth_oidc');
        set_config('authendpoint', 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/authorize', 'auth_oidc');
        set_config('tokenendpoint', 'https://contoso.ciamlogin.com/tenant-id/oauth2/v2.0/token', 'auth_oidc');
        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);

        $this->assertFalse(utils::is_configured());

        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM);

        $this->assertTrue(utils::is_configured());
    }

    /**
     * A Teams theme override that the plugin set earlier is cleared when the IdP type is Microsoft Entra External ID, as
     * the theme is not applied any more.
     *
     * @return void
     * @covers ::local_o365_after_require_login
     */
    public function test_after_require_login_clears_teams_theme_set_by_plugin_for_external_id(): void {
        global $SESSION;

        $this->resetAfterTest();
        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);
        $SESSION->theme = 'boost_o365teams';
        $SESSION->local_o365_teamstheme = true;

        local_o365_after_require_login(null, false, null, false, true);

        $this->assertFalse(isset($SESSION->theme));
        $this->assertFalse(isset($SESSION->local_o365_teamstheme));
    }

    /**
     * An unrelated theme override, which the plugin did not set, is left alone for Microsoft Entra External ID.
     *
     * @return void
     * @covers ::local_o365_after_require_login
     */
    public function test_after_require_login_keeps_unrelated_theme_override_for_external_id(): void {
        global $SESSION;

        $this->resetAfterTest();
        $this->set_idp_type(AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID);
        $SESSION->theme = 'classic';
        unset($SESSION->local_o365_teamstheme);

        local_o365_after_require_login(null, false, null, false, true);

        $this->assertSame('classic', $SESSION->theme);
    }
}
