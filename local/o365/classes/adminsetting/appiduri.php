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
 * @copyright (C) 2016 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

/**
 * Displays the APP ID URI for easier config.
 */
class appiduri extends \admin_setting {

    /**
     * Constructor.
     *
     * @param string $name Name of the setting.
     * @param string $visiblename Visible name of the setting.
     * @param string $description Description of the setting.
     * @param array $defaultsetting Default value.
     * @param array $choices Array of icon choices.
     */
    public function __construct($name, $heading, $description) {
        $this->nosave = true;
        parent::__construct($name, $heading, $description, '');
    }

    /**
     * Always returns true because we have no real setting.
     *
     * @return bool Always returns true
     */
    public function get_setting() {
        return true;
    }

    /**
     * Always returns true because we have no real setting.
     *
     * @return bool Always returns true
     */
    public function get_defaultsetting() {
        return true;
    }

    /**
     * Never write settings.
     *
     * @return string Always returns an empty string.
     */
    public function write_setting($data) {
        return '';
    }

    /**
     * Returns an HTML string for the setting.
     *
     * @return string Returns an HTML string.
     */
    public function output_html($data, $query = '') {
        global $CFG;
        $wwwroot = (!empty($CFG->loginhttps)) ? str_replace('http://', 'https://', $CFG->wwwroot) : $CFG->wwwroot;
        $html = \html_writer::tag('h5', $wwwroot);
        return format_admin_setting($this, $this->visiblename, $html, $this->description, true, '', null, $query);
    }
}
