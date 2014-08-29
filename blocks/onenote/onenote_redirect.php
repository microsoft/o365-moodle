<?php

/*
 * Get Yammer code and call the home page
 * Needed to add the parameter authprovider in order to identify the authentication provider
 */
require('../../config.php');
$code = optional_param('code', '', PARAM_TEXT);

if (empty($code)) {
    throw new moodle_exception('onenote_failure');
}

$loginurl = '/my/'; // TODO: What should be this url to allow user to add the block on other pages?
if (!empty($CFG->alternateloginurl)) {
    $loginurl = $CFG->alternateloginurl;
}

$url = new moodle_url($loginurl, array('code' => $code, 'authprovider' => 'onenote'));
redirect($url);

?>
