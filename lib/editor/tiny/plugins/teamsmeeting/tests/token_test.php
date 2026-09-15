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
 * Unit tests for the tiny_teamsmeeting callback token.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2026 Enovation Solutions
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tiny_teamsmeeting;

/**
 * Unit tests for the callback token helper.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2026 Enovation Solutions
 * @author      Lai Wei <lai.wei@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers      \tiny_teamsmeeting\token
 */
final class token_test extends \advanced_testcase {
    /**
     * Set up test data.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
        // Prime the signing secret so sign() can read it back.
        token::generate();
    }

    /**
     * Build a correctly signed token for the given user and expiry, without
     * going through generate(), so individual fields can be varied.
     *
     * @param int $userid
     * @param int $expiry Unix timestamp the token should expire at.
     * @return string
     */
    private function sign(int $userid, int $expiry): string {
        $secret = get_config('tiny_teamsmeeting', 'tokensecret');
        $payload = $userid . ':' . $expiry;
        return hash_hmac('sha256', $payload, $secret) . bin2hex($payload);
    }

    /**
     * A token issued for the current user validates back to that user's id.
     */
    public function test_generate_then_validate_returns_the_issuing_user(): void {
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);

        $result = token::validate(token::generate());

        $this->assertSame((int) $user->id, $result);
    }

    /**
     * The token is self-describing: validate() resolves it to the issuing user
     * regardless of who (if anyone) is logged in when it is checked.
     */
    public function test_validate_does_not_depend_on_the_current_session(): void {
        $usera = $this->getDataGenerator()->create_user();
        $userb = $this->getDataGenerator()->create_user();

        $this->setUser($usera);
        $tokena = token::generate();
        $this->setUser($userb);
        $tokenb = token::generate();

        $this->assertNotSame($tokena, $tokenb);

        $this->setUser(null);
        $this->assertSame((int) $usera->id, token::validate($tokena));
        $this->assertSame((int) $userb->id, token::validate($tokenb));
    }

    /**
     * An empty token is rejected.
     */
    public function test_validate_rejects_an_empty_token(): void {
        $this->assertNull(token::validate(''));
    }

    /**
     * Structurally invalid tokens are rejected before any signature check.
     */
    public function test_validate_rejects_malformed_tokens(): void {
        $sig = str_repeat('a', 64);

        $this->assertNull(token::validate(str_repeat('a', 40)), 'shorter than a signature');
        $this->assertNull(token::validate($sig), 'signature length only, no payload');
        $this->assertNull(token::validate(str_repeat('z', 96)), 'non-hexadecimal characters');
        $this->assertNull(token::validate($sig . 'abc'), 'odd-length payload hex');
        $this->assertNull(token::validate($sig . bin2hex('no-colon-here')), 'payload is not id:expiry');
        $this->assertNull(token::validate($sig . bin2hex('7:')), 'payload missing the expiry');
    }

    /**
     * A token far longer than any real token could be is rejected outright,
     * before the length-proportional ctype_xdigit()/hex2bin()/preg_match()
     * checks would otherwise run on it - this endpoint is reached before any
     * authentication check, so an oversized value is otherwise free for an
     * unauthenticated caller to send repeatedly.
     */
    public function test_validate_rejects_an_oversized_token(): void {
        // Mirrors token::MAX_LENGTH (512): one character past it must be rejected.
        $this->assertNull(token::validate(str_repeat('a', 513)));
    }

    /**
     * A token whose signature has been altered is rejected.
     */
    public function test_validate_rejects_a_tampered_signature(): void {
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $token = token::generate();

        $tampered = ($token[0] === '0' ? '1' : '0') . substr($token, 1);

        $this->assertNull(token::validate($tampered));
    }

    /**
     * Re-pointing a valid signature at a different payload is rejected.
     */
    public function test_validate_rejects_a_tampered_payload(): void {
        $user = $this->getDataGenerator()->create_user();
        $token = $this->sign((int) $user->id, time() + 600);

        $signature = substr($token, 0, 64);
        $forged = $signature . bin2hex(((int) $user->id + 1) . ':' . (time() + 600));

        $this->assertNull(token::validate($forged));
    }

    /**
     * A correctly signed token whose expiry is in the past is rejected.
     */
    public function test_validate_rejects_an_expired_token(): void {
        $user = $this->getDataGenerator()->create_user();

        $this->assertNull(token::validate($this->sign((int) $user->id, time() - 1)));
    }

    /**
     * A correctly signed token that has not expired is accepted.
     */
    public function test_validate_accepts_a_current_token(): void {
        $user = $this->getDataGenerator()->create_user();

        $result = token::validate($this->sign((int) $user->id, time() + 60));

        $this->assertSame((int) $user->id, $result);
    }

    /**
     * A token embeds the language the issuing user was shown at the time,
     * not their profile default, since that is routinely overridden per-session
     * (e.g. by the language menu) and is what current_language() resolves to.
     */
    public function test_validate_lang_returns_the_language_active_when_the_token_was_issued(): void {
        global $USER;

        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        // Set directly, after setUser() rather than through it: both
        // create_user() (via user_create_user()) and setUser() (via
        // \core\session\manager::set_user()) run lang through PARAM_LANG
        // cleaning, which silently falls back to the site default for any
        // language pack not installed on the test site - 'xx' would not
        // survive either path. current_language() itself does not validate
        // this, so setting it directly on the already-assigned global proves
        // the token carries through whatever it returns, rather than a
        // coincidentally-matching real pack.
        $USER->lang = 'xx';

        $result = token::validate_lang(token::generate());

        $this->assertSame('xx', $result);
    }

    /**
     * A structurally older token with no language segment in its payload is
     * still accepted by validate(), and validate_lang() degrades to ''.
     */
    public function test_validate_lang_returns_empty_string_for_a_token_without_a_language(): void {
        $user = $this->getDataGenerator()->create_user();
        $token = $this->sign((int) $user->id, time() + 60);

        $this->assertSame((int) $user->id, token::validate($token));
        $this->assertSame('', token::validate_lang($token));
    }

    /**
     * An invalid token has no language to report.
     */
    public function test_validate_lang_returns_empty_string_for_an_invalid_token(): void {
        $this->assertSame('', token::validate_lang(''));
    }
}
