<?php
	include("header.php");
	include("menu.php");
?>
<div id="content" class="box">
	<h1>Hello, <?php echo $_SESSION['username']; ?>.</h1>
	<a href="manual" target="_blank">User manual</a>
</div>
<?php
	include("footer.php");
?>
