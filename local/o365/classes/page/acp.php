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

namespace local_o365\page;

/**
 * Admin control panel page.
 */
class acp extends base {

    /**
     * Set the system API user.
     */
    public function mode_setsystemuser() {
        global $SESSION;
        $SESSION->auth_oidc_justevent = true;
        redirect(new \moodle_url('/auth/oidc/index.php', ['promptlogin' => 1]));
    }

    /**
     * Perform health checks.
     */
    public function mode_healthcheck() {
        $this->standard_header();

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

        $this->standard_footer();
    }

    /**
     * Clear items from the match queue.
     */
    public function mode_usermatchclear() {
        global $DB;
        $type = optional_param('type', null, PARAM_TEXT);
        $return = ['success' => false];
        switch ($type) {
            case 'success':
                $DB->delete_records_select('local_o365_matchqueue', 'completed = "1" AND errormessage = ""');
                $return = ['success' => true];
                break;

            case 'error':
                $DB->delete_records_select('local_o365_matchqueue', 'completed = "1" AND errormessage != ""');
                $return = ['success' => true];
                break;

            case 'queued':
                $DB->delete_records_select('local_o365_matchqueue', 'completed = "0"');
                $return = ['success' => true];
                break;

            case 'all':
                $DB->delete_records('local_o365_matchqueue');
                $return = ['success' => true];
                break;

            default:
                $return = ['success' => false];
        }
        echo json_encode($return);
        die();
    }

    /**
     * User match tool.
     */
    public function mode_usermatch() {
        global $DB, $OUTPUT, $PAGE, $SESSION;

        $errors = [];
        $mform = new \local_o365\form\usermatch('?mode=usermatch');
        if ($fromform = $mform->get_data()) {
            $datafile = $mform->save_temp_file('matchdatafile');
            if (!empty($datafile)) {
                $finfo = new \finfo();
                $type = $finfo->file($datafile, FILEINFO_MIME);
                $type = explode(';', $type);
                if (strtolower($type[0]) === 'text/plain') {
                    try {
                        $fh = fopen($datafile, 'r');
                        if (!empty($fh)) {
                            $row = 1;
                            while (($data = fgetcsv($fh)) !== false) {
                                if (!empty($data)) {
                                    if (isset($data[0]) && isset($data[1])) {
                                        $newrec = new \stdClass;
                                        $newrec->musername = trim($data[0]);
                                        $newrec->o365username = trim($data[1]);
                                        $newrec->completed = 0;
                                        $newrec->errormessage = '';
                                        $DB->insert_record('local_o365_matchqueue', $newrec);
                                    } else {
                                        $errors[] = get_string('acp_usermatch_upload_err_data', 'local_o365', $row);
                                    }
                                }
                                $row++;
                            }
                            fclose($fh);
                        } else {
                            $errors[] = get_string('acp_usermatch_upload_err_fileopen', 'local_o365');
                        }
                    } catch (\Exception $e) {
                        $errors[] = $e->getMessage();
                    }
                } else {
                    $errors[] = get_string('acp_usermatch_upload_err_badmime', 'local_o365', $type[0]);
                }
                @unlink($datafile);
                $mform->set_data([]);
            } else {
                $errors[] = get_string('acp_usermatch_upload_err_nofile', 'local_o365');
            }
            if (!empty($errors)) {
                $SESSION->o365matcherrors = $errors;
            }
            redirect(new \moodle_url('/local/o365/acp.php', ['mode' => 'usermatch']));
            die();
        }

        $PAGE->requires->jquery();
        $this->standard_header();
        echo \html_writer::tag('h2', get_string('acp_usermatch', 'local_o365'));
        echo \html_writer::div(get_string('acp_usermatch_desc', 'local_o365'));
        echo \html_writer::empty_tag('br');
        echo \html_writer::empty_tag('br');
        echo \html_writer::tag('h4', get_string('acp_usermatch_upload', 'local_o365'));
        echo \html_writer::div(get_string('acp_usermatch_upload_desc', 'local_o365'));
        echo \html_writer::empty_tag('br');
        if (!empty($SESSION->o365matcherrors)) {
            foreach ($SESSION->o365matcherrors as $error) {
                echo \html_writer::div($error, 'alert-error local_o365_statusmessage');
            }
            $SESSION->o365matcherrors = [];
        }
        $mform->display();

        echo \html_writer::empty_tag('br');
        echo \html_writer::tag('h4', get_string('acp_usermatch_matchqueue', 'local_o365'));
        echo \html_writer::div(get_string('acp_usermatch_matchqueue_desc', 'local_o365'));
        $matchqueuelength = $DB->count_records('local_o365_matchqueue');
        if ($matchqueuelength > 0) {

            echo \html_writer::start_tag('div', ['class' => 'matchqueuetoolbar']);

            $clearurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'usermatchclear']);
            $clearurl = $clearurl->out();

