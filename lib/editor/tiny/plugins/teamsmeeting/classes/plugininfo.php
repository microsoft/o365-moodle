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

/**
 * Tiny Teams Meeting plugin info.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tiny_teamsmeeting;

defined('MOODLE_INTERNAL') || die();

use context;
use editor_tiny\editor;
use editor_tiny\plugin;
use editor_tiny\plugin_with_buttons;
use editor_tiny\plugin_with_configuration;

require_once($CFG->dirroot . '/repository/url/lib.php');

/**
 * Tiny Teams Meeting plugin info.
 *
 * @package     tiny_teamsmeeting
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class plugininfo extends plugin implements plugin_with_buttons, plugin_with_configuration {

    /**
     * Return the buttons for the editor plugin.
     *
     * @return string[] List of buttons this plugin provides.
     */
    public static function get_available_buttons() : array {
        return [
            'tiny_teamsmeeting/plugin',
        ];
    }

    /**
     * Is the plugin enabled? This is the case when the capabilities are met.
     *
     * @param context $context The context that the editor is used within
     * @param array $options The options passed in when requesting the editor
     * @param array $fpoptions The filepicker options passed in when requesting the editor
     * @param editor|null $editor The editor instance in which the plugin is initialised
     * @return boolean
     */
    public static function is_enabled(
        context $context,
        array $options,
        array $fpoptions,
        ?editor $editor = null
    ): bool {
        return has_capability('tiny/teamsmeeting:add', $context);
    }

    /**
     * Return plugin configuration for the given context.
     *
     * @param context $context
     * @param array $options
     * @param array $fpoptions
     * @param editor|null $editor
     * @return array
     */
    public static function get_plugin_configuration_for_context(context $context, array $options, array $fpoptions,
        ?editor $editor = null) : array {
        global $CFG, $SESSION, $USER;

        return [
            'appurl' => get_config('tiny_teamsmeeting', 'meetingapplink'),
            'clientdomain' => encode_url($CFG->wwwroot),
            'localevalue' => (empty($SESSION->lang) ? $USER->lang : $SESSION->lang),
            'msession' => sesskey(),
        ];
    }
}
