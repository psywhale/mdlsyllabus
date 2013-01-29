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
html { margin: 0 auto; #border: 5px solid darkgreen; font-family: Verdana; background: #dcd0a0; width: 450px; #margin: 0 auto;} ';
echo '
table.tech tbody tr:nth-child(odd) { background-color: #E0D3A8; width:100% }
table.tech tbody tr:nth-child(even) { background-color: #EADCAD; } 
table.tech {font-size: 14px; border-width: 0px; border-spacing: 0px; border-style: solid; border-color: #005000; border-collapse: separate;} 
table.tech td {border-style: hidden;  padding: 2px 7px;} 
table.tech tbody tr:hover {background-color: #dcd0a0;} 
table.tech th {background-color: #ccc; color: black; padding: 9px 16px; -moz-border-radius:10px; -webkit-border-top-left-radius:10px; border-top-left-radius:10px; border-top-right-radius:10px;} .last tr {-moz-border-radius:10px; -webkit-border-bottom-left-radius:10px; border-bottom-left-radius:10px; border-bottom-right-radius:10px;}';
echo '.TH {font-size: 19px;text-shadow: 2px 2px 5px grey; -moz-text-shadow:2px 2px 5px grey; -webkit-text-shadow:2px 2px 5px grey; -o-text-shadow:2px 2px 5px grey; -ms-text-shadow:2px 2px 5px grey;}';
echo 'div#round {background-color: #dcd0a0; padding-left:10px;padding-right: 10px;padding-bottom: 10px; width: 88%; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px; border: 1px solid black;}';
echo '#white{padding:10px;border: 2px ridge #dcd0a0;background-color:white;-moz-border-radius: 10px;-webkit-border-radius: 10px;border-radius: 10px;-o-border-radius: 10px;-ms-border-radius: 10px;-moz-box-shadow: inset 0 0 15px #CEC298;-webkit-box-shadow: inset 0 0 15px #CEC298;box-shadow: inset 0 0 15px #CEC298;-o-box-shadow: inset 0 0 15px #CEC298;-ms-box-shadow: inset 0 0 15px #CEC298;}';
echo '</style>';

echo '<DIV id=overDiv style="Z-INDEX: 1000; VISIBILITY: hidden; POSITION: absolute"></DIV>';

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
	$flexInfo = str_getcsv($line,',','"');
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
        echo '<td style="text-align: left; padding: 2px 12px 0px 10px;" valign="bottom"><a href="mailto:'.$flexer[0].'@wosc.edu?subject=Flex Time" title="Email '.$flexer[0].'">'.$flexer[0].'</a>';
        //TIME IN
        echo '<td style="text-align: left;padding: 2px 12px 0px 10px;" valign="bottom">'.$flexInfo[4].'</td>';
        //TIME OUT
        echo '<td style="text-align: left;padding: 2px 12px 0px 10px;" valign="bottom">'.$flexInfo[5].'</td>';
        //Time Used
        echo '<td style="text-align: left;padding: 2px 2px 0px 10px; color: darkgreen;" valign="bottom">'.$flexInfo[8].'</td>';
        //DATE FLEX WAS USED
        echo '<td style="text-align: left;padding: 2px 2px 0px 10px;" valign="bottom">'.$flexInfo[6].'';
 if($flexInfo[7] != ""){
       	echo '<span style="float: right;">
<a onclick="window.open(\'personal.php?row='.$flexInfo[9].'\',\'Your Notes for '.$flexInfo[6].'\',\'resizable=yes,status=yes,width=300,height=200,left=\'+(screen.availWidth/2-150)+\',top=\'+(screen.availHeight/2-100)+\'\');return false;"  href="personal.php?row='.$flexInfo[9].'" title="Not Working?  Click here!" target="_blank"><img src="http://wosc.edu/img/icons/books.png" width="16" border="0" style="padding:0 4px 0 3px;" alt="notes" title="Notes for this days workout!"></a>
<a onmouseover="return overlib(\''.$flexInfo[7].'\');" onmouseout="return nd();" href="personal.php?row='.$flexInfo[9].'">
NOTES
</a>
</span></td>';
/*        echo '<span style="float: right;"><a onmouseover="return overlib(\''.$flexInfo[7].'\');" onmouseout="return nd();" href="javascript:void()"><img src="http://wosc.edu/img/icons/books.png" width="16" border="0" style="padding:0 4px 0 3px;" alt="notes" title="Notes for this days workout!">NOTES</a></span></td>'; */
 }
	echo '</tr>';

        //Straight data
        //      echo "$flexInfo[0], $flexInfo[1], $flexInfo[3], $flexInfo[4], $flexInfo[5], $flexInfo[6]<br>";
}



echo '</tr>';
echo '</tbody></table></div>';
echo '</div>';
echo '</body></html>';

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
