<div id="footer" class="arrivalable box2">
	<a href="." title=""><!--FOOTERCONTENTS--></a>
</div>

<?php
///Scroll into selected in menu subpage
if( isset($_GET['site']) ){
	echo "<script>scrollInto(\"" . $_GET['site'] . "\");</script>";
}
?>

</body>
</html>