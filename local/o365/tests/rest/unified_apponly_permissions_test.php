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
 * Test cases for checking the application permissions of the Microsoft Graph API.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\rest;

use advanced_testcase;

/**
 * Tests the check of the application permissions of the Microsoft Graph API.
 *
 * @group local_o365
 * @group office365
 * @covers \local_o365\rest\unified::find_missing_apponly_permissions
 */
final class unified_apponly_permissions_test extends advanced_testcase {
    /**
     * Create a Graph client that doesn't talk to Microsoft.
     *
     * @return unified
     */
    private function create_graph(): unified {
        return $this->getMockBuilder(unified::class)->disableOriginalConstructor()->onlyMethods([])->getMock();
    }

    /**
     * Test permissions missing from the application are reported with their friendly names.
     */
    public function test_missing_permissions(): void {
        $missing = $this->create_graph()->find_missing_apponly_permissions(
            ['Channel.Create' => [], 'Team.Create' => []],
            ['Team.Create' => []],
            [['value' => 'Channel.Create', 'displayName' => 'Create channels']],
            null
        );

        $this->assertSame(['Channel.Create' => 'Create channels'], $missing);
    }

    /**
     * Test a permission that is as good as the required one is accepted.
     */
    public function test_alternative_permission(): void {
        $this->assertSame([], $this->create_graph()->find_missing_apponly_permissions(
            ['Channel.ReadBasic.All' => ['ChannelSettings.Read.All']],
            ['ChannelSettings.Read.All' => []],
            [],
            ['ChannelSettings.Read.All' => true]
        ));
    }

    /**
     * Test permissions on the application that haven't had consent granted are reported.
     */
    public function test_permission_without_consent(): void {
        $missing = $this->create_graph()->find_missing_apponly_permissions(
            ['Channel.Create' => [], 'Team.Create' => [], 'User.Read.All' => ['User.ReadWrite.All']],
            ['Channel.Create' => [], 'Team.Create' => [], 'User.ReadWrite.All' => []],
            [['value' => 'Channel.Create', 'displayName' => 'Create channels']],
            ['Team.Create' => true, 'User.ReadWrite.All' => true]
        );

        $this->assertSame(['Channel.Create'], array_keys($missing));
        $this->assertStringStartsWith('Create channels (', $missing['Channel.Create']);
        $this->assertStringContainsString(get_string('settings_verifysetup_notgranted', 'local_o365'), $missing['Channel.Create']);
    }

    /**
     * Test consent isn't checked when it isn't known which permissions have been granted.
     */
    public function test_consent_unknown(): void {
        $this->assertSame([], $this->create_graph()->find_missing_apponly_permissions(
            ['Channel.Create' => []],
            ['Channel.Create' => []],
            [],
            null
        ));
    }
}
