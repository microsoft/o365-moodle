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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * Autocomplete for Microsoft 365 groups in cohort sync.
 *
 * @package local_o365
 * @copyright Enovation Solutions Ltd. {@link https://enovation.ie}
 * @author Patryk Mroczko <patryk.mroczko@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_o365\form;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/form/autocomplete.php');

use MoodleQuickForm_autocomplete;

class group_autocomplete extends MoodleQuickForm_autocomplete {

    /**
     * Constructor.
     *
     * @param string $elementName Element name.
     * @param mixed $elementLabel Label for the element.
     */
    public function __construct($elementName = null, $elementLabel = null) {
        $validattributes = [
                'ajax' => 'local_o365/group_datasource',
                'multiple' => false,
                'casesensitive' => false,
                'placeholder' => get_string('cohortsync_select_group', 'local_o365'),
                'showsuggestions' => true,
                'noselectionstring' => get_string('cohortsync_emptygroups', 'local_o365'),
        ];

        parent::__construct($elementName, $elementLabel, [], $validattributes);
    }

    /**
     * Set the value of this element. If values can be added or are unknown, we will make sure they exist in the options array.
     *
     * @param string|array $value The value to set.
     * @return boolean
     */
    public function setValue($value) {
        $values = (array) $value;
        $groupstofetch = array();

        foreach ($values as $onevalue) {
            if ($onevalue && !$this->optionExists($onevalue) && ($onevalue !== '_qf__force_multiselect_submission')) {
                array_push($groupstofetch, $onevalue);
            }
        }

        if (empty($groupstofetch)) {
            $this->setSelected($values);
            return true;
        }

        if (isset($this->_attributes['cohortsyncmain'])) {
            $cohortsyncmain = $this->_attributes['cohortsyncmain'];

            foreach ($groupstofetch as $groupid) {
                $displayName = $cohortsyncmain->get_group_name_by_group_oid($groupid);
                if (!empty($displayName)) {
                    $this->addOption($displayName, $groupid);
                }
            }
        }

        $this->setSelected($values);
        return true;
    }
}