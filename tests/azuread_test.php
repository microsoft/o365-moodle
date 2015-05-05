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
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

class azuread_mock extends \local_o365\rest\azuread {
    /**
     * Transform the full request URL.
     *
     * @param string $requesturi The full request URI, includes the API uri and called endpoint.
     * @return string The transformed full request URI.
     */
    public function transform_full_request_uri($requesturi) {
        return parent::transform_full_request_uri($requesturi);
    }
}

/**
 * Tests \local_o365\rest\azuread.
 *
 * @group local_o365
 */
class local_o365_azuread_testcase extends \advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Get sample AAD userdata.
     *
     * @param int $i A counter to generate unique data.
     * @return array Array of AAD user data.
     */
    protected function get_aad_userinfo($i = 0) {
        return [
            'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
            'objectType' => 'User',
            'objectId' => '00000000-0000-0000-0000-00000000000'.$i,
            'city' => 'Toronto',
            'country' => 'CA',
            'department' => 'Dev',
            'givenName' => 'Test',
            'userPrincipalName' => 'testuser'.$i.'@example.onmicrosoft.com',
            'mail' => 'testuser'.$i.'@example.onmicrosoft.com',
            'surname' => 'User'.$i,
            'preferredLanguage' => ($i == 3) ? 'de-DE' : 'en-US',
        ];
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
            'resource' => 'resource',
        ];

        $clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret,
                $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
        $token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken,
                $tokenrec->scope, $tokenrec->resource, $tokenrec->user_id, $clientdata, $httpclient);
        return $token;
    }

    /**
     * Dataprovider for test_create_user_from_aaddata.
     *
     * @return array Array of test parameters.
     */
    public function dataprovider_create_user_from_aaddata() {
        global $CFG;
        $tests = [];

        $tests['fulldata'] = [
            [
                'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
                'objectType' => 'User',
                'objectId' => '00000000-0000-0000-0000-000000000001',
                'city' => 'Toronto',
                'country' => 'CA',
                'department' => 'Dev',
                'givenName' => 'Test',
                'userPrincipalName' => 'testuser1@example.onmicrosoft.com',
                'mail' => 'testuser1@example.onmicrosoft.com',
                'surname' => 'User1',
            ],
            [
                'auth' => 'oidc',
                'username' => 'testuser1@example.onmicrosoft.com',
                'firstname' => 'Test',
                'lastname' => 'User1',
                'email' => 'testuser1@example.onmicrosoft.com',
                'city' => 'Toronto',
                'country' => 'CA',
                'department' => 'Dev',
                'lang' => 'en',
                'confirmed' => '1',
                'deleted' => '0',
                'mnethostid' => $CFG->mnet_localhost_id,
            ],
        ];

        $tests['nocity'] = [
            [
                'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
                'objectType' => 'User',
                'objectId' => '00000000-0000-0000-0000-000000000002',
                'country' => 'CA',
                'department' => 'Dev',
                'givenName' => 'Test',
                'userPrincipalName' => 'testuser2@example.onmicrosoft.com',
                'mail' => 'testuser2@example.onmicrosoft.com',
                'surname' => 'User2',
            ],
            [
                'auth' => 'oidc',
                'username' => 'testuser2@example.onmicrosoft.com',
                'firstname' => 'Test',
                'lastname' => 'User2',
                'email' => 'testuser2@example.onmicrosoft.com',
                'city' => '',
                'country' => 'CA',
                'department' => 'Dev',
                'lang' => 'en',
                'confirmed' => '1',
                'deleted' => '0',
                'mnethostid' => $CFG->mnet_localhost_id,
            ],
        ];

        $tests['nocountry'] = [
            [
                'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
                'objectType' => 'User',
                'objectId' => '00000000-0000-0000-0000-000000000003',
                'department' => 'Dev',
                'givenName' => 'Test',
                'userPrincipalName' => 'testuser3@example.onmicrosoft.com',
                'mail' => 'testuser3@example.onmicrosoft.com',
                'surname' => 'User3',
            ],
            [
                'auth' => 'oidc',
                'username' => 'testuser3@example.onmicrosoft.com',
                'firstname' => 'Test',
                'lastname' => 'User3',
                'email' => 'testuser3@example.onmicrosoft.com',
                'city' => '',
                'country' => '',
                'department' => 'Dev',
                'lang' => 'en',
                'confirmed' => '1',
                'deleted' => '0',
                'mnethostid' => $CFG->mnet_localhost_id,
            ],
        ];

        $tests['nodepartment'] = [
            [
                'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
                'objectType' => 'User',
                'objectId' => '00000000-0000-0000-0000-000000000004',
                'givenName' => 'Test',
                'userPrincipalName' => 'testuser4@example.onmicrosoft.com',
                'mail' => 'testuser4@example.onmicrosoft.com',
                'surname' => 'User4',
            ],
            [
                'auth' => 'oidc',
                'username' => 'testuser4@example.onmicrosoft.com',
                'firstname' => 'Test',
                'lastname' => 'User4',
                'email' => 'testuser4@example.onmicrosoft.com',
                'city' => '',
                'country' => '',
                'department' => '',
                'lang' => 'en',
                'confirmed' => '1',
                'deleted' => '0',
                'mnethostid' => $CFG->mnet_localhost_id,
            ],
        ];

        return $tests;
    }

    /**
     * Test create_user_from_aaddata method.
     *
     * @dataProvider dataprovider_create_user_from_aaddata
     * @param array $aaddata The AzureAD user data to create the user from.
     * @param array $expecteduser The expected user data to be created.
     */
    public function test_create_user_from_aaddata($aaddata, $expecteduser) {
        global $DB;
        $httpclient = new \local_o365\tests\mockhttpclient();
        $apiclient = new \local_o365\rest\azuread($this->get_mock_token(), $httpclient);
        $apiclient->create_user_from_aaddata($aaddata);

        $userparams = ['auth' => 'oidc', 'username' => $aaddata['mail']];
        $this->assertTrue($DB->record_exists('user', $userparams));
        $createduser = $DB->get_record('user', $userparams);

        foreach ($expecteduser as $k => $v) {
            $this->assertEquals($v, $createduser->$k);
        }
    }

    /**
     * Test sync_users method.
     */
    public function test_sync_users() {
        global $CFG, $DB;

        for ($i = 1; $i <= 2; $i++) {
            $muser = [
                'auth' => 'oidc',
                'deleted' => '0',
                'mnethostid' => $CFG->mnet_localhost_id,
                'username' => '00000000-0000-0000-0000-00000000000'.$i,
                'firstname' => 'Test',
                'lastname' => 'User'.$i,
                'email' => 'testuser'.$i.'@example.onmicrosoft.com',
                'lang' => 'en'
            ];
            $DB->insert_record('user', (object)$muser);

            $token = [
                'oidcuniqid' => '00000000-0000-0000-0000-00000000000'.$i,
                'authcode' => '000',
                'username' => 'testuser'.$i.'@example.onmicrosoft.com',
                'scope' => 'test',
                'resource' => \local_o365\rest\azuread::get_resource(),
                'token' => '000',
                'expiry' => '9999999999',
                'refreshtoken' => 'fsdfsdf'.$i,
                'idtoken' => 'sdfsdfsdf'.$i,
            ];
            $DB->insert_record('auth_oidc_token', (object)$token);
        }

        $response = [
            'value' => [
                $this->get_aad_userinfo(1),
                $this->get_aad_userinfo(3),
            ],
        ];
        $response = json_encode($response);
        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpclient->set_response($response);

        $apiclient = new \local_o365\rest\azuread($this->get_mock_token(), $httpclient);
        $aadusers = $apiclient->get_users();
        $apiclient->sync_users($aadusers['value']);

        $existinguser = ['auth' => 'oidc', 'username' => 'testuser1@example.onmicrosoft.com'];
        $this->assertTrue($DB->record_exists('user', $existinguser));

        $createduser = ['auth' => 'oidc', 'username' => 'testuser3@example.onmicrosoft.com'];
        $this->assertTrue($DB->record_exists('user', $createduser));
        $createduser = $DB->get_record('user', $createduser);
        $this->assertEquals('Test', $createduser->firstname);
        $this->assertEquals('User3', $createduser->lastname);
        $this->assertEquals('testuser3@example.onmicrosoft.com', $createduser->email);
        $this->assertEquals('Toronto', $createduser->city);
        $this->assertEquals('CA', $createduser->country);
        $this->assertEquals('Dev', $createduser->department);
        $this->assertEquals('en', $createduser->lang);
    }

    /**
     * Test transform_full_request_uri method.
     */
    public function test_transform_full_request_uri() {
        $httpclient = new \local_o365\tests\mockhttpclient();
        $apiclient = new azuread_mock($this->get_mock_token(), $httpclient);

        $requesturi = 'https://graph.windows.net/users';
        $expecteduri = 'https://graph.windows.net/users?api-version=1.5';
        $actualuri = $apiclient->transform_full_request_uri($requesturi);
        $this->assertEquals($expecteduri, $actualuri);

        $requesturi = 'https://graph.windows.net/users?something';
        $expecteduri = 'https://graph.windows.net/users?something&api-version=1.5';
        $actualuri = $apiclient->transform_full_request_uri($requesturi);
        $this->assertEquals($expecteduri, $actualuri);
    }
}
