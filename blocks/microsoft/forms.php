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
 * Define forms used by the plugin.
 *
 * @package block_microsoft
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2021 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot . '/local/o365/lib.php');

/**
 * Class block_microsoft_course_configure_team_form.
 * Form to configure course Team reset actions.
 */
class block_microsoft_course_configure_team_form extends moodleform {
    /**
     * Form definition.
     */
    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'course');
        $mform->setType('course', PARAM_INT);

        $resetoptions = [];
        $resetoptions[] = $mform->createElement('radio', 'reset_setting', '',
            get_string('teams_reset_option_do_nothing', 'block_microsoft'), TEAMS_COURSE_RESET_SETTING_DO_NOTHING);
        $resetoptions[] = $mform->createElement('radio', 'reset_setting', '',
            get_string('teams_reset_option_disconnect', 'block_microsoft'), TEAMS_COURSE_RESET_SETTING_DISCONNECT);
        $mform->addGroup($resetoptions, 'resetsettinggroup', get_string('course_reset_team_option', 'block_microsoft'),
            '<br/><br/>', false);
        $mform->setDefault('reset_setting', TEAMS_COURSE_RESET_SETTING_DO_NOTHING);

        $this->add_action_buttons();
    }
}

/**
 * Class block_microsoft_course_configure_group_form.
 * Form to configure course group reset actions.
 */
class block_microsoft_course_configure_group_form extends moodleform {
    /**
     * Form definition.
     */
    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'course');
        $mform->setType('course', PARAM_INT);

        $resetoptions = [];
        $resetoptions[] = $mform->createElement('radio', 'reset_setting', '',
            get_string('group_reset_option_do_nothing', 'block_microsoft'), GROUP_COURSE_RESET_SETTING_DO_NOTHING);
        $resetoptions[] = $mform->createElement('radio', 'reset_setting', '',
            get_string('group_reset_option_disconnect', 'block_microsoft'), GROUP_COURSE_RESET_SETTING_DISCONNECT);
        $mform->addGroup($resetoptions, 'resetsettinggroup', get_string('course_reset_group_option', 'block_microsoft'),
            '<br/><br/>', false);
        $mform->setDefault('reset_setting', GROUP_COURSE_RESET_SETTING_DO_NOTHING);

        $this->add_action_buttons();
    }
}
