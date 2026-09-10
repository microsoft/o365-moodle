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
use core\context\system;

/**
 * Unit tests for auth_oidc\utils.
 *
 * @package   auth_oidc
 * @author    Lai Wei <lai.wei@enovation.ie>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 * @group auth_oidc
 * @group office365
 */
final class utils_test extends advanced_testcase {
    /**
     * Data provider for {@see self::test_migrate_removed_icon_choices()}.
     *
     * @return array
     */
    public static function migrate_removed_icon_choices_provider(): array {
        return [
            'unset icon is left unset' => [null, null],
            'kept icon is left unchanged' => ['auth_oidc:openid', 'auth_oidc:openid'],
            'branded removed icon is remapped' => ['auth_oidc:o365', 'auth_oidc:office_365'],
            'legacy microsoft icon is remapped' => ['auth_oidc:microsoft', 'auth_oidc:microsoft_365'],
            'copilot icon is remapped' => ['auth_oidc:microsoft_365_copilot', 'auth_oidc:microsoft_365'],
            'removed core icon falls back to default' => ['moodle:t/lock', 'auth_oidc:microsoft_365'],
            'unknown value falls back to default' => ['something:unexpected', 'auth_oidc:microsoft_365'],
        ];
    }

    /**
     * Test utils::migrate_removed_icon_choices().
     *
     * @dataProvider migrate_removed_icon_choices_provider
     * @param string|null $icon Value stored in auth_oidc/icon before migration.
     * @param string|null $expected Expected value of auth_oidc/icon after migration.
     * @return void
     * @covers \auth_oidc\utils::migrate_removed_icon_choices
     */
    public function test_migrate_removed_icon_choices(?string $icon, ?string $expected): void {
        $this->resetAfterTest(true);

        if ($icon === null) {
            unset_config('icon', 'auth_oidc');
        } else {
            set_config('icon', $icon, 'auth_oidc');
        }

        utils::migrate_removed_icon_choices();

        $this->assertSame($expected, get_config('auth_oidc', 'icon') ?: null);
    }

    /**
     * A populated custom icon means the stock icon setting is not in play, so migration must
     * not touch either setting.
     *
     * @return void
     * @covers \auth_oidc\utils::migrate_removed_icon_choices
     */
    public function test_migrate_removed_icon_choices_skips_when_customicon_set(): void {
        $this->resetAfterTest(true);

        set_config('icon', 'moodle:t/lock', 'auth_oidc');
        set_config('customicon', '/logo.png', 'auth_oidc');

        utils::migrate_removed_icon_choices();

        $this->assertSame('moodle:t/lock', get_config('auth_oidc', 'icon'));
        $this->assertSame('/logo.png', get_config('auth_oidc', 'customicon'));
    }

    /**
     * A custom icon migrated from a core SVG stock icon can never be published to pix_plugins,
     * so the repair clears it and restores the default stock icon.
     *
     * @return void
     * @covers \auth_oidc\utils::repair_failed_icon_migration
     */
    public function test_repair_failed_icon_migration_clears_unpublishable_icon(): void {
        global $CFG;
        $this->resetAfterTest(true);

        $filename = 'migrated_i_permissionlock.svg';
        $this->create_customicon_file($filename);
        set_config('customicon', '/' . $filename, 'auth_oidc');
        unset_config('icon', 'auth_oidc');

        $stalepublished = $CFG->dataroot . '/pix_plugins/auth/oidc/0/customicon.png';
        check_dir_exists(dirname($stalepublished));
        file_put_contents($stalepublished, 'stale');

        utils::repair_failed_icon_migration();

        $this->assertEmpty(get_config('auth_oidc', 'customicon'));
        $this->assertSame('auth_oidc:microsoft_365', get_config('auth_oidc', 'icon'));
        $this->assertFileDoesNotExist($stalepublished);

        $fs = get_file_storage();
        $this->assertTrue($fs->is_area_empty(system::instance()->id, 'auth_oidc', 'customicon', 0));
    }

    /**
     * A migrated custom icon in a publishable format renders correctly and must be left alone.
     *
     * @return void
     * @covers \auth_oidc\utils::repair_failed_icon_migration
     */
    public function test_repair_failed_icon_migration_keeps_publishable_icon(): void {
        $this->resetAfterTest(true);

        $filename = 'migrated_i_permissionlock.png';
        $this->create_customicon_file($filename);
        set_config('customicon', '/' . $filename, 'auth_oidc');

        utils::repair_failed_icon_migration();

        $this->assertSame('/' . $filename, get_config('auth_oidc', 'customicon'));
    }

    /**
     * A custom icon that was uploaded by an admin (not produced by the migration) must be left
     * alone regardless of its extension.
     *
     * @return void
     * @covers \auth_oidc\utils::repair_failed_icon_migration
     */
    public function test_repair_failed_icon_migration_ignores_admin_uploads(): void {
        $this->resetAfterTest(true);

        $this->create_customicon_file('logo.gif');
        set_config('customicon', '/logo.gif', 'auth_oidc');

        utils::repair_failed_icon_migration();

        $this->assertSame('/logo.gif', get_config('auth_oidc', 'customicon'));
    }

    /**
     * Store a file in the auth_oidc customicon file area.
     *
     * @param string $filename
     * @return void
     */
    private function create_customicon_file(string $filename): void {
        get_file_storage()->create_file_from_string([
            'contextid' => system::instance()->id,
            'component' => 'auth_oidc',
            'filearea' => 'customicon',
            'itemid' => 0,
            'filepath' => '/',
            'filename' => $filename,
        ], 'icon-data');
    }
}
