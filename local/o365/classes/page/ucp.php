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
 * User control panel page.
 */
class ucp extends base {
    /** @var bool Whether the user is using o365 login. */
    protected $o365loginconnected = false;

    /** @var bool Whether the user is connected to o365 or not (has an active token). */
    protected $o365connected = false;

    /**
     * Run before the main page mode - determines connection status.
     *
     * @return bool Success/Failure.
     */
    public function header() {
        global $USER, $DB;
        $this->o365loginconnected = ($USER->auth === 'oidc') ? true : false;
        $this->o365connected = \local_o365\utils::is_o365_connected($USER->id);
        return true;
    }

    /**
     * Manage calendar syncing.
     */
    public function mode_onenote() {
        global $OUTPUT;
        $mform = new \local_o365\form\onenote('?action=onenote');
        if ($mform->is_cancelled()) {
            redirect(new \moodle_url('/local/o365/ucp.php'));
        } else if ($fromform = $mform->get_data()) {
            $disableo365onenote = (!empty($fromform->disableo365onenote)) ? 1 : 0;
            set_user_preference('local_o365_disableo365onenote', $disableo365onenote);
            redirect(new \moodle_url('/local/o365/ucp.php'));
        } else {
            $defaultdata = ['disableo365onenote' => get_user_preferences('local_o365_disableo365onenote', 0)];
            $mform->set_data($defaultdata);
            echo $OUTPUT->header();
            $mform->display();
            echo $OUTPUT->footer();
        }
    }

    /**
     * Manage calendar syncing.
     */
    public function mode_calendar() {
        global $DB, $USER, $OUTPUT, $PAGE;

        $PAGE->navbar->add(get_string('ucp_calsync_title', 'local_o365'), new \moodle_url('/local/o365/ucp.php?action=calendar'));

        if (empty($this->o365connected)) {
            throw new \moodle_exception('ucp_notconnected', 'local_o365');
        }

        $outlookresource = \local_o365\rest\calendar::get_resource();
        if (empty($outlookresource)) {
            throw new \Exception('Not configured');
        }
        $httpclient = new \local_o365\httpclient();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $token = \local_o365\oauth2\token::instance($USER->id, $outlookresource, $clientdata, $httpclient);

        $calsync = new \local_o365\feature\calsync\main();
        $o365calendars = $calsync->get_calendars();

        $customdata = [
            'o365calendars' => [],
            'usercourses' => enrol_get_my_courses(['id', 'fullname']),
            'cancreatesiteevents' => false,
            'cancreatecourseevents' => [],
        ];
        foreach ($o365calendars as $o365calendar) {
            $customdata['o365calendars'][] = [
                'id' => $o365calendar['Id'],
                'name' => $o365calendar['Name'],
            ];
        }
        $primarycalid = $customdata['o365calendars'][0]['id'];

        // Determine permissions to create events. Determines whether user can sync from o365 to Moodle.
        $customdata['cancreatesiteevents'] = has_capability('moodle/calendar:manageentries', \context_course::instance(SITEID));
        foreach ($customdata['usercourses'] as $courseid => $course) {
            $cancreateincourse = has_capability('moodle/calendar:manageentries', \context_course::instance($courseid));
            $customdata['cancreatecourseevents'][$courseid] = $cancreateincourse;
        }

        $mform = new \local_o365\feature\calsync\form\subscriptions('?action=calendar', $customdata);
        if ($mform->is_cancelled()) {
            redirect(new \moodle_url('/local/o365/ucp.php'));
        } else if ($fromform = $mform->get_data()) {
            \local_o365\feature\calsync\form\subscriptions::update_subscriptions($fromform, $primarycalid,
                    $customdata['cancreatesiteevents'], $customdata['cancreatecourseevents']);
            redirect(new \moodle_url('/local/o365/ucp.php?action=calendar&saved=1'));
        } else {
            $PAGE->requires->jquery();
            $defaultdata = [];
            $existingsubsrs = $DB->get_recordset('local_o365_calsub', ['user_id' => $USER->id]);
            foreach ($existingsubsrs as $existingsubrec) {
                if ($existingsubrec->caltype === 'site') {
                    $defaultdata['sitecal']['checked'] = '1';
                    $defaultdata['sitecal']['syncwith'] = $existingsubrec->o365calid;
                    $defaultdata['sitecal']['syncbehav'] = $existingsubrec->syncbehav;
                } else if ($existingsubrec->caltype === 'user') {
                    $defaultdata['usercal']['checked'] = '1';
                    $defaultdata['usercal']['syncwith'] = $existingsubrec->o365calid;
                    $defaultdata['usercal']['syncbehav'] = $existingsubrec->syncbehav;
                } else if ($existingsubrec->caltype === 'course') {
                    $defaultdata['coursecal'][$existingsubrec->caltypeid]['checked'] = '1';
                    $defaultdata['coursecal'][$existingsubrec->caltypeid]['syncwith'] = $existingsubrec->o365calid;
                    $defaultdata['coursecal'][$existingsubrec->caltypeid]['syncbehav'] = $existingsubrec->syncbehav;
                }
            }

            $existingsubsrs->close();
            $mform->set_data($defaultdata);
            echo $OUTPUT->header();
            $mform->display();
            echo $OUTPUT->footer();
        }
    }

