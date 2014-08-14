<?php
require_once("../../config.php");

require_once("lib.php");
$syllabusid = $_GET['cloneid'];
$instance_id = $_GET['instance_id'];
$course = $_GET['course_id'];

require_login($course, true, NULL);
$result = $DB->get_records_sql("SELECT shortname FROM {course} WHERE id = ?", array($course));
foreach ($result as $key => $value) {
    $courseShortname = $key;
}
global $CFG, $DB;

$cloneCanidate=$DB->get_records_sql("select * from {course_syllabus} where id = ?",array($syllabusid));

$cloneCanidate[$syllabusid]->instance = $instance_id;
$cloneCanidate[$syllabusid]->section_no = $courseShortname;



//print_r($cloneCanidate);

$DB->insert_record("course_syllabus", $cloneCanidate[$syllabusid]);

header("Location: edit.php?course=".$course."&instance_id=".$instance_id."");

?>
