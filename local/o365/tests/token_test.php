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
 * Token test cases.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365;

use advanced_testcase;

/**
 * Tests \local_o365\oauth2\token
 *
 * @group local_o365
 * @group office365
 */
final class token_test extends advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test refresh method.
     *
     * @covers \local_o365\oauth2\token::refresh
     */
    public function test_refresh(): void {
        global $USER, $DB;
        $this->setAdminUser();
        $now = time();

        $httpclient = new \local_o365\tests\mockhttpclient();
        $newtokenresponse = [
            'access_token' => 'newtoken',
            'expires_on' => $now + 1000,
            'refresh_token' => 'newrefreshtoken',
            'scope' => 'newscope',
            'resource' => 'newresource',
        ];
        $newtokenresponse = json_encode($newtokenresponse);
        $httpclient->set_response($newtokenresponse);

        $oidcconfig = (object)[
            'clientid' => 'clientid',
            'clientsecret' => 'clientsecret',
            'authendpoint' => 'http://example.com/auth',
            'tokenendpoint' => 'http://example.com/token',
        ];

        $tokenrec = (object)[
            'token' => 'oldtoken',
            'expiry' => $now - 1000,
            'refreshtoken' => 'refreshtoken',
            'scope' => 'oldscope',
            'tokenresource' => 'oldresource',
            'user_id' => $USER->id,
        ];
        $tokenrec->id = $DB->insert_record('local_o365_token', $tokenrec);

        $clientdata = new \local_o365\oauth2\clientdata(
            $oidcconfig->clientid,
            $oidcconfig->clientsecret,
            $oidcconfig->authendpoint,
            $oidcconfig->tokenendpoint
        );
        $token = new \local_o365\oauth2\token(
            $tokenrec->token,
            $tokenrec->expiry,
            $tokenrec->refreshtoken,
            $tokenrec->scope,
            $tokenrec->tokenresource,
            $tokenrec->user_id,
            $clientdata,
            $httpclient
        );
        $token->refresh();

        $this->assertEquals(1, $DB->count_records('local_o365_token'));

        $tokenrec = $DB->get_record('local_o365_token', ['id' => $tokenrec->id]);
        $this->assertEquals('newtoken', $tokenrec->token);
        $this->assertEquals('newrefreshtoken', $tokenrec->refreshtoken);
        $this->assertEquals('newscope', $tokenrec->scope);
        $this->assertEquals('newresource', $tokenrec->tokenresource);
        $this->assertEquals($now + 1000, $tokenrec->expiry);

        $this->assertEquals('newtoken', $token->get_token());
        $this->assertEquals('newrefreshtoken', $token->get_refreshtoken());
        $this->assertEquals('newscope', $token->get_scope());
        $this->assertEquals('newresource', $token->get_tokenresource());
        $this->assertEquals($now + 1000, $token->get_expiry());
    }

    /**
     * Test detection of token endpoint responses that require multi-factor authentication.
     *
     * @param mixed $tokenresult The decoded token endpoint response.
     * @param bool $expected The expected result.
     *
     * @covers \local_o365\oauth2\token::is_mfa_required_response
     * @dataProvider is_mfa_required_response_provider
     */
    public function test_is_mfa_required_response($tokenresult, bool $expected): void {
        $this->assertSame($expected, \local_o365\oauth2\token::is_mfa_required_response($tokenresult));
    }

    /**
     * Data provider for test_is_mfa_required_response().
     *
     * @return array
     */
    public static function is_mfa_required_response_provider(): array {
        return [
            'interaction required error' => [['error' => 'interaction_required'], true],
            'mfa error code only' => [['error' => 'invalid_grant', 'error_codes' => [50076]], true],
            'full mfa response' => [
                [
                    'error' => 'interaction_required',
                    'error_description' => 'AADSTS50076: you must use multi-factor authentication.',
                    'error_codes' => [50076],
                    'suberror' => 'basic_action',
                ],
                true,
            ],
            'other error' => [['error' => 'invalid_grant', 'error_codes' => [70008]], false],
            'successful response' => [['token_type' => 'Bearer', 'access_token' => 'token'], false],
            'empty array' => [[], false],
            'not an array' => [null, false],
        ];
    }

    /**
     * Test that a refresh rejected because multi-factor authentication is required is flagged for the user.
     *
     * @covers \local_o365\oauth2\token::get_for_new_resource
     * @covers \local_o365\oauth2\token::consume_mfa_required_for_user
     */
    public function test_get_for_new_resource_flags_mfa_required(): void {
        global $DB;

        $user = $this->getDataGenerator()->create_user();
        $otheruser = $this->getDataGenerator()->create_user();

        // The Graph token, which is used to get tokens for other resources, is stored by auth_oidc.
        $DB->insert_record('auth_oidc_token', (object)[
            'oidcuniqid' => 'oidcuniqid' . $user->id,
            'username' => $user->username,
            'userid' => $user->id,
            'oidcusername' => $user->username,
            'scope' => 'scope',
            'tokenresource' => 'https://graph.microsoft.com',
            'authcode' => 'authcode',
            'token' => 'graphtoken',
            'expiry' => time() - 1000,
            'refreshtoken' => 'refreshtoken',
            'idtoken' => 'idtoken',
        ]);

        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpclient->set_response(json_encode([
            'error' => 'interaction_required',
            'error_description' => 'AADSTS50076: you must use multi-factor authentication.',
            'error_codes' => [50076],
        ]));
        $clientdata = new \local_o365\oauth2\clientdata(
            'clientid',
            'clientsecret',
            'http://example.com/auth',
            'http://example.com/token'
        );

        $gettoken = function () use ($user, $clientdata, $httpclient) {
            return \local_o365\oauth2\token::get_for_new_resource(
                $user->id,
                'https://outlook.office.com',
                $clientdata,
                $httpclient
            );
        };

        $this->assertFalse(\local_o365\oauth2\token::consume_mfa_required_for_user($user->id));

        $this->assertFalse($gettoken());
        $this->assertFalse(\local_o365\oauth2\token::consume_mfa_required_for_user($otheruser->id));
        $this->assertTrue(\local_o365\oauth2\token::consume_mfa_required_for_user($user->id));
        // The flag is one-shot, reading it clears it.
        $this->assertFalse(\local_o365\oauth2\token::consume_mfa_required_for_user($user->id));

        // A later attempt that fails for a different reason must not leave the flag set by an earlier attempt.
        $this->assertFalse($gettoken());
        $httpclient->set_response(json_encode(['error' => 'invalid_grant', 'error_codes' => [70008]]));
        $this->assertFalse($gettoken());
        $this->assertFalse(\local_o365\oauth2\token::consume_mfa_required_for_user($user->id));
    }
}
