<?php
function verifyUser($username, $passwd){
	
	$users = '[{"username":"admin","passwdHash":"$2y$10$nfHjnLl\/DpIZE1lNjWb1gePs7UBzQ.0hq\/ZaZpgIRlm8VK5vuUzqC","permissions":"11111"}]';
	
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