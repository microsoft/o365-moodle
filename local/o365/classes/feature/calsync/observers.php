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
 * Observer functions used by the calendar sync feature.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\calsync;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/lib/filelib.php');

/**
 * Observer functions used by the calendar sync feature.
 */
class observers {
    /** @var bool Flag indicating whether we're currently importing events. */
    public static $importingevents = false;

    /**
     * Set class static flag indicating whether we're currently importing events.
     *
     * @param bool $status Import status.
     */
    public static function set_event_import($status) {
        static::$importingevents = $status;
    }

    /**
     * Handle user_enrolment_deleted event to clean up calendar subscriptions.
     *
     * @param \core\event\user_enrolment_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_user_enrolment_deleted(\core\event\user_enrolment_deleted $event) {
        global $DB;
        if (\local_o365\utils::is_connected() !== true) {
            return false;
        }

        $userid = $event->relateduserid;
        $courseid = $event->courseid;

        if (empty($userid) || empty($courseid)) {
            return true;
        }

        // Clean up calendar subscriptions.
        $calsubparams = ['user_id' => $userid, 'caltype' => 'course', 'caltypeid' => $courseid];
        $subscriptions = $DB->get_recordset('local_o365_calsub', $calsubparams);
        foreach ($subscriptions as $subscription) {
            $eventdata = [
                'objectid' => $subscription->id,
                'userid' => $userid,
                'other' => [
                    'caltype' => 'course',
                    'caltypeid' => $courseid,
                ],
            ];
            $event = \local_o365\event\calendar_unsubscribed::create($eventdata);
            $event->trigger();
        }

        $subscriptions->close();
        $DB->delete_records('local_o365_calsub', $calsubparams);
        return true;
    }

    /**
     * Handle course_deleted event
     *
     * Does the following:
     *     - clean up calendar subscriptions.
     *
     * @param \core\event\course_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_course_deleted(\core\event\course_deleted $event) {
        global $DB;
        $courseid = $event->objectid;
        $DB->delete_records('local_o365_calsub', ['caltype' => 'course', 'caltypeid' => $courseid]);
        return true;
    }

    /**
     * Handle a calendar_event_created event.
     *
     * @param \core\event\calendar_event_created $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_calendar_event_created(\core\event\calendar_event_created $event) {
        if (\local_o365\utils::is_connected() !== true) {
            return false;
        }

        if (static::$importingevents === true) {
            return true;
        }

        $task = new \local_o365\feature\calsync\task\synccalendarevent();
        $task->set_custom_data(['eventid' => $event->objectid, 'action' => 'create']);
        \core\task\manager::queue_adhoc_task($task);
        return true;
    }

    /**
     * Handle a calendar_event_updated event.
     *
     * @param \core\event\calendar_event_updated $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_calendar_event_updated(\core\event\calendar_event_updated $event) {
        if (\local_o365\utils::is_connected() !== true) {
            return false;
        }

        $task = new \local_o365\feature\calsync\task\synccalendarevent();
        $task->set_custom_data(['eventid' => $event->objectid, 'action' => 'update']);
        \core\task\manager::queue_adhoc_task($task);
        return true;
    }

    /**
     * Handle a calendar_event_deleted event.
     *
     * @param \core\event\calendar_event_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_calendar_event_deleted(\core\event\calendar_event_deleted $event) {
        if (\local_o365\utils::is_connected() !== true) {
            return false;
        }

        // Falls back to a raw DB::get_record() call (returning false, not null) if no snapshot was
        // explicitly attached - normalise here so a bare false doesn't get handed to (int)$snapshot->x
        // below, which would silently coerce courseid/groupid to 0 instead of leaving snapshot unset.
        $snapshot = $event->get_record_snapshot('event', $event->objectid) ?: null;

        $task = new \local_o365\feature\calsync\task\synccalendarevent();
        $task->set_custom_data([
            'eventid' => $event->objectid,
            'action' => 'delete',
            'snapshot' => $snapshot
                ? ['courseid' => (int)$snapshot->courseid, 'groupid' => (int)$snapshot->groupid]
                : null,
        ]);
        \core\task\manager::queue_adhoc_task($task);
        return true;
    }

    /**
     * Handle a course_module_updated event.
     *
     * Editing a course module's "Restrict access" rules (or anything else affecting who can see it)
     * doesn't touch the calendar 'event' row at all, so no calendar_event_updated fires and the normal
     * observers never re-evaluate Outlook sync for it. Moodle's own calendar looks correct regardless,
     * since it recomputes visibility live on every render (see is_event_module_visible_to_user() in
     * \local_o365\feature\calsync\main) - but Outlook sync is event-driven, so it needs an explicit
     * trigger. course_module_updated doesn't tell us specifically whether availability changed, so this
     * queues a reconciliation task for every calendar event tied to the module on every edit.
     *
     * @param \core\event\course_module_updated $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_course_module_updated(\core\event\course_module_updated $event) {
        if (\local_o365\utils::is_connected() !== true) {
            return false;
        }

        $modulename = $event->other['modulename'] ?? null;
        $instanceid = $event->other['instanceid'] ?? null;

        if (empty($modulename) || empty($instanceid)) {
            return true;
        }

        $task = new \local_o365\feature\calsync\task\syncmoduleavailability();
        $task->set_custom_data([
            'modulename' => $modulename,
            'instanceid' => $instanceid,
        ]);
        \core\task\manager::queue_adhoc_task($task);

        return true;
    }

    /**
     * Handle a group_member_added event.
     *
     * A group-based "Restrict access" rule doesn't just change when the rule itself is edited - it also
     * changes whenever the affected user's group membership changes, which editing the module obviously
     * doesn't cover. See handle_group_member_removed() and queue_user_availability_sync() for details.
     *
     * @param \core\event\group_member_added $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_group_member_added(\core\event\group_member_added $event) {
        return static::queue_user_availability_sync($event->courseid, $event->relateduserid);
    }

    /**
     * Handle a group_member_removed event.
     *
     * @param \core\event\group_member_removed $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_group_member_removed(\core\event\group_member_removed $event) {
        return static::queue_user_availability_sync($event->courseid, $event->relateduserid);
    }

    /**
     * Queue an adhoc task to re-check Outlook sync for one user's group-restricted events in a course.
     *
     * @param int $courseid The course the group membership change happened in.
     * @param int $userid The user whose group membership changed.
     * @return bool Success/Failure.
     */
    protected static function queue_user_availability_sync($courseid, $userid) {
        if (\local_o365\utils::is_connected() !== true) {
            return false;
        }

        if (empty($courseid) || empty($userid)) {
            return true;
        }

        $task = new \local_o365\feature\calsync\task\syncuseravailability();
        $task->set_custom_data([
            'courseid' => $courseid,
            'userid' => $userid,
        ]);
        \core\task\manager::queue_adhoc_task($task);

        return true;
    }

