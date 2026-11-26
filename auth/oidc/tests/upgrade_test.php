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

namespace auth_oidc;

use advanced_testcase;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/upgradelib.php');
require_once($CFG->dirroot . '/auth/oidc/lib.php');
require_once($CFG->dirroot . '/auth/oidc/db/upgrade.php');

/**
 * Unit tests for the upgrade steps of auth_oidc.
 *
 * @package   auth_oidc
 * @author    Lai Wei <lai.wei@enovation.ie>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 * @group auth_oidc
 * @group office365
 * @coversNothing
 */
final class upgrade_test extends advanced_testcase {
    /** @var float The plugin version before the single sign out setting was renamed to single logout. */
    private const VERSION_BEFORE_RENAME = 2026100500;

    /**
     * Run the upgrade steps that come after the given version.
     *
     * The version that is saved for the plugin is set back first, as the upgrade steps refuse to run when the saved version is
     * not older than the version they set.
     *
     * @param float $oldversion The version to upgrade from.
     * @return void
     */
    private function run_upgrade(float $oldversion): void {
        set_config('version', $oldversion, 'auth_oidc');

        $this->assertTrue(xmldb_auth_oidc_upgrade($oldversion));
    }

    /**
     * The saved single sign out setting is moved to the single logout setting.
     *
     * @return void
     */
    public function test_single_sign_off_is_renamed_to_single_logout(): void {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        unset_config('single_logout', 'auth_oidc');
        set_config('single_sign_off', '1', 'auth_oidc');

        $this->run_upgrade(self::VERSION_BEFORE_RENAME);

        $this->assertSame('1', get_config('auth_oidc', 'single_logout'));
        $this->assertFalse(get_config('auth_oidc', 'single_sign_off'));
    }

    /**
     * A disabled single sign out setting stays disabled.
     *
     * @return void
     */
    public function test_disabled_single_sign_off_is_renamed_to_single_logout(): void {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        unset_config('single_logout', 'auth_oidc');
        set_config('single_sign_off', '0', 'auth_oidc');

        $this->run_upgrade(self::VERSION_BEFORE_RENAME);

        $this->assertSame('0', get_config('auth_oidc', 'single_logout'));
        $this->assertFalse(get_config('auth_oidc', 'single_sign_off'));
    }

    /**
     * The rename is written to the config log.
     *
     * @return void
     */
    public function test_rename_is_written_to_config_log(): void {
        global $DB;

        $this->resetAfterTest(true);
        $this->setAdminUser();

        unset_config('single_logout', 'auth_oidc');
        set_config('single_sign_off', '1', 'auth_oidc');
        $conditions = ['plugin' => 'auth_oidc', 'name' => 'single_logout'];
        $existing = $DB->count_records('config_log', $conditions);

        $this->run_upgrade(self::VERSION_BEFORE_RENAME);

        $this->assertSame($existing + 1, $DB->count_records('config_log', $conditions));
        $logs = $DB->get_records('config_log', $conditions, 'id DESC', '*', 0, 1);
        $this->assertSame('1', reset($logs)->value);
    }

    /**
     * A single logout setting that exists already is not overwritten, and the old setting is still removed.
     *
     * @return void
     */
    public function test_existing_single_logout_is_not_overwritten(): void {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        set_config('single_logout', '0', 'auth_oidc');
        set_config('single_sign_off', '1', 'auth_oidc');

        $this->run_upgrade(self::VERSION_BEFORE_RENAME);

        $this->assertSame('0', get_config('auth_oidc', 'single_logout'));
        $this->assertFalse(get_config('auth_oidc', 'single_sign_off'));
    }

    /**
     * Nothing is created when the single sign out setting was never saved.
     *
     * @return void
     */
    public function test_nothing_is_created_without_single_sign_off(): void {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        unset_config('single_logout', 'auth_oidc');
        unset_config('single_sign_off', 'auth_oidc');

        $this->run_upgrade(self::VERSION_BEFORE_RENAME);

        $this->assertFalse(get_config('auth_oidc', 'single_logout'));
        $this->assertFalse(get_config('auth_oidc', 'single_sign_off'));
    }

    /**
     * The step does not run again for a site that has been upgraded already.
     *
     * @return void
     */
    public function test_rename_is_skipped_when_already_upgraded(): void {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        set_config('single_sign_off', '1', 'auth_oidc');
        unset_config('single_logout', 'auth_oidc');
        $currentversion = (float) get_config('auth_oidc', 'version');

        $this->assertTrue(xmldb_auth_oidc_upgrade($currentversion));

        $this->assertSame('1', get_config('auth_oidc', 'single_sign_off'));
        $this->assertFalse(get_config('auth_oidc', 'single_logout'));
    }

    /**
     * The upgrade step sets the plugin version it is introduced in.
     *
     * @return void
     */
    public function test_upgrade_reaches_the_plugin_version(): void {
        $this->resetAfterTest(true);
        $this->setAdminUser();

        $plugin = new \stdClass();
        require(__DIR__ . '/../version.php');

        $this->run_upgrade(self::VERSION_BEFORE_RENAME);

        $this->assertEquals($plugin->version, get_config('auth_oidc', 'version'));
    }
}
