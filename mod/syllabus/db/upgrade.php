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
 * Syllabus module upgrade
 *
 * @package    mod
 * @subpackage syllabus
 * @copyright  2006 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This file keeps track of upgrades to
// the syllabus module
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installation to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the methods of database_manager class
//
// Please do not forget to use upgrade_set_timeout()
// before any action that may take longer time to finish.

defined('MOODLE_INTERNAL') || die;

function xmldb_syllabus_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

//===== 1.9.0 upgrade line ======//

    if ($oldversion < 2009042200) {

    /// Rename field content on table syllabus to intro
        $table = new xmldb_table('syllabus');
        $field = new xmldb_field('content', XMLDB_TYPE_TEXT, 'small', null, XMLDB_NOTNULL, null, null, 'name');

    /// Launch rename field content
        $dbman->rename_field($table, $field, 'intro');

    /// syllabus savepoint reached
        upgrade_mod_savepoint(true, 2009042200, 'syllabus');
    }

    if ($oldversion < 2009042201) {

    /// Define field introformat to be added to syllabus
        $table = new xmldb_table('syllabus');
        $field = new xmldb_field('introformat', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, null, null, '0', 'intro');

    /// Launch add field introformat
        $dbman->add_field($table, $field);

        // all existing lables in 1.9 are in HTML format
        $DB->set_field('master_syllabus', 'introformat', FORMAT_HTML, array());

    /// syllabus savepoint reached
        upgrade_mod_savepoint(true, 2009042201, 'syllabus');
    }

    // Moodle v2.1.0 release upgrade line
    // Put any upgrade step following this

    // Moodle v2.2.0 release upgrade line
    // Put any upgrade step following this
     if ($oldversion < 2013012900) {

        // Define field year to be added to course_syllabus
        $table = new xmldb_table('course_syllabus');
        $field = new xmldb_field('year', XMLDB_TYPE_CHAR, '4', null, XMLDB_NOTNULL, null, null, 'master_syllabus_id');

        // Conditionally launch add field year
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        $table = new xmldb_table('course_syllabus');
        $field = new xmldb_field('semester', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'year');

        // Conditionally launch add field semester
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }


        // syllabus savepoint reached
        upgrade_mod_savepoint(true, 2013012900, 'syllabus');
    }
    
        if ($oldversion < 2013013000) {

        // Define field attendance_policy to be added to course_syllabus
        $table = new xmldb_table('course_syllabus');
        $field = new xmldb_field('attendance_policy', XMLDB_TYPE_TEXT, null, null, null, null, null, 'instance');

        // Conditionally launch add field attendance_policy
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        
        $table = new xmldb_table('course_syllabus');
        $field = new xmldb_field('assessment', XMLDB_TYPE_TEXT, null, null, null, null, null, 'attendance_policy');

        // Conditionally launch add field assessment
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // syllabus savepoint reached
        upgrade_mod_savepoint(true, 2013013000, 'syllabus');
       }
     if ($oldversion < 2013013001) {

        // Define field grading_policy to be added to course_syllabus
        $table = new xmldb_table('course_syllabus');
        $field = new xmldb_field('grading_policy', XMLDB_TYPE_TEXT, null, null, null, null, null, 'assessment');

        // Conditionally launch add field grading_policy
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // syllabus savepoint reached
        upgrade_mod_savepoint(true, 2013013001, 'syllabus');
    }
    
        if ($oldversion < 2013013002) {

        // Define field notify_method to be added to course_syllabus
        $table = new xmldb_table('course_syllabus');
        $field = new xmldb_field('notify_method', XMLDB_TYPE_TEXT, null, null, null, null, null, 'grading_policy');

        // Conditionally launch add field notify_method
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // syllabus savepoint reached
        upgrade_mod_savepoint(true, 2013013002, 'syllabus');
    }
    
    
        if ($oldversion < 2013021200) {

        // Define field notify_method to be added to course_syllabus
        $table = new xmldb_table('course_syllabus');
        $field = new xmldb_field('course_requirements', XMLDB_TYPE_TEXT, null, null, null, null, null, 'notify_method');

        // Conditionally launch add field notify_method
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // syllabus savepoint reached
        upgrade_mod_savepoint(true, 2013021200, 'syllabus');
    }

        if ($oldversion < 2013042300) {

        // Define field instructor_hours to be added to course_syllabus
        $table = new xmldb_table('course_syllabus');
        $field = new xmldb_field('instructor_hours', XMLDB_TYPE_TEXT, null, null, null, null, null, 'instructor_phone');

        // Conditionally launch add field instructor_hours
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // syllabus savepoint reached
        upgrade_mod_savepoint(true, 2013042300, 'syllabus');
    }
    
        if ($oldversion < 2013053100) {

        // Define field getting_started to be added to course_syllabus
        $table = new xmldb_table('course_syllabus');
        $field = new xmldb_field('getting_started', XMLDB_TYPE_TEXT, null, null, null, null, null, 'course_requirements');

        // Conditionally launch add field getting_started
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // syllabus savepoint reached
        upgrade_mod_savepoint(true, 2013053100, 'syllabus');
    }
     


    return true;
}


