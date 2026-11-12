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
 * Unit tests for the usersyncgroupfilter admin setting.
 *
 * @package local_o365
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

use advanced_testcase;
use local_o365\feature\usersync\main;

/**
 * Unit tests for the class usersyncgroupfilter.
 *
 * @group local_o365
 * @group office365
 * @coversDefaultClass \local_o365\adminsetting\usersyncgroupfilter
 */
final class usersyncgroupfilter_test extends advanced_testcase {
    /**
     * Data provider for split_group_ids().
     *
     * @return array
     */
    public static function split_group_ids_provider(): array {
        $a = '11111111-1111-1111-1111-111111111111';
        $b = '22222222-2222-2222-2222-222222222222';

        return [
            'empty' => ['', []],
            'whitespace only' => [" \n ", []],
            'single' => [$a, [$a]],
            'comma separated' => ["$a,$b", [$a, $b]],
            'mixed separators and spaces' => ["$a, $b;\n$a", [$a, $b]],
            'upper case is normalised' => [strtoupper($a), [$a]],
        ];
    }

    /**
     * Test splitting a raw value into group IDs.
     *
     * @dataProvider split_group_ids_provider
     * @covers \local_o365\feature\usersync\main::split_group_ids
     * @param string $value Raw value.
     * @param array $expected Expected IDs.
     */
    public function test_split_group_ids(string $value, array $expected): void {
        $this->assertSame($expected, main::split_group_ids($value));
    }

    /**
     * Build a test instance of the setting with a stub API client injected.
     *
     * @param object|null $apiclient Stub exposing get_groups_batch(), or null to simulate Microsoft Graph being unavailable.
     * @return usersyncgroupfilter
     */
    private function get_test_setting(?object $apiclient): usersyncgroupfilter {
        return new class ('local_o365/usersyncgroupfilter', 'Test', 'Test', '', $apiclient) extends usersyncgroupfilter {
            /**
             * Stub API client.
             *
             * @var object|null
             */
            private ?object $stubclient;

            /**
             * Constructor.
             *
             * @param string $name Setting name.
             * @param string $visiblename Visible name.
             * @param string $description Description.
             * @param string $defaultsetting Default value.
             * @param object|null $stubclient Stub API client.
             */
            public function __construct($name, $visiblename, $description, $defaultsetting, ?object $stubclient) {
                parent::__construct($name, $visiblename, $description, $defaultsetting);
                $this->stubclient = $stubclient;
            }

            /**
             * Return the stub API client, or fail like an unconfigured Microsoft Graph connection.
             *
             * @return object
             */
            protected function get_group_api_client() {
                if ($this->stubclient === null) {
                    throw new \moodle_exception('generalexceptionmessage', 'error', '', 'Not configured');
                }
                return $this->stubclient;
            }
        };
    }

    /**
     * Build a stub API client that knows the given group IDs.
     *
     * @param array $existing Group IDs that exist.
     * @return object
     */
    private function get_stub_client(array $existing): object {
        return new class ($existing) {
            /**
             * Group IDs that exist.
             *
             * @var array
             */
            private array $existing;

            /**
             * Constructor.
             *
             * @param array $existing Group IDs that exist.
             */
            public function __construct(array $existing) {
                $this->existing = $existing;
            }

            /**
             * Look up groups like unified::get_groups_batch().
             *
             * @param array $objectids Group IDs.
             * @return array
             */
            public function get_groups_batch(array $objectids): array {
                $result = [];
                foreach ($objectids as $id) {
                    $result[$id] = in_array($id, $this->existing) ? ['id' => $id] : null;
                }
                return $result;
            }
        };
    }

    /**
     * Test that valid values are stored normalised and invalid values are rejected.
     *
     * @covers ::write_setting
     */
    public function test_write_setting(): void {
        $this->resetAfterTest();

        $a = '11111111-1111-1111-1111-111111111111';
        $b = 'aaaaaaaa-2222-2222-2222-222222222222';
        $setting = $this->get_test_setting($this->get_stub_client([$a, $b]));

        $this->assertSame('', $setting->write_setting("$a,\n" . strtoupper($b)));
        $this->assertSame($a . ',' . $b, get_config('local_o365', 'usersyncgroupfilter'));

        $this->assertSame('', $setting->write_setting($a));
        $this->assertSame($a, get_config('local_o365', 'usersyncgroupfilter'));

        $this->assertSame('', $setting->write_setting(''));
        $this->assertEmpty(get_config('local_o365', 'usersyncgroupfilter'));

        $error = $setting->write_setting("$a, not-a-guid, also-bad");
        $this->assertSame(
            get_string('settings_usersyncgroupfilter_validation_error', 'local_o365', 'not-a-guid, also-bad'),
            $error
        );
        $this->assertEmpty(get_config('local_o365', 'usersyncgroupfilter'), 'Nothing must be stored when any ID is invalid.');
    }

    /**
     * Test that a well-formed group ID that does not exist is rejected and nothing is stored.
     *
     * @covers ::write_setting
     */
    public function test_write_setting_rejects_unknown_group(): void {
        $this->resetAfterTest();

        $a = '11111111-1111-1111-1111-111111111111';
        $missing1 = '33333333-3333-3333-3333-333333333333';
        $missing2 = '44444444-4444-4444-4444-444444444444';
        $setting = $this->get_test_setting($this->get_stub_client([$a]));

        // Every unknown group is reported, not only the first one.
        $error = $setting->write_setting("$missing1,$a,$missing2");
        $this->assertSame(
            get_string('settings_usersyncgroupfilter_notfound', 'local_o365', $missing1 . ', ' . $missing2),
            $error
        );
        $this->assertEmpty(get_config('local_o365', 'usersyncgroupfilter'));

        // Malformed and unknown IDs are reported together.
        $error = $setting->write_setting("bad-id,$missing1");
        $this->assertSame(
            get_string('settings_usersyncgroupfilter_validation_error', 'local_o365', 'bad-id') . ' ' .
            get_string('settings_usersyncgroupfilter_notfound', 'local_o365', $missing1),
            $error
        );
        $this->assertEmpty(get_config('local_o365', 'usersyncgroupfilter'));
    }

    /**
     * Test that the value is saved, with a warning, when Microsoft Graph cannot be used to check the groups.
     *
     * @covers ::write_setting
     */
    public function test_write_setting_saves_when_graph_unavailable(): void {
        $this->resetAfterTest();

        $a = '11111111-1111-1111-1111-111111111111';
        $setting = $this->get_test_setting(null);

        $this->assertSame('', $setting->write_setting($a));
        $this->assertSame($a, get_config('local_o365', 'usersyncgroupfilter'));
    }
}
