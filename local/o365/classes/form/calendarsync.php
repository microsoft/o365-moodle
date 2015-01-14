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
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

namespace local_o365\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * o365 Calendar Sync Form.
 */
class calendarsync extends \moodleform {
    /**
     * Form definition.
     */
    protected function definition() {
        global $USER;

        $mform =& $this->_form;

        $usercourses = enrol_get_my_courses(['id', 'fullname']);

        $mform->addElement('html', \html_writer::tag('h2', get_string('ucp_calsync_title', 'local_o365')));
        $mform->addElement('html', \html_writer::span(get_string('ucp_calsync_desc', 'local_o365')));

        $mform->addElement('advcheckbox', 'sitecal', '', get_string('calendar_site', 'local_o365'));
        $mform->addElement('advcheckbox', 'usercal', '', get_string('calendar_user', 'local_o365'));
        foreach ($usercourses as $courseid => $course) {
            $mform->addElement('advcheckbox', 'coursecal['.$course->id.']', '', $course->fullname);
        }

        $this->add_action_buttons();
    }
}
