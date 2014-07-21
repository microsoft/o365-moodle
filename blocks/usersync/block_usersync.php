<?php
class block_usersync extends block_base {
    public function init() {
        $this->title = get_string('usersync', 'block_usersync');
    }
    
    public function get_content() {
    if ($this->content !== null) {
      return $this->content;
    }
 
    $this->content         =  new stdClass;
    $this->content->text   = 'Moodle-Azure AD User Sync block content';
    $this->content->footer = 'Footer here...';
 
    return $this->content;
  }
  
  public function cron() {
    mtrace( "Moodle-Azure AD User Sync cron script is starting." );
 
    // do something
 
    mtrace( "Moodle-Azure AD User Sync cron script completed." );
    return true;
  }
}