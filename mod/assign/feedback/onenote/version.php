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
 * This file contains the version information for the OneNote feedback plugin
 * @package assignfeedback_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft Open Technologies, Inc. (based on files by NetSpot {@link http://www.netspot.com.au})
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version = 2015011605;
$plugin->requires = 2014051200;
$plugin->component = 'assignfeedback_onenote';
$plugin->maturity = MATURITY_STABLE;
$plugin->release = '27.0.0.4';
$plugin->dependencies = [
	'local_onenote' => 2015011604
];
