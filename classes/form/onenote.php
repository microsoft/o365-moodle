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

/**
 * o365 OneNote Preferences form.
 */
class onenote extends \moodleform {
    /**
     * Form definition.
     */
    protected function definition() {
        global $USER;

        $mform =& $this->_form;

        $mform->addElement('html', \html_writer::tag('h2', get_string('ucp_onenote_title', 'local_o365')));
        $mform->addElement('html', \html_writer::div(get_string('ucp_onenote_desc', 'local_o365')));
        $mform->addElement('html', '<br />');
        $mform->addElement('html', \html_writer::tag('b', get_string('ucp_options', 'local_o365')));
        $mform->addElement('advcheckbox', 'disableo365onenote', get_string('ucp_onenote_disable', 'local_o365'));

        $this->add_action_buttons();
    }
}
