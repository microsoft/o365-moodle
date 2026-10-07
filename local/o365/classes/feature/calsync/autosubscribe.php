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
 * Automatic calendar subscription helper for the calendar sync feature.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\calsync;

/**
 * Automatic calendar subscription helper for the calendar sync feature.
 *
 * When the site is configured as "opt-out", users who are connected to Microsoft 365 get Outlook calendar sync
 * enabled, and are subscribed to the calendars of all courses they are enrolled in, without having to do it
 * manually on their calendar sync settings page. They can still change or turn off everything on that page.
 */
class autosubscribe {
    /** @var string Users must enable calendar sync and subscribe to calendars themselves (default). */
    public const MODE_OPTIN = 'optin';

    /** @var string Calendar sync and course calendar subscriptions are enabled automatically. */
    public const MODE_OPTOUT = 'optout';

    /** @var string User preference recording that a user's calendar sync choices have been initialised. */
    public const PREF_INITIALISED = 'local_o365_calsync_initialised';

    /** @var string Calendar type for the site calendar. */
    public const TYPE_SITE = 'site';

    /** @var string Calendar type for the user's personal calendar. */
    public const TYPE_USER = 'user';

    /** @var string Calendar type for course calendars. */
    public const TYPE_COURSE = 'course';

    /** @var string[] Calendar types subscribed to automatically unless the admin has chosen otherwise. */
    public const DEFAULT_TYPES = [self::TYPE_USER, self::TYPE_COURSE];

    /**
     * Get the calendar types users are subscribed to automatically in opt-out mode.
     *
     * @return string[] Any of TYPE_SITE, TYPE_USER and TYPE_COURSE.
     */
    public static function get_subscribe_types(): array {
        $config = get_config('local_o365', 'calsyncsubscribetypes');
        if ($config === false) {
            return self::DEFAULT_TYPES;
        }

        return array_values(array_intersect(
            [self::TYPE_SITE, self::TYPE_USER, self::TYPE_COURSE],
            explode(',', $config)
        ));
    }

    /**
     * Whether the site is configured to subscribe users to calendars automatically.
     *
     * @return bool
     */
    public static function is_optout_mode(): bool {
        return get_config('local_o365', 'calsyncsubscribemode') === self::MODE_OPTOUT;
    }

    /**
     * Whether a user's calendar sync choices have already been initialised, either automatically or by the user.
     *
     * Once set, automatic enabling is never applied again, so a user who turns calendar sync off stays opted out.
     *
     * @param int $userid The Moodle user ID.
     * @return bool
     */
    public static function is_initialised(int $userid): bool {
        return !empty(get_user_preferences(self::PREF_INITIALISED, null, $userid));
    }

    /**
     * Record that a user's calendar sync choices have been initialised.
     *
     * @param int $userid The Moodle user ID.
     * @return void
     */
    public static function mark_initialised(int $userid): void {
        set_user_preference(self::PREF_INITIALISED, 1, $userid);
    }

    /**
     * Enable calendar sync for a user and subscribe them to the calendar types chosen by the admin.
     *
     * Does nothing if the user's choices have already been initialised.
     *
     * @param int $userid The Moodle user ID.
     * @return int|null The number of calendars subscribed to, or null if the user was already initialised.
     */
    public static function initialise_user(int $userid): ?int {
        global $DB;

        if (self::is_initialised($userid)) {
            return null;
        }

        self::mark_initialised($userid);

        if (!$DB->record_exists('local_o365_calsettings', ['user_id' => $userid])) {
            $DB->insert_record('local_o365_calsettings', (object)[
                'user_id' => $userid,
                'o365calid' => '',
                'timecreated' => time(),
            ]);
        }

        $types = self::get_subscribe_types();
        $subscribed = 0;

        if (in_array(self::TYPE_SITE, $types) && self::subscribe($userid, self::TYPE_SITE, 0)) {
            $subscribed++;
        }

        if (in_array(self::TYPE_USER, $types) && self::subscribe($userid, self::TYPE_USER, $userid)) {
            $subscribed++;
        }

        if (in_array(self::TYPE_COURSE, $types)) {
            foreach (enrol_get_users_courses($userid, true, ['id']) as $course) {
                if (self::subscribe_course($userid, (int)$course->id)) {
                    $subscribed++;
                }
            }
        }

        return $subscribed;
    }

    /**
     * Subscribe a user to a course calendar, syncing from Moodle to their primary Outlook calendar.
     *
     * @param int $userid The Moodle user ID.
     * @param int $courseid The course ID.
     * @return bool Whether a new subscription was created.
     */
    public static function subscribe_course(int $userid, int $courseid): bool {
        return self::subscribe($userid, self::TYPE_COURSE, $courseid);
    }

    /**
     * Subscribe a user to a calendar, syncing from Moodle to their primary Outlook calendar.
     *
     * @param int $userid The Moodle user ID.
     * @param string $caltype The calendar type, one of the TYPE_* constants.
     * @param int $caltypeid The course ID for course calendars, the user ID for personal calendars, or 0 for the site.
     * @return bool Whether a new subscription was created.
     */
    protected static function subscribe(int $userid, string $caltype, int $caltypeid): bool {
        global $DB;

        $subparams = ['user_id' => $userid, 'caltype' => $caltype, 'caltypeid' => $caltypeid];
        if ($DB->record_exists('local_o365_calsub', $subparams)) {
            return false;
        }

        $subid = $DB->insert_record('local_o365_calsub', (object)($subparams + [
            'o365calid' => '',
            'syncbehav' => 'out',
            'isprimary' => 1,
            'timecreated' => time(),
        ]));

        \local_o365\event\calendar_subscribed::create([
            'objectid' => $subid,
            'userid' => $userid,
            'other' => ['caltype' => $caltype, 'caltypeid' => ($caltype === self::TYPE_COURSE) ? $caltypeid : 0],
        ])->trigger();

        return true;
    }
}
