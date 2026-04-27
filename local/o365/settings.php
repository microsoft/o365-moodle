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
 * Plugin settings.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

use auth_oidc\adminsetting\auth_oidc_admin_setting_label;
use core\url;
use local_o365\adminsetting\usersyncoptions;
use local_o365\adminsetting\adminconsent;
use local_o365\adminsetting\verifysetup;
use local_o365\adminsetting\courseresetteams;
use local_o365\adminsetting\moodlesetup;
use local_o365\adminsetting\serviceresource;
use local_o365\adminsetting\toollink;
use local_o365\adminsetting\coursesync;
use local_o365\adminsetting\usersynccreationrestriction;
use local_o365\feature\coursesync\main;
use local_o365\feature\coursesync\utils;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/local/o365/lib.php');
require_once($CFG->dirroot . '/auth/oidc/lib.php');

// Backward compatibility: handle legacy s_local_o365_tabs parameter.
if ($PAGE->has_set_url() && $PAGE->url->get_param('s_local_o365_tabs') !== null) {
    $legacytab = intval($PAGE->url->get_param('s_local_o365_tabs'));
    $sectionmap = [
        LOCAL_O365_TAB_SETUP => 'local_o365',
        LOCAL_O365_TAB_SYNC => 'local_o365_sync',
        LOCAL_O365_TAB_ADVANCED => 'local_o365_advanced',
        LOCAL_O365_TAB_SDS => 'local_o365_sds',
        LOCAL_O365_TAB_TEAMS => 'local_o365_teams',
        LOCAL_O365_TAB_MOODLE_APP => 'local_o365_moodle_app',
    ];
    if (isset($sectionmap[$legacytab])) {
        $newurl = new url('/admin/settings.php', ['section' => $sectionmap[$legacytab]]);
        redirect($newurl);
    }
}

if (!$PAGE->requires->is_head_done()) {
    $PAGE->requires->jquery();
}

global $install;

// Course role options used across multiple settings pages.
$courseroleoptions = [];
$courseroles = get_roles_for_contextlevels(CONTEXT_COURSE);
$allroles = get_all_roles();
foreach ($courseroles as $courserole) {
    $role = $allroles[$courserole];
    $courseroleoptions[$courserole] = role_get_name($role);
}

