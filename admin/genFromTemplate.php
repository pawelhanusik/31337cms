<?php
function genFromTemplate($templateName, $data){
	genFromTemplatePaths('templates/' . $templateName, '../' . $templateName, $data);
}
function genFromTemplatePaths($templatePath, $newPath, $data){
	$template = file_get_contents($templatePath);
	
	foreach($data as $key => $value){
		$template = str_replace('<!--' . strtoupper($key) . '-->', $value, $template);
	}
	
	file_put_contents($newPath, $template);
}

function genString($str, $data){
	foreach($data as $key => $value){
		$str = str_replace('<!--' . strtoupper($key) . '-->', $value, $str);
	}
	return $str;
}
?>