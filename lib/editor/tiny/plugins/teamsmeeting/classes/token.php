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
 * Generates and validates the token handed to the external meetings app.
 *
 * The meetings app is a third party origin, so the Moodle session key must
 * never be sent to it. Instead the app is given an opaque token derived from
 * the current user id keyed by the session key. The token proves that the
 * request that eventually calls back into result.php originated from an active,
 * authenticated Moodle session belonging to the same user, without disclosing
 * the session key itself.
 *
 * @package     tiny_teamsmeeting
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class token {
    /**
     * Generate the callback token for the current user and session.
     *
     * @return string A 64 character hexadecimal token.
     */
    public static function generate(): string {
        global $USER;
        return hash_hmac('sha256', (string) $USER->id, sesskey());
    }

    /**
     * Validate a token received from the meetings app callback.
     *
     * @param string $token The token supplied by the request.
     * @return bool True when the token matches the expected value.
     */
    public static function validate(string $token): bool {
        return $token !== '' && hash_equals(self::generate(), $token);
    }
}
