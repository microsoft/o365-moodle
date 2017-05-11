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
     * Get a mock apiclient
     *
     * @return \local_o365\rest\sds A mock SDS api client.
     */
    protected function get_mock_apiclient() {
        $mocktoken = $this->get_mock_token();
        $mockhttpclient = new \local_o365\tests\mockhttpclient();
        $mockclient = new \local_o365\rest\sds($mocktoken, $mockhttpclient);
        return $mockclient;
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
     * Test the main runsync function.
     */
    public function test_runsync() {
        global $DB;
        $mocktoken = $this->get_mock_token();
        $mockhttpclient = new \local_o365\tests\mockhttpclient();
        $schoolresponse = $this->get_school_response();
        $schoolsectionsresponse = $this->get_school_sections_response();
        $responses = [
            json_encode($schoolresponse),
            json_encode($schoolsectionsresponse),
        ];
        $mockhttpclient->set_responses($responses);
        $mockclient = new \local_o365\rest\sds($mocktoken, $mockhttpclient);

        set_config('sdsschools', 'fd1bdc2b-a59c-444e-af75-e250c546410e', 'local_o365');
        set_config('sdsprofilesyncenabled', '0', 'local_o365');
        set_config('sdsfieldmap', serialize([]), 'local_o365');
        set_config('sdsenrolmentenabled', '0', 'local_o365');

        \local_o365\feature\sds\task\sync::runsync($mockclient);

        // Verify course is created.
        $sectiondata = $schoolsectionsresponse['value'][0];
        $expectedcoursename = $sectiondata[$mockclient::PREFIX.'_CourseName'];
        $expectedcoursename .= ' '.$sectiondata[$mockclient::PREFIX.'_SectionNumber'];
        $expectedcourseshortname = $sectiondata['displayName'];
        $params = [
            'fullname' => $expectedcoursename,
            'shortname' => $expectedcourseshortname
        ];
        $course = $DB->get_record('course', $params);
        $this->assertNotEmpty($course);

        // Verify objects records.
        $params = [
            'type' => 'sdsschool',
            'subtype' => 'coursecat',
        ];
        $sdscoursecats = $DB->get_records('local_o365_objects', $params);
        $this->assertNotEmpty($sdscoursecats, 'No sdsschool/coursecat object record for the school found.');
        $this->assertEquals(1, count($sdscoursecats), 'Only 1 sdsschool/coursecat object record for the school should exist.');
        $objectrec = reset($sdscoursecats);
        $this->assertEquals($schoolresponse['displayName'], $objectrec->o365name, 'o365name incorrect');
        $this->assertEquals($schoolresponse['objectId'], $objectrec->objectid, 'Object ID should match');

        $params = [
            'type' => 'sdssection',
            'subtype' => 'course',
        ];
        $sdssections = $DB->get_records('local_o365_objects', $params);
        $this->assertNotEmpty($sdssections, 'No sdssection/course object record for the section found.');
        $this->assertEquals(1, count($sdssections), 'Only 1 sdssection/course object record for the school should exist.');
        $objectrec = reset($sdssections);
        $this->assertEquals($expectedcourseshortname, $objectrec->o365name, 'o365name incorrect');
        $this->assertEquals($sectiondata['objectId'], $objectrec->objectid, 'Object ID should match');

        $params = [
            'type' => 'group',
            'subtype' => 'course',
        ];
        $groups = $DB->get_records('local_o365_objects', $params);
        $this->assertNotEmpty($groups, 'No group/course object record for the section found.');
        $this->assertEquals(1, count($groups), 'Only 1 group/course object record for the school should exist.');
        $objectrec = reset($groups);
        $this->assertEquals($expectedcourseshortname, $objectrec->o365name, 'o365name incorrect');
        $this->assertEquals($sectiondata['objectId'], $objectrec->objectid, 'Object ID should match');

        // Run sync again to make sure we don't create duplicates.
        $mockhttpclient->set_responses($responses);
        \local_o365\feature\sds\task\sync::runsync($mockclient);

        $params = [
            'fullname' => $expectedcoursename,
            'shortname' => $expectedcourseshortname
        ];
        $course = $DB->get_record('course', $params);
        $this->assertNotEmpty($course);

        // Verify objects records.
        $params = [
            'type' => 'sdsschool',
            'subtype' => 'coursecat',
        ];
        $sdscoursecats = $DB->get_records('local_o365_objects', $params);
        $this->assertNotEmpty($sdscoursecats, 'No sdsschool/coursecat object record for the school found.');
        $this->assertEquals(1, count($sdscoursecats), 'Only 1 sdsschool/coursecat object record for the school should exist.');
        $objectrec = reset($sdscoursecats);
        $this->assertEquals($schoolresponse['displayName'], $objectrec->o365name, 'o365name incorrect');
        $this->assertEquals($schoolresponse['objectId'], $objectrec->objectid, 'Object ID should match');

        $params = [
            'type' => 'sdssection',
            'subtype' => 'course',
        ];
        $sdssections = $DB->get_records('local_o365_objects', $params);
        $this->assertNotEmpty($sdssections, 'No sdssection/course object record for the section found.');
        $this->assertEquals(1, count($sdssections), 'Only 1 sdssection/course object record for the school should exist.');
        $objectrec = reset($sdssections);
        $this->assertEquals($expectedcourseshortname, $objectrec->o365name, 'o365name incorrect');
        $this->assertEquals($sectiondata['objectId'], $objectrec->objectid, 'Object ID should match');

        $params = [
            'type' => 'group',
            'subtype' => 'course',
        ];
        $groups = $DB->get_records('local_o365_objects', $params);
        $this->assertNotEmpty($groups, 'No group/course object record for the section found.');
        $this->assertEquals(1, count($groups), 'Only 1 group/course object record for the school should exist.');
        $objectrec = reset($groups);
        $this->assertEquals($expectedcourseshortname, $objectrec->o365name, 'o365name incorrect');
        $this->assertEquals($sectiondata['objectId'], $objectrec->objectid, 'Object ID should match');
    }

    /**
     * Get a response for a school query.
     *
     * @return array Array of response data.
     */
    protected function get_school_response() {
        $response = [
            "odata.metadata" => 'https://graph.windows.net/contososd.com/$metadata#directoryObjects/Microsoft.DirectoryServices.AdministrativeUnit/@Element',
            "odata.type" => "Microsoft.DirectoryServices.AdministrativeUnit",
            "objectType" => "AdministrativeUnit",
            "objectId" => "fd1bdc2b-a59c-444e-af75-e250c546410e",
            "deletionTimestamp" => null,
            "displayName" => "Palo Alto High School",
            "description" => null,
            \local_o365\rest\sds::PREFIX."_SchoolPrincipalEmail" => "principal@example.com",
            \local_o365\rest\sds::PREFIX."_SchoolPrincipalName" => "John Doe",
            \local_o365\rest\sds::PREFIX."_HighestGrade" => "12",
            \local_o365\rest\sds::PREFIX."_LowestGrade" => "9",
            \local_o365\rest\sds::PREFIX."_SchoolNumber" => "425",
            \local_o365\rest\sds::PREFIX."_SyncSource_SchoolId" => "425",
            \local_o365\rest\sds::PREFIX."_SyncSource" => "SIS",
            \local_o365\rest\sds::PREFIX."_Phone" => "(916) 555-1200",
            \local_o365\rest\sds::PREFIX."_Zip" => "94003",
            \local_o365\rest\sds::PREFIX."_State" => "CA",
            \local_o365\rest\sds::PREFIX."_City" => "Palo Alto",
            \local_o365\rest\sds::PREFIX."_Address" => "123 Fake St",
            \local_o365\rest\sds::PREFIX."_AnchorId" => "School_425",
            \local_o365\rest\sds::PREFIX."_ObjectType" => "School"
        ];
        return $response;
    }

    /**
     * Get a mock response for a school sections query.
     *
     * @return array Array of response data.
     */
    protected function get_school_sections_response() {
        $response = [
            'odata.metadata' => 'https://graph.windows.net/95b43ae0-0554-4cc5-8c22-fe219dc31156/$metadata#directoryObjects/Microsoft.DirectoryServices.Group',
            'value' => [
                [
                    "odata.type" => "Microsoft.DirectoryServices.Group",
                    "objectType" => "Group",
                    "objectId" => "d016567a-3d56-4162-aa16-1d938dbd7b8e",
                    "deletionTimestamp" => null,
                    "description" => null,
                    "dirSyncEnabled" => null,
                    "displayName" => "425_JZ100 Section 20",
                    "lastDirSyncTime" => null,
                    "mail" => "Section_1140@example.com",
                    "mailNickname" => "Section_1140",
                    "mailEnabled" => true,
                    "onPremisesSecurityIdentifier" => null,
                    "provisioningErrors" => [],
                    "proxyAddresses" => [
                      "SMTP:Section_1140@example.com"
                    ],
                    "securityEnabled" => true,
                    \local_o365\rest\sds::PREFIX."_Period" => "2",
                    \local_o365\rest\sds::PREFIX."_CourseNumber" => "JZ100",
                    \local_o365\rest\sds::PREFIX."_CourseDescription" => "JZ100 - JAZZ ENSEMBLE 1",
                    \local_o365\rest\sds::PREFIX."_CourseName" => "JAZZ ENSEMBLE 1",
                    \local_o365\rest\sds::PREFIX."_SyncSource_CourseId" => "15057",
                    \local_o365\rest\sds::PREFIX."_TermEndDate" => "12/21/2015",
                    \local_o365\rest\sds::PREFIX."_TermStartDate" => "8/30/2015",
                    \local_o365\rest\sds::PREFIX."_TermName" => "2015 Term 1",
                    \local_o365\rest\sds::PREFIX."_SyncSource_TermId" => "2015",
                    \local_o365\rest\sds::PREFIX."_SectionNumber" => "425_JZ100_20",
                    \local_o365\rest\sds::PREFIX."_SectionName" => "425_JZ100 Section 20",
                    \local_o365\rest\sds::PREFIX."_SyncSource_SectionId" => "1140",
                    \local_o365\rest\sds::PREFIX."_SyncSource_SchoolId" => "425",
                    \local_o365\rest\sds::PREFIX."_SyncSource" => "SIS",
                    \local_o365\rest\sds::PREFIX."_AnchorId" => "Section_1140",
                    \local_o365\rest\sds::PREFIX."_ObjectType" => "Section",
                ]
            ]
        ];
        return $response;
    }
}
