<?php
require_once("../../config.php");

require_once("lib.php");

$id = optional_param('id',0,PARAM_INT);    // Course Module ID, or
//$l = optional_param('l',0,PARAM_INT);     // Syllabus ID
$course = $_GET['course_id'];
$instance_id = $_GET['instance_id'];
$syllabusid = $_GET['syllabusid'];

require_login($course, true, NULL);

if (isset($_POST['submit-edit'])) {
    $course = $_GET['course_id'];
    $DB->update_record("course_syllabus", $_POST);
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
	$result = $DB->get_records_sql("SELECT * FROM {course_syllabus} WHERE id = ?", array($syllabusid));
        $mastersyllabusid = $result[$syllabusid]->master_syllabus_id;
        $masterresult = $DB->get_records_sql("SELECT * FROM {master_syllabus} WHERE id = ?", array($mastersyllabusid));
        ?>   
<div class="syllabus-form-tabs">
                
                <span id="edit-master" class="syllabus-form-tab selected">Edit Course Syllabus</span>                 
                </div>
<div class="syllabus-form-body">
                    <form id="course-add-new" action="course-edit.php?course_id=<?php echo $course; ?>&syllabusid=<?php echo $syllabusid; ?>&instance_id=<?php echo $instance_id; ?>" method="POST">
                        <input type="hidden" name="id" value="<?php echo $syllabusid; ?>" />
                        <label for="course_number">Course Number*</label>
                        <input type="text" class="required" name="course_number" disabled="disabled" value="<?php echo $masterresult[$mastersyllabusid]->course_number; ?>" /><br/>
                        <label for="title">Course Title</label>
                        <input type="text" name="title" disabled="disabled" value="<?php echo $masterresult[$mastersyllabusid]->title; ?>" /><br />
                        <label for="section">Section*</label>
                        <input class="required" type="text" maxlength="7" name="section_no" value="<?php echo $result[$syllabusid]->section_no; ?>" /><br />
                        <label for="year">Year</label>
                        <select name="year"><br/>
                        <?php 
                        $now = date('Y') -3;
                        $years[$now] = $now;
                        for ($i=0; $i <= 9; $i++) {
                            $now = $now + 1;
                            $years[$now] = $now;
                            
                            }
                        // if no year grab from master 
                        if(!$result[$syllabusid]->year) {
                            $result[$syllabusid]->year = $masterresult[$mastersyllabusid]->year;
                        }
                        if(!$result[$syllabusid]->semester) {
                            $result[$syllabusid]->semester = $masterresult[$mastersyllabusid]->semester;
                        }
                        
                        //same for att. policy & assessment
                        if(!$result[$syllabusid]->attendance_policy) {
                            $result[$syllabusid]->attendance_policy = $masterresult[$mastersyllabusid]->attendance_policy;
                        }
                        if(!$result[$syllabusid]->assessment) {
                            $result[$syllabusid]->assessment = $masterresult[$mastersyllabusid]->assessment;
                        }
                            
		   
                        
                        foreach($years as $key => $value) {
                            if ($value == $result[$syllabusid]->year) {
                                echo '<option selected="selected">'.$value.'</option>';
                            } else {
                                echo '<option>'.$value.'</option>';
                            }                                
                        }
                        ?>
                        </select><br />
                        <label for="semester">Semester</label>
                        <select name="semester">
                            <?php
                           $semesters = syllabus_get_semesters();
                            
                            foreach($semesters as $key => $value) {
                                if($value == $result[$syllabusid]->semester) {
                                    echo '<option selected="selected">'.$value.'</option>';
                                } else {
                                    echo '<option>'.$value.'</option>';
                                }
                            }
                            
                            ?>
                            
                        </select><br/>
                        <label for="instructor_name">Instructor Name*</label>
                        <input class="required" type="text" name="instructor_name" value="<?php echo $result[$syllabusid]->instructor_name; ?>" /><br />
                        <label for="instructor_email">Instructor Email*</label>
                        <input class="required" type="text" name="instructor_email" value="<?php echo $result[$syllabusid]->instructor_email; ?>" /><br />
                        <label for="instructor_phone">Instructor Phone</label>
                        <input type="text" name="instructor_phone" value="<?php echo $result[$syllabusid]->instructor_phone; ?>" /><br />
                        <label for="textbook" class="textarea">Textbook</label>
                        <?php $value = $result[$syllabusid]->textbook; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'textbook', $value); ?><br />
                        
                        <label for="supplies" class="textarea">Supplies</label>
                        <?php $value = $result[$syllabusid]->supplies; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'supplies', $value); ?><br />
                        
                        <label for="attendance_policy" class="textarea">Attendance Policy</label>
                        <?php $value = $result[$syllabusid]->attendance_policy; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'attendance_policy', $value); ?><br />
                        <label for="grading_policy" class="textarea">Grading Policy</label>
                        <?php $value = $result[$syllabusid]->grading_policy; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'grading_policy', $value); ?><br />
                        
                        <label for="assessment" class="textarea">Assessment Method</label>
                        <?php $value = $result[$syllabusid]->assessment; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'assessment', $value); ?><br />
                        
                        <label for="additional_info" class="textarea">Additional Info</label>
                        <?php $value = $result[$syllabusid]->additional_info; ?>
                        <?php print_textarea(1, 25, 65, 400, 300, 'additional_info', $value); ?><br />
                        
                        
                        <input type="submit" value="Update" name="submit-edit"/> <input type="submit" value="Cancel" id="course-edit-cancel" name="cancel" />
                    </form>
                    <p>* Required fields.</p>
		</div>
                
                

              
       

<?php
// Finish the page
echo $OUTPUT->footer();
?>
