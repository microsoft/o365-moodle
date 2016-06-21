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
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\page;

/**
 * Admin control panel page.
 */
class acp extends base {

    /**
     * Add base navbar for this page.
     */
    protected function add_navbar() {
        global $PAGE;
        $mode = optional_param('mode', '', PARAM_TEXT);
        $extra = '';
        switch ($mode) {
            case 'usergroupcustom':
                $extra = '&s_local_o365_tabs=1';
                break;
            case 'healthcheck':
            case 'usermatch':
            case 'maintenance':
                $extra = '&s_local_o365_tabs=2';
                break;
        }
        $PAGE->navbar->add($this->title, new \moodle_url('/admin/settings.php?section=local_o365'.$extra));
    }

    /**
     * Set the system API user.
     */
    public function mode_setsystemuser() {
        redirect(new \moodle_url('/auth/oidc/index.php', ['promptaconsent' => 1, 'justauth' => 1]));
    }

    /**
     * Perform health checks.
     */
    public function mode_healthcheck() {
        $this->standard_header();

        echo \html_writer::tag('h2', get_string('acp_healthcheck', 'local_o365'));
        echo '<br />';

        $healthchecks = ['systemapiuser', 'ratelimit'];
        foreach ($healthchecks as $healthcheck) {
            $healthcheckclass = '\local_o365\healthcheck\\'.$healthcheck;
            $healthcheck = new $healthcheckclass();
            $result = $healthcheck->run();

            echo '<h5>'.$healthcheck->get_name().'</h5>';
            if ($result['result'] === true) {
                echo '<div class="alert alert-success">'.$result['message'].'</div><br />';
            } else {
                switch ($result['severity']) {
                    case \local_o365\healthcheck\healthcheckinterface::SEVERITY_TRIVIAL:
                        $severityclass = 'alert-info';
                        break;

                    default:
                        $severityclass = 'alert-error';
                }

                echo '<div class="alert '.$severityclass.'">';
                echo $result['message'];
                if (isset($result['fixlink'])) {
                    echo '<br /><br />'.\html_writer::link($result['fixlink'], get_string('healthcheck_fixlink', 'local_o365'));
                }
                echo '</div><br />';
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
                                        $newrec->openidconnect = (isset($data[2]) &&  intval(trim($data[2]))) >  0  ? 1 : 0;
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
                echo \html_writer::div($error, 'alert-error alert local_o365_statusmessage');
            }
            $SESSION->o365matcherrors = [];
        }
        $mform->display();

        echo \html_writer::empty_tag('br');
        echo \html_writer::tag('h4', get_string('acp_usermatch_matchqueue', 'local_o365'));
        echo \html_writer::div(get_string('acp_usermatch_matchqueue_desc', 'local_o365'));
        $matchqueuelength = $DB->count_records('local_o365_matchqueue');
        if ($matchqueuelength > 0) {

            echo \html_writer::start_tag('div', ['class' => 'local_o365_matchqueuetoolbar']);

            $clearurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'usermatchclear']);
            $clearurl = $clearurl->out();

            // Clear successful button.
            $checkicon = $OUTPUT->pix_icon('t/check', 'success', 'moodle');
            $clearcallback = '$(\'table.local_o365_matchqueue\').find(\'tr.success\').fadeOut();';
            $attrs = ['onclick' => '$.post(\''.$clearurl.'\', {type:\'success\'}, function(data) { '.$clearcallback.' })'];
            $buttontext = get_string('acp_usermatch_matchqueue_clearsuccess', 'local_o365');
            echo \html_writer::tag('button', $checkicon.' '.$buttontext, $attrs);

            // Clear error button.
            $warningicon = $OUTPUT->pix_icon('i/warning', 'warning', 'moodle');
            $clearcallback = '$(\'table.local_o365_matchqueue\').find(\'tr.error\').fadeOut();';
            $attrs = ['onclick' => '$.post(\''.$clearurl.'\', {type:\'error\'}, function(data) { '.$clearcallback.' })'];
            $buttontext = get_string('acp_usermatch_matchqueue_clearerrors', 'local_o365');
            echo \html_writer::tag('button', $warningicon.' '.$buttontext, $attrs);

