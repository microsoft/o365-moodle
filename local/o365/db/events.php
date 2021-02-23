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

$observers = [
    // User groups
    [
        'eventname'   => '\core\event\group_created',
        'callback'    => '\local_o365\feature\usergroups\observers::handle_group_created',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\group_deleted',
        'callback'    => '\local_o365\feature\usergroups\observers::handle_group_deleted',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\group_updated',
        'callback'    => '\local_o365\feature\usergroups\observers::handle_group_updated',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\group_member_added',
        'callback'    => '\local_o365\feature\usergroups\observers::handle_group_member_added',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\group_member_removed',
        'callback'    => '\local_o365\feature\usergroups\observers::handle_group_member_removed',
        'priority'    => 200,
        'internal'    => false,
    ],

    // Calendar sync.
    [
        'eventname'   => '\core\event\user_enrolment_deleted',
        'callback'    => '\local_o365\feature\calsync\observers::handle_user_enrolment_deleted',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\course_deleted',
        'callback'    => '\local_o365\feature\calsync\observers::handle_course_deleted',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\calendar_event_created',
        'callback'    => '\local_o365\feature\calsync\observers::handle_calendar_event_created',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\calendar_event_updated',
        'callback'    => '\local_o365\feature\calsync\observers::handle_calendar_event_updated',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\calendar_event_deleted',
        'callback'    => '\local_o365\feature\calsync\observers::handle_calendar_event_deleted',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\local_o365\event\calendar_subscribed',
        'callback'    => '\local_o365\feature\calsync\observers::handle_calendar_subscribed',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\local_o365\event\calendar_unsubscribed',
        'callback'    => '\local_o365\feature\calsync\observers::handle_calendar_unsubscribed',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\user_deleted',
        'callback'    => '\local_o365\feature\calsync\observers::handle_user_deleted',
        'priority'    => 200,
        'internal'    => false,
    ],

    // Events from auth_oidc.
    [
        'eventname'   => '\auth_oidc\event\user_authed',
        'callback'    => '\local_o365\observers::handle_oidc_user_authed',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\auth_oidc\event\user_connected',
        'callback'    => '\local_o365\observers::handle_oidc_user_connected',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\auth_oidc\event\user_disconnected',
        'callback'    => '\local_o365\observers::handle_oidc_user_disconnected',
        'priority'    => 200,
        'internal'    => true,
    ],
    [
        'eventname'   => '\auth_oidc\event\user_loggedin',
        'callback'    => '\local_o365\observers::handle_oidc_user_loggedin',
        'priority'    => 200,
        'internal'    => false,
    ],

    // Events from core.
    [
        'eventname'   => '\core\event\user_enrolment_created',
        'callback'    => '\local_o365\observers::handle_user_enrolment_created',
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
        'eventname'   => '\core\event\user_enrolment_updated',
        'callback'    => '\local_o365\observers::handle_user_enrolment_updated',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\role_assigned',
        'callback'    => '\local_o365\observers::handle_role_assigned',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\role_unassigned',
        'callback'    => '\local_o365\observers::handle_role_unassigned',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\role_capabilities_updated',
        'callback'    => '\local_o365\observers::handle_role_capabilities_updated',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\role_deleted',
        'callback'    => '\local_o365\observers::handle_role_deleted',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\course_created',
        'callback'    => '\local_o365\observers::handle_course_created',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\course_updated',
        'callback'    => '\local_o365\observers::handle_course_updated',
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
        'eventname'   => '\core\event\user_created',
        'callback'    => '\local_o365\observers::handle_user_created',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\user_deleted',
        'callback'    => '\local_o365\observers::handle_user_deleted',
        'priority'    => 200,
        'internal'    => true,
    ],
    [
        'eventname'   => '\core\event\notification_sent',
        'callback'    => '\local_o365\observers::handle_notification_sent',
        'priority'    => 200,
        'internal'    => false,
    ],
    [
        'eventname'   => '\core\event\config_log_created',
        'callback'    => '\local_o365\observers::handle_config_log_created',
        'priority'    => 200,
        'internal'    => true,
    ],
    [
        'eventname'   => '\core\event\course_reset_started',
        'callback'    => '\local_o365\feature\usergroups\observers::handle_course_reset_started',
        'priority'    => 200,
        'internal'    => true,
    ],
];
