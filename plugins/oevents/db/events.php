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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.
defined('MOODLE_INTERNAL') || die();


$handlers = array(
    'course_created'      => array(
        'handlerfile'     => '/local/oevents/lib.php',
        'handlerfunction' => 'on_course_created',
        'schedule'        => 'instant'
    ),
    'course_deleted'      => array(
        'handlerfile'     => '/local/oevents/lib.php',
        'handlerfunction' => 'on_course_deleted',
        'schedule'        => 'instant'
    ),
);

$observers = array(
    array(
        'eventname'   => '\core\event\user_enrolment_created',
        'callback'    => 'on_user_enrolment_created',
        'includefile' => '/local/oevents/lib.php'
    ),
    array(
        'eventname'   => '\core\event\user_enrolment_deleted',
        'callback'    => 'on_user_enrolment_deleted',
        'includefile' => '/local/oevents/lib.php',
    ),
    array(
        'eventname'   => '\core\event\calendar_event_created',
        'callback'    => 'on_calendar_event_created',
        'includefile' => '/local/oevents/lib.php'
    ),
    array(
        'eventname'   => '\core\event\calendar_event_deleted',
        'callback'    => 'on_calendar_event_deleted',
        'includefile' => '/local/oevents/lib.php',
    ),
);