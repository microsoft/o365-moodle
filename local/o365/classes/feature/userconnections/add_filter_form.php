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
 * "Add filter" form for the manage user connections page.
 *
 * @package local_o365
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2025 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\userconnections;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/user/filters/lib.php');

/**
 * "Add filter" form with a shorter section header.
 *
 * Identical to the core user_add_filter_form except that the generic "New filter" section header is renamed to the
 * shorter "Filter". The form identifier is kept the same as the parent so that submission handling is unchanged.
 */
class add_filter_form extends \user_add_filter_form {
    /**
     * Use the parent form identifier so the submission markers and session handling behave exactly like the core form.
     *
     * @return string
     */
    protected function get_form_identifier() {
        return 'user_add_filter_form';
    }

    /**
     * Form definition.
     */
    public function definition() {
        parent::definition();

        if ($this->_form->elementExists('newfilter')) {
            $this->_form->getElement('newfilter')->setText(get_string('filter'));
        }
    }
}
