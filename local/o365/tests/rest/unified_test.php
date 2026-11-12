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
 * Unit tests for the unified class.
 *
 * @package local_o365
 * @author Christian Abila <christian.abila@edaktik.at>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2025 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\rest;

use advanced_testcase;
use core\component;
use dml_exception;
use local_o365\oauth2\apptoken;
use local_o365\oauth2\token;
use local_o365\tests\mockhttpclient;
use moodle_exception;

/**
 * Unit tests for the class unified
 *
 * @package   local_o365
 * @copyright 2025 eDaktik GmbH {@link https://www.edaktik.at/}
 * @author    Christian Abila <christian.abila@edaktik.at>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group local_o365
 * @group office365
 * @coversDefaultClass \local_o365\rest\unified
 */
final class unified_test extends advanced_testcase {
    /**
     * If oidcresource is set, its value is returned.
     *
     * @return void
     * @throws dml_exception
     * @covers ::get_tokenresource
     */
    public function test_get_token_oidc_resource(): void {
        $this->resetAfterTest();
        $pluginslist = component::get_plugin_list('auth');
        if (!array_key_exists('oidc', $pluginslist)) {
            $this->markTestSkipped('auth_oidc needs to be installed to use this test!');
        }

        $resource = 'resource';
        set_config('oidcresource', $resource, 'auth_oidc');

        $this->assertEquals($resource, unified::get_tokenresource());
    }

    /**
     * If oidcresource and the Chinese API are not set, "https://graph.microsoft.com" is returned.
     *
     * @return void
     * @covers ::get_tokenresource
     * @throws dml_exception
     */
    public function test_get_token_microsoft_resource(): void {
        $this->resetAfterTest();
        $pluginslist = component::get_plugin_list('auth');
        if (!array_key_exists('oidc', $pluginslist)) {
            $this->markTestSkipped('auth_oidc needs to be installed to use this test!');
        }

        $this->assertEquals(unified::RESOURCE_URL, unified::get_tokenresource());
    }

    /**
     * If oidcresource is not set and the China Microsoft cloud is selected, then the Chinese resource is returned.
     *
     * @return void
     * @covers ::get_tokenresource
     * @throws dml_exception
     */
    public function test_get_token_chinese_api(): void {
        $this->resetAfterTest();
        $pluginslist = component::get_plugin_list('auth');
        if (!array_key_exists('oidc', $pluginslist)) {
            $this->markTestSkipped('auth_oidc needs to be installed to use this test!');
        }

        global $CFG;
        require_once($CFG->dirroot . '/auth/oidc/lib.php');

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        set_config('microsoftcloud', AUTH_OIDC_MICROSOFT_CLOUD_CHINA, 'auth_oidc');

        $this->assertEquals(unified::RESOURCE_URL_CHINESE, unified::get_tokenresource());
    }

    /**
     * use_chinese_api() returns the correct value.
     *
     * @return void
     * @covers ::use_chinese_api
     */
    public function test_use_chinese_api_returns_correct_value(): void {
        $this->resetAfterTest();
        $this->assertFalse(unified::use_chinese_api());

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        set_config('microsoftcloud', AUTH_OIDC_MICROSOFT_CLOUD_CHINA, 'auth_oidc');
        $this->assertTrue(unified::use_chinese_api());
    }

    /**
     * Configure auth_oidc so that application tokens can be requested.
     *
     * @return void
     */
    private function setup_oidc_for_apptoken(): void {
        $pluginslist = component::get_plugin_list('auth');
        if (!array_key_exists('oidc', $pluginslist)) {
            $this->markTestSkipped('auth_oidc needs to be installed to use this test!');
        }

        set_config('idptype', AUTH_OIDC_IDP_TYPE_MICROSOFT_ENTRA_ID, 'auth_oidc');
        set_config('clientid', 'clientid', 'auth_oidc');
        set_config('clientsecret', 'clientsecret', 'auth_oidc');
        set_config('clientauthmethod', AUTH_OIDC_AUTH_METHOD_SECRET, 'auth_oidc');
    }

