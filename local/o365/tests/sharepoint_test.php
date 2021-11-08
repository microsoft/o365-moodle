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

/**
 * Tests \local_o365\rest\sharepoint.
 *
 * @group local_o365
 * @group office365
 * @codeCoverageIgnore
 */
class local_o365_sharepoint_testcase extends \advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp() : void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Get a mock token object to use when constructing the API client.
     *
     * @return \local_o365\oauth2\token The mock token object.
     */
    protected function get_mock_token() {
        $httpclient = new \local_o365\tests\mockhttpclient();

        $oidcconfig = (object)[
            'clientid' => 'clientid',
            'clientsecret' => 'clientsecret',
            'authendpoint' => 'http://example.com/auth',
            'tokenendpoint' => 'http://example.com/token'
        ];

        $tokenrec = (object)[
            'token' => 'token',
            'expiry' => time() + 1000,
            'refreshtoken' => 'refreshtoken',
            'scope' => 'scope',
            'user_id' => '2',
            'tokenresource' => 'resource',
        ];

        $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret,
                $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
        $token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken,
                $tokenrec->scope, $tokenrec->tokenresource, $tokenrec->user_id, $clientdata, $httpclient);
        return $token;
    }

    /**
     * Test site_exists method.
     */
    public function test_site_exists() {
        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpclient->set_response('');
        $apiclient = new \local_o365\rest\sharepoint($this->get_mock_token(), $httpclient);
        $this->assertFalse($apiclient->site_exists('test'));

        $response = $this->get_response_create_site('Moodle', 'moodle', 'Test site');
        $httpclient->set_response($response);
        $this->assertTrue($apiclient->site_exists('test'));
    }

    /**
     * Get a successful response for creating a site.
     *
     * @return string The json response.
     */
    protected function get_response_create_site($title, $url, $description) {
        $successresponse = '{
            "odata.metadata":"https://example.sharepoint.com/moodle/_api/$metadata#SP.ApiData.Webs/@Element",
            "odata.type":"SP.Web",
            "odata.id":"https://example.sharepoint.com/moodle/'.$url.'/_api/Web",
            "odata.editLink":"https://example.sharepoint.com/moodle/'.$url.'/_api/Web",
            "AllowRssFeeds":true,
            "AlternateCssUrl":"",
            "AppInstanceId":"00000000-0000-0000-0000-000000000000",
            "Configuration":0,
            "Created":"2014-12-11T14:16:28",
            "CustomMasterUrl":"/moodle/'.$url.'/_catalogs/masterpage/seattle.master",
            "Description":'.json_encode($description).',
            "DocumentLibraryCalloutOfficeWebAppPreviewersDisabled":false,
            "EnableMinimalDownload":true,
            "Id":"000000000-1111-2222-3333-444455556666",
            "Language":1033,
            "LastItemModifiedDate":"2014-12-11T14:16:36Z",
            "MasterUrl":"/moodle/'.$url.'/_catalogs/masterpage/seattle.master",
            "QuickLaunchEnabled":true,
            "RecycleBinEnabled":true,
            "ServerRelativeUrl":"/moodle/'.$url.'",
            "SiteLogoUrl":null,
            "SyndicationEnabled":true,
            "Title":"'.$title.'",
            "TreeViewEnabled":false,
            "UIVersion":15,
            "UIVersionConfigurationEnabled":false,
            "Url":"https://example.sharepoint.com/moodle/'.$url.'",
            "WebTemplate":"STS"}';
        return $successresponse;
    }

    /**
     * Get a successful response for adding a user to a group.
     *
     * @return string The json response.
     */
    protected function get_response_add_user_to_group($userupn) {
        $response = '{
            "odata.metadata":"https://example.sharepoint.com/moodle/_api/$metadata#SP.ApiData.Users1/@Element",
            "odata.type":"SP.User",
            "odata.id":"https://example.sharepoint.com/moodle/_api/Web/GetUserById(11)",
            "odata.editLink":"Web/GetUserById(11)",
            "Id":11,
            "IsHiddenInUI":false,
            "LoginName":"i:0#.f|membership|'.$userupn.'",
            "Title":"Test User",
            "PrincipalType":1,
            "Email":"'.$userupn.'",
            "IsShareByEmailGuestUser":false,
            "IsSiteAdmin":false,
            "UserId":{"NameId":"0000111122223333","NameIdIssuer":"urn:federation:microsoftonline"}
        }';
        return $response;
    }

    /**
     * Get a successful response for creating a group.
     *
     * @return string The json response.
     */
    protected function get_response_create_group($name, $desc) {
        $response = '{
            "odata.metadata":"https://example.sharepoint.com/moodle/_api/$metadata#SP.ApiData.Groups1/@Element",
            "odata.type":"SP.Group",
            "odata.id":"https://example.sharepoint.com/moodle/_api/Web/SiteGroups/GetById(37)",
            "odata.editLink":"Web/SiteGroups/GetById(37)",
            "Id":37,
            "IsHiddenInUI":false,
            "LoginName":"'.$name.'",
            "Title":"'.$name.'",
            "PrincipalType":8,
            "AllowMembersEditMembership":false,
            "AllowRequestToJoinLeave":false,
            "AutoAcceptRequestToJoinLeave":false,
            "Description":"'.$desc.'",
            "OnlyAllowMembersViewMembership":true,
            "OwnerTitle":"Test User",
            "RequestToJoinLeaveEmailSetting":null}';
        return $response;
    }

    /**
     * Get a successful response for assigning group permissions.
     *
     * @return string The json response.
     */
    protected function get_response_assign_group_permission() {
        $response = '{
            "odata.metadata":"https://pdyn.sharepoint.com/moodle/_api/$metadata#Edm.Null",
            "odata.null":true}';
        return $response;
    }

    /**
     * Test create_course_subsite method.
     */
    public function test_create_course_subsite() {
        global $DB;
        $course = $this->getDataGenerator()->create_course();

        $successresponse = $this->get_response_create_site($course->fullname, $course->shortname, $course->summary);
        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpclient->set_responses(['', $successresponse]);
        $apiclient = new \local_o365\tests\mocksharepoint($this->get_mock_token(), $httpclient);
        $apiclient->create_course_subsite($course);

        $rec = $DB->get_record('local_o365_coursespsite', ['courseid' => $course->id]);
        $this->assertNotEmpty($rec);
        $this->assertEquals('/moodle/'.$course->shortname, $rec->siteurl);
    }

    /**
     * Test add_users_with_capability_to_group method.
     */
    public function test_add_users_with_capability_to_group() {
        global $DB;
        $requiredcapability = \local_o365\rest\sharepoint::get_course_site_required_capability();
        $course = $this->getDataGenerator()->create_course();
        $role = $this->getDataGenerator()->create_role(['archetype' => 'editingteacher']);
        $coursecontext = \context_course::instance($course->id);

        $user1 = $this->getDataGenerator()->create_user(['auth' => 'oidc']);
        $user2 = $this->getDataGenerator()->create_user(['auth' => 'oidc']);

        $testtoken = (object)[
            'user_id' => $user1->id,
            'scope' => '',
            'token' => '',
            'refreshtoken' => '',
            'expiry' => 0
        ];
        $testtoken->id = $DB->insert_record('local_o365_token', $testtoken);

        $testoidctoken = (object)[
            'oidcuniqid' => 'user1',
            'tokenresource' => 'https://graph.microsoft.com',
            'username' => $user1->username,
            'userid' => $user1->id,
            'scope' => 'User.Read',
            'authcode' => '000',
            'token' => '111',
            'refreshtoken' => '222',
            'idtoken' => '333',
            'expiry' => time() + 9999,
        ];
        $testoidctoken->id = $DB->insert_record('auth_oidc_token', $testoidctoken);

        $aaduserdata = (object)[
            'type' => 'user',
            'subtype' => '',
            'objectid' => '',
            'moodleid' => $user1->id,
            'o365name' => 'test@example.onmicrosoft.com',
            'timecreated' => time(),
            'timemodified' => time(),
        ];
        $aaduserdata->id = $DB->insert_record('local_o365_objects', $aaduserdata);

        $result = $this->getDataGenerator()->role_assign($role, $user1->id, $coursecontext);

        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpclient->set_responses([$this->get_response_add_user_to_group($aaduserdata->o365name)]);
        $apiclient = new \local_o365\rest\sharepoint($this->get_mock_token(), $httpclient);
        $results = $apiclient->add_users_with_capability_to_group($coursecontext, $requiredcapability, 10);

        $this->assertNotEmpty($results[$user1->id]);
        $this->assertEquals(1, count($results));

        $assignmentexists = $DB->record_exists('local_o365_spgroupassign', ['groupid' => 10, 'userid' => $user1->id]);
        $this->assertTrue($assignmentexists);
    }

    /**
     * Test create_course_site method.
     */
    public function test_create_course_site() {
        global $DB;
        $requiredcapability = \local_o365\rest\sharepoint::get_course_site_required_capability();
        $course = $this->getDataGenerator()->create_course();
        $role = $this->getDataGenerator()->create_role(['archetype' => 'editingteacher']);
        $coursecontext = \context_course::instance($course->id);
        set_config('sharepointcourseselect', 'onall', 'local_o365');
        $user1 = $this->getDataGenerator()->create_user(['auth' => 'oidc']);
        $user2 = $this->getDataGenerator()->create_user(['auth' => 'oidc']);

        $testtoken = (object)[
            'user_id' => $user1->id,
            'scope' => '',
            'token' => '',
            'refreshtoken' => '',
            'expiry' => 0
        ];
        $testtoken->id = $DB->insert_record('local_o365_token', $testtoken);

        $aaduserdata = (object)[
            'type' => 'user',
            'subtype' => '',
            'objectid' => '',
            'moodleid' => $user1->id,
            'o365name' => 'test@example.onmicrosoft.com',
            'timecreated' => time(),
            'timemodified' => time(),
        ];
        $aaduserdata->id = $DB->insert_record('local_o365_objects', $aaduserdata);

        $result = $this->getDataGenerator()->role_assign($role, $user1->id, $coursecontext);

        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpresponses = [
            // Indicate site not found.
            '',
            // Indicate site created.
            $this->get_response_create_site($course->fullname, $course->shortname, $course->summary),
            // Indicate group created.
            $this->get_response_create_group('testgroup', 'testgroup'),
            // Indicate permissions assigned.
            $this->get_response_assign_group_permission(),
            // Indicate user added to group.
            $this->get_response_add_user_to_group($aaduserdata->o365name),
        ];
        $httpclient->set_responses($httpresponses);
        $apiclient = new \local_o365\rest\sharepoint($this->get_mock_token(), $httpclient);
        $apiclient->create_course_site($course->id);

        $coursespsite = $DB->get_record('local_o365_coursespsite', ['courseid' => $course->id]);
        $this->assertNotEmpty($coursespsite);
        $this->assertEquals('/moodle/'.$course->shortname, $coursespsite->siteurl);

        $spgroupdata = $DB->get_records('local_o365_spgroupdata', ['coursespsiteid' => $coursespsite->id]);
        $this->assertNotEmpty($spgroupdata);
    }
}
