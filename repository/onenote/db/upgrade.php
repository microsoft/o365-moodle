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
 * @package    repository_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft Open Technologies, Inc. (based on files by 2012 Lancaster University Network Services Ltd)
 */

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_repository_onenote_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014103001) {
        if (!$dbman->table_exists('repository_onenote')) {
            $dbman->install_one_table_from_xmldb_file(__DIR__.'/install.xml', 'repository_onenote');
        }
        upgrade_plugin_savepoint(true, 2014103001, 'repository', 'onenote');
    }

    return true;
}
