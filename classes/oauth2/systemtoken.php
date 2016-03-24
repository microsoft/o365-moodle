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

namespace local_o365\oauth2;

/**
 * Represents an oauth2 token.
 */
class systemtoken extends \local_o365\oauth2\token {
    /**
     * Get stored token for a user and resourse.
     *
     * @param int $userid The ID of the user to get the token for.
     * @param string $resource The resource to get the token for.
     * @return array Array of token data.
     */
    protected static function get_stored_token($userid, $resource) {
        $tokens = get_config('local_o365', 'systemtokens');
        $tokens = unserialize($tokens);
        if (isset($tokens[$resource])) {
            $tokens[$resource]['user_id'] = null;
            return $tokens[$resource];
        } else {
            return false;
        }
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
     * Delete a stored token.
     *
     * @param array $existingtoken The existing token record.
     * @return bool Success/Failure.
     */
    protected function delete_stored_token($existingtoken) {
        $tokens = get_config('local_o365', 'systemtokens');
        $tokens = unserialize($tokens);
        if (isset($tokens[$existingtoken['resource']])) {
            unset($tokens[$existingtoken['resource']]);
        }
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
    public static function store_new_token($userid, $token, $expiry, $refreshtoken, $scope, $resource) {
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
