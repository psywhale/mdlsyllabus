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
 * Syllabus module
 *
 * @package    mod
 * @subpackage syllabus
 * @copyright  2003 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once("lib.php");

global $DB, $CFG;
$instance_id = $_GET['id'];

$result = $DB->get_records_sql("SELECT course FROM {course_modules} WHERE id = ?", array($instance_id));
foreach ($result as $key => $value) {
    $course = $key;
}

require_login($course, true, NULL);

$PAGE->set_url('/mod/syllabus/view.php', array('course'=>$course));

$PAGE->set_title('Course Syllabus');

$PAGE->set_pagelayout('course');

$PAGE->set_heading('Course Syllabus');

echo $OUTPUT->header();


$result = $DB->get_records_sql("SELECT {master_syllabus}.*, {course_syllabus}.* FROM {master_syllabus} JOIN {course_syllabus} ON {master_syllabus}.id = {course_syllabus}.master_syllabus_id JOIN {syllabus} ON {course_syllabus}.id = {syllabus}.selected_course_syllabus JOIN {course_modules} ON {syllabus}.id = {course_modules}.instance WHERE {course_modules}.id = ?", array($instance_id));

foreach($result as $key => $value) {
    $syllabus = $value;
}
// Show the Syllabus

echo syllabus_print($syllabus);
?>
 
<?php echo $OUTPUT->footer(); ?>
