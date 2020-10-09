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
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2015 onwards Microsoft, Inc. (http://microsoft.com/)
 */

require_once(__DIR__.'/../../config.php');
require_login();
$aadsync = get_config('local_o365', 'aadsync');
$aadsync = array_flip(explode(',', $aadsync));
// Only profile sync once for each session.
if (empty($SESSION->block_microsoft_profilesync)) {
    if (isset($aadsync['photosynconlogin']) || isset($aadsync['tzsynconlogin'])) {
        $PAGE->requires->jquery();
        $usersync = new \local_o365\feature\usersync\main();
        if (isset($aadsync['photosynconlogin'])) {
            $usersync->assign_photo($USER->id, null);
        }
        if (isset($aadsync['tzsynconlogin'])) {
            $usersync->sync_timezone($USER->id, null);
        }
        $SESSION->block_microsoft_profilesync = true;
    }
}
