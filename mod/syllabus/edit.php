<?php
require_once("../../config.php");

require_once("lib.php");

$id = optional_param('id',0,PARAM_INT);    // Course Module ID, or
//$l = optional_param('l',0,PARAM_INT);     // Syllabus ID
$course = $_GET['course'];
$instance_id = $_GET['instance_id'];

require_login($course, true, NULL);

$context = get_context_instance(CONTEXT_COURSE, $course);



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

global $CFG, $DB;

if(empty($course)) {
    echo 'Error: you are accessing this page incorrectly.  Please access it from within a course.';
} else {
		
        ?>        
                
	<?php if (has_capability('mod/syllabus:updatemaster', $context)) {       ?>	
                <div>
         
                <div class="syllabus-form-tabs">
         
         
                <span id="manage-master" class="syllabus-form-tab selected">Manage Master Syllabus</span> <span id="manage-course" class="syllabus-form-tab">Manage Course Syllabus</span>
                
                </div>
                
                <div id="master-syllabus-body">
                
                <div class="syllabus-form-body" id="master-syllabus-view-all">
                
                <button id="add-new-master-syllabus-button">Add New</button>
                
                <table class="syllabus-table"><colgroup><col /><col /><col /><col /></colgroup>
                
                <tr class="heading"><th>Course</th><th>Action</th></tr>
                <?php
                //Get all records from master_syllabus that exist for this course 
                //$result = $DB->get_records_sql('SELECT {master_syllabus}.course_number, {master_syllabus}.title FROM {master_syllabus} JOIN {course_modules} ON {master_syllabus}.id = {course_modules}.instance JOIN {modules} ON {modules}.id = {course_modules}.module WHERE {modules}.name = ?', array('syllabus'));
                $result = $DB->get_records_sql('SELECT {master_syllabus}.id, {master_syllabus}.course_id, {master_syllabus}.course_number FROM {master_syllabus} ORDER BY {master_syllabus}.course_number ASC');
                if(empty($result)) {
                    echo '<tr><td colspan="4" style="text-align:center">Please <a id="add-new-master-syllabus-link" href="#">add a new</a> syllabus.</td></tr>';
                }
                $i = 1;
                
                foreach($result as $key => $value) {
                    
                    $course_number = $value->course_number;
                    //$year = $value->year;
                    //$semester = $value->semester;
                    $syllabusid = $value->id;
                    $courseid = $value->course_id;
                
                    if($i % 2 == 0) {
                    
                        echo '<tr class="alt"><td>'.$course_number.'</td><td class="syllabus-center"><a href="master-edit.php?syllabusid='.$syllabusid.'&course_id='.$course.'&instance_id='.$instance_id.'">Edit</a> | <a class="delete-master" href="master-delete.php?syllabusid='.$syllabusid.'&course_id='.$course.'&instance_id='.$instance_id.'">Delete</a></td></tr>';
                        
                    } else {
                        
                        echo '<tr><td>'.$course_number.'</td><td class="syllabus-center"><a href="master-edit.php?syllabusid='.$syllabusid.'&course_id='.$course.'&instance_id='.$instance_id.'">Edit</a> | <a class="delete-master" href="master-delete.php?syllabusid='.$syllabusid.'&course_id='.$course.'&instance_id='.$instance_id.'">Delete</a></td></tr>';                                            
                    }
                    
                    $i++;
                }
                ?>
                </table>
                
                </div>
                    
                <div class="syllabus-form-body" id="master-syllabus-add-new">
                    <form id="master-add-new" action="master-add-new.php?course=<?php echo $course; ?>&instance_id=<?php echo $instance_id; ?>" method="POST">
                        <label for="course_number">Course Number*</label>
                        <input type="text" class="required" name="course_number" /><br/>
                        <label for="heading">Heading*</label>
                        <input type="text" class="required" name="heading" id="heading" /><br />
                        <label for="department">Department*</label>
                        <input type="text" class="required" name="department" /><br />
                
                              
                
                
                <label for="title">Course Title <a href="#" title="Help with course titles." onclick="alert('In order for a course title to appear in this list, the course must first be created in Moodle.')"><img src="<?php echo $OUTPUT->pix_url('help', 'moodle'); ?>" alt="Help with course titles." /></a></label>
                <input type="text" class="required" name="title" /><br />
                <br />
                <input type="hidden" id="course_id" name="course_id" value="" />
   
                        <br />
                
                        <label for="credits">Credits*</label>
                        <input type="text" class="required" name="credits" /><br />
                        <label for="prerequisites" class="textarea">Prerequisites</label>
                        <?php print_textarea(1, 25, 65, 400, 300, 'prerequisites'); ?><br />
                        
                        <label for="corequisites" class="textarea">Corequisites</label>
                        <?php print_textarea(1, 25, 65, 400, 300, 'corequisites'); ?><br />
                        <label for="catalog_desc" class="textarea">Catalog Description</label>
                        <?php print_textarea(1, 25, 65, 400, 300, 'catalog_desc'); ?><br />
                        <label for="learning_outcomes" class="textarea">Learning Outcomes</label>
                        <?php print_textarea(1, 25, 65, 400, 300, 'learning_outcomes'); ?><br />
                        <label for="course_requirements" class="textarea">Course Requirements</br>(Template
                            <?php syllabus_helper("Template", get_string("SyllabusTemplateHelp","syllabus"))?>)</label>
                        <?php print_textarea(1, 25, 65, 400, 300, 'course_requirements'); ?><br />
                        <label for="attendance_policy" class="textarea">Attendance Policy </br>(Template
                            <?php syllabus_helper("Template", get_string("SyllabusTemplateHelp","syllabus"))?>)</label>
                        <?php print_textarea(1, 25, 65, 400, 300, 'attendance_policy'); ?><br />
                        
                        <label for="course_competencies" class="textarea">Course Competencies</label>
                        <?php print_textarea(1, 25, 65, 400, 300, 'course_competencies'); ?><br />
                        <label for="assessment" class="textarea">Course Assessment (Evaluation)</br>(Template
                            <?php syllabus_helper("Template", get_string("SyllabusTemplateHelp","syllabus"))?>)</label>
                        <?php print_textarea(1, 25, 65, 400, 300, 'assessment'); ?><br />
                        
                        <input type="submit" value="Add" name="submit"/> <input type="submit" value="Cancel" id="master-add-new-cancel" name="cancel" />
                    </form>
                    <p>* Required fields.</p>
		</div>
                
                </div>
                
                </div>
<div id="course-syllabus-body">
                
                <div class="syllabus-form-body" id="course-syllabus-view-all">
                
                    <button id="add-new-course-syllabus-button">Add New</button>
                    
                    <table class="syllabus-table"><colgroup><col /><col /><col /><col /></colgroup>
                
                <tr class="heading"><th>Course</th><th>Year</th><th>Semester</th><th>Action</th></tr>
                <?php
                //Get all records from course_syllabus that were created for this instance 
                $result = $DB->get_records_sql('SELECT {course_syllabus}.id, {master_syllabus}.course_id, {master_syllabus}.course_number, {course_syllabus}.year, {course_syllabus}.semester FROM {course_syllabus} JOIN {master_syllabus} ON {course_syllabus}.master_syllabus_id = {master_syllabus}.id WHERE {course_syllabus}.instance = ? ORDER BY {master_syllabus}.course_number ASC', array($instance_id));
                // get the selected course syllabus for this instance
                $instanceresult = $DB->get_records_sql('SELECT {syllabus}.id, {syllabus}.selected_course_syllabus FROM {syllabus} JOIN {course_modules} ON {syllabus}.id = {course_modules}.instance WHERE {course_modules}.id = ?', array($instance_id));
                if(!empty($instanceresult)) {
                    foreach($instanceresult as $key => $value) {
                        $selected = $value->selected_course_syllabus;
                    }
                } else {
                    $selected = 0;
                }
                
                if(empty($result)) {
                    echo '<tr><td colspan="4" style="text-align:center">Please <a id="add-new-course-syllabus-link" href="#">add a new</a> syllabus.</td></tr>';
                }
                $i = 1;
                
                foreach($result as $key => $value) {
                    
                    $course_number = $value->course_number;
                    $year = $value->year;
                    $semester = $value->semester;
                    $syllabusid = $value->id;
                    $courseid = $value->course_id;
                //    $selected = $value->selected;
                
                    if($i % 2 == 0) {
                    
                        echo '<tr class="alt"';
                        
                    } else {
                        
                        echo '<tr';
                    }
                    echo '><td>'.$course_number.'</td><td>'.$year.'</td><td>'.$semester.'</td><td class="syllabus-center">';
                    
                    if($syllabusid == $selected) {
                        echo '<em>Selected</em>';
                   } else {
                        echo '<a href="course-select.php?syllabusid='.$syllabusid.'&course_id='.$course.'&instance_id='.$instance_id.'">Select</a>'; 
                   }
                    echo ' | <a href="course-edit.php?syllabusid='.$syllabusid.'&course_id='.$course.'&instance_id='.$instance_id.'">Edit</a> | <a class="delete-course" href="course-delete.php?syllabusid='.$syllabusid.'&course_id='.$course.'&instance_id='.$instance_id.'">Delete</a></td></tr>';
                    $i++;
                }
                
                ?>
                </table>
                 
                    
                </div>
                    <?php 
                    //  select which master syllabus to use as a template
                   $result = $DB->get_records_sql("SELECT id,course_number,title FROM {master_syllabus} order by {master_syllabus}.course_number ASC");
                   ?>
                <div class="syllabus-form-body" id="course-syllabus-add-new">
                    <p>Please select a master syllabus to use as a template:</p>
                    <form id="select-template" action="course-add-new.php?course_id=<?php echo $course; ?>&instance_id=<?php echo $instance_id; ?>" method="POST">
                     <table class="syllabus-table"> 
                         <colgroup><col /><col /><col /><col /></colgroup>
                        <tr class="heading"><th style="width:10px"></th><th>Course Number</th><th>Title</th></tr>
                        
                   <?php
                    
                   
                   if(empty($result)) {
                       echo '<tr><td colspan="4">There are no master syllabi for this course yet.  Please contact the course coordinator.</td></tr>';
                   }
                   $i = 1;
                   foreach($result as $key => $value) {
                       if ($i % 2 == 0) {
                           echo '<tr class="alt"><td style="width:10px"><input type="radio" name="select-template" value="'.$value->id.'"></td><td>'.$value->course_number.'</td><td>'.$value->title.'</td></tr>';
                       } else {
                           echo '<tr><td style="width:10px"><input type="radio" name="select-template" value="'.$value->id.'"></td><td>'.$value->course_number.'</td><td>'.$value->title.'</td></tr>';
                       }
                       $i++;
                   }
                   ?>
                        </table>
                        <input type="hidden" name="course_id" value="<?php echo $course; ?>" />
                        <input type="submit" name="submit" value="Select" /> <input id="course-add-new-cancel" type="submit" name="cancel" value="Cancel" />
                    </form>
                </div>
                </div>
                
                
                <?php } elseif (has_capability('mod/syllabus:updatecourse', $context)) { ?>
                <div>
                <div class="syllabus-form-tabs">
         
         
                <span id="manage-course" class="syllabus-form-tab selected">Manage Course Syllabus</span>
                
                </div>
                <div class="syllabus-form-body" id="course-syllabus-view-all">
                
                    <button id="add-new-course-syllabus-button">Add New</button>
                    
                    <table class="syllabus-table"><colgroup><col /><col /><col /><col /></colgroup>
                
                <tr class="heading"><th>Course</th><th>Year</th><th>Semester</th><th>Action</th></tr>
                <?php
                //Get all records from course_syllabus that were created for this instance 
                $result = $DB->get_records_sql('SELECT {course_syllabus}.id, {master_syllabus}.course_id, {master_syllabus}.course_number, {master_syllabus}.year, {master_syllabus}.semester FROM {course_syllabus} JOIN {master_syllabus} ON {course_syllabus}.master_syllabus_id = {master_syllabus}.id WHERE {course_syllabus}.instance = ? ORDER BY {master_syllabus}.course_number ASC', array($instance_id));
                // get the selected course syllabus for this instance
                $instanceresult = $DB->get_records_sql('SELECT {syllabus}.id, {syllabus}.selected_course_syllabus FROM {syllabus} JOIN {course_modules} ON {syllabus}.id = {course_modules}.instance WHERE {course_modules}.id = ?', array($instance_id));
                if(!empty($instanceresult)) {
                    foreach($instanceresult as $key => $value) {
                        $selected = $value->selected_course_syllabus;
                    }
                } else {
                    $selected = 0;
                }
                
                if(empty($result)) {
                    echo '<tr><td colspan="4" style="text-align:center">Please <a id="add-new-course-syllabus-link" href="#">add a new</a> syllabus.</td></tr>';
                }
                $i = 1;
                
                foreach($result as $key => $value) {
                    
                    $course_number = $value->course_number;
                    $year = $value->year;
                    $semester = $value->semester;
                    $syllabusid = $value->id;
                    $courseid = $value->course_id;
                //    $selected = $value->selected;
                
                    if($i % 2 == 0) {
                    
                        echo '<tr class="alt"';
                        
                    } else {
                        
                        echo '<tr';
                    }
                    echo '><td>'.$course_number.'</td><td>'.$year.'</td><td>'.$semester.'</td><td class="syllabus-center">';
                    
                    if($syllabusid == $selected) {
                        echo '<em>Selected</em>';
                   } else {
                        echo '<a href="course-select.php?syllabusid='.$syllabusid.'&course_id='.$course.'&instance_id='.$instance_id.'">Select</a>'; 
                   }
                    echo ' | <a href="course-edit.php?syllabusid='.$syllabusid.'&course_id='.$course.'&instance_id='.$instance_id.'">Edit</a> | <a class="delete-course" href="course-delete.php?syllabusid='.$syllabusid.'&course_id='.$course.'&instance_id='.$instance_id.'">Delete</a></td></tr>';
                    $i++;
                }
                
                ?>
                </table>
                 
                    
                </div>
                    <?php 
                    //  select which master syllabus to use as a template
                   $result = $DB->get_records_sql("SELECT id,course_number,semester,year FROM {master_syllabus} ORDER BY {master_syllabus}.course_number ASC");
                   ?>
                <div class="syllabus-form-body" id="course-syllabus-add-new">
                    <p>Please select a master syllabus to use as a template:</p>
                    <form id="select-template" action="course-add-new.php?course_id=<?php echo $course; ?>&instance_id=<?php echo $instance_id; ?>" method="POST">
                     <table class="syllabus-table"> 
                         <colgroup><col /><col /><col /><col /></colgroup>
                        <tr class="heading"><th style="width:10px"></th><th>Course Number</th><th>Year</th><th>Semester</th></tr>
                        
                   <?php
                    
                   
                   if(empty($result)) {
                       echo '<tr><td colspan="4">There are no master syllabi for this course yet.  Please contact the course coordinator.</td></tr>';
                   }
                   $i = 1;
                   foreach($result as $key => $value) {
                       if ($i % 2 == 0) {
                           echo '<tr class="alt"><td style="width:10px"><input type="radio" name="select-template" value="'.$value->id.'"></td><td>'.$value->course_number.'</td><td>'.$value->year.'</td><td>'.$value->semester.'</td></tr>';
                       } else {
                           echo '<tr><td style="width:10px"><input type="radio" name="select-template" value="'.$value->id.'"></td><td>'.$value->course_number.'</td><td>'.$value->year.'</td><td>'.$value->semester.'</td></tr>';
                       }
                       $i++;
                   }
                   ?>
                        </table>
                        <input type="hidden" name="course_id" value="<?php echo $course; ?>" />
                        <input type="submit" name="submit" value="Select" /> <input id="course-add-new-cancel" type="submit" name="cancel" value="Cancel" />
                    </form>
                </div>
                </div>
                
                	
       

<?php
                } else {
                    echo '<p>You do not have permission to manage this course syllabus.</p>';
                }
}
// Finish the page
echo $OUTPUT->footer();
?>
