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
 * Admin setting for the SDS profile sync school selector.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

use admin_setting_configselect;
use core_text;
use lang_string;
use local_o365\feature\sds\utils;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/lib/adminlib.php');

/**
 * Select of SDS schools for profile sync, with the school list loaded lazily from the Graph API.
 *
 * The choices are only fetched when the setting is actually rendered, so building the full admin tree
 * (for example on /admin/search.php) does not trigger a Graph API call.
 */
class sdsprofilesync extends admin_setting_configselect {
    /**
     * Populate the list of choices on demand.
     *
     * Always fills $this->choices: the full school list from the Graph API when it can be retrieved, otherwise just
     * "Disabled" plus the currently stored school, so the form still reflects the effective configuration.
     *
     * @return bool always true
     */
    public function load_choices() {
        if (is_array($this->choices)) {
            return true;
        }

        $this->choices = ['' => new lang_string('settings_sds_profilesync_disabled', 'local_o365')];

        [$status, $schools] = utils::get_settings_schools();
        if ($status !== 'ok') {
            // The school list is unavailable. Keep the currently stored school as a choice so the form reflects the
            // effective configuration instead of falling back to display the first ("Disabled") option.
            $current = $this->get_setting();
            if (!empty($current)) {
                $this->choices[$current] = get_string('settings_sds_school_unavailable', 'local_o365', $current);
            }

            return true;
        }

        $schoolchoices = [];
        foreach ($schools as $schoolid => $schoolname) {
            $schoolchoices[$schoolid] = $schoolname . ' (' . $schoolid . ')';
        }
        asort($schoolchoices);
        $this->choices += $schoolchoices;

        return true;
    }

    /**
     * Save the submitted value, unless the school list could not be retrieved.
     *
     * When the Graph API is unavailable the school choices are not authoritative, so leave a previously configured
     * school untouched rather than risk clearing it from a stale form submission.
     *
     * @param string $data
     * @return string empty string on success, error message otherwise
     */
    public function write_setting($data) {
        [$status] = utils::get_settings_schools();
        if ($status !== 'ok') {
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
