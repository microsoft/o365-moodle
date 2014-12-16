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
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

namespace auth_oidc;

require_once($CFG->dirroot.'/lib/filelib.php');

/**
 * Implementation of \auth_oidc\httpclientinterface using Moodle CURL.
 */
class httpclient extends \curl implements \auth_oidc\httpclientinterface {
    /**
     * Generate a client tag.
     *
     * @return string A client tag.
     */
    protected function get_clienttag_headers() {
        global $CFG;

        $iid = sha1($CFG->wwwroot);
        $mdlver = '1.0';
        $ostype = 'Linux|Windows';
        $osver = '3.4.30|6.2.9000';
        $arch = 'x64';
        $ver = '1.0';

        $params = "lang=PHP; os={$ostype}; os_version={$osver}; arch={$arch}; version={$ver}; MoodleInstallId={$iid}";
        $clienttag = "Moodle/{$mdlver} ({$params})";

        return [
            'User-Agent: '.$clienttag,
            'X-ClientService-ClientTag: '.$clienttag,
        ];
    }

    /**
     * Single HTTP Request
     *
     * @param string $url The URL to request
     * @param array $options
     * @return bool
     */
    protected function request($url, $options = array()) {
        $this->setHeader($this->get_clienttag_headers());
        $result = parent::request($url, $options);
        $this->resetHeader();
        return $result;
    }
}
