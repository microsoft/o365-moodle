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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Microsoft Block.
 */
class block_microsoft extends block_base {
    /**
     * Initialize plugin.
     */
    public function init() {
        $this->title = get_string('microsoft', 'block_microsoft');
    }

    /**
     * Whether the block has settings.
     *
     * @return bool Has settings or not.
     */
    public function has_config() {
        return true;
    }

    /**
     * Get the content of the block.
     *
     * @return stdObject
     */
    public function get_content() {
        global $USER, $DB;

        if (!isloggedin()) {
            return null;
        }

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new \stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        try {
            $o365connected = \local_o365\utils::is_o365_connected($USER->id);
            if ($o365connected === true) {
                $this->content->text .= $this->get_content_connected();
            } else {
                $connection = $DB->get_record('local_o365_connections', ['muserid' => $USER->id]);
                if (!empty($connection)) {
                    $uselogin = (!empty($connection->uselogin)) ? true : false;
                    $this->content->text .= $this->get_content_matched($connection->aadupn, $uselogin);
                } else {
                    $this->content->text .= $this->get_content_notconnected();
                }
            }
        } catch (\Exception $e) {
            $this->content->text = $e->getMessage();
        }

        return $this->content;
    }

    /**
     * Get block content for an unconnected but matched user.
     *
     * @param string $o365account The o365 account the user was matched to.
     * @param bool $uselogin Whether the match includes login change.
     * @return string Block content.
     */
    protected function get_content_matched($o365account, $uselogin = false) {
        $html = '';

        $langmatched = get_string('o365matched_title', 'block_microsoft');
        $html .= '<h5>'.$langmatched.'</h5>';

        $langmatcheddesc = get_string('o365matched_desc', 'block_microsoft', $o365account);
        $html .= '<p>'.$langmatcheddesc.'</p>';

        $langlogin = get_string('logintoo365', 'block_microsoft');
        $html .= '<p>'.get_string('o365matched_complete_authreq', 'block_microsoft').'</p>';

        if ($uselogin === true) {
            $html .= '<p>'.\html_writer::link(new \moodle_url('/local/o365/ucp.php'), $langlogin).'</p>';
        } else {
            $html .= '<p>'.\html_writer::link(new \moodle_url('/local/o365/ucp.php?action=connecttoken'), $langlogin).'</p>';
        }

        return $html;
    }

    /**
     * Get content for a connected user.
     *
     * @return string Block content.
     */
    protected function get_content_connected() {
        global $PAGE, $DB, $CFG, $SESSION, $USER, $OUTPUT;
        $o365config = get_config('local_o365');
        $html = '';

        $aadsync = get_config('local_o365', 'aadsync');
        $aadsync = array_flip(explode(',', $aadsync));
        // Only profile sync once for each session.
        if (empty($SESSION->block_microsoft_profilesync) && isset($aadsync['photosynconlogin'])) {
            $PAGE->requires->jquery();
            $PAGE->requires->js('/blocks/microsoft/js/microsoft.js');
            $PAGE->requires->js_init_call('microsoft_update_profile', array($CFG->wwwroot));
        }

        $user = $DB->get_record('user', array('id' => $USER->id));
        $langconnected = get_string('o365connected', 'block_microsoft', $user);
        $html .= '<h5>'.$langconnected.'</h5>';
        if (!empty($user->picture)) {
            $html .= '<div class="profilepicture">';
            $html .= $OUTPUT->user_picture($user, array('size' => 100, 'class' => 'block_microsoft_profile'));
            $html .= '</div>';
        }
        $outlookurl = new \moodle_url('/local/o365/ucp.php?action=calendar');
        $outlookstr = get_string('linkoutlook', 'block_microsoft');
        $sharepointstr = get_string('linksharepoint', 'block_microsoft');
        $prefsurl = new \moodle_url('/local/o365/ucp.php');
        $prefsstr = get_string('linkprefs', 'block_microsoft');

        $items = [];

        if ($PAGE->context instanceof \context_course && $PAGE->context->instanceid !== SITEID) {
            if (!empty($o365config->sharepointlink)) {
                $coursespsite = $DB->get_record('local_o365_coursespsite', ['courseid' => $PAGE->context->instanceid]);
                if (!empty($coursespsite)) {
                    $spsite = \local_o365\rest\sharepoint::get_resource();
                    if (!empty($spsite)) {
                        $spurl = $spsite.'/'.$coursespsite->siteurl;
                        $spattrs = ['class' => 'servicelink block_microsoft_sharepoint', 'target' => '_blank'];
                        $items[] = html_writer::link($spurl, $sharepointstr, $spattrs);
                        $items[] = '<hr/>';
                    }
                }
            }
        }

        $items[] = $this->render_onenote();

        if (!empty(get_config('block_microsoft', 'settings_showoutlooksync'))) {
            $items[] = \html_writer::link($outlookurl, $outlookstr, ['class' => 'servicelink block_microsoft_outlook']);
        }

        if (!empty(get_config('block_microsoft', 'settings_showpreferences'))) {
            $items[] = \html_writer::link($prefsurl, $prefsstr, ['class' => 'servicelink block_microsoft_preferences']);
        }

        if (has_capability('auth/oidc:manageconnection', \context_user::instance($USER->id), $USER->id) === true) {
            $connecturl = new \moodle_url('/local/o365/ucp.php', ['action' => 'aadlogin']);
            $connectstr = get_string('linkconnection', 'block_microsoft');
            $items[] = \html_writer::link($connecturl, $connectstr, ['class' => 'servicelink block_microsoft_connection']);
        }

        $downloadlinks = $this->get_content_o365download();
        foreach ($downloadlinks as $link) {
            $items[] = $link;
        }

        $html .= \html_writer::alist($items);

        return $html;
    }

