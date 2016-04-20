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
$page = optional_param('page', 0, PARAM_INT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourseid');
}

$context = context_course::instance($course->id);
require_login($course);
require_capability('block/microsoft:viewgroups', $context);

$PAGE->set_pagelayout('course');
$PAGE->set_context($context);
$PAGE->set_url('/blocks/microsoft/groups/managegroups.php');
$manage = has_capability('block/microsoft:managegroups', $context);
if ($manage) {
    $groups = block_microsoft_study_groups_list($USER->id, ['courseid' => $course->id], $manage, 0, 1000, 2);
} else {
    $groups = block_microsoft_study_groups_list($USER->id, null, $manage, 0, 1000, 2);
}

$heading = get_string('managegroups', 'block_microsoft');
$PAGE->set_title($heading);
$PAGE->set_heading($heading);
$PAGE->navbar->add($heading);
echo $OUTPUT->header();

$cache = \cache::make('block_microsoft', 'groups');

$start = $page * 25;
$end = $start + 25;
$count = 0;
echo \html_writer::start_tag('table', ['class' => 'block_microsoft_managegroups']);
$row = \html_writer::tag('td', '');
$row .= \html_writer::tag('td', \html_writer::tag('strong', get_string('columnname', 'block_microsoft')));
$columncount = 0;
foreach (['onedrive', 'calendar', 'conversations', 'notebook'] as $name) {
    if (!empty(get_config('block_microsoft', 'settings_cpshow'.$name))) {
        $attr = [
            'class' => 'block_microsoft_managegroups_header',
        ];
        $row .= \html_writer::tag('td', \html_writer::tag('strong', get_string('column'.$name, 'block_microsoft')), $attr);
        $columncount++;
    }
}
echo \html_writer::tag('tr', $row);
$strpending = get_string("managegrouppending", 'block_microsoft');

foreach ($groups as $group) {
    if ($count >= $start && $count < $end) {
        $groupscache = block_microsoft_get_urls($cache, $group->courseid, $group->id);
        $attr = [
            'courseid' => $group->courseid,
            'groupid'  => $group->id,
        ];
        if ($manage) {
            $url = new \moodle_url('/blocks/microsoft/groups/group.php', $attr);
        } else {
            $url = new \moodle_url('/blocks/microsoft/groups/gcp.php', $attr);
        }
        $attr = [
            'class' => 'block_microsoft_icon',
        ];
        $image = block_microsoft_print_group_picture($group, 'f1.png', $attr);
        if (empty($image)) {
            $image = $OUTPUT->pix_icon('defaultprofile', '', 'local_o365', $attr);
        }
        $link = \html_writer::link($url, $image);
        $row = \html_writer::tag('td', $link);

        $link = \html_writer::link($url, $group->name);
        $row .= \html_writer::tag('td', $link);

        if ($groupscache == null) {
            $row .= \html_writer::tag('td', $strpending, ['colspan' => $columncount]);
        } else {
            foreach (['onedrive', 'calendar', 'conversations', 'notebook'] as $name) {
                if (!empty(get_config('block_microsoft', 'settings_cpshow'.$name)) && !empty($groupscache['urls'][$name])) {
                    $attr = [
                        'class' => 'block_microsoft_icon',
                    ];
                    $icon = $OUTPUT->pix_icon($name, get_string('column'.$name, 'block_microsoft'), 'block_microsoft', $attr);
                    $attr = [
                        'target' => '_blank',
                    ];
                    $link = \html_writer::link($groupscache['urls'][$name], $icon, $attr);
                    $row .= \html_writer::tag('td', $link);
                    $columncount++;
                }
            }
        }
        echo \html_writer::tag('tr', $row);
    }
    $count++;
}
echo \html_writer::end_tag('table');
echo \html_writer::tag('br', '');

echo \html_writer::tag('strong', get_string('totalgroups', 'block_microsoft', count($groups)));
echo \html_writer::tag('br', '');
$sep = "";
$total = count($groups);
if ($start > 0) {
    $strprevious = get_string('previous');
    $link = new \moodle_url('/blocks/microsoft/groups/managegroups.php', ['page' => $page-1, 'courseid' => $courseid]);
    echo $sep.\html_writer::link($link, $strprevious);
    $sep = " ";
}
if (count($groups) > 25) {
    for ($i = 0; $i < $total/25; $i++) {
        if ($page != $i) {
            $link = new \moodle_url('/blocks/microsoft/groups/managegroups.php', ['page' => $i, 'courseid' => $courseid]);
            echo $sep.\html_writer::link($link, $i+1);
        } else {
            echo $sep.$i+1;
        }
        $sep = " ";
    }
}
if ($end < $total && $total > 25) {
    $strnext = get_string('next');
    $link = new \moodle_url('/blocks/microsoft/groups/managegroups.php', ['page' => $page+1, 'courseid' => $courseid]);
    echo $sep.\html_writer::link($link, $strnext);
}

echo $OUTPUT->footer();
