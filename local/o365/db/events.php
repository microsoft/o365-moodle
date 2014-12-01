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
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

$observers = [
    [
        'eventname'   => '\auth_oidc\event\user_loggedin',
        'callback'    => '\local_o365\observers::handle_oidc_login',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\auth_oidc\event\user_authed',
        'callback'    => '\local_o365\observers::handle_oidc_authed',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\calendar_event_created',
        'callback'    => '\local_o365\observers::handle_calendar_event_created',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\calendar_event_updated',
        'callback'    => '\local_o365\observers::handle_calendar_event_updated',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\calendar_event_deleted',
        'callback'    => '\local_o365\observers::handle_calendar_event_deleted',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\local_o365\event\calendar_subscribed',
        'callback'    => '\local_o365\observers::handle_calendar_subscribed',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\local_o365\event\calendar_unsubscribed',
        'callback'    => '\local_o365\observers::handle_calendar_unsubscribed',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\user_enrolment_deleted',
        'callback'    => '\local_o365\observers::handle_user_enrolment_deleted',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\course_deleted',
        'callback'    => '\local_o365\observers::handle_course_deleted',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\auth_oidc\event\user_created',
        'callback'    => '\local_o365\observers::handle_oidc_user_created',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\user_deleted',
        'callback'    => '\local_o365\observers::handle_user_deleted',
        'priority'    => 200,
        'internal'    => false,
    ],
];