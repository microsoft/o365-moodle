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

?>