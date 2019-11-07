<?php
function getArticles($filter){
	$articles = [];
	
	$articlesPaths = [];
	if($filter !== "internal"){
		$articlesPaths = array_merge($articlesPaths, glob("../articles/homepage/*"));
		$articlesPaths = array_merge($articlesPaths, glob("../articles/homepage/.??*"));
	}
	if($filter !== "homepage"){
		$articlesPaths = array_merge($articlesPaths, glob("../articles/internal/*"));
		$articlesPaths = array_merge($articlesPaths, glob("../articles/internal/.??*"));
	}
	foreach ($articlesPaths as $path) {
		$dir = substr($path, 0, strrpos($path, "/")+1);
		$filename = substr($path, strlen($dir));
		
		$tmpPos1 = strpos($dir, "/") + 1;
		$tmpPos1 = strpos($dir, "/", $tmpPos1) + 1;
		$tmpPos2 = strpos($dir, "/", $tmpPos1 );
		$type = substr($dir, $tmpPos1, $tmpPos2 - $tmpPos1 );
		
		$sort = "";
		$name = "";
		$extension = "";
		$startPos = strpos($filename, ".");
		$endPos = strrpos($filename, ".");
		if($startPos === False || $endPos === False){
			$name = $filename;
		}else if($endPos === $startPos){
			$name = substr($filename, 0, $startPos);
			$extension = substr($filename, $startPos+1);
		}else{
			$sort = substr($filename, 0, $startPos);
			$name = substr($filename, $startPos +1, $endPos - $startPos-1);
			$extension = substr($filename, $endPos+1);
		}
		
		$mainSitePath = substr($path, strpos($path, "/")+1);
		
		$articles[] = Array(
			'id' => count($articles),
			'sort' => $sort,
			'name' => $name,
			'extension' => $extension,
			'type' => $type,
			'dir' => $dir,
			'filename' => $filename,
			'path' => $path,
			'mainSitePath' => $mainSitePath
		);
	}
	
	return $articles;
}
?>