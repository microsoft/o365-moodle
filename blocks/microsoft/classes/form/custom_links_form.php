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
 * Form to manage the custom links shown in the block.
 *
 * @package block_microsoft
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot . '/blocks/microsoft/lib.php');

/**
 * Form to manage the custom links shown in the block.
 */
class block_microsoft_custom_links_form extends moodleform {
    /**
     * Form definition.
     */
    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('static', 'intro', '', get_string('settings_customlinks_desc', 'block_microsoft'));

        $targets = [
            '_blank' => get_string('settings_customlinktarget_blank', 'block_microsoft'),
            '_self' => get_string('settings_customlinktarget_self', 'block_microsoft'),
        ];

        $repeatarray = [
            $mform->createElement('header', 'linkheader', get_string('settings_customlinkheading', 'block_microsoft', '{no}')),
            $mform->createElement('hidden', 'linkid', 0),
            $mform->createElement(
                'text',
                'linkname',
                get_string('customlink_name', 'block_microsoft'),
                ['size' => 40, 'maxlength' => 255]
            ),
            $mform->createElement(
                'text',
                'linkurl',
                get_string('customlink_url', 'block_microsoft'),
                ['size' => 60, 'maxlength' => 2000]
            ),
            $mform->createElement(
                'filemanager',
                'linkicon',
                get_string('customlink_icon', 'block_microsoft'),
                null,
                block_microsoft_get_custom_link_icon_options()
            ),
            $mform->createElement('select', 'linktarget', get_string('customlink_target', 'block_microsoft'), $targets),
            $mform->createElement(
                'advcheckbox',
                'linkshowall',
                get_string('customlink_visibility', 'block_microsoft'),
                get_string('customlink_showall', 'block_microsoft')
            ),
            $mform->createElement('advcheckbox', 'linkdelete', '', get_string('customlink_delete', 'block_microsoft')),
        ];

        $repeatoptions = [
            'linkid' => ['type' => PARAM_INT],
            'linkname' => ['type' => PARAM_TEXT],
            'linkurl' => ['type' => PARAM_RAW_TRIMMED],
            'linktarget' => ['default' => '_blank'],
            'linkshowall' => ['type' => PARAM_BOOL],
            'linkdelete' => ['type' => PARAM_BOOL, 'default' => 0],
        ];

        $this->repeat_elements(
            $repeatarray,
            max(1, (int) ($this->_customdata['count'] ?? 1)),
            $repeatoptions,
            'repeats',
            'addlink',
            1,
            get_string('customlink_addanother', 'block_microsoft'),
            true
        );

        $this->add_action_buttons();
    }

    /**
     * Validate the links: name, URL and icon are all required for a link, and the URL must be valid.
     * Links marked for deletion, and links with an empty name and URL, are not validated.
     *
     * @param array $data
     * @param array $files
     * @return array Errors indexed by element name.
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        foreach ($data['linkname'] as $i => $name) {
            if (!empty($data['linkdelete'][$i])) {
                continue;
            }

            $name = trim($name);
            $url = trim($data['linkurl'][$i]);
            if ($name === '' && $url === '') {
                continue;
            }
            if ($name === '') {
                $errors['linkname[' . $i . ']'] = get_string('required');
            } else if (core_text::strlen($name) > 255) {
                $errors['linkname[' . $i . ']'] = get_string('maximumchars', '', 255);
            }
            if ($url === '') {
                $errors['linkurl[' . $i . ']'] = get_string('required');
            } else if (core_text::strlen($url) > 2000) {
                $errors['linkurl[' . $i . ']'] = get_string('maximumchars', '', 2000);
            } else if (!block_microsoft_is_valid_custom_link_url($url)) {
                $errors['linkurl[' . $i . ']'] = get_string('customlink_error_url', 'block_microsoft');
            }

            $draftitemid = (int) ($data['linkicon'][$i] ?? 0);
            if (!$draftitemid || !file_get_all_files_in_draftarea($draftitemid)) {
                $errors['linkicon[' . $i . ']'] = get_string('required');
            }
        }

        return $errors;
    }
}
