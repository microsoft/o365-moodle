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
 * Certificate from a KeyVault.
 *
 * @package    auth_oidc
 * @copyright  2022 Murdoch University
 * @author     Frédéric Massart <fred@branchup.tech>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace auth_oidc\local\certificate;

use auth_oidc\httpclientinterface;
use auth_oidc\local\token\token;
use auth_oidc\utils;

/**
 * Certificate from a KeyVault.
 *
 * Currently on supports PEM encoded certificates in the Key Vault.
 *
 * @package    auth_oidc
 * @copyright  2022 Murdoch University
 * @author     Frédéric Massart <fred@branchup.tech>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class keyvault implements certificate {

    /** @var token The access token reader. */
    protected $token;
    /** @var httpclientinterface The HTTP client. */
    protected $httpclient;
    /** @var string The vault host. */
    protected $vaulthost;
    /** @var string The certificate name in the vault. */
    protected $certname;
    /** @var string The certificate version in the vault. */
    protected $certversion;

    /** @var string The certificate. */
    protected $certificate;
    /** @var string The secret. */
    protected $privatekey;

    /**
     * Constructor.
     *
     * @param token $token The access token reader.
     * @param httpclientinterface $httpclient The HTTP client.
     * @param string $vaulthost The vault host, e.g. example.vault.azure.net.
     * @param string $certname The certificate name in the vault.
     * @param string $certversion The certificate version in the vault.
     */
    public function __construct(token $token, httpclientinterface $httpclient,
            $vaulthost, $certname, $certversion) {
        $this->token = $token;
        $this->httpclient = $httpclient;
        $this->vaulthost = $vaulthost;
        $this->certname = $certname;
        $this->certversion = $certversion;
    }

    /**
     * Get the pem.
     *
     * @return string
     */
    public function get_pem() {
        $this->load_private_key();
        return $this->privatekey;
    }

    /**
     * Get the certificate's SHA1 thumbprint.
     *
     * @return string
     */
    public function get_thumbprint() {
        $this->load_private_key();
        return openssl_x509_fingerprint($this->get_pem(), 'sha1');
    }

    /**
     * Load the certificate, if needed.
     */
    protected function load_certificate() {
        if (!$this->certificate) {
            $this->certificate = $this->request_certificate()['value'];
        }
    }

    /**
     * Load the private key, if needed.
     */
    protected function load_private_key() {
        if (!$this->privatekey) {
            $this->privatekey = $this->request_private_key()['value'];
        }
    }

    /**
     * Request the certificate from the vault.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/keyvault/certificates/get-certificate/get-certificate
     * @return array As returned by API.
     */
    protected function request_certificate() {
        $accesstoken = $this->token->get_access_token();
        $query = ['api-version' => '7.3'];
        $headers = ["Authorization: Bearer {$accesstoken}"];

        $this->httpclient->resetheader();
        $this->httpclient->setheader($headers);
        $response = $this->httpclient->get("https://{$this->vaulthost}/certificates/{$this->certname}/{$this->certversion}", $query);

        if (!empty($this->httpclient->error) || $this->httpclient->info['http_code'] != 200) {
            $debuginfo = [
                'error' => $this->httpclient->error,
                'info' => $this->httpclient->info,
                'response' => $this->httpclient->response,
            ];
            utils::debug('HTTP error during Key Vault call.', __METHOD__, $debuginfo);
            throw new \moodle_exception('errorkeyvaultcall', 'auth_oidc', '', null, json_encode($debuginfo));
        }

        return utils::process_json_response($response, ['value' => null]);
    }

    /**
     * Request the certificate's private key from the vault.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/keyvault/secrets/get-secret/get-secret
     * @return array As returned by API.
     */
    protected function request_private_key() {
        $accesstoken = $this->token->get_access_token();
        $query = ['api-version' => '7.3'];
        $headers = ["Authorization: Bearer {$accesstoken}"];

        $this->httpclient->resetheader();
        $this->httpclient->setheader($headers);
        $response = $this->httpclient->get("https://{$this->vaulthost}/secrets/{$this->certname}/{$this->certversion}", $query);

        if (!empty($this->httpclient->error) || $this->httpclient->info['http_code'] != 200) {
            $debuginfo = [
                'error' => $this->httpclient->error,
                'info' => $this->httpclient->info,
                'response' => $this->httpclient->response,
            ];
            utils::debug('HTTP error during Key Vault call.', __METHOD__, $debuginfo);
            throw new \moodle_exception('errorkeyvaultcall', 'auth_oidc', '', null, json_encode($debuginfo));
        }

        return utils::process_json_response($response, ['value' => null]);
    }

}
