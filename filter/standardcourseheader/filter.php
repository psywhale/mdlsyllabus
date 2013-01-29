<?php

class filter_standardcourseheader extends moodle_text_filter {
	
	public function replace_stuff($tag){
	global $COURSE, $DB;  
	//initialize vars
	$keyValues = null;
	$vid = "";
	$feedback = "";	
		//Getting youtube video
		$working = explode(" ",$tag[0]);
		foreach($working as $pair) {
			$pair = preg_replace('/\]/','',$pair);
			if(preg_match('/=/',$pair)){
				$keyValues = explode('=',$pair);
				//echo "Key = $keyValues[0] and Value = $keyValues[1]";
			}
		
			if($keyValues[0] == 'video'){
				$vidInfo = explode('=',$pair);
				$vid =  '<iframe style="max-width: 320px;" class="instructorvid" wmode="Opaque" src="http://www.youtube.com/embed/'.$vidInfo[1].'?rel=0" 
					title="YouTube video player" frameborder="0" height="212" width="100%"></iframe>';
			}
                        if($keyValues[0] == 'feedback'){
                                $feedback =  '<a title="Intersession Course Feedback" href="#" target="_blank"><span class="button-green">INTERSESSION FEEKBACK</span></a>';
                        }
			if($keyValues[0] == 'syllabus'){
				$syllabusInfo = explode('=',$pair,2);
				$syllabusLink = $syllabusInfo[1];
			}
		}
		
		$url = substr($working[1],6,strlen($working[1])-7);  
		//return $url;
		
		//Getting Instructor Info
		$res = $DB->get_record('context', array('instanceid'=>$COURSE->id, 'contextlevel'=>50), "id");
		$context = $res->id;
		//echo 'CONTEXT = '.$context;
		$res = $DB->get_record('role_assignments', array('contextid'=>$context,'roleid'=>3), 'userid',IGNORE_MULTIPLE);
		$instructor = $res->userid;
		
		//Getting Mail Module instance
		$res = $DB->get_record('course_modules', array('course'=>$COURSE->id, 'module'=>27), 'id', IGNORE_MULTIPLE);
		$mailboxLink = '<a href="http://moodle.wosc.edu/mod/mail/view.php?id=' . $res->id . '">Course Email</a>';

		//echo 'USERID = '.$instructor;
		$instInfo = $DB->get_record('user', array('id'=>$instructor));
		$courseTitle = preg_replace('/\d[A-z]\d\d\d\:/','',$COURSE->fullname);

		if($instInfo->phone1 != ''){
                        $phone1 = 'Phone - '.$instInfo->phone1.'</br>';
                }
                if($instInfo->phone2 != ''){
                        $phone2 = 'Phone - '.$instInfo->phone2.'</br>';
                }
		
		if($vid == ''){
			$picture = print_user_picture($instInfo,$COURSE->id,NULL,200,true,true,'',true);
			$vid = $picture;
		}
		$block = '

<div style="width:98%; padding: 2px; align: center; margin-left:auto; margin-right:auto; list-style-type:none; max-width: 1024px;" id="sch-border"><center>

						<!-- ***************************** Course Title / Description ********************** -->
	<div style="width: 90%">
	<p style="margin-top: 25px;">
	<h4 style="text-decoration: underline;">Welcome to '.$courseTitle.'</h4>
	'.$COURSE->summary.' </p>
</div><!-- *** END Course Info div *** -->
						<!-- *********************END Course Title / Description*********************** -->

<hr style="color:#dcd0a0; width:90%;" size="2" />

						<!-- ************************** Vid/Pic -- Instructor Info ********************** -->
<div style="margin-top: 8px; width: 50%; float:left;" id="sch-img-vid">
	<p style="text-align: center; margin-right: 20px; margin-left: 20px;">
		'.$vid.'
	</p>
</div><!-- *** END Vid/Pic div *** -->
						<!-- *********************END VIDEO/PICTURE HERE*********************** -->
<div style="padding-top: 20px; width: 45%; float:right; min-width: 190px; margin-right: 10px;" id="sch-inst-info">
	<span style="color: #000000; font-weight: bold;">Instructor - '.$instInfo->firstname.' '.$instInfo->lastname.'</span>
		<br />
	<span style="color: #FF0000;">'.$phone1.' '.$phone2.'
		E-mail - '.$mailboxLink.'</span>
		<br />
		<a title="Syllabus" href="'.$syllabusLink.'" target="_blank"><span class="button-blue">Syllabus</span></a>
		<br />
		Western Oklahoma State College is on <span style="font-weight: bold;">Central Standard Time</span></p>
		'.$feedback.'
	<!--
	<span style="font-weight: bold; font-size: x-large;" size="5">Please Complete:</span>
		<br style="font-weight: bold;" />
		<a style="font-weight: bold;" title="Feedback"
href="https://docs.google.com/a/newmoodle.wosc.edu/spreadsheet/viewform?hl=en_US&amp;formkey=dDBnTEt4ejNrMEFiQXNzSEpCeVZ5UkE6MQ#gid=0" target="_blank">Intersession Feedback Form</a>
	-->
</div><!-- *** END Instructor Info div *** -->
<div style="clear: both;"></div>

<hr style="color:#dcd0a0; width:90%;" size="2" />

						<!-- ***************************** Course Resources ********************** -->
<div style="width: 50%; float:left; align: top;" id="sch-resources">
	<h6>Common Resources</h6>
	<ul style="list-style-type:none;">
		<li><a title="Campus Connect" href="https://admin.wosc.edu/cc3/gui_sis.html" target="_blank">Campus Connect Account </a></li>
		<li><a title="WOSC" href="http://www.tutor.com/wosc" target="_blank">24/7 Free Online Tutoring</a></li>
		<li><a title="Book Store" href="http://www.wosc.edu/index.php?page=student-store" target="_blank">Book Store</a></li>
		<li><a title="LRC" href="http://www.wosc.edu/library" target="_blank">Library </a></li>
	</ul>
</div><!-- *** END Course Resources div *** -->
						<!-- ***************************** Technical Help ********************** -->
<div style="width: 50%; float:right; align: top; min-width: 180px; " id="sch-resources">
	<h6>Need Technical help?</h6>
	<ul style="list-style-type:none;">
		<li><a title="moodle support" href="http://wosc.edu/help" target="_blank">Moodle Technical Support </a></li>
		<li><a title="ADA" href="http://wosc.edu/index.php?page=counseling#disabilities" target="_blank">ADA Compliance for WOSC </a></li>
		<li><a title="IT Helpdesk (For technical assistance)" href="http://wosc.edu/it" target="_blank">IT Helpdesk</a></li>
	</ul>
</div><!-- *** END Technical Help div *** -->
						<div style="clear: both;"></div>
</center></div>
						<!-- ***************************** End Common Header ********************** -->
 
			 
 			';

		return $block;
		
	}
    public function filter($text, array $options = array()) {
	  
 
		$block = preg_replace_callback('/\[courseheader.*\]/', array($this,'replace_stuff'),$text);
	
		return preg_replace('/\[courseheader.*\]/',$block,$text);
	
	}
	
	
}
		
?>
