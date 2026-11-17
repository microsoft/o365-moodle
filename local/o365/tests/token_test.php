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

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/auth/oidc/lib.php');

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
     * Test the refresh request and response handling for each IdP type.
     *
     * @dataProvider refresh_by_idptype_provider
     * @covers \local_o365\oauth2\token::refresh
     * @param int $idptype The IdP type.
     * @param array $expectedparams Request parameters expected to be sent.
     * @param array $unexpectedparams Request parameters expected not to be sent.
     * @param array $response The token endpoint response.
     * @param string $expectedrefreshtoken The expected refresh token after the refresh.
     * @param string $expectedresource The expected token resource after the refresh.
     */
    public function test_refresh_by_idptype(
        int $idptype,
        array $expectedparams,
        array $unexpectedparams,
        array $response,
        string $expectedrefreshtoken,
        string $expectedresource
    ): void {
        global $USER, $DB;
        $this->setAdminUser();
        set_config('idptype', $idptype, 'auth_oidc');
        $now = time();

        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpclient->set_response(json_encode($response));

        $tokenrec = (object)[
            'token' => 'oldtoken',
            'expiry' => $now - 1000,
            'refreshtoken' => 'refreshtoken',
            'scope' => 'oldscope',
            'tokenresource' => 'https://graph.microsoft.com',
            'user_id' => $USER->id,
        ];
        $tokenrec->id = $DB->insert_record('local_o365_token', $tokenrec);

        $clientdata = new \local_o365\oauth2\clientdata(
            'clientid',
            'clientsecret',
            'http://example.com/auth',
            'http://example.com/token'
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
        $this->assertTrue($token->refresh());

        $requests = $httpclient->get_requests();
        parse_str($requests[0]['options']['CURLOPT_POSTFIELDS'], $sent);
        foreach ($expectedparams as $name => $value) {
            $this->assertEquals($value, $sent[$name]);
        }
        foreach ($unexpectedparams as $name) {
            $this->assertArrayNotHasKey($name, $sent);
        }

        $this->assertEquals('newtoken', $token->get_token());
        $this->assertEquals($expectedrefreshtoken, $token->get_refreshtoken());
        $this->assertEquals($expectedresource, $token->get_tokenresource());
        if (isset($response['expires_on'])) {
            $this->assertEquals($response['expires_on'], $token->get_expiry());
        } else {
            $this->assertEqualsWithDelta($now + $response['expires_in'], $token->get_expiry(), 10);
        }
    }

    /**
     * Data provider for test_refresh_by_idptype().
     *
     * @return array
     */
    public static function refresh_by_idptype_provider(): array {
        return [
            'Microsoft Entra ID (v1.0) sends the resource' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID,
                ['resource' => 'https://graph.microsoft.com'],
                ['scope'],
                [
                    'token_type' => 'Bearer',
                    'access_token' => 'newtoken',
                    'expires_on' => 2000000000,
                    'refresh_token' => 'newrefreshtoken',
                    'scope' => 'newscope',
                    'resource' => 'newresource',
                ],
                'newrefreshtoken',
                'newresource',
            ],
            'Microsoft identity platform (v2.0) sends scopes' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM,
                ['scope' => 'https://graph.microsoft.com/.default offline_access'],
                ['resource'],
                [
                    'token_type' => 'Bearer',
                    'access_token' => 'newtoken',
                    'expires_in' => 3600,
                    'refresh_token' => 'newrefreshtoken',
                    'scope' => 'newscope',
                ],
                'newrefreshtoken',
                'https://graph.microsoft.com',
            ],
            'Microsoft identity platform (v2.0) keeps the refresh token when none is returned' => [
                AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM,
                ['scope' => 'https://graph.microsoft.com/.default offline_access'],
                ['resource'],
                [
                    'token_type' => 'Bearer',
                    'access_token' => 'newtoken',
                    'expires_in' => 3600,
                ],
                'refreshtoken',
                'https://graph.microsoft.com',
            ],
        ];
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

    /**
     * Test that a token for a new resource can be stored with the Microsoft identity platform (v2.0).
     *
     * The v2.0 token response has no resource, and the scope is not always returned. The scope must never be null, because it
     * cannot be stored.
     *
     * @dataProvider get_for_new_resource_v2_provider
     * @covers \local_o365\oauth2\token::get_for_new_resource
     * @param array $response Extra fields of the token endpoint response.
     * @param string $expectedscope The expected stored scope.
     */
    public function test_get_for_new_resource_with_identity_platform(array $response, string $expectedscope): void {
        global $DB;

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');
        $user = $this->getDataGenerator()->create_user();

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
            'token_type' => 'Bearer',
            'access_token' => 'newtoken',
            'expires_in' => 3600,
        ] + $response));
        $clientdata = new \local_o365\oauth2\clientdata(
            'clientid',
            'clientsecret',
            'http://example.com/auth',
            'http://example.com/token'
        );

        $token = \local_o365\oauth2\token::get_for_new_resource(
            $user->id,
            'https://outlook.office.com',
            $clientdata,
            $httpclient
        );

        $this->assertInstanceOf(\local_o365\oauth2\token::class, $token);
        $this->assertEquals('newtoken', $token->get_token());
        $this->assertEquals('https://outlook.office.com', $token->get_tokenresource());
        $this->assertSame($expectedscope, $token->get_scope());

        $requests = $httpclient->get_requests();
        parse_str($requests[0]['options']['CURLOPT_POSTFIELDS'], $sent);
        $this->assertEquals('https://outlook.office.com/.default offline_access', $sent['scope']);
        $this->assertArrayNotHasKey('resource', $sent);
    }

    /**
     * Data provider for test_get_for_new_resource_with_identity_platform().
     *
     * @return array
     */
    public static function get_for_new_resource_v2_provider(): array {
        return [
            'scope returned' => [['scope' => 'Calendars.ReadWrite'], 'Calendars.ReadWrite'],
            'scope not returned' => [[], ''],
        ];
    }

    /**
     * Create a user with a Graph token stored by auth_oidc, and another user's token for a different resource with the same ID.
     *
     * @param string $graphresource The resource stored with the Graph token.
     * @return array The user and the ID of the Graph token, which is also the ID of the other user's token.
     */
    protected function create_graph_token_and_colliding_token(string $graphresource = 'https://graph.microsoft.com'): array {
        global $DB;

        $user = $this->getDataGenerator()->create_user();
        $otheruser = $this->getDataGenerator()->create_user();

        $graphtokenid = $DB->insert_record('auth_oidc_token', (object)[
            'oidcuniqid' => 'oidcuniqid' . $user->id,
            'username' => $user->username,
            'userid' => $user->id,
            'oidcusername' => $user->username,
            'scope' => 'oldscope',
            'tokenresource' => $graphresource,
            'authcode' => 'authcode',
            'token' => 'oldgraphtoken',
            'expiry' => time() - 1000,
            'refreshtoken' => 'oldrefreshtoken',
            'idtoken' => 'idtoken',
        ]);

        // A token of another user in local_o365_token, with the same ID as the Graph token in auth_oidc_token.
        $DB->import_record('local_o365_token', (object)[
            'id' => $graphtokenid,
            'user_id' => $otheruser->id,
            'scope' => 'otherscope',
            'tokenresource' => 'https://outlook.office.com',
            'token' => 'othertoken',
            'expiry' => time() + 1000,
            'refreshtoken' => 'otherrefreshtoken',
        ]);

        return [$user, $graphtokenid];
    }

    /**
     * Test that refreshing the Graph token updates it in auth_oidc_token, and does not touch local_o365_token.
     *
     * @covers \local_o365\oauth2\token::refresh
     */
    public function test_refresh_updates_graph_token_in_source_table(): void {
        global $DB;

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');
        [$user, $graphtokenid] = $this->create_graph_token_and_colliding_token();
        $othertoken = $DB->get_record('local_o365_token', ['id' => $graphtokenid]);

        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpclient->set_response(json_encode([
            'token_type' => 'Bearer',
            'access_token' => 'newgraphtoken',
            'expires_in' => 3600,
            'refresh_token' => 'newrefreshtoken',
            'scope' => 'newscope',
        ]));
        $clientdata = new \local_o365\oauth2\clientdata(
            'clientid',
            'clientsecret',
            'http://example.com/auth',
            'http://example.com/token'
        );

        $token = \local_o365\oauth2\token::instance($user->id, 'https://graph.microsoft.com', $clientdata, $httpclient);
        $this->assertTrue($token->refresh());

        $graphtoken = $DB->get_record('auth_oidc_token', ['id' => $graphtokenid]);
        $this->assertEquals('newgraphtoken', $graphtoken->token);
        $this->assertEquals('newrefreshtoken', $graphtoken->refreshtoken);
        $this->assertEquals('newscope', $graphtoken->scope);
        $this->assertEquals('https://graph.microsoft.com', $graphtoken->tokenresource);
        $this->assertGreaterThan(time(), $graphtoken->expiry);

        // The token of the other user in local_o365_token is untouched.
        $this->assertEquals($othertoken, $DB->get_record('local_o365_token', ['id' => $graphtokenid]));
        $this->assertEquals(1, $DB->count_records('local_o365_token'));
    }

    /**
     * Test refreshing a Graph token stored without a resource, as can happen with the Microsoft identity platform (v2.0).
     *
     * @covers \local_o365\oauth2\token::refresh
     * @covers \local_o365\oauth2\token::instance
     */
    public function test_refresh_graph_token_without_stored_resource(): void {
        global $DB;

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');
        [$user, $graphtokenid] = $this->create_graph_token_and_colliding_token('');
        $othertoken = $DB->get_record('local_o365_token', ['id' => $graphtokenid]);

        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpclient->set_response(json_encode([
            'token_type' => 'Bearer',
            'access_token' => 'newgraphtoken',
            'expires_in' => 3600,
            'refresh_token' => 'newrefreshtoken',
            'scope' => 'newscope',
        ]));
        $clientdata = new \local_o365\oauth2\clientdata(
            'clientid',
            'clientsecret',
            'http://example.com/auth',
            'http://example.com/token'
        );

        $token = \local_o365\oauth2\token::instance($user->id, 'https://graph.microsoft.com', $clientdata, $httpclient);
        $this->assertEquals('https://graph.microsoft.com', $token->get_tokenresource());
        $this->assertTrue($token->refresh());

        $requests = $httpclient->get_requests();
        parse_str($requests[0]['options']['CURLOPT_POSTFIELDS'], $sent);
        $this->assertEquals('https://graph.microsoft.com/.default offline_access', $sent['scope']);

        // The refreshed token is saved in auth_oidc_token, and local_o365_token is untouched.
        $graphtoken = $DB->get_record('auth_oidc_token', ['id' => $graphtokenid]);
        $this->assertEquals('newgraphtoken', $graphtoken->token);
        $this->assertEquals('newrefreshtoken', $graphtoken->refreshtoken);
        $this->assertEquals($othertoken, $DB->get_record('local_o365_token', ['id' => $graphtokenid]));
    }

    /**
     * Test that a token constructed without a resource requests the Graph resource of the Microsoft cloud in use.
     *
     * @covers \local_o365\oauth2\token::refresh
     */
    public function test_refresh_with_empty_resource_requests_graph_scope(): void {
        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');

        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpclient->set_response(json_encode([
            'token_type' => 'Bearer',
            'access_token' => 'newtoken',
            'expires_in' => 3600,
        ]));
        $clientdata = new \local_o365\oauth2\clientdata(
            'clientid',
            'clientsecret',
            'http://example.com/auth',
            'http://example.com/token'
        );

        $token = new \local_o365\oauth2\token(
            'oldtoken',
            time() - 1000,
            'refreshtoken',
            'oldscope',
            '',
            0,
            $clientdata,
            $httpclient
        );
        $this->assertTrue($token->refresh());

        $requests = $httpclient->get_requests();
        parse_str($requests[0]['options']['CURLOPT_POSTFIELDS'], $sent);
        $this->assertEquals(auth_oidc_get_graph_resource() . '/.default offline_access', $sent['scope']);
    }

    /**
     * Test that token requests are authenticated with a client assertion when certificate authentication is configured.
     *
     * @dataProvider certificate_authentication_provider
     * @covers \local_o365\oauth2\token::refresh
     * @covers \local_o365\oauth2\token::jump_tokenresource
     * @covers \local_o365\oauth2\token::get_for_new_resource
     * @param string $method The token method to test.
     * @param int $authmethod The configured authentication method.
     */
    public function test_token_requests_use_configured_client_authentication(string $method, int $authmethod): void {
        global $DB;

        $privatekey = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
        $csr = $privatekey ? openssl_csr_new(['commonName' => 'test'], $privatekey) : false;
        $certificate = $csr ? openssl_csr_sign($csr, null, $privatekey, 1) : false;
        if (!$certificate) {
            $this->markTestSkipped('Cannot generate a test certificate with OpenSSL.');
        }
        openssl_x509_export($certificate, $certificatepem);
        openssl_pkey_export($privatekey, $privatekeypem);

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');
        set_config('clientauthmethod', $authmethod, 'auth_oidc');
        set_config('clientcertsource', AUTH_OIDC_AUTH_CERT_SOURCE_TEXT, 'auth_oidc');
        set_config('clientcert', $certificatepem, 'auth_oidc');
        set_config('clientprivatekey', $privatekeypem, 'auth_oidc');
        set_config('clientid', 'clientid', 'auth_oidc');
        set_config('tokenendpoint', 'http://example.com/token', 'auth_oidc');

        $user = $this->getDataGenerator()->create_user();
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
            'token_type' => 'Bearer',
            'access_token' => 'newtoken',
            'expires_in' => 3600,
        ]));
        $clientdata = new \local_o365\oauth2\clientdata(
            'clientid',
            'clientsecret',
            'http://example.com/auth',
            'http://example.com/token'
        );
        $graphtoken = \local_o365\oauth2\token::instance($user->id, 'https://graph.microsoft.com', $clientdata, $httpclient);

        switch ($method) {
            case 'refresh':
                $graphtoken->refresh();
                break;
            case 'jump_tokenresource':
                \local_o365\oauth2\token::jump_tokenresource($graphtoken, 'https://outlook.office.com', $clientdata, $httpclient);
                break;
            case 'get_for_new_resource':
                \local_o365\oauth2\token::get_for_new_resource($user->id, 'https://outlook.office.com', $clientdata, $httpclient);
                break;
        }

        $requests = $httpclient->get_requests();
        parse_str($requests[0]['options']['CURLOPT_POSTFIELDS'], $sent);
        $this->assertEquals('clientid', $sent['client_id']);
        if ($authmethod == AUTH_OIDC_AUTH_METHOD_CERTIFICATE) {
            $this->assertArrayNotHasKey('client_secret', $sent);
            $this->assertEquals('urn:ietf:params:oauth:client-assertion-type:jwt-bearer', $sent['client_assertion_type']);
            $this->assertCount(3, explode('.', $sent['client_assertion']));
        } else {
            $this->assertEquals('clientsecret', $sent['client_secret']);
            $this->assertArrayNotHasKey('client_assertion', $sent);
            $this->assertArrayNotHasKey('client_assertion_type', $sent);
        }
    }

    /**
     * Data provider for test_token_requests_use_configured_client_authentication().
     *
     * @return array
     */
    public static function certificate_authentication_provider(): array {
        $data = [];
        foreach (['refresh', 'jump_tokenresource', 'get_for_new_resource'] as $method) {
            $data[$method . ' with a secret'] = [$method, AUTH_OIDC_AUTH_METHOD_SECRET];
            $data[$method . ' with a certificate'] = [$method, AUTH_OIDC_AUTH_METHOD_CERTIFICATE];
        }

        return $data;
    }

    /**
     * Test that a failed refresh of the Graph token does not delete tokens from local_o365_token or the login token.
     *
     * @covers \local_o365\oauth2\token::refresh
     */
    public function test_failed_refresh_of_graph_token_does_not_delete_other_tokens(): void {
        global $DB;

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');
        [$user, $graphtokenid] = $this->create_graph_token_and_colliding_token();

        $httpclient = new \local_o365\tests\mockhttpclient();
        $httpclient->set_response(json_encode(['error' => 'invalid_grant']));
        $clientdata = new \local_o365\oauth2\clientdata(
            'clientid',
            'clientsecret',
            'http://example.com/auth',
            'http://example.com/token'
        );

        $token = \local_o365\oauth2\token::instance($user->id, 'https://graph.microsoft.com', $clientdata, $httpclient);
        try {
            $token->refresh();
            $this->fail('Expected the refresh to fail.');
        } catch (\moodle_exception $e) {
            $this->assertEquals('errorcouldnotrefreshtoken', $e->errorcode);
        }

        $this->assertTrue($DB->record_exists('local_o365_token', ['id' => $graphtokenid]));
        $this->assertTrue($DB->record_exists('auth_oidc_token', ['id' => $graphtokenid]));
    }
}
