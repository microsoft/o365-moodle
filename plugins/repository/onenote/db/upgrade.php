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
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_repository_onenote_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014101601) {
    
        // Define table repository_onenote to be created.
        $table = new xmldb_table('repository_onenote');
    
        // Adding fields to table repository_onenote.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
    
        // Adding keys to table repository_onenote.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
    
        // Conditionally launch create table for repository_onenote.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
    
        // Define table course_user_ext to be created.
        $table = new xmldb_table('course_user_ext');
    
        // Adding fields to table course_user_ext.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('user_id', XMLDB_TYPE_INTEGER, '5', null, null, null, null);
        $table->add_field('course_id', XMLDB_TYPE_INTEGER, '5', null, null, null, null);
        $table->add_field('section_id', XMLDB_TYPE_CHAR, '100', null, null, null, null);
    
        // Adding keys to table course_user_ext.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
    
        // create table for course_user_ext.
        if ($dbman->table_exists($table))
            $dbman->drop_table($table);

        $dbman->create_table($table);
    
        // Define table assign_user_ext to be created.
        $table = new xmldb_table('assign_user_ext');
    
        // Adding fields to table course_user_ext.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('user_id', XMLDB_TYPE_INTEGER, '5', null, null, null, null);
        $table->add_field('assign_id', XMLDB_TYPE_INTEGER, '5', null, null, null, null);
        $table->add_field('submission_student_page_id', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('feedback_student_page_id', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('submission_teacher_page_id', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('feedback_teacher_page_id', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        
        // Adding keys to table course_user_ext.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
    
        // create table for assign_user_ext.
        if ($dbman->table_exists($table))
            $dbman->drop_table($table);
            
        $dbman->create_table($table);
    
        // Onenote savepoint reached.
        upgrade_plugin_savepoint(true, 2014101601, 'repository', 'onenote');
    }
    
    // Moodle v2.3.0 release upgrade line
    // Put any upgrade step following this

    // Moodle v2.4.0 release upgrade line
    // Put any upgrade step following this


    // Moodle v2.5.0 release upgrade line.
    // Put any upgrade step following this.


    // Moodle v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Moodle v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
