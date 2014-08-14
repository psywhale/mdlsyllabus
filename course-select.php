<?php
require_once("../../config.php");

require_once("lib.php");
$syllabusid = $_GET['syllabusid'];

$instance_id = $_GET['instance_id'];
$course = $_GET['course_id'];

require_login($course, true, NULL);

global $CFG, $DB;

$result = $DB->get_records_sql('SELECT {syllabus}.id FROM {syllabus} JOIN {course_modules} ON {syllabus}.id = {course_modules}.instance WHERE {course_modules}.id = ?', array($instance_id));
foreach($result as $key => $value) {
    $instance = $key;
}

$DB->update_record("syllabus", array("id"=>$instance,"selected_course_syllabus"=>$syllabusid));


header("Location: edit.php?course=".$course."&instance_id=".$instance_id."");

?>
