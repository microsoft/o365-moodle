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
 * Issues and consumes the short-lived, single-use token used to authenticate
 * the return trip from the external meeting-creation app to result.php.
 *
 * @package    atto_teamsmeeting
 * @copyright  2020 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace atto_teamsmeeting;

/**
 * Issues and consumes the short-lived, single-use token used to authenticate
 * the return trip from the external meeting-creation app to result.php.
 *
 * That redirect lands as a subframe navigation from a cross-origin iframe, so
 * the browser may not send the Moodle session cookie. This token lets
 * result.php identify the acting user without depending on that cookie.
 *
 * Built on Moodle's core user_private_key API: the token is an opaque random
 * value stored server-side against the issuing user and context, so it can be
 * looked up rather than merely verified, and validate() deletes it on first
 * use so a captured token cannot be replayed.
 *
 * @package    atto_teamsmeeting
 * @copyright  2020 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class result_token {
    /** @var string Script identifier the token is filed under in user_private_key. */
    const SCRIPT = 'atto_teamsmeeting_result';

    /** @var int Token lifetime in seconds. */
    const TTL = 1800;

    /**
     * Generate a single-use token for the given user and context.
     *
     * @param int $userid The id of the user the token is issued for.
     * @param int $contextid The id of the context the token is scoped to.
     * @return string The token.
     */
    public static function generate(int $userid, int $contextid): string {
        return create_user_key(self::SCRIPT, $userid, $contextid, null, time() + self::TTL);
    }

    /**
     * Validate a token against the expected context and consume it.
     *
     * On success the underlying key is deleted, so the same token cannot be
     * validated a second time.
     *
     * @param string $token The token to validate.
     * @param int $expectedcontextid The context id the token must be scoped to.
     * @return int|null The userid the token was issued for, or null if invalid, expired,
     *                   mismatched, or already used.
     */
    public static function validate(string $token, int $expectedcontextid): ?int {
        global $DB;

        if ($token === '') {
            return null;
        }

        try {
            $key = validate_user_key($token, self::SCRIPT, $expectedcontextid);
        } catch (\moodle_exception $e) {
            return null;
        }

        $DB->delete_records('user_private_key', ['id' => $key->id]);

        return (int) $key->userid;
    }
}
