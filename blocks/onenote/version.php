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
 * This file contains the version information for the OneNote block plugin
 *
 * @package block_onenote
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2014091614;
$plugin->requires  = 2014051200;
$plugin->component = 'block_onenote';
$plugin->maturity = MATURITY_STABLE;
$plugin->release = '1.0.0.0';
$plugin->dependencies = array('local_onenote' => 2014110503);
