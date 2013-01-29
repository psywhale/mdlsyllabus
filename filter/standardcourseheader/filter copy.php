<?php

class filter_helloworld extends moodle_text_filter {
	

    public function filter($text, array $options = array()) {
	global $COURSE, $DB;    
 
	// Lets get the context id
	if(preg_match("/\[courseheader\]/",$text)){
    
		$res = $DB->get_record('context', array('instanceid'=>$COURSE->id, 'contextlevel'=>50), "id");
		$context = $res->id;
		echo 'CONTEXT = '.$context;
		$res = $DB->get_record('role_assignments', array('contextid'=>$context,'roleid'=>3), 'userid');
		$instructor = $res->userid;
		echo 'USERID = '.$instructor;
		$instInfo = $DB->get_record('user', array('id'=>$instructor));
    	$block = '
 <div style="margin: 10px;" id="galleryviewborder"><center>
<table style="text-align: left; width: 99%; height: 495px;" border="0" cellpadding="1" cellspacing="1">
<tbody>
<tr>
<td style="height: 200px; width: 347px;"><br /><center><!-- *********************INSERT VIDEO/PICTURE HERE*********************** --><iframe style="max-width: 320px;" wmode="Opaque" src="'.$COURSE->idnumber.'" title="YouTube video player" frameborder="0" height="212" width="100%"></iframe><br /><br />
<table style="width: 95%;" border="0">
<tbody>
<tr>
<td style="text-align: center;">
<p style="text-align: center;"><span style="color: #ff0000;"><span style="color: #000000;">Instructor - '.$instInfo->firstname.' '.$instInfo->lastname.'</span><br />Phone - '.$instInfo->phone1.'<br />E-mail - '.$instInfo->email.'</span><br />Western Oklahoma State College is on <span style="font-weight: bold;">Central Standard Time</span></p>
<span style="font-weight: bold; font-size: x-large;" class="Apple-style-span" size="5">Please Complete:</span><br style="font-weight: bold;" /><a style="font-weight: bold;" title="Feedback" href="https://docs.google.com/a/newmoodle.wosc.edu/spreadsheet/viewform?hl=en_US&amp;formkey=dDBnTEt4ejNrMEFiQXNzSEpCeVZ5UkE6MQ#gid=0" target="_blank">Intersession Feedback Form</a></td>
</tr>
</tbody>
</table>
<!-- *********************END VIDEO/PICTURE HERE*********************** --></center></td>
<td style="height: 200px; width: 313px; text-align: center;">
<p style="text-align: center;"><br /><span><br /></span><small><span><big><span><span size="3"><span style="text-decoration: underline;"><span style="font-size: medium;" size="4"><b>Welcome to '.$COURSE->fullname.'</b></span></span></span><br /></span></big></span></small><span style="font-size: small;"></span></p>
'.$COURSE->summary.'
<p><b><span style="text-decoration: underline;"><br /></span></b></p>
<p><br /><!-- End Extra Course Info --><!-- ***************************** start 1st steps ********************** --></p>
<div id="ststeps"><small><big><br /><br /><br /></big></small><small><big></big></small><ol>
<li style="text-align: left;"><small><big><a title="Syllabus" href="http://moodle.wosc.edu/mod/page/view.php?id=27511" target="_blank"><span class="nolink">Syllabus</span></a><a title="Syllabus" href="http://moodle.wosc.edu/mod/resource/view.php?id=46727"></a></big></small></li>
<li style="text-align: left;"><small><big><a title="Browser Check Up" href="http://wosc.edu/index.php?page=browser" target="_blank">Computer Check Up</a></big></small></li>
<li style="text-align: left;"><a href="#section-1"><small><big>Start Section 1</big></small></a></li>
</ol><small><big></big></small></div>
<p><!-- ***************************** end 1st steps ********************** --></p>
<p></p>
</td>
</tr>
<tr>
<td colspan="2"><hr style="color: #000000;" width="85%" /></td>
</tr>
<tr valign="top">
<td style="width: 347px;"><small><big><span><b></b></span></big></small><center>
<table style="width: 95%;" border="0">
<tbody>
<tr>
<td valign="top" width="100%"><span class="Apple-style-span"><small><big><span></span><!-- ***************************** Course Resources ********************** --><span style="font-weight: bold;"></span></big></small></span>
<blockquote style="margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 40px; border-style: none; padding: 0px;" class="webkit-indent-blockquote"><small><small><big><span></span></big><big><span><big><span style="font-weight: bold;">Common Resources</span><br /></big></span></big></small></small>
<ul>
<li><a title="Campus Connect" href="https://admin.wosc.edu/cc3/gui_sis.html" target="_blank">Campus Connect Account </a></li>
<li><a title="email" href="https://mail.google.com/a/email.wosc.edu" target="_blank">WOSC Email Account </a></li>
<li><a title="WOSC" href="http://www.wosc.edu" target="_blank">WOSC Website</a></li>
<li><a title="Book Store" href="http://www.wosc.edu/index.php?page=student-store" target="_blank">Book Store</a></li>
<li><a title="LRC" href="http://www.wosc.edu/library" target="_blank">Library </a></li>
</ul>
<small><big><span><big></big></span></big></small></blockquote>
<big></big></td>
</tr>
</tbody>
</table>
<small><big><b><br /></b></big></small></center></td>
<td style="width: 313px;">
<table style="width: 95%;" align="center" border="0">
<tbody><!-- ***************************** Technical Help ********************** -->
<tr>
<td valign="top" width="100%"><span style="font-weight: bold;">Need Technical help?</span><br />
<ul>
<li><a title="moodle support" href="http://wosc.edu/help" target="_blank">Moodle Technical Support </a></li>
<li><a title="ADA" href="http://wosc.edu/index.php?page=counseling#disabilities" target="_blank">ADA Compliance for WOSC </a></li>
<li><a title="IT Helpdesk (For technical assistance)" href="http://wosc.edu/it" target="_blank">IT Helpdesk</a></li>
</ul>
<!-- ***************************** End Technical Help ********************** --><!-- ***************************** Common Resources ********************** --><span style="font-weight: bold;"></span><!-- ***************************** End Common Resources ********************** --></td>
</tr>
</tbody>
</table>
<center></center></td>
</tr>
</tbody>
</table>
</center></div>
<p><span style="color: #888888;"><!-- ***************************** End Common Header ********************** --></span></p>
 
 ';
 
        return str_replace('[courseheader]', $block, $text);
	}
    else
    {
    	return $text;
    }   
}
}
 
?>