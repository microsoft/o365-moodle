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

namespace local_o365\feature\usergroups;

use context_course;

define('API_CALL_RETRY_LIMIT', 3);

class coursegroups {
    const NAME_OPTION_FULL_NAME = 1;
    const NAME_OPTION_SHORT_NAME = 2;
    const NAME_OPTION_ID = 3;
    const NAME_OPTION_ID_NUMBER = 4;

    protected $graphclient;
    protected $DB;
    protected $debug = false;

    /**
     * Constructor.
     *
     * @param \local_o365\rest\unified $graphclient A graph API client to use.
     * @param \moodle_database $DB An active database connection.
     * @param bool $debug Whether to ouput debug messages.
     */
    public function __construct(\local_o365\rest\unified $graphclient, \moodle_database $DB, $debug = false) {
        $this->graphclient = $graphclient;
        $this->DB = $DB;
        $this->debug = $debug;
    }

    /**
     * Optionally run mtrace() based on $this->debug setting.
     *
     * @param string $msg The debug message.
     */
    protected function mtrace($msg, $eol = "\n") {
        if ($this->debug === true) {
            mtrace($msg, $eol);
        }
    }

    /**
     * Create teams and populate membership for all courses that don't have an associated team recorded.
     */
    public function create_groups_for_new_courses() {
        $createteams = get_config('local_o365', 'createteams');
        if ($createteams === 'onall' || $createteams === 'oncustom') {
            $coursesenabled = \local_o365\feature\usergroups\utils::get_enabled_courses();
            if (empty($coursesenabled)) {
                $this->mtrace('Custom group creation is enabled, but no courses are enabled.');
                return false;
            }
        } else {
            $this->mtrace('Group creation is disabled.');
            return false;
        }

        if (is_array($coursesenabled)) {
            list($coursesinsql, $coursesparams) = $this->DB->get_in_or_equal($coursesenabled);
        } else {
            $coursesinsql = '';
            $coursesparams = [];
        }

        // First process courses with groups that have been "soft-deleted".
        $sql = 'SELECT crs.id as courseid,
                       obj.*
                  FROM {course} crs
                  JOIN {local_o365_objects} obj ON obj.type = ? AND obj.subtype = ? AND obj.moodleid = crs.id';
        $params = ['group', 'course'];
        if (!empty($coursesinsql)) {
            $sql .= ' WHERE crs.id '.$coursesinsql;
            $params = array_merge($params, $coursesparams);
        }
        $objectrecs = $this->DB->get_recordset_sql($sql, $params);
        foreach ($objectrecs as $objectrec) {
            $metadata = (!empty($objectrec->metadata)) ? @json_decode($objectrec->metadata, true) : [];
            if (is_array($metadata) && !empty($metadata['softdelete'])) {
                $this->mtrace('Attempting to restore group for course #'.$objectrec->courseid);
                $result = $this->restore_group($objectrec->id, $objectrec->objectid, $metadata);
                if ($result === true) {
                    $this->mtrace('....success!');
                } else {
                    $this->mtrace('....failed. Group may have been deleted for too long.');
                }
            }
        }

        // Process courses without an associated group.
        $sql = 'SELECT crs.*
                  FROM {course} crs
             LEFT JOIN {local_o365_objects} obj ON obj.type = ? AND obj.subtype = ? AND obj.moodleid = crs.id
                 WHERE obj.id IS NULL AND crs.id != ?';
        $params = ['group', 'course', SITEID];
        if (!empty($coursesinsql)) {
            $sql .= ' AND crs.id '.$coursesinsql;
            $params = array_merge($params, $coursesparams);
        }
        $courses = $this->DB->get_recordset_sql($sql, $params, 0, 5);
        $coursesprocessed = 0;
        foreach ($courses as $course) {
            $coursesprocessed++;
            $createclassteam = false;
            $creategrouponly = true;
            $ownerid = null;
            $teacherid = null;

            if (\local_o365\feature\usergroups\utils::course_is_group_feature_enabled($course->id, 'team')) {
                $creategrouponly = false;
                $teacherids = static::get_team_owner_ids_by_course_id($course->id);
                foreach ($teacherids as $teacherid) {
                    if ($ownerid = $this->DB->get_field('local_o365_objects', 'objectid',
                        ['type' => 'user', 'moodleid' => $teacherid])) {
                        $createclassteam = true;
                        break;
                    }
                }
            }

            if ($createclassteam) {
                // Create class team directly.
                try {
                    $objectrec = $this->create_class_team($course, $ownerid);
                } catch (\Exception $e) {
                    $this->mtrace('Could not create class team for course #' . $course->id . '. Reason: ' . $e->getMessage());
                    continue;
                }
            } else if ($creategrouponly || get_config('local_o365', 'group_creation_fallback') == true) {
                // Create group.
                try {
                    $objectrec = $this->create_group($course);
                } catch (\Exception $e) {
                    $this->mtrace('Could not create group for course #' . $course->id . '. Reason: ' . $e->getMessage());
                    continue;
                }
            } else {
                // Option to fall back to group is disabled, and Team owner is not found.
                $this->mtrace('Skip creating class team for course #' . $course->id . '. Reason: missing Team owner');
                continue;
            }

            try {
                $this->resync_group_membership($course->id, $objectrec['objectid']);
            } catch (\Exception $e) {
                $this->mtrace('Could not sync users to group for course #'.$course->id.'. Reason: '.$e->getMessage());
                continue;
            }
        }
        if (empty($coursesprocessed)) {
            $this->mtrace('All courses have a group recorded.');
        } else {
            $this->mtrace('Processed courses: '.$coursesprocessed);
        }
        $courses->close();

        // Process team sync changes
        $sql = 'SELECT crs.*
                  FROM {course} crs
             LEFT JOIN {local_o365_objects} obj_g ON obj_g.type = ? AND obj_g.subtype = ? AND obj_g.moodleid = crs.id
             LEFT JOIN {local_o365_objects} obj_t ON obj_t.type = ? AND obj_t.subtype = ? AND obj_t.moodleid = crs.id
                 WHERE obj_g.id IS NOT NULL
                   AND obj_t.id IS NULL
                   AND crs.id != ?';
        $params = ['group', 'course', 'group', 'courseteam', SITEID];
        if (!empty($coursesinsql)) {
            $sql .= ' AND crs.id ' . $coursesinsql;
            $params = array_merge($params, $coursesparams);
        }
        $courses = $this->DB->get_recordset_sql($sql, $params);
        $coursesprocessed = 0;

        // Get app ID.
        if (!empty($courses)) {
            $appid = get_config('local_o365', 'moodle_app_id');
        }

        foreach ($courses as $course) {
            if (\local_o365\feature\usergroups\utils::course_is_group_feature_enabled($course->id, 'team')) {
                $this->mtrace('Attempting to create team for course #' . $course->id . '...');
                $coursesprocessed++;
                $groupobjectrec = $this->DB->get_record('local_o365_objects',
                    ['type' => 'group', 'subtype' => 'course', 'moodleid' => $course->id]);
                if (empty($groupobjectrec)) {
                    $errmsg = 'Could not find group object ID in local_o365_objects for course ' . $course->id;
                    $errmsg .= 'Please ensure group exists first.';
                    $this->mtrace($errmsg);
                    continue;
                }
                $teacherids = static::get_team_owner_ids_by_course_id($course->id);
                $hasowner = false;
                foreach ($teacherids as $teacherid) {
                    if ($ownerid = $this->DB->get_field('local_o365_objects', 'objectid',
                        ['type' => 'user', 'moodleid' => $teacherid])) {
                        $hasowner = true;
                        break;
                    }
                }
                if ($hasowner) {
                    try {
                        $this->create_team($course->id, $groupobjectrec->objectid, $appid);
                    } catch (\Exception $e) {
                        $this->mtrace('Could not create team for course #' . $course->id . '. Reason: ' . $e->getMessage());
                    }
                } else {
                    $this->mtrace('Skip creating team for course #' . $course->id . '. Reason: No owner');
                }
            }
        }
    }