            // Clear successful button.
            $checkicon = $OUTPUT->pix_icon('t/check', 'success', 'moodle');
            $clearcallback = '$(\'table.matchqueue\').find(\'tr.success\').fadeOut();';
            $attrs = ['onclick' => '$.post(\''.$clearurl.'\', {type:\'success\'}, function(data) { '.$clearcallback.' })'];
            $buttontext = get_string('acp_usermatch_matchqueue_clearsuccess', 'local_o365');
            echo \html_writer::tag('button', $checkicon.' '.$buttontext, $attrs);

            // Clear error button.
            $warningicon = $OUTPUT->pix_icon('i/warning', 'warning', 'moodle');
            $clearcallback = '$(\'table.matchqueue\').find(\'tr.error\').fadeOut();';
            $attrs = ['onclick' => '$.post(\''.$clearurl.'\', {type:\'error\'}, function(data) { '.$clearcallback.' })'];
            $buttontext = get_string('acp_usermatch_matchqueue_clearerrors', 'local_o365');
            echo \html_writer::tag('button', $warningicon.' '.$buttontext, $attrs);

            // Clear warning button.
            $queuedicon = $OUTPUT->pix_icon('i/scheduled', 'warning', 'moodle');
            $clearcallback = '$(\'table.matchqueue\').find(\'tr.queued\').fadeOut();';
            $attrs = ['onclick' => '$.post(\''.$clearurl.'\', {type:\'queued\'}, function(data) { '.$clearcallback.' })'];
            $buttontext = get_string('acp_usermatch_matchqueue_clearqueued', 'local_o365');
            echo \html_writer::tag('button', $queuedicon.' '.$buttontext, $attrs);

            // Clear all button.
            $removeicon = $OUTPUT->pix_icon('t/delete', 'warning', 'moodle');
            $clearcallback = '$(\'table.matchqueue\').find(\'tr:not(:first-child)\').fadeOut();';
            $attrs = ['onclick' => '$.post(\''.$clearurl.'\', {type:\'all\'}, function(data) { '.$clearcallback.' })'];
            $buttontext = get_string('acp_usermatch_matchqueue_clearall', 'local_o365');
            echo \html_writer::tag('button', $removeicon.' '.$buttontext, $attrs);

            echo \html_writer::end_tag('div');

            $matchqueue = $DB->get_recordset('local_o365_matchqueue', null, 'id ASC');
            // Constructing table manually instead of \html_table for memory reasons.
            echo \html_writer::start_tag('table', ['class' => 'matchqueue']);
            echo \html_writer::start_tag('tr');
            echo \html_writer::tag('th', '');
            echo \html_writer::tag('th', get_string('acp_usermatch_matchqueue_column_muser', 'local_o365'));
                echo \html_writer::tag('th', get_string('acp_usermatch_matchqueue_column_o365user', 'local_o365'));
                echo \html_writer::tag('th', get_string('acp_usermatch_matchqueue_column_status', 'local_o365'));
            echo \html_writer::end_tag('tr');
            foreach ($matchqueue as $queuerec) {
                $status = 'queued';
                $trclass = 'alert-info queued';
                if (!empty($queuerec->completed) && empty($queuerec->errormessage)) {
                    $status = 'success';
                    $trclass = 'alert-success success';
                } else if (!empty($queuerec->errormessage)) {
                    $status = 'error';
                    $trclass = 'alert-error error';
                }

                echo \html_writer::start_tag('tr', ['class' => $trclass]);

                switch ($status) {
                    case 'success':
                        echo \html_writer::tag('td', $checkicon);
                        break;

                    case 'error':
                        echo \html_writer::tag('td', $warningicon);
                        break;

                    default:
                        echo \html_writer::tag('td', $queuedicon);
                }

                echo \html_writer::tag('td', $queuerec->musername);
                echo \html_writer::tag('td', $queuerec->o365username);

                switch ($status) {
                    case 'success':
                        echo \html_writer::tag('td', get_string('acp_usermatch_matchqueue_status_success', 'local_o365'));
                        break;

                    case 'error':
                        $statusstr = get_string('acp_usermatch_matchqueue_status_error', 'local_o365', $queuerec->errormessage);
                        echo \html_writer::tag('td', $statusstr);
                        break;

                    default:
                        echo \html_writer::tag('td', get_string('acp_usermatch_matchqueue_status_queued', 'local_o365'));
                }
                echo \html_writer::end_tag('tr');
            }
            echo \html_writer::end_tag('table');
            $matchqueue->close();
        } else {
            $msgclasses = 'alert-info local_o365_statusmessage';
            echo \html_writer::div(get_string('acp_usermatch_matchqueue_empty', 'local_o365'), $msgclasses);
        }
        $this->standard_footer();
    }
}
