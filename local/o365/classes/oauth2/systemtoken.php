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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365\oauth2;

/**
 * Represents an oauth2 token.
 */
class systemtoken extends \local_o365\oauth2\token {
    /**
     * Get a system token for a given resource.
     *
     * @param string $resource The new resource.
     * @param \local_o365\oauth2\clientdata $clientdata Client information.
     * @param \local_o365\httpclientinterface $httpclient An HTTP client.
     * @return \local_o365\oauth2\systemtoken|bool A constructed token for the new resource, or false if failure.
     */
    public static function instance($resource, \local_o365\oauth2\clientdata $clientdata,
                                    \local_o365\httpclientinterface $httpclient) {
        $tokens = get_config('local_o365', 'systemtokens');
        $tokens = unserialize($tokens);
        if (isset($tokens[$resource])) {
            $token = new systemtoken($tokens[$resource]['token'], $tokens[$resource]['expiry'], $tokens[$resource]['refreshtoken'],
                    $tokens[$resource]['scope'], $tokens[$resource]['resource'], $clientdata, $httpclient);
            return $token;
        } else {
            if ($resource === 'https://graph.windows.net') {
                // This is the base resource we need to get tokens for other resources. If we don't have this, we can't continue.
                return null;
            } else {
                $token = static::get_for_new_resource($resource, $clientdata, $httpclient);
                if (!empty($token)) {
                    return $token;
                }
            }
        }
        return null;
    }

    /**
     * Get a token instance for a new resource.
     *
     * @param string $resource The new resource.
     * @param \local_o365\oauth2\clientdata $clientdata Client information.
     * @param \local_o365\httpclientinterface $httpclient An HTTP client.
     * @return \local_o365\oauth2\systemtoken|bool A constructed token for the new resource, or false if failure.
     */
    public static function get_for_new_resource($resource, \local_o365\oauth2\clientdata $clientdata,
                                                \local_o365\httpclientinterface $httpclient) {
        $aadgraphtoken = static::instance('https://graph.windows.net', $clientdata, $httpclient);
        if (!empty($aadgraphtoken)) {
            $params = [
                'client_id' => $clientdata->get_clientid(),
                'client_secret' => $clientdata->get_clientsecret(),
                'grant_type' => 'refresh_token',
                'refresh_token' => $aadgraphtoken->get_refreshtoken(),
                'resource' => $resource,
            ];
            $tokenresult = $httpclient->post($clientdata->get_tokenendpoint(), $params);
            $tokenresult = @json_decode($tokenresult, true);

            if (!empty($tokenresult) && isset($tokenresult['token_type']) && $tokenresult['token_type'] === 'Bearer') {
                static::store_new_token($tokenresult['access_token'], $tokenresult['expires_on'],
                        $tokenresult['refresh_token'], $tokenresult['scope'], $tokenresult['resource']);
                $token = static::instance($resource, $clientdata, $httpclient);
                return $token;
            }
        }
        return false;
    }

    /**
     * Get stored token for a user and resourse.
     *
     * @param int $userid The ID of the user to get the token for.
     * @param string $resource The resource to get the token for.
     * @return array Array of token data.
     */
    protected function get_stored_token($userid, $resource) {
        $tokens = get_config('local_o365', 'systemtokens');
        $tokens = unserialize($tokens);
        return (isset($tokens[$resource])) ? $tokens[$resource] : false;
    }

    /**
     * Update the stored token.
     *
     * @param array $existingtoken Array of existing token data.
     * @param array $newtoken Array of new token data.
     * @return bool Success/Failure.
     */
    protected function update_stored_token($existingtoken, $newtoken) {
        $tokens = get_config('local_o365', 'systemtokens');
        $tokens = unserialize($tokens);
        if (isset($tokens[$existingtoken['resource']])) {
            unset($tokens[$existingtoken['resource']]);
        }
        $tokens[$newtoken['resource']] = $newtoken;
        $tokens = serialize($tokens);
        set_config('systemtokens', $tokens, 'local_o365');
        return true;
    }

    /**
     * Store a new system token.
     *
     * @param string $token Token access token.
     * @param int $expiry Token expiry timestamp.
     * @param string $refreshtoken Token refresh token.
     * @param string $scope Token scope.
     * @param string $resource Token resource.
     * @return array Array of new token information.
     */
    public static function store_new_token($token, $expiry, $refreshtoken, $scope, $resource) {
        $tokens = get_config('local_o365', 'systemtokens');
        $tokens = unserialize($tokens);
        $newtoken = [
            'token' => $token,
            'expiry' => $expiry,
            'refreshtoken' => $refreshtoken,
            'scope' => $scope,
            'resource' => $resource,
        ];
        $tokens[$resource] = $newtoken;
        $tokens = serialize($tokens);
        set_config('systemtokens', $tokens, 'local_o365');
        return $newtoken;
    }
}
