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
 * Clears the Microsoft Teams tab theme override from the current session.
 *
 * theme_boost_o365teams calls this when it detects that it is rendering outside of a Microsoft
 * Teams tab despite the session still forcing the Teams theme, which otherwise leaks the Teams-only
 * theme into direct browser access to Moodle (see microsoft/o365-moodle#1278).
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

use core\context\system;

define('AJAX_SCRIPT', true);
require_once(__DIR__ . '/../../config.php');

require_login();
require_sesskey();

$PAGE->set_context(system::instance());

unset($SESSION->theme);
unset($SESSION->local_o365_teamstheme);

http_response_code(200);
