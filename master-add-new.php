<?php
require_once("../../config.php");

require_once("lib.php");
$course = $_GET['course'];
$instance_id = $_GET['instance_id'];
require_login($course, true, NULL);

global $CFG, $DB;
//die(print_r($_POST));
$DB->insert_record("master_syllabus", $_POST);

header("Location: edit.php?course=".$course."&instance_id=".$instance_id."");

?>
