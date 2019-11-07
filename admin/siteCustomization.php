<?php
include("header.php");
include("menu.php");

$vars_raw = file_get_contents("../css/_vars.css");
$vars = explode("\n", $vars_raw);
foreach($vars as $v){
	if(strpos($v, "--color") !== false){
		$colonPos = strrpos($v, ":");
		$prop = substr($v, 0, $colonPos);
		$val = substr($v, $colonPos+1);
		
		$startPos = strpos($val, "#");
		if($startPos < 2){
			$endPos = strpos($val, ";");
			$val = substr($val, $startPos, $endPos - $startPos);
			$val = strtoupper($val);
		}
	}
}


if( !empty($_POST['submit']) ){
	include("genFromTemplate.php");
	//header
	if( isset($_POST['headerTitle']) && isset($_POST['headerDescription']) && isset($_POST['headerAuthor']) && isset($_POST['faviconPath']) && isset($_POST['footerContents']) && isset($_POST['headerType']) ){
		
		$headerImgPath = (isset($_POST['headerImgPath'])) ? $_POST['headerImgPath'] : '';
		$headerImgs = "";
		if($_POST['headerType'] === "single"){
			$headerImgs = "<img src=\"" . $headerImgPath . "\">";
		}else if($_POST['headerType'] === "slides"){
			$dirPath = $headerImgPath;
			$dirPath = substr($dirPath, 0, strrpos($dirPath, "/"));
			$className = "";
			foreach (glob("../" . $dirPath . "/*") as $filename) {
				$filename = substr($filename, 3);
				$headerImgs .= "<img class=\"$className\" src=\"$filename\">\n";
				$className = "hidden";
			}
		}
		
		$data = [
			'title' => $_POST['headerTitle'],
			'description' => $_POST['headerDescription'],
			'author' => $_POST['headerAuthor'],
			'faviconPath' => $_POST['faviconPath'],
			'headerType' => $_POST['headerType'],
			//'imgPath' => ($_POST['headerType'] !== "none")?$_POST['headerImgPath']:'',
			'headerImgs' => $headerImgs,
			'bodyArgs' => (!empty($_POST['1337enabled']) && $_POST['1337enabled'] === "on")?'class="1337"':'',
			'footerContents' => $_POST['footerContents'],
			'headerStatistics' => (!empty($_POST['headerStatistics']) && $_POST['headerStatistics'] === "on")?'true':'false',
		];
		genFromTemplate("header.php", $data);
		genFromTemplate("footer.php", $data);
	}else{
		header("Location: error.php?m=siteCustomization0");
		die();
	}
	
	//colors
	$varsCss = "";
	foreach($_POST as $key => $val){
		if(strpos($key, "--color") !== false){
			$varsCss .= $key . ": " . $val . ";" . PHP_EOL;
		}
	}
	$data = [
		'vars' => $varsCss
	];
	genFromTemplate("css/_vars.css", $data);
}


$headerTitle = "";
$headerDescription = "";
$headerAuthor = "";
$headerType = "";
$footerContents = "";
$headerImgPath = "";
$body1337 = "";

$header_raw_h = file_get_contents("../header.php");
$footer_raw_f = file_get_contents("../footer.php");

$posStart = strpos($header_raw_h, "<title>") + 7;
$posEnd = strpos($header_raw_h, "</title>");
$headerTitle = substr($header_raw_h, $posStart, $posEnd - $posStart);

$posStart = strpos($header_raw_h, "description") + 1;
$posStart = strpos($header_raw_h, "content=", $posStart) + 9;
$posEnd = strpos($header_raw_h, "/>", $posStart) - 1;
$headerDescription = substr($header_raw_h, $posStart, $posEnd - $posStart);

$posStart = strpos($header_raw_h, "author") + 1;
$posStart = strpos($header_raw_h, "content=", $posStart) + 9;
$posEnd = strpos($header_raw_h, "/>", $posStart) - 1;
$headerAuthor = substr($header_raw_h, $posStart, $posEnd - $posStart);

$posStart = strpos($header_raw_h, "<div id=\"header\"") + 1;
$posStart = strpos($header_raw_h, "class=\"", $posStart) + 7;
$posEnd = strpos($header_raw_h, "\"", $posStart);
$headerType = substr($header_raw_h, $posStart, $posEnd - $posStart);
$posStart = strrpos($headerType, " ")+1;
$headerType = substr($headerType, $posStart);

$posStart = strpos($header_raw_h, "<div id=\"header\"") + 1;
$posStart = strpos($header_raw_h, "<img ", $posStart);
$posStart = strpos($header_raw_h, "src=\"", $posStart);
if($posStart !== false){
	$posStart += 5;
	$posEnd = strpos($header_raw_h, "\">", $posStart);
	$headerImgPath = substr($header_raw_h, $posStart, $posEnd - $posStart);
}else{
	$headerImgPath = "";
}

