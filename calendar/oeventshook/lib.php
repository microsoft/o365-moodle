<?php

global $CFG,$USER;

require_once $CFG->calendar .'/lib.php';

//$calendar = new calendar_event();
echo "<pre>";
print_r($calendar->properties);

echo $calendar::calendar_event_hook('update_event',array($calendar->properties));
//exit;
if(calendar_event_hook('update_event',array($calendar->properties))) {
    echo "I am in";exit;
}
if(calendar_event_hook('delete_event',array($calendar->properties))) {
    echo "I am in delete";exit;
}



?>