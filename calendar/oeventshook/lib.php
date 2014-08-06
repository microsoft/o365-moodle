<?php
require_once($CFG->dirroot.'/local/oevents/lib.php');
    
     function oeventshook_add_event ($data) {
          global $USER; 
          if($USER->auth == "googleoauth2") {         
             $in = new events_o365(); 
             $in->insert_o365($data);
          }
    }
    function oeventshook_pre_delete_event ($data) {
           global $USER;         
           if($USER->auth == "googleoauth2") {         
             $in = new events_o365(); 
             $in->delete_o365($data);
          }
    }
?>