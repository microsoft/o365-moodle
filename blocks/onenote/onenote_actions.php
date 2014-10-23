<?php

require_once('../../config.php');
require_once($CFG->libdir.'/oauthlib.php');
require_once($CFG->dirroot.'/repository/onenote/onenote_api.php');

$action = required_param('action', PARAM_TEXT);
$cmid = required_param('cmid', PARAM_INT);
$want_feedback_page = optional_param('wantfeedback', false, PARAM_BOOL);
$is_teacher = optional_param('isteacher', false, PARAM_BOOL);
$submission_user_id = optional_param('submissionuserid', null, PARAM_INT);
$submission_id = optional_param('submissionid', null, PARAM_INT);
$grade_id = optional_param('gradeid', null, PARAM_INT);

$url = microsoft_onenote::get_page($cmid, $want_feedback_page, $is_teacher, $submission_user_id, $submission_id, $grade_id);
if ($url) {
    $url = new moodle_url($url);
    redirect($url);
} else {
    throw new moodle_exception('get_onenote_page_failed');
}