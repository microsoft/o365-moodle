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
 * Sync of Moodle groups to private channels in the Microsoft Team connected to the course.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\coursesync;

use core_text;
use local_o365\rest\unified;
use moodle_exception;
use stdClass;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/local/o365/lib.php');
require_once($CFG->libdir . '/grouplib.php');

/**
 * Creates a private channel in the Microsoft Team of a course for each Moodle group in the course, and keeps the channel
 * members in line with the group members. Synchronization is only ever from Moodle to Microsoft Teams.
 */
class groupchannels {
    /** @var string The type of the local_o365_objects records that map Moodle groups to channels. */
    public const OBJECT_TYPE = 'channel';

    /** @var string The subtype of the local_o365_objects records that map Moodle groups to channels. */
    public const OBJECT_SUBTYPE = 'moodlegroup';

    /** @var string The groups whose channel still needs work. */
    protected const KIND_INCOMPLETE = 'incomplete';

    /** @var string The groups that have no channel yet. */
    protected const KIND_WITHOUT_CHANNEL = 'withoutchannel';

    /** @var string The groups that have a channel with nothing outstanding. */
    protected const KIND_WITH_CHANNEL = 'withchannel';

    /** @var int The maximum length of a channel name in Microsoft Teams. */
    public const MAX_CHANNEL_NAME_LENGTH = 50;

    /** @var int The maximum length of a channel description in Microsoft Teams. */
    public const MAX_CHANNEL_DESCRIPTION_LENGTH = 1024;

    /** @var unified The Microsoft Graph client. */
    protected $graphclient;

    /** @var main|null The course sync object. */
    protected $coursesync = null;

    /** @var int The indentation level of the output of this class. */
    protected $tracelevel = 0;

    /** @var string[] The Microsoft names of users, by lowercase object ID, to show in the output. */
    protected $userlabels = [];

    /**
     * Constructor.
     *
     * @param unified $graphclient A Microsoft Graph client using the application token.
     */
    public function __construct(unified $graphclient) {
        $this->graphclient = $graphclient;
    }

    /**
     * Whether channels are created for Moodle groups on this site.
     *
     * @return bool
     */
    public static function is_enabled(): bool {
        return !empty(get_config('local_o365', 'coursesyncgroupchannels')) &&
            utils::is_enabled() &&
            (int)get_config('local_o365', 'courseusersyncdirection') !== COURSE_USER_SYNC_DIRECTION_TEAMS_TO_MOODLE;
    }

    /**
     * Get the object ID of the Microsoft Team connected to a course.
     *
     * @param int $courseid The Moodle course ID.
     * @return string|null The object ID, or null if the course has no Team.
     */
    public static function get_team_object_id(int $courseid): ?string {
        global $DB;

        $objectid = $DB->get_field_select(
            'local_o365_objects',
            'objectid',
            "type = 'group' AND subtype IN ('courseteam', 'teamfromgroup') AND moodleid = ?",
            [$courseid],
            IGNORE_MULTIPLE
        );

        return $objectid ?: null;
    }

    /**
     * Whether the groups of a course get channels in the course's Team.
     *
     * @param int $courseid The Moodle course ID.
     * @return bool
     */
    public static function is_course_eligible(int $courseid): bool {
        return static::is_enabled() &&
            utils::is_course_sync_enabled($courseid) &&
            static::get_team_object_id($courseid) !== null;
    }

    /**
     * Turn a Moodle group name into a valid Microsoft Teams channel name.
     *
     * Channel names are at most 50 characters, can't contain ~ # % & * { } + / \ : < > ? | ' ", can't start with an
     * underscore or period or end with a period, and can't be "General".
     *
     * @param string $groupname The name of the Moodle group.
     * @param int $groupid The ID of the Moodle group, used if nothing usable is left of the name.
     * @return string
     */
    public static function get_channel_name(string $groupname, int $groupid): string {
        $name = preg_replace('/[~#%&*{}+\/\\\\:<>?|\'"]/u', '-', $groupname);
        $name = preg_replace('/[\x00-\x1F\x7F]/u', '', $name);
        $name = trim(preg_replace('/\s+/u', ' ', $name));
        $name = core_text::substr($name, 0, static::MAX_CHANNEL_NAME_LENGTH);
        $name = rtrim(ltrim($name, '_.'), '. ');

        if ($name === '' || core_text::strtolower($name) === 'general') {
            $name = core_text::substr($name === '' ? 'Group' : $name, 0, static::MAX_CHANNEL_NAME_LENGTH - 12) . ' ' . $groupid;
        }

        return $name;
    }

