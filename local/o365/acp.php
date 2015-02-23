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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

require_once(__DIR__.'/../../config.php');

$mode = required_param('mode', PARAM_TEXT);

require_login();
require_capability('moodle/site:config', \context_system::instance());

if ($mode === 'setsystemuser') {
    $SESSION->auth_oidc_justevent = true;
    redirect(new \moodle_url('/auth/oidc/index.php', ['promptlogin' => 1]));
} else if ($mode === 'healthcheck') {
    $PAGE->set_url('/local/o365/acp.php');
    $PAGE->set_context(\context_system::instance());
    $PAGE->set_pagelayout('standard');
    $acptitle = get_string('acp_title', 'local_o365');
    $PAGE->navbar->add($acptitle, $PAGE->url);
    $PAGE->set_title($acptitle);
    echo $OUTPUT->header();
    echo \html_writer::tag('h5', $acptitle);
    echo \html_writer::tag('h2', get_string('acp_healthcheck', 'local_o365'));
    echo '<br />';

    $healthchecks = ['systemapiuser'];
    foreach ($healthchecks as $healthcheck) {
        $healthcheckclass = '\local_o365\healthcheck\\'.$healthcheck;
        $healthcheck = new $healthcheckclass();
        $result = $healthcheck->run();

        echo '<h5>'.$healthcheck->get_name().'</h5>';
        if ($result['result'] === true) {
            echo '<div class="alert-success">'.$result['message'].'</div>';
        } else {
            echo '<div class="alert-error">';
            echo $result['message'];
            if (isset($result['fixlink'])) {
                echo '<br /><br />'.\html_writer::link($result['fixlink'], get_string('healthcheck_fixlink', 'local_o365'));
            }
            echo '</div>';
        }
    }

    echo $OUTPUT->footer();
}