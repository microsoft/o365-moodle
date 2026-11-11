<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace auth_oidc\adminsetting;

use advanced_testcase;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/auth/oidc/lib.php');

/**
 * Unit tests for the user restrictions settings, which are disabled for Microsoft Entra External ID.
 *
 * @package   auth_oidc
 * @author    Lai Wei <lai.wei@enovation.ie>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 * @group auth_oidc
 * @group office365
 * @coversDefaultClass \auth_oidc\adminsetting\external_id_disabled
 */
final class auth_oidc_admin_setting_userrestrictions_test extends advanced_testcase {
    /**
     * Set up the test environment.
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
        $this->setAdminUser();
    }

    /**
     * Create the settings that are disabled for Microsoft Entra External ID.
     *
     * @return \admin_setting[] The text area and the checkbox, indexed by their names.
     */
    private function create_settings(): array {
        return [
            'userrestrictions' => new auth_oidc_admin_setting_userrestrictions(
                'auth_oidc/userrestrictions',
                'Restrictions',
                'Description',
                ''
            ),
            'userrestrictionscasesensitive' => new auth_oidc_admin_setting_userrestrictionscasesensitive(
                'auth_oidc/userrestrictionscasesensitive',
                'Case sensitive',
                'Description',
                0
            ),
        ];
    }

    /**
     * The controls are disabled by a fieldset around the setting for External ID, whatever they are.
     *
     * @return void
     * @covers ::output_html
     */
    public function test_output_html_is_wrapped_in_disabled_fieldset_for_external_id(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');

        foreach ($this->create_settings() as $setting) {
            $html = $setting->output_html('');

            $this->assertMatchesRegularExpression('/^<fieldset\b[^>]*\bdisabled="disabled"/', $html);
            $this->assertStringEndsWith('</fieldset>', trim($html));
        }
    }

    /**
     * The settings are not changed for the other IdP types.
     *
     * @return void
     * @covers ::output_html
     */
    public function test_output_html_is_not_changed_for_other_idp_types(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');

        foreach ($this->create_settings() as $setting) {
            $this->assertStringNotContainsString('<fieldset', $setting->output_html(''));
        }
    }

    /**
     * The submitted values are ignored for External ID, and the saved ones are kept.
     *
     * @return void
     * @covers ::write_setting
     */
    public function test_write_setting_is_ignored_for_external_id(): void {
        set_config('userrestrictions', '^saved@', 'auth_oidc');
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_EXTERNAL_ID, 'auth_oidc');

        $settings = $this->create_settings();
        $this->assertSame('', $settings['userrestrictions']->write_setting('^changed@'));

        $this->assertSame('^saved@', get_config('auth_oidc', 'userrestrictions'));
    }

    /**
     * The submitted values are saved for the other IdP types.
     *
     * @return void
     * @covers ::write_setting
     */
    public function test_write_setting_saves_for_other_idp_types(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');

        $settings = $this->create_settings();
        $this->assertSame('', $settings['userrestrictions']->write_setting('^changed@'));

        $this->assertSame('^changed@', get_config('auth_oidc', 'userrestrictions'));
    }
}
