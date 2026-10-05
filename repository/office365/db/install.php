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
 * Post-install script for repository_office365.
 *
 * @package    repository_office365
 * @copyright  2026 Microsoft, Inc.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Set default configuration on install.
 *
 * @return bool True on success.
 */
function xmldb_repository_office365_install() {
    set_config('enableinternal', 1, 'office365');
    set_config('enablecoursegroup', 1, 'office365');
    set_config('enableonedrivegroup', 1, 'office365');
    set_config('enabletrendinggroup', 1, 'office365');

    return true;
}
