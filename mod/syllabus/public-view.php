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
       <div id="syllabus_container">
        <p style="text-align:center;"><img style="float:right; margin: -5px 0 0 -90px;" src="http://wosc.edu/img/seal90.png">
	<span style="font-size: 78%"><strong><?php echo strtoupper($syllabus->heading); ?></strong></span><br />
	<span style="font-size: 80%;"><strong>DEPARTMENT OF <?php echo strtoupper($syllabus->department); ?></strong></span><br />
	<span style="font-size: 155%;"><strong>COURSE SYLLABUS</strong><br />
	</p><br />
<!--         <p style="text-align:center"><strong>COURSE SYLLABUS</strong></p> -->
        <table style="border:none;width:100%" style="syllabus_table">
            <tr>
                <td style=""><strong>COURSE TITLE</strong></td>
                <td><?php echo strtoupper($syllabus->title); ?></td>
                <td style=""><strong>INSTRUCTOR NAME</strong></td>
                <td><?php echo $syllabus->instructor_name; ?></td>
            </tr>
            <tr>
                <td style=""><strong>SEMESTER</strong></td>
                <td><?php echo $syllabus->semester; ?> <?php echo $syllabus->year; ?></td>
                <td style=""><strong>INSTRUCTOR EMAIL</strong></td>
                <td><a href="mailto:<?php echo $syllabus->instructor_email; ?>?subject=Question about the <?php echo $syllabus->section_no; ?>: <?php echo strtoupper($syllabus->title); ?> Syllabus...&body=Course Title:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($syllabus->title); ?>%0D%0ACourse Date:&nbsp;&nbsp;&nbsp;<?php echo $syllabus->semester; ?> <?php echo $syllabus->year; ?>%0D%0ACourse #:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($syllabus->course_number); ?>%0D%0A%0D%0A%0D%0A - Insert Question Here - %0D%0A" target="_blank"><?php echo $syllabus->instructor_email; ?></a></td>
            </tr>
            <tr>
                <td style=""><strong>COURSE NUMBER</strong></td>
                <td><?php echo strtoupper($syllabus->course_number); ?></td>
                <td style=""><strong>INSTRUCTOR PHONE</strong></td>
                <td><?php echo $syllabus->instructor_phone; ?></td>
            </tr>
            <tr>
                <td style=""><strong>SECTION NUMBER</strong></td>
                <td><?php echo $syllabus->section_no; ?></td>
                <td style=""><strong>CREDIT HOURS</strong></td>
                <td><?php echo strtoupper($syllabus->credits); ?></td>
            </tr>
        </table>   
<hr style="color: #555 !important;" > 
		<div style="margin-left: 8px;"> <!-- START <p> left margin -->
        <strong>PREREQUISITES</strong><?php echo strtoupper($syllabus->prerequisites); ?>
        <strong>COREQUISITES</strong><?php echo $syllabus->corequisites; ?>
        <strong>CATALOG DESCRIPTION</strong><?php echo $syllabus->catalog_desc; ?>
        <strong>TEXTBOOK</strong><?php echo $syllabus->textbook; ?>
        <strong>SUPPLIES</strong><?php echo $syllabus->supplies; ?>
        <strong>LEARNING OUTCOMES</strong><?php echo $syllabus->learning_outcomes; ?>
        <strong>COURSE REQUIREMENTS</strong><?php echo $syllabus->course_requirements; ?>
        <strong>ATTENDANCE POLICY</strong><?php echo $syllabus->attendance_policy; ?>
        <strong>ACADEMIC ETHICS</strong><?php echo $syllabus->academic_ethics; ?>
        <strong>COURSE COMPETENCIES</strong><?php echo $syllabus->course_competencies; ?>
        <strong>ASSESSMENT</strong><?php echo $syllabus->assessment; ?>
        <strong>ADDITIONAL INFO</strong><?php echo $syllabus->additional_info; ?>
        <strong>ADA STATEMENT</strong><?php echo $syllabus->ada_statement; ?>
		</div> <!-- END <p> left margin -->

<style TYPE="text/css">
#syllabus_container { padding: 20px 15px; margin: 15px auto; width: 90%; min-width: 500px; max-width: 1024px;
  background: white; background: rgba(250, 250, 250, 0.8); border: ridge 1px black; font-size: 108%;
  -webkit-border-radius: 10px; moz-border-radius: 10px; ms-border-radius: 10px; o-border-radius: 10px; border-radius: 10px;
  -moz-box-shadow: inset 0 0 10px #ddd, 2px 2px 10px #777; -webkit-box-shadow: inset 0 0 10px #ddd, 2px 2px 10px #777;
  box-shadow: inset 0 0 10px #ddd, 2px 2px 10px #777; color: black !important;}
table#syllabus_table td { margin: -20px 0 !important; text-overflow: ellipsis;}
  @media only screen and (max-width: 920px) {
    #syllabus_container img {width: 75px}
    #syllabus_container {font-size: 90%}
  }
  @media only screen and (max-width: 790px) {
    #syllabus_container img {width: 65px}
    #syllabus_container {font-size: 80%}
  }
  @media only screen and (max-width: 690px) {
    #syllabus_container img {width: 60px}
    #syllabus_container {font-size: 70%}
  }
  @media only screen and (max-width: 650px) {
    #syllabus_container img {display:none}
  }
</style>

    </div>
<?php echo $OUTPUT->footer(); ?>