    /**
     * Restore a deleted group.
     *
     * @param int $objectrecid The id of the local_o365_objects record.
     * @param string $objectid The O365 object id of the group.
     * @param array $objectrecmetadata The metadata of the object database record.
     */
    public function restore_group($objectrecid, $objectid, $objectrecmetadata) {
        global $DB;
        $deletedgroups = $this->graphclient->list_deleted_groups();
        if (is_array($deletedgroups) && !empty($deletedgroups['value'])) {
            foreach ($deletedgroups['value'] as $deletedgroup) {
                if (!empty($deletedgroup) && isset($deletedgroup['id']) && $deletedgroup['id'] == $objectid) {
                    // Deleted group found.
                    $this->graphclient->restore_deleted_group($objectid);
                    $updatedobjectrec = new \stdClass;
                    $updatedobjectrec->id = $objectrecid;
                    unset($objectrecmetadata['softdelete']);
                    $updatedobjectrec->metadata = json_encode($objectrecmetadata);
                    $DB->update_record('local_o365_objects', $updatedobjectrec);
                    return true;
                }
            }
        }
        // No deleted group found. May have expired. Delete our record.
        $DB->delete_records('local_o365_objects', ['id' => $objectrecid]);
        return false;
    }

    /**
     * Create a Microsoft 365 unified group for a Moodle course.
     *
     * @param stdClass $course A course record.
     *
     * @return array Array form of the created local_o365_objects record.
     */
    public function create_group($course) {
        $now = time();

        $groupname = static::get_group_display_name($course);
        $groupshortname = static::get_group_mail_alias($course);

        $extra = null;
        if (!empty($course->summary)) {
            $description = strip_tags($course->summary);
            if (strlen($description) > 1024) {
                $description = shorten_text($description, 1024, true, ' ...');
            }
            $extra = [
                'description' => $description,
            ];
        }
        try {
            $response = $this->graphclient->create_group($groupname, $groupshortname, $extra);
        } catch (\Exception $e) {
            $this->mtrace('Could not create group for course #'.$course->id.'. Reason: '.$e->getMessage());
            return false;
        }

        $this->mtrace('Created group '.$response['id'].' for course #'.$course->id);
        $objectrec = [
            'type' => 'group',
            'subtype' => 'course',
            'objectid' => $response['id'],
            'moodleid' => $course->id,
            'o365name' => $groupname,
            'timecreated' => $now,
            'timemodified' => $now,
        ];
        $objectrec['id'] = $this->DB->insert_record('local_o365_objects', (object)$objectrec);
        $this->mtrace('Recorded group object ('.$objectrec['objectid'].') into object table with record id '.$objectrec['id']);
        return $objectrec;
    }

