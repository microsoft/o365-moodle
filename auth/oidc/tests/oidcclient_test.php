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
 * OIDC client test cases.
 *
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */



namespace auth_oidc;

defined('MOODLE_INTERNAL') || die();

global $CFG;

/**
 * Tests oidcclient.
 *
 * @group auth_oidc
 * @group office365
 */
final class oidcclient_test extends \advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test getting and setting credentials.
     *
     * @covers \auth_oidc\tests\mockoidcclient::setcreds
     */
    public function test_creds_getters_and_setters(): void {
        $httpclient = new \auth_oidc\tests\mockhttpclient();
        $client = new \auth_oidc\tests\mockoidcclient($httpclient);

        $this->assertNull($client->get_clientid());
        $this->assertNull($client->get_clientsecret());
        $this->assertNull($client->get_redirecturi());

        $id = 'id';
        $secret = 'secret';
        $redirecturi = 'redirecturi';
        $tokenresource = 'resource';
        $scope = (isset($this->config->oidcscope)) ? $this->config->oidcscope : null;
        $client->setcreds($id, $secret, $redirecturi, $tokenresource, $scope);

        $this->assertEquals($id, $client->get_clientid());
        $this->assertEquals($secret, $client->get_clientsecret());
        $this->assertEquals($redirecturi, $client->get_redirecturi());
        $this->assertEquals($tokenresource, $client->get_tokenresource());
    }

    /**
     * Dataprovider returning IdP types and whether the 'resource' param is expected in the auth request.
     *
     * @return array Array of arrays of test parameters.
     */
    public static function dataprovider_authrequestparams_idptype(): array {
        require_once(__DIR__ . '/../lib.php');

        return [
            'Microsoft Entra ID (v1.0)' => [AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, true],
            'Microsoft identity platform (v2.0)' => [AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, false],
            'Other' => [AUTH_OIDC_IDP_TYPE_OTHER, false],
        ];
    }

    /**
     * Test that the 'resource' auth request param is only sent for IdP types that support it.
     *
     * @dataProvider dataprovider_authrequestparams_idptype
     * @covers \auth_oidc\tests\mockoidcclient::getauthrequestparams
     * @param int $idptype
     * @param bool $expectresource
     */
    public function test_getauthrequestparams_resource_by_idptype(int $idptype, bool $expectresource): void {
        set_config('idptype', $idptype, 'auth_oidc');

        $httpclient = new \auth_oidc\tests\mockhttpclient();
        $client = new \auth_oidc\tests\mockoidcclient($httpclient);
        $tokenresource = 'https://graph.microsoft.com';
        $client->setcreds('id', 'secret', 'redirecturi', $tokenresource, 'openid');

        $params = $client->getauthrequestparams();

        if ($expectresource) {
            $this->assertArrayHasKey('resource', $params);
            $this->assertEquals($tokenresource, $params['resource']);
        } else {
            $this->assertArrayNotHasKey('resource', $params);
        }
    }

    /**
     * Dataprovider for the prompt parameter of authorization requests.
     *
     * @return array Array of arrays of test parameters.
     */
    public static function dataprovider_prompt(): array {
        return [
            'default' => [[], false, false, null],
            'force setting' => [['forceselectaccount' => 1], false, false, 'select_account'],
            'select account requested' => [[], false, true, 'select_account'],
            'promptlogin wins over force setting' => [['forceselectaccount' => 1], true, false, 'login'],
            'silent mode wins over force setting' => [
                ['forceselectaccount' => 1, 'silentloginmode' => 1], false, false, 'none',
            ],
        ];
    }

    /**
     * Test the prompt parameter of authorization requests.
     *
     * @dataProvider dataprovider_prompt
     * @covers \auth_oidc\oidcclient::getauthrequestparams
     * @param array $config
     * @param bool $promptlogin
     * @param bool $selectaccount
     * @param string|null $expected
     */
    public function test_getauthrequestparams_prompt(
        array $config,
        bool $promptlogin,
        bool $selectaccount,
        ?string $expected
    ): void {
        foreach ($config as $name => $value) {
            set_config($name, $value, 'auth_oidc');
        }
        $client = new \auth_oidc\tests\mockoidcclient(new \auth_oidc\tests\mockhttpclient());
        $client->setcreds('id', 'secret', 'http://example.com/redirect', 'resource', 'openid');

        $params = $client->getauthrequestparams($promptlogin, [], [], $selectaccount);

        if ($expected === null) {
            $this->assertArrayNotHasKey('prompt', $params);
        } else {
            $this->assertEquals($expected, $params['prompt']);
        }
    }

    /**
     * Dataprovider returning endpoints.
     *
     * @return array Array of arrays of test parameters.
     */
    public static function dataprovider_endpoints(): array {
        $tests = [];

        $tests['oneinvalid'] = [
                ['auth' => 100],
                ['Exception', 'Invalid Endpoint URI received.'],
        ];

        $tests['oneinvalidonevalid1'] = [
                ['auth' => 100, 'token' => 'http://example.com/token'],
                ['Exception', 'Invalid Endpoint URI received.'],
        ];

        $tests['oneinvalidonevalid2'] = [
                ['token' => 'http://example.com/token', 'auth' => 100],
                ['Exception', 'Invalid Endpoint URI received.'],
        ];

        $tests['onevalid'] = [
                ['token' => 'http://example.com/token'],
                [],
        ];

        $tests['twovalid'] = [
                ['auth' => 'http://example.com/auth', 'token' => 'http://example.com/token'],
                [],
        ];

        return $tests;
    }

    /**
     * Test setting and getting endpoints.
     *
     * @dataProvider dataprovider_endpoints
     * @covers \auth_oidc\tests\mockoidcclient::setendpoints
     * @param array $endpoints
     * @param array $expectedexception
     */
    public function test_endpoints_getters_and_setters(array $endpoints, array $expectedexception): void {
        if (!empty($expectedexception)) {
            $this->expectException($expectedexception[0]);
            $this->expectExceptionMessage($expectedexception[1]);
        }
        $httpclient = new \auth_oidc\tests\mockhttpclient();
        $client = new \auth_oidc\tests\mockoidcclient($httpclient);
        $client->setendpoints($endpoints);

        foreach ($endpoints as $type => $uri) {
            $this->assertEquals($uri, $client->get_endpoint($type));
        }
    }

    /**
     * The scope requested from Microsoft Graph in the Microsoft Identity Platform requests follows the Microsoft cloud setting.
     *
     * @covers \auth_oidc\oidcclient::app_access_token_request
     * @covers \auth_oidc\oidcclient::getadminconsentrequestparams
     */
    public function test_identity_platform_requests_use_graph_of_the_cloud_in_use(): void {
        require_once(__DIR__ . '/../lib.php');

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_IDENTITY_PLATFORM, 'auth_oidc');
        set_config('clientauthmethod', AUTH_OIDC_AUTH_METHOD_SECRET, 'auth_oidc');

        $cases = [
            [AUTH_OIDC_MICROSOFT_CLOUD_GLOBAL, 'https://graph.microsoft.com/.default'],
            [AUTH_OIDC_MICROSOFT_CLOUD_CHINA, 'https://microsoftgraph.chinacloudapi.cn/.default'],
        ];
        foreach ($cases as [$microsoftcloud, $expectedscope]) {
            set_config('microsoftcloud', $microsoftcloud, 'auth_oidc');

            $postedparams = null;
            $httpclient = $this->createMock(\auth_oidc\httpclient::class);
            $httpclient->method('post')->willReturnCallback(function ($url, $params) use (&$postedparams) {
                $postedparams = $params;
                return json_encode(['access_token' => 'token']);
            });

            $client = new \auth_oidc\tests\mockoidcclient($httpclient);
            $client->setcreds('id', 'secret', 'https://example.com/redirect');
            $client->setendpoints(['token' => 'https://example.com/token']);

            $client->app_access_token_request();
            $this->assertSame($expectedscope, $postedparams['scope']);

            $getparams = new \ReflectionMethod($client, 'getadminconsentrequestparams');
            $this->assertSame($expectedscope, $getparams->invoke($client)['scope']);
        }
    }

    /**
     * Test that the PKCE S256 code challenge matches the example in RFC 7636 appendix B.
     *
     * @covers \auth_oidc\oidcclient::get_code_challenge
     */
    public function test_get_code_challenge(): void {
        $this->assertEquals(
            'E9Melhoa2OwvFrEMTJguCHaoeK1t8URWbuGJSstw-cM',
            oidcclient::get_code_challenge('dBjftJeZ4CVP-mB92K27uhbUJU1p1r_wW1gFWFOEjXk')
        );
    }

    /**
     * Test that generated PKCE code verifiers are valid and unique.
     *
     * @covers \auth_oidc\oidcclient::generate_code_verifier
     */
    public function test_generate_code_verifier(): void {
        $verifier = oidcclient::generate_code_verifier();
        $this->assertMatchesRegularExpression('/^[A-Za-z0-9_-]{43,128}$/', $verifier);
        $this->assertNotEquals($verifier, oidcclient::generate_code_verifier());
    }

    /**
     * Test that, with PKCE enabled, the authorization request carries the S256 challenge of the verifier stored with its state.
     *
     * @covers \auth_oidc\oidcclient::getauthrequestparams
     * @covers \auth_oidc\oidcclient::getnewstate
     */
    public function test_authrequest_pkce_challenge_matches_stored_verifier(): void {
        global $DB;

        set_config('usepkce', 1, 'auth_oidc');
        $client = new \auth_oidc\tests\mockoidcclient(new \auth_oidc\tests\mockhttpclient());
        $client->setcreds('id', 'secret', 'http://example.com/redirect', 'resource', 'openid');

        $params = $client->getauthrequestparams();

        $this->assertEquals('S256', $params['code_challenge_method']);
        $staterec = $DB->get_record('auth_oidc_state', ['state' => $params['state']], '*', MUST_EXIST);
        $this->assertMatchesRegularExpression('/^[A-Za-z0-9_-]{43,128}$/', $staterec->codeverifier);
        $this->assertEquals(oidcclient::get_code_challenge($staterec->codeverifier), $params['code_challenge']);
        $this->assertArrayNotHasKey('code_verifier', $params);
    }

    /**
     * Test that, with PKCE disabled, the authorization request has no challenge and no verifier is stored.
     *
     * @covers \auth_oidc\oidcclient::getauthrequestparams
     */
    public function test_authrequest_without_pkce_omits_challenge(): void {
        global $DB;

        set_config('usepkce', 0, 'auth_oidc');
        $client = new \auth_oidc\tests\mockoidcclient(new \auth_oidc\tests\mockhttpclient());
        $client->setcreds('id', 'secret', 'http://example.com/redirect', 'resource', 'openid');

        $params = $client->getauthrequestparams();

        $this->assertArrayNotHasKey('code_challenge', $params);
        $this->assertArrayNotHasKey('code_challenge_method', $params);
        $staterec = $DB->get_record('auth_oidc_state', ['state' => $params['state']], '*', MUST_EXIST);
        $this->assertEmpty($staterec->codeverifier);
    }

    /**
     * Test that the token request sends the code verifier when there is one, and omits it when there is not.
     *
     * @covers \auth_oidc\oidcclient::tokenrequest
     */
    public function test_tokenrequest_sends_code_verifier_only_when_present(): void {
        $httpclient = new \auth_oidc\tests\mockhttpclient();
        $httpclient->set_response(json_encode(['id_token' => 'idtoken', 'access_token' => 'accesstoken']));
        $client = new \auth_oidc\tests\mockoidcclient($httpclient);
        $client->setcreds('id', 'secret', 'http://example.com/redirect', 'resource', 'openid');
        $client->setendpoints(['auth' => 'http://example.com/auth', 'token' => 'http://example.com/token']);

        $client->tokenrequest('thecode', 'theverifier');
        $client->tokenrequest('thecode');

        $this->assertCount(2, $httpclient->postrequests);
        $this->assertEquals('theverifier', $httpclient->postrequests[0]['params']['code_verifier']);
        $this->assertEquals('thecode', $httpclient->postrequests[0]['params']['code']);
        $this->assertArrayNotHasKey('code_verifier', $httpclient->postrequests[1]['params']);
    }
}
