<?php
include("header.php");
include("menu.php");

$users_raw = file_get_contents("users.php");
$startPos = strpos($users_raw, '$users = \'') + 10;
$endPos = strpos($users_raw, '\';');
$users_raw = substr($users_raw, $startPos, $endPos - $startPos);
$users = json_decode($users_raw, true);

if( isset($_GET['action']) && !empty($_GET['action']) ){

	if($_GET['action'] === 'delete'){
		if( isset($_REQUEST['username']) ){
			include("genFromTemplate.php");
			
			//ask if user really wants to delete an account
			if( !isset($_REQUEST['sure']) || $_REQUEST['sure'] < 1){
				?>
				<div id="content" class="box">
					<h3>Do you really want to delete an account?</h3>
					<h4>Username: <?php echo $_REQUEST['username']; ?></h4>
					<button onclick="document.location = 'usersSettings.php'">No</button>
					<button onclick="document.location = 'usersSettings.php?action=delete&username=<?php echo $_REQUEST['username']; ?>&sure=1'">Yes</button>
				</div>
				<?php
				include("footer.php");
				die();
			}
			//protection - prompt if user wants to delete last account
			if(count($users) == 1 ) {
				if( !isset($_REQUEST['sure']) || $_REQUEST['sure'] != 2){
					?>
					<div id="content" class="box">
						<h2>Do you really want to delete last account?</h2>
						<h3>If you won't create one just after deleting it, you won't be able to login into administrator panel anymore.</h3>
						<button onclick="document.location = 'usersSettings.php'">No</button>
						<button onclick="document.location = 'usersSettings.php?action=delete&username=<?php echo $_REQUEST['username']; ?>&sure=2'">Yes</button>
					</div>
					<?php
					include("footer.php");
					die();
				}
			}
			//==================================
			
			//foreach($users as $e){
			for($i = 0; $i < count($users); ++$i){
				$e = $users[$i];
				if($e['username'] === $_REQUEST['username']){
					unset($users[$i]);
					break;
				}
			}
			
			$data = [
				'users' => json_encode($users),
			];
			
			genFromTemplatePaths("templates/admin/users.php", "users.php", $data);	
			header("Location: usersSettings.php");
			die();
		}else{
			header("Location: error.php?m=usersSettings1");
			die();
		}
	}else if($_GET['action'] === 'add'){
		header("Location: addUser.php");
		die();
	}else{
		header("Location: error.php?m=usersSettings0");
		die();
	}
	
}else{
?>

<div id="content" class="box">
	<div class="invisibleBox2">
		<h2>Users</h2>
	</div>
	<div class="box3">
		<table>
			<tr>
				<th>Username</th>
				<th class="colFitContents">Delete</th>
			</tr>

<?php
		foreach($users as $e){
?>
			<td><?php echo $e['username']; ?></td>
			<td><button onclick="document.location = 'usersSettings.php?action=delete&username=<?php echo $e['username'] ?>'">&#128465;</button></td>
<?php
		}
?>
				
		</table>
	</div>
	<div class="invisibleBox2">
		<input type="button" value="Add new user" onclick="document.location = 'addUser.php'">
	</div>
</div>

<?php
}
	include("footer.php");
?>