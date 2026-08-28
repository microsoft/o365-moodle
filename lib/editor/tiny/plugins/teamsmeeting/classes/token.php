<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Callback token helper for the tiny_teamsmeeting plugin.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2026 Enovation Solutions
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tiny_teamsmeeting;

/**
 * Issues and verifies the signed token handed to the external meetings app.
 *
 * After a meeting is created the app navigates an iframe back to result.php to
 * report it. That iframe lives in a cross-site context, so the browser will not
 * send the Moodle session cookie with the navigation and result.php cannot rely
 * on an authenticated session. Instead the app carries this token, which names
 * the issuing user and is signed with a site-local secret, letting result.php
 * authenticate the callback and re-establish the user on its own.
 *
 * The Moodle session key is never given to the app.
 *
 * @package     tiny_teamsmeeting
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class token {
    /** @var int Seconds a freshly issued token remains valid. */
    private const LIFETIME = 7200;

    /**
     * Issue a token for the current user.
     *
     * @return string Hexadecimal token, safe to pass as a URL parameter.
     */
    public static function generate(): string {
        global $USER;
        $payload = $USER->id . ':' . (time() + self::LIFETIME);
        return hash_hmac('sha256', $payload, self::secret()) . bin2hex($payload);
    }

    /**
     * Verify a token and return the user id it was issued for.
     *
     * @param string $token The token received from the callback request.
     * @return int|null The user id, or null when the token is missing, malformed,
     *                  tampered with or expired.
     */
    public static function validate(string $token): ?int {
        if (strlen($token) <= 64 || !ctype_xdigit($token)) {
            return null;
        }
        $signature = substr($token, 0, 64);
        $payload = @hex2bin(substr($token, 64));
        if ($payload === false || !preg_match('/^(\d+):(\d+)$/', $payload, $matches)) {
            return null;
        }
        if (!hash_equals(hash_hmac('sha256', $payload, self::secret()), $signature)) {
            return null;
        }
        if ((int) $matches[2] < time()) {
            return null;
        }
        return (int) $matches[1];
    }

    /**
     * Return the site-local secret used to sign tokens, creating it on first use.
     *
     * @return string
     */
    private static function secret(): string {
        $secret = get_config('tiny_teamsmeeting', 'tokensecret');
        if (empty($secret)) {
            $secret = bin2hex(random_bytes(32));
            set_config('tokensecret', $secret, 'tiny_teamsmeeting');
        }
        return $secret;
    }
}
