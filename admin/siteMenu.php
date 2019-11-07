<?php
include("header.php");
include("menu.php");

$menuEntries_raw = file_get_contents("../menu.php");
$startPos = strpos($menuEntries_raw, '<div class="center">');
$endPos = strpos($menuEntries_raw, "</div>");
$menuEntries_raw = substr($menuEntries_raw, $startPos, $endPos - $startPos);
$menuEntries = [];

$startPos = 0;
//while( ($startPos = strpos($menuEntries_raw, '<a href', $startPos)) ){
while( ($startPos = min(strpos($menuEntries_raw, "\n", $startPos), strpos($menuEntries_raw, "\r\n", $startPos)) ) ){
	//$endPos = strpos($menuEntries_raw, "</a>", $startPos) + 4;
	$startPos += 1;
	//$endPos = strpos($menuEntries_raw, PHP_EOL, $startPos);
	$endPos = min(strpos($menuEntries_raw, "\n", $startPos), strpos($menuEntries_raw, "\r\n", $startPos));
	
	if($endPos !== false){
		$newEntry = substr($menuEntries_raw, $startPos, $endPos - $startPos);
		if(strlen($newEntry) > 0){
			$menuEntries[] = $newEntry;
		}
	}
};

if( isset($_GET['action']) && !empty($_GET['action']) ){

	if($_GET['action'] === 'delete'){
		if( isset($_REQUEST['id']) ){
			include("genFromTemplate.php");
			
			//ask if user really wants to delete it
			if( !isset($_REQUEST['sure']) || $_REQUEST['sure'] < 1){
				?>
				<div id="content" class="box">
					<h3>Do you really want to delete this menu entry?</h3>
					<h4>Entry: <?php 
						$startPos = strpos($menuEntries[$_REQUEST['id']], ">") + 1;
						$endPos = strpos($menuEntries[$_REQUEST['id']], "</a>");
						echo substr($menuEntries[$_REQUEST['id']], $startPos, $endPos - $startPos);
						?></h4>
					<h4>Source: <?php echo htmlspecialchars($menuEntries[$_REQUEST['id']]); ?></h4>
					<button onclick="document.location = 'siteMenu.php'">No</button>
					<button onclick="document.location = 'siteMenu.php?action=delete&id=<?php echo $_REQUEST['id']; ?>&sure=1'">Yes</button>
				</div>
				<?php
				include("footer.php");
				die();
			}
			//==================================
			
			unset($menuEntries[$_REQUEST['id']]);
			
			$menuEntries_raw = "";
			foreach($menuEntries as $me){
				$menuEntries_raw .= $me . PHP_EOL;
			}
			if($menuEntries_raw[strlen($menuEntries_raw)-1] === "\n"){
				$menuEntries_raw = substr($menuEntries_raw, 0, strlen($menuEntries_raw)-strlen(PHP_EOL));
			}
			
			$data = [
				'menuEntries' => $menuEntries_raw,
			];
			
			genFromTemplate("menu.php", $data);	
			header("Location: siteMenu.php");
			die();
		}else{
			header("Location: error.php?m=siteMenu1");
			die();
		}
	}else if($_GET['action'] === 'add'){
		header("Location: changeMenuEntry.php");
		die();
	}else if($_GET['action'] === 'edit'){
		if( isset($_POST['submit']) ){
			include("genFromTemplate.php");
			
			$id = count($menuEntries);
			$name = "";
			$path = "";
			$menuType = "scrollInto";
			$manualCode = "";
			
			if( isset($_POST['id']) ){
				$id = $_POST['id'];
			}
			if( !empty($_POST['name']) ){
				$name = $_POST['name'];
			}
			if( !empty($_POST['menuType']) ){
				$menuType = $_POST['menuType'];
			}
			if( !empty($_POST['path']) ){
				$path = $_POST['path'][$menuType];
			}
			if( !empty($_POST['manualCode']) ){
				$manualCode = $_POST['manualCode'];
			}
			
			$data = [
				'path' => $path,
				'name' => $name
			];
			$newEntry = "";
			switch($menuType){
				case "manual":
					$newEntry = $manualCode;
					break;
				case "homepage":
					$newEntry = genString('<a href="javascript:homepage();"><!--NAME--></a>', $data);
					break;
				case "external":
					$newEntry = genString('<a href="<!--PATH-->" target="_blank"><!--NAME--></a>', $data);
					break;
				case "link":
					$newEntry = genString('<a href="javascript:changeSite(\'<!--PATH-->\');"><!--NAME--></a>', $data);
					break;
				case "scrollInto":
					$newEntry = genString('<a href="javascript:scrollInto(\'<!--PATH-->\');"><!--NAME--></a>', $data);
					break;
			}
			
			$menuEntries[$id] = $newEntry;
			
			$menuEntries_raw = "";
			foreach($menuEntries as $me){
				$menuEntries_raw .= $me . PHP_EOL;
			}
			if($menuEntries_raw[strlen($menuEntries_raw)-1] === "\n"){
				$menuEntries_raw = substr($menuEntries_raw, 0, strlen($menuEntries_raw)-strlen(PHP_EOL));
			}
			
			
			$data = [
				'menuEntries' => $menuEntries_raw
			];
			
			genFromTemplate("menu.php", $data);	
			header("Location: siteMenu.php");
			die();
		}else{
			if( isset($_GET['id']) ){
				$id = $_GET['id'];
				$name = "";
				$path = "";
				$menuType = "";
				if( isset($_REQUEST['name']) && !empty($_REQUEST['name']) ){
					$name = $_REQUEST['name'];
				}
				if( isset($_REQUEST['path']) && !empty($_REQUEST['path']) ){
					$path = $_REQUEST['path'];
				}
				if( isset($_REQUEST['menuType']) && !empty($_REQUEST['menuType']) ){
					$menuType = $_REQUEST['menuType'];
				}
				header("Location: changeMenuEntry.php?action=edit&id=$id&name=$name&path=$path&menuType=$menuType");
				die();
			}else{
				header("Location: changeMenuEntry.php");
				die();
			}
		}
	}else if($_GET['action'] === 'changeSort'){
		if( isset($_GET['srcID']) && isset($_GET['dstID']) ){
			if( $_GET['srcID'] < 0 || $_GET['srcID'] >= count($menuEntries)
				|| $_GET['dstID'] < 0 || $_GET['dstID'] >= count($menuEntries)
			){
				header("Location: error.php?m=siteMenu3");
				die();
			}
			
			include("genFromTemplate.php");
			
			$tmp = $menuEntries[$_GET['srcID']];
			$menuEntries[$_GET['srcID']] = $menuEntries[$_GET['dstID']];
			$menuEntries[$_GET['dstID']] = $tmp;
			
			$menuEntries_raw = "";
			foreach($menuEntries as $me){
				$menuEntries_raw .= $me . PHP_EOL;
			}
			if($menuEntries_raw[strlen($menuEntries_raw)-1] === "\n"){
				$menuEntries_raw = substr($menuEntries_raw, 0, strlen($menuEntries_raw)-strlen(PHP_EOL));
			}
			
			$data = [
				'menuEntries' => $menuEntries_raw
			];
			
			genFromTemplate("menu.php", $data);	
			header("Location: siteMenu.php");
			die();
		}else{
			header("Location: error.php?m=siteMenu2");
			die();
		}		
	}else{
		header("Location: error.php?m=siteMenu0");
		die();
	}
	
}else{
?>

<div id="content" class="box">
	<div class="invisibleBox2">
		<h2>Menu entries</h2>
	</div>
	<div class="box3">
		<table>
		<tr>
			<th class="colFitContents"></th>
			<th class="colFitContents"></th>
			<th>Name</th>
			<th>Article</th>
			<th class="colFitContents">Type</th>
			<th class="colFitContents">Edit</th>
			<th class="colFitContents">Delete</th>
		</tr>
		<?php
		$meID = -1;
		foreach($menuEntries as $me){
			$meID++;
		?>
			<tr>
					<td><button <?php echo ($meID === 0)?'style="visibility: hidden;"':'' ?> onclick="document.location = 'siteMenu.php?action=changeSort&amp;srcID=<?php echo $meID; ?>&amp;dstID=<?php echo $meID-1; ?>'">&#708;</button></td>
					<td><button <?php echo ($meID === count($menuEntries)-1)?'style="visibility: hidden;"':'' ?> onclick="document.location = 'siteMenu.php?action=changeSort&amp;srcID=<?php echo $meID; ?>&amp;dstID=<?php echo $meID+1; ?>'">&#709;</button></td>
					<?php
						$menuName = "";
						$menuPath = "";
						$menuType = "manual";
						if( strpos($me, "javascript:scrollInto") !== False ){
							$menuType = "scrollInto";
						}else if( strpos($me, "javascript:changeSite") !== False ){
							$menuType = "link";
						}else if( strpos($me, "javascript:homepage();") !== False ){
							$menuType = "homepage";
						}else if( strpos($me, "target=\"_blank\"") !== False ){
							$menuType = "external";
						}
						
						if($menuType === "manual"){
							$menuName = $me;
							echo '<td colspan="2">' . htmlspecialchars($me) . '</td>';
						}else{
							$startPos = strpos($me, ">") + 1;
							$endPos = strpos($me, "</a>");
							$menuName = substr($me, $startPos, $endPos - $startPos);
							
							$startPos = 0;
							$endPos = 0;
							if($menuType === "scrollInto" || $menuType === "link"){
								$startPos = strpos($me, "('") + 2;
								$endPos = strpos($me, "')", $startPos);
							}else if($menuType === "external"){
								$startPos = strpos($me, "href=\"") + 6;
								$endPos = strpos($me, "\"", $startPos);
							}
							$menuPath = substr($me, $startPos, $endPos - $startPos);
							
							echo '<td>' . $menuName . '</td>';
							echo '<td>' . $menuPath . '</td>';
						}
					?>
					<td class="colFitContents">
						<?php
							switch($menuType){
							case "manual":
								echo "Manual";
								break;
							case "scrollInto":
								echo "Scroll into";
								break;
							case "link":
								echo "Normal link";
								break;
							case "homepage":
								echo "Homepage";
								break;
							case "external":
								echo "External link";
								break;
							}
						?>
					</td>
					<td><button onclick="document.location = 'siteMenu.php?action=edit&amp;id=<?php echo urlencode($meID); ?>&amp;name=<?php echo urlencode($menuName); ?>&amp;path=<?php echo urlencode($menuPath); ?>&amp;menuType=<?php echo urlencode($menuType); ?>'">&#9998;</button></td>
					<td><button onclick="document.location = 'siteMenu.php?action=delete&amp;id=<?php echo urlencode($meID); ?>'">&#128465;</button></td>
			</tr>
		<?php
		}
		?>
		</table>
	</div>
	<div class="invisibleBox2">
		<input type="button" value="Add new menu entry" onclick="document.location = 'siteMenu.php?action=add'">
	</div>
</div>

<?php
}
include("footer.php");
?>