    /**
     * A tenant is valid if it issues an application token, and the tenant being tested is used in the request.
     *
     * @return void
     * @covers ::test_tenant
     */
    public function test_test_tenant_valid(): void {
        $this->resetAfterTest();
        $this->setup_oidc_for_apptoken();
        set_config('entratenant', 'saved.example.com', 'local_o365');

        $httpclient = new mockhttpclient();
        $httpclient->set_response(json_encode(['token_type' => 'Bearer', 'access_token' => 'token', 'expires_in' => 3600]));

        $this->assertTrue(unified::test_tenant('tested.example.com', $httpclient));

        $requests = $httpclient->get_requests();
        $this->assertCount(1, $requests);
        $this->assertStringContainsString('/tested.example.com/', $requests[0]['url']);

        // The tested tenant is not saved, and no token is stored.
        $this->assertEquals('saved.example.com', get_config('local_o365', 'entratenant'));
        $this->assertEmpty(get_config('local_o365', 'apptokens'));
    }

    /**
     * A tenant is invalid if it does not issue an application token.
     *
     * @return void
     * @covers ::test_tenant
     */
    public function test_test_tenant_invalid(): void {
        $this->resetAfterTest();
        $this->setup_oidc_for_apptoken();

        $httpclient = new mockhttpclient();
        $httpclient->set_response(json_encode([
            'error' => 'invalid_request',
            'error_description' => 'AADSTS90002: Tenant not found.',
        ]));

        $this->assertFalse(unified::test_tenant('wrong.example.org', $httpclient));
        $this->assertEquals(
            'invalid_request: AADSTS90002: Tenant not found.',
            apptoken::get_last_error()
        );
    }

    /**
     * A tenant is invalid if the token endpoint does not return JSON, and the reason names the endpoint.
     *
     * @return void
     * @covers ::test_tenant
     */
    public function test_test_tenant_invalid_response(): void {
        $this->resetAfterTest();
        $this->setup_oidc_for_apptoken();

        $httpclient = new mockhttpclient();
        $httpclient->set_response('<html>Bad gateway</html>');

        $this->assertFalse(unified::test_tenant('tested.example.com', $httpclient));
        $this->assertStringContainsString('/tested.example.com/', apptoken::get_last_error());
        $this->assertStringStartsWith('No valid response received from ', apptoken::get_last_error());
    }

    /**
     * An empty tenant is invalid, and no request is made.
     *
     * @return void
     * @covers ::test_tenant
     */
    public function test_test_tenant_empty(): void {
        $this->resetAfterTest();
        $this->setup_oidc_for_apptoken();

        $httpclient = new mockhttpclient();
        $httpclient->set_response(json_encode(['error' => 'invalid_request', 'error_description' => 'Tenant not found.']));
        $this->assertFalse(unified::test_tenant('wrong.example.org', $httpclient));
        $this->assertNotEmpty(apptoken::get_last_error());

        // The reason of the previous failure is not carried over to a check that makes no request.
        $httpclient = new mockhttpclient();
        $this->assertFalse(unified::test_tenant('  ', $httpclient));
        $this->assertEmpty($httpclient->get_requests());
        $this->assertSame('', apptoken::get_last_error());
    }

    /**
     * If the HTTP client is not completely set, the HTTP method's result is returned.
     *
     * @return void
     * @covers ::betaapicall
     */
    public function test_betaapicall_http_method_result(): void {

        $expectedresult = 'OK';
        $token = self::createMock(token::class);
        $token->method('is_expired')->willReturn(false);
        $token->method('get_token')->willReturn('token');

        $httpclient = new mockhttpclient();
        $httpclient->set_response($expectedresult);

        $unified = new unified($token, $httpclient);
        $this->assertEquals($expectedresult, $unified->betaapicall('get', 'users'));
    }

