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
 * Cache definitions for the atto_teamsmeeting plugin.
 *
 * @package    atto_teamsmeeting
 * @copyright  2026 Enovation Solutions
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$definitions = [
    // Holds the language the dialogue was shown in, keyed by the single-use
    // result_token value, so result.php can render in that language even when
    // the cross-origin redirect back to it starts a fresh, cookie-less session
    // that would otherwise only know the user's profile default language.
    // The ttl mirrors result_token::TTL; entries are also deleted on first use.
    'resultlang' => [
        'mode' => cache_store::MODE_APPLICATION,
        'simplekeys' => true,
        'simpledata' => true,
        'ttl' => 1800,
    ],
];
