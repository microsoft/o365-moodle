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
		global $USER;

		if (!isloggedin()) {    	
		    return false;
		} 		
		
		$params = array();
        $curl = new curl();
        $params['access_token'] = $access_token;															
        $header = array('Authorization: Bearer '.$access_token);        
        $curl->setHeader($header);
		$eventresponse = $curl->get('https://outlook.office365.com/ews/odata/Me/Calendar/Events');
		$o365events = json_decode($eventresponse);	
	    
        //Need to give start time and end time to get all the events from calendar.
	    //TODO: Here I am giving the time recent and next 60 days.
	    $timestart = time() - 432000;
        $timeend = time() + 5184000;		
        $moodleevents = calendar_get_events($timestart,$timeend,$USER->id,FALSE,FALSE,true,true);	

        //echo 'o365events: '; print_r($o365events); echo '<br/><br/>';
        //echo 'moodleevents: '; print_r($moodleevents); echo '<br/><br/>';
        
        // loop through all Office 365 events and create or update moodle events
	    if ($o365events) {	    	
            foreach ($o365events->value as $o365event) {
                // if event already exists in moodle, get its id so we can update it instead of creating a new one
                $event_id = 0;
                if ($moodleevents) {
                    foreach ($moodleevents as $moodleevent) {
                        if ((trim($moodleevent->uuid)) == trim($o365event->ChangeKey)) {
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
                    $event->context      = context_course::instance(1); // TODO: Let us put course ID as the first thing in the event 		
                    $event->uuid         = $o365event->ChangeKey;
                }
                
                $event->name         = $o365event->Subject;
                $event->description  = array("text" => $o365event->Subject,
                                        "format" => 1,
                                        "itemid" => $o365event->Id
                                         );
                $event->timestart    = strtotime($o365event->Start); // TODO: time is wrong. timezone problem?						
                $event->timeduration = strtotime($o365event->End) - strtotime($o365event->Start);
                
                //echo 'event id, uuid: '; print_r($event_id); echo ', '; print_r($event->uuid); echo '<br/><br/>';
                
                // create or update moodle event
                // TODO: this is creating a new event every time with same values. not updating existing.
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
                echo 'checking: '; print_r($moodleevent->uuid); echo '<br/><br/>';
                foreach ($o365events->value as $o365event) {
                    if (trim($moodleevent->uuid) == trim($o365event->ChangeKey)) { 
                        if ($found) {
                            echo 'duplicate: '; print_r($moodleevent->uuid); echo '<br/><br/>';
                            $moodleevent->delete(); // delete duplicates
                        }
                        
                        $found = true;
                    }
                }
                
                if (!$found) {
                    echo 'not found: '; print_r($moodleevent->uuid); echo '<br/><br/>';
                    $moodleevent->delete();
                }
            }
        }
        //exit;
    }	
}
