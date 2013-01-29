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
 * Add syllabus form
 *
 * @package    mod
 * @subpackage syllabus
 * @copyright  2006 Jamie Pratt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once ($CFG->dirroot.'/course/moodleform_mod.php');

$PAGE->requires->js('/mod/syllabus/jquery.js', true);

$PAGE->requires->js('/mod/syllabus/validator.js', true);

$PAGE->requires->js('/mod/syllabus/createinstance.js', true);



class mod_syllabus_mod_form extends moodleform_mod {

    function definition() {
        global $DB, $CFG;
        $course = $_GET['course'];
        //select id from modules where name = 'syllabus'
        $result = $DB->get_records_sql("SELECT id FROM {modules} WHERE name = ?", array('syllabus'));
        foreach($result as $key => $value) {
            $module = $key;
        }
        // select module from course_modules where course = $course and module = $module
            $result = $DB->get_records_sql("SELECT id,module FROM {course_modules} WHERE course = ? AND module = ?", array($course, $module));
        if(!empty($result) && !isset($_GET['update'])) {
            $url = $CFG->wwwroot.'/course/view.php?id='.$course;
            echo "Redirecting back to the course...";
            echo "<script type=\"text/javascript\"> alert('A syllabus resource already exists for this course.'); window.location.replace('";
            echo $url;
            echo "');</script>";
            
                     
        } else {
            
            if(isset($_GET['update'])) {
                $id = $_GET['update'];
                $result = $DB->get_records_sql("SELECT course FROM {course_modules} WHERE id = ?",array($id));
                foreach ($result as $key => $value) {
                $course = $key;
                }
                $url = $CFG->wwwroot.'/mod/syllabus/edit.php?course='.$course.'&instance_id='.$id;
                redirect($url);

            }  else {
                    $mform = $this->_form;

            //$this->add_intro_editor(true, get_string("syllabustext', 'syllabus'));
            $mform->addElement('html', '<p>Adding a syllabus instance to the course...</p>');

            $this->standard_coursemodule_elements();

    //-------------------------------------------------------------------------------
    // buttons
            $this->add_action_buttons(true, false, null);

            }
        } 
    }
}