    /**
     * If the HTTP code is 202, the HTTP response is returned.
     *
     * @return void
     * @covers ::betaapicall
     */
    public function test_betaapicall_202(): void {

        $expectedresult = 'OK';
        $token = self::createMock(token::class);
        $token->method('is_expired')->willReturn(false);
        $token->method('get_token')->willReturn('token');

        $httpclient = new mockhttpclient();
        $httpclient->set_response($expectedresult);
        $httpclient->info = ['http_code' => 202];
        $httpclient->response = $expectedresult;

        $unified = new unified($token, $httpclient);
        $this->assertEquals($expectedresult, $unified->betaapicall('get', 'users'));
    }

    /**
     * Found groups return their data, and a genuine 404 is reported as not found (null).
     *
     * @return void
     * @covers ::get_groups_batch
     */
    public function test_get_groups_batch_found_and_not_found(): void {
        $foundid = 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa';
        $missingid = 'bbbbbbbb-bbbb-bbbb-bbbb-bbbbbbbbbbbb';

        $batchresponse = [
            'responses' => [
                ['id' => '1', 'status' => 200, 'body' => ['id' => $foundid, 'displayName' => 'Group A']],
                ['id' => '2', 'status' => 404, 'body' => ['error' => ['code' => 'Request_ResourceNotFound']]],
            ],
        ];

        $token = self::createMock(token::class);
        $token->method('is_expired')->willReturn(false);
        $token->method('get_token')->willReturn('token');

        $httpclient = new mockhttpclient();
        $httpclient->set_response(json_encode($batchresponse));

        $unified = new unified($token, $httpclient);
        $results = $unified->get_groups_batch([$foundid, $missingid]);

        $this->assertSame(['id' => $foundid, 'displayName' => 'Group A'], $results[$foundid]);
        $this->assertNull($results[$missingid]);
    }

    /**
     * A non-200/404 per-request status (e.g. throttling or a permission error) must not be
     * silently reported as "not found" - it is a service-level failure, so it is thrown.
     *
     * @return void
     * @covers ::get_groups_batch
     */
    public function test_get_groups_batch_service_error_throws(): void {
        $groupid = 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa';

        $batchresponse = [
            'responses' => [
                ['id' => '1', 'status' => 429, 'body' => ['error' => ['code' => 'TooManyRequests']]],
            ],
        ];

        $token = self::createMock(token::class);
        $token->method('is_expired')->willReturn(false);
        $token->method('get_token')->willReturn('token');

        $httpclient = new mockhttpclient();
        $httpclient->set_response(json_encode($batchresponse));

        $unified = new unified($token, $httpclient);

        $this->expectException(moodle_exception::class);
        $unified->get_groups_batch([$groupid]);
    }

    /**
     * Create a unified API client whose HTTP client answers every request with the given response.
     *
     * @param string $response The response body.
     * @param int $httpcode The HTTP status code.
     * @return unified
     */
    protected function get_unified_with_response(string $response, int $httpcode): unified {
        $token = self::createMock(token::class);
        $token->method('is_expired')->willReturn(false);
        $token->method('get_token')->willReturn('token');

        $httpclient = new mockhttpclient();
        $httpclient->set_response($response);
        $httpclient->info = ['http_code' => $httpcode];

        return new unified($token, $httpclient);
    }

    /**
     * An event that is deleted reports success.
     *
     * @return void
     * @covers ::delete_event
     */
    public function test_delete_event_success(): void {
        $unified = $this->get_unified_with_response('', 204);

        $this->assertTrue($unified->delete_event('eventid', 'user@example.com'));
        $this->assertTrue($unified->delete_event('eventid', 'groupid', 'group'));
    }

