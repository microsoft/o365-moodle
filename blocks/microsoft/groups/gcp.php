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

$courseid = optional_param('courseid', 0, PARAM_INT);
$groupid  = optional_param('groupid', 0, PARAM_INT);

$course = $DB->get_record('course', ['id' => $courseid]);
if (empty($courseid) || empty($course) || $courseid == SITEID) {
    print_error('invalidcourseid');
}

require_login($course);

if (\local_o365\feature\usergroups\utils::course_is_group_enabled($course->id) !== true) {
    print_error('groupsnotenabledforcourse', 'block_microsoft');
}

if (!$group = $DB->get_record('local_o365_coursegroupdata', ['courseid' => $courseid, 'groupid' => $groupid])) {
    // For older installs a record will not always exist in local_o365_coursegroupdata.
    if (!empty($groupid) && !$DB->record_exists('groups', ['id' => $groupid])) {
        print_error('invalidgroupid');
    }
    $group = block_microsoft_create_coursegroupdata($courseid, $groupid);
    // Create group and records if needed.
    block_microsoft_create_group($group);
    $group = $DB->get_record('local_o365_coursegroupdata', ['courseid' => $courseid, 'groupid' => $groupid]);
}

$strstudygroups = get_string('studygroups', 'block_microsoft');
$PAGE->set_title($strstudygroups);
$PAGE->set_heading($course->fullname . ': '.$strstudygroups);
$PAGE->set_pagelayout('course');
$PAGE->set_url('/blocks/microsoft/groups/gcp.php', ['courseid' => $group->courseid, 'groupid' => $group->groupid]);
$context = context_course::instance($course->id);
require_capability('block/microsoft:viewgroups', $context);
$PAGE->navbar->add($strstudygroups, new moodle_url('/blocks/microsoft/groups/gcp.php', ['courseid' => $group->courseid, 'groupid' => $group->groupid]));

$cache = \cache::make('block_microsoft', 'groups');
$groupscache = block_microsoft_get_urls($cache, $courseid, $groupid);

echo $OUTPUT->header();

$html = \html_writer::tag('h5', $group->displayname);
$html .= block_microsoft_print_group_picture($group);
echo \html_writer::tag('div', $html, ['class' => 'block_microsoft_cpheader']);

if ($groupscache == null) {
    // Group is not created yet.
    $str = get_string("cpgrouppending", 'block_microsoft');
    $html = \html_writer::tag('h5', $str);
    echo \html_writer::tag('div', $html, ['class' => 'block_microsoft_cppending']);
} else {
    foreach ($groupscache['urls'] as $name => $url) {
        if (!empty(get_config('block_microsoft', 'settings_cpshow'.$name))) {
            $url = new \moodle_url($url);
            $str = get_string("cp{$name}", 'block_microsoft');
            $attr = [
                'class' => 'block_microsoft_cpicons',
            ];
            $html = \html_writer::tag('h5', \html_writer::link($url, $str, ['target' => '_blank']));
            $icon = $OUTPUT->pix_icon($name, get_string('column'.$name, 'block_microsoft'), 'block_microsoft', $attr);
            $html .= \html_writer::link($url, $icon, ['target' => '_blank']);
            $html .= \html_writer::tag('br', '');
            echo \html_writer::tag('div', $html, ['class' => 'block_microsoft_cp'.$name]);
        }
    }
}

if (has_capability('block/microsoft:managegroups', $context)) {
    $url = new \moodle_url('/blocks/microsoft/groups/group.php', ['id' => $group->id]);
    $str = get_string("editgroupsettings", 'block_microsoft');
    $html = \html_writer::tag('h5', \html_writer::link($url, $str));
    echo \html_writer::tag('div', $html, ['class' => 'block_microsoft_cpeditgroupsettings']);
}

echo $OUTPUT->footer();