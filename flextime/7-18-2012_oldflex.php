<?php
require_once('../config.php');
require_login($course, true, $cm);
global $USER;
$username = $USER->username;

$fp = fopen("flex.csv",'r');
$line = fgets($fp);


/*
// browser res detection
if(!isset($_GET['r']))     
{     
echo "<script language=\"JavaScript\">     
<!--      
document.location=\"$PHP_SELF?r=1&width=\"+screen.width+\"&Height=\"+screen.height;     
//-->     
</script>";     
}     
else {         

// Code to be displayed if resolutoin is detected     
     if(isset($_GET['width']) && isset($_GET['Height'])) {     
               // Resolution  detected     
     }     
     else {     
               // Resolution not detected     
     }     
}
*/
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head>';
/*echo '<script type="text/javascript">
<!-- 
if (screen.width <= 699) { 
document.location = "http://wosc.edu/mobile/flex.php";
}
//--> 
</script>';*/
echo '<link rel="shortcut icon" href="http://wosc.edu/img/icons/woscani.gif" type="image/x-icon"/> <title>FLEX Appeal</title>';
echo '<style language="stylesheet">
div#style {width: 720px; position: absolute; padding: 0 150px; top: 160px; margin: 0 auto;} 
html { margin: 0 auto; #border: 5px solid darkgreen; font-family: Verdana; background: #dcd0a0; #width: 700px; #margin: 0 auto;} ';
echo '
table.tech tbody tr:nth-child(odd) { background-color: #E0D3A8; }
table.tech tbody tr:nth-child(even) { background-color: #EADCAD; } 
table.tech {font-size: 14px; border-width: 0px; border-spacing: 0px; border-style: solid; border-color: #005000; border-collapse: separate;} 
table.tech td {border-style: hidden;  padding: 2px 7px;} 
table.tech tbody tr:hover {background-color: #dcd0a0;} 
table.tech th {background-color: #ccc; color: black; padding: 9px 16px; -moz-border-radius:10px; -webkit-border-top-left-radius:10px; border-top-left-radius:10px; border-top-right-radius:10px;} .last tr {-moz-border-radius:10px; -webkit-border-bottom-left-radius:10px; border-bottom-left-radius:10px; border-bottom-right-radius:10px;}';
echo '.TH {font-size: 19px;text-shadow: 2px 2px 5px grey; -moz-text-shadow:2px 2px 5px grey; -webkit-text-shadow:2px 2px 5px grey; -o-text-shadow:2px 2px 5px grey; -ms-text-shadow:2px 2px 5px grey;}';
echo 'div#round {background-color: #dcd0a0; padding-left:10px;padding-right: 10px;padding-bottom: 10px; width: 88%; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px; border: 1px solid black;}';
echo '#white{padding:10px;border: 2px ridge #dcd0a0;background-color:white;-moz-border-radius: 10px;-webkit-border-radius: 10px;border-radius: 10px;-o-border-radius: 10px;-ms-border-radius: 10px;-moz-box-shadow: inset 0 0 15px #CEC298;-webkit-box-shadow: inset 0 0 15px #CEC298;box-shadow: inset 0 0 15px #CEC298;-o-box-shadow: inset 0 0 15px #CEC298;-ms-box-shadow: inset 0 0 15px #CEC298;}</style>';
echo '
<link rel="stylesheet" type="text/css" media="screen" href="http://www.wosc.edu//stylesheet.php?cssid=191&amp;mediatype=screen" />
<link rel="stylesheet" type="text/css" media="screen" href="http://www.wosc.edu//stylesheet.php?cssid=184&amp;mediatype=screen" />
<link rel="stylesheet" type="text/css" media="screen" href="http://www.wosc.edu//stylesheet.php?cssid=178&amp;mediatype=screen" />
<link rel="stylesheet" type="text/css" media="screen" href="http://www.wosc.edu//stylesheet.php?cssid=179&amp;mediatype=screen" />
<link rel="stylesheet" type="text/css" media="all,screen" href="http://www.wosc.edu//stylesheet.php?cssid=214&amp;mediatype=all,screen" />
';
echo '</head><body>';


echo '
<div class="headwrap">

	<div class="container_12 header">

    	

        <div class="grid_8 logo">
        

<a href="./"><img title="WOSC Home Page" alt="WOSC Webpage Logo Header"  src="http://wosc.edu/moodle2x/2xheader-seal.png" align="left"></a>

<a href="./"><img alt="WOSC Webpage Logo Header" title="WOSC Home Page" class="header-name" src="http://wosc.edu/moodle2x/2xheader-name.png" align="left"></a>

                    
        </div><!--/logo-->


        
        <div class="grid_4 last h-details">
        
        	<div class="logged-in">
            

<span class="toprightlinks logout"> </span>
            
            </div><!--/logged-in-->
        
   <div id="rightheader">
<div class="logindiv" align="right" >

</div> <!-- logindiv -->
</div> <!-- rightheader -->

        </div><!--/hdetails-->
        
        <div class="container_12 nav">
		
<!-- ####################################### -->
<!-- ########### Just For Moodle ########### -->
<!-- ####################################### -->

<div id="wosctopmenu">

<div class="grids-24" id="main-nav"> 
     <div class="grid-24"> 
	  <ul class="navigation">
<!-- ********************************************************** -->
<!-- ********************************************************** -->
                <li><a href="http://www.wosc.edu/index.php?page=about-wosc">About WOSC</a>
<ul >
<li><a href="http://www.wosc.edu/index.php?page=About-WOSC" title="Westerns Mission, History and Purpose">Mission, History & Purpose</a></li>
<li><a href="http://www.wosc.edu/index.php?page=HEA" title="Important Institution Information">Institutional Information</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Office-of-the-President" title="Office of the President">President & Leadership</a></li>
<li><a href="http://www.wosc.edu/index.php?page=WOSC-Board-of-Regents" title="WOSC Board of Regents">Board of Regents</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Jobs" title="Employment (Job) Opportunities">Job Opportunities</a></li>
<li><a href="http://OKHigherEd.org" title="Oklahoma State Regents for Higher Education" target="_blank">Oklahoma State Regents <br />for Higher Education</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Visiting-WOSC" title="2801 N Main, Altus, OK 73521">Campus Map & Area</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Campus-Life" title="Campus Life">Campus Life</a></li>
</ul>
                </li>
<!-- ********************************************************** -->
<!-- ********************************************************** -->
                <li><a href="http://www.wosc.edu/enroll">Enrollment!</a>
<ul >
<li><a href="http://www.wosc.edu/apply" title="Online Application for Admissions"><strong>Apply to Western</strong></a></li>
<li><a href="http://www.wosc.edu/admissions" title="Admissions">Admissions</a></li>
<li><a href="http://www.wosc.edu/finaid" title="Financial Aid">Financial Aid</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Business-Affairs" title="Business Affairs">Business Affairs</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Tuition-Fees" title="Tuition and Fees">Tuition and Fees</a></li>
<li><a href="http://www.wosc.edu/index.php?page=College-Catalog" title="The Western Oklahoma State College Catalog"> COLLEGE CATALOG <br />& Degree Plans</a></li>
<li><a href="http://intersession.wosc.edu" title="Intersession, Westerns 10 day classes during the Spring, Summer, and Fall Semester.">INTERSESSION</a></li>
<li><a href="http://www.wosc.edu/courseschedule" title="Course Schedule">COURSE SCHEDULE</a></li>
</ul>
                </li>
<!-- ********************************************************** -->
<!-- ********************************************************** -->
                <li><a href="http://www.wosc.edu/index.php?page=current-students">Current Students</a>
<ul >
<li><a href="https://admin.wosc.edu/cc3/gui_sis.html" title="Campus Connect" target="_blank"><center><strong>Campus Connect</strong> <br />(Enroll / Pay / Schedule / Grades)</center></a></li>
<li><a href="https://moodle2.wosc.edu" title="Moodle / Student E-mail"><center><strong>Moodle</strong> <br />(Online Classes / Email)</center></a></li>
<li><a href="http://www.wosc.edu/library" title="Library (LRC)">Library (LRC)</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Student-Services" title="Student Services">Student Services</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Student-Organizations" title="Student Organizations">Student Organizations</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Degree-Program-Pages" title="Department & Program Pages">  Dept. / Program Pages</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Academic-Event-Calendar" title="Academic &amp; Event Calendar">Event Calendar</a></li>
</ul>
				</li>
<!-- ********************************************************** -->
<!-- ********************************************************** -->
		<li><a href="http://www.wosc.edu/index.php?page=academics">Academics</a>
<ul >
<li><a href="http://www.wosc.edu/index.php?page=A-Z-Directory" title="A-Z Employee Directory"> A-Z Employee Directory</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Military-Students" title="FAQs for Military Students"> Military Students</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Articulation-Agreement" title="Articulation Agreement"> Articulation Agreements</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Cooperative-Alliances" title="Cooperative Alliances"> Cooperative Alliances</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Distance-Learning" title="Distance Learning"> Distance Learning</a></li>
<li><a href="http://www.wosc.edu/it" title="Information Technology"> Information Technology</a></li>
<li><a href="http://www.wosc.edu/index.php?page=Institutional-Research" title="Institutional Research and Reports"> Research & Reports</a></li>
</ul>
                </li>
<!-- ********************************************************** -->
<!-- ********************************************************** -->
                <li><a href="http://www.wosc.edu/index.php?page=pioneer-sports">Pioneer Sports</a>
<ul >
<li><a href="http://www.woscbaseball.com" title="Baseball">Baseball</a></li>
<li><a href="http://www.hometeamsonline.com/teams/?u=WOSCHOOPS&amp;s=basketball&amp;t=c" title="Mens Basketball">Basketball, Mens</a></li>
<li><a href="http://www.hometeamsonline.com/teams/?u=WOSCLADYHOOPS&amp;t=c&amp;s=basketball&amp;p=home" title="Womens Basketball">Basketball, Womens</a></li>
<li><a href="http://www.wosc.edu/index.php?page=cheerleading" title="Cheerleading">Cheerleading</a></li>
<li><a href="http://www.wosc.edu/index.php?page=golf" title="Golf">Golf</a></li>
<li><a href="http://www.woscrodeo.com" title="Rodeo">Rodeo</a></li>
<li><a href="http://www.hometeamsonline.com/teams/Default.asp?u=wosc&amp;s=softball&amp;t=c" title="Softball">Softball</a></li>
<li><hr/></li>
<li><a href="http://www.wosc.edu/sports">Sports schedules</a></li>
</ul>
                </li>
<!-- ********************************************************** -->
<!-- ********************************************************** -->
                <li><a href="http://www.wosc.edu/index.php?page=alumni-and-friends">Alumni & Community</a>
<ul >
<li><a href="http://www.wosc.edu/index.php?page=alumni-association" title="Alumni Association">Alumni & Friends</a></li>
<li><a href="http://www.wosc.edu/index.php?page=wosc-foundation-inc" title="WOSC Foundation, Inc. & Scholarships">Foundation & Scholarships</a></li>
<li><a href="http://www.altuschamber.com/" title="Altus Community" target="_blank"> Altus Community</a></li>
<li><a href="http://www.wosc.edu/index.php?page=community-education" title="Community Education"> Community Education</a></li>
<li><a href="http://www.wosc.edu/index.php?page=concurrent-students" title="Concurrent Enrollment"> Concurrent Enrollment</a></li>
<li><a href="http://artdept.wosc.edu" title="WOSC Student Art" target="_blank"> WOSC Student Art</a></li>
<li><a href="http://www.wosc.edu/index.php?page=upward-bound" title="Upward Bound"> Upward Bound</a></li>
<li><a href="http://www.wosc.edu/index.php?page=visiting-wosc" title="Visiting WOSC"> Visiting WOSC</a></li>
</ul>
                </li>
<!-- ********************************************************** -->
<!-- ********************************************************** -->
<li><a href="index.php?page=contact-us"><img src="http://wosc.edu/img/icons/search.gif" title="Search Westerns Website" alt="search" style="padding:0; margin: -5px;"></a>
<ul style="width:160px;margin-left:-100px;">
<li style="padding-left:13px;padding-bottom:5px;">
    <form id="cntnt01moduleform_1" method="get" action="http://www.wosc.edu/index.php?page=contact-us" class="cms_form">
<div class="hidden">
<input type="hidden" name="mact" value="Search,cntnt01,dosearch,0" />
<input type="hidden" name="cntnt01returnid" value="15" />
</div>
    <label for="cntnt01searchinput"></label><input type="text" id="cntnt01searchinput2" name="cntnt01searchinput" size="15" maxlength="50" value="Search Western..." onfocus="if(this.value==this.defaultValue) this.value="";" onblur="if(this.value=="") this.value=this.defaultValue;"/>
</li>
</ul>
                </li>
<!-- ********************************************************** -->
<!-- ********************************************************** -->

	</ul> 
  </div> 
	<div class="clear"></div> 
</div>

</div>
		
		
        </div><!-- /container_12 nav -->

    </div><!-- /container_12 header -->

</div><!-- /headwrap -->

<div id="page">
<!-- Moodle2x Header -->

<!-- END OF HEADER -->
<div id="content" class="wrap wraplevel1 ">
<div id="content-bt" class="bt"><div>&nbsp;</div></div>
<div id="content-i1" class="i1"><div id="content-i2" class="i2"><div id="content-i3" class="i3">


';

//
//
//
 echo '<div id="style">

<p><img style="margin-left: 5px; margin-right: 5px;" title="Flex Appeal" src="http://wosc.edu/img/flex.png" alt="Flex Appeal" width="170" height="71" /></p>

<p><span style="font-size: medium;">
 &#8226; <a style="text-decoration: none; margin: 0px 10px 0pt 0pt;" title="All documents pertaining to Flex time." href="#forms"><strong>Contract &amp; Papers</strong></a>
 &nbsp;  &nbsp; &#8226; <a style="text-decoration: none; margin: 0px 10px 0pt 0pt;" href="http://wosc.edu/index.php?page=your-input-form"> Feedback  </a> 
 &nbsp;  &nbsp; &#8226; <a style="text-decoration: none; margin: 0px 10px 0pt 0pt;" href="#resources">Resources</a>
 &nbsp;  &nbsp; &#8226; <a style="text-decoration: none; margin: 0px 10px 0pt 0pt;" href="http://wosc.edu/index.php?page=suggest-a-workout-form">Suggest "workouts"</a>
 &nbsp;  &nbsp; &#8226; <a style="text-decoration: none; margin: 0px 10px 0pt 0pt;" href="#tracker"><strong>Flex Tracker!</strong></a></span></p>

<p><iframe id="white" src="http://docs.google.com/a/newmoodle.wosc.edu/spreadsheet/embeddedform?formkey=dFE0Wjg3d2FUTDFPYUJvdDhVZGRJNXc6MQ" frameborder="0" marginwidth="0" marginheight="0" width="699" height="850"></iframe></p>

<table style="width: 100%; margin-top: -30px" border="0" cellspacing="15" cellpadding="15" align="center">

<tbody>

<tr>

<td style="width: 66%;" valign="top">

<p><a name="forms"></a><img src="http://wosc.edu/modules/TruetypeText/cache/9286c9fc789d846c3a32e5eeccb76b45.gif" alt="The "  width="56" height="32"/><img src="http://wosc.edu/modules/TruetypeText/cache/783a67ff4a6619bc70dfefba5e527c2a.gif" alt="Papers "  width="93" height="32"/></p>

<ul>

<li><a title="Contract and Policy" href="http://wosc.edu/uploads/flex/Health%20and%20Wellness%20Policy%20Guidelines.pdf" target="_blank">Health and Wellness Contract and Policy Guidelines</a></li>

<li><a title="Liability" href="http://wosc.edu/uploads/flex/Waiver%20of%20Liability.pdf" target="_blank">Waiver of Liability</a></li>

<li><a title="Wellness Center Hours" href="http://wosc.edu/uploads/flex/Wellness%20Center%20Schedule%20Summer%202012.xlsx" target="_blank">Wellness Center hours</a></li>

<li><a title="Swimming Pool Hours" href="http://wosc.edu/uploads/flex/Pool%20Schedule%20Summer%202012.xlsx" target="_blank">Swimming Pool hours</a></li>

</ul>

</td>

<td style="width: 33%;" valign="top">

<p><a name="resources"></a><img src="http://wosc.edu/modules/TruetypeText/cache/fbc12d64a3073bdc49e16087797c1de3.gif" alt="Resources "  width="133" height="32"/></p>

<ul>

<li><a style="text-decoration: none; margin: 0px 20px 0pt 0pt;" href="http://www.freeworkoutsguide.com/index.html" target="_blank">Workout Guide</a></li>

<p> <em><em><img style="position: relative; bottom: 0pt; right: 0pt; margin: 20px 10px; float: right;" title="Western Seal" src="http://wosc.edu/img/seal90.png" alt="Western Seal" width="90" height="90" /></em></em></p>

</ul>

</td>

</tr>

</tbody>

</table>

<hr />

<p> </p>

<!-- <p><em style="float: right;">    MUST be signed in to <br />Moodle to view the Tracker.</em></p> -->

<p><a name="tracker"></a><img src="http://wosc.edu/modules/TruetypeText/cache/9ec08019fca05adb76271c07def8542f.gif" alt="Flex "  width="62" height="32"/><img src="http://wosc.edu/modules/TruetypeText/cache/d91492a395956d67f1b39c25317a93eb.gif" alt="Tracker "  width="109" height="32"/></p>
';


// *************************
// START OF TABLE
// *************************
echo '<div id="round"><table class="tech"><tbody>';
echo '<tr class="TH" style="background-color: #dcd0a0; ">';
//echo '<td style="text-align: left;padding:20px 12px 20px 5px;">SUBMIT TIME</td>';
echo '<td style="text-align: left;padding:10px 12px 8px 5px;">USER NAME</td>';
echo '<td style="text-align: left;padding:10px 12px 8px 5px;">TIME IN</td>';
echo '<td style="text-align: left;padding:10px 12px 8px 5px;">TIME OUT</td>';
echo '<td style="text-align: left;padding:10px 12px 8px 5px; color: darkgreen;">TIME USED</td>';
echo '<td style="text-align: left;padding:10px 12px 8px 5px;">DATE OF FLEX</td></tr>';

$rowNum = 1;

while(!feof($fp)){
	$line = fgets($fp);
	$flexInfo = explode(',',$line);
	$rowNum++;
	$flexInfo[9] = $rowNum;
	//$startTime = new DateTime($flexInfo[4]);
	//$endTime = new DateTime($flexInfo[5]);
        //$timeDiff = $startTime->diff($endTime);

	//echo "Start time = $startTime, End Time = $endTime, Date Difference = $timeDiff"; 
	
	// Supervisor or President
	if($flexInfo[1] == $USER->username.'@newmoodle.wosc.edu') {
		printPersonalInfo($flexInfo);
	}
	if(($flexInfo[3] == $USER->username) || ($USER->username == "phil.birdine")) {
		printInfo($flexInfo);
	}
		
        if(($USER->username == "lisa.greenlee") && (
			($flexInfo[3] == "steve.prater") || 
			($flexInfo[3] == "jason.morrison") || 
			($flexInfo[3] == "chrystal.overton") || 
			($flexInfo[3] == "chad.wiginton") || 
			($flexInfo[3] == "suzanne.rooker"))) {
        	printInfo($flexInfo);
	}

        if(($USER->username == "tricia.latham") && (
                        ($flexInfo[3] == "doyle.jenks"))) {
                printInfo($flexInfo);
        }

}

$time = $flexInfo[5] - $flexInfo[4];
//var_dump ($time);

//HTML goese here

function printInfo($flexInfo){

	//SUBMIT TIME
	//$flexD = explode('2012',$flexInfo[0]);
	//echo '<tr><td style="text-align: left;" valign="bottom">'.$flexD[0].'</td>';
	//USERNAME
	$flexer = explode('@',$flexInfo[1]);
	echo '<td style="text-align: left; padding: 2px 12px 0px 10px;" valign="bottom">'.$flexer[0].'</td>';
	//TIME IN
	echo '<td style="text-align: left;padding: 2px 12px 0px 10px;" valign="bottom">'.$flexInfo[4].'</td>';
	//TIME OUT
	echo '<td style="text-align: left;padding: 2px 12px 0px 10px;" valign="bottom">'.$flexInfo[5].'</td>';
	//Time Used
	echo '<td style="text-align: left;padding: 2px 2px 0px 10px; color: darkgreen;" valign="bottom">'.$flexInfo[8].'</td>';
	//DATE FLEX WAS USED
	echo '<td style="text-align: left;padding: 2px 2px 0px 10px;" valign="bottom">'.$flexInfo[6].'</td></tr>';

	//Straight data
	//	echo "$flexInfo[0], $flexInfo[1], $flexInfo[3], $flexInfo[4], $flexInfo[5], $flexInfo[6]<br>";
}

function printPersonalInfo($flexInfo){

        //SUBMIT TIME
        //$flexD = explode('2012',$flexInfo[0]);
        //echo '<tr><td style="text-align: left;" valign="bottom">'.$flexD[0].'</td>';
        //USERNAME
        $flexer = explode('@',$flexInfo[1]);
        echo '<td style="text-align: left; padding: 2px 12px 0px 10px;" valign="bottom"><a target="_blank" href="personal.php?row='.$flexInfo[9].'">'.$flexer[0].'</a></td>';
        //TIME IN
        echo '<td style="text-align: left;padding: 2px 12px 0px 10px;" valign="bottom">'.$flexInfo[4].'</td>';
        //TIME OUT
        echo '<td style="text-align: left;padding: 2px 12px 0px 10px;" valign="bottom">'.$flexInfo[5].'</td>';
        //Time Used
        echo '<td style="text-align: left;padding: 2px 2px 0px 10px; color: darkgreen;" valign="bottom">'.$flexInfo[8].'</td>';
        //DATE FLEX WAS USED
        echo '<td style="text-align: left;padding: 2px 2px 0px 10px;" valign="bottom">'.$flexInfo[6].'</td></tr>';

        //Straight data
        //      echo "$flexInfo[0], $flexInfo[1], $flexInfo[3], $flexInfo[4], $flexInfo[5], $flexInfo[6]<br>";
}



echo '</tr>';
echo '</tbody></table></div>';

echo '<p><em><br />Bookmark this form on your phone!</em><a title="URL for your Mobile device" href="http://goo.gl/gRyQ2" target="_blank">
<img id="white" style="margin-right: 10px; margin-left: 10px; float:left;" title="Flex Time Link to Form (MUST BE SIGNED IN TO YOUR EMAIL ON YOUR PHONES BROWSER))" src="http://chart.googleapis.com/chart?cht=qr&amp;chs=100x100&amp;choe=UTF-8&amp;chld=H%7C0&amp;chl=http://goo.gl/gRyQ2" alt="flex qr code" width="150" height="150" /></a></p>

<p><strong><br /></strong></p>

<p><strong>MUST be signed in to your WOSC Email on your phones browser.</strong></p> <br /><br />';

echo '</div></body></html>';

/*$server = substr(gethostname(), -1);
echo 'Host: .'$server'.; */

/* echo '
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-10130365-1");
pageTracker._trackPageview();
} catch(err) {}</script>
';*/


fclose($fp);


p
?>
