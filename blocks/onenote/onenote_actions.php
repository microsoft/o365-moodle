<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');

$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('assign', $id, 0, false, MUST_EXIST);
$assign = $DB->get_record('assign', array('id' => $cm->instance));
error_log('assign: ' . print_r($assign, true));

// TODO: save to one note using name, intro, and formatting
// TODO: Redirect to that onenote page so student can continue working on it
// TODO: Fix up images / links etc. (copy those to onenote too and update hrefs accordingly)
?>