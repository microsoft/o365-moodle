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
 * Autocomplete for Moodle cohorts in cohort sync.
 *
 * @package local_o365
 * @subpackage form
 * @copyright Enovation Solutions Ltd. {@link https://enovation.ie}
 * @author Patryk Mroczko <patryk.mroczko@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_o365\form;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/form/autocomplete.php');

use MoodleQuickForm_autocomplete;

class cohort_autocomplete extends MoodleQuickForm_autocomplete {

    /**
     * Constructor.
     *
     * @param string $elementName Element name.
     * @param mixed $elementLabel Label for the element.
     */
    public function __construct($elementName = null, $elementLabel = null) {
        $validattributes = [
                'ajax' => 'local_o365/cohort_datasource',
                'multiple' => false,
                'casesensitive' => false,
                'placeholder' => get_string('cohortsync_select_cohort', 'local_o365'),
                'showsuggestions' => true,
                'noselectionstring' => get_string('cohortsync_emptycohorts', 'local_o365'),
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
        $cohortstofetch = array();

        foreach ($values as $onevalue) {
            if ($onevalue && !$this->optionExists($onevalue) && ($onevalue !== '_qf__force_multiselect_submission')) {
                array_push($cohortstofetch, $onevalue);
            }
        }

        if (empty($cohortstofetch)) {
            $this->setSelected($values);
            return true;
        }

        if (isset($this->_attributes['cohortsyncmain'])) {
            $cohortsyncmain = $this->_attributes['cohortsyncmain'];

            foreach ($cohortstofetch as $cohortid) {
                $name = $cohortsyncmain->get_cohort_name_by_cohort_id($cohortid);
                if (!empty($name)) {
                    $this->addOption($name, $cohortid);
                }
            }
        }

        $this->setSelected($values);
        return true;
    }
}