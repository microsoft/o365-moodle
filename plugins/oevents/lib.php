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
require_once($CFG->dirroot.'/local/oevents/office_lib.php');
require_once($CFG->dirroot.'/local/oevents/util.php');

class events_o365 {
    // TODO: Need to parametrize this so it can be called from cron as well as login hook
    public function sync_calendar(){
        global $USER,$DB,$SESSION;
        if (!isloggedin()) {
            return false;
        }

        date_default_timezone_set('UTC');
        $params = array();
        $courseevents = array();

        //to get the list of courses the user is enrolled in
        $courses = enrol_get_my_courses();
        if($courses) {
            //get the calendar course id for each of the courses and get events
            foreach($courses as $course) {
                $course_id = $course->id;
                $is_teacher = is_teacher($course_id, $USER->id);
                if($is_teacher) {
                    $course_cal = $DB->get_record('course_ms_ext',array("course_id" => $course_id));
                    if ($course_cal) {
                    	if($course_cal->calendar_id == '') {
                    		$calendar = o365_get_calendar($SESSION->accesstoken);
                    		echo "<pre>";
                    		//print_r($calendar);
                    		$o365_cal = array();
                    		foreach ($calendar->value as $cal) {                    			
                    		 if($cal->Id) {
				                    $o365_cal[$cal->Id] = $cal->Name;
				                }
                    		}
                    		$calendar_id = array_search($course->fullname, $o365_cal);                    		
                    		$course_calendar = new stdClass();	
                    		$course_calendar->id = $course_cal->id;
                    		$course_calendar->course_id = $course_id;
                    		$course_calendar->calendar_id = $calendar_id;
                    		$course_cal = $DB->update_record('course_ms_ext', $course_calendar);
                    		$course_cal->calendar_id = $calendar_id;
                    	}
                        $events = o365_get_calendar_events($SESSION->accesstoken,$course_cal->calendar_id);

                        if(!isset($events->error) || !($events->error)) {
                            foreach($events->value as $event) {
                                $event->course = $course_id;
                            }

                            array_push($courseevents,$events);
                        }
                    } else {
                    	$calendar = o365_get_calendar($SESSION->accesstoken);
                    	$course_calendar = new stdClass();
                    	$course_calendar->course_id = $course_id;
                    	$course_calendar->calendar_id = $calendar->Id;
                    	$course_cal = $DB->insert_record('course_ms_ext', $course_calendar);
                    }
                }
            }
        }

         // TODO: Restrict time range to be the same as moodle events. Use $filter?
        $o365events = o365_get_calendar_events($SESSION->accesstoken,'');        
        if($courseevents && is_array($courseevents)) {
            foreach ($courseevents[0]->value as $event) {
                array_push($o365events->value, $event);                
            }
        }
        
        // Need to give start time and end time to get all the events from calendar.
        //TODO: Here I am giving the time recent and next 60 days. What is a good range?
        $timestart = time() - 4320000;
        $timeend = time() + 5184000;
        $moodleevents = calendar_get_events($timestart,$timeend,$USER->id,FALSE,true,true,true);        
        $context_value = 0;

        // loop through all Office 365 events and create or update moodle events
        if (!isset($o365events->error)) {
            foreach ($o365events->value as $o365event) {
                // if event already exists in moodle, get its id so we can update it instead of creating a new one
                if (strtotime($o365event->Start) == 0) // this happens due to some bug in O365, ignore these events
                    continue;

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

                if(isset($o365event->course)) {
                    $event->courseid = $o365event->course;
                }

                $event->uuid         = $o365event->Id;
                $event->name         = empty($o365event->Subject) ? '<unnamed>' : $o365event->Subject;
                $event->description  = array("text" => empty($o365event->Subject) ? '<unnamed>' : $o365event->Subject,
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

    public function insert_event_o365($data) {
        global $DB,$SESSION,$USER;

        error_log('insert_o365 called');
        error_log(print_r($data, true));

        date_default_timezone_set('UTC');

        //Checking if access token has expired, then ask for a new token
        
        check_token_expiry();

        // if this event already exists in O365, it will have a uuid, so don't insert it again
        //$data does not provide with uuid. So for that we are retrieving each event by event id.
        $eventdata = calendar_get_events_by_id(array($data->id));

        if ($eventdata[$data->id]->uuid != "") {
            return;
        }

        //event object to be passed
        $oevent = new object;
        $oevent->Subject = $data->name;
        $oevent->Body = array("ContentType" => "Text",
            "Content" => trim($data->description)
        );

        $oevent->Start = date("Y-m-d\TH:i:s\Z", $data->timestart);

        if($data->timeduration == 0) {
            $oevent->End = date("Y-m-d\TH:i:s\Z", $data->timestart + 3600);
        } else {
            $oevent->End = date("Y-m-d\TH:i:s\Z", $data->timestart + $data->timeduration);
        }

        if ($data->courseid != 0) { //Course event
            $course = $DB->get_record('course',array("id" => $data->courseid));
            $course_name = $course->fullname;
            $course_cal = $DB->get_record('course_ms_ext',array("course_id" => $data->courseid));
            $calendar_id = $course_cal->calendar_id;
            $course_name = array(0 => $course_name);

            //In moodle the roles are based on the context, to check if logged in user is a teacher
            $is_teacher = is_teacher($data->courseid, $USER->id);
            if($is_teacher) {
                // If this is a course event, and the logged in user is a teacher,
                // make students in that course as attendees
                // TODO: Is there a way to get this via the API instead of sql?
                if (property_exists($data, "courseid")) {
                    $sql = "SELECT u.id,u.firstname, u.lastname, u.email FROM `mdl_user` u
                            JOIN mdl_role_assignments ra ON u.id = ra.userid
                            JOIN mdl_role r ON ra.roleid = r.id
                            JOIN mdl_context c ON ra.contextid = c.id
                            WHERE c.contextlevel = 50
                            AND c.instanceid = ".$data->courseid."
                            AND r.shortname = 'student' ";
                    $students = $DB->get_records_sql($sql);
                }

                $attendees = array();
                foreach ($students as $student) {
                    $attend = array(
                                   "Name" => $student->firstname." ".$student->lastname,
                                   "Address" => $student->email,
                                   "Type" => "Required"
                                    );
                    array_push($attendees,$attend);
                }

                $oevent->Attendees = $attendees;
            }

            $event_data =  json_encode($oevent);
            $eventresponse = o365_create_calendar_event($SESSION->accesstoken,$calendar_id,$event_data);

        } else { //if user event, either teacher or student
            $event_data =  json_encode($oevent);
            $eventresponse = o365_create_calendar_event($SESSION->accesstoken,'',$event_data);
        }

        // obtain uuid back from O365 and set it into the moodle event
        $eventresponse = json_decode($eventresponse);
        if($eventresponse && $eventresponse->Id) {
            $event = calendar_event::load($data->id);
            $event->uuid = $eventresponse->Id;
            $event->update($event);
        }
    }

    public function delete_event_o365($data) {
        global $DB,$SESSION;

        error_log('delete_o365 called');
        error_log(print_r($data, true));

        //Checking if access token has expired, then ask for a new token
        check_token_expiry();

        if($data->uuid) {
            o365_delete_calendar_event($SESSION->accesstoken,$data->uuid);
        }
    }

   /* public function check_token_expiry() {
        global $SESSION;

        date_default_timezone_set('UTC');

        if (time() > $SESSION->expires) {
            $refresh = array();
            $refresh['client_id'] = $SESSION->params_office['client_id'];
            $refresh['client_secret'] = $SESSION->params_office['client_secret'];
            $refresh['grant_type'] = "refresh_token";
            $refresh['refresh_token'] = $SESSION->refreshtoken;
            $refresh['resource'] = $SESSION->params_office['resource'];
            $requestaccesstokenurl = "https://login.windows.net/common/oauth2/token";

            $curl = new curl();
            $refresh_token_access = $curl->post($requestaccesstokenurl, $refresh);

            $access_token = json_decode($refresh_token_access)->access_token;
            $refresh_token = json_decode($refresh_token_access)->refresh_token;
            $expires_on = json_decode($refresh_token_access)->expires_on;

            $SESSION->accesstoken =  $access_token;
            $SESSION->refreshtoken = $refresh_token;
            $SESSION->expires = $expires_on;
         }
    }*/

    public function get_app_token(){
        $clientsecret = urlencode(get_config('auth/googleoauth2', 'azureadclientsecret'));
        $resource = urlencode('https://outlook.office365.com'); //'https://graph.windows.net' 'https://outlook.office365.com'
        $clientid = urlencode(get_config('auth/googleoauth2', 'azureadclientid'));
        $state = urlencode('state=bb706f82-215e-4836-921d-ac013e7e6ae5');

        $fields = 'grant_type=client_credentials&client_secret='.$clientsecret
                  .'&resource='.$resource.'&client_id='.$clientid.'&state='.$state;

        $curl = curl_init();

        $stsurl = 'https://login.windows.net/' . get_config('auth/googleoauth2', 'azureaddomain') . '/oauth2/token?api-version=1.0';
        curl_setopt($curl, CURLOPT_URL, $stsurl);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,  $fields);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $output = curl_exec($curl);

        curl_close($curl);

        $tokenoutput = json_decode($output);
        // echo 'token: ' ; print_r($tokenoutput);

        return $tokenoutput->{'access_token'};
    }

}

//--------------------------------------------------------------------------------------------------------------------------------------------
// Cron method
function local_oevents_cron() {
    mtrace( "O365 Calendar Sync cron script is starting." );
    date_default_timezone_set('UTC');

    //$this->check_token_expiry();
    //$this->sync_calendar();

    $oevents = new events_o365();
    $token = $oevents->get_app_token();

    // get all users
    $users = get_users();
    error_log(print_r($users, true));
    
    // Loop over all users and sync their calendars
    foreach ($users as $user) {
        $o365events = o365_get_calendar_events_upn($token, $user->upn);
        
        // TODO: sync calendar
    }
    
    mtrace( "O365 Calendar Sync cron script completed." );

    return true;
}

//--------------------------------------------------------------------------------------------------------------------------------------------
// Event handlers
function on_course_created($data) {
    create_course_calendar($data);
}

function on_course_deleted($data) {
    delete_course_calendar($data);
}

function on_user_enrolment_created($data) {
    subscribe_to_course_calendar($data);
}

function on_user_enrolment_deleted($data) {
    unsubscribe_from_course_calendar($data);
}

// TODO: Use this type of event hooks?
// function on_calendar_event_created($data) {
    // $in = new events_o365();
    // $in->delete_o365($data);
// }

// function on_calendar_event_deleted($data) {
    // $in = new events_o365();
    // $in->delete_o365($data);
// }

//--------------------------------------------------------------------------------------------------------------------------------------------
// helper methods
function create_course_calendar($data) {
    global $DB,$SESSION;

    error_log("create_course_calendar called");
    error_log(print_r($data, true));

    $new_calendar = o365_create_calendar($SESSION->accesstoken, $data->fullname);

    $course_calendar = new stdClass();    
    $course_calendar->course_id = $data->id;
    $course_calendar->calendar_id = $new_calendar->Id;
    $course_ext = $DB->get_record('course_ms_ext', array("course_id" => $data->id));
    if($course_ext) {
    	$course_calendar->id = $course_ext->id;
        $update = $DB->update_record("course_ms_ext", $course_calendar);
    } else {
    	$insert = $DB->insert_record("course_ms_ext", $course_calendar);
    }    
    //error_log(print_r($insert, true));
}

function delete_course_calendar($data) {
    global $DB,$SESSION;

    error_log("delete_course_calendar called");
    error_log(print_r($data, true));

    $course_ext = $DB->get_record('course_ms_ext', array("course_id" => $data->id));

    o365_delete_calendar($SESSION->accesstoken, $course_ext->calendar_id);
}

function subscribe_to_course_calendar($data) {
    global $DB;
    error_log("subscribe_to_course_calendar called");
    error_log(print_r($data, true));

    // Get O365 calendar id for the course from course table
    $calendar_id = $DB->get_record('course_ms_ext', array("course_id" => $data->courseid));
    
    // TODO: Get student UPN and share the calendar with them

    // TODO: If possible, let the student accept the request automatically. (Otherwise let them do it manually.)
}

function unsubscribe_from_course_calendar($data) {
    error_log("unsubscribe_from_course_calendar called");
    error_log(print_r($data, true));
}
