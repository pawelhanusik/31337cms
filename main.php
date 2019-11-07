<?php
foreach (glob("articles/homepage/*") as $filename) {
	
	include($filename);
}	
?>