    /**
     * An event that isn't there any more reports that nothing was deleted, without an error.
     *
     * @return void
     * @covers ::delete_event
     */
    public function test_delete_event_not_found(): void {
        $response = json_encode(['error' => ['code' => 'ErrorItemNotFound', 'message' => 'The specified object was not found.']]);
        $unified = $this->get_unified_with_response($response, 404);

        $this->assertFalse($unified->delete_event('eventid', 'user@example.com'));
    }

    /**
     * A request that Microsoft refuses, for example a group calendar event deleted without the owner's own token,
     * is reported instead of looking like a successful delete.
     *
     * @return void
     * @covers ::delete_event
     */
    public function test_delete_event_refused_throws(): void {
        $response = json_encode(['error' => ['code' => 'ErrorAccessDenied', 'message' => 'Access is denied.']]);
        $unified = $this->get_unified_with_response($response, 403);

        $this->expectException(moodle_exception::class);
        $unified->delete_event('eventid', 'groupid', 'group');
    }

    /**
     * A refused request is reported even when Microsoft's response has no error details.
     *
     * @return void
     * @covers ::delete_event
     */
    public function test_delete_event_refused_without_details_throws(): void {
        $unified = $this->get_unified_with_response('', 500);

        $this->expectException(moodle_exception::class);
        $unified->delete_event('eventid', 'user@example.com');
    }

    /**
     * Nothing is requested for an empty event ID.
     *
     * @return void
     * @covers ::delete_event
     */
    public function test_delete_event_without_id(): void {
        $unified = $this->get_unified_with_response('', 500);

        $this->assertTrue($unified->delete_event('', 'user@example.com'));
    }

    /**
     * Build a unified client whose per-group member fetch returns fixture data instead of calling Microsoft Graph.
     *
     * @param array $membersbygroup Map of group ID to a list of batches, each batch a list of user arrays.
     * @return unified
     */
    private function get_unified_with_group_fixtures(array $membersbygroup): unified {
        return new class ($membersbygroup) extends unified {
            /**
             * Group IDs requested, in order.
             *
             * @var array
             */
            public array $requestedgroups = [];

            /**
             * Fixture data.
             *
             * @var array
             */
            private array $fixtures;

            /**
             * Constructor, which skips the parent constructor.
             *
             * @param array $fixtures Fixture data.
             */
            public function __construct(array $fixtures) {
                $this->fixtures = $fixtures;
            }

            /**
             * Number of group existence checks made.
             *
             * @var int
             */
            public int $batchcalls = 0;

            /**
             * Whether the group existence check fails like a Graph permission or service error.
             *
             * @var bool
             */
            public bool $batchfails = false;

            /**
             * Look up groups from the fixtures, where 'missing' means the group does not exist.
             *
             * @param array $objectids Group object IDs.
             * @return array
             */
            public function get_groups_batch(array $objectids): array {
                $this->batchcalls++;
                if ($this->batchfails) {
                    throw new moodle_exception('generalexceptionmessage', 'error', '', 'Forbidden');
                }
                $result = [];
                foreach ($objectids as $id) {
                    $result[$id] = $this->fixtures[$id] === 'missing' ? null : ['id' => $id];
                }
                return $result;
            }

            /**
             * Return fixture batches for the group.
             *
             * @param string $groupid Group object ID.
             * @param callable $callback Batch callback.
             * @param string|array $params Requested fields.
             * @return int
             */
            protected function process_single_group_members_batched(string $groupid, callable $callback, $params = 'default'): int {
                $this->requestedgroups[] = $groupid;
                if ($this->fixtures[$groupid] === 'fail') {
                    throw new moodle_exception('generalexceptionmessage', 'error', '', 'Forbidden');
                }
                $total = 0;
                foreach ($this->fixtures[$groupid] as $batch) {
                    $callback($batch);
                    $total += count($batch);
                }
                return $total;
            }
        };
    }

