<?php
require_once("../../config.php");

require_once("lib.php");
$syllabusid = $_GET['syllabusid'];
$instance_id = $_GET['instance_id'];
$course = $_GET['course_id'];

require_login($course, true, NULL);

global $CFG, $DB;

$DB->delete_records("course_syllabus", array("id"=>$syllabusid));

header("Location: edit.php?course=".$course."&instance_id=".$instance_id."");

?>
