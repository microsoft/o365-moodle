<?php
// This file is part of Moodle-oembed-Filter
//
// Moodle-oembed-Filter is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle-oembed-Filter is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle-oembed-Filter.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Filter for component 'filter_oembed'
 *
 * @package   filter_oembed
 * @copyright 2012 Matthew Cannings, Sandwell College; modified 2015 by Microsoft Open Technologies, Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * code based on the following filters...
 * Screencast (Mark Schall)
 * Soundcloud (Troy Williams)
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $torf = array('1' => get_string('yes'), '0' => get_string('no'));
    $item = new admin_setting_configselect('filter_oembed/youtube', get_string('youtube', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/vimeo', get_string('vimeo', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/ted', get_string('ted', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/slideshare', get_string('slideshare', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/officemix', get_string('officemix', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/issuu', get_string('issuu', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/soundcloud', get_string('soundcloud', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/pollev', get_string('pollev', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/o365video', get_string('o365video', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/sway', get_string('sway', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);

    // New provider method.
    $providers = \filter_oembed::get_supported_providers();
    foreach ($providers as $provider) {
        $enabledkey = 'provider_'.$provider.'_enabled';
        $name = get_string('provider_'.$provider, 'filter_oembed');
        $item = new \admin_setting_configselect('filter_oembed/'.$enabledkey, $name, '', 1, $torf);
        $settings->add($item);
    }

    $item = new admin_setting_configcheckbox('filter_oembed/lazyload', new lang_string('lazyload', 'filter_oembed'), '', 0);
    $settings->add($item);
}
