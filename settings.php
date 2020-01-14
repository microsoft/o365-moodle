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
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/local/o365/lib.php');

if (!$PAGE->requires->is_head_done()) {
    $PAGE->requires->jquery();
}
global $install;

// Define tab constants
if (!defined('LOCAL_O365_TAB_SETUP')) {
    /**
     * LOCAL_O365_TAB_SETUP - Setup settings.
     */
    define('LOCAL_O365_TAB_SETUP', 0);
    /**
     * LOCAL_O365_TAB_OPTIONS - Options to customize the plugins.
     */
    define('LOCAL_O365_TAB_OPTIONS', 1);
    /**
     * LOCAL_O365_TAB_ADVANCED - Admin tools + advanced settings.
     */
    define('LOCAL_O365_TAB_ADVANCED', 2);
    /**
     * LOCAL_O365_TAB_CONNECTIONS - User connections table.
     */
    define('LOCAL_O365_TAB_CONNECTIONS', 4);
    /**
     * LOCAL_O365_TAB_SDS - School data sync
     */
    define('LOCAL_O365_TAB_SDS', 3);
    /**
     * LOCAL_O365_TAB_TEAMS - Teams tab.
     */
    define('LOCAL_O365_TAB_TEAMS', 5);
    /**
     * LOCAL_O365_TAB_MOODLE_APP - Teams Moodle app.
     */
    define('LOCAL_O365_TAB_MOODLE_APP', 6);
}

