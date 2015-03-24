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
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace auth_oidc\loginflow;

/**
 * Login flow for the oauth2 resource owner credentials grant.
 */
class rocreds extends \auth_oidc\loginflow\base {
    /**
     * This is the primary method that is used by the authenticate_user_login() function in moodlelib.php.
     *
     * @param string $username The username (with system magic quotes)
     * @param string $password The password (with system magic quotes)
     * @return bool Authentication success or failure.
     */
    public function user_login($username, $password = null) {
        global $CFG, $DB;

        $client = $this->get_oidcclient();
        $authparams = ['code' => ''];

        // Get OIDC username from token. If no token, user is a synced user and username will work.
        $oidcusername = $username;
        $oidctoken = $DB->get_records('auth_oidc_token', ['username' => $username]);
        if (!empty($oidctoken)) {
            $oidctoken = array_shift($oidctoken);
            if (!empty($oidctoken) && !empty($oidctoken->oidcusername)) {
                $oidcusername = $oidctoken->oidcusername;
            }
        }

        // Make request.
        $tokenparams = $client->rocredsrequest($oidcusername, $password);
        if (!empty($tokenparams) && isset($tokenparams['token_type']) && $tokenparams['token_type'] === 'Bearer') {
            list($oidcuniqid, $idtoken) = $this->process_idtoken($tokenparams['id_token']);
            $tokenrec = $DB->get_record('auth_oidc_token', ['oidcuniqid' => $oidcuniqid]);
            if (!empty($tokenrec)) {
                $this->updatetoken($tokenrec->id, $authparams, $tokenparams);
            } else {
                $tokenrec = $this->createtoken($oidcuniqid, $username, $authparams, $tokenparams, $idtoken);
            }
            return true;
        }
        return false;
    }
}