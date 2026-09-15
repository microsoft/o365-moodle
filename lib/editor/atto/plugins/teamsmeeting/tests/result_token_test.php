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
 * Tests for the atto_teamsmeeting result_token helper.
 *
 * @package    atto_teamsmeeting
 * @copyright  2026 Enovation Solutions
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace atto_teamsmeeting;

use advanced_testcase;

/**
 * Tests for the atto_teamsmeeting result_token helper.
 *
 * @package    atto_teamsmeeting
 * @copyright  2026 Enovation Solutions
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \atto_teamsmeeting\result_token
 */
final class result_token_test extends advanced_testcase {
    /**
     * Set up test data.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * validate() returns the userid a token was issued for, and consumes it.
     */
    public function test_validate_returns_the_userid_and_consumes_the_token(): void {
        $user = $this->getDataGenerator()->create_user();
        $contextid = \context_system::instance()->id;

        $token = result_token::generate((int) $user->id, $contextid);

        $this->assertSame((int) $user->id, result_token::validate($token, $contextid));
        // A second validation of the same token fails: it was consumed by the first.
        $this->assertNull(result_token::validate($token, $contextid));
    }

    /**
     * validate_lang() returns the language active when the token was generated,
     * i.e. what current_language() resolved to at that point - not the user's
     * profile default, which is only a fallback and is routinely overridden by
     * a session-level language change or a course-forced language.
     */
    public function test_validate_lang_returns_the_language_active_when_the_token_was_generated(): void {
        global $SESSION;

        $user = $this->getDataGenerator()->create_user(['lang' => 'en']);
        $this->setUser($user);
        // Override the session-active language independently of the profile
        // default, exactly as the language menu would.
        $SESSION->lang = 'xx';

        $token = result_token::generate((int) $user->id, \context_system::instance()->id);

        $this->assertSame('xx', result_token::validate_lang($token));
    }

    /**
     * validate_lang() consumes its cache entry, so it cannot be replayed even
     * though it does not consume the underlying result_token itself.
     */
    public function test_validate_lang_can_only_be_read_once(): void {
        $user = $this->getDataGenerator()->create_user();
        $token = result_token::generate((int) $user->id, \context_system::instance()->id);

        $this->assertNotSame('', result_token::validate_lang($token));
        $this->assertSame('', result_token::validate_lang($token));
    }

    /**
     * An unrecognised token has no cached language to report.
     */
    public function test_validate_lang_returns_empty_string_for_an_unknown_token(): void {
        // Alphanumeric, matching what PARAM_ALPHANUM would actually let through
        // to result.php, unlike a value containing punctuation such as '-'.
        $this->assertSame('', result_token::validate_lang('notarealtoken1234567890'));
    }

    /**
     * An empty token has no cached language to report.
     */
    public function test_validate_lang_returns_empty_string_for_an_empty_token(): void {
        $this->assertSame('', result_token::validate_lang(''));
    }
}