    /**
     * Initiate an OIDC authorization request.
     *
     * @param bool $uselogin Whether to switch the user's Moodle login method to OpenID Connect upon successful authorization.
     */
    protected function doauthrequest($uselogin) {
        global $CFG, $SESSION, $DB, $USER;
        require_once($CFG->dirroot.'/auth/oidc/auth.php');
        $stateparams = ['redirect' => '/local/o365/ucp.php'];
        $extraparams = [];
        $promptlogin = false;
        $o365connected = \local_o365\utils::is_o365_connected($USER->id);
        if ($o365connected === true && isset($USER->auth) && $USER->auth === 'oidc') {
            // User is already connected.
            redirect('/local/o365/ucp.php');
        }

        $connection = $DB->get_record('local_o365_connections', ['muserid' => $USER->id]);
        if (!empty($connection)) {
            // Matched user.
            $extraparams['login_hint'] = $connection->aadupn;
            $promptlogin = true;
        }
        $auth = new \auth_oidc\loginflow\authcode;
        $auth->set_httpclient(new \auth_oidc\httpclient());
        if ($uselogin !== true) {
            $stateparams['connectiononly'] = true;
        }
        $auth->initiateauthrequest($promptlogin, $stateparams, $extraparams);
    }

    /**
     * Connect to o365 and use o365 login.
     */
    public function mode_connectlogin() {
        $this->doauthrequest(true);
    }

    /**
     * Connect to o365 without switching user's login method.
     */
    public function mode_connecttoken() {
        global $USER;
        if (\local_o365\utils::is_o365_connected($USER->id) !== true) {
            require_capability('auth/oidc:manageconnection', \context_user::instance($USER->id), $USER->id);
        }
        $this->doauthrequest(false);
    }

    /**
     * Disconnect from o365.
     */
    public function mode_disconnecttoken() {
        global $CFG, $USER;
        require_capability('auth/oidc:manageconnection', \context_user::instance($USER->id), $USER->id);
        require_once($CFG->dirroot.'/auth/oidc/auth.php');
        $auth = new \auth_plugin_oidc;
        $auth->set_httpclient(new \auth_oidc\httpclient());
        $redirect = new \moodle_url('/local/o365/ucp.php');
        $auth->disconnect(true, $redirect);
    }

    /**
     * Azure AD Login status page.
     */
    public function mode_aadlogin() {
        global $OUTPUT, $USER;
        require_capability('auth/oidc:manageconnection', \context_user::instance($USER->id), $USER->id);
        $opname = 'Office 365';
        echo $OUTPUT->header();
        echo \html_writer::start_div('o365_ucp_featurepage');
        $strtitle = get_string('ucp_index_aadlogin_title', 'local_o365');
        echo \html_writer::tag('h3', $strtitle, ['class' => 'featureheader feature_aadlogin']);
        if ($this->o365connected === true && isset($USER->auth) && $USER->auth === 'oidc') {
            echo get_string('ucp_index_aadlogin_active', 'local_o365');
            if (is_enabled_auth('manual') === true) {
                $disconnectlinkuri = new \moodle_url('/auth/oidc/ucp.php', ['action' => 'disconnectlogin']);
                $strdisconnect = get_string('ucp_login_stop', 'auth_oidc', $opname);
                $linkhtml = \html_writer::link($disconnectlinkuri, $strdisconnect);
                echo \html_writer::tag('h5', $linkhtml);
            }
        } else {
            echo get_string('ucp_index_aadlogin_inactive', 'local_o365');
            $connectlinkuri = new \moodle_url('/local/o365/ucp.php', ['action' => 'connectlogin']);
            $linkhtml = \html_writer::link($connectlinkuri, get_string('ucp_login_start', 'auth_oidc', $opname));
            echo \html_writer::tag('h5', $linkhtml);
        }
        echo \html_writer::end_div();
        echo $OUTPUT->footer();
    }

    /**
     * Print a feature on the index page.
     *
     * @param string $id The feature identifier: "aadlogin", "calendar", "onenote".
     * @param bool $enabled Whether the feature is accessible or not.
     * @return string HTML for the feature entry.
     */
    protected function print_index_feature($id, $enabled) {
        $html = \html_writer::start_div('feature_'.$id);
        $featureuri = new \moodle_url('/local/o365/ucp.php?action='.$id);
        $strtitle = get_string('ucp_index_'.$id.'_title', 'local_o365');

        if ($enabled === true) {
            $html .= \html_writer::link($featureuri, $strtitle);
        } else {
            $html .= \html_writer::tag('b', $strtitle);
        }

        $strdesc = get_string('ucp_index_'.$id.'_desc', 'local_o365');
        $html .= \html_writer::tag('p', $strdesc);
        $html .= \html_writer::end_div();
        return $html;
    }

