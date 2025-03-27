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
 * Observer functions for sharing link management.
 *
 * @package local_o365
 * @author Ivo Bättig ivo@joker-it.ch>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_o365\feature\sharing;

use core\event\course_module_updated;
use core\event\course_section_updated;
use local_o365\utils;
use moodle_exception;

defined('MOODLE_INTERNAL') || die();

/**
 * Observer functions for sharing link management.
 */
class observers {

    /**
     * Handle course section visibility changes.
     *
     * @param course_section_updated $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_section_updated(course_section_updated $event): bool {
        global $DB;

        // Only process events with visibility changes.
        $eventdata = $event->get_record_snapshot('course_sections', $event->objectid);
        if (!isset($eventdata->visible)) {
            return true;
        }

        try {
            $sharingmanager = new main();
            $visibilitychanged = false;

            // Check if visibility changed by comparing with other data.
            $othersectioninfo = $event->other;
            if (isset($othersectioninfo['oldvisible']) && $othersectioninfo['oldvisible'] != $eventdata->visible) {
                $visibilitychanged = true;
            }

            if (!$visibilitychanged) {
                // No visibility change, nothing to do.
                return true;
            }

            // Get all course modules in this section.
            $modules = $DB->get_records('course_modules', [
                'course' => $eventdata->course,
                'section' => $eventdata->id,
            ]);

            if (empty($modules)) {
                // No modules in the section, nothing to do.
                return true;
            }

            foreach ($modules as $module) {
                if ($eventdata->visible) {
                    // Section is now visible, create sharing links for modules.
                    // Only create links if the module itself is visible.
                    if ($module->visible) {
                        $sharingmanager->create_sharing_links_for_module($module->id);
                    }
                } else {
                    // Section is now hidden, delete sharing links for all modules in the section.
                    $sharingmanager->delete_sharing_links_for_module($module->id);
                }
            }

            return true;
        } catch (moodle_exception $e) {
            utils::debug('Error in handle_section_updated: ' . $e->getMessage(), __METHOD__, $e);
            return false;
        }
    }

    /**
     * Handle course module visibility changes.
     *
     * @param course_module_updated $event The triggered event.
     * @return bool Success/Failure.
     */
    public static function handle_module_updated(course_module_updated $event): bool {
        try {
            // Get module information.
            $eventdata = $event->get_record_snapshot('course_modules', $event->objectid);
            if (!isset($eventdata->visible)) {
                return true;
            }

            $visibilitychanged = false;

            // Check if visibility changed by comparing with other data.
            $othermoduleinfo = $event->other;
            if (isset($othermoduleinfo['visible']) && $othermoduleinfo['visible'] != $eventdata->visible) {
                $visibilitychanged = true;
            }

            if (!$visibilitychanged) {
                // No visibility change, nothing to do.
                return true;
            }

            $sharingmanager = new main();

            if ($eventdata->visible) {
                // Module is now visible, create sharing links.
                // We need to check if the section is visible as well.
                $section = self::get_section_info($eventdata->course, $eventdata->section);
                if ($section && $section->visible) {
                    $sharingmanager->create_sharing_links_for_module($eventdata->id);
                }
            } else {
                // Module is now hidden, delete sharing links.
                $sharingmanager->delete_sharing_links_for_module($eventdata->id);
            }

            return true;
        } catch (moodle_exception $e) {
            utils::debug('Error in handle_module_updated: ' . $e->getMessage(), __METHOD__, $e);
            return false;
        }
    }

    /**
     * Helper function to get section information.
     *
     * @param int $courseid The course ID.
     * @param int $sectionid The section ID.
     * @return object|null The section information or null if not found.
     */
    private static function get_section_info(int $courseid, int $sectionid) {
        global $DB;
        
        // Try to get section by ID.
        $section = $DB->get_record('course_sections', ['id' => $sectionid]);
        if ($section) {
            return $section;
        }
        
        // If section not found by ID, try to get it by course and section number.
        return $DB->get_record('course_sections', ['course' => $courseid, 'section' => $sectionid]);
    }
}