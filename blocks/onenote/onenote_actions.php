<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');
require_once $CFG->dirroot.'/blocks/onenote/onenote_lib.php';

$id = required_param('id', PARAM_INT);
echo $token = required_param('token', PARAM_TEXT);

// Map $cm->course to section id
$cm = get_coursemodule_from_id('assign', $id, 0, false, MUST_EXIST);
$assign = $DB->get_record('assign', array('id' => $cm->instance));

$assign_context =  get_coursemodule_from_instance('assign', $assign->id, $cm->course);
$context = context_module::instance($assign_context->id);

$section = $DB->get_record('course_ms_ext',array("course_id" => $cm->course));
$section_id = $section->section_id;

$BOUNDARY = hash('sha256',rand());
$date = date("Y-m-d H:i:s");
$postdata = create_postdata($assign, $context->id, $BOUNDARY);
/*$imageData = file_get_contents('ex.jpg');
		$postdata = <<<POSTDATA
--{$BOUNDARY}
Content-Disposition: form-data; name="Presentation"
Content-Type: text/html
		
<!DOCTYPE html>
<html>
  <head>
    <title>$assign->name</title>
    <meta name="created" value="$date"/>
  </head>
  <body>
    <p>This is a page that just contains some simple <i>formatted</i> <b>text</b> and an image</p>
    <img src="name:imageData" alt="A beautiful logo" width=\"426\" height=\"68\" />
  </body>
</html>
--{$BOUNDARY}
Content-Disposition: form-data; name="imageData"
Content-Type: image/jpeg

$imageData
--{$BOUNDARY}--
POSTDATA;
*/	

$url = 'https://www.onenote.com/api/beta/sections/' . $section_id . '/pages';
$encodedAccessToken = rawurlencode($token);
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


/*$curl = new curl();

//$curl->setHeader('Authorization: Bearer ' . rawurlencode($token));
$curl->setopt(array("CURLOPT_SSL_VERIFYPEER" => false));
$curl->setHeader("Content-Type: multipart/form-data; boundary=$BOUNDARY\r\n".
                                                        "Authorization: Bearer ".rawurlencode($token));
$response = $curl->post($url, $postdata);
$response = json_decode($response);
$err = $curl->error;
*/

$url = new moodle_url($url);
redirect($url);
?>