            // Clear warning button.
            $queuedicon = $OUTPUT->pix_icon('i/scheduled', 'warning', 'moodle');
            $clearcallback = '$(\'table.local_o365_matchqueue\').find(\'tr.queued\').fadeOut();';
            $attrs = ['onclick' => '$.post(\''.$clearurl.'\', {type:\'queued\'}, function(data) { '.$clearcallback.' })'];
            $buttontext = get_string('acp_usermatch_matchqueue_clearqueued', 'local_o365');
            echo \html_writer::tag('button', $queuedicon.' '.$buttontext, $attrs);

            // Clear all button.
            $removeicon = $OUTPUT->pix_icon('t/delete', 'warning', 'moodle');
            $clearcallback = '$(\'table.local_o365_matchqueue\').find(\'tr:not(:first-child)\').fadeOut();';
            $attrs = ['onclick' => '$.post(\''.$clearurl.'\', {type:\'all\'}, function(data) { '.$clearcallback.' })'];
            $buttontext = get_string('acp_usermatch_matchqueue_clearall', 'local_o365');
            echo \html_writer::tag('button', $removeicon.' '.$buttontext, $attrs);

            echo \html_writer::end_tag('div');

            $matchqueue = $DB->get_recordset('local_o365_matchqueue', null, 'id ASC');
            // Constructing table manually instead of \html_table for memory reasons.
            echo \html_writer::start_tag('table', ['class' => 'local_o365_matchqueue']);
            echo \html_writer::start_tag('tr');
            echo \html_writer::tag('th', '');
            echo \html_writer::tag('th', get_string('acp_usermatch_matchqueue_column_muser', 'local_o365'));
            echo \html_writer::tag('th', get_string('acp_usermatch_matchqueue_column_o365user', 'local_o365'));
            echo \html_writer::tag('th', get_string('acp_usermatch_matchqueue_column_openidconnect', 'local_o365'));
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
                echo \html_writer::tag('td', $queuerec->openidconnect > 0 ? get_string('yes') : get_string('no'));

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
            $msgclasses = 'alert-info alert local_o365_statusmessage';
            echo \html_writer::div(get_string('acp_usermatch_matchqueue_empty', 'local_o365'), $msgclasses);
        }
        $this->standard_footer();
    }

    /**
     * Endpoint to change user group customization.
     */
    public function mode_usergroupcustom_change() {
        $coursedata = json_decode(required_param('coursedata', PARAM_RAW), true);
        require_sesskey();

        foreach ($coursedata as $courseid => $course) {
            foreach ($course as $feature => $value) {
                if ($feature === 'enabled') {
                    \local_o365\feature\usergroups\utils::set_course_group_enabled($courseid, $value);
                } else if (in_array($feature, ['onedrive', 'calendar', 'conversations'])) {
                    \local_o365\feature\usergroups\utils::set_course_group_feature_enabled($courseid, [$feature], $value);
                }
            }
        }
        echo json_encode(['Saved']);
    }

    /**
     * Endpoint to change user group customization.
     */
    public function mode_usergroupcustom_bulkchange() {
        $enabled = (bool)required_param('state', PARAM_BOOL);
        $feature = (string)optional_param('feature', 'enabled', PARAM_ALPHA);
        require_sesskey();
        \local_o365\feature\usergroups\utils::bulk_set_group_feature_enabled($feature, $enabled);
        echo json_encode(['Saved']);
    }

    /**
     * User group customization.
     */
    public function mode_usergroupcustom() {
        global $OUTPUT, $PAGE;

        $PAGE->navbar->add(get_string('acp_usergroupcustom', 'local_o365'), new \moodle_url($this->url, ['mode' => 'usergroupcustom']));

        $totalcount = 0;
        $perpage = 20;

        $curpage = optional_param('page', 0, PARAM_INT);
        $sort = optional_param('sort', '', PARAM_ALPHA);
        $sortdir = strtolower(optional_param('sortdir', 'asc', PARAM_ALPHA));

        $headers = [
            'shortname' => get_string('shortnamecourse'),
            'fullname' => get_string('fullnamecourse'),
        ];
        if (empty($sort) || !isset($headers[$sort])) {
            $sort = 'shortname';
        }
        if (!in_array($sortdir, ['asc', 'desc'], true)) {
            $sortdir = 'asc';
        }

        $table = new \html_table;
        foreach ($headers as $hkey => $desc) {
            $diffsortdir = ($sort === $hkey && $sortdir === 'asc') ? 'desc' : 'asc';
            $linkattrs = ['mode' => 'usergroupcustom', 'sort' => $hkey, 'sortdir' => $diffsortdir];
            $link = new \moodle_url('/local/o365/acp.php', $linkattrs);

            if ($sort === $hkey) {
                $desc .= ' '.$OUTPUT->pix_icon('t/'.'sort_'.$sortdir, 'sort');
            }
            $table->head[] = \html_writer::link($link, $desc);
        }
        $table->head[] = get_string('acp_usergroupcustom_enabled', 'local_o365');
        $table->head[] = get_string('groups_onedrive', 'local_o365');
        $table->head[] = get_string('groups_calendar', 'local_o365');
        $table->head[] = get_string('groups_conversations', 'local_o365');
        $table->head[] = get_string('groups_notebook', 'local_o365');

        $limitfrom = $curpage * $perpage;
        $coursesid = [];
        $courses = get_courses_page('all', 'c.'.$sort.' '.$sortdir, 'c.*', $totalcount, $limitfrom, $perpage);
        foreach ($courses as $course) {
            if ($course->id == SITEID) {
                continue;
            }
            $coursesid[] = $course->id;
            $isenabled = \local_o365\feature\usergroups\utils::course_is_group_enabled($course->id);
            $enabledname = 'course_'.$course->id.'_enabled';
            $onedriveenabled = \local_o365\feature\usergroups\utils::course_is_group_feature_enabled($course->id, 'onedrive');
            $onedrivename = 'course_onedrive_'.$course->id.'_enabled';
            $calendarenabled = \local_o365\feature\usergroups\utils::course_is_group_feature_enabled($course->id, 'calendar');
            $calendarname = 'course_calendar_'.$course->id.'_enabled';
            $convenabled = \local_o365\feature\usergroups\utils::course_is_group_feature_enabled($course->id, 'conversations');
            $convname = 'course_conversations_'.$course->id.'_enabled';

            $enablecheckboxattrs = [
                'onchange' => 'local_o365_set_usergroup(\''.$course->id.'\', $(this).prop(\'checked\'), $(this))'
            ];
            $onedrivecheckboxattrs = [
                'class' => 'feature feature_onedrive',
            ];
            $calendarcheckboxattrs = [
                'class' => 'feature feature_calendar',
            ];
            $convcheckboxattrs = [
                'class' => 'feature feature_conversations',
            ];

            if ($isenabled !== true) {
                $onedrivecheckboxattrs['disabled'] = '';
                $calendarcheckboxattrs['disabled'] = '';
                $convcheckboxattrs['disabled'] = '';
            }

            $rowdata = [
                $course->shortname,
                $course->fullname,
                \html_writer::checkbox($enabledname, 1, $isenabled, '', $enablecheckboxattrs),
                \html_writer::checkbox($onedrivename, 1, $onedriveenabled, '', $onedrivecheckboxattrs),
                \html_writer::checkbox($calendarname, 1, $calendarenabled, '', $calendarcheckboxattrs),
                \html_writer::checkbox($convname, 1, $convenabled, '', $convcheckboxattrs),
                get_string('acp_usergroupcustom_comingsoon', 'local_o365'),
            ];
            $table->data[] = $rowdata;
        }

        $PAGE->requires->jquery();
        $this->standard_header();

        $endpoint = new \moodle_url('/local/o365/acp.php', ['mode' => 'usergroupcustom_change', 'sesskey' => sesskey()]);
        $bulkendpoint = new \moodle_url('/local/o365/acp.php', ['mode' => 'usergroupcustom_bulkchange', 'sesskey' => sesskey()]);

        $js = 'var local_o365_set_usergroup = function(courseid, state, checkbox) { ';
        $js .= 'data = {courseid: courseid, state: state}; ';
        $js .= 'var newfeaturedisabled = (state == 0) ? true : false; ';
        $js .= 'var newfeaturechecked = (state == 1) ? true : false; ';
        $js .= 'var featurecheckboxes = checkbox.parents("tr").find("input.feature"); ';
        $js .= 'featurecheckboxes.prop("disabled", newfeaturedisabled); ';
        $js .= 'featurecheckboxes.prop("checked", newfeaturechecked); ';
        $js .= '}; ';

        $js .= 'var local_o365_usergroup_bulk_set_feature = function(feature, state) { ';
        $js .= 'var enabled = (state == 1) ? true : false; ';
        $js .= 'console.log("local_o365_usergroup_bulk_set_feature " + state + " " + enabled); ';
        $js .= '$("input.feature_"+feature+":not(:disabled)").prop("checked", enabled); ';
        $js .= '}; ';
        $js .= 'var local_o365_usergroup_coursesid = '.json_encode($coursesid).'; ';
        $js .= 'var local_o365_usergroup_features = ["calendar", "onedrive", "conversations"]; ';

        $js .= 'var local_o365_usergroup_save = function() { '."\n";
        $js .= 'var coursedata = {}; '."\n";
        $js .= 'for (var i = 0; i < local_o365_usergroup_coursesid.length; i++) {'."\n";
        $js .= 'var courseid = local_o365_usergroup_coursesid[i]; '."\n";
        $js .= 'var enabled = $("input[name=\'course_"+courseid+"_enabled\']").is(\':checked\'); '."\n";
        $js .= 'var features = {enabled: enabled}; '."\n";
        $js .= 'for (var j = 0; j < local_o365_usergroup_features.length; j++) {'."\n";
        $js .= '    var feature = local_o365_usergroup_features[j]; '."\n";
        $js .= '    if (enabled) { '."\n";
        $js .= '        features[feature] = $("input[name=\'course_"+feature+"_"+courseid+"_enabled\']").is(\':checked\'); '."\n";
        $js .= '        console.log("local_o365_usergroup_save " + feature + " " + features[feature]); '."\n";
        $js .= '    } else { // If enabled.'."\n";
        $js .= '        features[feature] = false; ';
        $js .= '    }; '."\n";
        $js .= '}; '."\n";
        $js .= 'coursedata[courseid] = features; '."\n";
        $js .= '}; '."\n";
        $js .= ' // Send data to server. '."\n";
        $js .= '$.ajax({
            url: \''.$endpoint->out(false).'\',
            data: {coursedata: JSON.stringify(coursedata)},
            type: "POST",
            success: function(data) {
                console.log(data);
                $(\'#acp_usergroupcustom_savemessage\').show();
                setTimeout(function () { $(\'#acp_usergroupcustom_savemessage\').hide(); }, 5000);
            }
        }); '."\n";
        $js .= '}; '."\n";
        echo \html_writer::script($js);
        echo \html_writer::tag('h2', get_string('acp_usergroupcustom', 'local_o365'));

        // Bulk Operations
        $strbulkenable = get_string('acp_usergroupcustom_bulk_enable', 'local_o365');
        $strbulkdisable = get_string('acp_usergroupcustom_bulk_disable', 'local_o365');
        echo \html_writer::tag('h5', get_string('acp_usergroupcustom_bulk', 'local_o365'));
        echo \html_writer::start_tag('div', ['style' => 'display: inline-block;margin: 0 1rem']);
        echo \html_writer::tag('span', get_string('groups_onedrive', 'local_o365').': ');
        echo \html_writer::tag('button', $strbulkenable, ['onclick' => 'local_o365_usergroup_bulk_set_feature(\'onedrive\', 1)']);
        echo \html_writer::tag('button', $strbulkdisable, ['onclick' => 'local_o365_usergroup_bulk_set_feature(\'onedrive\', 0)']);
        echo \html_writer::end_tag('div');

        echo \html_writer::start_tag('div', ['style' => 'display: inline-block;margin: 0 1rem']);
        echo \html_writer::tag('span', get_string('groups_calendar', 'local_o365').': ');
        echo \html_writer::tag('button', $strbulkenable, ['onclick' => 'local_o365_usergroup_bulk_set_feature(\'calendar\', 1)']);
        echo \html_writer::tag('button', $strbulkdisable, ['onclick' => 'local_o365_usergroup_bulk_set_feature(\'calendar\', 0)']);
        echo \html_writer::end_tag('div');

        echo \html_writer::start_tag('div', ['style' => 'display: inline-block;margin: 0 1rem']);
        echo \html_writer::tag('span', get_string('groups_conversations', 'local_o365').': ');
        echo \html_writer::tag('button', $strbulkenable, ['onclick' => 'local_o365_usergroup_bulk_set_feature(\'conversations\', 1)']);
        echo \html_writer::tag('button', $strbulkdisable, ['onclick' => 'local_o365_usergroup_bulk_set_feature(\'conversations\', 0)']);
        echo \html_writer::end_tag('div');

        echo \html_writer::tag('h5', get_string('courses'));
        echo \html_writer::table($table);
        echo \html_writer::tag('p', get_string('acp_usergroupcustom_savemessage', 'local_o365'), ['id' => 'acp_usergroupcustom_savemessage', 'style' => 'display: none; font-weight: bold; color: red']);
        echo  \html_writer::tag('button', get_string('savechanges'), ['class'=>'buttonsbar', 'onclick' => 'local_o365_usergroup_save()']);
        $cururl = new \moodle_url('/local/o365/acp.php', ['mode' => 'usergroupcustom']);
        echo $OUTPUT->paging_bar($totalcount, $curpage, $perpage, $cururl);
        $this->standard_footer();
    }

    /**
     * Resync course usergroup membership.
     */
    public function mode_maintenance_coursegroupusers() {
        global $DB;
        $courseid = optional_param('courseid', 0, PARAM_INT);
        \core_php_time_limit::raise(0);
        raise_memory_limit(MEMORY_EXTRA);
        disable_output_buffering();

        $httpclient = new \local_o365\httpclient();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $graphresource = \local_o365\rest\unified::get_resource();
        $graphtoken = \local_o365\oauth2\systemtoken::instance(null, $graphresource, $clientdata, $httpclient);
        if (empty($graphtoken)) {
            mtrace('Could not get Microsoft Graph API token.');
            return true;
        }
        $graphclient = new \local_o365\rest\unified($graphtoken, $httpclient);
        $coursegroups = new \local_o365\feature\usergroups\coursegroups($graphclient, $DB, true);

        $coursesenabled = \local_o365\feature\usergroups\utils::get_enabled_courses();
        if (empty($coursesenabled)) {
            mtrace('No courses are enabled for groups, or groups are disabled.');
            return false;
        }

        $sql = 'SELECT crs.id,
                       obj.objectid as groupobjectid
                  FROM {course} crs
                  JOIN {local_o365_objects} obj ON obj.type = ? AND obj.subtype = ? AND obj.moodleid = crs.id
                 WHERE crs.id != ?';
        $params = ['group', 'course', SITEID];
        if (!empty($courseid)) {
            $sql .= ' AND crs.id = ?';
            $params[] = $courseid;
        }
        if (is_array($coursesenabled)) {
            list($coursesinsql, $coursesparams) = $DB->get_in_or_equal($coursesenabled);
            $sql .= ' AND crs.id '.$coursesinsql;
            $params = array_merge($params, $coursesparams);
        }
        $courses = $DB->get_recordset_sql($sql, $params);
        foreach ($courses as $course) {
            try {
                echo '<pre>';
                $coursegroups->resync_group_membership($course->id, $course->groupobjectid);
                echo '</pre>';
                mtrace(PHP_EOL);
            } catch (\Exception $e) {
                mtrace('Could not sync course '.$course->id.'. Reason: '.$e->getMessage());
            }
        }
        $courses->close();

        die();
    }

    /**
     * Maintenance tools.
     */
    public function mode_maintenance() {
        global $DB, $OUTPUT, $PAGE, $SESSION;
        $PAGE->navbar->add(get_string('acp_maintenance', 'local_o365'), new \moodle_url($this->url, ['mode' => 'maintenance']));
        $PAGE->requires->jquery();
        $this->standard_header();

        echo \html_writer::tag('h2', get_string('acp_maintenance', 'local_o365'));
        echo \html_writer::div(get_string('acp_maintenance_desc', 'local_o365'));
        echo \html_writer::empty_tag('br');
        echo \html_writer::div(get_string('acp_maintenance_warning', 'local_o365'), 'alert alert-info');

        $toolurl = new \moodle_url($this->url, ['mode' => 'maintenance_coursegroupusers']);
        $toolname = get_string('acp_maintenance_coursegroupusers', 'local_o365');
        echo \html_writer::link($toolurl, $toolname, ['target' => '_blank']);
        echo \html_writer::div(get_string('acp_maintenance_coursegroupusers_desc', 'local_o365'));

        $this->standard_footer();
    }
}
