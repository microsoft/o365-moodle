<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');
require_once($CFG->dirroot.'/repository/onenote/onenote_api.php');

global $USER;

$action = required_param('action', PARAM_TEXT);
$id = required_param('id', PARAM_INT);
//$token = required_param('token', PARAM_TEXT);
$onenote_token = get_onenote_token();

// Map $cm->course to section id
$cm = get_coursemodule_from_id('assign', $id, 0, false, MUST_EXIST);
$assign = $DB->get_record('assign', array('id' => $cm->instance));
$context = context_module::instance($cm->id);
$user_id = $USER->id;
$section = $DB->get_record('course_user_ext',array("course_id" => $cm->course,"user_id" => $user_id));
$section_id = $section->section_id;

$BOUNDARY = hash('sha256',rand());
$date = date("Y-m-d H:i:s");
$postdata = create_postdata($assign, $context->id, $BOUNDARY);

$url = 'https://www.onenote.com/api/beta/sections/' . $section_id . '/pages';
$encodedAccessToken = rawurlencode($onenote_token);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: multipart/form-data; boundary=$BOUNDARY\r\n".
                    "Authorization: Bearer ".$encodedAccessToken));
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);

$raw_response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if ($info['http_code'] == 201)
{
    $response_without_header = substr($raw_response,$info['header_size']);
    $response = json_decode($response_without_header);

    // Redirect to that onenote page so student can continue working on it
    $url = $response->links->oneNoteWebUrl->href;
} else {
    $url = '/';
}

$url = new moodle_url($url);
redirect($url);