    /**
     * A single group ID, as a string or an array, is passed through without deduplication.
     *
     * @return void
     * @covers ::process_group_members_batched
     */
    public function test_process_group_members_batched_single_group(): void {
        $unified = $this->get_unified_with_group_fixtures(['g1' => [[['id' => 'u1'], ['id' => 'u2']], [['id' => 'u3']]]]);

        $received = [];
        $callback = function (array $users) use (&$received): void {
            $received[] = array_column($users, 'id');
        };

        $this->assertSame(3, $unified->process_group_members_batched('g1', $callback));
        $this->assertSame([['u1', 'u2'], ['u3']], $received);
        $this->assertSame(3, $unified->process_group_members_batched(['g1'], $callback));
        $this->assertSame(['g1', 'g1'], $unified->requestedgroups);
        $this->assertSame(0, $unified->batchcalls, 'A single group needs no existence check.');
    }

    /**
     * Users in several groups are passed to the callback once, and batches left empty are not passed at all.
     *
     * @return void
     * @covers ::process_group_members_batched
     */
    public function test_process_group_members_batched_multiple_groups_deduplicates(): void {
        $unified = $this->get_unified_with_group_fixtures([
            'g1' => [[['id' => 'u1'], ['id' => 'u2']]],
            'g2' => [[['id' => 'u2'], ['id' => 'u3']], [['id' => 'u1']]],
            'g3' => [[['id' => 'u3']]],
        ]);

        $received = [];
        $callback = function (array $users) use (&$received): void {
            $received[] = array_column($users, 'id');
        };

        $this->assertSame(3, $unified->process_group_members_batched(['g1', 'g2', 'g2', 'g3'], $callback));
        $this->assertSame([['u1', 'u2'], ['u3']], $received);
        $this->assertSame(['g1', 'g2', 'g3'], $unified->requestedgroups, 'Duplicate group IDs are fetched once.');
    }

    /**
     * No groups means no requests and no users.
     *
     * @return void
     * @covers ::process_group_members_batched
     */
    public function test_process_group_members_batched_no_groups(): void {
        $unified = $this->get_unified_with_group_fixtures([]);

        $this->assertSame(0, $unified->process_group_members_batched([], function (array $users): void {
            $this->fail('The callback must not be called.');
        }));
        $this->assertSame([], $unified->requestedgroups);
    }

    /**
     * A group that cannot be read fails the whole retrieval with an error naming that group, so callers never act on
     * a partial member list.
     *
     * @return void
     * @covers ::process_group_members_batched
     * @covers ::get_group_fetch_exception
     */
    public function test_process_group_members_batched_failure_names_group(): void {
        $unified = $this->get_unified_with_group_fixtures([
            'g1' => [[['id' => 'u1']]],
            'g2' => 'fail',
            'g3' => [[['id' => 'u3']]],
        ]);

        foreach ([['g2'], ['g1', 'g2', 'g3']] as $groupids) {
            try {
                $unified->process_group_members_batched($groupids, function (array $users): void {
                });
                $this->fail('An exception was expected.');
            } catch (moodle_exception $e) {
                $this->assertStringContainsString('group g2', $e->getMessage());
                $this->assertStringContainsString('Forbidden', $e->getMessage());
            }
        }
        $this->assertNotContains('g3', $unified->requestedgroups, 'Groups after the failing one are not fetched.');
    }

    /**
     * A group that does not exist stops the run before any group's members are processed.
     *
     * @return void
     * @covers ::process_group_members_batched
     * @covers ::assert_groups_exist
     */
    public function test_process_group_members_batched_missing_group_fails_before_processing(): void {
        $unified = $this->get_unified_with_group_fixtures([
            'g1' => [[['id' => 'u1']]],
            'g2' => 'missing',
            'g3' => [[['id' => 'u3']]],
            'g4' => 'missing',
        ]);

        try {
            $unified->process_group_members_batched(['g1', 'g2', 'g3', 'g4'], function (array $users): void {
                $this->fail('No users must be processed.');
            });
            $this->fail('An exception was expected.');
        } catch (moodle_exception $e) {
            $this->assertStringContainsString('g2, g4', $e->getMessage(), 'All missing groups are named.');
            $this->assertStringContainsString('do not exist', $e->getMessage());
        }
        $this->assertSame([], $unified->requestedgroups, 'No group members are retrieved.');
        $this->assertSame(1, $unified->batchcalls);
    }

