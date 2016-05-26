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
 * @copyright 2012 Matthew Cannings, Sandwell College; modified 2015 by Microsoft, Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * code based on the following filters...
 * Screencast (Mark Schall)
 * Soundcloud (Troy Williams)
 */

defined('MOODLE_INTERNAL') || die;

require_once(__DIR__.'/filter.php');

if ($ADMIN->fulltree) {
    $torf = array('1' => new lang_string('yes'), '0' => new lang_string('no'));
    $item = new admin_setting_configselect('filter_oembed/youtube', new lang_string('youtube', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/vimeo', new lang_string('vimeo', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/ted', new lang_string('ted', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/slideshare', new lang_string('slideshare', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/officemix', new lang_string('officemix', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/issuu', new lang_string('issuu', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/soundcloud', new lang_string('soundcloud', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/pollev', new lang_string('pollev', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/o365video', new lang_string('o365video', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);
    $item = new admin_setting_configselect('filter_oembed/sway', new lang_string('sway', 'filter_oembed'), '', 1, $torf);
    $settings->add($item);

    // New provider method.
    $providers = \filter_oembed::get_supported_providers();
    foreach ($providers as $provider) {
        $enabledkey = 'provider_'.$provider.'_enabled';
        $name = new lang_string('provider_'.$provider, 'filter_oembed');
        $item = new \admin_setting_configselect('filter_oembed/'.$enabledkey, $name, '', 1, $torf);
        $settings->add($item);
    }

    $item = new admin_setting_configcheckbox('filter_oembed/lazyload', new lang_string('lazyload', 'filter_oembed'), '', 0);
    $settings->add($item);
    $retrylist = array('0' => new lang_string('none'), '1' => new lang_string('once', 'filter_oembed'),
                                                  '2' => new lang_string('times', 'filter_oembed', '2'),
                                                  '3' => new lang_string('times', 'filter_oembed', '3'));
    $item = new admin_setting_configselect('filter_oembed/retrylimit', new lang_string('retrylimit', 'filter_oembed'), '', '1', $retrylist);
    $settings->add($item);
}
