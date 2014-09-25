<?php
    $capabilities = array(
 
    'local/oevents:addinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS, 
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
 
    ),
);