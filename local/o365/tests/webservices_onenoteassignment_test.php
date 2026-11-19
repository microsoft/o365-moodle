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
 * Test cases for onenote assignment features.
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365;

use advanced_testcase;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use lang_string;
use local_o365\webservices\create_onenoteassignment;
use local_o365\webservices\delete_onenoteassignment;
use local_o365\webservices\read_onenoteassignment;
use local_o365\webservices\update_onenoteassignment;
use PHPUnit\Framework\AssertionFailedError;

/**
 * Tests \local_o365\webservices\utils
 *
 * @group local_o365
 * @group office365
 */
final class webservices_onenoteassignment_test extends advanced_testcase {
    // Data structure elements of the array based on old Data Provider.
    /** @var int */
    const DBSTATE = 0;
    /** @var int */
    const PARAMS = 1;
    /** @var int  */
    const EXPECTEDRETURN = 2;
    /** @var int */
    const EXPECTEDEXCEPTION = 3;

    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Run every test case, asserting the expected exception when the case defines one.
     *
     * Each case is executed independently, so a case that expects an exception does not stop the following cases.
     *
     * @param array $testcases Test cases, indexed by description. Each case uses the DBSTATE, PARAMS, EXPECTEDRETURN and
     *                         EXPECTEDEXCEPTION indexes.
     * @param callable $callback Callback receiving the test case, which calls the tested method and asserts its return.
     */
    private function run_testcases(array $testcases, callable $callback): void {
        foreach ($testcases as $description => $data) {
            if (!empty($data[self::DBSTATE])) {
                $dataset = $this->createArrayDataSet($data[self::DBSTATE]);
                $this->loadDataSet($dataset);
            }

            $this->setAdminUser();

            $expectedexception = $data[self::EXPECTEDEXCEPTION];
            $thrown = null;
            try {
                $callback($data);
            } catch (\Throwable $e) {
                if (empty($expectedexception) || $e instanceof AssertionFailedError) {
                    throw $e;
                }
                $thrown = $e;
            }

            if (!empty($expectedexception)) {
                $this->assertNotNull($thrown, $description . ': expected exception ' . $expectedexception[0] . ' was not thrown.');
                $this->assertInstanceOf($expectedexception[0], $thrown, $description);
                if (isset($expectedexception[1])) {
                    $this->assertStringContainsString($expectedexception[1], $thrown->getMessage(), $description);
                }
            }
        }
    }

