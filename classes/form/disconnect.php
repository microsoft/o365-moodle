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
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

namespace auth_oidc\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * OIDC Disconnect Form.
 */
class disconnect extends \moodleform {
    /**
     * Form definition.
     */
    protected function definition() {
        global $USER;

        $authconfig = get_config('auth_oidc');
        $opname = (!empty($authconfig->opname)) ? $authconfig->opname : get_string('pluginname', 'auth_oidc');

        $mform =& $this->_form;
        $mform->addElement('html', \html_writer::tag('h4', get_string('ucp_disconnect_title', 'auth_oidc', $opname)));
        $mform->addElement('html', \html_writer::div(get_string('ucp_disconnect_details', 'auth_oidc', $opname)));
        $mform->addElement('html', '<br />');

        $mform->addElement('header', 'userdetails', get_string('userdetails'));
        $mform->addElement('text', 'username', get_string('username'));
        $mform->addElement('passwordunmask', 'password', get_string('password'));

        $mform->setType('username', PARAM_USERNAME);
        $mform->addRule('username', null, 'required', null, 'client');
        $mform->addRule('password', null, 'required', null, 'client');

        // If the user cannot choose a username, set it to their current username and freeze.
        if (isset($this->_customdata['canchooseusername']) && $this->_customdata['canchooseusername'] == false) {
            $mform->setDefault('username', $USER->username);
            $element = $mform->getElement('username');
            $element->freeze();
        }

        $this->add_action_buttons();
    }
}
