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
 * Admin setting for the SDS course sync school selector.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

use admin_setting_configmulticheckbox;
use core_text;
use local_o365\feature\sds\utils;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/lib/adminlib.php');

/**
 * Multi checkbox of SDS schools, with the school list loaded lazily from the Graph API.
 *
 * The choices are only fetched when the setting is actually rendered, so building the full admin tree
 * (for example on /admin/search.php) does not trigger a Graph API call.
 */
class sdsschools extends admin_setting_configmulticheckbox {
    /**
     * Load the list of schools from the Graph API on demand.
     *
     * Returns false when the list cannot be retrieved: the parent renderer then suppresses the checkbox list (rather
     * than showing an empty one) and the sdsschoolsstatus heading explains why. write_setting() also relies on this to
     * leave a previously configured school list untouched, so a transient failure does not silently disable course sync.
     *
     * @return bool true if the school list was retrieved, false otherwise
     */
    public function load_choices() {
        if (is_array($this->choices)) {
            return true;
        }

        [$status, $schools] = utils::get_settings_schools();
        if ($status !== 'ok') {
            return false;
        }

        $this->choices = $schools;

        return true;
    }

    /**
     * Save the submitted value, unless the school list could not be retrieved.
     *
     * @param array $data
     * @return string empty string on success, error message otherwise
     */
    public function write_setting($data) {
        if (!$this->load_choices()) {
            return '';
        }

        return parent::write_setting($data);
    }

    /**
     * Is this setting related to the given query text.
     *
     * Deliberately matches only on the static name, visible name and description so that searching the admin settings
     * does not load the school list from the Graph API.
     *
     * @param string $query
     * @return bool true if related, false if not
     */
    public function is_related($query) {
        if (strpos(strtolower($this->name), $query) !== false) {
            return true;
        }
        if (strpos(core_text::strtolower($this->visiblename), $query) !== false) {
            return true;
        }
        if (strpos(core_text::strtolower($this->description), $query) !== false) {
            return true;
        }

        return false;
    }
}
