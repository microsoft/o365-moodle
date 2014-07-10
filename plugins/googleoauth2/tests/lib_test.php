<?php
/**
 * Unit tests for auth/googleoauth2/lib.php.
 *
 * @package    auth_googleoauth2
 * @category   phpunit
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/auth/googleoauth2/lib.php');

class auth_googleoauth2_lib_testcase extends advanced_testcase {

    /*
     * Test auth_googleoauth2_display_buttons()
     */
    public function test_auth_googleoauth2_display_buttons() {
        // A total fake test for checking that travis-ci works.
        $this->assertEquals(1, 1);
    }

}