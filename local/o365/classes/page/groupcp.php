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
 * User control panel page.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\page;

defined('MOODLE_INTERNAL') || die();

/**
 * User control panel page.
 */
class groupcp extends base {
    /** @var bool Whether the user is using o365 login. */
    protected $o365loginconnected = false;

    /** @var bool Whether the user is connected to o365 or not (has an active token). */
    protected $o365connected = false;

    /**
     * Run before the main page mode - determines connection status.
     *
     * @return bool Success/Failure.
     */
    public function header() {
        global $USER, $DB;
        $this->o365loginconnected = ($USER->auth === 'oidc') ? true : false;
        $this->o365connected = \local_o365\utils::is_o365_connected($USER->id);
        return true;
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
            $data = file_postupdate_standard_editor($data, 'description', $editoroptions, $context, 'local_o365', 'description',
                $data->id);
        }

        if (!empty($group)) {
            // Group already exists, update instead of insert.
            $data->id = $group->id;
            $DB->update_record('local_o365_coursegroupdata', $data);
        } else {
            $data->id = $DB->insert_record('local_o365_coursegroupdata', $data);
        }
        \local_o365\feature\usergroups\utils::update_moodle_group($data, $editform, $editoroptions);

        $group = $DB->get_record('local_o365_coursegroupdata', ['id' => $data->id]);
        $object = \local_o365\feature\usergroups\utils::get_o365_object($group);
        if (!empty($object->objectid) && $editform) {
            \local_o365\feature\usergroups\utils::update_group_icon($object->objectid, $group, $data, $editform);
        } else if (empty($object) && $editform) {
            \local_o365\feature\usergroups\utils::update_group_icon(null, $group, $data, $editform);
        }
        return $group->id;
    }

    /**
     * Manage course groups.
     */
    public function mode_managecoursegroups() {
        global $DB, $USER, $OUTPUT, $PAGE, $CFG;

        $courseid = optional_param('courseid', 0, PARAM_INT);
        $page = optional_param('page', 0, PARAM_INT);

        if (!$course = $DB->get_record('course', array('id' => $courseid))) {
            print_error('invalidcourseid');
        }

        if (\local_o365\feature\usergroups\utils::course_is_group_enabled($course->id) !== true) {
            print_error('groups_notenabledforcourse', 'local_o365');
        }

        $context = \context_course::instance($course->id);
        $this->set_context($context);
        require_login($course);
        require_capability('local/o365:managegroups', $this->context);
        $PAGE->set_pagelayout('course');

        $manage = has_capability('local/o365:managegroups', $context);
        if ($manage) {
            $groups = \local_o365\feature\usergroups\utils::study_groups_list($USER->id, ['courseid' => $course->id], $manage, 0,
                1000, 2);
        } else {
            $groups = \local_o365\feature\usergroups\utils::study_groups_list($USER->id, null, $manage, 0, 1000, 2);
        }

        $heading = get_string('groups_manage', 'local_o365');
        $this->set_title($heading);

        echo $this->standard_header();

        $start = $page * 25;
        $end = $start + 25;
        $count = 0;
        echo \html_writer::start_tag('table', ['class' => 'local_o365_groupcp_managegroups']);
        $row = \html_writer::tag('td', '');
        $row .= \html_writer::tag('td', \html_writer::tag('strong', get_string('groups_columnname', 'local_o365')));
        $columncount = 0;

        foreach (['team'] as $feature) {
            $attr = ['class' => 'local_o365_groupcp_managegroups_header'];
            $strresourcename = get_string('groups_' . $feature, 'local_o365');
            $row .= \html_writer::tag('td', \html_writer::tag('strong', $strresourcename), $attr);
            $columncount++;
        }
        echo \html_writer::tag('tr', $row);
        $strpending = get_string('groups_manage_pending', 'local_o365');

        foreach ($groups as $group) {
            if ($count >= $start && $count < $end) {
                $groupurls = \local_o365\feature\usergroups\utils::get_group_urls($group->courseid, $group->id);
                $attr = [
                    'courseid' => $group->courseid,
                    'groupid'  => $group->id,
                ];
                if ($manage) {
                    $attr['action'] = 'editgroup';
                    $url = new \moodle_url('/local/o365/groupcp.php', $attr);
                } else {
                    $url = new \moodle_url('/local/o365/groupcp.php', $attr);
                }
                $attr = [
                    'class' => 'local_o365_groupcp_icon',
                ];
                $image = \local_o365\feature\usergroups\utils::print_group_picture($group, 'f1.png', $attr);
                if (empty($image)) {
                    $image = $OUTPUT->pix_icon('defaultprofile', '', 'local_o365', $attr);
                }
                $link = \html_writer::link($url, $image);
                $row = \html_writer::tag('td', $link);

                $link = \html_writer::link($url, $group->name);
                $row .= \html_writer::tag('td', $link);

                if ($groupurls == null) {
                    $row .= \html_writer::tag('td', $strpending, ['colspan' => $columncount]);
                } else {
                    foreach (['team'] as $feature) {
                        $enabled = \local_o365\feature\usergroups\utils::course_is_group_feature_enabled($group->courseid,
                            $feature);
                        if ($enabled === true) {
                            $url = new \moodle_url($groupurls[$feature]);
                            $strresourcename = get_string('groups_' . $feature, 'local_o365');
                            $pixattrs = ['style' => 'width:2rem;height:2rem'];
                            $icon = $OUTPUT->pix_icon('groups' . $feature, $strresourcename, 'local_o365', $pixattrs);
                            $tdattrs = ['style' => 'text-align:center'];
                            $row .= \html_writer::tag('td', \html_writer::link($url, $icon, ['target' => '_blank']), $tdattrs);
                        } else {
                            $row .= \html_writer::tag('td', '');
                        }
                    }
                }
                echo \html_writer::tag('tr', $row);
            }
            $count++;
        }
        echo \html_writer::end_tag('table');
        echo \html_writer::tag('br', '');

        echo \html_writer::tag('strong', get_string('groups_total', 'local_o365', count($groups)));
        echo \html_writer::tag('br', '');

        $linkparams = ['action' => 'managecoursegroups', 'courseid' => $courseid];
        $cururl = new \moodle_url('/local/o365/groupcp.php', $linkparams);
        echo $OUTPUT->paging_bar(count($groups), $page, 25, $cururl);

        echo $this->standard_footer();
    }

    /**
     * Edit a group.
     */
    public function mode_editgroup() {
        global $DB, $PAGE, $CFG, $OUTPUT;
        require_once($CFG->dirroot.'/lib/formslib.php');

        $courseid = optional_param('courseid', 0, PARAM_INT);
        $id = optional_param('id', 0, PARAM_INT);
        $groupid = optional_param('groupid', 0, PARAM_INT);
        $delete = optional_param('delete', 0, PARAM_BOOL);
        $confirm = optional_param('confirm', 0, PARAM_BOOL);

        if (!empty($id)) {
            $this->set_url(new \moodle_url('/local/o365/groupcp.php', ['action' => 'editgroup', 'id' => $id]));
            $group = $DB->get_record('local_o365_coursegroupdata', ['id' => $id]);
            if (empty($group)) {
                print_error('invalidgroupid');
            }
            if (empty($courseid)) {
                $courseid = $group->courseid;
            } else if ($courseid != $group->courseid) {
                print_error('invalidcourseid');
            }

            $course = $DB->get_record('course', ['id' => $courseid]);
            if (empty($course)) {
                print_error('invalidcourseid');
            }
            if (\local_o365\feature\usergroups\utils::course_is_group_enabled($course->id) !== true) {
                print_error('groups_notenabledforcourse', 'local_o365');
            }
        } else if (!empty($courseid)) {
            $this->set_url(new \moodle_url('/local/o365/groupcp.php', ['action' => 'editgroup', 'courseid' => $courseid]));
            $course = $DB->get_record('course', ['id' => $courseid]);
            if (empty($course) || $courseid == SITEID) {
                print_error('invalidcourseid');
            }
            if (\local_o365\feature\usergroups\utils::course_is_group_enabled($course->id) !== true) {
                print_error('groups_notenabledforcourse', 'local_o365');
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
                $group = \local_o365\feature\usergroups\utils::create_coursegroupdata($course->id, $groupid);
                $id = \local_o365\feature\usergroups\utils::create_group($group);
                $group->id = $id;
            }
        } else {
            print_error('invalidgroupid');
        }

        $this->set_context(\context_course::instance($course->id));
        require_login($course);

        if (empty($group)) {
            print_error('invalidgroupid');
        }

        // Check if user has capability to manage the course group.
        $context = \context_course::instance($course->id);
        require_capability('local/o365:managegroups', $context);
        if (!empty($group->groupid)) {
            // If managing a Moodle course group require access to groups.
            require_capability('moodle/course:managegroups', $context);
        }

        $PAGE->set_pagelayout('admin');
        $this->set_title($course->fullname.': '.get_string('groups', 'local_o365'));

        // Prepare the description editor.
        $editoroptions = [
            'maxfiles' => EDITOR_UNLIMITED_FILES,
            'maxbytes' => $course->maxbytes,
            'trust' => false,
            'context' => $context,
            'noclean' => true
        ];

        $component = 'local_o365';
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
            $group = file_prepare_standard_editor($group, 'description', $editoroptions, $context, $component, 'description',
                $editorid);
        } else {
            $editoroptions['subdirs'] = false;
            $group = file_prepare_standard_editor($group, 'description', $editoroptions, $context, $component, 'description',
                null);
        }

        // First create the form.
        $editform = new \local_o365\form\groupedit($this->url, ['editoroptions' => $editoroptions]);
        $editform->set_data($group);

        $returnurlparams = ['action' => 'editgroup', 'courseid' => $group->courseid, 'groupid' => $group->groupid];
        $returnurl = new \moodle_url('/local/o365/groupcp.php', $returnurlparams);
        if ($editform->is_cancelled()) {
            redirect($returnurl);
        } else if ($data = $editform->get_data()) {
            if ($data->id) {
                \local_o365\feature\usergroups\utils::update_group($data, $editform, $editoroptions);
            } else {
                $id = \local_o365\feature\usergroups\utils::create_group($data, $editform, $editoroptions);
                $group = $DB->get_record('local_o365_coursegroupdata', ['id' => $id]);
                $returnurl = new \moodle_url('/local/o365/groupcp.php',
                    ['courseid' => $group->courseid, 'groupid' => $group->groupid]);
            }
            redirect($returnurl);
        }

        $strstudygroup = get_string('groups_studygroup', 'local_o365');
        $strheading = get_string('groups_editsettings', 'local_o365');

        $PAGE->navbar->add($strheading);

        echo $OUTPUT->header();
        echo \html_writer::start_tag('div', ['id' => 'o365grouppicture']);
        if (!empty($group->displayname)) {
            echo \html_writer::tag('h1', $group->displayname);
        }
        if ($id) {
            echo \local_o365\feature\usergroups\utils::print_group_picture($group);
        }
        echo \html_writer::end_tag('div');
        $editform->display();
        $this->standard_footer();
    }

    /**
     * View a group.
     */
    public function mode_viewgroup() {
        global $PAGE, $DB, $CFG, $OUTPUT;

        $courseid = optional_param('courseid', 0, PARAM_INT);
        $groupid  = optional_param('groupid', 0, PARAM_INT);

        $course = $DB->get_record('course', ['id' => $courseid]);
        if (empty($courseid) || empty($course) || $courseid == SITEID) {
            print_error('invalidcourseid');
        }

        require_login($course);
        if (\local_o365\feature\usergroups\utils::course_is_group_enabled($course->id) !== true) {
            print_error('groups_notenabled', 'local_o365');
        }

        // Get group data.
        $group = $DB->get_record('local_o365_coursegroupdata', ['courseid' => $courseid, 'groupid' => $groupid]);

        // Create group and records if needed. (For older installs a record will not always exist in local_o365_coursegroupdata).
        if (empty($group)) {
            if (!empty($groupid) && !$DB->record_exists('groups', ['id' => $groupid])) {
                print_error('invalidgroupid');
            }
            $group = \local_o365\feature\usergroups\utils::create_coursegroupdata($courseid, $groupid);
            \local_o365\feature\usergroups\utils::create_group($group);
            $group = $DB->get_record('local_o365_coursegroupdata', ['courseid' => $courseid, 'groupid' => $groupid]);
        }

        $this->set_title($course->fullname . ': ' . get_string('groups', 'local_o365'));
        $PAGE->set_pagelayout('course');
        $this->set_url(new \moodle_url($this->url, ['courseid' => $group->courseid, 'groupid' => $group->groupid]));
        $this->set_context(\context_course::instance($course->id));

        // If the user doesn't have the manage groups capability, check if they can view groups.
        if (!has_capability('local/o365:managegroups', $this->context)) {
            require_capability('local/o365:viewgroups', $this->context);
        }

        $groupurls = \local_o365\feature\usergroups\utils::get_group_urls($courseid, $groupid);

        echo $OUTPUT->header();

        echo \html_writer::start_div('local_o365_groupcp');

        $grouppicture = \local_o365\feature\usergroups\utils::print_group_picture($group);
        if (empty($grouppicture)) {
            $grouppicture = $OUTPUT->pix_icon('defaultprofile', '', 'local_o365', ['class' => 'local_o365_groupcp_icon']);
        }
        $headerhtml = $grouppicture.\html_writer::tag('h4', $group->displayname);
        echo \html_writer::div($headerhtml, 'local_o365_groupcp_header');

        if ($groupurls == null) {
            // Group is not created yet.
            $html = \html_writer::tag('h5', get_string('groups_pending', 'local_o365'));
            echo \html_writer::tag('div', $html);
        } else {
            $links = [
                \html_writer::tag('h5', 'Group Resources:'),
            ];
            foreach (['conversations', 'onedrive', 'calendar', 'notebook', 'team'] as $feature) {
                if (!isset($groupurls[$feature])) {
                    continue;
                }

                $url = new \moodle_url($groupurls[$feature]);
                $strresourcename = get_string('groups_'.$feature, 'local_o365');
                $icon = $OUTPUT->pix_icon('groups'.$feature, $strresourcename, 'local_o365');
                $links[] = \html_writer::link($url, $icon.$strresourcename, ['target' => '_blank']);
            }
            echo \html_writer::alist($links);
        }

        if (has_capability('local/o365:managegroups', $this->context)) {
            $url = new \moodle_url('/local/o365/groupcp.php',
                ['action' => 'editgroup', 'id' => $group->id, 'courseid' => $courseid]);
            $streditgroup = get_string('groups_editsettings', 'local_o365');
            $html = \html_writer::tag('h5', \html_writer::link($url, $streditgroup));
            echo \html_writer::tag('div', $html);
        }

        echo \html_writer::end_div();
        echo $this->standard_footer();
    }

    /**
     * Default mode - show connection status and a list of features to manage.
     */
    public function mode_default() {
        $this->mode_viewgroup();
    }
}