    /**
     * Create a Microsoft 365 class team for a Moodle course.
     *
     * @param \stdClass $course
     * @param int $ownerid
     *
     * @return array|false
     * @throws \dml_exception
     */
    public function create_class_team(\stdClass $course, $ownerid) {
        $now = time();
        $displayname = $this->get_team_display_name($course);
        $description = $course->summary;
        $extra = null;

        try {
            $teamid = null;
            $response = $this->graphclient->create_class_team($displayname, $description, $ownerid);

            if (is_array($response) && array_key_exists('Location', $response)) {
                $location = $response['Location'];
                $locationparts = explode('/', $location);
                foreach ($locationparts as $locationpart) {
                    if (substr($locationpart, 0, 5) == 'teams') {
                        $teamid = substr($locationpart, 7, 36);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->mtrace('Could not create class team for #' . $course->id . '. Reason: ' . $e->getMessage());
            return false;
        }

        if (is_null($teamid)) {
            $this->mtrace('Could not create class team for #' . $course->id . '. Reason: invalid team ID');
            return false;
        }

        $this->mtrace('Created class team ' . $teamid . ' for course #' . $course->id);

        // Record group object.
        $groupobjectrec = [
            'type' => 'group',
            'subtype' => 'course',
            'objectid' => $teamid,
            'moodleid' => $course->id,
            'o365name' => $displayname,
            'timecreated' => $now,
            'timemodified' => $now,
        ];
        $groupobjectrec['id'] = $this->DB->insert_record('local_o365_objects', (object)$groupobjectrec);
        $this->mtrace('Recorded group object (' . $groupobjectrec['objectid'] . ') into object table with record id ' .
            $groupobjectrec['id']);

        // Record team object.
        $teamobjectrec = [
            'type' => 'group',
            'subtype' => 'courseteam',
            'objectid' => $teamid,
            'moodleid' => $course->id,
            'o365name' => $displayname,
            'timecreated' => $now,
            'timemodified' => $now,
        ];
        $teamobjectrec['id'] = $this->DB->insert_record('local_o365_objects', (object)$teamobjectrec);
        $this->mtrace('Recorded team object (' . $teamobjectrec['objectid'] . ') into object table with record id ' .
            $teamobjectrec['id']);

        $moodleappid = get_config('local_o365', 'moodle_app_id');
        if (!empty($moodleappid)) {
            // Provision app to the newly created team.
            $retrycounter = 0;
            $moodleappprovisioned = false;
            while ($retrycounter <= API_CALL_RETRY_LIMIT) {
                if ($retrycounter) {
                    $this->mtrace('..... Retry #' . $retrycounter);
                    sleep(10);
                }
                try {
                    if ($this->graphclient->provision_app($teamobjectrec['objectid'], $moodleappid)) {
                        $moodleappprovisioned = true;
                        break;
                    }
                } catch (\Exception $e) {
                    $this->mtrace('Could not add app to team for course #' . $course->id . '. Reason: ' . $e->getMessage());
                    $retrycounter++;
                }
            }

            // List all channels.
            if ($moodleappprovisioned) {
                try {
                    $generalchanelid = $this->graphclient->get_general_channel_id($teamobjectrec['objectid']);
                } catch (\Exception $e) {
                    $this->mtrace('Could not list channels in team for course #' . $course->id . '. Reason: ' . $e->getMessage());
                    $generalchanelid = false;
                }

                if ($generalchanelid) {
                    // Add tab to channel.
                    try {
                        $this->graphclient->add_moodle_tab_to_channel($teamobjectrec['objectid'], $generalchanelid, $moodleappid,
                            $course->id);
                    } catch (\Exception $e) {
                        $this->mtrace('Could not add Moodle tab to channel in team for course #' . $course->id .
                            '. Reason : '. $e->getMessage());
                    }
                }
            }
        }

        return $teamobjectrec;
    }

    /**
     * Return the display name of Team for the given course according to configuration.
     *
     * @param \stdClass $course
     *
     * @return string
     */
    public static function get_team_display_name(\stdClass $course) {
        $teamdisplayname = '';
        
        $teamnameprefix = get_config('local_o365', 'team_name_prefix');
        if ($teamnameprefix) {
            $teamdisplayname = $teamnameprefix;
        }

        $teamnamecourse = get_config('local_o365', 'team_name_course');
        switch ($teamnamecourse) {
            case static::NAME_OPTION_FULL_NAME:
                $teamdisplayname .= $course->fullname;
                break;
            case static::NAME_OPTION_SHORT_NAME:
                $teamdisplayname .= $course->shortname;
                break;
            case static::NAME_OPTION_ID:
                $teamdisplayname .= $course->id;
                break;
            case static::NAME_OPTION_ID_NUMBER:
                $teamdisplayname .= $course->idnumber;
                break;
            default:
                $teamdisplayname .= $course->fullname;
        }

        $teamnamesuffix = get_config('local_o365', 'team_name_suffix');
        if ($teamnamesuffix) {
            $teamdisplayname .= $teamnamesuffix;
        }

        return $teamdisplayname;
    }

    /**
     * Return the team display name to be used on the sample course according to the current settings.
     *
     * @return string
     */
    public static function get_sample_team_display_name() {
        $teamgroupamesamplecourse = static::get_team_group_name_sample_course();
        
        return static::get_team_display_name($teamgroupamesamplecourse);
    }

    /**
     * Return the display name of group for the given course according to configuration.
     *
     * @param \stdClass $course
     * @param \stdClass|null $group
     *
     * @return string
     */
    public static function get_group_display_name(\stdClass $course, \stdClass $group = null) {
        $groupdisplayname = '';

        $groupdisplaynameprefix = get_config('local_o365', 'group_display_name_prefix');
        if ($groupdisplaynameprefix) {
            $groupdisplayname = $groupdisplaynameprefix;
        }

        $groupdisplaynamecourse = get_config('local_o365', 'group_display_name_course');
        switch ($groupdisplaynamecourse) {
            case static::NAME_OPTION_FULL_NAME:
                $groupdisplayname .= $course->fullname;
                break;
            case static::NAME_OPTION_SHORT_NAME:
                $groupdisplayname .= $course->shortname;
                break;
            case static::NAME_OPTION_ID:
                $groupdisplayname .= $course->id;
                break;
            case static::NAME_OPTION_ID_NUMBER:
                $groupdisplayname .= $course->idnumber;
                break;
            default:
                $groupdisplayname .= $course->fullname;
        }

        if ($group) {
            $groupdisplayname .= $group->name;
        }

        $groupdisplaynamesuffix = get_config('local_o365', 'group_display_name_suffix');
        if ($groupdisplaynamesuffix) {
            $groupdisplayname .= $groupdisplaynamesuffix;
        }

        return $groupdisplayname;
    }

    /**
     * Return the email alias of group for the given course according to configuration.
     *
     * @param \stdClass $course
     * @param \stdClass|null $group
     *
     * @return string
     */
    public static function get_group_mail_alias(\stdClass $course, \stdClass $group = null) {
        $groupmailaliasprefix = get_config('local_o365', 'group_mail_alias_prefix');
        if ($groupmailaliasprefix) {
            $groupmailaliasprefix = static::clean_up_group_mail_alias($groupmailaliasprefix);
        }

        $groupmailaliassuffix = get_config('local_o365', 'group_mail_alias_suffix');
        if ($groupmailaliassuffix) {
            $groupmailaliassuffix = static::clean_up_group_mail_alias($groupmailaliassuffix);
        }

        $groupmailaliascourse = get_config('local_o365', 'group_mail_alias_course');
        switch ($groupmailaliascourse) {
            case static::NAME_OPTION_FULL_NAME:
                $coursepart = $course->fullname;
                break;
            case static::NAME_OPTION_SHORT_NAME:
                $coursepart = $course->shortname;
                break;
            case static::NAME_OPTION_ID:
                $coursepart = $course->id;
                break;
            case static::NAME_OPTION_ID_NUMBER:
                $coursepart = $course->idnumber;
                break;
            default:
                $coursepart = $course->shortname;
        }
        
        if ($group) {
            $grouppart = $group->id . '_' . $group->name;
            $grouppart = static::clean_up_group_mail_alias($grouppart);
            if (strlen($grouppart) > 16) {
                $grouppart = substr($grouppart, 0, 16);
            }
            $grouppart = '-' . $grouppart;
        } else {
            $grouppart = '';
        }

        $coursepart = static::clean_up_group_mail_alias($coursepart);

        $coursepartmaxlength = 64 - strlen($groupmailaliasprefix) - strlen($groupmailaliassuffix) - strlen($grouppart);
        if (strlen($coursepart) > $coursepartmaxlength) {
            $coursepart = substr($coursepart, 0, $coursepartmaxlength);
        }

        return $groupmailaliasprefix . $coursepart . $grouppart . $groupmailaliassuffix;
    }

    /**
     * Remove unsupported characters from the mail alias parts, and return the result.
     *
     * @param string $mailalias
     *
     * @return string|string[]|null
     */
    public static function clean_up_group_mail_alias($mailalias) {
        return preg_replace('/[^a-z0-9-_]+/iu', '', $mailalias);
    }

    /**
     * Return the display name and the mail alias of the group of the sample course.
     *
     * @return array
     */
    public static function get_sample_group_names() {
        $samplegroupnames = [];

        $samplecourse = static::get_team_group_name_sample_course();
        $samplegroupnames['displayname'] = static::get_group_display_name($samplecourse);
        $samplegroupnames['mailalias'] = static::get_group_mail_alias($samplecourse);

        return $samplegroupnames;
    }

    /**
     * Return a stdClass object representing a course object to be used for Team / group naming convention example.
     *
     * @return \stdClass
     */
    public static function get_team_group_name_sample_course() {
        $samplecourse = new \stdClass();
        $samplecourse->fullname = 'Sample course 15';
        $samplecourse->shortname = 'sample 15';
        $samplecourse->id = 2;
        $samplecourse->idnumber = 'Sample ID 15';

        return $samplecourse;
    }

    /**
     * Get the IDs of all present groups.
     *
     * @return array An array of group IDs.
     */
    public function get_all_group_ids() {
        $groupids = [];
        $groups = $this->graphclient->get_groups();
        foreach ($groups['value'] as $group) {
            $groupids[] = $group['id'];
        }
        while (!empty($groups['@odata.nextLink'])) {
            // Extract skiptoken.
            $nextlink = parse_url($groups['@odata.nextLink']);
            if (isset($nextlink['query'])) {
                $query = [];
                parse_str($nextlink['query'], $query);
                if (isset($query['$skiptoken'])) {
                    $groups = $this->graphclient->get_groups($query['$skiptoken']);
                    foreach ($groups['value'] as $group) {
                        if (!in_array($group['id'], $groupids)) {
                            $groupids[] = $group['id'];
                        }
                    }
                } else {
                    $groups = [];
                }
            }
        }
        return $groupids;
    }

    /**
     * Resync the membership of a course group based on the users enrolled in the associated course.
     *
     * @param int $courseid The ID of the course.
     * @param string $groupobjectid The object ID of the Microsoft 365 group.
     *
     * @return array|false
     */
    public function resync_group_membership($courseid, $groupobjectid = null) {
        $this->mtrace('Syncing group membership for course #'.$courseid);

        if ($groupobjectid === null) {
            $params = [
                'type' => 'group',
                'subtype' => 'course',
                'moodleid' => $courseid,
            ];
            $objectrec = $this->DB->get_record('local_o365_objects', $params);
            if (empty($objectrec)) {
                $errmsg = 'Could not find group object ID in local_o365_objects for course '.$courseid.'. ';
                $errmsg .= 'Please ensure group exists first.';
                $this->mtrace($errmsg);
                return false;
            }
            $groupobjectid = $objectrec->objectid;
        }

        $this->mtrace('Syncing to group "'.$groupobjectid.'"');

        // Get current group membership.
        $members = $this->graphclient->get_group_members($groupobjectid);
        $owners = $this->graphclient->get_group_owners($groupobjectid);
        $currentmembers = [];
        $currentowners = [];
        foreach ($members['value'] as $member) {
            $currentmembers[] = $member['id'];
        }
        foreach ($owners['value'] as $owner) {
            $currentowners[] = $owner['id'];
        }

        // Get intended group members.
        $intendedteamownerids = static::get_team_owner_ids_by_course_id($courseid);
        $intendedteammemberuserids = $this->get_team_member_ids_by_course_id($courseid);

        $intendedteamowners = static::get_user_object_ids_by_user_ids($intendedteamownerids);
        $intendedteammembers = static::get_user_object_ids_by_user_ids($intendedteammemberuserids);

        if (!empty($currentowners)) {
            $toaddowners = array_diff($intendedteamowners, $currentowners);
            $toremoveowners = array_diff($currentowners, $intendedteamowners);
        } else {
            $toaddowners = $intendedteamowners;
            $toremoveowners = [];
        }

        if (!empty($currentmembers)) {
            $toaddmembers = array_diff($intendedteammembers, $currentmembers);
            $toremovemembers = array_diff($currentmembers, $intendedteammembers);
        } else {
            $toaddmembers = $intendedteammembers;
            $toremovemembers = [];
        }

        // Check if group object is created
        $this->mtrace('... Checking if group is setup ...', '');
        $retrycounter = 0;
        while ($retrycounter <= API_CALL_RETRY_LIMIT) {
            try {
                if ($retrycounter) {
                    $this->mtrace('...... Retry #' . $retrycounter);
                    sleep(10);
                }
                $result = $this->graphclient->get_group($groupobjectid);
                if (!empty($result['id'])) {
                    $this->mtrace('Success!');
                    break;
                } else {
                    $this->mtrace('Error!');
                    $this->mtrace('...... Received: ' . \local_o365\utils::tostring($result));
                    $retrycounter++;
                }
            } catch (\Exception $e) {
                $this->mtrace('Error!');
                $this->mtrace('...... Received: ' . $e->getMessage());
                $retrycounter++;
            }
        }

        // Remove owners.
        $this->mtrace('Owners to remove: ' . count($toremoveowners));
        foreach ($toremoveowners as $userobjectid) {
            $this->mtrace('... Removing ' . $userobjectid . '...', '');
            $result = $this->graphclient->remove_owner_from_group($groupobjectid, $userobjectid);
            if ($result === true) {
                $this->mtrace('Success!');
            } else {
                $this->mtrace('Error!');
                $this->mtrace('...... Received: '.\local_o365\utils::tostring($result));
            }
        }

        // Remove members.
        foreach ($toremovemembers as $key => $userobjectid) {
            if (in_array($userobjectid, $intendedteamowners)) {
                unset($toremovemembers[$key]);
            }
        }
        $this->mtrace('Members to remove: ' . count($toremovemembers));
        foreach ($toremovemembers as $userobjectid) {
            $this->mtrace('... Removing ' . $userobjectid . '...', '');
            $result = $this->graphclient->remove_member_from_group($groupobjectid, $userobjectid);
            if ($result === true) {
                $this->mtrace('Success!');
            } else {
                $this->mtrace('Error!');
                $this->mtrace('...... Received: '.\local_o365\utils::tostring($result));
            }
        }

        // Add owners.
        $this->mtrace('Owners to add: ' . count($toaddowners));
        foreach ($toaddowners as $userobjectid) {
            $this->mtrace('... Adding ' . $userobjectid . '...', '');
            $retrycounter = 0;
            while ($retrycounter <= API_CALL_RETRY_LIMIT) {
                if ($retrycounter) {
                    $this->mtrace('...... Retry #' . $retrycounter);
                    sleep(10);
                }
                $result = $this->graphclient->add_owner_to_group($groupobjectid, $userobjectid);
                if ($result === true) {
                    $this->mtrace('Success!');
                    break;
                } else {
                    $this->mtrace('Error!');
                    $this->mtrace('...... Received: ' . \local_o365\utils::tostring($result));
                    $retrycounter++;

                    if (strpos($result, 'Request_ResourceNotFound') === false) {
                        break;
                    }
                }
            }
        }

        // Add members.
        $this->mtrace('Members to add: ' . count($toaddmembers));
        foreach ($toaddmembers as $userobjectid) {
            $this->mtrace('... Adding ' . $userobjectid . '...', '');
            $retrycounter = 0;
            while ($retrycounter <= API_CALL_RETRY_LIMIT) {
                if ($retrycounter) {
                    $this->mtrace('...... Retry #' . $retrycounter);
                    sleep(10);
                }
                $result = $this->graphclient->add_member_to_group($groupobjectid, $userobjectid);
                if ($result === true) {
                    $this->mtrace('Success!');
                    break;
                } else {
                    $this->mtrace('Error!');
                    $this->mtrace('...... Received: ' . \local_o365\utils::tostring($result));
                    $retrycounter++;

                    if (strpos($result, 'Request_ResourceNotFound') === false) {
                        break;
                    }
                }
            }
        }

        $this->mtrace('Done');

        return [array_merge($toaddowners, $toaddmembers), array_merge($toremoveowners, $toremovemembers)];
    }

    /**
     * Helper function to retrieve users who have Team owner capability in the course with the given ID.
     *
     * @param int $courseid Id of Moodle course.
     *
     * @return array array containing ids of teachers.
     */
    public static function get_team_owner_ids_by_course_id($courseid) {
        $context = context_course::instance($courseid);
        $teamownerusers = get_users_by_capability($context, 'local/o365:teamowner', 'u.id, u.deleted');
        $teamowneruserids = [];
        foreach ($teamownerusers as $user) {
            if (!$user->deleted) {
                array_push($teamowneruserids, $user->id);
            }
        }

        return $teamowneruserids;
    }

    /**
     * Helper function to retrieve users who have Team member capability in the course with the given ID.
     *
     * @param $courseid
     *
     * @return array
     */
    public function get_team_member_ids_by_course_id($courseid) {
        $context = context_course::instance($courseid);
        $teammemberusers = get_users_by_capability($context, 'local/o365:teammember', 'u.id, u.deleted');
        $teammemberuserids = [];
        foreach ($teammemberusers as $user) {
            array_push($teammemberuserids, $user->id);
        }

        return $teammemberuserids;
    }

    /**
     * Return the list of o365_object IDs for the users with the given IDs.
     *
     * @param $userids
     *
     * @return array
     */
    public static function get_user_object_ids_by_user_ids($userids) {
        global $DB;

        if ($userids) {
            list($idsql, $idparams) = $DB->get_in_or_equal($userids);
            $sql = "SELECT objectid
                  FROM {local_o365_objects}
                 WHERE type = ?
                   AND moodleid {$idsql}";
            $params = array_merge(['user'], $idparams);
            return $DB->get_fieldset_sql($sql, $params);
        } else {
            return [];
        }
    }

    /**
     * Helper function to retrieve study group object.
     *
     * @param int $groupid Id of Moodle group.
     * @return object Object containing o365 object id.
     */
    public static function get_study_group_object($groupid) {
        global $DB;
        $params = [
            'type' => 'group',
            'subtype' => 'usergroup',
            'moodleid' => $groupid
        ];
        $object = $DB->get_record('local_o365_objects', $params);
        if (empty($object)) {
            return false;
        }
        return $object;
    }

    /**
     * Update a study group from a Moodle group.
     *
     * @param int $moodlegroupid Id of Moodle course group.
     * @return boolean True on success.
     */
    public function update_study_group($moodlegroupid) {
        global $DB;
        $caller = 'update_study_group';
        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }

        if (empty($this->graphclient)) {
            return false;
        }

        $grouprec = $DB->get_record('groups', ['id' => $moodlegroupid]);
        if (empty($grouprec)) {
            \local_o365\utils::debug('Could not find group with id "' . $moodlegroupid . '"', $caller);
            return false;
        }

        $courserec = $DB->get_record('course', ['id' => $grouprec->courseid]);
        if (empty($courserec)) {
            $msg = 'Could not find course with id "' . $grouprec->courseid . '" for group with id "' . $moodlegroupid . '"';
            \local_o365\utils::debug($msg, $caller);
            return false;
        }

        // Keep local_o365_coursegroupdata in sync with groups table.
        $o365grouprec = $DB->get_record('local_o365_coursegroupdata',
            ['groupid' => $moodlegroupid, 'courseid' => $grouprec->courseid]);
        if (empty($o365grouprec)) {
            $msg = 'Could not find local_o365_coursegroupdata record with with course "' . $grouprec->courseid .
                '" for group with id "' . $moodlegroupid . '"';
            \local_o365\utils::debug($msg, $caller);
            return false;
        }
        $o365grouprec->displayname = $grouprec->name;
        $o365grouprec->description = $grouprec->description;
        $o365grouprec->descriptionformat = $grouprec->descriptionformat;
        $o365grouprec->timemodified = $grouprec->timemodified;
        $updatephoto = false;
        if ($o365grouprec->picture != $grouprec->picture) {
            // Picture has changed.
            $updatephoto = true;
            $o365grouprec->picture = $grouprec->picture;
        }
        $DB->update_record('local_o365_coursegroupdata', $o365grouprec);

        $o365groupname = $courserec->shortname.': '.$grouprec->name;

        $object = self::get_study_group_object($moodlegroupid);
        if (empty($object->objectid)) {
            \local_o365\utils::debug('Could not find o365 object for moodle group with id "' . $moodlegroupid . '"', $caller);
            return false;
        }

        $groupdata = [
            'id'          => $object->objectid,
            'displayName' => $o365groupname,
            'description' => $grouprec->description,
        ];

        // Update o365 group.
        try {
            $o365group = $this->graphclient->update_group($groupdata);
        } catch (\Exception $e) {
            \local_o365\utils::debug('Updating of study group for Moodle group "' . $moodlegroupid . '" failed: ' .
                $e->getMessage(), $caller);
            return false;
        }

        if ($updatephoto) {
            $this->update_study_group_photo($grouprec, $object->objectid);
        }
        return true;
    }

    /**
     * Update study group photo.
     *
     * @param object $group Moodle group object.
     * @param string $o365groupid Microsoft 365 object id for group to update.
     * @return boolean True on success.
     */
    public function update_study_group_photo($group, $o365groupid) {
        $caller = 'update_study_group_photo';
        // Update o365 group photo.
        try {
             // Get file.
            $context = context_course::instance($group->courseid);
            $fs = get_file_storage();
            $fileinfo = [
                'component' => 'group',
                'filearea' => 'icon',
                'itemid' => $group->id,
                'contextid' => $context->id,
                'filepath' => '/',
                'filename' => 'f3.jpg'
            ];
            $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
                                  $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
            if ($file) {
                $photo = $file->get_content();
            } else {
                $fileinfo['filename'] = 'f3.png';
                $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
                                      $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
                if ($file) {
                    $photo = $file->get_content();
                } else {
                    // Photo will be set to the default.
                    $photo = '';
                }
            }

            $result = $this->graphclient->upload_group_photo($o365groupid, $photo);
            if (!empty($result)) {
                // If a response has returned than an error has occured.
                \local_o365\utils::debug('Update study group photo: "'.$group->id.'" '.$result, $caller);
                return false;
            }
        } catch (\Exception $e) {
            \local_o365\utils::debug('Update study group photo: "'.$group->id.'" Error:'.$e->getMessage(), $caller);
            return false;
        }
        return true;
    }

    /**
     * Create a study group from a Moodle group.
     *
     * @param int $moodlegroupid Id of Moodle course group.
     *
     * @return object|boolean False on failure, o365 object on success.
     */
    public function create_study_group($moodlegroupid) {
        global $DB;

        $caller = 'create_study_group';
        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }

        if (empty($this->graphclient)) {
            return false;
        }

        $grouprec = $DB->get_record('groups', ['id' => $moodlegroupid]);
        if (empty($grouprec)) {
            \local_o365\utils::debug('Could not find group with id "' . $moodlegroupid . '"', $caller);
            return false;
        }

        $courserec = $DB->get_record('course', ['id' => $grouprec->courseid]);
        if (empty($courserec)) {
            $msg = 'Could not find course with id "' . $grouprec->courseid . '" for group with id "' . $moodlegroupid . '"';
            \local_o365\utils::debug($msg, $caller);
            return false;
        }

        $o365groupdisplayname = self::get_group_display_name($courserec, $grouprec);
        $o365groupmailalias = self::get_group_mail_alias($courserec, $grouprec);

        $extra = [
            'description' => $grouprec->description
        ];

        // Create o365 group.
        try {
            $o365group = $this->graphclient->create_group($o365groupdisplayname, $o365groupmailalias, $extra);
        } catch (\Exception $e) {
            $this->mtrace('Could not create group for course group #' . $moodlegroupid.' in course #' . $courserec->id . '. ' .
                'Reason: '.$e->getMessage());
            return false;
        }

        // Create course group data.
        $data = new \stdClass();
        $now = time();
        $data->displayname = $o365groupdisplayname;
        $data->description = $grouprec->description;
        $data->descriptionformat = $grouprec->descriptionformat;
        $data->groupid = $grouprec->id;
        $data->courseid = $grouprec->courseid;
        // Pictures will be synced on a cron job after the group is provisioned on Microsoft 365.
        $data->picture = 0;
        $data->timecreated = $now;
        $data->timemodified = $now;
        $DB->insert_record('local_o365_coursegroupdata', $data);

        // Store group in database.
        $now = time();
        $rec = [
            'type' => 'group',
            'subtype' => 'usergroup',
            'moodleid' => $moodlegroupid,
            'objectid' => $o365group['id'],
            'o365name' => '',
            'timecreated' => $now,
            'timemodified' => $now,
        ];
        $DB->insert_record('local_o365_objects', $rec);
        return (object)$rec;
    }

    /**
     * When a Moodle group is created the profile photo cannot be uploaded as the group is not provisioned.
     */
    public function sync_group_profile_photo() {
        global $DB;

        $sql = 'SELECT g.*, obj.objectid, cgd.id cgdid
                  FROM {groups} g,
                       {local_o365_objects} obj,
                       {local_o365_coursegroupdata} cgd
                 WHERE obj.type = ?
                       AND obj.subtype = ?
                       AND obj.moodleid = g.id
                       AND cgd.groupid = g.id
                       AND cgd.picture != g.picture';
        $params = ['group', 'usergroup'];
        $groups = $this->DB->get_recordset_sql($sql, $params, 0, 5);
        $count = 0;
        foreach ($groups as $group) {
            // If the upload fails, it will not reattempt unless user modifies the photo.
            if ($this->update_study_group_photo($group, $group->objectid)) {
                $count++;
            }
            $DB->set_field('local_o365_coursegroupdata', 'picture', $group->picture, array('id' => $group->cgdid));
        }
        if ($count) {
            $this->mtrace('Synced '.$count.' group profile photos.');
        }
    }

    /**
     * Create a Microsoft 365 team for a Moodle course.
     *
     * @param $courseid
     * @param null $groupobjectid
     * @param null $moodleappid
     *
     * @return array|bool|mixed
     * @throws \dml_exception
     */
    public function create_team($courseid, $groupobjectid = null, $moodleappid = null) {
        $this->mtrace('Create team for course #' . $courseid);

        // Get group object and id, if needed.
        if (!empty($groupobjectid)) {
            $groupparams = ['objectid' => $groupobjectid];
        } else {
            $groupparams = [
                'type' => 'group',
                'subtype' => 'course',
                'moodleid' => $courseid,
            ];
        }
        $groupobjectrec = $this->DB->get_record('local_o365_objects', $groupparams);
        if (!empty($groupobjectrec)) {
            $groupobjectid = $groupobjectrec->objectid;
        } else {
            $errmsg = 'Could not find group object ID in local_o365_objects for course ' . $courseid . '. ';
            $errmsg .= 'Please ensure group exists first.';
            $this->mtrace($errmsg);
            return false;
        }

        $this->mtrace('Syncing to group "' . $groupobjectid . '"');

        // Check if team exists.
        $teamparams = [
            'type' => 'group',
            'subtype' => 'courseteam',
            'moodleid' => $courseid,
        ];
        $teamobjectrec = $this->DB->get_record('local_o365_objects', $teamparams);
        if (empty($teamobjectrec)) {
            // Create team.
            $now = time();

            $teacherids = static::get_team_owner_ids_by_course_id($courseid);
            $hasowner = false;
            foreach ($teacherids as $teacherid) {
                if ($ownerid = $this->DB->get_field('local_o365_objects', 'objectid',
                    ['type' => 'user', 'moodleid' => $teacherid])) {
                    $hasowner = true;
                    break;
                }
            }
            if (!$hasowner) {
                $this->mtrace('Skip creating team for course #' . $courseid . '. Reason: No owner');
                return false;
            }

            try {
                $response = $this->graphclient->create_team($groupobjectid);
            } catch (\Exception $e) {
                $this->mtrace('Could not create team for course #' . $courseid . '. Reason: ' . $e->getMessage());
                return false;
            }

            if ($response) {
                $this->mtrace('Created team ' . $groupobjectid . ' for course #' . $courseid);
                $teamobjectrec = [
                    'type' => 'group',
                    'subtype' => 'courseteam',
                    'objectid' => $groupobjectid,
                    'moodleid' => $courseid,
                    'o365name' => $groupobjectrec->o365name,
                    'timecreated' => $now,
                    'timemodified' => $now,
                ];
                $teamobjectrec['id'] = $this->DB->insert_record('local_o365_objects', (object)$teamobjectrec);
                $this->mtrace('Recorded team object (' . $teamobjectrec['objectid'] . ') into object table with record id '
                    . $teamobjectrec['id']);

                if (!empty($moodleappid)) {
                    $this->add_moodle_tab_in_teams($courseid, $groupobjectid, $moodleappid);
                }
            }

            return $teamobjectrec;
        } else {
            // team already exists
            $this->mtrace('Team existed for course #' . $courseid . ' with object table record id ' .
                $teamobjectrec['id']);
            return true;
        }
    }

    /**
     * Add Moodle tab to the Teams for the course with ID provided.
     *
     * @param $courseid
     * @param $groupobjectid
     * @param $moodleappid
     *
     * @return bool
     */
    public function add_moodle_tab_in_teams($courseid, $groupobjectid, $moodleappid) {
        // Provision app to the newly created team.
        $retrycounter = 0;
        $moodleappprovisioned = false;
        while ($retrycounter <= API_CALL_RETRY_LIMIT) {
            if ($retrycounter) {
                $this->mtrace('..... Retry #' . $retrycounter);
                sleep(10);
            }
            try {
                $this->graphclient->provision_app($groupobjectid, $moodleappid);
                $moodleappprovisioned = true;
                break;
            } catch (\Exception $e) {
                $this->mtrace('Could not add app to team for course #' . $courseid . '. Reason: ' . $e->getMessage());
                $retrycounter++;
            }
        }

        if (!$moodleappprovisioned) {
            return true;
        }

        // List all channels.
        try {
            $generalchanelid = $this->graphclient->get_general_channel_id($groupobjectid);
        } catch (\Exception $e) {
            $generalchanelid = null;
            $this->mtrace('Could not list channels in team for course #' . $courseid . '. Reason: ' . $e->getMessage());
        }

        if ($generalchanelid) {
            // Add tab to channel.
            try {
                $this->graphclient->add_moodle_tab_to_channel($groupobjectid, $generalchanelid, $moodleappid, $courseid);
            } catch (\Exception $e) {
                $this->mtrace('Could not add Moodle tab to channel in team for course #' . $courseid . '. Reason : '.
                    $e->getMessage());
            }
        }
    }

    /**
     * Update Teams cache.
     *
     * @return true
     */
    public function update_teams_cache() {
        global $DB;

        $createteamsconfig = get_config('local_o365', 'createteams');
        if (!($createteamsconfig === 'onall' || $createteamsconfig === 'oncustom')) {
            $this->mtrace('Teams creation is disabled.');
            return false;
        }

        $coursesenabled = \local_o365\feature\usergroups\utils::get_enabled_courses_with_feature('team');
        if (count($coursesenabled) == 0) {
            $this->mtrace('Teams creation is disabled.');
            return false;
        }

        // Fetch teams from Graph API.
        $this->mtrace('Attempting to fetch teams');
        $teams = [];
        $teamspart = $this->graphclient->get_teams();
        foreach ($teamspart['value'] as $teamitem) {
            $teams[$teamitem['id']] = $teamitem;
        }
        while (!empty($teamspart['@odata.nextLink'])) {
            $nextlink = parse_url($teamspart['@odata.nextLink']);
            if (isset($nextlink['query'])) {
                $query = [];
                parse_str($nextlink['query'], $query);
                if (isset($query['$skiptoken'])) {
                    $teamspart = $this->graphclient->get_teams($query['$skiptoken']);
                    foreach ($teamspart['value'] as $teamitem) {
                        if (!array_key_exists($teamitem['id'], $teams)) {
                            $teams[$teamitem['id']] = $teamitem;
                        }
                    }
                } else {
                    $teamspart = [];
                }
            }
        }

        // Build existing cache records cache.
        $this->mtrace('Build existing cache records cache');
        $existingcacherecords = $DB->get_records('local_o365_teams_cache');
        $existingcachebyoid = [];
        foreach ($existingcacherecords as $existingcacherecord) {
            $existingcachebyoid[$existingcacherecord->objectid] = $existingcacherecord;
        }

        // Compare, then create, update, or delete cache.
        $this->mtrace('Update cache records');
        foreach ($teams as $team) {
            if (array_key_exists($team['id'], $existingcachebyoid)) {
                // Update existing cache record.
                $cacherecord = $existingcachebyoid[$team['id']];
                $cacherecord->name = $team['displayName'];
                $cacherecord->description = $team['description'];
                $DB->update_record('local_o365_teams_cache', $cacherecord);

                unset($existingcachebyoid[$team['id']]);
            } else {
                // Create new cache record.
                $cacherecord = new \stdClass();
                $cacherecord->objectid = $team['id'];
                $cacherecord->name = $team['displayName'];
                $cacherecord->description = $team['description'];
                $cacherecord->url = $this->graphclient->get_teams_url($team['id']);
                $DB->insert_record('local_o365_teams_cache', $cacherecord);
            }
        }
        $this->mtrace('Delete old cache records');
        foreach ($existingcachebyoid as $oldcacherecord) {
            $DB->delete_records('local_o365_teams_cache', ['id' => $oldcacherecord->id]);
        }

        // Set last updated timestamp.
        set_config('teamscacheupdated', time(), 'local_o365');

        return true;
    }

    /**
     * Return the ID of the Moodle app in catalog.
     */
    public function get_moodle_app_id() {
        $this->mtrace('Get moodle app ID.');

        $teamsmoodleappexternalid = get_config('local_o365', 'teams_moodle_app_external_id');
        if (!$teamsmoodleappexternalid) {
            $teamsmoodleappexternalid = TEAMS_MOODLE_APP_EXTERNAL_ID;
        }

        $this->graphclient->get_catalog_app_id($teamsmoodleappexternalid);
    }
}
