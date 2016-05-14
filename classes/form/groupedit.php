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

namespace local_o365\form;

/**
 * A form for editing of groups office 365 groups.
 *
 * @copyright 2016 Remote-leaner Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Group form class
 *
 * @copyright 2006 The Open University, N.D.Freear AT open.ac.uk, J.White AT open.ac.uk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   core_group
 */
class groupedit extends \moodleform {

    /**
     * Definition of the form.
     */
    public function definition() {
        global $USER, $CFG, $COURSE;
        $coursecontext = \context_course::instance($COURSE->id);

        $mform =& $this->_form;
        $editoroptions = $this->_customdata['editoroptions'];

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text','displayname', get_string('groups_edit_name', 'local_o365'),'maxlength="254" size="50"');
        $mform->addRule('displayname', get_string('required'), 'required', null, 'client');
        $mform->setType('displayname', PARAM_TEXT);

        $mform->addElement('editor', 'description_editor', get_string('groups_edit_description', 'local_o365'), null, $editoroptions);
        $mform->setType('description_editor', PARAM_RAW);

        $mform->addElement('static', 'currentpicture', get_string('currentpicture'));

        $mform->addElement('checkbox', 'deletepicture', get_string('delete'));
        $mform->setDefault('deletepicture', 0);

        $mform->addElement('filepicker', 'imagefile', get_string('groups_edit_newpicture', 'local_o365'));
        $mform->addHelpButton('imagefile', 'groups_edit_newpicture', 'local_o365');

        $mform->addElement('hidden','id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden','groupid');
        $mform->setType('groupid', PARAM_INT);

        $mform->addElement('hidden','courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons();
    }

    /**
     * Extend the form definition after the data has been parsed.
     */
    public function definition_after_data() {
        global $COURSE, $DB;

        $mform = $this->_form;
        $groupid = $mform->getElementValue('id');

        if ($o365group = $DB->get_record('local_o365_coursegroupdata', ['id' => $groupid])) {
            // Check permissions for security.
            $context = \context_course::instance($o365group->courseid);
            require_capability('local/o365:managegroups', $context);
            if (!empty($o365group->groupid)) {
                // If managing a Moodle course group require access to groups.
                require_capability('moodle/course:managegroups', $context);
            }
            $haspic = false;
            $pic = '';
            if ($o365group->picture) {
                if ($pic = \local_o365\feature\usergroups\utils::print_group_picture($o365group)) {
                    $haspic = true;
                }
            }
            if (!$haspic) {
                $pic = get_string('none');
                if ($mform->elementExists('deletepicture')) {
                    $mform->removeElement('deletepicture');
                }
            }
            $imageelement = $mform->getElement('currentpicture');
            $imageelement->setValue($pic);
        } else {
            if ($mform->elementExists('currentpicture')) {
                $mform->removeElement('currentpicture');
            }
            if ($mform->elementExists('deletepicture')) {
                $mform->removeElement('deletepicture');
            }
        }

    }

    /**
     * Form validation
     *
     * @param array $data
     * @param array $files
     * @return array $errors An array of errors
     */
    public function validation($data, $files) {
        global $COURSE, $DB, $CFG;

        $errors = parent::validation($data, $files);

        // Ensure display name is unique.
        $displayname = trim($data['displayname']);
        if ($data['id'] and $o365group = $DB->get_record('local_o365_coursegroupdata', ['id' => $data['id']])) {
            if (\core_text::strtolower($o365group->displayname) != \core_text::strtolower($displayname)) {
                if ($DB->get_record('local_o365_coursegroupdata', ['displayname' => $displayname])) {
                    $errors['displayname'] = get_string('groups_edit_nameexists', 'local_o365', $displayname);
                }
            }
        } else if ($DB->get_record('local_o365_coursegroupdata', ['displayname' => $displayname])) {
            $errors['displayname'] = get_string('groups_edit_nameexists', 'local_o365', $displayname);
        }
        return $errors;
    }

    /**
     * Get editor options for this form
     *
     * @return array An array of options
     */
    public function get_editor_options() {
        return $this->_customdata['editoroptions'];
    }
}
