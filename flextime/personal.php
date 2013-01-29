<?php

require_once('../config.php');
require_login($course, true, $cm);
global $USER;
$username = $USER->username;

$fp = fopen("flex.csv",'r');

$row = $_GET["row"];

$rowNum = 1;

while(!feof($fp)){
        $line = fgets($fp);
        $flexInfo = explode(',',$line);
	if(($rowNum == $row)&& ($flexInfo[1] == "$USER->username@newmoodle.wosc.edu")){
		printInfo($flexInfo[7]);
	}
	$rowNum++;
}


function printInfo($info){

	echo $info;


}



?>
