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
 * Gets data from DB about the meeting.
 *
 * @package    atto_teamsmeeting
 * @copyright  2020 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../../../config.php');
require_once(__DIR__ . '/locallib.php');

require_login();

$url = required_param('url', PARAM_URL);
$newwindow = optional_param('newwindow', false, PARAM_BOOL);
$result = '';
if (!empty($url)) {
    $record = atto_teamsmeeting_get_meeting($url);
    $result = atto_teamsmeeting_meeting_url($record, $newwindow);
}

echo $result;
die();
