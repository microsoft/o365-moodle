<?php
// This file is part of Oauth2 authentication plugin for Moodle.
//
// Oauth2 authentication plugin for Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Oauth2 authentication plugin for Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Oauth2 authentication plugin for Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file contains lib functions for the Oauth2 authentication plugin.
 *
 * @package   auth_googleoauth2
 * @copyright 2013 Jerome Mouneyrac {@link http://jerome.mouneyrac.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Get (generate) session state token.
 *
 * @return string the state token.
 */
function auth_googleoauth2_get_state_token() {
    // Create a state token to prevent request forgery.
    // Store it in the session for later validation.
    $state = md5(rand());
    $_SESSION['STATETOKEN'] = $state;
    return $state;
}

/**
 * The very ugly code to display the buttons.
 * It's been moved quickly here from the README.md to make it easy for people to add the code into login/index_form.php
 */
function auth_googleoauth2_display_buttons() {
    global $CFG;

    // Load the CSS social buttons
    echo '
    <script language="javascript">
        linkElement = document.createElement("link");
        linkElement.rel = "stylesheet";
        linkElement.href = "' . $CFG->wwwroot . '/auth/googleoauth2/csssocialbuttons/css/zocial.css";
        document.head.appendChild(linkElement);
    </script>
    ';

    //get previous auth provider
    $allauthproviders = optional_param('allauthproviders', false, PARAM_BOOL);
    $cookiename = 'MOODLEGOOGLEOAUTH2_'.$CFG->sessioncookie;
    if (empty($_COOKIE[$cookiename])) {
        $authprovider = '';
    } else {
        $authprovider = $_COOKIE[$cookiename];
    }

    echo "<center>";
    echo "<div style=\"width:'1%'\">";
    $displayprovider = ((empty($authprovider) || $authprovider == 'google' || $allauthproviders) && get_config('auth/googleoauth2', 'googleclientid'));
    $providerdisplaystyle = $displayprovider?'display:inline-block;padding:10px;':'display:none;';
    echo '<div class="singinprovider" style="' . $providerdisplaystyle .'">
            <a class="zocial googleplus" href="https://accounts.google.com/o/oauth2/auth?client_id='.
              get_config('auth/googleoauth2', 'googleclientid') .'&redirect_uri='.$CFG->wwwroot .'/auth/googleoauth2/google_redirect.php&scope=https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email&response_type=code">
                Sign-in with Google
            </a>
        </div>';

     $displayprovider = ((empty($authprovider) || $authprovider == 'facebook' || $allauthproviders) && get_config('auth/googleoauth2', 'facebookclientid'));
     $providerdisplaystyle = $displayprovider?'display:inline-block;padding:10px;':'display:none;';
     echo '<div class="singinprovider" style="'. $providerdisplaystyle .'">
            <a class="zocial facebook" href="https://www.facebook.com/dialog/oauth?client_id='. get_config('auth/googleoauth2', 'facebookclientid') .'&redirect_uri='. $CFG->wwwroot .'/auth/googleoauth2/facebook_redirect.php&scope=email&response_type=code">
                Sign-in with Facebook
            </a>
        </div>';

    $displayprovider = ((empty($authprovider) || $authprovider == 'github' || $allauthproviders) && get_config('auth/googleoauth2', 'githubclientid'));
    $providerdisplaystyle = $displayprovider?'display:inline-block;padding:10px;':'display:none;';
    echo '<div class="singinprovider" style="'. $providerdisplaystyle .'">
            <a class="zocial github" href="https://github.com/login/oauth/authorize?client_id='. get_config('auth/googleoauth2', 'githubclientid') .'&redirect_uri='. $CFG->wwwroot .'/auth/googleoauth2/github_redirect.php&scope=user:email&response_type=code">
                Sign-in with Github
            </a>
        </div>';

    $displayprovider = ((empty($authprovider) || $authprovider == 'linkedin' || $allauthproviders) && get_config('auth/googleoauth2', 'linkedinclientid'));
    $providerdisplaystyle = $displayprovider?'display:inline-block;padding:10px;':'display:none;';
    echo '<div class="singinprovider" style="'. $providerdisplaystyle .'">
            <a class="zocial linkedin" href="https://www.linkedin.com/uas/oauth2/authorization?client_id='. get_config('auth/googleoauth2', 'linkedinclientid') .'&redirect_uri='. $CFG->wwwroot .'/auth/googleoauth2/linkedin_redirect.php&state='.auth_googleoauth2_get_state_token().'&scope=r_basicprofile%20r_emailaddress&response_type=code">
                Sign-in with Linkedin
            </a>
        </div>';


     $displayprovider = ((empty($authprovider) || $authprovider == 'messenger' || $allauthproviders) && get_config('auth/googleoauth2', 'messengerclientid'));
     $providerdisplaystyle = $displayprovider?'display:inline-block;padding:10px;':'display:none;';
     echo '<div class="singinprovider" style="'. $providerdisplaystyle .'">
            <a class="zocial windows" href="https://oauth.live.com/authorize?client_id='. get_config('auth/googleoauth2', 'messengerclientid') .'&redirect_uri='. $CFG->wwwroot .'/auth/googleoauth2/messenger_redirect.php&scope=wl.basic wl.emails wl.signin&response_type=code">
                Sign-in with Windows Live
            </a>
        </div>
    </div>';

    if (!empty($authprovider) and !$allauthproviders) {
        echo '<br/><br/>
            <div class="moreproviderlink">
                <a href="'. $CFG->wwwroot . (!empty($CFG->alternateloginurl) ? $CFG->alternateloginurl : '/login/index.php') . '?allauthproviders=true' .'" onclick="changecss(\'singinprovider\',\'display\',\'inline-block\');">
                    '. get_string('moreproviderlink', 'auth_googleoauth2').'
                </a>
            </div>';
    }
    echo "</center>";
}
