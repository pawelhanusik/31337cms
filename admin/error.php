<?php
include("header.php");
include("menu.php");
?>

<div id="content" class="box">
<?php
$messages = [
	'unknown' => 'An unknown error occured.',
	'siteCustomization0' => 'An error occured. Please make sure that all variables are set correctly.',
	'addUser0' => 'An error occured. Please make sure that all variables are set correctly.',
	'addUser1' => 'User with such a username already exists.',
	'usersSettings0' => 'Invalid action',
	'usersSettings1' => 'Cannot delete the user, becouse username is not specified.',
	'siteMenu0' => 'Invalid action.',
	'siteMenu1' => 'Cannot delete the menu entry, becouse menu entry id is not specified.',
	'siteMenu2' => 'Cannot change menu entries order, becouse IDs of menu entries to change weren\'t provided (both or one of them).',
	'siteMenu3' => 'Cannot change menu entries order. Did you somehow selected first/last menu entry?',
	'addMenuEntry0' => 'Cannot add menu entry. Error code: addMenuEntry0.',
	'siteArticles0' => 'Invalid action.',
	'siteArticles1' => 'Cannot delete an article, becouse an id wasn\'t specified.',
	'siteArticles2' => 'Cannot delete an article. Article doesn\'t exists.',
	'siteArticles3' => 'Permission denied while trying to move an article to trash. Samething went really wrong. Error code: siteArticles3.',
	'siteArticles4' => 'Cannot change articles order, becouse IDs of articles to change weren\'t provided (both or one of them).',
	'siteArticles5' => 'Cannot change articles order. Please try again.',
	'siteArticles6' => 'Cannot change articles order. Please try again.',
	'siteArticles7' => 'Cannot change articles order. Did you somehow selected first/last item of a articles category?',
	'addArticle0' => 'Cannot add menu entry. Error code: addArticle0',
	'changeArticle0' => 'Cannot edit menu entry. Error code: changeArticle0',
	'media0' => 'File is invalid upload file or it cannot be written to specified location.',
	'media1' => 'File already exists.',
	'media2' => 'Please select a file.'
];
$back = [
	'siteCustomization0' => 'siteCustomization.php',
	'addUser0' => 'addUser.php',
	'addUser1' => 'addUser.php',
	'usersSettings0' => 'usersSettings.php',
	'usersSettings1' => 'usersSettings.php',
	'siteMenu0' => 'siteMenu.php',
	'siteMenu1' => 'siteMenu.php',
	'siteMenu2' => 'siteMenu.php',
	'siteMenu3' => 'siteMenu.php',
	'addMenuEntry0' => 'addMenuEntry.php',
	'siteArticles0' => 'siteArticles.php',
	'siteArticles1' => 'siteArticles.php',
	'siteArticles2' => 'siteArticles.php',
	'siteArticles3' => 'siteArticles.php',
	'siteArticles4' => 'siteArticles.php',
	'siteArticles5' => 'siteArticles.php',
	'siteArticles6' => 'siteArticles.php',
	'siteArticles7' => 'siteArticles.php',
	'addArticle0' => 'addArticle.php',
	'changeArticle0' => 'changeArticle.php',
	'media0' => 'media.php',
	'media1' => 'media.php',
	'media2' => 'media.php'
];

if(isset($_REQUEST['m'])){
	
	if( isset($messages[$_REQUEST['m']]) ){
		echo $messages[$_REQUEST['m']];
	}else{
		echo '<div>' . $messages['unknown'] . '</div>';
	}
	if( isset($back[$_REQUEST['m']]) ){
		echo '<div><a href="' . $back[$_REQUEST['m']] . '">Go back</a></div>';
	}
}

?>
</div>

<?php
include("footer.php");
?>