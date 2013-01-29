<?php


$url = 'http://docs.google.com/spreadsheet/pub?key=0AtCs8oPrTSk_dFE0Wjg3d2FUTDFPYUJvdDhVZGRJNXc&single=true&gid=0&output=csv';

$fp = fopen($url,'r');

$allGood = false;
if($fp){
	$flexFile = fopen('flex.csv','w');
	$allGood = true;
	}

if($flexFile){

	while(!feof($fp)){
		$line = fgets($fp);
//		echo "$line<br>";
		fwrite($flexFile,$line);
	}

	fclose($fp);
	fclose($flexFile);
}
else {
	echo "Could not open files.";
}

echo 'You just updated the Flex data!  Woot for you!!!';
?>

