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
 * User sync test cases.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365;

use advanced_testcase;
use local_o365\feature\usersync\main;
use local_o365\oauth2\token;
use local_o365\rest\unified;
use local_o365\tests\mockhttpclient;

/**
 * Tests \local_o365\feature\usersync\main.
 *
 * @group local_o365
 * @group office365
 */
final class usersync_test extends advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Get a mock token object to use when constructing the API client.
     *
     * @return token The mock token object.
     */
    protected function get_mock_clientdata() {
        $oidcconfig = (object) [
            'clientid' => 'clientid',
            'clientsecret' => 'clientsecret',
            'authendpoint' => 'http://example.com/auth',
            'tokenendpoint' => 'http://example.com/token',
        ];

        $clientdata = new \local_o365\oauth2\clientdata(
            $oidcconfig->clientid,
            $oidcconfig->clientsecret,
            $oidcconfig->authendpoint,
            $oidcconfig->tokenendpoint
        );

        return $clientdata;
    }

    /**
     * Get a mock token object to use when constructing the API client.
     *
     * @return token The mock token object.
     */
    protected function get_mock_token() {
        $httpclient = new mockhttpclient();

        $tokenrec = (object) [
            'token' => 'token',
            'expiry' => time() + 1000,
            'refreshtoken' => 'refreshtoken',
            'scope' => 'scope',
            'user_id' => '2',
            'tokenresource' => 'resource',
        ];

        $clientdata = $this->get_mock_clientdata();
        $token = new token(
            $tokenrec->token,
            $tokenrec->expiry,
            $tokenrec->refreshtoken,
            $tokenrec->scope,
            $tokenrec->tokenresource,
            $tokenrec->user_id,
            $clientdata,
            $httpclient
        );

        return $token;
    }

    /**
     * Get sample Microsoft Entra ID userdata.
     *
     * @param int $i A counter to generate unique data.
     * @return array Array of Microsoft Entra ID user data.
     */
    protected function get_entra_id_userinfo($i = 0) {
        return [
            'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
            'objectType' => 'User',
            'objectId' => '00000000-0000-0000-0000-00000000000' . $i,
            'id' => '00000000-0000-0000-0000-00000000000' . $i,
            'city' => 'Toronto',
            'country' => ($i == 3) ? 'Canada' : 'CA',
            'department' => 'Dev',
            'givenName' => 'Test',
            'mail' => 'testuser' . $i . '@example.onmicrosoft.com',
            'surname' => 'User' . $i,
            'preferredLanguage' => ($i == 3) ? 'sa-IN' : 'en-US',
            'userPrincipalName' => 'testuser' . $i . '@example.onmicrosoft.com',
        ];
    }

    /**
     * Dataprovider for test_create_user_from_entra_id_data.
     *
     * @return array Array of test parameters.
     */
    public static function dataprovider_create_user_from_entra_id_data(): array {
        global $CFG;
        $tests = [];

        $tests['fulldata'] = [
            [
                'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
                'objectType' => 'User',
                'objectId' => '00000000-0000-0000-0000-000000000001',
                'id' => '00000000-0000-0000-0000-000000000001',
                'city' => 'Toronto',
                'country' => 'CA',
                'department' => 'Dev',
                'givenName' => 'Test',
                'mail' => 'testuser1@example.onmicrosoft.com',
                'surname' => 'User1',
                'userPrincipalName' => 'testuser1@example.onmicrosoft.com',
                'useridentifier' => 'testuser1@example.onmicrosoft.com',
                'useridentifierlower' => 'testuser1@example.onmicrosoft.com',
                'upnsplit0' => 'testuser1',
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
                'id' => '00000000-0000-0000-0000-000000000002',
                'country' => 'CA',
                'department' => 'Dev',
                'givenName' => 'Test',
                'mail' => 'testuser2@example.onmicrosoft.com',
                'surname' => 'User2',
                'userPrincipalName' => 'testuser2@example.onmicrosoft.com',
                'useridentifier' => 'testuser2@example.onmicrosoft.com',
                'useridentifierlower' => 'testuser2@example.onmicrosoft.com',
                'upnsplit0' => 'testuser2',
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
                'id' => '00000000-0000-0000-0000-000000000003',
                'department' => 'Dev',
                'givenName' => 'Test',
                'mail' => 'testuser3@example.onmicrosoft.com',
                'surname' => 'User3',
                'userPrincipalName' => 'testuser3@example.onmicrosoft.com',
                'useridentifier' => 'testuser3@example.onmicrosoft.com',
                'useridentifierlower' => 'testuser3@example.onmicrosoft.com',
                'upnsplit0' => 'testuser3',
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
                'id' => '00000000-0000-0000-0000-000000000004',
                'givenName' => 'Test',
                'mail' => 'testuser4@example.onmicrosoft.com',
                'surname' => 'User4',
                'userPrincipalName' => 'testuser4@example.onmicrosoft.com',
                'useridentifier' => 'testuser4@example.onmicrosoft.com',
                'useridentifierlower' => 'testuser4@example.onmicrosoft.com',
                'upnsplit0' => 'testuser4',
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
     * Test create_user_from_entra_id_data method.
     *
     * @dataProvider dataprovider_create_user_from_entra_id_data
     * @param array $entraiddata The Microsoft Entra ID user data to create the user from.
     * @param array $expecteduser The expected user data to be created.
     * @covers \local_o365\feature\usersync\main::create_user_from_entra_id_data
     */
    public function test_create_user_from_entra_id_data($entraiddata, $expecteduser): void {
        global $DB;

        $httpclient = new mockhttpclient();
        $clientdata = $this->get_mock_clientdata();
        $usersync = new main($clientdata, $httpclient);
        $usersync->create_user_from_entra_id_data($entraiddata, []);

        $userparams = ['auth' => 'oidc', 'username' => $entraiddata['mail'], 'firstname' => $entraiddata['givenName'],
            'lastname' => $entraiddata['surname']];
        $this->assertTrue($DB->record_exists('user', $userparams));
        $createduser = $DB->get_record('user', $userparams);

        foreach ($expecteduser as $k => $v) {
            $this->assertEquals($v, $createduser->$k);
        }
    }

    /**
     * Test that update_user_from_entra_id_data() clears a mapped Moodle profile field when Microsoft
     * Entra ID returns the field explicitly as null, rather than leaving the previously-synced value
     * in place. Graph's $select response returns a selected-but-unset field as null instead of
     * omitting the key entirely, which apply_configured_fieldmap() must treat as "clear this field".
     *
     * @covers \local_o365\feature\usersync\main::update_user_from_entra_id_data
     * @covers \local_o365\feature\usersync\main::apply_configured_fieldmap
     */
    public function test_update_user_from_entra_id_data_clears_field_on_null(): void {
        global $DB;

        $httpclient = new mockhttpclient();
        $clientdata = $this->get_mock_clientdata();
        $usersync = new main($clientdata, $httpclient);

        $entraiddata = [
            'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
            'objectType' => 'User',
            'objectId' => '00000000-0000-0000-0000-000000000099',
            'id' => '00000000-0000-0000-0000-000000000099',
            'city' => 'Toronto',
            'country' => 'CA',
            'department' => 'Dev',
            'givenName' => 'Test',
            'mail' => 'testuser99@example.onmicrosoft.com',
            'surname' => 'User99',
            'userPrincipalName' => 'testuser99@example.onmicrosoft.com',
            'useridentifier' => 'testuser99@example.onmicrosoft.com',
            'useridentifierlower' => 'testuser99@example.onmicrosoft.com',
            'upnsplit0' => 'testuser99',
        ];

        $usersync->create_user_from_entra_id_data($entraiddata, []);

        $existinguser = $DB->get_record('user', ['username' => $entraiddata['mail']], '*', MUST_EXIST);
        $this->assertSame('Toronto', $existinguser->city);
        $this->assertSame('CA', $existinguser->country);
        $this->assertSame('Dev', $existinguser->department);

        // Simulate the fields being cleared in Microsoft Entra ID: Graph's $select response returns
        // the keys explicitly as null rather than omitting them.
        $entraiddata['city'] = null;
        $entraiddata['country'] = null;
        $entraiddata['department'] = null;

        $usersync->update_user_from_entra_id_data($entraiddata, $existinguser);

        $updateduser = $DB->get_record('user', ['id' => $existinguser->id], '*', MUST_EXIST);
        $this->assertSame('', $updateduser->city);
        $this->assertSame('', $updateduser->country);
        $this->assertSame('', $updateduser->department);
    }

    /**
     * When Microsoft Entra ID provides no 'mail' attribute for a user being synced (for example, a cloud-only
     * account with no Exchange Online mailbox), and placeholder email generation is disabled (the default),
     * the user must still be created, with their email address left unset rather than the sync failing.
     *
     * Regression test for https://github.com/microsoft/o365-moodle/issues/2839.
     *
     * @return void
     * @covers \local_o365\feature\usersync\main::create_user_from_entra_id_data
     * @covers \local_o365\feature\usersync\main::apply_configured_fieldmap
     */
    public function test_create_user_from_entra_id_data_leaves_email_unset_when_no_mail_and_generation_disabled(): void {
        global $DB;

        $entraiddata = [
            'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
            'objectType' => 'User',
            'objectId' => '00000000-0000-0000-0000-000000000005',
            'id' => '00000000-0000-0000-0000-000000000005',
            'givenName' => 'Test',
            'surname' => 'User5',
            'userPrincipalName' => 'CONTOSO\\testuser5',
            'useridentifier' => 'testuser5',
        ];

        $httpclient = new mockhttpclient();
        $clientdata = $this->get_mock_clientdata();
        $usersync = new main($clientdata, $httpclient);
        $usersync->create_user_from_entra_id_data($entraiddata, []);

        $createduser = $DB->get_record('user', ['username' => 'testuser5', 'auth' => 'oidc']);
        $this->assertNotFalse($createduser);
        $this->assertSame('', $createduser->email);
    }

    /**
     * When Microsoft Entra ID provides no 'mail' attribute for a user being synced, and the site is configured
     * to generate a placeholder address, the user sync task must apply the generated placeholder email
     * address to the newly created user, the same way the OIDC login flow does.
     *
     * Regression test for https://github.com/microsoft/o365-moodle/issues/2839.
     *
     * @return void
     * @covers \local_o365\feature\usersync\main::create_user_from_entra_id_data
     * @covers \local_o365\feature\usersync\main::apply_configured_fieldmap
     */
    public function test_create_user_from_entra_id_data_generates_placeholder_email_when_no_mail_received(): void {
        global $DB;

        set_config('generatedummyemail', 1, 'auth_oidc');
        set_config('dummyemaildomain', 'example.test', 'auth_oidc');

        $entraiddata = [
            'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
            'objectType' => 'User',
            'objectId' => '00000000-0000-0000-0000-000000000006',
            'id' => '00000000-0000-0000-0000-000000000006',
            'givenName' => 'Test',
            'surname' => 'User6',
            'userPrincipalName' => 'CONTOSO\\testuser6',
            'useridentifier' => 'testuser6',
        ];

        $httpclient = new mockhttpclient();
        $clientdata = $this->get_mock_clientdata();
        $usersync = new main($clientdata, $httpclient);
        $usersync->create_user_from_entra_id_data($entraiddata, []);

        $createduser = $DB->get_record('user', ['username' => 'testuser6', 'auth' => 'oidc']);
        $this->assertNotFalse($createduser);
        $this->assertSame('contosotestuser6@example.test', $createduser->email);
    }

    /**
     * When Microsoft Graph is configured, Entra ID user data carries the object ID under 'id' rather than
     * 'objectId'. The placeholder email fallback must still find it, so a Graph-synced user with neither a
     * mail attribute nor a usable UPN still gets a generated placeholder address instead of none at all.
     *
     * Regression test for https://github.com/microsoft/o365-moodle/issues/2839.
     *
     * @return void
     * @covers \local_o365\feature\usersync\main::create_user_from_entra_id_data
     * @covers \local_o365\feature\usersync\main::apply_configured_fieldmap
     */
    public function test_create_user_from_entra_id_data_generates_placeholder_email_using_graph_id_field(): void {
        global $DB;

        set_config('generatedummyemail', 1, 'auth_oidc');
        set_config('dummyemaildomain', 'example.test', 'auth_oidc');

        $entraiddata = [
            'id' => '00000000-0000-0000-0000-000000000007',
            'givenName' => 'Test',
            'surname' => 'User7',
            'useridentifier' => 'testuser7',
        ];

        $httpclient = new mockhttpclient();
        $clientdata = $this->get_mock_clientdata();
        $usersync = new main($clientdata, $httpclient);
        $usersync->create_user_from_entra_id_data($entraiddata, []);

        $createduser = $DB->get_record('user', ['username' => 'testuser7', 'auth' => 'oidc']);
        $this->assertNotFalse($createduser);
        $this->assertSame('00000000-0000-0000-0000-000000000007@example.test', $createduser->email);
    }

    /**
     * Test sync_users method when creating users.
     *
     * @covers \local_o365\feature\usersync\main::sync_users
     */
    public function test_sync_users_create(): void {
        global $CFG, $DB;

        set_config('usersync', 'create', 'local_o365');
        for ($i = 1; $i <= 2; $i++) {
            $muser = [
                'auth' => 'oidc',
                'deleted' => '0',
                'mnethostid' => $CFG->mnet_localhost_id,
                'username' => 'testuser' . $i . '@example.onmicrosoft.com',
                'firstname' => 'Test',
                'lastname' => 'User' . $i,
                'email' => 'testuser' . $i . '@example.onmicrosoft.com',
                'lang' => 'en',
            ];
            $muser['id'] = $DB->insert_record('user', (object) $muser);

            $token = [
                'oidcuniqid' => '00000000-0000-0000-0000-00000000000' . $i,
                'authcode' => '000',
                'username' => 'testuser' . $i . '@example.onmicrosoft.com',
                'userid' => $muser['id'],
                'scope' => 'test',
                'tokenresource' => unified::get_tokenresource(),
                'token' => '000',
                'expiry' => '9999999999',
                'refreshtoken' => 'fsdfsdf' . $i,
                'idtoken' => 'sdfsdfsdf' . $i,
            ];
            $DB->insert_record('auth_oidc_token', (object) $token);
        }

        $response = [
            'value' => [
                $this->get_entra_id_userinfo(1),
                $this->get_entra_id_userinfo(3),
            ],
        ];
        $response = json_encode($response);
        $httpclient = new mockhttpclient();
        $httpclient->set_response($response);

        // Construct the REST client with the mock token/httpclient so process_users_batched()
        // uses the mock HTTP layer rather than a real Graph API call.
        // sync_users() only does DB work so usersync\main needs no clientdata/httpclient.
        $apiclient = new unified($this->get_mock_token(), $httpclient);
        $usersync = new main();
        $apiclient->process_users_batched(function (array $userbatch) use ($usersync) {
            $usersync->sync_users($userbatch, 'userPrincipalName');
        });

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
     * Test create_entra_users_temp_table and drop_entra_users_temp_table.
     *
     * @covers \local_o365\feature\usersync\main::create_entra_users_temp_table
     * @covers \local_o365\feature\usersync\main::drop_entra_users_temp_table
     */
    public function test_temp_table_lifecycle(): void {
        global $DB;

        $usersync = new main();
        $dbman = $DB->get_manager();

        $temptablename = $usersync->create_entra_users_temp_table();

        // Verify table was created.
        $table = new \xmldb_table($temptablename);
        $this->assertTrue($dbman->table_exists($table));

        // Verify table structure.
        $columns = $DB->get_columns($temptablename);
        $this->assertArrayHasKey('objectid', $columns);
        $this->assertArrayHasKey('accountenabled', $columns);

        // Drop table.
        $usersync->drop_entra_users_temp_table($temptablename);
        $this->assertFalse($dbman->table_exists($table));
    }

    /**
     * Test populate_entra_users_temp_table inserts records correctly.
     *
     * @covers \local_o365\feature\usersync\main::populate_entra_users_temp_table
     */
    public function test_populate_entra_users_temp_table(): void {
        global $DB;

        $usersync = new main();
        $temptablename = $usersync->create_entra_users_temp_table();

        try {
            // Manually populate temp table (simulate what populate_entra_users_temp_table does).
            $records = [
                (object) ['objectid' => 'entra-user-1', 'accountenabled' => 1],
                (object) ['objectid' => 'entra-user-2', 'accountenabled' => 0],
                (object) ['objectid' => 'entra-user-3', 'accountenabled' => 1],
            ];
            $DB->insert_records($temptablename, $records);

            // Verify records were inserted.
            $dbrecords = $DB->get_records($temptablename);
            $this->assertCount(3, $dbrecords);

            $recordsbyid = [];
            foreach ($dbrecords as $rec) {
                $recordsbyid[$rec->objectid] = $rec;
            }

            $this->assertEquals(1, $recordsbyid['entra-user-1']->accountenabled);
            $this->assertEquals(0, $recordsbyid['entra-user-2']->accountenabled);
            $this->assertEquals(1, $recordsbyid['entra-user-3']->accountenabled);
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Test re-enable path: suspended users in Entra are re-enabled.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     */
    public function test_process_user_status_reenable(): void {
        global $DB;

        set_config('usersync', 'create', 'local_o365');
        set_config('usersync_reenable', 1, 'local_o365');

        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();

        // Suspend both users and switch to OIDC auth.
        $user1->suspended = 1;
        $user1->auth = 'oidc';
        $user2->suspended = 1;
        $user2->auth = 'oidc';
        $DB->update_record('user', $user1);
        $DB->update_record('user', $user2);

        // Create object mappings.
        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'moodleid' => $user1->id,
            'objectid' => 'entra-user-1',
            'o365name' => $user1->email,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);
        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'moodleid' => $user2->id,
            'objectid' => 'entra-user-2',
            'o365name' => $user2->email,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);

        // Create temp table with users.
        $usersync = new main();
        $temptablename = $usersync->create_entra_users_temp_table();

        try {
            $DB->insert_records($temptablename, [
                (object) ['objectid' => 'entra-user-1', 'accountenabled' => 1],
                (object) ['objectid' => 'entra-user-2', 'accountenabled' => 1],
            ]);

            // Process status.
            [$reenabled, $suspended, $deleted] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                true, // Re-enable suspended users.
                false, // Do not suspend.
                false, // Do not delete.
                false, // Do not suspend on disabled accounts.
                false  // Do not check account status.
            );

            $this->assertEquals(2, $reenabled);
            $this->assertEquals(0, $suspended);
            $this->assertEquals(0, $deleted);

            // Verify users are no longer suspended.
            $user1refresh = $DB->get_record('user', ['id' => $user1->id]);
            $user2refresh = $DB->get_record('user', ['id' => $user2->id]);
            $this->assertEquals(0, $user1refresh->suspended);
            $this->assertEquals(0, $user2refresh->suspended);
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Test accountEnabled gating: suspended users with accountEnabled=0 are not re-enabled by 'reenable', even when
     * 'disabledsyncreenable' is off, while suspended users with accountEnabled=1 are.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     */
    public function test_process_user_status_reenable_with_disabled_account(): void {
        global $DB;

        set_config('usersync', 'create', 'local_o365');
        set_config('usersync_reenable', 1, 'local_o365');

        $blockeduser = $this->getDataGenerator()->create_user(['auth' => 'oidc', 'suspended' => 1]);
        $alloweduser = $this->getDataGenerator()->create_user(['auth' => 'oidc', 'suspended' => 1]);

        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'moodleid' => $blockeduser->id,
            'objectid' => 'entra-user-blocked',
            'o365name' => $blockeduser->email,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);
        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'moodleid' => $alloweduser->id,
            'objectid' => 'entra-user-allowed',
            'o365name' => $alloweduser->email,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);

        $usersync = new main();

        foreach ([false, true] as $dodisabledsyncreenable) {
            $DB->set_field('user', 'suspended', 1, ['id' => $blockeduser->id]);
            $DB->set_field('user', 'suspended', 1, ['id' => $alloweduser->id]);

            $temptablename = $usersync->create_entra_users_temp_table();

            try {
                $DB->insert_records($temptablename, [
                    (object) ['objectid' => 'entra-user-blocked', 'accountenabled' => 0],
                    (object) ['objectid' => 'entra-user-allowed', 'accountenabled' => 1],
                ]);

                [$reenabled, $suspended, $deleted] = $usersync->process_user_status_from_temp_table(
                    $temptablename,
                    true, // Re-enable suspended users.
                    false, // Do not suspend.
                    false, // Do not delete.
                    false, // Do not suspend on disabled accounts.
                    $dodisabledsyncreenable
                );

                $this->assertEquals(1, $reenabled);
                $this->assertEquals(0, $suspended);
                $this->assertEquals(0, $deleted);

                $this->assertEquals(
                    1,
                    $DB->get_field('user', 'suspended', ['id' => $blockeduser->id]),
                    'User blocked from signing in to Entra should remain suspended.'
                );
                $this->assertEquals(
                    0,
                    $DB->get_field('user', 'suspended', ['id' => $alloweduser->id]),
                    'User allowed to sign in to Entra should be re-enabled.'
                );
            } finally {
                $usersync->drop_entra_users_temp_table($temptablename);
            }
        }
    }

    /**
     * Test suspend path: users deleted in Entra are suspended.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     */
    public function test_process_user_status_suspend(): void {
        global $DB;

        set_config('usersync', 'create', 'local_o365');

        $user1 = $this->getDataGenerator()->create_user();
        $user1->auth = 'oidc';
        $user1->suspended = 0;
        $DB->update_record('user', $user1);

        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'moodleid' => $user1->id,
            'objectid' => 'entra-user-deleted',
            'o365name' => $user1->email,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);

        $usersync = new main();
        $temptablename = $usersync->create_entra_users_temp_table();

        try {
            // Empty temp table - user was deleted from Entra (not calling populate to avoid API requirement).

            [$reenabled, $suspended, $deleted] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                false, // Do not re-enable.
                true, // Suspend deleted users.
                false, // Do not delete.
                false, // Do not suspend on disabled accounts.
                false  // Do not check account status.
            );

            $this->assertEquals(0, $reenabled);
            $this->assertEquals(1, $suspended);
            $this->assertEquals(0, $deleted);

            // Verify user is suspended.
            $user1refresh = $DB->get_record('user', ['id' => $user1->id]);
            $this->assertEquals(1, $user1refresh->suspended);
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Create an OIDC user mapped to an Entra object, for the status processing tests.
     *
     * @param string $objectid The Entra object ID.
     * @param int $suspended Whether the user is suspended.
     * @return \stdClass The Moodle user.
     */
    protected function create_mapped_oidc_user(string $objectid, int $suspended): \stdClass {
        global $DB;

        $user = $this->getDataGenerator()->create_user();
        $user->auth = 'oidc';
        $user->suspended = $suspended;
        $DB->update_record('user', $user);

        $now = time();
        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'subtype' => '',
            'objectid' => $objectid,
            'moodleid' => $user->id,
            'o365name' => $user->email,
            'tenant' => '',
            'timecreated' => $now,
            'timemodified' => $now,
        ]);

        return $user;
    }

    /**
     * Get a user sync instance whose Entra deleted-users list is empty (soft-delete retention expired for everyone).
     *
     * @return main
     */
    protected function get_usersync_with_empty_deleted_items(): main {
        $apiclient = new class {
            /**
             * Return no deleted users.
             *
             * @param callable $callback Batch callback, never called.
             */
            public function process_deleted_users_batched(callable $callback): void {
            }
        };

        return new class ($apiclient) extends main {
            /**
             * Test API client.
             *
             * @var object
             */
            private object $testapiclient;

            /**
             * Constructor.
             *
             * @param object $apiclient Test API client.
             */
            public function __construct(object $apiclient) {
                parent::__construct();
                $this->testapiclient = $apiclient;
            }

            /**
             * Return the test API client.
             *
             * @return object
             */
            public function construct_user_api() {
                return $this->testapiclient;
            }
        };
    }

    /**
     * Test that suspending a user records the suspension time, and re-enabling the user clears it.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     */
    public function test_process_user_status_suspension_time_preference(): void {
        global $DB;

        $user = $this->create_mapped_oidc_user('entra-user-gone', 0);

        $usersync = new main();
        $temptablename = $usersync->create_entra_users_temp_table();

        try {
            $before = time();
            $usersync->process_user_status_from_temp_table($temptablename, false, true, false, false, false);
            $suspendedtime = (int) get_user_preferences(main::SUSPENDED_TIME_PREFERENCE, 0, $user->id);
            $this->assertGreaterThanOrEqual($before, $suspendedtime);
            $this->assertLessThanOrEqual(time(), $suspendedtime);

            // The user reappears in Entra and is re-enabled, so the marker is removed.
            $DB->insert_records($temptablename, [(object) ['objectid' => 'entra-user-gone', 'accountenabled' => 1]]);
            [$reenabled] = $usersync->process_user_status_from_temp_table($temptablename, true, true, false, false, false);
            $this->assertEquals(1, $reenabled);
            $this->assertEquals(0, $DB->get_field('user', 'suspended', ['id' => $user->id]));
            $this->assertFalse($DB->record_exists('user_preferences', [
                'userid' => $user->id,
                'name' => main::SUSPENDED_TIME_PREFERENCE,
            ]));
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Test that suspended users are only deleted once the configured delay since suspension has passed.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     */
    public function test_process_user_status_delete_delay(): void {
        global $DB;

        $delay = 30 * DAYSECS;
        set_config('usersync_delete_delay', $delay, 'local_o365');

        $recent = $this->create_mapped_oidc_user('entra-user-recent', 1);
        set_user_preference(main::SUSPENDED_TIME_PREFERENCE, time() - 10 * DAYSECS, $recent->id);
        $expired = $this->create_mapped_oidc_user('entra-user-expired', 1);
        set_user_preference(main::SUSPENDED_TIME_PREFERENCE, time() - 40 * DAYSECS, $expired->id);
        $legacy = $this->create_mapped_oidc_user('entra-user-legacy', 1);

        $usersync = $this->get_usersync_with_empty_deleted_items();
        $temptablename = $usersync->create_entra_users_temp_table();

        try {
            $before = time();
            [$reenabled, $suspended, $deleted] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                false,
                true,
                true,
                false,
                false
            );

            // Only the user suspended for longer than the delay is deleted.
            $this->assertEquals(1, $deleted);
            $this->assertEquals(0, $DB->get_field('user', 'deleted', ['id' => $recent->id]));
            $this->assertEquals(1, $DB->get_field('user', 'deleted', ['id' => $expired->id]));
            $this->assertEquals(0, $DB->get_field('user', 'deleted', ['id' => $legacy->id]));

            // The user suspended before the delay was tracked has their clock started now.
            $legacytime = (int) get_user_preferences(main::SUSPENDED_TIME_PREFERENCE, 0, $legacy->id);
            $this->assertGreaterThanOrEqual($before, $legacytime);

            // Without a delay, the remaining suspended users are deleted straight away.
            set_config('usersync_delete_delay', 0, 'local_o365');
            [$reenabled, $suspended, $deleted] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                false,
                true,
                true,
                false,
                false
            );
            $this->assertEquals(2, $deleted);
            $this->assertEquals(1, $DB->get_field('user', 'deleted', ['id' => $recent->id]));
            $this->assertEquals(1, $DB->get_field('user', 'deleted', ['id' => $legacy->id]));
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Test that users from additional tenants are neither suspended nor deleted, while hosting tenant users still are.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     * @covers \local_o365\feature\usersync\main::get_additional_tenant_domains
     * @covers \local_o365\feature\usersync\main::is_additional_tenant_user
     */
    public function test_process_user_status_skips_additional_tenant_users(): void {
        global $DB;

        set_config('multitenants', json_encode(['tenant-2' => ['Example.ac.at', 'other.example.ac.at']]), 'local_o365');
        set_config('legacymultitenants', json_encode(['legacy.example.org']), 'local_o365');

        $users = [
            'hosting' => ['upn' => 'hosting@host.example.com', 'suspended' => 0],
            'additional' => ['upn' => 'user@EXAMPLE.ac.at', 'suspended' => 0],
            'additionalsuspended' => ['upn' => 'old@other.example.ac.at', 'suspended' => 1],
            'hostingsuspended' => ['upn' => 'gone@host.example.com', 'suspended' => 1],
            'legacy' => ['upn' => 'user@legacy.example.org', 'suspended' => 0],
        ];
        foreach ($users as $key => $data) {
            $user = $this->getDataGenerator()->create_user();
            $user->auth = 'oidc';
            $user->suspended = $data['suspended'];
            $DB->update_record('user', $user);
            $users[$key]['id'] = $user->id;

            $DB->insert_record('local_o365_objects', (object) [
                'type' => 'user',
                'moodleid' => $user->id,
                'objectid' => 'entra-' . $key,
                'o365name' => $data['upn'],
                'timecreated' => time(),
                'timemodified' => time(),
            ]);
        }

        // Deleting needs the list of soft-deleted Entra users, so serve an empty one from a mock HTTP client.
        $httpclient = new mockhttpclient();
        $httpclient->set_response(json_encode(['value' => []]));
        $apiclient = new unified($this->get_mock_token(), $httpclient);
        $usersync = $this->getMockBuilder(main::class)->onlyMethods(['construct_user_api'])->getMock();
        $usersync->method('construct_user_api')->willReturn($apiclient);
        $temptablename = $usersync->create_entra_users_temp_table();

        try {
            // Empty temp table - none of the users are in the hosting tenant's Entra user list.
            [$reenabled, $suspended, $deleted] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                false, // Do not re-enable.
                true, // Suspend deleted users.
                true, // Delete suspended users.
                false, // Do not suspend on disabled accounts.
                false  // Do not check account status.
            );

            $this->assertEquals(0, $reenabled);
            $this->assertEquals(1, $suspended);
            $this->assertEquals(1, $deleted);

            // Hosting tenant users are suspended / deleted as before.
            $this->assertEquals(1, $DB->get_field('user', 'suspended', ['id' => $users['hosting']['id']]));
            $this->assertEquals(1, $DB->get_field('user', 'deleted', ['id' => $users['hostingsuspended']['id']]));

            // Additional tenant users are untouched, matching domains case-insensitively.
            $additional = $DB->get_record('user', ['id' => $users['additional']['id']]);
            $this->assertEquals(0, $additional->suspended);
            $this->assertEquals(0, $additional->deleted);
            $legacy = $DB->get_record('user', ['id' => $users['legacy']['id']]);
            $this->assertEquals(0, $legacy->suspended);
            $this->assertEquals(0, $legacy->deleted);
            $additionalsuspended = $DB->get_record('user', ['id' => $users['additionalsuspended']['id']]);
            $this->assertEquals(1, $additionalsuspended->suspended);
            $this->assertEquals(0, $additionalsuspended->deleted);
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Test that 'disabledsyncsuspend' independently suspends a user present in Entra with accountEnabled=false,
     * without needing 'suspend' or 'reenable' enabled, and leaves an enabled user alone. This behaviour lives
     * exclusively in userenabledstatussync (not in the regular usersync task), so a disabled Entra account is
     * suspended promptly regardless of when the daily-gated status sync task last ran... other than via this task.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     */
    public function test_process_user_status_disabledsyncsuspend(): void {
        global $DB;

        $activeuser = $this->getDataGenerator()->create_user(['auth' => 'oidc', 'suspended' => 0]);
        $alreadysuspendeduser = $this->getDataGenerator()->create_user(['auth' => 'oidc', 'suspended' => 1]);

        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'moodleid' => $activeuser->id,
            'objectid' => 'entra-user-active',
            'o365name' => $activeuser->email,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);
        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'moodleid' => $alreadysuspendeduser->id,
            'objectid' => 'entra-user-alreadysuspended',
            'o365name' => $alreadysuspendeduser->email,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);

        $usersync = new main();
        $temptablename = $usersync->create_entra_users_temp_table();

        try {
            // Both users are still present in Entra, but their accounts are disabled there.
            $DB->insert_records($temptablename, [
                (object) ['objectid' => 'entra-user-active', 'accountenabled' => 0],
                (object) ['objectid' => 'entra-user-alreadysuspended', 'accountenabled' => 0],
            ]);

            [$reenabled, $suspended, $deleted] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                false, // Do not re-enable.
                false, // Do not suspend deleted users.
                false, // Do not delete.
                true, // Suspend users disabled in Entra.
                false  // Do not re-enable users enabled in Entra.
            );

            $this->assertEquals(0, $reenabled);
            $this->assertEquals(1, $suspended);
            $this->assertEquals(0, $deleted);

            $this->assertEquals(
                1,
                $DB->get_field('user', 'suspended', ['id' => $activeuser->id]),
                'User should be suspended when present in Entra but disabled there.'
            );
            $this->assertEquals(
                1,
                $DB->get_field('user', 'suspended', ['id' => $alreadysuspendeduser->id]),
                'Already-suspended user should remain suspended.'
            );
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Test that 'suspendnolink' suspends oidc accounts with no local_o365_objects record, matching by username, and
     * leaves alone accounts that are still present and enabled in Entra as well as non-oidc accounts.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     * @covers \local_o365\feature\usersync\main::suspend_unlinked_users_from_temp_table
     */
    public function test_process_user_status_suspend_unlinked(): void {
        global $DB;

        // Binding username claim must be a specific resolvable field for unlinked matching to run.
        set_config('bindingusernameclaim', 'upn', 'auth_oidc');

        $generator = $this->getDataGenerator();
        // Orphan oidc account (no local_o365_objects record) that is missing from Entra.
        $deletedorphan = $generator->create_user(['auth' => 'oidc', 'suspended' => 0]);
        // Orphan oidc account still present and enabled in Entra - must be left alone.
        $liveorphan = $generator->create_user(['auth' => 'oidc', 'suspended' => 0]);
        // Non-oidc account whose username matches an Entra account - must never be touched.
        $manualuser = $generator->create_user(['auth' => 'manual', 'suspended' => 0]);
        // Orphan missing from Entra but already suspended - reported only, not re-counted.
        $suspendedorphan = $generator->create_user(['auth' => 'oidc', 'suspended' => 1]);

        $usersync = new main();
        $temptablename = $usersync->create_entra_users_temp_table();

        try {
            $DB->insert_records($temptablename, [
                (object) ['objectid' => 'obj-live', 'accountenabled' => 1, 'bindingvalue' => $liveorphan->username],
                (object) ['objectid' => 'obj-manual', 'accountenabled' => 1, 'bindingvalue' => $manualuser->username],
            ]);

            [$reenabled, $suspended, $deleted] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                false, // Do not re-enable.
                true, // Suspend deleted users.
                false, // Do not delete.
                false, // Do not suspend on disabled accounts.
                false, // Do not re-enable users enabled in Entra.
                true   // Suspend unlinked accounts.
            );

            $this->assertEquals(0, $reenabled);
            $this->assertEquals(1, $suspended, 'Only the not-yet-suspended orphan should be counted.');
            $this->assertEquals(0, $deleted);

            $this->assertEquals(
                1,
                $DB->get_field('user', 'suspended', ['id' => $deletedorphan->id]),
                'Unlinked oidc account missing from Entra should be suspended.'
            );
            $this->assertEquals(
                0,
                $DB->get_field('user', 'suspended', ['id' => $liveorphan->id]),
                'Unlinked oidc account still present and enabled in Entra should be left alone.'
            );
            $this->assertEquals(
                0,
                $DB->get_field('user', 'suspended', ['id' => $manualuser->id]),
                'Non-oidc account should never be touched.'
            );
            $this->assertEquals(
                1,
                $DB->get_field('user', 'suspended', ['id' => $suspendedorphan->id]),
                'Already-suspended orphan stays suspended and is not re-counted.'
            );
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Test the guards on 'suspendnolink': it does nothing when the option is off, skips guest-style usernames, and
     * only suspends matched-but-disabled accounts when 'disabledsyncsuspend' is on.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     * @covers \local_o365\feature\usersync\main::suspend_unlinked_users_from_temp_table
     */
    public function test_process_user_status_suspend_unlinked_guards(): void {
        global $DB;

        set_config('bindingusernameclaim', 'upn', 'auth_oidc');

        $generator = $this->getDataGenerator();
        $orphan = $generator->create_user(['auth' => 'oidc', 'suspended' => 0]);
        $guestorphan = $generator->create_user(['auth' => 'oidc', 'suspended' => 0, 'username' => 'guest_ext_1']);
        $disabledorphan = $generator->create_user(['auth' => 'oidc', 'suspended' => 0]);

        $usersync = new main();

        // Option off - nothing happens even though the orphan is missing from Entra.
        $temptablename = $usersync->create_entra_users_temp_table();
        try {
            $DB->insert_records($temptablename, [
                (object) ['objectid' => 'obj-x', 'accountenabled' => 1, 'bindingvalue' => 'someone-else'],
            ]);
            $usersync->process_user_status_from_temp_table($temptablename, false, true, false, false, false, false);
            $this->assertEquals(
                0,
                $DB->get_field('user', 'suspended', ['id' => $orphan->id]),
                'Nothing should happen while suspendnolink is off.'
            );
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }

        // Option on: guest-style username is skipped; disabled match only suspended with disabledsyncsuspend.
        $temptablename = $usersync->create_entra_users_temp_table();
        try {
            $DB->insert_records($temptablename, [
                (object) ['objectid' => 'obj-disabled', 'accountenabled' => 0, 'bindingvalue' => $disabledorphan->username],
                (object) ['objectid' => 'obj-guest', 'accountenabled' => 0, 'bindingvalue' => 'guest_ext_1'],
            ]);
            [, $suspended] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                false,
                true,
                false,
                true,
                false,
                true
            );

            $this->assertEquals(2, $suspended);
            $this->assertEquals(
                1,
                $DB->get_field('user', 'suspended', ['id' => $orphan->id]),
                'Orphan missing from Entra should be suspended.'
            );
            $this->assertEquals(
                1,
                $DB->get_field('user', 'suspended', ['id' => $disabledorphan->id]),
                'Orphan disabled in Entra should be suspended when disabledsyncsuspend is on.'
            );
            $this->assertEquals(
                0,
                $DB->get_field('user', 'suspended', ['id' => $guestorphan->id]),
                'Guest-style username should be skipped.'
            );
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Test that 'suspendnolink' does nothing when the binding username claim is "auto" (its effective claim is decided
     * per login and can differ between users, so the Moodle username cannot be reliably matched to one Entra account).
     *
     * @covers \local_o365\feature\usersync\main::suspend_unlinked_users_from_temp_table
     * @covers \local_o365\feature\usersync\main::get_binding_graph_field
     */
    public function test_process_user_status_suspend_unlinked_requires_specific_claim(): void {
        global $DB;

        set_config('bindingusernameclaim', 'auto', 'auth_oidc');

        $orphan = $this->getDataGenerator()->create_user(['auth' => 'oidc', 'suspended' => 0]);

        $usersync = new main();
        $temptablename = $usersync->create_entra_users_temp_table();
        try {
            $DB->insert_records($temptablename, [
                (object) ['objectid' => 'obj-x', 'accountenabled' => 1, 'bindingvalue' => 'someone-else'],
            ]);
            [, $suspended] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                false,
                true,
                false,
                false,
                false,
                true
            );

            $this->assertEquals(0, $suspended);
            $this->assertEquals(
                0,
                $DB->get_field('user', 'suspended', ['id' => $orphan->id]),
                'Unlinked matching must not run when the binding claim is "auto".'
            );
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Test that 'disabledsyncreenable' independently re-enables a suspended user present in Entra with
     * accountEnabled=true, without needing 'reenable' enabled, and leaves a still-disabled user suspended.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     */
    public function test_process_user_status_disabledsyncreenable(): void {
        global $DB;

        $suspendeduser = $this->getDataGenerator()->create_user(['auth' => 'oidc', 'suspended' => 1]);
        $stilldisableduser = $this->getDataGenerator()->create_user(['auth' => 'oidc', 'suspended' => 1]);

        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'moodleid' => $suspendeduser->id,
            'objectid' => 'entra-user-reenabled',
            'o365name' => $suspendeduser->email,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);
        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'moodleid' => $stilldisableduser->id,
            'objectid' => 'entra-user-stilldisabled',
            'o365name' => $stilldisableduser->email,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);

        $usersync = new main();
        $temptablename = $usersync->create_entra_users_temp_table();

        try {
            $DB->insert_records($temptablename, [
                (object) ['objectid' => 'entra-user-reenabled', 'accountenabled' => 1],
                (object) ['objectid' => 'entra-user-stilldisabled', 'accountenabled' => 0],
            ]);

            [$reenabled, $suspended, $deleted] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                false, // Do not re-enable.
                false, // Do not suspend deleted users.
                false, // Do not delete.
                false, // Do not suspend users disabled in Entra.
                true   // Re-enable users enabled in Entra.
            );

            $this->assertEquals(1, $reenabled);
            $this->assertEquals(0, $suspended);
            $this->assertEquals(0, $deleted);

            $this->assertEquals(
                0,
                $DB->get_field('user', 'suspended', ['id' => $suspendeduser->id]),
                'User should be re-enabled when present and enabled again in Entra.'
            );
            $this->assertEquals(
                1,
                $DB->get_field('user', 'suspended', ['id' => $stilldisableduser->id]),
                'User should remain suspended while still disabled in Entra.'
            );
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
        }
    }

    /**
     * Test sync_users when user is renamed in Entra ID with username update disabled.
     *
     * Regression test for issue #3107: When a user is renamed in Azure AD (e.g., uppercase to lowercase),
     * and the "Update Moodle username" setting is disabled, both o365name and auth_oidc_token.useridentifier
     * should still be updated to prevent OIDC login failures and sync issues.
     *
     * @covers \local_o365\feature\usersync\main::sync_users
     */
    public function test_sync_users_renamed_with_username_update_disabled(): void {
        global $CFG, $DB;

        // Disable username updates.
        set_config('supportuseridentifierchange', '0', 'local_o365');

        // Configure minimal sync settings (sync existing users only, no new user creation).
        set_config('usersync', 'sync', 'local_o365');

        // Create initial user with lowercase UPN (as it currently exists in Moodle).
        // This simulates a user that was previously synced from Entra ID.
        $muser = [
            'auth' => 'oidc',
            'deleted' => '0',
            'mnethostid' => $CFG->mnet_localhost_id,
            'username' => 'testuser@example.onmicrosoft.com', // Lowercase - current state.
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'testuser@example.onmicrosoft.com',
            'lang' => 'en',
        ];
        $muser['id'] = $DB->insert_record('user', (object) $muser);
        $userid = $muser['id'];

        // Create o365 object with UPPERCASE o365name.
        // This simulates what was stored when the user was synced with uppercase UPN.
        // Now the user has been renamed in Azure AD to lowercase.
        $o365object = (object) [
            'type' => 'user',
            'subtype' => 'default',
            'objectid' => '00000000-0000-0000-0000-000000000001',
            'moodleid' => $userid,
            'o365name' => 'TestUser@example.onmicrosoft.com', // Uppercase - old value before rename.
            'timecreated' => time(),
            'timemodified' => time(),
        ];
        $o365id = $DB->insert_record('local_o365_objects', $o365object);

        // Create auth token with UPPERCASE useridentifier (the stale value).
        // This simulates what happens after a user is renamed in Azure AD but token isn't updated.
        $token = (object) [
            'oidcuniqid' => '00000000-0000-0000-0000-000000000001',
            'authcode' => '000',
            'username' => 'testuser@example.onmicrosoft.com', // Current lowercase.
            'useridentifier' => 'TestUser@example.onmicrosoft.com', // Uppercase - stale, will be updated.
            'userid' => $userid,
            'scope' => 'test',
            'tokenresource' => unified::get_tokenresource(),
            'token' => '000',
            'expiry' => '9999999999',
            'refreshtoken' => 'refreshtoken1',
            'idtoken' => 'idtoken1',
        ];
        $tokenid = $DB->insert_record('auth_oidc_token', $token);

        // Simulate Entra ID response with lowercase UPN (renamed).
        $response = [
            'value' => [
                [
                    'odata.type' => 'Microsoft.WindowsAzure.ActiveDirectory.User',
                    'objectType' => 'User',
                    'objectId' => '00000000-0000-0000-0000-000000000001',
                    'id' => '00000000-0000-0000-0000-000000000001',
                    'givenName' => 'Test',
                    'mail' => 'testuser@example.onmicrosoft.com',
                    'surname' => 'User',
                    'userPrincipalName' => 'testuser@example.onmicrosoft.com', // Lowercase - renamed.
                    'useridentifier' => 'testuser@example.onmicrosoft.com', // Lowercase - renamed.
                    'useridentifierlower' => 'testuser@example.onmicrosoft.com', // Lowercase - renamed.
                    'upnsplit0' => 'testuser',
                ],
            ],
        ];
        $response = json_encode($response);
        $httpclient = new mockhttpclient();
        $httpclient->set_response($response);

        // Run sync.
        $apiclient = new unified($this->get_mock_token(), $httpclient);
        $usersync = new main();
        $apiclient->process_users_batched(function (array $userbatch) use ($usersync) {
            $usersync->sync_users($userbatch, 'userPrincipalName');
        });

        // Verify Moodle username was NOT changed (because username update is disabled).
        $updateduser = $DB->get_record('user', ['id' => $userid]);
        $this->assertEquals(
            'testuser@example.onmicrosoft.com',
            $updateduser->username,
            'Moodle username should remain unchanged when username update is disabled'
        );

        // Verify o365name WAS updated from uppercase to lowercase.
        $updatedo365object = $DB->get_record('local_o365_objects', ['id' => $o365id]);
        $this->assertEquals(
            'testuser@example.onmicrosoft.com',
            $updatedo365object->o365name,
            'o365name should be updated from uppercase to the new lowercase identifier'
        );

        // Verify token useridentifier WAS updated from uppercase to lowercase.
        $updatedtoken = $DB->get_record('auth_oidc_token', ['id' => $tokenid]);
        $this->assertEquals(
            'testuser@example.onmicrosoft.com',
            $updatedtoken->useridentifier,
            'auth_oidc_token.useridentifier should be updated from uppercase to the new lowercase identifier'
        );

        // Verify only one OIDC user exists (no new user created).
        $usercount = $DB->count_records('user', ['auth' => 'oidc']);
        $this->assertEquals(
            1,
            $usercount,
            'Exactly one OIDC user should exist; no new user should be created'
        );
    }

    /**
     * Test user creation restrictions with multiple Microsoft 365 group object IDs.
     *
     * @covers \local_o365\feature\usersync\main::check_usercreationrestriction
     */
    public function test_usercreationrestriction_multiple_group_ids(): void {
        $apiclient = new class {
            /**
             * Transitive group IDs returned for the test user.
             *
             * @var array
             */
            public ?array $usergroups = [];

            /**
             * Return the configured test group IDs.
             *
             * @param string $userid User object ID.
             * @return array
             */
            public function get_user_transitive_groups($userid): ?array {
                return $this->usergroups;
            }
        };

        $usersync = new class ($apiclient) extends main {
            /**
             * Test API client.
             *
             * @var object
             */
            private object $testapiclient;

            /**
             * Constructor.
             *
             * @param object $apiclient Test API client.
             */
            public function __construct(object $apiclient) {
                $this->testapiclient = $apiclient;
            }

            /**
             * Return the test API client.
             *
             * @return object
             */
            public function construct_user_api() {
                return $this->testapiclient;
            }

            /**
             * Expose the protected restriction check for this regression test.
             *
             * @param array $entraiduserdata Entra ID user data.
             * @return bool
             */
            public function check_usercreationrestriction_for_test(array $entraiduserdata): bool {
                return $this->check_usercreationrestriction($entraiduserdata);
            }
        };

        $restriction = [
            'remotefield' => 'o365groupid',
            'value' => '11111111-1111-1111-1111-111111111111, 22222222-2222-2222-2222-222222222222',
            'useregex' => false,
        ];
        set_config('usersynccreationrestriction', serialize($restriction), 'local_o365');

        // Membership in any configured group should pass.
        $apiclient->usergroups = ['22222222-2222-2222-2222-222222222222'];
        $this->assertTrue($usersync->check_usercreationrestriction_for_test(['id' => 'test-user']));

        // No matching configured group should fail.
        $apiclient->usergroups = ['33333333-3333-3333-3333-333333333333'];
        $this->assertFalse($usersync->check_usercreationrestriction_for_test(['id' => 'test-user']));

        // Preserve the existing single-group configuration behavior.
        $restriction['value'] = '22222222-2222-2222-2222-222222222222';
        set_config('usersynccreationrestriction', serialize($restriction), 'local_o365');
        $apiclient->usergroups = ['22222222-2222-2222-2222-222222222222'];
        $this->assertTrue($usersync->check_usercreationrestriction_for_test(['id' => 'test-user']));

        // Group object IDs should match regardless of GUID letter casing.
        $restriction['value'] = 'AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA';
        set_config('usersynccreationrestriction', serialize($restriction), 'local_o365');
        $apiclient->usergroups = ['aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa'];
        $this->assertTrue($usersync->check_usercreationrestriction_for_test(['id' => 'test-user']));

        // A failed Graph lookup can return null. This must fail closed without a TypeError.
        $apiclient->usergroups = null;
        $this->assertFalse($usersync->check_usercreationrestriction_for_test(['id' => 'test-user']));
    }

    /**
     * Test that is_enabled() correctly reflects whether the scheduled user sync task should run.
     *
     * @covers \local_o365\feature\usersync\main::is_enabled
     */
    public function test_is_enabled(): void {
        // No usersync config at all.
        unset_config('usersync', 'local_o365');
        $this->assertFalse(main::is_enabled());

        // Only an on-login-only option is configured; the scheduled task has nothing to do.
        set_config('usersync', 'photosynconlogin', 'local_o365');
        $this->assertFalse(main::is_enabled());

        // The 'match' option alone must enable the scheduled task, even without 'matchswitchauth'.
        set_config('usersync', 'match', 'local_o365');
        $this->assertTrue(main::is_enabled());

        // A core option combined with an on-login-only option still enables the task.
        set_config('usersync', 'photosynconlogin,create', 'local_o365');
        $this->assertTrue(main::is_enabled());
    }
}
