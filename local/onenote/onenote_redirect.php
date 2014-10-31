<?php

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/onenote_api.php');

$onenote_api = microsoft_onenote::getInstance(); // takes care of getting auth token and setting it into the api object
if (!$onenote_api->is_logged_in())
    throw new moodle_exception('Unable to log in to OneNote.');

$strhttpsbug = get_string('cannotaccessparentwin', 'repository');
$strrefreshnonjs = get_string('refreshnonjsfilepicker', 'repository');

$js =<<<EOD
<html>
<head>
    <script type="text/javascript">
    if(window.opener){
        window.opener.M.core_filepicker.active_filepicker.list();
        window.close();
    } else {
        alert("{$strhttpsbug }");
    }
    </script>
</head>
<body>
    <noscript>
    {$strrefreshnonjs}
    </noscript>
</body>
</html>
EOD;

die($js);