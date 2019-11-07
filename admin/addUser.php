<?php
if( isset($_POST['submit']) ){
	
	if( isset($_POST['new_username']) && isset($_POST['new_passwd']) ){
		include("genFromTemplate.php");
		
		$users_raw = file_get_contents("users.php");
		$startPos = strpos($users_raw, '$users = \'') + 10;
		$endPos = strpos($users_raw, '\';');
		$users_raw = substr($users_raw, $startPos, $endPos - $startPos);
		$users = json_decode($users_raw, true);
		
		foreach($users as $e){
			if($e['username'] === $_POST['new_username']){
				header("Location: error.php?m=addUser1");
				die();
			}
		}
		
		$users[] = Array(
			"username" => $_POST['new_username'],
			"passwdHash" => password_hash($_POST['new_passwd'], PASSWORD_BCRYPT),
			"permissions" => '11111'
		);
		
		$data = [
			'users' => json_encode($users),
		];
		
		genFromTemplatePaths("templates/admin/users.php", "users.php", $data);	
		header("Location: usersSettings.php");
		die();
		
	}else{
		header("Location: error.php?m=addUser0");
		die();
	}
	
}


include("header.php");
include("menu.php");

?>

<div id="content" class="box">
	<div class="box3">
		<form action="addUser.php" method="post">
			<h2>Add new user</h2>
			<div><input name="new_username" type="text" placeholder="Username" required autofocus></div>
			<div><input name="new_passwd" type="password" placeholder="Password" required></div>
			<div><input name="submit" type="submit" value="Add"></div>
		</form>
	</div>
	<div class="box3">
		<a href="usersSettings.php">Go back to users list</a>
	</div>
</div>

<?php
include("footer.php");
?>