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
 * Boost o365teams.
 *
 * @package    theme_boost_o365teams
 * @copyright  2018 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use theme_boost_o365teams\css_processor;

if ($ADMIN->fulltree) {

    $themename = 'boost_o365teams';
    $themedir = $CFG->dirroot . '/theme/' . $themename;
    $component = 'theme_' . $themename;
    $theme = theme_config::load($themename);

    // If theme is being installed for the first time, show all settings and expand all collapsible containers.
    // This will prevent uninitialized defaults.
    $wasinstalled = (isset ($theme->settings->enablestyleoverrides)) ? true : false;

    $settings = new theme_boost_admin_settingspage_tabs('themesettingboost_o365teams', get_string('configtitle', 'theme_boost'));

    // Add logo stamp.
    $name = "theme_boost_o365teams/footer_stamp";
    $title = get_string('footer_stamp_title', 'theme_boost_o365teams');
    $description = get_string('footer_stamp_desc', 'theme_boost_o365teams');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footer_stamp');

    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

}
