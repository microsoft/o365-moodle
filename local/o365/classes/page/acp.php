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
     * Override set_title() function - not showing heading.
     *
     * @param string $title
     */
    public function set_title($title) {
        global $PAGE;
        $this->title = $title;
        $PAGE->set_title($this->title);
    }

    /**
     * Add base navbar for this page.
     */
    protected function add_navbar() {
        global $PAGE;
        $mode = optional_param('mode', '', PARAM_TEXT);
        $extra = '';
        switch ($mode) {
            case 'usergroupcustom':
            case 'sharepointcourseselect':
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
     * Provide admin consent.
     */
    public function mode_adminconsent() {
        $auth = new \auth_oidc\loginflow\authcode;
        $auth->set_httpclient(new \auth_oidc\httpclient());
        $stateparams = [
            'redirect' => '/admin/settings.php?section=local_o365',
            'justauth' => true,
            'forceflow' => 'authcode',
            'action' => 'adminconsent',
        ];
        $extraparams = ['prompt' => 'admin_consent'];
        $auth->initiateauthrequest(true, $stateparams, $extraparams);
    }

    /**
     * Set the system API user.
     */
    public function mode_setsystemuser() {
        $auth = new \auth_oidc\loginflow\authcode;
        $auth->set_httpclient(new \auth_oidc\httpclient());
        $stateparams = [
            'redirect' => '/admin/settings.php?section=local_o365',
            'justauth' => true,
            'forceflow' => 'authcode',
            'action' => 'setsystemapiuser',
        ];
        $extraparams = ['prompt' => 'admin_consent'];
        $auth->initiateauthrequest(true, $stateparams, $extraparams);
    }

    /**
     * This function ensures setup is sufficiently complete to add additional tenants.
     */
    public function checktenantsetup() {
        $config = get_config('local_o365');
        if (empty($config->aadtenant)) {
            return false;
        }
        if (\local_o365\utils::is_configured_apponlyaccess() === true || !empty($config->systemtokens)) {
            return true;
        }
        return false;
    }

    /**
     * Configure additional tenants.
     */
    public function mode_tenants() {
        global $CFG;
        $this->standard_header();
        echo \html_writer::tag('h2', get_string('acp_tenants_title', 'local_o365'));
        echo \html_writer::div(get_string('acp_tenants_title_desc', 'local_o365'));
        echo \html_writer::empty_tag('br');
        $config = get_config('local_o365');
        if ($this->checktenantsetup() !== true) {
            $errmsg = get_string('acp_tenants_errornotsetup', 'local_o365');
            echo \html_writer::div($errmsg, 'alert alert-info');
            $this->standard_footer();
            return;
        }

        $multitenantdesc = get_string('acp_tenants_intro', 'local_o365', $CFG->wwwroot);
        echo \html_writer::div($multitenantdesc, 'alert alert-info');

        echo \html_writer::empty_tag('br');
        $hosttenantstr = get_string('acp_tenants_hosttenant', 'local_o365', $config->aadtenant);
        $hosttenanthtml = \html_writer::tag('h4', $hosttenantstr);
        echo \html_writer::div($hosttenanthtml, '');
        echo \html_writer::empty_tag('br');

        $addtenantstr = get_string('acp_tenants_add', 'local_o365');
        $addtenanturl = new \moodle_url('/local/o365/acp.php', ['mode' => 'tenantsadd']);
        echo \html_writer::link($addtenanturl, $addtenantstr, ['class' => 'btn btn-primary']);

        $configuredtenants = get_config('local_o365', 'multitenants');
        if (!empty($configuredtenants)) {
            $configuredtenants = json_decode($configuredtenants, true);
            if (!is_array($configuredtenants)) {
                $configuredtenants = [];
            }
        }

        if (!empty($configuredtenants)) {
            $table = new \html_table;
            $table->head[] = get_string('acp_tenants_tenant', 'local_o365');
            $table->head[] = get_string('acp_tenants_actions', 'local_o365');
            $revokeaccessstr = get_string('acp_tenants_revokeaccess', 'local_o365');
            foreach ($configuredtenants as $configuredtenant) {
                $revokeurlparams = [
                    'mode' => 'tenantsrevoke',
                    't' => base64_encode($configuredtenant),
                    'sesskey' => sesskey(),
                ];
                $revokeurl = new \moodle_url('/local/o365/acp.php', $revokeurlparams);
                $table->data[] = [
                    $configuredtenant,
                    \html_writer::link($revokeurl, $revokeaccessstr),
                ];
            }
            echo \html_writer::table($table);
        } else {
            $emptytenantstr = get_string('acp_tenants_none', 'local_o365');
            echo \html_writer::empty_tag('br');
            echo \html_writer::empty_tag('br');
            echo \html_writer::div($emptytenantstr, 'alert alert-error');
        }

        $this->standard_footer();
    }

    /**
     * Description page shown before adding an additional tenant.
     */
    public function mode_tenantsadd() {
        $this->standard_header();
        echo \html_writer::tag('h2', get_string('acp_tenants_title', 'local_o365'));
        echo \html_writer::div(get_string('acp_tenants_title_desc', 'local_o365'));
        echo \html_writer::empty_tag('br');
        if ($this->checktenantsetup() !== true) {
            $errmsg = get_string('acp_tenants_errornotsetup', 'local_o365');
            echo \html_writer::div($errmsg, 'alert alert-info');
            $this->standard_footer();
            return;
        }
        echo \html_writer::div(get_string('acp_tenantsadd_desc', 'local_o365'));
        echo \html_writer::empty_tag('br');
        $addtenantstr = get_string('acp_tenantsadd_linktext', 'local_o365');
        $addtenanturl = new \moodle_url('/local/o365/acp.php', ['mode' => 'tenantsaddgo']);
        echo \html_writer::link($addtenanturl, $addtenantstr, ['class' => 'btn btn-primary']);

        $this->standard_footer();
    }

    /**
     * Revoke access to a specific tenant.
     */
    public function mode_tenantsrevoke() {
        require_sesskey();
        $tenant = required_param('t', PARAM_TEXT);
        $tenant = (string)base64_decode($tenant);
        \local_o365\utils::disableadditionaltenant($tenant);
        redirect(new \moodle_url('/local/o365/acp.php?mode=tenants'));
    }

    /**
     * Perform auth request for tenant addition.
     */
    public function mode_tenantsaddgo() {
        $auth = new \auth_oidc\loginflow\authcode;
        $auth->set_httpclient(new \auth_oidc\httpclient());
        $stateparams = [
            'redirect' => '/local/o365/acp.php?mode=tenantsadd',
            'justauth' => true,
            'forceflow' => 'authcode',
            'action' => 'addtenant',
            'ignorerestrictions' => true,
        ];
        $extraparams = ['prompt' => 'admin_consent'];
        $auth->initiateauthrequest(true, $stateparams, $extraparams);
    }

    /**
     * Perform health checks.
     */
    public function mode_healthcheck() {
        $this->standard_header();

        echo \html_writer::tag('h2', get_string('acp_healthcheck', 'local_o365'));
        echo '<br />';

        $enableapponlyaccess = get_config('local_o365', 'enableapponlyaccess');
        if (empty($enableapponlyaccess)) {
            $healthchecks = ['systemapiuser', 'ratelimit'];
        } else {
            $healthchecks = ['ratelimit'];
        }
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
     * Endpoint to change Teams customization.
     */
    public function mode_usergroupcustom_change() {
        require_sesskey();

        // Save enabled by default on new course settings.
        $enabledfornewcourse = required_param('newcourse', PARAM_BOOL);
        set_config('sync_new_course', $enabledfornewcourse, 'local_o365');

        // Save course settings.
        $coursedata = json_decode(required_param('coursedata', PARAM_RAW), true);
        foreach ($coursedata as $courseid => $course) {
            if (!is_scalar($courseid) || ((string)$courseid !== (string)(int)$courseid)) {
                // Non-intlike courseid value. Invalid. Skip.
                continue;
            }
            foreach ($course as $feature => $value) {
                // Value must be boolean - existing set_* functions below already treat non-true as false, so let's be clear.
                if (!is_bool($value)) {
                    $value = false;
                }
                if ($feature === 'enabled') {
                    \local_o365\feature\usergroups\utils::set_course_group_enabled($courseid, $value);
                } else if (in_array($feature, ['team'])) {
                    \local_o365\feature\usergroups\utils::set_course_group_feature_enabled($courseid, [$feature], $value);
                }
            }
        }
        echo json_encode(['Saved']);
    }

    /**
     * Endpoint to change Teams customization.
     */
    public function mode_usergroupcustom_bulkchange() {
        $enabled = (bool)required_param('state', PARAM_BOOL);
        $feature = (string)optional_param('feature', 'enabled', PARAM_ALPHA);
        require_sesskey();
        \local_o365\feature\usergroups\utils::bulk_set_group_feature_enabled($feature, $enabled);
        echo json_encode(['Saved']);
    }

    /**
     * Enable / disable all sync features on all course when using custom settings.
     */
    public function mode_usergroupcustom_allchange() {
        global $DB;

        $enabled = (bool)required_param('state', PARAM_BOOL);
        require_sesskey();

        $courses = $DB->get_records('course');
        foreach ($courses as $course) {
            if ($course->id == SITEID) {
                continue;
            }
            \local_o365\feature\usergroups\utils::set_course_group_enabled($course->id, $enabled);
        }
    }

    /**
     * Teams customization.
     */
    public function mode_usergroupcustom() {
        global $CFG, $OUTPUT, $PAGE;

        $PAGE->navbar->add(get_string('acp_usergroupcustom', 'local_o365'), new \moodle_url($this->url, ['mode' => 'usergroupcustom']));

        $totalcount = 0;
        $perpage = 20;

        $curpage = optional_param('page', 0, PARAM_INT);
        $sort = optional_param('sort', '', PARAM_ALPHA);
        $search = optional_param('search', '', PARAM_TEXT);
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
        $table->head[] = get_string('groups_team', 'local_o365');

        $limitfrom = $curpage * $perpage;
        $coursesid = [];

        if (empty($search)) {
            $sortdir = 1;
            if ($sortdir == 'desc') {
                $sortdir = -1;
            }
            $options = [
                'recursive' => true,
                'sort' => [$sort => $sortdir],
                'offset' => $limitfrom,
                'limit' => $perpage,
            ];
            $topcat = \core_course_category::get(0);
            $courses = $topcat->get_courses($options);
            $totalcount = $topcat->get_courses_count($options);
        } else {
            $searchar = explode(' ', $search);
            $courses = get_courses_search($searchar, 'c.'.$sort.' '.$sortdir, $curpage, $perpage, $totalcount);
        }

        foreach ($courses as $course) {
            if ($course->id == SITEID) {
                continue;
            }
            $coursesid[] = $course->id;
            $isenabled = \local_o365\feature\usergroups\utils::course_is_group_enabled($course->id);
            $enabledname = 'course_'.$course->id.'_enabled';
            $teamenabled = \local_o365\feature\usergroups\utils::course_is_group_feature_enabled($course->id, 'team');
            $teamname = 'course_team_' . $course->id . '_enabled';

            $enablecheckboxattrs = [
                'onchange' => 'local_o365_set_usergroup(\''.$course->id.'\', $(this).prop(\'checked\'), $(this))'
            ];
            $teamcheckboxattrs = [
                'class' => 'feature feature_teams',
            ];

            if ($isenabled !== true) {
                $teamcheckboxattrs['disabled'] = '';
            }

            $rowdata = [
                $course->shortname,
                $course->fullname,
                \html_writer::checkbox($enabledname, 1, $isenabled, '', $enablecheckboxattrs),
                \html_writer::checkbox($teamname, 1, $teamenabled, '', $teamcheckboxattrs),
            ];
            $table->data[] = $rowdata;
        }

        $PAGE->requires->jquery();
        $this->standard_header();

        $endpoint = new \moodle_url('/local/o365/acp.php', ['mode' => 'usergroupcustom_change', 'sesskey' => sesskey()]);
        $bulkendpoint = new \moodle_url('/local/o365/acp.php', ['mode' => 'usergroupcustom_bulkchange', 'sesskey' => sesskey()]);
        $custompageurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'usergroupcustom']);
        $allchangeendpoint = new \moodle_url('/local/o365/acp.php',
            ['mode' => 'usergroupcustom_allchange', 'sesskey' => sesskey()]);

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
        $js .= 'var local_o365_usergroup_features = ["team"]; ';

        $js .= 'var local_o365_usergroup_all_set_feature = function(state) {';
        $js .= 'var enabled = (state == 1) ? true : false; ';
        $js .= ' // Send data to server. ' . "\n";
        $js .= '$.ajax({
            url: \'' . $allchangeendpoint->out(false) . '\',
            data: {state: enabled},
            type: "POST",
            success: function(data) {
                console.log(data);
                window.location.href = "' . $custompageurl->out(false) . '";
            }
        });' . "\n";
        $js .= '}; ' . "\n";

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
            data: {
                coursedata: JSON.stringify(coursedata),
                newcourse: $("input#id_s_local_o365_sync_new_course").prop("checked"),
            },
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

        // Option to enable all sync features on all pages.
        echo \html_writer::tag('button', get_string('acp_usrgroupcustom_enable_all', 'local_o365'),
            ['onclick' => 'local_o365_usergroup_all_set_feature(1)']);

        // Option to enable sync by default for new courses.
        require_once($CFG->libdir . '/adminlib.php');
        $enablefornewcourse = new \admin_setting_configcheckbox('local_o365/sync_new_course',
            get_string('acp_usergroupcustom_new_course', 'local_o365'),
            get_string('acp_usergroupcustom_new_course_desc', 'local_o365'), '0');
        echo $enablefornewcourse->output_html(get_config('local_o365', 'sync_new_course'));

        // Option to enable all sync features on all pages.
        echo \html_writer::tag('button', get_string('acp_usrgroupcustom_enable_all', 'local_o365'),
            ['onclick' => 'local_o365_usergroup_all_set_feature(1)']);

        // Bulk Operations
        $strbulkenable = get_string('acp_usergroupcustom_bulk_enable', 'local_o365');
        $strbulkdisable = get_string('acp_usergroupcustom_bulk_disable', 'local_o365');

        echo \html_writer::tag('h5', get_string('acp_usergroupcustom_bulk', 'local_o365'));
        echo \html_writer::tag('h6', get_string('acp_usergroupcustom_bulk_help', 'local_o365'));

        echo \html_writer::start_tag('div', ['style' => 'display: inline-block;margin: 0 1rem']);
        echo \html_writer::tag('span', get_string('groups_team', 'local_o365').': ');
        echo \html_writer::tag('button', $strbulkenable, ['onclick' => 'local_o365_usergroup_bulk_set_feature(\'teams\', 1)']);
        echo \html_writer::tag('button', $strbulkdisable, ['onclick' => 'local_o365_usergroup_bulk_set_feature(\'teams\', 0)']);
        echo \html_writer::end_tag('div');

        // Search form.
        echo \html_writer::tag('h5', get_string('search'));
        echo \html_writer::start_tag('form', ['id' => 'coursesearchform', 'method' => 'get']);
        echo \html_writer::start_tag('fieldset', ['class' => 'coursesearchbox invisiblefieldset']);
        echo \html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'mode', 'value' => 'usergroupcustom']);
        echo \html_writer::empty_tag('input', ['type' => 'text', 'id' => 'coursesearchbox', 'size' => 30, 'name' => 'search',
            'value' => s($search)]);
        echo \html_writer::empty_tag('input', ['type' => 'submit', 'value' => get_string('go')]);
        echo \html_writer::div(\html_writer::tag('strong', get_string('acp_usergroupcustom_searchwarning', 'local_o365')));
        echo \html_writer::end_tag('fieldset');
        echo \html_writer::end_tag('form');
        echo \html_writer::empty_tag('br');

        echo \html_writer::tag('h5', get_string('courses'));
        echo \html_writer::table($table);
        echo \html_writer::tag('p', get_string('acp_usergroupcustom_savemessage', 'local_o365'),
            ['id' => 'acp_usergroupcustom_savemessage', 'style' => 'display: none; font-weight: bold; color: red']);
        echo  \html_writer::tag('button', get_string('savechanges'),
            ['class'=>'buttonsbar', 'onclick' => 'local_o365_usergroup_save()']);

        $searchtext = optional_param('search', '', PARAM_TEXT);
        $cururl = new \moodle_url('/local/o365/acp.php', ['mode' => 'usergroupcustom', 'search' => $searchtext]);
        echo $OUTPUT->paging_bar($totalcount, $curpage, $perpage, $cururl);
        $this->standard_footer();
    }

    /**
     * Resync deleted Microsoft 365 groups for courses and Moodle groups.
     */
    public function mode_maintenance_coursegroupscheck() {
        global $DB;
        $httpclient = new \local_o365\httpclient();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $graphresource = \local_o365\rest\unified::get_resource();
        $graphtoken = \local_o365\utils::get_app_or_system_token($graphresource, $clientdata, $httpclient);
        if (empty($graphtoken)) {
            mtrace('Could not get Microsoft Graph API token.');
            return true;
        }
        $graphclient = new \local_o365\rest\unified($graphtoken, $httpclient);
        $coursegroups = new \local_o365\feature\usergroups\coursegroups($graphclient, $DB, true);
        $coursesenabled = \local_o365\feature\usergroups\utils::get_enabled_courses();
        $groupids = $coursegroups->get_all_group_ids();

        $objects = $DB->get_recordset_sql("SELECT *
                                             FROM {local_o365_objects}
                                            WHERE type = 'group' AND
                                                  subtype IN ('usergroup', 'course')");
        echo "<pre>";
        foreach ($objects as $object) {
            if (!in_array($object->objectid, $groupids)) {
                if ($object->subtype == 'usergroup') {
                    $moodleobject = $DB->get_record('groups', ['id' => $object->moodleid]);
                    if (is_array($coursesenabled) && !in_array($moodleobject->courseid, $coursesenabled)) {
                        echo "Course not enabled 4\n";
                        continue;
                    }
                    if (empty($coursesenabled)) {
                        echo "Course not enabled 3\n";
                        continue;
                    }
                    $DB->delete_records('local_o365_objects', ['id' => $object->id]);
                    if (!empty($moodleobject)) {
                        echo "Creating object for Moodle group: {$moodleobject->name}\n";
                        try {
                            $coursegroups->create_study_group($moodleobject->id);
                        } catch (\Exception $e) {
                            $this->mtrace('Could not create group for Moodle group #'.$moodleobject->id.'. Reason: '.$e->getMessage());
                            continue;
                        }
                    } else {
                        echo "Cleaning up object for Moodle group {$object->moodleid} Microsoft 365 object id {$object->objectid}\n";
                    }
                } else {
                    if (is_array($coursesenabled) && !in_array($object->moodleid, $coursesenabled)) {
                        echo "Course not enabled 1\n";
                        continue;
                    }
                    if (empty($coursesenabled)) {
                        echo "Course not enabled 2\n";
                        continue;
                    }
                    $course = $DB->get_record('course', ['id' => $object->moodleid]);
                    $DB->delete_records('local_o365_objects', ['id' => $object->id]);
                    if (!empty($course)) {
                        try {
                            $objectrec = $coursegroups->create_group($course);
                            echo "Created object for Moodle course: {$course->fullname}\n";
                        } catch (\Exception $e) {
                            $this->mtrace('Could not create group for course #'.$course->id.'. Reason: '.$e->getMessage());
                            continue;
                        }

                        try {
                            $coursegroups->resync_group_membership($course->id, $objectrec['objectid'], []);
                        } catch (\Exception $e) {
                            $this->mtrace('Could not sync users to group for course #'.$course->id.'. Reason: '.$e->getMessage());
                            continue;
                        }
                    } else {
                        echo "Cleaning up object for Moodle course {$object->moodleid} Microsoft 365 object id {$object->objectid}\n";
                    }
                }
            } else {
                echo "Group for course {$object->moodleid} still exists. Object id: {$object->objectid} \n";
            }
        }
        echo "Check completed.";
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
        $graphtoken = \local_o365\utils::get_app_or_system_token($graphresource, $clientdata, $httpclient);
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

    public function mode_maintenance_debugdata() {
        global $CFG;

        if (!empty($CFG->local_o365_disabledebugdata)) {
            return false;
        }

        $pluginmanager = \core_plugin_manager::instance();

        $plugins = [
            'auth_oidc' => [
                'authendpoint',
                'tokenendpoint',
                'oidcresource',
                'autoappend',
                'domainhint',
                'loginflow',
                'debugmode',
            ],
            'block_microsoft' => [
                'showo365download',
                'settings_showonenotenotebook',
                'settings_showoutlooksync',
                'settings_showpreferences',
                'settings_showo365connect',
                'settings_showmanageo365conection',
                'settings_showcoursespsite',
            ],
            'filter_oembed' => [
                'o365video',
                'officemix',
                'sway',
                'provider_docsdotcom_enabled',
            ],
            'local_microsoftservices' => [],
            'local_msaccount' => [],
            'local_o365' => [
                'aadsync',
                'aadtenant',
                'azuresetupresult',
                'chineseapi',
                'createteams',
                'debugmode',
                'enableunifiedapi',
                'disablegraphapi',
                'fieldmap',
                'odburl',
                'photoexpire',
                'usersynccreationrestriction',
                'sharepoint_initialized',
                'task_usersync_lastskiptoken',
                'unifiedapiactive',
            ],
            'local_office365' => [],
            'local_onenote' => [],
            'assignsubmission_onenote' => [],
            'assignfeedback_onenote' => [],
            'repository_office365' => [],
            'repository_onenote' => [],
        ];

        $configdata = [];

        $configdata['moodlecfg'] = [
            'dbtype' => $CFG->dbtype,
            'debug' => $CFG->debug,
            'debugdisplay' => $CFG->debugdisplay,
            'debugdeveloper' => $CFG->debugdeveloper,
            'auth' => $CFG->auth,
            'timezone' => $CFG->timezone,
            'forcetimezone' => $CFG->forcetimezone,
            'authpreventaccountcreation' => $CFG->authpreventaccountcreation,
            'alternateloginurl' => $CFG->alternateloginurl,
            'release' => $CFG->release,
            'version' => $CFG->version,
            'localo365forcelegacyapi' => (isset($CFG->local_o365_forcelegacyapi)) ? 1 : 0,
        ];

        $configdata['plugin_data'] = [];
        foreach ($plugins as $plugin => $settings) {
            $plugintype = substr($plugin, 0, strpos($plugin, '_'));
            $pluginsubtype = substr($plugin, strpos($plugin, '_') + 1);

            $plugindata = [];
            $plugincfg = get_config($plugin);

            $plugindata['version'] = (isset($plugincfg->version)) ? $plugincfg->version : 'null';

            $enabled = $pluginmanager->get_enabled_plugins($plugintype);
            $plugindata['enabled'] = (isset($enabled[$pluginsubtype])) ? 1 : 0;

            foreach ($settings as $setting) {
                $plugindata[$setting] = (isset($plugincfg->$setting)) ? $plugincfg->$setting : null;
            }

            $configdata['plugin_data'][$plugin] = $plugindata;
        }

        echo json_encode($configdata);
    }

    /**
     * Endpoint to sync sharepoint subsite UI display with existing shareoint subsites.
     */
    public function mode_sharepointcourseenabled_sync() {
        require_sesskey();
        $syncupgrade = new \stdClass();
        // Attempt to sync up display values with actual sharepoint subsites.
        try {
            $syncupgrade = \local_o365\feature\sharepointcustom\utils::update_enabled_subsites_json();
        } catch (\Exception $e) {
            mtrace('Error: '.$e->getMessage());
        }

        $returnurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'sharepointcourseselect']);
        if (!empty($syncupgrade) && $syncupgrade !== false) {
            // Toggle synced boolean.
            $setconf = set_config('spcustomsynced', true, 'local_o365');
            // Reload page to same settings page.
            redirect($returnurl);
        } else {
            // Stays false.
            $setconf = set_config('spcustomsynced', false, 'local_o365');
            // Reload page to same settings page.
            redirect($returnurl);
        }
    }

    /**
     * Endpoint to change sharepoint subsite customization.
     */
    public function mode_sharepointcourseenabled_change() {
        $courseid = (int)required_param('courseid', PARAM_INT);
        $enabled = (bool)required_param('state', PARAM_BOOL);
        require_sesskey();

        // Update the enabled JSON set in plugin config.
        $saved = \local_o365\feature\sharepointcustom\utils::set_course_subsite_enabled($courseid, $enabled);

        echo json_encode([$courseid, $enabled, 'Saved', $saved]);
    }

    /**
     * Bulk endpoint to change sharepoint subsite enabled.
     */
    public function mode_sharepointcustom_bulkchange() {
        $coursedata = json_decode(required_param('coursedata', PARAM_RAW), true);
        require_sesskey();

        $result = [];
        foreach ($coursedata as $key => $value) {
            $saved = \local_o365\feature\sharepointcustom\utils::set_course_subsite_enabled($key, $value);
            $result[] = $saved;
        }

        echo 'Saved. '. json_encode($result);
    }

    /**
     * SharePoint course resource customization.
     */
    public function mode_sharepointcourseselect() {
        global $OUTPUT, $PAGE, $DB, $CFG;

        // If custom setting is not enabled, redirect back to the settings page.
        $selectisenabled = get_config('local_o365', 'sharepointcourseselect');
        if ($selectisenabled !== 'oncustom') {
            $linkattrs = ['section' => 'local_o365', 's_local_o365_tabs' => '1'];
            $actionurl = new \moodle_url('/admin/settings.php', $linkattrs);
            redirect($actionurl);
        }

        require_once($CFG->libdir.'/coursecatlib.php');
        require_once ($CFG->libdir.'/formslib.php');
        $spcustomsynced = get_config('local_o365', 'spcustomsynced');
        $spcustomsynced = $spcustomsynced ? $spcustomsynced : false;

        $PAGE->navbar->add(get_string('acp_sharepointcourseselect', 'local_o365'), new \moodle_url($this->url, ['mode' => 'sharepointcourseselect']));

        $totalcount = 0;
        $perpage = 20;

        $curpage = optional_param('page', 0, PARAM_INT);
        $sort = optional_param('sort', '', PARAM_ALPHA);
        $search = optional_param('search', '', PARAM_TEXT);
        $sortdir = strtolower(optional_param('sortdir', 'asc', PARAM_ALPHA));

        $headers = [
            'shortname' => get_string('shortnamecourse'),
            'fullname' => get_string('fullnamecourse'),
            'category' => get_string('category'),
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
            $linkattrs = ['mode' => 'sharepointcourseselect', 'sort' => $hkey, 'sortdir' => $diffsortdir];
            $link = new \moodle_url('/local/o365/acp.php', $linkattrs);

            if ($sort === $hkey) {
                $desc .= ' '.$OUTPUT->pix_icon('t/'.'sort_'.$sortdir, 'sort');
            }
            $table->head[] = \html_writer::link($link, $desc);
        }
        $table->head[] = get_string('acp_sharepointcourseselectlabel_enabled', 'local_o365');

        $limitfrom = $curpage * $perpage;
        if (empty($search)) {
            $sortdir = 1;
            if ($sortdir == 'desc') {
                $sortdir = -1;
            }
            $options = [
                'recursive' => true,
                'sort' => [$sort => $sortdir],
                'offset' => $limitfrom,
                'limit' => $perpage,
            ];
            $topcat = \core_course_category::get(0);
            $courses = $topcat->get_courses($options);
            $totalcount = $topcat->get_courses_count($options);
        } else {
            $searchar = explode(' ', $search);
            $courses = get_courses_search($searchar, 'c.'.$sort.' '.$sortdir, $curpage, $perpage, $totalcount);
        }
        $coursesid = [];
        $categories = array();
        foreach ($courses as $course) {
            if ($course->id == SITEID) {
                continue;
            }
            $coursesid[] = $course->id;
            $isenabled = \local_o365\feature\sharepointcustom\utils::course_is_sharepoint_enabled($course->id);
            $enabledname = 'course_'.$course->id.'_enabled';

            $enablecheckboxattrs = [
                'onchange' => '$(this).toggleClass(\'changed\');'
            ];

            $category = $DB->get_record('course_categories',array('id'=>$course->category));
            $name = $category->name;
            array_push($categories, $name);

            $rowdata = [
                $course->shortname,
                $course->fullname,
                '<span class="category-'.$category->id.'">'.$category->name.'</span>',
                \html_writer::checkbox($enabledname, 1, $isenabled, '', $enablecheckboxattrs),
            ];
            $table->data[] = $rowdata;
        }

        $PAGE->requires->jquery();
        $this->standard_header();

        // Endpoint for checkbox toggle.
        $endpoint = new \moodle_url('/local/o365/acp.php', ['mode' => 'sharepointcourseenabled_change', 'sesskey' => sesskey()]);
        // Bulk save endpoint.
        $bulkendpoint = new \moodle_url('/local/o365/acp.php', ['mode' => 'sharepointcustom_bulkchange', 'sesskey' => sesskey()]);
        // End point for sync courses.
        $syncendpoint = new \moodle_url('/local/o365/acp.php', ['mode' => 'sharepointcourseenabled_sync', 'sesskey' => sesskey()]);
        // Build JS script content.
        $js = 'var local_o365_set_sharepoint_enabled = function(courseid, state, checkbox) { ';
        $js .= 'data = {courseid: courseid, state: state}; ';
        $js .= '$.post(\''.$endpoint->out(false).'\', data, function(data) { console.log(data); }); ';
        $js .= 'var newfeaturedisabled = (state == 0) ? true : false; ';
        $js .= 'var newfeaturechecked = (state == 1) ? true : false; ';
        $js .= 'var featurecheckboxes = checkbox.parents("tr").find("input.feature"); ';
        $js .= 'featurecheckboxes.prop("disabled", newfeaturedisabled); ';
        $js .= 'featurecheckboxes.prop("checked", newfeaturechecked); ';
        $js .= 'console.log("local_o365_set_sharepoint_enabled"); ';
        $js .= '};';
        // Bulk save changes.
        $js .= 'var local_o365_sharepointcustom_save = function() { '."\n";
        $js .= 'var local_o365_spcourseschanged = $(\'table input.changed\');'."\n";
        $js .= 'if (local_o365_spcourseschanged.length >= 1) {'."\n";
        $js .= ' // Build data to send. '."\n";
        $js .= 'var $coursedata = {}; '."\n";
        $js .= 'for (var i = 0; i < local_o365_spcourseschanged.length; i++) {'."\n";
        $js .= 'var $courseid = $(local_o365_spcourseschanged[i]).attr(\'name\'); '."\n";
        $js .= '$courseid = $courseid.replace(/course|enabled|_/gi, \'\'); '."\n";
        $js .= 'var $enabled = $(local_o365_spcourseschanged[i]).prop(\'checked\'); '."\n";
        $js .= '$coursedata[$courseid] = $enabled; '."\n";
        $js .= '}; '."\n";
        $js .= 'data = JSON.stringify($coursedata); '."\n";
        $js .= ' // Send data to server. '."\n";
        $js .= '$.ajax({
            url: \''.$bulkendpoint->out(false).'\',
            data: {coursedata: JSON.stringify($coursedata)},
            type: "POST",
            success: function(data) {
                console.log(\'Success: \'+data);
                $(\'#acp_sharepointcustom_savemessage\').show();
                setTimeout(function () { $(\'#acp_sharepointcustom_savemessage\').hide(); }, 5000);
                $(local_o365_spcourseschanged).each( function() { $(this).toggleClass(\'changed\'); } );
            }
        }); '."\n";
        // $js .= '$.post(\''.$bulkendpoint->out(false).'\', data, function(data) { console.log(data); }); ';
        $js .= '} '."\n";
        $js .= '}; '."\n";
        echo \html_writer::script($js);

        // Print functionality heading.
        echo \html_writer::tag('h2', get_string('acp_sharepointcourseselect', 'local_o365'));
        // If we haven't updated by syncing data from sharepoint, and there are courses, give the option to do that.
        if (!$spcustomsynced && (count($courses) > 1)) {
            $linkattrs = ['mode' => 'sharepointcourseenabled_sync'];
            $link = new \moodle_url('/local/o365/acp.php', $linkattrs);
            echo \html_writer::tag('h5', get_string('acp_sharepointcourseselect_syncopt', 'local_o365'));
            echo \html_writer::tag('p', get_string('acp_sharepointcourseselect_syncopt_inst', 'local_o365'));
            echo \html_writer::empty_tag('img', ['src' => $OUTPUT->pix_url('spinner', 'local_o365'), 'alt' => 'In process...', 'class' => 'local_o365_spinner']);
            echo $OUTPUT->single_button($syncendpoint, get_string('acp_sharepointcourseselect_syncopt_btn', 'local_o365'), 'get');
            $js = '$(\'div.singlebutton :submit\').click(function() { $(\'img.local_o365_spinner\').show(); });';
            echo \html_writer::script($js);
        }
        // Search form.
        echo \html_writer::tag('h5', get_string('search'));
        echo \html_writer::start_tag('form', ['id' => 'coursesearchform', 'method' => 'get']);
        echo \html_writer::start_tag('fieldset', ['class' => 'coursesearchbox invisiblefieldset']);
        echo \html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'mode', 'value' => 'sharepointcourseselect']);
        echo \html_writer::empty_tag('input', ['type' => 'text', 'id' => 'coursesearchbox', 'size' => 30, 'name' => 'search', 'value' => s($search)]);
        echo \html_writer::empty_tag('input', ['type' => 'submit', 'value' => get_string('go')]);
        echo \html_writer::div(\html_writer::tag('strong', get_string('acp_sharepointcourseselect_searchwarning', 'local_o365')));
        echo \html_writer::end_tag('fieldset');
        echo \html_writer::end_tag('form');
        echo \html_writer::empty_tag('br');

        // Write instrutions for selecting courses.
        echo \html_writer::tag('h5', get_string('acp_sharepointcourseselect_instr_header', 'local_o365'));
        echo \html_writer::tag('p', get_string('acp_sharepointcourseselect_instr', 'local_o365'));
        // Begin courses table.
        echo \html_writer::tag('h5', get_string('courses'));
        echo \html_writer::table($table);
       // URL and paging elements.
        $cururl = new \moodle_url('/local/o365/acp.php', ['mode' => 'sharepointcourseselect']);
        echo $OUTPUT->paging_bar($totalcount, $curpage, $perpage, $cururl);
         // Notification box to confirm bulk save.
        echo \html_writer::start_tag('div', ['class' => 'alert alert-success alert-block fade in', 'id' => 'acp_sharepointcustom_savemessage', 'style' => 'display: none;', 'role' => 'alert']);
        echo \html_writer::tag('button', '×', ['class'=>'close', 'data-dismiss' => 'alert', 'type' => 'button']);
        echo get_string('acp_sharepointcustom_savemessage', 'local_o365');
        echo \html_writer::end_tag('div');
        // Bulk save button.
        echo  \html_writer::tag('button', get_string('savechanges'), ['class'=>'buttonsbar', 'onclick' => 'local_o365_sharepointcustom_save()']);

        $this->standard_footer();
    }

    /**
     * Maintenance tools.
     */
    public function mode_maintenance() {
        global $DB, $OUTPUT, $PAGE, $SESSION, $CFG;
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

        $toolurl = new \moodle_url($this->url, ['mode' => 'maintenance_coursegroupscheck']);
        $toolname = get_string('acp_maintenance_coursegroupscheck', 'local_o365');
        echo \html_writer::empty_tag('br');
        echo \html_writer::link($toolurl, $toolname, ['target' => '_blank']);
        echo \html_writer::div(get_string('acp_maintenance_coursegroupscheck_desc', 'local_o365'));

        if (empty($CFG->local_o365_disabledebugdata)) {
            $toolurl = new \moodle_url($this->url, ['mode' => 'maintenance_debugdata']);
            $toolname = get_string('acp_maintenance_debugdata', 'local_o365');
            echo \html_writer::empty_tag('br');
            echo \html_writer::link($toolurl, $toolname);
            echo \html_writer::div(get_string('acp_maintenance_debugdata_desc', 'local_o365'));
        }

        $toolurl = new \moodle_url($this->url, ['mode' => 'maintenance_cleanoidctokens']);
        $toolname = get_string('acp_maintenance_cleanoidctokens', 'local_o365');
        echo \html_writer::empty_tag('br');
        echo \html_writer::link($toolurl, $toolname);
        echo \html_writer::div(get_string('acp_maintenance_cleanoidctokens_desc', 'local_o365'));

        // Clear delta token.
        $toolurl = new \moodle_url($this->url, ['mode' => 'maintenance_cleandeltatoken']);
        $toolname = get_string('acp_maintenance_cleandeltatoken', 'local_o365');
        echo \html_writer::empty_tag('br');
        echo \html_writer::link($toolurl, $toolname);
        echo \html_writer::div(get_string('acp_maintenance_cleandeltatoken_desc', 'local_o365'));

        $this->standard_footer();
    }

    /**
     * Clean up OpenID Connect tokens.
     */
    public function mode_maintenance_deleteoidctoken() {
        global $DB;
        $tokenid = required_param('id', PARAM_INT);
        require_sesskey();
        $DB->delete_records('auth_oidc_token', ['id' => $tokenid]);
        mtrace("Token deleted.");
    }

    /**
     * Clean up OpenID Connect tokens.
     */
    public function mode_maintenance_cleanoidctokens() {
        global $DB;
        $records = $DB->get_recordset('auth_oidc_token', ['userid' => 0]);
        foreach ($records as $token) {
            $toolurl = new \moodle_url($this->url, ['mode' => 'maintenance_deleteoidctoken', 'id' => $token->id, 'sesskey' => sesskey()]);
            $toolname = 'Delete Token';
            $str = $token->id.': Moodle user '.$token->username.' as a token for OIDC username '.$token->oidcusername.' but no recorded userid.';
            $deletelink = \html_writer::link($toolurl, $toolname);
            mtrace($str.' '.$deletelink);
        }

        $sql = 'SELECT tok.id AS id,
                       u.id AS muserid,
                       u.username AS musername,
                       u.auth,
                       u.deleted,
                       u.suspended,
                       tok.oidcuniqid,
                       tok.username AS tokusername,
                       tok.userid AS tokuserid,
                       tok.oidcusername
                  FROM {auth_oidc_token} tok
                  JOIN {user} u
                       ON u.id = tok.userid
                 WHERE tok.userid != 0 AND u.username != tok.username';
        $tokens = $DB->get_recordset_sql($sql);
        foreach ($tokens as $token) {
            mtrace($token->id.': Mismatch between usernames and userids. Userid "'.$token->tokuserid.'" references Moodle user "'.$token->musername.'" but token references "'.$token->tokusername.'"');
        }
    }

    /**
     * Clean up user sync delta token.
     */
    public function mode_maintenance_cleandeltatoken() {
        set_config('task_usersync_lastdeltatoken', '', 'local_o365');
        mtrace("Cleaned up last delta token.");

        set_config('task_usersync_lastskiptokendelta', '', 'local_o365');
        mtrace("Cleaned up last skip delta token.");
    }

    /**
     * User connection management.
     */
    public function mode_userconnections() {
        global $DB, $OUTPUT, $PAGE, $SESSION, $CFG;
        $url = new \moodle_url($this->url, ['mode' => 'userconnections']);
        $PAGE->navbar->add(get_string('acp_userconnections', 'local_o365'), $url);
        $PAGE->requires->jquery();
        $this->standard_header();

        $searchurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'userconnections']);
        $filterfields = [
            'o365username' => 0,
            'realname' => 0,
            'username' => 0,
            'idnumber' => 1,
            'firstname' => 1,
            'lastname' => 1,
            'email' => 1,
        ];
        $ufiltering = new \local_o365\feature\userconnections\filtering($filterfields, $searchurl);
        list($extrasql, $params) = $ufiltering->get_sql_filter();
        list($o365usernamesql, $o365usernameparams) = $ufiltering->get_filter_o365username();

        $ufiltering->display_add();
        $ufiltering->display_active();

        $table = new \local_o365\feature\userconnections\table('local_o365_userconnections');
        $table->define_baseurl($CFG->wwwroot.'/local/o365/acp.php?mode=userconnections');
        $table->set_where($extrasql, $params);
        $table->set_having($o365usernamesql, $o365usernameparams);
        $table->out(25, true);

        $this->standard_footer();
    }

    /**
     * Resync action from the userconnections tool.
     */
    public function mode_userconnections_resync() {
        global $DB;
        $userid = required_param('userid', PARAM_INT);
        confirm_sesskey();

        if (\local_o365\utils::is_configured() !== true) {
            mtrace('Microsoft 365 not configured');
            return false;
        }

        // Perform prechecks.
        $userrec = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);

        $params = ['type' => 'user', 'moodleid' => $userid];
        $objectrecord = $DB->get_record('local_o365_objects', $params);
        if (empty($objectrecord) || empty($objectrecord->objectid)) {
            throw new \moodle_exception('acp_userconnections_resync_nodata', 'local_o365');
        }

        // Get aad data.
        $usersync = new \local_o365\feature\usersync\main();
        $userdata = $usersync->get_user($objectrecord->objectid);
        echo '<pre>';
        $usersync->sync_users($userdata);
        echo '</pre>';
    }

    /**
     * Manual match action from the userconnections tool.
     */
    public function mode_userconnections_manualmatch() {
        global $DB;
        $userid = required_param('userid', PARAM_INT);
        confirm_sesskey();

        // Perform prechecks.
        $userrec = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);

        // Check whether Moodle user is already o365 connected.
        if (\local_o365\utils::is_o365_connected($userid)) {
            throw new \moodle_exception('acp_userconnections_manualmatch_error_muserconnected', 'local_o365');
        }

        // Check existing matches for Moodle user.
        $existingmatchforuser = $DB->get_record('local_o365_connections', ['muserid' => $userid]);
        if (!empty($existingmatchforuser)) {
            throw new \moodle_exception('acp_userconnections_manualmatch_error_musermatched', 'local_o365');
        }

        $urlparams = ['mode' => 'userconnections_manualmatch', 'userid' => $userid];
        $redirect = new \moodle_url('/local/o365/acp.php', $urlparams);
        $customdata = ['userid' => $userid];
        $mform = new \local_o365\form\manualusermatch($redirect, $customdata);
        if ($fromform = $mform->get_data()) {
            $o365username = trim($fromform->o365username);

            // Check existing matches for Microsoft user.
            $existingmatchforo365user = $DB->get_record('local_o365_connections', ['aadupn' => $o365username]);
            if (!empty($existingmatchforo365user)) {
                throw new \moodle_exception('acp_userconnections_manualmatch_error_o365usermatched', 'local_o365');
            }

            // Check existing tokens for Microsoft 365 user (indicates o365 user is already connected to someone).
            $existingtokenforo365user = $DB->get_record('auth_oidc_token', ['oidcusername' => $o365username]);
            if (!empty($existingtokenforo365user)) {
                throw new \moodle_exception('acp_userconnections_manualmatch_error_o365userconnected', 'local_o365');
            }

            // Check if a o365 user object record already exists.
            $params = [
                'moodleid' => $userid,
                'type' => 'user',
            ];
            $existingobject = $DB->get_record('local_o365_objects', $params);
            if (!empty($existingobject) && $existingobject->o365name === $o365username) {
                throw new \moodle_exception('acp_userconnections_manualmatch_error_muserconnected2', 'local_o365');
            }

            $uselogin = (!empty($fromform->uselogin)) ? 1 : 0;
            $matchrec = (object)[
                'muserid' => $userid,
                'aadupn' => $o365username,
                'uselogin' => $uselogin,
            ];
            $DB->insert_record('local_o365_connections', $matchrec);
            redirect(new \moodle_url('/local/o365/acp.php', ['mode' => 'userconnections']));
            die();
        }

        global $OUTPUT, $PAGE, $SESSION, $CFG;
        $url = new \moodle_url($this->url, ['mode' => 'userconnections']);
        $PAGE->navbar->add(get_string('acp_userconnections', 'local_o365'), $url);
        $PAGE->requires->jquery();
        $this->standard_header();
        $mform->display();
        $this->standard_footer();
    }

    /**
     * Unmatch action from the userconnections tool.
     */
    public function mode_userconnections_unmatch() {
        global $DB;
        $userid = required_param('userid', PARAM_INT);
        confirm_sesskey();
        $user = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);
        $confirmed = optional_param('confirmed', 0, PARAM_INT);
        if (!empty($confirmed)) {
            $DB->delete_records('local_o365_connections', ['muserid' => $userid]);
            redirect(new \moodle_url('/local/o365/acp.php', ['mode' => 'userconnections']));
            die();
        } else {
            global $DB, $OUTPUT, $PAGE, $SESSION, $CFG;
            $url = new \moodle_url($this->url, ['mode' => 'userconnections']);
            $PAGE->navbar->add(get_string('acp_userconnections', 'local_o365'), $url);
            $PAGE->requires->jquery();
            $this->standard_header();
            $message = get_string('acp_userconnections_table_unmatch_confirmmsg', 'local_o365', $user->username);
            $message .= '<br /><br />';
            $urlparams = [
                'mode' => 'userconnections_unmatch',
                'userid' => $userid,
                'confirmed' => 1,
                'sesskey' => sesskey(),
            ];
            $url = new \moodle_url('/local/o365/acp.php', $urlparams);
            $label = get_string('acp_userconnections_table_unmatch', 'local_o365');
            $message .= \html_writer::link($url, $label);
            echo \html_writer::tag('div', $message, ['class' => 'alert alert-info', 'style' => 'text-align:center']);
            $this->standard_footer();
        }
    }

    /**
     * Disconnect action from the userconnections tool.
     */
    public function mode_userconnections_disconnect() {
        global $CFG, $DB;
        require_once($CFG->dirroot.'/auth/oidc/auth.php');
        $userid = required_param('userid', PARAM_INT);
        confirm_sesskey();
        $user = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);
        $confirmed = optional_param('confirmed', 0, PARAM_INT);
        if (!empty($confirmed)) {
            $auth = new \auth_plugin_oidc;
            $auth->set_httpclient(new \auth_oidc\httpclient());
            $redirect = new \moodle_url('/local/o365/acp.php', ['mode' => 'userconnections']);
            $selfurlparams = ['mode' => 'userconnections_disconnect', 'userid' => $userid, 'confirmed' => 1];
            $selfurl = new \moodle_url('/local/o365/acp.php', $selfurlparams);
            $justtokens = ($user->auth == 'oidc') ? false : true;
            $auth->disconnect($justtokens, false, $redirect, $selfurl, $userid);
            die();
        } else {
            global $DB, $OUTPUT, $PAGE, $SESSION, $CFG;
            $url = new \moodle_url($this->url, ['mode' => 'userconnections']);
            $PAGE->navbar->add(get_string('acp_userconnections', 'local_o365'), $url);
            $PAGE->requires->jquery();
            $this->standard_header();
            $message = get_string('acp_userconnections_table_disconnect_confirmmsg', 'local_o365', $user->username);
            $message .= '<br /><br />';
            $urlparams = [
                'mode' => 'userconnections_disconnect',
                'userid' => $userid,
                'confirmed' => 1,
                'sesskey' => sesskey(),
            ];
            $url = new \moodle_url('/local/o365/acp.php', $urlparams);
            $label = get_string('acp_userconnections_table_disconnect', 'local_o365');
            $message .= \html_writer::link($url, $label);
            echo \html_writer::tag('div', $message, ['class' => 'alert alert-info', 'style' => 'text-align:center']);
            $this->standard_footer();
        }
    }
}
