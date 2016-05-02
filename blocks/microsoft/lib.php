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
 * @package block_microsoft
 * @author  Remote-Learner.net Inc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

/**
 * Add a new group.
 *
 * @param stdClass $data group properties
 * @param stdClass $editform
 * @param array $editoroptions
 * @return id of group or false if error
 */
function block_microsoft_create_group($data, $editform = false, $editoroptions = false) {
    global $CFG, $DB;

    // Check that the course exists.
    $course = $DB->get_record('course', array('id' => $data->courseid), '*', MUST_EXIST);
    $context = context_course::instance($course->id);
    $data->timecreated  = time();
    $data->timemodified = $data->timecreated;
    $data->displayname  = trim($data->displayname);

    if ($editform and $editoroptions) {
        $data->description       = $data->description_editor['text'];
        $data->descriptionformat = $data->description_editor['format'];
    }

    $group = $DB->get_record('local_o365_coursegroupdata', ['courseid' => $data->courseid, 'groupid' => $data->groupid]);
    if ($editform && $editoroptions && empty($data->groupid)) {
        // Update description from editor with fixed files.
        $data = file_postupdate_standard_editor($data, 'description', $editoroptions, $context, 'block_microsoft', 'description', $data->id);
    }

    if (!empty($group)) {
        // Group already exists, update instead of insert.
        $data->id = $group->id;
        $DB->update_record('local_o365_coursegroupdata', $data);
    } else {
        $data->id = $DB->insert_record('local_o365_coursegroupdata', $data);
    }
    block_microsoft_update_moodle_group($data, $editform, $editoroptions);

    $group = $DB->get_record('local_o365_coursegroupdata', ['id' => $data->id]);
    $object = block_microsoft_get_o365_object($group);
    if (!empty($object->objectid) && $editform) {
        block_microsoft_update_group_icon($object->objectid, $group, $data, $editform);
    } else if (empty($object) && $editform) {
        block_microsoft_update_group_icon(null, $group, $data, $editform);
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
function block_microsoft_update_moodle_group($data, $editform, $editoroptions) {
    global $DB;
    if (!empty($data->groupid)) {
        if ($editform && $editoroptions) {
            $context = context_course::instance($data->courseid, MUST_EXIST);
            $data = file_postupdate_standard_editor($data, 'description', $editoroptions, $context, 'group', 'description', $data->groupid);
        }
        $upd = new stdClass();
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
function block_microsoft_update_group_icon($o365groupid, $group, $data, $editform) {
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
    $context = context_course::instance($group->courseid, MUST_EXIST);
    $newpicture = $group->picture;

    if (!empty($data->deletepicture)) {
        $fs->delete_area_files($context->id, 'block_microsoft', 'icon', $group->id);
        $newpicture = 0;
        if (!empty($o365groupid)) {
            $graphclient = block_microsoft_get_graphclient();
            $graphclient->upload_group_photo($o365groupid, '');
        }
    } else if ($iconfile = $editform->save_temp_file('imagefile')) {
        if ($rev = process_new_icon($context, 'block_microsoft', 'icon', $group->id, $iconfile, true)) {
            $newpicture = $rev;
        } else {
            $fs->delete_area_files($context->id, 'block_microsoft', 'icon', $group->id);
            $newpicture = 0;
        }
        if (!empty($o365groupid)) {
            $photo = file_get_contents($iconfile);
            $graphclient = block_microsoft_get_graphclient();
            $graphclient->upload_group_photo($o365groupid, $photo);
        }
        @unlink($iconfile);
    }

    if ($newpicture != $group->picture) {
        $DB->set_field('local_o365_coursegroupdata', 'picture', $newpicture, array('id' => $group->id));
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
function block_microsoft_update_group($data, $editform = false, $editoroptions = false) {
    global $CFG, $DB;
    $caller = 'block_microsoft_update_group';
    $context = context_course::instance($data->courseid);

    $data->timemodified = time();
    if (isset($data->name)) {
        $data->name = trim($data->name);
    }

    if ($editform and $editoroptions) {
        $data->description       = $data->description_editor['text'];
        $data->descriptionformat = $data->description_editor['format'];
    }

    if ($editform && $editoroptions && empty($data->groupid)) {
        $data = file_postupdate_standard_editor($data, 'description', $editoroptions, $context, 'block_microsoft', 'description', $data->id);
    }

    $DB->update_record('local_o365_coursegroupdata', $data);

    block_microsoft_update_moodle_group($data, $editform, $editoroptions);

    $o365group = $DB->get_record('local_o365_coursegroupdata', array('id'=>$data->id));
    $object = block_microsoft_get_o365_object($o365group);
    if (!empty($object->objectid) && $editform) {
        block_microsoft_update_group_icon($object->objectid, $o365group, $data, $editform);
    } else if (empty($object) && $editform) {
        block_microsoft_update_group_icon(null, $o365group, $data, $editform);
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
            $graphapi = block_microsoft_get_graphclient();
            $o365group = $graphapi->update_group($groupdata);
        } catch (\Exception $e) {
            \local_o365\utils::debug('Updating of study group for Moodle group "'.$usergroupid.'" failed: '.$e->getMessage(), $caller);
            return false;
        }

    }
    return true;
}

/**
 * Return image tag to display office 365 group picture.
 *
 * @param object $o365group Course group record.
 * @param string $image File name to use for image, ie f1.png, f2.png.
 * @param array $overrideattr Attirbutes for image tag.
 * @return string Image tag for image or blank for no image.
 */
function block_microsoft_print_group_picture($o365group, $image = 'f1.png', $overrideattr = null) {
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
    $context = context_course::instance($o365group->courseid);
    $grouppictureurl = moodle_url::make_pluginfile_url($context->id, 'block_microsoft', 'icon', $o365group->id, '/', $image);
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
 * Retrieve icon image and send to the browser for display.
 *
 * @param object $course Course object.
 * @param object $cm Course module object.
 * @param object $context Context.
 * @param string $filearea File area, icon or description.
 * @param array $args Array of arguments passed.
 * @param boolean $forcedownload True if download should be fored.
 * @param array $options Array of options.
 */
function block_microsoft_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB;
    // Check the contextlevel is as expected - if your plugin is a block, this becomes CONTEXT_BLOCK, etc.
    if ($context->contextlevel != CONTEXT_COURSE) {
        return false;
    }

    // Make sure the filearea is one of those used by the plugin.
    if ($filearea !== 'icon' && $filearea !== 'description') {
        return false;
    }

    // Make sure the user is logged in and has access to the module (plugins that are not course modules should leave out the 'cm' part).
    require_login($course, true, $cm);

    // Item id is the office 365 group id in local_o365_coursegroupdata.
    $itemid = array_shift($args); // The first item in the $args array.

    // Extract the filename / filepath from the $args array.
    $filename = array_pop($args); // The last item in the $args array.
    if (!$args) {
        $filepath = '/'; // $args is empty => the path is '/'
    } else {
        $filepath = '/'.implode('/', $args).'/'; // $args contains elements of the filepath
    }

    // Retrieve the file from the Files API.
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'block_microsoft', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        // The file does not exist.
        return false;
    }

    send_stored_file($file, null, 0, $forcedownload, $options);
}

/**
 * Return list of study groups.
 * @param array $filter Array containing filter for groups, 'courseid' or group 'id'.
 * @param int $max Maxiumn amount of groups to show.
 * @param int|boolean $mode False for html link, 1 for only links and 2 for moodle group object.
 * @return array Array of links, or array of objects. Last link is a link to complete list of study groups.
 */
function block_microsoft_study_groups_list($userid, $filter, $manage = true, $start = 0, $max = 5, $mode = false) {
    global $DB;
    if (empty($filter['courseid']) || !empty($filter['courseid']) && $filter['courseid'] == SITEID) {
        // Quering for all moodle groups that user has access to.
        if (is_siteadmin($userid) && $manage) {
            // This user is a site admin and can access all groups.
            $moodlegroups = $DB->get_records('groups', [], 'name', '*', $start, $max + 1);
        } else {
            if ($manage) {
                // Get groups that user can manage.
                $roles = get_roles_with_capability('block/microsoft:managegroups', CAP_ALLOW);
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
        $capability = 'block/microsoft:viewgroups';
    }

    $grouplist = [];
    $groupcount = 0;
    foreach ($moodlegroups as $moodlegroup) {
        $context = context_course::instance($moodlegroup->courseid);
        if (!has_capability($capability, $context, $userid)) {
            continue;
        }
        if ($groupcount < $max) {
            if (empty($moodlegroup->groupid) && !empty($moodlegroup->id)) {
                $moodlegroup->groupid = $moodlegroup->id;
            }
            $params = ['courseid' => $moodlegroup->courseid, 'groupid' => $moodlegroup->id];
            if ($manage) {
                $groupurl = new \moodle_url('/blocks/microsoft/groups/group.php', $params);
            } else {
                $groupurl = new \moodle_url('/blocks/microsoft/groups/gcp.php', $params);
            }
            if ($mode == 1) {
                $grouplist[] = $groupurl->out(false);
            } else if ($mode == 2) {
                $grouplist[] = $moodlegroup;
            } else {
                $attr = ['class' => 'servicelink block_microsoft_studygroup'];
                $grouplist[] = \html_writer::link($groupurl, $moodlegroup->name, $attr);
            }
            $groupcount++;
        }
    }
    if (count($moodlegroups) > $max && !$mode) {
        $morestr = get_string('morestudygroups', 'block_microsoft');
        $moreurl = new \moodle_url('/blocks/microsoft/groups/managegroups.php', ['courseid' => $filter['courseid']]);
        $grouplist[] = \html_writer::link($moreurl, $morestr, ['class' => 'servicelink block_microsoft_moregroups']);
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
function block_microsoft_create_coursegroupdata($courseid, $groupid) {
    global $DB;
    $subtype = 'course';
    $moodleid = $courseid;
    if ($groupid) {
        $subtype = 'usergroup';
        $moodleid = $groupid;
    }
    $group = new stdClass();
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
function block_microsoft_get_graphclient() {
    if (\local_o365\utils::is_configured() !== true) {
        return false;
    }

    if (\local_o365\feature\usergroups\utils::is_enabled() !== true) {
        return false;
    }

    $httpclient = new \local_o365\httpclient();
    $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();

    $unifiedresource = \local_o365\rest\unified::get_resource();
    $unifiedtoken = \local_o365\oauth2\systemtoken::instance(null, $unifiedresource, $clientdata, $httpclient);
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
function block_microsoft_get_o365_object($group) {
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
function block_microsoft_get_urls($cache, $courseid, $groupid) {
    $groupscache = $cache->get($courseid.'_'.$groupid);

    if (!empty($groupscache)) {
        return $groupscache;
    }

    $group = new \stdClass();
    $group->groupid = $groupid;
    $group->courseid = $courseid;
    $object = block_microsoft_get_o365_object($group);
    if (empty($object->objectid)) {
        return null;
    }
    try {
        $graphapi = block_microsoft_get_graphclient();
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
        $caller = 'gcp.php';
        \local_o365\utils::debug('Exception while retrieving group urls: groupid '.$object->objectid.' '.$e->getMessage(), $caller);
        return null;
    }
}