<?php

$functions = [
        'tiny_teamsmeeting_edit_meeting' => [
                'classname'   => '\tiny_teamsmeeting\edit_meeting_api',
                'methodname'  => 'edit_meeting',
                'classpath'   => 'lib/editor/tiny/plugins/teamsmeeting/classes/edit_meeting_api.php',
                'description' => 'Edit existing meeting',
                'type'        => 'write',
                'ajax'        => true
        ]
];

$services = [
        'tiny_teamsmeeting_service' => [
                'functions' => ['tiny_teamsmeeting_edit_meeting'],
                'restrictedusers' => 0,
                'enabled' => 1
        ]
];
