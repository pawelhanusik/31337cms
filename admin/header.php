<?php
session_start();

include("users.php");
include("functions.php");


if( isset($_POST['username']) && isset($_POST['passwd']) ){
	$permissions = verifyUser($_POST['username'], $_POST['passwd']);
	if( $permissions !== False && strlen($permissions) > 0 ){
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['loggedin'] = True;
		$_SESSION['permissions'] = $permissions;
		header("Location: .");
		die();
	}else{
		echo "<h1>ACCESS DENIED!</h1>";
		die();
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>31337 cms - administrator</title>
	
	<!--Load CodeMirror lib-->
	<link rel="stylesheet" href="js_lib/codemirror-5.48.0/lib/codemirror.css">
	<script src="js_lib/codemirror-5.48.0/lib/codemirror.js"></script>
	<script src="js_lib/codemirror-5.48.0/mode/xml/xml.js"></script>
	<script src="js_lib/codemirror-5.48.0/mode/javascript/javascript.js"></script>
	<script src="js_lib/codemirror-5.48.0/mode/css/css.js"></script>
	<script src="js_lib/codemirror-5.48.0/mode/php/php.js"></script>
	<script src="js_lib/codemirror-5.48.0/mode/htmlmixed/htmlmixed.js"></script>
	<script src="js_lib/codemirror-5.48.0/addon/edit/matchbrackets.js"></script>
	<!---->
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
<body>
<?php
if(
	!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== True
	|| !isset($_SESSION['username'])
){
?>
	<div id="content" class="box">
		<h1>Administrator panel</h1>
		<p>Please log in.</p>
		<form action="index.php" method="post">
			<p><input name="username" type="text" placeholder="Username" required autofocus></p>
			<p><input name="passwd" type="password" placeholder="Password" required></p>
			<p><input name="submit" type="submit" value="Login"></p>
		</form>
	</div>
<?php
	include("footer.php");
	die();
?>
<?php
}
?>




