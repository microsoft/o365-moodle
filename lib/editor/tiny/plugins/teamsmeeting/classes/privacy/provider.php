<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Privacy API implementation for TinyMCE Teams Meeting plugin for Moodle.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tiny_teamsmeeting\privacy;

use core_privacy\local\metadata\collection;

defined('MOODLE_INTERNAL') || die();

/**
 * Privacy API implementation for the Teams Meeting plugin.
 *
 * @package     tiny_teamsmeeting
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\local\metadata\provider {

    /**
     * Get the metadata about this system.
     *
     * @param collection $collection The initialised collection to add items to.
     * @return collection The collection with information about the system.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_external_location_link('msteamsapp', ['userlang' => 'privacy:metadata:msteamsapp:userlang'],
            'privacy:metadata:msteamsapp');

        return $collection;
    }
}
