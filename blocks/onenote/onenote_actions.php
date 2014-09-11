<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');

$id = required_param('id', PARAM_INT);
$token = required_param('token', PARAM_TEXT);

$cm = get_coursemodule_from_id('assign', $id, 0, false, MUST_EXIST);
$assign = $DB->get_record('assign', array('id' => $cm->instance));
//error_log('assign: ' . print_r($assign, true));

// save to one note using name, intro
// TODO: Fix up images / links etc. (copy those to onenote too and update hrefs accordingly)
$html = '--NewPart\r\nContent-Disposition: form-data; name="Presentation"\r\nContent-Type: application/xhtml+xml\r\n\r\n<?xml version="1.0" encoding="utf-8" ?>\r\n' .
    '<!DOCTYPE html><html><head><title>Assignment: ' . $assign->name . '</title></head><body><h1>' . $assign->name . '</h1><div>' . $assign->intro . '</div></body></html>\r\n\r\n' .
    '--NewPart--';

$url = 'https://www.onenote.com/api/beta/pages';

$curl = new curl();
$curl->setHeader('Authorization: Bearer ' . $token);
$curl->setHeader('Content-Type: multipart/form-data; boundary=NewPart');
$response = $curl->post($url, $html);
$response = json_decode($response);

error_log("response: " . print_r($response, true));

if (!$response || isset($response->error)) {
} else {

// TODO: Redirect to that onenote page so student can continue working on it
//$response->links->oneNoteWebUrl;
}

?>