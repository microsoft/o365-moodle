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

require_once($CFG->dirroot.'/lib/externallib.php');

/**
 * Tests \local_o365\webservices\utils
 *
 * @group local_o365
 * @group office365
 */
class local_o365_webservices_onenoteassignment_testcase extends \advanced_testcase {

    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test assignment_create_parameters method.
     */
    public function test_assignment_create_parameters() {
        $schema = \local_o365\webservices\create_onenoteassignment::assignment_create_parameters();
        $this->assertTrue($schema instanceof \external_function_parameters);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Dataprovider for test_assignment_create.
     *
     * @return array Array of test parameters.
     */
    public function dataprovider_create_assignment() {
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
     */
    public function test_assignment_create($params, $expectedreturn) {
        global $DB;
        $course = $this->getDataGenerator()->create_course();

        if ($params['course'] === '[[courseid]]') {
            $params['course'] = (int)$course->id;
        }

        $this->setAdminUser();

        $actualreturn = \local_o365\webservices\create_onenoteassignment::assignment_create($params);
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
     */
    public function test_assignment_create_returns() {
        $schema = \local_o365\webservices\create_onenoteassignment::assignment_create_returns();
        $this->assertTrue($schema instanceof \external_single_structure);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Test assignment_read_parameters method.
     */
    public function test_assignment_read_parameters() {
        $schema = \local_o365\webservices\read_onenoteassignment::assignment_read_parameters();
        $this->assertTrue($schema instanceof \external_function_parameters);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Returns a list of general data existence tests to run against any function that looks up assignment data.
     *
     * @return [type] [description]
     */
    public function get_general_assignment_data_tests() {
        return [
            'Course not found (no course)' => [
                'dbstate' => [],
                'params' => [
                    'coursemodule' => 60,
                    'course' => 2,
                ],
                'expectedexception' => ['dml_missing_record_exception', 'Can not find data record in database table course'],
            ],
            'Course not found (different id)' => [
                'dbstate' => [
                    'course' => [
                        ['id'],
                        ['2'],
                    ],
                ],
                'params' => [
                    'coursemodule' => 60,
                    'course' => 3,
                ],
                'expectedexception' => ['dml_missing_record_exception', 'Can not find data record in database table course'],
            ],
            'Module not found (no record)' => [
                'dbstate' => [
                    'course' => [
                        ['id'],
                        ['2'],
                    ],
                ],
                'params' => [
                    'coursemodule' => 60,
                    'course' => 2,
                ],
                'expectedexception' => ['local_o365\webservices\exception\modulenotfound'],
            ],
            'Module not found (different id)' => [
                'dbstate' => [
                    'course' => [
                        ['id'],
                        ['2'],
                    ],
                    'course_modules' => [
                        ['id', 'course', 'module'],
                        ['10', '2', '1'],
                    ],
                ],
                'params' => [
                    'coursemodule' => 60,
                    'course' => 2,
                ],
                'expectedexception' => ['local_o365\webservices\exception\modulenotfound'],
            ],
            'Assignment record not found (no record)' => [
                'dbstate' => [
                    'course' => [
                        ['id'],
                        ['2'],
                    ],
                    'course_modules' => [
                        ['id', 'course', 'module'],
                        ['60', '2', '1'],
                    ],
                ],
                'params' => [
                    'coursemodule' => 60,
                    'course' => 2,
                ],
                'expectedexception' => ['local_o365\webservices\exception\assignnotfound'],
            ],
            'Assignment record not found (no record for that course_module record)' => [
                'dbstate' => [
                    'course' => [
                        ['id'],
                        ['2'],
                    ],
                    'course_modules' => [
                        ['id', 'course', 'module', 'instance'],
                        ['59', '2', '1', '70'],
                        ['61', '2', '1', '71'],
                    ],
                    'assign' => [
                        ['id', 'course', 'name', 'intro'],
                        ['70', '2', 'OneNote Assignment', 'This is a test assignment'],
                    ],
                ],
                'params' => [
                    'coursemodule' => 61,
                    'course' => 2,
                ],
                'expectedexception' => ['local_o365\webservices\exception\assignnotfound'],
            ],
            'All data correct, assignment not a OneNote assignment' => [
                'dbstate' => [
                    'course' => [
                        ['id'],
                        ['2'],
                    ],
                    'course_modules' => [
                        ['id', 'course', 'module', 'instance'],
                        ['59', '2', '1', '70'],
                        ['61', '2', '1', '71'],
                    ],
                    'assign' => [
                        ['id', 'course', 'name', 'intro'],
                        ['70', '2', 'OneNote Assignment', 'This is a test assignment'],
                    ],
                ],
                'params' => [
                    'coursemodule' => 59,
                    'course' => 2,
                ],
                'expectedexception' => ['local_o365\webservices\exception\invalidassignment'],
            ],
            'All data correct, assignment is a OneNote assignment' => [
                'dbstate' => [
                    'course' => [
                        ['id'],
                        ['2'],
                    ],
                    'course_modules' => [
                        ['id', 'course', 'module', 'instance', 'section'],
                        ['59', '2', '1', '70', '40'],
                        ['61', '2', '1', '71', '40'],
                    ],
                    'course_sections' => [
                        ['id', 'course', 'section', 'sequence'],
                        ['40', '2', '5', '59'],
                        ['41', '2', '6', ''],
                    ],
                    'assign' => [
                        ['id', 'course', 'name', 'intro'],
                        ['70', '2', 'OneNote Assignment', 'This is a test assignment'],
                    ],
                    'assign_plugin_config' => [
                        ['id', 'assignment', 'plugin', 'subtype', 'name', 'value'],
                        ['100', '70', 'onenote', 'assignsubmission', 'enabled', '1'],
                    ],
                ],
                'params' => [
                    'coursemodule' => 59,
                    'course' => 2,
                ],
                'expectedexception' => null,
            ],
        ];
    }

    /**
     * Dataprovider for test_assignment_read.
     *
     * @return array Array of test parameters.
     */
    public function dataprovider_assignment_read() {
        $generaltests = $this->get_general_assignment_data_tests();
        $return = [];

        foreach ($generaltests as $testkey => $parameters) {
            if ($testkey === 'All data correct, assignment is a OneNote assignment') {
                $return[$testkey] = [
                    $parameters['dbstate'],
                    $parameters['params'],
                    [
                        'data' => [
                            [
                                'course' => '2',
                                'coursemodule' => '59',
                                'name' => 'OneNote Assignment',
                                'intro' => 'This is a test assignment',
                                'section' => '40',
                                'visible' => '1',
                                'instance' => '70',
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

        // Additional success test with slightly different parameters.
        $return['All data correct, assignment is a OneNote assignment 2'] = [
            [
                'course' => [
                    ['id'],
                    ['2'],
                ],
                'course_modules' => [
                    ['id', 'course', 'module', 'instance', 'section', 'visible'],
                    ['59', '2', '1', '70', '2', '1'],
                    ['61', '2', '1', '71', '2', '1'],
                ],
                'assign' => [
                    ['id', 'course', 'name', 'intro'],
                    ['71', '2', 'OneNote Assignment', 'This is a test assignment'],
                ],
                'assign_plugin_config' => [
                    ['id', 'assignment', 'plugin', 'subtype', 'name', 'value'],
                    ['100', '71', 'onenote', 'assignsubmission', 'enabled', '1'],
                ],
            ],
            [
                'coursemodule' => 61,
                'course' => 2,
            ],
            [
                'data' => [
                    [
                        'course' => '2',
                        'coursemodule' => '61',
                        'name' => 'OneNote Assignment',
                        'intro' => 'This is a test assignment',
                        'section' => '2',
                        'visible' => '1',
                        'instance' => '71',
                    ],
                ],
            ],
            null,
        ];
        return $return;
    }

    /**
     * Test \local_o365\webservices\read_onenoteassignment::assignment_read().
     *
     * @dataProvider dataprovider_assignment_read
     * @param array $dbstate Array of tables and records to create before test.
     * @param array $params Webservices parameters.
     * @param array $expectedreturn The expected service return.
     * @param array|null $expectedexception If an exception is expected, the expected exception, otherwise null.
     *                                 Index 0 is class name.
     *                                 Index 1 is the exception message.
     */
    public function test_assignment_read($dbstate, $params, $expectedreturn, $expectedexception) {
        global $DB;

        if (!empty($dbstate)) {
            $dataset = $this->createArrayDataSet($dbstate);
            $this->loadDataSet($dataset);
        }

        if (!empty($expectedexception)) {
            if (isset($expectedexception[1])) {
                $this->setExpectedException($expectedexception[0], $expectedexception[1]);
            } else {
                $this->setExpectedException($expectedexception[0]);
            }
        }

        $this->setAdminUser();

        $actualreturn = \local_o365\webservices\read_onenoteassignment::assignment_read($params);
        $this->assertEquals($expectedreturn, $actualreturn);
    }

    /**
     * Test assignment_read_returns method.
     */
    public function test_assignment_read_returns() {
        $schema = \local_o365\webservices\read_onenoteassignment::assignment_read_returns();
        $this->assertTrue($schema instanceof \external_single_structure);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Test assignment_update_parameters method.
     */
    public function test_assignment_update_parameters() {
        $schema = \local_o365\webservices\update_onenoteassignment::assignment_update_parameters();
        $this->assertTrue($schema instanceof \external_function_parameters);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Dataprovider for test_assignment_update.
     *
     * @return array Array of test parameters.
     */
    public function dataprovider_assignment_update() {
        $generaltests = $this->get_general_assignment_data_tests();
        $return = [];

        foreach ($generaltests as $testkey => $parameters) {
            if ($testkey === 'All data correct, assignment is a OneNote assignment') {
                $return[$testkey] = [
                    $parameters['dbstate'],
                    $parameters['params'],
                    [
                        'data' => [
                            [
                                'course' => '2',
                                'coursemodule' => '59',
                                'name' => 'OneNote Assignment',
                                'intro' => 'This is a test assignment',
                                'section' => '40',
                                'visible' => '1',
                                'instance' => '70',
                            ],
                        ],
                    ],
                    $parameters['expectedexception'],
                ];

                $return['Update name'] = [
                    $parameters['dbstate'],
                    array_merge($parameters['params'], ['name' => 'New OneNote Assignment']),
                    [
                        'data' => [
                            [
                                'course' => '2',
                                'coursemodule' => '59',
                                'name' => 'New OneNote Assignment',
                                'intro' => 'This is a test assignment',
                                'section' => '40',
                                'visible' => '1',
                                'instance' => '70',
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
                                'course' => '2',
                                'coursemodule' => '59',
                                'name' => 'OneNote Assignment',
                                'intro' => 'This is a new test assignment',
                                'section' => '40',
                                'visible' => '1',
                                'instance' => '70',
                            ],
                        ],
                    ],
                    $parameters['expectedexception'],
                ];

                $return['Update section to nonexistent section'] = [
                    $parameters['dbstate'],
                    array_merge($parameters['params'], ['section' => 48]),
                    [
                        'data' => [
                            [
                                'course' => '2',
                                'coursemodule' => '59',
                                'name' => 'OneNote Assignment',
                                'intro' => 'This is a test assignment',
                                'section' => '41',
                                'visible' => '1',
                                'instance' => '70',
                            ],
                        ],
                    ],
                    ['local_o365\webservices\exception\sectionnotfound'],
                ];

                $return['Update section'] = [
                    $parameters['dbstate'],
                    array_merge($parameters['params'], ['section' => 41]),
                    [
                        'data' => [
                            [
                                'course' => '2',
                                'coursemodule' => '59',
                                'name' => 'OneNote Assignment',
                                'intro' => 'This is a test assignment',
                                'section' => '41',
                                'visible' => '1',
                                'instance' => '70',
                            ],
                        ],
                    ],
                    $parameters['expectedexception'],
                ];

                $return['Update visible'] = [
                    $parameters['dbstate'],
                    array_merge($parameters['params'], ['visible' => 0]),
                    [
                        'data' => [
                            [
                                'course' => '2',
                                'coursemodule' => '59',
                                'name' => 'OneNote Assignment',
                                'intro' => 'This is a test assignment',
                                'section' => '40',
                                'visible' => '0',
                                'instance' => '70',
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
     * Test \local_o365\webservices\update_onenoteassignment::assignment_update().
     *
     * @dataProvider dataprovider_assignment_update
     * @param array $dbstate Array of tables and records to create before test.
     * @param array $params Webservices parameters.
     * @param array $expectedreturn The expected service return.
     * @param array|null $expectedexception If an exception is expected, the expected exception, otherwise null.
     *                                 Index 0 is class name.
     *                                 Index 1 is the exception message.
     */
    public function test_assignment_update($dbstate, $params, $expectedreturn, $expectedexception) {
        if (!empty($dbstate)) {
            $dataset = $this->createArrayDataSet($dbstate);
            $this->loadDataSet($dataset);
        }

        if (!empty($expectedexception)) {
            if (isset($expectedexception[1])) {
                $this->setExpectedException($expectedexception[0], $expectedexception[1]);
            } else {
                $this->setExpectedException($expectedexception[0]);
            }
        }

        $this->setAdminUser();

        $actualreturn = \local_o365\webservices\update_onenoteassignment::assignment_update($params);

        $this->assertEquals($expectedreturn, $actualreturn);
    }

    /**
     * Test assignment_update_returns method.
     */
    public function test_assignment_update_returns() {
        $schema = \local_o365\webservices\update_onenoteassignment::assignment_update_returns();
        $this->assertTrue($schema instanceof \external_single_structure);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Test assignment_delete_parameters method.
     */
    public function test_assignment_delete_parameters() {
        $schema = \local_o365\webservices\delete_onenoteassignment::assignment_delete_parameters();
        $this->assertTrue($schema instanceof \external_function_parameters);
        $this->assertArrayHasKey('data', $schema->keys);
    }

    /**
     * Dataprovider for test_assignment_delete.
     *
     * @return array Array of test parameters.
     */
    public function dataprovider_assignment_delete() {
        $generaltests = $this->get_general_assignment_data_tests();
        $return = [];

        foreach ($generaltests as $testkey => $parameters) {
            if ($testkey === 'All data correct, assignment is a OneNote assignment') {
                $return[$testkey] = [
                    $parameters['dbstate'],
                    $parameters['params'],
                    ['result' => true],
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
     * Test \local_o365\webservices\delete_onenoteassignment::assignment_delete().
     *
     * @dataProvider dataprovider_assignment_delete
     * @param array $dbstate Array of tables and records to create before test.
     * @param array $params Webservices parameters.
     * @param array $expectedreturn The expected service return.
     * @param array|null $expectedexception If an exception is expected, the expected exception, otherwise null.
     *                                 Index 0 is class name.
     *                                 Index 1 is the exception message.
     */
    public function test_assignment_delete($dbstate, $params, $expectedreturn, $expectedexception) {
        if (!empty($dbstate)) {
            $dataset = $this->createArrayDataSet($dbstate);
            $this->loadDataSet($dataset);
        }

        if (!empty($expectedexception)) {
            if (isset($expectedexception[1])) {
                $this->setExpectedException($expectedexception[0], $expectedexception[1]);
            } else {
                $this->setExpectedException($expectedexception[0]);
            }
        }

        $this->setAdminUser();

        $actualreturn = \local_o365\webservices\delete_onenoteassignment::assignment_delete($params);

        $this->assertEquals($expectedreturn, $actualreturn);
    }

    /**
     * Test assignment_delete_returns method.
     */
    public function test_assignment_delete_returns() {
        $schema = \local_o365\webservices\delete_onenoteassignment::assignment_delete_returns();
        $this->assertTrue($schema instanceof \external_single_structure);
        $this->assertArrayHasKey('result', $schema->keys);
    }
}
