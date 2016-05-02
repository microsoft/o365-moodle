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

require_once(__DIR__.'/../../../config.php');
require_once($CFG->dirroot.'/blocks/microsoft/lib.php');
require_once('group_form.php');

$courseid = optional_param('courseid', 0, PARAM_INT);
$id       = optional_param('id', 0, PARAM_INT);
$groupid  = optional_param('groupid', 0, PARAM_INT);
$delete   = optional_param('delete', 0, PARAM_BOOL);
$confirm  = optional_param('confirm', 0, PARAM_BOOL);

if ($id) {
    if (!$group = $DB->get_record('local_o365_coursegroupdata', ['id' => $id])) {
        print_error('invalidgroupid');
    }
    if (empty($courseid)) {
        $courseid = $group->courseid;
    } else if ($courseid != $group->courseid) {
        print_error('invalidcourseid');
    }

    if (!$course = $DB->get_record('course', array('id' => $courseid))) {
        print_error('invalidcourseid');
    }
    if (\local_o365\feature\usergroups\utils::course_is_group_enabled($course->id) !== true) {
        print_error('groupsnotenabledforcourse', 'block_microsoft');
    }

} else {
    if ((!$course = $DB->get_record('course', array('id' => $courseid))) || $courseid == SITEID) {
        print_error('invalidcourseid');
    }
    if (\local_o365\feature\usergroups\utils::course_is_group_enabled($course->id) !== true) {
        print_error('groupsnotenabledforcourse', 'block_microsoft');
    }


    $filter = [
        'courseid' => $course->id,
        'groupid' => 0
    ];
    $subtype = 'course';
    $moodleid = $course->id;
    if ($groupid) {
        $subtype = 'usergroup';
        $filter['groupid'] = $groupid;
        $moodleid = $groupid;
    }
    $group = $DB->get_record('local_o365_coursegroupdata', $filter);
    if (empty($group)) {
        $group = block_microsoft_create_coursegroupdata($course->id, $groupid);
        $id = block_microsoft_create_group($group);
        $group->id = $id;
    }
}

if ($id !== 0) {
    $PAGE->set_url('/blocks/microsoft/groups/group.php', ['id' => $id]);
} else {
    $PAGE->set_url('/blocks/microsoft/groups/group.php', ['courseid' => $courseid]);
}

require_login($course);

if (empty($group)) {
    print_error('invalidgroupid');
}

// Check if user has capability to manage the course group.
$context = context_course::instance($course->id);
require_capability('block/microsoft:managegroups', $context);
if (!empty($group->groupid)) {
    // If managing a Moodle course group require access to groups.
    require_capability('moodle/course:managegroups', $context);
}

$strstudygroups = get_string('studygroups', 'block_microsoft');
$PAGE->set_title($strstudygroups);
$PAGE->set_heading($course->fullname . ': '.$strstudygroups);
$PAGE->set_pagelayout('admin');
navigation_node::override_active_url(new \moodle_url('/blocks/microsoft/groups/group.php', ['id' => $course->id]));

$returnurl = new \moodle_url('/blocks/microsoft/groups/gcp.php', ['courseid' => $group->courseid, 'groupid' => $group->groupid]);

// Prepare the description editor.
$editoroptions = [
    'maxfiles' => EDITOR_UNLIMITED_FILES,
    'maxbytes' => $course->maxbytes,
    'trust' => false,
    'context' => $context,
    'noclean' => true
];

$component = 'block_microsoft';
if (!empty($group->groupid)) {
    $editorid = $group->id;
    $component = 'group';
    $editorid = $group->groupid;
    // For study groups/Moodle groups the groups table is authority.
    $moodlegroup = $DB->get_record('groups', ['id' => $group->groupid]);
    $group->description = $moodlegroup->description;
    $group->descriptionformat = $moodlegroup->descriptionformat;
} else if (!empty($group->id)) {
    $editorid = $group->id;
} else {
    $editorid = null;
}

if (!empty($editorid)) {
    $editoroptions['subdirs'] = file_area_contains_subdirs($context, $component, 'description', $editorid);
    $group = file_prepare_standard_editor($group, 'description', $editoroptions, $context, $component, 'description', $editorid);
} else {
    $editoroptions['subdirs'] = false;
    $group = file_prepare_standard_editor($group, 'description', $editoroptions, $context, $component, 'description', null);
}

// First create the form.
$editform = new block_microsoft_group_form(null, ['editoroptions' => $editoroptions]);
$editform->set_data($group);

if ($editform->is_cancelled()) {
    redirect($returnurl);
} else if ($data = $editform->get_data()) {
    if ($data->id) {
        block_microsoft_update_group($data, $editform, $editoroptions);
    } else {
        $id = block_microsoft_create_group($data, $editform, $editoroptions);
        $group = $DB->get_record('local_o365_coursegroupdata', ['id' => $id]);
        $returnurl = new \moodle_url('/blocks/microsoft/groups/gcp.php', ['courseid' => $group->courseid, 'groupid' => $group->groupid]);
    }
    redirect($returnurl);
}

$strstudygroup = get_string('studygroup', 'block_microsoft');
$strheading = get_string('editgroupsettings', 'block_microsoft');

$PAGE->navbar->add($strstudygroup, new \moodle_url('/blocks/microsoft/groups/gcp.php', ['courseid' => $group->courseid, 'groupid' => $group->groupid]));
$PAGE->navbar->add($strheading);

echo $OUTPUT->header();
echo \html_writer::start_tag('div', ['id' => 'o365grouppicture']);
if (!empty($group->displayname)) {
    echo html_writer::tag('h1', $group->displayname);
}
if ($id) {
    echo block_microsoft_print_group_picture($group);
}
echo \html_writer::end_tag('div');
$editform->display();
echo $OUTPUT->footer();
