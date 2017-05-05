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
 * @package   block_skypeweb
 */

namespace block_skypeweb\output;

defined('MOODLE_INTERNAL') || die();

class renderer extends \plugin_renderer_base {

    /**
     * Render a skypeweb block
     *
     * @param \templatable $block
     * @return string|boolean
     */
    public function render_block(\templatable $block) {
        $data = $block->export_for_template($this);
        return $this->render_from_template('block_skypeweb/block', $data);
    }

    /**
     * Render block login page.
     *
     * @param \templatable $block
     * @return string|boolean
     */
    public function render_login(\templatable $block) {
        $data = $block->export_for_template($this);
        return $this->render_from_template('block_skypeweb/login', $data);
    }

}
