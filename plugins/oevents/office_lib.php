<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
// O365 library methods:

function o365_create_calendar($access_token, $calendar_name) {
    error_log("o365_create_calendar called");
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
    error_log("o365_delete_calendar called");
    error_log(print_r($calendar_id, true));

    $curl = new curl();
    $header = array("Authorization: Bearer ". $access_token);
    $curl->setHeader($header);

    $response = $curl->delete("https://outlook.office365.com/ews/odata/Me/Calendars('".$calendar_id."')");
}

function o365_get_calendar_events($access_token, $calendar_id) {
    error_log("o365_get_calendar_events called");
    error_log(print_r($calendar_id, true));

    $curl = new curl();
    $header = array('Authorization: Bearer '.$access_token);
    $curl->setHeader($header);

    if($calendar_id != '') {
        $response = $curl->get("https://outlook.office365.com/ews/odata/Me/Calendars('".$calendar_id."')/Events");
    } else {
        $response = $curl->get('https://outlook.office365.com/ews/odata/Me/Calendar/Events');
    }

    $events = json_decode($response);
    return $events;
}

function o365_create_calendar_event($access_token, $calendar_id, $event) {
    error_log("o365_create_calendar_event called");
    error_log(print_r($calendar_id, true));

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
    error_log("o365_delete_calendar_event called");
    error_log(print_r($event_id, true));

    $curl = new curl();
    $header = array("Authorization: Bearer ".$access_token);
    $curl->setHeader($header);

    $response = $curl->delete("https://outlook.office365.com/ews/odata/Me/Calendar/Events('".$event_id."')");
}

function o365_get_calendar_events_upn($access_token, $upn) {
    error_log("o365_get_calendar_events_upn called");
    error_log(print_r($upn, true));

    $curl = new curl();
    $header = array('Authorization: Bearer ' . $access_token);
    $curl->setHeader($header);
    $eventresponse = $curl->get('https://outlook.office365.com/ews/odata/' . urlencode($upn) . '/Calendar/Events'); // TODO: Restrict time range to be the same as moodle events

    $o365events = json_decode($eventresponse);

    return $o365events;
}

function o365_get_messages($access_token) {
    error_log("o365_get_messages called");

    $curl = new curl();
    $header = array("Authorization: Bearer ". $access_token);
    $curl->setHeader($header);

    $response = $curl->get("https://outlook.office365.com/ews/odata/Me/Folders('Inbox')/Messages");
    $omessages = json_decode($response);
    return $omessages;
}

?>