if ($hassiteconfig) {
    // Create the top-level folder for all Microsoft 365 integration settings pages.
    $o365folder = new admin_category('local_o365_folder', new lang_string('pluginname', 'local_o365'));
    $ADMIN->add('localplugins', $o365folder);

    // SETUP PAGE
    // The section ID 'local_o365' is preserved for backward compatibility with
    // existing links (e.g. from auth_oidc_reset_app_tokens callback).
    $settings = new admin_settingpage('local_o365', get_string('settings_header_setup', 'local_o365'));
    $ADMIN->add('local_o365_folder', $settings);

    if (empty($install)) {
        $settings->add(new admin_setting_heading('local_o365_nav', '', local_o365_get_settings_nav_html('local_o365')));
    }

    $stepsenabled = 1;

    // Step 1: Registration.
    $oidcconfigpageurl = new url('/auth/oidc/manageapplication.php');
    $label = new lang_string('settings_setup_step1', 'local_o365');
    $desc = new lang_string('settings_setup_step1_desc', 'local_o365', $CFG->wwwroot);
    $settings->add(new admin_setting_heading('local_o365_setup_step1', $label, $desc));

    $configdesc = new lang_string('settings_setup_step1clientcreds', 'local_o365', $oidcconfigpageurl->out());
    $settings->add(new admin_setting_heading('local_o365_setup_step1clientcreds', '', $configdesc));

    $manualconfigurl = 'https://docs.moodle.org/' . get_config('core', 'branch') . '/en/Microsoft_365';
    $configdesc = new lang_string('settings_setup_step1_credentials_end', 'local_o365', $manualconfigurl);
    $settings->add(new admin_setting_heading('local_o365_setup_step1_credentialsend', '', $configdesc));

    if (auth_oidc_is_setup_complete()) {
        $settings->add(new admin_setting_heading(
            'local_o365_existing_settings_heading',
            '',
            get_string('settings_setup_step1_existing_settings', 'local_o365')
        ));
        // IdP type.
        $settings->add(new admin_setting_description(
            'local_o365_existing_settings_idp_type',
            get_string('idptype', 'auth_oidc'),
            auth_oidc_get_idp_type_name()
        ));
        // Client ID.
        $settings->add(new admin_setting_description(
            'local_o365_existing_setting_client_id',
            get_string('clientid', 'auth_oidc'),
            get_config('auth_oidc', 'clientid')
        ));
        // Authentication type.
        $settings->add(new admin_setting_description(
            'local_o365_existing_setting_client_auth_method',
            get_string('clientauthmethod', 'auth_oidc'),
            auth_oidc_get_client_auth_method_name()
        ));
    }

    // Step 2: Consent and additional information.
    if (auth_oidc_is_setup_complete()) {
        $stepsenabled = 2;
    } else {
        $configdesc = new lang_string('settings_setup_step1_continue', 'local_o365');
        $settings->add(new admin_setting_heading('local_o365_setup_step1continue', '', $configdesc));
    }

    if ($stepsenabled === 2) {
        $label = new lang_string('settings_setup_step2', 'local_o365');
        $desc = new lang_string('settings_setup_step2_desc', 'local_o365');
        $settings->add(new admin_setting_heading('local_o365_setup_step2', $label, $desc));

        $label = new lang_string('settings_adminconsent', 'local_o365');
        $desc = new lang_string('settings_adminconsent_details', 'local_o365');
        $settings->add(new adminconsent('local_o365/adminconsent', $label, $desc, '', PARAM_RAW));

        $label = new lang_string('settings_entratenant', 'local_o365');
        $desc = new lang_string('settings_entratenant_details', 'local_o365');
        $settings->add(new serviceresource('local_o365/entratenant', $label, $desc, '', PARAM_URL));

        $label = new lang_string('settings_odburl', 'local_o365');
        $desc = new lang_string('settings_odburl_details', 'local_o365');
        $settings->add(new serviceresource('local_o365/odburl', $label, $desc, '', PARAM_URL));

        $entratenant = get_config('local_o365', 'entratenant');
        $odburl = get_config('local_o365', 'odburl');
        if (!empty($entratenant) && !empty($odburl)) {
            $stepsenabled = 3;
        }
    }

    // Step 3: Verify.
    if ($stepsenabled === 3) {
        $label = new lang_string('settings_setup_step3', 'local_o365');
        $desc = new lang_string('settings_setup_step3_desc', 'local_o365');
        $settings->add(new admin_setting_heading('local_o365_setup_step3', $label, $desc));

        $label = new lang_string('settings_verifysetup', 'local_o365');
        $desc = new lang_string('settings_verifysetup_details', 'local_o365');
        $settings->add(new verifysetup('local_o365/verifysetup', $label, $desc));
    }

    // Remaining pages are only registered outside of install mode.
    if (empty($install)) {
        // SYNC SETTINGS PAGE.
        $syncsettings = new admin_settingpage(
            'local_o365_sync',
            get_string('settings_header_syncsettings', 'local_o365')
        );
        $ADMIN->add('local_o365_folder', $syncsettings);
        $syncsettings->add(new admin_setting_heading(
            'local_o365_sync_nav',
            '',
            local_o365_get_settings_nav_html('local_o365_sync')
        ));

        $label = new lang_string('settings_options_usersync', 'local_o365');
        $desc = new lang_string('settings_options_usersync_desc', 'local_o365');
        $syncsettings->add(new admin_setting_heading('local_o365_options_usersync', $label, $desc));

        // User sync options.
        $label = new lang_string('settings_usersync', 'local_o365');
        $scheduledtasks = new url('/admin/tool/task/scheduledtasks.php');
        $desc = new lang_string('settings_usersync_details', 'local_o365', $scheduledtasks->out());
        $syncsettings->add(new usersyncoptions('local_o365/usersync', $label, $desc));

        // User creation restrictions.
        $label = new lang_string('settings_usersynccreationrestriction', 'local_o365');
        $desc = new lang_string('settings_usersynccreationrestriction_details', 'local_o365');
        $syncsettings->add(new usersynccreationrestriction('local_o365/usersynccreationrestriction', $label, $desc, []));

        // Link to field mapping settings.
        $label = new lang_string('settings_fieldmap', 'local_o365');
        $oidcsettingspageurl = new url('/admin/settings.php', ['section' => 'auth_oidc_field_mapping']);
        $desc = new lang_string('settings_fieldmap_details', 'local_o365', $oidcsettingspageurl->out(false));
        $syncsettings->add(new auth_oidc_admin_setting_label('local_o365/fieldmap', $label, $desc, null));

        // User suspension / deletion running time.
        $label = new lang_string('settings_suspend_delete_running_time', 'local_o365');
        $desc = new lang_string('settings_suspend_delete_running_time_desc', 'local_o365');
        $syncsettings->add(new admin_setting_configtime(
            'local_o365/usersync_suspension_h',
            'local_o365/usersync_suspension_m',
            $label,
            $desc,
            ['h' => 2, 'm' => 30]
        ));

        // Toggle to control whether to support UPN change.
        $label = new lang_string('settings_support_user_identifier_change', 'local_o365');
        $desc = new lang_string('settings_support_user_identifier_change_desc', 'local_o365');
        $syncsettings->add(new admin_setting_configcheckbox(
            'local_o365/support_user_identifier_change',
            $label,
            $desc,
            '0'
        ));

        // Course sync section.
        $label = new lang_string('settings_secthead_coursesync', 'local_o365');
        $desc = new lang_string('settings_secthead_coursesync_desc', 'local_o365');
        $syncsettings->add(new admin_setting_heading('local_o365_section_coursesync', $label, $desc));

        // Course sync setting.
        $label = new lang_string('settings_coursesync', 'local_o365');
        $desc = new lang_string('settings_coursesync_details', 'local_o365');
        $syncsettings->add(new coursesync('local_o365/coursesync', $label, $desc, 'off'));

        // Sync hidden courses setting.
        $label = new lang_string('settings_coursesync_sync_hidden_courses', 'local_o365');
        $desc = new lang_string('settings_coursesync_sync_hidden_courses_desc', 'local_o365');
        $syncsettings->add(new admin_setting_configcheckbox('local_o365/synchiddencourses', $label, $desc, '0'));

        // Course deletion action.
        $label = new lang_string('settings_coursesync_delete_group_on_course_deletion', 'local_o365');
        $desc = new lang_string('settings_coursesync_delete_group_on_course_deletion_details', 'local_o365');
        $syncsettings->add(new admin_setting_configcheckbox(
            'local_o365/delete_group_on_course_deletion',
            $label,
            $desc,
            '0'
        ));

        // Course sync disabled action.
        $label = new lang_string('settings_coursesync_delete_group_on_course_sync_disabled', 'local_o365');
        $desc = new lang_string('settings_coursesync_delete_group_on_course_sync_disabled_details', 'local_o365');
        $syncsettings->add(new admin_setting_configcheckbox(
            'local_o365/delete_group_on_course_sync_disabled',
            $label,
            $desc,
            '0'
        ));

        // Courses to process per task.
        $label = new lang_string('settings_coursesync_courses_per_task', 'local_o365');
        $desc = new lang_string('settings_coursesync_courses_per_task_details', 'local_o365');
        $syncsettings->add(new admin_setting_configtext('local_o365/courses_per_task', $label, $desc, 20, PARAM_INT));

        // Sync direction setting.
        $label = new lang_string('settings_coursesync_sync_direction', 'local_o365');
        $desc = new lang_string('settings_coursesync_sync_direction_details', 'local_o365');
        $options = [
            COURSE_USER_SYNC_DIRECTION_MOODLE_TO_TEAMS => new lang_string(
                'settings_coursesync_sync_moodle_to_teams',
                'local_o365'
            ),
            COURSE_USER_SYNC_DIRECTION_TEAMS_TO_MOODLE => new lang_string(
                'settings_coursesync_sync_teams_to_moodle',
                'local_o365'
            ),
            COURSE_USER_SYNC_DIRECTION_BOTH => new lang_string('settings_coursesync_sync_both', 'local_o365'),
        ];
        $syncsettings->add(new admin_setting_configselect(
            'local_o365/courseusersyncdirection',
            $label,
            $desc,
            COURSE_USER_SYNC_DIRECTION_MOODLE_TO_TEAMS,
            $options
        ));

        // Course sync Team owner role.
        $label = new lang_string('settings_coursesync_enrolment_owner_role', 'local_o365');
        $desc = new lang_string('settings_coursesync_enrolment_owner_role_desc', 'local_o365');
        $syncsettings->add(new admin_setting_configselect(
            'local_o365/coursesyncownerrole',
            $label,
            $desc,
            3,
            $courseroleoptions
        ));

        // Course sync Team member role.
        $label = new lang_string('settings_coursesync_enrolment_member_role', 'local_o365');
        $desc = new lang_string('settings_coursesync_enrolment_member_role_desc', 'local_o365');
        $syncsettings->add(new admin_setting_configselect(
            'local_o365/coursesyncmemberrole',
            $label,
            $desc,
            5,
            $courseroleoptions
        ));

        // Team / group name section.
        $syncsettings->add(new admin_setting_heading(
            'local_o365_section_team_name',
            new lang_string('settings_secthead_team_group_name', 'local_o365'),
            new lang_string('settings_secthead_team_group_name_desc', 'local_o365')
        ));

        $teamgroupnamemainpartoptions = [
            main::NAME_OPTION_FULL_NAME  => get_string('settings_main_name_option_full_name', 'local_o365'),
            main::NAME_OPTION_SHORT_NAME => get_string('settings_main_name_option_short_name', 'local_o365'),
            main::NAME_OPTION_ID         => get_string('settings_main_name_option_id', 'local_o365'),
            main::NAME_OPTION_ID_NUMBER  => get_string('settings_main_name_option_id_number', 'local_o365'),
        ];

        // Team naming convention - prefix.
        $syncsettings->add(new admin_setting_configtext(
            'local_o365/team_name_prefix',
            get_string('settings_team_name_prefix', 'local_o365'),
            get_string('settings_team_name_prefix_desc', 'local_o365'),
            ''
        ));

        // Team naming convention - course.
        $syncsettings->add(new admin_setting_configselect(
            'local_o365/team_name_course',
            get_string('settings_team_name_course', 'local_o365'),
            get_string('settings_team_name_course_desc', 'local_o365'),
            main::NAME_OPTION_FULL_NAME,
            $teamgroupnamemainpartoptions
        ));

        // Team naming convention - suffix.
        $syncsettings->add(new admin_setting_configtext(
            'local_o365/team_name_suffix',
            get_string('settings_team_name_suffix', 'local_o365'),
            get_string('settings_team_name_suffix_desc', 'local_o365'),
            ''
        ));

        // Group mail alias naming convention - prefix.
        $syncsettings->add(new admin_setting_configtext_with_maxlength(
            'local_o365/group_mail_alias_prefix',
            get_string('settings_group_mail_alias_prefix', 'local_o365'),
            get_string('settings_group_mail_alias_prefix_desc', 'local_o365'),
            '',
            PARAM_TEXT,
            null,
            15
        ));

        // Group mail alias naming convention - course.
        $syncsettings->add(new admin_setting_configselect(
            'local_o365/group_mail_alias_course',
            get_string('settings_group_mail_alias_course', 'local_o365'),
            get_string('settings_group_mail_alias_course_desc', 'local_o365'),
            main::NAME_OPTION_SHORT_NAME,
            $teamgroupnamemainpartoptions
        ));

        // Group mail alias naming convention - suffix.
        $syncsettings->add(new admin_setting_configtext_with_maxlength(
            'local_o365/group_mail_alias_suffix',
            get_string('settings_group_mail_alias_suffix', 'local_o365'),
            get_string('settings_group_mail_alias_suffix_desc', 'local_o365'),
            '',
            PARAM_TEXT,
            null,
            15
        ));

        // Sample Team / group name.
        [$sampleteamname, $samplegroupalias] = utils::get_sample_team_group_names();
        $syncsettings->add(new admin_setting_heading(
            'local_o365_section_team_name_sample',
            '',
            get_string(
                'settings_team_name_sample',
                'local_o365',
                ['teamname' => $sampleteamname, 'mailalias' => $samplegroupalias]
            )
        ));

        // Sync Team name.
        $syncsettings->add(new admin_setting_configcheckbox(
            'local_o365/team_name_sync',
            get_string('settings_team_name_sync', 'local_o365'),
            get_string('settings_team_name_sync_desc', 'local_o365'),
            0
        ));

        // Cohort sync section.
        $label = new lang_string('settings_secthead_cohortsync', 'local_o365');
        $desc = new lang_string('settings_secthead_cohortsync_desc', 'local_o365');
        $syncsettings->add(new admin_setting_heading('local_o365_section_cohortsync', $label, $desc));

        $label = new lang_string('settings_cohortsync', 'local_o365');
        $linktext = new lang_string('settings_cohortsync_linktext', 'local_o365');
        $linkurl = new url('/local/o365/cohortsync.php');
        $desc = new lang_string('settings_cohortsync_details', 'local_o365');
        $syncsettings->add(new toollink(
            'local_o365/cohortsync',
            $label,
            $linktext,
            $linkurl,
            $desc
        ));

        // Course request section.
        $label = new lang_string('settings_secthead_course_request', 'local_o365');
        $desc = new lang_string('settings_secthead_course_request_desc', 'local_o365');
        $syncsettings->add(new admin_setting_heading('local_o365_section_course_request', $label, $desc));

        // Course request Team owner role.
        $label = new lang_string('settings_course_request_enrolment_owner_role', 'local_o365');
        $desc = new lang_string('settings_course_request_enrolment_owner_role_desc', 'local_o365');
        $syncsettings->add(new admin_setting_configselect(
            'local_o365/courserequestownerrole',
            $label,
            $desc,
            3,
            $courseroleoptions
        ));

        // Course request Team member role.
        $label = new lang_string('settings_course_request_enrolment_member_role', 'local_o365');
        $desc = new lang_string('settings_course_request_enrolment_member_role_desc', 'local_o365');
        $syncsettings->add(new admin_setting_configselect(
            'local_o365/courserequestmemberrole',
            $label,
            $desc,
            5,
            $courseroleoptions
        ));

        // ADVANCED SETTINGS PAGE.
        $advancedsettings = new admin_settingpage(
            'local_o365_advanced',
            get_string('settings_header_advanced', 'local_o365')
        );
        $ADMIN->add('local_o365_folder', $advancedsettings);
        $advancedsettings->add(new admin_setting_heading(
            'local_o365_advanced_nav',
            '',
            local_o365_get_settings_nav_html('local_o365_advanced')
        ));

        // Tools section.
        $label = new lang_string('settings_header_tools', 'local_o365');
        $advancedsettings->add(new admin_setting_heading('local_o365_section_tools', $label, ''));

        $label = new lang_string('settings_tools_tenants', 'local_o365');
        $linktext = new lang_string('settings_tools_tenants_linktext', 'local_o365');
        $linkurl = new url('/local/o365/acp.php', ['mode' => 'tenants']);
        $desc = new lang_string('settings_tools_tenants_details', 'local_o365');
        $advancedsettings->add(new toollink(
            'local_o365/tenants',
            $label,
            $linktext,
            $linkurl,
            $desc
        ));

        $label = new lang_string('settings_healthcheck', 'local_o365');
        $linktext = new lang_string('settings_healthcheck_linktext', 'local_o365');
        $linkurl = new url('/local/o365/acp.php', ['mode' => 'healthcheck']);
        $desc = new lang_string('settings_healthcheck_details', 'local_o365');
        $advancedsettings->add(new toollink(
            'local_o365/healthcheck',
            $label,
            $linktext,
            $linkurl,
            $desc
        ));

        $label = new lang_string('settings_userconnections', 'local_o365');
        $linktext = new lang_string('settings_userconnections_linktext', 'local_o365');
        $linkurl = new url('/local/o365/acp.php', ['mode' => 'userconnections']);
        $desc = new lang_string('settings_userconnections_details', 'local_o365');
        $advancedsettings->add(new toollink(
            'local_o365/userconnections',
            $label,
            $linktext,
            $linkurl,
            $desc
        ));

        $label = new lang_string('settings_teamconnections', 'local_o365');
        $linktext = new lang_string('settings_teamconnections_linktext', 'local_o365');
        $linkurl = new url('/local/o365/acp.php', ['mode' => 'teamconnections']);
        $desc = new lang_string('settings_teamconnections_details', 'local_o365');
        $advancedsettings->add(new toollink(
            'local_o365/teamconnections',
            $label,
            $linktext,
            $linkurl,
            $desc
        ));

        $label = new lang_string('settings_usermatch', 'local_o365');
        $linktext = new lang_string('settings_usermatch', 'local_o365');
        $linkurl = new url('/local/o365/acp.php', ['mode' => 'usermatch']);
        $desc = new lang_string('settings_usermatch_details', 'local_o365');
        $advancedsettings->add(new toollink(
            'local_o365/usermatch',
            $label,
            $linktext,
            $linkurl,
            $desc
        ));

        $label = new lang_string('settings_maintenance', 'local_o365');
        $linktext = new lang_string('settings_maintenance_linktext', 'local_o365');
        $linkurl = new url('/local/o365/acp.php', ['mode' => 'maintenance']);
        $desc = new lang_string('settings_maintenance_details', 'local_o365');
        $advancedsettings->add(new toollink(
            'local_o365/maintenance',
            $label,
            $linktext,
            $linkurl,
            $desc
        ));

        // Advanced settings section.
        $label = new lang_string('settings_secthead_advanced', 'local_o365');
        $desc = new lang_string('settings_secthead_advanced_desc', 'local_o365');
        $advancedsettings->add(new admin_setting_heading('local_o365_section_advanced', $label, $desc));

        // Course reset Teams settings.
        if (utils::is_enabled()) {
            $label = new lang_string('settings_course_reset_teams', 'local_o365');
            $desc = new lang_string('settings_course_reset_teams_details', 'local_o365');
            $advancedsettings->add(new courseresetteams(
                'local_o365/course_reset_teams',
                $label,
                $desc,
                COURSE_SYNC_RESET_SITE_SETTING_DO_NOTHING
            ));
        }

        // Reset team name prefix.
        $label = new lang_string('settings_reset_team_name_prefix', 'local_o365');
        $desc = new lang_string('settings_reset_team_name_prefix_details', 'local_o365');
        $advancedsettings->add(new admin_setting_configtext(
            'local_o365/reset_team_name_prefix',
            $label,
            $desc,
            '(archived) ',
            PARAM_TEXT
        ));

        // Reset group name prefix.
        $label = new lang_string('settings_reset_group_name_prefix', 'local_o365');
        $desc = new lang_string('settings_reset_group_name_prefix_details', 'local_o365');
        $advancedsettings->add(new admin_setting_configtext(
            'local_o365/reset_group_name_prefix',
            $label,
            $desc,
            'disconnected-',
            PARAM_TEXT
        ));

        $label = new lang_string('settings_o365china', 'local_o365');
        $desc = new lang_string('settings_o365china_details', 'local_o365');
        $advancedsettings->add(new admin_setting_configcheckbox('local_o365/chineseapi', $label, $desc, '0'));

        $label = new lang_string('settings_debugmode', 'local_o365');
        $logurl = new url('/report/log/index.php', ['chooselog' => '1', 'modid' => 'site_errors']);
        $desc = new lang_string('settings_debugmode_details', 'local_o365', $logurl->out());
        $advancedsettings->add(new admin_setting_configcheckbox('local_o365/debugmode', $label, $desc, '0'));

        $label = new lang_string('settings_switchauthminupnsplit0', 'local_o365');
        $desc = new lang_string('settings_switchauthminupnsplit0_details', 'local_o365');
        $advancedsettings->add(new admin_setting_configtext('local_o365/switchauthminupnsplit0', $label, $desc, '10'));

        $label = new lang_string('settings_photoexpire', 'local_o365');
        $desc = new lang_string('settings_photoexpire_details', 'local_o365');
        $advancedsettings->add(new admin_setting_configtext('local_o365/photoexpire', $label, $desc, '24'));

        // Custom theme.
        $themes = get_list_of_themes();
        $options = [];
        foreach ($themes as $theme) {
            $options[$theme->name] = $theme->name;
        }
        $label = new lang_string('settings_customtheme', 'local_o365');
        $desc = new lang_string('settings_customtheme_desc', 'local_o365');
        $advancedsettings->add(new admin_setting_configselect(
            'local_o365/customtheme',
            $label,
            $desc,
            'boost_o365teams',
            $options
        ));

        // SCHOOL DATA SYNC (SDS) PAGE.
        $sdssettings = new admin_settingpage(
            'local_o365_sds',
            get_string('settings_header_sds', 'local_o365')
        );
        $ADMIN->add('local_o365_folder', $sdssettings);
        $sdssettings->add(new admin_setting_heading(
            'local_o365_sds_nav',
            '',
            local_o365_get_settings_nav_html('local_o365_sds')
        ));

        $scheduledtasks = new url('/admin/tool/task/scheduledtasks.php');
        $desc = new lang_string('settings_sds_intro_previewwarning', 'local_o365');
        $desc .= new lang_string('settings_sds_intro_desc', 'local_o365', $scheduledtasks->out());
        $sdssettings->add(new admin_setting_heading('local_o365_sds_intro', '', $desc));

        $apiclient = \local_o365\feature\sds\utils::get_apiclient();
        if ($apiclient) {
            try {
                $schools = $apiclient->get_schools();

                if (!empty($schools)) {
                    // SDS course sync school selector header.
                    $label = new lang_string('settings_sds_coursecreation', 'local_o365');
                    $desc = new lang_string('settings_sds_coursecreation_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_heading('local_o365_sds_coursecreation', $label, $desc));

                    $label = new lang_string('settings_sds_coursecreation_enabled', 'local_o365');
                    $desc = new lang_string('settings_sds_coursecreation_enabled_desc', 'local_o365');
                    $coursesyncdefault = [];
                    $coursesynchoices = [];
                    $profilesyncchoices = [];
                    foreach ($schools as $school) {
                        $coursesynchoices[$school['id']] = $school['displayName'];
                        $profilesyncchoices[$school['id']] = $school['displayName'] . ' (' . $school['id'] . ')';
                    }

                    $sdssettings->add(new admin_setting_configmulticheckbox(
                        'local_o365/sdsschools',
                        $label,
                        $desc,
                        $coursesyncdefault,
                        $coursesynchoices
                    ));

                    $label = new lang_string('settings_sds_teams_enabled', 'local_o365');
                    $desc = new lang_string('settings_sds_teams_enabled_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configcheckbox('local_o365/sdsteamsenabled', $label, $desc, '0'));

                    $schooldisabledactionoptions = [
                        SDS_SCHOOL_DISABLED_ACTION_KEEP_CONNECTED => get_string(
                            'settings_sds_school_disabled_action_keep_connected',
                            'local_o365'
                        ),
                        SDS_SCHOOL_DISABLED_ACTION_DISCONNECT => get_string(
                            'settings_sds_school_disabled_action_disconnect',
                            'local_o365'
                        ),
                    ];
                    $label = new lang_string('settings_sds_school_disabled_action', 'local_o365');
                    $desc = new lang_string('settings_sds_school_disabled_action_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configselect(
                        'local_o365/sdsschooldisabledaction',
                        $label,
                        $desc,
                        SDS_SCHOOL_DISABLED_ACTION_KEEP_CONNECTED,
                        $schooldisabledactionoptions
                    ));

                    // SDS categorize by subject.
                    $label = new lang_string('settings_sds_categorize_by_subject', 'local_o365');
                    $desc = new lang_string('settings_sds_categorize_by_subject_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configcheckbox('local_o365/sdscategorizebysubject', $label, $desc, '0'));

                    // SDS ignore past courses.
                    $label = new lang_string('settings_sds_ignore_past_courses', 'local_o365');
                    $desc = new lang_string('settings_sds_ignore_past_courses_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configcheckbox('local_o365/sdsignorepastclasses', $label, $desc, '0'));

                    // SDS expired course prefix.
                    $label = new lang_string('settings_sds_expired_course_prefix', 'local_o365');
                    $desc = new lang_string('settings_sds_expired_course_prefix_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configtext(
                        'local_o365/sdsexpiredprefix',
                        $label,
                        $desc,
                        'Exp',
                        PARAM_TEXT
                    ));
                    $sdssettings->hide_if(
                        'local_o365/sdsexpiredprefix',
                        'local_o365/sdsignorepastclasses',
                        'notchecked'
                    );

                    // SDS cohort sync header.
                    $label = new lang_string('settings_sds_cohortsync', 'local_o365');
                    $desc = new lang_string('settings_sds_cohortsync_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_heading('local_o365_sds_cohortsync', $label, $desc));

                    // SDS create cohorts.
                    $label = new lang_string('settings_sds_create_cohorts', 'local_o365');
                    $desc = new lang_string('settings_sds_create_cohorts_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configcheckbox('local_o365/sdscreatecohorts', $label, $desc, '0'));

                    // SDS cohort include teachers.
                    $label = new lang_string('settings_sds_cohort_include_teachers', 'local_o365');
                    $desc = new lang_string('settings_sds_cohort_include_teachers_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configcheckbox('local_o365/sdscohortincludeteachers', $label, $desc, '0'));

                    $label = new lang_string('settings_sds_courseenrolsync', 'local_o365');
                    $desc = new lang_string('settings_sds_courseenrolsync_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_heading('local_o365_sds_courseenrolsync', $label, $desc));

                    // SDS to Moodle enrolment sync.
                    $label = new lang_string('settings_sds_enrolment_enabled', 'local_o365');
                    $desc = new lang_string('settings_sds_enrolment_enabled_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configcheckbox(
                        'local_o365/sdsenrolmentenabled',
                        $label,
                        $desc,
                        '1'
                    ));

                    // Moodle to SDS enrolment sync.
                    $label = new lang_string('settings_sds_sync_enrolment_to_sds', 'local_o365');
                    $desc = new lang_string('settings_sds_sync_enrolment_to_sds_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configcheckbox(
                        'local_o365/sdssyncenrolmenttosds',
                        $label,
                        $desc,
                        '0'
                    ));

                    // SDS enrolment suspension setting.
                    $label = new lang_string('settings_sds_suspend_enrolment', 'local_o365');
                    $desc = new lang_string('settings_sds_suspend_enrolment_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configcheckbox('local_o365/sdssuspendenrolment', $label, $desc, '1'));

                    // SDS two-way course sync setting.
                    $label = new lang_string('settings_sds_enable_course_sync', 'local_o365');
                    $desc = new lang_string('settings_sds_enable_course_sync_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configcheckbox('local_o365/sdsenablecoursesync', $label, $desc, '0'));

                    $label = new lang_string('settings_sds_enrolment_teacher_role', 'local_o365');
                    $desc = new lang_string('settings_sds_enrolment_teacher_role_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configselect(
                        'local_o365/sdsenrolmentteacherrole',
                        $label,
                        $desc,
                        3,
                        $courseroleoptions
                    ));

                    $label = new lang_string('settings_sds_enrolment_student_role', 'local_o365');
                    $desc = new lang_string('settings_sds_enrolment_student_role_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configselect(
                        'local_o365/sdsenrolmentstudentrole',
                        $label,
                        $desc,
                        5,
                        $courseroleoptions
                    ));

                    $label = new lang_string('settings_sds_profilesync_header', 'local_o365');
                    $desc = new lang_string('settings_sds_profilesync_header_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_heading('local_o365_sds_profilesync_header', $label, $desc));

                    asort($profilesyncchoices);
                    $profilesyncchoices = ['' => new lang_string('settings_sds_profilesync_disabled', 'local_o365')]
                        + $profilesyncchoices;

                    $label = new lang_string('settings_sds_profilesync', 'local_o365');
                    $desc = new lang_string('settings_sds_profilesync_desc', 'local_o365');
                    $sdssettings->add(new admin_setting_configselect(
                        'local_o365/sdsprofilesync',
                        $label,
                        $desc,
                        '0',
                        $profilesyncchoices
                    ));
                } else {
                    $desc = new lang_string('settings_sds_noschools', 'local_o365');
                    $sdssettings->add(new admin_setting_heading('local_o365_sds_noschools', '', $desc));
                }
            } catch (moodle_exception $e) {
                $desc = new lang_string('settings_sds_get_schools_error', 'local_o365');
                $sdssettings->add(new admin_setting_heading('local_o365_sds_get_schools_error', '', $desc));
            }
        }

        // TEAMS PAGE.
        $teamssettings = new admin_settingpage(
            'local_o365_teams',
            get_string('settings_header_teams', 'local_o365')
        );
        $ADMIN->add('local_o365_folder', $teamssettings);
        $teamssettings->add(new admin_setting_heading(
            'local_o365_teams_nav',
            '',
            local_o365_get_settings_nav_html('local_o365_teams')
        ));

        // Banner.
        $bannerhtml = html_writer::start_div('local_o365_settings_teams_banner_part_1', ['id' => 'admin-teams-banner']);
        $bannerhtml .= html_writer::img(
            new url('/local/o365/pix/teams_app.png'),
            '',
            ['class' => 'x-hidden-focus force-vertical-align local_o365_settings_teams_app_img']
        );
        $bannerhtml .= html_writer::start_tag('p');
        $bannerhtml .= get_string('settings_teams_banner', 'local_o365');
        $bannerhtml .= html_writer::empty_tag('br');
        $bannerhtml .= html_writer::end_tag('p');
        $bannerhtml .= html_writer::end_div();
        $teamssettings->add(new admin_setting_heading('local_o365/teams_setting_banner', '', $bannerhtml));

        $teamssettings->add(new admin_setting_heading(
            'local_o365/teams_setting_moodle_setup_heading',
            '',
            get_string('settings_teams_moodle_setup_heading', 'local_o365')
        ));

        $label = new lang_string('settings_moodlesettingssetup', 'local_o365');
        $desc = new lang_string('settings_moodlesettingssetup_details', 'local_o365');
        $teamssettings->add(new moodlesetup('local_o365/moodlesetup', $label, $desc));

        $teamssettings->add(new admin_setting_configtext(
            'local_o365/teams_moodle_app_external_id',
            get_string('settings_teams_moodle_app_external_id', 'local_o365'),
            get_string('settings_teams_moodle_app_external_id_desc', 'local_o365'),
            TEAMS_MOODLE_APP_EXTERNAL_ID
        ));

        $teamssettings->add(new admin_setting_configtext(
            'local_o365/teams_moodle_app_short_name',
            get_string('settings_teams_moodle_app_short_name', 'local_o365'),
            get_string('settings_teams_moodle_app_short_name_desc', 'local_o365'),
            'Moodle'
        ));

        $teamssettings->add(new admin_setting_configtext(
            'local_o365/teams_moodle_tab_name',
            get_string('settings_teams_moodle_tab_name', 'local_o365'),
            get_string('settings_teams_moodle_tab_name_desc', 'local_o365'),
            'Moodle'
        ));

        // Manifest download link (informational heading).
        $downloadmanifesthtml = html_writer::start_div('local_o365_settings_manifest_container');
        $downloadmanifesthtml .= html_writer::start_tag('p');
        $manifesturl = new url('/local/o365/export_manifest.php');
        $downloadmanifesthtml .= html_writer::link(
            $manifesturl,
            get_string('settings_download_teams_tab_app_manifest', 'local_o365'),
            ['class' => 'btn btn-primary']
        );
        $downloadmanifesthtml .= html_writer::end_tag('p');
        $downloadmanifesthtml .= html_writer::start_tag('p');
        $downloadmanifesthtml .= get_string('settings_download_teams_tab_app_manifest_reminder', 'local_o365');
        $downloadmanifesthtml .= html_writer::end_tag('p');
        $downloadmanifesthtml .= html_writer::start_tag('p');
        $downloadmanifesthtml .= get_string('settings_publish_manifest_instruction', 'local_o365');
        $downloadmanifesthtml .= html_writer::end_tag('p');
        $downloadmanifesthtml .= html_writer::end_div();
        $teamssettings->add(new admin_setting_heading('download_manifest_header', '', $downloadmanifesthtml));

        // MOODLE APP PAGE (conditional on feature flag).
        if (local_o365_show_teams_moodle_app_id_tab()) {
            $moodleappsettings = new admin_settingpage(
                'local_o365_moodle_app',
                get_string('settings_header_moodle_app', 'local_o365')
            );
            $ADMIN->add('local_o365_folder', $moodleappsettings);
            $moodleappsettings->add(new admin_setting_heading(
                'local_o365_moodle_app_nav',
                '',
                local_o365_get_settings_nav_html('local_o365_moodle_app')
            ));

            $moodleappiddescription = get_string('settings_moodle_app_id_desc', 'local_o365');
            if (\local_o365\utils::is_connected() === true) {
                $graphclient = \local_o365\utils::get_api();
                if ($graphclient) {
                    $teamsmoodleappexternalid = get_config('local_o365', 'teams_moodle_app_external_id');
                    if (!$teamsmoodleappexternalid) {
                        $teamsmoodleappexternalid = TEAMS_MOODLE_APP_EXTERNAL_ID;
                    }
                    $moodleappid = '';
                    try {
                        $moodleappid = $graphclient->get_catalog_app_id($teamsmoodleappexternalid);
                    } catch (moodle_exception $e) {
                        debugging('Error getting catalog app ID. Details: ' . $e->getMessage(), DEBUG_NORMAL);
                    }
                    if ($moodleappid) {
                        $moodleappiddescription .= get_string(
                            'settings_moodle_app_id_desc_auto_id',
                            'local_o365',
                            $moodleappid
                        );
                    }
                }
            }

            $moodleappsettings->add(new admin_setting_configtext(
                'local_o365/moodle_app_id',
                get_string('settings_moodle_app_id', 'local_o365'),
                $moodleappiddescription,
                '',
                PARAM_TEXT,
                36
            ));

            if (\local_o365\utils::is_connected() === true) {
                $setmoodleappidinstructionhtml = html_writer::start_tag('p');
                $setmoodleappidinstructionhtml .= get_string('settings_set_moodle_app_id_instruction', 'local_o365');
                $setmoodleappidinstructionhtml .= html_writer::end_tag('p');
                $setmoodleappidinstructionhtml .= html_writer::empty_tag('br');
                $setmoodleappidinstructionhtml .= html_writer::img(
                    new \core\url('/local/o365/pix/moodle_app_id.png'),
                    '',
                    ['class' => 'x-hidden-focus force-vertical-align local_o365_settings_moodle_app_id_img']
                );
                $moodleappsettings->add(new admin_setting_heading(
                    'set_moodle_app_id_instruction_header',
                    '',
                    $setmoodleappidinstructionhtml
                ));
            }
        }
    }
}

$settings = null;
