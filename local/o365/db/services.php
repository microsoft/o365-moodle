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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

$functions = [
    'local_o365_create_onenoteassignment' => [
        'classname' => '\local_o365\webservices\create_onenoteassignment',
        'methodname' => 'assignment_create',
        'classpath' => 'local/o365/classes/webservices/create_onenoteassignment.php',
        'description' => 'Create an assignment',
        'type' => 'write',
    ],
    'local_o365_get_onenoteassignment' => [
        'classname' => '\local_o365\webservices\read_onenoteassignment',
        'methodname' => 'assignment_read',
        'classpath' => 'local/o365/classes/webservices/read_onenoteassignment.php',
        'description' => 'Get an assignment',
        'type' => 'read',
    ],
    'local_o365_update_onenoteassignment' => [
        'classname' => '\local_o365\webservices\update_onenoteassignment',
        'methodname' => 'assignment_update',
        'classpath' => 'local/o365/classes/webservices/update_onenoteassignment.php',
        'description' => 'Update an assignment',
        'type' => 'write',
    ],
    'local_o365_delete_onenoteassignment' => [
        'classname' => '\local_o365\webservices\delete_onenoteassignment',
        'methodname' => 'assignment_delete',
        'classpath' => 'local/o365/classes/webservices/delete_onenoteassignment.php',
        'description' => 'Delete an assignment',
        'type' => 'write',
    ],
];

// Pre-built service.
$services = [
    'Moodle Office 365 Webservices' => [
        'functions' => [
            'local_o365_create_onenoteassignment',
            'local_o365_get_onenoteassignment',
            'local_o365_update_onenoteassignment',
            'local_o365_delete_onenoteassignment',
        ],
        'restrictedusers' => 0,
        'enabled' => 0,
        'shortname' => 'o365_webservices',
    ]
];
