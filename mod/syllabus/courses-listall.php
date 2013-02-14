<?php


require_once("../../config.php");

require_once("lib.php");

$id = optional_param('id',0,PARAM_INT);    // Course Module ID, or
//$l = optional_param('l',0,PARAM_INT);     // Syllabus ID
$course = $_GET['course'];
$instance_id = $id;
global $DB, $CFG;

$result = $DB->get_records_sql("SELECT course FROM {course_modules} WHERE id = ?", array($instance_id));
foreach ($result as $key => $value) {
    $course = $key;
}
require_login($course, true, NULL);

$context = get_context_instance(CONTEXT_COURSE, $course);

//var_dump($result);die;

$PAGE->set_url('/mod/syllabus/edit.php', array('course'=>$course));

$PAGE->set_title('Syllabus Management');

$PAGE->requires->js('/mod/syllabus/jquery.js', true);

$PAGE->requires->js('/mod/syllabus/validator.js', true);

$PAGE->requires->js('/mod/syllabus/js.php', true);

$PAGE->requires->css('/mod/syllabus/style.css');

$PAGE->set_heading('Syllabus Management');

$PAGE->set_context($context);

$PAGE->set_pagelayout('course');



// other things you may want to set - remove if not needed
//$PAGE->set_cacheable(false);
//$PAGE->set_focuscontrol('some-html-id');
//$PAGE->add_body_class('newmodule-'.$somevar);

// Output starts here
echo $OUTPUT->header();
?>

<div class="syllabus-form-body">
    <table class="syllabus-table"><colgroup><col /><col /><col /><col /><col /></colgroup>
                
                <tr class="heading"><th>Course</th><th>Title</th><th>Year</th><th>Semester</th><th>Action</th></tr>
                <?php
                //Get all records from course_syllabus that were created for this instance 
                $result = $DB->get_records_sql('SELECT {course_syllabus}.id,
                    {master_syllabus}.course_id, {master_syllabus}.course_number,
                    {master_syllabus}.title,{course_syllabus}.instance,
                    {course_syllabus}.year, {course_syllabus}.semester, {course_syllabus}.section_no 
                    FROM {course_syllabus} JOIN {master_syllabus} ON 
                    {course_syllabus}.master_syllabus_id = {master_syllabus}.id 
                    ORDER BY 
                    {master_syllabus}.course_number ASC');
                // get the selected course syllabus for this instance
                
                
                if(empty($result)) {
                    echo '<tr><td colspan="4" style="text-align:center">Please <a id="add-new-course-syllabus-link" href="#">add a new</a> syllabus.</td></tr>';
                }
                $i = 1;
                //var_export($result);
                foreach($result as $key => $value) {
                    
                    $course_number = $value->course_number;
                    $year = $value->year;
                    $title = $value->title;
                    $semester = $value->semester;
                    $syllabusid = $value->id;
                    $courseid = $value->course_id;
                //    $selected = $value->selected;
                
                    if($i % 2 == 0) {
                    
                        echo '<tr class="alt"';
                        
                    } else {
                        
                        echo '<tr';
                    }
                    echo '><td>'.$course_number.'</td><td>'.$title.'</td><td>'.$year.'</td><td>'.$semester.'</td><td class="syllabus-center">';
                    
                   
                    echo '<a href="'.$CFG->wwwroot.'/mod/syllabus/public-view.php?id='.$value->instance.'">Public Link</a>'; 
                   
                    echo '</td></tr>';
                    $i++;
                }
                
                ?>
                </table>
</div>
