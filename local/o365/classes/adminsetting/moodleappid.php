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
 * Admin setting for the Moodle app ID in the Teams app catalog.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

use admin_setting_configtext;
use moodle_exception;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/lib/adminlib.php');
require_once($CFG->dirroot . '/local/o365/lib.php');

/**
 * Config text for the Moodle app ID, appending the auto-detected catalog app ID to the description when rendered.
 *
 * The Graph API is only queried when the setting is rendered, so building the full admin tree
 * (for example on /admin/search.php) does not trigger a Graph API call.
 */
class moodleappid extends admin_setting_configtext {
    /**
     * Return the XHTML for this setting, with the auto-detected catalog app ID appended to the description.
     *
     * @param mixed $data
     * @param string $query
     * @return string
     */
    public function output_html($data, $query = '') {
        $originaldescription = $this->description;
        $this->description .= $this->get_auto_id_description();
        $html = parent::output_html($data, $query);
        $this->description = $originaldescription;

        return $html;
    }

    /**
     * Query the Graph API for the catalog app ID and return the description snippet to append, or an empty string.
     *
     * @return string
     */
    protected function get_auto_id_description(): string {
        if (\local_o365\utils::is_connected() !== true) {
            return '';
        }

        try {
            $graphclient = \local_o365\utils::get_api();
        } catch (moodle_exception $e) {
            return '';
        }
        if (!$graphclient) {
            return '';
        }

        $teamsmoodleappexternalid = get_config('local_o365', 'teams_moodle_app_external_id');
        if (!$teamsmoodleappexternalid) {
            $teamsmoodleappexternalid = TEAMS_MOODLE_APP_EXTERNAL_ID;
        }

        try {
            $moodleappid = $graphclient->get_catalog_app_id($teamsmoodleappexternalid);
        } catch (moodle_exception $e) {
            debugging('Error getting catalog app ID. Details: ' . $e->getMessage(), DEBUG_NORMAL);
            return '';
        }

        if (!$moodleappid) {
            return '';
        }

        return get_string('settings_moodle_app_id_desc_auto_id', 'local_o365', $moodleappid);
    }
}