    /**
     * Handle calendar_subscribed event - queue calendar sync jobs for cron.
     *
     * @param \local_o365\event\calendar_subscribed $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_calendar_subscribed(\local_o365\event\calendar_subscribed $event) {
        if (\local_o365\utils::is_connected() !== true) {
            return false;
        }

        $eventdata = $event->get_data();
        $calsubscribe = new \local_o365\feature\calsync\task\syncoldevents();
        $calsubscribe->set_custom_data([
            'caltype' => $eventdata['other']['caltype'],
            'caltypeid' => ((isset($eventdata['other']['caltypeid'])) ? $eventdata['other']['caltypeid'] : 0),
            'userid' => $eventdata['userid'],
            'timecreated' => time(),
        ]);
        \core\task\manager::queue_adhoc_task($calsubscribe);
        return true;
    }

    /**
     * Handle calendar_unsubscribed event - queue calendar sync jobs for cron.
     *
     * @param \local_o365\event\calendar_unsubscribed $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_calendar_unsubscribed(\local_o365\event\calendar_unsubscribed $event) {
        if (\local_o365\utils::is_connected() !== true) {
            return false;
        }

        $eventdata = $event->get_data();
        $calunsubscribe = new \local_o365\feature\calsync\task\syncoldevents();
        $calunsubscribe->set_custom_data([
            'caltype' => $eventdata['other']['caltype'],
            'caltypeid' => ((isset($eventdata['other']['caltypeid'])) ? $eventdata['other']['caltypeid'] : 0),
            'userid' => $eventdata['userid'],
            'timecreated' => time(),
        ]);
        \core\task\manager::queue_adhoc_task($calunsubscribe);
        return true;
    }

    /**
     * Handle a mod_assign extension_granted event.
     *
     * mod_assign\assign::save_user_extension() updates or deletes the underlying calendar 'event' record
     * with direct SQL when an extension is re-granted or revoked, bypassing calendar_event::update() and
     * calendar_event::delete(). This means \core\event\calendar_event_updated/deleted never fire for those
     * two cases, so the normal calendar sync observers never see the change.
     *
     * extension_granted itself, however, is always triggered - for grants, re-grants, and revokes alike -
     * and it fires before that raw SQL runs. Registering this as an internal (synchronous) observer means
     * it executes at that same point: assign_user_flags has already been saved with the new extension
     * date, but the 'event' table still holds the pre-change record. That lets us diff old vs. new state
     * to work out what needs reconciling in Outlook for the two cases core's own events miss. A
     * first-time grant needs no special handling here, since core creates the event via
     * calendar_event::create(), which fires calendar_event_created and is handled normally by
     * handle_calendar_event_created().
     *
     * This only does cheap, local DB reads/writes. The actual Outlook sync involves outbound Graph API
     * calls, which would add latency to the teacher's grant-extension request and hold this request's
     * transaction open for longer than necessary if made inline here - so instead this only captures a
     * snapshot of what changed and queues an adhoc task (\local_o365\feature\calsync\task\
     * syncassignextension) to make those calls after the request has committed.
     *
     * @param \mod_assign\event\extension_granted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_assign_extension_granted(\mod_assign\event\extension_granted $event) {
        global $DB;

        if (\local_o365\utils::is_connected() !== true) {
            return false;
        }

        $assignid = $event->objectid;
        $userid = $event->relateduserid;

        $flags = $DB->get_record('assign_user_flags', ['assignment' => $assignid, 'userid' => $userid]);
        $newextensionduedate = (!empty($flags)) ? (int) $flags->extensionduedate : 0;

        // Still the pre-change record - see method docblock.
        $oldevent = $DB->get_record('event', [
            'modulename' => 'assign',
            'instance' => $assignid,
            'userid' => $userid,
            'eventtype' => 'extension',
        ]);

        if (empty($oldevent)) {
            return true;
        }

        if (empty($newextensionduedate)) {
            // Extension is being revoked - core is about to delete the event record directly.
            $action = 'delete';
        } else if ((int) $oldevent->timestart !== $newextensionduedate) {
            // Extension date is being changed - core is about to update the event record directly.
            $action = 'update';
        } else {
            return true;
        }

        $task = new \local_o365\feature\calsync\task\syncassignextension();
        $task->set_custom_data([
            'action' => $action,
            'event' => $oldevent,
            'newextensionduedate' => $newextensionduedate,
        ]);
        \core\task\manager::queue_adhoc_task($task);

        return true;
    }

    /**
     * Handle user_deleted event - clean up calendar subscriptions, mapping, and settings.
     *
     * @param \core\event\user_deleted $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_user_deleted(\core\event\user_deleted $event) {
        global $DB;
        $userid = $event->objectid;
        $DB->delete_records('local_o365_calsub', ['user_id' => $userid]);
        $DB->delete_records('local_o365_calidmap', ['userid' => $userid]);
        $DB->delete_records('local_o365_calsettings', ['user_id' => $userid]);

        return true;
    }
}