    /**
     * Get block content for unconnected users.
     *
     * @return string Block content.
     */
    protected function get_content_notconnected() {
        global $DB, $USER, $OUTPUT;
        $html = '<h5>'.get_string('notconnected', 'block_microsoft').'</h5>';
        $items = [];
        $connecturl = new \moodle_url('/local/o365/ucp.php');
        $connectstr = get_string('connecttoo365', 'block_microsoft');

        $items[] = $this->render_onenote();

        if (!empty(get_config('block_microsoft', 'settings_showo365connect'))) {
            $items[] = \html_writer::link($connecturl, $connectstr, ['class' => 'servicelink block_microsoft_connection']);
        }

        $downloadlinks = $this->get_content_o365download();
        foreach ($downloadlinks as $link) {
            $items[] = $link;
        }

        $html .= \html_writer::alist($items);
        return $html;
    }

    /**
     * Get Office 365 download links (if enabled).
     *
     * @return array Array of download link HTML, or empty array if download links disabled.
     */
    protected function get_content_o365download() {
        $linksenabled = get_config('block_microsoft', 'showo365download');
        if (empty($linksenabled)) {
            return [];
        }

        $url = 'http://office.com/getoffice365';
        $str = get_string('geto365', 'block_microsoft');
        return [
            \html_writer::link($url, $str, ['class' => 'servicelink block_microsoft_downloado365', 'target' => '_blank']),
        ];
    }

    /**
     * Get the user's Moodle OneNote Notebook.
     *
     * @param \local_onenote\api\base $onenoteapi A constructed OneNote API to use.
     * @return array Array of information about the user's OneNote notebook used for Moodle.
     */
    protected function get_onenote_notebook(\local_onenote\api\base $onenoteapi) {
        $moodlenotebook = null;
        for ($i = 0; $i < 2; $i++) {
            $notebooks = $onenoteapi->get_items_list('');
            if (!empty($notebooks)) {
                $notebookname = get_string('notebookname', 'block_microsoft');
                foreach ($notebooks as $notebook) {
                    if ($notebook['title'] == $notebookname) {
                        $moodlenotebook = $notebook;
                        break;
                    }
                }
            }
            if (empty($moodlenotebook)) {
                $onenoteapi->sync_notebook_data();
            } else {
                break;
            }
        }
        return $moodlenotebook;
    }

    /**
     * Render OneNote section of the block.
     *
     * @return string HTML for the rendered OneNote section of the block.
     */
    protected function render_onenote() {
        global $USER, $PAGE;

        $onenotelinksenabled = get_config('block_microsoft', 'settings_showonenotenotebook');
        if (empty($onenotelinksenabled)) {
            return '';
        }

        $action = optional_param('action', '', PARAM_TEXT);
        try {
            $onenoteapi = \local_onenote\api\base::getinstance();
            $output = '';
            if ($onenoteapi->is_logged_in()) {
                // Add the "save to onenote" button if we are on an assignment page.
                $onassignpage = ($PAGE->cm && $PAGE->cm->modname == 'assign' && $action == 'editsubmission') ? true : false;
                if ($onassignpage === true && $onenoteapi->is_student($PAGE->cm->id, $USER->id)) {
                    $workstr = get_string('workonthis', 'block_microsoft');
                    $output .= $onenoteapi->render_action_button($workstr, $PAGE->cm->id).'<br /><br />';
                }
                // Find moodle notebook, create if not found.
                $moodlenotebook = null;

                $cache = \cache::make('block_microsoft', 'onenotenotebook');
                $moodlenotebook = $cache->get($USER->id);
                if (empty($moodlenotebook)) {
                    $moodlenotebook = $this->get_onenote_notebook($onenoteapi);
                    $result = $cache->set($USER->id, $moodlenotebook);
                }

                if (!empty($moodlenotebook)) {
                    $url = new \moodle_url($moodlenotebook['url']);
                    $stropennotebook = get_string('linkonenote', 'block_microsoft');
                    $linkattrs = [
                        'onclick' => 'window.open(this.href,\'_blank\'); return false;',
                        'class' => 'servicelink block_microsoft_onenote',
                    ];
                    $output .= \html_writer::link($url->out(false), $stropennotebook, $linkattrs);
                } else {
                    $output .= get_string('error_nomoodlenotebook', 'block_microsoft');
                }
            } else {
                $output .= $this->render_signin_widget($onenoteapi->get_login_url());
            }
            return $output;
        } catch (\Exception $e) {
            if (class_exists('\local_o365\utils')) {
                $debuginfo = (!empty($e->debuginfo)) ? $e->debuginfo : null;
                \local_o365\utils::debug($e->getMessage(), 'block_microsoft', $debuginfo);
            }
            return '<span class="block_microsoft_onenote servicelink">'.get_string('linkonenote_unavailable', 'block_microsoft')
                    .'<br /><small>'.get_string('contactadmin', 'block_microsoft').'</small></span>';
        }
    }

    /**
     * Get the HTML for the sign in button for an MS account.
     *
     * @return string HTML containing the sign in widget.
     */
    public function render_signin_widget($loginurl) {
        $loginstr = get_string('msalogin', 'block_microsoft');

        $attrs = [
            'onclick' => 'window.open(this.href,\'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=0\'); return false;',
            'class' => 'servicelink block_microsoft_msasignin'
        ];
        return \html_writer::link($loginurl, $loginstr, $attrs);
    }
}
