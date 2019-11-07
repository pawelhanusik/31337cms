<div id="footer" class="box2">
	<a href=".">31337 cms - administrator panel</a>
</div>

<?php
///Scroll into selected in menu subpage
if( isset($_GET['site']) ){
	echo "<script>scrollInto(\"" . $_GET['site'] . "\");</script>";
}
?>

</body>
</html>