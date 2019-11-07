<?php
if( isset($_POST['submit']) ){
	header("Location: error.php?m=changeArticle0");
	die();
}

//save filter value from siteArticles.php and send it back later
if( isset($_REQUEST['f']) && !empty($_REQUEST['f']) ){
	$filter = $_REQUEST['f'];
}

include("header.php");
include("menu.php");

$article = Array(
	'id' => "",
	'sort' => "",
	'name' => "",
	'extension' => "",
	'type' => "",
	'dir' => "",
	'filename' => "",
	'path' => ""
);
if( isset($_GET['path']) ){
	$path = $_GET['path'];
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
	
	$article = Array(
		'id' => "",
		'sort' => $sort,
		'name' => $name,
		'extension' => $extension,
		'type' => $type,
		'dir' => $dir,
		'filename' => $filename,
		'path' => $path
	);
}

?>

<div id="content" class="box">
	<div class="box3">
		<form action="siteArticles.php?action=edit" method="post">
			<h2>Edit an article</h2>
			<?php if(isset($filter)) echo '<input type="hidden" name="f" value="' . $filter . '">'; ?>
			<?php if(isset($article['sort'])) echo '<input type="hidden" name="sort" value="' . $article['sort'] . '">'; ?>
			<div>
				Article type:
				<select name="articleType">
					<option value="homepage" <?php echo ($article['type']==='homepage')?'selected':''; ?>>Homepage</option>
					<option value="internal" <?php echo ($article['type']==='internal')?'selected':''; ?>>Internal</option>
				</select>
			</div>
			<input type="text" name="name" placeholder="Name" value="<?php echo $article['name']; ?>" required>
			Contents:
			<div class="editor"><?php echo $article['path']; ?></div>
			<div><input name="submit" type="submit" value="<?php echo ($article['path']!=="")?'Change':'Add'; ?>"></div>
		</form>
	</div>
	<div class="box3">
		<a href="siteArticles.php">Go back</a>
	</div>
</div>

<?php
include("footer.php");
?>