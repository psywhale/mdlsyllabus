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
 * given logged in user's email get all other syllabus with that email
 * @param char $email 
 */
function syllabus_printCloneList($email,$courseid,$instanceid){
    global $CFG,$DB;
    $html="";
    if($email) {
        $result=$DB->get_records_sql("select {course_syllabus}.*,{master_syllabus}.title from {course_syllabus} inner join {master_syllabus} on {course_syllabus}.master_syllabus_id = {master_syllabus}.id where {course_syllabus}.instructor_email = \"$email\" and {course_syllabus}.instance  != \"$instanceid\"");
        if(empty($result)) {
            $html = "<tr><td colspan=4>No Cloneable Syllabi Found</td></tr>";
            return($html);
                    
        }else{
            $i = 1;
                    
            foreach($result as $key => $value){
                if($i % 2 ==0) {
                    $html .="<tr class=\"alt\">";
                }
                else {
                    $html .= "<tr>";
                }
                $html .=
                        "<td>$value->section_no</td>" .
                        "<td><a href=\"view.php?id=$value->instance\">$value->title</a></td>" .
                        "<td>$value->semester $value->year</td>" .
                        "<td><button onclick='window.location=\"course-clone.php?cloneid=$value->id&course_id=$courseid&instance_id=$instanceid\"'>Clone</button></td>" .
                        "</tr>";
                $i++;
            }
         return($html);
        }
            
    }
    else {
        return("<tr><td colspan=4>Email Fail</td></tr>");
    }
    
    
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
        <strong>INSTRUCTOR INFORMATION</strong> $syllabus->instructor_hours        
        <strong>PREREQUISITES</strong> $syllabus->prerequisites
        <strong>COREQUISITES</strong> $syllabus->corequisites
        <strong>CATALOG DESCRIPTION</strong> $syllabus->catalog_desc
        <strong>TEXTBOOK</strong> $syllabus->textbook";
   if($syllabus->supplies != "") {
       $syllabus_html .= "<strong>SUPPLIES</strong> $syllabus->supplies";
   }
   
        $syllabus_html .= "    
        
        <strong>LEARNING OUTCOMES</strong> $syllabus->learning_outcomes
        ";
   if($syllabus->getting_started != "") {
       $syllabus_html .= "<strong>GETTING STARTED WITH THIS COURSE</strong> $syllabus->getting_started";
   }
   $syllabus_html .= "
        <strong>COURSE REQUIREMENTS</strong> $syllabus->course_requirements
                 ";
   if($syllabus->format_purpose != "") {
       $syllabus_html .= "<strong>COURSE STRUCTURE AND PURPOSE</strong> $syllabus->format_purpose";
   }
   $syllabus_html .= "   
        <strong>ATTENDANCE POLICY</strong> $syllabus->attendance_policy
        <strong>GRADING SCALE</strong> $syllabus->grading_policy
        <strong>ACADEMIC ETHICS</strong> <br />Western Oklahoma State College is committed to instilling and upholding integrity as a core value. All members of the Western Oklahoma State College community are entrusted with academic integrity, which encompasses the fundamental values of honesty, trust, respect, fairness, and responsibility. Western is devoted to maintaining an honest academic environment and ensures fair resolution of alleged violations of academic integrity.
        <a href=\"http://wosc.edu//index.php?page=academic-integrity-policy\"> Complete Integrity Policy available here... </a> <br/><br/>
        <strong>WESTERN'S ASSESSMENT POLICY</strong> <br />An important part of Western’s “commitment to excellence” is the systematic collection and examination of assessment data both to document and to improve student learning. Instructors and students will be asked to participate in assessment activities as a part of the course work. The results of assessment benefit students by identifying how competently they perform course goals as well as benefiting the college by confirming Western’s performance as an institution of higher education. <br/><br/>
        <strong>COURSE ASSESSMENT (Evaluation)</strong> $syllabus->assessment
        <strong>ADDITIONAL INFO</strong> $syllabus->additional_info
        <strong>WITHDRAW POLICY</strong> <br/>
           A student may withdraw from one of more classes with an automatic grade of \"W\". Please read the complete withdraw policy located in <a href=\"http://www.wosc.edu/index.php?page=College-Catalog\">College Catalog</a>.
     
           <br/><br/>
        <strong>TIME EXPECTATIONS FOR STUDENTS</strong> <br/>
           For each hour a student attends class, a student is expected to spend an additional two hours to prepare for the course. For example, in a traditional 16-week course, a three-hour course will require three hours of class time and an additional six hours of preparation outside of class each week. A three-hour course offered in an eight-week format would require six hours of class per week and an additional 12 hours outside of class per week for the student to prepare the course. Students should keep this information in mind as they prepare their schedules.
     
           <br/><br/>
        <strong>STUDENT SERVICE INFORMATION</strong> <br/>
            <p>Western Oklahoma State College offers a variety of resources to ensure student success. Tutor.com is a free online tutoring service that can be accessed 24 hours a day through the online portal. Peer tutoring is offered in multiple subject areas and can be found in A-4. Students who qualify for WINDS (federally funded TRIO grant) can access professional tutors in SSC202. Virtual Western is an online orientation also found on the online portal. All of these services are free to Western students and can be instrumental in navigating the collegiate experience.</p>
            <p> For more information regarding these services visit the <a href=\"http://wosc.edu//index.php?page=peer-tutoring\">Tutoring web page</a>.</p>
     
           <br/>
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
        <strong>EMAILS</strong> <br/>
            Please email the instructor with any concerns or questions about the course using the course email link inside Moodle. Always remember to be respectful and use appropriate language. All students should expect a response within an appropriate amount of time. (16 & 8 week courses should expect a response within a 48 hour window.)
        <br/><br/>

        <strong> NETIQUETTE: ETIQUETTE FOR COMMUNICATING ONLINE </strong> <br/>
        <p>Most, if not all, of the communication in online courses will occur online, which poses both benefits and challenges. It means that we can craft our responses effectively. If, however, we don't take the time to craft our responses, we can communicate unintended messages.
</p>
<p>It is sometimes difficult to remember that there are real people reading our messages. Words can mean many things, and what we intend to say is not always what others hear. This is especially true of \"online communication\" where others do not have the opportunity to see your \"body language\" or hear your tone; therefore, they have a greater possibility of misunderstanding what you truly mean. For those reasons, users of the Internet have come up with guidelines for net communication aimed at lessening the chances of miscommunication and perceived disrespect.
</p>
<p>Please, follow these guidelines in all of your online responses and discussion groups.
</p>
<p>Respect all who are participating in this learning community by
<ul><li>honoring their right to their opinions
<li>respecting the right of each person to disagree with others
<li>responding honestly but thoughtfully and respectfully using language which others will not consider foul or abusive
<li>always signing your name to any contribution you choose to make
<li>respecting your own privacy and the privacy of others by not revealing information which you deem private and which you feel might embarrass you or others
<li>being constructive in your responses to others in the class
<li>being prepared to clarify statements which might be misunderstood or misinterpreted by others
<li>One good way to avoid problems is to compose your postings off-line and reread them before sending them. Something written in haste may not say what you really think after the heat of the moment has passed.
</ul></p>
        <br/><br/>

        <strong>SUBJECT TO CHANGE NOTICE</strong> <br/>This syllabus is subject to change at any point during the course. If changes are made to the syllabus, all affected students will be notified by the method(s) listed in the Syllabus Change Notification section.<br/><br/>
        <strong>SYLLABUS CHANGE NOTIFICATION METHOD</strong> $syllabus->notify_method
        <strong>COURSE COMPETENCIES</strong> $syllabus->course_competencies
            
<strong>THE LEARNING RESOURCES CENTER</strong><br/>
<p>The Learning Resources Center (LRC) offers the following: online databases, E-books, periodicals, newspapers, in-house book collection, LibGuides, Interlibrary loans, and a photo and newspaper archive. Reference assistance is available in-person, by appointment and via Instant Messaging. Fax machines, copiers, a scanner, a big screen t.v. and two computers labs/group study rooms are available for use. If we do not have the items you need please submit an Interlibrary loans form located at <a href='http://www.wosc.edu/library'>www.wosc.edu/library</a>. Click on the link “Interlibrary Loan Request Form”.
</p><p>
To access the WOSC online card catalog and proprietary databases go to 
<a href='http://wosc-verso.auto-graphics.com/homepages/myaccount.asp'>http://wosc-verso.auto-graphics.com/homepages/myaccount.asp</a>
</p><p>
Enter the following username and password.<br/>
My Username: 29164000160540<br/>
My Password: onlinewestern<br/>
</p><p>
Note: To checkout books and other physical materials students need to setup their own accounts by coming to the LRC circulation desk. Please bring your Greenbucks Card (Student ID) with you.
</p>
<strong>PRACTICES FOR VERIFICATION OF STUDENT IDENTITY (Commission Policy FDCR.A.10.050)</strong>
<p>In order to verify the identity of students who participate in class or coursework, the institution may make use of a variety of methods, including but not limited to: (1) secure login and pass code; (2) proctored examinations; and (3) new or other technologies and practices that are effective in verifying the identity of students. Such methods must have reasonable and appropriate safeguards to protect student privacy. The institution must notify students at the time of registration or enrollment of any projected additional student charges associated with the verification of student identity such as separate fees charged by proctoring services, etc.
</p>
<p>When a Western Oklahoma State College students enroll in an online course, their participation in the course is restricted until they retrieve login information from Campus Connect. Access to Campus Connect also requires a secure login and password. In addition, Western Oklahoma State College’s online courses require students to take exams via ProctorU or in an Oklahoma approved proctoring environment. Some courses with different forms of assessment utilize other means of student verification and will be explained and documented by the instructor.</p>
<p>Students who do not reside in Oklahoma are required to use ProctorU for all proctored exams in online courses. Oklahoma residents may choose to take exams in an approved proctoring environment with instructor approval. For information about Western’s testing center, please visit the testing center website below.
</p>
<p>
<a href=http://www.wosc.edu/index.php?page=proctored-exams>Click here for Western's Testing Center Website</a>
</p>
<p>
ProctorU Service<br/>
Using a webcam and a reliable high-speed internet connection, students can take exams anywhere within the required time the instructor has given to take the test.
</p>

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

function syllabus_helper($title = "NEED TITLE", $helptext = "helptext needed") {
    global $CFG,$PAGE,$OUTPUT;
    echo "
    <a href=\"#\" title=\"$title\" onclick=\"alert('$helptext')\"><img src=\"".$OUTPUT->pix_url('help', 'moodle')."\" alt=\"$title\" /></a>
        ";
    
}