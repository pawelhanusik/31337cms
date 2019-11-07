<?php
include("header.php");
include("menu.php");

$articles = [];
$filter = "all"; ///filter can be: all, homepage, internal

if( isset($_REQUEST['f']) && !empty($_REQUEST['f']) ){
	$filter = $_REQUEST['f'];
}

$articles = getArticles($filter);

if( isset($_GET['action']) && !empty($_GET['action']) ){

	if($_GET['action'] === 'delete'){
		if( isset($_REQUEST['id']) ){			
			//ask if user really wants to delete it
			if( !isset($_REQUEST['sure']) || $_REQUEST['sure'] < 1){
				?>
				<div id="content" class="box">
					<h3>Do you really want to delete this article?</h3>
					<h3>Article name: <?php echo $articles[$_GET['id']]['name'] ?></h3>
					<h4>Article type: <?php echo $articles[$_GET['id']]['type'] ?></h4>
					<h4>Path to article file: <?php echo $articles[$_GET['id']]['mainSitePath'] ?></h4>
					<button onclick="document.location = 'siteArticles.php?f=<?php echo $filter; ?>'">No</button>
					<button onclick="document.location = 'siteArticles.php?f=<?php echo $filter; ?>&amp;action=delete&id=<?php echo $_REQUEST['id']; ?>&sure=1'">Yes</button>
				</div>
				<?php
				include("footer.php");
				die();
			}
			//==================================
			
			if( !rename( $articles[$_GET['id']]['path'], 'trash/articles/' . $articles[$_GET['id']]['type'] . '/' . $articles[$_GET['id']]['filename'] . '.' . time() ) ){
				if( !mkdir( 'trash/articles/' . $articles[$_GET['id']]['type'] . '/', 0666, true) ){
					header("Location: error.php?m=siteArticles3");
					die();
				}
				if( !rename( $articles[$_GET['id']]['path'], 'trash/articles/' . $articles[$_GET['id']]['type'] . '/' . $articles[$_GET['id']]['filename'] . '.' . time() ) ){
					header("Location: error.php?m=siteArticles2");
					die();
				}
			}
			
			header("Location: siteArticles.php?f=" . $filter);
			die();
		}else{
			header("Location: error.php?m=siteArticles1");
			die();
		}
	}else if($_GET['action'] === 'add'){
		header("Location: changeArticle.php?f=" . $filter);
		die();
	}else if($_GET['action'] === 'edit'){
		if( isset($_POST['submit']) ){
			include("genFromTemplate.php");
			
			$articleType = "internal";
			$name = time();
			$sort = "z";
			$code = "";
			
			if( !empty($_POST['articleType']) ){
				$articleType = $_POST['articleType'];
				if($articleType !== "homepage" && $articleType !== "internal"){
					$articleType = "internal";
				}
			}
			if( !empty($_POST['name']) ){
				$name = $_POST['name'];
				$name = str_replace(" ", "_", $name);
			}
			if( isset($_POST['sort']) && $_POST['sort'] != '' ){
				$sort = $_POST['sort'];
			}
			if( !empty($_POST['editor']) ){
				$code = $_POST['editor'];
			}
			
			$data = [
				'articleName' => $name,
				'articleContent' => $code
			];
			genFromTemplatePaths("templates/article.php", "../articles/" . $articleType . '/' . $sort . "." . $name . '.php', $data);
			header("Location: siteArticles.php?f=" . $filter);
			die();
		}else{
			if( isset($_GET['id']) ){
				header("Location: changeArticle.php?f=" . $filter . "&path=" . $articles[$_GET['id']]['path']);
				die();
			}else{
				header("Location: changeArticle.php?f=" . $filter);
				die();
			}
		}
	}else if($_GET['action'] === 'changeSort'){
		if( isset($_GET['srcID']) && isset($_GET['dstID']) ){
			if( $_GET['srcID'] < 0 || $_GET['srcID'] >= count($articles)
				|| $_GET['dstID'] < 0 || $_GET['dstID'] >= count($articles)
				|| $articles[$_GET['srcID']]['type'] !== $articles[$_GET['dstID']]['type']
			){
				header("Location: error.php?m=siteArticles7");
				die();
			}
			///CHECK SORT
			//ensures that 2 articles doesn't have the same sort value if so - generate new sort values
			{
				$sortVals = [];
				$regenerate = false;
				foreach($articles as $a){
					if(isset($sortVals[$a['sort']])){
						$sortVals[$a['sort']]++;
					}else{
						$sortVals[$a['sort']] = 1;
					}
					if(strlen($a['sort']) === 0){
						$regenerate = true;
						break;
					}
				}
				if(!$regenerate){
					foreach($sortVals as $sv){
						if($sv > 1){
							$regenerate = true;
							break;
						}
					}
				}
				
				if($regenerate){
					$sortValLen = ceil(log(count($articles), 36));
					$sortVal = "";
					for($j = 0; $j < $sortValLen; ++$j){
						$sortVal .= '0';
					}
					foreach($articles as $a){
						rename( $a['path'], $a['dir'] . $sortVal . "." . $a['name'] . "." . $a['extension'] );
						
						$sortVal[strlen($sortVal)-1] = chr(ord($sortVal[strlen($sortVal)-1])+1);
						if($sortVal[strlen($sortVal)-1] > '9' && $sortVal[strlen($sortVal)-1] < 'a'){
							$sortVal[strlen($sortVal)-1] = 'a';
						}else if($sortVal[strlen($sortVal)-1] > 'z'){
							$sortVal[strlen($sortVal)-1] = '0';
							$i = strlen($sortVal)-2;
							for(; $i >= 0; --$i){
								if($sortVal[$i] == '9'){
									$sortVal[$i] = 'a';
									break;
								}else if($sortVal[$i] < 'z'){
									$sortVal[$i] = chr(ord($sortVal[$i])+1);
									break;
								}else{
									$sortVal[$i] = '0';
								}
							}
							if($i < 0){
								$sortValLen = strlen($sortVal);
								$sortVal = "";
								for($j = 0; $j < $sortValLen; ++$j){
									$sortVal .= 'z';
								}
								$sortVal .= "0";
							}
						}
					}
				}
			}
			$articles = getArticles($filter);
			//CHECK SORT END
			
			
			if( rename( $articles[$_GET['srcID']]['path'], $articles[$_GET['srcID']]['dir'] . $articles[$_GET['dstID']]['sort'] . "." . $articles[$_GET['srcID']]['name'] . "." . $articles[$_GET['srcID']]['extension'] ) === false){
				header("Location: error.php?m=siteArticles6");
				die();
			}
			if( rename( $articles[$_GET['dstID']]['path'], $articles[$_GET['dstID']]['dir'] . $articles[$_GET['srcID']]['sort'] . "." . $articles[$_GET['dstID']]['name'] . "." . $articles[$_GET['dstID']]['extension'] ) === false){
				header("Location: error.php?m=siteArticles5");
				die();
			}
			
			header("Location: siteArticles.php?f=" . $filter);
			die();
		}else{
			header("Location: error.php?m=siteArticles4");
			die();
		}
	}else{
		header("Location: error.php?m=siteArticles0");
		die();
	}
	
}else{
?>

<div id="content" class="box">
	<div class="invisibleBox2">
		<h2>Articles</h2>
		<div>
			Show:
			<select name="menuType">
				<option value="scrollInto" onclick="window.location = 'siteArticles.php?f=all'" <?php echo ($filter === "all")?'selected':''; ?>>All</option>
				<option value="link"       onclick="window.location = 'siteArticles.php?f=homepage'" <?php echo ($filter === "homepage")?'selected':''; ?>>Homepage</option>
				<option value="external"   onclick="window.location = 'siteArticles.php?f=internal'" <?php echo ($filter === "internal")?'selected':''; ?>>Internal</option>
			</select>
		</div>
	</div>
	<div>
		<div class="box3">
			
			<div class="left">
				<table>
					<tr>
						<th class="colFitContents"></th>
						<th class="colFitContents"></th>
						<th>Name</th>
						<th>Type</th>
						<th class="colFitContents">Edit</th>
						<th class="colFitContents">Delete</th>
					</tr>
					<?php
					for($id = 0; $id < count($articles); ++$id){
						$a = $articles[$id];
					?>
					<tr>
						<td><button <?php echo ($a['id'] === 0 || $a['type'] !== $articles[$id-1]['type'])?'style="visibility: hidden;"':'' ?> onclick="document.location = 'siteArticles.php?f=<?php echo $filter; ?>&amp;action=changeSort&amp;srcID=<?php echo $a['id']; ?>&amp;dstID=<?php echo $a['id']-1; ?>'">&#708;</button></td>
						<td><button <?php echo ($a['id'] === count($articles)-1 || $a['type'] !== $articles[$id+1]['type'])?'style="visibility: hidden;"':'' ?> onclick="document.location = 'siteArticles.php?f=<?php echo $filter; ?>&amp;action=changeSort&amp;srcID=<?php echo $a['id']; ?>&amp;dstID=<?php echo $a['id']+1; ?>'">&#709;</button></td>
						<td><?php echo $a['name']; ?></td>
						<td><?php echo $a['type']; ?></td>
						<td><button onclick="document.location = 'siteArticles.php?f=<?php echo $filter; ?>&amp;action=edit&amp;id=<?php echo $a['id']; ?>'">&#9998;</button></td>
						<td><button onclick="document.location = 'siteArticles.php?f=<?php echo $filter; ?>&amp;action=delete&amp;id=<?php echo $a['id']; ?>'">&#128465;</button></td>
					</tr>
					<?php
					}
					?>
				</table>
			</div>
		</div>
		
	</div>
	
	<div class="invisibleBox2">
		<input type="button" value="Add new article" onclick="document.location = 'siteArticles.php?f=<?php echo $filter; ?>&amp;action=add'">
	</div>
	
</div>

<?php
}
include("footer.php");
?>