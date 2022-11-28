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
 * PEM string certificate.
 *
 * @package    auth_oidc
 * @copyright  2022 Murdoch University
 * @author     Frédéric Massart <fred@branchup.tech>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace auth_oidc\local\certificate;

defined('MOODLE_INTERNAL') || die();

/**
 * PEM string certificate.
 */
class pemstring implements certificate {

    /** @var string The PEM string. */
    protected $pem;

    /**
     * Constructor.
     *
     * @param string $pem The PEM string.
     */
    public function __construct($pem) {
        $this->pem = $pem;
    }

    /**
     * Get the PEM string.
     *
     * @return string
     */
    public function get_pem() {
        return $this->pem;
    }

    /**
     * Get the certificate's thumbprint.
     *
     * @return string SHA-1 hash.
     */
    public function get_thumbprint() {
        return openssl_x509_fingerprint($this->get_pem(), 'sha1');
    }

}
