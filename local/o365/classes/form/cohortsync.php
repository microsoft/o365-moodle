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
 * Microsoft group and Moodle cohort mapping form.
 *
 * @package     local_o365
 * @copyright   Enovation Solutions Ltd. {@link https://enovation.ie}
 * @author      Patryk Mroczko <patryk.mroczko@enovation.ie>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_o365\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

use html_table;
use html_writer;
use moodle_url;
use moodleform;
use MoodleQuickForm;

MoodleQuickForm::registerElementType(
    'group_autocomplete',
    "$CFG->dirroot/local/o365/classes/form/group_autocomplete.php",
    'local_o365\form\group_autocomplete'
);
MoodleQuickForm::registerElementType(
    'cohort_autocomplete',
    "$CFG->dirroot/local/o365/classes/form/cohort_autocomplete.php",
    'local_o365\form\cohort_autocomplete'
);

/**
 * Class cohortsync.
 *
 * @package local_o365\form
 */
class cohortsync extends moodleform {
    /**
     * Define the form elements.
     */
    public function definition(): void {
        $mform = $this->_form;

        $cohortsyncmain = $this->_customdata['cohortsyncmain'];

        // Display instructions.
        $description = html_writer::div(get_string('cohortsync_desc', 'local_o365'), 'alert alert-info');
        $mform->addElement('html', $description);

        // Get group and cohort options.
        $existingmappings = $cohortsyncmain->get_mappings();
        $mappedcohortids = [];
        $mappedgroupoids = [];

        foreach ($existingmappings as $mapping) {
            $mappedgroupoids[] = $mapping->objectid;
            $mappedcohortids[] = $mapping->moodleid;
        }

        // Display group selector.
        $buttonattributes = [];
        $mform->addElement(
            'group_autocomplete',
            'groupoid',
            get_string('cohortsync_select_group', 'local_o365'),
            ['cohortsyncmain' => $cohortsyncmain]
        );

        // Display cohort selector.
        $mform->addElement(
            'cohort_autocomplete',
            'cohortid',
            get_string('cohortsync_select_cohort', 'local_o365'),
            ['cohortsyncmain' => $cohortsyncmain]
        );

        // Display submit button.
        $mform->addElement('submit', 'action', get_string('cohortsync_addmapping', 'local_o365'), $buttonattributes);

        // Display existing mappings.
        $existingmappingscontent = html_writer::start_div('existing-mappings');
        $existingmappingscontent .= html_writer::tag('h4', get_string('cohortsync_tabledesc', 'local_o365'));

        if (empty($existingmappings)) {
            $existingmappingscontent .= html_writer::tag('p', get_string('cohortsync_emptymatchings', 'local_o365'));
        } else {
            $existingmappingstable = new html_table();
            $existingmappingstable->attributes['class'] = 'generaltable mod_index';
            $existingmappingstable->head = [
                get_string('cohortsync_tablehead_group', 'local_o365'),
                get_string('cohortsync_tablehead_cohort', 'local_o365'),
                get_string('cohortsync_tablehead_actions', 'local_o365'),
            ];
            foreach ($existingmappings as $mapping) {
                $groupname = $cohortsyncmain->get_group_name_by_group_oid($mapping->objectid);
                $cohortname = $cohortsyncmain->get_cohort_name_by_cohort_id($mapping->moodleid);

                $cohorturl = new moodle_url('/cohort/edit.php', ['id' => $mapping->moodleid]);

                $deletemappingurl = new moodle_url(
                    '/local/o365/cohortsync.php',
                    ['action' => 'delete', 'connectionid' => $mapping->id]
                );
                $existingmappingstable->data[] = [
                    $groupname,
                    html_writer::link($cohorturl, $cohortname),
                    html_writer::link(
                        $deletemappingurl,
                        get_string('cohortsync_deletemapping', 'local_o365'),
                        ['class' => 'btn btn-primary']
                    ),
                ];
            }

            $existingmappingscontent .= html_writer::table($existingmappingstable);
        }

        $existingmappingscontent .= html_writer::end_div();

        $mform->addElement('html', $existingmappingscontent);
    }
}
