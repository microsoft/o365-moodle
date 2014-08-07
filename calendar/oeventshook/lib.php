<?php
require_once($CFG->dirroot.'/local/oevents/lib.php');
    /*
     * Function written to get the auth provider of login
     * If the provider is Azure alone we will have the calls to hook
     * This calls inturn calls the plugin OEVENTS which fetch the 
     * O365 events throught office 365 api.
     */
     function get_auth_provider() {
         global $CFG;          
         $cookiename = 'MOODLEGOOGLEOAUTH2_'.$CFG->sessioncookie;
         if (empty($_COOKIE[$cookiename])) {
              $authprovider = '';
         } else {
              $authprovider = $_COOKIE[$cookiename];
         }
         return $authprovider;
     }    
     /*
      * Hook event which calls when a calendar event is added      * 
      */
     function oeventshook_add_event ($data) {
          $authprovider = get_auth_provider();           
          if($authprovider == "azuread") {         
             $in = new events_o365(); 
             $in->insert_o365($data);
          }
    }
    /*
     * Hook event call before the delete is done from moodle.     * 
     */
    function oeventshook_pre_delete_event ($data) {
           $authprovider = get_auth_provider();         
           if($authprovider == "azuread") {         
             $in = new events_o365(); 
             $in->delete_o365($data);
          }
    }
?>