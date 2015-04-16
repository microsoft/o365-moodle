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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/lib/formslib.php');
\MoodleQuickForm::registerElementType('localo365calendar', "$CFG->dirroot/local/o365/classes/form/element/calendar.php", '\local_o365\form\element\calendar');

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

        $mform->addElement('html', \html_writer::tag('h2', get_string('ucp_calsync_title', 'local_o365')));
        $mform->addElement('html', \html_writer::div(get_string('ucp_calsync_desc', 'local_o365')));
        $mform->addElement('html', '<br />');
        $mform->addElement('html', \html_writer::tag('b', get_string('ucp_calsync_availcal', 'local_o365')));

        $checkboxattrs = ['class' => 'calcheckbox', 'group' => '1'];

        $sitecalcustom = $this->_customdata;
        $sitecalcustom['cansyncin'] = $this->_customdata['cancreatesiteevents'];
        $mform->addElement('localo365calendar', 'sitecal', '', get_string('calendar_site', 'local_o365'), $checkboxattrs, $sitecalcustom);

        $usercalcustom = $this->_customdata;
        $usercalcustom['cansyncin'] = true;
        $mform->addElement('localo365calendar', 'usercal', '', get_string('calendar_user', 'local_o365'), $checkboxattrs, $usercalcustom);

        foreach ($this->_customdata['usercourses'] as $courseid => $course) {
            $coursecalcustom = $this->_customdata;
            $coursecalcustom['cansyncin'] = (!empty($this->_customdata['cancreatecourseevents'][$courseid])) ? true : false;
            $mform->addElement('localo365calendar', 'coursecal['.$course->id.']', '', $course->fullname, $checkboxattrs, $coursecalcustom);
        }

        $this->add_action_buttons();
    }
}
