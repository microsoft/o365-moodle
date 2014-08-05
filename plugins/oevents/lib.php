<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Library function for syncing the events from O365. This library will
 contain functions to add/edit and delete events
 *
 * @package    local
 * @subpackage oevents - to get office 365 events.
 * @copyright  2014 Introp
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class events_o365 {
    //Calling this function from auth.
    //TODO: We need to run a cron. Need to find out how we can pass the token to cron
    //so that we can get the events.

    public function sync_calendar($access_token){

        global $USER,$DB,$SESSION;
        if (!isloggedin()) {
            return false;
        }

        date_default_timezone_set('UTC');

        $params = array();
        $curl = new curl();
        $params['access_token'] = $access_token;
        $header = array('Authorization: Bearer '.$access_token);
        $curl->setHeader($header);
        $eventresponse = $curl->get('https://outlook.office365.com/ews/odata/Me/Calendar/Events'); // TODO: Restrict time range to be the same as moodle events
        $o365events = json_decode($eventresponse);

        //Need to give start time and end time to get all the events from calendar.
        //TODO: Here I am giving the time recent and next 60 days.
        $timestart = time() - 4320000;
        $timeend = time() + 5184000;
        $moodleevents = calendar_get_events($timestart,$timeend,$USER->id,FALSE,FALSE,true,true);

        // loop through all Office 365 events and create or update moodle events
        if (!isset($o365events->error)) {
            foreach ($o365events->value as $o365event) {
                // if event already exists in moodle, get its id so we can update it instead of creating a new one
                //Keep both the course name and O365 category name same.
                if($o365event->Categories) {
                    $course = $DB->get_record('course', array("fullname" => $o365event->Categories[0]));
                    $course_id = $course->id;
                    $context_value = context_course::instance($course_id);
                } else {
                    $context_value = 0;
                }

                //echo "event: "; print_r($o365event); echo "<br/><br/>";

                $event_id = 0;
                if ($moodleevents) {
                    foreach ($moodleevents as $moodleevent) {
                        if ((trim($moodleevent->uuid)) == trim($o365event->Id)) {
                            $event_id = $moodleevent->id;
                            break;
                        }
                    }
                }

                // prepare event data
                if ($event_id != 0) {
                    $event = calendar_event::load($event_id);
                } else {
                    $event = new stdClass;
                    $event->id = 0;
                    $event->userid       = $USER->id;
                    $event->eventtype    = 'user';
                    if ($context_value != 0)
                        $event->context      = $context_value;
                }

                $event->uuid         = $o365event->Id;
                $event->name         = $o365event->Subject;
                $event->description  = array("text" => $o365event->Subject,
                                        "format" => 1,
                                        "itemid" => $o365event->Id
                                         );
                $event->timestart    = strtotime($o365event->Start);
                $event->timeduration = strtotime($o365event->End) - strtotime($o365event->Start);

                // create or update moodle event
                if ($event_id != 0) {
                    $event->update($event);
                } else {
                    $event = new calendar_event($event);
                    $event->update($event);
                }
            }
        }

        // if an event exists in moodle but not in O365, we need to delete it from moodle
        if ($moodleevents) {
            foreach ($moodleevents as $moodleevent) {
                //echo "event: "; print_r($moodleevent); echo "<br/><br/>";
                $found = false;

                foreach ($o365events->value as $o365key => $o365event) {
                    if (trim($moodleevent->uuid) == trim($o365event->Id)) {
                        $found = true;
                        unset($o365events->value[$o365key]);
                        break;
                    }
                }

                if (!$found) {
                    $event = calendar_event::load($moodleevent->id);
                    $event->delete();
                }
            }
        }
    }

    public function insert_o365($data) {
        global $DB,$SESSION;

        date_default_timezone_set('UTC');

        //Students list gives the attendees of the particular course.
        //TODO: Plan A is to make this student as attendees. Since all of the users have
        //account in o365 they can be assigned by passing array of attendees in the
        //curl event.
        // if (property_exists($data, "courseid")) {
            // $sql = "SELECT u.id,u.firstname, u.lastname, u.email FROM `mdl_user` u JOIN mdl_role_assignments ra ON u.id = ra.userid
                    // JOIN mdl_role r ON ra.roleid = r.id
                    // JOIN mdl_context c ON ra.contextid = c.id
                    // WHERE c.contextlevel = 50
                    // AND c.instanceid = ".$data->courseid."
                    // AND r.shortname = 'student' ";
            // $students = $DB->get_record_sql($sql);
        // }

        // if this event already exists in O365, it will have a uuid, so don't insert it again
        //$data does not provide with uuid. So for that we are retrieving each event by event id.
        $eventdata = calendar_get_events_by_id(array($data->id));

        if ($eventdata[$data->id]->uuid != "") {
            return;
        }

        $oevent = new object;
        $oevent->Subject = $data->name;

        if ($data->courseid != 0) {
            $course = $DB->get_record('course',array("id" => $data->courseid));
            $course_name = $course->fullname;
            $course_name = array(0 => $course_name);
            //I am getting correct array for categories. But while posting
            //it takes long time to post and gets back with internal server error.
            $oevent->Categories = $course_name;

        }

        $oevent->Body = array("ContentType" => "Text",
            "Content" => trim($data->description)
        );

        $oevent->Start = date("Y-m-d\TH:i:s\Z", $data->timestart);

        if($data->timeduration == 0) {
            $oevent->End = date("Y-m-d\TH:i:s\Z", $data->timestart + 3600);
        } else {
            $oevent->End = date("Y-m-d\TH:i:s\Z", $data->timestart + $data->timeduration);
        }

        print_r($oevent);
        $event_data =  json_encode($oevent);
        $curl = new curl();
        $header = array("Accept: application/json",
                        "Content-Type: application/json;odata.metadata=full",
                        "Authorization: Bearer ".$SESSION->accesstoken);
        $curl->setHeader($header);
        $eventresponse = $curl->post('https://outlook.office365.com/ews/odata/Me/Calendar/Events',$event_data);

        // obtain uuid back from O365 and set it into the moodle event
        $eventresponse = json_decode($eventresponse);
        if($eventresponse && $eventresponse->Id) {
            $event = calendar_event::load($data->id);
            $event->uuid = $eventresponse->Id;
            $event->update($event);
        }
    }
    public function delete_o365($data) {
        global $DB,$SESSION;
        if($data->uuid) {
            $curl = new curl();
            $url = "https://outlook.office365.com/ews/odata/Me/Calendar/Events('".$data->uuid."')";
            $header = array("Authorization: Bearer ".$SESSION->accesstoken);
            $curl->setHeader($header);
            $eventresponse = $curl->delete($url);
        }
    }
}
