<?php
require_once($CFG->dirroot.'/local/oevents/lib.php');
    
     function oeventshook_add_event ( $data) {
         global $USER;
     //local_pp_error_log ("processing calendar event added",$data); 
      if($USER->auth == "googleoauth2") {         
         $in = new events_o365(); 
         $in->insert_o365($data);
      }
    }
    function oeventshook_delete_event ($data) {
        global $USER;
         echo "<pre>";
         print_r($data);
         $event = calendar_event::load($data);
         print_r($event);
         
         exit;
       if($USER->auth == "googleoauth2") {         
         $in = new events_o365(); 
         $in->delete_o365($data);
      } 
       
         
    }     
 



?>