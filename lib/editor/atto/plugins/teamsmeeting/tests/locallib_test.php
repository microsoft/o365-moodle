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
 * Tests for atto_teamsmeeting's locallib functions.
 *
 * @package    atto_teamsmeeting
 * @copyright  2026 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace atto_teamsmeeting;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/lib/editor/atto/plugins/teamsmeeting/locallib.php');

use advanced_testcase;

/**
 * Tests for atto_teamsmeeting's locallib functions.
 *
 * @package    atto_teamsmeeting
 * @copyright  2026 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers ::atto_teamsmeeting_get_meeting
 * @covers ::atto_teamsmeeting_meeting_url
 */
final class locallib_test extends advanced_testcase {
    /**
     * Set up test data.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * Insert a meeting record for the given link.
     *
     * @param string $link
     * @param string $title
     * @param string $options
     * @return \stdClass The inserted record.
     */
    private function create_meeting(string $link, string $title = 'My meeting', string $options = ''): \stdClass {
        global $DB;

        $record = (object) [
            'title' => $title,
            'link' => $link,
            'options' => $options,
            'timecreated' => time(),
            'timemodified' => time(),
            'userid' => $this->getDataGenerator()->create_user()->id,
        ];
        $record->id = $DB->insert_record('atto_teamsmeeting', $record);

        return $record;
    }

    /**
     * atto_teamsmeeting_get_meeting() finds a record by its exact link.
     */
    public function test_get_meeting_finds_exact_link(): void {
        $link = 'https://teams.microsoft.com/l/meetup-join/one';
        $record = $this->create_meeting($link);
        $this->create_meeting('https://teams.microsoft.com/l/meetup-join/two');

        $found = atto_teamsmeeting_get_meeting($link);

        $this->assertNotNull($found);
        $this->assertEquals($record->id, $found->id);
    }

    /**
     * atto_teamsmeeting_get_meeting() does not match a stored link that is
     * only a prefix of the searched-for url.
     *
     * The comparison length is taken from the searched-for url, so a naive
     * implementation could truncate the stored (shorter) link down to
     * nothing meaningful and appear to match. Teams meeting links all share
     * a long common prefix, so this is a realistic near-miss, not just a
     * contrived one.
     */
    public function test_get_meeting_does_not_match_prefix(): void {
        $this->create_meeting('https://teams.microsoft.com/l/meetup-join/one');

        $found = atto_teamsmeeting_get_meeting('https://teams.microsoft.com/l/meetup-join/one-and-more');

        $this->assertNull($found);
    }

    /**
     * atto_teamsmeeting_get_meeting() returns null when nothing matches.
     */
    public function test_get_meeting_returns_null_when_not_found(): void {
        $this->assertNull(atto_teamsmeeting_get_meeting('https://teams.microsoft.com/l/meetup-join/missing'));
    }

    /**
     * atto_teamsmeeting_meeting_url() with no record points at error.php and
     * carries no window preference.
     */
    public function test_meeting_url_for_missing_record(): void {
        $data = json_decode(atto_teamsmeeting_meeting_url(null));

        $this->assertStringContainsString('/lib/editor/atto/plugins/teamsmeeting/error.php', $data[0]);
        $this->assertSame('', $data[1]);
        $this->assertSame('', $data[2]);
        $this->assertSame('', $data[3]);
        $this->assertSame(0, $data[4]);
    }

    /**
     * atto_teamsmeeting_meeting_url() with a record points at result.php and
     * carries the record's own title, link and options.
     */
    public function test_meeting_url_for_existing_record(): void {
        $record = $this->create_meeting(
            'https://teams.microsoft.com/l/meetup-join/found',
            'Found meeting',
            'https://teams.microsoft.com/meetingOptions/?organizerId=abc'
        );

        $data = json_decode(atto_teamsmeeting_meeting_url($record));

        $this->assertStringContainsString('/lib/editor/atto/plugins/teamsmeeting/result.php', $data[0]);
        $this->assertSame($record->title, $data[1]);
        $this->assertSame($record->link, $data[2]);
        $this->assertSame($record->options, $data[3]);
    }

    /**
     * atto_teamsmeeting_meeting_url() threads the newwindow flag through as
     * 1 or 0 - it is read back out of a JSON array by plain JS array
     * indexing (button.js), not by key, so its position and type matter.
     */
    public function test_meeting_url_threads_newwindow(): void {
        $record = $this->create_meeting('https://teams.microsoft.com/l/meetup-join/found');

        $withnewwindow = json_decode(atto_teamsmeeting_meeting_url($record, true));
        $withoutnewwindow = json_decode(atto_teamsmeeting_meeting_url($record, false));
        $default = json_decode(atto_teamsmeeting_meeting_url($record));

        $this->assertSame(1, $withnewwindow[4]);
        $this->assertSame(0, $withoutnewwindow[4]);
        $this->assertSame(0, $default[4]);
    }
}
