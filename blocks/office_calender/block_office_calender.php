<?php
class block_office_calender extends block_base {
    public function init() {
        $this->title = get_string('office_calender', 'block_office_calender');
    }
    
    public function get_content() {
    if ($this->content !== null) {
      return $this->content;
    }	
	global $USER,$SESSION;
	
	 if (!isloggedin()) {    	
        return false;
    } 
	 echo "<pre>";
	 print_r($SESSION->office_events);//exit;
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
							$event->userid       =$user->id;							
							$event->description  = array("text" =>"from the office 365",
													"format" => 1,
													"itemid" => $des_itemid
													 );
							$event->timestart    = strtotime($events_array->Start);						
							$event->timeduration = strtotime($events_array->End);
							$event->eventtype    = 'user';
							$event->context      = $context;
      						$calendar_event = new calendar_event();
							$calendar_event->update($event);							
			    		}
					}
					
					
	$events_url = 'https://outlook.office365.com/ews/odata/Me/Calendar/Events';
	//echo "code".$_SESSION['code'];
	// echo "<pre>";
	 //print_r($_SESSION[USER]);
	// echo $user_email = $_SESSION[USER]->email;
     //echo $url = 'https://outlook.office365.com/ews/odata/'.$user_email.'/Calendars';*/
     //  require_once($CFG->libdir . '/filelib.php');
     
	 $curl = new curl;
	 //$header = array('Content-Type: application/json');
     //$curl->setHeader($header);	 
	 $results = $curl->get($events_url);
	 //echo "hi";
	 print_r($results);
	  //echo json_decode($results);//exit;
	  
	    $this->content         =  new stdClass;
	    $this->content->text   = 'Moodle-Azure AD Calender block content';
	    $this->content->footer = 'Footer here...';
	//echo "<pre>";
	//print_r($_SESSION); 
    	
 
 
    return $this->content;
  }  
  
}