    /**
     * Queue a task to sync the channel of a Moodle group soon.
     *
     * @param int $groupid The Moodle group ID.
     * @param int $delay The number of seconds to wait before the task runs.
     * @return bool Whether a task was queued.
     */
    public static function queue_group_sync(int $groupid, int $delay = 0): bool {
        if (!static::is_enabled() || !\local_o365\utils::is_connected()) {
            return false;
        }

        $task = new \local_o365\task\groupchannelsyncgroup();
        $task->set_custom_data(['groupid' => $groupid]);
        if ($delay > 0) {
            $task->set_next_run_time(time() + $delay);
        }

        \core\task\manager::queue_adhoc_task($task, true);

        return true;
    }

    /**
     * Queue tasks to sync the channels of all the groups in a Moodle course.
     *
     * @param int $courseid The Moodle course ID.
     * @param int $delay The number of seconds to wait before the tasks run, for example to let a new Team get ready.
     * @return int The number of tasks queued.
     */
    public static function queue_course_groups_sync(int $courseid, int $delay = 0): int {
        global $DB;

        $count = 0;
        foreach ($DB->get_fieldset_select('groups', 'id', 'courseid = ?', [$courseid], 'id') as $groupid) {
            if (static::queue_group_sync((int)$groupid, $delay)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Note whether the channel of a group still needs work, such as students who couldn't be added yet.
     *
     * Groups noted as incomplete are retried before all other groups by the scheduled sync.
     *
     * @param int $groupid The Moodle group ID.
     * @param bool $incomplete Whether the channel needs another attempt.
     * @return void
     */
    protected function mark_incomplete(int $groupid, bool $incomplete): void {
        global $DB;

        $mapping = static::get_mapping($groupid);
        if (!$mapping) {
            return;
        }

        $metadata = json_decode((string)$mapping->metadata, true);
        $metadata = is_array($metadata) ? $metadata : [];
        if (!empty($metadata['incomplete']) === $incomplete) {
            return;
        }

        if ($incomplete) {
            $metadata['incomplete'] = true;
        } else {
            unset($metadata['incomplete']);
        }

        $DB->set_field('local_o365_objects', 'metadata', json_encode($metadata), ['id' => $mapping->id]);
    }

    /**
     * Get the record linking a Moodle group to its channel.
     *
     * @param int $groupid The Moodle group ID.
     * @return stdClass|false
     */
    public static function get_mapping(int $groupid) {
        global $DB;

        return $DB->get_record(
            'local_o365_objects',
            ['type' => static::OBJECT_TYPE, 'subtype' => static::OBJECT_SUBTYPE, 'moodleid' => $groupid]
        );
    }

    /**
     * Forget the channel of a Moodle group, without touching the channel itself in Microsoft Teams.
     *
     * @param int $groupid The Moodle group ID.
     * @return void
     */
    public static function forget_group(int $groupid): void {
        global $DB;

        $DB->delete_records(
            'local_o365_objects',
            ['type' => static::OBJECT_TYPE, 'subtype' => static::OBJECT_SUBTYPE, 'moodleid' => $groupid]
        );
    }

    /**
     * Whether an API error means the thing asked for doesn't exist.
     *
     * @param moodle_exception $e The exception.
     * @return bool
     */
    protected static function is_not_found_error(moodle_exception $e): bool {
        return stripos($e->getMessage(), 'not found') !== false || stripos($e->getMessage(), 'NotFound') !== false;
    }

    /**
     * Whether an API error means a channel with that name exists already.
     *
     * @param moodle_exception $e The exception.
     * @return bool
     */
    protected static function is_name_conflict_error(moodle_exception $e): bool {
        return stripos($e->getMessage(), 'already exist') !== false || stripos($e->getMessage(), 'NameAlreadyExists') !== false;
    }

    /**
     * Whether an API error means the user isn't a member of the Team yet.
     *
     * @param moodle_exception $e The exception.
     * @return bool
     */
    protected static function is_not_in_team_error(moodle_exception $e): bool {
        return stripos($e->getMessage(), 'team roster') !== false;
    }

    /**
     * Get the course sync object, which knows how to add a member to a Team and whether a Team is locked.
     *
     * @return main
     */
    protected function get_coursesync(): main {
        if ($this->coursesync === null) {
            $this->coursesync = new main($this->graphclient);
        }

        return $this->coursesync;
    }

    /**
     * Whether a Team limits its membership to its owners, as an education class Team does until an owner activates it.
     *
     * Students of such a Team can't be put in its channels yet.
     *
     * @param string $teamobjectid The object ID of the Team.
     * @return bool
     */
    protected function is_team_locked(string $teamobjectid): bool {
        return (bool)$this->get_coursesync()->is_team_locked($teamobjectid);
    }

    /**
     * Add a user to the Team, so the user can be put in a channel of it.
     *
     * Members added to the Team's Microsoft 365 group in bulk can take a while to show up in the Team, so this uses the
     * same way of adding a single member as the rest of the course sync, which puts the user in the Team straight away.
     *
     * @param string $teamobjectid The object ID of the Team.
     * @param string $userobjectid The object ID of the user.
     * @return bool Whether the user was added.
     */
    protected function add_user_to_team(string $teamobjectid, string $userobjectid): bool {
        try {
            $this->get_coursesync()->add_member_to_group($teamobjectid, $userobjectid);
        } catch (moodle_exception $e) {
            $this->mtrace(
                'Could not add ' . $this->get_user_label($userobjectid) . ' to the Team. Details: ' . $e->getMessage(),
                3
            );
            return false;
        }

        return true;
    }

    /**
     * Find the names to show in the output for some Microsoft 365 users.
     *
     * The user principal name is used when Moodle knows the user, otherwise the email or display name Microsoft gave.
     *
     * @param string[] $objectids The object IDs of the users.
     * @param array $currentmembers The current members of a channel, as returned by the Graph API.
     * @return void
     */
    protected function load_user_labels(array $objectids, array $currentmembers): void {
        global $DB;

        $missing = array_diff(array_unique(array_map('strtolower', $objectids)), array_keys($this->userlabels));
        if ($missing) {
            [$insql, $params] = $DB->get_in_or_equal($missing, SQL_PARAMS_NAMED);
            $records = $DB->get_recordset_sql(
                "SELECT objectid, o365name FROM {local_o365_objects} WHERE type = 'user' AND LOWER(objectid) $insql",
                $params
            );
            foreach ($records as $record) {
                $this->userlabels[strtolower($record->objectid)] = $record->o365name;
            }

            $records->close();
        }

        foreach ($currentmembers as $member) {
            $objectid = strtolower($member['userId'] ?? '');
            $label = $member['email'] ?? $member['displayName'] ?? '';
            if ($objectid !== '' && $label !== '' && !isset($this->userlabels[$objectid])) {
                $this->userlabels[$objectid] = $label;
            }
        }
    }

    /**
     * Get the name to show in the output for a Microsoft 365 user.
     *
     * @param string $objectid The object ID of the user.
     * @return string The user principal name if known, otherwise the object ID.
     */
    protected function get_user_label(string $objectid): string {
        return $this->userlabels[strtolower($objectid)] ?? $objectid;
    }

    /**
     * Set the indentation level of the output, so it fits in the output of whatever is calling this.
     *
     * @param int $level The indentation level.
     * @return void
     */
    public function set_trace_level(int $level): void {
        $this->tracelevel = $level;
    }

    /**
     * Print debugging information using mtrace.
     *
     * @param string $message The message.
     * @param int $level The indentation level, relative to the level set with set_trace_level().
     * @return void
     */
    protected function mtrace(string $message, int $level = 0): void {
        \local_o365\utils::mtrace($message, $this->tracelevel + $level);
    }

    /**
     * Get the object IDs of the Microsoft 365 users who should be owners and members of the channel of a group.
     *
     * Only members of the Moodle group who also have the role of a Team owner or member in the course, and are connected to
     * Microsoft 365, can be put in the channel, as the Team has to contain them as well.
     *
     * @param stdClass $group The Moodle group.
     * @return array[] Two lists of lowercase object IDs: the owners, then the other members.
     */
    protected function get_intended_members(stdClass $group): array {
        $groupuserids = array_keys(groups_get_members($group->id, 'u.id'));

        $owneruserids = array_intersect($groupuserids, utils::get_team_owner_user_ids_by_course_id($group->courseid));
        $memberuserids = array_diff(
            array_intersect($groupuserids, utils::get_team_member_user_ids_by_course_id($group->courseid)),
            $owneruserids
        );

        $owners = array_map('strtolower', utils::get_user_object_ids_by_user_ids($owneruserids));
        $members = array_map('strtolower', utils::get_user_object_ids_by_user_ids($memberuserids));

        return [array_values(array_unique($owners)), array_values(array_diff(array_unique($members), $owners))];
    }

    /**
     * Create the channel for a Moodle group.
     *
     * @param stdClass $group The Moodle group.
     * @param string $teamobjectid The object ID of the Team.
     * @param string $ownerobjectid The object ID of the user to be the first owner of the channel.
     * @return string|null The ID of the new channel, or null if it could not be created.
     */
    protected function create_channel(stdClass $group, string $teamobjectid, string $ownerobjectid): ?string {
        global $DB;

        $name = static::get_channel_name($group->name, $group->id);
        $description = core_text::substr(
            trim(html_entity_decode(strip_tags((string)$group->description), ENT_QUOTES)),
            0,
            static::MAX_CHANNEL_DESCRIPTION_LENGTH
        );

        $channel = null;
        try {
            try {
                $channel = $this->graphclient->create_private_channel($teamobjectid, $name, $description, $ownerobjectid);
            } catch (moodle_exception $e) {
                if (!static::is_name_conflict_error($e)) {
                    throw $e;
                }

                // Another channel is called the same, so make the name unique.
                $suffix = ' (' . $group->id . ')';
                $name = core_text::substr($name, 0, static::MAX_CHANNEL_NAME_LENGTH - core_text::strlen($suffix)) . $suffix;
                $this->mtrace('A channel with that name exists already. Using "' . $name . '".', 1);
                $channel = $this->graphclient->create_private_channel($teamobjectid, $name, $description, $ownerobjectid);
            }
        } catch (moodle_exception $e) {
            $this->mtrace('Could not create the channel. Details: ' . $e->getMessage(), 1);
            if (stripos($e->getMessage(), 'backend request') !== false) {
                $this->mtrace(
                    'Microsoft gave no reason. This is usually a delay on Microsoft\'s side while a new Team is being set up, ' .
                        'and the channel will be created on a later run.',
                    1
                );
            }

            return null;
        }

        $now = time();
        $DB->insert_record('local_o365_objects', (object)[
            'type' => static::OBJECT_TYPE,
            'subtype' => static::OBJECT_SUBTYPE,
            'objectid' => $channel['id'],
            'moodleid' => $group->id,
            'o365name' => $name,
            'tenant' => '',
            'metadata' => json_encode(['courseid' => (int)$group->courseid, 'teamobjectid' => $teamobjectid]),
            'timecreated' => $now,
            'timemodified' => $now,
        ]);
        $this->mtrace('Created the channel "' . $name . '".', 1);

        return $channel['id'];
    }

    /**
     * Create the channel of a Moodle group if it doesn't exist, and make its members the same as the members of the group.
     *
     * @param int $groupid The Moodle group ID.
     * @return bool Whether everything was done. False means something failed, and another attempt is needed.
     */
    public function sync_group(int $groupid): bool {
        global $DB;

        $group = $DB->get_record('groups', ['id' => $groupid]);
        if (!$group) {
            $this->mtrace('Process group #' . $groupid);
            static::forget_group($groupid);
            $this->mtrace('The group no longer exists.', 1);
            $this->mtrace('Finished processing group #' . $groupid);

            return true;
        }

        $this->mtrace('Process group #' . $group->id . ' (' . $group->name . ') in course #' . $group->courseid);
        $success = $this->sync_existing_group($group);
        $this->mark_incomplete((int)$group->id, !$success);
        $this->mtrace('Finished processing group #' . $group->id);

        return $success;
    }

    /**
     * Create the channel of a Moodle group that exists if it doesn't exist, and sync its members.
     *
     * @param stdClass $group The Moodle group.
     * @return bool Whether everything was done.
     */
    protected function sync_existing_group(stdClass $group): bool {
        global $DB;

        $groupid = (int)$group->id;

        if (!static::is_course_eligible((int)$group->courseid)) {
            $this->mtrace('The course is not synchronized to a Team, or channels are not enabled. Skipping.', 1);
            return true;
        }

        $teamobjectid = static::get_team_object_id((int)$group->courseid);

        [$owners, $members] = $this->get_intended_members($group);
        if (empty($owners)) {
            // A private channel needs an owner, so a Team owner of the course has to stand in until the group has one.
            $teamowners = array_map('strtolower', utils::get_team_owner_object_ids_by_course_id((int)$group->courseid));
            if (empty($teamowners)) {
                $this->mtrace('Neither the group nor the course has a Team owner who could own the channel. Skipping.', 1);
                return false;
            }

            $owners = [reset($teamowners)];
            $members = array_values(array_diff($members, $owners));
        }

        $mapping = static::get_mapping($groupid);
        if ($mapping) {
            $metadata = json_decode((string)$mapping->metadata, true);
            if (($metadata['teamobjectid'] ?? null) !== $teamobjectid) {
                // The course has been connected to a different Team.
                static::forget_group($groupid);
                $mapping = false;
            }
        }

        $channelid = $mapping ? $mapping->objectid : null;
        $current = null;
        if ($channelid) {
            try {
                $current = $this->graphclient->get_channel_members($teamobjectid, $channelid);
            } catch (moodle_exception $e) {
                if (!static::is_not_found_error($e)) {
                    $this->mtrace('Could not get the channel members. Details: ' . $e->getMessage(), 1);
                    return false;
                }

                $this->mtrace('The channel no longer exists.', 1);
                static::forget_group($groupid);
                $channelid = null;
            }
        }

        if (!$channelid) {
            $channelid = $this->create_channel($group, $teamobjectid, reset($owners));
            if (!$channelid) {
                return false;
            }

            try {
                $current = $this->graphclient->get_channel_members($teamobjectid, $channelid);
            } catch (moodle_exception $e) {
                $this->mtrace('Could not get the channel members. Details: ' . $e->getMessage(), 1);
                return false;
            }
        }

        $skipped = [];
        if ($this->is_team_locked($teamobjectid)) {
            // The students of a Team that hasn't been activated can't be put in channels yet. Keep the ones already in.
            $currentuserids = array_map('strtolower', array_column($current, 'userId'));
            $skipped = array_diff($members, $currentuserids);
            if ($skipped) {
                $this->mtrace(
                    'The Team has not been activated yet, so ' . count($skipped) .
                        ' student(s) can not be added to the channel until an owner activates it.',
                    1
                );
                $members = array_values(array_diff($members, $skipped));
            }
        }

        $success = $this->sync_channel_members($teamobjectid, $channelid, $owners, $members, $current) &&
            empty($skipped);

        $DB->set_field(
            'local_o365_objects',
            'timemodified',
            time(),
            ['type' => static::OBJECT_TYPE, 'subtype' => static::OBJECT_SUBTYPE, 'moodleid' => $groupid]
        );

        return $success;
    }

    /**
     * Sync the channels of the next few groups, going through all groups of the courses synchronized to a Team in turn.
     *
     * Three groups of groups are handled in turn, each with its own place in the rotation, so none can hold up the others:
     * - groups whose channel still needs work, such as one waiting for the students of a class Team to be activated;
     * - groups that have no channel yet, such as those of a course that has just got a Team;
     * - groups that have a channel, which are checked for differences that crept in.
     * Whatever a group of groups doesn't use of its share is left to the ones after it.
     *
     * Each call carries on from where the previous one stopped.
     *
     * @param int $limit The maximum number of groups to sync.
     * @return int The number of groups synced.
     */
    public function sync_next_groups(int $limit): int {
        $total = 0;

        $total += $this->sync_next_groups_of_kind(static::KIND_INCOMPLETE, (int)ceil($limit / 3));
        $total += $this->sync_next_groups_of_kind(static::KIND_WITHOUT_CHANNEL, (int)ceil(($limit - $total) * 2 / 3));
        $total += $this->sync_next_groups_of_kind(static::KIND_WITH_CHANNEL, $limit - $total);

        return $total;
    }

    /**
     * Sync the next few groups of one kind.
     *
     * @param string $kind One of the KIND_* constants.
     * @param int $limit The maximum number of groups to sync.
     * @return int The number of groups synced.
     */
    protected function sync_next_groups_of_kind(string $kind, int $limit): int {
        global $DB;

        if ($limit < 1) {
            return 0;
        }

        $descriptions = [
            static::KIND_INCOMPLETE => 'that need another attempt',
            static::KIND_WITHOUT_CHANNEL => 'that have no channel yet',
            static::KIND_WITH_CHANNEL => 'that have a channel',
        ];
        $description = $descriptions[$kind];
        $this->mtrace('Process groups ' . $description . '...');

        $cursorname = 'groupchannelsynccursor_' . $kind;
        $cursor = (int)get_config('local_o365', $cursorname);

        $flagparam = '%"incomplete":true%';
        if ($kind === static::KIND_INCOMPLETE) {
            $channelcondition = 'EXISTS (SELECT 1 FROM {local_o365_objects} c
                                          WHERE c.type = :channeltype AND c.subtype = :channelsubtype AND c.moodleid = g.id
                                            AND ' . $DB->sql_like('c.metadata', ':flag') . ')';
        } else if ($kind === static::KIND_WITH_CHANNEL) {
            $channelcondition = 'EXISTS (SELECT 1 FROM {local_o365_objects} c
                                          WHERE c.type = :channeltype AND c.subtype = :channelsubtype AND c.moodleid = g.id
                                            AND (c.metadata IS NULL OR ' .
                $DB->sql_like('c.metadata', ':flag', true, true, true) . '))';
        } else {
            $channelcondition = 'NOT EXISTS (SELECT 1 FROM {local_o365_objects} c
                                              WHERE c.type = :channeltype AND c.subtype = :channelsubtype AND c.moodleid = g.id)';
        }

        $sql = "SELECT g.id, g.courseid
                  FROM {groups} g
                 WHERE g.id > :cursor
                   AND EXISTS (SELECT 1
                                 FROM {local_o365_objects} o
                                WHERE o.type = 'group'
                                  AND o.subtype IN ('courseteam', 'teamfromgroup')
                                  AND o.moodleid = g.courseid)
                   AND $channelcondition
              ORDER BY g.id";
        $params = ['cursor' => $cursor, 'channeltype' => static::OBJECT_TYPE, 'channelsubtype' => static::OBJECT_SUBTYPE];
        if ($kind !== static::KIND_WITHOUT_CHANNEL) {
            $params['flag'] = $flagparam;
        }

        $groups = $DB->get_recordset_sql($sql, $params);

        $count = 0;
        $reachedend = true;
        $currentcourseid = 0;
        $baselevel = $this->tracelevel;
        foreach ($groups as $group) {
            if (!static::is_course_eligible((int)$group->courseid)) {
                continue;
            }

            if ($count >= $limit) {
                $reachedend = false;
                break;
            }

            if ((int)$group->courseid !== $currentcourseid) {
                if ($currentcourseid) {
                    $this->mtrace('Finished processing course #' . $currentcourseid, 1);
                }

                $currentcourseid = (int)$group->courseid;
                $shortname = $DB->get_field('course', 'shortname', ['id' => $currentcourseid]);
                $this->mtrace('Process course #' . $currentcourseid . ' (' . $shortname . ')', 1);
            }

            $this->tracelevel = $baselevel + 2;
            try {
                $this->sync_group((int)$group->id);
            } finally {
                $this->tracelevel = $baselevel;
            }

            $cursor = (int)$group->id;
            $count++;
        }

        $groups->close();

        if ($currentcourseid) {
            $this->mtrace('Finished processing course #' . $currentcourseid, 1);
        } else {
            $this->mtrace('No groups to process.', 1);
        }

        $this->mtrace('Finished processing groups ' . $description . '. Synced ' . $count . ' group(s).');

        set_config($cursorname, $reachedend ? 0 : $cursor, 'local_o365');

        return $count;
    }

    /**
     * Make the members of a channel the intended ones.
     *
     * Owners are added and promoted before anyone is demoted or removed, so the channel is never left without an owner.
     *
     * @param string $teamobjectid The object ID of the Team.
     * @param string $channelid The ID of the channel.
     * @param string[] $owners The object IDs of the users who should own the channel.
     * @param string[] $members The object IDs of the users who should be members, but not owners, of the channel.
     * @param array $current The current members of the channel, as returned by the Graph API.
     * @return bool Whether all changes were made.
     */
    protected function sync_channel_members(
        string $teamobjectid,
        string $channelid,
        array $owners,
        array $members,
        array $current
    ): bool {
        $success = true;

        $currentbyuser = [];
        foreach ($current as $member) {
            if (empty($member['userId']) || empty($member['id'])) {
                continue;
            }

            $currentbyuser[strtolower($member['userId'])] = [
                'membershipid' => $member['id'],
                'owner' => in_array('owner', $member['roles'] ?? []),
            ];
        }

        $this->load_user_labels(array_merge($owners, $members, array_keys($currentbyuser)), $current);

        $this->mtrace('Owners: ' . count($owners) . ', members: ' . count($members), 1);

        $changes = [];
        foreach ($owners as $objectid) {
            if (!isset($currentbyuser[$objectid])) {
                $changes[] = ['add', $objectid, true];
            } else if (!$currentbyuser[$objectid]['owner']) {
                $changes[] = ['role', $objectid, true];
            }
        }

        foreach ($members as $objectid) {
            if (!isset($currentbyuser[$objectid])) {
                $changes[] = ['add', $objectid, false];
            } else if ($currentbyuser[$objectid]['owner']) {
                $changes[] = ['role', $objectid, false];
            }
        }

        $intended = array_flip(array_merge($owners, $members));
        foreach ($currentbyuser as $objectid => $unused) {
            if (!isset($intended[$objectid])) {
                $changes[] = ['remove', $objectid, false];
            }
        }

        // Adding and promoting owners come first in the list of changes, and removals last.
        foreach ($changes as [$action, $objectid, $owner]) {
            try {
                switch ($action) {
                    case 'add':
                        try {
                            $this->graphclient->add_member_to_channel($teamobjectid, $channelid, $objectid, $owner);
                        } catch (moodle_exception $e) {
                            if (!static::is_not_in_team_error($e) || !$this->add_user_to_team($teamobjectid, $objectid)) {
                                throw $e;
                            }

                            $this->mtrace(
                                $this->get_user_label($objectid) . ' was not in the Team yet, so added them to it first.',
                                3
                            );
                            $this->graphclient->add_member_to_channel($teamobjectid, $channelid, $objectid, $owner);
                        }

                        $this->mtrace('Added ' . $this->get_user_label($objectid) . ($owner ? ' as owner' : ''), 2);
                        break;
                    case 'role':
                        $this->graphclient->update_channel_member_role(
                            $teamobjectid,
                            $channelid,
                            $currentbyuser[$objectid]['membershipid'],
                            $owner
                        );
                        $this->mtrace(($owner ? 'Promoted ' : 'Demoted ') . $this->get_user_label($objectid), 2);
                        break;
                    case 'remove':
                        $this->graphclient->remove_member_from_channel(
                            $teamobjectid,
                            $channelid,
                            $currentbyuser[$objectid]['membershipid']
                        );
                        $this->mtrace('Removed ' . $this->get_user_label($objectid), 2);
                        break;
                }
            } catch (moodle_exception $e) {
                $success = false;
                $this->mtrace(
                    'Could not ' . $action . ' ' . $this->get_user_label($objectid) . '. Details: ' . $e->getMessage(),
                    2
                );
            }
        }

        return $success;
    }
}
