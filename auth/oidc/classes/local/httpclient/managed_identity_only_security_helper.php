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
 * Managed identity only security helper.
 *
 * @package    auth_oidc
 * @copyright  2022 Murdoch University
 * @author     Frédéric Massart <fred@branchup.tech>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace auth_oidc\local\httpclient;

use core\files\curl_security_helper;

defined('MOODLE_INTERNAL') || die();

/**
 * Managed identity only security helper.
 *
 * The purpose of this implementation of the curl securiy helper is to:
 *
 * a) mitigate the default Moodle settings to block access to managed identity.
 * b) restrict usage to managed identity endpoint only.
 */
class managed_identity_only_security_helper extends curl_security_helper {

    public function is_enabled() {
        return true;
    }

    protected function host_is_blocked($host) {
        return $host !== '169.254.169.254';
    }

    protected function port_is_blocked($port) {
        return $port != 80;
    }

}
