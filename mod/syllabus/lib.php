<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Library of functions and constants for module syllabus
 *
 * @package    mod
 * @subpackage syllabus
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/** SYLLABUS_MAX_NAME_LENGTH = 50 */
//define("SYLLABUS_MAX_NAME_LENGTH", 50);

// get course module id
function get_syllabus_coursemodule_from_id($modulename, $cmid, $courseid=0, $sectionnum=false, $strictness=IGNORE_MISSING) {
    global $DB;

    $params = array('cmid'=>$cmid);

    if (!$modulename) {
        if (!$modulename = $DB->get_field_sql("SELECT md.name
                                                 FROM {modules} md
                                                 JOIN {course_modules} cm ON cm.module = md.id
                                                WHERE cm.id = :cmid", $params, $strictness )) {
            return false;
        }
    }

    $params['modulename'] = $modulename;

    $courseselect = "";
    $sectionfield = "";
    $sectionjoin  = "";

    if ($courseid) {
        $courseselect = "AND cm.course = :courseid";
        $params['courseid'] = $courseid;
    }

    if ($sectionnum) {
        $sectionfield = ", cw.section AS sectionnum";
        $sectionjoin  = "LEFT JOIN {course_sections} cw ON cw.id = cm.section";
    }

    $sql = "SELECT cm.*, m.course_id, md.name AS modname $sectionfield
              FROM {course_modules} cm
                   JOIN {modules} md ON md.id = cm.module
                   JOIN {master_syllabus} m ON m.id = cm.instance
                   $sectionjoin
             WHERE cm.id = :cmid AND md.name = :modulename
                   $courseselect";

   return $DB->get_record_sql($sql, $params, $strictness);
}


/**
 * @uses SYLLABUS_MAX_NAME_LENGTH
 * @param object $syllabus
 * @return string
 */

function get_syllabus_name($syllabus) {
    $textlib = textlib_get_instance();
    $name = strip_tags(format_string($syllabus->title,true));
    if ($textlib->strlen($name) > SYLLABUS_MAX_NAME_LENGTH) {
        $name = $textlib->substr($name, 0, SYLLABUS_MAX_NAME_LENGTH)."...";
    }

    if (empty($name)) {
        // arbitrary name
        $name = get_string('modulename','syllabus');
    }
    
    return $name;
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @global object
 * @param object $syllabus
 * @return bool|int
 */
function syllabus_add_instance($syllabus) {
    global $DB, $CFG;

    $syllabus->name = 'Syllabus';
    $syllabus->timemodified = time();
    $syllabus->intro = 'syllabus';
    //$course = $syllabus->course;
    return $DB->insert_record("syllabus", $syllabus);
    //$url = $CFG->wwwroot.'/mod/syllabus/edit.php?course='.$course;
    //redirect($url);
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @global object
 * @param object $syllabus
 * @return bool
 */

function syllabus_update_instance($syllabus) {
    global $DB, $CFG;
    $instance_id = $_GET['update'];
    $url = $CFG->wwwroot.'/mod/syllabus/edit.php?instance_id='.$instance_id;
    redirect($url);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @global object
 * @param int $id
 * @return bool
 */

function syllabus_delete_instance($id) {
    global $DB;

    if (! $syllabus = $DB->get_record("syllabus", array("id"=>$id))) {
        return false;
    }

    $result = true;

    if (! $DB->delete_records("syllabus", array("id"=>$syllabus->id))) {
        $result = false;
    }

    return $result;
}

/**
 * Returns the users with data in one resource
 * (NONE, but must exist on EVERY mod !!)
 *
 * @todo: deprecated - to be deleted in 2.2
 *
 * @param int $syllabusid
 */

function syllabus_get_participants($syllabusid) {

    return false;
}

/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 * See get_array_of_activities() in course/lib.php
 *
 * @global object
 * @param object $coursemodule
 * @return object|null
 */
function syllabus_get_coursemodule_info($coursemodule) {
    
    $info = new stdClass();
    $info->name = 'Syllabus';
    $info->extra = 'This is the syllabus for this course.';
    return $info;
}

/*
function syllabus_get_coursemodule_info($coursemodule) {
    global $DB;

    if ($syllabus = $DB->get_record('master_syllabus', array('id'=>$coursemodule->instance), 'id, title')) {
        if (empty($syllabus->title)) {
            // label name missing, fix it
            $syllabus->title = "syllabus{$syllabus->id}";
            $DB->set_field('syllabus', 'name', $syllabus->title, array('id'=>$syllabus->id));
        }
        $info = new stdClass();
        // no filtering hre because this info is cached and filtered later
        $info->extra = format_module_intro('syllabus', $syllabus, $coursemodule->id, false);
        $info->name  = 'SYLLABUS';
        
        return $info;
    } else {
        return null;
    }
}
*/

/**
 * @return array
 */

function syllabus_get_view_actions() {
    return array();
}

/**
 * @return array
 */

function syllabus_get_post_actions() {
    return array();
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 *
 * @param object $data the data submitted from the reset course.
 * @return array status array
**/

function syllabus_reset_userdata($data) {
    return array();
}

/**
 * Returns all other caps used in module
 *
 * @return array
 */

function syllabus_get_extra_capabilities() {
    return array('moodle/site:accessallgroups');
}

/**
 * @uses FEATURE_IDNUMBER
 * @uses FEATURE_GROUPS
 * @uses FEATURE_GROUPINGS
 * @uses FEATURE_GROUPMEMBERSONLY
 * @uses FEATURE_MOD_INTRO
 * @uses FEATURE_COMPLETION_TRACKS_VIEWS
 * @uses FEATURE_GRADE_HAS_GRADE
 * @uses FEATURE_GRADE_OUTCOMES
 * @param string $feature FEATURE_xx constant for requested feature
 * @return bool|null True if module supports feature, false if not, null if doesn't know
 */
function syllabus_supports($feature) {
    switch($feature) {
        case FEATURE_IDNUMBER:                return false;
        case FEATURE_GROUPS:                  return false;
        case FEATURE_GROUPINGS:               return false;
        case FEATURE_GROUPMEMBERSONLY:        return true;
        case FEATURE_MOD_INTRO:               return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return false;
        case FEATURE_GRADE_HAS_GRADE:         return false;
        case FEATURE_GRADE_OUTCOMES:          return false;
        case FEATURE_MOD_ARCHETYPE:           return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_BACKUP_MOODLE2:          return true;
        case FEATURE_NO_VIEW_LINK:            return false;

        default: return null;
    }
}
/**
 * @return array
 * 
 */
function syllabus_get_semesters() {
   $semesters = array(
   'FALL',
   'FALL 1st 8 weeks',
   'FALL 2nd 8 weeks',
   'FALL 1st 4 weeks',
   'FALL 2nd 4 weeks',
   'FALL 3rd 4 weeks',
   'FALL 4th 4 weeks',
   'SPRING',
   'SPRING 1st 8 weeks',
   'SPRING 2nd 8 weeks',
   'SPRING 1st 4 weeks',
   'SPRING 2nd 4 weeks',
   'SPRING 3rd 4 weeks',
   'SPRING 4th 4 weeks',
   'SUMMER',
   'SUMMER 1st 4 weeks',
   'SUMMER 2nd 4 weeks'
   );
                            
return $semesters;
}

/**
 * Given a course syllabus id number checks whether it is used in mdl_syllabus 
 *  as  selected course syllabus
 *  @param int $syllabusid  master id number 
 *  @return int Course id number
 */
function syllabus_course_has_selected ($syllabusid){
    global $DB;
    if($syllabusid){
        $sql = "select * from {syllabus} where selected_course_syllabus = $syllabusid";
        $result = $DB->get_record_sql($sql);
        
    }
    else{
        return false;
    }
    
    return $result->course;
}



/**
 * @return string 
 */
function syllabus_print($syllabus) {
    //var_dump($syllabus); die;
    $syllabus->heading = strtoupper($syllabus->heading);
    $syllabus->department = strtoupper($syllabus->department);
    $syllabus->title = strtoupper($syllabus->title);
    $syllabus->course_number = strtoupper($syllabus->course_number);
    $syllabus->credits = strtoupper($syllabus->credits);
    $syllabus->prerequisites = strtoupper($syllabus->prerequisites); 
    
   $syllabus_html = "
    <div id=\"syllabus_container\">
        <p style=\"text-align:center;\"><img style=\"float:right; margin: -5px 0 0 -90px;\" src=\"http://wosc.edu/img/seal90.png\">
	<span style=\"font-size: 78%\"><strong>$syllabus->heading </strong></span><br />
	<span style=\"font-size: 80%;\"><strong>DEPARTMENT OF $syllabus->department</strong></span><br />
	<span style=\"font-size: 155%;\"><strong>COURSE SYLLABUS</strong><br />
	</p><br />
<!--         <p style=\"text-align:center\"><strong>COURSE SYLLABUS</strong></p> -->
        <table style=\"border:none;width:100%\" style=\"syllabus_table\">
            <tr>
                <td style=\"\"><strong>COURSE TITLE</strong></td>
                <td>$syllabus->title</td>
                <td style=\"\"><strong>INSTRUCTOR NAME</strong></td>
                <td>$syllabus->instructor_name</td>
            </tr>
            <tr>
                <td style=\"\"><strong>SEMESTER</strong></td>
                <td>$syllabus->semester $syllabus->year</td>
                <td style=\"\"><strong>INSTRUCTOR EMAIL</strong></td>
                <td><a href=\"mailto:$syllabus->instructor_email?subject=Question about the $syllabus->section_no; ?>: <?php echo strtoupper($syllabus->title); ?> Syllabus...&body=Course Title:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($syllabus->title); ?>%0D%0ACourse Date:&nbsp;&nbsp;&nbsp;<?php echo $syllabus->semester; ?> <?php echo $syllabus->year; ?>%0D%0ACourse #:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($syllabus->course_number); ?>%0D%0A%0D%0A%0D%0A - Insert Question Here - %0D%0A\" target=\"_blank\">$syllabus->instructor_email</a></td>
            </tr>
            <tr>
                <td style=\"\"><strong>COURSE NUMBER</strong></td>
                <td>$syllabus->course_number</td>
                <td style=\"\"><strong>INSTRUCTOR PHONE</strong></td>
                <td>$syllabus->instructor_phone</td>
            </tr>
            <tr>
                <td style=\"\"><strong>SECTION NUMBER</strong></td>
                <td>$syllabus->section_no</td>
                <td style=\"\"><strong>CREDIT HOURS</strong></td>
                <td>$syllabus->credits</td>
            </tr>
        </table>   
<hr style=\"color: #555 !important;\" > 
		<div style=\"margin-left: 8px;\"> <!-- START <p> left margin -->
        <strong>INSTRUCTOR OFFICE HOURS</strong> $syllabus->instructor_hours        
        <strong>PREREQUISITES</strong> $syllabus->prerequisites
        <strong>COREQUISITES</strong> $syllabus->corequisites
        <strong>CATALOG DESCRIPTION</strong> $syllabus->catalog_desc
        <strong>TEXTBOOK</strong> $syllabus->textbook
        <strong>SUPPLIES</strong> $syllabus->supplies
        <strong>LEARNING OUTCOMES</strong> $syllabus->learning_outcomes
        
        <strong>COURSE REQUIREMENTS</strong> $syllabus->course_requirements
        <strong>ATTENDANCE POLICY</strong> $syllabus->attendance_policy
        <strong>GRADING POLICY</strong> $syllabus->grading_policy
        <strong>ACADEMIC ETHICS</strong> <br />Western Oklahoma State College is committed to instilling and upholding integrity as a core value. All members of the Western Oklahoma State College community are entrusted with academic integrity, which encompasses the fundamental values of honesty, trust, respect, fairness, and responsibility. Western is devoted to maintaining an honest academic environment and ensures fair resolution of alleged violations of academic integrity.
        <a href=\"http://wosc.edu//index.php?page=academic-integrity-policy\"> Complete Integrity Policy available here... </a> <br/><br/>
        <strong>ASSESSMENT</strong> <br />An important part of Western’s “commitment to excellence” is the systematic collection and examination of assessment data both to document and to improve student learning. Instructors and students will be asked to participate in assessment activities as a part of the course work. The results of assessment benefit students by identifying how competently they perform course goals as well as benefiting the college by confirming Western’s performance as an institution of higher education. <br/><br/>
        <strong>COURSE ASSESSMENT</strong> $syllabus->assessment
        <strong>ADDITIONAL INFO</strong> $syllabus->additional_info
        <strong>WITHDRAW POLICY</strong> <br/>
           A student may withdraw from one of more classes with an automatic grade of \"W\". Please read the complete withdraw policy located in <a href=\"http://www.wosc.edu/index.php?page=College-Catalog\">College Catalog</a>.
     
           <br/><br/>
        <strong>TUTORING</strong> <br/>
            Western provides FREE tutoring for students experiencing academic difficulty. Peer tutoring is available in A-4 and online tutoring is available at Tutor.com. For more information regarding these services visit the <a href=\"http://wosc.edu//index.php?page=peer-tutoring\">Tutoring web page</a>.
     
           <br/><br/>
        <strong>TRANSCRIPTS</strong> <br/>
             Students may request a transcript by visiting the Office of Admissions or logging into their Campus Connect account.  For more information go to <a href=http://wosc.edu//admissions#transcripts>WOSC Transcripts webpage</a>
     
           <br/><br/>
        <strong>STUDENTS RECEIVING TITLE IV FEDERAL AID (GRANTS,LOANS,WORK-STUDY,ETC..)</strong> <br/>
              If you withdraw or do not successfully complete the hours your aid was calculated on, or quit attending class before the 60% point of the semester, you may owe a refund to the Title IV Program.<br/><br/>
Class attendance is a requirement to receive Title IV Federal Aid.   On-line students must submit work to be certified as attending. Failure to attend class will delay and could void your aid.
     
           <br/><br/>
        <strong>ADA STATEMENT</strong> <br/>
           WOSC is committed to providing support services to physically and learning disabled students.  These services are guided by Section 504 of the Rehabilitation Act of 1973 and the Americans with Disabilities Act of 1990 which prohibits discrimination against otherwise qualified individuals with disabilities, and mandates that reasonable accommodations be made for such persons. <a href=\"http://www.wosc.edu/index.php?page=counseling\">Complete ADA Policy available</a> 
           <br/><br/>
        <strong>SUBJECT TO CHANGE NOTICE</strong> <br/>This syllabus is subject to change at any point during the course. If changes are made to the syllabus, all affected students will be notified by the method(s) listed in the Syllabus Change Notification section.<br/><br/>
        <strong>SYLLABUS CHANGE NOTIFICATION METHOD</strong> $syllabus->notify_method
        <strong>COURSE COMPETENCIES</strong> $syllabus->course_competencies
		</div> <!-- END <p> left margin -->

<style TYPE=\"text/css\">
#syllabus_container { padding: 20px 15px; margin: 15px auto; width: 90%; min-width: 500px; max-width: 1024px;
  background: white; background: rgba(250, 250, 250, 0.8); border: ridge 1px black; font-size: 108%;
  -webkit-border-radius: 10px; moz-border-radius: 10px; ms-border-radius: 10px; o-border-radius: 10px; border-radius: 10px;
  -moz-box-shadow: inset 0 0 10px #ddd, 2px 2px 10px #777; -webkit-box-shadow: inset 0 0 10px #ddd, 2px 2px 10px #777;
  box-shadow: inset 0 0 10px #ddd, 2px 2px 10px #777; color: black !important;}
table#syllabus_table td { margin: -20px 0 !important; text-overflow: ellipsis;}
  @media only screen and (max-width: 920px) {
    #syllabus_container img {width: 75px}
    #syllabus_container {font-size: 90%}
  }
  @media only screen and (max-width: 790px) {
    #syllabus_container img {width: 65px}
    #syllabus_container {font-size: 80%}
  }
  @media only screen and (max-width: 690px) {
    #syllabus_container img {width: 60px}
    #syllabus_container {font-size: 70%}
  }
  @media only screen and (max-width: 650px) {
    #syllabus_container img {display:none}
  }
</style>

    </div>
    ";
   
   return $syllabus_html;
}