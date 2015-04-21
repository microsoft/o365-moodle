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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365\page;

/**
 * Basic page-style class handling page setup and page modes.
 */
class base {
    /** @var string The page's URL (relative to Moodle root). */
    protected $url = '';

    /** @var string The page's title. */
    protected $title = '';

    /** @var \context The page's context. */
    protected $context = null;

    /**
     * Constructor.
     *
     * @param string $url The page's URL (relative to Moodle root).
     * @param string $title The page's title.
     * @param \context $context The page's context.
     */
    public function __construct($url, $title, $context = null) {
        global $PAGE;
        $this->url = $url;
        $this->title = $title;
        $this->context = (!empty($context)) ? $context : \context_system::instance();
        $PAGE->set_url($this->url);
        $PAGE->set_context($this->context);
        $PAGE->set_pagelayout('standard');
        $PAGE->navbar->add($this->title, $this->url);
        $PAGE->set_title($this->title);
    }

    /**
     * Hook function run before the main page mode.
     *
     * @return bool True.
     */
    public function header() {
        return true;
    }

    /**
     * Run a page mode.
     *
     * @param string $mode The page mode to run.
     */
    public function run($mode) {
        $this->header();
        $methodname = (!empty($mode)) ? 'mode_'.$mode : 'mode_default';
        if (!method_exists($this, $methodname)) {
            $methodname = 'mode_default';
        }
        $this->$methodname();
    }
}