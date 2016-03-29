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
 * @package profilefield_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

/**
 * Class profile_field_oidc
 *
 * @copyright  2014 onwards James McQuillan
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class profile_field_oidc extends \profile_field_base {
    /**
     * Adds the profile field to the moodle form class
     *
     * @param moodleform $mform instance of the moodleform class
     */
    public function edit_field_add($mform) {
        return true;
    }

    public function display_data() {
        global $USER, $DB;

        $label = get_string('pluginname', 'profilefield_oidc');
        $authconfig = get_config('auth_oidc');
        if (!empty($authconfig->opname)) {
            $label = $authconfig->opname;
        }

        $vieweduser = $DB->get_record('user', ['id' => $this->userid]);
        if (!empty($vieweduser) && $vieweduser->auth === 'oidc') {
            $value = get_string('connected', 'profilefield_oidc', $label);
            $linkstr = get_string('connected_link', 'profilefield_oidc', $label);
        } else {
            $value = get_string('notconnected', 'profilefield_oidc', $label);
            $linkstr = get_string('notconnected_link', 'profilefield_oidc', $label);
        }
        if ($USER->id == $this->userid) {
            $manageurl = new \moodle_url('/auth/oidc/ucp.php');
            $value .= ' '.html_writer::link($manageurl, $linkstr);
        }

        return $value;
    }

    /**
     * Accessor method: Load the field record and user data associated with the
     * object's fieldid and userid
     * @internal This method should not generally be overwritten by child classes.
     */
    public function load_data() {
        parent::load_data();
        if (!empty($this->field)) {
            $label = get_string('pluginname', 'profilefield_oidc');
            $authconfig = get_config('auth_oidc');
            if (!empty($authconfig->opname)) {
                $label = $authconfig->opname;
            }
            $this->field->name = $label;
        }
    }

    /**
     * Check if the field data is considered empty
     * @internal This method should not generally be overwritten by child classes.
     * @return boolean
     */
    public function is_empty() {
        return false;
    }
}
