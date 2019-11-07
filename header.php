<?php

$turnOnStatistics = true;
if($turnOnStatistics){
	file_put_contents("stats.log",
		time() . "\t" . $_SERVER['REMOTE_ADDR'] . "\n",
		FILE_APPEND);
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>31337 cms</title>
	<meta name="description" content="Database-less content management system with a feature of converting whole site into cool-looking 1337 site."/>
	<meta name="author" content="Paweł Hanusik"/>
	<link rel="shortcut icon" href="media/favicon.ico" >
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php
	//Add every stylesheet from 'css' dir
	foreach (glob("css/*.css") as $filename) {
		echo "\t<link rel='stylesheet' href='$filename'>\n";
	}
?>
<?php
	///Add every js file (separetly libs and normal scripts in order to load libs first)
	//Add every js lib from 'js_lib' dir
	foreach (glob("js_lib/*.js") as $filename) {
		echo "\t<script type='text/javascript' src='$filename'></script>\n";
	}	
	//Add every js script from 'js' dir
	foreach (glob("js/*.js") as $filename) {
		echo "\t<script type='text/javascript' src='$filename'></script>\n";
	}
?>
</head>
<body >

<div id="header" class="arrivalable box slides">
	<div class="static" >
		<a href="."><img class="" src="media/imgs/header/slide_01.jpg">
<img class="hidden" src="media/imgs/header/slide_02.jpg">
<img class="hidden" src="media/imgs/header/slide_03.jpg">
<img class="hidden" src="media/imgs/header/slide_04.jpg">
</a>
	</div>
	<div class="fade" ></div>
</div>
