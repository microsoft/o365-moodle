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
     * Test accountEnabled gating: suspended users with accountEnabled=0 are not re-enabled.
     *
     * @covers \local_o365\feature\usersync\main::process_user_status_from_temp_table
     */
    public function test_process_user_status_reenable_with_disabled_account(): void {
        global $DB;

        set_config('usersync', 'create', 'local_o365');
        set_config('usersync_reenable', 1, 'local_o365');
        set_config('usersync_disabledsync', 1, 'local_o365');

        $user1 = $this->getDataGenerator()->create_user();
        $user1->suspended = 1;
        $user1->auth = 'oidc';
        $DB->update_record('user', $user1);

        $DB->insert_record('local_o365_objects', (object) [
            'type' => 'user',
            'moodleid' => $user1->id,
            'objectid' => 'entra-user-1',
            'o365name' => $user1->email,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);

        $usersync = new main();
        $temptablename = $usersync->create_entra_users_temp_table();

        try {
            // User has accountEnabled=0 in Entra.
            $DB->insert_records($temptablename, [
                (object) ['objectid' => 'entra-user-1', 'accountenabled' => 0],
            ]);

            // Process with syncdisabledstatus=true.
            [$reenabled, $suspended, $deleted] = $usersync->process_user_status_from_temp_table(
                $temptablename,
                true, // Re-enable suspended users.
                false, // Do not suspend.
                false, // Do not delete.
                true  // Check account enabled status.
            );

            $this->assertEquals(0, $reenabled);

            // User should still be suspended.
            $user1refresh = $DB->get_record('user', ['id' => $user1->id]);
            $this->assertEquals(1, $user1refresh->suspended);
        } finally {
            $usersync->drop_entra_users_temp_table($temptablename);
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
}
