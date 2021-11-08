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
 * Tests \local_o365\feature\usergroups\coursegroups.
 *
 * @group local_o365
 * @group office365
 */
class local_o365_coursegroups_testcase extends \advanced_testcase {
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
            'tokenresource' => 'resource',
        ];

        $clientdata = $this->get_mock_clientdata();
        $token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken,
                $tokenrec->scope, $tokenrec->tokenresource, $tokenrec->user_id, $clientdata, $httpclient);
        return $token;
    }

    /**
     * Construct a coursegroups instance using mock data.
     *
     * @param \local_o365\httpclient $httpclient Http Client to use.
     * @return \local_o365\feature\usergroups\coursegroups Constructed coursegroups instance.
     */
    public function constructcoursegroupsinstance($httpclient) {
        global $DB;
        $token = $this->get_mock_token();
        $graphclient = new \local_o365\rest\unified($token, $httpclient);
        return new \local_o365\feature\usergroups\coursegroups($graphclient, $DB, false);
    }

    /**
     * Test create_group() method.
     */
    public function test_create_group() {
        $course = $this->getDataGenerator()->create_course();

         // Set up mock http client.
        $httpclient = new \local_o365\tests\mockhttpclient();
        $fixedresponse = ['id' => 'group1'];
        $httpclient->set_response(json_encode($fixedresponse));

        $coursegroups = $this->constructcoursegroupsinstance($httpclient);
        $objectrec = $coursegroups->create_group($course); // This may need to be updated to consider the new naming settings.

        // Assert returned object record.
        $expectedobjectrec = [
            'type' => 'group',
            'subtype' => 'course',
            'objectid' => 'group1',
            'moodleid' => $course->id,
            'o365name' => $course->fullname,
        ];
        $this->assertEquals($expectedobjectrec, array_intersect_key($objectrec, $expectedobjectrec));

        // Assert API calls.
        $requests = $httpclient->get_requests();
        $pluginversion = get_config('local_o365', 'version');
        $expecteduseragent = 'Moodle-groups-'.$pluginversion;
        $description = strip_tags($course->summary);
        if (strlen($description) > 1024) {
            $description = shorten_text($description, 1024, true, ' ...');
        }
        $expectedrequests = [
            [
                'url' => 'https://graph.microsoft.com/v1.0/groups',
                'options' => [
                    'CURLOPT_POST' => 1,
                    'CURLOPT_POSTFIELDS' => json_encode([
                        'groupTypes' => ['Unified'],
                        'displayName' => $course->fullname,
                        'mailEnabled' => false,
                        'securityEnabled' => false,
                        'mailNickname' => strtolower(preg_replace('/[^a-z0-9-_]+/iu', '', $course->fullname)),
                        'visibility' => 'Private',
                        'resourceBehaviorOptions' => ["HideGroupInOutlook","WelcomeEmailDisabled"],
                        'description' => $description,
                    ]),
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],
        ];
        $this->assertEquals($expectedrequests, $requests);
    }

    /**
     * Test resync_group_membership method.
     */
    public function test_resync_group_membership() {
        global $DB;

        // Create Moodle entities.
        $course = $this->getDataGenerator()->create_course();
        $users = [
            $this->getDataGenerator()->create_user(),
            $this->getDataGenerator()->create_user(),
            $this->getDataGenerator()->create_user(),
        ];

        // Create tokens and objects for users.
        foreach ($users as $i => $user) {
            $tokenrec = [
                'oidcuniqid' => 'user'.$i,
                'tokenresource' => 'https://graph.microsoft.com',
                'username' => $user->username,
                'userid' => $user->id,
                'scope' => 'User.Read',
                'authcode' => '000',
                'token' => '111',
                'refreshtoken' => '222',
                'idtoken' => '333',
                'expiry' => time() + 9999,
            ];
            $tokenrec['id'] = $DB->insert_record('auth_oidc_token', (object)$tokenrec);

            $objectrec = [
                'moodleid' => $user->id,
                'type' => 'user',
                'objectid' => 'user'.$i,
                'o365name' => 'testuser'.$i.'@example.onmicrosoft.com',
                'timecreated' => time(),
                'timemodified' => time(),
            ];
            $objectrec['id'] = $DB->insert_record('local_o365_objects', (object)$objectrec);
        }

        // Enrol users.
        $this->getDataGenerator()->enrol_user($users[0]->id, $course->id);
        $this->getDataGenerator()->enrol_user($users[1]->id, $course->id);

        // Set up mock http client.
        $httpclient = new \local_o365\tests\mockhttpclient();
        $memberresponse = [
            'value' => [
                [
                    'id' => 'user1',
                ],
                [
                    'id' => 'user2',
                ]
            ]
        ];
        $httpclient->set_response(json_encode($memberresponse));

        $coursegroups = $this->constructcoursegroupsinstance($httpclient);
        [$toadd, $toremove] = $coursegroups->resync_group_membership($course->id, 'testgroupobjectid');

        $pluginversion = get_config('local_o365', 'version');
        $expecteduseragent = 'Moodle-groups-'.$pluginversion;

        $requests = $httpclient->get_requests();
        $expectedrequests = [
            // List members request.
            [
                'url' => 'https://graph.microsoft.com/v1.0/groups/testgroupobjectid/members',
                'options' => [
                    'CURLOPT_HTTPGET' => '1',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],

            // List owners request.
            [
                'url' => 'https://graph.microsoft.com/v1.0/groups/testgroupobjectid/owners',
                'options' => [
                    'CURLOPT_HTTPGET' => '1',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],

            // Attempts to get group.
            [
                'url' => 'https://graph.microsoft.com/v1.0/groups/testgroupobjectid',
                'options' => [
                    'CURLOPT_HTTPGET' => '1',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],
            [
                'url' => 'https://graph.microsoft.com/v1.0/groups/testgroupobjectid',
                'options' => [
                    'CURLOPT_HTTPGET' => '1',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],
            [
                'url' => 'https://graph.microsoft.com/v1.0/groups/testgroupobjectid',
                'options' => [
                    'CURLOPT_HTTPGET' => '1',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],
            [
                'url' => 'https://graph.microsoft.com/v1.0/groups/testgroupobjectid',
                'options' => [
                    'CURLOPT_HTTPGET' => '1',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],            [
                'url' => 'https://graph.microsoft.com/v1.0/groups/testgroupobjectid',
                'options' => [
                    'CURLOPT_HTTPGET' => '1',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],
            [
                'url' => 'https://graph.microsoft.com/v1.0/groups/testgroupobjectid',
                'options' => [
                    'CURLOPT_HTTPGET' => '1',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],

            // Remove user1 as owner.
            [
                'url' => 'https://graph.microsoft.com/beta/groups/testgroupobjectid/owners/user1/$ref',
                'options' => [
                    'CURLOPT_CUSTOMREQUEST' => 'DELETE',
                    'CURLOPT_USERPWD' => 'anonymous: noreply@moodle.org',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],

            // Remove user2 as owner.
            [
                'url' => 'https://graph.microsoft.com/beta/groups/testgroupobjectid/owners/user2/$ref',
                'options' => [
                    'CURLOPT_CUSTOMREQUEST' => 'DELETE',
                    'CURLOPT_USERPWD' => 'anonymous: noreply@moodle.org',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],

            // Remove user2 as member.
            [
                'url' => 'https://graph.microsoft.com/beta/groups/testgroupobjectid/members/user2/$ref',
                'options' => [
                    'CURLOPT_CUSTOMREQUEST' => 'DELETE',
                    'CURLOPT_USERPWD' => 'anonymous: noreply@moodle.org',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],

            // Add request.
            [
                'url' => 'https://graph.microsoft.com/beta/groups/testgroupobjectid/members/$ref',
                'options' => [
                    'CURLOPT_POST' => '1',
                    'CURLOPT_POSTFIELDS' => '{"@odata.id":"https:\/\/graph.microsoft.com\/v1.0\/directoryObjects\/user0"}',
                    'CURLOPT_USERAGENT' => $expecteduseragent,
                ],
            ],
        ];
        $this->assertEquals($expectedrequests, $requests);

        $expectedtoadd = ['user0'];
        $this->assertEquals($expectedtoadd, $toadd);
        $expectedtoremove = ['user1', 'user2'];
        $this->assertEquals($expectedtoremove, $toremove);
    }
}
