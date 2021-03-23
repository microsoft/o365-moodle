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

class utils {
    /**
     * Determine whether course usergroups are enabled or not.
     *
     * @return bool True if group creation is enabled. False otherwise.
     */
    public static function is_enabled() {
        $createteams = get_config('local_o365', 'createteams');
        return ($createteams === 'oncustom' || $createteams === 'onall') ? true : false;
    }

    /**
     * Get an array of enabled courses.
     *
     * @return array Array of course IDs, or TRUE if all courses enabled.
     */
    public static function get_enabled_courses() {
        $createteams = get_config('local_o365', 'createteams');
        if ($createteams === 'onall') {
            return true;
        } else if ($createteams === 'oncustom') {
            $coursesenabled = get_config('local_o365', 'usergroupcustom');
            $coursesenabled = @json_decode($coursesenabled, true);
            if (!empty($coursesenabled) && is_array($coursesenabled)) {
                return array_keys($coursesenabled);
            }
        }
        return [];
    }

    /**
     * Get a list of courses that are enabled for a specific feature.
     *
     * @param string $feature The required feature.
     * @return bool|array Array of course IDs, or TRUE if all courses are enabled.
     */
    public static function get_enabled_courses_with_feature($feature) {
        $createteams = get_config('local_o365', 'createteams');
        if ($createteams === 'onall') {
            return true;
        } else if ($createteams === 'oncustom') {
            $coursesenabled = get_config('local_o365', 'usergroupcustom');
            $coursesenabled = @json_decode($coursesenabled, true);
            if (empty($coursesenabled) || !is_array($coursesenabled)) {
                return [];
            }
            $enabledcourses = array_keys($coursesenabled);

            $featureconfig = get_config('local_o365', 'usergroupcustomfeatures');
            $featureconfig = @json_decode($featureconfig, true);
            if (empty($featureconfig) || !is_array($featureconfig)) {
                return [];
            }

            $return = [];
            foreach ($enabledcourses as $courseid) {
                if (isset($featureconfig[$courseid]) && isset($featureconfig[$courseid][$feature])) {
                    $return[] = $courseid;
                }
            }
            return $return;
        }
        return [];
    }

