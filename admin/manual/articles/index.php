<?php
$type = "";
$name = "";
if( !empty($_REQUEST['name']) ){
	$name = $_REQUEST['name'];
}else if( !empty($_REQUEST['site']) ){
	$name = $_REQUEST['site'];
}

if( !empty($_REQUEST['type']) ){
	$type = $_REQUEST['type'];
}

foreach (glob("$type/*$name.*") as $filename) {
	header("Location: $filename");
	die();
}	
?>