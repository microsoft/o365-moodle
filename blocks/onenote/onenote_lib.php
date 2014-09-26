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
function get_file_contents($filename,$context_id) {
	//get file contents
	$fs = get_file_storage();
	// Prepare file record object
	$fileinfo = array(
			'component' => 'mod_assign',     // usually = table name
			'filearea' => 'intro',     // usually = table name
			'itemid' => 0,               // usually = ID of row in table
			'contextid' => $context_id, // ID of context
			'filepath' => '/',           // any path beginning and ending in /
			'filename' => $filename);

	// Get file
	$file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
			$fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
	$filesize =  $file->get_filesize();
	$filedata = $file->get_filepath();
	$filename = $file->get_filename();
	$contents = $file->get_content();
	return $contents;
}
function create_postdata($assign,$context_id,$BOUNDARY) {	
	$dom = new DOMDocument();
	$dom->loadHTML($assign->intro);
	$xpath = new DOMXPath($dom);
	$doc = $dom->getElementsByTagName("html")->item(0);
	$src = $xpath->query(".//@src");
	if($src) {
		$img_data = "";
		foreach ($src as $s) {
			$value = explode( "/", $s->nodeValue );
			$s->nodeValue = array_pop($value);//.$s->nodeValue
			$contents = get_file_contents($s->nodeValue,$context_id);
			$src_name = explode(".",$s->nodeValue);
			$s->nodeValue = "name:".$src_name[0];
			$img_data .= <<<IMGDATA
--{$BOUNDARY}
Content-Disposition: form-data; name="$src_name[0]"
Content-Type: image/jpeg

$contents
IMGDATA;
		}
	}
	$output = $dom->saveXML( $doc );
	$date = date("Y-m-d H:i:s");
			$eol = "\r\n";
			$BODY=<<<POSTDATA
--{$BOUNDARY}
Content-Disposition: form-data; name="Presentation"
Content-Type: text/html

<!DOCTYPE html>
<html>
<head>
<title>Assignment:  $assign->name </title>
<meta name="created" value="$date"/>
</head>
<body>
<h1> $assign->name </h1>
<div> $output </div>
</body>
</html>
$img_data
--{$BOUNDARY}--
POSTDATA;

return $BODY;
}

?>