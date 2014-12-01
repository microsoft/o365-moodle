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
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

require_once(__DIR__.'/../../config.php');

require_login();

$action = optional_param('action', null, PARAM_TEXT);
$o365connected = $DB->record_exists('local_o365_token', ['user_id' => $USER->id]);

$PAGE->set_url('/local/o365/ucp.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_pagelayout('standard');
$ucptitle = get_string('ucp_title', 'local_o365');
$PAGE->navbar->add($ucptitle, $PAGE->url);
$PAGE->set_title($ucptitle);

if (!empty($action)) {
	if ($action === 'calendar') {
		$mform = new \local_o365\form\calendarsync('?action=calendar');

		if ($mform->is_cancelled()) {
            redirect(new \moodle_url('/local/o365/ucp.php'));
        } else if ($fromform = $mform->get_data()) {
        	// Determine and organize existing subscriptions.
        	$sitecalsubscribed = false;
            $sitecalsubscribedrecid = null;
        	$usercalsubscribed = false;
            $usercalsubscribedrecid = null;
        	$existingcoursesubs = [];
        	$existingsubsrs = $DB->get_recordset('local_o365_calsub', ['user_id' => $USER->id]);
        	foreach ($existingsubsrs as $existingsubrec) {
        		if ($existingsubrec->caltype === 'site') {
        			$sitecalsubscribed = true;
                    $sitecalsubscribedrecid = $existingsubrec->id;
        		} else if ($existingsubrec->caltype === 'user') {
					$usercalsubscribed = true;
                    $usercalsubscribedrecid = $existingsubrec->id;
        		} else if ($existingsubrec->caltype === 'course') {
        			$existingcoursesubs[$existingsubrec->caltypeid] = $existingsubrec->caltypeid;
        		}
        	}
        	$existingsubsrs->close();

        	// Update site calendar subscription.
        	if ($fromform->sitecal === '0' && $sitecalsubscribed === true) {
        		$DB->delete_records('local_o365_calsub', ['user_id' => $USER->id, 'caltype' => 'site']);
                $eventdata = ['objectid' => $sitecalsubscribedrecid, 'userid' => $USER->id, 'other' => ['caltype' => 'site']];
                $event = \local_o365\event\calendar_unsubscribed::create($eventdata);
                $event->trigger();
        	} else if ($fromform->sitecal === '1' && $sitecalsubscribed === false) {
        		$newsub = ['user_id' => $USER->id, 'caltype' => 'site', 'caltypeid' => 0, 'timecreated' => time()];
				$newsub['id'] = $DB->insert_record('local_o365_calsub', (object)$newsub);
                $eventdata = ['objectid' => $newsub['id'], 'userid' => $USER->id, 'other' => ['caltype' => 'site']];
                $event = \local_o365\event\calendar_subscribed::create($eventdata);
                $event->trigger();
        	}

        	// Update user calendar subscription.
        	if ($fromform->usercal === '0' && $usercalsubscribed === true) {
        		$DB->delete_records('local_o365_calsub', ['user_id' => $USER->id, 'caltype' => 'user']);
                $eventdata = ['objectid' => $usercalsubscribedrecid, 'userid' => $USER->id, 'other' => ['caltype' => 'user']];
                $event = \local_o365\event\calendar_unsubscribed::create($eventdata);
                $event->trigger();
        	} else if ($fromform->usercal === '1' && $usercalsubscribed === false) {
        		$newsub = ['user_id' => $USER->id, 'caltype' => 'user', 'caltypeid' => $USER->id, 'timecreated' => time()];
				$newsub['id'] = $DB->insert_record('local_o365_calsub', (object)$newsub);
                $eventdata = ['objectid' => $newsub['id'], 'userid' => $USER->id, 'other' => ['caltype' => 'user']];
                $event = \local_o365\event\calendar_subscribed::create($eventdata);
                $event->trigger();
        	}

        	// The following calculates what courses need to be added or removed from the subscription table.
        	$newcoursesubs = [];
        	foreach ($fromform->coursecal as $courseid => $onoff) {
        		if ($onoff === '1') {
        			$newcoursesubs[$courseid] = $courseid;
        		}
        	}
        	$todelete = array_diff_key($existingcoursesubs, $newcoursesubs);
        	foreach ($todelete as $courseid) {
        		$DB->delete_records('local_o365_calsub', ['user_id' => $USER->id, 'caltype' => 'course', 'caltypeid' => $courseid]);
                $eventdata = ['objectid' => $USER->id, 'userid' => $USER->id, 'other' => ['caltype' => 'course', 'caltypeid' => $courseid]];
                $event = \local_o365\event\calendar_unsubscribed::create($eventdata);
                $event->trigger();
        	}
			$toadd = array_diff_key($newcoursesubs, $existingcoursesubs);
			foreach ($toadd as $courseid) {
				$newsub = [
					'user_id' => $USER->id,
					'caltype' => 'course',
					'caltypeid' => $courseid,
					'timecreated' => time(),
				];
        		$DB->insert_record('local_o365_calsub', (object)$newsub);
                $eventdata = ['objectid' => $USER->id, 'userid' => $USER->id, 'other' => ['caltype' => 'course', 'caltypeid' => $courseid]];
                $event = \local_o365\event\calendar_subscribed::create($eventdata);
                $event->trigger();
        	}
        	redirect(new moodle_url('/local/o365/ucp.php'));
        } else {
        	$defaultdata = [];
        	$existingsubsrs = $DB->get_recordset('local_o365_calsub', ['user_id' => $USER->id]);
        	foreach ($existingsubsrs as $existingsubrec) {
        		if ($existingsubrec->caltype === 'site') {
        			$defaultdata['sitecal'] = '1';
        		} elseif ($existingsubrec->caltype === 'user') {
        			$defaultdata['usercal'] = '1';
        		} elseif ($existingsubrec->caltype === 'course') {
        			$defaultdata['coursecal'][$existingsubrec->caltypeid] = '1';
        		}
        	}
        	$existingsubsrs->close();

        	$mform->set_data($defaultdata);
        	echo $OUTPUT->header();
        	$mform->display();
        	echo $OUTPUT->footer();
        }
	}
} else {
	echo $OUTPUT->header();
	echo \html_writer::tag('h2', $ucptitle);
	echo get_string('ucp_general_intro', 'local_o365');
	echo '<br /><br />';

	echo \html_writer::link(new \moodle_url('?action=calendar'), get_string('ucp_calsync_title', 'local_o365'));

	// Course calendars.
	// Group calendars.
	//
	echo $OUTPUT->footer();
}