    /**
     * Test assignment_create_parameters method.
     *
     * @covers \local_o365\webservices\create_onenoteassignment::assignment_create_parameters
     */
    public function test_assignment_create_parameters(): void {
        $schema = create_onenoteassignment::assignment_create_parameters();
        $this->assertTrue($schema instanceof external_function_parameters);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Dataprovider for test_assignment_create.
     *
     * @return array Array of test parameters.
     */
    public static function dataprovider_create_assignment(): array {
        return [
            [
                [
                    'name' => 'Test assignment',
                    'course' => '[[courseid]]',
                    'intro' => 'Test Intro',
                    'section' => 1,
                    'visible' => 0,
                ],
                [
                    'course' => '[[courseid]]',
                    'coursemodule' => '[[coursemodule]]',
                    'name' => 'Test assignment',
                    'intro' => 'Test Intro',
                    'section' => '[[section]]',
                    'visible' => '0',
                    'instance' => '[[instance]]',

                ],
            ],
        ];
    }

    /**
     * Test \local_o365\webservices\create_onenoteassignment::assignment_create().
     *
     * @dataProvider dataprovider_create_assignment
     * @param array $params Webservice parameters.
     * @param array $expectedreturn Expected return.
     * @covers \local_o365\webservices\create_onenoteassignment::assignment_create
     */
    public function test_assignment_create($params, $expectedreturn): void {
        global $DB;
        $course = $this->getDataGenerator()->create_course();

        if ($params['course'] === '[[courseid]]') {
            $params['course'] = (int) $course->id;
        }

        $this->setAdminUser();

        $actualreturn = create_onenoteassignment::assignment_create($params);
        $this->assertNotEmpty($actualreturn);
        $this->assertArrayHasKey('data', $actualreturn);

        if ($expectedreturn['course'] === '[[courseid]]') {
            $expectedreturn['course'] = $course->id;
        }

        if ($expectedreturn['coursemodule'] === '[[coursemodule]]') {
            $expectedreturn['coursemodule'] = $actualreturn['data'][0]['coursemodule'];
        }

        if ($expectedreturn['section'] === '[[section]]') {
            $expectedreturn['section'] = $actualreturn['data'][0]['section'];
        }

        if ($expectedreturn['instance'] === '[[instance]]') {
            $expectedreturn['instance'] = $actualreturn['data'][0]['instance'];
        }

        $this->assertEquals($expectedreturn, $actualreturn['data'][0]);

        $this->assertNotEmpty($DB->get_record('course_modules', ['id' => $actualreturn['data'][0]['coursemodule']]));
        $this->assertNotEmpty($DB->get_record('assign', ['id' => $actualreturn['data'][0]['instance']]));
    }

    /**
     * Test assignment_create_returns method.
     *
     * @covers \local_o365\webservices\create_onenoteassignment::assignment_create_returns
     */
    public function test_assignment_create_returns(): void {
        $schema = create_onenoteassignment::assignment_create_returns();
        $this->assertTrue($schema instanceof external_single_structure);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Test assignment_read_parameters method.
     *
     * @covers \local_o365\webservices\read_onenoteassignment::assignment_read_parameters
     */
    public function test_assignment_read_parameters(): void {
        $schema = read_onenoteassignment::assignment_read_parameters();
        $this->assertTrue($schema instanceof external_function_parameters);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Returns a list of general data existence tests to run against any function that looks up assignment data.
     *
     * @return array[] [type] [description]
     */
    public static function get_general_assignment_data_tests() {
        global $DB;

        $course = static::getDataGenerator()->create_course();
        // Assignment without OneNote submission enabled.
        $assign = static::getDataGenerator()->create_module('assign', ['course' => $course->id,
            'section' => 1,
            'name' => 'Assignment',
            'intro' => 'This is a test assignment']);
        $onenoteassign = static::getDataGenerator()->create_module('assign', ['course' => $course->id,
            'section' => 1,
            'name' => 'OneNote Assignment',
            'intro' => 'This is a test assignment']);

        // Enable OneNote submission for the OneNote assignment.
        $pluginconfigparams = [
            'assignment' => $onenoteassign->id,
            'plugin' => 'onenote',
            'subtype' => 'assignsubmission',
            'name' => 'enabled',
        ];
        $assignpluginconfig = $DB->get_record('assign_plugin_config', $pluginconfigparams);
        if (empty($assignpluginconfig)) {
            $pluginconfigparams['value'] = 1;
            $DB->insert_record('assign_plugin_config', $pluginconfigparams);
        } else if (empty($pluginconfigparams['value'])) {
            $assignpluginconfig->value = 1;
            $DB->update_record('assign_plugin_config', $assignpluginconfig);
        }

        // Explicitly disable OneNote submission for the plain assignment.
        $disabledparams = [
            'assignment' => $assign->id,
            'plugin' => 'onenote',
            'subtype' => 'assignsubmission',
            'name' => 'enabled',
        ];
        $disabledconfig = $DB->get_record('assign_plugin_config', $disabledparams);
        if (empty($disabledconfig)) {
            $disabledparams['value'] = 0;
            $DB->insert_record('assign_plugin_config', $disabledparams);
        } else {
            $disabledconfig->value = 0;
            $DB->update_record('assign_plugin_config', $disabledconfig);
        }

        // Create course modules whose assignment record does not exist.
        $assignmoduleid = $DB->get_field('modules', 'id', ['name' => 'assign'], MUST_EXIST);
        $noinstancecmid = $DB->insert_record('course_modules', [
            'course' => $course->id,
            'module' => $assignmoduleid,
            'instance' => 0,
        ]);
        $missinginstancecmid = $DB->insert_record('course_modules', [
            'course' => $course->id,
            'module' => $assignmoduleid,
            'instance' => $onenoteassign->id + 1000,
        ]);

        // Get assignment config.
        $fakecourseid = $course->id + 1;
        $fakecmid = $missinginstancecmid + 1;

        $invalidrecord = new lang_string('invalidrecord', 'error', 'course');

        return [
            'Course not found (no course)' => [
                'dbstate' => [],
                'params' => [
                    'coursemodule' => $assign->cmid,
                    'course' => -1,
                ],
                'expectedexception' => ['dml_missing_record_exception', $invalidrecord->out()],
            ],
            'Course not found (different id)' => [
                'dbstate' => [],
                'params' => [
                    'coursemodule' => $assign->cmid,
                    'course' => $fakecourseid,
                ],
                'expectedexception' => ['dml_missing_record_exception', $invalidrecord->out()],
            ],
            'Module not found (no record)' => [
                'dbstate' => [],
                'params' => [
                    'coursemodule' => -1,
                    'course' => $course->id,
                ],
                'expectedexception' => ['local_o365\webservices\exception\modulenotfound'],
            ],
            'Module not found (different id)' => [
                'dbstate' => [],
                'params' => [
                    'coursemodule' => $fakecmid,
                    'course' => $course->id,
                ],
                'expectedexception' => ['local_o365\webservices\exception\modulenotfound'],
            ],
            'Assignment record not found (no record)' => [
                'dbstate' => [],
                'params' => [
                    'coursemodule' => $noinstancecmid,
                    'course' => $course->id,
                ],
                'expectedexception' => ['local_o365\webservices\exception\assignnotfound'],
            ],
            'Assignment record not found (no record for that course_module record)' => [
                'dbstate' => [],
                'params' => [
                    'coursemodule' => $missinginstancecmid,
                    'course' => $course->id,
                ],
                'expectedexception' => ['local_o365\webservices\exception\assignnotfound'],
            ],
            'All data correct, assignment not a OneNote assignment' => [
                'dbstate' => [],
                'params' => [
                    'coursemodule' => $assign->cmid,
                    'course' => $course->id,
                ],
                'expectedexception' => ['local_o365\webservices\exception\invalidassignment'],
            ],
            'All data correct, assignment is a OneNote assignment' => [
                'dbstate' => [],
                'params' => [
                    'coursemodule' => $onenoteassign->cmid,
                    'course' => $course->id,
                ],
                'expectedexception' => null,
            ],
        ];
    }

    /**
     * Get the test cases for test_assignment_read.
     *
     * @return array Array of test parameters.
     */
    public static function get_assignment_read_testcases(): array {
        global $DB;

        $generaltests = static::get_general_assignment_data_tests();
        $return = [];

        foreach ($generaltests as $testkey => $parameters) {
            if ($testkey === 'All data correct, assignment is a OneNote assignment') {
                $return[$testkey] = [
                    $parameters['dbstate'],
                    $parameters['params'],
                    [
                        'data' => [
                            [
                                'course' => $parameters['params']['course'],
                                'coursemodule' => (string) $parameters['params']['coursemodule'],
                                'name' => 'OneNote Assignment',
                                'intro' => 'This is a test assignment',
                                'section' => $DB->get_field(
                                    'course_sections',
                                    'id',
                                    ['course' => $parameters['params']['course'],
                                    'section' => 1]
                                ),
                                'visible' => '1',
                                'instance' => $DB->get_field(
                                    'course_modules',
                                    'instance',
                                    ['id' => $parameters['params']['coursemodule']],
                                    MUST_EXIST
                                ),
                            ],
                        ],
                    ],
                    $parameters['expectedexception'],
                ];
            } else {
                $return[$testkey] = [
                    $parameters['dbstate'],
                    $parameters['params'],
                    [],
                    $parameters['expectedexception'],
                ];
            }
        }

        return $return;
    }

    /**
     * Test \local_o365\webservices\read_onenoteassignment::assignment_read().
     *
     * @covers \local_o365\webservices\read_onenoteassignment::assignment_read
     */
    public function test_assignment_read(): void {
        $dataarr = $this->get_assignment_read_testcases();
        $this->run_testcases($dataarr, function (array $data): void {
            $actualreturn = read_onenoteassignment::assignment_read($data[self::PARAMS]);

            $this->assertEquals($data[self::EXPECTEDRETURN], $actualreturn);
        });
    }

    /**
     * Test assignment_read_returns method.
     *
     * @covers \local_o365\webservices\read_onenoteassignment::assignment_read_returns
     */
    public function test_assignment_read_returns(): void {
        $schema = read_onenoteassignment::assignment_read_returns();
        $this->assertTrue($schema instanceof external_single_structure);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Test assignment_update_parameters method.
     *
     * @covers \local_o365\webservices\update_onenoteassignment::assignment_update_parameters
     */
    public function test_assignment_update_parameters(): void {
        $schema = update_onenoteassignment::assignment_update_parameters();
        $this->assertTrue($schema instanceof external_function_parameters);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Get the test cases for test_assignment_update.
     *
     * @return array Array of test parameters.
     */
    public static function get_assignment_update_testcases(): array {
        global $DB;
        $generaltests = static::get_general_assignment_data_tests();
        $return = [];

        foreach ($generaltests as $testkey => $parameters) {
            if ($testkey === 'All data correct, assignment is a OneNote assignment') {
                $data = [
                    'name' => 'New OneNote Assignment',
                    'intro' => 'This is a test assignment',
                    'newintro' => 'This is a new test assignment',
                    'section' => $DB->get_field(
                        'course_sections',
                        'id',
                        ['course' => $parameters['params']['course'], 'section' => 1]
                    ),
                    'newsection' => $DB->get_field(
                        'course_sections',
                        'id',
                        ['course' => $parameters['params']['course'], 'section' => 0]
                    ),
                    'visible' => 1,
                    'newvisible' => 0,
                ];

                $return['Update name'] = [
                    $parameters['dbstate'],
                    array_merge($parameters['params'], ['name' => 'New OneNote Assignment']),
                    [
                        'data' => [
                            [
                                'course' => $parameters['params']['course'],
                                'coursemodule' => (string) $parameters['params']['coursemodule'],
                                'name' => $data['name'],
                                'intro' => $data['intro'],
                                'section' => $data['section'],
                                'visible' => $data['visible'],
                            ],
                        ],
                    ],
                    $parameters['expectedexception'],
                ];

                $return['Update intro'] = [
                    $parameters['dbstate'],
                    array_merge($parameters['params'], ['intro' => 'This is a new test assignment']),
                    [
                        'data' => [
                            [
                                'course' => $parameters['params']['course'],
                                'coursemodule' => (string) $parameters['params']['coursemodule'],
                                'name' => $data['name'],
                                'intro' => $data['newintro'],
                                'section' => $data['section'],
                                'visible' => $data['visible'],
                            ],
                        ],
                    ],
                    $parameters['expectedexception'],
                ];

                $return['Update section to nonexistent section'] = [
                    $parameters['dbstate'],
                    array_merge($parameters['params'], ['section' => '-1']),
                    [
                        'data' => [
                            [
                                'course' => $parameters['params']['course'],
                                'coursemodule' => (string) $parameters['params']['coursemodule'],
                                'name' => $data['name'],
                                'intro' => $data['newintro'],
                                'section' => $data['section'],
                                'visible' => $data['visible'],
                            ],
                        ],
                    ],
                    ['local_o365\webservices\exception\sectionnotfound'],
                ];

                $return['Update section'] = [
                    $parameters['dbstate'],
                    array_merge($parameters['params'], ['section' => $data['newsection']]),
                    [
                        'data' => [
                            [
                                'course' => $parameters['params']['course'],
                                'coursemodule' => (string) $parameters['params']['coursemodule'],
                                'name' => $data['name'],
                                'intro' => $data['newintro'],
                                'section' => $data['newsection'],
                                'visible' => $data['visible'],
                            ],
                        ],
                    ],
                    $parameters['expectedexception'],
                ];

                $return['Update visible'] = [
                    $parameters['dbstate'],
                    array_merge($parameters['params'], ['visible' => $data['newvisible']]),
                    [
                        'data' => [
                            [
                                'course' => $parameters['params']['course'],
                                'coursemodule' => (string) $parameters['params']['coursemodule'],
                                'name' => $data['name'],
                                'intro' => $data['newintro'],
                                'section' => $data['newsection'],
                                'visible' => $data['newvisible'],
                            ],
                        ],
                    ],
                    $parameters['expectedexception'],
                ];
            }
        }

        return $return;
    }

    /**
     * Test \local_o365\webservices\update_onenoteassignment::assignment_update().
     *
     * @covers \local_o365\webservices\update_onenoteassignment::assignment_update
     */
    public function test_assignment_update(): void {
        $dataarr = $this->get_assignment_update_testcases();
        $this->run_testcases($dataarr, function (array $data): void {
            $actualreturn = update_onenoteassignment::assignment_update($data[self::PARAMS]);

            $this->assertEquals($data[self::EXPECTEDRETURN]['data'][0]['name'], $actualreturn['data'][0]['name']);
            $this->assertEquals($data[self::EXPECTEDRETURN]['data'][0]['intro'], $actualreturn['data'][0]['intro']);
            $this->assertEquals($data[self::EXPECTEDRETURN]['data'][0]['visible'], $actualreturn['data'][0]['visible']);
            $this->assertEquals($data[self::EXPECTEDRETURN]['data'][0]['section'], $actualreturn['data'][0]['section']);
        });
    }

    /**
     * Test assignment_update_returns method.
     *
     * @covers \local_o365\webservices\update_onenoteassignment::assignment_update_returns
     */
    public function test_assignment_update_returns(): void {
        $schema = update_onenoteassignment::assignment_update_returns();
        $this->assertTrue($schema instanceof external_single_structure);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Test assignment_delete_parameters method.
     *
     * @covers \local_o365\webservices\delete_onenoteassignment::assignment_delete_parameters
     */
    public function test_assignment_delete_parameters(): void {
        $schema = delete_onenoteassignment::assignment_delete_parameters();
        $this->assertTrue($schema instanceof external_function_parameters);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Get the test cases for test_assignment_delete.
     *
     * @return array Array of test parameters.
     */
    public static function get_assignment_delete_testcases(): array {
        $generaltests = static::get_general_assignment_data_tests();
        $return = [];

        foreach ($generaltests as $testkey => $parameters) {
            // Test only deleting the OneNote assignment.
            if ($testkey === 'All data correct, assignment is a OneNote assignment') {
                $return[$testkey] = [
                    $parameters['dbstate'],
                    $parameters['params'],
                    ['result' => true],
                    $parameters['expectedexception'],
                ];
            }
        }

        return $return;
    }

    /**
     * Test \local_o365\webservices\delete_onenoteassignment::assignment_delete().
     *
     * @covers \local_o365\webservices\delete_onenoteassignment::assignment_delete
     */
    public function test_assignment_delete(): void {
        $dataarr = $this->get_assignment_delete_testcases();
        $this->run_testcases($dataarr, function (array $data): void {
            $actualreturn = delete_onenoteassignment::assignment_delete($data[self::PARAMS]);

            $this->assertEquals($data[self::EXPECTEDRETURN], $actualreturn);
        });
    }

    /**
     * Test assignment_delete_returns method.
     *
     * @covers \local_o365\webservices\delete_onenoteassignment::assignment_delete_returns
     */
    public function test_assignment_delete_returns(): void {
        $schema = delete_onenoteassignment::assignment_delete_returns();
        $this->assertTrue($schema instanceof external_single_structure);
        $this->assertArrayHasKey('result', $schema->keys);
    }
}
