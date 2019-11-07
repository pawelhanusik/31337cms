<?php
include("header.php");
include("menu.php");

$path = "";
if( isset($_GET['path']) ){
	$path = $_GET['path'];
}
$path = str_replace("../", "./", $path);


//File upload
if(!empty($_POST['submit'])){
	if(empty($_FILES['fileToUpload'])){
		header("Location: error.php?m=media2");
		die();
	}
	$target_dir = "../media/" . $path;
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	
	if (file_exists($target_file)) {
		header("Location: error.php?m=media1");
		die();
	}
	
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	} else {
		header("Location: error.php?m=media0");
		die();
	}
}

if(!empty($_GET['action'])){
	if($_GET['action'] === "delete"){
		
		if( !isset($_REQUEST['sure']) || $_REQUEST['sure'] < 1){
			?>
			<div id="content" class="box">
				<h3>Do you really want to delete this file?</h3>
				<h3>File path: <?php echo $path; ?></h3>
				<button onclick="document.location = 'media.php?path=<?php echo $path; ?>'">No</button>
				<button onclick="document.location = 'media.php?path=<?php echo $path; ?>&amp;action=delete&amp;sure=1'">Yes</button>
			</div>
			<?php
		}else{
			unlink('../media/' . $path);
			$path = substr($path, 0, strrpos($path, "/")+1);
		}
	}
}
?>

<div id="content" class="box">
	<div class="invisibleBox2">
		<h2>Files:</h2>
	</div>
	<div class="box3">
		<form action="media.php?path=<?php echo $path; ?>" method="post" enctype="multipart/form-data">
			<input type="file" name="fileToUpload" required>
			<input style="width: auto;" type="submit" value="Upload" name="submit">
		</form>
	</div>
	<div id="fileBrowser" class="box3">
		<h4><?php echo 'media/' . $path ?></h4>
<?php
		$dotdotPos = False;
		$found = 0;
		for($pos = strlen($path) - 1; $pos >= 0; $pos--){
			if($path[$pos] === '/'){
				$found++;
				if($found === 2){
					$dotdotPos = $pos;
					break;
				}
			}
		}
		if($dotdotPos !== False){
			echo '<div class="dir"><a href=media.php?path=' . substr($path, 0, $dotdotPos+1) . '>' . '&#11025;' . '</a></div>';
		}else{
			echo '<div class="dir"><a href=media.php?path=>&#11025;</a></div>';
		}
		if(strlen($path) === 0 || $path[strlen($path)-1] === "/")
		{
			foreach (glob("../media/$path*", GLOB_MARK ) as $filename) {
				$filename = substr($filename, strlen('../media/' . $path));
				if($filename[strlen($filename)-1] === "\\"){
					//dir
					echo '<div class="dir"><a href=media.php?path=' . $path . substr($filename, 0, strlen($filename)-1) . '/' . '>' . $filename . '</a></div>';
				}else{
					//file
					echo '<div class="file"><a href=media.php?path=' . $path . $filename . '>' . $filename . '</a></div>';
				}
			}
		}
		else
		{
			echo '<input style="width: auto;" type="button" value="delete" onclick="window.location = \'media.php?path=' . $path . '&action=delete\'">';
			if( strpos(mime_content_type('../media/' . $path), "image") !== False ){
				echo '<div class="box3"><img src=' . '../media/' . $path . '></div>';
			}else{
				$contents = file_get_contents('../media/' . $path);
				echo "<div class='box3'>\n" . str_replace("\n", "\n<br>", htmlspecialchars($contents)) . "\n</div>";
			}
		}
?>
	</div>
</div>

<?php
include("footer.php");
?>