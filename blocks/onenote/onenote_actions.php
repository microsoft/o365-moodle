<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');


$id = required_param('id', PARAM_INT);
$token = required_param('token', PARAM_TEXT);

// Map $cm->course to section id
$cm = get_coursemodule_from_id('assign', $id, 0, false, MUST_EXIST);
$assign = $DB->get_record('assign', array('id' => $cm->instance));

$assign_context =  get_coursemodule_from_instance('assign', $assign->id, $cm->course);
$context = context_module::instance($assign_context->id);

$section = $DB->get_record('course_ms_ext',array("course_id" => $cm->course));
$section_id = $section->section_id;
$date = date("Y-m-d H:i:s");

$doc = new DOMDocument();
$doc->loadHTML($assign->intro);
$xpath = new DOMXPath($doc);
$src = $xpath->evaluate("string(//img/@src)");
if($src) {
	$filename = explode("/",$src);
	$filename = $filename[1];
}

//get file contents
$fs = get_file_storage();
// Prepare file record object
$fileinfo = array(
		'component' => 'mod_assign',     // usually = table name
		'filearea' => 'intro',     // usually = table name
		'itemid' => 0,               // usually = ID of row in table
		'contextid' => $context->id, // ID of context
		'filepath' => '/',           // any path beginning and ending in /
		'filename' => $filename);

// Get file
$file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
		$fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
$filesize =  $file->get_filesize();
$filedata = $file->get_filepath();
$filename = $file->get_filename();
$contents = $file->get_content();
//error_log('assign: ' . print_r($assign, true));

// save to one note using name, intro
// TODO: Fix up images / links etc. (copy those to onenote too and update hrefs accordingly)

        
$html = '<!DOCTYPE html><html><head>
		<title>Assignment: ' . $assign->name . '</title>
		<meta name="created" content="'.$date.'">
		</head>
		<body>
				<h1>' . $assign->name . '</h1>
			    			
				<div>' . $assign->intro . '</div>
		</body></html>';

$eol = "\r\n"; 
$BOUNDARY = md5(time()); 
$BODY=""; 
$BODY.= '--'.$BOUNDARY. $eol; 
$BODY .= 'Content-Disposition: form-data; name="Presentation"'; 
$BODY .= $html;
$BODY.= '--'.$BOUNDARY. $eol; 
$BODY.= 'Content-Disposition: form-data; name="Presentation"; filename="'.$filename.'"'. $eol ; 
$BODY.= 'Content-Type: application/octet-stream' . $eol; 
$BODY.= 'Content-Transfer-Encoding: base64' . $eol . $eol; 
$BODY.= chunk_split(base64_encode($contents)) . $eol; 
$BODY.= '--'.$BOUNDARY .'--' . $eol. $eol;

$url = 'https://www.onenote.com/api/beta/sections/' . $section_id . '/pages';
$postfields = array("filedata" => $filedata,"filename" => $filename,"file" => $contents);
$curl = new curl();
$curl->setHeader('Authorization: Bearer ' . $token);
$curl->setHeader('Content-Type:multipart/form-data,boundary='.$BOUNDARY);
//$curl->setopt(array("CURLOPT_POSTFIELDS" => $postfields,"CURLOPT_INFILESIZE" => $filesize));
//$file->add_to_curl_request();
$response = $curl->post($url, $BODY);
$response = json_decode($response);

//error_log("response: " . print_r($response, true));

if (!$response || isset($response->ErrorCode)) {
    $url = '/';
} else {
    // Redirect to that onenote page so student can continue working on it
    $url = $response->links->oneNoteWebUrl->href;
}

$url = new moodle_url($url);
redirect($url);
?>