    /**
     * Determine whether a course is group-enabled.
     *
     * @param int $courseid The Moodle course ID to check.
     * @return bool Whether the course is group enabled or not.
     */
    public static function course_is_group_enabled($courseid) {
        $createteams = get_config('local_o365', 'createteams');
        if ($createteams === 'onall') {
            return true;
        } else if ($createteams === 'oncustom') {
            $coursesenabled = get_config('local_o365', 'usergroupcustom');
            $coursesenabled = @json_decode($coursesenabled, true);
            if (!empty($coursesenabled) && is_array($coursesenabled) && isset($coursesenabled[$courseid])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Add a new group.
     *
     * @param stdClass $data group properties
     * @param stdClass $editform
     * @param array $editoroptions
     * @return id of group or false if error
     */
    public static function create_group($data, $editform = false, $editoroptions = false) {
        global $CFG, $DB;

        // Check that the course exists.
        $course = $DB->get_record('course', ['id' => $data->courseid], '*', MUST_EXIST);
        $context = \context_course::instance($course->id);
        $data->timecreated  = time();
        $data->timemodified = $data->timecreated;
        $data->displayname  = trim($data->displayname);

        if ($editform and $editoroptions) {
            $data->description = $data->description_editor['text'];
            $data->descriptionformat = $data->description_editor['format'];
        }

        $group = $DB->get_record('local_o365_coursegroupdata', ['courseid' => $data->courseid, 'groupid' => $data->groupid]);
        if ($editform && $editoroptions && empty($data->groupid)) {
            // Update description from editor with fixed files.
            $data = file_postupdate_standard_editor($data, 'description', $editoroptions, $context, 'local_o365', 'description', $data->id);
        }

        if (!empty($group)) {
            // Group already exists, update instead of insert.
            $data->id = $group->id;
            $DB->update_record('local_o365_coursegroupdata', $data);
        } else {
            $data->id = $DB->insert_record('local_o365_coursegroupdata', $data);
        }
        static::update_moodle_group($data, $editform, $editoroptions);

        $group = $DB->get_record('local_o365_coursegroupdata', ['id' => $data->id]);
        $object = static::get_o365_object($group);
        if (!empty($object->objectid) && $editform) {
            static::update_group_icon($object->objectid, $group, $data, $editform);
        } else if (empty($object) && $editform) {
            static::update_group_icon(null, $group, $data, $editform);
        }
        return $group->id;
    }

    /**
     * Update Moodle group.
     *
     * @param object $data group properties.
     * @param object $editform Editform object.
     * @param array $editoroptions Editor options.
     */
    public static function update_moodle_group($data, $editform, $editoroptions) {
        global $DB;
        if (!empty($data->groupid)) {
            if ($editform && $editoroptions) {
                $context = \context_course::instance($data->courseid, MUST_EXIST);
                $data = file_postupdate_standard_editor($data, 'description', $editoroptions, $context, 'group', 'description', $data->groupid);
            }
            $upd = new \stdClass();
            $upd->id = $data->groupid;
            $upd->name = $data->displayname;
            $upd->description = $data->description;
            $upd->descriptionformat = $data->descriptionformat;
            $DB->update_record('groups', $upd);
        }
    }

    /**
     * Update the group icon from form data
     *
     * @param string $o365groupid O365 Group id.
     * @param object $group Group information.
     * @param object $data Form data.
     * @param object $editform Edit form.
     */
    public static function update_group_icon($o365groupid, $group, $data, $editform) {
        global $CFG, $DB;
        require_once("$CFG->libdir/gdlib.php");

        // If group id is set than use core update function.
        if (!empty($group->groupid)) {
            if (!$moodlegroup = $DB->get_record('groups', ['id' => $group->groupid])) {
                throw new \moodle_exception('Invalid group id');
            }
            require_once($CFG->dirroot.'/group/lib.php');
            groups_update_group_icon($moodlegroup, $data, $editform);
            return;
        }

        $fs = get_file_storage();
        $context = \context_course::instance($group->courseid, MUST_EXIST);
        $newpicture = $group->picture;

        if (!empty($data->deletepicture)) {
            $fs->delete_area_files($context->id, 'local_o365', 'icon', $group->id);
            $newpicture = 0;
            if (!empty($o365groupid)) {
                $graphclient = static::get_graphclient();
                $graphclient->upload_group_photo($o365groupid, '');
            }
        } else if ($iconfile = $editform->save_temp_file('imagefile')) {
            if ($rev = process_new_icon($context, 'local_o365', 'icon', $group->id, $iconfile, true)) {
                $newpicture = $rev;
            } else {
                $fs->delete_area_files($context->id, 'local_o365', 'icon', $group->id);
                $newpicture = 0;
            }
            if (!empty($o365groupid)) {
                $photo = file_get_contents($iconfile);
                $graphclient = static::get_graphclient();
                $graphclient->upload_group_photo($o365groupid, $photo);
            }
            @unlink($iconfile);
        }

        if ($newpicture != $group->picture) {
            $DB->set_field('local_o365_coursegroupdata', 'picture', $newpicture, ['id' => $group->id]);
            $group->picture = $newpicture;
        }
    }

    /**
     * Update group.
     *
     * @param object $data group properties (with magic quotes)
     * @param object $editform
     * @param array $editoroptions
     * @return bool true or exception
     */
    public static function update_group($data, $editform = false, $editoroptions = false) {
        global $CFG, $DB;
        $caller = '\local_o365\feature\usergroups\utils::update_group';
        $context = \context_course::instance($data->courseid);

        $data->timemodified = time();
        if (isset($data->name)) {
            $data->name = trim($data->name);
        }

        if ($editform and $editoroptions) {
            $data->description = $data->description_editor['text'];
            $data->descriptionformat = $data->description_editor['format'];
        }

        if ($editform && $editoroptions && empty($data->groupid)) {
            $data = file_postupdate_standard_editor($data, 'description', $editoroptions, $context, 'local_o365', 'description', $data->id);
        }

        $DB->update_record('local_o365_coursegroupdata', $data);

        static::update_moodle_group($data, $editform, $editoroptions);

        $o365group = $DB->get_record('local_o365_coursegroupdata', ['id' => $data->id]);
        $object = static::get_o365_object($o365group);
        if (!empty($object->objectid) && $editform) {
            static::update_group_icon($object->objectid, $o365group, $data, $editform);
        } else if (empty($object) && $editform) {
            static::update_group_icon(null, $o365group, $data, $editform);
        }

        if (!empty($o365group->groupid)) {
            $group = $DB->get_record('groups', ['id' => $o365group->groupid]);
            // Trigger group event.
            $params = [
                'context' => $context,
                'objectid' => $group->id,
            ];
            $event = \core\event\group_updated::create($params);
            $event->add_record_snapshot('groups', $group);
            $event->trigger();
        } else {
            // Updating course.
            if (empty($object->objectid)) {
                \local_o365\utils::debug('Could not find o365 object for moodle group with id "'.$usergroupid.'"', $caller);
                return false;
            }

            $groupdata = [
                'id'          => $object->objectid,
                'displayName' => $o365group->displayname,
                'description' => $o365group->description,
            ];

            // Update o365 group.
            try {
                $graphapi = static::get_graphclient();
                $o365group = $graphapi->update_group($groupdata);
            } catch (\Exception $e) {
                \local_o365\utils::debug('Updating of study group for Moodle group "'.$usergroupid.'" failed: '.$e->getMessage(), $caller);
                return false;
            }

        }
        return true;
    }

    /**
     * Return image tag to display Microsoft 365 group picture.
     *
     * @param object $o365group Course group record.
     * @param string $image File name to use for image, ie f1.png, f2.png.
     * @param array $overrideattr Attirbutes for image tag.
     * @return string Image tag for image or blank for no image.
     */
    public static function print_group_picture($o365group, $image = 'f1.png', $overrideattr = null) {
        global $DB;
        // If group id is set than retrieve picture from groups file storage to prevent duplicate files.
        if (!empty($o365group->groupid)) {
            if (!$moodlegroup = $DB->get_record('groups', ['id' => $o365group->groupid])) {
                throw new \moodle_exception('Invalid group id');
            }
            return print_group_picture($moodlegroup, $o365group->courseid, false, true);
        }
        if (empty($o365group->picture)) {
            return '';
        }
        $context = \context_course::instance($o365group->courseid);
        $grouppictureurl = \moodle_url::make_pluginfile_url($context->id, 'local_o365', 'icon', $o365group->id, '/', $image);
        $attr = [
            'class' => 'grouppicture',
            'title' => $o365group->displayname,
        ];
        if (!empty($overrideattr)) {
            foreach ($overrideattr as $name => $value) {
                $attr[$name] = $value;
            }
        }
        return \html_writer::img($grouppictureurl, get_string('group').' '.$o365group->displayname, $attr);
    }

    /**
     * Return list of study groups.
     * @param array $filter Array containing filter for groups, 'courseid' or group 'id'.
     * @param int $max Maxiumn amount of groups to show.
     * @param int|boolean $mode False for html link, 1 for only links and 2 for moodle group object.
     * @return array Array of links, or array of objects. Last link is a link to complete list of study groups.
     */
    public static function study_groups_list($userid, $filter, $manage = true, $start = 0, $max = 5, $mode = false) {
        global $DB;
        if (empty($filter['courseid']) || !empty($filter['courseid']) && $filter['courseid'] == SITEID) {
            // Quering for all moodle groups that user has access to.
            if (is_siteadmin($userid) && $manage) {
                // This user is a site admin and can access all groups.
                $moodlegroups = $DB->get_records('groups', [], 'name', '*', $start, $max + 1);
            } else {
                if ($manage) {
                    // Get groups that user can manage.
                    $roles = get_roles_with_capability('local/o365:managegroups', CAP_ALLOW);
                    if (empty($roles)) {
                        // No roles with capability, than user does not have access.
                        return [];
                    }
                    list ($rolesql, $roleparams) = $DB->get_in_or_equal(array_map(function ($role) { return $role->id; }, $roles));
                    $params = array_merge($roleparams, [$userid]);
                    $groupssql = 'SELECT DISTINCT g.id id, g.name, g.courseid
                                    FROM {groups} g, {role_assignments} ra, {context} c
                                   WHERE ra.roleid '.$rolesql.'
                                         AND ra.userid = ?
                                         AND ra.contextid = c.id
                                         AND contextlevel = '.CONTEXT_COURSE.'
                                         AND g.courseid = c.instanceid
                                ORDER BY g.name';
                    $moodlegroups = $DB->get_records_sql($groupssql, $params);
                } else {
                    // Get groups that user is enroled in.
                    $groupssql = 'SELECT DISTINCT g.id id, g.name, g.courseid
                                    FROM {groups} g, {groups_members} gm
                                   WHERE gm.userid = ?
                                         AND gm.groupid = g.id
                                ORDER BY g.name';
                    $moodlegroups = $DB->get_records_sql($groupssql, [$userid]);
                }
            }
        } else {
            // Retrieve groups by filter.
            $moodlegroups = $DB->get_records('groups', $filter, 'name', 'id,name,courseid');
        }

        // Ensure that user can access the group.
        if ($manage) {
            $capability = 'moodle/course:managegroups';
        } else {
            $capability = 'local/o365:viewgroups';
        }

        $grouplist = [];
        $groupcount = 0;
        foreach ($moodlegroups as $moodlegroup) {
            $context = \context_course::instance($moodlegroup->courseid);
            if (!has_capability($capability, $context, $userid)) {
                continue;
            }
            if ($groupcount < $max) {
                if (empty($moodlegroup->groupid) && !empty($moodlegroup->id)) {
                    $moodlegroup->groupid = $moodlegroup->id;
                }
                $params = ['courseid' => $moodlegroup->courseid, 'groupid' => $moodlegroup->id];
                if ($manage) {
                    $groupurl = new \moodle_url('/local/o365/groupcp.php', $params);
                } else {
                    $groupurl = new \moodle_url('/local/o365/groupcp.php', $params);
                }
                if ($mode == 1) {
                    $grouplist[] = $groupurl->out(false);
                } else if ($mode == 2) {
                    $grouplist[] = $moodlegroup;
                } else {
                    $attr = ['class' => 'servicelink'];
                    $grouplist[] = \html_writer::link($groupurl, $moodlegroup->name, $attr);
                }
                $groupcount++;
            }
        }
        if (count($moodlegroups) > $max && !$mode) {
            $morestr = get_string('groups_more', 'local_o365');
            $moreurl = new \moodle_url('/local/o365/groupcp.php', ['action' => 'managecoursegroups', 'courseid' => $filter['courseid']]);
            $grouplist[] = \html_writer::link($moreurl, $morestr, ['class' => 'servicelink']);
        }
        return $grouplist;
    }

    /**
     * Create course group data object for insert.
     *
     * @param int $courseid Course id.
     * @param int $groupid Group id.
     * @return object Group data object for insert.
     */
    public static function create_coursegroupdata($courseid, $groupid) {
        global $DB;
        $subtype = 'course';
        $moodleid = $courseid;
        if ($groupid) {
            $subtype = 'usergroup';
            $moodleid = $groupid;
        }
        $group = new \stdClass();
        $group->courseid = $courseid;
        if ($o365object = $DB->get_record('local_o365_objects', ['moodleid' => $moodleid, 'type' => 'group', 'subtype' => $subtype])) {
            $group->displayname = $o365object->o365name;
            $group->description = $o365object->o365name;
            $group->descriptionformat = 1;
        }
        if ($groupid) {
            // Retrieve group name from Moodle group.
            $group->groupid = $groupid;
            // Use moodle group page to create new group.
            $moodlegroup = $DB->get_record('groups', ['courseid' => $courseid, 'id' => $groupid]);
            if (empty($moodlegroup)) {
                print_error('invalidgroupid');
            }
            $group->displayname = $moodlegroup->name;
            $group->description = $moodlegroup->description;
            $group->descriptionformat = 1;
        } else {
            // Retrieve group name from course.
            $siterec = $DB->get_record('course', ['id' => SITEID]);
            $groupprefix = !empty($siterec) ? $siterec->shortname : '';
            $course = $DB->get_record('course', ['id' => $courseid]);
            $group->displayname = $groupprefix.': '.$course->fullname;
            $group->description = $course->summary;
            $group->descriptionformat = $course->summaryformat;
            $group->groupid = 0;
        }
        $group->timecreated = time();
        $group->timeupdated = time();
        return $group;
    }


    /**
     * Create connection to graph.
     * @return object Graph api.
     */
    public static function get_graphclient() {
        if (\local_o365\utils::is_configured() !== true) {
            return false;
        }

        if (\local_o365\feature\usergroups\utils::is_enabled() !== true) {
            return false;
        }

        $httpclient = new \local_o365\httpclient();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();

        $tokenresource = \local_o365\rest\unified::get_tokenresource();
        $unifiedtoken = \local_o365\utils::get_app_or_system_token($tokenresource, $clientdata, $httpclient);
        if (empty($unifiedtoken)) {
            return false;
        }
        return new \local_o365\rest\unified($unifiedtoken, $httpclient);
    }

    /**
     * Get local o365 object for group.
     *
     * @param object $group Record for local_o365_coursegroupdata.
     * @return array Array containing o365 object data.
     */
    public static function get_o365_object($group) {
        global $DB;
        if (!empty($group->groupid)) {
            $moodleid = $group->groupid;
            $subtype  = 'usergroup';
        } else {
            $moodleid = $group->courseid;
            $subtype  = 'course';
        }
        $params = [
            'type' => 'group',
            'subtype' => $subtype,
            'moodleid' => $moodleid
        ];
        $object = $DB->get_record('local_o365_objects', $params);
        if (empty($object)) {
            return false;
        }
        return $object;
    }

    /**
     * Get urls for Moodle group from cache or by api call.
     *
     * @param object $cache Moodle cache.
     * @param int $courseid Moodle Course id.
     * @param int $groupid Moodle Group id.
     * @return array Array containing o365 url data.
     */
    public static function get_group_urls($cache, $courseid, $groupid) {
        $groupscache = $cache->get($courseid.'_'.$groupid);

        if (!empty($groupscache)) {
            return $groupscache;
        }

        $group = new \stdClass();
        $group->groupid = $groupid;
        $group->courseid = $courseid;
        $object = static::get_o365_object($group);
        if (empty($object->objectid)) {
            return null;
        }
        try {
            $graphapi = static::get_graphclient();
            $urls = $graphapi->get_group_urls($object->objectid);
            $groupscache = [
                'object' => (array)$object,
                'urls' => $urls,
            ];
            if (!empty($urls)) {
                // Set cache when urls are successfully generated.
                $cache->set($courseid.'_'.$groupid, $groupscache);
            }
            return $groupscache;
        } catch (\Exception $e) {
            $caller = 'groupcp.php';
            \local_o365\utils::debug('Exception while retrieving group urls: groupid '.$object->objectid.' '.$e->getMessage(), $caller);
            return null;
        }
    }

    /**
     * (Soft) delete a course group.
     *
     * @param int $courseid The ID of the course.
     */
    public static function delete_course_group($courseid) {
        global $DB;
        $params = ['type' => 'group', 'subtype' => 'course', 'moodleid' => $courseid];
        $objectrec = $DB->get_record('local_o365_objects', $params);
        if (!empty($objectrec)) {
            $graphclient = \local_o365\rest\unified::instance_for_user(null);
            $result = $graphclient->delete_group($objectrec->objectid);
            if ($result === true) {
                $metadata = (!empty($objectrec->metadata)) ? @json_decode($objectrec->metadata, true) : [];
                if (empty($metadata) || !is_array($metadata)) {
                    $metadata = [];
                }
                $metadata['softdelete'] = true;
                $updatedobject = new \stdClass;
                $updatedobject->id = $objectrec->id;
                $updatedobject->metadata = json_encode($metadata);
                $DB->update_record('local_o365_objects', $updatedobject);
            }
        }
    }

    /**
     * Change whether groups are enabled for a course.
     *
     * @param int $courseid The ID of the course.
     * @param bool $enabled Whether to enable or disable.
     * @param bool $allfeatures Whether to enable all features, or just teams.
     */
    public static function set_course_group_enabled($courseid, $enabled = true, $allfeatures = false) {
        $usergroupconfig = get_config('local_o365', 'usergroupcustom');
        $usergroupconfig = @json_decode($usergroupconfig, true);
        if (empty($usergroupconfig) || !is_array($usergroupconfig)) {
            $usergroupconfig = [];
        }

        if ($enabled === true) {
            $usergroupconfig[$courseid] = $enabled;
        } else {
            if (isset($usergroupconfig[$courseid])) {
                unset($usergroupconfig[$courseid]);
                static::delete_course_group($courseid);
            }
        }

        $features = ['team'];
        if ($allfeatures) {
            static::set_course_group_feature_enabled($courseid, $features, $enabled);
        } else {
            static::set_course_group_feature_enabled($courseid, ['team'], $enabled);
        }

        set_config('usergroupcustom', json_encode($usergroupconfig), 'local_o365');
    }

    /**
     * Determine whether a group feature is enabled or disabled.
     *
     * @param int $courseid The ID of the course.
     * @param string $feature The feature to check.
     * @return bool Whether the feature is enabled or not.
     */
    public static function course_is_group_feature_enabled($courseid, $feature) {
        $createteams = get_config('local_o365', 'createteams');
        if ($createteams === 'onall') {
            return true;
        } else if ($createteams === 'oncustom') {
            $config = get_config('local_o365', 'usergroupcustomfeatures');
            $config = @json_decode($config, true);
            return (!empty($config) && is_array($config) && isset($config[$courseid]) && isset($config[$courseid][$feature]))
                ? true : false;
        }
        return false;
    }

    /**
     * Change whether group features are enabled for a course.
     *
     * @param int $courseid The ID of the course.
     * @param array $features Array of features to enable or disable.
     * @param bool $enabled Whether to enable or disable.
     */
    public static function set_course_group_feature_enabled($courseid, array $features, $enabled = true) {
        $usergroupconfig = get_config('local_o365', 'usergroupcustomfeatures');
        $usergroupconfig = @json_decode($usergroupconfig, true);
        if (empty($usergroupconfig) || !is_array($usergroupconfig)) {
            $usergroupconfig = [];
        }
        if (!isset($usergroupconfig[$courseid])) {
            $usergroupconfig[$courseid] = [];
        }
        if ($enabled === true) {
            foreach ($features as $feature) {
                $usergroupconfig[$courseid][$feature] = $enabled;
            }
        } else {
            foreach ($features as $feature) {
                if (isset($usergroupconfig[$courseid][$feature])) {
                    unset($usergroupconfig[$courseid][$feature]);
                }
            }
        }
        set_config('usergroupcustomfeatures', json_encode($usergroupconfig), 'local_o365');
    }

    /**
     * Enable or disable a feature for all group courses.
     *
     * @param string $feature The feature to enable or disable.
     * @param bool $enabled Whether to enable or disable.
     */
    public static function bulk_set_group_feature_enabled($feature, $enabled) {
        $usergroupconfig = get_config('local_o365', 'usergroupcustomfeatures');
        $usergroupconfig = @json_decode($usergroupconfig, true);
        if ($enabled === true) {
            if (empty($usergroupconfig) || !is_array($usergroupconfig)) {
                $usergroupconfig = [];
            }
            $enabledcourses = static::get_enabled_courses();
            foreach ($enabledcourses as $courseid) {
                if (!isset($usergroupconfig[$courseid])) {
                    $usergroupconfig[$courseid] = [];
                }
                $usergroupconfig[$courseid][$feature] = true;
            }
        } else {
            if (empty($usergroupconfig) || !is_array($usergroupconfig)) {
                return true;
            } else {
                foreach ($usergroupconfig as $courseid => $features) {
                    if (isset($features[$feature])) {
                        unset($usergroupconfig[$courseid][$feature]);
                    }
                }
            }
        }
        set_config('usergroupcustomfeatures', json_encode($usergroupconfig), 'local_o365');
    }

    /**
     * Return a list of unmatched teams, which can be used as connecting options.
     *
     * @param null $currentoid
     *
     * @return array
     */
    public static function get_teams_options($currentoid = null) {
        global $DB;

        $teamsoptions = [];
        $teamnamecache = [];
        $matchedid = 0;

        $matchedoids = $DB->get_fieldset_select('local_o365_objects', 'objectid', 'type = ? AND subtype = ?', ['group', 'course']);

        $teamcacherecords = $DB->get_records('local_o365_teams_cache');
        foreach ($teamcacherecords as $key => $teamcacherecord) {
            if ($teamcacherecord->objectid == $currentoid || !in_array($teamcacherecord->objectid, $matchedoids)) {
                if (!array_key_exists($teamcacherecord->name, $teamnamecache)) {
                    $teamnamecache[$teamcacherecord->name] = [];
                }
                $teamnamecache[$teamcacherecord->name][] = $teamcacherecord->objectid;
            } else {
                unset($teamcacherecords[$key]);
            }
        }

        foreach ($teamcacherecords as $teamcacherecord) {
            $teamoidpart = '';
            if (count($teamnamecache[$teamcacherecord->name]) > 1) {
                $teamoidpart = ' [' . $teamcacherecord->objectid . '] ';
            }
            if ($teamcacherecord->objectid == $currentoid) {
                $teamsoptions[$teamcacherecord->id] = $teamcacherecord->name . $teamoidpart . ' - ' .
                    get_string('acp_teamconnections_current_connection', 'local_o365');
                $matchedid = $teamcacherecord->id;
            } else {
                $teamsoptions[$teamcacherecord->id] = $teamcacherecord->name . $teamoidpart;
            }
        }

        natcasesort($teamsoptions);

        if (!$currentoid) {
            $teamsoptions = ['0' => get_string('acp_teamconnections_not_connected', 'local_o365')] + $teamsoptions;
        }

        return [$teamsoptions, $matchedid];
    }
}
