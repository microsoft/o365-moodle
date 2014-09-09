<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
// Common utility methods:

// check if given user is a teacher in the given course
function is_teacher($course_id, $user_id) {
    //teacher role comes with courses.
    $context = context_course::instance($course_id);//get_context_instance(CONTEXT_COURSE, $course_id, true);
    
    $roles = get_user_roles($context, $user_id, true);

    foreach ($roles as $role) {
        if ($role->roleid == 3) {
            return true;
        }
    }

    return false;
}
function check_token_expiry() {
        global $SESSION;

        date_default_timezone_set('UTC');
        if(isset($SESSION->expires)) {
        if (time() > $SESSION->expires) {
            $refresh = array();
            if(isset($SESSION->params_office)) {
                $refresh['client_id'] = $SESSION->params_office['client_id'];
                $refresh['client_secret'] = $SESSION->params_office['client_secret'];
                $refresh['grant_type'] = "refresh_token";
                $refresh['refresh_token'] = $SESSION->refreshtoken;
                $refresh['resource'] = $SESSION->params_office['resource'];    
            }
            
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
    }
  }

?>