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
 * Clear user tokens form.
 *
 * @package auth_oidc
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc\form;

use moodleform;

/**
 * Class clear_user_tokens_form represents the form on the clear user tokens page.
 */
class clear_user_tokens_form extends moodleform {
    /**
     * Form definition.
     *
     * @return void
     */
    public function definition() {
        $mform =& $this->_form;

        $mform->addElement('radio', 'scope', '', get_string('clear_user_tokens_scope_selected', 'auth_oidc'), 'selected');
        $mform->addElement(
            'autocomplete',
            'userids',
            get_string('clear_user_tokens_users', 'auth_oidc'),
            [],
            ['ajax' => 'core_user/form_user_selector', 'multiple' => true]
        );
        $mform->hideIf('userids', 'scope', 'neq', 'selected');
        $mform->addElement('radio', 'scope', '', get_string('clear_user_tokens_scope_all', 'auth_oidc'), 'all');
        $mform->setDefault('scope', 'selected');
        $mform->setType('scope', PARAM_ALPHA);

        $this->add_action_buttons(false, get_string('clear_user_tokens_submit', 'auth_oidc'));
    }

    /**
     * Validate the submitted data.
     *
     * @param array $data Submitted data.
     * @param array $files Submitted files.
     * @return array Validation errors, indexed by element name.
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if ($data['scope'] === 'selected' && empty($data['userids'])) {
            $errors['userids'] = get_string('clear_user_tokens_no_user_selected', 'auth_oidc');
        }

        return $errors;
    }
}
