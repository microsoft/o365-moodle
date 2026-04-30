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
 * Admin setting for custom Teams template ID (only enabled when custom template is selected).
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

use Exception;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/lib/adminlib.php');

/**
 * Admin setting for custom template ID, disabled unless team_type is set to 'custom'.
 */
class team_type_custom_id extends \admin_setting_configtext {
    /**
     * Validate and save the setting.
     *
     * @param mixed $data
     * @return string Empty if valid, error message otherwise
     */
    public function write_setting($data) {
        $data = trim($data);

        // Check if custom template is being used.
        $teamtype = get_config('local_o365', 'team_type');
        if ($teamtype === 'custom') {
            // Custom template is selected, validate the custom template ID.
            if (empty($data)) {
                return get_string('error_custom_template_id_required', 'local_o365');
            }

            // Validate the custom template ID using the Graph API.
            try {
                if (\local_o365\utils::is_connected() !== true) {
                    return get_string('error_not_connected', 'local_o365');
                }

                $graphclient = \local_o365\utils::get_api();
                if (!$graphclient) {
                    return get_string('error_graph_client_not_available', 'local_o365');
                }

                // Validate the template ID by checking if it exists.
                if (!$graphclient->validate_teams_template($data)) {
                    return get_string('error_custom_template_id_not_found', 'local_o365', $data);
                }

                // Template is valid, proceed with saving.
                return parent::write_setting($data);
            } catch (Exception $e) {
                return get_string('error_custom_template_id_validation_failed', 'local_o365');
            }
        }

        // Custom template is not selected, just save normally.
        return parent::write_setting($data);
    }

