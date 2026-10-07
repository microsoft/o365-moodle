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
 * Test cases for the SDS sync scheduled task.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\sds;

use advanced_testcase;
use local_o365\feature\sds\task\sync;

/**
 * Tests \local_o365\feature\sds\task\sync.
 *
 * @group local_o365
 */
final class sync_test extends advanced_testcase {
    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Build an education class resource as returned by the API.
     *
     * @param string $id
     * @return array
     */
    private function get_school_class(string $id = 'class1'): array {
        return [
            'id' => $id,
            'mailNickname' => 'Section_' . $id,
            'displayName' => 'Display ' . $id,
            'classCode' => 'CODE-' . $id,
            'externalName' => 'External ' . $id,
        ];
    }

    /**
     * Data provider for test_get_class_course_names().
     *
     * @return array
     */
    public static function get_class_course_names_provider(): array {
        return [
            'defaults' => [null, null, [], ['Section_class1', 'Display class1']],
            'configured fields' => ['classCode', 'externalName', [], ['CODE-class1', 'External class1']],
            'short name same as mail nickname' => ['mailNickname', 'mailNickname', [], ['Section_class1', 'Section_class1']],
            'invalid fields fall back to defaults' => ['id', 'description', [], ['Section_class1', 'Display class1']],
            'empty short name falls back to mail nickname' => ['classCode', 'displayName', ['classCode' => ''],
                ['Section_class1', 'Display class1']],
            'blank short name falls back to mail nickname' => ['classCode', 'displayName', ['classCode' => '   '],
                ['Section_class1', 'Display class1']],
            'missing short name falls back to mail nickname' => ['externalName', 'displayName', ['externalName' => null],
                ['Section_class1', 'Display class1']],
            'empty full name falls back to display name' => ['classCode', 'externalName', ['externalName' => ''],
                ['CODE-class1', 'Display class1']],
            'values are trimmed' => ['classCode', 'externalName', ['classCode' => '  CODE  ', 'externalName' => ' Name '],
                ['CODE', 'Name']],
            'long short name is truncated' => ['classCode', 'displayName', ['classCode' => str_repeat('a', 120)],
                [str_repeat('a', 100), 'Display class1']],
        ];
    }

    /**
     * Test get_class_course_names() with different settings and class data.
     *
     * @dataProvider get_class_course_names_provider
     * @covers \local_o365\feature\sds\task\sync::get_class_course_names
     * @param string|null $shortnamefield
     * @param string|null $fullnamefield
     * @param array $overrides
     * @param array $expected
     */
    public function test_get_class_course_names(
        ?string $shortnamefield,
        ?string $fullnamefield,
        array $overrides,
        array $expected
    ): void {
        if ($shortnamefield !== null) {
            set_config('sdscourseshortnamefield', $shortnamefield, 'local_o365');
        }
        if ($fullnamefield !== null) {
            set_config('sdscoursefullnamefield', $fullnamefield, 'local_o365');
        }

        $schoolclass = array_merge($this->get_school_class(), $overrides);

        $this->assertSame($expected, sync::get_class_course_names($schoolclass));
    }

    /**
     * Test get_class_course_names() falls back to the mail nickname when the short name is used by another class's course.
     *
     * @covers \local_o365\feature\sds\task\sync::get_class_course_names
     */
    public function test_get_class_course_names_short_name_conflict(): void {
        global $DB;

        set_config('sdscourseshortnamefield', 'classCode', 'local_o365');

        // A course created for another class that already uses this class's class code as short name.
        $othercourse = $this->getDataGenerator()->create_course(['shortname' => 'CODE-class1']);
        $DB->insert_record('local_o365_objects', [
            'type' => 'sdssection',
            'subtype' => 'course',
            'objectid' => 'otherclass',
            'moodleid' => $othercourse->id,
            'o365name' => 'CODE-class1',
            'tenant' => '',
            'timecreated' => time(),
            'timemodified' => time(),
        ]);

        [$shortname] = sync::get_class_course_names($this->get_school_class());
        $this->assertSame('Section_class1', $shortname);
    }

    /**
     * Test get_class_course_names() keeps the short name when the existing course is linked to the same class.
     *
     * @covers \local_o365\feature\sds\task\sync::get_class_course_names
     */
    public function test_get_class_course_names_short_name_same_class(): void {
        global $DB;

        set_config('sdscourseshortnamefield', 'classCode', 'local_o365');

        $course = $this->getDataGenerator()->create_course(['shortname' => 'CODE-class1']);
        $DB->insert_record('local_o365_objects', [
            'type' => 'sdssection',
            'subtype' => 'course',
            'objectid' => 'class1',
            'moodleid' => $course->id,
            'o365name' => 'CODE-class1',
            'tenant' => '',
            'timecreated' => time(),
            'timemodified' => time(),
        ]);

        [$shortname] = sync::get_class_course_names($this->get_school_class());
        $this->assertSame('CODE-class1', $shortname);
    }

    /**
     * Test get_class_course_names() keeps the short name when the existing course is not linked to any SDS class,
     * so that the existing course can be re-linked.
     *
     * @covers \local_o365\feature\sds\task\sync::get_class_course_names
     */
    public function test_get_class_course_names_short_name_unlinked_course(): void {
        set_config('sdscourseshortnamefield', 'classCode', 'local_o365');

        $this->getDataGenerator()->create_course(['shortname' => 'CODE-class1']);

        [$shortname] = sync::get_class_course_names($this->get_school_class());
        $this->assertSame('CODE-class1', $shortname);
    }
}
