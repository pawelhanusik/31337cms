<?php

$turnOnStatistics = <!--HEADERSTATISTICS-->;
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
	<title><!--TITLE--></title>
	<meta name="description" content="<!--DESCRIPTION-->"/>
	<meta name="author" content="<!--AUTHOR-->"/>
	<link rel="shortcut icon" href="<!--FAVICONPATH-->" >
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
<body <!--BODYARGS-->>

<div id="header" class="arrivalable box <!--HEADERTYPE-->">
	<div class="static" >
		<a href="."><!--HEADERIMGS--></a>
	</div>
	<div class="fade" ></div>
</div>
