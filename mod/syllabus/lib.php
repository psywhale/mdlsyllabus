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
 * Library of functions and constants for module syllabus
 *
 * @package    mod
 * @subpackage syllabus
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/** SYLLABUS_MAX_NAME_LENGTH = 50 */
//define("SYLLABUS_MAX_NAME_LENGTH", 50);

// get course module id
function get_syllabus_coursemodule_from_id($modulename, $cmid, $courseid=0, $sectionnum=false, $strictness=IGNORE_MISSING) {
    global $DB;

    $params = array('cmid'=>$cmid);

    if (!$modulename) {
        if (!$modulename = $DB->get_field_sql("SELECT md.name
                                                 FROM {modules} md
                                                 JOIN {course_modules} cm ON cm.module = md.id
                                                WHERE cm.id = :cmid", $params, $strictness )) {
            return false;
        }
    }

    $params['modulename'] = $modulename;

    $courseselect = "";
    $sectionfield = "";
    $sectionjoin  = "";

    if ($courseid) {
        $courseselect = "AND cm.course = :courseid";
        $params['courseid'] = $courseid;
    }

    if ($sectionnum) {
        $sectionfield = ", cw.section AS sectionnum";
        $sectionjoin  = "LEFT JOIN {course_sections} cw ON cw.id = cm.section";
    }

    $sql = "SELECT cm.*, m.course_id, md.name AS modname $sectionfield
              FROM {course_modules} cm
                   JOIN {modules} md ON md.id = cm.module
                   JOIN {master_syllabus} m ON m.id = cm.instance
                   $sectionjoin
             WHERE cm.id = :cmid AND md.name = :modulename
                   $courseselect";

   return $DB->get_record_sql($sql, $params, $strictness);
}


/**
 * @uses SYLLABUS_MAX_NAME_LENGTH
 * @param object $syllabus
 * @return string
 */

function get_syllabus_name($syllabus) {
    $textlib = textlib_get_instance();
    $name = strip_tags(format_string($syllabus->title,true));
    if ($textlib->strlen($name) > SYLLABUS_MAX_NAME_LENGTH) {
        $name = $textlib->substr($name, 0, SYLLABUS_MAX_NAME_LENGTH)."...";
    }

    if (empty($name)) {
        // arbitrary name
        $name = get_string('modulename','syllabus');
    }
    
    return $name;
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @global object
 * @param object $syllabus
 * @return bool|int
 */
function syllabus_add_instance($syllabus) {
    global $DB, $CFG;

    $syllabus->name = 'Syllabus';
    $syllabus->timemodified = time();
    $syllabus->intro = 'syllabus';
    //$course = $syllabus->course;
    return $DB->insert_record("syllabus", $syllabus);
    //$url = $CFG->wwwroot.'/mod/syllabus/edit.php?course='.$course;
    //redirect($url);
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @global object
 * @param object $syllabus
 * @return bool
 */

function syllabus_update_instance($syllabus) {
    global $DB, $CFG;
    $instance_id = $_GET['update'];
    $url = $CFG->wwwroot.'/mod/syllabus/edit.php?instance_id='.$instance_id;
    redirect($url);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @global object
 * @param int $id
 * @return bool
 */

function syllabus_delete_instance($id) {
    global $DB;

    if (! $syllabus = $DB->get_record("syllabus", array("id"=>$id))) {
        return false;
    }

    $result = true;

    if (! $DB->delete_records("syllabus", array("id"=>$syllabus->id))) {
        $result = false;
    }

    return $result;
}

/**
 * Returns the users with data in one resource
 * (NONE, but must exist on EVERY mod !!)
 *
 * @todo: deprecated - to be deleted in 2.2
 *
 * @param int $syllabusid
 */

function syllabus_get_participants($syllabusid) {

    return false;
}

/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 * See get_array_of_activities() in course/lib.php
 *
 * @global object
 * @param object $coursemodule
 * @return object|null
 */
function syllabus_get_coursemodule_info($coursemodule) {
    
    $info = new stdClass();
    $info->name = 'Syllabus';
    $info->extra = 'This is the syllabus for this course.';
    return $info;
}

/*
function syllabus_get_coursemodule_info($coursemodule) {
    global $DB;

    if ($syllabus = $DB->get_record('master_syllabus', array('id'=>$coursemodule->instance), 'id, title')) {
        if (empty($syllabus->title)) {
            // label name missing, fix it
            $syllabus->title = "syllabus{$syllabus->id}";
            $DB->set_field('syllabus', 'name', $syllabus->title, array('id'=>$syllabus->id));
        }
        $info = new stdClass();
        // no filtering hre because this info is cached and filtered later
        $info->extra = format_module_intro('syllabus', $syllabus, $coursemodule->id, false);
        $info->name  = 'SYLLABUS';
        
        return $info;
    } else {
        return null;
    }
}
*/

/**
 * @return array
 */

function syllabus_get_view_actions() {
    return array();
}

/**
 * @return array
 */

function syllabus_get_post_actions() {
    return array();
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 *
 * @param object $data the data submitted from the reset course.
 * @return array status array
**/

function syllabus_reset_userdata($data) {
    return array();
}

/**
 * Returns all other caps used in module
 *
 * @return array
 */

function syllabus_get_extra_capabilities() {
    return array('moodle/site:accessallgroups');
}

/**
 * @uses FEATURE_IDNUMBER
 * @uses FEATURE_GROUPS
 * @uses FEATURE_GROUPINGS
 * @uses FEATURE_GROUPMEMBERSONLY
 * @uses FEATURE_MOD_INTRO
 * @uses FEATURE_COMPLETION_TRACKS_VIEWS
 * @uses FEATURE_GRADE_HAS_GRADE
 * @uses FEATURE_GRADE_OUTCOMES
 * @param string $feature FEATURE_xx constant for requested feature
 * @return bool|null True if module supports feature, false if not, null if doesn't know
 */
function syllabus_supports($feature) {
    switch($feature) {
        case FEATURE_IDNUMBER:                return false;
        case FEATURE_GROUPS:                  return false;
        case FEATURE_GROUPINGS:               return false;
        case FEATURE_GROUPMEMBERSONLY:        return true;
        case FEATURE_MOD_INTRO:               return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return false;
        case FEATURE_GRADE_HAS_GRADE:         return false;
        case FEATURE_GRADE_OUTCOMES:          return false;
        case FEATURE_MOD_ARCHETYPE:           return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_BACKUP_MOODLE2:          return true;
        case FEATURE_NO_VIEW_LINK:            return false;

        default: return null;
    }
}
/**
 * @return array
 * 
 */
function syllabus_get_semesters() {
   $semesters = array(
   'FALL',
   'FALL 1st 8 weeks',
   'FALL 2nd 8 weeks',
   'FALL 1st 4 weeks',
   'FALL 2nd 4 weeks',
   'FALL 3rd 4 weeks',
   'FALL 4th 4 weeks',
   'SPRING',
   'SPRING 1st 8 weeks',
   'SPRING 2nd 8 weeks',
   'SPRING 1st 4 weeks',
   'SPRING 2nd 4 weeks',
   'SPRING 3rd 4 weeks',
   'SPRING 4th 4 weeks',
   'SUMMER',
   'SUMMER 1st 4 weeks',
   'SUMMER 2nd 4 weeks'
   );
                            
return $semesters;
}