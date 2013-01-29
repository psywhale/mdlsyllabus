<?php
//moodle 2.x
define('CLI_SCRIPT', true);


require(dirname(dirname(dirname(__FILE__))).'/config.php');

#require_once('config.php');
require_once($CFG->libdir.'/blocklib.php');
$hidden = true;

$courses = get_courses("all","c.sortorder ASC","c.*",$hidden);//can be feed categoryid to just effect one category
$numofcourses = count($courses);
$coursecount = 0;
foreach($courses as $course) {
   $coursecount++;
   echo "$course->id";
   $context = get_context_instance(CONTEXT_COURSE,$course->id);
//   blocks_delete_all_for_context($context->id);
   echo " delete blocks";
//   blocks_add_default_course_blocks($course);
   echo " added blocks   $coursecount / $numofcourses\n";
} 
?>
