<?php
function verifyUser($username, $passwd){
	
	$users = '<!--USERS-->';
	
	$users = json_decode($users, true);

	foreach($users as $e){
		if($e['username'] === $username){
			if(password_verify($passwd, $e['passwdHash'])){
				return $e['permissions'];
			}else{
				return False;
			}
		}
	}
}

?>