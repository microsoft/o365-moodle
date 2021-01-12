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

namespace local_o365\obj;

/**
 * Class representing Microsoft 365 user information.
 */
class o365user {
    protected $muserid = null;
    protected $oidctoken = null;
    public $objectid = null;
    public $username = null;
    public $upn = null;

    protected function __construct($userid, $oidctoken) {
        $this->muserid = $userid;
        $this->oidctoken = $oidctoken;
        $this->objectid = $oidctoken->oidcuniqid;
        $this->username = $oidctoken->oidcusername;
        $this->upn = $oidctoken->oidcusername;
    }

    public function get_idtoken() {
        return $this->oidctoken->idtoken;
    }

    public static function instance_from_muserid($userid) {
        global $DB;

        $aadresource = \local_o365\rest\azuread::get_resource();
        $params = ['userid' => $userid, 'resource' => $aadresource];
        $oidctoken = $DB->get_record('auth_oidc_token', $params);
        if (empty($oidctoken)) {
            return null;
        }
        return new \local_o365\obj\o365user($userid, $oidctoken);
    }
}
