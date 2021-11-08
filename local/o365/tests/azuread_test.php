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
 * @codeCoverageIgnore
 */
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
 * @group office365
 * @codeCoverageIgnore
 */
class local_o365_azuread_testcase extends \advanced_testcase {
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
     * Test transform_full_request_uri method.
     */
    public function test_transform_full_request_uri() {
        $httpclient = new \local_o365\tests\mockhttpclient();
        $apiclient = new azuread_mock($this->get_mock_token(), $httpclient);

        $requesturi = 'https://graph.microsoft.com/users';
        $expecteduri = 'https://graph.microsoft.com/users?api-version=1.5';
        $actualuri = $apiclient->transform_full_request_uri($requesturi);
        $this->assertEquals($expecteduri, $actualuri);

        $requesturi = 'https://graph.microsoft.com/users?something';
        $expecteduri = 'https://graph.microsoft.com/users?something&api-version=1.5';
        $actualuri = $apiclient->transform_full_request_uri($requesturi);
        $this->assertEquals($expecteduri, $actualuri);
    }
}