$posStart = strpos($header_raw_h, "shortcut icon") + 1;
$posStart = strpos($header_raw_h, "href=\"", $posStart) + 6;
$posEnd = strpos($header_raw_h, "\"", $posStart);
$faviconPath = substr($header_raw_h, $posStart, $posEnd - $posStart);

$posStart = strpos($header_raw_h, "turnOnStatistics = ") + 19;
$posEnd = strpos($header_raw_h, ";", $posStart);
$headerStatistics = (strpos(substr($header_raw_h, $posStart, $posEnd - $posStart), "true") !== False) ? 'checked' : '';

$posStart = strpos($footer_raw_f, "<a href=") + 1;
$posStart = strpos($footer_raw_f, ">", $posStart) + 1;
$posEnd = strpos($footer_raw_f, "</a>", $posStart) ;
$footerContents = substr($footer_raw_f, $posStart, $posEnd - $posStart);

$posStart = strpos($header_raw_h, "<body") + 1;
$posEnd = strpos($header_raw_h, ">", $posStart);
$body1337 = (strpos(substr($header_raw_h, $posStart, $posEnd - $posStart), "1337") !== False) ? 'checked' : '';

?>

<div id="content" class="box">
	<form action="siteCustomization.php" method="post">
		<div class="box3">
			<input name="submit" type="submit" value="Save">
		</div>
		<div class="box3">
			<h2>General</h2>
			<table>
				<tr>
					<th>Property</th>
					<th>Value</th>
				</tr>
				<tr>
					<td>Title:</td>
					<td>
						<input type="text" name="headerTitle" value="<?php echo $headerTitle; ?>">
					</td>
				</tr>
				<tr>
					<td>Author:</td>
					<td>
						<input type="text" name="headerAuthor" value="<?php echo $headerAuthor; ?>">
					</td>
				</tr>
				<tr>
					<td>Description:</td>
					<td>
						<input type="text" name="headerDescription" value="<?php echo $headerDescription; ?>">
					</td>
				</tr>
				
				<tr>
					<td>Header image type:</td>
					<td>
						<select name="headerType" class="fullWidth">
							<option value="single" onclick="visibilityShowNth(0);" <?php echo ($headerType === "single")?'selected':''; ?>>Single image</option>
							<option value="slides" onclick="visibilityShowNth(1);" <?php echo ($headerType === "slides")?'selected':''; ?>>Slide show</option>
							<option value="none"   onclick="visibilityShowNth(2);" <?php echo ($headerType === "none")?'selected':''; ?>>None</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<div class="visibilityNth" <?php if($headerType !== "single") echo 'style="display: none;"'; ?> >Image path:</div>
						<div class="visibilityNth" <?php if($headerType !== "slides") echo 'style="display: none;"'; ?> >First image path:</div>
						<div class="visibilityNth" <?php if($headerType !== "none")   echo 'style="display: none;"'; ?> >-</div>
					</td>
					<td>
						<input type="text" name="headerImgPath" value="<?php echo $headerImgPath; ?>">
					</td>
				</tr>
				
				<tr>
					<td>Site icon path:</td>
					<td>
						<input type="text" name="faviconPath" value="<?php echo $faviconPath; ?>">
					</td>
				</tr>
				
				<tr>
					<td>Enable statistics:</td>
					<td>
						<input type="checkbox" class="fullWidth" name="headerStatistics" <?php echo $headerStatistics; ?>>
					</td>
				</tr>
				<tr>
					<td>Footer text:</td>
					<td>
						<input type="text" name="footerContents" value="<?php echo $footerContents; ?>">
					</td>
				</tr>
			</table>
		</div>
		<div class="box3">
			<h2>Colors</h2>
			<table>
				<tr>
					<th>Property</th>
					<th>Value</th>
				</tr>
				<?php
				$vars_raw = file_get_contents("../css/_vars.css");
				$vars = explode("\n", $vars_raw);
				foreach($vars as $v){
					if(strpos($v, "--color") !== false){
						$colonPos = strrpos($v, ":");
						$prop = substr($v, 0, $colonPos);
						$val = substr($v, $colonPos+1);
						
						$startPos = strpos($val, "#");
						if($startPos === False){
							$startPos = strpos($val, "rgb");
						}
						if($startPos < 2){
							$endPos = strpos($val, ";");
							$val = substr($val, $startPos, $endPos - $startPos);
						}
				?>
				<tr>
					<td><?php echo $prop; ?></td>
					<td>
						<input type="text" class="colorpicker" name="<?php echo $prop; ?>" value="<?php echo $val; ?>">
					</td>
				</tr>
				<?php
					}
				}
				?>
			</table>
		</div>
		<div class="box3">
			<h2>31337</h2>
			<table>
				<tr>
					<th>Property</th>
					<th>Value</th>
				</tr>
				<tr>
					<td>Convert text into 1337</td>
					<td>
						<input type="checkbox" class="fullWidth" name="1337enabled" <?php echo $body1337; ?>>
					</td>
				</tr>		
			</table>
		</div>
		<div class="box3">
			<input name="submit" type="submit" value="Save">
		</div>
	</form>
</div>

<?php
include("footer.php");
?>