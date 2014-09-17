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
 * Online users block settings.
 *
 * @package    block_online_users
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('block_yammer_clientid', get_string('clientid', 'block_yammer'),
                   get_string('clientiddetails', 'block_yammer'), 30, PARAM_ALPHANUMEXT));
    $settings->add(new admin_setting_configtext('block_yammer_clientsecret', get_string('clientsecret', 'block_yammer'),
                   get_string('clientsecretdetails', 'block_yammer'), 50, PARAM_ALPHANUMEXT));
    $settings->add(new admin_setting_configtext('block_yammer_redirect', get_string('redirect', 'block_yammer'),
                   get_string('redirectdetails', 'block_yammer'), 90, PARAM_URL));
    
                   
}

