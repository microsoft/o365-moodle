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

defined('MOODLE_INTERNAL') || die();

global $CFG;

/**
 * Tests \local_o365\feature\sds\task\sync
 *
 * @group local_o365
 * @group office365
 * @codeCoverageIgnore
 */
class local_o365_sdssync_testcase extends \advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Get a mock token object to use when constructing the API client.
     *
     * @return \local_o365\oauth2\token The mock token object.
     */
    protected function get_mock_clientdata() {
        $oidcconfig = (object)[
            'clientid' => 'clientid',
            'clientsecret' => 'clientsecret',
            'authendpoint' => 'http://example.com/auth',
            'tokenendpoint' => 'http://example.com/token'
        ];

        $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret,
                $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
        return $clientdata;
    }

    /**
     * Get a mock token object to use when constructing the API client.
     *
     * @return \local_o365\oauth2\token The mock token object.
     */
    protected function get_mock_token() {
        $httpclient = new \local_o365\tests\mockhttpclient();

        $tokenrec = (object)[
            'token' => 'token',
            'expiry' => time() + 1000,
            'refreshtoken' => 'refreshtoken',
            'scope' => 'scope',
            'user_id' => '2',
            'resource' => 'resource',
        ];

        $clientdata = $this->get_mock_clientdata();
        $token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken,
                $tokenrec->scope, $tokenrec->resource, $tokenrec->user_id, $clientdata, $httpclient);
        return $token;
    }

    /**
     * Test get_or_create_school_coursecategory.
     */
    public function test_get_or_create_school_coursecategory() {
        global $DB;

        $testobjectid = '111111a1-2222-bbbb-3333-01234567890a';
        $testschoolname = 'Test School';

        // Assert starting environment.
        $params = ['type' => 'sdsschool', 'subtype' => 'coursecat', 'objectid' => $testobjectid];
        $existingobject = $DB->get_record('local_o365_objects', $params);
        $this->assertEmpty($existingobject);
        $params = ['name' => $testschoolname];
        $existingcoursecat = $DB->get_record('course_categories', $params);
        $this->assertEmpty($existingcoursecat);

        \local_o365\feature\sds\task\sync::get_or_create_school_coursecategory($testobjectid, $testschoolname);

        $params = ['type' => 'sdsschool', 'subtype' => 'coursecat', 'objectid' => $testobjectid];
        $objectrec = $DB->get_record('local_o365_objects', $params);
        $this->assertNotEmpty($objectrec);
        $this->assertEquals($testobjectid, $objectrec->objectid);
        $this->assertEquals($testschoolname, $objectrec->o365name);

        $params = ['name' => $testschoolname, 'id' => $objectrec->moodleid];
        $coursecatrec = $DB->get_record('course_categories', $params);
        $this->assertNotEmpty($coursecatrec);

        \local_o365\feature\sds\task\sync::get_or_create_school_coursecategory($testobjectid, $testschoolname);

        $params = ['type' => 'sdsschool', 'subtype' => 'coursecat', 'objectid' => $testobjectid];
        $objectrec2 = $DB->get_record('local_o365_objects', $params);
        $this->assertNotEmpty($objectrec2);
        $this->assertEquals($objectrec->id, $objectrec2->id);

        $params = ['name' => $testschoolname, 'id' => $objectrec->moodleid];
        $coursecatrec2 = $DB->get_record('course_categories', $params);
        $this->assertNotEmpty($coursecatrec2);
        $this->assertEquals($coursecatrec->id, $coursecatrec2->id);

        $params = ['name' => $testschoolname];
        $coursecatrecs = $DB->get_records('course_categories', $params);
        $this->assertEquals(1, count($coursecatrecs));
    }

    /**
     * Test get_or_create_section_course.
     */
    public function test_get_or_section_course() {
        global $DB;

        $schoolcat = \coursecat::create(['name' => 'TestCat']);

        $objectid = '111111a1-2222-bbbb-3333-01234567890a';
        $shortname = '101_MA502 Section 1';
        $fullname = '8th Grade Mathematics';

        // Assert starting environment.
        $params = ['type' => 'sdssection', 'subtype' => 'course', 'objectid' => $objectid];
        $existingobject = $DB->get_record('local_o365_objects', $params);
        $this->assertEmpty($existingobject);
        $params = ['shortname' => $shortname];
        $existingcourse = $DB->get_record('course', $params);
        $this->assertEmpty($existingcourse);

        \local_o365\feature\sds\task\sync::get_or_create_section_course($objectid, $shortname, $fullname, $schoolcat->id);

        $params = ['type' => 'sdssection', 'subtype' => 'course', 'objectid' => $objectid];
        $objectrec = $DB->get_record('local_o365_objects', $params);
        $this->assertNotEmpty($objectrec);
        $this->assertEquals($objectid, $objectrec->objectid);
        $this->assertEquals($shortname, $objectrec->o365name);

        $params = ['shortname' => $shortname, 'id' => $objectrec->moodleid];
        $courserec = $DB->get_record('course', $params);
        $this->assertNotEmpty($courserec);

        \local_o365\feature\sds\task\sync::get_or_create_section_course($objectid, $shortname, $fullname, $schoolcat->id);

        $params = ['type' => 'sdssection', 'subtype' => 'course', 'objectid' => $objectid];
        $objectrec2 = $DB->get_record('local_o365_objects', $params);
        $this->assertNotEmpty($objectrec2);
        $this->assertEquals($objectrec->id, $objectrec2->id);

        $params = ['shortname' => $shortname, 'id' => $objectrec->moodleid];
        $courserec2 = $DB->get_record('course', $params);
        $this->assertNotEmpty($courserec2);
        $this->assertEquals($courserec->id, $courserec2->id);
    }

    /**
     * Get a response for a school query.
     *
     * @param string $objectid The school objectid.
     * @param string $name The school name.
     * @param string $schoolnumber The school number.
     * @return string API response JSON.
     */
    protected function get_school_response($objectid, $name, $schoolnumber) {
        $prefix = \local_o365\rest\sds::PREFIX;
        $data = [
            'objectType' => 'AdministrativeUnit',
            'objectId' => $objectid,
            'displayName' => $name,
            'description' => '',
            $prefix.'_SchoolNumber' => $schoolnumber,
        ];
        return json_encode($data);
    }
}