    /**
     * When the existence check itself cannot be completed, the run is aborted before any group is processed.
     *
     * @return void
     * @covers ::process_group_members_batched
     * @covers ::assert_groups_exist
     */
    public function test_process_group_members_batched_aborts_when_check_fails(): void {
        $unified = $this->get_unified_with_group_fixtures([
            'g1' => [[['id' => 'u1']]],
            'g2' => [[['id' => 'u2']]],
        ]);
        $unified->batchfails = true;

        try {
            $unified->process_group_members_batched(['g1', 'g2'], function (array $users): void {
                $this->fail('No users must be processed.');
            });
            $this->fail('An exception was expected.');
        } catch (moodle_exception $e) {
            $this->assertStringContainsString('Could not check that the user sync groups exist', $e->getMessage());
            $this->assertStringContainsString('Forbidden', $e->getMessage());
        }
        $this->assertSame([], $unified->requestedgroups, 'No group members are retrieved.');
    }

    /**
     * Build a unified client that records every API call and answers from queued responses instead of calling Microsoft
     * Graph. A queue is picked by the first key that the requested API method contains.
     *
     * @param array $responses Map of a substring of the API method to a list of JSON responses, used in order.
     * @return unified
     */
    private function get_unified_with_recorded_calls(array $responses): unified {
        return new class ($responses) extends unified {
            /**
             * Recorded calls, each with the API method and the options.
             *
             * @var array
             */
            public array $calls = [];

            /**
             * Queued responses.
             *
             * @var array
             */
            private array $responses;

            /**
             * Constructor, which skips the parent constructor.
             *
             * @param array $responses Queued responses.
             */
            public function __construct(array $responses) {
                $this->responses = $responses;
            }

            /**
             * Treat every group as existing.
             *
             * @param array $objectids Group object IDs.
             * @return array
             */
            public function get_groups_batch(array $objectids): array {
                return array_combine($objectids, array_map(fn($id) => ['id' => $id], $objectids));
            }

            /**
             * Record the call and return the next queued response.
             *
             * @param string $httpmethod HTTP method.
             * @param string $apimethod API method.
             * @param string $params Parameters.
             * @param array $options Options.
             * @return string
             */
            public function apicall($httpmethod, $apimethod, $params = '', $options = []) {
                $this->calls[] = ['apimethod' => $apimethod, 'options' => $options];
                foreach ($this->responses as $needle => $queue) {
                    if (strpos($apimethod, $needle) !== false && !empty($queue)) {
                        return array_shift($this->responses[$needle]);
                    }
                }
                return '{"value":[]}';
            }
        };
    }

