<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
// O365 library methods: TODO: Move to separate file
function create_course_calendar($data) {
    global $DB,$SESSION;

    error_log("create_course_calendar called");
    error_log(print_r($data, true));

    $newCal = array(
                "@odata.type" => "#Microsoft.Exchange.Services.OData.Model.Calendar",
                "Name" => $data->fullname
                );
    $calendar_name = json_encode($newCal);
    $curl = new curl();
    $header = array("Accept: application/json",
                "Content-Type: application/json;odata.metadata=full",
                "Authorization: Bearer ". $SESSION->accesstoken);
    $curl->setHeader($header);
    $new_Calendar = $curl->post("https://outlook.office365.com/ews/odata/Me/Calendars", $calendar_name);
    $new_Calendar = json_decode($new_Calendar);
    //TODO Need to get the course calendar same as calendar id from office.
    //Store the id in some fields of course table
    //idnumber is varchar type and can we use it to store our calendar id we get?
    $course_calendar = new stdClass();
    $course_calendar->course_id = $data->id;
    $course_calendar->calendar_course_id = $new_Calendar->Id;
    $insert = $DB->insert_record("course_calendar_ext", $course_calendar);
    error_log(print_r($insert, true));

}

function delete_course_calendar($data) {
    global $DB,$SESSION;
    error_log("delete_course_calendar called");
    error_log(print_r($data, true));
    $course_cal = $DB->get_record('course_calendar_ext',array("course_id" => $data->id));
    $curl = new curl();
    $header = array("Authorization: Bearer ". $SESSION->accesstoken);
    $curl->setHeader($header);
    $new_Calendar = $curl->delete("https://outlook.office365.com/ews/odata/Me/Calendars('".$course_cal->calendar_course_id."')");
}

function subscribe_to_course_calendar($data) {
    error_log("subscribe_to_course_calendar called");
    error_log(print_r($data, true));

    // TODO: Get O365 calendar id for the course from course table
    // TODO: Get student UPN and share the calendar with them
    // TODO: If possible, let the student accept the request automatically. (Otherwise let them do it manually.)
}

function unsubscribe_from_course_calendar($data) {
    error_log("unsubscribe_from_course_calendar called");
    error_log(print_r($data, true));
}



?>