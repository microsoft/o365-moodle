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
 * Installation file for the OneNote repository
 * @package    repository_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft Open Technologies, Inc. (based on files by 2012 Lancaster University Network Services Ltd)
 */

/**
 * Create a default instance of the onenote repository
 *
 * @return bool A status indicating success or failure
 */
function xmldb_repository_onenote_install() {
    global $CFG;
    $result = true;
    require_once($CFG->dirroot.'/repository/lib.php');
    $onenoteplugin = new repository_type('onenote', array(), true);
    if (!$id = $onenoteplugin->create(true)) {
        $result = false;
    }
    return $result;
}
