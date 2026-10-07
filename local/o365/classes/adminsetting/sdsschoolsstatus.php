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
 * Informational heading reporting the SDS school list retrieval status.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

use admin_setting_heading;
use html_writer;
use local_o365\feature\sds\utils;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/lib/adminlib.php');

/**
 * Heading that shows a message when the SDS school list cannot be retrieved.
 *
 * The Graph API is only queried when the heading is rendered, so building the full admin tree
 * (for example on /admin/search.php) does not trigger a Graph API call.
 */
class sdsschoolsstatus extends admin_setting_heading {
    /**
     * Constructor.
     *
     * @param string $name unique ascii name
     */
    public function __construct($name) {
        parent::__construct($name, '', '');
    }

    /**
     * Return the HTML for this heading, or an empty string when the school list was retrieved successfully.
     *
     * @param mixed $data
     * @param string $query
     * @return string
     */
    public function output_html($data, $query = '') {
        $message = $this->get_status_message();
        if ($message === '') {
            return '';
        }

        // Set the description only for this render and restore it afterwards, so the transient message does not leak
        // into a later render or into is_related().
        $original = $this->description;
        $this->description = $message;
        $html = parent::output_html($data, $query);
        $this->description = $original;

        return $html;
    }

    /**
     * This heading is not a real setting and must never appear in the admin settings search results.
     *
     * @param string $query
     * @return bool always false
     */
    public function is_related($query) {
        return false;
    }

    /**
     * Return the message to show for the current SDS school list retrieval status, or an empty string when it succeeded.
     *
     * @return string
     */
    protected function get_status_message(): string {
        [$status] = utils::get_settings_schools();

        switch ($status) {
            case 'noschools':
                return get_string('settings_sds_noschools', 'local_o365');
            case 'notconnected':
                return html_writer::div(get_string('error_not_connected', 'local_o365'), 'alert alert-info');
            case 'ok':
                return '';
            default:
                // Status 'error' - the school list could not be retrieved.
                return get_string('settings_sds_get_schools_error', 'local_o365');
        }
    }
}
