<?php
if( isset($_POST['submit']) ){
	header("Location: error.php?m=addMenuEntry0");
	die();
}


include("header.php");
include("menu.php");

$name = "";
$path = "";
$menuType = "scrollInto";

if( isset($_REQUEST['id']) ){
	$id = $_REQUEST['id'];
}
if( !empty($_REQUEST['name']) ){
	$name = $_REQUEST['name'];
}
if( !empty($_REQUEST['path']) ){
	$path = $_REQUEST['path'];
}
if( !empty($_REQUEST['menuType']) ){
	$menuType = $_REQUEST['menuType'];
}
?>

<div id="content" class="box">
	<div class="box3">
		<form action="siteMenu.php?action=edit" method="post">
			<h2><?php echo (isset($id))?'Edit menu entry':'Add new menu entry'; ?></h2>
			<?php if(isset($id)) echo '<input type="hidden" name="id" value="' . $id . '">'; ?>
			<div <?php if(!empty($menuType) && $menuType === "manual") echo 'style="display: none;"'; ?> class="visibilityDependantRev">
				<div><input name="name" type="text" placeholder="Name" value="<?php echo htmlspecialchars($name); ?>"></div>
				<!--======================================================-->
				<div <?php if($menuType !== "scrollInto") echo 'style="display: none;"'; ?> class="visibilityNth">
					<select class="fullWidth" name="path[scrollInto]">
						<option value="" selected>Select an article (type: scroll into)</option>
						<?php
						$articles_homepage = getArticles("homepage");
						foreach($articles_homepage as $a){
							echo '<option value="' . $a['name'] . '" ' . (($path === $a['name'])?'selected':'') . '>' . $a['name'] . '</option>';
						}
						?>
					</select>
				</div>
				<div <?php if($menuType !== "link") echo 'style="display: none;"'; ?> class="visibilityNth">
					<select class="fullWidth" name="path[link]">
						<option value="" selected>Select an article (type: normal link)</option>
						<?php
						$articles_internal = getArticles("internal");
						foreach($articles_internal as $a){
							echo '<option value="' . $a['name'] . '" ' . (($path === $a['name'])?'selected':'') . '>' . $a['name'] . '</option>';
						}
						?>
					</select>
				</div>
				<div <?php if($menuType !== "external") echo 'style="display: none;"'; ?> class="visibilityNth"><input name="path[external]" type="text" placeholder="Document path" value="<?php echo htmlspecialchars($path); ?>"></div>
				<div <?php if($menuType !== "homepage") echo 'style="display: none;"'; ?> class="visibilityNth"></div>
				<!--======================================================-->
			</div>
			<div>
			<p>Link type:</p>
				<select name="menuType">
					<option value="scrollInto" onclick="visibilityDependantElementUpdate(false); visibilityShowNth(0);" <?php echo ($menuType === "scrollInto")?'selected':''; ?>>Scroll into</option>
					<option value="link"       onclick="visibilityDependantElementUpdate(false); visibilityShowNth(1);" <?php echo ($menuType === "link")?'selected':''; ?>>Normal link</option>
					<option value="external"   onclick="visibilityDependantElementUpdate(false); visibilityShowNth(2);" <?php echo ($menuType === "external")?'selected':''; ?>>External link</option>
					<option value="homepage"   onclick="visibilityDependantElementUpdate(false); visibilityShowNth(3);" <?php echo ($menuType === "homepage")?'selected':''; ?>>Homepage</option>
					<option value="manual"     onclick="visibilityDependantElementUpdate(true);"  <?php echo ($menuType === "manual")?'selected':''; ?>>Manual</option>
				</select>
			</div>
			<div <?php if($menuType !== "manual") echo 'style="display: none;"'; ?> class="visibilityDependant"><textarea name="manualCode" rows="5" placeholder="HTML/PHP code of the menu entry"><?php echo htmlspecialchars($name); ?></textarea></div>
			<div><p></p><input name="submit" type="submit" value="<?php echo (isset($id))?'Change':'Add'; ?>"></div>
		</form>
	</div>
	<div class="box3">
		<a href="siteMenu.php">Go back</a>
	</div>
</div>

<?php
include("footer.php");
?>