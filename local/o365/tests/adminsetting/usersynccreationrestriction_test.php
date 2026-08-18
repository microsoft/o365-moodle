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
 * Unit tests for the usersynccreationrestriction admin setting.
 *
 * @package local_o365
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

use advanced_testcase;
use core\component;
use moodle_exception;

/**
 * Unit tests for the class usersynccreationrestriction
 *
 * @group local_o365
 * @group office365
 * @coversDefaultClass \local_o365\adminsetting\usersynccreationrestriction
 */
final class usersynccreationrestriction_test extends advanced_testcase {
    /**
     * Build a test instance of the setting with a stub group API client injected.
     *
     * @param object $apiclient Stub API client exposing get_groups_batch().
     * @return usersynccreationrestriction
     */
    private function get_test_setting(object $apiclient): usersynccreationrestriction {
        $pluginslist = component::get_plugin_list('auth');
        if (!array_key_exists('oidc', $pluginslist)) {
            $this->markTestSkipped('auth_oidc needs to be installed to use this test!');
        }

        return new class ('local_o365/usersynccreationrestriction', 'Test', 'Test', []) extends usersynccreationrestriction {
            /** @var object Stub API client to return from get_group_api_client(). */
            public object $testapiclient;

            /**
             * Return the stub API client instead of constructing a real one.
             *
             * @return object
             */
            protected function get_group_api_client() {
                return $this->testapiclient;
            }
        };
    }

    /**
     * Build a stub Microsoft Graph group API client for testing.
     *
     * @param array $validgroupids Object IDs that should validate successfully.
     * @param bool $throw Whether get_groups_batch() should throw a moodle_exception.
     * @return object
     */
    private function get_stub_group_api(array $validgroupids = [], bool $throw = false): object {
        return new class ($validgroupids, $throw) {
            /** @var array Object IDs passed to each call to get_groups_batch(). */
            public array $calls = [];

            /** @var array Object IDs that should validate successfully. */
            private array $validgroupids;

            /** @var bool Whether get_groups_batch() should throw. */
            private bool $throw;

            /**
             * Constructor.
             *
             * @param array $validgroupids Object IDs that should validate successfully.
             * @param bool $throw Whether get_groups_batch() should throw a moodle_exception.
             */
            public function __construct(array $validgroupids, bool $throw) {
                $this->validgroupids = $validgroupids;
                $this->throw = $throw;
            }

            /**
             * Stub batch group lookup.
             *
             * @param array $objectids Object IDs to look up.
             * @return array
             * @throws moodle_exception
             */
            public function get_groups_batch(array $objectids): array {
                $this->calls[] = $objectids;
                if ($this->throw) {
                    throw new moodle_exception('erroro365apibadcall', 'local_o365');
                }

                $results = [];
                foreach ($objectids as $objectid) {
                    $results[$objectid] = in_array($objectid, $this->validgroupids, true) ? ['id' => $objectid] : null;
                }

                return $results;
            }
        };
    }

    /**
     * Broken form data (missing remotefield/value) wipes the setting and reports no error.
     *
     * @covers ::write_setting
     */
    public function test_write_setting_broken_data(): void {
        $this->resetAfterTest();

        $setting = $this->get_test_setting($this->get_stub_group_api());
        $result = $setting->write_setting(['remotefield' => 'o365groupid']);

        $this->assertSame('', $result);
        $this->assertSame([], $setting->get_setting());
    }

    /**
     * Multiple valid group object IDs are validated in a single batched API call and saved.
     *
     * @covers ::write_setting
     * @covers ::get_group_api_client
     */
    public function test_write_setting_multiple_valid_group_ids(): void {
        $this->resetAfterTest();

        $id1 = '11111111-1111-1111-1111-111111111111';
        $id2 = '22222222-2222-2222-2222-222222222222';
        $apiclient = $this->get_stub_group_api([$id1, $id2]);
        $setting = $this->get_test_setting($apiclient);

        $result = $setting->write_setting([
            'remotefield' => 'o365groupid',
            'value' => "$id1, $id2",
            'useregex' => 0,
        ]);

        $this->assertSame('', $result);
        $this->assertSame("$id1, $id2", $setting->get_setting()['value']);

        // All configured group IDs must be validated in a single batch call, not one per ID.
        $this->assertCount(1, $apiclient->calls);
        $this->assertSame([$id1, $id2], $apiclient->calls[0]);
    }

    /**
     * An unrecognised group object ID is rejected with an error naming that ID.
     *
     * @covers ::write_setting
     */
    public function test_write_setting_invalid_group_id(): void {
        $this->resetAfterTest();

        $id1 = '11111111-1111-1111-1111-111111111111';
        $id2 = '22222222-2222-2222-2222-222222222222';
        $apiclient = $this->get_stub_group_api([$id1]);
        $setting = $this->get_test_setting($apiclient);

        $result = $setting->write_setting([
            'remotefield' => 'o365groupid',
            'value' => "$id1, $id2",
            'useregex' => 0,
        ]);

        $this->assertStringContainsString($id2, $result);
    }

    /**
     * A Graph API failure during validation is reported as a generic validation error.
     *
     * @covers ::write_setting
     */
    public function test_write_setting_group_api_failure(): void {
        $this->resetAfterTest();

        $apiclient = $this->get_stub_group_api([], true);
        $setting = $this->get_test_setting($apiclient);

        $result = $setting->write_setting([
            'remotefield' => 'o365groupid',
            'value' => '11111111-1111-1111-1111-111111111111',
            'useregex' => 0,
        ]);

        $this->assertSame(get_string('settings_usersynccreationrestriction_groupvalidationerror', 'local_o365'), $result);
    }

    /**
     * Group object IDs that only differ by casing are deduplicated before validation.
     *
     * @covers ::write_setting
     */
    public function test_write_setting_dedup_case_insensitive(): void {
        $this->resetAfterTest();

        $id = '11111111-1111-1111-1111-111111111111';
        $apiclient = $this->get_stub_group_api([$id]);
        $setting = $this->get_test_setting($apiclient);

        $result = $setting->write_setting([
            'remotefield' => 'o365groupid',
            'value' => strtoupper($id) . ', ' . $id,
            'useregex' => 0,
        ]);

        $this->assertSame('', $result);

        // The two casings of the same ID must be validated and stored as a single entry.
        $this->assertCount(1, $apiclient->calls);
        $this->assertCount(1, $apiclient->calls[0]);
        $this->assertSame(strtoupper($id), $setting->get_setting()['value']);
    }
}