if ($hassiteconfig) {
    $settings = new \admin_settingpage('local_o365', new lang_string('pluginname', 'local_o365'));
    $ADMIN->add('localplugins', $settings);

    $tabs = new \local_o365\adminsetting\tabs('local_o365/tabs', $settings->name, false);
    $tabs->addtab(LOCAL_O365_TAB_SETUP, new lang_string('settings_header_setup', 'local_o365'));
    $tabs->addtab(LOCAL_O365_TAB_OPTIONS, new lang_string('settings_header_syncsettings', 'local_o365'));
    $tabs->addtab(LOCAL_O365_TAB_ADVANCED, new lang_string('settings_header_advanced', 'local_o365'));
    $tabs->addtab(LOCAL_O365_TAB_SDS, new lang_string('settings_header_sds', 'local_o365'));
    $tabs->addtab(LOCAL_O365_TAB_TEAMS, new lang_string('settings_header_teams', 'local_o365'));
    if (local_o365_show_teams_moodle_app_id_tab()) {
        $tabs->addtab(LOCAL_O365_TAB_MOODLE_APP, new lang_string('settings_header_moodle_app', 'local_o365'));
    }
    $settings->add($tabs);

    $tab = $tabs->get_setting();

    if ($tab == LOCAL_O365_TAB_SETUP || !empty($install)) {
        $stepsenabled = 1;

        // STEP 1: Registration.
        $oidcsettings = new \moodle_url('/admin/settings.php?section=authsettingoidc');
        $label = new lang_string('settings_setup_step1', 'local_o365');
        $desc = new lang_string('settings_setup_step1_desc', 'local_o365', $CFG->wwwroot);
        $settings->add(new admin_setting_heading('local_o365_setup_step1', $label, $desc));

        $configdesc = new \lang_string('settings_setup_step1clientcreds', 'local_o365');
        $settings->add(new admin_setting_heading('local_o365_setup_step1clientcreds', '', $configdesc));

        $configkey = new lang_string('settings_clientid', 'local_o365');
        $configdesc = new lang_string('settings_clientid_desc', 'local_o365');
        $settings->add(new admin_setting_configtext('auth_oidc/clientid', $configkey, $configdesc, '', PARAM_TEXT));

        $configkey = new lang_string('settings_clientsecret', 'local_o365');
        $configdesc = new lang_string('settings_clientsecret_desc', 'local_o365');
        $settings->add(new admin_setting_configtext('auth_oidc/clientsecret', $configkey, $configdesc, '', PARAM_TEXT));

        $configdesc = new \lang_string('settings_setup_step1_credentials_end', 'local_o365', (object)['oidcsettings' => $oidcsettings->out()]);
        $settings->add(new admin_setting_heading('local_o365_setup_step1_credentialsend', '', $configdesc));

        // STEP 2: Connection Method.
        $clientid = get_config('auth_oidc', 'clientid');
        $clientsecret = get_config('auth_oidc', 'clientsecret');
        if (!empty($clientid) && !empty($clientsecret)) {
            $stepsenabled = 2;
        } else {
            $configdesc = new \lang_string('settings_setup_step1_continue', 'local_o365');
            $settings->add(new admin_setting_heading('local_o365_setup_step1continue', '', $configdesc));
        }

        if ($stepsenabled === 2) {
            $label = new lang_string('settings_setup_step2', 'local_o365');
            $desc = new lang_string('settings_setup_step2_desc', 'local_o365');
            $settings->add(new admin_setting_heading('local_o365_setup_step2', $label, $desc));

            $label = new lang_string('settings_enableapponlyaccess', 'local_o365');
            $desc = new lang_string('settings_enableapponlyaccess_details', 'local_o365');
            $settings->add(new \admin_setting_configcheckbox('local_o365/enableapponlyaccess', $label, $desc, '1'));

            $label = new lang_string('settings_systemapiuser', 'local_o365');
            $desc = new lang_string('settings_systemapiuser_details', 'local_o365');
            $settings->add(new \local_o365\adminsetting\systemapiuser('local_o365/systemapiuser', $label, $desc, '', PARAM_RAW));

            $enableapponlyaccess = get_config('local_o365', 'enableapponlyaccess');
            $systemapiuser = get_config('local_o365', 'systemtokens');
            if (!empty($enableapponlyaccess) || !empty($systemapiuser)) {
                $stepsenabled = 3;
            } else {
                $configdesc = new \lang_string('settings_setup_step2_continue', 'local_o365');
                $settings->add(new admin_setting_heading('local_o365_setup_step2continue', '', $configdesc));
            }
        }

        // STEP 3: Consent and additional information.
        if ($stepsenabled === 3) {
            $label = new lang_string('settings_setup_step3', 'local_o365');
            $desc = new lang_string('settings_setup_step3_desc', 'local_o365');
            $settings->add(new admin_setting_heading('local_o365_setup_step3', $label, $desc));

            $label = new lang_string('settings_adminconsent', 'local_o365');
            $desc = new lang_string('settings_adminconsent_details', 'local_o365');
            $settings->add(new \local_o365\adminsetting\adminconsent('local_o365/adminconsent', $label, $desc, '', PARAM_RAW));

            $label = new lang_string('settings_aadtenant', 'local_o365');
            $desc = new lang_string('settings_aadtenant_details', 'local_o365');
            $default = '';
            $paramtype = PARAM_URL;
            $settings->add(new \local_o365\adminsetting\serviceresource('local_o365/aadtenant', $label, $desc, $default, $paramtype));

            $label = new lang_string('settings_odburl', 'local_o365');
            $desc = new lang_string('settings_odburl_details', 'local_o365');
            $default = '';
            $paramtype = PARAM_URL;
            $settings->add(new \local_o365\adminsetting\serviceresource('local_o365/odburl', $label, $desc, $default, $paramtype));

            $aadtenant = get_config('local_o365', 'aadtenant');
            $odburl = get_config('local_o365', 'odburl');
            if (!empty($aadtenant) && !empty($odburl)) {
                $stepsenabled = 4;
            }
        }

        // Step 4: Verify.
        if ($stepsenabled === 4) {
            $label = new lang_string('settings_setup_step4', 'local_o365');
            $desc = new lang_string('settings_setup_step4_desc', 'local_o365');
            $settings->add(new admin_setting_heading('local_o365_setup_step4', $label, $desc));

            $label = new lang_string('settings_azuresetup', 'local_o365');
            $desc = new lang_string('settings_azuresetup_details', 'local_o365');
            $settings->add(new \local_o365\adminsetting\azuresetup('local_o365/azuresetup', $label, $desc));
        }
    }

    if ($tab == LOCAL_O365_TAB_OPTIONS || !empty($install)) {

        $label = new lang_string('settings_options_usersync', 'local_o365');
        $desc = new lang_string('settings_options_usersync_desc', 'local_o365');
        $settings->add(new admin_setting_heading('local_o365_options_usersync', $label, $desc));

        $label = new lang_string('settings_aadsync', 'local_o365');
        $scheduledtasks = new \moodle_url('/admin/tool/task/scheduledtasks.php');
        $desc = new lang_string('settings_aadsync_details', 'local_o365', $scheduledtasks->out());
        $choices = [
            'create' => new lang_string('settings_aadsync_create', 'local_o365'),
            'update' => new lang_string('settings_aadsync_update', 'local_o365'),
            'delete' => new lang_string('settings_aadsync_delete', 'local_o365'),
            'match' => new lang_string('settings_aadsync_match', 'local_o365'),
            'matchswitchauth' => new lang_string('settings_aadsync_matchswitchauth', 'local_o365'),
            'appassign' => new lang_string('settings_aadsync_appassign', 'local_o365'),
            'photosync' => new lang_string('settings_aadsync_photosync', 'local_o365'),
            'photosynconlogin' => new lang_string('settings_aadsync_photosynconlogin', 'local_o365'),
            'nodelta' => new lang_string('settings_aadsync_nodelta', 'local_o365'),
        ];
        $default = [];
        $settings->add(new \local_o365\adminsetting\configmulticheckboxchoiceshelp('local_o365/aadsync', $label, $desc, $default, $choices));

        $key = 'local_o365/usersynccreationrestriction';
        $label = new lang_string('settings_usersynccreationrestriction', 'local_o365');
        $desc = new lang_string('settings_usersynccreationrestriction_details', 'local_o365');
        $default = [];
        $settings->add(new \local_o365\adminsetting\usersynccreationrestriction($key, $label, $desc, $default));

        $label = new lang_string('settings_fieldmap', 'local_o365');
        $desc = new lang_string('settings_fieldmap_details', 'local_o365');
        $default = \local_o365\adminsetting\usersyncfieldmap::defaultmap();
        $settings->add(new \local_o365\adminsetting\usersyncfieldmap('local_o365/fieldmap', $label, $desc, $default));

        $label = new lang_string('settings_secthead_coursesync', 'local_o365');
        $desc = new lang_string('settings_secthead_coursesync_desc', 'local_o365');
        $settings->add(new admin_setting_heading('local_o365_section_coursesync', $label, $desc));

        $label = new lang_string('settings_usergroups', 'local_o365');
        $desc = new lang_string('settings_usergroups_details', 'local_o365');
        $settings->add(new \local_o365\adminsetting\usergroups('local_o365/createteams', $label, $desc, 'off'));

    }

    if ($tab === LOCAL_O365_TAB_ADVANCED || !empty($install)) {
        // Tools.
        $label = new lang_string('settings_header_tools', 'local_o365');
        $desc = '';
        $settings->add(new admin_setting_heading('local_o365_section_tools', $label, $desc));

        $label = new lang_string('settings_tools_tenants', 'local_o365');
        $linktext = new lang_string('settings_tools_tenants_linktext', 'local_o365');
        $linkurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'tenants']);
        $desc = new lang_string('settings_tools_tenants_details', 'local_o365');
        $settings->add(new \local_o365\adminsetting\toollink('local_o365/tenants', $label, $linktext, $linkurl, $desc));

        $label = new lang_string('settings_healthcheck', 'local_o365');
        $linktext = new lang_string('settings_healthcheck_linktext', 'local_o365');
        $linkurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'healthcheck']);
        $desc = new lang_string('settings_healthcheck_details', 'local_o365');
        $settings->add(new \local_o365\adminsetting\toollink('local_o365/healthcheck', $label, $linktext, $linkurl, $desc));

        $label = new lang_string('settings_userconnections', 'local_o365');
        $linktext = new lang_string('settings_userconnections_linktext', 'local_o365');
        $linkurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'userconnections']);
        $desc = new lang_string('settings_userconnections_details', 'local_o365');
        $settings->add(new \local_o365\adminsetting\toollink('local_o365/userconnections', $label, $linktext, $linkurl, $desc));

        $label = new lang_string('settings_usermatch', 'local_o365');
        $linktext = new lang_string('settings_usermatch', 'local_o365');
        $linkurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'usermatch']);
        $desc = new lang_string('settings_usermatch_details', 'local_o365');
        $settings->add(new \local_o365\adminsetting\toollink('local_o365/usermatch', $label, $linktext, $linkurl, $desc));

        $label = new lang_string('settings_maintenance', 'local_o365');
        $linktext = new lang_string('settings_maintenance_linktext', 'local_o365');
        $linkurl = new \moodle_url('/local/o365/acp.php', ['mode' => 'maintenance']);
        $desc = new lang_string('settings_maintenance_details', 'local_o365');
        $settings->add(new \local_o365\adminsetting\toollink('local_o365/maintenance', $label, $linktext, $linkurl, $desc));

        // Advanced settings.
        $label = new lang_string('settings_secthead_advanced', 'local_o365');
        $desc = new lang_string('settings_secthead_advanced_desc', 'local_o365');
        $settings->add(new admin_setting_heading('local_o365_section_advanced', $label, $desc));

        $label = new lang_string('settings_o365china', 'local_o365');
        $desc = new lang_string('settings_o365china_details', 'local_o365');
        $settings->add(new \admin_setting_configcheckbox('local_o365/chineseapi', $label, $desc, '0'));

        $label = new lang_string('settings_debugmode', 'local_o365');
        $logurl = new \moodle_url('/report/log/index.php', ['chooselog' => '1', 'modid' => 'site_errors']);
        $desc = new lang_string('settings_debugmode_details', 'local_o365', $logurl->out());
        $settings->add(new \admin_setting_configcheckbox('local_o365/debugmode', $label, $desc, '0'));

        $label = new lang_string('settings_switchauthminupnsplit0', 'local_o365');
        $desc = new lang_string('settings_switchauthminupnsplit0_details', 'local_o365');
        $settings->add(new \admin_setting_configtext('local_o365/switchauthminupnsplit0', $label, $desc, '10'));

        $label = new lang_string('settings_photoexpire', 'local_o365');
        $desc = new lang_string('settings_photoexpire_details', 'local_o365');
        $settings->add(new \admin_setting_configtext('local_o365/photoexpire', $label, $desc, '24'));

        // Legacy settings.
        $label = new lang_string('settings_secthead_legacy', 'local_o365');
        $desc = new lang_string('settings_secthead_legacy_desc', 'local_o365');
        $settings->add(new admin_setting_heading('local_o365_section_legacy', $label, $desc));

        $label = new lang_string('settings_sharepointlink', 'local_o365');
        $desc = new lang_string('settings_sharepointlink_details', 'local_o365');
        $settings->add(new \local_o365\adminsetting\sharepointlink('local_o365/sharepointlink', $label, $desc, '', PARAM_RAW));

        $label = new lang_string('acp_sharepointcourseselect', 'local_o365');
        $desc = new lang_string('acp_sharepointcourseselect_desc', 'local_o365');
        $settingname = 'local_o365/sharepointcourseselect';
        $settings->add(new \local_o365\adminsetting\sharepointcourseselect($settingname, $label, $desc, 'none'));

        // Preview features.
        $label = new lang_string('settings_secthead_preview', 'local_o365');
        $desc = new lang_string('settings_secthead_preview_desc', 'local_o365');
        $settings->add(new admin_setting_heading('local_o365_section_preview', $label, $desc));

        $label = new lang_string('settings_previewfeatures', 'local_o365');
        $desc = new lang_string('settings_previewfeatures_details', 'local_o365');
        $settings->add(new \admin_setting_configcheckbox('local_o365/enablepreview', $label, $desc, '0'));
    }

    if ($tab == LOCAL_O365_TAB_SDS || !empty($install)) {
        $scheduledtasks = new \moodle_url('/admin/tool/task/scheduledtasks.php');
        $desc = new lang_string('settings_sds_intro_previewwarning', 'local_o365');
        $desc .= new lang_string('settings_sds_intro_desc', 'local_o365', $scheduledtasks->out());
        $settings->add(new admin_setting_heading('local_o365_sds_intro', '', $desc));

        try {
            $httpclient = new \local_o365\httpclient();
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            $resource = \local_o365\rest\sds::get_resource();
            $token = \local_o365\oauth2\systemapiusertoken::instance(null, $resource, $clientdata, $httpclient);
            $schools = null;
            if (!empty($token)) {
                $apiclient = new \local_o365\rest\sds($token, $httpclient);
                $schools = $apiclient->get_schools();
                $schools = $schools['value'];
            }
        } catch (\Exception $e) {
            \local_o365\utils::debug($e->getMessage(), 'settings.php', $e);
            $schools = [];
        }

        if (!empty($schools)) {
            $label = new lang_string('settings_sds_profilesync', 'local_o365');
            $desc = new lang_string('settings_sds_profilesync_desc', 'local_o365');
            $settings->add(new admin_setting_heading('local_o365_sds_profilesync', $label, $desc));

            $label = new lang_string('settings_sds_profilesync_enabled', 'local_o365');
            $desc = new lang_string('settings_sds_profilesync_enabled_desc', 'local_o365');
            $settings->add(new \admin_setting_configcheckbox('local_o365/sdsprofilesyncenabled', $label, $desc, '0'));

            $label = new lang_string('settings_sds_fieldmap', 'local_o365');
            $desc = new lang_string('settings_sds_fieldmap_details', 'local_o365');
            $default = [
                'givenName/firstname',
                'surName/lastname',
                'pre_Email/email',
                'pre_MailingAddress/address',
                'pre_MailingCity/city',
                'pre_MailingCountry/country',
            ];
            $settings->add(new \local_o365\adminsetting\sdsfieldmap('local_o365/sdsfieldmap', $label, $desc, $default));

            $label = new lang_string('settings_sds_coursecreation', 'local_o365');
            $desc = new lang_string('settings_sds_coursecreation_desc', 'local_o365');
            $settings->add(new admin_setting_heading('local_o365_sds_coursecreation', $label, $desc));

            $label = new \lang_string('settings_sds_coursecreation_enabled', 'local_o365');
            $desc = new \lang_string('settings_sds_coursecreation_enabled_desc', 'local_o365');
            $default = [];
            $choices = [];
            foreach ($schools as $school) {
                $choices[$school['objectId']] = $school['displayName'];
            }
            $settings->add(new admin_setting_configmulticheckbox('local_o365/sdsschools', $label, $desc, $default, $choices));

            $label = new lang_string('settings_sds_enrolment_enabled', 'local_o365');
            $desc = new lang_string('settings_sds_enrolment_enabled_desc', 'local_o365');
            $settings->add(new \admin_setting_configcheckbox('local_o365/sdsenrolmentenabled', $label, $desc, '0'));
        } else {
            $desc = new lang_string('settings_sds_noschools', 'local_o365');
            $settings->add(new admin_setting_heading('local_o365_sds_noschools', '', $desc));
        }
    }

    if ($tab == LOCAL_O365_TAB_TEAMS || !empty($install)) {
        // Banner.
        $bannerhtml = html_writer::start_div('local_o365_settings_teams_banner_part_1', ['id' => 'admin-teams-banner']);
        $bannerhtml .= html_writer::img(new moodle_url('/local/o365/pix/teams_app.png'), '',
            ['class' => 'x-hidden-focus force-vertical-align local_o365_settings_teams_app_img']);
        $bannerhtml .= html_writer::start_tag('p');
        $bannerhtml .= get_string('settings_teams_banner_1', 'local_o365');
        $bannerhtml .= html_writer::empty_tag('br');
        $bannerhtml .= html_writer::empty_tag('br');
        $bannerhtml .= html_writer::end_tag('p');
        $bannerhtml .= html_writer::start_tag('p');
        $bannerhtml .= get_string('settings_teams_banner_2', 'local_o365');
        $bannerhtml .= html_writer::empty_tag('br');
        $bannerhtml .= html_writer::empty_tag('br');
        $bannerhtml .= html_writer::end_tag('p');
        $bannerhtml .= html_writer::end_div();
        $settings->add(new admin_setting_heading('local_o365/teams_setting_banner', '', $bannerhtml));

        // Instructions.
        $userrole = $DB->get_record('role', ['shortname' => 'user'], '*', MUST_EXIST);
        $edituserroleurl = new moodle_url('/admin/roles/define.php', ['action' => 'edit', 'roleid' => $userrole->id]);
        $settings->add(new admin_setting_heading('local_o365/teams_setting_additional_instructions', '',
            get_string('settings_teams_additional_instructions', 'local_o365',
                ['edituserroleurl' => $edituserroleurl->out()])));

        // Setting bot_app_id.
        $settings->add(new admin_setting_configtext_with_maxlength('local_o365/bot_app_id',
            get_string('settings_bot_app_id', 'local_o365'),
            get_string('settings_bot_app_id_desc', 'local_o365'),
            '00000000-0000-0000-0000-000000000000', PARAM_TEXT, 38, 36));

        // Setting bot_app_password.
        $settings->add(new admin_setting_configpasswordunmask('local_o365/bot_app_password',
            get_string('settings_bot_app_password', 'local_o365'),
            get_string('settings_bot_app_password_desc', 'local_o365'),
            ''));

        // Deploy button.
        $deploybuttonhtml = html_writer::start_div('form-item row local_o365_settings_teams_banner_part_2',
            ['id' => 'admin-teams-bot-deploy']);
        $deploybuttonhtml .= html_writer::start_tag('p', ['class' => 'local_o365_settings_teams_horizontal_spacer']);
        $deploybuttonhtml .= get_string('settings_teams_deploy_bot_1', 'local_o365');
        $deploybuttonhtml .= html_writer::empty_tag('br');
        $deploybuttonhtml .= html_writer::empty_tag('br');
        $deploybuttonhtml .= html_writer::link('https://aka.ms/DeployMoodleTeamsBot',
            html_writer::img('http://azuredeploy.net/deploybutton.png', ''), ['target' => '_blank']);
        $deploybuttonhtml .= html_writer::empty_tag('br');
        $deploybuttonhtml .= html_writer::link('https://aka.ms/MoodleTeamsBotHelp',
            get_string('settings_teams_deploy_bot_2', 'local_o365'), ['target' => '_blank']);
        $deploybuttonhtml .= html_writer::end_tag('p');
        $deploybuttonhtml .= html_writer::end_div();
        $settings->add(new admin_setting_heading('local_o365/teams_deploy_bot', '', $deploybuttonhtml));

        // Setting bot_shared_secret.
        $sharedsecretsetting = new admin_setting_configtext('local_o365/bot_sharedsecret',
            get_string('settings_bot_sharedsecret', 'local_o365'),
            get_string('settings_bot_sharedsecret_desc', 'local_o365'),
            '');
        $sharedsecretsetting->nosave = true;
        $settings->add($sharedsecretsetting);

        // Setting bot_feature_enabled.
        $settings->add(new admin_setting_configcheckbox('local_o365/bot_feature_enabled',
            get_string('settings_bot_feature_enabled', 'local_o365'),
            get_string('settings_bot_feature_enabled_desc', 'local_o365'),
            '0'));

        // Setting bot_webhook_endpoint.
        $settings->add(new admin_setting_configtext('local_o365/bot_webhook_endpoint',
            get_string('settings_bot_webhook_endpoint', 'local_o365'),
            get_string('settings_bot_webhook_endpoint_desc', 'local_o365'),
            ''));

        // Manifest download link.
        $downloadmanifesthtml = html_writer::start_div('local_o365_settings_manifest_container');
        $downloadmanifesthtml .= html_writer::start_tag('p');
        $manifesturl = new moodle_url('/local/o365/export_manifest.php');
        $downloadmanifesthtml .= html_writer::link($manifesturl,
            get_string('settings_download_teams_tab_app_manifest', 'local_o365'),
            ['class' => 'btn btn-primary']);
        $downloadmanifesthtml .= html_writer::end_tag('p');
        $downloadmanifesthtml .= html_writer::start_tag('p');
        $downloadmanifesthtml .= get_string('settings_download_teams_tab_app_manifest_reminder', 'local_o365');
        $downloadmanifesthtml .= html_writer::end_tag('p');
        $downloadmanifesthtml .= html_writer::start_tag('p');
        $downloadmanifesthtml .= get_string('settings_publish_manifest_instruction', 'local_o365');
        $downloadmanifesthtml .= html_writer::end_tag('p');
        $downloadmanifesthtml .= html_writer::end_div();

        $settings->add(new admin_setting_heading('download_manifest_header', '', $downloadmanifesthtml));
    }

    if (($tab == LOCAL_O365_TAB_MOODLE_APP || !empty($install)) && local_o365_show_teams_moodle_app_id_tab()) {
        // Moodle app ID.
        $moodleappiddescription = get_string('settings_moodle_app_id_desc', 'local_o365');
        if (\local_o365\utils::is_configured() === true) {
            if (\local_o365\utils::is_configured_apponlyaccess() !== true) {
                $httpclient = new \local_o365\httpclient();
                $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
                $unifiedresource = \local_o365\rest\unified::get_resource();
                $unifiedtoken = \local_o365\utils::get_app_or_system_token($unifiedresource, $clientdata, $httpclient);

                if (!empty($unifiedtoken)) {
                    $graphclient = new \local_o365\rest\unified($unifiedtoken, $httpclient);

                    // Check Moodle app ID using default externalId provided in Moodle application.
                    $moodleappid = $graphclient->get_catalog_app_id(TEAMS_MOODLE_APP_EXTERNAL_ID);

                    if ($moodleappid) {
                        $moodleappiddescription .= get_string('settings_moodle_app_id_desc_auto_id', 'local_o365', $moodleappid);
                    }
                }
            }
        }

        $settings->add(new admin_setting_configtext('local_o365/moodle_app_id',
            get_string('settings_moodle_app_id', 'local_o365'),
            $moodleappiddescription,
            '00000000-0000-0000-0000-000000000000', PARAM_TEXT, 38, 36));

        // Set Moodle App ID instructions.
        if (\local_o365\utils::is_configured() === true && \local_o365\utils::is_configured_apponlyaccess() === true) {
            $setmoodleappidinstructionhtml = html_writer::start_tag('p');
            $setmoodleappidinstructionhtml .= get_string('settings_set_moodle_app_id_instruction', 'local_o365');
            $setmoodleappidinstructionhtml .= html_writer::end_tag('p');
            $setmoodleappidinstructionhtml .= html_writer::empty_tag('br');
            $setmoodleappidinstructionhtml .= html_writer::img(new moodle_url('/local/o365/pix/moodle_app_id.png'), '',
                ['class' => 'x-hidden-focus force-vertical-align local_o365_settings_moodle_app_id_img']);

            $settings->add(new admin_setting_heading('set_moodle_app_id_instruction_header', '', $setmoodleappidinstructionhtml));
        }
    }
}