    /**
     * Get HTML for the connection status indicator box.
     *
     * @param string $status The current connection status.
     * @return string The HTML for the connection status indicator box.
     */
    protected function print_connection_status($status = 'connected') {
        global $OUTPUT, $USER, $DB;
        $classes = 'connectionstatus';
        $icon = '';
        $msg = '';
        switch ($status) {
            case 'connected':
                $classes .= ' alert-success';
                $icon = $OUTPUT->pix_icon('t/check', 'valid', 'moodle');
                if (isset($USER->auth) && $USER->auth !== 'oidc') {
                    $msg = get_string('ucp_index_connectionstatus_connected', 'local_o365');
                    $connecturl = new \moodle_url('/local/o365/ucp.php', ['action' => 'connecttoken']);
                    $disconnecturl = new \moodle_url('/local/o365/ucp.php', ['action' => 'disconnecttoken']);
                    $msg .= '<br /><br />';
                    $msg .= \html_writer::tag('b', get_string('ucp_index_connectionstatus_manage', 'local_o365')).'<br />';
                    if (has_capability('auth/oidc:manageconnection', \context_user::instance($USER->id), $USER->id) === true) {
                        $msg .= $OUTPUT->pix_icon('t/delete', 'valid', 'moodle');
                        $msg .= \html_writer::link($disconnecturl, get_string('ucp_index_connectionstatus_disconnect', 'local_o365'));
                        $msg .= '<br />';
                    }
                    $msg .= $OUTPUT->pix_icon('i/reload', 'valid', 'moodle');
                    $msg .= \html_writer::link($connecturl, get_string('ucp_index_connectionstatus_reconnect', 'local_o365'));
                } else {
                    $msg = get_string('ucp_index_connectionstatus_connected', 'local_o365');
                    $msg .= '<br /><br />';
                    $msg .= get_string('ucp_index_aadlogin_active', 'local_o365');
                    if (has_capability('auth/oidc:manageconnection', \context_user::instance($USER->id), $USER->id) === true) {
                        $disconnecturl = new \moodle_url('/auth/oidc/ucp.php', ['action' => 'disconnectlogin']);
                        $msg .= '<br /><br />';
                        $msg .= \html_writer::link($disconnecturl, get_string('ucp_index_connectionstatus_disconnect', 'local_o365'));
                    }
                }
                break;

            case 'matched':
                $matchrec = $DB->get_record('local_o365_connections', ['muserid' => $USER->id]);
                $classes .= ' alert-info';
                $msg = get_string('ucp_index_connectionstatus_matched', 'local_o365', $matchrec->aadupn);
                $connecturl = new \moodle_url('/local/o365/ucp.php', ['action' => 'connecttoken']);
                $msg .= '<br /><br />';
                $msg .= \html_writer::link($connecturl, get_string('ucp_index_connectionstatus_login', 'local_o365'));
                break;

            case 'notconnected':
                $classes .= ' alert-error';
                $icon = $OUTPUT->pix_icon('i/info', 'valid', 'moodle');
                $msg = get_string('ucp_index_connectionstatus_notconnected', 'local_o365');
                if (has_capability('auth/oidc:manageconnection', \context_user::instance($USER->id), $USER->id) === true) {
                    $connecturl = new \moodle_url('/local/o365/ucp.php', ['action' => 'connecttoken']);
                    $msg .= '<br /><br />';
                    $msg .= \html_writer::link($connecturl, get_string('ucp_index_connectionstatus_connect', 'local_o365'));
                }
                break;
        }

        $html = \html_writer::start_div($classes);
        $html .= \html_writer::tag('h5', get_string('ucp_index_connectionstatus_title', 'local_o365'));
        $html .= $icon;
        $html .= \html_writer::tag('p', $msg);
        $html .= \html_writer::end_div();
        return $html;
    }

    /**
     * Default mode - show connection status and a list of features to manage.
     */
    public function mode_default() {
        global $OUTPUT, $DB, $USER;

        $opname = 'Office 365';
        echo $OUTPUT->header();
        echo \html_writer::start_div('o365_ucp_index');
        echo \html_writer::tag('h2', $this->title);
        echo get_string('ucp_general_intro', 'local_o365');

        if ($this->o365connected === true) {
            echo $this->print_connection_status('connected');
        } else {
            $matchrec = $DB->get_record('local_o365_connections', ['muserid' => $USER->id]);
            if (!empty($matchrec)) {
                echo $this->print_connection_status('matched');
            } else {
                echo $this->print_connection_status('notconnected');
            }
        }

        echo \html_writer::start_div('features');
        echo '<br />';
        echo \html_writer::tag('h5', get_string('ucp_features', 'local_o365'));
        $introstr = get_string('ucp_features_intro', 'local_o365');
        if ($this->o365connected !== true) {
            $introstr .= get_string('ucp_features_intro_notconnected', 'local_o365');
        }
        echo \html_writer::tag('p', $introstr);

        if (has_capability('auth/oidc:manageconnection', \context_user::instance($USER->id), $USER->id) === true) {
            echo $this->print_index_feature('aadlogin', true);
        }
        echo $this->print_index_feature('calendar', $this->o365connected);
        echo $this->print_index_feature('onenote', $this->o365connected);

        echo \html_writer::end_div();

        echo \html_writer::end_div();
        echo $OUTPUT->footer();
    }
}