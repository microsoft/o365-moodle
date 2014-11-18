<?php

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/msaccount_client.php');

if (!msaccount_api::getInstance()->is_logged_in()) // upgrades token and then checks for success
    throw new moodle_exception('Unable to log in to Microsoft Account.');

$strhttpsbug = get_string('cannotaccessparentwin', 'local_msaccount');
$strrefreshnonjs = get_string('refreshnonjsfilepicker', 'local_msaccount');

$js =<<<EOD
<html>
<head>
    <script type="text/javascript">
    if(window.opener){
        try {
            window.opener.M.core_filepicker.active_filepicker.list();
        } catch (ex) { 
            alert("{$strhttpsbug }");
        }
    } else {
        alert("{$strhttpsbug }");
    }
        
    window.close();
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