    /**
     * Return an XHTML string for the setting with toggle logic and test button.
     *
     * @param mixed $data
     * @param string $query
     * @return string
     */
    public function output_html($data, $query = '') {
        $teamtypeid = 'id_s_local_o365_team_type';
        $customidid = 'id_s_local_o365_team_type_custom_id';
        $testbuttonid = 'test_template_id_btn';
        $statusid = 'test_template_id_status';

        // Get translatable strings for JavaScript.
        $strings = [
            'settings_team_type_custom_id_test_button',
            'settings_team_type_custom_id_validating',
            'settings_team_type_custom_id_error_empty',
            'settings_team_type_custom_id_error_not_found',
            'settings_team_type_custom_id_error_validation',
            'settings_team_type_custom_id_error_default',
            'settings_team_type_custom_id_error_timeout',
            'settings_team_type_custom_id_error_network',
            'settings_team_type_custom_id_error_parsererror',
            'settings_team_type_custom_id_error_http',
        ];
        $translatedstrings = [];
        foreach ($strings as $stringkey) {
            $translatedstrings[$stringkey] = get_string($stringkey, 'local_o365');
        }
        $stringsasjson = json_encode($translatedstrings);

        $js = <<<JS
(function() {
    var strings = {$stringsasjson};

    function escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    function toggleTeamTypeCustomId() {
        var \$teamTypeSelect = jQuery('#{$teamtypeid}');
        var \$customIdInput = jQuery('#{$customidid}');
        var \$testButton = jQuery('#{$testbuttonid}');

        if (\$teamTypeSelect.length === 0 || \$customIdInput.length === 0) {
            return;
        }

        var \$customIdContainer = \$customIdInput.closest('.form-group, .form-setting');

        function updateState() {
            var isCustomSelected = \$teamTypeSelect.val() === 'custom';
            if (isCustomSelected) {
                \$customIdContainer.css('opacity', '1');
                \$customIdInput.prop('disabled', false);
                \$testButton.prop('disabled', false).css('opacity', '1');
            } else {
                \$customIdContainer.css('opacity', '0.5');
                \$customIdInput.prop('disabled', true);
                \$testButton.prop('disabled', true).css('opacity', '0.5');
            }
        }

        \$teamTypeSelect.on('change', updateState);
        updateState();
    }

    function validateTemplateId() {
        var \$customIdInput = jQuery('#{$customidid}');
        var \$statusEl = jQuery('#{$statusid}');
        var templateId = \$customIdInput.val().trim();

        if (!templateId) {
            \$statusEl.html(
                '<span style="color: red;">' +
                escapeHtml(strings.settings_team_type_custom_id_error_empty) +
                '</span>'
            );
            return;
        }

        \$statusEl.html('<span style="color: #999;">' + escapeHtml(strings.settings_team_type_custom_id_validating) + '</span>');

        var testButton = jQuery('#{$testbuttonid}');
        testButton.prop('disabled', true);

        jQuery.ajax({
            url: M.cfg.wwwroot + '/local/o365/admin/ajax/validate_template_id.php',
            type: 'POST',
            data: {
                template_id: templateId,
                sesskey: M.cfg.sesskey
            },
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                if (response.valid) {
                    \$statusEl.html('<span style="color: green;">' + escapeHtml(response.message) + '</span>');
                } else {
                    \$statusEl.html('<span style="color: red;">' + escapeHtml(response.message) + '</span>');
                }
            },
            error: function(xhr, status, error) {
                var errorMsg = '';
                var serverMessage = '';

                try {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        serverMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        var parsed = JSON.parse(xhr.responseText);
                        if (parsed && parsed.message) {
                            serverMessage = parsed.message;
                        }
                    }
                } catch (e) {
                    // JSON parsing failed.
                }

                if (xhr.status === 404) {
                    errorMsg = strings.settings_team_type_custom_id_error_not_found.replace('{' + '\$a}', escapeHtml(templateId));
                } else if (xhr.status === 500) {
                    var serverMsg = serverMessage ? escapeHtml(serverMessage) : strings.settings_team_type_custom_id_error_default;
                    errorMsg = strings.settings_team_type_custom_id_error_validation.replace('{' + '\$a}', serverMsg);
                } else if (status === 'timeout') {
                    errorMsg = strings.settings_team_type_custom_id_error_timeout;
                } else if (status === 'error' && xhr.status === 0) {
                    errorMsg = strings.settings_team_type_custom_id_error_network;
                } else if (status === 'parsererror') {
                    errorMsg = strings.settings_team_type_custom_id_error_parsererror;
                } else {
                    var serverMsg = serverMessage ?
                        escapeHtml(serverMessage) :
                        error || strings.settings_team_type_custom_id_error_default;
                    errorMsg = strings.settings_team_type_custom_id_error_http.replace('{' + '\$a}', xhr.status);
                    if (serverMsg !== strings.settings_team_type_custom_id_error_default) {
                        errorMsg = errorMsg.replace('Please try again or contact your administrator.', serverMsg);
                    }
                }

                \$statusEl.html('<span style="color: red;">' + escapeHtml(errorMsg) + '</span>');
                // Clear the custom template ID field on validation failure.
                \$customIdInput.val('');
            },
            complete: function() {
                testButton.prop('disabled', false);
            }
        });
    }

    if (typeof jQuery !== 'undefined') {
        jQuery(document).ready(function() {
            // Position button right after the input field.
            var \$input = jQuery('#{$customidid}');
            if (\$input.length > 0) {
                var buttonHtml = '<div class="team-type-custom-id-test-wrapper">' +
                    '<button id="{$testbuttonid}" type="button" ' +
                    'class="btn btn-secondary team-type-custom-id-test-button" disabled>' +
                    escapeHtml(strings.settings_team_type_custom_id_test_button) + '</button>' +
                    '<div class="team-type-custom-id-test-status"><span id="{$statusid}"></span></div>' +
                    '</div>';
                \$input.after(buttonHtml);

                // Make the wrapper appear on its own line within the form-setting.
                \$input.closest('.form-setting').find('.team-type-custom-id-test-wrapper').css({
                    'display': 'block',
                    'clear': 'both',
                    'margin-top': '8px'
                });

                // Hide the "Default: Empty" text for this setting.
                \$input.closest('.form-item').find('.form-defaultinfo').hide();
            }

            toggleTeamTypeCustomId();
            jQuery(document).on('click', '#{$testbuttonid}', function(e) {
                e.preventDefault();
                validateTemplateId();
            });
            jQuery('#{$customidid}').on('blur', function() {
                if (jQuery('#{$customidid}').val().trim()) {
                    validateTemplateId();
                }
            });
        });
    }
})();
JS;

        $css = <<<CSS
<style>
#id_s_local_o365_team_type_custom_id {
    display: block;
    margin-bottom: 8px;
}
.team-type-custom-id-test-wrapper {
    display: block;
    clear: both;
    margin-bottom: 12px;
    flex-basis: 100%;
    width: 100%;
}
.team-type-custom-id-test-button {
    opacity: 0.5;
    margin-right: 10px;
    margin-bottom: 0;
}
.team-type-custom-id-test-status {
    display: inline-block;
    margin-left: 10px;
    margin-top: 0;
}
</style>
CSS;

        return parent::output_html($data, $query) . $css . \html_writer::script($js);
    }
}
