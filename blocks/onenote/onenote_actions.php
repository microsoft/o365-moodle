<?php

require_once('../../config.php');
require_once($CFG->libdir.'/oauthlib.php');
require_once($CFG->dirroot.'/repository/onenote/onenote_api.php');

$action = required_param('action', PARAM_TEXT);
$cmid = required_param('id', PARAM_INT);

$url = microsoft_onenote::get_page($cmid, false, false);
if ($url) {
    $url = new moodle_url($url);
    redirect($url);
} else {
    throw new moodle_exception('save_to_onenote_failed');
}