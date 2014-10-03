<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//OneNote api calls

function get_oneNote_notes ($access_token) {
    $curl = new curl();

    $header = array(
                        'Authorization: Bearer ' . $access_token,
                        'Content-Type: application/json'
                 );
    $curl->setHeader($header);

    $notes = $curl->get('https://www.onenote.com/api/v1.0/notebooks');
    $notes = json_decode($notes);

    return $notes;
}
function create_oneNote_notes($access_token, $note) {
   $curl = new curl();

    $header = array(
                        'Authorization: Bearer ' . $access_token,
                        'Content-Type: application/json'
                 );
    $curl->setHeader($header);

    $eventresponse = $curl->post('https://www.onenote.com/api/v1.0/notebooks',$note);
    $eventresponse = json_decode($eventresponse);

    return $eventresponse;
}
function get_oneNote_section($access_token, $note_id) {
    $curl = new curl();

    $header = array(
                        'Authorization: Bearer ' . $access_token,
                        'Content-Type: application/json'
                 );
    $curl->setHeader($header);

    $getsection = $curl->get('https://www.onenote.com/api/v1.0/notebooks/'.$note_id.'/sections');
    $getsection = json_decode($getsection);

    return $getsection;

}
function create_oneNote_section($access_token, $note_id, $section) {
    $curl = new curl();

    $header = array(
                        'Authorization: Bearer ' . $access_token,
                        'Content-Type: application/json'
                 );
    $curl->setHeader($header);

    $eventresponse = $curl->post('https://www.onenote.com/api/v1.0/notebooks/'.$note_id.'/sections',$section);

}
function get_file_contents($path,$filename,$context_id) {
	//get file contents
	$fs = get_file_storage();
	// Prepare file record object
	$fileinfo = array(
			'component' => 'mod_assign',     // usually = table name
			'filearea' => 'intro',     // usually = table name
			'itemid' => 0,               // usually = ID of row in table
			'contextid' => $context_id, // ID of context
			'filepath' => $path,           // any path beginning and ending in /
			'filename' => $filename);

	// Get file
	//error_log(print_r($fileinfo, true));
	$file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
			$fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
	$filesize =  $file->get_filesize();
	$filedata = $file->get_filepath();
	
	$contents = array();
	$contents['filename'] = $file->get_filename();
	$contents['content'] = $file->get_content();
	return $contents;
}
function create_postdata($assign,$context_id,$BOUNDARY) {
	//error_log($assign->intro);	
	$dom = new DOMDocument();
	$dom->loadHTML($assign->intro);
	$xpath = new DOMXPath($dom);
	$doc = $dom->getElementsByTagName("body")->item(0);
	$src = $xpath->query(".//@src");
	if($src) {
		$img_data = "";
		foreach ($src as $s) {
			$path_parts = pathinfo($s->nodeValue);
			$path = substr($path_parts['dirname'], strlen('@@PLUGINFILE@@')) . '/';
			$contents = get_file_contents($path, $path_parts['basename'], $context_id);
			$s->nodeValue = "name:".$path_parts['filename'];

			$img_data .= <<<IMGDATA
--{$BOUNDARY}
Content-Disposition: form-data; name="$path_parts[filename]"; filename="$contents[filename]"
Content-Type: image/jpeg

$contents[content]
IMGDATA;
			
			$img_data .="\r\n";
		}
	}

	// extract just the content of the body
	$dom_clone = new DOMDocument;
	foreach ($doc->childNodes as $child){
		$dom_clone->appendChild($dom_clone->importNode($child, true));
	}
	
	$output = $dom_clone->saveHTML();
	$date = date("Y-m-d H:i:s");
	
	$BODY=<<<POSTDATA
--{$BOUNDARY}
Content-Disposition: form-data; name="Presentation"
Content-Type: text/html; charset=utf-8

<!DOCTYPE html>
<html>
<head>
<title>Assignment: $assign->name</title>
<meta name="created" value="$date"/>
</head>
<body style="font-family:Arial">
<h2>$assign->name</h2>
$output
</body>
</html>
$img_data
--{$BOUNDARY}--
POSTDATA;

return $BODY;
}
