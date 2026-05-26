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
 * Web service definition for Tiny Teams Meeting plugin.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'tiny_teamsmeeting_get_meeting_details' => [
        'classname' => '\tiny_teamsmeeting\external\get_meeting_details',
        'description' => 'Get existing meeting details',
        'type' => 'read',
        'ajax' => true,
        'services' => ['tiny_teamsmeeting_service'],
    ],
];

$services = [
    'tiny_teamsmeeting_service' => [
        'functions' => ['tiny_teamsmeeting_get_meeting_details'],
        'restrictedusers' => 0,
        'enabled' => 1,
    ],
];
