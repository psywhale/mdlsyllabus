<?php
require_once('../config.php');
require_login($course, true, $cm);
global $USER;
$username = $USER->username;

$fp = fopen("flex.csv",'r');
$line = fgets($fp);



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

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head>';
/*echo '<script type="text/javascript">
<!-- 
if (screen.width <= 699) { 
document.location = "http://wosc.edu/mobile/flex.php";
}
//--> 
</script>';*/
echo '<link rel="shortcut icon" href="http://wosc.edu/img/icons/woscani.gif" type="image/x-icon"/> <title>FLEX Appeal</title>';
echo '<style language="stylesheet">div#style {width: 720px; margin: 0 auto;} html { border: 5px solid darkgreen; font-family: Verdana; background: #dcd0a0; #width: 700px; #margin: 0 auto;}table.tech tbody tr:nth-child(odd) { background-color: #E0D3A8; }table.tech tbody tr:nth-child(even) { background-color: #EADCAD; } ';
echo 'table.tech {font-size: 14px; border-width: 0px; border-spacing: 0px; border-style: solid; border-color: #005000; border-collapse: separate;} table.tech td {border-style: hidden;  padding: 2px 7px;} table.tech tbody tr:hover {background-color: #dcd0a0;} table.tech th {background-color: #ccc; color: black; padding: 9px 16px; -moz-border-radius:10px; -webkit-border-top-left-radius:10px; border-top-left-radius:10px; border-top-right-radius:10px;} .last tr {-moz-border-radius:10px; -webkit-border-bottom-left-radius:10px; border-bottom-left-radius:10px; border-bottom-right-radius:10px;}';
echo '.TH {font-size: 19px;text-shadow: 2px 2px 5px grey; -moz-text-shadow:2px 2px 5px grey; -webkit-text-shadow:2px 2px 5px grey; -o-text-shadow:2px 2px 5px grey; -ms-text-shadow:2px 2px 5px grey;}';
echo 'div#round {background-color: #dcd0a0; padding-left:10px;padding-right: 10px;padding-bottom: 10px; width: 88%; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px; border: 1px solid black;}';
echo '#white{padding:10px;border: 2px ridge #dcd0a0;background-color:white;-moz-border-radius: 10px;-webkit-border-radius: 10px;border-radius: 10px;-o-border-radius: 10px;-ms-border-radius: 10px;-moz-box-shadow: inset 0 0 15px #CEC298;-webkit-box-shadow: inset 0 0 15px #CEC298;box-shadow: inset 0 0 15px #CEC298;-o-box-shadow: inset 0 0 15px #CEC298;-ms-box-shadow: inset 0 0 15px #CEC298;}</style>';
echo '</head><body>';

//
//
//
 echo '<div id="style"><p><em style="float: right;"> MUST be signed in <br />to your WOSC E-mail.</em></p>

<p><img style="margin-left: 5px; margin-right: 5px;" title="Flex Appeal" src="http://wosc.edu/img/flex.png" alt="Flex Appeal" width="170" height="71" /></p>

<p><span style="font-size: medium;">.  <a style="text-decoration: none; margin: 0px 10px 0pt 0pt;" title="All documents pertaining to Flex time." href="#forms">Contract &amp; Papers</a>.  <a style="text-decoration: none; margin: 0px 10px 0pt 0pt;" href="http://wosc.edu/index.php?page=your-input-form"> Feedback  </a> .  <a style="text-decoration: none; margin: 0px 10px 0pt 0pt;" href="#resources">Resources</a>.  <a style="text-decoration: none; margin: 0px 10px 0pt 0pt;" href="http://wosc.edu/index.php?page=suggest-a-workout-form">Suggest "workouts"</a>. <a style="text-decoration: none; margin: 0px 10px 0pt 0pt;" href="#tracker">Flex Tracker!</a></span></p>

<p><iframe id="white" src="http://docs.google.com/a/newmoodle.wosc.edu/spreadsheet/embeddedform?formkey=dFE0Wjg3d2FUTDFPYUJvdDhVZGRJNXc6MQ" frameborder="0" marginwidth="0" marginheight="0" width="699" height="640"></iframe></p>

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



while(!feof($fp)){
	$line = fgets($fp);
	$flexInfo = explode(',',$line);

	//$startTime = new DateTime($flexInfo[4]);
	//$endTime = new DateTime($flexInfo[5]);
        //$timeDiff = $startTime->diff($endTime);

	//echo "Start time = $startTime, End Time = $endTime, Date Difference = $timeDiff"; 
	
	// Supervisor or President
	if(($flexInfo[3] == $USER->username) || ($USER->username == "phil.birdine") || ($flexInfo[1] == $USER->username.'@newmoodle.wosc.edu')) {
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
echo '<td style="text-align: left;padding: 2px 2px 0px 10px; color: darkgreen;" valign="bottom">'.$flexInfo[7].'</td>';
//DATE FLEX WAS USED
echo '<td style="text-align: left;padding: 2px 2px 0px 10px;" valign="bottom">'.$flexInfo[6].'</td></tr>';

//Straight data
//	echo "$flexInfo[0], $flexInfo[1], $flexInfo[3], $flexInfo[4], $flexInfo[5], $flexInfo[6]<br>";
}

echo '</tr>';
echo '</tbody></table></div>';

echo '<p><em><br />Bookmark this form on your phone!</em><a title="URL for your Mobile device" href="http://goo.gl/gRyQ2" target="_blank">
<img id="white" style="margin-right: 10px; margin-left: 10px; float:left;" title="Flex Time Link to Form (MUST BE SIGNED IN TO YOUR EMAIL ON YOUR PHONES BROWSER))" src="http://chart.googleapis.com/chart?cht=qr&amp;chs=100x100&amp;choe=UTF-8&amp;chld=H%7C0&amp;chl=http://goo.gl/gRyQ2" alt="flex qr code" width="150" height="150" /></a></p>

<p><strong><br /></strong></p>

<p><strong>MUST be signed in to your WOSC Email on your phones browser.</strong></p> <br /><br />';

echo '</div></body></html>';

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


?>