    /**
     * Group member and owner queries use the user cast, so each page request carries $count=true and the ConsistencyLevel
     * header, including the pages that follow a next link.
     *
     * @return void
     * @covers ::process_group_members_batched
     * @covers ::execute_odata_paginated
     * @covers \local_o365\rest\o365api::apicall
     */
    public function test_process_group_members_batched_sends_consistency_options_on_every_page(): void {
        $this->resetAfterTest();

        $nextlink = 'https://graph.microsoft.com/v1.0/groups/g1/transitiveMembers/microsoft.graph.user?$skiptoken=abc';
        $unified = $this->get_unified_with_recorded_calls([
            '/owners/' => ['{"value":[{"id":"u3"}]}'],
            '/transitiveMembers/' => [
                '{"value":[{"id":"u1"}],"@odata.nextLink":"' . str_replace('/', '\\/', $nextlink) . '"}',
                '{"value":[{"id":"u2"}]}',
            ],
        ]);

        $received = [];
        $total = $unified->process_group_members_batched('g1', function (array $users) use (&$received): void {
            $received = array_merge($received, array_column($users, 'id'));
        }, ['id']);

        $this->assertSame(3, $total);
        $this->assertEqualsCanonicalizing(['u1', 'u2', 'u3'], $received);
        $this->assertCount(3, $unified->calls, 'Owners, then two member pages.');
        foreach ($unified->calls as $call) {
            $this->assertSame(['ConsistencyLevel: eventual'], $call['options']['headers']);
            $this->assertStringContainsString('$count=true', $call['apimethod']);
        }
        $this->assertStringContainsString('/transitiveMembers/microsoft.graph.user', $unified->calls[1]['apimethod']);
        $this->assertStringContainsString('$skiptoken=abc', $unified->calls[2]['apimethod']);
    }

    /**
     * The delta sync looks up the member and owner IDs with the same consistency options.
     *
     * @return void
     * @covers ::process_group_members_delta_batched
     */
    public function test_process_group_members_delta_batched_sends_consistency_options(): void {
        $this->resetAfterTest();

        $unified = $this->get_unified_with_recorded_calls([
            '/transitiveMembers/' => ['{"value":[{"id":"u1"}]}'],
            '/owners/' => ['{"value":[{"id":"u2"}]}'],
            '/users/delta' => ['{"value":[{"id":"u1"},{"id":"u9"}]}'],
        ]);

        $received = [];
        $unified->process_group_members_delta_batched('g1', function (array $users) use (&$received): void {
            $received = array_merge($received, array_column($users, 'id'));
        }, ['id']);

        $this->assertSame(['u1'], $received, 'Only members of the group pass the filter.');
        $this->assertGreaterThanOrEqual(3, count($unified->calls));
        foreach (array_slice($unified->calls, 0, 2) as $call) {
            $this->assertSame(['ConsistencyLevel: eventual'], $call['options']['headers']);
            $this->assertStringContainsString('$count=true', $call['apimethod']);
        }
    }

    /**
     * The user ID is always selected, so de-duplication and owner handling keep working when the caller selects other
     * fields only, for one group and for several groups.
     *
     * @return void
     * @covers ::process_group_members_batched
     */
    public function test_process_group_members_batched_always_selects_id(): void {
        $user = fn(string $id, string $upn): array => ['id' => $id, 'userPrincipalName' => $upn];
        $page = fn(array $users): string => json_encode(['value' => $users]);
        $unified = $this->get_unified_with_recorded_calls([
            '/groups/g1/transitiveMembers/' => [$page([$user('u1', 'a@x')]), $page([$user('u1', 'a@x')])],
            '/groups/g1/owners/' => [$page([$user('u3', 'c@x')]), $page([$user('u3', 'c@x')])],
            '/groups/g2/transitiveMembers/' => [$page([$user('u1', 'a@x'), $user('u2', 'b@x')])],
            '/groups/g2/owners/' => [$page([])],
        ]);

        $collect = function (array $groupids) use ($unified): array {
            $received = [];
            $unified->process_group_members_batched($groupids, function (array $users) use (&$received): void {
                $received = array_merge($received, array_column($users, 'userPrincipalName'));
            }, ['userPrincipalName']);
            return $received;
        };

        $this->assertEqualsCanonicalizing(['a@x', 'c@x'], $collect(['g1']), 'One group returns members and owners.');
        $this->assertEqualsCanonicalizing(
            ['a@x', 'c@x', 'b@x'],
            $collect(['g1', 'g2']),
            'Several groups return each user once.'
        );
        foreach ($unified->calls as $call) {
            $this->assertMatchesRegularExpression('/\$select=[^&]*\bid\b/', $call['apimethod']);
        }
    }
}
