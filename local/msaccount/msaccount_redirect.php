<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    local_msaccount
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');

if (!\local_msaccount\api::getinstance()->is_logged_in()) { // Upgrades token and then checks for success.
    throw new moodle_exception('Unable to log in to Microsoft Account.');
}
$strhttpsbug = get_string('cannotaccessparentwin', 'local_msaccount');
$strrefreshnonjs = get_string('refreshnonjsfilepicker', 'local_msaccount');

$js = <<<EOD
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
