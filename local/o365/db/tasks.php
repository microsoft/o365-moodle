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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$tasks = [
    [
        'classname' => 'local_o365\task\refreshsystemrefreshtoken',
        'blocking' => 0,
        'minute' => '1',
        'hour' => '1',
        'day' => '*',
        'dayofweek' => '3',
        'month' => '*'
    ],
    [
        'classname' => 'local_o365\task\usersync',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '1',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ],
    [
        'classname' => 'local_o365\task\groupcreate',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '*',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ],
    [
        'classname' => 'local_o365\feature\calsync\task\importfromoutlook',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '*',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ],
    [
        'classname' => 'local_o365\task\processmatchqueue',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '*',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ],
    [
        'classname' => 'local_o365\feature\sds\task\sync',
        'blocking' => 0,
        'minute' => '1',
        'hour' => '3',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ],
];
