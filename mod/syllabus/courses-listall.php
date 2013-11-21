<?php


require_once("../../config.php");

require_once("lib.php");

$id = optional_param('id',0,PARAM_INT);    // Course Module ID, or
//$l = optional_param('l',0,PARAM_INT);     // Syllabus ID
$Filter = array();
$yearFilter = optional_param('y',0,PARAM_ALPHANUM);
$semesterFilter = optional_param('s',0,PARAM_ALPHANUM);
$sectionFilter = optional_param('n',0,PARAM_ALPHANUM);
$Filter["y"] = $yearFilter;
$Filter["s"] = $semesterFilter;
$Filter["n"] = $sectionFilter;

// if no filter vars clean filter array 
foreach ($Filter as $key => $value) {
    if (empty($value)) {
        unset($Filter[$key]);
    }
    
}

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
$PAGE->requires->js('/mod/syllabus/filter.js', true);

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
//var_dump($Filter);
?>

<div class="syllabus-form-body">
    <table class="syllabus-table"><colgroup><col /><col /><col /><col /><col /><col /></colgroup>
                
        <tr class="heading"><th>Course Number</th><th>Section<br/><?php echo syllabus_columnDataGroups("section_no",$Filter["n"]);?></th><th>Title</th><th>Year<br/><?php echo syllabus_columnDataGroups("year",$Filter["y"]);?></th><th>Semester<br/><?php echo syllabus_columnDataGroups("semester",$Filter["s"]);?></th><th>Action</th></tr>
                <?php
                //Get all records from course_syllabus that were created for this instance 
                $sql = 'SELECT {course_syllabus}.id,
                    {master_syllabus}.course_id, {master_syllabus}.course_number,
                    {master_syllabus}.title,{course_syllabus}.instance,
                    {course_syllabus}.year, {course_syllabus}.semester, {course_syllabus}.section_no 
                    FROM {course_syllabus} JOIN {master_syllabus} ON 
                    {course_syllabus}.master_syllabus_id = {master_syllabus}.id';
                if(!empty($Filter)){
                    $sql .=" where ";
                    $counter = 1;
                    foreach($Filter as $key => $value) {
                        if($counter >1) {
                            if($counter <= count($Filter)) {
                                $sql .= " and ";
                            }
                        }
                        switch ($key) {
                            case "y":
                                $sql .= "{course_syllabus}.year =\"$value\" ";
                                $counter++;
                                
                                break;
                            case "s":
                                $sql .= "{course_syllabus}.semester =\"$value\" ";
                                $counter++;
                                
                                break;
                            case "n":
                                $sql .= "{course_syllabus}.section_no =\"$value\" ";
                                $counter++;
                             
                                break;

                            default:
                                break;
                        }
                    }
                }
                $sql .=' 
                    ORDER BY 
                    {master_syllabus}.course_number ASC';
                
                $result = $DB->get_records_sql($sql);
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
                    $section_num = $value->section_no;
                //    $selected = $value->selected;
                
                    if($i % 2 == 0) {
                    
                        echo '<tr class="alt"';
                        
                    } else {
                        
                        echo '<tr';
                    }
                    
                    //check if class is active by checking if there is an instance with syllabus id
                    
                    $courseMoodleId=syllabus_course_has_selected($syllabusid);
                    
                    if($courseMoodleId) {
                        if($courseMoodleId->selected_course_syllabus == $syllabusid) {
                            $titlelink = "<a href=$CFG->wwwroot/course/view.php?id=$courseMoodleId->course>$title</a>";
                        }
                        else {
                            $titlelink = "<a href=$CFG->wwwroot/course/view.php?id=$courseMoodleId->course style=font-color:grey>$title</a>";
                        }
                    }
                    else {
                        $titlelink = "<strike>$title</br> $courseMoodleId</strike>";
                    }
                    
                    
                    echo '><td>'.$course_number.'</td><td>'.$section_num.'</td><td>'.$titlelink.'</td><td>'.$year.'</td><td>'.$semester.'</td><td class="syllabus-center">';
                    
                   
                    echo '<a href="'.$CFG->wwwroot.'/mod/syllabus/public-view.php?id='.$value->instance.'">Public Link</a>'; 
                   
                    echo '</td></tr>';
                    $i++;
                }
                
                ?>
                </table>
    <table class="syllabus-table"><colgroup><col /></colgroup>
                
                <tr class="heading"><th>Courses with Syllabus Instances but no Syllabus Selected</th></tr>
                <?php
                $result = $DB->get_records_sql('select course from {syllabus} where selected_course_syllabus is null');
                $i=1;
                foreach($result as $key=>$value) {
                             
                if($i % 2 == 0) {
                    
                        echo '<tr class="alt"';
                        
                    } else {
                        
                        echo '<tr';
                    }
                    
                echo ">";
                echo "<td><a href=$CFG->wwwroot/course/view.php?id=$value->course>Course $value->course</a></td>";
                echo "</tr>";
                $i++;
                }
                ?>
    </table>
</div>
<?php echo $OUTPUT->footer(); ?>
    