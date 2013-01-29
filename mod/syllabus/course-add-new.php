<?php
require_once("../../config.php");

require_once("lib.php");

$id = optional_param('id',0,PARAM_INT);    // Course Module ID, or
//$l = optional_param('l',0,PARAM_INT);     // Syllabus ID
$course = $_POST['course_id'];
$instance_id = $_GET['instance_id'];
$syllabusid = $_POST['select-template'];

require_login($course, true, NULL);

if (isset($_POST['submit-add-new'])) {
    $course = $_GET['course'];
    $DB->insert_record("course_syllabus", $_POST);
    header("Location: edit.php?course=".$course."&instance_id=".$instance_id."");
}

$PAGE->set_url('/mod/syllabus/course-add-new.php', array('course'=>$course));

$PAGE->set_title('Syllabus Management');

$PAGE->requires->js('/mod/syllabus/jquery.js', true);

$PAGE->requires->js('/mod/syllabus/validator.js', true);

$PAGE->requires->js('/mod/syllabus/js.php', true);

$PAGE->requires->css('/mod/syllabus/style.css');

$PAGE->set_heading('Syllabus Management');

$PAGE->set_pagelayout('course');

//$PAGE->set_context($context);

// other things you may want to set - remove if not needed
//$PAGE->set_cacheable(false);
//$PAGE->set_focuscontrol('some-html-id');
//$PAGE->add_body_class('newmodule-'.$somevar);

// Output starts here
echo $OUTPUT->header();

global $CFG, $DB;
	$result = $DB->get_records_sql("SELECT * FROM {master_syllabus} WHERE id = ?", array($syllabusid));
       
        ?>   
<div class="syllabus-form-tabs">
                
                <span id="edit-master" class="syllabus-form-tab selected">Add New Course Syllabus</span>                 
                </div>
<div class="syllabus-form-body">
                    <form id="course-add-new" action="course-add-new.php?course=<?php echo $course; ?>&instance_id=<?php echo $instance_id; ?>" method="POST">
                        <input type="hidden" name="master_syllabus_id" value="<?php echo $syllabusid; ?>" />
                        <input type="hidden" name="instance" value="<?php echo $instance_id; ?>" />
                        <label for="course_number">Course Number*</label>
                        <input type="text" class="required" name="course_number" disabled="disabled" value="<?php echo $result[$syllabusid]->course_number; ?>" /><br/>
                        <label for="title">Course Title</label>
                        <input type="text" name="title" disabled="disabled" value="<?php echo $result[$syllabusid]->title; ?>" /><br />
                        <label for="section">Section*</label>
                        <input class="required" type="text" maxlength="7" name="section_no" value="" /><br />
                        <label for="year">Year</label>
                        <input disabled="disabled" type="text" value="<?php echo $result[$syllabusid]->year; ?>" /><br />
                        <label for="semester">Semester</label>
                        <input disabled="disabled" type="text" value="<?php echo $result[$syllabusid]->semester; ?>" /><br />
                        <label for="instructor_name">Instructor Name*</label>
                        <input class="required" type="text" name="instructor_name" /><br />
                        <label for="instructor_email">Instructor Email*</label>
                        <input class="required" type="text" name="instructor_email" /><br />
                        <label for="instructor_phone">Instructor Phone</label>
                        <input type="text" name="instructor_phone" /><br />
                        <label for="textbook" class="textarea">Textbook</label>
                        <?php print_textarea(1, 25, 65, 200, 300, 'textbook'); ?><br />
                        
                        <label for="supplies" class="textarea">Supplies</label>
                        <?php print_textarea(1, 25, 65, 200, 300, 'supplies'); ?><br />
                        <label for="additional_info" class="textarea">Additional Info</label>
                        <?php print_textarea(1, 25, 65, 200, 300, 'additional_info'); ?><br />
                        
                        <input type="submit" value="Add" name="submit-add-new"/> <input type="submit" value="Cancel" id="course-add-cancel" name="cancel" />
                    </form>
                    <p>* Required fields.</p>
		</div>
                
                

              
       

<?php
// Finish the page
echo $OUTPUT->footer();
?>
