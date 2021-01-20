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
use WebDriver\Exception;

define('API_CALL_RETRY_LIMIT', 3);

class coursegroups {
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
        $this->replace_group_notebook_job();
        $groupprefix = '';

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
            $ownerid = null;
            $teacherid = null;

            if (\local_o365\feature\usergroups\utils::course_is_group_feature_enabled($course->id, 'team')) {
                $teacherids = $this->get_team_owner_ids_by_course_id($course->id);
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
                    $objectrec = $this->create_class_team($course, $ownerid, $groupprefix);
                } catch (\Exception $e) {
                    $this->mtrace('Could not create class team for course #' . $course->id . '. Reason: ' . $e->getMessage());
                    continue;
                }
            } else {
                // Create group.
                try {
                    $objectrec = $this->create_group($course, $groupprefix);
                } catch (\Exception $e) {
                    $this->mtrace('Could not create group for course #'.$course->id.'. Reason: '.$e->getMessage());
                    continue;
                }
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
                $teacherids = $this->get_team_owner_ids_by_course_id($course->id);
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
     * Create an Office 365 unified group for a Moodle course.
     *
     * @param stdClass $course A course record.
     * @param string $groupprefix A string to prefix group names and mailNicknames.
     * @return array Array form of the created local_o365_objects record.
     */
    public function create_group($course, $groupprefix = null) {
        $now = time();
        $groupname = $course->fullname;
        if (!empty($groupprefix)) {
            $groupname = $groupprefix.': '.$groupname;
        }

        $groupshortname = $course->shortname;
        if (!empty($groupprefix)) {
            $mailnickprefix = \core_text::strtolower($groupprefix);
            $mailnickprefix = preg_replace('/[^a-z0-9]+/iu', '', $mailnickprefix);
            $groupshortname = $mailnickprefix.'_'.$groupshortname;
        }

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
     * Create an Office 365 class team for a Moodle course.
     *
     * @param stdClass $course
     * @param array $ownerid
     * @param string|null $groupprefix
     * @return array|bool
     */
    public function create_class_team($course, $ownerid, $groupprefix = null) {
        $now = time();
        $displayname = $course->fullname;
        if (!empty($groupprefix)) {
            $displayname = $groupprefix . ': ' . $displayname;
        }

        $description = $course->summary;

        $extra = null;

        try {
            $teamid = null;
            $response = $this->graphclient->create_class_team($displayname, $description, $ownerid, $extra);

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
                    $this->graphclient->provision_app($teamobjectrec['objectid'], $moodleappid);
                    $moodleappprovisioned = true;
                    break;
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
     * @param string $groupobjectid The object ID of the office 365 group.
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
        $intendedteamownerids = $this->get_team_owner_ids_by_course_id($courseid);
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
    public function get_team_owner_ids_by_course_id($courseid) {
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
     * The function will replace the simple notebook of a office 365 group with class notebook.
     * If o365 notebook is already present i.e. o365 group notebook setup is already done.
     */
    public function replace_group_notebook_job() {
        $httpclient = new \local_o365\httpclient();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $notebookresource = \local_o365\rest\notebook::get_resource();
        $notebooktoken = \local_o365\utils::get_app_or_system_token($notebookresource, $clientdata, $httpclient);
        $notebookclient = new \local_o365\rest\notebook($notebooktoken, $httpclient);
        $groups = $this->get_all_officegroupids_classnotebook_notpresent();

        if (empty($groups)) {
            $this->mtrace('No groups waiting to have class notebook created.');
            return true;
        }

        foreach ($groups as $group) {
            $o365groupid = $group->objectid;
            $dbcoursegroupid = $group->id;
            try {
                $teachers = $students = array();
                if ($group->groupid === '0') {
                    $teacherids = $this->get_team_owner_ids_by_course_id($group->moodleid);

                    // Get list of users enrolled in the course. These are our intended group members.
                    $intendedmembers = [];
                    $coursecontext = context_course::instance($group->moodleid);
                    list($esql, $params) = get_enrolled_sql($coursecontext);
                    $sql = "SELECT u.id, u.email,
                                   tok.oidcuniqid as userobjectidd
                              FROM {user} u
                              JOIN ($esql) je ON je.id = u.id
                              JOIN {auth_oidc_token} tok ON tok.userid = u.id AND tok.resource = :tokresource
                             WHERE u.deleted = 0";
                    $params['tokresource'] = \local_o365\rest\unified::get_resource();
                    $enrolled = $this->DB->get_recordset_sql($sql, $params);
                    foreach ($enrolled as $user) {
                        if (in_array($user->id, $teacherids)) {
                            array_push($teachers, $user->email);
                        } else {
                            array_push($students, $user->email);
                        }
                    }
                    $enrolled->close();
                }
                $classnotebook = $notebookclient->create_class_notebook($o365groupid, $teachers, $students);
                $this->mtrace('... Replaced notebook with class notebook for o365 groupid '.$o365groupid);
                $sql = 'UPDATE {local_o365_coursegroupdata} SET classnotebook = 1 WHERE id = ?';
                $params = [$dbcoursegroupid];
                $this->DB->execute($sql, $params);
            } catch (\Exception $e) {
                /* Ignore if can't replace */
            }
        }
    }

    /**
     * The function will fetch and return all the o365 groups for whom notebook is not replaced with class notebook.
     */
    public function get_all_officegroupids_classnotebook_notpresent() {
        $notebookcourses = \local_o365\feature\usergroups\utils::get_enabled_courses_with_feature('notebook');
        if (empty($notebookcourses)) {
            return [];
        }

        $allgroups = [];

        $sql = 'SELECT cg.id, cg.groupid, obj.objectid, obj.moodleid
                  FROM {local_o365_objects} obj
            INNER JOIN {local_o365_coursegroupdata} cg ON obj.moodleid = cg.courseid
                 WHERE obj.type = ? AND obj.subtype = ? AND cg.classnotebook = 0 AND cg.groupid = 0';
        $params = ['group', 'course'];
        if (is_array($notebookcourses)) {
            list($coursesinsql, $coursesparams) = $this->DB->get_in_or_equal($notebookcourses);
            $sql .= ' AND cg.courseid '.$coursesinsql;
            $params = array_merge($params, $coursesparams);
        }
        $coursegroups = $this->DB->get_recordset_sql($sql, $params);
        foreach ($coursegroups as $group) {
            array_push($allgroups, $group);
        }
        $coursegroups->close();

        $sql = 'SELECT cg.id, cg.groupid, obj.objectid, obj.moodleid
                  FROM {local_o365_objects} obj
            INNER JOIN {local_o365_coursegroupdata} cg ON obj.moodleid = cg.groupid
                 WHERE obj.type = ? AND obj.subtype = ? AND cg.classnotebook = 0';
        $params = ['group', 'usergroup'];
        if (is_array($notebookcourses)) {
            list($coursesinsql, $coursesparams) = $this->DB->get_in_or_equal($notebookcourses);
            $sql .= ' AND cg.courseid '.$coursesinsql;
            $params = array_merge($params, $coursesparams);
        }
        $incourseusergroups = $this->DB->get_recordset_sql($sql, $params);
        foreach ($incourseusergroups as $group) {
            array_push($allgroups, $group);
        }
        $incourseusergroups->close();

        return $allgroups;
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
    public function update_study_group($moodegroupid) {
        global $DB;
        $caller = 'update_study_group';
        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }

        if (empty($this->graphclient)) {
            return false;
        }

        $grouprec = $DB->get_record('groups', ['id' => $moodegroupid]);
        if (empty($grouprec)) {
            \local_o365\utils::debug('Could not find group with id "'.$usergroupid.'"', $caller);
            return false;
        }

        $courserec = $DB->get_record('course', ['id' => $grouprec->courseid]);
        if (empty($courserec)) {
            $msg = 'Could not find course with id "'.$grouprec->courseid.'" for group with id "'.$moodegroupid.'"';
            \local_o365\utils::debug($msg, $caller);
            return false;
        }

        // Keep local_o365_coursegroupdata in sync with groups table.
        $o365grouprec = $DB->get_record('local_o365_coursegroupdata', ['groupid' => $moodegroupid, 'courseid' => $grouprec->courseid]);
        if (empty($o365grouprec)) {
            $msg = 'Could not find local_o365_coursegroupdata record with with course "'.$grouprec->courseid.'" for group with id "'.$moodegroupid.'"';
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

        $object = self::get_study_group_object($moodegroupid);
        if (empty($object->objectid)) {
            \local_o365\utils::debug('Could not find o365 object for moodle group with id "'.$usergroupid.'"', $caller);
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
            \local_o365\utils::debug('Updating of study group for Moodle group "'.$usergroupid.'" failed: '.$e->getMessage(), $caller);
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
     * @param string $o365groupid Office 365 object id for group to update.
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
     * @return object|boolean False on failure, o365 object on success.
     */
    public function create_study_group($moodegroupid) {
        global $DB;
        $caller = 'create_study_group';
        if (\local_o365\utils::is_configured() !== true || \local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }

        if (empty($this->graphclient)) {
            return false;
        }

        $grouprec = $DB->get_record('groups', ['id' => $moodegroupid]);
        if (empty($grouprec)) {
            \local_o365\utils::debug('Could not find group with id "'.$usergroupid.'"', $caller);
            return false;
        }

        $courserec = $DB->get_record('course', ['id' => $grouprec->courseid]);
        if (empty($courserec)) {
            $msg = 'Could not find course with id "'.$grouprec->courseid.'" for group with id "'.$usergroupid.'"';
            \local_o365\utils::debug($msg, $caller);
            return false;
        }

        $o365groupname = $courserec->shortname.': '.$grouprec->name;

        $extra = [
            'description' => $grouprec->description
        ];

        // Create o365 group.
        try {
            $o365group = $this->graphclient->create_group($o365groupname, null, $extra);
        } catch (\Exception $e) {
            return false;
        }

        // Create course group data.
        $data = new \stdClass();
        $now = time();
        $data->displayname = $grouprec->name;
        $data->description = $grouprec->description;
        $data->descriptionformat = $grouprec->descriptionformat;
        $data->groupid = $grouprec->id;
        $data->courseid = $grouprec->courseid;
        // Pictures will be synced on a cron job after the group is provisioned on office 365.
        $data->picture = 0;
        $data->timecreated = $now;
        $data->timemodified = $now;
        $DB->insert_record('local_o365_coursegroupdata', $data);

        // Store group in database.
        $now = time();
        $rec = [
            'type' => 'group',
            'subtype' => 'usergroup',
            'moodleid' => $moodegroupid,
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
        $siterec = $this->DB->get_record('course', ['id' => SITEID]);
        $groupprefix = (!empty($siterec)) ? $siterec->shortname : '';

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
     * Create an Office 365 team for a Moodle course.
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

            $teacherids = $this->get_team_owner_ids_by_course_id($courseid);
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
                    // Provision app to the newly created team.
                    try {
                        $response = $this->graphclient->provision_app($groupobjectid, $moodleappid);
                    } catch (\Exception $e) {
                        $this->mtrace('Could not add app to team for course #' . $courseid . '. Reason: ' . $e->getMessage());
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
                            $this->graphclient->add_moodle_tab_to_channel($groupobjectid, $generalchanelid, $moodleappid,
                                $courseid);
                        } catch (\Exception $e) {
                            $this->mtrace('Could not add Moodle tab to channel in team for course #' . $courseid .
                                '. Reason : '. $e->getMessage());
                        }
                    }
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
     * Return the ID of the Moodle app in catalog.
     */
    public function get_moodle_app_id() {
        $this->mtrace('Get moodle app ID.');

        $this->graphclient->get_catalog_app_id('2e43119b-fcfe-44f8-b3e5-996ffcb7fb95');
    }
}
