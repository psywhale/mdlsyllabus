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

//require_login($course, true, NULL);

$PAGE->set_url('/mod/syllabus/public-view.php', array('course'=>$course));

$PAGE->set_title('Course Syllabus');

$PAGE->set_pagelayout('course');

$PAGE->set_heading('Course Syllabus');

echo $OUTPUT->header();


$result = $DB->get_records_sql("SELECT {master_syllabus}.*, {course_syllabus}.* FROM {master_syllabus} JOIN {course_syllabus} ON {master_syllabus}.id = {course_syllabus}.master_syllabus_id JOIN {syllabus} ON {course_syllabus}.id = {syllabus}.selected_course_syllabus JOIN {course_modules} ON {syllabus}.id = {course_modules}.instance WHERE {course_modules}.id = ?", array($instance_id));

foreach($result as $key => $value) {
    $syllabus = $value;
}
// Show the Syllabus
?>
    <div>
        <p style="text-align:center"><strong><?php echo strtoupper($syllabus->heading); ?><br />DEPARTMENT OF <?php echo strtoupper($syllabus->department); ?></strong></p>
        <p style="text-align:center"><strong>COURSE SYLLABUS</strong></p>
        <table style="border:none;width:100%">
            <tr>
                <td style="width:33%"><strong>COURSE NUMBER</strong></td>
                <td><?php echo strtoupper($syllabus->course_number); ?></td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:33%"><strong>COURSE TITLE</strong></td>
                <td><?php echo strtoupper($syllabus->title); ?></td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:33%"><strong>YEAR</strong></td>
                <td><?php echo $syllabus->year; ?></td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:33%"><strong>SEMESTER</strong></td>
                <td><?php echo $syllabus->semester; ?></td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:33%"><strong>SECTION</strong></td>
                <td><?php echo $syllabus->section_no; ?></td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:33%"><strong>INSTRUCTOR NAME</strong></td>
                <td><?php echo $syllabus->instructor_name; ?></td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:33%"><strong>INSTRUCTOR EMAIL</strong></td>
                <td><?php echo $syllabus->instructor_email; ?></td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:33%"><strong>INSTRUCTOR PHONE</strong></td>
                <td><?php echo $syllabus->instructor_phone; ?></td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:33%"><strong>CREDIT HOURS</strong></td>
                <td><?php echo strtoupper($syllabus->credits); ?></td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:33%"><strong>PREREQUISITES</strong></td>
                <td><?php echo strtoupper($syllabus->prerequisites); ?></td>
            </tr>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="width:33%"><strong>COREQUISITES</strong></td>
                <td><?php echo $syllabus->corequisites; ?></td>
            </tr>
        </table>    
        <p><strong>CATALOG DESCRIPTION</strong></p>
        <p><?php echo $syllabus->catalog_desc; ?></p>
        <p><strong>TEXTBOOK</strong></p>
        <p><?php echo $syllabus->textbook; ?></p>
        <p><strong>LEARNING OUTCOMES</strong></p>
        <p><?php echo $syllabus->learning_outcomes; ?></p>
        <p><strong>COURSE REQUIREMENTS</strong></p>
        <p><?php echo $syllabus->course_requirements; ?></p>
        <p><strong>ATTENDANCE POLICY</strong></p>
        <p><?php echo $syllabus->attendance_policy; ?></p>
        <p><strong>ACADEMIC ETHICS</strong></p>
        <p><?php echo $syllabus->academic_ethics; ?></p>
        <p><strong>COURSE COMPETENCIES</strong></p>
        <p><?php echo $syllabus->course_competencies; ?></p>
        <p><strong>ASSESSMENT</strong></p>
        <p><?php echo $syllabus->assessment; ?></p>
        <p><strong>SUPPLIES</strong></p>
        <p><?php echo $syllabus->supplies; ?></p>
        <p><strong>ADDITIONAL INFO</strong></p>
        <p><?php echo $syllabus->additional_info; ?></p>
        <p><strong>ADA STATEMENT</strong></p>
        <p><?php echo $syllabus->ada_statement; ?></p>
    </div>
<?php echo $OUTPUT->footer(); ?>