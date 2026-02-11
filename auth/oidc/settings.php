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
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

use auth_oidc\adminsetting\auth_oidc_admin_setting_endpoint;
use auth_oidc\adminsetting\auth_oidc_admin_setting_iconselect;
use auth_oidc\adminsetting\auth_oidc_admin_setting_loginflow;
use auth_oidc\adminsetting\auth_oidc_admin_setting_redirecturi;
use auth_oidc\utils;

require_once($CFG->dirroot . '/auth/oidc/lib.php');

if ($hassiteconfig) {
    // Add folder for OIDC settings.
    $oidcfolder = new admin_category('oidcfolder', get_string('pluginname', 'auth_oidc'));
    $ADMIN->add('authsettings', $oidcfolder);

    // Application configuration settings page.
    $applicationsettings = new admin_settingpage(
        'auth_oidc_application',
        get_string('settings_page_application', 'auth_oidc')
    );

    // Link to the guided Application Configuration Wizard.
    $wizardurl = new moodle_url('/auth/oidc/manageapplication.php');
    $applicationsettings->add(new admin_setting_description(
        'auth_oidc/application_wizard_link',
        '',
        get_string('settings_application_wizard_desc', 'auth_oidc', $wizardurl->out())
    ));

    // Basic settings heading.
    $applicationsettings->add(new admin_setting_heading(
        'auth_oidc/application_basic_heading',
        get_string('settings_section_basic', 'auth_oidc'),
        ''
    ));

    // IdP type.
    $idptypeoptions = [
        AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID => get_string('idp_type_microsoft_entra_id', 'auth_oidc'),
        AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM => get_string('idp_type_microsoft_identity_platform', 'auth_oidc'),
        AUTH_OIDC_IDP_TYPE_OTHER => get_string('idp_type_other', 'auth_oidc'),
    ];
    $idptypesetting = new admin_setting_configselect(
        'auth_oidc/idptype',
        get_string('idptype', 'auth_oidc'),
        get_string('idptype_help', 'auth_oidc'),
        AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID,
        $idptypeoptions
    );
    $idptypesetting->set_updatedcallback('auth_oidc_reset_app_tokens');
    $applicationsettings->add($idptypesetting);

    // Client ID.
    $clientidsetting = new admin_setting_configtext(
        'auth_oidc/clientid',
        get_string('clientid', 'auth_oidc'),
        get_string('clientid_help', 'auth_oidc'),
        '',
        PARAM_TEXT
    );
    $clientidsetting->set_updatedcallback('auth_oidc_reset_app_tokens');
    $applicationsettings->add($clientidsetting);

    // Authentication heading.
    $applicationsettings->add(new admin_setting_heading(
        'auth_oidc/application_auth_heading',
        get_string('settings_section_authentication', 'auth_oidc'),
        ''
    ));

    // Client authentication method.
    $clientauthmethoptions = [
        AUTH_OIDC_AUTH_METHOD_SECRET => get_string('auth_method_secret', 'auth_oidc'),
        AUTH_OIDC_AUTH_METHOD_CERTIFICATE => get_string('auth_method_certificate', 'auth_oidc'),
    ];
    $clientauthmethodsetting = new admin_setting_configselect(
        'auth_oidc/clientauthmethod',
        get_string('clientauthmethod', 'auth_oidc'),
        get_string('clientauthmethod_help', 'auth_oidc'),
        AUTH_OIDC_AUTH_METHOD_SECRET,
        $clientauthmethoptions
    );
    $clientauthmethodsetting->set_updatedcallback('auth_oidc_reset_app_tokens');
    $applicationsettings->add($clientauthmethodsetting);

    // Client secret.
    $clientsecretsetting = new admin_setting_configpasswordunmask(
        'auth_oidc/clientsecret',
        get_string('clientsecret', 'auth_oidc'),
        get_string('clientsecret_help', 'auth_oidc'),
        ''
    );
    $clientsecretsetting->set_updatedcallback('auth_oidc_reset_app_tokens');
    $applicationsettings->add($clientsecretsetting);

    // Certificate source.
    $certsourceoptions = [
        AUTH_OIDC_AUTH_CERT_SOURCE_TEXT => get_string('cert_source_text', 'auth_oidc'),
        AUTH_OIDC_AUTH_CERT_SOURCE_FILE => get_string('cert_source_path', 'auth_oidc'),
    ];
    $applicationsettings->add(new admin_setting_configselect(
        'auth_oidc/clientcertsource',
        get_string('clientcertsource', 'auth_oidc'),
        get_string('clientcertsource_help', 'auth_oidc'),
        AUTH_OIDC_AUTH_CERT_SOURCE_TEXT,
        $certsourceoptions
    ));

    // Client certificate private key (plain text).
    $applicationsettings->add(new admin_setting_configtextarea(
        'auth_oidc/clientprivatekey',
        get_string('clientprivatekey', 'auth_oidc'),
        get_string('clientprivatekey_help', 'auth_oidc'),
        '',
        PARAM_TEXT
    ));

    // Client certificate public key (plain text).
    $applicationsettings->add(new admin_setting_configtextarea(
        'auth_oidc/clientcert',
        get_string('clientcert', 'auth_oidc'),
        get_string('clientcert_help', 'auth_oidc'),
        '',
        PARAM_TEXT
    ));

    // Client certificate private key file name.
    $applicationsettings->add(new admin_setting_configtext(
        'auth_oidc/clientprivatekeyfile',
        get_string('clientprivatekeyfile', 'auth_oidc'),
        get_string('clientprivatekeyfile_help', 'auth_oidc'),
        '',
        PARAM_FILE
    ));

    // Client certificate public key file name.
    $applicationsettings->add(new admin_setting_configtext(
        'auth_oidc/clientcertfile',
        get_string('clientcertfile', 'auth_oidc'),
        get_string('clientcertfile_help', 'auth_oidc'),
        '',
        PARAM_FILE
    ));

    // Client certificate passphrase.
    $applicationsettings->add(new admin_setting_configpasswordunmask(
        'auth_oidc/clientcertpassphrase',
        get_string('clientcertpassphrase', 'auth_oidc'),
        get_string('clientcertpassphrase_help', 'auth_oidc'),
        ''
    ));

    // Endpoints heading.
    $applicationsettings->add(new admin_setting_heading(
        'auth_oidc/application_endpoints_heading',
        get_string('settings_section_endpoints', 'auth_oidc'),
        ''
    ));

    // Authorization endpoint.
    $authendpointsetting = new auth_oidc_admin_setting_endpoint(
        'auth_oidc/authendpoint',
        get_string('authendpoint', 'auth_oidc'),
        get_string('authendpoint_help', 'auth_oidc'),
        'https://login.microsoftonline.com/organizations/oauth2/authorize',
        'auth'
    );
    $authendpointsetting->set_updatedcallback('auth_oidc_reset_app_tokens');
    $applicationsettings->add($authendpointsetting);

    // Token endpoint.
    $tokenendpointsetting = new auth_oidc_admin_setting_endpoint(
        'auth_oidc/tokenendpoint',
        get_string('tokenendpoint', 'auth_oidc'),
        get_string('tokenendpoint_help', 'auth_oidc'),
        'https://login.microsoftonline.com/organizations/oauth2/token',
        'token'
    );
    $tokenendpointsetting->set_updatedcallback('auth_oidc_reset_app_tokens');
    $applicationsettings->add($tokenendpointsetting);

    // Other parameters heading.
    $applicationsettings->add(new admin_setting_heading(
        'auth_oidc/application_otherparams_heading',
        get_string('settings_section_other_params', 'auth_oidc'),
        ''
    ));

    // OIDC resource.
    $oidcresourcesetting = new admin_setting_configtext(
        'auth_oidc/oidcresource',
        get_string('oidcresource', 'auth_oidc'),
        get_string('oidcresource_help', 'auth_oidc'),
        'https://graph.microsoft.com',
        PARAM_TEXT
    );
    $oidcresourcesetting->set_updatedcallback('auth_oidc_reset_app_tokens');
    $applicationsettings->add($oidcresourcesetting);

    // OIDC scope.
    $oidcscopesetting = new admin_setting_configtext(
        'auth_oidc/oidcscope',
        get_string('oidcscope', 'auth_oidc'),
        get_string('oidcscope_help', 'auth_oidc'),
        'openid profile email',
        PARAM_TEXT
    );
    $oidcscopesetting->set_updatedcallback('auth_oidc_reset_app_tokens');
    $applicationsettings->add($oidcscopesetting);

    // Secret expiry notification (only when local_o365 is installed).
    if (auth_oidc_is_local_365_installed()) {
        $applicationsettings->add(new admin_setting_heading(
            'auth_oidc/application_secretexpiry_heading',
            get_string('settings_section_secret_expiry_notification', 'auth_oidc'),
            ''
        ));

        $applicationsettings->add(new admin_setting_configtext(
            'auth_oidc/secretexpiryrecipients',
            get_string('secretexpiryrecipients', 'auth_oidc'),
            get_string('secretexpiryrecipients_help', 'auth_oidc'),
            '',
            PARAM_TEXT
        ));
    }

    // Conditional display: show secret field only when auth method is "secret".
    $applicationsettings->hide_if(
        'auth_oidc/clientsecret', 'auth_oidc/clientauthmethod', 'neq', AUTH_OIDC_AUTH_METHOD_SECRET
    );

    // Conditional display: show certificate fields only when auth method is "certificate".
    $applicationsettings->hide_if(
        'auth_oidc/clientcertsource', 'auth_oidc/clientauthmethod', 'neq', AUTH_OIDC_AUTH_METHOD_CERTIFICATE
    );
    $applicationsettings->hide_if(
        'auth_oidc/clientcertpassphrase', 'auth_oidc/clientauthmethod', 'neq', AUTH_OIDC_AUTH_METHOD_CERTIFICATE
    );

    // Conditional display: certificate text fields only when cert source is "text".
    $applicationsettings->hide_if(
        'auth_oidc/clientprivatekey', 'auth_oidc/clientauthmethod', 'neq', AUTH_OIDC_AUTH_METHOD_CERTIFICATE
    );
    $applicationsettings->hide_if(
        'auth_oidc/clientprivatekey', 'auth_oidc/clientcertsource', 'neq', AUTH_OIDC_AUTH_CERT_SOURCE_TEXT
    );
    $applicationsettings->hide_if(
        'auth_oidc/clientcert', 'auth_oidc/clientauthmethod', 'neq', AUTH_OIDC_AUTH_METHOD_CERTIFICATE
    );
    $applicationsettings->hide_if(
        'auth_oidc/clientcert', 'auth_oidc/clientcertsource', 'neq', AUTH_OIDC_AUTH_CERT_SOURCE_TEXT
    );

    // Conditional display: certificate file fields only when cert source is "file".
    $applicationsettings->hide_if(
        'auth_oidc/clientprivatekeyfile', 'auth_oidc/clientauthmethod', 'neq', AUTH_OIDC_AUTH_METHOD_CERTIFICATE
    );
    $applicationsettings->hide_if(
        'auth_oidc/clientprivatekeyfile', 'auth_oidc/clientcertsource', 'neq', AUTH_OIDC_AUTH_CERT_SOURCE_FILE
    );
    $applicationsettings->hide_if(
        'auth_oidc/clientcertfile', 'auth_oidc/clientauthmethod', 'neq', AUTH_OIDC_AUTH_METHOD_CERTIFICATE
    );
    $applicationsettings->hide_if(
        'auth_oidc/clientcertfile', 'auth_oidc/clientcertsource', 'neq', AUTH_OIDC_AUTH_CERT_SOURCE_FILE
    );

    // Conditional display: secret expiry recipients only for non-OTHER Microsoft IdP using secret auth.
    if (auth_oidc_is_local_365_installed()) {
        $applicationsettings->hide_if(
            'auth_oidc/secretexpiryrecipients', 'auth_oidc/clientauthmethod', 'neq', AUTH_OIDC_AUTH_METHOD_SECRET
        );
        $applicationsettings->hide_if(
            'auth_oidc/secretexpiryrecipients', 'auth_oidc/idptype', 'eq', AUTH_OIDC_IDP_TYPE_OTHER
        );
    }

    $ADMIN->add('oidcfolder', $applicationsettings);

    $idptype = get_config('auth_oidc', 'idptype');
    if ($idptype) {
        // Binding username claim settings page.
        $bindingusernamesettings = new admin_settingpage(
            'auth_oidc_binding_username_claim',
            get_string('settings_page_binding_username_claim', 'auth_oidc')
        );

        // Determine options and description based on IdP type and user sync state.
        switch ($idptype) {
            case AUTH_OIDC_IDP_TYPE_OTHER:
                $bindingclaimdesc = 'binding_username_claim_help_non_ms';
                $bindingusernameoptions = [
                    'auto' => get_string('binding_username_auto', 'auth_oidc'),
                    'preferred_username' => 'preferred_username',
                    'email' => 'email',
                    'unique_name' => 'unique_name',
                    'sub' => 'sub',
                    'samaccountname' => 'samaccountname',
                    'custom' => get_string('binding_username_custom', 'auth_oidc'),
                ];
                break;
            case AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM:
            case AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID:
                if (auth_oidc_is_local_365_installed() && auth_oidc_is_user_sync_enabled()) {
                    $bindingclaimdesc = 'binding_username_claim_help_ms_with_user_sync';
                    $bindingusernameoptions = [
                        'auto' => get_string('binding_username_auto', 'auth_oidc'),
                        'email' => 'email',
                        'upn' => 'upn',
                        'oid' => 'oid',
                        'samaccountname' => 'samaccountname',
                    ];
                } else {
                    $bindingclaimdesc = 'binding_username_claim_help_ms_no_user_sync';
                    $bindingusernameoptions = [
                        'auto' => get_string('binding_username_auto', 'auth_oidc'),
                        'preferred_username' => 'preferred_username',
                        'email' => 'email',
                        'upn' => 'upn',
                        'unique_name' => 'unique_name',
                        'oid' => 'oid',
                        'sub' => 'sub',
                        'samaccountname' => 'samaccountname',
                        'custom' => get_string('binding_username_custom', 'auth_oidc'),
                    ];
                }
                break;
            default:
                $bindingclaimdesc = 'binding_username_claim_help_ms_no_user_sync';
                $bindingusernameoptions = [
                    'auto' => get_string('binding_username_auto', 'auth_oidc'),
                    'preferred_username' => 'preferred_username',
                    'email' => 'email',
                    'upn' => 'upn',
                    'unique_name' => 'unique_name',
                    'sub' => 'sub',
                    'oid' => 'oid',
                    'samaccountname' => 'samaccountname',
                    'custom' => get_string('binding_username_custom', 'auth_oidc'),
                ];
        }

        $bindingusernamesettings->add(new admin_setting_configselect(
            'auth_oidc/bindingusernameclaim',
            get_string('bindingusernameclaim', 'auth_oidc'),
            get_string($bindingclaimdesc, 'auth_oidc'),
            'auto',
            $bindingusernameoptions
        ));

        // Custom claim name (only when the 'custom' option is available for the current IdP type).
        if (array_key_exists('custom', $bindingusernameoptions)) {
            $bindingusernamesettings->add(new admin_setting_configtext(
                'auth_oidc/customclaimname',
                get_string('customclaimname', 'auth_oidc'),
                get_string('customclaimname_description', 'auth_oidc'),
                '',
                PARAM_TEXT
            ));
        }

        $ADMIN->add('oidcfolder', $bindingusernamesettings);

        // Change binding username claim tool page (bulk migration tool, not a settings page).
        $ADMIN->add('oidcfolder', new admin_externalpage(
            'auth_oidc_change_binding_username_claim_tool',
            get_string('settings_page_change_binding_username_claim_tool', 'auth_oidc'),
            new moodle_url('/auth/oidc/change_binding_username_claim_tool.php')
        ));
    }

    // Other settings page and its settings.
    $settings = new admin_settingpage($section, get_string('settings_page_other_settings', 'auth_oidc'));

    // Basic heading.
    $settings->add(new admin_setting_heading(
        'auth_oidc/basic_heading',
        get_string('heading_basic', 'auth_oidc'),
        get_string('heading_basic_desc', 'auth_oidc')
    ));

    // Redirect URI.
    $settings->add(new auth_oidc_admin_setting_redirecturi(
        'auth_oidc/redirecturi',
        get_string('cfg_redirecturi_key', 'auth_oidc'),
        get_string('cfg_redirecturi_desc', 'auth_oidc'),
        utils::get_redirecturl()
    ));


    // Additional options heading.
    $settings->add(new admin_setting_heading(
        'auth_oidc/additional_options_heading',
        get_string('heading_additional_options', 'auth_oidc'),
        get_string('heading_additional_options_desc', 'auth_oidc')
    ));

    // Force redirect.
    $settings->add(new admin_setting_configcheckbox(
        'auth_oidc/forceredirect',
        get_string('cfg_forceredirect_key', 'auth_oidc'),
        get_string('cfg_forceredirect_desc', 'auth_oidc'),
        0
    ));

    // Silent login mode.
    $forceloginconfigurl = new moodle_url('/admin/settings.php', ['section' => 'sitepolicies']);
    $settings->add(new admin_setting_configcheckbox(
        'auth_oidc/silentloginmode',
        get_string('cfg_silentloginmode_key', 'auth_oidc'),
        get_string('cfg_silentloginmode_desc', 'auth_oidc', $forceloginconfigurl->out(false)),
        0
    ));

    // Auto-append.
    $settings->add(new admin_setting_configtext(
        'auth_oidc/autoappend',
        get_string('cfg_autoappend_key', 'auth_oidc'),
        get_string('cfg_autoappend_desc', 'auth_oidc'),
        '',
        PARAM_TEXT
    ));

    // Domain hint.
    $settings->add(new admin_setting_configtext(
        'auth_oidc/domainhint',
        get_string('cfg_domainhint_key', 'auth_oidc'),
        get_string('cfg_domainhint_desc', 'auth_oidc'),
        '',
        PARAM_TEXT
    ));

    // Login flow.
    $settings->add(new auth_oidc_admin_setting_loginflow(
        'auth_oidc/loginflow',
        get_string('cfg_loginflow_key', 'auth_oidc'),
        '',
        'authcode'
    ));

    // User restrictions heading.
    $settings->add(new admin_setting_heading(
        'auth_oidc/user_restrictions_heading',
        get_string('heading_user_restrictions', 'auth_oidc'),
        get_string('heading_user_restrictions_desc', 'auth_oidc')
    ));

    // User restrictions.
    $settings->add(new admin_setting_configtextarea(
        'auth_oidc/userrestrictions',
        get_string('cfg_userrestrictions_key', 'auth_oidc'),
        get_string('cfg_userrestrictions_desc', 'auth_oidc'),
        '',
        PARAM_TEXT
    ));

    // User restrictions case sensitivity.
    $settings->add(new admin_setting_configcheckbox(
        'auth_oidc/userrestrictionscasesensitive',
        get_string('cfg_userrestrictionscasesensitive_key', 'auth_oidc'),
        get_string('cfg_userrestrictionscasesensitive_desc', 'auth_oidc'),
        '1'
    ));

    // Sign out integration heading.
    $settings->add(new admin_setting_heading(
        'auth_oidc/sign_out_heading',
        get_string('heading_sign_out', 'auth_oidc'),
        get_string('heading_sign_out_desc', 'auth_oidc')
    ));

    // Single sign out from Moodle to IdP.
    $settings->add(new admin_setting_configcheckbox(
        'auth_oidc/single_sign_off',
        get_string('cfg_signoffintegration_key', 'auth_oidc'),
        get_string('cfg_signoffintegration_desc', 'auth_oidc', $CFG->wwwroot),
        '0'
    ));

    // IdP logout endpoint.
    $settings->add(new admin_setting_configtext(
        'auth_oidc/logouturi',
        get_string('cfg_logoutendpoint_key', 'auth_oidc'),
        get_string('cfg_logoutendpoint_desc', 'auth_oidc'),
        'https://login.microsoftonline.com/organizations/oauth2/logout',
        PARAM_URL
    ));

    // Front channel logout URL.
    $settings->add(new auth_oidc_admin_setting_redirecturi(
        'auth_oidc/logoutendpoint',
        get_string('cfg_frontchannellogouturl_key', 'auth_oidc'),
        get_string('cfg_frontchannellogouturl_desc', 'auth_oidc'),
        utils::get_frontchannellogouturl()
    ));

    // Display heading.
    $settings->add(new admin_setting_heading(
        'auth_oidc/display_heading',
        get_string('heading_display', 'auth_oidc'),
        get_string('heading_display_desc', 'auth_oidc')
    ));

    // Provider Name (opname).
    $settings->add(new admin_setting_configtext(
        'auth_oidc/opname',
        get_string('cfg_opname_key', 'auth_oidc'),
        get_string('cfg_opname_desc', 'auth_oidc'),
        get_string('pluginname', 'auth_oidc'),
        PARAM_TEXT
    ));

    // Icon.
    $icons = [
        [
            'pix' => 'o365',
            'alt' => new lang_string('cfg_iconalt_o365', 'auth_oidc'),
            'component' => 'auth_oidc',
        ],
        [
            'pix' => 't/locked',
            'alt' => new lang_string('cfg_iconalt_locked', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 't/lock',
            'alt' => new lang_string('cfg_iconalt_lock', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 't/go',
            'alt' => new lang_string('cfg_iconalt_go', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 't/stop',
            'alt' => new lang_string('cfg_iconalt_stop', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 't/user',
            'alt' => new lang_string('cfg_iconalt_user', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 'u/user35',
            'alt' => new lang_string('cfg_iconalt_user2', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 'i/permissions',
            'alt' => new lang_string('cfg_iconalt_key', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 'i/cohort',
            'alt' => new lang_string('cfg_iconalt_group', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 'i/groups',
            'alt' => new lang_string('cfg_iconalt_group2', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 'i/mnethost',
            'alt' => new lang_string('cfg_iconalt_mnet', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 'i/permissionlock',
            'alt' => new lang_string('cfg_iconalt_userlock', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 't/more',
            'alt' => new lang_string('cfg_iconalt_plus', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 't/approve',
            'alt' => new lang_string('cfg_iconalt_check', 'auth_oidc'),
            'component' => 'moodle',
        ],
        [
            'pix' => 't/right',
            'alt' => new lang_string('cfg_iconalt_rightarrow', 'auth_oidc'),
            'component' => 'moodle',
        ],
    ];
    $settings->add(new auth_oidc_admin_setting_iconselect(
        'auth_oidc/icon',
        get_string('cfg_icon_key', 'auth_oidc'),
        get_string('cfg_icon_desc', 'auth_oidc'),
        'auth_oidc:o365',
        $icons
    ));

    // Custom icon.
    $configkey = new lang_string('cfg_customicon_key', 'auth_oidc');
    $configdesc = new lang_string('cfg_customicon_desc', 'auth_oidc');
    $customiconsetting = new admin_setting_configstoredfile(
        'auth_oidc/customicon',
        get_string('cfg_customicon_key', 'auth_oidc'),
        get_string('cfg_customicon_desc', 'auth_oidc'),
        'customicon',
        0,
        ['accepted_types' => ['.png', '.jpg', '.ico'], 'maxbytes' => get_max_upload_file_size()]
    );
    $customiconsetting->set_updatedcallback('auth_oidc_initialize_customicon');
    $settings->add($customiconsetting);

    // Debugging heading.
    $settings->add(new admin_setting_heading(
        'auth_oidc/debugging_heading',
        get_string('heading_debugging', 'auth_oidc'),
        get_string('heading_debugging_desc', 'auth_oidc')
    ));

    // Record debugging messages.
    $settings->add(new admin_setting_configcheckbox(
        'auth_oidc/debugmode',
        get_string('cfg_debugmode_key', 'auth_oidc'),
        get_string('cfg_debugmode_desc', 'auth_oidc'),
        '0'
    ));

    $ADMIN->add('oidcfolder', $settings);

    // Cleanup OIDC tokens page.
    $ADMIN->add('oidcfolder', new admin_externalpage(
        'auth_oidc_cleanup_oidc_tokens',
        get_string('settings_page_cleanup_oidc_tokens', 'auth_oidc'),
        new moodle_url('/auth/oidc/cleanupoidctokens.php')
    ));

    // Other settings page and its settings.
    $fieldmappingspage = new admin_settingpage('auth_oidc_field_mapping', get_string('settings_page_field_mapping', 'auth_oidc'));
    $ADMIN->add('oidcfolder', $fieldmappingspage);

    // Display locking / mapping of profile fields.
    $authplugin = get_auth_plugin('oidc');
    auth_oidc_display_auth_lock_options(
        $fieldmappingspage,
        $authplugin->authtype,
        $authplugin->userfields,
        get_string('cfg_field_mapping_desc', 'auth_oidc'),
        true,
        false,
        $authplugin->get_custom_user_profile_fields()
    );
}

$settings = null;
