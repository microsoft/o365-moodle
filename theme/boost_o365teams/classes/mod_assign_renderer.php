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
 * Boost o365teams mod_assign renderer.
 *
 * @package    theme_boost_o365teams
 * @copyright  2018 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/assign/classes/output/renderer.php');
require_once($CFG->dirroot . '/mod/assign/classes/output/assign_header.php');

/**
 * mod_assign
 *
 * @package    theme_boost_o365teams
 * @copyright  2018 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_boost_o365teams_mod_assign_renderer extends mod_assign\output\renderer {
    /**
     * Render the header.
     *
     * @param mod_assign\output\assign_header $header
     * @return string
     */
    public function render_assign_header(mod_assign\output\assign_header $header) {
        if ($header->subpage) {
            $this->page->navbar->add($header->subpage, $header->subpageurl);
        }

        $heading = format_string($header->assign->name, false, ['context' => $header->context]);
        $this->page->set_title($heading);
        $this->page->set_heading($this->page->course->fullname);

        $description = $header->preface;
        if ($header->showintro) {
            $description = $this->output->box_start('generalbox boxaligncenter', 'intro');
            if ($header->showintro) {
                $description .= format_module_intro('assign', $header->assign, $header->coursemoduleid);
            }

            $description .= $header->postfix;
            $description .= $this->output->box_end();
        }

        $activityheader = $this->page->activityheader;
        $activityheader->set_attrs([
            'title' => $activityheader->is_title_allowed() ? $heading : '',
            'description' => $description,
        ]);

        return $this->output->header();
    }
}
