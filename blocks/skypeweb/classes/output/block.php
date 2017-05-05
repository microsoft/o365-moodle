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

namespace block_skypeweb\output;

defined('MOODLE_INTERNAL') || die();

class block implements \renderable, \templatable {

    /**
     * Contructor
     */
    public function __construct() {
    }

    /**
     * Prepare data for use in a template
     *
     * @param \renderer_base $output
     * @return array Template data
     */
    public function export_for_template(\renderer_base $output) {
        $data = [
            'redirecturi' => new \moodle_url('/blocks/skypeweb/skypeloginreturn.php')
        ];
        return $data;
    }
}

