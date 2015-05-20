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
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft Open Technologies, Inc.
 */

require_once(__DIR__.'/../../config.php');

require_login();
$PAGE->set_url('/local/onenote/onenote_actions.php');
$PAGE->set_context(\context_system::instance());

$action = required_param('action', PARAM_TEXT);
$cmid = required_param('cmid', PARAM_INT);
$wantfeedbackpage = optional_param('wantfeedback', false, PARAM_BOOL);
$isteacher = optional_param('isteacher', false, PARAM_BOOL);
$subuserid = optional_param('submissionuserid', null, PARAM_INT);
$sub = optional_param('submissionid', null, PARAM_INT);
$gradeid = optional_param('gradeid', null, PARAM_INT);

$url = \local_onenote\api\base::getinstance()->get_page($cmid, $wantfeedbackpage, $isteacher, $subuserid, $sub, $gradeid);

// If connection error then show message.
if ($url == 'connection_error') {
    throw new \moodle_exception(get_string('connction_error', 'local_onenote'), 'onenote');
}

if ($url) {
    $url = new moodle_url($url);
    redirect($url);
} else {
    throw new \moodle_exception(get_string('onenote_page_error', 'local_onenote'), 'onenote');
}