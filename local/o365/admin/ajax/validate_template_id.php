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
 * AJAX endpoint to validate a custom Teams template ID.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/o365/lib.php');

// Set content type for JSON responses.
header('Content-Type: application/json; charset=utf-8');

// Check admin access.
require_login();
require_capability('moodle/site:config', context_system::instance());
require_sesskey();

// Get the template ID from the request.
$templateid = optional_param('template_id', '', PARAM_TEXT);

if (empty($templateid)) {
    http_response_code(400);
    echo json_encode([
        'valid' => false,
        'message' => get_string('error_template_id_empty', 'local_o365'),
    ]);
    exit;
}

// Trim and validate the template ID.
$templateid = trim($templateid);

if (empty($templateid)) {
    http_response_code(400);
    echo json_encode([
        'valid' => false,
        'message' => get_string('error_template_id_empty', 'local_o365'),
    ]);
    exit;
}

// Try to validate the template ID using the Graph API.
try {
    // Check if connected to Office 365.
    if (\local_o365\utils::is_connected() !== true) {
        http_response_code(503);
        echo json_encode([
            'valid' => false,
            'message' => get_string('error_not_connected', 'local_o365'),
        ]);
        exit;
    }

    // Get the Graph API client.
    $graphclient = \local_o365\utils::get_api();
    if (!$graphclient) {
        http_response_code(503);
        echo json_encode([
            'valid' => false,
            'message' => get_string('error_graph_client_not_available', 'local_o365'),
        ]);
        exit;
    }

    // Validate the template ID by checking if it exists in the Graph API.
    try {
        $templateisvalid = $graphclient->validate_teams_template($templateid);
    } catch (Exception $e) {
        // Unexpected error during validation.
        http_response_code(500);
        debugging('Template validation error: ' . $e->getMessage(), DEBUG_DEVELOPER);
        echo json_encode([
            'valid' => false,
            'message' => get_string('error_template_validation_failed', 'local_o365', 'API error'),
        ]);
        exit;
    }

    if ($templateisvalid) {
        // Template is valid.
        $message = get_string('success_template_id_valid', 'local_o365', $templateid);
        echo json_encode([
            'valid' => true,
            'message' => $message,
        ]);
    } else {
        // Template not found.
        http_response_code(404);
        echo json_encode([
            'valid' => false,
            'message' => get_string('error_template_id_not_found', 'local_o365', $templateid),
        ]);
    }
    exit;
} catch (Exception $e) {
    // Outer catch - unexpected error. Keep exception details in debug log only, not in user-facing message.
    debugging('AJAX validate_template_id error: ' . $e->getMessage(), DEBUG_DEVELOPER);

    http_response_code(500);
    echo json_encode([
        'valid' => false,
        'message' => get_string('error_template_validation_error', 'local_o365'),
    ]);
    exit;
}
