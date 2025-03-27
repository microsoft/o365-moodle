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
 * Main class for sharing links functionality.
 *
 * @package local_o365
 * @author Your Name <your.email@example.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2025 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\sharing;

use local_o365\feature\coursesync\main as coursesync_main;
use local_o365\rest\unified;
use local_o365\utils;
use moodle_exception;
use stdClass;

defined('MOODLE_INTERNAL') || die();

/**
 * Main class for sharing links functionality.
 */
class main {

    /**
     * Get the Microsoft Graph API client.
     *
     * @return unified The Microsoft Graph API client.
     */
    protected function get_graph_api_client() {
        return coursesync_main::get_unified_api(__METHOD__);
    }

    /**
     * Delete sharing links for a module.
     *
     * @param int $moduleid The ID of the course module to delete sharing links for.
     * @return bool Success/Failure.
     */
    public function delete_sharing_links_for_module(int $moduleid): bool {
        global $DB;

        try {
            // Delete all sharing links for this module from the database.
            $DB->delete_records('local_o365_sharing', ['moduleid' => $moduleid]);
            return true;
        } catch (moodle_exception $e) {
            utils::debug('Error in delete_sharing_links_for_module: ' . $e->getMessage(), __METHOD__, $e);
            return false;
        }
    }

    /**
     * Create sharing links for a course module.
     *
     * @param int $moduleid The ID of the course module to create sharing links for.
     * @return bool Success/Failure.
     */
    public function create_sharing_links_for_module(int $moduleid): bool {
        global $DB;
        
        try {
            // First, check if the module is visible.
            $module = $DB->get_record('course_modules', ['id' => $moduleid]);
            if (!$module || !$module->visible) {
                // Module is not visible, don't create sharing links.
                return false;
            }

            // Check if the section is visible.
            $section = $DB->get_record('course_sections', ['id' => $module->section]);
            if (!$section || !$section->visible) {
                // Section is not visible, don't create sharing links.
                return false;
            }

            // Get the course.
            $course = $DB->get_record('course', ['id' => $module->course]);
            if (!$course) {
                return false;
            }

            // Check if course sync is enabled for this course.
            $coursesyncenabled = $this->is_course_sync_enabled($course->id);
            if (!$coursesyncenabled) {
                // Course sync not enabled, don't create sharing links.
                return false;
            }
            
            // Get Microsoft 365 group ID for the course.
            $groupobject = $DB->get_record('local_o365_objects', [
                'type' => 'group',
                'subtype' => 'courseteam',
                'moodleid' => $course->id
            ]);
            
            if (empty($groupobject)) {
                // No Microsoft 365 group for this course, nothing to do.
                return false;
            }
            
            // Now we can recreate sharing links for this module.
            $apiclient = $this->get_graph_api_client();
            if (!$apiclient) {
                return false;
            }

            // Get Microsoft 365 files associated with this module
            // In a real implementation, you would need to identify files associated with the module
            // and get their Microsoft 365 file IDs. This would depend on how files are stored and managed
            // in your Moodle-Microsoft 365 integration.
            
            // For demonstration purposes, let's simulate getting OneDrive files associated with the module.
            $modulefiles = $this->get_module_files($moduleid);
            
            if (empty($modulefiles)) {
                // No files found for this module.
                return true;
            }
            
            $now = time();
            
            // Process each file and create a sharing link.
            foreach ($modulefiles as $file) {
                // Check if a sharing link already exists for this file.
                $existinglink = $DB->get_record('local_o365_sharing', [
                    'moduleid' => $moduleid, 
                    'fileid' => $file->fileid
                ]);
                
                if ($existinglink) {
                    // Link already exists, skip this file.
                    continue;
                }
                
                try {
                    // Create sharing link for the file using Microsoft Graph API.
                    $sharinglink = $apiclient->get_sharing_link($file->fileid, $groupobject->objectid);
                    
                    // Save the sharing link to the database.
                    $sharinglinkrecord = new stdClass();
                    $sharinglinkrecord->moduleid = $moduleid;
                    $sharinglinkrecord->fileid = $file->fileid;
                    $sharinglinkrecord->filename = $file->filename;
                    $sharinglinkrecord->sharelink = $sharinglink;
                    $sharinglinkrecord->timecreated = $now;
                    $sharinglinkrecord->timemodified = $now;
                    
                    $DB->insert_record('local_o365_sharing', $sharinglinkrecord);
                } catch (moodle_exception $e) {
                    utils::debug('Error creating sharing link for file: ' . $file->fileid . ' - ' . $e->getMessage(), __METHOD__, $e);
                    // Continue with other files even if one fails.
                }
            }
            
            return true;
        } catch (moodle_exception $e) {
            utils::debug('Error in create_sharing_links_for_module: ' . $e->getMessage(), __METHOD__, $e);
            return false;
        }
    }

    /**
     * Get files associated with a module.
     * 
     * Note: This is a simplified implementation that would need to be adapted to your
     * specific Microsoft 365 integration to correctly identify OneDrive/SharePoint files.
     *
     * @param int $moduleid The ID of the course module.
     * @return array Array of file objects with fileid and filename properties.
     */
    protected function get_module_files(int $moduleid): array {
        global $DB;
        
        // This is a placeholder implementation.
        // In a complete implementation, you would need to:
        // 1. Get the files from the Moodle files table associated with this module
        // 2. For each file, find its corresponding Microsoft 365 file ID
        
        // For this example, let's check if there are any files in the database that might have 
        // Microsoft 365 file IDs associated with them.
        $result = [];
        
        // In a real implementation, this would need to query the appropriate tables that store
        // the mapping between Moodle files and Microsoft 365 file IDs.
        
        // This is just a placeholder that needs to be replaced with actual implementation.
        // For now, we'll return an empty array indicating no files to process.
        
        return $result;
    }

    /**
     * Check if course sync is enabled for the given course.
     *
     * @param int $courseid The course ID.
     * @return bool Whether course sync is enabled.
     */
    protected function is_course_sync_enabled(int $courseid): bool {
        return \local_o365\feature\coursesync\utils::is_course_sync_enabled($courseid);
    }
}