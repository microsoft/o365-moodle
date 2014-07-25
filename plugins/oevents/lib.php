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
//require_once($CFG->dirroot . '/auth/googleoauth2/auth.php');
//	require_once($CFG->dirroot . '/calendar/lib.php');
class events_o365 {

   //Calling this function from auth. 
   //TODO We need to run a cron. Need to find out how we can pass the token to cron
   //so that we can get the events.
   
	public function get_events_o365($access_token){
		global $USER;
		if (!isloggedin()) {    	
		        return false;
		    } 		
		
		$params = array();
        $curl = new curl();
        $params['access_token'] = $access_token;															
        $header = array('Authorization: Bearer '.$access_token);        
        $curl->setHeader($header);
		$getevent = $curl->get('https://outlook.office365.com/ews/odata/Me/Calendar/Events');
		$calenderevents = json_decode($getevent);	
	    //Need to give start time and end time to get all the events from calendar.
	    //Here I am giving the time recent and next 60 days.
	    $timestart = time() - 432000;
        $timeend = time() + 5184000;		
        $user_events = calendar_get_events($timestart,$timeend,$USER->id,FALSE,FALSE,true,true);		
	    if($calenderevents) {	    	
						//TODO here 1 is the course id, we need to give a course id to get the context. From 
						//O365 course id is not got. Need to find out a way to get that.						
						$context = context_course::instance(1);		
						 $des_itemid = rand(1, 999999999);				
						//format_module_intro($events_array->Subject, $events_array, $cmid)						
					foreach ($calenderevents->value as $events_array) {
						    			    
							$event = new stdClass;
							$event->name         = $events_array->Subject;
							$event->id           = 0;
							$event->userid       = $USER->id;							
							$event->description  = array("text" =>"from the office 365",
													"format" => 1,
													"itemid" => $des_itemid
													 );
							$event->timestart    = strtotime($events_array->Start);						
							$event->timeduration = strtotime($events_array->End);
							$event->eventtype    = 'user';
							$event->context      = $context;
							$event->uuid         = $events_array->ChangeKey;
				            $calendar_event = new calendar_event();				          
							if($user_events) {
								foreach($user_events as $mevent) {				            	
				                 if(trim($event->uuid) != trim($mevent->uuid)) {				                 	
				            		$calendar_event->update($event);	     	
				                 }
				             }		
							} else {
								   $calendar_event->update($event);
							}							
			    		}
					}      
	
      }	
}

