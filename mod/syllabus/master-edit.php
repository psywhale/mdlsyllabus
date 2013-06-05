<?php
require_once("../../config.php");

require_once("lib.php");

$id = optional_param('id',0,PARAM_INT);    // Course Module ID, or
//$l = optional_param('l',0,PARAM_INT);     // Syllabus ID
$course = $_GET['course_id'];

$syllabusid = $_GET['syllabusid'];
$instance_id = $_GET['instance_id'];
require_login($course, true, NULL);

if (isset($_POST['submit'])) {
    $DB->update_record("master_syllabus", $_POST);
    header("Location: edit.php?course=".$course."&instance_id=".$instance_id."");
}

$PAGE->set_url('/mod/syllabus/master-edit.php', array('course'=>$course));

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
                
                <span id="edit-master" class="syllabus-form-tab selected">Edit Master Syllabus</span>                 
                </div>
<div class="syllabus-form-body" id="master-syllabus-edit">
                    <form id="master-edit" action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $syllabusid; ?>" />
                        <label for="course_number">Course Number*</label>
                        <input type="text" class="required" name="course_number" value="<?php echo $result[$syllabusid]->course_number; ?>" /><br/>
                        <label for="heading">Heading*</label>
                        <input type="text" class="required" name="heading" id="heading" value="<?php echo $result[$syllabusid]->heading; ?>" /><br />
                        <label for="department">Department*</label>
                        <input type="text" class="required" name="department" value="<?php echo $result[$syllabusid]->department; ?>" /><br />
                        <label for="title">Course Title <a href="#" title="Help with course titles." onclick="alert('This field should only be changed if the course name has been changed in Moodle.')"><img src="<?php echo $OUTPUT->pix_url('help', 'moodle'); ?>" alt="Help with course titles." /></a></label>
                        <input type="text" name="title" value="<?php echo $result[$syllabusid]->title; ?>" /><br />

<br />
                
<label for="credits">Credits*<?php syllabus_helper("help for Credits", "Number of credits class is worth")?></label>
                        <input type="text" class="required" name="credits" value="<?php echo $result[$syllabusid]->credits; ?>" /><br />
                        <label for="prerequisites" class="textarea">Prerequisites</label>
                        <?php $value = $result[$syllabusid]->prerequisites; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'prerequisites', $value); ?><br />
                        
                        <label for="corequisites" class="textarea">Corequisites</label>
                        <?php $value = $result[$syllabusid]->corequisites; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'corequisites', $value); ?><br />
                        
                        <label for="catalog_desc" class="textarea">Catalog Description</label>
                        <?php $value = $result[$syllabusid]->catalog_desc; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'catalog_desc', $value); ?><br />
                        
                        <label for="learning_outcomes" class="textarea">Learning Outcomes</label>
                        <?php $value = $result[$syllabusid]->learning_outcomes; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'learning_outcomes', $value); ?><br />
                        
                        <label for="course_requirements" class="textarea">Course Requirements</label>
                        <?php $value = $result[$syllabusid]->course_requirements; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'course_requirements', $value); ?><br />
                        
                        <label for="attendance_policy" class="textarea">Attendance Policy</label>
                        <?php $value = $result[$syllabusid]->attendance_policy; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'attendance_policy', $value); ?><br />
                        
                        
                        
                        <label for="course_competencies" class="textarea">Course Competencies</label>
                        <?php $value = $result[$syllabusid]->course_competencies; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'course_competencies', $value); ?><br />
                        
                        <label for="assessment" class="textarea">Course Assessment (Evaluation)</label>
                        <?php $value = $result[$syllabusid]->assessment; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'assessment', $value); ?><br />
                        
                        
                        <input type="submit" value="Update" name="submit"/> <input type="submit" value="Cancel" id="master-edit-cancel" name="cancel" />
                    </form>
                    <p>* Required fields.</p>
		</div>
                
                

              
       

<?php
// Finish the page
echo $OUTPUT->footer();
?>
