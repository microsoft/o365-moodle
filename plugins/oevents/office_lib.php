<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
// O365 library methods:

function o365_create_calendar($access_token, $calendar_name) {
    error_log("create_calendar called");
    error_log(print_r($calendar_name, true));

    $param = array(
                "@odata.type" => "#Microsoft.Exchange.Services.OData.Model.Calendar",
                "Name" => $calendar_name
                );
                
    $encoded_param = json_encode($param);    
    
    $curl = new curl();
    $header = array("Accept: application/json",
                "Content-Type: application/json;odata.metadata=full",
                "Authorization: Bearer ". $access_token);
    $curl->setHeader($header);    
    
    $response = $curl->post("https://outlook.office365.com/ews/odata/Me/Calendars", $encoded_param);    
    
    $new_calendar = json_decode($response);    
    return $new_calendar;
}

function o365_delete_calendar($access_token, $calendar_id) {
    error_log("delete_calendar called");
    error_log(print_r($calendar_id, true));
    
    $curl = new curl();
    $header = array("Authorization: Bearer ". $access_token);
    $curl->setHeader($header);

    $response = $curl->delete("https://outlook.office365.com/ews/odata/Me/Calendars('".$calendar_id."')");
}

function o365_get_calendar_event($access_token, $calendar_id) {
        $curl = new curl();       
        $header = array('Authorization: Bearer '.$access_token);
        $curl->setHeader($header);
        
        if($calendar_id != '') {
            $events = $curl->get("https://outlook.office365.com/ews/odata/Me/Calendars('".$calendar_id."')/Events");
        } else {
            $events = $curl->get('https://outlook.office365.com/ews/odata/Me/Calendar/Events');
        }
        
        return $events;
        
}

function o365_create_calendar_event($access_token, $calendar_id, $event) {
        //curl object
        $curl = new curl();
        $header = array("Accept: application/json",
                        "Content-Type: application/json;odata.metadata=full",
                        "Authorization: Bearer ". $access_token);
        $curl->setHeader($header);
        
        if($calendar_id != '') {                  
            $events = $curl->post("https://outlook.office365.com/ews/odata/Me/Calendars('".$calendar_id."')/Events",$event);
        } else {             
            $events = $curl->post('https://outlook.office365.com/ews/odata/Me/Calendar/Events',$event);
        }        
        return $events;
        
}

function o365_delete_calendar_event($access_token, $event_id) {
        //curl object
       $curl = new curl();
       $header = array("Authorization: Bearer ".$access_token);
       $curl->setHeader($header);
      
       $response = $curl->delete("https://outlook.office365.com/ews/odata/Me/Calendar/Events('".$event_id."')");        
}

function get_calendar_events_upn($access_token, $upn) {
        $curl = new curl();
        $header = array('Authorization: Bearer ' . $access_token);
        $curl->setHeader($header);
        $eventresponse = $curl->get('https://outlook.office365.com/ews/odata/' . urlencode($upn) . '/Calendar/Events'); // TODO: Restrict time range to be the same as moodle events
        //$eventresponse = $curl->get('https://outlook.office365.com/ews/odata/Me/Calendar/Events'); // TODO: Restrict time range to be the same as moodle events

        $o365events = json_decode($eventresponse);
        // echo 'events: '; print_r($o365events);

        return $o365events;
    }

?>