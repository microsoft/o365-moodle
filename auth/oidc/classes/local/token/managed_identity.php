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
 * Managed identity token.
 *
 * @package    auth_oidc
 * @copyright  2022 Murdoch University
 * @author     Frédéric Massart <fred@branchup.tech>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace auth_oidc\local\token;

use auth_oidc\httpclientinterface;
use auth_oidc\utils;

/**
 * Managed identity token.
 *
 * @package    auth_oidc
 * @copyright  2022 Murdoch University
 * @author     Frédéric Massart <fred@branchup.tech>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class managed_identity implements token {

    /** @var string|null The managed identity client ID. */
    protected $clientid;
    /** @var string The resource. */
    protected $resource;
    /** @var httpclientinterface The HTTP client. */
    protected $httpclient;

    /** @var array|null The token. */
    protected $token;

    /**
     * Constructor.
     *
     * @param string $resource The resource.
     * @param httpclientinterface $httpclient The HTTP client.
     * @param string|null $clientid The managed identity client ID.
     */
    public function __construct($resource, httpclientinterface $httpclient, $clientid = null) {
        $this->resource = $resource;
        $this->httpclient = $httpclient;
        $this->clientid = $clientid;
    }

    /**
     * Get the access token.
     *
     * @return string
     */
    public function get_access_token() {
        if (!$this->token || $this->token['expires_on'] < time() - 60) {
            $this->token = $this->request_token();
        }
        return $this->token['access_token'];
    }

    /**
     * Request the token.
     *
     * @see https://docs.microsoft.com/en-us/azure/active-directory/managed-identities-azure-resources/how-to-use-vm-token#get-a-token-using-http
     * @return array As returned by the API.
     */
    protected function request_token() {
        $query = [
            'api-version' => '2018-02-01',
            'resource' => $this->resource,
        ];
        if ($this->clientid) {
            $query['client_id'] = $this->clientid;
        }

        $headers = ['Metadata: true'];
        $this->httpclient->resetheader();
        $this->httpclient->setheader($headers);
        $response = $this->httpclient->get('http://169.254.169.254/metadata/identity/oauth2/token', $query);

        if (!empty($this->httpclient->error) || $this->httpclient->info['http_code'] != 200) {
            $debuginfo = [
                'error' => $this->httpclient->error,
                'info' => $this->httpclient->info,
                'response' => $this->httpclient->response,
            ];
            utils::debug('HTTP error during Managed Identity call.', __METHOD__, $debuginfo);
            throw new \moodle_exception('errormanagedidentitycall', 'auth_oidc', '', null, json_encode($debuginfo));
        }

        return utils::process_json_response($response, ['access_token' => null, 'expires_on' => null]);
    }

}
